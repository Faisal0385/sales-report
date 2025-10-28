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
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                <table class="min-w-full text-sm text-left">
                    <thead class="border-b border-gray-700 text-gray-400">
                        <tr>
                            <th class="py-2 px-3 font-medium">Date</th>
                            <th class="py-2 px-3 font-medium">{{ $purchaseDetail->purchase_date }}</th>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 font-medium">Customer</th>
                            <th class="py-2 px-3 font-medium">{{ $purchaseDetail->customer_name }}</th>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 font-medium">Product</th>
                            <th class="py-2 px-3 font-medium">{{ $purchaseDetail->product_details }}</th>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 font-medium">IMEI/SN</th>
                            <th class="py-2 px-3 font-medium">{{ $purchaseDetail->imei_number }}</th>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 font-medium">Phone</th>
                            <th class="py-2 px-3 font-medium">{{ $purchaseDetail->phone_number }}</th>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 font-medium">Payment Method</th>
                            <th class="py-2 px-3 font-medium">{{ strtoupper($purchaseDetail->payment_method )}}</th>
                        </tr>
                         <tr>
                            <th class="py-2 px-3 font-medium">Amount</th>
                            <th class="py-2 px-3 font-medium">{{ $purchaseDetail->purchase_amount }}</th>
                        </tr>

                    </thead>
                </table>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>

    <!-- Include html5-qrcode from CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        document.getElementById('bankTransferRadio').addEventListener('change', function () {
            const fields = document.getElementById('bankTransferFields');
            if (this.checked) {
                fields.style.display = 'block';
            }
        });

        document.getElementById('cashRadio').addEventListener('change', function () {
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


    <script>
        document.getElementById("start-scan").addEventListener("click", function () {
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
            }, function (err) {
                if (err) {
                    console.error(err);
                    alert("Camera initialization failed.");
                    return;
                }
                Quagga.start();
            });

            Quagga.onDetected(function (result) {
                console.log("Scanned Code:", result.codeResult.code);
                document.getElementById("imei-number").value = result.codeResult.code;

                // Stop scanning
                Quagga.stop();
                document.getElementById("scanner-container").style.display = "none";
            });
        });

        document.getElementById("close-scanner").addEventListener("click", function () {
            Quagga.stop();
            document.getElementById("scanner-container").style.display = "none";
        });
    </script>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const outputImg = document.getElementById('photo-preview');
        const context = canvas.getContext('2d');
        let stream;

        // Open camera
        function openCamera() {
            document.getElementById('camera-container').style.display = 'block';

            navigator.mediaDevices.getUserMedia({
                video: true
            })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Error accessing webcam:", err);
                    alert("Could not access camera.");
                });
        }

        // Close camera
        function closeCamera() {
            document.getElementById('camera-container').style.display = 'none';
            if (stream) {
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            }
        }

        document.getElementById('capture').addEventListener('click', () => {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');

            // Show preview
            outputImg.src = imageData;
            outputImg.classList.remove('hidden');

            // Save to hidden input for form submit
            document.getElementById('captured-photo').value = imageData;

            closeCamera();
        });
    </script>

    <script>
        let html5QrCode;

        function startQRScanner() {
            const qrReader = document.getElementById("qr-reader");
            qrReader.style.display = "block"; // show scanner

            // Create scanner instance if not already
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("qr-reader");
            }

            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };

            html5QrCode.start({
                facingMode: "environment"
            }, // use back camera
                config,
                qrCodeMessage => {
                    // Show result
                    document.getElementById("imei-number").value = `${qrCodeMessage}`;
                    // Stop scanner after success
                    html5QrCode.stop().then(() => {
                        qrReader.style.display = "none";
                    });
                },
                errorMessage => {
                    // Optional: show scanning errors in console
                    console.log("Scanning error: ", errorMessage);
                }
            ).catch(err => {
                console.error("Unable to start scanning.", err);
            });
        }
    </script>

</body>

</html>