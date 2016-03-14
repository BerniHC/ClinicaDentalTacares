<?php

class UsersController extends BaseController {
    
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->ability(NULL, "add-users,edit-users,view-users,delete-users"))
            App::abort('403');

        $users = User::withTrashed()->get();
        
        $this->layout->title = 'Usuarios';
        $this->layout->content = View::make('admin.users.list', array (
            'users' => $users
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add()
	{
        if(!Auth::user()->can("add-users"))
            App::abort('403');

        $document_types = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Tipos de Documentos');
        })->lists('description', 'id');
        
        $genders = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Géneros');
        })->get();

        $roles = Role::all()->lists('name', 'id');
        
        $this->layout->title = 'Agregar Usuario';
        $this->layout->content = View::make('admin.users.add', array (
            'document_types' => $document_types, 
            'genders' => $genders, 
            'roles' => $roles
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("add-users"))
            App::abort('403');

        $rules =  array (
            'document_type' => array('required', 'exists:metatype,id'),
            'document_value' => array('required', 'max:30', 'unique:person'),
            'firstname' => array('required', 'max:30'),
            'middlename' => array('max:30'),
            'lastname' => array('max:30'),
            'gender' => array('required', 'exists:metatype,id'),
            'birthdate' => array('required', 'date_format:d/m/Y'),
            'email' => array('required', 'email', 'max:100', 'unique:user'),
            'password' => array('required', 'min:6', 'max:12', 'has:letter,num', 'confirmed'),
            'role' => array('required', 'exists:role,id'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try 
            {
                $person = new Person;
                $person->document_type_id = Input::get('document_type');
                $person->document_value = Input::get('document_value');
                $person->firstname = Input::get('firstname');
                $person->middlename = Input::get('middlename');
                $person->lastname = Input::get('lastname');
                $person->gender_id = Input::get('gender');
                $person->birthdate = DateTime::createFromFormat('d/m/Y', Input::get('birthdate'));

                $user = new User;
                $user->email = Input::get('email');
                $user->password = Hash::make(Input::get('password'));
                $user->confirmation_code = str_random(30);
                $user->require_new_password = Input::has('require_new_password');

                if(!$person->save())
                    throw new Exception('Error al intentar guardar datos personales.');
                    
                if(!$person->user()->save($user))
                    throw new Exception('Error al intentar guardar datos del usuario.');

                if(!$user->roles()->sync(array(Input::get('role'))))
                    throw new Exception('Error al intentar asociar roles del usuario.');

                DB::commit();

                try 
                {
                    //Send Confirmatiom Email
                    $data = array(
                        'username' => $user->person->partialname(),
                        'email' => $user->email,
                        'password' => Input::get('password'),
                        'confirmation_code' => $user->confirmation_code,
                        'confirmation_url' => URL::route('confirm-account', array($user->confirmation_code))
                    );
                    Mail::send('emails.confirmation', $data, function($message) use ($user)
                    {
                        $message->to($user->email, $user->person->fullname())->subject('Confirmación de la cuenta');
                    });
                }
                catch (\Exception $ex) 
                {
                    Session::flash('warning', 'El usuario ha sido creado pero no ha sido posible enviar el correo de confirmación: ' . $user->confirmation_code);
                    return Redirect::action('UsersController@get_view', array('id' => $user->id))->withInput();
                }

                Session::flash('success', 'El usuario ha sido agregado correctamente.');
                return Redirect::action('UsersController@get_view', array('id' => $user->id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar el usuario especificado.');
                return Redirect::action('UsersController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('UsersController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit($id)
	{
        if(!Auth::user()->can("edit-users"))
            App::abort('403');
        
        $user = User::findOrFail($id);
        
        $document_types = Metatype::whereHas('metagroup', function($q){
            $q->where('description', '=', 'Tipos de Documentos');
        })->lists('description', 'id');
        
        $genders = Metatype::whereHas('metagroup', function($q){
            $q->where('description', '=', 'Géneros');
        })->get();

        $roles = Role::all()->lists('name', 'id');

        $this->layout->title = 'Editar Usuario';
        $this->layout->content = View::make('admin.users.edit', array (
            'document_types' => $document_types, 
            'genders' => $genders, 
            'roles' => $roles,
            'user' => $user
        ));
	}
    
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("edit-users"))
            App::abort('403');
        
        $rules = array (
            'document_type' => array('required', 'exists:metatype,id'),
            'document_value' => array('required', 'max:30'),
            'firstname' => array('required', 'max:30'),
            'middlename' => array('max:30'),
            'lastname' => array('max:30'),
            'gender' => array('required', 'exists:metatype,id'),
            'birthdate' => array('required', 'date_format:d/m/Y'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try 
            {
                $user = User::findOrFail($id);
                $user->person->document_type_id = Input::get('document_type');
                $user->person->document_value = Input::get('document_value');
                $user->person->firstname = Input::get('firstname');
                $user->person->middlename = Input::get('middlename');
                $user->person->lastname = Input::get('lastname');
                $user->person->gender_id = Input::get('gender');
                $user->person->birthdate = DateTime::createFromFormat('d/m/Y', Input::get('birthdate'));
                $user->roles()->sync(Input::get('role'));

                if (!$user->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');
                
                DB::commit();

                Session::flash('success', 'El usuario ha sido editado correctamente.');
                return Redirect::action('UsersController@get_view', array($id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                
                Session::flash('error', 'No ha sido posible editar el usuario especificado.');
                return Redirect::action('UsersController@get_edit', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('UsersController@get_edit', array($id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // View Action
    //----------------------------------------------------------

    // GET
	public function get_view($id)
	{
        if(!Auth::user()->can("view-users"))
            App::abort('403');

        $user = User::withTrashed()->findOrFail($id);

        $this->layout->title = $user->person->fullname();
        $this->layout->content = View::make('admin.users.view', array( 
            'user' => $user
        ));
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete($id)
	{
        if(!Auth::user()->can("delete-users"))
            App::abort('403');

        $user = User::findOrFail($id);

        if($user->delete())
            Session::flash('success', 'El paciente ha sido bloqueado correctamente.');
        else
            Session::flash('error', 'No ha sido posible bloqueado el usuario especificado.');

        return Redirect::back();
	}
    
    // GET
	public function get_restore( $id )
	{
        if(!Auth::user()->can("delete-users"))
            App::abort('403');

        $user = User::onlyTrashed()->findOrFail($id);

        if($user->restore())
            Session::flash('success', 'El usuario ha sido restaurado correctamente.');
        else
            Session::flash('error', 'No ha sido posible restaurar el usuario especificado.');

        return Redirect::back();
	}

}