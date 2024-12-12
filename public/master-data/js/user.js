var MainForm;
var BtnSubmit;
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    
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

            reloadData();

            break;

        case 'ADD':
            $('#list-data').hide("slow");
            $('#add-data').show("slow");
            
            $('.title-form-input-hdr').text('Tambah');
            $('.txt-btn-form-submit').text('Simpan');
            $('input[name="nip"]').prop('readonly', false);
            $('input[name="password"]').attr('required', true);
            $('input[name="confirm_password"]').attr('required', true);

            reset_input();
            
            $('input[name="state"]').val('ADD');
            $('select[name="role"]').val('admin').trigger('change');

            break;
        case 'EDIT':
            $('#list-data').hide();
            $('#add-data').show();

            $('.title-form-input-hdr').text('Ubah');
            $('.txt-btn-form-submit').text('Ubah');
            $('input[name="nip"]').prop('readonly', true);
            $('input[name="password"]').attr('required', false);
            $('input[name="confirm_password"]').attr('required', false);

            reset_input();

            $('input[name="state"]').val('EDIT');
            
            break;
        
        case 'BACK':
            window.scrollTo({ top: 0, behavior: 'smooth' });
            $('#list-data').show("slow");
            $('#add-data').hide("slow");
            
            break;
    }
}

function reset_input() {
    // Membersihkan Semua Inputan
    $('#form-input input').val('');
    $('#form-input select').val('').trigger("change");
    
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
                data: 'nip'
            },
            {
                data: 'nama'
            },
            {
                data: 'email'
            },
            {
                data: 'role',
                render: function(data) {
                    return data.substr(0,1).toUpperCase()+data.substr(1);
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    btnEdit = '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit" onclick="edit('+ data +')"> <i class="fas fa-pencil-alt"></i> </button>';
                    btnDelete = '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" onclick="destroy('+ data +')"> <i class="fas fa-trash"></i> </button>';

                    return btnEdit + " " + btnDelete;
                },
            },
        ],
        order: [
            [0, 'desc']
        ],
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
                $('input[name="nip"]').val(response.data.nip);
                $('input[name="nama"]').val(response.data.nama);
                $('input[name="email"]').val(response.data.email);
                $('select[name="role"]').val(response.data.role).trigger('change');
                
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