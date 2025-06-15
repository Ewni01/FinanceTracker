<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker | <?php echo $page_title ?? 'Dashboard'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="assets/images/logo.png" alt="Finance Tracker Logo">
                <span>Finance Tracker</span>
            </div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <nav>
                    <a href="dashboard.php"><i class="fas fa-tachometer-alt btn-icon"></i>Dashboard</a>
                    <a href="add-expense.php"><i class="fas fa-plus-circle btn-icon"></i>Add Expense</a>
                    <a href="manage-expenses.php"><i class="fas fa-list-ul btn-icon"></i>Manage Expenses</a>
                    <a href="add-lending.php"><i class="fas fa-hand-holding-usd btn-icon"></i>Lendings</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt btn-icon"></i>Logout</a>
                </nav>
            <?php endif; ?>
        </div>
    </header>