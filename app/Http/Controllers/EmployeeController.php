<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{

    public function updateImage(Request $request, $id){
        $employee = Employee::find($id);
        if( $request->hasFile("nationalId") ) {
            $photo = $request->file('nationalId');
            $url = Storage::disk('s3')->put("public", $photo);
            $employee->nationalId = Config::get('app.base_url')."/".Config::get("app.bucket_name")."/".$url;

        } else if($request->hasFile("medicalCertificate")) {
            $photo = $request->file("medicalCertificate");
            $url = Storage::disk('s3')->put("public", $photo);
            $employee->medicalCertificate = Config::get('app.base_url')."/".Config::get("app.bucket_name")."/".$url;
        
        }

        $employee->save();
        return response()->json($employee,200);
    }

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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->get("firstName") ." ".$request->get("lastName");
            $user->email = $request->get("email"); 
            $user->password = $request->get("password");
            $user->save();

            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->firstName = $request->get("firstName");
            $employee->lastName = $request->get("lastName");
            $employee->middleName = $request->get("middleName");
            $employee->phoneNumber = $request->get("phoneNumber");
            $employee->currentAddress = $request->get("currentAddress");
            $employee->designation_id = $request->get("designation_id");
            $employee->line_manager_id = $request->get("line_manager_id");
            
            if( $request->hasFile("nationalId") ) {
                $photo = $request->file('nationalId');
                $url = Storage::disk('s3')->put("public", $photo);
                $employee->nationalId = Config::get('app.base_url')."/".Config::get("app.bucket_name")."/".$url;

            }
            $employee->maritalStatus = $request->get("maritalStatus");
            $employee->dateOfBirth = $request->get("dateOfBirth");
            $employee->gender = $request->get("gender");

            if($request->hasFile("medicalCertificate")) {
                $photo = $request->file("medicalCertificate");
                $url = Storage::disk('s3')->put("public", $photo);
                $employee->medicalCertificate = Config::get('app.base_url')."/".Config::get("app.bucket_name")."/".$url;
            }
            $employee->save();

            return response()->json($employee,201);
        }catch(Exception $e) {
            DB::rollBack();            
        } finally {
            DB::commit();
        }
    }
    

    /**cd
     * Show the form for editing the specified resource.
     */
    public function view($id)
    {
        return response()->json(Employee::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
  
        $employee = Employee::findOrFail($id);
        $employee->firstName = $request->get("firstName");
        $employee->lastName = $request->get("lastName");
        $employee->middleName = $request->get("middleName");
        $employee->phoneNumber = $request->get("phoneNumber");
        $employee->currentAddress = $request->get("currentAddress");
        $employee->designation_id = $request->get("designation_id");
        $employee->line_manager_id = $request->get("line_manager_id");
        
        if( $request->hasFile("nationalId") ) {

            $photo = $request->file('nationalId');
            $url = Storage::disk('s3')->put("public", $photo);
            $employee->nationalId = Config::get('app.base_url')."/".Config::get("app.bucket_name")."/".$url;

        }
        $employee->maritalStatus = $request->get("maritalStatus");
        $employee->dateOfBirth = $request->get("dateOfBirth");
        $employee->gender = $request->get("gender");

        if($request->hasFile("medicalCertificate")) {
            $photo = $request->file("medicalCertificate");
            $url = Storage::disk('s3')->put("public", $photo);
            $employee->medicalCertificate = Config::get('app.base_url')."/".Config::get("app.bucket_name")."/".$url;
        }
        $employee->save();
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
