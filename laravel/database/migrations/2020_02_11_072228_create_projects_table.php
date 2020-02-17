<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->text('url')->nullable();
            $table->text('dev_url')->nullable();
            $table->text('repo_url')->nullable();
            $table->date('delivered_on')->nullable();
            $table->integer('lead_by')->nullable();
            $table->integer('product_manager_id')->nullable();
            $table->boolean('wip')->default(1);
            $table->integer('created_by')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
