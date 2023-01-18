<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Crea una cuenta en barbershop</p>


<?php require __DIR__ . '/../templates/alertas.php'; ?>
<form class="formulario formulario-registro" method="POST" action="/crear-cuenta">

    <label>Nombre</label>
    <input class="input" type="text" placeholder="Tu Nombre" name="nombre" value="<?php echo s($usuarios->nombre) ?>">
    <label>Apellido</label>
    <input class="input" type="text" placeholder="Tu Apellido" name="apellido" value="<?php echo s($usuarios->apellido) ?>">
    <label>Telefono</label>
    <input class="input" type="tel" placeholder="Tu Telefono" name="telefono" value="<?php echo s($usuarios->telefono) ?>">
    <label>Email</label>
    <input class="input" type="email" placeholder="Tu Email" name="email" value=" <?php echo s($usuarios->email) ?>">
    <label for="">Password</label>
    <input class="input" type="password" placeholder="Tu Password" name="password">
    <input class="btn btn_formulario" type="submit" value="Registarse">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? </a>
    <a href="/olvide"> ¿Olvidates tu contraseña? </a>
</div>