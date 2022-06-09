<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogLogin;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

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

        $allUsers = User::with('access')->select($select)->whereRaw($where)->get();
        return response()->json($allUsers);
    }

    public function getUser (Request $request) {
        $match = ['email' => $request->email];
        $user = User::with('access')->where($match)->get();
        if (isset($user[0]['password'])) {
            if ($user[0]['active'] != 1) {
                return 606;
            }
            if (password_verify($request->password, $user[0]['password'])) {
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
        $user = User::with('access')->where($match)->get();
        return response()->json($user);
    }

    public function addUser (Request $request) {
        $newUser = new User();
        $newUser->active = 1;
        $newUser->gender = $request->gender;
        $newUser->name = $request->firstName;
        $newUser->full_name = $request->firstName.' '.$request->lastName;
        $newUser->email = $request->email;
        $newUser->cpf = $request->cpf;
        $newUser->role = $request->role;
        $newUser->password = password_hash($request->password, PASSWORD_DEFAULT);
        $newUser->access_id = 1;
        $newUser->configs = '{"theme":1}';
        $newUser->save();
        return response()->json($newUser->load('access'));
    }

    public function editUser (User $user, Request $request) {
        if (isset($request->configs) && $request->configs == 'change') {
            $configs = json_decode($user->configs);
            if (isset($request->theme)) {
                $configs->theme = $request->theme;
            }
            $user->configs = json_encode($configs);
            $user->save();
            return response()->json($user->load('access'));
        }
        $name = substr($request->full_name, 0, strpos($request->full_name, " "));
        $user->name = $name;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->role = $request->role;


        /*if (isset($request->photo) && $request->photo) {
            $photo_name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$photo_name);
            $request->merge(['photo' => $photo_name]);
            $user->photo = $photo_name;
        }*/



        if (isset($request->active)) {
            $user->active = $request->active;
        }
        if (isset($request->password) && !empty($request->password)) {
            $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        }
        if (isset($request->access_id) && !empty($request->access_id)) {
            $user->access_id = $request->access_id;
        }
        if (isset($request->gender) && !empty($request->gender)) {
            $user->gender = $request->gender;
        }

        $user->save();
        return response()->json($user->load('access'));
    }

     public function editUserAccess (User $user, Request $request) {
        if (isset($request->access_id) && !empty($request->access_id)) {
            $user->access_id = $request->access_id;
        }
        if (isset($request->active) && $request->active != -1) {
            if ($request->active == 1) {
                $user->active = 0;
            } else {
                $user->active = 1;
            }
        }
        $user->save();
        return response()->json($user->load('access'));
    }

    public function deleteUser (User $user, Request $request) {
        $user->delete();
        return response()->json($user);
    }

    public function addAvatar(){
        return view('add_avatar');
    }
    //Store image
    public function storeAvatar(Request $request){

        $user = User::find($request->user_id);
        $user->photo = $request->file('photo')->store('uploads/avatars/'.$user->cpf);
        $user->save();

        return response()->json($user->load('access'));
    }
	//View image
    public function getAvatar(){
        return view('view_avatar');
    }

}
