<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emer_contact_no')->nullable();
            $table->string('emer_contact_name')->nullable();
            $table->string('designation')->nullable();
            $table->date('dob')->nullable();
            $table->date('doj')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('emp_id')->unique();
            $table->date('resignation_date')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->integer('reporting_to')->nullable();
            $table->string('bg')->nullable();
            $table->text('profile_pic')->nullable();
            $table->text('resume_url')->nullable();
            $table->string('branch_id')->nullable()->default(1);
            $table->integer('current_salary')->nullable();
            $table->string('user_type')->default('employee');
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
