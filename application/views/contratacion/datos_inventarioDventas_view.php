<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php
        if($this->session->userdata('id_rol') == "16" || $this->session->userdata('id_rol') == "6" || $this->session->userdata('id_rol') == "5" || $this->session->userdata('id_rol') == "3" || $this->session->userdata('id_rol') == "4" || $this->session->userdata('id_rol') == "9" || $this->session->userdata('id_rol') == "53"){
            $this->load->view('template/sidebar');
        }
        else {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        }
    ?>

    <!--Contenido de la página-->
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-bookmark fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Registros de Terrenos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="filtro3" id="filtro3" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona proyecto" data-size="7" required>
                                                <option value= "InventarioCompleto"> Inventario Completo </option>
                                                <?php
                                                if($residencial != NULL) :
                                                    foreach($residencial as $fila) : ?>
                                                        <option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
                                                    <?php endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select id="filtro4" name="filtro4"class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true"  title="Selecciona Condominio" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tableTerrenos" class="table-striped table-hover" style="text-align:center;">
                                                <thead>
                                                <tr>
                                                    <th><center>PROYECTO</center></th>
                                                    <th><center>CONDOMINIO</center></th>
                                                    <th><center>LOTE</center></th>
                                                    <th><center>SUPERFICIE</center></th>
                                                    <th><center>TOTAL</center></th>
                                                    <th><center>ENGANCHE</center></th>
                                                    <th><center>A FINANCIAR</center></th>
                                                    <th><center>MESES S/I</center></th>
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
    </div>



    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="container-fluid" style="padding: 50px 10px;">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="card-title" style="text-align: center">Registros de Terrenos</h4><br><br>
                                <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Proyecto:</label><br>
                                    <select name="filtro3" id="filtro3" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn " title="Selecciona Proyecto" data-size="7" required>
                                        <option value= "InventarioCompleto"> Inventario Completo </option>
                                        <?php
                                        if($residencial != NULL) :
                                            foreach($residencial as $fila) : ?>
                                                <option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
                                            <?php endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                                <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label>Condominio:</label><br>
                                    <select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true"
                                            data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-content" style="padding: 50px 20px;">
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="tableTerrenos" class="table table-bordered table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th><center>Proyecto</center></th>
                                                <th><center>Condominio</center></th>
                                                <th><center>Lote</center></th>
                                                <th><center>Superficie</center></th>
                                                <th><center>Total</center></th>
                                                <th><center>Enganche</center></th>
                                                <th><center>A Financiar</center></th>
                                                <th><center>Meses S/I</center></th>
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
<script>
    $('#filtro3').change(function(){
        var entra = 0;
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $('#filtro4').val();

        // var table = $('#tableTerrenos').DataTable();
        //
        // table
        //     .clear()
        //     .draw();

        if(residencial == 'InventarioCompleto')
        {
            var ruta = "<?= site_url('registroLote/getLotesDventasAll') ?>";
            $("#filtro4").html( "" ).append( "" );
            entra = 1;
        }
        else
        {
            entra = 0;
            $("#filtro4").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>registroLote/getCondominio/'+residencial,
                type: 'post',
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro4").append($('<option>').val(id).text(name));
                    }
                    $("#filtro4").selectpicker('refresh');

                }
            });
            //$('#filtro4').load("<?//= site_url('registroLote/getCondominio') ?>///"+residencial);
        }

        if(entra == 1)
        {
            var table = $('#tableTerrenos').DataTable({
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Registros de terrenos',
                    title:'Registros de terrenos',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SUPERFICIE';
                                        break;
                                    case 4:
                                        return 'TOTAL';
                                        break;
                                    case 5:
                                        return 'ENGANCHE';
                                        break;
                                    case 6:
                                        return 'A FINANCIAR';
                                        break;
                                    case 7:
                                        return 'MESES S/I';
                                        break;
                                }
                            }
                        }
                    }
                }],

                ordering: false,
                pagingType: "full_numbers",
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
                columns: [
                    { data: 'nombreResidencial' },
                    { data: 'nombreCondominio' },
                    { data: 'nombreLote' },
                    { data: 'sup' },
                    {
                        // data: 'total'
                        data: function(d)
                        {
                            return "$"+alerts.number_format(d.total, 2, ".", ",")
                        }
                    },
                    {
                        // data: 'enganche'
                        data: function(d)
                        {
                            return "$"+alerts.number_format(d.enganche,2, ".", ",");
                        }
                    },
                    {
                        // data: 'saldo'
                        data: function(d)
                        {
                            return "$"+alerts.number_format(d.saldo, 2, ".", ",");
                        }
                    },
                    { data: 'msni' },
                ],
                "ajax": {
                    "url": ruta,
                    "type": "POST",
                    "dataSrc": "",
                    cache: false,
                    "data": function( d ){
                        d.proyecto = $('#empresa').val();
                        d.idproyecto = $('#proyecto').val();
                    }
                },
            });
        }
    });

    $('#filtro4').change(function()
    {
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $('#filtro4').val();
        var ruta;
        var table = $('#exmaple').DataTable();

        ruta = "<?= site_url('registroLote/getLotesDventas') ?>/"+valorSeleccionado+'/'+residencial;

        var table = $('#tableTerrenos').DataTable({
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            ordering: false,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Registros de terrenos',
                title:'Registros de terrenos',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return 'PROYECTO';
                                    break;
                                case 1:
                                    return 'CONDOMINO';
                                    break;
                                case 2:
                                    return 'LOTE';
                                case 3:
                                    return 'SUPERFICIE';
                                    break;
                                case 4:
                                    return 'TOTAL';
                                    break;
                                case 5:
                                    return 'ENGANCHE';
                                    break;
                                case 6:
                                    return 'A FINANCIAR';
                                    break;
                                case 7:
                                    return 'MESES S/I';
                                    break;
                            }
                        }
                    }
                }
            }],


            pagingType: "full_numbers",
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
            columns: [
                { data: 'nombreResidencial' },
                { data: 'nombreCondominio' },
                { data: 'nombreLote' },
                { data: 'sup' },
                {
                    // data: 'total'
                    data: function(d)
                    {
                        return "$"+alerts.number_format(d.total, 2, ".", ",")
                    }
                },
                {
                    // data: 'enganche'
                    data: function(d)
                    {
                        return "$"+alerts.number_format(d.enganche,2, ".", ",");
                    }
                },
                {
                    // data: 'saldo'
                    data: function(d)
                    {
                        return "$"+alerts.number_format(d.saldo, 2, ".", ",");
                    }
                },
                { data: 'msni' },
            ],
            "ajax": {
                "url": ruta,
                "dataSrc": "",
                "type": "POST",
                cache: false,
                "data": function( d ){
                    d.proyecto = $('#empresa').val();
                    d.idproyecto = $('#proyecto').val();
                }
            },
        });
    });

</script>
