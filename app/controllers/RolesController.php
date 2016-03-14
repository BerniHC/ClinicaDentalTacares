<?php
class RolesController extends BaseController {

    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
    public function get_list() 
    {
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $roles = Role::all();

        $this->layout->title = 'Roles';
        $this->layout->content = View::make('admin.configuration.roles.list', array(
            'roles' => $roles
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

        $this->layout->title = 'Agregar Rol';
        $this->layout->content = View::make('admin.configuration.roles.add');
	}
     
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules =  array(
            'name' => array('required', 'max:30'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            try {
                $role = new Role;
                $role->name = Input::get('name');

                if(!$role->save())
                    throw new Exception('Error al intentar guardar el rol especificado.');

                Session::flash('success', 'El rol ha sido agregado correctamente.');
                return Redirect::action('RolesController@get_list');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible agregar el rol especificado.');
                return Redirect::action('RolesController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('RolesController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
    public function get_edit( $id )
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $role = Role::findOrFail($id);

        $permissions = Permission::all();

        $this->layout->title = 'Editar Rol';
        $this->layout->content = View::make('admin.configuration.roles.edit', array(
            'role' => $role,
            'permissions' => $permissions
        ));
	}
     
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'name' => array('required', 'max:30'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try {
                $role = Role::find($id);
                $role->name = Input::get('name');

                if($role->id != 1)
                if(Input::has('permissions'))
                    $role->perms()->sync(Input::get('permissions'));

                if(!$role->save())
                    throw new Exception('Error al intentar guardar el rol especificado.');

                DB::commit();

                Session::flash('success', 'El rol ha sido modificado correctamente.');
                return Redirect::action('RolesController@get_list');
            }
            catch (\Exception $ex) 
            {
                DB::rollback();

                Session::flash('error', 'No ha sido posible modificar el rol especificado.');
                return Redirect::action('RolesController@get_edit', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('RolesController@get_edit', array($id))->withErrors($validator)->withInput();
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

        $role = Role::findOrFail($id);
        
        if($role->id != 1 && $role->id != 2) {
            if($role->delete())
                Session::flash('success', 'El role ha sido eliminado correctamente.');
            else
                Session::flash('error', 'No ha sido posible eliminar el rol especificado.');
        }
        else {
            Session::flash('warning', 'El role especificado es necesario para el correcto funcionamiento del sistema.');
        }
        return Redirect::action('RolesController@get_list');
	}
    
}