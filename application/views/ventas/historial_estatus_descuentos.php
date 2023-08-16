<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
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

        <div class="modal fade"
             id="movimiento-modal"
             tabindex="-1"
             role="dialog"
             aria-labelledby="movimientoModal"
             aria-hidden="true"
             data-backdrop="static"
             data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable"
                 role="document">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">Actualizar pago a descuento</h4>
                    </div>

                    <form method="post"
                          class="row"
                          id="estatus-form"
                          autocomplete="off">
                        <div class="modal-body">
                            <div class="col-lg-12">
                                <h5 id="total-pagos">
                                </h5>
                            </div>

                            <div class="col-lg-12"><hr></div>

                            <div class="col-lg-12">
                                <div id="div-options"></div>
                            </div>
                            <input type="hidden" name="tipo_desc" id="tipo_desc">

                            <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <textarea class="form-control"
                                              name="comentario"
                                              id="comentario"
                                              rows="3"
                                              placeholder="Escriba el motivo del descuento..."
                                              required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
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
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Historial <b>general estatus para descuentos</b></h3>
                                    <p class="card-title pl-1">(Listado de todos los pagos por proyecto y estatus)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0" for="proyecto">Proyecto *</label>
                                                    <select name="filtro33" id="filtro33" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona un proyecto" data-size="7" required>
                                                        <option value="0">Seleccione todo</option>
                                                    </select>
                                                    <!-- param -->
                                                    <?php
                                                    if($this->session->userdata('id_rol') == 13 || $this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17){
                                                        ?>
                                                        <input type="hidden" id="param" name="param" value="0"> 
                                                        <?php 
                                                    }
                                                    else{
                                                        ?>
                                                        <input type="hidden" id="param" name="param" value="1">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0" for="filtro44">Estatus *</label>
                                                    <select class="selectpicker select-gral" id="filtro44" name="estatus" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona estatus" data-size="7" required/>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="roles">Puesto</label>
                                                    <select class="selectpicker select-gral"
                                                            name="roles"
                                                            id="roles"
                                                            required>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <label class="m-0"
                                                           for="users">Usuario</label>
                                                    <select class="selectpicker select-gral"
                                                            id="users"
                                                            name="users"
                                                            data-style="btn"
                                                            data-show-subtext="true"
                                                            data-live-search="true"
                                                            title="SELECCIONA UN USUARIO"
                                                            data-size="7"
                                                            required>
                                                    </select>
                                                </div>
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
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>REF.</th>
                                                        <th>PRECIO LOTE</th>
                                                        <th>TOTAL COM.</th>
                                                        <th>PAGO CLIENTE</th>
                                                        <th>DISPERSADO</th>
                                                        <th>PAGADO</th>
                                                        <th>PENDIENTE</th>
                                                        <th>USUARIO</th>
                                                        <th>PUESTO</th>
                                                        <th>DETALLE</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <!-- Modal general -->
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script>
        $(document).ready(function() {
            $("#tabla_historialGral").prop("hidden", true);
            var url = "<?=base_url()?>/index.php/";
            $.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#filtro33").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#filtro33").selectpicker('refresh');
            }, 'json');

            $.get(`${url2}Comisiones/getPuestoByIdOpts`, function (data) {
                const puestos = JSON.parse(data);
                $('#roles').append($('<option>').val('').text('SELECCIONA UN ROL'));
                puestos.forEach(puesto => {
                    const id = puesto.id_opcion;
                    const name = puesto.nombre.toUpperCase();

                    $('#roles').append($('<option>').val(id).text(name));
                });

                $("#roles").selectpicker('refresh');
            });
        });

        $('#filtro33').change(function(ruta){
            $("#filtro44").empty().selectpicker('refresh');

            $.ajax({
                url: '<?=base_url()?>Comisiones/lista_estatus_desc',
                type: 'post',
                dataType: 'json',
                success:function(response){
                    const len = response.length;
                    for(let i = 0; i<len; i++){
                        const id = response[i]['idEstatus'];
                        const name = response[i]['nombre'];
                        $("#filtro44").append($('<option>').val(id).text(name));
                    }
                    $("#filtro44").selectpicker('refresh');
                }
            });
        });

        $('#filtro44').change(function(ruta){
            const proyecto = $('#filtro33').val();
            let status = $('#filtro44').val(); 
            

            if(status === '' || status === null || status === undefined){
                status = 0;
            }

            let usuario = $('#users').val();
            if (usuario === undefined || usuario === null || usuario === '') {
                usuario = 0;
            }

            getAssimilatedCommissions(proyecto, status, usuario);
        });

        $('#roles').change(function () {
            $("#users").empty().selectpicker('refresh');

            $.ajax({
                url: `${url}Comisiones/getUsersName`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const len = data.length;
                    for(let i = 0; i < len; i++){
                        const id = data[i]['id_usuario'];
                        const name = data[i]['name_user'].toUpperCase();
                        $("#users").append($('<option>').val(id).text(name));
                    }

                    $("#users").selectpicker('refresh');

                    const proyecto = $('#filtro33').val();
                    let status = $('#filtro44').val();

                    if (proyecto === undefined || proyecto === null || proyecto === '') {
                        return;
                    }

                    if(status === '' || status === null || status === undefined){
                        status = 0;
                    }

                    let usuario = $('#users').val();
                    if (usuario === undefined || usuario === null || usuario === '') {
                        usuario = 0;
                    }

                    getAssimilatedCommissions(proyecto, status, usuario);
                }
            });
        });

        $('#users').change(function () {
            const proyecto = $('#filtro33').val();
            let status = $('#filtro44').val();

            if(status === '' || status === null || status === undefined){
                status = 0;
            }

            let usuario = $('#users').val();
            if (usuario === undefined || usuario === null || usuario === '') {
                usuario = 0;
            }

            getAssimilatedCommissions(proyecto, status, usuario);
        });

        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        } 

        $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
            let titulos = [];
            if(i != 0){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_historialGral2.column(i).search() !== this.value) {
                        tabla_historialGral2.column(i).search(this.value).draw();

                        var total = 0;
                        var index = tabla_historialGral2.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();
                    }
                });
            }
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

       /* const optNueva = `
            <div class="form-check">
                <input class="form-check-input"
                    type="radio"
                    name="estatus"
                    id="estatus-nueva"
                    value="1"
                    required>
                <label class="form-check-label"
                    for="estatus-nueva">
                Nueva
                </label>
            </div>`;
        const optRevision = `
            <div class="form-check">
                <input class="form-check-input"
                    type="radio"
                    name="estatus"
                    id="estatus-revision"
                    value="4"
                    required>
                <label class="form-check-label"
                    for="estatus-revision">
                Revisión contraloría
                </label>
            </div>`;
        const optPausado = `
            <div class="form-check">
                <input class="form-check-input"
                    type="radio"
                    name="estatus"
                    id="estatus-pausado"
                    value="6"
                    required>
                <label class="form-check-label"
                    for="estatus-pausado">
                Pausado
                </label>
            </div>`;
        const optPagado = `
            <div class="form-check">
                <input class="form-check-input"
                    type="radio"
                    name="estatus"
                    id="estatus-pagado"
                    value="11"
                    required>
                <label class="form-check-label"
                    for="estatus-pagado">
                Pagado
                </label>
            </div>`;*/

        let seleccionados = [];
        //INICIO TABLA QUERETARO*****************************************

        function getAssimilatedCommissions(proyecto, status, usuario){
            let at='';
            let texto='';
            if(status == 3 || status == 4){
                at = ''; 
                texto='REGRESAR DESCUENTOS';
            }else{
                at='';
                texto='DESCUENTOS';
            }
            let titulos = [];
            $("#tabla_historialGral").prop("hidden", false);
            tabla_historialGral2 = $("#tabla_historialGral").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    text: ''+texto+'',
                    action: function() {
                        seleccionados = [];

                        if ($('input[name="idTQ[]"]:checked').length > 0) {
                            const estatus = $('#filtro44').val();
                            const idComisiones = $(tabla_historialGral2.$('input[name="idTQ[]"]:checked'))
                                .map(function () {
                                    return this.value;
                                })
                                .get();
                            seleccionados = idComisiones;
                            const titlePagos = (idComisiones.length > 1)
                                ? `<b>${idComisiones.length}</b> pagos seleccionados`
                                : `<b>${idComisiones.length}</b> pago seleccionado`;
                            $('#total-pagos').html('').html(titlePagos);
                           // $('#div-options').html('').html('<label>Seleccione una opción:</label>'+options);
                            $('#movimiento-modal').modal();
                        }
                    },
                    attr: {
                        class: 'btn btn-azure',
                        style: 'position: relative; float: right;',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'HISTORIAL_GENERAL_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'ID PAGO';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 4){
                                    return 'NOMBRE LOTE';
                                }else if(columnIdx == 5){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 6){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 7){
                                    return 'TOTAL COMISIÓN';
                                }else if(columnIdx == 8){
                                    return 'PAGO CLIENTE';
                                }else if(columnIdx == 9){
                                    return 'DISPERSADO NEODATA';
                                }else if(columnIdx == 10){
                                    return 'PAGADO';
                                }else if(columnIdx == 11){
                                    return 'PENDIENTE';
                                }else if(columnIdx == 12){
                                    return 'COMISIONISTA';
                                }else if(columnIdx == 13){
                                    return 'PUESTO';
                                }else if(columnIdx == 14){
                                    return 'DETALLE';
                                }else if(columnIdx == 15){
                                    return 'ESTATUS ACTUAL';
                                }else if(columnIdx != 16 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
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
                columns: [{
                    "width": "2%",
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        var lblStats;
                        lblStats ='<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                        return lblStats;
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.condominio+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.referencia+'</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class=""m-0>$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p class=""m-0><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p class=""m-0>$'+formatMoney(d.pagado)+'</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        if(d.restante==null||d.restante==''){
                            return '<p class=""m-0>$'+formatMoney(d.comision_total)+'</p>';
                        }else{
                            return '<p class=""m-0>$'+formatMoney(d.restante)+'</p>';
                        }
                    }
                }, 
                {
                    "width": "5%",
                    "data": function( d ){
                        if(d.activo == 0 || d.activo == '0'){
                            return '<p class=""m-0><b>'+d.user_names+'</b></p><p class=""m-0><span class="label" style="background:red;">BAJA</span></p>';
                        }
                        else{
                            return '<p class=""m-0><b>'+d.user_names+'</b></p>';
                        }
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p class=""m-0>'+d.puesto+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        if(d.bonificacion >= 1){
                            p1 = '<p class=""m-0><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class=""m-0><span class="label" style="background:RED;">Recisión de contrato</span></p>';
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
                        var etiqueta;
                            
                        if((d.id_estatus_actual == 11) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p class=""m-0><span class="label" style="background:#ED7D72;">DESCUENTO</span></p>';
                        }else if((d.id_estatus_actual == 12) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p class=""m-0><span class="label" style="background:#EDB172;">DESCUENTO RESGUARDO</span></p>';
                        }else if((d.id_estatus_actual == 0) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p class=""m-0><span class="label" style="background:#ED8172;">DESCUENTO EN PROCESO</span></p>';
                        }else if((d.id_estatus_actual == 16) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p class=""m-0><span class="label" style="background:#ED8172;">DESCUENTO DE PAGO</span></p>';
                        }else if((d.id_estatus_actual == 17) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p class=""m-0><span class="label" style="background:#ED72B9;">DESCUENTO UNIVERSIDAD</span></p>';
                        }else if((d.id_estatus_actual == 18) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#89C86C;">DESCUENTO PRÉSTAMO</span></p>';
                        }else if((d.id_estatus_actual == 19) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#3BC6AC;">DESCUENTO SCIO</span></p>';
                        }else if((d.id_estatus_actual == 20) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#72CBED;">DESCUENTO PLAZA</span></p>';
                        }else if((d.id_estatus_actual == 21) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#7282ED;">DESCUENTO LINEA TELEFÓNICA</span></p>';
                        }else if((d.id_estatus_actual == 22) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#CA72ED;">DESCUENTO MANTENIMIENTO</span></p>';
                        }else if((d.id_estatus_actual == 23) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#CA15ED;">DESCUENTO NÓMINA - ANALISTAS DE COMISIONES</span></p>';
                        }else if((d.id_estatus_actual == 24) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#CA9315;">DESCUENTO NÓMINA - ASISTENTES CDMX</span></p>';
                        }else if((d.id_estatus_actual == 25) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#34A25C;">DESCUENTO NÓMINA - IMSS</span></p>';
                        }else if((d.id_estatus_actual == 26) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#165879;">NÓMINA -LIDER DE PROYECTO E INNOVACIÓN</span></p>';
                        }else if((d.id_estatus_actual == 27) && d.descuento_aplicado == 1 ){
                            etiqueta = '<p><span class="label" style="background:#161179;">DESCUENTO NUEVO PAGO</span></p>';
                        }else{
                            switch(d.id_estatus_actual){
                                case '1':
                                case 1:
                                case '2':
                                case 2:
                                case '12':
                                case 12:
                                case '14':
                                case 14:
                                
                                case '14':
                                case 14:
                                case '51':
                                case 51:
                                case '52':
                                case 52:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#29A2CC;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '3':
                                case 3:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#CC6C29;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '13':
                                case 13:
                                case '4':
                                case 4:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#9129CC;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '5':
                                case 5:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#CC2976;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '6':
                                case 6:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#81BFBE;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '7':
                                case 7:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#28A255;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '8':
                                case 8:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#4D7FA1;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '9':
                                case 9:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#E86606;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '10':
                                case 10:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#E89606;">'+d.estatus_actual+'</span></p>';
                                break;

                                case '11':
                                case 11:

                                if(d.pago_neodata < 1){
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p><p class="m-0"><span class="label" style="background:#5FD482;">IMPORTACIÓN</span></p>';
                                }else{

                                    etiqueta = '<p class="m-0"><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p>';
                                }
                                break;

                                case '88':
                                case 88:
                                    etiqueta = '<p class="m-0"><span class="label" style="background:#A1055A;">'+d.estatus_actual+'</span></p>';
                                break;

                                default:
                                    etiqueta = '';
                                break;
                            }
                        }
                        return etiqueta;
                    }
                },
                { 
                    "width": "2%",
                    "orderable": false,
                    "data": function( data ){
                        var BtnStats;

                        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                
                        return BtnStats;
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    'searchable':true,
                    'className': 'dt-body-center',
                    'render': function (d, type, full) {
                        const estatus = $('#filtro44').val();
                        if ( estatus === '5' || estatus === '6' || estatus === '7') {
                            return '';
                        } else if (estatus === '7' && (full.estatus === '1' || full.estatus === '6')) {
                            return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                        } else if ($('#filtro44').val() === '2') {
                            if (full.forma_pago.toLowerCase() !== 'factura') {
                                return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            } else {
                                return '';
                            }
                        } else {
                            return '<input type="checkbox" name="idTQ[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                        }
                    },
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {
                    url: `${url2}Comisiones/getDatosHistorialPagoEstatus_desc/${proyecto}/${status}/${usuario}`,
                    type: "POST",
                    cache: false,
                    data: function( d ){}
                },
            });

            $("#tabla_historialGral tbody").on("click", ".consultar_logs_asimilados", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAAAAAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            }); 

  
        }

        //FIN TABLA  **********************************************

        $('#estatus-form').on('submit', function (e) {
            e.preventDefault();

            const estatusId = $('#filtro44').val();
            let tipo_desc = 0;
            let comentario = $('#comentario').val();
            if (estatusId == 1) {
                tipo_desc = 27;
            } else if (estatusId == 2) {
                tipo_desc = 16;
            } else if (estatusId == 3) {
                tipo_desc = 1;
            } else if (estatusId == 4) {
                tipo_desc = 4;
            } 

            let formData = new FormData();
            formData.append('idPagos', seleccionados);
            formData.append('estatus', tipo_desc);
            formData.append('comentario', comentario);

            $.ajax({
                type: 'POST',
                url: 'cambiarEstatusPagosDescuentos',
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function (response) {
                    if (JSON.parse(response)) {
                        $('#movimiento-modal').modal('hide');
                        alerts.showNotification("top", "right", "Datos actualizados correctamente", "success");

                       /* appendBodyModal(`
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h3 style='color:#676767;'>Se cambiaron los estatus de los pagos seleccionados</h3>
                                    <img style='width: 200px; height: 200px;'
                                        src='<?= base_url('dist/img/check.gif')?>'>
                                </div>
                            </div>
                        `);
                        showModal();*/
                        tabla_historialGral2.ajax.reload();
                    } else {
                        $('#movimiento-modal').modal('hide');
                        appendBodyModal(`
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h3>Error al enviar comisiones</h3>
                                    <img style='width: 200px; height: 200px;'
                                                src='<?= base_url('dist/img/error.gif')?>'>
                                    <br>
                                    <p style="font-size: 16px">No se pudo ejecutar esta acción, intentalo más tarde.</p>
                                <div>
                            </div>
                        `);
                        showModal();
                    }
                },
                error: function() {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $('#movimiento-modal').on('hidden.bs.modal', function() {
            $('#estatus-form').trigger('reset');
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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
</body>