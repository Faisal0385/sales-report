<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sales;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('client.report-page.report-page');
    }


    public function salesReportView(Request $request)
    {
        $company = $request->input('company');
        $branch = $request->input('branch');
        $year = $request->input('year');
        $month = $request->input('month');
        $last_year = $year - 1;

        // ✅ Filter sales by year and month
        $last_year_sales = Sales::whereYear('sales_date', $last_year)
            ->whereMonth('sales_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum("daily_total");

        // ✅ Filter sales by year and month
        $this_year_sales = Sales::whereYear('sales_date', $year)
            ->whereMonth('sales_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum("daily_total");


        $sale_total = Sales::whereYear('sales_date', $year)
            ->whereMonth('sales_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum("daily_total");

        return view('client.report-page.sales-report-view', compact('sale_total', 'last_year_sales', 'this_year_sales', 'year', 'month', 'company','branch'));

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
            ->whereYear('sales_date', date('Y'))
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
