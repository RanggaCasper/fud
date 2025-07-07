@extends('layouts.app')

@section('content')
    <div class="mt-[72px]">
        <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-3"
            id="restaurant-detail">
            <div class="max-w-screen-sm mx-auto px-4 md:px-0 py-6">
                <x-card title="Transaction Details">
                    <div class="flex flex-col space-y-6">
                        <div>
                            <div class="p-4 md:p-5 flex w-full rounded-xl items-center bg-warning/10">
                                <div class="p-1 rounded-full mr-3 md:mr-4 bg-warning">
                                    <div
                                        class="w-8 h-8 md:w-9 md:h-9 rounded-full flex items-center justify-center bg-warning">
                                        <i class="ti ti-coins text-white text-lg md:text-xl"></i>
                                    </div>
                                </div>
                                <div class="text-sm md:text-base">
                                    <div class="font-semibold text-md">
                                        Pay your invoice!</div>
                                    <div class="text-sm">Expires in
                                        <span class="text-custom-secondary font-bold" id="invoice-expiry">00:25:43</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">TRX ID</h5>
                                <p class="text-sm">{{ $transaction->transaction_id }}</p>
                            </div>
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">Created At</h5>
                                <p class="text-sm">{{ $transaction->created_at }}</p>
                            </div>
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">Status</h5>
                                @if ($transaction->status === 'pending')
                                    <div class="inline">
                                        <x-badge color="warning">{{ ucfirst($transaction->status) }}</x-badge>
                                    </div>
                                @else
                                    <p class="text-sm">{{ $transaction->status }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">PAID AT</h5>
                                <span>{{ $transaction->paid_at ?? 'Not Paid' }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="overflow-x-auto mt-4 rounded-lg shadow">
                                <div class="overflow-x-auto mt-4 rounded-lg shadow">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Item
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                    Price
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="order-items-body" class="divide-y divide-gray-200 bg-white"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div></div>
                        </div>
                        <div>
                            <h5 class="text-sm font-semibold">Payment QR Code</h5>
                            <p class="text-sm text-gray-600">
                                Scan this QR Code to pay (Click image to zoom in)
                            </p>
                            <div id="qr-container" class="flex">
                                <img alt="QR Code" id="qris-qr" class="size-48 bg-gray-100 rounded-lg cursor-pointer"
                                    src="#">
                            </div>
                        </div>
                        @php
                            $previousUrl = url()->previous();
                            $currentUrl = url()->current();
                            $backUrl = $previousUrl !== $currentUrl ? $previousUrl : route('owner.ads.index');
                        @endphp
    
                        <a class="btn btn-primary btn-md w-full btn-icon" href="{{ $backUrl }}">
                            <i class="ti ti-arrow-left"></i>
                            Back to Ads
                        </a>
                    </div>
                </x-card>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.3/viewer.min.js"></script>
    <script>
        $.ajax({
            url: "{{ route('owner.transaction.get', ['reference' => $transaction->reference]) }}",
            method: "GET",
            success: function(response) {
                let orderHtml = '';
                response.data.order_items.forEach(item => {
                    orderHtml += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${item.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">${item.quantity}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">Rp ${formatRupiah(item.price)}</td>
                    </tr>
                `;
                });

                orderHtml += `
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="2" class="px-6 py-4 text-sm text-gray-700 text-right">Payment Fee</td>
                        <td class="px-6 py-4 text-sm text-gray-800">Rp ${formatRupiah(response.data.fee_customer)}</td>
                    </tr>
                `;

                orderHtml += `
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="2" class="px-6 py-4 text-sm text-gray-700 text-right">Total</td>
                        <td class="px-6 py-4 text-sm text-gray-800">Rp ${formatRupiah(response.data.amount)}</td>
                    </tr>
                `;

                $('#order-items-body').html(orderHtml);

                $('#qris-qr').attr('src', response.data.qr_url);

                const expiredTime = response.data.expired_time;
                const $expiryElement = $('#invoice-expiry');

                const timer = setInterval(function() {
                    const now = Math.floor(Date.now() / 1000);
                    const remaining = expiredTime - now;

                    if (remaining <= 0) {
                        clearInterval(timer);
                        $expiryElement.text('Expired').addClass('text-red-600');
                        return;
                    }

                    const h = String(Math.floor(remaining / 3600)).padStart(2, '0');
                    const m = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
                    const s = String(remaining % 60).padStart(2, '0');

                    $expiryElement.text(`${h}:${m}:${s}`);
                }, 1000);

                if (window.qrViewer) {
                    window.qrViewer.update();
                } else {
                    window.qrViewer = new Viewer(document.getElementById('qr-container'), {
                        toolbar: false,
                        navbar: false,
                        title: false
                    });
                }
            },
            error: function(error) {
                console.error("Error fetching transaction details:", error);
            }
        });

        function formatRupiah(amount) {
            return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
@endpush
