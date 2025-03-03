<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        return view('login_page');
    }

    public function registerBlade()
    {
        return view('register_page');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Password and confirm password not matched.',
        ]);

        $adduser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($adduser) {
            Auth::login($adduser);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User Registration Successful',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Email is invalid.',
            'password.required' => 'Password is required.',
        ]);
        // $user  = User::where('email', $request->email)->get();
        $user = User::where('email', $request->email)->first();

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            return response()->json([
                'status' => 200,
                'message' => 'Login Successful',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Invalide Email or Password',
            ]);
        }
    }

    public function logout()
    {
        Session::flush();

        return response()->json([
            'status' => 200,
            'message' => 'Logout Successfull',
        ]);
    }
}
