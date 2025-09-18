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
        <!--  5. Sales Report Page              -->
        <!-- =================================== -->
        <div id="page-sales-report" class="page text-left">
            <!-- Page Header -->
            <div class="bg-gray-800 border-b border-gray-700 rounded-t-lg p-4 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-400 hover:text-white transition mr-4 p-1 rounded-full hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div class="bg-purple-600 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M3.5 2.5a.5.5 0 00-1 0V4a.5.5 0 00.5.5H4v10.5a.5.5 0 00.5.5h10.5V16a.5.5 0 00.5.5h1.5a.5.5 0 000-1H16v-1.5a.5.5 0 00-.5-.5H4V4h1.5a.5.5 0 000-1H4a.5.5 0 00-.5-.5V2.5z" />
                            <path
                                d="M15 3a.5.5 0 01.5.5v1.5a.5.5 0 01-1 0V4a.5.5 0 01.5-.5zM6 3a.5.5 0 01.5.5v1.5a.5.5 0 01-1 0V4a.5.5 0 01.5-.5zm3.5 11.5a.5.5 0 00-1 0V16a.5.5 0 00.5.5h1.5a.5.5 0 000-1H10v-1.5a.5.5 0 00-.5-.5z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold">{{ Auth::user()->company ?? '' }} - Sales Report</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </button>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-800 text-red-200 m-4">
                    <strong>Whoops! Something went wrong:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Content Area -->
            <div class="p-6 bg-gray-800 rounded-b-lg">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-3 space-y-6">
                        <!-- New Sales Entry Form -->
                        <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                            <h2 class="text-lg font-semibold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 mr-2 text-purple-400">
                                    <path
                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                New Sales Entry
                            </h2>
                            <p class="text-sm text-gray-400 mt-1 mb-4">Fill in the sales figures for today. The daily
                                total will be calculated automatically.</p>



                            <form id="sales-entry-form" method="POST" action="{{ route('sales.store') }}">
                                @csrf
                                <div class="mb-4 relative">
                                    <label for="sales-date" class="text-sm font-medium text-gray-300">Date</label>
                                    <span class="absolute left-3 top-9 text-gray-400 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input type="date" id="sales-date" name="sales_date"
                                        value="{{ old('sales_date', \Carbon\Carbon::today()->toDateString()) }}"
                                        class="pl-10 mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm py-2 px-3 text-base appearance-none focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="cash-sales" class="text-sm font-medium text-gray-300">Cash
                                            Sales</label>
                                        <input type="number" id="cash-sales" name="cash_sales" min="0"
                                            oninput="updateDailyTotal()" value="0" step="any"
                                            class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                                    </div>
                                    <div>
                                        <label for="techpoint-sales" class="text-sm font-medium text-gray-300">TechPoint
                                            Sales</label>
                                        <input type="number" id="techpoint-sales" name="techpoint_sales"
                                            oninput="updateDailyTotal()" value="0" step="any" min="0"
                                            class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                                    </div>
                                </div>
                                <div class="bg-gray-800 rounded-lg p-4 flex justify-between items-center mb-4">
                                    <span class="font-semibold">Daily Total:</span>
                                    <span id="daily-total" class="text-2xl font-bold text-purple-400">£0.00</span>
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                                    Add Daily Entry
                                </button>
                            </form>

                        </div>

                        <!-- Monthly Total -->
                        <div
                            class="bg-gray-900 p-6 rounded-lg border border-gray-700 flex justify-between items-center">
                            <div>

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

                                <h3 class="font-semibold text-gray-300">Monthly Total</h3>
                                <p class="text-sm text-gray-400">Total sales for {{ $months[date('m')] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold">£ {{ $daily_total }}</p>
                            </div>
                        </div>

                        <!-- Recent Sales Entries Table -->
                        <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                            <h2 class="text-lg font-semibold">Recent Sales Entries</h2>
                            <p class="text-sm text-gray-400 mt-1 mb-4">A list of sales records for the current month.
                            </p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left">
                                    <thead class="border-b border-gray-700 text-gray-400">
                                        <tr>
                                            <th class="py-2 px-3 font-medium">SL</th>
                                            <th class="py-2 px-3 font-medium">Date</th>
                                            <th class="py-2 px-3 font-medium">Cash</th>
                                            <th class="py-2 px-3 font-medium">TechPoint</th>
                                            <th class="py-2 px-3 font-medium">Daily Total</th>
                                            <th class="py-2 px-3 font-medium text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales-entries-tbody">

                                        @foreach ($sales as $key => $sale)
                                            <tr>
                                                <td class="py-3 px-3">{{ $key + 1 }}</td>
                                                <td class="py-3 px-3">{{ $sale->sales_date }}</td>
                                                <td class="py-3 px-3">{{ $sale->cash_sales }}</td>
                                                <td class="py-3 px-3">{{ $sale->techpoint_sales }}</td>
                                                <td class="py-3 px-3 font-semibold">
                                                    £{{ number_format($sale->daily_total, 2) }}</td>
                                                <td class="py-3 px-3 text-right">
                                                    <form action="{{ route('sales.destroy', $sale->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-gray-500 hover:text-red-400 p-1 rounded-full transition-colors"
                                                            title="Delete Sale">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                <p id="no-sales-message" class="text-center text-gray-500 py-8">No sales entries for
                                    this month yet.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Monthly Target Card -->
                        <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                            <h2 class="text-lg font-semibold flex items-center justify-between">
                                Monthly Target
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </h2>
                            <p class="text-gray-400 text-3xl font-bold mt-4">£1.00</p>
                            <p class="text-sm text-gray-500">No data from last year to set a target.</p>
                            <div class="relative w-48 h-48 mx-auto my-6">
                                <svg class="w-full h-full" viewBox="0 0 100 100">
                                    <!-- Background circle -->
                                    <circle class="text-gray-700" stroke-width="10" cx="50" cy="50"
                                        r="40" fill="transparent" stroke="currentColor"></circle>
                                    <!-- Progress circle -->
                                    <circle id="target-progress-circle" class="text-purple-500" stroke-width="10"
                                        cx="50" cy="50" r="40" fill="transparent"
                                        stroke="currentColor" stroke-linecap="round"
                                        style="transform: rotate(-90deg); transform-origin: 50% 50%;"
                                        stroke-dasharray="251.2" stroke-dashoffset="251.2"></circle>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-green-400 font-semibold flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                    </svg>
                                    Target is looking good!
                                </p>
                                <p class="text-sm text-gray-400">You are £848567.00 over the target.</p>
                            </div>
                        </div>

                        <!-- Add Monthly Total Sale -->
                        {{-- <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                            <h2 class="text-lg font-semibold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-purple-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Add Monthly Total Sale
                            </h2>
                            <p class="text-sm text-gray-400 mt-1 mb-4">Manually enter a total sales amount for a past
                                month or year for historical tracking.</p>
                            <form onsubmit="handleAddMonthlyTotal(event)">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="monthly-total-year"
                                            class="text-sm font-medium text-gray-300">Year</label>
                                        <select id="monthly-total-year"
                                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm py-2 px-3 text-base focus:outline-none focus:ring-purple-500 focus:border-purple-500"></select>
                                    </div>
                                    <div>
                                        <label for="monthly-total-month"
                                            class="text-sm font-medium text-gray-300">Month</label>
                                        <select id="monthly-total-month"
                                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm py-2 px-3 text-base focus:outline-none focus:ring-purple-500 focus:border-purple-500"></select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="monthly-total-amount" class="text-sm font-medium text-gray-300">Total
                                        Sale Amount (£)</label>
                                    <input type="number" id="monthly-total-amount" value="0" step="any"
                                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                                </div>
                                <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                                    Add Monthly Total
                                </button>
                            </form>
                        </div> --}}

                        <!-- Download Monthly Report -->
                        <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                            <h2 class="text-lg font-semibold">Download Monthly Report</h2>
                            <p class="text-sm text-gray-400 mt-1 mb-4">Select a year and month to export sales data to
                                a CSV file.</p>
                            <form onsubmit="handleDownloadMonthlyReport(event)">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="download-monthly-year"
                                            class="text-sm font-medium text-gray-300">Year</label>
                                        <select id="download-monthly-year"
                                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm py-2 px-3 text-base focus:outline-none focus:ring-purple-500 focus:border-purple-500">


                                            @php

                                                $years = ['2024', '2025', '2026', '2027', '2028', '2029', '2030'];

                                            @endphp

                                            @foreach ($years as $key => $year)
                                                <option value="{{ $year }}"
                                                    {{ $year == date('Y') ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div>
                                        <label for="download-monthly-month"
                                            class="text-sm font-medium text-gray-300">Month</label>
                                        <select id="download-monthly-month"
                                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm py-2 px-3 text-base focus:outline-none focus:ring-purple-500 focus:border-purple-500">

                                            @foreach ($months as $key => $month)
                                                <option value="{{ $key }}">{{ $month }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download Monthly Report (CSV)
                                </button>
                            </form>
                        </div>

                        <!-- Download Yearly Report -->
                        <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                            <h2 class="text-lg font-semibold">Download Yearly Report</h2>
                            <p class="text-sm text-gray-400 mt-1 mb-4">Select a year to export all its sales data to a
                                CSV file.</p>
                            <form onsubmit="handleDownloadYearlyReport(event)">
                                <div class="mb-4">
                                    <label for="download-yearly-year"
                                        class="text-sm font-medium text-gray-300">Year</label>
                                    <select id="download-yearly-year"
                                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm py-2 px-3 text-base focus:outline-none focus:ring-purple-500 focus:border-purple-500">

                                        @php
                                            $years = ['2024', '2025', '2026', '2027', '2028', '2029', '2030'];
                                        @endphp

                                        @foreach ($years as $key => $year)
                                            <option value="{{ $year }}"
                                                {{ $year == date('Y') ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <button type="submit"
                                    class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download Yearly Report (CSV)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Store references to the page elements
        const pages = {
            'page-select-company': document.getElementById('page-select-company'),
            'page-select-branch': document.getElementById('page-select-branch'),
            'page-login': document.getElementById('page-login'),
            'page-signup': document.getElementById('page-signup'),
            'page-dashboard': document.getElementById('page-dashboard'),
            'page-sales-report': document.getElementById('page-sales-report'),
            'page-buy-products': document.getElementById('page-buy-products'),
            'page-buy-products-subcategory': document.getElementById('page-buy-products-subcategory'),
            'page-purchase-entry': document.getElementById('page-purchase-entry')
        };

        const loginTitle = document.getElementById('login-title');
        const loginIcon = document.getElementById('login-icon');
        const loginError = document.getElementById('login-error');
        const passwordInput = document.getElementById('password');

        // This object maps company names to their specific icons (as SVG strings)
        const companyIcons = {
            'TechPoint': `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M12 6V5m0 14v-1M9 6l1.293-1.293a1 1 0 011.414 0L12 6m0 12l1.293 1.293a1 1 0 001.414 0L15 18M9.75 12h4.5M12 9.75v4.5" /></svg>`,
            'TikTech': `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18h3" /></svg>`,
            'Restaurant': `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.362-3.797z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214C16.317 4.209 17.587 3 19.5 3c2.21 0 4 1.79 4 4 0 1.913-.91 3.56-2.35 4.638M12 12.75h9" /></svg>`
        };

        // Defines the options for each product category
        const subCategories = {
            'Mobile Phones': ['iPhone', 'Android Phone'],
            'Tablets': ['iPad', 'Android Tablet'],
            'Laptops/Macbooks': ['Laptop', 'Macbook'],
            'PC and accessories': ['Windows PC', 'Mac', 'Accessories'],
        };

        let currentPurchaseCategory = ''; // To store the selected product type
        let recentPurchases = []; // To store purchase entry data
        let nextPurchaseId = 1;
        let cameraStream = null; // To hold the camera stream object

        // --- Core Navigation Logic ---
        function showPage(pageIdToShow) {
            // Hide all pages
            for (const pageId in pages) {
                pages[pageId].classList.add('hidden', 'opacity-0');
            }
            // Show the target page with a fade-in effect
            const pageToShow = pages[pageIdToShow];
            if (pageToShow) {
                pageToShow.classList.remove('hidden');
                // A tiny delay allows the 'display' property to update before starting the transition
                setTimeout(() => {
                    pageToShow.classList.remove('opacity-0');
                }, 10);
            }
            // Reset form states when navigating away
            loginError.classList.add('hidden');
            passwordInput.value = '';
            document.getElementById('signup-success').classList.add('hidden', 'opacity-0', '-translate-y-2');


            // Initialize the sales report page when it's shown
            if (pageIdToShow === 'page-sales-report') {
                initializeSalesReport();
            }

            // Initialize the purchase entry page when it's shown
            if (pageIdToShow === 'page-purchase-entry') {
                initializePurchaseEntryPage();
            }
        }

        // --- Page Interaction Logic ---

        // Called when a user clicks on a product category card
        function selectProductCategory(categoryName) {
            const subCategoryOptions = subCategories[categoryName];
            const subCategoryTitle = document.getElementById('subcategory-title');
            const subCategoryGrid = document.getElementById('subcategory-grid');

            // Clear previous options from the grid
            subCategoryGrid.innerHTML = '';

            // Check if this category has defined sub-categories
            if (subCategoryOptions) {
                subCategoryTitle.textContent = `What kind of ${categoryName.toLowerCase()}?`;

                // Create and add a card for each sub-category option
                subCategoryOptions.forEach(option => {
                    const card = document.createElement('div');
                    card.className =
                        'bg-gray-800 p-8 rounded-lg border border-gray-700 hover:bg-gray-700 hover:border-purple-500 cursor-pointer transition-all duration-300 flex items-center justify-center';
                    card.innerHTML = `<h3 class="font-semibold text-lg">${option}</h3>`;
                    card.onclick = () => selectSubCategory(categoryName, option);
                    subCategoryGrid.appendChild(card);
                });

                showPage('page-buy-products-subcategory');
            } else {
                // Fallback for categories without defined sub-categories (like Cameras or Other electronics)
                console.log(`Selected product category: ${categoryName}`);

                // Store the main category as the selected product type
                currentPurchaseCategory = categoryName;

                // Update the subtitle on the purchase entry form
                const subtitle = document.getElementById('purchase-entry-subtitle');
                subtitle.textContent = `Enter details of the product bought from a customer for category: ${categoryName}.`;

                // Show the final purchase entry page directly
                showPage('page-purchase-entry');
            }
        }

        // Called when a user clicks on a sub-category card (e.g., iPhone)
        function selectSubCategory(category, subCategory) {
            console.log(`Final Selection: ${category} -> ${subCategory}`);
            // Store the selection for when the form is submitted
            currentPurchaseCategory = subCategory;

            // Update the title on the purchase entry form
            const subtitle = document.getElementById('purchase-entry-subtitle');
            subtitle.textContent = `Enter details of the product bought from a customer for category: ${subCategory}.`;
            // Show the final purchase entry page
            showPage('page-purchase-entry');
        }

        // Called when a user clicks on a company card
        function selectCompany(companyName) {
            if (companyName === 'TikTech') {
                showPage('page-select-branch');
            } else {
                loginTitle.textContent = `Login to ${companyName}`;
                loginIcon.innerHTML = companyIcons[companyName] || '';
                showPage('page-login');
            }
        }

        // Called when a user selects a TikTech branch
        function selectBranch(branchName) {
            loginTitle.textContent = `Login to ${branchName}`;
            // Use the generic 'Building' icon for all branches
            loginIcon.innerHTML =
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6M9 11.25h6M9 15.75h6" /></svg>`;
            showPage('page-login');
        }

        // Simulates a backend login check
        function handleLogin(event) {
            event.preventDefault(); // Prevents the form from reloading the page

            const email = event.target.email.value;
            const password = event.target.password.value;

            loginError.classList.add('hidden');

            // --- SIMULATED LOGIN ---
            // Try logging in with: m@example.com and password123
            if (email === 'm@example.com' && password === 'password123') {
                // Successful login
                showPage('page-dashboard');
            } else {
                // Failed login
                loginError.classList.remove('hidden');
            }
        }

        // Simulates a signup process
        function handleSignup(event) {
            event.preventDefault();
            const successMessage = document.getElementById('signup-success');

            // Show success message with animation
            successMessage.classList.remove('hidden');
            setTimeout(() => {
                successMessage.classList.remove('opacity-0', '-translate-y-2');
            }, 10);

            // After a delay, redirect to the login page
            setTimeout(() => {
                showPage('page-login');
            }, 2000); // 2-second delay
        }

        // --- New Purchase Entry Page Logic ---
        function initializePurchaseEntryPage() {
            // Set the purchase date to today by default
            const purchaseDateField = document.getElementById('purchase-date');
            if (!purchaseDateField.value) {
                purchaseDateField.value = new Date().toISOString().split('T')[0];
            }
            // Populate dropdowns for this page
            populateDateDropdowns('purchase-download-year', 'purchase-download-month');
            // Render the recent purchases table
            renderPurchaseTable();
        }

        function handlePurchaseEntry(event) {
            event.preventDefault();

            const newPurchase = {
                id: nextPurchaseId++,
                date: document.getElementById('purchase-date').value,
                customer: document.getElementById('customer-name').value,
                product: currentPurchaseCategory, // Use the stored category
                imei: document.getElementById('imei-number').value,
                phone: document.getElementById('phone-number').value,
                payment: document.querySelector('input[name="payment"]:checked').value,
                amount: parseFloat(document.getElementById('purchase-amount').value) || 0,
            };

            recentPurchases.unshift(newPurchase);
            renderPurchaseTable();

            console.log(`New purchase logged:`, newPurchase);

            // Reset the form for the next entry
            event.target.reset();
            document.getElementById('purchase-date').value = new Date().toISOString().split('T')[0]; // Reset date to today
            document.getElementById('photo-preview').classList.add('hidden');
        }

        function renderPurchaseTable() {
            const tbody = document.getElementById('recent-purchases-tbody');
            const noPurchasesMessage = document.getElementById('no-purchases-message');
            tbody.innerHTML = '';

            if (recentPurchases.length === 0) {
                noPurchasesMessage.classList.remove('hidden');
            } else {
                noPurchasesMessage.classList.add('hidden');
                recentPurchases.forEach(purchase => {
                    const formattedDate = new Date(purchase.date + 'T00:00:00').toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short'
                    });
                    const row = document.createElement('tr');
                    row.className = 'border-b border-gray-700 hover:bg-gray-700/50';
                    row.innerHTML = `
                        <td class="py-3 px-3">${formattedDate}</td>
                        <td class="py-3 px-3">${purchase.customer}</td>
                        <td class="py-3 px-3">${purchase.product}</td>
                        <td class="py-3 px-3">${purchase.imei}</td>
                        <td class="py-3 px-3">${purchase.phone}</td>
                        <td class="py-3 px-3 capitalize">${purchase.payment}</td>
                        <td class="py-3 px-3 font-semibold">£${purchase.amount.toFixed(2)}</td>
                        <td class="py-3 px-3 text-right">
                             <button onclick="deletePurchaseEntry(${purchase.id})" class="text-gray-500 hover:text-red-400 p-1 rounded-full transition-colors" title="Delete Purchase">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
        }

        function deletePurchaseEntry(purchaseId) {
            recentPurchases = recentPurchases.filter(p => p.id !== purchaseId);
            renderPurchaseTable();
        }

        // --- Camera Logic ---
        async function openCamera() {
            const modal = document.getElementById('camera-modal');
            const video = document.getElementById('camera-stream');

            try {
                // Request access to the user's camera
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                });
                video.srcObject = cameraStream;
                modal.classList.remove('hidden');
            } catch (err) {
                console.error("Error accessing camera: ", err);
                alert("Could not access the camera. Please ensure you have given permission.");
            }
        }

        function closeCamera() {
            const modal = document.getElementById('camera-modal');
            if (cameraStream) {
                // Stop all video tracks to turn off the camera light
                cameraStream.getTracks().forEach(track => track.stop());
            }
            modal.classList.add('hidden');
        }

        document.getElementById('capture-btn').addEventListener('click', () => {
            const canvas = document.getElementById('camera-canvas');
            const video = document.getElementById('camera-stream');
            const preview = document.getElementById('photo-preview');

            // Set canvas dimensions to match the video stream
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw the current video frame onto the canvas
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            // Get the image data from the canvas
            const imageDataUrl = canvas.toDataURL('image/jpeg');

            // Display the captured image as a preview on the form
            preview.src = imageDataUrl;
            preview.classList.remove('hidden');

            // Close the camera modal
            closeCamera();
        });


        // --- Sales Report Page Logic (Simulated Backend) ---

        // This array acts as our in-memory database for sales.
        let salesData = [];
        let nextId = 1; // To give each sales entry a unique ID

        function initializeSalesReport() {
            // Set current date if not already set
            const dateField = document.getElementById('sales-date');
            if (dateField && !dateField.value) {
                dateField.value = new Date().toISOString().split('T')[0];
            }

            // Populate the "database" with initial data if it's empty
            if (salesData.length === 0) {
                salesData = [{
                        id: 1,
                        date: '2025-09-09',
                        cash: 250.00,
                        techpoint: 125.50
                    },
                    {
                        id: 2,
                        date: '2025-09-08',
                        cash: 180.25,
                        techpoint: 90.00
                    },
                ];
                nextId = 3;
            }

            // Populate Year and Month dropdowns for this specific page
            populateDateDropdowns('monthly-total-year', 'monthly-total-month');
            populateDateDropdowns('download-monthly-year', 'download-monthly-month');
            populateDateDropdowns('download-yearly-year', null);

            // Render the progress chart with dummy data
            renderMonthlyTargetChart(75);
            // Render the sales table from our array
            renderSalesTable();
            // Ensure total is correct on page load
            updateDailyTotal();
        }

        function addSalesEntry(event) {
            event.preventDefault();
            const cashSalesInput = document.getElementById('cash-sales');
            const techpointSalesInput = document.getElementById('techpoint-sales');

            const newEntry = {
                id: nextId++, // Assign a new unique ID
                date: document.getElementById('sales-date').value,
                cash: parseFloat(cashSalesInput.value) || 0,
                techpoint: parseFloat(techpointSalesInput.value) || 0,
            };

            // Add the new entry to the start of our data array
            salesData.unshift(newEntry);

            // Re-render the table to show the change
            renderSalesTable();

            // Reset the form for the next entry
            cashSalesInput.value = '0';
            techpointSalesInput.value = '0';
            updateDailyTotal();
        }

        function deleteSalesEntry(entryId) {
            // Filter the array to remove the entry with the matching ID
            salesData = salesData.filter(entry => entry.id !== entryId);

            // Re-render the table
            renderSalesTable();
        }

        function renderSalesTable() {
            const tbody = document.getElementById('sales-entries-tbody');
            const noSalesMessage = document.getElementById('no-sales-message');
            if (!tbody || !noSalesMessage) return; // Safety check
            tbody.innerHTML = ''; // Clear existing rows

            // Sort data so the newest entries are always on top
            const sortedData = salesData.sort((a, b) => b.id - a.id);

            if (sortedData.length === 0) {
                noSalesMessage.classList.remove('hidden');
            } else {
                noSalesMessage.classList.add('hidden');
                sortedData.forEach(entry => {
                    const total = (entry.cash + entry.techpoint).toFixed(2);
                    const formattedDate = new Date(entry.date + 'T00:00:00').toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    const row = document.createElement('tr');
                    row.className = 'border-b border-gray-800 hover:bg-gray-800/50';
                    row.innerHTML = `
                        <td class="py-3 px-3">${formattedDate}</td>
                        <td class="py-3 px-3">£${entry.cash.toFixed(2)}</td>
                        <td class="py-3 px-3">£${entry.techpoint.toFixed(2)}</td>
                        <td class="py-3 px-3 font-bold">£${total}</td>
                        <td class="py-3 px-3 text-right">
                            <button onclick="deleteSalesEntry(${entry.id})" class="text-gray-500 hover:text-red-400 p-1 rounded-full transition-colors" title="Delete Entry">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
        }

        // --- Helper & Static Functions ---

        function updateDailyTotal() {
            // FIX: Get elements fresh each time to avoid errors
            const cashSalesInput = document.getElementById('cash-sales');
            const techpointSalesInput = document.getElementById('techpoint-sales');
            const dailyTotalDisplay = document.getElementById('daily-total');

            if (cashSalesInput && techpointSalesInput && dailyTotalDisplay) {
                const cash = parseFloat(cashSalesInput.value) || 0;
                const techpoint = parseFloat(techpointSalesInput.value) || 0;
                const total = cash + techpoint;
                dailyTotalDisplay.textContent = `£${total.toFixed(2)}`;
            }
        }

        function populateDateDropdowns(yearSelectId, monthSelectId) {
            const yearSelect = document.getElementById(yearSelectId);
            const monthSelect = monthSelectId ? document.getElementById(monthSelectId) : null;

            if (!yearSelect) return; // Safely exit if the element isn't on the current page

            const currentYear = new Date().getFullYear();

            // Populate years if the dropdown is empty
            if (yearSelect.options.length === 0) {
                for (let i = 0; i < 5; i++) {
                    const year = currentYear - i;
                    yearSelect.add(new Option(year, year));
                }
            }
            yearSelect.value = '2025';

            if (!monthSelect) return; // Safely exit for elements without a month dropdown

            // Populate months if the dropdown is empty
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];
            if (monthSelect.options.length === 0) {
                months.forEach((month, index) => {
                    monthSelect.add(new Option(month, index + 1));
                });
            }
            monthSelect.value = '9'; // September
        }

        function renderMonthlyTargetChart(percentage) {
            const circle = document.getElementById('target-progress-circle');
            if (!circle) return; // Safety check
            const radius = circle.r.baseVal.value;
            const circumference = 2 * Math.PI * radius;

            const offset = circumference - (percentage / 100) * circumference;

            circle.style.strokeDasharray = `${circumference} ${circumference}`;
            circle.style.strokeDashoffset = offset;
        }

        function handleAddMonthlyTotal(event) {
            event.preventDefault();
            const year = document.getElementById('monthly-total-year').value;
            const month = document.getElementById('monthly-total-month').value;
            const amount = document.getElementById('monthly-total-amount').value;

            console.log(`Adding monthly total for ${month}/${year}: £${amount}`);
            alert(`Monthly total of £${amount} for ${month}/${year} has been recorded in the console.`);
            document.getElementById('monthly-total-amount').value = '0';
        }

        function handleDownloadMonthlyReport(event) {
            event.preventDefault();
            const year = document.getElementById('download-monthly-year').value;
            const month = document.getElementById('download-monthly-month').value.padStart(2, '0');
            const monthName = document.getElementById('download-monthly-month').options[document.getElementById(
                'download-monthly-month').selectedIndex].text;

            const reportData = salesData.filter(d => d.date.startsWith(`${year}-${month}`));

            if (reportData.length === 0) {
                alert(`No sales data found for ${monthName} ${year} to download.`);
                return;
            }

            let csvContent = "Date,Cash Sales,TechPoint Sales,Daily Total\n";
            reportData.forEach(row => {
                const total = (row.cash + row.techpoint).toFixed(2);
                csvContent += `${row.date},${row.cash.toFixed(2)},${row.techpoint.toFixed(2)},${total}\n`;
            });

            downloadCSV(csvContent, `monthly-report-${year}-${month}.csv`);
        }

        function handleDownloadYearlyReport(event) {
            event.preventDefault();
            const year = document.getElementById('download-yearly-year').value;

            const reportData = salesData.filter(d => d.date.startsWith(year));

            if (reportData.length === 0) {
                alert(`No sales data found for ${year} to download.`);
                return;
            }

            let csvContent = "Date,Cash Sales,TechPoint Sales,Daily Total\n";
            reportData.forEach(row => {
                const total = (row.cash + row.techpoint).toFixed(2);
                csvContent += `${row.date},${row.cash.toFixed(2)},${row.techpoint.toFixed(2)},${total}\n`;
            });

            downloadCSV(csvContent, `yearly-report-${year}.csv`);
        }

        function downloadCSV(csvContent, fileName) {
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement("a");
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", fileName);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    </script>

    <style>
        /* Hides the default calendar icon so we can use our own SVG icon */
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }

        /* Dark mode styling for date picker */
        input[type="date"] {
            color-scheme: dark;
        }
    </style>
</body>

</html>
