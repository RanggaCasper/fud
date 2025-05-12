@props(['provider', 'isConnected'])

<div class="p-4 rounded-lg w-full {{ $isConnected ? 'bg-success' : 'bg-gray-300' }} 
    text-white font-semibold flex items-center justify-between gap-4 transition-all duration-300 ease-in-out">
    
    <div class="flex items-center gap-3">
        <!-- Icon -->
        <i class="ri ri-{{ $provider }}-line text-2xl"></i>
        
        <!-- Text Section -->
        <div class="flex flex-col">
            <span class="text-lg font-semibold">
                {{ ucfirst($provider) }}
            </span>
            <span class="text-xs text-white">
                {{ $isConnected ? 'Connected' : 'Not Connected' }}
            </span>
        </div>
    </div>

    <!-- Action Button -->
    @if($isConnected)
        <!-- If connected, show Disconnect Button -->
        <a href="{{ route('auth.disconnect.social', $provider) }}" 
            class="flex items-center justify-center px-4 py-2 bg-white rounded-lg text-danger font-medium hover:bg-gray-100 transition-all duration-300 ease-in-out"
            title="Disconnect {{ ucfirst($provider) }}">
            <i class="ri ri-link-unlink text-lg"></i>
            <span class="ml-2 text-sm">Disconnect</span>
        </a>
    @else
        <!-- If not connected, show Connect Button -->
        <a href="{{ route('auth.login.social', ['provider' => $provider]) }}" 
            class="flex items-center justify-center px-4 py-2 {{ $provider === 'facebook' ? 'bg-blue-600' : 'bg-danger' }} rounded-lg text-white font-medium hover:bg-opacity-70 transition-all duration-300 ease-in-out"
            title="Connect {{ ucfirst($provider) }}">
            <i class="ri ri-{{ $provider }}-fill text-lg"></i>
            <span class="ml-2 text-sm">Connect</span>
        </a>
    @endif
</div>
