<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;


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
        $temp = $all_status[0];
        $all_status[0] = $all_status[1];
        $all_status[1] = $temp;
        return response()->json($all_status);
    }



}
