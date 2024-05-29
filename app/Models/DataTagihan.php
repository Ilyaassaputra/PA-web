<?php

namespace App\Models;

use App\Models\DataSantri;
use App\Models\JenisTagihan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataTagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'jenis_tagihan_id',
        'bulan',
        'thn_ajaran',
        'nominal_tagihan',
        'status_pembayaran',
        'batch_id',

    ];

    public function santri()
    {
        return $this->belongsTo(DataSantri::class, 'santri_id');
    }

    public function jenisTagihan()
    {
        return $this->belongsTo(JenisTagihan::class, 'jenis_tagihan_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(DataPembayaran::class, 'tagihan_id', 'id');
    }




}
