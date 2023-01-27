$(document).ready(function () {

    $(".back").click(function () {
        window.history.back();
    });

    $('.chosen-select1').select2({
        allowClear: true,
        ajax: {
            url: 'modal/getSku.php',
            type: 'post',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchSku: params.term // search term
                };
            },
            processResults: function (response) {
                // console.log(response);
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    //line for SKU change, 
    $("#sPromo1").hide();
    $("#sku1").change(() => {
        var sku4 = $("#sku1").val();
        $.ajax({
            url: 'modal/getPrice.php', // buat file selectData.php terpisah
            method: 'post',
            dataType: "json",
            data: {
                sku4: sku4
            },
            success: function (data) {
                // console.log(data);
                $("#prdHarga1").val(data[0]);
            }
        });

        $.ajax({
            url: "modal/getPromo.php",
            method: "POST",
            data: {
                id: sku4
            },
            success: (data) => {
                $("#sPromo1").show();
                $("#dsopromo1").html(data);
                $("#dsopromo1").select2({
                    placeholder: "Pilih Nama Promo",
                    allowClear: true
                });
                $("#harga1").prop("readonly", false);
                $("#percent_discount1").prop("readonly", false);
                $("#nominal_discount1").prop("readonly", false);
            }
        });
    });

    //On Change pada Select Promo
    $("#dsopromo1").change(() => {
        var xpromo = $("#dsopromo1").val();
        var id_promo = xpromo.split("|")[0];
        var jenis_pro = xpromo.split('|')[1];
        $("#jenisPromo1").val(jenis_pro);
        var id_sku = $("#sku1").val();
        // alert(jenis_pro);
        $.ajax({
            method: "POST",
            url: "modal/getPromoDtl.php",
            dataType: "JSON",
            data: {
                id: id_promo,
                sku: id_sku
            },
            success: (data) => {
                var hsl = data;
                var min_req = parseInt(hsl.qty_min);
                switch (jenis_pro){
                    case '0':
                        $("#prdHarga1").val(hsl.hargadef);
                        $("#harga1").val(hsl.harga_disc);
                        // $("#percent_discount1").val(hsl.disc_percent);
        
                        // $("#nominal_discount1").val(hsl.discount);
        
                        $("#harga1").prop("readonly", true);
                        $("#percent_discount1").prop("readonly", true);
                        $("#nominal_discount1").prop("readonly", true);
                        $("#pengajuan1").prop("hidden", true);
                    break;
                    case '1': 
                        $("#prdHarga1").val(hsl.hargadef);
                        $("#harga1").val(hsl.hargadef);
                        $("#percent_discount1").val(hsl.disc_percent);
                        $("#qty_min1").val(hsl.qty_min);

                        $("#harga1").prop("readonly", true);
                        $("#percent_discount1").prop("readonly", true);
                        $("#nominal_discount1").prop("readonly", true);
                        $("#pengajuan1").prop("hidden", true);
                    break;
                    case '2':
                        $("#prdHarga1").val(hsl.hargadef);
                        $("#harga1").val(hsl.hargadef);
                        $("#qty_min1").val(hsl.qty_min); 
                        $("#diskon_tetap1").val(hsl.discount);
                        $("#harga1").prop("readonly", true);
                        $("#nominal_discount1").prop("readonly", true);
                        $("#percent_discount1").prop("readonly", true);
                        $("#pengajuan1").prop("hidden", true);
                    }
            }
        });
    });

    //memunculkan kolom pengajuan harga
    $('#colpengajuan1').hide(); //hide form ajukan harga
    $('#resetajuan1').hide(); //tombol reset di hide

    $('#pengajuan1').click(function () {
        // alert('ada pengajuan');
        $('#colpengajuan1').show();
        $('#resetajuan1').show();
        $('#pengajuan1').hide();

        $('.pengajuan').prop('checked', true);
    });

    $('#resetajuan1').click(function () {
        $('#colpengajuan1').hide();
        $('#resetajuan1').hide();
        $('#pengajuan1').show();
        document.getElementById('hrg_pengajuan1').value = '';

        $('.pengajuan').prop('checked', false);
    });

    $("#sku1").change(() => {
        var sku4 = $("#sku1").val();
        $.ajax({
            url: 'modal/GetHrgBot.php', // buat file selectData.php terpisah
            method: 'post',
            dataType: "json",
            data: {
                sku4: sku4
            },
            success: function (data) {
                // console.log(data);
                $("#HrgBot1").val(data[0]);
            }
        });
    });
    // perhitungan rumus
    $("#harga1").keyup(function () {

        var qty_brg = $("#qty1").val();
        var prc_disc = $("#percent_discount1").val();
        var nmn_disc = $("#nominal_discount1").val();
        var harga_brg = $("#harga1").val();
        var bool_ppn = $("#ppn1").is(':checked');
        var ppn = $("#ppn1").val();
        var harga_ppn = 0;
        var hasil = 0;
        var discount = 0;
        var amount = 0;

        if (bool_ppn) {
            amount = qty_brg * harga_brg;
            discount = nmn_disc;
            harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
        } else {
            harga_ppn = 0;

            amount = qty_brg * harga_brg;
            discount = nmn_disc;

            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
        }
        $("#hitungan_ppn1").val(harga_ppn);
        $("#amount1").val(amount);
        $("#nominal_discount1").val(discount);
        $("#harga_total1").val(hasil);


    });
    //harga_bawah
    $("#harga1").change(function () {
        var botprice = $('#HrgBot1').val();
        var harga_brg = $("#harga1").val();
        if (parseInt(harga_brg) < parseInt(botprice)) {
            swal.fire(
                'Ulangi!',
                'Harga Terlalu Rendah',
                'warning');
            $('#harga1').val('');
            $("#hitungan_ppn1").val(0);
            $("#amount1").val(0);
            $("#nominal_discount1").val(0);
            $("#harga_total1").val(0);
        }
    });
    $("#percent_discount1").keyup(function () {
        var qty_brg = $("#qty1").val();
        var prc_disc = $("#percent_discount1").val();
        var nmn_disc = $("#nominal_discount1").val();
        var harga_brg = $("#harga1").val();
        var bool_ppn = $("#ppn1").is(':checked');
        var ppn = $("#ppn1").val();
        var harga_ppn = 0;
        var hasil = 0;
        var amount = 0;
        var discount = 0;
        if (bool_ppn) {

            amount = qty_brg * harga_brg;
            discount = amount * (prc_disc / 100);
            harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
        } else {
            harga_ppn = 0;

            amount = qty_brg * harga_brg;
            discount = amount * (prc_disc / 100);

            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

        }
        $("#nominal_discount1").val(discount);
        $("#hitungan_ppn1").val(harga_ppn);
        $("#amount1").val(amount);
        $("#harga_total1").val(hasil);
    });
    $("#nominal_discount1").change(function () {
        $("#percent_discount1").val(0);
        $("#qty1").trigger("keyup");
    });
    $("#qty1").keyup(function () {
        var jenpro = $("#jenisPromo1").val();
        var qty_brg = $("#qty1").val();
        var min_qty = $("#qty_min1").val();  
        var prc_disc = $("#percent_discount1").val();
        var nmn_disc = $("#nominal_discount1").val();
        var harga_brg = $("#harga1").val();
        var bool_ppn = $("#ppn1").is(':checked');
        var diskon_tetap = $("#diskon_tetap1").val();
        var ppn = $("#ppn1").val();
        var harga_ppn = 0;
        var hasil = 0;
        var discount = 0;
        var amount = 0; 
        console.log(diskon_tetap);
        if (jenpro == 1) {
            // alert('1');
            if (bool_ppn) {
                amount = qty_brg * harga_brg;
                discount = amount * (prc_disc / 100);
                harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
                
                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;
                
                amount = qty_brg * harga_brg;
                discount = amount * (prc_disc / 100);
    
                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            }
        } else if (jenpro == 0) {
            // alert('2');
            if (bool_ppn) {
                amount = qty_brg * harga_brg;
                discount = nmn_disc;
                harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
    
                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;
    
                amount = qty_brg * harga_brg;
                discount = nmn_disc;
    
                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
    
            }
        } else if (jenpro == 2) {
            // alert('3');
            if (bool_ppn) {
                amount = qty_brg * harga_brg;
                rumus = Math.floor(qty_brg / min_qty);
                discount = diskon_tetap * rumus;
                harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;
                rumus = Math.floor(qty_brg / min_qty);
                amount = qty_brg * harga_brg;
                discount = diskon_tetap * rumus;
                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            }
        } 
        $("#hitungan_ppn1").val(harga_ppn);
        $("#amount1").val(amount);
        $("#harga_total1").val(hasil);
        $("#nominal_discount1").val(discount);  
    });

    $("#qty1").change(function () {
        var qty_brg = $("#qty1").val();
        var min_qty = $("#qty_min1").val(); 
        var nmn_disc = $("#nominal_discount1").val();
        // $("#nominal_discount1").val(rumus);
        if (parseInt(qty_brg) < parseInt(min_qty)) {
            swal.fire(
                'Ulangi!',
                'Qty Terlalu Rendah',
                'warning');
            $("#qty1").val(0);
            }
    });
    $("#ppn1").click(function () {
        var qty_brg = $("#qty1").val();
        var prc_disc = $("#percent_discount1").val();
        var nmn_disc = $("#nominal_discount1").val();
        var harga_brg = $("#harga1").val();
        var bool_ppn = $("#ppn1").is(':checked');
        var ppn = $("#ppn1").val();
        var harga_ppn = 0;
        var hasil = 0;
        var discount = 0;
        var amount = 0;
        if (bool_ppn) {
            amount = qty_brg * harga_brg;
            discount = nmn_disc;
            harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
        } else {
            harga_ppn = 0;

            amount = qty_brg * harga_brg;
            discount = nmn_disc;

            hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

        }
        $("#hitungan_ppn1").val(harga_ppn);
        $("#amount1").val(amount);
        $("#nominal_discount1").val(discount);
        $("#harga_total1").val(hasil);
    });
    // perhitungan rumus


    $("#customer").select2({
        ajax: {
            url: "modal/ajaxCustomer.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    $('.chosen-select-payment').select2({

    });
    $('.chosen-select-top').select2({

    });

    var index = 1;
    //add Form - Perulangan
    $(".tambah").click(function () {
        index++;
        var form = "form" + index;
        var sku = "sku" + index;
        var prdHarga = "prdHarga" + index;
        var HrgBot = "HrgBot" + index;
        var qty = "qty" + index;
        var harga = "harga" + index;
        var harga_total = "harga_total" + index;
        var ppn = "ppn" + index;
        var hitungan_ppn = "hitungan_ppn" + index;
        var amount = "amount" + index;
        var percent_discount = "percent_discount" + index;
        var nominal_discount = "nominal_discount" + index;
        var ket = "ket" + index;
        var dsopromo = "dsopromo" + index;
        var hrg_pengajuan = "hrg_pengajuan" + index;
        var jenispromo = "jenisPromo" + index;
        var diskon_tetap = "diskon_tetap" + index;
        var qtymin = "qty_min" + index;
        $(".main_form").append('<form id="' + (form) + '">' +
            '<div class="text-center label label label-danger">Item ' + index +
            '</div><div class="row"> ' +
            '<div class="col-sm-3"><div class="form-group"><label>SKU</label>' +
            '<select  name = "sku' +
            '" id = "' + (sku) + '" class="form-control chosen-select' + index + ' pilih" >' +
            '<option value = "" >--Pilih SKU OR Barcode--</option><div class="dropdown"></div> ' +
            '</select >' +
            '</div></div>' +
            '<div class="col-sm-2"><div class="form-group"><label>Harga Referensi</label>' +
            '<input type = "text"  placeholder="Harga Reff" name ="prdHarga" id = "' + (
                prdHarga) +
            '" class="form-control" readonly >' +
            '<input type = "hidden"   name ="HrgBot" id = "' + (
                HrgBot) +
            '" class="form-control" readonly >' +
            '</div></div>' +
            '<input type = "hidden" name = "qty_min" id = "' + (qtymin) + '" class="form-control" readonly >' +
            '<input type = "hidden" name = "jenisPromo" id = "' + (jenispromo) + '" class="form-control" readonly >' +
            '<input type = "hidden" name = "diskon_tetap" id= "' + (diskon_tetap) + '" class="form-control" readonly >' +
            '<div class="col-sm-4" id="sPromo' + index + '"><div class="form-group"><label for="">Promo</label>' +
            '<select name="dsopromo" id="' + (dsopromo) + '" class="form-control"></select>' + 
            '</div></div></div>' +



            '<div class="row"><div class="col-sm-2"><div class="form-group"><label>Qty</label>' +
            '<input type = "text"  placeholder="qty" class="form-control" name = "qty" id = "' +
            (qty) +
            '" / >' +
            '</div></div>' +

            '<div class="col-sm-2"><div class="form-group"><label>Harga</label>' +
            '<input type = "text"  placeholder="Harga" class="form-control" name = "harga" id = "' +
            (harga) + '" / >' +
            '</div></div>' +

            '<div class="col-sm-2"><div class="form-group"><label>Amount</label>' +
            '<input type = "text"  placeholder="amount" class="form-control" name = "amount" id = "' +
            (amount) + '" readonly / >' +
            '</div></div>' +


            '<div class="col-sm-1"><div class="form-group"><label>Disc(%)</label>' +
            '<input type="text" class="form-control" placeholder="%disc" value="0" name="percent_discount" id="' +
            (percent_discount) + '" />' +
            '</div></div>' +
            '<div class="col-sm-2"><div class="form-group"><label>Nom. Disc</label>' +
            '<input type="text" class="form-control" placeholder="Rp.disc" value="0" name="nominal_discount" id="' +
            (nominal_discount) + '" />' +
            '</div></div>' +

            '<div class="col-sm-1"><div class="form-group"><label> </label><div class="i-checks"><label><input type = "checkbox" id = "' +
            ppn +
            '" name = "ppn" value = "10" class="form-control"><i></i>PPN </label></div> <input type="hidden" name="hitungan_ppn" id="' +
            hitungan_ppn + '">' +
            '</div></div>' +
            '<div class="col-sm-2"><div class="form-group"><label>Harga Total</label>' +
            '<input type = "text"  placeholder="total" class="form-control" name ="harga_total" id = "' +
            (harga_total) + '" readonly>' +
            '</div></div>' +

            '<div class="col-sm-2"><div class="form-group"><label>Keterangan</label>' +
            '<input type = "text" placeholder="keterangan" class="form-control" name="ket" id = "' +
            (ket) + '">' +
            '</div></div>' +

            '<div class="col-sm-3" id="colpengajuan' + index +
            '"><div class="form-group"><label>Harga Pengajuan</label>' +
            '<input type="text" placeholder="Rp." class="form-control" name="hrg_pengajuan" id ="' +
            hrg_pengajuan + '">' +
            '</div></div>' +

            '<hr></div > <a class="btn btn-success btn-xs m-b-xs text-white" id="pengajuan' + index +
            '">Ajukan Harga</a> <a class="btn btn-warning btn-xs m-b-xs" id="resetajuan' +
            index + '">Reset</a></form></div></div>');

        //memunculkan kolom pengajuan harga
        $('#colpengajuan' + index).hide(); //hide form ajukan harga
        $('#resetajuan' + index).hide(); //tombol reset di hide

        $('#pengajuan' + index).click(function () {
            // alert('ada pengajuan');
            $('#colpengajuan' + index).show();
            $('#resetajuan' + index).show();
            $('#pengajuan' + index).hide();

            $('.pengajuan').prop('checked', true);
        });

        $('#resetajuan' + index).click(function () {
            $('#colpengajuan' + index).hide();
            $('#resetajuan' + index).hide();
            $('#pengajuan' + index).show();
            document.getElementById('hrg_pengajuan' + index).value = '';
        });
        //    generate dropdown
        $('.chosen-select' + index).select2({
            ajax: {
                url: 'modal/getSku.php',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchSku: params.term // search term
                    };
                },
                processResults: function (response) {
                    // console.log(response);
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        // masukan harga ketika memilih sku ke kolom harga
        for (let i = 1; i <= index; i++) {
            $("#sPromo" + index).hide();
            $("#sku" + i).change(() => {
                var sku4 = $("#sku" + i).val();
                $.ajax({
                    url: 'modal/getPrice.php',
                    method: 'post',
                    dataType: "json",
                    data: {
                        sku4: sku4
                    },
                    success: (data) => {
                        // console.log(data);
                        $("#prdHarga" + i).val(data[0]);
                    }
                });
                // get Data Promo from ajax => table promo
                $.ajax({
                    url: "modal/getPromo.php",
                    method: "POST",
                    data: {
                        id: sku4
                    },
                    success: (data) => {
                        $("#sPromo" + index).show();
                        $("#dsopromo" + index).html(data);
                        $("#dsopromo" + index).select2({
                            placeholder: "Pilih Nama Promo",
                            allowClear: true
                        });
                        $("#harga" + index).prop("readonly", false);
                        $("#percent_discount" + index).prop("readonly", false);
                        $("#nominal_discount" + index).prop("readonly", false);
                    }
                });
            });

            //On Change pada Select Promo
            $("#dsopromo" + index).change(() => {
                var xpromo = $("#dsopromo" + index).val();
                var id_promo = xpromo.split("|")[0];
                var jenis_pro = xpromo.split('|')[1];
                $("#jenisPromo" + index).val(jenis_pro); //jenis promo 
                var id_sku = $("#sku" + index).val();
                // alert('work');
                $.ajax({
                    method: "POST",
                    url: "modal/getPromoDtl.php",
                    dataType: "JSON",
                    data: {
                        id: id_promo,
                        sku: id_sku
                    },
                    success: (data) => {
                        var hsl = data;
                        var min_req = parseInt(hsl.qty_min);
                        switch (jenis_pro){
                            case '0':
                                $("#prdHarga" + index).val(hsl.hargadef);
                                $("#harga" + index).val(hsl.harga_disc);
                                
                                $("#harga" + index).prop("readonly", true);
                                $("#percent_discount" + index).prop("readonly", true);
                                $("#nominal_discount" + index).prop("readonly", true);
                                $("#pengajuan" + index).prop("hidden", true);
                            break;
                            case '1': 
                                $("#prdHarga" + index).val(hsl.hargadef);
                                $("#harga" + index).val(hsl.hargadef);
                                $("#percent_discount" + index).val(hsl.disc_percent);
                                $("#qty_min" + index).val(hsl.qty_min);
        
                                $("#harga" + index).prop("readonly", true);
                                $("#percent_discount" + index).prop("readonly", true);
                                $("#nominal_discount" + index).prop("readonly", true);
                                $("#pengajuan" + index).prop("hidden", true);
                            break; 
                            case '2':
                                $("#prdHarga" + index).val(hsl.hargadef);
                                $("#harga" + index).val(hsl.hargadef);
                                $("#qty_min" + index).val(hsl.qty_min); 
                                $("#diskon_tetap" + index).val(hsl.discount);
                                $("#harga" + index).prop("readonly", true);
                                $("#nominal_discount" + index).prop("readonly", true);
                                $("#percent_discount" + index).prop("readonly", true);
                                $("#pengajuan" + index).prop("hidden", true);
                        }

                        // $("#prdHarga" + index).val(hsl.hargadef);
                        // $("#harga" + index).val(hsl.harga_disc); 

                        // $("#harga" + index).prop("readonly", true);
                        // $("#percent_discount" + index).prop("readonly", true);
                        // $("#nominal_discount" + index).prop("readonly", true);
                    }
                });
            });

            // harga batas bawah ketika memilih sku
            $("#sku" + i).change(() => {
                var sku4 = $("#sku" + i).val();
                $.ajax({
                    url: 'modal/GetHrgBot.php', // buat file selectData.php terpisah
                    method: 'post',
                    dataType: "json",
                    data: {
                        sku4: sku4
                    },
                    success: function (data) {
                        // console.log(data);
                        $("#HrgBot" + i).val(data[0]);
                    }
                });
            });

            // perhitungan rumus
            $("#harga" + i).keyup(function () {
                var qty_brg = $("#qty" + i).val();
                var prc_disc = $("#percent_discount" + i).val();
                var nmn_disc = $("#nominal_discount" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;
                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amount" + i).val(amount);
                $("#harga_total" + i).val(hasil);
                $("#nominal_discount" + i).val(discount);
            });
            $("#percent_discount" + i).keyup(function () {
                var qty_brg = $("#qty" + i).val();
                var prc_disc = $("#percent_discount" + i).val();
                var nmn_disc = $("#nominal_discount" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var amount = 0;
                var discount = 0;
                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = amount * (prc_disc / 100);
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = amount * (prc_disc / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#nominal_discount" + i).val(discount);
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amount" + i).val(amount);
                $("#harga_total" + i).val(hasil);
            });
            $("#nominal_discount" + i).change(function () {
                $("#percent_discount" + i).val(0);
                $("#qty" + i).trigger("keyup");
            });
            $("#qty" + i).keyup(function () {
                var jenpro = $("#jenisPromo" + i).val();
                var qty_brg = $("#qty" + i).val();
                var min_qty = $("#qty_min" + i).val(); 
                var prc_disc = $("#percent_discount" + i).val();
                var nmn_disc = $("#nominal_discount" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;
                var rumus = 0;
                var diskon_tetap = $("#diskon_tetap" + i).val();
                console.log(diskon_tetap);
                if (jenpro == 1) {
                    // alert('1');
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = amount * (prc_disc / 100);
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
                        
                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;
                        
                        amount = qty_brg * harga_brg;
                        discount = amount * (prc_disc / 100);
            
                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    }
                } else if (jenpro == 0) {
                    // alert('2');
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
            
                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;
            
                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
            
                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            
                    }
                }  else if (jenpro == 2) {
                    // alert('3');
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        rumus = Math.floor(qty_brg / min_qty);
                        discount = diskon_tetap * rumus;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);
                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;
                        rumus = Math.floor(qty_brg / min_qty);
                        amount = qty_brg * harga_brg;
                        discount = diskon_tetap * rumus;
                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    }
                } 
                // if (bool_ppn) {

                //     amount = qty_brg * harga_brg;
                //     discount = nmn_disc;
                //     harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                //     hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                // } else {
                //     harga_ppn = 0;

                //     amount = qty_brg * harga_brg;
                //     discount = nmn_disc;

                //     hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                // }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amount" + i).val(amount);
                $("#harga_total" + i).val(hasil);
                $("#nominal_discount" + i).val(discount);
            });
            $("#qty" + index).change(function () {
                var qty_brg = $("#qty" + index).val();
                var min_qty = $("#qty_min" + index).val(); 
                if (parseInt(qty_brg) < parseInt(min_qty)) {
                    swal.fire(
                        'Ulangi!',
                        'Qty Terlalu Rendah',
                        'warning');
                    $("#qty" + index).val(0);
                    }
            });
            $("#ppn" + i).click(function () {
                var qty_brg = $("#qty" + i).val();
                var prc_disc = $("#percent_discount" + i).val();
                var nmn_disc = $("#nominal_discount" + i).val();
                var harga_brg = $("#harga" + i).val();
                var bool_ppn = $("#ppn" + i).is(':checked');
                var ppn = $("#ppn" + i).val();
                var harga_ppn = 0;
                var hasil = 0;
                var discount = 0;
                var amount = 0;
                if (bool_ppn) {
                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;
                    harga_ppn = ((qty_brg * harga_brg) - discount) * (11 / 100);

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                } else {
                    harga_ppn = 0;

                    amount = qty_brg * harga_brg;
                    discount = nmn_disc;

                    hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                }
                $("#hitungan_ppn" + i).val(harga_ppn);
                $("#amount" + i).val(amount);
                $("#harga_total" + i).val(hasil);
                $("#nominal_discount" + i).val(discount);
            });
            //harga_bawah
            $("#harga" + i).change(function () {
                var botprice = $('#HrgBot' + i).val();
                var harga_brg = $("#harga" + i).val();
                if (parseInt(harga_brg) < parseInt(botprice)) {
                    swal.fire(
                        'Ulangi!',
                        'Harga Terlalu Rendah',
                        'warning');
                    $('#harga' + i).val('');
                    $("#hitungan_ppn" + i).val(0);
                    $("#amount" + i).val(0);
                    $("#nominal_discount" + i).val(0);
                    $("#harga_total" + i).val(0);
                }
            });
        }
    });
    $(".simpan").click(() => {
        var formHeader = $("#formHeader").serializeArray();
        var top = $('#top').val();
        var u_input = $('#sales').val();
        var customer = $('#customer').val();
        var tgl = $('#tanggal').val();
        var alamat_kirim = $('#alamatKirim').val();
        var jenis_perusahaan = $('#jenisPerusahaan').val();
        var stat = $('#statcust').val();
        var jTrans = $('#jTrans').val();
        var top = $('#top').val();
        if (customer == '' || tgl == '' || alamat_kirim == '' || jenis_perusahaan == '' || stat == '' || jTrans == '' || top == '') {
            swal.fire(
                'Gagal!',
                'Lengkapi Form Header',
                'warning'
            );
        } else {
            // kirim ke header
            $.ajax({
                method: "POST",
                url: "modal/datapo_hdr.php",
                data: formHeader,
                success: function (data) {
                    var id_po = data.split("|")[0];
                    var namacustomer = data.split("|")[1];
                    // console.log(id_po);
                    for (var i = 1; i <= index; i++) {
                        var jTrans = $("#jTrans").val();
                        var form = $('#form' + (i)).serializeArray();
                        form.push({
                            name: "jTrans",
                            value: jTrans
                        });
                        form.push({
                            name: "nopo",
                            value: id_po
                        });
                        form.push({
                            name: "no_urut",
                            value: i
                        });
                        // console.log(form);
                        $.ajax({
                            method: "POST",
                            url: "modal/datapo_dtl.php",
                            data: form,
                            success: function (data) {
                                console.log(data);
                            }
                        });
                    }
                    // console.log(data);
                    swal.fire(
                        'Sukses',
                        'Data berhasil ditambahkan',
                        'success'
                    );
                    var pj = $('.pengajuan').is(':checked');
                    if (pj) {
                        xpj = 'Ada Pengajuan Harga'
                    } else {
                        xpj = 'Tidak Ada Pengajuan Harga'
                    }
                    var url =
                        'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                    var chat_id = ["-759758736", "-1001704848872"];
                    var text = "== ADA PO BARU ==\n" +
                        "Nama Customer : <i>" + namacustomer + "</i>\n" +
                        "No. PO : <i>" + id_po + "</i>\n" +
                        "Nama Sales : <i>" + u_input + "</i>\n" +
                        "Term : <b>" + top + "</b>\n" +
                        "Produk : <b>" + index + "</b> SKU\n" +
                        "Keterangan : <b>" + xpj + "</b>";
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
                        // your code to be executed after 1 second
                        var lvl = $('#lvl').val();
                        if (lvl !== "sales") {
                            location.assign(
                                "datapo.php");
                        } else {
                            location.assign(
                                "dataposales.php");
                        }
                    },
                        5000);
                }
            });
        }
    });
});