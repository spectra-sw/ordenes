function nueva(){
    data=$( "#f1" ).serialize(); 
    dataArray=data.split("&");
    dataArray.forEach(function(datos) {
        x=datos.split("=")    
        var sel = "#"+x[0]
        $( sel ).val("");
                
    });
    $("#datos").css('display','block');
    url="/getConsec";
    $.ajax({
        url: url,
        type: "GET", // not POST, laravel won't allow it
        success: function(data){
            $('#id').val(data);
            $("#consec").html(data);
          }
      });
}
function agregarp(){
    //alert("");
    cantp = $("#cantp").val();
    undp=$("#undp").val();
    //alert(cantp);
    materiales = $("#materiales").val();
    if((cantp=="")&&(undp=="")&&(materiales=="")){
        $("#mensajep").html("* Debe ingresar algún campo");
        $("#alertap").css('display','block');
    }
    else{
        $("#alertap").css('display','none');
        cantp = parseFloat($("#cantp").val());
        id=parseInt($("#id").val());
        diaid=parseInt($("#diaid").val());
        url = '/agregarp'
        data = {cant: cantp, und:undp, materiales:materiales, id:id, diaid:diaid}
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    $data = $(data);
                    $("#tablap").html($data);
                    $("#cantp").val("");
                    $("#undp").val("");
                    $("#materiales").val("");
                }
        });
    }
}
function agregarp2(){
    //alert("");
    cantp = $("#cantp2").val();
    undp=$("#undp2").val();
    alert(cantp);
    materiales = $("#materiales2").val();
    if((cantp=="")&&(undp=="")&&(materiales=="")){
        $("#mensajep2").html("* Debe ingresar algún campo");
        $("#alertap2").css('display','block');
    }
    else{
        $("#alertap2").css('display','none');
        cantp = parseFloat($("#cantp2").val());
        id=parseInt($("#id").val());
        diaid=parseInt($("#diaid2").val());
        url = '/agregarp'
        data = {cant: cantp, und:undp, materiales:materiales, id:id, diaid:diaid}
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    $data = $(data);
                    $("#tablap2").html($data);
                    $("#cantp2").val("");
                    $("#undp2").val("");
                    $("#materiales2").val("");
                }
        });
    }
}
function agregare(){
    cante = $("#cante").val();
    unde=$("#unde").val();
    observacion = $("#observacione").val();
    if((cante=="")&&(unde=="")&&(observacion=="")){
        $("#mensajee").html("* Debe ingresar algún campo");
        $("#alertae").css('display','block');
    }
    else{
        $("#alertae").css('display','none');
        cante = parseFloat($("#cante").val());
        unde=$("#unde").val();
        observacion = $("#observacione").val();
        id=parseInt($("#id").val());
        diaid=parseInt($("#diaid").val());
        url = '/agregare'
        data = {cant: cante, und:unde, observacion:observacion, id:id, diaid:diaid}
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    $data = $(data);
                    $("#tablae").html($data);
                    $("#cante").val("");
                    $("#unde").val("");
                    $("#observacione").val("");
                }
        });
    }
}
function agregarh(){
    hi = $("#hi").val();
    mi = $("#mi").val();
    hf = $("#hf").val();
    mf = $("#mf").val();
    //ht = $("#th").val();
   
    //$("#th").val(ht) 
    trabajador = $("#cct").val();
    if ((hi=="")||(mi=="")||(hf=="")||(mf=="")||(trabajador=="")){
        $("#mensajeh").html("* Debe ingresar todos los campos");
        $("#alertah").css('display','block');
    }
    else{
        $("#alertah").css('display','none');
        hi = parseInt($("#hi").val());
        mi = parseInt($("#mi").val());
        hf = parseInt($("#hf").val());
        mf = parseInt($("#mf").val());
        ht = (hf + mf/60)- (hi + mi/60)
        ha =0;
        id=parseInt($("#id").val());
        trabajador = $("#cct").val();
        diaid=parseInt($("#diaid").val());
        url = '/agregarh'
        data = {hi: hi,mi:mi, hf:hf, mf:mf, ht:ht , trabajador: trabajador, id:id,diaid:diaid, ha:ha}
        console.log(data);
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    if (data == 'no'){
                        alert('Ya existen horas registradas en el día para este trabajador');
                    }
                    else{
                        $data = $(data);
                        $("#tablah").html($data);
                        $("#hi").val("");
                        $("#mi").val("");
                        $("#hf").val("");
                        $("#mf").val("");
                        $("#th").val("");
                    }
                }
        });
    }
}
function nuevodia(){
    id=parseInt($("#id").val());
    proyecto = $("#proyecto").val()
    url = '/agregardia'
    data = {id:id, proyecto:proyecto}
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                /*$('#diaid').val(data);
                $("#tablap").html("");
                $("#tablae").html("");
                $("#tablah").html("");
                $("#dias").css('display','block');*/
                $data = $(data);
                $('#dias').html(data); 
                $("#dias").css('display','block');
              }
    });   
}
function calchoras(){
    hi = parseInt($("#hi").val());
   // alert(hi);
    mi = parseInt($("#mi").val());
    //alert(mi);
    hf = parseInt($("#hf").val());
    //alert(hf);
    mf = parseInt($("#mf").val());
    //alert(mf);
    ht = (hf + mf/60)- (hi + mi/60)
    //alert(ht);
    $("#th").val(ht) 
}
function almdia(){
    id=parseInt($("#id").val());
    diaid=parseInt($("#diaid").val());
    observaciond=$("#observaciond").val();
    //alert(observaciond);
    fecha=$("#fecha").val();
    url = '/almdia'
    data = {diaid:diaid, observaciond : observaciond, fecha:fecha, id :id}
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                  //alert(data)
                if (data == 'no'){
                    alert("No existen horas registradas para el día");
                }
                else{
                    $data = $(data);
                    $("#tablad").html($data); 
                    $("#dias").css('display','none');
                }
              }
    });   
}
function enviarorden(a){
    data=$( "#f1" ).serialize(); 
    //console.log(data)
    dataArray=data.split("&");
    //console.log(dataArray);
    cont =0;
    band="";
    dataArray.forEach(function(datos) {
        //console.log(datos);
        if (cont<7){
            console.log(datos);
            x=datos.split("=")
            if ((x[1]=="")&&(x[0] != "fechaInicio")&&(x[0] != "fechaFinal")) {
                var sel = "#"+x[0]
                $( sel ).addClass( "invalid" );
                band="error";
            }
        }
        cont++;
    });
    if(band!="error"){
        if (a==1){
        url = '/saveorden';
        }
        if (a==2){
            url = '/updateorden';
        }
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data)            
                }
        });  
    }
    else{
        alert("Ingrese todos los campos obligatorios marcados con *")
    } 
}
function consultar(){
    data=$( "#formConsulta" ).serialize(); 
    url = '/getordenes'
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                $data = $(data);
                $("#tablao").html($data);
              }
    });   
}
function archivo(){
    data=$( "#formConsulta" ).serialize(); 
    console.log(data);
    url = '/archivon'
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                $data = $(data);
                $("#tablao").html($data);
              }
    }); 
}
function archivoc(){
    data=$( "#formConsulta" ).serialize(); 
    console.log(data);
    url = '/archivoc'
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                $data = $(data);
                $("#tablao").html($data);
              }
    }); 
}
function reportep(){
    data=$( "#formConsulta" ).serialize(); 
    url = '/reportep'
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                $data = $(data);
                $("#tablao").html($data);
              }
    }); 
}

