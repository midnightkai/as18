<?php
echo "<a target='_blank' href = 'https://github.com/midnightkai/as18'>Github repo</a><br>";

main();

function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
	$json_string = curl_get_contents($apiCall);
    $obj = json_decode($json_string);
    
    $arr1 = Array();
    $arr2 = Array();
    foreach($obj-> Countries as $i){
        array_push($arr1, $i->Country);
        array_push($arr2, $i->TotalDeaths);
    }
    array_multisort($arr2, SORT_DESC, $arr1);
    $output = array_slice($arr1, 0, 10);
    print_r($output);
    foreach($output as $k =>$a){
        $output[$k] = json_encode($a);
    }
    
}  

// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>

