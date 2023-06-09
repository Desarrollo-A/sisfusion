<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        if ($this->session->userdata('id_rol') == "49" || $this->session->userdata('id_rol') == "13" || $this->session->userdata('id_rol') == "17" ){
            /*-----------------------contraloria--------------------------------*/
            $this->load->view('template/sidebar');
        }
        else {
            echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
        }
        ?>

        <!-- Modals -->

        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <form id="form_baja" name="form_baja" method="post">
                        <div class="modal-body cancelacion"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <!--<div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form method="post" id="form_mktd">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Plaza 1</label>
                                    <select name="plaza1" id="plaza1" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Plaza 2</label>
                                    <select name="plaza2" id="plaza2" class="selectpicker" data-style="btn btn-second"data-show-subtext="true" data-live-search="true" title="Selecciona una opción"  required>
                                        <option value="0">Selecciona una opción</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>-->

        <!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center>
                            <img src="<?= base_url() ?>static/images/cob_mktd.gif" width="150" height="150">
                        </center>
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>-->
        <!--<div class="modal fade modal-alertas" id="modal_precio" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red"></div>
                    <form method="post" id="form_precio">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>-->

        <!--<div class="modal fade" id="seeInformationMarketing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsData()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: orange;">
                                <h5 style="color: white;"><b>BITÁCORA DE CAMBIOS</b></h5>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsData()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>-->

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
                                    <h3 class="card-title center-align" >Reporte descuentos <b>universidad maderas</b></h3>
                                    <p class="card-title pl-1">(Listado de lotes donde se aplicó el descuento según el mes seleccionado)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="myText_desU" id="myText_desU">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0" for="mes">Mes</label>
                                                    <select name="mes" id="mes" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona mes" data-size="7" required>
                                                        <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 1; $i <= 12; $i++) {
                                                            $monthNum  = $i;
                                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                            $monthName = strftime('%B', $dateObj->getTimestamp());

                                                            echo '<option value="' . $i . '">' . $monthName . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0" for="mes">Año</label>
                                                    <select name="anio" id="anio" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                        <?php
                                                        setlocale(LC_ALL, 'es_ES');
                                                        for ($i = 2019; $i <= 2023; $i++) {
                                                            $yearName  = $i;
                                                            echo '<option value="' . $i . '">' . $yearName . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                                <thead>
                                                    <tr>
                                                        <th>ID PAGO</th>
                                                        <th>LOTE</th>  
                                                        <th>EMPRESA</th>          
                                                        <th>ID USUARIO</th>
                                                        <th>NOMBRE</th>
                                                        <th>PUESTO</th>
                                                        <th>PLAZA</th>
                                                        <th>DESCUENTO</th>
                                                        <th>CREADO POR</th>
                                                        <th>FECHA CREACIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div><!--main-panel close-->
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
        $('#mes').change(function(ruta) {
            anio = $('#anio').val();
            mes = $('#mes').val();
            if(anio == ''){
                anio=0;
            }else{
                getAssimilatedCommissions(mes, anio);
            }
        });

        $('#anio').change(function(ruta) {
            mes = $('#mes').val();
            if(mes == ''){
                mes=0;
            }
            anio = $('#anio').val();
            if (anio == '' || anio == null || anio == undefined) {
                anio = 0;
            }
            getAssimilatedCommissions(mes, anio);
        });

        //INICIO TABLA QUERETARO********************************************


        var url = "<?=base_url()?>";
        var url2 = "<?=base_url()?>index.php/";
        var tr;
        var tabla_historialGral2 ;
        var totaPen = 0;
        let rol  = "<?=$this->session->userdata('id_rol')?>";
        //INICIO TABLA QUERETARO***************************************
        let titulos = [];

        $('#tabla_historialGral thead tr:eq(0) th').each( function (i) {
            if(i != 10){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
                $('input', this).on('keyup change', function() {
                    if (tabla_historialGral2.column(i).search() !== this.value) {
                        tabla_historialGral2.column(i).search(this.value).draw();

                        var total = 0;
                        var index = tabla_historialGral2.rows({
                            selected: true,
                            search: 'applied'
                        }).indexes();

                        var data = tabla_historialGral2.rows(index).data();
                        $.each(data, function(i, v) {
                            total += parseFloat(v.abono_neodata);

                        });

                        var to1 = formatMoney(total);
                        document.getElementById("myText_desU").value = to1;
                    }
                });
            }  
        });

        function getAssimilatedCommissions(mes, anio) {
            // $('#tabla_historialGral').on('xhr.dt', function(e, settings, json, xhr) {
            //     var total = 0;
            //     $.each(json.data, function(i, v) {
            //         total += parseFloat(v.abono_neodata);
            //     });
            //     var to = formatMoney(total);
            //     document.getElementById("myText_desU").value = to;
            // });



             $('#tabla_historialGral').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.abono_neodata);
                });
                var to = formatMoney(total);
                document.getElementById("myText_desU").textContent = '$' + to;
            });

             

            $("#tabla_historialGral").prop("hidden", false);
            tabla_historialGral2 = $("#tabla_historialGral").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'DESCUENTOS UNIVERSIDAD',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'LOTE';
                                }else if(columnIdx == 2){
                                    return 'EMPRESA';
                                }else if(columnIdx == 3){
                                    return 'ID USUARIO';
                                }else if(columnIdx == 4){
                                    return 'USUARIO';
                                }else if(columnIdx == 5){
                                    return 'PUESTO';
                                }else if(columnIdx == 6){
                                    return 'PLAZA';
                                }else if(columnIdx == 7){
                                    return 'DESCUENTO';
                                }else if(columnIdx == 8){
                                    return 'CREADO POR';
                                }else if(columnIdx == 9){
                                    return 'FECHA CREACIÓN';
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
                        var lblStats;
                        lblStats ='<p class="m-0">'+d.id_pago_i+'</p>';
                        return lblStats;
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombreLote+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.empresa+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.id_usuario+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.user_names+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.puesto+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.nombre+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.abono_neodata)+'</b></p>';
                    }
                }, 
                {
                    "width": "10%",
                    "data": function( d ){
                        var etiqueta;
                        etiqueta = '<p class="m-0">'+d.creado+'</p>';
                        return etiqueta;
                    }
                },
                {
                    "width": "12%",
                    "data": function( d ){
                        var etiqueta;
                        etiqueta = '<p class="m-0">'+d.fecha_pago_intmex+'</p>';
                        return etiqueta;     
                    }
                },
                {
                    "width": "2%",
                    "orderable": false,
                    "data": function( data ){

                        var BtnStats = '';
                        if(rol == 49){
                        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.nombreLote+'" data-nameuser="'+data.user_names+'" data-puesto="'+data.puesto+'" data-monto="'+data.abono_neodata+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-sky regresarpago" title="Cancelar descuento">' +'<i class="fas fa-sync-alt"></i></button>';
                        }

                        return BtnStats;
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center',
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {
                    url: url2 + "Comisiones/getDatosHistorialDU/" + anio + "/" + mes,
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });


            /*$("#tabla_historialGral tbody").on("click", ".bitacora_reporte_marketing", function() {
                lote = $(this).val();
                cliente = $(this).attr("data-value");
                $("#seeInformationMarketing").modal();
                $.getJSON("getDataMarketing/" + lote + "/" + cliente).done(function(data) {
                    $.each(data, function(i, v) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;"><b>COMENTARIO: </b><i style="color:gray;">' + v.comentario + '</i></p><p style="color:gray;"><b>FECHA PROSPECCIÓN: </b><i style="color:gray;">' + v.fecha_prospecion_mktd + '</i></p><p style="color:gray;"><b>CREADO POR: </b> ' + v.nombre + '<p><b style="color:#896597">' + v.fecha_creacion + '</b></p><hr></div>');
                    });
                });
            });*/

            $("#tabla_historialGral tbody").on("click", ".regresarpago", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");
                nameuser = $(this).attr("data-nameuser");
                puesto = $(this).attr("data-puesto");
                monto = $(this).attr("data-monto");
                $("#seeInformationModalAsimilados .modal-body").append(`
                <h5><b>Cancelar descuento</b></h5>
                <p>¿Está seguro que desea cancelar el descuento del <b>${puesto} ${nameuser}</b>?</p>
                <div class="form-group">
                <input type="hidden" name="id_pago" id="id_pago" value="${id_pago}">
                <input type="hidden" name="monto" id="monto" value="${monto}">
                <label>Motivo cancelación</label>
                <textarea class="form-control" row="4" name="motivo" id="motivo"></textarea>
                </div>`);

                $("#seeInformationModalAsimilados .modal-body").append(`<center>
                <button type="submit" class="btn btn-sunccess" style="background:#003D82;" ><b>Aceptar</b></button>
                <button type="button" class="btn btn-danger " data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button></center>`);

                $("#seeInformationModalAsimilados").modal();
            });

            /*$("#form_mktd").submit( function(e) {
                e.preventDefault();
                var plaza1 = $('#plaza1').val();
                var plaza2=$('#plaza2').val();
                var idLote=$('#idlote').val();

                if( plaza1 == plaza2){
                    alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "warning");
                }
                else{
                    $.ajax({
                        type: "POST",
                        url: url2 + "Comisiones/MKTD_compartida",
                        data: {idLote: idLote, plaza1: plaza1,plaza2:plaza2},
                        dataType: 'json',
                        success: function(data){
                            if(data == 1){
                                $("#modal_mktd").modal('toggle');
                                    tabla_historialGral2.ajax.reload();
                                    alerts.showNotification("top", "right", "Registro agregado con exito.", "success");
                            }
                            else if(data == 3){
                                $("#modal_mktd").modal('toggle');
                                tabla_historialGral2.ajax.reload();
                                alerts.showNotification("top", "right", "No se puede aplicar el ajuste porque ya se hicieron pagos individuales anteriormente.", "warning");
                            }
                        },error: function( ){
                            alerts.showNotification("top", "right", "Las plazas seleccionadas son iguales.", "danger");
                        }
                    });
                }   
            })*/

            /*$("#form_aplicar").submit(function(e) {
                e.preventDefault();
            }).validate({
                submitHandler: function(form) {
                    var data = new FormData($(form)[0]);
                    $.ajax({
                        url: url + 'Comisiones/agregar_comentarios',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        method: 'POST',
                        type: 'POST', // For jQuery < 1.9
                        success: function(data) {
                            if (true) {
                                $("#modal_nuevas").modal('toggle');
                                alerts.showNotification("top", "right", "Se guardó tu información correctamente", "success");
                                setTimeout(function() {
                                    tabla_historialGral2.ajax.reload();
                                }, 3000);
                            } else {
                                alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                            }
                        },
                        error: function() {
                            alert("ERROR EN EL SISTEMA");
                        }
                    });
                }
            });*/

            /*function replaceAll( text, busca, reemplaza ){
                while (text.toString().indexOf(busca) != -1)
                text = text.toString().replace(busca,reemplaza);
                return text;
            }*/

            /*$("#form_precio").submit(function(e) {
                e.preventDefault();
            }).validate({
                submitHandler: function(form) {
                    let precioformato = $('#precioL').val();
                    let precio = replaceAll(precioformato,',','');
                    if(!isNaN(precio)){
                        var data = new FormData($(form)[0]);
                        $.ajax({
                            url: url + 'Comisiones/SavePrecioLoteMKTD',
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            method: 'POST',
                            type: 'POST', // For jQuery < 1.9
                            success: function(data) {
                                if (1) {
                                    $("#modal_precio").modal('toggle');
                                    alerts.showNotification("top", "right", "Precio del lote actualizado", "success");
                                    setTimeout(function() {
                                        tabla_historialGral2.ajax.reload();
                                    }, 100);
                                } else {
                                    alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                                }
                            },
                            error: function() {
                                alert("ERROR EN EL SISTEMA");
                            }
                        });
                    }
                    else{
                        alerts.showNotification("top", "right", "Número invalido", "danger");
        
                    }
                }
            });*/
        }

        //FIN TABLA  ****************************************************************************************

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $(window).resize(function() {
            tabla_historialGral2.columns.adjust();
        });

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        function cleanCommentsAsimilados() {
            $('#seeInformationModalAsimilados').modal('hide');
            var cancelacion = document.getElementsByClassName('cancelacion');
            $('.cancelacion').html('');
            cancelacion.innerHTML = '';
        }

        /*$(document).on("click", ".btn-historial-lo", function() {
            window.open(url + "Comisiones/getHistorialEmpresa", "_blank");
        });*/

        /*function cleanComments() {
            var myCommentsList = document.getElementById('documents');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }*/

        /*$(document).ready(function() {
            $.getJSON(url + "Comisiones/report_plazas").done(function(data) {
                $(".report_plazas").html();
                $(".report_plazas1").html();
                $(".report_plazas2").html();

                if (data[0].id_plaza == '0' || data[1].id_plaza == 0) {
                    if (data[0].plaza00 == null || data[0].plaza00 == 'null' || data[0].plaza00 == '') {
                        $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> ' + data[0].plaza01 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                    } else {
                        $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> ' + data[0].plaza01 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> ' + data[0].plaza00 + '%</label>');
                    }

                }
                if (data[1].id_plaza == '1' || data[1].id_plaza == 1) {
                    if (data[1].plaza10 == null || data[1].plaza10 == 'null' || data[1].plaza10 == '') {
                        $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> ' + data[1].plaza11 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                    } else {
                        $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> ' + data[1].plaza11 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> ' + data[1].plaza10 + '%</label>');
                    }

                }

                if (data[2].id_plaza == '2' || data[2].id_plaza == 2) {
                    if (data[2].plaza20 == null || data[2].plaza20 == 'null' || data[2].plaza20 == '') {
                        $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> ' + data[2].plaza21 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                    } else {
                        $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> ' + data[2].plaza21 + '%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> ' + data[2].plaza20 + '%</label>');
                    }

                }
            });
        });*/

        $("#form_baja").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                $.ajax({
                    type: 'POST',
                    url: 'CancelarDescuento',
                    data: data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){},
                    success: function(data) {
                        if (data == 1) {
                            cleanCommentsAsimilados();
                            alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                            tabla_historialGral2.ajax.reload();
                        } else {
                            cleanCommentsAsimilados();
                            alerts.showNotification("top", "right", "Oops, algo salió mal. Error al intentar actualizar.", "warning");
                        }
                    },
                    error: function(){
                        cleanCommentsAsimilados();
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
        });
    </script>
</body>