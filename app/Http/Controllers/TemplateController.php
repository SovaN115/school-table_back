<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Call;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function index(Request $request) {
        $template = Template::all();

        return response()->json([
            'data' => $template
        ], 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'days' => ['required'],
            'name' => ['required'],
            'lessons' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $template = Template::create($validated);

        for ($i=0; $i < $validated['lessons']; $i++) { 
            Call::create(['template_id' => $template['id'], 'lesson_number' => $i+1]);
        }

        return response()->json([
            'data' => [
                'id' => $template['id']
            ]
        ],201);
    }

    public function apply(Request $request, $id) {
        Template::where('is_selected', 1)->update([
            'is_selected' => null
        ]);
        Template::where('id', $id)->update([
            'is_selected' => 1
        ]);
    }

    public function show(Request $request, $id) {
        $template = Template::find($id);

        return response()->json([
            'data' => $template
        ], 200);
    }

    public function getSelected(Request $request) {
        $template = Template::where('is_selected', 1)->get();

        return response()->json([
            'data' => [
                'id' => $template[0]['id'],
                'days' => $template[0]['days'],
                'is_selected' => $template[0]['is_selected'],
                'lessons' => $template[0]['lessons']
            ]
        ], 200);
    }

    public function delete($id){
        $template = Template::where('id', $id)->delete();

        return response()->json([
            'data' => [
                $template
            ]
        ], 200);
    }  
}
