<body>
<div class="wrapper">

<?php $this->load->view('template/sidebar'); ?>



<style type="text/css">
		::-webkit-input-placeholder { /* Chrome/Opera/Safari */
			color: white;
			opacity: 0.4;

		::-moz-placeholder { /* Firefox 19+ */
			color: white;
			opacity: 0.4;
		}

		:-ms-input-placeholder { /* IE 10+ */
			color: white;
			opacity: 0.4;
		}

		:-moz-placeholder { /* Firefox 18- */
			color: white;
			opacity: 0.4;
		}
		}
        .msj{
            z-index: 9999999;
        }

        .bkLoading
{
   /* background:#000; *//*b3b3b3*/
   background-image: linear-gradient(to bottom, #000, #000);
   position:absolute;
   top:0%;
   left:0%;
   width:100%;
   height:100%;
   z-index:99999;
   padding-top:200px;
   color:white;
   font-weight:300;
   opacity: 0.5;


   /* display:none; */
}

.lds-dual-ring.hidden {
    display: none;
}
.lds-dual-ring {
    display: inline-block;
    width: 80px;
    height: 80px;
}
.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 5% auto;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: #fff transparent #fff transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background-color: #56A7D1;
    z-index: 9999999;
    opacity: 0.4;
    transition: all 0.5s;
    display: flex;
    align-items: center;
}
@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
	</style>



	<!--<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

				<form method="post" id="form_espera_uno">
					<div class="modal-body"></div>
					<div class="modal-footer"></div>
				</form>
			</div>
		</div>
	</div>-->


    <!--<div class="modal fade modal-alertas" id="modal-delete" role="dialog" data-backdrop="static">
		<div class="modal-dialog modal-sm">
			<div class="modal-content" >
          
			
					<div class="modal-body"></div>
					<div class="modal-footer"></div>
				
                
			</div>
		</div>
	</div>-->



 <!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header bg-red">
                <center><img src="<?php //echo base_url()?>static/images/preview.gif" width="250" height="200"></center>
            </div>

            <form method="post" id="form_aplicar">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->




	<div class="modal fade modal-alertas" id="miModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-red">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Descuentos</h4>
				</div>
				<form method="post" id="form_descuentos">
					<div class="modal-body">
                    
                    <div class="form-group">
                        <label class="label">Puesto del usuario</label>
                    <select class="selectpicker roles" name="roles" id="roles" required>
                        <option value="">----Seleccionar-----</option>
                        <option value="7">Asesor</option>
                        <!-- <option value="38">MKTD</option> -->
                        <option value="9">Coordinador</option>
                        <option value="3">Gerente</option>
                        <!-- <option value="2">Sub director</option>  
                        <option value="1">Director</option>  -->

                    </select>
                    </div>

           
                    <div class="form-group" id="users"><label class="label">Usuario</label>
                    <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                    </div>
                     
                     
                    <b id="cargando" style="color: black;"></b>
                    <b id="cargando2" style="color: red;"></b>

                    <div class="form-group" id="loteorigen"><label class="label">Lote origen</label>
                    <select id="idloteorigen" disabled  name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                    </div>



                    <b id="msj2" style="color: red;"></b>

                    <div class="form-group row">


                       <div class="col-md-6">
                       <div class="form-group" >
                       <label class="label">Monto disponible</label>
                       <input class="form-control" type="text" id="idmontodisponible" readonly required name="idmontodisponible" value=""></div>
                        <div id="montodisponible">

                        </div>   
                    </div>


                       <div class="col-md-6">
                       <div class="form-group">
                       <label class="label">Monto a descontar</label>
                        <input class="form-control" type="text" id="monto" readonly="readonly" name="monto" value="">
                        </div>
                        </div>
 

                    </div>

                    <div class="form-group">

                        <label class="label">Mótivo de descuento</label>
                        <textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea>
                        
                    </div>

                    <div class="form-group">

                  <center>
                  <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>

                  </center>
                    </div>

                    </div>
				</form>
			</div>
		</div>
	</div>



    <!--<div class="modal fade modal-alertas" id="modal_descuentos" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_descuentos">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>-->

   
