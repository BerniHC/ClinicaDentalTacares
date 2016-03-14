<?php
class MainController extends BaseController {
    
    protected $layout = 'layouts.main';

    // HomePage
	public function home()
	{
        // If authenticated redirect to dashborad
        if(Auth::check())
            return Redirect::action('AdminController@dashboard');
        
        // Else show homepage view
        $this->layout->title = 'Bienvenido';
        $this->layout->content = View::make('main.home');
	}

}