<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMADIK REGISTER</title>
    <link rel="stylesheet" href="register-style.css">
</head>
<body>
    <a href="index.php" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 0L6.59 1.41L12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" transform="rotate(180 8 8)"/>
        </svg>
        Back to site
    </a>

    <div class="container">
        <div class="form-container">
            <h2>REGISTER</h2>
            <form id="registerForm" method="post" action="proses_register.php">
                <div class="form-group" id="usernameGroup">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" autocomplete="username">
                    <span class="error-message">Username Terpakai</span>
                </div>

                <div class="form-group" id="emailGroup">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" autocomplete="email">
                    <span class="error-message">Email tidak valid</span>
                </div>

                <div class="form-group" id="passwordGroup">
                    <label for="password-new">Password Baru</label>
                    <input type="password" id="password-new" name="password-new" placeholder="Password" autocomplete="new-password">
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strengthBarFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                    <span class="error-message">Password minimal 6 karakter</span>
                </div>

                <div class="form-group" id="confirmGroup">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <input type="password" id="password-confirm" name="password-confirm" placeholder="Password" autocomplete="new-password">
                    <span class="error-message">Password tidak cocok</span>
                </div>

                <input type="hidden" id="genderInput" name="gender" value="">

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" id="btnMale">Laki-Laki</button>
                    <button type="button" class="btn btn-secondary" id="btnFemale">Perempuan</button>
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="anonymous" name="anonymous">
                    <label for="anonymous" class="checkbox-label">
                        <strong>Daftar sebagai Anonim</strong>
                        <span class="checkbox-description">Email Anda akan disembunyikan dari pengguna lain dan hanya dapat dilihat oleh Admin untuk keperluan keamanan dan verifikasi akun.</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">REGISTER</button>
            </form>
        </div>
    </div>
    <script src="register.js"></script>
</body>
</html>