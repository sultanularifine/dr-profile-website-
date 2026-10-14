<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PatientMedicalDocument extends Model {
 protected $fillable=['patient_id','appointment_id','uploaded_by','title','document_type','private_file_path','original_filename','mime_type','file_size','notes'];
 public function patient(){return $this->belongsTo(User::class,'patient_id');}
 public function appointment(){return $this->belongsTo(Appointment::class);}
 public function uploader(){return $this->belongsTo(User::class,'uploaded_by');}
}
