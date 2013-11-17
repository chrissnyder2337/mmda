<?php
require_once('metadata_attributes.php');
/**
 * Givin a file will add it to db and return results.
 */
function mmda_add_file($filepath, $externalfilepath = NULL){
  global $db;

  //get hash of file
  $file_hash = md5_file($filepath);
  $filename = basename($filepath);

  //check if file already exists based on hash / name
  if(!mmda_check_file_exists($filename,$file_hash)){

    //get metadata from tika
    $metadata =  mmda_get_metadata($filepath);

    //create uuid
    $uuid = uniqid();

    //add uuid to all metadata tables
    foreach ($metadata as $table => $attributes) {
      $metadata[$table]['uuid'] = $uuid;
    }

    // add File table specific information
    $metadata['File']['local_path'] = $filepath;

    if(!empty($externalfilepath)){
      $metadata['File']['external_path'] = $externalfilepath;
    }

    $metadata['File']['md5_hash'] = $file_hash;

    //insert into
    mmda_insert_file($metadata);

    return "This file's DAGR was inserted with the id <b>".$uuid."</b>";

    print "<pre>";
    print_r($metadata);
    print "</pre>";
  }else{
    return "File already in db";
  }

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
  $tika_metadata =  $tika->getMetaData($filepath);
  $metadata = mmda_match_metadata($tika_metadata);
  return $metadata;


}

/**
 * givin medadata from tika's out put match it up with the data we are storing
 * @param  [array] $tika_metadata [description]
 * @return array
 */
function mmda_match_metadata($tika_metadata){
  global $metadata_aliases;
  global $metadata_attributes;
  $metadata = array();

  //match on files
  foreach ($tika_metadata as $attribute => $value) {
    // check if atribute is storable
    if(isset($metadata_aliases[$attribute])){
      $db_name = $metadata_aliases[$attribute];
      $metadata[$db_name] = $metadata_attributes[$db_name];
      $metadata[$db_name]['value'] = $value;
    }
  }

  $metadata_bytable = array();
  //organize it my table we are inserting
  foreach ($metadata as $attribute => $attr_data) {
    if(!isset($metadata_bytable[$attr_data['table']])){
      $metadata_bytable[$attr_data['table']] = array();
    }
    $metadata_bytable[$attr_data['table']][$attribute] = $attr_data['value'];
  }

  return $metadata_bytable;
}


function mmda_insert_file($metadata){
  global $db;
  foreach ($metadata as $table => $attributes) {

    $query = $db->insert($table,$attributes);

    //the mysql wrapper does this for us with sanitation
    //$query = $db->query("INSERT INTO ? (?) VALUES (?)",array($table, $columns,$values));
  }
  return;

}
