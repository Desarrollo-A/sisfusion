<!-- <div class="card-content">
    <div class="row">
        <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px; margin-bottom:2px">
            <div class="card border shadow py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        <div class="col mr-12">
                            <div class="text-xs font-weight-bold lbl-sky text-uppercase center-align"><p>Total:</p></div>
                            <div class="center-align" style="padding-top:20px; margin-bottom:2px;">
                                <i class="fas fa-coins fa-2x" style="color: #0067d4;"></i>
                            </div>
                            <div id="totalGeneral" class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0</div>
                        </div>            
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px; margin-bottom:2px">
            <div class="card border shadow py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        <div class="col mr-12">
                            <div class="text-xs font-weight-bold lbl-sky text-uppercase center-align">Total recaudado:</div>
                            <div class="center-align" style="padding-top:20px; margin-bottom:2px;">
                                <i class="fas fa-coins fa-2x" style="color: #0067d4;"></i>
                            </div>
                            <div id="totalRecaudado" class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0</div>
                        </div>            
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px; margin-bottom:2px">
            <div class="card border shadow py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        <div class="col mr-12">
                            <div class="text-xs font-weight-bold lbl-sky text-uppercase center-align">Total pagado caja:</div>
                            <div class="center-align" style="padding-top:20px; margin-bottom:2px;">
                                <i class="fas fa-coins fa-2x" style="color: #0067d4;"></i>
                            </div>
                            <div id="totalPagadoCaja" class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0</div>
                        </div>            
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px; margin-bottom:2px">
            <div class="card border shadow py-2">
                <div class="card-body">
                    <div class="no-gutters align-items-center">
                        <div class="col mr-12">
                            <div class="text-xs font-weight-bold lbl-sky text-uppercase center-align">Pendiente:</div>
                            <div class="center-align" style="padding-top:20px; margin-bottom:2px;">
                                <i class="fas fa-coins fa-2x" style="color: #0067d4;"></i>
                            </div>
                            <div id="totalPendiente" class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0</div>
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="wrapper" id="chartsAmount">
<div class="content boxContent">
		<div class="container-fluid">
		<div class="row m-auto rowCarousel">
		<div class="w-100 scrollCharts">
			<div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconUno">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0"><br> <span class="str">Total</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalGeneral" id="totalGeneral" 
							class="h5 totalGeneral mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasTotales">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconCuatro">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0"><br> <span class="str">Total recaudado</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalRecaudado" id="totalRecaudado" 
							class="h5 totalRecaudado mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasContratadas">
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconDos">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0"><br> <span class="str">Total pagado caja</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalPagadoCaja" id="totalPagadoCaja" 
							class="h5 totalPagadoCaja mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasContratadas">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconTres">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0"><br> <span class="str">Pendiente</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalPendiente" id="totalPendiente" 
							class="h5 totalPendiente mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasContratadas">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="gradientLeft d-none"></div>
        <div class="gradientRight"></div>
	</div>



