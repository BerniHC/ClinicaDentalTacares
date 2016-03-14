<?php

class EventsController extends BaseController 
{
    protected $layout = 'layouts.admin';

    //----------------------------------------------------------
    // List Action
    //----------------------------------------------------------

    // GET
	public function get_list()
	{
        if(!Auth::user()->ability(NULL, "add-events,edit-events,view-events,delete-events"))
            App::abort('403');

        $upcoming = EventCal::whereHas('schedule', function($q) {
            $q->where('start_datetime', '>=', date('Y-m-d'));
        })->get();

        $outgoing = EventCal::whereHas('schedule', function($q) {
            $q->where('start_datetime', '<', date('Y-m-d'));
        })->get();
        
        $this->layout->title = 'Eventos';
        $this->layout->content = View::make('admin.events.list', array(
            'upcoming' => $upcoming,
            'outgoing' => $outgoing
        ));
	}
    
    //----------------------------------------------------------
    // Add Action
    //----------------------------------------------------------

    // GET
	public function get_add($date = '', $time = '0000')
	{
        if(!Auth::user()->can("add-events"))
            App::abort('403');
 
        $date = $date == '' ? date('Ymd') : $date;
        $startDate = DateTime::createFromFormat('YmdHi', $date.$time);
        $endDate = DateTime::createFromFormat('YmdHi', $date.$time);
        if($time != '0000') $endDate->add(new DateInterval('PT30M'));
        
        $metagroup = Metagroup::where('description', '=', 'Prioridades de Eventos')->first();
        $priorities = $metagroup->metatypes()->lists('description', 'id');

        $this->layout->title = 'Agregar Evento';
        $this->layout->content = View::make('admin.events.add', array(
            'startDate' => strtotime($startDate->format('Y-m-d H:i')),
            'endDate' => strtotime($endDate->format('Y-m-d H:i')),
            'priorities' => $priorities
        ));
	}
    
    // POST
	public function post_add()
	{
        if(!Auth::user()->can("add-events"))
            App::abort('403');

        $rules =  array(
            'subject' => array('required', 'max:100'),
            'description' => array('max:1000'),
            'priority' => array('required', 'exists:metatype,id'),
            'start_date' => array('required', 'date_format:d/m/Y'),
            'end_date' => array('date_format:d/m/Y'),
            'start_time' => array('date_format:H:i A'),
            'end_time' => array('date_format:H:i A')
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) 
        {
            DB::beginTransaction();
            try 
            {
                $event = new EventCal;
                $event->subject = Input::get('subject');
                $event->description = Input::get('description');
                $event->priority_id = Input::get('priority');
                $event->recurrence_type_id = 12;

                $schedule = new Schedule;

                if(Input::get('all_day_event')) 
                {
                    $schedule->start_datetime = DateTime::createFromFormat('d/m/Y h:i:s', Input::get('start_date').' 00:00:00');
                    $schedule->end_datetime = $schedule->start_datetime;
                } 
                else 
                {
                    $schedule->start_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                    $schedule->end_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('end_date').' '.Input::get('end_time'));
                }

                if($schedule->end_datetime < $schedule->start_datetime)
                    throw new Exception('La fecha fin del evento debe ser posterior a la fecha inicio.');

                if(!$schedule->save() || !$schedule->event()->save($event))
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                DB::commit();

                Session::flash('success', 'El evento ha sido agregado correctamente.');
                return Redirect::action('EventsController@get_view', array($event->id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();

                Session::flash('error', $ex->getMessage());
                return Redirect::action('EventsController@get_add')->withInput();
            }
        }
        else
        {
            return Redirect::action('EventsController@get_add')->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // Edit Action
    //----------------------------------------------------------

    // GET
	public function get_edit( $id )
	{
        if(!Auth::user()->can("edit-events"))
            App::abort('403');
            
        $event = EventCal::withTrashed()->findOrFail($id);
        
        $metagroup = Metagroup::where('description', '=', 'Prioridades de Eventos')->first();
        $priorities = $metagroup->metatypes()->lists('description', 'id');

        $this->layout->title = 'Editar Evento';
        $this->layout->content = View::make('admin.events.edit', array(
            'priorities' => $priorities, 
            'event' => $event
        ));
	}
    
    // POST
	public function post_edit( $id )
	{
        if(!Auth::user()->can("edit-events"))
            App::abort('403');

        $event = EventCal::withTrashed()->findOrFail($id);

        $rules =  array(
            'subject' => array('required', 'max:100'),
            'description' => array('max:1000'),
            'priority' => array('required', 'exists:metatype,id'),
            'start_date' => array('required', 'date_format:d/m/Y'),
            'end_date' => array('date_format:d/m/Y'),
            'start_time' => array('date_format:H:i A'),
            'end_time' => array('date_format:H:i A'),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->passes() ) 
        {
            DB::beginTransaction();
            try {
                $event->subject = Input::get('subject');
                $event->description = Input::get('description');
                $event->priority_id = Input::get('priority');
                $event->recurrence_type_id = 12;

                $schedule = $event->schedule;

                if(Input::get('all_day_event')) {
                    $schedule->start_datetime = DateTime::createFromFormat('d/m/Y h:i:s', Input::get('start_date').' 00:00:00');
                    $schedule->end_datetime = $schedule->start_datetime;
                } else {
                    $schedule->start_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('start_date').' '.Input::get('start_time'));
                    $schedule->end_datetime = DateTime::createFromFormat('d/m/Y H:i A', Input::get('end_date').' '.Input::get('end_time'));
                }
                
                if($schedule->end_datetime < $schedule->start_datetime)
                    throw new Exception('La fecha fin del evento debe ser posterior a la fecha inicio.');

                if(!$schedule->save() || !$event->save())
                    throw new Exception('Error al intentar guardar el elemento especificado.');

                DB::commit();

                Session::flash('success', 'El evento ha sido editado correctamente.');
                return Redirect::action('EventsController@get_view', array($id));
            }
            catch (\Exception $ex) 
            {
                DB::rollback();

                Session::flash('error', $ex->getMessage());
                return Redirect::action('EventsController@get_edit', array($id))->withInput();
            }
        }
        else
        {
            return Redirect::action('EventsController@get_edit', array($id))->withErrors($validator)->withInput();
        }
	}
    
    //----------------------------------------------------------
    // View Action
    //----------------------------------------------------------

    // GET
	public function get_view( $id )
	{
        if(!Auth::user()->can("view-events"))
            App::abort('403');

        $event = EventCal::withTrashed()->findOrFail($id);
        
        $this->layout->title = $event->subject;
        $this->layout->content = View::make('admin.events.view', array(
            'event' => $event
        ));
	}
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------

    // GET
	public function get_delete( $id )
	{
        if(!Auth::user()->can("delete-events"))
            App::abort('403');

        $event = EventCal::findOrFail($id);

        if($event != null && $event->delete())
            Session::flash('success', 'El evento ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el evento especificado.');

        return Redirect::action('EventsController@get_list');
	}
    
}