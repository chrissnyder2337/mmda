<?php
require_once ('load_libraries.php');

$edit_file_form = '
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Edit DAGR (UUID: 4567-56789-567s678-45678)</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="annottatedname">Annotated Name</label>
  <div class="col-md-4">
  <input id="annottatedname" name="annottatedname" type="text" placeholder="Annotated Name" class="form-control input-md">

  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="keywords">Keywords</label>
  <div class="col-md-5">
  <input id="keywords" name="keywords" type="text" placeholder="keywords" class="form-control input-md">
  <span class="help-block">Comma Seperated</span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>

';


if(isset($_POST['submit']) && $_POST['submit'] == 'editfile'){
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
  $template->setContent($edit_file_form);
}



$template->setTab(2);
$template->render();


