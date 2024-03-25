<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    // middleware
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Seat::all();
    }

    public function getSeatByOrder()
    {
        return Seat::orderBy('area')->orderBy('row')->orderBy('no')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'area' => 'required|string|max:1',
            'row' => 'required|integer',
            'no' => 'required|integer',
            'priority' => 'integer',
            'is_occupied' => 'boolean',
            'is_reserved' => 'boolean',
        ]);
        if (!$data) {
            return response()->json(['message' => 'Error'], 200);
        }
        Seat::create($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Seat::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'area' => 'string|max:1',
            'row' => 'integer',
            'no' => 'integer',
            'priority' => 'integer',
            'is_occupied' => 'boolean',
            'is_reserved' => 'boolean',
        ]);
        if (!$data) {
            return response()->json(['message' => 'Error'], 200);
        }
        Seat::find($id)->update($data);
        return response()->json(['message' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Seat::destroy($id);
        return response()->json(['message' => 'OK']);
    }
}
