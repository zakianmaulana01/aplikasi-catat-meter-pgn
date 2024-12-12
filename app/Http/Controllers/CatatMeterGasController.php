<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use DateTime;
use Auth;
use Carbon\Carbon;

class CatatMeterGasController extends Controller
{
    public function index()
    {
        return view('catat-meter-gas');
    }

    public function cari_data_pelanggan($id_pelanggan)
    {
        DB::beginTransaction();
        try {
            $data = DB::table('pelanggans')->where('id_pelanggan', $id_pelanggan)->first();
        
            DB::commit();
            return response()->json([
                'code' => 200,
                'msg'  => 'Berhasil Mendapatkan Data',
                'data' => $data
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 500,
                'msg'   => $e->getMessage()
            ]);
        }
    }
    
    public function store_catat_meter(Request $request)
    {
        $state              = $request->state;
        $id_pelanggan_trx   = $request->id_pelanggan_trx;
        $foto               = $request->foto;
        $angka_stand        = $request->angka_stand;
        $jam_pencatatan     = $request->jam_pencatatan;
        $tanggal_pencatatan = $request->tanggal_pencatatan;
        
        $namauser  = Auth::user()->nama;
        $date_time = new DateTime;

        DB::beginTransaction();
        try {
            if ($request->hasFile('foto')) {
                $file_img   = date('Ym', strtotime($tanggal_pencatatan)) . '-' . $id_pelanggan_trx . "." . $foto->getClientOriginalExtension();
                $type       = $foto->getMimeType();
                $size       = $foto->getSize();
                
                $path = $foto->move(public_path()."/catat-meter-gas/img/", $file_img);
            } else {
                $file_img = null;
            }

            if ($file_img == null) {
                return response()->json([
                    'code' => 400,
                    'msg'  => 'Foto Meter Gas Belum Dimasukkan',
                ]);
            } else if(!$angka_stand) {
                return response()->json([
                    'code' => 400,
                    'msg'  => 'Angka Stand Belum Di input',
                ]);
            }

            DB::table('catat_meter_gas')->insert([
                'id_pelanggan'      => $id_pelanggan_trx,
                'foto'              => $file_img,
                'angka_stand'       => $angka_stand,
                'jam_catat'         => $jam_pencatatan,
                'tanggal_pencatatan'=> date('Y-m-d', strtotime($tanggal_pencatatan)),
                'created_by'        => $namauser,
                'created_at'        => $date_time,
            ]);

            DB::commit();
            return response()->json([
                'code' => 200,
                'msg'  => 'Berhasil menyimpan data.',
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'code' => 500,
                'msg'  => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }
}
