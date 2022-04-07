<?php
require "../config/config.php";
require "../config/auth.php";
$id = $_GET['id'];
$category = $_GET['category'];
?>
<!doctype html>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация нового пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="RegStyle.css">
</head>
<body>
<center>
    <div class ="container mt-4">
        <h2>Новая заявка</h2>
        <form method="post" action="../Personal_Area/lk.php?id=<?=$id?>">
            <button type="submit" class="btn btn-danger btn-sm">Вернуться в личный кабинет</button>
        </form>
        <br>
        <form action="Script/Script_Form.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$id?>">
            <div class="name">
                <div class="row">
                    <div class="col">
                        <div class="place">
                            <h5>Вид работ</h5>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="task" id="task" autocomplete= "off" value="Сборка и обработка"  disabled="disabled">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Заказчик</h5>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="company" id="company" required placeholder="Пример: DNS " autocomplete= "on">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>E-mail</h5>
                    </div>
                    <div class="col">
                        <input type="text"  class="form-control" name="email" id="email" placeholder="Не обязательно" autocomplete= "off">
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
                            <input type="text" class="form-control" name="Full_name" id = "Full_name" required autocomplete="on">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Моб. Телефон</h5>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="number" id="number" required placeholder="Пример: 89521234567" autocomplete= "on">
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
                            <input type="text" class="form-control" name="Full_name_2" id = "Full_name_2" autocomplete="on">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Моб. Телефон</h5>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="number_2" id="number_2"  placeholder="Пример: 89521234567" autocomplete= "on">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Адрес места выполнения монтажа</h5>
                    </div>
                    <div class="col">
                        <textarea class="form-control" name = "address" id = "address" required placeholder="Пример: г. Калининград, Ленинский проспект 16" autocomplete="on" rows = "3"></textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col">
                        <h5>Количество заявок</h5>
                    </div>
                    <div class="col">
                        <select class="form-select" required>
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                            <option value="3"> 3 </option>
                            <option value="4"> 4 </option>
                            <option value="5"> 5 </option>
                            <option value="6"> 6 </option>
                            <option value="7"> 7 </option>
                            <option value="8"> 8 </option>
                            <option value="9"> 9 </option>
                            <option value="10"> 10 </option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <h5>Описание характеристик заказа</h5>
                    <div class ="size">
                        <textarea class="form-control" name = "techtask" id = "techtask" required placeholder="Описание характеристик заказа" autocomplete="off" rows = "3"></textarea>

                    </div>

                    <div class="col">

                    </div>
                    <div class="col">
                         </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <h5>Прикрепить Фотографии</h5>
                    </div>
                    <div class="col">
                        <input class = "form-control" type="file" name="filename"  required accept="image/jpeg, image/png">
                    </div>
                </div>
                <br>
                <div class="row">
                    <button type="submit" class="btn btn-success btn-lg btn-block">Оформить заявку</button>
                </div>
            </div>
        </form>
    </div>
</center>


</body>
</html>