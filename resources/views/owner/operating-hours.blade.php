@extends('layouts.panel')

@section('content')
    <x-card.card title="Manage Operating Hours">
        <form method="POST" data-reset="false">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($operatingHours as $hour)
                    @php
                        $rawRanges = array_filter(explode(',', str_replace("\u{202F}", '', $hour['operating_hours'])));
                        $ranges = [];

                        foreach ($rawRanges as $range) {
                            $parts = explode('–', trim($range));

                            if (count($parts) === 2) {
                                try {
                                    $start = trim($parts[0]);
                                    $end = trim($parts[1]);

                                    if (preg_match('/^\d+$/', $start)) {
                                        $start .= ' PM';
                                    }
                                    if (preg_match('/^\d+$/', $end)) {
                                        $end .= ' PM';
                                    }

                                    $open = \Carbon\Carbon::parse($start)->format('H:i');
                                    $close = \Carbon\Carbon::parse($end)->format('H:i');
                                    $ranges[] = ['open' => $open, 'close' => $close];
                                } catch (\Exception $e) {
                                    $ranges[] = ['open' => '', 'close' => ''];
                                }
                            }
                        }
                    @endphp

                    <div class="operating-hour-box border border-gray-200 p-5 rounded-2xl shadow-sm bg-white"
                        data-index="{{ $loop->index }}">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg font-semibold text-gray-800">{{ $hour['day'] }}</h4>
                        </div>

                        <input type="hidden" name="hours[{{ $loop->index }}][id]" value="{{ $hour['id'] }}">
                        <input type="hidden" name="hours[{{ $loop->index }}][day]" value="{{ $hour['day'] }}">

                        <div class="flex items-center gap-3 mb-3">
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="hours[{{ $loop->index }}][is_24]"
                                    class="form-checkbox rounded-sm text-green-600 toggle-24"
                                    {{ trim($hour['operating_hours']) === 'Open 24 hours' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Open 24 Hours</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" name="hours[{{ $loop->index }}][is_closed]"
                                    class="form-checkbox rounded-sm text-red-500 toggle-closed"
                                    {{ trim($hour['operating_hours']) === 'Closed' ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">Closed</span>
                            </label>
                        </div>

                        <div class="time-inputs flex flex-col gap-2">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="flex gap-2">
                                    <div class="w-1/2">
                                        <label class="block text-xs text-gray-500 mb-1">Open {{ $i + 1 }}</label>
                                        <input type="time" name="hours[{{ $loop->index }}][open][]"
                                            value="{{ $ranges[$i]['open'] ?? '' }}"
                                            class="time-open w-full border-gray-300 rounded-lg">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-xs text-gray-500 mb-1">Close {{ $i + 1 }}</label>
                                        <input type="time" name="hours[{{ $loop->index }}][close][]"
                                            value="{{ $ranges[$i]['close'] ?? '' }}"
                                            class="time-close w-full border-gray-300 rounded-lg">
                                    </div>
                                </div>
                            @endfor

                        </div>
                    </div>
                @endforeach
            </div>

            <x-button type="submit" class="mt-6">Submit</x-button>
        </form>
    </x-card.card>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.operating-hour-box').each(function() {
                const $box = $(this);
                const $is24 = $box.find('.toggle-24');
                const $isClosed = $box.find('.toggle-closed');
                const $inputs = $box.find('.time-inputs');

                function updateState() {
                    if ($is24.is(':checked')) {
                        $isClosed.prop('checked', false);
                    }

                    if ($isClosed.is(':checked')) {
                        $is24.prop('checked', false);
                    }

                    if ($is24.is(':checked') || $isClosed.is(':checked')) {
                        $inputs.hide();
                    } else {
                        $inputs.show();
                    }
                }

                $is24.on('change', updateState);
                $isClosed.on('change', updateState);

                updateState();
            });
        });
    </script>
@endpush
