@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="flex flex-col w-full">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-blue-gray-900">Dashboard</h1>
            <a href="{{ route('designation.index') }}"
                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700 mx-1 my-1">Designation</a>
            <a href="{{ route('department.index') }}"
                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700 mx-1 my-1">Department</a>
        </div>
    @endsection
