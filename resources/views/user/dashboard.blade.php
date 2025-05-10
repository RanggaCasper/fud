@extends('layouts.panel')
@section('showNavbot', true)
@section('content')
<div class="flex justify-center">
    <div class="w-full">
        <div class="bg-muted backdrop-blur-md bg-opacity-40 rounded-lg">
            <div class="bg-muted backdrop-blur-md bg-opacity-40 rounded-lg">
                <div class="relative flex items-center justify-between gap-2 p-5 duration-300 ease-in-out">  
                    <div class="z-10 flex justify-center gap-3">
                        @if(Auth::user()->avatar)                                                
                            <img class="object-cover lazyload h-14 w-14 rounded-lg lazyload" loading="lazy" data-src="{{ Auth::user()->avatar }}" alt="user photo">
                        @else
                            <span class="object-cover lazyload h-14 w-14 rounded-lg flex items-center justify-center bg-primary text-white text-sm font-medium">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        @endif
                        <div class="z-10 flex flex-col justify-center text-white">  
                            <h5 class="text-sm font-semibold truncate group-hover:text-primary">  
                                {{ auth()->user()->name }}</h5>  
                            <p class="text-xs truncate">{{ auth()->user()->created_at }}</p>  
                        </div>  
                    </div>
                    <div class="z-10 flex flex-col gap-2">
                        <button class="flex items-center gap-1 text-white bg-primary hover:bg-primary/75 rounded-full text-sm px-5 py-1.5 text-center" aria-label="Cetak Invoice">  
                            <i class="ri ri-settings-line"></i>
                            Profile  
                        </button>  
                    </div>
                </div>
                <div class="absolute inset-0 z-0 w-full h-full overflow-hidden rounded-lg">  
                    <img data-src="https://w.wallhaven.cc/full/dg/wallhaven-dgkz1g.png"
                        loading="lazy"
                        alt="Background"
                        class="object-cover w-full h-full lazyload blur-sm brightness-50">  
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="flex flex-col space-y-4">
    <h5 class="font-semibold text-dark text-md">Jumlah Transaksi Hari Ini</h5>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
        <div class="flex flex-col items-center justify-center p-6 shadow-lg bg-info rounded-lg backdrop-blur-md bg-opacity-70 text-light">
            <div class="text-4lg font-semibold">0</div>
            <div class="pt-4 text-sm font-medium">Dalam Proses</div>
        </div>
        <div class="flex flex-col items-center justify-center p-6 shadow-lg bg-success rounded-lg backdrop-blur-md bg-opacity-70 text-light">
            <div class="text-4lg font-semibold">0</div>
            <div class="pt-4 text-sm font-medium">Sukses</div>
        </div>
        <div class="flex flex-col items-center justify-center p-6 shadow-lg bg-warning rounded-lg backdrop-blur-md bg-opacity-70 text-light">
            <div class="text-4lg font-semibold">1</div>
            <div class="pt-4 text-sm font-medium">Batal</div>
        </div>
        <div class="flex flex-col items-center justify-center p-6 shadow-lg bg-danger rounded-lg backdrop-blur-md bg-opacity-70 text-light">
            <div class="text-4lg font-semibold">0</div>
            <div class="pt-4 text-sm font-medium">Gagal</div>
        </div>
    </div>

    <!-- Chart Transaksi -->
    <div class="p-5 shadow-lg bg-light rounded-lg backdrop-blur-md bg-opacity-70">
        <h5 class="font-semibold text-md">Chart Transaksi</h5>
        <div id="chart"></div>
    </div>
</div>   
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
      series: [{
      name: 'series1',
      data: [31, 40, 28, 51, 42, 109, 100]
    }, {
      name: 'series2',
      data: [11, 32, 45, 32, 34, 52, 41]
    }],
      chart: {
      height: 350,
      type: 'area',
      background: 'transparent'
    },
    theme: {
        mode: 'light',  // Removed dark mode theme
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth'
    },
    xaxis: {
      type: 'datetime',
      categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
    },
    tooltip: {
      x: {
        format: 'dd/MM/yy HH:mm'
      },
    },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endpush
