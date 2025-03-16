<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestForm;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
     public function index(Request $request)
    {
        $fromDate = Carbon::parse($request->fromDate);
        $toDate = Carbon::parse($request->toDate);

        $query = EmployeeLeave::query();

        if($request->has("fromDate")){
            $query->whereDate('fromDate','>=',$fromDate->format('m-d-y'));
        }

         if($request->has("toDate")){
            $query->whereDate('toDate','<=',$toDate->format('m-d-y'));
        }

        if( $request->has('query') ) {
            $query->where('reason','like','%'.$request->get('query').'%');
        }
        
        $leaveRequests = $query->paginate(perPage: 10);

        return response()->json(compact('leaveRequests'),200);
    }

    public function request(LeaveRequestForm $leaveRequestForm)
    {
        $inputs = $leaveRequestForm->validated();
        $employee_id = Auth()->id();
        $approver_id = Employee::select("id")->where("id", $employee_id)->get();

        dd($approver_id);
        return response()->json(compact('inputs'),200);
    }
}
