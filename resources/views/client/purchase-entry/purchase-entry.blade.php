<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Portal</title>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for a clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <style>
        /* Using Inter as the default font */
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom transition for a smoother feel */
        .page {
            transition: opacity 0.3s ease-in-out;
        }

        /* Success message styling */
        .success-message {
            transition: opacity 0.5s, transform 0.5s;
        }

        /* Camera Modal Styling */
        #camera-modal {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

    <div class="w-full max-w-5xl p-4">

        <!-- =================================== -->
        <!--  8. New Purchase Entry Page        -->
        <!-- =================================== -->
        <div id="page-purchase-entry" class="page text-left">
            <!-- Page Header -->
            <div class="bg-gray-800 border-b border-gray-700 rounded-t-lg p-4 flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-400 hover:text-white transition mr-4 p-1 rounded-full hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5 mr-2 text-purple-400">
                                <path
                                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            New Purchase Entry
                        </h1>
                        <p id="purchase-entry-subtitle" class="text-sm text-gray-400"></p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="p-4 rounded-lg bg-red-800 text-red-200 m-4">
                    <strong>Whoops! Something went wrong:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- ✅ Success Message -->
            @if (session('success'))
                <div class="m-4 p-3 rounded-md bg-green-600 text-white">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ❌ Error Message -->
            @if (session('error'))
                <div class="mb-4 p-3 rounded-md bg-red-600 text-white">
                    {{ session('error') }}
                </div>
            @endif


            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Form -->
                <div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg border border-gray-700">
                    <form method="POST" action="{{ route('purchase.store') }}" class="space-y-4"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="date" class="text-sm font-medium text-gray-300">Purchase
                                    Date</label>
                                <input type="date" name="purchase_date" id="purchase-date" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="customer-name" class="text-sm font-medium text-gray-300">Customer
                                    Name</label>
                                <input type="text" name="customer_name" id="customer-name" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="phone-number" class="text-sm font-medium text-gray-300">Phone Number
                                    (UK)</label>
                                <input type="tel" name="phone_number" id="phone-number"
                                    placeholder="e.g. 07123 456789" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="email-address" class="text-sm font-medium text-gray-300">Email Address
                                    (Optional)</label>
                                <input type="email" name="email" id="email-address"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="category_item" class="text-sm font-medium text-gray-300">Category</label>
                                <select name="category" id="category_item" required onchange="subCategory()"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">

                                    @php
                                        $categories = [
                                            'Mobile Phones',
                                            'Tablets',
                                            'Laptops/Macbooks',
                                            'PC and accessories',
                                        ];
                                    @endphp

                                    <option value="">
                                        Select Category
                                    </option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category }}">
                                            {{ $category }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div>
                                <label for="sub_category_id"
                                    class="text-sm font-medium text-gray-300">SubCategory</label>
                                <select name="sub_category" id="sub_category_id" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                                </select>
                            </div>

                        </div>
                        <div>
                            <label for="product-details" class="text-sm font-medium text-gray-300">Product
                                Details</label>
                            <textarea name="product_details" id="product-details" rows="3" required
                                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base"></textarea>
                        </div>


                        {{-- <div class="relative">
                            <label for="imei-number" class="text-sm font-medium text-gray-300">IMEI Number
                                (Mandatory)</label>
                            <input type="text" name="imei_number" id="imei-number" required
                                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base pr-20">
                            <div class="absolute inset-y-0 right-0 top-6 flex items-center pr-3 space-x-2">
                                <button type="button" class="text-gray-400 hover:text-white"><svg
                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.25 2A2.25 2.25 0 002 4.25v11.5A2.25 2.25 0 004.25 18h11.5A2.25 2.25 0 0018 15.75V4.25A2.25 2.25 0 0015.75 2H4.25zM6 7a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                                <button type="button" class="text-gray-400 hover:text-white"><svg
                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                            clip-rule="evenodd" />
                                    </svg></button>
                            </div>
                        </div> --}}

                        <div class="relative">
                            <label for="imei-number" class="text-sm font-medium text-gray-300">IMEI Number
                                (Mandatory)</label>
                            <input type="text" name="imei_number" id="imei-number" required
                                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base pr-20">

                            <div class="absolute inset-y-0 right-0 top-6 flex items-center pr-3 space-x-2">
                                <button type="button" id="start-scan" class="text-gray-400 hover:text-white">
                                    <!-- barcode icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.25 2A2.25 2.25 0 002 4.25v11.5A2.25 2.25 0 004.25 18h11.5A2.25 2.25 0 0018 15.75V4.25A2.25 2.25 0 0015.75 2H4.25zM6 7a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Scanner container (hidden initially) -->
                        <div id="scanner-container"
                            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:1000; margin:0px">
                            <div class="text-center" id="scanner" style="width:100%; height:100%;"></div>
                            <button id="close-scanner"
                                style="position:absolute;top:20px;right:20px;padding:10px;background:red;color:white;">Close</button>
                        </div>




















                        <div>
                            <label for="customer-address" class="text-sm font-medium text-gray-300">Customer Address
                                (Optional)</label>
                            <textarea name="customer_address" id="customer-address" rows="3"
                                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base"></textarea>
                        </div>
                        <div>
                            <label for="customer-id-proof" class="text-sm font-medium text-gray-300">Customer ID
                                Proof (Optional)</label>
                            <div class="mt-1 flex items-center space-x-2">
                                <input type="file" name="customer_id_proof" id="customer-id-proof"
                                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700">
                                <button type="button" onclick="openCamera()"
                                    class="p-2.5 bg-gray-600 rounded-md hover:bg-gray-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M2 4a1 1 0 011-1h1.5a1 1 0 01.98.804l1.32 4.62a1 1 0 01-.364 1.118l-1.132.85a12.182 12.182 0 005.37 5.37l.85-1.132a1 1 0 011.118-.364l4.62 1.32A1 1 0 0116 16.5V18a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                                    </svg>
                                </button>
                            </div>
                            <img id="photo-preview" class="hidden mt-2 rounded-md max-h-24" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                            <label class="text-sm font-medium text-gray-300">Payment Method</label>
                            <div class="mt-2 flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash" checked
                                        class="h-4 w-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500"
                                        id="cashRadio"><span class="ml-2 text-sm">Cash</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="bank_transfer"
                                        class="h-4 w-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500"
                                        id="bankTransferRadio">
                                    <span class="ml-2 text-sm">Bank Transfer</span>
                                </label>
                            </div>
                        </div>

                        <div id="bankTransferFields" style="display: none; margin-top:10px;">
                            <div>
                                <label for="bank_transfer_name" class="text-sm font-medium text-gray-300">Name</label>
                                <input type="text" name="bank_transfer_name" id="bank_transfer_name"
                                    step="any" min="1"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="bank_transfer_sort_code" class="text-sm font-medium text-gray-300">Sort
                                    Code</label>
                                <input type="text" name="bank_transfer_sort_code" id="bank_transfer_sort_code"
                                    step="any" min="1"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="bank_transfer_account" class="text-sm font-medium text-gray-300">Account
                                    Number</label>
                                <input type="text" name="bank_transfer_account" id="bank_transfer_account"
                                    step="any" min="1"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                        </div>

                        <div>
                            <label for="purchase-amount" class="text-sm font-medium text-gray-300">Purchase Amount
                                (£)</label>
                            <input type="number" name="purchase_amount" id="purchase-amount" value="0"
                                required step="any" min="1"
                                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                        </div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                            Add Purchase
                        </button>
                    </form>
                </div>

                <!-- Right Column: Info Cards -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                        <h3 class="font-semibold text-gray-300">Monthly Investment</h3>
                        <p class="text-sm text-gray-400">Total for September</p>
                        <p class="text-3xl font-bold mt-2">£ {{ $purchase_amount }}</p>
                    </div>
                    {{-- <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                        <h3 class="font-semibold text-gray-300">Upload Report</h3>
                        <p class="text-sm text-gray-400 mt-1 mb-2">Let the AI assistant parse your CSV file.</p>
                        <input type="file"
                            class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600">
                    </div> --}}
                    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
                        <h3 class="font-semibold text-gray-300">Download Report</h3>
                        <p class="text-sm text-gray-400 mt-1 mb-4">Select a month and year to download the purchase
                            report.</p>
                        <form action="{{ route('purchase.download') }}" method="GET">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="purchase-download-year"
                                        class="text-sm font-medium text-gray-300">Year</label>
                                    <select name="year" id="purchase-download-year"
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-1 text-base">
                                        @php
                                            $years = ['2024', '2025', '2026', '2027', '2028', '2029', '2030'];
                                        @endphp
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ $year == date('Y') ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="purchase-download-month"
                                        class="text-sm font-medium text-gray-300">Month</label>
                                    <select name="month" id="purchase-download-month"
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-1 text-base">
                                        @php
                                            $months = [
                                                '01' => 'January',
                                                '02' => 'February',
                                                '03' => 'March',
                                                '04' => 'April',
                                                '05' => 'May',
                                                '06' => 'June',
                                                '07' => 'July',
                                                '08' => 'August',
                                                '09' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December',
                                            ];
                                        @endphp
                                        @foreach ($months as $key => $month)
                                            <option value="{{ $key }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full flex items-center justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Report
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Recent Purchases Table -->
            <div class="mt-6 bg-gray-800 p-6 rounded-lg border border-gray-700">
                <h2 class="text-xl font-bold">Recent Purchases</h2>
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full text-sm text-left">
                        <thead class="border-b border-gray-700 text-gray-400">
                            <tr>
                                <th class="py-2 px-3 font-medium">SL</th>
                                <th class="py-2 px-3 font-medium">Date</th>
                                <th class="py-2 px-3 font-medium">Customer</th>
                                <th class="py-2 px-3 font-medium">Product</th>
                                <th class="py-2 px-3 font-medium">IMEI/SN</th>
                                <th class="py-2 px-3 font-medium">Phone</th>
                                <th class="py-2 px-3 font-medium">Payment</th>
                                <th class="py-2 px-3 font-medium">Amount</th>
                                <th class="py-2 px-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recent-purchases-tbody">
                            @forelse($purchases as $key => $purchase)
                                <tr>
                                    <td class="py-3 px-3">{{ $key + 1 }}</td>
                                    <td class="py-3 px-3">{{ $purchase->purchase_date }}</td>
                                    <td class="py-3 px-3">{{ $purchase->customer_name }}</td>
                                    <td class="py-3 px-3">{{ $purchase->product_details }}</td>
                                    <td class="py-3 px-3">{{ $purchase->imei_number }}</td>
                                    <td class="py-3 px-3">{{ $purchase->phone_number }}</td>
                                    <td class="py-3 px-3">{{ $purchase->payment_method }}</td>
                                    <td class="py-3 px-3 font-semibold">
                                        £{{ number_format($purchase->purchase_amount, 2) }}</td>
                                    <td class="py-3 px-3 text-right">
                                        <form action="{{ route('purchase.destroy', $purchase->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                            @csrf
                                            <button type="submit"
                                                class="text-gray-500 hover:text-red-400 p-1 rounded-full transition-colors"
                                                title="Delete Sale">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-gray-400">
                                        <p id="no-purchases-message" class="text-center text-gray-500 py-8">No
                                            purchases yet.</p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Camera Modal -->
        <div id="camera-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
            <div class="bg-gray-800 rounded-lg p-4 max-w-lg w-full relative">
                <video id="camera-stream" class="w-full rounded-md" autoplay playsinline></video>
                <canvas id="camera-canvas" class="hidden"></canvas>
                <div class="mt-4 flex justify-center space-x-4">
                    <button id="capture-btn"
                        class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700">Capture
                        Photo</button>
                    <button onclick="closeCamera()"
                        class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-500">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Include html5-qrcode from CDN -->


    <script>
        document.getElementById('bankTransferRadio').addEventListener('change', function() {
            const fields = document.getElementById('bankTransferFields');
            if (this.checked) {
                fields.style.display = 'block';
            }
        });

        document.getElementById('cashRadio').addEventListener('change', function() {
            const fields = document.getElementById('bankTransferFields');
            if (this.checked) {
                fields.style.display = 'none';
            }
        });

        const subCategories = {
            'Mobile Phones': ['iPhone', 'Android Phone'],
            'Tablets': ['iPad', 'Android Tablet'],
            'Laptops/Macbooks': ['Laptop', 'Macbook'],
            'PC and accessories': ['Windows PC', 'Mac', 'Accessories'],
        };


        function subCategory() {
            let category_item = document.getElementById('category_item').value;
            let select = document.getElementById('sub_category_id');

            // Clear old options
            select.innerHTML = "";

            // Fill with new options
            subCategories[category_item].forEach(element => {
                let option = document.createElement("option");
                option.value = element;
                option.text = element;
                select.appendChild(option);
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
    <script>
        document.getElementById("start-scan").addEventListener("click", function() {
            document.getElementById("scanner-container").style.display = "block";

            Quagga.init({
                inputStream: {
                    type: "LiveStream",
                    target: document.querySelector('#scanner'),
                    constraints: {
                        facingMode: "environment" // use back camera
                    }
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "upc_reader"]
                }
            }, function(err) {
                if (err) {
                    console.error(err);
                    alert("Camera initialization failed.");
                    return;
                }
                Quagga.start();
            });

            Quagga.onDetected(function(result) {
                console.log("Scanned Code:", result.codeResult.code);
                document.getElementById("imei-number").value = result.codeResult.code;

                // Stop scanning
                Quagga.stop();
                document.getElementById("scanner-container").style.display = "none";
            });
        });

        document.getElementById("close-scanner").addEventListener("click", function() {
            Quagga.stop();
            document.getElementById("scanner-container").style.display = "none";
        });
    </script>


</body>

</html>
