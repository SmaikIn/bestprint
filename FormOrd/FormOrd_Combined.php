<?php
session_start();
require "../config/config.php";
require "../config/auth.php";
$id = $_GET['id'];
if (isset($_GET['config_file'])) {
    $dir = scandir("../files/File_ORD");
    $str = $id . "_";
    $cnt = 0;
    for ($i = 2; $i < count($dir); $i++) {
        $inf = str_replace($str, $str, $dir[$i], $cnt);
        $count[$i] = $cnt;

    }
    for ($i = 2; $i < count($dir); $i++) {
        if ($count[$i] == 1) {
            $dir_delete = "../files/File_ORD/" . $dir[$i];
            $scan_dir_delete = scandir($dir_delete);
            for ($j = 2; $j < count($scan_dir_delete); $j++) {
                $file_delete = $dir_delete . "/" . $scan_dir_delete[$j];
                unlink($file_delete);
            }
            if (is_dir($dir_delete)) {
                rmdir($dir_delete);
            }
        }
    }
}


$category = $_GET['category'];
if (isset($_GET['type_ord'])) {
    $_SESSION['type_ord'] = $_GET['type_ord'];
}
if (empty($_SESSION['block_print'])) {
    $_SESSION['block_print'] = "off";
}
if (empty($_SESSION['block_frez'])) {
    $_SESSION['block_frez'] = "off";
}
if (empty($_SESSION['block_process'])) {
    $_SESSION['block_process'] = "off";
}
if (empty($_SESSION['block_poligrafy'])) {
    $_SESSION['block_poligrafy'] = "off";
}


if (empty($_SESSION['block_montage'])) {
    $_SESSION['block_montage'] = "off";
}
if (empty($_SESSION['block_zav'])) {
    $_SESSION['block_zav'] = "off";
}
if (empty($_SESSION['block_delivery'])) {
    $_SESSION['block_delivery'] = "off";
}
?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новая Заявка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="Step1.css">
    <script src="../tel_Script/phoneinput.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector('input').focus();
        })
    </script>
