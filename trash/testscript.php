<?php


if (move_uploaded_file($_FILES['filename']['tmp_name'], 'files/'.$_FILES['filename']['name'])){
    echo'файл скоприован';
}else{
    echo 'файл не скопирован';
}
