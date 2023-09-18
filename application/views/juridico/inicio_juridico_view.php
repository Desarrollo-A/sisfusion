
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
							Bienvenido/a 	<?=$this->session->userdata('nombre')?> <?=$this->session->userdata('apellido_paterno')?> 
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
				<div class="col-lg-3 col-md-6 col-sm-6 hide">
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
				<div class="col-lg-3 col-md-6 col-sm-6 hide">
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
			</div>
			<div class="row hide">
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
			<div class="row hide">
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
			</div>
			<style type="text/css">
				#banner
				{
				/*padding: 5em 0 50em 0;
				    width: 100%;
				    height: auto;
				    background: url('<?=base_url()?>dist/img/img_4.jpeg');
				    background-attachment: cover;
				    background-position: bottom;
				    background-repeat: no-repeat;*/
				    /* CSS gradients */
    				background-image: url('<?=base_url()?>dist/img/img_4.jpeg'), 
                      	-moz-linear-gradient(top, #ADB2B6 0%, #ABAEB3 100%);
    				background-image: url('<?=base_url()?>dist/img/img_4.jpeg'), 
                      -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ADB2B6), color-stop(100%, #ABAEB3));
    				background-image: url('<?=base_url()?>dist/img/img_4.jpeg'), 
                      linear-gradient(to bottom, #ADB2B6, #ABAEB3);
					padding: 400px 100px;
					text-align: center;
					background-position: center center;
					background-size: cover;
					background-repeat: no-repeat;
					position: relative;

				}
				#fondo h1 {
					font-size: 60px;
					color: #;
					position: relative
				}
			</style>
			<div class="row" style="" id="banner">
				<!--<h1>Ciudad Maderas</h1>-->
			</div>
		</div>
	</div>
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
