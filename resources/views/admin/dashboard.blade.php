@extends('layouts.panel')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="col-span-1">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="flex items-center justify-between p-3 gap-3 border-b border-gray-200">
                    <div class="bg-primary/10 p-3 rounded-lg inline-flex items-center justify-center">
                        <div class="bg-primary p-2 rounded-lg inline-flex items-center justify-center">
                            <i class="ti ti-users text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="w-full">
                        <h5 class="text-xl font-semibold">{{ $userCount }}</h5>
                        <p class="text-sm text-gray-500">Total Users</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="flex items-center justify-between p-3 gap-3 border-b border-gray-200">
                    <div class="bg-primary/10 p-3 rounded-lg inline-flex items-center justify-center">
                        <div class="bg-primary p-2 rounded-lg inline-flex items-center justify-center">
                            <i class="ti ti-chef-hat text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="w-full">
                        <h5 class="text-xl font-semibold">{{ $restaurantCount }}</h5>
                        <p class="text-sm text-gray-500">Total Restaurants</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1">
            <div class="bg-white shadow-sm rounded-lg">
                <div class="flex items-center justify-between p-3 gap-3 border-b border-gray-200">
                    <div class="bg-primary/10 p-3 rounded-lg inline-flex items-center justify-center">
                        <div class="bg-primary p-2 rounded-lg inline-flex items-center justify-center">
                            <i class="ti ti-message text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="w-full">
                        <h5 class="text-xl font-semibold">{{ $reviewCount }}</h5>
                        <p class="text-sm text-gray-500">Total Reviews</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h5 class="text-lg font-semibold mb-3">{{ config('app.name') }} Insights</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-card title="Top 5 Highest Rated Restaurants">
                @foreach ($highestRatedRestaurants as $restaurant)
                    <a href="{{ route('restaurant.index', $restaurant->slug) }}" target="_blank"
                        class="block hover:bg-gray-50 rounded-md px-2">
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <div class="flex items-center">
                                <img src="{{ $restaurant->thumbnail }}" alt="{{ $restaurant->name }}"
                                    class="w-12 h-12 rounded-lg mr-3">
                                <div>
                                    <h6 class="font-semibold">{{ $restaurant->name }}</h6>
                                    <p class="text-sm text-gray-500">Rating: {{ $restaurant->rating }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </x-card>
            <x-card title="Top 5 Most Reviewed Restaurants">
                @foreach ($mostReviewedRestaurants as $restaurant)
                    <a href="{{ route('restaurant.index', $restaurant->slug) }}" target="_blank"
                        class="block hover:bg-gray-50 rounded-md px-2">
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <div class="flex items-center">
                                <img src="{{ $restaurant->thumbnail }}" alt="{{ $restaurant->name }}"
                                    class="w-12 h-12 rounded-lg mr-3">
                                <div>
                                    <h6 class="font-semibold">{{ $restaurant->name }}</h6>
                                    <p class="text-sm text-gray-500">Review: {{ $restaurant->reviews }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </x-card>
        </div>
    </div>
    <div>
        <h5 class="text-lg font-semibold mb-3">Google Search Summary</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-card title="Top Queries">
                <div id="gsc-queries">
                    <p class="text-sm text-gray-400 italic">Loading...</p>
                </div>
            </x-card>
            <x-card title="Top Pages">
                <div id="gsc-pages">
                    <p class="text-sm text-gray-400 italic">Loading...</p>
                </div>
            </x-card>
            <x-card title="Top Devices">
                <div id="gsc-devices-chart" class="w-full max-w-md mx-auto">
                    <p class="text-sm text-gray-400 italic">Loading...</p>
                </div>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $.ajax({
            url: "{{ route('admin.dashboard.gsc') }}",
            method: "GET",
            success: function(response) {
                const data = response.data;

                const sections = {
                    queries: 'Top Queries',
                    pages: 'Top Pages',
                    countries: 'Top Countries',
                    appearances: 'Search Appearances'
                };

                for (const key in sections) {
                    const target = '#gsc-' + key;
                    const rows = data[key];
                    let html = '';

                    if (!rows || rows.length === 0) {
                        html += `<p class="text-sm text-gray-400 italic">No data available.</p>`;
                    } else {
                        html += '<ul class="divide-y">';
                        rows.forEach(row => {
                            const keyValue = row.keys?.[0] ?? '-';

                            const label = (key === 'pages') ?
                                `<a href="${keyValue}" target="_blank" class="text-blue-600 text-sm underline">${keyValue}</a>` :
                                `<div class="break-all">${keyValue}</div>`;

                            html += `
                        <li class="py-2">
                            ${label}
                            <div class="text-xs text-gray-500">
                                Clicks: ${row.clicks},
                                Impr: ${row.impressions},
                                CTR: ${(row.ctr * 100).toFixed(2)}%,
                                Pos: ${row.position.toFixed(2)}
                            </div>
                        </li>`;
                        });
                        html += '</ul>';
                    }

                    $(target).html(html);
                }

                const deviceData = data.devices ?? [];
                const deviceLabels = deviceData.map(row => row.keys?.[0]?.toLowerCase() ?? 'unknown');
                const deviceClicks = deviceData.map(row => row.clicks ?? 0);

                if (deviceData.length > 0) {
                    $('#gsc-devices-chart').empty();

                    const options = {
                        chart: {
                            type: 'pie',
                            height: 320
                        },
                        labels: deviceLabels,
                        series: deviceClicks,
                        legend: {
                            position: 'bottom'
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#gsc-devices-chart"), options);
                    chart.render();
                } else {
                    $('#gsc-devices-chart').html(
                        '<p class="text-sm text-gray-400 italic">No data available.</p>');
                }

            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    </script>
@endpush
