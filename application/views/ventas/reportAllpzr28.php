
<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>
    <!--Contenido de la página-->

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

    #modal_nuevas{
        z-index: 1041!important;
    }

    #modal_vc{
        z-index: 1041!important;
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
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0,0,0,.8);
    z-index: 9999999;
    opacity: 1;
    transition: all 0.5s;
}


</style>


	<div class="content">
        <div class="container-fluid">
 
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
 
                        <div class="card-content">
                            <h3 class="card-title center-align"><b>Reporte comisiones Asesores</b></h3>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
									<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_ingresar_9" name="tabla_ingresar_9" style="text-align:center;">

								        <thead>
                                            <tr>
											    <!-- <th></th> -->
                                                <th style="font-size: .9em;">ID LOTE</th>
												<th style="font-size: .9em;">PROYECTO</th>
												<th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">COLABORADOR</th>
                                                <th style="font-size: .9em;">COMISIÓN</th>
                                                <th style="font-size: .9em;">ABONADO</th>
                                                <th style="font-size: .9em;">PENDIENTE</th>
                                                <!-- <th style="font-size: .9em;">TIPO VENTA</th> -->
                                                 <th style="font-size: .9em;">MODALIDAD</th>
                                                <th style="font-size: .9em;">EST. CONTRATACIÓN</th> 
                                                <!-- <th style="font-size: .9em;">ESTATUS</th> -->
                                                <th style="font-size: .9em;">MÁS</th>
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



<div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_pagadas">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>


<!-- modal  AGREGAR PLAN DE ENGANCHE-->
<div class="modal fade modal-alertas" id="modal_enganche" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
            </div>
            <form method="post" id="form_enganche">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->



<!-- modal verifyNEODATA -->
<div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_NEODATA">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->
<!-- modal verifyNEODATA -->
<div class="modal fade modal-alertas" id="modal_NEODATA2" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_NEODATA2">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->


    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>

</body>
<?php $this->load->view('template/footer');?>
<script>

var url = "<?=base_url()?>";
var url2 = "<?=base_url()?>index.php/";


var getInfo1 = new Array(6);
var getInfo3 = new Array(6);


$("#tabla_ingresar_9").ready( function(){

    let titulos = [];
$('#tabla_ingresar_9 thead tr:eq(0) th').each( function (i) {

   if( i != 11){
    var title = $(this).text();
    titulos.push(title);

	$(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
	$( 'input', this ).on('keyup change', function () {
		if (tabla_1.column(i).search() !== this.value ) {
			tabla_1
			.column(i)
			.search(this.value)
			.draw();
		}
	} );
}
});


tabla_1 = $("#tabla_ingresar_9").DataTable({
  dom: 'Bfrtip',
  "buttons": [
      {
          extend: 'excelHtml5',
          text: 'Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [0,1,2,3,4,5,6,7,8,9,10],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' LOTE ';
                        }
                         return ' '+titulos[columnIdx] +' ';
                          
                    }
                }
            }
        }
    ],

 
    width: 'auto',
"language":{ url: "../static/spanishLoader.json" },
 
"pageLength": 10,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"columns": [
// {
// "width": "3%",
// "className": 'details-control',
// "orderable": false,
// "data" : null,
// "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
// },
{
    "width": "5%",
	"data": function( d ){
        var lblStats;
        lblStats ='<p style="font-size: .8em"><b>'+d.idLote+'</b></p>';
		return lblStats;
	}
},
{
"width": "5%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
}
},
{
"width": "9%",
"data": function( d ){
	return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
}
},
{
"width": "12%",
"data": function( d ){
	return '<p style="font-size: .8em">'+d.nombreLote+'</p>';

}
}, 
{
"width": "14%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>'+d.nombre_cliente+'</b></p>';

}
}, 
{
"width": "14%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>'+d.asesor+'</b></p>';

}
}, 
{
"width": "9%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>$'+formatMoney(d.comision_total)+'</b></p>';

}
},
{
"width": "9%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>$'+formatMoney(d.abonado)+'</b></p>';

}
},
{
"width": "9%",
"data": function( d ){
	return '<p style="font-size: .8em"><b>$'+formatMoney(d.comision_total-d.abonado)+'</b></p>';

}
},
// {
// "width": "9%",
// "data": function( d ){
 
//     var lblType;
// 			if(d.tipo_venta==1) {
// 				lblType ='<span class="label label-danger">Venta Particular</span>';
// 			}
// 			else if(d.tipo_venta==2) {
// 				lblType ='<span class="label label-success">Venta normal</span>';
// 			}
//         return lblType;
//     }
// }, 

 {
"width": "9%",
"data": function( d ){
    var lblStats;
            if(d.compartida==null) {
                lblStats ='<span class="label label-warning" style="background:#E5D141;">Individual</span>';
            }else {
                lblStats ='<span class="label label-warning">Compartida</span>';
            }
    return lblStats;
}
}, 


// {
// "width": "9%",
// "data": function( d ){
//     var lblStats;
//     if(d.idStatusContratacion==15) {
//         // lblStats ='';
//         lblStats ='<span class="label label-success" style="background:#9E9CD5;">Contratado</span>';

//     }
//     else {
//         lblStats ='<p><b>'+d.idStatusContratacion+'</b></p>';

        
//     }
//     return lblStats;
// }
// },

{
"width": "14%",
"data": function( d ){
    var lblStats;
 
    if(d.totalNeto2==null) {
            lblStats ='<span class="label label-danger">Sin precio lote</span>';
    }
    else {
        
        switch(d.lugar_prospeccion){
        case '6':
            lblStats ='<span class="label" style="background:#B4A269;">MARKETING DIGÍTAL</span>';
        break;
        
        case '12':
            lblStats ='<span class="label" style="background:#00548C;">CLUB MADERAS</span>';
        break;
        case '25':
            lblStats ='<span class="label" style="background:#0860BA;">IGNACIO GREENHAM</span>';
        break;

        default:
            lblStats ='';
        break;
    }
}
return lblStats;
 
}
},

 { 
"width": "12%",
"orderable": false,


"data": function( data ){
    var BtnStats;
    
    if(data.totalNeto2==null) {
        BtnStats = '';
    }else {
        if(data.compartida==null) {
            BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'"  data-value="'+data.registro_comision+'" data-code="'+data.cbbtton+'" ' +
			 'class="btn btn-info btn-round btn-fab btn-fab-mini verify_neodata" title="Ver">' +
             '<span class="material-icons">timeline</span></button>&nbsp;&nbsp;';
            }else {
                BtnStats = '<button href="#" value="'+data.idLote+'" data-estatus="'+data.idStatusContratacion+'" data-value="'+data.registro_comision+'"  data-code="'+data.cbbtton+'" ' +
                'class="btn btn-info btn-round btn-fab btn-fab-mini verify_neodata" title="Ver">' +
                '<span class="material-icons">timeline</span></button>&nbsp;&nbsp;';  
            }
        }
        return BtnStats;
    }
}

],

columnDefs: [
{
"searchable": false,
"orderable": false,
"targets": 0
},

],

"ajax": {
 "url": '<?=base_url()?>index.php/Comisiones/getDataDispersionPagoReport',
"dataSrc": "",
"type": "POST",
cache: false,
"data": function( d ){
}
},
"order": [[ 1, 'asc' ]]

});

$('#tabla_ingresar_9 tbody').on('click', 'td.details-control', function () {
		 var tr = $(this).closest('tr');
		 var row = tabla_1.row(tr);

		 if (row.child.isShown()) {
			 row.child.hide();
			 tr.removeClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
		 } else {
			var status;
				
				 var fechaVenc;
				 if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38) {
					 status = 'Status 8 listo (Asistentes de Gerentes)';
				 } else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65 ) {
					 status = 'Status 8 enviado a Revisión (Asistentes de Gerentes)';
				 }
				 else
				 {
					 status='N/A';
				 }

				 if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 38 ||
					 row.data().idStatusContratacion == 8 && row.data().idMovimiento == 65) {
					 fechaVenc = row.data().fechaVenc;
				 }
				 else
				 {
					 fechaVenc='N/A';
				 }

			 
			 var informacion_adicional = '<table class="table text-justify">' +
				 '<tr><b>INFORMACIÓN COLABORADORES</b>:' +
				 '<td style="font-size: .8em"><strong>SUBDIRECTOR: </strong>' + row.data().subdirector + '</td>' +
 				 '<td style="font-size: .8em"><strong>GERENTE: </strong>' + row.data().gerente + '</td>' +
				 '<td style="font-size: .8em"><strong>COORDINADOR: </strong>'+row.data().coordinador+'</td>' +
				 '<td style="font-size: .8em"><strong>ASESOR: </strong>'+row.data().asesor+'</td>' +
				 '</tr>' +
				 '</table>';


			 row.child(informacion_adicional).show();
			 tr.addClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
		 }


     });



      


    



        $("#tabla_ingresar_9 tbody").on("click", ".verify_neodata", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();

            registro_status = $(this).attr("data-value");
            id_estatus = $(this).attr("data-estatus");
 

            $("#modal_NEODATA .modal-header").html("");
            $("#modal_NEODATA .modal-body").html("");
            $("#modal_NEODATA .modal-footer").html("");
            
            $.getJSON( url + "Comisiones/getStatusNeodata/"+idLote).done( function( data ){
 
                if(data.length > 0){

                     console.log("entra 1");
                    switch (data[0].Marca) {
                    case '0':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '1':

                    
                    if(registro_status==0){//COMISION NUEVA


 

                        let total0 = parseFloat(data[0].Aplicado);
                        let total = 0;
                        
                        if(total0 > 0){
                            total = total0;
                        }else{
                            total = 0; 
                        }


                        


                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4>Total pago cliente: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div></div>');
                        // $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4>Cliente neodata: <b>$'+formatMoney(data[0].AplicadoCliente)+'</b></h4></div></div>');
                        
                       
                        // let total = 10000;

                    $.getJSON( url + "Comisiones/porcentajes/"+idLote).done( function( data2 ){

                            // console.log("entra a porcentajes");
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data2[0].totalNeto2)+'</b></h4></div></div><br>');



                            // sacar 5%
                            new_validate = parseFloat(data2[0].totalNeto2 * 0.05);

                            if(total>new_validate && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)){
                                // console.log("solo dispersa la mitad");
                                $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i><b style="color:blue;"> Anticipo </b> diponible <i>'+row.data().nombreLote+'</i></h3></div></div><br><br>');

                               var bandera_anticipo = 1;
                             }
                            else if(
                                (total<new_validate && (id_estatus == 9 || id_estatus == 10 || id_estatus == 11 || id_estatus == 12 || id_estatus == 13 || id_estatus == 14)
                                ) || (id_estatus == 15)  ){
                                    $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0)+'</b></h3></div></div><br><br>');
                                // console.log("solo dispersa lo proporcional");
                               var bandera_anticipo = 0;
                            }
                            
                            lugar = data2[0].lugar_prospeccion;
                            var_sum = 0;
/**--------------------------------------------------------------------------------------------- */

                       


                   
                        });

                    //FIN DE VALIDACION 0 SIN REGISTRO COMISION
                    
                    } else if(registro_status==1){
                        $.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
                            
                            let total0 = parseFloat((data[0].Aplicado));
                            let total = 0;

                            if(total0 > 0){
                               total = total0;
                            }else{
                               total = 0; 
                            }

                             
                            // let total = 100000;
                            var counts=0;
                            // console.log(total);

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div>');


                            $("#modal_NEODATA .modal-header").append('<div class="row">'+
                            '<div class="col-md-4">Comisión total: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
                            '<div class="col-md-4">Comisión total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
                            '<div class="col-md-4">Comisión pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4>Total pago cliente: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div></div>');
                            // $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4>Cliente neodata: <b>$'+formatMoney(data[0].AplicadoCliente)+'</b></h4></div></div>');

                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-(data1[0].abonado))+'</b></h3></div></div><br>');
                       

                        $.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
                            $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"></div></div>');
                          //  console.log(total);
                          let contador=0;
                          console.log('gree:'+data.length);

                          for (let index = 0; index < data.length; index++) {
                                    const element = data[index].id_usuario;
                                    if(data[index].id_usuario == 4415){
                                        contador +=1;
                                    }
                                    
                                }

                            $.each( data, function( i, v){

       if(v.rol_generado == 7){
                                
     saldo =0;                           
if(v.rol_generado == 7 && v.id_usuario == 4415){
    saldo = (( (v.porcentaje_saldos/2) /100)*(total));
    contador +=1;
}else if(v.rol_generado == 7 && contador > 0){
    saldo = (( (v.porcentaje_saldos/2) /100)*(total));
}else if(v.rol_generado == 7 && contador == 0){
    saldo = ((v.porcentaje_saldos /100)*(total));
}
else if(v.rol_generado != 7){
    saldo = ((v.porcentaje_saldos /100)*(total));
}
                                
  

                                if(v.abono_pagado>0){
                                    console.log("OPCION 1");


                                   evaluar = (v.comision_total-v.abono_pagado);
                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    
                                    resta_1 = saldo-v.abono_pagado;
                                    
                                    if(resta_1<1){
                                        // console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(resta_1 >= 1){
                                        // console.log("entra aqui 2");

                                        if(resta_1 > pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;

                                        }
                                        
                                    }


                                    

                                }
                                else if(v.abono_pagado<=0){

                                    console.log("OPCION 2");

                                    pending = (v.comision_total);

                                if(saldo > pending){
                                    saldo = pending;
                                }
                                
                                if(pending < 1){
                                    saldo = 0;
                                }
                                }

                                  if(v.id_usuario == 832){
                                    saldo = (saldo*2);
                                }

                                $("#modal_NEODATA .modal-body").append('<div class="row">'
                                +'<div class="col-md-3"><p>'+v.colaborador+'</p><b><p style="font-size:12px;">'+v.rol+'</p></b></div>'

                                +'<div class="col-md-1"><p>'+v.porcentaje_decimal+'%</p></div>'
                                +'<div class="col-md-2"><p>$'+formatMoney(v.comision_total)+'</p></div>'
                                +'<div class="col-md-2"><p>$'+formatMoney(v.abono_pagado)+'</p></div>'
                                +'<div class="col-md-2"><p>$'+formatMoney(pending)+'</p></div>'
                                +'<div class="col-md-2"></div>');
                           // }  
                                counts++

                            }

                            });
                        });
                        
                    });
                } 
                                       
                    break;
                    case '2':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '3':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '4':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '5':
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: '+row.data().nombreLote+'.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        
                    break;
                }
            }
            else{
                console.log("entra 2");
                 $("#modal_NEODATA .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
            });

            $("#modal_NEODATA").modal();

        });




        

        

});

