<?php
// Author Hocnv
// Desc: proxy for telegram
// LastUpdate: 2019-02-10 
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );
header("content-type: application/x-javascript");
error_reporting(E_ALL);
ini_set("display_errors",0);
// botname: warningsmsbot
$urlDirect = 'https://api.telegram.org/bot794240641:AAGghCbQvhVazekRpxmvlQC-fox0JBEeKFA/sendMessage';
$chatid = "-342072922";

// /usr/bin/curl -X POST "https://api.telegram.org/bot794240641:AAGghCbQvhVazekRpxmvlQC-fox0JBEeKFA/sendMessage" -d "chat_id=$chat_id&text=$mesgAlert"

#$urlReturn = getReferrer();

$ipClient = getUserIP();
#$listIp = listIp();
writelog("Begin----------------");
writelog("Request: ".$_SERVER['REQUEST_URI']);
writelog("IP: ".$ipClient);
#writelog("REFER: ".$urlReturn);


$mesgAlert = $_GET['mesg'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$urlDirect);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "chat_id=$chatid&text=$mesgAlert");

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);

writelog($server_output);
writelog("End----------------");
echo "OK";
function writelog($message) {
    $output = date('Y-m-d H:i:s') . ' : ' . $message . "\n";
    $filename = "log_".date('Ymd').".log";

    $pathname = 'logs/' . $filename;

    $exists = file_exists($pathname);
    $result = file_put_contents($pathname, $output, FILE_APPEND);

    return $result;
}
function listIp(){
//    $myFile = dirname(__FILE__)."/VinaIP.txt";
//    $myFile = dirname(__FILE__)."/VinaVtel.txt";
    $myFile = dirname(__FILE__)."/listIpViettel.txt";
    $viettelIP = file($myFile);//file in to an array
    return $viettelIP;
}

function checkIp($ip,$listIp){
    list ($net, $mask) = preg_split("/[\/]+/", $listIp);
    $ip_net = ip2long($net);
    $ip_mask = ~((1 << (32 - $mask)) - 1);
    $ip_ip = ip2long($ip);
    $ip_ip_net = $ip_ip & $ip_mask;
    return ($ip_ip_net === $ip_net);
}
function getReferrer(){
    if (isset($_SERVER['HTTP_REFERER'])) {
        $ref_url = $_SERVER['HTTP_REFERER'];
    }else{
        $ref_url = 'http://gamehtml5.vn';
    }
    return $ref_url;
}
function getUserIP(){
    if (isset($_SERVER)){

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }

        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR')){
        return getenv('HTTP_X_FORWARDED_FOR');
    }

    if (getenv('HTTP_CLIENT_IP')){
        return getenv('HTTP_CLIENT_IP');
    }

    return getenv('REMOTE_ADDR');
}
?>
