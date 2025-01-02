<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $query = Employee::query();
        if ($request->has("query")) {
            $query = $query->where("firstName","like","%". $request->get("query") ."%");
            $query = $query->orWhere("lastName","like","%". $request->get("query") ."%");
        }
        $employees = $query->paginate(10);
        return response()->json($employees);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        return response()->json(Employee::create($request->all()),201);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return response()->json(Employee::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->firstName = $request->get("first_name");
        $employee->lastName = $request->get("last_name");
        $employee->email = $request->get("email");
        $employee->phoneNumber = $request->get("phone");
        $employee->currentAddress = $request->get("current_address");
        if( $request->hasFile("national_id") ) {
           $employee->nationalId = Storage::disk()->put("public", $request->get("national_id"));
        }
        $employee->marriageStatus = $request->get("marriage_status");
        $employee->dateOfBirth = $request->get("date_of_birth");
        $employee->gender = $request->get("gender");
        if( $request->hasFile("medical_certificate") ) {
            $employee->medicalCertificate = Storage::disk()->put("public", $request->get("medical_certificate")) ;
        }
        return response()->json($employee,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(null,200);
    }
}
