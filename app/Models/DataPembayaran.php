<?php

namespace App\Models;

use App\Models\DataSantri;
use App\Models\DataTagihan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPembayaran extends Model
{
    use HasFactory;
    protected $fillable = [

        'tagihan_id',
        'jenis_tagihan_id',
        'nominal_tagihan',
        'metode',
        'bukti_transfer',
        'jumlah_dibayar',
        'sisa_pembayaran',
    ];



    public function tagihans()
    {
        return $this->belongsTo(DataTagihan::class, 'tagihan_id', 'id');
    }

    public function jenisTagihan()
    {
        return $this->belongsTo(JenisTagihan::class);
    }


}
