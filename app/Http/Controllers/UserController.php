<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            "status" => 200,
            "message" => "data successfully sent",
            "users" => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
            'email' =>'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($request->all());

        return response()->json([
            "status" => 201,
            "message" => "$user->name is successfully registered"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return response()->json([
            "status" => 200,
            "message" => "data successfully sent",
            "user" => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' =>'string',
            'email' =>'email',
            'password' => 'confirm',
        ]);

        $user = User::find($id);

        if(!$user){
            return response()->json([
                "status" => 404,
                "message" => "Account not found"
            ], 404);
        }

        $user->update($request->all());

        return response()->json([
            "status" => 200,
            "message" => "User updated successfully",
            "user" => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                "status" => 404,
                "message" => "Account not found"
            ], 404);
        }

        $user->delete();

        return response()->json([
            "status" => 200,
            "message" => "User deleted successfully"
        ]);
    }

    /** 
     * Login to the user
     */
    public function login(Request $request){
        $request->validate([
            'email' =>'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                "status" => 404,
                "message" => "Account not found"
            ], 404);
        }

        if(!Hash::check($request['password'], $user->password)){
            return response()->json([
                "status" => 401,
                "message" => "Invalid password"
            ], 401);
        }

        $token = $user->createToken('aut_token')->plainTextToken;

        return response()->json([
            "status" => 200,
            "message" => "Successfully logged in",
            "token" => $token,
            "user" => $user,
        ]);
    }

    public function logout() {
        auth("sanctum")->user()->tokens()->delete();
        return response()->json([
            "status" => 200,
            "message" => "berhasil logout",
            "token" => "null",
            "token_type" => "null"
        ]);
    }
}
