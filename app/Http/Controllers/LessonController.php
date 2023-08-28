<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\TeacherLessons;

class LessonController extends Controller
{
    public function index(Request $request, $templateId) {
        $lessons = Lesson::where('template_id', $templateId)->with('teacher')->get();

        return response()->json($lessons, 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'template_id' => ['required'],
            'name' => ['required'],
            'teacher' => ['required']
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $lesson = Lesson::create([
            'template_id' => $validated['template_id'],
            'name' => $validated['name'],
            'teacher_id' => $validated['teacher']['id']
        ]);
    

        return response()->json([
            'data' => [
                'id' => $lesson['id']
            ]
        ],201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();

        $lesson = Lesson::where('id', $id)->update([
            'name' => $request['name'],
            'teacher_id' => $request['teacher']['id']
        ]);

    }

    public function show(Request $request, $id) {
        $lesson = Lesson::with('teacher')->find($id);

        return response()->json($lesson, 200);
    }

    public function delete($id){
        $lesson = Lesson::where('id', $id)->delete();

        $teqcherLesson = TeacherLessons::where('lesson_id', $id)->delete();

        return response()->json([
            'data' => [
                $lesson
            ]
        ], 200);
    }  
}
