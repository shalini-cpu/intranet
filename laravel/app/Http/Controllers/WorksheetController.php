<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonUtilTrait;
use App\Project;
use App\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorksheetController extends Controller
{
    use JsonUtilTrait;

    public function index()
    {
        return 'worksheet Index';
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title" => "required|string|regex:/^[a-zA-Z0-9\s\-]*$/",
                "desc" => "nullable|string",
                "hours_spend" => "required|numeric",
                "date" => "required|date|date_format:Y-m-d",
                "task_type" => "nullable|string",
                "stack" => "nullable|string",
//                "user_id" => "required|exists:users.id",
                "project_id" => "required|exists:projects,id",
                "priority" => "nullable",
                "status" => "nullable",
            ]);

            if ($validator->fails()) {
                return $this->responseWithError($validator->messages());
            }

            $request->merge(['user_id' => auth()->id()]);

            $project = Project::find(request('project_id'));
            $new_worksheet = $project->worksheets()->create($request->all());

            return $this->responseWithSuccess('New worksheet created successfuly', [$new_worksheet]);

        } catch (Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);

        }
    }

    public function show(Worksheet $worksheet)
    {

    }

    public function update(Request $request, Worksheet $worksheet)
    {
        //
    }

    public function destroy(Worksheet $worksheet)
    {
        //
    }
}
