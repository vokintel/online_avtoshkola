<!-- <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" /> -->

<?php 


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
function link_get($id){

    //initial request with login data

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://autodoc.ua/api/search/filtered');
    // curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"categoryUrl":"","searchParametersJson":"{\"searchPhrase\":\"'.$id.'\",\"rest\":0,\"formFactor\":2,\"carTypes\":[],\"carModels\":[],\"productLines\":[],\"sortOrder\":1,\"sortField\":\"\",\"treeParts\":[0],\"from\":0,\"count\":20,\"categoryUrl\":\"\",\"selectedCategory\":\"\",\"keyword\":\"\",\"artId\":0,\"showAll\":true,\"languageId\":2}"}');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
 
    $headers = [
'Accept: application/json, text/plain, */*',
'Content-Type: application/json;charset=UTF-8',
	];

	// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	

    $answer = curl_exec($ch);
    $response = json_decode($answer, true);
    // print_r($response);
    // die;
    echo '<img src="https://autodoc.ua/api/product/image?productId='.$response['products'][0]['id'].'&number=1">';
    // echo 'https://my.omega.page/api/api/v1.0/resources/'.$response['products'][0]['id'].'/images/1';
}




$spreadsheet_url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ6FxscNOBFLXbtcyLET2OeFHrZjDwnHX3sUshMrdR73CMgiN7F6K2CYm-UfHlYWw/pub?gid=466695491&single=true&output=csv';

if(!ini_set('default_socket_timeout', 15)) echo " " ;

if (($handle = fopen($spreadsheet_url, " r ")) !== FALSE) {
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$spreadsheet_data[] = $data;
	}
	fclose($handle);
}
else
die(" Problem reading csv ");

echo '<pre>';
// print_r($spreadsheet_data);

foreach ($spreadsheet_data as $key => $value) {
	print_r($value);
	// die;
	link_get($value[1]);
	die;
}

// function rename($value)
// {
// 	$array = array(
// 		'задн.' => 'задний',
// 		'газ.' => 'газовый',
// 		'передн.' => 'передний',
// 		'подв.' => 'подвески',
// 		'масл.' => 'масляный',
// 		);
// 	foreach ( as $key => $value) {
// 		# code...
// 	}
// 	// if ($value contains 'are'){ return str_replace("задн.", "задний", $value);}
	
// }
