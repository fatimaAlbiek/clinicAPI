<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = auth()->user()->patient;
        $prescriptions = Prescription::with('appointment.doctor')->whereHas('appointment', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->get();

        return response()->json([
            'precreption' => $prescriptions
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
    public function show($id)
    {
        $patient = auth()->user()->patient;
        $prescription = Prescription::with('appointment')->whereHas('appointment', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->findOrFail($id);

        return response()->json([
            'prescription' => $prescription
        ]);
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
