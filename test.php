<?php

require_once './function.php';
$a = [];
$a[] = "@as2c";
$a[] = 2;
$a[] = 3;

$c = [];
$c[] = "dccs";
$c[] = 2;
$c[] = 3;

$b = [];
$b[0][0] = 1;
$b[0][1] = 2;
$b[0][2] = 3;
$b[1][0] = 4;
$b[1][1] = 5;
$b[1]["aaa"] = "ccc";

$aaa = "aaa.jpg";

const ERROR = [
    '101' => '未入力です',
    '102' => '入力に誤りがあります',
    '103' => '数値で入力してください',
    '104' => '実在している年齢で入力してください'
];

if(isset($_POST['btn'])){
    var_dump($_FILES['img']);
    
}else{
    echo 'aaa';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="./test.php" method="POST"　enctype="multipart/form-data">
    <input type="file" name="img">
    <button name="btn">aaaaa</button>
</form>


</body>
</html>







<html>
<body>
    

</body>

</html>



