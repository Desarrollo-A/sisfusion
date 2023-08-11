
<body class="">
<div class="wrapper ">
<?php

if ($this->session->userdata('id_rol') == "28" ) //
{
    $this->load->view('template/sidebar');
}else {
    echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
}


?>
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



<!--<div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
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
</div>-->


<!-- modal  AGREGAR PLAN DE ENGANCHE-->
<!--<div class="modal fade modal-alertas" id="modal_enganche" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
            </div>
            <form method="post" id="form_enganche">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->
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


/*$("#form_enganche").submit( function(e) {
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
});*/




/*$("#form_pagadas").submit( function(e) {
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
});*/



 
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

/*jQuery(document).ready(function(){

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

})*/

/*$('.decimals').on('input', function () {
  this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
});*/

/*function SoloNumeros(evt){
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
}*/

/*function closeModalEng(){
    $("#modal_enganche").modal('toggle');
}*/




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

