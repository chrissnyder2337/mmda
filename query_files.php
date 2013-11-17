<?php 
require_once ('load_libraries.php');

function get_attributeoptions(){
 
  $attribute_options = '';

  $attributes = mmda_get_filterable_attributes();
  
  foreach($attributes as $dbattr => $displayattr){
    $attribute_options .= '<option value="'.$dbattr.'">'.$displayattr.'</option>';
  }
  
  return $attribute_options;
}

$criteria_form = '
<div class="row">
  <div class="form-inline">
    <div class="col-md-4">
      <div class="form-group">
          <select id="attribute" name="attribute[]" class="form-control">
            '.get_attributeoptions().'
          </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
          <select id="operator" name="operator[]" class="form-control">
            <option value="= \'value\'">Equal To</option>
            <option value="!= \'value\'">Not Equal To</option>
            <option value="< \'value\'">Less Than</option>
            <option value="> \'value\'">Greater Than</option>
            <option value="LIKE \'%value%\'">Contains</option>
            <option value="">Does Not Contain</option>
          </select>
      </div>
    </div>
    <div class="col-md-4">
      <!-- Text input-->
      <div class="form-group">
        <input id="value" name="value[]" placeholder="value" class="form-control input-md" type="text">
      </div>
    </div>
  </div>
</div>
';

$query_form = '
<script>
  var criteria = 1;
  function add_criteria() {
      criteria++;
      var objTo = document.getElementById("criteria_field")
      var divtest = document.createElement("div");
      divtest.innerHTML =document.getElementById("criteria_field_template").innerHTML;
      
      objTo.appendChild(divtest)
  }
</script>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Query Metadata</legend>

<input type="button" id="more_criteria" onclick="add_criteria();" value="Add Criteria" />

<div id="criteria_field_template" style="display:none">
'.$criteria_form.'
</div>

<div id="criteria_field"> '
 . $criteria_form .
'</div>

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

$template->setContent($query_form);
$template->setTab(4);
$template->render();