function verorden(id){
    url='verorden/'+id;
    window.open(url,'_blank');
}
function editorden(id){
    url='ordenese/'+id;
    window.open(url,'_blank');
}
function auto(id,dia){
    url = '/autorizadas'
    selector= "#ha" + id
    sdia = "#tablah" + dia
    valor = $(selector).val();
    data = { valor: valor , id:id}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) {
            //alert(data);
            if (data == 'limite'){
                alert('No puede autorizar horas superiores al tiempo registrado');
            }else{
                if (data == 'login'){
                    alert('Debe loguearse para poder autorizar horas');
                }
                else{
                    $data = $(data);
                    $(sdia).html($data);
                }
            }
        }
    }); 
}
function del(tipo,id,diaid){
    //alert(tipo);
    //alert(id);
    if (tipo==1){
        sel = "#tablap"
    }
    if (tipo==2){
        sel = "#tablae"
    }
    if (tipo==3){
        sel = "#tablah"
    }
    url = '/eliminar'
    data = { tipo : tipo , id : id, diaid:diaid}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) {
          //alert(data)
          $data = $(data);
          $(sel).html($data);
        }
    }); 
}
function del2(tipo,id){
    //alert(tipo);
    //alert(id);
    if (tipo==1){
        sel = "#tablap2"
    }
    if (tipo==2){
        sel = "#tablae2"
    }
    if (tipo==3){
        sel = "#tablah2"
    }
    url = '/eliminar'
    data = { tipo : tipo , id : id}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) {
          //alert(data)
          $data = $(data);
          $(sel).html($data);
        }
    }); 
}
function login(){
    email = $("#email").val();
    pwd = $("#pwd").val();

    if ((email =="")||(pwd=="")){
        $("#mensaje").html("* Debe ingresar todos los campos");
        $("#alerta").css('display','block');
    }
    else{
        url = 'validar'
        data = { email : email , pwd : pwd}
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                if (data == 0){
                    window.open('menu','_self');
                }
                if (data == 1){
                    //window.open('ordenes','_self');
                    window.open('menu','_self');
                }
                if (data == 10){
                    //window.open('ordenes','_self');
                    window.open('menu','_self');
                }
                if ((data != 0)&&(data != 1)&&(data != 10)){
                    $("#mensaje").html(data);
                    $("#alerta").css('display','block');
                }
            }
        }); 
    }
}


