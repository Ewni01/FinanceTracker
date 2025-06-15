<?php
require_once 'includes/config.php';
require_login();

// Check if expense ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: manage-expenses.php");
    exit;
}

// Fetch expense data
$expense = null;
$sql = "SELECT * FROM expenses WHERE id = :id AND user_id = :user_id";
if($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
    if($stmt->execute()) {
        if($stmt->rowCount() == 1) {
            $expense = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            header("location: manage-expenses.php");
            exit;
        }
    }
}

// Process form data when submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = trim($_POST["amount"]);
    $category = trim($_POST["category"]);
    $description = trim($_POST["description"]);
    $date = trim($_POST["date"]);
    
    $sql = "UPDATE expenses SET amount = :amount, category = :category, description = :description, date = :date WHERE id = :id AND user_id = :user_id";
    
    if($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":category", $category, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        
        if($stmt->execute()) {
            header("location: manage-expenses.php?success=Expense+updated+successfully");
            exit;
        }
    }
}

$page_title = "Edit Expense";
include 'includes/header.php'; 
?>

<div class="container">
    <h2><i class="fas fa-edit" style="margin-right: 10px;"></i>Edit Expense</h2>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $_GET['id']; ?>" method="post">
        <div class="form-group">
            <label><i class="fas fa-dollar-sign" style="margin-right: 8px;"></i>Amount</label>
            <input type="number" step="0.01" name="amount" required value="<?php echo $expense['amount']; ?>">
        </div>
        <div class="form-group">
            <label><i class="fas fa-tag" style="margin-right: 8px;"></i>Category</label>
            <select name="category" required>
                <option value="Food" <?php echo $expense['category'] == 'Food' ? 'selected' : ''; ?>>Food</option>
                <option value="Transport" <?php echo $expense['category'] == 'Transport' ? 'selected' : ''; ?>>Transport</option>
                <option value="Entertainment" <?php echo $expense['category'] == 'Entertainment' ? 'selected' : ''; ?>>Entertainment</option>
                <option value="Utilities" <?php echo $expense['category'] == 'Utilities' ? 'selected' : ''; ?>>Utilities</option>
                <option value="Rent" <?php echo $expense['category'] == 'Rent' ? 'selected' : ''; ?>>Rent</option>
                <option value="Other" <?php echo $expense['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right: 8px;"></i>Description</label>
            <textarea name="description"><?php echo $expense['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label><i class="fas fa-calendar-day" style="margin-right: 8px;"></i>Date</label>
            <input type="date" name="date" required value="<?php echo $expense['date']; ?>">
        </div>
        <div class="form-group">
            <button type="submit" class="btn"><i class="fas fa-save btn-icon"></i>Update Expense</button>
            <a href="manage-expenses.php" class="btn btn-outline"><i class="fas fa-times btn-icon"></i>Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>