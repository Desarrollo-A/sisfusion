<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">

    <?php
    if($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="18"
        || $this->session->userdata('id_usuario')=="2767" || $this->session->userdata('id_rol')=="70"){
        //sistemas
        $this->load->view('template/sidebar');
    }
    else{
        echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
    }
    ?>

    <!-- Modals -->
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons" onclick="cleanComments()">clear</i>
                    </button>
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
                                                                <!--<th>NUSKAH</th>
                                                                <th>MKTD 2020</th>-->
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
                                        <!-----//////////////////////////////////////////////////////////////////////////////////////--->
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
                                                                        <select name="mes" id="mes" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona mes" data-size="7" required>
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
                                                                        <select name="anio" id="anio" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" title="Selecciona año" data-size="7" required>
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
                                                                        <select name="selectEstatusN" id="selectEstatusN" class="selectpicker select-gral m-0"
                                                                                data-style="btn" data-show-subtext="true" data-live-search="true"
                                                                                title="Selecciona opción" data-size="7" required>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        

                                                       
                                                    </div>
                                                                            </div>

                                         
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class="table-responsive">
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
                                        </div>
                                        <?php } ?>
                                        <!---///////////////////////////////////////////////////////////////////////----->
                                        
                                        <!-- ///////////////// -->
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
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script>
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";
    var totaPen = 0;
    var tr;


    $(document).ready(function(){
        sp.initFormExtendedDatetimepickers();
        $('.datepicker').datetimepicker({locale: 'es'});
        setInitialValues();
    });

    sp = { //  SELECT PICKER
        initFormExtendedDatetimepickers: function () {
            $('.datepicker').datetimepicker({
                format: 'MM/DD/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove',
                    inline: true
                }
            });
        }
    }

    function setInitialValues() {
        // BEGIN DATE
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
        const fechaFin = new Date();
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
        finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
        finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
        // console.log('Fecha inicio: ', finalBeginDate);
        // console.log('Fecha final: ', finalEndDate);
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        $("#beginDateR").val(convertDate(beginDate));
        $("#endDateR").val(convertDate(endDate));
        // let estatus = $("#selectEstatus").val();
        fillTable(1, finalBeginDate, finalEndDate, 0, 0);
        fillTableR(1, finalBeginDate, finalEndDate, 0, 0);
    }

    $(document).on("click", "#searchByDateRange", function () {
        /*let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);*/
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        let estatus =($("#selectEstatus").val() == '') ? 0 : $("#selectEstatus").val();
        fillTable(3, finalBeginDate, finalEndDate, 0, estatus);

    });
    function fillTable(typeTransaction, beginDate, endDate, where, estatus){
        console.log("typeTransaction: ", typeTransaction);
        console.log("beginDate: ", beginDate);
        console.log("endDate: ", endDate);
        console.log("where: ", where);
        console.log("opcion: ",  estatus);


        $("#tabla_total_comisionistas").ready( function(){
            let c=0;
            $('#tabla_total_comisionistas').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.total_dispersado);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas_tc").textContent = '$' + to;
            });

            tabla_total_comisionistas = $("#tabla_total_comisionistas").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID COMISIONISTA';
                                }
                                else if(columnIdx == 1){
                                    return 'ROL';
                                }else if(columnIdx == 2){
                                    return 'NOMBRE';
                                }else if(columnIdx == 3){
                                    return 'TOTAL';
                                }else if(columnIdx == 4){
                                    return 'FECHA';
                                }
                                else if(columnIdx == 5){
                                    return 'ESTATUS';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
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
                    "width": "4%",
                    "data": function( d ){
                        return '<p class="m-0"><br>'+d.id_usuario+'</p>';
                    }
                },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0"><br>'+d.rol+'</p>';
                        }
                    },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0"><b>'+d.nombre_comisionista+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">$'+formatMoney(d.total_dispersado)+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.fecha+'<b></b></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.nombre+'<b></b></p>';
                        }
                    }],
                ajax: {
                    url: url2 + "Comisiones/getCommissionsByMktdUser/",
                    type: "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where,
                        "estatus": estatus
                    }
                },
            });
        });
    }

    /*function totalComisones(fecha1,fecha2,estatus){
        $("#tabla_total_comisionistas").ready( function(){
            let c=0;
            $('#tabla_total_comisionistas').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.total_dispersado);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas_tc").textContent = '$' + to;
            });

            tabla_total_comisionistas = $("#tabla_total_comisionistas").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID COMISIONISTA';
                                }
                                else if(columnIdx == 1){
                                    return 'ROL';
                                }else if(columnIdx == 2){
                                    return 'NOMBRE';
                                }else if(columnIdx == 3){
                                    return 'TOTAL';
                                }else if(columnIdx == 4){
                                    return 'FECHA';
                                }
                                else if(columnIdx == 5){
                                    return 'ESTATUS';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                language: {
                    url: "<//?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "4%",
                    "data": function( d ){
                        return '<p class="m-0"><br>'+d.id_usuario+'</p>';
                    }
                },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0"><br>'+d.rol+'</p>';
                        }
                    },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0"><b>'+d.nombre_comisionista+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">$'+formatMoney(d.total_dispersado)+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.fecha+'<b></b></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0">'+d.nombre+'<b></b></p>';
                        }
                    }],
                ajax: {
                    url: url2 + "Comisiones/getCommissionsByMktdUser/"+fecha1+"/"+fecha2+"/"+estatus,
                    type: "POST",
                    cache: false,
                    data: {}
                },
            });
        });
    }*/


    $.post("<?=base_url()?>index.php/Comisiones/getEstatusPagosMktd", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#selectEstatus").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#selectEstatus").selectpicker('refresh');
    }, 'json');

    $.post("<?=base_url()?>index.php/Comisiones/getEstatusPagosMktd", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#selectEstatusN").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#selectEstatusN").selectpicker('refresh');
    }, 'json');

    $.post("<?=base_url()?>index.php/Comisiones/getEstatusPagosMktd", function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#selectEstatusR").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#selectEstatusR").selectpicker('refresh');
    }, 'json');

    /**--------------------------------------------------- */

    

    
    $('#mes').change(function(ruta) {
            anio = $('#anio').val();
            mes = $('#mes').val();
            mes = $('#mes').val();
            Estatus = $('#selectEstatusN').val();

            if(anio == '' || Estatus == ''){
            }else{
                RevisionMKTD(mes,anio,Estatus);

            }
        });

        $('#anio').change(function(ruta) {
            anio = $('#anio').val();
            mes = $('#mes').val();
            Estatus = $('#selectEstatusN').val();

            if(mes == '' || Estatus == ''){
            }else{
                RevisionMKTD(mes,anio,Estatus);
            }
            
        });

    $('#selectEstatusN').change( function(){
        mes = $('#mes').val();
        anio = $('#anio').val();
        Estatus = $('#selectEstatusN').val();

        if(mes == '' || anio == '' ){
       //     alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
        }else{
            RevisionMKTD(mes,anio,Estatus);
        }
    });

    let titulos3 = [];
        $('#tabla_plaza_12 thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            titulos3.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if (plaza_12.column(i).search() !== this.value ) {
                    plaza_12.column(i).search(this.value).draw();

                    var total = 0;
                    var totalNus=0;
                    var totalMktd=0;
                    var totalTo=0;
                    var index = plaza_12.rows({ selected: true, search: 'applied' }).indexes();
                    var data = plaza_12.rows( index ).data();

                    $.each(data, function(i, v){
                        total += parseFloat(v.impuesto);
                        totalNus += parseFloat(v.nus);
                        totalMktd += parseFloat(v.mktd);
                        totalTo += parseFloat(v.impuesto)+ parseFloat(v.nus) + parseFloat(v.mktd);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_nuevasCo").textContent = formatMoney(total);
                    var to2 = formatMoney(totalNus);
                    document.getElementById("myText_nuevasNus").textContent = formatMoney(totalNus);
                    var to3 = formatMoney(totalMktd);
                    document.getElementById("myText_nuevasMktd").textContent = formatMoney(totalMktd);

                    document.getElementById("myText_nuevasTo").textContent = formatMoney(totalTo);
                }
            });
        });