/**---------------------------------------------------------------------------------------------------------------- */

//INICIO COMPARTIDA

$("#tabla_ingresar_9 tbody").on("click", ".verify_neodataCompartida", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            idLote = $(this).val();

            registro_status = $(this).attr("data-value");

            $("#modal_NEODATA2 .modal-header").html("");
            $("#modal_NEODATA2 .modal-body").html("");
            $("#modal_NEODATA2 .modal-footer").html("");
            
            // $.getJSON( url + "Comisiones/getStatusNeodata/"+idLote).done( function( data ){
                $.getJSON( url + "Comisiones/getStatusNeodata/"+idLote).done( function( data ){
 
                if(data.length > 0){


                    // console.log("entra 1");
                    console.log(data[0].Marca);


                    switch (data[0].Marca) {
                    case '0':
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>En espera de próximo abono en NEODATA de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '1':
                        console.log(registro_status);
                        
                        if(registro_status==0){//COMISION NUEV
 

                         let total0 = parseFloat(data[0].Aplicado);
                         let total = 0;
                        
                            if(total0 > 0){
                                total = total0;
                            }else{
                                total = 0; 
                            }


                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4>Total pago cliente: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div></div>');
                            // $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4>Cliente neodata: <b>$'+formatMoney(data[0].AplicadoCliente)+'</b></h4></div></div>');
                            $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0)+'</b></h3></div></div><br>');


                         // let total = 10000;

                         $.getJSON( url + "Comisiones/porcentajes2/"+idLote).done( function( data2 ){
                           var lugar_3 = data2[0].lugar_prospeccion;
                            console.log(lugar_3);

                              console.log('cord'+data2[0].id_coordinador);
                                console.log('cord2'+data2[0].idcoordinador2);
                            // $("#modal_NEODATA2 .modal-body").append(`<div class="row" id ='dpd' data-value=${formatMoney(total)}><div class="col-md-12" ><h3><b>Disponible para dispersar de  $${formatMoney(total)}.</b></h3></div>  </div>`);
                            $("#modal_NEODATA2 .modal-body").append(`<div class="row"><div class="col-md-12"><h5><b>Precio Lote $ ${ formatMoney(data2[0].totalNeto2)}.</b></h5></div>  </div><br>`);
                            $("#modal_NEODATA2 .modal-body").append(`<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>`);
                            
                            if(data2.length == 1){
                                let nuevoPor =  data2[0].p1 / 2;
                                let nuevoPorsaldo = data2[0].ps1 / 2;
                                
                                let porcentaje1=0;
                                porcentaje1 = data2[0].totalNeto2 * (nuevoPor / 100);
                                let saldo1 = 0;


                                saldo1 = total * (nuevoPorsaldo / 100);
                                if(saldo1 > porcentaje1){
                                    saldo1 = porcentaje1;
                                }
                                let resto1 = 0;
                                resto1 = porcentaje1 - saldo1;
                                if(resto1 < 1){
                                    resto1=0;
                                }else{
                                    resto1= porcentaje1 - saldo1;
                                }


                                // MSL-MAGNOLIA-27

                   
                                $("#modal_NEODATA2 .modal-body").append(`<input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idLote" id="idLote" value="${idLote}"><input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}"><div class="row">   
                                <input type="hidden" name="idAs" value="${data2[0].id_asesor}"><input type="hidden" name="rolAs" value="7"><div class="col-md-3"><b><p>${data2[0].asesor}</p></b><p>Asesor</p><br></div>
                                <div class="col-md-1"><input type="text" name="porAs" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor}"></div>
                                <div class="col-md-2"><input type="text" name="totalAs" id="totalAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje1.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="comisionAs" id="comisionAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                <div class="col-md-2"><input type="text" name="disponibleAs" id="diponibleAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto1.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="restoAs" id="restoAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo1.toFixed(3)}"></div></div></div>
                                <div class="row"> 
                                <input type="hidden" name="idAs2" value="${data2[0].idasesor2}"><input type="hidden" name="rolAs2" value="7"><div class="col-md-3"><b><p>${data2[0].asesor2}</p></b><p>Asesor</p><br></div>
                                <div class="col-md-1"><input type="text" name="porAs2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor}"></div>
                                <div class="col-md-2"><input type="text" name="totalAs2" id="totalAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje1.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="comisionAs2" id="comisionAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                <div class="col-md-2"><input type="text" name="disponibleAs2" id="diponibleAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto1.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="restoAs2" id="restoAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo1.toFixed(3)}"></div></div>
                                `);

                                /**-----SI EL COORDINADOR 1 Y/O 2 VIENEN VACIOS--------------------- */
                                
                                if(data2[0].id_coordinador == null && data2[0].idcoordinador2 == 0){
                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                        <input type="hidden" name="idCoor" value="0"><input type="hidden" name="rolCoor" value="0"><div class="col-md-3"><b><p style="color:red;">N/A Coordinador</p></b><p>Coordinador</p><br></div>
                                        <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div></div></div>`);
                                    }else if(data2[0].id_coordinador == null && data2[0].idcoordinador2 != 0){
                                        let nuevoPor2 =  data2[0].p2 ;
                                        let nuevoPorsaldo2 = data2[0].ps2;
                                        let porcentaje2=0;
                                        porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                        let saldo2 = 0;
                                        saldo2 = total * (nuevoPorsaldo2 / 100);
                                        if(saldo2 > porcentaje2){
                                            saldo2 = porcentaje2;
                                        }
                                        let resto2 = 0;
                                        resto2 = porcentaje2 - saldo2;
                                        if(resto2 < 1){
                                            resto2=0;
                                        }else{
                                            resto2= porcentaje2 - saldo2;
                                        }
                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row"> 
                                        <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                        <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                        <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                        <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                        <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>`);
                                    }else if(data2[0].id_coordinador != null && data2[0].idcoordinador2 == 0){
                                        let nuevoPor2 =  data2[0].p2 ;
                                        let nuevoPorsaldo2 = data2[0].ps2 ;
                                        let porcentaje2=0;
                                        porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                        let saldo2 = 0;
                                        saldo2 = total * (nuevoPorsaldo2 / 100);
                                        if(saldo2 > porcentaje2){
                                            saldo2 = porcentaje2;
                                        }
                                        let resto2 = 0;
                                        resto2 = porcentaje2 - saldo2;
                                        if(resto2 < 1){
                                            resto2=0;
                                        }else{
                                            resto2= porcentaje2 - saldo2;
                                        }
                                        
                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                            <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);  

                                        }else if(data2[0].id_coordinador != null && data2[0].idcoordinador2 != 0){

                                            if(data2[0].id_coordinador ==  data2[0].idcoordinador2){
                                                let nuevoPor2 =  data2[0].p2 ;
                                                let nuevoPorsaldo2 = data2[0].ps2 ;       
                                                let porcentaje2=0;        
                                                porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);        
                                                let saldo2 = 0;         
                                                saldo2 = total * (nuevoPorsaldo2 / 100);         
                                                if(saldo2 > porcentaje2){                   
                                                    saldo2 = porcentaje2;               
                                                }               
                                                let resto2 = 0;       
                                                resto2 = porcentaje2 - saldo2;   
                                                if(resto2 < 1){       
                                                    resto2=0;    
                                                }else{        
                                                    resto2= porcentaje2 - saldo2;   
                                                }
                                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                    <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                                    <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                                    <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                    <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);

                                                }  else{
                                                    let nuevoPor2 =  data2[0].p2 / 2;
                                                    let nuevoPorsaldo2 = data2[0].ps2 / 2;
                                                    let porcentaje2=0;
                                                    porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                                    let saldo2 = 0;
                                                    saldo2 = total * (nuevoPorsaldo2 / 100);
                                                    if(saldo2 > porcentaje2){
                                                        saldo2 = porcentaje2;
                                                    }
                                                    let resto2 = 0;
                                                    resto2 = porcentaje2 - saldo2;
                                                    if(resto2 < 1){
                                                        resto2=0;
                                                    }else{
                                                        resto2= porcentaje2 - saldo2;
                                                    }
                                                    
                                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                        <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                                        <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                                        <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                        <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                                        </div>
                                                        <div class="row"> 
                                                        <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                                        <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                                        <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                        <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>   `); 
                                                    }
                                                }
                                                
                                                /**-----SI EL GERENTE 1 Y/O 2 VIENEN VACIOS--------------------- */

                                                if(data2[0].id_gerente == data2[0].idgerente2){
                                                    let nuevoPor3 =  data2[0].p3 ;                   
                                                    let nuevoPorsaldo3 = data2[0].ps3 ;    
                                                    let porcentaje3=0;      
                                                    porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);       
                                                    let saldo3 = 0;       
                                                    saldo3 = total * (nuevoPorsaldo3 / 100);       
                                                    if(saldo3 > porcentaje3){        
                                                        saldo3 = porcentaje3;        
                                                    }      
                                                    let resto3 = 0;     
                                                    resto3 = porcentaje3 - saldo3;      
                                                    if(resto3 < 1){
                                                        resto3=0;
                                                    }else{
                                                        resto3= porcentaje3 - saldo3;
                                                    }


                                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                        <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="3"><div class="col-md-3"><b><p>${data2[0].gerente2}</p></b><p>Gerente</p><br></div>
                                                        <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                        <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                        <div class="col-md-2"><input type="text" name="disponibleGe" id="diponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>
                                                        </div>`);

                                                    }else{

                                                        let nuevoPor3 =  data2[0].p3 / 2;
                                                        let nuevoPorsaldo3 = data2[0].ps3 / 2;
                                                        let porcentaje3=0;
                                                        porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);
                                                        let saldo3 = 0;
                                                        saldo3 = total * (nuevoPorsaldo3 / 100);
                                                        if(saldo3 > porcentaje3){
                                                            saldo3 = porcentaje3;
                                                        }
                                                        let resto3 = 0;
                                                        resto3 = porcentaje3 - saldo3;
                                                        if(resto3 < 1){
                                                            resto3=0;
                                                        }else{
                                                            resto3= porcentaje3 - saldo3;
                                                        }
        
                                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                            <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="3"><div class="col-md-3"><b><p>${data2[0].gerente}</p></b><p>Gerente</p><br></div>
                                                            <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                            <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                            <div class="col-md-2"><input type="text" name="disponibleGe" id="disponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>
                                                                </div>
                                                            <div class="row"> 
                                                            <input type="hidden" name="idGe2" value="${data2[0].idgerente2}"><input type="hidden" name="rolGe2" value="3"><div class="col-md-3"><b><p>${data2[0].gerente2}</p></b><p>Gerente</p><br></div>
                                                            <div class="col-md-1"><input type="text" name="porGe2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                            <div class="col-md-2"><input type="text" name="totalGe2" id="totalGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="comisionGe2" id="comisionGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                            <div class="col-md-2"><input type="text" name="disponibleGe2" id="disponibleGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="restoGe2" id="restoGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>`);
                                                        }
                                                        
                                                        /*----------------------SUB DIRECTOR--------------------------------*/

                                                        if(data2[0].id_subdirector == data2[0].idsubdirector2){
                                                            let nuevoPor4 =  data2[0].p4 ;
                                                            let nuevoPorsaldo4 = data2[0].ps4 ;
                                                            let porcentaje4=0;
                                                            porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                            let saldo4  = 0;
                                                            saldo4 = total * (nuevoPorsaldo4 / 100);
                                                            if(saldo4 > porcentaje4){
                                                                saldo4 = porcentaje4;
                                                            }
                                                            let resto4 = 0;
                                                            resto4 = porcentaje4 - saldo4;
                                                            if(resto4 < 1){
                                                                resto4=0;
                                                            }else{
                                                                resto4= porcentaje4 - saldo4;
                                                            }
                                                            
                                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                                <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div></div>`);
                                                            }else{

                                                                let nuevoPor4 =  data2[0].p4 / 2;
                                                                let nuevoPorsaldo4 = data2[0].ps4 / 2;
                                                                let porcentaje4=0;
                                                                porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                                let saldo4  = 0;
                                                                saldo4 = total * (nuevoPorsaldo4 / 100);
                                                                if(saldo4 > porcentaje4){
                                                                    saldo4 = porcentaje4;
                                                                }
                                                                let resto4 = 0;
                                                                resto4 = porcentaje4 - saldo4;
                                                                if(resto4 < 1){
                                                                    resto4=0;
                                                                }else{
                                                                    resto4= porcentaje4 - saldo4;
                                                                }
        
                                                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                    <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                                    <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                    <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                    <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>
                                                                        </div>
                                                                    <div class="row"> 
                                                                    <input type="hidden" name="idSub2" value="${data2[0].idsubdirector2}"><input type="hidden" name="rolSub2" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector2}</p></b><p>Sub director</p><br></div>
                                                                    <div class="col-md-1"><input type="text" name="porSub2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                    <div class="col-md-2"><input type="text" name="totalSub2" id="totalSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="comisionSub2" id="comisionSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                    <div class="col-md-2"><input type="text" name="disponibleSub2" id="disponibleSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="restoSub2" id="restoSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>`);
                                                                }
                                                                /**------------------------FIN SUB DIRECTOR */
                                                                
                                                                /**.--------------------DIRECTOR-------------- */
                                                                let nuevoPor5 =  data2[0].p5 ;
                                                                let nuevoPorsaldo5 = data2[0].ps5 ;
                                                                let porcentaje5=0;
        
                                                                porcentaje5 = data2[0].totalNeto2 * (nuevoPor5 / 100);
                                                                let saldo5  = 0;
                                                                saldo5 = total * (nuevoPorsaldo5 / 100);
                                                                if(saldo5 > porcentaje5){
                                                                    saldo5 = porcentaje5;
                                                                }
                                                                let resto5 = 0;
                                                                resto5 = porcentaje5 - saldo5;
                                                                if(resto5 < 1){
                                                                    resto5=0;
                                                                }else{
                                                                    resto5= porcentaje5 - saldo5;
                                                                }
                                                                
                                                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                    <input type="hidden" name="idDir" value="${data2[0].id_director}"><input type="hidden" name="rolDir" value="1"><div class="col-md-3"><b><p>${data2[0].director}</p></b><p>Director</p><br></div>
                                                                    <div class="col-md-1"><input type="text" name="porDir" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor5}"></div>
                                                                    <div class="col-md-2"><input type="text" name="totalDir" id="totalDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje5.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="comisionDir" id="comisionDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                    <div class="col-md-2"><input type="text" name="disponibleDir" id="disponibleDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto5.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="restoDir" id="restoDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo5.toFixed(3)}"></div></div></div>`);
    
                                                                    $("#modal_NEODATA2 .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" id="dispersarc01" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
                                                                    // $('#dispersarc01').prop('disabled', true);



                                                              

                                                                    if(lugar_3 == '6' || lugar_3 == 6)      
                                                                    {
                                                                    $("#modal_NEODATA2 .modal-body").append('<div class="row"><input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idMk" value="'+data2[0].id_mk2+'"><input type="hidden" name="rolMk" value="38">'+
                                                                    '<div class="col-md-3"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+data2[0].marketing2+'" style="font-size:12px;"><b><p style="font-size:12px;">Marketing</p></b></div>'
                                                                    +'<div class="col-md-1"><input type="text" name="porMk" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+data2[0].p62+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="totalMk" id="totalMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+porcentaje5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="comisionMk" id="comisionMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="disponibleMk" id="diponibleMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+resto5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="restoMk" id="restoMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+saldo5.toFixed(3)+'"></div></div>');
                                                                    }
                                                                    else{
                                                                        $("#modal_NEODATA2 .modal-body").append('<div class="row">'
                                                                        +'<input id="id_disparador" type="hidden" name="id_disparador" value="0">'
                                                                        +'<input type="hidden" name="idMk" value="0">'
                                                                        +'<input type="hidden" name="rolMk" value="0">'
                                                                        +'<div class="col-md-1"><input type="hidden" name="porMk" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="totalMk" id="totalMk" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="comisionMk" id="comisionMk" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="disponibleMk" id="diponibleMk"  value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="restoMk" id="restoMk" value="0"></div></div>');

                                                                    }


                                                                    if(lugar_3 == '12' || lugar_3 == 12)      
                                                                    {
                                                                    $("#modal_NEODATA2 .modal-body").append('<div class="row"><input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idCb" value="'+data2[0].id_cb2+'"><input type="hidden" name="rolCb" value="42">'+
                                                                    '<div class="col-md-3"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+data2[0].club_maderas2+'" style="font-size:12px;"><b><p style="font-size:12px;">Marketing</p></b></div>'
                                                                    +'<div class="col-md-1"><input type="text" name="porCb" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+data2[0].p62+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="totalCb" id="totalCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+porcentaje5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="comisionCb" id="comisionCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="disponibleCb" id="diponibleCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+resto5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="restoCb" id="restoCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+saldo5.toFixed(3)+'"></div></div>');
                                                                    }
                                                                    else{
                                                                        $("#modal_NEODATA2 .modal-body").append('<div class="row">'
                                                                        +'<input id="id_disparador" type="hidden" name="id_disparador" value="0">'
                                                                        +'<input type="hidden" name="idCb" value="0">'
                                                                        +'<input type="hidden" name="rolCb" value="0">'
                                                                        +'<div class="col-md-1"><input type="hidden" name="porCb" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="totalCb" id="totalCb" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="comisionCb" id="comisionCb" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="disponibleCb" id="diponibleCb"  value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="restoCb" id="restoCb" value="0"></div></div>');

                                                                    }



                                                                if(lugar_3 != '6' && lugar_3 != 6 && lugar_3 != 12 && lugar_3 != '12')      
                                                                {
                                                                    console.log("empresa");
                                                                $("#modal_NEODATA2 .modal-body").append('<div class="row"><input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idEm" value="4824"><input type="hidden" name="rolEm" value="45">'+
                                                                '<div class="col-md-3"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="Empresa Abonos" style="font-size:12px;"><b><p style="font-size:12px;">Empresa</p></b></div>'
                                                                +'<div class="col-md-1"><input type="text" name="porEm" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="1"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="totalEm1" id="totalEm1" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+porcentaje5.toFixed(3)+'"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="comisionEm" id="comisionEm" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="disponibleEm" id="diponibleEm" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+resto5.toFixed(3)+'"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="restoEm" id="restoEm" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+saldo5.toFixed(3)+'"></div></div>');
                                                                }
                                                                else{
                                                                    console.log("no empresa");

                                                                    $("#modal_NEODATA2 .modal-body").append('<div class="row">'
                                                                    +'<input id="id_disparador" type="hidden" name="id_disparador" value="0">'
                                                                    +'<input type="hidden" name="idEm" value="0">'
                                                                    +'<input type="hidden" name="rolEm" value="0">'
                                                                    +'<div class="col-md-1"><input type="hidden" name="porEm" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="totalEm1" id="totalEm1" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="comisionEm" id="comisionEm" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="disponibleEm" id="diponibleEm"  value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="restoEm" id="restoEm" value="0"></div></div>');

                                                                }


 
                                                                
                                                                
/*----*************************--------------------------------COMPARTIDA CON 3 ASESORES----------*************************-----------------------* */
}else

if(data2.length == 2){
    let nuevoPor =  data2[0].p1 / 3;
    let nuevoPorsaldo = data2[0].ps1 / 3;
    let porcentaje1=0;
    porcentaje1 = data2[0].totalNeto2 * (nuevoPor / 100);
    let saldo1 = 0;
    saldo1 = total * (nuevoPorsaldo / 100);
    if(saldo1 > porcentaje1){
        saldo1 = porcentaje1;
    }
    let resto1 = 0;
    resto1 = porcentaje1 - saldo1;
    if(resto1 < 1){
        resto1=0;
    }else{
        resto1= porcentaje1 - saldo1;
    }
    
    $("#modal_NEODATA2 .modal-body").append(`<input type="hidden" name="idLote" id="idLote" value="${idLote}">
        <input type="hidden" name="pago_neo" id="pago_neo" value="${total.toFixed(3)}">
        <div class="row">   
      <input type="hidden" name="idAs" value="${data2[0].id_asesor}"><input type="hidden" name="rolAs" value="7"><div class="col-md-3"><b><p>${data2[0].asesor}</p></b><p>Asesor</p><br></div>
      <div class="col-md-1"><input type="text" name="porAs" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor}"></div>
      <div class="col-md-2"><input type="text" name="totalAs" id="totalAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje1.toFixed(3)}"></div>
      <div class="col-md-2"><input type="text" name="comisionAs" id="comisionAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
      <div class="col-md-2"><input type="text" name="disponibleAs" id="diponibleAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto1.toFixed(3)}"></div>
      <div class="col-md-2"><input type="text" name="restoAs" id="restoAs" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo1.toFixed(3)}"></div></div>
        </div>
      <div class="row"> 
      <input type="hidden" name="idAs2" value="${data2[0].idasesor2}"><input type="hidden" name="rolAs2" value="7"><div class="col-md-3"><b><p>${data2[0].asesor2}</p></b><p>Asesor</p><br></div>
      <div class="col-md-1"><input type="text" name="porAs2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor}"></div>
      <div class="col-md-2"><input type="text" name="totalAs2" id="totalAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje1.toFixed(3)}"></div>
      <div class="col-md-2"><input type="text" name="comisionAs2" id="comisionAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
      <div class="col-md-2"><input type="text" name="disponibleAs2" id="diponibleAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto1.toFixed(3)}"></div>
      <div class="col-md-2"><input type="text" name="restoAs2" id="restoAs2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo1.toFixed(3)}"></div></div>
      <div class="row"> 
      <input type="hidden" name="idAs3" value="${data2[1].idasesor2}"><input type="hidden" name="rolAs3" value="7"><div class="col-md-3"><b><p>${data2[1].asesor2}</p></b><p>Asesor</p><br></div>
      <div class="col-md-1"><input type="text" name="porAs3" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor}"></div>
      <div class="col-md-2"><input type="text" name="totalAs3" id="totalAs3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje1.toFixed(3)}"></div>
      <div class="col-md-2"><input type="text" name="comisionAs3" id="comisionAs3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
      <div class="col-md-2"><input type="text" name="disponibleAs3" id="diponibleAs3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto1.toFixed(3)}"></div>
      <div class="col-md-2"><input type="text" name="restoAs3" id="restoAs3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo1.toFixed(3)}"></div></div>`);
      
      if((data2[0].id_coordinador !== null && data2[0].id_coordinador !== 0) &&  (data2[0].idcoordinador2 === null || data2[0].idcoordinador2 === 0) && (data2[1].idcoordinador2 === null || data2[1].idcoordinador2 === 0) )
      {//coor 1
        console.log(' opc 1');
        let nuevoPor2 =  data2[0].p2 ;
        let nuevoPorsaldo2 = data2[0].ps2;
        let porcentaje2=0;
        porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
        let saldo2 = 0;
        saldo2 = total * (nuevoPorsaldo2 / 100);
        if(saldo2 > porcentaje2){
            saldo2 = porcentaje2;
        }
        let resto2 = 0;
        resto2 = porcentaje2 - saldo2;
        if(resto2 < 1){
            resto2=0;
        }else{
            resto2= porcentaje2 - saldo2;
        }
        
        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
            <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);
        
        }else if( (data2[0].id_coordinador == null || data2[0].id_coordinador == 0) &&  (data2[0].idcoordinador2 != null && data2[0].idcoordinador2 != 0) &&  (data2[1].idcoordinador2 == null || data2[1].idcoordinador2 == 0) )
        {// coor 2
            console.log(' opc 2');
            let nuevoPor2 =  data2[0].p2;
            let nuevoPorsaldo2 = data2[0].ps2;
            let porcentaje2=0;
            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
            let saldo2 = 0;
            saldo2 = total * (nuevoPorsaldo2 / 100);
            if(saldo2 > porcentaje2){      
                saldo2 = porcentaje2;
            }
            let resto2 = 0;
            resto2 = porcentaje2 - saldo2;
        
            if(resto2 < 1){
                resto2=0;
            }else{
                resto2= porcentaje2 - saldo2;
            }
        
            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                <input type="hidden" name="idCoor" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);


            }else if( (data2[0].id_coordinador == null || data2[0].id_coordinador == 0) &&  (data2[0].idcoordinador2 == null || data2[0].idcoordinador2 == 0) &&  (data2[1].idcoordinador2 != null && data2[1].idcoordinador2 != 0) )
            {//coor 3
                console.log(' opc 3');
                let nuevoPor2 =  data2[0].p2;
                let nuevoPorsaldo2 = data2[0].ps2;
                let porcentaje2=0;
        
            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
            let saldo2 = 0;
            saldo2 = total * (nuevoPorsaldo2 / 100);
            if(saldo2 > porcentaje2){  
                saldo2 = porcentaje2;
            }
            let resto2 = 0;
            resto2 = porcentaje2 - saldo2;
            if(resto2 < 1){
                resto2=0;
            }else{
                resto2= porcentaje2 - saldo2;
            }
        
            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
            <input type="hidden" name="idCoor" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);

        }else if(data2[0].id_coordinador == null || data2[0].id_coordinador == 0 &&  data2[0].idcoordinador2 == null || data2[0].idcoordinador2 == 0 &&  data2[1].idcoordinador2 == null || data2[1].idcoordinador2 == 0)
        {// nelson
            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                <input type="hidden" name="idCoor" value="0"><input type="hidden" name="rolCoor" value="0"><div class="col-md-3"><b><p style="color:red;">N/A Coordinador</p></b><p>Coordinador</p><br></div>
                <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div></div></div>`);
            }
            else if( (data2[0].id_coordinador != null && data2[0].id_coordinador != 0) &&  (data2[0].idcoordinador2 != null && data2[0].idcoordinador2 != 0) &&  (data2[1].idcoordinador2 == null || data2[1].idcoordinador2 == 0) )
            {// coor1 y 2
                if(data2[0].id_coordinador == data2[0].idcoordinador2){
                    let nuevoPor2 =  data2[0].p2 ;
                    let nuevoPorsaldo2 = data2[0].ps2 ;
                    let porcentaje2=0;
                    porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                    let saldo2 = 0;
                    saldo2 = total * (nuevoPorsaldo2 / 100);
                    if(saldo2 > porcentaje2){
                        saldo2 = porcentaje2;
                    }
                    let resto2 = 0;
                    resto2 = porcentaje2 - saldo2;
                    if(resto2 < 1){
                        resto2=0;
                    }else{
                        resto2= porcentaje2 - saldo2;
                    }
        
                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                        <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                        <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                        <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                        <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                        <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                        <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);
                    }else{
                        let nuevoPor2 =  data2[0].p2 / 2;
                        let nuevoPorsaldo2 = data2[0].ps2 / 2;
                        let porcentaje2=0;
                        porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                        let saldo2 = 0;
                        saldo2 = total * (nuevoPorsaldo2 / 100);
                        if(saldo2 > porcentaje2){
                            saldo2 = porcentaje2;
                        }
                        let resto2 = 0;
                        resto2 = porcentaje2 - saldo2;
                        if(resto2 < 1){
                            resto2=0;
                        }else{
                            resto2= porcentaje2 - saldo2;
                        }
            
                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                            <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                            </div>
                            <div class="row"> 
                            <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                            <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                            <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                            <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                            <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                            <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>`);

                        }
                    }

                    else if( (data2[0].id_coordinador != null && data2[0].id_coordinador != 0) &&  (data2[0].idcoordinador2 == null || data2[0].idcoordinador2 == 0) &&  (data2[1].idcoordinador2 != null && data2[1].idcoordinador2 != 0))
                    {// coor1 y 3
                        
                        if(data2[0].id_coordinador == data2[1].idcoordinador2){
                            let nuevoPor2 =  data2[0].p2 ;
                            let nuevoPorsaldo2 = data2[0].ps2 ;
                            let porcentaje2=0;
                            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                            let saldo2 = 0;
                            saldo2 = total * (nuevoPorsaldo2 / 100);
                            if(saldo2 > porcentaje2){
                                saldo2 = porcentaje2;
                            }
                            let resto2 = 0;
                            resto2 = porcentaje2 - saldo2;

                            if(resto2 < 1){
                                resto2=0;
                            }else{
                                resto2= porcentaje2 - saldo2;
                            }
            
                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                            <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);
                        }else{

                            let nuevoPor2 =  data2[0].p2 / 2;
                            let nuevoPorsaldo2 = data2[0].ps2 / 2;
                            let porcentaje2=0;
                            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                            let saldo2 = 0;
                            saldo2 = total * (nuevoPorsaldo2 / 100);
                            if(saldo2 > porcentaje2){
                                saldo2 = porcentaje2;
                            }
                            let resto2 = 0;
                            resto2 = porcentaje2 - saldo2;
                            if(resto2 < 1){
                                resto2=0;
                            }else{
                                resto2= porcentaje2 - saldo2;
                            }
            
                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                    </div>
                                <div class="row"> 
                                <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>   `);
                            }
                        }

                        else if( (data2[0].id_coordinador == null || data2[0].id_coordinador == 0) &&  (data2[0].idcoordinador2 != null && data2[0].idcoordinador2 != 0) &&  (data2[1].idcoordinador2 != null && data2[1].idcoordinador2 != 0))
                        {// coor2 y 3
                            if(data2[0].idcoordinador2 == data2[1].idcoordinador2){
                                let nuevoPor2 =  data2[0].p2 ;
                                let nuevoPorsaldo2 = data2[0].ps2;
                                let porcentaje2=0;
                                porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                let saldo2 = 0;
                                saldo2 = total * (nuevoPorsaldo2 / 100);
                                if(saldo2 > porcentaje2){
                                    saldo2 = porcentaje2;
                                }
                                let resto2 = 0;
                                resto2 = porcentaje2 - saldo2;
                                if(resto2 < 1){
                                    resto2=0;
                                }else{
                                    resto2= porcentaje2 - saldo2;
                                }
            
                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);
                            }else{
                                let nuevoPor2 =  data2[0].p2 / 2;
                                let nuevoPorsaldo2 = data2[0].ps2 / 2;
                                let porcentaje2=0;
                                porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                let saldo2 = 0;
                                saldo2 = total * (nuevoPorsaldo2 / 100);
                                if(saldo2 > porcentaje2){
                                    saldo2 = porcentaje2;
                                }
                                let resto2 = 0;
                                resto2 = porcentaje2 - saldo2;
                                if(resto2 < 1){
                                    resto2=0;
                                }else{
                                    resto2= porcentaje2 - saldo2;
                                }
            
                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                    <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                    <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                    <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                    <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                    <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                    <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                    </div>
                                    <div class="row"> 
                                    <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                    <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                    <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                    <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                    <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                    <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>`);
                                }
                            }

                            else if( (data2[0].id_coordinador != null && data2[0].id_coordinador != 0) &&  (data2[0].idcoordinador2 != null && data2[0].idcoordinador2 != 0) &&  (data2[1].idcoordinador2 != null && data2[1].idcoordinador2 != 0) )
                            {// coor1 , 2 y  3// 1 y 2 ==

                                if(data2[0].id_coordinador == data2[0].idcoordinador2 && data2[0].id_coordinador != data2[1].idcoordinador2 && data2[0].idcoordinador2 != data2[1].idcoordinador2){//IMPRIME 1 Y 3

                                    let nuevoPor2 =  data2[0].p2 / 2;
                                    let nuevoPorsaldo2 = data2[0].ps2 / 2;
                                    let porcentaje2=0;
                                    porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                    let saldo2 = 0;
                                    saldo2 = total * (nuevoPorsaldo2 / 100);
                                    if(saldo2 > porcentaje2){
                                        saldo2 = porcentaje2;
                                    }
                                    let resto2 = 0;
                                    resto2 = porcentaje2 - saldo2;
                                    if(resto2 < 1){
                                        resto2=0;
                                    }else{
                                        resto2= porcentaje2 - saldo2;
                                    }
            
                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                        <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                        <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                        <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                        <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                        <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                        </div>
                                        <div class="row"> 
                                        <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                        <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                        <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                        <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                        <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                        <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div> `);
                                    }//1 y 3 ==

                                    else  if(data2[0].id_coordinador != data2[0].idcoordinador2 && data2[0].id_coordinador == data2[1].idcoordinador2 && data2[0].idcoordinador2 != data2[1].idcoordinador2){//IMPRIME 1 Y 2
                                        let nuevoPor2 =  data2[0].p2 / 2;
                                        let nuevoPorsaldo2 = data2[0].ps2 / 2;
                                        let porcentaje2=0;
                                        porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                        let saldo2 = 0;
                                        saldo2 = total * (nuevoPorsaldo2 / 100);
                                        if(saldo2 > porcentaje2){
                                            saldo2 = porcentaje2;
                                        }
                                        let resto2 = 0;
                                        resto2 = porcentaje2 - saldo2;

                                        if(resto2 < 1){
                                            resto2=0;
                                        }else{
                                            resto2= porcentaje2 - saldo2;
                                        }
            
                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                            <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                                </div>
                                            <div class="row"> 
                                            <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                            <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>`);
                                        } // 2 Y 3 ==

                                        else  if(data2[0].id_coordinador != data2[0].idcoordinador2 && data2[0].id_coordinador != data2[1].idcoordinador2 && data2[0].idcoordinador2 == data2[1].idcoordinador2){
                                            //IMPRIME 1 Y 2
                                            let nuevoPor2 =  data2[0].p2 / 2;
                                            let nuevoPorsaldo2 = data2[0].ps2 / 2;
                                            let porcentaje2=0;
                                            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                            let saldo2 = 0;
                                            saldo2 = total * (nuevoPorsaldo2 / 100);
                                            if(saldo2 > porcentaje2){
                                                saldo2 = porcentaje2;
                                            }
                                                    let resto2 = 0;
                                            resto2 = porcentaje2 - saldo2;

                                            if(resto2 < 1){
                                                resto2=0;
                                            }else{
                                                resto2= porcentaje2 - saldo2;
                                            }
            
                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                                <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                                    </div>
                                                <div class="row"> 
                                                <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                                <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>`);

                                            }// 1, 2 y 3 ==
                                            
                                            else  if(data2[0].id_coordinador == data2[0].idcoordinador2 && data2[0].id_coordinador == data2[1].idcoordinador2 && data2[0].idcoordinador2 == data2[1].idcoordinador2){//IMPRIME 1 
                                            let nuevoPor2 =  data2[0].p2 ;
                                            let nuevoPorsaldo2 = data2[0].ps2 ;
                                            let porcentaje2=0;
                                            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                            let saldo2 = 0;
                                            saldo2 = total * (nuevoPorsaldo2 / 100);
                                            if(saldo2 > porcentaje2){
                                                saldo2 = porcentaje2;
                                            }
                                            let resto2 = 0;
                                            resto2 = porcentaje2 - saldo2;

                                            if(resto2 < 1){
                                                resto2=0;
                                            }else{
                                                resto2= porcentaje2 - saldo2;
                                            }
            
                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                                <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div></div>`);
                                            }// 1, 2, y 3 !=

                                            else  if(data2[0].id_coordinador != data2[0].idcoordinador2 && data2[0].id_coordinador != data2[1].idcoordinador2 && data2[0].idcoordinador2 != data2[1].idcoordinador2){
                                                //IMPRIME 1 ,2 y 3

                                            let nuevoPor2 =  data2[0].p2 / 3;
                                            let nuevoPorsaldo2 = data2[0].ps2 / 3;
                                            let porcentaje2=0;
                                            porcentaje2 = data2[0].totalNeto2 * (nuevoPor2 / 100);
                                            let saldo2 = 0;
                                            saldo2 = total * (nuevoPorsaldo2 / 100);

                                            if(saldo2 > porcentaje2){       
                                                saldo2 = porcentaje2;
                                            }
                                            let resto2 = 0;
                                            resto2 = porcentaje2 - saldo2;

                                            if(resto2 < 1){
                                                resto2=0;
                                            }else{
                                                resto2= porcentaje2 - saldo2;
                                            }
                                            
                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                            <input type="hidden" name="idCoor" value="${data2[0].id_coordinador}"><input type="hidden" name="rolCoor" value="9"><div class="col-md-3"><b><p>${data2[0].coordinador}</p></b><p>Coordinador</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porCoor" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                            <div class="col-md-2"><input type="text" name="totalCoor" id="totalCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionCoor" id="comisionCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleCoor" id="diponibleCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoCoor" id="restoCoor" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>
                                                </div>
                                            <div class="row"> 
                                            <input type="hidden" name="idCoor2" value="${data2[0].idcoordinador2}"><input type="hidden" name="rolCoor2" value="9"><div class="col-md-3"><b><p>${data2[0].coor2}</p></b><p>Coordinador</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porCoor2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                            <div class="col-md-2"><input type="text" name="totalCoor2" id="totalCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionCoor2" id="comisionCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleCoor2" id="disponibleCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoCoor2" id="restoCoor2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>   
                                            <div class="row"> 
                                            <input type="hidden" name="idCoor3" value="${data2[1].idcoordinador2}"><input type="hidden" name="rolCoor3" value="9"><div class="col-md-3"><b><p>${data2[1].coor2}</p></b><p>Coordinador</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porCoor3" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor2}"></div>
                                            <div class="col-md-2"><input type="text" name="totalCoor3" id="totalCoor3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionCoor3" id="comisionCoor3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleCoor3" id="disponibleCoor3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto2.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoCoor3" id="restoCoor3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo2.toFixed(3)}"></div></div>`);

                                        }

                                    }


                                    /**---------------------GERENTE-------------------------------- */

                                    if(data2[0].id_gerente == data2[0].idgerente2 && data2[0].id_gerente == data2[1].idgerente2 && data2[0].idgerente2 == data2[1].idgerente2)
                                    {
                                        //SI TODOS LOS ID SON IGUALES SOLO IMPRIME 1
                                        let nuevoPor3 =  data2[0].p3 ;
                                        let nuevoPorsaldo3 = data2[0].ps3 ;
                                        let porcentaje3=0;
                                        porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);
                                        let saldo3 = 0;
                                        saldo3 = total * (nuevoPorsaldo3 / 100);
                                        if(saldo3 > porcentaje3){
                                            saldo3 = porcentaje3;
                                        }
                                        let resto3 = 0;
                                        resto3 = porcentaje3 - saldo3;
                                        if(resto3 < 1){
                                            resto3=0;
                                        }else{
                                            resto3= porcentaje3 - saldo3;
                                        }
            
                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                            <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="3"><div class="col-md-3"><b><p>${data2[0].gerente}</p></b><p>Gerente</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                            <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleGe" id="diponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div></div>`);

                                        }else if(data2[0].id_gerente != data2[0].idgerente2 && data2[0].id_gerente == data2[1].idgerente2 && data2[0].idgerente2 != data2[1].idgerente2 ){
                                            //SI ES GERENTE 1 ES DIREFENTE DEL GERENTE 2, Y EL GERENTE 1 ES IGUAL AL GERENTE3 Y EL GERENTE 2 DIREFERENTE DEL GERENTE 3
                                            //ENTONCES IMPRIME 1 y 2 
                                        let nuevoPor3 =  data2[0].p3 / 2;
                                        let nuevoPorsaldo3 = data2[0].ps3 / 2;
                                        let porcentaje3=0;
                                        porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);
                                        let saldo3 = 0;
                                        saldo3 = total * (nuevoPorsaldo3 / 100);
                                        if(saldo3 > porcentaje3){
                                            saldo3 = porcentaje3;
                                        }
                                        let resto3 = 0;
                                        resto3 = porcentaje3 - saldo3;

                                        if(resto3 < 1){
                                            resto3=0;
                                        }else{
                                            resto3= porcentaje3 - saldo3;
                                        }
            
                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                            <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="3"><div class="col-md-3"><b><p>${data2[0].gerente}</p></b><p>Gerente</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                            <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleGe" id="disponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>
                                                </div>
                                            <div class="row"> 
                                            <input type="hidden" name="idGe2" value="${data2[0].idgerente2}"><input type="hidden" name="rolGe2" value="3"><div class="col-md-3"><b><p>${data2[0].gerente2}</p></b><p>Gerente</p><br></div>
                                            <div class="col-md-1"><input type="text" name="porGe2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                            <div class="col-md-2"><input type="text" name="totalGe2" id="totalGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="comisionGe2" id="comisionGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                            <div class="col-md-2"><input type="text" name="disponibleGe2" id="disponibleGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                            <div class="col-md-2"><input type="text" name="restoGe2" id="restoGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>`);


                                        }else if(data2[0].id_gerente != data2[0].idgerente2 && data2[0].id_gerente != data2[1].idgerente2 && data2[0].idgerente2 == data2[1].idgerente2 ){
                                            //SI EL GERENTE 1 DIREFENTE DEL GERENTE 2, Y GERENTE 1 DIFERENTE DEL GERENTE 3, Y EL GERENTE 2 IGUAL AL GERENTE 3 
                                            //ENTONCES IMPRIME 1 y 2 
                                            let nuevoPor3 =  data2[0].p3 / 2;
                                            let nuevoPorsaldo3 = data2[0].ps3 / 2;
                                            let porcentaje3=0;
                                            porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);
                                            let saldo3 = 0;
                                            saldo3 = total * (nuevoPorsaldo3 / 100);
                                            if(saldo3 > porcentaje3){
                                                saldo3 = porcentaje3;
                                            }
                                            let resto3 = 0;
                                            resto3 = porcentaje3 - saldo3;

                                            if(resto3 < 1){
                                                resto3=0;
                                            }else{
                                                resto3= porcentaje3 - saldo3;
                                            }
                                            
                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="${data2[0].rolGe}"><div class="col-md-3"><b><p>${data2[0].gerente}</p></b><p>Gerente</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleGe" id="disponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>
                                                    </div>
                                                <div class="row"> 
                                                <input type="hidden" name="idGe2" value="${data2[0].idgerente2}"><input type="hidden" name="rolGe2" value="${data2[0].rolGe}"><div class="col-md-3"><b><p>${data2[0].gerente2}</p></b><p>Gerente</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porGe2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                <div class="col-md-2"><input type="text" name="totalGe2" id="totalGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionGe2" id="comisionGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleGe2" id="disponibleGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoGe2" id="restoGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>`);


                                            }else if(data2[0].id_gerente != data2[0].idgerente2 && data2[0].id_gerente == data2[1].idgerente2 && data2[0].idgerente2 != data2[1].idgerente2 ){
                                                //SI EL GERENTE 1 ES IGUAL AL GERENTE 2, Y EL GERENTE 1 DIFERENTE DEL GERENTE 3, Y EL GERENTE 2 DIFERENTE DEL GERENTE 3
                                                //ENTONCES IMPRIME 1 Y 3 
                                            let nuevoPor3 =  data2[0].p3 / 2;
                                            let nuevoPorsaldo3 = data2[0].ps3 / 2;
                                            let porcentaje3=0;
                                            porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);
                                            let saldo3 = 0;
                                            saldo3 = total * (nuevoPorsaldo3 / 100);
                                            if(saldo3 > porcentaje3){
                                                saldo3 = porcentaje3;
                                            }
                                            let resto3 = 0;
                                            resto3 = porcentaje3 - saldo3;

                                            if(resto3 < 1){
                                                resto3=0;
                                            }else{
                                                resto3= porcentaje3 - saldo3;
                                            }
            
                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="${data2[0].rolGe}"><div class="col-md-3"><b><p>${data2[0].gerente}</p></b><p>Gerente</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleGe" id="disponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>
                                                    </div>
                                                <div class="row"> 
                                                <input type="hidden" name="idGe2" value="${data2[0].idgerente2}"><input type="hidden" name="rolGe2" value="${data2[0].rolGe}"><div class="col-md-3"><b><p>${data2[0].gerente2}</p></b><p>Gerente</p><br></div>
                                                <div class="col-md-1"><input type="text" name="porGe2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                <div class="col-md-2"><input type="text" name="totalGe2" id="totalGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="comisionGe2" id="comisionGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                <div class="col-md-2"><input type="text" name="disponibleGe2" id="disponibleGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                <div class="col-md-2"><input type="text" name="restoGe2" id="restoGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>`);

                                            }else if(data2[0].id_gerente != data2[0].idgerente2 && data2[0].id_gerente != data2[1].idgerente2 && data2[0].idgerente2 != data2[1].idgerente2 ){
                                                //SI EL GERENTE 1 DIREFENTE DEL GERENTE 2, Y GERENTE 1 DIFERENTE DEL GERENTE 3, Y EL GERENTE 2 DIFERENTE AL GERENTE 3 
                                                //ENTONCES IMPRIME 1 , 2 Y 3 

                                                let nuevoPor3 =  data2[0].p3 / 3;
                                                let nuevoPorsaldo3 = data2[0].ps3 / 3;
                                                let porcentaje3=0;
                                                porcentaje3 = data2[0].totalNeto2 * (nuevoPor3 / 100);
                                                let saldo3 = 0;
                                                saldo3 = total * (nuevoPorsaldo3 / 100);
                                                if(saldo3 > porcentaje3){
                                                    saldo3 = porcentaje3;
                                                    }
                                                let resto3 = 0;
                                                resto3 = porcentaje3 - saldo3;

                                                if(resto3 < 1){
                                                    resto3=0;
                                                }else{
                                                    resto3= porcentaje3 - saldo3;
                                                }
            
                                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                    <input type="hidden" name="idGe" value="${data2[0].id_gerente}"><input type="hidden" name="rolGe" value="${data2[0].rolGe}"><div class="col-md-3"><b><p>${data2[0].gerente}</p></b><p>Gerente</p><br></div>
                                                    <div class="col-md-1"><input type="text" name="porGe" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                    <div class="col-md-2"><input type="text" name="totalGe" id="totalGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="comisionGe" id="comisionGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                    <div class="col-md-2"><input type="text" name="disponibleGe" id="disponibleGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="restoGe" id="restoGe" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>
                                                        </div>
                                                    <div class="row"> 
                                                    <input type="hidden" name="idGe2" value="${data2[0].idgerente2}"><input type="hidden" name="rolGe2" value="${data2[0].rolGe}"><div class="col-md-3"><b><p>${data2[0].gerente2}</p></b><p>Gerente</p><br></div>
                                                    <div class="col-md-1"><input type="text" name="porGe2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                    <div class="col-md-2"><input type="text" name="totalGe2" id="totalGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="comisionGe2" id="comisionGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                    <div class="col-md-2"><input type="text" name="disponibleGe2" id="disponibleGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="restoGe2" id="restoGe2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>   
                                                    <div class="row"> 
                                                    <input type="hidden" name="idGe3" value="${data2[1].idgerente2}"><input type="hidden" name="rolGe2" value="3"><div class="col-md-3"><b><p>${data2[1].gerente2}</p></b><p>Gerente</p><br></div>
                                                    <div class="col-md-1"><input type="text" name="porGe3" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor3}"></div>
                                                    <div class="col-md-2"><input type="text" name="totalGe3" id="totalGe3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje3.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="comisionGe3" id="comisionGe3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                    <div class="col-md-2"><input type="text" name="disponibleGe3" id="disponibleGe3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto3.toFixed(3)}"></div>
                                                    <div class="col-md-2"><input type="text" name="restoGe3" id="restoGe3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo3.toFixed(3)}"></div></div>`);
                                                }
                                                /**------------------------------------------------------------ */

                                                /**-----------------------------SUB DIRECTOR------------------------- */

                                                if(data2[0].id_subdirector == data2[0].idsubdirector2 && data2[0].id_subdirector == data2[1].idsubdirector2 && data2[0].idsubdirector2 == data2[1].idsubdirector2)
                                                {
                                                    //SI TODOS LOS ID SON IGUALES SOLO IMPRIME 1
                                                    let nuevoPor4 =  data2[0].p4 ;
                                                    let nuevoPorsaldo4 = data2[0].ps4 ;
                                                    let porcentaje4=0;
                                                    porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                    let saldo4  = 0;
                                                    saldo4 = total * (nuevoPorsaldo4 / 100);
                                                    if(saldo4 > porcentaje4){
                                                        saldo4 = porcentaje4;
                                                        }
                                                    let resto4 = 0;
                                                    resto4 = porcentaje4 - saldo4;

                                                    if(resto4 < 1){
                                                        resto4=0;
                                                    }else{
                                                        resto4= porcentaje4 - saldo4;
                                                    }
            
                                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                        <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                        <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                        <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                        <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                        <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div></div>`);


                                                    }else if(data2[0].id_subdirector != data2[0].idsubdirector2 && data2[0].id_subdirector == data2[1].idsubdirector2 && data2[0].idsubdirector2 != data2[1].idsubdirector2 ){
                                                        //SI ES SUBDIRECTOR 1 ES DIREFENTE DEL SUBDIRECTOR 2, Y EL SUBDIRECTOR 1 ES IGUAL AL SUBDIRECTOR Y EL SUBDIRECTOR 2 DIREFERENTE DEL SUBDIRECTOR 3
                                                        //ENTONCES IMPRIME 1 y 2 
                                                        let nuevoPor4 =  data2[0].p4 / 2;
                                                        let nuevoPorsaldo4 = data2[0].ps4 / 2;
                                                        let porcentaje4=0;
                                                        porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                        let saldo4  = 0;
                                                        saldo4 = total * (nuevoPorsaldo4 / 100);
                                                        if(saldo4 > porcentaje4){
                                                            saldo4 = porcentaje4;
                                                            }
                                                        let resto4 = 0;
                                                        resto4 = porcentaje4 - saldo4;

                                                        if(resto4 < 1){
                                                            resto4=0;
                                                        }else{
                                                            resto4= porcentaje4 - saldo4;
                                                        }
            
                                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                            <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                            <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                            <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                            <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>
                                                                </div>
                                                            <div class="row"> 
                                                            <input type="hidden" name="idSub2" value="${data2[0].idsubdirector2}"><input type="hidden" name="rolSub2" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector2}</p></b><p>Sub director</p><br></div>
                                                            <div class="col-md-1"><input type="text" name="porSub2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                            <div class="col-md-2"><input type="text" name="totalSub2" id="totalSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="comisionSub2" id="comisionSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                            <div class="col-md-2"><input type="text" name="disponibleSub2" id="disponibleSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                            <div class="col-md-2"><input type="text" name="restoSub2" id="restoSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>`);

                                                        }else if(data2[0].id_subdirector != data2[0].idsubdirector2 && data2[0].id_subdirector != data2[1].idsubdirector2 && data2[0].idsubdirector2 == data2[1].idsubdirector2 ){
                                                            //SI EL GERENTE 1 DIREFENTE DEL SUBDIRECTOR 2, Y SUBDIRECTOR 1 DIFERENTE DEL SUBDIRECTOR 3, Y EL SUBDIRECTOR 2 IGUAL AL SUBDIRECTOR
                                                            //ENTONCES IMPRIME 1 y 2 
                                                            let nuevoPor4 =  data2[0].p4 / 2;
                                                            let nuevoPorsaldo4 = data2[0].ps4 / 2;
                                                            let porcentaje4=0;
                                                            porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                            let saldo4  = 0;
                                                            saldo4 = total * (nuevoPorsaldo4 / 100);
                                                            if(saldo4 > porcentaje4){
                                                                saldo4 = porcentaje4;
                                                                }
                                                            let resto4 = 0;
                                                            resto4 = porcentaje4 - saldo4;

                                                            if(resto4 < 1){
                                                                resto4=0;
                                                            }else{
                                                                resto4= porcentaje4 - saldo4;
                                                            }
            
                                                            $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                                <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>
                                                                    </div>
                                                                <div class="row"> 
                                                                <input type="hidden" name="idSub2" value="${data2[0].idsubdirector2}"><input type="hidden" name="rolSub2" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector2}</p></b><p>Sub director</p><br></div>
                                                                <div class="col-md-1"><input type="text" name="porSub2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                <div class="col-md-2"><input type="text" name="totalSub2" id="totalSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                <div class="col-md-2"><input type="text" name="comisionSub2" id="comisionSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                <div class="col-md-2"><input type="text" name="disponibleSub2" id="disponibleSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                <div class="col-md-2"><input type="text" name="restoSub2" id="restoSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>`);


                                                            }else if(data2[0].id_subdirector != data2[0].idsubdirector2 && data2[0].id_subdirector == data2[1].idsubdirector2 && data2[0].idsubdirector2 != data2[1].idsubdirector2 ){
                                                                //SI EL SUBDIRECTOR 1 ES IGUAL AL SUBDIRECTOR 2, Y EL SUBDIRECTOR 1 DIFERENTE DEL SUBDIRECTOR 3, Y EL SUBDIRECTOR 2 DIFERENTE DEL SUBDIRECTOR 3
                                                                //ENTONCES IMPRIME 1 Y 3 
                                                                let nuevoPor4 =  data2[0].p4 / 2;
                                                                let nuevoPorsaldo4 = data2[0].ps4 / 2;
                                                                let porcentaje4=0;
                                                                porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                                let saldo4  = 0;
                                                                saldo4 = total * (nuevoPorsaldo4 / 100);
                                                                if(saldo4 > porcentaje4){
                                                                    saldo4 = porcentaje4;
                                                                }
                                                                let resto4 = 0;
                                                                resto4 = porcentaje4 - saldo4;
                                                                if(resto4 < 1){
                                                                    resto4=0;
                                                                }else{
                                                                    resto4= porcentaje4 - saldo4;
                                                                }
                                                                
                                                                $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                    <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                                    <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                    <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                    <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div></div>
                                                                        </div>
                                                                    <div class="row"> 
                                                                    <input type="hidden" name="idSub2" value="${data2[0].idsubdirector2}"><input type="hidden" name="rolSub2" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector2}</p></b><p>Sub director</p><br></div>
                                                                    <div class="col-md-1"><input type="text" name="porSub2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                    <div class="col-md-2"><input type="text" name="totalSub2" id="totalSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="comisionSub2" id="comisionSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                    <div class="col-md-2"><input type="text" name="disponibleSub2" id="disponibleSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                    <div class="col-md-2"><input type="text" name="restoSub2" id="restoSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>`);

                                                                }else if(data2[0].id_subdirector != data2[0].idsubdirector2 && data2[0].id_subdirector != data2[1].idsubdirector2 && data2[0].idsubdirector2 != data2[1].idsubdirector2 ){
                                                                    //SI EL SUBDIRECTOR 1 DIREFENTE DEL SUBDIRECTOR 2, Y SUBDIRECTOR 1 DIFERENTE DEL SUBDIRECTOR 3, Y EL SUBDIRECTOR 2 DIFERENTE AL SUBDIRECTOR 3 
                                                                    //ENTONCES IMPRIME 1 , 2 Y 3 
                                                                    let nuevoPor4 =  data2[0].p4 / 3;
                                                                    let nuevoPorsaldo4 = data2[0].ps4 / 3;
                                                                    let porcentaje4=0;
                                                                    porcentaje4 = data2[0].totalNeto2 * (nuevoPor4 / 100);
                                                                    let saldo4  = 0;
                                                                    saldo4 = total * (nuevoPorsaldo4 / 100);
                                                                    if(saldo4 > porcentaje4){
                                                                        saldo4 = porcentaje4;
                                                                        }
                                                                    let resto4 = 0;
                                                                    resto4 = porcentaje4 - saldo4;

                                                                    if(resto4 < 1){
                                                                        resto4=0;
                                                                    }else{
                                                                        resto4= porcentaje4 - saldo4;
                                                                    }
            
                                                                    $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                        <input type="hidden" name="idSub" value="${data2[0].id_subdirector}"><input type="hidden" name="rolSub" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector}</p></b><p>Sub director</p><br></div>
                                                                        <div class="col-md-1"><input type="text" name="porSub" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                        <div class="col-md-2"><input type="text" name="totalSub" id="totalSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                        <div class="col-md-2"><input type="text" name="comisionSub" id="comisionSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                        <div class="col-md-2"><input type="text" name="disponibleSub" id="disponibleSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                        <div class="col-md-2"><input type="text" name="restoSub" id="restoSub" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>
                                                                            </div>
                                                                        <div class="row"> 
                                                                        <input type="hidden" name="idSub2" value="${data2[0].idsubdirector2}"><input type="hidden" name="rolSub2" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector2}</p></b><p>Sub director</p><br></div>
                                                                        <div class="col-md-1"><input type="text" name="porSub2" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                        <div class="col-md-2"><input type="text" name="totalSub2" id="totalSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                        <div class="col-md-2"><input type="text" name="comisionSub2" id="comisionSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                        <div class="col-md-2"><input type="text" name="disponibleSub2" id="disponibleSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                        <div class="col-md-2"><input type="text" name="restoSub2" id="restoSub2" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>   
                                                                        <div class="row"> 
                                                                        <input type="hidden" name="idSub3" value="${data2[1].idsubdirector2}"><input type="hidden" name="rolSub2" value="2"><div class="col-md-3"><b><p>${data2[0].subdirector2}</p></b><p>Sub director</p><br></div>
                                                                        <div class="col-md-1"><input type="text" name="porSub3" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor4}"></div>
                                                                        <div class="col-md-2"><input type="text" name="totalSub3" id="totalSub3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje4.toFixed(3)}"></div>
                                                                        <div class="col-md-2"><input type="text" name="comisionSub3" id="comisionSub3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                        <div class="col-md-2"><input type="text" name="disponibleSub3" id="disponibleSub3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto4.toFixed(3)}"></div>
                                                                        <div class="col-md-2"><input type="text" name="restoSub3" id="restoSub3" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo4.toFixed(3)}"></div></div>`);

                                                                    }

                                                                    /**-----------------DIRECTOR-------------------------------------- */
                                                                        let nuevoPor5 =  data2[0].p5 ;
                                                                        let nuevoPorsaldo5 = data2[0].ps5 ;
                                                                        let porcentaje5=0;
                                                                        porcentaje5 = data2[0].totalNeto2 * (nuevoPor5 / 100);
                                                                        let saldo5  = 0;
                                                                        saldo5 = total * (nuevoPorsaldo5 / 100);
                                                                        if(saldo5 > porcentaje5){
                                                                            saldo5 = porcentaje5;
                                                                            }
                                                                        let resto5 = 0;
                                                                        resto5 = porcentaje5 - saldo5;

                                                                        if(resto5 < 1){
                                                                            resto5=0;
                                                                        }else{
                                                                            resto5= porcentaje5 - saldo5;
                                                                        }
                                                                        
                                                                        $("#modal_NEODATA2 .modal-body").append(`<div class="row">   
                                                                            <input type="hidden" name="idDir" value="${data2[0].id_director}"><input type="hidden" name="rolDir" value="1"><div class="col-md-3"><b><p>${data2[0].director}</p></b><p>Director</p><br></div>
                                                                            <div class="col-md-1"><input type="text" name="porDir" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${nuevoPor5}"></div>
                                                                            <div class="col-md-2"><input type="text" name="totalDir" id="totalDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${porcentaje5.toFixed(3)}"></div>
                                                                            <div class="col-md-2"><input type="text" name="comisionDir" id="comisionDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>
                                                                            <div class="col-md-2"><input type="text" name="disponibleDir" id="disponibleDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${resto5.toFixed(3)}"></div>
                                                                            <div class="col-md-2"><input type="text" name="restoDir" id="restoDir" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="${saldo5.toFixed(3)}"></div></div></div>`);
                                                                            
                                                                            if(lugar_3 == '6' || lugar_3 == 6)      
                                                                    {
                                                                    $("#modal_NEODATA2 .modal-body").append('<div class="row"><input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idMk" value="'+data2[0].id_mk2+'"><input type="hidden" name="rolMk" value="38">'+
                                                                    '<div class="col-md-3"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+data2[0].marketing2+'" style="font-size:12px;"><b><p style="font-size:12px;">Marketing</p></b></div>'
                                                                    +'<div class="col-md-1"><input type="text" name="porMk" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+data2[0].p62+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="totalMk" id="totalMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+porcentaje5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="comisionMk" id="comisionMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="disponibleMk" id="diponibleMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+resto5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="restoMk" id="restoMk" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+saldo5.toFixed(3)+'"></div></div>');
                                                                    }
                                                                    else{
                                                                        $("#modal_NEODATA2 .modal-body").append('<div class="row">'
                                                                        +'<input id="id_disparador" type="hidden" name="id_disparador" value="0">'
                                                                        +'<input type="hidden" name="idMk" value="0">'
                                                                        +'<input type="hidden" name="rolMk" value="0">'
                                                                        +'<div class="col-md-1"><input type="hidden" name="porMk" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="totalMk" id="totalMk" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="comisionMk" id="comisionMk" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="disponibleMk" id="diponibleMk"  value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="restoMk" id="restoMk" value="0"></div></div>');

                                                                    }


                                                                    if(lugar_3 == '12' || lugar_3 == 12)      
                                                                    {
                                                                    $("#modal_NEODATA2 .modal-body").append('<div class="row"><input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idCb" value="'+data2[0].id_cb2+'"><input type="hidden" name="rolCb" value="42">'+
                                                                    '<div class="col-md-3"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+data2[0].club_maderas2+'" style="font-size:12px;"><b><p style="font-size:12px;">Marketing</p></b></div>'
                                                                    +'<div class="col-md-1"><input type="text" name="porCb" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+data2[0].p62+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="totalCb" id="totalCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+porcentaje5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="comisionCb" id="comisionCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="disponibleCb" id="diponibleCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+resto5.toFixed(3)+'"></div>'
                                                                    +'<div class="col-md-2"><input type="text" name="restoCb" id="restoCb" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+saldo5.toFixed(3)+'"></div></div>');
                                                                    }
                                                                    else{
                                                                        $("#modal_NEODATA2 .modal-body").append('<div class="row">'
                                                                        +'<input id="id_disparador" type="hidden" name="id_disparador" value="0">'
                                                                        +'<input type="hidden" name="idCb" value="0">'
                                                                        +'<input type="hidden" name="rolCb" value="0">'
                                                                        +'<div class="col-md-1"><input type="hidden" name="porCb" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="totalCb" id="totalCb" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="comisionCb" id="comisionCb" value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="disponibleCb" id="diponibleCb"  value="0"></div>'
                                                                        +'<div class="col-md-2"><input type="hidden" name="restoCb" id="restoCb" value="0"></div></div>');

                                                                    }



                                                                if(lugar_3 != '6' && lugar_3 != 6 && lugar_3 != 12 && lugar_3 != '12')      
                                                                {
                                                                    console.log("empresa");
                                                                $("#modal_NEODATA2 .modal-body").append('<div class="row"><input id="id_disparador" type="hidden" name="id_disparador" value="0"><input type="hidden" name="idEm" value="4824"><input type="hidden" name="rolEm" value="45">'+
                                                                '<div class="col-md-3"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="Empresa Abonos" style="font-size:12px;"><b><p style="font-size:12px;">Empresa</p></b></div>'
                                                                +'<div class="col-md-1"><input type="text" name="porEm" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="1"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="totalEm1" id="totalEm1" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+porcentaje5.toFixed(3)+'"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="comisionEm" id="comisionEm" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="0"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="disponibleEm" id="diponibleEm" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+resto5.toFixed(3)+'"></div>'
                                                                +'<div class="col-md-2"><input type="text" name="restoEm" id="restoEm" readonly  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+saldo5.toFixed(3)+'"></div></div>');
                                                                }
                                                                else{
                                                                    console.log("no empresa");

                                                                    $("#modal_NEODATA2 .modal-body").append('<div class="row">'
                                                                    +'<input id="id_disparador" type="hidden" name="id_disparador" value="0">'
                                                                    +'<input type="hidden" name="idEm" value="0">'
                                                                    +'<input type="hidden" name="rolEm" value="0">'
                                                                    +'<div class="col-md-1"><input type="hidden" name="porEm" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="totalEm1" id="totalEm1" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="comisionEm" id="comisionEm" value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="disponibleEm" id="diponibleEm"  value="0"></div>'
                                                                    +'<div class="col-md-2"><input type="hidden" name="restoEm" id="restoEm" value="0"></div></div>');

                                                                }
                                                                

                                                                    $("#modal_NEODATA2 .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" id="dispersarc02" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
                                                                    // $('#dispersarc02').prop('disabled', true);

                                                                    /**----------------------------------------------------------------------------------------------------- */

                                                                }
                                                            });
                                                                // else if(data2.length == 0){
                                                                //     alert("NELSON")
                                                                // }
                    
                  } 
                  
                  

                  else if(registro_status==1){

$.getJSON( url + "Comisiones/getDatosAbonadoSuma11/"+idLote).done( function( data1 ){
    let total0 = parseFloat((data[0].Aplicado));
    let total = 0;
    
    if(total0 > 0){
        total = total0;
    }else{
        total = 0; 
    }

    // let total = 100000;
    var counts=0;
    // console.log(total);
    $("#modal_NEODATA2 .modal-header").append('<div class="row">'+
    '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney(data1[0].total_comision)+'</b></div>'+
    '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney(data1[0].abonado)+'</b></div>'+
    '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney((data1[0].total_comision)-(data1[0].abonado))+'</b></div></div>');


    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4>Aplicado neodata: <b>$'+formatMoney(data[0].Aplicado)+'</b></h4></div></div>');
    // $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4>Cliente neodata: <b>$'+formatMoney(data[0].AplicadoCliente)+'</b></h4></div></div>');
    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><i class="fa fa-info-circle" style="color:gray;"></i> Saldo diponible para <i>'+row.data().nombreLote+'</i>: <b>$'+formatMoney(total0-data1[0].abonado)+'</b></h3></div></div><br>');


    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Precio lote: $'+formatMoney(data1[0].totalNeto2)+'</b></h4></div></div><br>');


$.getJSON( url + "Comisiones/getDatosAbonadoDispersion/"+idLote).done( function( data ){
    $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-3"><p style="font-zise:10px;"><b>USUARIOS</b></p></div><div class="col-md-1"><b>%</b></div><div class="col-md-2"><b>TOT. COMISIÓN</b></div><div class="col-md-2"><b><b>ABONADO</b></div><div class="col-md-2"><b>PENDIENTE</b></div><div class="col-md-2"><b>DISPONIBLE</b></div></div>');

    $.each( data, function( i, v){
     //   console.log(data);
        pending = (v.comision_total-v.abono_pagado);
console.log(v.porcentaje_saldos);
       let nuevosaldo = 0;
       let nuevoabono=0;
       let evaluar =0;

       if( v.rol_generado == 7 && v.porcentaje_decimal == 1.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;
        }else  if( v.rol_generado == 7 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.3333333333333333){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.33333000000000002){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }
        else if( v.rol_generado == 3 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) / 2;   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.3333333333333333){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.33333000000000002){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.66666000000000003){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        }
        else if( v.rol_generado == 2 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
        }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.5){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.3333333333333333){
            nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        }else if( v.rol_generado == 1 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 38 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 42 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }else if( v.rol_generado == 45 && v.porcentaje_decimal == 1){
            nuevosaldo = parseFloat(v.porcentaje_saldos);   
        }

        // if( v.rol_generado == 7 && v.porcentaje_decimal == 1.5){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /2;
        // }else  if( v.rol_generado == 7 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        // }else if( v.rol_generado == 9 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
        // }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.5){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        // }else if( v.rol_generado == 9 && v.porcentaje_decimal == 0.3333333333333333){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        // }else if( v.rol_generado == 3 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos);   
        // }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.5){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) / 2;   
        // }else if( v.rol_generado == 3 && v.porcentaje_decimal == 0.3333333333333333){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        // }else if( v.rol_generado == 2 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) ;   
        // }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.5){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /2;   
        // }else if( v.rol_generado == 2 && v.porcentaje_decimal == 0.3333333333333333){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos) /3;   
        // }else if( v.rol_generado == 1 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos);   
        // }else if( v.rol_generado == 38 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos);   
        // }else if( v.rol_generado == 42 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos);   
        // }else if( v.rol_generado == 45 && v.porcentaje_decimal == 1){
        //     nuevosaldo = parseFloat(v.porcentaje_saldos);   
        // }

        //console.log(nuevosaldo);
        saldo = ((nuevosaldo/100)*(total));
        // alert(v.porcentaje_saldos);
        // console.log(v.porcentaje_saldos);
        // console.log(total);
        // console.log(saldo);
       /* nuevoabono = saldo - v.abono_pagado;

        if(nuevoabono < 0){

        }else{

        }*/

        console.log("saldo"+saldo);

        if(v.abono_pagado>0){
                                    console.log("OPCION 1");


                                   evaluar = (v.comision_total-v.abono_pagado);

                                    if(evaluar<1){
                                        pending = 0;
                                        saldo = 0;
                                    }
                                    else{
                                        pending = evaluar;
                                    }
                                    
                                    nuevoabono = saldo-v.abono_pagado;
                                    
                                    if(nuevoabono<1){
                                        console.log("entra aqui 1");
                                        saldo = 0;
                                    }
                                    else if(nuevoabono>=1){
                                        console.log("entra aqui 2");

                                        if(nuevoabono>pending){
                                            saldo = pending;
                                        }
                                        else{
                                            saldo = saldo-v.abono_pagado;

                                        }
                                        
                                    }


                                    

                                }
                                else if(v.abono_pagado<=0){

                                    console.log("OPCION 2");

                                    pending = (v.comision_total);

                                if(saldo > pending){
                                    saldo = pending;
                                }
                                
                                if(pending < 1){
                                    saldo = 0;
                                }
                                }
        /* */

        if(saldo > pending){
            saldo = pending;
        }
        
        if(pending < 1){
            saldo = 0;
            pending = 0;
        }




        $("#modal_NEODATA2 .modal-body").append('<div class="row">'
        +'<div class="col-md-3"><input id="id_disparador" type="hidden" name="id_disparador" value="1"><input type="hidden" name="pago_neo" id="pago_neo" value="'+total.toFixed(3)+'"><input type="hidden" name="pending" id="pending" value="'+pending+'"><input type="hidden" name="idLote" id="idLote" value="'+idLote+'"><input id="rol" type="hidden" name="id_comision[]" value="'+v.id_comision+'"><input id="rol" type="hidden" name="rol[]" value="'+v.id_usuario+'"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.colaborador+'" style="font-size:12px;"><b><p style="font-size:12px;">'+v.rol+'</p></b></div>'

        +'<div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.porcentaje_decimal+'%"></div>'
        +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.comision_total)+'"></div>'
        +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.abono_pagado)+'"></div>'
        +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(pending)+'"></div>'
        +'<div class="col-md-2"><input id="abono_nuevo'+counts+'" onkeyup="nuevo_abono('+counts+');" class="form-control ng-invalid ng-invalid-required abono_nuevo"  name="abono_nuevo[]" value="'+saldo+'" type="hidden">'
        +'<input class="form-control ng-invalid ng-invalid-required" readonly="true" name="" value="'+formatMoney(saldo)+'"></div>'+'</div>');
        
        counts++
    });
    console.log('dfsfsfsdf'+counts);
});
$("#modal_NEODATA2 .modal-footer").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-success" name="disper_btn" id="dispersar" value="Dispersar"></div><div class="col-md-3"><input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR"></div></div>');
if(total < 1 ){
    $('#dispersar').prop('disabled', true);
}
});

} 

