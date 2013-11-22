<?php
require_once ('load_libraries.php');

$content = '';

$time_report_form = '
<form class="form-horizontal" method="GET">
<fieldset>

<!-- Form Name -->
<legend>Time Report</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="startDate"></label>
  <div class="col-md-4">
  <input id="startDate" name="startDate" placeholder="Start Date" class="form-control input-md" type="text" value="'.(!empty($_GET['startDate'])?$_GET['startDate']:'').'">
  <span class="help-block">mm/dd/yyyy</span>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="endDate"></label>
  <div class="col-md-4">
  <input id="endDate" name="endDate" placeholder="End Date" class="form-control input-md" type="text" value="'.(!empty($_GET['endDate'])?$_GET['endDate']:'').'">
  <span class="help-block">mm/dd/yyyy</span>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="query"></label>
  <div class="col-md-4">
    <button id="action" name="action" value="runtimereport" class="btn btn-primary">Run Report</button>
  </div>
</div>

</fieldset>
</form>
';




if(isset($_GET['action']) && $_GET['action'] == 'runtimereport'){

  $content .=$time_report_form;
  if(!empty($_GET['startDate']) && !empty($_GET['endDate'])){

    $time_report = mmda_get_time_report($_GET['startDate'],$_GET['endDate']);
   // print "<pre>";
   //print_r($time_report);
   // print "</pre>";
      $content .= mmda_format_result_table($time_report);
  }else{
   $content .= '<div class="alert alert-danger">You need to supply a valid start and end date</a></div>';
  }


}else{
  $content .=$time_report_form;
}

$template->setContent($content);
$template->setTab(6 );
$template->render();
