<?php

set_time_limit(100000);
include_once 'db/dbConn.php';
include_once 'getAddingKey.php';
include_once 'getDeactInfo.php';
include_once 'post.php';
include_once 'getDeleteInfo.php';
include_once 'goSomewhere.php';
include_once 'getCookie.php';

$db = dbConn();
global $counter;

function updateCounter($db)
{
    $sql = $db->prepare('SELECT `couner` FROM counter WHERE `counter`.`id` = 0');
    $sql->execute();
    $counter = $sql->fetch(PDO::FETCH_NUM);
    return $counter;
}

$counter = updateCounter($db);

$sql = $db->prepare('SELECT COUNT(1) FROM logindata');
$sql->execute();
$count = $sql->fetch(PDO::FETCH_NUM);

checkCounter($counter, $count, $db);
$counter = updateCounter($db);
plusCounter($counter, $db);


function checkCounter($counter, $count, $db)
{
    if ($counter[0] > $count[0]) {
        $sql = $db->prepare('UPDATE `counter` SET `couner` = 1 WHERE `counter`.`id` = 0;');
        $sql->execute();
        print_r("counter updated");
    }
}

function plusCounter($counter, $db)
{
    $c = $counter[0];
    $c++;
    $sql = $db->prepare('UPDATE `counter` SET `couner` = ' . $c  . ' WHERE `counter`.`id` = 0');
    $sql->execute();
}


function getLoginInfo($counter, $db) {
    $sql = $db->prepare('SELECT * FROM logindata WHERE `logindata`.`id` = ?');
    $sql->execute(array($counter[0]));
    $ldata = $sql->fetch(PDO::FETCH_ASSOC);
    return $ldata;
}

$loginInfo = getLoginInfo($counter, $db);
print_r($loginInfo);

$login = $loginInfo['login'];
$password = $loginInfo['password'];
$tel = $loginInfo['tel'];


$login_url = 'https://www.olx.ua/account/?ref%5B0%5D%5Baction%5D=myaccount&ref%5B0%5D%5Bmethod%5D=index#login';

$post_data = 'login%5Bemail%5D=' . $login . '&login%5Bpassword%5D=' . $password . '&login%5Bremember-me%5D=on';

$agent = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';

$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_URL, $login_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
curl_setopt($ch, CURLOPT_HEADER, 1);
$postResult = curl_exec($ch);
curl_close($ch);


$file = "resultdata/loginresponse.txt";
file_put_contents($file, $postResult);


//post categroies for landscape - 1433 611 641  48


$cookie = getCookie();
sleep(rand(20, 25));
$refLink = goSomewhere($cookie);
sleep(rand(15, 25));
getDeact($cookie);
sleep(rand(10, 20));
getDelete($cookie);
sleep(rand(20, 30));
$addingKey = getKey($refLink, $cookie);
sleep(rand(30, 40));
post($cookie, $addingKey, 1433, $tel, $login);
print_r($login);
sleep(rand(30, 40));
//$addingKey = getKey($refLink, $cookie);
//sleep(rand(50, 60));
//post($cookie, $addingKey, 641, $tel, $login);
