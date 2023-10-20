$(document).ready(function (){
    fetchUsers();

    function fetchUsers()
    {
        $.ajax({
            type: "GET",
            url: "http://127.0.0.1:8000/api/v1/Usuario",
            dataType: "json",
            success: function(response){
                console.log(response);
                $('.tbodyUsers').html("");
                $.each(response, function(key, item){
                    $('.tbodyUsers').append('<tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.email+'</td>\
                        <td>'+item.nombre+'</td>\
                        <td>'+item.apodo+'</td>\
                    </tr>'
                    );

                });
            }
        });
    }

    const loginForm = document.querySelector(".login");
    const registerForm = document.querySelector(".registrar");
    const showRegisterLink = document.querySelector(".botonRegistro");
    const showLoginLink = document.querySelector(".botonLogin");

    const loginData = {
        username: null,
        password: null
    };

    const registerData = {
        username: null,
        apodo:null,
        password: null
    };

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const userLogin = document.getElementById("userLogin").value;
        const contraLogin = document.getElementById("contraLogin").value;

        loginData.username = userLogin;
        loginData.password = contraLogin;
        console.log(loginData);

        //código de inicio de sesión
    });

    registerForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const userRegister = document.getElementById("userRegister").value;
        const apodoRegister = document.getElementById("apodoRegister").value;
        const passwordRegister = document.getElementById("passwordRegister").value;

        registerData.username = userRegister;
        registerData.apodo = apodoRegister;
        registerData.password = passwordRegister;
        $.ajax({
            url: "http://127.0.0.1:8000/api/v1/Usuario",
            method: "POST",
            data: {
              email: userRegister,
              apodo: apodoRegister,
              password: passwordRegister
            },
            success: function(data) {
              fetchUsers();
              alert("usuario agregado");
            }
          });
          fetchUsers();
        console.log(registerData);
        //código de registro
    });
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

// document.addEventListener("DOMContentLoaded", function() {
//     const loginForm = document.querySelector(".login");
//     const registerForm = document.querySelector(".registrar");
//     const showRegisterLink = document.querySelector(".botonRegistro");
//     const showLoginLink = document.querySelector(".botonLogin");

//     const loginData = {
//         username: null,
//         password: null
//     };

//     const registerData = {
//         username: null,
//         apodo:null,
//         password: null
//     };

//     loginForm.addEventListener("submit", function(e) {
//         e.preventDefault();

//         const userLogin = document.getElementById("userLogin").value;
//         const contraLogin = document.getElementById("contraLogin").value;

//         loginData.username = userLogin;
//         loginData.password = contraLogin;
//         console.log(loginData);

//         //código de inicio de sesión
//     });

//     registerForm.addEventListener("submit", function(e) {
//         e.preventDefault();

//         const userRegister = document.getElementById("userRegister").value;
//         const apodoRegister = document.getElementById("apodoRegister").value;
//         const passwordRegister = document.getElementById("passwordRegister").value;

//         registerData.username = userRegister;
//         registerData.apodo = apodoRegister;
//         registerData.password = passwordRegister;
//         $.ajax({
//             url: "http://127.0.0.1:8000/api/v1/Usuario",
//             method: "POST",
//             data: {
//               email: userRegister,
//               apodo: apodoRegister,
//               password: passwordRegister
//             },
//             success: function(data) {
//               alert("usuario agregado");
//               fetchUsers();
//             }
//           });
//         console.log(registerData);
//         //código de registro
//     });
//     showRegisterLink.addEventListener("click", function(e) {
//         e.preventDefault();
//         loginForm.style.display = "none";
//         registerForm.style.display = "block";
//     });

//     showLoginLink.addEventListener("click", function(e) {
//         e.preventDefault();
//         registerForm.style.display = "none";
//         loginForm.style.display = "block";
//     });

// });



