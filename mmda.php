<?php

require_once ('load_libraries.php');
/**
 * Givin a file will add it to db and return results.
 */
function mmda_add_file($filepath, $is_external = FALSE){

  //get hash of file
  $file_hash = md5_file($filepath);
  $filename = basename($filepath);

  //check if file already exists based on hash / name
  if(!mmda_check_file_exists($filename,$file_hash)){

    //get metadata from tika
    $metadata =  mmda_get_metadata($filepath);

    //create uuid
    $uuid = mmda_get_uuid();

    //add uuid to all metadata tables
    foreach ($metadata as $table => $attributes) {
      $metadata[$table]['uuid'] = $uuid;
    }

    // add File table specific information


    if($is_external){
      $metadata['File']['external_path'] = $filepath;
    } else{
      $metadata['File']['local_path'] = $filepath;
    }

    $metadata['File']['md5_hash'] = $file_hash;

    //insert into
    mmda_insert_file($metadata);

    return $uuid;


  }else{
    return FALSE;
  }

}

function mmda_check_file_exists($filename,$filehash)
{
  $db = db_connect();
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
  global $metadata_attributes;

  $metadata_aliases = mmda_get_metadata_attributes();
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
  $db = db_connect();
  foreach ($metadata as $table => $attributes) {

    $query = $db->insert($table,$attributes);

    //the mysql wrapper does this for us with sanitation
    //$query = $db->query("INSERT INTO ? (?) VALUES (?)",array($table, $columns,$values));
  }
  return;

}
/**
 * Use the mysql database to generate a uuid
 * @return string           uuid
 */
function mmda_get_uuid(){
  $db = db_connect();

  $query = $db->query("SELECT UUID() as uuid");
  $result = $query->fetchAll();

  if($result[0]->uuid){
    return $result[0]->uuid;
  }

  return false;

}

function mmda_get_file($uuid){
  $db = db_connect();


  $sql = "SELECT *
    FROM File
      LEFT JOIN AudioMetadata on AudioMetadata.uuid = File.uuid
      LEFT JOIN AuthoringMetadata on AuthoringMetadata.uuid = File.uuid
      LEFT JOIN DocumentCountsMetadata on DocumentCountsMetadata.uuid = File.uuid
      LEFT JOIN ExecutableMetadata on ExecutableMetadata.uuid = File.uuid
      LEFT JOIN FileReferences on ExecutableMetadata.uuid = File.uuid
      LEFT JOIN ImageResolutionMetadata on ImageResolutionMetadata.uuid = File.uuid
      LEFT JOIN VideoMetadata on VideoMetadata.uuid = File.uuid
      LEFT JOIN WebpageMetadata on WebpageMetadata.uuid = File.uuid
    WHERE
      File.uuid = ?";

  $query = $db->query($sql,array($uuid));

  $results = $query->fetchAllArray();

  return $results[0];

}

function mmda_get_dagr_html($uuid){
  global $metadata_attributes;
  $file_metadata = mmda_get_file($uuid);

  $filename = $file_metadata['resource_name'];

  $html = '
    <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">
  <h3 class="panel-title"><span class="glyphicon glyphicon-file"></span> '.$filename.'</h3> ('.$uuid.')</div>
  <div class="panel-body">
    <a href="#">Download</a> | <a href="#">Edit</a> | <a href="#">Remove DAGR</a>
  </div>

  <!-- List group -->
  <ul class="list-group">';

  foreach ($file_metadata as $key => $value) {
    if(!empty($value)){
      $html .= '<li class="list-group-item">';
      if(isset($metadata_attributes[$key]) && isset($metadata_attributes[$key]['display'])){
        $label = $metadata_attributes[$key]['display'];
      }else{
        $label = $key;
      }
      $html .= '<strong>'.$label.':</strong> ';
      $html .= $value;
      $html .= '</li>';
    }
  }

  $html .= '</ul></div>';
  return $html;
}

/**
 * Created an array of atributes keyed by the aliases
 * @return array aliases
 */
function mmda_get_metadata_attributes(){
  global $metadata_attributes;
  $metadata_aliases = array();
  foreach ($metadata_attributes as $db_attribute => $db_attribute_properties) {
    foreach ($db_attribute_properties['tika_alias'] as $tika_alias) {
      $metadata_aliases[$tika_alias] = $db_attribute;
    }
  }

  return $metadata_aliases;
}

/**
 * Create and array of filterable attributes keyed by dbname
 * @return array db_name=>displayname
 */
function mmda_get_filterable_attributes(){
  global $metadata_attributes;
  $filterable_attributes = array();
  foreach ($metadata_attributes as $key => $properties) {
    if(isset($properties['filterable']) && $properties['filterable']){
      $filterable_attributes[$key] = $properties['display'];
    }
  }
  return $filterable_attributes;
}
/*
 * Gets a list of all metadata tables
 */
function mmda_get_tables(){
  global $metadata_attributes;
  $tables = array();
  foreach ($metadata_attributes as $attribute => $properties) {
    if(!isset($tables[$properties['table']])){
      $tables[$properties['table']] = $properties['table'];
    }
  }
  return array_values($tables);
}

/* 
 * Determine if URL is valid
 */
function mmda_isValidURL($url){
        return preg_match('#^(?:https?|ftp)://#', $url);
}
/*
 * Parses through all downloadable content of the given webpage.
 * @return array urls
 */
function mmda_get_webpage_content($url){
  $html = file_get_html($url);
  $content = array();
  // Find all images
  foreach($html->find('img') as $element){
    if (!preg_match('/^mailto/',$element->src)){
      if (!mmda_isValidURL($element->src))
        $element->src = $url.$element->src;
      $content[] = $element->src;
    }
  }
  // Find all links
  foreach($html->find('a') as $element){
    if (!preg_match('/^mailto/',$element->href)){
      if (!mmda_isValidURL($element->href))
        $element->href = $url.$element->href;
      $content[] = $element->href;
    }
  }
  return array_unique($content);
}
