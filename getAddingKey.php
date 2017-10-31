<?php
function getKey($link, $cookie)
{
    // Инициализируем курл
    $ch = curl_init('https://www.olx.ua/post-new-ad/?bs=listing_adding');

// Параметры курла
    curl_setopt($ch, CURLOPT_HEADER, 0);
// Следующая опция необходима для того, чтобы функция curl_exec() возвращала значение а не выводила содержимое переменной на экран
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Connection: keep-alive',
        'Cache-Control: max-age=0',
        'Origin: https://www.olx.ua',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Referer: ' . $link,
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2',
        'Cookie: ' . $cookie
    ));

// Получаем html
    $response = curl_exec($ch);
    $file = "resultdata/addingkey.txt";
    file_put_contents($file, $response);
// Отключаемся
    curl_close($ch);

    $regexp = '/<input[\s\w=\"\']*name[\s]*=[\s]*\"data\[adding_key\]\"[\s]*value[\s]*=[\s]*\"([\w0-9.]*)\"/';

// Находим и сохраняем нужный фрагмент
    preg_match($regexp, $response, $matches);
    print_r($matches[1]);
    return $matches[1];
}