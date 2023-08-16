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

<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_interes">
                <div class="modal-body"></div>
            </form>
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



<div class="modal fade modal-alertas" id="modal_enganche" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_enganche">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade modal-alertas" id="modal_new_abono" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_new_abono">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade modal-alertas" id="modal_vc" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_vc">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-alertas" id="modal_precioNeto" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form method="post" id="form_precioNeto">
                <div class="modal-body"></div>
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
                        <div class="row">
                            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">


                                <div class="tab-content">

                                    <div class="tab-pane active" id="nuevas-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">HISTORIAL LOTES</h4>
                                                                <p class="category">Panel para registrar los abonos de comisiones ya hechas por el área de CONTRALORÍA.</p></div>


                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_dispersar_comisiones" name="tabla_dispersar_comisiones">
                                                                                <thead>
                                                                                     <tr>
                                                                                        <th style="font-size: .8em;">ID</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">CONDOMINIO</th>
                                                                                        <th style="font-size: .8em;">PROYECTO</th>
                                                                                        <th style="font-size: .8em;">CLIENTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                       <!--  <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">TIPO VENTA</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <th style="font-size: .8em;">FEC. CREACIÓN</th> -->
                                                                                        <th style="font-size: .8em;">MÁS</th>
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

                                      <!-- ///////////////// -->




                                    <!-- //////////////// -->

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
    var totaPen = 0;
    var tr;


  $("#tabla_dispersar_comisiones").ready( function(){

  $('#tabla_dispersar_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_historial.column(i).search() !== this.value ) {
            tabla_historial
            .column(i)
            .search(this.value)
            .draw();

            // var total = 0;
            // var index = tabla_historial.rows({ selected: true, search: 'applied' }).indexes();
            // var data = tabla_historial.rows( index ).data();

            // $.each(data, function(i, v){
            //     total += parseFloat(v.pago_cliente);
            // });
            // var to1 = formatMoney(total);
            // document.getElementById("myText_nuevas").value = formatMoney(total);
        }
    } );
}
});

