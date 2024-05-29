<?php

namespace App\Models;

use App\Models\User;
use App\Models\DataSantri;
use App\Models\ListSekolah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendaftar extends Model
{
  use HasFactory;
  protected $table = 'data_pendaftars';

  protected $fillable = [
    'user_id',
    'nama',
    'tempat_lahir',
    'tanggal_lahir',    
    'jenis_kelamin',
    'sekolah_id',
    'nama_ayah',
    'nama_ibu',
    'alamat',
    'no_hp',
    'foto',
    'status',
    'bukti_pembayaran',
  ];



  public function daftarSekolah()
  {
    return $this->belongsTo(ListSekolah::class, 'sekolah_id');
  }
  // public function user()
  // {
  //   return $this->belongsTo(User::class);
  // }

  public function user()
  {
      return $this->belongsTo(User::class, 'user_id');
  }
  public function dataSantri()
  {
    return $this->hasOne(DataSantri::class);
  }
}
