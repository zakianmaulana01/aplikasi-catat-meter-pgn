<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Illuminate\Support\Facades\Hash;
use DateTime;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData.pelanggan');
    }

    public function list_data() {
        $data = DB::table('pelanggans')->orderBy('id', 'DESC')->get();

        return Datatables::of($data)->addIndexColumn()->make(true);
    }

    public function store(Request $request)
    {
        $state      = $request->state;
        $sysid      = $request->sysid;

        $foto           = $request->foto;
        $id_pelanggan   = $request->id_pelanggan;
        $npwp           = $request->npwp;
        $nik            = $request->nik;
        $nama           = $request->nama;
        $email          = $request->email;
        $no_hp          = $request->no_hp;
        $jenis_kelamin  = $request->jenis_kelamin;
        $tgl_lahir      = $request->tanggal_lahir;
        $tempat_lahir   = $request->tempat_lahir;
        $alamat         = $request->alamat;
        $provinsi       = $request->provinsi_text;
        $kota           = $request->kota_text;
        $kecamatan      = $request->kecamatan_text;
        $kode_pos       = $request->kodepos_text;
        $date_time      = new DateTime;

        DB::beginTransaction();
        try {
            if ($state === 'ADD') {
                // Cek ID Pelanggan sudah ada atau belum
                $get_id_pelanggan = DB::table('pelanggans')->where('id_pelanggan', $id_pelanggan)->first();

                if ($get_id_pelanggan) {
                    return response()->json([
                        'code' => 400,
                        'msg'  => 'ID Pelanggan sudah ada. Pastikan ID Pelanggan tidak sama.',
                    ]);
                }

                if ($request->hasFile('foto')) {
                    $file_img   = $id_pelanggan . "." . $foto->getClientOriginalExtension();
                    $type       = $foto->getMimeType();
                    $size       = $foto->getSize();
                    
                    $path = $foto->move(public_path()."/master-data/pelanggan/img/", $file_img);
                    // $path = $foto->storeAs('pelanggan/img', $file_img, 'public');
                } else {
                    $file_img = null;
                }
    
                $id_pelanggan = $this->generateIdPelanggan();

                DB::table('pelanggans')->insert([
                    'foto'          => $file_img,
                    'id_pelanggan'  => $id_pelanggan,
                    'nik'           => $nik,
                    'npwp'          => $npwp,
                    'nama'          => $nama,
                    'email'         => $email,
                    'no_hp'         => $no_hp,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tanggal_lahir' => date('Y-m-d', strtotime($tgl_lahir)),
                    'tempat_lahir'  => $tempat_lahir,
                    'alamat'        => $alamat,
                    'provinsi'      => $provinsi,
                    'kota'          => $kota,
                    'kecamatan'     => $kecamatan,
                    'kode_pos'      => $kode_pos,
                    'created_at'    => $date_time,
                ]);

            } elseif ($state === 'EDIT') {
                $get_pelanggan = DB::table('pelanggans')->where('id', $sysid)->first();

                if ($request->hasFile('foto')) {
                    $file_img   = $id_pelanggan . "." . $foto->getClientOriginalExtension();
                    $type       = $foto->getMimeType();
                    $size       = $foto->getSize();

                    $path = $foto->move(public_path()."/master-data/pelanggan/img/", $file_img);
                } else {
                    $file_img = $get_pelanggan->foto;
                }
    
                DB::table('pelanggans')->where('id', $sysid)->update([
                    'foto'          => $file_img,
                    'nik'           => $nik,
                    'npwp'          => $npwp,
                    'nama'          => $nama,
                    'email'         => $email,
                    'no_hp'         => $no_hp,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tanggal_lahir' => date('Y-m-d', strtotime($tgl_lahir)),
                    'tempat_lahir'  => $tempat_lahir,
                    'alamat'        => $alamat,
                    'provinsi'      => $provinsi,
                    'kota'          => $kota,
                    'kecamatan'     => $kecamatan,
                    'kode_pos'      => $kode_pos,
                    'created_at'    => $date_time,
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'msg'  => 'Status operasi tidak valid.',
                ]);
            }

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

    public function detail($id)
    {
        DB::beginTransaction();
        try {
            $data = DB::table('pelanggans')->where('id', $id)->first();
        
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

    public function edit($id)
    {
        DB::beginTransaction();
        try {
            $data = DB::table('pelanggans')->where('id', $id)->first();
        
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('pelanggans')->where('id', $id)->delete();
        
            DB::commit();
            return response()->json([
                'code' => 200,
                'msg'  => 'Berhasil Menghapus Data',
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 500,
                'msg'   => $e->getMessage()
            ]);
        }
    }

    function generateIdPelanggan()
    {
        $currentYear = date('y');
        $currentMonth = date('m');
        
        $lastId = DB::table('pelanggans')
                    ->where('id_pelanggan', 'like', "{$currentYear}{$currentMonth}%")
                    ->orderBy('id_pelanggan', 'desc')
                    ->first();
        
        if ($lastId) {
            $lastCounter = substr($lastId->id_pelanggan, -3);
            $newCounter = str_pad((int)$lastCounter + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newCounter = '001';
        }

        $id_pelanggan = "{$currentYear}{$currentMonth}{$newCounter}";

        return $id_pelanggan;
    }
}
