const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const registerButton = document.getElementById('register-button');

registerButton.addEventListener('click', () => {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
    console.log("hola");
});

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    // Aquí debes agregar la lógica para verificar las credenciales del usuario.
    // Por ejemplo, puedes comparar los valores ingresados con una lista de usuarios válidos.
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Simulando una comprobación simple
    if (username === 'usuario' && password === 'contraseña') {
        alert('Inicio de sesión exitoso');
    } else {
        alert('Credenciales incorrectas');
    }
});

registerForm.addEventListener('submit', (e) => {
    e.preventDefault();
    // Aquí debes agregar la lógica para registrar al usuario.
    // Puedes guardar los datos en una base de datos, en una lista en memoria, o donde prefieras.
    const newUsername = document.getElementById('new-username').value;
    const newPassword = document.getElementById('new-password').value;

    // Simulando un registro simple
    alert(`Usuario registrado: ${newUsername}`);
});
