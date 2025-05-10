<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
  public function showLoginForm(Request $request)
  {
    return view('pages.login', ['title' => 'NaNohu - Prihlásenie']);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      return redirect()->intended('/')->with('notification', 'Prihlásenie bolo úspešne!');
      ;
    } else {
      return back()->withErrors([
        'email' => 'Tieto prihlasovacie údaje sú nesprávne.',
      ]);
    }
  }

  public function logout()
  {
    Auth::logout();
    return redirect('/')->with('notification', 'Odhlásenie bolo úspešné!');
  }
}
