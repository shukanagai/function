<?php
$link = mysqli_connect('localhost' , 'root' , '' , 'ph23_sample');

mysqli_set_charset($link , 'utf8');

$result = mysqli_query($link , "SELECT name , age FROM sample WHERE name = '永山'");

$row = mysqli_fetch_assoc($result);

mysqli_close($link);


var_dump($row);