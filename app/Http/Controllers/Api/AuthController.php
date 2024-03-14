<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable',
        ]);

        $user = User::query()->where('email', $request->email)->first();

        if (! $user || ! $user->is_approved || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name ?? Str::random(10));

        return response()->json([
            'message' =>'success',
            'token'=> $token->plainTextToken
        ]);
    }

    public function register(Request $request){

        $bloodTypes=["A+","A-","B+","B-","AB+","AB-","O+","O-"];

        $request->validate([
            'name'=> ['required', 'string'],
            'email'=> ['required', 'email', 'unique:users'],
            'password'=> ['required'],
            'gender'=> ['required', Rule::in(['male', 'female'])],
            'blood_type'=> ['required', Rule::in($bloodTypes)]
        ]);

        $user = User::query()
            ->create([
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'password' => Hash::make($request->input("password")),
                'gender' => $request->input("gender"),
                'blood_type' => $request->input("blood_type"),
            ]);

        return response()->json([
            'message' =>'Registration Successful',
            'data'=> $user
        ]);
    }

    public function approve(Request $request, User $user){

        $user->update([
            "is_approved" => true
        ]);

        return response()->json([
            'message' => 'User Approved',
            'data'=> $user
        ]);
    }
}
