$(document).ready(function() {
    $('#tabelmonitoring').bootstrapTable({
        url: "../serverside/tabelmonitoring.php",
        pagination: true,
        search: true,
        columns: [{
            field: 'no_bl',
            title: 'No. BL',
            sortable: 'true'
        }, {
            field: 'noso',
            title: 'No. SCO',
            sortable: 'true'
        }, {
            field: 'nama_pt',
            title: 'PT',
            sortable: 'true'
        }, {
            field: 'customer_nama',
            title: 'Customer',
            sortable: 'true'
        }, {
            field: 'sales',
            title: 'Sales',
            sortable: 'true'
        }, {
            field: 'aproval_by',
            title: 'By Accounting',
            sortable: 'true',
        }, {
            field: 'aproval_date',
            title: 'Tgl',
            sortable: 'true',
        }, {
            field: 'tgl_po',
            title: 'Tgl',
            sortable: 'true',
        },
        {
            field: 'issuedby',
            title: 'By Admin',
            sortable: 'true'
        }, {
            field: 'tgl_create',
            title: 'Tgl',
            sortable: 'true'
        }, {
            field: 'kenek',
            title: 'Kenek',
            sortable: 'true'
        }, {
            field: 'sopir',
            title: 'Sopir',
            sortable: 'true'
        }, {
            field: 'tgl_delivery',
            title: 'Tgl',
            sortable: 'true'
        }, {
            field: 'selisih',
            title: 'Selisih',
             formatter: function (value, row, index) {
                 if (value === '0') {
                        return '<span class="label label-success">Lunas</span>'
                           } else if (value === 'Belum Bayar') {
                        return '<span class="label label-warning">Belum Bayar</span>'
                        } else {
                    return '<span class="label label-danger">' + value + '</span>'
             }
            }
        }
        ]
    });
});

  