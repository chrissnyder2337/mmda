<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
//load the template needed
require_once ('template/template.php');
require_once('libraries/OBJ-MySQL/bin/OBJ_mysql.php');
require_once('libraries/tikawrapper.php');
require_once('mmda.php');

//SET UP DB

$config = array();
$config["hostname"]  = "localhost";
$config["database"]  = "dagrdb";
$config["username"]  = "dagrdb";
$config["password"]  = "snyder";

//class instantiation
$db = new OBJ_mysql($config);


// SET Template
$template = new MMDA_Template();

//set variables
$upload_dir = './dagrfiles/';



