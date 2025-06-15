@php
    $alertClasses = $type === 'success' ? 'bg-green-50 text-success border-success' :
                    ($type === 'danger' ? 'bg-red-50 text-danger border-danger' :
                    ($type === 'info' ? 'bg-blue-50 text-info border-info' :
                    'bg-yellow-50 text-warning border-warning'));
@endphp

<div class="flex items-center p-4 mb-3 text-sm {{ $alertClasses }} border rounded-lg" role="alert">
    <i class="ti ti-info-circle text-lg me-1"></i>
    <div>
        {{ $message }}
    </div>
</div>
