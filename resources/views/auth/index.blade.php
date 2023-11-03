@extends('../plantillas/layout')
@section('body_content')
    <div class="formulario login">
        <form id="login-form" method="post">
            <h2>Inicio de sesión</h2>
            <div class="username">
                <input id="userLogin" type="text" required>
                <label>Email</label>
            </div>
            <div class="username">
                <input id="contraLogin" type="password" required>
                <label>Contraseña</label>
            </div>
            <input id="botonLoguearme" type="submit" value="login">
            <div class="registro">
                Quiero <a href="#" class="botonRegistro">registrarme</a>
            </div>
        </form>
    </div>
    <div class="formulario registrar">
        <form id="register-form" method="post">
            <h2>Registro</h2>
            <div class="username">
                <input id="userRegister" type="text" required>
                <label>Email</label>
            </div>
            <div class="username">
                <input id= "apodoRegister" type="text" required>
                <label>Apodo</label>
            </div>
            <div class="username">
                <input id= "passwordRegister" type="password" required>
                <label>Contraseña</label>
            </div>
            <input id="botonRegistrar" type="submit" value="register">
            <div class="registro">
                Quiero <a href="#" class="botonLogin">loguearme</a>
            </div>
        </form>
    </div>
@endsection

