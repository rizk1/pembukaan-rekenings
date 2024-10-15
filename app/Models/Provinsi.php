<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'reg_provinces';
    protected $fillable = ['name'];

    public function kabupatenKota()
    {
        return $this->hasMany(kabupatenKota::class, 'province_id', 'id');
    }
}
