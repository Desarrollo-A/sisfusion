<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
    <?php
    if($this->session->userdata('id_rol')=="16" || $this->session->userdata('id_rol')=="6" || $this->session->userdata('id_rol')=="11"  || $this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="32" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="47" || $this->session->userdata('id_rol')=="15" || $this->session->userdata('id_rol')=="7" || $this->session->userdata('id_rol')=="12")//contratacion
    {
        $this->load->view('template/sidebar');
    }
    else
    {
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

    <!-- Modals -->
    <div class="modal fade " id="modalConfirmRegExp" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body text-center">
                        <h3>¿Estás seguro que desea regresar el expediente <b id="loteName"></b> ?</h3>
                        <p><small>El cambio no podrá ser revertido.</small></p>
                        <input type="hidden" value="" id="tempIDC">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary acepta_regreso">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Regresar expediente</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="filtro3" id="filtro3"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un proyecto" data-size="7" required>
                                                <?php
                                                if($residencial != NULL) :
                                                    foreach($residencial as $fila) : ?>
                                                        <option value= <?=$fila['idResidencial']?> > <?=$fila['descripcion']?> </option>
                                                    <?php endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select id="filtro4" name="filtro4"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un condominio" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select id="filtro5" name="filtro5"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un lote" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Clientes</label>
                                            <select id="filtro6" name="filtro6"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un cliente" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="tableDoct"
                                               class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>ID LOTE</th>
                                                <th>LOTE</th>
                                                <th>GERENTE</th>
                                                <th>COORDINADOR</th>
                                                <th>ASESOR</th>
                                                <th>CLIENTE</th>
                                                <th>APARTADO</th>
                                                <th>CLIENTE ESTATUS</th>
                                                <th>LOTE ESTATUS</th>
                                                <th>LUGAR PROSPECCIÓN</th>
                                                <th>ACCIÓN</th>
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
    Shadowbox.init();
</script>
<script>
    $(document).ready (function() {



        $('#filtro3').change(function(){

            var valorSeleccionado = $(this).val();

            // console.log(valorSeleccionado);
            //build select condominios
            $('#tableDoct').DataTable().clear();
            $("#filtro4").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>registroCliente/getCondominios/'+valorSeleccionado,
                type: 'post',
                dataType: 'json',
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idCondominio'];
                        var name = response[i]['nombre'];
                        $("#filtro4").append($('<option>').val(id).text(name));
                    }
                    $("#filtro4").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');
                }
            });
        });


        $('#filtro4').change(function(){
            var residencial = $('#filtro3').val();
            var condominio = $(this).val();
            $('#tableDoct').DataTable().clear();
            // console.log(valorSeleccionado);
            //$('#filtro5').load("<?//= site_url('registroCliente/getLotesAll') ?>///"+valorSeleccionado+'/'+residencial);
            $("#filtro5").empty().selectpicker('refresh');
            $.ajax({
                url: '<?=base_url()?>registroCliente/getSelectedLotes/'+condominio+'/'+residencial,
                type: 'post',
                dataType: 'json',
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['idLote'];
                        var name = response[i]['nombreLote'];
                        $("#filtro5").append($('<option>').val(id).text(name));
                    }
                    $("#filtro5").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');
                }
            });
        });


        $('#filtro5').change(function(){
            var idLote = $(this).val();
            // console.log(valorSeleccionado);
            //$('#filtro5').load("<?//= site_url('registroCliente/getLotesAll') ?>///"+valorSeleccionado+'/'+residencial);
            $("#filtro6").empty().selectpicker('refresh');
            $('#tableDoct').DataTable().clear();
            $.ajax({
                url: '<?=base_url()?>registroCliente/getClientsByLote/'+idLote,
                type: 'post',
                dataType: 'json',
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
                success:function(response){
                    var len = response.length;
                    for( var i = 0; i<len; i++)
                    {
                        var id = response[i]['id_cliente'];
                        var name = response[i]['nombreCliente'];
                        let estatus='';
                        if(response[i]['status'] == 1){
                            estatus=' [Activo]'
                        }
                        $("#filtro6").append($('<option>').val(id).text(name + estatus));
                    }
                    $("#filtro6").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');
                }
            });
        });



        $('#tableDoct thead tr:eq(0) th').each(function (i) {

            if (i != 12) {
                var title = $(this).text();
                $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {
                    if ($('#tableDoct').DataTable().column(i).search() !== this.value) {
                        $('#tableDoct').DataTable()
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        $('#filtro6').change(function(){

            var idCliente = $(this).val();

            console.log(idCliente);
            $('#tableDoct').DataTable({
                destroy: true,
                lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax":
                    {
                        "url": '<?=base_url()?>index.php/registroCliente/getClientByID/'+idCliente,
                        "dataSrc": ""
                    },
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                "pageLength": 10,
                "ordering": false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Lista de documentación por lote',
                        title: "Lista de documentación por lote",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 7, 8]
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                        className: 'btn buttons-pdf',
                        titleAttr: 'Regreso de expediente',
                        title: "Regreso de expediente",
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,7,8],
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
                                            return 'ID LOTE';
                                        case 3:
                                            return 'LOTE';
                                            break;
                                        case 4:
                                            return 'CLIENTE';
                                            break;
                                        case 5:
                                            return 'APARTADO';
                                            break;
                                        case 6:
                                            return 'CLIENTE ESTATUS';
                                            break;
                                        case 7:
                                            return 'LOTE ESTATUS';
                                            break;
                                        case 8:
                                            return 'LUGAR PROSPECCIÓN';
                                            break;
                                    }
                                }
                            }
                        }
                    }
                ],
                /*
                        GERENTE
                        COORDINADOR
                        ASESOR*/
                "language":{ "url": "<?=base_url()?>/static/spanishLoader.json" },
                "columns":
                    [
                        {
                            "width": "8%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
                            }
                        },

                        {
                            "width": "8%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.nombreCondominio+'</p>';
                            }
                        },
                        {
                            "width": "12%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.idLote+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.gerente+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.coordinador+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.asesor+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.nomCliente+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.fechaApartado+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                let lblStatus='';
                                if(d.estatus_cliente == 1){
                                    lblStatus = '<small style="background: rgb(52,199,89); color:white; padding: 5px; width: 40px;border-radius: 10px">ACTIVO</small>';
                                }else{
                                    lblStatus = '<small style="background: rgb(255,59,48); color:white; padding: 5px; width: 40px;border-radius: 10px">INACTIVO</small>';
                                }
                                return '<p style="font-size: .8em">'+lblStatus+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em; background-color:'+d.statusLoteColor+'; padding: 2px; color:white; padding: 2px;border-radius: 10px">'+d.estatus_lote+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            "data": function( d ){
                                return '<p style="font-size: .8em">'+d.lp+'</p>';
                            }
                        },
                        {
                            "width": "10%",
                            data: null,
                            render: function ( data, type, row )
                            {
                                let button_action='';
                                if(data.estatus_cliente==0){
                                    button_action = '<center><a class="backButton btn-data btn-warning" title= "Regresar expediente" style="cursor:pointer;" data-nomLote="'+data.nombreLote+'" data-nombreCliente="'+data.nomCliente+'" data-idCliente="'+data.id_cliente+'"><i class="fas fa-history"></i></a></center>';
                                }else{
                                    button_action = 'NA';
                                }
                                return button_action;
                            }
                        }
                    ]
            });

        });










    });/*document Ready*/

    $(document).on('click', '.backButton', function(){
        console.log("CAMARA MI PERRROOOOOO");
        var $itself = $(this);
        let nombreLote = $itself.attr('data-nomLote');
        let cliente = $itself.attr('data-nombreCliente');
        let idCliente = $itself.attr('data-idCliente');
        console.log("nombreLote: ", nombreLote);
        console.log("cliente: ", cliente);
        console.log("idCliente: ", idCliente);
        $('#tempIDC').val(idCliente);
        $('#loteName').text(nombreLote);
        $('#modalConfirmRegExp').modal();
        // data-nomLote
        // modalConfirmRegExp
    });

    $(document).on('click', '.acepta_regreso', function(){
       console.log('olv si acepto jejee');
        let id_cliente = $('#tempIDC').val();
      $.ajax({
            type: "POST",
            url:  `${base_url}Restore/return_status_uno/`,//https://maderascrm.gphsis.com/index.php/Restore/return_status_uno/idCliente
            data: {idCliente: id_cliente},
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('#spiner-loader').removeClass('hide');
            },
            success: function(data){
                $('#spiner-loader').addClass('hide');
                console.log(data.data);
                if(data.data==true){
                    alerts.showNotification("top", "right", "Se ha regresado el expediente correctamente.", "success");
                }else{
                    alerts.showNotification("top", "right", "Ha ocurrido un error intentalo nuevamente.", "danger");
                }
                $('#modalConfirmRegExp').modal('hide');
                $("#tableDoct").DataTable().ajax.reload();
            },
            error: function() {
                $('#modalConfirmRegExp').modal('hide');

                $('#spiner-loader').addClass('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        }); /* */
    });


</script>

