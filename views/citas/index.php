<h1 class="nombre-pagina">Citas</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>


<?php
require __DIR__ . '/../templates/barra.php';
?>


<div id="app">

    <div class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Datos</button>
        <button type="button" data-paso="3">Resumen</button>
    </div>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p>Elige Tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion paso-2">
        <h2>Tus Datos</h2>
        <p class="text-center">Coloca Tus Datos y Fecha</p>

        <form class="formulario">
            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu nombre" class="input" id="nombre" value="<?php echo $nombre ?>" disabled>
            <label for="fecha">Fecha</label>
            <input type="date" class="input" id="fecha" min="<?php echo date('Y-m-d') ?>">

            <label for="hora">Hora</label>
            <input type="time" class="input" id="hora">
        </form>

    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p>Verifique la información</p>

    </div>

    <div class="paginacion">
        <button id="anterior" class="btn btn_paginacion">
            &laquo;Anterior
        </button>
        <button id="siguiente" class="btn btn_paginacion">
            Siguiente&raquo;
        </button>
    </div>
</div>


<template class="template-servicios">
    <div class="servicio" id="">
        <p hidden class="id"></p>
        <p class="nombre-servicio">Corte Hombre </p>
        <p class="precio-servicio">60.000 </p>
    </div>
</template>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../build/js/app.js"> </script>