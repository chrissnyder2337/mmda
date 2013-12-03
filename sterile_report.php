<?php
require_once ('load_libraries.php');

$content = '';
$content .= "<h1>Sterile Report</h1>";
$content .= "<p>These are all of the DAGRs which have no Children DAGRs.</p>";
$sterile_report = mmda_get_sterile_report();
$sterile_report = mmda_remove_empty_columns($sterile_report);
$content .= mmda_format_result_table($sterile_report);


$template->setContent($content);
$template->setTab(5);
$template->render();