<div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <center><img src="<?=base_url()?>static/images/preview.gif" width="250" height="200"></center>

                

            </div>
            <form method="post" id="form_abono">
                <div class="modal-body"></div>
                <div class="modal-footer">

                </div>
            </form>
            
        </div>
    </div>
</div>

	<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body"></div>
			</div>
		</div>
	</div>-->



<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                 <div class="card-content">
                                    <div class="material-datatables">
                                    <div class="tab-pane active" id="factura-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <h4 class="card-title" ><b>DESCUENTOS DE COMISIONES</b></h4>
                                                                    <!-- <p class="category">Comisiones solictadas por colaboradores para proceder a pago sin factura.</b></p> -->
                                                                    <p class="category"><i class="material-icons">info</i> Descuentos aplicados a usuarios, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Nueva, sin solicitar'.</p>

                                                                </div>

                                                            </div>

                                                            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12 "> <br>
                                                            <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                            <label style="color: #0a548b;">&nbsp;Total descuentos aplicados: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totalpv" id="totalp"></label>
                                                            </div>
                                                            
                                                            <div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3 text-right">
                                                            <button ype="button" class="btn btn-primary " data-toggle="modal" data-target="#miModal">DESCUENTO UNIVERSIDAD</button>
                                                            </div>
                                                           
                                                            </div>

                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_descuentos" name="tabla_descuentos" style="font-size: .8em;">
                                                                                 <thead>
                                                                                 <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">USUARIO</th>
																							<th style="font-size: .9em;">$ DESCUENTO</th>
                                                                                            <th style="font-size: .9em;">LOTE</th>
                                                                                            <th style="font-size: .9em;">MOTIVO</th>
                                                                                            <th style="font-size: .9em;">ESTATUS</th>
                                                                                            <th style="font-size: .9em;">CREADO POR</th>
																							<th style="font-size: .9em;">FECHA CAPTURA</th>
																							<!-- <th style="font-size: .9em;">OPCIONES</th> -->
																						</tr>
                                                                                </thead>
                                                                            </table>
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
                            </div>
                        </div>
                    </div>
                </div>


<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
<div id="loaderDiv" class="lds-dual-ring hidden overlay">
    <b>Guardando...</b>
</div>

