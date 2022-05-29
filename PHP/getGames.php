<?php
    $key = '?key=ab7a5b9fbdc04a96823d553be23f4a29';
    $url = 'https://api.rawg.io/api/games/';
    $game = $_GET['Game'];

    $curl = curl_init();
    $geturl = $url . $game . $key;
    curl_setopt($curl, CURLOPT_URL, $geturl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    $json = (array)json_decode($result);
    if(array_key_exists('redirect', $json)){
        $curl = curl_init();
        $geturl = $url . $json['slug'] .$key ;
        curl_setopt($curl, CURLOPT_URL, $geturl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
    }

    echo($result);
?>