<?php

function getDeact($cookie)
{

    $file = "resultdata/loginresponse.txt";
    $response = file_get_contents($file);


    $regexp = "/<a[\s]*id[\s]*=[\s]*\"deactivate([\d]*)[^>]*data-token[\s]*=\"([\w\d.\-\+\*\/]*)/";
    preg_match_all($regexp, $response, $matches, PREG_PATTERN_ORDER);

    $deleteID = [];
    $deleteToken = [];

    foreach ($matches[1] as $item) {
        array_push($deleteID, $item);
    }

    foreach ($matches[2] as $item) {
        array_push($deleteToken, $item);
    }

    if (count($deleteID) > 0) {
        for ($i = 0; $i < count($deleteID); $i++) {
            deactivatePosts($cookie, $deleteID[$i], $deleteToken[$i]);
            sleep(rand(60, 120));
        }
    } else {
        $errorMsg = date("Y-m-d H:i:s") . " Error deactivating messages\n";
        $log = 'logs/log.txt';
        file_put_contents($log, $errorMsg, FILE_APPEND);
    }
}

function deactivatePosts($cookie, $deleteID, $deleteToken)
{

// создание объекта curl
    $ch = curl_init();

// задаем URL

//$url = "http://olx/server.php";
    $url = "https://www.olx.ua/ajax/myaccount/deactivateme/";

    curl_setopt($ch, CURLOPT_URL, $url);

// указываем что это POST запрос
    curl_setopt($ch, CURLOPT_POST, true);

// указываем, чтобы нам вернулось содержимое после запроса
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// в случае необходимости, следовать по перенаправлени¤м
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Connection: keep-alive',
        'Cache-Control: max-age=0',
        'Origin: https://www.olx.ua',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Referer: https://www.olx.ua/post-new-ad/?bs=listing_adding',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2',
        'Cookie: ' . $cookie
    ));

    $post_data = "adID=" . $deleteID . "&reasonID=6&text=&token=" . $deleteToken;

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
//    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
//    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');

    $result = curl_exec($ch);

    file_put_contents(dirname(__FILE__) . "/resultdata/deactresponse.txt", $result);
}