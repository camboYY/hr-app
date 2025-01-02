<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::paginate(10);

        return response()->json(['departments'=>$departments],200);
    }

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();
        return response()->json($department,201);
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return response()->json(Department::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $department = Department::find($id);
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();
        return response()->json($department,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Department::destroy($id);
        return response()->json(null,status: 200);
    }
   
}
