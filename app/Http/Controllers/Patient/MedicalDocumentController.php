<?php
namespace App\Http\Controllers\Patient;
use App\Http\Controllers\Controller;
use App\Models\PatientMedicalDocument;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class MedicalDocumentController extends Controller {
 public function index(){ $documents=PatientMedicalDocument::where('patient_id',auth()->id())->latest()->paginate(20); return view('patient.documents.index',compact('documents')); }
 public function store(Request $request){ $data=$request->validate(['title'=>['required','string','max:255'],'document_type'=>['required','in:medical_report,lab_result,old_prescription,scan_or_image,other'],'appointment_id'=>['nullable','integer','exists:appointments,id'],'file'=>['required','file','mimes:jpg,jpeg,png,webp,pdf','max:10240'],'notes'=>['nullable','string','max:2000']]); if(!empty($data['appointment_id'])) abort_unless(Appointment::whereKey($data['appointment_id'])->where('patient_id',auth()->id())->exists(),404); $file=$request->file('file'); $path=$file->store('private/patient-medical-documents','local'); PatientMedicalDocument::create(['patient_id'=>auth()->id(),'appointment_id'=>$data['appointment_id']??null,'uploaded_by'=>auth()->id(),'title'=>$data['title'],'document_type'=>$data['document_type'],'private_file_path'=>$path,'original_filename'=>$this->safeName($file->getClientOriginalName()),'mime_type'=>$file->getMimeType(),'file_size'=>$file->getSize(),'notes'=>$data['notes']??null]); return redirect()->route('patient.documents.index')->with('success','Medical document uploaded securely. Your doctor can view it from the admin document list.'); }
 public function download(PatientMedicalDocument $document){ abort_unless((int)$document->patient_id===(int)auth()->id(),404); abort_unless(Storage::disk('local')->exists($document->private_file_path),404); return Storage::disk('local')->download($document->private_file_path,$document->original_filename); }
 private function safeName(string $name):string{$ext=preg_replace('/[^A-Za-z0-9]+/','',pathinfo($name,PATHINFO_EXTENSION))?:'bin';$base=preg_replace('/[^A-Za-z0-9._-]+/','-',pathinfo(str_replace('\\','/',$name),PATHINFO_FILENAME))?:'medical-file';return substr(trim($base,'.-_'),0,100).'.'.strtolower($ext);}
}
