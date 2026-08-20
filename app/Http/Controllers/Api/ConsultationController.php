<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Doctor;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //show all consultations for patient
    {
        $patient = auth()->user()->patient;
        if (!$patient) {
            return response()->json(['success' => false, 'message' => "المستخدم غير مسجل كمريض"], 422);
        }

        $consultations = Consultation::where('patient_id', $patient->id)
            ->with(['doctor.user', 'doctor.department'])->latest()
            ->get();

        return response()->json([
            "success" => true,
            'consultations' => $consultations,
        ]);
    }


    public function store(Request $request, $doctor_id) //create message
    {
        $request->validate([
            'message' => 'required|string',

        ]);
        $doctor = Doctor::find($doctor_id);
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => "الطبيب غير موجود"
            ], 404);
        }
        $patient = auth()->user()->patient;
        if (!$patient) {
            return response()->json(['success' => false, 'message' => "المستخدم غير مسجل كمريض"], 422);
        }

        $consultation = Consultation::create([
            'message' => $request->message,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'doctor_reply' => null,
            'status' => 'open',
        ]);

        $consultation->load(['doctor.user', 'doctor.department']);

        return response()->json([
            "success" => true,
            'message' => 'تم ارسال الاستشارة بنجاح',
            'consultation' => $consultation,
        ], 201);
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
