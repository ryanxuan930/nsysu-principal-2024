<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
            'student_no' => 'required|string',
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
            'student_no' => 'string',
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

    /**
     * Login
     */

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'student_no' => 'required',
        ]);
        $student = Student::where('email', $data['email'])->where('student_no', $data['student_no'])->first();
        if (!$student) {
            return response()->json(['message' => 'Email或學號錯誤'], 200);
        }
        $payload = [];
        $payload['student_id'] = $student->student_id;
        $payload['student_no'] = $student->student_no;
        $encryptedValue = Crypt::encryptString(json_encode($payload));
        return response()->json(['message' => 'OK', 'student' => $student, 'payload' => $encryptedValue], 200);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $data = $request->validate([
            'email' => 'required',
            'student_no' => 'required',
        ]);
        $student = Student::where('email', $data['email'])->where('student_no', $data['student_no'])->first();
        if (!$student) {
            return response()->json(['message' => 'Email或學號錯誤'], 200);
        }
        $student->update(['check_out' => now()]);
        return response()->json(['message' => 'OK']);
    }
}
