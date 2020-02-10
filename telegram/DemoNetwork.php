<?php
// *
// * [...]
// * @botname: Notify_Alerting
// * @author  PhuongNguyen
// * @version 1.0
// * @since   20/12/2019
// */

error_reporting(E_ALL);
ini_set("display_errors",1);
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );
header("content-type: application/x-javascript");

$ipClient = getUserIP();
#$0 = listIp();
writelog("Begin----------------");
writelog("Request: ".$_SERVER['REQUEST_URI']);
// writelog("IP: ".$ipClient);

// Check IP running this API
isAllowed($ipClient);

$message = $_GET['mesg'];
echo $message . PHP_EOL;
writelog("Message: ".$message);

// Group Distribute Network
$bot_group = "****:AAGA7MrnHvDnTduS1eW_eNKNv6C-*******";
$chatid = "-******";

$urlDirect = url_Direct($bot_group);
callAPI($urlDirect, $chatid, $message);

/*
if (preg_match("/LVBNetwork/", $message))
{
	echo "if" . PHP_EOL;
	$urlDirect = url_Direct($bot_group_test);
	$text_mesg = preg_replace("/LVBNetwork/", '', $message);
	echo $text_mesg . PHP_EOL;
	// callAPI($urlDirect, $chatid_test, $text_mesg);
}
elseif (preg_match("/LVBService/", $message))
{
	echo "elseif";
}
else
{
	echo "Undefined";
        $urlDirect = url_Direct($bot_group);
        //callAPI($urlDirect, $chatid, $message);
}
*/
function callAPI($url, $chatid, $mesgAlert){
	// INIT
   $curl = curl_init();
   
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_POST, 1);
   curl_setopt($curl, CURLOPT_POSTFIELDS, "chat_id=$chatid&text=$mesgAlert");
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   writelog($result);
   writelog("End----------------");
   curl_close($curl);
   return $result;
}

function url_Direct($bot_id) {
    $urlDirect = "https://api.telegram.org/bot" . $bot_id . "/sendMessage";
    return $urlDirect;
}

function writelog($message) {
    $output = date('Y-m-d H:i:s') . ' : ' . $message . "\n";
    $filename = "Demo_Network_".date('Ymd').".log";
    $pathname = 'logs/' . $filename;
    $exists = file_exists($pathname);
    $result = file_put_contents($pathname, $output, FILE_APPEND);
    return $result;
}
function isAllowed($ip){
    
    $whitelist = array('::1', '10.36.240.17', '10.36.201.12', '10.36.201.15', '10.36.201.51', '10.36.201.*');

    // If the ip is matched, return true
    if(in_array($ip, $whitelist))
    { 
	writelog("IP: ".$ip." Co trong whitelist");
        return true;
    }

    foreach($whitelist as $i){
        $wildcardPos = strpos($i, "*");

        // Check if the ip has a wildcard
        if($wildcardPos !== false && substr($ip, 0, $wildcardPos) . "*" == $i) {
	    writelog("IP: ".$ip." Co trong whitelist");
            return true;
        }
	echo $i;
    }
	writelog("IP: ".$ip." can not allowed");
    return exit();
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

