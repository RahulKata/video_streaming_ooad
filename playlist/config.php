<?php
define('GOOGLE_API_KEY', 'AIzaSyBaOWnd283EdkJ33xdQ7BGOhWgzuJN-o2E');
 
function getYTList($api_url = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $arr_result = json_decode($response);
    if (isset($arr_result->items)) {
        return $arr_result;
    } elseif (isset($arr_result->error)) {
        //var_dump($arr_result); //this line gives you error info if you are not getting a video list.
    }
}
?>