//admin
function nuevoemp(){
    $("#nuevoemp").modal();
}
function nuevocdc(){
    $("#nuevocdc").modal();
}
function nuevoproyecto(){
    $("#nuevoproyecto").modal();
}
function nuevocliente(){
    $("#nuevocliente").modal();
}
function guardare(){
    band=0;
    $('#formEmp input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'apellido2')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formEmp" ).serialize(); 
        url = '/nuevoemp'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablaemp();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function guardarcdc(){
    band=0;
    $('#formCdc input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'observaciones')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formCdc" ).serialize(); 
        url = '/nuevocdc'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablacdc();
                }
        });   
    }
    else{

        alert("Debes ingresar todos los campos");
    }
}
function guardarcliente(){
    band=0;
    $('#formCliente input').each(function() { 
        if (($(this).val() == '')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formCliente" ).serialize(); 
        url = '/nuevocliente'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablacliente();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function guardarproy(){
    band=0;
    $('#formProy input').each(function() { 
        if (($(this).val() == '')) {
            band=1;
        }        
    })
    $('#formProy select').each(function() { 
        if (($(this).val() == '')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formProy" ).serialize(); 
        url = '/nuevoproy'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablaproy();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function acciones(op,id){
    //alert(op);
    //alert(id);
    if (op==1){
        data = { id : id }
        url="/buscaremp"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                $("#editarBody").html(data);
                $("#editaremp").modal();
            }
        }); 
    }
    if(op==2){
        $("#id").val(id);
        $("#eliminaremp").modal(); 
    }
    if(op==3){
        $("#idup").val(id);
        $("#password").modal();
    }
    
}
function accionesproyectos(op,id){
    //alert(op);
    //alert(id);
    if (op==1){
        data = { id : id }
        url="/buscarproy"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                $("#editarBodyProy").html(data);
                $("#editarproy").modal();
            }
        }); 
    }
    if(op==2){
        $("#id").val(id);
        $("#eliminarproy").modal(); 
    }   
}
function accionescdc(op,id){
    //alert(op);
    //alert(id);
    if (op==1){
        data = { id : id }
        url="/buscarcdc"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                //alert(data);
                $("#cdceditBody").html(data);
                $("#editarcdc").modal();
            }
        }); 
    }
    if(op==2){
        $("#id").val(id);
        $("#eliminarcdc").modal(); 
    }
}
function accionescliente(op,id){
    //alert(op);
    //alert(id);
    if (op==1){
        data = { id : id }
        url="/buscarcliente"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                //alert(data);
                $("#editarClienteBody").html(data);
                $("#editarcliente").modal();
            }
        }); 
    }
    if(op==2){
        $("#id").val(id);
        $("#eliminarcliente").modal(); 
    }
}
function editare(){
    band=0;
    $('#formEdit input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'apellido2')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formEdit" ).serialize(); 
        url = '/editaremp'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablaemp();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function editarcliente(){
    band=0;
    $('#formEditCliente input').each(function() { 
        if (($(this).val() == '')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formEditCliente" ).serialize(); 
        url = '/editarcliente'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablacliente();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function editarproy(){
    band=0;
    $('#formEditProy input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'apellido2')) {
            band=1;
        }        
    })
    $('#formEditProy select').each(function() { 
        if (($(this).val() == '')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formEditProy" ).serialize(); 
        url = '/editarproy'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablaproy();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function editarcdc(){
    band=0;
    $('#formCdce input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'observaciones')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formCdce" ).serialize(); 
        url = '/editarcdc'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablacdc();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function acttablaemp(){
    campo='';
    url="/tablaemp"
    data = { campo : campo}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) { 
            $("#te").html(data);
        }
    }); 
}
function acttablaproy(){
    campo='';
    url="/tablaproy"
    data = { campo : campo}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) { 
            $("#tp").html(data);
        }
    }); 
}
function acttablacdc(){
    campo = ''
    data = {campo : campo}
    url="/tablacdc"
    $.ajax({
        url: url,
        data:data,
        type:'GET',
        success: function(data) { 
            $("#tc").html(data);
        }
    }); 
}
function acttablacliente(){
    campo = ''
    data = {campo : campo}
    url="/tablacliente"
    $.ajax({
        url: url,
        data:data,
        type:'GET',
        success: function(data) { 
            $("#tcl").html(data);
        }
    }); 
}
function eliminare(){
    id = $("#id").val();
    // alert(id);
    data={ id : id}
    url = '/eliminaremp'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                alert(data);
                acttablaemp();
            }
    });   
}
function eliminarproy(){
    id = $("#id").val();
    // alert(id);
    data={ id : id}
    url = '/eliminarproy'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                alert(data);
                acttablaproy();
            }
    });   
}
function eliminarcdc(){
    id = $("#id").val();
    // alert(id);
    data={ id : id}
    url = '/eliminarcdc'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                alert(data);
                acttablacdc();
            }
    });   
}
function updatepwd(){
    id = $("#idup").val();
    password= $("#pwd").val();
    // alert(id);
    data={ id : id, password : password}
    url = '/updatep'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                alert(data);
            }
    });   
}
function ordenar(campo){
    //alert(campo);
    url="/tablaemp";
    data = {campo : campo}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) { 
            $("#te").html(data);
        }
    }); 
}
function ordenarc(campo){
    url="/tablacdc"
    data = {campo : campo}
    $.ajax({
        url: url,
        data: data,
        type:'GET',
        success: function(data) { 
            $("#tc").html(data);
        }
    }); 
}
function buscarcontactos(){
    cliente = $("#cliente").val();
    url="/buscarcontactos"
    data = {cliente : cliente}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) { 
              //alert(data);     
              $("#contacto").val(data); 
             
        }
    });   
}
function modalconfirm(){
    $("#cproyecto").val($("#proyecto").val());
    $("#cfechaInicio").val($("#fechaInicio").val());
    $("#cfechaFinal").val($("#fechaFinal").val());
    $("#ccliente").val($("#cliente").val());
    $("#cresponsable").val($("#responsable").val());
    $("#carea").val($("#area").val());
    $("#ccontacto").val($("#contacto").val());
    $("#confirm").modal();
}
function infoDia(id){
    //alert(id);
    url = '/getdia'
    data = {id : id}
    $.ajax({
          url: url,
          type:'GET',
          data: data,
          success: function(data) {
                $data = $(data);
                $("#infoBody").html($data); 
                $("#info").modal();
            } 
        });   
}
function editDia(id){
    /*
    //alert(id);
    url = '/editDia'
    data = {id : id}
    $.ajax({
          url: url,
          type:'GET',
          data: data,
          success: function(data) {
               //alert(data);
                $data = $(data);
                $("#infoBody").html($data); 
                $("#info").modal();
            } 
        });  
    */
   url = '/editDia'
   data = {id : id}
   $.ajax({
             url: url,
             type:'GET',
             data: data,
             success: function(data) {
               $data = $(data);
               $('#dias').html(data); 
               $("#dias").css('display','block');
             }
   });    
}
function deleteDia(id){
   url = '/deleteDia'
   data = {id : id}
   $.ajax({
             url: url,
             type:'GET',
             data: data,
             success: function(data) {
               $data = $(data);
               $("#tablad").html($data); 
               
             }
   });    
}
function nuevaprog(){
    $("#prog").modal();
}
function guardarprog(){
    band=0;
    $('#formProg input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'observaciones')) {
            band=1;
        }        
    })
    $('#formProg select').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'observaciones')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formProg" ).serialize(); 
        console.log(data);
        url = '/nuevaprog'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablaprog();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function acttablaprog(){
    campo='';
    url="/tablaprog"
    data = { campo : campo}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) { 
            $("#tprog").html(data);
        }
    }); 
}
function accionesprog(op,id){ 
    if (op==1){
        data = { id : id }
        url="/buscarprog"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                $("#editarprogBody").html(data);
                $("#editarprog").modal();
            }
        }); 
    }
    if(op==2){
        $("#id").val(id);
        $("#eliminarprog").modal(); 
    }  
}
function editarprog(){
    band=0;
    $('#formProgEdit input').each(function() { 
        if (($(this).val() == '') && ($(this).attr('id') != 'observaciones')) {
            band=1;
        }        
    })
    if (band==0){
        data=$( "#formProgEdit" ).serialize(); 
        url = '/editarprog'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    acttablaprog();
                }
        });   
    }
    else{
        alert("Debes ingresar todos los campos");
    }
}
function eliminarprog(){
    id = $("#id").val();
    // alert(id);
    data={ id : id}
    url = '/eliminarprog'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                alert(data);
                acttablaprog();
            }
    });   
}
function rocupacion(){
    data=$( "#formRegistro" ).serialize(); 
    dataArray=data.split("&");
    band =0;
    dataArray.forEach(function(datos) {
        x=datos.split("=")
        if (x[1]==""){
            band=1;
        }  
    });
    if(band==0){
        url = '/rocupacion'
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    alert(data);
                    //$('#formRegistro').trigger("reset");
                    $('#proyecto').val("");
                    $('#actividad').val("");
                    $('#horas').val("0");
                    $('#min').val("0");
                }
        }); 
    }
    else{
        alert("Debe ingresar todos los campos");
    }
}
function validarfest(fecha){
    //alert(fecha);
    url = '/consfestivo'
    data = { fecha : fecha }
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                if (data == "si"){
                    alert("La fecha seleccionada es un día festivo");
                }
            }
    }); 
}
function filtrarprog(){
    data=$( "#filtrarProg" ).serialize(); 
    url = '/filtrarprog'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tprog").html(data);
            }
    });   
}
function calendario(){
    data=$( "#filtrarProg" ).serialize(); 
    url = '/calendarioprog'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tprog").html(data);
            }
    });   
}
function filtrarproy(){
    data=$( "#filtrarProy" ).serialize(); 
    url = '/filtrarproy'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tp").html(data);
            }
    });   
}
function filtrarcentro(){
    data=$( "#filtrarCentro" ).serialize(); 
    url = '/filtrarcentro'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tc").html(data);
            }
    });   
}
function filtrarcliente(){
    data=$( "#filtrarCliente" ).serialize(); 
    url = '/filtrarcliente'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tcl").html(data);
            }
    });   
}
function consultaroc(){
    data=$( "#formConsultaOcupacion" ).serialize(); 
    url = '/calendariooc'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tablaocupacion").html(data);
            }
    });   
}
function seguimiento(){
    data=$( "#formReportesOcupacion" ).serialize(); 
    url = '/seguimiento'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tablareporteo").html(data);
            }
    });   
}
function generalo(){
    data=$( "#formReportesOcupacion" ).serialize(); 
    url = '/generalo'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tablareporteo").html(data);
            }
    });   
}
function distribuciono(){
    data=$( "#formReportesOcupacion" ).serialize(); 
    url = '/distribuciono'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                $("#tablareporteo").html(data);
            }
    });   
}
function buscarInfoOc(){
    data={fecha : $("#dia").val()}
    url = '/buscarinfooc'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                
                $("#msghoras").html(data); 
                $("#divhoras").css('display','block');
            }
    });   
}
function consprog(proyecto,fecha,cc){
    /*alert(proyecto);
    alert(fecha);
    alert(cc);*/
    data = { proyecto : proyecto, fecha : fecha, cc:cc }
        url="/consprog"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                $("#editarprogBody").html(data);
                $("#editarprog").modal();
            }
        }); 

}
function extra(proyecto,fecha,cc,hi,hf){
    /*alert(proyecto);
    alert(fecha);
    alert(cc);*/
    data = { proyecto : proyecto, fecha : fecha, cc:cc, hi:hi, hf:hf }
        url="/authextra"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
                $("#authExtraBody").html(data);
                $("#authExtraModal").modal();
            }
        }); 

}
function guardarextra(){
    data=$( "#formExtra" ).serialize(); 
    url = '/saveextra'
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                alert(data);
            }
    });   
}


