<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechLabelUsersTable extends Migration
{
    public function up()
    {
        Schema::create('tech_label_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('techlable_id');
            $table->integer('user_id');
            $table->integer('level')->default(6);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tech_label_users');
    }
}
