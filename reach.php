<?php
require_once ('load_libraries.php');

$content = '';

if(!empty($_GET['uuid'])){
  $uuid = $_GET['uuid'];
  $content .= '<h1>Reach Report For: <i>'.$uuid.'</i></h1>';
  $uuids = mmda_get_descendants($uuid);
  $content .= '<div>';
  foreach ($uuids as $uuid) {
    $content .= mmda_get_dagr_single_html($uuid);
  }
  $content .= '</div>';

}else{
  $content .= "<h1>Reach Report</h1>";
  $content .= "no uuid provided";
}


$template->setContent($content);
$template->setTab(9);
$template->render();
