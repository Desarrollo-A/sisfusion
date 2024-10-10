<style>

#seeLotesDetailModalMetricas table.dataTable > tbody > tr > td{
  white-space: nowrap !important;
}

#seeLotesDetailModalMetricas table.dataTable > thead > tr > th{
    padding: 1px 0px!important;
    text-align: center !important;
    font-weight: lighter;
    font-size: 10px;
}

#seeLotesDetailModalMetricas table {
  text-align: center;
}

#seeLotesDetailModalMetricas table thead tr {
  background-color: #143860;
}

#seeLotesDetailModalMetricas table thead tr th input {
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

#seeLotesDetailModalMetricas table thead tr th input:active {
  border: 1px solid #fff;
}

#seeLotesDetailModalMetricas table thead tr th input:focus {
  border: 1px solid #fff;
}

#seeLotesDetailModalMetricas table thead tr th input::placeholder {
  color: #ffffff;
  text-transform: undercase;
}

#seeLotesDetailModalMetricas table .update-dataTable:hover {
  background-color: #b5c2d0;
}

</style>
<div class="modal fade" id="seeLotesDetailModalMetricas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" data-i18n="desglose-lotes">Desglose de lotes</h4>
			</div>
			<div class="modal-body" style="padding-botom:0px">
        <div class="row">
          <div class="col-md-12">
            <table id="lotesDetailTableMetricas" class="table-striped table-hover w-100 dataTable no-footer">
                <thead>
                    <tr>
                        <th>proyecto</th>
                        <th>condominio</th>
                        <th>lote</th>
                        <th>cliente</th>
                        <th>asesor</th>
                        <th>coordinador</th>
                        <th>gerente</th>
                        <th>subdirector</th>
                        <th>director-regional</th>
                        <th>fecha-apartado</th>
                        <th>superficie</th>
                        <th>Total</th>
                    </tr>
                </thead>
            </table>
          </div>
        </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" data-i18n="cerrar">Cerrar</button>
			</div>
		</div>
	</div>
</div>