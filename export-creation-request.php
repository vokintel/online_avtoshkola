<?php

function link_get($link){

    //initial request with login data

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://client.atlanticexpresscorp.com/login/check');
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "_username=vokintel@icloud.com&_password=trewQ123456&login=Login");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
    curl_setopt($ch, CURLOPT_COOKIEFILE, '/');  //could be empty, but cause problems on some hosts
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }

    //another request preserving the session

    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_POST, false);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, "");
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }

    return $answer;

}
// отправляем запрос на создание експорт-файлов
$invoices = link_get('https://client.atlanticexpresscorp.com/excel/invoices');
$payments = link_get('https://client.atlanticexpresscorp.com/excel/payments');

?>