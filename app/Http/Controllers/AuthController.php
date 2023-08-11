<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'birthday' => 'required|date',
            ]);

            \Log::info($request->all());

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->birthday = $request->birthday;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->remember_token = $user->createToken('API')->plainTextToken;
            $user->save();

            DB::commit();

            return response()->json(['user' => $user], 201);
        } catch (\Exception $e) {
            DB::rollback();

            $data = [
                'message' => 'User Registration Failed!',
                'error' => $e->getMessage(),
            ];

            return response()->json($data, 409);
        }
    }

    /*public function __construct()
    {
        $this->middleware('auth');
    }*/



}
