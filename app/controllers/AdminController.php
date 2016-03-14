<?php
class AdminController extends BaseController {
    
    protected $layout = 'layouts.admin';

    // Dashboard
	public function dashboard()
	{
        // Select today appointments
        $date_1 = new DateTime(date('Y-m-d') . ' 00:00:00');
        $date_2 = new DateTime(date('Y-m-d') . ' 00:00:00');
        $date_2->add(new DateInterval('P1D'));
        
        $schedules = Schedule::whereHas('appointment', function($q) {
            $q->whereHas('status', function($r) {
                $r->where('description', '=', 'Asignada');
            });
        })->where('start_datetime', '>=', $date_1)
          ->where('start_datetime', '<', $date_2)
          ->orderBy('start_datetime', 'asc')
          ->get();
        
        // Select next events
        $events = EventCal::whereHas('schedule', function($q) {
            $q->where('start_datetime', '>=', date('Y-m-d'));
        })->take(5)->get();

        // Select new patients
        $patients = Patient::orderBy('created_at', 'desc')->take(5)->get();

        $data_chart2 = DB::select( 
            DB::raw("SELECT mt.description y, count(p.id) a FROM patient p JOIN metatype mt ON p.type_id = mt.id GROUP BY mt.id")
        );
        
        // Show dashboard view
        $this->layout->title = 'Escritorio';
        $this->layout->content = View::make('admin.dashboard', array(
            'schedules' => $schedules,
            'events' => $events,
            'patients' => $patients,
            'data_chart2' => $data_chart2
        ));
	}

}