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
    cantp = parseFloat($("#cantp").val());
    undp=$("#undp").val();
    materiales = $("#materiales").val();
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
function agregare(){
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
function agregarh(){
    hi = parseInt($("#hi").val());
    mi = parseInt($("#mi").val());
    hf = parseInt($("#hf").val());
    mf = parseInt($("#mf").val());
    ht = parseFloat($("#th").val());
    id=parseInt($("#id").val());
    trabajador = $("#trabajador").val();
    diaid=parseInt($("#diaid").val());
    url = '/agregarh'
    data = {hi: hi,mi:mi, hf:hf, mf:mf, ht:ht , trabajador: trabajador, id:id,diaid:diaid}
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
    alert(observaciond);
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