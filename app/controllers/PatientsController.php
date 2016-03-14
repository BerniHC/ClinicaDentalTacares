<?php

class PatientsController extends BaseController {
    
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->ability(NULL, "add-patients,edit-patients,view-patients,delete-patients"))
            App::abort('403');

        $patients = Patient::withTrashed()->get();
        
        $this->layout->title = 'Pacientes';
        $this->layout->content = View::make('admin.patients.list', array(
            'patients' => $patients
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add()
	{
        if(!Auth::user()->can("add-patients"))
            App::abort('403');
           
        $patient_types = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Tipos de Pacientes');
        })->lists('description', 'id');
         
        $document_types = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Tipos de Documentos');
        })->lists('description', 'id');
        
        $genders = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Géneros');
        })->get();

        $this->layout->title = 'Agregar Paciente';
        $this->layout->content = View::make('admin.patients.add', array(
            'document_types' => $document_types, 
            'patient_types' => $patient_types, 
            'genders' => $genders, 
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("add-patients"))
            App::abort('403');

        $rules = array (
            'document_type' => array('required', 'exists:metatype,id'),
            'document_value' => array('required', 'max:30', 'unique:person'),
            'firstname' => array('required', 'max:30'),
            'middlename' => array('max:30'),
            'lastname' => array('max:30'),
            'gender' => array('required', 'exists:metatype,id'),
            'birthdate' => array('required', 'date_format:d/m/Y'),
            'email' => array('email', 'max:100', 'unique:user'),
            'telephone' => array('numeric'),
            'patient_type' => array('required', 'exists:metatype,id'),
            'observations' => array('max:1000')
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

                $patient = new Patient;
                $patient->email = Input::get('email');
                $patient->type_id = Input::get('patient_type');
                $patient->observation = Input::get('observation');

                if(!$person->save() || !$person->patient()->save($patient)) 
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                if (Input::has('telephone')) 
                {
                    $telephone = new Telephone;
                    $telephone->number = Input::get('telephone');
                    $person->telephones()->save($telephone);
                }

                DB::commit();

                Session::flash('success', 'El paciente ha sido agregado correctamente.');
                return Redirect::action('PatientsController@get_view', array('id' => $patient->id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();

                Session::flash('error', 'No ha sido posible agregar el paciente especificado.');
                return Redirect::action('PatientsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('PatientsController@get_add')->withErrors($validator)->withInput();
        }
	}

    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit($id)
	{
        if(!Auth::user()->can("edit-patients"))
            App::abort('403');

        $patient = Patient::findOrFail($id);

        $patient_types = Metatype::whereHas('metagroup', function($q){
            $q->where('description', '=', 'Tipos de Pacientes');
        })->lists('description', 'id');
         
        $document_types = Metatype::whereHas('metagroup', function($q){
            $q->where('description', '=', 'Tipos de Documentos');
        })->lists('description', 'id');
        
        $genders = Metatype::whereHas('metagroup', function($q){
            $q->where('description', '=', 'Géneros');
        })->get();

        $this->layout->title = 'Editar Paciente';
        $this->layout->content = View::make('admin.patients.edit', array (
            'document_types' => $document_types,  
            'patient_types' => $patient_types, 
            'genders' => $genders, 
            'patient' => $patient
        ));
	}
    
    // POST
	public function post_edit($id)
	{
        if(!Auth::user()->can("edit-patients"))
            App::abort('403');

        $rules =  array(
            'document_type' => array('required', 'exists:metatype,id'),
            'document_value' => array('max:30'),
            'firstname' => array('required', 'max:30'),
            'middlename' => array('max:30'),
            'lastname' => array('max:30'),
            'gender' => array('required', 'exists:metatype,id'),
            'birthdate' => array('required', 'date_format:d/m/Y'),
            'email' => array('required', 'email', 'max:100', 'unique:user'),
            'patient_type' => array('required', 'exists:metatype,id'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try 
            {
                $patient = Patient::findOrFail($id);

                $patient->email = Input::get('email');
                $patient->type_id = Input::get('patient_type');
                $patient->observation = Input::get('observation');

                $patient->person->document_type_id = Input::get('document_type');
                $patient->person->document_value = Input::get('document_value');
                $patient->person->firstname = Input::get('firstname');
                $patient->person->middlename = Input::get('middlename');
                $patient->person->lastname = Input::get('lastname');
                $patient->person->gender_id = Input::get('gender');
                $patient->person->birthdate = DateTime::createFromFormat('d/m/Y', Input::get('birthdate'));

                if(!$patient->person->save() || !$patient->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                DB::commit();

                Session::flash('success', 'El paciente ha sido editado correctamente.');
                return Redirect::action('PatientsController@get_view', array('id' => $id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();

                Session::flash('error', 'No ha sido posible editar el paciente especificado.');
                return Redirect::action('PatientsController@get_edit', array('id' => $id))->withInput();
            }
        }
        else
        {
            return Redirect::action('PatientsController@get_edit', array('id' => $id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // View Action
    //----------------------------------------------------------

    // GET
	public function get_view( $id )
	{
        if(!Auth::user()->can("view-patients"))
            App::abort('403');

        $patient = Patient::withTrashed()->findOrFail($id);

        $this->layout->title = $patient->person->fullname();
        $this->layout->content = View::make('admin.patients.view', array(
            'patient' => $patient
        ));
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete( $id )
	{
        if(!Auth::user()->can("delete-patients"))
            App::abort('403');

        $patient = Patient::findOrFail($id);

        if($patient->delete())
            Session::flash('success', 'El paciente ha sido desactivado correctamente.');
        else
            Session::flash('error', 'No ha sido posible desactivar el paciente especificado.');

        return Redirect::back();
	}
    
    // GET
	public function get_restore( $id )
	{
        if(!Auth::user()->can("delete-patients"))
            App::abort('403');

        $patient = Patient::onlyTrashed()->findOrFail($id);

        if($patient->restore())
            Session::flash('success', 'El paciente ha sido restaurado correctamente.');
        else
            Session::flash('error', 'No ha sido posible restaurar el paciente especificado.');

        return Redirect::back();
	}
    
}