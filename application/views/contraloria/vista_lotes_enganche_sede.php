<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?> 
        
        <!--Contenido de la página-->
        <div class="modal fade" id="modal_aprobar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title="><center>¿Qué quieres modificar?</center></h4>
                    </div>
                    <form id="form_modificacion" name="form_modificacion" method="post">
                        <input type="text" class="hide" id="idLote" name="idLote">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <select id="modificacion" class="selectpicker" data-style="btn btn-round" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" multiple>
                                            <option value="Enganche">Enganche</option>
                                            <option value="Ubicacion">Ubicación</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-12">
                                        <div id="enganche" style="display:none">
                                            <label class="control-label label-gral">Enganche</label>
                                            <input type="text" id="enganches" name="enganches" class="form-control input-gral" style="text-align:center" value="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-12">
                                        <div id="ubicacion" style="display:none">
                                            <label class="control-label label-gral">Ubicación</label>
                                            <select id="ubicacion_sede" name="ubicacion_sede" class="selectpicker select-gral m-0" data-style="btn btn-round" style="text-align:center"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
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
                                    <h3 class="card-title center-align">Actualización de lotes apartados</h3>
                                </div>
                                <p class="card-title center-align">En esta vista podrás hacer la actualización del enganche y ubicación de un lote apartado.</p>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">PROYECTO</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un proyecto"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">CONDOMINIO</label>
                                                    <select name="condominio" id="condominio"  class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un condominio"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">LOTE</label>
                                                    <select name="lote" id="lote" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un lote"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="table-responsive">
                                        <table id="tabla_historial" name="tabla_historial"
                                                class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                                <tr>
                                                    <th>LOTE</th>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>TOTAL</th>
                                                    <th>ENGANCHE</th>
                                                    <th>UBICACIÓN</th>
                                                    <th>ESTATUS LOTE</th>
                                                    <th>ESTATUS CONTRATACIÓN</th>
                                                    <th>ACCIONES</th>
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
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">reorder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title center-align">Historial</h4>
                                <div class="row col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="proyecto">Proyecto: </label>
                                            <select name="proyecto" id="proyecto" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>SELECCIONA UN PROYECTO</option></select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="condominio">Condominio: </label>
                                            <select name="condominio" id="condominio" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>SELECCIONA UN CONDOMINIO</option></select>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="lote">Lote: </label>
                                            <select name="lote" id="lote" class="selectpicker" data-style="btn"data-show-subtext="true" data-live-search="true"  title="" data-size="7" required><option disabled selected>SELECCIONA UN LOTE</option></select>
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
                            <div class="card-content" style="padding: 50px 20px;">
                                <h4 class="card-title"></h4>
                                <div class="toolbar">
                                
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">

                                            <table class="table table-responsive table-bordered table-striped table-hover"
                                                    id="tabla_historial" name="tabla_historial">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: .9em;">LOTE</th>
                                                        <th style="font-size: .9em;">ID LOTE</th>
                                                        <th style="font-size: .9em;">CLIENTE</th>
                                                        <th style="font-size: .9em;">FECHA APARTADO</th>
                                                        <th style="font-size: .9em;">ASESOR</th>
                                                        <th style="font-size: .9em;">COORDINADOR</th>
                                                        <th style="font-size: .9em;">GERENTE</th>
                                                        <th style="font-size: .9em;">TOTAL</th>
                                                        <th style="font-size: .9em;">ENGANCHE</th>
                                                        <th style="font-size: .9em;">UBICACIÓN</th>
                                                        <th style="font-size: .9em;">ESTATUS LOTE</th>
                                                        <th style="font-size: .9em;">ESTATUS CONTRATACIÓN</th>
                                                        <th style="font-size: .9em;">ACCIONES</th>
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

    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php";
    var urlimg = "<?=base_url()?>img/";

    $('#tabla_historial thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_historial').DataTable().column(i).search() !== this.value ) {
                $('#tabla_historial').DataTable().column(i).search(this.value).draw();
            }
        });
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
                $("#condominio").append($('<option disabled selected>SELECCIONA UN CONDOMINIO</option>'));
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
            $.post(url + "Contraloria/lista_lote_apartado/"+index_condominio, function(data) {
                var len = data.length;
                $("#lote").append($('<option disabled selected>SELECCIONA UN LOTE</option>'));
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
        tabla_expediente = $("#tabla_historial").DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            destroy: true,
            "buttons": [
                
            ],
            "ajax":
                {
                    "url": '<?=base_url()?>index.php/Contraloria/get_lote_historial/'+index_lote,
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
                    {'data': function (d) {
                            return d.idLote
                        } 
                    },
                    {data: 'cliente'},
                    {data: 'fechaApartado'},
                    {data: 'asesor'},
                    {data: 'coordinador'},
                    {data: 'gerente'},
                    {data: 'saldo'},
                    {data: 'enganche'},
                    {data: 'nombre_ubicacion'},
                    {data: 'lote'},
                    {data: 'contratacion'},
                    {
                        "data": function(d){
                            opciones = `<center><button id="modificar" data-idLote=${d.idLote} class="btn-data btn-orangeYellow" data-toggle="tooltip" data-placement="top" title="Modificar"><i class="far fa-edit"></i></button></center>`;
                            return opciones;
                        }
                    }
                ]
        });
    });

    $(document).on('click', '#modificar', function () {
        var data = tabla_expediente.row($(this).parents('tr')).data();
        getLoteApartado(data.idLote);
        $('#idLote').val(data.idLote);
        $("#modal_aprobar").modal();
    });

    function getLoteApartado(idLote){
        $.get('get_lote_apartado',{
            idLote:idLote
        }, function(data) {
            $('#enganches').val(data.enganche);
            $("#ubicacion_sede").append($('<option selected disabled>').val(data.id_sede).text(data.nombre_ubicacion.toUpperCase()));
            $("#ubicacion_sede").selectpicker('refresh');
        }, 'json');   
    }

    $(document).on('change', '#modificacion', function () {
        $('#enganche').hide();
        $('#ubicacion').hide();
        const valores = $(this).val();
        valores.forEach(str => {
            if(str === 'Enganche'){
                $('#enganche').show();
            }
            if(str === 'Ubicacion'){
                $('#ubicacion').show();
            }
        });
    });
    
    $(document).on("submit", "#form_modificacion", function (e) {
        e.preventDefault();
        let idLote = $("#idLote").val();
        let data = new FormData($(this)[0]);
        data.append('enganche', $('#enganches').val() == '' ? null : $('#enganches').val());
        data.append('ubicacion', $('#ubicacion_sede').val() == '' ? null : $('#ubicacion_sede').val());
        data.append("idLote", idLote);
        
        $.ajax({
            url: "updateLoteEngancheSede",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                $("#modal_aprobar").modal("hide");
                $('#tabla_historial').DataTable().ajax.reload();
            }
        });
    });

    $(document).ready(function(){
        $("#ubicacion_sede").empty().selectpicker('refresh');
        $.post(url + "Contraloria/lista_sedes", function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_sede'];
                var name = data[i]['nombre'];
                $("#ubicacion_sede").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#ubicacion_sede").selectpicker('refresh');
        }, 'json');
    });

    $("#enganches").on({
        "focus": function (event) {
            $(event.target).select();
        },
        "keyup": function (event) {
            $(event.target).val(function (index, value ) {
                return value.replace(/\D/g, "")
                            .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
            });
        }
    });

</script>