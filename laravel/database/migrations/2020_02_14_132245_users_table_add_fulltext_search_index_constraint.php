<?php

use Illuminate\Database\Migrations\Migration;


class UsersTableAddFulltextSearchIndexConstraint extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE users ADD FULLTEXT fulltext_index_users (name,email,mobile,emp_id,branch_id)');
        DB::statement('ALTER TABLE tech_labels ADD FULLTEXT fulltext_index_tech_labels (name)');
//        Schema::table('users', function (Blueprint $table) {
//        });
    }

    public function down()
    {
        DB::statement('DROP INDEX fulltext_index_users ON users');
        DB::statement('DROP INDEX fulltext_index_tech_labels ON tech_labels');
//        Schema::table('users', function (Blueprint $table) {
//        });
    }
}
