<div>
    <div class="wrapper">
        <?php
        /*-------------------------------------------------------*/
$datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;  
            $this->load->view('template/sidebar', $datos);

            $idDoc=0;
     //       echo var_dump($opn_cumplimiento);
 /*--------------------------------------------------------*/
            /*$dato= array(
                'actualizaPrecio' => 0,
                'actualizaReferencia' => 0,
                'acuserecibidos' => 0,
                'altaCluster' => 0,
                'altaLote' => 0,
                'aparta' => 0,
                'autorizacionesReport' => 0,
                'clubMaderasReport' => 0,
                'asesores' => 0,
                'autorizacion' => 0,
                'cambiarAsesor' => 0,
                'comhistorial' => 0,
                'comnuevas' => 0,
                'consulta12Status' => 0,
                'asignarVentas' => 0,
                'consulta9Status' => 0,
                'contrato' => 0,
                'coOwners' => 0,
                'corrida' => 0,
                'corridaF' => 0,
                'corridasElaboradas' => 0,
                'consDepositoSeriedad' => 0,
                'asignarVentas' => 0,
                'disponibles' => 0,
                'documentacion' => 0,
                'DS' => 0,
                'DSConsult' => 0,
                'enviosRL' => 0,
                'estatus10' => 0,
                'estatus10Report' => 0,
                'estatus12' => 0,
                'estatus13' => 0,
                'estatus14' => 0,
                'estatus15' => 0,
                'estatus2' => 0,
                'estatus20' => 0,
                'estatus5' => 0,
                'estatus6' => 0,
                'estatus7' => 0,
                'estatus8' => 0,
                'estatus9' => 0,
                'expediente' => 0,
                'expedientesIngresados' => 0,
                'expRevisados' => 0,
                'gerentesAsistentes' => 0,
                'histComisiones' => 0,
                'historialPagos' => 0,
                'home' => 0,
                'integracionExpediente' => 0,
                'inventario' => 0,
                'inventarioDisponible' => 0,
                'liberacion' => 0,
                'listaCliente' => 0,
                'lotes45dias' => 0,
                'lotesContratados' => 0,
                'manual' => 0,
                'nuevasComisiones' => 0,
                'pagosCancelados' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'prospectosMktd' => 0,
                'rechazoJuridico' => 0,
                'references' => 0,
                'sharedSales' => 0,
                'status11' => 0,
                'status14' => 0,
                'status3' => 0,
                'status7' => 0,
                'status8' => 0,
                'ultimoStatus' => 0,
                'usuarios' => 0,
                'altaUsuarios' => 0,
                'listaUsuarios' => 0,
                'autoriza'=> 0,
                'bulkload' => 0,
                'mkt_digital' => 0,
                'prospectPlace' => 0,
                'documentacionMKT' => 0,
                'inventarioMKT' => 0,
                'clientsList' => 0,
                'documentacion_ds' => 0,
                'historialpagos' => 0,
                'tablaPorcentajes' => 0,
                'DSContraloriaSU' => 0,
                'carpetaPdf' => 0,
                'busquedaDetallada' => 0
            );
        $this->load->view('template/sidebar', $dato);*/

        ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title">Configura tu perfil</h4>
                                                <div class="table-responsive">
                                                    <form name="my_personal_info_form" id="my_personal_info_form" class="col-md-10 col-md-offset-1" >

                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Nombre</label>
                                                                <input id="name" name="name" type="text" class="form-control" value="<?= $nombre ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Apellido paterno</label>
                                                                <input id="last_name" name="last_name" type="text" class="form-control" value="<?= $apellido_paterno ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Apellido materno</label>
                                                                <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control" value="<?= $apellido_materno ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">RFC</label>
                                                                <input id="rfc" name="rfc" type="text" class="form-control" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?= $rfc ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Correo electrónico</label>
                                                                <input id="email" name="email" type="email" class="form-control" value="<?= $correo ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Teléfono celular</label>
                                                                <input id="phone_number" name="phone_number" type="number" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?= $telefono ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Nombre de usuario</label>
                                                                <input id="username" name="username" type="text" class="form-control" disabled value="<?= $usuario ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Contraseña</label>
                                                                <input id="contrasena" name="contrasena" type="password" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  value="<?= $contrasena ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="checkbox" onclick="showPassword()" style="margin-top: 60px">Mostrar contraseña
                                                                <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $id_usuario ?>">
                                                            </div>
                                                        </div>



                                                        <div class="row">




                                                         <?php

                                                            if($this->session->userdata('forma_pago')==2){ ?>



                                                        <div class="col-md-6">
                                                            <?php if(count($opn_cumplimiento) == 0){?>
                                                                <div class="input-group">
                                                                    <label class="input-group-btn">
                                                                        <span class="btn btn-warning btn-file update" data-id_usuario="<?=$this->session->userdata('id_usuario')?>">
                                                                            Subir opinión cumplimiento&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <input type="text" class="form-control" id= "txtexp" readonly>
                                                                    </div> <?php } else {
                                                                        if($opn_cumplimiento[0]['estatus'] == 1){
                                                                            $idDoc=$opn_cumplimiento[0]["id_opn"];
                                                                            echo '<p><b style="color:#4068AB;">Opinión SAT de este mes cargada con éxito</b></p>';
                                                                            echo '<a href="#" class="btn btn-info btn-round btn-fab btn-fab-mini verPDF" title="Opinión de cumplimiento sin cargar"  style="margin-right:5px;" data-usuario="'.$opn_cumplimiento[0]["archivo_name"].'" ><i class="material-icons">description</i></a>';
                                                                            echo '<button type="button" class="btn btn-danger btn-round btn-fab btn-fab-mini DelPDF" data-toggle="modal" data-target="#Aviso2"  title="Borrar"><i class="material-icons">delete</i></button>';
                                                                        }else if($opn_cumplimiento[0]['estatus'] == 0){
                                                                            ?>
                                                                            <div class="input-group"  >
                                                                                <label class="input-group-btn"  >
                                                                                    <span class="btn btn-warning btn-file update" data-id_usuario="<?=$this->session->userdata('id_usuario')?>">
                                                                            Subir opinión cumplimiento&hellip;
                                                                        </span>
                                                                                </label>
                                                                                <input type="text" class="form-control" id= "txtexp" readonly>
                                                                                </div> <?php
                                                                            }else if($opn_cumplimiento[0]['estatus'] == 2){
                                                                                ?>
                                                                                <p style="color: #02B50C;">Opinión del SAT bloqueda, ya hay facturas cargadas.</p>
                                                                                <?php
                                                                            }
                                                                        }?>
                                                        </div> 

                                                          <?php } ?>








                                                            <div class="col-md-4 col-md-offset-4">
                                                                <button type="submit" class="btn btn-primary btn-block" >Actualizar</button>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!------->
 
            <!-- modal  INSERT FILE-->
             
