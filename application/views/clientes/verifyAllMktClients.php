<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">

<?php $this->load->view('template/sidebar'); ?>


    <style>
        .label-inf {
            color: #333;
        }
        /*.modal-body-scroll{
            height: 100px;
            width: 100%;
            overflow-y: auto;
        }*/
        select:invalid {
            border: 2px dashed red;
        }

        .textoshead::placeholder { color: white; }

    </style>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="container-fluid box-w-division mb-5"">
                            <h3 class="card-title center-align">Lista clientes</h3>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-sm-12 col-lg-12 pb-2">
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="all_clientes_table"  class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th><center>ID LOTE</center></th>
                                                    <th><center>MEDIO PROSPECCIÓN</center></th>
                                                    <th><center>FECHA APARTADO</center></th>
                                                    <th><center>LOTE</center></th>
                                                    <th><center>CLIENTE</center></th>
                                                    <th><center>ASESOR</center></th>
                                                    <th><center>GERENTE</center></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid mt-5">
                            <div class="toolbar ">
                                <div class="row">
                                    <h3 class="card-title center-align">Documentación por lote</h3>
                                    <div class="col-md-5">
                                        <div class="form-group label-floating">
                                            <label class="control-label label-gral">ID lote</label>
                                            <input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating">
                                            <button type="submit" class="btn-gral-data find_doc">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-sm-12 col-lg-12">
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tableDoct"  class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>NOMBRE DOCUMENTO</th>
                                                    <th>HORA/FECHA</th>
                                                    <th>DOCUMENTO</th>
                                                    <th>RESPONSABLE</th>
                                                    <th>UBICACIÓN</th>
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
    </div>
    </div>
    <div class="content hide">
        <div class="container-fluid">
            <!--            <h5 style="text-align: center">REGISTRO ESTATUS 6 (Corrida elaborada)</h5>-->
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title center-align">Lista clientes</h4><br><br>
                            <div class="toolbar">
                            </div>

                            <div class="table-responsive">
                                <div class="material-datatables">
                                    <table id="all_clientes_table" class="table table-bordered table-hover" style="text-align:center;width: 100%">
                                        <thead>
                                        <tr>
                                            <th><center>ID lote</center></th>
                                            <th><center>Medio prospección</center></th>
                                            <th><center>Fecha apartado</center></th>
                                            <th><center>Lote</center></th>
                                            <th><center>Cliente</center></th>
                                            <th><center>Asesor</center></th>
                                            <th><center>Gerente</center></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title" style="text-align: center">Documentación por lote</h4>

                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <br><label>Lote:</label>
                                </div>
                                <div class="col-md-5">
                                    <input id="inp_lote" name="inp_lote" class="form-control" type="number">
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger find_doc"> Buscar </button>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tableDoct" class="table table-bordered table-hover" width="100%"
                                                   style="text-align:center;">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Proyecto</th>
                                                    <th class="text-center">Condominio</th>
                                                    <th class="text-center">Lote</th>
                                                    <th class="text-center">Cliente</th>
                                                    <th class="text-center">Nombre de documento</th>
                                                    <th class="text-center">Hora/Fecha</th>
                                                    <th class="text-center">Documento</th>
                                                    <th class="text-center">Responsable</th>
                                                    <th class="text-center">Ubicación</th>
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
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>

