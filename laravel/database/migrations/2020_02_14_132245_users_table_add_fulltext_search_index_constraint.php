<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

class UsersTableAddFulltextSearchIndexConstraint extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE users ADD FULLTEXT fulltext_index (name,email,mobile,emp_id,branch_id)');
//        Schema::table('users', function (Blueprint $table) {
//        });
    }

    public function down()
    {
        DB::statement('DROP INDEX FULLTEXT ON users');
//        Schema::table('users', function (Blueprint $table) {
//        });
    }
}
