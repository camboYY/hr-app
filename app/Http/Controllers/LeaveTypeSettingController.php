<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveTypeSettingFormRequest;
use App\Http\Requests\LeaveTypeSettingUpdateFormRequest;
use App\Models\LeaveTypeSetting;
use Illuminate\Http\Request;

class LeaveTypeSettingController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveTypeSetting::query();
        if( $request->has('query') ) {
            $query->where('leave_type','like','%'.$request->get('query').'%');
        }
        $leaveTypeSettings = $query->paginate(10);
        return response()->json($leaveTypeSettings);
    }
    public function store(LeaveTypeSettingFormRequest $request) 
    {
        try {
            $request->validated();

            $leaveTypeSetting = new LeaveTypeSetting();
            $leaveTypeSetting->leave_type = $request->leave_type;
            $leaveTypeSetting->leave_balance = $request->leave_balance;
            $leaveTypeSetting->save();
            return response()->json($leaveTypeSetting, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function update(LeaveTypeSettingUpdateFormRequest $request, int $id)
    {
        try {
            $leaveTypeSetting = LeaveTypeSetting::findOrFail($id);
            if($request->has("leave_type")) 
            {
                $leaveTypeSetting->leave_type = $request->leave_type;
            }
            if($request->has("leave_balance"))
            {
                $leaveTypeSetting->leave_balance = $request->leave_balance;
            }
            $leaveTypeSetting->save();
            return response()->json($leaveTypeSetting, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function destroy(int $id) 
    {
        try {
            LeaveTypeSetting::destroy($id);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
