<?php 
require_once ('load_libraries.php');

$add_webpage_form = '
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Insert New Webpage</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="URLinput">URL</label>  
  <div class="col-md-4">
  <input id="URLinput" name="URLinput" placeholder="" class="form-control input-md" required="" type="text">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>
';

$template->setContent($add_webpage_form);
$template->setTab(3);
$template->render();
