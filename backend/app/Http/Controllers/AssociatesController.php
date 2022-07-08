<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Associate;


class AssociatesController extends Controller
{
    public function getAssociates(Request $request)
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

        $allAssociates = Associate::select($select)->whereRaw($where)->get();
        return response()->json($allAssociates);
    }
}
