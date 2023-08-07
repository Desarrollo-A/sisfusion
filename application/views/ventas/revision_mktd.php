<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">

    <?php
    if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="18" || $this->session->userdata('id_usuario')=="2767" || $this->session->userdata('id_rol')=="70"){
        $this->load->view('template/sidebar');
    }
    else{
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>
    <div class="modal fade modal-alertas" id="miModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Descuentos</h4>
                </div>
                <form method="post" id="form_descuentos">
                    <div class="modal-body">
                        <div class="form-group" id="users">
                            <label class="label">Usuario</label>
                            <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                        </div>
                        <div class="form-group" id="loteorigen">
                            <label class="label">Lote origen</label>
                            <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                        </div>
                        <b id="msj2" style="color: red;"></b>
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
                        <div class="form-group d-flex justify-center">
                            <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--<div class="modal fade modal-alertas" id="modal_users" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="form_interes">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>-->

    <!--<div class="modal fade modal-alertas" id="modal_colaboradores" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form method="post" id="form_colaboradores">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>-->

    <!--<div class="modal fade modal-alertas" id="modal_mktd" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">EDITAR INFORMACIÓN</h4>
                </div>
                <form method="post" id="form_MKTD">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>-->

    <!--<div class="modal fade modal-alertas" id="modalParcialidad" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">SOLICITAR PARCIALIDAD DE PAGO</h4>
                </div>
                <form method="post" id="form_parcialidad">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>-->

    <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons" onclick="cleanComments()">clear</i></button>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #949494;">
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
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()"><b>Cerrar</b></button>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
        <div class="modal-dialog" style="width:800px; margin-top:20px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <!--<div class="modal fade modal-alertas" id="documento_preview" role="dialog">
        <div class="modal-dialog" style= "margin-top:20px;"></div>
    </div>-->
    <!-- END Modals -->

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm">
                    <?php if($this->session->userdata('id_rol') != "18") { ?>
                        <li class="active">
                            <a href="#nuevas-1" role="tab" data-toggle="tab">
                                <span class="material-icons">done</span>PAGOS SOLICITADOS MKTD
                            </a>
                        </li>
                        <?php } else{ ?>
                        <li class="active">
                            <a href="#nuevas-12" role="tab" data-toggle="tab">
                                <span class="material-icons">done</span>PAGOS SOLICITADOS MKTD
                            </a>
                        </li>
                        <?php } ?>
                        
                        <li>
                            <a href="#proceso-1" role="tab" data-toggle="tab">
                                <span class="material-icons">done_all</span>LOTES DISPERSADOS
                            </a>
                        </li>
                        <?php
                        if($this->session->userdata('id_rol')=="18"){
                            ?>
                            <li>
                                <a href="#total_comisionistas" role="tab" data-toggle="tab">
                                    <span class="material-icons">supervisor_account</span>TOTAL COMISIONISTA
                                </a>
                            </li>
                            <li>
                                <a href="#total_comisionistas2" role="tab" data-toggle="tab">
                                    <span class="material-icons">donut_small</span>ESTATUS DISPERSIÓN
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <div class="card no-shadow m-0">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                <?php if($this->session->userdata('id_rol') != "18") { ?>
                                    <div class="tab-pane active" id="nuevas-1">
                                        <div class="encabezadoBox">
                                            <h3 class="card-title center-align" >Comisiones nuevas <b>mktd</b></h3>
                                            <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago para el área de MKTD)</p>
                                        </div>
                                        <div class="toolbar">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <?php
                                                    if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17"){?>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <?php } else { ?>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <?php } ?>
                                                            <div class="form-group d-flex justify-center align-center m-0">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="myText_nuevas" id="myText_nuevas">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17"){?>
                                                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Aplicar descuento</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_plaza_1" name="tabla_plaza_1">
                                                            <thead>
                                                            <tr>
                                                                <th>ID USUARIO</th>
                                                                <th>USUARIO</th>
                                                                <th>SEDE USUARIO</th>
                                                                <th>IMPUESTO %</th>
                                                                <th>ABONO DISPERSADO</th>
                                                                <th>DESCUENTO</th>
                                                                <th>A PAGAR</th>
                                                                <th>TOTAL</th>
                                                                <th>FORMA PAGO</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <?php } ?>
                                        <?php if($this->session->userdata('id_rol') == "18") { ?>
                                        <div class="tab-pane active" id="nuevas-12">
                                        <div class="encabezadoBox">
                                            <h3 class="card-title center-align" >Comisiones nuevas <b>mktd</b></h3>
                                            <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago para el área de MKTD)</p>
                                        </div>
                                        <div class="toolbar">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <?php
                                                    if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17"){?>
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                        <?php } else { ?>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <?php } ?>
                                                            <div class="form-group col-md-6 m-0">
                                                                <h4 class="title-tot center-align m-0">Comisiones:</h4>
                                                                <p class="input-tot pl-1 center-align" name="myText_nuevasCo" id="myText_nuevasCo">$0.00</p>
                                                            </div>
                                                            <div class="form-group col-md-6 m-0">
                                                                <h4 class="title-tot center-align m-0">NUSKAH:</h4>
                                                                <p class="input-tot pl-1 center-align" name="myText_nuevasNus" id="myText_nuevasNus">$0.00</p>
                                                            </div>
                                                            <div class="form-group col-md-6 m-0">
                                                                <h4 class="title-tot center-align m-0">MKTD 2020:</h4>
                                                                <p class="input-tot pl-1 center-align" name="myText_nuevasMktd" id="myText_nuevasMktd">$0.00</p>
                                                            </div>
                                                            <div class="form-group col-md-6 m-0">
                                                                <h4 class="title-tot center-align m-0">Total:</h4>
                                                                <p class="input-tot pl-1 center-align" name="myText_nuevasTo" id="myText_nuevasTo">$0.00</p>
                                                            </div>
                                                            
                                                        </div>
                                                        <?php
                                                        if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17"){?>
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Aplicar descuento</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="toolbar">
                                            <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="container-fluid p-0">
                                                                <div class="row">
                                                                <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                                    <div class="form-group">
                                                                        <label for="proyecto">Mes</label>
                                                                        <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
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
                                                                <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Año</label>
                                                                        <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
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
                                                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                                    <div class="form-group label-floating select-is-empty">
                                                                        <label for="proyecto">Estatus:</label>
                                                                        <select name="selectEstatusN" id="selectEstatusN" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                                                                          
                                                    </div>
                                                </div>                                       
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <table class="table-striped table-hover" id="tabla_plaza_12" name="tabla_plaza_12">
                                                        <thead>
                                                        <tr>
                                                            <th>ID USUARIO</th>
                                                            <th>USUARIO</th>
                                                            <th>SEDE USUARIO</th>
                                                            <th>IMPUESTO %</th>
                                                            <th>ABONO DISPERSADO</th>
                                                            <th>DESCUENTO</th>
                                                            <th>A PAGAR</th>
                                                            <th>NUSKAH</th>
                                                            <th>MKTD 2020</th>
                                                            <th>TOTAL</th>
                                                            <th>FORMA PAGO</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align" >Listado lotes <b>mktd</b></h3>
                                                <p class="card-title pl-1">(Lotes correspondientes a comisiones solicitadas para pago por el área de MKTD)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total:</h4>
                                                                <p class="input-tot pl-1" name="myText_proceso" id="myText_proceso">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_plaza_2" name="tabla_plaza_2">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>PROY.</th>
                                                                <th>CONDOMINIO</th>
                                                                <th>LOTE</th>
                                                                <th>REFERENCIA</th>
                                                                <th>PRECIO LOTE</th>
                                                                <th>EMP.</th>
                                                                <th>TOT. COM.</th>
                                                                <th>P. CLIENTE</th>
                                                                <th>SOLICITADO</th>
                                                                <th>TIPO VENTA</th>
                                                                <th>USUARIO</th>
                                                                <th>PUESTO</th>
                                                                <th>FEC. ENVÍO</th>
                                                                <th>MÁS</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ///////////////// -->
                                        <div class="tab-pane" id="total_comisionistas">
                                            <h3 class="card-title center-align">Total comisionista</b></h3>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="myText_nuevas_tc" id="myText_nuevas_tc">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                            <div class="container-fluid p-0">
                                                                <div class="row">
                                                                    <div class="col-md-12 p-r">
                                                                        <div class="form-group d-flex">
                                                                            <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                                            <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                                <span class="material-icons update-dataTable">search</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating select-is-empty">
                                                                <!--<label for="proyecto">Lugar prospección:</label>-->
                                                                <select name="selectEstatus" id="selectEstatus" class="selectpicker select-gral m-0"
                                                                        data-style="btn" data-show-subtext="true" data-live-search="true"
                                                                        title="Selecciona opción" data-size="7" required>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!--<div class="col-md-2">
                                                            <input type="date" name="fecha1" id="fecha1" class="form-control">
                                                        </div>
                                                        <div class="col-md-2" id="f2">
                                                            <input type="date" name="fecha2" id="fecha2" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control" id="selectEstatus" name="selectEstatus" require>
                                                                <option value="" default>---Seleccionar---</option>
                                                            </select>
                                                        </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_total_comisionistas" name="tabla_total_comisionistas">
                                                            <thead>
                                                            <tr>
                                                                <th>ID COMISIONISTA</th>
                                                                <th>ROL</th>
                                                                <th>NOMBRE</th>
                                                                <th>TOTAL</th>
                                                                <th>FECHA</th>
                                                                <th>ESTUTUS</th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ///////////////// -->
                                        <div class="tab-pane" id="total_comisionistas2">
                                            <div class="encabezadoBox">
                                                <h3 class="card-title center-align" >Comisiones nuevas <b>mktd</b></h3>
                                                <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago para el área de MKTD)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="myText_nuevas_tc2" id="myText_nuevas_tc2">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <!--<div class="col-md-2">
                                                            <input type="date" name="fechaR1" id="fechaR1" class="form-control">
                                                        </div>
                                                        <div class="col-md-2" id="f2">
                                                            <input type="date" name="fechaR2" id="fechaR2" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select class="form-control" id="selectEstatusR" name="selectEstatusR" require>
                                                                <option value="" default>---Seleccionar---</option>
                                                            </select>
                                                        </div>-->
                                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                                            <div class="container-fluid p-0">
                                                                <div class="row">
                                                                    <div class="col-md-12 p-r">
                                                                        <div class="form-group d-flex">
                                                                            <input type="text" class="form-control datepicker" id="beginDateR" value="01/01/2021" />
                                                                            <input type="text" class="form-control datepicker" id="endDateR" value="01/01/2021" />
                                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRangeR">
                                                                                <span class="material-icons update-dataTable">search</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                            <div class="form-group label-floating select-is-empty">
                                                                <!--<label for="proyecto">Lugar prospección:</label>-->
                                                                <select name="selectEstatusR" id="selectEstatusR" class="selectpicker select-gral m-0"
                                                                        data-style="btn" data-show-subtext="true" data-live-search="true"
                                                                        title="Selecciona opción" data-size="7" required>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_total_comisionistas2" name="tabla_total_comisionistas2">
                                                            <thead>
                                                            <tr>
                                                                <th>COMISIONISTA</th>
                                                                <th>PLAN</th>
                                                                <th>SEDE</th>
                                                                <th>TOTAL</th>
                                                                <th>ESTUTUS</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/ventas/revision_mktd.js"></script>
</body>