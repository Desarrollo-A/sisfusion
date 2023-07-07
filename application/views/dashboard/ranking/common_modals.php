<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<style>
 table.dataTable > thead > tr > th, #reporte table.dataTable > tbody > tr > th, #reporte table.dataTable > tfoot > tr > th, #reporte table.dataTable > thead > tr > td, #reporte table.dataTable > tbody > tr > td, #reporte table.dataTable > tfoot > tr > td {
  white-space: nowrap !important;
}
#seeInformationModalRanking table.dataTable > tbody > tr > td{
  white-space: nowrap !important;
}

#seeInformationModalRanking table.dataTable > thead > tr > th{
  padding: 1px 0px!important;
}

#seeInformationModalRanking table {
  text-align: center;
}

#seeInformationModalRanking table thead tr {
  background-color: #143860;
}

#seeInformationModalRanking table thead tr th input {
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

#seeInformationModalRanking table thead tr th input:active {
  border: 1px solid #fff;
}

#seeInformationModalRanking table thead tr th input:focus {
  border: 1px solid #fff;
}

#seeInformationModalRanking table thead tr th input::placeholder {
  color: #ffffff;
  text-transform: undercase;
}

#seeInformationModalRanking table .update-dataTable:hover {
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

<!-- Modals -->
<div class="modal fade" id="seeInformationModalRanking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Desglose de lotes</h4>
			</div>
			<div class="modal-body" style="padding-botom:0px">
        <div class="row">
          <div class="col-md-12">
            <table id="lotesInformationTableRanking" class="table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>PROYECTO</th>
                        <th>CONDOMINIO</th>
                        <th>LOTE</th>
                        <th>TOTAL</th>
                        <th>CLIENTE</th>
                        <th>ASESOR</th>
                        <th>FECHA DE APARTADO</th>
                        <th>ESTATUS DE CONTRACIÓN</th>
                        <th>ESTATUS DEL LOTE</th>
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