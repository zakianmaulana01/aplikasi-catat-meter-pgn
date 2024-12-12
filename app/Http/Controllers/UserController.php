<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Illuminate\Support\Facades\Hash;
use DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MasterData.user');
    }

    public function list_data() {
        $data = DB::table('users')->get();

        return Datatables::of($data)->addIndexColumn()->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state      = $request->state;
        $sysid      = $request->sysid;
        $nip        = $request->nip;
        $nama       = $request->nama;
        $email      = $request->email;
        $role       = $request->role;
        $password   = $request->password;
        $c_password = $request->confirm_password;
        $date_time  = new DateTime;

        DB::beginTransaction();
        try {
            if ($password && $password !== $c_password) {
                return response()->json([
                    'code' => 400,
                    'msg'  => 'Confirm Password tidak sesuai. Silakan periksa kembali.',
                ]);
            }

            if ($state === 'ADD') {
                // Cek NIP sudah ada atau belum
                $get_nip = DB::table('users')->where('nip', $nip)->first();

                if ($get_nip) {
                    return response()->json([
                        'code' => 400,
                        'msg'  => 'NIP sudah ada. Pastikan NIP tidak sama.',
                    ]);
                }

                DB::table('users')->insert([
                    'nip'        => $nip,
                    'nama'       => $nama,
                    'email'      => $email,
                    'role'       => $role,
                    'password'   => Hash::make($password),
                    'created_at' => $date_time,
                ]);

            } elseif ($state === 'EDIT') {
                $get_user = DB::table('users')->where('id', $sysid)->first();

                // Jika Password diisi, maka gunakan Password baru, jika tidak ada maka gunakan Password lama
                $password = $password ? Hash::make($password) : $get_user->password;

                DB::table('users')->where('id', $sysid)->update([
                    'nama'       => $nama,
                    'email'      => $email,
                    'role'       => $role,
                    'password'   => $password,
                    'updated_at' => $date_time,
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

    public function edit($id)
    {
        DB::beginTransaction();
        try {
            $data = DB::table('users')->where('id', $id)->first();
        
            DB::commit();
            return response()->json([
                'code' => 200,
                'msg'  => 'Berhasil Menghapus Data',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::table('users')->where('id', $id)->delete();
        
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
}
