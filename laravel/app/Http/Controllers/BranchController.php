<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Traits\JsonUtilTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /// TODO:ROLE MANAGER, HR, OPERATIONS
    use JsonUtilTrait;

    public function index()
    {
        try {
            /// TODO:ROLE manager|admin can retrieve all Branches
            $branches =
                Branch::paginate(10)->appends(request()->all());

            return $this->responseWithSuccess('Success', $branches);

        } catch (\Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);
        }
    }

    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                "location" => "required|string|regex:/^[a-zA-Z0-9\s\-]*$/",
                "city" => "required|string|regex:/^[a-zA-Z0-9\s\-]*$/",
                "mobile" => "required",
                "address" => "required|string"
            ]);

            if ($validator->fails()) {
                return $this->responseWithError($validator->messages());
            }

            $new_branch = Branch::create(request()->only(['location', 'city', 'mobile', 'address']));

            return $this->responseWithSuccess('New Branch created successfuly', [$new_branch]);

        } catch (\Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);

        }
    }

    public function users(Request $request, $branch_id)
    {
        try {
            /// TODO:ROLE manager|admin can retrieve all Branches
            $branches =
                User::with('branch')->
                addSelect([
                    'users.id', 'users.name', 'users.email', 'users.mobile', 'users.role_id', 'users.reporting_to', 'users.branch_id',
                ])->
                paginate(10)->
                appends(request()->all());

            return $this->responseWithSuccess('Success', $branches);

        } catch (\Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);
        }

    }

    public function show(Branch $branch)
    {
        try {
            return $this->responseWithSuccess('Success', $branch);

        } catch (\Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);
        }
    }

    public function update(Request $request, Branch $branch)
    {
    }

    public function destroy(Branch $branch)
    {
    }
}
