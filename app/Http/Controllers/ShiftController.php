<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShiftsResource;
use App\Models\Shift;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $shifts = Shift::all();
        return response()->json($shifts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Display the specified resource.
     *
     * @param Shift $shift
     * @return JsonResponse
     */
    public function show(Shift $shift)
    {
        //dd($shift);
        return response()->json($shift, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Shift $shift
     * @return JsonResponse
     */
    public function update(Request $request, Shift $shift)
    {
        $shift->update($request->all());
        $shift->save();
        //dd($request);
        return response()->json($shift, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shift $shift
     * @return JsonResponse
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return response()->json($shift, 200);
    }
}
