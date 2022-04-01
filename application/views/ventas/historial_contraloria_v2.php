<body>
<div class="wrapper">

    <?php


  if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17"  || $this->session->userdata('id_rol')=="28" || $this->session->userdata('id_rol')=="32"|| $this->session->userdata('id_rol')=="18"  )//contraloria
    {
        /*-------------------------------------------------------*/
$datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
    }
    else
    {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
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
    th {
        background: #003D82;
        color: white;
    }

    .textoshead::placeholder { color: white; }

</style>

    <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                    </button>
                    <h4 class="modal-title">Consulta información</h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab">Bitácora de cambios</a></li>
                        </ul>
                        <!-- Tab panes -->
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->

<!--<div class="modal fade modal-alertas" id="modal_despausar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="form_despausar">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->

<!--<div class="modal fade modal-alertas" id="modal_refresh" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="form_refresh">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>-->


<!--<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
        <div class="modal-dialog" style="width:800px; margin-top:20px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>-->



 
<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
    <div class="modal-dialog" style= "margin-top:20px;"></div>
</div>


<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>-->

<!--<div class="modal fade bd-example-modal-sm" id="myModalTQro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
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
                                    <div class="tab-pane active" id="ASIMILADOS-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title" >HISTORIAL - <b>GENERAL</b></h4>
                                                                    <p class="category">Listado de todos los pagos aplicados y en proceso.</b></p>
                                                                </div>

                                                                <!-- <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totpagarAsimilados" id="totpagarAsimilados"></label>
                                                                    
                                                                </div> -->

                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                        <div class="form-group">
                                                                            <label for="proyecto">Proyecto:</label>
                                                                            <select name="filtro33" id="filtro33" class="selectpicker" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required> <option value="0">Seleccione todo</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                                        <div class="form-group">
                                                                            <label>Condominio</label>
                                                                            <select class="selectpicker" id="filtro44" name="filtro44[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required/></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                                                                 <thead>
                                                                                    

                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th style="font-size: .9em;" id="th_pago">ID PAGO</th>
                                                                                    <th style="font-size: .9em;" id="th_lote">LOTE</th>
                                                                                    <th style="font-size: .8em;" id="th_precio">PRECIO LOTE</th>
                                                                                    <th style="font-size: .8em;" id="th_totalcom">TOTAL COM. ($)</th>
                                                                                    <th style="font-size: .8em;" id="th_paycliente">PAGO CLIENTE</th>
                                                                                    <th style="font-size: .8em;" id="th_abononeo">ABONO NEO.</th>
                                                                                    <th style="font-size: .8em;" id="th_pagado">PAGADO</th>
                                                                                    <th style="font-size: .8em;" id="th_pendiente">PENDIENTE</th>
                                                                                    <th style="font-size: .9em;" id="th_usuario">USUARIO</th>
                                                                                    <th style="font-size: .9em;" id="th_PUESTO">PUESTO</th>
                                                                                    <th style="font-size: .9em;" id="th_estatus">ESTATUS</th>
                                                                                    <th style="font-size: .8em;" id="th_more">MÁS</th>
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

    function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        myCommentsList.innerHTML = '';
    }


