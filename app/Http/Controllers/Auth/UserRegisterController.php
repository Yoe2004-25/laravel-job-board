<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Events\UserRegister;
use Illuminate\Support\Facades\Hash; 

class UserRegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:225',
            'email'=>'required|string|email|max:225|unique:users',
            'password'=>'required|string|min:8|max:15',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),  
        ]);

        event(new UserRegister($user));

        return response()->json(['message' => 'User registered successfully'], 201);
    }
}