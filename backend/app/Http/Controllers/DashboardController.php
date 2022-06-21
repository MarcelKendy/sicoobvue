<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;


class DashboardController extends Controller
{

    public function getCardDoneCommissions (Request $request) {
        $this_week = date("Y-m-d", strtotime('monday this week'));
        $doneCommissions[0] = Commission::
            selectRaw("status, DATE(date_operator) as date_operator")
            ->whereRaw("status = 'Aprovado Ups' AND
                CAST(date_operator as date) >= CAST('".$this_week."' as date)")
            ->get()->toArray();


        return response()->json($doneCommissions);
    }

}
