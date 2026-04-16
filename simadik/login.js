// Get registered users from localStorage (not used in demo mode)
function getRegisteredUsers() {
    const users = localStorage.getItem('registeredUsers');
    return users ? JSON.parse(users) : [];
}

// =============================================
// DUMMY/DEMO ACCOUNTS
// =============================================

// Dummy admin account
const adminAccount = {
    email: 'admin@simadik.id',
    password: 'admin123',
    role: 'admin',
    name: 'Admin Dinas'
};

// Dummy user accounts (untuk login ke dashboard user)
const demoUserAccounts = [
    {
        email: 'user@demo.com',
        password: 'user123',
        role: 'user',
        username: 'Demo User',
        gender: 'Laki-laki',
        isAnonymous: false
    },
    {
        email: 'siswa@demo.com',
        password: 'siswa123',
        role: 'user',
        username: 'Siswa Demo',
        gender: 'Perempuan',
        isAnonymous: false
    },
    {
        email: 'orangtua@demo.com',
        password: 'ortu123',
        role: 'user',
        username: 'Orang Tua Demo',
        gender: 'Laki-laki',
        isAnonymous: false
    }
];

// =============================================
// EMAIL VALIDATION
// =============================================
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// =============================================
// LOGIN FORM HANDLER
// =============================================
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        // Basic validation
        if (!email || !password) {
            alert('Harap isi semua field!');
            return;
        }
        
        // Email validation
        if (!validateEmail(email)) {
            alert('Format email tidak valid!');
            return;
        }
        
        // Check if admin
        if (email === adminAccount.email && password === adminAccount.password) {
            // Login as admin
            sessionStorage.setItem('currentUser', JSON.stringify({
                email: adminAccount.email,
                role: adminAccount.role,
                name: adminAccount.name,
                username: 'Admin'
            }));
            
            alert('Login berhasil!\nSelamat datang, ' + adminAccount.name);
            window.location.href = '../dashboard-admin/dashboard-admin.html';
            return;
        }
        
        // Check demo user accounts
        const demoUser = demoUserAccounts.find(u => u.email === email && u.password === password);
        
        if (demoUser) {
            // Login as demo user
            sessionStorage.setItem('currentUser', JSON.stringify({
                email: demoUser.email,
                role: demoUser.role,
                name: demoUser.username,
                username: demoUser.username,
                gender: demoUser.gender,
                isAnonymous: demoUser.isAnonymous
            }));
            
            alert('Login berhasil!\nSelamat datang, ' + demoUser.username);
            window.location.href = '../DASHBOARD/dashboard.html';
            return;
        }
        
        // Check registered users (if any)
        const registeredUsers = getRegisteredUsers();
        const registeredUser = registeredUsers.find(u => u.email === email && u.password === password);
        
        if (registeredUser) {
            // Login as registered user
            sessionStorage.setItem('currentUser', JSON.stringify({
                email: registeredUser.email,
                role: registeredUser.role,
                name: registeredUser.username,
                username: registeredUser.username,
                gender: registeredUser.gender,
                isAnonymous: registeredUser.isAnonymous
            }));
            
            alert('Login berhasil!\nSelamat datang, ' + registeredUser.username);
            window.location.href = '../DASHBOARD/dashboard.html';
        } else {
            // Login failed
            alert('Email atau password salah!\n\n' +
                  '━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n' +
                  '📌 AKUN DEMO TERSEDIA:\n' +
                  '━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n' +
                  '👤 ADMIN:\n' +
                  '   Email: admin@simadik.id\n' +
                  '   Password: admin123\n\n' +
                  '👥 USER DEMO:\n' +
                  '   1. Email: user@demo.com\n' +
                  '      Password: user123\n\n' +
                  '   2. Email: siswa@demo.com\n' +
                  '      Password: siswa123\n\n' +
                  '   3. Email: orangtua@demo.com\n' +
                  '      Password: ortu123\n' +
                  '━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        }
    });
}


// =============================================
// SHOW DEMO ACCOUNTS INFO (OPTIONAL)
// =============================================
function showDemoAccounts() {
    alert('━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n' +
          '📌 AKUN DEMO TERSEDIA:\n' +
          '━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n' +
          '👤 ADMIN:\n' +
          '   Email: admin@simadik.id\n' +
          '   Password: admin123\n' +
          '   Dashboard: Admin Dashboard\n\n' +
          '👥 USER DEMO:\n' +
          '   1. Demo User\n' +
          '      Email: user@demo.com\n' +
          '      Password: user123\n\n' +
          '   2. Siswa Demo\n' +
          '      Email: siswa@demo.com\n' +
          '      Password: siswa123\n\n' +
          '   3. Orang Tua Demo\n' +
          '      Email: orangtua@demo.com\n' +
          '      Password: ortu123\n' +
          '━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
}

// Optional: Add a button to show demo accounts
// You can call showDemoAccounts() from a button in your HTML