<div class="lg:col-span-2 bg-gray-800 p-6 rounded-lg border border-gray-700">

    <form method="POST" action="{{ route('purchase.store') }}" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="date" class="text-sm font-medium text-gray-300">Purchase
                    Date</label>
                <input type="date" name="purchase_date" id="purchase-date" required value="{{ old('purchase_date') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
            <div>
                <label for="customer-name" class="text-sm font-medium text-gray-300">Customer
                    Name</label>
                <input type="text" name="customer_name" id="customer-name" required
                    value="{{ old('customer_name') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="phone-number" class="text-sm font-medium text-gray-300">Phone Number
                    (UK)</label>
                <input type="tel" name="phone_number" id="phone-number" placeholder="e.g. 07123 456789" required
                    value="{{ old('phone_number') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
            <div>
                <label for="email-address" class="text-sm font-medium text-gray-300">Email Address
                    (Optional)</label>
                <input type="email" name="email" id="email-address" value="{{ old('email') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category_item" class="text-sm font-medium text-gray-300">Category</label>
                <select name="category" id="category_item" required onchange="subCategory()"
                    value="{{ old('category_item') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">

                    @php
                        $categories = ['Mobile Phones', 'Tablets', 'Laptops/Macbooks', 'PC and accessories'];
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
                <label for="sub_category_id" class="text-sm font-medium text-gray-300">SubCategory</label>
                <select name="sub_category" id="sub_category_id" required value="{{ old('sub_category') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
                </select>
            </div>

        </div>
        <div>
            <label for="product-details" class="text-sm font-medium text-gray-300">Product
                Details</label>
            <textarea name="product_details" id="product-details" rows="3" required
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">{{ old('product_details') }}</textarea>
        </div>

        <div class="relative">
            <label for="imei-number" class="text-sm font-medium text-gray-300">IMEI Number
                (Mandatory)</label>
            <input type="text" name="imei_number" id="imei-number" required value="{{ old('imei_number') }}"
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base pr-20">

            <div class="absolute inset-y-0 right-0 top-6 flex items-center pr-3 space-x-2">
                <button type="button" id="start-scan" class="text-gray-400 hover:text-white">
                    <!-- barcode icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.25 2A2.25 2.25 0 002 4.25v11.5A2.25 2.25 0 004.25 18h11.5A2.25 2.25 0 0018 15.75V4.25A2.25 2.25 0 0015.75 2H4.25zM6 7a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <button type="button" onclick="startQRScanner()" class="text-gray-400 hover:text-white">
                    <!-- qrcode icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M3 3h8v8H3V3zm2 2v4h4V5H5zm10-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm10 0h2v2h-2v-2zm4 0h2v6h-6v-2h4v-4zm-4 4h2v2h-2v-2zm-4 2h2v2h-2v-2zm8 0h2v2h-2v-2z" />
                    </svg>
                </button>
                <a href="https://www.imei.info/" target="_blank" class="text-gray-400 hover:text-white">
                    <!-- search icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 014.61 11.61l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A6.75 6.75 0 1110.5 3.75zm-4.5 6.75a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
        <!-- Scanner container -->
        <div id="qr-reader" style="width: 300px; display: none;"></div>
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
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">{{ old('customer_address') }}</textarea>
        </div>
        <div>
            <label for="customer-id-proof" class="text-sm font-medium text-gray-300">Customer ID
                Proof (Optional)</label>
            <div class="mt-1 flex items-center space-x-2">
                <input type="file" name="customer_id_proof" id="customer-id-proof"
                    value="{{ old('customer_id_proof') }}"
                    class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700">
                <!-- Camera Button -->
                <button type="button" onclick="openCamera()"
                    class="p-2.5 bg-gray-600 rounded-md hover:bg-gray-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M2 4a1 1 0 011-1h1.5a1 1 0 01.98.804l1.32 4.62a1 1 0 01-.364 1.118l-1.132.85a12.182 12.182 0 005.37 5.37l.85-1.132a1 1 0 011.118-.364l4.62 1.32A1 1 0 0116 16.5V18a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                    </svg>
                </button>
            </div>
            <!-- Camera Button -->
            <!-- Captured Photo Preview -->
            <input type="hidden" name="captured_photo" id="captured-photo" value="{{ old('captured_photo') }}">
            <img id="photo-preview" name="photo-preview" class="hidden mt-2 rounded-md max-h-24" />

            <!-- Camera Modal -->
            <div id="camera-container"
                style="display:none; text-align:center; background:rgba(0,0,0,0.8); position:fixed; top:0; left:0; width:100%; height:100%; z-index:1000; padding-top:50px;">
                <div style="background:white; padding:20px; border-radius:10px; display:inline-block;">
                    <h2>Webcam Capture</h2>
                    <video id="video" width="400" height="300" autoplay></video>
                    <br>
                    <button id="capture">📸 Capture</button>
                    <button onclick="closeCamera()">❌ Close</button>
                    <canvas id="canvas" width="400" height="300" style="display:none;"></canvas>
                </div>
            </div>

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
                <input type="text" name="bank_transfer_name" id="bank_transfer_name" step="any"
                    min="1" value="{{ old('bank_transfer_name') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
            <div>
                <label for="bank_transfer_sort_code" class="text-sm font-medium text-gray-300">Sort
                    Code</label>
                <input type="text" name="bank_transfer_sort_code" id="bank_transfer_sort_code" step="any"
                    min="1" value="{{ old('bank_transfer_sort_code') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
            <div>
                <label for="bank_transfer_account" class="text-sm font-medium text-gray-300">Account
                    Number</label>
                <input type="text" name="bank_transfer_account" id="bank_transfer_account" step="any"
                    min="1" value="{{ old('bank_transfer_account') }}"
                    class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
            </div>
        </div>

        <div>
            <label for="purchase-amount" class="text-sm font-medium text-gray-300">Purchase Amount
                (£)</label>
            <input type="number" name="purchase_amount" id="purchase-amount" value="0" required
                value="{{ old('purchase_amount') }}" step="any" min="1"
                class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md shadow-sm py-2 px-3 text-base">
        </div>
        <button type="submit"
            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-colors">
            Add Purchase
        </button>
    </form>

</div>
