<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KabupatenKota;
use App\Models\Provinsi;

class LocationController extends Controller
{
    public function getProvinsi() {
        return response()->json(Provinsi::all());
    }
    public function getKota($provinsi_id) {
        return response()->json(KabupatenKota::where('province_id', $provinsi_id)->get());
    }
    public function getKecamatan($kota_id) {
        return response()->json(Kecamatan::where('regency_id', $kota_id)->get());
    }
    public function getKelurahan($kecamatan_id) {
        return response()->json(Kelurahan::where('district_id', $kecamatan_id)->get());
    }
}
