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
            return response()->json([
                'message' => 'المستخدم غير مسجل كمريض'
            ], 422);
        }

        $medicalFiles = MedicalFile::where('patient_id', $patient->id)
            ->with([
                'requestedBy.user:id,name',
                'performedBy.user:id,name',
            ])
            ->latest()
            ->get();

        $medicalFiles = $medicalFiles->map(function ($file) {
            return [
                'id' => $file->id,
                'file_type' => $file->file_type,
                'file_url' => $file->file_url,
                'result' => $file->result,
                'status' => $file->status,
                'requested_by_name' => $file->requestedBy?->user?->name,
                'performed_by_name' => $file->performedBy?->user?->name,
                'created_at' => $file->created_at,
                'updated_at' => $file->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $medicalFiles
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
