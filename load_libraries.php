<?php
//load the template needed
require_once ('template/template.php');
require_once('libraries/OBJ-MySQL/bin/OBJ_mysql.php');

//SET UP DB

$config = array();
$config["hostname"]  = "localhost ";
$config["database"]  = "dagrdb";
$config["username"]  = "dagrdb";
$config["password"]  = "snyder";

//class instantiation
$db = new OBJ_mysql($config);


// SET Template
$template = new MMDA_Template();





