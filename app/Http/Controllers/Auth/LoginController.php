<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;
use Hash;
use Session;
use App\User;

class LoginController extends Controller
{
    
    public function login_view()
    {
        if (Auth::check()) {
            return back();
        }else {
            return view('auth.login');
        }
    }

    // public function login_pos
    public function login_post(Request $request){
        $nip        = $request->nip;
        $password   = $request->password;
    
        $data = User::where('nip', $nip)->first();
    
        if ($data) {
            if (Hash::check($password, $data->password)) {
                Auth::login($data);
                
                if ($data->role == 'admin') {
                    return redirect('/');
                } else {
                    return redirect('/catat-meter-gas');
                }
            } else {
                return redirect('login')->with('alert', 'NIP atau Password, Salah !');
            }
        } else {
            return redirect('login')->with('alert', 'Akun Tidak Terdaftar');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

}
