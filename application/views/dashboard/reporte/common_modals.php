<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<style>
 table.dataTable > thead > tr > th, #reporte table.dataTable > tbody > tr > th, #reporte table.dataTable > tfoot > tr > th, #reporte table.dataTable > thead > tr > td, #reporte table.dataTable > tbody > tr > td, #reporte table.dataTable > tfoot > tr > td {
  white-space: nowrap !important;
}

table {
  text-align: center;
}

table thead tr {
  background-color: #143860;
}

table thead tr th {
  padding: 3px !important;
}

table thead tr th input {
  border: 1px solid transparent;
  border-radius: 5px;
  color: #ffffff;
  text-align: center;
  font-weight: 500;
  background-color: #143860;
}

table thead tr th input:active {
  border: 1px solid #333333;
}

table thead tr th input:focus {
  border: 1px solid #333333;
}

table thead tr th input::placeholder {
  color: #ffffff;
}

table td.delimetter {
  border-right: solid #eaeaea6b !important;
}

table th.delimetter {
  border-right: solid #284e78 !important;
}

table .update-dataTable {
  border: 0;
  background-color: #D8DDE2;
  color: #103f75;
}

table .update-dataTable:hover {
  background-color: #b5c2d0;
}

table .btnSub {
  border: none;
  background-color: #D8DDE2;
  border-radius: 20px;
  width: 30px;
  height: 30px;
  color: #103f75;
}

table .btnSub:hover {
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
            <!-- <div class="modal-header">
            </div> -->
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
                            <input type="text" class="form-control datepicker text-center pl-1" id="beginDate"/>
                            <span>-</span>
                            <input type="text" class="form-control datepicker text-center " id="endDate"/>
                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                <span class="material-icons update-dataTable">search</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row p-0 h-70">
                    <input type="text" id="type" hidden/>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 h-100">
                        <div id="boxModalChart" class="h-100 d-flex justify-center align-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Desglose de lotes</h4>
			</div>
			<div class="modal-body">
                <div class="row">
		        	<div class="col-md-12">
                        <table id="lotesInformationTable" class="table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Condominio</th>
                                    <th>Lote</th>
                                    <th>Cliente</th>
                                    <th>Asesor</th>
                                    <th>Fecha de apartado</th>
                                    <th>Estatus contratación</th>
                                    <th>Estatus lote</th>
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