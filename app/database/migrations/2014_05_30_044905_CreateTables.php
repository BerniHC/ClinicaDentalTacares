<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration 
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
        //--------------------------------------------------
        // Meta
        //--------------------------------------------------

        // Meta Group
        Schema::create('metagroup', function($table) {
            $table->integer('id', true);
            $table->string('description', 50);
            $table->softDeletes();
        });

        // Meta Type
        Schema::create('metatype', function($table) {
            $table->integer('id', true);
            $table->integer('metagroup_id');
            $table->string('description', 50);
            $table->softDeletes();
            
            $table->foreign('metagroup_id')->references('id')->on('metagroup');
        });

        // Estate
        Schema::create('estate', function($table) {
            $table->integer('id', true);
            $table->string('name', 50);
            $table->softDeletes();
        });
        
        // City
        Schema::create('city', function($table) {
            $table->integer('id', true);
            $table->string('name', 50);
            $table->integer('estate_id');
            $table->softDeletes();

            $table->foreign('estate_id')->references('id')->on('estate');
        });

        //--------------------------------------------------
        // Users
        //--------------------------------------------------

        // People
        Schema::create('person', function($table)
        {
            $table->integer('id', true);
            $table->integer('document_type_id');
            $table->string('document_value', 30)->unique()->nullable();
            $table->string('firstname', 30);
            $table->string('middlename', 30)->nullable();
            $table->string('lastname', 30)->nullable();
            $table->integer('gender_id');
            $table->date('birthdate');
            $table->softDeletes();

            $table->index(array('document_value', 'firstname', 'middlename', 'lastname'));
            $table->foreign('document_type_id')->references('id')->on('metatype');
            $table->foreign('gender_id')->references('id')->on('metatype');
        });
        
		// Address
        Schema::create('address', function($table)
        {
            $table->integer('id', true);
            $table->integer('person_id');
            $table->integer('estate_id');
            $table->integer('city_id');
            $table->string('address', 200)->nullable();
            $table->softDeletes();
            
            $table->foreign('person_id')->references('id')->on('person');
            $table->foreign('estate_id')->references('id')->on('estate');
            $table->foreign('city_id')->references('id')->on('city');
        });

        // Telephone
        Schema::create('telephone', function($table)
        {
            $table->integer('id', true);
            $table->integer('person_id');
            $table->integer('number');
            $table->softDeletes();

            $table->foreign('person_id')->references('id')->on('person');
        });

		// User
        Schema::create('user', function($table)
        {
            $table->integer('id', true);
            $table->integer('person_id')->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 128);
            $table->string('remember_token', 100)->nullable();
            $table->string('confirmation_code', 30);
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('require_new_password')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->foreign('person_id')->references('id')->on('person');
        });
        
		// Patient
        Schema::create('patient', function($table)
        {
            $table->integer('id', true);
            $table->integer('person_id')->unique();
            $table->string('email', 100)->unique();
            $table->integer('type_id');
            $table->text('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->foreign('person_id')->references('id')->on('person');
            $table->foreign('type_id')->references('id')->on('metatype');
        });

        // Reset Tokens
        Schema::create('reset_tokens', function($table)
        {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('token', 30);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('user');
        });

        //--------------------------------------------------
        // Agenda
        //--------------------------------------------------
        
        // Category
        Schema::create('category', function($table)
        {
            $table->integer('id', true);
            $table->string('description', 50);
            $table->string('color', 10);
            $table->softDeletes();
        });
        
        // Treatment
        Schema::create('treatment', function($table)
        {
            $table->integer('id', true);
            $table->string('description', 50);
            $table->integer('category_id');
            $table->softDeletes();
            
            $table->foreign('category_id')->references('id')->on('category');
        });
        
        // Schedule
        Schema::create('schedule', function($table)
        {
            $table->integer('id', true);
            $table->datetime('start_datetime');
            $table->datetime('end_datetime')->nullable();
            $table->softDeletes();

            $table->index(array('start_datetime', 'end_datetime'));
        });
        
        // Event
        Schema::create('event', function($table)
        {
            $table->integer('id', true);
            $table->string('subject', 100);
            $table->string('description', 1000)->nullable();
            $table->integer('priority_id');
            $table->integer('recurrence_type_id');
            $table->integer('schedule_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('subject');
            $table->foreign('priority_id')->references('id')->on('metatype');
            $table->foreign('recurrence_type_id')->references('id')->on('metatype');
            $table->foreign('schedule_id')->references('id')->on('schedule');
        });
        
        // Appointment
        Schema::create('appointment', function($table)
        {
            $table->integer('id', true);
            $table->integer('patient_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('category_id');
            $table->integer('status_id');
            $table->string('observation', 1000)->nullable();
            $table->integer('schedule_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('patient_id')->references('id')->on('patient');
            $table->foreign('doctor_id')->references('id')->on('user');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('status_id')->references('id')->on('metatype');
            $table->foreign('schedule_id')->references('id')->on('schedule');
        });
        
        // Treatment
        Schema::create('appointment_treatment', function($table)
        {
            $table->integer('appointment_id');
            $table->integer('treatment_id');
            $table->integer('amount')->default(0);
            $table->string('observation', 1000)->nullable();
            $table->softDeletes();

            $table->primary(array('appointment_id', 'treatment_id'));
            $table->foreign('appointment_id')->references('id')->on('appointment')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('treatment_id')->references('id')->on('treatment');
        });
        
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
        Schema::drop('appointment_treatment');
        Schema::drop('appointment');
        Schema::drop('event');
        Schema::drop('schedule');
        Schema::drop('treatment');
        Schema::drop('category');
        Schema::drop('reset_tokens');
        Schema::drop('patient');
        Schema::drop('user');
        Schema::drop('telephone');
        Schema::drop('address');
        Schema::drop('person');
        Schema::drop('city');
        Schema::drop('estate');
        Schema::drop('metatype');
        Schema::drop('metagroup');
	}

}
