<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller{
    public function showForgotPasswordForm(Request $request) {
        return view('pages.forgot_password', ['title' => 'NaNohu - Obnova hesla']);
    }

    public function sendResetLink(Request $request){
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        $resetLink = url("/reset_password/$token");
        
        //toto nie je funkcne, pokial v env subore nebudu MAIL udaje
        Mail::raw("Klikni pre obnovu hesla: $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Obnova hesla');
        });

        return redirect("/reset_password/$token"); //a tym padom je pouzivatel hned presmerovany
    }

    public function showResetForm($token) {
        return view('pages.reset_password', ['title' => 'NaNohu - Obnova hesla','token' => $token]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Token je neplatný alebo vypršal.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Heslo bolo úspešne zmenené.');
    }
}