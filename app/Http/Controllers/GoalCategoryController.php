<?php

namespace App\Http\Controllers;

use App\Models\GoalCategory;
use Illuminate\Http\Request;

class GoalCategoryController extends Controller
{
    public function index(Request $request) 
    {
        $per_page = $request->get('per_page',10);
        $search = $request->get('query', "");
        $query = GoalCategory::query();
        
        if(!empty($search))
        {
            $query = GoalCategory::where("category_name", "like", "%".$search."%");
        }
        $goal_categories = $query->paginate($per_page);
       return response()->json($goal_categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' =>'required|string|max:255',
            'category_description' => 'nullable|string|max:255',
        ]);

        $goal_category = GoalCategory::create($request->all());
        return response()->json($goal_category, 201);
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'category_name' =>'required|string|max:255',
                'category_description' => 'nullable|string|max:255',
            ]);

            $goal_category = GoalCategory::findOrFail($id);
            $goal_category->update($request->all());
            return response()->json($goal_category, 200);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function destroy(int $id)
    {
        $goal_category = GoalCategory::findOrFail($id);
        $goal_category->delete();
        return response()->json(null, 200);
    }
}
