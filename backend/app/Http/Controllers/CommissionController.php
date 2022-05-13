<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\User;

class CommissionController extends Controller
{

    public function getCommissions(Request $request)
    {
        $allCommissions = Commission::with('indicator', 'seller', 'operator')->get();
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
        $newCommission->date_indicator = $request->date_indicator;
        $newCommission->date_seller = $request->date_seller;
        $newCommission->date_operator = $request->date_operator;
        $newCommission->product = $request->product;
        $newCommission->value = $request->value;
        $newCommission->indicator_id = $request->indicator_id;
        $newCommission->seller_id = $request->seller_id;
        $newCommission->operator_id = $request->operator_id;
        $newCommission->status = $request->status;
        $newCommission->commission_percentage = $request->commission_percentage;

        if ($request->custom_value) {
            $newCommission->custom_value = $request->custom_value;
            $value = $request->custom_value;
        } else {
            $value = $request->value;
        }
        if ($newCommission->status == 'Aprovado UPS') {
            $commissions = $this->calculateCommission($request->product, $value, $request->commission_percentage);
            $newCommission->indicator_commission = $commissions[0];
            $newCommission->seller_commission = $commissions[1];
            $newCommission->operator_commission = $commissions[2];
        }
        $newCommission->save();
        return response()->json($newCommission->load('indicator', 'seller', 'operator'));
    }

    public function calculateCommission($product, $value, $commission_percentage)
    {
        $commission_percentage = $commission_percentage / 100;
        switch ($product) {

            case 'Seguro Prestamista':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro de Vida - Sicoob Seguradora':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro de Vida':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value, true);

            case 'Seguro de Vida Coletivo':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro Animal de Elite':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro Auto':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro Equipamentos':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro Residencial e Empresarial':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Seguro Agrícola':
                $commission_sicoob_value = (($commission_percentage * $value) * 0.80);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Crédito Consignado':
                $commission_sicoob_value = ($commission_percentage * $value);
                return $this->calculatingCommission($commission_sicoob_value);

            case 'Consórcio':
                $commission_sicoob_value = ($commission_percentage * $value);
                return $this->calculatingCommission($commission_sicoob_value);

        }
    }


    public function calculatingCommission($sicoob_commission_value)
    {
        $sicoob_commission_value_taxing = 0.965 * $sicoob_commission_value;
        $employees_commission_value = 0.04 * $sicoob_commission_value_taxing;
        $indicator_commission_value = 0.20 * $employees_commission_value;
        $seller_commission_value = 0.60 * $employees_commission_value;
        $operator_commission_value = 0.20 * $employees_commission_value;
        $indicator_commission_value = number_format($indicator_commission_value, 2, '.', '');
        $seller_commission_value = number_format($seller_commission_value, 2, '.', '');
        $operator_commission_value = number_format($operator_commission_value, 2, '.', '');
        return [$indicator_commission_value, $seller_commission_value, $operator_commission_value];
    }

    public function editCommission(Commission $commission, Request $request)
    {
        $commission->date_indicator = $request->date_indicator;
        $commission->date_seller = $request->date_seller;
        $commission->date_operator = $request->date_operator;
        $commission->indicator_id = $request->indicator_id;
        $commission->seller_id = $request->seller_id;
        $commission->operator_id = $request->operator_id;

        if ($request->custom_value) {
            if ($request->status == 'Aprovado UPS') {
                if (($commission->custom_value != $request->custom_value) || ($commission->product != $request->product) || ($commission->commission_percentage != $request->commission_percentage) || ($commission->status != $request->status)) {

                    $commissions                      = $this->calculateCommission($request->product, $request->custom_value, $request->commission_percentage);
                    $commission->indicator_commission = $commissions[0];
                    $commission->seller_commission    = $commissions[1];
                    $commission->operator_commission  = $commissions[2];
                }
            } else if ($commission->status == 'Aprovado UPS') {
                $commission->indicator_commission = null;
                $commission->seller_commission    = null;
                $commission->operator_commission  = null;
            }
            $commission->custom_value = $request->custom_value;
        } else {
            if ($request->status == 'Aprovado UPS') {
                if (($commission->value != $request->value) || ($commission->product != $request->product) || ($commission->commission_percentage != $request->commission_percentage) || ($commission->status != $request->status)) {
                    $commissions                      = $this->calculateCommission($request->product, $request->value, $request->commission_percentage);
                    $commission->indicator_commission = $commissions[0];
                    $commission->seller_commission    = $commissions[1];
                    $commission->operator_commission  = $commissions[2];
                }
            } else if ($commission->status == 'Aprovado UPS') {
                $commission->indicator_commission = null;
                $commission->seller_commission    = null;
                $commission->operator_commission  = null;
            }
            if ($commission->custom_value){
                $commission->custom_value = null;
            }
        }
        $commission->status = $request->status;
        $commission->commission_percentage = $request->commission_percentage;
        $commission->value = $request->value;
        $commission->product = $request->product;

        $commission->save();
        return response()->json($commission->load('indicator', 'seller', 'operator'));
    }

    public function deleteCommission(Commission $commission, Request $request)
    {
        $commission->delete();
        return response()->json($commission);
    }
}
