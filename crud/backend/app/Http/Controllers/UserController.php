<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();

        // Return Json Response
        return response()->json([
            'results' => $users
        ], 200);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            // Create User
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Return Json Response
            return response()->json([
                'message' => "User successfully created."
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    public function show($id)
    {
        // User Detail
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => "User not found."
            ], 404);
        }

        // Return Json Response
        return response()->json([
            'users' => $user
        ], 200);
    }


    public function update(UserStoreRequest $request, $id)
    {
        try {
            // Find user
            $user = User::find($id);
            if (!$user) {
                return User()->json([
                    'message' => 'User not found'
                ], 404);
            }

            // echo request
            $user->name = $request->name;
            $user->email = $request->email;

            // Upadate User
            $user->save();

            // Return Json Response
            return response()->json([
                'message' => 'User successfully updated.'
            ], 200);
        } catch (\Throwable $th) {
            // Return json response
            return response()->json([
                'message' => 'Something went really wrong'
            ], 500);
        }
    }

    public function destroy($id)
    {
        // Find user
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // Delete user
        $user->delete();

        // Return Json Response
        return response()->json([
            'message' => 'User sucessfully deleted.'
        ], 200);
    }
}
