@extends('layouts.panel')

@section('title', 'Ads Chart')

@section('content')
    <x-card title="Insights">
        <div id="chart"></div>
    </x-card>
    <div class="mb-3">
        <a href="{{ route('owner.ads.index') }}" class="btn btn-sm btn-primary btn-icon"><i class="ti ti-arrow-left"></i> Back to Ads</a>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const chartData = @json($chartData);
        const grouping = @json($grouping);

        const seriesData = Object.entries(chartData).map(([label, value]) => ({
            x: label,
            y: value
        }));

        const options = {
            chart: {
                type: 'bar',
                height: 400,
                zoom: {
                    enabled: true
                }
            },
            series: [{
                name: 'Ads Clicks',
                data: seriesData
            }],
            xaxis: {
                type: 'category',
                title: {
                    text: grouping === 'hourly-12' ? 'Hour' : 'Date'
                },
                labels: {
                    rotate: -45,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Total Clicks'
                }
            },
            title: {

            }
        };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
