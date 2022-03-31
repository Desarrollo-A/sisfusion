<body>
    <div class="wrapper">

        <?php

        switch ($this->session->userdata('id_rol')) {
            case '28': // DIRECTOR
           
                $datos = array();
                $datos = $datos4;
                $datos = $datos2;
                $datos = $datos3;
                $this->load->view('template/sidebar', $datos);
                break;
            default: // NO ACCESS
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
        ?>


        <style type="text/css">
            ::-webkit-input-placeholder {
                /* Chrome/Opera/Safari */
                color: white;
                opacity: 0.4;

                ::-moz-placeholder {
                    /* Firefox 19+ */
                    color: white;
                    opacity: 0.4;
                }

                :-ms-input-placeholder {
                    /* IE 10+ */
                    color: white;
                    opacity: 0.4;
                }

                :-moz-placeholder {
                    /* Firefox 18- */
                    color: white;
                    opacity: 0.4;
                }
            }

            :root {
                --color-green: #00a878;
                --color-red: #fe5e41;
                --color-button: #fdffff;
                --color-black: #000;
            }

            .switch-button {
                display: inline-block;
            }

            .switch-button .switch-button__checkbox {
                display: none;
            }

            .switch-button .switch-button__label {
                background-color: var(--color-red);
                width: 5rem;
                height: 3rem;
                border-radius: 3rem;
                display: inline-block;
                position: relative;
            }

            .switch-button .switch-button__label:before {
                transition: .2s;
                display: block;
                position: absolute;
                width: 3rem;
                height: 3rem;
                background-color: var(--color-button);
                content: '';
                border-radius: 50%;
                box-shadow: inset 0px 0px 0px 1px var(--color-black);
            }

            .switch-button .switch-button__checkbox:checked+.switch-button__label {
                background-color: var(--color-green);
            }

            .switch-button .switch-button__checkbox:checked+.switch-button__label:before {
                transform: translateX(2rem);
            }
        </style>


        <!--<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
            <div class="modal-dialog" style="margin-top:20px;"></div>
        </div>-->


        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>


        <div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
       
            <form method="post" id="form_colaboradores">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
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
                                        

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="nuevas-1">
                                                <div class="content">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-header">

                                                                        <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                                            <h4 class="card-title">COMISIONES NUEVAS</h4>
                                                                            <p class="category">Las comisiones se encuentran <b>disponibles</b> para solicitar tu pago.</p>
                                                                            <p class="estado_horario"></p>

                                                                        </div>

                                                                        <div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6"><br>
                                                                            <label style="color: #0a548b;">&nbsp;Disponible: $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" name="myText_nuevas" id="myText_nuevas"></label>


                                                                            <label style="color: #0a548b;">&nbsp;Solicitar: $

                                                                                <span style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" id="totpagarPen"></span>

                                                                            </label>

                                                                        </div>

                                                                    </div>
                                                                    <div class="card-content">

                                                                        <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                            <div class="material-datatables">
                                                                                <div class="form-group">
                                                                                    <div class="text-right">
                                                                                        <!-- <button class="btn btn-info text-right subir_factura_multiple" title="SUBIR FACTURA MULTIPLE"">FACTURA MULTIPLE</button> -->
                                                                    </div>
                                                                        <div class=" table-responsive">
                                                                                            <table class="table table-responsive table-bordered table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones" style="text-align:center;">
                                                                                                <thead>
                                                                                                <tr>
                                                                                <th style="font-size: .8em;"></th>
                                                                                        <th style="font-size: .8em;">ID PAGO</th>
                                                                                        <th style="font-size: .8em;">LOTE</th>
                                                                                        <th style="font-size: .8em;">PRECIO LOTE</th>
                                                                                        <th style="font-size: .8em;">TOTAL COM. ($)</th>
                                                                                        <th style="font-size: .8em;">COM %.</th>
                                                                                        <th style="font-size: .8em;">PAGO CLIENTE</th>
                                                                                        <th style="font-size: .8em;">ABONO NEO.</th>
                                                                                        <th style="font-size: .8em;">PAGADO</th>
                                                                                        <th style="font-size: .8em;">PENDIENTE</th>
                                                                                        <th style="font-size: .8em;">FECHA APARTADO</th>
                                                                                        <th style="font-size: .8em;">SEDE</th>
                                                                                        <th style="font-size: .8em;">SEDE COMISIÓN</th>
                                                                                        <th style="font-size: .8em;">ESTATUS</th>
                                                                                        <!-- <th style="font-size: .8em;">TIPO</th> -->
                                                                                        <!-- <th style="font-size: .8em;"></th> -->
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
        <style>
            .abc {
                z-index: 9999999;
            }
        </style>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>

    </div>
    <!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script>
    var url = "<?= base_url() ?>";
    var url2 = "<?= base_url() ?>index.php/";
    var totaPen = 0;
    var tr;

    $("#tabla_nuevas_comisiones").ready(function() {

        let titulos = [];
        $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
            if(i != 0 && i != 13){
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function() {

                    if (tabla_nuevas.column(i).search() !== this.value) {
                        tabla_nuevas
                            .column(i)
                            .search(this.value)
                            .draw();

                        var total = 0;
                        var index = tabla_nuevas.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                        var data = tabla_nuevas.rows(index).data();

                        $.each(data, function(i, v) {
                            total += parseFloat(v.pago_cliente);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("myText_nuevas").value = formatMoney(total);
                    }
                });
            }
        });

        $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function(i, v) {
                total += parseFloat(v.pago_cliente);
            });
            var to = formatMoney(total);
            document.getElementById("myText_nuevas").value = to;
        });

        tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
            dom: 'Brtip',
            "buttons": [
                {
                text: '<i class="fa fa-check"></i> REGIÓN SAKURA',
                action: function() {
                    if ($('input[name="idT[]"]:checked').length > 0) {
                        var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                            return this.value;
                        }).get();
                        $.get(url + "Comisiones/asigno_region_uno/" + idcomision).done(function() {                            
                                $("#myModalEnviadas").modal('toggle');
                                tabla_nuevas.ajax.reload();
                                // tabla_revision.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?= base_url('dist/img/check_com.png') ?>'><br><br><P>COMISIONES ASIGNADAS A REGIÓN 1 - <b>SAKURA TIJERINA</b> PARA SU REVISIÓN.</P><BR><i style='font-size:12px;'></i></P></center>");
                            
                        });
                    }
                },

                attr: {
                    class: 'btn btn-info',
                 }
            }, 

            {
                text: '<i class="fa fa-check"></i> REGIÓN MARICELA',
                action: function() {
                    if ($('input[name="idT[]"]:checked').length > 0) {
                        var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                            return this.value;
                        }).get();
                        $.get(url + "Comisiones/asigno_region_dos/" + idcomision).done(function() {                            
                                $("#myModalEnviadas").modal('toggle');
                                tabla_nuevas.ajax.reload();
                                // tabla_revision.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?= base_url('dist/img/check_com.png') ?>'><br><br><P>COMISIONES ASIGNADAS A REGIÓN 2 - <b>MARICELA RICO</b> PARA SU REVISIÓN.</P><BR><i style='font-size:12px;'></i></P></center>");
                            
                        });
                    }
                },

                attr: {
                    class: 'btn btn-warning',
                 }
            }, 
            
        
       {
           extend:    'excelHtml5',
           text:      '<i class="fa fa-file-excel-o"></i>',
           titleAttr: 'Excel',
          exportOptions: {
              columns: [1,2,3,4,5,6,7,8,9,10,11],
              format: {
                 header:  function (d, columnIdx) {
                     if(columnIdx == 0){
                         return ' '+d +' ';
                        }else if(columnIdx == 10){
                            return 'ESTATUS ';
                        }
                        else if(columnIdx != 10 && columnIdx !=0){
                            if(columnIdx == 11){
                                return 'FECHA'
                            }
                            else{
                                return ' '+titulos[columnIdx-1] +' ';
                            }
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
            "language": {
                url: "../static/spanishLoader.json"
            },
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            "columns": [

{  "width": "5%",
"data": function( d ){
        return '<p style="font-size: .8em">'+d.id_lote+'</p>';
    }},
    {  "width": "5%",
"data": function( d ){
        return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
    }},
{
    "width": "12%",
    "data": function( d ){
        return '<p style="font-size: .8em"><b>'+d.lote+'</b></p>';
    }
},
{
    "width": "8%",
    "data": function( d ){
        return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
    }
},
 {
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+' </p>';
    }
},
{
    "width": "5%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+formatMoney(d.porcentaje_decimal)+'%</p>';
    }
},
{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
    }
},
 {
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
    }
},
{
    "width": "10%",
    "data": function( d ){
        return '<p style="font-size: .8em">$'+formatMoney(d.pagado)+'</p>';
    }
},
 {
    "width": "10%",
    "data": function(d) {
        if (d.restante == null || d.restante == '') {
            return '<p style="font-size: .8em">$' + formatMoney(d.comision_total) + '</p>';
        } else {
            return '<p style="font-size: .8em">$' + formatMoney(d.restante) + '</p>';
        }
    }
},

{
    "width": "10%",
    "data": function( d ){
        let fech = d.fechaApartado;
let fecha = fech.substr(0, 10);

let nuevaFecha = fecha.split('-');
return '<p style="font-size: .8em">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
    }
},
 
{
    "width": "5%",
    "data": function( d ){
        return '<p style="font-size: .8em">'+d.nombre+'</p>';
    }
} ,
{
                    data: function (d) {
                        if (d.ubicacion_dos == null) {
                            return '<p style="font-size: .8em">Sin lugar de venta asignado</p>';
                        } else {
                            return '<p style="font-size: .8em">' + d.ubicacion_dos + '</p>';
                        }
                    }
                },

{
    "width": "5%",
    "data": function( d ){

        var lblStats;
 
    if(d.estatus==1||d.estatus=='1') {
            lblStats ='<span class="label label-danger">Sin validar</span>';
    }
    else if(d.estatus==41||d.estatus=='41') {
        lblStats ='<span class="label" style="background:blue;">ENVIADA A REGIÓN 2</span>';
        }

    else if(d.estatus==42||d.estatus=='42') {
        lblStats ='<span class="label" style="background:#7095E5;">ENVIADA A REGIÓN 1</span>';
        }

    else if(d.estatus==51||d.estatus=='51'||d.estatus==52||d.estatus=='52') {
        lblStats ='<button class="btn btn-round btn-fab btn-fab-mini aprobar_solicitud" title="PARCIALIDAD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'" style="margin-right: 3px;color:#fff; background:#FBCF5B;"><i class="material-icons">done</i></button>';   
    }
    else if(d.estatus==61||d.estatus=='61') {
        lblStats ='<span class="label" style="background:red;">RECHAZO REGIÓN 2</span>';
        }

    else if(d.estatus==62||d.estatus=='62') {
        lblStats ='<span class="label" style="background:red;">RECHAZO REGIÓN 1</span>';
        }
 
return lblStats;

 
    }
} 






 
],

            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0,
                'searchable': false,
                'className': 'dt-body-center',
                'render': function(d, type, full, meta) {

                    if(full.estatus != 1 && full.estatus != 61 && full.estatus != 62 && full.estatus != 51 && full.estatus != 52){
                        return '';

                    }else{
                        return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                    }   
                    
                },
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
            }],

            "ajax": {
                "url": url2 + "Comisiones/getDatosNuevasMktd_pre",
                "type": "POST",
                cache: false,
                "data": function(d) {}
            },
            "order": [
                [1, 'asc']
            ]
        });

        /*$("#tabla_nuevas_comisiones tbody").on("click", ".mas_opciones_8", function() {
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row(tr);

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>ASESOR:&nbsp;&nbsp;<b>' + row.data().nombreLote + '</b></p> </div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>PLAN DE PAGO:&nbsp;&nbsp;<b>' + row.data().nombreLote + '</b></p></div><div class="col-lg-6"><p>NOMBRE LOTE:&nbsp;&nbsp;<b>' + row.data().nombreLote + '</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-6"><p>VENTA:&nbsp;&nbsp;<b>' + row.data().nombreLote + '</b></p></div><div class="col-lg-6"><p>COMISIÓN $:&nbsp;&nbsp;<b>' + row.data().nombreLote + '</b></p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>MEDIO(S) DE VENTA:&nbsp;&nbsp;<b>' + row.data().nombreLote + '</b></p></div></div>');
            $("#modal_nuevas").modal();
        });*/



        $("#tabla_nuevas_comisiones tbody").on("click", ".aprobar_solicitud", function(){
          var tr = $(this).closest('tr');
        //   var row = plaza_1.row( tr );
          var row = tabla_nuevas.row(tr);
          let c=0;
          $("#modal_colaboradores .modal-body").html("");
          $("#modal_colaboradores .modal-footer").html("");
          $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Desea aprobar la solicitud del lote: <b>'+row.data().lote+'</b> por la cantidad de: <b>$'+formatMoney(row.data().pago_cliente)+'</b>?</p> </div></div>');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_pago" name="pago_id" value="'+row.data().id_pago_i+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_comision" name="com_value" value="'+row.data().id_comision+'">');
          $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+row.data().pago_cliente+'">');
          $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="Aprobar"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
          $("#modal_colaboradores").modal();
        });


        $('#tabla_nuevas_comisiones').on('click', 'input', function() {
            tr = $(this).closest('tr');

            var row = tabla_nuevas.row(tr).data();

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



        /*$("#tabla_nuevas_comisiones tbody").on("click", ".pedir_parcialidad", function() {
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row(tr);
            id_pago = $(this).val();

            $("#modalParcialidad .modal-body").html("");
            $("#modalParcialidad .modal-body").append('<div class="row"><div class="col-lg-12"><p>Solo puede solicitar una parcialidad de pago menor al monto correpondiente a la cantidad de <b>$' + formatMoney(row.data().pago_cliente) + '<input type="hidden" id="value_pago_cliente" name="value_pago_cliente" value="' + formatMoney(row.data().pago_cliente) + '"></b>.</p></div></div>');
            $("#modalParcialidad .modal-body").append('<div class="row"><div class="col-lg-12"><input type="text" id="new_value_parcial"  id="new_value_parcial" class="form-control" onkeydown="calcularMontoParcialidad()"><div name="label_estado" name="label_estado"></div></div></div>');
            $("#modalParcialidad").modal();
        });*/

        /**---------------------------------------------------------------------------------------------------------------------------------------- */

        /*$("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_facturas2", function() {

            id_pago = $(this).val();
            user = $(this).attr("data-usuario");


            $("#seeInformationModal").modal();


            $.getJSON(url + "Comisiones/getDatosFactura/" + id_pago).done(function(data) {

                $("#seeInformationModal .facturaInfo").append('<div class="row">');
                if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0') {

                    $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['nombre'] + ' ' + data.datos_solicitud['apellido_paterno'] + ' ' + data.datos_solicitud['apellido_materno'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['nombreLote'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ ' + data.datos_solicitud['total'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ ' + formatMoney(data.datos_solicitud['porcentaje_dinero']) + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['folio_factura'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['fecha_factura'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['fecha_ingreso'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['metodo_pago'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['regimen'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['forma_pago'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['cfdi'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['unidad'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['claveProd'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['uuid'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['descripcion'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                } else {
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
                }
                $("#seeInformationModal .facturaInfo").append('</div>');


            });

            $.getJSON("getComments/" + id_pago + "/" + user).done(function(data) {
                //   counter = 0;
                $.each(data, function(i, v) {
                    //   counter ++;
                    //fillTimeline(v);
                    $("#comments-list-factura").append('<li class="timeline-inverted">\n' +
                        '    <div class="timeline-badge info"></div>\n' +
                        '    <div class="timeline-panel">\n' +
                        '            <label><h6>' + v.nombre_usuario + '</h6></label>\n' +
                        '            <br>' + v.comentario + '\n' +
                        '        <h6>\n' +
                        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_movimiento + '</span>\n' +
                        '        </h6>\n' +
                        '    </div>\n' +
                        '</li>');
                });
            });

        });*/
        /**--------------------------------------------------------- -------------------------------------------------------------------------------------------*/
        /*$("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_asimilados", function() {
            id_pago = $(this).val();
            user = $(this).attr("data-usuario");

            $("#seeInformationModalAsimilados").modal();

            $.getJSON("getComments/" + id_pago + "/" + user).done(function(data) {
                counter = 0;
                $.each(data, function(i, v) {
                    counter++;
                    //fillTimeline(v);
                    $("#comments-list-asimilados").append('<li class="timeline-inverted">\n' +
                        '    <div class="timeline-badge info"></div>\n' +
                        '    <div class="timeline-panel">\n' +
                        '            <label><h6>' + v.nombre_usuario + '</h6></label>\n' +
                        '            <br>' + v.comentario + '\n' +
                        '        <h6>\n' +
                        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_movimiento + '</span>\n' +
                        '        </h6>\n' +
                        '    </div>\n' +
                        '</li>');
                });
            });

        });*/



        /*$("#tabla_nuevas_comisiones tbody").on("click", ".consultar_detalles", function() {
            id_com = $(this).val();
            id_pj = $(this).attr("data-personalidad");

            $("#seeInformationModal").modal();

            $.getJSON(url + "Comisiones/getDatosDetalles/" + id_com + "/" + id_pj).done(function(data) {
                $.each(data, function(i, v) {

                    $("#seeInformationModal .documents").append('<div class="row">');
                    if (v.estado == "NO EXISTE") {

                        $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:gray;">' + (v.nombre).substr(0, 52) + '</label></div><div class="col-md-5"><label style="font-size:10px; margin:0; color:gray;">(No existente)</label></div>');
                    } else {
                        $("#seeInformationModal .documents").append('<div class="col-md-7"><label style="font-size:10px; margin:0; color:#0a548b;"><b>' + (v.nombre).substr(0, 52) + '</b></label></div> <div class="col-md-5"><label style="font-size:10px; margin:0; color:#0a548b;"><b>(' + v.expediente + ')</label></b> - <button onclick="preview_info(&#39;' + (v.expediente) + '&#39;)" style="border:none; background-color:#fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 12px; color:#0a548b;"></i></button></div>');
                    }
                    $("#seeInformationModal .documents").append('</div>');
                });
            });


            $.getJSON(url + "Comisiones/getDatosFactura/" + id_com).done(function(data) {

                $("#seeInformationModal .facturaInfo").append('<div class="row">');
                if (!data.datos_solicitud['id_factura'] == '' && !data.datos_solicitud['id_factura'] == '0') {

                    $("#seeInformationModal .facturaInfo").append('<BR><div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>NOMBRE EMISOR</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['nombre'] + ' ' + data.datos_solicitud['apellido_paterno'] + ' ' + data.datos_solicitud['apellido_materno'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b> LOTE</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['nombreLote'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>TOTAL FACT.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ ' + data.datos_solicitud['total'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>MONTO COMSN.</b></label><br><label style="font-size:12px; margin:0; color:gray;">$ ' + data.datos_solicitud['pago_cliente'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FOLIO</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['folio_factura'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA FACTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['fecha_factura'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-4"><label style="font-size:14px; margin:0; color:gray;"><b>FECHA CAPTURA</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['fecha_ingreso'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>MÉTODO</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['metodo_pago'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>RÉGIMEN F.</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['regimen'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>FORMA P.</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['forma_pago'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CFDI</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['cfdi'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>UNIDAD</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['unidad'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-3"><label style="font-size:14px; margin:0; color:gray;"><b>CLAVE PROD.</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['claveProd'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-6"><label style="font-size:14px; margin:0; color:gray;"><b>UUID</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['uuid'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');

                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:14px; margin:0; color:gray;"><b>DESCRIPCIÓN</b></label><br><label style="font-size:12px; margin:0; color:gray;">' + data.datos_solicitud['descripcion'] + '</label><br><label style="font-size:12px; margin:0; color:gray;"> </label></div>');
                } else {
                    $("#seeInformationModal .facturaInfo").append('<div class="col-md-12"><label style="font-size:10px; margin:0; color:orange;">SIN HAY DATOS A MOSTRAR</label></div>');
                }
                $("#seeInformationModal .facturaInfo").append('</div>');

            });

        });*/







    });

    //FIN TABLA NUEVA


    // $("#tabla_porcentajes_mktd tbody").on("click", ".update_colaborador", function(){

    // $("#modal_mktd .modal-body").html("");
    // $("#modal_mktd .modal-body").append('<div class="row"><div class="col-lg-12"><p><b>'+row.data().colaborador+'</b></p> </div></div>');
    // $("#modal_mktd .modal-body").append('<div class="row"><div class="col-lg-6"><p>'+row.data().puesto+'</p></div></div>');


    // $("#modal_mktd .modal-body").append('<br><div class="row"><div class="col-lg-6"><p>Porcentaje activo:&nbsp;&nbsp;<b>'+row.data().porcentaje+'%</b></p></div><div class="col-lg-6"></div></div>');
    // $("#modal_mktd .modal-body").append('<div class="row"><div class="col-lg-6"><p>Porcentaje nuevo:&nbsp;&nbsp;<input name="valor_agregado" id="valor_agregado"maxlength="2" size="4"></p></div><div class="col-lg-6"><p>Fecha inicio:&nbsp;&nbsp;<input name="valor_fecha" id="valor_fecha" type="date"></p></div></div>');
    // $("#modal_mktd .modal-body").append('<div class="row"><div class="col-lg-4"><input type="button" class="btn btn-round desactivar_user" value="DESACTIVAR"></div> <div class="col-lg-4"><input type="button" class="btn btn-round btn-primary" value="ACEPTAR"></div> <div class="col-lg-4"><input type="button" class="btn btn-round btn-danger" value="CANCELAR"></div></div>');




    $(window).resize(function() {
        tabla_nuevas.columns.adjust();
        // tabla_revision.columns.adjust();
        // tabla_pagadas.columns.adjust();
        // tabla_otras.columns.adjust();
        // tabla_mktd.columns.adjust();
    });

    function formatMoney(n) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    /*$(document).on("click", ".subir_factura", function() {
        resear_formulario();
        id_comision = $(this).val();
        total = $(this).attr("data-total");
        link_post = "Comisiones/guardar_solicitud/" + id_comision;
        $("#modal_formulario_solicitud").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#modal_formulario_solicitud .modal-body #frmnewsol").append(`<div id="inputhidden"><input type="hidden" id="comision_xml" name="comision_xml" value="${ id_comision}">
        <input type="hidden" id="pago_cliente" name="pago_cliente" value="${ parseFloat(total).toFixed(2) }"></div>`);
    });*/


    let c = 0;

    /*function saveX() {
        save2();
    }*/

 

    $("#form_colaboradores").submit( function(e) {
        e.preventDefault();
        var id_pago = $('#id_pago').val();
        var id_comision=$('#id_comision').val();
        $.ajax({
            type: "POST",
            url: url2 + "Comisiones/aprobar_comision",
            data: {id_pago: id_pago, id_comision: id_comision},
            dataType: 'json',
            success: function(data){
                    // if(true){
                    //     $('#loader').addClass('hidden');
                        $("#modal_colaboradores").modal('toggle');
                        tabla_nuevas.ajax.reload();
                        // plaza_1.ajax.reload();
                        alert("¡Se envío con éxito a Director de MKTD!");
                    // }else{
                    //     alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    //     $('#loader').addClass('hidden');
                    // }
            },error: function( ){
                alert("ERROR EN EL SISTEMA");
            }
        });
          
    })
 

    /*function cleanComments() {

        var myCommentsList = document.getElementById('comments-list-factura');
        myCommentsList.innerHTML = '';

        // var myCommentsList = document.getElementById('documents');
        // myCommentsList.innerHTML = '';

        var myFactura = document.getElementById('facturaInfo');
        myFactura.innerHTML = '';


    }*/

    /*function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        myCommentsList.innerHTML = '';
    }*/


    /*function fillFields(v) {
        // alert(v.nombre);
    }*/



    /*function close_modal_xml() {
        $("#modal_nuevas").modal('toggle');
    }*/
