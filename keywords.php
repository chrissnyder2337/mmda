<?php
require_once ('load_libraries.php');

$content = '';

if(!empty($_GET['keyword'])){
  $keyword = $_GET['keyword'];
  $content .= '<h1>Keyword: '.$keyword.'</h1>';
  $uuids = mmda_get_uuids_by_keyword($keyword);
  $content .= '<div>';
  foreach ($uuids as $uuid) {
    $content .= mmda_get_dagr_single_html($uuid);
  }
  $content .= '</div>';

}else{
  $content .= "<h1>Keywords</h1>";
  $content .= '<div class="list-group">';
  $keywords = mmda_get_all_keywords();
  foreach ($keywords as $keyword) {
    $content .= '<a class="list-group-item" href="keywords.php?keyword='.$keyword.'"><span class="glyphicon glyphicon-tag"></span> '.$keyword.'</a>';
  }
  $content .= '</div>';
}


$template->setContent($content);
$template->setTab(9);
$template->render();
