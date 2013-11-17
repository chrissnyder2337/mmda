<?php 
require_once ('load_libraries.php');

$add_file_form = '
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Insert New File</legend>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="file">Select File</label>
  <div class="col-md-4">
    <input id="file" name="file" class="input-file" type="file">
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

$template->setContent($add_file_form);
$template->setTab(2);
$template->render();


