@extends('layouts.app')
@section('title', 'Departement')
@section('content')
    <div class="flex flex-col w-full">

        <div class="flex justify-between items-center">

            <h1 class="text-2xl font-semibold text-pink-gray-900">Departement</h1>
            <a href="{{ route('department.create') }}"
                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700 mx-1 my-1">Add departement</a>
        </div>
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($departements as $departement)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            {{ $departement->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            {{ $departement->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <a href="{{ route('department.edit', $departement->id) }}"
                                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700 mx-1 my-1">Edit</a>
                            <form action="{{ route('department.destroy', $departement->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-1.5 bg-red-500 text-white rounded-md hover:bg-red-700 mx-1 my-1">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $departements->links() }}
    </div>
    </div>
@endsection