function aprobar(id){
    obs =$("#observacion").val();

    data = { obs : obs, id:id }
        url="/voboextra"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
               alert(data);
               location.reload();
            }
        }); 
}
function analiticas(){
    //alert();
    data=$( "#formReportesOcupacion" ).serialize(); 
    url = '/exportAnaliticas'
    var url = "/exportAnaliticas?" + $.param(data)
    window.location = url;
    /*console.log(data);
    $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) {
                
            }
    });   */
}
function nuevaextra(){
    
        url="/nuevaextra"
        $.ajax({
            url: url,
            type:'GET',
           
            success: function(data) { 
                $("#authExtraBody").html(data);
                $("#authExtraModal").modal();
            }
        }); 

}
function exportarextra(){
    //alert();
    data={ fechaInicio :$("#fechaInicio").val() , fechaFinal:  $("#fechaFinal").val() }
    var url = "/exportExtra?" + $.param(data)
    window.location = url;
}
function exportarproyectos(){
    var url = "/exportProyectos" 
    window.location = url;
}
function delOcupacion(ocupacion_id){
    let text = "Desea eliminar este registro?";
    if (confirm(text) == true) {
        data = {  ocupacion_id : ocupacion_id}
        url="/deleteOcupacion"
        $.ajax({
            url: url,
            type:'GET',
            data: data,
            success: function(data) { 
               alert(data)
            }
        }); 
    } 
}