<?php
session_start();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tasks.csv"');

$output = fopen('php://output', 'w');

fputcsv($output, ['Task', 'Completed', 'Description', 'Date', 'Color']);

foreach ($_SESSION['todo_lists'] as $list_name => $list) {
    foreach ($list['tasks'] as $index => $task) {
        $completed = $_SESSION['todo_lists'][$list_name]['completed'][$index] ? 'Yes' : 'No';
        $description = $_SESSION['todo_lists'][$list_name]['descriptions'][$index];
        $date = $_SESSION['todo_lists'][$list_name]['dates'][$index];
        $color = $_SESSION['todo_lists'][$list_name]['colors'][$index];

        fputcsv($output, [$task, $completed, $description, $date, $color]);
    }
}

fclose($output);
exit();
?>
