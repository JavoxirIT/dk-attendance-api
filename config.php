<?php
    define('API_KEY','5654516569:AAHzzL9uckislm986VLthXwn2rEKrM26Krs');
    $url = "";
    $host = "localhost"; //"a345111.mysql.mchost.ru"; //;
    $user_bd = "root"; //"u1585231_skladob"; //
    $password = "5588"; //"19890601Bobur"; //
    $db = "students"; //"u1585231_skladob"; //

    $link = mysqli_connect($host, $user_bd, $password, $db);
    mysqli_set_charset($link, "utf8");
    if (!$link) {
        echo "Xato: MySQL bilan aloqa o'rnatib bo'lmadi." . PHP_EOL;
        echo "Errno xato kodi: " . mysqli_connect_errno() . PHP_EOL;
        echo "Xatolik matni: " . mysqli_connect_error() . PHP_EOL;
        exit();
    }
    else{
        // echo "MySQL-ga ulanish o'rnatildi!" . PHP_EOL;
        // echo "Server haqida ma'lumot: " . mysqli_get_host_info($link) . PHP_EOL;
        // exit();
    }
?>