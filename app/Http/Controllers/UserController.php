<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create($fields);

        $token = $user->createToken('myappToken')->plainTextToken;

        $response = authResponse($user, $token);


        return response($response, 201);
    }

    public function login(LoginRequest $request)
    {

        $fields = $request->validated();

        if (Auth::guard('web')->attempt($fields)) {

            $user = Auth::user();

            $token = $user->createToken('myappToken')->plainTextToken;

            $response = authResponse($user, $token);

            return response($response, 201);
        } else {
            throw ValidationException::withMessages([
                'Error' => ['Invalid credentials'],
            ]);
        }
    }

    public function update(UpdateRequest $request)
    {
        $fields = $request->validated();
        $user = $request->user();

        $user->update($fields);

        return success(['message' => 'User details updated successfully.']);
    }

    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return $users;
    }

}
