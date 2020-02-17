<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonUtilTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    use JsonUtilTrait;

    public function index()
    {
        $users =
            User::orderBy('users.created_at', 'desc')
                ->paginate(40)
                ->appends(request()->all());
        return $this->responseWithSuccess('Success', $users);
    }

    function store(Request $request)
    {
        // TODO:ROLE ONLY Manager|HR|OPERATION
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|regex:/^[a-zA-Z0-9\s]*$/"
                , "email" => "email|required"
                , 'password' => "required"
                , 'role_id' => "required|integer|exists:roles,id"
                , 'phone' => 'required'
                , 'mobile' => 'nullable'
                , 'emer_contact_no' => 'nullable'
                , 'emer_contact_name' => 'nullable'
                , 'designation' => 'required|string'
                , 'dob' => 'required|date|date_format:Y-m-d"'
                , 'doj' => 'required|date|date_format:Y-m-d"'
                , 'hire_date' => 'required|date|date_format:Y-m-d'
                , 'emp_id' => 'required|unique:users,emp_id'
//                , 'resignation_date' =>  'required|date|date_format:Y-m-d' \\ TODO:PENDING Search
                , 'city' => 'required|string'
                , 'address' => 'required|string'
                , 'reporting_to' => "required|integer|exists:users,id"
                , 'bg' => 'nullable'
                , 'profile_pic' => 'nullable'
                , 'resume_url' => 'nullable'
                , 'branch_id' => 'required|integer|exists:branches,id'
                , 'current_salary' => 'required'
                , 'user_type' => 'nullable'
            ]);

            if ($validator->fails()) {
                return $this->responseWithError($validator->messages());
            }

            $new_user = User::create($request->all());
            return $this->responseWithSuccess('New User created successfuly', [$new_user]);

        } catch (Throwable $e) {
            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);
        }
    }

    public function show(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }


    /// User Fulltext Search (Email,fName,Lname,mobile,email)
    public function serach(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                "keywords" => "required|string|max:255"
            ]);

            if ($validator->fails()) {
                return $this->responseWithError("validation error", $validator->messages(), [request()->all()]);
            }

            $keywords = request('keywords');

            if ($keywords) {
                // Search DB
                $user_found =
                    User::
                    whereRaw(
                        "MATCH (users.name,email,mobile,emp_id,branch_id) AGAINST (? IN BOOLEAN MODE)",
                        $this->fullTextWildcards($keywords)
                    )->
                    with('tech_labels.tech_label')->
                    select(['users.id', 'users.name', 'users.email', 'users.mobile', 'users.designation', 'users.emp_id',])->
                    paginate(30)->
                    appends(request()->all());

                if ($user_found) {
                    return $this->responseWithSuccess("Search results", $user_found);
                }
            }

            return $this->responseWithError('input Error', $validator->messages());

        } catch (QueryException $e) {
            info(["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()]);
            return $this->responseWithError("Insertnal server error", [], 400, 400);
        } catch (Throwable $e) {

            $info_msg = ["Line:" => $e->getLine(), "Message:" => $e->getMessage(), "Code:" => $e->getCode()];
            info($info_msg);

            if (config('app.env') === 'local') {
                return $this->responseWithError("Internal server error", $info_msg, 500, 500);
            }
            return $this->responseWithError("Internal server error", [], 500, 500);
        }

//        $user_found = User::
//        whereRAW("MATCH(name,description) AGAINST(? IN BOOLEAN MODE)", array($search))
//            ->orWhereRAW('id IN (SELECT project_id FROM roles JOIN users ON user.id = roles.user_id WHERE MATCH(username, first_name, last_name) AGAINST(? IN BOOLEAN MODE))', array($search));
//        ->
//        orWhereRaw('');
    }

    //// Fulltext search helper
    protected function fullTextWildcards($term)
    {
        try {

            // removing symbols used by MySQL
            $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
            $term = str_replace($reservedSymbols, '', $term);

            $words = explode(' ', $term);

            foreach ($words as $key => $word) {
                /*
                 * applying + operator (required word) only big words
                 * because smaller ones are not indexed by mysql
                 */
                if (strlen($word) >= 3) {
                    $words[$key] = '*' . $word . '*';
                }
            }
            return implode(' ', $words);

        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->responseWithError("Insertnal server error", [], 400, 400);
        }
    }


}
