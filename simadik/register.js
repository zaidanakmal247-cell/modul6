const registerForm = document.getElementById('registerForm');
const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password-new');
const confirmInput = document.getElementById('password-confirm');
const anonymousCheckbox = document.getElementById('anonymous');
const btnMale = document.getElementById('btnMale');
const btnFemale = document.getElementById('btnFemale');

let selectedGender = '';

// GENDER SELECTION
btnMale.addEventListener('click', function() {
    btnMale.classList.add('active');
    btnFemale.classList.remove('active');
    selectedGender = 'Laki-Laki';
    document.getElementById('genderInput').value = 'Laki-Laki';
});

btnFemale.addEventListener('click', function() {
    btnFemale.classList.add('active');
    btnMale.classList.remove('active');
    selectedGender = 'Perempuan';
    document.getElementById('genderInput').value = 'Perempuan';
});

// PASSWORD STRENGTH CHECKER
passwordInput.addEventListener('input', function() {
    const password = this.value;
    const strengthContainer = document.querySelector('.password-strength');
    const strengthBarFill = document.getElementById('strengthBarFill');
    const strengthText = document.getElementById('strengthText');

    if (password.length === 0) {
        strengthContainer.classList.remove('show');
        return;
    }

    strengthContainer.classList.add('show');

    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    strengthBarFill.className = 'strength-bar-fill';
    let strengthLabel = '';
    if (strength <= 2) {
        strengthBarFill.classList.add('weak');
        strengthLabel = 'Lemah';
    } else if (strength <= 4) {
        strengthBarFill.classList.add('medium');
        strengthLabel = 'Sedang';
    } else {
        strengthBarFill.classList.add('strong');
        strengthLabel = 'Kuat';
    }
    strengthText.textContent = 'Kekuatan Password: ' + strengthLabel;
});

// REAL-TIME VALIDATION
usernameInput.addEventListener('blur', function() {
    validateUsername(this.value);
});

emailInput.addEventListener('blur', function() {
    validateEmailField(this.value);
});

confirmInput.addEventListener('input', function() {
    if (this.value.length > 0) {
        validatePasswordMatch();
    }
});

// VALIDATION FUNCTIONS
function validateUsername(username) {
    const usernameGroup = document.getElementById('usernameGroup');
    if (username.trim().length < 3) {
        usernameGroup.querySelector('.error-message').textContent = 'Username minimal 3 karakter';
        usernameGroup.classList.add('error');
        return false;
    }
    usernameGroup.classList.remove('error');
    return true;
}

function validateEmailField(email) {
    const emailGroup = document.getElementById('emailGroup');
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!re.test(email)) {
        emailGroup.querySelector('.error-message').textContent = 'Format email tidak valid';
        emailGroup.classList.add('error');
        return false;
    }
    emailGroup.classList.remove('error');
    return true;
}

function validatePassword(password) {
    const passwordGroup = document.getElementById('passwordGroup');
    if (password.length < 6) {
        passwordGroup.classList.add('error');
        return false;
    }
    passwordGroup.classList.remove('error');
    return true;
}

function validatePasswordMatch() {
    const confirmGroup = document.getElementById('confirmGroup');
    if (passwordInput.value !== confirmInput.value) {
        confirmGroup.classList.add('error');
        return false;
    }
    confirmGroup.classList.remove('error');
    return true;
}

// FORM SUBMISSION
registerForm.addEventListener('submit', function(e) {
    const username = usernameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value;
    const confirmPassword = confirmInput.value;

    let isValid = true;

    document.querySelectorAll('.form-group').forEach(group => {
        group.classList.remove('error');
    });

    if (!username || !validateUsername(username)) {
        isValid = false;
    }
    if (!email || !validateEmailField(email)) {
        isValid = false;
    }
    if (!password || !validatePassword(password)) {
        isValid = false;
    }
    if (!confirmPassword || !validatePasswordMatch()) {
        isValid = false;
    }
    if (!selectedGender) {
        alert('Silakan pilih jenis kelamin!');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
});

confirmInput.addEventListener('paste', function(e) {
    e.preventDefault();
    alert('Copy-paste tidak diizinkan untuk konfirmasi password.');
});