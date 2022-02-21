<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        switch ($this->session->userdata('id_rol')) {
            case '13': // CONTRALORÍA
            case '17': // SUBDIRECTOR CONTRALORÍA
            case '32': // CONTRALORÍA CORPORATIVA
            case '11': // ADMINISTRACIÓN
                $datos = array();
                $datos = $datos4;
                $datos = $datos2;
                $datos = $datos3;
                $this->load->view('template/sidebar', $datos);
                break;
            default: // NO ACCESS
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
                break;
        }
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Estatus comisiones</h3>
                                    <p class="card-title pl-1">(Comisiones sin pago reflejado en NEODATA)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0" for="proyecto">Proyecto</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required>
                                                        <option value="0">Selecciona una opción</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0" for="condominio">Condominio</label>
                                                    <select name="condominio" id="condominio" class="selectpicker select-gral" data-style="btn btn-second"data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
                                                        <option disabled selected>Selecciona una opción</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_comisiones_sin_pago" name="tabla_comisiones_sin_pago">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>ASESOR</th>
                                                        <th>COORDINADOR</|th>
                                                        <th>GERENTE</th>
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
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->

    <?php $this->load->view('template/footer'); ?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        userType = <?= $this->session->userdata('id_rol') ?> ;

        $(document).ready(function() {
            $.post(url + "Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#proyecto").selectpicker('refresh');
            }, 'json');
        });

        $('#proyecto').change( function(){
            index_proyecto = $(this).val();
            index_condominio = 0
            $("#condominio").html("");
            $(document).ready(function(){
                $.post(url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
                    var len = data.length;
                    $("#condominio").append($('<option disabled selected>Selecciona una opción</option>'));

                    for( var i = 0; i<len; i++)
                    {
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#condominio").selectpicker('refresh');
                }, 'json');
            });
            fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
        });

        $('#condominio').change( function(){
            index_proyecto = $('#proyecto').val();
            index_condominio = $(this).val();
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
        });

        var url = "<?= base_url() ?>";
        var url2 = "<?= base_url() ?>index.php/";
        var totaPen = 0;
        var tr;

        $('#tabla_comisiones_sin_pago thead tr:eq(0) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tabla_comisiones_sin_pago').DataTable().column(i).search() !== this.value) {
                    $('#tabla_comisiones_sin_pago').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        function fillCommissionTableWithoutPayment (proyecto, condominio) {
            tabla_comisiones_sin_pago = $("#tabla_comisiones_sin_pago").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                language: {
                    url: "../static/spanishLoader.json"
                },
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
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Descargar archivo de Excel',
                }],
                columns: [{
                    data: function(d) {
                        return '<p class="m-0">' + d.idLote + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreResidencial + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCondominio + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreLote + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCliente + ' </p>';
                    }
                },

                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreAsesor + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreCoordinador + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.nombreGerente + '</p>';
                    }
                },
                {
                    data: function(d) {
                        return '<p class="m-0">' + d.reason + '</p>';
                    }
                }],
                columnDefs: [{
                    defaultContent: "",
                    targets: "_all",
                    searchable: true,
                    orderable: false
                }],
                ajax: {
                    url: url2 + "ComisionesNeo/getGeneralStatusFromNeodata/" + proyecto + "/" + condominio,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
        }
    </script>
</body>