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
                    <a href="{{ route('report.page') }}"
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
                    <h1 class="text-xl font-bold">Sales Report of {{ ucfirst($company) }}</h1>
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
                <div class="m-4 p-3 rounded-md bg-red-600 text-white">
                    {{ session('error') }}
                </div>
            @endif
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

            <!-- Main Content Area -->
            <div class="p-6 bg-gray-800 rounded-b-lg">
                <div class="lg:col-span-2 space-y-6 mt-5">

                    <hr>
                    <div class="lg:col-span-2 space-y-6 mt-5">
                        <div class="mt-3">
                            <!-- Recent Sales Entries Table -->
                            <div class="bg-gray-900 p-6 rounded-lg border border-gray-700">
                                <h2 class="text-lg font-semibold">{{ $year }} - {{ $months[$month] }}
                                    {{ $sale_total }}
                                </h2>
                                <p class="text-sm text-gray-400 mt-1 mb-4">A list of sales records for the month.
                                </p>
                            </div>
                        </div>
                        <br>
                    </div>

                    <br>
                    <form action="{{ route('sales.download') }}" method="GET">
                        <input type="hidden" name="year" value="{{ $year }}">
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="company" value="{{ $company }}">
                        <input type="hidden" name="branch" value="{{ $branch }}">
                        <button type="submit"
                            class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Monthly Report (CSV)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>