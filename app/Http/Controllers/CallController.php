<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;

class CallController extends Controller
{
    public function index(Request $request, $templateId) {
        $call = Call::where('template_id', $templateId)->get();

        return response()->json([
            'data' => $call
        ], 200);
    }

    public function create(Request $request) {

        $call = Call::create($request->all());

        return response()->json([
            'data' => [
                'id' => $call['id']
            ]
        ],201);
    }

    public function update(Request $request, $id) {
        $data = $request->all();

        Call::where('id', $id)->update($data);

        return response()->json([
            'data' => [
                'id' => $data
            ]
        ],201);
    }

    public function show(Request $request, $id) {
        $group = Call::find($id);

        return response()->json([
            'data' => $group
        ], 200);
    }

    public function delete($id){
        $group = Call::where('id', $id)->delete();

        return response()->json([
            'data' => [
                $group
            ]
        ], 200);
    }  
}
