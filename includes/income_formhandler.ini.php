<?php


// form handler for income

if($_SERVER["REQUEST_METHOD"] =="POST"){
    $incomeDate = $_POST["incomeDate"];
    $incomeAmount = $_POST["incomeAmount"];
    $IncomeNote = $_POST["IncomeNote"];
    $incomeCategory = $_POST["incomeCategory"];
    $userID = $_SESSION["user_id"];
    $payslipFile = $_POST["payslipFile"];
    $qstAmount = $_POST["gstAmount"];
    $hstAmount = $_POST["hstAmount"];
   
  

    //Check if important fields are filled...
    if (empty($incomeCategory) || empty($incomeAmount) || empty($incomeDate)){
        die("Income Category, Amount and Date can't be empty");
    }

    try {
        require_once "dbh.inc.php"; //Connecting to database...
        require_once 'config_session.inc.php';
       

        $query = "INSERT INTO income (date, amount, note, incomeCategoryID, userID, payslip, qst, hst) 
          VALUES (:incomeDate, :incomeAmount, :note, :incomeCategory, :userID, :payslipFile, :qst, :hst)";

$stmt = $pdo->prepare($query);

$userID = $_SESSION["user_id"]; // Static userID, adjust if necessary

$stmt->bindParam(":incomeDate", $incomeDate);
$stmt->bindParam(":incomeAmount", $incomeAmount);
$stmt->bindParam(":note", $IncomeNote);
$stmt->bindParam(":incomeCategory", $incomeCategory);
$stmt->bindParam(":userID", $userID);
$stmt->bindParam(":payslipFile", $payslipFile);
$stmt->bindParam(":qst", $qstAmount);
$stmt->bindParam(":hst", $hstAmount);

if ($stmt->execute()) {
    echo "<script>
    alert('Income inserted successfully!'); location.href='../dashboard.php';</script>";
} else {
    echo "<script>
    alert('Error: " . addslashes($stmt->error) . "');
    </script>";
}



    } catch (PDOException $e) {
        die("Query failed" . $e-> getMessage());
    }

}
else {
    header("Location: ../home.php");
    die();
}
