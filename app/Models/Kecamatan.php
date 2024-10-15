<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'reg_districts';
    protected $fillable = ['name', 'regency_id'];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class, 'district_id', 'id');
    }
}
