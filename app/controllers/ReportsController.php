<?php
class ReportsController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Default Action
    //----------------------------------------------------------
    
    // GET
    public function get_default($startdate = '', $enddate = '') 
    {
        if(!Auth::user()->can("view-reports"))
            App::abort('403');

        $startdate = $startdate == '' ? date('Y').'-01-01' : DateTime::createFromFormat('Ymd', $startdate)->format('Y-m-d');
        $enddate = $enddate == '' ? date('Y-m-d') : DateTime::createFromFormat('Ymd', $enddate)->format('Y-m-d');

        $defaultConnection = Config::get('database.default');

        JasperPHP::process(
            storage_path() . '/jasper/annual_report.jasper',
            public_path() . '/jasper/annual_report',
            array("pdf", "html", "ods"),
            array('startdate' => $startdate, 'enddate' => $enddate),
            Config::get('database.connections.' . $defaultConnection)
        )->execute();
            
        $this->layout->title = 'Reportes';
        $this->layout->content = View::make('admin.reports.default', array(
            'startdate' => date('d/m/Y', strtotime($startdate)),
            'enddate' => date('d/m/Y', strtotime($enddate))
        ));
    }
    
    //----------------------------------------------------------
    // Download Action
    //----------------------------------------------------------
    
    public function get_download($filename)
    {
        if(!Auth::user()->can("view-reports"))
            App::abort('403');

        $file = public_path() . '/jasper/' . $filename;

        return Response::download($file);
    }

}