<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina"> Inicia Sesión En Barbershoper</p>


<?php require __DIR__ . '/../templates/alertas.php'; ?>
<form class="formulario" method="post" action="/">

    <label> Email </label>
    <input class="input" type="email" placeholder="Tu Email" name="email" />
    <label>Password</label>
    <input class="input" type="password" placeholder="Tu Contraseña" name="password" />

    <input class=" btn btn_ingresar" type="submit" value="Ingresar">



</form>

<div class="acciones">

    <a href="/crear-cuenta">¿Aún No tienes cuenta? </a>

    <a href="/olvide"> ¿Olvidates tu contraseña? </a>
</div>