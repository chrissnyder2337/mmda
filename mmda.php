<?php

require_once ('load_libraries.php');
/**
 * Givin a file will add it to db and return results.
 */
function mmda_add_file($filepath, $is_external = FALSE){
  //check if readable
  if(!fopen($filepath, "r")){
    return FALSE;
  }


  //get hash of file
  $file_hash = md5_file($filepath);
  $filename = basename($filepath);

  //check if file already exists based on hash / name
  if(!mmda_check_file_exists($filename,$file_hash)){

    //get metadata from tika
    $metadata =  mmda_get_metadata($filepath);

    if(empty($metadata)){return FALSE;}
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

  // print "<pre>";
  // print_r($tika_metadata);
  // print "</pre>"

  if(empty($tika_metadata)){
    return FALSE;
  }
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


/**
 * Run a custom query with the user provided where clause
 *
 */
function mmda_run_custom_query($where_clause){
  $db = db_connect();

  $sql = "SELECT *
    FROM File
      LEFT JOIN AudioMetadata on AudioMetadata.uuid = File.uuid
      LEFT JOIN AuthoringMetadata on AuthoringMetadata.uuid = File.uuid
      LEFT JOIN DocumentCountsMetadata on DocumentCountsMetadata.uuid = File.uuid
      LEFT JOIN ExecutableMetadata on ExecutableMetadata.uuid = File.uuid
      LEFT JOIN ImageResolutionMetadata on ImageResolutionMetadata.uuid = File.uuid
      LEFT JOIN VideoMetadata on VideoMetadata.uuid = File.uuid
      LEFT JOIN WebpageMetadata on WebpageMetadata.uuid = File.uuid
      LEFT JOIN File f1 on File.uuid = f1.uuid
    WHERE
      ". $where_clause;

  $query = $db->query($sql);

  $results = $query->fetchAllArray();

  return $results;
}

function mmda_get_file($uuid){
  $db = db_connect();


  $sql = "SELECT *
    FROM File
      LEFT JOIN AudioMetadata on AudioMetadata.uuid = File.uuid
      LEFT JOIN AuthoringMetadata on AuthoringMetadata.uuid = File.uuid
      LEFT JOIN DocumentCountsMetadata on DocumentCountsMetadata.uuid = File.uuid
      LEFT JOIN ExecutableMetadata on ExecutableMetadata.uuid = File.uuid
      LEFT JOIN ImageResolutionMetadata on ImageResolutionMetadata.uuid = File.uuid
      LEFT JOIN VideoMetadata on VideoMetadata.uuid = File.uuid
      LEFT JOIN WebpageMetadata on WebpageMetadata.uuid = File.uuid
      LEFT JOIN File f1 on File.uuid = f1.uuid
    WHERE
      File.uuid = ?";

  $query = $db->query($sql,array($uuid));

  $results = $query->fetchAllArray();

  if(isset($results[0])){
    return $results[0];
  }else{
    return false;
  }
}

function mmda_get_all_keywords(){
  $db = db_connect();
  $sql = "SELECT DISTINCT(keyword) from Keywords";
  $query = $db->query($sql);
  $results = $query->fetchAllArray();

  if(isset($results[0])){
    //complile results into array
    $keywords = array();
    foreach ($results as $row) {
      $keywords[] = $row['keyword'];
    }
    return $keywords;
  }else{
    return false;
  }
}
/**
 * Return all uuids of the DAGRs with
 * @param  [type] $keyword [description]
 * @return [type]          [description]
 */
function mmda_get_uuids_by_keyword($keyword){
  $db = db_connect();
  $sql = "SELECT uuid from Keywords WHERE keyword = ?";
  $query = $db->query($sql,array($keyword));
  $results = $query->fetchAllArray();

if(isset($results[0])){
    $uuids = array();
    foreach ($results as $row) {
      $uuids[]  = $row['uuid'];
    }
    return $uuids;
  }else{
    return array();
  }
}

/**
 * Get the keywords of the dagr
 * @param  [type] $uuid [description]
 * @return [type]       [description]
 */
function mmda_get_keywords($uuid){
  $db = db_connect();
  $sql = "SELECT keyword from Keywords where uuid = ?";
  $query = $db->query($sql, array($uuid));
  $results = $query->fetchAllArray();

  if(isset($results[0])){
    //complile results into array
    $keywords = array();
    foreach ($results as $row) {
      $keywords[] = $row['keyword'];
    }
    return $keywords;
  }else{
    return array();
  }
}

function mmda_update_dagr_keywords($uuid, $keywords){
  if(empty($keywords) || !is_array($keywords)){
    return FALSE;
  }

  //Remove all previous keywords.
  $db = db_connect();
  $sql = "DELETE FROM Keywords WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  //add each keyword
  foreach ($keywords as $keyword) {
    if(!empty($keyword)){
      $sql = "INSERT INTO Keywords (uuid, keyword) VALUES (?, ?)";
      $query = $db->query($sql,array($uuid,$keyword));
    }
  }
}

/**
 * Get the parent dagr's uuid
 * @return [type] [description]
 */
function mmda_get_parent_uuid($uuid){
  $db = db_connect();

  $sql = "SELECT parent_uuid from FileReferences where child_uuid = ?";

  $query = $db->query($sql, array($uuid));

  $results = $query->fetchAllArray();

  if(isset($results[0])){
    return $results[0]['parent_uuid'];
  }else{
    return false;
  }
}

function mmda_get_descendants($uuid, &$visited = array()){
  $children_uuids = mmda_get_children_uuids($uuid);

  $descendant_uuids = $children_uuids;
  foreach ($children_uuids as $child_uuid) {
    if(!in_array($child_uuid, $visited)){
      $visited[] = $child_uuid;

      $more_children = mmda_get_descendants($child_uuid, $visited);
    }

    $descendant_uuids = array_merge($descendant_uuids, $more_children);
  }

  return $descendant_uuids;

}

/**
 * Returns an array of children uuids
 * @param  [type] $uuid [description]
 * @return [type]       [description]
 */
function mmda_get_children_uuids($uuid){
  $db = db_connect();

  $sql = "SELECT child_uuid from FileReferences where parent_uuid = ?";

  $query = $db->query($sql, array($uuid));

  $results = $query->fetchAllArray();

  if(isset($results[0])){
    $child_uuids = array();
    foreach ($results as $row) {
      $child_uuids[]  = $row['child_uuid'];
    }
    return $child_uuids;
  }else{
    return array();
  }
}

/**
 * get the html of a single dagr listing
 *
 * this includes the filename, and the edit and delete button
 * @param  [type] $uuid [description]
 * @return [type]       [description]
 */
function mmda_get_dagr_single_html($uuid){
  $db = db_connect();

  $sql = "SELECT File.uuid, File.resource_name, File.anotated_name
    FROM File
   WHERE File.uuid = ? ";

  $query = $db->query($sql,array($uuid));

  $results = $query->fetchAllArray();

  if(isset($results[0])){
    return '<div class="dagr-item">'. $results[0]['anotated_name']
      . ' (' . $results[0]['resource_name'] .')'
      . '<a href="edit_file.php?uuid='.$uuid.'"> <span class="glyphicon glyphicon-edit"> </span> Edit </a> '
      . '<a href="delete_file.php?uuid='.$uuid.'"> <span class="glyphicon glyphicon-trash"> </span> Delete </a> </div>';
  }else{
    return false;
  }
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
    $dagrs[$row['uuid']] = $row['anotated_name'] . " (" . $row['resource_name'] .")";
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
    $dagrs_option_html .= '<option value="'.$uuid.'" ';
    if($default_uuid != NULL && $default_uuid == $uuid){
      $dagrs_option_html .= "selected='selected'";
    }
    $dagrs_option_html .= ">".$name."</option>\n";
  }

  return $dagrs_option_html;
}

/**
 * Update anotated name
 * @param  string $uuid          [description]
 * @param  string $anotated_name [description]
 * @return [type]                [description]
 */
function mmda_update_anotated_name($uuid, $anotated_name){
  $db = db_connect();

  $sql = "UPDATE File
    SET File.anotated_name = ?
    WHERE File.uuid = ?";

  $query = $db->query($sql,array($anotated_name,$uuid));
}

/**
 * change the parent dagr with $uuid to the dagr with the uuid of
 * $parent_uuid
 * @param  [type] $uuid        [description]
 * @param  [type] $parent_uuid [description]
 * @return [type]              [description]
 */
function mmda_update_parent_uuid($uuid,$parent_uuid){
  $db = db_connect();

  //Delete old parent reference
  $sql = "DELETE FROM  FileReferences
    WHERE FileReferences.child_uuid = ?";
  $query = $db->query($sql,array($uuid));

  //Add new parent reference
  $sql = "INSERT INTO FileReferences (parent_uuid, child_uuid) VALUES (?, ?)";
  $query = $db->query($sql,array($parent_uuid,$uuid));

}

function mmda_get_dagr_html($uuid){
  global $metadata_attributes;
  $file_metadata = mmda_get_file($uuid);

  $filename = $file_metadata['resource_name'];

  //CREATE PARENT DAGR PANEL
  $parent_uuid = mmda_get_parent_uuid($uuid);

  if(!empty($parent_uuid)){
    $parent_item_html = mmda_get_dagr_single_html($parent_uuid);
  }else{
    $parent_item_html = ' - NO PARENT - ';
  }

  $parent_panel_html = '
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
    <h3 class="panel-title">
      <span class="glyphicon glyphicon-file"></span> Parent DAGR
    </h3></div>
    <div class="panel-body">
    '.$parent_item_html.'
    </div>
  </div>
  ';

  //CREATE CHILDREN DAGR PANEL
  $child_uuids = mmda_get_children_uuids($uuid);

  $children_item_html = '';

  if(!empty($child_uuids)){
    foreach ($child_uuids as $child_uuid) {
      $children_item_html .= mmda_get_dagr_single_html($child_uuid);
    }
  }else{
    $children_item_html = ' - NO CHILDREN - ';
  }

  $children_panel_html = '
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
    <h3 class="panel-title">
      <span class="glyphicon glyphicon-file"></span> Children DAGRs
          </h3></div>
    <div class="panel-body">
    '.$children_item_html.'
    </div>
  </div>
  ';

    //CREATE CHILDREN DAGR PANEL
  $descendant_uuids = mmda_get_descendants($uuid);

  $descendant_item_html = '';

  if(!empty($descendant_uuids)){
    foreach ($descendant_uuids as $descendant_uuid) {
      $descendant_item_html .= mmda_get_dagr_single_html($descendant_uuid);
    }
  }else{
    $descendant_item_html = ' - NO DESCENDANTS - ';
  }

  $descendant_panel_html = '
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
    <h3 class="panel-title">
      <span class="glyphicon glyphicon-file"></span> Descendant DAGRs (Reach Query)
          </h3></div>
    <div class="panel-body">
    '.$descendant_item_html.'
    </div>
  </div>
  ';

  //KEYWORDS PANEL

 $keywords = mmda_get_keywords($uuid);
 $keywords_items_html = '';
 $keywords_html = array();
  foreach ($keywords as $keyword) {
    $keywords_html[] = '<a  href="keywords.php?keyword='.$keyword.'"><span class="glyphicon glyphicon-tag"></span> '.$keyword.'</a>';
  }
  if(!empty($keywords_html)){
    $keywords_items_html = implode(',',$keywords_html);
  }
  $keywords_panel_html = '
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
    <h3 class="panel-title">
      <span class="glyphicon glyphicon-tags"></span> Keywords
          </h3></div>
    <div class="panel-body">
    '.$keywords_items_html.'
    </div>
  </div>
  ';



  $attr_html = '
    <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon-file"></span> '.$filename.'</h3> ('.$uuid.')</div>
    <div class="panel-body">

    </div>

  <!-- List group -->
  <ul class="list-group">';

  foreach ($file_metadata as $key => $value) {
    if(!empty($value)){
      $attr_html .= '<li class="list-group-item">';
      if(isset($metadata_attributes[$key]) && isset($metadata_attributes[$key]['display'])){
        $label = $metadata_attributes[$key]['display'];
      }else{
        $label = $key;
      }
      $attr_html .= '<strong>'.$label.':</strong> ';
      if($key == 'external_path' || $key == 'local_path'){
        $attr_html .= '<a href="'.$value.'" target="_blank">'.$value.'</a>';
      }else{
        $attr_html .= $value;
      }
      $attr_html .= '</li>';
    }
  }

  $attr_html .= '</ul></div>';


  $html = '<div class="row">
    <div class="col-md-6">'. $attr_html.'</div>
    <div class="col-md-6">'.$keywords_panel_html. $parent_panel_html.$children_panel_html.$descendant_panel_html.' </div>
    </div>';
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
  $url = rtrim($url, " /");
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
      LEFT JOIN ImageResolutionMetadata on ImageResolutionMetadata.uuid = File.uuid
      LEFT JOIN VideoMetadata on VideoMetadata.uuid = File.uuid
      LEFT JOIN WebpageMetadata on WebpageMetadata.uuid = File.uuid
      LEFT JOIN File f1 on File.uuid = f1.uuid
    WHERE
      File.file_added_timestamp >= ?
      and File.file_added_timestamp < ?";

  $query = $db->query($sql,array($mysql_startDate,$mysql_endDate));


  $results = $query->fetchAllArray();

  return $results;

}

/**
 * Return the orphan Report
 * @return [type] [description]
 */
function mmda_get_orphan_report(){
  $db = db_connect();


  $sql = "SELECT *
    FROM File
      LEFT JOIN AudioMetadata on AudioMetadata.uuid = File.uuid
      LEFT JOIN AuthoringMetadata on AuthoringMetadata.uuid = File.uuid
      LEFT JOIN DocumentCountsMetadata on DocumentCountsMetadata.uuid = File.uuid
      LEFT JOIN ExecutableMetadata on ExecutableMetadata.uuid = File.uuid
      LEFT JOIN ImageResolutionMetadata on ImageResolutionMetadata.uuid = File.uuid
      LEFT JOIN VideoMetadata on VideoMetadata.uuid = File.uuid
      LEFT JOIN WebpageMetadata on WebpageMetadata.uuid = File.uuid
      LEFT JOIN FileReferences on File.uuid = FileReferences.child_uuid
      LEFT JOIN File f1 on File.uuid = f1.uuid
    WHERE
      FileReferences.parent_uuid IS NULL";

  $query = $db->query($sql);
  $results = $query->fetchAllArray();

  return $results;
}

/**
 * Return the orphan Report
 * @return [type] [description]
 */
function mmda_get_sterile_report(){
  $db = db_connect();


  $sql = "SELECT *
    FROM File
      LEFT JOIN AudioMetadata on AudioMetadata.uuid = File.uuid
      LEFT JOIN AuthoringMetadata on AuthoringMetadata.uuid = File.uuid
      LEFT JOIN DocumentCountsMetadata on DocumentCountsMetadata.uuid = File.uuid
      LEFT JOIN ExecutableMetadata on ExecutableMetadata.uuid = File.uuid
      LEFT JOIN ImageResolutionMetadata on ImageResolutionMetadata.uuid = File.uuid
      LEFT JOIN VideoMetadata on VideoMetadata.uuid = File.uuid
      LEFT JOIN WebpageMetadata on WebpageMetadata.uuid = File.uuid
      LEFT JOIN FileReferences on File.uuid = FileReferences.parent_uuid
      LEFT JOIN File f1 on File.uuid = f1.uuid
    WHERE
      FileReferences.child_uuid IS NULL";

  $query = $db->query($sql);
  $results = $query->fetchAllArray();
  return $results;
}

/**
 * Delete a dagr from the database.
 * @param  [type] $uuid [description]
 * @return [type]       [description]
 */
function mmda_delete_dagr($uuid){

  //check if dagr exists
  if(!mmda_get_file($uuid)){
    return "No Dagr witht the uuid <strong>".$uuid."</strong> exists";
  }

  $db = db_connect();

  $sql = "DELETE FROM File WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM AudioMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM AuthoringMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM DocumentCountsMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM ExecutableMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM ImageResolutionMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM VideoMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM WebpageMetadata WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  $sql = "DELETE FROM FileReferences WHERE child_uuid = ? OR parent_uuid = ?";
  $query = $db->query($sql,array($uuid,$uuid));

  $sql = "DELETE FROM Keywords WHERE uuid = ?";
  $query = $db->query($sql,array($uuid));

  return "The DAGR (".$uuid.")has been deleted!";
}


/**
 * format html of result table.
 * @param  array $results to be formatted
 * @return string          html table
 */
function mmda_format_result_table($results){
  global $metadata_attributes;
  $html = '<div class="table-responsive" style="overflow:auto;"><table class="table table-striped table-condensed" style="font-size: .9em;" >';

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
      if($key == 'uuid'){
         $html .= '<td>'.$value. ' <a href="edit_file.php?uuid='.$value.'"> <span class="glyphicon glyphicon-edit"> </span> Edit </a> '
      . '<a href="delete_file.php?uuid='.$value.'"> <span class="glyphicon glyphicon-trash"> </span> Delete </a> </div>'.' </td>';
      }else{
        $html .= '<td>'.$value.'</td>';
      }
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
      if($count == $num_rows){
        unset($row[$column]);
      }
    }
  }
  return $results;
}
