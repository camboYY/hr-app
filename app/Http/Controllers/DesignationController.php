<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        $query = Designation::query();
        if( $request->has('query') ) {
            $query->where('name','like','%'.$request->get('query').'%');
        }
        $query->paginate(10);
        $designations = $query->get();

        return response()->json($designations);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'responsibilities' => 'nullable',
            'contract_id' => 'nullable',
        ]);

        $designation = new Designation();
        $designation->name = $request->name;
        $designation->responsibilities = $request->responsibilities;
        $designation->contract_id = $request->contract_id;
        $designation->save();

        return response()->json($designation, 201);
    }


    public function edit($id)   { 
        $designation = Designation::find($id);
        return response()->json($designation);
    }

    public function update(Request $request, $id) { 
        $request->validate([
            'name' => 'required',
            'responsibilities' => 'required',
            'contract_id' => 'nullable',
        ]);

        $designation = Designation::find($id);
        $designation->name = $request->name;
        $designation->responsibilities = $request->responsibilities;
        $designation->contract_id = $request->contract_id;
        $designation->save();

        return response()->json($designation,200);
    }

    public function destroy($id) { 
        $designation = Designation::find($id);
        $designation->delete();
        return response()->json(null,200);
    }

}