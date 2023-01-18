window.addEventListener('DOMContentLoaded', function (e) {
    recorrerTabs(); // Recorre el menu
    mostrarSeccion(); // Muestra las secciones y a pagina
    consultarServicios(); // Consulta los servicios de la BD
    addInformacionDatos(); // Añade la informacion de datos
    // administrador();
});

let errores = [];


// Variables paginador
let paso = 1;


const pasoInicial = 1;
const pasoFinal = 3;


// Objetos en Javascript
const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [],
}


// Asigna los eventos a cada tab y muestra la seccion correcpondiente
function recorrerTabs() {
    const tabs = document.querySelectorAll(".tabs button");
    tabs.forEach(tab =>
        tab.addEventListener('click', function (e) {
            paso = e.target.dataset.paso;
            mostrarSeccion();
        })
    )
}


// Muestra la seccion
function mostrarSeccion() {

    if (document.querySelector(".mostrar")) {
        ocultarSeccion = document.querySelector(".mostrar");
        ocultarSeccion.classList.remove("mostrar");
    }
    let seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add("mostrar");
    resaltarBoton();
    paginacionApp();

    if (paso == 3) {
        mostrarResumen(); // Muestra el resumen de la cita
    }
}

function resaltarBoton() {
    if (document.querySelector(".resaltar")) {
        apagarBtn = document.querySelector(".resaltar");
        apagarBtn.classList.remove("resaltar");
    }
    let btnResaltar = document.querySelector(`[data-paso='${paso}']`);
    btnResaltar.classList.add("resaltar")
}


function paginacionApp() {

    let btnAnterior = document.querySelector("#anterior");
    let btnSiguiente = document.querySelector("#siguiente");


    btnAnterior.addEventListener('click', paginaAnterior);
    btnSiguiente.addEventListener('click', paginaSiguiente);

    if (paso == 1) {
        btnAnterior.classList.add("ocultar");
    } else {
        btnAnterior.classList.remove("ocultar");
    }

    if (paso == 3) {
        btnSiguiente.classList.add("ocultar");
    } else {
        btnSiguiente.classList.remove("ocultar");
    }

}
function paginaSiguiente() {
    paso++;
    mostrarSeccion();

}

function paginaAnterior() {
    paso--;
    mostrarSeccion();
}

async function consultarServicios() {
    try {
        const url = "http://localhost:3000/api/servicios";
        let resultado = await fetch(url);
        let servicios = await resultado.json();
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error)
    }

}

