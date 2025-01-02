{{-- @extends('layouts.app') --}}

@section('title', 'Login')
<x-layout>
    <div class="flex mx-auto bg-gray-200 px-10 py-4 rounded-md shadow-md">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input class="my-4 w-full form-input rounded-sm px-4 py-3" type="email" name="email" placeholder="E-mail">
            <input class="my-4 w-full form-input rounded-sm px-4 py-3" type="password" name="password"
                placeholder="Password">
            <button class="text-white px-4 py-3 w-full rounded-sm bg-pink-500 hover:bg-pink-700"
                type="submit">Login</button>
            @if (Session::has('error'))
                <div class="text-red-500"> {{ Session::get('error') }}</div>
            @endif
        </form>
    </div>
</x-layout>
