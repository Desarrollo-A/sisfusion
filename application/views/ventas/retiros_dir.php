<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">
            ul.timeline {
                list-style-type: none;
                position: relative;
            }
            ul.timeline:before {
                content: ' ';
                background: #d4d9df;
                display: inline-block;
                position: absolute;
                left: 29px;
                width: 2px;
                height: 80%;
                z-index: 400;
            }
            ul.timeline > li {
                margin: 20px 0;
                padding-left: 60px;
            }
            ul.timeline > li:before {
                content: ' ';
                background: white;
                display: inline-block;
                position: absolute;
                border-radius: 50%;
                border: 3px solid #22c0e8;
                left: 20px;
                width: 20px;
                height: 20px;
                z-index: 400;
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
                    <div class="modal-header bg-red"></div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_log" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="bod"></div>
                </div>
            </div>
        </div>
   
        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?=base_url()?>static/images/preview.gif" width="250" height="200"></center>
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
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Descuentos de resguardos</h3>
                                    <p class="card-title pl-1">( Descuentos aplicados a directivos, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Enviada a resguardo personal'.)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Total reguardo:</h4>
                                                    <p class="input-tot pl-1" name="totalpv" id="totalp">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Ingresos extras:</h4>
                                                    <p class="input-tot pl-1" name="totalx" id="totalx">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Saldo disponible:</h4>
                                                    <p class="input-tot pl-1" name="totalpv3" id="totalp3">$0.00</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Descuentos aplicados:</h4>
                                                    <p class="input-tot pl-1" name="totalpv2" id="totalp2">$0.00</p>
                                                </div>
                                            </div>
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
    <script>
        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var totaPen = 0;
        var tr;

        var id_user_session = "<?=$this->session->userdata('id_usuario')?>"
        7
        
        function formatMoney( n ) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };


        $("#form_descuentos").on('submit', function(e){ 
            e.preventDefault();
            let userid =  $('#usuarioid').val();
        
            let formData = new FormData(document.getElementById("form_descuentos"));
            formData.append("dato", "valor");
            $.ajax({
                url: 'saveRetiro',
                data: formData,
                method: 'POST',
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    console.log(data);
                    if (data == 1) {
                        document.getElementById("form_descuentos").reset();
                        $('#miModal').modal('hide');
                        
                        DescuentosxDirectivos(userid);
                        $("#roles").val('');
                        $("#roles").selectpicker("refresh");
                        $('#usuarioid').val('default');
                        $("#usuarioid").selectpicker("refresh");
                        $('#filtro33').val('default');
                        $("#filtro33").selectpicker("refresh");

                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");
                    
                    }
                    else if(data == 2) {
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                    }
                    else if(data == 3){
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                    }
                },
                error: function(){
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        let titulos = [];
        $('#tabla_descuentos thead tr:eq(0) th').each( function (i) {
            if(i!=7){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (tabla_nuevas.column(i).search() !== this.value ) {
                        tabla_nuevas
                        .column(i)
                        .search(this.value)
                        .draw();

                        var total = 0;
                        var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
                        var data = tabla_nuevas.rows( index ).data();

                        let to1=0;
                    }
                });
            }
        });
    
        $("#tabla_ingresar_9").ready( function(){
            let titulos = [];
            $('#tabla_ingresar_9 thead tr:eq(0) th').each( function (i) {
                if(i != 0 && i != 11){
                    var title = $(this).text();
                    titulos.push(title);
                    
                    $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                    $('input', this ).on('keyup change', function () {
                        if (tabla_1.column(i).search() !== this.value ) {
                            tabla_1
                            .column(i)
                            .search(this.value)
                            .draw();
                        }
                    });
                }
            });

            let resto = 0;
            let total67 = 0;
            $.post('getDisponbleResguardo/' + id_user, function(data) {
                document.getElementById('totalp3').textContent = '';
                let disponible = formatMoney(data.toFixed(3));
                document.getElementById('totalp3').textContent = disponible;
                resto = 0;
                resto = data.toFixed(3);
            }, 'json');

            $.post('getDisponbleResguardoP/' + id_user, function(data) {
                document.getElementById('totalp').textContent = '';
                let disponible = formatMoney(data);
                document.getElementById('totalp').textContent = disponible;
                total67 = data;
            }, 'json');


            $('#tabla_descuentos').on('xhr.dt', function(e, settings, json, xhr) {
                document.getElementById('totalp2').textContent = '';

                var total = 0;
                let sumaExtras=0;
                $.each(json.data, function(i, v) {
                    if (v.estatus != 3 && v.estatus != 67) {
                        total += parseFloat(v.monto);
                    }
                    if(v.estatus == 67){
                        sumaExtras=sumaExtras +parseFloat(v.monto);
                    }
                });
                let to = 0;
                to = formatMoney(total);
                document.getElementById("totalp2").textContent = to;

                let extra = 0;
                extra = formatMoney(sumaExtras);
                document.getElementById("totalx").textContent = extra;
                
                let to2 = 0;
                to2 = parseFloat(resto) + parseFloat(total);
            });

            tabla_nuevas = $("#tabla_descuentos").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'RETIROS',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' ID ';
                                }else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'MONTO DESCUENTO';
                                }else if(columnIdx == 3){
                                    return 'MOTIVO';
                                }else if(columnIdx == 4){
                                    return 'ESTATUS';
                                }else if(columnIdx == 5){
                                    return 'CREADO POR';
                                }else if(columnIdx == 6){
                                    return 'FECHA CAPTURA';
                                }
                                else if(columnIdx != 7 && columnIdx !=0){
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
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_rc + '</p>';
                    }
                },
                {
                    "width": "13%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.usuario + '</b></p>';
                    }
                },

                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.monto) + '</p>';
                    }
                },

                {
                    "width": "13%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.conceptos + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        if (d.estatus == 1) {
                            return '<span class="label label-warning">ACTIVO</span>';
                        } else if (d.estatus == 3) {
                            return '<span class="label label-danger">CANCELADO</span>';
                        } else if (d.estatus == 2) {
                            return '<span class="label label-success">APROBADO</span>';
                        } else if (d.estatus == 4) {
                            return '<span class="label label-danger">RECHAZADO DIRECTIVO</span>';
                        }else if (d.estatus == 67) {
                            return '<span class="label label-info">INGRESO EXTRA</span>';
                        }

                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.creado_por + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function(d) {
                        let fecha = d.fecha_creacion.substring(0, d.fecha_creacion.length - 4);
                        return '<p class="m-0">' + fecha + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function( d ){

                        if(id_user_session == 1875 ){
                                if(d.estatus == 3 || d.estatus == 4 || d.estatus == 2){
                                    return `<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas btn-log" value="${d.id_rc}" title="LOG"><i class="fas fa-info"></i></button></div>`; 
                                } else{
                                    return ``;
                                }
                        }
                        else{
                            if(d.estatus == 1){
                            return `<div class="d-flex justify-center"><button class="btn-data btn-warning btn-delete" value="'+d.id_rc+','+d.monto+','+d.usuario+'" title="RECHAZAR RETIRO"><i class="fas fa-trash"></i></button>
                            <button class="btn-data btn-green btn-aut" value="${d.id_rc},${d.monto},${d.usuario}" title="APROBAR RETIRO"><i class="fas fa-check"></i></button></div>`;

                        }
                        else if(d.estatus == 3 || d.estatus == 4 || d.estatus == 2){
                            return `<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas btn-log" value="${d.id_rc}" title="LOG"><i class="fas fa-info"></i></button></div>`; 
                        } else{
                            return ``;
                        }

                        }
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0,
                    searchable:false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getRetiros/"+id_user+'/'+1,                    
                    type: "POST",
                    cache: false,
                    data: function( d ){
                    }
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

            $("#tabla_descuentos tbody").on("click", ".btn-aut", function(){
                var tr = $(this).closest('tr');
                var row = tabla_nuevas.row( tr );

                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-header").html("");
                $("#modal_nuevas .modal-header").append(`<h3>Autorizar</h3>`);
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Seguro que desea autorizar a <b>'+row.data().usuario+'</b> la cantidad de <b style="color:red;">$'+formatMoney(row.data().monto)+'</b>?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_rc+'"><input type="hidden" name="opcion" id="opcion" value="Autorizar"><br><div><input type="submit"  class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></p></div></div>');
                $("#modal_nuevas").modal();
            });

            $("#tabla_descuentos tbody").on("click", ".btn-delete", function(){
                var tr = $(this).closest('tr');
                var row = tabla_nuevas.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-header").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Está seguro que desea borrar el pago de <b>'+row.data().usuario+'</b> por la cantidad de <b style="color:red;">$'+formatMoney(row.data().monto)+'</b>?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_rc+'"> <input type="hidden" id="userid" name="userid" value="'+id_user+'"><input type="hidden" name="opcion" id="opcion" value="Rechazar"><br><div class="form-group"><label>Motivo de eliminación</label><textarea class="form-control" id="motivodelete" name="motivodelete"></textarea></div><br><div class="text-right"><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></p></div></div>');
                $("#modal_nuevas").modal();
            });

            $("#tabla_descuentos tbody").on("click", ".btn-log", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_rc = $(this).val();
                document.getElementsByClassName('modal_body').innerHTML = '';
                $("#modal_log .modal-body").append("");
                $("#modal_log .modal-body").html("");
                $("#modal_log .modal-body").html("");
                $("#modal_log .modal-body").append(`<h3><b>Historial</b></h3><br>`);
                $("#modal_log .modal-body .timeline").html("");
                $.post("<?=base_url()?>index.php/Comisiones/getHistoriRetiros/"+id_rc, function (data) {
                    var len = data.length;
                    console.log(data);
                    let c=0;
                    $("#modal_log .modal-body").append(`
                    <div class="row mt-5 mb-5">
                        <div class="col-md-12 offset-md-3">
                            <ul class="timeline">`);
                            for (var i = 0; i < len; i++) {
                                if(c > 1){
                                    break;
                                }
                                let fecha = data[i].fecha_creacion.substring(0, data[i].fecha_creacion.length - 4);
                                $("#modal_log .modal-body .timeline").append(`
                                <li>
                                    <em><b>Fecha creación: </b>${fecha}</em><br>
                                    <em><b>Autor:</b> ${data[i].usuario} </em>
                                    <p><b>Movimiento: </b>${data[i].comentario}</p>
                                </li>`);
                                if(i == len){
                                    c=c+1;
                                }
                                
                            }
                            $("#modal_log .modal-body").append(`</ul>
                        </div>
                    </div><div class="text-right">
                    <button type="button" class="btn btn-danger" onclick="cerrar();" data-dismiss="modal">Cerrar</button></div></p></div></div>`);
                }, 'json');

                $("#modal_log").modal();
            });

            $("#tabla_descuentos tbody").on("click", ".btn-update", function(){
                var tr = $(this).closest('tr');
                var row = tabla_nuevas.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-header").html("");
                $("#modal_nuevas .modal-header").append(`<h3><b>Actualizar Información</b></h3>`);
                $("#modal_nuevas .modal-body").append(`<div class="row"><div class="col-lg-12">
                <div class="form-group">
                <label>Monto</label>
                <input type="number" class="form-control" onblur="verificar2(${resto},${row.data().monto})" name="monto" id="monto" value="${row.data().monto}">
                <input type="hidden" id="userid" name="userid" value="${user}">
                </div>
                <div class="form-group">
                <label>Motivo</label>
                <textarea class="form-control" id="conceptos" name="conceptos">${row.data().conceptos}</textarea>
                </div>
                <input type="hidden" name="id_descuento" id="id_descuento" value="${row.data().id_rc}"><input type="hidden" name="opcion" id="opcion" value="Actualizar"><br><div class="text-right"><input type="submit"  class="btn btn-success" id="btnsub" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div></p></div></div>`);
                $("#modal_nuevas").modal();
            });
        });
            
        function verificar2(resto,monto){
            let montoingresado = $('#monto').val();
            let resta = parseFloat(montoingresado) - parseFloat(monto);

            if(parseFloat(resto) > resta){
                document.getElementById('btnsub').disabled = false;
            }
            else{
                alerts.showNotification("top", "right", "Monto excedido.", "warning");
                document.getElementById('btnsub').disabled = true;
            } 
        }

        function closeModalEng(){
            document.getElementById("form_abono").reset();
            a = document.getElementById('inputhidden');
            padre = a.parentNode;
            padre.removeChild(a);
        
            $("#modal_abono").modal('toggle');
        }

        function Cerrar(){
            a = document.getElementById('bod');
            padre = a.parentNode;
            padre.removeChild(a);
            
            $("#modal_log").modal('toggle');
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
                        $('#filtro33').val('default');
                        $("#filtro33").selectpicker("refresh");
                    }
                    else if(data == 0) {
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
                let iduser = $('#userid').val();
                var data = new FormData( $(form)[0] );        
                $.ajax({
                    url: url+'Comisiones/UpdateRetiro',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data = 1 ){
                            $("#modal_nuevas").modal('toggle');
                            alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                            setTimeout(function() {
                                tabla_nuevas.ajax.reload();
                            }, 100);
                        }
                        else{
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });
    
        // FIN TABLA PAGADAS
        function mandar_espera(idLote, nombre) {
            idLoteespera = idLote;
            link_espera1 = "Comisiones/generar comisiones/";
            $("#myModalEspera .modal-footer").html("");
            $("#myModalEspera .modal-body").html("");
            $("#myModalEspera ").modal();
            $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
        }

        $("#roles").change(function() {
            var parent = $(this).val();
            document.getElementById('monto1').value = ''; 
            document.getElementById('idmontodisponible').value = ''; 
            $('#usuarioid option').remove();
            $.post('getUsuariosRol/'+parent, function(data) {
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

        $("#usuarioid").change(function() {
            document.getElementById('monto1').value = ''; 
            document.getElementById('idmontodisponible').value = 'Cargando....'; 
            
            var user = $(this).val();
            $.post('getDisponbleResguardo/'+user, function(data) {
                let disponible = formatMoney(data.toFixed(3));
                $('#idmontodisponible').val(disponible);
            }, 'json'); 
        });

        $("#numeroP").change(function(){
            let monto = parseFloat($('#monto1').val());
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

        function replaceAll( text, busca, reemplaza ){
            while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca,reemplaza);
            return text;
        }

    function verificar(){
        let valorDispo = $('#idmontodisponible').val();
        let disponible = replaceAll(valorDispo,',','');
        let monto_ingresado = replaceAll($('#monto1').val(),',','');
        let monto = parseFloat(monto_ingresado).toFixed(2);
        console.log('disponible: '+disponible);
        console.log('monto: '+monto);
        if(monto < 1 || isNaN(monto)){
            alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
            document.getElementById('btn_abonar').disabled=true; 
        }
        else{
            if(parseFloat(disponible) < parseFloat(monto)){
                alerts.showNotification("top", "right", "El monto ingresado es mayor a lo disponible.", "warning");
                document.getElementById('btn_abonar').disabled=true;
            }
            else{
                document.getElementById('btn_abonar').disabled=false;
            }
        }    
    }

    </script>
</body>