<script>

    $('#all_clientes_table thead tr:eq(0) th').each( function (i) {

        //  if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#all_clientes_table').DataTable().column(i).search() !== this.value ) {
                $('#all_clientes_table').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );
        //}
    });

    var all_clientes_table;
    $(document).ready(function () {

        let titulos = [];
        $('#all_clientes_table thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            titulos.push(title);
        });

        all_clientes_table = $('#all_clientes_table').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Lista de clientes',
                    title:"Lista de clientes",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, ],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID LOTE';
                                        break;
                                    case 1:
                                        return 'MEDIO PROSPECCION';
                                        break;
                                    case 2:
                                        return 'FECHA APARTADO';
                                    case 3:
                                        return 'LOTE';
                                        break;
                                    case 4:
                                        return 'CLIENTE';
                                        break;
                                    case 5:
                                        return 'ASESOR';
                                        break;
                                    case 6:
                                        return 'GERENTE';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            language: {
                url: "../static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columnDefs: [{
                defaultContent: "Sin especificar",
                targets: "_all",
                searchable: true,
                orderable: true
            }],
            destroy: true,
            ordering: false,
            columns: [
                { data: function (d) {
                        return d.idLote;
                    }
                },
                { data: function (d) {
                        return d.medio;
                    }
                },
                { data: function (d) {
                        return d.fechaApartado;
                    }
                },
                { data: function (d) {
                        return d.nombreLote;
                    }
                },
                { data: function (d) {
                        return d.nombreCliente;
                    }
                },
                { data: function (d) {
                        return d.nombreAsesor;
                    }
                },
                { data: function (d) {
                        return d.nombreGerente;
                    }
                }
            ],
            "ajax": {
                "url": "getClientsListByManager",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });
    });
</script>

