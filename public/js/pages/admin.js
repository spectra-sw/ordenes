// --------- START SELECTORES ---------- //

const containerTablaEmpleados = document.querySelector(
    "#containerTablaEmpleados"
);
const containerTablaClientes = document.querySelector(
    "#containerTablaClientes"
);
const containerTablaProyectos = document.querySelector(
    "#containerTablaProyectos"
);
const containerTablaCortes = document.querySelector("#containerTablaCortes");
const containerTablaTurnos = document.querySelector("#containerTablaTurnos");

// --------- END SELECTORES ---------- //

// ---------- START EVENTOS ---------- //
if (containerTablaEmpleados !== null) {
    const observerTablaEmpleados = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && $("#tablaEmpleados")[0] === undefined) {
                resetTablaEmpleados();
            }
        });
    });
    observerTablaEmpleados.observe(containerTablaEmpleados);
}

const observerTablaClientes = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting && $("#tablaClientes")[0] === undefined) {
            resetTablaClientes();
        }
    });
});
observerTablaClientes.observe(containerTablaClientes);

const observerTablaProyectos = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting && $("#tablaProyectos")[0] === undefined) {
            resetTablaProyectos();
        }
    });
});
observerTablaProyectos.observe(containerTablaProyectos);

const observerTablaCortes = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting && $("#tablaCortes")[0] === undefined) {
            resetTablaCortes();
        }
    });
});
observerTablaCortes.observe(containerTablaCortes);

const observerTablaTurnos = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting && $("#tablaTurnos")[0] === undefined) {
            resetTablaTurno();
        }
    });
});
observerTablaTurnos.observe(containerTablaTurnos);

// ---------- END EVENTOS ---------- //

// ---------- START FUNCIONES ---------- //

/**
 * EMPLEADOS
 */
const accionesEmpleados = (accion = undefined, empleado_id = undefined) => {
    if (accion != undefined && accion != 0) {
        const url = "/modal-empleado-acciones";
        const data = {
            accion,
            empleado_id,
        };

        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: (data) => {
                $("#modalFeedbackContent").html(data);
                $("#modalFeedback").modal("show");
            },
        });
    }
};

const crearEmpleado = () => {
    const keys_name = [
        "cc",
        "apellido1",
        "apellido2",
        "nombre",
        "auxilio",
        "auxiliot",
        "correo",
        "ciudad",
        "horario",
        "area",
        "cargo",
        "tipo",
    ];

    restFetchForm("/nuevoemp", "formEmpleado", keys_name, (response) => {
        alert(response.message);
        resetTablaEmpleados();
        $("#modalFeedback").modal("hide");
    });
};

const editarEmpleado = () => {
    const keys_name = [
        "id",
        "cc",
        "apellido1",
        "apellido2",
        "nombre",
        "auxilio",
        "auxiliot",
        "correo",
        "ciudad",
        "horario",
        "area",
        "cargo",
        "tipo",
    ];

    restFetchForm("/editaremp", "formEmpleado", keys_name, (response) => {
        alert(response.message);
        resetTablaEmpleados();
        $("#modalFeedback").modal("hide");
    });
};

const eliminarEmpleado = () => {
    restFetchForm("/eliminaremp", "formEmpleado", ["id"], (response) => {
        alert(response.message);
        resetTablaEmpleados();
        $("#modalFeedback").modal("hide");
    });
};

const updatePassword = () => {
    const keys_name = ["password", "empleado_id"];

    restFetchForm("/updatep", "formEmpleado", keys_name, (response) => {
        alert(response.message);
        resetTablaEmpleados();
        $("#modalFeedback").modal("hide");
    });
};

const resetTablaEmpleados = () => {
    const url = "/tablaemp";
    $.ajax({
        url: url,
        type: "GET",
        data: {},
        success: (data) => {
            $("#containerTablaEmpleados").html(data);
            $("#tablaEmpleados").DataTable();
            $("#tablaEmpleados").parent()[0].classList.add("table-responsive");
        },
    });
};

/**
 * CLIENTES
 */
const accionesClientes = (accion = undefined, cliente_id = undefined) => {
    if (accion != undefined && accion != 0) {
        const url = "/modal-cliente-acciones";
        const data = {
            accion,
            cliente_id,
        };

        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: (data) => {
                $("#modalFeedbackContent").html(data);
                $("#modalFeedback").modal("show");
            },
        });
    }
};

const crearCliente = () => {
    const keys_name = ["cliente", "contactos"];

    restFetchForm("/nuevocliente", "formCliente", keys_name, (response) => {
        alert(response.message);
        resetTablaClientes();
        $("#modalFeedback").modal("hide");
    });
};

const editarCliente = () => {
    const keys_name = ["id", "cliente", "contactos"];

    restFetchForm("/editarcliente", "formCliente", keys_name, (response) => {
        alert(response.message);
        resetTablaClientes();
        $("#modalFeedback").modal("hide");
    });
};

const eliminarCliente = () => {
    restFetchForm(
        "/eliminarcliente",
        "formCliente",
        ["cliente_id"],
        (response) => {
            alert(response.message);
            resetTablaClientes();
            $("#modalFeedback").modal("hide");
        }
    );
};

