<?php   
require "../config/config.php";
require "../config/auth.php";
session_start();
$id = $_GET['id'];
$category = $_GET['category'];
$cnt_order = $_GET['cnt_order'];
if (empty($cnt_order)) {
    $cnt_order = 1;
}
?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Создание заявки </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="Step1.css">
</head>
<body>
<center>
    <div class="container mt-4">
        <div class="row">
            <div class="col" style="text-align: left">
                <h1>Новая заявка</h1>
                <br>

            </div>
            <div class="col" style="text-align: right">
                <form method="post" action="../Personal_Area/lk.php?id=<?= $id ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Вернуться в личный кабинет</button>
                </form>
            </div>
        </div>

        <br>
        <form action="Step2/FormOrd_Mounting_Step2.php?id=<?= $id ?>&step1=1" method="post"
              enctype="multipart/form-data">
            <div class="name">
                <div class="row">
                    <div class="col">
                        <div class="place">
                            <h5>Вид работ</h5>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="task" id="task" autocomplete="off" value="Монтаж"
                               disabled="disabled">
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
                        <input type="text" class="form-control" name="number" id="number" required
                               value="<?= $_SESSION['number'] ?>"
                               placeholder="Пример: 89521234567" autocomplete="on">
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
                        <input type="text" class="form-control" name="number_2" id="number_2"
                               value="<?= $_SESSION['number_2'] ?>"
                               placeholder="Пример: 89521234567" autocomplete="on">
                    </div>
                </div>
                <br>
                <div class="row">
                    <button type="submit" class="btn btn-success">К Шагу №2</button>
                </div>
            </div>
        </form>
    </div>
</center>
</body>
</html>