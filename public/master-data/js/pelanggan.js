var MainForm;
var BtnSubmit;
var baseUrl = window.location.origin + '/project_pgn_dev';
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    
    // --------------------- SELECT CHANGE API WILAYAH ----------------------- //
    $('select[name="provinsi"]').change(function () {
        let provinsiId          = $(this).val();
        let kotaDropdown        = $('select[name="kota"]');
        let kecamatanDropdown   = $('select[name="kecamatan"]');
        let kodeposDropdown     = $('select[name="kodepos"]');

        if (provinsiId) {
            kotaDropdown.prop('disabled', false).html('<option value="">Memuat...</option>');
            kecamatanDropdown.prop('disabled', true).html('<option value="">Pilih Kota Terlebih Dahulu</option>');
            kodeposDropdown.prop('disabled', true).html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');

            get_kota(provinsiId);
        } else {
            kotaDropdown.prop('disabled', true).html('<option value="">Pilih Provinsi Terlebih Dahulu</option>');
            kecamatanDropdown.prop('disabled', true).html('<option value="">Pilih Kota Terlebih Dahulu</option>');
            kodeposDropdown.prop('disabled', true).html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');
        }
    });

    $('select[name="kota"]').change(function () {
        let kotaId = $(this).val();
        let kecamatanDropdown = $('select[name="kecamatan"]');
        let kodeposDropdown = $('select[name="kodepos"]');

        if (kotaId) {
            kecamatanDropdown.prop('disabled', false).html('<option value="">Memuat...</option>');
            kodeposDropdown.prop('disabled', true).html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');
            
            get_kecamatan(kotaId);
        } else {
            kecamatanDropdown.prop('disabled', true).html('<option value="">Pilih Kota Terlebih Dahulu</option>');
            kodeposDropdown.prop('disabled', true).html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');
        }
    });
    
    $('select[name="kecamatan"]').change(function () {
        let kecamatanId = $(this).val();
        let kotaId = $('select[name="kota"]').val();
        let kodeposDropdown = $('select[name="kodepos"]');

        if (kecamatanId) {
            kodeposDropdown.prop('disabled', false).html('<option value="">Memuat...</option>');

            get_kode_pos(kotaId, kecamatanId);
        } else {
            kodeposDropdown.prop('disabled', true).html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');
        }
    });
    // ----------------- SELECT CHANGE API WILAYAH - END --------------------- //
    
    // ----------------- START FORM VALIDATION SAVE ----------- //
    MainForm = $('#form-input');
    BtnSubmit = $('#btn-submit');
    MainForm.validate({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    $.validator.setDefaults({
        debug: true,
        success: 'valid'
    });

    $(BtnSubmit).click(function (e) {
        e.preventDefault();

        if (MainForm.valid()) {
            Swal.fire({
                title: 'Loading....',
                html: '<div class="spinner-border text-primary"></div>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            Fn_Submit_Form(MainForm)
        } else {
            $('html, body').animate({
                scrollTop: ($('.error:visible').offset().top - 200)
            }, 400);
        }
    });
    // ------------- START FORM VALIDATION SAVE - END ----------- //
});

form_state('LOAD');

function form_state(state) {
    switch (state) {
        case 'LOAD':
            $('#list-data').show("slow");
            $('#add-data').hide("slow");
            $('#detail-data').hide("slow");

            reloadData();

            break;

        case 'ADD':
            $('#list-data').hide("slow");
            $('#add-data').show("slow");
            $('#detail-data').hide("slow");
            
            $('.title-form-input-hdr').text('Tambah');
            $('.txt-btn-form-submit').text('Simpan');
            $('input[name="nip"]').prop('readonly', false);
            $('input[name="password"]').attr('required', true);
            $('input[name="confirm_password"]').attr('required', true);

            reset_input();

            get_provinsi();
                    
            $('select[name="kota"]').prop('disabled', true).html('<option value="">Pilih Provinsi Terlebih Dahulu</option>');
            $('select[name="kecamatan"]').prop('disabled', true).html('<option value="">Pilih Kota Terlebih Dahulu</option>');
            $('select[name="kodepos"]').prop('disabled', true).html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');
            
			$(".flatpickr").val(moment().format("DD MMMM YYYY")).removeAttr('readonly');

            $('input[name="state"]').val('ADD');
            $('select[name="role"]').val('admin').trigger('change');

            break;
        case 'EDIT':
            $('#list-data').hide();
            $('#add-data').show();
            $('#detail-data').hide("slow");

            $('.title-form-input-hdr').text('Ubah');
            $('.txt-btn-form-submit').text('Ubah');
            $('input[name="nip"]').prop('readonly', true);
            $('input[name="password"]').attr('required', false);
            $('input[name="confirm_password"]').attr('required', false);

            reset_input();
            get_provinsi();

            $('select[name="kota"]').prop('disabled', false);
            $('select[name="kecamatan"]').prop('disabled', false);
            $('select[name="kodepos"]').prop('disabled', false);

            $('input[name="state"]').val('EDIT');
            
            break;
        case 'DETAIL':
            $('#list-data').hide();
            $('#add-data').hide();
            $('#detail-data').show("slow");

            $('.txt-data').text('');
            break;
        case 'BACK':
            window.scrollTo({ top: 0, behavior: 'smooth' });
            $('#list-data').show("slow");
            $('#add-data').hide("slow");
            $('#detail-data').hide("slow");
            
            break;
    }
}

function reset_input() {
    // Membersihkan Semua Inputan
    $('#form-input input').val('');
    $('#form-input textarea').val('');
    $('#form-input select').val('').trigger("change");
    $('#form-input select').empty();

    var drEvent = $('input[name="foto"]').dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();

    $('#laki-laki').val('L');
    $('#perempuan').val('P');

    // Reset Validation
    $('input').removeClass('is-invalid');
    $('input').removeClass('is-valid');

    if (typeof valid !== "undefined") {
        valid.resetForm();
    }
}

function reloadData() {
    var isMobile = $(window).width() <= 768;

    // Menghancurkan DataTable yang ada sebelum menginisialisasi ulang
    if ($.fn.DataTable.isDataTable('#table-data')) {
        $('#table-data').DataTable().clear().destroy();
    }

    $('#table-data').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: document.location.href + '/list-data',
        columns: [
            {
                data: 'id_pelanggan'
            },
            {
                data: 'nik'
            },
            {
                data: 'nama'
            },
            {
                data: 'email'
            },
            {
                data: 'alamat'
            },
            {
                data: 'no_hp'
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    btnPrimary = '<button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Detail" onclick="detail('+ data +')"> <i class="fas fa-eye"></i> </button>';
                    btnEdit = '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit" onclick="edit('+ data +')"> <i class="fas fa-pencil-alt"></i> </button>';
                    btnDelete = '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" onclick="destroy('+ data +')"> <i class="fas fa-trash"></i> </button>';

                    return btnPrimary + " " + btnEdit + " " + btnDelete;
                },
            },
        ],
        order: [],
        columnDefs: [{
                className: "text-center",
                targets: "_all",
            },
            {
                className: "text-left",
                targets: []
            }
        ],
        autoWidth: false,
        responsive: isMobile,
        preDrawCallback: function() {
            $("#table-data tbody td").addClass("blurry");
        },
        language: {
            processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" style="text-align:center" class="loading-text"></span> ',
        },
        drawCallback: function() {
            $("#table-data tbody td").addClass("blurry");
            setTimeout(function() {
                $("#table-data tbody td").removeClass("blurry");
            });
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
}

function Fn_Submit_Form() {
    BtnSubmit.prop("disabled", true);
    var formDataa = new FormData(MainForm[0]);

    // Ambil teks dari dropdown dan tambahkan ke FormData
    var provinsiText = $('[name="provinsi"] option:selected').text();
    var kotaText = $('[name="kota"] option:selected').text();
    var kecamatanText = $('[name="kecamatan"] option:selected').text();
    var kodeposText = $('[name="kodepos"] option:selected').text();

    formDataa.set('provinsi_text', provinsiText);
    formDataa.set('kota_text', kotaText);
    formDataa.set('kecamatan_text', kecamatanText);
    formDataa.set('kodepos_text', kodeposText);

    $.ajax({
        dataType: "json",
        type: "POST",
        url: document.location.href + "/store",
        data: formDataa,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.close()
            if (response.code == 200) {
                $(MainForm)[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.msg,
                    showCancelButton: false,
                }).then((result) => {
                    form_state('LOAD');
                })
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: response.msg,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Confirm!',
                    footer: '<a href="javascript:void(0)">Notifikasi System</a>'
                });
            }
            BtnSubmit.prop("disabled", false);
        },
        error: function (xhr, status, error) {
            var statusCode = xhr.status;
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText ? xhr.responseText : "Terjadi kesalahan: " + error;
            Swal.fire({
                icon: "error",
                title: "Error!",
                html: `Kode HTTP: ${statusCode}<br\>Pesan: ${errorMessage}`,
            });

            BtnSubmit.prop("disabled", false);
        }
    });
}

