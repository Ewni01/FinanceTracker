<?php
require_once 'includes/config.php';
require_login();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = trim($_POST["amount"]);
    $person = trim($_POST["person"]);
    $description = trim($_POST["description"]);
    $date = trim($_POST["date"]);
    
    $sql = "INSERT INTO lendings (user_id, amount, person, description, date) VALUES (:user_id, :amount, :person, :description, :date)";
    
    if($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":person", $person, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":date", $date, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            header("location: dashboard.php");
            exit;
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Add Lending</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" required>
        </div>
        <div class="form-group">
            <label>Person</label>
            <input type="text" name="person" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" required value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="form-group">
            <input type="submit" value="Add Lending">
            <a href="dashboard.php" class="btn">Cancel</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?>