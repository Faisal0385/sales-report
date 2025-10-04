<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        $branch = Auth::user()->branch;

        $purchases = Purchase::where('month', '=', date('m'))->where('company', '=', $company)->where('branch', '=', $branch)->orderBy('id', 'desc')->paginate(10);
        $purchase_amount = Purchase::where('month', '=', date('m'))->where('company', '=', $company)->where('branch', '=', $branch)->sum('purchase_amount');

        return view('client.purchase-entry.purchase-entry', compact('purchases', 'purchase_amount'));
    }

    public function store(Request $request)
    {
        // ✅ Validate incoming request
        $validated = $request->validate([
            'purchase_date'           => 'required|date',
            'customer_name'           => 'required|string|max:255',
            'phone_number'            => 'required|string|max:20',
            'email'                   => 'nullable|email|max:255',
            'customer_address'        => 'nullable|string',
            'product_details'         => 'required|string',
            'imei_number'             => 'required|string|unique:purchases,imei_number',
            'customer_id_proof'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'captured_photo'          => 'nullable|string',
            'payment_method'          => 'required|in:cash,card,bank_transfer,other',
            'purchase_amount'         => 'required|numeric|min:1',
            'category'                => 'required|string|max:255',
            'sub_category'            => 'required|string|max:255',
            'bank_transfer_name'      => 'nullable|string|max:255',
            'bank_transfer_account'   => 'nullable|string|max:255',
            'bank_transfer_sort_code' => 'nullable|string|max:255',
        ]);


        // ✅ Handle file upload if exists
        if ($request->hasFile('customer_id_proof')) {
            $validated['customer_id_proof'] = $request->file('customer_id_proof')
                ->store('id_proofs', 'public');
        }

        if ($request->captured_photo) {
            // Get base64 string
            $image = $request->captured_photo;

            // Remove base64 prefix
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            // Decode and save
            $imageName = time() . '.png';
            Storage::disk('public')->put('captured_photo/' . $imageName, base64_decode($image));

            // Store path in $validated
            $validated['captured_photo'] = 'captured_photo/' . $imageName;
            // dd($validated['captured_photo']);
        }

        list($year, $month, $day) = explode('-', $validated['purchase_date']);

        // ✅ Add company & branch from logged in user
        $validated['year'] = $year;
        $validated['month'] = $month;
        $validated['day'] = $day;

        $validated['company'] = Auth::user()->company ?? null;
        $validated['branch']  = Auth::user()->branch ?? null;

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
            fputcsv($handle, ['Purchase Date', 'Customer Name', 'Phone', 'Email', 'Address', 'imei_number', 'Product Details', 'Total Amount']);

            // Add data rows
            foreach ($purchases as $purchase) {
                fputcsv($handle, [
                    $purchase->purchase_date,
                    $purchase->customer_name,
                    $purchase->phone_number,
                    $purchase->email,
                    $purchase->customer_address,
                    $purchase->imei_number,
                    $purchase->product_details,
                    $purchase->purchase_amount,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
