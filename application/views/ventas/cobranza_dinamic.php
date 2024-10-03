<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-bar fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div class="row">
                                        <h3 class="card-title center-align" >Reporte dinámico</h3>
                                        <p class="card-title pl-1">(Concentrado de lotes con apartado por fecha, gerencias y plazas)</p>
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Total vendido</h4>
                                                    <p class="input-tot pl-1" id="myText_vendido">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Año (<span class="isRequired">*</span>)</label>
                                                    <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Mes(<span class="isRequired">*</span>)</label>
                                                    <select name="mes" id="mes" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body"  required></select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label">Plaza</label>
                                                    <select name="plaza" id="plaza" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="control-label">Gerente</label>
                                                    <select name="gerente" id="gerente" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover hide" id="tableDinamicMKTD" name="tableDinamicMKTD">
                                            <thead>
                                                <tr>
                                                    <th>LOTES VENDIDOS</th>
                                                    <th>MONTO VENDIDO</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>SUBDIRECTOR</th>
                                                    <th>DIRECTOR REGIONAL</th>
                                                    <th>MES DE APARTADO</th>
                                                    <th>PLAZA</th>
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
            <?php $this->load->view('template/footer_legend');?>
        </div>
        <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/cobranzaDinamic.js"></script>

    <script>
        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            myCommentsList.innerHTML = '';
        }

        $('#tableDinamicMKTD thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                if(i != 0 && i != 8){

                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if ($('#tableDinamicMKTD').DataTable().column(i).search() !== this.value ) {
                        $('#tableDinamicMKTD').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        $('#mes').change( function(){
            mes = $('#mes').val();
            anio = $('#anio').val();
            if(anio == ''){
            }else{
                getAssimilatedCommissions(mes, anio, 0, 0);
            }
        });
        
        $(document).ready(function(){
            $('#anio').html("");
            $('#plaza').html("");
            $('#gerente').html("");
            var d = new Date();
            var n = d.getFullYear();
            for (var i = n; i >= 2020; i--){
                var id = i;
                $("#anio").append($('<option>').val(id).text(id));
            }
            $("#anio").selectpicker('refresh');
            $("#plaza").selectpicker('refresh');
            $("#gerente").selectpicker('refresh');
        });


        $('#anio').change( function(){
            $("#plaza").html("");
            $("#gerente").html("");

            mes = $('#mes').val();
            if(mes == '')
            {
                mes =0;
            }
            anio = $('#anio').val();

            $(document).ready(function(){
                $.post(url + "Comisiones/listSedes", function(data) {
                    var len = data.length;
                    $("#plaza").append($('<option disabled selected>Selecciona una opción</option>'));
                    for( var i = 0; i<len; i++){
                        var id = data[i]['id_sede'];
                        var name = data[i]['nombre'];
                        $("#plaza").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#plaza").selectpicker('refresh');
                    $("#gerente").selectpicker('refresh');
                }, 'json');
            });
            getAssimilatedCommissions(mes, anio, 0, 0);
        });

        $('#plaza').change( function(){
            $("#gerente").html("");
            mes = $('#mes').val();
            anio = $('#anio').val();
            plaza = $('#plaza').val();
            if(mes == '')
            {
                mes =0;
            }
            $(document).ready(function(){
                $.post(url + "Comisiones/listGerentes/"+plaza, function(data) {
                    var len = data.length;
                    $("#gerente").append($('<option disabled selected>Selecciona una opción</option>'));
                    for( var i = 0; i<len; i++)
                    {
                        var id = data[i]['id_usuario'];
                        var name = data[i]['nombreUser'];
                        $("#gerente").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#gerente").selectpicker('refresh');
                }, 'json');
            });
            getAssimilatedCommissions(mes, anio, plaza, 0);
        });

        $('#gerente').change( function(){
            mes = $('#mes').val();
            anio = $('#anio').val();
            plaza = $('#plaza').val();
            gerente = $('#gerente').val();
            if(mes == '')
            {
                mes =0;
            }
            getAssimilatedCommissions(mes, anio, plaza, gerente);
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
        var tableDinamicMKTD2 ;
        var totaPen = 0;
        //INICIO TABLA QUERETARO****************

        $('#tableDinamicMKTD thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if ($('#tableDinamicMKTD').DataTable().column(i).search() !== this.value) {
                    $('#tableDinamicMKTD').DataTable().column(i).search(this.value).draw();

                    var total = 0;
                    var index = tableDinamicMKTD2.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();

                    var data = tableDinamicMKTD2.rows(index).data();
                    $.each(data, function(i, v) {
                        total += parseFloat(v.monto_vendido);
                    });
                    document.getElementById("myText_vendido").textContent = '$'+formatMoney(total);
                }        
            });
            
            titulos.push(title);    
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        });

        function getAssimilatedCommissions(mes, anio, plaza, gerente){
            let titulos = [];
            $('#tableDinamicMKTD').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.monto_vendido);
                });
                var to = formatMoney(total);
                document.getElementById("myText_vendido").textContent = '$'+to;
            });

            $("#tableDinamicMKTD").prop("hidden", false);
            tableDinamicMKTD2 = $("#tableDinamicMKTD").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'DINAMIC COBRANZA APARTADOS',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'LOTES VENDIDOS';
                                }else if(columnIdx == 2){
                                    return 'MONTO VENDIDO';
                                }else if(columnIdx == 3){
                                    return 'ASESOR';
                                }else if(columnIdx == 4){
                                    return 'GERENTE';
                                }else if(columnIdx == 5){
                                    return 'MES APARTADO';
                                }else if(columnIdx == 6){
                                    return 'PLAZA VENTA';
                                }else if(columnIdx == 7){
                                    return 'ESTATUS VENTA';
                                }else if(columnIdx != 8 && columnIdx !=0){
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
                    "width": "5%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">play_circle_filled</i>'
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0" style="color: crimson;">'+d.lotes_vendidos+'</p>';
                        else
                            return '<p class="m-0">'+d.lotes_vendidos+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0" style="color:crimson;">$'+formatMoney(d.monto_vendido)+'</p>';
                        else
                            return '<p class="m-0">$'+formatMoney(d.monto_vendido)+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0" style="color:crimson;">'+d.asesor+'</p>';
                        else
                            return '<p class="m-0">'+d.asesor+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0" style="color:crimson;">'+d.gerente+'</p>';
                        else
                            return '<p class="m-0">'+d.gerente+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0" style="color:crimson;">'+($('select[name="mes"] option:selected').text()).toUpperCase()+'</p>';
                        else
                            return '<p class="m-0">'+($('select[name="mes"] option:selected').text()).toUpperCase()+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0" style="color:crimson;">'+(d.nombre).toUpperCase()+' </p>';
                        else 
                            return '<p class="m-0">'+(d.nombre).toUpperCase()+' </p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        if(d.status == 0)
                            return '<p class="m-0"><span class="label" style="background: crimson;">CANCELADO</span></p>';
                        else
                            return '<p class="m-0"><span class="label" style="background: steelblue;">ACTIVO</span></p>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    'searchable':false,
                    'className': 'dt-body-center',
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosCobranzaDimamic/" + mes + "/" + anio+ "/" + plaza+ "/" + gerente,
                    "type": "POST",
                    cache: false,
                    "data": function( d ){}
                },
                order: [[ 1, 'asc' ]]
            });


            $('#tableDinamicMKTD').on('click', 'input', function() {
                tr = $(this).closest('tr');
                var row = tableDinamicMKTD2.row(tr).data();

                if (row.pa == 0) {
                    row.pa = row.monto_vendido;
                    totaPen += parseFloat(row.pa);
                    tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                } else{
                    totaPen -= parseFloat(row.pa);
                    row.pa = 0;
                }
                $("#totpagarPen").html(formatMoney(totaPen));
            });

        }
        //FIN TABLA  ****************************************************************************************

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $(window).resize(function(){
            tableDinamicMKTD2.columns.adjust();
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
    </script>
</body>