//   $('#tabla_dispersar_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
//     var total = 0;
//     $.each(json.data, function(i, v){
//         total += parseFloat(v.pago_cliente);
//     });
//     var to = formatMoney(total);
//     document.getElementById("myText_nuevas").value = to;
// });


        tabla_historial = $("#tabla_dispersar_comisiones").DataTable({
            dom: 'Brtip',
            width: 'auto',

//             dom: 'Bfrtip',
//   width: 'auto',


            "buttons": [

        ],

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

            // l.idLote, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2
            {
                "width": "4%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.idLote+'</p>';
                }
            },

            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.nombreLote+'</b></p>';
                }
            },

            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombreCondominio+'</p>';
                }
            },

            {
                "width": "12%",
                "data": function( d ){
                    if(d.registro_comision == 1){
                        // return '<p style="font-size: .8em">'+d.nombreResidencial+'</p><br><b>Comisión activa</b>';
                        return '<p style="font-size: .8em">'+d.nombreResidencial+'<span class="label" style="background:#B5646B;">Comisión activa</span></p>';

                    }else{
                        return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
                    }
                    
                }
            },

            {
                "width": "12%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+' '+d.apellido_paterno+' '+d.apellido_materno+'</p>';
                }
            },

            {
                "width": "10%",
                "data": function( d ){

                    if(d.totalNeto2==''||d.totalNeto2==null||d.totalNeto2==0){
                       return '<p style="font-size: .8em; color: red;"><b>$'+formatMoney(d.totalNeto2)+'</b></p>';
                    }
                    else{
                       return '<p style="font-size: .8em; "><b>$'+formatMoney(d.totalNeto2)+'</b></p>';
                    }
                }
            },

            {
                "width": "10%",
                "orderable": false,
                "data": function( d ){


                    // if(d.registro_comision == 0){
 
                    // if(d.totalNeto2==0||d.totalNeto2==null||d.totalNeto2==''){
                    //  return '<center><button class="btn btn-warning btn-round btn-fab btn-fab-mini cargar_precioNeto" title="AGREGAR TOTAL LOTE" value="' + d.idLote +'" color:#fff;"><i class="material-icons">edit</i></button></center>';

                    // }
                    //     else{
                    //         if(d.plan_enganche==''||d.plan_enganche==null){
                    //         return '<center><button class="btn btn-pink btn-round btn-fab btn-fab-mini marcar_plan_pago" title="AGREGAR PLAN ENGANCHE" value="' + d.idLote +'" color:#fff;"><i class="material-icons">build</i></button></center>';
                    //     }
                    //     else{
                    //     return '';

                    // }

                    // }


                    // }
           

                    if(d.registro_comision == 1){
                        // // alert("here new");

                        // if(d.plan_enganche==''||d.plan_enganche==null){
                            
                        //     return '<center><button class="btn btn-black btn-round btn-fab btn-fab-mini agregar_nuevo_abono" title="AGREGAR NUEVO ABONO" value="' + d.idLote +'" color:#fff;"><i class="material-icons">note_add</i></button></center>';
                        // }
                        // else{

                        return '<center><button class="btn btn-black btn-round btn-fab btn-fab-mini agregar_nuevo_abono" title="AGREGAR NUEVO ABONO" value="' + d.idLote +'" color:#fff;"><i class="material-icons">note_add</i></button></center>';
                    // }

                    }
                    else{

                    if(d.totalNeto2==0||d.totalNeto2==null||d.totalNeto2==''){
                     return '<center><button class="btn btn-warning btn-round btn-fab btn-fab-mini cargar_precioNeto" title="AGREGAR TOTAL LOTE" value="' + d.idLote +'" color:#fff;"><i class="material-icons">edit</i></button></center>';

                    }
                    else{

                        if(d.uservc==null){
                            

                            // if(d.plan_enganche==''||d.plan_enganche==null){

                            //     return '<center><button class="btn btn-primary btn-round btn-fab btn-fab-mini cargar_abono" title="AGREGAR ABONO" value="' + d.idLote +'" color:#fff;"><i class="material-icons">edit</i></button>'
                            // +'<button class="btn btn-danger btn-round btn-fab btn-fab-mini marcar_pagada" title="MARCAR COMO PAGADA" value="' + d.idLote +'" color:#fff;"><i class="material-icons">description</i></button>'
                            // +'<button class="btn btn-pink btn-round btn-fab btn-fab-mini marcar_plan_pago" title="AGREGAR PLAN ENGANCHE" value="' + d.idLote +'" color:#fff;"><i class="material-icons">build</i></button></center>';


                            // }
                            // else{

                                return '<center><button class="btn btn-primary btn-round btn-fab btn-fab-mini cargar_abono" title="AGREGAR ABONO" value="' + d.idLote +'" color:#fff;"><i class="material-icons">edit</i></button>'
                            +'<button class="btn btn-danger btn-round btn-fab btn-fab-mini marcar_pagada" title="MARCAR COMO PAGADA" value="' + d.idLote +'" color:#fff;"><i class="material-icons">description</i></button></center>';

                            // }

                        }
                        else{
                                return '<center><button class="btn btn-success btn-round btn-fab btn-fab-mini venta_compartida" title="VENTA COMPARTIDA" value="'+d.idLote+'" color:#fff;"><i class="material-icons">supervised_user_circle</i></button>'
                                +'<button class="btn btn-danger btn-round btn-fab btn-fab-mini marcar_pagada" title="MARCAR COMO PAGADA" value="' + d.idLote +'" color:#fff;"><i class="material-icons">description</i></button></center>';
                            }
                            

                    }
                    }


                }
            }],

            columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                'searchable':false,
                'className': 'dt-body-center',

                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
            }],

            "ajax": {
                "url": url2 + "Comisiones/getDatosComisionesDispersarContraloria",
                /*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });



        $('#tabla_dispersar_comisiones').on( 'click', 'input', function () {
            tr = $(this).closest('tr');

            var row = tabla_historial.row( tr ).data();

            if( row.pa == 0 ){

                row.pa = row.pago_cliente;
                // tabla_historial.row( tr ).data( row );
                totaPen += parseFloat( row.pa );
                tr.children().eq(1).children('input[type="checkbox"]').prop( "checked",true );
            }else{

                totaPen -= parseFloat( row.pa );
                row.pa = 0;
                // tabla_historial.row( tr ).data( row );

            }

            $("#totpagarPen").html(formatMoney(totaPen));
        });




         $("#tabla_dispersar_comisiones tbody").on("click", ".cargar_precioNeto", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historial.row( tr );
            idLote = $(this).val();

            $("#modal_precioNeto .modal-header").html("");
            $("#modal_precioNeto .modal-body").html("");
            $("#modal_precioNeto .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="text" id="precio_Neto" name="precio_Neto" class="form-control" placeholder="Digite precio lote final"><input type="hidden" name="lote" id="lote" value="'+idLote+'"></center></div></div>');


            $("#modal_precioNeto .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div></div>');
            $("#modal_precioNeto").modal();
        });


        

        $("#tabla_dispersar_comisiones tbody").on("click", ".marcar_pagada", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historial.row( tr );
            idLote = $(this).val();
            // alert(idLote);


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_pagadas .modal-body").html("");

            $("#modal_pagadas .modal-body").append('<h4 class="modal-title">¿Ya se pago completa la comision para el lote <b>'+row.data().nombreLote+'</b>?</h4>');
            $("#modal_pagadas .modal-body").append('<input type="hidden" name="ideLotep" id="ideLotep" value="'+idLote+'">');

            $("#modal_pagadas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_pagadas").modal();
        });




        /*$("#tabla_dispersar_comisiones tbody").on("click", ".marcar_plan_pago", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historial.row( tr );
            idLote = $(this).val();
            // alert(idLote);


            // $("#modal_pagadas .modal-header").html("");
            $("#modal_enganche .modal-body").html("");

            $("#modal_enganche .modal-body").append('<h4 class="modal-title">Plan de enganche: <b>'+row.data().nombreLote+'</b>?</h4>');
            $("#modal_enganche .modal-body").append('<input type="hidden" name="ideLotenganche" id="ideLotenganche" value="'+idLote+'">');

            
            $("#modal_enganche .modal-body").append('<div class="col-md-12"><select id="planSelect" name="planSelect" class="form-control planSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>');*/


            

$.post('getPlanesEnganche', function(data) {
       $("#planSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
       var len = data.length;
       for( var i = 0; i<len; i++)
       {
           var id = data[i]['id_usuario'];
           var name = data[i]['name_user'];
           // var sede = data[i]['id_sede'];
           // alert(name);
           $("#planSelect").append($('<option>').val(id).attr('data-value', id).text(name));
       }
       if(len<=0)
       {
       $("#planSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
       }
           $("#planSelect").val(v.id_director);
       $("#planSelect").selectpicker('refresh');
   }, 'json');



            $("#modal_enganche .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="ACEPTAR"></center></div></div>');
        $("#modal_enganche").modal();
        });*/

        




var counts=0;
 $("#tabla_dispersar_comisiones tbody").on("click", ".agregar_nuevo_abono", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historial.row( tr );
            idLote = $(this).val();
            $("#modal_new_abono .modal-body").html("");
            $("#modal_new_abono .modal-header").html("");
            $("#modal_new_abono .modal-footer").html("");

            $("#modal_new_abono .modal-header").append('<h4 class="modal-title">Abonado a: <b>'+row.data().nombreLote+'</b></h4>');
            $.getJSON( url + "Comisiones/getDatosAbonadoSuma1/"+idLote).done( function( data1 ){
                $("#modal_new_abono .modal-header").append('<div class="row">'+
                '<div class="col-md-4">Total pago: <b style="color:blue">'+formatMoney((data1[0].val))+'</b></div>'+
                '<div class="col-md-4">Total abonado: <b style="color:green">'+formatMoney((data1[1].val)   )+'</b></div>'+
                '<div class="col-md-4">Total pendiente: <b style="color:orange">'+formatMoney(((data1[0].val)-(data1[1].val)))+'</b></div></div>');
            });


 
            $("#modal_new_abono .modal-body").append('<div class="row">'
                     +'<div class="col-md-3"><b>NOMBRE</b></div>'
                    +'<div class="col-md-1">%</div>'
                    +'<div class="col-md-2"><b>TOTAL</b></div>'
                    +'<div class="col-md-2"><b>ABONADO</b></div>'
                    +'<div class="col-md-2"><b>PENDIENTE</b></div>'
                    +'<div class="col-md-2"><b>ABONAR</b></div></div>');

            $.getJSON( url + "Comisiones/getDatosAbonado/"+idLote).done( function( data ){
                $.each( data, function( i, v){


                    $("#modal_new_abono .modal-body").append('<input type="hidden" name="referencia" id="referencia" value="'+v.referencia+'"><input type="hidden" name="idDesarrollo" id="idDesarrollo" value="'+v.idResidencial+'"><input type="hidden" name="ideLote" id="ideLote" value="'+v.idLote+'">');

                   
                    $("#modal_new_abono .modal-body").append('<div class="row">'

                    +'<div class="col-md-3"><input id="rol" type="hidden" name="id_comision[]" value="'+v.id_comision+'"><input id="rol" type="hidden" name="rol[]" value="'+v.id_usuario+'"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.colaborador+'" style="font-size:12px;"><b><p style="font-size:12px;">'+v.rol+'</p></b></div>'

                    +'<div class="col-md-1"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+v.porcentaje_decimal+'%"></div>'
                    +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.comision_total)+'"></div>'
                    +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney(v.abono_pagado)+'"></div>'
                    +'<div class="col-md-2"><input class="form-control ng-invalid ng-invalid-required" required readonly="true" value="'+formatMoney((v.comision_total-v.abono_pagado))+'"></div>'
                    +'<div class="col-md-2"><input id="abono_nuevo'+counts+'" onkeyup="nuevo_abono('+counts+');" class="form-control ng-invalid ng-invalid-required abono_nuevo"  name="abono_nuevo[]" value="0"></div></div>');
                    counts++
                });
            });

           
            $("#modal_new_abono .modal-footer").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div></div>');
            $("#modal_new_abono").modal();
        });

    



 $("#tabla_dispersar_comisiones tbody").on("click", ".cargar_abono", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historial.row( tr );
            idLote = $(this).val();

            // alert(idLote);

            $("#modal_nuevas .modal-header").html("");
            $("#modal_nuevas .modal-body").html("");

            $("#modal_nuevas .modal-header").append('<h4 class="modal-title">DETALLE COMISIÓN PARA: <b>'+row.data().nombreLote+'</b></h4>');

            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-3"><p><b>PRECIO LOTE:&nbsp;&nbsp;</b><input type="text" class="form-control" name="precioLote" id="precioLote" value="'+row.data().totalNeto2+'" onkeyup="myFunctionTL();" readonly> </p></div><div class="col-md-3"><p><b>SUMA TOTAL:&nbsp;&nbsp;</b><input type="text" class="form-control" name="sumTotal" id="sumTotal" value="0" readonly> </p></div><div class="col-md-3"><p><b>SUMA ABONADO:&nbsp;&nbsp;</b><input type="text" class="form-control sumAbonado" name="sumAbonado" id="sumAbonado" value="0" readonly> </p></div><div class="col-md-3"><p><b>SUMA PENDIENTE:&nbsp;&nbsp;</b><input type="text" class="form-control" name="sumPendiente" id="sumPendiente" value="0" readonly> </p></div></div>');

            $("#modal_nuevas .modal-body").append('<br><div class="row"><div class="col-md-2"><p><b>PUESTO&nbsp;&nbsp;</b></p></div><div class="col-md-2"><p><b>USUARIO&nbsp;&nbsp;</b></p></div><div class="col-md-2"><p><b>%&nbsp;&nbsp;</b></p></div> <div class="col-md-2"><p><b>ABONADO&nbsp;&nbsp;</b></p></div> <div class="col-md-2"><p><b>PENDIENTE&nbsp;&nbsp;</b></p></div> <div class="col-md-2"><p><b>TOTAL&nbsp;&nbsp;</b></p></div></div>');

            $.getJSON( url + "Comisiones/getDatosDispersar/"+idLote).done( function( data ){
                $.each( data, function( i, v){


                    $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">DIRECTOR</div>'

                        +'<div class="col-md-3"><select id="directorSelect" name="directorSelect" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeDir" name="porcentajeDir" onkeyup="myFunctionD();" class="form-control porcentajeDir ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input type="text" id="abonadoDir" name="abonadoDir" onkeyup=" myFunctionD2();" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-old="" data-type="currency" class="form-control abonadoDir ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteDir" name="pendienteDir" class="form-control pendienteDir ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalDir" name="totalDir" class="form-control totalDir ng-invalid ng-invalid-required" required readonly="true"></div></div>');



                    $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">SUBDIRECTOR</div>'

                        +'<div class="col-md-3"><select id="subdirectorSelect" name="subdirectorSelect" class="form-control subdirectorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajesubDir" name="porcentajesubDir" onkeyup="myFunctionS();" class="form-control porcentajesubDir ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadosubDir" name="abonadosubDir" onkeyup="myFunctionS2();" data-old="" class="form-control abonadosubDir ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendientesubDir" name="pendientesubDir" class="form-control pendientesubDir ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalsubDir" name="totalsubDir" class="form-control totalsubDir ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">GERENTE</div>'

                        +'<div class="col-md-3"><select id="gerenteSelect" name="gerenteSelect" class="form-control gerenteSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeGerente" name="porcentajeGerente" onkeyup="myFunctionG();" class="form-control porcentajeGerente ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoGerente" name="abonadoGerente" onkeyup="myFunctionG2();" data-old="" class="form-control abonadoGerente ng-invalid ng-invalid-required" required ></div>'

                        +'<div class="col-md-2"><input id="pendienteGerente" name="pendienteGerente" class="form-control pendienteGerente ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalGerente" name="totalGerente" class="form-control totalGerente ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">COORDINADOR</div>'

                        +'<div class="col-md-3"><select id="coordinadorSelect" name="coordinadorSelect" class="form-control coordinadorSelect ng-invalid ng-invalid-required" data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeCoordinador" name="porcentajeCoordinador" onkeyup="myFunctionC();" class="form-control porcentajeCoordinador ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoCoordinador" data-old="" name="abonadoCoordinador" onkeyup="myFunctionC2();" data-old="" class="form-control abonadoCoordinador ng-invalid ng-invalid-required"></div>'

                        +'<div class="col-md-2"><input id="pendienteCoordinador" name="pendienteCoordinador" class="form-control pendienteCoordinador ng-invalid ng-invalid-required" readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalCoordinador" name="totalCoordinador" class="form-control totalCoordinador ng-invalid ng-invalid-required" readonly="true"></div></div>');




                $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">ASESOR</div>'

                        +'<div class="col-md-3"><select id="asesorSelect" name="asesorSelect" class="form-control asesorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeAsesor" name="porcentajeAsesor" onkeyup="myFunctionA();" class="form-control porcentajeAsesor ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoAsesor" data-old="" name="abonadoAsesor" onkeyup="myFunctionA2();" class="form-control abonadoAsesor ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteAsesor" name="pendienteAsesor" class="form-control pendienteAsesor ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalAsesor" name="totalAsesor" class="form-control totalAsesor ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">MKTD</div>'

                        +'<div class="col-md-3"><select id="MKTDSelect" name="MKTDSelect" class="form-control MKTDSelect ng-invalid ng-invalid-required" data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeMKTD" name="porcentajeMKTD" onkeyup="myFunctionmktd();" class="form-control porcentajeMKTD ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoMKTD" data-old="" name="abonadoMKTD" onkeyup="myFunctionmktd2();" class="form-control abonadoMKTD ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteMKTD" name="pendienteMKTD" class="form-control pendienteMKTD ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalMKTD" name="totalMKTD" class="form-control totalMKTD ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">SUB. CLUB</div>'

                        +'<div class="col-md-3"><select id="SubClubSelect" name="SubClubSelect" class="form-control SubClubSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeSubClub" name="porcentajeSubClub" onkeyup="myFunctionsubclub();" class="form-control porcentajeSubClub ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoSubClub" data-old="" name="abonadoSubClub" onkeyup="myFunctionsubclub2();" class="form-control abonadoSubClub ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteSubClub" name="pendienteSubClub" class="form-control pendienteSubClub ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalSubClub" name="totalSubClub" class="form-control totalSubClub ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                        

                // $("#modal_nuevas .modal-body").append('<div class="row">'
                //         +'<div class="col-md-2">EJEC. CLUB</div>'

                //         +'<div class="col-md-3"><select id="EjectClubSelect" name="EjectClubSelect" class="form-control EjectClubSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                //         +'<div class="col-md-1"><input id="porcentajeEjectClub" name="porcentajeEjectClub" onkeyup="myFunctionejeclub();" class="form-control porcentajeEjectClub ng-invalid ng-invalid-required" required placeholder="%"></div>'

                //         +'<div class="col-md-2"><input id="abonadoEjectClub" data-old="" name="abonadoEjectClub" onkeyup="myFunctionejeclub2();" class="form-control abonadoEjectClub ng-invalid ng-invalid-required" required></div>'

                //         +'<div class="col-md-2"><input id="pendienteEjectClub" name="pendienteEjectClub" class="form-control pendienteEjectClub ng-invalid ng-invalid-required" required readonly="true"></div>'

                //         +'<div class="col-md-2"><input id="totalEjectClub" name="totalEjectClub" class="form-control totalEjectClub ng-invalid ng-invalid-required" required readonly="true"></div></div>');



               $("#modal_nuevas .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">GREENHAM</div>'

                        +'<div class="col-md-3"><select id="GreenSelect" name="GreenSelect" class="form-control GreenSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeGreenham" name="porcentajeGreenham" onkeyup="myFunctionGreen();" class="form-control porcentajeGreenham ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoGreenham" data-old="" name="abonadoGreenham" onkeyup="myFunctionGreen2();" class="form-control abonadoGreenham ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteGreenham" name="pendienteGreenham" class="form-control pendienteGreenham ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalGreenham" name="totalGreenham" class="form-control totalGreenham ng-invalid ng-invalid-required" required readonly="true"></div></div>');



                 $("#modal_nuevas .modal-body").append('<input type="hidden" name="referencia" id="referencia" value="'+v.referencia+'"><input type="hidden" name="idDesarrollo" id="idDesarrollo" value="'+v.idResidencial+'"><input type="hidden" name="ideLote" id="ideLote" value="'+v.idLote+'">');

                  // $("#modal_nuevas .modal-body").append('<input type="hidden" name="referencia" id="referencia" value="'+v.referencia+'"><input type="hidden" name="idDesarrollo" id="idDesarrollo" value="'+v.idResidencial+'"><input type="hidden" name="ideLote" id="ideLote" value="'+v.idLote+'">');






                  if(v.id_coordinador == null){
                    $('#porcentajeCoordinador').val(0);
                    $('#totalCoordinador').val(0);
                    $('#abonadoCoordinador').val(0);
                    $('#pendienteCoordinador').val(0);
                    $('#porcentajeCoordinador').attr('readonly', true);
                    $('#abonadoCoordinador').attr('readonly', true);
                       
                    }



                 $.post('getDirector', function(data) {
                        $("#directorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#directorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#directorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                            $("#directorSelect").val(v.id_director);
                        $("#directorSelect").selectpicker('refresh');
                    }, 'json');



                 $.post('getsubDirector', function(data) {
                        $("#subdirectorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#subdirectorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#subdirectorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                            $("#subdirectorSelect").val(v.id_subdirector);
                        // $("#subdirectorSelect").val("<option val>KELYN HERNANDEZ</option>");
                        $("#subdirectorSelect").selectpicker('refresh');


                    }, 'json');



             $.post('getGerente', function(data) {
                        $("#gerenteSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#gerenteSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#gerenteSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }

                        // $("#asesorSelect").val("<option val>KELYN HERNANDEZ</option>");
                            $("#gerenteSelect").val(v.id_gerente);
                        $("#gerenteSelect").selectpicker('refresh');


                    }, 'json');


              $.post('getCoordinador', function(data) {
                  console.log(v);
                        $("#coordinadorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#coordinadorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }

                        if(len<=0)
                        {
                        $("#coordinadorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                         $("#coordinadorSelect").val(v.id_coordinador);
                        $("#coordinadorSelect").selectpicker('refresh');
                    }, 'json');

                    $('#coordinadorSelect').on('change', function(){
                        if($("#coordinadorSelect").val() == ''){
                            $('#porcentajeCoordinador').attr('readonly', true);
                            $('#abonadoCoordinador').attr('readonly', true);
                           
                        }else{
                            $('#porcentajeCoordinador').attr('readonly', false);
                            $('#abonadoCoordinador').attr('readonly', false);
                           
                        }
                    })

               $.post('getAsesor', function(data) {
                        $("#asesorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#asesorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#asesorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }

                        // $("#asesorSelect").val("<option val>KELYN HERNANDEZ</option>");
                            $("#asesorSelect").val(v.id_asesor);
                        $("#asesorSelect").selectpicker('refresh');


                    }, 'json');


                    $.post('getMktd', function(data) {
                                                                        $("#MKTDSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#MKTDSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#MKTDSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#MKTDSelect").val(4394);
                                                                        $("#MKTDSelect").selectpicker('refresh');
                                                                    }, 'json');
                                                                    
                                                                    // $.post('getEjectClub', function(data) {
                                                                    //     $("#EjectClubSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                    //     var len = data.length;
                                                                    //     for( var i = 0; i<len; i++)
                                                                    //     {
                                                                    //         var id = data[i]['id_usuario'];
                                                                    //         var name = data[i]['name_user'];
                                                                    //         $("#EjectClubSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                    //     }
                                                                    //     if(len<=0)
                                                                    //     {
                                                                    //         $("#EjectClubSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                    //     }
                                                                    //     $("#EjectClubSelect").val(0);
                                                                    //     $("#EjectClubSelect").selectpicker('refresh');
                                                                    // }, 'json');


                                                                    $.post('getSubClub', function(data) {
                                                                        $("#SubClubSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#SubClubSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }

                                                                        if(len<=0)
                                                                        {
                                                                            $("#SubClubSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#SubClubSelect").val(4615);
                                                                        $("#SubClubSelect").selectpicker('refresh');
                   
                                                                    }, 'json');


                                                                    $.post('getGreen', function(data) {
                                                                        $("#GreenSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#GreenSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#GreenSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#GreenSelect").val(4415);
                                                                        $("#GreenSelect").selectpicker('refresh');
                   
                                                                    }, 'json');




                                                                    




 

            //    console.log(v);

 
                });


        $("#modal_nuevas .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div></div>');
        $("#modal_nuevas").modal();





            });


        });


        //////////////////////////////////////




        $("#tabla_dispersar_comisiones tbody").on("click", ".venta_compartida", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historial.row( tr );
            idLote = $(this).val();
console.log('entra')
             $("#modal_vc .modal-header").html("");
            $("#modal_vc .modal-body").html("");

            $("#modal_vc .modal-header").append('<h4 class="modal-title">DETALLE COMISIÓN PARA: <b>'+row.data().nombreLote+'</b></h4>');

            $("#modal_vc .modal-body").append('<div class="row"><div class="col-md-3"><p><b>PRECIO LOTE:&nbsp;&nbsp;</b><input type="text" class="form-control" name="precioLote" id="precioLote" value="'+row.data().totalNeto2+'" onkeyup="myFunctionTL();" readonly> </p></div><div class="col-md-3"><p><b>SUMA TOTAL:&nbsp;&nbsp;</b><input type="text" class="form-control" name="sumTotal" id="sumTotal" value="0" readonly> </p></div><div class="col-md-3"><p><b>SUMA ABONADO:&nbsp;&nbsp;</b><input type="text" class="form-control sumAbonado" name="sumAbonado" id="sumAbonado" value="0" readonly> </p></div><div class="col-md-3"><p><b>SUMA PENDIENTE:&nbsp;&nbsp;</b><input type="text" class="form-control" name="sumPendiente" id="sumPendiente" value="0" readonly> </p></div></div>');

            $("#modal_vc .modal-body").append('<br><div class="row"><div class="col-md-2"><p><b>PUESTO&nbsp;&nbsp;</b></p></div><div class="col-md-2"><p><b>USUARIO&nbsp;&nbsp;</b></p></div><div class="col-md-2"><p><b>%&nbsp;&nbsp;</b></p></div> <div class="col-md-2"><p><b>ABONADO&nbsp;&nbsp;</b></p></div> <div class="col-md-2"><p><b>PENDIENTE&nbsp;&nbsp;</b></p></div> <div class="col-md-2"><p><b>TOTAL&nbsp;&nbsp;</b></p></div></div>');

            $.getJSON( url + "Comisiones/getDatosDispersar/"+idLote).done( function( data ){
                  $.each( data, function( i, v){
               

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">DIRECTOR</div>'
                        +'<div class="col-md-3"><select id="directorSelect" name="directorSelect" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeDir" name="porcentajeDir" onkeyup="myFunctionD();" class="form-control porcentajeDir ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input type="text" id="abonadoDir" name="abonadoDir" onkeyup="myFunctionD2();" class="form-control abonadoDir ng-invalid ng-invalid-required" default-value="" value="" required></div>'
                        +'<div class="col-md-2"><input id="pendienteDir" name="pendienteDir" class="form-control pendienteDir ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalDir" name="totalDir" class="form-control totalDir ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">SUBDIRECTOR</div>'
                        +'<div class="col-md-3"><select id="subdirectorSelect" name="subdirectorSelect" class="form-control subdirectorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajesubDir" name="porcentajesubDir" onkeyup="myFunctionS();" class="form-control porcentajesubDir ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadosubDir" name="abonadosubDir" onkeyup="myFunctionS2();" class="form-control abonadosubDir ng-invalid ng-invalid-required" required></div>'
                        +'<div class="col-md-2"><input id="pendientesubDir" name="pendientesubDir" class="form-control pendientesubDir ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalsubDir" name="totalsubDir" class="form-control totalsubDir ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">GERENTE</div>'
                        +'<div class="col-md-3"><select id="gerenteSelect" name="gerenteSelect" class="form-control gerenteSelect ng-invalid ng-invalid-required" data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeGerente" name="porcentajeGerente" onkeyup="myFunctionG();" class="form-control porcentajeGerente ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoGerente" name="abonadoGerente" onkeyup="myFunctionG2();" class="form-control abonadoGerente ng-invalid ng-invalid-required" required ></div>'
                        +'<div class="col-md-2"><input id="pendienteGerente" name="pendienteGerente" class="form-control pendienteGerente ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalGerente" name="totalGerente" class="form-control totalGerente ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">COORDINADOR</div>'
                        +'<div class="col-md-3"><select id="coordinadorSelect" name="coordinadorSelect" class="form-control coordinadorSelect ng-invalid ng-invalid-required" data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeCoordinador" name="porcentajeCoordinador" onkeyup="myFunctionC();" class="form-control porcentajeCoordinador ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoCoordinador" data-old="" name="abonadoCoordinador" onkeyup="myFunctionC2();" class="form-control abonadoCoordinador ng-invalid ng-invalid-required"></div>'
                        +'<div class="col-md-2"><input id="pendienteCoordinador" name="pendienteCoordinador" class="form-control pendienteCoordinador ng-invalid ng-invalid-required" readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalCoordinador" name="totalCoordinador" class="form-control totalCoordinador ng-invalid ng-invalid-required" readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">ASESOR</div>'
                        +'<div class="col-md-3"><select id="asesorSelect" name="asesorSelect" class="form-control asesorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeAsesor" name="porcentajeAsesor" onkeyup="myFunctionA();" class="form-control porcentajeAsesor ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoAsesor" data-old="" name="abonadoAsesor" onkeyup="myFunctionA2();" class="form-control abonadoAsesor ng-invalid ng-invalid-required" required></div>'
                        +'<div class="col-md-2"><input id="pendienteAsesor" name="pendienteAsesor" class="form-control pendienteAsesor ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalAsesor" name="totalAsesor" class="form-control totalAsesor ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                 $("#modal_vc .modal-body").append('<input type="hidden" name="referencia" id="referencia" value="'+v.referencia+'"><input type="hidden" name="idDesarrollo" id="idDesarrollo" value="'+v.idResidencial+'"><input type="hidden" name="ideLote" id="ideLote" value="'+v.idLote+'">');
 

                 if(v.id_coordinador == null){
                    $('#porcentajeCoordinador').val(0);
                    $('#porcentajeCoordinador').val(0);
                    $('#porcentajeCoordinador').attr('readonly', true);
                    $('#abonadoCoordinador').attr('readonly', true);
                   
                }

                 $.post('getDirector', function(data) {
                        $("#directorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#directorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#directorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                            $("#directorSelect").val(v.id_director);
                        $("#directorSelect").selectpicker('refresh');
                    }, 'json');



                 $.post('getsubDirector', function(data) {
                        $("#subdirectorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#subdirectorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#subdirectorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                            $("#subdirectorSelect").val(v.id_subdirector);
                        // $("#subdirectorSelect").val("<option val>KELYN HERNANDEZ</option>");
                        $("#subdirectorSelect").selectpicker('refresh');


                    }, 'json');



             $.post('getGerente', function(data) {
                        $("#gerenteSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#gerenteSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#gerenteSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }

                        // $("#asesorSelect").val("<option val>KELYN HERNANDEZ</option>");
                            $("#gerenteSelect").val(v.id_gerente);
                        $("#gerenteSelect").selectpicker('refresh');


                    }, 'json');


              $.post('getCoordinador', function(data) {
                        $("#coordinadorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#coordinadorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }

                        if(len<=0)
                        {
                        $("#coordinadorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }
                         $("#coordinadorSelect").val(v.id_coordinador);
                        $("#coordinadorSelect").selectpicker('refresh');
                    }, 'json');
                    $("#coordinadorSelect").on('change', function(){

                        if($("#coordinadorSelect").val() == ''){
                            $('#porcentajeCoordinador').attr('readonly', true);
                            $('#abonadoCoordinador').attr('readonly', true);
                        
                        }else{
                            $('#porcentajeCoordinador').attr('readonly', false);
                            $('#abonadoCoordinador').attr('readonly', false);
                        }
                    })

               $.post('getAsesor', function(data) {
                        $("#asesorSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++)
                        {
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            // var sede = data[i]['id_sede'];
                            // alert(name);
                            $("#asesorSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                        }
                        if(len<=0)
                        {
                        $("#asesorSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                        }

                        // $("#asesorSelect").val("<option val>KELYN HERNANDEZ</option>");
                            $("#asesorSelect").val(v.id_asesor);
                        $("#asesorSelect").selectpicker('refresh');


                    }, 'json');

            //    console.log(v);
        });


            $.getJSON( url + "Comisiones/getDatosDispersarCompartidas/"+idLote).done( function( data1 ){
                // $.each( data, function( i, v){
                    

                    // alert("holas");
                    // console.log("v");
                    console.log(data1.length);

                    if(data1.length==1||data1.length=='1'){

                        // console.log("entra a 1 mas");
 
                $("#modal_vc .modal-body").append('<hr><div class="row">'
                    +'<div class="col-md-2">SUBDIRECTOR</div>'
                    +'<div class="col-md-3"><select id="subdirectorSelect21" name="subdirectorSelect21" class="form-control subdirectorSelect21 ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajesubDir21" name="porcentajesubDir21" onkeyup="myFunctionSdos();" class="form-control porcentajesubDir21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadosubDir21" data-old="" name="abonadosubDir21" onkeyup="myFunctionSdos2();" class="form-control abonadosubDir21 ng-invalid ng-invalid-required" required></div>'
                    +'<div class="col-md-2"><input id="pendientesubDir21" name="pendientesubDir21" class="form-control pendientesubDir21 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalsubDir21" name="totalsubDir21" class="form-control totalsubDir21 ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">GERENTE</div>'
                    +'<div class="col-md-3"><select id="gerenteSelect21" name="gerenteSelect21" class="form-control gerenteSelect21 ng-invalid ng-invalid-required" data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeGerente21" name="porcentajeGerente21" onkeyup="myFunctionGdos();" class="form-control porcentajeGerente21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoGerente21" data-old="" name="abonadoGerente21" onkeyup="myFunctionGdos2();" class="form-control abonadoGerente21 ng-invalid ng-invalid-required" required ></div>'
                    +'<div class="col-md-2"><input id="pendienteGerente21" name="pendienteGerente21" class="form-control pendienteGerente21 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalGerente21" name="totalGerente21" class="form-control totalGerente21 ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">COORDINADOR</div>'
                    +'<div class="col-md-3"><select id="coordinadorSelect21" name="coordinadorSelect21" class="form-control coordinadorSelect21 ng-invalid ng-invalid-required" data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeCoordinador21" name="porcentajeCoordinador21" onkeyup="myFunctionCdos();" class="form-control porcentajeCoordinador21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoCoordinador21" data-old="" name="abonadoCoordinador21" onkeyup="myFunctionCdos2();" class="form-control abonadoCoordinador21 ng-invalid ng-invalid-required"></div>'
                    +'<div class="col-md-2"><input id="pendienteCoordinador21" name="pendienteCoordinador21" class="form-control pendienteCoordinador21 ng-invalid ng-invalid-required" readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalCoordinador21" name="totalCoordinador21" class="form-control totalCoordinador21 ng-invalid ng-invalid-required" readonly="true"></div></div>');
                    
                $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">ASESOR</div>'
                    +'<div class="col-md-3"><select id="asesorSelect21" name="asesorSelect21" class="form-control asesorSelect21 ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeAsesor21" name="porcentajeAsesor21" onkeyup="myFunctionAdos();" class="form-control porcentajeAsesor21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoAsesor21" data-old="" name="abonadoAsesor21" onkeyup="myFunctionAdos2();" class="form-control abonadoAsesor21 ng-invalid ng-invalid-required" required></div>'
                    +'<div class="col-md-2"><input id="pendienteAsesor21" name="pendienteAsesor21" class="form-control pendienteAsesor21 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalAsesor21" name="totalAsesor21" class="form-control totalAsesor21 ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">MKTD</div>'
                        +'<div class="col-md-3"><select id="MKTDSelect" name="MKTDSelect" class="form-control MKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeMKTD" name="porcentajeMKTD" onkeyup="myFunctionmktd();" class="form-control porcentajeMKTD ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoMKTD" data-old="" name="abonadoMKTD" onkeyup="myFunctionmktd2();" class="form-control abonadoMKTD ng-invalid ng-invalid-required" required></div>'
                        +'<div class="col-md-2"><input id="pendienteMKTD" name="pendienteMKTD" class="form-control pendienteMKTD ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalMKTD" name="totalMKTD" class="form-control totalMKTD ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">CLUB M.</div>'
                        +'<div class="col-md-3"><select id="SubClubSelect" name="SubClubSelect" class="form-control SubClubSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeSubClub" name="porcentajeSubClub" onkeyup="myFunctionsubclub();" class="form-control porcentajeSubClub ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoSubClub" data-old="" name="abonadoSubClub" onkeyup="myFunctionsubclub2();" class="form-control abonadoSubClub ng-invalid ng-invalid-required" required></div>'
                        +'<div class="col-md-2"><input id="pendienteSubClub" name="pendienteSubClub" class="form-control pendienteSubClub ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalSubClub" name="totalSubClub" class="form-control totalSubClub ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                // $("#modal_vc .modal-body").append('<div class="row">'
                //         +'<div class="col-md-2">EJEC. CLUB</div>'
                //         +'<div class="col-md-3"><select id="EjectClubSelect" name="EjectClubSelect" class="form-control EjectClubSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'
                //         +'<div class="col-md-1"><input id="porcentajeEjectClub" name="porcentajeEjectClub" onkeyup="myFunctionejeclub();" class="form-control porcentajeEjectClub ng-invalid ng-invalid-required" required placeholder="%"></div>'
                //         +'<div class="col-md-2"><input id="abonadoEjectClub" data-old="" name="abonadoEjectClub" onkeyup="myFunctionejeclub2();" class="form-control abonadoEjectClub ng-invalid ng-invalid-required" required></div>'
                //         +'<div class="col-md-2"><input id="pendienteEjectClub" name="pendienteEjectClub" class="form-control pendienteEjectClub ng-invalid ng-invalid-required" required readonly="true"></div>'
                //         +'<div class="col-md-2"><input id="totalEjectClub" name="totalEjectClub" class="form-control totalEjectClub ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">GREENHAM</div>'

                        +'<div class="col-md-3"><select id="GreenSelect" name="GreenSelect" class="form-control GreenSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeGreenham" name="porcentajeGreenham" onkeyup="myFunctionGreen();" class="form-control porcentajeGreenham ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoGreenham" data-old="" name="abonadoGreenham" onkeyup="myFunctionGreen2();" class="form-control abonadoGreenham ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteGreenham" name="pendienteGreenham" class="form-control pendienteGreenham ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalGreenham" name="totalGreenham" class="form-control totalGreenham ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                //  $("#modal_vc .modal-body").append('<input type="hidden" name="referencia" id="referencia" value="'+data[0].referencia+'"><input type="hidden" name="idDesarrollo2" id="idDesarrollo2" value="'+data[0].idResidencial+'"><input type="hidden" name="ideLote" id="ideLote" value="'+data[0].idLote+'">');
 
                if(data1[0].id_coordinador == null){
                    $('#totalCoordinador21').val(0);
                    $('#porcentajeCoordinador21').val(0);
                    $('#abonadoCoordinador21').val(0);
                    $('#pendienteCoordinador21').val(0);
                    $('#porcentajeCoordinador21').attr('readonly', true);
                    $('#abonadoCoordinador21').attr('readonly', true);
                }
                $.post('getsubDirector2', function(data) {
                        $("#subdirectorSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            $("#subdirectorSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if(len<=0){
                                $("#subdirectorSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                }
                                $("#subdirectorSelect21").val(data1[0].id_subdirector);
                                $("#subdirectorSelect21").selectpicker('refresh');
                                }, 'json');
                                
                                $.post('getGerente2', function(data) {
                                    $("#gerenteSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                    var len = data.length;
                                    for( var i = 0; i<len; i++)
                                    {
                                        var id = data[i]['id_usuario'];
                                        var name = data[i]['name_user'];
                                        $("#gerenteSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                                        }
                                        if(len<=0){
                                            $("#gerenteSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                            }
                                            $("#gerenteSelect21").val(data1[0].id_gerente);
                                            $("#gerenteSelect21").selectpicker('refresh');
                                            }, 'json');
                                            
                                            $.post('getCoordinador2', function(data) {
                                                $("#coordinadorSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                var len = data.length;
                                                for( var i = 0; i<len; i++){
                                                    var id = data[i]['id_usuario'];
                                                    var name = data[i]['name_user'];
                                                    $("#coordinadorSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                                                    }
                                                    if(len<=0){
                                                        $("#coordinadorSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                        }
                                                        $("#coordinadorSelect21").val(data1[0].id_coordinador);
                                                        $("#coordinadorSelect21").selectpicker('refresh');
                                                        }, 'json');

                                                        $("#coordinadorSelect21").on('change', function(){
                                                            if($("#coordinadorSelect21").val() == ''){
                                                            $('#porcentajeCoordinador21').attr('readonly', true);
                                                            $('#abonadoCoordinador21').attr('readonly', true);
                                                            }else{
                                                                $('#porcentajeCoordinador21').attr('readonly', false);
                                                                $('#abonadoCoordinador21').attr('readonly', false);
                                                            }
                                                        })
                                                       
                                                        
                                                        $.post('getAsesor2', function(data) {
                                                            $("#asesorSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                            var len = data.length;
                                                            for( var i = 0; i<len; i++){
                                                                var id = data[i]['id_usuario'];
                                                                var name = data[i]['name_user'];
                                                                $("#asesorSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                }
                                                                if(len<=0){
                                                                    $("#asesorSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                    }
                                                                    $("#asesorSelect21").val(data1[0].id_asesor);
                                                                    $("#asesorSelect21").selectpicker('refresh');
                                                                    }, 'json');


                                                                    $.post('getMktd', function(data) {
                                                                        $("#MKTDSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#MKTDSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#MKTDSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#MKTDSelect").val(4394);
                                                                        $("#MKTDSelect").selectpicker('refresh');
                                                                    }, 'json');
                                                                    
                                                                    // $.post('getEjectClub', function(data) {
                                                                    //     $("#EjectClubSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                    //     var len = data.length;
                                                                    //     for( var i = 0; i<len; i++)
                                                                    //     {
                                                                    //         var id = data[i]['id_usuario'];
                                                                    //         var name = data[i]['name_user'];
                                                                    //         $("#EjectClubSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                    //     }
                                                                    //     if(len<=0)
                                                                    //     {
                                                                    //         $("#EjectClubSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                    //     }
                                                                    //     $("#EjectClubSelect").val(0);
                                                                    //     $("#EjectClubSelect").selectpicker('refresh');
                                                                    // }, 'json');


                                                                    $.post('getSubClub', function(data) {
                                                                        $("#SubClubSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#SubClubSelect").append($('<option selected="selected">').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#SubClubSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#SubClubSelect").val(4615);
                                                                        $("#SubClubSelect").selectpicker('refresh');
                   
                                                                    }, 'json');


                                                                    $.post('getGreen', function(data) {
                                                                        $("#GreenSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#GreenSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#GreenSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#GreenSelect").val(4415);
                                                                        $("#GreenSelect").selectpicker('refresh');
                   
                                                                    }, 'json');
 
                    
                                                                    $("#modal_vc .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div></div>');

                                                                    $("#modal_vc").modal();
                                                                    // });
                                                                }
                     if(data1.length==2||data1.length=='2'){

                    //aqui va el proceso 

                    console.log("entra a 2 mas");
                    
                    $("#modal_vc .modal-body").append('<hr><div class="row">'
                    +'<div class="col-md-2">SUBDIRECTOR</div>'
                    +'<div class="col-md-3"><select id="subdirectorSelect21" name="subdirectorSelect21" class="form-control subdirectorSelect21 ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajesubDir21" name="porcentajesubDir21" onkeyup="myFunctionSdos();" class="form-control porcentajesubDir21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadosubDir21" data-old="" name="abonadosubDir21" onkeyup="myFunctionSdos2();" class="form-control abonadosubDir21 ng-invalid ng-invalid-required" required></div>'
                    +'<div class="col-md-2"><input id="pendientesubDir21" name="pendientesubDir21" class="form-control pendientesubDir21 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalsubDir21" name="totalsubDir21" class="form-control totalsubDir21 ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                    $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">GERENTE</div>'
                    +'<div class="col-md-3"><select id="gerenteSelect21" name="gerenteSelect21" class="form-control gerenteSelect21 ng-invalid ng-invalid-required"  data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeGerente21" name="porcentajeGerente21" onkeyup="myFunctionGdos();" class="form-control porcentajeGerente21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoGerente21" data-old="" name="abonadoGerente21" onkeyup="myFunctionGdos2();" class="form-control abonadoGerente21 ng-invalid ng-invalid-required" required ></div>'
                    +'<div class="col-md-2"><input id="pendienteGerente21" name="pendienteGerente21" class="form-control pendienteGerente21 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalGerente21" name="totalGerente21" class="form-control totalGerente21 ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                    $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">COORDINADOR</div>'
                    +'<div class="col-md-3"><select id="coordinadorSelect21" name="coordinadorSelect21" class="form-control coordinadorSelect21 ng-invalid ng-invalid-required"  data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeCoordinador21" name="porcentajeCoordinador21" onkeyup="myFunctionCdos();" class="form-control porcentajeCoordinador21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoCoordinador21" data-old="" name="abonadoCoordinador21" onkeyup="myFunctionCdos2();" class="form-control abonadoCoordinador21 ng-invalid ng-invalid-required"></div>'
                    +'<div class="col-md-2"><input id="pendienteCoordinador21" name="pendienteCoordinador21" class="form-control pendienteCoordinador21 ng-invalid ng-invalid-required" readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalCoordinador21" name="totalCoordinador21" class="form-control totalCoordinador21 ng-invalid ng-invalid-required" readonly="true"></div></div>');
                    
                    $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">ASESOR</div>'
                    +'<div class="col-md-3"><select id="asesorSelect21" name="asesorSelect21" class="form-control asesorSelect21 ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeAsesor21" name="porcentajeAsesor21" onkeyup="myFunctionAdos();" class="form-control porcentajeAsesor21 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoAsesor21" data-old="" name="abonadoAsesor21" onkeyup="myFunctionAdos2();" class="form-control abonadoAsesor21 ng-invalid ng-invalid-required" required></div>'
                    +'<div class="col-md-2"><input id="pendienteAsesor21" name="pendienteAsesor21" class="form-control pendienteAsesor21 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalAsesor21" name="totalAsesor21" class="form-control totalAsesor21 ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                    <!-- //////////////////////////////////////////////7 -->
                    $("#modal_vc .modal-body").append('<hr><div class="row">'
                    +'<div class="col-md-2">SUBDIRECTOR</div>'
                    +'<div class="col-md-3"><select id="subdirectorSelect31" name="subdirectorSelect31" class="form-control subdirectorSelect31 ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajesubDir31" name="porcentajesubDir31" onkeyup="myFunctionStres();" class="form-control porcentajesubDir31 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadosubDir31" data-old="" name="abonadosubDir31" onkeyup="myFunctionStres3();" class="form-control abonadosubDir31 ng-invalid ng-invalid-required" required></div>'
                    +'<div class="col-md-2"><input id="pendientesubDir31" name="pendientesubDir31" class="form-control pendientesubDir31 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalsubDir31" name="totalsubDir31" class="form-control totalsubDir31 ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                    $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">GERENTE</div>'
                    +'<div class="col-md-3"><select id="gerenteSelect31" name="gerenteSelect31" class="form-control gerenteSelect31 ng-invalid ng-invalid-required"  data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeGerente31" name="porcentajeGerente31" onkeyup="myFunctionGtres();" class="form-control porcentajeGerente31 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoGerente31" data-old="" name="abonadoGerente31" onkeyup="myFunctionGtres3();" class="form-control abonadoGerente31 ng-invalid ng-invalid-required" required ></div>'
                    +'<div class="col-md-2"><input id="pendienteGerente31" name="pendienteGerente31" class="form-control pendienteGerente31 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalGerente31" name="totalGerente31" class="form-control totalGerente31 ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                    $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">COORDINADOR</div>'
                    +'<div class="col-md-3"><select id="coordinadorSelect31" name="coordinadorSelect31" class="form-control coordinadorSelect31 ng-invalid ng-invalid-required"  data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeCoordinador31" name="porcentajeCoordinador31" onkeyup="myFunctionCtres();" class="form-control porcentajeCoordinador31 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoCoordinador31" data-old="" name="abonadoCoordinador31" onkeyup="myFunctionCtres3();" class="form-control abonadoCoordinador31 ng-invalid ng-invalid-required"></div>'
                    +'<div class="col-md-2"><input id="pendienteCoordinador31" name="pendienteCoordinador31" class="form-control pendienteCoordinador31 ng-invalid ng-invalid-required" readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalCoordinador31" name="totalCoordinador31" class="form-control totalCoordinador31 ng-invalid ng-invalid-required" readonly="true"></div></div>');
                    
                    $("#modal_vc .modal-body").append('<div class="row">'
                    +'<div class="col-md-2">ASESOR</div>'
                    +'<div class="col-md-3"><select id="asesorSelect31" name="asesorSelect31" class="form-control asesorSelect31 ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'
                    +'<div class="col-md-1"><input id="porcentajeAsesor31" name="porcentajeAsesor31" onkeyup="myFunctionAtres();" class="form-control porcentajeAsesor31 ng-invalid ng-invalid-required" required placeholder="%"></div>'
                    +'<div class="col-md-2"><input id="abonadoAsesor31" data-old="" name="abonadoAsesor31" onkeyup="myFunctionAtres3();" class="form-control abonadoAsesor31 ng-invalid ng-invalid-required" required></div>'
                    +'<div class="col-md-2"><input id="pendienteAsesor31" name="pendienteAsesor31" class="form-control pendienteAsesor31 ng-invalid ng-invalid-required" required readonly="true"></div>'
                    +'<div class="col-md-2"><input id="totalAsesor31" name="totalAsesor31" class="form-control totalAsesor31 ng-invalid ng-invalid-required" required readonly="true"></div></div>');



                    $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">MKTD</div>'
                        +'<div class="col-md-3"><select id="MKTDSelect" name="MKTDSelect" class="form-control MKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeMKTD" name="porcentajeMKTD" onkeyup="myFunctionmktd();" class="form-control porcentajeMKTD ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoMKTD" data-old="" name="abonadoMKTD" onkeyup="myFunctionmktd2();" class="form-control abonadoMKTD ng-invalid ng-invalid-required" required></div>'
                        +'<div class="col-md-2"><input id="pendienteMKTD" name="pendienteMKTD" class="form-control pendienteMKTD ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalMKTD" name="totalMKTD" class="form-control totalMKTD ng-invalid ng-invalid-required" required readonly="true"></div></div>');

                $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">CLUB M.</div>'
                        +'<div class="col-md-3"><select id="SubClubSelect" name="SubClubSelect" class="form-control SubClubSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'
                        +'<div class="col-md-1"><input id="porcentajeSubClub" name="porcentajeSubClub" onkeyup="myFunctionsubclub();" class="form-control porcentajeSubClub ng-invalid ng-invalid-required" required placeholder="%"></div>'
                        +'<div class="col-md-2"><input id="abonadoSubClub" data-old="" name="abonadoSubClub" onkeyup="myFunctionsubclub2();" class="form-control abonadoSubClub ng-invalid ng-invalid-required" required></div>'
                        +'<div class="col-md-2"><input id="pendienteSubClub" name="pendienteSubClub" class="form-control pendienteSubClub ng-invalid ng-invalid-required" required readonly="true"></div>'
                        +'<div class="col-md-2"><input id="totalSubClub" name="totalSubClub" class="form-control totalSubClub ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                        

                // $("#modal_vc .modal-body").append('<div class="row">'
                //         +'<div class="col-md-2">EJEC. CLUB</div>'
                //         +'<div class="col-md-3"><select id="EjectClubSelect" name="EjectClubSelect" class="form-control EjectClubSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'
                //         +'<div class="col-md-1"><input id="porcentajeEjectClub" name="porcentajeEjectClub" onkeyup="myFunctionejeclub();" class="form-control porcentajeEjectClub ng-invalid ng-invalid-required" required placeholder="%"></div>'
                //         +'<div class="col-md-2"><input id="abonadoEjectClub" data-old="" name="abonadoEjectClub" onkeyup="myFunctionejeclub2();" class="form-control abonadoEjectClub ng-invalid ng-invalid-required" required></div>'
                //         +'<div class="col-md-2"><input id="pendienteEjectClub" name="pendienteEjectClub" class="form-control pendienteEjectClub ng-invalid ng-invalid-required" required readonly="true"></div>'
                //         +'<div class="col-md-2"><input id="totalEjectClub" name="totalEjectClub" class="form-control totalEjectClub ng-invalid ng-invalid-required" required readonly="true"></div></div>');


                        $("#modal_vc .modal-body").append('<div class="row">'
                        +'<div class="col-md-2">GREENHAM</div>'

                        +'<div class="col-md-3"><select id="GreenSelect" name="GreenSelect" class="form-control GreenSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                        +'<div class="col-md-1"><input id="porcentajeGreenham" name="porcentajeGreenham" onkeyup="myFunctionGreen();" class="form-control porcentajeGreenham ng-invalid ng-invalid-required" required placeholder="%"></div>'

                        +'<div class="col-md-2"><input id="abonadoGreenham" data-old="" name="abonadoGreenham" onkeyup="myFunctionGreen2();" class="form-control abonadoGreenham ng-invalid ng-invalid-required" required></div>'

                        +'<div class="col-md-2"><input id="pendienteGreenham" name="pendienteGreenham" class="form-control pendienteGreenham ng-invalid ng-invalid-required" required readonly="true"></div>'

                        +'<div class="col-md-2"><input id="totalGreenham" name="totalGreenham" class="form-control totalGreenham ng-invalid ng-invalid-required" required readonly="true"></div></div>');
                    
                    // <!-- $("#modal_vc .modal-body").append('<input type="hidden" name="referencia" id="referencia" value="'+data[0].referencia+'"><input type="hidden" name="idDesarrollo2" id="idDesarrollo2" value="'+data[0].idResidencial+'"><input type="hidden" name="ideLote" id="ideLote" value="'+data[0].idLote+'">'); -->
                    if(data1[0].id_coordinador == null){
                        $('#totalCoordinador21').val(0);
                        $('#totalCoordinador31').val(0);
                        $('#abonadoCoordinador21').val(0);
                        $('#pendienteCoordinador21').val(0);
                        $('#abonadoCoordinador31').val(0);
                        $('#pendienteCoordinador31').val(0);
                        $('#porcentajeCoordinador21').val(0);
                        $('#porcentajeCoordinador31').val(0);
                        $('#porcentajeCoordinador21').attr('readonly', true);
                        $('#abonadoCoordinador21').attr('readonly', true);
                        $('#porcentajeCoordinador31').attr('readonly', true);
                        $('#abonadoCoordinador31').attr('readonly', true);
                }
                    
                    $.post('getsubDirector2', function(data) {
                        $("#subdirectorSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            $("#subdirectorSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if(len<=0){
                                $("#subdirectorSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                }
                                $("#subdirectorSelect21").val(data1[0].id_subdirector);
                                $("#subdirectorSelect21").selectpicker('refresh');
                                }, 'json');
                                
                                $.post('getGerente2', function(data) {
                                    $("#gerenteSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                    var len = data.length;
                                    for( var i = 0; i<len; i++)
                                    {
                                        var id = data[i]['id_usuario'];
                                        var name = data[i]['name_user'];
                                        $("#gerenteSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                                        }
                                        if(len<=0){
                                            $("#gerenteSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                            }
                                            $("#gerenteSelect21").val(data1[0].id_gerente);
                                            $("#gerenteSelect21").selectpicker('refresh');
                                            }, 'json');
                                            
                                            $.post('getCoordinador2', function(data) {
                                                $("#coordinadorSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                var len = data.length;
                                                for( var i = 0; i<len; i++){
                                                    var id = data[i]['id_usuario'];
                                                    var name = data[i]['name_user'];
                                                    $("#coordinadorSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                                                    }
                                                    if(len<=0){
                                                        $("#coordinadorSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                        }
                                                        $("#coordinadorSelect21").val(data1[0].id_coordinador);
                                                        $("#coordinadorSelect21").selectpicker('refresh');
                                                        }, 'json');
                                                        
                                                        $("#coordinadorSelect21").on('change', function(){
                                                            if($("#coordinadorSelect21").val() == ''){
                                                                $('#porcentajeCoordinador21').attr('readonly', true);
                                                                $('#abonadoCoordinador21').attr('readonly', true);
                                                            
                                                            }else{
                                                                $('#porcentajeCoordinador21').attr('readonly', false);
                                                                $('#abonadoCoordinador21').attr('readonly', false);
                                                            }
                                                        });
                                                        
                                                        $.post('getAsesor2', function(data) {
                                                            $("#asesorSelect21").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                            var len = data.length;
                                                            for( var i = 0; i<len; i++){
                                                                var id = data[i]['id_usuario'];
                                                                var name = data[i]['name_user'];
                                                                $("#asesorSelect21").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                }
                                                                if(len<=0){
                                                                    $("#asesorSelect21").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                    }
                                                                    $("#asesorSelect21").val(data1[0].id_asesor);
                                                                    $("#asesorSelect21").selectpicker('refresh');
                                                                    }, 'json');



                    $.post('getsubDirector3', function(data) {
                        $("#subdirectorSelect31").append($('<option disabled>').val("default").text("Seleccione una opción"))
                        var len = data.length;
                        for( var i = 0; i<len; i++){
                            var id = data[i]['id_usuario'];
                            var name = data[i]['name_user'];
                            $("#subdirectorSelect31").append($('<option>').val(id).attr('data-value', id).text(name));
                            }
                            if(len<=0){
                                $("#subdirectorSelect31").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                }
                                $("#subdirectorSelect31").val(data1[0].id_subdirector);
                                $("#subdirectorSelect31").selectpicker('refresh');
                                }, 'json');
                                
                                $.post('getGerente3', function(data) {
                                    $("#gerenteSelect31").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                    var len = data.length;
                                    for( var i = 0; i<len; i++)
                                    {
                                        var id = data[i]['id_usuario'];
                                        var name = data[i]['name_user'];
                                        $("#gerenteSelect31").append($('<option>').val(id).attr('data-value', id).text(name));
                                        }
                                        if(len<=0){
                                            $("#gerenteSelect31").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                            }
                                            $("#gerenteSelect31").val(data1[0].id_gerente);
                                            $("#gerenteSelect31").selectpicker('refresh');
                                            }, 'json');
                                            
                                            $.post('getCoordinador3', function(data) {
                                                $("#coordinadorSelect31").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                var len = data.length;
                                                for( var i = 0; i<len; i++){
                                                    var id = data[i]['id_usuario'];
                                                    var name = data[i]['name_user'];
                                                    $("#coordinadorSelect31").append($('<option>').val(id).attr('data-value', id).text(name));
                                                    }
                                                    if(len<=0){
                                                        $("#coordinadorSelect31").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                        }
                                                        $("#coordinadorSelect31").val(data1[0].id_coordinador);
                                                        $("#coordinadorSelect31").selectpicker('refresh');
                                                        }, 'json');
                                                        
                                                        $("#coordinadorSelect31").on('change', function(){
                                                            if($("#coordinadorSelect31").val() == ''){
                                                                $('#porcentajeCoordinador31').attr('readonly', true);
                                                                $('#abonadoCoordinador31').attr('readonly', true);
                                                            
                                                            }else{
                                                                $('#porcentajeCoordinador31').attr('readonly', false);
                                                                $('#abonadoCoordinador31').attr('readonly', false);
                                                            }
                                                        })
                                                        
                                                        $.post('getAsesor3', function(data) {
                                                            $("#asesorSelect31").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                            var len = data.length;
                                                            for( var i = 0; i<len; i++){
                                                                var id = data[i]['id_usuario'];
                                                                var name = data[i]['name_user'];
                                                                $("#asesorSelect31").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                }
                                                                if(len<=0){
                                                                    $("#asesorSelect31").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                    }
                                                                    $("#asesorSelect31").val(data1[0].id_asesor);
                                                                    $("#asesorSelect31").selectpicker('refresh');
                                                                    }, 'json');



                                                                    
                                                                    $.post('getMktd', function(data) {
                                                                        $("#MKTDSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#MKTDSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#MKTDSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#MKTDSelect").val(4394);
                                                                        $("#MKTDSelect").selectpicker('refresh');
                                                                    }, 'json');
                                                                    
                                                                    // $.post('getEjectClub', function(data) {
                                                                    //     $("#EjectClubSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                    //     var len = data.length;
                                                                    //     for( var i = 0; i<len; i++)
                                                                    //     {
                                                                    //         var id = data[i]['id_usuario'];
                                                                    //         var name = data[i]['name_user'];
                                                                    //         $("#EjectClubSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                    //     }
                                                                    //     if(len<=0)
                                                                    //     {
                                                                    //         $("#EjectClubSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                    //     }
                                                                    //     $("#EjectClubSelect").val(0);
                                                                    //     $("#EjectClubSelect").selectpicker('refresh');
                                                                    // }, 'json');


                                                                    $.post('getSubClub', function(data) {
                                                                        $("#SubClubSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#SubClubSelect").append($('<option selected="selected">').val(id).attr('data-value', id).text(name));
                                                                        }

                                                                        if(len<=0)
                                                                        {
                                                                            $("#SubClubSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#SubClubSelect").val(4615);
                                                                        $("#SubClubSelect").selectpicker('refresh');
                   
                                                                    }, 'json');



                                                                    $.post('getGreen', function(data) {
                                                                        $("#GreenSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                                                                        var len = data.length;
                                                                        for( var i = 0; i<len; i++)
                                                                        {
                                                                            var id = data[i]['id_usuario'];
                                                                            var name = data[i]['name_user'];
                                                                            $("#GreenSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                                                                        }
                                                                        if(len<=0)
                                                                        {
                                                                            $("#GreenSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                                                                        }
                                                                        $("#GreenSelect").val(4415);
                                                                        $("#GreenSelect").selectpicker('refresh');
                   
                                                                    }, 'json');

                                                                    $("#modal_vc .modal-body").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div></div>');
                                                                    $("#modal_vc").modal();
           
                                                                }
                
                                                            });
                                                        });
                                                    });




//////////////////////////////////////7





});





function myFunctionTL(){

    $("#abonadoDir").val('');
    $("#abonadosubDir").val('');
    $("#abonadoGerente").val('');
    $("#abonadoCoordinador").val('');
    $("#abonadoAsesor").val('');
    $("#abonadoMKTD").val('');
    $("#abonadoSubClub").val('');
    $("#abonadoEjectClub").val('');
    $("#abonadoGreenham").val('');

    $("#porcentajeDir").val('');
    $("#porcentajesubDir").val('');
    $("#porcentajeGerente").val('');
    $("#porcentajeCoordinador").val('');
    $("#porcentajeAsesor").val('');
    $("#porcentajeMKTD").val('');
    $("#porcentajeSubClub").val('');
    $("#porcentajeEjectClub").val('');
    $("#porcentajeGreenham").val('');
     
 
$("#abonadosubDir21").val('');
$("#abonadoGerente21").val('');
$("#abonadoCoordinador21").val('');
$("#abonadoAsesor21").val('');

$("#porcentajesubDir21").val('');
$("#porcentajeGerente21").val('');
$("#porcentajeCoordinador21").val('');
$("#porcentajeAsesor21").val('');

$("#abonadosubDir31").val('');
$("#abonadoGerente31").val('');
$("#abonadoCoordinador31").val('');
$("#abonadoAsesor31").val('');

$("#porcentajesubDir31").val('');
$("#porcentajeGerente31").val('');
$("#porcentajeCoordinador31").val('');
$("#porcentajeAsesor31").val('');




}


function nuevo_abono(contador){
    formatCurrency($('#abono_nuevo'+contador));
}

// precioLote

function myFunctionD(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeDir').value;
    var pretotal = $("#totalDir").val();
    $("#totalDir").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalDir").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));

    $("#abonadoDir").val(0);
    myFunctionD2();
}

function myFunctionS(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajesubDir').value;
    var pretotal = $("#totalsubDir").val();
    $("#totalsubDir").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalsubDir").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));

    $("#abonadosubDir").val(0);
    myFunctionS2();
}

function myFunctionG(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeGerente').value;
    var pretotal = $("#totalGerente").val();
    $("#totalGerente").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalGerente").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));

    $("#abonadoGerente").val(0);
    myFunctionG2();
}

function myFunctionC(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeCoordinador').value;
    var pretotal = $("#totalCoordinador").val();
    $("#totalCoordinador").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalCoordinador").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));

    $("#abonadoCoordinador").val(0);
    myFunctionC2();
}
function myFunctionA(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeAsesor').value;
    var pretotal = $("#totalAsesor").val();
    $("#totalAsesor").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalAsesor").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
    $("#abonadoAsesor").val(0);
    myFunctionA2();
}




/////////////////////////7

function myFunctionmktd(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeMKTD').value;
    var pretotal = $("#totalMKTD").val();
    $("#totalMKTD").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalMKTD").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val(parseFloat(sumTotal)+parseInt(total));
    $("#abonadoMKTD").val(0);
    myFunctionmktd2();
}

function myFunctionsubclub(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeSubClub').value;
    var pretotal = $("#totalSubClub").val();
    $("#totalSubClub").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalSubClub").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
    $("#abonadoSubClub").val(0);
    myFunctionsubclub2();
}

function myFunctionejeclub(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeEjectClub').value;
    var pretotal = $("#totalEjectClub").val();
    $("#totalEjectClub").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalEjectClub").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
    $("#abonadoEjectClub").val(0);
}
    
function myFunctionGreen(){
    var val1 = document.getElementById('precioLote').value;
    var val2 = document.getElementById('porcentajeGreenham').value;
    var pretotal = $("#totalGreenham").val();
    $("#totalGreenham").val(((val1*0.01)*val2).toFixed(2));
    var total = $("#totalGreenham").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
    $("#abonadoGreenham").val(0);
    myFunctionGreen2();
}


//////////////////////77


function myFunctionD2(){
    formatCurrency($('#abonadoDir'));
    // formatCurrency($('#totalDir'));
    
    var pretotal = $("#abonadoDir").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalDir').value;
    var val2 = document.getElementById('abonadoDir').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }    
    var sumAbonado = document.getElementById('sumAbonado').value;
    console.log('abonado inicial Dir' + pretotal);
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    console.log('abonado final Dir' + sumAbonado);

    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoDir").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteDir").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteDir").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteDir").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');

    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
  if($("#pendienteDir").val()>=0){
    formatCurrency($('#pendienteDir'));
  }
}

function myFunctionS2(){
    formatCurrency($('#abonadosubDir'));
    // formatCurrency($('#totalsubDir'));
    var pretotal = $("#abonadosubDir").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalsubDir').value;
    var val2 = document.getElementById('abonadosubDir').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    
    console.log('abonado inicial subdir' + pretotal);

    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    console.log('abonado final subdir' + sumAbonado);

    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadosubDir").attr("data-old",inputVal2);

    var prePendiente =  $("#pendientesubDir").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendientesubDir").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendientesubDir").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2)); 
    if($("#pendientesubDir").val()>=0){
    formatCurrency($('#pendientesubDir'));
  }
}

function myFunctionG2(){
    formatCurrency($('#abonadoGerente'));
    // formatCurrency($('#totalGerente'));
    var pretotal = $("#abonadoGerente").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalGerente').value;
    var val2 = document.getElementById('abonadoGerente').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoGerente").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteGerente").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteGerente").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteGerente").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));     
    if($("#pendienteGerente").val()>=0){
    formatCurrency($('#pendienteGerente'));
  }
}

function myFunctionC2(){
    formatCurrency($('#abonadoCoordinador'));
    // formatCurrency($('#totalCoordinador'));
    var pretotal = $("#abonadoCoordinador").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalCoordinador').value;
    var val2 = document.getElementById('abonadoCoordinador').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoCoordinador").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteCoordinador").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteCoordinador").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteCoordinador").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));     
    if($("#pendienteCoordinador").val()>=0){
    formatCurrency($('#pendienteCoordinador'));
  }
}
function myFunctionA2(){
    // formatCurrency($('#totalAsesor'));
    formatCurrency($('#abonadoAsesor'));
    var pretotal = $("#abonadoAsesor").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalAsesor').value;
    var val2 = document.getElementById('abonadoAsesor').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoAsesor").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteAsesor").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteAsesor").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteAsesor").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));     
    if($("#pendienteAsesor").val()>=0){
    formatCurrency($('#pendienteAsesor'));
  }
}
//////////////////////////////////7

function myFunctionmktd2(){
    // formatCurrency($('#totalMKTD'));
    formatCurrency($('#abonadoMKTD'));
    var pretotal = $("#abonadoMKTD").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalMKTD').value;
    var val2 = document.getElementById('abonadoMKTD').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoMKTD").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteMKTD").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteMKTD").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteMKTD").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteMKTD").val()>=0){
    formatCurrency($('#pendienteMKTD'));
  }
}

function myFunctionsubclub2(){
    // formatCurrency($('#totalSubClub'));
    formatCurrency($('#abonadoSubClub'));
    var pretotal = $("#abonadoSubClub").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalSubClub').value;
    var val2 = document.getElementById('abonadoSubClub').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoSubClub").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteSubClub").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteSubClub").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteSubClub").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteSubClub").val()>=0){
    formatCurrency($('#pendienteSubClub'));
  }
}

function myFunctionejeclub2(){
    // formatCurrency($('#totalEjectClub'));
    formatCurrency($('#abonadoEjectClub'));
    var pretotal = $("#abonadoEjectClub").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalEjectClub').value;
    var val2 = document.getElementById('abonadoEjectClub').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoEjectClub").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteEjectClub").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteEjectClub").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteEjectClub").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteEjectClub").val()>=0){
    formatCurrency($('#pendienteEjectClub'));
  }
}

function myFunctionGreen2(){
    // formatCurrency($('#totalGreenham'));
    formatCurrency($('#abonadoGreenham'));
    var pretotal = $("#abonadoGreenham").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalGreenham').value;
    var val2 = document.getElementById('abonadoGreenham').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoGreenham").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteGreenham").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteGreenham").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteGreenham").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteGreenham").val()>=0){
    formatCurrency($('#pendienteGreenham'));
  }
}



///////////////////////////777


function myFunctionSdos(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajesubDir21').value;
var pretotal = $("#totalsubDir21").val();
$("#totalsubDir21").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalsubDir21").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadosubDir21").val(0);
myFunctionSdos2();
}

function myFunctionGdos(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajeGerente21').value;
var pretotal = $("#totalGerente21").val();
$("#totalGerente21").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalGerente21").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadoGerente21").val(0);
myFunctionGdos2();
}

function myFunctionCdos(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajeCoordinador21').value;
var pretotal = $("#totalCoordinador21").val();
$("#totalCoordinador21").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalCoordinador21").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadoCoordinador21").val(0);
myFunctionCdos2();
}

function myFunctionAdos(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajeAsesor21').value;
var pretotal = $("#totalAsesor21").val();
$("#totalAsesor21").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalAsesor21").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadoAsesor21").val(0);
myFunctionAdos2();
}

function myFunctionSdos2(){
    // formatCurrency($('#totalsubDir21'));
    formatCurrency($('#abonadosubDir21'));
    var pretotal = $("#abonadosubDir21").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalsubDir21').value;
    var val2 = document.getElementById('abonadosubDir21').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadosubDir21").attr("data-old",inputVal2);

    var prePendiente =  $("#pendientesubDir21").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendientesubDir21").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendientesubDir21").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendientesubDir21").val()>=0){
        formatCurrency($('#pendientesubDir21'));
    }
}

function myFunctionGdos2(){
    // formatCurrency($('#totalGerente21'));
    formatCurrency($('#abonadoGerente21'));
    var pretotal = $("#abonadoGerente21").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalGerente21').value;
    var val2 = document.getElementById('abonadoGerente21').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoGerente21").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteGerente21").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteGerente21").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteGerente21").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteGerente21").val()>=0){
            formatCurrency($('#pendienteGerente21'));
    }
}

function myFunctionCdos2(){
    // formatCurrency($('#totalCoordinador21'));
    formatCurrency($('#abonadoCoordinador21'));
    var pretotal = $("#abonadoCoordinador21").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalCoordinador21').value;
    var val2 = document.getElementById('abonadoCoordinador21').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoCoordinador21").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteCoordinador21").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteCoordinador21").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteCoordinador21").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteCoordinador21").val()>=0){
                formatCurrency($('#pendienteCoordinador21'));
    }
}

function myFunctionAdos2(){
    // formatCurrency($('#totalAsesor21'));
    formatCurrency($('#abonadoAsesor21'));
    var pretotal = $("#abonadoAsesor21").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalAsesor21').value;
    var val2 = document.getElementById('abonadoAsesor21').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoAsesor21").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteAsesor21").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteAsesor21").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteAsesor21").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteAsesor21").val()>=0){
                    formatCurrency($('#pendienteAsesor21'));
    }
}





function myFunctionStres(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajesubDir31').value;
var pretotal = $("#totalsubDir31").val();
$("#totalsubDir31").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalsubDir31").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadosubDir31").val(0);
myFunctionStres3();
}

function myFunctionGtres(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajeGerente31').value;
var pretotal = $("#totalGerente31").val();
$("#totalGerente31").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalGerente31").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadoGerente31").val(0);
myFunctionGtres3();
}

function myFunctionCtres(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajeCoordinador31').value;
var pretotal = $("#totalCoordinador31").val();
$("#totalCoordinador31").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalCoordinador31").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadoCoordinador31").val(0);
myFunctionCtres3();
}

function myFunctionAtres(){
var val1 = document.getElementById('precioLote').value;
var val2 = document.getElementById('porcentajeAsesor31').value;
var pretotal = $("#totalAsesor31").val();
$("#totalAsesor31").val(((val1*0.01)*val2).toFixed(2));
var total = $("#totalAsesor31").val();
    if(pretotal == ''){
        pretotal = 0;
    }   
    var sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)-parseFloat(pretotal)).toFixed(2));
    sumTotal = document.getElementById('sumTotal').value;
    $("#sumTotal").val((parseFloat(sumTotal)+parseFloat(total)).toFixed(2));