$('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();

        if(i != 0 && i != 12){

        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
                $('#tabla_historialGral').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );

    }
    });



    $(document).ready(function() {
        $("#tabla_historialGral").prop("hidden", true);

        var url = "<?=base_url()?>/index.php/";
        $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro3").selectpicker('refresh');
        }, 'json');

        $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro33").selectpicker('refresh');
        }, 'json');


        $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#filtro333").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#filtro333").selectpicker('refresh');
        }, 'json');
    });

    $('#filtro3').change(function(ruta){
        residencial = $('#filtro3').val();
        $("#filtro4").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro4").append($('<option>').val(id).text(name));
                    }
                    $("#filtro4").selectpicker('refresh');

                }
            });
    });

        $('#filtro33').change(function(ruta){
        residencial = $('#filtro33').val();
        $("#filtro44").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro44").append($('<option>').val(id).text(name));
                    }
                    $("#filtro44").selectpicker('refresh');

                }
            });
    });

    $('#filtro3').change(function(ruta){
        proyecto = $('#filtro3').val();
        condominio = $('#filtro4').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getInvoiceCommissions(proyecto, condominio);
    });

    $('#filtro4').change(function(ruta){
        proyecto = $('#filtro3').val();
        condominio = $('#filtro4').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getInvoiceCommissions(proyecto, condominio);
    });


    $('#filtro33').change(function(ruta){
        proyecto = $('#filtro33').val();
        condominio = $('#filtro44').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        console.log(proyecto);
        console.log(condominio);
        getAssimilatedCommissions(proyecto, condominio);
    });

    $('#filtro44').change(function(ruta){
        proyecto = $('#filtro33').val();
        condominio = $('#filtro44').val();
        if(condominio == '' || condominio == null || condominio == undefined){
            condominio = 0;
        }
        getAssimilatedCommissions(proyecto, condominio);
    });

    $('#filtro333').change(function(ruta){
        proyecto = $('#filtro333').val();
        getHistoryCommissions(proyecto);
    });




    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var totalLeon = 0;
    var totalQro = 0;
    var totalSlp = 0;
    var totalMerida = 0;
    var totalCdmx = 0;
    var totalCancun = 0;
    var tr;
    var tabla_historialGral2 ;
    var totaPen = 0;
//INICIO TABLA QUERETARO****************************************************************************************


  function getAssimilatedCommissions(proyecto, condominio){
      let titulos = [];
        

      $(".textoshead::placeholder").css( "color", "white" );

    //   $('#tabla_historialGral').on('xhr.dt', function(e, settings, json, xhr) {
    //         var total = 0;
    //         $.each(json.data, function(i, v) {
    //             total += parseFloat(v.pago_cliente);
    //         });
    //         var to = formatMoney(total);
    //         document.getElementById("totpagarAsimilados").value = to;
    //     });



    $("#tabla_historialGral").prop("hidden", false);
    tabla_historialGral2 = $("#tabla_historialGral").DataTable({
    dom: 'Brtip',
    width: 'auto',
    "buttons": [

 
        {
            extend: 'excelHtml5',
            text: 'Excel',
            className: 'btn btn-success',
            titleAttr: 'Excel',
           title: 'HISTORIAL_GENERAL_SISTEMA_COMISIONES',

          exportOptions: {
              columns: [1,2,3,4,5,6,7,8,9,10,11],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                        //  return ' '+d +' ';
                         return 'ID LOTE';
                        
                        // }else if(columnIdx == 1){
                        //     return 'ID LOTE';
                        }else if(columnIdx == 1){
                            return 'ID PAGO';
                        }else if(columnIdx == 2){
                            return 'NOMBRE LOTE';
                        }else if(columnIdx == 3){
                            return 'PRECIO LOTE ';
                        }else if(columnIdx == 4){
                            return 'TOTAL COMISIÓN';
                        }else if(columnIdx == 5){
                            return 'PAGO CLIENTE';
                        }else if(columnIdx == 6){
                            return 'ABONO NEODATA';
                        }else if(columnIdx == 7){
                            return 'PAGADO';
                        }else if(columnIdx == 8){
                            return 'PENDIENTE';
                        }else if(columnIdx == 9){
                            return 'COMISIONISTA';
                        }else if(columnIdx == 10){
                            return 'PUESTO';
                        }else if(columnIdx == 11){
                            return 'ESTATUS ACTUAL';
                        }
                        else if(columnIdx != 12 && columnIdx !=0){
                        //     if(columnIdx == 11){
                        //         return 'nose2'
                        //     }
                        //     else{
                                return ' '+titulos[columnIdx-1] +' ';
                        //     }
                        }
                    }
                }
            },

            attr: {
                    class: 'btn btn-success',
                 }
        },
    //    {
    //        extend:    'excelHtml5',
    //        text:      '<i class="fa fa-file-excel-o"></i>',
    //        titleAttr: 'Excel',
    //       exportOptions: {
    //           columns: [1,2,3,4,5,6,7,8,9,10,11],
    //           format: {
    //              header:  function (d, columnIdx) {
    //                  if(columnIdx == 0){
    //                      return ' '+d +' ';
    //                     }else if(columnIdx == 10){
    //                         return 'ESTATUS ';
    //                     }
    //                     else if(columnIdx != 10 && columnIdx !=0){
    //                         if(columnIdx == 11){
    //                             return 'FECHA'
    //                         }
    //                         else{
    //                             return ' '+titulos[columnIdx-1] +' ';
    //                         }
    //                     }
    //                 }
    //             }
    //         },

    //         attr: {
    //                 class: 'btn btn-success',
    //              }
    //     },


        ],


        width: 'auto',
