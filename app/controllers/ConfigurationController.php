<?php
class ConfigurationController extends BaseController {

    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Website
    //----------------------------------------------------------

    // GET
    public function get_website() 
    {
        // Check permission
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        // Show website configuration view
        $this->layout->title = 'Website';
        $this->layout->content = View::make('admin.configuration.website');
    }
    
    // POST Website
	public function post_website()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'name' => array('required'),
            'admin_name' => array('required'),
            'admin_email' => array('required', 'email')
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                Setting::set('website.name', Input::get('name'));
                Setting::set('website.slogan', Input::get('slogan'));
                Setting::set('website.admin_name', Input::get('admin_name'));
                Setting::set('website.admin_email', Input::get('admin_email'));

                $file = Input::file('front');

                // Obtener metadatos de la imagen
                $ext = $file->getClientOriginalExtension();
                $name = 'front.'.$ext;
                $path = public_path() . "/images";
                
                // Guardar imagen en almacenamieto
                $file->move($path, $name);
                
                Setting::set('website.front', $name);

                Session::flash('success', 'La configuración del sitio web ha cambiado correctamente.');
                return Redirect::action('ConfigurationController@get_website');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible modificar la configuración del sitio web.');
                return Redirect::action('ConfigurationController@get_website')->withInput();
            }
        }
        else
        {
            return Redirect::action('ConfigurationController@get_website')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Agenda
    //----------------------------------------------------------

    // GET
    public function get_agenda() 
    {
        // Check permission
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        // Show agenda configuration view
        $this->layout->title = 'Agenda';
        $this->layout->content = View::make('admin.configuration.agenda');
    }
    
    // POST Agenda
	public function post_agenda()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules =  array(
            'first_day' => array('required'),
            'min_time' => array('required', 'date_format:H:i A'),
            'max_time' => array('required', 'date_format:H:i A'),
            'slot_duration' => array('required'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try 
            {
                Setting::set('agenda.first_day', Input::get('first_day'));
                Setting::set('agenda.min_time', Input::get('min_time'));
                Setting::set('agenda.max_time', Input::get('max_time'));
                Setting::set('agenda.slot_duration', Input::get('slot_duration'));

                Session::flash('success', 'La configuración de la agenda ha cambiado correctamente.');
                return Redirect::action('ConfigurationController@get_agenda');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible modificar la configuración de la agenda.');
                return Redirect::action('ConfigurationController@get_agenda')->withInput();
            }
        }
        else
        {
            return Redirect::action('ConfigurationController@get_agenda')->withErrors($validator)->withInput();
        }
	}
    
}