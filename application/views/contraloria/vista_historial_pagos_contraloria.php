<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>
    
    <!--Contenido de la página-->
    <div class="modal fade modal-alertas" id="modal_" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Subir archivo de expediente.</h4>
                </div>
                <form method="post" id="form_interes">
                    <div class="modal-body">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-receipt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Historial de pagos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">PROYECTO</label>
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona gerente"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">CONDOMINIO</label>
                                                <select name="condominio" id="condominio"  class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona gerente"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">LOTE</label>
                                                <select name="lote" id="lote" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona gerente"
                                                        data-size="7" data-live-search="true" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="tabla_historialpagos_contraloria" name="tabla_historialpagos_contraloria"
                                           class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th>LOTE</th>
                                                <th>CLIENTE</th>
                                                <th>NO. RECIBO</th>
                                                <th>MONTO</th>
                                                <th>CONCEPTO</th>
                                                <th>FORMA PAGO</th>
                                                <th>FECHA</th>
                                                <th>USUARIO</th>
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



    <div class="content hide">
        <div class="container-fluid">

            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <center>
                        <!--						<h4>HISTORIAL DE PAGOS</h4>-->
                    </center>
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Historial de pagos</h4>
                            <div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <div class="row">

                                    <div class="col-md-4 form-group">
                                        <label for="proyecto">Proyecto: </label>
                                        <select name="proyecto" id="proyecto" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA PROYECTO -</option></select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="condominio">Condominio: </label>
                                        <select name="condominio" id="condominio" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA CONDOMINIO -</option></select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="lote">Lote: </label>
                                        <select name="lote" id="lote" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>- SELECCIONA LOTE -</option></select>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <!--						<div class="card-header card-header-icon" data-background-color="goldMaderas">-->
                        <!--							<i class="material-icons">reorder</i>-->
                        <!--						</div>-->
                        <div class="card-content" style="padding: 50px 20px;">
                            <h4 class="card-title"></h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">

                                        <table class="table table-responsive table-bordered table-striped table-hover"
                                               id="tabla_historialpagos_contraloria" name="tabla_historialpagos_contraloria">
                                            <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th style="font-size: .9em;">LOTE</th>
                                                <th style="font-size: .9em;">CLIENTE</th>
                                                <th style="font-size: .9em;">NO. RECIBO</th>
                                                <th style="font-size: .9em;">MONTO</th>
                                                <th style="font-size: .9em;">CONCEPTO</th>
                                                <th style="font-size: .9em;">FORMA PAGO</th>
                                                <th style="font-size: .9em;">FECHA</th>
                                                <th style="font-size: .9em;">USUARIO</th>
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

    var url = "<?=base_url()?>";/*http://localhost:9081/sisfusion/*/
    var url2 = "<?=base_url()?>index.php";/*http://localhost:9081/sisfusion/index.php/*/
    var urlimg = "<?=base_url()?>img/";/*http://localhost:9081/sisfusion/img/*/

    $('#tabla_historialpagos_contraloria thead tr:eq(0) th').each( function (i) {
        // if(i!=9){
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_historialpagos_contraloria').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_historialpagos_contraloria').DataTable().column(i).search(this.value).draw();
                }
            });
        // }

    });

    $(document).ready(function(){
        $.post(url + "Contraloria/lista_proyecto", function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['idResidencial'];
                var name = data[i]['descripcion'];
                $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#proyecto").selectpicker('refresh');
        }, 'json');
    });

    $('#proyecto').change( function() {
        index_proyecto = $(this).val();
        $("#condominio").html("");
        $(document).ready(function(){
            $.post(url + "Contraloria/lista_condominio/"+index_proyecto, function(data) {
                var len = data.length;
                $("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));
                for( var i = 0; i<len; i++)
                {
                    var id = data[i]['idCondominio'];
                    var name = data[i]['nombre'];
                    $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#condominio").selectpicker('refresh');
            }, 'json');
        });

    });


    $('#condominio').change( function() {
        index_condominio = $(this).val();
        $("#lote").html("");
        $(document).ready(function(){
            $.post(url + "Contraloria/lista_lote/"+index_condominio, function(data) {
                var len = data.length;
                $("#lote").append($('<option disabled selected>- SELECCIONA LOTE -</option>'));
                for( var i = 0; i<len; i++)
                {
                    var id = data[i]['idLote'];
                    var name = data[i]['nombreLote'];
                    $("#lote").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#lote").selectpicker('refresh');
            }, 'json');

        });

    });

    $('#lote').change( function() {
        index_lote = $(this).val();

        // $('#tabla_historialpagos_contraloria').DataTable({
        tabla_expediente = $("#tabla_historialpagos_contraloria").DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            destroy: true,
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Historial pagos',
                    title:"Historial pagos",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Historial pagos',
                    title: "Historial pagos",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            "ajax":
                {
                    "url": '<?=base_url()?>index.php/Contraloria/get_lote_historial_pagos/'+index_lote,
                    "dataSrc": ""
                },
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            "ordering": false,
            "searching": true,
            "paging": true,

            "bAutoWidth": false,
            "bLengthChange": false,
            "scrollX": true,
            "bInfo": true,
            "fixedColumns": true,

            "columns":
                [
                    {data: 'nombreLote'},
                    {
                        data: null,
                        render: function (data, type, row)
                        {
                            return data.nombre + ' ' + data.apellido_paterno + ' ' + data.apellido_materno;
                        },
                    },
                    {data: 'noRecibo'},
                    {
                        data: null,
                        render: function(data, type, row)
                        {
                            return "$" + myFunctions.number_format(data.engancheCliente, '2', '.', ',');
                        }
                    },
                    {data: 'concepto'},
                    {data: 'tipo'},
                    {data: 'fechaEnganche'},
                    {
                        data: 'usuario'
                    }

                ]

        });



    });




    $(window).resize(function(){
        tabla_expediente.columns.adjust();
    });



</script>

