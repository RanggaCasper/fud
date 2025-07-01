@extends('layouts.panel')

@section('content')
    @php
        $restaurant = Auth::user()->owned->restaurant;

        $formTypes = [
            [
                'type' => 'dining-option',
                'title' => 'Dining Options',
                'relation' => $restaurant->diningOptions,
                'name' => 'dining_options',
            ],
            [
                'type' => 'payments',
                'title' => 'Payment Methods',
                'relation' => $restaurant->payments,
                'name' => 'payments',
            ],
            [
                'type' => 'accessibility',
                'title' => 'Accessibility Features',
                'relation' => $restaurant->accessibilities,
                'name' => 'accessibilities',
            ],
        ];
    @endphp

    @foreach ($formTypes as $form)
        <x-card.card :title="$form['title']">
            <form method="POST" action="{{ route('owner.features.update', ['type' => $form['type']]) }}" data-reset="false">
                @csrf
                @method('PUT')

                @php
                    $ownedItems = $form['relation'];

                    $modelMap = [
                        'dining-option' => \App\Models\Restaurant\DiningOption::class,
                        'payments' => \App\Models\Restaurant\Payment::class,
                        'accessibility' => \App\Models\Restaurant\Accessibility::class,
                    ];

                    $model = $modelMap[$form['type']] ?? null;

                    $allItems = $model ? $model::select('name')->groupBy('name')->orderBy('name')->get() : collect();
                @endphp

                <div class="grid grid-cols-2">
                    @foreach ($allItems as $index => $item)
                        <div class="flex items-center mb-4">
                            <input id="{{ $form['name'] }}-checkbox-{{ $index }}" type="checkbox"
                                name="{{ $form['name'] }}[]" value="{{ $item->name }}"
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded-sm focus:ring-primary focus:ring-2"
                                @checked($ownedItems->pluck('name')->contains($item->name))>
                            <label for="{{ $form['name'] }}-checkbox-{{ $index }}"
                                class="ms-2 text-sm font-medium text-gray-900">
                                {{ $item->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <x-button type="submit">Submit</x-button>
                <x-button type="reset">Reset</x-button>
            </form>
        </x-card.card>
    @endforeach
@endsection
