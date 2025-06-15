<?php
require_once 'includes/auth.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    if(register_user($username, $email, $password)) {
        header("location: login.php");
        exit;
    } else {
        $register_err = "Registration failed. Please try again.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container">
    <h2>Sign Up</h2>
    <?php if(!empty($register_err)) echo '<div class="error">'.$register_err.'</div>'; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
<?php include 'includes/footer.php'; ?>