function mostrarServicios(servicios) {

    const contenedorServicios = document.querySelector(".listado-servicios");
    const templateServicio = document.querySelector(".template-servicios").content;

    servicios.forEach(servicio => {

        let nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = servicio.nombre;


        let precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$${servicio.precio}`;

        let divServicios = document.createElement("DIV");
        divServicios.classList.add("servicio");
        divServicios.dataset.id = servicio.id;
        divServicios.appendChild(nombreServicio);
        divServicios.appendChild(precioServicio);

        contenedorServicios.appendChild(divServicios);
    })
    recorrerServicios();
}

function recorrerServicios() {
    const allServices = document.querySelectorAll(".servicio");
    allServices.forEach(servicio => {

        let id = servicio.dataset.id;
        let nombre = servicio.querySelector(".nombre-servicio").textContent
        let precio = servicio.querySelector(".precio-servicio").textContent

        const obj = { id, nombre, precio, };
        servicio.addEventListener('click', function () {
            //  verifica Si el elemento seleccionado existe en el array o no
            if (cita.servicios.find(elemen => (elemen.id == servicio.dataset.id))) {
                // SI EXISTE ELIMINARLO DE cita.servicios
                servicio.classList.remove('seleccionado');
                cita.servicios = cita.servicios.filter(element => element.id != servicio.dataset.id);
            } else {
                // SI NO EXISTE AGREGARLO al array de cita.servicios
                servicio.classList.add('seleccionado');
                cita.servicios = [...cita.servicios, obj];
            }

        });
    });

}


// Esta funcion ingresa la informacion de la cita al objeto cita
function addInformacionDatos() {
    const nombre = document.querySelector("#nombre");
    const fecha = document.querySelector("#fecha");
    const Inputhora = document.querySelector("#hora");

    cita.nombre = nombre.value;

    fecha.addEventListener('change', function (e) {

        const dia = new Date(e.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            e.target.value = '';

            errores.push("SELECCIONASTE UN SABADO O UN DOMINGO");
            alerta('ELIGE UN DIA ENTRE SEMANA', "error", ".formulario");
        } else {
            cita.fecha = fecha.value;
        }


    });

    Inputhora.addEventListener('change', function () {
        const hora = Inputhora.value.split(":")[0];

        if (hora <= 10 || hora >= 19) {
            Inputhora.value = '';
            alerta('La barberia esta cerrada a esa hora, elija otra', 'error', '.formulario');
        } else {
            cita.hora = Inputhora.value;
        }

    });

}

// Esta funcion muestra las alertas

function alerta(mensaje, tipo, contenedor, desaparece = true) {
    // Valida que la alerta existe para no volverla a agregar
    let alertaSeleccionada = document.querySelector('.alertas');
    if (alertaSeleccionada) {
        alertaSeleccionada.remove();
    }
    let parrafoMensaje = document.createElement("P");
    parrafoMensaje.textContent = mensaje;

    let divError = document.createElement("DIV");
    divError.classList.add("alertas", tipo);

    divError.appendChild(parrafoMensaje);
    document.querySelector(contenedor).appendChild(divError);
    if (desaparece) {
        setTimeout(() => {
            divError.remove();
        }, 3000);
    }

}

/*MOSTRAMOS EL RESUMEN DE LA CITA  Y LOS SERVICIOS QUE EL USUARIO PIDE */
function mostrarResumen() {

    const resumen = document.querySelector(".contenido-resumen");
    resumen.innerHTML = "";
    if (Object.values(cita).includes('') || cita.servicios.length == 0) {
        alerta("DATOS INCOMPLETOS, REVISA BIEN", "error", ".contenido-resumen", false);
        console.log("DATOS INCOMPLETOS...")
        console.log(cita)
    } else {

        const { nombre, fecha, hora, servicios } = cita;

        let pNombre = document.createElement("P");
        let pFecha = document.createElement("P");
        let pHora = document.createElement("P");
        let div = document.createElement("DIV");


        pNombre.textContent = nombre;
        pFecha.textContent = fecha;
        pHora.textContent = hora;


        let btnCita = document.createElement("a");
        btnCita.classList.add('btn', 'btn_reservar');
        btnCita.textContent = "PEDIR CITA";
        btnCita.addEventListener('click', pedirCita);

        div.appendChild(pNombre);
        div.appendChild(pFecha);
        div.appendChild(pHora);

        /*RECORREMOS LOS SERVICIOS */
        servicios.forEach(servicio => {
            const { nombre, precio } = servicio;
            let servicios = document.createElement("DIV");
            let pNombreServicio = document.createElement("P");
            pNombreServicio.textContent = nombre;
            let pPrecioServicio = document.createElement("P");
            pPrecioServicio.textContent = precio;
            servicios.appendChild(pNombreServicio);
            servicios.appendChild(pPrecioServicio);
            div.appendChild(servicios);
        });

        resumen.appendChild(div);
        resumen.appendChild(btnCita);
    }

}


/*ESTA FUNCION PIDE INSERTA LA CITA EN LA BD */
async function pedirCita() {


    let arrayServicios = cita.servicios.map(servicio => servicio.id);

    const datos = new FormData();

    datos.append('fecha', cita.fecha);
    datos.append('hora', cita.hora);
    datos.append('servicios', arrayServicios);
    let url = 'http://localhost:3000/citas';
    let consulta = await fetch(url, {
        method: "POST",
        body: datos
    });
    let response = await consulta.text();

    Swal.fire(
        'Cita Agendada!',
        `${cita.nombre} Tiene su cita agendada`,
        'success'
    ).then(function () {
        location.reload();
    })
}