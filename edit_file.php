<?php
require_once ('load_libraries.php');

$content = '';
if(isset($_GET['uuid'])){

  $uuid = $_GET['uuid'];

  //TODO do all changes here.

  if(isset($_POST['anotated_name'])){
    mmda_update_anotated_name($uuid,$_POST['anotated_name']);
  }

  if(isset($_POST['parent_uuid'])){
    mmda_update_parent_uuid($uuid,$_POST['parent_uuid']);
  }


  if(isset($_POST['keywords'])){
  //   //update keywords here
    $keywords = explode(",", trim($_POST['keywords']));
    mmda_update_dagr_keywords($uuid,$keywords);
  }

  $dagr = mmda_get_file($uuid);

  //check if dagr was actually found.
  if($dagr){

    //start making the edit form
    $edit_file_form = '<form class="form-horizontal" method="post">
    <fieldset>';

    //define form name
    $edit_file_form .= '  <!-- Form Name -->
    <legend>Edit DAGR (UUID: '.$uuid.')</legend>';

    //define anotated name form
    $edit_file_form .= '<!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="anotated_name">Anotated Name</label>
      <div class="col-md-4">
      <input id="anotated_name" name="anotated_name" type="text" placeholder="Annotated Name" value="'.$dagr['anotated_name'].'" class="form-control input-md">
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
    //TODO: maybe implement something like http: this://jqueryui.com/autocomplete/#multiple
    $keywords = mmda_get_keywords($uuid);
    if(is_array($keywords) && !empty($keywords)){
      $keywords_string = implode(",", $keywords);
    }else{
      $keywords_string ='';
    }
    $edit_file_form .= ' <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="keywords">Keywords</label>
      <div class="col-md-5">
      <input id="keywords" name="keywords" type="text" placeholder="keywords" class="form-control input-md" value="'.$keywords_string.'"/>
      <span class="help-block">Comma Seperated</span>
      </div>
    </div>';


    //define the submit button
    $edit_file_form .= '<!-- Button -->
  <div class="form-group">
    <label class="col-md-4 control-label" for="singlebutton"></label>
    <div class="col-md-8">
      <a href="delete_file.php?uuid='.$uuid.'"> <span class="glyphicon glyphicon-trash"> </span> Delete DAGR </a>
      <button id="singlebutton" name="singlebutton" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save Changes</button>

    </div>
  </div>';

    //print_r($dagr);


    //end form
    $edit_file_form .= '  </fieldset>
    </form>';


    $content .= $edit_file_form;


    //get viewable dagr
    $content .= mmda_get_dagr_html($uuid);
  }else{
    $content = '<div class="alert alert-danger"> DAGR with UUID of '.$uuid.' not found.</a></div>';
  }

} else{
  $content = '<div class="alert alert-danger"> UUID not specified.</div>';
}


$template->setContent($content);
$template->setTab(2);
$template->render();


