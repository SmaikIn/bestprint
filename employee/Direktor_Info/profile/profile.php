<?php
require "../../../config/config.php";
require "../../../config/auth.php";
$id = $_GET['id'];
$u_id = $_GET['u_id'];
$empl = $_GET['empl'];
if (isset($_GET['delete'])) {
    $string_q = "DELETE FROM `users` WHERE `users`.`id` =" . $_GET['u_id'];
    mysqli_query($connect, $string_q);
    ?>
    <script>
        window.close();
    </script>
    <?php
}

if (isset($_POST['email'])) {
    $string_q = 'UPDATE `users` SET `e-mail` = "' . $_POST['email'] . '" WHERE id = ' . $u_id;
    mysqli_query($connect, $string_q);
    unset($_POST['email']);
}
if (isset($_POST['number'])) {
    $string_q = 'UPDATE users SET phone = "' . $_POST['number'] . '" WHERE id = ' . $u_id;
    mysqli_query($connect, $string_q);
    unset($_POST['number']);
}
if (empty($_FILES['filename']['name'])) {
    $filename = 'Profile.png';
} else {
    move_uploaded_file($_FILES['filename']['tmp_name'], '../../../image/avatar/' . $_FILES['filename']['name']);
    $filename = $_FILES['filename']['name'];
    $sql = "UPDATE users SET image = '" . $filename . "' WHERE id = " . $u_id;
    mysqli_query($connect, $sql);
    unset($_FILES);
}


$sql = mysqli_query($connect, "SELECT `name`, `image`, `phone`, `birthday`, `e-mail`, `QR`, catid, messengerV, messengerT, messengerW FROM users WHERE id = '$u_id'");
$sql = mysqli_fetch_all($sql);

$cat_id = $sql[0][6];
$query = mysqli_query($connect, "SELECT name FROM category WHERE id = '$cat_id'");
$query = mysqli_fetch_all($query);


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Личный профиль</title>
    <script src="../../../tel_Script/phoneinput.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector('input').focus();
        })
    </script>
</head>
<style>
    .w {
        color: white;
        background-color: #9b9b9b;
        outline: #5700dd;
        box-shadow: #5700dd;
    }

    .w:hover {
        background: #5700dd;
    }

    ,
    .w:out-of-range {
        background: #5700dd;
    }

    ,

    .w:focus {
        background: #5700dd;
    }

    ,
