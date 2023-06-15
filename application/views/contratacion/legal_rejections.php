<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <!--Contenido de la página-->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Rechazos jurídico</h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="Jtabla" name="Jtabla">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>TIPO</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>GERENTE</th>
                                                        <th>CLIENTE</th>
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
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script>
        var idlote_global = 0;
        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var getInfo1 = new Array(7);
        var getInfo2 = new Array(7);
        var getInfo3 = new Array(7);
        var getInfo4 = new Array(7);
        var getInfo5 = new Array(7);
        var getInfo6 = new Array(7);


        $("#Jtabla").ready( function(){

            $('#Jtabla thead tr:eq(0) th').each( function (i) {
                if(i != 0){
                    var title = $(this).text();
                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if (tabla_6.column(i).search() !== this.value ) {
                            tabla_6
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    } );
                }
            });


            let titulos = [];
            $('#Jtabla thead tr:eq(0) th').each( function (i) {
                if( i!=0 && i!=13){
                    var title = $(this).text();
                    titulos.push(title);
                }
            });

            tabla_6 = $("#Jtabla").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [1,2,3,4,5,6],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'TIPO';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 4){
                                    return 'LOTE';
                                }else if(columnIdx == 5){
                                    return 'GERENTE';
                                }else if(columnIdx == 6){
                                    return 'CLIENTE';
                                }
                            }
                        }
                    }
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
                    "width": "3%",
                    "className": 'details-control',
                    "orderable": false,
                    "data" : null,
                    "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
                },
                {

                    "data": function( d ){
                        var lblStats = '<span class="label label-danger">Rechazo</span>';
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreResidencial+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';

                    }
                },
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.gerente+'</p>';
                    }
                },
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
                    }
                }],
                columnDefs: [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                ajax: {
                    "url": '<?=base_url()?>index.php/Asistente_gerente/getLegalRejections',
                    "dataSrc": "",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },
                "order": [[ 1, 'asc' ]]
            });

            $('#Jtabla tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_6.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                } 
                else {
                    var status = 'RECHAZO (JURÍDICO)';
                    var fechaVenc = 'VENCIDO';

                    var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información adicional</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>'+status+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>'+ row.data().comentario +'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha vencimiento: </b>' + fechaVenc + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha realizado: </b>' + row.data().modificado + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>'+row.data().coordinador+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>'+row.data().asesor+'</label></div></div></div>';
                    row.child(informacion_adicional).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                }
            });
        });
    </script>
</body>