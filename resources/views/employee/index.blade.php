@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <div class="flex flex-col w-full">
        <div class="flex justify-between items-center">

            <h1 class="text-2xl font-semibold text-pink-gray-900">Employee</h1>
            <a href="{{ route('employee.designation') }}"
                class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700 mx-1 my-1">Add departement</a>
        </div>

        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        First Name</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Last Name</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Phone Number</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Middle Name</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        National ID Card</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Marrital Status</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Date Of Birth</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Medical Certificate</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Gender</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Line Manager</th>
                    <th
                        class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                        Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($employees as $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->first_name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->last_name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->phone_number }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->middle_name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->national_id }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->marital_status }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->date_of_birth }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->medical_certificate }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->gender }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">{{ $employee->line_manager }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <a href="{{ route('employee.edit', $employee->id) }}">Edit</a>
                            <a href="{{ route('employee.destroy', $employee->id) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{ $employees->links() }}
        </table>
    </div>
@endsection
