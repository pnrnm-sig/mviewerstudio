<?php
//include 'who.php';
require_once('who.php');
$geob_user = getUser();
// !!! Changement fait après installation : chemin relatif en chemin absolu !!!
// $_conf = json_decode(file_get_contents("../../../apps/config.json"), true)["app_conf"];
$_conf = json_decode(file_get_contents("/home/studio/mviewerstudio/apps/config.json"), true)["app_conf"];
$xml_0 = file_get_contents('php://input');
$xml = str_replace('anonymous', $geob_user, $xml_0);
$fichier = hash('md5', $xml) . '.xml'; // determine name saved xml
file_put_contents($_conf['export_conf_folder'] .$fichier, $xml);
header('Content-type: application/json',true);   
echo '{"success":true, "filepath":"'.$fichier.'"}'; 
  
?>