<script>
    Shadowbox.init();
    var tablaDoc;
    $('#tableDoct thead tr:eq(0) th').each( function (i) {

        //  if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
                $('#tableDoct').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );
        //}
    });



    var id_rol_current = <?php echo $this->session->userdata('id_rol')?>;
    $(document).ready (function() {

        let titulos = [];
        $('#tableDoct thead tr:eq(0) th').each( function (i) {
            if( i!=0 && i!=13){
                var title = $(this).text();
                titulos.push(title);
            }
        });


        $(".find_doc").click( function() {

            var idLote = $('#inp_lote').val();

            tablaDoc = $('#tableDoct').DataTable({
                destroy: true,
                lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax":
                    {
                        "url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+idLote,
                        "dataSrc": ""
                    },
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                "ordering": false,
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Documentación del lote ' + $('#inp_lote').val() ,
                        title:'Documentación del lote ' + $('#inp_lote').val() ,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 7, 8],
                            format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'PROYECTO';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'LOTE';
                                        case 3:
                                            return 'CLIENTE';
                                            break;
                                        case 4:
                                            return 'NOMBRE DOCUMENTO';
                                            break;
                                        case 5:
                                            return 'HORA/FECHA';
                                            break;
                                        case 7:
                                            return 'RESPONSABLE';
                                            break;
                                        case 8:
                                            return 'UBICACIÓN';
                                            break;
                                    }
                                }
                            }
                        }
                    }
                ],
                pagingType: "full_numbers",
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                columnDefs: [{
                    visible: false,
                    searchable: false
                }],
                "columns":
                    [

                        {data: 'nombreResidencial'},
                        {data: 'nombre'},
                        {data: 'nombreLote'},
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                return data.nomCliente +' ' +data.apellido_paterno+' '+data.apellido_materno;
                            },
                        },
                        {data: 'movimiento'},
                        {data: 'modificado'},
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                datos = data.id_asesor;
                                // $.post( "<?=base_url()?>index.php/Asistente_gerente/setVar/"+datos, function( data_json ) {
                                //     console.log(<?php echo $this->session->userdata('datauserjava')?>);
                                // });

                                if (getFileExtension(data.expediente) == "pdf") {
                                    if(data.tipo_doc == 8){
                                        file = '<center><a class="pdfLink3  btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';
                                    } else {
                                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3){?>
                                        if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3) ){
                                            file = '<center><a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a> | <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></i></button></center>';
                                        } else {
                                            file = '<center><a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';
                                        }
                                        <?php } else {?>file = '<center><a class="pdfLink  btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';<?php } ?>
                                    }
                                }
                                else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
                                    file = "<center><a class='btn-data btn-green-excel' href='../../static/documentos/cliente/corrida/" + data.expediente + "'><i class='fas fa-file-excel'></i><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a> </center>";
                                }
                                else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
                                    if(data.tipo_doc == 7){
                                        file = '<center><button type="button" title= "Corrida inhabilitada" class="btn-data btn-green disabled" disabled><i class="material-icons">grid_on</i></button></center>';
                                    } else if(data.tipo_doc == 8){
                                        file = '<center><button type="button" title= "Contrato inhabilitado" class="btn-data btn-green disabled" disabled><i class="material-icons">insert_drive_file</i></button></center>';
                                    } else {
                                        <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3){?>
                                        if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3) ){
                                            file = '<center><button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button></center>';
                                        } else {
                                            file = '<center><button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button></center>';
                                        }
                                        <?php } else {?> file = '<center><button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled " disabled><i class="fas fa-cloud-upload-alt"></i></button></center>'; <?php } ?>
                                    }
                                }
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
                                    file = '<center><a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a></center>';
                                }
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
                                    file = '<center><a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a></center>';
                                }
                                else if (getFileExtension(data.expediente) == "Autorizaciones") {
                                    file = '<center><a href="#" class="btn-data btn-warning seeAuts" title= "Autorizaciones" data-idCliente="'+data.idCliente+'" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a></center>';
                                }
                                else if (getFileExtension(data.expediente) == "Prospecto") {
                                    file = '<center><a href="#" class="btn-data btn-blueMaderas verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-check"></i></a></center>';
                                }
                                else
                                {
                                    <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3){?>
                                    if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3) ){
                                        file = '<center><a class="pdfLink  btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a> | <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button></center>';
                                    } else {
                                        file = '<center><a class="pdfLink  btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a></center>';
                                    }
                                    <?php } else {?> file = '<center><a class="pdfLink  btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a></center>'; <?php }?>

                                }
                                return file;
                            }
                        },
                        {
                            data: null,
                            render: function ( data, type, row )
                            {
                                return myFunctions.validateEmptyFieldDocs(data.primerNom) +' '+myFunctions.validateEmptyFieldDocs(data.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                            },
                        },
                        {data: 'ubic'},
                    ]
            });

            <?php #$this->session->unset_userdata('datauserjava'); ?>

        });




        $('.btn-documentosGenerales').on('click', function () {
            $('#modalFiles').modal('show');
        });

        function getFileExtension(filename) {
            validaFile =  filename == null ? 'null':
                filename == 'Depósito de seriedad' ? 'Depósito de seriedad':
                    filename == 'Autorizaciones' ? 'Autorizaciones':
                        filename.split('.').pop();
            return validaFile;
        }



    });/*document Ready*/

    $(document).on('click', '.pdfLink', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      985,
            height:     660
        });
    });

    $(document).on('click', '.pdfLink2', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });

    $(document).on('click', '.pdfLink22', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      1600,
            height:     900
        });
    });

    $(document).on('click', '.pdfLink3', function () {
        var $itself = $(this);
        Shadowbox.open({
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
            width:      985,
            height:     660
        });
    });

    $(document).on('click', '.verProspectos', function () {
        var $itself = $(this);
        Shadowbox.open({
            /*verProspectos*/
            content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>clientes/printProspectInfo/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
            player:     "html",
            title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
            width:      985,
            height:     660

        });
    });


    $(document).on('click', '.seeAuts', function (e) {
        e.preventDefault();
        var $itself = $(this);
        var idLote=$itself.attr('data-idLote');
        $.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
            $('#auts-loads').empty();
            var statusProceso;
            $.each(JSON.parse(data), function(i, item) {
                if(item['estatus'] == 0)
                {
                    statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
                }
                else if(item['estatus'] == 1)
                {
                    statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
                }
                else if(item['estatus'] == 2)
                {
                    statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
                }
                else if(item['estatus'] == 3)
                {
                    statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
                }
                else
                {
                    statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
                }
                $('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
                $('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
                $('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
                    '<br><hr>');


            });
            $('#verAutorizacionesAsesor').modal('show');
        });
    });

</script>

</html>
