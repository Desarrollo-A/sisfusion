<body>
<div class="wrapper">

	<?php


	/*if($this->session->userdata('id_rol')=="18")//contraloria
	{


		$dato= array(
			'home' => 0,
			'usuarios' => 0,
			'statistics' => 0,
			'manual' => 0,
			'aparta' => 0,
			'prospectos' => 0,
			'prospectosMktd' => 0,
			'prospectosAlta' => 0,
			'sharedSales' => 0,
			'coOwners' => 0,
			'references' => 0,
			'plazasComisiones'     => 1,
			'nuevasComisiones' => 0,
			'histComisiones' => 0,
			'bulkload' => 0
		);


		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else
	{
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);

	?>



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
	</style>



	<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

				<form method="post" id="form_espera_uno">
					<div class="modal-body"></div>
					<div class="modal-footer"></div>
				</form>
			</div>
		</div>
	</div>





	<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body"></div>
			</div>
		</div>
	</div>

      


	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="nav-center">
									
									</div>

									<div class="tab-content">

										<div class="tab-pane active" id="nuevas-1">
											<div class="content">
												<div class="container-fluid">
													<div class="row">
														<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="card">
																<div class="card-header">

																	<div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
																		<h4 class="card-title">BONOS SOLICITADOS</h4>
                                                                      
                                                                    </div>
                                                                    
                                                                    <label style="color: #0a548b;">&nbsp;Bonos activos<b>:</b> $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totalp" id="totalp"></label>


																</div>
																<div class="card-content">
																	<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<div class="material-datatables">
																			<div class="form-group">
																				<div class="table-responsive">
																					<table class="table table-responsive table-bordered table-striped table-hover" style="font-size: .7em;" id="tabla_bono_revision" name="tabla_bono_revision">
																						<thead>
																						<tr>
                                                                                        <th style="font-size: .9em;"></th>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                                <th style="font-size: .9em;">USUARIO</th>
                                                                                                    <th style="font-size: .9em;">PUESTO</th>
                                                                                                    <th style="font-size: .9em;">MONTO BONO</th>
                                                                                                    <th style="font-size: .9em;">ABONADO</th>
                                                                                                    <th style="font-size: .9em;">PENDIENTE</th>
                                                                                                    <th style="font-size: .9em;">TOTAL PAGOS</th>
                                                                                                    <th style="font-size: .9em;">PAGO INDIVIDUAL</th>
                                                                                                    <th style="font-size: .9em;">IMPUESTO</th>
                                                                                                    <th style="font-size: .9em;">TOTAL A PAGAR</th>
                                                                                                    <th style="font-size: .9em;">ESTATUS</th>
                                                                                                    <th style="font-size: .9em;">COMENTARIO</th>
                                                                                                    <th style="font-size: .9em;">FECHA DE REGISTRO</th>
                                                                                                    <th style="font-size: .9em;">OPCIONES</th>
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
					</div>
				</div>
			</div>
		</div>
    </div>
    
    <div class="modal fade modal-alertas" id="modal_bonos" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_bonos">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>

   
<div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <center><img src="<?=base_url()?>static/images/warning.png" width="300" height="300"></center>

                

            </div>
            <form method="post" id="form_abono">
                <div class="modal-body"></div>
                <div class="modal-footer">

                </div>
            </form>
        </div>
    </div>
</div>


	<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
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

<script>
	var url = "<?=base_url()?>";
	var url2 = "<?=base_url()?>index.php/";
	var totaPen = 0;
    var tr;
    



 /**------------------------------------------------------------------TABLA REVISONES-------------------------------- */
 $("#tabla_bono_revision").ready(function() {

$('#tabla_bono_revision thead tr:eq(0) th').each( function (i) {
if(  i!=13){
var title = $(this).text();

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
        total += parseFloat(v.pago);
    });
    var to1 = formatMoney(total);
    document.getElementById("totalp").value = total;
    console.log('fsdf'+total);
}
} );
}
});

$('#tabla_bono_revision').on('xhr.dt', function ( e, settings, json, xhr ) {
        var total = 0;
        $.each(json.data, function(i, v){
            total += parseFloat(v.pago);
        });
        var to = formatMoney(total);
        document.getElementById("totalp").value = to;
    });


