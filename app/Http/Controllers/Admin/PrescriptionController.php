<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Services\PrescriptionPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PrescriptionController extends Controller
{
    private function authorizeMedicalStaff(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['Super Admin', 'Doctor']), 403);
    }

    public function index()
    {
        $this->authorizeMedicalStaff();
        $prescriptions = Prescription::with(['patient','author','appointment'])->latest()->paginate(20);
        return view('backend.medical.prescriptions.index', compact('prescriptions'));
    }

    public function create(Appointment $appointment)
    {
        $this->authorizeMedicalStaff();
        abort_unless(in_array($appointment->status, ['confirmed', 'waiting', 'in_progress', 'completed'], true), 422, 'A prescription can only be created for a confirmed, waiting, active or completed consultation.');
        $appointment->load('patient','chamber');
        return view('backend.medical.prescriptions.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $this->authorizeMedicalStaff();
        abort_unless(in_array($appointment->status, ['confirmed', 'waiting', 'in_progress', 'completed'], true), 422, 'A prescription can only be created for a confirmed, waiting, active or completed consultation.');
        $data = $request->validate([
            'type' => ['required', Rule::in(['digital','handwritten'])],
            'action' => ['required', Rule::in(['draft','publish'])],
            'title' => ['nullable','string','max:255'],
            'chief_complaints' => ['nullable','string','max:20000'],
            'examination_findings' => ['nullable','string','max:20000'],
            'diagnosis' => ['nullable','string','max:20000'],
            'investigation_advice' => ['nullable','string','max:20000'],
            'general_advice' => ['nullable','string','max:20000'],
            'follow_up_date' => ['nullable','date'],
            'medicines' => ['nullable','array','max:100'],
            'medicines.*.medicine_name' => ['nullable','string','max:255'],
            'medicines.*.strength' => ['nullable','string','max:100'],
            'medicines.*.dosage' => ['nullable','string','max:255'],
            'medicines.*.route' => ['nullable','string','max:100'],
            'medicines.*.frequency' => ['nullable','string','max:255'],
            'medicines.*.duration' => ['nullable','string','max:100'],
            'medicines.*.quantity' => ['nullable','string','max:100'],
            'medicines.*.instructions' => ['nullable','string','max:2000'],
            'handwritten_file' => ['required_if:type,handwritten','nullable','file','mimes:jpg,jpeg,png,webp,pdf','max:10240'],
        ]);

        abort_unless($appointment->patient_id, 422, 'Appointment has no patient.');
        if (($data['type'] ?? null) === 'digital' && ($data['action'] ?? null) === 'publish') {
            $this->assertDigitalPrescriptionHasClinicalContent($data);
        }

        $prescription = DB::transaction(function () use ($request, $appointment, $data) {
            $prescription = Prescription::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'author_id' => auth()->id(),
                'type' => $data['type'],
                'status' => $data['action'] === 'publish' ? 'published' : 'draft',
                'title' => $data['title'] ?? null,
                'chief_complaints' => $data['chief_complaints'] ?? null,
                'examination_findings' => $data['examination_findings'] ?? null,
                'diagnosis' => $data['diagnosis'] ?? null,
                'investigation_advice' => $data['investigation_advice'] ?? null,
                'general_advice' => $data['general_advice'] ?? null,
                'follow_up_date' => $data['follow_up_date'] ?? null,
                'published_at' => $data['action'] === 'publish' ? now() : null,
            ]);

            if ($data['type'] === 'handwritten' && $request->hasFile('handwritten_file')) {
                $file = $request->file('handwritten_file');
                $path = $file->store('private/prescriptions', 'local');
                $prescription->update([
                    'private_file_path' => $path,
                    'original_filename' => $this->safeDownloadFilename($file->getClientOriginalName(), $file->extension()),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }

            $allowedMedicineFields = ['medicine_name', 'strength', 'dosage', 'route', 'frequency', 'duration', 'quantity', 'instructions'];
            foreach (($data['medicines'] ?? []) as $index => $medicine) {
                if (trim((string) ($medicine['medicine_name'] ?? '')) === '') continue;
                $safeMedicine = array_intersect_key($medicine, array_flip($allowedMedicineFields));
                $prescription->items()->create(array_merge($safeMedicine, ['sort_order' => $index]));
            }

            return $prescription;
        });

        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription '.$prescription->reference.' saved as '.$prescription->status.'.');
    }

    public function publish(Prescription $prescription)
    {
        $this->authorizeMedicalStaff();
        abort_unless($prescription->status === 'draft', 422, 'Only a draft prescription can be published. Use a recorded correction/addendum workflow for an already published prescription.');
        if ($prescription->type === 'digital') {
            $prescription->loadMissing('items');
            $clinicalData = [
                'chief_complaints' => $prescription->chief_complaints,
                'examination_findings' => $prescription->examination_findings,
                'diagnosis' => $prescription->diagnosis,
                'investigation_advice' => $prescription->investigation_advice,
                'general_advice' => $prescription->general_advice,
            ];
            $hasContent = collect($clinicalData)->contains(fn ($value) => trim((string) $value) !== '')
                || $prescription->items->contains(fn ($item) => trim((string) $item->medicine_name) !== '');
            if (!$hasContent) {
                throw ValidationException::withMessages(['prescription' => 'Add clinical notes or at least one medicine before publishing a digital prescription.']);
            }
        }
        $prescription->update(['status' => 'published', 'published_at' => now()]);
        return back()->with('success', 'Prescription published to the patient dashboard.');
    }

    private function assertDigitalPrescriptionHasClinicalContent(array $data): void
    {
        $clinicalFields = ['chief_complaints', 'examination_findings', 'diagnosis', 'investigation_advice', 'general_advice'];
        foreach ($clinicalFields as $field) {
            if (trim((string) ($data[$field] ?? '')) !== '') {
                return;
            }
        }
        foreach (($data['medicines'] ?? []) as $medicine) {
            if (trim((string) ($medicine['medicine_name'] ?? '')) !== '') {
                return;
            }
        }
        throw ValidationException::withMessages(['prescription' => 'Add clinical notes or at least one medicine before publishing a digital prescription.']);
    }

    private function safeDownloadFilename(string $originalName, string $extension): string
    {
        $name = pathinfo(str_replace('\\', '/', $originalName), PATHINFO_FILENAME);
        $name = preg_replace('/[^A-Za-z0-9._-]+/', '-', $name) ?: 'prescription';
        $name = trim($name, '.-_');
        $extension = preg_replace('/[^A-Za-z0-9]+/', '', $extension) ?: 'bin';
        return ($name !== '' ? substr($name, 0, 100) : 'prescription') . '.' . strtolower($extension);
    }

    public function download(Prescription $prescription)
    {
        $this->authorizeMedicalStaff();
        abort_unless($prescription->private_file_path && Storage::disk('local')->exists($prescription->private_file_path), 404);
        return Storage::disk('local')->download($prescription->private_file_path, $prescription->original_filename ?: 'prescription-file');
    }

    public function pdf(Prescription $prescription, PrescriptionPdfService $pdfService)
    {
        $this->authorizeMedicalStaff();
        abort_unless($prescription->status === 'published' && $prescription->type === 'digital', 422, 'Only published digital prescriptions can be downloaded as a generated PDF.');
        $path = $pdfService->ensureGenerated($prescription);
        return Storage::disk('local')->download($path, $prescription->reference . '.pdf');
    }
}
