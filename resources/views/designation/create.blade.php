@extends('layouts.app')
@section('title', 'Add Designation')
@section('content')
    <div class="flex">
        <div class="w-1/3">
            <h1 class="text-2xl font-semibold text-blue-gray-900">Add Designation</h1>
            <form action="{{ route('designation.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-blue-gray-700">Name</label>
                    <input type="text" name="name" id="name"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('name')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="responsibilities" class="block text-blue-gray-700">Responsibilities</label>
                    <textarea name="responsibilities" id="responsibilities"
                        class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500"></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Save</button>
                </div>
                <ul>

                </ul>
            </form>
        </div>
    </div>

@endsection
