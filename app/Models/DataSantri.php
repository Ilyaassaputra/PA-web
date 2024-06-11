<?php

namespace App\Models;

use App\Models\User;
use App\Models\ListSekolah;
use App\Models\DataPendaftar;
use App\Models\DataPembayaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DataTagihan;

class DataSantri extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'data_pendaftar_id'
    ];

    public function dataPendaftar()
    {
        return $this->belongsTo(DataPendaftar::class)->onDelete('cascade');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sekolah()
    {
        return $this->belongsTo(ListSekolah::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(DataPembayaran::class, 'santri_id');
    }

    public function tagihans()
    {
        return $this->hasMany(DataTagihan::class, 'santri_id', 'id');
    }
}
