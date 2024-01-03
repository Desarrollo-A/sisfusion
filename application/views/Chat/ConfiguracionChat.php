<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php
    /*-------------------------------------------------------*/
    $datos = array();
    $datos = $datos4;
    $datos = $datos2;
    $datos = $datos3;
    $this->load->view('template/sidebar', $datos);
    /*--------------------------------------------------------*/
    if($this->session->userdata('id_rol') != 20 && $this->session->userdata('id_rol') != 19  && $this->session->userdata('id_rol') != 28 && $this->session->userdata('id_rol') != 18 ){
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

    <style type="text/css">
        @media screen and (min-width: 990px) {
            .box-img{
                width: 200px;
                height: 200px;
                border-radius: 50%;
            }
        }
        @media screen and (max-width: 990px) {
            .box-img{
                width: 400px;
                height: 400px;
                border-radius: 50%;
            }
            .col-img {
                border: none!important;
            }
        }
        .center{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .col-img{
            border-right: 2px solid #eaeaea
        }
        .no-btn{
            background-color: transparent;
            border: none;
            color: #545454;
        }
        .no-btn:hover{
            color:red;
        }
    </style>

    <!-- Modals -->
    <div class="modal fade" id="EditarChat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h5 class="modal-title" id="exampleModalLongTitle">Chat</h5>
                </div>
                <div class="modal-body">
                    <form id="formChat" method="POST">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating div_last_name">
                                        <label class="label">Número de asesores</label>
                                        <input id="num_chatS" name="num_chatS" min="0" type="number" class="form-control" required="number">
                                        <input type="hidden" id="idC" name="idC">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 30px!important">Cancelar</button>
                                    <button type="submit" class="btn btn-primary" style="padding: 12px 30px!important">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-comments fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Configuración de chats</h3>
                                <div class="toolbar">
                                    <div class="col-md-12 d-flex flex-end">
                                        <!--<button class="no-btn" data-toggle="modal" data-target="#EditarMiPerfil"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>-->
                                    </div>
                                    <div class="row pb-5">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-12 center col-img">
                                            <div class="box-img" style="background-image: url(../static/images/perfil/<?=$permiso[0]['id_usuario']?>/<?=$permiso[0]['foto']?>); background-position: center; background-repeat: no-repeat; background-size: cover;width: 150px; height: 150px; border-radius: 50%; margin: auto;">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9 pl-4">
                                            <div class="row">
                                                <div class="col-md-12 d-flex flex-end">
                                                    <button class="no-btn" data-toggle="modal" data-target="#EditarMiPerfil"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="col-md-12">
                                                    <?php
                                                    if ($permiso[0]['estatus'] == 3) {
                                                        echo '<b>Estatus</b><p><span class="label label-default" >OFF LINE</span></p>';
                                                    }elseif ($permiso[0]['estatus'] == 2) {
                                                        echo '<b>Estatus</b><p><span class="label label-warning" >Consulta</span></p>';
                                                    }elseif ($permiso[0]['estatus'] == 1) {
                                                        echo '<b>Estatus</b><p><span class="label label-success" >Online</span></p>';
                                                    }
                                                    elseif ($permiso[0]['estatus'] == 4) {
                                                        echo '<b>Estatus:</b><p><span class="label" style="background-color:#47F2C8;border-color:#47F2C8;" >Autorizado</span></p>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-12">
                                                    <p><b>Mensaje</b><br><i style="font-size: 18px">"<?=$permiso[0]['mensaje']?>"</i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table id="tabla_chats" class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>NÚMERO DE ASESORES</th>
                                                    <th>SEDE</th>
                                                    <th>ACCIONES</th>
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
<?php $this->load->view('template/footer');?>
<script type="text/javascript">
    let url = "<?=base_url()?>";
    let rol = "<?=$this->session->userdata('id_rol')?>";
    let sedes = "<?=$this->session->userdata('id_sede')?>";
    let urlChat = '';
    if(rol == 19){
        urlChat = url+'Chat/ConfiguracionSuper/'+sedes;
    }
    else if(rol == 20){
        urlChat = url+'Chat/ConfiguracionGte/'+sedes;
    }
    else if(rol == 28){
        urlChat = url+'Chat/ConfiguracionAdmin/'+sedes;
    }
    else if(rol == 18){
        urlChat = url+'Chat/ConfiguracionAdmin/'+sedes;
    }

    $(document).ready(function () {
        $('#tabla_chats thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            if ( i != 3 ) {
                $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (chatsTable.column(i).search() !== this.value ) {
                        chatsTable
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        chatsTable = $('#tabla_chats').DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Chats por sede',
                    title: 'Descargar archivo de Excel',
                    exportOptions: {
                        columns: [0, 1, 2],
                        format: {
                            header: function (d, columnIdx) {
                                if (columnIdx == 0) {
                                    return 'ID';
                                } else if (columnIdx == 1) {
                                    return 'NÚMERO DE ASESORES';
                                } else if (columnIdx == 2) {
                                    return 'SEDE ';
                                }
                            }
                        }
                    }
                }
            ],
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
                data: function (d) {
                    return '<center>'+d.idchatsede+'</center>';
                }
            },
                {
                    data: function (d) {
                        return '<center>'+d.numero+'</center>';
                    }
                },
                {
                    data: function (d) {
                        if(d.id_sede == 1){
                            return '<center><p>San Luis Potosí</p></center>';
                        }else  if(d.id_sede == 2){
                            return '<center><p>Querétaro</p></center>';
                        }else  if(d.id_sede == 3){
                            return '<center><p>Península</p></center>';
                        }else  if(d.id_sede == 4){
                            return '<center><p>Ciudad de México</p></center>';
                        }else  if(d.id_sede == 5){
                            return '<center><p>León</p></center>';
                        }else  if(d.id_sede == 6){
                            return '<center><p>Cancún</p></center>';
                        }else  if(d.id_sede == 7){
                            return '<center><p>United States</p></center>';
                        }
                    }
                },
                {
                    data: function (d) {
                        return '<center><button class="btn-data btn-blueMaderas edit-num" data-id-usuario="' + d.idchatsede+","+d.numero+ '" title="Consultar"><i class="fas fa-pencil-alt"></i></button></center>';
                    }
                }],
            ajax: {
                "url": urlChat,
                "type": "POST",
                cache: false,
                "data": function( d ){}
            }
        });
    });

    $(document).on('click', '.edit-num', function(e){
        let valor = $(this).attr("data-id-usuario");
        let separar = valor.split(',');
        $('#idC').val(separar[0]);
        $('#num_chatS').val(separar[1]);
        $("#EditarChat").modal();
    });


    $("#formChat").on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("formChat"));
        formData.append("dato", "valor");
        $.ajax({
            type: 'POST',
            url: 'SaveNumeroChat',
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                // Actions before send post
            },
            success: function(data) {
                if (data == 1) {
                    $("#EditarChat").modal('hide');
                    alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                    chatsTable.ajax.reload();
                }
                else {
                    $("#EditarChat").modal('hide');
                    chatsTable.ajax.reload();
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function(){
                $("#EditarChat").modal('hide');
                chatsTable.ajax.reload();
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#btnenviar").on('click', function(e){
        let mensaje = $('#mensajeE').val();
        let numeros =  getNumbersInString(mensaje);
        if(numeros.length > 2 || mensaje.indexOf('@') >= 0){
            alerts.showNotification("top", "right", "No se permite ingresar teléfonos ni correos en este campo.", "warning");
        }
        else{
            updateDatos();
        }
    });

    let v2;
    $("#file-uploadE").on('change', function(e){
        v2 = document.getElementById("file-uploadE").files[0].name;
    });

    function updateDatos() {
        let val=0;
        if (v2 == undefined || v2 == '') { val =1; }
        else{ val=2; }

        var formData = new FormData(document.getElementById("EditarPerfilForm"));
        formData.append("dato", "valor");
        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>index.php/Chat/UpdatePerfilAs/'+val,
            data: formData,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) {
                if (data == 1) {
                    $("#EditarMiPerfil").modal('hide');
                    setTimeout('document.location.reload()',1000);
                    alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                }
                else {
                    $("#EditarMiPerfil").modal('hide');
                    alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                }
            },
            error: function(){
                $("#EditarMiPerfil").modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }

    function getNumbersInString(string) {
        var tmp = string.split("");
        var map = tmp.map(function(current){
            if (!isNaN(parseInt(current))) {
                return current;
            }
        });

        var numbers = map.filter(function(value) {
            return value != undefined;
        });

        return numbers.join("");
    }

</script>
</body>
</html>