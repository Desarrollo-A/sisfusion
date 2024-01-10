<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<body>
    <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>


        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
                                <div id="nameLote"></div>
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
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-history fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Historial general</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="anio">Año</label>
                                                    <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_comisiones_suma" name="tabla_comisiones_suma">
                                                <thead>
                                                    <tr>
                                                        <th>ID PAGO</th>
                                                        <th>REFERENCIA</th>
                                                        <th>NOMBRE</th>
                                                        <th>PUESTO</th>
                                                        <th>FORMA PAGO</th>
                                                        <th>TOTAL COMISIÓN</th>
                                                        <th>% COMISIÓN</th>
                                                        <th>ESTATUS</th>
                                                        <th>MÁS</th>
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
    <?php $this->load->view('template/footer');?>
    <script>
        function tableComisionesSuma(anio){
            $('#tabla_comisiones_suma thead tr:eq(0) th').each( function (i) {
                if( i != 9 ){
                    var title = $(this).text();  
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_suma.column(i).search() !== this.value) {
                            tabla_suma.column(i).search(this.value).draw();
                        }
                    });
                }
            });

            $('#tabla_comisiones_suma').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json, function(i, v) {
                    total += parseFloat(v.total_comision);
                });
                var to = formatMoney(total);
                
            });

            tabla_suma = $("#tabla_comisiones_suma").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES SUMA PAGADAS',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 2){
                                    return 'NOMBRE COMISIONISTA';
                                }else if(columnIdx == 3){
                                    return 'PUESTO';
                                }else if(columnIdx == 4){
                                    return 'FORMA PAGO';
                                }else if(columnIdx == 5){
                                    return 'TOTAL COMISIÓN';
                                }else if(columnIdx == 6){
                                    return '% COMISIÓN';
                                }else if(columnIdx == 7){
                                    return 'ESTATUS';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: `${general_base_url}static/spanishLoader_v2.json`,
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_suma + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.referencia + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.nombre_comisionista + '</b></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.puesto + '</b></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.forma_pago + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.total_comision) + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_comision + '%</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return `<span style="background-color:${d.color_estatus}40; padding: 7px 10px; border-radius: 20px;"><label class="m-0 fs-125"><b style="color:${d.color_estatus}">${d.estatus}</b></label><span>`;
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_suma+'"  data-referencia="'+data.referencia+'" ' +'class="btn-data btn-blueMaderas consultar_history m-auto" title="Detalles">' +'<i class="fas fa-info"></i></button>';

                    }
                }],
                ajax: {
                    url: general_base_url + "Suma/getAllComisiones",
                    type: "POST",
                    data: {anio : anio},
                    dataType: 'json',
                    dataSrc: ""
                },
            });

            $("#tabla_comisiones_suma tbody").on("click", ".consultar_history", function(e){
                console.log("cloc");
                e.preventDefault();
                e.stopImmediatePropagation();
                id_pago = $(this).val();
                referencia = $(this).attr("data-referencia");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").html("");
                $("#comments-list-asimilados").html("");
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
                $.getJSON(general_base_url+"Suma/getHistorial/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
                    });
                });
            });

            $("#tabla_comisiones_suma tbody").on("click", ".consultar_history", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                id_pago = $(this).val();
                referencia = $(this).attr("data-referencia");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").html("");
                $("#comments-list-asimilados").html("");
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DE LA REFERENCIA <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+referencia+'</b></h5></p>');
                $.getJSON(general_base_url+"Suma/getHistorial/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.modificado_por+'</b></p></div>');
                    });
                });
            });
        }
            

        $("#anio").ready( function(){
            let yearBegin = 2019;
            let currentYear = moment().year()
            while( yearBegin <= currentYear ){
                $("#anio").append(`<option value="${yearBegin}">${yearBegin}</option>`);
                yearBegin++;
            }
            $("#anio").val(currentYear);
            $("#anio").selectpicker('refresh');

            tableComisionesSuma(currentYear);
        });

        $("#anio").on("change", function(){
            tableComisionesSuma(this.value);
        })
    </script>
</body>