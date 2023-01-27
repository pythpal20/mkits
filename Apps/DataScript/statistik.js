$(document).ready(function() {
    $('.kasitunjuk').click(function() {
        $("#statistic").modal('show');
        var $table = $('#statisk')
        var $tableco = $('#statistikco')
        $(function() {
            $('#toolbar').find('select').change(function() {
                $table.bootstrapTable('destroy').bootstrapTable({
                    url: '../serverside/getStatistik.php?id=sco',
                    pagination: true,
                    search: true,
                    fixedColumns: true,
                    fixedNumber: 1,
                    exportDataType: $(this).val(),
                    exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                    columns: [{
                        field: 'state',
                        checkbox: true,
                        visible: $(this).val() === 'selected'
                    }, {
                        field: 'sales',
                        title: 'Nama User',
                        sortable: 'true'
                    }, {
                        field: 'Jan',
                        title: 'Januari',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Feb',
                        title: 'Februari',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Mar',
                        title: 'Maret',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Apr',
                        title: 'April',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Mei',
                        title: 'Mei',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Jun',
                        title: 'Juni',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Jul',
                        title: 'Juli',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Ags',
                        title: 'Agustus',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Sep',
                        title: 'September',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Okt',
                        title: 'Oktober',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Nov',
                        title: 'November',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Des',
                        title: 'Desember',
                        sortable: 'true',
                        formatter: Rupiah
                    }]
                });
            }).trigger('change')
        });

        //tableCO
        $(function() {
            $('#toolbar2').find('select').change(function() {
                $tableco.bootstrapTable('destroy').bootstrapTable({
                    url: '../serverside/getStatistik.php?id=co',
                    pagination: true,
                    search: true,
                    fixedColumns: true,
                    fixedNumber: 1,
                    exportDataType: $(this).val(),
                    exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
                    columns: [{
                        field: 'state',
                        checkbox: true,
                        visible: $(this).val() === 'selected'
                    }, {
                        field: 'sales',
                        title: 'Nama User',
                        sortable: 'true'
                    }, {
                        field: 'Jan',
                        title: 'Januari',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Feb',
                        title: 'Februari',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Mar',
                        title: 'Maret',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Apr',
                        title: 'April',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Mei',
                        title: 'Mei',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Jun',
                        title: 'Juni',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Jul',
                        title: 'Juli',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Ags',
                        title: 'Agustus',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Sep',
                        title: 'September',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Okt',
                        title: 'Oktober',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Nov',
                        title: 'November',
                        sortable: 'true',
                        formatter: Rupiah
                    }, {
                        field: 'Des',
                        title: 'Desember',
                        sortable: 'true',
                        formatter: Rupiah
                    }]
                });
            }).trigger('change')
        });
    });

    function Rupiah(value, row) {
        var sign = 1;
        if (value < 0) {
            sign = -1;
            value = -value;
        }

        let num = value.toString().includes('.') ? value.toString().split('.')[0] : value.toString();
        let len = num.toString().length;
        let result = '';
        let count = 1;

        for (let i = len - 1; i >= 0; i--) {
            result = num.toString()[i] + result;
            if (count % 3 === 0 && count !== 0 && i !== 0) {
                result = '.' + result;
            }
            count++;
        }

        if (value.toString().includes(',')) {
            result = result + ',' + value.toString().split('.')[1];
        }
        // return result with - sign if negative
        return sign < 0 ? '-' + result : (result ? 'Rp. ' + result : '');
    }
});