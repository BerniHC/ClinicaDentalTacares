<?php
class AccountController extends BaseController {

    protected $layout = 'layouts.admin';

    //----------------------------------------------------------
    // Login Action
    //----------------------------------------------------------
    
    // GET
    public function get_login() 
    {
        $this->layout->title = 'Iniciar Sesión';
        $this->layout->content = View::make('account.login');
    }

    // POST
    public function post_login()
    {
        $rules = array(
            'email' => array('required', 'email'),
            'password' => array('required'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->passes()) 
		    return Redirect::action('AccountController@get_login')->withErrors($validator)->withInput();

        $user = User::where('email', '=', Input::get('email'))->withTrashed()->first();

        if ($user && Hash::check(Input::get('password'), $user->password))
        {
            if(!$user->is_confirmed) {
                Session::flash('warning', 'Esta cuenta no ha sido confirmada.');
                return Redirect::action('AccountController@get_login')->withInput();
            }

            if($user->trashed()) {
                Session::flash('error', 'Esta cuenta ha sido desactivada.');
                return Redirect::action('AccountController@get_login')->withInput();
            }

            if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), Input::get('remeber_me')))
                return Redirect::action('AdminController@dashboard');
            else {
                Session::flash('error', 'Error al intentar autentificar la cuenta.');
                return Redirect::action('AccountController@get_login')->withInput();
            }
        } 
        else 
        {
            Session::flash('error', 'Correo y/o contraseña inválidos.');
            return Redirect::action('AccountController@get_login')->withInput();
        }
    }
    
    //----------------------------------------------------------
    // Confirm Action
    //----------------------------------------------------------
    
    // GET
    public function get_confirm($code)
    {
        $user = User::where('confirmation_code', '=', $code)->first();
        if( $user ) 
        {
            $user->is_confirmed = true;
            $user->save();

            Session::flash('success', 'Cuenta confirmada correctamente.');
            return Redirect::action('AccountController@get_login');
        } 
        else 
        {
            Session::flash('warning', 'Código de verificación inválido.');
            return Redirect::action('AccountController@get_login');
        }
    }

    //----------------------------------------------------------
    // Profile Action
    //----------------------------------------------------------
    
    // GET
    public function get_profile() {
        $user = Auth::user();

        $this->layout->title = 'Mi Cuenta';
        $this->layout->content = View::make('account.profile', array(
            'user' => $user
        ));
    }
    
    //----------------------------------------------------------
    // Forgot Password Action
    //----------------------------------------------------------
    
    // GET
    public function get_forgot_password() 
    {
        $this->layout->title = '¿Has olvidado la contraseña?';
        $this->layout->content = View::make('account.forgot-password');
    }

    // POST
    public function post_forgot_password()
    {
        $rules =  array(
            'email' => array('required', 'email', 'exists:user'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            $user = User::where('email', '=', Input::get('email'))->firstOrFail();

            $resetToken = new ResetToken;
            $resetToken->user_id = $user->id;
            $resetToken->token = str_random(30);

            if ($resetToken->save()) 
            {
                $data = array(
                    'username' => $user->person->partialname(),
                    'token' => $resetToken->token,
                );
                Mail::send('emails.reset-password', $data, function($message) use ($user)
                {
                    $message->to($user->email, $user->person->fullname())->subject('Restablecer contraseña');
                });

                Session::flash('success', 'Se le ha enviado un correo con instrucciones para restablecer su cuenta.');
                return Redirect::action('AccountController@get_forgot_password');
            }
            else
            {
                $error = $resetToken->errors()->all(':message');
                return Redirect::action('AccountController@get_forgot_password')->withInput()->with( 'error', $error );
            }
        } 
        else 
        {
            return Redirect::action('AccountController@get_forgot_password')->withErrors($validator)->withInput();
        }
    }
    
    //----------------------------------------------------------
    // Reset Password Action
    //----------------------------------------------------------
    
    // GET
    public function get_reset_password($token = '')
    {
        $this->layout->title = 'Restablecer Contraseña';
        $this->layout->content = View::make('account.reset-password', array(
            'token' => $token
        ));
    }

    // POST
    public function post_reset_password( $token = '' )
    {
        $rules =  array(
            'token' => array('required', 'exists:reset_tokens'),
            'password' => array('required', 'min:6', 'max:12', 'has:letter,num', 'confirmed'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            $resetToken = ResetToken::where('token', '=', Input::get('token'))->first();
            if(strtotime( '+30 minute' , strtotime($resetToken->updated_at) ) >= time('d/m/Y H:i:s')) {
                $user = User::find($resetToken->user_id);
                $user->password = Hash::make(Input::get('password'));
                $user->save();

                Session::flash('success', 'La contraseña ha sido cambiada correctamente.');
                return Redirect::action('AccountController@get_reset_password');
            } 
            else 
            {
                Session::flash('warning', 'El plazo de caducidad del token ha expirado.');
                return Redirect::action('AccountController@get_reset_password');
            }
        } 
        else 
        {
            return Redirect::action('AccountController@get_reset_password')->withErrors($validator)->withInput();
        }
    }
    
    //----------------------------------------------------------
    // Change Password Action
    //----------------------------------------------------------
    
    // GET
    public function get_change_password() 
    {
        $this->layout->title = 'Cambiar Contraseña';
        $this->layout->content = View::make('account.change-password');
    }

    // POST
    public function post_change_password()
    {
        $rules =  array(
            'old_password' => array('required'),
            'password' => array('required', 'min:6', 'max:12', 'has:letter,num', 'confirmed'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            $user = Auth::user();
            if (Hash::check(Input::get('old_password'), $user->password)) 
            {
                $user->password = Hash::make(Input::get('password'));
                $user->require_new_password = FALSE;
                $user->save();

                Session::flash('success', 'La contraseña ha sido cambiada correctamente.');
                return Redirect::action('AccountController@get_change_password');
            } 
            else 
            {
                Session::flash('error', 'La contraseña anterior es inválida.');
                return Redirect::action('AccountController@get_change_password');
            }
        } 
        else 
        {
            return Redirect::action('AccountController@get_change_password')->withErrors($validator)->withInput();
        }
    }
    
    //----------------------------------------------------------
    // Logout Action
    //----------------------------------------------------------
    
    public function logout()
    {
        Auth::logout();
        return Redirect::action('home');
    }
    
}