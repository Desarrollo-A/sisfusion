<?php class Corrida extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// $this->load->model('registrolote_modelo');
		// $this->load->model('model_queryinventario');
		$this->load->model('Corrida_model');
		$this->load->database('default');
		$this->load->library('Pdf');
		$this->validateSession();
	}

	public function index()
	{
	}

	public function descuentos() {

		$objDatos = json_decode(file_get_contents("php://input"));
		$idLote = $objDatos->lote;
		$paquetes = $this->Corrida_model->getPaquetes($idLote);
		$response = $this->Corrida_model->getDescuentos();


		for( $i = 0; $i < count($paquetes); $i++ ){
			$array = array();
			for( $c = 0; $c < count( $response ); $c++ ){
				if( $paquetes[$i]['id_paquete'] == $response[$c]['id_paquete'] ){
					$array[] = $response[$c];
				}
			}
			$paquetes[$i]['response'] = $array;

		}

		echo json_encode($paquetes);
	}



	public function cf(){
		$this->load->view("corrida/cf_view");
	}

	public function cf2(){
		$this->load->view("corrida/cf_view2");
	}

	public function cf3(){
		$this->load->view("corrida/cf_view_PAC");
	}

	public function getGerente() {
		$data= $this->Corrida_model->getGerente();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getCoordinador() {
		$objDatos = json_decode(file_get_contents("php://input"));
		$data= $this->Corrida_model->getCoordinador($objDatos->gerente);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getAsesor() {
		$objDatos = json_decode(file_get_contents("php://input"));
		$data= $this->Corrida_model->getAsesores($objDatos->coordinador);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

 
	public function editar_ds(){

		$objDatos = json_decode(file_get_contents("php://input"));
		
		$idLote = (int)$objDatos->id_lote;
		$id_asesor = (int)$objDatos->asesor;
		$id_gerente = (int)$objDatos->gerente;
		$cantidad_enganche = (int)$objDatos->cantidad_enganche;
		$paquete = (int)$objDatos->paquete;


		$arreglo =array();
		$arreglo["nombre"]= $objDatos->nombre;
		$arreglo["id_lote"]= $idLote;
		$arreglo["edad"]= $objDatos->edad;
		$arreglo["telefono"]= $objDatos->telefono;
		$arreglo["correo"]= $objDatos->correo;
		$arreglo["id_asesor"]= $id_asesor;
		$arreglo["id_gerente"]= $id_gerente;
		$arreglo["plan_corrida"]= $objDatos->plan;
		$arreglo["anio"]= $objDatos->anio;
		$arreglo["dias_pagar_enganche"]= $objDatos->dias_pagar_enganche;
		$arreglo["porcentaje_enganche"]= $objDatos->porcentaje_enganche;
		$arreglo["cantidad_enganche"]= $cantidad_enganche;
		$arreglo["meses_diferir"]= $objDatos->meses_diferir;
 		$arreglo["paquete"]= $paquete;
		$arreglo["opcion_paquete"]= $objDatos->opcion_paquete;
		$arreglo["precio_m2_final"]= $objDatos->precio_m2_final;
		$arreglo["saldo"]= $objDatos->saldoc;
		$arreglo["precio_final"]= $objDatos->precioFinalc;
		$arreglo["fecha_limite"]= $objDatos->fechaEngc;
		$arreglo["pago_enganche"]= $objDatos->engancheFinalc;
		$arreglo["msi_1p"]= ($objDatos->msi_1p == '' || $objDatos->msi_1p == NULL) ? 0 :$objDatos->msi_1p;
		$arreglo["msi_2p"]= ($objDatos->msi_2p == '' || $objDatos->msi_2p == NULL) ? 0 :$objDatos->msi_2p;
		$arreglo["msi_3p"]= ($objDatos->msi_3p == '' || $objDatos->msi_3p == NULL) ? 0 :$objDatos->msi_3p;
		$arreglo["primer_mensualidad"]= $objDatos->primer_mensualidad;
		$arreglo["finalMesesp1"]= $objDatos->finalMesesp1;
		$arreglo["finalMesesp2"]= $objDatos->finalMesesp2;
		$arreglo["finalMesesp3"]= $objDatos->finalMesesp3;
		$arreglo["observaciones"]= $objDatos->observaciones;
		
		
		
		$response = $this->Corrida_model->insertCf($arreglo);

		if($response) {
			$this->Corrida_model->insertPreciosAll($objDatos->allDescuentos, $idLote, $response[0]['id_corrida']);
			$response['message'] = 'OK';
			echo json_encode($response);

		}else {

			$response['message'] = 'ERROR';
			echo json_encode($response);
		}


	}


	public function inventario(){
		$this->load->view("inventario_view");
	}

	public function insertCorrida(){
		$objDatos = json_decode(file_get_contents("php://input"));
		$response = $this->Corrida_model->insertCorrida($objDatos->data, $objDatos->id_corrida);
	}


	public function caratula_mal(){
		setlocale(LC_MONETARY, 'en_US.UTF-8');

		$informacion_corrida = $this->Corrida_model->getinfoCorrida($this->uri->segment(3));
		$informacion_loteCorrida = $this->Corrida_model->getinfoLoteCorrida($informacion_corrida->row()->id_lote);
		$informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($informacion_corrida->row()->id_lote, $this->uri->segment(3));
		$informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->row()->id_asesor, $informacion_corrida->row()->id_gerente);

		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Sistemas María José Martínez Martínez');
		$pdf->SetTitle('Corrida Financiera');
		$pdf->SetSubject('Corrida Financiera');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('Helvetica', '', 10, '', true);
 		$pdf->AddPage('P', 'LEGAL');
		$pdf->SetFont('Helvetica', '', 7, '', true);
		$pdf->SetFooterMargin(0);
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->Image('static/images/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
		$pdf->setPageMark();
		$pdf->writeHTML(date("d-m-Y H:i:s"));

		$html = '<style>
		legend {
			background-color: #296D5D;
			color: #fff;
			padding: 3px 6px;
		}
		</style>

		<section class="content">
		<div class="row">
		<div class="col-xs-10 col-md-offset-1">
		<div class="box">
		<div class="box-body">

		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
		<td colspan="2" align="right"><b style="font-size: 1.8em; "> CORRIDA FINANCIERA<BR></b><small style="font-size: 2.5em; color: #777;"> Ciudad Maderas</small></td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; ">Información general</b></td>
		</tr>
		</table>

		<br>

		<div class="row">
		<table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Nombre:</b><br>'.$informacion_corrida->row()->nombre.' </td>
		<td style="font-size: 1.3em;"><b>Edad:</b><br>'.$informacion_corrida->row()->edad.' </td>
		<td style="font-size: 1.3em;"><b>Teléfono:</b><br>'.$informacion_corrida->row()->telefono.' </td>
		<td style="font-size: 1.3em;"><b>Email:</b><br>'.$informacion_corrida->row()->correo.' </td>
		</tr>
		</table>

		<br><br><br>

		<table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Gerente:</b><br>'.$informacion_vendedor->row()->nombreGerente.'</td>
		<td style="font-size: 1.3em;"><b>Asesor:</b><br>'.$informacion_vendedor->row()->nombreAsesor.'</td>			
		</tr>
		</table>

		<table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Proyecto:</b><br>'.$informacion_loteCorrida->row()->nombreResidencial.'</td>
		<td style="font-size: 1.3em;"><b>Condominio:</b><br>'.$informacion_loteCorrida->row()->nombreCondominio.'</td> 
		<td style="font-size: 1.3em;"><b>Lote:</b><br>'.$informacion_loteCorrida->row()->nombreLote.'</td>
		<td style="font-size: 1.3em;"><b>Plan:</b><br>'.$informacion_corrida->row()->plan_corrida.'</td>
		<td style="font-size: 1.3em;"><b>Años:</b><br>'.$informacion_corrida->row()->anio.'</td>
		</tr>
		</table>

		<table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Superficie:</b> <br>'.$informacion_loteCorrida->row()->sup.'m<sup>2</sup></td>
		<td style="font-size: 1.3em;"><b>Precio m2:</b> <br>'.$informacion_loteCorrida->row()->precio.'</td> 
		<td style="font-size: 1.3em;"><b>Total:</b> <br>'.$informacion_loteCorrida->row()->total.'</td>
		<td style="font-size: 1.3em;"><b>Porcentaje:</b> <br>'.$informacion_loteCorrida->row()->porcentaje.'%</td>
		<td style="font-size: 1.3em;"><b>Enganche:</b> <br>'.$informacion_loteCorrida->row()->enganche.'</td>
		</tr>
		</table>

		<table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Dias para pagar Enganche:</b><br> '.$informacion_corrida->row()->dias_pagar_enganche.'</td>
		<td style="font-size: 1.3em;"><b>Enganche (%):</b><br> '.$informacion_corrida->row()->porcentaje_enganche.'%</td>
		<td style="font-size: 1.3em;"><b>Enganche cantidad ($):</b><br> '.$informacion_corrida->row()->cantidad_enganche.'</td>							
		<td style="font-size: 1.3em;"><b>Apartado ($):</b><br> '.$informacion_corrida->row()->apartado.'</td>
		<td style="font-size: 1.3em;"><b>Meses a diferir:</b><br> '.$informacion_corrida->row()->meses_diferir.'</td>
		</tr>
		</table>

		<br><br><br>

		<table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; ">Descuentos</b></td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
		<tr align="center">
		<td style="font-size: 1.3em;"><b>Precio final m2</b></td>
		<td style="font-size: 1.3em;"><b>Precio total final</b></td>
		<td style="font-size: 1.3em;"><b>Ahorros</b></td>
        </tr>
        </table>

        <table width="100%" style="padding:0px 0px 10px 0px; height: 45px; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd;" width="690">';

        if($informacion_descCorrida->num_rows() > 0) {
        	foreach ($informacion_descCorrida->result() as $row) {
 			$html .='<tr align="center">
			<td style="color:#2E86C1; font-size: 1.3em;"><b> '.$row->pm.' </b></td>
			<td style="color:#2E86C1; font-size: 1.3em;"><b> '.$row->pt.' </b></td>
			<td style="color:#27AE60; font-size: 1.3em;"><b> '.$row->ahorro.' </b></td></tr>';
		}
	}

	$html .='</table>
	<br><br><br>

	<table width="100%" style=";height: 45px; border: 1px solid #ddd;" width="690">
	<tr align="center">
	<td><b style="font-size:18px">PRECIO FINAL</b><br><label style="font-size:19px">'.$informacion_corrida->row()->precio_final.'</label><br><BR><BR><b style="font-size:15px">Saldo </b><br><label style="font-size:15px">'.$informacion_corrida->row()->saldo.'</label>
	</td>
	</tr>
	</table>

	<br><br>

	<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; "> Enganche y mensualidades</b></td>
	</tr>
	</table>

	<br><br>

	<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td style="font-size: 1.3em;"><b>Días pago enganche</b><br>'.$informacion_corrida->row()->dias_pagar_enganche.'</td>
	<td style="font-size: 1.3em;"><b>Mensualidades SIN interés</b><br><b>'.$informacion_corrida->row()->finalMesesp1.' </b> '.$informacion_corrida->row()->msi_1p.'</td>
	<td style="font-size: 1.3em;"><b>Primer mensualidad</b><br>'.$informacion_corrida->row()->primer_mensualidad.'</td>
	</tr>
	</table>

	<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td style="font-size: 1.3em;"><b>Fecha Limite</b><br>'.$informacion_corrida->row()->fecha_limite.'</td>
	<td style="font-size: 1.3em;"><b>Mensualidades con interés (1% S.S.I.) </b><br><b>'.$informacion_corrida->row()->finalMesesp2.' </b> '.$informacion_corrida->row()->msi_2p.'</td>
	</tr>
	</table>

	<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td style="font-size: 1.3em;"><b>Pago Enganche</b><br>'.$informacion_corrida->row()->pago_enganche.'</td>
	<td style="font-size: 1.3em;"><b>Mensualidades con interés (1.25% S.S.I.) </b><br><b>'.$informacion_corrida->row()->finalMesesp3.' </b> '.$informacion_corrida->row()->msi_3p.'</td>
	</tr>
	</table>

	<br><br>

	<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; ">Datos Bancarios</b></td>
	</tr>
	</table>

	<br><br>

	<table width="100%" style="padding:10px 0px;text-align:center;height: 45px; border: 1px solid #ddd;" width="690">
    <tr>
    <td style="font-size: 1.3em;"><b>Banco:</b></td>
    <td style="font-size: 1.3em;"><b>Razón Social: </b></td>
    <td style="font-size: 1.3em;"><b>Cuenta: </b></td>
    <td style="font-size: 1.3em;"><b>Clabe:</b></td>
    <td style="font-size: 1.3em;"><b>Referencia: </b></td>
    </tr>

    <tr>
    <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->banco.'</td>
    <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->empresa.'</td>
    <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->cuenta.'</td>
    <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->clabe.'</td>
    <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->referencia.'</td>
    </tr>

    </table>

    <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
	<tr><td></td></tr>
	</table>

	<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td style="font-size: 1.3em;"><b>Asesor</b></td>
	<td style="font-size: 1.3em;">'.$informacion_vendedor->row()->nombreAsesor.'</td>
	</tr>
	</table>

	<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td style="font-size: 1.3em;"><b>Observaciones</b></td>
	<td style="font-size: 1em;">'.$informacion_corrida->row()->observaciones.'</td>
	</tr>
	</table>

	<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
	<tr>
	<td style="font-size:1.2em;">Precios, disponibilidad, descuentos y vigencia sujetos a cambio sin previo aviso. Esta simulación constituye un ejercicio numérico que no implica ningún compromiso de Ciudad Maderas o de sus marcas comerciales, CIUDAD MADERAS. Solo sirve para fines de orientación. Los descuentos se aplican "escalonados", primero uno y luego el siguiente. Para Compra Múltiple: familiares que comprueben parentesco, amigos o socios.</td>
	</tr>
	</table>

	<br><br>

	</div></div></div></div>

	</section>';

	$pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
	$namePDF = utf8_decode('CORRIDA_FINANCIERA.pdf');
 
	$pdf->Output(utf8_decode($namePDF), 'I');
}

	public function caratula(){
		setlocale(LC_MONETARY, 'en_US.UTF-8');

		$informacion_corrida = $this->Corrida_model->getinfoCorrida($this->uri->segment(3));
		$informacion_loteCorrida = $this->Corrida_model->getinfoLoteCorrida($informacion_corrida->id_lote);
		$informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($informacion_corrida->id_lote, $this->uri->segment(3));
		
		$getRol = $this->Corrida_model->getRol($informacion_corrida->id_asesor);

		
			if($getRol->id_rol == 7) { // IS ASESOR
				$informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			} else if($getRol->id_rol == 9) { // IS COORDINADOR
				$informacion_vendedor = $this->Corrida_model->getCoordCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			} else { // IS GERENTE
				$informacion_vendedor = $this->Corrida_model->getGerenteCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			}

		$informacion_plan = $this->Corrida_model->getPlanCorrida($this->uri->segment(3));
		$informacion_diferidos = array_slice($informacion_plan, 0, $informacion_corrida->meses_diferir);



		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistemas María José Martínez Martínez');
$pdf->SetTitle('Corrida Financiera');
$pdf->SetSubject('Corrida Financiera');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setFontSubsetting(true);
$pdf->SetFont('Helvetica', '', 10, '', true);
// $pdf->SetMargins(15, 20, 15, true);
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('Helvetica', '', 5, '', true);
$pdf->SetFooterMargin(0);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->Image('static/images/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->setPageMark();
$pdf->writeHTML(date("d-m-Y H:i:s"));



$html = '

<style>


legend {
    background-color: #296D5D;
    color: #fff;
    padding: 3px 6px;
}




</style>

    <section class="content">
		<div class="row">
			<div class="col-xs-10 col-md-offset-1">
			<div class="box">
				<div class="box-body">
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
							<td colspan="2" align="right"><b style="font-size: 3em; "> CORRIDA FINANCIERA<BR></b><small style="font-size: 2.5em; color: #777;"> Ciudad Maderas</small> 
							</td>
						</tr>
					</table>
					
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Información general</b>
							</td>
						</tr>
					</table>							
					<br>


						<div class="row">
	
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Nombre:</b> '.$informacion_corrida->nombre.' 
								</td>
								<td style="font-size: 1.4em;">
								<b>Edad:</b> '.$informacion_corrida->edad.'
								</td> 
								<td style="font-size: 1.4em;">
								<b>Teléfono:</b> '.$informacion_corrida->telefono.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Email:</b> '.$informacion_corrida->correo.'
								</td>
							</tr>
						</table>
                        <br>
                        <br>
                        <br>




                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								<b>Gerente:</b> '.$informacion_vendedor->nombreGerente.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Asesor:</b> '.$informacion_vendedor->nombreAsesor.'
								</td>			
							</tr>
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;text-align:left"><b>Proyecto:</b> '.$informacion_loteCorrida->nombreResidencial.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Condominio:</b> '.$informacion_loteCorrida->nombreCondominio.'
								</td> 
								<td style="font-size: 1.4em;">
								<b>Lote:</b> '.$informacion_loteCorrida->nombreLote.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Plan:</b> '.$informacion_corrida->plan_corrida.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Años:</b> '.$informacion_corrida->anio.'
								</td>
							</tr>							
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								<b>Superficie:</b> '.$informacion_loteCorrida->sup.'m<sup>2</sup>
								</td>
								<td style="font-size: 1.4em;">
								<b>Precio m2:</b> '.money_format('%(#10n',$informacion_loteCorrida->precio).' 
								</td> 
								<td style="font-size: 1.4em;">
								<b>Total:</b> '.money_format('%(#10n',$informacion_loteCorrida->total).'
								</td>
								<td style="font-size: 1.4em;">
								<b>Porcentaje:</b> '.$informacion_loteCorrida->porcentaje.'%
								</td>
							
								<td style="font-size: 1.4em;">
								<b>Enganche:</b> '.money_format('%(#10n',$informacion_loteCorrida->enganche).'
								</td>
							</tr>		
					  </table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
						  <tr>		
								<td style="font-size: 1.4em;">
								<b>Días para pagar Enganche:</b> '.$informacion_corrida->dias_pagar_enganche.'
						    	</td>
								<td style="font-size: 1.4em;">
								<b>Enganche (%):</b> '.$informacion_corrida->porcentaje_enganche.'%
						    	</td>
								<td style="font-size: 1.4em;"><b>Enganche cantidad ($):</b> '.money_format('%(#10n',$informacion_corrida->cantidad_enganche).'
						    	</td>							
								<td style="font-size: 1.4em;">
								<b>Apartado ($):</b> '.money_format('%(#10n',$informacion_corrida->apartado).'
						    	</td>
								<td style="font-size: 1.4em;">
								<b>Meses a diferir:</b> '.$informacion_corrida->meses_diferir.'
							    </td>
						 </tr>		
					  </table>
			
                        <br>
                        <br>
                        <br>
                        
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Descuentos</b>
							</td>
						</tr>
					</table>							
					<br><br>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr align="center">
							  <td style="font-size: 1.4em;"><b>Porcentaje y/o monto</b></td>
							  <td style="font-size: 1.4em;"><b>Precio final m2</b></td>
							  <td style="font-size: 1.4em;"><b>Precio total final</b></td>
							  <td style="font-size: 1.4em;"><b>Ahorros</b></td>
                        </tr>
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">';
                      
                          foreach ($informacion_descCorrida as $row){
                              $html .='
                              <tr align="center">
							  <td style="color:#27AE60; font-size: 1.4em;"><b>'; 
							  
							  if ($row['id_condicion'] == 1 || $row['id_condicion'] == 2){
							  $html .='
							   '.$row['porcentaje'].'%
                              ';
							   }
							   
							  
							  if ($row['id_condicion'] == 3 || $row['id_condicion'] == 4){
							  $html .=' '.money_format('%(#10n',$row['porcentaje']).' ';							 
							  }
							  
							  if ($row['id_condicion'] == 6){
							  $html .=' MENSUALIDAD JULIO';
							  }
							  
							  if ($row['id_condicion'] == 7){
							  $html .='Enganche diferido sin descontar MSI';
							  }
							   
							  
							  $html .='</b></td>
							  <td style="color:#2E86C1; font-size: 1.4em;"><b> '.money_format('%(#10n',$row['pm']).' </b></td>
							  <td style="color:#2E86C1; font-size: 1.4em;"><b> '.money_format('%(#10n',$row['pt']).' </b></td>
							  <td style="color:#27AE60; font-size: 1.4em;"><b> '.money_format('%(#10n',$row['ahorro']).' </b></td>
                              </tr>';
                          }
                          
                        $html .='</table>
                        
                        <br>
                        <br>
                        <br>
                        
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche diferido</b>
							</td>
						</tr>
					</table>							
					<br><br>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr align="center">
							  <td style="font-size: 1.4em;"><b>Fecha</b></td>
							  <td style="font-size: 1.4em;"><b>Pago #</b></td>
							  <td style="font-size: 1.4em;"><b>Total</b></td>
                        </tr>
					  </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">';
                      
                          foreach ($informacion_diferidos as $row){
                              $html .='
                              <tr align="center">
							  <td style="font-size: 1.4em;">'.$row['fecha'].'</td>
							  <td style="font-size: 1.4em;">'.$row['pago'].'</td>
							  <td style="font-size: 1.4em;">'.money_format('%(#10n',$row['total']).'</td>
                              </tr>';
                          }
                          
                        $html .='</table>
                        
                        <br>
                        <br>
                        <br>
						
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">

		
							<tr align="center">
								<td>
								<b style="font-size:10px">Saldo </b><br>
								<label style="font-size:10px">'.money_format('%(#10n',$informacion_corrida->saldo).'</label>
								<BR><BR>
								<b style="font-size:15px">PRECIO FINAL</b><br>
								<label style="font-size:15px">'.money_format('%(#10n',$informacion_corrida->precio_final).'</label><br>
								</td>
							</tr>
					  </table>
					  
					  
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche y mensualidades</b>
							</td>
						</tr>
					</table>							
					<br><br>
						

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Días pago enganche</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->dias_pagar_enganche.'</td>
								<td style="font-size: 1.4em;"><b>Mensualidades SIN interés</b></td>
								<td style="font-size: 1.4em;"> <b>'.$informacion_corrida->finalMesesp1.' </b> '.money_format('%(#10n',$informacion_corrida->msi_1p).'</td>
								<td style="font-size: 1.4em;"><b>Primer mensualidad</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->primer_mensualidad.'</td>
							</tr>
					  </table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Fecha Límite</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->fecha_limite.'</td>
								<td style="font-size: 1.4em;"><b>Mensualidades con interés (1% S.S.I.) </b></td>
								<td style="font-size: 1.4em;"> <b>'.$informacion_corrida->finalMesesp2.' </b> '.money_format('%(#10n',$informacion_corrida->msi_2p).'</td>
								<td style="font-size: 1.4em;"></td>
								<td style="font-size: 1.4em;"></td>
								</tr>
					  </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">

							<tr>
								<td style="font-size: 1.4em;"><b>Pago Enganche</b></td>
								<td style="font-size: 1.4em;">'.money_format('%(#10n',$informacion_corrida->pago_enganche).'<br></td>
								<td style="font-size: 1.4em;"><b>Mensualidades con interés (1.25% S.S.I.) </b></td>
								<td style="font-size: 1.4em;"> <b>'.$informacion_corrida->finalMesesp3.' </b> '.money_format('%(#10n',$informacion_corrida->msi_3p).'</td>
								<td style="font-size: 1.4em;"></td>
								<td style="font-size: 1.4em;"></td>
							</tr>
						</table>

						
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos Bancarios</b>
							</td>
						</tr>
					</table>							
					<br><br>
						
		
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
                        <tr>
                        <td style="font-size: 1.4em;"><b>Banco:</b></td>
                        <td style="font-size: 1.4em;"><b>Razón Social: </b></td>
                        <td style="font-size: 1.4em;"><b>Cuenta: </b></td>
                        <td style="font-size: 1.4em;"><b>Clabe:</b></td>
                        <td style="font-size: 1.4em;"><b>Referencia: </b></td>
                        </tr>

                        <tr>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->banco.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->empresa.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->cuenta.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->clabe.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->referencia.'</td>
                        </tr>
                        
                        
                        </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td></td>
							</tr>		
						</table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Asesor</b></td>
								<td style="font-size: 1.4em;">'.$informacion_vendedor->nombreAsesor.'</td>
							</tr>
						</table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Observaciones</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->observaciones.'</td>
							</tr>
						</table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								   Precios, disponibilidad, descuentos y vigencia sujetos a cambio sin previo aviso. Esta simulación constituye un ejercicio numérico que no implica ningún compromiso de Ciudad Maderas o de sus marcas comerciales, CIUDAD MADERAS. Solo sirve para fines de orientación. Los descuentos se aplican "escalonados", primero uno y luego el siguiente. Para Compra Múltiple: familiares que comprueben parentesco, amigos o socios.  
					             </td>
							</tr>
						</table>
                        <br>
                        <br>

				  </div>
				</div>
			  </div>

		</div>
	</section>
         

';

$pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);


$namePDF = utf8_decode('CORRIDA_FINANCIERA.pdf');



$pdf->Output(utf8_decode($namePDF), 'I');




}






	public function caratulacf_mal(){
		setlocale(LC_MONETARY, 'en_US.UTF-8');

		$informacion_corrida = $this->Corrida_model->getinfoCorrida($this->uri->segment(3));
		$informacion_loteCorrida = $this->Corrida_model->getinfoLoteCorrida($informacion_corrida->row()->id_lote);
		$informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($informacion_corrida->row()->id_lote, $this->uri->segment(3));
		$informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->row()->id_asesor, $informacion_corrida->row()->id_gerente);
		$informacion_plan = $this->Corrida_model->getPlanCorrida($this->uri->segment(3));

		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Sistemas María José Martínez Martínez');
		$pdf->SetTitle('Corrida Financiera');
		$pdf->SetSubject('Corrida Financiera');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('Helvetica', '', 10, '', true);
 		$pdf->AddPage('P', 'LEGAL');
		$pdf->SetFont('Helvetica', '', 7, '', true);
		$pdf->SetFooterMargin(0);
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		/* $pdf->Image('static/images/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false); */
		/* $pdf->setPageMark(); */
		$pdf->writeHTML(date("d-m-Y H:i:s"));


		setlocale(LC_MONETARY, 'es_MX');

		$html = '<style>
		legend {
			background-color: #296D5D;
			color: #fff;
			padding: 3px 6px;
		}

		</style>
		<section class="content">
		<div class="row">
		<div class="col-xs-10 col-md-offset-1">
		<div class="box">
		<div class="box-body">
		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
		<td colspan="2" align="right"><b style="font-size: 1.8em; "> CORRIDA FINANCIERA<BR></b><small style="font-size: 2.5em; color: #777;"> Ciudad Maderas</small></td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="padding:10px 0px; text-align: center; height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; border-radius: 15px;"><b style="font-size: 1.8em; ">Información general</b>
		</td>
		</tr>
		</table>

		<br>

		<div class="row">

		<table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Nombre:</b><br> ' .$informacion_corrida->row()->nombre.'</td>
		<td style="font-size: 1.3em;"><b>Edad:</b><br> '.$informacion_corrida->row()->edad.'</td> 
		<td style="font-size: 1.3em;"><b>Teléfono:</b><br> '.$informacion_corrida->row()->telefono.'</td>
		<td style="font-size: 1.3em;"><b>Email:</b><br> '.$informacion_corrida->row()->correo.'</td>
		</tr>
		</table>
		
		<br><br><br>

		<table width="100%" style="padding:10px 3px;height: 60px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><br><b>Gerente:</b><br> '.$informacion_vendedor->row()->nombreGerente.'</td>
		<td style="font-size: 1.3em;"><br><b>Asesor:</b><br> '.$informacion_vendedor->row()->nombreAsesor.'</td>			
		</tr>
		</table>

		<table width="100%" style="padding:10px 3px;height: 60px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Proyecto:</b><br> '.$informacion_loteCorrida->row()->nombreResidencial.'</td>
		<td style="font-size: 1.3em;"><b>Condominio:</b><br> '.$informacion_loteCorrida->row()->nombreCondominio.'</td> 
		<td style="font-size: 1.3em;"><b>Lote:</b><br> '.$informacion_loteCorrida->row()->nombreLote.'</td>
		<td style="font-size: 1.3em;"><b>Plan:</b><br> '.$informacion_corrida->row()->plan_corrida.'</td>
		<td style="font-size: 1.3em;"><b>Años:</b><br> '.$informacion_corrida->row()->anio.'</td>
		</tr>
		</table>

		<table width="100%" style="padding:10px 3px;height: 60px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Superficie:</b><br> '.$informacion_loteCorrida->row()->sup.'m<sup>2</sup></td>
		<td style="font-size: 1.3em;"><b>Precio m2:</b><br> '.$informacion_loteCorrida->row()->total.'</td> 
		<td style="font-size: 1.3em;"><b>Total:</b><br> '.$informacion_loteCorrida->row()->total.'</td>
		<td style="font-size: 1.3em;"><b>Porcentaje:</b><br> '.$informacion_loteCorrida->row()->porcentaje.'%</td>
		<td style="font-size: 1.3em;"><b>Enganche:</b><br> '.$informacion_loteCorrida->row()->enganche.'</td>
		</tr>
		</table>

		<table width="100%" style="padding:10px 3px;height: 60px; border: 1px solid #ddd; text-align: center;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Dias para pagar Enganche:</b><br> '.$informacion_corrida->row()->dias_pagar_enganche.'</td>
		<td style="font-size: 1.3em;"><b>Enganche (%):</b><br> '.$informacion_corrida->row()->porcentaje_enganche.'%</td>
		<td style="font-size: 1.3em;"><b>Enganche cantidad ($):</b><br> '.$informacion_corrida->row()->cantidad_enganche.'</td>							
		<td style="font-size: 1.3em;"><b>Apartado ($):</b><br> '.$informacion_corrida->row()->apartado.'</td>
		<td style="font-size: 1.3em;"><b>Meses a diferir:</b><br> '.$informacion_corrida->row()->meses_diferir.'</td>
		</tr>
		</table>

		<br><br><br>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; ">Descuentos</b></td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="padding:10px 0px 0px 0px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
		<tr align="center">
		<td style="font-size: 1.3em;"><b>Precio final m2</b></td>
		<td style="font-size: 1.3em;"><b>Precio total final</b></td>
		<td style="font-size: 1.3em;"><b>Ahorros</b></td>
		</tr>
		</table>

		<table width="100%" style="padding:0px 0px 10px 0px; height: 45px; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd;" width="690">';

		if($informacion_descCorrida->num_rows() > 0) {
			foreach ($informacion_descCorrida->result() as $row) {
				$html .='<tr align="center">
				<td style="color:#2E86C1; font-size: 1.3em;"><b> '.$row->pm.' </b></td>
				<td style="color:#2E86C1; font-size: 1.3em;"><b> '.$row->pt.' </b></td>
				<td style="color:#27AE60; font-size: 1.3em;"><b> '.$row->ahorro.' </b></td></tr>';
			}
		}

		$html .='</table><br><br><br>
		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr align="center">
		<td><b style="font-size:18px">PRECIO FINAL</b><br><label style="font-size:19px">'.$informacion_corrida->row()->precio_final.'</label><br><BR><BR><b style="font-size:15px">Saldo </b><br><label style="font-size:15px">'.$informacion_corrida->row()->saldo.'</label>
		</td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; ">Enganche y mensualidades</b></td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Días pago enganche</b><br>'.$informacion_corrida->row()->dias_pagar_enganche.'</td>
		<td style="font-size: 1.3em;"><b>Mensualidades SIN interés</b><br><b>'.$informacion_corrida->row()->finalMesesp1.' </b> '.$informacion_corrida->row()->msi_1p.'</td>
		<td style="font-size: 1.3em;"><b>Primer mensualidad</b><br>'.$informacion_corrida->row()->primer_mensualidad.'</td>
		</tr>
		</table>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Fecha Limite</b><br>'.$informacion_corrida->row()->fecha_limite.'</td>
		<td style="font-size: 1.3em;"><b>Mensualidades con interés (1% S.S.I.) </b><br><b>'.$informacion_corrida->row()->finalMesesp2.' </b> '.$informacion_corrida->row()->msi_2p.'</td>
		</tr>
		</table>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Pago Enganche</b><br>'.$informacion_corrida->row()->pago_enganche.'</td>
		<td style="font-size: 1.3em;"><b>Mensualidades con interés (1.25% S.S.I.) </b><br><b>'.$informacion_corrida->row()->finalMesesp3.' </b> '.$informacion_corrida->row()->msi_3p.'</td>
		</tr></table>

		<br><br>

		<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td colspan="2" style="background-color: #001459;color: #fff;padding: 3px 6px; "><b style="font-size: 1.8em; ">Datos Bancarios</b></td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="padding:10px 0px;text-align:center;height: 45px; border: 1px solid #ddd;" width="690">
        <tr>
        <td style="font-size: 1.3em;"><b>Banco:</b></td>
        <td style="font-size: 1.3em;"><b>Razón Social: </b></td>
        <td style="font-size: 1.3em;"><b>Cuenta: </b></td>
        <td style="font-size: 1.3em;"><b>Clabe:</b></td>
        <td style="font-size: 1.3em;"><b>Referencia: </b></td>
        </tr>

        <tr>
        <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->banco.'</td>
        <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->empresa.'</td>
        <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->cuenta.'</td>
        <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->clabe.'</td>
        <td style="font-size: 1.3em;">'.$informacion_loteCorrida->row()->referencia.'</td>
        </tr>
        </table>

        <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr><td></td></tr>
		</table>

		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Asesor</b></td>
		<td style="font-size: 1.3em;">'.$informacion_vendedor->row()->nombreAsesor.'</td>
		</tr>
		</table>

		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td style="font-size: 1.3em;"><b>Observaciones</b></td>
		<td style="font-size: 1em;">'.$informacion_corrida->row()->observaciones.'</td>
		</tr>
		</table>

		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr>
		<td style="font-size: 1.2em;">Precios, disponibilidad, descuentos y vigencia sujetos a cambio sin previo aviso. Esta simulación constituye un ejercicio numérico que no implica ningún compromiso de Ciudad Maderas o de sus marcas comerciales, CIUDAD MADERAS. Solo sirve para fines de orientación. Los descuentos se aplican "escalonados", primero uno y luego el siguiente. Para Compra Múltiple: familiares que comprueben parentesco, amigos o socios.</td>
		</tr>
		</table>

		<br><br>

		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
		<tr align="center">
		<td style="border:1px solid #ddd; font-size: 1.3em;"><b>Fecha</b></td>
		<td style="border:1px solid #ddd; font-size: 1.3em;"><b>Pago #</b></td>
		<td style="border:1px solid #ddd; font-size: 1.3em;"><b>Capital</b></td>
		<td style="border:1px solid #ddd; font-size: 1.3em;"><b>Intereses</b></td>
		<td style="border:1px solid #ddd; font-size: 1.3em;"><b>Total</b></td>
		<td style="border:1px solid #ddd; font-size: 1.3em;"><b>Saldo</b></td>
		</tr>
		</table>

		<table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">';

		if($informacion_plan->num_rows() > 0) {
			foreach ($informacion_plan->result() as $row) {
 			$html .='<tr align="center">
			<td style="border:1px solid #ddd; font-size: 1.3em;">'.$row->fecha.'</td>
			<td style="border:1px solid #ddd; font-size: 1.3em;">'.$row->pago.'</td>
			<td style="border:1px solid #ddd; font-size: 1.3em;">'.$row->capital.'</td>
			<td style="border:1px solid #ddd; font-size: 1.3em;">'.$row->interes.'</td>
			<td style="border:1px solid #ddd; font-size: 1.3em;">'.$row->total.'</td>
			<td style="border:1px solid #ddd; font-size: 1.3em;">'.$row->saldo.'</td>
			</tr>';
		}
	}

	$html .='</table>
	<br><br>
	</div>
	</div>
	</div>
	</div>
	</section>';

	$pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

	$namePDF = utf8_decode('CORRIDA_FINANCIERA.pdf');

	$pdf->Output(utf8_decode($namePDF), 'I');
}


	public function caratulacf(){
		setlocale(LC_MONETARY, 'en_US.UTF-8');

		$informacion_corrida = $this->Corrida_model->getinfoCorrida($this->uri->segment(3));
		$informacion_loteCorrida = $this->Corrida_model->getinfoLoteCorrida($informacion_corrida->id_lote);
		$informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($informacion_corrida->id_lote, $this->uri->segment(3));

		$getRol = $this->Corrida_model->getRol($informacion_corrida->id_asesor);

		
			if($getRol->id_rol == 7){ // IS ASESOR
				$informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			} else if($getRol->id_rol == 9){ // IS COORDINADOR
				$informacion_vendedor = $this->Corrida_model->getCoordCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			} else { // IS GERENTE
				$informacion_vendedor = $this->Corrida_model->getGerenteCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			}	
		
		
		$informacion_plan = $this->Corrida_model->getPlanCorrida($this->uri->segment(3));

		$informacion_diferidos = array_slice($informacion_plan, 0, $informacion_corrida->meses_diferir);




		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistemas María José Martínez Martínez');
$pdf->SetTitle('Corrida Financiera');
$pdf->SetSubject('Corrida Financiera');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, 0);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->setFontSubsetting(true);
$pdf->SetFont('Helvetica', '', 10, '', true);
// $pdf->SetMargins(15, 20, 15, true);
$pdf->AddPage('P', 'LEGAL');
$pdf->SetFont('Helvetica', '', 5, '', true);
$pdf->SetFooterMargin(0);
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->Image('static/images/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->setPageMark();
$pdf->writeHTML(date("d-m-Y H:i:s"));



$html = '

<style>


legend {
    background-color: #296D5D;
    color: #fff;
    padding: 3px 6px;
}




</style>

    <section class="content">
		<div class="row">
			<div class="col-xs-10 col-md-offset-1">
			<div class="box">
				<div class="box-body">
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
							<td colspan="2" align="right"><b style="font-size: 3em; "> CORRIDA FINANCIERA<BR></b><small style="font-size: 2.5em; color: #777;"> Ciudad Maderas</small> 
							</td>
						</tr>
					</table>
					
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Información general</b>
							</td>
						</tr>
					</table>							
					<br>


						<div class="row">
	
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
                             	<b>Nombre:</b> '.$informacion_corrida->nombre.' 
								</td>
								<td style="font-size: 1.4em;">
								<b>Edad:</b> '.$informacion_corrida->edad.'
								</td> 
								<td style="font-size: 1.4em;">
								<b>Teléfono:</b> '.$informacion_corrida->telefono.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Email:</b> '.$informacion_corrida->correo.'
								</td>
							</tr>
						</table>
                        <br>
                        <br>
                        <br>




                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								<b>Gerente:</b> '.$informacion_vendedor->nombreGerente.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Asesor:</b> '.$informacion_vendedor->nombreAsesor.'
								</td>			
							</tr>
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
						    	<b>Proyecto:</b> '.$informacion_loteCorrida->nombreResidencial.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Condominio:</b> '.$informacion_loteCorrida->nombreCondominio.'
								</td> 
								<td style="font-size: 1.4em;">
								<b>Lote:</b> '.$informacion_loteCorrida->nombreLote.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Plan:</b> '.$informacion_corrida->plan_corrida.'
								</td>
								<td style="font-size: 1.4em;">
								<b>Años:</b> '.$informacion_corrida->anio.'
								</td>
							</tr>							
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								<b>Superficie:</b> '.$informacion_loteCorrida->sup.'m<sup>2</sup>
								</td>
								<td style="font-size: 1.4em;">
								<b>Precio m2:</b> '.money_format('%(#10n',$informacion_loteCorrida->precio).' 
								</td> 
								<td style="font-size: 1.4em;">
								<b>Total:</b> '.money_format('%(#10n',$informacion_loteCorrida->total).'
								</td>
								<td style="font-size: 1.4em;">
								<b>Porcentaje:</b> '.$informacion_loteCorrida->porcentaje.'%
								</td>
							
								<td style="font-size: 1.4em;">
								<b>Enganche:</b> '.money_format('%(#10n',$informacion_loteCorrida->enganche).'
								</td>
							</tr>		
					  </table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
						  <tr>		
								<td style="font-size: 1.4em;">
								<b>Días para pagar Enganche:</b> '.$informacion_corrida->dias_pagar_enganche.'
						    	</td>
								<td style="font-size: 1.4em;">
								<b>Enganche (%):</b> '.$informacion_corrida->porcentaje_enganche.'%
						    	</td>
								<td style="font-size: 1.4em;">
                        		<b>Enganche cantidad ($):</b> '.money_format('%(#10n',$informacion_corrida->cantidad_enganche).'
						    	</td>							
								<td style="font-size: 1.4em;">
								<b>Apartado ($):</b> '.money_format('%(#10n',$informacion_corrida->apartado).'
						    	</td>
								<td style="font-size: 1.4em;">
								<b>Meses a diferir:</b> '.$informacion_corrida->meses_diferir.'
							    </td>
						 </tr>		
					  </table>
			
                        <br>
                        <br>
                        <br>
                        
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Descuentos</b>
							</td>
						</tr>
					</table>							
					<br><br>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr align="center">
							  <td style="font-size: 1.4em;"><b>Porcentaje y/o monto</b></td>
							  <td style="font-size: 1.4em;"><b>Precio final m2</b></td>
							  <td style="font-size: 1.4em;"><b>Precio total final</b></td>
							  <td style="font-size: 1.4em;"><b>Ahorros</b></td>
                        </tr>
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">';
                      
                          foreach ($informacion_descCorrida as $row){
                              $html .='
                              <tr align="center">
							  <td style="color:#27AE60; font-size: 1.4em;"><b>'; 
							  
							  if ($row['id_condicion'] == 1 || $row['id_condicion'] == 2){
							  $html .='
							   '.$row['porcentaje'].'%
                              ';
							   }
							   
							  
							  if ($row['id_condicion'] == 3 || $row['id_condicion'] == 4){
							  $html .=' '.money_format('%(#10n',$row['porcentaje']).' ';							 
							  }
							  
							  if ($row['id_condicion'] == 6){
							  $html .=' MENSUALIDAD JULIO';
							  }
							  
							  if ($row['id_condicion'] == 7){
							  $html .='Enganche diferido sin descontar MSI';
							  }
							  
							  
							  $html .='</b></td>
							  <td style="color:#2E86C1; font-size: 1.4em;"><b> '.money_format('%(#10n',$row['pm']).' </b></td>
							  <td style="color:#2E86C1; font-size: 1.4em;"><b> '.money_format('%(#10n',$row['pt']).' </b></td>
							  <td style="color:#27AE60; font-size: 1.4em;"><b> '.money_format('%(#10n',$row['ahorro']).' </b></td>
                              </tr>';
                          }
                          
                        $html .='</table>
                        
                        <br>
                        <br>
                        <br>
                        
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche diferido</b>
							</td>
						</tr>
					</table>							
					<br><br>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr align="center">
							  <td style="font-size: 1.4em;"><b>Fecha</b></td>
							  <td style="font-size: 1.4em;"><b>Pago #</b></td>
							  <td style="font-size: 1.4em;"><b>Total</b></td>
                        </tr>
					  </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">';
                      
                          foreach ($informacion_diferidos as $row){
                              $html .='
                              <tr align="center">
							  <td style="font-size: 1.4em;">'.$row['fecha'].'</td>
							  <td style="font-size: 1.4em;">'.$row['pago'].'</td>
							  <td style="font-size: 1.4em;">'.money_format('%(#10n',$row['total']).'</td>
                              </tr>';
                          }
                          
                        $html .='</table>
                        
                        <br>
                        <br>
                        <br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">

		
							<tr align="center">
								<td>
								<b style="font-size:10px">Saldo </b><br>
								<label style="font-size:10px">'.money_format('%(#10n',$informacion_corrida->saldo).'</label>
								<BR><BR>
								<b style="font-size:15px">PRECIO FINAL</b><br>
								<label style="font-size:15px">'.money_format('%(#10n',$informacion_corrida->precio_final).'</label><br>
								</td>
							</tr>
					  </table>
					  
					  
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche y mensualidades</b>
							</td>
						</tr>
					</table>							
					<br><br>
						

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Días pago enganche</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->dias_pagar_enganche.'</td>
								<td style="font-size: 1.4em;"><b>Mensualidades SIN interés</b></td>
								<td style="font-size: 1.4em;"> <b>'.$informacion_corrida->finalMesesp1.' </b> '.money_format('%(#10n',$informacion_corrida->msi_1p).'</td>
								<td style="font-size: 1.4em;"><b>Primer mensualidad</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->primer_mensualidad.'</td>
							</tr>
					  </table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Fecha Límite</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->fecha_limite.'</td>
								<td style="font-size: 1.4em;"><b>Mensualidades con interés (1% S.S.I.) </b></td>
								<td style="font-size: 1.4em;"> <b>'.$informacion_corrida->finalMesesp2.' </b> '.money_format('%(#10n',$informacion_corrida->msi_2p).'</td>
								<td style="font-size: 1.4em;"></td>
								<td style="font-size: 1.4em;"></td>
								</tr>
					  </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">

							<tr>
								<td style="font-size: 1.4em;"><b>Pago Enganche</b></td>
								<td style="font-size: 1.4em;">'.money_format('%(#10n',$informacion_corrida->pago_enganche).'<br></td>
								<td style="font-size: 1.4em;"><b>Mensualidades con interés (1.25% S.S.I.) </b></td>
								<td style="font-size: 1.4em;"> <b>'.$informacion_corrida->finalMesesp3.' </b> '.money_format('%(#10n',$informacion_corrida->msi_3p).'</td>
								<td style="font-size: 1.4em;"></td>
								<td style="font-size: 1.4em;"></td>
							</tr>
						</table>

						
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #296D5D;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos Bancarios</b>
							</td>
						</tr>
					</table>							
					<br><br>
						
		
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
                        <tr>
                        <td style="font-size: 1.4em;"><b>Banco:</b></td>
                        <td style="font-size: 1.4em;"><b>Razón Social: </b></td>
                        <td style="font-size: 1.4em;"><b>Cuenta: </b></td>
                        <td style="font-size: 1.4em;"><b>Clabe:</b></td>
                        <td style="font-size: 1.4em;"><b>Referencia: </b></td>
                        </tr>

                        <tr>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->banco.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->empresa.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->cuenta.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->clabe.'</td>
                        <td style="font-size: 1.4em;">'.$informacion_loteCorrida->referencia.'</td>
                        </tr>
                        
                        
                        </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td></td>
							</tr>		
						</table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Asesor</b></td>
								<td style="font-size: 1.4em;">'.$informacion_vendedor->nombreAsesor.'</td>
							</tr>
						</table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Observaciones</b></td>
								<td style="font-size: 1.4em;">'.$informacion_corrida->observaciones.'</td>
							</tr>
						</table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								   Precios, disponibilidad, descuentos y vigencia sujetos a cambio sin previo aviso. Esta simulación constituye un ejercicio numérico que no implica ningún compromiso de Ciudad Maderas o de sus marcas comerciales, CIUDAD MADERAS. Solo sirve para fines de orientación. Los descuentos se aplican "escalonados", primero uno y luego el siguiente. Para Compra Múltiple: familiares que comprueben parentesco, amigos o socios.  
					             </td>
							</tr>
						</table>



					<br><br><br>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr align="center">
							  <td style="border:1px solid #ddd; font-size: 1.4em;"><b>Fecha</b></td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;"><b>Pago #</b></td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;"><b>Capital</b></td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;"><b>Intereses</b></td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;"><b>Total</b></td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;"><b>Saldo</b></td>


                        </tr>
					  </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">';
                      
                          foreach ($informacion_plan as $row){
                              $html .='
                              <tr align="center">
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.$row['fecha'].'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.$row['pago'].'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row['capital']).'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row['interes']).'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row['total']).'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row['saldo']).'</td>
                              </tr>';
                          }
                          
                        $html .='</table>
                        
                        <br>
                        <br>

				  </div>
				</div>
			  </div>

		</div>
	</section>
         

';

$pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);


$namePDF = utf8_decode('CORRIDA_FINANCIERA.pdf');



$pdf->Output(utf8_decode($namePDF), 'I');



}

	/*
	That it is an implementation of the function money_format for the
	platforms that do not it bear.

	The function accepts to same string of format accepts for the
	original function of the PHP.

	(Sorry. my writing in English is very bad)

	The function is tested using PHP 5.1.4 in Windows XP
	and Apache WebServer.
	*/


	function money_format($floatcurr, $curr = 'EUR')
	{
		$currencies['ARS'] = array(2, ',', '.');          //  Argentine Peso
		$currencies['AMD'] = array(2, '.', ',');          //  Armenian Dram
		$currencies['AWG'] = array(2, '.', ',');          //  Aruban Guilder
		$currencies['AUD'] = array(2, '.', ' ');          //  Australian Dollar
		$currencies['BSD'] = array(2, '.', ',');          //  Bahamian Dollar
		$currencies['BHD'] = array(3, '.', ',');          //  Bahraini Dinar
		$currencies['BDT'] = array(2, '.', ',');          //  Bangladesh, Taka
		$currencies['BZD'] = array(2, '.', ',');          //  Belize Dollar
		$currencies['BMD'] = array(2, '.', ',');          //  Bermudian Dollar
		$currencies['BOB'] = array(2, '.', ',');          //  Bolivia, Boliviano
		$currencies['BAM'] = array(2, '.', ',');          //  Bosnia and Herzegovina, Convertible Marks
		$currencies['BWP'] = array(2, '.', ',');          //  Botswana, Pula
		$currencies['BRL'] = array(2, ',', '.');          //  Brazilian Real
		$currencies['BND'] = array(2, '.', ',');          //  Brunei Dollar
		$currencies['CAD'] = array(2, '.', ',');          //  Canadian Dollar
		$currencies['KYD'] = array(2, '.', ',');          //  Cayman Islands Dollar
		$currencies['CLP'] = array(0,  '', '.');          //  Chilean Peso
		$currencies['CNY'] = array(2, '.', ',');          //  China Yuan Renminbi
		$currencies['COP'] = array(2, ',', '.');          //  Colombian Peso
		$currencies['CRC'] = array(2, ',', '.');          //  Costa Rican Colon
		$currencies['HRK'] = array(2, ',', '.');          //  Croatian Kuna
		$currencies['CUC'] = array(2, '.', ',');          //  Cuban Convertible Peso
		$currencies['CUP'] = array(2, '.', ',');          //  Cuban Peso
		$currencies['CYP'] = array(2, '.', ',');          //  Cyprus Pound
		$currencies['CZK'] = array(2, '.', ',');          //  Czech Koruna
		$currencies['DKK'] = array(2, ',', '.');          //  Danish Krone
		$currencies['DOP'] = array(2, '.', ',');          //  Dominican Peso
		$currencies['XCD'] = array(2, '.', ',');          //  East Caribbean Dollar
		$currencies['EGP'] = array(2, '.', ',');          //  Egyptian Pound
		$currencies['SVC'] = array(2, '.', ',');          //  El Salvador Colon
		$currencies['ATS'] = array(2, ',', '.');          //  Euro
		$currencies['BEF'] = array(2, ',', '.');          //  Euro
		$currencies['DEM'] = array(2, ',', '.');          //  Euro
		$currencies['EEK'] = array(2, ',', '.');          //  Euro
		$currencies['ESP'] = array(2, ',', '.');          //  Euro
		$currencies['EUR'] = array(2, ',', '.');          //  Euro
		$currencies['FIM'] = array(2, ',', '.');          //  Euro
		$currencies['FRF'] = array(2, ',', '.');          //  Euro
		$currencies['GRD'] = array(2, ',', '.');          //  Euro
		$currencies['IEP'] = array(2, ',', '.');          //  Euro
		$currencies['ITL'] = array(2, ',', '.');          //  Euro
		$currencies['LUF'] = array(2, ',', '.');          //  Euro
		$currencies['NLG'] = array(2, ',', '.');          //  Euro
		$currencies['PTE'] = array(2, ',', '.');          //  Euro
		$currencies['GHC'] = array(2, '.', ',');          //  Ghana, Cedi
		$currencies['GIP'] = array(2, '.', ',');          //  Gibraltar Pound
		$currencies['GTQ'] = array(2, '.', ',');          //  Guatemala, Quetzal
		$currencies['HNL'] = array(2, '.', ',');          //  Honduras, Lempira
		$currencies['HKD'] = array(2, '.', ',');          //  Hong Kong Dollar
		$currencies['HUF'] = array(0,  '', '.');          //  Hungary, Forint
		$currencies['ISK'] = array(0,  '', '.');          //  Iceland Krona
		$currencies['INR'] = array(2, '.', ',');          //  Indian Rupee
		$currencies['IDR'] = array(2, ',', '.');          //  Indonesia, Rupiah
		$currencies['IRR'] = array(2, '.', ',');          //  Iranian Rial
		$currencies['JMD'] = array(2, '.', ',');          //  Jamaican Dollar
		$currencies['JPY'] = array(0,  '', ',');          //  Japan, Yen
		$currencies['JOD'] = array(3, '.', ',');          //  Jordanian Dinar
		$currencies['KES'] = array(2, '.', ',');          //  Kenyan Shilling
		$currencies['KWD'] = array(3, '.', ',');          //  Kuwaiti Dinar
		$currencies['LVL'] = array(2, '.', ',');          //  Latvian Lats
		$currencies['LBP'] = array(0,  '', ' ');          //  Lebanese Pound
		$currencies['LTL'] = array(2, ',', ' ');          //  Lithuanian Litas
		$currencies['MKD'] = array(2, '.', ',');          //  Macedonia, Denar
		$currencies['MYR'] = array(2, '.', ',');          //  Malaysian Ringgit
		$currencies['MTL'] = array(2, '.', ',');          //  Maltese Lira
		$currencies['MUR'] = array(0,  '', ',');          //  Mauritius Rupee
		$currencies['MXN'] = array(2, '.', ',');          //  Mexican Peso
		$currencies['MZM'] = array(2, ',', '.');          //  Mozambique Metical
		$currencies['NPR'] = array(2, '.', ',');          //  Nepalese Rupee
		$currencies['ANG'] = array(2, '.', ',');          //  Netherlands Antillian Guilder
		$currencies['ILS'] = array(2, '.', ',');          //  New Israeli Shekel
		$currencies['TRY'] = array(2, '.', ',');          //  New Turkish Lira
		$currencies['NZD'] = array(2, '.', ',');          //  New Zealand Dollar
		$currencies['NOK'] = array(2, ',', '.');          //  Norwegian Krone
		$currencies['PKR'] = array(2, '.', ',');          //  Pakistan Rupee
		$currencies['PEN'] = array(2, '.', ',');          //  Peru, Nuevo Sol
		$currencies['UYU'] = array(2, ',', '.');          //  Peso Uruguayo
		$currencies['PHP'] = array(2, '.', ',');          //  Philippine Peso
		$currencies['PLN'] = array(2, '.', ' ');          //  Poland, Zloty
		$currencies['GBP'] = array(2, '.', ',');          //  Pound Sterling
		$currencies['OMR'] = array(3, '.', ',');          //  Rial Omani
		$currencies['RON'] = array(2, ',', '.');          //  Romania, New Leu
		$currencies['ROL'] = array(2, ',', '.');          //  Romania, Old Leu
		$currencies['RUB'] = array(2, ',', '.');          //  Russian Ruble
		$currencies['SAR'] = array(2, '.', ',');          //  Saudi Riyal
		$currencies['SGD'] = array(2, '.', ',');          //  Singapore Dollar
		$currencies['SKK'] = array(2, ',', ' ');          //  Slovak Koruna
		$currencies['SIT'] = array(2, ',', '.');          //  Slovenia, Tolar
		$currencies['ZAR'] = array(2, '.', ' ');          //  South Africa, Rand
		$currencies['KRW'] = array(0,  '', ',');          //  South Korea, Won
		$currencies['SZL'] = array(2, '.', ', ');         //  Swaziland, Lilangeni
		$currencies['SEK'] = array(2, ',', '.');          //  Swedish Krona
		$currencies['CHF'] = array(2, '.', '\'');         //  Swiss Franc
		$currencies['TZS'] = array(2, '.', ',');          //  Tanzanian Shilling
		$currencies['THB'] = array(2, '.', ',');          //  Thailand, Baht
		$currencies['TOP'] = array(2, '.', ',');          //  Tonga, Paanga
		$currencies['AED'] = array(2, '.', ',');          //  UAE Dirham
		$currencies['UAH'] = array(2, ',', ' ');          //  Ukraine, Hryvnia
		$currencies['USD'] = array(2, '.', ',');          //  US Dollar
		$currencies['VUV'] = array(0,  '', ',');          //  Vanuatu, Vatu
		$currencies['VEF'] = array(2, ',', '.');          //  Venezuela Bolivares Fuertes
		$currencies['VEB'] = array(2, ',', '.');          //  Venezuela, Bolivar
		$currencies['VND'] = array(0,  '', '.');          //  Viet Nam, Dong
		$currencies['ZWD'] = array(2, '.', ' ');          //  Zimbabwe Dollar
		// custom function to generate: ##,##,###.##
		function formatinr($input)
		{
			$dec = "";
			$pos = strpos($input, ".");
			if ($pos === FALSE)
			{
				//no decimals
			}
			else
			{
				//decimals
				$dec   = substr(round(substr($input, $pos), 2), 1);
				$input = substr($input, 0, $pos);
			}
			$num   = substr($input, -3);    // get the last 3 digits
			$input = substr($input, 0, -3); // omit the last 3 digits already stored in $num
			// loop the process - further get digits 2 by 2
			while (strlen($input) > 0)
			{
				$num   = substr($input, -2).",".$num;
				$input = substr($input, 0, -2);
			}
			return $num.$dec;
		}
		if ($curr == "INR")
		{
			return formatinr($floatcurr);
		}
		else
		{
			return number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
		}
	}


		function getResidencialDisponible() {
		$recidenciales = $this->Corrida_model->getResidencialDis();
		if($recidenciales != null) {
			echo json_encode($recidenciales);
		} else {
			echo json_encode(array());
		}
	}

	
	function getCondominioDisponibleA() {

		$objDatos = json_decode(file_get_contents("php://input"));

		$condominio = $this->Corrida_model->getCondominioDis($objDatos->residencial);
		if($condominio != null) {
			echo json_encode($condominio);
		} else {
			echo json_encode(array());
		}
	}

	 public function validateSession()
    {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            //echo "<script>console.log('No hay sesión iniciada');</script>";
            redirect(base_url() . "index.php/login");
        }
    }


}
