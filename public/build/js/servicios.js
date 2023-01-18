
window.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    getServicios();
}

async function getServicios() {
    const url = "http://localhost:3000/api/servicios";
    let consulta = await fetch(url);
    let response = await consulta.json();
    mostrarServicios(response);
}


/*MOSTRAMOS LOS SERVICIOS */
function mostrarServicios(servicios) {
    const listado = document.querySelector(".listado-servicios");
    servicios.forEach(servicio => {
        let { id, nombre, precio } = servicio;

        let pNombre = document.createElement("P");
        pNombre.textContent = nombre;
        let Pprecio = document.createElement("P");
        Pprecio.textContent = precio;
        /*CREAMOS LOS BOTONES DE ELIMINAR Y ACTUALIZAR Y LES ASIGNAMOS SUS RESPECTIVAS FUNCIONES */
        let btnEliminar = document.createElement("button");
        let btnActualizar = document.createElement("button");
        btnActualizar.classList.add("btn", "btn_servicio");
        btnEliminar.classList.add("btn", "btn_eliminar");
        btnEliminar.textContent = "Eliminar";


        btnEliminar.addEventListener('click', function () {
            eliminar(id, nombre);
        });


        btnActualizar.addEventListener('click', function () {
            actualizar(id, nombre, precio);

        });


        btnActualizar.textContent = "Actualizar";
        let div = document.createElement("DIV");
        div.classList.add("servicio")



        div.appendChild(pNombre);
        div.appendChild(Pprecio);
        div.appendChild(btnEliminar);
        div.appendChild(btnActualizar);

        listado.appendChild(div);
    });


}

/*ELIMINAR SERVICIOS */
async function eliminar(id, servicio) {
    datos = new FormData();
    datos.append('id', id);

    let consulta = await fetch('http://localhost:3000/servicios/delete', {
        method: 'POST',
        body: datos
    })
    let response = await consulta.json();
    console.log(response)
    if (response.solicitud) {
        Swal.fire(
            'Cita Eliminada ',
            `Se elimino el servicio  ${servicio} correctamente!`,
            'info'
        ).then(function () {
            location.reload();
        });
    } else {

        Swal.fire(
            'Cita Eliminada ',
            response.message,
            'info'
        )
    }
}

/*ACTUALIZAMOS LOS SERVICIOS */
async function actualizar(id, nombre, precio) {
    const { value: formValues } = await Swal.fire({
        title: 'Actualizar Servicio',
        html:
            `<input  id="swal-input1" class="swal2-input" value='${nombre}'>` +
            `<input  id="swal-input2" class="swal2-input" value='${precio}'>`,
        focusConfirm: false,
        preConfirm: () => {
            return [
                nombreActualizar = document.getElementById('swal-input1').value,
                precioActualizar = document.getElementById('swal-input2').value,

            ]
        }
    })

    if (formValues) {
        let datos = new FormData();
        datos.append("id", id);
        datos.append("nombre", nombreActualizar);
        datos.append("precio", precioActualizar);

        let consulta = await fetch('http://localhost:3000/servicios/update', {
            method: 'POST',
            body: datos
        });
        let response = await consulta.json();
        if (response.message) {
            Swal.fire('Actualizado Correctamente',
                'El registro se actualizo correctamente',
                'success').then(function () {
                    location.reload();
                });
        } else {
            Swal.fire('No se pudo actualizar',
                'Presentamos problemas internos',
                'info');
        }

    }
}


