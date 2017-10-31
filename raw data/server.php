<?php

echo "AAA";

file_put_contents("post.txt", print_r($_POST, true));
//file_put_contents("raw.txt", file_get_contents('php://input'));