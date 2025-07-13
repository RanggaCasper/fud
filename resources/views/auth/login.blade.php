@extends('layouts.auth')

@section('title', config('app.name'))

@section('description', 'Join ' . config('app.name') . ', find your next favorite bite!')

@section('content')
    <div class="">
        <div class="flex flex-col md:w-sm">
            <a href="{{ route('auth.login.social', ['provider' => 'google']) }}"
                class="text-dark gap-2 shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 48 48" class="LgbsSe-Bz112c">
                    <g>
                        <path fill="#EA4335"
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                        </path>
                        <path fill="#4285F4"
                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                        </path>
                        <path fill="#FBBC05"
                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                        </path>
                        <path fill="#34A853"
                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                        </path>
                        <path fill="none" d="M0 0h48v48H0z"></path>
                    </g>
                </svg>
                Sign up with Google
            </a>
            <a href="{{ route('auth.login.social', ['provider' => 'facebook']) }}" type="button"
                class="text-white shadow-sm gap-2 border bg-[#3b5998] hover:bg-[#3b5998]/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
                <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 8 19">
                    <path fill-rule="evenodd"
                        d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                        clip-rule="evenodd" />
                </svg>
                Sign up with Facebook
            </a>
            <span class="relative flex items-center text-sm text-dark bg-light mb-2">
                <span class="flex-grow border-t border-dark/25"></span>
                <span class="mx-4 font-semibold">OR</span>
                <span class="flex-grow border-t border-dark/25"></span>
            </span>
            <div class="flex flex-col">
                <button type="button" data-modal-target="registerModal" data-modal-toggle="registerModal"
                    class="text-white gap-2 shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center">
                    Create Account
                </button>
                <span class="text-xs text-dark">
                    By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use.
                </span>
            </div>
            <div class="mt-12">
                <h5 class="font-semibold text-dark text-sm">Already have an account?</h5>
            </div>
            <button type="button" data-modal-target="loginModal" data-modal-toggle="loginModal"
                class="text-primary border-2 border-primary gap-2 shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center me-2 mb-2">
                Login
            </button>
        </div>
    </div>

    <div id="registerModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="registerModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                            <x-input label="Username" id="registerUsername" name="username" placeholder="Username"
                                type="text" />
                        </div>
                        <div class="mb-3">
                            <x-input label="Name" id="registerName" name="name" placeholder="Name" type="text" />
                        </div>
                        <div class="mb-3">
                            <x-input label="Email" id="registerEmail" name="email" placeholder="Email" type="email" />
                        </div>
                        <div class="mb-3">
                            <x-input label="Phone Number" id="registerPhone" name="phone" placeholder="Phone Number"
                                type="number" />
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-2">
                            <div class="mb-3">
                                <x-input label="Password" id="registerPassword" name="password" placeholder="Password"
                                    type="password" />
                            </div>
                            <div class="mb-3">
                                <x-input label="Confirm Password" id="registerPasswordConfirmation"
                                    name="password_confirmation" placeholder="Password" type="password" />
                            </div>
                        </div>
                        <div class="flex items-center mb-3 relative">
                            <input id="link-checkbox" type="checkbox" value="1" name="terms"
                                class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded-sm focus:ring-primary focus:ring-2">
                            <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900">I agree with the <a
                                    href="{{ route('page.index', ['slug' => 'terms-and-conditions']) }}"
                                    class="text-primary hover:underline">terms and conditions</a>.</label>
                        </div>

                        <!-- Modal footer -->
                        <button type="submit"
                            class="text-white shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-6 w-full">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="loginModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                    <a href="{{ route('auth.login.social', ['provider' => 'google']) }}"
                        class="text-dark gap-2 shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 48 48"
                            class="LgbsSe-Bz112c">
                            <g>
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                </path>
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                </path>
                                <path fill="#FBBC05"
                                    d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                </path>
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                </path>
                                <path fill="none" d="M0 0h48v48H0z"></path>
                            </g>
                        </svg>
                        Sign in with Google
                    </a>
                    <a href="{{ route('auth.login.social', ['provider' => 'facebook']) }}" type="button"
                        class="text-white shadow-sm gap-2 border bg-[#3b5998] hover:bg-[#3b5998]/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2">
                        <svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 8 19">
                            <path fill-rule="evenodd"
                                d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                clip-rule="evenodd" />
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
                            <x-input label="Phone, email or username" id="loginUsername" name="input"
                                placeholder="Enter your phone, email or username" type="text" />
                        </div>
                        <div class="mb-3">
                            <x-input label="Password" id="loginPassword" name="password"
                                placeholder="Enter your Password" type="password" />
                        </div>
                        <div class="mb-3 flex justify-between items-center">
                            {!! NoCaptcha::display() !!}
                            <div>
                                <x-button class="btn-icon" id="refreshCaptcha"><i class="ti ti-refresh text-lg"></i></x-button>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <button type="submit"
                            class="text-white shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-2 w-full">
                            Login
                        </button>
                    </form>
                    <button data-modal-target="forgotModal" data-modal-toggle="forgotModal" data-modal-hide="loginModal"
                        type="button"
                        class="text-primary border-2 border-primary shadow-sm bg-white hover:bg-primary/10 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-9">
                        Forgot Password?
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="forgotModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="forgotModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                    <form action="{{ route('auth.forgot.store') }}" method="POST" id="forgotPasswordForm">
                        @csrf
                        <div class="mb-3">
                            <x-input label="Email" id="forgotEmail" name="email" placeholder="Email"
                                type="email" />
                        </div>
                        <div class="mb-3">
                            <x-input-group label="Token" id="token" name="token" placeholder="Token"
                                button-text="Send" button-type="button" button-id="btnToken" />
                        </div>
                        <div class="mb-3">
                            <x-input label="Password" id="forgotPassword" name="password" placeholder="Password"
                                type="password" />
                        </div>
                        <div class="mb-3">
                            <x-input label="Confirm Password" id="forgotPasswordConfirmation"
                                name="password_confirmation" placeholder="Password" type="password" />
                        </div>

                        <!-- Modal footer -->
                        <button type="submit"
                            class="text-white shadow-sm bg-primary hover:bg-primary/90 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-center mb-6 w-full">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const cooldownKey = 'forgotTokenCooldownUntil';
        const button = $('#btnToken');
        const buttonText = 'Send';

        function startCooldown(button, originalText, cooldownUntil) {
            const interval = setInterval(() => {
                const now = Date.now();
                const secondsLeft = Math.ceil((cooldownUntil - now) / 1000);

                if (secondsLeft <= 0) {
                    clearInterval(interval);
                    button.prop('disabled', false);
                    button.html(originalText);
                    localStorage.removeItem(cooldownKey);
                } else {
                    button.prop('disabled', true);
                    button.html(`${secondsLeft}s`);
                }
            }, 1000);
        }

        $(document).ready(function() {
            const cooldownUntil = parseInt(localStorage.getItem(cooldownKey));
            if (cooldownUntil && cooldownUntil > Date.now()) {
                startCooldown(button, buttonText, cooldownUntil);
            }
        });

        $('#btnToken').click(function() {
            let button = $(this);
            let originalText = buttonText;

            button.prop('disabled', true);
            $('.alert').remove();
            button.html(`
            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-light animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
            </svg>
            Loading...
        `);

            $.ajax({
                url: '{{ route('auth.forgot.getToken') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: $('#forgotEmail').val(),
                },
                success: function(response) {
                    if (response.status && response.message) {
                        $('#forgotPasswordForm').before(`
                        <div class="alert flex items-center p-4 mb-4 text-sm bg-green-50 dark:!text-white dark:bg-success text-success border-success border rounded-lg" role="alert">
                            <i class="ti ti-info-circle text-lg me-1"></i>
                            <div>${response.message}</div>
                        </div>
                    `);

                        const cooldownUntil = Date.now() + 60 * 1000;
                        localStorage.setItem(cooldownKey, cooldownUntil);
                        startCooldown(button, originalText, cooldownUntil);
                    } else {
                        button.prop('disabled', false);
                        button.html(originalText);
                    }
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    let errors = response.errors;

                    $(".error-message").remove();

                    if (errors && typeof errors === "object" && Object.keys(errors).length > 0) {
                        $.each(errors, function(field, message) {
                            let input = $(`[name="${field}"]`);
                            let d = input.closest(".relative");
                            input.addClass("border-danger");
                            d.after(
                                `<div class="error-message text-xs text-danger mt-1">${message[0]}</div>`);
                        });
                    } else {
                        const msg = response.errors || response.message;
                        $('#forgotPasswordForm').before(`
                        <div class="alert flex items-center p-4 mb-4 text-sm bg-red-50 dark:!text-white dark:bg-danger text-danger border-danger border rounded-lg" role="alert">
                            <i class="ti ti-info-circle text-lg me-1"></i>
                            <div>${msg}</div>
                        </div>
                    `);
                    }

                    button.prop('disabled', false);
                    button.html(originalText);
                },
                complete: function() {
                }
            });
        });

        $('#refreshCaptcha').on('click', function() {
            grecaptcha.reset();
        });
    </script>
@endpush
