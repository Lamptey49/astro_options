@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white/5 backdrop-blur p-8 rounded-2xl border border-white/10 shadow-xl">

        <h2 class="text-3xl font-bold text-center mb-2">
            Create Account
        </h2>
        <p class="text-center text-gray-400 mb-8">
            Start investing today
        </p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-5">
                <label class="block mb-2 text-sm">Full Name</label>
                <input type="text" name="name" required
                       class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label class="block mb-2 text-sm">Email Address</label>
                <input type="email" name="email" required
                       class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label class="block mb-2 text-sm">Password</label>
                <input type="password" name="password" required
                       class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block mb-2 text-sm">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <!-- Submit -->
            <button class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-500 font-semibold hover:opacity-90">
                Create Account
            </button>
        </form>

        <p class="text-center text-gray-400 mt-8 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">
                Login
            </a>
        </p>

    </div>
</div>
@endsection
