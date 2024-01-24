$(document).ready(function () {
  
    $.ajax({
        url: 'getautorizaciones',
        type: 'post',
        dataType: 'JSON',
        success: function (autorizaciones) 
        {

            console.log(autorizaciones)
            var html = ` `;
            for(var i = 0; i < autorizaciones.length ; i++) {
      
                html += `
                <div class=" col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <label class="control-label">Nombre del usuario</label>
                    <input class="form-control input-gral" id="nombreDelPermiso" type="text" readonly  name="nombreDelPermiso" value="${autorizaciones[i].colaborador}">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                    <label class="control-label">Ultima Actualizacion</label>
                    <input class="form-control input-gral" id="pa" type="text"   name="pagoDescuento"  value="${autorizaciones[i].fecha_modificacion}">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="toggle-button-cover control-label">
                        <div class="button r" id="button-3">
                            <input type="checkbox" id="autorizacionBandera_${autorizaciones[i].id_autorizacion}" 
                            onclick="kj(${autorizaciones[i].id_autorizacion})" class="checkbox autorizacionBandera" />
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div>
                </div>`
                ;

                }
             
                document.getElementById("autorizaciones").innerHTML = html;
                for(var e = 0; e < autorizaciones.length ; e++) {
                    if(autorizaciones[e].bandera == 0){
                        $("#autorizacionBandera_"+autorizaciones[e].id_autorizacion).prop('checked', true);
                       
                    }else if(autorizaciones[e].bandera == 1){
                        $("#autorizacionBandera_"+autorizaciones[e].id_autorizacion).prop('checked', false);
                      
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




