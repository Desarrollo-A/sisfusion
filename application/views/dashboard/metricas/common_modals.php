<style>

#seeLotesDetailModalMatricas table.dataTable > tbody > tr > td{
  white-space: nowrap !important;
}

#seeLotesDetailModalMatricas table.dataTable > thead > tr > th{
  padding: 1px 0px!important;
}

#seeLotesDetailModalMatricas table {
  text-align: center;
}

#seeLotesDetailModalMatricas table thead tr {
  background-color: #143860;
}

#seeLotesDetailModalMatricas table thead tr th input {
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

#seeLotesDetailModalMatricas table thead tr th input:active {
  border: 1px solid #fff;
}

#seeLotesDetailModalMatricas table thead tr th input:focus {
  border: 1px solid #fff;
}

#seeLotesDetailModalMatricas table thead tr th input::placeholder {
  color: #ffffff;
  text-transform: undercase;
}

#seeLotesDetailModalMatricas table .update-dataTable:hover {
  background-color: #b5c2d0;
}

</style>
<div class="modal fade" id="seeLotesDetailModalMatricas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Desglose de lotes</h4>
			</div>
			<div class="modal-body" style="padding-botom:0px">
        <div class="row">
          <div class="col-md-12">
            <table id="lotesDetailTableMetricas" class="table-striped table-hover w-100">
                <thead>
                    <tr>
                        <th>PROYECTO</th>
                        <th>CONDOMINIO</th>
                        <th>LOTE</th>
                        <th>CLIENTE</th>
                        <th>ASESOR</th>
                        <th>COORDINADOR</th>
                        <th>GERENTE</th>
                        <th>SUBDIRECTOR</th>
                        <th>DIRECTOR REGIONAL</th>
                        <th>FECHA DE APARTADO</th>
                        <th>SUPERFICIE</th>
                        <th>TOTAL</th>
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