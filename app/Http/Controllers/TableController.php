<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Call;
use App\Models\Cabinet;
use App\Models\Day;

class TableController extends Controller
{
    public function index(Request $request, $templateId) {
        $sections = Table::where('template_id', $templateId)->get();
        $groups = Group::where('template_id', $templateId)->get();
        $lessons = Lesson::with('teacher')->where('lessons.template_id', $templateId)->get();
        $calls = Call::where('template_id', $templateId)->get();
        $teachers = Teacher::where('template_id', $templateId)->get();
        $cabinets = Cabinet::where('template_id', $templateId)->get();
        $days = Day::all();

        $data = [];

        for ($i=0; $i < count($sections); $i++) { 
            $class = [];
            $day = [];
            $section = [];
            $lesson = [];
            $cabinet = [];
            $teacher = [];
            $call = [];
            $day = [];

            $table = [];

            for ($j=0; $j < count($groups); $j++) { 
                if($sections[$i]['class_id'] == $groups[$j]['id']){
                    $class = $groups[$j];
                }
            }

            for ($j=0; $j < count($lessons); $j++) { 
                if($sections[$i]['lesson_id'] == $lessons[$j]['id']){
                    $lesson = $lessons[$j];
                }
            }

            for ($j=0; $j < count($calls); $j++) { 
                if($sections[$i]['call_id'] == $calls[$j]['id']){
                    $call = $calls[$j];
                }
            }

            for ($j=0; $j < count($teachers); $j++) { 
                if($sections[$i]['teacher_id'] == $teachers[$j]['id']){
                    $teacher = $teachers[$j];
                }
            }

            for ($j=0; $j < count($cabinets); $j++) { 
                if($sections[$i]['cabinet_id'] == $cabinets[$j]['id']){
                    $cabinet = $cabinets[$j];
                }
            }

            for ($j=0; $j < count($days); $j++) { 
                if($sections[$i]['day_id'] == $days[$j]['id']){
                    $day = $days[$j];
                }
            }

            

            $section['cabinet'] = $cabinet;
            $section['teacher'] = $teacher;
            $section['lesson'] = $lesson;
            $section['call'] = $call;
            $section['section_id'] = $sections[$i]['id'];

            $table['class'] = $class;
            $table['day'] = $day;
            $table['section'] = $section;
            $data[] = $table;
        }

        if(!isset($sections[0])) {
            return ;
        }

        $rowsData = [
            [
                'class' => $data[0]['class'],
                'day' => $data[0]['day'],
                'sections' => [
                    $data[0]['section']
                ]
            ],
        ];

        for ($i=1; $i < count($data); $i++) { 
            $len = count($rowsData);
            for ($j=0; $j < $len; $j++) { 

                if($rowsData[$j]['class']['id'] == $data[$i]['class']['id'] && $rowsData[$j]['day']['id'] == $data[$i]['day']['id']) {
                    $rowsData[$j]['sections'][] =  $data[$i]['section'];
                    break;
                }

                if($j == count($rowsData) - 1){
                    $rowsData[] = [
                        'class' => $data[$i]['class'],
                        'day' => $data[$i]['day'],
                        'sections' => [
                            $data[$i]['section']
                        ]

                    ];
                }

            }
        }

        return response()->json([
            'data' => $rowsData,

        ], 200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'template_id' => ['required'],
            'day_id' => ['required'],
            'call_id' => ['required'],
            'lesson_id' => ['required'],
            'class_id' => ['required'],
            'cabinet_id' => ['required'],
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->all();
            return response()->json([
                'errors' => $errors
            ],403);
        }

        $validated = $validator->validated();

        $table = Table::create($validated);

        return response()->json([
            'data' => [
                'id' => $table['id']
            ]
        ],201);
    }

    public function update(Request $request, $id) {

        Table::where('id', $id)->update($request->all());
    }

    public function show(Request $request, $id) {
        $table = Table::find($id);

        return response()->json([
            'data' => $table
        ], 200);
    }
    public function delete($id) {
        $table = Table::where('id', $id)->update([
            'lesson_id' => null,
            'cabinet_id' => null,
            'teacher_id' => null
        ]);
    }

}
