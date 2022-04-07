<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма Заявки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="FormOrd.css">

</head>
<body>
<center>
    <h1>Новая Заявка</h1>
</center>
<form method="post">
<center>
    <div class="row">
        <fieldset class="info">
            <div class="leg">
                <legend class="order"><center> Юридическая информация</center></legend>
            </div>
            <br><br>
            <center>
                <div class="row">
                    <div class="col">
                        <label for="name">ФИО</label>
                    </div>
                    <div class="col">
                        <input type="text" name="name" value="" />
                    </div>
                </div> <br>
                <div class="row">
                    <div class="col">
                        <label for="email">Моб. Телефон</label>
                    </div>
                    <div class="col">
                        <input type="text" name="number" value= "" />
                    </div>
                </div><br>
                <div class="row">
                    <div class="col">
                        <label for="email">Email</label>
                    </div>
                    <div class="col">
                        <input type="text" name="email" autocomplete = "off" value= "" />
                    </div>
                </div><br>
            </center>

        </fieldset>
        <fieldset class="info">
            <div class="leg">
                <legend class="order" ><center>Компания Заявитель</center></legend>
            </div><br><br>
            <center>
                <div class="row">
                    <div class="col">
                        <label for="name">Название Компании</label>
                    </div>
                    <div class="col">
                        <input type="text" name="CompanyName" value="" />
                    </div>
                </div><br>
                <div class="row">
                    <div class="col">
                        <label for="name">Адрес Компании Заявителя</label>
                    </div>
                    <div class="col">
                        <textarea class="form-control" rows = "2" aria-label="With textarea"></textarea>
                    </div>
                </div><br>
                <br> <br>
            </center>
        </fieldset>
    </div>
    <div class="row">
        <fieldset class="info">
            <div class="leg">
                <legend class="order" > <center> Техническое Задание </center> </legend>
            </div>
            <br><br>
            <div class="row">
                <a>
                    <label for = "name"> Количество заявок </label>
                    <select class="sum_of_orders">
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
                </a><br><br>



                <div class="col">
                    <center>
                        <label for="name">Вид Работ</label>
                        <select class="typework" name = "typework" size="1">
                            <option value="1">Изготовление и обработка</option>
                            <option  value="2">Монтаж</option>
                            <option  value="3">Замеры</option>
                            <option  value="4">Замеры автомобиля</option>
                            <option  value="5">Монтаж автомобиля</option>
                            <option  value="5">Доставка</option>
                        </select>
                    </center>
                    <br>
                </div>
            </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-8">
                            <label for="name">Описание</label>
                            <textarea class="form-control" aria-label="With textarea"></textarea>
                        </div>
                        <div class="col-6 col-md-4">
                            <label for="name">Прикрепить Фотографии</label>
                            <input class="file" type="file">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</center>
</form>
</body>
</html>


