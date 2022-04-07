



<?php
/*
ob_start ();
require 'FPDF/fpdf.php';
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
ob_end_flush();*/
?>
<?php

require 'config/config.php';
$id = 1093;
$handle = fopen("2.txt", "r");
while (!feof($handle)) {
    $buffer =  fgets($handle, 4096);
    if ($buffer  "NULL"){
    echo $id;
    }
    /*if ($buffer == "NULL"){
       //        $buffer = NULL;
        echo $buffer;
    }else{
        echo "UPDATE `orders` SET `dateStart`= '$buffer' WHERE `id`='$id'";
        echo "<br>";
    }*/

    //mysqli_query($connect, "INSERT INTO `orders`(`id`, `castomer`, `address`, `contact`, `addCoditions`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Picture`, `Result`) VALUES (NULL,'$buffer',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)");
   // echo "INSERT INTO `orders`(`id`, `castomer`, `address`, `contact`, `addCoditions`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Picture`, `Result`) VALUES (NULL,'$buffer',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);";



    $id++;
    //$i++;
    //if ($i==1000){break;}
}
fclose($handle);
/*

for ($id = 884; $id<1092;$id++){
    mysqli_query($connect, "DELETE FROM `orders` WHERE `orders`.`id` = '$id'");
}
*/

?>