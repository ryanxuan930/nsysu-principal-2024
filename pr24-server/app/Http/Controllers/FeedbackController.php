<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // middleware
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Feedback::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required',
            'identity' => 'required',
            'college' => 'required',
            'grade' => 'required',
            'q1_score' => 'required',
            'q1_comment' => 'required',
            'q2_score' => 'required',
            'q2_comment' => 'required',
            'q3_comment' => 'required',
            'q4_score' => 'required',
            'q4_comment' => 'required',
            'q5_comment' => 'required',
            'q6_comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        Feedback::create($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Feedback::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'student_id' => 'required',
            'identity' => 'required',
            'college' => 'required',
            'grade' => 'required',
            'q1_score' => 'required',
            'q1_comment' => 'required',
            'q2_score' => 'required',
            'q2_comment' => 'required',
            'q3_comment' => 'required',
            'q4_score' => 'required',
            'q4_comment' => 'required',
            'q5_comment' => 'required',
            'q6_comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        Feedback::find($id)->update($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Feedback::destroy($id);
        return response()->json(['message' => 'OK']);
    }

    public function getFeedbackByStudentId($student_id)
    {
        return Feedback::where('student_id', $student_id)->get();
    }
}
