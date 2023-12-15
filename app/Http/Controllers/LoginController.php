<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $check = Admin::select(['username'])->where('username', $request->username)->first();

        if($check) {
            if(!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect()->back()->with('danger', 'Username atau password salah');
            }
    
            if(Auth::check()) {
                return redirect()->route('dashboard');
            }else{
                return redirect()->back()->with('danger', 'Username atau password salah');
            }
        }

        return redirect()->back()->with('danger', 'Username atau password salah');
    }

    public function logout() 
    {
        if(Auth::check()) Auth::logout();

        return redirect('/');
    }
}