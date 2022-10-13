<?php

/*
echo "<pre style='text-align: left'>";
//var_dump($_FILES);
//var_dump($_POST);

echo "</pre>";*/


session_start();
$_SESSION[1] = $_POST['Печать'];
//$FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $j;
//$FILE_ID = $FILE_ID . $_POST['order_num'];
/*

/*
if (!is_dir($FILE_ID)) {
    mkdir($FILE_ID, 0777, true);
}
$FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $j . "/";
for ($i = 0; $i < count($_FILES); $i++) {
    move_uploaded_file($_FILES['print_file_1_' . $i]['tmp_name'], $FILE_ID . $_FILES['print_file_1_' . $i]['name']);
}*/
?>