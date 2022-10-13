<?php
session_start();
$id = $_GET['id'];


if ($_GET['block_print'] == "off") {
    $_SESSION['block_print'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_print']; $k++) {
        $dateValue = $k;
        $dateValue = $dateValue . " date print_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time print_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask print_order";

        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_print'] = 0;
}
if ($_GET['block_print'] == "on") {
    $_SESSION['block_print'] = "on";
    $_SESSION['cnt_order_print'] = 1;

}
if ($_GET['cnt_order_print'] == "delete") {

    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date print_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time print_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask print_order";

    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_print']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_print']; $k++) {
            $dateValue = $k . " date print_order";
            $timeValue = $k . " time print_order";
            $techtaskValue = $k . " techtask print_order";
            $z = $k + 1;
            $dateValue2 = $z . " date print_order";
            $timeValue2 = $z . " time print_order";
            $techtaskValue2 = $z . " techtask print_order";

            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_print']) {
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
            }


        }
    }
    $_SESSION['cnt_order_print']--;

} else {
    if (isset($_GET['cnt_order_print'])) {
        if ($_GET['cnt_order_print'] != 0) {
            if ($_GET['cnt_order_print'] < $_SESSION['cnt_order_print']) {
                for ($i = $_GET['cnt_order_print'] + 1; $i <= $_SESSION['cnt_order_print']; $i++) {
                    $dateValue = $i;
                    $dateValue = $dateValue . " date print_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time print_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask print_order";

                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);


                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_print'] = $_GET['cnt_order_print'];
            } else {
                $_SESSION['cnt_order_print'] = $_GET['cnt_order_print'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_print
if ($_POST['save_print'] == 1) {
    $array = $_POST['Печать'];
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date print_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time print_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask print_order";
    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_PRINT_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_PRINT_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
        for ($i = 0; $i < count($control_files); $i++) {
            if ($control_files[$i] == "false") {
                $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
                if ($control_files[$i] == "false") {
                    echo "<h1> Ошибка загрузки файла: {$_FILES[$i]['tmp_name']} </h1>";
                }
            }
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        if ($dir[$i])
            ?>
            <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
        style="width: 550px;display: flex; justify-content: center; text-align: center;">
        <input class="form-control"
               style="text-align: center; width: 50px;"
               disabled
               value="<?= $i - 1 ?>">
        <input type="text" style="width: 400px;  text-align: center;"
               class="form-control"
               value="<?= $dir[$i] ?>"
               disabled>
        <a class="btn btn-outline-danger"
           href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=print">
            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                 height="16"
                 fill="currentColor" class="bi bi-x-octagon-fill"
                 viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
            </svg>
        </a>
        </div>
        <?
    }


}//Сохранение данных block_print
if ($_GET['file_type'] == 'print') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PRINT_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_print

if ($_GET['block_frez'] == "off") {
    $_SESSION['block_frez'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_frez']; $k++) {
        $dateValue = $k;
        $dateValue = $dateValue . " date frez_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time frez_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask frez_order";
        $select_material = $k;
        $select_material = $select_material . " select_material frez_order";
        $select_thickness = $k;
        $select_thickness = $select_thickness . " select_thickness frez_order";
        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);
        unset($_SESSION[$select_material]);
        unset($_SESSION[$select_thickness]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_frez'] = 0;
}
if ($_GET['block_frez'] == "on") {
    $_SESSION['block_frez'] = "on";
    $_SESSION['cnt_order_frez'] = 1;

}
if ($_GET['cnt_order_frez'] == "delete") {

    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date frez_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time frez_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask frez_order";
    $select_material = "";
    $select_material = $select_material . $_POST['order_num'];
    $select_material = $select_material . " select_material frez_order";
    $select_thickness = "";
    $select_thickness = $select_thickness . $_POST['order_num'];
    $select_thickness = $select_thickness . " select_thickness frez_order";
    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);
    unset($_SESSION[$select_material]);
    unset($_SESSION[$select_thickness]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_frez']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_frez']; $k++) {
            $dateValue = $k . " date frez_order";
            $timeValue = $k . " time frez_order";
            $techtaskValue = $k . " techtask frez_order";
            $select_material = $k . " select_material frez_order";
            $select_thickness = $k . " select_thickness frez_order";
            $z = $k + 1;
            $dateValue2 = $z . " date frez_order";
            $timeValue2 = $z . " time frez_order";
            $techtaskValue2 = $z . " techtask frez_order";
            $select_material2 = $z . " select_material frez_order";
            $select_thickness2 = $z . " select_thickness frez_order";

            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];
            $_SESSION[$select_material] = $_SESSION[$select_material2];
            $_SESSION[$select_thickness] = $_SESSION[$select_thickness2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_frez']) {
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
                unset($_SESSION[$select_material2]);
                unset($_SESSION[$select_thickness2]);
            }


        }
    }
    $_SESSION['cnt_order_frez']--;

} else {
    if (isset($_GET['cnt_order_frez'])) {
        if ($_GET['cnt_order_frez'] != 0) {
            if ($_GET['cnt_order_frez'] < $_SESSION['cnt_order_frez']) {
                for ($i = $_GET['cnt_order_frez'] + 1; $i <= $_SESSION['cnt_order_frez']; $i++) {
                    $dateValue = $i;
                    $dateValue = $dateValue . " date frez_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time frez_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask frez_order";
                    $select_material = $i;
                    $select_material = $select_material . " select_material frez_order";
                    $select_thickness = $i;
                    $select_thickness = $select_thickness . " select_thickness frez_order";

                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);
                    unset($_SESSION[$select_material]);
                    unset($_SESSION[$select_thickness]);

                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_frez'] = $_GET['cnt_order_frez'];
            } else {
                $_SESSION['cnt_order_frez'] = $_GET['cnt_order_frez'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_frez

if ($_POST['save_frez'] == 1) {
    $array = $_POST['Фрезеровка'];
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date frez_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time frez_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask frez_order";
    $select_material = "";
    $select_material = $select_material . $array['ord_id'];
    $select_material = $select_material . " select_material frez_order";
    $select_thickness = "";
    $select_thickness = $select_thickness . $array['ord_id'];
    $select_thickness = $select_thickness . " select_thickness frez_order";

    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $_SESSION[$select_material] = $array['select_material'];
    $_SESSION[$select_thickness] = $array['select_thickness'];

    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_FREZ_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_FREZ_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
        for ($i = 0; $i < count($control_files); $i++) {
            if ($control_files[$i] == "false") {
                $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
                if ($control_files[$i] == "false") {
                    echo "<h1> Ошибка загрузки файла: {$_FILES[$i]['tmp_name']} </h1>";
                }
            }
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        if ($dir[$i])
            ?>
            <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
        style="width: 550px;display: flex; justify-content: center; text-align: center;">
        <input class="form-control"
               style="text-align: center; width: 50px;"
               disabled
               value="<?= $i - 1 ?>">
        <input type="text" style="width: 400px;  text-align: center;"
               class="form-control"
               value="<?= $dir[$i] ?>"
               disabled>
        <a class="btn btn-outline-danger"
           href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=frez">
            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                 height="16"
                 fill="currentColor" class="bi bi-x-octagon-fill"
                 viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
            </svg>
        </a>
        </div>
        <?
    }


}//Сохранение данных block_print

/*
if ($_POST['save_frez'] == 1) {
    $dateValue = "";
    $dateValue = $dateValue . $_POST['order_num'];
    $dateValue = $dateValue . " date frez_order";
    $timeValue = "";
    $timeValue = $timeValue . $_POST['order_num'];
    $timeValue = $timeValue . " time frez_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_POST['order_num'];
    $techtaskValue = $techtaskValue . " techtask frez_order";
    $select_material = "";
    $select_material = $select_material . $_POST['order_num'];
    $select_material = $select_material . " select_material frez_order";
    $select_thickness = "";
    $select_thickness = $select_thickness . $_POST['order_num'];
    $select_thickness = $select_thickness . " select_thickness frez_order";


    $_SESSION[$dateValue] = $_POST['date'];
    $_SESSION[$timeValue] = $_POST['time'];
    $_SESSION[$techtaskValue] = $_POST['techtask'];
    $_SESSION[$select_material] = $_POST['select_material'];
    $_SESSION[$select_thickness] = $_POST['select_thickness'];


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_";
    $FILE_ID = $FILE_ID . $_POST['order_num'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $_POST['order_num'] . "/";
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
    }


}//Сохранение данных block_frez*/
if ($_GET['file_type'] == 'frez') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_frez


if ($_GET['block_process'] == "off") {
    $_SESSION['block_process'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_process']; $k++) {
        $dateValue = $k;
        $dateValue = $dateValue . " date process_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time process_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask process_order";

        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_process'] = 0;
}
if ($_GET['block_process'] == "on") {
    $_SESSION['block_process'] = "on";
    $_SESSION['cnt_order_process'] = 1;

}
if ($_GET['cnt_order_process'] == "delete") {

    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date process_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time process_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask process_order";

    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_process']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_process']; $k++) {
            $dateValue = $k . " date process_order";
            $timeValue = $k . " time process_order";
            $techtaskValue = $k . " techtask process_order";
            $z = $k + 1;
            $dateValue2 = $z . " date process_order";
            $timeValue2 = $z . " time process_order";
            $techtaskValue2 = $z . " techtask process_order";

            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_process']) {
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
            }


        }
    }
    $_SESSION['cnt_order_process']--;

} else {
    if (isset($_GET['cnt_order_process'])) {
        if ($_GET['cnt_order_process'] != 0) {
            if ($_GET['cnt_order_process'] < $_SESSION['cnt_order_process']) {
                for ($i = $_GET['cnt_order_process'] + 1; $i <= $_SESSION['cnt_order_process']; $i++) {
                    $dateValue = $i;
                    $dateValue = $dateValue . " date process_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time process_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask process_order";

                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);

                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_process'] = $_GET['cnt_order_process'];
            } else {
                $_SESSION['cnt_order_process'] = $_GET['cnt_order_process'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_process
if ($_POST['save_process'] == 1) {
    $array = $_POST['Обработка'];
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date process_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time process_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask process_order";
    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_PROCESS_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_PROCESS_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
        for ($i = 0; $i < count($control_files); $i++) {
            if ($control_files[$i] == "false") {
                $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
                if ($control_files[$i] == "false") {
                    echo "<h1> Ошибка загрузки файла: {$_FILES[$i]['tmp_name']} </h1>";
                }
            }
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        ?>
        <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
             style="width: 550px;display: flex; justify-content: center; text-align: center;">
            <input class="form-control"
                   style="text-align: center; width: 50px;"
                   disabled
                   value="<?= $i - 1 ?>">
            <input type="text" style="width: 400px;  text-align: center;"
                   class="form-control"
                   value="<?= $dir[$i] ?>"
                   disabled>
            <a class="btn btn-outline-danger"
               href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=process">
                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                     height="16"
                     fill="currentColor" class="bi bi-x-octagon-fill"
                     viewBox="0 0 16 16">
                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                </svg>
            </a>
        </div>
        <?
    }


}//Сохранение данных block_process
/*
if ($_POST['save_process'] == 1) {
    $dateValue = "";
    $dateValue = $dateValue . $_POST['order_num'];
    $dateValue = $dateValue . " date process_order";
    $timeValue = "";
    $timeValue = $timeValue . $_POST['order_num'];
    $timeValue = $timeValue . " time process_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_POST['order_num'];
    $techtaskValue = $techtaskValue . " techtask process_order";

    $_SESSION[$dateValue] = $_POST['date'];
    $_SESSION[$timeValue] = $_POST['time'];
    $_SESSION[$techtaskValue] = $_POST['techtask'];


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_";
    $FILE_ID = $FILE_ID . $_POST['order_num'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $_POST['order_num'] . "/";
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
    }


}//Сохранение данных block_process*/
if ($_GET['file_type'] == 'process') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PROCESS_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_process


if ($_GET['block_poligrafy'] == "off") {
    $_SESSION['block_poligrafy'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_poligrafy']; $k++) {
        $dateValue = $k;
        $dateValue = $dateValue . " date poligrafy_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time poligrafy_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask poligrafy_order";

        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_poligrafy'] = 0;
}
if ($_GET['block_poligrafy'] == "on") {
    $_SESSION['block_poligrafy'] = "on";
    $_SESSION['cnt_order_poligrafy'] = 1;

}
if ($_GET['cnt_order_poligrafy'] == "delete") {

    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date poligrafy_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time poligrafy_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask poligrafy_order";

    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_PLOGRAFY_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_poligrafy']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_poligrafy']; $k++) {
            $dateValue = $k . " date poligrafy_order";
            $timeValue = $k . " time poligrafy_order";
            $techtaskValue = $k . " techtask poligrafy_order";
            $z = $k + 1;
            $dateValue2 = $z . " date poligrafy_order";
            $timeValue2 = $z . " time poligrafy_order";
            $techtaskValue2 = $z . " techtask poligrafy_order";

            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_poligrafy']) {
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
            }


        }
    }
    $_SESSION['cnt_order_poligrafy']--;

} else {
    if (isset($_GET['cnt_order_poligrafy'])) {
        if ($_GET['cnt_order_poligrafy'] != 0) {
            if ($_GET['cnt_order_poligrafy'] < $_SESSION['cnt_order_poligrafy']) {
                for ($i = $_GET['cnt_order_poligrafy'] + 1; $i <= $_SESSION['cnt_order_poligrafy']; $i++) {
                    $dateValue = $i;
                    $dateValue = $dateValue . " date poligrafy_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time poligrafy_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask poligrafy_order";

                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);

                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_poligrafy'] = $_GET['cnt_order_poligrafy'];
            } else {
                $_SESSION['cnt_order_poligrafy'] = $_GET['cnt_order_poligrafy'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_poligrafy
if ($_POST['save_poligrafy'] == 1) {
    $array = $_POST['Полиграфия'];
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date poligrafy_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time poligrafy_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask poligrafy_order";
    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_POLIGRAFY_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_POLIGRAFY_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        ?>
        <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
             style="width: 550px;display: flex; justify-content: center; text-align: center;">
            <input class="form-control"
                   style="text-align: center; width: 50px;"
                   disabled
                   value="<?= $i - 1 ?>">
            <input type="text" style="width: 400px;  text-align: center;"
                   class="form-control"
                   value="<?= $dir[$i] ?>"
                   disabled>
            <a class="btn btn-outline-danger"
               href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=poligrafy">
                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                     height="16"
                     fill="currentColor" class="bi bi-x-octagon-fill"
                     viewBox="0 0 16 16">
                    <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                </svg>
            </a>
        </div>
        <?
    }


}//Сохранение данных block_poligrafy
/*
if ($_POST['save_poligrafy'] == 1) {

    $dateValue = "";
    $dateValue = $dateValue . $_POST['order_num'];
    $dateValue = $dateValue . " date poligrafy_order";
    $timeValue = "";
    $timeValue = $timeValue . $_POST['order_num'];
    $timeValue = $timeValue . " time poligrafy_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_POST['order_num'];
    $techtaskValue = $techtaskValue . " techtask poligrafy_order";

    $_SESSION[$dateValue] = $_POST['date'];
    $_SESSION[$timeValue] = $_POST['time'];
    $_SESSION[$techtaskValue] = $_POST['techtask'];


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_";
    $FILE_ID = $FILE_ID . $_POST['order_num'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $_POST['order_num'] . "/";
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
    }


}//Сохранение данных block_poligrafy*/
if ($_GET['file_type'] == 'poligrafy') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_poligrafy

if ($_GET['block_montage'] == "off") {
    $_SESSION['block_montage'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_montage']; $k++) {

        $pointValue = $k;
        $pointValue = $pointValue . " point montage_order";
        $dateValue = $k;
        $dateValue = $dateValue . " date montage_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time montage_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask montage_order";

        unset($_SESSION[$pointValue]);
        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_montage'] = 0;
}
if ($_GET['block_montage'] == "on") {
    $_SESSION['block_montage'] = "on";
    $_SESSION['cnt_order_montage'] = 1;

}
if ($_GET['cnt_order_montage'] == "delete") {

    $pointValue = "";
    $pointValue = $pointValue . $_GET['order_num'];
    $pointValue = $pointValue . " point montage_order";
    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date montage_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time montage_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask montage_order";

    unset($_SESSION[$pointValue]);
    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_montage']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_montage']; $k++) {

            $pointValue = $k . " point montage_order";
            $dateValue = $k . " date montage_order";
            $timeValue = $k . " time montage_order";
            $techtaskValue = $k . " techtask montage_order";
            $z = $k + 1;
            $pointValue2 = $z . " point montage_order";
            $dateValue2 = $z . " date montage_order";
            $timeValue2 = $z . " time montage_order";
            $techtaskValue2 = $z . " techtask montage_order";

            $_SESSION[$pointValue] = $_SESSION[$pointValue2];
            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_montage']) {
                unset($_SESSION[$pointValue2]);
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
            }


        }
    }
    $_SESSION['cnt_order_montage']--;

} else {
    if (isset($_GET['cnt_order_montage'])) {
        if ($_GET['cnt_order_montage'] != 0) {
            if ($_GET['cnt_order_montage'] < $_SESSION['cnt_order_montage']) {
                for ($i = $_GET['cnt_order_montage'] + 1; $i <= $_SESSION['cnt_order_montage']; $i++) {
                    $pointValue = $i;
                    $pointValue = $pointValue . " point montage_order";
                    $dateValue = $i;
                    $dateValue = $dateValue . " date montage_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time montage_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask montage_order";

                    unset($_SESSION[$pointValue]);
                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);

                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_montage'] = $_GET['cnt_order_montage'];
            } else {
                $_SESSION['cnt_order_montage'] = $_GET['cnt_order_montage'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_montage


if ($_POST['save_montage'] == 1) {
    $array = $_POST['Монтаж'];
    $pointValue = "";
    $pointValue = $pointValue . $array['ord_id'];
    $pointValue = $pointValue . " point montage_order";
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date montage_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time montage_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask montage_order";
    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $_SESSION[$pointValue] = $array['adress'];
    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_MONTAGE_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_MONTAGE_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
        for ($i = 0; $i < count($control_files); $i++) {
            if ($control_files[$i] == "false") {
                $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
                if ($control_files[$i] == "false") {
                    echo "<h1> Ошибка загрузки файла: {$_FILES[$i]['tmp_name']} </h1>";
                }
            }
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        if ($dir[$i])
            ?>
            <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
        style="width: 550px;display: flex; justify-content: center; text-align: center;">
        <input class="form-control"
               style="text-align: center; width: 50px;"
               disabled
               value="<?= $i - 1 ?>">
        <input type="text" style="width: 400px;  text-align: center;"
               class="form-control"
               value="<?= $dir[$i] ?>"
               disabled>
        <a class="btn btn-outline-danger"
           href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=montage">
            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                 height="16"
                 fill="currentColor" class="bi bi-x-octagon-fill"
                 viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
            </svg>
        </a>
        </div>
        <?
    }


}//Сохранение данных block_zav


/*
if ($_POST['save_montage'] == 1) {

    $pointValue = "";
    $pointValue = $pointValue . $_POST['order_num'];
    $pointValue = $pointValue . " point montage_order";
    $dateValue = "";
    $dateValue = $dateValue . $_POST['order_num'];
    $dateValue = $dateValue . " date montage_order";
    $timeValue = "";
    $timeValue = $timeValue . $_POST['order_num'];
    $timeValue = $timeValue . " time montage_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_POST['order_num'];
    $techtaskValue = $techtaskValue . " techtask montage_order";

    $_SESSION[$pointValue] = $_POST['point'];
    $_SESSION[$dateValue] = $_POST['date'];
    $_SESSION[$timeValue] = $_POST['time'];
    $_SESSION[$techtaskValue] = $_POST['techtask'];


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_";
    $FILE_ID = $FILE_ID . $_POST['order_num'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $_POST['order_num'] . "/";
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
    }


}//Сохранение данных block_montage*/
if ($_GET['file_type'] == 'montage') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_MONTAGE_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_montage

if ($_GET['block_zav'] == "off") {
    $_SESSION['block_zav'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_zav']; $k++) {

        $pointValue = $k;
        $pointValue = $pointValue . " point zav_order";
        $dateValue = $k;
        $dateValue = $dateValue . " date zav_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time zav_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask zav_order";

        unset($_SESSION[$pointValue]);
        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_zav'] = 0;
}
if ($_GET['block_zav'] == "on") {
    $_SESSION['block_zav'] = "on";
    $_SESSION['cnt_order_zav'] = 1;

}
if ($_GET['cnt_order_zav'] == "delete") {

    $pointValue = "";
    $pointValue = $pointValue . $_GET['order_num'];
    $pointValue = $pointValue . " point zav_order";
    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date zav_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time zav_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask zav_order";

    unset($_SESSION[$pointValue]);
    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_zav_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_zav']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_zav']; $k++) {

            $pointValue = $k . " point zav_order";
            $dateValue = $k . " date zav_order";
            $timeValue = $k . " time zav_order";
            $techtaskValue = $k . " techtask zav_order";
            $z = $k + 1;
            $pointValue2 = $z . " point zav_order";
            $dateValue2 = $z . " date zav_order";
            $timeValue2 = $z . " time zav_order";
            $techtaskValue2 = $z . " techtask zav_order";

            $_SESSION[$pointValue] = $_SESSION[$pointValue2];
            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_zav']) {
                unset($_SESSION[$pointValue2]);
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
            }


        }
    }
    $_SESSION['cnt_order_zav']--;

} else {
    if (isset($_GET['cnt_order_zav'])) {
        if ($_GET['cnt_order_zav'] != 0) {
            if ($_GET['cnt_order_zav'] < $_SESSION['cnt_order_zav']) {
                for ($i = $_GET['cnt_order_zav'] + 1; $i <= $_SESSION['cnt_order_zav']; $i++) {
                    $pointValue = $i;
                    $pointValue = $pointValue . " point zav_order";
                    $dateValue = $i;
                    $dateValue = $dateValue . " date zav_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time zav_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask zav_order";

                    unset($_SESSION[$pointValue]);
                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);

                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_zav'] = $_GET['cnt_order_zav'];
            } else {
                $_SESSION['cnt_order_zav'] = $_GET['cnt_order_zav'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_zav

if ($_POST['save_zav'] == 1) {
    $array = $_POST['Замеры'];
    $pointValue = "";
    $pointValue = $pointValue . $array['ord_id'];
    $pointValue = $pointValue . " point zav_order";
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date zav_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time zav_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask zav_order";
    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $_SESSION[$pointValue] = $array['adress'];
    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_ZAV_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_ZAV_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
        for ($i = 0; $i < count($control_files); $i++) {
            if ($control_files[$i] == "false") {
                $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
                if ($control_files[$i] == "false") {
                    echo "<h1> Ошибка загрузки файла: {$_FILES[$i]['tmp_name']} </h1>";
                }
            }
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        if ($dir[$i])
            ?>
            <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
        style="width: 550px;display: flex; justify-content: center; text-align: center;">
        <input class="form-control"
               style="text-align: center; width: 50px;"
               disabled
               value="<?= $i - 1 ?>">
        <input type="text" style="width: 400px;  text-align: center;"
               class="form-control"
               value="<?= $dir[$i] ?>"
               disabled>
        <a class="btn btn-outline-danger"
           href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=zav">
            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                 height="16"
                 fill="currentColor" class="bi bi-x-octagon-fill"
                 viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
            </svg>
        </a>
        </div>
        <?
    }


}//Сохранение данных block_zav


/*
if ($_POST['save_zav'] == 1) {

    $pointValue = "";
    $pointValue = $pointValue . $_POST['order_num'];
    $pointValue = $pointValue . " point zav_order";
    $dateValue = "";
    $dateValue = $dateValue . $_POST['order_num'];
    $dateValue = $dateValue . " date zav_order";
    $timeValue = "";
    $timeValue = $timeValue . $_POST['order_num'];
    $timeValue = $timeValue . " time zav_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_POST['order_num'];
    $techtaskValue = $techtaskValue . " techtask zav_order";

    $_SESSION[$pointValue] = $_POST['point'];
    $_SESSION[$dateValue] = $_POST['date'];
    $_SESSION[$timeValue] = $_POST['time'];
    $_SESSION[$techtaskValue] = $_POST['techtask'];


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_";
    $FILE_ID = $FILE_ID . $_POST['order_num'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $_POST['order_num'] . "/";
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
    }


}//Сохранение данных block_zav*/
if ($_GET['file_type'] == 'zav') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_ZAV_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_zav

if ($_GET['block_delivery'] == "off") {
    $_SESSION['block_delivery'] = "off";
    for ($k = 1; $k <= $_SESSION['cnt_order_delivery']; $k++) {

        $pointValue = $k;
        $pointValue = $pointValue . " point delivery_order";
        $dateValue = $k;
        $dateValue = $dateValue . " date delivery_order";
        $timeValue = $k;
        $timeValue = $timeValue . " time delivery_order";
        $techtaskValue = $k;
        $techtaskValue = $techtaskValue . " techtask delivery_order";

        unset($_SESSION[$pointValue]);
        unset($_SESSION[$dateValue]);
        unset($_SESSION[$timeValue]);
        unset($_SESSION[$techtaskValue]);

        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_";
        $FILE_ID = $FILE_ID . $k;
        if (is_dir($FILE_ID)) {
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $k . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $k;
            rmdir($FILE_ID);
        }


    }
    $_SESSION['cnt_order_delivery'] = 0;
}
if ($_GET['block_delivery'] == "on") {
    $_SESSION['block_delivery'] = "on";
    $_SESSION['cnt_order_delivery'] = 1;

}
if ($_GET['cnt_order_delivery'] == "delete") {

    $pointValue = "";
    $pointValue = $pointValue . $_GET['order_num'];
    $pointValue = $pointValue . " point delivery_order";
    $dateValue = "";
    $dateValue = $dateValue . $_GET['order_num'];
    $dateValue = $dateValue . " date delivery_order";
    $timeValue = "";
    $timeValue = $timeValue . $_GET['order_num'];
    $timeValue = $timeValue . " time delivery_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_GET['order_num'];
    $techtaskValue = $techtaskValue . " techtask delivery_order";

    unset($_SESSION[$pointValue]);
    unset($_SESSION[$dateValue]);
    unset($_SESSION[$timeValue]);
    unset($_SESSION[$techtaskValue]);


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_delivery_";
    $FILE_ID = $FILE_ID . $_GET['order_num'];
    if (is_dir($FILE_ID)) {
        $scan_dir = scandir($FILE_ID);
        for ($i = 2; $i < count($scan_dir); $i++) {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $_GET['order_num'] . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$i];
            unlink($FILE_ID);
        }
        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $_GET['order_num'];
        rmdir($FILE_ID);
    }

    if ($_GET['order_num'] != $_SESSION['cnt_order_delivery']) {
        for ($k = $_GET['order_num']; $k < $_SESSION['cnt_order_delivery']; $k++) {

            $pointValue = $k . " point delivery_order";
            $dateValue = $k . " date delivery_order";
            $timeValue = $k . " time delivery_order";
            $techtaskValue = $k . " techtask delivery_order";
            $z = $k + 1;
            $pointValue2 = $z . " point delivery_order";
            $dateValue2 = $z . " date delivery_order";
            $timeValue2 = $z . " time delivery_order";
            $techtaskValue2 = $z . " techtask delivery_order";

            $_SESSION[$pointValue] = $_SESSION[$pointValue2];
            $_SESSION[$dateValue] = $_SESSION[$dateValue2];
            $_SESSION[$timeValue] = $_SESSION[$timeValue2];
            $_SESSION[$techtaskValue] = $_SESSION[$techtaskValue2];

            if (isset($_SESSION[$dateValue2])) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $k;
                $FILE_ID2 = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $z;
                rename($FILE_ID2, $FILE_ID);
            }
            if ($z == $_SESSION['cnt_order_delivery']) {
                unset($_SESSION[$pointValue2]);
                unset($_SESSION[$dateValue2]);
                unset($_SESSION[$timeValue2]);
                unset($_SESSION[$techtaskValue2]);
            }


        }
    }
    $_SESSION['cnt_order_delivery']--;

} else {
    if (isset($_GET['cnt_order_delivery'])) {
        if ($_GET['cnt_order_delivery'] != 0) {
            if ($_GET['cnt_order_delivery'] < $_SESSION['cnt_order_delivery']) {
                for ($i = $_GET['cnt_order_delivery'] + 1; $i <= $_SESSION['cnt_order_delivery']; $i++) {
                    $pointValue = $i;
                    $pointValue = $pointValue . " point delivery_order";
                    $dateValue = $i;
                    $dateValue = $dateValue . " date delivery_order";
                    $timeValue = $i;
                    $timeValue = $timeValue . " time delivery_order";
                    $techtaskValue = $i;
                    $techtaskValue = $techtaskValue . " techtask delivery_order";

                    unset($_SESSION[$pointValue]);
                    unset($_SESSION[$dateValue]);
                    unset($_SESSION[$timeValue]);
                    unset($_SESSION[$techtaskValue]);

                    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_";
                    $FILE_ID = $FILE_ID . $i;
                    if (is_dir($FILE_ID)) {
                        $scan_dir = scandir($FILE_ID);
                        for ($j = 2; $j < count($scan_dir); $j++) {
                            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $i . "/";
                            $FILE_ID = $FILE_ID . $scan_dir[$j];
                            unlink($FILE_ID);
                        }
                        $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $i;
                        rmdir($FILE_ID);
                    }
                }
                $_SESSION['cnt_order_delivery'] = $_GET['cnt_order_delivery'];
            } else {
                $_SESSION['cnt_order_delivery'] = $_GET['cnt_order_delivery'];
            }
        }
    }
}//Процесс удаления строчек или изменение их количества из block_delivery

if ($_POST['save_delivery'] == 1) {
    $array = $_POST['Доставка'];
    $pointValue = "";
    $pointValue = $pointValue . $array['ord_id'];
    $pointValue = $pointValue . " point delivery_order";
    $dateValue = "";
    $dateValue = $dateValue . $array['ord_id'];
    $dateValue = $dateValue . " date delivery_order";
    $timeValue = "";
    $timeValue = $timeValue . $array['ord_id'];
    $timeValue = $timeValue . " time delivery_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $array['ord_id'];
    $techtaskValue = $techtaskValue . " techtask delivery_order";
    $_SESSION[$dateValue] = $array['date'];
    $_SESSION[$timeValue] = $array['time'];
    $_SESSION[$techtaskValue] = $array['techtask'];
    $_SESSION[$pointValue] = $array['adress'];
    $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_DELIVERY_";
    $FILE_ID = $FILE_ID . $array['ord_id'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    if (!empty($_FILES)) {
        $FILE_ID = "../../../files/File_ORD/" . $array['id'] . "_ORDER_DELIVERY_" . $array['ord_id'] . "/";
        for ($i = 0; $i < count($_FILES); $i++) {
            $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
        }
        for ($i = 0; $i < count($control_files); $i++) {
            if ($control_files[$i] == "false") {
                $control_files[$i] = move_uploaded_file($_FILES[$i]['tmp_name'], $FILE_ID . $_FILES[$i]['name']);
                if ($control_files[$i] == "false") {
                    echo "<h1> Ошибка загрузки файла: {$_FILES[$i]['tmp_name']} </h1>";
                }
            }
        }
    }
    $dir = scandir($FILE_ID);
    for ($i = 2; $i < count(scandir($FILE_ID)); $i++) {
        if ($dir[$i])
            ?>
            <div class="input-group input-group-sm" id="file_info_<?= $i ?>"
        style="width: 550px;display: flex; justify-content: center; text-align: center;">
        <input class="form-control"
               style="text-align: center; width: 50px;"
               disabled
               value="<?= $i - 1 ?>">
        <input type="text" style="width: 400px;  text-align: center;"
               class="form-control"
               value="<?= $dir[$i] ?>"
               disabled>
        <a class="btn btn-outline-danger"
           href="FormOrd_Combined_Step2.php?id=<?= $array['id'] ?>&file_ord=<?= $array['ord_id'] ?>&file_num=<?= $i ?>&file_type=delivery">
            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                 height="16"
                 fill="currentColor" class="bi bi-x-octagon-fill"
                 viewBox="0 0 16 16">
                <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
            </svg>
        </a>
        </div>
        <?
    }


}//Сохранение данных block_delivery


/*
if ($_POST['save_delivery'] == 1) {

    $pointValue = "";
    $pointValue = $pointValue . $_POST['order_num'];
    $pointValue = $pointValue . " point delivery_order";
    $dateValue = "";
    $dateValue = $dateValue . $_POST['order_num'];
    $dateValue = $dateValue . " date delivery_order";
    $timeValue = "";
    $timeValue = $timeValue . $_POST['order_num'];
    $timeValue = $timeValue . " time delivery_order";
    $techtaskValue = "";
    $techtaskValue = $techtaskValue . $_POST['order_num'];
    $techtaskValue = $techtaskValue . " techtask delivery_order";

    $_SESSION[$pointValue] = $_POST['point'];
    $_SESSION[$dateValue] = $_POST['date'];
    $_SESSION[$timeValue] = $_POST['time'];
    $_SESSION[$techtaskValue] = $_POST['techtask'];


    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_";
    $FILE_ID = $FILE_ID . $_POST['order_num'];
    if (!is_dir($FILE_ID)) {
        mkdir($FILE_ID, 0777, true);
    }
    $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $_POST['order_num'] . "/";
    for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
        move_uploaded_file($_FILES['files']['tmp_name'][$i], $FILE_ID . $_FILES['files']['name'][$i]);
    }


}//Сохранение данных block_delivery*/
if ($_GET['file_type'] == 'delivery') {
    if (isset($_GET['file_ord']) && isset($_GET['file_num'])) {
        if ($_GET['file_num'] == "all") {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            for ($j = 2; $j < count($scan_dir); $j++) {
                $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $_GET['file_ord'] . "/";
                $FILE_ID = $FILE_ID . $scan_dir[$j];
                unlink($FILE_ID);
            }
        } else {
            $FILE_ID = "../../files/File_ORD/" . $id . "_ORDER_DELIVERY_";
            $FILE_ID = $FILE_ID . $_GET['file_ord'];
            $scan_dir = scandir($FILE_ID);
            $FILE_ID = $FILE_ID . "/";
            $FILE_ID = $FILE_ID . $scan_dir[$_GET['file_num']];
            unlink($FILE_ID);
        }
    }
}//блок удаление файлов block_delivery

if ($_GET['step1'] == 1) {
    $_SESSION['company'] = $_POST['company'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['Full_name'] = $_POST['Full_name'];
    $_SESSION['number'] = $_POST['number'];
    $_SESSION['Full_name_2'] = $_POST['Full_name_2'];
    $_SESSION['number_2'] = $_POST['number_2'];
}//Приход С Шага № 1


if ($_GET['block_poligrafy'] == "on") {
    $_SESSION['block_poligrafy'] = "on";
}


if ($_SESSION['cnt_order_print'] == 0) {
    $_SESSION['block_print'] = "off";
}
if ($_SESSION['cnt_order_frez'] == 0) {
    $_SESSION['block_frez'] = "off";
}
if ($_SESSION['cnt_order_process'] == 0) {
    $_SESSION['block_process'] = "off";
}

if ($_SESSION['cnt_order_montage'] == 0) {
    $_SESSION['block_montage'] = "off";
}


if ($_SESSION['cnt_order_zav'] == 0) {
    $_SESSION['block_zav'] = "off";
}


if ($_SESSION['cnt_order_delivery'] == 0) {
    $_SESSION['block_delivery'] = "off";
}

