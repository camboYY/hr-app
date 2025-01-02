@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <div class="w-full max-w-sm min-w-[200px]">
        <form action="{{ route('employee.search') }}" method="GET">
            @csrf
            <div class="relative">
                <input name="search" type="text"
                    class="w-full bg-transparent placeholder:text-black text-black text-sm border border-pink-200 rounded-md pl-3 pr-28 py-2 transition duration-300 ease focus:outline-none focus:border-pink-400 hover:border-pink-300 shadow-sm focus:shadow"
                    placeholder="First Name or Last Name" />
                <button
                    class="absolute top-1 right-1 flex items-center rounded bg-pink-800 py-1 px-2.5 border border-transparent text-center text-sm text-white transition-all shadow-sm hover:shadow focus:bg-pink-700 focus:shadow-none active:bg-pink-700 hover:bg-pink-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2">
                        <path fill-rule="evenodd"
                            d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    Search
                </button>
            </div>
        </form>
        <div class="flex w-1/3 flex-col">
            <h1 class="text-2xl font-semibold text-blue-gray-900">Result</h1>
            {{-- Display search result --}}
            @if (isset($employees))
                @foreach ($employees as $employee)
                    {{ $employee->firstName }}
                @endforeach
            @endif
        </div>
    </div>
@endsection
