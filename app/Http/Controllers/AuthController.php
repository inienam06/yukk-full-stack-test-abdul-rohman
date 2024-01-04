<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function login() {
        return view('login');
    }

    public function register() {
        return view('register');
    }

    public function do_register() {
        request()->validate([
            'name' => 'required|string|max:75',
            'email' => 'required|string|max:100|unique:tbl_user,email',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
        ]);

        session()->flash('success', 'Successfully Registered');
        return redirect()->route('login');
    }

    public function authenticate() {
        request()->validate([
            'email' => 'required|exists:tbl_user,email',
            'password' => 'required'
        ]);
        
        if(auth()->attempt(request()->only(['email', 'password']))) {
            session()->flash('success', 'Login Succeed');
            return redirect()->intended(route('home'));
        }

        session()->flash('fail', 'E-mail or password does not match');
        return redirect()->back()->with(request()->all());
    }

    public function logout() {
        auth()->logout();
        session()->flash('fail', 'Logout Success');
        return redirect()->route('login');
    }
}
