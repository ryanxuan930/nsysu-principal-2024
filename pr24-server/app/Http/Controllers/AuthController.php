<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\User;
use App\Models\Student;
use App\Models\Seat;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $token = Auth::attempt($credentials);
        if(!$token)
        {
            return response()->json(['message' => '帳號或密碼錯誤'], 200);
        }

        $user = User::find(auth()->user()->user_id);
        //force to update user model cache 
        auth()->setUser($user);
        // Return the token along with the user info
        return response()->json(['message' => 'OK', 'user' => auth()->user(), 'token' => $token], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'OK'], 200);
    }
    // qrcode
    public function decode(Request $request) 
    {
        $credentials = $request->validate([
            'payload' => 'required',
        ]);
        try {
            $content = Crypt::decryptString($credentials['payload']);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'error'], 200);
        }
        try {
            $payload = json_decode($content, true);
        } catch (Exception $e) {
            return response()->json(['message' => 'error'], 200);
        }
        if (!array_key_exists('student_id', $payload) || !array_key_exists('student_no', $payload)) {
            return response()->json(['message' => 'error'], 200);
        }
        // find user in Student
        $student = Student::where('student_id', $payload['student_id'])
            ->where('student_no', $payload['student_no'])
            ->first();
        if (!$student->check_in) {
            $student->check_in = now();
        }
        if (!$student->area) {
            $seat = Seat::where('is_occupied', 0)->where('is_reserved', 0)->orderBy('seat_id', 'asc')->first();
            $student->area = $seat->area;
            $student->row = $seat->row;
            $student->no = $seat->no;
            $seat->is_occupied = 1;
            $seat->save();
        }
        $student->save();
        return response()->json(['message' => 'OK', 'seat' => $seat, 'user' => $payload], 200);
    }
}
