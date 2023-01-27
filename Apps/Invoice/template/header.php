<?php if (isset($_SESSION['moduls']) || $_SESSION['moduls'] != '6') { ?>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold"><?php echo $data['user_nama']; ?></span>
                            <span class="text-muted text-xs block">
                                <?php
                                if ($data['modul'] == '1') {
                                    $mdl = "SM";
                                    $warna = "danger";
                                    $modl = "Sales dan Marketing";
                                } elseif ($data['modul'] == '2') {
                                    $mdl = "AK";
                                    $warna = "warning";
                                    $modl = "Akunting & Finance";
                                } elseif ($data['modul'] == '3') {
                                    $mdl = "ADM";
                                    $warna = "info";
                                    $modl = "Admin dan Penjualan";
                                } elseif ($data['modul'] == '4') {
                                    $mdl = "WRH";
                                    $warna = "primary";
                                    $modl = "Warehouse";
                                } elseif ($data['modul'] == '5') {
                                    $mdl = "DLV";
                                    $warna = "success";
                                    $modl = "Delivery";
                                }
                                ?>
                                <?php echo $data['level'] . ' | <span class="label label-' . $warna . '" rel="tooltip" title="Modul ' . $modl . '">' . $mdl . '</span>'; ?>
                            </span>
                        </a>
                    </div>
                    <div class="logo-element">
                        <div style="height: 30px; width: 30px; background-color: #dd0000; border-radius: 50%; display: inline-block;">SO</div>
                    </div>
                </li>
                <li id="dashboard">
                    <a href="../dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <?php if ($data['modul'] == '1') : ?>
                    <!-- MODUL 1 = SALES & MARKETING -->
                    <li id="master" class="">
                        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Master</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php if ($data['level'] != 'sales') { ?>
                                <li id="mastercustomer"><a href="../customer.php">Customer</a></li>
                            <?php } ?>
                            <li id="masterarea"><a href="../area.php">Data Area</a></li>
                            <li id="masterproduk"><a href="../masterproduk.php">Data Item</a></li>
                            <li id="bundlePromotion"><a href="../promoBundling.php">Promo <span class="label label-info float-right">New!</span></a></li>
                        </ul>
                    </li>
                    <li id="order">
                        <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Data Order</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php if ($data['level'] !== 'sales') : ?>
                                <li id="purchaseorder"><a href="../datapo.php" rel="tooltip" title="Data SCO Dan Buat PO">Data Order</span> <label id="x"></label></a></li>
                                <li>
                                    <a href="#">Pick Ticket Sample <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li id="samplerequest"><a href="../datasample.php">Pengajuan</a></li>
                                        <li id="pengajuan"><a href="../RptAktual.php">Aktual</a></li>
                                    </ul>
                                </li>
                            <?php endif ?>
                            <!-- =============== -->
                            <?php if ($data['level'] == 'sales') : ?>
                                <li id="purchaseorder"><a href="../dataposales.php" rel="tooltip" title="Data SCO Dan Buat PO">Data PO</a></li>
                                <li id="samplerequest"><a href="../datasample.php">Req. Sample</a></li>
                            <?php endif ?>
                        </ul>
                    </li>
                    <li id="fpp">
                        <!-- fpp -->
                        <?php if ($data['level'] !== 'sales') : ?>
                            <a href="../datafpp.php"><i class="fa fa-folder-open"></i> <span class="nav-label">Data
                                    FPP</span></a>
                        <?php endif; ?>
                        <?php if ($data['level'] == 'sales') : ?>
                            <a href="../datafppsales.php"><i class="fa fa-folder-open"></i> <span class="nav-label">My
                                    FPP</span></a>
                        <?php endif; ?>
                    </li>
                    <?php if ($data['level'] == 'superadmin' || $data['level'] == 'admin') { ?>
                        <li id="" class="">
                            <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">Keep Stock</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li id="dbkeeps"><a href="../dashboardQtyKeepstock.php">Info Stock</a></li>
                                <li id="dbkeep"><a href="../list_keep_stock.php">Data Keep Stock</a></li>
                                <li><a href="../list_so_mau_keep.php">Data Order</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- delivery admin sales -->
                    <?php if ($data['level'] != "guest") { ?>
                        <li id="tbldelivery" class="">
                            <a href="#"><i class="fa fa-paper-plane"></i> <span class="nav-label">Delivery</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li id="table_co_deliv"><a href="../list_co_sudah_delivery_sales.php">Info Delivery</a></li>
                                <li id="table_co_delivall"><a href="../list_co_deliveryall.php">Co-Delivery</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($data['level'] == 'admin' || $data['level'] == 'superadmin') { ?>
                        <li>
                            <a href="#"><i class="fa fa-exchange"></i> <span class="nav-label">Kunjungan</span><span class="fa arrow"></span> <label class="label label-info pull-right">NEW</label> </a>
                            <ul class="nav nav-second-level">
                                <li id="bankData"><a href="../tempcustomer.php">Temp. Customer</a></li>
                                <li id="FormAndData"><a href="../kunjungan.php">Form & Data Kunjungan</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($data['level'] != "sales") { ?>
                        <li id="billing" class=""><a href="../billing.php"><i class="fa fa-database"></i> <span class="nav-label">Info Penagihan</span></a></li>
                    <?php } ?>
                    <!--delivery admin sales -->
                <?php endif; ?>
                <!-- END OF MODUL 1 -->

                <?php if ($data['modul'] == '2') { ?>
                    <!-- MODUL 2 = AKUNTING & FINANCE -->
                    <?php if ($data['user_nama'] == 'Myrahw' || $data['user_nama'] == 'Stephanie') { ?>
                        <li id="tagihan" class="">
                            <a href="../tagihanharian.php"><i class="fa fa-dollar"></i> <span class="nav-label">Setoran</span></a>
                        </li>
                    <?php } ?>
                    <li id="mastercustomer"><a href="../customer_ak.php"><i class="fa fa-book"></i> <span class="nav-label">Master Customer</span></a></li>
                    <li id="soaprove">
                        <a href="../cek_ar.php"><i class="fa fa-credit-card"></i> <span class="nav-label">Check &
                                Approval</span></a>
                    </li>
                    <li id="masterco"><a href="../orderak.php"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Change Method CO</span></a></li>
                    <li id="slm" class="">
                        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Sales Marketing</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="sco" class=""><a href="../mastersco.php">Data SCO</a></li>
                            <li>
                                <a href="#">Pick Ticket Sample <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li id="samplerequest"><a href="../datapts.php">Pengajuan</a></li>
                                    <li id="pengajuan"><a href="../RptAktual.php">Aktual</a></li>
                                </ul>
                            </li>
                            <li id="fpp" class=""><a href="../masterfpp.php">Data FPP</a></li>
                        </ul>
                    </li>
                    <li id="delivery" class="">
                        <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Delivery</span> <span class="label label-warning">Beta</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="table_co_deliv">
                                <a href="../list_co_sudah_delivery_fa.php">Info Delivery</a>
                            </li>
                            <li id="table_co_delivall">
                                <a href="../list_co_deliveryall.php">Co-Delivery</a>
                            </li>
                        </ul>
                    </li>
                    <li id="penagihan">
                        <a href="../list_penagihan.php"><i class="fa fa-dollar"></i> <span class="nav-label">Penagihan </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Inv. Berjalan<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li id="invmwk"><a href="InvMwk.php">PT. MWK</a></li>
                                    <li id="invmwm"><a href="InvMwm.php">PT. MWM</a></li>
                                    <li id="invbak"><a href="InvBak.php">PT. BAK</a></li>
                                    <li id="invfci"><a href="InvFci.php">PT. FCI</a></li>
                                    <li id="invdtm"><a href="InvDtm.php">PT. DTM</a></li>
                                </ul>
                            </li>
                            <!-- <li id="PenagihanBerjalan"><a href="list_penagihanjalan.php">Berjalan</a></li> -->
                            <li id="PenagihanSelesai"><a href="../list_penagihanlunas.php">Lunas (Selesai)</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END OF MODUL 2 -->
                <?php if ($data['modul'] == '3') { ?>
                    <!-- MODUL 3 = ADMIN PENJUALAN -->
                    <li id="mastercustomer"><a href="../customer_ak.php"><i class="fa fa-book"></i> <span class="nav-label">Master Customer</span></a></li>
                    <li id="tabelSco">
                        <a href="../scomasuk.php"><i class="fa fa-shopping-cart"></i> <span class="nav-label">SCO Masuk</span>
                        </a>
                    </li>
                    <li id="table_co_delivall">
                        <a href="../list_co_deliveryall.php"><i class="fa fa-truck"></i> <span class="nav-label">Co-Delivery</span>
                        </a>
                    </li>
                    <li id="datafix">
                        <a href="../orderfix.php"><i class="fa fa-database"></i> <span class="nav-label">Data Order CO</span></a>
                    </li>
                    <li id="samplerequest">
                        <a href="../dataptsadm.php"><i class="fa fa-ticket"></i> <span class="nav-label">Req. Sample</span><label id="x"></label></a>
                    </li>
                    <li id="penagihan">
                        <a href="../list_penagihan.php"><i class="fa fa-dollar"></i> <span class="nav-label">Penagihan </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="invmwk"><a href="penagihan_mwk.php">PT. MWK</a></li>
                            <li id="invmwm"><a href="penagihan_mwm.php">PT. MWM</a></li>
                            <li id="invbak"><a href="penagihan_bak.php">PT. BAK</a></li>
                            <li id="invfci"><a href="penagihan_fci.php">PT. FCI</a></li>
                            <li id="invdtm"><a href="penagihan_dtm.php">PT. DTM</a></li>
                        </ul>
                    </li>
                    <?php if ($data['level'] == 'admin' || $data['level'] == 'superadmin') { ?>
                        <li>
                            <a href="#"><i class="fa fa-exchange"></i> <span class="nav-label">Kunjungan</span><span class="fa arrow"></span> <label class="label label-info pull-right">NEW</label> </a>
                            <ul class="nav nav-second-level">
                                <li id="bankData"><a href="../tempcustomer.php">Temp. Customer</a></li>
                                <li id="FormAndData"><a href="../kunjungan.php">Form & Data Kunjungan</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li id="slm" class="">
                        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">SCO dan FPP</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="sco" class=""><a href="../mastersco.php">Data SCO</a></li>
                            <li id="fpp" class=""><a href="../masterfpp.php">Data FPP</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- END OF MODUL 3 -->
                <?php if ($data['modul'] == '4') { ?>
                    <!-- MODUL 4 = WAREHOUSE -->
                    <li id="">
                        <a href="#">
                            <i class="fa fa-paper-plane-o"></i> <span class="nav-label">Pick Ticket Sample</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li id="ptsamplesm"><a href="../datasamplewrh.php">Pengajuan PTS</a></li>
                            <li id="ptsampleakt"><a href="../datasampleaktual.php">Aktual PTS</a></li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="#"><i class="fa fa-ticket"></i> <span class="nav-label">Keep Stock</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="keepstock_sales">
                                <a href="../dashboardQtyKeepstock.php">
                                    Dashboard
                                </a>
                            </li>
                            <li id="tabelKeepStok">
                                <a href="../list_keep_stock.php">List Keep Stock
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!-- Modul 4 = Warehouse -->
                <?php if ($data['modul'] == '4') { ?>

                    <?php if ($data['user_nama'] == 'cecep nurhidayat' || $data['user_nama'] == 'alif IT') { ?>
                        <li id="tagihan" class="">
                            <a href="../tagihanharian.php"><i class="fa fa-dollar"></i> <span class="nav-label">Setoran</span></a>
                        </li>
                    <?php } ?>
                    <li id="delivery" class="">
                        <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Delivery</span> <span class="label label-warning">Beta</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="table_co_deliv">
                                <a href="../list_co_sudah_delivery_gudang.php">Delivery
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- END OF MODUL 4 -->
                <!-- MODUL 5 = DELIVERY -->

                <?php if ($data['modul'] == '5') { ?>

                    <?php if ($data['user_nama'] == 'Paulus Christofel S (MKITS Developer)' || $data['user_nama'] == 'Ari Sugara') { ?>
                        <li id="tagihan" class="">
                            <a href="../tagihanharian.php"><i class="fa fa-dollar"></i> <span class="nav-label">Setoran</span></a>
                        </li>
                    <?php } ?>
                    <li id="delivery" class="">
                        <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Delivery</span> <span class="label label-warning">Beta</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="table_co">
                                <a href="../list_co_delivery.php">
                                    CO
                                </a>
                            </li>
                            <li id="table_co_deliv">
                                <a href="../list_co_sudah_delivery.php">Delivery
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- END OF MODUL 4 -->

                <!-- ALL MODUL CAN SEE -->
                <li>
                    <a href="#"><i class="fa fa-info"></i> <span class="nav-label">Info & Monitoring</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li id="status_sco"><a href="../infosco.php">Status SCO</a></li>
                        <li id="monitoring"><a href="../infomonitoring.php">Status BL</a></li>
                    </ul>
                <li id="akun">
                    <a href="../user.php"><i class="fa fa-user"></i> <span class="nav-label">Data User</span></a>
                </li>
                <li>
                    <a href="../logout.php"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
                </li>

            </ul>
        </div>
    </nav>
<?php } else { ?>
    <p>Tidak ada akses</p>
<?php } ?>