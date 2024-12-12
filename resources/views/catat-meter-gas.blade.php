@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card card-primary card-outline" id="get-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="header-title">Catat Meter Gas</h4>
                                <p class="card-title-desc">Silakan catat pembacaan meter gas sesuai dengan data terbaru yang tersedia di lapangan.</p>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4 col-sm-12 px-3 mx-auto text-center">
                                    <div class="form-group">
                                        <input type="number" min="0" class="form-control form-control-md" name="id_pelanggan" placeholder="Masukkan ID Pelanggan..." required>
                                    </div>
                                    
                                    <button type="button" class="btn btn-info waves-effect waves-dark mb-4 btn-new-data" data-toggle="tooltip" title="" onclick="cari_data_pelanggan('ADD')" data-original-title="Cari Data Pelanggan" aria-describedby="tooltip999391">
                                        <span class="btn-label">
                                            <i class="fas fa-search mr-2"></i>
                                        </span> 
                                        Cari Data Pelanggan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card bd-callout shadow" id="detail-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="header-title pt-2">Detail Data Pelanggan</h4>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-info waves-effect waves-dark mb-4 btn-tambah-trx" data-toggle="tooltip" title="Catat Meter Gas" onclick="catat_meter()">
                                    <span class="btn-label">
                                        <i class="fas fa-tachometer-alt mr-2"></i>
                                    </span> 
                                    Catat Meter Gas
                                </button>
                            </div>
                        </div>

                        <hr class="mt-0">

                        <!-- Foto -->
                        <div class="col-md-12 mb-4 text-center">
                            <img class="detail-img-pelanggan" src="" height="190px">
                        </div>
                        
                        <div class="col-md-10 mx-auto">
                            <div class="row">
                                <!-- Detail Informasi -->
                                <div class="col-md-4 mb-3">
                                    <label>ID Pelanggan:</label>
                                    <input type="hidden" name="id_pelanggan_trx">
                                    <div class="txt-data" data-key="id_pelanggan"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Nomor NPWP:</label>
                                    <div class="txt-data" data-key="npwp"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Nomor Induk Kependudukan (NIK):</label>
                                    <div class="txt-data" data-key="nik"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Nama:</label>
                                    <div class="txt-data" data-key="nama"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Email:</label>
                                    <div class="txt-data" data-key="email"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>No HP/WA:</label>
                                    <div class="txt-data" data-key="no_hp"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin:</label>
                                    <div class="txt-data" data-key="jenis_kelamin"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Tanggal Lahir:</label>
                                    <div class="txt-data" data-key="tanggal_lahir"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Tempat Lahir:</label>
                                    <div class="txt-data" data-key="tempat_lahir"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Provinsi:</label>
                                    <div class="txt-data" data-key="provinsi"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kota/Kabupaten:</label>
                                    <div class="txt-data" data-key="kota"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kecamatan:</label>
                                    <div class="txt-data" data-key="kecamatan"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kode Pos:</label>
                                    <div class="txt-data" data-key="kode_pos"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Alamat:</label>
                                    <div class="txt-data" data-key="alamat"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-catat-meter-gas">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Catat Meter Gas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="form-input-catat-meter">
                        <div class="col-md-12">
                            <div class="form-group px-0">
                                <label>Foto Meter Gas</label>
                                <input type="file" name="foto" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="png jpg jpeg" />
                            </div>
                            
                            <div class="form-group">
                                <label>Angka Stand</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control form-control-md" name="angka_stand" placeholder="Masukkan Angka Stand..." required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">m<sup>2</sup></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jam Pencatatan</label>
                                <input type="text" class="form-control form-control-md flatpickr-time" name="jam_pencatatan" placeholder="Jam Pencatatan..." required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pencatatan</label>
                                <input type="text" class="form-control form-control-md flatpickr" name="tanggal_pencatatan" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-info waves-effect waves-dark btn-new-data" data-toggle="tooltip" title="" onclick="save_catat_meter()" data-original-title="Simpan Data">
                        <span class="btn-label">
                            <i class="fas fa-save mr-2"></i>
                        </span> 
                        Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('public/js/catat-meter-gas.js')}}"></script>
@endsection
