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
    diaid=parseInt($("#diaid").val());
    observaciond=$("#observaciond").val();
    //alert(observaciond);
    fecha=$("#fecha").val();
    url = '/almdia'
    data = {diaid:diaid, observaciond : observaciond, fecha:fecha}
    $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                  alert(data)
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
                if (data == "ok"){
                    window.open('menu');
                }
                else{
                    $("#mensaje").html(data);
                    $("#alerta").css('display','block');
                }
            }
        }); 
    }
}