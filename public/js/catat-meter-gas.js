var MainForm;
var BtnSubmit;
var baseUrl = window.location.origin + '/project_pgn_dev';
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('#get-data').show();
    $('#detail-data').hide();
});

function cari_data_pelanggan() {
    let id_pelanggan = $('input[name="id_pelanggan"]').val();

    $('#detail-data').hide('slow');
    $('input[name="id_pelanggan_trx"]').val('');

    $.ajax({
        url: document.location.href + "/cari-data-pelanggan/" + id_pelanggan,
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
                let foto = response.data.foto ? '/public/master-data/pelanggan/img/' + response.data.foto : '/public/assets-global/img/no_photo.png';
                $('.detail-img-pelanggan').attr('src', baseUrl + foto);
                $('input[name="id_pelanggan_trx"]').val(response.data.id_pelanggan);
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
                $('#detail-data').show('slow');

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

function catat_meter() {
    $('#form-input-catat-meter input').val('');
    var drEvent = $('input[name="foto"]').dropify();
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();

    $(".flatpickr").val(moment().format("DD MMMM YYYY")).removeAttr('readonly');
    $(".flatpickr-time").val(moment().format("HH:mm")).removeAttr('readonly');

    $('#modal-catat-meter-gas').modal('show');
}

function save_catat_meter() {
    var formDataa = new FormData($('#form-input-catat-meter')[0]);
    formDataa.append('id_pelanggan_trx', $('input[name="id_pelanggan_trx"]').val());

    $.ajax({
        dataType: "json",
        type: "POST",
        url: document.location.href + "/save-catat-meter",
        data: formDataa,
        cache: false,
        contentType: false,
        processData: false,
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
            Swal.close()
            if (response.code == 200) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.msg,
                    showCancelButton: false,
                }).then((result) => {
                    $('#modal-catat-meter-gas').modal('hide');
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