"language":{ url: "../static/spanishLoader.json" },

"pageLength": 10,
"bAutoWidth": false,
"fixedColumns": true,
"ordering": false,
"destroy": true,
"columns": [
    // [
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
    "width": "8%",
    "data": function( d ){
    return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
}
},
{
    "width": "8%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
}
},
{
    "width": "8%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
}
},

{
    "width": "8%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
}
},
{
    "width": "8%",
    "data": function( d ){
    return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
}
},
{
    "width": "8%",
    "data": function( d ){
    return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
}
},
{
    "width": "8%",
    "data": function( d ){
        if(d.restante==null||d.restante==''){
            return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+'</p>';
        }else{
            return '<p style="font-size: .8em">$'+formatMoney(d.restante)+'</p>';
        }
    }
}, 
{
    "width": "12%",
    "data": function( d ){
    return '<p style="font-size: .8em"><b>'+d.user_names+'</b></p>';
}
},

{
    "width": "10%",
    "data": function( d ){
    return '<p style="font-size: .8em">'+d.puesto+'</p>';
}
},



{
    "width": "9%",
    "data": function( d ){
    // return '<p style="font-size: .8em">'+d.user_names+'<br><b>'+d.puesto+'</b></p>';


    if(d.restante<=0 && d.restante!=null && d.restante!=''){
        return '<p style="font-size: .8em"><span class="label" style="background:#29CC59;">LIQUIDADO</span></p>';
    }

    else{

        if((d.id_estatus_actual == 11 || d.id_estatus_actual == 11) && d.descuento_aplicado == 1 ){
            return '<p style="font-size: .8em"><span class="label" style="background:#ED7D72;">DESCUENTO</span></p>';
        }
        else{
            
            switch(d.id_estatus_actual){
                        case '1':
                            case 2:
                            return '<p style="font-size: .8em"><span class="label" style="background:#29A2CC;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '3':
                            case 3:
                            return '<p style="font-size: .8em"><span class="label" style="background:#CC6C29;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '4':
                            case 4:
                            return '<p style="font-size: .8em"><span class="label" style="background:#9129CC;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '5':
                            case 5:
                            return '<p style="font-size: .8em"><span class="label" style="background:#CC2976;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '6':
                            case 6:
                            return '<p style="font-size: .8em"><span class="label" style="background:#81BFBE;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '7':
                            case 7:
                            return '<p style="font-size: .8em"><span class="label" style="background:#28A255;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '8':
                            case 8:
                            return '<p style="font-size: .8em"><span class="label" style="background:#4D7FA1;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '9':
                            case 9:
                            return '<p style="font-size: .8em"><span class="label" style="background:#E86606;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '10':
                            case 10:
                            return '<p style="font-size: .8em"><span class="label" style="background:#E89606;">'+d.estatus_actual+'</span></p>';
                        break;

                        case '11':
                        case 11:
                            case '12':
                            case 12:
                            return '<p style="font-size: .8em"><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p>';
                        break;

                        default:
                        return '<p style="font-size: .8em"><span class="label" style="background:gray;">'+d.estatus_actual+'</span></p>';                        
                        break;

                    }
                }
                }
}
},

 

