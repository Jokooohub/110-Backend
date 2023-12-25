<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Login using specified resources
    public function login(UserRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $response = [
            'user'  => $user,
            'token' => $user->createToken($request->email)->plainTextToken
        ];
        return $response;
    }

    // Logout using specified resources
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'message' => 'Logout.'
        ];
        return $response;
    }

    public function loginAdmin(AdminRequest $request)
    {

        $admins = Admin::where('name', $request->name)->first();

        if (!$admins || !Hash::check($request->password, $admins->password)) {
            throw ValidationException::withMessages([
                'name' => ['The provided credentials are incorrect.'],
            ]);
        }

        $response = [
            'admin'  => $admins,
            'token' => $admins->createToken($request->name)->plainTextToken
        ];
        return $response;
    }
}