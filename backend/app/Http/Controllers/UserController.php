<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogLogin;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class UserController extends Controller
{

    public function getUsers(Request $request)
    {

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

        $allUsers = User::with('access', 'role')->select($select)->whereRaw($where)->get();
        return response()->json($allUsers);
    }

    public function getUser(Request $request)
    {
        $match = ['email' => $request->email];
        $user = User::with('access', 'role')->where($match)->get();
        if (isset($user[0]['password'])) {
            if ($user[0]['active'] != 1) {
                return 606;
            }
            if (password_verify($request->password, $user[0]['password'])) {
                $log_login = new LogLogin();
                $log_login->user_id = $user[0]['id'];
                $log_login->status = 1;
                $log_login->save();
                return response()->json($user);
            } else {
                return 505;
            }
        } else {
            return 404;
        }
    }

    public function getProfile(Request $request)
    {
        $user = User::select('id', 'full_name', 'email', 'cpf', 'photo', 'role_id', 'gender', 'active', 'access_id', 'agency', 'address', 'phone', 'phone_corporation', 'profile_about')->with('access:id,name', 'role')->find($request->user_id)->toArray();
        if ($user) {
            $session_active = false;
            $latest_logged_in = LogLogin::select('id')->where('user_id', $user['id'])->where('status', 1)->latest('created_at')->first();
            if ($latest_logged_in) {
                $latest_logged_out = LogLogin::select('id')->where('user_id', $user['id'])->where('status', 0)->where('id', '>', $latest_logged_in->id)->first();
                $session_active = !$latest_logged_out;
            }
            $user['logged'] = $session_active;
            return response()->json($user);
        }
        return 404;
    }

    public function getUserPassword(Request $request)
    {
        $match = ['email' => $request->email];
        $user = User::select('password')->where($match)->get();
        return response()->json($user);
    }

    public function addLogLogin(Request $request)
    {
        $log_login = new LogLogin();
        $log_login->user_id = $request->user_id;
        $log_login->status = $request->status;
        $log_login->save();
        return response()->json($log_login);
    }

    public function addUser(Request $request)
    {
        $newUser = new User();
        $newUser->active = 1;
        $newUser->gender = $request->gender;
        $newUser->name = $request->firstName;
        $newUser->full_name = $request->firstName . ' ' . $request->lastName;
        $newUser->email = $request->email;
        $newUser->cpf = $request->cpf;
        $newUser->role = $request->role;
        $newUser->password = password_hash($request->password, PASSWORD_DEFAULT);
        $newUser->access_id = 1;
        $newUser->profile_about = 'Eu conecto pessoas para promover justiça financeira e prosperidade.';
        $newUser->configs = '{"theme":1}';
        $newUser->save();
        return response()->json($newUser->load('access', 'role'));
    }

    public function editUser(User $user, Request $request)
    {
        if (isset($request->configs) && $request->configs == 'change') {
            $configs = json_decode($user->configs);
            if (isset($request->theme)) {
                $configs->theme = $request->theme;
            }
            $user->configs = json_encode($configs);
            $user->save();
            return response()->json($user->load('access', 'role'));
        }
        $name = substr($request->full_name, 0, strpos($request->full_name, " "));
        $user->name = $name;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;

        if (isset($request->active)) {
            $user->active = $request->active;
        }
        if (isset($request->password) && !empty($request->password)) {
            $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        }
        if (isset($request->access_id) && !empty($request->access_id)) {
            $user->access_id = $request->access_id;
        }
        if (isset($request->role_id) && !empty($request->role_id)) {
            $user->role_id = $request->role_id;
        }
        if (isset($request->profile_about) && !empty($request->profile_about)) {
            $user->profile_about = $request->profile_about;
        }
        if (isset($request->gender) && !empty($request->gender)) {
            $user->gender = $request->gender;
        }

        $user->save();
        return response()->json($user->load('access', 'role'));
    }

    public function editProfile(User $user, Request $request) {
        $user->profile_about = $request->profile_about;
        $user->save();
        return true;
    }

    public function editUserAccess(User $user, Request $request)
    {
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
        return response()->json($user->load('access', 'role'));
    }

    public function deleteUser(User $user, Request $request)
    {
        $user->delete();
        return response()->json($user);
    }

    public function addAvatar()
    {
        return view('add_avatar');
    }
    
    public function storeAvatar(Request $request)
    {

        $user = User::find($request->user_id);
        $user->photo = $request->file('photo')->store('uploads/avatars/' . $user->cpf);
        $user->save();

        return response()->json($user->load('access', 'role'));
    }
    
    public function getAvatar()
    {
        return view('view_avatar');
    }
}