//                   else if(registro_status==1)
//                   {
 

// }
                                       
                    break;
                    case '2':
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No se encontró esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '3':
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No tiene vivienda, si hay referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '4':
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>No hay pagos aplicados a esta referencia de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    case '5':
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Referencia duplicada de '+row.data().nombreLote+'.</b></h4><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                    break;
                    default:
                        $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h4><b>Sin localizar.</b></h4><br><h5>Revisar con sistemas: '+row.data().nombreLote+'.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
                        
                    break;
                }
            }
            else{
                console.log("entra 2");
                 $("#modal_NEODATA2 .modal-body").append('<div class="row"><div class="col-md-12"><h3><b>No se encontró esta referencia en NEODATA de '+row.data().nombreLote+'.</b></h3><br><h5>Revisar con Administración.</h5></div> <div class="col-md-12"><center><img src="'+url+'static/images/robot.gif" width="320" height="300"></center></div> </div>');
            }
            });

            $("#modal_NEODATA2").modal();

        });

/**----------------------------------------------------------------------------------------------------------------- */





$("#form_NEODATA").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            $('#loader').removeClass('hidden');
 
                    var data = new FormData( $(form)[0] );
                    
 
                    $.ajax({
                        url: url + 'Comisiones/InsertNeo',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data){

                            if( data == 1 ){
                                $('#loader').addClass('hidden');

                                alert("Dispersión guardada con exito.");
                                tabla_1.ajax.reload();
                                 $("#modal_NEODATA").modal( 'hide' );
                                 
                            }else{
                                $('#loader').addClass('hidden');
                                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                            }
                        },error: function(){
                            $('#loader').addClass('hidden');
                            alert("ERROR EN EL SISTEMA");
                        }
                    });

             
        }
    });   


