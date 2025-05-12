@extends('layouts.panel')

@section('content')
<x-card.card title="Profile">
    <div class="flex items-center mb-3">
        @if(Auth::user()->avatar)                                                
            <img class="object-cover lazyload h-14 w-14 rounded-lg lazyload" loading="lazy" data-src="{{ Auth::user()->avatar }}" alt="user photo">
        @else
            <span class="object-cover lazyload h-14 w-14 rounded-lg flex items-center justify-center bg-primary text-white text-sm font-medium">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>
        @endif
    </div>
    <form action="{{ route('settings.update.profile') }}" method="POST" enctype="multipart/form-data" data-reset="false">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-3 mb-3">
            <x-input 
                label="Name"
                id="name"
                name="name" 
                placeholder="Name" 
                value="{{ auth()->user()->name }}"
                type="text"
            />
            <x-input 
                label="Username"
                id="username"
                name="username" 
                placeholder="Username" 
                type="text"
                value="{{ auth()->user()->username }}"
                :disabled="true"
            />
            <x-input 
                label="Email"
                id="email"
                name="email" 
                placeholder="Email" 
                value="{{ auth()->user()->email }}"
                type="text"
                :disabled="true"
            />
             <x-input 
                label="Created At"
                id="created_at"
                name="created_at"
                placeholder="created_at" 
                value="{{ auth()->user()->created_at }}"
                type="text"
                :disabled="true"
            />
        </div>
        <x-button label="Submit" type="submit" />
        <x-button label="Reset" type="reset" />
    </form>
</x-card.card>

<x-card.card title="Password">
    <form action="{{ route('settings.update.password') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if(Auth::user()->password)
            <div class="mb-3">
                <x-input 
                    label="Current Password"
                    id="current_password"
                    name="current_password" 
                    placeholder="Current Password" 
                    type="password"
                />
            </div>
        @else
            <x-alert type="warning" message="Your password has not been set yet. Please set a new password." />
        @endif
        <div class="grid md:grid-cols-2 gap-3 mb-3">
            <x-input 
                label="New Password"
                id="new_password"
                name="password" 
                placeholder="New Password" 
                type="password"
            />
            <x-input 
                label="Confirm Password"
                id="password_confirmation"
                name="password_confirmation" 
                placeholder="Confirm Password" 
                type="password"
            />  
        </div>
        <x-button label="Submit" type="submit" />
        <x-button label="Reset" type="reset" />
    </form>
</x-card.card>

<x-card.card title="Linked Account">
    <div class="grid md:grid-cols-2 gap-3 mb-3">
        <x-social-account provider="google" isConnected="{{ Auth::user()->isGoogleConnected() }}" />
        <x-social-account provider="facebook" isConnected="{{ Auth::user()->isFacebookConnected() }}" />
    </div>
</x-card.card>

<x-card.card title="Delete Account">
    <form action="{{ route('settings.delete.account') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div class="mb-3">
            <x-alert type="warning" message="Are you sure you want to delete your account? This action cannot be undone." />
        </div>
        <div class="grid md:grid-cols-2 gap-3 mb-3">
            <x-input 
                label="Password"
                id="password"
                name="password" 
                placeholder="Password" 
                type="password"
            />
            <x-input 
                label="Confirm Password"
                id="password_confirmation"
                name="password_confirmation" 
                placeholder="Confirm Password" 
                type="password"
            /> 
        </div>
        <x-button label="Delete Account" type="submit" color="danger" />
    </form>
</x-card.card>
@endsection

@push('scripts')
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
                confirmButton: "btn btn-primary btn-md mx-1",
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
                confirmButton: "btn btn-primary btn-md mx-1",
            },
        });
    </script>
@endif
@endpush