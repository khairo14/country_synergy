<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    //
    public function signIn(Request $request){
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // DD($request->email,$request->password);
        // $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            // $user = 'asd';
            $request->session()->regenerate();

            return redirect()->intended('home');
        }
        // dd($user = Auth::user());

        return back();
    }

    public function signOut(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

}