$("#form_enganche").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/enganche_comision",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#loader').addClass('hidden');
                        $("#modal_enganche").modal('toggle');
                        tabla_1.ajax.reload();
                        alert("¡Se agregó con éxito!");
                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
    }
});




$("#form_pagadas").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/liquidar_comision",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(true){
                        $('#loader').addClass('hidden');
                        $("#modal_pagadas").modal('toggle');
                        tabla_1.ajax.reload();
                        alert("¡Se agregó con éxito!");


                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#loader').addClass('hidden');
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
    }
});



 
$("#form_NEODATA2").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            $('#loader').removeClass('hidden');
                    var data = new FormData( $(form)[0] );
                    $.ajax({
                        url: url + 'Comisiones/InsertNeoCompartida',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data){
                            if( data == 1 ){
                                $('#loader').addClass('hidden');
                                tabla_1.ajax.reload();
                                alert("Dispersión guardada con exito.");
                                 $("#modal_NEODATA2").modal( 'hide' ); 
                            }else{
                                $('#loader').addClass('hidden');
                                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                            }
                        },error: function(){
                            $('#loader').addClass('hidden');
                            alert("ERROR EN EL SISTEMA");
                        }
                    });

             
        }
    });

jQuery(document).ready(function(){

	jQuery('#editReg').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');
	jQuery(this).find('#comentario').val('');
	jQuery(this).find('#totalNeto').val('');
	jQuery(this).find('#totalNeto2').val('');
	})

	jQuery('#rechReg').on('hidden.bs.modal', function (e) {
	jQuery(this).removeData('bs.modal');
	jQuery(this).find('#comentario3').val('');
    })
    


    function myFunctionD2(){
    formatCurrency($('#inputEdit'));
    }

})

$('.decimals').on('input', function () {
  this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});

function SoloNumeros(evt){
	if(window.event){
	keynum = evt.keyCode; 
	}
	else{
	keynum = evt.which;
	} 

	if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
	return true;
	}
	else{
		alerts.showNotification("top", "left", "Solo Numeros.", "danger");
	return false;
	}
}

function closeModalEng(){
    $("#modal_enganche").modal('toggle');
}




function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

 


    function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}

</script>

