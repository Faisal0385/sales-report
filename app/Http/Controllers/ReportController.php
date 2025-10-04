<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sales;
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
        $Tiktech    = "Tiktech";
        $Techpoint  = "Techpoint";
        $Restaurant = "Restaurant";

        $Hornchurch = "Hornchurch";
        $Upminister = "Upminister";
        $Billericay = "Billericay";

        $TechpointSales = Sales::where('month', '=', date('m'))->where('company', '=', $Techpoint)->where('branch', '=', null)->orderBy('id', 'desc')->paginate(10);
        $RestaurantSales = Sales::where('month', '=', date('m'))->where('company', '=', $Restaurant)->where('branch', '=', null)->orderBy('id', 'desc')->paginate(10);

        $TiktechHornchurchSales = Sales::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Hornchurch)->orderBy('id', 'desc')->paginate(10);
        $TiktechUpministerSales = Sales::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Upminister)->orderBy('id', 'desc')->paginate(10);
        $TiktechBillericaySales = Sales::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Billericay)->orderBy('id', 'desc')->paginate(10);

        $techpoint_daily_total  = Sales::where('month', '=', date('m'))->where('company', '=', $Techpoint)->where('branch', '=', null)->sum('daily_total');
        $restaurant_daily_total = Sales::where('month', '=', date('m'))->where('company', '=', $Restaurant)->where('branch', '=', null)->sum('daily_total');
        $hornchurch_daily_total = Sales::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Hornchurch)->sum('daily_total');
        $upminister_daily_total = Sales::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Upminister)->sum('daily_total');
        $billericay_daily_total = Sales::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Billericay)->sum('daily_total');

        return view('client.report-page.sales-report', compact(
            'TechpointSales',
            'RestaurantSales',
            'TiktechHornchurchSales',
            'TiktechUpministerSales',
            'TiktechBillericaySales',
            'techpoint_daily_total',
            'restaurant_daily_total',
            'hornchurch_daily_total',
            'upminister_daily_total',
            'billericay_daily_total'
        ));
    }

    public function puchaseReport()
    {
        $Tiktech    = "Tiktech";
        $Techpoint  = "Techpoint";
        $Restaurant = "Restaurant";

        $Hornchurch = "Hornchurch";
        $Upminister = "Upminister";
        $Billericay = "Billericay";

        $TechpointSales = Purchase::where('month', '=', date('m'))->where('company', '=', $Techpoint)->where('branch', '=', null)->orderBy('id', 'desc')->paginate(10);
        $RestaurantSales = Purchase::where('month', '=', date('m'))->where('company', '=', $Restaurant)->where('branch', '=', null)->orderBy('id', 'desc')->paginate(10);

        $TiktechHornchurchSales = Purchase::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Hornchurch)->orderBy('id', 'desc')->paginate(10);
        $TiktechUpministerSales = Purchase::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Upminister)->orderBy('id', 'desc')->paginate(10);
        $TiktechBillericaySales = Purchase::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Billericay)->orderBy('id', 'desc')->paginate(10);

        $techpoint_daily_total  = Purchase::where('month', '=', date('m'))->where('company', '=', $Techpoint)->where('branch', '=', null)->sum('purchase_amount');
        $restaurant_daily_total = Purchase::where('month', '=', date('m'))->where('company', '=', $Restaurant)->where('branch', '=', null)->sum('purchase_amount');
        $hornchurch_daily_total = Purchase::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Hornchurch)->sum('purchase_amount');
        $upminister_daily_total = Purchase::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Upminister)->sum('purchase_amount');
        $billericay_daily_total = Purchase::where('month', '=', date('m'))->where('company', '=', $Tiktech)->where('branch', '=', $Billericay)->sum('purchase_amount');


        return view('client.report-page.purchase-report', compact(
            'TechpointSales',
            'RestaurantSales',
            'TiktechHornchurchSales',
            'TiktechUpministerSales',
            'TiktechBillericaySales',
            'techpoint_daily_total',
            'restaurant_daily_total',
            'hornchurch_daily_total',
            'upminister_daily_total',
            'billericay_daily_total'
        ));
    }
}
