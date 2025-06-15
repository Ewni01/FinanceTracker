<?php
require_once 'includes/config.php';
require_login();

// Fetch all expenses
$expenses = [];
$sql = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC";
if($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Delete expense if requested
if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM expenses WHERE id = :id AND user_id = :user_id";
    if($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $delete_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        header("location: manage-expenses.php?success=Expense+deleted+successfully");
        exit;
    }
}

$page_title = "Manage Expenses";
include 'includes/header.php'; 
?>

<div class="container">
    <h2><i class="fas fa-list-ul" style="margin-right: 10px;"></i>Manage Expenses</h2>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    
    <div class="actions" style="margin-bottom: 1.5rem;">
        <a href="add-expense.php" class="btn"><i class="fas fa-plus-circle btn-icon"></i>Add New Expense</a>
        <a href="dashboard.php" class="btn btn-outline"><i class="fas fa-arrow-left btn-icon"></i>Back to Dashboard</a>
    </div>
    
    <?php if(count($expenses) > 0): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($expenses as $expense): ?>
                    <tr>
                        <td><?php echo date('M j, Y', strtotime($expense['date'])); ?></td>
                        <td style="color: var(--danger-color); font-weight: bold;">-$<?php echo number_format($expense['amount'], 2); ?></td>
                        <td><span class="category-badge"><?php echo $expense['category']; ?></span></td>
                        <td><?php echo $expense['description'] ?: '--'; ?></td>
                        <td>
                            <a href="edit-expense.php?id=<?php echo $expense['id']; ?>" class="action-link" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="manage-expenses.php?delete=<?php echo $expense['id']; ?>" class="danger-link" title="Delete" onclick="return confirm('Are you sure you want to delete this expense?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="card" style="text-align: center; padding: 2rem;">
            <i class="fas fa-receipt" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
            <h3>No Expenses Found</h3>
            <p>You haven't recorded any expenses yet. Click the button below to add your first expense.</p>
            <a href="add-expense.php" class="btn"><i class="fas fa-plus-circle btn-icon"></i>Add Expense</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>