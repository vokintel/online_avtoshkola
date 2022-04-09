<?php


set_time_limit(300);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
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

    $img = array();
    $json = json_encode(html_to_obj($answer), JSON_PRETTY_PRINT);
    $array = json_decode($json, true);
    // echo '<pre>';
    // echo '<pre>';
    $type = $array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][1]['children'][1]['children'][0]['children'][4]['children'][1]['html'];
    // echo '<pre>';
    // print_r();
    // die;
    if (!isset($array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'][1]['children'][0]['children'][7]['children'][1]['children'][0]['href'])) {
        $Tracking = '';
    } else {
        $Tracking = $array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'][1]['children'][0]['children'][7]['children'][1]['children'][0]['href'];
    }

    if (empty($Tracking)) {
        if (!isset($array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'][1]['children'][0]['children'][13]['children'][1]['children'][0]['href'])) {
        $Tracking = '';
        } else {
            $Tracking = $array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'][1]['children'][0]['children'][13]['children'][1]['children'][0]['href'];
        }
    }

    // echo '<pre>';
    if (!isset($array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'][1]['children'][0]['children'][5]['children'][1]['html'])) {
        $Booking = '';
    } else {
        $Booking = $array['children'][1]['children'][0]['children'][6]['children'][3]['children'][0]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'][1]['children'][0]['children'][5]['children'][1]['html'];
    }
    


    if (!isset($array['children'][1]['children'][0]['children'][6]['children'][3]['children'][1]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'])) {
        $img = array();
    } else {
        foreach ($array['children'][1]['children'][0]['children'][6]['children'][3]['children'][1]['children'][0]['children'][1]['children'][0]['children'][0]['children'][0]['children'] as $key => $val) {
            $img[] = $val['children'][0]['href'];
        }
    }
    

    foreach ($array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children'][0]['children'] as $key => $value) {
        $array_index[] = $value['html'];
    }
    // echo '<pre>';
    if (!isset($array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children'])) {
        foreach ($array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children'] as $key => $value) {
            foreach ($value['children'] as $key => $val) {
                if ($array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children'][0]['children'][$key]['html'] == 'Invoice') {
                    $data[str_replace(' ', '', $array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children'][0]['children'][$key]['html'])] = $val['children'][0]['href'];
                } else {
                    $data[str_replace(' ', '', $array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children'][0]['children'][$key]['html'])] = $val['html'];
                }
            }

            $array_result[] = $data;

        }
    } else {
            
        $array_result = array();
    }
    // print_r($array['children'][1]['children'][0]['children'][6]['children'][3]['children']['0']['children'][0]['children'][1]['children'][3]['children'][1]['children']);

    $data_result = array(
        'img' => $img,
        'services' => $array_result,
        'type' => $type,
        'Tracking' => $Tracking,
        'Booking' => $Booking
    );


    echo json_encode($data_result, true);

}
$data_link = array(
    'https://client.atlanticexpresscorp.com'.$_GET['link']
);

    
$result = array();
foreach ($data_link as $key => $value) {
    array_push($result, link_get($value));
}



?>