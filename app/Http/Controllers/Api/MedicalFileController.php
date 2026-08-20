<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalFile;

class MedicalFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = auth()->user()->patient;
        if (!$patient) {
            return response()->json(['message' => 'المستخدم غير مسجل كمريض'], 422);
        }

        $medicalFile = MedicalFile::where('patient_id', $patient->id)->with([
            'requestedBy.user',
            'requestedBy.department'
        ])->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $medicalFile
        ]);
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
        //
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
}
