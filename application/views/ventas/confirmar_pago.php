
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
            .addNewRecord {    
                background-image: linear-gradient(to bottom, #ffffff,#e0ffff 100%) !important;   
            }
        }
    </style>

	<div class="content">
        <div class="container-fluid">
 
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">

                    <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <br>
                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_nuevas" id="myText_nuevas"></label>
                     
                    </label>
                    </div>

 
                        <div class="card-content">
                            <h3 class="card-title center-align">Comisiones - <b>Confirmar pago</b></h3>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
									<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_confirmar_contraloria" name="tabla_confirmar_contraloria" style="text-align:center;">

								        <thead>
                                            <tr>
											    <th></th>
                                                <th style="font-size: .9em;">ID PAGO</th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .8em;">PRECIO LOTE</th>
                                                <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                <th style="font-size: .8em;">ABONO NEO.</th>
                                                <th style="font-size: .8em;">PAGADO</th>
                                                <th style="font-size: .8em;">PENDIENTE</th>
                                                <th style="font-size: .9em;">USUARIO</th>
                                                <th style="font-size: .9em;">PUESTO</th>
                                                <th style="font-size: .8em;"></th>
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




<!-- modal  CONFIRMAR PAGO-->
<div class="modal fade modal-alertas" id="modal_confirmPay" role="dialog">
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


var getInfo1 = new Array(6);
var getInfo3 = new Array(6);


$("#tabla_confirmar_contraloria").ready( function(){

    let titulos = [];
$('#tabla_confirmar_contraloria thead tr:eq(0) th').each( function (i) {

   if(i != 0 && i != 11){
    var title = $(this).text();
    titulos.push(title);

	$(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
	$( 'input', this ).on('keyup change', function () {
		// if (tabla_1.column(i).search() !== this.value ) {
		// 	tabla_1
		// 	.column(i)
		// 	.search(this.value)
		// 	.draw();
        // }
        
        if (tabla_1.column(i).search() !== this.value ) {
            tabla_1
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_1.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_1.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_nuevas").value = formatMoney(total);
        }


	} );
}
});

$('#tabla_confirmar_contraloria').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.pago_cliente);
    });
    var to = formatMoney(total);
    document.getElementById("myText_nuevas").value = to;
});


tabla_1 = $("#tabla_confirmar_contraloria").DataTable({
  dom: 'Bfrtip',
  "buttons": [
      {
          extend: 'excelHtml5',
          text: 'Excel',
          className: 'btn btn-success',
          titleAttr: 'Excel',
          exportOptions: {
              columns: [1,2,3,4,5,6,7, 8, 9, 10],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }else if(columnIdx == 11){
                            return ' '+d +' ';
                        }
                        else if(columnIdx != 11 && columnIdx !=0){
                            if(columnIdx == 11){
                                return 'SEDE ';
                            }
                            if(columnIdx == 12){
                                return 'TIPO'
                            }
                            else{
                                return ' '+titulos[columnIdx-1] +' ';
                            }
                        }
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
{
"width": "3%",
"className": 'details-control',
"orderable": false,
"data" : null,
"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
},
{
    "width": "5%",
	"data": function( d ){
        var lblStats;
        lblStats ='<p style="font-size: .8em"><b>'+d.id_pago_i+'</b></p>';
		return lblStats;
    }
},
{
    "width": "10%",
    "data": function( d ){
    return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
}
},
{
    "width": "9%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
}
},
{
    "width": "9%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
}
},

{
    "width": "9%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
}
},
{
    "width": "9%",
    "data": function( d ){
    return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
}
},
{
    "width": "9%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
}
},
{
    "width": "10%",
    "data": function( d ){
        if(d.restante==null||d.restante==''){
            return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+'</p>';
        }else{
            return '<p style="font-size: .8em">$'+formatMoney(d.restante)+'</p>';
        }
    }
}, 
{
    "width": "10%",
    "data": function( d ){
    return '<p style="font-size: .8em">'+d.user_names+'</p>';
}
},

{
    "width": "10%",
    "data": function( d ){
    return '<p style="font-size: .8em"><b>'+d.puesto+'</b></p>';
}
},
{ 
    "width": "10%",
    "orderable": false,
    "data": function( data ){
        var BtnStats;
        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' +
			 'class="btn btn-success btn-round btn-fab btn-fab-mini confirmPayment" title="Verificar en NEODATA">' +
             '<span class="material-icons">check_circle</span></button>&nbsp;&nbsp;';
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
 "url": '<?=base_url()?>index.php/Comisiones/getDatosConfirmarPago',
"dataSrc": "",
"type": "POST",
cache: false,
"data": function( d ){
}
},
"order": [[ 1, 'asc' ]]

});

$('#tabla_confirmar_contraloria tbody').on('click', 'td.details-control', function () {
		 var tr = $(this).closest('tr');
		 var row = tabla_1.row(tr);

		 if (row.child.isShown()) {
			 row.child.hide();
			 tr.removeClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
		 } else {
			var status;
 
			 
			 var informacion_adicional = '<table class="table text-justify">' +
				 '<tr><b>INFORMACIÓN ADICIONAL</b>:' +
				 '<td style="font-size: .8em"><strong>PORCENTAJE A COMISIONAR: </strong>' + row.data().porcentaje_decimal + '%</td>' +
 				 '<td style="font-size: .8em"><strong>FECHA PAGO: </strong>' + row.data().fecha_creacion + '</td>' +
				 '</tr>' +
				 '</table>';


			 row.child(informacion_adicional).show();
			 tr.addClass('shown');
			 $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
		 }
     });
     
     $("#tabla_confirmar_contraloria tbody").on("click", ".confirmPayment", function(){
            var tr = $(this).closest('tr');
            var row = tabla_1.row( tr );
            id_pago_i = $(this).val();
 
            $("#modal_confirmPay .modal-body").html("");
            $("#modal_confirmPay .modal-body").append('<h4 class="modal-title">¿Esta seguro que el pago por <b>$'+formatMoney(row.data().pago_cliente)+'</b> correspondiente al lote <b>'+row.data().nombreLote+'</b> fue pagado correctamente a <b>'+row.data().user_names+'</b>?</h4>');
            $("#modal_confirmPay .modal-body").append('<input type="hidden" name="idPagoInd" value="'+id_pago_i+'">');

            $("#modal_confirmPay .modal-body").append('<div class="row"><div class="col-md-12"><br></div></div>');
            $("#modal_confirmPay .modal-body").append('<div class="row"><div class="col-md-3"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><input type="button" class="btn btn-danger" value="CANCELAR" onclick="closeModalEng()"></div><div class="col-md-3"></div></div>');
            $("#modal_confirmPay").modal();
        });
});







$("#form_enganche").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/setConfirmarPago",
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
                        $("#modal_confirmPay").modal('toggle');
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

})



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

function closeModalEng(){
    $("#modal_confirmPay").modal('toggle');
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


</script>

