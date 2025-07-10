@extends('layouts.app')

@section('content')
    <div class="mt-[72px]">
        <section class="bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/hero-pattern.svg')] py-3"
            id="restaurant-detail">
            <div class="max-w-screen-sm mx-auto px-4 md:px-0 py-6">
                <x-card>
                    <div class="flex flex-col space-y-6">
                        <div class="status-box p-4 flex items-center rounded-xl bg-gray-100">
                            <div class="status-icon-bg p-1 rounded-full mr-3 bg-gray-300">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center status-icon bg-gray-300">
                                    <i class="ti ti-coins text-white text-lg"></i>
                                </div>
                            </div>
                            <div>
                                <div class="status-message font-semibold text-md">Invoice status unknown.</div>
                                <div class="status-detail text-sm mt-1">
                                    Updated at: <span class="text-custom-secondary font-bold">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">Trx Id</h5>
                                <p class="text-sm" id="trx-id">N/A</p>
                            </div>
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">Created At</h5>
                                <p class="text-sm" id="created-at">N/A</p>
                            </div>
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">Status</h5>
                                <div class="inline">
                                    <x-badge><span class="text-xs" id="status">N/A</span></x-badge>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <h5 class="text-sm font-semibold">Paid At</h5>
                                <span class="text-sm" id="paid-at">N/A</span>
                            </div>
                        </div>
                        <div>
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
                                    @php
                                        $detail = json_decode($transaction->order_details, true);
                                    @endphp
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $detail['item'] ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $detail['amount'] ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($detail['price'] ?? 0, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"
                                                class="px-6 py-4 whitespace-nowrap text-sm text-end text-gray-700 font-medium">
                                                Fee
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($transaction->fee, 0, ',', '.') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2"
                                                class="px-6 py-4 whitespace-nowrap text-sm text-end font-semibold text-gray-900">
                                                Total
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="hidden" id="payment-details">
                            <h5 class="text-sm font-semibold">Payment QR Code</h5>
                            <p class="text-sm text-gray-600">
                                Scan this QR Code to pay (Click image to zoom in)
                            </p>
                            <div id="qr-container" class="flex">
                                <img alt="QR Code" id="qris-qr" class="size-48 bg-gray-100 rounded-lg cursor-pointer"
                                    src="{{ $transaction->qr_link }}">
                            </div>
                        </div>
                        @php
                            $previousUrl = url()->previous();
                            $currentUrl = url()->current();
                            $backUrl = $previousUrl !== $currentUrl ? $previousUrl : route('owner.ads.index');
                        @endphp
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
                            <x-button id="check-status" color="success" class="w-full">
                                Check Status
                            </x-button>

                            <a href="{{ $backUrl }}"
                                class="btn btn-primary btn-md w-full flex items-center justify-center">
                                <i class="ti ti-arrow-left mr-2"></i>
                                Back to Ads
                            </a>
                        </div>
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
        function fetchData() {
            $.ajax({
                url: "{{ route('owner.transaction.get', ['reference' => $transaction->reference]) }}",
                method: "GET",
                success: function(response) {
                    $('#trx-id').text(response.data.transaction_id);
                    $('#qris-qr').attr('src', response.data.qr_link);

                    function formatDate(dateStr) {
                        if (!dateStr) return 'Not Paid';

                        const date = new Date(dateStr);
                        const day = String(date.getDate()).padStart(2, '0');

                        const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep",
                            "Okt",
                            "Nov", "Des"
                        ];
                        const month = monthNames[date.getMonth()];

                        const year = date.getFullYear();
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');

                        return `${day} ${month} ${year} ${hours}:${minutes}`;
                    }

                    $('#paid-at').text(formatDate(response.data.paid_at));
                    $('#created-at').text(formatDate(response.data.created_at));

                    // Badge Status Kecil
                    const rawStatus = response.data.status || 'N/A';

                    if (rawStatus === 'pending') {
                        $('#payment-details').removeClass('hidden');
                    } else {
                        $('#payment-details').addClass('hidden');
                    }

                    const status = rawStatus.charAt(0).toUpperCase() + rawStatus.slice(1).toLowerCase();
                    const $wrapper = $('#status').text(status).parent();

                    const badgeClasses = {
                        paid: ['bg-success', 'text-white'],
                        pending: ['bg-warning', 'text-white'],
                        canceled: ['bg-danger', 'text-white'],
                    };

                    const preserved = $wrapper
                        .attr('class')
                        .split(/\s+/)
                        .filter(cls => !cls.startsWith('bg-') && (!cls.startsWith('text-') || cls ===
                            'text-xs'));

                    $wrapper.attr('class', [...preserved, ...(badgeClasses[status.toLowerCase()] || [
                        'bg-gray-100',
                        'text-gray-800'
                    ])].join(' '));

                    // Status Box Besar
                    const statusBoxInfo = {
                        pending: {
                            bg: 'bg-yellow-100',
                            iconBg: 'bg-yellow-500',
                            message: 'Pay your invoice!',
                            label: 'Expires in',
                            value: '',
                        },
                        paid: {
                            bg: 'bg-green-100',
                            iconBg: 'bg-green-500',
                            message: 'Invoice paid successfully.',
                            label: 'Paid at:',
                            value: formatDate(response.data.paid_at),
                        },
                        canceled: {
                            bg: 'bg-red-100',
                            iconBg: 'bg-red-500',
                            message: 'Invoice has been canceled.',
                            label: 'Updated at:',
                            value: formatDate(response.data.updated_at),
                        },
                    };

                    const boxData = statusBoxInfo[rawStatus.toLowerCase()] || {
                        bg: 'bg-gray-100',
                        iconBg: 'bg-gray-300',
                        message: 'Invoice status unknown.',
                        label: '',
                        value: '',
                    };

                    const $box = $('.status-box');
                    $box.removeClass((_, cls) => cls.match(/bg-\S+/g)?.join(' ') || '').addClass(boxData.bg);
                    $box.find('.status-icon-bg').removeClass((_, cls) => cls.match(/bg-\S+/g)?.join(' ') || '')
                        .addClass(boxData.iconBg);
                    $box.find('.status-icon').removeClass((_, cls) => cls.match(/bg-\S+/g)?.join(' ') || '')
                        .addClass(boxData.iconBg);
                    $box.find('.status-message').text(boxData.message);

                    if (boxData.label) {
                        $box.find('.status-detail').html(
                            `${boxData.label} <span class="text-custom-secondary font-bold">${boxData.value}</span>`
                        );
                    } else {
                        $box.find('.status-detail').remove();
                    }

                    // Timer expired (jika pending)
                    if (rawStatus.toLowerCase() === 'pending') {
                        const expiredTime = Math.floor(new Date(response.data.expired_at).getTime() / 1000);
                        const $expiryElement = $('#invoice-expiry');
                        const $statusBoxTime = $('.status-box .status-detail span');

                        if (window.invoiceTimer) clearInterval(window.invoiceTimer);

                        window.invoiceTimer = setInterval(function() {
                            const now = Math.floor(Date.now() / 1000);
                            const remaining = expiredTime - now;

                            if (remaining <= 0) {
                                clearInterval(window.invoiceTimer);
                                $expiryElement.text('Expired').addClass('text-red-600');
                                $statusBoxTime.text('Expired').addClass('text-red-600');
                                return;
                            }

                            const h = String(Math.floor(remaining / 3600)).padStart(2, '0');
                            const m = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
                            const s = String(remaining % 60).padStart(2, '0');

                            const formatted = `${h}:${m}:${s}`;
                            $expiryElement.text(formatted);
                            $statusBoxTime.text(formatted);
                        }, 1000);
                    }

                    // Viewer QR
                    if (window.qrViewer) {
                        window.qrViewer.update();
                    } else {
                        window.qrViewer = new Viewer(document.getElementById('qr-container'), {
                            toolbar: false,
                            navbar: false,
                            title: false
                        });
                    }
                }
            });
        }

        $(document).ready(function() {
            fetchData();

            $('#check-status').on('click', function() {
                fetchData();
            });
        });
    </script>
@endpush
