<?php
require_once './func/function.php';

$list = csv_read('./csv/type.csv');

var_dump($list);