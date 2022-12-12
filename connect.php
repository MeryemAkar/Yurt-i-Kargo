<?php

    $connect = new PDO("mysql:host=localhost;dbname=kargo;charset=utf8","root","");
    $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $connect -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 



?>