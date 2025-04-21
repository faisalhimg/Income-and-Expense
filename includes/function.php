<?php
require_once "dbh.inc.php";

function getRecentTransact(object $pdo, int $user_id): array {
    $sql = "
        SELECT 
            CategoryName, Type, Amount, Date
        FROM (
            SELECT 
                ic.CategoryName,
                'Income' AS Type,
                i.date AS Date,
                (i.qst + i.hst + i.amount) AS Amount
            FROM income i
            JOIN incomecategory ic ON i.incomeCategoryID = ic.incomeCategoryID
            WHERE i.userID = :user_id

            UNION

            SELECT 
                ec.CategoryName,
                'Expense' AS Type,
                e.date AS Date,
                e.amount AS Amount
            FROM expense e
            JOIN expensecategory ec ON e.expenseCategoryID = ec.expenseCategoryID
            WHERE e.userID = :user_id
        ) AS combined
        ORDER BY Date DESC
        LIMIT 50
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function totalIncome(object $pdo, int $user_id): array{
    $sql= "SELECT  
    'income' AS record_type,
    DATE_FORMAT(CURDATE(), '%Y-%m') AS current_month,
    SUM(amount) AS total_income
FROM income
WHERE 
    userID = :user_id
    AND YEAR(date) = YEAR(CURDATE()) 
    AND MONTH(date) = MONTH(CURDATE());
";
$stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function totalExpense(object $pdo, int $user_id): array{
    $sql= "SELECT  
    'expense' AS record_type,
    DATE_FORMAT(CURDATE(), '%Y-%m') AS current_month,
    SUM(amount) AS total_expense
FROM expense
WHERE 
    userID = :user_id
    AND YEAR(date) = YEAR(CURDATE()) 
    AND MONTH(date) = MONTH(CURDATE());
";
$stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function totalTax(object $pdo, int $user_id): array{
    $sql= "SELECT  
    'QST',
    'HST',
    DATE_FORMAT(CURDATE(), '%Y-%m') AS current_month,
    SUM(qst+hst) AS total_tax
FROM income
WHERE 
    userID = :user_id
    AND YEAR(date) = YEAR(CURDATE()) 
    AND MONTH(date) = MONTH(CURDATE());
";
$stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



function getAllTransactions($pdo, $user_id, $month = null) {
    $query = "
        SELECT t.Date, t.Type, c.CategoryName, t.Amount, t.GST, t.HST, t.Note
        FROM transactions t
        JOIN categories c ON t.CategoryID = c.CategoryID
        WHERE t.UserID = :user_id
    ";

    if ($month) {
        $query .= " AND DATE_FORMAT(t.Date, '%Y-%m') = :month";
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    if ($month) {
        $stmt->bindValue(':month', $month, PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getYearlyIncomeByCategory($pdo, $user_id) {
    $year = date('Y'); // Always use current year
    
    $stmt = $pdo->prepare("
        SELECT incomecategory.categoryName, SUM(amount) AS total
        FROM Income
        JOIN Incomecategory ON income.incomeCategoryID = Incomecategory.incomeCategoryID
        WHERE userID = ? AND YEAR(Date) = ?
        GROUP BY income.incomeCategoryID, incomecategory.categoryName
    ");
    $stmt->execute([$user_id, $year]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getYearlyExpenseByCategory($pdo, $user_id) {
    $year = date('Y');
    
    $stmt = $pdo->prepare("
        SELECT expensecategory.categoryName, SUM(amount) AS total
        FROM expense
        JOIN expensecategory ON expense.expenseCategoryID = expensecategory.expenseCategoryID
        WHERE userID = ? AND YEAR(Date) = ?
        GROUP BY expense.expenseCategoryID, expensecategory.categoryName
    ");
    $stmt->execute([$user_id, $year]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



