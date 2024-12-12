$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

     // Event listener ketika bulan atau tahun berubah
    $('select[name="bulan"], select[name="tahun"]').on('change', function() {
        var bulan = $('select[name="bulan"]').val();
        var tahun = $('select[name="tahun"]').val();

        // Cek apakah bulan dan tahun sudah dipilih
        if (bulan && tahun) {
            get_data();
        }
    });
});

get_data();

function get_data() {
    var bulan = $('select[name="bulan"]').val();
    var tahun = $('select[name="tahun"]').val();

    $.ajax({
        url: document.location.href + "get-data",
        type: "GET",
        data: { bulan: bulan, tahun: tahun },
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
                $('.txt-card-dashboard[data-key="total_operator"]').text(response.tot_operator);
                $('.txt-card-dashboard[data-key="total_pelanggan"]').text(response.tot_pelanggan);
                $('.txt-card-dashboard[data-key="total_pemakaian_bulan_ini"]').html(response.tot_pemakaian_bulan + ' m<sup style="font-size: 20px">2</sup>');
                $('.txt-card-dashboard[data-key="total_pemakaian_bulan_ini"]').html(response.tot_pemakaian_bulan + ' m<sup style="font-size: 20px">2</sup>');
                $('.txt-card-dashboard[data-key="rata_rata_volume_pemakaian"]').html(response.rata_rata_pemakaian_bulan + ' m<sup style="font-size: 20px">2</sup>');

                $('.txt-tahun').text(tahun);

                
                let categories = [];
                let data = [];

                // Loop menggunakan each()
                $.each(response.data_grafik, function(index, item) {        
                    categories.push(item.categories);
                    data.push(item.data !== null ? item.data : 'null');
                });

                grafik_pemakaian_perbulan(categories, data);
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

function grafik_pemakaian_perbulan(x_categories, series) {
    Highcharts.chart('grafik-pemakaian-perbulan', {
        title: {
            text: null,
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        yAxis: {
            title: {
                text: 'm <sup>2</sup>',
                useHTML: true
            },
            labels: {
                formatter: function () {
                    return this.value;
                },
                style: {
                    fontSize: '11px',
                }
            }
        },
        xAxis: {
            categories: x_categories,  
            labels: {
                style: {
                    fontSize: '11px'
                }
            }
        },
        legend: {
            enabled: true,
            align: 'center',
            verticalAlign: 'bottom',
            itemStyle: {
                fontSize: '11px',
            }
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '11px'
                    },
                    borderWidth: 0
                }
            }
        },
    
        series: [{
            name: 'Pemakaian',
            data: series
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
}
