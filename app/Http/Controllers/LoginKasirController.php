<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kasir;
use Auth;

class LoginKasirController extends Controller
{
    public function viewLogin()
    {
        return view('login_kasir');
    }

    public function login(Request $request)
    {
        $check = Kasir::select(['username'])->where('username', $request->username)->first();

        if($check) {
            if(!Auth::guard('kasir')->attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect()->back()->with('danger', 'Username atau password salah');
            }
    
            if(Auth::guard('kasir')->check()) {
                return redirect()->route('cashier_barang');
            }else{
                return redirect()->back()->with('danger', 'Username atau password salah');
            }
        }

        return redirect()->back()->with('danger', 'Username atau password salah');
    }

    public function logout() 
    {
        if(Auth::guard('kasir')->check()) Auth::guard('kasir')->logout();

        return redirect('/');
    }
}