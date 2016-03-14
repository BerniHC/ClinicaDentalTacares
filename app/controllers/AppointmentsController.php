<?php

class AppointmentsController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Others Actions
    //----------------------------------------------------------

    // Json Patients
    public function json_patients()
    {
        // Select patients list
        $patients = DB::table('person')
            ->join('patient', 'person.id', '=', 'patient.person_id')
            ->whereNull('patient.deleted_at')
            ->select('patient.id', DB::raw("CONCAT(firstname, ' ', middlename, ' ', lastname) AS name"))
            ->get(['id', 'name']);
        
        return json_encode($patients);
    }
    
    // Json Doctors
    public function json_doctors()
    {
        // Select doctors list
        $doctors = DB::table('person')
            ->join('user', 'person.id', '=', 'user.person_id')
            ->join('user_role', 'user.id', '=', 'user_role.user_id')
            ->where('user_role.role_id', '=', '2')
            ->whereNull('user.deleted_at')
            ->select('user.id', DB::raw("CONCAT(firstname, ' ', middlename, ' ', lastname) AS name"))
            ->get(['id', 'name']);
        
        return json_encode($doctors);
    }
    
    // Change Status
	public function change_status( $id, $status_id )
	{
        // Check permissions
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');

        try {
            // Get and update appointment
            $appointment = Appointment::withTrashed()->findOrFail($id);
            $appointment->status_id = $status_id;

            // Save appointment to database
            if(!$appointment->save()) 
                throw new Exception('Error al intentar cambiar el estado.');

            Session::flash('success', 'El estado ha sido cambiado correctamente.');
            return Redirect::action('AppointmentsController@get_view', array($id));
        }
        catch (\Exception $ex) 
        {
            Log::error($ex);

            Session::flash('error', 'No ha sido posible cambiar el estado.');
            return Redirect::action('AppointmentsController@get_view', array($id));
        }
	}
    
    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        // Check permission
        if(!Auth::user()->ability(NULL, "add-appointments,edit-appointments,view-appointments,delete-appointments"))
            App::abort('403');

        // Select upcoming appointments
        $upcoming = Appointment::whereHas('schedule', function($q) {
            $q->where('start_datetime', '>=', date('Y-m-d'));
        })->get();

        // Select aoutgoing appointments
        $outgoing = Appointment::whereHas('schedule', function($q) {
            $q->where('start_datetime', '<', date('Y-m-d'));
        })->get();
        
        // Show appointments list
        $this->layout->title = 'Citas';
        $this->layout->content = View::make('admin.appointments.list', array(
            'upcoming' => $upcoming,
            'outgoing' => $outgoing
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add($date = '', $time = '0800')
	{
        // Check permissions
        if(!Auth::user()->can("add-appointments"))
            App::abort('403');
           
        // Get start date to add appointment
        $date = $date == '' ? date('Y-m-d') : DateTime::createFromFormat('Ymd', $date)->format('Y-m-d');
        $startDate = strtotime($date . DateTime::createFromFormat('Hi', $time)->format(' H:i'));
        
        // Select appointment categories
        $categories = Category::lists('description', 'id');
        
        // Show add appointment view
        $this->layout->title = 'Agregar Cita';
        $this->layout->content = View::make('admin.appointments.add', array(
            'categories' => $categories,
            'startDate' => $startDate
        ));
	}
    
    // POST
	public function post_add()
	{
        // Check permissions
        if(!Auth::user()->can("add-appointments"))
            App::abort('403');

        // Set validation rules
        $rules =  array(
            'patient_id' => array('required', 'exists:patient,id'),
            'doctor_id' => array('exists:user,id'),
            'category' => array('required', 'exists:category,id'),
            'start_date' => array('required', 'date_format:d/m/Y'),
            'start_time' => array('date_format:H:i A'),
            'observation' => array('max:1000'),
        );

        // Check validation rules
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try {
                // Get status id
                $status_id = Metatype::where('description', '=', 'Asignada')->pluck('id');

                // Create appointment
                $appointment = new Appointment;
                $appointment->patient_id = Input::get('patient_id');
                $appointment->doctor_id = Input::has('doctor_id') ? Input::get('doctor_id') : null;
                $appointment->category_id = Input::get('category');
                $appointment->status_id = $status_id;
                $appointment->observation = Input::get('observation');

                // Create schedule
                $schedule = new Schedule;
                $schedule->start_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $schedule->end_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $schedule->end_datetime->add(new DateInterval('PT30M'));

                // Save schedule and appointment to database
                if(!$schedule->save() || !$schedule->appointment()->save($appointment)) 
                    throw new Exception('Error al intentar guardar el elemento especificado.');
                
                DB::commit();

                Session::flash('success', 'La cita ha sido agregada correctamente.');
                return Redirect::action('AppointmentsController@get_view', array($appointment->id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar la cita especificada.');
                return Redirect::action('AppointmentsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('AppointmentsController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit( $id )
	{
        // Check permission
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');
        
        // Get appointment
        $appointment = Appointment::withTrashed()->findOrFail($id);
        
        // Select appointment categories
        $categories = Category::lists('description', 'id');

        // Select appointment status
        $status = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Estados de las citas');
        })->lists("description", "id");
        
        // Show edit appointment view
        $this->layout->title = 'Editar Cita';
        $this->layout->content = View::make('admin.appointments.edit', array(
            'categories' => $categories,
            'status' => $status,
            'appointment' => $appointment
        ));
	}
    
    // POST
	public function post_edit( $id )
	{
        // Check permission
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');
           
        // Set validation rules
        $rules =  array(
            'patient_id' => array('required', 'exists:patient,id'),
            'doctor_id' => array('exists:user,id'),
            'category' => array('required', 'exists:category,id'),
            'start_date' => array('required', 'date_format:d/m/Y'),
            'start_time' => array('date_format:H:i A'),
            'status' => array('required', 'exists:metatype,id'),
            'observation' => array('max:1000'),
        );

        // Check validation rules
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try {
                // Get and update appointment 
                $appointment = Appointment::withTrashed()->findOrFail($id);
                $appointment->patient_id = Input::get('patient_id');
                $appointment->doctor_id = Input::has('doctor_id') ? Input::get('doctor_id') : null;
                $appointment->category_id = Input::get('category');
                $appointment->status_id = Input::get('status');
                $appointment->observation = Input::get('observation');

                // Update schedule
                $appointment->schedule->start_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $appointment->schedule->end_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                $appointment->schedule->end_datetime->add(new DateInterval('PT30M'));

                // Save appointment and schedule to database
                if(!$appointment->save() || !$appointment->schedule->save())
                    throw new Exception('Error al intentar editar el elemento especificado.');
                
                DB::commit();

                Session::flash('success', 'La cita ha sido editada correctamente.');
                return Redirect::action('AppointmentsController@get_view', array($id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();
                Log::error($ex);

                Session::flash('error', 'No ha sido posible editar la cita especificada.');
                return Redirect::action('AppointmentsController@get_edit', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('AppointmentsController@get_edit', array($id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // View Action
    //----------------------------------------------------------

    // GET
	public function get_view( $id )
	{
        // Check permissions
        if(!Auth::user()->can("view-appointments"))
            App::abort('403');
        
        // Get appointment
        $appointment = Appointment::withTrashed()->findOrFail($id);
        
        // Get appointment status list
        $status = Metatype::whereHas('metagroup', function($q) {
            $q->where('description', '=', 'Estados de las citas');
        })->get();
        
        // Show appointment view
        $this->layout->title = 'Cita de ' . $appointment->patient->person->fullname();
        $this->layout->content = View::make('admin.appointments.view', array (
            'appointment' => $appointment,
            'status' => $status
        ));
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete( $id )
	{
        if(!Auth::user()->can("delete-appointments"))
            App::abort('403');

        $appointment = Appointment::findOrFail($id);

        if($appointment->delete())
            Session::flash('success', 'La cita ha sido eliminada correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar la cita especificada.');

        return Redirect::action('AppointmentsController@get_list');
	}
    
    //----------------------------------------------------------
    // Add Treatment Action
    //----------------------------------------------------------

    // GET
	public function get_add_treatment($appointment_id)
	{
        if(!Auth::user()->can("edit-appointments")) App::abort('403');

        $appointment = Appointment::withTrashed()->findOrFail($appointment_id);

        $treatments = Treatment::where('category_id', '=', $appointment->category_id)->lists('description', 'id');
        
        $this->layout->title = 'Agregar Tratamiento';
        $this->layout->content = View::make('admin.treatments.add', array(
            'appointment' => $appointment,
            'treatments' => $treatments
        ));
	}
    
    // POST
	public function post_add_treatment($appointment_id)
	{
        if(!Auth::user()->can("edit-appointments")) 
            App::abort('403');

        $rules =  array(
            'treatment' => array('required', 'exists:treatment,id'),
            'amount' => array('required', 'numeric', 'min:0'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                $appointment = Appointment::findOrFail($appointment_id);
                $appointment->treatments()->attach(
                    Input::get('treatment'), 
                    array (
                        'amount' => Input::get('amount'),
                        'observation' => Input::get('observation')
                    )
                );

                if(!$appointment->save()) 
                    throw new Exception('Error al intentar guardar el elemento especificado.');
                
                Session::flash('success', 'El tratamiento ha sido agregado correctamente.');
                return Redirect::action('AppointmentsController@get_view', array($appointment_id));
            }
            catch (\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar el tratamiento especificado.');
                return Redirect::action('AppointmentsController@get_add_treatment', array($appointment_id))->withInput();
            }
        }
        else
        {
            return Redirect::action('AppointmentsController@get_add_treatment', array($appointment_id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit_treatment($appointment_id, $treatment_id)
	{
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');
        
        $appointment = Appointment::withTrashed()->findOrFail($appointment_id);
        $treatments = Treatment::where('category_id', '=', $appointment->category_id)->lists('description', 'id');
        $treatment = $appointment->treatments()->findOrFail($treatment_id);

        $this->layout->title = 'Editar Tratamiento';
        $this->layout->content = View::make('admin.treatments.edit', array(
            'treatments' => $treatments,
            'treatment' => $treatment
        ));
	}
    
    // POST
	public function post_edit_treatment($appointment_id, $treatment_id)
	{
        if(!Auth::user()->can("edit-appointments")) 
            App::abort('403');

        $rules = array(
            'treatment' => array('required', 'exists:treatment,id'),
            'amount' => array('required', 'numeric', 'min:0'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            try {
                $appointment = Appointment::findOrFail($appointment_id);
                $treatment = $appointment->treatments()->findOrFail($treatment_id);
                //$treatment->

                if(!$appointment->save()) 
                    throw new Exception('Error al intentar guardar el elemento especificado.');
                
                Session::flash('success', 'El tratamiento ha sido agregado correctamente.');
                return Redirect::action('AppointmentsController@get_view', array($appointment_id));
            }
            catch (\Exception $ex) 
            {
                Log::error($ex);

                Session::flash('error', 'No ha sido posible agregar el tratamiento especificado.');
                return Redirect::action('AppointmentsController@get_add_treatment', array($appointment_id))->withInput();
            }
        }
        else
        {
            return Redirect::action('AppointmentsController@get_add_treatment', array($appointment_id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Delete Treatment Action
    //----------------------------------------------------------

    // GET
	public function get_delete_treatment($appointment_id, $treatment_id)
	{
        if(!Auth::user()->can("edit-appointments"))
            App::abort('403');

        $appointment = Appointment::findOrFail($appointment_id);
        $appointment->treatments()->detach($treatment_id);

        if($appointment->save())
            Session::flash('success', 'El tratamiento ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el tratamiento especificado.');

        return Redirect::action('AppointmentsController@get_view', array($appointment_id));
	}
    
}