$("#abonadoAsesor31").val(0);
myFunctionAtres3();
}

function myFunctionStres3(){
    // formatCurrency($('#totalsubDir31'));
    formatCurrency($('#abonadosubDir31'));
    var pretotal = $("#abonadosubDir31").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalsubDir31').value;
    var val2 = document.getElementById('abonadosubDir31').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadosubDir31").attr("data-old",inputVal2);

    var prePendiente =  $("#pendientesubDir31").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendientesubDir31").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendientesubDir31").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendientesubDir31").val()>=0){
        formatCurrency($('#pendientesubDir31'));
    }
}

function myFunctionGtres3(){
    // formatCurrency($('#totalGerente31'));
    formatCurrency($('#abonadoGerente31'));
    var pretotal = $("#abonadoGerente31").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalGerente31').value;
    var val2 = document.getElementById('abonadoGerente31').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoGerente31").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteGerente31").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteGerente31").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteGerente31").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteGerente31").val()>=0){
        formatCurrency($('#pendienteGerente31'));
    }
}

function myFunctionCtres3(){
    // formatCurrency($('#totalCoordinador31'));
    formatCurrency($('#abonadoCoordinador31'));
    var pretotal = $("#abonadoCoordinador31").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalCoordinador31').value;
    var val2 = document.getElementById('abonadoCoordinador31').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoCoordinador31").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteCoordinador31").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteCoordinador31").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteCoordinador31").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteCoordinador31").val()>=0){
        formatCurrency($('#pendienteCoordinador31'));
    }
}
function myFunctionAtres3(){
    // formatCurrency($('#totalAsesor31'));
    formatCurrency($('#abonadoAsesor31'));
    var pretotal = $("#abonadoAsesor31").attr("data-old");
    if(pretotal == '' || pretotal == undefined){
        pretotal = 0;
    }
    var val1 = document.getElementById('totalAsesor31').value;
    var val2 = document.getElementById('abonadoAsesor31').value;
    var inputVal2 = val2.replace(/[$,]/g,'');
    var inputVal1 = val1.replace(/[$,]/g,'');
    if(inputVal2 == ''){
        inputVal2 = 0;
    }   
    var sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)-parseFloat(pretotal));
    sumAbonado = document.getElementById('sumAbonado').value;
    $("#sumAbonado").val(parseFloat(sumAbonado)+parseFloat(inputVal2));
    if(isNaN(document.getElementById('sumAbonado').value)){
        $("#sumAbonado").val(0);
    }
    $("#abonadoAsesor31").attr("data-old",inputVal2);

    var prePendiente =  $("#pendienteAsesor31").val();
    var repPendiente = prePendiente.replace(/[$,]/g,'');
    $("#pendienteAsesor31").val(inputVal1-inputVal2);
    var totalPendiente = $("#pendienteAsesor31").val();
    var repTotal = totalPendiente.replace(/[$,]/g,'');
    if(repPendiente == '' || repPendiente == undefined){
        repPendiente = 0;
    }   
    var sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)-parseFloat(repPendiente)).toFixed(2));
    sumPendiente = document.getElementById('sumPendiente').value;
    $("#sumPendiente").val((parseFloat(sumPendiente)+parseFloat(repTotal)).toFixed(2));
    if($("#pendienteAsesor31").val()>=0){
        formatCurrency($('#pendienteAsesor31'));
    }
}


