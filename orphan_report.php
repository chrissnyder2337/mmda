<?php
require_once ('load_libraries.php');
$welcome_message = "<h1>Orphan Report Here</h1>";

$template->setContent($welcome_message);
$template->setTab(5);
$template->render();
