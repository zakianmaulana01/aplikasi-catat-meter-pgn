@extends('layouts.backend')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card card-primary card-outline" id="list-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="header-title">List User</h4>
                                <p class="card-title-desc">Tabel berikut menampilkan daftar user beserta informasi detail yang dapat diubah, ditambah, atau dihapus.</p>
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
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
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
                                    <h4 class="header-title"><span class="title-form-input-hdr">Tambah</span> Data User</h4>
                                    <p class="card-title-desc">Form Input untuk Menyimpan/Mengubah Informasi User Baru</p>
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
                                <!-- LEFT -->
                                <div class="col-lg-6 col-sm-12 px-4">
                                    <div class="form-group">
                                        <label>Nomor Induk Pegawai</label>
                                        <input type="text" class="form-control form-control-sm" name="nip" placeholder="Masukkan Nomor Induk Pegawai..." required>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control form-control-sm" placeholder="Masukkan Email Pegawai..." name="email" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group input-group-pass" id="show_hide_password">
                                            <input type="password" class="form-control form-control-sm password" name="password" placeholder="Masukkan Password Pegawai...">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-eye-slash"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- LEFT - END -->

                                <!-- RIGHT -->
                                <div class="col-lg-6 col-sm-12 px-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama Pegawai..." name="nama" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control form-control-sm select2" name="role" required>
                                            <option value="admin">Admin</option>
                                            <option value="operator">Operator</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div class="input-group input-group-pass" id="show_hide_password">
                                            <input type="password" class="form-control form-control-sm confirm_password" name="confirm_password"  placeholder="Masukkan Password Ulang Pegawai...">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa fa-eye-slash"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- RIGHT - END -->
                            </div>

                            <!-- =============================== END FORM =========================== -->
                            <div class="card-footer text-muted py-3 text-center mt-4">
                                <button type="button" class="btn btn-simpan-data px-5 btn-md" id="btn-submit"><i class="fas fa-save mr-2"></i> <span class="txt-btn-form-submit">Simpan</span> Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('public/master-data/js/user.js')}}"></script>
@endsection
