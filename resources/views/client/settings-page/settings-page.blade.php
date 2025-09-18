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
                            Create New user
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
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                <!-- Left Column: Form -->
                <div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg border border-gray-700">
                    <form method="POST" action="{{ route('settings.store') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="customer-name" class="text-sm font-medium text-gray-300">Customer
                                    Name</label>
                                <input type="text" name="name" id="customer-name" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="email-address" class="text-sm font-medium text-gray-300">Email Address
                                </label>
                                <input type="email" name="email" id="email-address"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="text-sm font-medium text-gray-300">Password</label>
                                <input type="password" name="password" id="password" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="confirm-password" class="text-sm font-medium text-gray-300">Confirm
                                </label>
                                <input type="password" name="confirm_password" id="confirm-password"
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                            </div>
                            <div>
                                <label for="purchase-download-month"
                                    class="text-sm font-medium text-gray-300">Company</label>
                                <select name="company" id="purchase-download-month" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">

                                    @php
                                        $companies = ['TechPoint', 'TikTech', 'Restaurant'];
                                    @endphp

                                    @foreach ($companies as $key => $company)
                                        <option value="{{ $company }}">
                                            {{ $company }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div>
                                <label for="purchase-download-month"
                                    class="text-sm font-medium text-gray-300">Branch</label>
                                <select name="branch" id="purchase-download-month" required
                                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">

                                    @php
                                        $branches = [
                                            '',
                                            'TikTech-Hornchurch',
                                            'TikTech-Upminister',
                                            'TikTech-Billericay',
                                        ];
                                    @endphp

                                    @foreach ($branches as $key => $branch)
                                        <option value="{{ $branch }}">
                                            {{ $branch }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <br>
                        <hr>

                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
                            Add User
                        </button>
                    </form>
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
</body>

</html>
