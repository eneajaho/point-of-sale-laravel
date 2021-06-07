<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{

    public function index()
    {
        $shifts = Shift::all();
        return response()->json($shifts);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $shift = Shift::create($data);
        return response()->json($shift, 201);
    }

    public function show(Shift $shift)
    {
        return response()->json($shift);
    }

    public function update(Request $request, Shift $shift)
    {
        $shift->update($request->all());
        $shift->save();
        return response()->json($shift);
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return response()->json($shift);
    }
}
