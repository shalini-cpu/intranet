<?php

use App\Branch;
use App\Role;
use App\Techlabel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticDataSeeder extends Seeder
{
    public function run()
    {
        DB::table('techlabels')->delete();
        $tech_tag = ['Laravel', 'Node', 'Javascript', 'ReactJS', 'Angular', 'Android', 'Java','C#', 'PHP', 'C/C++', 'R', 'Objective-C', 'Swift', 'TypeScript', 'Matlab', 'Kotlin', 'VBA', 'Ruby', 'Go', 'Scala', 'Visual Basic', 'Rust', 'Perl', 'Abap', 'Dart', 'Groovy', 'Ada', 'Lua', 'Cobol', 'Haskell', 'Julia', 'Delphi'];
        foreach ($tech_tag as $tag) {
            Techlabel::create(["name" => $tag, "status" => 1]);
        }

        DB::table('roles')->truncate();
        $array = ["admin", "manager", "hr", "emp", "operation", "finance"];
        foreach ($array as $tag) {
            Role::create(["name" => $tag]);
        }

        Branch::truncate();
        factory(Branch::class, 10)->create();

    }
}
