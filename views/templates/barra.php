<div class="barra">
    <p>Hola: <?php echo $nombre ?? '' ?> </p>

    <a href="/logout" class="btn">Cerrar Sesión</a>
</div>

<?php

if ($_SESSION["admin"]) { ?>
    <div class="barra-servicio">

        <a class="btn btn_servicio" href="/admin/citas"> Ver Citas </a>
        <a class="btn btn_servicio" href="/admin/servicios"> Ver Servicios </a>
        <a class="btn btn_servicio " href="/servicios/create">Nuevo Servicio</a>
    </div>
<?php } ?>