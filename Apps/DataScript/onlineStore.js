$(document).ready(() => {
    var lvl = $("#lvlUser").val();
    var pg = $("#pgn").val();
    if (lvl == "admin" || lvl == "superadmin") {
        var table_toko = $("#onlinestore").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/getOnlinestore.php",
            "responsive": true,
            "columnDefs": [{
                "targets": 5,
                "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
            }, {
                "targets": 6,
                "render": function (data, row) {
                    if (pg === 'Vega') {
                        if (data === 'UNPROCESS') {
                            return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
                        } else if (data === 'CANCEL') {
                            return '<span class="label label-danger">[' + data +
                                ']</span>';
                        } else if (data === 'PROCESS') {
                            return '<span class="label label-success">[' + data +
                                ']</span>';
                        }
                    } else {
                        if (data === 'UNPROCESS') {
                            return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip" disabled>Proses</button>';
                        } else if (data === 'CANCEL') {
                            return '<span class="label label-danger">[' + data +
                                ']</span>';
                        } else if (data === 'PROCESS') {
                            return '<span class="label label-success">[' + data +
                                ']</span>';
                        }
                    }
                }
            }, {
                "targets": 7,
                "render": function (data, row) {
                    if (data === '0|0') {
                        return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                    } else if (data === '2|0') {
                        return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
                    } else if (data == '1|0') {
                        return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                    } else if (data == '1|1') {
                        return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
                    }
                }
            }]
        });
    } else {
        var table_toko = $('#onlinestore').DataTable({ //ketika yang login adalah guest
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/getOnlinestore.php",
            "responsive": true,
            columnDefs: [{
                "targets": -1,
                "data": null,
                "orderable": false,
                "defaultContent": '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>'
            }]
        });
    }

    table_toko.on('draw.dt', function () { //penomoran pada tabel
        var info = table_toko.page.info();
        table_toko.column(0, {
            search: 'applied',
            order: 'applied',
            page: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });

    $('#onlinestore tbody').on('click', '.view_data', function () { //view detail di modal show
        var data = table_toko.row($(this).parents('tr')).data();
        var data3 = data[5];
        var data3 = btoa(data3);
        var id = data[0];
        $.ajax({
            url: "modal/detailpo.php",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                //console.log(data);
                $('#detaiOrder').html(data);
                $('#viewDetail').modal('show');

            }
        });
    });

    $('#onlinestore tbody').on('click', '.aprove', function () { //aprove data 
        var data = table_toko.row($(this).parents('tr')).data();
        var data3 = data[3];
        var data3 = btoa(data3);
        var id = data[0];
        var sals = data[4];
        var cust = data[3];
        var pengg = $('#pengguna').val();
        $.ajax({
            url: "modal/changestatus.php",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                Swal.fire(
                    data,
                    '',
                    'success'
                );
                var url =
                    'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                var chat_id = ["-759758736", "-1001688464072"];
                var text = "Processed By : <i>" + pengg +
                    "</i>\n" + "No. PO : <b><i>" +
                    "<a href='#'>" + id + "</a></i></b>\n" +
                    "Customer : <i>" + cust + "</i>\n" +
                    "Sales : <i>" + sals + "</i>\n" + data;
                for (let index = 0; index < chat_id.length; index++) {
                    const element = chat_id[index];
                    $.ajax({
                        url: url,
                        method: "get",
                        data: {
                            chat_id: element,
                            parse_mode: 'html',
                            text: text
                        }
                    });
                }
                setTimeout(function () {
                    location.assign("datapo.php");
                }, 2000);
            }
        })

    });
    $('#onlinestore tbody').on('click', '.ubah', function () { // tombol ubah data po
        var data = table_toko.row($(this).parents('tr')).data();
        var data3 = data[3];
        var data3 = btoa(data3);
        window.location.href = "datapo_edit.php?id=" + data[0];
    });

    $('#onlinestore tbody').on('click', '.hapus', function () { //tombol hapus po
        var data = table_toko.row($(this).parents('tr')).data();
        var data3 = data[3];
        var data3 = btoa(data3);
        window.location.href = "modal/datapo_delete.php?id=" + data[0];
    });

    $('#onlinestore tbody').on('click', '.cancel', function () { // tombol cancel PO
        var data = table_toko.row($(this).parents('tr')).data();
        var data3 = data[3];
        var data3 = btoa(data3);
        var id = data[0];
        $.ajax({
            url: "modal/cancelsco.php",
            method: "POST",
            data: {
                id: id
            },
            success: function (data) {
                $('#FormPending').html(data);
                $('#EditModal').modal('show');
            }
        });
    });
});
