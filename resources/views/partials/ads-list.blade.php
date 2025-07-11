<div class="space-y-5">
    @foreach ($ads as $ad)
        @php
            $transaction = $ad->transaction;
            $status = $ad->approval_status;
            $statusClasses = [
                'pending' => 'text-warning bg-warning/10',
                'approved' => 'text-success bg-success/10',
                'rejected' => 'text-danger bg-danger/10',
            ];
            $statusText = [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ];
            $hasImage = !empty($ad->image);
        @endphp

        <div
            class="flex flex-col sm:flex-row sm:items-start gap-4 p-4 border border-gray-100 rounded-xl hover:shadow-md transition">
            @if ($hasImage)
                <a href="{{ Storage::url($ad->image) }}" target="_blank">
                    <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->adsType->name }}"
                        class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                </a>
            @else
                <div
                    class="w-16 h-16 {{ $statusClasses[$status] ?? 'bg-gray-100' }} rounded-lg flex items-center justify-center font-bold text-sm flex-shrink-0">
                    Ads
                </div>
            @endif

            <div class="flex-1 w-full">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-1">
                    <div class="text-gray-800 font-semibold">{{ $ad->adsType->name }}</div>
                    <div class="flex items-center justify-end">
                        <span
                            class="inline-flex items-center gap-1 text-xs font-medium px-3 py-1 rounded-full {{ $statusClasses[$status] ?? 'bg-gray-200 text-gray-600' }}">
                            @if ($status === 'pending')
                                <i class="ti ti-clock-hour-2 text-sm"></i>
                            @elseif ($status === 'approved')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif ($status === 'rejected')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>

                <div class="text-sm text-gray-500 flex justify-between">
                    <span>{{ $ad->created_at->format('d M Y • H:i') }}</span>
                    <span class="text-xs">#{{ $transaction->transaction_id }}</span>
                </div>

                <div class="mt-2 flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                    <div class="text-lg font-semibold text-muted">
                        Rp {{ number_format($transaction->price, 0, ',', '.') }}
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if ($status === 'pending')
                            <form action="{{ route('owner.ads.cancel', ['reference' => $ad->id]) }}" method="POST"
                                data-fetch="fetchData">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 text-sm text-white bg-danger border border-gray-300 rounded-md hover:bg-danger/90">
                                    Cancled
                                </button>
                            </form>
                        @endif

                        @if ($status === 'approved')
                            @if ($transaction->status === 'pending')
                                <a href="{{ route('owner.transaction.index', ['trx_id' => $transaction->transaction_id]) }}"
                                    class="px-3 py-1.5 text-sm text-white border bg-primary border-gray-300 rounded-md hover:bg-primary/90">
                                    Payment
                                </a>
                                <form action="{{ route('owner.ads.cancel', ['reference' => $ad->id]) }}" method="POST"
                                    data-fetch="fetchData">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 text-sm text-white bg-danger border border-gray-300 rounded-md hover:bg-danger/90">
                                        Cancled
                                    </button>
                                </form>
                            @elseif ($transaction->status === 'paid')
                                <a href="{{ route('owner.transaction.index', ['trx_id' => $transaction->transaction_id]) }}"
                                    class="px-3 py-1.5 text-sm text-white border bg-success border-gray-300 rounded-md hover:bg-success/90">
                                    Invoice
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