{ 
    "width": "5%",
    "orderable": false,
    "data": function( data ){

        var BtnStats;
 
 BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' +
     'class="btn btn-round btn-fab btn-fab-mini consultar_logs_asimilados" style="background: #A569BD;" title="Detalles">' +
     '<span class="material-icons">info</span></button>&nbsp;&nbsp;';

return BtnStats;


        }
    }
],


    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets:   0,
        'searchable':false,
        'className': 'dt-body-center',

        

        select: {
            style:    'os',
            selector: 'td:first-child'
        },
    }],

    "ajax": {
        // "url": url2 + "Comisiones/getDatosHistorialPago/" + proyecto + "/" + condominio,
        "url": url2 + "Comisiones/getDatosHistorialPago/" + proyecto + "/" + condominio,

        "type": "POST",
        cache: false,
        "data": function( d ){
                }
            },
            "order": [[ 1, 'asc' ]]
    });




      $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(){
          id_pago = $(this).val();
          user = $(this).attr("data-usuario");

          $("#seeInformationModalAsimilados").modal();

          $.getJSON("getComments/"+id_pago).done( function( data ){
              $.each( data, function(i, v){
                  $("#comments-list-asimilados").append('<li class="timeline-inverted">\n' +
                      ' <div class="timeline-badge info"></div>\n' +
                      ' <div class="timeline-panel">\n' +
                      ' <label><h6>'+v.nombre_usuario+'</h6></label>\n' +
                      ' <br>'+v.comentario+'\n' +
                      ' <h6>\n' +
                      ' <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.fecha_movimiento+'</span>\n' +
                      ' </h6>\n' +
                      ' </div>\n' +
                      '</li>');
              });
          });

      });

    $('#tabla_historialGral').on('click', 'input', function() {
            tr = $(this).closest('tr');

            var row = tabla_historialGral2.row(tr).data();

            if (row.pa == 0) {

                row.pa = row.pago_cliente;
                totaPen += parseFloat(row.pa);
                tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
            } else {

                totaPen -= parseFloat(row.pa);
                row.pa = 0;
            }

            $("#totpagarPen").html(formatMoney(totaPen));
        });




        /*$("#tabla_historialGral tbody").on("click", ".cambiar_estatus", function(){
    var tr = $(this).closest('tr');
    var row = tabla_historialGral2.row( tr );

    id_pago_i = $(this).val();

    $("#modal_nuevas .modal-body").html("");
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro de pausar la comisión de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe mótivo por el cual se pauso la solicitud"></input></div></div>');
    $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
    $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="PAUSAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
    $("#modal_nuevas").modal();
});*/




/*$("#tabla_historialGral tbody").on("click", ".despausar_estatus", function(){
    var tr = $(this).closest('tr');
    var row = tabla_historialGral2.row( tr );
    id_pago_i = $(this).val();
    $("#modal_refresh .modal-body").html("");
    $("#modal_refresh .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Está seguro regresar al estatus inicial la comisión  de <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().usuario+'</i>?</p></div></div>');
    $("#modal_refresh .modal-body").append('<input class="idComPau" name="id_comision" type="text" value="'+row.data().id_comision+'" hidden>');
    $("#modal_refresh .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="CONFIRMAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
    $("#modal_refresh").modal();
});*/





    $("#tabla_historialGral tbody").on("click", ".consultar_documentos", function(){
    id_com = $(this).val();
    id_pj = $(this).attr("data-personalidad");

    $("#seeInformationModal").modal();

    $.getJSON( url + "Comisiones/getDatosDocumentos/"+id_com+"/"+id_pj).done( function( data ){
        $.each( data, function( i, v){

            $("#seeInformationModal .documents").append('<div class="row">');
            if (v.estado == "NO EXISTE"){

                $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:gray;">'+(v.nombre).substr(0, 52)+'</label></div><div class="col-md-5"><label style="font-size:10px; margin:0; color:gray;">(No existente)</label></div>');
            }
            else{
                $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>'+(v.nombre).substr(0, 52)+'</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>('+v.expediente+')</label></b> - <button onclick="preview_info(&#39;'+(v.expediente)+'&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
             }
             $("#seeInformationModal .documents").append('</div>');
         });
    });

    $.getJSON( url + "Comisiones/getDatosFactura/"+id_com).done( function( data ){
        // $.each( data, function( i, v){

            // alert(data.datos_solicitud['id_factura']);

           $("#seeInformationModal .facturaInfo").append('<div class="row">');
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){

                $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                 $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');



                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['folio_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');



                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');





                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');




                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');



                $("#seeInformationModal .facturaInfo").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['uuid']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['descripcion']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
            }
            else {
                 $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
                // $("#seeInformationModal .facturaInfo").append('<label color="red;">SIN HAY DATOS A MOSTRAR</label>');
             }
             $("#seeInformationModal .facturaInfo").append('</div>');


        // });
    });

    // $.getJSON( url + "Comisiones/getCambios/"+id_com+"/"+id_pj).done( function( data ){
    //     $.each( data, function( i, v){
    //         fillFields(v, 1);
    //     });
    // });

});





  }


