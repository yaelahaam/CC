<?php
/**
 * @copyright MazterinDev
 * @package B00king.c0m awto
 */
require("./ModulKu.php");
$modulku = new ModulKu;

function headers(){
    global $modulku;
    $headers[] = 'Authority: www.googleapis.com';
    $headers[] = 'X-Client-Version: Chrome/JsCore/7.20.0/FirebaseCore-web';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36';
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Accept: */*';
    $headers[] = 'Origin: https://grivy.app';
    $headers[] = 'X-Client-Data: CKS1yQEIk7bJAQiltskBCMS2yQEIqZ3KAQinuMoBCKzHygEI9sfKAQjnyMoBCOnIygEItMvKAQjb1coBCJ/WygEImNjKARiLwcoB';
    $headers[] = 'Sec-Fetch-Site: cross-site';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Referer: https://grivy.app/';
    $headers[] = 'Accept-Language: en-US,en;q=0.9,id;q=0.8';
    return $headers;
}

function register_app($email){
    global $modulku;
    $headers = headers();
    $post_data = json_encode(array(
        "requestType"   => "EMAIL_SIGNIN",
        "email"         => $email,
        "continueUrl"   => "https://grivy.app/login-email/coke-ayo-idm",
        "canHandleCodeInApp"    => true
    ));
    $register = $modulku->curl('https://www.googleapis.com/identitytoolkit/v3/relyingparty/getOobConfirmationCode?key=AIzaSyC2Jncgy1smi8CV91PG3sUZBDAo5raozYc', $post_data, $headers);
    return json_decode($register[1], true);
}


$site = [
    'https://www.sobhog.com/'
];
while(true){
    $random = $site[array_rand($site)];
    $sitez = $random;
    $get_email = $modulku->get_email($sitez);
    echo "# Trying with email ".$get_email['current_email']."\n";
    $reg = register_app($get_email['current_email']);
    if(isset($reg['kind'])){
        echo "# Success register.\n";
        $get_msg = $modulku->get_message($sitez, $get_email['title_replaced'], $get_email['current_email'], $get_email['cookie']);
        if($get_msg == FALSE){
            echo "BAD EMAIL SERVER!, CHANGE IT.";
        }else{
           preg_match('#<a href=\'(.*?)\'#si', $get_msg['result']['html'], $m);
           echo str_replace('&amp;', '&', $m[1])." | ".$get_email['current_email']."\n";
           $modulku->save("cocacola.txt", str_replace('&amp;', '&', $m[1])." | ".$get_email['current_email']."\n");
        }
        echo "\n\n";
    }else{
        print_r($reg);
        echo "\n";
    }
    sleep(3);
}
?>