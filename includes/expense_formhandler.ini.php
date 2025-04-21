<?php

// form handler for expense
if($_SERVER["REQUEST_METHOD"]=="POST"){
        $expenseDate = $_POST["expenseDate"];
        $expenseAmount = $_POST["expenseAmount"];
        $expenseNote = $_POST["expenseNote"];
        $expenseCategory = $_POST["expenseCategory"];
        $userID = $_SESSION["user_id"];
        $receipt = $_POST["receipt"];


        //check if important fields are field

        if(empty($expenseCategory) || empty($expenseAmount) || empty($expenseDate)){
            die("Expense Category, Amount and Date can't be empty please complete the form");
        }

        try {
            require_once "dbh.inc.php"; //Initiating connection to database
            require_once 'config_session.inc.php';

            $query = "INSERT INTO expense(date, amount, note, expenseCategoryID, userID, receipt) 
            values (:expenseDate, :expenseAmount, :expenseNote, :expenseCategory, :userID, :receipt)";

            $stmt = $pdo->prepare($query);

            $userID = $_SESSION["user_id"]; // static default user

            $stmt->bindParam(":expenseDate", $expenseDate);
            $stmt->bindParam(":expenseAmount", $expenseAmount);
            $stmt->bindParam(":expenseNote", $expenseNote);
            $stmt->bindParam(":expenseCategory", $expenseCategory);
            $stmt->bindParam(":userID", $userID);
            $stmt->bindParam(":receipt", $receipt);

            /*$stmt->execute();
            echo("expense record successfully recorded!");
            header("location: ../home.php");*/
            if ($stmt->execute()) {
                echo "<script>
                alert('Expense inserted successfully!'); location.href='../dashboard.php';</script>";
            }



        } catch (PDOException $e) {
            die("Query failed" . $e-> getMessage());
        
        }
        
    } else {
        die("location:../dashboad.php");
        die();

        
}