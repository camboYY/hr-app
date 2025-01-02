@extends('layouts.app')
@section('title', 'Designation')
@section('content')
    <div class="flex flex-col w-full">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-pink-gray-900">Designation</h1>
            <a href="{{ route('designation.create') }}"
                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700">Add Designation</a>
        </div>
        <div class="mt-4">
            <table class="w-full border-collapse border border-pink-gray-200">
                <thead>
                    <tr class="bg-pink-gray-50">
                        <th class="border border-pink-gray-200 px-4 py-2">ID</th>
                        <th class="border border-pink-gray-200 px-4 py-2">Name</th>
                        <th class="border border-pink-gray-200 px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($designations as $designation)
                        <tr>
                            <td class="border border-pink-gray-200 px-4 py-2">{{ $designation->id }}</td>
                            <td class="border border-pink-gray-200 px-4 py-2">{{ $designation->name }}</td>
                            <td class="border border-pink-gray-200 px-4 py-2">
                                <a role="button" href="{{ route('designation.edit', $designation->id) }}"
                                    class="px-4 py-2.5 bg-pink-500 text-white rounded-md hover:bg-pink-700">Edit</a>
                                <form action="{{ route('designation.destroy', $designation->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>{{ $designations->links() }}</h3>
        </div>
    </div>
@endsection
