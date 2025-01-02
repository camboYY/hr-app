@extends('layouts.app')
@section('title', 'Employee')
@section('content')
    <div class="flex">
        <div class="flex-col w-1/3">
            <form action="{{ route('employee.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="firstName" class="block text-blue-gray-700">First Name</label>
                    <input type="text" name="firstName" id="firstName"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('firstName')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-blue-gray-700">Last Name</label>
                    <input type="text" name="lastName" id="lastName"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('lastName')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="phoneNumber" class="block text-blue-gray-700">Phone Number</label>
                    <input type="text" name="phoneNumber" id="phoneNumber"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('phoneNumber')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="middleName" class="block text-blue-gray-700">Middle Name</label>
                    <input type="text" name="middleName" id="middleName"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="nationalId" class="block text-blue-gray-700">National ID Card</label>
                    <input type="file" name="nationalId" id="nationalId"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('nationalId')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="maritalStatus" class="block text-blue-gray-700">Marrital Status</label>
                    <select id="maritalStatus" name="maritalStatus"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                    </select>
                    @error('maritalStatus')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="dateOfBirth" class="block text-blue-gray-700">Date Of Birth</label>
                    <input type="date" name="dateOfBirth" id="dateOfBirth"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('dateOfBirth')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="currentAddress" class="block text-blue-gray-700">Current Address</label>
                    <input type="text" name="currentAddress" id="currentAddress"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('currentAddress')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-blue-gray-700">Gender</label>
                    <select id="gender" name="gender"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @error('gender')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="medicalCertificate" class="block text-blue-gray-700">Medical Certificate</label>
                    <input type="file" id="medicalCertificate" name="medicalCertificate"
                        class= "w-full px-3 py-2 border border-blue-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-100 focus:border-blue-500">
                    @error('medicalCertificate')
                        <div class=" text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-700">Save</button>
                </div>
            </form>

        </div>
    </div>
@endsection