</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<link href="<?=base_url()?>dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>dist/js/controllers/select2/select2.min.js"></script>-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
	var url = "<?=base_url()?>";
	var url2 = "<?=base_url()?>index.php/";
	var totaPen = 0;
    var tr;
    

    function formato(texto){
  return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
}

    function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
    }


    $("#form_descuentos").on('submit', function(e){ 
        $('#idloteorigen').removeAttr('disabled');
        $('#loaderDiv').removeClass('hidden');

        e.preventDefault();
    let formData = new FormData(document.getElementById("form_descuentos"));
formData.append("dato", "valor");
    $.ajax({
        url: 'saveDescuento/'+3,
        data: formData,
        method: 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#loaderDiv').addClass('hidden');
                document.getElementById('cargando').innerHTML = '';
         document.getElementById('cargando2').innerHTML = '';
                document.getElementById("form_descuentos").reset();
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                //$("#idloteorigen").val(null).trigger('change');
               // $("#idloteorigen").trigger('change');
               // document.getElementById('idloteorigen').value = '';
               $('#idloteorigen option').remove();
               // $(".directorSelect2").val('');
                $("#roles").val('');
                $("#roles").selectpicker("refresh");
                $('#usuarioid').val('default');
                $("#usuarioid").selectpicker("refresh");

                alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
        
            	
               
            } else if(data == 2) {
                $('#loaderDiv').addClass('hidden');
                document.getElementById('cargando').innerHTML = '';
         document.getElementById('cargando2').innerHTML = '';
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                $(".directorSelect2").empty();
              
            }else if(data == 3){
                document.getElementById('cargando').innerHTML = '';
         document.getElementById('cargando2').innerHTML = '';
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                $(".directorSelect2").empty();
           
            }
            $('#idloteorigen').attr('disabled','true');

        },
        error: function(){
            $('#loaderDiv').addClass('hidden');
            document.getElementById('cargando').innerHTML = '';
         document.getElementById('cargando2').innerHTML = '';
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#idloteorigen').attr('disabled','true');


        }
    });
});




 



	$("#tabla_descuentos").ready( function(){

        let titulos = [];

      $('#tabla_descuentos thead tr:eq(0) th').each( function (i) {
 if(i!=8){
  var title = $(this).text();
  titulos.push(title);

  //titulos.push(title);

  $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
  $( 'input', this ).on('keyup change', function () {

      if (tabla_nuevas.column(i).search() !== this.value ) {
        tabla_nuevas
          .column(i)
          .search(this.value)
          .draw();

          var total = 0;
          var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
          var data = tabla_nuevas.rows( index ).data();

          $.each(data, function(i, v){
              total += parseFloat(v.monto);
          });
          var to1 = formatMoney(total);
          document.getElementById("totalp").value = total;
          console.log('fsdf'+total);
      }
  } );
}
});

$('#tabla_descuentos').on('xhr.dt', function ( e, settings, json, xhr ) {
              var total = 0;
              $.each(json.data, function(i, v){
                  total += parseFloat(v.monto);
              });
              var to = formatMoney(total);
              document.getElementById("totalp").value = to;
          });
 
		tabla_nuevas = $("#tabla_descuentos").DataTable({
            dom: 'Brtip',
    width: 'auto',
    "buttons": [

{
    extend:    'excelHtml5',
    text:      'Excel',
    titleAttr: 'Excel',
    title: 'DESCUENTOS_UNIVERSIDAD',
    exportOptions: {
  
  columns: [0,1,2,3,4,5,6,7],
  format: {
     header:  function (d, columnIdx) {
         if(columnIdx == 0){
            return 'ID';
            
            }else if(columnIdx == 1){
                return 'USUARIO';
            }else if(columnIdx == 2){
                return 'MONTO DESCUENTO';
            }else if(columnIdx == 3){
                return 'NOMBRE LOTE';
            }else if(columnIdx == 4){
                return 'MOTIVO';
            }else if(columnIdx == 5){
                return 'ESTATUS';
            }else if(columnIdx == 6){
                return 'CREADO POR';
            }else if(columnIdx == 7){
                return 'FECHA CAPTURA';
            }

        }
    }
},

     attr: {
             class: 'btn btn-success',
          }
 },


 ],
            width: 'auto',
            "ordering": false,
           
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
			"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
		
			"columns": [

				{
					"width": "4%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>'+d.id_pago_i+'</center></p>';
					}
                },
                {
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center><b>'+d.usuario+'</b></center></p>';
					}
                },

				{
					"width": "3%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center><b>$'+formatMoney(d.monto)+'</b></center></p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<p style="font-size: .7em"><center>'+d.nombreLote+'</center></p>';
					}
                },
                {
					"width": "25%",
					"data": function( d ){
						return '<p style="font-size: .8em"><center>'+d.motivo+'</center></p>';
					}
				},
				{
					"width": "5%",
					"data": function( d ){
                        if(d.estatus == 17 || d.estatus == '17'){
                            return '<center><span class="label label-success">APLICADO</span><center>';	
                        }else{
                            return '<center><span class="label label-warning">CANCELADO</span><center>';	
                        }
                        
					}
                },
                {
					"width": "7%",
					"data": function( d ){
                        return '<p style="font-size: .7em"><center>'+d.modificado_por+'</center></p>';
					}
				},
				{
					"width": "7%",
					"data": function( d ){
                        let fecha = d.fecha_abono.split('.');
                        let fecha2 = fecha[0].split(' ');
                        let newfecha = formato(fecha2[0]);
						return '<p style="font-size: .8em"><center>'+newfecha+' '+fecha2[1]+'</center></p>';
					}
				},
				// {
				// 	"width": "8%",
				// 	"orderable": false,
				// 	"data": function( d ){

                      
                            
                //             return '<button class="btn btn-success btn-round btn-fab btn-fab-mini btn-update" value="'+d.id_pago_i+','+d.monto+','+d.usuario+','+d.nombreLote+'"  style="margin-right: 3px;background-color:#20A117;border-color:#20A117"><i class="material-icons" data-toggle="tooltip" data-placement="right" title="APROBAR DESCUENTO">check</i></button>';
                            
                //     }
				// }
            ],
                columnDefs: [
          {

  orderable: false,
  className: 'select-checkbox',
  targets:   0,
  'searchable':false,
  'className': 'dt-body-center'
  }],

			"ajax": {
				"url": url2 + "Comisiones/getdescuentos2",
				/*registroCliente/getregistrosClientes*/
				"type": "POST",
				cache: false,
				"data": function( d ){

                }
            },
		});

 