RevisionMKTD(0,0,0);
function RevisionMKTD(mes,anio,Estatus){
console.log(mes);
console.log(anio);
console.log(Estatus);

    $("#tabla_plaza_12").ready( function(){
        

        let c=0;
        $('#tabla_plaza_12').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;
            var totalNus=0;
            var totalMktd=0;
            var totalTo=0;

            $.each(json.data, function(i, v){
                total += parseFloat(v.impuesto);
                totalNus += parseFloat(v.nus);
                        totalMktd += parseFloat(v.mktd);
                        totalTo += parseFloat(v.impuesto)+ parseFloat(v.nus) + parseFloat(v.mktd);
            });
            var to = formatMoney(total);
            document.getElementById("myText_nuevasCo").textContent = '$'+formatMoney(total);
            var to2 = formatMoney(totalNus);
                    document.getElementById("myText_nuevasNus").textContent = '$'+formatMoney(totalNus);
                    var to3 = formatMoney(totalMktd);
                    document.getElementById("myText_nuevasMktd").textContent = '$'+formatMoney(totalMktd);
                    document.getElementById("myText_nuevasTo").textContent = '$'+formatMoney(totalTo);

        });

        plaza_12 = $("#tabla_plaza_12").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MKTD_CONCENTRADO_PAGO_COMISIONES',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }else if(columnIdx == 3){
                                    return 'IMPUESTO';
                                }else if(columnIdx == 4){
                                    return 'ABONO DISPERSADO';
                                }
                                else if(columnIdx == 5){
                                    return 'DESCUENTO';
                                }
                                else if(columnIdx == 6){
                                    return 'A PAGAR';
                                }
                                else if(columnIdx == 7){
                                    return 'NUSKAH';
                                }
                                else if(columnIdx == 8){
                                    return 'MKTD 2020';
                                }
                                else if(columnIdx == 9){
                                    return 'TOTAL';
                                }
                                else if(columnIdx == 10){
                                    return 'FORMA PAGO';
                                }
                            }
                        }
                },
            }],
            pagingType: "full_numbers",
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
                    return '<p class="m-0"><b>'+d.id_usuario+'</b></p>';
                }
            },
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.colaborador+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.sede+'</p>';
                    }
                },
                
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.sum_abono_marketing)+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.dcto)+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.impuesto)+'</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.nus)+'</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.mktd)+'</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        let suma = parseFloat(d.impuesto)+ parseFloat(d.nus)+ parseFloat(d.mktd);
                        return '<p class="m-0"><b>$'+formatMoney(suma)+'</b></p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.forma_pago+'</p>';
                    }
                },],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                searchable:false,
                className: 'dt-body-center'
            }],
            ajax: {
                url: url2 + "Comisiones/getDatosRevisionMktd2/"+mes+"/"+anio+"/"+Estatus,
                type: "POST",
                cache: false,
                data: function( d ){}
            },
        });

        /*$("#tabla_plaza_12 tbody").on("click", ".dispersar_colaboradores", function(){
            var tr = $(this).closest('tr');
            var row = plaza_1.row( tr );
            let c=0;
            let ubication = $(this).attr("data-value");
            let plen = $(this).val();
            $.getJSON( url + "Comisiones/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){
                let suma_01 = parseFloat(data01[0].suma_f01);

                $("#modal_colaboradores .modal-body").html("");
                $("#modal_colaboradores .modal-footer").html("");
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión total:&nbsp;&nbsp;<b>$'+formatMoney(suma_01)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');

                $.getJSON( url + "Comisiones/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){
                    var_sum = 0;
                    let fech = data1[0].fecha_plan;
                    let fecha = fech.substr(0, 10);
                    let nuevaFecha = fecha.split('-');
                    let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                    let fech2 = data1[0].fin_plan;
                    let fecha2 = fech2.substr(0, 10);
                    let nuevaFecha2 = fecha2.split('-');
                    let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div> </div>');

                    $.each( data1, function( i, v){
                        valor_money = ((v.porcentaje/100)*suma_01)
                        $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b><p>'+v.colaborador+'</p></b><p>'+v.rol+'</p><br></div>'
                            +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-5"><input type="text" readonly name="abono_marketing[]" id="abono_marketing_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                            +'</div>');
                        var_sum +=  parseFloat(v.porcentaje);
                        c++;
                    });

                    var_sum2 = parseFloat(var_sum);
                    new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                    new_valll2 = parseFloat((suma_01/100)*var_sum2);

                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
                });

                $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
                $("#modal_colaboradores").modal();
            });
        });*/
    });
}
    //FIN TABLA NUEVA
    /**------------------------------------------------------ */

    /**------------------------------------------------------- */
    $("#tabla_plaza_1").ready( function(){
        let titulos = [];
        $('#tabla_plaza_1 thead tr:eq(0) th').each( function (i) {
            var title = $(this).text();
            titulos.push(title);

            $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if (plaza_1.column(i).search() !== this.value ) {
                    plaza_1.column(i).search(this.value).draw();

                    var total = 0;
                    var index = plaza_1.rows({ selected: true, search: 'applied' }).indexes();
                    var data = plaza_1.rows( index ).data();

                    $.each(data, function(i, v){
                        total += parseFloat(v.sum_abono_marketing);
                    });
                    var to1 = formatMoney(total);
                    document.getElementById("myText_nuevas").textContent = formatMoney(total);
                }
            });
        });

        let c=0;
        $('#tabla_plaza_1').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;

            $.each(json.data, function(i, v){
                total += parseFloat(v.sum_abono_marketing);
            });
            var to = formatMoney(total);
            document.getElementById("myText_nuevas").textContent = '$' + to;
        });

        plaza_1 = $("#tabla_plaza_1").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MKTD_CONCENTRADO_PAGO_COMISIONES',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }else if(columnIdx == 3){
                                    return 'EMPRESA';
                                }else if(columnIdx == 4){
                                    return 'IMPUESTO';
                                }
                                else if(columnIdx == 5){
                                    return 'ABONO DISPERSADO';
                                }
                                else if(columnIdx == 6){
                                    return 'DESCUENTO';
                                }
                                else if(columnIdx == 7){
                                    return 'A PAGAR';
                                }
                                else if(columnIdx == 8){
                                    return 'FORMA PAGO';
                                }
                            }
                        }
                },
            }],
            pagingType: "full_numbers",
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
                    return '<p class="m-0"><b>'+d.id_usuario+'</b></p>';
                }
            },
                {
                    "width": "20%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.colaborador+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.sede+'</p>';
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
                        return '<p class="m-0"><b>'+d.valimpuesto+'%</b></p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.sum_abono_marketing)+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0">$'+formatMoney(d.dcto)+'</p>';
                    }
                },
                {
                    "width": "10%",
                    "data": function( d ){
                        return '<p class="m-0"><b>$'+formatMoney(d.impuesto)+'</b></p>';
                    }
                },
                {
                    "width": "15%",
                    "data": function( d ){
                        return '<p class="m-0">'+d.forma_pago+'</p>';
                    }
                },],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                searchable:false,
                className: 'dt-body-center'
            }],
            ajax: {
                url: url2 + "Comisiones/getDatosRevisionMktd",
                type: "POST",
                cache: false,
                data: function( d ){}
            },
        });

        /*$("#tabla_plaza_1 tbody").on("click", ".dispersar_colaboradores", function(){
            var tr = $(this).closest('tr');
            var row = plaza_1.row( tr );
            let c=0;
            let ubication = $(this).attr("data-value");
            let plen = $(this).val();
            $.getJSON( url + "Comisiones/getDatosSumaMktd/"+ubication+"/"+plen).done( function( data01 ){
                let suma_01 = parseFloat(data01[0].suma_f01);

                $("#modal_colaboradores .modal-body").html("");
                $("#modal_colaboradores .modal-footer").html("");
                $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión total:&nbsp;&nbsp;<b>$'+formatMoney(suma_01)+'</b></p> </div></div>');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="total_comi" value="'+data01[0].suma_f01+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="num_plan" value="'+plen+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="valores_pago_i" value="'+data01[0].valor_obtenido+'">');
                $("#modal_colaboradores .modal-body").append('<input type="hidden" name="pago_mktd" id="pago_mktd" value="'+parseFloat(suma_01)+'">');

                $.getJSON( url + "Comisiones/getDatosColabMktd/"+ubication+"/"+plen).done( function( data1 ){
                    var_sum = 0;
                    let fech = data1[0].fecha_plan;
                    let fecha = fech.substr(0, 10);
                    let nuevaFecha = fecha.split('-');
                    let fechaCompleta = nuevaFecha[2]+'-'+nuevaFecha[1]+'-'+nuevaFecha[0];
                    let fech2 = data1[0].fin_plan;
                    let fecha2 = fech2.substr(0, 10);
                    let nuevaFecha2 = fecha2.split('-');
                    let fechaCompleta2 = nuevaFecha2[2]+'-'+nuevaFecha2[1]+'-'+nuevaFecha2[0];
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-4"><p style="color:blue;">Número plan:&nbsp;&nbsp;<b>'+data1[0].id_plan+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Inicio:&nbsp;&nbsp;<b>'+fechaCompleta+'</b></p> </div>  <div class="col-lg-4"><p style="color:green;">Fin:&nbsp;&nbsp;<b>'+fechaCompleta2+'</b></p> </div> </div>');

                    $.each( data1, function( i, v){
                        valor_money = ((v.porcentaje/100)*suma_01)
                        $("#modal_colaboradores .modal-body").append('<div class="row"><input type="hidden" name="user_mktd[]" value="'+v.id_usuario+'"><div class="col-md-5"><b><p>'+v.colaborador+'</p></b><p>'+v.rol+'</p><br></div>'
                            +'<div class="col-md-2"><input type="text" name="porcentaje_mktd[]" readonly class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+v.porcentaje+'%'+'"></div>'+'<div class="col-md-5"><input type="text" readonly name="abono_marketing[]" id="abono_marketing_'+i+'"  class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" value="'+parseFloat(valor_money.toFixed(3))+'"></div>'
                            +'</div>');
                        var_sum +=  parseFloat(v.porcentaje);
                        c++;
                    });

                    var_sum2 = parseFloat(var_sum);
                    new_valll = parseFloat((suma_01)-((suma_01/100)*var_sum2));
                    new_valll2 = parseFloat((suma_01/100)*var_sum2);

                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión distribuida:&nbsp;&nbsp;<b>'+new_valll2.toFixed(3)+'</b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Comisión restante:&nbsp;&nbsp;<b style="color:red;">'+new_valll.toFixed(3)+'</b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<div class="row"><div class="col-lg-12"><p>Suma: <b id="Sumto" style="color:red;"></b></p> </div></div>');
                    $("#modal_colaboradores .modal-body").append('<input type="hidden" name="cuantos" id="cuantos" value="'+c+'">');
                });

                $("#modal_colaboradores .modal-footer").append('<br><div class="row"><div class="col-md-6"><center><input type="submit" class="btn btn-success" value="DISPERSAR"></center></div><div class="col-md-6"><center><input type="button" class="btn btn-danger"  data-dismiss="modal" value="CANCELAR"></center></div></div>');
                $("#modal_colaboradores").modal();
            });
        });*/
    });
    //FIN TABLA NUEVA

    // INICIO TABLA EN PROCESO
    $("#tabla_plaza_2").ready( function(){
        let titulos = [];
        $('#tabla_plaza_2 thead tr:eq(0) th').each( function (i) {
            if( i!=0 && i!=15){
                var title = $(this).text();
                titulos.push(title);
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {

                    if (plaza_2.column(i).search() !== this.value ) {
                        plaza_2.column(i).search(this.value).draw();

                        var total = 0;
                        var index = plaza_2.rows({ selected: true, search: 'applied' }).indexes();
                        var data = plaza_2.rows( index ).data();

                        $.each(data, function(i, v){
                            total += parseFloat(v.pago_cliente);
                        });
                        var to1 = formatMoney(total);
                        document.getElementById("myText_proceso").textContent = formatMoney(total);
                    }
                });
            }
        });

        let c=0;
        $('#tabla_plaza_2').on('xhr.dt', function ( e, settings, json, xhr ) {
            var total = 0;
            $.each(json.data, function(i, v){
                total += parseFloat(v.pago_cliente);
            });
            var to = formatMoney(total);
            document.getElementById("myText_proceso").textContent = '$' + to;
        });

        plaza_2 = $("#tabla_plaza_2").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons:  [
                <?php if($this->session->userdata('id_rol') == 13 || $this->session->userdata('id_rol') == 17 ){?>
                {
                    text: '<i class="fa fa-check"></i> ENVIAR A INTERNOMEX',
                    action: function(){
                        $.get(url+"Comisiones/acepto_contraloria_MKTD/").done(function () {
                            $("#myModalEnviadas").modal('toggle');
                            plaza_2.ajax.reload();
                            plaza_1.ajax.reload();
                            $("#myModalEnviadas .modal-body").html("");
                            $("#myModalEnviadas").modal();
                            $("#myModalEnviadas .modal-body").append("<center><img style='width: 75%; height: 75%;' src='<?= base_url('dist/img/send_intmex.gif')?>'><p style='color:#676767;'>Comisiones del área <b>Marketing Dígital</b> fueron enviadas a <b>INTERNOMEX</b> correctamente.</p></center>");
                        });
                    },
                    attr: {
                        class: 'btn btn-azure',
                        style: 'position: relative; float: right;',
                    }
                },
                <?php } ?>
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'MARKETING_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 3){
                                    return 'NOMBRE LOTE ';
                                }else if(columnIdx == 4){
                                    return 'REFERENCIA';
                                }else if(columnIdx == 5){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 6){
                                    return 'EMPRESA';
                                }else if(columnIdx == 7){
                                    return 'TOT. COMISIÓN';
                                }else if(columnIdx == 8){
                                    return 'P. CLIENTE';
                                }else if(columnIdx == 9){
                                    return 'TOT. PAGAR';
                                }else if(columnIdx == 10){
                                    return 'TIPO VENTA';
                                }else if(columnIdx == 11){
                                    return 'COMISIONISTA';
                                }else if(columnIdx == 12){
                                    return 'PUESTO';
                                }else if(columnIdx == 13){
                                    return 'FECH. ENVÍO';
                                }
                                else if(columnIdx != 14 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
            pagingType: "full_numbers",
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
                    return '<p style="font-size: .8em">'+d.id_pago_i+'</p>';
                }
            },
                {
                    "width": "3%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">'+d.proyecto+'</p>';
                    }
                },{
                    "width": "5%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">'+d.condominio+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p style="font-size: .8em"><b>'+d.lote+'</b></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">'+d.referencia+'</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">$'+formatMoney(d.precio_lote)+'</p>';
                    }
                },
                {
                    "width": "3%",
                    "data": function( d ){
                        return '<p style="font-size: .8em"><b>'+d.empresa+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">$'+formatMoney(d.comision_total)+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">$'+formatMoney(d.pago_neodata)+'</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        return '<p style="font-size: .8em">$'+formatMoney(d.pago_cliente)+'</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        if(d.lugar_prospeccion == 6){
                            return '<p style="font-size: .8em">COMISIÓN + MKTD <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                        }
                        else{
                            return '<p style="font-size: .8em">COMISIÓN <br><b> ('+d.porcentaje_decimal+'% de '+d.porcentaje_abono+'%)</b></p>';
                        }

                    }
                },
                {
                    "width": "8%",
                    "data": function( d ){
                        return '<p style="font-size: .8em"><b>'+d.usuario+'</b></i></p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function( d ){
                        return '<p style="font-size: .8em"><i> '+d.puesto+'</i></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function( d ){
                        var BtnStats1;
                        BtnStats1 =  '<p style="font-size: .8em">'+d.fecha_creacion+'</p>';
                        return BtnStats1;
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function( data ){

                        var BtnStats;

                        BtnStats = '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn btn-round btn-fab btn-fab-mini consultar_logs_asimilados" style="background: #3982C0;" title="Detalles">' +'<span class="material-icons">info</span></button>&nbsp;';
                        return BtnStats;

                    }
                }],
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets:   0,
                'searchable':false,
                'className': 'dt-body-center',
                select: {
                    style:    'os',
                    selector: 'td:first-child'
                },
            }],
            ajax: {
                url: url2 + "Comisiones/getDatosNuevasmkContraloria",
                type: "POST",
                cache: false,
                data: function( d ){}
            },
        });

        $("#tabla_plaza_2 tbody").on("click", ".consultar_logs_asimilados", function(e){
            e.preventDefault();
            e.stopImmediatePropagation();

            id_pago = $(this).val();
            lote = $(this).attr("data-value");

            $("#seeInformationModal").modal();
            $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DEL PAGO DE: <b>'+lote+'</b></h5></p>');
            $.getJSON("getComments/"+id_pago).done( function( data ){
                $.each( data, function(i, v){
                    $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:gray;">'+v.comentario+'</i><br><b style="color:#3982C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                });
            });
        });
    });

    // FIN TABLA PROCESO
    $('#fecha1').change( function(){
        fecha1 = $(this).val();
        let fecha2 = $('#fecha2').val();
        let opcion = $('#selectEstatus').val();
        if(fecha2 == ''){

        }
        else{
            totalComisones(fecha1, fecha2, opcion);
        }
    });

    $('#fecha2').change( function(){
        fecha2 = $(this).val();
        let fecha1 = $('#fecha1').val();
    });

    $('#selectEstatus').change( function(){
        // estatus = $(this).val();
        /*if(fecha1 == '' || fecha2 == '' || estatus == ''){
            alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
        }else{
            totalComisones(fecha1,fecha2,estatus);
        }*/

        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        let estatus =($(this).val() == '') ? 0 : $(this).val();
        fillTable(1, finalBeginDate, finalEndDate, 0, estatus);
    });

    // totalComisones(0,0,0);
    // fillTable(0,0,0,0,0);
    let titulos = [];
    $('#tabla_total_comisionistas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead" id="t-'+i+'" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_total_comisionistas.column(i).search() !== this.value ) {
                tabla_total_comisionistas
                    .column(i)
                    .search(this.value)
                    .draw();

                var total = 0;
                var index = tabla_total_comisionistas.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_total_comisionistas.rows( index ).data();

                $.each(data, function(i, v){
                    total += parseFloat(v.total_dispersado);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_nuevas_tc").textContent = formatMoney(total);
            }
        });
    });





    // FIN TABLA PROCESO

    /*$('#fechaR1').change( function(){
        fecha1 = $(this).val();
        let fecha2 = $('#fechaR2').val();
    });*/

    /*$('#fechaR2').change( function(){
        fecha2 = $(this).val();
        let fecha1 = $('#fechaR1').val();
    });*/

    $('#selectEstatusR').change( function(){
        // estatus = $(this).val();
        // let fecha1 = $('#fechaR1').val();
        // let fecha2 = $('#fechaR2').val();
        // if(fecha1 == '' || fecha2 == '' || estatus == ''){
        //     alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
        // }
        // else{
        //     totalComisonesR(fecha1,fecha2,estatus);
        // }
        let finalBeginDate = $("#beginDateR").val();
        let finalEndDate = $("#endDateR").val();
        let estatus =($(this).val() == '') ? 0 : $(this).val();
        fillTableR(1, finalBeginDate, finalEndDate, 0, estatus);
    });

    // totalComisonesR(0,0,0);
    let titulos2 = [];
    $('#tabla_total_comisionistas2 thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text"  id="t-'+i+'" class="textoshead" placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (tabla_total_comisionistas2.column(i).search() !== this.value ) {
                tabla_total_comisionistas2
                    .column(i)
                    .search(this.value)
                    .draw();

                var total = 0;
                var index = tabla_total_comisionistas2.rows({ selected: true, search: 'applied' }).indexes();
                var data = tabla_total_comisionistas2.rows( index ).data();

                $.each(data, function(i, v){
                    total += parseFloat(v.total);
                });
                var to1 = formatMoney(total);
                document.getElementById("myText_nuevas_tc2").textContent = formatMoney(total);
            }
        });
    });

    function fillTableR(typeTransaction, beginDate, endDate, where, estatus){
        console.log('/*****************segundo******************/');
        console.log("typeTransaction: ", typeTransaction);
        console.log("beginDate: ", beginDate);
        console.log("endDate: ", endDate);
        console.log("where: ", where);
        console.log("opcion: ",  estatus);

        $("#tabla_total_comisionistas2").ready( function(){
            let c=0;

            $('#tabla_total_comisionistas2').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.total);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas_tc2").textContent = '$' + to;
            });

            tabla_total_comisionistas2 = $("#tabla_total_comisionistas2").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'COMISIONISTA';
                                }
                                else if(columnIdx == 1){
                                    return 'PLAN';
                                }else if(columnIdx == 2){
                                    return 'SEDE';
                                }else if(columnIdx == 3){
                                    return 'TOTAL';
                                }else if(columnIdx == 4){
                                    return 'ESTATUS';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
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
                    "width": "4%",
                    "data": function( d ){
                        return '<p class="m-0"><center>MKTD COMISIONES</center></p>';
                    }
                },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0"><center>'+d.id_plan+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0"><center><b>'+d.sede+'</b></center></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0"><center>$'+formatMoney(d.total)+'</center></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>'+d.nombre+'</center></p>';
                        }
                    }],
                ajax: {
                    url: url2 + "Comisiones/getCommissionsByMktdUserReport/",
                    type: "POST",
                    cache: false,
                    data: {
                        "typeTransaction": typeTransaction,
                        "beginDate": beginDate,
                        "endDate": endDate,
                        "where": where,
                        "estatus": estatus
                    }
                },
            });/**/
        });
    }

    $(document).on("click", "#searchByDateRangeR", function () {
        /*let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        fillTable(3, finalBeginDate, finalEndDate, 0);*/
        let finalBeginDate = $("#beginDateR").val();
        let finalEndDate = $("#endDateR").val();
        let estatus =($("#selectEstatusR").val() == '') ? 0 : $("#selectEstatusR").val();
        fillTableR(3, finalBeginDate, finalEndDate, 0, estatus);

    });


    /*function totalComisonesR(fecha1,fecha2,estatus){
        $("#tabla_total_comisionistas2").ready( function(){
            let c=0;

            $('#tabla_total_comisionistas2').on('xhr.dt', function ( e, settings, json, xhr ) {
                var total = 0;
                $.each(json.data, function(i, v){
                    total += parseFloat(v.total);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas_tc2").textContent = '$' + to;
            });

            tabla_total_comisionistas2 = $("#tabla_total_comisionistas2").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: "auto",
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'MKTD_CONTRALORÍA_SISTEMA_COMISIONES',
                    exportOptions: {
                        columns: [0,1,2,3,4,5],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID COMISIONISTA';
                                }
                                else if(columnIdx == 1){
                                    return 'ROL';
                                }else if(columnIdx == 2){
                                    return 'NOMBRE';
                                }else if(columnIdx == 3){
                                    return 'TOTAL';
                                }else if(columnIdx == 4){
                                    return 'FECHA';
                                }
                                else if(columnIdx == 5){
                                    return 'ESTATUS';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                language: {
                    url: "<//?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "4%",
                    "data": function( d ){
                        return '<p class="m-0"><center>MKTD COMISIONES</center></p>';
                    }
                },
                    {
                        "width": "6%",
                        "data": function( d ){
                            return '<p class="m-0"><center>'+d.id_plan+'</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0"><center><b>'+d.sede+'</b></center></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p class="m-0"><center>$'+formatMoney(d.total)+'</center></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){
                            return '<p style="font-size: .8em"><center>'+d.nombre+'</center></p>';
                        }
                    }],
                ajax: {
                    url: url2 + "Comisiones/getCommissionsByMktdUserReport/"+fecha1+"/"+fecha2+"/"+estatus,
                    type: "POST",
                    cache: false,
                    data: function( d ){}
                },
            });
        });
    }*/

    // INICIO TABLA EN PROCESO

    // FUNCTION MORE
    /*$(document).on( "click", ".nuevo_plan", function(){
        $("#modal_mktd .modal-body").html("");
        $("#modal_mktd .modal-footer").html("");

        $.getJSON( url + "Comisiones/getDatosNuevo/").done( function( data1 ){
            $("#modal_mktd .modal-body").append('<div class="row"><div class="col-md-6"><label>Fecha inicio: </label><input type="date" class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" name="fecha_inicio" id="fecha_inicio" required=""></div></div>');
            $.each( data1, function( i, v){
                $("#modal_mktd .modal-body").append('<div class="row">'
                    +'<div class="col-md-3"><br><input class="form-contol ng-invalid ng-invalid-required" style="border: 1px solid white; outline: none;" value="'+v.puesto+'"  readonly><input id="puesto" name="puesto[]" value="'+v.id_rol+'" type="hidden"></div>'

                    +'<div class="col-md-3"><select id="userMKTDSelect'+i+'" name="userMKTDSelect[]" class="form-control userMKTDSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div>'

                    +'<div class="col-md-2"><input id="porcentajeUserMk'+i+'" name="porcentajeUserMk[]" class="form-control porcentajeUserMk ng-invalid ng-invalid-required" required placeholder="%" value="0"></div>'

                    +'<div class="col-md-2"><select id="plazaMKTDSelect'+i+'" name="plazaMKTDSelect[]" class="form-control plazaMKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div>'

                    +'<div class="col-md-2"><select id="sedeMKTDSelect'+i+'" name="sedeMKTDSelect[]" class="form-control sedeMKTDSelect ng-invalid ng-invalid-required"   data-live-search="true"></select></div></div>');

                $.post('getUserMk', function(data) {
                    $("#userMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                    var len = data.length;
                    for( var j = 0; j<len; j++){
                        var id = data[j]['id_usuario'];
                        var name = data[j]['name_user'];
                        $("#userMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                    }

                    if(len<=0){
                        $("#userMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                    }

                    $("#userMKTDSelect"+i+"").val(data1[i].id_usuario);
                    $("#userMKTDSelect"+i+"").selectpicker('refresh');
                }, 'json');

                $.post('getPlazasMk', function(data) {
                    $("#plazaMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                    var len = data.length;
                    for( var j = 0; j<len; j++){
                        var id = data[j]['id_opcion'];
                        var name = data[j]['nombre'];
                        $("#plazaMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                    }

                    if(len<=0){
                        $("#plazaMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                    }

                    $("#plazaMKTDSelect"+i+"").val(1);
                    $("#plazaMKTDSelect"+i+"").selectpicker('refresh');
                }, 'json');

                $.post('getSedeMk', function(data) {
                    $("#sedeMKTDSelect"+i+"").append($('<option disabled>').val("default").text("Seleccione una opción"))
                    var len = data.length;
                    for( var j = 0; j<len; j++){
                        var id = data[j]['id_sede'];
                        var name = data[j]['nombre'];

                        $("#sedeMKTDSelect"+i+"").append($('<option>').val(id).attr('data-value', id).text(name));
                    }

                    if(len<=0){
                        $("#sedeMKTDSelect"+i+"").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                    }

                    if(data1[i].id_rol=='20'){
                        $("#sedeMKTDSelect"+i+"").val(data1[i].id_sede);
                    }
                    else{
                        $("#sedeMKTDSelect"+i+"").val(2);
                    }

                    $("#sedeMKTDSelect"+i+"").selectpicker('refresh');
                }, 'json');
            });
        });

        $("#modal_mktd .modal-footer").append('<br><div class="row"><div class="col-md-12"><center><input type="submit" id="btnsubmit" class="btn btn-success" value="GUARDAR"></center></div></div>');
        $("#modal_mktd").modal();
    });*/

    function formatMoney( n ) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    /*$(document).on( "click", ".subir_factura", function(){
        resear_formulario();
        id_comision = $(this).val();
        link_post = "Comisiones/guardar_solicitud/"+id_comision;
        $("#modal_formulario_solicitud").modal( {backdrop: 'static', keyboard: false} );
    });*/

    //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
    /*function resear_formulario(){
        $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
        $("#modal_formulario_solicitud textarea").html('');
        $("#modal_formulario_solicitud #obse").val('');

        var validator = $( "#frmnewsol" ).validate();
        validator.resetForm();
        $( "#frmnewsol div" ).removeClass("has-error");
    }*/

    /*$("#cargar_xml").click( function(){
        subir_xml( $("#xmlfile") );
    });*/

    var justificacion_globla = "";

    /*function subir_xml( input ){
        var data = new FormData();
        documento_xml = input[0].files[0];
        var xml = documento_xml;
        data.append("xmlfile", documento_xml);
        resear_formulario();

        $.ajax({
            url: url + "Comisiones/cargaxml",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            success: function(data){
                if( data.respuesta[0] ){
                    documento_xml = xml;
                    var informacion_factura = data.datos_xml;
                    cargar_info_xml( informacion_factura );
                    $("#solobs").val( justificacion_globla );
                }
                else{
                    input.val('');
                    alert( data.respuesta[1] );
                }
            },
            error: function( data ){
                input.val('');
                alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
            }
        });
    }*/

    /*function cargar_info_xml( informacion_factura ){

        $("#emisor").val( ( informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '') ).attr('readonly',true);
        $("#rfcemisor").val( ( informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '') ).attr('readonly',true);

        $("#receptor").val( ( informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '') ).attr('readonly',true);
        $("#rfcreceptor").val( ( informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '') ).attr('readonly',true);

        $("#regimenFiscal").val( ( informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '') ).attr('readonly',true);

        $("#formaPago").val( ( informacion_factura.formaPago ? informacion_factura.formaPago[0] : '') ).attr('readonly',true);
        $("#total").val( ('$ '+informacion_factura.total ? '$ '+informacion_factura.total[0] : '') ).attr('readonly',true);

        $("#cfdi").val( ( informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '') ).attr('readonly',true);

        $("#metodopago").val( ( informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '') ).attr('readonly',true);

        $("#unidad").val( ( informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '') ).attr('readonly',true);

        $("#clave").val( ( informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '') ).attr('readonly',true);

        $("#obse").val( ( informacion_factura.descripcion ? informacion_factura.descripcion[0] : '') ).attr('readonly',true);
    }*/

    /*$("#form_colaboradores").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            $('#loader').removeClass('hidden');
            var data = new FormData( $(form)[0] );
            let sumat=0;
            let valor = parseFloat($('#pago_mktd').val()).toFixed(3);
            let valor1 = parseFloat(valor-0.10);
            let valor2 = parseFloat(valor)+0.010;

            for(let i=0;i<$('#cuantos').val();i++){
                sumat += parseFloat($('#abono_marketing_'+i).val());
            }

            let sumat2 =  parseFloat((sumat).toFixed(3));
            document.getElementById('Sumto').innerHTML= ''+ parseFloat(sumat2.toFixed(3)) +'';

            if(parseFloat(sumat2.toFixed(3)) < valor1){
                alerts.showNotification("top", "right", "Falta dispersar", "warning");
            }
            else if(parseFloat(sumat2.toFixed(3)) >= valor1 && parseFloat(sumat2.toFixed(3)) <= valor2 ){
                $.ajax({
                    url: url2 + "Comisiones/nueva_mktd_comision",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if(true){
                            $('#loader').addClass('hidden');
                            $("#modal_colaboradores").modal('toggle');
                            plaza_2.ajax.reload();
                            plaza_1.ajax.reload();
                            alert("¡Se agregó con éxito!");
                        }else{
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                            $('#loader').addClass('hidden');
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
            else if(parseFloat(sumat2.toFixed(3)) > valor1 && parseFloat(sumat2.toFixed(3)) > valor2 ){
                alerts.showNotification("top", "right", "Cantidad excedida", "danger");
            }

        }
    });*/

    /*$("#frmnewsol").submit( function(e) {
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            var data = new FormData( $(form)[0] );
            data.append("xmlfile", documento_xml);
            $.ajax({
                url: url + link_post,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data.resultado ){
                        alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_formulario_solicitud").modal( 'toggle' );
                        tabla_nuevas.ajax.reload();
                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                },error: function(){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });*/

    /*$("#form_MKTD").submit( function(e) {
        e.preventDefault();
    }).validate({
        rules: {
            'porcentajeUserMk[]':{
                required: true,
            }
        },
        messages: {
            'porcentajeUserMk[]':{
                required : "Dato requerido"
            }
        },
        submitHandler: function( form ) {
            var data = new FormData( $(form)[0] );
            $.ajax({
                url: url + "Comisiones/save_new_mktd",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data.resultado ){
                        alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_mktd").modal( 'toggle' );
                    }else{
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                    }
                },error: function(){
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }
    });*/

    /*function calcularMontoParcialidad() {
        $precioFinal = parseFloat($('#value_pago_cliente').val());
        $precioNuevo = parseFloat($('#new_value_parcial').val());

        if ($precioNuevo >= $precioFinal) {
            $('#label_estado').append('<label>MONTO NO VALIDO</label>');
        }
        else if ($precioNuevo < $precioFinal) {
            $('#label_estado').append('<label>MONTO VALIDO</label>');
        }
    }*/

    /*function preview_info(archivo){
        $("#documento_preview .modal-dialog").html("");
        $("#documento_preview").css('z-index', 9999);
        archivo = url+"dist/documentos/"+archivo+"";
        var re = /(?:\.([^.]+))?$/;
        var ext = re.exec(archivo)[1];
        elemento = "";
        if (ext == 'pdf'){
            elemento += '<iframe src="'+archivo+'" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
            elemento += '</iframe>';
            $("#documento_preview .modal-dialog").append(elemento);
            $("#documento_preview").modal();
        }
        if(ext == 'jpg' || ext == 'jpeg'){
            elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
            elemento += '<img src="'+archivo+'" style="overflow:hidden; width: 40%;">';
            elemento += '</div>';
            $("#documento_preview .modal-dialog").append(elemento);
            $("#documento_preview").modal();
        }
        if(ext == 'xlsx'){
            elemento += '<div class="modal-content">';
            elemento += '<iframe src="'+archivo+'"></iframe>';
            elemento += '</div>';
            $("#documento_preview .modal-dialog").append(elemento);
        }
    }*/

    function cleanComments() {
        var myCommentsList = document.getElementById('comments-list-asimilados');
        var myCommentsLote = document.getElementById('nameLote');
        myCommentsList.innerHTML = '';
        myCommentsLote.innerHTML = '';
    }

    $(window).resize(function(){
        plaza_1.columns.adjust();
        plaza_2.columns.adjust();

    });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

    /*$(document).ready( function(){
        $.getJSON( url + "Comisiones/report_plazas").done( function( data ){
            $(".report_plazas").html();
            $(".report_plazas1").html();
            $(".report_plazas2").html();

            if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
                if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
                }

            }
            if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
                if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
                }

            }

            if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
                if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
                }
            }
        });
    });*/

    /*$(document).ready( function(){
        $.getJSON( url + "Comisiones/report_plazas").done( function( data ){
            $(".report_plazas").html();
            $(".report_plazas1").html();
            $(".report_plazas2").html();

            if(data[0].id_plaza == '0' || data[1].id_plaza == 0){
                if(data[0].plaza00==null || data[0].plaza00=='null' ||data[0].plaza00==''){
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas").append('<label style="color: #6a2c70;">&nbsp;<b>Porcentaje:</b> '+data[0].plaza01+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[0].plaza00+'%</label>');
                }

            }
            if(data[1].id_plaza == '1' || data[1].id_plaza == 1){
                if(data[1].plaza10==null || data[1].plaza10=='null' ||data[1].plaza10==''){
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas1").append('<label style="color: #b83b5e;">&nbsp;<b>Porcentaje:</b> '+data[1].plaza11+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[1].plaza10+'%</label>');
                }

            }

            if(data[2].id_plaza == '2' || data[2].id_plaza == 2){
                if(data[2].plaza20==null || data[2].plaza20=='null' ||data[2].plaza20==''){
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> 0%</label>');
                }
                else{
                    $(".report_plazas2").append('<label style="color: #f08a5d;">&nbsp;<b>Porcentaje:</b> '+data[2].plaza21+'%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Restante</b> '+data[2].plaza20+'%</label>');
                }

            }
        });
    });*/

    $("#idloteorigen").select2({dropdownParent:$('#miModal')});

    $(document).ready(function () {
        $.post(url + "Comisiones/getMktdRol", function (data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre']+' '+data[i]['apellido_paterno']+' '+data[i]['apellido_materno'];
                $("#usuarioid").append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#usuarioid").selectpicker('refresh');
        }, 'json');
    });

    $("#usuarioid").change(function() {
        document.getElementById('monto').value = '';
        document.getElementById('idmontodisponible').value = '';
        var user = $(this).val();
        $('#idloteorigen option').remove(); // clear all values

        $.post('getLotesOrigenmk/'+user, function(data) {
            $("#idloteorigen").append($('<option disabled>').val("default").text("Seleccione una opción"));
            var len = data.length;

            for( var i = 0; i<len; i++)
            {
                var name = data[i]['nombreLote'];
                var comision = data[i]['id_pago_i'];
                var pago_neodata = data[i]['pago_neodata'];
                let comtotal = data[i]['comision_total'] -data[i]['abono_pagado'];


                $("#idloteorigen").append(`<option value='${comision},${comtotal.toFixed(2)},${pago_neodata}'> $${ formatMoney(comtotal.toFixed(2))}</option>`);
            }
            if(len<=0)
            {
                $("#idloteorigen").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#idloteorigen").selectpicker('refresh');
        }, 'json');
    });

    $("#idloteorigen").change(function() {
        let cuantos = $('#idloteorigen').val().length;
        let suma =0;

        if(cuantos > 1){
            var comision = $(this).val();
            for (let index = 0; index < $('#idloteorigen').val().length; index++) {
                datos = comision[index].split(',');
                let id = datos[0];
                let monto = datos[1];
                document.getElementById('monto').value = '';

                $.post('getInformacionDataMK/'+id, function(data) {
                    var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                    var idecomision = data[0]['id_pago_i'];
                    suma = suma + disponible;
                    document.getElementById('montodisponible').innerHTML = '';

                    $("#idmontodisponible").val('$'+formatMoney(suma));
                    $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+suma.toFixed(2)+'">');
                    $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');

                    var len = data.length;

                    if(len<=0){
                        $("#idmontodisponible").val('$'+formatMoney(0));
                    }
                    $("#montodisponible").selectpicker('refresh');
                }, 'json');
            }
        }
        else{
            var comision = $(this).val();
            datos = comision[0].split(',');
            let id = datos[0];
            let monto = datos[1];
            document.getElementById('monto').value = '';
            $.post('getInformacionDataMK/'+id, function(data) {
                var disponible = (data[0]['comision_total']-data[0]['abono_pagado']);
                var idecomision = data[0]['id_pago_i'];

                document.getElementById('montodisponible').innerHTML = '';
                $("#montodisponible").append('<input type="hidden" name="valor_comision" id="valor_comision" value="'+disponible+'">');
                $("#idmontodisponible").val('$'+formatMoney(disponible));

                $("#montodisponible").append('<input type="hidden" name="ide_comision" id="ide_comision" value="'+idecomision+'">');

                var len = data.length;

                if(len<=0){
                    $("#idmontodisponible").val('$'+formatMoney(0));
                }

                $("#montodisponible").selectpicker('refresh');
            }, 'json');
        }
    });

    function verificar(){
        let disponible = parseFloat($('#valor_comision').val()).toFixed(2);
        let monto = parseFloat($('#monto').val()).toFixed(2);

        if(monto < 1 || isNaN(monto)){
            alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
            document.getElementById('btn_abonar').disabled=true;
        }
        else{
            if(parseFloat(monto) <= parseFloat(disponible) ){
                let cantidad = parseFloat($('#numeroP').val());
                resultado = monto /cantidad;
                $('#pago').val(formatMoney(resultado));
                document.getElementById('btn_abonar').disabled=false;
                console.log('OK');

                let cuantos = $('#idloteorigen').val().length;
                let cadena = '';
                var data = $('#idloteorigen').select2('data')
                for (let index = 0; index < cuantos; index++) {

                    let datos = data[index].id;
                    let montoLote = datos.split(',');
                    let abono_neo = montoLote[1];
                    if(parseFloat(abono_neo) > parseFloat(monto) && cuantos > 1){
                        document.getElementById('msj2').innerHTML="El monto ingresado se cubre con la comisión "+data[index].text;
                        document.getElementById('btn_abonar').disabled=true;
                        break;
                    }

                    cadena = cadena+' , '+data[index].text;
                    document.getElementById('msj2').innerHTML='';
                }

                $('#comentario').val('PAGOS DESCUENTO: '+cadena+'. Por la cantidad de: $'+formatMoney(monto));
            }
            else if(parseFloat(monto) > parseFloat(disponible) ){
                alerts.showNotification("top", "right", "Monto a descontar mayor a lo disponible", "danger");

                document.getElementById('monto').value = '';
                document.getElementById('btn_abonar').disabled=true;
            }
        }
    }

    $("#form_descuentos").on('submit', function(e){
        e.preventDefault();
        document.getElementById('btn_abonar').disabled=true;
        let formData = new FormData(document.getElementById("form_descuentos"));
        formData.append("dato", "valor");
        $.ajax({
            url: 'saveDescuentomk/'+1,
            data: formData,
            method: 'POST',
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) {
                if (data == 1) {
                    document.getElementById('btn_abonar').disabled=false;
                    document.getElementById("form_descuentos").reset();
                    plaza_1.ajax.reload();

                    $('#miModal').modal('hide');
                    $('#idloteorigen option').remove();
                    $("#roles").val('');
                    $("#roles").selectpicker("refresh");
                    $('#usuarioid').val('default');
                    $("#usuarioid").selectpicker("refresh");
                    $('#tabla_descuentos').DataTable().ajax.reload(null, false);

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
</script>
</body>