//FIN TABLA NUEVA










  $("#form_precioNeto").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/agregar_precioNeto",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(data[0]){
                        $("#modal_precioNeto").modal('toggle');
                        tabla_historial.ajax.reload();

                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
    }
});





  $("#form_vc").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/agregar_comisionvc",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(data[0]){
                        $('#loader').addClass('hidden');
                        $("#modal_vc").modal('toggle');
                        tabla_historial.ajax.reload();
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





$("#form_interes").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/agregar_comision",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if(data[0]){
                        $('#loader').addClass('hidden');
                        $("#modal_nuevas").modal('toggle');
                        tabla_historial.ajax.reload();
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


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


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





////////////////////




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
                        tabla_historial.ajax.reload();
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
                        tabla_historial.ajax.reload();
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


// ideLotenganche
//             planSelect





////////////////////////////////////////


$("#form_new_abono").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url2 + "Comisiones/nuevo_abono_comision",
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
                        $("#modal_new_abono").modal('toggle');
                        tabla_historial.ajax.reload();
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







//////////////////////////////////////





    // FUNCTION MORE

    $(window).resize(function(){
        tabla_historial.columns.adjust();
    //     tabla_proceso.columns.adjust();
    //     tabla_pagadas.columns.adjust();
    //     tabla_otras.columns.adjust();
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

