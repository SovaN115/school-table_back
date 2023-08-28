<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cabinet;

class CabinetController extends Controller
{
    public function index(Request $request, $templateId) {
        $cabinets = Cabinet::where('template_id', $templateId)->get();

        return response()->json([
            'data' => $cabinets
        ], 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'template_id' => ['required'],
            'room' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $cabinet = Cabinet::create($validated);

        return response()->json([
            'data' => [
                'id' => $cabinet['id']
            ]
        ],201);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'template_id' => ['required'],
            'room' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        Cabinet::where('id', $id)->update($validated);
    }

    public function show(Request $request, $id) {
        $cabinet = Cabinet::find($id);

        return response()->json([
            'data' => $cabinet
        ], 200);
    }

    public function delete($id){
        $cabinet = Cabinet::where('id', $id)->delete();

        return response()->json([
            'data' => [
                $cabinet
            ]
        ], 200);
    }  
}
