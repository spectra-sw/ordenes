const images = [
    '/img/fondos/image0.png',
    '/img/fondos/image1.png',
    '/img/fondos/image2.png',
    '/img/fondos/image3.png',
   
  ];
  
const randomImage = images[Math.floor(Math.random() * images.length)];
const element = document.querySelector('.random-background-image');
element.style.backgroundImage = `url(${randomImage})`;

function buscarP(codigo){
    //alert(codigo);
    url = '/consproyecto'
    data = {codigo : codigo}
    $.ajax({
          url: url,
          type:'GET',
          data: data,
          success: function(data) {
              //console.log(data)
              $("#cliente").val(data.cliente.cliente);
              $("#contacto").val(data.cliente.contactos);
              $("#descripcion").val(data.descripcion);
              $("#subportafolio").val(data.subportafolio);
              $("#director").val(data.director);
              $("#lider").val(data.lider);
              $("#sistema").val(data.sistema);

              /*for (let k in data.trabajadores) {
                    //console.log(k + ' is ' + data.trabajadores[k])
                    
                    $('#cct').append($('<option>', { 
                        value: k,
                        text : data.trabajadores[k]
                    }));
                }      */
              //validartipo(data.sistema)
              //$("#contacto").val(data.responsable);
        }
    }); 
}
function detectSelectChange() {
    var select = document.getElementById("tipo");
    if (select != null) {
        select.addEventListener("change", function() {
        var opcion = document.getElementById("tipo").value;
        if (opcion == "1"){
            var div = document.getElementById("datos");
            div.style.display = "block";
        }
        else{
            var div = document.getElementById("datos");
            div.style.display = "none";
        }
        var div = document.getElementById("datos2");
        div.style.display = "block";
        });
    }
}
detectSelectChange();
//habilitar nueva jornada
var btnNuevaJornada = document.getElementById("btnNuevaJornada");
if (btnNuevaJornada  != null) {
btnNuevaJornada.addEventListener("click", function() {
    $.ajax({
        type: "GET",
        url: "/consecJornada",
        success: function(response) {
            //alert(response);
            document.getElementById("jornada_id").value = response;
            var div = document.getElementById("formJornada");
            div.style.display = "block";
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
    var div = document.getElementById("formJornada");
    div.style.display = "block";
});
}
//guardar registro
var btnRegistrar = document.getElementById("btnRegistrar");
if (btnNuevaJornada  != null) {
var isValid = true;
var hValid = true;
var sValid = true;
btnRegistrar.addEventListener("click", function() {
    var tipo = document.getElementById("tipo").value;
    var requiredSelects;
    if (tipo === "1"){
        requiredSelects = document.querySelectorAll("select[required], input[required]");
        for (var i = 0; i < requiredSelects.length; i++) {
            if (requiredSelects[i].value === "") {
                isValid = false;
                break;
            }
        }
    }
    else if (tipo === "0"){
        requiredSelects = ["fecha", "horaInicio", "horaFin", "minInicio", "minFin"];
        for (var i = 0; i < requiredSelects.length; i++) {
            var x = document.getElementById(requiredSelects[i]).value;
            console.log(requiredSelects[i] + ":" + x);
            if (x === "") {
                isValid = false;
                break;
            }
        }
    }
    hValid=validarHoras();
    sValid=validarSolape();
   
});
}
function validarHoras(){
    const startHour = parseInt(document.getElementById('horaInicio').value);
    const startMin = parseInt(document.getElementById('minInicio').value);
    const endHour = parseInt(document.getElementById('horaFin').value);
    const endMin = parseInt(document.getElementById('minFin').value);

    const startTime = startHour + startMin / 60;
    const endTime = endHour + endMin / 60;

    if (startTime >= endTime) {
        errorHandler('La hora final no puede ser mayor o igual a la hora de inicio');
        return false;
    }
    
    return true;
}
function validarSolape(){
    var formData = $("#formRegistro").serialize(); 
    $.ajax({
        type: "GET",
        url: "/solapeJornada",
        data: formData,
        success: function(response) {
            console.log(response)
            if(response=="true"){
                errorHandler('El rango de horas se solapa con otro registro para la misma fecha');
                sValid= false;
            }
            else{
                sValid= true;
            }
            enviar()
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}
function enviar(){
    console.log(sValid);
    if ((isValid) && (hValid) && (sValid)) {
        // Submit the form
        var formData = $("#formRegistro").serialize(); 
        console.log(formData);
        $.ajax({
            type: "GET",
            url: "/registrarJornada",
            data: formData,
            success: function(response) {
                // Handle the response
                $("#tablaJornada").html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    } 
    else {
        if (!isValid){
            errorHandler('Debes ingresar todos los campos obligatorios (*)');
        }
        //var element = document.getElementById("alertaError");
        //element.classList.add("show");
        //element.style.display = "block";
    }
}
function delj(id) {
    $.ajax({
        type: "GET",
        url: "/deleteJornada",
        data: { id: id },
        success: function (response) {
            successHandler("El registro se ha eliminado con éxito");
            $("#tablaJornada").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        }
    });
}
function errorHandler(mensaje) {
    $.ajax({
        type: "GET",
        url: '/mensaje/error',
        data : { mensaje: mensaje },
        success: function(response) {
            $('#mensaje').html(response);
        }
    });
}
function successHandler(mensaje) {
    $.ajax({
        type: "GET",
        url: "/mensaje/exito",
        data: { mensaje: "El registro se ha eliminado con éxito" },
        success: function (response) {
            $("#mensaje").html(response);
        }
    });
}
var btnConsultar = document.getElementById("btnConsultar");
btnConsultar.addEventListener("click", function() {
    alert("");
    var formData = $("#formConsultaJornada").serialize(); 
    $.ajax({
        type: "GET",
        url: "/consultaJornada",
        data: formData,
        success: function(response) {
            $("#mensaje").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});