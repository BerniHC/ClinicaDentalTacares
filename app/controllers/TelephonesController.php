<?php

class TelephonesController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add($person_id)
	{
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $this->layout->title = 'Agregar Teléfono';
        $this->layout->content = View::make('admin.telephones.add');
	}
    
    // POST
	public function post_add($person_id)
	{
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $rules = array(
            'number' => array('required', 'numeric'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            $telephone = new Telephone;
            $telephone->number = Input::get('number');
            $telephone->person_id = $person_id;

            if ($telephone->save())
            {
                Session::flash('success', 'El teléfono ha sido agregado correctamente.');

                if(count($telephone->person->user)) 
                    return Redirect::action('UsersController@get_view', array('id' => $telephone->person->user->id));
                elseif (count($telephone->person->patient))
                    return Redirect::action('PatientsController@get_view', array('id' => $telephone->person->patient->id));
            }
            else
            {
                Session::flash('error', 'No ha sido posible agregar el teléfono especificado.');
                return Redirect::action('TelephonesController@get_add', array('person_id' => $person_id))->withInput();
            }
        }
        else
        {
            return Redirect::action('TelephonesController@get_add', array('person_id' => $person_id))->withErrors($validator)->withInput();
        }
	}

    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
    public function get_delete($id) 
    {
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $telephone = Telephone::findOrFail($id);

        if($telephone->delete())
            Session::flash('success', 'El teléfono ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el teléfono especificado.');

        if(count($telephone->person->user)) 
            return Redirect::action('UsersController@get_view', array('id' => $telephone->person->user->id));
        elseif (count($telephone->person->patient))
            return Redirect::action('PatientsController@get_view', array('id' => $telephone->person->patient->id));
    } 
}