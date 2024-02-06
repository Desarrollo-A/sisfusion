$(document).ready(function () {
  
    $.ajax({
        url: 'getanios',
        type: 'post',
        dataType: 'JSON',
        success: function (anio) 
        {

            console.log(anio)
            var html = ` `;
            for(var i = 0; i < anio.length ; i++) {
      
                html += `
                <div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <label class="control-label">Año</label>
                    <input class="form-control input-gral" id="anio" type="text" readonly  name="anio" value="${anio[i].nombre}">
                </div>
                `
                ;

                }
             
                document.getElementById("autorizaciones").innerHTML = html;
                for(var e = 0; e < anio.length ; e++) {
                    if(anio[e].bandera == 0){
                        $("#autorizacionBandera_"+anio[e].id_autorizacion).prop('checked', true);
                       
                    }else if(anio[e].bandera == 1){
                        $("#autorizacionBandera_"+anio[e].id_autorizacion).prop('checked', false);
                      
                    }
                
                }
              
               
                //    $("#myCheck").prop('checked', false);

                // $("#autorizaciones").append(html);

        }
    });
})


// {'id_rol': id_rol, 'id_catalogo': id_catalogo},

function kj(id_autorizacion){

    let bandera = 0
    if($("#autorizacionBandera_"+id_autorizacion).is(':checked')) {
        bandera = 0
        
    }else{
        bandera = 1
       
    }


    $.ajax({
        url: 'editarAutorizacion',
        type: 'post',
        data:{
            'bandera': bandera,
            'id_autorizacion' : id_autorizacion
        },
        dataType: 'JSON',
        success: function (data) 
        {
            alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
        },
        error: (a, b, c) => {
            alerts.showNotification("top", "right", "Descuento No actualizado .", "error");
        }
     } )
}




