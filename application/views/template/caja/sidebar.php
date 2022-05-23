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
 
			<li class="nav-item hidden-xs  <?php if ($home == 1) {
				echo 'active';
			} ?>">
				<a class="nav-link" href="<?= base_url() ?>">
					<i class="material-icons">home</i>
					<p>Inicio</p>
				</a>
			</li>
 
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
							<a class="nav-link "  href="<?= base_url() ?>index.php/Compartido/[]">
								<!--<i class="material-icons">view_headline</i>-->
								Lista clientes
							</a>
						</li>

						<li class="nav-item <?php if ($documentacion == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link "  href="<?= base_url() ?>index.php/Compartido/[]">
								<!--<i class="material-icons">view_headline</i>-->
								Documentación
							</a>
						</li>

						<li class="nav-item <?php if ($cambiarAsesor == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link " href="<?=base_url()?>index.php/Caja/cambiar_asesor">
								<!--<i class="material-icons">view_headline</i>-->
								Cambiar Asesor
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
							<a class="nav-link" href="<?=base_url()?>index.php/Compartido/[]">
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
