<div class="sidebar" data-active-color="blue" data-background-color="white" data-image="<?=base_url()?>dist/img/sidebar-1.jpg">
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
        <?php $prospectos = 0; $prospectosAlta = 0; $prospectosMktd = 0; $bulkload = 0; $usuarios = 0;?>
		<ul class="nav">
			<li class="nav-item <?php if ($home == 1) {echo 'active';} ?>">
				<a class="nav-link" href="<?= base_url() ?>">
					<i class="material-icons">home</i>
					<p>Inicio</p>
				</a>
			</li>
			<li class="nav-item <?php if ($DS == 1 || $DSConsult==1 || $documentacion == 1 || $listaCliente ==1) {echo 'active';} ?>">
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
						<li class="<?php if ($documentacion == 1) {echo 'active';} ?>">
							<a href="<?= base_url() ?>index.php/asesor/documentacion">
								<!--<span class="sidebar-mini"> D </span>-->
								Documentacion
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
							<a class="nav-link" href="<?= base_url() ?>index.php/Asesor/cf">
								<!--<i class="material-icons">monetization_on</i>-->
								<p>Corrida financiera</p>
							</a>
						</li>
						<li class="<?php if ($inventario == 1) {echo 'active';} ?>">
							<a class="nav-link" href="<?= base_url() ?>index.php/asesor/inventario">
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
			<!-- <li class="nav-item <?php if ($comisiones == 1) {echo 'active';} ?>">
				<a class="nav-link" href="<?= base_url() ?>index.php/Comisiones/comisiones_view">
					<i class="material-icons">assignment_turned_in</i>
					<p>Comisiones</p>
				</a>
			</li> -->

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
							<a class="nav-link" href="<?=base_url()?>index.php/asesor/comisiones_view">
								Nueva solicitud
							</a>
						</li>

						<li class="nav-item <?php if ($histComisiones == 1) {
							echo 'active';
						} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/asesor/hitorial_Comisiones">
								Historial solicitudes
							</a>
						</li>

					</ul>
				</div>
			</li>
            <!--<li class="nav-item <?php if ($statistics == 1) {echo 'active';} ?>">
                <a class="nav-link" href="<?= base_url() ?>index.php/clientes/consultStatistics">
                    <i class="material-icons">bubble_chart</i>
                    <p>Estadísticas</p>
                </a>
            </li>-->



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
<!--				<a class="navbar-brand" href="#"> <img src="--><?//=base_url()?><!--static/images/CMOF.png" width="20%"> </a>-->
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
