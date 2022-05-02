<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function getUsers (Request $request) {
        $allUsers = User::all();
        return response()->json($allUsers);
    }

    public function getUser (Request $request) {
        $match = ['email' => $request->email, 'password' => $request->password];
        $user = User::where($match)->get();
        return response()->json($user);
    }

    public function getUserPassword (Request $request) {
        $match = ['email' => $request->email];
        $user = User::where($match)->get();
        return response()->json($user);
    }

    public function addUser (Request $request) {
        $newUser = new User();
        $newUser->name = $request->firstName;
        $newUser->full_name = $request->firstName.' '.$request->lastName;
        $newUser->email = $request->email;
        $newUser->cpf = $request->cpf;
        $newUser->password = $request->password;
        $newUser->accesses = 'basic';
        $newUser->save();
        return response()->json($newUser);
    }

    public function editUser (User $user, Request $request) {
        $user->name = $request->name;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        if (isset($request->password)) {
            $user->password = $request->password;
        }
        if (isset($request->accesses)) {
            $user->accesses = $request->accesses;
        }

        $user->save();
        return response()->json($request);
    }

    public function deleteUser (User $user, Request $request) {
        $user->delete();
        return response()->json($user);
    }
}
