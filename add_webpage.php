<?php
require_once ('load_libraries.php');

$url = (!empty($_GET['url']))?$_GET['url']:"";

$add_webpage_form = '
<form class="form-horizontal" action="add_webpage.php" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Insert New Webpage</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="URLinput"></label>
  <div class="col-md-4">
  <input id="url" name="urltoadd" required="You must specify a URL" class="form-control input-md" type="text" value="'.$url.'">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" value="inserturl" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>
';

if(isset($_POST['submit']) && $_POST['submit'] == 'inserturl'){
  $results = '';
  $url = $_POST['urltoadd'];
  if (mmda_isValidURL($url)){
    $scraped_urls = mmda_get_webpage_content($url);
    print_r($scraped_urls);

    //add the webpage dagr
    $webpage_dagr_uuid = mmda_add_file($url,TRUE);
    print_r($webpage_dagr_uuid);

    $results .= '<div class="alert alert-sucess">Webpage added. <a href="edit_file.php?uuid='.$webpage_dagr_uuid.'">EDIT</a></div>';

    $web_page_child_uuids = array();
    //ADD EACH OF THE SCRAPED FILES
    foreach ($scraped_urls as $url) {
      $web_page_child_uuids[] = mmda_add_file($url,TRUE);
    }

    //SET THE PARENT UUID OF ALL OF THE FILES TO BE THE WEB PAGE
    foreach ($web_page_child_uuids as $child_uuid) {
      if(!empty($child_uuid)){
        mmda_update_parent_uuid($child_uuid,$webpage_dagr_uuid);
      }
    }
  } else {
    $results .= '<div class="alert alert-danger">URL is not valid.</a></div><a href="add_webpage.php" class="alert-link">Try Again</a>';
  }
  $template->setContent($results);
}else{
  $template->setContent($add_webpage_form);
}


$template->setTab(3);
$template->render();
