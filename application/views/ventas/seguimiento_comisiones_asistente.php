<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade"
         id="seeInformationModalAsimilados"
         tabindex="-1"
         role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true"
         data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable"
             role="document">
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
                    <button type="button" class="btn btn-danger btn-simple"
                            data-dismiss="modal" onclick="cleanCommentsAsimilados()">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-dollar fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Seguimiento <b>comisiones por gerencia</b></h3>
                            </div>

                            <div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="m-0"
                                                       for="puestos">Puesto*</label>
                                                <select class="selectpicker select-gral"
                                                        name="puestos"
                                                        id="puestos"
                                                        required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="m-0"
                                                       for="usuarios">Usuarios*</label>
                                                <select class="selectpicker select-gral"
                                                        name="usuarios"
                                                        id="usuarios"
                                                        required>
                                                    <option value="0">Selecciona una opción</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="m-0"
                                                       for="proyectos">Proyecto</label>
                                                <select class="selectpicker select-gral"
                                                        name="proyectos"
                                                        id="proyectos">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label class="m-0"
                                                       for="estatus">Estatus</label>
                                                <select class="selectpicker select-gral"
                                                        name="estatus"
                                                        id="estatus">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="div-tabla"
                                 class="material-datatables">
                                <div class="table-responsive">
                                    <table class="table-striped table-hover"
                                           id="tabla-historial">
                                        <thead>
                                            <tr>
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

