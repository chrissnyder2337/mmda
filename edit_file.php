<?php
require_once ('load_libraries.php');

$content = '';
if(isset($_GET['uuid'])){
  $uuid = $_GET['uuid'];

  $dagr = mmda_get_file($uuid);

  //check if dagr was actually found.
  if($dagr){

    //start making the edit form
    $edit_file_form = '<form class="form-horizontal">
    <fieldset>';

    //define form name
    $edit_file_form .= '  <!-- Form Name -->
    <legend>Edit DAGR (UUID: '.$uuid.')</legend>';

    //define anotated name form
    $edit_file_form .= '<!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="anotated_name">Anotated Name</label>
      <div class="col-md-4">
      <input id="annottatedname" name="annottatedname" type="text" placeholder="Annotated Name" value="'.$dagr['anotated_name'].'" class="form-control input-md">
      </div>
    </div>';

    //define parent uuid select list
    $parent_uuid = mmda_get_parent_uuid($uuid);
    if($parent_uuid){
      $parent_uuid_options = mmda_get_dagrs_list_select_options($parent_uuid);
    }else{
      $parent_uuid_options = mmda_get_dagrs_list_select_options();
    }
    $edit_file_form .= '<!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="parent_uuid">Parent DAGR</label>
      <div class="col-md-5">
        <select id="parent_uuid" name="parent_uuid" class="form-control">
          <option value ="">--- NONE ---</option>
          '.$parent_uuid_options.'
        </select>
      </div>
    </div>';


    //define keyword edit.
    $edit_file_form .= ' <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="keywords">Keywords</label>
      <div class="col-md-5">
      <input id="keywords" name="keywords" type="text" placeholder="keywords" class="form-control input-md">
      <span class="help-block">Comma Seperated</span>
      </div>
    </div>';


    //define the submit button
    $edit_file_form .= '<!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="singlebutton"></label>
    <div class="col-md-4">
      <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
    </div>
  </div>';

    //print_r($dagr);


    //end form
    $edit_file_form .= '  </fieldset>
    </form>';


    $content .= $edit_file_form;
  }else{
    $content = '<div class="alert alert-danger"> DAGR with UUID of '.$uuid.' not found.</a></div>';
  }

  $edit_file_form = '
  <form class="form-horizontal">
  <fieldset>

  <!-- Form Name -->
  <legend>Edit DAGR (UUID: 4567-56789-567s678-45678)</legend>



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

} else{
  $content = '<div class="alert alert-danger"> UUID not specified.</a></div>';
}


$template->setContent($content);
$template->setTab(2);
$template->render();


