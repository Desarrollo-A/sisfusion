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
    .file-name {
        margin: 0;
        position: relative;
        overflow: hidden;
        line-height: 30px;
        padding: 5px 12px;
        box-sizing: border-box;
        font-size: 15px;
        vertical-align: middle;
        width: 80%;
        border:none;
        border-radius: 5px 0 0 5px;
        background-color: #eee;
        }
        .btn-select {
        margin: 0;
        height: 40px;
        border: none;
        border-radius: 0 5px 5px 0;
        width: 20%;
        box-sizing: border-box;
        background-color: #7795b3;
        transition: all 0.6s;
        color: #FFF;
        font-size: 15px;
        vertical-align: middle;
        }
        .btn-select:hover {
            background: #2a64ad;        
        }
</style>

<div class="modal fade modal-alertas" id="modal_aprobacion" role="dialog">
    <div class="modal-dialog" style="width:520px;">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">APROBAR PAGO DE COMISIÓN</h4>
            </div>
            <form method="post" id="form_aprobacion">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-alertas" id="modal_prev_fac" role="dialog">
    <div class="modal-dialog" style="width:520px; margin-top:20px">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">DATOS DE FACTURA</h4>
            </div>
            <div class="modal-body" style="padding-top:0">
                <div class="row"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-alertas" id="modal_pausar" role="dialog">
    <div class="modal-dialog" style="width:520px;">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">COMISIÓN EN ESPERA</h4>
            </div>
            <form method="post" id="form_pausar">
                <div class="modal-body"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-alertas" id="modal_reactivacion" role="dialog">
    <div class="modal-dialog" style="width:520px;">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">REACTIVAR COMISIÓN</h4>
            </div>
            <form method="post" id="form_reactivacion">
                <div class="modal-body"></div>
            </form>
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
                                    <ul class="nav nav-pills nav-pills-internomex nav-pills-icons" role="tablist">
                                        <li class="active" style="margin-right: 50px;">
                                            <a href="#factura-1" role="tab" data-toggle="tab">
                                                por pagar con factura
                                            </a>
                                        </li>

                                      

                                        <li style="margin-right: 50px;">
                                            <a href="#asimilados-2" role="tab" data-toggle="tab">
                                               Por pagar asimilados
                                            </a>
                                        </li>

                                        <li style="margin-right: 50px;">
                                            <a href="#espera-3" role="tab" data-toggle="tab">
                                                pagos en espera
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content">

                                    <div class="tab-pane active" id="factura-1">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">COMISIONES NUEVAS - FACTURA</h4>
                                                                <p class="category">Las comisiones con factura se encuentran en espera de dispersión de pago.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total a pagar: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_nfact" id="myText_nfact"></label>

                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_nuevas_fact" name="tabla_nuevas_fact">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">EMPRESA</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">FROMA PAGO</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COM. $</th>
                                                                                        <th style="font-size: .9em;">BENEFICIARIO</th>
                                                                                        <th style="font-size: .9em;">ESTATUS</th>
                                                                                        <th style="font-size: .9em;">FEC. CREACIÓN</th>
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
                                        </div>
                                    </div>

                                    <!-- ///////////////// -->

                                    <div class="tab-pane" id="asimilados-2">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">COMISIONES EN REVISIÓN</h4>
                                                                <p class="category">Las comisiones de pago a asimilados se encuentran en espera de dispersión de pago.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" name="myText_asimilados" id="myText_asimilados"></label>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_nuevas_asimilados" name="tabla_nuevas_asimilados">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">EMPRESA</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">FROMA PAGO</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COM. $</th>
                                                                                        <th style="font-size: .9em;">BENEFICIARIO</th>
                                                                                        <th style="font-size: .9em;">ESTATUS</th>
                                                                                        <th style="font-size: .9em;">FEC. CREACIÓN</th>
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
                                        </div>
                                    </div>


                                 

                                    <!-- /////////////// -->

                                    <div class="tab-pane" id="espera-3">
                                        <div class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                    <h4 class="card-title">COMISIONES EN ESPERA</h4>
                                                                <p class="category">Comisiones pausadas.</p></div>

                                                                <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                    <label style="color: #0a548b;">&nbsp;Total: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="myText_otras" id="myText_otras"></label>
                                                                </div>

                                                            </div>
                                                            <div class="card-content">
                                                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_otras_comisiones" name="tabla_otras_comisiones">
                                                                                <thead>
                                                                                     <tr>
                                                                                        <th style="font-size: .9em;">ID</th>
                                                                                        <th style="font-size: .9em;">LOTE</th>
                                                                                        <th style="font-size: .9em;">EMPRESA</th>
                                                                                        <th style="font-size: .9em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .9em;">FROMA PAGO</th>
                                                                                        <th style="font-size: .9em;">COM. %</th>
                                                                                        <th style="font-size: .9em;">COM. $</th>
                                                                                        <th style="font-size: .9em;">BENEFICIARIO</th>
                                                                                        <th style="font-size: .9em;">ESTATUS</th>
                                                                                        <th style="font-size: .9em;">FEC. CREACIÓN</th>
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
                                        </div>
                                    </div>

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

  $("#tabla_nuevas_fact").ready( function(){

  $('#tabla_nuevas_fact thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
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
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_nfact").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_nuevas_fact').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_nfact").value = to;
});


        tabla_nuevas = $("#tabla_nuevas_fact").DataTable({
            dom: '<"clear">',
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

            // {  "width": "4%" },
            {
                "width": "4%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_comision+'</p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lote+'</p>';
                }
            },

 
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><B>'+d.empresa+'</B></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><I>'+(d.f_pago).toUpperCase();+'</I></p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
                }
            },

                        {
                "width": "13%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                }
            },


            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.nombre_estatus+'</b></p>';
                }
            },
 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            },
            {
                "width": "14%",
                "orderable": false,
                "data": function( d ){

                     return '<button class="btn btn-info btn-round btn-fab btn-fab-mini box-btn-internomex" title="APROBAR PAGO SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff; background:#50B65E;"><i class="material-icons">thumb_up</i></button>'+
                     
                     '<button class="btn btn-round btn-fab btn-fab-mini info ver_factura" title="VER DETALLES PAGO SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff;"><i class="material-icons">info</i></button>'+

                     '<button class="btn btn-info btn-round btn-fab btn-fab-mini pausar_comision" title="PAUSAR PAGO SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff; background:#E4952A;"><i class="material-icons">pause</i></button>';
 
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
                "url": url2 + "Comisiones/getDatosInternomexNuevas",
                /*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        


    ////////////Funcion para insertar html en modal .modal_aprobacion////////////
    $("#tabla_nuevas_fact tbody").on("click", ".box-btn-internomex", function(){
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);
        var comision = $(this).val();
            
        $("#modal_aprobacion .modal-body").html("");
        var elemento = "";
        elemento += '<input id="id_comision" name="id_comision" hidden value='+row.data().id_comision+'>';
        elemento += '<p>¿Está seguro de que se aplicó el pago de la comisión correspondiente al lote: <b>'+row.data().lote+'</b> por el monto de <b>$'+formatMoney(row.data().porcentaje_dinero)+'</b>?</p>';
        elemento += '<div class="box-btn-form" style="width:100%; display:flex; justify-content: space-between">';
        elemento += '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" style="width:40%">Cerrar</button>';
        elemento += '<button class="btn btn-primary" type="submit" style="width:40%">Enviar</button>';
        elemento += '</div>';
        $("#modal_aprobacion .modal-body").append(elemento);
        $("#modal_aprobacion").modal();
    });
    ////////////END Funcion para insertar html en modal .modal_aprobacion////////////

        ///////////////////Función para insertar html en modal .ver_factura//////////////
    $("#tabla_nuevas_fact tbody").on("click", ".ver_factura", function(){
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);
        var comision = $(this).val();
        $("#modal_prev_fac .row").html("");
        $.getJSON( url + "Comisiones/getDatosFactura/"+comision).done(function( data ){
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){
                archivo = url+"UPLOADS/XML/"+data.datos_solicitud['nombre_archivo']+"";
                $("#modal_prev_fac .row").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['folio_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>'); 
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['uuid']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['descripcion']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray; display:flex; justify-content:center"><a class="btn btn-primary" href="'+archivo+'" download="'+data.datos_solicitud['nombre_archivo']+'">Descargar XML</a>');
            }
            else{
                $("#modal_prev_fac .row").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
            }
            $("#modal_prev_fac .row").append('</div>');
            $("#modal_prev_fac").modal();
        });
    });
    ///////////////////END Función para insertar html en modal .ver_factura//////////////

        ///////////////////Función para insertar html en modal .modal_pausar//////////////
    $("#tabla_nuevas_fact tbody").on("click", ".pausar_comision", function(){
        var tr = $(this).closest('tr');
        var row = tabla_nuevas.row(tr);
        $("#modal_pausar .modal-body").html("");
        var elemento = "";
        elemento += '<input id="id_comision" name="id_comision" hidden value='+row.data().id_comision+'>';
        elemento += '<p>¿Está seguro de pausar el pago de la comisión correspondiente al lote: <b>'+row.data().lote+'</b> por el monto de <b>$'+formatMoney(row.data().porcentaje_dinero)+'</b>?</p>';
        elemento += '<div class="box-btn-form" style="width:100%; display:flex; justify-content: space-between">';
        elemento += '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" style="width:40%">Cerrar</button>';
        elemento += '<button class="btn btn-primary" type="submit" style="width:40%">Pausar</button>';
        elemento += '</div>';
        $("#modal_pausar .modal-body").append(elemento);
        $("#modal_pausar").modal();
    });
 
    ///////////////////END Función para insertar html en modal .modal_pausar//////////////


 


 
    });

//FIN TABLA NUEVA

 //INICIO TABLA ASIMILADOS

  $("#tabla_nuevas_asimilados").ready( function(){

  $('#tabla_nuevas_asimilados thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_asimilados.column(i).search() !== this.value ) {
            tabla_asimilados
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_asimilados.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_asimilados.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_asimilados").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_nuevas_asimilados').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_asimilados").value = to;
});


        tabla_asimilados = $("#tabla_nuevas_asimilados").DataTable({
            dom: '<"clear">',
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

            // {  "width": "4%" },
            {
                "width": "4%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_comision+'</p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lote+'</p>';
                }
            },

 
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><B>'+d.empresa+'</B></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><I>'+(d.f_pago).toUpperCase();+'</I></p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
                }
            },

                        {
                "width": "13%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                }
            },


            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.nombre_estatus+'</b></p>';
                }
            },
 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            },
            {
                "width": "14%",
                "orderable": false,
                "data": function( d ){

                     return '<button class="btn btn-info btn-round btn-fab btn-fab-mini box-btn-internomex" title="APROBAR PAGO SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff; background:#50B65E;"><i class="material-icons">thumb_up</i></button>'+
                     
                     '<button class="btn btn-round btn-fab btn-fab-mini info ver_factura" title="VER DETALLES PAGO SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff;"><i class="material-icons">info</i></button>'+

                     '<button class="btn btn-info btn-round btn-fab btn-fab-mini pausar_comision" title="PAUSAR PAGO SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff; background:#E4952A;"><i class="material-icons">pause</i></button>';
 
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
                "url": url2 + "Comisiones/getDatosInternomexNuevas2",
                /*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        


    ////////////Funcion para insertar html en modal .modal_aprobacion////////////
    $("#tabla_nuevas_asimilados tbody").on("click", ".box-btn-internomex", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados.row(tr);
        var comision = $(this).val();
            
        $("#modal_aprobacion .modal-body").html("");
        var elemento = "";
        elemento += '<input id="id_comision" name="id_comision" hidden value='+row.data().id_comision+'>';
        elemento += '<p>¿Está seguro de que se aplicó el pago de la comisión correspondiente al lote: <b>'+row.data().lote+'</b> por el monto de <b>$'+formatMoney(row.data().porcentaje_dinero)+'</b>?</p>';
        elemento += '<div class="box-btn-form" style="width:100%; display:flex; justify-content: space-between">';
        elemento += '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" style="width:40%">Cerrar</button>';
        elemento += '<button class="btn btn-primary" type="submit" style="width:40%">Enviar</button>';
        elemento += '</div>';
        $("#modal_aprobacion .modal-body").append(elemento);
        $("#modal_aprobacion").modal();
    });
    ////////////END Funcion para insertar html en modal .modal_aprobacion////////////

        ///////////////////Función para insertar html en modal .ver_factura//////////////
    $("#tabla_nuevas_asimilados tbody").on("click", ".ver_factura", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados.row(tr);
        var comision = $(this).val();
        $("#modal_prev_fac .row").html("");
        $.getJSON( url + "Comisiones/getDatosFactura/"+comision).done(function( data ){
            if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0'){
                archivo = url+"UPLOADS/XML/"+data.datos_solicitud['nombre_archivo']+"";
                $("#modal_prev_fac .row").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombre']+' '+data.datos_solicitud['apellido_paterno']+' '+data.datos_solicitud['apellido_materno']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['nombreLote']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['total']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ '+data.datos_solicitud['porcentaje_dinero']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['folio_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_factura']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['fecha_ingreso']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['metodo_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>'); 
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['regimen']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['forma_pago']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['cfdi']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['unidad']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['claveProd']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['uuid']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">'+data.datos_solicitud['descripcion']+'</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                $("#modal_prev_fac .row").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray; display:flex; justify-content:center"><a class="btn btn-primary" href="'+archivo+'" download="'+data.datos_solicitud['nombre_archivo']+'">Descargar XML</a>');
            }
            else{
                $("#modal_prev_fac .row").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
            }
            $("#modal_prev_fac .row").append('</div>');
            $("#modal_prev_fac").modal();
        });
    });
    ///////////////////END Función para insertar html en modal .ver_factura//////////////

        ///////////////////Función para insertar html en modal .modal_pausar//////////////
    $("#tabla_nuevas_asimilados tbody").on("click", ".pausar_comision", function(){
        var tr = $(this).closest('tr');
        var row = tabla_asimilados.row(tr);
        $("#modal_pausar .modal-body").html("");
        var elemento = "";
        elemento += '<input id="id_comision" name="id_comision" hidden value='+row.data().id_comision+'>';
        elemento += '<p>¿Está seguro de pausar el pago de la comisión correspondiente al lote: <b>'+row.data().lote+'</b> por el monto de <b>$'+formatMoney(row.data().porcentaje_dinero)+'</b>?</p>';
        elemento += '<div class="box-btn-form" style="width:100%; display:flex; justify-content: space-between">';
        elemento += '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" style="width:40%">Cerrar</button>';
        elemento += '<button class="btn btn-primary" type="submit" style="width:40%">Pausar</button>';
        elemento += '</div>';
        $("#modal_pausar .modal-body").append(elemento);
        $("#modal_pausar").modal();
    });
 
    ///////////////////END Función para insertar html en modal .modal_pausar//////////////


 


 
    });

//FIN TABLA ASIMILADOS

 


// INICIO TABLA OTRAS

  $("#tabla_otras_comisiones").ready( function(){

  $('#tabla_otras_comisiones thead tr:eq(0) th').each( function (i) {
   if( i!=0 && i!=10){
    var title = $(this).text();


    $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {

        if (tabla_otras.column(i).search() !== this.value ) {
            tabla_otras
            .column(i)
            .search(this.value)
            .draw();

            var total = 0;
            var index = tabla_otras.rows({ selected: true, search: 'applied' }).indexes();
            var data = tabla_otras.rows( index ).data();

            $.each(data, function(i, v){
                total += parseFloat(v.porcentaje_dinero);
            });
            var to1 = formatMoney(total);
            document.getElementById("myText_otras").value = formatMoney(total);
        }
    } );
}
});

  $('#tabla_otras_comisiones').on('xhr.dt', function ( e, settings, json, xhr ) {
    var total = 0;
    $.each(json.data, function(i, v){
        total += parseFloat(v.porcentaje_dinero);
    });
    var to = formatMoney(total);
    document.getElementById("myText_otras").value = to;
});


        tabla_otras = $("#tabla_otras_comisiones").DataTable({
            dom: '<"clear">',
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

            // {  "width": "4%" },
            {
                "width": "4%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.id_comision+'</p>';
                }
            },

            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.lote+'</p>';
                }
            },

 
            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><B>'+d.empresa+'</B></p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><I>'+(d.f_pago).toUpperCase();+'</I></p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+(d.porcentaje_decimal).toFixed(2)+' %</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>$ '+formatMoney(d.porcentaje_dinero)+'</b></p>';
                }
            },

                        {
                "width": "13%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                }
            },


            {
                "width": "8%",
                "data": function( d ){
                    return '<p style="font-size: .8em"><b>'+d.nombre_estatus+'</b></p>';
                }
            },
 
            {
                "width": "10%",
                "data": function( d ){
                    return '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                }
            },
            {
                "width": "14%",
                "orderable": false,
                "data": function( d ){

                     return '<button class="btn btn-info btn-round btn-fab btn-fab-mini reactivar_comision" title="REACTIVAR SOLICITUD" value="'+d.id_comision+'" style="margin-right: 3px;color:#fff; background:#D5CB04;"><i class="material-icons">cached</i></button>';
 
                }
            }],

            columnDefs: [

{

    orderable: false,
    className: 'select-checkbox',
    targets:   0,
    'searchable':false,
    'className': 'dt-body-center'
    }],



            "ajax": {
                "url": url2 + "Comisiones/getDatosInternomexPausadas",/*registroCliente/getregistrosClientes*/
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}},
                    "order": [[ 1, 'asc' ]]
                });

        $("#tabla_otras_comisiones tbody").on("click", ".reactivar_comision", function(){
            var tr = $(this).closest('tr');
            var row = tabla_otras.row(tr);
            $("#modal_reactivacion .modal-body").html("");
            var elemento = "";
            elemento += '<input id="id_comision" name="id_comision" hidden value='+row.data().id_comision+'>';
            elemento += '<p>¿Desea regresar a revisión la comisión del lote: '+row.data().lote+' por el monto de $'+formatMoney(row.data().porcentaje_dinero)+'?</p>';
            elemento += '<div class="box-btn-form" style="width:100%; display:flex; justify-content: space-between">';
            elemento += '<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" style="width:40%">Cerrar</button>';
            elemento += '<button class="btn btn-primary" type="submit" style="width:40%">Reactivar</button>';
            elemento += '</div>';
            $("#modal_reactivacion .modal-body").append(elemento);
            $("#modal_reactivacion").modal();
        });


    });

