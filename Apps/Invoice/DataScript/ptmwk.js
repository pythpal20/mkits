$(document).ready(function() {
    var $table = $("#example")
    $(function() {
            $table.bootstrapTable('destroy').bootstrapTable({
                url: 'serverside/data.php?id=1',
                pagination: true,
                search: true,
                fixedColumns: true,
                fixedNumber: 2,
                fixedRightNumber:1,
                exportDataType: $(this).val(),
                exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                columns: [{
                        field: 'state',
                        checkbox: true,
                        visible: $(this).val() === 'selected'
                    }, {
                    field: 'tgl_inv',
                    title: 'Tgl. Inv.',
                    sortable: 'true'
                }, {
                    field: 'nofa_awal',
                    title: 'No Inv.',
                    sortable: 'true'
                }, {
                    field: 'noso',
                    title: 'No SO',
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
                    field: 'nominal_awal',
                    title: 'Nominal FA Awal',
                    sortable: 'true',
                    formatter: function(value){
                        return [
                            'Rp. ' + value.toLocaleString()
                        ]
                    }
                }, {
                    field: 'nominal_akhir',
                    title: 'Nominal Konfirmasi',
                    sortable: 'true',
                    formatter: function(value){
                        return [
                            'Rp. ' + value.toLocaleString()
                        ]
                    }
                }, {
                    field: 'tgl_kontrabon',
                    title: 'tgl Kontrabon',
                    sortable: 'true'
                }, {
                    field: 'tgl_duedate',
                    title: 'tgl Duedate',
                    sortable: 'true'
                }, {
                    field: 'overdue',
                    title: 'Overdue',
                    sortable: 'true'
                }, {
                    field: 'total_bayar',
                    title: 'Total Bayar',
                    sortable: 'true'
                }, {
                    field: 'selisih',
                    title: 'Selisih',
                    sortable: 'true'
                }, {
                    field: 'No_Co',
                    title: 'Aksi',
                    formatter: function (value, row, index) {
                        return [
                            '<a class="btn btn-xs btn-info remove" href="../form_penagihan.php?co='+ value +'" target="_blank">',
                            '<i class="fa fa-eye"></i>',
                            '</a>'
                        ].join('');
                    }
                }]
                
            });
    });
    
});