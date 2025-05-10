@extends('layouts.auth')

@section('title', 'Masuk')

@section('description', 'Masuk dengan akun yang telah Kamu daftarkan.')

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
        <a href="#" class="text-dark hover:text-primary">Lupa kata sandi mu?</a>
    </div>
    <div class="flex items-center justify-center">
        <div class="g-recaptcha" data-sitekey="your-site-key"></div>
    </div>
    <button type="submit" class="w-full bg-primary disabled:bg-primary/50 inline-flex items-center justify-center hover:bg-primary/75 text-light font-medium rounded-lg text-sm px-front.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">Masuk</button>
</form>
<div class="mt-6">
    <h5 class="text-center text-dark">Tidak memiliki akun? <a class="font-semibold cursor-pointer hover:text-primary/90 text-primary" href="#">Daftar</a></h5>
</div>
@endsection