<?php $this->load->view('template/footer');?>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>
    const url = '<?=base_url()?>'
    let tablaComisiones;

    $(document).ready(function () {
        $("#div-tabla").prop("hidden", true);

        $.ajax({
            url: `${url}Comisiones/getPuestoComisionesAsistentes`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#puestos').append($('<option>').val(0).text('Selecciona una opción'));

                for (let i = 0; i < data.length; i++) {
                    const id = data[i].id_opcion;
                    const nombre = data[i].nombre;
                    $('#puestos').append($('<option>').val(id).text(nombre));
                }

                $('#puestos').selectpicker('refresh');
            }
        });

        $.ajax({
            url: `${url}Comisiones/findAllResidenciales`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#proyectos').append($('<option>').val(0).text('Selecciona una opción'));

                for (let i = 0; i < data.length; i++) {
                    const id = data[i].idResidencial;
                    const nombre = data[i].descripcion;
                    $('#proyectos').append($('<option>').val(id).text(nombre));
                }

                $('#proyectos').selectpicker('refresh');
            }
        });

        $.ajax({
            url: `${url}Comisiones/getEstatusComisionesAsistentes`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#estatus').append($('<option>').val(0).text('Selecciona una opción'));

                for (let i = 0; i < data.length; i++) {
                    if (data[i].idEstatus !== 6) {
                        const id = data[i].idEstatus;
                        const nombre = data[i].nombre;
                        $('#estatus').append($('<option>').val(id).text(nombre));
                    }
                }

                $('#estatus').selectpicker('refresh');
            }
        });
    });

    $('#puestos').on('change', function () {
        const puesto = $(this).val();
        $('#usuarios').empty()
            .append($('<option>').val(0).text('Selecciona una opción'))
            .selectpicker('refresh');
        $("#div-tabla").prop("hidden", true);

        if (puesto !== '0') {
            $.ajax({
                url: `${url}Comisiones/findUsuariosByPuestoAsistente/${puesto}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {

                    for (let i = 0; i < data.length; i++) {
                        const id = data[i].id_usuario;
                        const nombre = data[i].nombre_completo;
                        $('#usuarios').append($('<option>').val(id).text(nombre));
                    }

                    $('#usuarios').selectpicker('refresh');
                }
            });
        }
    });

    $('#usuarios').on('change', function () {
        const idUsuario = $(this).val();
        const idProyecto = $('#proyectos').val();
        const idEstatus = $('#estatus').val();

        if (idUsuario !== '0') {
            loadTable(idUsuario, idProyecto, idEstatus);
        } else {
            $("#div-tabla").prop("hidden", true);
        }
    });

    $('#proyectos').on('change', function () {
        const idProyecto = $(this).val();
        const idUsuario = $('#usuarios').val();
        const idEstatus = $('#estatus').val();

        if (idUsuario !== '0') {
            loadTable(idUsuario, idProyecto, idEstatus);
        }
    });

    $('#estatus').on('change', function () {
        const idEstatus = $(this).val();
        const idUsuario = $('#usuarios').val();
        const idProyecto = $('#proyectos').val();

        if (idUsuario !== '0') {
            loadTable(idUsuario, idProyecto, idEstatus);
        }
    });

    $('#tabla-historial thead tr:eq(0) th').each( function (i) {
        const title = $(this).text();
        if (i !== 15){
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $('input', this).on('keyup change', function () {
                if ($('#tabla-historial').DataTable().column(i).search() !== this.value ) {
                    $('#tabla-historial').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    function loadTable(idUsuario, idProyecto, idEstatus) {
        $("#div-tabla").prop("hidden", false);

        tablaComisiones = $('#tabla-historial').DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'HISTORIAL_GENERAL_COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                        format: {
                            header:  function (d, columnIdx) {
                                if (columnIdx === 0) {
                                    return 'ID PAGO';
                                } else if (columnIdx === 1) {
                                    return 'PROYECTO';
                                } else if (columnIdx === 2) {
                                    return 'CONDOMINIO';
                                } else if(columnIdx === 3) {
                                    return 'NOMBRE LOTE';
                                } else if(columnIdx === 4) {
                                    return 'REFERENCIA';
                                } else if(columnIdx === 5) {
                                    return 'PRECIO LOTE';
                                } else if(columnIdx === 6) {
                                    return 'TOTAL COMISIÓN';
                                } else if(columnIdx === 7) {
                                    return 'PAGO CLIENTE';
                                } else if(columnIdx === 8) {
                                    return 'DISPERSADO NEODATA';
                                } else if(columnIdx === 9) {
                                    return 'PAGADO';
                                } else if(columnIdx === 10) {
                                    return 'PENDIENTE';
                                } else if(columnIdx === 11) {
                                    return 'COMISIONISTA';
                                } else if(columnIdx === 12) {
                                    return 'PUESTO';
                                } else if(columnIdx === 13) {
                                    return 'DETALLE';
                                } else if(columnIdx === 14) {
                                    return 'ESTATUS ACTUAL';
                                } else if(columnIdx !== 15 && columnIdx !== 0) {
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: `${url}static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [
                {
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.id_pago_i+'</b></p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.proyecto+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.condominio+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.referencia+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.precio_lote)+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.comision_total)+' </p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.pago_cliente)+'</b></p>';
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.pagado)+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        if(d.restante === null || d.restante === ''){
                            return '<p class="m-0">$'+formatMoney(d.comision_total)+'</p>';
                        }
                        else{
                            return '<p class="m-0">$'+formatMoney(d.restante)+'</p>';
                        }
                    }
                },
                {
                    "data": function( d ){
                        if(d.activo === 0 || d.activo === '0'){
                            return '<p class="m-0"><b>'+d.user_names+'</b></p><p><span class="label" style="background:red;">BAJA</span></p>';
                        }
                        else{
                            return '<p class="m-0"><b>'+d.user_names+'</b></p>';
                        }
                    }
                },
                {
                    "data": function( d ){
                        return '<p class="m-0">'+d.puesto+'</p>';
                    }
                },
                {
                    "data": function( d ){
                        if (d.bonificacion >= 1) {
                            p1 = '<p class="m-0"><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                        } else {
                            p1 = '';
                        }

                        if(d.lugar_prospeccion === 0){
                            p2 = '<p class="m-0"><span class="label" style="background:RED;">Recisión de contrato</span></p>';
                        } else {
                            p2 = '';
                        }

                        return p1 + p2;
                    }
                },
                {
                    "data": function( d ){
                        var etiqueta;

                        if((d.id_estatus_actual === 11) && d.descuento_aplicado === 1 ){
                            etiqueta = '<p><span class="label" style="background:#ED7D72;">DESCUENTO</span></p>';
                        }else if((d.id_estatus_actual === 12) && d.descuento_aplicado === 1 ){
                            etiqueta = '<p><span class="label" style="background:#EDB172;">DESCUENTO RESGUARDO</span></p>';
                        }else if((d.id_estatus_actual === 0) && d.descuento_aplicado === 1 ){
                            etiqueta = '<p><span class="label" style="background:#ED8172;">DESCUENTO EN PROCESO</span></p>';
                        }else if((d.id_estatus_actual === 16) && d.descuento_aplicado === 1 ){
                            etiqueta = '<p><span class="label" style="background:#ED8172;">DESCUENTO DE PAGO</span></p>';
                        }else if((d.id_estatus_actual === 17) && d.descuento_aplicado === 1 ){
                            etiqueta = '<p><span class="label" style="background:#ED72B9;">DESCUENTO UNIVERSIDAD</span></p>';
                        }else{

                            switch(d.id_estatus_actual){
                                case '1':
                                case 1:
                                case '2':
                                case 2:
                                case '12':
                                case 12:
                                case '13':
                                case 13:
                                case '14':
                                case 14:
                                case '51':
                                case 51:
                                case '52':
                                case 52:
                                    etiqueta = '<p><span class="label" style="background:#29A2CC;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '3':
                                case 3:
                                    etiqueta = '<p><span class="label" style="background:#CC6C29;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '4':
                                case 4:
                                    etiqueta = '<p><span class="label" style="background:#9129CC;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '5':
                                case 5:
                                    etiqueta = '<p><span class="label" style="background:#CC2976;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '6':
                                case 6:
                                    etiqueta = '<p><span class="label" style="background:#81BFBE;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '7':
                                case 7:
                                    etiqueta = '<p><span class="label" style="background:#28A255;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '8':
                                case 8:
                                    etiqueta = '<p><span class="label" style="background:#4D7FA1;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '9':
                                case 9:
                                    etiqueta = '<p><span class="label" style="background:#E86606;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '10':
                                case 10:
                                    etiqueta = '<p><span class="label" style="background:#E89606;">'+d.estatus_actual+'</span></p>';
                                    break;

                                case '11':
                                case 11:

                                    if(d.pago_neodata < 1){
                                        etiqueta = '<p><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p><p><span class="label" style="background:#5FD482;">IMPORTACIÓN</span></p>';
                                    }else{

                                        etiqueta = '<p><span class="label" style="background:#05A134;">'+d.estatus_actual+'</span></p>';
                                    }
                                    break;

                                case '88':
                                case 88:
                                    etiqueta = '<p><span class="label" style="background:#A1055A;">'+d.estatus_actual+'</span></p>';
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
                    "data": function( data ){
                        return `
                            <div class="d-flex justify-center">
                                <button href="#"
                                        value="${data.id_pago_i}"
                                        data-value="${data.nombreLote}"
                                        data-code="${data.cbbtton}"
                                        class="btn-data btn-blueMaderas consultar_logs_asimilados"
                                        title="Detalles">
                                        <i class="fas fa-info"></i>
                                </button>
                            </div>`;
                    }
                }
            ],
            columnDefs: [
                {
                    orderable: false,
                    className: 'select-checkbox dt-body-center',
                    targets:   0,
                    'searchable':false,
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }
            ],
            ajax: {
                "url": `${url}Comisiones/getUsuariosByComisionesAsistentes/${idUsuario}/${idProyecto}/${idEstatus}`,
                "type": "GET",
                "cache": false,
                "data": function( d ) {}
            },
            order: [[ 1, 'asc' ]]
        });

        $("#tabla-historial tbody").on("click", ".consultar_logs_asimilados", function(e){
            e.preventDefault();
            e.stopImmediatePropagation();

            const id_pago = $(this).val();
            const lote = $(this).attr("data-value");

            $.getJSON("getComments/"+id_pago).done( function( data ){
                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');

                $.each( data, function(i, v){
                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                });
            });
        });
    }

    function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';
    }

    function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = (d === undefined) ? "." : d,
            t = (t === undefined) ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) +
            (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
</script>