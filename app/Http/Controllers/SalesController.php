<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $branch = Auth::user()->branch;

        $sales = Sales::where('company', '=', $company)->where('branch', '=', $branch)->orderBy('id', 'desc')->get();
        $daily_total = Sales::where('month', '=', date('m'))->where('company', '=', $company)->where('branch', '=', $branch)->sum('daily_total');

        return view('client.sales-page.sales-page', compact('sales', 'daily_total'));
    }

    public function store(Request $request)
    {
        if (is_null(Auth::user()->company)) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['company' => 'Your account has no company assigned.']);
        }

        ## Validate incoming request
        $validated = $request->validate([
            'sales_date'       => 'required|date',
            'cash_sales'       => 'required|numeric|min:1',
            'techpoint_sales'  => 'required|numeric|min:0',
        ]);


        list($year, $month, $day) = explode('-', $validated['sales_date']);

        ## Store in database
        Sales::create([
            'year'            => $year,
            'month'           => $month,
            'day'             => $day,
            'sales_date'      => $validated['sales_date'],
            'cash_sales'      => $validated['cash_sales'],
            'techpoint_sales' => $validated['techpoint_sales'],
            'daily_total'     => $validated['cash_sales'] + $validated['techpoint_sales'],
            'company'         => Auth::user()->company ?? null,
            'branch'          => Auth::user()->branch ?? null,
        ]);

        return redirect()->back()->with('success', 'Sales entry added successfully!');
    }


    public function destroy($id)
    {
        // Find the sale by ID
        $sale = Sales::find($id);

        if (!$sale) {
            return redirect()->back()->withErrors(['sale' => 'Sale entry not found.']);
        }

        // Delete the sale
        $sale->delete();

        return redirect()->back()->with('success', 'Sale entry deleted successfully!');
    }
}
