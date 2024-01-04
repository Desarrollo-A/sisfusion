<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper ">

    <?php $this->load->view('template/sidebar', "");  ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-trash fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Reporte de asesores sin ventas</h3>
                            <br>
                            <div class="material-datatables" id="box-reporteLiberacionesTable">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover"
                                               id="reporteAsesoresTable" name="reporteAsesoresTable">
                                            <thead>
                                                <tr>
                                                    <th>ESTATUS</th>
                                                    <th>ASESOR</th>
                                                    <th>ID ASESOR</th>
                                                    <th>FECHA INGRESO</th>
                                                    <th>MONTO TOTAL</th>
                                                    <th>MESES TRANSCURRIDOS</th>
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
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script>
    $(document).ready(function () {
        fillTable();
    });

    $('#reporteAsesoresTable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        if (i != 14) {
            $(this).html('<input type="text" class="textoshead" placeholder="' +  title +'"/>');
            $('input', this).on('keyup change', function () {
                if ($("#reporteAsesoresTable").DataTable().column(i).search() !== this.value) {
                    $("#reporteAsesoresTable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    function fillTable(typeTransaction, beginDate, endDate, where) {
        generalDataTable = $('#reporteAsesoresTable').dataTable({
            dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ESTATUS';
                                        break;
                                    case 1:
                                        return 'ASESOR';
                                        break;
                                    case 2:
                                        return 'ID ASESOR';
                                        break;
                                    case 3:
                                        return 'FECHA INGRESO';
                                        break;
                                    case 4:
                                        return 'MONTO TOTAL';
                                        break;
                                    case 5:
                                        return 'MESES TRANSCURRIDOS';
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
            pagingType: "full_numbers",
            fixedHeader: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
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
                    data: function (d) {
                        if (d.estatus == 1) {
                            return '<center><span class="label label-default">Activo</span><center>';
                        } else if (d.estatus == 3) {
                            return '<center><span class="label label-default">Inactivo comisionando</span><center>';
                        } else {
                            return '<center><span class="label label-default">Inactivo</span><center>';
                        }
                    }
                },
                {
                    data: function (d) {
                        return d.asesor;
                    }
                },
                {
                    data: function (d) {
                        return d.id_usuario;
                    }
                },
                {
                    data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                {
                    data: function (d) {
                        return "$"+formatMoney(d.monto_vendido);
                    }
                },
                {
                    data: function (d) {
                        if (d.meses <= 5){
                            return '<center><span class="label label-default" style="background:#27AE60">'+d.meses+' meses sin ventas</span></center>';
                        } else if (d.meses >= 6 && d.meses <= 8){
                            return '<center><span class="label label-default" style="background:#FF7C00">'+d.meses+' meses sin ventas</span></center>';
                        } else if (d.meses >= 9){
                            return '<center><span class="label label-default" style="background:#E74C3C">'+d.meses+' meses sin ventas</span><center>';
                        }
                        
                    }
                }
            ],
            columnDefs: [{
                visible: false,
                searchable: false
            }],
            ajax: {
                url: 'getReporteAsesores',
                type: "POST",
                cache: false
            }
        });
    }

</script>
</body>