</script>

<script>
    /*$(document).ready(function() {

        $.getJSON(url + "Comisiones/report_plazas").done(function(data) {
            $(".report_plazas").html();
            $(".report_plazas1").html();
            $(".report_plazas2").html();

            if (data[0].id_plaza == '0' || data[1].id_plaza == 0) {
                if (data[0].plaza00 == null || data[0].plaza00 == 'null' || data[0].plaza00 == '') {
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> ' + data[0].plaza01 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                } else {
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> ' + data[0].plaza01 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> ' + data[0].plaza00 + '%</label>');
                }

            }
            if (data[1].id_plaza == '1' || data[1].id_plaza == 1) {
                if (data[1].plaza10 == null || data[1].plaza10 == 'null' || data[1].plaza10 == '') {
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> ' + data[1].plaza11 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                } else {
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> ' + data[1].plaza11 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> ' + data[1].plaza10 + '%</label>');
                }

            }

            if (data[2].id_plaza == '2' || data[2].id_plaza == 2) {
                if (data[2].plaza20 == null || data[2].plaza20 == 'null' || data[2].plaza20 == '') {
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> ' + data[2].plaza21 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                } else {
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> ' + data[2].plaza21 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> ' + data[2].plaza20 + '%</label>');
                }

            }
        });
    });*/
</script>