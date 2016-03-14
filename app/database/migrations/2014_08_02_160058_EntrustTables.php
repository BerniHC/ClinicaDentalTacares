<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntrustTables extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        //--------------------------------------------------
        // Roles
        //--------------------------------------------------

        // Creates the roles table
        Schema::create('role', function ($table) {
            $table->integer('id', true);
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Creates the assigned_roles (Many-to-Many relation) table
        Schema::create('user_role', function ($table) {
            $table->integer('user_id');
            $table->integer('role_id');
            $table->softDeletes();

            $table->primary(array('user_id', 'role_id'));
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('role');
        });

        // Creates the permissions table
        Schema::create('permission', function ($table) {
            $table->integer('id', true);
            $table->string('name')->unique();
            $table->string('display_name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('permission_role', function ($table) {
            $table->integer('permission_id');
            $table->integer('role_id');
            $table->softDeletes();
            
            $table->primary(array('permission_id', 'role_id'));
            $table->foreign('permission_id')->references('id')->on('permission'); // assumes a users table
            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('user_role');
        Schema::drop('permission_role');
        Schema::drop('role');
        Schema::drop('permission');
    }

}
