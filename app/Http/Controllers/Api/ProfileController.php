<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController
{

    public function update(Request $request): JsonResponse
    {
        $bloodTypes=["A+","A-","B+","B-","AB+","AB-","O+","O-"];

        $request->validate([
            'name'=> ['required', 'string'],
            'gender'=> ['required', Rule::in(['male', 'female'])],
            'blood_type'=> ['required', Rule::in($bloodTypes)]
        ]);

        $user = User::query()
            ->where("id", $request->user()->id)
            ->update([
                'name' => $request->input("name"),
                'gender' => $request->input("gender"),
                'blood_type' => $request->input("blood_type"),
            ]);

        return response()->json([
            'message' =>'Registration Successful',
            'data'=> $user
        ]);
    }

    public function add(Request $request, Certificate $certificate): JsonResponse
    {
        $request->user()->certificates()->save($certificate);

        return response()->json([
            'message' =>'success'
        ]);
    }

    public function remove(Request $request, Certificate $certificate): JsonResponse
    {
        $request->user()->certificates()->detach($certificate->id);

        return response()->json([
            'message' =>'success'
        ]);
    }
}
