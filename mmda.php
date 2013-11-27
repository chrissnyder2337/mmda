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

  print '<pre>';
  print_r($tika_metadata);
  print '</pre>';
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

/**
 * Get a list of all dagrs keyed by uuid
 * @return array dagrs
 */
function mmda_get_dagrs_list(){
  $db = db_connect();

  $sql = "SELECT File.uuid, File.resource_name, File.anotated_name
    FROM File";

  $query = $db->query($sql);

  $results = $query->fetchAllArray();

  $dagrs = array();

  foreach ($results as $row) {
    $dagrs[$row['uuid']] = $row['anotated_name'] . "(" . $row['resource_name'] .")";
  }

  return $dagrs;
}

/**
 * returns the option html for all of the dagrs
 * @param  string $default_uuid uuid of option to be selected
 * @return string               options html
 */
function mmda_get_dagrs_list_select_options($default_uuid = NULL){
  $dagrs = mmda_get_dagrs_list();

  $dagrs_option_html = '';

  foreach ($dagrs as $uuid => $name) {
    $dagrs_option_html .= '<option value="'.$uuid."' ";
    if($default_uuid != NULL && $default_uuid == $uuid){
      $dagrs_option_html .= "selected='selected'";
    }
    $dagrs_option_html .= ">".$name."</option>\n";
  }

  return $dagrs_option_html;
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

function mmda_get_time_report($startDate,$endDate){
  $db = db_connect();

  // convert mm/dd/yyyy to appropriate format
  $mysql_startDate = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $startDate)));
  $mysql_endDate = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $endDate)));

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
      File.file_added_timestamp >= ?
      and File.file_added_timestamp < ?";

  $query = $db->query($sql,array($mysql_startDate,$mysql_endDate));


  $results = $query->fetchAllArray();

  return $results;

}


/**
 * format html of result table.
 * @param  array $results to be formatted
 * @return string          html table
 */
function mmda_format_result_table($results){
  global $metadata_attributes;
  $html = '<div style="overflow: auto"><table class="table table-bordered" >';

  //HEAD OF TABLE
  $html .= '<thead><tr>';
  foreach ($results[0] as $key => $value) {
    //get printable collum name from table if possible
    if(isset($metadata_attributes[$key]) && isset($metadata_attributes[$key]['display'])){
      $label = $metadata_attributes[$key]['display'];
    }else{
      $label = $key;
    }
    $html .= '<th>'.$label.'</th>';
  }
  $html .= '</tr><thead>';
  //END HEAD OF TABLE

  //BODY OF TABLE
  $html .= '<tbody>';
  foreach ($results as $key => $row) {
    $html .= '<tr>';
    foreach ($row as $key => $value) {
      $html .= '<td>'.$value.'</td>';
    }
    $html .= '</tr>';
  }


  $html .= '</tbody>';
  //END BODY OF TABLE
  $html .= '</table></div>';



  //add datatables call
  return $html;

}

function mmda_remove_empty_columns($results){

  $num_rows = count($results);
  $column_count = array();
  foreach ($results as $row) {
    foreach ($row as $column => $value) {
      if(empty($value)){
        if(!isset($column_count[$column])){
          $column_count[$column]=0;
        }
        $column_count[$column]++;
      }
    }
  }


  foreach ($results as &$row) {
    foreach ($column_count as $column => $count) {
      print($count);
      if($count == $num_rows){
        unset($row[$column]);
      }
    }
  }
  return $results;
}
