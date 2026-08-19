<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json([
            'status' => true,
            'data' => $doctors
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['status' => false, 'message' => 'الطبيب غير موجود'], 404);
        }

        return response()->json(['status' => true, 'data' => $doctor], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getDoctorByDepartment($department_id)
    {

        $doctors = Doctor::where('department_id', $department_id)->with('user')->get();

        if ($doctors->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'لا يوجد أطباء في هذا القسم'], 404);
        }

        return response()->json([
            'doctors' => $doctors->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->user->name,

                ];
            })
        ]);
    }
}
