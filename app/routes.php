<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//--------------------------------------------------------
// Main Routes
//--------------------------------------------------------

Route::get('/', array('as' => 'home', 'uses' => 'MainController@home'));

//--------------------------------------------------------
// Login Routes
//--------------------------------------------------------

Route::group(array('before' => 'logout'), function()
{
    Route::get('/login', array('as' => 'login', 'uses' => 'AccountController@get_login'));
    Route::get('/confirm/{code}', array('as' => 'confirm-account', 'uses' => 'AccountController@get_confirm'));
    Route::get('/forgot-password', array('as' => 'forgot-password', 'uses' => 'AccountController@get_forgot_password'));
    Route::get('/reset-password/{token?}', array('as' => 'reset-password', 'uses' => 'AccountController@get_reset_password'));

    Route::post('/login', array('before' => 'csrf', 'uses'=>'AccountController@post_login'));
    Route::post('/forgot-password', array('before' => 'csrf', 'uses'=>'AccountController@post_forgot_password'));
    Route::post('/reset-password/{token?}', array('before' => 'csrf', 'uses'=>'AccountController@post_reset_password'));
});

//--------------------------------------------------------
// Account Routes
//--------------------------------------------------------

Route::group(array('before' => 'auth|ban.user'), function()
{
    // Account 
    Route::get('/account/change-password', array('as' => 'change-password', 'uses' => 'AccountController@get_change_password'));
    Route::get('/account/profile', array('as' => 'profile', 'uses' => 'AccountController@get_profile'));
    Route::get('/account/logout', array('as' => 'logout', 'uses' => 'AccountController@logout'));
    
    Route::post('/account/change-password', array('before' => 'csrf', 'uses'=>'AccountController@post_change_password'));
});

//--------------------------------------------------------
// Admin Routes
//--------------------------------------------------------

