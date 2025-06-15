<?php 
$page_title = "Home";
include 'includes/header.php'; 
?>

<div class="hero">
    <h1>Take Control of Your Finances</h1>
    <p>Track your income, expenses, and savings with our intuitive finance management tool. Get insights into your spending habits and achieve your financial goals.</p>
    <div class="actions">
        <a href="signup.php" class="btn"><i class="fas fa-user-plus btn-icon"></i>Get Started</a>
        <a href="login.php" class="btn btn-outline"><i class="fas fa-sign-in-alt btn-icon"></i>Login</a>
    </div>
</div>

<div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
        <div class="card">
            <h3><i class="fas fa-chart-line" style="color: var(--primary-color); margin-right: 10px;"></i>Track Expenses</h3>
            <p>Monitor your spending across different categories and get detailed reports on where your money goes.</p>
        </div>
        <div class="card">
            <h3><i class="fas fa-piggy-bank" style="color: var(--primary-color); margin-right: 10px;"></i>Save Money</h3>
            <p>Identify spending patterns and find opportunities to save more money each month.</p>
        </div>
        <div class="card">
            <h3><i class="fas fa-chart-pie" style="color: var(--primary-color); margin-right: 10px;"></i>Visual Reports</h3>
            <p>Beautiful charts and graphs help you understand your finances at a glance.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>