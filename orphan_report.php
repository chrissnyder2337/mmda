<?php
require_once ('load_libraries.php');

$content = '';
$content .= "<h1>Orphan Report</h1>";
$content .= "<p>These are all of the DAGRs which have no Parent DAGRs.</p>";
$orphan_report = mmda_get_orphan_report();
$orphan_report = mmda_remove_empty_columns($orphan_report);
$content .= mmda_format_result_table($orphan_report);


$template->setContent($content);
$template->setTab(5);
$template->render();
