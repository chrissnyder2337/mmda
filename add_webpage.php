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
  $array = mmda_get_webpage_content($_POST['urltoadd']);
  var_dump($array);
}else{
  $template->setContent($add_webpage_form);
}


$template->setTab(3);
$template->render();
