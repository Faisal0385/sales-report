<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sales;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('client.report-page.report-page');
    }

    public function saleReport()
    {

        $companies = Sales::select('company')
            ->distinct()
            ->whereNotNull('company')
            ->pluck('company');

        $branches = Sales::select('branch')
            ->distinct()
            ->whereNotNull('branch')
            ->pluck('branch');

        $totals = Sales::select('company', 'branch', DB::raw('SUM(daily_total) as total_amount'))
            ->groupBy('company', 'branch')
            ->get()
            ->groupBy('company')
            ->map(function ($branches) {
                return $branches->pluck('total_amount', 'branch');
            });

        return view('client.report-page.sales-report', compact(
            'companies',
            'branches',
            'totals'
        ));
    }

    public function puchaseReport()
    {

        $companies = Purchase::select('company')
            ->distinct()
            ->whereNotNull('company')
            ->pluck('company');

        $branches = Purchase::select('branch')
            ->distinct()
            ->whereNotNull('branch')
            ->pluck('branch');

        $totals = Purchase::select('company', 'branch', DB::raw('SUM(purchase_amount) as total_amount'))
            ->groupBy('company', 'branch')
            ->get()
            ->groupBy('company')
            ->map(function ($branches) {
                return $branches->pluck('total_amount', 'branch');
            });

        return view('client.report-page.purchase-report', compact(
            'companies',
            'branches',
            'totals'
        ));
    }
}
