@extends('layouts.auth')

@section('title', config('app.name'))

@section('description', 'Join '.config('app.name').', find your next favorite bite!')

@section('content')
<div class="">
    <div class="flex flex-col md:w-sm">
        <a href="{{ route('auth.login.social', ['provider' => 'google']) }}" class="text-dark gap-2 shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 48 48" class="LgbsSe-Bz112c"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>
            Sign up with Google
        </a>
        <a href="{{ route('auth.login.social', ['provider' => 'facebook']) }}" type="button" class="text-white shadow-sm gap-2 border bg-[#3b5998] hover:bg-[#3b5998]/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
            <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
            <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
            </svg>
            Sign up with Facebook
        </a>
        <span class="relative flex items-center text-sm text-dark bg-light mb-2">
          <span class="flex-grow border-t border-dark/25"></span>
          <span class="mx-4 font-semibold">OR</span>
          <span class="flex-grow border-t border-dark/25"></span>
        </span>
        <div class="flex flex-col">
            <button type="button" data-modal-target="registerModal" data-modal-toggle="registerModal" class="text-white gap-2 shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center">
                Create Account
            </button>
            <span class="text-xs text-dark">
                By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use.
            </span>
        </div>
        <div class="mt-12">
            <h5 class="font-semibold text-dark text-sm">Already have an account?</h5>
        </div>
        <button type="button" data-modal-target="loginModal" data-modal-toggle="loginModal" class="text-primary border-2 border-primary gap-2 shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center me-2 mb-2">
            Login
        </button>
    </div>
</div>

<div id="registerModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="registerModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-4 pt-4 mb-3">
                <x-logo />
            </div>
            <div class="p-4 flex flex-col md:w-sm mx-auto">
                <div class="mb-6">
                    <h5 class="text-4xl font-bold text-primary">Create Account</h5>
                    <p class="text-black font-semibold text-sm">Explore. Review. Devour. Join Today!</p>
                </div>
                <form action="{{ route('auth.register.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <x-input 
                            label="Username"
                            id="registerUsername"
                            name="username" 
                            placeholder="Username" 
                            type="text"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Name"
                            id="registerName"
                            name="name" 
                            placeholder="Name" 
                            type="text"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Email"
                            id="registerEmail"
                            name="email" 
                            placeholder="Email" 
                            type="email"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Phone Number"
                            id="registerPhone"
                            name="phone" 
                            placeholder="Phone Number" 
                            type="number"
                        />
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-2">
                        <div class="mb-3">
                            <x-input 
                                label="Password"
                                id="registerPassword"
                                name="password" 
                                placeholder="Password" 
                                type="password"
                            />
                        </div>
                        <div class="mb-3">
                            <x-input 
                                label="Confirm Password"
                                id="registerPasswordConfirmation"
                                name="password_confirmation"
                                placeholder="Password" 
                                type="password"
                            />
                        </div>
                    </div>
                    <div class="flex items-center mb-3 relative">
                        <input id="link-checkbox" type="checkbox" value="1" name="terms" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded-sm focus:ring-primary focus:ring-2">
                        <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900">I agree with the <a href="{{ route('page.index', ['slug' => 'terms-and-conditions']) }}" class="text-primary hover:underline">terms and conditions</a>.</label>
                    </div>
    
                    <!-- Modal footer -->
                    <button type="submit" class="text-white shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-6 w-full">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="loginModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="loginModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-4 pt-4 mb-3">
                <x-logo />
            </div>
            <div class="p-4 flex flex-col md:w-sm mx-auto">
                <div class="mb-6">
                    <h5 class="text-4xl font-bold text-primary">Login to {{ config('app.name') }}</h5>
                    <p class="text-black font-semibold text-sm">Welcome Back, fud!</p>
                </div>
                <a href="{{ route('auth.login.social', ['provider' => 'google']) }}" class="text-dark gap-2 shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 48 48" class="LgbsSe-Bz112c"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>
                    Sign in with Google
                </a>
                <a href="{{ route('auth.login.social', ['provider' => 'facebook']) }}" type="button" class="text-white shadow-sm gap-2 border bg-[#3b5998] hover:bg-[#3b5998]/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
                    <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                    <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                    </svg>
                    Sign in with Facebook
                </a>
                <span class="relative flex items-center text-sm text-dark mb-2">
                <span class="flex-grow border-t border-dark/25"></span>
                <span class="mx-4 font-semibold">OR</span>
                <span class="flex-grow border-t border-dark/25"></span>
                </span>
                <form action="{{ route('auth.login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <x-input 
                            label="Phone, email or username"
                            id="loginUsername"
                            name="input" 
                            placeholder="Enter your phone, email or username" 
                            type="text"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Password"
                            id="loginPassword"
                            name="password" 
                            placeholder="Enter your Password"
                            type="password"
                        />
                    </div>
                    <!-- Modal footer -->
                    <button type="submit" class="text-white shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2 w-full">
                        Login
                    </button>
                </form>
                <button data-modal-target="forgotModal" data-modal-toggle="forgotModal" type="button" class="text-primary border-2 border-primary shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-9">
                    Forgot Password?
                </button>
            </div>
        </div>
    </div>
</div>

<div id="forgotModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="forgotModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="px-4 pt-4 mb-3">
                <x-logo />
            </div>
            <div class="p-4 flex flex-col md:w-sm mx-auto">
                <div class="mb-6">
                    <h5 class="text-4xl font-bold text-primary">Forgot Password</h5>
                    <p class="text-black font-semibold text-sm">No worries! Reset your password with OTP.</p>
                </div>
                <form method="POST">
                    @csrf
                    <div class="mb-3">
                        <x-input 
                            label="Email"
                            id="forgotEmail"
                            name="email" 
                            placeholder="Email" 
                            type="email"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Token"
                            id="forgotToken"
                            name="token" 
                            placeholder="Token" 
                            type="text"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Password"
                            id="forgotPassword"
                            name="password" 
                            placeholder="Password" 
                            type="password"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input 
                            label="Confirm Password"
                            id="forgotPasswordConfirmation"
                            name="password_confirmation"
                            placeholder="Password" 
                            type="password"
                        />
                    </div>
    
                    <!-- Modal footer -->
                    <button type="submit" class="text-white shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-6 w-full">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
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
                        <p class="mx-4 mb-0 text-dark">{{ session('swalError') }}</p>
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
                        <p class="mx-4 mb-0 text-dark">{{ session('swalSuccess') }}</p>
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
