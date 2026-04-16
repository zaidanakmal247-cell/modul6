<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Back to site button -->
    <a href="../DASHBOARD/dashboard.html" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 0L6.59 1.41L12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" transform="rotate(180 8 8)"/>
        </svg>
        Back to site
    </a>

    <div class="container">
        <!-- Logo -->
        <div class="logo">
            
            <p class="tagline">SMART Educations</p>
            <p class="subtitle">LAYANAN PENGADUAN LALU LINTAS</p>
        </div>

        <!-- Login Form -->
        <div class="form-container">
            <h2>LOGIN</h2>
            <form id="loginForm" method="post" action="proses_login.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password <a href="forgotpassword.html" class="forgot-link">(Forgot it?)</a></label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary">Log In</button>

                <div class="signup-box">
                    Don't have an account? <a href="register.php">Sign up.</a>
                </div>
            </form>
        </div>
    </div>

    
</body>
</html>