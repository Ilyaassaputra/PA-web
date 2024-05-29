<?php

namespace App\Models;

use App\Models\DataPendaftar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListSekolah extends Model
{
    
    public function dataPendaftars()
    {
        return $this->hasMany(DataPendaftar::class, 'sekolah_id');
    }

    
    public function dataSantri()
    {
        return $this->hasMany(DataSantri::class,'sekolah_id');
    }
}