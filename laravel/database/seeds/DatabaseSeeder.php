<?php

use Illuminate\Database\Seeder;
use App\Approval;
use App\Attendance;
use App\Feedback;
use App\Leave;
use App\MonthYear;
use App\Payslip;
use App\Project;
use App\Team;
use App\Worksheet;
use App\User;
use App\TechLabelUser;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $this->call([StaticDataSeeder::class]);

        User::truncate();
        factory(User::class, 100)->create();

        TechLabelUser::truncate();
        factory(TechLabelUser::class, 200)->create();

        Project::truncate();
        factory(Project::class, 40)->create();

        Team::truncate();
        factory(Team::class, 50)->create();

        Worksheet::truncate();
        factory(Worksheet::class, 100)->create();

        Feedback::truncate();
        factory(Feedback::class, 100)->create();

        Leave::truncate();
        factory(Leave::class, 40)->create();

        Attendance::truncate();
        factory(Attendance::class, 200)->create();

        Payslip::truncate();
        factory(Payslip::class, 100)->create();

        Approval::truncate();
        factory(Approval::class, 30)->create();

    }
}