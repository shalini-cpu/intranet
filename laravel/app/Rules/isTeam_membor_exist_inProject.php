<?php

namespace App\Rules;

use App\Project;
use App\Team;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class isTeam_membor_exist_inProject implements Rule
{
    public $project = null;
    public $message = "User already exists in team";
    public $team = [];

    public function __construct($project_id = null, array $team)
    {
        $this->project =
            $project_id ?
                Project::with('team')->find($project_id) :
                Project::with('team')->find(request('project_id'));

        $this->team = $team ? $team : request('team');
    }

    public function passes($attribute, $value)
    {
        if (!$this->project) {
            return $this->fail('Project-id invalid');
        }

        foreach ($this->team as $member) {
            $found_row = Team::where([
                'project_id' => $this->project->id,
                'user_id' => $member['user_id'],
                'tech_label_id' => $member['tech_label_id'],
            ])->exists();

            $found_user = User::select('id', 'name')->find($member['user_id']);

            if ($found_row) {
                return $this->fail("User: '{$found_user->name}' already exists in team");
            }
            
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }

    public function fail($message)
    {
        if ($message) {
            $this->message = $message;
        }
        return false;
    }

    public function get_project()
    {
        return $this->project;
    }

    public function get_team_array()
    {
        return $this->team;
    }
}
