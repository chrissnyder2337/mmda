<?php 
require_once ('load_libraries.php');

$time_report_form = '
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Time Report</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="startDate"></label>  
  <div class="col-md-4">
  <input id="startDate" name="startDate" placeholder="Start Date" class="form-control input-md" type="text">
  <span class="help-block">mm/dd/yyyy</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="endDate"></label>  
  <div class="col-md-4">
  <input id="endDate" name="endDate" placeholder="End Date" class="form-control input-md" type="text">
  <span class="help-block">mm/dd/yyyy</span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="query"></label>
  <div class="col-md-4">
    <button id="query" name="query" class="btn btn-primary">Query</button>
  </div>
</div>

</fieldset>
</form>
';
