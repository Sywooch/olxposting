<?php

function goSomewhere($cookie)
{
    include_once 'db/dbConn.php';
    $db = dbConn();

    $sql = $db->prepare('SELECT COUNT(1) FROM links');
    $sql->execute();
    $num = $sql->fetch(PDO::FETCH_NUM);

    $rnd = rand(1, $num[0]);

    $sql = $db->prepare('SELECT * FROM links WHERE `links`.`id`=?');
    $sql->execute(array($rnd));
    $link = $sql->fetch(PDO::FETCH_ASSOC);

// Инициализируем курл
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $link['link']);

// Параметры курла
    $agent = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
// указываем, чтобы нам вернулось содержимое после запроса
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Connection: keep-alive',
        'Cache-Control: max-age=0',
        'Origin: https://www.olx.ua',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Referer: https://www.olx.ua/myaccount/#login',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2',
        'Cookie: ' . $cookie
    ));

// в случае необходимости, следовать по перенаправлени¤м
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
    curl_setopt($ch, CURLOPT_HEADER, true);


// Получаем html
    $response = curl_exec($ch);
    $file = "resultdata/goSmwhr.txt";
    file_put_contents($file, $response);

// Отключаемся
    curl_close($ch);

    return $link['link'];
}