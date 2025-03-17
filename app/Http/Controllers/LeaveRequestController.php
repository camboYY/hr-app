<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveApproveRequestForm;
use App\Http\Requests\LeaveRequestForm;
use App\Http\Requests\LeaveUpdateRequestForm;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\LeaveStatus;
use Date;
use DB;
use Illuminate\Http\Request;
use Validator;

class LeaveRequestController extends Controller
{
     public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fromDate' => 'nullable|date|date_format:Y-m-d',
            'toDate' => 'nullable|date|date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $query = EmployeeLeave::query();

        if($request->has("fromDate")){
            $query->whereDate('fromDate','>=',$fromDate);
        }

         if($request->has("toDate")){
            $query->orWhereDate('toDate','<=',$toDate);
        }

        if( $request->has('query') ) {
            $query->orWhere('reason','like','%'.$request->get('query').'%');
        }
        
        $leaveRequests = $query->with(["leaveStatus", "leaveTypeSetting", "relief"])->paginate(perPage: 10);

        return response()->json($leaveRequests);
    }

    public function request(LeaveRequestForm $leaveRequestForm)
    {
        DB::beginTransaction();
        try{
            $leaveRequestForm->validated();
            $employee_id = Auth()->id();
            $employees = Employee::select("line_manager_id")->where("id", $employee_id)->get();
            if(!isset($employees)) {
                return response()->json(['error' => 'You are not authorized to make leave request'], 403);
            }
            $leaveStatus = new LeaveStatus();
            $leaveStatus->status = "PENDING";
            $leaveStatus->date = Date::now()->toIso8601String();
            $leaveStatus->save();
            $leaveRequest = new EmployeeLeave();
            $leaveRequest->leave_status_id = $leaveStatus->id;
            $leaveRequest->employee_id = Auth()->id();
            $leaveRequest->fromDate = $leaveRequestForm->fromDate;
            $leaveRequest->toDate = $leaveRequestForm->toDate;
            $leaveRequest->leave_type_setting_id = $leaveRequestForm->leave_type_setting_id;
            $leaveRequest->leave_option = $leaveRequestForm->leave_option;
            $leaveRequest->approver_id = $employees[0]->line_manager_id;
            $leaveRequest->relief_id = $leaveRequestForm->relief_id;
            $leaveRequest->reason = $leaveRequestForm->reason;
            $leaveRequest->save();
            return response()->json($leaveRequest,200);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        } finally {
            DB::commit();
        }
    }

    public function searchEmployee(Request $request) 
    {
        $query = Employee::query();
        $search = $request->get('search') ;
        if($search){
            $query->where("firstName","like","%". $search ."%");
            $query->orWhere("lastName","like","%". $search ."%");
        }

        $employees = $query->get();
        return response()->json($employees);
    }

    public function update(LeaveUpdateRequestForm $request, int $id)
    {
        try {
            $request->validated();
            $leaveRequest = EmployeeLeave::find($id);
            if (!$leaveRequest) {
                return response()->json(['error' => 'Leave request not found'], 404);
            }
            if($request->has("leave_type_setting_id")) {
                $leaveRequest->leave_type_setting_id = $request->leave_type_setting_id;
            }
            if($request->has("leave_option")) {
                $leaveRequest->leave_option = $request->leave_option;
            }
            if($request->has("relief_id")) {
                $leaveRequest->relief_id = $request->relief_id;
            }
            if($request->has("reason")) {
                $leaveRequest->reason = $request->reason;
            }
            if($request->has("fromDate")) {
                $leaveRequest->fromDate = $request->fromDate;
            }
            if($request->has("toDate")) {
                $leaveRequest->toDate = $request->toDate;
            }

            $leaveRequest->save();
            return response()->json($leaveRequest, 200);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function approveRequest(LeaveApproveRequestForm $request, int $id)
    {
        $request->validated();
        $leaveRequest = EmployeeLeave::findOrFail($id);
        if (!$leaveRequest) {
            return response()->json(['error' => 'Leave request not found'], 404);
        }
        $leaveStatus = LeaveStatus::findOrFail($leaveRequest->leave_status_id);
        $leaveStatus->status = $request->leave_status;
        $leaveStatus->date = Date::now()->toIso8601String();
        if($request->has("comment")) {
            $leaveStatus->reason = $request->comment;
        }
        $leaveStatus->save();
        return response()->json(null, 200);
    }
}
