
<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>
	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<h5>
							Bienvenido/a 	<?=$this->session->userdata('primerNombre')?> <?=$this->session->userdata('segundoNombre')?> <?=$this->session->userdata('apellidoPaterno')?>
						</h5>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<h4 class="pull-right">
							<script>
								var today = new Date();
								var dd = String(today.getDate()).padStart(2, '0');
								var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
								var yyyy = today.getFullYear();

								var hh = today.getHours();
								var mi = today.getMinutes();
								var ss = today.getSeconds();

								today = mm + '/' + dd + '/' + yyyy + " - " + hh + ":" + mi +":"+ss;
								document.write(today);
							</script>
						</h4>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="orange">
							<i class="material-icons">weekend</i>
						</div>
						<div class="card-content">
							<p class="category">Bookings</p>
							<h3 class="card-title">184</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons text-danger">warning</i>
								<a href="#pablo">Get More Space...</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="rose">
							<i class="material-icons">equalizer</i>
						</div>
						<div class="card-content">
							<p class="category">Website Visits</p>
							<h3 class="card-title">75.521</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">local_offer</i> Tracked from Google Analytics
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="green">
							<i class="material-icons">store</i>
						</div>
						<div class="card-content">
							<p class="category">Revenue</p>
							<h3 class="card-title">$34,245</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">date_range</i> Last 24 Hours
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="blue">
							<i class="fa fa-twitter"></i>
						</div>
						<div class="card-content">
							<p class="category">Followers</p>
							<h3 class="card-title">+245</h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">update</i> Just Updated
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="green">
							<i class="material-icons">language</i>
						</div>
						<div class="card-content">
							<h4 class="card-title">Global Sales by Top Locations</h4>
							<div class="row">
								<div class="col-md-5">
									<div class="table-responsive table-sales">
										<table class="table">
											<tbody>
											<tr>
												<td>
													<div class="flag">
														<img src="../dist/img/flags/US.png">
													</div>
												</td>
												<td>USA</td>
												<td class="text-right">
													2.920
												</td>
												<td class="text-right">
													53.23%
												</td>
											</tr>
											<tr>
												<td>
													<div class="flag">
														<img src="../dist/img/flags/DE.png">
													</div>
												</td>
												<td>Germany</td>
												<td class="text-right">
													1.300
												</td>
												<td class="text-right">
													20.43%
												</td>
											</tr>
											<tr>
												<td>
													<div class="flag">
														<img src="../dist/img/flags/AU.png">
													</div>
												</td>
												<td>Australia</td>
												<td class="text-right">
													760
												</td>
												<td class="text-right">
													10.35%
												</td>
											</tr>
											<tr>
												<td>
													<div class="flag">
														<img src="../dist/img/flags/GB.png">
													</div>
												</td>
												<td>United Kingdom</td>
												<td class="text-right">
													690
												</td>
												<td class="text-right">
													7.87%
												</td>
											</tr>
											<tr>
												<td>
													<div class="flag">
														<img src="../dist/img/flags/RO.png">
													</div>
												</td>
												<td>Romania</td>
												<td class="text-right">
													600
												</td>
												<td class="text-right">
													5.94%
												</td>
											</tr>
											<tr>
												<td>
													<div class="flag">
														<img src="../dist/img/flags/BR.png">
													</div>
												</td>
												<td>Brasil</td>
												<td class="text-right">
													550
												</td>
												<td class="text-right">
													4.34%
												</td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6 col-md-offset-1">
									<div id="worldMap" class="map"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="card card-chart">
						<div class="card-header" data-background-color="rose" data-header-animation="true">
							<div class="ct-chart" id="websiteViewsChart"></div>
						</div>
						<div class="card-content">
							<div class="card-actions">
								<button type="button" class="btn btn-danger btn-simple fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
									<i class="material-icons">refresh</i>
								</button>
								<button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Change Date">
									<i class="material-icons">edit</i>
								</button>
							</div>
							<h4 class="card-title">Website Views</h4>
							<p class="category">Last Campaign Performance</p>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">access_time</i> campaign sent 2 days ago
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card card-chart">
						<div class="card-header" data-background-color="green" data-header-animation="true">
							<div class="ct-chart" id="dailySalesChart"></div>
						</div>
						<div class="card-content">
							<div class="card-actions">
								<button type="button" class="btn btn-danger btn-simple fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
									<i class="material-icons">refresh</i>
								</button>
								<button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Change Date">
									<i class="material-icons">edit</i>
								</button>
							</div>
							<h4 class="card-title">Daily Sales</h4>
							<p class="category">
								<span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">access_time</i> updated 4 minutes ago
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card card-chart">
						<div class="card-header" data-background-color="blue" data-header-animation="true">
							<div class="ct-chart" id="completedTasksChart"></div>
						</div>
						<div class="card-content">
							<div class="card-actions">
								<button type="button" class="btn btn-danger btn-simple fix-broken-card">
									<i class="material-icons">build</i> Fix Header!
								</button>
								<button type="button" class="btn btn-info btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
									<i class="material-icons">refresh</i>
								</button>
								<button type="button" class="btn btn-default btn-simple" rel="tooltip" data-placement="bottom" title="Change Date">
									<i class="material-icons">edit</i>
								</button>
							</div>
							<h4 class="card-title">Completed Tasks</h4>
							<p class="category">Last Campaign Performance</p>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">access_time</i> campaign sent 2 days ago
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
<div class="fixed-plugin" style="display: none">
	<div class="dropdown show-dropdown">
		<a href="#" data-toggle="dropdown">
			<i class="fa fa-cog fa-2x"> </i>
		</a>
		<ul class="dropdown-menu">
			<li class="header-title"> Sidebar Filters</li>
			<li class="adjustments-line">
				<a href="javascript:void(0)" class="switch-trigger active-color">
					<div class="badge-colors ml-auto mr-auto">
						<span class="badge filter badge-purple" data-color="purple"></span>
						<span class="badge filter badge-azure" data-color="azure"></span>
						<span class="badge filter badge-green" data-color="green"></span>
						<span class="badge filter badge-warning" data-color="orange"></span>
						<span class="badge filter badge-danger" data-color="danger"></span>
						<span class="badge filter badge-rose active" data-color="rose"></span>
					</div>
					<div class="clearfix"></div>
				</a>
			</li>
			<li class="header-title">Images</li>
			<li class="active">
				<a class="img-holder switch-trigger" href="javascript:void(0)">
					<img src="../dist/img/sidebar-1.jpg" alt="">
				</a>
			</li>
			<li>
				<a class="img-holder switch-trigger" href="javascript:void(0)">
					<img src="../dist/img/sidebar-2.jpg" alt="">
				</a>
			</li>
			<li>
				<a class="img-holder switch-trigger" href="javascript:void(0)">
					<img src="../dist/img/sidebar-3.jpg" alt="">
				</a>
			</li>
			<li>
				<a class="img-holder switch-trigger" href="javascript:void(0)">
					<img src="../dist/img/sidebar-4.jpg" alt="">
				</a>
			</li>
			<li class="button-container">
				<a href="https://www.creative-tim.com/product/material-dashboard" target="_blank" class="btn btn-primary btn-block">Free Download</a>
			</li>
			<li class="button-container">
				<a href="https://demos.creative-tim.com/material-dashboard/docs/2.1/getting-started/introduction.html" target="_blank" class="btn btn-default btn-block">
					View Documentation
				</a>
			</li>
			<li class="button-container github-star">
				<a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star ntkme/github-buttons on GitHub">Star</a>
			</li>
			<li class="header-title">Thank you for 95 shares!</li>
			<li class="button-container text-center">
				<button id="twitter" class="btn btn-round btn-twitter"><i class="fa fa-twitter"></i> &middot; 45</button>
				<button id="facebook" class="btn btn-round btn-facebook"><i class="fa fa-facebook-f"></i> &middot; 50</button>
				<br>
				<br>
			</li>
		</ul>
	</div>
</div>

</div><!--main-panel close-->
</body>
