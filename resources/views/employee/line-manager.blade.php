@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <div class="flex w-1/3 mt-2">

        @if (!isset($lineManagers))
            <form action="{{ route('employee.search') }}" class="w-full" method="POST">
                @csrf
                @method('POST')
                <div class="flex flex-row  w-full justify-between ">
                    <input type="text" name="query" placeholder="First name , Last name"
                        class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    <button class="py-2 px-2 rounded-md text-white bg-pink-500 hover:bg-pink-700">
                        search</button>
                </div>
            </form>
        @else
            @if (isset($lineManagers) && count($lineManagers) == 0)
                <p class="text-red-500">No line manager found</p>
            @endif
            @foreach ($lineManagers as $item)
                <form action="{{ route('employee.line-manager.select') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="flex w-full flex-row justify-between">
                            <input type="text" name="lineManagerId" value="{{ $item->id }}" hidden />
                            <input type="text" name="name" value="{{ $item->name }}"
                                class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">

                            <button type="submit"
                                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700">Take</button>
                        </div>
                    </div>
                </form>
            @endforeach

        @endif
    </div>
@endsection
