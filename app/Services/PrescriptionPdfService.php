<?php

namespace App\Services;

use App\Models\DoctorProfile;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

/** Creates and privately stores a final digital-prescription PDF once. */
class PrescriptionPdfService
{
    public function ensureGenerated(Prescription $prescription): string
    {
        if ($prescription->generated_pdf_path && Storage::disk('local')->exists($prescription->generated_pdf_path)) {
            return $prescription->generated_pdf_path;
        }

        abort_unless(class_exists(Pdf::class), 503, 'PDF generation is not installed yet. Run: composer require barryvdh/laravel-dompdf:^3.1');
        abort_unless($prescription->type === 'digital' && $prescription->status === 'published', 422, 'Only published digital prescriptions can be converted to PDF.');

        $prescription->loadMissing(['author', 'appointment.chamber', 'items', 'patient']);
        $doctorProfile = DoctorProfile::query()->where('is_visible', true)->first();
        $pdf = Pdf::loadView('patient.prescriptions.pdf', [
            'prescription' => $prescription,
            'doctorProfile' => $doctorProfile,
            'patient' => $prescription->patient,
        ])->setPaper('a4', 'portrait')->setOptions([
            'isRemoteEnabled' => false,
            'isPhpEnabled' => false,
            'defaultFont' => 'DejaVu Sans',
        ]);

        $path = 'private/prescriptions/generated/' . $prescription->reference . '.pdf';
        Storage::disk('local')->put($path, $pdf->output());
        $prescription->forceFill([
            'generated_pdf_path' => $path,
            'generated_pdf_generated_at' => now(),
        ])->save();

        return $path;
    }
}
