<?php
require_once 'includes/auth.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    if(login_user($email, $password)) {
        header("location: dashboard.php");
        exit;
    } else {
        $login_err = "Invalid email or password.";
    }
}

$page_title = "Login";
include 'includes/header.php'; 
?>

<div class="auth-container">
    <h2><i class="fas fa-sign-in-alt" style="margin-right: 10px;"></i>Login to Your Account</h2>
    
    <?php if(!empty($login_err)): ?>
        <div class="error"><?php echo $login_err; ?></div>
    <?php endif; ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label><i class="fas fa-envelope" style="margin-right: 8px;"></i>Email Address</label>
            <input type="email" name="email" required placeholder="Enter your email">
        </div>
        <div class="form-group">
            <label><i class="fas fa-lock" style="margin-right: 8px;"></i>Password</label>
            <input type="password" name="password" required placeholder="Enter your password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn"><i class="fas fa-sign-in-alt btn-icon"></i>Login</button>
        </div>
    </form>
    
    <div class="auth-options">
        <a href="signup.php">Create an account</a>
        <span style="margin: 0 10px;">•</span>
        <a href="#">Forgot password?</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>