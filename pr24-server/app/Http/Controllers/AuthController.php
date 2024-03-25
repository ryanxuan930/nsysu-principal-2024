<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $token = auth('user')->attempt($credentials);
        if(!$token)
        {
            return response()->json(['message' => '帳號或密碼錯誤'], 200);
        }

        $user = User::find(auth('user')->user()->user_id);
        //force to update user model cache 
        auth()->setUser($user);
        // Return the token along with the user info
        return response()->json(['message' => 'OK', 'user' => auth('user')->user(), 'token' => $token], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'OK'], 200);
    }

}
