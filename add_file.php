<?php
require_once ('load_libraries.php');

$add_file_form = '
<form class="form-horizontal" action="add_file.php" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Insert New File</legend>

<!-- File Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="file">Select File</label>
  <div class="col-md-4">
    <input id="file" name="filetoadd" class="input-file" type="file" required="You must specify a file">
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


if(isset($_POST['submit']) && $_POST['submit'] == 'insertfile'){
  $results = '';

  //add file into tika
  if(!empty($_FILES) && !empty($_FILES['filetoadd'])){


    //move uploaded file to more permenat location.
    $uploadedfile = $upload_dir . $_FILES['filetoadd']['name'];
    if (move_uploaded_file($_FILES['filetoadd']['tmp_name'], $uploadedfile)) {

      $dagr_uuid = mmda_add_file($uploadedfile);

      if($dagr_uuid){
        $results .= '<div class="alert alert-success">This file\'s DAGR was inserted with the id <b>'.$dagr_uuid.'</b></div>';

        $results .= mmda_get_dagr_html($dagr_uuid);

      }else{
        $results .= '<div class="alert alert-danger"> File already in db.</a></div>';
      }


    } else {
      $results .= '<div class="alert alert-danger"> Was not able to add. Possible upload attack <a href="add_file.php" class="alert-link">Try Again</a></div>';
    }


  }else{
    $results .= '<div class="alert alert-danger"> Was not able to upload. <a href="add_file.php" class="alert-link">Try Again</a></div>';
  }
  $template->setContent($results);
}else{
  //show form
  $template->setContent($add_file_form);
}



$template->setTab(2);
$template->render();