</style>
<body>
<center>
    <div class="container mt-2">
        <h1><?= $query[0][0] ?></h1>
        <br>
        <div class="row" style="width: 1000px">
            <div class="col-4">
                <div class="row" style="text-align: center; width: 300px;">
                    <center>
                        <?
                        $Image = "../../../image/avatar/";
                        $Image = $Image . $sql[0][1];
                        echo($Image == "" ? "No image" : "<img width='300' src='" . $Image . "'></img>");
                        ?>
                        <br>
                        <br>
                        <form method="post" action="profile.php?<?= $_SERVER['QUERY_STRING'] ?>"
                              enctype="multipart/form-data">
                            <input type="file" class="form-control" name="filename" style="width: 250px;"
                                   required accept="image/jpeg, image/png"> <br>
                            <button type="submit" class="btn btn-outline-primary btn" style="width: 250px;">Загрузить
                                фотографию
                            </button>
                        </form>

                    </center>
                </div>
                <?
                if ($sql[0][6] == 5) {
                    ?>
                    <div class="row" style="text-align: center; width: 300px;">
                        <center>
                            <?
                            $Image = "../../../" . $sql[0][5];
                            echo($Image == "" ? "No image" : "<img width='200' src='" . $Image . "'></img>");
                            ?>
                        </center>
                    </div>
                    <div class="row">
                        <?
                        $query = "SELECT max(id) FROM `worktime` WHERE u_id = '$u_id' ";
                        $query = mysqli_query($connect, $query);
                        $query = mysqli_fetch_all($query);
                        if (empty($query[0][0])) {
                            ?>
                            <input class="form-control" disabled value="Сотрудник сейчас не на работе"
                                   style="text-align: center; background: #ff0101">
                            <?
                        } else {
                            $u_id2 = $query[0][0];
                            $query = "SELECT * FROM `worktime` WHERE  id = '$u_id2'";
                            $query = mysqli_query($connect, $query);
                            $query = mysqli_fetch_all($query);
                            if (empty($query[0][3])) {
                                ?>
                                <input class="form-control" disabled value="Сотрудник сейчас на работе"
                                       style="text-align: center; background: #01ff01">
                                <?
                            } else {
                                ?>
                                <input class="form-control" disabled value="Сотрудник сейчас не на работе"
                                       style="text-align: center; background: #ff0101">
                                <?
                            }
                        }
                        ?>
                    </div>
                    <?
                }
                ?>
                <br>
                <div class="row">
                    <a class="btn btn-outline-primary"
                       href="../../../RegFun/UserUpdate.php?id=<?= $id ?>&redact=<?= $u_id ?>&empl=<?= $empl ?>&dir=dir">
                        Редактирование профиля
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                        </svg>
                    </a>
                </div>
                <br>
                <br>
                <div class="row">
                    <a class="btn btn-outline-danger" href="profile.php?<?= $_SERVER['QUERY_STRING'] ?>&delete=1">
                        Уволить сотрудника
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="row" style="text-align: left; width: 700px;">
                    <label for="status"><h4>ФИО</h4></label>
                </div>
                <br>
                <div class="row" style="text-align: left; width: 700px;">
                    <label for="number"><h4>Телефон</h4></label>
                </div>
                <br>
                <div class="row" style="text-align: left; width: 700px;">
                    <label for=""><h4>Мессенджеры</h4></label>
                </div>
                <br>
                <div class="row" style="text-align: left; width: 700px;">
                    <label for="date"><h4>День рождения</h4></label>
                </div>
                <br>
                <div class="row" style="text-align: left; width: 700px;">
                    <label for="email"><h4>E-mail</h4></label>
                </div>
                <br>
                <?
                if ($_GET['empl'] == "montage") {
                    ?>
                    <div class="row" style="text-align: left; width: 700px;">
                        <label for="email"><h4>Табель</h4></label>
                    </div>
                    <br>
                <? }
                ?>
                <div class="row" style="text-align: left; width: 700px;">
                    <label for="email"><h4>Статистика</h4></label>
                </div>
                <br>

            </div>
            <div class="col-3">
                <div class="row" style="text-align: left; width: 500px;">
                    <input class="form-control" id="status" style="width: 300px; text-align: center;" disabled
                           value="<?= $sql[0][0] ?>">
                </div>
                <br>

                <form method="post" action="profile.php?id=<?= $id ?>&u_id=<?= $u_id ?>">
                    <div class="row input-group" style="text-align: left; width: 300px;">
                        <input type="tel" id="number" class="form-control" name="number"
                               style="width: 200px; text-align: center;" maxlength="18" data-tel-input
                               value="<?= $sql[0][2] ?>"
                               aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" style="width: 50px;" type="submit" id="button-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                 fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                            </svg>
                        </button>
                        <a class="btn btn-outline-success" style="width: 50px;" href="tel:<?= $sql[0][2] ?>"
                           id="button-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                 class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                        </a>
                    </div>
                </form>
                <br>
                <div class="row" style="width: 500px;">
                    <div class="row input-group" style="text-align: left; width: 350px;">
                        <?
                        if ($sql[0][7] == true) {
                            ?>
                            <a class="w btn btn-outline-primary" style="width: 101px"
                               href="viber://chat?number=<?= $sql[0][2]; ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="30"
                                     height="30"
                                     preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512">
                                    <rect x="0" y="0" width="512" height="512" fill="none" stroke="none"/>
                                    <path fill="currentColor"
                                          d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8c8.7-9.4 20.7-23.2 29.8-33.7c82.2 6.9 145.3-8.9 152.5-11.2c16.6-5.4 110.5-17.4 125.7-142c15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1c-6 1.9-61.5 15.7-131.2 11.2c0 0-52 62.7-68.2 79c-5.3 5.3-11.1 4.8-11-5.7c0-6.9.4-85.7.4-85.7c-.1 0-.1 0 0 0c-101.8-28.2-95.8-134.3-94.7-189.8c1.1-55.5 11.6-101 42.6-131.6c55.7-50.5 170.4-43 170.4-43c96.9.4 143.3 29.6 154.1 39.4c35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6c-1.1-22-11.4-32.7-32.6-33.9c-8.6-.5-7.8-13.4.7-12.9c27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3c-8.5-.6-7.6-13.5.9-12.9c58 4.2 88.9 44.1 87.8 92.5c-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1c-.6-81.5-54.9-125.9-120.8-126.4c-8.5-.1-8.5-12.9 0-12.9c73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5c-16.2-12.8-31-27.9-42.4-42.4c-10.3-12.9-20.7-28.2-30.8-46.6c-21.3-38.5-26-55.7-26-55.7c-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9c0 0 12.4 14.8 17.7 22.1c5 6.8 11.7 17.7 15.2 23.8c6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7c14.7 8.3 33.4 21.2 45.8 32.9c7 5.7 8.6 14.4 3.8 23.6z"/>
                                </svg>
                            </a>
                            <?
                        }
                        if ($sql[0][8] == true) {
                            if ($sql[0][2][0] != "+") {
                                $TW = $sql[0][2];
                                $TW[0] = 7;
                                $TW[2] = " ";
                                $TW[6] = " ";
                                $TW[11] = " ";
                                $TW[14] = " ";
                                $TW = str_replace(' ', '', $TW);
                                $TW = "+" . $TW;
                            }
                            ?>
                            <a class="btn btn-outline-primary" style="width: 101px"
                               href="https://t.me/<?= $TW ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                     class="bi bi-telegram" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
                                </svg>
                            </a>
                            <?
                        }
                        if ($sql[0][9] == true) {

                            ?>
                            <a class="btn btn-outline-success" style="width: 101px"
                               href="https://wa.me/<?= $TW ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                     class="bi bi-whatsapp" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                </svg>
                            </a>
                        <? }
                        if ($sql[0][7] == false and $sql[0][8] == false and $sql[0][9] == false) {
                            ?>
                            <a class="btn btn-secondary disabled" style="width: 301px;">
                                Данные не найдены
                            </a>
                            <?
                        }

                        ?>

                    </div>
                </div>

                <br>
                <div class="row" style="text-align: left; width: 500px;">
                    <input class="form-control" id="date" style="width: 300px; text-align: center;" disabled
                           value="<? echo date("d-m-Y", strtotime($sql[0][3])); ?>">
                </div>
                <br>
                <form method="post" action="profile.php?id=<?= $id ?>&u_id=<?= $u_id ?>">
                    <div class="row input-group" style="text-align: left; width: 300px;">
                        <input type="email" class="form-control" name="email" id="email"
                               style="width: 250px; text-align: center;"
                               value="<?= $sql[0][4] ?>"
                               aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary" style="width: 50px;" type="submit" id="button-addon2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                 fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                <br>
                <?
                if ($_GET['empl'] == "montage") {
                    $date_1 = new DateTime('-15 days');
                    $date_2 = new DateTime('+15 days');
                    $date_1 = $date_1->format('Y-m-d');
                    $date_2 = $date_2->format('Y-m-d');
                    ?>
                    <div class="row" style="text-align: left; width: 500px;">
                        <a class="btn btn-outline-primary btn"
                           href="../../Stat/Stat.php?id=<?= $id ?>&redact=<?= $u_id ?>&dateStart=<?= $date_1 ?>&dateEnd=<?= $date_2 ?>"
                           style="width: 300px;">Рабочее время сотрудника</a>
                    </div>
                    <br>
                    <?
                }
                ?>
                <div class="row" style="text-align: left; width: 500px;">
                    <a class="btn btn-outline-success btn"
                       href="info_ord/info_ord.php?<?= $_SERVER['QUERY_STRING'] ?>&name=<?= $sql[0][0] ?>"
                       style="width: 300px;">Информация о заявках</a>
                </div>
                <br>
            </div>


        </div>

    </div>
</center>
</body>
</html>