<?php
require "../../../config/config.php";
require "../../../config/auth.php";
require_once '../../../QR/phpqrcode/qrlib.php';
session_start();
$id = $_GET['id'];
$company = $_SESSION['company'];
$email = $_SESSION['email'];
$Full_name = $_SESSION['Full_name'];
$number = $_SESSION['number'];
$Full_name_2 = $_SESSION['Full_name_2'];
$number_2 = $_SESSION['number_2'];
$contact = $Full_name . " " . $number . " " . $email . " " . $Full_name_2 . " " . $number_2;
$Array = array();
$a = NULL;
$result = NULL;
$cnt_ord_error = 0;
$time = date('Y-m-d H:i');
function rename_win($oldfile, $newfile)
{
    if (!rename($oldfile, $newfile)) {
        $dir = scandir($oldfile);
        if (is_dir($newfile)) {
            mkdir($newfile, 0777);
            for ($k = 1; $k < count($dir); $k++) {
                $file_new = $oldfile . "/" . $dir[$k];
                $name_dir = $newfile;
                echo $file_new;
                echo $name_dir;
                copy($file_new, $name_dir);
                unlink($file_new);
            }
            return TRUE;
        }
        return FALSE;
    }
    return TRUE;
}

if ($_SESSION['block_print'] == "on") {
    if ($_SESSION['cnt_order_print'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_print']; $i++) {
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date print_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time print_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask print_order";
            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Печать','$techtaskValue',NULL,NULL,NULL)";
            $Array['print'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['print'][$i]['check_ord'] == 1) {
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['print'][$i][0] = $ord_id;
                $Array['print'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $i;
                $Array['print'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['print'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_PRINT_" . $i;
                $Array['print'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['print'][$i]['file'] = rename_win($Array['print'][$i][3], $Array['print'][$i][4]);
                if ($Array['print'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['print'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['print'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['print'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['print'][$i]['check_ord'] = "Ошибка";
            }
        }
    }
}//Order_Uploads block_print
if ($_SESSION['block_frez'] == "on") {
    if ($_SESSION['cnt_order_frez'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_frez']; $i++) {
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date frez_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time frez_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask frez_order";
            $select_material = "";
            $select_material = $select_material . $i;
            $select_material = $select_material . " select_material frez_order";
            $select_thickness = "";
            $select_thickness = $select_thickness . $i;
            $select_thickness = $select_thickness . " select_thickness frez_order";

            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            $select_material = $_SESSION[$select_material];
            $select_thickness = $_SESSION[$select_thickness];

            /*
                        $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Фрезеровка','$techtaskValue',NULL,'$select_material', '$select_thickness')";
                        mysqli_query($connect, $sql);
                        $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND techTask = '$techtaskValue'AND deadline = '$datetimeValue' AND dateStart = '$time' ");
                        $sql = mysqli_fetch_all($sql);
                        $ord_id = $sql[0][0];
                        mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                        $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $i;
                        $FILE_ID_2 = "../../../files/File_ORD/" . $ord_id;
                        rename($FILE_ID, $FILE_ID_2);
                        $sql = "Update `orders` SET orders.Files = '" . $FILE_ID_2 . "' WHERE orders.id = " . $ord_id;
                        mysqli_query($connect, $sql);

                        $file_constant = $ord_id . ".png";
                        $FILE_ID_2 = $FILE_ID_2 . "/" . $file_constant;
                        QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                        $answer['frez'][$i] = $ord_id;
            */

            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Фрезеровка','$techtaskValue',NULL,'$select_material', '$select_thickness')";
            $Array['frez'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['frez'][$i]['check_ord'] == 1) {
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['frez'][$i][0] = $ord_id;
                $Array['frez'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_FREZ_" . $i;
                $Array['frez'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['frez'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_FREZ_" . $i;
                $Array['frez'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['frez'][$i]['file'] = rename_win($Array['frez'][$i][3], $Array['frez'][$i][4]);
                if ($Array['frez'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['frez'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['frez'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['frez'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['frez'][$i]['check_ord'] = "Ошибка";
            }

        }
    }
}//Order_Uploads block_frez
if ($_SESSION['block_process'] == "on") {
    if ($_SESSION['cnt_order_process'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_process']; $i++) {
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date process_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time process_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask process_order";
            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            /*   $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Сборка и обработка','$techtaskValue',NULL,NULL,NULL)";
               mysqli_query($connect, $sql);
               $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND contact = '$contact' AND techTask = '$techtaskValue'AND deadline = '$datetimeValue' AND dateStart = '$time'   ");
               $sql = mysqli_fetch_all($sql);
               $ord_id = $sql[0][0];
               mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
               $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $i;
               $FILE_ID_2 = "../../../files/File_ORD/" . $ord_id;
               rename($FILE_ID, $FILE_ID_2);
               $sql = "Update `orders` SET orders.Files = '" . $FILE_ID_2 . "' WHERE orders.id = " . $ord_id;
               mysqli_query($connect, $sql);

               $file_constant = $ord_id . ".png";
               $FILE_ID_2 = $FILE_ID_2 . "/" . $file_constant;
               QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
               $answer['process'][$i] = $ord_id;
   */

            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Сборка и обработка','$techtaskValue',NULL,NULL,NULL)";
            $Array['process'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['process'][$i]['check_ord'] == 1) {
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['process'][$i][0] = $ord_id;
                $Array['process'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_PROCESS_" . $i;
                $Array['process'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['process'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_PROCESS_" . $i;
                $Array['process'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['process'][$i]['file'] = rename_win($Array['process'][$i][3], $Array['process'][$i][4]);
                if ($Array['process'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['process'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['process'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['process'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['process'][$i]['check_ord'] = "Ошибка";
            }
        }
    }
}//Order_Uploads block_process
if ($_SESSION['block_poligrafy'] == "on") {
    if ($_SESSION['cnt_order_poligrafy'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_poligrafy']; $i++) {
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date poligrafy_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time poligrafy_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask poligrafy_order";
            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            /* $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Полиграфия','$techtaskValue',NULL,NULL,NULL)";
             mysqli_query($connect, $sql);
             $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND contact = '$contact' AND techTask = '$techtaskValue' AND deadline = '$datetimeValue' AND dateStart = '$time'   ");
             $sql = mysqli_fetch_all($sql);
             $ord_id = $sql[0][0];
             mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
             $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $i;
             $FILE_ID_2 = "../../../files/File_ORD/" . $ord_id;
             rename($FILE_ID, $FILE_ID_2);
             $sql = "Update `orders` SET orders.Files = '" . $FILE_ID_2 . "' WHERE orders.id = " . $ord_id;
             mysqli_query($connect, $sql);

             $file_constant = $ord_id . ".png";
             $FILE_ID_2 = $FILE_ID_2 . "/" . $file_constant;
             QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
             $answer['poligrafy'][$i] = $ord_id;

 */
            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Полиграфия','$techtaskValue',NULL,NULL,NULL)";
            $Array['poligrafy'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['poligrafy'][$i]['check_ord'] == 1) {
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['poligrafy'][$i][0] = $ord_id;
                $Array['poligrafy'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $i;
                $Array['poligrafy'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['poligrafy'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_POLIGRAFY_" . $i;
                $Array['poligrafy'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['poligrafy'][$i]['file'] = rename_win($Array['poligrafy'][$i][3], $Array['poligrafy'][$i][4]);
                if ($Array['poligrafy'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['poligrafy'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['poligrafy'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['poligrafy'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['poligrafy'][$i]['check_ord'] = "Ошибка";
            }
        }
    }
}//Order_Uploads block_poligrafy
if ($_SESSION['block_montage'] == "on") {
    if ($_SESSION['cnt_order_montage'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_montage']; $i++) {
            $pointValue = "";
            $pointValue = $pointValue . $i;
            $pointValue = $pointValue . " point montage_order";
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date montage_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time montage_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask montage_order";
            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            $pointValue = $_SESSION[$pointValue];
            /*  $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company','$pointValue','$contact','$time', '$datetimeValue','Монтаж','$techtaskValue',NULL,NULL,NULL)";
              mysqli_query($connect, $sql);
              $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND contact = '$contact' AND techTask = '$techtaskValue' AND deadline = '$datetimeValue' AND dateStart = '$time'   ");
              $sql = mysqli_fetch_all($sql);
              $ord_id = $sql[0][0];
              mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
              $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $i;
              $FILE_ID_2 = "../../../files/File_ORD/" . $ord_id;
              rename($FILE_ID, $FILE_ID_2);
              $sql = "Update `orders` SET orders.Files = '" . $FILE_ID_2 . "' WHERE orders.id = " . $ord_id;
              mysqli_query($connect, $sql);

              $file_constant = $ord_id . ".png";
              $FILE_ID_2 = $FILE_ID_2 . "/" . $file_constant;
              QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
              $answer['montage'][$i] = $ord_id;
  */
            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company','$pointValue','$contact','$time', '$datetimeValue','Монтаж','$techtaskValue',NULL,NULL,NULL)";
            $Array['montage'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['montage'][$i]['check_ord'] == 1) {
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['montage'][$i][0] = $ord_id;
                $Array['montage'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $i;
                $Array['montage'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['montage'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_MONTAGE_" . $i;
                $Array['montage'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['montage'][$i]['file'] = rename_win($Array['montage'][$i][3], $Array['montage'][$i][4]);
                if ($Array['montage'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['montage'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['montage'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['montage'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['montage'][$i]['check_ord'] = "Ошибка";
            }
        }
    }
}//Order_Uploads block_montage
if ($_SESSION['block_zav'] == "on") {
    if ($_SESSION['cnt_order_zav'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_zav']; $i++) {
            $pointValue = "";
            $pointValue = $pointValue . $i;
            $pointValue = $pointValue . " point zav_order";
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date zav_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time zav_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask zav_order";
            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            $pointValue = $_SESSION[$pointValue];
            /*    $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company','$pointValue','$contact','$time', '$datetimeValue','Замеры','$techtaskValue',NULL,NULL,NULL)";
                mysqli_query($connect, $sql);
                $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND contact = '$contact' AND techTask = '$techtaskValue' AND deadline = '$datetimeValue' AND dateStart = '$time'  ");
                $sql = mysqli_fetch_all($sql);
                $ord_id = $sql[0][0];
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $i;
                $FILE_ID_2 = "../../../files/File_ORD/" . $ord_id;
                rename($FILE_ID, $FILE_ID_2);
                $sql = "Update `orders` SET orders.Files = '" . $FILE_ID_2 . "' WHERE orders.id = " . $ord_id;
                mysqli_query($connect, $sql);

                $file_constant = $ord_id . ".png";
                $FILE_ID_2 = $FILE_ID_2 . "/" . $file_constant;
                QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                $answer['zav'][$i] = $ord_id;
    */
            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company','$pointValue','$contact','$time', '$datetimeValue','Замеры','$techtaskValue',NULL,NULL,NULL)";
            $Array['zav'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['zav'][$i]['check_ord'] == 1) {
                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['zav'][$i][0] = $ord_id;
                $Array['zav'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_ZAV_" . $i;
                $Array['zav'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['zav'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_ZAV_" . $i;
                $Array['zav'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['zav'][$i]['file'] = rename_win($Array['zav'][$i][3], $Array['zav'][$i][4]);
                if ($Array['zav'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['zav'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['zav'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['zav'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['zav'][$i]['check_ord'] = "Ошибка";
            }
        }
    }
}//Order_Uploads block_zav
if ($_SESSION['block_delivery'] == "on") {
    if ($_SESSION['cnt_order_delivery'] > 0) {
        for ($i = 1; $i <= $_SESSION['cnt_order_delivery']; $i++) {
            $pointValue = "";
            $pointValue = $pointValue . $i;
            $pointValue = $pointValue . " point delivery_order";
            $dateValue = "";
            $dateValue = $dateValue . $i;
            $dateValue = $dateValue . " date delivery_order";
            $timeValue = "";
            $timeValue = $timeValue . $i;
            $timeValue = $timeValue . " time delivery_order";
            $techtaskValue = "";
            $techtaskValue = $techtaskValue . $i;
            $techtaskValue = $techtaskValue . " techtask delivery_order";
            $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
            $techtaskValue = $_SESSION[$techtaskValue];
            $pointValue = $_SESSION[$pointValue];
            /*
            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company','$pointValue','$contact','$time', '$datetimeValue','Доставка','$techtaskValue',NULL,NULL,NULL)";
            mysqli_query($connect, $sql);
            $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND contact = '$contact' AND techTask = '$techtaskValue' AND deadline = '$datetimeValue' AND dateStart = '$time'  ");
            $sql = mysqli_fetch_all($sql);
            $ord_id = $sql[0][0];
            mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
            $FILE_ID = "../../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $i;
            $FILE_ID_2 = "../../../files/File_ORD/" . $ord_id;
            rename($FILE_ID, $FILE_ID_2);
            $sql = "Update `orders` SET orders.Files = '" . $FILE_ID_2 . "' WHERE orders.id = " . $ord_id;
            mysqli_query($connect, $sql);

            $file_constant = $ord_id . ".png";
            $FILE_ID_2 = $FILE_ID_2 . "/" . $file_constant;
            QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
            $answer['delivery'][$i] = $ord_id;*/


            $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company','$pointValue','$contact','$time', '$datetimeValue','Замеры','$techtaskValue',NULL,NULL,NULL)";
            $Array['delivery'][$i]['check_ord'] = mysqli_query($connect, $sql);
            $ord_id = mysqli_insert_id($connect);
            if ($Array['delivery'][$i]['check_ord'] == 1) {

                mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                $Array['delivery'][$i][0] = $ord_id;
                $Array['delivery'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $i;
                $Array['delivery'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                $Array['delivery'][$i][3] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $id . "_ORDER_DELIVERY_" . $i;
                $Array['delivery'][$i][4] = $_SERVER['DOCUMENT_ROOT'] . "/files/File_ORD/" . $ord_id;
                $Array['delivery'][$i]['file'] = rename_win($Array['delivery'][$i][3], $Array['delivery'][$i][4]);
                if ($Array['delivery'][$i]['file'] == 1) {
                    $sql = "Update `orders` SET orders.Files = '" . $Array['delivery'][$i][2] . "' WHERE orders.id = " . $ord_id;
                    mysqli_query($connect, $sql);
                    $file_constant = $ord_id . ".png";
                    $FILE_ID_2 = $Array['delivery'][$i][2] . "/" . $file_constant;
                    QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                } else {
                    $Array['delivery'][$i]['file'] = "Ошибка";
                }
            } else {
                $Array['delivery'][$i]['check_ord'] = "Ошибка";
            }
        }
    }
}//Order_Uploads block_delivery
if (isset($Array)) {
    if (isset($Array['print'])) {
        for ($i = 1; $i <= count($Array['print']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['print'][$i][0]}");
        }
    }
    if (isset($Array['frez'])) {
        for ($i = 1; $i <= count($Array['frez']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['frez'][$i][0]}");
        }
    }
    if (isset($Array['poligrafy'])) {
        for ($i = 1; $i <= count($Array['poligrafy']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['poligrafy'][$i][0]}");
        }
    }
    if (isset($Array['process'])) {
        for ($i = 1; $i <= count($Array['process']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['process'][$i][0]}");
        }
    }
    if (isset($Array['delivery'])) {
        for ($i = 1; $i <= count($Array['delivery']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['delivery'][$i][0]}");
        }
    }
    if (isset($Array['montage'])) {
        for ($i = 1; $i <= count($Array['montage']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['montage'][$i][0]}");
        }
    }
    if (isset($Array['zav'])) {
        for ($i = 1; $i <= count($Array['zav']); $i++) {
            mysqli_query($connect, "UPDATE ordstatus SET print = -1 WHERE oID = {$Array['zav'][$i][0]}");
        }
    }

}

/*
if (isset($Array)) {
    if (isset($Array['print'])) {
        for ($i = 1; $i <= count($Array['print']); $i++) {
            if ($Array['print'][$i]['check_ord'] == "Ошибка") {
                $dateValue = "";
                $dateValue = $dateValue . $i;
                $dateValue = $dateValue . " date print_order";
                $timeValue = "";
                $timeValue = $timeValue . $i;
                $timeValue = $timeValue . " time print_order";
                $techtaskValue = "";
                $techtaskValue = $techtaskValue . $i;
                $techtaskValue = $techtaskValue . " techtask print_order";
                $datetimeValue = $_SESSION[$dateValue] . " " . $_SESSION[$timeValue];
                $techtaskValue = $_SESSION[$techtaskValue];
                $sql = "INSERT INTO `orders`(`id`, `company`, `address`, `contact`, `dateStart`, `deadline`, `typeTask`, `techTask`, `Files`, `material`, `thickness`) VALUES (NULL,'$company',NULL,'$contact','$time', '$datetimeValue','Печать','$techtaskValue',NULL,NULL,NULL)";
                $Array['print'][$i]['check_ord'] = mysqli_query($connect, $sql);
                if ($Array['print'][$i]['check_ord'] == 1) {
                    $sql = mysqli_query($connect, "SELECT id FROM orders WHERE company = '$company' AND contact = '$contact' AND techTask = '$techtaskValue' AND deadline = '$datetimeValue' AND dateStart = '$time'");
                    $sql = mysqli_fetch_all($sql);
                    $ord_id = $sql[0][0];
                    mysqli_query($connect, "INSERT INTO `uorders`(`oId`, `uId`) VALUES ('$ord_id','$id')");
                    $Array['print'][$i][0] = $ord_id;
                    $Array['print'][$i][1] = "../../../files/File_ORD/" . $id . "_ORDER_PRINT_" . $i;
                    $Array['print'][$i][2] = "../../../files/File_ORD/" . $ord_id;
                    $Array['print'][$i]['file'] = rename($Array['print'][$i][1], $Array['print'][$i][2]);
                    if ($Array['print'][$i]['file'] == 1) {
                        $sql = "Update `orders` SET orders.Files = '" . $Array['print'][$i][2] . "' WHERE orders.id = " . $ord_id;
                        mysqli_query($connect, $sql);
                        $file_constant = $ord_id . ".png";
                        $FILE_ID_2 = $Array['print'][$i][2] . "/" . $file_constant;
                        QRcode::png($ord_id, $FILE_ID_2, 'H', 8);
                    } else {
                        $Array['print'][$i]['file'] = "Ошибка";
                    }
                } else {
                    $Array['print'][$i]['check_ord'] = "Ошибка";
                }
            }
            if ($Array['print'][$i]['check_ord'] == "Ошибка") {
                $Array['print'][$i]['check_ord'] = "Фатальная Ошибка";
            }
        }
    }


    if (!empty($answer['print'])) {
        $ord_ans[1][0] = "Заявки блока печати: " . count($answer['print']) . " шт ";
        for ($i = 1; $i <= count($answer['print']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['print'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[1][$i] = "(№" . $i . ")  id = " . $answer['print'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['print'][$i]}");
            $_SESSION['print' . $i] = $answer['print'][$i];
        }

    }
    if (!empty($answer['frez'])) {
        $ord_ans[2][0] = "Заявки блока фрезировки: " . count($answer['frez']) . " шт ";
        for ($i = 1; $i <= count($answer['frez']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['frez'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[2][$i] = "(№" . $i . ")  id = " . $answer['frez'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['frez'][$i]}");
            $_SESSION['frez' . $i] = $answer['frez'][$i];


        }
    }
    if (!empty($answer['process'])) {
        $ord_ans[3][0] = "Заявки блока обработки: " . count($answer['process']) . " шт ";
        for ($i = 1; $i <= count($answer['process']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['process'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[3][$i] = "(№" . $i . ")  id = " . $answer['process'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['process'][$i]}");
            $_SESSION['process' . $i] = $answer['process'][$i];

        }
    }
    if (!empty($answer['poligrafy'])) {
        $ord_ans[4][0] = "Заявки блока полиграфии: " . count($answer['poligrafy']) . " шт ";
        for ($i = 1; $i <= count($answer['poligrafy']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['poligrafy'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[4][$i] = "(№" . $i . ")  id = " . $answer['poligrafy'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['poligrafy'][$i]}");
            $_SESSION['poligrafy' . $i] = $answer['poligrafy'][$i];

        }
    }
    if (!empty($answer['montage'])) {
        $ord_ans[5][0] = "Заявки блока монтажа: " . count($answer['montage']) . " шт ";
        for ($i = 1; $i <= count($answer['montage']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['montage'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[5][$i] = "(" . $i . ")  id = " . $answer['montage'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['montage'][$i]}");
            $_SESSION['montage' . $i] = $answer['montage'][$i];

        }
    }
    if (!empty($answer['zav'])) {
        $ord_ans[6][0] = "Заявки блока замеров: " . count($answer['zav']) . " шт ";
        for ($i = 1; $i <= count($answer['zav']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['zav'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[6][$i] = "(" . $i . ") id = " . $answer['zav'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['zav'][$i]}");
            $_SESSION['zav' . $i] = $answer['zav'][$i];

        }
    }
    if (!empty($answer['delivery'])) {
        $ord_ans[7][0] = "Заявки блока доставки: " . count($answer['delivery']) . " шт ";
        for ($i = 1; $i <= count($answer['delivery']); $i++) {
            $file = "../../../files/File_ORD/" . $answer['delivery'][$i];
            $file = scandir($file);
            $file = count($file) - 2;
            $ord_ans[7][$i] = "(" . $i . ")  " . $answer['delivery'][$i] . " файлов прикреплено " . $file;
            mysqli_query($connect, "UPDATE ordstatus SET print = 10 WHERE oID = {$answer['delivery'][$i]}");
            $_SESSION['delivery' . $i] = $answer['delivery'][$i];
        }
    }

}
*/

$date_1 = new DateTime('+7 days');
$date_2 = new DateTime('-7 days');
$date_1 = $date_1->format('Y-m-d');
$date_2 = $date_2->format('Y-m-d');
header("Location: http://{$_SERVER['SERVER_NAME']}/Orders/Orders.php?id={$id}&start=1&date_start={$date_2}&date_end={$date_1}");



