<?php

function getCookie()
{
    $file = 'resultdata/loginresponse.txt';
    $rawContent = file_get_contents($file);

    $contentArray = explode("\n", $rawContent);

    $cookieArray = [];

    for ($i = 0; $i < 50; $i++) {
        $stringArray = explode(":", $contentArray[$i]);
        if ($stringArray[0] == "Set-Cookie") {
            $subStringArray = explode(";", $stringArray[1]);
            array_push($cookieArray, trim($subStringArray[0]));
        }
    }
    $cookie = implode("; ", $cookieArray);
    return $cookie;
}