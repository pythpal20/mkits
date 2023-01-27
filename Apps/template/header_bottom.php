<?php
    if($data['modul'] == '1') { //danger
    $color="background-color:#dc3545;";}
    else if($data['modul'] == '2') {  //warning
    $color="background-color:#f8ac59;"; }
    else if($data['modul'] == '3') { //info
    $color="background-color:#17a2b8;"; }
    else if($data['modul'] == '4') { //succes
    $color="background-color:#1ab394;"; }
    else if($data['modul'] == '5') { //primary
    $color="background-color:#1c84c6"; }
?>

<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0; <?= $color?>;">
        <div class="navbar-header">
            <a style="<?=$color?>;color:white;" class="navbar-minimalize minimalize-styl-2 btn " href="#"><i
                    class="fa fa-bars"></i> </a>
            <a href="#" class="navbar-brand">
                <img src="../img/system/mkc2.png" height="48" width="120" alt="CoolBrand">
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li style="padding: 20px">
                <span class="m-r-sm text-white welcome-message">MKITS (Mr. Kitchen Integrated System)</span>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>
                    <?php if($data['modul'] == '2'): ?>
                    <span class="label label-primary" id="aklabel"></span>
                    <?php endif; ?>
                    <?php if($data['modul'] == '3'): ?>
                    <span class="label label-primary" id="sqlqty"></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </nav>
</div>