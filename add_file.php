<?php
require_once ('load_libraries.php');

$add_file_form = '
<form class="form-horizontal" action="add_file.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Insert New File</legend>

<!-- File Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="file">Select File</label>
  <div class="col-md-4">
    <input id="file" name="file" class="input-file" type="file" required="You must specify a file">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" value="insertfile" class="btn btn-primary">Insert File Metadata</button>
  </div>
</div>

</fieldset>
</form>
';



//Decide what page to display
switch (variable) {
  case 'value':
    # code...
    break;

  default:
    # code...
    break;
}










print "<pre>";
print_r($_POST);
print "</pre>";






$template->setContent($add_file_form);
$template->setTab(2);
$template->render();


