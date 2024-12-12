@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card card-primary card-outline" id="list-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="header-title">List Pelanggan</h4>
                                <p class="card-title-desc">Tabel berikut menampilkan daftar pelanggan beserta informasi detail yang dapat diubah, ditambah, atau dihapus.</p>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-info waves-effect waves-dark mb-4 btn-new-data" data-toggle="tooltip" title="" onclick="form_state('ADD')" data-original-title="Tambah Data Baru" aria-describedby="tooltip999391">
                                    <span class="btn-label">
                                        <i class="fa fa-plus mr-2"></i>
                                    </span> 
                                    Tambah Data
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table-data" class="table table-sm table-bordered table-striped display nowrap" style="width: 100%;">
                                <thead style="background-color: #3B6D8C;">
                                    <tr class="text-center text-white">
                                        <th>ID Pelanggan</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>No HP/WA</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- hi dude i dude some magic here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="card bd-callout shadow" id="add-data">
                    <form enctype="multipart/form-data" id="form-input">
                        <input type="hidden" name="state">
                        <input type="hidden" name="sysid">
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="header-title"><span class="title-form-input-hdr">Tambah</span> Data Pelanggan</h4>
                                    <p class="card-title-desc">Form Input untuk Menyimpan/Mengubah Informasi Pelanggan Baru</p>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" class="btn btn-info waves-effect waves-dark mb-4 btn-back-data" data-toggle="tooltip" title="Kembali" onclick="form_state('BACK')" aria-describedby="tooltip999391">
                                        <span class="btn-label">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                        </span> 
                                        Kembali
                                    </button>
                                </div>
                            </div>

                            <hr class="mt-0">
    
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 px-3">
                                    <div class="form-group col-md-6 px-0">
                                        <label>Foto</label>
                                        <input type="file" name="foto" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="png jpg jpeg" />
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>ID Pelanggan</label>
                                        <input type="text" class="form-control form-control-sm" name="id_pelanggan" placeholder="ID Pelanggan akan dibuat otomatis dari sistem" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Nomor NPWP</label>
                                        <input type="number" min="0" class="form-control form-control-sm" name="npwp" placeholder="Masukkan Nomor NPWP..." required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Nomor Induk Kependudukan (NIK)</label>
                                        <input type="number" class="form-control form-control-sm" min="0" name="nik" placeholder="Masukkan Nomor Induk Kependudukan..." required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control form-control-sm" name="nama" placeholder="Masukkan Nama..." required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control form-control-sm" placeholder="Masukkan Email Pelanggan..." name="email" required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>No HP/WA</label>
                                        <input type="number" min="0" class="form-control form-control-sm" name="no_hp" placeholder="Masukkan No HP/WA..." required>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" value="L" id="laki-laki" name="jenis_kelamin" checked>
                                                <label for="laki-laki" class="custom-control-label">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio ml-3">
                                                <input class="custom-control-input" type="radio" value="P" id="perempuan" name="jenis_kelamin">
                                                <label for="perempuan" class="custom-control-label">Perempuan</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="text" class="form-control form-control-sm flatpickr" name="tanggal_lahir">
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control form-control-sm" name="tempat_lahir" placeholder="Masukkan Tempat Lahir..." required>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <select class="form-control form-control-sm select2" name="provinsi" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Kota/Kabupaten</label>
                                        <select class="form-control form-control-sm select2" name="kota" required>
                                            <option value="">Pilih Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control form-control-sm select2" name="kecamatan" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Kode Pos</label>
                                        <select class="form-control form-control-sm select2" name="kodepos" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12 px-3">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control form-control-sm" cols="30" rows="3" required></textarea>
                                    </div>
                                </div>

                            </div>

                            <!-- =============================== END FORM =========================== -->
                            <div class="card-footer text-muted py-3 text-center mt-4">
                                <button type="button" class="btn btn-simpan-data px-5 btn-md" id="btn-submit"><i class="fas fa-save mr-2"></i> <span class="txt-btn-form-submit">Simpan</span> Data</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card bd-callout shadow" id="detail-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="header-title">Detail Data Pelanggan</h4>
                                <p class="card-title-desc">Detail Data Untuk Mengetahui Informasi Pelanggan</p>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-info waves-effect waves-dark mb-4 btn-back-data" data-toggle="tooltip" title="Kembali" onclick="form_state('BACK')" aria-describedby="tooltip999391">
                                    <span class="btn-label">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                    </span> 
                                    Kembali
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
@endsection

@section('js')
    <script src="{{asset('public/master-data/js/pelanggan.js')}}"></script>
@endsection
