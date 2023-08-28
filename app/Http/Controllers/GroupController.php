<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;
use App\Models\Table;
use App\Models\Call;
use App\Models\Template;

class GroupController extends Controller
{
    public function index(Request $request, $templateId) {
        $group = Group::where('template_id', $templateId)->get();

        return response()->json([
            'data' => $group
        ], 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'template_id' => ['required'],
            'name' => ['required'],
            'number_of_students' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $group = Group::create($validated);

        $calls = Call::where('template_id',  $validated['template_id'])->get();
        $template = Template::find($validated['template_id']);

        for ($i=0; $i < $template['days']; $i++) { 
            for ($j=0; $j < $template['lessons']; $j++) { 
                Table::create([
                    'call_id' => $calls[$j]['id'],
                    'class_id' => $group['id'],
                    'day_id' => $i + 1,
                    'template_id' => $validated['template_id']
                ]);
            }
        }

        return response()->json([
            'data' => [
                'id' => $group['id']
            ]
        ],201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();

        Group::where('id', $id)->update($data);
    }

    public function show(Request $request, $id) {
        $group = Group::find($id);

        return response()->json([
            'data' => $group
        ], 200);
    }

    public function delete($id){
        $group = Group::where('id', $id)->delete();
        $table = Table::where('class_id', $id)->delete();

        return response()->json([
            'data' => [
                $group
            ]
        ], 200);
    }  
}
