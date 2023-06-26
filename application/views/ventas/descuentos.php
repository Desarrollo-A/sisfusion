<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
            if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="32"|| $this->session->userdata('id_rol')=="63" || $this->session->userdata('id_rol')=="70")
                $this->load->view('template/sidebar');
            else
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
        ?>

        <style type="text/css">
            .msj{
                z-index: 9999999;
            }
        </style>

        <!-- Modals -->
        <div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" id="form_espera_uno">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal-delete" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?=base_url()?>static/images/preview.gif" width="250" height="200"></center>
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles" name="roles" id="roles" required>
                                    <option value="">----Seleccionar-----</option>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 

                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj2" style="color: red;"></b>
                            <b id="sumaReal"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos2">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles2" name="roles2" id="roles2" required>
                                    <option value="">----Seleccionar-----</option>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>

                            <div class="form-group" id="loteorigen2">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="form-control directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible2" readonly name="idmontodisponible2" value="">
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto2" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="submit" id="btn_abonar2" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_descuentos" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center>
                            <img src="<?=base_url()?>static/images/preview.gif" width="250" height="200">
                        </center>
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">money_off</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Descuentos de comisiones</h3>
                                    <p class="card-title pl-1">(Descuentos aplicados a usuarios, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Nueva, sin solicitar')</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Total descuentos sin aplicar:</h4>
                                                    <p class="input-tot pl-1" name="totalpv" id="totalp">$0.00</p>
                                                </div>
                                            </div>

                                            <?php if($this->session->userdata('id_rol') != 63){?>


                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Desc. pagos nuevos sin solicitar</button>
                                                </div>
                                            </div>
                                            


                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <button ype="button" class="btn-data-gral" data-toggle="modal" data-target="#miModal2">Desc. pagos en revisión contraloria</button>
                                                </div>
                                            </div>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_descuentos" name="tabla_descuentos">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>USUARIO</th>
                                                        <th>$ DESCUENTO</th>
                                                        <th>LOTE</th>
                                                        <th>MOTIVO</th>
                                                        <th>ESTATUS</th>
                                                        <th>CREADO POR</th>
                                                        <th>FECHA CAPTURA</th>
                                                        <th>OPCIONES</th>
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
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>rolPermission = <?= $this->session->userdata('id_rol') ?>;</script>

<script>


        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var totaPen = 0;
        var tr;
        
        $("#form_descuentos").on('submit', function(e){ 
            $("#idloteorigen").prop("disabled", false);
            e.preventDefault();
            document.getElementById('btn_abonar').disabled=true;
            let formData = new FormData(document.getElementById("form_descuentos"));
            formData.append("dato", "valor");
            $.ajax({
                url: 'saveDescuento/'+1,
                data: formData,
                method: 'POST',
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    if (data == 1) {
                        document.getElementById("form_descuentos").reset();
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        $('#idloteorigen option').remove();
                        $("#roles").val('');
                        $("#roles").selectpicker("refresh");
                        $('#usuarioid').val('default');
                        $("#usuarioid").selectpicker("refresh");
                        document.getElementById('sumaReal').innerHTML = '';
                        document.getElementById('btn_abonar').disabled=false;
                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
                    }
                    else if(data == 2) {
                        document.getElementById('btn_abonar').disabled=false;

                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                        $(".directorSelect2").empty();
                    }
                    else if(data == 3){
                        document.getElementById('btn_abonar').disabled=false;

                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                        $(".directorSelect2").empty();
                    }
                },
                error: function(){
                    document.getElementById('btn_abonar').disabled=false;
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $("#form_descuentos2").on('submit', function(e){ 
            document.getElementById('btn_abonar2').disabled=true;
            $("#idloteorigen2").prop("disabled", false);
            e.preventDefault();

            let formData = new FormData(document.getElementById("form_descuentos2"));
            formData.append("dato", "valor");
            $.ajax({
                url: 'saveDescuento/'+2,
                data: formData,
                method: 'POST',
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    if (data == 1) {
                        document.getElementById('btn_abonar2').disabled=false;
                        document.getElementById("form_descuentos2").reset();
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal2').modal('hide');
                        $('#idloteorigen2 option').remove();
                        $("#roles2").val('');
                        $("#roles2").selectpicker("refresh");
                        $('#usuarioid2').val('default');
                        $("#usuarioid2").selectpicker("refresh");
                        document.getElementById('sumaReal2').innerHTML = '';
                        document.getElementById('btn_abonar2').disabled=true;

                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
                    }
                    else if(data == 2) {
                        document.getElementById('btn_abonar2').disabled=false;

                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                        $(".directorSelect2").empty();
                    }
                    else if(data == 3){
                        document.getElementById('btn_abonar2').disabled=false;

                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                        $(".directorSelect2").empty();
                    }
                },
                error: function(){
                    document.getElementById('btn_abonar2').disabled=false;
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $("#tabla_descuentos").ready( function(){
            let titulos = [];
            $('#tabla_descuentos thead tr:eq(0) th').each( function (i) {
                if(i!=8){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {

                        if (tabla_nuevas.column(i).search() !== this.value ) {
                            tabla_nuevas.column(i).search(this.value).draw();

                            var total = 0;
                            var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                            var data = tabla_nuevas.rows( index ).data();

                            $.each(data, function(i, v){
                                total += parseFloat(v.monto);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("totalp").textContent = to1;
                        }
                    });
                }
            });

            $('#tabla_descuentos').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.monto);
                });
                var to = formatMoney(total);
                document.getElementById("totalp").textContent = '$' + to;
            });
    
            tabla_nuevas = $("#tabla_descuentos").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'DESCUENTOS_SIN_APPLICAR',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID';
                                }else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'MONTO DESCUENTO';
                                }else if(columnIdx == 3){
                                    return 'NOMBRE LOTE';
                                }else if(columnIdx == 4){
                                    return 'MOTIVO';
                                }else if(columnIdx == 5){
                                    return 'ESTATUS';
                                }else if(columnIdx == 6){
                                    return 'CREADO POR';
                                }else if(columnIdx == 7){
                                    return 'FECHA CAPTURA';
                                }else if(columnIdx != 8 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
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
                    "width": "5%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_pago_i+'</p>';
                    }
                },
                {
                    "width": "13%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.usuario+'</p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.monto)+'</p>';
                    }
                },
                {
                    "width": "11%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },
                {
                    "width": "13%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.motivo+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        if(d.estatus == 16 || d.estatus == '16'){
                            return '<span class="label label-success">APLICADO</span>'; 
                        }else{
                            return '<span class="label label-warning">INACTIVO</span>'; 
                        }
                        
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.modificado_por+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.fecha_abono+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function( d ){

                        
                        if((d.estatus != 16 || d.estatus != '16') && (rolPermission != 63)){
                            return '<div class="d-flex justify-center"><button class="btn-data btn-green btn-update" value="'+d.id_pago_i+','+d.monto+','+d.usuario+','+d.nombreLote+'"><i class="material-icons" data-toggle="tooltip" data-placement="right" title="APROBAR DESCUENTO">check</i></button></div>';
                        }
                        else{
                            return '';
                        }

                        

                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    searchable:true,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getdescuentos",
                    type: "POST",
                    cache: false,
                    data: function( d ){}
                },
            });

            /**------------------------------------------- */
            $("#tabla_descuentos tbody").on("click", ".abonar", function(){    
                bono = $(this).val();
                var dat = bono.split(",");
                $("#modal_abono .modal-body").append(`<div id="inputhidden">
                <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">$${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6>
                <input type='hidden' name="id_bono" id="id_bono" value="${dat[0]}"><input type='hidden' name="pago" id="pago" value="${dat[1]}"><input type='hidden' name="id_usuario" id="id_usuario" value="${dat[2]}">
            
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <button type="submit" id="" class="btn btn-primary ">GUARDAR</button>
                    </div>
                    <div class="col-md-3">
                    <button type="button" onclick="closeModalEng()" class=" btn btn-danger" data-dismiss="modal">CANCELAR</button>
                    </div>
                    <div class="col-md-3"></div>

                    </div>`);
                $("#modal_abono .modal-body").append(``);
                $('#modal_abono').modal('show');
            });

            $("#tabla_descuentos tbody").on("click", ".btn-delete", function(){    
                id = $(this).val();
                $("#modal-delete .modal-body").append(`<div id="borrarBono"><form id="form-delete">
                <h5>¿Estas seguro que deseas eliminar este bono?</h5>
                <br>
                <input type="hidden" id="id_descuento" name="id_descuento" value="${id}">
                <input type="submit" class="btn btn-success" value="Aceptar">
                <button class="btn btn-danger" onclick="CloseModalDelete2();">Cerrar</button>
                </form></div>`);

                $('#modal-delete').modal('show');
            });


            $("#tabla_descuentos tbody").on("click", ".btn-update", function(){
                var tr = $(this).closest('tr');
                var row = tabla_nuevas.row( tr );

                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Seguro que desea descontar a <b>'+row.data().usuario+'</b> la cantidad de <b style="color:red;">$'+formatMoney(row.data().monto)+'</b> correspondiente al lote <b>'+row.data().nombreLote+'</b> ?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_pago_i+'"><br><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></p></div></div>');
                $("#modal_nuevas").modal();
            });
        });
        /**-------------------------------------------------- */

        function closeModalEng(){
            document.getElementById("form_abono").reset();
            a = document.getElementById('inputhidden');
            padre = a.parentNode;
            padre.removeChild(a);
        
            $("#modal_abono").modal('toggle');
        }

        function CloseModalDelete(){
            a = document.getElementById('borrarBono');
            padre = a.parentNode;
            padre.removeChild(a);
            $("#modal-delete").modal('toggle');
        }

        function CloseModalDelete2(){
            document.getElementById("form-delete").reset();
            a = document.getElementById('borrarBono');
            padre = a.parentNode;
            padre.removeChild(a);
        
            $("#modal-delete").modal('toggle');
        }

        function CloseModalUpdate2(){
            document.getElementById("form-update").reset();
            a = document.getElementById('borrarUpdare');
            padre = a.parentNode;
            padre.removeChild(a);
        
            $("#modal-abono").modal('toggle');
        }

        $(document).on('submit','#form-delete', function(e){ 
            e.preventDefault();
            var formData = new FormData(document.getElementById("form-delete"));
            formData.append("dato", "valor");
            $.ajax({
                method: 'POST',
                url: url+'Comisiones/BorrarDescuento',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    if (data == 1) {
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        CloseModalDelete2();
                        alerts.showNotification("top", "right", "Abono borrado con exito.", "success");
                        document.getElementById("form_abono").reset();
                    } else if(data == 0) {
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        CloseModalDelete2();
                        alerts.showNotification("top", "right", "Pago liquidado.", "warning");
                    }
                },
                error: function(){
                    closeModalEng();
                    $('#modal_abono').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $("#form_aplicar").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );

                data.append("id_pago_i", id_pago_i);
                $.ajax({
                    url: url+'Comisiones/UpdateDescuento',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data = 1 ){
                            $("#modal_nuevas").modal('toggle' );
                            alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                            setTimeout(function() {
                                tabla_nuevas.ajax.reload();
                            }, 3000);
                        }else{
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function mandar_espera(idLote, nombre) {
            idLoteespera = idLote;
            link_espera1 = "Comisiones/generar comisiones/";
            $("#myModalEspera .modal-footer").html("");
            $("#myModalEspera .modal-body").html("");
            $("#myModalEspera ").modal();
            $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
        }

        $(window).resize(function(){
            tabla_nuevas.columns.adjust();
        });

        function formatMoney( n ) {
            var c = isNaN(c = Math.abs(c)) ? 3 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        /**.---------------------------ROLES------------------------------------------ */
        $("#roles").change(function() {
            var parent = $(this).val();
            document.getElementById('monto').value = ''; 
            document.getElementById('idmontodisponible').value = ''; 
            document.getElementById('comentario').value = '';
            document.getElementById('sumaReal').innerHTML = '';
            $('#idloteorigen option').remove();

            $('#usuarioid option').remove();
            $.post('getUsuariosRol/'+parent+"/"+1, function(data) {
                $("#usuarioid").append($('<option>').val("0").text("Seleccione una opción"));
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id_usuario'];
                    var name = data[i]['name_user'];
            
                    $("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if(len<=0){
                    $("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#usuarioid").selectpicker('refresh');
            }, 'json'); 
        });

        $("#roles2").change(function() {
            var parent = $(this).val();
            document.getElementById('monto2').value = ''; 
            document.getElementById('idmontodisponible2').value = '';
            document.getElementById('sumaReal2').innerHTML = '';
            document.getElementById('comentario2').value = '';
            document.getElementById('sumaReal2').innerHTML = '';

            $('#usuarioid2 option').remove();
            $('#idloteorigen2 option').remove();
    
            $.post('getUsuariosRol/'+parent, function(data) {
                $("#usuarioid2").append($('<option>').val("0").text("Seleccione una opción"));
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var id = data[i]['id_usuario'];
                    var name = data[i]['name_user'];
            
                    $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
                }

                if(len<=0){
                    $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#usuarioid2").selectpicker('refresh');
            }, 'json'); 
        });

        /**----------------------------FIN ROLES---------------------- */
        $("#idloteorigen").select2({dropdownParent:$('#miModal')});
        $("#idloteorigen2").select2({dropdownParent:$('#miModal2')});

        /**-----------------------------LOTES----------------------- */   
        $("#usuarioid").change(function() {
            document.getElementById('monto').value = ''; 
            document.getElementById('idmontodisponible').value = ''; 
            document.getElementById('comentario').value = '';
            document.getElementById('montodisponible').innerHTML = '';
            document.getElementById('sumaReal').innerHTML = '';
            
            var user = $(this).val();
            $('#idloteorigen option').remove(); // clear all values
            $.post('getLotesOrigen/'+user+'/'+1, function(data) {
                $("#idloteorigen").append($('<option disabled>').val("default").text("Seleccione una opción"));
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];

                    
                    $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(3)},${pago_neodata}'>${name}  -   $${ formatMoney(comtotal.toFixed(3))}</option>`);
                }

                if(len<=0){
                    $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }else{
                    console.log('dfsdfsf');
                    //$('#idloteorigen').select2('data').disabled = true;
                    $("#idloteorigen").prop("disabled", true);
                    
                //    $("#idloteorigen").selectpicker('refresh');
                }
                $("#idloteorigen").selectpicker('refresh');
            }, 'json');     
            document.getElementById("monto").focus();
            alerts.showNotification("top", "right", "Debe ingresar el monto a descontar, antes de seleccionar pagos.", "warning"); 
        });
        
        $("#usuarioid2").change(function() {
            document.getElementById('monto2').value = ''; 
            document.getElementById('idmontodisponible2').value = '';
            document.getElementById('comentario2').value = '';
            document.getElementById('montodisponible2').innerHTML = ''; 
            document.getElementById('sumaReal2').innerHTML = '';

            var user = $(this).val();
            $('#idloteorigen2 option').remove(); // clear all values
            $.post('getLotesOrigen/'+user+'/'+2, function(data) {
                $("#idloteorigen2").append($('<option disabled>').val("default").text("Seleccione una opción"));
                var len = data.length;
            
                for( var i = 0; i<len; i++){
                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];
                    
                    $("#idloteorigen2").append(`<option value='${comision},${comtotal.toFixed(3)},${pago_neodata}'>${name}  -   $${ formatMoney(comtotal.toFixed(3))}</option>`);
                }

                if(len<=0){
                    $("#idloteorigen2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }else{
                    $("#idloteorigen2").prop("disabled", true);
                }

                $("#idloteorigen2").selectpicker('refresh');
            }, 'json'); 
        });

        /**--------------------------------------------------- */
        $("#idloteorigen").change(function() {
            let cuantos = $('#idloteorigen').val().length;
            let suma =0;
            
            if(cuantos > 1){
                var comision = $(this).val();
                for (let index = 0; index < $('#idloteorigen').val().length; index++) {
                    datos = comision[index].split(',');
                    let id = datos[0];
                    let monto = datos[1];
                   // document.getElementById('monto').value = ''; 
                    
                    $.post('getInformacionData/'+id+'/'+1, function(data) {
                        var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                        var idecomision = data[0]['id_pago_i'];
                        suma = suma + disponible;
                        document.getElementById('montodisponible').innerHTML = '';
                        document.getElementById('sumaReal').innerHTML = 'Suma real:'+suma;
                        $("#idmontodisponible").val('$'+formatMoney(suma));
                        $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma+'">');
                        $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
            
                        var len = data.length;
                        if(len<=0){
                            $("#idmontodisponible").val('$'+formatMoney(0));
                        }
                        
                        $("#montodisponible").selectpicker('refresh');
                        verificarMontos();
                    }, 'json');
                }
            }
            else if(cuantos == 1){
                var comision = $(this).val();
                datos = comision[0].split(',');
                let id = datos[0];
                let monto = datos[1];
                //document.getElementById('monto').value = ''; 
                $.post('getInformacionData/'+id+'/'+1, function(data) {
                    var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                
                    document.getElementById('montodisponible').innerHTML = '';
                    document.getElementById('sumaReal').innerHTML = 'Suma real:'+disponible;
                    $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
                    $("#idmontodisponible").val('$'+formatMoney(disponible));
                
                    $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');
                                
                    var len = data.length;
                    if(len<=0){
                        $("#idmontodisponible").val('$'+formatMoney(0));
                    }

                    $("#montodisponible").selectpicker('refresh');
                    verificarMontos();
                }, 'json'); 
            }else {
                document.getElementById('montodisponible').innerHTML = '';
                    document.getElementById('sumaReal').innerHTML = '';
                $("#montodisponible").append('');
                $("#idmontodisponible").val(0);
            }

        });

        $("#idloteorigen2").change(function() {
            let cuantos = $('#idloteorigen2').val().length;
            let suma =0;
            if(cuantos > 1){
                var comision = $(this).val();
                for (let index = 0; index < $('#idloteorigen2').val().length; index++) {
                    datos = comision[index].split(',');
                    let id = datos[0];
                    let monto = datos[1];
                    //document.getElementById('monto2').value = ''; 
                    $.post('getInformacionData/'+id+'/'+2, function(data) {
                        var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                        var idecomision = data[0]['id_pago_i'];
                        suma = suma + disponible;
                        document.getElementById('montodisponible2').innerHTML = '';
                        document.getElementById('sumaReal2').innerHTML = 'Suma real:'+suma;
                        $("#idmontodisponible2").val('$'+formatMoney(suma));
                        $("#montodisponible2").append('<input type="hidden" name="valor_comision2" id="valor_comision2" value="'+suma+'">');
                        $("#montodisponible2").append('<input type="hidden" name="ide_comision2" id="ide_comision2" value="'+idecomision+'">');
                    
                        var len = data.length;
                        if(len<=0){
                            $("#idmontodisponible2").val('$'+formatMoney(0));
                        }
                        
                        $("#montodisponible2").selectpicker('refresh');
                        verificarMontos2();
                    }, 'json');
                }
            }
            else if(cuantos == 1){
                var comision = $(this).val();
                datos = comision[0].split(',');
                let id = datos[0];
                let monto = datos[1];
               // document.getElementById('monto2').value = ''; 
                $.post('getInformacionData/'+id+'/'+2, function(data) {
                    var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                    document.getElementById('montodisponible2').innerHTML = '';
                    document.getElementById('sumaReal2').innerHTML = 'Suma real:'+disponible;
                    $("#montodisponible2").append('<input type="hidden" name="valor_comision2" id="valor_comision2" value="'+disponible+'">');
                    $("#idmontodisponible2").val('$'+formatMoney(disponible));
                
                    $("#montodisponible2").append('<input type="hidden" name="ide_comision2" id="ide_comision2" value="'+idecomision+'">');
                                
                    var len = data.length;
                    if(len<=0){
                        $("#idmontodisponible2").val('$'+formatMoney(0));
                    }
                    $("#montodisponible2").selectpicker('refresh');
                    verificarMontos2();
                }, 'json'); 

            }else {
                document.getElementById('montodisponible2').innerHTML = '';
                    document.getElementById('sumaReal2').innerHTML = '';
                $("#montodisponible2").append('');
                $("#idmontodisponible2").val(0);
            }
        });

        /**---------------------------------------------------------------------- */
        $("#numeroP").change(function(){
            let monto = parseFloat($('#monto').val());
            let cantidad = parseFloat($('#numeroP').val());
            let resultado=0;

            if (isNaN(monto)) {
                alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
                $('#pago').val(resultado);
                document.getElementById('btn_abonar').disabled=true;
            }
            else{
                resultado = monto /cantidad;
    
                if(resultado > 0){
                    document.getElementById('btn_abonar').disabled=false;
                    $('#pago').val(formatMoney(resultado));
                }
                else{
                    document.getElementById('btn_abonar').disabled=true;
                    $('#pago').val(formatMoney(0));
                }
            }
        });

        $("#numeroP2").change(function(){
        
            let monto = parseFloat($('#monto2').val());
            let cantidad = parseFloat($('#numeroP2').val());
            let resultado=0;

            if (isNaN(monto)) {
                alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
                $('#pago2').val(resultado);
                document.getElementById('btn_abonar2').disabled=true;
            }
            else{
                resultado = monto /cantidad;
                if(resultado > 0){
                    document.getElementById('btn_abonar2').disabled=false;
                    $('#pago2').val(formatMoney(resultado));
                }
                else{
                    document.getElementById('btn_abonar2').disabled=true;
                    $('#pago2').val(formatMoney(0));
                }
            }
        });

        function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
         }
        function verificarMontos(){
            
            // let disponible = parseFloat($('#valor_comision').val()).toFixed(2);
             let disponible = replaceAll($('#valor_comision').val(), '$', '');
             disponible = replaceAll(disponible, ',', '');
            // let monto = parseFloat($('#monto').val()).toFixed(2);
             let monto = replaceAll($('#monto').val(), ',', '');
             //monto = replaceAll(monto, ',', '');
             let cuantos = $('#idloteorigen').val().length;
             console.log(monto);
             console.log(disponible);
             if(parseFloat(monto) <= parseFloat(disponible) ){
                 $("#idloteorigen").prop("disabled", true);
                 $("#btn_abonar").prop("disabled", false);    
                     let cantidad = parseFloat($('#numeroP').val());
                     resultado = monto /cantidad;
                     $('#pago').val(formatMoney(resultado));
                     document.getElementById('btn_abonar').disabled=false;
 
                   
                     let cadena = '';
                     var data = $('#idloteorigen').select2('data')
                     for (let index = 0; index < cuantos; index++) {
                         let datos = data[index].id;
                         let montoLote = datos.split(',');
                         /*let abono_neo = montoLote[1];
                         if(parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1){
                             document.getElementById('msj2').innerHTML="El monto ingresado se cubre con la comisión "+data[index].text;
                             document.getElementById('btn_abonar').disabled=true; 
                             break;  
                         }*/
                         cadena = cadena+' , '+data[index].text;
                         document.getElementById('msj2').innerHTML='';
                     }
                     $('#comentario').val('Lotes involucrados en el descuento: '+cadena+'. Por la cantidad de: $'+formatMoney(monto));
                 }
                 else if(parseFloat(monto) > parseFloat(disponible) ){
                    // alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
                     
                     //document.getElementById('monto').value = ''; 
                     document.getElementById('btn_abonar').disabled=true; 
                 }
         }
         /*function verificar(){
             let disponible = replaceAll($('#valor_comision').val(), '$', '');
             disponible = replaceAll(disponible, ',', '');
             let monto = replaceAll($('#monto').val(), ',', '');
            
             if(parseFloat(monto) < 1 || isNaN(monto)){
                 alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
                 document.getElementById('btn_abonar').disabled=true; 
             }
             else{
                 console.log(disponible)
                 console.log(monto)
 
                 if(parseFloat(disponible) > parseFloat(monto)){
                     $("#idloteorigen").prop("disabled", true);
                 }else{
                     $("#idloteorigen").prop("disabled", false);
                 }
                 console.log('essfsf');     
             }      
         }*/
 
          function verificar(){
             let disponible = $('#valor_comision').val();
             //
             let monto = replaceAll($('#monto').val(), ',', '');
              monto = replaceAll(monto, '$', '');
             // let monto = parseFloat($('#monto').val()).toFixed(2);
              if(monto < 1 || isNaN(monto)){
                  alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
                  document.getElementById('btn_abonar').disabled=true; 
              }
              else{
                 console.log(disponible)
                 console.log(monto)
                 if(disponible !== '' && disponible !== undefined && disponible !== 'undefined'){
                     disponible = replaceAll($('#valor_comision').val(), '$', '');
                     disponible = replaceAll(disponible, ',', '');
                     if(parseFloat(disponible) >= parseFloat(monto)){
                     $("#idloteorigen").prop("disabled", true);
                     document.getElementById('btn_abonar').disabled=false; 
                     }else{
                         $("#idloteorigen").prop("disabled", false);
                         document.getElementById('btn_abonar').disabled=true; 
                     }
                 }else{
                     $("#idloteorigen").prop("disabled", false);
                 }       
              }      
          }
          function verificarMontos2(){
             
             // let disponible = parseFloat($('#valor_comision').val()).toFixed(2);
              let disponible = replaceAll($('#valor_comision2').val(), '$', '');
              disponible = replaceAll(disponible, ',', '');
             // let monto = parseFloat($('#monto').val()).toFixed(2);
              let monto = replaceAll($('#monto2').val(), ',', '');
              //monto = replaceAll(monto, ',', '');
              let cuantos = $('#idloteorigen2').val().length;
              console.log(monto);
              console.log(disponible);
              if(parseFloat(monto) <= parseFloat(disponible) ){
                  $("#idloteorigen2").prop("disabled", true);
                  $("#btn_abonar2").prop("disabled", false);
                      let cantidad = parseFloat($('#numeroP2').val());
                      resultado = monto /cantidad;
                      $('#pago2').val(formatMoney(resultado));
                      document.getElementById('btn_abonar2').disabled=false;
  
                    
                      let cadena = '';
                      var data = $('#idloteorigen2').select2('data')
                      for (let index = 0; index < cuantos; index++) {
                          let datos = data[index].id;
                          let montoLote = datos.split(',');
                          /*let abono_neo = montoLote[1];
                          if(parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1){
                              document.getElementById('msj2').innerHTML="El monto ingresado se cubre con la comisión "+data[index].text;
                              document.getElementById('btn_abonar').disabled=true; 
                              break;  
                          }*/
                          cadena = cadena+' , '+data[index].text;
                          document.getElementById('msj').innerHTML='';
                      }
                      $('#comentario2').val('Lotes involucrados en el descuento: '+cadena+'. Por la cantidad de: $'+formatMoney(monto));
                  }
                  else if(parseFloat(monto) > parseFloat(disponible) ){
                     // alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
                      
                      //document.getElementById('monto').value = ''; 
                      document.getElementById('btn_abonar2').disabled=true; 
                  }
          }
 
         function verificar2(){
             let disponible = $('#valor_comision2').val();
             let monto = replaceAll($('#monto2').val(), ',', '');
              monto = replaceAll(monto, '$', '');
             if(monto < 1 || isNaN(monto)){
                 alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
                 document.getElementById('btn_abonar2').disabled=true; 
             }
             else{
                 console.log(disponible)
                 if(disponible != '' && disponible !== undefined && disponible != 'undefined'){
                     disponible = replaceAll(disponible, '$', '');
                     disponible = replaceAll(disponible, ',', '');

                     if(parseFloat(disponible) >= parseFloat(monto)){
                     $("#idloteorigen2").prop("disabled", true);
                     document.getElementById('btn_abonar2').disabled=false; 
                     }else{
                         $("#idloteorigen2").prop("disabled", false);
                         document.getElementById('btn_abonar2').disabled=true; 
                     }
                 }else{
                     $("#idloteorigen2").prop("disabled", false);
                 }            }    
         }
    </script>

 

</body>