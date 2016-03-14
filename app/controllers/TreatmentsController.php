<?php
class TreatmentsController extends BaseController {
    
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $categories = Category::all();
        $treatments = Treatment::orderBy('category_id')->get();
        
        $this->layout->title = 'Tratamientos';
        $this->layout->content = View::make('admin.configuration.treatments.list', array(
            'categories' => $categories,
            'treatments' => $treatments
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
        
        $categories = Category::lists('description', 'id');

        $this->layout->title = 'Agregar Tratamiento';
        $this->layout->content = View::make('admin.configuration.treatments.add', array(
            'categories' => $categories
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'category' => array('required', 'exists:category,id'),
            'description' => array('required', 'max:50'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                $treatment = new Treatment;
                $treatment->description = Input::get('description');
                $treatment->category_id = Input::get('category');

                if (!$treatment->save())
                    throw new Exception('Error al intentar guardar el tratamiento especificado.');

                Session::flash('success', 'El tratamiento ha sido agregado correctamente.');
                return Redirect::action('TreatmentsController@get_list');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible agregar el tratamiento especificado.');
                return Redirect::action('TreatmentsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('TreatmentsController@get_add')->withErrors($validator)->withInput();
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

        $treatment = Treatment::findOrFail($id);

        $categories = Category::lists('description', 'id');

        $this->layout->title = 'Editar Tratamiento';
        $this->layout->content = View::make('admin.configuration.treatments.edit', array(
            'treatment' => $treatment,
            'categories' => $categories
        ));
	}
    
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'category' => array('required', 'exists:category,id'),
            'description' => array('required', 'max:50'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            try {
                $treatment = Treatment::findOrFail($id);
                $treatment->description = Input::get('description');
                $treatment->category_id = Input::get('category');

                if (!$treatment->save())
                    throw new Exception('Error al intentar guardar el tratamiento especificado.');

                Session::flash('success', 'El tratamiento ha sido modificado correctamente.');
                return Redirect::action('TreatmentsController@get_list');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible modificar el tratamiento especificado.');
                return Redirect::action('TreatmentsController@get_edit', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('TreatmentsController@get_edit', array($id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $treatment = Treatment::findOrFail($id);

        if($treatment->delete())
            Session::flash('success', 'El tratamiento ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el tratamiento especificado.');

        return Redirect::action('TreatmentsController@get_list');
	}
    
    //----------------------------------------------------------
    // Add Category Action
    //----------------------------------------------------------

    // GET
	public function get_add_category()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $this->layout->title = 'Agregar Categoría';
        $this->layout->content = View::make('admin.configuration.treatments.categories.add');
	}
    
    // POST
	public function post_add_category()
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'description' => array('required', 'max:50'),
            'color' => array('required', 'max:7'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            $category = new Category;
            $category->description = Input::get('description');
            $category->color = strtoupper(Input::get('color'));

            if ($category->save())
            {
                Session::flash('success', 'La categoría ha sido agregada correctamente.');
                return Redirect::action('TreatmentsController@get_list');
            }
            else
            {
                Session::flash('error', 'No ha sido posible agregar la categoría especificada.');
                return Redirect::action('TreatmentsController@get_add_category')->withInput();
            }
        }
        else
        {
            return Redirect::action('TreatmentsController@get_add_category')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Category Action
    //----------------------------------------------------------

    // GET
	public function get_edit_category($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $category = Category::findOrFail($id);

        $this->layout->title = 'Editar Categoría';
        $this->layout->content = View::make('admin.configuration.treatments.categories.edit', array(
            'category' => $category
        ));
	}
    
    // POST
	public function post_edit_category($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $rules = array(
            'description' => array('required', 'max:50'),
            'color' => array('required', 'max:7'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                $category = Category::findOrFail($id);
                $category->description = Input::get('description');
                $category->color = strtoupper(Input::get('color'));

                if (!$category->save())
                    throw new Exception('Error al intentar guardar la categoría especificada.');

                Session::flash('success', 'La categoría ha sido modificado correctamente.');
                return Redirect::action('TreatmentsController@get_list');
            }
            catch (\Exception $ex) 
            {
                Session::flash('error', 'No ha sido posible modificar la categoría especificada.');
                return Redirect::action('TreatmentsController@get_edit_category', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('TreatmentsController@get_edit_category', array($id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Delete Category Action
    //----------------------------------------------------------

    // GET
	public function get_delete_category($id)
	{
        if(!Auth::user()->can("config-system"))
            App::abort('403');

        $category = Category::findOrFail($id);

        if($category->delete())
            Session::flash('success', 'La categoría ha sido eliminada correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar la categoría especificada.');

        return Redirect::action('TreatmentsController@get_list');
	}
    
}