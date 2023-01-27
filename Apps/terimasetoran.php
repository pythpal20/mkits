<?php
// var_dump($_POST);
// die();
if (isset($_POST['id'])) {
    include '../../config/connection.php';
    $id = date_format(date_create($_POST['id']), 'Y-m-d');
    $sopir = $_POST['sopir'];
    $kenek = $_POST['kenek'];

    $output = '';

    $tgl = '%' . $id . '%';
    $query = "SELECT  a.tgl_delivery,
	    a.sopir, 
	    a.kenek,
        SUM(b.harga_total) AS nomAkhir,
        (SELECT SUM(nominal_diterima) FROM tb_setoran WHERE tgl_delivery = '$id' AND sopir='$sopir' GROUP BY tgl_delivery) AS setoran
    FROM customerorder_hdr_delivery a
    JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
    JOIN salesorder_hdr c ON a.noso = c.noso
    WHERE a.sopir LIKE '$sopir' AND a.kenek LIKE '$kenek' AND (DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d') = '$id') AND c.term  LIKE 'Cash On Delivery'
    GROUP BY DATE_FORMAT(a.tgl_delivery, '%Y-%m-%d');";
    $pcs = $db1->prepare($query);
    $pcs->execute();
    $resl = $pcs->get_result();
    $row = $resl->fetch_assoc();

    $output .= '<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Input setoran</h5>
    </div>
    <div class="panel-body">
        <form id="InputSetoran">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Nominal Akhir</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Rp.
                            </span>
                            <input type="text" class="form-control" name="" id=""
                                value="' . number_format($row["nomAkhir"], 0, ",", ".") . '" readonly>
                            <input type="hidden" class="form-control" name="nomterima" id="nomterima"
                                value="' . $row["nomAkhir"] . '" readonly>
                            <input type="hidden" id="tglKirim" name="tglKirim" value="' . $id . '">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Total sudah setor</label>
                        <input type="text" class="form-control" name="" id="" value="' . 'Rp. ' . number_format($row["setoran"], 0, ",", ".") . '"
                            readonly>
                        <input type="hidden" class="form-control" name="setoran" id="setoran" value="' . $row["setoran"] . '"
                            readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Sisa</label>
                        <input type="text" class="form-control" name="sisa" id="sisa" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Sopir</label>
                        <input type="text" class="form-control" name="sopir" id="sopir" value="' . $row["sopir"] . '" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="">Kenek</label>
                        <input type="text" class="form-control" name="kenek" id="kenek" value="' . $row["kenek"] . '" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label>Jumlah Diterima</label>
                    <input type="text" class="form-control" id="JDiterima" name="JDiterima" placeholder="RP. ">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" style="height:75px"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>';
}
echo $output;