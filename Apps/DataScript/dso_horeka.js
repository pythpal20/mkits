$(document).ready(function () {
  var lvl = $("#lvlUser").val();
  if (lvl == "admin" || lvl == "superadmin") {
    var table = $("#foodpack").DataTable({
      processing: true,
      serverSide: true,
      ajax: "../serverside/dataPoFoodpack.php",
      responsive: true,
      columnDefs: [
        {
          targets: 5,
          render: $.fn.dataTable.render.number(".", "", "", "Rp. "),
        },
        {
          targets: 6,
          render: (data, row) => {
            if (data === "0") {
              return '<center><span class="label label-info label-sm">NO</span></center>';
            } else {
              return '<center><span class="label label-primary label-sm">YES</span></center>';
            }
          },
        },
        {
          targets: 7,
          render: (data, row) => {
            if (data === "UNPROCESS") {
              return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
            } else if (data === "CANCEL") {
              return '<span class="label label-danger">[' + data + "]</span>";
            } else if (data === "PROCESS") {
              return '<span class="label label-success">[' + data + "]</span>";
            }
          },
        },
        {
          targets: 8,
          render: (data, row) => {
            if (data === "0|0") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
            } else if (data === "2|0") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
            } else if (data === "2|1") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
            } else if (data == "1|0") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
            } else if (data == "1|1") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
            }
          },
        },
      ],
    });
    table.on("draw.dt", () => {
      var info = table.page.info();
      table
        .column(0, {
          search: "applied",
          order: "applied",
          page: "applied",
        })
        .nodes()
        .each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
        });
    });

    $("#foodpack tbody").on("click", ".view_data", function () {
      //view detail di modal show
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[5];
      var data3 = btoa(data3);
      var id = data[0];
      $.ajax({
        url: "modal/detailpo.php",
        method: "POST",
        data: {
          id: id,
        },
        success: function (data) {
          //console.log(data);
          $("#detaiOrder").html(data);
          $("#viewDetail").modal("show");
        },
      });
    });
    $("#foodpack tbody").on("click", ".aprove", function () {
      //aprove data
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      var id = data[0];
      var sals = data[4];
      var cust = data[3];
      var pengg = $("#pengguna").val();
      swal
        .fire({
          title: "Proses Data",
          text: "Apakah sudah yakin akan memproses SCO ini?",
          imageUrl: '../img/system/undraw_Questions.png',
          imageHeight: 200,
          showCancelButton: true,
          confirmButtonColor: "#48D1CC",
          cancelButtonColor: "#FF4500",
          confirmButtonText: "Ya, Proses!"
        })
        .then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "modal/changestatus.php",
              method: "POST",
              data: {
                id: id,
              },
              success: function (data) {
                Swal.fire({
                    title: data,
                    imageUrl:'../img/system/undraw_approve.png',
                    imageHeight: 200
                });
                var url =
                  "https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage";
                var chat_id = ["-759758736", "-1001688464072"];
                var text =
                  "Processed By : <i>" +
                  pengg +
                  "</i>\n" +
                  "No. PO : <b><i>" +
                  "<a href='#'>" +
                  id +
                  "</a></i></b>\n" +
                  "Customer : <i>" +
                  cust +
                  "</i>\n" +
                  "Sales : <i>" +
                  sals +
                  "</i>\n" +
                  data;
                for (let index = 0; index < chat_id.length; index++) {
                  const element = chat_id[index];
                  $.ajax({
                    url: url,
                    method: "get",
                    data: {
                      chat_id: element,
                      parse_mode: "html",
                      text: text,
                    },
                  });
                }
                setTimeout(function () {
                  location.assign("datapo.php");
                }, 2000);
              },
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swal.fire("Batal", "Anda Batal Memproses data", "error");
          }
        });
    });

    $("#foodpack tbody").on("click", ".ubah", function () {
      // tombol ubah data po
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      window.location.href = "datapo_edit.php?id=" + data[0];
    });

    $("#foodpack tbody").on("click", ".hapus", function () {
      //tombol hapus po
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      window.location.href = "modal/datapo_delete.php?id=" + data[0];
    });

    $("#foodpack tbody").on("click", ".cancel", function () {
      // tombol cancel PO
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      var id = data[0];
      $.ajax({
        url: "modal/cancelsco.php",
        method: "POST",
        data: {
          id: id,
        },
        success: function (data) {
          $("#FormPending").html(data);
          $("#EditModal").modal("show");
        },
      });
    });
  } else {
    var table = $("#foodpack").DataTable({
      //ketika yang login adalah guest
      processing: true,
      serverSide: true,
      ajax: "../serverside/dataPo.php?id=foodpack",
      responsive: true,
      columnDefs: [
        {
          targets: 6,
          render: function (data, row) {
            if (data === "0") {
              return '<center><span class="label label-info label-sm">NO</span></center>';
            } else {
              return '<center><span class="label label-primary label-sm">YES</span></center>';
            }
          },
        },
        {
          targets: 7,
          render: function (data, row) {
            if (data === "UNPROCESS") {
              return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
            } else if (data === "CANCEL") {
              return '<span class="label label-danger">[' + data + "]</span>";
            } else if (data === "PROCESS") {
              return '<span class="label label-success">[' + data + "]</span>";
            }
          },
        },
        {
          targets: -1,
          data: null,
          orderable: false,
          defaultContent:
            '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>',
        },
      ],
    });

    table.on("draw.dt", function () {
      //penomoran
      var info = table.page.info();
      table
        .column(0, {
          search: "applied",
          order: "applied",
          page: "applied",
        })
        .nodes()
        .each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
        });
    });

    $("#foodpack tbody").on("click", ".view_data", function () {
      // view detail data pada modal show
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[5];
      var data3 = btoa(data3);
      var id = data[0];
      $.ajax({
        url: "modal/detailpo.php",
        method: "POST",
        data: {
          id: id,
        },
        success: function (data) {
          //console.log(data);
          $("#detaiOrder").html(data);
          $("#viewDetail").modal("show");
        },
      });
    });
  }
});

