<div>
    <div class="wrapper">
        <?php
            $dato= array(
                'actualizaPrecio' => 0,
                'actualizaReferencia' => 0,
                'acuserecibidos' => 0,
                'altaCluster' => 0,
                'altaLote' => 0,
                'aparta' => 0,
                'asesores' => 0,
                'autorizacion' => 0,
                'cambiarAsesor' => 0,
                'comhistorial' => 0,
                'comnuevas' => 0,
                'consulta12Status' => 0,
                'consulta9Status' => 0,
                'contrato' => 0,
                'coOwners' => 0,
                'corrida' => 0,
                'corridaF' => 0,
                'corridasElaboradas' => 0,
                'disponibles' => 0,
                'documentacion' => 0,
                'DS' => 0,
                'DSConsult' => 0,
                'enviosRL' => 0,
                'estatus10' => 0,
                'estatus10Report' => 0,
                'estatus12' => 0,
                'estatus13' => 0,
                'estatus14' => 0,
                'estatus15' => 0,
                'estatus2' => 0,
                'estatus20' => 0,
                'estatus5' => 0,
                'estatus6' => 0,
                'estatus7' => 0,
                'estatus8' => 0,
                'estatus9' => 0,
                'expediente' => 0,
                'expedientesIngresados' => 0,
                'expRevisados' => 0,
                'gerentesAsistentes' => 0,
                'histComisiones' => 0,
                'historialPagos' => 0,
                'home' => 0,
                'integracionExpediente' => 0,
                'inventario' => 0,
                'inventarioDisponible' => 0,
                'liberacion' => 0,
                'listaCliente' => 0,
                'lotes45dias' => 0,
                'lotesContratados' => 0,
                'manual' => 0,
                'nuevasComisiones' => 0,
                'pagosCancelados' => 0,
                'prospectos' => 0,
                'prospectosAlta' => 0,
                'prospectosMktd' => 0,
                'rechazoJuridico' => 0,
                'references' => 0,
                'sharedSales' => 0,
                'status11' => 0,
                'status14' => 0,
                'status3' => 0,
                'status7' => 0,
                'status8' => 0,
                'ultimoStatus' => 0,
                'usuarios' => 0,
                'altaUsuarios' => 0,
                'listaUsuarios' => 0,
				'autoriza'=> 0,
				'bulkload' => 0,
				'mkt_digital' => 0,
				'prospectPlace' => 0,
				'documentacionMKT' => 0,
				'inventarioMKT' => 0,
                'clientsList' => 0);
        $this->load->view('template/sidebar', $dato);

        ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="block full">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                            <i class="material-icons">list</i>
                                        </div>
                                        <div class="card-content">
                                            <div class="row">
                                                <h4 class="card-title">Configura tu perfil</h4>
                                                <div class="table-responsive">
                                                    <form name="my_personal_info_form" id="my_personal_info_form" class="col-md-10 col-md-offset-1" >

                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Nombre</label>
                                                                <input id="name" name="name" type="text" class="form-control" value="<?= $nombre ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Apellido paterno</label>
                                                                <input id="last_name" name="last_name" type="text" class="form-control" value="<?= $apellido_paterno ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Apellido materno</label>
                                                                <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control" value="<?= $apellido_materno ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">RFC</label>
                                                                <input id="rfc" name="rfc" type="text" class="form-control" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?= $rfc ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Correo electrónico</label>
                                                                <input id="email" name="email" type="email" class="form-control" value="<?= $correo ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Teléfono celular</label>
                                                                <input id="phone_number" name="phone_number" type="number" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?= $telefono ?>">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Nombre de usuario</label>
                                                                <input id="username" name="username" type="text" class="form-control" disabled value="<?= $usuario ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Contraseña</label>
                                                                <input id="contrasena" name="contrasena" type="password" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  value="<?= $contrasena ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <input type="checkbox" onclick="showPassword()" style="margin-top: 60px">Mostrar contraseña
                                                                <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $id_usuario ?>">
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-8">
                                                                <button type="submit" class="btn btn-primary btn-block" >Actualizar</button>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                    </form>
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
</body>

<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/usuarios-1.1.0.js"></script>

</html>
