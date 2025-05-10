@extends('layouts.auth')

@section('title', 'Login')

@section('description', 'Start your session with us.')

@section('content')
<form class="mt-6 space-y-4" method="POST">
    @csrf
    <div>
        <x-front.input 
            label="Username"
            id="username"
            name="username" 
            placeholder="Username" 
            type="text"
        />
    </div>
    <div>
        <x-front.input 
            label="Password"
            id="password"
            name="password" 
            placeholder="Password" 
            type="password"
        />
    </div>
    
    <div class="flex items-center justify-end text-sm">      
        <a href="#" class="text-dark hover:text-primary">Forgot Password?</a>
    </div>
    <div class="flex items-center justify-center">
        <div class="g-recaptcha" data-sitekey="your-site-key"></div>
    </div>
    <button type="submit" class="w-full bg-primary disabled:bg-primary/50 inline-flex items-center justify-center hover:bg-primary/75 text-light font-medium rounded-lg text-sm px-front.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">Login</button>
    <div class="mb-3">
        <span class="relative flex items-center text-sm text-dark bg-light">
          <span class="flex-grow border-t border-dark/25"></span>
          <span class="mx-8">Login With</span>
          <span class="flex-grow border-t border-dark/25"></span>
        </span>
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="bg-red-600 rounded-lg text-white text-xs text-center self-center px-3 py-2 my-2 flex items-center justify-center">
                <i class="ri-google-fill mr-2"></i> Google
            </a>

            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="bg-blue-600 rounded-lg text-white text-xs text-center self-center px-3 py-2 my-2 flex items-center justify-center">
                <i class="ri-facebook-fill mr-2"></i> Facebook
            </a>
        </div>
    </div>
</form>
<div class="mt-6">
    <h5 class="text-center text-dark">New on our platform?  <a class="font-semibold cursor-pointer hover:text-primary/90 text-primary" href="#">Register</a></h5>
</div>

@endsection