tabla_nuevas = $("#tabla_bono_revision").DataTable({
    width: 'auto',
    "ordering": false,
           
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
    dom: 'Brtip',
   
    "buttons": [


{
    text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
    action: function(){

        if ($('input[name="idTQ[]"]:checked').length > 0 ) {
            var idbono = $(tabla_nuevas.$('input[name="idTQ[]"]:checked')).map(function () { return this.value; }).get();
// console.log(idbono);
// alert(idbono);
            $.get(url+"Comisiones/enviarBonosMex/"+idbono).done(function () {
                $("#myModalEnviadas").modal('toggle');
                tabla_nuevas.ajax.reload();
                $("#myModalEnviadas .modal-body").html("");
                $("#myModalEnviadas").modal();
                $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src='<?= base_url('dist/img/mktd.png')?>'><br><br><b><P style='color:#BCBCBC;'>BONOS ENVIADOS A INTERNOMEX CORRECTAMENTE.</P></b></center>");
            });
        }
    },
    attr: {
        class: 'btn bg-olive',
        style: 'background: #3D8E9F; position: relative; float: right;',
    }
},
   {
       extend:    'excelHtml5',
       text:      'Excel',
       titleAttr: 'Excel',
      exportOptions: {
          columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
          format: {
             header:  function (d, columnIdx) {
                
                if(columnIdx == 1){
                        return 'ID ';
                    }
                else if(columnIdx == 2){
                        return 'USUARIO ';
                    }else if(columnIdx == 3){
                        return 'ROL ';
                    }else if(columnIdx == 4){
                        return 'MONTO BONO';
                    }else if(columnIdx == 5){
                        return 'ABONDADO';
                    }else if(columnIdx == 6){
                        return 'PENDIENTE';
                    }
                    else if(columnIdx == 7){
                        return 'NÚMERO PAGO';
                    }else if(columnIdx == 8){
                        return 'PAGO INDIVIDUAL';
                    }else if(columnIdx == 9){
                        return 'ESTATUS';
                    }
                    else if(columnIdx == 10){
                        return 'IMPUESTO';
                    }
                    else if(columnIdx == 11){
                        return 'TOTAL APAGAR';
                    }
                    else if(columnIdx == 12){
                        return 'COMENTARIO';
                    }
                    else if(columnIdx == 13){
                        return 'FECHA';
                    }
                }
            }
        },

        attr: {
                class: 'btn btn-success',
             }
    },


    ],


    "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    },

    "columns": [
        {
            "width": "3%",
        },
        {
            "width": "3%",
            "data": function(d) {
                return '<p style="font-size: .8em"><center>' + d.id_pago_bono + '</center></p>';
            }
        },

        {
            "width": "7%",
            "data": function(d) {
                return '<p style="font-size: .8em"><center>' + d.nombre + '</center></p>';
            }
        },
        {
            "width": "7%",
            "data": function(d) {


                return '<p style="font-size: .8em"><center>'+d.id_rol+'</center></p>';


            }
        },
        {
            "width": "7%",
            "data": function(d) {
                return '<p style="font-size: .8em"><center>$' + formatMoney(d.monto) + '</center></p>';
            }
        },
        {
                    "width": "7%",
                    "data": function(d) {
                        let abonado = d.n_p*d.pago;
                        if(abonado >= d.monto -.30 && abonado <= d.monto +.30){
                            abonado = d.monto;
                        }else{
                            abonado =d.n_p*d.pago;
                        }
                        return '<p style="font-size: .8em"><center><b>$' + formatMoney(abonado) + '</b></center></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        let pendiente = d.monto - (d.n_p*d.pago);
                        if(pendiente < 1){
                            pendiente = 0;
                        }else{
                            pendiente = d.monto - (d.n_p*d.pago);
                        }
                        return '<p style="font-size: .8em"><center><b>$' + formatMoney(pendiente) + '</b></center></p>';
                    }
                },
                {
                    "width": "3%",
                    "data": function(d) {
                        return '<p style="font-size: .8em"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
                    }
                },
        {
            "width": "7%",
            "data": function(d) {
                return '<p style="font-size: .8em"><center>$' + formatMoney(d.pago) + '</center></p>';
            }
        },
        {
                    "width": "5%",
                    "data": function(d) {

                        if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                            return '<p style="font-size: .9em !important"><center><b>0%</b></center></p>';

                    }else{
                        return '<p style="font-size: .8em"><center><b>'+parseFloat(d.impuesto)+'%</b></center></p>';
                       

                    }
                        // return '<p style="font-size: .8em"><center><b>' +d.n_p+'</b>/'+d.num_pagos+ '</center></p>';
                    }
                },
        {
            "width": "7%",
            "data": function(d) {

                if(parseFloat(d.pago) == parseFloat(d.impuesto1)){
                    return '<p style="font-size: .8em"><center><b>$' + formatMoney(d.pago) + '</b></center></p>';


                    }else{

                        let iva = ((parseFloat(d.impuesto)/100)*d.pago);
                        let pagar = parseFloat(d.pago) - iva;
                        return '<p style="font-size: .8em"><center><b>$' + formatMoney(pagar) + '</b></center></p>';


                    }
                
            }
        },
        {
            "width": "7%",
            "data": function(d) {

                if (d.estado == 1) {
                    return '<center><span class="label label-danger" style="background:#27AE60">NUEVO</span><center>';
                } else if (d.estado == 2) {
                    return '<center><span class="label label-danger" style="background:#E3A13C">EN REVISIÓN</span><center>';
                } else if (d.estado == 3) {
                    return '<center><span class="label label-danger" style="background:#04B41E">PAGADO</span><center>';
                }
                else if (d.estado == 6) {
                    return '<center><span class="label label-danger" style="background:#065D7F">EVIADO A INTERNOMEX</span><center>';
                }


            }
        },
        {
            "width": "15%",
            "data": function(d) {
               
                return '<p style="font-size: .8em"><center>' + d.comentario + '</center></p>';
            }
        },
        {
            "width": "8%",
            "data": function(d) {
                let fecha = d.fecha_abono.split('.')
                return '<p style="font-size: .8em"><center>' + fecha[0] + '</center></p>';
            }
        },
        {
            "width": "6%",
            "orderable": false,
            "data": function(d) {

                if (d.estado == 2 || d.estado == 6) {
                    return '<button class="btn btn-default btn-round btn-fab btn-fab-mini consulta_abonos" value="' + d.id_pago_bono + ','+ d.nombre +' "  style="margin-right: 3px;background-color:#A1A1A1;border-color:#A1A1A1;margin:5px;"><i class="material-icons" style="font-size:24px;color:#fff;background:#A1A1A1;" data-toggle="tooltip" data-placement="right" title="HISTORIAL">info</i></button>';
                }




            } 
        }
    ],
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        'searchable':false,
        'className': 'dt-body-center',
        'render': function (d, type, full, meta){
            if(full.estado == 2){
                return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_bono + '">';

            }else{
                return '  <i class="material-icons">check</i>';
            }
          

        },
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
    }],
    "ajax": {
        "url": url2 + "Comisiones/getBonosPorUserContra/" + '2,6',
        /*registroCliente/getregistrosClientes*/
        "type": "POST",
        cache: false,
        "data": function(d) {

        }
    },
});

