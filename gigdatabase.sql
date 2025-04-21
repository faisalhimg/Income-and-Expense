-- Cretae table for `users`--
CREATE TABLE `users` (
  `userID` int NOT NULL,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` text NOT NULL,
);

-- Insert data for table `users`--
INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `password`, `created_at`, `username`) VALUES 
(1, 'Admin', 'Tester', 'admintest@gmail.com', '12345678', '2025-04-18 16:35:43', 'admin');

-- Cretae table for `income`--
CREATE TABLE income(
incomeID int auto_increment NOT NULL,
date date NOT NULL,
amount decimal(10,2) NOT NULL,
note text,
incomeCategoryID int NOT NULL,
userID int NOT NULL,
primary key (incomeID),
CONSTRAINT fk_incomeCategory FOREIGN KEY (incomeCategoryID)
        REFERENCES incomecategory(incomeCategoryID) ON DELETE CASCADE,
    CONSTRAINT fk_user FOREIGN KEY (userID)
        REFERENCES users(userID) ON DELETE CASCADE
);

-- Insert data for table `income`--
INSERT INTO `income` (`incomeID`, `date`, `amount`, `note`, `incomeCategoryID`, `userID`, `payslip`, `qst`, `hst`) VALUES
(2, '2025-03-22', 95.00, '', 1, 1, '', 20, 10),

-- Cretae table for `expense`--
CREATE TABLE expense (
    expenseID INT AUTO_INCREMENT NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    note TEXT,
    expenseCategoryID INT NOT NULL,
    userID INT NOT NULL,
    PRIMARY KEY (expenseID),
    CONSTRAINT fk_expenseCategory FOREIGN KEY (expenseCategoryID)
        REFERENCES expensecategory(expenseCategoryID) ON DELETE CASCADE,
    CONSTRAINT fk_expense_user FOREIGN KEY (userID)
        REFERENCES users(userID) ON DELETE CASCADE
);


-- Cretae table for `expensecategory`--
  CREATE TABLE `expensecategory` (
  `expenseCategoryID` int NOT NULL,
  `categoryName` varchar(225) DEFAULT NULL
  );

-- Insert into table for `expensecategory`--
INSERT INTO expensecategory (categoryName)
values
('Fuel costs'),
('Oil'),
('Motor Vehicle expenses'),
('Insurance'),
('Rent'),
('Maintenance and repairs'),
('Telephone'),
('Meals and Entertainment'),
('Bad debts'),
('Business Tax. Fees, licenses, dues, membership'),
('Other expenses');

  -- Creare Table for table `incomecategory`--
CREATE TABLE `incomecategory` (
  `incomeCategoryID` int NOT NULL,
  `categoryName` varchar(225) DEFAULT NULL
)

  -- Insert into table for `incomecategory`--
INSERT INTO `incomecategory` (`incomeCategoryID`, `categoryName`) VALUES
(1, 'Uber'),
(2, 'Instacart'),
(3, 'DoorDash'),
(4, 'Skip The Dishes'),
(5, 'Other');