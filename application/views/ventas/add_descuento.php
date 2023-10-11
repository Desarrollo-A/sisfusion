<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form method="post" id="form_interes">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="seeInformationModalDU" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #3982C0;">
                            <div id="nameLote"></div>
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
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                            onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="seeInformationModalP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content boxContent">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #3982C0;">
                            <div id="nameUser"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTabP">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <ul class="" id="comments-list-asimiladosP">
                                                <div class="row toolbar">
                                                    <input id="userid" name="userid" value="0" type="hidden">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="mes">Mes</label>
                                                                <select name="mes" id="mes" class="selectpicker select-gral m-0 " data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona un mes" data-size="7" required> 
                                                                 </select>
                                                            </div> 
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label class="m-0" for="mes">Año</label>
                                                                <select name="anio" id="anio" class="selectpicker select-gral m-0 "  data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
                                                                
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group text-center" ><h4 class="title-tot center-align m-0 " >MONTO:</h4><p class="category input-tot pl-1" ><B id="montito">$0</B></p></div>

                                                </div>
                                        
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                            onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade modal-alertas" id="miModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="card-title"><b>Aplicar descuento</b></h4>
                </div>
                <form method="post" id="form_basta">
                    <div class="modal-body">


                        <div id="loteorigen"><label class="label">Lote origen</label>
                            <select id="idloteorigen" disabled name="idloteorigen[]" multiple="multiple"
                                    class="form-control directorSelect2 js-example-theme-multiple"
                                    style="width: 100%;height:200px !important;" required
                                    data-live-search="true"></select>
                        </div>


                        <b id="msj2" style="color: red;"></b>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label">Monto disponible</label>
                                <input class="form-control" type="text" id="idmontodisponible" readonly required
                                       name="idmontodisponible" value=""></div>
                            <div id="montodisponible">

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label">Monto a descontar</label>
                                <input class="form-control" type="text" id="monto" readonly="readonly" name="monto"
                                       value="">
                            </div>
                        </div>


                        <div class="col-md-12">

                            <label class="label">Mótivo de descuento</label>
                            <textarea id="comentario" name="comentario" class="form-control" rows="3"
                                      required></textarea>

                        </div>

                        <input class="form-control" type="hidden" id="usuarioid" name="usuarioid" value="">
                        <input class="form-control" type="hidden" id="pagos_aplicados" name="pagos_aplicados" value="">


                        <div class="form-group">

                            <center>
                                <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">CANCELAR</button>
                            </center>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>


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
            <div class="modal-content">
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-alertas" id="ModalBonos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal" data-toggle="modal"> &times;</button>
                    <h4 class="modal-title">Descuentos</h4>
                </div>
                <form method="post" id="form_nuevo">
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="label">Puesto del usuario</label>
                            <select class="selectpicker roles" name="roles" id="roles" required>
                                <option value="">----Seleccionar-----</option>
                                <option value="7">Asesor</option>
                                <option value="9">Coordinador</option>
                                <option value="3">Gerente</option>
                            </select>
                        </div>


                        <div class="form-group" id="users2">
                        </div>


                        <div class="form-group row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto Descuento</label>
                                    <input class="form-control" type="text" id="descuento" required name="descuento"
                                           maxlength="10" autocomplete="off" value=""
                                           onkeypress="return filterFloat(event,this);"/>
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">NÚmero de Pagos</label>
                                    <select class="form-control" name="numeroPagos" id="numeroPagos" required>
                                        <option value="" disabled="true" selected="selected">- Selecciona opción -
                                        </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>

                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label">Monto a descontar</label>
                                    <input class="form-control" type="text" id="pago_ind01" name="pago_ind01" value="">
                                </div>
                            </div>


                        </div>

                        <div class="form-group">

                            <label class="label">Mótivo de descuento</label>
                            <textarea id="comentario2" name="comentario2" class="form-control" rows="3"
                                      required></textarea>

                        </div>

                        <div class="form-group">

                            <center>
                                <button type="submit" id="btn_descontar" class="btn btn-primary">GUARDAR</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal" data-toggle="modal">
                                    CANCELAR
                                </button>
                            </center>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <center><img src="<?= base_url() ?>static/images/preview.gif" width="250" height="200"></center>


                </div>
                <form method="post" id="form_abono">
                    <div class="modal-body"></div>
                    <div class="modal-footer">

                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Descuentos Universidad</h3>
                                <p class="card-title pl-1">(Descuentos activos, una vez liquidados podrás consultarlos en el Historial de descuentos)</p><br>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <h5 class="card-title center-align">
                                    <!--Total bonos aplicados<b>:</b> $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text"  name="totalp" id="totalp">-->
                                    Total descuentos<b>:</b> $<input style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;" disabled="disabled" readonly="readonly" type="text" name="totalp" id="totalp">
                                </h5>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="table-responsive">
                                    <table  id="tabla_descuentos" name="tabla_descuentos"
                                            class="table-striped table-hover" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>USUARIO</th>
                                                <th>PUESTO</th>
                                                <th>SEDE</th>
                                                <th>SALDO COMISIONES</th>
                                                <th>DESCUENTO</th>
                                                <th>APLICADO</th>
                                                <th>PENDIENTE GRAL.</th>
                                                <th>PAGO MENSUAL</th>
                                                <th>ESTATUS</th>
                                                <th>PENDIENTE MES</th>
                                                <th>DISPONIBLE DESC.</th>
                                                <th>FEC. CREACIÓN</th>

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



    <div class="content hide">
        <div class="container-fluid">
            <div class="row">
                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <div class="content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <h4 class="card-title">DESCUENTOS - <b>UNIVERSIDAD</b>
                                                                        </h4>
                                                                        <p class="category">Descuentos activos, una vez
                                                                            liquidados podrás consultarlos en el
                                                                            Historial de descuentos.</b></p>
                                                                    </div>
                                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <label style="color: #0a548b;">&nbsp;Total
                                                                            Descuentos<b>:</b> $<input
                                                                                    style="border-bottom: none; border-top: none; border-right: none;  border-left: none; background: white; color: #0a548b; font-weight: bold;"
                                                                                    disabled="disabled"
                                                                                    readonly="readonly" type="text"
                                                                                    name="totalp" id="totalp"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="card-content">
                                                                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                        <div class="material-datatables">
                                                                            <div class="form-group">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-responsive table-bordered table-striped table-hover"
                                                                                           style="font-size: .7em;"
                                                                                           id="tabla_descuentos"
                                                                                           name="tabla_descuentos">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th style="font-size: 1em;"></th>
                                                                                            <th style="font-size: 1em;">
                                                                                                ID
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                USUARIO
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                PUESTO
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                SEDE
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                SALDO COMISIONES
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                DESCUENTO
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                APLICADO
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                PENDIENTE GRAL.
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                PAGO MENSUAL
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                ESTATUS
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                PENDIENTE MES
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                DISPONIBLE DESC.
                                                                                            </th>
                                                                                            <th style="font-size: 1em;">
                                                                                                ACCIONES
                                                                                            </th>
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
    </div>


    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!--<link href="<?= base_url() ?>dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>dist/js/controllers/select2/select2.min.js"></script>-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var totaPen = 0;
    var tr;


    $("#tabla_descuentos").ready(function () {

        let titulos = [];

        $('#tabla_descuentos thead tr:eq(0) th').each(function (i) {
            if ( i!=13) {
                var title = $(this).text();
                titulos.push(title);

                //titulos.push(title);

                $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                $('input', this).on('keyup change', function () {

                    if (tabla_nuevas.column(i).search() !== this.value) {
                        tabla_nuevas
                            .column(i)
                            .search(this.value)
                            .draw();

                        var total = 0;
                        var index = tabla_nuevas.rows({selected: true, search: 'applied'}).indexes();
                        var data = tabla_nuevas.rows(index).data();

                        $.each(data, function (i, v) {
                            total += parseFloat(v.monto);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("totalp").value = to1;
                        // console.log('fsdf'+total);
                    }
                });
            }
        });

        $('#tabla_descuentos').on('xhr.dt', function (e, settings, json, xhr) {
            var total = 0;
            $.each(json.data, function (i, v) {
                total += parseFloat(v.monto);
            });
            var to = formatMoney(total);
            document.getElementById("totalp").value = to;
        });

        tabla_nuevas = $("#tabla_descuentos").DataTable({
            // dom: 'Brtip',
            dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            "buttons": [

                {
                    text: '<i class="fa fa-edit"></i> NUEVO DESCUENTO',
                    action: function () {
                        open_Mb();
                    },
                    attr: {
                        class: ' btn-azure'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'buttons-excel',
                    titleAttr: 'DESCUENTOS UNIVERSIDAD',
                    title: 'DESCUENTOS UNIVERSIDAD',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 , 11,12],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'ID';
                                        break;
                                    case 1:
                                        return 'USUARIO';
                                        break;
                                    case 2:
                                        return 'PUESTO';
                                    case 3:
                                        return 'SEDE';
                                        break;
                                    case 4:
                                        return 'SALDO COMISIONES';
                                        break;
                                    case 5:
                                        return 'DESCUENTO';
                                        break;
                                    case 6:
                                        return 'APLICADO';
                                        break;
                                    case 7:
                                        return 'PENDIENTE GRAL.';
                                        break;
                                    case 8:
                                        return 'PAGO MENSUAL';
                                        break;
                                    case 9:
                                        return 'ESTATUS';
                                        break;
                                    case 10:
                                        return 'PENDIENTE MES';
                                        break;
                                    case 11:
                                        return 'DISPONIBLE DESC';
                                        break;

                                     case 12:
                                        return 'FECHA CREACIÓN';
                                        break;
                                }
                            }
                        }
                    }
                },


            ],
            width: 'auto',
            "ordering": false,

            "pageLength": 10,
            "bAutoWidth": false,
            "fixedColumns": true,
            language: {
                url: "<?=base_url()?>/static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            pagingType: "full_numbers",
            "columns": [
                {
                    "width": "3%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.id_usuario + '</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.nombre + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.puesto + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.sede + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function (d) {

                        if (d.id_sede == 6) {
                            if (d.abono_nuevo < 15000) {
                                return '<p style="font-size: 1em; color:gray">$' + formatMoney(d.abono_nuevo) + '</p>';
                            } else {
                                return '<p style="font-size: 1em; color:blue"><b>$' + formatMoney(d.abono_nuevo) + '</b></p>';
                            }

                        } else {
                            if (d.abono_nuevo < 10000) {
                                return '<p style="font-size: 1em; color:gray">$' + formatMoney(d.abono_nuevo) + '</p>';
                            } else {
                                return '<p style="font-size: 1em; color:blue"><b>$' + formatMoney(d.abono_nuevo) + '</b></p>';
                            }
                        }
                    }
                },

                {
                    "width": "7%",
                    "data": function (d) {
                        // , du.pagado_caja, du.pago_individual, du.pagos_activos
                        return '<p style="font-size: 1em"><b>$' + formatMoney(d.monto) + '</b></p>';
                    }
                },

                {
                    "width": "7%",
                    "data": function (d) {
                        // abono_00 = parseFloat(d.abono_pagado + d.pagado_caja);
                        if (d.aply == null || d.aply <= 1) {
                            return '<p style="font-size: 1em">$' + formatMoney(d.pagado_caja) + '</p>';
                        } else {
                            return '<p style="font-size: 1em">$' + formatMoney(d.aply) + '</p>';
                        }

                    }
                },

                {
                    "width": "7%",
                    "data": function (d) {
                        OP = parseFloat(d.monto - d.aply);
                        return '<p style="font-size: 1em; color:gray">$' + formatMoney(OP) + '</p>';
                    }
                },

                {
                    "width": "7%",// PAGADO mensual
                    "data": function (d) {

                        return '<p style="font-size: 1em">$' + formatMoney(d.pago_individual) + '</p>';

                    }
                },

                {
                    "width": "7%",
                    "data": function (d) {
                        if (d.status == 0) {
                            return '<span class="label" style="background:red;">BAJA</span>';
                        } else {
                            if (d.id_sede == 6) {
                                if (d.abono_nuevo < 15000) {
                                    $RES = 0;
                                } else {
                                    $RES = 1;
                                }
                            } else {
                                if (d.abono_nuevo < 10000) {
                                    $RES = 0;
                                } else {
                                    $RES = 1;
                                }
                            }

                            if ($RES == 0) {
                                return '<span class="label" style="background:#BEBEBE;">NA</span>';
                            } else {

                                if (d.estatus == 2) {
                                    return '<span class="label" style="background:#BEBEBE;">NA</span>';
                                } 
                                else {
                                    return '<span class="label" style="background:#9321B6;">DISPONIBLE</span>';
                                }
                            }

                        }

                    }
                },

                {
                    "width": "7%",
                    "data": function (d) {
                        OK = parseFloat(d.pago_individual * d.pagos_activos);
                        OP = parseFloat(d.monto - d.aply);

                        if (OK > OP) {
                            OP2 = OP;
                        } else {
                            OP2 = OK;
                        }


                        if (OP2 < 1) {

                            return '<p style="font-size: 1em; color:gray">$' + formatMoney(0) + '</p>';

                        } else {
                            return '<p style="font-size: 1em; color:red"><b>$' + formatMoney(OP2) + '</b></p>';

                        }
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {

                        validar = 0;
                        OK = parseFloat(d.pago_individual * d.pagos_activos);
                        OP = parseFloat(d.monto - d.aply);

                        if (OK > OP) {
                            OP2 = OP;
                        } else {
                            OP2 = OK;
                        }


                        if (OP2 < 1) {

                            respuesta = 0;

                        } else {

                            if (d.id_sede == 6) {
                                if (d.abono_nuevo < 15000) {
                                    respuesta = 0;
                                } else {

                                    validar = Math.trunc(d.abono_nuevo / 15000);

                                    if (validar >= d.pagos_activos) {
                                        validar = d.pagos_activos;
                                        respuesta = OP2;
                                    } else {

                                        respuesta = validar * d.pago_individual;
                                    }

                                }
                            } else {
                                if (d.abono_nuevo < 10000) {
                                    respuesta = 0;
                                } else {

                                    validar = Math.trunc(d.abono_nuevo / 10000);

                                    if (validar >= d.pagos_activos) {
                                        validar = d.pagos_activos;
                                        respuesta = OP2;
                                    } else {

                                        respuesta = (validar * d.pago_individual);
                                    }

                                }
                            }


                        }

                        return '<p style="font-size: 1em; color:gray"><b>$' + formatMoney(respuesta) + '</b></p>';

                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        return '<p style="font-size: 1em">' + d.fecha_creacion + '</p>';
                    }
                },

                {
                    "width": "8%",
                    "data": function (d) {
                        if (d.status == 0) {
                            return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' + '<i class="fas fa-info-circle"></i></button>'+
                            '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-darkMaderas consultar_historial_pagos" title="Historial pagos">' + '<i class="fas fa-chart-bar"></i></button></div>';

                        } else {
                            OK = parseFloat(d.pago_individual * d.pagos_activos);
                            OP = parseFloat(d.monto - d.aply);

                            if (OK > OP) {
                                pend = OP;
                            } else {
                                pend = OK;
                            }


                            if (d.estatus == 2) {
                                BOTON = 0;
                            } else {
                                if (pend > 0) {
                                    if (d.id_sede == 6) {
                                        if (d.abono_nuevo < 15000) {
                                            BOTON = 0;
                                        } else {
                                            validar = Math.trunc(d.abono_nuevo / 15000);
                                            if (validar >= d.pagos_activos) {
                                                validar = d.pagos_activos;
                                                pendiente = pend;
                                            } else {
                                                pendiente = (validar * d.pago_individual);
                                            }
                                            BOTON = 1;
                                        }
                                    } else {
                                        if (d.abono_nuevo < 10000) {
                                            BOTON = 0;
                                        } else {
                                            validar = Math.trunc(d.abono_nuevo / 10000);
                                            if (validar >= d.pagos_activos) {
                                                validar = d.pagos_activos;
                                                pendiente = pend;
                                            } else {
                                                pendiente = (validar * d.pago_individual);
                                            }
                                            BOTON = 1;
                                        }
                                    }
                                } else {
                                    BOTON = 0;
                                }
                            }

                            if (BOTON == 0) {
                                return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-blueMaderas consultar_logs_asimilados" title="Detalles">' + '<span class="fas fa-info-circle"></span></button><button href="#" value="' + d.id_usuario + '" data-value="' + d.aply + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-warning topar_descuentos" title="Detener descuentos">' + '<i class="fas fa-times"></i></button>'+
                            '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-gray consultar_historial_pagos" title="Historial pagos">' + '<i class="fas fa-chart-bar"></i></button></div>';
                            } else {
                                return '<div class="d-flex justify-center"><button href="#" value="' + d.id_usuario + '" data-value="' + pendiente + '"  data-sede="' + d.id_sede + '" data-validate="' + validar + '" data-code="' + d.cbbtton + '" ' + 'class="btn-data btn-violetDeep agregar_nuevo_descuento"  title="Aplicar descuento">' + '<i class="fas fa-plus"></i></button>'+
                            '<button href="#" value="' + d.id_usuario + '" data-value="' + d.nombre + '" data-code="' + d.id_usuario + '" ' + 'class="btn-data btn-gray consultar_historial_pagos" title="Historial pagos">' + '<i class="fas fa-chart-bar"></i></button></div>';
                            }
                        }


                    },
                }
            ],
            columnDefs: [
                {

                    orderable: false,
                    className: 'select-checkbox',
                    'searchable': false,
                    'className': 'dt-body-center'
                }],

            "ajax": {
                "url": url2 + "Comisiones/getDescuentosCapital",
                /*registroCliente/getregistrosClientes*/
                "type": "POST",
                cache: false,
                "data": function (d) {

                }
            },
        });


        $("#tabla_descuentos tbody").on("click", ".agregar_nuevo_descuento", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();


            $("#idloteorigen").val('');
            $("#usuarioid").val('');
            $("#pagos_aplicados").val('');


            $("#idloteorigen").selectpicker("refresh");
            $('#idloteorigen option').remove();


            id_user = $(this).val();
            monto = $(this).attr("data-value");
            sde = $(this).attr("data-sede");
            validar = $(this).attr("data-validate");

            // alert(validar);

            $("#miModal modal-body").html("");
            $("#miModal").modal();

            var user = $(this).val();
            let datos = user.split(',');
            $("#monto").val('$' + formatMoney(monto));
            $("#usuarioid").val(id_user);
            $("#pagos_aplicados").val(validar);

            $.post('getLotesOrigen2/' + id_user + '/' + monto, function (data) {
                var len = data.length;


                let valores = '';
                let sumaselected = 0;
                for (var i = 0; i < len; i++) {

                    var name = data[i]['nombreLote'];
                    var comision = data[i]['id_pago_i'];
                    var pago_neodata = data[i]['pago_neodata'];
                    let comtotal = parseFloat(data[i]['comision_total']) - parseFloat(data[i]['abono_pagado']);
                    sumaselected = sumaselected + parseFloat(data[i]['comision_total']);

                    console.log('suma lote ' + comtotal);
                    console.log('suma2 lote ' + sumaselected);


                    $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)},${pago_neodata},${name}' selected="selected">${name}  -   $${formatMoney(comtotal.toFixed(2))}</option>`);
                }

                $("#idmontodisponible").val('$' + formatMoney(sumaselected));
                verificar();

                if (len <= 0) {
                    $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#idloteorigen").selectpicker('refresh');
            }, 'json');


        });


