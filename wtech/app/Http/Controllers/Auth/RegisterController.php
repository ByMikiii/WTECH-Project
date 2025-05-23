<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class RegisterController extends Controller
{
  public function register(Request $request)
  {
    $validated = $request->validate([
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
      'email' => $validated['email'],
      'password' => Hash::make($validated['password']),
      'username' => null,
      'first_name' => null,
      'last_name' => null,
      'phone' => null,
      'street' => null,
      'city' => null,
      'postal_code' => null,
    ]);

    Auth::login($user);

    return response()->json(['message' => 'Používateľ zaregistrovaný!']);
    }
}
