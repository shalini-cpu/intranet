<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonUtilTrait;
use App\Project;
use App\Rules\isTeam_membor_exist_inProject;
use App\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use JsonUtilTrait;

    public function index(Request $request)
    {
        try {
            /// TODO:ROLE manager|admin can retrieve all projects
            $projects =
                Project::
                with('team', 'team.user_details')->
                paginate(30)->appends(request()->all());

            return $this->responseWithSuccess('Success', $projects);

        } catch (Throwable $e) {
            info(["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()]);
            return $this->responseWithError("Internal server error", null, 500, 500);
        }

    }

    public function store(Request $request)
    {
        // IF manager
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|regex:/^[a-zA-Z0-9\s]*$/"
                , 'title' => "required|regex:/^[a-zA-Z0-9\s\-]*$/"
                , 'desc' => "required"
                , 'url' => "string"
                , 'dev_url' => "string"
                , 'repo_url' => "string"
                , 'delivered_on' => "required|date|date_format:Y-m-d"
                , 'lead_by' => "required|integer|exists:users,id"
                , 'product_manager_id' => "required|integer|exists:users,id"
                , 'wip' => "integer"
                , 'created_by' => "required|integer|exists:users,id"
                , 'team' => "array"
                , 'team.*.user_id' => "exists:users,id"
                , 'team.*.tech_label_id' => "exists:tech_labels,id"
            ]);

            if ($validator->fails()) {
                return $this->responseWithError($validator->messages());
            }

            $request->merge(['created_by' => auth()->id()]);
            $new_project = Project::create($request->all());

            request('team') ? $new_project->team()->createMany(request()->get('team')) : false;

            $created_project = Project::with('team')->find($new_project->id);
            return $this->responseWithSuccess('New project created successfuly', [$created_project]);

        } catch (Throwable $e) {
            info(["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()]);
            return $this->responseWithError("Internal server error", null, 500, 500);
        }
    }

    public function show($id)
    {
        // ONLY ADMIN, MANAGER OR TEAM_MEMBOR
        try {
            $project = Project::with('team')->find($id);
            return $this->responseWithSuccess('Success', $project);

        } catch (Throwable $e) {
            info(["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()]);
            return $this->responseWithError("Internal server error", null, 500, 500);
        }
    }

    public function update(Request $request, Project $project)
    {
        // IF manager
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|regex:/^[a-zA-Z0-9\s]*$/"
                , 'title' => "required|regex:/^[a-zA-Z0-9\s\-]*$/"
                , 'desc' => "required"
                , 'url' => "string"
                , 'dev_url' => "string"
                , 'repo_url' => "string"
                , 'delivered_on' => "required|date|date_format:Y-m-d"
                , 'lead_by' => "required|integer|exists:users,id"
                , 'product_manager_id' => "required|integer|exists:users,id"
                , 'wip' => "integer"
                , 'created_by' => "required|integer|exists:users,id"
            ]);

            if ($validator->fails()) {
                return $this->responseWithError($validator->messages());
            }

            $new_project = $project::update($request->all());
            return $this->responseWithSuccess('New project created successfuly', [$new_project]);

        } catch (Throwable $e) {
            info(["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()]);
            return $this->responseWithError("Internal server error", null, 500, 500);
        }
    }

    public function destroy(Project $project)
    {

    }

    public function add_team_members()
    {
        // IF manager
        try {
            $validator = Validator::make(request()->all(), [
                'project_id' => 'required|exists:projects,id'
                , 'team' => [
                    "required", "array",
                    $validated_rule = new isTeam_membor_exist_inProject(request('project_id'), request('team'))
                ]
                , "team.*.user_id" => [
                    "required", "exists:users,id",
                ]
                , 'team.*.tech_label_id' => [
                    "required", "exists:tech_labels,id",
                ]

            ]);

            if ($validator->fails()) {
                return $this->responseWithError($validator->messages());
            }

            $project = $validated_rule->get_project();
            $project->team()->createMany($validated_rule->get_team_array());

            return $this->responseWithSuccess('Team members added successfuly, into Project', [$project->team]);

        } catch (Throwable $e) {
            info(["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()]);
            return $this->responseWithError("Internal server error", null, 500, 500);
        }

    }

    public function worksheets(Request $request, $project_id = null)
    {
        try {
            $project_worksheets =
                Worksheet::whereProject_id($project_id)->
                paginate(30)->appends(request()->all());

            return $this->responseWithSuccess('Success', $project_worksheets);

        } catch (Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);

        }
    }
}
