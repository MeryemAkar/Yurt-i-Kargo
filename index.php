<?php

$token = sha1(md5("Arya"));
$data = array("token" => $token, "id" => "1");

$curl = curl_init("http://localhost/test/api.php");
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$answer = curl_exec($curl);
curl_close($curl);

var_dump($answer);
