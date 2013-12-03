<?php

class MMDA_Template{

  public $title = 'MMDA';
  public $head = '<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="libraries/bootstrap/docs-assets/ico/favicon.png">

    <title>Mulimedia Data Aggregator</title>

    <!-- Bootstrap core CSS -->
    <link href="libraries/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="template/mmda.css" rel="stylesheet">


    <!-- Load custom js -->
    <script type="text/javascript" src="template/mmda.js">

    </script>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

    <!--[if lt IE 9]><script src="libraries/bootstrap/docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  ';

public $body_prefix = '<body style="" screen_capture_injected="true"> <div id="wrap">';

public $nav_bar = '';

  public $content_prefix = '<div class="container">      <div class="starter-template">';

  public $content_suffix = ' </div><!-- /.container --></div>';

  public $body_suffix = '
  </div> <!-- /wrap div-->
  <div id="footer">
      <div class="container">
        <p class="text-muted credit"> Project for <em>CMSC424: Database Design</em> at the University of Maryland. Created by <a href="http://chrissnyder.org">Christopher Snyder</a> and <a href="http://www.linkedin.com/pub/jonathan-snyder/9/a1b/b89">Jon Snyder</a>. &copy; 2013</p>
      </div>
    </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="./libraries/bootstrap/dist/js/bootstrap.min.js"></script>

  </body></html>';

  public $content;

public function setContent($content)
{
  $this->content = $content;
}

/* givin a tab number sets it as the active tab */
public function setTab($activeTab)
{
  $this->nav_bar = '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Mulimedia Data Aggregator</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li '. (($activeTab == 2)?'class="active"':'').'><a href="add_file.php"><span class="glyphicon glyphicon-file"></span> Add File</a></li>
            <li '. (($activeTab == 3)?'class="active"':'').'><a href="add_webpage.php"><span class="glyphicon glyphicon-globe"></span> Add Webpage</a></li>
            <li '. (($activeTab == 4)?'class="active"':'').'><a href="query_files.php"><span class="glyphicon glyphicon-search"></span> Query Metadata
            <li '. (($activeTab == 5)?'class="active"':'').'><a href="orphan_report.php"><span class="glyphicon glyphicon-list-alt"></span> Orphan Report</a></li>
            <li '. (($activeTab == 6)?'class="active"':'').'><a href="sterile_report.php"><span class="glyphicon glyphicon-list-alt"></span> Sterile Report</a></li>
            <li '. (($activeTab == 7)?'class="active"':'').'><a href="time_report.php"><span class="glyphicon glyphicon-calendar"></span> Time Report</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>';

}

  public function render()
  {
    print $this->head;
    print $this->body_prefix;
    print $this->nav_bar;
    print $this->content_prefix;
    print $this->content;
    print $this->content_suffix;
    print $this->body_suffix;
  }


}
