<h1 class="nombre-pagina">Panel De Administración</h1>
<?php
require __DIR__ . '/../templates/barra.php';

?>


<h2>Crear Servicio</h2>
<?php require __DIR__ . '/../templates/alertas.php'; ?>
<div class="busqueda">

    <form class="formulario" action="/servicios/create" method="POST">
        <label>Nombre Servicio</label>
        <input type="text" class="input" name="nombre" placeholder="Nombre Del Servicio" value="<?php echo s($servicio->nombre) ?>">
        <label>Precio Servicio</label>
        <input type="text" class="input" name="precio" placeholder="Precio Del Servicio" value="<?php echo s($servicio->precio) ?>">
        <input class="btn btn_formulario" type="submit" value="Crear Servicio">
    </form>
</div>