<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemCom;

/* 
    Codes List:
    [
        {0: 'Dashboard Data Update'}
    ]

*/

class SystemComsController extends Controller
{
    public function getSystemCom(Request $request)
    {
        $result = SystemCom::where('code', $request->code)->first();
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    public function addSystemCom(Request $request)
    {
        $newSystemCom = new SystemCom();
        $newSystemCom->code = $request->code;
        $newSystemCom->save();
        return true;
    }

    public function editSystemCom(SystemCom $system_com, Request $request)
    {
        $system_com->code = $request->code;
        $system_com->save();
        return true;
    }

    public function deleteSystemCom(SystemCom $system_com, Request $request)
    {
        $system_com->delete();
        return true;
    }
}
