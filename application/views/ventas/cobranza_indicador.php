<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?=base_url()?>static/images/cob_mktd.gif" width="150" height="150"></center>
                    </div>
                    <form method="post" id="form_aplicar">
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
                                    <h3 class="card-title center-align" >Reporte indicador mktd</h3>
                                    <p class="card-title pl-1">(Listado de ventas por plaza MKTD)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label className="m-0" for="proyecto">Mes</label>
                                                <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona mes" data-size="7" required>
                                                    <?php
                                                    setlocale(LC_ALL, 'es_ES');
                                                    for ($i=1; $i<=12; $i++) {
                                                        $monthNum  = $i;
                                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                        $monthName = strftime('%B', $dateObj->getTimestamp());
                                                        echo '<option value="'.$i.'">'.$monthName.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group">
                                                <label className="m-0">Año</label>
                                                <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona año" data-size="7" required>
                                                    <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i=2019; $i<=2022; $i++) {
                                                            $yearName  = $i;
                                                            echo '<option value="'.$i.'">'.$yearName.'</option>';
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
                                                        <th>PLAZA</th>
                                                        <th>MONTO</th>
                                                        <th># LOTES</th>
                                                        <th>ESTATUS</th>
                                                        <th>MES</th>
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
    </div><!--main-panel close-->

    <?php $this->load->view('template/footer');?>
    <script>

        function cleanCommentsData() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            myCommentsList.innerHTML = '';
        }

        $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                if(i != 0 && i != 14){

                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#tabla_historialGral').DataTable().column(i).search() !== this.value ) {
                        $('#tabla_historialGral').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            }
        });


        $('#mes').change(function(ruta){
            mes = $('#mes').val();
            anio = $('#anio').val();
            if(anio == '' || anio == null || anio == undefined){
                alert("Selecciona un año");
            }
            else{
                getAssimilatedCommissions(mes, anio);
            }
        });



        $('#anio').change(function(ruta){
            mes = $('#mes').val();
            anio = $('#anio').val();
            if(mes == '' || mes == null || mes == undefined){
            alert("Selecciona un mes");
            }
            else{
                getAssimilatedCommissions(mes, anio);
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

    //INICIO TABLA QUERETARO****************************************************************************************


        $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
            if(i != 0 && i != 12){
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


        function getAssimilatedCommissions(mes, anio){
            let titulos = [];
            $("#tabla_historialGral").prop("hidden", false);
            tabla_historialGral2 = $("#tabla_historialGral").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COBRANZA APARTADOS',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 1){
                                    return 'ID LOTE';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 4){
                                    return 'NOMBRE LOTE';
                                }else if(columnIdx == 5){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 6){
                                    return 'FECHA APARTADO';
                                }else if(columnIdx == 7){
                                    return 'MES';
                                }else if(columnIdx == 8){
                                    return 'CLIENTE';
                                }else if(columnIdx == 9){
                                    return 'PLAZA';
                                }else if(columnIdx == 10){
                                    return 'GERENTE';
                                }else if(columnIdx == 11){
                                    return 'ASESOR';
                                }else if(columnIdx == 12){
                                    return 'ESTATUS';
                                }else if(columnIdx == 13){
                                    return 'EVIDENCIA';
                                }else if(columnIdx != 14 && columnIdx !=0){
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
                columns: [
                {
                    "width": "2%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
                },
                {
                    "width": "6%",
                    "data": function( d ){
                    var lblStats;
                    lblStats ='<p class="m-0">'+d.nombre+'</p>';
                    return lblStats;
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p class="m-0">$'+formatMoney(d.monto_vendido)+'</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    return '<p class="m-0">'+d.lotes_vendidos+'</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    if(d.status == 0)
                        return '<p class="m-0" style="color: crimson;"><b>CANCELADO</b></p>';
                    else
                        return '<p class="m-0">VENDIDO</p>';
                }
            },
            {
                "width": "7%",
                "data": function( d ){
                    if(d.status == 0)
                        return '<p class="m-0" style="color: crimson;"><b>'+($('select[name="mes"] option:selected').text()).toUpperCase()+'</b></p>';
                    else
                        return '<p class="m-0">'+($('select[name="mes"] option:selected').text()).toUpperCase()+'</p>';
                }
            }],

            columnDefs: [{
                orderable: false,
                targets:   0,
                'searchable':false,
                'className': 'dt-body-center',
            }],
            ajax: {
                "url": url2 + "Comisiones/getDatosCobranzaIndicador/"+ mes +"/"+ anio,
                "type": "POST",
                cache: false,
                "data": function( d ){}
            },
            order: [[ 1, 'asc' ]]
        });


        $("#tabla_historialGral tbody").on("click", ".bitacora_reporte_marketing", function(){
            lote = $(this).val();
            cliente = $(this).attr("data-value");

            // $("#seeInformationMarketing").html('');

            $("#seeInformationMarketing").modal();
            $.getJSON("getDataMarketing/"+lote+"/"+cliente).done( function( data ){
                $.each( data, function(i, v){
                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;"><b>COMENTARIO: </b><i style="color:gray;">'+v.comentario+'</i></p><p style="color:gray;"><b>FECHA PROSPECCIÓN: </b><i style="color:gray;">'+v.fecha_prospecion_mktd+'</i></p><p style="color:gray;"><b>CREADO POR: </b> '+v.nombre+'<p><b style="color:#896597">'+v.fecha_creacion+'</b></p><hr></div>');
                });
            });
        });

        $('#tabla_historialGral').on('click', 'input', function() {
            tr = $(this).closest('tr');
            var row = tabla_historialGral2.row(tr).data();

            if (row.pa == 0) {
                row.pa = row.pago_cliente;
                totaPen += parseFloat(row.pa);
                tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
            } else{
                totaPen -= parseFloat(row.pa);
                row.pa = 0;
            }

            $("#totpagarPen").html(formatMoney(totaPen));
        });

        $("#tabla_historialGral tbody").on("click", ".add_reporte_marketing", function(){
            var tr = $(this).closest('tr');
            var row = tabla_historialGral2.row( tr );

            lote = $(this).val();
            cliente = $(this).attr("data-value");
            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-footer").html("");

            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p>Añadir comentarios a <b>'+row.data().nombreLote+'</b><input type="hidden" name="lote" id="lote" value="'+lote+'"><input type="hidden" name="cliente" id="cliente" value="'+cliente+'">');

            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12"><div class="form-group"><label class="label">Fecha prospección</label><input class="form-control" type="date" id="fecha" name="fecha" value=""></div></div></div>');

            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12"><div class="form-group"><label class="label">Comentarios adicionales</label><textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea></div></div></div>');

            $("#modal_nuevas .modal-footer").append('<div class="row"><div class="col-md-12"><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></div>');
            $("#modal_nuevas").modal();
        });

        $("#form_aplicar").submit( function(e) {
            e.preventDefault();
            }).validate({
                submitHandler: function( form ) {
                    var data = new FormData( $(form)[0] );
                    console.log(data);
                    $.ajax({
                        // url: url + "Comisiones/pausar_solicitud/",
                        url: url+'Comisiones/agregar_comentarios',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data){
                            if( true ){
                                $("#modal_nuevas").modal('toggle' );
                                alerts.showNotification("top", "right", "Se guardó tu información correctamente", "success");
                                setTimeout(function() {
                                    tabla_historialGral2.ajax.reload();
                                    // tabla_otras2.ajax.reload();
                                }, 3000);
                            }else{
                                alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                            }
                        },error: function( ){
                            alert("ERROR EN EL SISTEMA");
                        }
                    });
                }
            });
        }

    //FIN TABLA *****************************************************************

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $(window).resize(function(){
            tabla_historialGral2.columns.adjust();
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

        $(document).on("click", ".btn-historial-lo", function(){
            window.open(url+"Comisiones/getHistorialEmpresa", "_blank");
        });

        function cleanComments(){
            var myCommentsList = document.getElementById('documents');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }
    </script>
</body>