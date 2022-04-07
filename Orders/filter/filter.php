<?php


if ($_GET['status'] == "1"){
    $status = NULL;
}else{
    $status = $_GET['status'];
}
if ($_GET['view'] == "1"){
    $view = NULL;
}else{
    $view = $_GET['view'];
}

if ($_GET['numorder'] == ""){
    $numorder = NULL;
}else{
    $numorder = $_GET['numorder'];
}
if ($_GET['nameorder'] == ""){
    $nameorder = NULL;
}else{
    $nameorder = $_GET['nameorder'];
}
if ($_GET['date'] == ""){
    $date = NULL;
}else{
    $date = $_GET['date'];
}