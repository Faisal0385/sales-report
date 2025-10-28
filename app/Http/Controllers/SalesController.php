<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SalesController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $branch = Auth::user()->branch;
        $last_month = (int) date('m') - 1;

        $sales = Sales::where('month', '=', date('m'))->where('company', '=', $company)->where('branch', '=', $branch)->orderBy('id', 'desc')->paginate(10);
        $daily_total = Sales::where('month', '=', date('m'))->where('company', '=', $company)->where('branch', '=', $branch)->sum('daily_total');
        $last_month = Sales::where('month', '=', $last_month)->where('company', '=', $company)->where('branch', '=', $branch)->sum('daily_total');

        $target = $last_month + (($last_month * 15) / 100);

        return view('client.sales-page.sales-page', compact('sales', 'daily_total', 'last_month', 'target'));
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
            'sales_date' => 'required|date',
            'cash_sales' => 'numeric|min:0',
            'techpoint_sales' => 'numeric|min:0',
            'card_sales' => 'numeric|min:0',
            'tiktech_sales' => 'numeric|min:0',
            'print_express_sales' => 'numeric|min:0',
        ]);


        $cash_sales = $validated['cash_sales'] ?? 0;
        $card_sales = $validated['card_sales'] ?? 0;
        $techpoint_sales = $validated['techpoint_sales'] ?? 0;
        $tiktech_sales = $validated['tiktech_sales'] ?? 0;
        $tiktech_sales = $validated['tiktech_sales'] ?? 0;
        $print_express_sales = $validated['print_express_sales'] ?? 0;


        if (
            $cash_sales == 0 &&
            $card_sales == 0 &&
            $techpoint_sales == 0 &&
            $tiktech_sales == 0 &&
            $print_express_sales == 0
        ) {
            return redirect()->back()->with('error', 'Payment field cannot be empty!');
        }


        list($year, $month, $day) = explode('-', $validated['sales_date']);

        ## Store in database
        Sales::create([
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'sales_date' => $validated['sales_date'],
            'cash_sales' => $cash_sales,
            'card_sales' => $card_sales,
            'techpoint_sales' => $techpoint_sales,
            'tiktech_sales' => $tiktech_sales,
            'print_express_sales' => $print_express_sales,
            'daily_total' => $cash_sales + $card_sales + $techpoint_sales + $tiktech_sales + $print_express_sales,
            'company' => Auth::user()->company ?? null,
            'branch' => Auth::user()->branch ?? null,
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


    public function downloadCsv(Request $request)
    {
        $company = Auth::user()->company ?? null;
        $branch = Auth::user()->branch ?? null;

        $year = $request->input('year');
        $month = $request->input('month');

        // ✅ Filter sales by year and month
        $sales = Sales::whereYear('sales_date', $year)
            ->whereMonth('sales_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->get();

        // ✅ CSV file name
        $fileName = "sales_{$year}_{$month}.csv";

        // ✅ Create CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // ✅ Stream CSV response
        $callback = function () use ($sales) {
            $handle = fopen('php://output', 'w');

            // Add header row
            fputcsv($handle, ['Sales Date', 'Cash Sales', 'Card Sales', 'Techpoint Sales', 'TikTech Sales', 'PrintExpress Sales', 'Daily Total']);

            // Add data rows
            foreach ($sales as $purchase) {
                fputcsv($handle, [
                    $purchase->sales_date,
                    $purchase->cash_sales,
                    $purchase->card_sales,
                    $purchase->techpoint_sales,
                    $purchase->tiktech_sales,
                    $purchase->print_express_sales,
                    $purchase->daily_total,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }


    // 
    public function downloadYearCsv(Request $request)
    {
        $company = Auth::user()->company ?? null;
        $branch = Auth::user()->branch ?? null;

        $year = $request->input('year');

        // ✅ Filter sales by year and month
        $sales = Sales::whereYear('sales_date', $year)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->get();

        // ✅ CSV file name
        $fileName = "sales_{$year}.csv";

        // ✅ Create CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // ✅ Stream CSV response
        $callback = function () use ($sales) {
            $handle = fopen('php://output', 'w');

            // Add header row
            fputcsv($handle, ['Sales Date', 'Cash Sales', 'Card Sales', 'Techpoint Sales', 'TikTech Sales', 'PrintExpress Sales', 'Daily Total']);

            // Add data rows
            foreach ($sales as $purchase) {
                fputcsv($handle, [
                    $purchase->sales_date,
                    $purchase->cash_sales,
                    $purchase->card_sales,
                    $purchase->techpoint_sales,
                    $purchase->tiktech_sales,
                    $purchase->print_express_sales,
                    $purchase->daily_total,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportYearlyReport(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // 🧮 Fetch totals grouped by month for the selected year
        $data = DB::table('sales')
            ->select('month', DB::raw('SUM(daily_total) as total'))
            ->where('year', (string) $year)
            ->groupBy('month')
            ->get();

        // 🗓️ Predefined month order
        $monthOrder = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $reportData = [];

        // ✅ Handle both numeric and text-based months
        foreach ($monthOrder as $num => $name) {
            $monthData = $data->first(function ($item) use ($num, $name) {
                // Match if stored as number, string number, or full month name
                return $item->month == $num ||
                    $item->month == (string) $num ||
                    strcasecmp($item->month, $name) === 0 ||
                    strcasecmp($item->month, substr($name, 0, 3)) === 0; // e.g. "Jan"
            });

            $total = $monthData ? $monthData->total : 0;
            $reportData[] = [$name, number_format($total, 2)];
        }

        // 📁 Define CSV filename
        $fileName = "yearly_sales_report_{$year}.csv";

        // 📤 Stream CSV response
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($reportData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Month', 'Total Sales']); // Header row

            foreach ($reportData as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }


    // Download Report CSV
    public function downloadReportCsv(Request $request)
    {
        $company = $request->input('company');
        $branch = $request->input('branch');

        $year = $request->input('year');
        $month = $request->input('month');

        // ✅ Filter sales by year and month
        $sales = Sales::whereYear('sales_date', $year)
            ->whereMonth('sales_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->get();

        // ✅ CSV file name
        $fileName = "sales_{$year}_{$month}.csv";

        // ✅ Create CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // ✅ Stream CSV response
        $callback = function () use ($sales) {
            $handle = fopen('php://output', 'w');

            // Add header row
            fputcsv($handle, ['Sales Date', 'Cash Sales', 'Card Sales', 'Techpoint Sales', 'TikTech Sales', 'PrintExpress Sales', 'Daily Total']);

            // Add data rows
            foreach ($sales as $purchase) {
                fputcsv($handle, [
                    $purchase->sales_date,
                    $purchase->cash_sales,
                    $purchase->card_sales,
                    $purchase->techpoint_sales,
                    $purchase->tiktech_sales,
                    $purchase->print_express_sales,
                    $purchase->daily_total,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