$("#tabla_bono_revision tbody").on("click", ".consulta_abonos", function() {

valores = $(this).val();
let nuevos = valores.split(',');
let id= nuevos[0];
let nombre=nuevos[1];
$.getJSON(url + "Comisiones/getHistorialAbono2/" + id).done(function(data) {


$("#modal_bonos .modal-header").html("");
$("#modal_bonos .modal-body").html("");
$("#modal_bonos .modal-footer").html("");


/*
$("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-2"><h6>Bono total: <b>$${formatMoney(data[0].monto)}</b></h6></div><div class="col-md-2"><h6>Pendiente: <b>$${formatMoney(pendiente)}</b></h6></div><div class="col-md-2"><h6>Bono mensual: <b>$${formatMoney(data[0].pago)}</b></h6></div><div class="col-md-2"><h6>Abonado: <b style="color:green;">${abonado}</b></h6></div><div class="col-md-3"><h6>Pagos: <b>${data.length} /${data[0].num_pagos}</b></h6></div></div>`);
$("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6><b>ABONO</b></h6></div><div class="col-md-3"><h6><b>FECHA DEL ABONO</b></h6></div><div class="col-md-3"><h6><b>NÚMERO DE PAGOS</b></h6></div><div class="col-md-3"><center><h6><b>ESTATUS</b></h6></center></div></div>`);
*/

let estatus = '';
    let color='';

        if(data[0].estado == 1){
            estatus=data[0].nombre;
            color='27AE60';
        }else if(data[0].estado == 2){
            estatus=data[0].nombre;
            color='E3A13C';
        }else if(data[0].estado == 3){
            estatus=data[0].nombre;
            color='04B41E';
        }else if(data[0].estado == 4){
            estatus=data[0].nombre;
            color='C2A205';
        }else if(data[0].estado == 5){
            estatus='CANCELADO';
            color='red';
        }
        else if(data[0].estado == 6){
            estatus='ENVIADO A INTERNOMEX';
            color='065D7F';
        }
    
       
        
    
    let f = data[0].fecha_abono.split('.');
    // let impuesto = parseFloat(data[0].impuesto);
    // let monto = parseFloat(data[0].abono);
    // let operacion = parseFloat(monto - ((impuesto/100)*monto));
    // data[0].abono = operacion;
    $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-3"><h6>PARA: <b>${nombre}</b></h6></div>
    <div class="col-md-3"><h6>Abono: <b style="color:green;">$${formatMoney(data[0].impuesto1)}</b></h6></div>
    <div class="col-md-3"><h6>Fecha: <b>${f[0]}</b></h6></div>
    <div class="col-md-3"><center><span class="label label-danger" style="background:#${color}">${estatus}</span><center></h6></div>
    </div>`);


    $("#modal_bonos .modal-body").append(`
    <br>
    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #71B85C;">
                            <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);

                    for (let index = 0; index < data.length; index++) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><b style="color:#896597">'+data[index].fecha+'</b><b style="color:gray;"> - '+data[index].nombreAu+'</b><br><i style="color:gray;">'+data[index].comentario+'</i></p><br></div>');

                        
                    }




/* $("#modal_bonos .modal-body").append(`<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>${data[0].monto}</i>: <b>$${formatMoney(data[0].monto)}</b></h3></div></div><br>`);*/




$("#modal_bonos").modal();
// console.log(data);

});

});
/**------------------------------------------- */
});
/**--------------------------------------------------------------------------------------------------------------------- */


