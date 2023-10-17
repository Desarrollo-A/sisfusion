<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prospectos extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Prospectos_model', 'Statistics_model', 'asesor/Asesor_model', 'Caja_model_outside', 'General_model', 'Clientes_model'));
        $this->load->library(array('session','form_validation'));
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');

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

    public function consultaProspectos(){
        $this->load->view('template/header');
        $this->load->view("prospectos/prospectos_consulta_view");
    }

	public function getProspectsList(){

            $data['data'] = $this->Prospectos_model->getProspectsList()->result_array();
            
            echo json_encode($data);
    }

	function getSedesProspectos()
    {
        echo json_encode($this->Prospectos_model->getSedesProspectos()->result_array());
    }

    public function saveComment(){
        if(isset($_POST) && !empty($_POST)){
            $response = $this->Prospectos_model->saveComment($this->session->userdata('id_usuario'),$this->input->post("id_prospecto"),$this->input->post("observations"));
            echo json_encode($response);
        }
    }

    public function getProspectInformation($id_prospecto){
        echo json_encode($this->Prospectos_model->getProspectInformation($id_prospecto)->result_array());
    }

    function getAsesor($sede)
    {
        echo json_encode($this->Prospectos_model->getAsesor($sede)->result_array());
    }

    function getCoordinador($sede)
    {
        echo json_encode($this->Prospectos_model->getCoordinador($sede)->result_array());
    }

    function getGerentes($sede)
    {
        echo json_encode($this->Prospectos_model->getGerentes($sede)->result_array());
    }

    function getSubdirector($sede)
    {
        echo json_encode($this->Prospectos_model->getSubdirector($sede)->result_array());
    }

    function getDirectorRegional($sede)
    {
        echo json_encode($this->Prospectos_model->getDirectorRegional($sede)->result_array());
    }
	
    public function fillSelects(){
        echo json_encode($this->Prospectos_model->getCatalogs()->result_array());
    }

    public function getInformationToPrint($id_prospecto){
        echo json_encode($this->Prospectos_model->getInformationToPrint($id_prospecto)->result_array());
    }

    public function updateProspect(){

        /* $specify = $_POST['specify'];
        if ($specify == '' || $specify == null) {
            $final_specification = 0;
        } else {
            $final_specification = $specify;
        } */

            $data = array(
                "nacionalidad" => $_POST['nationality'],
                "personalidad_juridica" => $_POST['legal_personality'],
                "curp" => $_POST['curp'],
                "rfc" => $_POST['rfc'],
                "nombre" => $_POST['name'],
                "apellido_paterno" => $_POST['last_name'],
                "apellido_materno" => $_POST['mothers_last_name'],
                "fecha_nacimiento" => $_POST['date_birth'],
                "edadFirma" => $_POST['company_antiquity'],
                "correo" => $_POST['email'],
                "telefono_2" => $_POST['phone_number2'],
                "estado_civil" => $_POST['civil_status'],
                "regimen_matrimonial" => $_POST['matrimonial_regime'],
                "tipo_vivienda" => $_POST['lives_at_home'],

                "ocupacion" => $_POST['occupation'],
                "empresa" => $_POST['company'],
                "posicion" => $_POST['position'],
                "antiguedad" => $_POST['antiquity'],
                "direccion" => $_POST['company_residence'],

                "plaza_venta" => $_POST['sales_plaza'],
                "observaciones" => $_POST['observation'], 

                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario')
            );

            if($_POST['nationality'] == '' ||  $_POST['legal_personality'] == '' || $_POST['name'] == '' || $_POST['sales_plaza'] == '' || $_POST['sales_plaza'] == null){
                $response = 0;
                echo json_encode($response);
            }else{
                $response = $this->Prospectos_model->updateProspect($data, $this->input->post("id_prospecto_ed"));
                echo json_encode($response);
            }
        
    }

    public function getComments($id_prospecto){
        echo json_encode($this->Prospectos_model->getComments($id_prospecto)->result_array());
    }

    public function getChangelog($id_prospecto){
        echo json_encode($this->Prospectos_model->getChangelog($id_prospecto)->result_array());
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
        $informacion = $this->Prospectos_model->getPrintableInformation($id_prospecto)->row();
        $informacion_lugar = $this->Prospectos_model->getProspectSpecification($id_prospecto)->row();

        $rol = $this->Prospectos_model->getRole($informacion->id_gerente)->row();

        if (in_array($rol->id_rol, array("7", "9", "3", "2"))) { // EN LA TABLA DE PROSPECTOS ESTÁN REGISTRADOS LOS DATOS DE VENTAS
            $informacion_ventas["coordinador"] = $informacion->coordinador;
            $informacion_ventas["telefono_coordinador"] = $informacion->telefono_coordinador;
            $informacion_ventas["gerente"] = $informacion->gerente;
            $informacion_ventas["telefono_gerente"] = $informacion->telefono_gerente;
            // BUSCO LOS DATOS DE MKTD (1) EN LA TABLA DE SALES PARTNER INFORMATION
            $informacion_mktd_data = $this->Prospectos_model->getSalesPartnerInformation($id_prospecto, 1)->row();
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
            $informacion_ventas_data = $this->Prospectos_model->getSalesPartnerInformation($id_prospecto, 2)->row();
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
        $informacion = $this->Prospectos_model->getPrintableInformation($id_prospecto)->row();
        $informacion_lugar = $this->Prospectos_model->getProspectSpecification($id_prospecto)->row();
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

    public function updateStatus(){

        $data = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "estatus_particular" => $this->input->post("estatus_particular")
        );

        $response = $this->Prospectos_model->updateProspect($data, $this->input->post("id_prospecto_estatus_particular"));
        echo json_encode($response);
    }

    public function insertRecordatorio(){

        $objDatos = json_decode(file_get_contents("php://input"));
        $data = array(
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "medio" => $objDatos->estatus_recordatorio,
            "fecha_cita" =>  str_replace("T", " ", $objDatos->dateStart),
            "idCliente" => $objDatos->id_prospecto_estatus_particular,
            "idOrganizador" => $this->session->userdata('id_usuario'),
            "estatus" => 1,
            "titulo" => $objDatos->evtTitle, 
            "fecha_final" =>  str_replace("T", " ", $objDatos->dateEnd),
            "id_direccion" => isset($objDatos->id_direccion) ? $objDatos->id_direccion :null,
            "direccion" => isset($objDatos->direccion) ? $objDatos->direccion :null,
            "descripcion" => $objDatos->description,
            "idGoogle" => isset($objDatos->idGoogle) ? $objDatos->idGoogle:null
        );

        $response = $this->General_model->addRecord('agenda', $data);

        if ($response){
            $dataN = array(
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "estatus_particular" => 3
            );

            if(isset($objDatos->telefono2)){
                $dataN['telefono_2'] = $objDatos->telefono2;
            }

            $responseN = $this->General_model->updateRecord('prospectos', $dataN, 'id_prospecto', $this->input->post("id_prospecto_estatus_particular"));

            if ($responseN)
                echo json_encode(array("status" => 200, "message" => "Se ha registrado el evento de manera exitosa."));
            else 
                echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. No se ha podido actualizar el estatus del prospecto"));
        } else 
            echo json_encode(array("status" => 503, "message" => "Oops, no se ha podido agendar cita, ni actualizar estatus del prospecto"));
    }

}