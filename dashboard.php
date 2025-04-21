<?php 
require_once 'includes/config.ini.php';
 if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

require_once "includes/dbh.inc.php";
require_once "includes/function.php";
require_once 'includes/signin_view.inc.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Income and Expense for GIGWorks</title>
  <link rel="stylesheet" href="includes/styles.css">
</head>
<body>
  <div class="container">
    <header class="header">
      <h1>GIG INCOME AND EXPENSE</h1>
      <div class="user-info">
        <p>Welcome, <strong><?php output_username(); ?></strong></p>
        <nav class="nav-links">
          <a href="tax-season.php">📄 Tax Season</a> |
          <a href="includes/signout.inc.php">🚪 Sign Out</a>
        </nav>
      </div>
    </header>
    
    <div id="stat1" class="stat-card">
    <?php
    try {
      $result = totalIncome($pdo, $_SESSION["user_id"]);

      $totalIncome = isset($result['total_income']) ? number_format($result['total_income'], 2) : '0.00';
      $currentMonth = isset($result['current_month']) ? $result['current_month'] : date('Y-m');
      
        echo '<h2>$' . htmlspecialchars($totalIncome) . '</h2>
              <p><p>' . htmlspecialchars(date('F', strtotime($currentMonth . '-01'))) . ' Earnings</p>
              <small>Total Earnings Without GST/HST For The Month</small>';
    } catch (\Throwable $th) {
        echo '<small>Error loading data</small>';
        error_log("Error in stat1: " . $th->getMessage());
    }
    ?>
</div>
    <div id="stat2" class="stat-card">
    <?php
try {
  $result = totalExpense($pdo, $_SESSION["user_id"]);

  $totalExpense = isset($result['total_expense']) ? number_format($result['total_expense'], 2) : '0.00';
  $currentMonth = isset($result['current_month']) ? $result['current_month'] : date('Y-m');
  
    echo '<h2>$' . htmlspecialchars($totalExpense) . '</h2>
          <p><p>' . htmlspecialchars(date('F', strtotime($currentMonth . '-01'))) . ' Expense</p>
          <small>Total Of All Expense For The Month</small>';
} catch (\Throwable $th) {
    echo '<h2>$0.00</h2>
          <p>' . date('Y-m') . ' Expenses</p>
          <small>Error loading data</small>';
    error_log("Error in expense stats: " . $th->getMessage());
}
?>
    </div>
    <div id="stat3" class="stat-card">
    <?php
    try {
      $result = totalTax($pdo, $_SESSION["user_id"]);

      $totalTax = isset($result['total_tax']) ? number_format($result['total_tax'], 2) : '0.00';
      $currentMonth = isset($result['current_month']) ? $result['current_month'] : date('Y-m');
      
        echo '<h2>$' . htmlspecialchars($totalTax) . '</h2>
              <p><p>' . htmlspecialchars(date('F', strtotime($currentMonth . '-01'))) . ' Tax</p>
              <small>Total of GST + HST</small>';
    } catch (\Throwable $th) {
        echo '<h2>$0.00</h2>
              <p>March Earnings</p>
              <small>Error loading data</small>';
        error_log("Error in stat1: " . $th->getMessage());
    }
    ?>
    </div>
    <div id="stat4" class="stat-card">
