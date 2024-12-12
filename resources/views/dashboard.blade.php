@extends('layouts.backend')

@section('css')
    <style>
        .grafik .card {
            border-radius: 7px;
        }

        .grafik h6 {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header pt-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 pl-0">
                    <h1 class="m-0"><b>Dashboard</b></h1>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <label class="mr-2 pt-1">Filter :</label>
                        </div>
                        <div class="col-md-5">
                            <select name="bulan" class="select2 form-control-sm form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                                        {{ (str_pad($i, 2, '0', STR_PAD_LEFT) == date('m')) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select name="tahun" class="select2 form-control-sm form-control">
                                @foreach (range(date('Y'), 2020) as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="txt-card-dashboard" data-key="total_operator">0</h3>
                        <p>Total Operator</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 class="txt-card-dashboard" data-key="total_pelanggan">0</h3>
                        <p>Total Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 class="txt-card-dashboard" data-key="total_pemakaian_bulan_ini">0</h3>
                        <p>Total Pemakaian Bulan Ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 class="txt-card-dashboard" data-key="rata_rata_volume_pemakaian">0</h3>
                        <p>Rata Rata Volume Pemakaian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 grafik mb-4">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <div class="text-center">
                            <h6 class="mb-2 text-lg txt-uppercase">GRAFIK PEMAKAIAN BULANAN TAHUN <span class="txt-tahun"></span></h6>
                        </div>
    
                        <div id="grafik-pemakaian-perbulan"></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('public/js/dashboard.js')}}"></script>
@endsection