let meses = [
    {id:01,mes:'Enero'},{id:02,mes:'Febrero'},{id:03,mes:'Marzo'},{id:04,mes:'Abril'},{id:05,mes:'Mayo'},{id:06,mes:'Junio'},{id:07,mes:'Julio'},{id:08,mes:'Agosto'},{id:09,mes:'Septiembre'
    },{id:10,mes:'Octubre'},{id:11,mes:'Noviembre'},{id:12,mes:'Diciembre'}];
console.log(meses);
let anios = [2019,2020,2021,2022];


        $("#tabla_descuentos tbody").on("click", ".consultar_historial_pagos", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            document.getElementById('nameUser').innerHTML = '';
            document.getElementById('montito').innerHTML = '';

            $('#userid').val(0);

            id_user = $(this).val();
            user = $(this).attr("data-value");
            $('#userid').val(id_user);

            $("#seeInformationModalP").modal();
            $("#nameUser").append('<p><h5 style="color: white;">HISTORIAL PAGOS: <b>' + user + '</b></h5></p>');
           
  let datos = '';
  let datosA = '';
     for (let index = 0; index < meses.length; index++) {
       //  const element = array[index];
         datos = datos + `<option value="${meses[index]['id']}">${meses[index]['mes']}</option>`; 
         
     }  
     for (let index = 0; index < anios.length; index++) {
       //  const element = array[index];
         datosA = datosA + `<option value="${anios[index]}">${anios[index]}</option>`; 
         
     }   
     $('#mes').html(datos);  
     $('#mes').selectpicker('refresh');
     $('#anio').html(datosA);  
     $('#anio').selectpicker('refresh');
  
  //$("#comments-list-asimiladosP .select-gral-mes").append(`${datos}`);




           /* $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                if (!data) {

                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');

                } else {
                    $.each(data, function (i, v) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SE DESCONTÓ LA CANTIDAD DE <b>$' + formatMoney(v.comentario) + '</b><br><b style="color:#3982C0;font-size:0.9em;">' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                    });
                }
            });*/
        });