/**-------------------------------------------------------------------------------------------------------------------------------------------------------- */



    function closeModalEng(){
       // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form_abono").reset();
        a = document.getElementById('inputhidden');
        padre = a.parentNode;
		padre.removeChild(a);
     
    $("#modal_abono").modal('toggle');
    
}


$("#form_abono").on('submit', function(e){ 
  
    e.preventDefault();
 var formData = new FormData(document.getElementById("form_abono"));
formData.append("dato", "valor");
            
    $.ajax({
        method: 'POST',
        url: url+'Comisiones/InsertAbono',
        data: formData,
        processData: false,
contentType: false,
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
            	document.getElementById("form_abono").reset();
               
            } else if(data == 2) {
                $('#tabla_prestamos').DataTable().ajax.reload(null, false);
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Pago liquidado.", "warning");
            }else if(data == 3){
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
            }
        },
        error: function(){
            closeModalEng();
            $('#modal_abono').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

        
    });
/*
function save(datos){

    var dat = datos.split(",");



    
    var parametros = {
        "id_bono": dat[0],
        "pago":dat[1],
        "id_usuario":dat[2]
    }

    var dataPost = 'id_bono='+dat[0]+'&pago='+dat[1]+'&id_usuario='+dat[2];

    $.ajax({
        url: url+'Comisiones/InsertAbono',
        data: dataPost,
        method: 'POST',
        dataType: 'html',
        success: function(data) {
            console.log(data);
            if (data == 1) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Abono registrado con exito.", "success");
                tabla_nuevas.ajax.reload();
            	document.getElementById("form_bonos").reset();
               
            } else if(data == 2) {
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
            }else if(data == 3){
                $('#miModal').modal('hide');
                alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
            }
        },
        error: function(){
            $('#miModal').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}
*/
	//FIN TABLA NUEVA


	// FIN TABLA PAGADAS



	function mandar_espera(idLote, nombre) {
		idLoteespera = idLote;
		// link_post2 = "Cuentasxp/datos_para_rechazo1/";
		link_espera1 = "Comisiones/generar comisiones/";
		$("#myModalEspera .modal-footer").html("");
		$("#myModalEspera .modal-body").html("");
		$("#myModalEspera ").modal();
		// $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
		$("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
	}






	// FUNCTION MORE

	$(window).resize(function(){
		tabla_nuevas.columns.adjust();
		tabla_proceso.columns.adjust();
		tabla_pagadas.columns.adjust();
		tabla_otras.columns.adjust();
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


    $("#roles").change(function() {
        var parent = $(this).val();

        document.getElementById("users").innerHTML ='';

        $('#users').append(` 
        <label class="label">Usuario</label>   
        <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true">
        </select>
        `);
        $.post('getUsuariosRol/'+parent, function(data) {
                        $("#usuarioid").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
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

    $("#numeroP").change(function(){
        let monto = parseFloat($('#monto').val());
        let cantidad = parseFloat($('#numeroP').val());
        let resultado=0;

        if (isNaN(monto)) {
            alert('Debe ingresar un monto valido');
            $('#pago').val(resultado);
        }else{
            //console.log(monto);
        resultado = monto /cantidad;

        $('#pago').val(formatMoney(resultado));
        }
     

});




</script>
   

