<?php
    //require_once 'static/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Corrida extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('registrolote_modelo');
        $this->load->model('model_queryinventario');
        $this->load->model('Corrida_model');
        $this->load->database('default');
        $this->load->library(array('session','form_validation', 'get_menu', 'pdf'));
        $this->load->model('asesor/Asesor_model');
        $this->validateSession();
	}

	public function index()
	{
	}

	public function descuentos() {

		$objDatos = json_decode(file_get_contents("php://input"));
		$idLote = $objDatos->lote;
		/*print_r($idLote);
		exit;*/
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
		echo json_encode($paquetes, JSON_NUMERIC_CHECK);
	}



	public function cf(){
        //$this->load->view("corrida/cf_view");
        $this->load->view("corrida/cf_cxl");
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
		$arreglo['status'] = 0;
        $arreglo["corrida_dump"]= json_encode($objDatos->corrida_dump);
        $arreglo["tipo_casa"]= $objDatos->tipo_casa;



        $array_allPackages = json_decode($objDatos->allPackages);
        $arrayTocxp = array();



        $arrayDescApply = ($objDatos->descApply == null || $objDatos->descApply == 'undefined') ? array(): $objDatos->descApply;
        if(count($arrayDescApply)>0){
            foreach ($array_allPackages as $key => $value) { //recorre todos los paquetes
                $arrayTocxp[$key]['id_paquete'] = $value->id_paquete;

                foreach ($value->response as $key2 => $value2) { //recorre los descuentos dentro de los paquetes
                    $arrayTocxp[$key]['descuentos'][$key2]['prioridad'] = $value2->prioridad;
                    $arrayTocxp[$key]['descuentos'][$key2]['id_descuento'] = $value2->id_descuento;
                    //$arrayTocxp[$key]['descuentos'][$key2]['estatus'] =  0;


                    for ($i = 0; $i < count($arrayDescApply); $i++) {
                        if ($arrayDescApply[$i]->id_descuento == $value2->id_descuento && $arrayDescApply[$i]->id_paquete == $value->id_paquete) {
                            $arrayTocxp[$key]['descuentos'][$key2]['estatus'] = 1;
                        }

                    }

                }
            }


            foreach ($arrayTocxp as $key => $value) {
                foreach ($value['descuentos'] as $key2 => $value2) {
                    (empty($value2['estatus'])) ? $arrayTocxp[$key]['descuentos'][$key2]['estatus'] = 0 : $value2['estatus'];
                }
            }


            /*echo '<br><br>';
            print_r(json_encode($arrayTocxp));*/

        }



		
		$response = $this->Corrida_model->insertCf($arreglo);

        $data_tocxl = array(
            'detalle_paquete' => json_encode($arrayTocxp),
            'estatus' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'creado_por' => 1,
            'fecha_modificacion' => date('Y-m-d H:i:s'),
            'modificado_por' => 1,
            'id_corrida' => $response[0]['id_corrida']
        );

		if($response) {
			$this->Corrida_model->insertPreciosAll($objDatos->allDescuentos, $idLote, $response[0]['id_corrida']);
			$response['message'] = 'OK';
            $this->Corrida_model->insertCXL($data_tocxl);
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
    public function updateCorrida(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $id_corrida = $objDatos->id_corrida;
        $activo= $objDatos->status;
        $idLote=$objDatos->id_lote;

        /*echo 'id_corrida:<br>';
        print_r($objDatos->id_corrida);
        echo '<br><br>data a insertar:<br>';
        print_r($objDatos->data);*/

        #update el corrida dump, all lo que se piba en el corridas dump

        $response = $this->Corrida_model->updateCorridaDump($id_corrida, $objDatos->data);
        if($response==1){

            if($activo == 1){
                /*parte de la regeneració dle excel*/
                #solo con el estatus
                #Borra el expediente anterior
                $expediente = $this->Corrida_model->getExpedienteCorrida($idLote);
                $dir_expediente = $_SERVER['DOCUMENT_ROOT'].'sisfusion/static/documentos/cliente/corrida/';
                $exp_cf = $expediente->expediente;
                $req = delete_img($dir_expediente, $exp_cf);

                #Regenera el archivo de nuevo
                $resultado =  $this->excelFile($id_corrida);

                if($resultado['status'] == 1){
                    /*$data = $this->Corrida_model->actionMCorrida($id_corrida, $action);
                    //update rama de documentación
                    $response['message'] = ($data == 1) ? 'OK' : 'ERROR';*/
                    $data_documento_update = array(
                        'modificado' => date('Y-m-d H:i:s'),
                        'idUser' => $this->session->userdata('id_usuario'),
                        'expediente' => $resultado['corrida_generada']
                    );
                    $this->Corrida_model->updateExpCorr($idLote, $data_documento_update);


                    $response_msg['message'] = 'OK';
                    $response_msg['id_corrida'] = $id_corrida;
                    echo json_encode($response_msg);
                }else{
                    $response_msg['message'] = 'OK';
                    $response_msg['detail'] = 'Se guardo correctamente pero no se pudo regenerar el excel, intentalo de nuevo';
                    echo json_encode($response_msg);
                }
                /*finaliza parte de la regeneración del excel*/
            }
            else{
                $response_msg['message'] = 'OK';
                $response_msg['id_corrida'] = $id_corrida;
                echo json_encode($response_msg);

            }
            //$data['message'] = 'OK';
            //echo json_encode($data);
            //echo json_encode($response_msg);
        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }


    }
	public function caratula_mal(){
		setlocale(LC_MONETARY, 'en_US.UTF-8');

		$informacion_corrida = $this->Corrida_model->getinfoCorrida($this->uri->segment(3));
		$informacion_loteCorrida = $this->Corrida_model->getinfoLoteCorrida($informacion_corrida->row()->id_lote);
		$informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($informacion_corrida->row()->id_lote, $this->uri->segment(3));
		$informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->row()->id_asesor, $informacion_corrida->row()->id_gerente);

		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ciudad Maderas');
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
$pdf->SetAuthor('Ciudad Maderas');
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
        $pdf->SetAuthor('Ciudad Maderas');
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
		/*print_r($informacion_corrida);
		exit;*/
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
        $informacion_plan = json_decode($informacion_plan[0]['corrida_dump']);

		$informacion_diferidos = array_slice($informacion_plan, 0, $informacion_corrida->meses_diferir);




		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ciudad Maderas');
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
							   }else if($row['id_condicion'] == 12){
                                  $html .=' Bono descuento al m2 $'.$row['porcentaje'].'';
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
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.$row->fecha.'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.$row->pago.'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row->capital).'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row->interes).'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row->total).'</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">'.money_format('%(#10n',$row->saldo).'</td>
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
		$residenciales = $this->Corrida_model->getResidencialDis();
		if($residenciales != null) {
			echo json_encode($residenciales);
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
    /*COSAS DE LA CORRIDA Y DEL EXPORT DEL EXCEL*/
    public function excelFile($id_corrida){

	    /*echo 'Estoy creadno el excel';
	    exit;*/
//	    $id_corrida = 76515;
        $data_corrida = $this->Corrida_model->getAllInfoCorrida($id_corrida);
//        print_r($data_corrida);
        $residencial = $data_corrida->residencial;
//        exit;



	    /*print_r(__DIR__ . '/../static/images/logo_ciudadmaderasAct.jpg');
	    exit;*/

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        #imagen ciudad maderas
        // Add a drawing to the worksheet
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Ciudad Maderas');
        $drawing->setDescription('Ciudad Maderas');
        $drawing->setPath(__DIR__.'/../../static/images/logo_ciudadmaderasAct.jpg');
        $drawing->setHeight(100);
        $drawing->setCoordinates('C1');
        $drawing->setOffsetX(80);
        $drawing->setOffsetY(20);
        $drawing->setWorksheet($sheet);
        $sheet->getRowDimension('1')->setRowHeight(100);
        $sheet->setShowGridlines(false);

        //$sheet->setCellValue('C1', 'CIUDAD MADERAS');
        $range1 = 'C1';
        $range2 = 'I1';
        $sheet->mergeCells("$range1:$range2");
        $sheet->getStyle('C:I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C:I')->getAlignment()->setVertical('center');
        $sheet->getStyle("C1:I1")->getFont()->setSize(28);
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB('808080');

        $sheet->setCellValue('C2', $residencial);
        $range12 = 'C2';
        $range22 = 'I2';
        $sheet->mergeCells("$range12:$range22");
        $sheet->getStyle("C2:I2")->getFont()->setSize(26);
        $sheet->getStyle('C2')->getFont()->getColor()->setARGB('FFFFFF');
        $sheet->getStyle( 'C1:C2' )->getFont()->setName('Calibri');
        $sheet->getStyle('C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1F497D');



        $sheet->setCellValue('D4', 'Condominio');
        $sheet->setCellValue('E4', 'Lote');
        $sheet->setCellValue('F4', 'Superficie');
        $sheet->setCellValue('G4', 'Precio m2');
        $sheet->setCellValue('H4', 'Plazo');
        $sheet->setCellValue('I4', '10% precio m2');

        #set values
        $sheet->setCellValue('D5', $data_corrida->nombreCondominio);
        $sheet->setCellValue('E5', $data_corrida->id_lote);
        $sheet->setCellValue('F5', $data_corrida->superficie);
        $sheet->setCellValue('G5', $data_corrida->preciom2);
        $sheet->getStyle('G5')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->setCellValue('H5', ($data_corrida->finalMesesp1 + $data_corrida->finalMesesp2 + $data_corrida->finalMesesp3));
        $sheet->setCellValue('I5', $data_corrida->precio_m2_final);
        $sheet->getStyle('I5')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


        $sheet->getStyle("D4:I4")->getFont()->setSize(10);
        $sheet->getStyle('D4:I4')->getFont()->getColor()->setARGB('4472C4');
        $sheet->getStyle( 'D4:I4' )->getFont()->setBold( true );
        $sheet->getStyle( 'D4:I4' )->getFont()->setName('Arial');
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(14);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(15);

        $sheet->getStyle('D5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle('I5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');


        $sheet->setCellValue('E7', 'Costo Total:');
        $sheet->getStyle("E7")->getFont()->setSize(12);
        $sheet->getStyle( 'E7' )->getFont()->setBold( true );
        $sheet->getStyle('E7')->getFont()->getColor()->setARGB('4472C4');
        $sheet->getStyle( 'E7' )->getFont()->setName('Arial');

        $sheet->setCellValue('F7', $data_corrida->precioOriginal);
        $sheet->setCellValue('G7', $data_corrida->precio_final);
        $sheet->getStyle('F7:G7')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

        $sheet->getStyle("F7:G7")->getFont()->setSize(12);
        $sheet->getStyle( 'F7:G7' )->getFont()->setName('Arial');
        $sheet->setCellValue('H7', 'PRECIO REAL CON DESCUENTO');
        $sheet->getStyle('F7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle( 'F7:G7' )->getFont()->setBold( true );
        $sheet->getStyle('G7:H7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C6E0B4');
        $sheet->getStyle('H7')->getAlignment()->setHorizontal('bottom');
        $sheet->getStyle('H7')->getAlignment()->setVertical('');


        $sheet->setCellValue('D9', 'Enganche');
        $sheet->setCellValue('E9', $data_corrida->porcentaje_enganche.'%');
        $sheet->setCellValue('F9', $data_corrida->cantidad_enganche);
        $sheet->getStyle('F9:G9')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

        $sheet->getStyle( 'D9' )->getFont()->setBold( true );
        $sheet->getStyle( 'D9' )->getFont()->setName('Arial');
        $sheet->getStyle("D9")->getFont()->setSize(10);
        $sheet->getStyle('F9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle( 'F9:G9' )->getFont()->setBold( true );
        $sheet->getStyle( 'F9:G9' )->getFont()->setName('Arial');
        $sheet->getStyle("F9:G9")->getFont()->setSize(12);
        $sheet->getStyle('G9:H9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C6E0B4');
        $sheet->setCellValue('G9', $data_corrida->pago_enganche);
        $sheet->setCellValue('H9', 'ENGANCHE '.$data_corrida->porcentaje_enganche.'%');

        $sheet->setCellValue('E11', 'Saldo');
        $sheet->getStyle( 'E11' )->getFont()->setName('Arial');
        $sheet->getStyle( 'E11:F11' )->getFont()->setBold( true );
        $sheet->getStyle("E11")->getFont()->setSize(10);
        $sheet->getStyle("F11")->getFont()->setSize(12);
        $sheet->setCellValue('F11', $data_corrida->saldo);
        $sheet->getStyle( 'F11' )->getFont()->setName('Arial');
        $sheet->getStyle('F11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle('F11')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);



        $sheet->setCellValue('C13', 'Mensualidad sin/Int. ');
        $sheet->setCellValue('E13', $data_corrida->finalMesesp1);
        $sheet->setCellValue('F13', $data_corrida->msi_1p);
        $sheet->getStyle( 'C13:E13' )->getFont()->setBold( true );
        $sheet->getStyle('E13')->getFont()->getColor()->setARGB('FF003A');
        $sheet->getStyle('F13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle( 'C13:F13' )->getFont()->setName('Arial');
        $sheet->getStyle("C13")->getFont()->setSize(9);
        $sheet->getStyle('F13:F15')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


        $sheet->setCellValue('H13', '1er Mensualidad');
            $sheet->getStyle( 'H13:I13' )->getFont()->setName('Arial');
        $sheet->getStyle("H13:I13")->getFont()->setSize(10);
        $sheet->getStyle('I13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->setCellValue('I13', '=C20');

        $sheet->setCellValue('C14', 'Mensualidad Con/Int. SSI');
        $sheet->setCellValue('D14', '1.00%');
        $sheet->setCellValue('E14', $data_corrida->finalMesesp2);
        $sheet->setCellValue('F14', $data_corrida->msi_2p);
        $sheet->getStyle( 'C14:E14' )->getFont()->setBold( true );
        $sheet->getStyle('E14')->getFont()->getColor()->setARGB('FF003A');
        $sheet->getStyle('F14')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle( 'C14:F14' )->getFont()->setName('Arial');
        $sheet->getStyle("C14")->getFont()->setSize(9);


        $sheet->setCellValue('C15', 'Mensualidad Con/Int. SSI ');
        $sheet->setCellValue('D15', '1.25%');
        $sheet->setCellValue('E15', $data_corrida->finalMesesp3);
        $sheet->setCellValue('F15', $data_corrida->msi_3p);
        $sheet->getStyle( 'C15:E15' )->getFont()->setBold( true );
        $sheet->getStyle('E15')->getFont()->getColor()->setARGB('FF003A');
        $sheet->getStyle('F15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle( 'C15:F15' )->getFont()->setName('Arial');
        $sheet->getStyle("C15")->getFont()->setSize(9);


        $sheet->setCellValue('H17', 'Tasa Anual');
        $sheet->getStyle( 'H17:I17' )->getFont()->setBold( true );
        $sheet->getStyle( 'H17:I17' )->getFont()->setName('Arial');
        $sheet->getStyle("H17:I17")->getFont()->setSize(10);
        $sheet->getStyle('H17')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H17')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H17')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('I17', '12.0%');
        $sheet->getStyle('I17')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I17')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I17')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->setCellValue('H18', 'Tasa Anual');
        $sheet->getStyle( 'H18:I18' )->getFont()->setBold( true );
        $sheet->getStyle( 'H18:I18' )->getFont()->setName('Arial');
        $sheet->getStyle("H18:I18")->getFont()->setSize(10);
        $sheet->getStyle('H18')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H18')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H18')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('I18', '15.0%');
        $sheet->getStyle('I18')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I18')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('I18')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        /*encabezados de la tabla*/
        $sheet->setCellValue('C19', 'FECHAS');
        $sheet->setCellValue('D19', 'MES');
        $sheet->setCellValue('E19', 'CAPITAL');
        $sheet->setCellValue('F19', 'INTERESES');
        $sheet->setCellValue('G19', 'PAGO');
        $sheet->setCellValue('H19', 'SALDO');
        $sheet->setCellValue('I19', 'ESQUEMA');
        $sheet->getStyle( 'C19:I19' )->getFont()->setBold( true );
        $sheet->getStyle('C19:I19')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle('C19:I19')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        $array_dump = $data_corrida->corrida_dump;
        $array_dump = json_decode(($array_dump));
        $total_array = count($array_dump);
        $i = 19;
        foreach($array_dump as $item=>$value){
            $i++;
            //echo $i;

            #fecha
            $sheet->setCellValue('C'.$i, $value->fecha);
            $sheet->getStyle('C'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #mes
            $sheet->setCellValue('D'.$i, $value->pago);
            $sheet->getStyle('D'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #capital
            $sheet->setCellValue('E'.$i, $value->capital);
            $sheet->getStyle('E'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('E'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


            #intereses
            $sheet->setCellValue('F'.$i, $value->interes);
            $sheet->getStyle('F'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


            #pago
            $sheet->setCellValue('G'.$i, ($value->total));
            $sheet->getStyle('G'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('G'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


            #saldo
            //$var = ($total_array == $value->pago) ? $array_dump[$item]  : '';
            $var = ($total_array == $value->pago) ? ($array_dump[$item-1]->saldo - $value->total): $value->saldo;
            $var = ($var < 0) ? 0 : $var;
            $sheet->setCellValue('H'.$i, $var);
            $sheet->getStyle('H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('H'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            #esquema
            if( ($item >= 0) && ($item <  $data_corrida->finalMesesp1) ) {
                $esquema = 1;
            } else if( ($item >= $data_corrida->finalMesesp1) && ($item <  $data_corrida->finalMesesp2) ){
                $esquema = 2;
            }else if( ($item >= $data_corrida->finalMesesp2) && ($item <  $total_array) ){
                $esquema = 3;
            }else{
                $esquema = 'NA';
            }
            $sheet->setCellValue('I'.$i, $esquema);
            $sheet->getStyle('I'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        }

//        exit;

        #CMML_KAN100_11022021_40513_247_KANJIROBA-100.xlsx
        $resName = $data_corrida->nombreResidencial;
        $cond3Letras = substr($data_corrida->nombreCondominio, 0, 3);
        $numberLote = substr($data_corrida->nombreLote, -3);
        $date_file = date('dmYhis');
        $id_lote = $data_corrida->id_lote;
        $idCliente = $data_corrida->idCliente;
        $randNumber = rand(3, 999);

        $nombre_archivo = $resName.'_'.$cond3Letras.$numberLote.'_'.$date_file.'_'.$idCliente.'_'.$randNumber.'.xlsx';

        $dir_2 = $_SERVER['DOCUMENT_ROOT'].'sisfusion/static/documentos/cliente/corrida/'.$nombre_archivo;
        $dir_2 = str_replace("\ ", '/', $dir_2);

        $writer = new Xlsx($spreadsheet);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $nombre_archivo .'"');
        header('Cache-Control: max-age=0');

        //$writer->save('php://output');// download file
        $writer->save($dir_2);
        $data_response = array(
            'message' => 'Corrida generada en excel correctamente',
            'status' => 1,
            'corrida_generada' => $nombre_archivo
        );
        return $data_response;
    }
    function listado_cf(){
        //print_r(phpversion());
        //exit;
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        //$datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');

        $this->load->view("corrida/corridas_generadas", $datos);
    }
    function editacf($id_corrida){
        $data_corrida = array(
            "id_corrida" => $id_corrida,
            "nombre" => 'LOTE TEST'
        );
        $data_corrida['data_corrida'] = $this -> Corrida_model -> getInfoCorridaByID($id_corrida);

        $this->load->view("corrida/editar_corrida", $data_corrida);
    }
    function update_financialR(){

        $objDatos = json_decode(file_get_contents("php://input"));

        $id_corrida = (int)$objDatos->id_corrida;
        $idLote = (int)$objDatos->id_lote;
        $id_asesor = (int)$objDatos->asesor;
        $id_gerente = (int)$objDatos->gerente;
        $cantidad_enganche = (int)$objDatos->cantidad_enganche;
        $paquete = $objDatos->paquete;
        $activo = $objDatos->status;



        $datos_arreglo = array(
            "idLote" => $idLote,
            "idAsesor" => $id_asesor,
            "idGerente" => $id_gerente,
            "cantidadEnganche" => $cantidad_enganche,
            "paquete" => $paquete
        );


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
        $arreglo["apartado"]= ($objDatos->apartado == '') ? 0 : $objDatos->apartado;
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



        /*print_r($arreglo["telefono"]);
        exit;*/

        $array_allPackages = json_decode($objDatos->allPackages);
        $arrayTocxp = array();





        $arrayDescApply = ($objDatos->descApply == null || $objDatos->descApply == 'undefined') ? array(): $objDatos->descApply;
        if(count($arrayDescApply)>0){
            foreach ($array_allPackages as $key => $value) { //recorre todos los paquetes
                $arrayTocxp[$key]['id_paquete'] = $value->id_paquete;

                foreach ($value->response as $key2 => $value2) { //recorre los descuentos dentro de los paquetes
                    $arrayTocxp[$key]['descuentos'][$key2]['prioridad'] = $value2->prioridad;
                    $arrayTocxp[$key]['descuentos'][$key2]['id_descuento'] = $value2->id_descuento;
                    //$arrayTocxp[$key]['descuentos'][$key2]['estatus'] =  0;


                    for ($i = 0; $i < count($arrayDescApply); $i++) {
                        if ($arrayDescApply[$i]->id_descuento == $value2->id_descuento && $arrayDescApply[$i]->id_paquete == $value->id_paquete) {
                            $arrayTocxp[$key]['descuentos'][$key2]['estatus'] = 1;
                        }

                    }

                }
            }


            foreach ($arrayTocxp as $key => $value) {
                foreach ($value['descuentos'] as $key2 => $value2) {
                    (empty($value2['estatus'])) ? $arrayTocxp[$key]['descuentos'][$key2]['estatus'] = 0 : $value2['estatus'];
                }
            }



            //print_r(json_encode($arrayTocxp));

        }








        /* echo 'Arreglo: <br>';
         print_r($arreglo);
         echo '<br><br> id_lote: '.$idLote.' <br><br>';
         echo 'id_corrida: '.$id_corrida.' <br><br>';
         echo '<br><br>allDescuentos: <br>';
         print_r($objDatos->allDescuentos);
         echo '<br><br>descuento cxl: <br>';
         print_r($arrayTocxp);
         echo '<br><br>';

         if(count($objDatos->allDescuentos) > 0){
             echo 'Se va actualizar All descuentos';
         }else{
             echo 'No hay nada xd';
         }


         exit;*/





        $response = $this->Corrida_model->updateCF($id_corrida, $arreglo);
        $respuesta = $this->Corrida_model->update_cxl($arrayTocxp, $id_corrida);
        //$response = 1;
        if($response == 1 && $respuesta==1) {
            $this->Corrida_model->updatePreciosAll($objDatos->allDescuentos, $idLote, $id_corrida);


                $response_msg['message'] = 'OK';
                $response_msg['id_corrida'] = $id_corrida;
                echo json_encode($response_msg);
        }
        else {
            $response_msg['message'] = 'ERROR';
            echo json_encode($response_msg);
        }





        /*MAKE NEXT STEPS*/
        /*$response = $this->Corrida_model->insertCf($arreglo);

        if($response) {
            $this->Corrida_model->insertPreciosAll($objDatos->allDescuentos, $idLote, $response[0]['id_corrida']);
            $response['message'] = 'OK';
            echo json_encode($response);
        }else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }*/

    }
    /*mariachoise*/
    public function getPaquetesByCondominio()
    {
        $time = time();
        $object = json_decode(file_get_contents("php://input"));


        if(!isset($object->id_condominio))
            echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Condominium id is a required parameter to make this request.", "message" => "Verify that the parameter is specified."));
        else if($object->id_condominio == '' || $object->id_condominio == null || $object->id_condominio == 'undefined')
            echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Some parameter does not have a specified value.", "message" => "Verify that all parameters contain a specified value."));
        else {
//            print_r($object->id_condominio);
//            echo '<br>';
//            print_r($object->id_corrida);
//            exit;
            $data = $this->Corrida_model->getPaquetesByCondominio($object->id_condominio, $object->id_corrida)->result_array();
            if (count($data) > 0){
                $array_descuentos = $data;
                $array_validado = array();
                /*hacer la validación para traer solo los ultimos 2 meses de descuentos*/
                foreach ($array_descuentos as $descuento){
                    $d1 = strtotime($descuento['fecha_creacion']);
                    $d2 = strtotime($descuento['fecha_inicio']);
                    $min_date = min($d1, $d2);
                    $max_date = max($d1, $d2);
                    $i = 0;
                    while (($min_date = strtotime("+2 MONTH", $min_date)) <= $max_date) {
                        $i++;
                    }
                    if($i<=2){
                        array_push($array_validado, $descuento);
                    }
                };
                //print_r($array_validado);
                echo json_encode($array_validado);

            }
            else{
                echo json_encode(array("status" => 200, "message" => "No information to display."));
            }
        }
    }
    public function descuentosCCF() {

        $objDatos = json_decode(file_get_contents("php://input"));
        $id_cxl = $objDatos->id_cxl;
        $data_back = $this->Corrida_model->getcxl($id_cxl);
        $paquetes_data= json_decode(str_replace("'", '"', $data_back->detalle_paquete));
        /*echo 'Paquetes al momento: <br>';
        print_r(count($paquetes_data));
        exit;*/
        $paquete_view = array();

        if($paquetes_data!=''){
            for( $i = 0; $i < count($paquetes_data); $i++ ){
                //echo 'id_paquete: <br>';
                //print_r($paquetes_data[$i]->id_paquete);
                //echo '<br>';
                $paquete_info = $this->Corrida_model->getPaqById($paquetes_data[$i]->id_paquete);
                $paquete_view[$i] = array(
                    'id_paquete' => $paquete_info->id_paquete,
                    'descripcion' => $paquete_info->descripcion,
                    /*'fecha_inicio' => $paquete_info->fecha_inicio,
                    'fecha_fin' => $paquete_info->fecha_fin,
                    'estatus' => $paquete_info->fecha_fin,
                    'sede' => $paquete_info->fecha_fin,*/
                );
                //print_r($paquete_view);
                //echo '<br><br>';


                for( $c = 0; $c < count($paquetes_data[$i]->descuentos); $c++ ){

                    //echo 'Descuento:<br>';
                    //print_r($paquetes_data[$i]->descuentos[$c]->id_descuento);
                    $data_descuento = $this->Corrida_model->getDescById($paquetes_data[$i]->descuentos[$c]->id_descuento);
                    //print_r($data_descuento);
                    //echo '<br>';
                    $paquete_view[$i]['response'][$c]['id_descuento'] = $data_descuento->id_descuento;
                    $paquete_view[$i]['response'][$c]['id_tdescuento'] = $data_descuento->id_tdescuento;
                    $paquete_view[$i]['response'][$c]['inicio'] = $data_descuento->inicio;
                    $paquete_view[$i]['response'][$c]['fin'] = $data_descuento->fin;
                    $paquete_view[$i]['response'][$c]['id_condicion'] = $data_descuento->id_condicion;
                    $paquete_view[$i]['response'][$c]['porcentaje'] = (int)$data_descuento->porcentaje;
                    $paquete_view[$i]['response'][$c]['eng_top'] = $data_descuento->eng_top;
                    $paquete_view[$i]['response'][$c]['apply'] = $data_descuento->apply;
                    $paquete_view[$i]['response'][$c]['leyenda'] = $data_descuento->leyenda;
                    $paquete_view[$i]['response'][$c]['prioridad'] = $data_descuento->prioridad;
                    //$paquete_view[$i]['response'][$c]['estatus'] = str_replace('"', '', $paquetes_data[$i]->descuentos[$c]->estatus);
                    $paquete_view[$i]['response'][$c]['estatus'] = $paquetes_data[$i]->descuentos[$c]->estatus;
                    $paquete_view[$i]['response'][$c]['id_paquete'] = $paquetes_data[$i]->id_paquete;
                    $paquete_view[$i]['response'][$c]['msi_descuento'] = (int) $data_descuento->msi_descuento;
                }
            }
        }else{
            $paquete_view = array();
        }

        print_r(json_encode($paquete_view));


        //print_r(json_decode(str_replace("'", '"', $data_back->detalle_paquete)));



        /*$idLote = $objDatos->lote;
        $paquetes = $this->Corrida_model->getPaquetes($idLote);
        print_r($paquetes);
        exit;
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

        echo json_encode($paquetes);*/
    }
    function getDescsByCondominio(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $id_condominio = $objDatos->id_condominio;
        $id_pxc = $objDatos->id_pxc;
        $data_descuentos = $this->Corrida_model->getDescsByCondominio($id_condominio, $id_pxc);


        $array_descuentos = explode(',', $data_descuentos->id_paquete, 999);

        $data_descuentos->paquetes_array = $array_descuentos;

//        print_r($array_descuentos);


        for($i=0; $i<count($array_descuentos); $i++){
            $paquete_info = $this->Corrida_model->getPaqById($array_descuentos[$i]);
            $paquete_view[$i] = array(
                'id_paquete' => $paquete_info->id_paquete,
                'descripcion' => $paquete_info->descripcion,
                //'estatus' => $paquete_info->estatus,
            );

            $data_desc_paq = $this->Corrida_model->getRelDescByIdPq($paquete_info->id_paquete);
            for($q = 0; $q<count($data_desc_paq); $q++){
                $data_descuento = $this->Corrida_model->getDescById($data_desc_paq[$q]['id_descuento']);
                $paquete_view[$i]['response'][$q]['id_descuento'] = $data_descuento->id_descuento;
                $paquete_view[$i]['response'][$q]['id_tdescuento'] = $data_descuento->id_tdescuento;
                $paquete_view[$i]['response'][$q]['inicio'] = $data_descuento->inicio;
                $paquete_view[$i]['response'][$q]['fin'] = $data_descuento->fin;
                $paquete_view[$i]['response'][$q]['id_condicion'] = $data_descuento->id_condicion;
                $paquete_view[$i]['response'][$q]['porcentaje'] = (int)$data_descuento->porcentaje;
                $paquete_view[$i]['response'][$q]['eng_top'] = $data_descuento->eng_top;
                $paquete_view[$i]['response'][$q]['apply'] = $data_descuento->apply;
                $paquete_view[$i]['response'][$q]['leyenda'] = $data_descuento->leyenda;
                $paquete_view[$i]['response'][$q]['prioridad'] = $data_descuento->prioridad;
                $paquete_view[$i]['response'][$q]['estatus'] = 0;
                $paquete_view[$i]['response'][$q]['id_paquete'] = $paquete_info->id_paquete;
                $paquete_view[$i]['response'][$q]['msi_descuento'] = (int)$data_descuento->msi_descuento;
            }
        }
        print_r(json_encode($paquete_view));

        exit;
    }
    function getLotesWCF($condominio,$residencial)
    {
        $data['lotes'] = $this->Corrida_model->getLotesAsesor($condominio, $residencial);
        //$data2 = array();
        if(count($data['lotes'])<=0)
        {
            $data['lotes'][0]['idLote'] = 0;
            $data['lotes'][0]['nombreLote'] = 'SIN CORRIDAS PARA ESTE LOTE';
            echo json_encode($data['lotes']);
        }
        else{
            echo json_encode($data['lotes']);
        }
    }
    function getCorridasByLote($idLote){
        $data_lotes = $this->Corrida_model->getCorridasByLote($idLote);
        if($data_lotes != null) {
            echo json_encode($data_lotes);
        } else {
            echo json_encode(array());
        }


    }
    function actionMCorrida($id_corrida, $action){
        $id_lote = $this->input->post('idLote');
        $data_documento_update = array();
        if($action == 1){
            $resultado =  $this->excelFile($id_corrida);

            if($resultado['status'] == 1){
                $data = $this->Corrida_model->actionMCorrida($id_corrida, $action);
                //update rama de documentación
                $response['message'] = ($data == 1) ? 'OK' : 'ERROR';
            }else{
                $response['message'] = 'ERROR';
            }

            $data_documento_update = array(
                'modificado' => date('Y-m-d H:i:s'),
                'idUser' => $this->session->userdata('id_usuario'),
                'expediente' => $resultado['corrida_generada']
            );
        }else{
            $expediente = $this->Corrida_model->getExpedienteCorrida($id_lote);
            $dir_expediente = $_SERVER['DOCUMENT_ROOT'].'sisfusion/static/documentos/cliente/corrida/';
            $exp_cf = $expediente->expediente;
            $req = delete_img($dir_expediente, $exp_cf);
            /*print_r($expediente);
            echo '<br>';
            print_r($expediente->expediente);
            echo '<br>';


            print_r($dir_expediente);
            exit;*/
            $data = $this->Corrida_model->actionMCorrida($id_corrida, $action);
            $response['message'] = ($data == 1) ? 'OK' : 'ERROR';

            $data_documento_update = array(
                'modificado' => date('Y-m-d H:i:s'),
                'idUser' => $this->session->userdata('id_usuario'),
                'expediente' => NULL
            );
        }

        $this->Corrida_model->updateExpCorr($id_lote, $data_documento_update);


        if($response != null) {
            echo json_encode($response);
        } else {
            echo json_encode(array());
        }
    }
    function checCFActived($idLote){
        $data = $this->Corrida_model->checCFActived($idLote);
        $response['message'] = count($data);
        if($response != null) {
            echo json_encode($response);
        } else {
            echo json_encode(array());
        }
    }


    #Traer costos de las casas de ciudad mederas
    function getInfoCasasRes(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $idLote = $objDatos->idLote;
        $data_casas = $this->Corrida_model->getInfoCasasRes($idLote);
        //$casas = json_decode(str_replace('"', '', $data_casas->tipo_casa));
        $casas = str_replace("'tipo_casa':", '', $data_casas->tipo_casa);
        $casas = str_replace('"', '', $casas );
        $casas = str_replace("'", '"', $casas );

        print_r($casas);
        exit;


        $response = $casas;
        if($response != null) {
            echo json_encode($response);
        } else {
            echo json_encode(array());
        }
    }

}