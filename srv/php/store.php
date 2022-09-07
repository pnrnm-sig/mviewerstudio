<?php
//include 'who.php';
require_once('who.php');

$geob_user = getUser();
$_conf = json_decode(file_get_contents("../../apps/config.json"), true)["app_conf"];
$xml_0 = file_get_contents('php://input');

// Remove filename from XML
$replace_match = '/^.*' . 'filename' . '.*$(?:\r\n|\n)?/m';
$xml_1 = preg_replace($replace_match, '', $xml_0);

$xml = str_replace('anonymous', $geob_user, $xml_1);


// Get XML filename
$xml_filename = simplexml_load_string(file_get_contents('php://input'));
$content = $xml_filename->filename->attributes()->filename;

// Save and replace XML using filename
if ($content != '') {
    $fichier = $content;
}
// Save with random filename
else {
    $fichier = hash('md5', $xml) . '.xml';
};

file_put_contents($_conf['export_conf_folder'] .$fichier, $xml);
header('Content-type: application/json',true);   
echo '{"success":true, "filepath":"'.$fichier.'"}'; 
  
?>
