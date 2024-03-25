<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'student_id' => 'required|string',
            'phone' => 'required|string',
            'ip' => 'required|ip',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'area' => 'required|string|max:1',
            'row' => 'required|integer',
            'no' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        Student::create($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Student::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => 'email',
            'student_id' => 'string',
            'phone' => 'string',
            'ip' => 'ip',
            'check_in' => 'date',
            'check_out' => 'date',
            'area' => 'string|max:1',
            'row' => 'integer',
            'no' => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        $student = Student::find($id);
        $student->update($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::destroy($id);
        return response()->json(['message' => 'OK']);
    }
}
