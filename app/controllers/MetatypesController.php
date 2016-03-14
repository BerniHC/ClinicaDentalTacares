<?php
class MetatypesController extends BaseController {
    
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $metatypes = Metatype::orderBy('metagroup_id')->get();
        
        $this->layout->title = 'Metatipos';
        $this->layout->content = View::make('admin.configuration.metatypes.list', array(
            'metatypes' => $metatypes
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $metagroups = Metagroup::lists('description', 'id');

        $this->layout->title = 'Agregar Metatipo';
        $this->layout->content = View::make('admin.configuration.metatypes.add', array(
            'metagroups' => $metagroups,
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'metagroup' => array('required', 'exists:metagroup,id'),
            'description' => array('required', 'max:50'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            $metatype = new Metatype;
            $metatype->description = Input::get('description');
            $metatype->metagroup_id = Input::get('metagroup');

            if ($metatype->save())
            {
                Session::flash('success', 'El metatipo ha sido agregado correctamente.');
                return Redirect::action('MetatypesController@get_list');
            }
            else
            {
                Session::flash('error', 'No ha sido posible agregar el metatipo.');
                return Redirect::action('MetatypesController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('MetatypesController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $metatype = Metatype::findOrFail($id);
        $metagroups = Metagroup::lists('description', 'id');

        $this->layout->title = 'Editar Metatipo';
        $this->layout->content = View::make('admin.configuration.metatypes.edit', array(
            'metatype' => $metatype,
            'metagroups' => $metagroups
        ));
	}
    
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'description' => array('required', 'max:50'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            $metatype = Metatype::findOrFail($id);
            $metatype->description = Input::get('description');

            if ($metatype->save())
            {
                Session::flash('success', 'El metatipo ha sido modificado correctamente.');
                return Redirect::action('MetatypesController@get_list');
            }
            else
            {
                Session::flash('error', 'No ha sido posible modificar el metatipo especificado.');
                return Redirect::action('MetatypesController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('MetatypesController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete( $id )
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $metatype = Metatype::findOrFail($id);

        if($metatype->delete())
            Session::flash('success', 'El metatipo ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el metatipo.');

        return Redirect::action('MetatypesController@get_list');
	}
    
}