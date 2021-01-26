function nueva(){
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
    cantp = $("#cantp").val();
    undp=$("#undp").val();
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
                }
        });
    }
}
function agregarh(){
    hi = $("#hi").val();
    mi = $("#mi").val();
    hf = $("#hf").val();
    mf = $("#mf").val();
    ht = $("#th").val();
    trabajador = $("#cct").val();
    if ((hi=="")||(mi=="")||(hf=="")||(mf=="")||(ht=="")||(trabajador=="")){
        $("#mensajeh").html("* Debe ingresar todos los campos");
        $("#alertah").css('display','block');
    }
    else{
        $("#alertah").css('display','none');
        hi = parseInt($("#hi").val());
        mi = parseInt($("#mi").val());
        hf = parseInt($("#hf").val());
        mf = parseInt($("#mf").val());
        ht = parseFloat($("#th").val());
        ha =0;
        id=parseInt($("#id").val());
        trabajador = $("#cct").val();
        diaid=parseInt($("#diaid").val());
        url = '/agregarh'
        data = {hi: hi,mi:mi, hf:hf, mf:mf, ht:ht , trabajador: trabajador, id:id,diaid:diaid, ha:ha}
        $.ajax({
                url: url,
                type:'GET',
                data: data,
                success: function(data) {
                    $data = $(data);
                    $("#tablah").html($data);
                }
        });
    }
}
function nuevodia(){
    id=parseInt($("#id").val());
    url = '/agregardia'
    data = {id:id}
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                $('#diaid').val(data);
                $("#tablap").html("");
                $("#tablae").html("");
                $("#tablah").html("");
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
                $data = $(data);
                $("#tablad").html($data); 
                $("#dias").css('display','none');
              }
    });   
}
function enviarorden(){
    data=$( "#f1" ).serialize(); 
    //console.log(data)
    dataArray=data.split("&");
    //console.log(dataArray);
    cont =0;
    band="";
    dataArray.forEach(function(datos) {
        console.log(datos);
        if (cont<9){
            x=datos.split("=")
            if (x[1]==""){
                var sel = "#"+x[0]
                $( sel ).addClass( "invalid" );
                band="error";
            }
        }
        cont++;
    });
    if(band!="error"){
        url = '/saveorden'
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
function verorden(id){
    url='verorden/'+id;
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
          $data = $(data);
          $(sdia).html($data);
        }
    }); 
}
function del(tipo,id){
    if (tipo==1){
        sel = "#tablap"
    }
    if (tipo==2){
        sel = "#tablae"
    }
    if (tipo==3){
        sel = "#tablah"
    }
    url = 'delete'
    data = { tipo : tipo , id : id}
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) {
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
                    window.open('ordenes','_self');
                }
                if ((data != 0)&&(data != 1)){
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
    url="/tablaemp"
    $.ajax({
        url: url,
        type:'GET',
        data: data,
        success: function(data) { 
            $("#te").html(data);
        }
    }); 
}
function acttablacdc(){
    url="/tablacdc"
    $.ajax({
        url: url,
        type:'GET',
        success: function(data) { 
            $("#tc").html(data);
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