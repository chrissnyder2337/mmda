<?php 
require_once ('load_libraries.php');

$add_webpage_form = '
<form class="form-horizontal" action="add_webpage.php" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Insert New Webpage</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="URLinput">URL</label>  
  <div class="col-md-4">
  <input id="url" name="urltoadd" required="You must specify a URL" class="form-control input-md" type="text">
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
    $array = mmda_get_webpage_content($url);
    $results .= var_dump($array);
  } else {
    $results .= '<div class="alert alert-danger">URL is not valid.</a></div><a href="add_webpage.php" class="alert-link">Try Again</a>';
  }
  $template->setContent($results);
}else{
  $template->setContent($add_webpage_form);
}


$template->setTab(3);
$template->render();
