<div class="sidebar" data-active-color="blue" data-background-color="white" data-image="../dist/img/sidebar-1.jpg">
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


			<li class="nav-item <?php if ($home == 1) {
				echo 'active';
			} ?>">
				<a class="nav-link" href="<?= base_url() ?>">
					<i class="material-icons">home</i>
					<p>Inicio</p>
				</a>
			</li>
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
						<li class="nav-item <?php if ($corridaF == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link"  href="<?= base_url() ?>index.php/corrida/cf">
								<!-- <i class="material-icons">play_arrow</i> -->
								Corrida financiera
							</a>
						</li>
						<li class="nav-item <?php if ($listaCliente == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link " href="<?=base_url()?>index.php/Asistente_gerente/registrosClienteVentasAsistentes">
								<!-- <i class="material-icons">chevron_right</i> -->
								Lista de clientes
							</a>
						</li>
						<li class="nav-item <?php if ($documentacion == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registrosClienteDocumentosventasAsistentes">
								<!-- <i class="material-icons">arrow_right</i> -->
								Documentación
							</a>
						</li>
						<li class="nav-item <?php if ($autorizacion == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registrosClienteAutorizacionAsistentes">
								<!-- <i class="material-icons">assignment_turned_in</i> -->
								Autorización
							</a>
						</li>
						<li class="nav-item <?php if ($contrato == 1) {
							echo 'active';
						} ?>">
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
						<li class="nav-item <?php if ($inventario == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/inventario">
								<!-- <i class="material-icons">assignment</i> -->
								Inventario
							</a>
						</li>
						<li class="nav-item <?php if ($estatus8 == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus8VentasAsistentes">
								<!-- <i class="material-icons">filter_8</i> -->
								Estatus 8
							</a>
						</li>
						<li class="nav-item <?php if ($estatus14 == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus14VentasAsistentes">
								<!-- <i class="material-icons">filter_1</i> -->
								Estatus 14
							</a>
						</li>
						<li class="nav-item <?php if ($estatus7 == 1) {
							echo 'active';
						} ?>">
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
						<li class="nav-item <?php if ($estatus9 == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/registroEstatus9VentasAsistentes">
								<!-- <i class="material-icons">filter_9</i> -->
								Estatus 9
							</a>
						</li>

						<li class="nav-item <?php if ($disponibles == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/inventarioDisponible">
								<!-- <i class="material-icons">assignment</i> -->
								Inventario disponibles
							</a>
						</li>
 
					</ul>
				</div>
			</li>
			<li class="nav-item <?php if ($asesores == 1) {
				echo 'active';
			} ?>">
				<a class="nav-link" href="<?= base_url() ?>index.php/Asistente_gerente/catalogoAsesores">
					<i class="material-icons">group</i>
					<p>Catalogo de asesores </p>
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
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/nueva_Solicitud">
								Nueva solicitud
							</a>
						</li>

						<li class="nav-item <?php if ($histComisiones == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Asistente_gerente/hitorial_Comisiones">
								Historial solicitudes
							</a>
						</li>
 
					</ul>
				</div>
			</li>



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
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="<?=base_url() ?>">
							<i class="material-icons">home</i>
							<p class="hidden-lg hidden-md">Home</p>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="material-icons">person</i>
							<p class="hidden-lg hidden-md">Profile</p>
						</a>
						<ul class="dropdown-menu">
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
