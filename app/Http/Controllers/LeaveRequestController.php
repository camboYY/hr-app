<?php

namespace App\Http\Controllers;

use App\Http\Dto\LeaveDto;
use App\Http\Requests\LeaveApproveRequestForm;
use App\Http\Requests\LeaveRequestForm;
use App\Http\Requests\LeaveUpdateRequestForm;
use App\Mail\LeaveConfirmation;
use App\Mail\SendMailForLeave;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use App\Models\LeaveStatus;
use Date;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class LeaveRequestController extends Controller
{
     public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);  // Default to 10 items per page
        $search = $request->get('search', "");
        $offset = $request->get('page',0);
        $fromDate = $request->get("fromDate");
        $toDate = $request->get("toDate");
        $userId = auth()->id();

        $validator = Validator::make($request->all(), [
            'fromDate' => 'nullable|date|date_format:Y-m-d',
            'toDate' => 'nullable|date|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $query = "
            SELECT empleave.id,
                CONCAT(emp.firstName, ' ', emp.lastName) AS staffName,  
                empleave.fromDate,
                empleave.toDate, 
                empleave.leave_option, 
                empleave.reason, 
                lts.leave_type,
                lts.leave_balance, 
                CONCAT(e.firstName, ' ', e.lastName) AS reliefName,
                ls.status 
            FROM employees AS emp
            INNER JOIN employee_leaves AS empleave ON emp.id = empleave.employee_id
            INNER JOIN leave_type_settings AS lts ON lts.id = empleave.leave_type_setting_id
            INNER JOIN employees AS e ON empleave.relief_id = e.id 
            INNER JOIN leave_statuses AS ls ON ls.id = empleave.leave_status_id
            WHERE emp.user_id = ? ";
        $bindings[] = $userId;

        if($fromDate){
            $query.= " AND empleave.fromDate >=? ";
            $bindings[] = $fromDate;
        }
        if($toDate){
            $query.= " AND empleave.toDate <=? ";
            $bindings[] = $toDate;
        }

        if($search){
            $query.= " AND (emp.firstName LIKE? OR emp.lastName LIKE?) ";
            $bindings[] = "%$search%";
            $bindings[] = "%$search%";
        }
        $query.= "LIMIT ? OFFSET ?";
        $bindings[] = $perPage;
        $bindings[] = $offset;
        $leaveRequests = DB::select($query, $bindings);
        $totalRecords = DB::select("SELECT count(*) as totalRecords FROM employee_leaves;");
        return response()->json(["data"=>$leaveRequests,"total"=> $totalRecords]); //
    }

    public function request(LeaveRequestForm $leaveRequestForm)
    {
        DB::beginTransaction();
        try{
            $leaveRequestForm->validated();
            $user_id = Auth()->id();
            $employee = Employee::select("line_manager_id","id")->where("user_id", $user_id)->first();
            if(!isset($employee)) {
                return response()->json(['error' => 'You are not authorized to make leave request'], 403);
            }
            $leaveStatus = new LeaveStatus();
            $leaveStatus->status = "PENDING";
            $leaveStatus->date = Date::now()->toIso8601String();
            $leaveStatus->save();
            $leaveRequest = new EmployeeLeave();
            $leaveRequest->leave_status_id = $leaveStatus->id;
            $leaveRequest->employee_id = $employee->id;
            $leaveRequest->fromDate = $leaveRequestForm->fromDate;
            $leaveRequest->toDate = $leaveRequestForm->toDate;
            $leaveRequest->leave_type_setting_id = $leaveRequestForm->leave_type_setting_id;
            $leaveRequest->leave_option = $leaveRequestForm->leave_option;
            $leaveRequest->approver_id = $employee->line_manager_id;
            $leaveRequest->relief_id = $leaveRequestForm->relief_id;
            $leaveRequest->reason = $leaveRequestForm->reason;
            $leaveRequest->save();
            $leaveDto = new LeaveDto();
            $leaveDto->fromDate = $leaveRequestForm->fromDate;
            $leaveDto->toDate = $leaveRequestForm->toDate;
            $leaveDto->leave_type = $leaveRequest->leaveTypeSetting->leave_type;
            $leaveDto->leaveOption = $leaveRequestForm->leave_option;
            $leaveDto->subjectName = "Dear Staff,";
            Mail::to($leaveRequestForm->user())->send(new SendMailForLeave($leaveDto));

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

    public function canncelLeave(LeaveUpdateRequestForm $request, int $id)
    {
        try {
            $request->validated();
            $leave = EmployeeLeave::find($id);
            if (!$leave) {
                return response()->json(['error' => 'Leave request not found'], 404);
            }
            if($leave->leaveStatus->status != "PENDING") {
                return response()->json(['error' => 'Leave request can only be cancelled when it is in pending status'], 400);
            }
            $leave->leaveStatus()->update(['status' => $request->get('leave_status')]);

            $leave->save();
            return response()->json($leave, 200);
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

        $leaveDto = new LeaveDto();
        $leaveDto->leaveStatus = $request->leave_status;
        $leaveDto->subjectName = "Dear Everone,";
        
        Mail::to($request->user())->send(new LeaveConfirmation($leaveDto));


        return response()->json(null, 200);
    }

    public function edit($id)
    {
        $leaveRequest = EmployeeLeave::with(["leaveStatus", "leaveTypeSetting", "relief", "employee"])->findOrFail($id);
        return response()->json($leaveRequest);
    }
}