function getPagosByUser(user,mes, anio){
    document.getElementById('montito').innerHTML = 'Cargando...';
    $.getJSON("getPagosByUser/" + user+"/"+mes+"/"+anio).done(function (data) {
               document.getElementById('montito').innerHTML ='$'+ formatMoney(data[0].suma);
            });
}
        $('#mes').change(function(ruta) {
            anio = $('#anio').val();
            mes = $('#mes').val();
            let user = $('#userid').val();
            if(anio == ''){
                anio=0;
            }else{
             
                getPagosByUser(user,mes, anio);
            }
        });

        $('#anio').change(function(ruta) {
            mes = $('#mes').val();
            anio = $('#anio').val();
            let user = $('#userid').val();

            if(mes != '' && (anio != '' || anio != null || anio != undefined)){
                //alert(34)
                getPagosByUser(user,mes, anio);

            }
        });

        $("#tabla_descuentos tbody").on("click", ".consultar_logs_asimilados", function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            id_user = $(this).val();
            lote = $(this).attr("data-value");

            $("#seeInformationModalDU").modal();
            $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DESCUENTO: <b>' + lote + '</b></h5></p>');
            $.getJSON("getCommentsDU/" + id_user).done(function (data) {
                if (!data) {

                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SIN </p></div>');

                } else {
                    $.each(data, function (i, v) {
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p style="color:gray;font-size:1.1em;">SE DESCONTÓ LA CANTIDAD DE <b>$' + formatMoney(v.comentario) + '</b><br><b style="color:#3982C0;font-size:0.9em;">' + v.date_final + '</b><b style="color:#C6C6C6;font-size:0.9em;"> - ' + v.nombre_usuario + '</b></p></div>');
                    });
                }
            });
        });


        $("#tabla_descuentos tbody").on("click", ".topar_descuentos", function () {
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row(tr);
            id_usuario = $(this).val();


            $("#modal_nuevas .modal-header").html("");
            $("#modal_nuevas .modal-body").html("");

            $("#modal_nuevas .modal-header").append('<h4 class="card-title"><b>Detener Descuento</b></h4>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p style="font-size:1.1em;">¿Está seguro de detener los pagos al ' + row.data().puesto + ' <u>' + row.data().nombre + '</u> con la cantidad de <b>$' + formatMoney(row.data().aply) + '</b>?</p></div></div>');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="1"><input type="hidden" name="monto" value="' + row.data().aply + '"><br><input type="text" class="form-control observaciones" name="observaciones" required placeholder="Describe el motivo por el cual se pausa esta solicitud"></input></div></div><br>');
            $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="' + row.data().id_usuario + '">');
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-12" style="align-content: left;"><center><input type="submit" id="btn_topar" class="btn btn-primary" value="DETENER" style="margin: 15px;"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></center></div></div>');
            $("#modal_nuevas").modal();
        });


        $('#tabla_descuentos tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
            } else {
                if (row.data().solicitudes == null || row.data().solicitudes == "null") {
                    $.post(url + "Comisiones/getDescuentosCapitalpagos", {"id_usuario": row.data().id_usuario}).done(function (data) {

                        row.data().solicitudes = JSON.parse(data);

                        tabla_nuevas.row(tr).data(row.data());

                        row = tabla_nuevas.row(tr);

                        row.child(construir_subtablas(row.data().solicitudes)).show();
                        tr.addClass('shown');
                        $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");

                    });
                } else {
                    row.child(construir_subtablas(row.data().solicitudes)).show();
                    tr.addClass('shown');
                    $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
                }

            }


        });


        function construir_subtablas(data) {
            var solicitudes = '<table class="table">';
            $.each(data, function (i, v) {
                //i es el indice y v son los valores de cada fila

                // console.log(data);
                if (v.id_usuario == 'undefined') {
                    solicitudes += '<tr>';
                    solicitudes += '<td><b>SIN PAGO APLICADOS</b></td>';
                    solicitudes += '</tr>';


                } else {
                    solicitudes += '<tr>';
                    solicitudes += '<td><b>Pago ' + (i + 1) + '</b></td>';
                    solicitudes += '<td>' + '<b>' + 'USUARIO ' + '</b> ' + v.nombre + '</td>';
                    solicitudes += '<td>' + '<b>' + 'MONTO: ' + '</b> $' + formatMoney(v.abono_neodata) + '</td>';
                    solicitudes += '<td>' + '<b>' + 'CREADO POR: ' + '</b> ' + v.creado_por + '</td>';
                    solicitudes += '<td>' + '<b>' + 'FECHA CAPTURA: ' + '</b> ' + v.fecha_abono + '</td>';
                    solicitudes += '</tr>';
                }

            });

            return solicitudes += '</table>';
        }


        /**------------------------------------------- */
        $("#tabla_descuentos tbody").on("click", ".abonar", function () {
            bono = $(this).val();
            var dat = bono.split(",");
            //$("#modal_abono").html("");
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
            //save(bono);
        });


        $("#tabla_descuentos tbody").on("click", ".btn-delete", function () {
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


        $("#tabla_descuentos tbody").on("click", ".btn-update", function () {
            var tr = $(this).closest('tr');
            var row = tabla_nuevas.row(tr);

            id_pago_i = $(this).val();

            $("#modal_nuevas .modal-body").html("");
            $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Seguro que desea descontar a <b>' + row.data().usuario + '</b> la cantidad de <b style="color:red;">$' + formatMoney(row.data().monto) + '</b> correspondiente al lote <b>' + row.data().nombreLote + '</b> ?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="' + row.data().id_pago_i + '"><br><input type="submit" class="btn btn-success" value="Aceptar"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></p></div></div>');
            $("#modal_nuevas").modal();
        });


        //  $("#tabla_descuentos tbody").on("click", ".btn-update", function(){
        //     id = $(this).val();

        //      bono = $(this).val();
        //     var dat = bono.split(",");

        //      $("#modal_abono .modal-body").append(`<div id="borrarUpdare"><form id="form-update">
        //     <h6>¿Seguro que desea descontar a <b>${dat[3]}</b> la cantidad de <b style="color:red;">$${formatMoney(dat[1])}</b> correspondiente a la comisión de <b>${dat[2]}</b> ?</h6><input type='hidden' name="id_descuento" id="id_descuento" value="${dat[0]}">
        //     <br>
        //      <input type="submit" class="btn btn-success" value="Aceptar">
        //     <button class="btn btn-danger" onclick="CloseModalUpdate2();">Cerrar</button>
        //     </form></div>`);

        //     $('#modal_abono').modal('show');
        // });


    });


    /**-------------------------------------------------------------------------------------------------------------------------------------------------------- */






    function cancela() {
        $("#modal_nuevas").modal('toggle');
    }


    //Función para pausar la solicitud
    $("#form_interes").submit(function (e) {

        $('#btn_topar').attr('disabled', 'true');

        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data = new FormData($(form)[0]);
            console.log(data);
            // data.append("id_pago_i", id_pago_i);
            $.ajax({
                url: url + "Comisiones/topar_descuentos",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (data[0]) {
                        $("#modal_nuevas").modal('toggle');
                        alerts.showNotification("top", "right", "Se detuvo el descuento exitosamente", "success");
                        setTimeout(function () {
                            tabla_nuevas.ajax.reload();
                            // tabla_otras2.ajax.reload();
                        }, 3000);
                    } else {
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });


    function filterFloat(evt, input) {
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;
        var isNumber = (key >= 48 && key <= 57);
        var isSpecial = (key == 8 || key == 13 || key == 0 || key == 46);
        if (isNumber || isSpecial) {
            return filter(tempValue);
        }

        return false;

    }

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        return (preg.test(__val__) === true);
    }


    $("#roles").change(function () {
        var parent = $(this).val();

        $("#users2").val('');

        $("#usuarioid2").val('');
        $("#usuarioid2").selectpicker("refresh");


        document.getElementById("users2").innerHTML = '';
        $('#users2').append(`<label class="label">Usuario</label><select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>`);
        $.post('getUsuariosRolDU/' + parent, function (data) {
            $("#usuarioid2").append($('<option disabled>').val("default").text("Seleccione una opción"))
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_usuario'];
                var name = data[i]['name_user'];
                var status = data[i]['estatus'];
                if(status == 0){
                    name = name + ' (Inactivo)';
                }
                $("#usuarioid2").append($('<option>').val(id).attr('data-value', id).text(name));
            }
            if (len <= 0) {
                $("#usuarioid2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#usuarioid2").selectpicker('refresh');
        }, 'json');
    });


    $("#form_basta").submit(function (e) {
         $('#btn_abonar').prop('disabled', true);
        document.getElementById('btn_abonar').disabled = true;

        $('#idloteorigen').removeAttr('disabled');

        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data1 = new FormData($(form)[0]);
            $.ajax({
                url: 'saveDescuento/' + 3,
                data: data1,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        $('#idloteorigen option').remove();
                        $("#roles").val('');
                        $("#roles").selectpicker("refresh");
                        $('#usuarioid').val('default');
                        $('#usuarioid').val('default');

                        $("#usuarioid").selectpicker("refresh");

                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");


                    } else if (data == 2) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                        $(".directorSelect2").empty();

                    } else if (data == 3) {
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#miModal').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                        $(".directorSelect2").empty();

                    }
                    $('#idloteorigen').attr('disabled', 'true');

                },
                error: function () {
                    $('#loaderDiv').addClass('hidden');
                    $('#miModal').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    $('#idloteorigen').attr('disabled', 'true');


                }
            });
        }
    });


    // btn_descontar


    $("#form_nuevo").submit(function (e) {

        // $('#btn_abonar').attr('disabled', 'true');
        $('#btn_abonar').prop('disabled', true);
        document.getElementById('btn_abonar').disabled = true;

        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data1 = new FormData($(form)[0]);
            $.ajax({
                url: 'saveDescuentoch/',
                data: data1,
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == 1) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#ModalBonos').modal('hide');
                        $("#roles").val('');
                        $("#roles").selectpicker("refresh");
                        document.getElementById("users2").innerHTML = '';
                        $("#usuarioid2").val('');
                        $("#usuarioid2").selectpicker("refresh");

                        $("#descuento").val('');
                        $("#numeroPagos").val('');
                        $("#pago_ind01").val('');
                        $("#comentario2").val('');
                        alerts.showNotification("top", "right", "Descuento registrado con exito.", "success");

                    } else if (data == 2) {
                        $('#loaderDiv').addClass('hidden');
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#ModalBonos').modal('hide');
                        alerts.showNotification("top", "right", "Ocurrio un error.", "warning");
                        $(".directorSelect2").empty();

                    } else if (data == 3) {
                        $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                        $('#ModalBonos').modal('hide');
                        alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un pago activo.", "warning");
                        $(".directorSelect2").empty();

                    }

                },
                error: function () {
                    $('#loaderDiv').addClass('hidden');
                    $('#ModalBonos').modal('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    $('#idloteorigen').attr('disabled', 'true');


                }
            });
        }
    });


    $("#numeroPagos").change(function () {


        let monto1 = replaceAll($('#descuento').val(), ',', '');
        let monto = replaceAll(monto1, '$', '');
        let cantidad = parseFloat($('#numeroPagos').val());
        let resultado = 0;


        if (isNaN(monto)) {
            alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
            $('#pago_ind01').val(resultado);
            // document.getElementById('btn_abonar').disabled = true;
            $('#btn_abonar').prop('disabled', true);
        document.getElementById('btn_abonar').disabled = true;
        } else {
            resultado = monto / cantidad;

            if (resultado > 0) {
                // document.getElementById('btn_abonar').disabled=false;
                $('#pago_ind01').val(formatMoney(resultado));
            } else {
                // document.getElementById('btn_abonar').disabled=true;
                $('#pago_ind01').val(formatMoney(0));
            }
        }
    });


    function closeModalEng() {
        // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form_abono").reset();
        a = document.getElementById('inputhidden');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal_abono").modal('toggle');

    }

    function CloseModalDelete() {
        // document.getElementById("inputhidden").innerHTML = "";
        a = document.getElementById('borrarBono');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal-delete").modal('toggle');

    }

    function CloseModalDelete2() {
        // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form-delete").reset();
        a = document.getElementById('borrarBono');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal-delete").modal('toggle');

    }

    function CloseModalUpdate2() {
        // document.getElementById("inputhidden").innerHTML = "";
        document.getElementById("form-update").reset();
        a = document.getElementById('borrarUpdare');
        padre = a.parentNode;
        padre.removeChild(a);

        $("#modal-abono").modal('toggle');

    }

    $(document).on('submit', '#form-delete', function (e) {
        e.preventDefault();
        var formData = new FormData(document.getElementById("form-delete"));
        formData.append("dato", "valor");
        $.ajax({
            method: 'POST',
            url: url + 'Comisiones/BorrarDescuento',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                    CloseModalDelete2();
                    // $('#modal_abono').modal('hide');
                    alerts.showNotification("top", "right", "Abono borrado con exito.", "success");
                    document.getElementById("form_abono").reset();

                } else if (data == 0) {
                    $('#tabla_descuentos').DataTable().ajax.reload(null, false);
                    CloseModalDelete2();
                    //$('#modal-delete').modal('hide');
                    alerts.showNotification("top", "right", "Pago liquidado.", "warning");
                }
            },
            error: function () {
                closeModalEng();
                $('#modal_abono').modal('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });


    $("#form_aplicar").submit(function (e) {
        e.preventDefault();
    }).validate({
        submitHandler: function (form) {

            var data = new FormData($(form)[0]);
            console.log(data);
            data.append("id_pago_i", id_pago_i);
            $.ajax({
                // url: url + "Comisiones/pausar_solicitud/",
                url: url + 'Comisiones/UpdateDescuento',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (data) {
                    if (data = 1) {
                        $("#modal_nuevas").modal('toggle');
                        alerts.showNotification("top", "right", "Se aplicó el descuento correctamente", "success");
                        setTimeout(function () {
                            tabla_nuevas.ajax.reload();
                            // tabla_otras2.ajax.reload();
                        }, 3000);
                    } else {
                        alerts.showNotification("top", "right", "No se ha procesado tu solicitud", "danger");

                    }
                }, error: function () {
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });


    // FIN TABLA PAGADAS


    function mandar_espera(idLote, nombre) {
        idLoteespera = idLote;
        // link_post2 = "Cuentasxp/datos_para_rechazo1/";
        link_espera1 = "Comisiones/generar comisiones/";
        $("#myModalEspera .modal-footer").html("");
        $("#myModalEspera .modal-body").html("");
        $("#myModalEspera ").modal();
        // $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
        $("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
    }


    // FUNCTION MORE

    $(window).resize(function () {
        tabla_nuevas.columns.adjust();
        // tabla_proceso.columns.adjust();
        // tabla_pagadas.columns.adjust();
        // tabla_otras.columns.adjust();
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

    /**.---------------------------ROLES------------------------------------------ */


    /**----------------------------FIN ROLES------------------------------------------------------------- */
    $("#idloteorigen").select2({dropdownParent: $('#miModal')});
    $("#idloteorigen").select2("readonly", true);
    /**-----------------------------LOTES----------------------- */
    $("#idloteorigen").change(function () {

        let cuantos = $('#idloteorigen').val().length;
        let suma = 0;
        //let ids = $('#idloteorigen').val();

        if (cuantos > 1) {

            var comision = $(this).val();
            //alert(comision);
            //let ids = comision.split(',');
            for (let index = 0; index < $('#idloteorigen').val().length; index++) {
                datos = comision[index].split(',');
                let id = datos[0];
                let monto = datos[1];
                // var id = comision[index];
                document.getElementById('monto').value = '';

                $.post('getInformacionData/' + id + '/' + 1, function (data) {

                    var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                    suma = suma + disponible;
                    document.getElementById('montodisponible').innerHTML = '';
                    $("#idmontodisponible").val('$' + formatMoney(suma));
                    $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + suma.toFixed(2) + '">');
                    $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
                    var len = data.length;
                    if (len <= 0) {
                        $("#idmontodisponible").val('$' + formatMoney(0));
                    }
                    $("#montodisponible").selectpicker('refresh');
                }, 'json');
            }
            console.log(suma);
        } else {
            var comision = $(this).val();
            datos = comision[0].split(',');
            let id = datos[0];
            let monto = datos[1];
            //alert(id+'-------'+monto);
            document.getElementById('monto').value = '';
            $.post('getInformacionData/' + id + '/' + 1, function (data) {
                var disponible = (data[0]['comision_total'] - data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];
                document.getElementById('montodisponible').innerHTML = '';
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="' + disponible + '">');
                $("#idmontodisponible").val('$' + formatMoney(disponible));
                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="' + idecomision + '">');
                var len = data.length;
                if (len <= 0) {
                    $("#idmontodisponible").val('$' + formatMoney(0));
                }
                $("#montodisponible").selectpicker('refresh');
            }, 'json');
        }
    });

    /**--------------------------------------------------------------------------------------------------------- */



    function verificar() {
        // let d = $('#valor_comision').val();
        let d2 = replaceAll($('#idmontodisponible').val(), ',', '');
        let disponiblefinal = replaceAll(d2, '$', '');
        //let m1 = $('#monto').val();
        let m = replaceAll($('#monto').val(), ',', '');
        let montofinal = replaceAll(m, '$', '');

        let disponible = parseFloat(disponiblefinal);
        let monto = parseFloat(montofinal);
        console.log('disponible: ' + disponible);
        console.log('monto: ' + monto);
        if (monto < 1 || isNaN(monto)) {
            alerts.showNotification("top", "right", "No hay saldo disponible para descontar.", "warning");
            // document.getElementById('btn_abonar').disabled = true;
            $('#btn_abonar').prop('disabled', true);
        document.getElementById('btn_abonar').disabled = true;

        } else {
            if (parseFloat(monto) <= parseFloat(disponible)) {
                // console.log('paso');
                let cantidad = parseFloat($('#numeroP').val());
                resultado = monto / cantidad;
                $('#pago').val(formatMoney(resultado));
                // document.getElementById('btn_abonar').disabled = false;

                $('#btn_abonar').prop('disabled', false);
                document.getElementById('btn_abonar').disabled = false;

                // console.log('OK');
                let cuantos = $('#idloteorigen').val().length;
                let cadena = '';
                var data = $('#idloteorigen').select2('data')
                console.log('CUANTOS SON: '+cuantos);
                for (let index = 0; index < cuantos; index++) {
                    let datos = data[index].id;
                    let montoLote = datos.split(',');
                    let abono_neo = montoLote[1];
                    if (parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1) {
                        document.getElementById('msj2').innerHTML = "El monto ingresado se cubre con la comisión " + data[index].text;
                        // document.getElementById('btn_abonar').disabled = true;

                        $('#btn_abonar').prop('disabled', false);
                document.getElementById('btn_abonar').disabled = false;

                        break;
                    }
                    console.log(data[index].text);
                    if(cuantos == 1){
                        let datosLote = data[index].text.split('-   $');
                        let nameLote = datosLote[0]
                        let montoLote = datosLote[1];
                        cadena =  'DESCUENTO UNIVERSIDAD MADERAS \n LOTE INVOLUCRADO: '+nameLote+',  MONTO DISPONIBLE: $'+montoLote+'.\n DESCUENTO DE: $'+formatMoney(monto)+', RESTANTE:$'+formatMoney(parseFloat(abono_neo) - parseFloat(monto));
                    }else{
                        cadena = 'DESCUENTO UNIVERSIDAD MADERAS';
                    }
                    
                    document.getElementById('msj2').innerHTML = '';

                }
                $('#comentario').val(cadena);

                // console.log(cadena);
            }
            //else {
            else if (parseFloat(monto) > parseFloat(disponible)) {
                alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");
                //document.getElementById('monto').value = '';
                // document.getElementById('btn_abonar').disabled = true;

                $('#btn_abonar').prop('disabled', true);
        document.getElementById('btn_abonar').disabled = true;
        
            }
        }

    }


    function cleanCommentsAsimilados() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';
    }


    function replaceAll(text, busca, reemplaza) {
        while (text.toString().indexOf(busca) != -1)
            text = text.toString().replace(busca, reemplaza);
        return text;
    }


    function open_Mb() {
        // console.log("SI ENTRA");
        // $("ModalBonos").modal();

        $("#roles").val('');
        $("#roles").selectpicker("refresh");

        document.getElementById("users2").innerHTML = '';


        $("#usuarioid2").val('');
        $("#usuarioid2").selectpicker("refresh");

        $("#comentario2").val('');

        $('#ModalBonos').modal('show');
    }

</script>
   

