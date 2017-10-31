<?php

function dbConn() {

    $user = 'olx_user';
    $pass = 'fE5WwVI6GaTjuGWK';
    try {
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=olx', $user, $pass);
        $dbh->exec('SET CHARACTER SET utf8');
    } catch (PDOException $e) {
        print "Ошибка!: " . $e->getMessage() . "<br/>";
        die();
    }
    return $dbh;
}