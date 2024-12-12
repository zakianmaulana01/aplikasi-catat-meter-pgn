<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use DateTime;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function get_data(Request $request) {
        $bulan =$request->bulan;
        $tahun = $request->tahun;

        $total_operator = DB::table('users')->where('role', 'operator')->count();
        $total_pelanggan = DB::table('pelanggans')->count();
        $total_pemakaian_bulan = DB::table('catat_meter_gas')
                                ->whereMonth('tanggal_pencatatan', $bulan)
                                ->whereYear('tanggal_pencatatan', $tahun) 
                                ->sum('angka_stand');
        $rata_rata_pemakaian_bulan = DB::table('catat_meter_gas')
                                    ->avg('angka_stand');

        $data_grafik = [];
        for ($i=1; $i <=12 ; $i++) { 
            $get_angka_grafik = DB::table('catat_meter_gas')
                        ->whereMonth('tanggal_pencatatan', $i)
                        ->whereYear('tanggal_pencatatan', $tahun)
                        ->sum('angka_stand');
                        
            $data_grafik[] = [
                'categories' => Carbon::createFromFormat('m', $i)->locale('id')->isoFormat('MMMM'),
                'data' => $get_angka_grafik,
            ];
        }

        return response()->json([
            'code' => 200,
            'msg'  => 'Berhasil Mendapatkan Data',
            'tot_operator' => $total_operator,
            'tot_pelanggan' => $total_pelanggan,
            'tot_pemakaian_bulan' => $total_pemakaian_bulan,
            'rata_rata_pemakaian_bulan' => $rata_rata_pemakaian_bulan,
            'data_grafik' => $data_grafik,
        ]);
    }
}
