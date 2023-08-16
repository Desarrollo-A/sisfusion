<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- modals -->
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

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?= base_url() ?>static/images/cob_mktd.gif" width="150" height="150"></center>
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_precio" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                    </div>
                    <form method="post" id="form_precio">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationMarketing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsData()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: orange;">
                                <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsData()"><b>Cerrar</b></button>
                    </div>
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
                                <i class="fas fa-chart-bar fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Reporte mktd</h3>
                                    <p class="card-title pl-1">(Listado de lotes con apartado en MKTD)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="proyecto">Mes</label>
                                                <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona mes" data-size="7" required>
                                                    <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            $monthNum  = $i;
                                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                            $monthName = strftime('%B', $dateObj->getTimestamp());

                                                            echo '<option value="' . $i . '">' . $monthName . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label>Año</label>
                                                <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                    <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 2019; $i <= 2022; $i++) {
                                                            $yearName  = $i;
                                                            echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>PROY.</th>
                                                        <th>COND.</th>
                                                        <th>LOTE</th>
                                                        <th>$ LOTE</th>
                                                        <th>F. APARTADO</th>
                                                        <th>MES</th>
                                                        <th>CLIENTE</th>
                                                        <th>PLAZA</th>
                                                        <th>ASESOR</th>
                                                        <th>GERENTE</th>
                                                        <th>ESTATUS</th>
                                                        <th>EVIDENCIA</th>
                                                        <th>COMISION</th>
                                                        <th>ABONADO</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>ESTADO COM.</th>
                                                        <th>LUGAR PROSPECCIÓN</th>
                                                        <th>ACCIÓN</th>
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
            <?php $this->load->view('template/footer_legend'); ?>
        </div>
    </div>
    </div><!--main-panel close-->

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
        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";


        function cleanCommentsData() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            myCommentsList.innerHTML = '';
        }

        $('#tabla_historialGral thead tr:eq(0) th').each(function(i) {
            var title = $(this).text();

            if ( i != 0 && i != 20) {

                $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function() {
                    if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value) {
                        $('#tabla_historialGral').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });
        
        $('#mes').change(function(ruta) {
            anio = $('#anio').val();
            mes = $('#mes').val();
            if(anio == ''){
                anio=0;
            }else{
                getAssimilatedCommissions(mes, anio);
            }
        });

        $('#anio').change(function(ruta) {
            mes = $('#mes').val();
            if(mes == ''){
                mes=0;
            }
            anio = $('#anio').val();
            if (anio == '' || anio == null || anio == undefined) {
                anio = 0;
            }
            getAssimilatedCommissions(mes, anio);
        });



        var url = "<?= base_url() ?>";
        var url2 = "<?= base_url() ?>index.php/";
        var totalLeon = 0;
        var totalQro = 0;
        var totalSlp = 0;
        var totalMerida = 0;
        var totalCdmx = 0;
        var totalCancun = 0;
        var tr;
        var tabla_historialGral2;
        var totaPen = 0;
        //INICIO TABLA QUERETARO****************************************************************************************

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

        $('#tabla_historialGral thead tr:eq(0) th').each(function(i) {
            if ( i != 0 && i != 20) {
                var title = $(this).text();
                titulos.push(title);

                $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function() {

                    if (tabla_historialGral2.column(i).search() !== this.value) {
                        tabla_historialGral2
                            .column(i)
                            .search(this.value)
                            .draw();

                        var total = 0;
                        var index = tabla_historialGral2.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                        var data = tabla_historialGral2.rows(index).data();

                        $.each(data, function(i, v) {
                            total += parseFloat(v.monto_vendido);
                        });


                        var to1 = formatMoney(total);
                        document.getElementById("myText_nuevas").value = formatMoney(total);
                    }
                });
            }
        });


        function getAssimilatedCommissions(mes, anio) {
            let titulos = [];
            $("#tabla_historialGral").prop("hidden", false);
            tabla_historialGral2 = $("#tabla_historialGral").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COBRANZA APARTADOS',

                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,15,16,17,18, 19],
                        format: {
                            header: function(d, columnIdx) {
                                if (columnIdx == 0) {
                                    return '';
                                } else if (columnIdx == 1) {
                                    return 'ID LOTE';
                                } else if (columnIdx == 2) {
                                    return 'PROYECTO';
                                } else if (columnIdx == 3) {
                                    return 'CONDOMINIO';
                                } else if (columnIdx == 4) {
                                    return 'NOMBRE LOTE';
                                } else if (columnIdx == 5) {
                                    return 'PRECIO LOTE';
                                } else if (columnIdx == 6) {
                                    return 'FECHA APARTADO';
                                } else if (columnIdx == 7) {
                                    return 'MES';
                                } else if (columnIdx == 8) {
                                    return 'CLIENTE';
                                } else if (columnIdx == 9) {
                                    return 'PLAZA';
                                } else if (columnIdx == 10) {
                                    return 'GERENTE';
                                } else if (columnIdx == 11) {
                                    return 'ASESOR';
                                } else if (columnIdx == 12) {
                                    return 'ESTATUS';
                                } else if (columnIdx == 13) {
                                    return 'EVIDENCIA';
                                } else if (columnIdx == 14) {
                                    return 'COMISION TOTAL';
                                } else if (columnIdx == 15) {
                                    return 'ABONADO';
                                } else if (columnIdx == 16) {
                                    return 'PAGADO';
                                } else if (columnIdx == 17) {
                                    return 'PENDIENTE';
                                } else if (columnIdx == 18) {
                                    return 'ESTATUS COMISION';
                                } else if (columnIdx == 19) {
                                    return 'LUGAR PROSPECCIÓN';
                                } else if (columnIdx != 20 && columnIdx != 0) {
                                    return ' ' + titulos[columnIdx - 1] + ' ';
                                }
                            }
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
                columns: [
                {
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        var lblStats;
                        lblStats = '<p class="m-0"><b>' + d.idLote + '</b></p>';
                        return lblStats;
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.condominio + '</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.nombreLote + '</b></p>';
                    }
                },

                {
                    "width": "5%",
                    "data": function(d) {
                        let precio = 0;
                        if(d.totalNeto2 < 1 && d.precio == null){
                            if(d.totalNeto == '0.00' || d.totalNeto == null)
                                return '<span style="color: #960034">' + d.total_sindesc + '</span>';
                            else
                                return '<span style="font-weight: 700">$' + formatMoney(d.totalNeto2) + '</span>';
                        }else if(d.totalNeto2 > 1 && d.precio == null){
                            precio = d.totalNeto2;
                            return '<p class="m-0">$' + formatMoney(precio) + '</p>';
                        }else if(d.totalNeto2 < 1 && d.precio != null){
                            precio = d.precio;
                            return '<p class="m-0">$' + formatMoney(precio) + '</p>';
                        }else if(d.totalNeto2 > 1 && d.precio > 0){
                            precio = d.totalNeto2;
                            return '<p class="m-0">$' + formatMoney(precio) + '</p>';
                        }
                        
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.fechaApartado + ' </p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.mes + '</b></p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.cliente + '</p>';
                    }
                },
                {
                    "width": "5",
                    "data": function(d) {
                        return '<p class="m-0">' + d.plaza + '</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.asesor + '</p>';
                    }
                }, {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.gerente + '</p>';
                    }
                },

                {
                    "width": "5%",
                    "data": function(d) {
                        let compar ='';
                        if(d.idc_mktd != null)
                        {
                            compar = '<span class="label label-info">COMPARTIDA</span><br>'+'<p><b>' +d.sd1+' / '+d.sd2+ '</b></p>';
                        }
                        if (d.status == 0 || d.status == '0'){
                            return '<p class="m-0" style="color:crimson;"><b>CANCELADO</b></p><center>'+compar+'<center>';
                        }
                        else{
                            return '<p class="m-0"><b>' + (d.estatus).toUpperCase() + '</b></p><center>'+compar+'<center>';
                        }
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.evidencia + '</p>';
                    }
                },

                {
                    "width": "5%",
                    "data": function(d) {
                        if(d.idStatusContratacion>8){
                            return '<p class="m-0">$' +formatMoney(d.comision_total) + '</p>';
                        }
                        else{
                            return '<p class="m-0"> - </p>';
                        }
                        
                    
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {

                        if(d.idStatusContratacion>8){
                            return '<p class="m-0">$' + formatMoney(d.abono_dispersado) + '</p>';
                        }
                        else{
                            return '<p class="m-0"> - </p>';
                        }

                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if(d.idStatusContratacion>8){
                            return '<p class="m-0">$' + formatMoney(d.abono_pagado) + '</p>';
                        }
                        else{ 
                            return '<p class="m-0"> - </p>';
                        }
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if(d.idStatusContratacion>8){
                            return '<p class="m-0">$' + formatMoney(d.comision_total-d.abono_pagado) + '</p>';
                        }
                        else{
                            return '<p class="m-0"> - </p>';
                        }

                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {

                        $label = '';


                        if(d.idStatusContratacion>8){
                            
                        switch(d.bandera){
                            case 7:
                            case '7':
                            $label = '<p><b>LIQUIDADA</b></p>';
                            break;

                            case 1:
                            case 55:
                            case '1':
                            case '55':
                            case 0:
                            case '0':
                            $label = '<p style="color: green;"><b>ACTIVA</b></p>';
                            break;

                            default:
                            $label = '<p style="color: dodgerblue;"><b>SIN DISPERSAR</b></p>';
                            break;
                        }
                    }
                        else{
                            $label = '<p style="color: orange;"><b>NA</b></p>';
                        }
                        return $label;
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        if (d.descuento_mdb == 1) 
                            return d.lugar_prospeccion + ' Martha Debayle';
                        else
                            return d.lugar_prospeccion;
                    }
                },
                {
                    "width": "10%",
                    "orderable": false,
                    "data": function(d) {
                        var BtnStats;
                        let BtnPrecio = '';
                        let BtnStatsCOM = '';
                        if(d.idc_mktd == null){
                            BtnStatsCOM =  '<button class="btn-data btn-violetChin compartir_mktd" title="COMPARTIR" value="' + d.idLote +'"><i class="material-icons">group_add</i></button>';
                        }
                        if (d.status == 0){
                            BtnStats = '<button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '"  data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-blueMaderas bitacora_reporte_marketing" title="Ver detalles">' + '<i class="fas fa-file-alt"></i></button>';
                        }
                        else{
                            BtnStats = '<button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '"  data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-orangeYellow bitacora_reporte_marketing" title="Ver detalles">' + '<i class="fas fa-file-alt"></i> <button href="#" value="' + d.idLote + '" data-value="' + d.id_cliente + '" data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-blueMaderas add_reporte_marketing" title="Añadir mas detalles">' + '<i class="fas fa-pencil-alt"></i></button>';
                            if (d.idStatusContratacion >= 1 && d.idStatusContratacion <= 8) {
                                BtnPrecio = '<button href="#" value="' + d.idLote + '" data-value="' + d.precio + '"  data-code="' + d.nombreLote + '" ' + 'class="btn-data btn-sky reporte_marketing" title="Agregar precio">' + '<i class="fas fa-dollar-sign"></i></button>';
                            }
                        }
                        return '<div class="d-flex justify-center">'+BtnStats + BtnPrecio + BtnStatsCOM+'</div>';
                    }
                }],
                columnDefs: [
                {
                "searchable": false,
                "orderable": false,
                "targets": 0
                }],
                "ajax": {
                    "url": "<?=base_url()?>index.php/Comisiones/getDatosCobranzaReporte/" + mes + "/" + anio,
                    "dataSrc": "",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                    },
                "order": [
                    [1, 'asc']
                ]
            });

            $("#tabla_historialGral tbody").on("click", ".bitacora_reporte_marketing", function() {
                lote = $(this).val();
                cliente = $(this).attr("data-value");
                $("#seeInformationMarketing").modal();
                $.getJSON("getDataMarketing/" + lote + "/" + cliente).done(function(data) {
                    $.each(data, function(i, v) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;"><b>COMENTARIO: </b><i style="color:gray;">' + v.comentario + '</i></p><p style="color:gray;"><b>FECHA PROSPECCIÓN: </b><i style="color:gray;">' + v.fecha_prospecion_mktd + '</i></p><p style="color:gray;"><b>CREADO POR: </b> ' + v.nombre + '<p><b style="color:#896597">' + v.fecha_creacion + '</b></p><hr></div>');
                    });
                });
            });

 
            $("#tabla_historialGral tbody").on("click", ".add_reporte_marketing", function() {
                var tr = $(this).closest('tr');
                var row = tabla_historialGral2.row(tr);

                lote = $(this).val();
                cliente = $(this).attr("data-value");

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-footer").html("");

                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Añadir comentarios a <b>' + row.data().nombreLote + '</b><input type="hidden" name="lote" id="lote" value="' + lote + '"><input type="hidden" name="cliente" id="cliente" value="' + cliente + '">');

                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12"><div class="form-group"><label class="label">Fecha prospección</label><input class="form-control" type="date" id="fecha" name="fecha" value=""></div></div></div>');

                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12"><div class="form-group"><label class="label">Comentarios adicionales</label><textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea></div></div></div>');

                $("#modal_nuevas .modal-footer").append('<div class="row"><div class="col-md-12"><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></div>');
                $("#modal_nuevas").modal();
            });

            $("#tabla_historialGral tbody").on("click", ".reporte_marketing", function() {
                lote = $(this).val();
                precio = $(this).attr("data-value");
                nombre = $(this).attr("data-code");

                $("#modal_precio .modal-header").html("");
                $("#modal_precio .modal-body").html("");
                $("#modal_precio .modal-footer").html("");

                $("#modal_precio .modal-header").append(`<div class="row">
                    <div class="col-md-12">
                    <center><h6>Cambiar precio al lote <b>${nombre}</b></h6></center>
                    </div>
                    </div>`);

                $("#modal_precio .modal-body").append(`<div class="row"><div class="col-md-12"><div class="form-group"><label class="label">Precio</label><input class="form-control" type="number" id="precioL" name="precioL" value="${formatMoney(precio)}"><input type="hidden" value="${lote}" readonly name="idLote" id="idLote"></div></div></div>`);

                $("#modal_precio .modal-footer").append('<div class="row"><div class="col-md-12"><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></div>');
                $("#modal_precio").modal();
            });


            $("#tabla_historialGral tbody").on("click", ".compartir_mktd", function(){
                var lote =  $(this).val();
                
                $("#modal_mktd .modal-footer").html("");
                $("#modal_mktd .modal-footer").append(`<input type="hidden" value="${lote}" id="idlote" name="idlote">`);
                $("#modal_mktd .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="GUARDAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
                $("#modal_mktd").modal();
            });

            $("#form_mktd").submit( function(e) {
                e.preventDefault();
                var plaza1 = $('#plaza1').val();
                var plaza2=$('#plaza2').val();
                var idLote=$('#idlote').val();

                if( plaza1 == plaza2){
                    alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "warning");
                }
                else{
                    $.ajax({
                        type: "POST",
                        url: url2 + "Comisiones/MKTD_compartida",
                        data: {idLote: idLote, plaza1: plaza1,plaza2:plaza2},
                        dataType: 'json',
                        success: function(data){
                            if(data == 1){
                                $("#modal_mktd").modal('toggle');
                                    tabla_historialGral2.ajax.reload();
                                    alerts.showNotification("top", "right", "Registro agregado con exito.", "success");
                            }
                            else if(data == 3){
                                $("#modal_mktd").modal('toggle');
                                tabla_historialGral2.ajax.reload();
                                alerts.showNotification("top", "right", "No se puede aplicar el ajuste porque ya se hicieron pagos individuales anteriormente.", "warning");
                            }
                        },error: function( ){
                            alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "danger");
                        }
                    });
                }
            })

            $("#form_aplicar").submit(function(e) {
                e.preventDefault();
            }).validate({
                submitHandler: function(form) {
                    var data = new FormData($(form)[0]);
                    console.log(data);
                    $.ajax({
                        url: url + 'Comisiones/agregar_comentarios',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data) {
                            if (true) {
                                $("#modal_nuevas").modal('toggle');
                                alerts.showNotification("top", "right", "Se guardó tu información correctamente", "success");
                                setTimeout(function() {
                                    tabla_historialGral2.ajax.reload();
                                    // tabla_otras2.ajax.reload();
                                }, 3000);
                            } else {
                                alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                            }
                        },
                        error: function() {
                            alert("ERROR EN EL SISTEMA");
                        }
                    });
                }
            });

            function replaceAll( text, busca, reemplaza ){
                while (text.toString().indexOf(busca) != -1)
                    text = text.toString().replace(busca,reemplaza);
                return text;
            }

            $("#form_precio").submit(function(e) {
                e.preventDefault();
            }).validate({
                submitHandler: function(form) {
                    let precioformato = $('#precioL').val();
                    let precio = replaceAll(precioformato,',','');
                    if(!isNaN(precio)){
                        var data = new FormData($(form)[0]);
                        console.log(data);
                        $.ajax({
                            url: url + 'Comisiones/SavePrecioLoteMKTD',
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            method: 'POST',
                            type: 'POST', // For jQuery < 1.9
                            success: function(data) {
                                if (1) {
                                    $("#modal_precio").modal('toggle');
                                    alerts.showNotification("top", "right", "Precio del lote actualizado", "success");
                                    setTimeout(function() {
                                        tabla_historialGral2.ajax.reload();
                                        // tabla_otras2.ajax.reload();
                                    }, 100);
                                } else {
                                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                                }
                            },
                            error: function() {
                                alert("ERROR EN EL SISTEMA");
                            }
                        });
                    }
                    else{
                        alerts.showNotification("top", "right", "Número invalido", "danger");
        
                    }
                }
            });
        }

        //FIN TABLA  ****************************************************************************************

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $(window).resize(function() {
            tabla_historialGral2.columns.adjust();
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

        /*$(document).on("click", ".btn-historial-lo", function() {
            window.open(url + "Comisiones/getHistorialEmpresa", "_blank");
        });*/

        /*function cleanComments(){
            var myCommentsList = document.getElementById('documents');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }*/
    </script>


    <script>
        $(document).ready(function() {
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
        });
    </script>
</body>