<?php
require_once ('load_libraries.php');

$content = '';

$query_help = '
<h3> Query Help </h3> <a data-toggle="collapse" data-target="#helper">
  Show / Hide
</a>
<div class="helper" id="helper">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">File</h3>
      </div>
      <div class="panel-body">
        Main file metadata.
      </div>
      <ul class="list-group">
        <li class="list-group-item"><code>File.annotated_name</code>  User annotated Name</li>
        <li class="list-group-item"><code>File.resource_name</code>  File name of document</li>
        <li class="list-group-item"><code>File.content_type</code>  ex: html, pdf, etc <br><i>Recommend use <code>LIKE</code> for these.</li>
        <li class="list-group-item"><code>File.content_length</code>  Size of file (in bytes)</li>
        <li class="list-group-item"><code>File.file_added_timestamp</code></li>
        <li class="list-group-item"><code>File.local_path</code></li>
        <li class="list-group-item"><code>File.external_path</code>  ex: URL</li>
      </ul>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Webpage</h3>
      </div>
      <div class="panel-body">
        Webpage specific metadata.
      </div>
       <ul class="list-group">
        <li class="list-group-item"><code>WebpageMetadata.webpage_title</code></li>
      </ul>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Video</h3>
      </div>
      <div class="panel-body">
        Video specific metadata.
      </div>
       <ul class="list-group">
        <li class="list-group-item"><code>VideoMetadata.video_format</code></li>
        <li class="list-group-item"><code>VideoMetadata.video_duration</code></li>
        <li class="list-group-item"><code>VideoMetadata.audio_duration</code></li>
      </ul>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Authoring</h3>
      </div>
      <div class="panel-body">
        Generic file metadata involving author and date.
      </div>
       <ul class="list-group">
        <li class="list-group-item"><code>AuthoringMetadata.created_date</code></li>
          <li class="list-group-item"><code>AuthoringMetadata.last_modified_date</code></li>
          <li class="list-group-item"><code>AuthoringMetadata.author</code></li>
          <li class="list-group-item"><code>AuthoringMetadata.title</code></li>
      </ul>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Document Counts</h3>
      </div>
      <div class="panel-body">
        Document counts found in office file types.
      </div>
      <ul class="list-group">
        <li class="list-group-item"><code>DocumentCountsMetadata.image_count</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.page_count</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.table_count</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.paragraph_count</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.character_count</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.word_count</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.<br>character_count_with_space</code></li>
        <li class="list-group-item"><code>DocumentCountsMetadata.slide_count</code></li>
      </ul>
    </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Image</h3>
      </div>
      <div class="panel-body">
        Demension metadata of image files.
      </div>
      <ul class="list-group">
        <li class="list-group-item"><code>ImageResolutionMetadata.x_resolution</code></li>
        <li class="list-group-item"><code>ImageResolutionMetadata.y_resolution</code></li>
        <li class="list-group-item"><code>ImageResolutionMetadata.resolution_units</code></li>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Audio</h3>
      </div>
      <div class="panel-body">
        Metadata involving music and audio files.
      </div>
      <ul class="list-group">
        <li class="list-group-item"><code>AudioMetadata.audio_bitrate</code></li>
        <li class="list-group-item"><code>AudioMetadata.audio_sample_rate</code></li>
        <li class="list-group-item"><code>AudioMetadata.channels</code></li>
        <li class="list-group-item"><code>AudioMetadata.channel_type</code></li>
        <li class="list-group-item"><code>AudioMetadata.audio_format</code></li>
        <li class="list-group-item"><code>AudioMetadata.track_number</code></li>
        <li class="list-group-item"><code>AudioMetadata.title</code></li>
        <li class="list-group-item"><code>AudioMetadata.genre</code></li>
        <li class="list-group-item"><code>AudioMetadata.duration</code></li>
        <li class="list-group-item"><code>AudioMetadata.artist</code></li>
        <li class="list-group-item"><code>AudioMetadata.album</code></li>
        <li class="list-group-item"><code>AudioMetadata.audio_compression</code></li>
    </div>
  </div>
</div>';

$query_form = '

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<h1>Query Metadata</h1>

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

$content .= $query_form . $query_help;

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
