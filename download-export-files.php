<?php

function dowload($link, $name){

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

    // the important part 
    $destination = 'file/'.$name.".xlsx";
    if (file_exists( $destination)) {
        unlink( $destination);
    }
    $file=fopen($destination,"w+");
    fputs($file,$answer);
    if(fclose($file))
    {
        echo "downloaded";
    }
    curl_close($ch);
    // print_r($answer);

}


$array_result = array();
function html_to_obj($html) {
    $dom = new \DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    // print_r($dom->documentElement);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element) {
    $obj = array( "tag" => $element->tagName );
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        }
        else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}

function google($post){
    $GOOGLE_SCRIPT = 'https://script.google.com/macros/s/AKfycbz6aR_Lncfdsv6dshr2ufgIsUPuSE6wxKfQE6CkcL2kWgc6gRwrjwcu7w/exec';

    $today = date("Y-m-d");
    $time = date("H:i:s");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $GOOGLE_SCRIPT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    $r = curl_exec($ch);
    print_r($r);
}

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
function get_content($answer) {
    $json = json_encode(html_to_obj($answer), JSON_PRETTY_PRINT);
    $array = json_decode($json, true);

    echo '<pre>';
    $i=0;
    foreach ($array['children'][1]['children'][0]['children'][6]['children'][3]['children'][1]['children'] as $key => $value) {
        $link_dowloand = 'https://client.atlanticexpresscorp.com'.$value['children'][3]['children'][0]['href'];
        dowload($link_dowloand, $i);
        echo $link_dowloand;
        if ( $i==1 ) {
            break;
        }
        $i++;

    }
    
    return 'ok';
}


$data_link = array(
    'https://client.atlanticexpresscorp.com/exported-documents'
);

$result = array();
foreach ($data_link as $key => $value) {
    $data = link_get($value);

    $data = get_content($data);
    print_r($data);
    // array_push($result, $data);
}
?>