<!------->


    <div class="modal fade modal-alertas" id="addFile" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="card-title"><b>Cargar opinión cumplimiento SAT</b></h4>
                </div>
                 <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                    <div class="modal-body">

                        <p>Recuerda que tu opinión de cumplimiento debe ser <b> POSITIVA </b> y una vez cargadas tus facturas no podrás remplazar este archivo, si requieres modificarla te recomendamos que sea <u>antes de cargar una factura</u>.</p>

  
                      <center><div class="input-group">
                         <label  class="input-group-btn">
                        </label>
                        <span class="btn btn-info btn-file">
                            <i class="fa fa-cloud-upload"></i> Subir archivo
                            <input id="file-uploadE" name="file-uploadE" required  accept="application/pdf" type="file" / >
                        </span>
                        <p id="archivoE"></p>
                    </div></center>
 
                    <div class="form-group">

              <center>
                <button type="submit" id="sendFile" class="btn btn-primary">GUARDAR</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
              </center>
          </div>



                    </div>

                </form>
            </div>
        </div>
    </div>

<!-- 

<div class="modal fade" id="addFile" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header" style="padding:0%">
                <button type="button" class="close" style="font-size: 40px;padding-right:10px;"  data-dismiss="modal" >&times;</button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                         <label  class="input-group-btn">
                        </label>
                        <span class="btn btn-info btn-file">
                            <i class="fa fa-cloud-upload"></i> Subir archivo
                            <input id="file-uploadE" name="file-uploadE" required  accept="application/pdf" type="file" / >
                        </span>
                        <p id="archivoE"></p>
                    </div>
                </div>

                <div class="modal-footer">
                    <center>
                        <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</div> -->



