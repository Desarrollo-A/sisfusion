<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
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
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" id="form_colaboradores">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="form_mktd">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Plaza 1</label>
                                    <select name="plaza1" id="plaza1" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Plaza 2</label>
                                    <select name="plaza2" id="plaza2" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Comisiones nuevas</h3>
                                    <p class="card-title pl-1">(Pagos dispersados por el área de contraloría, disponibles para revisión)</p>
                                </div>
                                <div class="material-datatables">
                                    <div class="container-fluid encabezado-totales">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="row">
                                                    <div class="col-md-12 no-shadow"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">DISPONIBLE</h4>
                                                        <p class="text-center"><i class="fa fa-usd" aria-hidden="true"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="myText_nuevas" style="font-size:30px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                                <div class="row d-flex justify-center">
                                                    <div class="col-md-12">
                                                        <h4 class="text-center">ENVIAR A VALIDACIÓN</h4>
                                                        <p class="text-center"><i class="far fa-hand-point-right"></i></p>
                                                        <input class="styles-tot" disabled="disabled" readonly="readonly" type="text" id="totpagarPen" style="font-size:30px" value="$0.00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                                                <div class="row">
                                                    <div class="col-md-12 no-shadow"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>ID LOTE</th>
                                                        <th>NOMBRE LOTE</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COM. ($)</th>
                                                        <th>PAGO CLIENTE</th>
                                                        <th>ABONO NEO.</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>FEC. APARTADO</th>
                                                        <th>DETALLE</th>
                                                        <th>SEDE</th>
                                                        <th>SEDE COMISIÓN</th>
                                                        <th>ESTATUS</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->
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


        $.post(url + "Comisiones/listSedes", function (data) {
            var len = data.length;
            for (var i = 0; i < len -1; i++) {
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#plaza1").append($('<option>').val(id).text(name.toUpperCase()));
                $("#plaza2").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#plaza1").selectpicker('refresh');
            $("#plaza2").selectpicker('refresh');
        }, 'json');


        $("#tabla_nuevas_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 0){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text"  class="textoshead" placeholder="' + title + '"/>');
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
                            document.getElementById("myText_nuevas").value = '$' + formatMoney(total);
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
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'COMISIONES NUEVAS COBRANZA MKTD',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }
                                else if(columnIdx == 14){
                                    return 'ESTATUS';
                                }
                                else if(columnIdx != 14 && columnIdx !=0){
                                    if(columnIdx == 12){
                                        return 'SEDE BASE';
                                    }
                                    else{
                                        return ' '+titulos[columnIdx-1] +' ';
                                    }
                                }
                            }
                        }
                    },
                },
                {
                    text: ' REGIÓN MARICELA',
                    className: 'btn-large btn-orangeYellow',
                    action: function() {
                        if ($('input[name="idT[]"]:checked').length > 0) {
                            var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                return this.value;
                            }).get();
                            $.get(url + "Comisiones/asigno_region_dos/" + idcomision).done(function() {                            
                                    $("#myModalEnviadas").modal('toggle');
                                    tabla_nuevas.ajax.reload();
                                    $("#myModalEnviadas .modal-body").html("");
                                    $("#myModalEnviadas").modal();
                                    $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?= base_url('dist/img/check_com.png') ?>'><br><br><P>COMISIONES ASIGNADAS A REGIÓN 2 - <b>MARICELA RICO</b> PARA SU REVISIÓN.</P><BR><i style='font-size:12px;'></i></P></center>");
                                
                            });
                        }
                    },
                }, 
                {
                    text: ' REGIÓN FERNANDA',
                    className: 'btn-large btn-blueMaderas',
                    action: function() {
                        if ($('input[name="idT[]"]:checked').length > 0) {
                            var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                return this.value;
                            }).get();
                            $.get(url + "Comisiones/asigno_region_uno/" + idcomision).done(function(){
                                $("#myModalEnviadas").modal('toggle');
                                tabla_nuevas.ajax.reload();
                                $("#myModalEnviadas .modal-body").html("");
                                $("#myModalEnviadas").modal();
                                $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?= base_url('dist/img/check_com.png') ?>'><br><br><P>COMISIONES ASIGNADAS A REGIÓN 1 - <b>MARIA FERNANDA LICEA</b> PARA SU REVISIÓN.</P><BR><i style='font-size:12px;'></i></P></center>");
                            });
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{  
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_lote+'</p>';
                    }
                },
                {  
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_pago_i+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.id_lote+'</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.lote+'</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pagado)+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        if (d.restante == null || d.restante == '') {
                            return '<p class="m-0">$' + formatMoney(d.comision_total) + '</p>';
                        } else {
                            return '<p class="m-0">$' + formatMoney(d.restante) + '</p>';
                        }
                    }
                },
                {
                    "width": "9%",
                    "data": function( d ){
                        let fech = d.fechaApartado;
                        let fecha = fech.substr(0, 10);
                        let nuevaFecha = fecha.split('-');
                        return '<p class="m-0">'+nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0]+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        if(d.bonificacion >= 1){
                            p1 = '<p title="Lote con bonificación en NEODATA"><span class="label" style="background:pink;color: black;">Bon. $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p title="Lote con cancelación de CONTRATO"><span class="label" style="background:crimson;">Recisión</span></p>';
                        }
                        else{
                            p2 = '';
                        }

                        return p1 + p2;;
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombre+'</p>';
                    }
                } ,
                {
                    "width": "5%",
                    "data": function( d ){
                        if(d.idc_mktd == null){
                            if (d.ubicacion_dos == null) {
                                return '<p color:crimson;"><b>Sin lugar de venta asignado</b></p>';
                            }else {
                                return '<p>' + d.ubicacion_dos + '</p>';
                            }
                        }else{
                            return '<span class="label label-warning">Compartida</span><br><br>'+'<p><b>' +d.sd1+' / '+d.sd2+ '</b></p>';
                        }
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        var lblStats;
                            if(d.idc_mktd == null){
                                if (d.ubicacion_dos == null) {
                                    if(d.estatus==1) {
                                        lblStats ='<span class="label label-danger">Sin validar</span>';
                                    }else if(d.estatus==41 || d.estatus == 42) {
                                        lblStats ='<span class="label" style="background:dodgerblue;">ENVIADA A REGIÓN 2</span>';
                                    }else if(d.estatus==61 || d.estatus==62) {
                                        lblStats ='<span class="label" style="background:crimson;">RECHAZO REGIÓN 2</span>';
                                    }
                                    else{
                                        lblStats ='<span class="label label-danger">NA</span>';
                                    }
                                }
                                else{
                                    if(d.estatus==41 || d.estatus == 42) {
                                        lblStats ='<span class="label" style="background:dodgerblue;">ENVIADA A REGIÓN 2</span>';
                                    }else if(d.estatus==61 || d.estatus == 62) {
                                        lblStats ='<span class="label" style="background:crimson;">RECHAZO REGIÓN 2</span>';
                                    }else if(d.estatus==51 || d.estatus==52 ||d.estatus==1) {
                                        lblStats ='<div class="d-flex justify-center"><button class="btn-data btn-green aprobar_solicitud" title="ENVIAR A DIRECTOR MKTD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'"><i class="material-icons">done</i></button></div>';
                                    }
                                    else{
                                        lblStats ='<span class="label label-danger">NA</span>';
                                    }
                                }
                            }
                            else{
                                lblStats = '<div class="d-flex justify-center"><button class="btn-data btn-green aprobar_solicitud" title="ENVIAR A DIRECTOR MKTD" value="' + d.id_pago_i +'" data-value="' + d.id_sede +'"><i class="material-icons">done</i></button></div>';
                            }
                        return lblStats;
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    'searchable': false,
                    'className': 'dt-body-center',
                    'render': function(d, type, full, meta) {
                        if((full.ubicacion_dos != '' || full.ubicacion_dos != 0 ) && full.estatus != 41 && full.estatus != 42 ){ 
                            return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                        }else{
                            return '';
                        }
                    }
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosNuevasMktd_pre",
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
                order: [
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
            var row = tabla_nuevas.row(tr);
            let c=0;
            $("#modal_colaboradores .modal-body").html("");
            $("#modal_colaboradores .modal-footer").html("");
            $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>¿Desea aprobar los pagos de comisiones para el lote: <b>'+row.data().lote+'</b>?</p> </div></div>');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_pago" name="pago_id" value="'+row.data().id_pago_i+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_lote" name="id_lote" value="'+row.data().idLote+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" id="precio_lote" name="precio_lote" value="'+row.data().precio_lote+'">');
            $("#modal_colaboradores .modal-body").append('<input type="hidden" id="id_comision" name="com_value" value="'+row.data().id_comision+'">');
            $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="Aprobar"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
            $("#modal_colaboradores").modal();
            });

            $("#tabla_nuevas_comisiones tbody").on("click", ".compartir_mktd", function(){
            var lote =  $(this).val();
            $("#modal_mktd .modal-footer").html("");
            $("#modal_mktd .modal-footer").append(`
            <input type="hidden" value="${lote}" id="idlote" name="idlote">
            `);
            $("#modal_mktd .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
            $("#modal_mktd").modal();
            });



            $('#tabla_nuevas_comisiones').on('click', 'input', function() {
                tr = $(this).closest('tr');
                var row = tabla_nuevas.row(tr).data();
                if (row.pa == 0) {

                    row.pa = row.pago_cliente;
                    totaPen += parseFloat(row.pa);
                    tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                } 
                else {
                    totaPen -= parseFloat(row.pa);
                    row.pa = 0;
                }
                document.getElementById("totpagarPen").value = '$' + formatMoney(totaPen);
            });


            /**--------------------------------------------------------- -------------------------------------------------------------------------------------------*/
            $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_asimilados", function() {
                id_pago = $(this).val();
                user = $(this).attr("data-usuario");

                $("#seeInformationModalAsimilados").modal();

                $.getJSON("getComments/" + id_pago + "/" + user).done(function(data) {
                    counter = 0;
                    $.each(data, function(i, v) {
                        counter++;
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
            });
        });

        //FIN TABLA NUEVA

        $(window).resize(function() {
            tabla_nuevas.columns.adjust();
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
        function saveX() {
            save2();
        }

        /**---------------GUARDAR PLAZAS PARA LOTES COMPARTIDOS--------------------*/
        $("#form_mktd").submit( function(e) {
            e.preventDefault();
            var plaza1 = $('#plaza1').val();
            var plaza2=$('#plaza2').val();
            var id_lote=$('#idlote').val();

            if( plaza1 == plaza2){
                alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "warning");
            }
            else{

                $.ajax({
                    type: "POST",
                    url: url2 + "Comisiones/MKTD_compartida",
                    data: {id_lote: id_lote, plaza1: plaza1,plaza2:plaza2},
                    dataType: 'json',
                    success: function(data){
                        if(data == 1){
                            $("#modal_mktd").modal('toggle');
                                tabla_nuevas.ajax.reload();
                                // plaza_1.ajax.reload();
                                alerts.showNotification("top", "right", "Registro agregado con exito.", "success");
                        }else if(data == 3){
                            $("#modal_mktd").modal('toggle');
                            alerts.showNotification("top", "right", "No se puede aplicar el ajuste porque ya se hicieron pagos individuales anteriormente.", "warning");

                        }
                    },error: function( ){
                        alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "danger");
                    }
                });
            }   
        })
        /**-----------------------FIN--------------------------------------------- */


        $("#form_colaboradores").submit( function(e) {
            e.preventDefault();
            var id_pago = $('#id_pago').val();
            var id_comision=$('#id_comision').val();
            var precio_lote=$('#precio_lote').val();
            var id_lote=$('#id_lote').val();
            $.ajax({
                type: "POST",
                url: url2 + "Comisiones/aprobar_comision",
                data: {id_pago: id_pago, id_comision: id_comision, precio_lote: precio_lote, id_lote: id_lote},
                dataType: 'json',
                success: function(data){
                    $("#modal_colaboradores").modal('toggle');
                    tabla_nuevas.ajax.reload();
                    alert("¡Se envío con éxito a Director de MKTD!");
                },error: function( ){
                    alert("ERROR EN EL SISTEMA");
                }
            });
            
        })
    

        /*function cleanComments() {
            var myCommentsList = document.getElementById('comments-list-factura');
            myCommentsList.innerHTML = '';
            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }*/

        /*function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            myCommentsList.innerHTML = '';
        }*/

        /*function fillFields(v) {
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
</body>