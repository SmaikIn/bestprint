<?php
session_start();
require "../config/config.php";
const TOKEN = '5338858349:AAHDW-9nnSryN1cMAPtRD9k1mryEWr_kYP0';
$method = 'getUpdates';
$url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
if (isset($_SESSION['last_message'])) {
    $params = [
        'offset' => $_SESSION['last_message'],
    ];
    $url = $url . "?" . http_build_query($params);
}
$response = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
echo "<pre>";
print_r($response);
echo "</pre>";
$cnt = 0;
for ($i = 0;
     $i < count($response['result']);
     $i++) {
    $last_message = $response['result'][$i]['update_id'];
    $cnt = 1;
    $text_message = $response['result'][$i]['message']['text'];
    $cnt_cnt = 0;
    if ($text_message == "/start") {
        $method = "sendMessage";
        $params = [
            'chat_id' => $response['result'][$i]['message']['chat']['id'],
            'text' => "Здравствуйте Я бот который ведёт учёт вашего рабочего времени. Если я вам ответил, значит я работаю. Вводите команды согласно инструкции",
        ];
        $url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
        $url = $url . "?" . http_build_query($params);
        file_get_contents($url);
        $cnt_cnt++;
    }
    if (strlen($text_message) == 11 || strlen($text_message) == 12 || strlen($text_message) == 10) {
        $text_obed = $text_message[0] . $text_message[1] . $text_message[2] . $text_message[3] . $text_message[4] . $text_message[5] . $text_message[6] . $text_message[7];

        if ($text_obed == "Обед") {
            $U_ID = $text_message[strlen($text_message) - 3] . $text_message[strlen($text_message) - 2] . $text_message[strlen($text_message) - 1] . $text_message[strlen($text_message)];
            echo $U_ID;
            $sql = "SELECT catID FROM users WHERE id = " . $U_ID;
            $sql = mysqli_query($connect, $sql);
            $sql = mysqli_fetch_all($sql);
            if ($sql[0][0] != 5) {
                $method = "sendMessage";
                $params = [
                    'chat_id' => $response['result'][$i]['message']['chat']['id'],
                    'text' => "Вы не монтажник. Система не может проставить вам обед.",
                ];
                $url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
                $url = $url . "?" . http_build_query($params);
                file_get_contents($url);
                $cnt_cnt++;
            } else {
                date_default_timezone_set('Europe/Riga');
                $today = date("Y/m/d");
                $time = date("H:i:s");
                $sql = "SELECT name FROM users WHERE id = " . $U_ID;
                $sql = mysqli_query($connect, $sql);
                $sql = mysqli_fetch_all($sql);


                $query = "SELECT max(id) FROM `worktime` WHERE u_id = '$U_ID' ";
                $query = mysqli_query($connect, $query);
                $query = mysqli_fetch_all($query);

                $id = $query[0][0];
                $query = "SELECT * FROM `worktime` WHERE  id = '$id'";
                $query = mysqli_query($connect, $query);
                $query = mysqli_fetch_all($query);

                if (empty($query[0][0])) {
                    mysqli_query($connect, "INSERT INTO `worktime`(`id`, `u_id`, `TimeStart`, `TimeEnd`, `Date`, `TimeResult`, OverTime) VALUES (NULL,'$U_ID','$time',NULL ,'$today',NULL,0)");
                    $obed = "начат";
                } else {

                    $id = $query[0][0];
                    $query = "SELECT * FROM `worktime` WHERE  id = '$id'";
                    $query = mysqli_query($connect, $query);
                    $query = mysqli_fetch_all($query);
                    if (empty($query[0][3])) {
                        mysqli_query($connect, "Update `worktime` SET `TimeEnd` = '$time' WHERE id = '$id'");
                        mysqli_query($connect, "Update `worktime` SET `TimeResult` = `TimeEnd` - `TimeStart` WHERE id = '$id'");
                        $obed = "закончен";

                    } else {
                        mysqli_query($connect, "INSERT INTO `worktime`(`id`, `u_id`, `TimeStart`, `TimeEnd`, `Date`, `TimeResult`, OverTime) VALUES (NULL,'$U_ID','$time',NULL ,'$today',NULL,0)");
                        $obed = "начат";
                    }

                }
                $answer = $sql[0][0] . " обед успешно " . $obed . "
                    Время: " . date("H:i:s") . " 
                    Дата " . date("d/m/Y");
                $method = "sendMessage";
                $params = [
                    'chat_id' => $response['result'][$i]['message']['chat']['id'],
                    'text' => $answer,
                ];
                $url = 'https://api.telegram.org/bot' . TOKEN . '/' . $method;
                $url = $url . "?" . http_build_query($params);
                file_get_contents($url);
                $cnt_cnt++;


            }
        }


    }
}
if ($cnt == 1) {
    $last_message++;
    $_SESSION['last_message'] = $last_message;
}


print_r($_SESSION);
?>
<script>
    setTimeout(function () {
        location.reload();
    }, 5000);
</script>