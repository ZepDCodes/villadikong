const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    function showRegister() {
      loginForm.classList.remove("active");
      registerForm.classList.add("active");
    }
    
    function showLogin() {
      registerForm.classList.remove("active");
      loginForm.classList.add("active");
    }

    function showLogin() {
    document.getElementById('loginForm').classList.add('active');
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('forgotForm').classList.remove('active');
    document.getElementById('resetForm').classList.remove('active');
}

function showRegister() {
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.add('active');
    document.getElementById('forgotForm').classList.remove('active');
    document.getElementById('resetForm').classList.remove('active');
}

function showForgot() {
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('forgotForm').classList.add('active');
    document.getElementById('resetForm').classList.remove('active');
}

// Auto-show reset form if token is in URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('reset_token')) {
        showResetForm();
    }
});

function showResetForm() {
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('forgotForm').classList.remove('active');
    document.getElementById('resetForm').classList.add('active');
}