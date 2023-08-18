<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clientes extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Clientes_model', 'Statistics_model', 'asesor/Asesor_model', 'Caja_model_outside',
            'General_model'));
        $this->load->library(array('session','form_validation'));
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

	public function index()
	{
		if($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '7')
		{
			redirect(base_url().'login');
		}
		$this->load->view('template/header');
		$this->load->view('asesor/inicio_asesor_view2');
		$this->load->view('template/footer');
	}
/**Reporte clientes  */
    public function RpClientes(){
        $this->load->view('template/header');
        $this->load->view("clientes/RpClientes");
    }
public function getRpClientes()
    {
        $data['data'] = $this->Clientes_model->getRpClientes();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
/** */
    public function marketingDigitalReport(){
        $this->load->view('template/header');
        $this->load->view("clientes/mktd_report");
    }

    public function getMKTDReport(){
        $data['data'] = $this->Clientes_model->getMKTDReport()->result_array();
        echo json_encode($data);
    }

    public function recommendedReport(){
        $this->load->view('template/header');
        $this->load->view("clientes/recommended_report");
    }

    public function newProspect(){
        $this->load->view('template/header');
        if ($this->session->userdata('id_rol') == '22') {
            $this->load->view("clientes/prospectos_mktd");
        } else {
            $this->load->view("clientes/prospectos");
        }
    }

    public function newProspectMktd(){
        $this->load->view('template/header');
        $this->load->view("clientes/prospectos_mktd");
    }

    public function getCMReport(){
        $data['data'] = $this->Clientes_model->getCMReport()->result_array();
        echo json_encode($data);
    }

    public function getOFReport(){
        $data['data'] = $this->Clientes_model->getOFReport()->result_array();
        echo json_encode($data);
    }
    
    public function originatingFromReport(){
        $this->load->view('template/header');
        $this->load->view("clientes/of_report");
    }
    
    public function clubMaderasReport(){
        $this->load->view('template/header');
        $this->load->view("clientes/cm_report");
    }

    public function statusByProspect(){
        $this->load->view('template/header');
        $this->load->view("clientes/dm_report");
    }

    public function digitalMarketingReport(){
        $this->load->view('template/header');
        $this->load->view("clientes/dm_report");
    }

    public function authorizations(){
        $this->load->view('template/header');
        $this->load->view("clientes/authorizations_report");
    }

    public function cmReport(){
        $this->load->view('template/header');
        $this->load->view("clientes/clubmaderas_report");
    }

/*---------------------------------------------------------------PREVENTA------------------------------------------------*/
 public function updateStatusPreventa(){
        $data = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "becameClient" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "estatus_particular" => 7,
            "tipo" => 1
        );
        if(isset($_POST) && !empty($_POST)){
            $response = $this->Clientes_model->updateStatusPreventa($data, $this->input->post("id_prospecto_estatus_particular3"));
            echo json_encode($response);
        }
    }
     public function getProspectsPreventaList($typeTransaction){
        /*
         *  0  MKTD
         *  1   VETNAS
         */
        if ($typeTransaction == 1) {
            $data['data'] = $this->Clientes_model->getProspectsPreventaList()->result_array();
        } elseif ($typeTransaction == 0) {
            $data['data'] = $this->Clientes_model->getProspectsPreventaList()->result_array();

        }
        echo json_encode($data);
    }
public function getStatusMktdPreventa(){
        echo json_encode($this->Clientes_model->getStatusMktdPreventa()->result_array());
    }
    public function consultPreventa(){
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospecto_preventa");
    }
/*-------------------------------------------------------------------------------------------------------------------------------*/

    public function bonuses(){
        $this->load->view('template/header');
        $this->load->view("clientes/bonuses");
    }
	public function verificarBonificaciones(){
		$this->load->view('template/header');
		$this->load->view("clientes/verificarBonificaciones");
	}

    public function consultProspects(){
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospectos");
    }
 
        public function consultProspects_dir()
    {
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospecto_dir.php");
    }
    public function consultProspects_sbdir()
    {
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospecto_sbdir");
    }
    public function busquedaDetallada()
    {
        $this->load->view('template/header');
        $this->load->view("clientes/busDet_prospectos");
    }

    public function consultClients(){
        $this->load->view('template/header');
        if($this->session->userdata('id_rol') == 26)
            $this->load->view("clientes/consulta_clientes_mercadologo");
        else
        $this->load->view("clientes/consulta_clientes");
    }

    public function consultProspectsMktd(){
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospectos_mktd");
    }

    public function consultProspectsGteMktd(){
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospectos_gtemktd");
    }

    public function consultProspectsGteVentas(){
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospectos_gteventas");
    }

    public function sharedSales(){
        $this->load->view('template/header');
        $this->load->view("clientes/shared_sales");
    }

    public function coOwners(){
        $this->load->view('template/header');
        $this->load->view("clientes/co_owners");
    }

    public function references(){
        $this->load->view('template/header');
        $this->load->view("clientes/references");
    }

    public function getRecommendedReport(){
        $clientsList = $this->Clientes_model->getRecommendedList()->result_array();
        $finalArray = array();
        for ($i = 0; $i < COUNT($clientsList); $i++) {
            $finalArray['data'][$i] = $this->Clientes_model->getRecommendedReport($clientsList[$i]['tipo_recomendado'], $clientsList[$i]['id_prospecto'], $clientsList[$i]['otro_lugar'])->row();
        }
        echo json_encode($finalArray);
    }

    public function bulkload(){
        $this->load->view('template/header');
        $this->load->view("clientes/bulkload");
    }
    public function listaClientes()
    {
        $this->load->view('template/header');
        $this->load->view('clientes/lista_cliente_sdmktd');
    }

    public function uploadData() {
        $search = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ,ÃÃ³,ÃÃº,ÃÃ±,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü");
        $replace = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;");
        $count=0;
        $fp = fopen($_FILES['customFile']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {
                continue;
            }
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
                $insert_csv['id_sede'] = $csv_line[0];
                $insert_csv['id_asesor'] = $csv_line[1];
                $insert_csv['nombre'] = utf8_encode($csv_line[2]);
                $insert_csv['apellido_paterno'] = utf8_encode($csv_line[3]);
                $insert_csv['apellido_materno'] = utf8_encode($csv_line[4]);
                $insert_csv['personalidad_juridica'] = $csv_line[5];
                $insert_csv['correo'] = $csv_line[6];
                $insert_csv['telefono'] = $csv_line[7];
                $insert_csv['telefono_2'] = $csv_line[8];
                $insert_csv['observaciones'] = utf8_encode($csv_line[9]);
                $insert_csv['lugar_prospeccion'] = $csv_line[10];
                $insert_csv['otro_lugar'] = $csv_line[11];
                $insert_csv['plaza_venta'] = $csv_line[12];
                $insert_csv['nacionalidad'] = $csv_line[13];
            }

            // var_dump($insert_csv);
            // exit;
            $i++;
            
            $data = array(
                'id_sede' => utf8_decode($insert_csv['id_sede']),
                'id_asesor' => $insert_csv['id_asesor'],
                'id_coordinador' => $this->session->userdata('id_usuario'),
                'id_gerente' => $this->session->userdata('id_rol') == 19 ? $this->session->userdata('id_usuario') : $this->session->userdata('id_lider'),
                'nombre' => $insert_csv['nombre'],
                'apellido_paterno' => $insert_csv['apellido_paterno'],
                'apellido_materno' => $insert_csv['apellido_materno'],
                'personalidad_juridica' => $insert_csv['personalidad_juridica'],
                'rfc' => '',
                'curp' => '',
                'correo' => $insert_csv['correo'],
                'telefono' => $insert_csv['telefono'],
                'telefono_2' => $insert_csv['telefono_2'],
                'tipo' => '0',
                'observaciones' => $insert_csv['observaciones'],
                'lugar_prospeccion' => $insert_csv['lugar_prospeccion'],
                'plaza_venta' => $insert_csv['plaza_venta'],
                'estatus' => '1',
                'nacionalidad' => $insert_csv['nacionalidad'],
                'creado_por' => $this->session->userdata('id_usuario'),
                'otro_lugar' => $insert_csv['otro_lugar'],
                'fecha_vencimiento' => date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")."+ 30 days"))
            );

            // var_dump($data);
            $response = $this->Clientes_model->uploadData($data);
            //echo json_encode($response);
            //$data['inserted_data']=$this->db->insert('prospectos', $data);
        }
        fclose($fp) or die("can't close file");
        $data['success']="success";
        // return $data;
        $countData = $count-1;
        echo json_encode($response);
