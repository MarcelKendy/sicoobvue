<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;

class CommissionController extends Controller
{

    public function getCommissions(Request $request)
    {
        $allCommissions = Commission::all();
        return response()->json($allCommissions);
    }

    public function getComission(Commission $commission, Request $request)
    {
        return response()->json($commission);
    }

    public function addCommission(Request $request)
    {
        $newCommission = new Commission();
        $newCommission->user_id = $request->user_id;
        $newCommission->date = $request->date;
        $newCommission->product = $request->product;
        $newCommission->value = $request->value;
        $newCommission->indicator = $request->indicator;
        $newCommission->seller = $request->seller;
        $newCommission->operator = $request->operator;
        $newCommission->status = $request->status;
        if ($request->custom_value) {
            $newCommission->custom_value = $request->custom_value;
            $value = $request->custom_value;
        } else {
            $value = $request->value;
        }
        $commissions = $this->calculateCommission($request->product, $value);
        $newCommission->indicator_commission = $commissions[0];
        $newCommission->seller_commission = $commissions[1];
        $newCommission->operator_commission = $commissions[2];

        $newCommission->save();
        return response()->json($newCommission);
    }

    public function calculateCommission($product, $value)
    {
        switch ($product) {

            case 'Seguro Prestamista':
                return $this->calculatingCommission($value, 0.20);

            case 'Seguro de Vida':
                return $this->calculatingCommission($value, 0.20, true);

            case 'Seguro de Vida Coletivo':
                return $this->calculatingCommission($value, 0.20);

            case 'Seguro Animal de Elite':
                return $this->calculatingCommission($value, 0.20);

            case 'Seguro Auto':
                return $this->calculatingCommission($value, 0.20);

            case 'Seguro Equipamentos':
                return $this->calculatingCommission($value, 0.20);

            case 'Seguro Residencial e Empresarial':
                return $this->calculatingCommission($value, 0.20);

            case 'Seguro Agrícola':
                return $this->calculatingCommission($value, 0.20);

            case 'Crédito Consignado':
                return $this->calculatingCommission($value, 0.20);

            case 'Consórcio':
                return $this->calculatingCommission($value, 0.20);

            case 'Previdência':
                return $this->calculatingCommission($value, 0.20);
        }
    }

    public function calculatingCommission($value, $sicoob_commission_percentage, $life_ensurance = false)
    {
        $sicoob_commission_value = $value * $sicoob_commission_percentage;
        if ($life_ensurance) {
            $sicoob_commission_value = 0.75 * $sicoob_commission_value;
        }
        $sicoob_commission_value_taxing = 0.965 * $sicoob_commission_value;
        $employees_commission_value = 0.04 * $sicoob_commission_value_taxing;
        $indicator_commission_value = 0.20 * $employees_commission_value;
        $seller_commission_value = 0.60 * $employees_commission_value;
        $operator_commission_value = 0.20 * $employees_commission_value;
        return [$indicator_commission_value, $seller_commission_value, $operator_commission_value];
    }

    public function editCommission(Commission $commission, Request $request)
    {
        $commission->date = $request->date;
        $commission->indicator = $request->indicator;
        $commission->seller = $request->seller;
        $commission->operator = $request->operator;
        $commission->status = $request->status;
        if ($request->custom_value) {
            if (($commission->custom_value != $request->custom_value) || ($commission->product != $request->product)) {
                $commissions                      = $this->calculateCommission($request->product, $request->custom_value);
                $commission->indicator_commission = $commissions[0];
                $commission->seller_commission    = $commissions[1];
                $commission->operator_commission  = $commissions[2];
            }
            $commission->custom_value = $request->custom_value;
        } else {
            if (($commission->value != $request->value) || ($commission->product != $request->product)) {
                $commissions = $this->calculateCommission($request->product, $request->value);
                $commission->indicator_commission = $commissions[0];
                $commission->seller_commission    = $commissions[1];
                $commission->operator_commission  = $commissions[2];
            }
        }
        $commission->value = $request->value;
        $commission->product = $request->product;

        $commission->save();
        return response()->json($commission);
    }

    public function deleteCommission(Commission $commission, Request $request)
    {
        $commission->delete();
        return response()->json($commission);
    }
}