</head>
<body>
<center>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h1>Новая заявка</h1>
                <h4>Шаг №1</h4>
            </div>
            <div class="col">
                <a class="btn btn-outline-danger btn-sm"
                   href="../Personal_Area/lk.php?id=<?= $id ?>">Вернуться в личный кабинет</a>
            </div>
        </div>
        <br>
        <?
        switch ($_SESSION['type_ord']) {
            case "Combined" :
                $type_ord = 'Комбинированная заявка';
                $_SESSION['link'] = "Step2/FormOrd_Combined_Step2.php?id=" . $id . "&step1=1";
                break;
            case "zav" :
                $type_ord = 'Замеры';
                $_SESSION['link'] = "Step2/FormOrd_zav_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_zav'] = "on";
                if (empty($_SESSION['cnt_order_zav'])) {
                    $_SESSION['cnt_order_zav'] = 1;
                }
                break;
            case "montage" :
                $type_ord = 'Монтаж';
                $_SESSION['link'] = "Step2/FormOrd_montage_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_montage'] = "on";
                if (empty($_SESSION['cnt_order_montage'])) {
                    $_SESSION['cnt_order_montage'] = 1;
                }
                break;
            case "poligrafy" :
                $type_ord = 'Полиграфия';
                $_SESSION['link'] = "Step2/FormOrd_poligrafy_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_poligrafy'] = "on";
                if (empty($_SESSION['cnt_order_poligrafy'])) {
                    $_SESSION['cnt_order_poligrafy'] = 1;
                }
                break;
            case "delivery" :
                $type_ord = 'Доставка';
                $_SESSION['link'] = "Step2/FormOrd_delivery_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_delivery'] = "on";
                if (empty($_SESSION['cnt_order_delivery'])) {
                    $_SESSION['cnt_order_delivery'] = 1;
                }
                break;
            case "frez" :
                $type_ord = 'Фрезеровка';
                $_SESSION['link'] = "Step2/FormOrd_frez_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_frez'] = "on";
                if (empty($_SESSION['cnt_order_frez'])) {
                    $_SESSION['cnt_order_frez'] = 1;
                }
                break;
            case "process" :
                $type_ord = 'Сборка и обработка';
                $_SESSION['link'] = "Step2/FormOrd_process_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_process'] = "on";
                if (empty($_SESSION['cnt_order_process'])) {
                    $_SESSION['cnt_order_process'] = 1;
                }
                break;
            case "print" :
                $type_ord = 'Печать';
                $_SESSION['link'] = "Step2/FormOrd_print_Step2.php?id=" . $id . "&step1=1";
                $_SESSION['block_print'] = "on";
                if (empty($_SESSION['cnt_order_print'])) {
                    $_SESSION['cnt_order_print'] = 1;
                }
                break;
            default :
                echo "КАКАЯ ТО НЕ ВЕДОМАЯ ОШИБКА, НАДО ВЕРНУТЬСЯ В ЛИЧНЫЙ КАБИНЕТ";
                exit();

        }
        ?>
        <form action="<?= $_SESSION['link'] ?>" method="post"
              enctype="multipart/form-data">
            <div class="name">
                <div class="row">
                    <div class="col">
                        <div class="place">
                            <h5>Вид работ</h5>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="task" id="task" autocomplete="off"
                               style="text-align: center"
                               value="<?= $type_ord ?>" disabled="disabled">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Заказчик</h5>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="company" id="company" required
                               value="<?= $_SESSION['company'] ?>"
                               placeholder="Пример: DNS " autocomplete="on">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>E-mail</h5>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Не обязательно"
                               value="<?= $_SESSION['email'] ?>"
                               autocomplete="off">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Контактное Лицо</h5>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="name">ФИО</span>
                            </div>
                            <input type="text" class="form-control" name="Full_name" id="Full_name" required
                                   value="<?= $_SESSION['Full_name'] ?>"
                                   autocomplete="on">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Моб. Телефон</h5>
                    </div>
                    <div class="col">
                        <input type="tel" class="form-control" data-tel-input placeholder="+7 (981) 455-25-45"
                               name="number" id="number" maxlength="18" autocomplete="on"
                               value="<?= $_SESSION['number'] ?>"/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Доп. Контакт</h5>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="name">ФИО</span>
                            </div>
                            <input type="text" class="form-control" name="Full_name_2" id="Full_name_2"
                                   value="<?= $_SESSION['Full_name_2'] ?>"
                                   autocomplete="on">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Моб. Телефон</h5>
                    </div>
                    <div class="col">
                        <input type="tel" class="form-control" data-tel-input placeholder="+7 (981) 455-25-45"
                               name="number_2" id="number_2" maxlength="18" autocomplete="on"
                               value="<?= $_SESSION['number_2'] ?>"/>
                    </div>
                </div>
                <br>
                <br>
                <? if (empty($_SESSION['cnt_order_print'])) {
                    $_SESSION['cnt_order_print'] = 0;

                }

                if (empty($_SESSION['cnt_order_frez'])) {
                    $_SESSION['cnt_order_frez'] = 0;

                }

                if (empty($_SESSION['cnt_order_process'])) {
                    $_SESSION['cnt_order_process'] = 0;

                }

                if (empty($_SESSION['cnt_order_poligrafy'])) {
                    $_SESSION['cnt_order_poligrafy'] = 0;

                }


                if (empty($_SESSION['cnt_order_montage'])) {
                    $_SESSION['cnt_order_montage'] = 0;

                }

                if (empty($_SESSION['cnt_order_zav'])) {
                    $_SESSION['cnt_order_zav'] = 0;

                }
                if (empty($_SESSION['cnt_order_delivery'])) {
                    $_SESSION['cnt_order_delivery'] = 0;

                }


                ?>
                <div class="row">
                    <button type="submit" class="btn btn-outline-dark btn">К Шагу №2</button>
                </div>
                <br>
                <br>
            </div>
        </form>
    </div>
</center>


</body>
</html>