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
                'regex:/^\+421\d{9}$/',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'postal_code' => [
                'nullable',
                'regex:/^\d{5}$/',
            ],
            'first_name' => [
                'nullable',
                'regex:/^[\p{L}\s\-\'\.]+$/u',
            ],
            'last_name' => [
                'nullable',
                'regex:/^[\p{L}\s\-\'\.]+$/u',
            ],
            'city' => [
                'nullable',
                'regex:/^[\p{L}\s\-\'\.]+$/u',
            ],
            'street' => [
                'nullable',
                'string',
            ],
        ]);

        $user = Auth::user();

        $user->update($validated);
        
        return response()->json(['message' => 'Úspešná zmena údajov']);
    }

    public function change_password(Request $request){
        
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6'],
        ]);
        
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Nesprávne aktuálne heslo']);
        }
        
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
    
        return response()->json(['message' => 'Heslo bolo úspešne zmenené']);
    }
}
