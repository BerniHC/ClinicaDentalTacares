<?php
class AddressesController extends BaseController
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Other Actions
    //----------------------------------------------------------
    
    // JSON
    public function json_cities()
    {
        $estate_id = Input::get('place');
        return City::where('estate_id', '=', $estate_id)->get(['id','name']);
    }

    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------
    
    // GET
	public function get_add($person_id)
	{
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $estates = Estate::all()->lists('name', 'id');

        $this->layout->title = 'Agregar Dirección';
        $this->layout->content = View::make('admin.addresses.add', array(
            'estates' => $estates
        ));
	}

    // POST
    public function post_add($person_id) 
    {
        if(!Auth::user()->ability(NULL, "edit-patients,edit-users"))
            App::abort('403');

        $rules = array(
            'city' => array('required', 'exists:city,id'),
            'estate' => array('required', 'exists:estate,id'),
            'address' => array('max:200')
        );
        
        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            DB::beginTransaction();
            try 
            {
                $address = new Address;
                $address->estate_id = Input::get('estate');
                $address->city_id = Input::get('city');
                $address->address = Input::get('address');
                $address->person_id = $person_id;

                if(!$address->save())
                {
                    Session::flash('error', 'No ha sido posible agregar la dirección especificada.');
                    return Redirect::action('AddressesController@get_add', array('person_id' => $person_id))->withInput();
                }

                DB::commit();
                
                Session::flash('success', 'La dirección ha sido agregada correctamente.');
                
                if(count($address->person->user)) 
                    return Redirect::action('UsersController@get_view', array('id' => $address->person->user->id));
                elseif (count($address->person->patient))
                    return Redirect::action('PatientsController@get_view', array('id' => $address->person->patient->id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();

                Session::flash('error', 'No ha sido posible agregar la dirección especificada.');
                return Redirect::action('AddressesController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('AddressesController@get_add', array('person_id' => $person_id))->withErrors($validator)->withInput();
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

        $address = Address::findOrFail($id);

        if($address->delete())
            Session::flash('success', 'La dirección ha sido eliminada correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar la dirección especificada.');
        
        if(count($address->person->user)) 
            return Redirect::action('UsersController@get_view', array('id' => $address->person->user->id));
        elseif (count($address->person->patient))
            return Redirect::action('PatientsController@get_view', array('id' => $address->person->patient->id));
    } 
}