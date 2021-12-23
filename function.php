<?php

// csvファイルを読み込む（一次元配列で帰ってくる 例）$list[0] = "1,永井,1999"）中に何もなかったらfalseが返ってくる//////////////////////////////////////////////
// $fileは読み込みたいcsvファイル
// function csv_read($file){
//     $fp = fopen($file , "r");

//     $value = fgets($fp);

//     // 中に何もなかったら１そうじゃなければ０を返す
//     $num = $value == NULL ? 1 : 0;

//     // 中身があったとき
//     if($num == 0){
//         $result_list = [];

//         $result_list[] = trim($value);

//         while($value=fgets($fp)){
//             $result_list[] = trim($value);
//         }

//         return $result_list;
//     }
//     // なかった時
//     else{
//         return false;
//     }
// }


// csvファイルを読み込む（一次元配列で帰ってくる 例）$list[0] = "1,永井,1999"）中に何もなかったらfalseが返ってくる//////////////////////////////////////////////
// $fileは読み込みたいcsvファイル
function csv_read($file){
    if(!file_exists($file)){//ファイルの存在チェック
        return false;
    }

    $fp = fopen($file , "r");
    $value = fgets($fp);

    $result_list = [];
    $result_list[] = trim($value);

    if($result_list[0] == NULL){
        return false;
    }

    while($value=fgets($fp)){
        $result_list[] = trim($value);
    }
    return $result_list;
}



// 一次元配列を二次元配列に変換（,や空白で区切っているもの限定 例）1,2,3）（二次元配列で返してくれる）//////////////////////////////////////////////
// $changed_one_listは二次元配列に変えたいもの、$delimitは区切っているもの
function chenge_two_array($changed_one_list , $delimit){

    // $changed_one_listがfalse（中身が空）だった時
    if($changed_one_list == false){
        return false;
    }
    else{
        // returnする二次元配列
        $result_list = [];

        // $changed_one_listの回数分foreachで回し二次元配列を作っていく
        foreach($changed_one_list as $key => $value){

            // ,で区切り一次元配列にし、それを$sub_listに入れる
            $sub_list = explode($delimit , $changed_one_list[$key]);

            // 二次元配列に入れていく
            $result_list[] = $sub_list;
        }
        return $result_list;
    }
}



// csvファイルからデータを読み取る（二次元配列で返してくれる）（１,２,３みたいな感じなのが前提）(区切りは "," 換えたい場合はchange_two_arrayの引数２を変える)///////////////////////////////////////////////////////
function csv_read_secound($file){

    $result = chenge_two_array(csv_read($file) , ',');


    // chenge_two_arrayがfalseだった時（中身がなかった時）
    if($result == false){
        return false;
    }
    
  
     return $result;// 中身があったとき
}





// csvファイルの主キーの最大値＋１を持ってきてくれる（$id_posは主キーが何番目にあるか）(","は区切ってるもの換えたい場合はcsv_read_secoundの引数２をその都度変える)////////////////////////////////////////////////////////////////
function csv_max_id($file , $id_pos){

    // csvファイルを二次元で持ってくる
    $csv_secound_list = csv_read_secound($file , ",");

    // $csv_secound_listがfalseだった時（csvファイルの中身が空だった時）
    if($csv_secound_list == false){
        $max = 0;
        return $max;
    }
    else{
        // 最初の主キーを$maxに入れておく
        $max = $csv_secound_list[0][$id_pos];

        // $maxより大きい主キーがあった場合上書し最後まで比べる
        for($i=1; $i<count($csv_secound_list); $i++){
            if($max < $csv_secound_list[$i][$id_pos]){
                $max = $csv_secound_list[$i][$id_pos];
            }
        }
        // 主キーの最大値の＋１を返す
        return $max+1;
    }
    
}





// csvfileに追記する$appendは追加したい文字または配列（二次元まで可能）////////////////////////////////////////////////////////////////////////////////
function csv_appending($file , $append){
    $fp = fopen("./" . $file , 'a');

    // $appendが配列かどうかをチェックする（配列だったらture）
    if(is_array($append)){


        // $appendが２次元配列かどうかをis_arrayでチェック（２次元ならture）
        if(is_array($append[0])){

            // ループで入れたい二次元配列を入れる
            foreach($append as $key => $value){

                // 二次元配列の各行をimplodeで一つの文字列にし、それをfileに入れていく
                $append_string = implode("," , $value);
                fputs($fp , $append_string . "\n");
            }
            return fclose($fp);
        }

        // 一次元配列だった場合

        // 一次元配列をimplodeで一つの文字列にし、それをfileに入れていく
        $append_string = implode("," , $append);
        fputs($fp , $append_string . "\n");
        return fclose($fp);
    }

    // $appendがただの文字列だった時
    else{
        fputs($fp , $append . "\n");
        return fclose($fp);
    }
}





// csvファイルを上書きし、新たに書き込みをする（２次元配列まで可能）/////////////////////////////////////////////////////////////////////////////////////////
function csv_writing($file , $append){
    $fp = fopen("./" . $file , 'w');

    fclose($fp);

    return csv_appending($file , $append);

}






// csvファイルから特定の列を持ってくる(２次元配列が前提）//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function csv_read_column($file , $bring_num){
    $list = csv_read_secound($file);

    // $listがfalseの時（中身がなかった時）
    if($list == false){
        return false;
    }
    // そうじゃなかったとき
    else{
        $result_list = [];
        foreach($list as $key => $value){
            $result_list[] = $list[$key][$bring_num];
        }
        return $result_list;
    }   
}





// csvファイルから特定の要素を取り出す//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function csv_column_specific($file , $column , $line){
    $list = csv_read_column($file , $column);

    // $listがfalseの時（中身がなかった時）
    if($list == false){
        return false;
    }
    // そうじゃなかったとき
    else{
        return $list[$line];
    }
}




// 空白チェック/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function space_check($check){
    if($check == ''){
        return false;
    } else{
        return true;
    }
}




// 文字列の間にスペースが入っているかチェック(はいっていたらfalse)///////////////////////////////////////////////////////////////////////////////////////////////////////
function space_between_check($check){
    $check1 = str_replace(" " , "" , $check);//半角スペース
    $check2 = str_replace("　" , "" , $check);//全角スペース
    if($check == $check1 && $check== $check2){
        return true;
    }else{
        return false;
    }
}



// $checkが$len1,$len2の間の文字数かチェック(何より上何より下タイプ)(len1＝＝len2だったらfalseになってしまう)/////////////////////////////////////////////////////////////
function compare_length($check , $len1 , $len2){
    $check1 = strlen($check);   //長さを図る


        if($len1 < $len2){   //len1がlen2より小さかった時
            if($len1 < $check1 && $check1 < $len2){
                return true;
            }else{
                return false;
            }


        }else{    //len2がlen1より小さかった時
            if($len2 < $check1 && $check1 < $len1){
                return true;
            }else{
                return false;
            }
        }
}

// compare_lengthの$checkの長さを図らない盤//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function compare_length_non_length($check , $len1 , $len2){

        if($len1 < $len2){   //len1がlen2より小さかった時
            if($len1 < $check && $check < $len2){
                return true;
            }else{
                return false;
            }


        }else{    //len2がlen1より小さかった時
            if($len2 < $check && $check < $len1){
                return true;
            }else{
                return false;
            }
        }
}

// $checkが$len1,$len2の間の文字数かチェック(何以上何以下タイプ)(len1＝＝len2だったらfalseになってしまう)/////////////////////////////////////////////////////////////////
function compare_length_near($check , $len1 , $len2){
    $check1 = strlen($check);   //長さを図る


        if($len1 < $len2){   //len1がlen2より小さかった時
            if($len1 <= $check1 && $check1 <= $len2){
                return true;
            }else{
                return false;
            }


        }else{    //len2がlen1より小さかった時
            if($len2 <= $check && $check <= $len1){
                return true;
            }else{
                return false;
            }
        }
}




// $search_strが$checkの文字の中にあるかチェック/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function particular_character_check($check , $search_str){
    $search_str_pos = strpos($check , $search_str);
    $check_len = strlen($check);

    if(compare_length_non_length($search_str_pos , 0 , $check_len-1)){
        return true;
    }else{
        return false;
    }
}

// $yearがその年より下かチェックする//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function check_year($year){
    if(date("Y") < $year){
        return false;
    }else{
        return true;
    }
}


// パスワードを●●●状態にする////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function pass_hidden($pass){
    $hidden_pass = "";
    $pass_long = strlen($pass);
    
    for($i=0; $i<$pass_long; $i++){
        $hidden_pass .= "●";
    }

    return $hidden_pass;
}



// csvファイルから特定の文字列を探す(なかったらfalse)($check_csv_posは探したい文字列の列)////////////////////////////////////////////////////////////////////////
function in_csv_existing($check , $csv , $check_csv_pos){
    $csv_list = csv_read_secound($csv , ',');

    for($i=0 ; $i<count($csv_list); $i++){
        if($check == $csv_list[$i][$check_csv_pos]){
            return true;
        }
    }

    return false;
}




function get_data($csv){
    if(!file_exists($csv)){
        return false;
    }

    return csv_read_secound($csv);
}



  

// DBからほしいテーブルを配列にして返す(二次元配列で返す)(SQL文に間違いがあったらfalse)($result_list[]の[]に何も書かなかったら普通に番号が入る)
// ($instructionはＳＱＬ文)
// function sql_table_read($link , $instruction){
//     $result = mysqli_query($link , $instruction);

//     if($result == false){
//         return false;
//     }

//     $result_list = [];  
//     while($row = mysqli_fetch_assoc($result)){
//         $result_list[] = $row;
//     }
//     return $result_list;
// }                                                                                             
 




// テーブルに追加する関数（$sql_instructionは登録するときの命令文）（成功したら登録したデータのIDを返す）
function sql_registration($host , $id , $password , $db_name , $sql_instruction){
    $link = mysqli_connect($host , $id , $password , $db_name);
    if(!$link){//DBと接続できなかったとき
        mysqli_close($link);
        return false;
    }
    mysqli_set_charset($link , 'utf8');
    if(mysqli_query($link , $sql_instruction)){//登録できたら通る
        $registration_id = mysqli_insert_id($link);
        mysqli_close($link);
        return $registration_id;
    }
    mysqli_close($link);
    return false;
}


// DBテーブルを配列にする関数（$sql_instructionはSQL文）（成功したら登録したlistを返す）
function sql_table_read($host , $id , $password , $db_name , $sql_instruction){
    $link = mysqli_connect($host , $id , $password , $db_name);
    if(!$link){//DBと接続できなかったとき
        mysqli_close($link);
        return false;
    }
    mysqli_set_charset($link , 'utf8');
    if($result = mysqli_query($link , $sql_instruction)){
        $result_list = [];  
        while($row = mysqli_fetch_assoc($result)){
            $result_list[] = $row;
        }
        return $result_list;
    }
    mysqli_close($link);
    return false;
}


// 特定のレコードを削除する関数
function sql_delete($host , $id , $password , $db_name , $sql_instruction){
    $link = mysqli_connect($host , $id , $password , $db_name);
    if(!$link){//DBと接続できなかったとき
        mysqli_close($link);
        return false;
    }
    mysqli_set_charset($link , 'utf8');
    if(!mysqli_query($link , $sql_instruction)){
        return false;
    }
    mysqli_close($link);
    return true;
}


function sql_count($host , $id , $password , $db_name , $sql_instruction){
    $link = mysqli_connect($host , $id , $password , $db_name);
    if(!$link){//DBと接続できなかったとき
        mysqli_close($link);
        return false;
    }
    mysqli_set_charset($link , 'utf8');
    $result = mysqli_query($link , $sql_instruction);
    
    $row = mysqli_fetch_assoc($result);

    if($row == false){
        return false;
    }
    mysqli_close($link);

    foreach($row as $value){
        $ans = $value;
    }
    return $ans;
}

// 特定にレコードを変更する関数
function sql_update($host , $id , $password , $db_name , $sql_instruction){
    return sql_delete($host , $id , $password , $db_name , $sql_instruction);
}


//年齢をチェックする関数（$const_errorはエラー文、添え字はその都度変える）
function age_check($check , $const_error){
    if(!space_check($check)){//空白チェック
        return $const_error['101'];
    }

    //数値チェック
    if(!is_numeric($check)){
        $check = mb_convert_kana($check , 'n');
        if(is_numeric($check)){//全角数値チェック
            return $const_error['105'];
        }else{
            return $const_error['103'];
        }
    }
    
    if(!compare_length_non_length($check , -1, 123)){//実在している年齢かチェック
        return $const_error['104'];
    }

    return NULL;
}

//名前をチェックする関数（$const_errorはエラー文、添え字はその都度変える）
function name_check($check , $const_error){
    if(!space_check($check)){//空白チェック
        return $const_error['empty']['msg'];
    }

    if(!space_between_check($check)){//間の空白チェック
        return $const_error['typo']['msg'];
    }

    return NULL;
}



function file_result($check , $const_error){
    $check_list = explode('.' , $check);

    if($check_list == NULL){
        return $const_error['file_check']['msg'];
    }

    if(count($check_list) == 1){//"."で区切れなかったときに(countした結果が１だった時に)falseを返す
        return $const_error['file_check']['msg'];
    }

    return end($check_list);//最後の"."の後ろの文字列を返す
}


function file_image_check($check , $const_error){
    $check_result = file_result($check , $const_error);

    if($check_result == $const_error['file_check']['msg']){
        return $const_error['file_check']['msg'];
    }

    $check_result = mb_convert_kana($check_result , 'r');

    if($check_result == 'jpg' || $check_result == 'png' || $check_result == 'gif' || $check_result == 'jpeg' || $check_result == 'JPG' || $check_result == 'PNG' || $check_result == 'GIF' || $check_result == 'JPEG'){
        return NULL;
    }else{
        return $const_error['img']['msg'];
    }

}

 





//配列を区切って何ページできるか　$page_separationは区切りたい個数
function list_page_amount($list , $page_separation){
    return ceil(count($list) / $page_separation);
}

//ページ分のリンクボタンを作る関数$current_locationは現在地
// 例）12...5...1920(5は現在地リンクではない)
function link_page_btn($list , $page_separation , $current_location , $link){
    $page_amount = list_page_amount($list , $page_separation);
    $result_list = [];
    if($page_amount <= 7){
        for($i=0; $i<$page_amount; $i++){
            $result_list[] = '<a href=' . $link . '?page=' . $i+1 . '>' . $i+1 . '</a>';
        }
        return $result_list;
    }
}

//パスワードをハッシュ化する
function pass_hash($pass , $solt , $cost){
    for($i=0; $i<$cost; $i++){
        $pass = md5($solt . $pass);
    }

    return $pass;
}

//ランダムな文字列作成
function rand_str($num_digit , $min_num_digit = null){

    $result = '';
    if($min_num_digit == NULL){
        for($i=0; $i<$num_digit; $i++){
            $result = $result . chr(mt_rand(65,90));
        }
    }else{
        $num = mt_rand($min_num_digit , $num_digit);
        for($i=0; $i<$num; $i++){
            $result = $result . chr(mt_rand(65,90));
        }
    }
    return $result;
}




//拡張子チェック
function file_extension_check($check){
    $check_list = explode('.' , $check);
    if($check_list == NULL || count($check_list) == 1){
        return false;
    }

    //最後の"."の後ろの文字列を返す
    return end($check_list);
}

//拡張子が画像かチェック
function file_img_check($img){
    $check = file_extension_check(mb_strtolower($img));
    if($check == false){
        return false;
    }
    elseif($check != 'jpg' && $check != 'png' && $check != 'gif'){
        return false;
    }
    return $check;
}



//画像縮小をする際に、指定のサイズに入る最大サイズの大きさを求める
function img_size_change($original_width , $original_height , $change_width , $change_height){
    // 結果を返すリスト
    $result_list = [
        'height' => '',
        'width' => ''
    ];

    //元のサイズが指定の大きさ以下のとき(そのサイズをそのまま返す)
    if($original_height <= $change_height && $original_width <= $change_width){
        $result_list['height'] = $original_height;
        $result_list['width'] = $original_width;
        return $result_list;
    }

    //高さの比率
    $height_raito = $original_height / $change_height;
    // 幅の比率
    $width_raito = $original_width / $change_width;

    //幅の比率が大きかった時
    if($height_raito <= $width_raito){
        $result_list['width'] = $change_width;
        $result_list['height'] = floor($original_height / $width_raito);
        return $result_list;
    }

    //高さの比率が大きかった時
    $result_list['height'] = $change_height;
    $result_list['width'] = floor($original_width / $height_raito);
    return $result_list;
}



//加工したい画像をまず所定の場所に移してからこの関数を使う
function img_shrink($pass , $img_name , $img_new_name = NULL , $width , $height){
    $img_data = getimagesize($pass . $img_name);
    //拡張子が画像かチェック
    if(!$img_type = file_img_check($img_name)){
        return false;
    }

    // jisに変換する
    $file_name = mb_convert_encoding($pass . $img_name , 'sjis' , 'utf8');
    //背景の黒い新しい画像ファイルを作成
    $img_out = imagecreatetruecolor($width , $height);

    //pngの時
    if($img_type == 'png'){
        $img_in = imagecreatefrompng($file_name);
        imagealphablending($img_out, false);
        imagesavealpha($img_out, true);
    }
    elseif($img_type == 'jpg'){
        $img_in = imagecreatefromjpeg($file_name);
    }
    else{
        $img_in = imagecreatefromgif($file_name);
    }

    //画像を出力
    imagecopyresampled($img_out , $img_in , 0 , 0 , 0 , 0 , $width , $height , $img_data[0] , $img_data[1]);
    

    //画像ファイルの書き出し
    //新しい名前で登録しない場合
    if($img_new_name == NULL){
        if($img_type == 'png'){
            imagepng($img_out , $pass . $img_name);
        }
        elseif($img_type == 'jpg'){
            imagejpeg($img_out , $pass . $img_name);
        }
        else{
            imagegif($img_out , $pass . $img_name);
        }
    }
    //新しい名前で登録する場合
    else{
        if($img_type == 'png'){
            imagepng($img_out , $pass . $img_new_name);
        }
        elseif($img_type == 'jpg'){
            imagejpeg($img_out , $pass . $img_new_name);
        }
        else{
            imagegif($img_out , $pass . $img_new_name);
        }
    }

    imagedestroy($img_in);
	imagedestroy($img_out);
    return true;
}


// $seek_strが$checkの中に存在しているかチェック($seek_strが先頭、語尾にある場合はfalse)
function str_exist_in_check_between($check , $seek_str){
    $num = strpos($check , $seek_str);

    if($num === false || $num == 0 || $num == strlen($check)){
        return false;
    }

    return true;
}

// $seek_strが$checkの中に存在しているかチェック
function str_exist_in_check($check , $seek_str){
    $num = strpos($check , $seek_str);

    if($num === false){
        return false;
    }

    return true;
}

//配列の階層を検索
function list_dimension($check_list , $blank=false ,  $count=0){
    if(!is_array($check_list)){
        return $count;
    }else{
        $count++;
        $tmp = ($blank) ? array($count) : array(0);
        foreach($check_list as $value){
            $tmp[] = list_dimension($value, $blank, $count);
        }
        return max($tmp);
    }
}

