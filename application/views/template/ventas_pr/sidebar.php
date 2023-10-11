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
		<ul class="nav">
			<li class="nav-item <?php if ($home == 1) {echo 'active';} ?>">
				<a class="nav-link" href="<?= base_url() ?>">
					<i class="material-icons">home</i>
					<p>Inicio</p>
				</a>
			</li>
            <?php
            switch ($this->session->userdata('id_rol')) {
                case "19": // SUBDIRECTOR MKTD
                    echo "<li class=\"nav-item <?php if ($usuarios == 1) {echo 'active';} ?>\"><a class=\"nav-link\" href=\"#\"><i class=\"material-icons\">face</i><p>Usuarios</p></a></li>";
                    break;
            }
            ?>
            <li class="nav-item <?php if ($prospectos == 1 || $prospectosAlta==1) {echo 'active';} ?>">
                <a data-toggle="collapse" href="#componentsExamples">
                    <i class="material-icons">perm_contact_calendar</i>
                    <p>Prospectos
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="componentsExamples">
                    <ul class="nav">
                        <?php
                          switch ($this->session->userdata('id_rol')) {
                              case "3": // GERENTE
                              case "9": // COORDINADOR
                              case "7": //ASESOR
                                  echo "<li class=\"<?php if ($prospectosAlta == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/newProspect\">Alta</a></li>";
                                  echo "<li class=\"<?php if ($prospectos == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/consultProspects\">Consulta</a></li>";
                              break;
                              case "1": // DIRECTOR
                              case "2": // SUBDIRECTOR
                              case "4": // ASISTENTE DIRECTOR
                              case "5": // ASISTENTE SUBDIRECTOR
                                  echo "<li class=\"<?php if ($prospectos == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/consultProspects\">Consulta</a></li>";
                              break;
                              case "18": // DIRECTOR MKTD
                                  echo "<li class=\"<?php if ($prospectos == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/consultProspects\">Consulta</a></li>";
                              break;
                              case "19": // SUBDIRECTOR MKTD
                                  echo "<li class=\"<?php if ($prospectosAlta == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/newProspect\">Alta</a></li>";
                                  echo "<li class=\"<?php if ($prospectosAlta == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/consultProspects\">Marketing digital</a></li>";
                                  echo "<li class=\"<?php if ($prospectos == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/consultProspects\">Ventas</a></li>";
                              break;
                              case "20": // GERENTE MKTD
                                  echo "<li class=\"<?php if ($prospectosAlta == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/newProspect\">Alta</a></li>";
                                  echo "<li class=\"<?php if ($prospectos == 1) {echo 'active';} ?>\"><a href=\"". base_url() ."index.php/clientes/consultProspects\">Consulta</a></li>";
                              break;
                          }
                        ?>
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
                        	<a class='nav-link' href='".base_url()."index.php/clientes/concentradoBonificaciones'>
	                        	<i class='material-icons'>help</i>
                                <p>Concentrado Bonificaciones</p>
							</a>                    	 
						</li>";
                    break;

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
