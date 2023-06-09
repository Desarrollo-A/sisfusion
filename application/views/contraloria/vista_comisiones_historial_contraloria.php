
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/contraloria/sidebar'); ?>
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
    </style>

    <div class="modal fade modal-alertas" id="modal_comisiones_hist" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h4 class="modal-title">[sin datos].</h4>
                </div>
                <form method="post" id="form_interes">
                    <div class="modal-body">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid"> 
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="blue">
                            COMISIONES <b>HISTORIAL</b>
                             <span style="font-size: 10px;"> (Gestión de solicitudes por comisiones)</span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title"></h4>
                            <div class="toolbar">
                             </div>
                            <div class="material-datatables"> 

                                <div class="form-group">
                                    <div class="table-responsive">
 
                                        <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_historial_comisiones" name="tabla_historial_comisiones">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">PROYECTO</th>
                                                <th style="font-size: .9em;">CONDOMINIO</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;"></th>
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


    var url = "http://localhost:9081/sisfusion/";
var url2 = "<?=base_url()?>index.php/";



     $("#tabla_historial_comisiones").ready( function(){

    $('#tabla_historial_comisiones thead tr:eq(0) th').each( function (i) {

       if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_comisiones_hist.column(i).search() !== this.value ) {
                tabla_comisiones_hist
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
 

    tabla_comisiones_hist = $("#tabla_historial_comisiones").DataTable({
      // dom: 'Brtip',
      width: 'auto',
  
"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
"processing": true,
"pageLength": 10,
"bAutoWidth": false,
"bLengthChange": false,
"scrollX": true,
"bInfo": false,
"searching": true,
"ordering": false,
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
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
    }
}, 
 
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
    }
},
{
    "width": "20%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
    }
}, 



{
    "width": "25%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.primerNombre+" "+d.segundoNombre+" "+d.apellidoMaterno+" "+d.apellidoPaterno+'</p>';
    }
}, 
 
{ 
    "width": "12%",
    "orderable": false,
    "data": function( data ){

        opciones = '<div class="btn-group" role="group">';
        opciones += '<button class="btn btn-just-icon btn-round btn-linkedin agregar_estatus_comisiones" title="Registrar ingreso de expediente" value="'+data.nombreLote+'" data-value="'+data.idLote+'" style="background:#0FC6C6;"><i class="material-icons">beenhere</i></button>';
        return opciones + '</div>';
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
    "url": url2 + "registroCliente/getregistrosClientes",
    "dataSrc": "",
    "type": "POST",
    cache: false,
    "data": function( d ){
    }
},
"order": [[ 1, 'asc' ]]

});

 

 $('#tabla_historial_comisiones tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tabla_comisiones_hist.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
    }
    else {

        var informacion_adicional = '<table class="table text-justify">'+
        '<tr>GERENTE(S) <b>'+row.data().primerNombre+' '+row.data().segundoNombre+row.data().apellidoPaterno+row.data().apellidoMaterno+'</b>'+
        '<td style="font-size: .8em"><strong>ASESOR(ES): </strong>'+row.data().idCliente+'</td>'+
        '<td style="font-size: .8em"><strong>CALLE: </strong>'+row.data().idCliente+'</td>'+
        '</tr>'+
        '</table>';

        row.child( informacion_adicional ).show();
        tr.addClass('shown');
        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
    }
});



     

    $("#tabla_historial_comisiones tbody").on("click", ".agregar_estatus_comisiones", function(){

        nombreLote = $(this).val();
        IDLote =  $(this).attr("data-value");

        $("#modal_comisiones_hist .modal-body").html("");

        $("#modal_comisiones_hist .modal-body").append('<div class="row"><div class="col-lg-12"><label><h4>¿Está seguro de registrar el ingreso de <b>'+nombreLote+'</b>?</h4></label></div></div>');

        $("#modal_comisiones_hist .modal-body").append('<div class="row"><div class="col-lg-2">&nbsp;</div><div class="col-lg-8"><center><button class="btn btn-social btn-fill btn-info boton_aceptar" style="background:green;margin-right: 10px;" value="'+IDLote+'">ACEPTAR</button><button class="btn btn-social btn-fill btn-danger" data-dismiss="modal" >CANCELAR</button></center></div></div>');
        $("#modal_comisiones_hist").modal();
});

 
}); 



$(document).on("click", ".boton_aceptar", function(){
    indexLote = $(this).val();

    alert(indexLote);

    // $.getJSON(url2 + "Contraloria/registrar_estatus_comisiones/"+indexLote).done(function( data ){
    //      if(data){

    //         alert("todo chido");
    //      }
    //         else{

    //             alert("nel baby");

    //         }

    // });

    // MANTENER ESTE CODIGO Y ADECUARLO AL QUERY CORRESPONDIENTE AL TENER LA BASE DE DATOS
});


    



 
  $(window).resize(function(){
        tabla_comisiones_hist.columns.adjust();
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
 
</script>