<?php
try {
    $incomeResult = totalIncome($pdo, $_SESSION["user_id"]);
    $expenseResult = totalExpense($pdo, $_SESSION["user_id"]);
    $taxResult = totalTax($pdo, $_SESSION["user_id"]);

    $incomeRaw = isset($incomeResult['total_income']) ? (float)$incomeResult['total_income'] : 0;
    $expenseRaw = isset($expenseResult['total_expense']) ? (float)$expenseResult['total_expense'] : 0;
    $taxRaw = isset($taxResult['total_tax']) ? (float)$taxResult['total_tax'] : 0;

    //Calculation for Net earnings (income less expense and tax)
    $netEarnings = $incomeRaw - ($expenseRaw + $taxRaw);
    $netFormatted = number_format($netEarnings, 2);

    $currentMonth = isset($incomeResult['current_month']) ? $incomeResult['current_month'] : date('Y-m');

    //Calculation for %30 of tax provision
    $taxProvision = $netEarnings * .3;
    $taxProvisionFormatted = number_format($taxProvision, 2);

    echo '
        <h2>$' . htmlspecialchars($netFormatted) . '</h2>
        <p>' . htmlspecialchars(date('F', strtotime($currentMonth . '-01'))) . ' Net Income - After expenses and taxes</p>
        <small>Tax Provision (30%) For The month is $' . htmlspecialchars($taxProvisionFormatted) . '</small>
    ';
} catch (\Throwable $th) {
    echo '
        <h2>$0.00</h2>
        <p>Net Income</p>
        <small>Error calculating net earnings</small>
    ';
    error_log("Error calculating net: " . $th->getMessage());
}
?>
</div>
   
    <section class="content">
      <!-- Income Form Column -->
      <div class="content-box">
        <h2>Income Form</h2>
        <form class="form-container" action="includes/income_formhandler.ini.php" method="post">
          <div class="form-group">
            <label for="income-source">Income Source</label>
            <select id="income-source" name="incomeCategory" required>
              <option value="">Select platform...</option>
              <option value="1">Uber</option>
              <option value="2">Instacart</option>
              <option value="3">DoorDash</option>
              <option value="4">SkipTheDishes</option>
              <option value="5">Other</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="income-amount">Amount (CA$)</label>
            <input type="number" id="income-amount" name="incomeAmount" placeholder="0.00" step="0.01" required>
          </div>
          
          <div class="form-group">
            <label for="income-date">Date</label>
            <input type="date" id="income-date" name="incomeDate" required>
          </div>
          
          <div class="form-group">
            <label for="income-qst">QST ($)</label>
            <input type="number" id="income-gst" name="gstAmount" placeholder="0.00" step="0.01" value="">
          </div>
          
          <div class="form-group">
            <label for="income-hst">HST ($)</label>
            <input type="number" id="income-hst" name="hstAmount" placeholder="0.00" step="0.01" value="">
          </div>
          
          <div class="form-group">
            <label for="income-attachment">Receipt/Proof</label>
            <input type="file" id="income-attachment" name="payslipFile">
          </div>
          
          <div class="form-group">
            <label for="income-note">Notes</label>
            <textarea id="income-note" name="IncomeNote" rows="3" placeholder="Additional details..."></textarea>
          </div>
          
          <button type="submit">Submit Income</button>
        </form>
      </div>
      
      <!-- Expense Form Column -->
      <div class="content-box">
        <h2>Expense Form</h2>
        <form class="form-container" action="includes/expense_formhandler.ini.php" method="post">
          <input type="hidden" name="form_type" value="expense">
          
          <div class="form-group">
            <label for="expense-category">Category</label>
            <select id="expense-category" name="expenseCategory" required>
              <option value="">Select category...</option>
              <option value="1">Fuel</option>
              <option value="2">Oil</option>
              <option value="3">Motor Vehicle expenses</option>
              <option value="4">Insurance</option>
              <option value="6">Maintenance and repairs</option>
              <option value="7">Telephone</option>
              <option value="8">Meals and Entertainment</option>
              <option value="9">Bad debts</option>
              <option value="10">Business Tax, Fees, licenses, dues, membership</option>
              <option value="11">Other expenses</option>
            </select>
          </div>

          <div class="form-group">
            <label for="expense-amount">Amount ($)</label>
            <input type="number" id="expense-amount" name="expenseAmount" placeholder="0.00" step="0.01" required>
          </div>

          <div class="form-group">
            <label for="expense-date">Date</label>
            <input type="date" id="expense-date" name="expenseDate" required>
          </div>

          <div class="form-group">
            <label for="expense-attachment">Receipt</label>
            <input type="file" id="expense-attachment" name="receipt">
          </div>
          
          <div class="form-group">
            <label for="expense-note">Notes</label>
            <textarea id="expense-note" name="expenseNote" rows="3" placeholder="Add notes..."></textarea>
          </div>

          <button type="submit">Submit Expense</button>
        </form>
      </div>
      
      <!-- Recent Transactions Column -->
      <div class="content-box transactions">
        <h2>Recent Transactions</h2>
    <?php                        
    try {
        $transactions = getRecentTransact ($pdo, (int) $_SESSION["user_id"]);
        
        if ($transactions) {
            foreach ($transactions as $row) {
                // Determine CSS class based on transaction type
                $amountClass = strtolower($row['Type']) === 'income' ? 'income' : 'expense';
                
                echo '<ul class="transaction-list">
                    <li class="transaction-item" >
                        <span>'.htmlspecialchars($row['CategoryName']).' '.htmlspecialchars($row['Type']).'</span>
                        <span class="transaction-amount '.$amountClass.'">$'.number_format($row['Amount'], 2).'</span>
                    </li>
                </ul>';
            }
        } else {
            echo '<p class="no-transactions">No transactions found</p>';
        }
    } catch (PDOException $e) {
        echo '<p class="error">Error loading transactions: '.htmlspecialchars($e->getMessage()).'</p>';
    }
    ?>
</div>
    </section>
    
    <footer class="footer">
      <p>&copy; 2023 Gig Income Tracker</p>
    </footer>
  </div>
</body>
</html>