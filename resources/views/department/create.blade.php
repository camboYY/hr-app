@extends('layouts.app')
@section('title', 'Department')
@section('content')
    <div class="flex">
        <div class="w-1/3">
            <h1 class="text-2xl font-semibold text-blue-gray-900">Add Department</h1>
            <form action="{{ route('department.store') }}" method="POST" class="mt-4">
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
                    <label for="description" class="block text-blue-gray-700">Description</label>
                    <textarea name="description" id="description"
                        class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500"></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700">Save</button>
                </div>
                <ul>

                </ul>
            </form>
        </div>
    </div>

@endsection
