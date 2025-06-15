<?php
require_once 'includes/config.php';
require_login();

// Fetch expenses summary
$expenses_summary = [];
$sql = "SELECT category, SUM(amount) as total FROM expenses WHERE user_id = :user_id GROUP BY category";
if($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $expenses_summary = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Calculate total expenses
$total_expenses = array_sum(array_column($expenses_summary, 'total'));

// Fetch recent expenses
$recent_expenses = [];
$sql = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC LIMIT 5";
if($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $recent_expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$page_title = "Dashboard";
include 'includes/header.php'; 
?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container">
    <h2><i class="fas fa-tachometer-alt" style="margin-right: 10px;"></i>Dashboard</h2>
    <p>Welcome back, <?php echo $_SESSION['username']; ?>! Here's your financial overview.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
        <div class="card" style="background: linear-gradient(135deg, #4361ee, #3f37c9); color: white;">
            <h3>Total Expenses</h3>
            <p style="font-size: 2rem; font-weight: bold;">$<?php echo number_format($total_expenses, 2); ?></p>
            <p><i class="fas fa-calendar-week"></i> All time</p>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #4cc9f0, #4895ef); color: white;">
            <h3>Categories</h3>
            <p style="font-size: 2rem; font-weight: bold;"><?php echo count($expenses_summary); ?></p>
            <p><i class="fas fa-tags"></i> Spending categories</p>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #f72585, #b5179e); color: white;">
            <h3>Recent Transactions</h3>
            <p style="font-size: 2rem; font-weight: bold;"><?php echo count($recent_expenses); ?></p>
            <p><i class="fas fa-exchange-alt"></i> Last 5 expenses</p>
        </div>
    </div>
    
    <div class="card">
        <h3><i class="fas fa-chart-pie" style="margin-right: 10px;"></i>Expenses by Category</h3>
        <?php if (!empty($expenses_summary)): ?>
            <div class="chart-container" style="position: relative; height: 300px;">
                <canvas id="expensesChart"></canvas>
            </div>
        <?php else: ?>
            <p>No expenses recorded yet to display chart.</p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <h3><i class="fas fa-history" style="margin-right: 10px;"></i>Recent Expenses</h3>
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recent_expenses as $expense): ?>
                <tr>
                    <td style="color: var(--danger-color); font-weight: bold;">-$<?php echo number_format($expense['amount'], 2); ?></td>
                    <td><span style="background-color: #e0e0e0; padding: 0.3rem 0.6rem; border-radius: 20px; font-size: 0.8rem;"><?php echo $expense['category']; ?></span></td>
                    <td><?php echo $expense['description'] ?: '--'; ?></td>
                    <td><?php echo date('M j, Y', strtotime($expense['date'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="actions">
        <a href="add-expense.php" class="btn"><i class="fas fa-plus-circle btn-icon"></i>Add Expense</a>
        <a href="manage-expenses.php" class="btn"><i class="fas fa-list-ul btn-icon"></i>Manage Expenses</a>
        <a href="add-lending.php" class="btn"><i class="fas fa-hand-holding-usd btn-icon"></i>Add Lending</a>
    </div>
</div>

<?php if (!empty($expenses_summary)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('expensesChart').getContext('2d');
    const expensesChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_column($expenses_summary, 'category')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_map('floatval', array_column($expenses_summary, 'total'))); ?>,
                backgroundColor: [
                    '#4361ee', '#3f37c9', '#4cc9f0', '#4895ef',
                    '#f72585', '#b5179e', '#7209b7', '#560bad'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = Math.round((value / total) * 100);
                            return `${label}: $${value.toFixed(2)} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>