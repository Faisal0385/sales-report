<div class="lg:col-span-1 space-y-6">
    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
        <h3 class="font-semibold text-gray-300">Monthly Investment</h3>
        <p class="text-sm text-gray-400">Total for September</p>
        <p class="text-3xl font-bold mt-2">£ {{ $purchase_amount }}</p>
    </div>
    <div class="bg-gray-800 p-6 rounded-lg border border-gray-700">
        <h3 class="font-semibold text-gray-300">Download Report</h3>
        <p class="text-sm text-gray-400 mt-1 mb-4">Select a month and year to download the purchase
            report.</p>
        <form action="{{ route('purchase.download') }}" method="GET">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="purchase-download-year" class="text-sm font-medium text-gray-300">Year</label>
                    <select name="year" id="purchase-download-year"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-1 text-base">
                        @php
                            $years = ['2024', '2025', '2026', '2027', '2028', '2029', '2030'];
                        @endphp
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="purchase-download-month" class="text-sm font-medium text-gray-300">Month</label>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Report
            </button>
        </form>

    </div>
</div>
