<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function loginProcess(Request $req){
        $this->validate($req,[
            'email' => 'required|email',
            'password' => 'required'            
        ]);
       
        $credentials = $req->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->is_blocked) {        
                Auth::logout();
                return redirect('/login')->withErrors(['error' => 'Your account is blocked. Please contact support.']);
            }
            $user->login_attempts = 0;
            $user->save();
            return redirect('/');
        } else {
            $user = User::where('email', $req->email)->first();
            if ($user) {
                $user->increment('login_attempts');
                if ($user->login_attempts >= 3) {
                    $user->is_blocked = true;
                    $user->save();
                    return redirect('/login')->withErrors(['error' => 'Your account has been blocked due to multiple failed login attempts. Please contact support.']);
                }
            }
            return redirect('/login')->withErrors(['error' => 'The email or password you entered is incorrect. Please try again.']);
        }
    }
}
