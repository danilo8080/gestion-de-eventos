document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector(".login");
    const registerForm = document.querySelector(".registrar");
    const showRegisterLink = document.querySelector(".botonLogin");
    const showLoginLink = document.querySelector(".botonRegistro");

    showRegisterLink.addEventListener("click", function(e) {
        e.preventDefault();
        loginForm.style.display = "none";
        registerForm.style.display = "block";
    });

    showLoginLink.addEventListener("click", function(e) {
        e.preventDefault();
        registerForm.style.display = "none";
        loginForm.style.display = "block";
    });
});
