<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;

class CommissionController extends Controller
{

    public function getCommissions (Request $request) {
        $allCommissions = Commission::all();
        return response()->json($allCommissions);
    }

    public function getComission (Commission $commission, Request $request) {
        return response()->json($commission);
    }

    public function addCommission (Request $request) {
        $newCommission = new Commission();
        $newCommission->date = $request->date;
        $newCommission->product = $request->product;
        $newCommission->value = $request->value;
        $newCommission->indicator = $request->indicator;
        $newCommission->seller = $request->seller;
        $newCommission->operator = $request->operator;
        $newCommission->indicator_commission = 0.20;
        $newCommission->seller_commission = 0.40;
        $newCommission->operator_commission = 0.10;

        $newCommission->save();
        return response()->json($newCommission);
    }

    public function editCommission (Commission $commission, Request $request) {
        $commission->date = $request->date;
        $commission->product = $request->product;
        $commission->value = $request->value;
        $commission->indicator = $request->indicator;
        $commission->seller = $request->seller;
        $commission->operator = $request->operator;


        $commission->save();
        return response()->json($commission);
    }

    public function deleteCommission (Commission $commission, Request $request) {
        $commission->delete();
        return response()->json($commission);
    }
}
