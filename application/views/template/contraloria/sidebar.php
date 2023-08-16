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
								Ingresar Expediente
							</a>
						</li>

						<li class="nav-item <?php if ($corrida == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link " href="<?=base_url()?>index.php/Contraloria/corrida_contraloria">
								<!--<i class="material-icons">view_headline</i>-->
								Ingresar Corrida
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
							<a class="nav-link" href="<?=base_url()?>index.php/registroLote/registrosLoteJuridico">
								Inventario
							</a>
						</li>
						<li class="nav-item <?php if ($estatus20 == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Contraloria/estatus_2_0_contraloria">
								Estatus 2.0
							</a>
						</li>
						<li class="nav-item <?php if ($estatus2 == 1) {
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
 								Envio contrato a RL
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
							<a class="nav-link" href="<?=base_url()?>index.php/Contraloria/acuse_recibidos_contraloria">
 								Acuse de contratos
							</a>
						</li>
					</ul>
				</div>
			</li>





			<li class="nav-item <?php if ($comnuevas==1||$comhistorial==1) {echo 'active';} ?>">
				<a data-toggle="collapse" href="#comisionesList">
					<i class="material-icons">pie_chart</i>
					<p>Comisiones
						<b class="caret"></b>
					</p>
				</a>
				<div class="collapse" id="comisionesList">
					<ul class="nav">
						<li class="nav-item <?php if ($comnuevas == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Contraloria/comisiones_nuevas_contraloria">
 								Nuevas
							</a>
						</li>
						<li class="nav-item <?php if ($comhistorial == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/Contraloria/comisiones_historial_contraloria">
 								Historial
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