//FIN TABLA  ****************************************************************************************




$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
           $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust();
           //.responsive.recalc();
    });


$(window).resize(function(){
    tabla_historialGral2.columns.adjust();
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




/*function cancela(){
   $("#modal_nuevas").modal('toggle');
}*/






//Función para pausar la solicitud
/*$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/pausar_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data[0] ){
                        $("#modal_nuevas").modal('toggle' );
                        alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                        setTimeout(function() {
                            tabla_historialGral2.ajax.reload();
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

//Función para regresar a estatus 7 la solicitud
/*$("#form_refresh").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/refresh_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data[0] ){
                        $("#modal_refresh").modal('toggle' );
                        alerts.showNotification("top", "right", "Se ha procesado la solicitud exitosamente", "success");
                        setTimeout(function() {
                            tabla_historialGral2.ajax.reload();
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

/*$("#form_despausar").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        var data = new FormData( $(form)[0] );
        console.log(data);
        data.append("id_pago_i", id_pago_i);
        $.ajax({
            url: url + "Comisiones/despausar_solicitud/",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data[0] ){
                        $("#modal_despausar").modal('toggle' );
                        alerts.showNotification("top", "right", "Se ha regresado la comisión exitosamente", "success");
                        setTimeout(function() {
                            tabla_historialGral2.ajax.reload();
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








/*$(document).on("click", ".btn-historial-lo", function(){
    window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
});*/



    function preview_info(archivo){
    $("#documento_preview .modal-dialog").html("");
    $("#documento_preview").css('z-index', 9999);
    archivo = url+"dist/documentos/"+archivo+"";
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(archivo)[1];
    elemento = "";
    if (ext == 'pdf'){
        elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
        elemento += '</iframe>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'jpg' || ext == 'jpeg'){
        elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
        elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
        $("#documento_preview").modal();
    }
    if(ext == 'xlsx'){
        elemento += '<div class="modal-content">';
        elemento += '<iframe src="'+archivo+'"></iframe>';
        elemento += '</div>';
        $("#documento_preview .modal-dialog").append(elemento);
    }
}







/*function cleanComments()
{

    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';


}*/



</script>

<script>
     /*$(document).ready( function()
   {


       $.getJSON( url + "Comisiones/getReporteEmpresa").done( function( data ){
        $(".report_empresa").html();
        $.each( data, function( i, v){
            $(".report_empresa").append('<div class="col xol-xs-3 col-sm-3 col-md-3 col-lg-3"><label style="color: #00B397;">&nbsp;'+v.empresa+': $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #00B397; font-weight: bold;" value="'+formatMoney(v.porc_empresa)+'" disabled="disabled" readonly="readonly" type="text"  name="myText_FRO" id="myText_FRO"></label></div>');

        });
    });

});*/


</script>

