<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalFormRequest;
use App\Models\EmployeeGoal;
use App\Models\Goal;
use App\Models\Track;
use DB;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->get('per_page',10);
        $query = Goal::query();
        if( $request->has('query') ) {
            $query->where('title','like','%'.$request->get('query').'%');
            $query->orWhere('description','like','%'.$request->get('query').'%');
        }
        $goals = $query->paginate($per_page);
        return response()->json($goals);
    }
    public function store(GoalFormRequest $request)
    {

        $request->validated();

        DB::beginTransaction();
        try {
            $goal = new Goal();
            $goal->title = $request->get('title');
            $goal->start_date = $request->get('start_date');
            $goal->end_date = $request->get('end_date');
            $goal->description = $request->get('description');
            $goal->comment = $request->get('comment');
            $goal->status = $request->get('status');
            $goal->weight = $request->get('weight');
            $goal->save();

            $track = new Track();
            $track->goal_id = $goal->id;
            $track->track_by = $request->get('track_by');
            $track->meet_target_amount = $request->get('meet_target_amount');
            $track->exceed_target_amount = $request->get('exceed_target_amount');
            $track->actual_archievement_amount = $request->get('actual_archievement_amount');
            $track->reviewed_by_id = $request->get('reviewed_by');
            $track->save();

            $employeeGoal = new EmployeeGoal();
            $employeeGoal->employee_id = auth()->id();
            $employeeGoal->goal_id = $goal->id;
            $employeeGoal->category_id = $request->get('category_id');
            $employeeGoal->assigned_date = $request->get('assigned_date');
            $employeeGoal->complete_date = $request->get('complete_date');
            $employeeGoal->progress = $request->get('progress');
            $employeeGoal->save();

            return response()->json($goal,201);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        } finally {
            DB::commit();
        }
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'title' => ['nullable','string','max:255'],
           'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after:start_date'],
            'description' => ['nullable','string','max:255'],
           'status' => ['required','in:active,inactive,pending,completed,progessing'],
        ]);
        if($request->has('status'))
        {
            $goal->status = $request->status;
        }
        if($request->has('title'))
        {
            $goal->title = $request->title;
        }
        if($request->has('start_date'))
        {
            $goal->start_date = $request->start_date;
        }
        if($request->has('end_date'))
        {
            $goal->end_date = $request->end_date;
        }
        if($request->has('description'))
        {
            $goal->description = $request->description;
        }
        $goal->save();

        return response()->json($goal,200);
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();
        return response()->json(null,200);
    }
}