/**------------------------------------------- */
        $("#tabla_descuentos tbody").on("click", ".abonar", function(){    
            bono = $(this).val();
            var dat = bono.split(",");
            //$("#modal_abono").html("");
            $("#modal_abono .modal-body").append(`<div id="inputhidden">
            <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">$${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6>
            <input type='hidden' name="id_bono" id="id_bono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}"><input type='hidden' name="id_usuario" id="id_usuario" value="${dat[2]}">
           
           <div class="col-md-3"></div>
           <div class="col-md-3">
            <button type="submit" id="" class="btn btn-primary ">GUARDAR</button>
            </div>
            <div class="col-md-3">
            <button type="button" onclick="closeModalEng()" class=" btn btn-danger" data-dismiss="modal">CANCELAR</button>
            </div>
            <div class="col-md-3"></div>

            </div>`);
            $("#modal_abono .modal-body").append(``);
            $('#modal_abono').modal('show');
            //save(bono);
        });



        /*$("#tabla_descuentos tbody").on("click", ".btn-delete", function(){
            id = $(this).val();
            $("#modal-delete .modal-body").append(`<div id="borrarBono"><form id="form-delete">
            <h5>¿Estas seguro que deseas eliminar este bono?</h5>
            <br>
            <input type="hidden" id="id_descuento" name="id_descuento" value="${id}">
            <input type="submit" class="btn btn-success" value="Aceptar">
            <button class="btn btn-danger" onclick="CloseModalDelete2();">Cerrar</button>
            </form></div>`);

            $('#modal-delete').modal('show');
        });*/


         /*$("#tabla_descuentos tbody").on("click", ".btn-update", function(){
    var tr = $(this).closest('tr');
    var row = tabla_nuevas.row( tr );

    id_pago_i = $(this).val();

    $("#modal_nuevas .modal-body").html("");
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Seguro que desea descontar a <b>'+row.data().usuario+'</b> la cantidad de <b style="color:red;">$'+formatMoney(row.data().monto)+'</b> correspondiente al lote <b>'+row.data().nombreLote+'</b> ?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_pago_i+'"><br><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></p></div></div>');
    $("#modal_nuevas").modal();
});*/





        //  $("#tabla_descuentos tbody").on("click", ".btn-update", function(){    
        //     id = $(this).val();

        //      bono = $(this).val();
        //     var dat = bono.split(",");

        //      $("#modal_abono .modal-body").append(`<div id="borrarUpdare"><form id="form-update">
        //     <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">$${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6><input type='hidden' name="id_descuento" id="id_descuento" value="${dat[0]}">
        //     <br>
        //      <input type="submit" class="btn btn-success" value="Aceptar">
        //     <button class="btn btn-danger" onclick="CloseModalUpdate2();">Cerrar</button>
        //     </form></div>`);
 
        //     $('#modal_abono').modal('show');
        // });

 



    });


/**-------------------------------------------------------------------------------------------------------------------------------------------------------- */



    function closeModalEng(){
       // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form_abono").reset();
        a = document.getElementById('inputhidden');
        padre = a.parentNode;
		padre.removeChild(a);
     
    $("#modal_abono").modal('toggle');
    
}

