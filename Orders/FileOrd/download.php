<?php
session_start();
$ord_id = $_GET['ord_id'];
$id = $_GET['id'];
$str = "../../files/File_ORD/" . $ord_id;
$scandir = scandir($str);
if(isset($_SESSION)){
    for($i = 2; $i<count($scandir); $i++){
        header();
    }
}else{
    for ($i = 2; $i < count($scandir); $i++) {
        $str = "../../../files/File_ORD/" . $ord_id . "/" . $scandir[$i];
        $_SESSION[$i] = $str;
    }

}