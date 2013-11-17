<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
//load the template needed
require_once ('template/template.php');
require_once('libraries/OBJ-MySQL/bin/OBJ_mysql.php');
require_once('libraries/tikawrapper.php');
require_once('metadata_attributes.php');
require_once('mmda.php');
require_once('libraries/simple_html_dom.php');


// SET Template
$template = new MMDA_Template();

//set variables
$upload_dir = './dagrfiles/';

function db_connect(){

  //SET UP DB

  $db_config = array();
  $db_config["hostname"]  = "localhost";
  $db_config["database"]  = "dagrdb";
  $db_config["username"]  = "dagrdb";
  $db_config["password"]  = "snyder";
  //class instantiation
  $db = new OBJ_mysql($db_config);
  return $db;
}



