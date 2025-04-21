<?php
ob_clean(); // Clears any previous output
require_once 'config_session.inc.php';
require_once 'config.ini.php';
require_once 'dbh.inc.php';
require_once 'function.php';


if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$month = $_POST['report_month'] ?? null;

// Set headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="gig_report.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['Date', 'Type', 'Category', 'Amount', 'GST', 'HST', 'Notes']);

$transactions = getAllTransactions($pdo, $user_id, $month);

if (empty($transactions)) {
    fputcsv($output, ['No records found']);
} else {
    foreach ($transactions as $row) {
        fputcsv($output, [
            $row['Date'],
            ucfirst($row['Type']),
            $row['CategoryName'],
            $row['Amount'],
            $row['GST'] ?? '',
            $row['HST'] ?? '',
            $row['Note'] ?? ''
        ]);
    }
}

fclose($output);
exit();
