@extends('layouts.panel')

@section('content')
<x-front.card.card title="Profile">
    <div class="flex items-center mb-3">
        @if(Auth::user()->avatar)                                                
            <img class="object-cover lazyload h-14 w-14 rounded-lg lazyload" loading="lazy" data-src="{{ Auth::user()->avatar }}" alt="user photo">
        @else
            <span class="object-cover lazyload h-14 w-14 rounded-lg flex items-center justify-center bg-primary text-white text-sm font-medium">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
        @endif
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid md:grid-cols-2 gap-3 mb-3">
            <x-front.input 
            label="Name"
            id="name"
            name="name" 
            placeholder="Name" 
            value="{{ auth()->user()->name }}"
            type="text"
            />
            <x-front.input 
                label="Username"
                id="username"
                name="username" 
                placeholder="Username" 
                type="text"
                value="{{ auth()->user()->username }}"
                :disabled="true"
            />
            <x-front.input 
                label="Email"
                id="email"
                name="email" 
                placeholder="Email" 
                value="{{ auth()->user()->email }}"
                type="text"
                :disabled="true"
            />
             <x-front.input 
                label="Created At"
                id="created_at"
                name="created_at"
                placeholder="created_at" 
                value="{{ auth()->user()->created_at }}"
                type="text"
                :disabled="true"
            />
        </div>
        <button type="submit" class="py-1.5 px-4 bg-primary text-white rounded-lg ">Submit</button>
        <button type="reset" class="py-1.5 px-4 bg-danger text-white rounded-lg ">Reset</button>
    </form>
</x-front.card.card>

<x-front.card.card title="Password">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <x-front.input 
                label="Old Password"
                id="password"
                name="password" 
                placeholder="Old Password" 
                type="password"
            />
        </div>
        <div class="grid md:grid-cols-2 gap-3 mb-3">
            <x-front.input 
                label="Password"
                id="password"
                name="password" 
                placeholder="Password" 
                type="password"
            />
            <x-front.input 
                label="Confirmation Password"
                id="confirmation_password"
                name="confirmation_password" 
                placeholder="Confirmation Password" 
                type="password"
            />  
        </div>
        <button type="submit" class="py-1.5 px-4 bg-primary text-white rounded-lg ">Submit</button>
        <button type="reset" class="py-1.5 px-4 bg-danger text-white rounded-lg ">Reset</button>
    </form>
</x-front.card.card>

<x-front.card.card title="Linked Account">
    <div class="grid md:grid-cols-2 gap-3 mb-3">
        <!-- Google Account -->
        <div class="p-4 rounded-lg w-full 
            {{ Auth::user()->isGoogleConnected() ? 'bg-success' : 'bg-gray-300' }} 
            text-white font-semibold flex items-center justify-between gap-4 transition-all duration-300 ease-in-out">

            <div class="flex items-center gap-3">
                <!-- Google Icon -->
                <i class="ri ri-google-line text-2xl"></i>
                
                <!-- Text Section -->
                <div class="flex flex-col">
                    <span class="text-lg font-semibold">
                        Google
                    </span>
                    <span class="text-xs text-white">
                        {{ Auth::user()->isGoogleConnected() ? 'Connected' : 'Not Connected' }}
                    </span>
                </div>
            </div>

            <!-- Action Button -->
            @if(Auth::user()->isGoogleConnected())
                <!-- If connected, show Disconnect Button -->
                <a href="{{ route('auth.disconnect.social', 'google') }}" 
                    class="flex items-center justify-center px-4 py-2 bg-white rounded-lg text-danger font-medium hover:bg-gray-100 transition-all duration-300 ease-in-out"
                    title="Disconnect Google"
                    >
                    <i class="ri ri-delete-bin-line text-lg"></i>
                    <span class="ml-2 text-sm">Disconnect</span>
                </a>
            @else
                <!-- If not connected, show Connect Button -->
                <a href="{{ route('auth.login.social', ['provider' => 'google']) }}" 
                    class="flex items-center justify-center px-4 py-2 bg-danger rounded-lg text-white font-medium hover:bg-danger/70 transition-all duration-300 ease-in-out"
                    title="Connect Google">
                    <i class="ri ri-google-fill text-lg"></i>
                    <span class="ml-2 text-sm">Connect</span>
                </a>
            @endif
        </div>

       <div class="p-4 rounded-lg w-full 
            {{ Auth::user()->isFacebookConnected() ? 'bg-success' : 'bg-gray-300' }} 
            text-white font-semibold flex items-center justify-between gap-4 transition-all duration-300 ease-in-out">

            <div class="flex items-center gap-3">
                <!-- Facebook Icon -->
                <i class="ri ri-facebook-line text-2xl"></i>
                
                <!-- Text Section -->
                <div class="flex flex-col">
                    <span class="text-lg font-semibold">
                        Facebook
                    </span>
                    <span class="text-xs text-white">
                        {{ Auth::user()->isFacebookConnected() ? 'Connected' : 'Not Connected' }}
                    </span>
                </div>
            </div>

            <!-- Action Button -->
            @if(Auth::user()->isFacebookConnected())
                <!-- If connected, show Disconnect Button -->
                <a href="{{ route('auth.disconnect.social', 'facebook') }}" 
                    class="flex items-center justify-center px-4 py-2 bg-white rounded-lg text-danger font-medium hover:bg-gray-100 transition-all duration-300 ease-in-out"
                    title="Disconnect Facebook"
                    >
                    <i class="ri ri-delete-bin-line text-lg"></i>
                    <span class="ml-2 text-sm">Disconnect</span>
                </a>
            @else
                <!-- If not connected, show Connect Button -->
                <a href="{{ route('auth.login.social', ['provider' => 'facebook']) }}" 
                    class="flex items-center justify-center px-4 py-2 bg-blue-600 rounded-lg text-white font-medium hover:bg-blue-600/70 transition-all duration-300 ease-in-out"
                    title="Connect Facebook">
                    <i class="ri ri-facebook-fill text-lg"></i>
                    <span class="ml-2 text-sm">Connect</span>
                </a>
            @endif
        </div>
    </div>
</x-front.card.card>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('swalError'))
    <script>
        Swal.fire({
            html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/azxkyjta.json" trigger="loop" style="width:100px;height:100px"></lord-icon>
                    <div class="pt-2 mx-5 mt-4 fs-15">
                        <h4 class="text-2xl font-semibold">Oops!!</h4>
                        <p class="mx-4 mb-0 text-muted">{{ session('swalError') }}</p>
                    </div>
                </div>
            `,
            customClass: {
                confirmButton: "bg-primary text-white mb-1",
            },
        });
    </script>
@endif

@if(session('swalSuccess'))
     <script>
        Swal.fire({
            html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/mhnfcfpf.json" trigger="loop" style="width:100px;height:100px"></lord-icon>
                    <div class="pt-2 mx-5 mt-4 fs-15">
                        <h4 class="text-2xl font-semibold">Success!!</h4>
                        <p class="mx-4 mb-0 text-muted">{{ session('swalSuccess') }}</p>
                    </div>
                </div>
            `,
            customClass: {
                confirmButton: "bg-primary text-white mb-1",
            },
        });
    </script>
@endif
@endpush