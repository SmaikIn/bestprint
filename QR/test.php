<?php
require_once 'phpqrcode/qrlib.php';
$u_id = "User ".$_POST['id'];
$file_constant = "employeeQR/".$u_id.".png";
QRcode::png($u_id,$file_constant,'H',8);
?>