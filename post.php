<?php

function post($cookie, $addingKey, $mainCat, $tel, $login)
{
    include_once 'db/dbConn.php';
    $db = dbConn();

    if ($mainCat == 48) {
        $sql = $db->prepare('SELECT COUNT(1) FROM landscape');
        $sql->execute();
        $textCount = $sql->fetch(PDO::FETCH_NUM);
        $sql = null;
        $textCounter = rand(1, $textCount[0]);

        $sql = $db->prepare('SELECT COUNT(1) FROM cat');
        $sql->execute();
        $catCount = $sql->fetch(PDO::FETCH_NUM);
        $sql = null;
        $catCounter = rand(1, $catCount[0]);

        $sql = $db->prepare('SELECT * FROM landscape WHERE `landscape`.`id` = ?');
        $sql->execute(array($textCounter));
        $text = $sql->fetch(PDO::FETCH_ASSOC);
        $sql = null;

        $sql = $db->prepare('SELECT * FROM cat WHERE `cat`.`id` = ?');
        $sql->execute(array($catCounter));
        $cat = $sql->fetch(PDO::FETCH_NUM);
        $sql = null;
    } else if ($mainCat == 1433) {
        $sql = $db->prepare('SELECT COUNT(1) FROM irrigation');
        $sql->execute();
        $textCount = $sql->fetch(PDO::FETCH_NUM);
        $sql = null;
        $textCounter = rand(1, $textCount[0]);

        $sql = $db->prepare('SELECT COUNT(1) FROM cat');
        $sql->execute();
        $catCount = $sql->fetch(PDO::FETCH_NUM);
        $sql = null;
        $catCounter = rand(1, $catCount[0]);

        $sql = $db->prepare('SELECT * FROM irrigation WHERE `irrigation`.`id` = ?');
        $sql->execute(array($textCounter));
        $text = $sql->fetch(PDO::FETCH_ASSOC);
        $sql = null;

        $sql = $db->prepare('SELECT * FROM cat WHERE `cat`.`id` = ?');
        $sql->execute(array($catCounter));
        $cat = $sql->fetch(PDO::FETCH_NUM);
        $sql = null;
    }


    $pic1 = rand(1, 30);
    $pic2 = rand(1, 30);
    $pic3 = rand(1, 30);

//    print_r($text);
//    echo "</br>";
//    print_r($cat);


// создание объекта curl
    $ch = curl_init();

// задаем URL

//$url = "http://olx/server.php";
    $url = "https://www.olx.ua/post-new-ad/?bs=listing_adding";

    curl_setopt($ch, CURLOPT_URL, $url);

// указываем что это POST запрос
    curl_setopt($ch, CURLOPT_POST, true);

// указываем, чтобы нам вернулось содержимое после запроса
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// в случае необходимости, следовать по перенаправлени¤м
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


    $fields = array(
        array("name" => "data[title]", "data" => $text['title']),
        array("name" => "data[category_id]", "data" => $mainCat),
        array("name" => "data[offer_seek]", "data" => ""),
        array("name" => "data[param_price][0]", "data" => "price"),
        array("name" => "data[param_price][1]", "data" => rand(130, 170)),
        array("name" => "data[param_price][currency]", "data" => "USD"),
        array("name" => "[param_currency]", "data" => ""),
        array("name" => "data[private_business]", "data" => "private"),
        array("name" => "data[description]", "data" => $text['text']),
        array("name" => "data[riak_key]", "data" => ""),
        array("name" => "image[1]", "data" => "@" . dirname(__FILE__) . "/img/" . $pic1 . ".jpg"),
        array("name" => "image[2]", "data" => "@" . dirname(__FILE__) . "/img/" . $pic2 . ".jpg"),
        array("name" => "image[3]", "data" => "@" . dirname(__FILE__) . "/img/" . $pic3 . ".jpg"),
        array("name" => "image[4]", "type" => "file", "data" => ""),
        array("name" => "image[5]", "type" => "file", "data" => ""),
        array("name" => "image[6]", "type" => "file", "data" => ""),
        array("name" => "image[7]", "type" => "file", "data" => ""),
        array("name" => "image[8]", "type" => "file", "data" => ""),
        array("name" => "data[gallery_html]", "data" => "1"),
        array("name" => "data[city_id]", "data" => "268"),
        array("name" => "data[city]", "data" => "Киев, Киевская область, Дарницкий"),
        array("name" => "data[district_id]", "data" => "3"),
        array("name" => "loc-option", "data" => "loc-opt-2"),
        array("name" => "data[map_zoom]", "data" => "11"),
        array("name" => "data[map_lat]", "data" => "50.40931"),
        array("name" => "data[map_lon]", "data" => "30.69263"),
        array("name" => "data[phone]", "data" => $tel),
        array("name" => "data[payment_code]", "data" => ""),
        array("name" => "data[sms_number]", "data" => ""),
        array("name" => "data[adding_key]", "data" => $addingKey),
        array("name" => "paidadFirstPrice", "data" => ""),
        array("name" => "paidadChangesLog", "data" => ""),
        array("name" => "data[suggested_categories][0]", "data" => $cat[1]),
        array("name" => "data[suggested_categories][1]", "data" => $cat[2]),
        array("name" => "data[suggested_categories][2]", "data" => $cat[3]),
        array("name" => "data[suggested_categories][3]", "data" => $cat[4]),
        array("name" => "data[map_radius]", "data" => "0")
    );

    $data = getPostData($fields);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Connection: keep-alive',
        'Cache-Control: max-age=0',
        'Origin: https://www.olx.ua',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Referer: https://www.olx.ua/post-new-ad/?bs=listing_adding',
//        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2',
        'Cookie: ' . $cookie
    ));

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');

    print_r($data);
    
    $result = curl_exec($ch);

    file_put_contents(dirname(__FILE__) . "/resultdata/postresponse.txt", $result);

    $msg = date("Y-m-d H:i:s") . "\\n Succes post from " . $login . " to category " . $mainCat . "\\n";
    $log = 'logs/log.txt';
    file_put_contents($log, $msg, FILE_APPEND);
}

function getPostData($data)
{
    $ret = array();

    foreach ($data as $item) {
        $ret[$item["name"]] = $item["data"];
    }

    return $ret;
}