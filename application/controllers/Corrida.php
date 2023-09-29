<?php
//    require_once 'static/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Corrida extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model(array('registrolote_modelo', 'General_model'));
        $this->load->model('model_queryinventario');
        $this->load->model('Corrida_model');
        $this->load->database('default');
        $this->load->library(array('session','form_validation', 'get_menu', 'pdf','permisos_sidebar'));
        $this->load->model('asesor/Asesor_model');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
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
		echo json_encode($paquetes, JSON_NUMERIC_CHECK);
	}



	public function cf(){
        $this->load->view("corrida/cf_cxl");
	}

	public function cf2(){
		$this->load->view("corrida/cf_view2");
	}
    public function pagos_capital(){
        $this->load->view("corrida/pagos_capital");
    }

	public function cf3(){
		$this->load->view("corrida/cf_view_PAC");
	}
	public function cf_testing(){
        $this->load->view("corrida/cf_cambios");

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
//        echo '$objDatos';
//        print_r($objDatos);
//        exit;


		$idLote = (int)$objDatos->id_lote;
		$id_asesor = ($objDatos->asesor!='')?(int)$objDatos->asesor : $objDatos->asesor;
		$id_gerente = (int)$objDatos->gerente;
		$id_coordinador = (int)$objDatos->coordinador;
		$cantidad_enganche = (int)$objDatos->cantidad_enganche;
		$paquete = (int)$objDatos->paquete;

//		echo 'Asesor';
//		print_r($id_asesor);
//		echo '<br>Coordinador<br>';
//        print_r($id_coordinador);
//        echo '<br>Gerente<br>';
//        print_r($objDatos->telefono);
//        exit;

		$arreglo =array();
		$arreglo["nombre"]= $objDatos->nombre;
		$arreglo["id_lote"]= $idLote;
		$arreglo["edad"]= $objDatos->edad;
		$arreglo["telefono"]= $objDatos->telefono;
		$arreglo["correo"]= $objDatos->correo;
		$arreglo["id_asesor"]= $id_asesor;
		$arreglo["id_coordinador"] = $id_coordinador;
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
        $arreglo["id_cliente"]= $objDatos->id_cliente;
        $arreglo["created_by"]= $this->session->userdata('id_usuario');
        //generar rama para subir la autorizacion de fecha inicio mensualidad
        $tipoIM = $objDatos->tipoIM;
        $arreglo["tipoPM"] = $tipoIM;
        $arreglo["fechaInicioPM"] = $objDatos->customDate;
//        $arreglo["fechaApartado"] = (isset($objDatos->fechaApartado)) ? $objDatos->customDate : $objDatos->fechaApartado;
        $clienteID = ($objDatos->id_cliente!=null || $objDatos->id_cliente!='') ?  $objDatos->id_cliente: 0;

        if($tipoIM == 3 && $clienteID>0){
            $verifica = $this->Corrida_model->revisaFIFCDOC($idLote,  $objDatos->id_cliente);
            if(count($verifica) == 0){
                $data_insert = array(
                    'movimiento' => 'AUTORIZACIÓN CAMBIO FECHA CF',
                    'expediente' => null,
                    'modificado' => date('Y-m-d H:i:s'),
                    'status'     => 1,
                    'idCliente'  => $objDatos->id_cliente,
                    'idCondominio' => $objDatos->condominio,
                    'idLote' => $idLote,
                    'idUser' => $this->session->userdata('id_usuario'),
                    'tipo_documento' => 0,
                    'id_autorizacion' => 0,
                    'tipo_doc' => 31,
                    'estatus_validacion' => 0
                );

                $this->General_model->addRecord('historial_documento', $data_insert);
            }
        }
        /*
        echo 'asesor:<br>';
        print_r($id_asesor);
        echo '<br>coordinador:<br>';
        print_r($id_coordinador);
        echo '<br>gerente:<br>';
        print_r($id_gerente);
        echo '<br>arreglo update:<br>';
        print_r($arreglo);
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




        }


        /*echo '<br><br>';
        print_r(json_encode($arrayTocxp));
        exit;*/



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
        #console.log();
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

		/*$getRol = $this->Corrida_model->getRol($informacion_corrida->id_asesor);


			if($getRol->id_rol == 7) { // IS ASESOR
				$informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			} else if($getRol->id_rol == 9) { // IS COORDINADOR
				$informacion_vendedor = $this->Corrida_model->getCoordCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			} else { // IS GERENTE
				$informacion_vendedor = $this->Corrida_model->getGerenteCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
			}*/

		$informacion_plan = $this->Corrida_model->getPlanCorrida($this->uri->segment(3));
		$informacion_diferidos = array_slice($informacion_plan, 0, $informacion_corrida->meses_diferir);

        if($informacion_corrida->id_asesor!=0){
            $data_asesor = $this->Corrida_model->getDataAsesorToPR($informacion_corrida->id_asesor);
        }
        if($informacion_corrida->id_coordinador!=0){
            $data_coord = $this->Corrida_model->getDataCoordToPR($informacion_corrida->id_coordinador);
        }
        if($informacion_corrida->id_gerente!=0){
            $data_gerente = $this->Corrida_model->getDataGerToPR($informacion_corrida->id_gerente);
        }
//        echo 'asesor:<br>';
//        print_r($data_asesor);
//        echo '<br>';
//        echo ' coordinador:<br>';
//        print_r($data_coord);
//        echo '<br>';
//        echo 'gerente:<br>';
//        print_r($data_gerente);
//        echo '<br>';
        $informacion_vendedor = array(
            "idAsesor" => ($data_asesor->idAsesor=="")?'NA':$data_asesor->idAsesor,
            "nombreAsesor" => ($data_asesor->nombreAsesor=="")?'NA':$data_asesor->nombreAsesor,
            "idCoordinador" => ($data_coord->idCoordinador=="")?'NA':$data_coord->idCoordinador,
            "nombreCoordinador" => ($data_coord->nombreCoordinador=="")?'NA':$data_coord->nombreCoordinador,
            "idGerente" => ($data_gerente->idGerente=="")?'NA':$data_gerente->idGerente,
            "nombreGerente" => ($data_gerente->nombreGerente=="")?'NA':$data_gerente->nombreGerente
        );
        $informacion_vendedor = (object) $informacion_vendedor;



//        print_r($informacion_vendedor);
//        exit;


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
    background-color: #103f75;
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
							<td colspan="2" align="left"><img src="https://maderascrm.gphsis.com/static/images/logo_ciudadmaderasAct.jpg" style=" max-width: 70%; height: auto;"></td>
							<td colspan="2" align="right"><b style="font-size: 3em; "> CORRIDA FINANCIERA<BR></b><small style="font-size: 2.5em; color: #777;"> </small> 
							</td>
						</tr>
					</table>
					
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Información general</b>
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
								<b>Precio m2:</b> '.$this->money_format('%(#10n',$informacion_loteCorrida->precio).' 
								</td> 
								<td style="font-size: 1.4em;">
								<b>Total:</b> '.$this->money_format('%(#10n',$informacion_loteCorrida->total).'
								</td>
								<td style="font-size: 1.4em;">
								<b>Porcentaje:</b> '.$informacion_loteCorrida->porcentaje.'%
								</td>
							
								<td style="font-size: 1.4em;">
								<b>Enganche:</b> '.$this->money_format('%(#10n',$informacion_loteCorrida->enganche).'
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
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Descuentos</b>
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
                              if ($row['id_condicion'] == 12){
                                  $html .='Bono ('.money_format('%(#10n',$row['porcentaje']).') de descuento al m2';
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
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche diferido</b>
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
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche y mensualidades</b>
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
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos Bancarios</b>
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

    public function caratulacf()
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');

        $informacion_corrida = $this->Corrida_model->getinfoCorrida($this->uri->segment(3));
        /*print_r($informacion_corrida);
        exit;*/
        $informacion_loteCorrida = $this->Corrida_model->getinfoLoteCorrida($informacion_corrida->id_lote);
        $informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($informacion_corrida->id_lote, $this->uri->segment(3));

        /*$getRol = $this->Corrida_model->getRol($informacion_corrida->id_asesor);


        if ($getRol->id_rol == 7) { // IS ASESOR
            $informacion_vendedor = $this->Corrida_model->getAsesorCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
        } else if ($getRol->id_rol == 9) { // IS COORDINADOR
            $informacion_vendedor = $this->Corrida_model->getCoordCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
        } else { // IS GERENTE
            $informacion_vendedor = $this->Corrida_model->getGerenteCorrida($informacion_corrida->id_asesor, $informacion_corrida->id_gerente);
        }*/

        if ($informacion_corrida->id_asesor != 0) {
            $data_asesor = $this->Corrida_model->getDataAsesorToPR($informacion_corrida->id_asesor);
        }
        if ($informacion_corrida->id_coordinador != 0) {
            $data_coord = $this->Corrida_model->getDataCoordToPR($informacion_corrida->id_coordinador);
        }
        if ($informacion_corrida->id_gerente != 0) {
            $data_gerente = $this->Corrida_model->getDataGerToPR($informacion_corrida->id_gerente);
        }
//        echo 'asesor:<br>';
//        print_r($data_asesor);
//        echo '<br>';
//        echo ' coordinador:<br>';
//        print_r($data_coord);
//        echo '<br>';
//        echo 'gerente:<br>';
//        print_r($data_gerente);
//        echo '<br>';
        $informacion_vendedor = array(
            "idAsesor" => ($data_asesor->idAsesor == "") ? 'NA' : $data_asesor->idAsesor,
            "nombreAsesor" => ($data_asesor->nombreAsesor == "") ? 'NA' : $data_asesor->nombreAsesor,
            "idCoordinador" => ($data_coord->idCoordinador == "") ? 'NA' : $data_coord->idCoordinador,
            "nombreCoordinador" => ($data_coord->nombreCoordinador == "") ? 'NA' : $data_coord->nombreCoordinador,
            "idGerente" => ($data_gerente->idGerente == "") ? 'NA' : $data_gerente->idGerente,
            "nombreGerente" => ($data_gerente->nombreGerente == "") ? 'NA' : $data_gerente->nombreGerente
        );
        $informacion_vendedor = (object)$informacion_vendedor;

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
							<td colspan="2" align="left"><img src="https://maderascrm.gphsis.com/static/images/logo_ciudadmaderasAct.jpg" style=" max-width: 70%; height: auto;"></td>
							<td colspan="2" align="right"><b style="font-size: 3em; "> CORRIDA FINANCIERA<BR></b><small style="font-size: 2.5em; color: #777;"></small> 
							</td>
						</tr>
					</table>
					
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Información general</b>
							</td>
						</tr>
					</table>							
					<br>


						<div class="row">
	
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
                             	<b>Nombre:</b> ' . $informacion_corrida->nombre . ' 
								</td>
								<td style="font-size: 1.4em;">
								<b>Edad:</b> ' . $informacion_corrida->edad . '
								</td> 
								<td style="font-size: 1.4em;">
								<b>Teléfono:</b> ' . $informacion_corrida->telefono . '
								</td>
								<td style="font-size: 1.4em;">
								<b>Email:</b> ' . $informacion_corrida->correo . '
								</td>
							</tr>
						</table>
                        <br>
                        <br>
                        <br>




                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								<b>Gerente:</b> ' . $informacion_vendedor->nombreGerente . '
								</td>
								<td style="font-size: 1.4em;">
								<b>Asesor:</b> ' . $informacion_vendedor->nombreAsesor . '
								</td>			
							</tr>
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
						    	<b>Proyecto:</b> ' . $informacion_loteCorrida->nombreResidencial . '
								</td>
								<td style="font-size: 1.4em;">
								<b>Condominio:</b> ' . $informacion_loteCorrida->nombreCondominio . '
								</td> 
								<td style="font-size: 1.4em;">
								<b>Lote:</b> ' . $informacion_loteCorrida->nombreLote . '
								</td>
								<td style="font-size: 1.4em;">
								<b>Plan:</b> ' . $informacion_corrida->plan_corrida . '
								</td>
								<td style="font-size: 1.4em;">
								<b>Años:</b> ' . $informacion_corrida->anio . '
								</td>
							</tr>							
					  </table>
					  
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
							<tr>
								<td style="font-size: 1.4em;">
								<b>Superficie:</b> ' . $informacion_loteCorrida->sup . 'm<sup>2</sup>
								</td>
								<td style="font-size: 1.4em;">
								<b>Precio m2:</b> ' . money_format('%(#10n', $informacion_loteCorrida->precio) . ' 
								</td> 
								<td style="font-size: 1.4em;">
								<b>Total:</b> ' . money_format('%(#10n', $informacion_loteCorrida->total) . '
								</td>
								<td style="font-size: 1.4em;">
								<b>Porcentaje:</b> ' . $informacion_loteCorrida->porcentaje . '%
								</td>
							
								<td style="font-size: 1.4em;">
								<b>Enganche:</b> ' . money_format('%(#10n', $informacion_loteCorrida->enganche) . '
								</td>
							</tr>		
					  </table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd; text-align: left;" width="690">
						  <tr>		
								<td style="font-size: 1.4em;">
								<b>Días para pagar Enganche:</b> ' . $informacion_corrida->dias_pagar_enganche . '
						    	</td>
								<td style="font-size: 1.4em;">
								<b>Enganche (%):</b> ' . $informacion_corrida->porcentaje_enganche . '%
						    	</td>
								<td style="font-size: 1.4em;">
                        		<b>Enganche cantidad ($):</b> ' . money_format('%(#10n', $informacion_corrida->cantidad_enganche) . '
						    	</td>							
								<td style="font-size: 1.4em;">
								<b>Apartado ($):</b> ' . money_format('%(#10n', $informacion_corrida->apartado) . '
						    	</td>
								<td style="font-size: 1.4em;">
								<b>Meses a diferir:</b> ' . $informacion_corrida->meses_diferir . '
							    </td>
						 </tr>		
					  </table>
			
                        <br>
                        <br>
                        <br>
                        
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Descuentos</b>
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

        foreach ($informacion_descCorrida as $row) {
            $html .= '
                              <tr align="center">
							  <td style="color:#27AE60; font-size: 1.4em;"><b>';

            if ($row['id_condicion'] == 1 || $row['id_condicion'] == 2) {
                $html .= '
							   ' . $row['porcentaje'] . '%
                              ';
            } else if ($row['id_condicion'] == 12) {
                $html .= ' Bono descuento al m2 $' . $row['porcentaje'] . '';
            }


            if ($row['id_condicion'] == 3 || $row['id_condicion'] == 4) {
                $html .= ' ' . money_format('%(#10n', $row['porcentaje']) . ' ';
            }

            if ($row['id_condicion'] == 6) {
                $html .= ' MENSUALIDAD JULIO';
            }

            if ($row['id_condicion'] == 7) {
                $html .= 'Enganche diferido sin descontar MSI';
            }
            if ($row['id_condicion'] == 12) {
                $html .= 'Bono (' . money_format('%(#10n', $row['porcentaje']) . ') de descuento al m2';
            }


            $html .= '</b></td>
							  <td style="color:#2E86C1; font-size: 1.4em;"><b> ' . money_format('%(#10n', $row['pm']) . ' </b></td>
							  <td style="color:#2E86C1; font-size: 1.4em;"><b> ' . money_format('%(#10n', $row['pt']) . ' </b></td>
							  <td style="color:#27AE60; font-size: 1.4em;"><b> ' . money_format('%(#10n', $row['ahorro']) . ' </b></td>
                              </tr>';
        }

        $html .= '</table>
                        
                        <br>
                        <br>
                        <br>
                        
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche diferido</b>
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

        foreach ($informacion_diferidos as $row) {
            $html .= '
                              <tr align="center">
							  <td style="font-size: 1.4em;">' . $row['fecha'] . '</td>
							  <td style="font-size: 1.4em;">' . $row['pago'] . '</td>
							  <td style="font-size: 1.4em;">' . money_format('%(#10n', $row['total']) . '</td>
                              </tr>';
        }

        $html .= '</table>
                        
                        <br>
                        <br>
                        <br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">

		
							<tr align="center">
								<td>
								<b style="font-size:10px">Saldo </b><br>
								<label style="font-size:10px">' . money_format('%(#10n', $informacion_corrida->saldo) . '</label>
								<BR><BR>
								<b style="font-size:15px">PRECIO FINAL</b><br>
								<label style="font-size:15px">' . money_format('%(#10n', $informacion_corrida->precio_final) . '</label><br>
								</td>
							</tr>
					  </table>
					  
					  
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Enganche y mensualidades</b>
							</td>
						</tr>
					</table>							
					<br><br>
						

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Días pago enganche</b></td>
								<td style="font-size: 1.4em;">' . $informacion_corrida->dias_pagar_enganche . '</td>
								<td style="font-size: 1.4em;"><b>Mensualidades SIN interés</b></td>
								<td style="font-size: 1.4em;"> <b>' . $informacion_corrida->finalMesesp1 . ' </b> ' . money_format('%(#10n', $informacion_corrida->msi_1p) . '</td>
								<td style="font-size: 1.4em;"><b>Primer mensualidad</b></td>
								<td style="font-size: 1.4em;">' . $informacion_corrida->primer_mensualidad . '</td>
							</tr>
					  </table>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Fecha Límite</b></td>
								<td style="font-size: 1.4em;">' . $informacion_corrida->fecha_limite . '</td>
								<td style="font-size: 1.4em;"><b>Mensualidades con interés (1% S.S.I.) </b></td>
								<td style="font-size: 1.4em;"> <b>' . $informacion_corrida->finalMesesp2 . ' </b> ' . money_format('%(#10n', $informacion_corrida->msi_2p) . '</td>
								<td style="font-size: 1.4em;"></td>
								<td style="font-size: 1.4em;"></td>
								</tr>
					  </table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">

							<tr>
								<td style="font-size: 1.4em;"><b>Pago Enganche</b></td>
								<td style="font-size: 1.4em;">' . money_format('%(#10n', $informacion_corrida->pago_enganche) . '<br></td>
								<td style="font-size: 1.4em;"><b>Mensualidades con interés (1.25% S.S.I.) </b></td>
								<td style="font-size: 1.4em;"> <b>' . $informacion_corrida->finalMesesp3 . ' </b> ' . money_format('%(#10n', $informacion_corrida->msi_3p) . '</td>
								<td style="font-size: 1.4em;"></td>
								<td style="font-size: 1.4em;"></td>
							</tr>
						</table>

						
					<br><br>
                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
						<tr>
							<td colspan="2" style="background-color: #103f75;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos Bancarios</b>
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
                        <td style="font-size: 1.4em;">' . $informacion_loteCorrida->banco . '</td>
                        <td style="font-size: 1.4em;">' . $informacion_loteCorrida->empresa . '</td>
                        <td style="font-size: 1.4em;">' . $informacion_loteCorrida->cuenta . '</td>
                        <td style="font-size: 1.4em;">' . $informacion_loteCorrida->clabe . '</td>
                        <td style="font-size: 1.4em;">' . $informacion_loteCorrida->referencia . '</td>
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
								<td style="font-size: 1.4em;">' . $informacion_vendedor->nombreAsesor . '</td>
							</tr>
						</table>

                      <table width="100%" style="height: 45px; border: 1px solid #ddd;" width="690">
							<tr>
								<td style="font-size: 1.4em;"><b>Observaciones</b></td>
								<td style="font-size: 1.4em;">' . $informacion_corrida->observaciones . '</td>
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

        foreach ($informacion_plan as $row) {
            $html .= '
                              <tr align="center">
							  <td style="border:1px solid #ddd; font-size: 1.4em;">' . $row->fecha . '</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">' . $row->pago . '</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">' . money_format('%(#10n', $row->capital) . '</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">' . money_format('%(#10n', $row->interes) . '</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">' . money_format('%(#10n', $row->total) . '</td>
							  <td style="border:1px solid #ddd; font-size: 1.4em;">' . money_format('%(#10n', $row->saldo) . '</td>
                              </tr>';
        }

        $html .= '</table>
                        
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
    function getCondominioDisponibleAMora() {

        $objDatos = json_decode(file_get_contents("php://input"));

        $condominio = $this->Corrida_model->getCondominioDisMora($objDatos->residencial);
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
        //echo 'Estoy creadno el excel';
        //exit;
        //$id_corrida = 76515;
        $data_corrida = $this->Corrida_model->getAllInfoCorrida($id_corrida);
        //print_r($data_corrida);
        $residencial = $data_corrida->residencial;
        $informacion_descCorrida = $this->Corrida_model->getinfoDescLoteCorrida($data_corrida->id_lote, $id_corrida);






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


        if($data_corrida->tipo_casa != NULL){
            $id_lote = $data_corrida->id_lote;
            $data_casas = $this->Corrida_model->getInfoCasasRes($id_lote);
            //$casas = json_decode(str_replace('"', '', $data_casas->tipo_casa));
            $casas = str_replace("'tipo_casa':", '', $data_casas->tipo_casa);
            $casas = str_replace('"', '', $casas );
            $casas = str_replace("'", '"', $casas );
            $casas = json_decode($casas);
//            echo 'Tipo de casa:';
//            print_r($data_corrida->tipo_casa);
//            echo '<br>';
            $nombre_casa = '';
            $sup_casa = '';
            $precio_m2_casa = '';
            $precio_casa = '';
            $extras = array();
            $extras_general = array();
            foreach ($casas as $clave=>$valor)
            {
                if((int) $data_corrida->tipo_casa === (int) $valor->id){
//                    echo 'el elegido es:<br>';
//                    print_r($valor);
//                    echo'<br>';
                    $nombre_casa = $valor->nombre;
                    $sup_casa = $valor->superficie;
                    $precio_m2_casa = $valor->precio_m2;
                    $precio_casa = $valor->total_const;
                    //vamos a avanzar los extras para mostrarlos y que concidan los numeros
                    if(count($valor->extras) >= 1){
//                        print_r($valor);
                        $n=0;
                        foreach($valor->extras as $indice=>$valor_extras){
                            $extras['techado'] = $valor_extras->techado;
                            $extras['tipo'] = 'techado';
                            $n++;
                        }
                    }


                }
            }
            array_push($extras_general, $extras);

            if(count($extras_general) >0){
                $precio_m2_casa = 16000;
            }
            $i = 30;
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

            $sheet->setCellValue('D4', 'Modelo');
            $sheet->setCellValue('E4', 'Sup. Casa');
            $sheet->setCellValue('F4', 'Precio m2 casa');
            $sheet->setCellValue('G4', 'Precio casa');
            $sheet->setCellValue('H4', 'Plazo');
            $sheet->setCellValue('I4', 'Apartado');
//            $sheet->setCellValue('I4', '10% precio m2');

            #set values
            $sheet->setCellValue('D5', $nombre_casa);
            $sheet->setCellValue('E5', $sup_casa);
            $sheet->setCellValue('F5', $precio_m2_casa);
            $sheet->getStyle('F5')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->setCellValue('G5', $precio_casa);
            $sheet->getStyle('G5')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->setCellValue('H5', ($data_corrida->finalMesesp1 + $data_corrida->finalMesesp2 + $data_corrida->finalMesesp3));
            $sheet->setCellValue('I5', $data_corrida->apartado);
            $sheet->getStyle('I5')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


            $sheet->setCellValue('D6', 'Lote');
            $sheet->setCellValue('E6', 'No');
            $sheet->setCellValue('F6', 'Superficie lote');
            $sheet->setCellValue('G6', 'Precio m2 lote');
            $sheet->setCellValue('H6', 'Precio/Saldo lote');

            $sheet->setCellValue('D7', $data_corrida->nombreCondominio);
            $sheet->setCellValue('E7', abs((int) filter_var(substr($data_corrida->nombreLote, -3), FILTER_SANITIZE_NUMBER_INT)));
            $sheet->setCellValue('F7', $data_corrida->superficie);
            $sheet->setCellValue('G7', $data_corrida->preciom2);
            $sheet->getStyle('G7')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->setCellValue('H7', $data_corrida->precio_total_lote);
            $sheet->getStyle('H7')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);




            $sheet->getStyle("D4:I4")->getFont()->setSize(10);
            $sheet->getStyle('D4:I4')->getFont()->getColor()->setARGB('4472C4');
            $sheet->getStyle( 'D4:I4' )->getFont()->setBold( true );
            $sheet->getStyle( 'D4:I4' )->getFont()->setName('Arial');
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(13);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(18);
            $sheet->getColumnDimension('H')->setWidth(18);
            $sheet->getColumnDimension('I')->setWidth(15);

            $sheet->getStyle('D5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');

            $sheet->getStyle("D6:I6")->getFont()->setSize(10);
            $sheet->getStyle('D6:I6')->getFont()->getColor()->setARGB('4472C4');
            $sheet->getStyle( 'D6:I6' )->getFont()->setBold( true );
            $sheet->getStyle( 'D6:I6' )->getFont()->setName('Arial');
            $sheet->getStyle('D7:H7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');

            //$sheet->mergeCells("D8:H8");
            //$sheet->setCellValue('D8', 'EXTRAS');
            //$sheet->getStyle( 'D8' )->getFont()->setBold( true );
            //$sheet->getStyle('D8:H8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D8E4BC');

//            print_r(count($extras_general));
//            exit;
            $contador=10;
            $extras_total = 0;
            if(count($extras_general) >= 1){
                //$sheet->mergeCells("D9:F9");
                //$sheet->setCellValue('D9', "Nombre");
                //$sheet->mergeCells("G9:H9");
                //$sheet->setCellValue('G9', "Precio");
                //$sheet->getStyle("D9:H9")->getFont()->setSize(10);
                //$sheet->getStyle('D9:H9')->getFont()->getColor()->setARGB('4472C4');
                //$sheet->getStyle( 'D9:H9' )->getFont()->setBold( true );
                //$sheet->getStyle( 'D9:H9' )->getFont()->setName('Arial');

                foreach ($extras_general as $values){
                    //print_r($values['tipo']);
                    //if($values['tipo']=='techado'){
                        //$sheet->mergeCells("D".$contador.":F".$contador);
                        //$sheet->setCellValue('D'.$contador, "Techado");
                        //$sheet->mergeCells("G".$contador.":H".$contador);
                        //$sheet->setCellValue('G'.$contador, $values['techado']);
                        //$sheet->getStyle('G'.$contador)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

                    //}
                    //$contador++;
                    $extras_total = $extras_total + $values['techado'];
                    //print_r($values);

                }
            }else{
                //$sheet->mergeCells("D9:H9");
                //$sheet->setCellValue('D9', 'Sin extras');
            }
            $sheet->setCellValue('G5', $precio_casa + $extras_total); #se vuelve a setear el valor de la casa más los extras en un solo registro


            #Aqui se deben mostrar los resultados
            $sheet->mergeCells("D14:H14");
            $sheet->setCellValue('D14', 'DESCUENTOS');
            $sheet->getStyle( 'D14' )->getFont()->setBold( true );
            $sheet->getStyle('D14:D14')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FABF8F');

            $contador2 = 15;
            if(count($informacion_descCorrida) >= 1){
                $sheet->mergeCells("D".$contador2.":"."E".$contador2);
                $sheet->setCellValue('D'.$contador2, 'Descuento');
                $sheet->getStyle( 'D'.$contador2 )->getFont()->setBold( true )->setSize(13);
                $sheet->getStyle('D'.$contador2 )->getFont()->getColor()->setARGB('4472C4');
//                $sheet->getStyle('D'.$contador2.':'.'E'.$contador2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');

                $sheet->mergeCells("F".$contador2.":"."G".$contador2);
                $sheet->setCellValue('F'.$contador2, 'Cantidad ahorro');
                $sheet->getStyle( 'F'.$contador2 )->getFont()->setBold( true )->setSize(13);
                $sheet->getStyle('F'.$contador2 )->getFont()->getColor()->setARGB('4472C4');

//                $sheet->getStyle('F'.$contador2.':'.'G'.$contador2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');

                $sheet->setCellValue('H'.$contador2, 'Aplicable a ');
                $sheet->getStyle('H'.$contador2)->getFont()->setBold( true );
                $sheet->getStyle('H'.$contador2 )->getFont()->getColor()->setARGB('4472C4');


//                $sheet->setCellValue('H'.$contador2, 'Aplicable a');
//                $sheet->getStyle( 'H'.$contador2 )->getFont()->setBold( true );
//                $sheet->getStyle('H'.$contador2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                $flag_cell = 0;
                $suma_descuentos=0;
                $precio_final_excel=0;
//                print_r(count($informacion_descCorrida));
//                echo '<br>';
                $nuevo_preciom2casa = $precio_m2_casa;
                $descuento_variable = 0;
                $descuento_variable2 = 0;
                $nuevo_preciom2lote = $data_corrida->preciom2;
                foreach($informacion_descCorrida as $item=>$value){
//                    print_r($item+1);

                    //print_r($value['porcentaje']);
                    $contador2++;
                    #porcentaje
                    $suma_descuentos = $suma_descuentos + $value['ahorro'];
                    $sheet->mergeCells("D".$contador2.":"."E".$contador2);
                    $sheet->setCellValue('D'.$contador2, $value['porcentaje']."%");
                    $sheet->getStyle( 'D'.$contador2 )->getFont()->setBold( true );
                    $sheet->getStyle('D'.$contador2.':'.'E'.$contador2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');

                    #ahorro
                    $sheet->mergeCells("F".$contador2.":"."G".$contador2);
                    $sheet->setCellValue('F'.$contador2, $value['ahorro']);
                    $sheet->getStyle( 'F'.$contador2 )->getFont()->setBold( true );
                    $sheet->getStyle('F'.$contador2.':'.'G'.$contador2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                    $sheet->getStyle('F'.$contador2)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


                    #aplica a
                    $sheet->setCellValue('H'.$contador2, $value['aplicable_a']);
                    $sheet->getStyle( 'H'.$contador2 )->getFont()->setBold( true );
                    $sheet->getStyle('H')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');


//                    $flag_val = $this->check_prime(4);
                    /*print_r($value);

                    echo '<br>';*/
//                    if(count($informacion_descCorrida) == ($item+1)){
//                        $precio_final_excel = $value['pm'];
//                        print_r();
//                    }

                    if($value['id_condicion']!=12){
//                        print_r($value);
                        $descuento_variable = ( $value['porcentaje'] * $nuevo_preciom2casa / 100);
                        $nuevo_preciom2casa = $nuevo_preciom2casa - $descuento_variable;
//                        echo '<br>';

                        $descuento_variable2 = ($value['porcentaje'] * $nuevo_preciom2lote / 100);
                        $nuevo_preciom2lote = $nuevo_preciom2lote - $descuento_variable2;

                    }

                }
//                print_r($nuevo_preciom2casa);
//                echo '<br>';
                /*echo 'TOTAL DESCUENTOS:<br>';
                print_r($suma_descuentos);*/
//                exit;



            }else{
                $sheet->mergeCells("D".$contador2.":"."H".$contador2);
                $sheet->setCellValue('D'.$contador2, 'Sin descuentos');
                $sheet->getStyle( 'D'.$contador2 )->getFont()->setBold( true );
                $sheet->getStyle('D'.$contador2.':'.'D'.$contador2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');

            }

            $sheet->mergeCells("E21:F21");
            $sheet->setCellValue('E21', 'PRECIO FINAL M2 CASA');
            $sheet->getStyle('E21:F21')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C4D79B');
            $sheet->getStyle( 'E21')->getFont()->setBold( true );
            $sheet->setCellValue('G21', $nuevo_preciom2casa);
            $sheet->getStyle( 'G21')->getFont()->setBold( false );
            $sheet->getStyle('G21')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D8E4BC');
            $sheet->getStyle('G21')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            #***********
            $sheet->mergeCells("E22:F22");
            $sheet->setCellValue('E22', 'PRECIO FINAL M2 LOTE');
            $sheet->getStyle('E22:F22')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DA9694');
            $sheet->getStyle( 'E22')->getFont()->setBold( true );
            $sheet->setCellValue('G22', $nuevo_preciom2lote);
            $sheet->getStyle( 'G22')->getFont()->setBold( false );
            $sheet->getStyle('G22')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
            $sheet->getStyle('G22')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


            #saldos y tabla
            //$sheet->mergeCells("D22:F22");
            //$sheet->setCellValue('D22', 'SUBTOTAL (contrucción + extras)');
            $sheet->mergeCells("D23:F23");
            $sheet->setCellValue('D23', 'SALDO CONSOLIDADO');
            $sheet->mergeCells("D24:F24");
            $sheet->setCellValue('D24', 'ENGANCHE');
            $sheet->mergeCells("D25:F25");
            $sheet->setCellValue('D25', 'SALDO');
            $sheet->mergeCells("D26:F26");
            $sheet->setCellValue('D26', 'MENSUALIDAD');

           // $sheet->getStyle("D22:F22")->getFont()->setSize(13)->setName('Arial')->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle("D23:F23")->getFont()->setSize(13)->setName('Arial')->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle("D24:F24")->getFont()->setSize(13)->setName('Arial')->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle("D25:F25")->getFont()->setSize(13)->setName('Arial')->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle("D26:F26")->getFont()->setSize(13)->setName('Arial')->setBold(true)->getColor()->setARGB('000000');

            //$sheet->mergeCells("G22:H22");
            //$sheet->getStyle('G22:H22')->getAlignment()->setHorizontal('left');
            //$sheet->getStyle('G22:H22')->getAlignment()->setVertical('left');
            //$sheet->setCellValue('G22', ($precio_casa + $extras_total));
            //$sheet->getStyle("G14:H22")->getFont()->setSize(13)->setBold( true );
            //$sheet->getStyle('G22')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            //$sheet->getStyle('G22:H22')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#D9D9D9');


            $sheet->mergeCells("G23:H23");
            $sheet->setCellValue('G23', $data_corrida->precio_final);
            $sheet->getStyle('G23:H23')->getAlignment()->setHorizontal('left');
            $sheet->getStyle('G23:H23')->getAlignment()->setVertical('left');
            $sheet->getStyle("G14:H23")->getFont()->setSize(13)->setBold( true );
            $sheet->getStyle('G23')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('G23:H23')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#D9D9D9');


            $sheet->mergeCells("G24:H24");
            $sheet->setCellValue('G24', $data_corrida->pago_enganche);
            $sheet->getStyle('G24:H24')->getAlignment()->setHorizontal('left');
            $sheet->getStyle('G24:H24')->getAlignment()->setVertical('left');
            $sheet->getStyle('G24')->getFont()->setSize(13)->setBold( true );
            $sheet->getStyle('G24')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('G24:H24')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#D9D9D9');


            $sheet->mergeCells("G25:H25");
            $sheet->setCellValue('G25', $data_corrida->saldo);
            $sheet->getStyle('G25:H25')->getAlignment()->setHorizontal('left');
            $sheet->getStyle('G25:H25')->getAlignment()->setVertical('left');
            $sheet->getStyle('G25')->getFont()->setSize(13)->setBold( true );
            $sheet->getStyle('G25')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('G25:H25')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#D9D9D9');


            $sheet->mergeCells("G26:H26");
            $sheet->setCellValue('G26', '=G31');
            $sheet->getStyle('G26:H26')->getAlignment()->setHorizontal('left');
            $sheet->getStyle('G26:H26')->getAlignment()->setVertical('left');
            $sheet->getStyle('G26')->getFont()->setSize(13)->setBold( true );
            $sheet->getStyle('G26')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('G26:H26')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#D9D9D9');



            #encabezado de las mensualidades
            $sheet->mergeCells("C28:D28");
            $sheet->setCellValue('C28', 'Mensualidad sin/Int. ');
            $sheet->getStyle('C28')->getFont()->setBold( true );
            $sheet->setCellValue('E28', $data_corrida->finalMesesp1);
            $sheet->getStyle('C28:I28')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('C29:I29')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


            $sheet->mergeCells("C29:D29");
            $sheet->setCellValue('C29', 'Mensualidad Con/Int. 1.108% SSI ');
            $sheet->getStyle('C29')->getFont()->setBold( true );
            $sheet->setCellValue('E29', ($data_corrida->finalMesesp2 + $data_corrida->finalMesesp3));
//            $sheet->getStyle('C25:E25')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #encabezado de los intereses
            $sheet->setCellValue('F28', 'Interés Mensual');
            $sheet->getStyle('F28')->getFont()->setBold( true );
            $sheet->setCellValue('G28', '1.108%');

            $sheet->setCellValue('F29', 'Interés Anual');
            $sheet->getStyle('F29')->getFont()->setBold( true );
            $sheet->setCellValue('G29', '13.3%');


            #primer mensualidad
            $sheet->mergeCells("H28:I28");
            $sheet->setCellValue('H28', 'Primer mensualidad');
            $sheet->getStyle('H28')->getFont()->setBold( true );

            $sheet->mergeCells("H29:I29");
            $sheet->setCellValue('H29', "=C".($i+1));

            #encabezado
            $sheet->setCellValue('C30', 'FECHAS');
            $sheet->setCellValue('D30', 'MES');
            $sheet->setCellValue('E30', 'CAPITAL');
            $sheet->setCellValue('F30', 'INTERESES');
            $sheet->setCellValue('G30', 'PAGO');
            $sheet->setCellValue('H30', 'SALDO');
            $sheet->setCellValue('I30', 'ESQUEMA');
            $sheet->getStyle( 'C30:I30' )->getFont()->setBold( true );
            $sheet->getStyle('C30:I30')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
            $sheet->getStyle('C30:I30')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            #termina encabezado



        }
        else{

            $i = 19;
            #aqui empieza el rango de de las corridas normales
            $range1 = 'C1';
            $range2 = 'I1';
            $sheet->mergeCells("$range1:$range2");
            $sheet->getStyle('C:I')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('C:I')->getAlignment()->setHorizontal('center');
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
            $sheet->setCellValue('E5', abs((int) filter_var(substr($data_corrida->nombreLote, -3), FILTER_SANITIZE_NUMBER_INT)));
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
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(18);
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


            $sheet->setCellValue('G11', 'Apartado');
            $sheet->getStyle( 'G11' )->getFont()->setName('Arial');
            $sheet->getStyle( 'G11:H11' )->getFont()->setBold( true );
            $sheet->getStyle("G11")->getFont()->setSize(10);
            $sheet->getStyle("H11")->getFont()->setSize(12);
            $sheet->setCellValue('H11', $data_corrida->apartado);
            $sheet->getStyle( 'H11' )->getFont()->setName('Arial');
            $sheet->getStyle('H11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
            $sheet->getStyle('H11')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);



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
            #termina encabezado
        }







        $array_dump = $data_corrida->corrida_dump;
        $array_dump = json_decode(($array_dump));
        $total_array = count($array_dump);
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

    function check_prime($num)
    {
        if ($num == 1)
            return 0;
        for ($i = 2; $i <= $num/2; $i++)
        {
            if ($num % $i == 0)
                return 0;
        }
        return 1;
    }

    function listado_cf(){
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
        $fecha_formateada = explode('-', $data_corrida['data_corrida']->primer_mensualidad );
        $data_corrida['data_corrida']->primer_mensualidad = $fecha_formateada[2].'-'.$fecha_formateada[1].'-'.$fecha_formateada[0];
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
        $arreglo["fecha_modificacion"] = date("Y-m-d H:i:s");
        $arreglo["fechaApartado"] = $objDatos->fechaApartado;

        /*print_r($arreglo);
        exit;*/

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
        }

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

    }

    public function getPaquetesByCondominio()
    {
        $time = time();
        $object = json_decode(file_get_contents("php://input"));


        if(!isset($object->id_condominio))
            echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Condominium id is a required parameter to make this request.", "message" => "Verify that the parameter is specified."));
        else if($object->id_condominio == '' || $object->id_condominio == null || $object->id_condominio == 'undefined')
            echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Some parameter does not have a specified value.", "message" => "Verify that all parameters contain a specified value."));
        else {
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
                echo json_encode(array("status" => 200, "message" => "No information to display.", "data"=>array()));
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
                $paquete_info = $this->Corrida_model->getPaqById($paquetes_data[$i]->id_paquete);
                $paquete_view[$i] = array(
                    'id_paquete' => $paquete_info->id_paquete,
                    'descripcion' => $paquete_info->descripcion,
                );

                for( $c = 0; $c < count($paquetes_data[$i]->descuentos); $c++ ){
                    $data_descuento = $this->Corrida_model->getDescById($paquetes_data[$i]->descuentos[$c]->id_descuento);
                    $paquete_view[$i]['response'][$c]['id_descuento'] = $data_descuento->id_descuento;
//                    $paquete_view[$i]['response'][$c]['id_tdescuento'] = $data_descuento->id_tdescuento;
//                    $paquete_view[$i]['response'][$c]['inicio'] = $data_descuento->inicio;
//                    $paquete_view[$i]['response'][$c]['fin'] = $data_descuento->fin;
                    $paquete_view[$i]['response'][$c]['id_condicion'] = $data_descuento->id_condicion;
                    $paquete_view[$i]['response'][$c]['porcentaje'] = (int)$data_descuento->porcentaje;
//                    $paquete_view[$i]['response'][$c]['eng_top'] = $data_descuento->eng_top;
                    $paquete_view[$i]['response'][$c]['apply'] = $data_descuento->apply;
                    $paquete_view[$i]['response'][$c]['leyenda'] = $data_descuento->leyenda;
                    $paquete_view[$i]['response'][$c]['prioridad'] = $data_descuento->prioridad;
                    $paquete_view[$i]['response'][$c]['estatus'] = $paquetes_data[$i]->descuentos[$c]->estatus;
                    $paquete_view[$i]['response'][$c]['id_paquete'] = $paquetes_data[$i]->id_paquete;
                    $paquete_view[$i]['response'][$c]['msi_descuento'] = (int) $data_descuento->msi_descuento;
                }
            }
        }else{
            $paquete_view = array();
        }

        print_r(json_encode($paquete_view));
    }
    function getDescsByCondominio(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $id_condominio = $objDatos->id_condominio;
        $id_pxc = $objDatos->id_pxc;
        $data_descuentos = $this->Corrida_model->getDescsByCondominio($id_condominio, $id_pxc);

        $object_descuentos = json_decode($data_descuentos->id_paquete);
        $array_descuentos = explode(',', $object_descuentos->paquetes, 999);
        $tipo_superficie = $object_descuentos->tipo_superficie;

        //recibe un array separados por "," así: Array ( [0] => 326 [1] => 328 [2] => 334 )
        for($i=0; $i<count($array_descuentos); $i++){
            $paquete_info = $this->Corrida_model->getPaqById($array_descuentos[$i]);
            $paquete_view[$i] = array(
                'id_paquete' => $paquete_info->id_paquete,
                'descripcion' => $paquete_info->descripcion,
                'aplicable_a' => $tipo_superficie->tipo,
                'sup1'        => $tipo_superficie->sup1,
                'sup2'        => $tipo_superficie->sup2,
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
        print_r(json_encode($paquete_view, JSON_NUMERIC_CHECK ));

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

    public function calculoMoratorio()
    {
        if($this->session->userdata('id_usuario') == 5107)
        {
            $this->load->view("corrida/moratorio");
        }
        else
        {
            redirect(base_url().'login');
        }
    }

    public function moratorios()
    {
            $this->load->view("corrida/moratorios_nv");
    }

    public function listado_corridaspc(){
        $datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
        $this->load->view('template/header');
        $this->load->view("corrida/corridas_pagosc", $datos);
    }
    function getCorridasPCByLote($idLote){
        $data_lotes = $this->Corrida_model->getCorridasPCByLote($idLote);
        if($data_lotes != null) {
            echo json_encode($data_lotes);
        } else {
            echo json_encode(array());
        }
    }
    public function insertPagoCapitalCorrida()
    {
        $objDatos = json_decode(file_get_contents("php://input"));
        $idLote = (int)$objDatos->idLote;
        $arreglo = array();
        $arreglo["plan_pc"] = $objDatos->plan_pc;
        $arreglo["idLote"] = $objDatos->idLote;
        $arreglo["anio"] = $objDatos->anio;
        $arreglo["precio_m2"] = $objDatos->precio_m2;
        $arreglo["total"] = $objDatos->total;
        $arreglo["porcentajeEng"] = $objDatos->porcentajeEng;
        $arreglo["engancheCantidad"] = $objDatos->engancheCantidad;
        $arreglo["diasPagoEng"] = $objDatos->diasPagoEng;
        $arreglo["mesesDiferir"] = $objDatos->mesesDiferir;
        $arreglo["fecha_limite"] = $objDatos->fecha_limite;
        $arreglo["mplan_1"] = $objDatos->mplan_1;
        $arreglo["mplan_2"] = $objDatos->mplan_2;
        $arreglo["mplan_3"] = $objDatos->mplan_3;
        $arreglo["pp_1"] = $objDatos->pp_1;
        $arreglo["pp_2"] = $objDatos->pp_2;
        $arreglo["pp_3"] = $objDatos->pp_3;
        $arreglo["primer_mensualidad"] = (date("Y-m-d", strtotime($objDatos->primer_mensualidad) ) == '' || date("Y-m-d", strtotime($objDatos->primer_mensualidad) ) == NULL) ? null : date("Y-m-d", strtotime($objDatos->primer_mensualidad) ) ;
        $arreglo["fecha_creacion"] = date('Y-m-d H:i:s');
        $arreglo["corrida_dump"] = json_encode($objDatos->corrida_dump);
        $arreglo["creado_por"] = $this->session->userdata('id_usuario');
        $data_response = $this->General_model->addRecord('pagos_capital', $arreglo);

        if($data_response) {
            $response['message'] = 'OK';
            echo json_encode($response);
        }else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }
    }
    function getLotesPC($condominio,$residencial)
    {
        $data['lotes'] = $this->Corrida_model->getLotesPC($condominio, $residencial);
        //$data2 = array
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

    function editapc($id_corrida){
        $data_corrida = array(
            "id_corrida" => $id_corrida,
            "nombre" => 'LOTE TEST'
        );
        $data_corrida['data_corrida'] = $this->Corrida_model->getInfoPCyID($id_corrida);
        $this->load->view("corrida/editarPC", $data_corrida);
    }

    function updatePC(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $id_pc = $objDatos->id_pc;
        $corrida_dump = $objDatos->corrida_dump;
        $data['corrida_dump'] = json_encode($corrida_dump);
        $data['modificado_por'] = $this->session->userdata('id_usuario');
        $data['fecha_modificacion'] = date('Y-m-d H:i:s');
        $table = 'pagos_capital';
        $key = 'id_pc';
        $data_response = $this->General_model->updateRecord($table, $data, $key, $id_pc); // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE


        if($data_response) {
            $response['message'] = 'OK';
            echo json_encode($response);
        }else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }

    }

    function getAllLotesY() {
        $objDatos = json_decode(file_get_contents("php://input"));
        $lotes = $this->Corrida_model->getAllLotesY($objDatos->condominio);
        if($lotes != null) {
            echo json_encode($lotes);
        } else {
            echo json_encode(array());
        }
    }
    public function getinfoLoteDisponibleYL()
    {
        $objDatos = json_decode(file_get_contents("php://input"));
        $data = $this->Corrida_model->getLotesInfoY($objDatos->lote);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }
    function generateExcelMR($data_corrida){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //        print_r('printing...');
        #imagen ciudad maderas
        // Add a drawing to the worksheet
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Ciudad Maderas');
        $drawing->setDescription('Ciudad Maderas');
        $drawing->setPath(__DIR__.'/../../static/images/logo_ciudadmaderasAct.jpg');
        $drawing->setHeight(100);
        $drawing->setCoordinates('D1');
        $drawing->setOffsetX(55);
        $drawing->setOffsetY(20);
        $drawing->setWorksheet($sheet);
        $sheet->getRowDimension('1')->setRowHeight(100);
        $sheet->setShowGridlines(true);

        $range1 = 'C1';
        $range2 = 'I1';
        $sheet->mergeCells("$range1:$range2");
        $sheet->getStyle('B:L')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B:L')->getAlignment()->setVertical('center');
        $sheet->getStyle("C1:I1")->getFont()->setSize(28);
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB('808080');

        $i = 15;
        #aqui empieza el rango de de las corridas normales
        $range1 = 'C1';
        $range2 = 'I1';
        $sheet->mergeCells("$range1:$range2");
        $sheet->getStyle('C:I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C:I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("C1:I1")->getFont()->setSize(28);
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB('808080');

        $sheet->setCellValue('C2', 'Cálculo de intereses moratorios');
        $range12 = 'C2';
        $range22 = 'I2';
        $sheet->mergeCells("$range12:$range22");
        $sheet->getStyle("C2:I2")->getFont()->setSize(26);
        $sheet->getStyle('C2')->getFont()->getColor()->setARGB('FFFFFF');
        $sheet->getStyle( 'C1:C2' )->getFont()->setName('Calibri');
        $sheet->getStyle('C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1F497D');



        $sheet->setCellValue('D4', 'PROYECTO');
        $sheet->setCellValue('E4', 'CONDOMINIO');
        $sheet->setCellValue('F4', 'LOTE');
        $sheet->setCellValue('G4', 'CLIENTE');
        $sheet->setCellValue('H4', 'SALDO INSOLUTO');
        $sheet->setCellValue('D5', $data_corrida['proyecto']);
        $sheet->setCellValue('E5', $data_corrida['condominio']);
        $sheet->setCellValue('F5', $data_corrida['nombreLote']);
        $sheet->setCellValue('G5', $data_corrida['cliente']);
        $sheet->getStyle('H5')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
        $sheet->setCellValue('H5', $data_corrida['saldo_insoluto']);

        $sheet->getStyle("D4:I4")->getFont()->setSize(10);
        $sheet->getStyle('D4:I4')->getFont()->getColor()->setARGB('4472C4');
        $sheet->getStyle( 'D4:I4' )->getFont()->setBold( true );
        $sheet->getStyle( 'D4:I4' )->getFont()->setName('Arial');
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(23);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('D5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');



        $sheet->setCellValue('D7', 'PLAZO');
        $sheet->setCellValue('E7', 'MSI');
        $sheet->setCellValue('F7', 'INTERÉS MORATORIO');
        $sheet->setCellValue('G7', 'FECHA PAGO');
        $sheet->getStyle("D7:I7")->getFont()->setSize(10);
        $sheet->getStyle('D7:I7')->getFont()->getColor()->setARGB('4472C4');
        $sheet->getStyle( 'D7:I7' )->getFont()->setBold( true );
        $sheet->getStyle( 'D7:I7' )->getFont()->setName('Arial');
        $sheet->getStyle('D8:G8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        #set values
        $sheet->setCellValue('D8', $data_corrida['plazo']);
        $sheet->setCellValue('E8', $data_corrida['msi']);
        $sheet->setCellValue('F8', $data_corrida['im']);
        $fecha_formateada = new DateTime($data_corrida['fecha_pago']);
        $sheet->setCellValue('G8',  $fecha_formateada->format('d-m-Y'));


        $sheet->setCellValue('F10', 'INTERÉS MORATORIO ACUMULADO');
        $sheet->setCellValue('G10', 'INTERÉS ORDINARIO ACUMULADO');
        $sheet->getStyle("F10:G10")->getFont()->setSize(10);
        $sheet->getStyle("F10:G10")->getAlignment()->setWrapText(true);
        $sheet->getStyle('F10:G10')->getFont()->getColor()->setARGB('4472C4');
        $sheet->getStyle( 'F10:G10' )->getFont()->setBold( true );
        $sheet->getStyle( 'F10:G10' )->getFont()->setName('Arial');
        $sheet->setCellValue('F11', $data_corrida['ima']);
        $sheet->setCellValue('G11', $data_corrida['ioa']);
        $sheet->getStyle('F11:G11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle('F11:G11')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

        #leyenda....
        $sheet->setCellValue('C13', '*Este sistema simula las operaciones de intereses moratorios e intereses ordinados, puede ser diferente al cálculo real');
        $rangel = 'C13';
        $rangel2 = 'I13';
        $sheet->mergeCells("$rangel:$rangel2");
        $sheet->getStyle("C13:I13")->getFont()->setSize(11);
        $sheet->getStyle('C13')->getFont()->getColor()->setARGB('ddd');
        $sheet->getStyle( 'C13:I13' )->getFont()->setName('Calibri');
        $sheet->getStyle("C13:I13")->getAlignment()->setWrapText(true);
        $sheet->getStyle( 'C13:I13' )->getFont()->setBold( true );
        $sheet->getStyle('C13:I13')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);





        /*encabezados de la tabla*/
        $sheet->setCellValue('B15', 'FECHAS');
        $sheet->setCellValue('C15', 'PAGO');
        $sheet->setCellValue('D15', 'CAPITAL');
        $sheet->setCellValue('E15', 'INTERESES');
        $sheet->setCellValue('F15', 'IMPORTE');
        $sheet->setCellValue('G15', 'FECHA PAGO');
        $sheet->setCellValue('H15', 'DÍAS DE RETRASO');
        $sheet->setCellValue('I15', 'INTERÉS MORATORIO');
        $sheet->setCellValue('J15', 'TOTAL');
        $sheet->setCellValue('K15', 'SALDO INSOLUTO');
        $sheet->setCellValue('L15', 'SALDO');
        $sheet->getStyle( 'B15:L15' )->getFont()->setBold( true );
        $sheet->getStyle('B15:L15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $sheet->getStyle('B15:L15')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle("H15")->getAlignment()->setWrapText(true);
        $sheet->getStyle("J15")->getAlignment()->setWrapText(true);

        #termina encabezado

        $array_dump = json_encode($data_corrida['data_corrida']);
        $array_dump = json_decode(($array_dump));
        $total_array = count($array_dump);
        foreach($array_dump as $item=>$value) {
            $i++;

            #fecha
            $sheet->setCellValue('B'.$i, $value->fecha);
            $sheet->getStyle('B'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #pago
            $sheet->setCellValue('C'.$i, $value->pago);
            $sheet->getStyle('C'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #capital
            $sheet->setCellValue('D'.$i, $value->capital);
            $sheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('D'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #intereses
            $sheet->setCellValue('E'.$i, $value->interes);
            $sheet->getStyle('E'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('E'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #importe
            $sheet->setCellValue('F'.$i, $value->importe);
            $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('F'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #fecha pago
            $sheet->setCellValue('G'.$i, $value->fechaPago);
            $sheet->getStyle('G'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #dias_retraso
            $sheet->setCellValue('H'.$i, $value->diasRetraso);
            $sheet->getStyle('H'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #IM
            $sheet->setCellValue('I'.$i, $value->interesMoratorio);
            $sheet->getStyle('I'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('I'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #total
            $sheet->setCellValue('J'.$i, $value->total);
            $sheet->getStyle('J'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('J'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #saldo moratorio
            $sheet->setCellValue('K'.$i, $value->saldo);
            $sheet->getStyle('K'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('K'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            #saldo
            $sheet->setCellValue('L'.$i, $value->saldoNormal);
            $sheet->getStyle('L'.$i)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            $sheet->getStyle('L'.$i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        }

        $nombre_archivo = 'moratorios.xlsx';


        $dir_2 = $_SERVER['DOCUMENT_ROOT'].'sisfusion/static/documentos/cliente/corrida/'.$nombre_archivo;
        $dir_2 = str_replace("\ ", '/', $dir_2);

        $writer = new Xlsx($spreadsheet);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $nombre_archivo .'"');
        header('Cache-Control: max-age=0');

        $writer->save("php://output");// download file
    }
    public function excel_moratorios(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $proyecto = $objDatos->proyecto;
        $condominio = $objDatos->condominio;
        $lote = $objDatos->lote;
        $nombreLote = $objDatos->nombreLote;
        $cliente = $objDatos->cliente;
        $plazo = $objDatos->plazo;
        $msi = $objDatos->msi;
        $im = $objDatos->im;
        $fecha_pago = $objDatos->fecha_pago;
        $saldo_insoluto = $objDatos->saldo_insoluto;
        $ima = $objDatos->ima;
        $ioa = $objDatos->ioa;
        $data_corrida = $objDatos->data_corrida;

        $data = array(
            'proyecto' => $proyecto,
            'condominio' => $condominio,
            'lote' => $lote,
            'nombreLote' => $nombreLote,
            'cliente' => $cliente,
            'plazo' => $plazo,
            'msi' => $msi,
            'im' => $im,
            'fecha_pago' => $fecha_pago,
            'saldo_insoluto' => $saldo_insoluto,
            'ima'=> $ima,
            'ioa'=> $ioa,
            'data_corrida' => $data_corrida
        );
        $responde = $this->generateExcelMR($data);
    }

    function getGerenteByID(){
        $objDatos = json_decode(file_get_contents("php://input"));
        $id_gerente = $objDatos->gerente;
        $data= $this->Corrida_model->getGerenteByID($id_gerente);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getCoordinadorByID() {
        $objDatos = json_decode(file_get_contents("php://input"));
        $data= $this->Corrida_model->getCoordinadorByID($objDatos->coordinador);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getAsesorByID() {
        $objDatos = json_decode(file_get_contents("php://input"));
        $data= $this->Corrida_model->getAsesorByID($objDatos->asesor);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

}