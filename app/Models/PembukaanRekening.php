<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembukaanRekening extends Model
{
    use HasFactory;
    protected $table = 'pembukaan_rekenings';
    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan_id',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan',
        'nama_jalan',
        'rt',
        'rw',
        'nominal_setor',
        'created_by',
        'status',
        'approved_by',
    ];

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }
}
