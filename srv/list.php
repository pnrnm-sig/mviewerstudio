<?php
//include 'who.php';
require_once('who.php');
$geob_user = getUser();
// !!! Changement fait après installation : chemin relatif en chemin absolu !!!
// $_conf = json_decode(file_get_contents("../../../apps/config.json"), true)["app_conf"];
$_conf = json_decode(file_get_contents("/home/studio/mviewerstudio/apps/config.json"), true)["app_conf"];
$the_files = glob($_conf['export_conf_folder'] . "*.xml");
usort( $the_files, function( $a, $b ) { return filemtime($a) - filemtime($b); } );
$files = array_reverse($the_files);
$data = array();
if (is_array($files)) {

     foreach($files as $filename) {
        $xml = simplexml_load_file("$filename");
        if ($xml !== false) {
            $content = file_get_contents("$filename");
            $content_replace = str_replace("rdf:", "", $content);  // delete all rdf: values to manipulate input with SimpleXml object
            $content_replace2 = str_replace("dc:", "", $content_replace);  // delete all dc: values to manipulate input with SimpleXml object
            $xml = simplexml_load_string($content_replace2); // load a SimpleXML object
            $xml_to_json = json_decode(json_encode($xml), 1); // use json to get all values into an array
            $description = $xml_to_json["metadata"]["RDF"]["Description"];
            if ($description["creator"] == $geob_user) {
                $url = str_replace($_conf['export_conf_folder'], $_conf['conf_path_from_mviewer'], "$filename");
                $metadata = array(
                    "url" => !empty($url) ? $url : '',
                    "creator" => !empty($description["creator"]) ? $description["creator"] : '',
                    "date" => !empty($description["date"]) ? $description["date"] : '',
                    "title" => !empty($description["title"]) ? $description["title"] : '',
                    "subjects" => !empty($description["subject"]) ?  $description["subject"] : '',
                );
                array_push( $data , $metadata);
            }
         }
        
     }
     
     header('Content-type: application/json',true);
     echo json_encode($data);

}
?>
