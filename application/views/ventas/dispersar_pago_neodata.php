<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">        
            #modal_nuevas{
                z-index: 1041!important;
            }

            #modal_vc{
                z-index: 1041!important;
            }
        </style>

        <!-- Modals -->

        <div class="modal fade" id="detalle-plan-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="material-icons">clear</i></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" id="planes-div">
                                <div class="form-group">
                                    <select class="selectpicker select-gral" id="planes" name="planes" data-style="btn" required>
                                    </select>
                                </div>
                            </div>
                            <div id="detalle-tabla-div"
                                 class="col-lg-12">
                                <table class="table table-bordered"
                                       id="plan-detalle-tabla">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="color:white; text-align: center; font-weight: bold;">PUESTO</th>
                                            <th scope="col" style="color:white; text-align: center; font-weight: bold;">% COMISIÓN</th>
                                            <th scope="col" style="color:white; text-align: center; font-weight: bold;">% NEODATA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="plan-detalle-tabla-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reporte dispersion</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" name="fecha1" id="fecha1" class="form-control">
                            </div>
                            <div class="col-md-6" id="f2">
                                <input type="date" name="fecha2" id="fecha2" class="form-control"> 
                            </div>
                        </div>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myUpdateBanderaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="my_updatebandera_form" name="my_updatebandera_form" method="post">
                    <div class="modal-header">
                        <button type="button"class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Modificar estatus</b></h4>
                    </div>
                        <div class="modal-body" style="text-align: center;">
                        </div>
                        <div class="modal-footer">
                        <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas"
             id="detenciones-modal"
             role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <form method="post"
                          class="row"
                          id="detenidos-form"
                          autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden"
                                   name="id_pagoc"
                                   id="id-lote-detenido">
                                   <input type="hidden"
                                   name="statusLote"
                                   id="statusLote">
                            
                            <!-- <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <input id="motivo" name="motivo" type="text" class="form-control input-gral" placeholder="Escriba un motivo corto." minlength="3" maxlength="50" required />
                                </div>
                            </div> -->
                            <div class="col-lg-12" >
                                <div class="form-group">
                                <label for="motivo" class="control-label label-gral">Motivo</label>
                                    <select class="selectpicker select-gral"
                                            id="motivo"
                                            name="motivo"
                                            data-style="btn"
                                            required>
                                            <option disabled default >SELECCIONA UNA OPCIÓN</option>
                                            <?php foreach($controversias as $controversia){ ?>

                                                <option value="<?= $controversia['id_opcion']; ?>"><?= $controversia['nombre'] ?> </option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group label-floating">
                                    <textarea class="form-control"
                                              name="descripcion"
                                              rows="3"
                                              placeholder="Escriba la descripción de la controversia..."
                                              required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <div class="modal fade modal-alertas"
             id="penalizacion4-modal"
             role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <form method="post"
                          class="row"
                          id="penalizacion4-form"
                          autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" name="id_lote" id="id-lote-penalizacion4">
                            <input type="hidden" name="id_cliente" id="id-cliente-penalizacion4">
  

                            <div class="col-lg-4">
                                <div class="form-group is-empty">
                                    <label for="asesor" class="control-label label-gral">Asesor</label>
                                    <input id="asesor"
                                           name="asesor"
                                           type="number" step="any" 
                                           class="form-control input-gral"
                                           placeholder="% Asesor"
                                            required />
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group is-empty">
                                    <label for="coordinador" class="control-label label-gral">Coordinador</label>
                                    <input id="coordinador"
                                           name="coordinador"
                                           type="number" step="any" 
                                           class="form-control input-gral"
                                           placeholder="% Coordinador"
                                            required />
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group is-empty">
                                    <label for="gerente" class="control-label label-gral">Gerente</label>
                                    <input id="gerente"
                                           name="gerente"
                                           type="number" step="any" 
                                           class="form-control input-gral"
                                           placeholder="% Gerente"
                                            required />
                                </div>
                            </div>
 
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                      
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade modal-alertas"
             id="penalizacion-modal"
             role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <form method="post"
                          class="row neeed-validation"
                          id="penalizacion-form"
                          autocomplete="off" novalidate>
                        <div class="modal-body">
                        <input type="hidden" name="id_lote" id="id_lote_penalizacion">
                        <input type="hidden" name="id_cliente" id="id_cliente_penalizacion">
                        <div class="col-lg-12">
                                <div class="form-group is-empty">
                                    <P>Comentarios:</P>
                                    <textarea class="form-control" rows="2" name="comentario_aceptado" id="comentario_aceptado" placeholder="Agregue sus comentarios..." requiere></textarea></p>
                                </div>
                            </div>   
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="modal fade modal-alertas"
             id="Nopenalizacion-modal"
             role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <form method="post"
                          class="row"
                          id="Nopenalizacion-form"
                          autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" name="id_lote" id="id_lote_cancelar">
                            <input type="hidden" name="id_cliente" id="id_cliente_cancelar">
                                <div class="col-lg-12">
                                    <div class="form-group is-empty">
                                        <P>Comentarios:</P>
                                        <textarea class="form-control" rows="2" name="comentario_rechazado" id="comentario_rechazado" placeholder="Agregue sus comentarios..."></textarea>
                                    </div>
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                Aceptar
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-simple"
                                    data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- END Modals -->
        <div class="modal fade modal-alertas" id="modal_pagadas" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_pagadas">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modal verifyNEODATA -->
        <div class="modal fade modal-alertas" id="modal_NEODATA" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="form_NEODATA">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal verifyNEODATA -->
        <!-- <div class="modal fade modal-alertas" id="modal_NEODATA2" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red" >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_NEODATA2">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div> -->

        <div class="modal fade" id="detalle-plan-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title" id="title-plan"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" id="planes-div">
                                <div class="form-group">
                                    <select class="selectpicker select-gral"
                                            id="planes"
                                            name="planes"
                                            data-style="btn"
                                            required>
                                    </select>
                                </div>
                            </div>
                            <div id="detalle-tabla-div"
                                 class="col-lg-12">
                                <table class="table table-bordered"
                                       id="plan-detalle-tabla">
                                    <thead>
                                        <tr>
                                            <th scope="col">PUESTO</th>
                                            <th scope="col">COMISIÓN</th>
                                            <th scope="col">NEODATA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="plan-detalle-tabla-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Dispersión de pago</h3>
                                    <p class="card-title pl-1">Lotes nuevos sin dispersar, con saldo disponible en neodata y recesiones con la nueva venta.</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row aligned-row">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Monto hoy: </h4>
                                                    <p class="category input-tot pl-1" id="monto_label">
                                                        <?php $query = $this->db->query("SELECT SUM(monto) nuevo_general FROM (SELECT SUM(pci.abono_neodata) monto FROM pago_comision_ind pci INNER JOIN comisiones c on c.id_comision = pci.id_comision INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) GROUP BY u.id_usuario) as nuevo_general ;");

                                                        foreach ($query->result() as $row){
                                                            $number = ($row->nuevo_general) ? $row->nuevo_general : 0;
                                                            echo '<B>$'.number_format($number, 3),'</B>';
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Pagos hoy: </h4>
                                                    <p class="category input-tot pl-1" id="pagos_label">
                                                     
                                                        <?php $query = $this->db->query("SELECT SUM(pagos) nuevo_general FROM (SELECT  count(id_pago_i) pagos FROM pago_comision_ind pci INNER JOIN comisiones c on c.id_comision = pci.id_comision INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) GROUP BY u.id_usuario) as nuevo_general ;");
                                                        foreach ($query->result() as $row){
                                                            $number = $row->nuevo_general;
                                                            echo '<B>'.$number,'</B>';
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Lotes hoy: </h4>
                                                    <p class="category input-tot pl-1" id="lotes_label">
                                                    
                                                    <?php $query = $this->db->query("SELECT SUM(lotes) nuevo_general FROM (SELECT  COUNT(DISTINCT(id_lote)) lotes FROM pago_comision_ind pci INNER JOIN comisiones c on c.id_comision = pci.id_comision INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) GROUP BY u.id_usuario) as nuevo_general ;");

                                                        foreach ($query->result() as $row) {
                                                            $number = $row->nuevo_general;
                                                            echo '<B>'.$number,'</B>';
                                                        } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-end text-center">
                                                <a data-target="#myModal" data-toggle="modal" class="btn-gral-data" id="MainNavHelp" href="#myModal" style="color:white"> Reporte dispersión</a>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-end text-center">
                                                <button class="btn-gral-data"
                                                   id="btn-detalle-plan"
                                                   style="color:white; ">
                                                    Planes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_dispersar_comisiones" name="tabla_dispersar_comisiones">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>TIPO VENTA</th>
                                                        <th>MODALIDAD</th>
                                                        <th>CONTRATACIÓN</th>
                                                        <th>PLAN VENTA</th>
                                                        <th>FEC. SISTEMA</th> 
                                                        <th>FEC. NEODATA</th>
                                                        <th>MÁS</th>
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
    <script > 
    var url = "<?=base_url()?>";
    var url2 = "<?=base_url()?>index.php/";

    </script>
    <script src="<?=base_url()?>dist/js/controllers/comisiones/dispersar_pago_neodata.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

</body>