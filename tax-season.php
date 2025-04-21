<?php
require_once 'includes/config.ini.php';
require_once 'includes/function.php';
require_once 'includes/signin_view.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

// Fetch income data
try {
    $income_data = getYearlyIncomeByCategory($pdo, $_SESSION["user_id"]);
    $income_totals = [];
    $income_year_total = 0;
    foreach ($income_data as $row) {
        $income_totals[$row['categoryName']] = $row['total'];
        $income_year_total += $row['total'];
    }
} catch (Exception $e) {
    $income_totals = [];
    $income_year_total = 0;
    error_log("Error fetching income data: " . $e->getMessage());
}

// Fetch expense data
try {
    $expense_data = getYearlyExpenseByCategory($pdo, $_SESSION["user_id"]);
    $expense_totals = [];
    $expense_year_total = 0;
    foreach ($expense_data as $row) {
        $expense_totals[$row['categoryName']] = $row['total'];
        $expense_year_total += $row['total'];
    }
} catch (Exception $e) {
    $expense_totals = [];
    $expense_year_total = 0;
    error_log("Error fetching expense data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tax Season Summary</title>
    <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
    <div class="container">

        <header class="header">
            <h1>📄 Tax Season Summary</h1>
            <div class="user-info">
                <p>Welcome, <strong><?php output_username(); ?></strong></p>
                <nav class="nav-links">
                    <a href="dashboard.php">🏠 Dashboard</a> |
                    <a href="includes/signout.inc.php">🚪 Sign Out</a>
                </nav>
            </div>
        </header>

        <main class="content">

            <!-- Income Summary -->
            <section class="content-box">
                <h2>📊 Income Categories</h2>
                <ul class="category-list">
                    <?php foreach ($income_totals as $category => $total): ?>
                        <li><?= htmlspecialchars($category); ?> — $<?= number_format($total, 2); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total Income for the Year:</strong> $<?= number_format($income_year_total, 2); ?></p>


            </section>

            <!-- Expense Summary -->
            <section class="content-box">
                <h2>💸 Expense Categories</h2>
                <ul class="category-list">
                    <?php foreach ($expense_totals as $category => $total): ?>
                        <li><?= htmlspecialchars($category); ?> — $<?= number_format($total, 2); ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total Expenses for the Year:</strong> $<?= number_format($expense_year_total, 2); ?></p>
            </section>

            <!-- Report Download -->
            <section class="content-box">
            <h2>📊 Tax Categories</h2>
                <ul class="category-list">
                    <li>HST</li>
                    <li>QST</li>                
                </ul>
                </h2>
                <p><strong>Total GST and HST Collected for the Year:</strong> $<?= number_format($income_year_total, 2); ?></p>
                <h2>🧾 Download Full Report</h2>
                <p>You can download a full summary of your income and expenses for your tax records.</p>
                <a href="download_report.php?report_month=<?= date('Y-m'); ?>" class="download-link">📥 Download CSV Report</a>
            </section>

        </main>

        <footer class="footer">
            <p>&copy; <?= date('Y'); ?> Gig Income Tracker</p>
        </footer>

    </div>
</body>
</html>
