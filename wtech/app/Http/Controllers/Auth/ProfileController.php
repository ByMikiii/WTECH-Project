<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;


class ProfileController extends Controller
{
    public function edit_profile(Request $request){

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'username' => [
                'nullable',
                'string',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'phone' => [
                'nullable',
                'string',
                Rule::unique('users')->ignore(Auth::id()),
            ],
        ]);

        $otherData = $request->only(['first_name', 'last_name', 'city', 'postal_code', 'street']);

        $user = Auth::user();

        $user->update(array_merge($validated, $otherData));
        
        return response()->json(['message' => 'Úspešná zmena údajov']);
    }
}
