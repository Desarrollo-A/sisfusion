<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
            $this->load->view('template/sidebar');
    ?>

    <!-- modal  INSERT COMENTARIOS-->
    <div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <form method="POST" name="sendAutsFromD" enctype="multipart/form-data" action="<?=base_url()?>index.php/registroCliente/updateAutsFromsDC">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center><h3 class="modal-title" id="myModalLabel"><b>Autorizaciones</b></h3></center>
                    </div>
                    <div class="modal-body">


                        <div id="loadAuts">

                        </div>
                        <input type="hidden" name="numeroDeRow"  id="numeroDeRow" value="">
                        <input type="hidden" name="idCliente"  id="idCliente" value="">
                        <input type="hidden" name="idCondominio"  id="idCondominio" value="">
                        <input type="hidden" name="idLote"  id="idLote" value="">
                        <input type="hidden" name="id_autorizacion"  id="id_autorizacion" value="">

                        <input type="hidden" name="nombreResidencial"  id="nombreResidencial" value="">
                        <input type="hidden" name="nombreCondominio"  id="nombreCondominio" value="">
                        <input type="hidden" name="nombreLote"  id="nombreLote" value="">



                    </div>
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-primary">
                            Enviar autorización
                        </button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Tus autorizaciones</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table id="authorizationsTable"
                                           class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th>ESTATUS</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ASESOR</th>
                                                <th>CLIENTE</th>
                                                <th>SOLICITUD</th>
                                                <th>COMENTARIO</th>
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




    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Tus autorizaciones</h4><br><br>
                            <div class="table-responsive">
                                <table id="authorizationsTable" class="table table-bordered table-hover" width="100%" style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th><center>Estatus</center></th>
                                        <th><center>Proyecto</center></th>
                                        <th><center>Condominio</center></th>
                                        <th><center>Lote</center></th>
                                        <th><center>Asesor</center></th>
                                        <th><center>Cliente</center></th>
                                        <th><center>Solicitud</center></th>
                                        <th><center>Comentario</center></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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
    $('#authorizationsTable thead tr:eq(0) th').each(function (i) {
        if (i != 8) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500; text-align: center;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#authorizationsTable').DataTable().column(i).search() !== this.value) {
                    $('#authorizationsTable').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    $(document).ready(function() {

        $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
            var input = $(this).closest('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        console.log('triggered');
    });





    var miArray = new Array(6)

    $(document).ready (function() {

        var table;
        var funcionToGetData;
        <?php
        if($this->session->userdata('id_rol') == 1)
        { ?>
            funcionToGetData = 'getAuthorizationsByDirector';
        <?php
        }
        else
        { ?>
            funcionToGetData = 'getAuthorizationsBySubdirector';
        <?php
        }
        ?>
        table = $('#authorizationsTable').DataTable( {
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            ordering: false,
            "buttons": [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Lista de autorizaciones',
                    title:"Lista de autorizaciones",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Lista de autorizaciones',
                    title: "Lista de autorizaciones",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            "scrollX": true,
            "pageLength": 10,
            "pagingType": "full_numbers",
            "lengthMenu": [
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
            ajax: "<?=base_url()?>index.php/Clientes/"+funcionToGetData+"/",
            columns: [
                {
                    data: function (d) {
                        if (d.estatus == 0) {
                            return '<center><span class="label" style="background:#229954">Autorizada</span><center>';
                        } else if (d.estatus == 1){
                            return '<center><span class="label" style="background:#2471A3">Pendiente</span><center>';
                        } else if (d.estatus == 2){
                            return '<center><span class="label" style="background:#B03A2E">Rechazada</span><center>';
                        } else {
                            return '<center><span class="labelr" style="background:#7D3C98">En DC</span><center>';
                        }

                    }
                },
                { "data": "nombreResidencial" },
                { "data": "nombreCondominio" },
                { "data": "nombreLote" },
                {
                    "data": function( d ){
                        var as1 = (d.asesor == null ? "" : d.asesor + '<br>');
                        var as2 = (d.asesor2 == null ? "" : d.asesor2 + '<br>');
                        var as3 = (d.asesor3 == null ? "" : d.asesor3 + '<br>');
                        return as1 ;
                    }
                },
                {
                    "data": function( d ){
                        var cliente = (d.cliente == null ? "" : d.cliente);
                        return cliente;
                    }
                },
                {
                    "data": function( d ){
                        var cliente = (d.cliente == null ? "" : d.autorizacion);
                        return cliente;
                    }
                },
                { "data": "comentario" },
                /*,
                {
                    "data": function( d ){
                        return '<button class="btn btn btn-round btn-fab btn-fab-mini getInfo" data-id_autorizacion="'+d.id_autorizacion+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" ' + 'data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" ' + 'data-idLote="'+d.idLote+'" style="margin-right: 3px;background-color:#2E4053;border-color:#2E4053"><i class="material-icons">remove_red_eye</i></button>';
                    }
                }*/
            ]
        });


        $("#authorizationsTable tbody").on("click", ".getInfo", function(e){
            e.preventDefault();
            var $itself = $(this);
            var idCliente = $itself.attr("data-idCliente");
            var nombreResidencial=$itself.attr('data-nombreresidencial');
            var nombreCondominio=$itself.attr('data-nombrecondominio');
            var idCondominio = $itself.attr("data-idCondominio");
            var nombreLote = $itself.attr("data-nombrelote");
            var idLote=$itself.attr('data-idLote');
            var id_aut = $itself.attr('data-id_autorizacion');
            $('#idCliente').val(idCliente);
            $('#idCondominio').val(idCondominio);
            $('#idLote').val(idLote);
            $('#id_autorizacion').val(id_aut);
            $('#nombreResidencial').val(nombreResidencial);
            $('#nombreCondominio').val(nombreCondominio);
            $('#nombreLote').val(nombreLote);

            $.post( "<?=base_url()?>index.php/Clientes/getAuthorizationDetails/"+idLote, function( data ) {
                $('#loadAuts').empty();
                var ctn;
                var p = 0;
                var opcionDenegado;
                $.each(JSON.parse(data), function(i, item) {

                    <?php
                    if($this->session->userdata('id_rol')==1)
                    {?>
                    opcionDenegado = '';
                    <?php
                    }
                    else
                    {
                    ?>
                    opcionDenegado = '<label><input type="radio" name="accion'+i+'" value="3" required> Enviar a DC</label><br>';
                    <?php
                    }
                    ?>


                    ctn ='<table width="100%">'+
                        '<tr>'+
                        '<td width="100%">' +
                        '<label>Solicitud asesor <small>('+item['fecha_creacion']+')</small>:</label><br><p><i>' + item['autorizacion']+'</i></p></td>' +
                        '<tr/>'+
                        '<tr>'+
                        '<td width="100%">' +
                        '<div class="form-group label-floating is-empty">\n' +
                        '                                            <label class="control-label">Comentario</label>\n' +
                        '<input type="text" name="observaciones'+i+'" class="form-control" placeholder="" required><br><br>' +
                        '                                        <span class="material-input"></span></div>' +

                        '<input type="hidden" name="idAutorizacion'+i+'"  value="'+item['id_autorizacion']+'">'+
                        '</td>' +
                        '<tr/>'+
                        '<tr>'+

                        '<td>' +
                        '<div class="input-group"><label class="input-group-btn"><span class="btn btn-primary btn-file">' +
                        'Seleccionar archivo&hellip;<input type="file" name="docArchivo'+i+'" id="expediente'+i+'" style="display: none;">' +
                        '</span></label><input type="text" class="form-control" id= "txtexp'+i+'" readonly></div><br><br>'+
                        '</td>' +
                        '<tr/>'+
                        '<tr>'+
                        '<div class="input-group" >' +
                        '<td style="text-align:center;">' +
                        '<div class="col-md-4">' +
                        '<label><input type="radio" name="accion'+i+'" value="0" required> Aceptar</label>' +
                        '</div>'+
                        '<div class="col-md-4">' +
                        '<label><input type="radio" name="accion'+i+'" value="2" required> Denegar</label>' +
                        '</div>'+
                        '<div class="col-md-4">' +
                        opcionDenegado +
                        '</div>'+
                        '</td>'+
                        '</div>'+
                        '</tr></table>'+
                        '<hr style="border:1px solid #eee">';
                    $('#loadAuts').append(ctn);

                    p++;
                });
                $('#numeroDeRow').val(p);
            });
            $('#addFile').modal('show');

        });
    });





    $(document).on('click', '#save', function(e) {
        e.preventDefault();

        var idCliente = miArray[0];
        var nombreResidencial = miArray[1];
        var nombreCondominio = miArray[2];
        var idCondominio = miArray[3];
        var nombreLote = miArray[4];
        var idLote = miArray[5];
        var expediente = $("#expediente")[0].files[0];
        var motivoAut = $("#motivoAut").val();


        var data = new FormData();

        data.append("idCliente", idCliente);
        data.append("nombreResidencial", nombreResidencial);
        data.append("nombreCondominio", nombreCondominio);
        data.append("idCondominio", idCondominio);
        data.append("nombreLote", nombreLote);
        data.append("idLote", idLote);
        data.append("expediente", expediente);
        data.append("motivoAut", motivoAut);

        var file = (expediente == undefined) ? 0 : 1;


        if (motivoAut.length <= 10 || file == 0) {
            //toastr.error('Todos los campos son obligatorios y/o mayores a 10 caracteres.');
            alerts.showNotification('top', 'right', 'Todos los campos son obligatorios y/o mayores a 10 caracteres.', 'danger');
        }

        if (motivoAut.length > 10 && file == 1) {
            $.ajax({
                url: "addFileVentas",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(data){
                    //toastr.success('Autorización enviada.', 'Alerta de éxito');
                    alerts.showNotification('top', 'right', 'Autorización enviada', 'success');
                    $('#addFile').modal('hide');
                    $('#authorizationsTable').DataTable().ajax.reload();
                },
                error: function( data ){
                    alerts.showNotification('top', 'right', 'Error al enviar autorización', 'danger');
                    //toastr.error('Error al enviar autorización.', 'Alerta de error');
                }
            });
        }

    });




    jQuery(document).ready(function(){
        jQuery('#addFile').on('hidden.bs.modal', function (e) {
            jQuery(this).removeData('bs.modal');
            jQuery(this).find('#expediente').val('');
            jQuery(this).find('#txtexp').val('');
            jQuery(this).find('#motivoAut').val('');

        })
    })


    $("#filtro4").on("change", function(){
        $('#authorizationsTable').DataTable().ajax.reload();
    });

    $(document).ready(function () {
        <?php
        if($this->session->userdata('success') == 1)
        {
            echo 'alerts.showNotification("top","right","Se enviaron las autorizaciones correctamente", "success");';
            echo 'console.log("logrado correctamente");';
            $this->session->unset_userdata('success');

        }
        elseif($this->session->userdata('error') == 99)
        {
            echo 'alerts.showNotification("top","right","Ocurrio un error al enviar la autorización ", "danger");';
            echo 'console.log("OCURRIO UN ERROR");';
            $this->session->unset_userdata('error');
        }
        ?>


    });





</script>
