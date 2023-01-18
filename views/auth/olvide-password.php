<h1 class="nombre-pagina">Olvide Contraseña</h1>
<p class="descripcion-pagina"> Inserta tu correo para recuperar tu contraseña</p>


<?php require __DIR__ . '/../templates/alertas.php'; ?>
<form class="formulario" method="POST" action="/olvide">
    <label>Ingresa Tu E-mail</label>
    <input class="input" type="email" name="email" placeholder="Tu Correo">
    <input class="btn btn_formulario" type="submit" value="Enviame Un Correo">
</form>