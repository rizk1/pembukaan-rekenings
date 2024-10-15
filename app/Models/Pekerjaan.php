<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pekerjaan',
    ];

    public function pembukaanRekenings()
    {
        return $this->hasMany(PembukaanRekening::class);
    }
}
