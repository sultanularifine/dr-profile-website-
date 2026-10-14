<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Services\PrescriptionPdfService;
use Illuminate\Support\Facades\Storage;

class PrescriptionAccessController extends Controller
{
    private function ownedPublishedPrescription(Prescription $prescription): Prescription
    {
        abort_unless((int) $prescription->patient_id === (int) auth()->id() && $prescription->status === 'published', 404);
        return $prescription;
    }

    public function show(Prescription $prescription)
    {
        $prescription = $this->ownedPublishedPrescription($prescription);
        $prescription->load(['author', 'appointment.chamber', 'items']);
        return view('patient.prescriptions.show', compact('prescription'));
    }

    public function file(Prescription $prescription)
    {
        $prescription = $this->ownedPublishedPrescription($prescription);
        abort_unless($prescription->private_file_path && Storage::disk('local')->exists($prescription->private_file_path), 404);
        return Storage::disk('local')->download($prescription->private_file_path, $prescription->original_filename ?: 'prescription-file');
    }

    public function preview(Prescription $prescription)
    {
        $prescription = $this->ownedPublishedPrescription($prescription);
        abort_unless($prescription->private_file_path && Storage::disk('local')->exists($prescription->private_file_path), 404);
        $mime = strtolower((string) $prescription->mime_type);
        abort_unless(in_array($mime, ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'], true), 404);

        return response()->file(Storage::disk('local')->path($prescription->private_file_path), [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="prescription-preview"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store, max-age=0',
        ]);
    }

    public function pdf(Prescription $prescription, PrescriptionPdfService $pdfService)
    {
        $prescription = $this->ownedPublishedPrescription($prescription);
        abort_unless($prescription->type === 'digital', 422, 'Only a digitally written prescription has a generated prescription PDF. Download the original scan for a handwritten prescription.');
        $path = $pdfService->ensureGenerated($prescription);
        return Storage::disk('local')->download($path, $prescription->reference . '.pdf');
    }
}
