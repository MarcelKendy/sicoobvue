<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access;


class AccessController extends Controller
{

    public function getAccesses (Request $request) {
        $allAccesses = Access::with('user')->get();
        foreach ($allAccesses as $key => $access) {
            $allAccesses[$key]['accesses'] = json_decode($access['accesses']);
        }
        return response()->json($allAccesses);
    }

    public function getAccess (Access $access, Request $request) {
        $access->accesses = json_decode($access->accesses);
        return response()->json($access);
    }


    public function addAccess (Request $request) {
        $newAccess = new Access();
        $newAccess->name = $request->name;
        $newAccess->accesses = json_encode($request->accesses);
        $newAccess->user_id = $request->user_id;
        $newAccess->save();
        return response()->json($newAccess);
    }

    public function editAccess (Access $access, Request $request) {
        $access->name = $request->name;
        $access->accesses = json_encode($request->accesses);
        $access->save();
        return response()->json($request);
    }

    public function deleteAccess (Access $access, Request $request) {
        $access->delete();
        return response()->json($access);
    }
}