$(document).ready(() => {
  var lvl = $("#lvlUser").val();
  var pg = $("#pgn").val();
  if (lvl == "admin" || lvl == "superadmin") {
    var table = $("#horeka").DataTable({
      processing: true,
      serverSide: true,
      ajax: "../serverside/dataPoHoreka.php",
      responsive: true,
      columnDefs: [
        {
          targets: 5,
          render: $.fn.dataTable.render.number(".", "", "", "Rp. "),
        },
        {
          targets: 6,
          render: (data, row) => {
            if (data === "0") {
              return '<center><span class="label label-info label-sm">NO</span></center>';
            } else {
              return '<center><span class="label label-primary label-sm">YES</span></center>';
            }
          },
        },
        {
          targets: 7,
          render: (data, row) => {
            if(pg === 'Antonius') {
              if (data === "UNPROCESS") {
                return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
              } else if (data === "CANCEL") {
                return '<span class="label label-danger">[' + data + "]</span>";
              } else if (data === "PROCESS") {
                return '<span class="label label-success">[' + data + "]</span>";
              }
            } else {
              if (data === "UNPROCESS") {
                return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip" disabled>Proses</button>';
              } else if (data === "CANCEL") {
                return '<span class="label label-danger">[' + data + "]</span>";
              } else if (data === "PROCESS") {
                return '<span class="label label-success">[' + data + "]</span>";
              }
            }
          },
        },
        {
          targets: 8,
          render: (data, row) => {
            if (data === "0|0") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
            } else if (data === "2|0") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
            } else if (data === "2|1") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
            } else if (data == "1|0") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
            } else if (data == "1|1") {
              return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
            }
          },
        },
      ],
    });
    table.on("draw.dt", () => {
      var info = table.page.info();
      table
        .column(0, {
          search: "applied",
          order: "applied",
          page: "applied",
        })
        .nodes()
        .each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
        });
    });

    $("#horeka tbody").on("click", ".view_data", function () {
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[5];
      var data3 = btoa(data3);
      var id = data[0];
      $.ajax({
        url: "modal/detailpo.php",
        method: "POST",
        data: {
          id: id,
        },
        success: function (data) {
          //console.log(data);
          $("#detaiOrder").html(data);
          $("#viewDetail").modal("show");
        },
      });
    });
    $("#horeka tbody").on("click", ".aprove", function () {
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      var id = data[0];
      var sals = data[4];
      var cust = data[3];
      var pengg = $("#pengguna").val();
      swal
        .fire({
          title: "Proses Data",
          text: "Apakah sudah yakin akan memproses SCO ini?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#48D1CC",
          cancelButtonColor: "#FF4500",
          confirmButtonText: "Ya, Proses!",
          background: "#FFF5EE",
        })
        .then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "modal/changestatus.php",
              method: "POST",
              data: {
                id: id,
                pengguna: pengg
              },
              success: function (data) {
                Swal.fire(data, "", "success");
                var url =
                  "https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage";
                var chat_id = ["-759758736", "-1001688464072"];
                var text =
                  "Processed By : <i>" +
                  pengg +
                  "</i>\n" +
                  "No. PO : <b><i>" +
                  "<a href='#'>" +
                  id +
                  "</a></i></b>\n" +
                  "Customer : <i>" +
                  cust +
                  "</i>\n" +
                  "Sales : <i>" +
                  sals +
                  "</i>\n" +
                  data;
                for (let index = 0; index < chat_id.length; index++) {
                  const element = chat_id[index];
                  $.ajax({
                    url: url,
                    method: "get",
                    data: {
                      chat_id: element,
                      parse_mode: "html",
                      text: text,
                    },
                  });
                }
                setTimeout(function () {
                  location.assign("datapo.php");
                }, 2000);
              },
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swal.fire("Batal", "Anda Batal Memproses data", "error");
          }
        });
    });

    $("#horeka tbody").on("click", ".ubah", function () {
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      window.location.href = "datapo_edit.php?id=" + data[0];
    });

    $("#horeka tbody").on("click", ".hapus", function () {
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      window.location.href = "modal/datapo_delete.php?id=" + data[0];
    });

    $("#horeka tbody").on("click", ".cancel", function () {
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[3];
      var data3 = btoa(data3);
      var id = data[0];
      $.ajax({
        url: "modal/cancelsco.php",
        method: "POST",
        data: {
          id: id,
        },
        success: function (data) {
          $("#FormPending").html(data);
          $("#EditModal").modal("show");
        },
      });
    });
  } else {
    var table = $("#horeka").DataTable({
      processing: true,
      serverSide: true,
      ajax: "../serverside/dataPo.php?id=horeka",
      responsive: true,
      columnDefs: [
        {
          targets: 6,
          render: function (data, row) {
            if (data === "0") {
              return '<center><span class="label label-info label-sm">NO</span></center>';
            } else {
              return '<center><span class="label label-primary label-sm">YES</span></center>';
            }
          },
        },
        {
          targets: 7,
          render: function (data, row) {
            if (data === "UNPROCESS") {
              return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
            } else if (data === "CANCEL") {
              return '<span class="label label-danger">[' + data + "]</span>";
            } else if (data === "PROCESS") {
              return '<span class="label label-success">[' + data + "]</span>";
            }
          },
        },
        {
          targets: -1,
          data: null,
          orderable: false,
          defaultContent:
            '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>',
        },
      ],
    });

    table.on("draw.dt", function () {
      var info = table.page.info();
      table.column(0, {
          search: "applied",
          order: "applied",
          page: "applied",
        }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
        });
    });

    $("#horeka tbody").on("click", ".view_data", function () {
      var data = table.row($(this).parents("tr")).data();
      var data3 = data[5];
      var data3 = btoa(data3);
      var id = data[0];
      $.ajax({
        url: "modal/detailpo.php",
        method: "POST",
        data: {
          id: id,
        },
        success: function (data) {
          //console.log(data);
          $("#detaiOrder").html(data);
          $("#viewDetail").modal("show");
        },
      });
    });
  }
});