// FIN TABLA PAGADAS







    // FUNCTION MORE

    $(window).resize(function(){
        tabla_nuevas.columns.adjust();
        tabla_revision.columns.adjust();
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

    $(document).on( "click", ".subir_factura", function(){
        resear_formulario();
        id_comision = $(this).val();
        link_post = "Comisiones/guardar_solicitud/"+id_comision;
        $("#modal_formulario_solicitud").modal( {backdrop: 'static', keyboard: false} );
        });




    //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
    function resear_formulario(){
        $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
        $("#modal_formulario_solicitud textarea").html('');

        $("#modal_formulario_solicitud #obse").val('');
 
        var validator = $( "#frmnewsol" ).validate();
        validator.resetForm();
        $( "#frmnewsol div" ).removeClass("has-error");

    }
 
    $("#cargar_xml").click( function(){
            subir_xml( $("#xmlfile") );
        });







    var justificacion_globla = "";

        function subir_xml( input ){

            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;

            data.append("xmlfile", documento_xml);
 
            resear_formulario();

            $.ajax({
                url: url + "Comisiones/cargaxml",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){

                     if( data.respuesta[0] ){

                        documento_xml = xml;

                        var informacion_factura = data.datos_xml;
                        
                        cargar_info_xml( informacion_factura );
                        $("#solobs").val( justificacion_globla );

 
                    }else{
                        input.val('');
                        alert( data.respuesta[1] );
                    }
                },
                error: function( data ){
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });

        }








    function cargar_info_xml( informacion_factura ){

        // alert(informacion_factura);



 

        $("#emisor").val( ( informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '') ).attr('readonly',true);
        $("#rfcemisor").val( ( informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '') ).attr('readonly',true);


        $("#receptor").val( ( informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '') ).attr('readonly',true);
        $("#rfcreceptor").val( ( informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '') ).attr('readonly',true);


        $("#regimenFiscal").val( ( informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '') ).attr('readonly',true);

        $("#formaPago").val( ( informacion_factura.formaPago ? informacion_factura.formaPago[0] : '') ).attr('readonly',true);
        $("#total").val( ('$ '+informacion_factura.total ? '$ '+informacion_factura.total[0] : '') ).attr('readonly',true);

        $("#cfdi").val( ( informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '') ).attr('readonly',true);

        $("#metodopago").val( ( informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '') ).attr('readonly',true);

        $("#unidad").val( ( informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '') ).attr('readonly',true);

        $("#clave").val( ( informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '') ).attr('readonly',true);

        $("#obse").val( ( informacion_factura.descripcion ? informacion_factura.descripcion[0] : '') ).attr('readonly',true);
  

       
 
        
    }




 // id_comision = id_comision;

    $("#frmnewsol").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
 
                    var data = new FormData( $(form)[0] );
                    // data.append("id_comision", id_comision);
                    data.append("xmlfile", documento_xml);

                    // if( !$("#proveedor").prop("disabled") ){
                    //     data.append("idproveedor", $("#proveedor").val());
                    // }
                    
                    // data.append("descr", $("#descr").val());

                    $.ajax({
                        url: url + link_post,
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data){
                            if( data.resultado ){
                                alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                                 $("#modal_formulario_solicitud").modal( 'toggle' );
                                 tabla_nuevas.ajax.reload();
                            }else{
                                alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                            }
                        },error: function( ){
                            alert("ERROR EN EL SISTEMA");
                        }
                    });

             
        }
    });



