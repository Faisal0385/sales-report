<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PurchaseController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $branch = Auth::user()->branch;

        $purchases = Purchase::where('month', '=', date('m'))->where('year', '=', date('Y'))->where('company', '=', $company)->where('branch', '=', $branch)->orderBy('id', 'desc')->paginate(10);
        $purchase_amount = Purchase::where('month', '=', date('m'))->where('company', '=', $company)->where('branch', '=', $branch)->sum('purchase_amount');

        return view('client.purchase-entry.purchase-entry', compact('purchases', 'purchase_amount'));
    }

    public function view($id)
    {

        $purchaseDetail = Purchase::findOrFail($id);
        return view('client.purchase-entry.detail-view-purchases', compact('purchaseDetail'));
    }

    public function store(Request $request)
    {
        // ✅ Validate incoming request
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string',
            'product_details' => 'required|string',
            'imei_number' => 'required|string|unique:purchases,imei_number',
            // 'customer_id_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1048576',
            'customer_id_proof' => 'nullable|mimes:jpeg,png,jpg,gif,webp,pdf|max:1048576',
            'captured_photo' => 'nullable|string',
            'payment_method' => 'required|in:cash,card,bank_transfer,other',
            'purchase_amount' => 'required|numeric|min:1',
            'category' => 'required|string|max:255',
            'sub_category' => 'required|string|max:255',
            'bank_transfer_name' => 'nullable|string|max:255',
            'bank_transfer_account' => 'nullable|string|max:255',
            'bank_transfer_sort_code' => 'nullable|string|max:255',
        ]);

        // ✅ Handle NID upload
        if ($request->hasFile('customer_id_proof')) {
            $nidFile = $request->file('customer_id_proof');
            $nidName = uniqid() . '.' . $nidFile->getClientOriginalExtension();
            $nidPath = 'uploads/customer_id_proof/';
            $nidFile->move(public_path($nidPath), $nidName);

            $validated['customer_id_proof'] = $nidPath . $nidName;
        }


        // ✅ Handle Selfie upload
        if (!empty($request->captured_photo)) {
            $photoData = $request->captured_photo;

            // Remove the part before base64 (like "data:image/png;base64,")
            $photo = str_replace('data:image/png;base64,', '', $photoData);
            $photo = str_replace(' ', '+', $photo); // Fix spaces

            // Generate a unique filename
            $fileName = 'selfie_' . time() . '.png';

            // Define full public path
            $directory = public_path('uploads/selfies');

            // Create folder if it doesn’t exist
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Full file path
            $filePath = $directory . '/' . $fileName;

            // Save decoded image directly to public folder
            file_put_contents($filePath, base64_decode($photo));


            // Save relative path for DB (for example: uploads/selfies/selfie_123.png)
            $validated['captured_photo'] = 'uploads/selfies/' . $fileName;
        }

        list($year, $month, $day) = explode('-', $validated['purchase_date']);

        // ✅ Add company & branch from logged in user
        $validated['year'] = $year;
        $validated['month'] = $month;
        $validated['day'] = $day;

        $validated['company'] = Auth::user()->company ?? null;
        $validated['branch'] = Auth::user()->branch ?? null;

        // ✅ Save purchase
        Purchase::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Purchase added successfully!');
    }

    public function destroy($id)
    {
        // ✅ Find the purchase by ID
        $purchase = Purchase::findOrFail($id);

        // ✅ Delete the purchase
        $purchase->delete();

        // ✅ Redirect back with success message
        return redirect()->back()->with('success', 'Purchase deleted successfully.');
    }


    public function downloadCsv(Request $request)
    {
        $company = Auth::user()->company ?? null;
        $branch = Auth::user()->branch ?? null;

        $year = $request->input('year');
        $month = $request->input('month');

        // ✅ Filter purchases by year and month
        $purchases = Purchase::whereYear('purchase_date', $year)
            ->whereMonth('purchase_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->get();

        // ✅ CSV file name
        $fileName = "purchases_{$year}_{$month}.csv";

        // ✅ Create CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // ✅ Stream CSV response
        $callback = function () use ($purchases) {
            $handle = fopen('php://output', 'w');

            // Add header row
            fputcsv($handle, ['Purchase Date', 'Company', 'Branch', 'Customer Name', 'Phone', 'Email', 'Address', 'IMEI Number', 'Category', 'Sub Category', 'Product Details', 'Payment Method', 'Bank Transfer Name', 'Bank Transfer Account', 'Bank Transfer Sort Code', 'Total Amount']);

            // Add data rows
            foreach ($purchases as $purchase) {
                fputcsv($handle, [
                    $purchase->purchase_date,
                    $purchase->company,
                    $purchase->branch,
                    $purchase->customer_name,
                    $purchase->phone_number,
                    $purchase->email,
                    $purchase->customer_address,
                    $purchase->imei_number,
                    $purchase->category,
                    $purchase->sub_category,
                    $purchase->product_details,
                    $purchase->purchase_amount,
                    $purchase->bank_transfer_name,
                    $purchase->bank_transfer_account,
                    $purchase->bank_transfer_sort_code,
                    $purchase->purchase_amount,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function downloadReportCsv(Request $request)
    {
        $company = $request->input('company');
        $branch = $request->input('branch');

        $year = $request->input('year');
        $month = $request->input('month');

        // ✅ Filter purchases by year and month
        $purchases = Purchase::whereYear('purchase_date', $year)
            ->whereMonth('purchase_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->get();

        // ✅ CSV file name
        $fileName = "purchases_{$year}_{$month}.csv";

        // ✅ Create CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // ✅ Stream CSV response
        $callback = function () use ($purchases) {
            $handle = fopen('php://output', 'w');

            // Add header row
            fputcsv($handle, ['Purchase Date', 'Company', 'Branch', 'Customer Name', 'Phone', 'Email', 'Address', 'IMEI Number', 'Category', 'Sub Category', 'Product Details', 'Payment Method', 'Bank Transfer Name', 'Bank Transfer Account', 'Bank Transfer Sort Code', 'Total Amount']);

            // Add data rows
            foreach ($purchases as $purchase) {
                fputcsv($handle, [
                    $purchase->purchase_date,
                    $purchase->company,
                    $purchase->branch,
                    $purchase->customer_name,
                    $purchase->phone_number,
                    $purchase->email,
                    $purchase->customer_address,
                    $purchase->imei_number,
                    $purchase->category,
                    $purchase->sub_category,
                    $purchase->product_details,
                    $purchase->purchase_amount,
                    $purchase->bank_transfer_name,
                    $purchase->bank_transfer_account,
                    $purchase->bank_transfer_sort_code,
                    $purchase->purchase_amount,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }










    public function purchaseMonthView(Request $request)
    {
        $company = Auth::user()->company ?? null;
        $branch = Auth::user()->branch ?? null;
        $year = $request->input('year');
        $month = $request->input('month');

        $last_year = $year - 1;

        // ✅ Filter purchase by year and month
        $last_year_purchase = Purchase::whereYear('purchase_date', $last_year)
            ->whereMonth('purchase_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum("purchase_amount");


        // ✅ Filter purchase by year and month
        $this_year_purchase = Purchase::whereYear('purchase_date', $year)
            ->whereMonth('purchase_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum("purchase_amount");


        // ✅ Filter purchase by year and month
        $purchases = Purchase::whereYear('purchase_date', $year)
            ->whereMonth('purchase_date', $month)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->paginate(8);

        return view('client.purchase-entry.purchase-month-view', compact('purchases', 'year', 'month', 'last_year_purchase', 'this_year_purchase'));
    }


    public function purchaseYearView(Request $request)
    {
        $company = Auth::user()->company ?? null;
        $branch = Auth::user()->branch ?? null;
        $year = $request->input('year');
        $last_year = $year - 1;

        // ✅ Filter purchases by year
        $last_year_purchase = DB::table('purchases')
            ->where('year', (string) $last_year)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum('purchase_amount');

        $this_year_purchase = DB::table('purchases')
            ->where('year', (string) $year)
            ->where('company', '=', $company)
            ->where('branch', '=', $branch)
            ->sum('purchase_amount');


        // ✅ Filter sales by year
        $sales = DB::table('purchases')
            ->select('month', DB::raw('SUM(purchase_amount) as total'))
            ->where('year', (string) $year)
            ->where('company', '=', Auth::user()->company)
            ->where('branch', '=', Auth::user()->branch)
            ->groupBy('month')
            ->get();

        return view('client.purchase-entry.purchase-year-view', compact('sales', 'year', 'last_year_purchase', 'this_year_purchase'));
    }


    public function exportYearlyReport(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // 🧮 Fetch totals grouped by month for the selected year
        $data = DB::table('purchases')
            ->select('month', DB::raw('SUM(purchase_amount) as total'))
            ->where('year', (string) $year)
            ->where('company', '=', Auth::user()->company)
            ->where('branch', '=', Auth::user()->branch)
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
        $fileName = "yearly_purchase_report_{$year}.csv";

        // 📤 Stream CSV response
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($reportData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Month', 'Total Purchase']); // Header row

            foreach ($reportData as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
