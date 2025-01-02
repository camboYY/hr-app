@extends('layouts.app')
@section('title', 'Edit Designation')
@section('content')
    <div class="flex">
        <div class="w-1/3">
            <h1 class="text-2xl font-semibold text-blue-gray-900">Edit Designation</h1>
            <form action="{{ route('designation.update', $designation->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-blue-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ $designation->name }}"
                        class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500"
                        required>
                </div>
                <div class="mb-4">
                    <label for="responsibilities" class="block text-blue-gray-700">Responsibilities</label>
                    <textarea name="responsibilities" id="responsibilities"
                        class="w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500"
                        required>{{ $designation->responsibilities }}</textarea>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
