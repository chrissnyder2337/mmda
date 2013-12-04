<?php
require_once ('load_libraries.php');


$add_file_form = '
<form class="form-horizontal" action="add_file.php" method="post" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Insert New File</legend>

<!-- File Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="file">Select File(s)</label>
  <div class="col-md-4">
    <input id="file" name="filetoadd[]"  multiple="" class="input-file" type="file" required="You must specify a file">
    <span class="help-block">To bulk add use Ctrl/Shift to select many files.</span>
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

    $number_of_files = count($_FILES['filetoadd']['name']);
    $file_index = 0;

    while($file_index < $number_of_files){

      //move uploaded file to more permenat location.
      $uploadedfile = $upload_dir . $_FILES['filetoadd']['name'][$file_index];
      if (move_uploaded_file($_FILES['filetoadd']['tmp_name'][$file_index], $uploadedfile)) {

        $dagr_uuid = mmda_add_file($uploadedfile);

        if($dagr_uuid){
          $results .= '<div class="alert alert-success">'.$_FILES['filetoadd']['name'][$file_index].'\'s DAGR was added. <a target="_blank" href="edit_file.php?uuid='.$dagr_uuid.'" class="btn btn-primary btn-large">EDIT <i class="icon-white icon-circle-arrow-right"></i></a></div>';

          //$results .= '<script>window.location="edit_file.php?uuid='.$dagr_uuid.'";</script>';

          //$results .= '<a href="edit_file.php?uuid='.$dagr_uuid.'" class="btn btn-primary btn-large">Continue <i class="icon-white icon-circle-arrow-right"></i></a>';

          //$results .= mmda_get_dagr_html($dagr_uuid);

        }else{
          $results .= '<div class="alert alert-danger"> File already in db.</a></div>';
        }


      } else {
        $results .= '<div class="alert alert-danger"> Was not able to add. Possible upload attack <a href="add_file.php" class="alert-link">Try Again</a></div>';
      }

      $file_index++;
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


