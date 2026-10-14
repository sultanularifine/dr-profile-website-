<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PatientMedicalDocument;
use Illuminate\Support\Facades\Storage;
class PatientMedicalDocumentController extends Controller {
 private function authorizeStaff(){abort_unless(auth()->user()?->hasAnyRole(['Super Admin','Doctor','Admin']),403);}
 public function index(){ $this->authorizeStaff(); $documents=PatientMedicalDocument::with(['patient','uploader','appointment'])->latest()->paginate(25); return view('backend.medical.documents.index',compact('documents')); }
 public function download(PatientMedicalDocument $document){$this->authorizeStaff();abort_unless(Storage::disk('local')->exists($document->private_file_path),404);return Storage::disk('local')->download($document->private_file_path,$document->original_filename);}
}
