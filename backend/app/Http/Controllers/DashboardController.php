<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\User;

class DashboardController extends Controller
{

    public function getCardDoneProducts (Request $request) {
        $month = date('Y-m-d', strtotime(date('Y-m-01')));
        $month_1 = date('Y-m-d', strtotime(date('Y-m-01').' -1 MONTH'));
        $month_2 = date('Y-m-d', strtotime(date('Y-m-01').' -2 MONTH'));
        $month_3 = date('Y-m-d', strtotime(date('Y-m-01').' -3 MONTH'));
        $dates = [$month_3, $month_2, $month_1, $month];

        foreach ($dates as $key => $date) {
            $raw_date = substr($date, 0, -3);
            $year_temp = substr($raw_date, 0, -3);
            $month_temp = substr($raw_date, 5);
            $dates[$key] = $month_temp."/".$year_temp;
        }

        $done_commissions[0] = count(Commission::
            select("id")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month_3."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month_3."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray());
        $done_commissions[1] = count(Commission::
            select("id")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month_2."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month_2."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray());
         $done_commissions[2] = count(Commission::
            select("id")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month_1."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month_1."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray());
        $done_commissions[3] = count(Commission::
            select("id")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray());

        $total = 0;
        foreach ($done_commissions as $qtt) {
            $total += $qtt;
        }

        return response()->json([$done_commissions, $dates, $total]);
    }
    public function getCardCommissionsVal (Request $request) {
        $month = date('Y-m-d', strtotime(date('Y-m-01')));
        $month_1 = date('Y-m-d', strtotime(date('Y-m-01').' -1 MONTH'));
        $month_2 = date('Y-m-d', strtotime(date('Y-m-01').' -2 MONTH'));
        $month_3 = date('Y-m-d', strtotime(date('Y-m-01').' -3 MONTH'));
        $dates = [$month_3, $month_2, $month_1, $month];

        foreach ($dates as $key => $date) {
            $raw_date = substr($date, 0, -3);
            $year_temp = substr($raw_date, 0, -3);
            $month_temp = substr($raw_date, 5);
            $dates[$key] = $month_temp."/".$year_temp;
        }

        $commissions_val[0] = (float)Commission::
            selectRaw("SUM(indicator_commission + seller_commission  + operator_commission) as total")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month_3."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month_3."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray()[0]['total'];
        $commissions_val[1] = (float)Commission::
            selectRaw("SUM(indicator_commission + seller_commission  + operator_commission) as total")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month_2."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month_2."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray()[0]['total'];
         $commissions_val[2] = (float)Commission::
            selectRaw("SUM(indicator_commission + seller_commission  + operator_commission) as total")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month_1."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month_1."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray()[0]['total'];
        $commissions_val[3] = (float)Commission::
            selectRaw("SUM(indicator_commission + seller_commission  + operator_commission) as total")
            ->whereRaw("status = 'Aprovado Ups' AND
                month(CAST('".$month."' as date)) = month(CAST(date_operator as date)) AND
                year(CAST('".$month."' as date)) = year(CAST(date_operator as date))
            ")
            ->get()->toArray()[0]['total'];

        $total = 0;
        foreach ($commissions_val as $key => $qtt) {
            $total += $qtt;
        }
        $total = number_format($total, 2, ",", ".");

        return response()->json([$commissions_val, $dates, $total]);
    }

    public function getCardProductsRegisters (Request $request) {
        $month = date('Y-m-d', strtotime(date('Y-m-01')));
        $month_1 = date('Y-m-d', strtotime(date('Y-m-01').' -1 MONTH'));
        $month_2 = date('Y-m-d', strtotime(date('Y-m-01').' -2 MONTH'));
        $month_3 = date('Y-m-d', strtotime(date('Y-m-01').' -3 MONTH'));
        $dates = [$month_3, $month_2, $month_1, $month];

        foreach ($dates as $key => $date) {
            $raw_date = substr($date, 0, -3);
            $year_temp = substr($raw_date, 0, -3);
            $month_temp = substr($raw_date, 5);
            $dates[$key] = $month_temp."/".$year_temp;
        }

        $products_registers[0] = count(Commission::
            select("id")
            ->whereRaw("
                month(CAST('".$month_3."' as date)) = month(CAST(created_at as date)) AND
                year(CAST('".$month_3."' as date)) = year(CAST(created_at as date))
            ")
            ->get()->toArray());
        $products_registers[1] = count(Commission::
            select("id")
            ->whereRaw("
                month(CAST('".$month_2."' as date)) = month(CAST(created_at as date)) AND
                year(CAST('".$month_2."' as date)) = year(CAST(created_at as date))
            ")
            ->get()->toArray());
         $products_registers[2] = count(Commission::
            select("id")
            ->whereRaw("
                month(CAST('".$month_1."' as date)) = month(CAST(created_at as date)) AND
                year(CAST('".$month_1."' as date)) = year(CAST(created_at as date))
            ")
            ->get()->toArray());
        $products_registers[3] = count(Commission::
            select("id")
            ->whereRaw("
                month(CAST('".$month."' as date)) = month(CAST(created_at as date)) AND
                year(CAST('".$month."' as date)) = year(CAST(created_at as date))
            ")
            ->get()->toArray());

        $total = 0;
        foreach ($products_registers as $qtt) {
            $total += $qtt;
        }

        return response()->json([$products_registers, $dates, $total]);
    }
    public function getInfoCards (Request $request) {
        $all_status = Commission::selectRaw('status, COUNT(*) as qtt')
            ->whereRaw("status != 'Aprovado UPS' AND '".date('Y')."' = year(CAST(created_at as date))")
            ->groupBy('status')
            ->get()->toArray();
        if (count($all_status) < 4) {
            $all_status = $this->emptyStatus($all_status);
        } else {
            $temp = $all_status[0];
            $all_status[0] = $all_status[1];
            $all_status[1] = $temp;
        }

        $delay = 0;
        foreach ($all_status as $key => $status) {
            $all_status[$key]['delay'] = ($delay);
            $delay += 0.3;
        }

        return response()->json($all_status);
    }
    public function getPieChartProducts (Request $request) {
        $all_products = Commission::selectRaw('product, COUNT(*) as qtt')
        ->where('status', 'Aprovado UPS')
        ->groupBy('product')->get()->toArray();
        $products = [];
        $qtts = [];
        $total = 0;
        foreach ($all_products as $product) {
            array_push($products, $product['product']);
            array_push($qtts, $product['qtt']);
            $total += $product['qtt'];
        }
        return response()->json([$products, $qtts, $total]);
    }
    public function getDonutChartCommissionProducts (Request $request) {
        $all_products = Commission::
        selectRaw("product, SUM(indicator_commission + seller_commission  + operator_commission) as qtt")
        ->where('status', 'Aprovado UPS')
        ->groupBy('product')->get()->toArray();
        $products = [];
        $qtts = [];
        $total = 0;
        foreach ($all_products as $product) {
            array_push($products, $product['product']);
            array_push($qtts, floatval($product['qtt']));
            $total += $product['qtt'];
        }
        $total = number_format($total, 2, ",", ".");
        return response()->json([$products, $qtts, $total]);
    }
    public function getColumnChartCommissionUsers (Request $request) {
        $all_indicators = Commission::
            selectRaw("indicator_id, SUM(indicator_commission) as total_indicator")
            ->where('status', 'Aprovado UPS')
            ->groupBy('indicator_id')
            ->with('indicator:id,full_name')
            ->get()->toArray();
        $all_sellers = Commission::
            selectRaw("seller_id, SUM(seller_commission) as total_seller")
            ->where('status', 'Aprovado UPS')
            ->groupBy('seller_id')
            ->with('seller:id,full_name')
            ->get()->toArray();
        $all_operators = Commission::
            selectRaw("operator_id, SUM(operator_commission) as total_operator")
            ->where('status', 'Aprovado UPS')
            ->groupBy('operator_id')
            ->with('operator:id,full_name')
            ->get()->toArray();
        $all_users_with_commission = User::join('commissions', function ($join) {
                $join->on('users.id', '=', 'commissions.indicator_id')
                ->orOn('users.id', '=', 'commissions.seller_id')
                ->orOn('users.id', '=', 'commissions.operator_id');
            })->
            selectRaw("users.id as id, users.full_name")
            ->where('commissions.status', 'Aprovado UPS')
            ->groupBy('users.id')
            ->get()->toArray();
        foreach ($all_users_with_commission as $key => $user) {
            $all_users_with_commission[$key]['total_indicator'] = 0;
            $all_users_with_commission[$key]['total_seller'] = 0;
            $all_users_with_commission[$key]['total_operator'] = 0;
            foreach ($all_indicators as $indicator) {
                if ($indicator['indicator_id'] == $user['id']) {
                    $all_users_with_commission[$key]['total_indicator'] = $indicator['total_indicator'];
                }
            }
            foreach ($all_sellers as $seller) {
                if ($seller['seller_id'] == $user['id']) {
                    $all_users_with_commission[$key]['total_seller'] = $seller['total_seller'];
                }
            }
            foreach ($all_operators as $operator) {
                if ($operator['operator_id'] == $user['id']) {
                    $all_users_with_commission[$key]['total_operator'] = $operator['total_operator'];
                }
            }
        }

        return response()->json($all_users_with_commission);
    }
    public function emptyStatus ($all_status) {
        $result = [[ "status" => "Aguard. Venda", "qtt" => 0 ], [ "status" => "Aguard. UPS", "qtt" => 0 ], [ "status" => "Não Vendido", "qtt" => 0 ], [ "status" => "Recusado UPS", "qtt" => 0 ]];
        foreach ($all_status as $status) {
            switch($status['status']) {
                case 'Aguard. Venda':
                    foreach ($result as $key_result => $not_empty) {
                        if ($not_empty['status'] == 'Aguard. Venda') {
                            $result[$key_result]['qtt'] = $status['qtt'];
                        }
                    }
                break;
                case 'Aguard. UPS':
                    foreach ($result as $key_result => $not_empty) {
                        if ($not_empty['status'] == 'Aguard. UPS') {
                            $result[$key_result]['qtt'] = $status['qtt'];
                        }
                    }
                break;
                case 'Não Vendido':
                    foreach ($result as $key_result => $not_empty) {
                        if ($not_empty['status'] == 'Não Vendido') {
                            $result[$key_result]['qtt'] = $status['qtt'];
                        }
                    }
                break;
                case 'Recusado UPS':
                    foreach ($result as $key_result => $not_empty) {
                        if ($not_empty['status'] == 'Recusado UPS') {
                            $result[$key_result]['qtt'] = $status['qtt'];
                        }
                    }
                break;
            }
        }
        return $result;
    }

}
