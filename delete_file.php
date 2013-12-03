<?php

require_once ('load_libraries.php');

$content = '';
if(isset($_GET['uuid'])){
  $result = mmda_delete_dagr($_GET['uuid']);
  $content = '<div class="alert"> '.$result.'</div>';
} else{
  $content = '<div class="alert alert-danger"> UUID not specified.</div>';
}


$template->setContent($content);
$template->setTab(2);
$template->render();
