<?php $pageTitle = "Login"; include 'includes/header.php'; ?>
<main class="auth-main">
    <section class="auth-container">
        <div class="form-box">
            <h2>Login</h2>
            <form method="post" action="process_login.php">
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Login</button>
            </form>
            <p style="text-align:center; margin-top:1em;">
                Don’t have an account?
                <a href="register.php" class="cta-button">Register</a>
            </p>
        </div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>
