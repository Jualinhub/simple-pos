@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <div class="w-full h-screen flex justify-center items-center bg-primary p-10 md:p-2">
        <div class="w-full md:w-1/4 bg-white rounded-xl p-8 pt-10 relative">
            <div class="absolute" style="top: -5vh; left: -5vh">
                <x-logo />
            </div>
            <h1 class=" text-2xl">Welcome!</h1>
            
            <form action="" method="POST">
                @csrf
                <div class="mt-4">

                    @error('email')
                    <div class="bg-red-200 text-red-600 text-sm w-full p-2 rounded mb-4">{{ $message }}</div>
                    @enderror

                    <div class="block mb-3">
                        <label for="email" class="text-sm text-gray-600 block mb-1">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" id="email" class="w-full border border-gray-400 rounded p-3" placeholder="Enter your Email" required>
                    </div>
    
                    <div class="block mb-3">
                        <label for="password" class="text-sm text-gray-600 block mb-1">Password</label>
                        <input type="password" name="password" id="password" class="w-full border border-gray-400 rounded p-3" placeholder="Enter your Password" required>
                    </div>
    
                    <div class="mt-2">
                        <button class="bg-primary w-full py-3 rounded text-white text-xl">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection