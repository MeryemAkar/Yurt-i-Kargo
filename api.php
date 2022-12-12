<?php

require_once("connect.php");

header("Content-Type:application/json; charset=utf8");

$process = $_SERVER["REQUEST_METHOD"];
parse_str(file_get_contents("php://input"),$data);

if ($data["token"] != sha1(md5("Arya"))) {
    $process["contents"] = $kargo;
    $process["securycode"] = 901;
    $process["message"] = "Unauthorized Access!";
}

function process($contents,$securycode,$message){
    $process["contents"] = $contents;
    $process["securycode"] = $securycode;
    $process["message"] = "$message";
    $result = json_encode($process, JSON_UNESCAPED_UNICODE);
    echo $result;
}

if ($demand == "GET") {
    $cargo = $process->query("select * from kargo where id=$data[id]", PDO::FETCH_ASSOC);

    if ($cargo->rowCount() > 0) {
        foreach ($cargo as $citys) {
            $kargo[] = array("adsoyad" => $citys["adsoyad"], "tckimlik" => $citys["tckimlik"], "adres" => $citys["adres"]);
        }
        $process["contents"] = $kargo;
        $process["kod"] = 900;
        $process["mesaj"] = "Kayıt Listelendi!";
    } else {
        $process["contents"] = "";
        $process["kod"] = 902;
        $process["mesaj"] = "Kayıt Bulunamadı!";
    }
}

?>