<div class="modal fade" id="Aviso" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content" >
                        <div class="modal-header" style="padding:0%">
                            <button type="button" class="close" style="font-size: 40px;padding-right:10px;" onclick="Recargar();"  data-dismiss="modal" >&times;</button>
                        
                        </div>
                        <div class="modal-body">

                        <h5 class="msj">
                        </h5>
                </div>
            </div> 

            </div>
</div>

<!-- <div class="modal fade" id="Aviso2" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content" >
                        <div class="modal-header" style="padding:0%">
                            <button type="button" class="close" style="font-size: 40px;padding-right:10px;"  data-dismiss="modal" >&times;</button>
                        
                        </div>
                        <div class="modal-body">
                        <center>
                        <h5>
                        ¿Estas seguro que deseas eliminar este archivo?
                        </h5>
                        <form id="formDelete">
                            <input type="hidden" value="<?=$idDoc?>" name="idDoc" id="idDoc">

                            <div class="form-group">
                            <button type="submit" class="btn btn-success">Aceptar</button>
                            </div>
                        </form>
                        </center>
                        
                </div>
            </div> 

            </div>
</div>

 -->
<div class="modal fade bd-example-modal-sm" id="Aviso2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header bg-red">
                    <h4 class="card-title"><b>Eliminar Opinión SAT</b></h4>
                </div>
      <div class="modal-body">
          <form id="formDelete">
 
                        <p>¿Estas seguro de eliminar este archivo?</p>

                            <input type="hidden" value="<?=$idDoc?>" name="idDoc" id="idDoc">

                            <div class="form-group">
                            <center><button type="submit" class="btn btn-danger">Eliminar</button></center>
                            </div>
                        </form>

      </div>
    </div>
  </div>
</div>



<!------>



        <?php $this->load->view('template/footer_legend');?>


</body>

<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script type="text/javascript">
    Shadowbox.init();

</script>
<script>
let url = "<?=base_url()?>";
$("#file-uploadE").on('change', function(e){  
    $('#archivoE').val('');      
 v2 = document.getElementById("file-uploadE").files[0].name; 
 document.getElementById("archivoE").innerHTML = v2;
});
$(document).on("click", ".update", function(e){

e.preventDefault();
$('#archivoE').val('');

var id_usurio = $(this).attr("data-id_usuario");

$('#addFile').modal('show');
console.log('alcuishe');

});

function Recargar(){
    $("#Aviso").modal('hide');
    setTimeout('document.location.reload()',10);  
}
$("#EditarPerfilForm").one('submit', function(e){ 
    document.getElementById('sendFile').disabled =true; 
    $("#sendFile").prop("disabled", true);
            e.preventDefault(); 

       var formData = new FormData(document.getElementById("EditarPerfilForm"));
formData.append("dato", "valor");   

             $.ajax({
        type: 'POST',
        url: url+'index.php/Usuarios/SubirPDF',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            document.getElementById('sendFile').disabled =false;
                 $("#sendFile").prop("disabled", false);
            if (data == 1) {
                 $("#addFile").modal('hide'); 
                 // $("#Aviso .msj").append('Una vez que haya cargado sus factura, ya no podrá modificar su opinión de cumplimiento en caso de ser errónea. por favor revise si el archivo seleccionado fue el correcto.');
                 setTimeout('document.location.reload()',10);                
                 alerts.showNotification("top", "right", "Opinión de cumplimiento cargada con éxito.", "success");
               
               
            } else {
                 $("#addFile").modal('hide'); 
    
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
             $("#addFile").modal('hide'); 
  
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    
});



$(document).on('click', '.verPDF', function () {
        var $itself = $(this);
        Shadowbox.open({
            /*verPDF*/
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cumplimiento/'+$itself.attr('data-usuario')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
            width:      985,
            height:     660

        });
    });
    $("#formDelete").on('submit', function(e){ 
            e.preventDefault(); 

       var formData = new FormData(document.getElementById("formDelete"));
formData.append("dato", "valor");   

             $.ajax({
        type: 'POST',
        url: url+'index.php/Usuarios/UpdatePDF',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
    
            if (data == 1) {
                 $("#Aviso2").modal('hide'); 
                  setTimeout('document.location.reload()',10);
                alerts.showNotification("top", "right", "El archivo se eliminó exitosamente.", "success");
          
               
            } else {
                 $("#addFile").modal('hide'); 
    
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
       
  
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    
});
    
</script>
</html>
