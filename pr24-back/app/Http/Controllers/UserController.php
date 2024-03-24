<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'account' => 'required',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        $data['password'] = bcrypt($data['password']);
        $data['ip'] = $request->ip();
        User::create($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'string',
            'account' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        User::find($id)->update($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return response()->json(['message' => 'OK']);
    }

    // Reset password
    public function resetPassword(Request $request, string $id)
    {
        $data = $request->validate([
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }
        $data['password'] = bcrypt($data['password']);
        User::find($id)->update($data);
        return response()->json(['message' => 'OK']);
    }
}
