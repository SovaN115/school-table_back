<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request, $templateId) {
        $teacher = Teacher::where('template_id', $templateId)->get();

        return response()->json($teacher, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'template_id' => ['required'],
            'name' => ['required'],
            'surname' => ['required'],
            'patronymic' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $teacher = Teacher::create($validated);

        return response()->json([
            'data' => [
                'id' => $teacher['id']
            ]
        ],201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();

        Teacher::where('id', $id)->update($data);
    }

    public function show(Request $request, $id) {
        $teacher = Teacher::find($id);

        return response()->json([
            'data' => $teacher
        ], 200);
    }

    public function delete($id){
        $teacher = Teacher::where('id', $id)->delete();

        return response()->json([
            'data' => [
                $teacher
            ]
        ], 200);
    }  
}
