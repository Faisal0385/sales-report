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
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
