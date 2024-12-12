<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class WilayahIDController extends Controller
{
    public function getProvinsi()
    {
        $response = Http::get('https://alamat.thecloudalert.com/api/provinsi/get/');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Gagal mengambil data provinsi.'], $response->status());
    }

    public function getKabKota($provinsiId)
    {
        $response = Http::get('https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=' . $provinsiId);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Gagal mengambil data kota.'], $response->status());
    }

    public function getKecamatan($kabkotaId)
    {
        $response = Http::get('https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=' . $kabkotaId);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Gagal mengambil data kecamatan.'], $response->status());
    }

    public function getKodePos($kabkotaId, $kecamatanId)
    {
        $response = Http::get('https://alamat.thecloudalert.com/api/kodepos/get/?d_kabkota_id='. $kabkotaId .'&d_kecamatan_id='. $kecamatanId .'');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['message' => 'Gagal mengambil data kode pos.'], $response->status());
    }
}
