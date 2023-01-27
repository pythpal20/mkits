//back and next button
$(document).ready(function () {
    $(".pilih1").select2({
        placeholder: "Barcode | Model => Type everything . . .",
        ajax: {
            url: "modal/getBarcode.php",
            type: "post",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    searchSku: params.term, // search term
                };
            },
            processResults: function (response) {
                // console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $("#sku1").change(() => {
        var sku4 = $("#sku1").val();
        $.ajax({
            url: "modal/getPriceByBarcode.php", // buat file selectData.php terpisah
            method: "post",
            dataType: "json",
            data: {
                sku4: sku4,
            },
            success: function (data) {
                // console.log(data);
                $("#hargadasar1").val(data[0]);
            },
        });
    });
    //Perhitungan dasar
    $("#hargadasar1").keyup(() => {
        var harga = $('#hargadasar1').val();
        var percent_disc = $('#diskon_persen1').val();
        var nom_disc = $('#nom_disc1').val();
        var hasil = 0;
        var discount = 0;

        discount = nom_disc;
        hasil = harga - discount;

        $('#harga_diskon1').val(hasil);
        $('#nom_disc1').val(discount);

    });
    $("#diskon_persen1").keyup(() => {
        var harga = $('#hargadasar1').val();
        var percent_disc = $('#diskon_persen1').val();
        var nom_disc = $('#nom_disc1').val();
        var hasil = 0;
        var discount = 0;

        discount = harga * (percent_disc / 100);
        hasil = harga - discount;

        $('#harga_diskon1').val(hasil);
        $('#nom_disc1').val(discount);
    });
    $("#nom_disc1").keyup(() => {
        var harga = $('#hargadasar1').val();
        var percent_disc = $('#diskon_persen1').val();
        var nom_disc = $('#nom_disc1').val();
        var hasil = 0;
        var discount = 0;

        discount = nom_disc;
        hasil = harga - discount;

        $('#harga_diskon1').val(hasil);
        $('#nom_disc1').val(discount);
    });
    //Perulangan Form
    var index = 1;
    $(".tambah").click(function () {
        index++;
        var promoDetail = "promoDetail" + index;
        var sku = "sku" + index;
        var hargadasar = "hargadasar" + index;
        var diskon_persen = "diskon_persen" + index;
        var nom_disc = "nom_disc" + index;
        var harga_diskon = "harga_diskon" + index;
        $("#formDetail").append('<form id="' + (promoDetail) + '">' +
            '<div class="row">' +
            '<div class="col-sm-4"><div class="form-group">' +
            '<label for="">SKU</label>' +
            '<select name="sku" id="' + (sku) + '" class="form-control pilih' + index + '"></select>' +
            '</div></div>' +
            '<div class="col-sm-2"><div class="form-group">' +
            '<label for="">Harga Dasar</label><input type="text" name="hargadasar" id="' + (hargadasar) + '" class="form-control">' +
            '</div></div>' +
            '<div class="col-sm-1"><div class="form-group">' +
            '<label for="">Disc (%)</label><input type="text" name="diskon_persen" id="' + (diskon_persen) + '" class="form-control" value="0">' +
            '</div></div>' +
            '<div class="col-sm-2"><div class="form-group">' +
            '<label for="">Nominal Diskon</label><input type="text" name="nom_disc" id="' + (nom_disc) + '" class="form-control" value="0">' +
            '</div></div>' +
            '<div class="col-sm-3"><div class="form-group">' +
            '<label for="">Harga Diskon</label><input type="text" name="harga_diskon" id="' + (harga_diskon) + '" class="form-control" readonly>' +
            '</div></div>' +
            '</div>' +
            '</form><hr style="background-color: red;"></div>'
        );
        for (let i = 1; i <= index; i++) {
            $(".pilih" + index).select2({
                placeholder: "Barcode | Model => Type everything . . .",
                ajax: {
                    url: "modal/getBarcode.php",
                    type: "post",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            searchSku: params.term, // search term
                        };
                    },
                    processResults: function (response) {
                        // console.log(response);
                        return {
                            results: response,
                        };
                    },
                    cache: true,
                },
            });

            $("#sku" + index).change(() => {
                var sku4 = $("#sku" + index).val();
                $.ajax({
                    url: "modal/getPriceByBarcode.php", // buat file selectData.php terpisah
                    method: "post",
                    dataType: "json",
                    data: {
                        sku4: sku4,
                    },
                    success: function (data) {
                        // console.log(data);
                        $("#hargadasar" + index).val(data[0]);
                    },
                });
            });
            //Perhitungan dasar
            $("#hargadasar" + index).keyup(() => {
                var harga = $('#hargadasar' + index).val();
                var percent_disc = $('#diskon_persen' + index).val();
                var nom_disc = $('#nom_disc' + index).val();
                var hasil = 0;
                var discount = 0;

                discount = nom_disc;
                hasil = harga - discount;

                $('#harga_diskon' + index).val(hasil);
                $('#nom_disc' + index).val(discount);

            });
            $("#diskon_persen" + index).keyup(() => {
                var harga = $('#hargadasar' + index).val();
                var percent_disc = $('#diskon_persen' + index).val();
                var nom_disc = $('#nom_disc' + index).val();
                var hasil = 0;
                var discount = 0;

                discount = harga * (percent_disc / 100);
                hasil = harga - discount;

                $('#harga_diskon' + index).val(hasil);
                $('#nom_disc' + index).val(discount);
            });
            $("#nom_disc" + index).keyup(() => {
                var harga = $('#hargadasar' + index).val();
                var percent_disc = $('#diskon_persen' + index).val();
                var nom_disc = $('#nom_disc' + index).val();
                var hasil = 0;
                var discount = 0;

                discount = nom_disc;
                hasil = harga - discount;

                $('#harga_diskon' + index).val(hasil);
                $('#nom_disc' + index).val(discount);
            });
        }
    });

    $(".simpan").click(() => { 
        var promoHeader = $("#promoHeader").serializeArray(); //form header
        var namapromo = $('#namapromo').val();
        var deskripsi = $('#deskripsi').val();
        var pengguna = $('#addby').val();

        if(namapromo == '' || deskripsi == '' || pengguna == '') {
            swal.fire(
                'Gagal..!',
                'Form Harus lengkap dan Benar',
                'warning'
            );
        } else{
            $.ajax({
                method: "POST",
                url: "modal/HeaderPromo.php",
                data: promoHeader,
                success: (data) => {
                    // console.log(data);
                    var id_promo = data;
                    for (var i = 1; i <= index; i++) {
                        var form = $('#promoDetail' + (i)).serializeArray();
                        form.push({
                            name: "promo_id",
                            value: id_promo
                        });
                        form.push({
                            name: "no_urut",
                            value: i
                        });
                        $.ajax({
                            method: "POST",
                            url: "modal/DetailPromo.php",
                            data: form,
                            success: (data) => {
                                // console.log(data);
                            }
                        });
                    }
                    //notif
                    swal.fire(
                        'Sukses',
                        'Data berhasil ditambahkan',
                        'success'
                    );
                    setTimeout(function () {
                        location.assign(
                            "promoBundling.php");
                    }, 2000);
                }
            });
        }
        
    });
});
