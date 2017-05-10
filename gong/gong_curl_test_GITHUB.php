
<?php

// DU METTRE L'UTILISATEUR EN ROOT POUR QUE L'USER PAR DEFAUT D'APACHE PUISSE FAIRE L'EXEC DU PYTHON.

// http://blogmotion.fr/systeme/executer-un-script-shell-avec-permission-root-en-php-1312

//////////////////////////////////SLACK BOT///////////////////////////////////

 $slack_webhook_url ="https://hooks.slack.com/services/Your_adress; // on keep l'URL du playload
 

 $recup_user_name=$_GET['user_name']; // $_GET['user_name'];  on récupère l'user name de celui qui a gong
 $recup_text=$_GET['text']; // On récupère le text qu'il envoie
 $URL_user_name='<https://evoliz.slack.com/team/'.$recup_user_name.'|@'.$recup_user_name.'>';
 
 $request_true=array('channel'=>'#general',

	'username'=>'Gong-bot',

	'text'=>$URL_user_name.' a gong! '.$recup_text,

	'icon_emoji'=>':gong:');



// INIT DE LA REQUÊTE  



$request_test=json_encode($request_true, JSON_FORCE_OBJECT); // On force l'encodage en JSON

$request_test=urlencode($request_test);	// On force l'encodage en URL 

$request_test="payload=".$request_test; // on rajoute payload=  devant.

// Si on l'avait fait avant, dans le urlencode on aurait eu payload:


$ch2=curl_init($slack_webhook_url); // on init la co vers l'adresse que Slack nous a donné

//FIN D'INIT DE LA REQUÊTE



// EMPECHE LES BUGS DE CERTIFICAT

// on a du installer le doc cacert.pem à la racine 

curl_setopt($ch2, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem'); 

// obligatoire pour ne pas avoir de bugs de certificat

curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, true); // pareil qu'au dessus
//

// ENVOI DE LA REQUÊTE
$hearder=array("HTTP/1.1 200 ok");

curl_setopt($ch2, CURLOPT_URL,$slack_webhook_url);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch2, CURLOPT_HTTP200ALIASES,$request_test);
curl_setopt($ch2, CURLOPT_POST, true); // On envoie une ligne
curl_setopt($ch2, CURLOPT_POSTFIELDS,$request_test); 

curl_exec($ch2);
curl_close($ch2);
exec("sudo python /var/www/gong_Server/gong.py >/dev/null &"); 

?>
