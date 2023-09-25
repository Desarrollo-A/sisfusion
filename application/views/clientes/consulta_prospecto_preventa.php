<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">   
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-address-book fa-2x"></i>                                
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado general de prospectos preventa</h3>
                                    
                                <div class="table-responsive">
                                    <div class="material-datatables">
                                        <table id="prospects_preventa_datatable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ESTADO</th>
                                                    <th>ETAPA</th>
                                                    <th>PROSPECTO</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>CREACIÓN</th>
                                                    <th>VENCIMIENTO</th>
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
        $('#prospects_preventa_datatable thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#prospects_preventa_datatable').DataTable().column(i).search() !== this.value ) {
                    $('#prospects_preventa_datatable').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $(document).ready(function () {
            prospectsTable = $('#prospects_preventa_datatable').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                dom: "<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end p-0'l>rt>"+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                pagingType: "full_numbers",
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                    orderable: false
                }],
                columns: [{
                    data: function (d) {
                        if (d.estatus == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                        } else {
                            return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                        }
                    }
                },
                { 
                    data: function (d) {
                        if(d.estatus_particular == 1) { // DESCARTADO
                            b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                        } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                            b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                        } else if (d.estatus_particular == 3){ // CON CITA
                            b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                        } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                            b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                        } else if (d.estatus_particular == 5){ // PAUSADO
                            b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                        } else if (d.estatus_particular == 6){ // PREVENTA
                            b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                        }
                        return b;
                    }
                },
                { 
                    data: function (d) {
                        return d.nombre;
                    }
                },
                { 
                    data: function (d) {
                        return d.asesor;
                    }
                },
                { 
                    data: function (d) {
                        return d.coordinador;
                    }
                },
                { 
                    data: function (d) {
                        return d.gerente;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_vencimiento;
                    }
                }],
                ajax: {
                    "url": "getPresalesList",
                    "type": "POST",
                    cache: false,
                    "data": function( d ){
                    }
                }
            });
        });
    </script>
</body>