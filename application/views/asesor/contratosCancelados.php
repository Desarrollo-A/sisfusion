<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar');  ?>


    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-times fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Contratos cancelados</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row hide">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="table_contratos_cancelados" name="table_contratos_cancelados"
                                           class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                        <tr>
                                            <th>RESIDENCIAL</th>
                                            <th>CONDOMINIO</th>
                                            <th>NOMBRE LOTE</th>
                                            <th>ID LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>FECHA APARTADO</th>
                                            <th>ESTATUS ACTUAL</th>
                                            <th>DESCRIPCIÓN</th>
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
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script type="text/javascript">


    var aut;

    let titulos = [];
    // $('#table_contratos_cancelados thead tr:eq(0) th').each( function (i) {
    //     if( i!=0 && i!=13){
    //         var title = $(this).text();
    //
    //         titulos.push(title);
    //     }
    // });

    $("#table_contratos_cancelados").ready( function(){

        tabla_valores_cc = $("#table_contratos_cancelados").DataTable({
            width: 'auto',
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Tus ventas',
                    title:"Tus ventas",
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'RESIDENCIAL';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'NOMBRE LOTE';
                                    case 3:
                                        return 'ID LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'FECHA APARTADO';
                                        break;
                                    case 6:
                                        return 'ESTATUS ACTUAL';
                                        break;
                                    case 7:
                                        return 'DESCRIPCIÓN';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            "ordering": false,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            "order": [[4, "desc"]],
            columns: [
                { "data": "nombreResidencial" },
                { "data": "nombreCondominio" },
                { "data": "nombreLote" },
                { "data": "idLote" },
                { "data": "nombreCliente" },
                { "data": "fechaApartado" },
                { "data": "estatusActual" },
                { "data": "descripcion" },
            ],
            "ajax": {
                "url": "<?=base_url()?>index.php/Asesor/getlotesRechazados",
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            },
        });

        $(document).on('click', '.abrir_prospectos', function () {
            $('#nom_cliente').html('');
            $('#id_cliente_asignar').val(0);
            var $itself = $(this);
            console.log($itself.attr('data-idCliente'));
            var id_cliente = $itself.attr('data-idCliente');
            var nombre_cliente = $itself.attr('data-nomCliente');
            /*asignar_prospecto_a_cliente
            nom_cliente*/
            $('#nom_cliente').append(nombre_cliente);
            $('#id_cliente_asignar').val(id_cliente);
            /*table_prospectos*/

            tabla_valores_ds = $("#table_prospectos").DataTable({
                width: 'auto',
                "dom": "Bfrtip",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Prospectos',
                        title:"Prospectos",
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                        className: 'btn buttons-pdf',
                        titleAttr: 'Prospectos',
                        title:"Prospectos",
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                    }
                ],
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                    orderable: false
                }],
                "pageLength": 10,
                "bAutoWidth": false,
                "fixedColumns": true,
                "ordering": false,
                "destroy": true,
                "language": {
                    /*"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"*/
                    "url": "<?=base_url()?>/static/spanishLoader.json"
                },
                "order": [[4, "desc"]],
                columns: [
                    {
                        "data": function(d){
                            return d.nombre + ' ' + d.apellido_paterno + ' ' + d.apellido_materno;
                        }
                    },
                    {
                        "data": function(d){
                            return myFunctions.validateEmptyField(d.correo);
                        }
                    },
                    {
                        "data": function(d){
                            return d.telefono;
                        }
                    },
                    {
                        "data": function(d){
                            var info = '';
                            info = '<b>Observación:</b> '+myFunctions.validateEmptyField(d.observaciones)+'<br>';
                            info += '<b>Lugar prospección:</b> '+d.lugar_prospeccion+'<br>';
                            info += '<b>Plaza venta:</b> '+d.plaza_venta+'<br>';
                            info += '<b>Nacionalidad:</b> '+d.nacionalidad+'<br>';


                            return info;
                        }
                    },
                    {
                        "data": function(d){
                            return '<center><button class="btn-data btn-green became_prospect_to_cliente"' +
                                'data-id_prospecto="'+d.id_prospecto+'" data-id_cliente="'+id_cliente+'">' +
                                '<i class="fas fa-user-check"></i></button></center>';
                        }
                    },
                ],

                "ajax": {
                    "url": "<?=base_url()?>index.php/Asesor/get_info_prospectos/",
                    "dataSrc": "",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                },

            });

            $('#asignar_prospecto_a_cliente').modal();

        });
        $('#table_prospectos thead tr:eq(0) th').each( function (i) {

            //  if(i != 0 && i != 11){
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 300;" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#table_prospectos').DataTable().column(i).search() !== this.value ) {
                    $('#table_prospectos').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            } );
            //}
        });
        $(document).on('click', '.became_prospect_to_cliente', function() {
            var $itself = $(this);
            var id_cliente = $itself.attr('data-id_cliente');
            var id_prospecto = $itself.attr('data-id_prospecto');
            /*console.log(id_cliente);
            console.log(id_prospecto);*/
            $('#modal_pregunta').modal();

            $(document).on('click', '#asignar_prospecto', function () {
                //ajax con el post de update prospecto a cliente
                $.ajax({
                    type: 'POST',
                    url: '<?=base_url()?>index.php/asesor/prospecto_a_cliente',
                    data: {'id_prospecto':id_prospecto,'id_cliente':id_cliente},
                    dataType: 'json',
                    beforeSend: function(){
                        $('#modal_loader_assign').modal();

                    },
                    success: function(data) {
                        console.log(data);
                        if (data.cliente_update == 'OK' && data.prospecto_update=='OK') {
                            $('#modal_loader_assign').modal("hide");
                            $('#asignar_prospecto_a_cliente').modal('hide');
                            $('#table_prospectos').DataTable().ajax.reload();
                            $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                            alerts.showNotification('top', 'right', 'Se ha asignado correctamente', 'success');

                        } else {
                            alerts.showNotification('top', 'right', 'Ha ocurrido un error inesperado verificalo ['+data+']', 'danger');
                        }
                    },
                    error: function(){
                        $('#modal_loader_assign').modal("hide");
                        $('#asignar_prospecto_a_cliente').modal('hide');
                        $('#table_prospectos').DataTable().ajax.reload();
                        $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                        alerts.showNotification('top', 'right', 'OCURRIO UN ERROR, INTENTALO DE NUEVO', 'danger');
                    }
                });
            });
        });




        $(document).on('click', '.pdfLink2', function () {
            var $itself = $(this);
            Shadowbox.open({
                content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
                player:     "html",
                title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
                width:      1600,
                height:     900
            });
        });

        $(document).on('click', '.pdfLink22', function () {
            var $itself = $(this);
            Shadowbox.open({
                content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
                player:     "html",
                title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
                width:      1600,
                height:     900
            });
        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2", function(e){
            e.preventDefault();

            getInfo2A[0] = $(this).attr("data-idCliente");
            getInfo2A[1] = $(this).attr("data-nombreResidencial");
            getInfo2A[2] = $(this).attr("data-nombreCondominio");
            getInfo2A[3] = $(this).attr("data-idCondominio");
            getInfo2A[4] = $(this).attr("data-nombreLote");
            getInfo2A[5] = $(this).attr("data-idLote");
            getInfo2A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);


            $('#modal1').modal('show');

        });



        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_2", function(e){
            e.preventDefault();

            getInfo2_2A[0] = $(this).attr("data-idCliente");
            getInfo2_2A[1] = $(this).attr("data-nombreResidencial");
            getInfo2_2A[2] = $(this).attr("data-nombreCondominio");
            getInfo2_2A[3] = $(this).attr("data-idCondominio");
            getInfo2_2A[4] = $(this).attr("data-nombreLote");
            getInfo2_2A[5] = $(this).attr("data-idLote");
            getInfo2_2A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal2').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo5", function(e){
            e.preventDefault();

            getInfo5A[0] = $(this).attr("data-idCliente");
            getInfo5A[1] = $(this).attr("data-nombreResidencial");
            getInfo5A[2] = $(this).attr("data-nombreCondominio");
            getInfo5A[3] = $(this).attr("data-idCondominio");
            getInfo5A[4] = $(this).attr("data-nombreLote");
            getInfo5A[5] = $(this).attr("data-idLote");
            getInfo5A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal3').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo6", function(e){
            e.preventDefault();

            getInfo6A[0] = $(this).attr("data-idCliente");
            getInfo6A[1] = $(this).attr("data-nombreResidencial");
            getInfo6A[2] = $(this).attr("data-nombreCondominio");
            getInfo6A[3] = $(this).attr("data-idCondominio");
            getInfo6A[4] = $(this).attr("data-nombreLote");
            getInfo6A[5] = $(this).attr("data-idLote");
            getInfo6A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);


            $('#modal4').modal('show');

        });



        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_3", function(e){
            e.preventDefault();

            getInfo2_3A[0] = $(this).attr("data-idCliente");
            getInfo2_3A[1] = $(this).attr("data-nombreResidencial");
            getInfo2_3A[2] = $(this).attr("data-nombreCondominio");
            getInfo2_3A[3] = $(this).attr("data-idCondominio");
            getInfo2_3A[4] = $(this).attr("data-nombreLote");
            getInfo2_3A[5] = $(this).attr("data-idLote");
            getInfo2_3A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);


            $('#modal5').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo2_7", function(e){
            e.preventDefault();

            getInfo2_7A[0] = $(this).attr("data-idCliente");
            getInfo2_7A[1] = $(this).attr("data-nombreResidencial");
            getInfo2_7A[2] = $(this).attr("data-nombreCondominio");
            getInfo2_7A[3] = $(this).attr("data-idCondominio");
            getInfo2_7A[4] = $(this).attr("data-nombreLote");
            getInfo2_7A[5] = $(this).attr("data-idLote");
            getInfo2_7A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal6').modal('show');

        });



        $("#tabla_deposito_seriedad tbody").on("click", ".getInfo5_2", function(e){
            e.preventDefault();

            getInfo5_2A[0] = $(this).attr("data-idCliente");
            getInfo5_2A[1] = $(this).attr("data-nombreResidencial");
            getInfo5_2A[2] = $(this).attr("data-nombreCondominio");
            getInfo5_2A[3] = $(this).attr("data-idCondominio");
            getInfo5_2A[4] = $(this).attr("data-nombreLote");
            getInfo5_2A[5] = $(this).attr("data-idLote");
            getInfo5_2A[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal7').modal('show');

        });


        $("#tabla_deposito_seriedad tbody").on("click", ".return1", function(e){
            e.preventDefault();

            return1a[0] = $(this).attr("data-idCliente");
            return1a[1] = $(this).attr("data-nombreResidencial");
            return1a[2] = $(this).attr("data-nombreCondominio");
            return1a[3] = $(this).attr("data-idCondominio");
            return1a[4] = $(this).attr("data-nombreLote");
            return1a[5] = $(this).attr("data-idLote");
            return1a[6] = $(this).attr("data-fechavenc");

            nombreLote = $(this).data("nomlote");
            $(".lote").html(nombreLote);

            $('#modal_return1').modal('show');

        });

    });





</script>




