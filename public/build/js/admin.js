window.addEventListener("DOMContentLoaded", function (e) {
    iniciarApp();
});

function iniciarApp() {
    const inputDate = document.querySelector(".busqDate");
    const fecha = new Date();

    let dia = fecha.getDate();
    let anio = fecha.getFullYear();
    let mes = fecha.getMonth() + 1;
    let fechaCompleta = `${anio}-${mes}-${dia}`;

    getReservaciones(fechaCompleta);


    inputDate.addEventListener("change", function (e) {
        getReservaciones(inputDate.value);
    });


}




/*OBTENEMOS LAS RESERVACIONES DEL SERVIDOR MEDIANTE UN JSON */
async function getReservaciones(fecha) {

    const datos = new FormData();
    datos.append("fecha", fecha);

    const url = "http://localhost:3000/api/reservaciones";
    const consulta = await fetch(url, {
        method: 'POST',
        body: datos
    });
    const resultado = await consulta.json();
    console.log(resultado)
    mostrarReservaciones(resultado);

}



/*PINTAMOS LAS RESERVACIONES EN PANTALLA */
function mostrarReservaciones(reservaciones) {
    console.log(reservaciones)
    const DIVResultados = document.querySelector(".listado-servicios");

    DIVResultados.innerHTML = "";
    reservaciones.forEach(reserva => {
        const { id, fecha, hora, fk_usuario, producto, precio } = reserva;
        console.log(producto)
        arrayP = producto.split(',');

        const dateOne = new Date(fecha);
        const dia = dateOne.getDate() + 1;
        const anio = dateOne.getFullYear();
        const mes = dateOne.getMonth() + 1;
        let fechaNormal = `${anio}, ${mes}, ${dia}`;
        /*MEJORAMOS LA FECHA PARA QUE SE VEA CON EL DIA Y EN ESPAÑOL */
        const diaNormal = new Date(fechaNormal).toLocaleDateString("es-CO", { weekday: 'long', month: 'long', day: 'numeric' });


        let divReserva = document.createElement("DIV");

        let listaServicios = document.createElement("ul");
        listaServicios.classList.add('lista')
        let parrafoFecha = document.createElement("P");
        let parrafoHora = document.createElement("P");
        let parrafoCliente = document.createElement("P");
        let parrafoPrecio = document.createElement("P");

        let botonEliminar = document.createElement("BUTTON");
        botonEliminar.textContent = "ELIMINAR";
        /*PERMITIMOS QUE EL ADMIN PUEDA ELIMINAR CITAS*/
        botonEliminar.classList.add('btn', 'btn_eliminar');

        botonEliminar.addEventListener('click', function () {
            eliminar(id, fk_usuario);
        });
        parrafoCliente.textContent = 'Cliente: ' + fk_usuario;
        parrafoFecha.textContent = 'Dia: ' + diaNormal;
        parrafoHora.textContent = 'Hora: ' + hora;
        parrafoPrecio.textContent = 'Total ' + precio;

        arrayP.forEach(element => {
            let elementLista = document.createElement("li");
            elementLista.textContent = element;
            listaServicios.appendChild(elementLista);
        });

        divReserva.appendChild(parrafoCliente);
        divReserva.appendChild(parrafoFecha);
        divReserva.appendChild(parrafoHora);
        divReserva.appendChild(listaServicios);
        divReserva.appendChild(parrafoPrecio);
        divReserva.appendChild(botonEliminar);
        DIVResultados.appendChild(divReserva);

    });
}


/*CUANDO EL USUARIO DE CLICK EN ELIMINAR SE ELIMINARÁ LA CITA */
async function eliminar(id, usuario) {
    datos = new FormData();
    datos.append('id', id);

    let consulta = await fetch('http://localhost:3000/citas/delete', {
        method: 'POST',
        body: datos
    })
    let response = await consulta.text();
    Swal.fire(
        'Cita Eliminada ',
        `Se elimino la cita de  ${usuario} correctamente!`,
        'info'
    ).then(function () {
        location.reload();
    });

}