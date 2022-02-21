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
								<i class="material-icons">assignment</i>
								Inventario
							</a>
						</li>
						<li class="nav-item <?php if ($status3== 1) {echo 'active';} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus3ContratacionJuridico">
								<i class="material-icons">filter_3</i>
								Estatus 3
							</a>
						</li>
						<li class="nav-item <?php if ($status7== 1) {echo 'active';} ?>">
							<a class="nav-link" href="<?=base_url()?>index.php/registroLote/registroStatus7ContratacionJuridico">
								<i class="material-icons">filter_7</i>
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
								<i class="material-icons">done_outline</i>
								Lotes Contratados
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