/*function CloseModalDelete(){
       // document.getElementById("inputhidden").innerHTML = "";
        a = document.getElementById('borrarBono');
        padre = a.parentNode;
		padre.removeChild(a);
     
    $("#modal-delete").modal('toggle');
    
}*/
/*function CloseModalDelete2(){
       // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form-delete").reset();
        a = document.getElementById('borrarBono');
        padre = a.parentNode;
		padre.removeChild(a);
     
    $("#modal-delete").modal('toggle');
    
}*/

/*function CloseModalUpdate2(){
       // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form-update").reset();
        a = document.getElementById('borrarUpdare');
        padre = a.parentNode;
		padre.removeChild(a);
     
    $("#modal-abono").modal('toggle');
    
}*/
/*$(document).on('submit','#form-delete', function(e){
  e.preventDefault();
var formData = new FormData(document.getElementById("form-delete"));
formData.append("dato", "valor");
    $.ajax({
        method: 'POST',
        url: url+'Comisiones/BorrarDescuento',
        data: formData,
        processData: false,
contentType: false,
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                CloseModalDelete2();
               // $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Abono borrado con exito.", "success");
            	document.getElementById("form_abono").reset();
               
            } else if(data == 0) {
                $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                CloseModalDelete2();
                //$('#modal-delete').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            }
        },
        error: function(){
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});*/





/*$("#form_aplicar").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            // url: url + "Comisiones/pausar_solicitud/",
            url: url+'Comisiones/UpdateDescuento',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data = 1 ){
                        $("#modal_nuevas").modal('toggle' );
                        alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                        setTimeout(function() {
                            tabla_nuevas.ajax.reload();
                            // tabla_otras2.ajax.reload();
                        }, 3000);
                    }else{
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
    }
});*/




// $(document).on('submit','#form-update', function(e){ 
//   e.preventDefault();
// var formData = new FormData(document.getElementById("form-update"));
// formData.append("dato", "valor");
//     $.ajax({
//         method: 'POST',
//         url: url+'Comisiones/UpdateDescuento',
//         data: formData,
//         processData: false,
// contentType: false,
//         success: function(data) {
//             console.log(data);
//             if (data == 1) {
//                 $('#tabla_descuentos').DataTable().ajax.reload(null, false);
//                 CloseModalDelete2();
//                // $('#modal_abono').modal('hide');
//                 alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
//             	document.getElementById("form_abono").reset();
               
