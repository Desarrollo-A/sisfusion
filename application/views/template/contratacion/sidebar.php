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
			<li class="nav-item hidden-xs  <?php if ($home == 1) { echo 'active'; } ?>">
				<a class="nav-link" href="<?= base_url() ?>">
					<i class="material-icons">home</i>
					<p>Inicio</p>
				</a>
			</li>
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
									<i class="material-icons">assignment</i>
									Inventario
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
									Ver último Status
								</a>
							</li>
							<li class="nav-item <?php if ($lotes45dias== 1) {echo 'active';} ?>">
								<a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesPost45">
									Lotes con más de 45 días
								</a>
							</li>
							<li class="nav-item <?php if ($lotesContratados== 1) {echo 'active';} ?>">
								<a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesContratados">
									Lotes Contratados
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
									Corridas Elaboradas
								</a>
							</li>
							<?php
						}
						if($this->session->userdata('jerarquia_user')==3)
						{
							?>
							<li class="nav-item <?php if ($ultimoStatus== 1) {echo 'active';} ?>">
								<a class="nav-link" href="<?=base_url()?>index.php/registroLote/finalStatus">
									Ver último Status
								</a>
							</li>
							<li class="nav-item <?php if ($lotes45dias== 1) {echo 'active';} ?>">
								<a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesPost45">
									Lotes con más de 45 días
								</a>
							</li>
							<li class="nav-item <?php if ($lotesContratados== 1) {echo 'active';} ?>">
								<a class="nav-link" href="<?=base_url()?>index.php/registroLote/reportLotesContratados">
									Lotes Contratados
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
						<p>Catálogo Asesores
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
