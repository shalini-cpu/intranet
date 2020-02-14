<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Traits\JsonUtilTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Throwable;

class ApiAuthController extends Controller
{
    use JsonUtilTrait;

    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // return $request->all();
        try {
            $input = $request->only('email', 'password');
            $token = null;
            if (!$token = JWTAuth::attempt($input)) {
                return $this->responseWithError('Invalid Email or Password');
            }
            return $this->responseWithSuccess('Login successful', ['token' => $token, 'user' => auth()->user()]);
        } catch (JWTException $th) {
            info(["Error" => $th]);
            return $this->responseWithError('Could not Create TOKEN!', $th, 500, 500);
        } catch (Throwable $th) {
            info(["Line:" => $th->getLine(), "Message:" => $th->getMessage(), "Code:" => $th->getCode()]);
            return $this->responseWithError('Could not Create TOKEN!', $th, 500, 500);
            //throw $th;
        }
    }

    /** Only for Dev Env
     * @param RegistrationFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "email" => 'required|email|unique:users,email',
                "password" => "required",
                "emp_id" => "required|unique:users,emp_id",
                "role_id" => "required|exists:roles,id",
                "user_type" => "required"
            ]);

            if ($validator->fails()) {
                return $this->responseWithError("Validation Error", $validator->messages(), 400);
            }

            $user = User::create($request->all());
            $user->password = bcrypt($request->password);
            $user->save();

            if ($this->loginAfterSignUp) {
                return $this->login($request);
            }

            return $this->responseWithSuccess('Success', [$user]);
        } catch (Throwable $th) {
            info(["Line:" => $th->getLine(), "Message:" => $th->getMessage(), "Code:" => $th->getCode()]);
            return $this->responseWithError('Could not create user!', [], 500, 500);
            //throw $th;
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            return $this->responseWithSuccess('success', ['user' => auth()->user()]);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return $this->responseWithError('Internal server error!', [], 500, 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
            return $this->responseWithSuccess('success', ['user' => auth()->user()]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->responseWithError('Internal server error!', [], 500, 500);
        }
    }

}