//             } else if(data == 0) {
//                 $('#tabla_descuentos').DataTable().ajax.reload(null, false);
//                 CloseModalDelete2();
//                 //$('#modal-delete').modal('hide');
//                 alerts.showNotification("top", "right", "Pago liquidado.", "warning");
//             }
//         },
//         error: function(){
//             closeModalEng();
//             $('#modal_abono').modal('hide');
//             alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
//         }
//     });
// });


 
	// FIN TABLA PAGADAS



	/*function mandar_espera(idLote, nombre) {
		idLoteespera = idLote;
		// link_post2 = "Cuentasxp/datos_para_rechazo1/";
		link_espera1 = "Comisiones/generar comisiones/";
		$("#myModalEspera .modal-footer").html("");
		$("#myModalEspera .modal-body").html("");
		$("#myModalEspera ").modal();
		// $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
		$("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
	}*/






	// FUNCTION MORE

	$(window).resize(function(){
		tabla_nuevas.columns.adjust();
		// tabla_proceso.columns.adjust();
		// tabla_pagadas.columns.adjust();
		// tabla_otras.columns.adjust();
	});

	function formatMoney( n ) {
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

/**.---------------------------ROLES------------------------------------------ */
    $("#roles").change(function() {
        var parent = $(this).val();
         document.getElementById('monto').value = ''; 
    	document.getElementById('idmontodisponible').value = ''; 
                 $("#idloteorigen").val('');
                $("#idloteorigen").selectpicker("refresh");
                $('#idloteorigen option').remove();

         document.getElementById('cargando').innerHTML = '';
         document.getElementById('cargando2').innerHTML = '';
         document.getElementById('comentario').value = ''; 


         // $("#idloteorigen").append($('<option disabled>').val("default").text("Seleccione una opción"))

         $('#usuarioid option').remove();
 
        $.post('getUsuariosRol2/'+parent, function(data) {
                        $("#usuarioid").append($('<option>').val("0").text("Seleccione una opción"));
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario']+','+data[i]['monto'];
                            var name = data[i]['name_user'];
                      
                            $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                           // $("#usuariosrol").val(v.id_director);
                        $("#usuarioid").selectpicker('refresh');
                    }, 'json'); 
    });


    /**----------------------------FIN ROLES------------------------------------------------------------- */
    $("#idloteorigen").select2({dropdownParent:$('#miModal')});
   // $("#idloteorigen").select2("readonly", true);
 /**-----------------------------LOTES----------------------- */   
    $("#usuarioid").change(function() {
       // document.getElementById('cargando').innerHTML ='';
        document.getElementById('cargando').innerHTML ='Cargando...';
        document.getElementById('cargando2').innerHTML ='';

    	document.getElementById('monto').value = ''; 
    	document.getElementById('idmontodisponible').value = ''; 
        $("#idloteorigen").val('');
                $("#idloteorigen").selectpicker("refresh");
                $('#idloteorigen option').remove();

        //  document.getElementById('cargando').innerHTML = '';
        //  document.getElementById('cargando2').innerHTML = '';
         document.getElementById('comentario').value = ''; 

         var user = $(this).val();
         let datos = user.split(',');
         $("#monto").val('$'+formatMoney(datos[1]));
         
         $('#idloteorigen option').remove(); // clear all values


        $.post('getLotesOrigen2/'+datos[0]+'/'+datos[1], function(data) {
                         $("#idloteorigen").append($('<option disabled>').val("default").text("Seleccione una opción"));
                        var len = data.length;
                        document.getElementById('cargando').innerHTML ='';
                        let sede = data[0]['id_sede'];
                        let maximo = 10000;
                        if(sede == 6){
maximo = 15000;
                        }
                            if(parseFloat(data[0]['suma']) <= maximo){
                                document.getElementById('cargando2').innerHTML = 'Total disponible: $'+formatMoney(data[0]['suma']);
                                document.getElementById('btn_abonar').disabled=true;

                            }else{
                                document.getElementById('btn_abonar').disabled=false;

                                document.getElementById('cargando').innerHTML = 'Total disponible: $'+formatMoney(data[0]['suma']);
let valores = '';
let sumaselected = 0;
                                for( var i = 0; i<len; i++)
                        {
                            var name = data[i]['nombreLote'];
                            var comision = data[i]['id_pago_i'];
                            let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];
 sumaselected = sumaselected + parseFloat(data[i]['comision_total']);
                            //$("#idloteorigen").attr('value',)
                          //  valores =  
                            $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)}' selected="selected">${name}  -   $${ formatMoney(comtotal.toFixed(2))}</option>`);
                        }
                        $("#idmontodisponible").val('$'+formatMoney(sumaselected));
                        verificar();

                            }
                        
                        if(len<=0)
                        {
                        $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                         $("#idloteorigen").selectpicker('refresh');
                    }, 'json'); 


                    
    });

