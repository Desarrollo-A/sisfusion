<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <style>
        .label-inf {
            color: #333;
        }
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
                            <i class="fas fa-user-circle fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Listado general de clientes</h3>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="clients-datatable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTES</th>
                                                    <th>SEDE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>LUGAR PROSPECCIÓN</th>
                                                    <th>ASESOR</th>
                                                    <th>FECHA APARTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
<!--<script src="--><?php //base_url()?><!--dist/js/jquery.validate.js"></script>-->


<script>

    $('#clients-datatable thead tr:eq(0) th').each( function (i) {

        //  if(i != 0 && i != 11){
        var title = $(this).text();
        $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#clients-datatable').DataTable().column(i).search() !== this.value ) {
                $('#clients-datatable').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        } );
        //}
    });

    let titulos = [];
    $('#clients-datatable thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
    });


    var clients_datatable;
    $(document).ready(function () {
        clients_datatable = $('#clients-datatable').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Listado general de clientes',
                    title:'Listado general de clientes' ,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        format: {
                            header:  function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                        break;
                                    case 3:
                                        return 'CLIENTES';
                                        break;
                                    case 4:
                                        return 'SEDE';
                                        break;
                                    case 5:
                                        return 'TELÉFONO';
                                        break;
                                    case 6:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 7:
                                        return 'ASESOR';
                                        break;
                                    case 8:
                                        return 'FECHA APARTADO';
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
                searchable: true
            }],
            scrollX: true,
            fixedHeader: true,
            pageLength: 10,
            width: '100%',
            pagingType: "full_numbers",
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering:true,
            columns: [
                { data: function (d) {
                        return d.nombreResidencial;
                    }
                },
                { data: function (d) {
                        return d.nombreCondominio;
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
                        return d.ubicacion;
                    }
                },
                { data: function (d) {
                        return d.telefono;
                    }
                },
                { data: function (d) {
                        return d.lugar_prospeccion;
                    }
                },
                { data: function (d) {
                        return d.nombreAsesor;
                    }
                },
                { data: function (d) {
                        return d.fechaApartado;
                    }
                }
            ],
            "ajax": {
                "url": "getClientsList",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });
    });
</script>

</html>
