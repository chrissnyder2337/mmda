<?php
require_once ('load_libraries.php');
$welcome_message = "<h1>Welcome the the MMDA</h1>";

$template->setContent($welcome_message);
$template->setTab(1);
$template->render();