/**------------------------------------------------------------------------------------------- */
    
    $("#idloteorigen").change(function() {

        let cuantos = $('#idloteorigen').val().length;
        let suma =0;
        //let ids = $('#idloteorigen').val();
      
      if(cuantos > 1){
    
        var comision = $(this).val();
       

       //alert(comision);
        //let ids = comision.split(',');
        for (let index = 0; index < $('#idloteorigen').val().length; index++) {
            datos = comision[index].split(',');
        let id = datos[0];
        let monto = datos[1];
           // var id = comision[index];
        document.getElementById('monto').value = ''; 

        $.post('getInformacionData/'+id+'/'+1, function(data) {

            var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
            var idecomision = data[0]['id_pago_i'];
           suma = suma + disponible;
           document.getElementById('montodisponible').innerHTML = '';
           $("#idmontodisponible").val('$'+formatMoney(suma));
            $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma.toFixed(2)+'">');
            $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                        var len = data.length;
                        if(len<=0)
                        {
                        $("#idmontodisponible").val('$'+formatMoney(0));
                        }
                         $("#montodisponible").selectpicker('refresh');
                    }, 'json');
        }
        console.log(suma);
      }else{
        var comision = $(this).val();
        datos = comision[0].split(',');
        let id = datos[0];
        let monto = datos[1];
        //alert(id+'-------'+monto);
        document.getElementById('monto').value = ''; 
        $.post('getInformacionData/'+id+'/'+1, function(data) {
            var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
            var idecomision = data[0]['id_pago_i'];
            document.getElementById('montodisponible').innerHTML = '';
             $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
            $("#idmontodisponible").val('$'+formatMoney(disponible));
            $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                        var len = data.length;
                        if(len<=0)
                        {
                        $("#idmontodisponible").val('$'+formatMoney(0));
                        }
                         $("#montodisponible").selectpicker('refresh');
                    }, 'json'); 
      }      
});
/**--------------------------------------------------------------------------------------------------------- */
    /*$("#numeroP").change(function(){
        let monto = parseFloat($('#monto').val());
        let cantidad = parseFloat($('#numeroP').val());
        let resultado=0;

        if (isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            $('#pago').val(resultado);
            document.getElementById('btn_abonar').disabled=true;
        }else{
            //console.log(monto);
            resultado = monto /cantidad;
 
            if(resultado > 0){
                document.getElementById('btn_abonar').disabled=false;
            $('#pago').val(formatMoney(resultado));
            }else{
                document.getElementById('btn_abonar').disabled=true;
            $('#pago').val(formatMoney(0));
            }
        }
    });*/
   
function verificar(){
   // let d = $('#valor_comision').val();
    let  d2 =  replaceAll($('#idmontodisponible').val(), ',','');
let disponiblefinal = replaceAll(d2, '$','');
    //let m1 = $('#monto').val();
    let  m =  replaceAll($('#monto').val(), ',','');
let montofinal = replaceAll(m, '$','');

let disponible = parseFloat(disponiblefinal);
let monto = parseFloat(montofinal);
console.log('disponible: '+disponible);
console.log('monto: '+monto);
    if(monto < 1 || isNaN(monto)){
        alerts.showNotification("top", "right", "No hay saldo disponible para descontar.", "warning");
        document.getElementById('btn_abonar').disabled=true; 
    }else{
                    if(parseFloat(monto) <= parseFloat(disponible) ){
                console.log('paso');
                        let cantidad = parseFloat($('#numeroP').val());
                        resultado = monto /cantidad;
                        $('#pago').val(formatMoney(resultado));
                        document.getElementById('btn_abonar').disabled=false;
                        console.log('OK');
                        let cuantos = $('#idloteorigen').val().length;
                        let cadena = '';
                        var data = $('#idloteorigen').select2('data')
                        for (let index = 0; index < cuantos; index++) {
                            let datos = data[index].id;
                            let montoLote = datos.split(',');
                            let abono_neo = montoLote[1];
                            if(parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1){                             
                                document.getElementById('msj2').innerHTML="El monto ingresado se cubre con la comisión "+data[index].text;
                        document.getElementById('btn_abonar').disabled=true; 
                        break;  
                            }
                            cadena = cadena+' , '+data[index].text;
                            document.getElementById('msj2').innerHTML='';
      
                        }
                        $('#comentario').val('Lotes involucrados en el descuento(universidad): '+cadena+'. Por la cantidad de: $'+formatMoney(monto));

                    // console.log(cadena);
                    }
                    //else {
                    else if(parseFloat(monto) > parseFloat(disponible) ){
                        alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");     
                        //document.getElementById('monto').value = ''; 
                        document.getElementById('btn_abonar').disabled=true; 
                    }
}
        
}

</script>
   

