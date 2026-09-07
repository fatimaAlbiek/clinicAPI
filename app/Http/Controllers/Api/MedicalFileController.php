<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MedicalFile;
use Illuminate\Support\Facades\Auth;

class MedicalFileController extends Controller
{
    /**
     * عرض الملفات الطبية الخاصة بالمريض
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
     * إنشاء طلب ملف طبي من قبل الطبيب
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'file_type' => 'required|in:Lab,Radiology',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'result' => 'nullable|string',
        ]);

        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return response()->json([
                'message' => 'المستخدم غير مسجل كطبيب'
            ], 422);
        }

        $fileUrl = null;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            $result = cloudinary()->uploadApi()->upload(
                $uploadedFile->getRealPath(),
                [
                    'folder' => 'clinic/medical_files',
                    'resource_type' => 'auto',
                ]
            );

            $fileUrl = $result['secure_url'];
        }

        $medicalFile = MedicalFile::create([
            'patient_id' => $request->patient_id,
            'requested_by' => $doctor->id,
            'performed_by' => null,
            'file_type' => $request->file_type,
            'file_url' => $fileUrl,
            'result' => $request->result,
            'status' => $fileUrl ? 'done' : 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medical file created successfully',
            'data' => $medicalFile
        ], 201);
    }
}