function detail(id) {
    $.ajax({
        url: document.location.href + "/detail/" + id,
        type: "GET",
        beforeSend: function () {
            Swal.fire({
                title: 'Loading....',
                html: '<div class="spinner-border text-primary"></div>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        },
        success: function (response) {
            if (response.code == 200) {
                form_state('DETAIL');
                
                let foto = response.data.foto ? '/public/master-data/pelanggan/img/' + response.data.foto : '/public/assets-global/img/no_photo.png';
                $('.detail-img-pelanggan').attr('src', baseUrl + foto);
                $('.txt-data[data-key="id_pelanggan"]').text(response.data.id_pelanggan);
                $('.txt-data[data-key="npwp"]').text(response.data.npwp);
                $('.txt-data[data-key="nik"]').text(response.data.nik);
                $('.txt-data[data-key="nama"]').text(response.data.nama);
                $('.txt-data[data-key="email"]').text(response.data.email);
                $('.txt-data[data-key="no_hp"]').text(response.data.no_hp);
                $('.txt-data[data-key="jenis_kelamin"]').text(response.data.jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan');
                $('.txt-data[data-key="tanggal_lahir"]').text(moment(response.data.tanggal_lahir).format("DD MMMM YYYY"));
                $('.txt-data[data-key="tempat_lahir"]').text(response.data.tempat_lahir);
                $('.txt-data[data-key="provinsi"]').text(response.data.provinsi);
                $('.txt-data[data-key="kota"]').text(response.data.kota);
                $('.txt-data[data-key="kecamatan"]').text(response.data.kecamatan);
                $('.txt-data[data-key="kode_pos"]').text(response.data.kode_pos);
                $('.txt-data[data-key="alamat"]').text(response.data.alamat);

                Swal.close();
            } else {
                Swal.fire({
                    title: 'Information!',
                    text: response.msg,
                    icon: "info",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                })
            }
        },
        error: function (xhr, status, error) {
            var errorMessage = xhr.status + ": " + xhr.statusText;
            Swal.fire({
                icon: "error",
                title: "<strong>Error</strong>",
                text: errorMessage,
            });
        },
    });
}

function edit(id) {
    $.ajax({
        url: document.location.href + "/edit/" + id,
        type: "GET",
        beforeSend: function () {
            Swal.fire({
                title: 'Loading....',
                html: '<div class="spinner-border text-primary"></div>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        },
        success: function (response) {
            if (response.code == 200) {
                form_state('EDIT');
                
                $('input[name="sysid"]').val(id);
                $('input[name="id_pelanggan"]').val(response.data.id_pelanggan);
                $('input[name="npwp"]').val(response.data.npwp);
                $('input[name="nik"]').val(response.data.nik);
                $('input[name="nama"]').val(response.data.nama);
                $('input[name="email"]').val(response.data.email);
                $('input[name="no_hp"]').val(response.data.no_hp);
                $('input[name="jenis_kelamin"][value="' + response.data.jenis_kelamin + '"]').prop('checked', true);
                $('input[name="tanggal_lahir"]').val(moment(response.data.tanggal_lahir).format("DD MMMM YYYY"));
                $('input[name="tempat_lahir"]').val(response.data.tempat_lahir);
                $('textarea[name="alamat"]').val(response.data.alamat);
                
                setTimeout(function() {
                    // Pilih Provinsi berdasarkan teks
                    setOptionsAndSelect('select[name="provinsi"]', response.data.provinsi);
                    
                    if ($('select[name="provinsi"]').val()) {
                        setTimeout(function() {
                            // Pilih Kota berdasarkan teks
                            setOptionsAndSelect('select[name="kota"]', response.data.kota);
                            
                            if ($('select[name="kota"]').val()) {
                                setTimeout(function() {
                                    // Pilih Kota berdasarkan teks
                                    setOptionsAndSelect('select[name="kecamatan"]', response.data.kecamatan);

                                    if ($('select[name="kecamatan"]').val()) {
                                        setTimeout(function() {
                                            // Pilih Kota berdasarkan teks
                                            setOptionsAndSelect('select[name="kodepos"]', response.data.kode_pos);
                                        }, 1000);  // Jeda 500 ms
                                    }
                                }, 1000);  // Jeda 500 ms
                            }
                        }, 1000);  // Jeda 500 ms
                    }

                }, 1000);  // Jeda 500 ms


                if (response.data.foto) {
                    var imagenUrl = baseUrl + "/public/master-data/pelanggan/img/" + response.data.foto;
                    var drEvent = $('input[name="foto"]').dropify(
                    {
                        defaultFile: imagenUrl
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = imagenUrl;
                    drEvent.destroy();
                    drEvent.init();
                }

                Swal.close();
            } else {
                Swal.fire({
                    title: 'Information!',
                    text: response.msg,
                    icon: "info",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                })
            }
        },
        error: function (xhr, status, error) {
            var errorMessage = xhr.status + ": " + xhr.statusText;
            Swal.fire({
                icon: "error",
                title: "<strong>Error</strong>",
                text: errorMessage,
            });
        },
    });
}

function setOptionsAndSelect(selector, textValue) {
    console.log("textValue " + textValue);
    $(selector).find('option').each(function() {
        let optionText = $(this).text().trim(); // Menghapus spasi sebelum dan sesudah
        if (optionText === textValue) {
            $(this).prop('selected', true);
            found = true; // Tandai bahwa nilai ditemukan
        }
    });

    $(selector).trigger('change'); // Trigger perubahan setelah pilihan dilakukan
}

function destroy(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "It will permanently deleted !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        confirmButtonClass: "btn-danger",
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: document.location.href + "/delete/" + id,
                    type: "POST",
                })
                    .done(function (response) {
                        if (response.code == 200) {
                            form_state('LOAD');

                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "Successfully Deleted.",
                                timer: 4000,
                                showConfirmButton: true,
                            });
                        } else {
                            Swal.fire({
                                title: 'Information!',
                                text: response.msg,
                                icon: "info",
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                            })
                        }
                    })
                    .fail(function (xhr, status, error) {
                        var errorMessage =
                            xhr.status + ": " + xhr.statusText;
                        Swal.fire({
                            icon: "error",
                            title: "<strong>Error</strong>",
                            text: errorMessage,
                        });
                    });
            });
        },
        allowOutsideClick: false,
    });
}

