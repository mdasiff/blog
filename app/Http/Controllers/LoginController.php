<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
    	$rule = [
            //'email'   => 'required|email:exists',
            'email'   => 'required',
            'password'   => 'required|min:6',
        ];

        $this->validate($request, $rule);


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return back()->with('success', 'Successfully logedin.');
        }
        
        return back()->with('error', 'Sorry! Wrong credentials.');
    }
    public function logout()
    {
    	Auth::logout();

        return back()->with('success', 'Successfully logedout.');
    }
}
