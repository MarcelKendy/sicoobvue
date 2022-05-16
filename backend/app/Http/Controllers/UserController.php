<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogLogin;

class UserController extends Controller
{

    public function getUsers (Request $request) {

        if (isset($request->select)) {
            $select = $request->select;
        } else {
            $select = '*';
        }
        if (isset($request->where)) {
            $where = $request->where;
        } else {
            $where = 'true';
        }

        $allUsers = User::select($select)->whereRaw($where)->get();
        return response()->json($allUsers);
    }

    public function getUser (Request $request) {
        $match = ['email' => $request->email];
        $user = User::where($match)->get();
        if (isset($user[0]['password'])) {
            if (password_verify($request->password, $user[0]['password'])) {
                $user[0]['accesses'] = json_decode($user[0]['accesses']);
                $log_login = new LogLogin();
                $log_login->user_id = $user[0]['id'];
                $log_login->save();
                return response()->json($user);
            } else {
                return 505;
            }
        } else {
            return 404;
        }
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
        $newUser->password = password_hash($request->password, PASSWORD_DEFAULT);
        $accesses = json_encode(array('commissions' => 'basic'));
        $newUser->accesses = $accesses;
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
