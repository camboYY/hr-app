@extends('layouts.app')
@section('title', 'Designation')
@section('content')
    <div class="flex">
        <div class="w-1/3">
            @if (!isset($designations))
                <form action="{{ route('designation.search') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="search-designation" class="form-label">Query:</label>
                        <input type="text" id="search-designation" name="query"
                            class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500"
                            placeholder="Designation title">
                    </div>

                    <div class="mb-3 text-center">
                        <button class="py-2 px-2 rounded-md text-white bg-pink-500 hover:bg-pink-700">
                            Submit</button>
                    </div>
                </form>
            @else
                @if (isset($designations) && count($designations) == 0)
                    <p class="text-red-500">No designation found</p>
                @endif
                @foreach ($designations as $item)
                    <form action="{{ route('employee.designation.select') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <div class="flex w-full flex-row justify-between">
                                <input type="text" name="designationId" value="{{ $item->id }}" hidden />

                                <input type="text" name="name" value="{{ $item->name }}"
                                    class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">

                                <button type="submit"
                                    class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700">Take</button>
                            </div>
                        </div>
                    </form>
                @endforeach
            @endif
        </div>

    </div>
@endsection
