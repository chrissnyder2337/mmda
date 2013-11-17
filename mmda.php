<?php
require_once('metadata_attributes.php');
/**
 * Givin a file will add it to db and return results.
 */
function mmda_add_file($filepath){

  //get hash of file
  $file_hash = md5_file($filepath);
  $filename = basename($filepath);

  //check if file already exists based on hash / name
  if(!mmda_check_file_exists($filename,$file_hash)){

    $metadata =  mmda_get_metadata($filepath);

    print "<pre>";
    print_r($metadata);
    print "</pre>";
  }else{
    return "File already in db";
  }



  //TODO grab metadata from tika which will give back an array of data

  //

  return 'query results';
}

function mmda_check_file_exists($filename,$filehash)
{
  global $db;
  $query = $db->query("SELECT count(*) as count FROM File WHERE md5_hash = ? and resource_name = ?",array($filehash,$filename));
  $result = $query->fetchAll();

  if($result[0]->count > 0){
    return TRUE;
  }

  return false;
}

function mmda_get_metadata($filepath){


  $tika = new TikaWrapper();
  return $tika->getMetaData($filepath);



}