const resetTablaClientes = () => {
    const url = "/tablacliente";
    $.ajax({
        url: url,
        data: {},
        type: "GET",
        success: (response) => {
            $("#containerTablaClientes").html(response);
            $("#tablaClientes").DataTable();
            $("#tablaClientes").parent()[0].classList.add("table-responsive");
        },
    });
};

/**
 * PROJETOS
 */
const accionesProyectos = (accion = undefined, proyecto_id = undefined) => {
    if (accion != undefined && accion != 0) {
        const url = "/modal-proyecto-acciones";
        const data = {
            accion,
            proyecto_id,
        };

        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: (data) => {
                $("#modalFeedbackContent").html(data);
                $("#modalFeedback").modal("show");
            },
        });
    }
};

const editarProyecto = () => {
    const keys_name = [
        "id",
        "codigo",
        "descripcion",
        "cliente",
        "sistema",
        "subportafolio",
        "director",
        "lider",
        "ciudad",
        "co",
        "un",
    ];

    restFetchForm("/editarproy", "formPoyecto", keys_name, (response) => {
        alert(response.message);
        resetTablaProyectos();
        $("#modalFeedback").modal("hide");
    });
};

const agregarAutorizado = () => {
    const data = $("#formAutProy").serialize();
    const url = "/agautorizadoproy";
    $.ajax({
        url: url,
        type: "GET",
        data: data,
        success: (response) => {
            $("#tablaautorizados").html(response);
        },
    });
};

const borrarAutorizado = (id) => {
    const data = { id };
    url = "/borrarautorizado";
    $.ajax({
        url: url,
        type: "GET",
        data: data,
        success: (data) => {
            //alert(data);
            $data = $(data);
            $("#tablaautorizados").html($data);
        },
    });
};

const togleHabilitarProyecto = () => {
    restFetchForm("/togle-habilitar-proyecto", "formPoyecto", ["id"], (response) => {
        alert(response.message);
        resetTablaProyectos();
        $("#modalFeedback").modal("hide");
    });
};

const resetTablaProyectos = () => {
    const url = "/tablaproy";
    $.ajax({
        url: url,
        type: "GET",
        data: {},
        success: (response) => {
            $("#containerTablaProyectos").html(response);
            $("#tablaProyectos").DataTable();
            $("#tablaProyectos").parent()[0].classList.add("table-responsive");
        },
    });
};

/**
 * Cortes
 */
const accionesCortes = (accion = undefined, corte_id = undefined) => {
    if (accion != undefined && accion != 0) {
        const url = "/modal-corte-acciones";
        const data = {
            accion,
            corte_id,
        };

        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: (data) => {
                $("#modalFeedbackContent").html(data);
                $("#modalFeedback").modal("show");
            },
        });
    }
};

const crearCorte = () => {
    const keys_name = ["fecha_inicio", "fecha_fin", "estado"];

    restFetchForm("/nuevocorte", "formCorte", keys_name, (response) => {
        alert(response.message);
        resetTablaCortes();
        $("#modalFeedback").modal("hide");
    });
};

const togleHabilitarCorte = (corte_id) => {
    restFetchForm(
        "/togle-habilitar-corte",
        "formCorte",
        ["corte_id"],
        (response) => {
            alert(response.message);
            resetTablaCortes();
            $("#modalFeedback").modal("hide");
        }
    );
};

const resetTablaCortes = () => {
    const url = "/tablacorte";
    $.ajax({
        url: url,
        data: {},
        type: "GET",
        success: (data) => {
            $("#containerTablaCortes").html(data);
            $("#tablaCortes").DataTable();
            $("#tablaCortes").parent()[0].classList.add("table-responsive");
        },
    });
};

/**
 * Turnos
 */
const accionesTurnos = (accion = undefined, turno_id = undefined) => {
    if (accion != undefined && accion != 0) {
        const url = "/modal-turno-acciones";
        const data = {
            accion,
            turno_id,
        };

        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: (data) => {
                $("#modalFeedbackContent").html(data);
                $("#modalFeedback").modal("show");
            },
        });
    }
};

const editarTurno = () => {
    // get data json from formEditarTurno
    const formData = new FormData($("#formEditarTurno")[0]);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    const url = `/update-turnos-form/${data.id}`;

    $.ajax({
        url: url,
        type: "GET",
        data: data,
        success: (data) => {
            alert(data.message);
            resetTablaTurno();
            $("#modalFeedback").modal("hide");
        },
        error: (error) => {
            // alert all errors
            for (const key in error.responseJSON.errors) {
                alert(error.responseJSON.errors[key]);
            }
        },
    });
};

const resetTablaTurno = () => {
    const url = "/tabla-turnos";
    $.ajax({
        url: url,
        data: {},
        type: "GET",
        success: (data) => {
            $("#containerTablaTurnos").html(data);
            $("#tablaTurnos").DataTable();
            $("#tablaTurnos").parent()[0].classList.add("table-responsive");
        },
    });
};

// ---------- END FUNCIONES ---------- //
