<?php 
require_once ('load_libraries.php');

$query_form = '
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Query Metadata</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="metadataType">Metadata Type</label>
  <div class="col-md-4">
    <select id="metadataType" name="metadataType" class="form-control">
      <option value="1">Audio</option>
      <option value="2">Authoring</option>
      <option value="3">Document Counts</option>
      <option value="4">Executable</option>
      <option value="5">Image Dimensions</option>
      <option value="6">Image Resolution</option>
      <option value="7">Keyword</option>
      <option value="8">Video</option>
      <option value="9">Webpage</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="attribute">Attribute</label>
  <div class="col-md-4">
    <select id="attribute" name="attribute" class="form-control">
      <option value="1">[dynamically created based off of metadataType]</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="operator"></label>
  <div class="col-md-4">
    <select id="operator" name="operator" class="form-control">
      <option value="= 'value'">Equal To</option>
      <option value="!= 'value'">Not Equal To</option>
      <option value="< 'value'">Less Than</option>
      <option value="> 'value'">Greater Than</option>
      <option value="LIKE '%value%'">Contains</option>
      <option value="">Does Not Contain</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="value">Value</label>  
  <div class="col-md-4">
  <input id="value" name="value" placeholder="" class="form-control input-md" type="text">
    
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