// --------------------- FUNCTION API WILAYAH ----------------------- //
function get_provinsi() {
    $.ajax({
        url: baseUrl + '/api/provinsi',
        method: 'GET',
        success: function (response) {
            if (response.status == 200) {
                let options = '<option value="">Pilih Provinsi</option>';
                $.each(response.result, function (index, provinsi) {
                    options += `<option value="${provinsi.id}">${provinsi.text}</option>`;
                });
    
                $('select[name="provinsi"]').html(options);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Confirm!',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                html: 'Gagal memuat data provinsi.',
            });
        }
    });
}

function get_kota(provinsiId) {
    $.ajax({
        url: baseUrl + `/api/kabkota/${provinsiId}`,
        method: 'GET',
        success: function (response) {
            if (response.status == 200) {
                let options = '<option value="">Pilih Kota</option>';
                $.each(response.result, function (index, kota) {
                    options += `<option value="${kota.id}">${kota.text}</option>`;
                });
    
                $('select[name="kota"]').html(options);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Confirm!',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                html: 'Gagal memuat data kota.',
            });
        }
    });
}

function get_kecamatan(kotaId) {
    $.ajax({
        url: baseUrl + `/api/kecamatan/${kotaId}`,
        method: 'GET',
        success: function (response) {
            if (response.status == 200) {
                let options = '<option value="">Pilih Kecamatan</option>';
                $.each(response.result, function (index, kecamatan) {
                    options += `<option value="${kecamatan.id}">${kecamatan.text}</option>`;
                });
    
                $('select[name="kecamatan"]').html(options);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Confirm!',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                html: 'Gagal memuat data kecamatan.',
            });
        }
    });
}

function get_kode_pos(kotaId, kecamatanId) {
    $.ajax({
        url: baseUrl + `/api/kodepos/${kotaId}/${kecamatanId}`,
        method: 'GET',
        success: function (response) {
            if (response.status == 200) {
                let options = '<option value="">Pilih Kode Pos</option>';
                $.each(response.result, function (index, kodepos) {
                    options += `<option value="${kodepos.id}">${kodepos.text}</option>`;
                });
    
                $('select[name="kodepos"]').html(options);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: response.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Confirm!',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                html: 'Gagal memuat data kode pos.',
            });
        }
    });
}
// ------------------- FUNCTION API WILAYAH - END ----------------------- //

// Fungsi Tambahan Datatable Untuk Responsif
let resizeTimeout;

$(window).resize(function() {
    // Clear timeout yang sudah ada
    clearTimeout(resizeTimeout);

    // Set timeout baru untuk memanggil reloadData setelah 300ms
    resizeTimeout = setTimeout(function() {
        reloadData();
    }, 300); // 300ms adalah delay sebelum memanggil reloadData
});