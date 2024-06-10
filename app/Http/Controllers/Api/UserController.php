<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateUserRequest;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request){
        // Update Logged in User Data
        return $request->update();
    }
}