//        echo json_encode(1);
    }

    public function concentradoBonificaciones()
	{
		$this->load->library('Pdf');
		$pdf = new TCPDF('L', 'mm', 'LETTER', 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		// $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
		$pdf->SetTitle('TICKET DE BOFINICACIÓN');
		$pdf->SetSubject('Información personal de prospecto / cliente (CRM)');
		$pdf->SetKeywords('CRM, INFROMACION, PERSONAL, PROSPECTO');
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, 0);
		//relación utilizada para ajustar la conversión de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setPrintHeader(false);
		// $pdf->setPrintFooter();
		$pdf->setFontSubsetting(true);
		$pdf->SetFont('Helvetica', '', 9, '', true);
		$pdf->SetMargins(7, 5, 10, true);
		$pdf->AddPage('L', 'LETTER');
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();
		$pdf->Image('dist/img/arbol1.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
		$pdf->setPageMark();
		$informacion = $this->Clientes_model->getPrintableInformation(1500)->row();
		$informacion_lugar = $this->Clientes_model->getProspectSpecification(1502)->row();
		$clienteMaderas = 0;
		/*if($informacion){*/
			$html = '
            <!DOCTYPE html>
            <html lang="es_mx"  ng-app="Contratación">
        <head>
            <style>
            legend {
                background-color: #296D5D;
                color: #fff;
            }           
            </style>
        </head>
        <body>
              <section class="content">
                    <div class="row">
                        <div class="col-xs-10 col-md-offset-1">
                        <div class="box">
                            <div class="box-body">
                                  <table width="100%" style="height: 100px; border: 5px solid #fff;" width="100%">
                                    <tr>
                                        <td colspan="2" align="left"><img src="'.base_url().'static/images/ddd.png" style=" max-width: 40%; height: 80px;"></td>
                                        <td colspan="2" align="right">
                                        <br><br>
                                        	<b style="font-size: 2em;color: #0b3e6f"> FORMATO RECOMENDACIÓN<BR></b>
                                        	<br>
                                        	<b style="font-size: 1.3em">FECHA: </b>'.date('d / m / Y'). '&nbsp;&nbsp;&nbsp; 
                                        	&nbsp;&nbsp;&nbsp; 
                                        	&nbsp;&nbsp;&nbsp; 
                                        	<b style="font-size: 1.3em">FOLIO: </b> <b style="color: red;font-size: 1.3em">17952</b>
                                        </td>
                                    </tr>
                                  </table>
                                
                                <br><br>
                                  <!--<table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;">
                                    <tr>
                                        <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos generales</b>
                                        </td>
                                    </tr>
                                </table>-->							
                                <br>                       
                                    <div class="row">                
                                  <table width="100%" style="padding:10px 0px;height: 45px; border: 1px solid #ddd; text-align: center;" >
                                        <tr>
                                        	<td colspan="1" align="left">
                                        		<label>NOMBRE:</label>
											</td>
                                            <td colspan="7" style="font-size: 1em;border-bottom:1px solid #0c368b">
                                             <b>Ariana Hernández Gutierrez</b>
                                            </td>
                                        </tr>                                     
                                        <tr>
                                            <td colspan="1" align="left">
                                        		<label>PROYECTO:</label>
											</td>
											<td colspan="2" style="font-size: 1em;border-bottom:1px solid #0c368b">
                                        		<label>CMQ</label>
											</td>
											<td colspan="1">
                                        		<label>CONDOMINIO:</label>
											</td>
											<td colspan="2" style="font-size: 1em;border-bottom:1px solid #0c368b">
                                        		<label>EUCALIPTO</label>
											</td>
											<td colspan="1">
                                        		<label>LOTE:</label>
											</td>
											<td colspan="1" style="font-size: 1em;border-bottom:1px solid #0c368b">
                                        		<label>MQ-EU-66</label>
											</td>
                                        </tr>
                                        <tr>
                                         	<td colspan="2" align="left">
                                        		<label>MOTIVO DE LA COMPRA:</label>
											</td>
											<td colspan="1">
                                        		<input type="checkbox" id="inversionMC" name="motivoCompra" value="1" 
                                        		style="border:1px solid #ccc" checked="checked"> Inversión
											</td>
											<td colspan="1">
                                        		<input type="checkbox" id="ContruirMC" name="motivoCompra" value="1" 
                                        		style="border:1px solid #ccc" checked="checked"> Construir Casa
											</td>
											<td colspan="2" align="right">
                                        		<label>OTRO: </label>
											</td>
											<td colspan="2" style="font-size: 1em;border-bottom:1px solid #0c368b">
                                        		<b>otro alv</b>
											</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <br>                                                         
                                <table width="100%" style="padding:10px 0px;height: 45px; border: 1px solid #ddd; text-align: center;">
                                <tr>
                                    <td colspan="8" align="center">
                                    	<label>¿LO ESTÁ RECOMENDANDO ALGUNA PERSONA QUE ES CLIENTE <b>MADERAS</b>?</label>
									</td>
								</tr>
								<tr>
									<td colspan="4" align="right">
                                    	<input type="checkbox" id="recEsMaderasSi" name="recEsMaderas" value="1" 
                                       		checked="checked"> Si
									</td>
									<td colspan="4" align="left">
                                    	<input type="checkbox" id="recEsMaderasNo" name="recEsMaderas" value="1" 
                                         checked="checked"> No
									</td>
                                </tr>
                                
                                
                                	';
			if($clienteMaderas==1)
			{
				$html .=
					'
					<tr><td colspan="8"></td></tr>
					<tr>
						<td colspan="4" align="left">
							<label>¿CUÁL ES EL NOMBRE DE LA PERSONA QUE LO RECOMENDÓ?</label>
						</td>
						<td colspan="4" style="font-size: 1em;border-bottom:1px solid #0c368b">
							<b>Fulanito Perez Ocampo</b>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="left">
						
							<label>¿SABE QUE LOTE COMPRÓ?</label>
						</td>
						<td colspan="1">
                             <input type="checkbox" id="sabeLoteComproSi" name="sabeLoteCompro" value="1" 
                             checked="checked"> Si
						</td>
						<td colspan="1">
                        	<input type="checkbox" id="sabeLoteComproNo" name="sabeLoteCompro" value="0" 
                            checked="checked"> No
						</td>
                    </tr>
					<tr>
						<td colspan="1" align="left">
							<label>PROYECTO:</label>
						</td>
						<td colspan="2" style="font-size: 1em;border-bottom:1px solid #0c368b">
							<label>CMQ</label>
						</td>
						<td colspan="1">
							<label>CONDOMINIO:</label>
						</td>
						<td colspan="2" style="font-size: 1em;border-bottom:1px solid #0c368b">
							<label>EUCALIPTO</label>
						</td>
						<td colspan="1">
							<label>LOTE:</label>
						</td>
						<td colspan="1" style="font-size: 1em;border-bottom:1px solid #0c368b">
							<label>MQ-EU-66</label>
						</td>
					</tr>
					';
			}
			elseif ($clienteMaderas==0)
			{
				$html .='
					<tr>
						<td colspan="8">
							<label>¿POR CUÁL MEDIO SE ENTERO DEL DESARROLLO?:</label>
						</td>
				    </tr>
				    <tr>
				    	<td colspan="2"></td> 
				    	<td colspan="1" align="left">
				    		<input type="checkbox" id="volanteMedio" name="volanteMedio" value="volante"> 
				    		<label for="volanteMedio">Volante</label>
				    		<br><br>
				    		
				    		<input type="checkbox" id="periodicoMedio" name="periodicoMedio" value="periodico"> 
				    		<label for="periodicoMedio">Periodico</label>
				    		<br><br>
				    		
				    		<input type="checkbox" id="revistaMedio" name="revistaMedio" value="revista"> 
				    		<label for="revistaMedio">Revista</label>
				    		<br><br>
				    		
				    		<input type="checkbox" id="eventoMedio" name="eventoMedio" value="evento"> 
				    		<label for="eventoMedio">Evento</label>
						</td>
						<td colspan="2" align="left">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;
				    		<input type="checkbox" id="plazasComMedio" name="plazasComMedio" value="plazasComerciales"> 
				    		<label for="plazasComMedio">Plazas Comerciales</label>
				    		<br><br>
				    	&nbsp;&nbsp;&nbsp;&nbsp;
				    	&nbsp;&nbsp;&nbsp;&nbsp;
				    		<input type="checkbox" id="redesSocMedio" name="redesSocMedio" value="redesSociales"> 
				    		<label for="redesSocMedio">Redes Sociales</label>
				    		<br><br>
				    	&nbsp;&nbsp;&nbsp;&nbsp;
				    	&nbsp;&nbsp;&nbsp;&nbsp;	
				    		<input type="checkbox" id="pagwebMedio" name="pagwebMedio" value="website"> 
				    		<label for="pagwebMedio">Página Web</label>
				    		<br><br>
				    	&nbsp;&nbsp;&nbsp;&nbsp;
				    	&nbsp;&nbsp;&nbsp;&nbsp;
				    		<input type="checkbox" id="sanalMedio" name="sanalMedio" value="senalizacion"> 
				    		<label for="sanalMedio">Evento</label>
						</td>
						<td colspan="2" align="left" style="font-size: 1em;border-bottom:1px solid #0c368b">
				    		<input type="checkbox" id="espectMedio" name="espectMedio" value="espectacular"> 
				    		<label for="espectMedio">Espectacular</label>
				    		<br><br><br><br><br>
				    		
				    		<label>Otro:</label>
				    		<br><br>
				    		<b>Estadio Corregidora GB</b>
						</td>
					</tr>
				
					';
			}
		$html .='
					<tr><td colspan="8"></td></tr>	
					<tr>
						<td colspan="8" align="left">
							<label>¿TIENE ALGUNA DUDA RESPECTO AL PRODUCTO, O COMENTARIO QUE NOS PUEDA
							AYUDAR A MEJORAR EL SERVICIO O EXPERIENCIA DE COMPRA?:</label>
						</td>
					</tr>
					<tr>
						<td colspan="8" style="font-size: 1em;border-bottom:1px solid #0c368b">
							<p style="text-align: justify">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
								exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure 
								dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
								 Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
								 mollit anim id est laborum.
							</p>
						</td>
					</tr>    
                            </table>
                                  <body>
            </html>
                                  ';

			$pdf->writeHTMLCell(0, 0, $x = '', $y = '10', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);ob_end_clean();
			$pdf->Output(utf8_decode("Informacion_erik-alan.pdf"), 'I');
		/*}*/
	}

    public function checkProspectValidity(){
        echo json_encode($this->Clientes_model->checkProspectValidity()->result_array());
    }

    public function consultStatistics(){
        $datos=array();
        $datos['tprospectos'] = $this->Statistics_model->getProspectsNumber()->result();
        $datos['pvigentes'] = $this->Statistics_model->getCurrentProspectsNumber()->result();
        $datos['pnovigentes'] = $this->Statistics_model->getNonCurrentProspectsNumber()->result();
        $datos['tclientes'] = $this->Statistics_model->getClientsNumber()->result();
        $datos['monthlyProspects'] = $this->Statistics_model->getMonthlyProspects()->result();
        $datos['dataSlp'] = $this->Statistics_model->getDataPerSede(1)->result();
        $datos['dataQro'] = $this->Statistics_model->getDataPerSede(2)->result();
        $datos['dataPen'] = $this->Statistics_model->getDataPerSede(3)->result();
        $datos['dataCdmx'] = $this->Statistics_model->getDataPerSede(4)->result();
        $datos['dataLeo'] = $this->Statistics_model->getDataPerSede(5)->result();
        $datos['dataCan'] = $this->Statistics_model->getDataPerSede(6)->result();
        $this->load->view('template/header');
        $this->load->view("clientes/consult_statistics", $datos);
    }

    public function getAuthorizationsBySubdirector(){
        $data['data'] = $this->Clientes_model->getAuthorizationsBySubdirector();
        echo json_encode($data);
    }

    public function getClubMaderasSales(){
        $data['data'] = $this->Clientes_model->getClubMaderasSales();
        echo json_encode($data);
    }

    public function getAuthorizationsByDirector()
    {
        $data['data'] = $this->Clientes_model->getAuthorizationsByDirector();
        echo json_encode($data);
    }

    public function getAuthorizationDetails($idLote)
    {
        $data = $this->Clientes_model->getAuthorizationDetails($idLote);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getProspectingPlaces(){
        echo json_encode($this->Clientes_model->getProspectingPlaces()->result_array());
    }

    public function getNationality(){
        echo json_encode($this->Clientes_model->getNationality()->result_array());
    }

    public function getCAPListByAdvisor(){
        echo json_encode($this->Clientes_model->getCAPListByAdvisor()->result_array());
    }

    public function getAdvisersMktd(){
        echo json_encode($this->Clientes_model->getAdvisersMktd()->result_array());
    }

    public function getKinship(){
        echo json_encode($this->Clientes_model->getKinship()->result_array());
    }

    public function getStatusMktd(){
        echo json_encode($this->Clientes_model->getStatusMktd()->result_array());
    }

    public function getLegalPersonality(){
        echo json_encode($this->Clientes_model->getLegalPersonality()->result_array());
    }

    public function getAdvertising(){
        echo json_encode($this->Clientes_model->getAdvertising()->result_array());
    }

    public function getSalesPlaza(){
        echo json_encode($this->Clientes_model->getSalesPlaza()->result_array());
    }

    public function getCivilStatus(){
        echo json_encode($this->Clientes_model->getCivilStatus()->result_array());
    }

    public function getMatrimonialRegime(){
        echo json_encode($this->Clientes_model->getMatrimonialRegime()->result_array());
    }

    public function getState(){
        echo json_encode($this->Clientes_model->getState()->result_array());
    }

    public function getProspectsList($typeTransaction){
	    /*
	     *  0  MKTD
	     *  1   VETNAS
	     */
        if (isset($_POST) || !empty($_POST) || $typeTransaction!='') {
            $transaction = ($this->input->post("transaction") == '') ? $typeTransaction : 0;
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");

            if ($typeTransaction == 1) {
                $data['data'] = $this->Clientes_model->getProspectsList($transaction, $beginDate, $endDate, $where)->result_array();
            } elseif ($typeTransaction == 0) {
                $data['data'] = $this->Clientes_model->getProspectsListMktd($transaction, $beginDate, $endDate, $where)->result_array();
            }
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function getProspectsReport() {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsReport($typeTransaction, $beginDate, $endDate, $where)->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function getProspectsSalesTeam(){
        $data['data'] = $this->Clientes_model->getProspectsSalesTeam()->result_array();
        echo json_encode($data);
    }

    public function getClientsList(){
        $data['data'] = $this->Clientes_model->getClientsList()->result_array();
        echo json_encode($data);
    }

    public function getSharedSalesList(){
	    $data['data'] = $this->Clientes_model->getSharedSalesList()->result_array();
        echo json_encode($data);
    }

    public function getSharedSalesListTitular(){
        $data['data'] = $this->Clientes_model->getSharedSalesListTitular()->result_array();
        echo json_encode($data);
    }

    public function getCoOwnersList(){
        $data['data'] = $this->Clientes_model->getCoOwnersList()->result_array();
        echo json_encode($data);
    }

    public function getReferencesList(){
        $data['data'] = $this->Clientes_model->getReferencesList()->result_array();
        echo json_encode($data);
    }

    public function getManagersMktd(){
        echo json_encode($this->Clientes_model->getManagersMktd()->result_array());
    }

    public function getManagers(){
        echo json_encode($this->Clientes_model->getManagers()->result_array());
    }

    public function getCoordinatorsByManager($id_gerente){
        echo json_encode($this->Clientes_model->getCoordinatorsByManager($id_gerente)->result_array());
    }

    public function getAdvisersByCoordinator($id_coordinador){
        echo json_encode($this->Clientes_model->getAdvisersByCoordinator($id_coordinador)->result_array());
    }

    public function getCoordinators(){
        echo json_encode($this->Clientes_model->getCoordinators()->result_array());
    }

    public function getProspects(){
        echo json_encode($this->Clientes_model->getProspects()->result_array());
    }

    public function getAllAdvisers(){
        echo json_encode($this->Clientes_model->getAllAdvisers()->result_array());
    }

    public function getAdvisers($id_sede){
        echo json_encode($this->Clientes_model->getAdvisers($id_sede)->result_array());
    }

    public function getAdvisersM(){
        echo json_encode($this->Clientes_model->getAdvisersM()->result_array());
    }

    public function getProspectInformation($id_prospecto){
        echo json_encode($this->Clientes_model->getProspectInformation($id_prospecto)->result_array());
    }

    public function getReferenceInformation($id_referencia){
        echo json_encode($this->Clientes_model->getReferenceInformation($id_referencia)->result_array());
    }

    public function getCoOwnerInformation($id_copropietario){
        echo json_encode($this->Clientes_model->getCoOwnerInformation($id_copropietario)->result_array());
    }

    public function getInformationToPrint($id_prospecto){
        echo json_encode($this->Clientes_model->getInformationToPrint($id_prospecto)->result_array());
    }

    public function getComments($id_prospecto){
        echo json_encode($this->Clientes_model->getComments($id_prospecto)->result_array());
    }

    public function getChangelog($id_prospecto){
        echo json_encode($this->Clientes_model->getChangelog($id_prospecto)->result_array());
    }

    public function saveComment(){
        if(isset($_POST) && !empty($_POST)){
            $response = $this->Clientes_model->saveComment($this->session->userdata('id_usuario'),$this->input->post("id_prospecto"),$this->input->post("observations"));
            echo json_encode($response);
        }
    }

    public function saveSalesPartner(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "id_prospecto" => $this->input->post("prospecto"),
                "id_asesor" => $this->input->post("asesor"),
                "id_coordinador" => $this->input->post("id_coordinador"),
                "id_gerente" => $this->input->post("id_gerente"),
                "estatus" => 1,
                "fecha_creacion" => date("Y-m-d H:i:s"),
                "creado_por" => $this->session->userdata('id_usuario'),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Clientes_model->saveSalesPartner($data);
            echo json_encode($response);
        }
    }

    public function saveReference(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "id_prospecto" => $this->input->post("prospecto"),
                "nombre" => $this->input->post("name"),
                "telefono" => $this->input->post("phone_number"),
                "parentesco" => $this->input->post("kinship"),
                "estatus" => 1,
                "fecha_creacion" => date("Y-m-d H:i:s"),
                "creado_por" => $this->session->userdata('id_usuario'),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Clientes_model->saveReference($data);
            echo json_encode($response);
        }
    }

    public function saveCoOwner(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "id_cliente" => $_POST['id_cliente'],
                "nacionalidad" => $_POST['nacionalidad'],
                "personalidad_juridica" => $_POST['personalidad_juridica'],
                "curp" => $_POST['curp'],
                "rfc" => $_POST['rfc'],
                "estatus" => 1,
                "nombre" => $_POST['nombre'],
                "apellido_paterno" => $_POST['apellido_paterno'],
                "apellido_materno" => $_POST['apellido_materno'],
                "correo" => $_POST['correo'],
                "telefono" => $_POST['telefono'],
                "telefono_2" => $_POST['telefono_2'],
                "fecha_creacion" => date("Y-m-d H:i:s"),
                "creado_por" => $this->session->userdata('id_usuario'),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "fecha_nacimiento" => $_POST['fecha_nacimiento'],
                "estado_civil" => $_POST['estado_civil'],
                "regimen_matrimonial" => $_POST['regimen_matrimonial'],
                "conyuge" => $_POST['conyuge'],
                "domicilio_particular" => $_POST['domicilio_particular'],
                "originario_de" => $_POST['originario_de'],
                "tipo_vivienda" => $_POST['tipo_vivienda'],
                "ocupacion" => $_POST['ocupacion'],
                "empresa" => $_POST['empresa'],
                "posicion" => $_POST['posicion'],
                "antiguedad" => $_POST['antiguedad'],
                "direccion" => $_POST['direccion'],
                "edadFirma" => $_POST['edadFirma'],
            );
            $response = $this->Clientes_model->saveCoOwner($data);
            echo json_encode($response);
        }
    }

    public function updateCoOwner(){
        if(isset($_POST) && !empty($_POST)){
            $id_copropietario = $this->session->userdata('id_usuario');
            $data = array(
                "id_copropietario" => $_POST['id_copropietario'],
                "nacionalidad" => $_POST['nacionalidad'],
                "personalidad_juridica" => $_POST['personalidad_juridica'],
                "curp" => $_POST['curp'],
                "rfc" => $_POST['rfc'],
                "estatus" => 1,
                "nombre" => $_POST['nombre'],
                "apellido_paterno" => $_POST['apellido_paterno'],
                "apellido_materno" => $_POST['apellido_materno'],
                "correo" => $_POST['correo'],
                "telefono" => $_POST['telefono'],
                "telefono_2" => $_POST['telefono_2'],
                "fecha_creacion" => date("Y-m-d H:i:s"),
                "creado_por" => $this->session->userdata('id_usuario'),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "fecha_nacimiento" => $_POST['fecha_nacimiento'],
                "estado_civil" => $_POST['estado_civil'],
                "regimen_matrimonial" => $_POST['regimen_matrimonial'],
                "conyuge" => $_POST['conyuge'],
                "domicilio_particular" => $_POST['domicilio_particular'],
                "originario_de" => $_POST['originario_de'],
                "tipo_vivienda" => $_POST['tipo_vivienda'],
                "ocupacion" => $_POST['ocupacion'],
                "empresa" => $_POST['empresa'],
                "posicion" => $_POST['posicion'],
                "antiguedad" => $_POST['antiguedad'],
                "direccion" => $_POST['direccion'],
                "edadFirma" => $_POST['edadFirma'],
            );
            $response = $this->Clientes_model->updateCoOwner($data, $id_copropietario);
            echo json_encode($response);
        }
    }

    public function updateValidity(){
        $id_prospecto = $this->input->post("id_prospecto");
        $prospectInformation =  $this->Clientes_model->getProspectInformation($id_prospecto)->result_array();
        $data = array(
            "fecha_vencimiento" => date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")."+ 30 days")),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "estatus" => 1, 
            "vigencia" => $prospectInformation[0]['vigencia'] + 1
        );
        if(isset($_POST) && !empty($_POST)){
            $response = $this->Clientes_model->updateValidity($data, $id_prospecto);
            echo json_encode($response);
        }
    }

    public function updateStatus(){
        $data = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "estatus_particular" => $this->input->post("estatus_particular")
        );
        $response = $this->Clientes_model->updateProspect($data, $this->input->post("id_prospecto_estatus_particular"));
        echo json_encode($response);
    }

    
    public function changeSalesPartnerStatus(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "estatus" => $this->input->post("estatus"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Clientes_model->changeSalesPartnerStatus($data, $this->input->post("id_vcompartida"));
            echo json_encode($response);
        }
    }

    public function changeTitular(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "id_asesor" => $this->input->post("id_asesor"),
                "id_cooridnador" => $this->input->post("id_coordinador"),
                "id_gerente" => $this->input->post("id_gerente"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Clientes_model->changeTitular($data, $this->input->post("id_cliente"));
            echo json_encode($response);
        }
    }

    public function changeCoOwnerStatus(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "estatus" => $this->input->post("estatus"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Clientes_model->changeCoOwnerStatus($data, $this->input->post("id_copropietario"));
            echo json_encode($response);
        }
    }

    public function changeReferenceStatus(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "estatus" => $this->input->post("estatus"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Clientes_model->changeReferenceStatus($data, $this->input->post("id_referencia"));
            echo json_encode($response);
        }
    }

    public function reasignProspect()
    {
        $request_type = $_POST['request_type'];
        $id_prospect = $this->input->post("id_prospecto_re_asign");
        // ARRAY WITH COMMON DATA TO UPDATE PROSPECT INFORMATION
        $data = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        // ARRAY WITH COMMON DATA TO INSERT SALES PARTNER INFORMATION
        $data_spi = array(
            "id_prospecto" => $id_prospect,
            "estatus" => 1,
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        $id_asesor = $_POST['id_asesor'];
        if (in_array($this->session->userdata('id_rol'), array("19", "20"))) {
            $rol = $this->Clientes_model->getRole($id_asesor)->row();
            // SE BUSCAN TODOS LOS REGISTROS ACTIVOS ASOCIADOS A ESTE PROSPECTO EN LA TBL SALES_PARTNER_ING
            $dato = $this->Clientes_model->getSalesPartnerRecords($id_prospect);
            if (COUNT($dato) > 0) { // RECORDS FOUND TO DEACTIVATE
                // ARRAY DATA TO UPDATE SALES PARTNER RECORD
                $data2 = array(
                    "estatus" => 0,
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );
                // CYCLE THAT UPDATES STATUS BY RECORD FOUND
                for ($i = 0; $i < COUNT($dato); $i++) {
                    $this->Clientes_model->updateSalesPartnerInfo($data2, $dato[$i]['id_sale']);
                }
            }
            if ($rol->id_rol == 7) { // IS ASESOR
                $informacion = $this->Clientes_model->getLeadersByAdviser($id_asesor)->row();
            } else if ($rol->id_rol == 9) { // IS COORDINADOR
                $informacion = $this->Clientes_model->getLeadersByCoordinator($id_asesor)->row();
            } else if ($rol->id_rol == 20) { // IS GERENTE
                $informacion = $this->Clientes_model->getLeadersByAdviser($id_asesor)->row();
            }
            $data_spi["id_asesor"] = $id_asesor;
            $data_spi["id_coordinador"] = $informacion->id_coordinador == $id_asesor ? 0 : $informacion->id_coordinador;
            $data_spi["id_gerente"] = $informacion->id_gerente;
            $data_spi["tipo"] = 2; // VENTAS INFORMATION
            $this->Clientes_model->saveSalesPartnerInfo($data_spi);
            if ($request_type == 1) { // IS SUBDIRECTOR MKTD
                $data["id_asesor"] = $id_asesor;
                $data["id_coordinador"] = $_POST['id_gerente'];
            } else if ($request_type == 2) { // IS GERENTE MKTD
                $data["id_asesor"] = $_POST['id_asesor'];
            }

        } else {
            if ($request_type == 3) { // IS ASISTENTE OR GERENTE VENTAS
                // IF THE PROSPECT IS MKTD, INSERT RECORD IN SALES PARTNER INFORMATION TABLE
                $data["id_asesor"] = $id_asesor;
                $data["id_coordinador"] = $_POST['id_coordinador'];
                $data["id_gerente"] = $_POST['id_gerente'];
            }
        }
        $response = $this->Clientes_model->updateProspect($data, $id_prospect);
        echo json_encode($response);
    }

    public function updateProspect()
    {
        $data = array(
            "nacionalidad" => $_POST['nationality'],
            "personalidad_juridica" => $_POST['legal_personality'],
            "curp" => $_POST['curp'],
            "rfc" => $_POST['rfc'],
            "apellido_paterno" => $_POST['last_name'],
            "apellido_materno" => $_POST['mothers_last_name'],
            "correo" => $_POST['email'],
            "telefono_2" => $_POST['phone_number2'],
            "plaza_venta" => $_POST['sales_plaza'],
            "observaciones" => $_POST['observation'],
            "fecha_nacimiento" => $_POST['date_birth'],
            "estado_civil" => $_POST['civil_status'],
            "regimen_matrimonial" => (isset($_POST['matrimonial_regime']) ? $_POST['matrimonial_regime']:5),
            "conyuge" => $_POST['spouce'],
            "domicilio_particular" => $_POST['home_address'],
            "originario_de" => $_POST['from'],
            "tipo_vivienda" => $_POST['lives_at_home'],
            "ocupacion" => $_POST['occupation'],
            "empresa" => $_POST['company'],
            "posicion" => $_POST['position'],
            "antiguedad" => $_POST['antiquity'],
            "direccion" => $_POST['company_residence'],
            "edadFirma" => $_POST['company_antiquity'],
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        if ((($this->session->userdata('id_usuario') == $_POST['owner']) && (($_POST['source']!=0 || $_POST['source']!=null) && $_POST['editProspecto']==0) )) {
            $data["nombre"] = $_POST['name'];
            $data["editProspecto"]= 1;
        }
        $response = $this->Clientes_model->updateProspect($data, $this->input->post("id_prospecto_ed"));
        echo json_encode($response);
    }

    public function updateReference(){
        $data = array(
            "id_prospecto" => $_POST['prospecto_ed'],
            "parentesco" => $_POST['kinship_ed'],
            "nombre" => $_POST['name_ed'],
            "telefono" => $_POST['phone_number_ed'],
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        $response = $this->Clientes_model->updateReference($data, $this->input->post("id_referencia"));
        echo json_encode($response);
    }

    public function saveProspect() {
        $cambio = 0;
        if (!isset($_POST['lives_at_home']))
            $cambio = 6;
        else
            $cambio = $_POST['lives_at_home'];

        $specify = $_POST['specify'];
        if ($specify == '' || $specify == null)
            $final_specification = 0;
        else
            $final_specification = $specify;
        
        $date = date("Y-m-d");
        $date = strtotime($date . "+ 30 days");
        $data = array(
            "nacionalidad" => $_POST['nationality'],
            "personalidad_juridica" => $_POST['legal_personality'],
            "curp" => $_POST['curp'],
            "rfc" => $_POST['rfc'],
            "tipo" => 0,
            "estatus" => 1,
            "nombre" => $_POST['name'],
            "apellido_paterno" => $_POST['last_name'],
            "apellido_materno" => $_POST['mothers_last_name'],
            "correo" => $_POST['email'],
            "telefono" => $_POST['phone_number'],
            "telefono_2" => $_POST['phone_number2'],
            "lugar_prospeccion" => $_POST['prospecting_place'],
            "otro_lugar" => $final_specification,
            "tipo_recomendado" => $_POST['type_recomendado'],
            "plaza_venta" => $_POST['sales_plaza'],
            "observaciones" => $_POST['observations'],
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "fecha_vencimiento" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "+ 30 days")),
            "fecha_nacimiento" => $_POST['date_birth'],
            "estado_civil" => $_POST['civil_status'],
            "regimen_matrimonial" => (isset($_POST['matrimonial_regime']) ? $_POST['matrimonial_regime']:5),
            "conyuge" => $_POST['spouce'],
            "domicilio_particular" => $_POST['home_address'],
            "originario_de" => $_POST['from'],
            "tipo_vivienda" => $cambio,
            "ocupacion" => $_POST['occupation'],
            "empresa" => $_POST['company'],
            "posicion" => $_POST['position'],
            "antiguedad" => $_POST['antiquity'],
            "direccion" => $_POST['company_residence'],
            "edadFirma" => $_POST['company_antiquity']
        );
        $data_spi = array(
            "estatus" => 1,
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        $data["id_sede"] = $this->session->userdata('id_sede');
        if($this->session->userdata('id_rol') == 7) {
            //ASESOR
            if($this->session->userdata('id_lider') == 832){
                $data["id_asesor"] = $this->session->userdata('id_usuario');
                $data["id_coordinador"] = $this->session->userdata('id_lider');
                $data["id_gerente"] = $this->session->userdata('id_lider');
                $data["id_subdirector"] = $this->session->userdata('id_lider_3');
                $data["id_regional"] = $this->session->userdata('id_lider_5');
                $data["id_regional_2"] = $this->session->userdata('id_regional_2');

            } else {
                $data["id_asesor"] = $this->session->userdata('id_usuario');
                $data["id_coordinador"] = $this->session->userdata('id_lider');
                $data["id_gerente"] = $this->session->userdata('id_lider_3');
                $data["id_subdirector"] = $this->session->userdata('id_lider_4');
                $data["id_regional"] = $this->session->userdata('id_lider_5');
                $data["id_regional_2"] = $this->session->userdata('id_regional_2');
            }
        } else if($this->session->userdata('id_rol') == 9) {
            //COORDIDADOR
            $data["id_asesor"] = $this->session->userdata('id_usuario');
            $data["id_coordinador"] = $this->session->userdata('id_usuario');
            $data["id_gerente"] = $this->session->userdata('id_lider');
            $data["id_subdirector"] = $this->session->userdata('id_lider_3');
            $data["id_regional"] = $this->session->userdata('id_lider_4');
            $data["id_regional_2"] = $this->session->userdata('id_regional_2');
        } else if($this->session->userdata('id_rol') == 3) {
            //GERENTE
            $data["id_asesor"] = $this->session->userdata('id_usuario');
            $data["id_coordinador"] = $this->session->userdata('id_usuario');
            $data["id_gerente"] = $this->session->userdata('id_usuario');
            $data["id_subdirector"] = $this->session->userdata('id_lider_4');
            $data["id_regional"] = $this->session->userdata('id_lider_5');
            $data["id_regional_2"] = $this->session->userdata('id_regional_2');
        }
        if ($_POST['prospecting_place'] == 6) {
            $rol = $this->Clientes_model->getRole($this->session->userdata('id_usuario'))->row();
            $informacion = $this->Clientes_model->getLeadersBySede($rol->id_sede)->row();
            $data_spi["id_asesor"] = $this->session->userdata('id_usuario');
            if($informacion) { // TIENE DATOS
                $data_spi["id_coordinador"] = $informacion->id_coordinador == $this->session->userdata('id_usuario') ? 0 : $informacion->id_coordinador;
                $data_spi["id_gerente"] = $informacion->id_gerente;
            } else { // NO TIENE DATOS
                $informacion2 = $this->Clientes_model->getVicePrincipal($rol->id_sede)->row();
                $data_spi["id_coordinador"] = $informacion2->id_coordinador;
                $data_spi["id_gerente"] = $informacion2->id_gerente;
            }
            $data_spi["tipo"] = 1; // MAKETING DIGITAL INFORMATION
            $response = $this->Clientes_model->saveProspectMktd($data, $data_spi);
        } else
            $response = $this->Clientes_model->saveProspect($data);
        echo json_encode($response);
    }

    public function printProspectInfoMktd($id_prospecto)
    {
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('INFORMACIÓN GENERAL DE PROSPECCIÓN');
        $pdf->SetSubject('Información personal de prospecto / cliente (CRM)');
        $pdf->SetKeywords('CRM, INFROMACION, PERSONAL, PROSPECTO');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(7, 10, 10, true);
        $pdf->AddPage('P', 'LETTER');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();
        $informacion = $this->Clientes_model->getPrintableInformation($id_prospecto)->row();
        $informacion_lugar = $this->Clientes_model->getProspectSpecification($id_prospecto)->row();

        $rol = $this->Clientes_model->getRole($informacion->id_gerente)->row();

        if (in_array($rol->id_rol, array("7", "9", "3", "2"))) { // EN LA TABLA DE PROSPECTOS ESTÁN REGISTRADOS LOS DATOS DE VENTAS
            $informacion_ventas["coordinador"] = $informacion->coordinador;
            $informacion_ventas["telefono_coordinador"] = $informacion->telefono_coordinador;
            $informacion_ventas["gerente"] = $informacion->gerente;
            $informacion_ventas["telefono_gerente"] = $informacion->telefono_gerente;
            // BUSCO LOS DATOS DE MKTD (1) EN LA TABLA DE SALES PARTNER INFORMATION
            $informacion_mktd_data = $this->Clientes_model->getSalesPartnerInformation($id_prospecto, 1)->row();
            $informacion_mktd["coordinador"] = $informacion_mktd_data->coordinador;
            $informacion_mktd["telefono_coordinador"] = $informacion_mktd_data->telefono_coordinador;
            $informacion_mktd["gerente"] = $informacion_mktd_data->gerente;
            $informacion_mktd["telefono_gerente"] = $informacion_mktd_data->telefono_gerente;


        } else { // EN LA TABLA DE PROSPECTOS ESTÁN REGISTRADOS LOS DATOS DE MKTD
            $informacion_mktd["coordinador"] = $informacion->coordinador;
            $informacion_mktd["telefono_coordinador"] = $informacion->telefono_coordinador;
            $informacion_mktd["gerente"] = $informacion->gerente;
            $informacion_mktd["telefono_gerente"] = $informacion->telefono_gerente;
            // BUSCO LOS DATOS DE VENTAS (2) EN LA TABLA DE SALES PARTNER INFORMATION
            $informacion_ventas_data = $this->Clientes_model->getSalesPartnerInformation($id_prospecto, 2)->row();
            $informacion_ventas["coordinador"] = $informacion_ventas_data->coordinador;
            $informacion_ventas["telefono_coordinador"] = $informacion_ventas_data->telefono_coordinador;
            $informacion_ventas["gerente"] = $informacion_ventas_data->gerente;
            $informacion_ventas["telefono_gerente"] = $informacion_ventas_data->telefono_gerente;
        }

        if ($informacion) {
            $html = '
            <!DOCTYPE html>
            <html lang="es_mx"  ng-app="CRM">
        <head>
            <style>
            legend {
                background-color: #296D5D;
                color: #fff;
            }           
            </style>
        </head>
        <body>
              <section class="content">
                    <div class="row">
                        <div class="col-xs-10 col-md-offset-1">
                        <div class="box">
                            <div class="box-body">
                                  <table width="100%" style="height: 100px; border: 1px solid #ddd;" width="690">
                                    <tr>
                                        <td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
                                        <td colspan="2" align="right"><b style="font-size: 2em; "> Información<BR></b><small style="font-size: 2em; color: #777;"> Prospecto</small> 
                                        </td>
                                    </tr>
                                </table>
                                
                                <br><br>
                                  <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                                    <tr>
                                        <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos generales</b>
                                        </td>
                                    </tr>
                                </table>                            
                                <br>                       
                                    <div class="row">                
                                  <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                        <tr>
                                            <td style="font-size: 1em;">
                                             <b>Nombre:</b><br>
                                             ' . $informacion->cliente . '
                                            </td>
                                            <td style="font-size: 1em;">
                                            <b>CURP:</b><br>
                                            ' . $informacion->curp . '
                                            </td>
                                            <td style="font-size: 1em;">
                                            <b>RFC:</b><br>
                                            ' . $informacion->rfc . '
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="font-size: 1em;">
                                             <b>Correo electrónico:</b><br>
                                             ' . $informacion->correo . '
                                            </td>
                                            <td style="font-size: 1em;">
                                            <b>Teléfono:</b><br>
                                            ' . $informacion->telefono . '
                                            </td>
                                            <td style="font-size: 1em;">
                                            <b>Teléfono 2 (opcional):</b><br>
                                            ' . $informacion->telefono_2 . '
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="font-size: 1em;">
                                             <b>Personalidad jurídica:</b><br>
                                             ' . $informacion->personalidad . '
                                            </td>
                                            <td style="font-size: 1em;">
                                            <b>Nacionalidad:</b><br>
                                            ' . $informacion->nacionalidad . '
                                            </td>

                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <br>
            
            
                                  <table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
                                    <tr>
                                        <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos de prospección</b>
                                        </td>
                                    </tr>
                                </table>                            
                                <br><br>
                                <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                <tr>
                                    <td rowspan="4" style="font-size: 1em; margin-top:5px;">
                                    <br><br><br><br><br><br><br>
                                     <b>Asesor:</b><br>
                                     ' . $informacion->asesor . '<br><br>
                                     <b>Teléfono asesor:</b><br>
                                    ' . $informacion->telefono_asesor . '
                                    </td>
                                    <td colspan="2" style="padding: 3px 6px; "><b style="font-size: 1.2em; ">Ventas</b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 1em;">
                                    <b>Coordinador:</b><br>
                                    ' . $informacion_ventas["coordinador"] . '<br><br>
                                    <b>Teléfono coordinador:</b><br>
                                    ' . $informacion_ventas["telefono_coordinador"] . '
                                    </td> 
                                    <td style="font-size: 1em;">
                                    <b>Gerente:</b><br>
                                    ' . $informacion_ventas["gerente"] . '<br><br>
                                    <b>Teléfono gerente:</b><br>
                                    ' . $informacion_ventas["telefono_gerente"] . '
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding: 3px 6px; "><b style="font-size: 1.2em; ">Marketing digital</b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 1em;">
                                    <b>Gerente:</b><br>
                                    ' . $informacion_mktd["coordinador"] . '<br><br>
                                    <b>Teléfono gerente:</b><br>
                                    ' . $informacion_mktd["telefono_coordinador"] . '
                                    </td> 
                                    <td style="font-size: 1em;">
                                    <b>Subdirector:</b><br>
                                    ' . $informacion_mktd["gerente"] . '<br><br>
                                    <b>Teléfono subdirector:</b><br>
                                    ' . $informacion_mktd["telefono_gerente"] . '
                                    </td>
                                </tr>
                                </table>
                                <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                <tr>
                                    <td style="font-size: 1em;">
                                    <b>Lugar:</b><br>
                                    ' . $informacion->lugar . '<br>
                                    ' . $informacion_lugar->especificar . '
                                    </td> 
                                    <td style="font-size: 1em;">
                                    <b>Plaza de venta:</b><br>
                                    ' . $informacion->plaza . '
                                    </td>
                                    <td style="font-size: 1em;">
                                    <b>Creado por:</b><br>
                                    ' . $informacion->creacion . '
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <br>
                                  <body>
            </html>
                                  ';

            $pdf->writeHTMLCell(0, 0, $x = '', $y = '10', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            ob_end_clean();
            $pdf->Output(utf8_decode("Informacion_" . $informacion->cliente . ".pdf"), 'I');
            /*$pdf = 'testfile.pdf';
            $save = 'output.jpg';
            exec('convert "'.$pdf.'" -colorspace RGB -resize 800 "'.$save.'"', $output, $return_var);*/
        }
    }

    public function printProspectInfo($id_prospecto){
        $this->load->library('Pdf');
        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
        $pdf->SetTitle('INFORMACIÓN GENERAL DE PROSPECCIÓN');
        $pdf->SetSubject('Información personal de prospecto / cliente (CRM)');
        $pdf->SetKeywords('CRM, INFROMACION, PERSONAL, PROSPECTO');
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, 0);
        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter();
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(7, 10, 10, true);
        $pdf->AddPage('P', 'LETTER');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();
        $informacion = $this->Clientes_model->getPrintableInformation($id_prospecto)->row();
        $informacion_lugar = $this->Clientes_model->getProspectSpecification($id_prospecto)->row();
        if($informacion){
            $html = '
            <!DOCTYPE html>
            <html lang="es_mx"  ng-app="CRM">
        <head>
            <style>
            legend {
                background-color: #296D5D;
                color: #fff;
            }           
            </style>
        </head>
        <body>
            <section class="content">
                <div class="row">
                    <div class="col-xs-10 col-md-offset-1">
                        <div class="box">
                            <div class="box-body">
                                <table width="100%" style="height: 100px; border: 1px solid #ddd;" width="690">
                                    <tr>
                                        <td colspan="2" align="left"><img src="https://www.ciudadmaderas.com/assets/img/logo.png" style=" max-width: 70%; height: auto;"></td>
                                        <td colspan="2" align="right"><b style="font-size: 2em; "> Información<BR></b><small style="font-size: 2em; color: #777;"> Prospecto</small></td>
                                    </tr>
                                </table>
                                <br><br>
                                <table width="100%" style="padding:10px 0px; text-align: center;height: 45px; border: 1px solid #ddd;" width="690">
                                    <tr>
                                        <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos generales</b></td>
                                    </tr>
                                </table>							
                                <br>                       
                                <div class="row">                
                                    <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                        <tr>
                                            <td style="font-size: 1em;">
                                                <b>Nombre:</b><br>
                                                '.$informacion->cliente.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>CURP:</b><br>
                                                '.$informacion->curp.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>RFC:</b><br>
                                                '.$informacion->rfc.'
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td style="font-size: 1em;">
                                                <b>Correo electrónico:</b><br>
                                                '.$informacion->correo.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>Teléfono:</b><br>
                                                '.$informacion->telefono.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>Teléfono 2 (opcional):</b><br>
                                                '.$informacion->telefono_2.'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 1em;">
                                                <b>Personalidad jurídica:</b><br>
                                                '.$informacion->personalidad.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>Nacionalidad:</b><br>
                                                '.$informacion->nacionalidad.'
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <br>                       
                                    <table width="100%" style="text-align: center;padding:10px;height: 45px; border-top: 1px solid #ddd;border-left: 1px solid #ddd;border-right: 1px solid #ddd;" width="690">
                                        <tr>
                                            <td colspan="2" style="background-color: #15578B;color: #fff;padding: 3px 6px; "><b style="font-size: 2em; ">Datos de prospección</b>
                                            </td>
                                        </tr>
                                    </table>							
                                    <br><br>                                  
                                    <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                        <tr>
                                            <td style="font-size: 1em;">
                                                <b>Asesor:</b><br>
                                                '.$informacion->asesor.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>Coordinador:</b><br>
                                                '.$informacion->coordinador.'
                                            </td> 
                                            <td style="font-size: 1em;">
                                                <b>Gerente:</b><br>
                                                '.$informacion->gerente.'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 1em;">
                                                <b>Teléfono asesor:</b><br>
                                                '.$informacion->telefono_asesor.'
                                            </td>
                                                <td style="font-size: 1em;">
                                                <b>Teléfono coordinador:</b><br>
                                            '.$informacion->telefono_coordinador.'
                                            </td> 
                                                <td style="font-size: 1em;">
                                                <b>Teléfono gerente:</b><br>
                                            '.$informacion->telefono_gerente.'
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" style="padding:10px 3px;height: 45px; border: 1px solid #ddd; text-align: center;" width="690">
                                        <tr>
                                            <td style="font-size: 1em;">
                                                <b>Medio de contacto:</b><br>
                                                '.$informacion->lugar.'<br>
                                                '.$informacion_lugar->especificar.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>Plaza de venta:</b><br>
                                                '.$informacion->plaza.'
                                            </td>
                                            <td style="font-size: 1em;">
                                                <b>Creado por:</b><br>
                                                '.$informacion->creacion.'
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <br>
                                    <br>
            <body>
            </html>';

            $pdf->writeHTMLCell(0, 0, $x = '', $y = '10', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);ob_end_clean();
            $pdf->Output(utf8_decode("Informacion_".$informacion->cliente.".pdf"), 'I');
        }
    }


    public function saveBonificacion()
	{
		$nombreClienteRecomendado 	= $this->input->post('nombreClienteRecomendado');
		$apellidoPaterno 			= $this->input->post('apellidoPaterno');
		$apellidoMaterno 			= $this->input->post('apellidoMaterno');

		$proyectoClienteQueRecomendo = $this->input->post('proyectoRecomendado');
		$condominioClienteQueRecomendo = $this->input->post('condominioRecomendado');
		$loteClienteQueRecomendo = $this->input->post('loteRecomendado');

		$motivoCompra = $this->input->post('motivoCompra');


		/*datos cliente el cual recomendo al newvuo usuario*/
		$nombreClienteBonificar = $this->input->post('nombreClienteBonificar');
		$apellidoPaternoBonificar = $this->input->post('apellidoPaternoBonificar');
		$apellidoMaternoBonificar = $this->input->post('apellidoMaternoBonificar');

			/*lote cliente el cual recomendo al newvuo usuario*/
			/*si sabe el lote	*/
			$proyectoRecomendador = $this->input->post('proyectoRecomendador');
			$condominioRecomendador = $this->input->post('condominioRecomendador');
			$loteRecomendador = $this->input->post('loteRecomendador');
		/*Recomendado no es cliente maderass*/
		$medioEnterado= $this->input->post('medioEnterado');
		$medioEnteradoOtro= $this->input->post('medioEnteradoOtro');


		$dudaComentariosProcesoCompra= $this->input->post('dudaComentariosProcesoCompra');

		$data = array(
			'nombreClienteRecomendado' => $nombreClienteRecomendado,
			'apellidoPaterno' => $apellidoPaterno,
			'apellidoMaterno' => $apellidoMaterno,

			'proyectoClienteQueRecomendo' => $proyectoClienteQueRecomendo,
			'condominioClienteQueRecomendo' => $condominioClienteQueRecomendo,
			'loteClienteQueRecomendo' => $loteClienteQueRecomendo,
			'motivoCompra' => $motivoCompra,

			'nombreClienteBonificar' => $nombreClienteBonificar,
			'apellidoPaternoBonificar' => $apellidoPaternoBonificar,
			'apellidoMaternoBonificar' => $apellidoMaternoBonificar,

			'proyectoRecomendador' => $proyectoRecomendador,
			'condominioRecomendador' => $condominioRecomendador,
			'loteRecomendador' => $loteRecomendador,

			'medioEnterado' =>$medioEnterado ,
			'medioEnteradoOtro' =>$medioEnteradoOtro ,
			'dudaComentariosProcesoCompra' =>$dudaComentariosProcesoCompra

		);
		print_r($data);

	}


    public function validateSession()
    {
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
        {
            redirect(base_url() . "index.php/login");
        }
    }

    public function getEmpty()
    {
        $data = array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getSubdirs()
    {
        $data = $this->Clientes_model->getSubdirs();

        for($i=0; $i < count($data); $i++)
        {
            $porciones = explode(",", $data[$i]->id_sede);
            $data[$i]->id_sede = $porciones[0];
        }

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    public function getSubdirs_mkt()
    {
        $data = $this->Clientes_model->getSubdirs_mkt();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    public function getGerentesBySubdir($id_subdir)
    {
        $data = $this->Clientes_model->getGerentesBySubdir($id_subdir);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    public function getGerentesBySubdir_ASB()
    {
        $data = $this->Clientes_model->getGerentesBySubdir_ASB();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    public  function  getGerentesBySubdir_mkt($id_subdir)
    {
        $data = $this->Clientes_model->getGerentesBySubdir_mkt($id_subdir);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    public function getCoordsByGrs($id_gerente)
    {
        $data = $this->Clientes_model->getCoordsByGrs($id_gerente);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getAsesorByCoords($id_coords)
    {
        $data = $this->Clientes_model->getAsesorByCoords($id_coords);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getProspectsListBySubdir($id_sede)
    {
        $data['data'] = $this->Clientes_model->getProspectsListBySubdir($id_sede);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getProspectsListByGerente($id_gerente)
    {
    ini_set('max_execution_time', 900);
    set_time_limit(900);
    ini_set('memory_limit','2048M');
        if ($this->session->userdata('id_rol') == 19) { // IS SUBDIRECTOR MKTD
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $dato = $this->Clientes_model->getSedeByUser($id_gerente);
            $data = $this->Clientes_model->getProspectsListByGerente($dato[0]['id_sede'], $typeTransaction, $beginDate, $endDate, $where);
        } else {

            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->Clientes_model->getProspectsListByGerente($id_gerente, $typeTransaction, $beginDate, $endDate, $where);
        }
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getProspectsListByCoord($id_coord)
    {
        if ($this->session->userdata('id_rol') == 19) {
            $dato = $this->Clientes_model->getSedeByUser($id_coord);
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->Clientes_model->getProspectsListByCoord($dato[0]['id_sede'], $typeTransaction, $beginDate, $endDate, $where);
        } else {
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->Clientes_model->getProspectsListByCoord($id_coord, $typeTransaction, $beginDate, $endDate, $where);
        }
        
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getProspectsListByAsesor($id_asesor)
    {
        $typeTransaction = $this->input->post("typeTransaction");
        if($this->input->post("beginDate") != 0 && $this->input->post("endDate") != 0){
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->Clientes_model->getProspectsListByAsesor($id_asesor, $typeTransaction, $beginDate, $endDate, $where);
        }
        else{
            $data = $this->Clientes_model->getProspectsListByAsesor($id_asesor, $typeTransaction, 0, 0, 0);
        }
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    /********************/
    function getResultsProspectsSerch()
    {

    ini_set('max_execution_time', 900);
    set_time_limit(900);
    ini_set('memory_limit','2048M');

        $name_prospect = $this->input->post('nombre');
        $correo_prospect = $this->input->post('correo');
        $telefono_prospect = $this->input->post('telefono');
        $ap_paterno_prospect = $this->input->post('ap_paterno');
        $ap_materno_prospect = $this->input->post('ap_materno');


        if(!empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect) && empty($ap_paterno_prospect)
        && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByName($name_prospect);
        }
        if(empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect)  && empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByMail($correo_prospect);
        }
        if(empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect)  && empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByTel($telefono_prospect);
        }
        if(empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect)  && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByAp_Paterno($ap_paterno_prospect);
        }
        if(empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect)  && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByAp_Materno($ap_materno_prospect);
        }
        /**Telefono, ap_paterno, ap_materno vacío,  ----correo y nombre**/
        if(!empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByMailName($name_prospect, $correo_prospect);
        }
        /**correo, ap_paterno, ap_materno vacío,  ----nombre y telefono**/
        if(!empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameTel($name_prospect, $telefono_prospect);
        }
        /**nombre, ap_paterno, ap_materno vacío,  ----correo y telefono**/
        if(empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByMailTel($correo_prospect, $telefono_prospect);
        }
        /**correo, telefono, ap_materno vacío,  ----nombre y ap_paterno**/
        if(!empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameApPaterno($name_prospect, $ap_paterno_prospect);
        }
        /**correo, telefono, ap_paterno vacío,  ----nombre y ap_materno**/
        if(!empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameApMaterno($name_prospect, $ap_materno_prospect);
        }
        /**correo, telefono,  vacío, nombre---- ap_paterno y ap_materno**/
        if(empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApPaternoApMaterno($ap_paterno_prospect, $ap_materno_prospect);
        }
        /** ap_materno, telefono,  vacío, nombre---- ap_paterno y correo**/
        if(empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApPaternoCorreo($ap_paterno_prospect, $correo_prospect);
        }
        /** ap_materno, correo,  vacío, nombre---- ap_paterno y  telefono**/
        if(empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApPaternoTel($ap_paterno_prospect, $telefono_prospect);
        }
        /**  ap_paterno, telefono,  vacío, nombre----  ap_materno y  correo **/
        if(empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApMaternoMail($ap_materno_prospect, $correo_prospect);
        }
        /**  ap_paterno, correo,  vacío, nombre----  ap_materno y telefono  **/
        if(empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApMaternoTel($ap_materno_prospect, $telefono_prospect);
        }
        // buscar todos
        if(!empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByAllFiels($name_prospect, $correo_prospect, $telefono_prospect, $ap_paterno_prospect, $ap_materno_prospect);
        }
        /**correo, telefono  vacío, ---- nombre, ap_paterno y ap_materno**/
        if(!empty($name_prospect) && empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameApPaternoApMaterno($name_prospect, $ap_paterno_prospect, $ap_materno_prospect);
        }
        /** telefono  vacío, ---- nombre, ap_paterno y ap_materno, correo**/
        if(!empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameApPaternoApMaternoCorreo($name_prospect, $ap_paterno_prospect, $ap_materno_prospect, $correo_prospect);
        }
        /*********combs telefono********/
        /** telefono  vacío, ---- nombre, ap_paterno y ap_materno, correo**/
        if(empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByTelCorreoApMaterno($telefono_prospect, $ap_materno_prospect, $correo_prospect);
        }
        /** nombre, ap_materno  vacío, ---- telefono ap_paterno , correo**/
        if(empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByTelCorreoApPaterno($telefono_prospect, $ap_paterno_prospect, $correo_prospect);
        }
        /** ap_paterno, ap_materno  vacío, ---- telefono nombre , correo**/
        if(!empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByTelCorreoName($telefono_prospect, $name_prospect, $correo_prospect);
        }
        /** correo vacío, ---- telefono nombre , ap_paterno, ap_materno **/
        if(!empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByTelCorreoName($telefono_prospect, $name_prospect, $correo_prospect);
        }
        if(empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByTelCorreoApMaternoApPaterno($telefono_prospect, $ap_materno_prospect, $correo_prospect, $ap_paterno_prospect);
        }
        /**  telefono ap_paterno vacío, ----  nombre , correo, ap_materno **/
        if(!empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameCorreoApMaterno($name_prospect, $correo_prospect, $ap_materno_prospect);
        }
        /**  ap_paterno,  correo vacío     ------- nombre + ap_materno + telefono**/
        if(!empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameTelApMaterno($name_prospect, $telefono_prospect, $ap_materno_prospect);
        }
        /** ap_paterno, vacío     ------- nombre + ap_materno + telefono + correo**/
        if(!empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameTelCorreoApMaterno($name_prospect, $telefono_prospect, $ap_materno_prospect, $correo_prospect);
        }
        /** ap_materno, vacío     ------- nombre +  ap_paterno + telefono + correo**/
        if(!empty($name_prospect) && !empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameTelCorreoApPaterno($name_prospect, $telefono_prospect, $ap_paterno_prospect, $correo_prospect);
        }
        /**ap_materno, telefono vacío     ------- nombre +  ap_paterno  + correo**/
        if(!empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameCorreoApPaterno($name_prospect, $ap_paterno_prospect, $correo_prospect);
        }
        /**ap_materno, correo vacío     ------- nombre +  ap_paterno  +  telefono**/
        if(!empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByNameTelApPaterno($name_prospect, $ap_paterno_prospect, $telefono_prospect);
        }
        /**nombre, telefono  vacío     -------  ap_materno +  ap_paterno  +   correo**/
        if(empty($name_prospect) && !empty($correo_prospect) && empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApPaternoApMaternoCorreo($ap_materno_prospect, $ap_paterno_prospect, $correo_prospect);
        }
        /**nombre, correo vacío     ------- ap_materno +  ap_paterno  +  telefono**/
        if(empty($name_prospect) && empty($correo_prospect) && !empty($telefono_prospect) && !empty($ap_paterno_prospect)
            && !empty($ap_materno_prospect))
        {
            $data['data'] = $this->Clientes_model->getProspByApMaternoTelApPaterno($ap_materno_prospect, $ap_paterno_prospect, $telefono_prospect);
        }
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getResidencialDisponible() {
        $recidenciales = $this->Caja_model_outside->getResidencialDis();
        if($recidenciales != null) {
            echo json_encode($recidenciales);
        } else {
            echo json_encode(array());
        }
    }

    public function getCondominioDisponible($proyecto) {
        $condominio = $this->Caja_model_outside->getCondominioDis($proyecto);
        if($condominio != null) {
            echo json_encode($condominio);
        } else {
            echo json_encode(array());
        }
    }

    public function getLoteDisponible($condominio) {
        $lotes = $this->Caja_model_outside->getLotesDis($condominio);
        if($lotes != null) {
            echo json_encode($lotes);
        } else {
            echo json_encode(array());
        }
    }

    public function getPresales(){
        $data['data'] = $this->Clientes_model->getPresales()->result_array();
        echo json_encode($data);
    }

    public function getProspectInformationByReference() {
        $reference = json_decode(file_get_contents("php://input"));
        $information = $this->Clientes_model->getProspectInformationByReference($reference->referencia);
        if($information != null) {
            echo json_encode($information);
        } else {
            echo json_encode(array());
        }
    }

    public function getPresalesList(){
        $data['data'] = $this->Clientes_model->getPresalesList()->result_array();
        echo json_encode($data);
    }

    public function toFixedValidation(){
        $this->load->view('template/header');
        $this->load->view("clientes/toFixedValidation");
    }
	
	
	
    public function consultProspectsAll(){
        $this->load->view('template/header');
        $this->load->view("clientes/consulta_prospectos_mktd_all");
    }


    public function getProspectsListByPlace($id_lugar){
        $data['data'] = $this->Clientes_model->getProspectsListByPlace($id_lugar);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }
    
    public function getProspectsListBySubdir_p($id_sub){
        $data['data'] = $this->Clientes_model->getProspectsListBySubdir_p($id_sub);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getProspectsListByGte($lugar_p,$id_gte){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsListByGte($lugar_p,$id_gte, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }

    }

    public function getProspectsListByCoord_v2($lugar_p,$id_sub,$id_gte,$id_coord){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsListByCoord_v2($lugar_p, $id_sub, $id_gte, $id_coord, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }

    }

    public function getProspectsListByAs($lugar_p,$id_sub,$id_gte,$id_coord,$id_as){

        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsListByAs($lugar_p,$id_sub,$id_gte,$id_coord,$id_as, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }



    public function getGerentesAll(){
        echo json_encode($this->Clientes_model->getGerentesAll()->result_array());
    }

    public function getProspectsListByGteAll($id_gte){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsListByGteAll($id_gte, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function getProspectsListByCoordByGte($id_gte,$id_coord){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsListByCoordByGte($id_gte,$id_coord, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function getProspectsListByAsByCoord($id_gte,$id_coord,$id_as){


        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsListByAsByCoord($id_gte,$id_coord,$id_as, $typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }

    }
	
	
    public function changeProspectingPlace()
    {
        $this->load->view('template/header');
        $this->load->view("clientes/change_lp");
    }
	
    public function getSedes()
    {
        $dato = $this->Clientes_model->getSedes();
        
        if($dato != null) {
            echo json_encode($dato);
        } else {
            echo json_encode(array());
        }
        exit;
    }
	
	

  public function change_lp()
    {
        $data = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'));
        if ($this->session->userdata('id_rol') == 20 || $this->session->userdata('id_rol') == 19)
            $data["lugar_prospeccion"] = $this->input->post('lugar_p');
        else
            $data["otro_lugar"] = $this->input->post('lugar_p');
        $id_pros = $this->input->post('id');
        $data = $this->Clientes_model->change_lp($id_pros, $data);
        echo json_encode($data);

    }


    public function addEvidencesGte(){
        $this->load->view('template/header');
        $this->load->view("clientes/addEvidenciaCB");
    }
    public function autorizarEvidenciasCB(){
        $this->load->view('template/header');
        $this->load->view("clientes/addEvidenciaCB");
    }
    public function autorizarEvidenciasCN(){
        $this->load->view('template/header');
        $this->load->view("clientes/autorizarEvidenciaCN");
    }

    public function verifyAllMktClients(){
        $this->load->view('template/header');
        $this->load->view("clientes/verifyAllMktClients");
    }

    public function getClientsListByManager(){
        $data['data'] = $this->Clientes_model->getClientsListByManager()->result_array();
        echo json_encode($data);
    }


    public function deletedFromEvidence()
    {
        $this->load->view('template/header');
        $this->load->view("clientes/registrosEliminadosEV");
    }

    public function clientsReport(){
        $this->load->view('template/header');
        switch ($this->session->userdata('id_rol')) {

            case '18': // SUBDIRECTOR MKTD & TI
            case '19': // SUBDIRECTOR MKTD
            case '20': // GERENTE MKTD
            case '28': // GERENTE MKTD
                $this->load->view("clientes/clients_report");
            break;
            case '4': // ASISTENTE GERENTE
            case '53': // ANALISTA COMISIONES
            case '13': // CONTRALORÍA
            case '17': // CONTRALORÍA
            case '63': // CONTROL INTERNO
            case '70': // EJECUTIVO CONTRALORIA JR
                $this->load->view("clientes/clients_report_ventas");
            break;
        }
    }
    
    public function getClientsReportMktd(){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getClientsReportMktd($typeTransaction, $beginDate, $endDate, $where)->result_array();
            echo json_encode($data);
        } else {
            json_encode(array());
        }
        exit;
    }

    public function prospectsAssigned(){
        $this->load->view('template/header');
        $this->load->view("clientes/prospects_assigned");
    }

    public function getProspectsAssignedList()
    {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $data['data'] = $this->Clientes_model->getProspectsAssignedList($typeTransaction, $beginDate, $endDate, $where);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function getGeneralProspectsList(){
        $this->load->view('template/header');
        $this->load->view("clientes/prospects_general_list");
    }

    public function getGeneralProspectsListInformation()
    {
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
        }
        $data['data'] = $this->Clientes_model->getGeneralProspectsListInformation($typeTransaction)->result_array();
        echo json_encode($data);
    }

    public function getSimilarLead(){
		$json['resultado'] = FALSE;
        $idInput = $this->input->post('id_input');
        $key = $this->input->post('key');
        if( $idInput == "name"){            
            $data = $this->Clientes_model->getSimilarName($key);
        } 
        else if($idInput == "phone_number"){
            $data = $this->Clientes_model->getSimilarPhone($key);
        } 
        else if($idInput == "email"){
            $data = $this->Clientes_model->getSimilarEmail($key);
        } 

        if($data != null) $json['resultado'] = TRUE;
        echo json_encode($json);
    }

    public function getNameLoteById(){
        $id_lote = $this->input->post('id_lote');

        $data['data'] = $this->Clientes_model->getNameLoteById($id_lote);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function fillSelects(){
        echo json_encode($this->Clientes_model->getCatalogs()->result_array());
    }

    public function registros_landing(){
        $this->load->view('template/header');
        $this->load->view("clientes/registros_lp");
    }

    public function registrosLP(){
        $typeTransaction = $this->input->post("typeTransaction");
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
        $where = $this->input->post("where");

        $data['data'] = $this->Clientes_model->getregistrosLP($typeTransaction, $beginDate, $endDate, $where);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function coincidenciasProspectos()
    {
        $this->load->view('template/header');
        $this->load->view("clientes/coincidencias_prospectos");
    }

    public function filterProspectos()
    {
        $nombre = '';
        $apellido_paterno = '';
        $apellido_materno = '';
        $telefono = '';
        $correo = '';
        $string = '';
        $arrayChecks = $this->input->post("checks");
        $jsonProspectos = $this->input->post("jsonProspectos");
        $prospectos = json_decode($jsonProspectos);
        $anio = $this->input->post("anio") == '' ? 0 : $this->input->post("anio");

        if (in_array("anio", $arrayChecks) && $anio != 0)
            $where2= "AND cl.fechaApartado BETWEEN '" . ($anio - 1) . "-12-31 23:59:59.999' AND '$anio-12-31 23:59:59.999'";
        if (in_array("anio", $arrayChecks) && $anio == 0)
            $where2 .= "AND cl.fechaApartado BETWEEN '2019-12-31 23:59:59.999' AND '" . date("Y") . "-12-31 23:59:59.999'";

        for ($i = 0; $i < count($prospectos); $i++) {
            $alone = "";
            if (in_array("nombre", $arrayChecks) && isset($prospectos[$i]->nombre))
                $alone .= " AND cl.nombre LIKE '%" . $this->normalizeName($prospectos[$i]->nombre) . "%'";
            if (in_array("apellido_paterno", $arrayChecks) && isset($prospectos[$i]->apellido_paterno))
                $alone .= " AND cl.apellido_paterno LIKE '%" . $this->normalizeName($prospectos[$i]->apellido_paterno) . "%' ";
            if (in_array("apellido_materno", $arrayChecks) && isset($prospectos[$i]->apellido_materno))
                $alone .= "AND cl.apellido_materno LIKE '%" . $this->normalizeName($prospectos[$i]->apellido_materno) . "%' ";
            if (in_array("telefono", $arrayChecks) && isset($prospectos[$i]->telefono))
                $alone .= "AND cl.telefono1 LIKE '%" . $this->normalizeTelephone($prospectos[$i]->telefono) . "%' ";
            if (in_array("correo", $arrayChecks) && isset($prospectos[$i]->correo))
                $alone .= "AND cl.correo LIKE '%" . $this->doubleSpaceBlank($prospectos[$i]->correo) . "%' ";
            $string .= ' OR (' . substr($alone, 4) . ')';
        }

        $where = substr($string, 4);

        $data['data'] = $this->Clientes_model->getCoincidencias($where, $where2)->result_array();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function normalizeName($str)
    {
        $transliteration = array(
            'Ĳ' => 'I', 'Ö' => 'O', 'Œ' => 'O', 'Ü' => 'U', 'ä' => 'a', 'æ' => 'a',
            'ĳ' => 'i', 'ö' => 'o', 'œ' => 'o', 'ü' => 'u', 'ß' => 's', 'ſ' => 's',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'Æ' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Ç' => 'C', 'Ć' => 'C',
            'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D', 'È' => 'E',
            'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ě' => 'E',
            'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G', 'Ġ' => 'G', 'Ģ' => 'G',
            'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I', 'İ' => 'I', 'Ĵ' => 'J',
            'Ķ' => 'K', 'Ľ' => 'K', 'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ł' => 'L',
            'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O',
            'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O',
            'Ŏ' => 'O', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Ş' => 'S',
            'Ŝ' => 'S', 'Ș' => 'S', 'Š' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ū' => 'U', 'Ů' => 'U',
            'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U', 'Ŵ' => 'W', 'Ŷ' => 'Y',
            'Ÿ' => 'Y', 'Ý' => 'Y', 'Ź' => 'Z', 'Ż' => 'Z', 'Ž' => 'Z', 'à' => 'a',
            'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'å' => 'a', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ƒ' => 'f',
            'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h', 'ħ' => 'h',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i', 'ĩ' => 'i',
            'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĵ' => 'j', 'ķ' => 'k', 'ĸ' => 'k',
            'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'ŀ' => 'l', 'ñ' => 'n',
            'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'ŋ' => 'n', 'ò' => 'o',
            'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o',
            'ŏ' => 'o', 'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'ś' => 's', 'š' => 's',
            'ť' => 't', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ū' => 'u', 'ů' => 'u',
            'ű' => 'u', 'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ÿ' => 'y',
            'ý' => 'y', 'ŷ' => 'y', 'ż' => 'z', 'ź' => 'z', 'ž' => 'z', 'Α' => 'A',
            'Ά' => 'A', 'Ἀ' => 'A', 'Ἁ' => 'A', 'Ἂ' => 'A', 'Ἃ' => 'A', 'Ἄ' => 'A',
            'Ἅ' => 'A', 'Ἆ' => 'A', 'Ἇ' => 'A', 'ᾈ' => 'A', 'ᾉ' => 'A', 'ᾊ' => 'A',
            'ᾋ' => 'A', 'ᾌ' => 'A', 'ᾍ' => 'A', 'ᾎ' => 'A', 'ᾏ' => 'A', 'Ᾰ' => 'A',
            'Ᾱ' => 'A', 'Ὰ' => 'A', 'ᾼ' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D',
            'Ε' => 'E', 'Έ' => 'E', 'Ἐ' => 'E', 'Ἑ' => 'E', 'Ἒ' => 'E', 'Ἓ' => 'E',
            'Ἔ' => 'E', 'Ἕ' => 'E', 'Ὲ' => 'E', 'Ζ' => 'Z', 'Η' => 'I', 'Ή' => 'I',
            'Ἠ' => 'I', 'Ἡ' => 'I', 'Ἢ' => 'I', 'Ἣ' => 'I', 'Ἤ' => 'I', 'Ἥ' => 'I',
            'Ἦ' => 'I', 'Ἧ' => 'I', 'ᾘ' => 'I', 'ᾙ' => 'I', 'ᾚ' => 'I', 'ᾛ' => 'I',
            'ᾜ' => 'I', 'ᾝ' => 'I', 'ᾞ' => 'I', 'ᾟ' => 'I', 'Ὴ' => 'I', 'ῌ' => 'I',
            'Θ' => 'T', 'Ι' => 'I', 'Ί' => 'I', 'Ϊ' => 'I', 'Ἰ' => 'I', 'Ἱ' => 'I',
            'Ἲ' => 'I', 'Ἳ' => 'I', 'Ἴ' => 'I', 'Ἵ' => 'I', 'Ἶ' => 'I', 'Ἷ' => 'I',
            'Ῐ' => 'I', 'Ῑ' => 'I', 'Ὶ' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M',
            'Ν' => 'N', 'Ξ' => 'K', 'Ο' => 'O', 'Ό' => 'O', 'Ὀ' => 'O', 'Ὁ' => 'O',
            'Ὂ' => 'O', 'Ὃ' => 'O', 'Ὄ' => 'O', 'Ὅ' => 'O', 'Ὸ' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Ῥ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Ύ' => 'Y',
            'Ϋ' => 'Y', 'Ὑ' => 'Y', 'Ὓ' => 'Y', 'Ὕ' => 'Y', 'Ὗ' => 'Y', 'Ῠ' => 'Y',
            'Ῡ' => 'Y', 'Ὺ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'P', 'Ω' => 'O',
            'Ώ' => 'O', 'Ὠ' => 'O', 'Ὡ' => 'O', 'Ὢ' => 'O', 'Ὣ' => 'O', 'Ὤ' => 'O',
            'Ὥ' => 'O', 'Ὦ' => 'O', 'Ὧ' => 'O', 'ᾨ' => 'O', 'ᾩ' => 'O', 'ᾪ' => 'O',
            'ᾫ' => 'O', 'ᾬ' => 'O', 'ᾭ' => 'O', 'ᾮ' => 'O', 'ᾯ' => 'O', 'Ὼ' => 'O',
            'ῼ' => 'O', 'α' => 'a', 'ά' => 'a', 'ἀ' => 'a', 'ἁ' => 'a', 'ἂ' => 'a',
            'ἃ' => 'a', 'ἄ' => 'a', 'ἅ' => 'a', 'ἆ' => 'a', 'ἇ' => 'a', 'ᾀ' => 'a',
            'ᾁ' => 'a', 'ᾂ' => 'a', 'ᾃ' => 'a', 'ᾄ' => 'a', 'ᾅ' => 'a', 'ᾆ' => 'a',
            'ᾇ' => 'a', 'ὰ' => 'a', 'ᾰ' => 'a', 'ᾱ' => 'a', 'ᾲ' => 'a', 'ᾳ' => 'a',
            'ᾴ' => 'a', 'ᾶ' => 'a', 'ᾷ' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd',
            'ε' => 'e', 'έ' => 'e', 'ἐ' => 'e', 'ἑ' => 'e', 'ἒ' => 'e', 'ἓ' => 'e',
            'ἔ' => 'e', 'ἕ' => 'e', 'ὲ' => 'e', 'ζ' => 'z', 'η' => 'i', 'ή' => 'i',
            'ἠ' => 'i', 'ἡ' => 'i', 'ἢ' => 'i', 'ἣ' => 'i', 'ἤ' => 'i', 'ἥ' => 'i',
            'ἦ' => 'i', 'ἧ' => 'i', 'ᾐ' => 'i', 'ᾑ' => 'i', 'ᾒ' => 'i', 'ᾓ' => 'i',
            'ᾔ' => 'i', 'ᾕ' => 'i', 'ᾖ' => 'i', 'ᾗ' => 'i', 'ὴ' => 'i', 'ῂ' => 'i',
            'ῃ' => 'i', 'ῄ' => 'i', 'ῆ' => 'i', 'ῇ' => 'i', 'θ' => 't', 'ι' => 'i',
            'ί' => 'i', 'ϊ' => 'i', 'ΐ' => 'i', 'ἰ' => 'i', 'ἱ' => 'i', 'ἲ' => 'i',
            'ἳ' => 'i', 'ἴ' => 'i', 'ἵ' => 'i', 'ἶ' => 'i', 'ἷ' => 'i', 'ὶ' => 'i',
            'ῐ' => 'i', 'ῑ' => 'i', 'ῒ' => 'i', 'ῖ' => 'i', 'ῗ' => 'i', 'κ' => 'k',
            'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => 'k', 'ο' => 'o', 'ό' => 'o',
            'ὀ' => 'o', 'ὁ' => 'o', 'ὂ' => 'o', 'ὃ' => 'o', 'ὄ' => 'o', 'ὅ' => 'o',
            'ὸ' => 'o', 'π' => 'p', 'ρ' => 'r', 'ῤ' => 'r', 'ῥ' => 'r', 'σ' => 's',
            'ς' => 's', 'τ' => 't', 'υ' => 'y', 'ύ' => 'y', 'ϋ' => 'y', 'ΰ' => 'y',
            'ὐ' => 'y', 'ὑ' => 'y', 'ὒ' => 'y', 'ὓ' => 'y', 'ὔ' => 'y', 'ὕ' => 'y',
            'ὖ' => 'y', 'ὗ' => 'y', 'ὺ' => 'y', 'ῠ' => 'y', 'ῡ' => 'y', 'ῢ' => 'y',
            'ῦ' => 'y', 'ῧ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'p', 'ω' => 'o',
            'ώ' => 'o', 'ὠ' => 'o', 'ὡ' => 'o', 'ὢ' => 'o', 'ὣ' => 'o', 'ὤ' => 'o',
            'ὥ' => 'o', 'ὦ' => 'o', 'ὧ' => 'o', 'ᾠ' => 'o', 'ᾡ' => 'o', 'ᾢ' => 'o',
            'ᾣ' => 'o', 'ᾤ' => 'o', 'ᾥ' => 'o', 'ᾦ' => 'o', 'ᾧ' => 'o', 'ὼ' => 'o',
            'ῲ' => 'o', 'ῳ' => 'o', 'ῴ' => 'o', 'ῶ' => 'o', 'ῷ' => 'o', 'А' => 'A',
            'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E',
            'Ж' => 'Z', 'З' => 'Z', 'И' => 'I', 'Й' => 'I', 'К' => 'K', 'Л' => 'L',
            'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S',
            'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'K', 'Ц' => 'T', 'Ч' => 'C',
            'Ш' => 'S', 'Щ' => 'S', 'Ы' => 'Y', 'Э' => 'E', 'Ю' => 'Y', 'Я' => 'Y',
            'а' => 'A', 'б' => 'B', 'в' => 'V', 'г' => 'G', 'д' => 'D', 'е' => 'E',
            'ё' => 'E', 'ж' => 'Z', 'з' => 'Z', 'и' => 'I', 'й' => 'I', 'к' => 'K',
            'л' => 'L', 'м' => 'M', 'н' => 'N', 'о' => 'O', 'п' => 'P', 'р' => 'R',
            'с' => 'S', 'т' => 'T', 'у' => 'U', 'ф' => 'F', 'х' => 'K', 'ц' => 'T',
            'ч' => 'C', 'ш' => 'S', 'щ' => 'S', 'ы' => 'Y', 'э' => 'E', 'ю' => 'Y',
            'я' => 'Y', 'ð' => 'd', 'Ð' => 'D', 'þ' => 't', 'Þ' => 'T', 'ა' => 'a',
            'ბ' => 'b', 'გ' => 'g', 'დ' => 'd', 'ე' => 'e', 'ვ' => 'v', 'ზ' => 'z',
            'თ' => 't', 'ი' => 'i', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm', 'ნ' => 'n',
            'ო' => 'o', 'პ' => 'p', 'ჟ' => 'z', 'რ' => 'r', 'ს' => 's', 'ტ' => 't',
            'უ' => 'u', 'ფ' => 'p', 'ქ' => 'k', 'ღ' => 'g', 'ყ' => 'q', 'შ' => 's',
            'ჩ' => 'c', 'ც' => 't', 'ძ' => 'd', 'წ' => 't', 'ჭ' => 'c', 'ხ' => 'k',
            'ჯ' => 'j', 'ჰ' => 'h'
        );

        $str = str_replace(array_keys($transliteration), array_values($transliteration), $str);
        $noSpaceBlank = $this->doubleSpaceBlank($str);
        $upperString = strtoupper($noSpaceBlank);
        return $upperString;
    }

    public function doubleSpaceBlank($string)
    {
        $doubleBlankSpace = preg_replace('!\s+!', ' ', $string);
        $lstFrstSpace = trim($doubleBlankSpace);
        return $lstFrstSpace;
    }

    public function normalizeTelephone($string)
    {
        $normalize = intval(preg_replace('/[^0-9]+/', '', $string), 10);
        return $normalize;
    }
    public function getGrsBySub($idSubdir)
    {
        $data = $this->Clientes_model->getGrsBySub($idSubdir);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getProspectsListBySubdirector($idSubdir)
    {
        if ($this->session->userdata('id_rol') == 19) {
            $dato = $this->Clientes_model->getSedeByUser($idSubdir);
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->Clientes_model->getProspectsListBySubdirector($dato[0]['id_sede'], $typeTransaction, $beginDate, $endDate, $where);
        } else {
            $typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
            $data = $this->Clientes_model->getProspectsListBySubdirector($idSubdir, $typeTransaction, $beginDate, $endDate, $where);
        }
        
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function prospectsReport(){
        $this->load->view('template/header');
        $this->load->view("marketing/prospectsReportMarketing");
    }

    public function getProspectsReportInformation(){
        if (isset($_POST) && !empty($_POST)) {
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $type = $this->input->post("type");

            $data['data'] = $this->Clientes_model->getProspectsReportInformation($type, $beginDate, $endDate)->result_array();
            echo json_encode($data);
        } else
            json_encode(array());
    }

    function searchData(){
        //este metodo se usa para la busqueda de clientes y prospectos USER POPEA
        //se diferencias por la bandera TB
        //1: clientes   2: Prospectos
        $idLote = $this->input->post("idLote");
        $name = $this->input->post("name");
        $mail = $this->input->post("mail");
        $telephone = $this->input->post("telephone");
        $sede = $this->input->post("sede");
        $id_dragon = $this->input->post("id_dragon");
        $tipo_busqueda = $this->input->post("TB");

        $fechaInicio = explode('/', $this->input->post("fecha_init"));
        $fechaFin = explode('/', $this->input->post("fecha_end"));
        $fecha_init = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
        $fecha_end = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));

        $data_search = array(
            'idLote' => $idLote,
            'nombre' => $name,
            'correo' => $mail,
            'telefono' => $telephone,
            'sede' => $sede,
            'id_dragon' => $id_dragon,
            'tipo_busqueda' => $tipo_busqueda,
            'fecha_init' => $fecha_init,
            'fecha_end' => $fecha_end
        );

        $result['data'] = $this->Clientes_model->searchData($data_search);
        print_r(json_encode($result, JSON_NUMERIC_CHECK));
        exit;
    }


    public function documentacionDR(){//vista documentos DRAGON POPEA
        $this->load->view('template/header');
        $this->load->view("clientes/documentacionDR");
    }

    public function prospectosDR(){//vista prospectos DRAGON POPEA
        $this->load->view('template/header');
        $this->load->view("clientes/prospectosDR");
    }

    public function dragonsClientsList() {
        $this->load->view('template/header');
        $this->load->view("marketing/dragonsClientsList");
    }

    public function getDragonsClientsList() {
        $result['data'] = $this->Clientes_model->getDragonsClientsList();
        echo json_encode($result, JSON_NUMERIC_CHECK);    
    }

    public function consultaClientesProyecto(){
        $this->load->view('template/header');
        $this->load->view('clientes/consulta_clientes_proyecto_view');
    }

    public function getClientsByProyect() {
        $data = $this->Clientes_model->getClientsByProyect($this->session->userdata('id_lider'));
        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function cancelacionesProceso()
    {
        $this->load->view('template/header');
        $this->load->view('clientes/cancelaciones_proceso');
    }

    public function infoCancelacionesProceso() {
        if (!isset($_POST) || empty($_POST)) {
            echo json_encode([]);
            return;
        }
        $idRol = $this->session->userdata('id_rol');
        $idLider = $this->session->userdata('id_lider');
        $fechaInicio = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $fechaFin = date("Y-m-d", strtotime($this->input->post("endDate")));
        $data = $this->Clientes_model->getCancelacionesProceso($idLider, $idRol, $fechaInicio, $fechaFin);
        echo json_encode($data);
    }

    public function updateCancelacionProceso()
    {
        $idCliente = $this->input->post('idCliente');

        if (!isset($idCliente)) {
            echo json_encode(['code' => 400, 'message' => 'Información requerida.']);
            return;
        }

        $result = $this->General_model->updateRecord('clientes', ['cancelacion_proceso' => 1], 'id_cliente', $idCliente);
        $code = ($result) ? 200 : 500;
        echo json_encode(['code' => $code]);
    }

    public function lotesApartReubicacion()
    {
        $this->load->view('template/header');
        $this->load->view('clientes/lotes_apart_reubicacion');
    }

    public function getLotesApartadosReubicacion()
    {
        $fechaInicio = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $fechaFin = date("Y-m-d", strtotime($this->input->post("endDate")));

        $data = $this->Clientes_model->getLotesApartadosReubicacion($fechaInicio, $fechaFin);
        echo json_encode($data);
    }
}