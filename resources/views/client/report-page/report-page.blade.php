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
        <!--  4. Dashboard Page                  -->
        <!-- =================================== -->
        <div id="page-dashboard" class="page text-center mx-auto">
            <div>
                <h1 class="text-3xl font-bold">All Reports</h1>
                <p class="text-gray-400 mt-2">Select an option to get started.</p>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Sales Report Card -->
                <a href="{{ route('sale.report.page') }}"
                    class="bg-gray-800 p-6 rounded-lg border border-gray-700 hover:bg-gray-700 hover:border-purple-500 cursor-pointer transition-all duration-300">
                    <!-- Icon: Chart -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-400 mx-auto" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    <h3 class="font-semibold mt-4 text-lg">Sales Report</h3>
                    <p class="text-sm text-gray-400 mt-1">View Reports</p>
                </a>
                <!-- Buy Products Card -->
                <a href="{{ route('purchase.report.page') }}"
                    class="bg-gray-800 p-6 rounded-lg border border-gray-700 hover:bg-gray-700 hover:border-purple-500 cursor-pointer transition-all duration-300">
                    <!-- Icon: Cart -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-400 mx-auto" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l1.823-6.836a.75.75 0 00-.54-.92l-14.25-3.562a.75.75 0 00-.91.54l-1.823 6.836A1.125 1.125 0 004.875 11.25H7.5M7.5 14.25c0-1.657 1.343-3 3-3h4.5c1.657 0 3 1.343 3 3M7.5 14.25v3h4.5v-3m4.5 0v3h-4.5v-3" />
                    </svg>
                    <h3 class="font-semibold mt-4 text-lg">Purchase Report</h3>
                    <p class="text-sm text-gray-400 mt-1">View Reports</p>
                </a>
            </div>

            <div class="p-3 m-3">
                <a href="{{ route('dashboard') }}" class="mt-8 text-sm text-gray-400 hover:text-white transition">&larr;
                    Back</a>
            </div>
        </div>
    </div>
</body>

</html>
