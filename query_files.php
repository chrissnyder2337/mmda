<?php
require_once ('load_libraries.php');

$content = '';

$query_form = '

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Query Metadata</legend>

<div id="criteria_field">
<!-- Text input-->
  <div class="form-group">
    <label class="col-md-3 control-label" for="where_clause">Where Clause</label>
    <div class="col-md-8">
    <input id="where_clause" name="where_clause" type="text" placeholder="File.anotated_name = \'hat\'" class="form-control input-md" required="">
    <span class="help-block">Provide SQL Conditions. Example: File.anotated_name = "hat"</span>
    </div>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="query"></label>
  <div class="col-md-4">
    <button id="query" name="submit" value="query" class="btn btn-primary">Query</button>
  </div>
</div>

</fieldset>
</form>
';

$content .= $query_form;

if(isset($_GET['submit']) && $_GET['submit'] == 'query'){

  $where_clause = $_GET['where_clause'];

  $query_results = mmda_run_custom_query($where_clause);
  $query_results = mmda_remove_empty_columns($query_results);
  $results_html = mmda_format_result_table($query_results);

  $content .= $results_html;

}

$template->setContent($content);
$template->setTab(4);
$template->render();
