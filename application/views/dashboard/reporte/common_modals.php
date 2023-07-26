<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<style>
 table.dataTable > thead > tr > th, #reporte table.dataTable > tbody > tr > th, #reporte table.dataTable > tfoot > tr > th, #reporte table.dataTable > thead > tr > td, #reporte table.dataTable > tbody > tr > td, #reporte table.dataTable > tfoot > tr > td {
  white-space: nowrap !important;
}
#seeInformationModalReport table.dataTable > tbody > tr > td{
  white-space: nowrap !important;
}

#seeInformationModalReport table.dataTable > thead > tr > th{
  padding: 1px 0px!important;
}

#seeInformationModalReport table {
  text-align: center;
}

#seeInformationModalReport table thead tr {
  background-color: #143860;
}

#seeInformationModalReport table thead tr th input {
  margin: 4px;
  border: 1px solid transparent;
  border-radius: 5px;
  color: #ffffff;
  text-align: center;
  font-weight: 300;
  font-size: 10px!important;
  background-color: #143860;
  width: 100%;
  text-transform: uppercase;
}

#seeInformationModalReport table thead tr th input:active {
  border: 1px solid #fff;
}

#seeInformationModalReport table thead tr th input:focus {
  border: 1px solid #fff;
}

#seeInformationModalReport table thead tr th input::placeholder {
  color: #ffffff;
  text-transform: undercase;
}

#seeInformationModalReport table .update-dataTable:hover {
  background-color: #b5c2d0;
}

#seeInformationModalCancelados table.dataTable > tbody > tr > td{
  white-space: nowrap !important;
}

#seeInformationModalCancelados table.dataTable > thead > tr > th{
  padding: 1px 0px!important;
    font-weight: lighter;
    text-align: center;
    font-size: 10px;
    text-transform: uppercase;

}

#seeInformationModalCancelados table {
  text-align: center;
}

#seeInformationModalCancelados table thead tr {
  background-color: #143860;
}

#seeInformationModalCancelados table thead tr th input {
  margin: 4px;
  border: 1px solid transparent;
  border-radius: 5px;
  color: #ffffff;
  text-align: center;
  font-weight: 300;
  font-size: 10px;
  background-color: #143860;
  width: 100%;
  text-transform: uppercase;
}

#seeInformationModalCancelados table thead tr th input:active {
  border: 1px solid #fff;
}

#seeInformationModalCancelados table thead tr th input:focus {
  border: 1px solid #fff;
}

#seeInformationModalCancelados table thead tr th input::placeholder {
  color: #ffffff;
  text-transform: undercase;
}

#seeInformationModalCancelados table .update-dataTable:hover {
  background-color: #b5c2d0;
}

.dataTables_scroll .container-fluid {
  padding-top: 5px;
  padding-bottom: 5px;
}

.dataTables_scrollBody::-webkit-scrollbar-track {
  border-radius: 10px;
  background-color: transparent;
}

.dataTables_scrollBody::-webkit-scrollbar {
  width: 2px;
  height: 5px;
  background-color: transparent;
}

.dataTables_scrollBody::-webkit-scrollbar-thumb {
  border-radius: 0px;
  background-color: #c1c1c1;
}

.dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
  background-color: #929292;
}

#reporte .boxAccordions .accordion-content {
  display: none;
}

#reporte .boxAccordions .accordion-content .dataTables_wrapper .container-fluid .row .dataTables_info {
  padding: 0;
  font-size: 12px;
}

#reporte .boxAccordions .accordion-content .dataTables_wrapper .container-fluid .row .paging_full_numbers {
  display: flex;
  justify-content: flex-end;
}


</style>
<div class="modal fade" id="modalChart" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="container-fluid h-100">
                <div class="row h-30 pl-2 pr-2 pt-3">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="boxModalTitle">
                            <div class="title"></div>
                            <div class="total"></div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 d-flex justify-end datesModal">
                        <div class="form-group d-flex m-0 p-0">
                            <input type="text" class="form-control datepicker text-center pl-1" id="fechaInicioVentas"/>
                            <span>-</span>
                            <input type="text" class="form-control datepicker text-center " id="fechaFinVentas"/>
                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange" onclick="searchByDateRange()">
                                <span class="material-icons">search</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row p-0 h-70">
                    <input type="text" id="type" hidden/>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 h-100">
                        <div id="boxModalChart" class="h-100 d-flex justify-center align-center">
                        </div>
                        <div class="loadChartModal w-100 h-100">
                          <img src='<?=base_url('dist/img/miniChartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="seeInformationModalReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Desglose de lotes</h4>
			</div>
			<div class="modal-body" style="padding-botom:0px">
        <div class="row">
          <div class="col-md-12">
            <table id="lotesInformationTable" class="table-striped table-hover w-100">
                <thead>
                    <tr>
                      <th>PROYECTO</th>
                      <th>CONDOMINIO</th>
                      <th>LOTE</th>
                      <th>SUPERFICIE</th>
                      <th>PRECIO DE LISTA</th>
                      <th>PRECIO CON DESCUENTO</th>
                      <th>CASA</th>
                      <th>CLIENTE</th>
                      <th>ASESOR</th>
                      <th>COORDINADOR</th>
                      <th>GERENTE</th>
                      <th>SUBDIRECTOR</th>
                      <th>DIRECTOR REGIONAL</th>
                      <th>FECHA DE APARTADO</th>
                      <th>FECHA DE ÚLTIMO ESTATUS</th>
                      <th>DÍAS DE ÚLTIMO ESTATUS</th>
                      <th>ESTATUS DE CONTRATACÍON</th>
                      <th>FECHA DE ESTATUS 9</th>
                      <th>DÍAS EN ESTATUS 9</th>
                      <th>ESTATUS DEL LOTE</th>
                      <th>APARTADO</th>
                    </tr>
                </thead>
            </table>
          </div>
        </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- END Modals -->

<!-- Modals -->
<div class="modal fade" id="seeInformationModalCancelados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Desglose de lotes</h4>
			</div>
			<div class="modal-body" style="padding-botom:0px">
        <div class="row">
          <div class="col-md-12">
            <table id="lotesInformationTableCancelados" class="table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>PROYECTO</th>
                        <th>CONDOMINIO</th>
                        <th>LOTE</th>
                        <th>SUPERFICIE</th>
                        <th>PRECIO DE LISTA</th>
                        <th>PRECIO CON DESCUENTO</th>
                        <th>CASA</th>
                        <th>CLIENTE</th>
                        <th>ASESOR</th>
                        <th>COORDINADOR</th>
                        <th>GERENTE</th>
                        <th>SUBDIRECTOR</th>
                        <th>DIRECTOR REGIONAL</th>
                        <th>FECHA DE APARTADO</th>
                        <th>FECHA DE ÚLTIMO ESTATUS</th>
                        <th>DÍAS DE ÚLTIMO ESTATUS</th>
                        <th>ESTATUS DE CONTRATACÍON</th>
                        <th>FECHA DE ESTATUS 9</th>
                        <th>DÍAS EN ESTATUS 9</th>
                        <th>ESTATUS DEL LOTE</th>
                        <th>FECHA DE LIBERACIÓN</th>
                        <th>MOTIVO</th>
                        <th>APARTADO</th>
                    </tr>
                </thead>
            </table>
          </div>
        </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- END Modals -->