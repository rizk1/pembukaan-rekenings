<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenKota extends Model
{
    use HasFactory;

    protected $table = 'reg_regencies';
    protected $fillable = ['name', 'province_id'];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'regency_id', 'id');
    }
}