Route::group(array('before' => 'auth|ban.user', 'after' => 'check.password'), function()
{
    Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'AdminController@dashboard'));

    // Addresses
    Route::get('/addresses/cities', array('as' => 'addresses-cities', 'uses' => 'AddressesController@json_cities'));
    
    // Calendar
    Route::get('/calendar/events/', array('as' => 'calendar-events', 'uses' => 'CalendarController@get_all_events'));
    Route::get('/calendar/check/{start_datetime?}/{end_datetime?}/{id?}', array('as' => 'calendar-check', 'uses' => 'CalendarController@check_availability'));
    Route::get('/calendar/{year?}/{month?}/{day?}', array('as' => 'calendar', 'uses' => 'CalendarController@get_default'));

    // Appointments
    Route::get('/appointments/patients', array('as' => 'appointment-patients', 'uses' => 'AppointmentsController@json_patients'));
    Route::get('/appointments/doctors', array('as' => 'appointment-doctors', 'uses' => 'AppointmentsController@json_doctors'));

    Route::get('/appointments', array('as' => 'appointment-list', 'uses' => 'AppointmentsController@get_list'));
    Route::get('/appointments/add/{date?}/{time?}', array('as' => 'appointment-add', 'uses' => 'AppointmentsController@get_add'));
    Route::get('/appointments/{id}/edit', array('as' => 'appointment-edit', 'uses' => 'AppointmentsController@get_edit'));
    Route::get('/appointments/{id}/view', array('as' => 'appointment-view', 'uses' => 'AppointmentsController@get_view'));
    Route::get('/appointments/{id}/delete', array('as' => 'appointment-delete', 'uses' => 'AppointmentsController@get_delete'));
    Route::get('/appointments/{id}/status/{status_id}', array('as' => 'appointment-status', 'uses' => 'AppointmentsController@change_status'));

    Route::post('/appointments/add/{date?}/{time?}', array('before' => 'csrf', 'uses'=>'AppointmentsController@post_add'));
    Route::post('/appointments/{id}/edit', array('before' => 'csrf', 'uses'=>'AppointmentsController@post_edit'));

    // Appointments Treatments
    Route::get('/appointments/{appointment_id}/treatments/add', array('as' => 'appointment-treatment-add', 'uses' => 'AppointmentsController@get_add_treatment'));
    Route::get('/appointments/{appointment_id}/treatments/{treatment_id}/edit', array('as' => 'appointment-treatment-edit', 'uses' => 'AppointmentsController@get_edit_treatment'));
    Route::get('/appointments/{appointment_id}/treatments/{treatment_id}/delete', array('as' => 'appointment-treatment-delete', 'uses' => 'AppointmentsController@get_delete_treatment'));

    Route::post('/appointments/{appointment_id}/treatments/add', array('before' => 'csrf', 'uses'=>'AppointmentsController@post_add_treatment'));
    Route::post('/appointments/{appointment_id}/treatments/{treatment_id}/edit', array('before' => 'csrf', 'uses'=>'AppointmentsController@post_edit_treatment'));

    // Events
    Route::get('/events', array('as' => 'event-list', 'uses' => 'EventsController@get_list'));
    Route::get('/events/add/{date?}/{time?}', array('as' => 'event-add', 'uses' => 'EventsController@get_add'));
    Route::get('/events/{id}/edit', array('as' => 'event-edit', 'uses' => 'EventsController@get_edit'));
    Route::get('/events/{id}/view', array('as' => 'event-view', 'uses' => 'EventsController@get_view'));
    Route::get('/events/{id}/delete', array('as' => 'event-delete', 'uses' => 'EventsController@get_delete'));

    Route::post('/events/add/{date?}/{time?}', array('before' => 'csrf', 'uses'=>'EventsController@post_add'));
    Route::post('/events/{id}/edit', array('before' => 'csrf', 'uses'=>'EventsController@post_edit'));
    
    // Addresses & Telephones
    Route::get('/addresses/add/{person_id}', array('as' => 'address-add', 'uses' => 'AddressesController@get_add'));
    Route::get('/addresses/delete/{id}', array('as' => 'address-delete', 'uses' => 'AddressesController@get_delete'));
    Route::get('/telephones/add/{person_id}', array('as' => 'telephone-add', 'uses' => 'TelephonesController@get_add'));
    Route::get('/telephones/delete/{id}', array('as' => 'telephone-delete', 'uses' => 'TelephonesController@get_delete'));

    Route::post('/addresses/add/{person_id}', array('before' => 'csrf', 'uses'=>'AddressesController@post_add'));
    Route::post('/telephones/add/{person_id}', array('before' => 'csrf', 'uses'=>'TelephonesController@post_add'));

    // Patients
    Route::get('/patients', array('as' => 'patient-list', 'uses' => 'PatientsController@get_list'));
    Route::get('/patients/add', array('as' => 'patient-add', 'uses' => 'PatientsController@get_add'));
    Route::get('/patients/{id}/edit', array('as' => 'patient-edit', 'uses' => 'PatientsController@get_edit'));
    Route::get('/patients/{id}/view', array('as' => 'patient-view', 'uses' => 'PatientsController@get_view'));
    Route::get('/patients/{id}/delete', array('as' => 'patient-delete', 'uses' => 'PatientsController@get_delete'));
    Route::get('/patients/{id}/restore', array('as' => 'patient-restore', 'uses' => 'PatientsController@get_restore'));

    Route::post('/patients/add', array('before' => 'csrf', 'uses'=>'PatientsController@post_add'));
    Route::post('/patients/{id}/edit', array('before' => 'csrf', 'uses'=>'PatientsController@post_edit'));

    // Users
    Route::get('/users', array('as' => 'user-list', 'uses' => 'UsersController@get_list'));
    Route::get('/users/add', array('as' => 'user-add', 'uses' => 'UsersController@get_add'));
    Route::get('/users/{id}/edit', array('as' => 'user-edit', 'uses' => 'UsersController@get_edit'));
    Route::get('/users/{id}/view', array('as' => 'user-view', 'uses' => 'UsersController@get_view'));
    Route::get('/users/{id}/delete', array('as' => 'user-delete', 'uses' => 'UsersController@get_delete'));
    Route::get('/users/{id}/restore', array('as' => 'user-restore', 'uses' => 'UsersController@get_restore'));

    Route::post('/users/add', array('before' => 'csrf', 'uses'=>'UsersController@post_add'));
    Route::post('/users/{id}/edit', array('before' => 'csrf', 'uses'=>'UsersController@post_edit'));

    // Configuration
    Route::get('/configuration/website', array('as' => 'config-website', 'uses' => 'ConfigurationController@get_website'));
    Route::get('/configuration/agenda', array('as' => 'config-agenda', 'uses' => 'ConfigurationController@get_agenda'));

    Route::post('/configuration/website', array('before' => 'csrf', 'uses'=>'ConfigurationController@post_website'));
    Route::post('/configuration/agenda', array('before' => 'csrf', 'uses'=>'ConfigurationController@post_agenda'));
    
    // Role
    Route::get('/configuration/roles', array('as' => 'role-list', 'uses' => 'RolesController@get_list'));
    Route::get('/configuration/roles/add', array('as' => 'role-add', 'uses' => 'RolesController@get_add'));
    Route::get('/configuration/roles/{id}/edit', array('as' => 'role-edit', 'uses' => 'RolesController@get_edit'));
    Route::get('/configuration/roles/{id}/delete', array('as' => 'role-delete', 'uses' => 'RolesController@get_delete'));
    
    Route::post('/configuration/roles/add', array('before' => 'csrf', 'uses'=>'RolesController@post_add'));
    Route::post('/configuration/roles/{id}/edit', array('before' => 'csrf', 'uses'=>'RolesController@post_edit'));
    
    // Metatypes
    Route::get('/configuration/metatypes', array('as' => 'metatype-list', 'uses' => 'MetatypesController@get_list'));
    Route::get('/configuration/metatypes/add', array('as' => 'metatype-add', 'uses' => 'MetatypesController@get_add'));
    Route::get('/configuration/metatypes/{id}/edit', array('as' => 'metatype-edit', 'uses' => 'MetatypesController@get_edit'));
    Route::get('/configuration/metatypes/{id}/delete', array('as' => 'metatype-delete', 'uses' => 'MetatypesController@get_delete'));

    Route::post('/configuration/metatypes/add', array('before' => 'csrf', 'uses'=>'MetatypesController@post_add'));
    Route::post('/configuration/metatypes/{id}/edit', array('before' => 'csrf', 'uses'=>'MetatypesController@post_edit'));

    // Treatments
    Route::get('/configuration/treatments', array('as' => 'treatment-list', 'uses' => 'TreatmentsController@get_list'));
    Route::get('/configuration/treatments/add', array('as' => 'treatment-add', 'uses' => 'TreatmentsController@get_add'));
    Route::get('/configuration/treatments/{id}/edit', array('as' => 'treatment-edit', 'uses' => 'TreatmentsController@get_edit'));
    Route::get('/configuration/treatments/{id}/delete', array('as' => 'treatment-delete', 'uses' => 'TreatmentsController@get_delete'));

    Route::post('/configuration/treatments/add', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_add'));
    Route::post('/configuration/treatments/{id}/edit', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_edit'));

    // Treatments Categories
    Route::get('/configuration/treatments/categories/add', array('as' => 'category-add', 'uses' => 'TreatmentsController@get_add_category'));
    Route::get('/configuration/treatments/categories/{id}/edit', array('as' => 'category-edit', 'uses' => 'TreatmentsController@get_edit_category'));
    Route::get('/configuration/treatments/categories/{id}/delete', array('as' => 'category-delete', 'uses' => 'TreatmentsController@get_delete_category'));
    
    Route::post('/configuration/treatments/categories/add', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_add_category'));
    Route::post('/configuration/treatments/categories/{id}/edit', array('before' => 'csrf', 'uses'=>'TreatmentsController@post_edit_category'));

    // Reports
    Route::get('/reports/download/{filename}', array('as' => 'reports-download', 'uses' => 'ReportsController@get_download'));
    Route::get('/reports/{startdate?}/{enddate?}', array('as' => 'reports', 'uses' => 'ReportsController@get_default'));

});
