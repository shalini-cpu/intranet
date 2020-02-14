<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonUtilTrait;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonUtilTrait;

    public function index()
    {
        $users =
                User::orderBy('users.created_at', 'desc')
                    ->paginate(40)
                    ->appends(request()->all())
            ;
            return $this->responseWithSuccess('Success', $users);
    }

    public function create()
    {
        
    }
    
    function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
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
}
