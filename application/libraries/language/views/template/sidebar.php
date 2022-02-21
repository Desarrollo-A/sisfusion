<div class="sidebar" data-active-color="blue" data-background-color="white" data-image="<?=base_url()?>/dist/img/sidebar-1.jpg">
    <div class="logo">
        <a href="<?=base_url()?>#" class="simple-text">
            <img src="<?=base_url()?>static/images/CMOF.png" width="50%">
        </a>
    </div>
    <div class="logo logo-mini">
        <a href="<?=base_url()?>#" class="simple-text" style="color: #0e4377;font-weight: 800">
            <img src="<?=base_url()?>dist/img/favicon.ico">
            CM
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user hide">
            <div class="photo">
                <img src="../dist/img/faces/avatar.jpg" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    Tania Andrew
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="#">My Profile</a>
                        </li>
                        <li>
                            <a href="#">Edit Profile</a>
                        </li>
                        <li>
                            <a href="#">Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <br><br>
        <ul class="nav">
            <!--contenido sidebar-->
            <li class="nav-item hidden-xs  <?php if ($home == 1) { echo 'active'; } ?>">
                <a class="nav-link" href="<?= base_url() ?>">
                    <i class="material-icons">home</i>
                    <p>Inicio</p>
                </a>
            </li>


            <?php
            $id_rol = $this->session->userdata('id_rol');
            if($id_rol=="16")//contratacion
            {?><!--Contratación ROL-16 -->
            <li class="nav-item <?php if ($listaCliente == 1 || $contrato==1 || $documentacion ==1 || $corrida==1) {echo 'active';} ?>">
                <a data-toggle="collapse" href="#clientesList">
                    <i class="material-icons">supervised_user_circle</i>
                    <p>Clientes
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="clientesList">
                    <ul class="nav">
                        <?php
                        if($this->session->userdata('jerarquia_user')==2)
                        {
                            ?>
                            <li class="nav-item <?php if ($corrida == 1) { echo 'active'; } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/corrida/cf">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Corrida financiera
                                </a>
                            </li>
                            <li class="nav-item <?php if ($listaCliente == 1) { echo 'active'; } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/registroCliente/registrosClienteContratacion">
                                    Lista de clientes
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroCliente/registrosClienteDocumentoContratacion">
                                    Documentación
                                </a>
                            </li>
                            <li class="nav-item <?php if ($contrato == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroCliente/registroContratoVentasAsistentes">
                                    Contrato
                                </a>
                            </li>
                            <?php
                        }
                        if($this->session->userdata('jerarquia_user')==3)
                        {
                            ?>
                            <li class="nav-item <?php if ($corrida == 1) { echo 'active'; } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/corrida/cf">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Corrida financiera
                                </a>
                            </li>
                            <li class="nav-item <?php if ($listaCliente == 1) { echo 'active'; } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/registroCliente/registrosClienteContratacion">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Lista de clientes
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroCliente/registrosClienteDocumentoContratacion">
                                    <!--<i class="material-icons">folder</i>-->
                                    Documentación
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li class="nav-item <?php if ($inventario == 1 || $inventarioDisponible==1 || $status8 ==1 || $status14==1) {echo 'active';} ?>">
                <a data-toggle="collapse" href="#lotesList">
                    <i class="material-icons">pages</i>
                    <p>Lotes
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="lotesList">
                    <ul class="nav">
                        <?php
                        if($this->session->userdata('jerarquia_user')==2)
                        {
                            ?>
                            <li class="nav-item <?php if ($inventario == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registrosLoteContratacion">
                                    <i class="material-icons">assignment</i>
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item <?php if ($inventarioDisponible == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registrosInvDis">
                                    <i class="material-icons">assignment</i>
                                    Inventario Disponible
                                </a>
                            </li>
                            <li class="nav-item <?php if ($status8== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus8ContratacionAsistentes">
                                    <i class="material-icons">filter_8</i>
                                    Estatus 8
                                </a>
                            </li>
                            <li class="nav-item <?php if ($status14== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus14ContratacionAsistentes">
                                    <i class="material-icons">filter_none</i>
                                    Estatus 14
                                </a>
                            </li>
                            <?php
                        }
                        if($this->session->userdata('jerarquia_user')==3)
                        {
                            ?>
                            <li class="nav-item <?php if ($inventario == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registrosLoteContratacion">
                                    <!--											<i class="material-icons">assignment</i>-->
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item <?php if ($status14== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus14ContratacionAsistentes">
                                    <!--											<i class="material-icons">filter_none</i>-->
                                    Estatus 14
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <li class="nav-item <?php if ($lotesContratados== 1 || $ultimoStatus==1 || $lotes45dias==1 || $consulta9Status==1 || $consulta12Status==1 || $expedientesIngresados==1 || $corridasElaboradas==1) {echo 'active';} ?>">
                <a data-toggle="collapse" href="#reportList">
                    <i class="material-icons">book</i>
                    <p>Reportes
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="reportList">
                    <ul class="nav">
                        <?php
                        if($this->session->userdata('jerarquia_user')==2)
                        {
                            ?>
                            <li class="nav-item <?php if ($ultimoStatus== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/finalStatus">
                                    Ver último status
                                </a>
                            </li>
                            <li class="nav-item <?php if ($lotes45dias== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesPost45">
                                    Lotes con más de 45 días
                                </a>
                            </li>
                            <li class="nav-item <?php if ($lotesContratados== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesContratados">
                                    Lotes contratados
                                </a>
                            </li>
                            <li class="nav-item <?php if ($consulta9Status== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/getHistorialProceso">
                                    Consulta status 9
                                </a>
                            </li>
                            <li class="nav-item <?php if($expedientesIngresados==1){echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/contratacion/expedientesIngresados">
                                    Expedientes ingresados
                                </a>
                            </li>
                            <li class="nav-item <?php if($corridasElaboradas==1){echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/contratacion/corridasElaboradas">
                                    Corridas elaboradas
                                </a>
                            </li>
                            <?php
                        }
                        if($this->session->userdata('jerarquia_user')==3)
                        {
                            ?>
                            <li class="nav-item <?php if ($ultimoStatus== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/finalStatus">
                                    Ver último status
                                </a>
                            </li>
                            <li class="nav-item <?php if ($lotes45dias== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesPost45">
                                    Lotes con más de 45 días
                                </a>
                            </li>
                            <li class="nav-item <?php if ($lotesContratados== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesContratados">
                                    Lotes contratados
                                </a>
                            </li>
                            <li class="nav-item <?php if ($consulta12Status== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/finalStatus12">
                                    Consulta status 12
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </li>
            <?php
            if($this->session->userdata('jerarquia_user')==2)
            {
                ?>
                <li class="nav-item hide <?php if ($gerentesAsistentes== 1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#catAseList">
                        <i class="material-icons">vertical_split</i>
                        <p>Catálogo asesores
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="catAseList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($gerentesAsistentes== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/create_asesor">
                                    <i class="material-icons">people</i>
                                    Gerentes / Asesores
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
            }
            ?>
            <!-- termina contratación sidebar -->
            <?php }

            if($id_rol==6)//asistente gerente
            { ?>
                <!--ventas ROL-16 -->
                <li class="nav-item <?php if ($prospectos == 1 || $prospectosAlta==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#componentsExamples">
                        <i class="material-icons">perm_contact_calendar</i>
                        <p>Prospectos
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="componentsExamples">
                        <ul class="nav">
                            <li class="<?php if ($prospectosAlta == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/clientes/newProspect">Alta</a>
                            </li>
                            <li class="<?php if ($prospectos == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/clientes/consultProspects">Consulta</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($corridaF==1||$documentacion==1||$listaCliente==1||$autorizacion==1||$contrato==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($corridaF == 1) { echo 'active'; } ?>">
                                <a class="nav-link"  href="<?= base_url() ?>index.php/corrida/cf">
                                    <!-- <i class="material-icons">play_arrow</i> -->
                                    Corrida financiera
                                </a>
                            </li>
                            <li class="nav-item <?php if ($listaCliente == 1) { echo 'active'; } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Asistente_gerente/registrosClienteVentasAsistentes">
                                    <!-- <i class="material-icons">chevron_right</i> -->
                                    Lista de clientes
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registrosClienteDocumentosventasAsistentes">
                                    <!-- <i class="material-icons">arrow_right</i> -->
                                    Documentación
                                </a>
                            </li>
                            <li class="nav-item <?php if ($autorizacion == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registrosClienteAutorizacionAsistentes">
                                    <!-- <i class="material-icons">assignment_turned_in</i> -->
                                    Autorización
                                </a>
                            </li>
                            <li class="nav-item <?php if ($contrato == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroContratoVentasAsistentes">
                                    <!-- <i class="material-icons">work</i> -->
                                    Contrato
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($inventario==1||$estatus8==1||$estatus14==1||$estatus7==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($inventario == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/inventario">
                                    <!-- <i class="material-icons">assignment</i> -->
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus8 == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus8VentasAsistentes">
                                    <!-- <i class="material-icons">filter_8</i> -->
                                    Estatus 8
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus14 == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus14VentasAsistentes">
                                    <!-- <i class="material-icons">filter_1</i> -->
                                    Estatus 14
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus7 == 1) { echo 'active'; } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus7VentasAsistentes">
                                    <!-- <i class="material-icons">filter_7</i> -->
                                    Estatus 7 (rechazos)
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($estatus9==1||$disponibles==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#reportesList">
                        <i class="material-icons">assignment</i>
                        <p>Reportes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="reportesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($estatus9 == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus9VentasAsistentes">
                                    <!-- <i class="material-icons">filter_9</i> -->
                                    Estatus 9
                                </a>
                            </li>

                            <li class="nav-item <?php if ($disponibles == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/inventarioDisponible">
                                    <!-- <i class="material-icons">assignment</i> -->
                                    Inventario disponibles
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($asesores == 1) { echo 'active'; } ?>">
                    <a class="nav-link" href="<?= base_url() ?>index.php/Asistente_gerente/catalogoAsesores">
                        <i class="material-icons">group</i>
                        <p>Catálogo de asesores </p>
                    </a>
                </li>

                <li class="nav-item <?php if ($nuevasComisiones==1||$histComisiones==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#comisionList">
                        <i class="material-icons">account_balance_wallet</i>
                        <p>Comisiones
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="comisionList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($nuevasComisiones == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/comisiones/comisiones_view">
                                    Solicitudes
                                </a>
                            </li>

                            <li class="nav-item <?php if ($histComisiones == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/comisiones/hitorial_Comisiones">
                                    Historial solicitudes
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <!--termina ventas -->
            <?php }
            if($id_rol == 11)
            {?>
                <!-- Administración rol 11 -->
                <li class="nav-item <?php if ($listaCliente == 1 || $documentacion ==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($listaCliente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Administracion/lista_cliente_administracion">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Lista de clientes
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Administracion/documentacion_administracion">
                                    <!--<i class="material-icons">folder</i>-->
                                    Documentación
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($inventario == 1 || $status11==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($inventario == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Administracion/inventario">
                                    <!--										<i class="material-icons">assignment</i>-->
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item <?php if ($status11== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus11ContratacionAdministracion">
                                    <!--										<i class="material-icons">filter_none</i>-->
                                    Estatus 11
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--termina administración-->
            <?php }
            if($id_rol == 7){?>
                <!-- asesor rol 7  -->
                <li class="nav-item <?php if ($prospectos == 1 || $prospectosAlta == 1 || $sharedSales == 1 || $coOwners == 1 || $references == 1 || $clientsList == 1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#componentsExamples">
                        <i class="material-icons">perm_contact_calendar</i>
                        <p>Prospectos
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="componentsExamples">
                        <ul class="nav">
                            <li class="<?php if ($prospectosAlta == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/clientes/newProspect">Alta</a>
                            </li>
                            <li class="<?php if ($prospectos == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/clientes/consultProspects">Consulta</a>
                            </li>
                            <li class="<?php if ($clientsList == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/clientes/consultClients">Nuevos clientes</a>
                            </li>
<!--                            <li class="--><?php //if ($sharedSales == 1) {echo 'active';} ?><!--">-->
<!--                                <a href="--><?//= base_url() ?><!--index.php/clientes/sharedSales">Ventas compartidas</a>-->
<!--                            </li>-->
<!--                            <li class="--><?php //if ($coOwners == 1) {echo 'active';} ?><!--">-->
<!--                                <a href="--><?//= base_url() ?><!--index.php/clientes/coOwners">Copropietarios</a>-->
<!--                            </li>-->
<!--                            <li class="--><?php //if ($references == 1) {echo 'active';} ?><!--">-->
<!--                                <a href="--><?//= base_url() ?><!--index.php/clientes/references">Referencias</a>-->
<!--                            </li>-->
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($DS == 1 || $DSConsult==1 || $documentacion == 1 || $listaCliente ==1 || $autoriza ==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientsList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientsList">
                        <ul class="nav">
                            <li class="<?php if ($DS == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/asesor/depositoSeriedad">
                                    <!--<span class="sidebar-mini"> DS </span>-->
                                    Depósito de seriedad
                                </a>
                            </li>
                            <li class="<?php if ($DSConsult == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/asesor/depositoSeriedadConsulta">
                                    <!--<span class="sidebar-mini"> DSC </span>-->
                                    Depósito de seriedad (consulta)
                                </a>
                            </li>
                            <li class="<?php if ($documentacion == 1) {echo 'active';} ?>">
                                <a href="<?= base_url() ?>index.php/asesor/documentacion">
                                    <!--<span class="sidebar-mini"> D </span>-->
                                    Documentación
                                </a>
                            </li>
							<li class="<?php if($autoriza == 1) {echo 'active';}?>">
								<a class="nav-link" href="<?=base_url()?>index.php/asesor/autorizaciones">
									Autorizaciones
								</a>
							</li>
                            <li class="<?php if ($listaCliente == 1) {echo 'active'; } ?> hide">
                                <a class="nav-link " href="<?= base_url() ?>index.php/registroCliente/registrosClienteDS">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    <!--<span class="sidebar-mini"> LC </span>-->
                                    Lista de clientes
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($corridaF==1 || $inventario == 1 || $inventarioDisponible == 1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="<?php if ($corridaF == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?= base_url() ?>index.php/corrida/cf">
                                    <!--<i class="material-icons">monetization_on</i>-->
                                    <p>Corrida financiera</p>
                                </a>
                            </li>
                            <li class="<?php if ($inventario == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?= base_url() ?>index.php/asesor/registrosLoteVentasAsesor">
                                    <!--<i class="material-icons">assignment</i>-->
                                    <p>Inventario</p>
                                </a>
                            </li>
                            <li class="<?php if ($inventarioDisponible == 1) {echo 'active';} ?>">
                                <!--<?= base_url() ?>index.php/asesor/invDispAsesor-->
                                <a class="nav-link" href="<?= base_url() ?>index.php/asesor/invDispAsesor">
                                    <!--<i class="material-icons">assignment</i>-->
                                    <p>Inventario disponible</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($nuevasComisiones==1||$histComisiones==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#comisionList">
                        <i class="material-icons">account_balance_wallet</i>
                        <p>Comisiones
                            <b class="caret"></b>
                        </p>
                    </a>


                    <div class="collapse" id="comisionList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($nuevasComisiones == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/comisiones/comisiones_view">
                                    Solicitudes
                                </a>
                            </li>

                            <li class="nav-item <?php if ($histComisiones == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/comisiones/hitorial_Comisiones">
                                    Historial solicitudes
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($manual==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#helpList">
                        <i class="material-icons">help</i>
                        <p>Ayuda
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="helpList">
                        <ul class="nav">

                            <li class="<?php if ($manual==1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?= base_url() ?>index.php/asesor/manual">
                                    <!--<i class="material-icons">monetization_on</i>-->
                                    <p>Manual</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- termina sidebar asesor 7-->
            <?php }
            if($id_rol == 12 ){?>
                <!-- rol caja 12 -->
                <li class="nav-item <?php if ($listaCliente==1||$documentacion==1||$cambiarAsesor==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($listaCliente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/caja/lista_clientes">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Lista clientes
                                </a>
                            </li>

                            <li class="nav-item <?php if ($documentacion == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/caja/documentacion">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Documentación
                                </a>
                            </li>

                            <li class="nav-item <?php if ($cambiarAsesor == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Caja/cambiar_asesor">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Cambiar asesor
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($historialPagos==1||$pagosCancelados==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#pagosList">
                        <i class="material-icons">attach_money</i>
                        <p>Pagos
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="pagosList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($historialPagos == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/historial_pagos">
                                    Historial
                                </a>
                            </li>
                            <li class="nav-item <?php if ($pagosCancelados == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/pagos_cancelados">
                                    Cancelados
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($altaCluster==1||$altaLote==1||$inventario==1||$actualizaPrecio==1||$actualizaReferencia==1||$liberacion==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($altaCluster == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/alta_cluster">
                                    Alta condominio
                                </a>
                            </li>
                            <li class="nav-item <?php if ($altaLote == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/alta_lote">
                                    Alta lotes
                                </a>
                            </li>
                            <li class="nav-item <?php if ($inventario == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/caja/inventario">
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item <?php if ($actualizaPrecio == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/actualiza_precio">
                                    Actualizar precios
                                </a>
                            </li>
                            <li class="nav-item <?php if ($actualizaReferencia == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/actualiza_referencia">
                                    Actualizar referencias
                                </a>
                            </li>
                            <li class="nav-item <?php if ($liberacion == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Caja/liberacion">
                                    Liberación
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- termina rol 12  caja-->
            <?php }
            if($id_rol == 13){?>
                <!-- contraloria Rol 13-->
                <li class="nav-item <?php if ($listaCliente==1||$expediente==1||$corrida==1||$documentacion==1||$historialpagos==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($listaCliente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/Contraloria/listaClientes">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Lista clientes
                                </a>
                            </li>

                            <li class="nav-item <?php if ($expediente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/Contraloria/expediente_contraloria">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Ingresar expediente
                                </a>
                            </li>

                            <li class="nav-item <?php if ($corrida == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Contraloria/corrida_contraloria">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Ingresar corrida
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/documentacion_contraloria">
                                    <!--<i class="material-icons">folder</i>-->
                                    Documentación
                                </a>
                            </li>
                            <li class="nav-item <?php if ($historialpagos == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/historial_pagos_contraloria">
                                    <!--<i class="material-icons">folder</i>-->
                                    Historial de pagos
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($inventario==1||$estatus20==1||$estatus2==1||$estatus5==1||$estatus6==1||$estatus9==1||$estatus10==1||$estatus13==1||$estatus15==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($inventario == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/inventario">
                                    <!--index.php/registroLote/registrosLoteJuridico-->
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item hide <?php if ($estatus20 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Contraloria/estatus_2_0_contraloria">
                                    Estatus 2.0
                                </a>
                            </li>
                            <li class="nav-item hide <?php if ($estatus2 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_2_contraloria">
                                    Estatus 2
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus5 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_5_contraloria">
                                    Estatus 5
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus6 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_6_contraloria">
                                    Estatus 6
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus9 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_9_contraloria">
                                    Estatus 9
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus10 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_10_contraloria">
                                    Estatus 10
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus13 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_13_contraloria">
                                    Estatus 13
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus15 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_15_contraloria">
                                    Estatus 15
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($enviosRL==1||$estatus12==1||$acuserecibidos==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#contratosList">
                        <i class="material-icons">insert_drive_file</i>
                        <p>Solicitud de contratos
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="contratosList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($enviosRL == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/envio_RL_contraloria">
                                    Envío contrato a RL
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus12 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_12_contraloria">
                                    Estatus 12
                                </a>
                            </li>
                            <li class="nav-item <?php if ($acuserecibidos == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link hide" href="<?=base_url()?>index.php/Contraloria/acuse_recibidos_contraloria">
                                    Acuse de contratos
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($integracionExpediente==1||$expRevisados==1|| $estatus10Report==1 || $rechazoJuridico) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#reportesList">
                        <i class="material-icons">bookmark</i>
                        <p>Reportes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="reportesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($integracionExpediente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/integracionExpediente">
                                    Interacion de Expediente
                                </a>
                            </li>
                            <li class="nav-item <?php if ($expRevisados == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/expRevisados">
                                    Expedientes revisados 100%
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus10Report == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus10">
                                    Estatus 10
                                </a>
                            </li>
                            <li class="nav-item <?php if ($rechazoJuridico == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/rechazoJuridico">
                                    Rechazos Jurídico
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($comnuevas==1||$comhistorial==1||$tablaPorcentajes==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#comisionesList">
                        <i class="material-icons">pie_chart</i>
                        <p>Comisiones
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="comisionesList">
                        <ul class="nav">

                            <li class="nav-item <?php if ($tablaPorcentajes == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Comisiones/tabla_porcentajes">
                                    Porcentajes Comisiones
                                </a>
                            </li>
                            <li class="nav-item <?php if ($comnuevas == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Comisiones/nuevas_contraloria">
                                    Nuevas
                                </a>
                            </li>
                            <li class="nav-item <?php if ($comhistorial == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Comisiones/hitorial_Comisiones">
                                    Historial
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <!-- termina contraloria Rol 13-->
            <?php }
            if($id_rol == 32){?>
                <!-- contraloria Rol 13-->
                <li class="nav-item <?php if ($listaCliente==1||$expediente==1||$corrida==1||$documentacion==1||$historialpagos==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($listaCliente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/Contraloria/listaClientes">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Lista clientes
                                </a>
                            </li>

                            <li class="nav-item <?php if ($expediente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/Contraloria/expediente_contraloria">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Ingresar expediente
                                </a>
                            </li>

                            <li class="nav-item <?php if ($corrida == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Contraloria/corrida_contraloria">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Ingresar corrida
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/documentacion_contraloria">
                                    <!--<i class="material-icons">folder</i>-->
                                    Documentación
                                </a>
                            </li>
                            <li class="nav-item <?php if ($historialpagos == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/historial_pagos_contraloria">
                                    <!--<i class="material-icons">folder</i>-->
                                    Historial de pagos
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($inventario==1||$estatus20==1||$estatus2==1||$estatus5==1||$estatus6==1||$estatus9==1||$estatus10==1||$estatus13==1||$estatus15==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($inventario == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/inventario">
                                    <!--index.php/registroLote/registrosLoteJuridico-->
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item hide <?php if ($estatus20 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/Contraloria/estatus_2_0_contraloria">
                                    Estatus 2.0
                                </a>
                            </li>
                            <li class="nav-item hide <?php if ($estatus2 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_2_contraloria">
                                    Estatus 2
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus5 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_5_contraloria">
                                    Estatus 5
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus6 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_6_contraloria">
                                    Estatus 6
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus9 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_9_contraloria">
                                    Estatus 9
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus10 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_10_contraloria">
                                    Estatus 10
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus13 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_13_contraloria">
                                    Estatus 13
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus15 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_15_contraloria">
                                    Estatus 15
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($enviosRL==1||$estatus12==1||$acuserecibidos==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#contratosList">
                        <i class="material-icons">insert_drive_file</i>
                        <p>Solicitud de contratos
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="contratosList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($enviosRL == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/envio_RL_contraloria">
                                    Envío contrato a RL
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus12 == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_12_contraloria">
                                    Estatus 12
                                </a>
                            </li>
                            <li class="nav-item <?php if ($acuserecibidos == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link hide" href="<?=base_url()?>index.php/Contraloria/acuse_recibidos_contraloria">
                                    Acuse de contratos
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($integracionExpediente==1||$expRevisados==1|| $estatus10Report==1 || $rechazoJuridico) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#reportesList">
                        <i class="material-icons">bookmark</i>
                        <p>Reportes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="reportesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($integracionExpediente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/integracionExpediente">
                                    Interacion de Expediente
                                </a>
                            </li>
                            <li class="nav-item <?php if ($expRevisados == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/expRevisados">
                                    Expedientes revisados 100%
                                </a>
                            </li>
                            <li class="nav-item <?php if ($estatus10Report == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus10">
                                    Estatus 10
                                </a>
                            </li>
                            <li class="nav-item <?php if ($rechazoJuridico == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Contraloria/rechazoJuridico">
                                    Rechazos Jurídico
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($comnuevas==1||$comhistorial==1||$tablaPorcentajes==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#comisionesList">
                        <i class="material-icons">pie_chart</i>
                        <p>Comisiones
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="comisionesList">
                        <ul class="nav">

                            <li class="nav-item <?php if ($tablaPorcentajes == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Comisiones/nuevas_contraloria">
                                    Nuevas
                                </a>
                            </li>
                            <li class="nav-item <?php if ($comnuevas == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Comisiones/confirmar_pago">
                                    Confirmar pago
                                </a>
                            </li>
                            <li class="nav-item <?php if ($comhistorial == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/Comisiones/hitorial_Comisiones">
                                    Historial
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


            <?php }
            if( in_array($id_rol, array(4, 5, 8)) ){?>
                <!-- contraloria Rol 13-->
                <li class="nav-item <?php if ($altaUsuarios==1 || $listaUsuarios==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        Usuarios
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <?php
                            if($id_rol == 8) {
                                ?>
                                <li class="nav-item <?php if ($altaUsuarios == 1) {
                                    echo 'active';
                                } ?>">
                                    <a class="nav-link " href="<?= base_url() ?>index.php/Usuarios/addUser">
                                        Alta
                                    </a>
                                </li>
                                <?php
                            }?>
                            <li class="nav-item <?php if ($listaUsuarios == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link "  href="<?= base_url() ?>index.php/Usuarios/usersList">
                                    Consulta
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>



            <?php }
            if($id_rol == 15){?>
                <!-- juridico Rol-15 -->
                <li class="nav-item <?php if ($listaCliente == 1 || $contrato==1 || $documentacion ==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#clientesList">
                        <i class="material-icons">supervised_user_circle</i>
                        <p>Clientes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="clientesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($listaCliente == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link " href="<?=base_url()?>index.php/registroCliente/registrosClienteJuridico">
                                    <!--<i class="material-icons">view_headline</i>-->
                                    Lista de clientes
                                </a>
                            </li>
                            <li class="nav-item <?php if ($documentacion == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroCliente/registrosClienteDocumentosJuridico">
                                    <!--<i class="material-icons">folder</i>-->
                                    Documentación
                                </a>
                            </li>
                            <li class="nav-item <?php if ($contrato == 1) {
                                echo 'active';
                            } ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroCliente/registroContratoJuridico">
                                    <!--<i class="material-icons">attach_money</i>-->
                                    Contrato
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($inventario == 1 || $status3==1 || $status7 ==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#lotesList">
                        <i class="material-icons">pages</i>
                        <p>Lotes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="lotesList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($inventario == 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registrosLoteJuridico">
                                    <!--									<i class="material-icons">assignment</i>-->
                                    Inventario
                                </a>
                            </li>
                            <li class="nav-item <?php if ($status3== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus3ContratacionJuridico">
                                    <!--									<i class="material-icons">filter_3</i>-->
                                    Estatus 3
                                </a>
                            </li>
                            <li class="nav-item <?php if ($status7== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus7ContratacionJuridico">
                                    <!--									<i class="material-icons">filter_7</i>-->
                                    Estatus 7
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($lotesContratados== 1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#reportList">
                        <i class="material-icons">book</i>
                        <p>Reportes
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="reportList">
                        <ul class="nav">
                            <li class="nav-item <?php if ($lotesContratados== 1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?=base_url()?>index.php/registroLote/getReportContratados">
                                    <!--									<i class="material-icons">done_outline</i>-->
                                    Lotes contratados
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- termina juridico-->
            <?php }
            if( in_array($id_rol, array(1, 2, 3, 4, 5, 9, 10, 18, 19, 20, 21, 22, 23, 31, 28)) ){?>
                <?php
                switch ($this->session->userdata('id_rol')) {
                    case "19": // SUBDIRECTOR MKTD
                    case "20": // GERENTE MKTD
                        /*echo "<li class=\"nav-item <?php if ($usuarios == 1) {echo 'active';} ?>\"><a class=\"nav-link\" href=\"#\"><i class=\"material-icons\">face</i><p>Usuarios</p></a></li>";*/
                    echo "<li class='nav-item "; if ($listaAsesores == 1) {echo 'active';} echo"'><a class='nav-link' href='" . base_url() . "index.php/usuarios/advisersList'><i class='material-icons'>tag_faces</i><p>Asesores / Coordinadores</p></a></li>";
                        break;
                    case "31": // INTERNOMEX

 						echo "<li class='nav-item "; if ($comisiones_internomex == 1) {echo 'active';} echo"'><a class='nav-link' href='" . base_url() . "index.php/internomex/comisiones'><i class='material-icons'>face</i><p>Verificar Comisiones</p></a></li>";

 						echo "<li class='nav-item "; if ($historial_internomex == 1) {echo 'active';} echo"'><a class='nav-link' href='". base_url() . "index.php/internomex/historial'><i class='material-icons'>face</i><p>Pagos comisiones</p></a></li>";


                        // echo "<li class=\"nav-item \"><a class=\"nav-link\" href=\"#\"><i class=\"material-icons\">face</i><p>Verificar Comisiones</p></a></li>";
                        break;


 						case "1": // DIRECTOR MKTD
 						case "2": // DIRECTOR MKTD
 						case "3": // DIRECTOR MKTD
 						case "9": // DIRECTOR MKTD
 						case "18": // DIRECTOR MKTD


 						case "22": // DIRECTOR MKTD
 						case "23": // DIRECTOR MKTD


						echo  "<li class='nav-item ";  if ($nuevasComisiones==1 || $histComisiones==1) {echo 'active';} echo"'>
						<a data-toggle='collapse' href='#comisionList'>
						<i class='material-icons'>account_balance_wallet</i>
						<p>Comisiones
						<b class='caret'></b>
						</p>
						</a>
						<div class='collapse' id='comisionList'>
						<ul class='nav'>
						 

							<li class='nav-item ";if ($nuevasComisiones == 1){echo 'active'; }  echo "'>
							
							<a href='".base_url()."index.php/comisiones/comisiones_mktd_club'>
							Solicitudes
							</a>
							</li>

							<li class='nav-item "; if ($histComisiones == 1) { echo 'active'; } echo"'>
								<a href='". base_url() ."index.php/comisiones/hitorial_Comisiones'>
 								Historial solicitudes
								</a>
								</li>
								</ul>
								</div>
								</li>";


 						break;
					case '28':
						echo '
						<li class="nav-item '; if($documentacionMKT==1){echo 'active';} echo'">
							<a data-toggle="collapse" href="#clienteMkt">
								<!--<i class="material-icons">analytics</i>-->
								<i class="material-icons">supervised_user_circle</i>
								<p>Clientes
								<b class="caret"></b>
								</p>
							</a>
							<div class="collapse" id="clienteMkt">
								<ul class="nav">
									<li class="nav-item '; if($documentacionMKT==1 ){echo 'active';} echo'">
										<a href="'.base_url().'index.php/MKT/documentos">Documentos</a>
									</li>
								</ul>
							</div>
						</li> 
						<li class="nav-item '; if($inventarioMKT==1){echo 'active';} echo'">
							<a data-toggle="collapse" href="#lotesMkt">
								<!--<i class="material-icons">analytics</i>-->
								<i class="material-icons">pages</i>
								<p>Lotes
								<b class="caret"></b>
								</p>
							</a>
							<div class="collapse" id="lotesMkt">
								<ul class="nav">
									<li class="nav-item '; if($inventarioMKT==1 ){echo 'active';} echo'">
										<a href="'.base_url().'index.php/MKT/inventario">Inventario lotes</a>
									</li>
								</ul>
							</div>
						</li>
						
						<li class="nav-item '; if($mkt_digital==1 || $prospectPlace == 1){echo 'active';} echo'">
							<a data-toggle="collapse" href="#statsMkt">
								<!--<i class="material-icons">analytics</i>-->
								<i class="fa fa-area-chart" aria-hidden="true"></i>
								<p>Estadísticas
								<b class="caret"></b>
								</p>
							</a>
							<div class="collapse" id="statsMkt">
								<ul class="nav">
									<li class="nav-item '; if($mkt_digital==1 ){echo 'active';} echo'">
										<a href="'.base_url().'index.php/MKT/">Marketing Digital</a>
									</li>
									<li class="nav-item '; if($prospectPlace==1 ){echo 'active';} echo'">
										<a href="'.base_url().'index.php/LP/">Lugar Prospección</a>
									</li>
								</ul>
							</div>
						</li>
						
						';

						break;
				}
				?>




                <?php
                if ($this->session->userdata('id_rol') != 10 && $this->session->userdata('id_rol') != 21 && $this->session->userdata('id_rol') != 31  && $this->session->userdata('id_rol') != 28) {
                    echo '<li class="nav-item ';  if ($prospectos == 1 || $prospectosAlta == 1 || $prospectosMktd == 1 || $bulkload == 1 || $clientsList = 1) {echo "active";} echo'">
                            <a data-toggle="collapse" href="#componentsExamples">
                                <i class="material-icons">perm_contact_calendar</i>
                                <p>Prospectos
                                    <b class="caret"></b>
                                </p>
					        </a>
					        <div class="collapse" id="componentsExamples">
						        <ul class="nav">';
                    switch ($id_rol) {
                        case "3": // GERENTE
                        case "9": // COORDINADOR
                        case "7": // ASESOR
                            echo '<li class="'; if ($prospectosAlta == 1) {echo 'active';} echo '"><a href="'. base_url() . 'index.php/clientes/newProspect">Alta</a></li>';
                            echo '<li class="'; if ($prospectos == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultProspects">Consulta</a></li>';
                            echo '<li class="'; if ($clientsList == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultClients">Nuevos clientes</a></li>';
                            break;
                        case "1": // DIRECTOR
                        case "2": // SUBDIRECTOR
                        case "4": // ASISTENTE DIRECTOR
                        case "5": // ASISTENTE SUBDIRECTOR
						echo '<li class="'; if ($prospectos == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultProspects">Consulta</a></li>';
                        echo '<li class="'; if ($clientsList == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultClients">Nuevos clientes</a></li>';
                            break;
                        case "18": // DIRECTOR MKTD
                            echo '<li class="';  if ($prospectosMktd == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultProspectsMktd\">Consulta</a></li>';
                            break;
                        case "19": // SUBDIRECTOR MKTD
                            echo '<li class="'; if ($bulkload == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/bulkload\">Carga masiva</a></li>';
                            echo '<li class="'; if ($prospectosAlta == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/newProspect\">Alta</a></li>';
                            echo '<li class="'; if ($prospectosMktd == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultProspectsMktd\">Marketing digital</a></li>';
                            echo '<li class="'; if ($prospectos == 1) {echo 'active';} echo '"><a href="' . base_url() . 'index.php/clientes/consultProspects\">Ventas</a></li>';
                            break;
                        case "20": // GERENTE MKTD
                            echo '<li class="'; if ($bulkload == 1) {echo 'active';} echo '"><a href=' . base_url() .'index.php/clientes/bulkload\">Carga masiva</a></li>';
                            echo '<li class="'; if ($prospectosAlta == 1) {echo 'active';} echo '"><a href=' . base_url() .'index.php/clientes/newProspect\">Alta</a></li>';
                            echo '<li class="'; if ($prospectosMktd == 1) {echo 'active';} echo '"><a href=' . base_url() .'index.php/clientes/consultProspectsMktd\">Consulta</a></li>';
                            break;
                    }
                    echo "</ul>
					        </div>
				</li>";
                }
                ?>
                <?php
                if ($this->session->userdata('id_rol') == 2) {
                    echo "<li class='nav-item ";if($corridaF==1 || $inventario == 1 || $inventarioDisponible == 1) {echo 'active';} echo"'>
                            <a data-toggle='collapse' href='#componentsExampless'>
                                <i class='material-icons'>pages</i>
                                <p>Lotes
                                    <b class='caret'></b>
                                </p>
					        </a>
					        <div class='collapse' id='componentsExampless'>
						        <ul class='nav'>
                                    <li class='"; if ($corridaF == 1) {echo 'active';} echo"'>
                                        <a class='nav-link' href='".base_url()."index.php/corrida/cf\'>
                                            <!--<i class=\"material-icons\">monetization_on</i>-->
                                            <p>Corrida financiera</p>
                                        </a>
                                    </li>
                                    <li class='"; if ($inventario == 1) {echo 'active';} echo"'>
                                        <a class='nav-link' href='".base_url()."index.php/asesor/inventario\'>
                                            <!--<i class=\"material-icons\">assignment</i>-->
                                            <p>Inventario</p>
                                        </a>
                                    </li>
                                    <li class='"; if ($inventarioDisponible == 1) {echo 'active';} echo"'>
                                        <!--<?= base_url() ?>index.php/asesor/invDispAsesor-->
                                        <a class='nav-link' href='".base_url()."index.php/asesor/invDispAsesor\'>
                                            <!--<i class=\"material-icons\">assignment</i>-->
                                            <p>Inventario disponible</p>
                                        </a>
                                    </li>
                                </ul>
					        </div>
				    </li>
				    <li class='nav-item "; if ($autorizaciones==1) { echo "active";}echo"'>
							<a data-toggle=\"collapse\" href=\"#autorizacionesListMenu\">
                                <i class=\"material-icons\">verified_user</i>
                                <p>Autorizaciones
                                    <b class=\"caret\"></b>
                                </p>
					        </a>
					        <div class=\"collapse\" id=\"autorizacionesListMenu\">
						        <ul class=\"nav\">
                                    <li class='";if ($autorizaciones == 1) {echo 'active';} echo"'>
                                        <a class=\"nav-link\" href='".base_url()."index.php/registroCliente/directivosAut\'>
                                            <!--<i class=\"material-icons\">monetization_on</i>-->
                                            <p>Autorizaciones</p>
                                        </a>
                                    </li>
                                </ul>
					        </div>
					</li>";
                }
                ?>
				<?php
				if ($this->session->userdata('id_rol') == 1) {
					echo "<li class='nav-item "; if ($autorizaciones==1) { echo "active";}echo"'>
							<a data-toggle=\"collapse\" href=\"#autorizacionesListMenu\">
                                <i class=\"material-icons\">verified_user</i>
                                <p>Autorizaciones
                                    <b class=\"caret\"></b>
                                </p>
					        </a>
					        <div class=\"collapse\" id=\"autorizacionesListMenu\">
						        <ul class=\"nav\">
                                    <li class='";if ($autorizaciones == 1) {echo 'active';} echo"'>
                                        <a class=\"nav-link\" href='".base_url()."index.php/registroCliente/directivosAut\'>
                                            <!--<i class=\"material-icons\">monetization_on</i>-->
                                            <p>Autorizaciones</p>
                                        </a>
                                    </li>
                                </ul>
					        </div>
					</li>";
				}
				?>
                <li class="nav-item <?php if ($manual==1) {echo 'active';} ?>">
                    <a data-toggle="collapse" href="#helpList">
                        <i class="material-icons">help</i>
                        <p>Ayuda
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="helpList">
                        <ul class="nav">

                            <li class="<?php if ($manual==1) {echo 'active';} ?>">
                                <a class="nav-link" href="<?= base_url() ?>index.php/asesor/manual">
                                    <!--<i class="material-icons">monetization_on</i>-->
                                    <p>Manual</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if ($aparta == 1) {echo 'active';} ?>">
                    <a class="nav-link" href="https://ciudadmaderas.com/comprar/index.html" target="_blank">
                        <i class="material-icons">add_shopping_cart</i>
                        <p>Aparta en línea</p>
                    </a>
                </li>
                <?php
                switch ($this->session->userdata('id_rol')) {
                    case "21": // CLIENTE
                        echo "<li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"". base_url() ."index.php/clientes/bonuses\">
                                <i class=\"material-icons\">attach_money</i>
                                <p>Bonificaciones</p>
                            </a>
                        </li>
                        <li class='nav-item'>
                        	<a class='nav-link' href='".base_url()."index.php/clientes/verificarBonificaciones'>
	                        	<i class='material-icons'>help</i>
                                <p>Verificar Bonificaciones</p>
							</a>                    	 
						</li>
						<li class='nav-item'>
                        	<a class='nav-link' href='".base_url()."index.php/clientes/concentradoBonificaciones' target='_blank'>
	                        	<i class='material-icons'>help</i>
                                <p>Concentrado bonificaciones</p>
							</a>                    	 
						</li>";
						break;



				}
				?>
			<?php } ?>
			<!--cierre de contenido sidebar-->
		</ul>
	</div>
</div>
<div class="main-panel">
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                    <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons visible-on-sidebar-mini">view_list</i>
                </button>
            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?=base_url()?>#" class="navbar-brand hidden-md hidden-lg" style="color: #0e4377;font-weight: 800">
                    <img src="<?=base_url()?>dist/img/favicon.ico">
                    CM
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <a class="navbar-brand" href="#"> Menú </a>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?=base_url() ?>">
                            <i class="material-icons">home</i>
                            <p class="hidden-lg hidden-md">Home</p>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span><?= $this->session->userdata('nombre')." ".$this->session->userdata('apellido_paterno')." ".$this->session->userdata('apellido_materno') ?></span>
                            <i class="material-icons">person</i>
                            <p class="hidden-lg hidden-md">Profile</p>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?=base_url()?>index.php/Usuarios/configureProfile">Configurar perfil</a>
                            </li>
                            <li>
                                <a href="<?=base_url()?>index.php/login/logout_ci">Cerrar sesión</a>
                            </li>
                        </ul>
                    </li>
                    <li class="separator hidden-lg hidden-md"></li>
                </ul>
            </div>
        </div>
    </nav>

