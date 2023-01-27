//1.dataTable
$(document).ready(function () {
    var table = $("#tablePromo").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "../serverside/dataPromo.php",
        columnDefs: [
            {
                //potong nama
                targets: 6,
                render: function (data, row) {
                    return data.split(" ")[0];
                },
            },
            {
                //add tombol
                targets: -1,
                data: null,
                defaultContent:
                    "<center><button class='btn btn-info btn-xs see' title='View Detail' data-toggle='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-xs btn-success edit' data-toggle='tooltip' title='Edit Promo'><span class='fa fa-edit'></span></button> <button class='btn btn-xs btn-danger hapus' data-toggle='tooltip' title='Non-Aktifkan Promo'><span class='fa fa-eraser'></span></button></center>",
            },
            {
                targets: 5,
                render: function (data, row) {
                    if (data === "0") {
                        return "Non-Aktif";
                    } else {
                        return "Aktif";
                    }
                },
            },
            {
                //kasi warna
                targets: 5,
                createdCell: function (tr, data) {
                    if (data === "0") {
                        $(tr).css("background-color", "MistyRose");
                    } else {
                        $(tr).css("background-color", "Azure");
                    }
                },
            },
        ],
    });
    table.on("draw.dt", function () {
        //penomoran
        var info = table.page.info();
        table.column(0, {
            search: "applied",
            order: "applied",
            page: "applied",
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });

    $("#tablePromo tbody").on("click", ".see", function () {
        var data = table.row($(this).parents("tr")).data();
        var data3 = data[5];
        var data3 = btoa(data3);
        var id = data[0];
        $.ajax({
            url: "modal/detailPromos.php",
            method: "POST",
            data: {
                id: id
            },
            success: function(data) {
                //console.log(data);
                $('#dataPromo').html(data);
                $('#modalPromo').modal('show');
                $('.detailPrm').DataTable();

            }
        });
    });
});