$("#form_pausar").submit( function(e) {
    e.preventDefault();
    id_comision = $("#id_comision").val();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url + "Comisiones/setPausarInternomex/"+id_comision,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if(true){           
                    $('#modal_pausar').modal('toggle');
                    alerts.showNotification("top", "right", "Se ha pausado la comisión exitosamente", "success");
                    setTimeout(function() {
                        document.location.reload()
                    }, 3000);
                }else{  
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    alerts.showNotification("top", "right", "No se ha podido completar la solicitud", "danger");
                    setTimeout(function() {
                        document.location.reload()
                    }, 3000);
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});



$("#form_aprobacion").submit( function(e) {
    e.preventDefault();
    id_comision = $("#id_comision").val();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url + "Comisiones/setAprobacionInternomex/"+id_comision,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if(true){           
                    // document.getElementById("confComisiones").submit();
                    $('#modal_aprobacion').modal('toggle');
                    alerts.showNotification("top", "right", "Se ha aprobado la comisión exitosamente", "success");
                    setTimeout(function() {
                        document.location.reload()
                    }, 3000);
                }else{  
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});




$("#form_reactivacion").submit( function(e) {
    e.preventDefault();
    id_comision = $("#id_comision").val();
}).validate({
    submitHandler: function( form ) {
        var data = new FormData( $(form)[0] );
        $.ajax({
            url: url + "Comisiones/setReactivarInternomex/"+id_comision,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if(true){           
                    $('#modal_reactivacion').modal('toggle');
                    alerts.showNotification("top", "right", "Se ha reactivado la comisión, ahora puede verificarlo.", "success");
                    setTimeout(function() {
                        document.location.reload()
                    }, 3000);
                }else{  
                    alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    alerts.showNotification("top", "right", "No se ha podido completar la solicitud", "danger");
                    setTimeout(function() {
                        document.location.reload()
                    }, 3000);
                }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
    }
});



// location.reload();



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


function cleanComments()
{

    var myCommentsList = document.getElementById('documents');
    myCommentsList.innerHTML = '';

    var myFactura = document.getElementById('facturaInfo');
    myFactura.innerHTML = '';
  

}


function fillFields (v) {

    alert(v.nombre);




}



 

</script>

