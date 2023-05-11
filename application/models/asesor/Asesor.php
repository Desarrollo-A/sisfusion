<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asesor extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('model_queryinventario');
        $this->load->model('asesor/Asesor_model');
        $this->load->model('registrolote_modelo');
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','form'));
        $this->load->database('default');
		$this->load->library('Pdf');
        $this->load->library('phpmailer_lib');
        date_default_timezone_set('America/Mexico_City');

    }

	public function index()
	{
		if($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '7')
		{
			redirect(base_url().'login');
		}
		$this->load->view('template/header');
		$this->load->view('asesor/inicio_asesor_view');
		$this->load->view('template/footer');
	}


    // public function comisiones_view()
    // {
    //     $this->load->view('template/header');
    //     $this->load->view("asesor/comisiones_view");
    // }


    //  public function hitorial_Comisiones()
    // {
    //     $this->load->view('template/header');
    //     $this->load->view("asesor/comisiones_view");
    // }

    public function deposito_seriedad_ds($idCliente, $onlyView){
        $datos=array();
        $datos["cliente"]= $this->registrolote_modelo->selectDS_ds($idCliente);
        $this->load->view('contraloria/dpform_c',$datos);
    }

    public function lista_gerentes(){
      echo json_encode($this->Asesor_model->get_gerentes_lista()->result_array());
    }
    public function lista_asesores($gerente){
      echo json_encode($this->Asesor_model->get_asesores_lista($gerente)->result_array());
    }
    public function lista_proyecto(){
      echo json_encode($this->Asesor_model->get_proyecto_lista()->result_array());
    }
    public function lista_condominio($proyecto){
      echo json_encode($this->Asesor_model->get_condominio_lista($proyecto)->result_array());
    }
    public function lista_lote($condominio){
      echo json_encode($this->Asesor_model->get_lote_lista($condominio)->result_array());
    }
    public function datos_dinamicos($lote, $asesor){
      echo json_encode($this->Asesor_model->get_datos_dinamicos($lote, $asesor)->result_array());
    }
    public function forma_venta(){
      echo json_encode($this->Asesor_model->get_datos_forma()->result_array());
    }
    public function tipo_venta(){
      echo json_encode($this->Asesor_model->get_datos_tipo()->result_array());
    }
    public function verificar_solicitud($lote){
      echo json_encode($this->Asesor_model->get_validar_solicitud($lote)->result_array());
    }



    public function getinfoLoteDisponible() {
        $objDatos = json_decode(file_get_contents("php://input"));
        $data = $this->Asesor_model->getLotesInfoCorrida($objDatos->lote);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

 

    public function inventario()/*this is the function*/
    {
        $datos = array();
        $datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
        $datos["residencial"] = $this->Asesor_model->get_proyecto_lista();
        $this->load->view('template/header');
        $this->load->view("contratacion/datos_lote_contratacion_view", $datos);
    }

    public function cf(){
        $this->load->view("corrida/cf_view");
    }

    public function cf2(){
        $this->load->view("corrida/cf_view2");
    }

    public function cf3()
    {
        $this->load->view("corrida/cf_view_PAC");
    }


    public function eliminar_propietario()
    {
        $json['resultado'] = FALSE;
        if( $this->input->post("id_copropietario")){
            $this->load->model("Asesor_model");
            $id_copropietario = $this->input->post("id_copropietario");
            $this->db->query('UPDATE copropietarios SET estatus = 0 WHERE id_copropietario = '.$id_copropietario.'');
            $json['resultado'] = TRUE;
         }

        echo json_encode( $json );
    }


    public function agregar_propietario()
    {

        $json['resultado'] = FALSE;

        if( $this->input->post("nombre_nuevo")){

            $nuevo0 = $this->input->post("idd");
            $nuevo1 = $this->input->post("nombre_nuevo");
            $nuevo2 = $this->input->post("apellidop_nuevo");
            $nuevo3 = $this->input->post("apellidom_nuevo");
            $nuevo4 = $this->input->post("correo_nuevo");
            $nuevo5 = $this->input->post("telefono1_nuevo");
            $nuevo6 = $this->input->post("telefono2_nuevo");
            $nuevo7 = $this->input->post("fnacimiento_nuevo");

            $nuevo8 = $this->input->post("nacionalidad_nuevo");
            $nuevo9 = $this->input->post("originario_nuevo");
            $nuevo10 = $this->input->post("domicilio_particular_nuevo");

            $nuevo11 = $this->input->post("estadocivil_nuevo");
            $nuevo12 = $this->input->post("conyuge_nuevo");
            $nuevo13 = $this->input->post("regimen_nuevo");

            $nuevo14 = $this->input->post("ocupacion_nuevo");
            $nuevo15 = $this->input->post("puesto_nuevo");
            $nuevo16 = $this->input->post("empresa_nuevo");

            $nuevo17 = $this->input->post("antiguedad_nuevo");
            $nuevo18 = $this->input->post("edad_firma_nuevo");
            $nuevo19 = $this->input->post("domempresa_nuevo");
            $nuevo20 = 1;
            $nuevo21 = $this->session->userdata('id_usuario');

            $arreglo_nuevo=array();
            $arreglo_nuevo["id_cliente"]=$nuevo0;
            $arreglo_nuevo["nombre"]=$nuevo1;
            $arreglo_nuevo["apellido_paterno"]=$nuevo2;
            $arreglo_nuevo["apellido_materno"]=$nuevo3;

            $arreglo_nuevo["correo"]=$nuevo4;
            $arreglo_nuevo["telefono"]=$nuevo5;
            $arreglo_nuevo["telefono_2"]=$nuevo6;
            $arreglo_nuevo["fecha_nacimiento"]=$nuevo7;

            $arreglo_nuevo["nacionalidad"]=$nuevo8;
            $arreglo_nuevo["originario_de"]=$nuevo9;
            $arreglo_nuevo["domicilio_particular"]=$nuevo10;

            $arreglo_nuevo["estado_civil"]=$nuevo11;
            $arreglo_nuevo["regimen_matrimonial"]=$nuevo13;
            $arreglo_nuevo["conyuge"]=$nuevo12;

            $arreglo_nuevo["ocupacion"]=$nuevo14;
            $arreglo_nuevo["posicion"]=$nuevo15;
            $arreglo_nuevo["empresa"]=$nuevo16;

            $arreglo_nuevo["antiguedad"]=$nuevo17;
            $arreglo_nuevo["edadFirma"]=$nuevo18;
            $arreglo_nuevo["direccion"]=$nuevo19;
            $arreglo_nuevo["estatus"]=$nuevo20;
            $arreglo_nuevo["creado_por"]=$nuevo21;

            $this->load->model("Asesor_model");
            $this->db->insert('copropietarios', $arreglo_nuevo);

            $json['resultado'] = TRUE;
         }

        echo json_encode( $json );
    }




    public function getGerente() {
        $data= $this->registrolote_modelo->getGerente();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }


    public function newProspect(){
        $datos=array();
        $this->load->view('template/header');
        $this->load->view("asesor/prospectos", $datos);
    }

    public function consultProspects(){
        $datos=array();
        $this->load->view('template/header');
        $this->load->view("asesor/consulta_prospectos", $datos);
    }

    public function consultStatistics(){
        $datos=array();
        $this->load->view('template/header');
        $this->load->view("asesor/consult_statistics", $datos);
    }

    public function getProspectingPlaces(){
        echo json_encode($this->Asesor_model->getProspectingPlaces()->result_array());
    }

    public function getNationality(){
        echo json_encode($this->Asesor_model->getNationality()->result_array());
    }

    public function getLegalPersonality(){
        echo json_encode($this->Asesor_model->getLegalPersonality()->result_array());
    }

    public function getAdvertising(){
        echo json_encode($this->Asesor_model->getAdvertising()->result_array());
    }

    public function getSalesPlaza(){
        echo json_encode($this->Asesor_model->getSalesPlaza()->result_array());
    }

    public function getCivilStatus(){
        echo json_encode($this->Asesor_model->getCivilStatus()->result_array());
    }

    public function getMatrimonialRegime(){
        echo json_encode($this->Asesor_model->getMatrimonialRegime()->result_array());
    }

    public function getState(){
        echo json_encode($this->Asesor_model->getState()->result_array());
    }

    public function getParentesco(){
        echo json_encode($this->Asesor_model->getParentesco()->result_array());
    }

    public function getModalidad(){
        echo json_encode($this->Asesor_model->getModalidad()->result_array());
    }
    public function getMediosVenta(){
        echo json_encode($this->Asesor_model->getMediosVenta()->result_array());
    }
    // public function getTipoVenta(){
    //     echo json_encode($this->Asesor_model->getTipoVenta()->result_array());
    // }
    public function getPlan(){
        echo json_encode($this->Asesor_model->getPlan()->result_array());
    }

    public function getProspectsList(){
        $data['data'] = $this->Asesor_model->getProspectsList()->result_array();
        echo json_encode($data);
    }

    public function getProspectInformation($id_prospecto){
        echo json_encode($this->Asesor_model->getProspectInformation($id_prospecto)->result_array());
    }

    public function getInformationToPrint($id_prospecto){
        echo json_encode($this->Asesor_model->getInformationToPrint($id_prospecto)->result_array());
    }

    public function getComments($id_prospecto){
        echo json_encode($this->Asesor_model->getComments($id_prospecto)->result_array());
    }

    public function getChangelog($id_prospecto){
        echo json_encode($this->Asesor_model->getChangelog($id_prospecto)->result_array());
    }

    public function saveComment(){
        if(isset($_POST) && !empty($_POST)){
            $response = $this->Asesor_model->saveComment($this->session->userdata('id_usuario'),$this->input->post("id_prospecto"),$this->input->post("observations"));
            echo json_encode($response);
        }
    }

    public function updateProspect(){
        $specify = $_POST['specify'];
        if ($specify == '' || $specify == null) {
            $final_specification = 0;
        } else {
            $final_specification = $specify;
        }
        $data = array(
            "nacionalidad" => $_POST['nationality'],
            "personalidad_juridica" => $_POST['legal_personality'],
            "curp" => $_POST['curp'],
            "rfc" => $_POST['rfc'],
            "apellido_paterno" => $_POST['last_name'],
            "apellido_materno" => $_POST['mothers_last_name'],
            "correo" => $_POST['email'],
            "telefono" => $_POST['phone_number'],
            "telefono_2" => $_POST['phone_number2'],
            "lugar_prospeccion" => $_POST['prospecting_place'],
            "otro_lugar" => $final_specification,
            "medio_publicitario" => $_POST['advertising'],
            "plaza_venta" => $_POST['sales_plaza'],
            "observaciones" => $_POST['observation'],
            "fecha_nacimiento" => $_POST['date_birth'],
            "estado_civil" => $_POST['civil_status'],
            "regimen_matrimonial" => $_POST['matrimonial_regime'],
            "conyuge" => $_POST['spouce'],
            "calle" => $_POST['street_name'],
            "numero" => $_POST['ext_number'],
            "colonia" => $_POST['suburb'],
            "municipio" => $_POST['town'],
            "estado" => $_POST['state'],
            "codigo_postal" => $_POST['postal_code'],
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
        $response = $this->Asesor_model->updateProspect($data, $this->input->post("id_prospecto_ed"));
        echo json_encode($response);
    }

    public function saveProspect(){
        $specify = $_POST['specify'];
        if ($specify == '' || $specify == null) {
            $final_specification = 0;
        } else {
            $final_specification = $specify;
        }
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
            "medio_publicitario" => $_POST['advertising'],
            "plaza_venta" => $_POST['sales_plaza'],
            "observaciones" => $_POST['observations'],
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "fecha_nacimiento" => $_POST['date_birth'],
            "estado_civil" => $_POST['civil_status'],
            "regimen_matrimonial" => $_POST['matrimonial_regime'],
            "conyuge" => $_POST['spouce'],
            "calle" => $_POST['street_name'],
            "numero" => $_POST['ext_number'],
            "colonia" => $_POST['suburb'],
            "municipio" => $_POST['town'],
            "estado" => $_POST['state'],
            "codigo_postal" => $_POST['postal_code'],
            "tipo_vivienda" => $_POST['lives_at_home'],
            "ocupacion" => $_POST['occupation'],
            "empresa" => $_POST['company'],
            "posicion" => $_POST['position'],
            "antiguedad" => $_POST['antiquity'],
            "direccion" => $_POST['company_residence'],
            "edadFirma" => $_POST['company_antiquity'],
            "id_sede" => $this->session->userdata('id_sede'),
            "id_asesor" => $this->session->userdata('id_usuario'),
            "id_coordinador" => $this->session->userdata('id_coordinador'),
            "id_gerente" => $this->session->userdata('id_gerente')
        );
        $response = $this->Asesor_model->saveProspect($data);
        echo json_encode($response);
    }

    public function saveCoOwner(){
        $data = array(
            "nacionalidad" => $_POST['nationality_co'],
            "personalidad_juridica" => $_POST['legal_personality_co'],
            "rfc" => $_POST['rfc_co'],
            "estatus" => 1,
            "nombre" => $_POST['name_co'],
            "apellido_paterno" => $_POST['last_name_co'],
            "apellido_materno" => $_POST['mothers_last_name_co'],
            "correo" => $_POST['email_co'],
            "telefono" => $_POST['phone_number_co'],
            "telefono_2" => $_POST['phone_number2_co'],
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario'),
            "fecha_nacimiento" => $_POST['date_birth_co'],
            "estado_civil" => $_POST['civil_status_co'],
            "regimen_matrimonial" => $_POST['matrimonial_regime_co'],
            "conyuge" => $_POST['spouce_co'],
            "calle" => $_POST['street_name_co'],
            "numero" => $_POST['ext_number_co'],
            "colonia" => $_POST['suburb_co'],
            "municipio" => $_POST['town_co'],
            "estado" => $_POST['state_co'],
            "codigo_postal" => $_POST['postal_code_co'],
            "tipo_vivienda" => $_POST['lives_at_home_co'],
            "ocupacion" => $_POST['occupation_co'],
            "empresa" => $_POST['company_co'],
            "posicion" => $_POST['position_co'],
            "antiguedad" => $_POST['antiquity_co'],
            "direccion" => $_POST['company_residence_co'],
            "edadFirma" => $_POST['company_antiquity_co'],
            "id_cliente" => $_POST['id_prospecto_ed_co']
        );
        $response = $this->Asesor_model->saveCoOwner($data);
        echo json_encode($response);
    }

    public function toPrintProspectInfo($id_prospecto){
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
        $informacion = $this->Asesor_model->getPrintableInformation($id_prospecto)->row();
        $informacion_lugar = $this->Asesor_model->getProspectSpecification($id_prospecto)->row();
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
                                 <b>Lugar:</b><br>
                                 '.$informacion->lugar.'<br>
                                 '.$informacion_lugar->especificar.'
                                </td>
                                <td style="font-size: 1em;">
                                <b>Método:</b><br>
                                '.$informacion->metodo.'
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
            </html>
                                  ';

            $pdf->writeHTMLCell(0, 0, $x = '', $y = '10', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);ob_end_clean();
            $pdf->Output(utf8_decode("Informacion_".$informacion->cliente.".pdf"), 'I');
            /*$pdf = 'testfile.pdf';
            $save = 'output.jpg';
            exec('convert "'.$pdf.'" -colorspace RGB -resize 800 "'.$save.'"', $output, $return_var);*/
        }
    }

    public function depositoSeriedad()
    {
        // $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("asesor/depositoSeriedad");
    }
    public function depositoSeriedadConsulta()
    {
        // $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("asesor/DSConsult");
    }

    public function registrosLoteVentasAsesor()
    {
        // $this->validateSession();
        $datos = array();
        //$datos["registrosLoteContratacion"] = $this->registrolote_modelo->registroLote();
        $datos["residencial"] = $this->Asesor_model->get_proyecto_lista();
        $this->load->view('template/header');
        $this->load->view("contratacion/datos_lote_contratacion_view", $datos);
    }
    public function invDispAsesor()
    {


		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
      	$this->load->view('template/header');
        $this->load->view("asesor/inventario_disponible",$datos);
    }
    public function manual()
    {
        $this->load->view('template/header');
        $this->load->view("asesor/manual_view");
    }

	public function validateSession()
	{
		if($this->session->userdata('id_rol')=="")
		{
			//echo "<script>console.log('No hay sesión iniciada');</script>";
			redirect(base_url() . "index.php/login");
		}
	}

    public function getLotesInventarioGralTodosc(){

        $data = $this->Asesor_model->getInventarioTodosc();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }


    public function getCondominioDesc($residenciales) {

        $data = $this->Asesor_model->getCondominioDesc($residenciales);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
//      for ($i=0; $i < count($data['condominios']); $i++) {
//          echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']." "."(".$data['condominios'][$i]['nombreResidencial'].")"."</option>";
//      }
    }

    public function getSupOne($residencial) {
        $data= $this->Asesor_model->getSupOne($residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
//      for ($i=0; $i < count($data['sup']); $i++) {
//          echo "<option idLote='".$data['sup'][$i]['sup']."' value='".$data['sup'][$i]['sup']."'>".$data['sup'][$i]['sup']." "."m2"."</option>";
//      }
    }



    public function getPrecio($residencial) {
        $data = $this->Asesor_model->getPrecio($residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
//      for ($i=0; $i < count($data['precio']); $i++) {
//          echo "<option idLote='".$data['precio'][$i]['precio']."' value='".$data['precio'][$i]['precio']."'>"."$".number_format($data['precio'][$i]['precio'], 2, ".", ",")."</option>";
//      }
    }

    public function getTotal($residencial) {
        $data = $this->Asesor_model->getTotal($residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
//      for ($i=0; $i < count($data['total']); $i++) {
//          echo "<option idLote='".$data['total'][$i]['total']."' value='".$data['total'][$i]['total']."'>"."$".number_format($data['total'][$i]['total'], 2, ".", ",")."</option>";
//      }
    }


    public function getMeses($residencial) {
        $data = $this->Asesor_model->getMeses($residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }


    public function getLotesInventarioXproyectoc($residencial){
        $data = $this->Asesor_model->getInventarioXproyectoc($residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }


function getLotesInventarioGralc($residencial, $condominio){
        $data = $this->registrolote_modelo->getInventarioc($residencial, $condominio);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }





    public function getMesesResidencial($residencial, $meses){
        $data = $this->Asesor_model->getMesesResidencial($residencial, $meses);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getMesesCluster($residencial, $condominio, $meses){
        $data = $this->Asesor_model->getMesesCluster($residencial, $condominio, $meses);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function getEmpy(){
        $data = [];
        echo json_encode($data);
    }

        function getTwoGroup($residencial, $grupo){
        $data = $this->Asesor_model->getTwoGroup($residencial, $grupo);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }
    function getOneGroup($condominio, $grupo){
        $data= $this->Asesor_model->getOneGroup($condominio, $grupo);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }







  public  function tableClienteDS() {
        $objDatos = json_decode(file_get_contents("php://input"));
        $dato = $this->Asesor_model->registroClienteDS();
        //$data2= $this->Asesor_model->getReferenciasCliente();

        // for($i=0; $i<count($dato); $i++)
        // {
        //     $data[$i]['id_cliente'] = $dato[$i]->id_cliente;
        //     $data[$i]['id_asesor'] = $dato[$i]->id_asesor;
        //     $data[$i]['id_coordinador'] = $dato[$i]->id_coordinador;
        //     $data[$i]['id_gerente'] = $dato[$i]->id_gerente;
        //     $data[$i]['id_sede'] = $dato[$i]->id_sede;
        //     $data[$i]['nombre'] = $dato[$i]->nombre;
        //     $data[$i]['apellido_paterno'] = $dato[$i]->apellido_paterno;
        //     $data[$i]['apellido_materno'] = $dato[$i]->apellido_materno;
        //     $data[$i]['personalidad_juridica'] = $dato[$i]->personalidad_juridica;
        //     $data[$i]['nacionalidad'] = $dato[$i]->nacionalidad;
        //     $data[$i]['rfc'] = $dato[$i]->rfc;
        //     $data[$i]['curp'] = $dato[$i]->curp;
        //     $data[$i]['correo'] = $dato[$i]->correo;
        //     $data[$i]['telefono1'] = $dato[$i]->telefono1;
        //     $data[$i]['telefono2'] = $dato[$i]->telefono2;
        //     $data[$i]['telefono3'] = $dato[$i]->telefono3;
        //     $data[$i]['fecha_nacimiento'] = $dato[$i]->fecha_nacimiento;
        //     $data[$i]['lugar_prospeccion'] = $dato[$i]->lugar_prospeccion;
        //     $data[$i]['medio_publicitario'] = $dato[$i]->medio_publicitario;
        //     $data[$i]['otro_lugar'] = $dato[$i]->otro_lugar;
        //     $data[$i]['plaza_venta'] = $dato[$i]->plaza_venta;
        //     $data[$i]['tipo'] = $dato[$i]->tipo;
        //     $data[$i]['estado_civil'] = $dato[$i]->estado_civil;
        //     $data[$i]['regimen_matrimonial'] = $dato[$i]->regimen_matrimonial;
        //     $data[$i]['nombre_conyuge'] = $dato[$i]->nombre_conyuge;
        //     // $data[$i]['calle'] = $dato[$i]->calle;
        //     // $data[$i]['numero'] = $dato[$i]->numero;
        //     // $data[$i]['colonia'] = $dato[$i]->colonia;
        //     // $data[$i]['municipio'] = $dato[$i]->municipio;
        //     // $data[$i]['estado'] = $dato[$i]->estado;
        //     // $data[$i]['codigo_postal'] = $dato[$i]->codigo_postal;
        //     $data[$i]['tipo_vivienda'] = $dato[$i]->tipo_vivienda;
        //     $data[$i]['ocupacion'] = $dato[$i]->ocupacion;
        //     $data[$i]['empresa'] = $dato[$i]->empresa;
        //     $data[$i]['puesto'] = $dato[$i]->puesto;
        //     $data[$i]['edadFirma'] = $dato[$i]->edadFirma;
        //     $data[$i]['antiguedad'] = $dato[$i]->antiguedad;
        //     $data[$i]['domicilio_empresa'] = $dato[$i]->domicilio_empresa;
        //     $data[$i]['telefono_empresa'] = $dato[$i]->telefono_empresa;
        //     $data[$i]['originario'] = $dato[$i]->originario;
        //     $data[$i]['noRecibo'] = $dato[$i]->noRecibo;
        //     $data[$i]['engancheCliente'] = $dato[$i]->engancheCliente;
        //     $data[$i]['concepto'] = $dato[$i]->concepto;
        //     $data[$i]['fechaEnganche'] = $dato[$i]->fechaEnganche;
        //     $data[$i]['idTipoPago'] = $dato[$i]->idTipoPago;
        //     $data[$i]['expediente'] = $dato[$i]->expediente;
        //     $data[$i]['status'] = $dato[$i]->status;
        //     $data[$i]['idLote'] = $dato[$i]->idLote;
        //     $data[$i]['fechaApartado'] = $dato[$i]->fechaApartado;
        //     $data[$i]['fechaVencimiento'] = $dato[$i]->fechaVencimiento;
        //     $data[$i]['usuario'] = $dato[$i]->usuario;
        //     $data[$i]['idCondominio'] = $dato[$i]->idCondominio;
        //     $data[$i]['fecha_creacion'] = $dato[$i]->fecha_creacion;
        //     $data[$i]['creado_por'] = $dato[$i]->creado_por;
        //     $data[$i]['fecha_modificacion'] = $dato[$i]->fecha_modificacion;
        //     $data[$i]['modificado_por'] = $dato[$i]->modificado_por;
        //     $data[$i]['nombreCondominio'] = $dato[$i]->nombreCondominio;
        //     $data[$i]['nombreResidencial'] = $dato[$i]->nombreResidencial;
        //     $data[$i]['nombreLote'] = $dato[$i]->nombreLote;
        //     $data[$i]['asesor'] = $dato[$i]->asesor;
        //     $data[$i]['gerente'] = $dato[$i]->gerente;
        //     $data[$i]['coordinador'] = $dato[$i]->coordinador;

        //     $dataRef = $this->Asesor_model->getReferenciasCliente($dato[$i]->id_cliente);
        //     $dataPrCon = $this->Asesor_model->getPrimerContactoCliente($dato[$i]->lugar_prospeccion);
        //     $dataVenComp = $this->Asesor_model->getVentasCompartidas($dato[$i]->id_cliente);
        //     $data[$i]['primerContacto'] = $dataPrCon[0]->nombre;

        //     for($n=0; $n < count($dataRef); $n++)
        //     {
        //         $data[$i]['idreferencia'.($n+1)] = $dataRef[$n]->id_referencia;
        //         $data[$i]['referencia'.($n+1)] = $dataRef[$n]->nombre;
        //         $data[$i]['telreferencia'.($n+1)] = $dataRef[$n]->telefono;
        //     }
        //     if(count($dataVenComp)<=0)
        //     {
        //         $data[$i]['asesor2'] = "N/A";
        //         $data[$i]['asesor3'] = "N/A";
        //     }
        //     else
        //     {
        //         for($a=0; $a<count($dataVenComp); $a++)
        //         {
        //             if(count($dataVenComp)>0)
        //             {
        //                 $data[$i]['asesor'.($a+1+1)] = $dataVenComp[$a]->nombre;
        //             }
        //             else{
        //                 $data[$i]['asesor'.($a+1+1)] = "";
        //             }

        //         }
        //     }
        // }
        if($dato != null) {

            echo json_encode($dato);

        }
        else
        {

            echo json_encode(array());
        }
    }




        public function deposito_seriedad($id_cliente, $onlyView){

        $datos=array();
        $datos["cliente"]= $this->Asesor_model->selectDS($id_cliente);
        $datos["referencias"]= $this->Asesor_model->selectDSR($id_cliente);
		$datos["referencias"] = (isset($datos["referencias"])) ? 0 : $datos["referencias"]; 

        $datos["asesor"]= $this->Asesor_model->selectDSAsesor($id_cliente);
        $datos["asesor2"]= $this->Asesor_model->selectDSAsesorCompartido($id_cliente);
        $datos["copropiedad"]= $this->Asesor_model->selectDSCopropiedad($id_cliente);
        $datos["copropiedadTotal"]= $this->Asesor_model->selectDSCopropiedadCount($id_cliente);

        $datos['onlyView'] = $onlyView;




        $this->load->view('template/header');
        $this->load->view('asesor/deposito_formato',$datos);

    }



    public function imprimir_ds($id_cliente){
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $informacion_cliente = $this->Asesor_model->getinfoCliente($id_cliente);
        /*print_r($informacion_cliente->row());
        exit;*/
        $informacion_referencias = $this->Asesor_model->getinfoReferencias($id_cliente);
        $informacion_copropietarios = $this->Asesor_model->getinfoCopropietario($id_cliente);

        $informacion_asesor = $this->Asesor_model->selectDSAsesor1($id_cliente);
        $informacion_asesor2 = $this->Asesor_model->selectDSAsesorCompartido1($id_cliente);


             /////////////////////////////////////////////////////////////////////////////////////////

            if($informacion_cliente->row()->tipoLote){
                if($informacion_cliente->row()->tipoLote == 1 || $informacion_cliente->row()->tipoLote == '1'){
                    $tpl1 = '<input type="radio" name="tipoLote" id="tipoLote" value="1" checked="checked" readonly> Lote';
                    $tpl2 = '<input type="radio" name="tipoLote" id="tipoLote" value="2" readonly> Lote Comercial';
                }
                if($informacion_cliente->row()->tipoLote == 2 || $informacion_cliente->row()->tipoLote == '2'){
                    $tpl1 = '<input type="radio" name="tipoLote" id="tipoLote" value="1" readonly> Lote';
                    $tpl2 = '<input type="radio" name="tipoLote" id="tipoLote" value="2" checked="checked" readonly> Lote Comercial';
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////////

            if($informacion_cliente->row()->desarrollo) {
                 // $arreglo_ds["desarrollo"]= $desarrollo;
                if($informacion_cliente->row()->desarrollo == 1){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" checked="checked" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($informacion_cliente->row()->desarrollo == 2){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" checked="checked" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($informacion_cliente->row()->desarrollo == 3){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" checked="checked" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($informacion_cliente->row()->desarrollo == 4){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" checked="checked" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($informacion_cliente->row()->desarrollo == 5){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" checked="checked" readonly> Mérida';
                }
            }
            else if(!$informacion_cliente->row()->desarrollo){
                // $arreglo_ds["desarrollo"]= '0';
            }


            /////////////////////////////////////////////////////////////////////////////////////////


            if($informacion_cliente->row()->idOficial_pf) {
                $id_identificacion = '<input type="checkbox" readonly name="idOficial_pf" id="idOficial_pf" value="1" checked="checked"> Identificación&nbsp;Oficial';
            }
            else if(!$informacion_cliente->row()->idOficial_pf){
                $id_identificacion = '<input type="checkbox" readonly name="idOficial_pf" id="idOficial_pf" value="1"> Identificación&nbsp;Oficial';
            }
            //----------------------------------------------------------------------------------------------------------
            if($informacion_cliente->row()->idDomicilio_pf) {
                $id_domicilio = '<input type="checkbox" readonly name="idDomicilio_pf" id="idDomicilio_pf" value="1" checked="checked"> Comprobante&nbsp;de&nbsp;Domicilio';
            }
            else if(!$informacion_cliente->row()->idDomicilio_pf){
                $id_domicilio = '<input type="checkbox" readonly name="idDomicilio_pf" id="idDomicilio_pf" value="1"> Comprobante&nbsp;de&nbsp;Domicilio';
            }
            //----------------------------------------------------------------------------------------------------------
            if($informacion_cliente->row()->actaMatrimonio_pf) {
                 $id_acta_m = '<input type="checkbox" readonly name="actaMatrimonio_pf" id="actaMatrimonio_pf" value="1" checked="checked"> Acta&nbsp;de&nbsp;Matrimonio';
            }
            else if(!$informacion_cliente->row()->actaMatrimonio_pf){
                $id_acta_m = '<input type="checkbox" readonly name="actaMatrimonio_pf" id="actaMatrimonio_pf" value="1"> Acta&nbsp;de&nbsp;Matrimonio';
            }
            //----------------------------------------------------------------------------------------------------------
            if($informacion_cliente->row()->actaConstitutiva_pm) {
                $id_acta_c = '<input type="checkbox" readonly name="actaConstitutiva_pm" id="actaConstitutiva_pm" value="1" checked="checked"> Acta&nbsp;Constitutiva';
            }
            else if(!$informacion_cliente->row()->actaConstitutiva_pm){
                $id_acta_c = '<input type="checkbox" readonly name="actaConstitutiva_pm" id="actaConstitutiva_pm" value="1"> Acta&nbsp;Constitutiva';
            }
            //----------------------------------------------------------------------------------------------------------
            if($informacion_cliente->row()->poder_pm) {
                $id_poder = '<input type="checkbox" readonly name="poder_pm" id="poder_pm" value="1" checked="checked"> Poder';
            }
            else if(!$informacion_cliente->row()->poder_pm){
                $id_poder = '<input type="checkbox" readonly name="poder_pm" id="poder_pm" value="1"> Poder';
            }
            //----------------------------------------------------------------------------------------------------------
            if($informacion_cliente->row()->idOficialApoderado_pm) {
                $id_apoderado = '<input type="checkbox" readonly name="idOficialApoderado_pm" id="idOficialApoderado_pm" value="1" checked="checked"> Identificación&nbsp;Oficial&nbsp;Apoderado';
            }
            else if(!$informacion_cliente->row()->idOficialApoderado_pm){
                $id_apoderado = '<input type="checkbox" readonly name="idOficialApoderado_pm" id="idOficialApoderado_pm" value="1"> Identificación&nbsp;Oficial&nbsp;Apoderado';
            }

            // //----------------------------------------------------------------------------------------------------------
            // /////////////////////////////////////////////////////////////////////////////////////////////////////////////


             if($informacion_cliente->row()->tipo_vivienda) {
                 // $arreglo_cliente["tipo_vivienda"]= $tipo_vivienda;

                if($informacion_cliente->row()->tipo_vivienda == 1){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" checked="checked" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($informacion_cliente->row()->tipo_vivienda == 2){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" checked="checked" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($informacion_cliente->row()->tipo_vivienda == 3){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" checked="checked" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($informacion_cliente->row()->tipo_vivienda == 4){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" checked="checked" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($informacion_cliente->row()->tipo_vivienda == 5){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" checked="checked" readonly> OTRO';
                }
            }
            else if(!$informacion_cliente->row()->tipo_vivienda){
                // $arreglo_cliente["tipo_vivienda"]= '0';
            }


             //CONVERTIMOS A ARREGLO TANTO LOS DESCUENTOS ACTUALES COMO EL NUEVO A AGREGAR
            $arrayCorreo = explode(",", 'kelyn.rodriguez23@gmail.com');

            // CHECAMOS SI EN EL ARREGLO NO HAY POSICIONES VACIAS Y LAS ELIMINAMOS
            $listCheckVacio = array_filter($arrayCorreo, "strlen");

            //VERIFICAMOS QUE NUESTRO ARREGLO NO TENGA DATOS REPETIDOS
            $arrayCorreoNotRepeat=array_unique($listCheckVacio);

            //EL ARREGLO FINAL LO CONVERTIMOS A STRING
            // $resCorreo = implode( ",", $arrayCorreoNotRepeat);

            $this->load->library('Pdf');
            $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
            // $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sistemas María José Martínez Martínez');
            $pdf->SetTitle('DEPÓSITO DE SERIEDAD');
            $pdf->SetSubject('CONSTANCIA DE RELACION EMPRESA TRABAJADOR');
            $pdf->SetKeywords('CONSTANCIA, CIUDAD MADERAS, RELACION, EMPRESA, TRABAJADOR');
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, 0);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('Helvetica', '', 9, '', true);
            $pdf->SetMargins(15, 15, 15, true);
            $pdf->AddPage('P', 'LEGAL');
            $pdf->SetFont('Helvetica', '', 5, '', true);
            $pdf->SetFooterMargin(0);
            $bMargin = $pdf->getBreakMargin();
            $auto_page_break = $pdf->getAutoPageBreak();
            $pdf->Image('static/images/ar4c.png', 120, 15, 300, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
            $pdf->setPageMark();


$html = '<!DOCTYPE html>
            <html lang="en">
            <head>
            <link rel="shortcut icon" href="'.base_url().'static/images/arbol_cm.png" />
            <link href="<?=base_url()?>dist/css/bootstrap.min.css" rel="stylesheet" />
            <!--  Material Dashboard CSS    -->
            <link href="<?=base_url()?>dist/css/material-dashboard.css" rel="stylesheet" />
            <!--  CSS for Demo Purpose, don\'t include it in your project     -->
            <link href="<?=base_url()?>dist/css/demo.css" rel="stylesheet" />
            <!--     Fonts and icons     -->
            <link href="<?=base_url()?>dist/css/font-awesome.css" rel="stylesheet" />
            <link href="<?=base_url()?>dist/css/google-roboto-300-700.css" rel="stylesheet" />
            <style>
            body{color: #084c94;}
            .espacio{padding: 5%;}
            .espaciodos{padding: 10%;} 
            h2{font-weight: bold;color: #084c94;}
            .save {display:scroll;position:fixed;bottom:225px;right:17px;z-index: 3;}
            p{color: #084c94;}
            .col-xs-16 {width: 3px;float: left;}
            .col-xs-17 {width: 16%;float: left;}
            #imagenbg {position: relative;top:1500px;z-index: -1;}
            #fichadeposito {position: absolute;z-index: 2;}
            .mySectionPdf
            {
                padding: 20px;
            }
            .form-group.is-focused .form-control 
            {
                outline: none;
                background-image: linear-gradient(#0c63c5, #177beb), linear-gradient(#D2D2D2, #D2D2D2);
                background-size: 100% 2px, 100% 1px;
                box-shadow: none;
                transition-duration: 0.3s;
            }
            b
            {
                font-size: 8px;
            }
            </style>
            </head>

            <body>
            <div id="fichadeposito" name="fichadeposito" class="fichadeposito">
            <div id="muestra">
            <table border="0" width="100%" id="tabla" align="center">
            <tr>
            
            <td width="70%" align="left">
             <label>
            <h1 style="margin-right: 50px;"> DEPÓSITO DE SERIEDAD</h1>
            </label>
            </td>

            <td align="right" width="15%">
            <br><br><br>
            <p style="margin-right: 2px;">FOLIO</p>
            </td>

            <td width="15%" style="border-bottom:1px solid #CCCCCC">
            <p style="color: red;font-size:14px;">'.$informacion_cliente->row()->clave.'</p>
            </td>

            </tr>
            </table>

            <table border="0" width="100%" align="" align="">
            <tr>
            <th rowspan="4" width="283" align="left">
            <img src="'.base_url().'/static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width: 250px"/>
            </th>

            <td width="367">
            <h5><p style="font-size:9px;"><strong>DESARROLLO:</strong></p></h5>
            </td>
            </tr>

            <tr>
            <td width="367">
            <table border="0" width="100%">
            <tr>
            <td width="20%">'.$d1.'</td>
            <td width="20%">'.$d2.'</td>
            <td width="20%">'.$d3.'</td>
            <td width="20%">'.$d4.'</td>
            <td width="20%">'.$d5.'</td>
            </tr>

            <tr>
            <td width="20%">'.$tpl1.'</td>
            <td width="20%">'.$tpl2.'</td>
            <td width="20%"></td>
            <td width="20%"></td>
            <td width="20%"></td>
            </tr>

            </table>
            </td>
            </tr>

            <tr>
            <td>
            <h5><p style="font-size:9px;"><strong>DOCUMENTACIÓN ENTREGADA:</strong></p></h5>
            </td>
            </tr>

            <tr>
            <td>
            <table border="0" width="100%">
            <tr>
            <td width="19 %"><p><strong>Personas&nbsp;Físicas</strong></p></td>
            <td width="23%">'.$id_identificacion.'</td>
            <td width="27%">'.$id_domicilio.'</td>
            <td width="29%" colspan="2">'.$id_acta_m.'</td>
            </tr>

            <tr>
            <td width="19%"><p><strong>Personas&nbsp;Morales</strong></p></td>
            <td width="23%">'.$id_acta_c.'</td>
            <td width="27%">'.$id_poder.'</td>
            <td width="29%" colspan="2">'.$id_apoderado.'</td>
            </tr>

            <tr>
            <td width="19%"></td>
            <td width="23%"><b>RFC:</b> '.$informacion_cliente->row()->rfc.'</td>
            <td width="27%"></td>
            <td width="29%" colspan="2"></td>
            </tr>

            </table>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2">
            <br>
            </td>
            </tr>
            
            <tr>
            <td width="40%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
            <label>NOMBRE(<b><span style="color: red;">*</span></b>):</label><br><br><b>&nbsp;'.$informacion_cliente->row()->nombre.' <br></b>
            </td>
            <td width="30%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
            <label>APELLIDO PATERNO(<b><span style="color: red;">*</span></b>):</label><br><br><b>&nbsp;'.$informacion_cliente->row()->apellido_paterno.' <br></b>
            </td>
            <td width="30%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
            <label>APELLIDO MATERNO(<b><span style="color: red;">*</span></b>):</label><br><br><b>&nbsp;'.$informacion_cliente->row()->apellido_materno.' <br></b>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>

            <tr>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>TELÉFONO CASA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->telefono1.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>CELULAR (<b><span style="color: red;">*</span></b>) </label><br><br><b>&nbsp;'.$informacion_cliente->row()->telefono2.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label> EMAIL (<b><span style="color: red;">*</span></b>)
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->correo.'</b><br>
            </td>
            </tr>
            
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA DE NACIMIENTO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->fecha_nacimiento.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>NACIONALIDAD:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->nacionalidad_valor.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>ORIGINARIO DE:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->originario.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>ESTADO CIVIL:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->estado_valor.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>NOMBRE CONYUGE:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->nombre_conyuge.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>RÉGIMEN:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->regimen_valor.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>DOMICILIO PARTICULAR:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->domicilio_particular.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>OCUPACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->ocupacion.'</b><br>
            </td>
            <td width="35%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EMPRESA EN LA QUE TRABAJA:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->empresa.'</b><br>
            </td>
            <td width="35%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>PUESTO:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->puesto.'</b><br>
            </td>
            <td width="10%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>ANTIGÜEDAD:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->antiguedad.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EDAD:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->edadFirma.'</b><br>
            </td>
            <td width="70%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>DOMICILIO EMPRESA:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->domicilio_empresa.'</b><br>
            </td>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>TELÉFONO EMPRESA:
                </label><br><br><b>&nbsp;'.$informacion_cliente->row()->telefono_empresa.'</b><br>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
 
            <tr>
            <td width="15%" colspan="2"><b>VIVE EN CASA:</b></td>
            <td width="10%">'.$tv1.'</td>
            <td width="10%">'.$tv2.'</td>
            <td width="10%">'.$tv3.'</td>
            <td width="10%">'.$tv4.'</td>
            <td width="10%">'.$tv5.'</td>
            </tr>
            <tr><td><br></td></tr>
            ';


            if($informacion_copropietarios->num_rows() > 0) {
                $html .= '<tr><td width="100%" colspan="2" style="background-color:#BECFDC;"><b style="font-size:1.7em;">DATOS COOPROPIETARIOS:</b><br></td></tr>';
            }
            else{
                $html .= '';
            }


            if($informacion_copropietarios->num_rows() > 0) {
                foreach ($informacion_copropietarios->result() as $row) {
                    $html .= '<tr style="background-color:#BECFDC;">
                    <td width="22%"><b>NOMBRE: </b>'.$row->nombre.' '.$row->apellido_paterno.' '.$row->apellido_materno.'</td>
                    <td width="26%"><b>PERSONALIDAD JURÍDICA: </b>'.$row->personalidad_juridica.'</td>
                    <td width="12%"><b>RFC: </b>'.$row->rfc.'</td>
                    <td width="16%"><b>CORREO: </b>'.$row->correo.'</td>
                    <td width="12%"><b>TEL: </b>'.$row->telefono.'</td>
                    <td width="12%"><b>TEL 2: </b>'.$row->telefono_2.'</td>
                    </tr>

                    <tr style="background-color:#BECFDC;">
                    <td width="22%"><b>FECHA NACIMIENTO: </b>'.$row->fecha_nacimiento.'</td>
                    <td width="26%"><b>NACIONALIDAD: </b>'.$row->nacionalidad.'</td>
                    <td width="12%"><b>EDAD FIRMA: </b>'.$row->edadFirma.'</td>
                    <td width="16%"><b>ESTADO CIVIL: </b>'.$row->estado_civil.'</td>
                    <td width="24%"><b>CONYUGE: </b>'.$row->conyuge.'</td>
                    </tr>

                    <tr style="background-color:#BECFDC;">
                    <td width="22%"><b>REGIMEN: </b>'.$row->regimen_matrimonial.'</td>
                    <td width="26%"><b>DOMICILIO: </b>'.$row->domicilio_particular.'</td>
                    <td width="28%"><b>ORIGINARIO DE: </b>'.$row->originario_de.'</td>
                    <td width="24%"><b>TIPO VIVIENDA: </b>'.$row->tipo_vivienda.'</td>
                    </tr>
                    
                    <tr style="background-color:#BECFDC;">
                    <td width="22%"><b>OCUPACIÓN: </b>'.$row->ocupacion.'</td>
                    <td width="26%"><b>EMPRESA: </b>'.$row->empresa.'</td>
                    <td width="28%"><b>PUESTO: </b>'.$row->posicion.'</td>
                    <td width="24%"><b>ANTIGÜEDAD: </b>'.$row->antiguedad.'</td>
                    </tr>

                    <tr style="background-color:#BECFDC;">
                    <td width="100%"><b>DIRECCIÓN EMPRESA: </b>'.$row->direccion.'</td>
                    </tr>

                    <tr style="background-color:#BECFDC;">
                    <td width="100%"><br></td>
                    </tr>';
                }
            }
            else{
                $html .= '';
            }

            // cop.nombre
            // apellido_paterno
            // apellido_materno,
            // ox.nombre as personalidad_juridica
            // rfc
            // correo
            // telefono
            // telefono_2
            // fecha_nacimiento,
            // ox2.nombre as nacionalidad
            // ox3.nombre as estado_civil
            // conyuge
            // ox4.nombre as regimen_matrimonial
            // domicilio_particular
            // originario_de
            // ox5.nombre as tipo_vivienda
            // ocupacion
            // empresa
            // posicion
            // antiguedad
            // direccion
            // edadFirma


            $html .= '<tr>
            <td width="100%" colspan="2"></td>
            </tr>
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>

            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>El Sr.(a):
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->nombre.' '.$informacion_cliente->row()->apellido_paterno.' '.$informacion_cliente->row()->apellido_materno.'</b><br>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>SE COMPROMETE A ADQUIRIR:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->nombreLote.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EN EL CLÚSTER:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->nombreCondominio.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>DE SUP APROX:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->sup.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>NO. REFERENCIA PAGO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->referencia.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>COSTO POR M<sup>2</sup> LISTA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->costoM2.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>COSTO POR M<sup>2</sup> FINAL:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->costom2f.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>UNA VEZ QUE SEA AUTORIZADO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->proyecto.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EN EL MUNICIPIO DE:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->municipio2.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>LA UBICACIÓN DE LOTE PUEDE VARIAR DEBIDO A AJUSTES DEL PROYECTO
                </label><br><br><br>
            </td>
            </tr>


            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>IMPORTE DE LA OFERTA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->importOferta.'</b><br>
            </td>
            <td width="75%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>IMPORTE EN LETRA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->letraImport.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label><label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $: </label><b>'.$informacion_cliente->row()->cantidad.'</b> <b> ( '.$informacion_cliente->row()->letraCantidad.' ), </b> misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo.El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma:</label> 
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>SALDO DE DEPÓSITO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->saldoDeposito.'</b><br>
            </td>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>APORTACIÓN MENSUAL:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->aportMensualOfer.'</b><br>
            </td>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA 1° APORTACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->fecha1erAport.'</b><br>
            </td>
            <td width="10%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>PLAZO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->plazo.'</b><br>
            </td>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA LIQUIDACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->fechaLiquidaDepo.'</b><br>
            </td>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA 2° APORTACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->fecha2daAport.'</b><br>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label align="justify">Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.</label> 
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>En el Municipio de <b>'.$informacion_cliente->row()->municipio2.'</b> a <b>'.$informacion_cliente->row()->dia.'</b> del mes <b>'.$informacion_cliente->row()->mes.'</b> del año <b>'.$informacion_cliente->row()->anio.'</b>.</label> 
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <br><br><br><br><br> 
            <td width="70%" align="center">'.$informacion_cliente->row()->nombre.' '.$informacion_cliente->row()->apellido_paterno.' '.$informacion_cliente->row()->apellido_materno.'
            <BR> ______________________________________________________________________________<p>Nombre y Firma / Ofertante</p><p>Acepto que se realice una verificación de mis datos, en los teléfonos<br> y correos que proporciono para el otorgamiento del crédito.</p>
            </td>

            <td width="30%" align="center"><label><b>REFERENCIAS PERSONALES</b>.</label>

            ';

            if($informacion_referencias->num_rows() > 0) {
                foreach ($informacion_referencias->result() as $row) {
                    $html .= '<br><p align="left">'.$row->nombre.' - '.$row->parentezco.' - '.$row->telefono.'</p>';
                }
            }
            else{
                $html .= '<br><p align="left">SIN REFERENCIAS PERSONALES</p>';
            }

            $html .= '</td></tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>OBSERVACIONES:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$informacion_cliente->row()->observacion.'</b><br>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>';

             if($informacion_asesor->num_rows() > 0) {

                if($informacion_asesor2->num_rows() > 0)
                {
                     foreach ($informacion_asesor2->result() as $row) {
                    $valor .= $informacion_asesor2->row()->nombreAsesor." - ";
                    $valo2 .= $informacion_asesor2->row()->nombreGerente." - ";
                }

                $html .= '<tr><br><br><br><br><br> <td width="50%" align="center">'.$valor.$informacion_asesor->row()->nombreAsesor.'<BR> ______________________________________________________________________________<p> <b>Nombre y Firma / Asesor</b></p></td>
                    <td width="50%" align="center">'.$valo2.$informacion_asesor->row()->nombreGerente.'<BR> ______________________________________________________________________________<p> 
                    <b>Nombre y Firma / Autorización de operación</b></p>
                    </td></tr>';
                }
                else
                {
                     $html .= '<tr><br><br><br><br><br> <td width="50%" align="center">'.$informacion_asesor->row()->nombreAsesor.'<BR> ______________________________________________________________________________<p> <b>Nombre y Firma / Asesor</b></p></td>
                    <td width="50%" align="center">'.$informacion_asesor->row()->nombreGerente.'<BR> ______________________________________________________________________________<p> 
                    <b>Nombre y Firma / Autorización de operación</b></p>
                    </td></tr>';
                }
            }


            else{
                $html .= '<br><p align="left">SIN REFERENCIAS PERSONALES</p>';
            }


            $html .= '<tr>
            <td width="100%" align="center">
            <table border="0" width="91%" style="background-color:#ffffff;">
            <tr>
            <td></td>
            </tr>
            </table>
            </td>
            </tr>

            </table>
            </td>


            </div>
            </div>
            </body>
            </html>';

            $pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

            ob_end_clean();
            $namePDF =  $pdf->Output(utf8_decode('DEPÓSITO_DE_SERIEDAD.pdf'), 'I');
            $attachment= $pdf->Output(utf8_decode($namePDF), 'S');
        }



    public function editar_ds(){

        setlocale(LC_MONETARY, 'en_US');

        $array1=$this->input->post("email_cop[]");
        $array2=$this->input->post("telefono1_cop[]");
        $array3=$this->input->post("telefono2_cop[]");
        $array4=$this->input->post("fnacimiento_cop[]");
        $array5=$this->input->post("nacionalidad_cop[]");
        $array6=$this->input->post("originario_cop[]");

        $array7=$this->input->post("id_particular_cop[]");
        $array8=$this->input->post("ecivil_cop[]");
        $array9=$this->input->post("conyuge_cop[]");
        $array10=$this->input->post("r_matrimonial_cop[]");
        $array11=$this->input->post("ocupacion_cop[]");
        $array12=$this->input->post("puesto_cop[]");

        $array13=$this->input->post("empresa_cop[]");
        $array14=$this->input->post("antiguedad_cop[]");
        $array15=$this->input->post("edadFirma_cop[]");
        $array16=$this->input->post("dom_emp_cop[]");

        $array17=$this->input->post("id_cop[]");



        if($this->input->post("id_cop[]")){
            for($i = 0; $i<=5; $i++){
                $valor_coprop = '<input type="radio" name="tipoLote" id="tipoLote" value="1" checked="checked" readonly> yeii';
            }
        }
        else{
            $valor_coprop = '<input type="radio" name="tipoLote" id="tipoLote" value="1" checked="checked" readonly> Lote';
        }


            $clave_folio = $this->input->post('clavevalor');
            $id_cliente = $this->input->post('id_cliente');

            $desarrollo = $this->input->post('desarrollo');
            $tipoLote = $this->input->post('tipoLote_valor');

            $asesor_datos = $this->input->post('asesor_datos');
            $gerente_datos = $this->input->post('gerente_datos');

            //VALORES SELECT
            $nac_select = $this->input->post('nac_select');
            $ecivil_select = $this->input->post('ecivil_select');
            $regimen_select = $this->input->post('regimen_select');
            $parentezco_select1 = $this->input->post('parentezco_select1');
            $parentezco_select2 = $this->input->post('parentezco_select2');

            //DOCUMENTACIÓN
            //PERSONA FISICA
            $idOficial_pf = $this->input->post('idOficial_pf');
            $idDomicilio_pf = $this->input->post('idDomicilio_pf');
            $actaMatrimonio_pf = $this->input->post('actaMatrimonio_pf');

            //PERSONA MORAL
            $poder_pm = $this->input->post('poder_pm');
            $actaConstitutiva_pm = $this->input->post('actaConstitutiva_pm');
            $idOficialApoderado_pm = $this->input->post('idOficialApoderado_pm');
            $rfc = $this->input->post('rfc');

            $nombre = $this->input->post('nombre');
            $apellido_paterno = $this->input->post('apellido_paterno');
            $apellido_materno = $this->input->post('apellido_materno');

            $telefono1 = $this->input->post('telefono1');//telefono casa
            $telefono2 = $this->input->post('telefono2');//telefono celular
            $correo = $this->input->post('correo');

            $fecha_nacimiento = $this->input->post('fecha_nacimiento');
            $nacionalidad = $this->input->post('nacionalidad');
            $originario = $this->input->post('originario');

            $estado_civil = $this->input->post('estado_civil');
            $nombre_conyuge = $this->input->post('nombre_conyuge');
            $regimen_matrimonial = $this->input->post('regimen_matrimonial');

            $domicilio_particular = $this->input->post('domicilio_particular');

            $ocupacion = $this->input->post('ocupacion');
            $empresa = $this->input->post('empresa');
            $puesto = $this->input->post('puesto');
            $antiguedad = $this->input->post('antiguedad');

            $edadFirma = $this->input->post('edadFirma');
            $domicilio_empresa = $this->input->post('domicilio_empresa');
            $telefono_empresa = $this->input->post('telefono_empresa');

            $tipo_vivienda = $this->input->post('tipo_vivienda');

            $costoM2 = $this->input->post('costoM2');
            $costom2f = $this->input->post('costom2f');
            $proyecto = $this->input->post('proyecto');
            $municipioDS = $this->input->post('municipioDS');

            $importOferta = $this->input->post('importOferta');
            $letraImport = $this->input->post('letraImport');

            $cantidad = $this->input->post('cantidad');
            $letraCantidad = $this->input->post('letraCantidad');

            $saldoDeposito = $this->input->post('saldoDeposito');
            $aportMensualOfer = $this->input->post('aportMensualOfer');
            $fecha1erAport = $this->input->post('fecha1erAport');
            $plazo = $this->input->post('plazo');
            $fechaLiquidaDepo = $this->input->post('fechaLiquidaDepo');
            $fecha2daAport = $this->input->post('fecha2daAport');

            $municipio2 = $this->input->post('municipio2');
            $dia = $this->input->post('dia');
            $mes = $this->input->post('mes');
            $anio = $this->input->post('anio');

            $nombre1 = $this->input->post('nombre1');
            $nombre2 = $this->input->post('nombre2');
            $parentesco1 = $this->input->post('parentesco1');
            $parentesco2 = $this->input->post('parentesco2');
            $telefono_referencia1 = $this->input->post('telefono_referencia1');
            $telefono_referencia2 = $this->input->post('telefono_referencia2');

            $observacion = $this->input->post('observacion');

            $nombreLote = $this->input->post('nombreLote');
            $nombreCondominio = $this->input->post('nombreCondominio');
            $sup = $this->input->post('sup');
            $referencia = $this->input->post('referencia');

            $id_referencia1 = $this->input->post('id_referencia1');
            $id_referencia2 = $this->input->post('id_referencia2');


            //ARRAY DEPOSITO DE SERIEDAD
            $arreglo_ds=array();
            $arreglo_ds["clave"]=$clave_folio;
            $arreglo_ds["desarrollo"]=$desarrollo;
            $arreglo_ds["tipoLote"]=$tipoLote;
            $arreglo_ds["idOficial_pf"]=$idOficial_pf;
            $arreglo_ds["idDomicilio_pf"]=$idDomicilio_pf;
            $arreglo_ds["actaMatrimonio_pf"]=$actaMatrimonio_pf;
            $arreglo_ds["actaConstitutiva_pm"]=$actaConstitutiva_pm;
            $arreglo_ds["idOficialApoderado_pm"]=$idOficialApoderado_pm;
            $arreglo_ds["costoM2"]=$costoM2;
            $arreglo_ds["costom2f"]=$costom2f;
            $arreglo_ds["proyecto"]=$proyecto;
            $arreglo_ds["municipio"]=$municipioDS;
            $arreglo_ds["importOferta"]=$importOferta;
            $arreglo_ds["letraImport"]=$letraImport;
            $arreglo_ds["cantidad"]=$cantidad;
            $arreglo_ds["letraCantidad"]=$letraCantidad;
            $arreglo_ds["saldoDeposito"]=$saldoDeposito;
            $arreglo_ds["aportMensualOfer"]=$aportMensualOfer;
            $arreglo_ds["fecha1erAport"]=$fecha1erAport;
            $arreglo_ds["plazo"]=$plazo;
            $arreglo_ds["fechaLiquidaDepo"]=$fechaLiquidaDepo;
            $arreglo_ds["fecha2daAport"]=$fecha2daAport;
            $arreglo_ds["municipio2"]=$municipio2;
            $arreglo_ds["dia"]=$dia;
            $arreglo_ds["mes"]=$mes;
            $arreglo_ds["anio"]=$anio;
            $arreglo_ds["observacion"]=$observacion;

            //ARRAY DATOS CLIENTE
            $arreglo_cliente=array();
            $arreglo_cliente["nombre"]=$nombre;
            $arreglo_cliente["apellido_paterno"]=$apellido_paterno;
            $arreglo_cliente["apellido_materno"]=$apellido_materno;
            $arreglo_cliente["telefono1"]=$telefono1;
            $arreglo_cliente["telefono2"]=$telefono2;
            $arreglo_cliente["correo"]=$correo;
            $arreglo_cliente["rfc"]=$rfc;
            $arreglo_cliente["fecha_nacimiento"]=$fecha_nacimiento;
            $arreglo_cliente["nacionalidad"]=$nacionalidad;
            $arreglo_cliente["originario"]=$originario;
            $arreglo_cliente["estado_civil"]=$estado_civil;
            $arreglo_cliente["nombre_conyuge"]=$nombre_conyuge;
            $arreglo_cliente["regimen_matrimonial"]=$regimen_matrimonial;
            $arreglo_cliente["domicilio_particular"]=$domicilio_particular;
            $arreglo_cliente["ocupacion"]=$ocupacion;
            $arreglo_cliente["nombre_conyuge"]=$nombre_conyuge;
            $arreglo_cliente["empresa"]=$empresa;
            $arreglo_cliente["puesto"]=$puesto;
            $arreglo_cliente["antiguedad"]=$antiguedad;
            $arreglo_cliente["edadFirma"]=$edadFirma;
            $arreglo_cliente["domicilio_empresa"]=$domicilio_empresa;
            $arreglo_cliente["telefono_empresa"]=$telefono_empresa;
            $arreglo_cliente["tipo_vivienda"]=$tipo_vivienda;
            $arreglo_cliente["regimen_matrimonial"]=$regimen_matrimonial;

            //ARRAY REFERENCIAS
            $arreglo_referencia1=array();
            $arreglo_referencia1["nombre"]=$nombre1;
            $arreglo_referencia1["telefono"]=$telefono_referencia1;
            $arreglo_referencia1["parentezco"]=$parentesco1;
            $arreglo_referencia2=array();
            $arreglo_referencia2["nombre"]=$nombre2;
            $arreglo_referencia2["telefono"]=$telefono_referencia2;
            $arreglo_referencia2["parentezco"]=$parentesco2;

            // var_dump($arreglo_ds);
            // // var_dump($arreglo_cliente);
            // // var_dump($arreglo_referencia1);
            // // var_dump($arreglo_referencia2);
            /////////////////////////////////////////////////////////////////////////////////////////

            if($this->input->post('tipoLote_valor')) {
                 $arreglo_ds["tipoLote"]= $tipoLote;

                if($this->input->post('tipoLote_valor') == 1 || $this->input->post('tipoLote_valor') == '1'){
                    $tpl1 = '<input type="radio" name="tipoLote" id="tipoLote" value="1" checked="checked" readonly> Lote';
                    $tpl2 = '<input type="radio" name="tipoLote" id="tipoLote" value="2" readonly> Lote Comercial';
                }
                if($this->input->post('tipoLote_valor') == 2 || $this->input->post('tipoLote_valor') == '2'){
                    $tpl1 = '<input type="radio" name="tipoLote" id="tipoLote" value="1" readonly> Lote';
                    $tpl2 = '<input type="radio" name="tipoLote" id="tipoLote" value="2" checked="checked" readonly> Lote Comercial';
                }
            }
            else if(!$this->input->post('tipoLote_valor')){
                $arreglo_ds["tipoLote"]= '0';
            }

            /////////////////////////////////////////////////////////////////////////////////////////


            if($this->input->post('desarrollo')) {
                 $arreglo_ds["desarrollo"]= $desarrollo;

                if($this->input->post('desarrollo') == 1){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" checked="checked" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($this->input->post('desarrollo') == 2){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" checked="checked" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($this->input->post('desarrollo') == 3){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" checked="checked" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($this->input->post('desarrollo') == 4){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" checked="checked" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" readonly> Mérida';
                }
                if($this->input->post('desarrollo') == 5){
                    $d1 = '<input type="radio" name="desarrollo" id="desarrollo" value="1" readonly> Queretaro';
                    $d2 = '<input type="radio" name="desarrollo" id="desarrollo" value="2" readonly> Leon';
                    $d3 = '<input type="radio" name="desarrollo" id="desarrollo" value="3" readonly> Celaya';
                    $d4 = '<input type="radio" name="desarrollo" id="desarrollo" value="4" readonly> San Luis Potosí';
                    $d5 = '<input type="radio" name="desarrollo" id="desarrollo" value="5" checked="checked" readonly> Mérida';
                }
            }
            else if(!$this->input->post('desarrollo')){
                $arreglo_ds["desarrollo"]= '0';
            }

            /////////////////////////////////////////////////////////////////////////////////////////

            if($this->input->post('idOficial_pf')) {
                $arreglo_ds["idOficial_pf"] = $idOficial_pf;
                $id_identificacion = '<input type="checkbox" readonly name="idOficial_pf" id="idOficial_pf" value="1" checked="checked"> Identificación&nbsp;Oficial';
            }
            else if(!$this->input->post('idOficial_pf')){
                $id_identificacion = '<input type="checkbox" readonly name="idOficial_pf" id="idOficial_pf" value="1"> Identificación&nbsp;Oficial';
                $arreglo_ds["idOficial_pf"] = '0';
            }
            //----------------------------------------------------------------------------------------------------------
            if($this->input->post('idDomicilio_pf')) {
                $arreglo_ds["idDomicilio_pf"] = $idDomicilio_pf;
                $id_domicilio = '<input type="checkbox" readonly name="idDomicilio_pf" id="idDomicilio_pf" value="1" checked="checked"> Comprobante&nbsp;de&nbsp;Domicilio';
            }
            else if(!$this->input->post('idDomicilio_pf')){
                $id_domicilio = '<input type="checkbox" readonly name="idDomicilio_pf" id="idDomicilio_pf" value="1"> Comprobante&nbsp;de&nbsp;Domicilio';
                $arreglo_ds["idDomicilio_pf"] = '0';
            }
            //----------------------------------------------------------------------------------------------------------
            if($this->input->post('actaMatrimonio_pf')) {
                $arreglo_ds["actaMatrimonio_pf"] = $actaMatrimonio_pf;
                $id_acta_m = '<input type="checkbox" readonly name="actaMatrimonio_pf" id="actaMatrimonio_pf" value="1" checked="checked"> Acta&nbsp;de&nbsp;Matrimonio';
            }
            else if(!$this->input->post('actaMatrimonio_pf')){
                $id_acta_m = '<input type="checkbox" readonly name="actaMatrimonio_pf" id="actaMatrimonio_pf" value="1"> Acta&nbsp;de&nbsp;Matrimonio';
                $arreglo_ds["actaMatrimonio_pf"] = '0';
            }
            //----------------------------------------------------------------------------------------------------------
            if($this->input->post('actaConstitutiva_pm')) {
                $arreglo_ds["actaConstitutiva_pm"] = $actaConstitutiva_pm;
                $id_acta_c = '<input type="checkbox" readonly name="actaConstitutiva_pm" id="actaConstitutiva_pm" value="1" checked="checked"> Acta&nbsp;Constitutiva';
            }
            else if(!$this->input->post('actaConstitutiva_pm')){
                $id_acta_c = '<input type="checkbox" readonly name="actaConstitutiva_pm" id="actaConstitutiva_pm" value="1"> Acta&nbsp;Constitutiva';
                $arreglo_ds["actaConstitutiva_pm"] = '0';
            }
            //----------------------------------------------------------------------------------------------------------
            if($this->input->post('poder_pm')) {
                $arreglo_ds["poder_pm"] = $poder_pm;
                $id_poder = '<input type="checkbox" readonly name="poder_pm" id="poder_pm" value="1" checked="checked"> Poder';
            }
            else if(!$this->input->post('poder_pm')){
                $id_poder = '<input type="checkbox" readonly name="poder_pm" id="poder_pm" value="1"> Poder';
                $arreglo_ds["poder_pm"] = '0';
            }
            //----------------------------------------------------------------------------------------------------------
            if($this->input->post('idOficialApoderado_pm')) {
                $arreglo_ds["idOficialApoderado_pm"] = $idOficialApoderado_pm;
                $id_apoderado = '<input type="checkbox" readonly name="idOficialApoderado_pm" id="idOficialApoderado_pm" value="1" checked="checked"> Identificación&nbsp;Oficial&nbsp;Apoderado';
            }
            else if(!$this->input->post('idOficialApoderado_pm')){
                $id_apoderado = '<input type="checkbox" readonly name="idOficialApoderado_pm" id="idOficialApoderado_pm" value="1"> Identificación&nbsp;Oficial&nbsp;Apoderado';
                $arreglo_ds["idOficialApoderado_pm"] = '0';
            }
            //----------------------------------------------------------------------------------------------------------

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////


             if($this->input->post('tipo_vivienda')) {
                 $arreglo_cliente["tipo_vivienda"]= $tipo_vivienda;

                if($this->input->post('tipo_vivienda') == 1){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" checked="checked" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($this->input->post('tipo_vivienda') == 2){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" checked="checked" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($this->input->post('tipo_vivienda') == 3){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" checked="checked" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($this->input->post('tipo_vivienda') == 4){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" checked="checked" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" readonly> OTRO';
                }
                if($this->input->post('tipo_vivienda') == 5){
                    $tv1 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" readonly> PROPIA';
                    $tv2 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="2" readonly> RENTADA';
                    $tv3 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" readonly> PAGÁNDOSE';
                    $tv4 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="4" readonly> FAMILIAR';
                    $tv5 = '<input type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" checked="checked" readonly> OTRO';
                }
            }
            else if(!$this->input->post('tipo_vivienda')){
                $arreglo_cliente["tipo_vivienda"]= '0';
            }



            if($this->input->post('pdfOK') != null || $this->input->post('pdfOK') == '1' ) {


             //CONVERTIMOS A ARREGLO TANTO LOS DESCUENTOS ACTUALES COMO EL NUEVO A AGREGAR
            $arrayCorreo = explode(",", 'programador.analista5@ciudadmaderas.com');

            // CHECAMOS SI EN EL ARREGLO NO HAY POSICIONES VACIAS Y LAS ELIMINAMOS
            $listCheckVacio = array_filter($arrayCorreo, "strlen");

            //VERIFICAMOS QUE NUESTRO ARREGLO NO TENGA DATOS REPETIDOS
            $arrayCorreoNotRepeat=array_unique($listCheckVacio);

            //EL ARREGLO FINAL LO CONVERTIMOS A STRING
            // $resCorreo = implode( ",", $arrayCorreoNotRepeat);

            $this->load->library('Pdf');
            $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
            // $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sistemas María José Martínez Martínez');
            $pdf->SetTitle('DEPÓSITO DE SERIEDAD');
            $pdf->SetSubject('CONSTANCIA DE RELACION EMPRESA TRABAJADOR');
            $pdf->SetKeywords('CONSTANCIA, CIUDAD MADERAS, RELACION, EMPRESA, TRABAJADOR');
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, 0);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('Helvetica', '', 9, '', true);
            $pdf->SetMargins(15, 15, 15, true);

            $pdf->AddPage('P', 'LEGAL');

            $pdf->SetFont('Helvetica', '', 5, '', true);

            $pdf->SetFooterMargin(0);
            $bMargin = $pdf->getBreakMargin();
            $auto_page_break = $pdf->getAutoPageBreak();
            $pdf->Image('static/images/ar4c.png', 120, 15, 300, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
            $pdf->setPageMark();


            $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
            <link rel="shortcut icon" href="'.base_url().'static/images/arbol_cm.png" />
            <link href="<?=base_url()?>dist/css/bootstrap.min.css" rel="stylesheet" />
            <!--  Material Dashboard CSS    -->
            <link href="<?=base_url()?>dist/css/material-dashboard.css" rel="stylesheet" />
            <!--  CSS for Demo Purpose, don\'t include it in your project     -->
            <link href="<?=base_url()?>dist/css/demo.css" rel="stylesheet" />
            <!--     Fonts and icons     -->
            <link href="<?=base_url()?>dist/css/font-awesome.css" rel="stylesheet" />
            <link href="<?=base_url()?>dist/css/google-roboto-300-700.css" rel="stylesheet" />
            <style>
            body{color: #084c94;}
            .espacio{padding: 5%;}
            .espaciodos{padding: 10%;} 
            h2{font-weight: bold;color: #084c94;}
            .save {display:scroll;position:fixed;bottom:225px;right:17px;z-index: 3;}
            p{color: #084c94;}
            .col-xs-16 {width: 3px;float: left;}
            .col-xs-17 {width: 16%;float: left;}
            #imagenbg {position: relative;top:1500px;z-index: -1;}
            #fichadeposito {position: absolute;z-index: 2;}
            .mySectionPdf
            {
                padding: 20px;
            }
            .form-group.is-focused .form-control 
            {
                outline: none;
                background-image: linear-gradient(#0c63c5, #177beb), linear-gradient(#D2D2D2, #D2D2D2);
                background-size: 100% 2px, 100% 1px;
                box-shadow: none;
                transition-duration: 0.3s;
            }
            b
            {
                font-size: 8px;
            }
            </style>
            </head>

            <body>
            <div id="fichadeposito" name="fichadeposito" class="fichadeposito">
            <div id="muestra">
            <table border="0" width="100%" id="tabla" align="center">
            <tr>
            
            <td width="70%" align="left">
             <label>
            <h1 style="margin-right: 50px;"> DEPÓSITO DE SERIEDAD</h1>
            </label>
            </td>

            <td align="right" width="15%">
            <br><br><br>
            <p style="margin-right: 2px;">FOLIO</p>
            </td>

            <td width="15%" style="border-bottom:1px solid #CCCCCC">
            <p style="color: red;font-size:14px;">'.$clave_folio.'</p>
            </td>

            </tr>
            </table>

            <table border="0" width="100%" align="" align="">
            <tr>
            <th rowspan="4" width="283" align="left">
            <img src="'.base_url().'/static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width: 250px"/>
            </th>

            <td width="367">
            <h5><p style="font-size:9px;"><strong>DESARROLLO:</strong></p></h5>
            </td>
            </tr>

            <tr>
            <td width="367">
            <table border="0" width="100%">
            <tr>
            <td width="20%">'.$d1.'</td>
            <td width="20%">'.$d2.'</td>
            <td width="20%">'.$d3.'</td>
            <td width="20%">'.$d4.'</td>
            <td width="20%">'.$d5.'</td>
            </tr>

            <tr>
            <td width="20%">'.$tpl1.'</td>
            <td width="20%">'.$tpl2.'</td>
            <td width="20%"></td>
            <td width="20%"></td>
            <td width="20%"></td>
            </tr>

            </table>
            </td>
            </tr>

            <tr>
            <td>
            <h5><p style="font-size:9px;"><strong>DOCUMENTACIÓN ENTREGADA:</strong></p></h5>
            </td>
            </tr>

            <tr>
            <td>
            <table border="0" width="100%">
            <tr>
            <td width="19 %"><p><strong>Personas&nbsp;Físicas</strong></p></td>
            <td width="23%">'.$id_identificacion.'</td>
            <td width="27%">'.$id_domicilio.'</td>
            <td width="29%" colspan="2">'.$id_acta_m.'</td>
            </tr>

            <tr>
            <td width="19%"><p><strong>Personas&nbsp;Morales</strong></p></td>
            <td width="23%">'.$id_acta_c.'</td>
            <td width="27%">'.$id_poder.'</td>
            <td width="29%" colspan="2">'.$id_apoderado.'</td>
            </tr>

            <tr>
            <td width="19%"></td>
            <td width="23%"><b>RFC:</b> '.$rfc.'</td>
            <td width="27%"></td>
            <td width="29%" colspan="2"></td>
            </tr>
 

            </table>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2">
            <br>
            </td>
            </tr>
            
            <tr>
            <td width="40%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
            <label>NOMBRE(<b><span style="color: red;">*</span></b>):</label><br><br><b>&nbsp;'.$nombre.' <br></b>
            </td>
            <td width="30%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
            <label>APELLIDO PATERNO(<b><span style="color: red;">*</span></b>):</label><br><br><b>&nbsp;'.$apellido_paterno.' <br></b>
            </td>
            <td width="30%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
            <label>APELLIDO MATERNO(<b><span style="color: red;">*</span></b>):</label><br><br><b>&nbsp;'.$apellido_materno.' <br></b>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>

            <tr>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>TELÉFONO CASA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$telefono1.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>CELULAR (<b><span style="color: red;">*</span></b>) </label><br><br><b>&nbsp;'.$telefono2.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label> EMAIL (<b><span style="color: red;">*</span></b>)
                </label><br><br><b>&nbsp;'.$correo.'</b><br>
            </td>
            </tr>
            
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA DE NACIMIENTO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$fecha_nacimiento.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>NACIONALIDAD:
                </label><br><br><b>&nbsp;'.$nac_select.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>ORIGINARIO DE:
                </label><br><br><b>&nbsp;'.$originario.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>ESTADO CIVIL:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$ecivil_select.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>NOMBRE CONYUGE:
                </label><br><br><b>&nbsp;'.$nombre_conyuge.'</b><br>
            </td>
            <td width="33.3%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>RÉGIMEN:
                </label><br><br><b>&nbsp;'.$regimen_select.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>DOMICILIO PARTICULAR:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$domicilio_particular.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>OCUPACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$ocupacion.'</b><br>
            </td>
            <td width="35%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EMPRESA EN LA QUE TRABAJA:
                </label><br><br><b>&nbsp;'.$empresa.'</b><br>
            </td>
            <td width="35%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>PUESTO:
                </label><br><br><b>&nbsp;'.$puesto.'</b><br>
            </td>
            <td width="10%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>ANTIGÜEDAD:
                </label><br><br><b>&nbsp;'.$antiguedad.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EDAD:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$edadFirma.'</b><br>
            </td>
            <td width="70%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>DOMICILIO EMPRESA:
                </label><br><br><b>&nbsp;'.$domicilio_empresa.'</b><br>
            </td>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>TELÉFONO EMPRESA:
                </label><br><br><b>&nbsp;'.$telefono_empresa.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
 
            <tr>
            <td width="15%" colspan="2"><b>VIVE EN CASA:</b></td>
            <td width="10%">'.$tv1.'</td>
            <td width="10%">'.$tv2.'</td>
            <td width="10%">'.$tv3.'</td>
            <td width="10%">'.$tv4.'</td>
            <td width="10%">'.$tv5.'</td>
            </tr>


            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>datossksk:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$valor_coprop.'</b><br>
            </td>
           
            </tr>


 

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>El Sr.(a):
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$nombre.' '.$apellido_paterno.' '.$apellido_materno.'</b><br>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>SE COMPROMETE A ADQUIRIR:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$nombreLote.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EN EL CLÚSTER:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$nombreCondominio.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>DE SUP APROX:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$sup.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>NO. REFERENCIA PAGO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$referencia.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>COSTO POR M<sup>2</sup> LISTA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$costoM2.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>COSTO POR M<sup>2</sup> FINAL:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$costom2f.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>UNA VEZ QUE SEA AUTORIZADO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$proyecto.'</b><br>
            </td>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>EN EL MUNICIPIO DE:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$municipio2.'</b><br>
            </td>
            </tr>


          

            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>LA UBICACIÓN DE LOTE PUEDE VARIAR DEBIDO A AJUSTES DEL PROYECTO
                </label><br><br><br>
            </td>
            </tr>


           

            <tr>
            <td width="25%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>IMPORTE DE LA OFERTA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$importOferta.'</b><br>
            </td>
            <td width="75%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>IMPORTE EN LETRA:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$letraImport.'</b><br>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label><label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $: </label><b>'.$cantidad.'</b> <b> ( '.$letraCantidad.' ), </b> misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo.El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma:</label> 
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>SALDO DE DEPÓSITO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$saldoDeposito.'</b><br>
            </td>
            <td width="15%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>APORTACIÓN MENSUAL:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$aportMensualOfer.'</b><br>
            </td>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA 1° APORTACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$fecha1erAport.'</b><br>
            </td>
            <td width="10%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>PLAZO:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$plazo.'</b><br>
            </td>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA LIQUIDACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$fechaLiquidaDepo.'</b><br>
            </td>
            <td width="20%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>FECHA 2° APORTACIÓN:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$fecha2daAport.'</b><br>
            </td>
            </tr>



            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label align="justify">Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.</label> 
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>
            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>En el Municipio de <b>'.$municipio2.'</b> a <b>'.$dia.'</b> del mes <b>'.$mes.'</b> del año <b>'.$anio.'</b>.</label> 
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>



            <tr>
            <br><br><br><br><br> 
            <td width="70%" align="center">'.$nombre.' '.$apellido_paterno.' '.$apellido_materno.'
            <BR> ______________________________________________________________________________<p>Nombre y Firma / Ofertante</p><p>Acepto que se realice una verificación de mis datos, en los teléfonos<br> y correos que proporciono para el otorgamiento del crédito.</p>
            </td>

            <td width="30%" align="center"><label><b>REFERENCIAS PERSONALES</b>.</label><br>
            <p align="left">
            <label>'.$nombre1.' - '.$parentezco_select1.' - '.$telefono1.'</label><br>
            <label>'.$nombre2.' - '.$parentezco_select2.' - '.$telefono2.'</label>
            </p>
            </td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2"></td>
            </tr>


            <tr>
            <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC"><label>OBSERVACIONES:
                </label><br><br><b style="padding-left: 250px">&nbsp;'.$observacion.'</b><br>
            </td>
            </tr>

            <tr>
            <td width="100%" colspan="2"></td>
            </tr>



            <tr>
            <br><br><br><br><br> 
            <td width="50%" align="center">'.$asesor_datos.'<BR> ______________________________________________________________________________<p> 
            <b>Nombre y Firma / Asesor</b></p>
            </td>

            <td width="50%" align="center">'.$gerente_datos.'<BR> ______________________________________________________________________________<p> 
            <b>Nombre y Firma / Autorización de operación</b></p>
            </td>
            </tr>
 

            <tr>
            <td width="100%" align="center">
            <table border="0" width="91%" style="background-color:#ffffff;">
            <tr>
            <td></td>
            </tr>
            </table>
            </td>
            </tr>


            </table>
            </td>

 
            </div>
            </div>
            </body>
            </html>';

            $pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);




$namePDF = utf8_decode('DEPÓSITO_DE_SERIEDAD_'.$id_cliente.'.pdf');

$pdf->Output(utf8_decode($namePDF), 'I');

 $attachment= $pdf->Output(utf8_decode($namePDF), 'S');
 // PHPMailer object
 $mail = $this->phpmailer_lib->load();



 $mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');


 //$mail->AddAddress('programador.analista1@ciudadmaderas.com');

     foreach ($arrayCorreoNotRepeat AS $arrCorreo){
               if ($arrCorreo){
               $mail->AddAddress($arrCorreo);
             }
     }



 // Email subject

 $mail->Subject = utf8_decode('DEPÓSITO DE SERIEDAD-CIUDAD MADERAS');

 // Set email format to HTML
 $mail->isHTML(true);

 // Email body content
 $mailContent = utf8_decode("<h1>Ciudad Maderas</h1>
     <p>Se adjunta el archivo Depósito de seriedad correspondiente.</p>");
 $mail->Body = $mailContent;
 $mail->AddStringAttachment($attachment, $namePDF);



    if ($this->Asesor_model->editaRegistroClienteDS($id_cliente, $arreglo_cliente, $arreglo_ds, $id_referencia1, $arreglo_referencia1,$id_referencia2, $arreglo_referencia2)){

     $mail->send();

  }else

   {

   die("ERROR");

  }


}

  else if($this->input->post('pdfOK') == null || $this->input->post('pdfOK') != '1' ) {

    $this->Asesor_model->editaRegistroClienteDS($id_cliente, $arreglo_cliente, $arreglo_ds, $id_referencia1, $arreglo_referencia1,$id_referencia2, $arreglo_referencia2);


    for ($i=0; $i < sizeof($array1); $i++) {
        $this->db->query("UPDATE copropietarios SET correo = '".$array1[$i]."', telefono = '".$array2[$i]."', telefono_2 = '".$array3[$i]."', fecha_nacimiento = '".$array4[$i]."', nacionalidad = '".$array5[$i]."', originario_de = '".$array6[$i]."', domicilio_particular = '".$array7[$i]."', estado_civil = '".$array8[$i]."', conyuge = '".$array9[$i]."', regimen_matrimonial = '".$array10[$i]."', ocupacion = '".$array11[$i]."', posicion = '".$array12[$i]."', empresa = '".$array13[$i]."', antiguedad = '".$array14[$i]."', edadFirma = '".$array15[$i]."', direccion = '".$array16[$i]."' WHERE id_copropietario = ".$array17[$i]."");
        }
    }
}
/*autorizaciones*/
public function autorizaciones()
{
	$this->load->view('template/header');
	$this->load->view("asesor/autorizaciones");
}

function getAutorizacionAs()
{
	$data['data'] = $this->Asesor_model->get_autorizaciones();
	echo json_encode($data);
}
public function get_auts_by_lote($idLote)
{
	$data = $this->Asesor_model->get_auts_by_lote($idLote);
	//print_r($data);
	if($data != null) {

		echo json_encode($data);

	} else {

		echo json_encode(array());

	}
}

public function get_sol_aut()
{
	$data['data'] = $this->Asesor_model->get_sol_aut();
	echo json_encode($data);
}

	public function addAutorizacionSbmt()
	{
		$data = array();
		$tamanoArreglo = $_POST['tamanocer'];
		//print_r($tamanoArreglo);
		$idCliente = $_POST['idCliente'];
		$idLote    = $_POST['idLote'];
		$id_sol    = $_POST['id_sol'];
		$id_aut    = $_POST['id_aut'];

		/*nuevo*/
		$nombreResidencial=$_POST['nombreResidencial'];
		$nombreCondominio=$_POST['nombreCondominio'];
		$nombreLote=$_POST['nombreLote'];
		$idCondominio=$_POST['idCondominio'];
		$autorizacionComent = "";
		/*termina nuevo*/

		for($n=0; $n<$tamanoArreglo;$n++)
		{
			$data = array(
				'idCliente' => $idCliente,
				'idLote' => $idLote,
				'id_sol' => $id_sol,
				'id_aut' => $id_aut,
				'estatus' => 1,
				'autorizacion' => $_POST['comentario_'.$n]
			);
			//echo "comentario ".$n.": ".$_POST['comentario_'.$n]."<br>";
			$dataInsert = $this->Asesor_model->insertAutorizacion($data);
			$autorizacionComent .= $_POST['comentario_'.$n].". ";
		}
		if($dataInsert==1)
		{
			// $this->session->set_userdata('success', 1);
			$this->notifyUsers($id_aut, $nombreResidencial, $nombreCondominio, $nombreLote, $idCondominio, $autorizacionComent);
			// redirect(base_url()."index.php/registroLote/autorizaciones");
			echo json_encode($dataInsert);
		}
		else
		{
			// $this->session->set_userdata('error', 99);
			// redirect(base_url()."index.php/registroLote/autorizaciones");
			echo json_encode($dataInsert);
		}
	}

	/*envia un correo cuando se solicita una nueva autorizacion*/
	public function notifyUsers($idAut, $nombreResidencial, $nombreCondominio, $nombreLote, $idCondominio, $motivoAut)
	{
		/*$idCliente=$this->input->post('idCliente');
		$idLote=$this->input->post('idLote');
		$nombreResidencial=$this->input->post('nombreResidencial');
		$nombreCondominio=$this->input->post('nombreCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCondominio=$this->input->post('idCondominio');
		$motivoAut=$this->input->post('motivoAut');*/


		$dataUser = $this->Asesor_model->getInfoUserById($idAut);
		/*switch ($idAut) {
			case 2400:
				$correoDir= 'programador.analista8@ciudadmaderas.com';//rigel.silva@ciudadmaderas.com
				break;
			case 2401:
				$correoDir= 'programador.analista8@ciudadmaderas.com';//jesus.torre@ciudadmaderas.com
				break;
			case 2402:
				$correoDir= 'programador.analista8@ciudadmaderas.com';//emilio.fernandez@ciudadmaderas.com
				break;
			case 2403:
				$correoDir= 'programador.analista8@ciudadmaderas.com';//f.martinez@ciudadmaderas.com
				break;
			case 2404:
				$correoDir= 'programador.analista8@ciudadmaderas.com';//adriana.manas@ciudadmaderas.com
				break;
		}*/

		/*$correoDir= 'programador.analista8@ciudadmaderas.com';se coloca el correo de testeo para desarrollo*/
		$correoDir = $dataUser[0]->correo;/*linea de codigo para produccion*/


		$mail = $this->phpmailer_lib->load();

		$mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');
		$mail->addAddress($correoDir);/*$correoDir*/

		$mail->Subject = utf8_decode('SOLICITUD DE AUTORIZACIÓN-CONTRATACIÓN');
		$mail->isHTML(true);

		$mailContent = utf8_decode( "<html><head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
      <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'> 
      <style media='all' type='text/css'>
          .encabezados{
              text-align: center;
              padding-top:  1.5%;
              padding-bottom: 1.5%;
          }
          .encabezados a{
              color: #234e7f;
              font-weight: bold;
          }
          
          .fondo{
              background-color: #234e7f;
              color: #fff;
          }
          
          h4{
              text-align: center;
          }
          p{
              text-align: right;
          }
          strong{
              color: #234e7f;
          }
      </style>
    </head>
    <body>
      <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'>
          <tr colspan='3'><td class='navbar navbar-inverse' align='center'>
              <table width='750px' cellspacing='0' cellpadding='3' class='container'>
                  <tr class='navbar navbar-inverse encabezados'><td>
                      <img src='https://www.ciudadmaderas.com/assets/img/logo.png' width='100%' class='img-fluid'/><p><a href='#'>SISTEMA DE CONTRATACIÓN</a></p>
                  </td></tr>
              </table>
          </td></tr>
          <tr><td border=1 bgcolor='#FFFFFF' align='center'>  
          <center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
            <tr class='active'>
              <th>Proyecto</th>
              <th>Condominio</th> 
              <th>Lote</th>   
              <th>Autorización</th>   
              <th>Fecha/Hora</th>   
            </tr> 
            <tr>   
                   <td><center>".$nombreResidencial."</center></td>
                   <td><center>".$nombreCondominio."</center></td>
                   <td><center>".$nombreLote."</center></td>
                   <td><center>".$motivoAut."</center></td>
                   <td><center>".date("Y-m-d H:i:s")."</center></td>
            </tr>
            </table></center>
          
          
          </td></tr>
      </table></body></html>");

		$mail->Body = $mailContent;

        if($correoDir != 'gustavo.mancilla@ciudadmaderas.com'){
            $mail->send();
        }
	}




public function intExpAsesor() {

    $idLote=$this->input->post('idLote');
    $nombreLote=$this->input->post('nombreLote');

    $arreglo=array();
    $arreglo["idStatusContratacion"]=2;
    $arreglo["idMovimiento"]=84;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");
    $arreglo["comentario"]= $this->input->post('comentario');


    date_default_timezone_set('America/Mexico_City');
    $horaActual = date('H:i:s');
    $horaInicio = date("08:00:00");
    $horaFin = date("16:00:00");


    if ($horaActual > $horaInicio and $horaActual < $horaFin) {

    $fechaAccion = date("Y-m-d H:i:s");
    $hoy_strtotime2 = strtotime($fechaAccion);
    $sig_fecha_dia2 = date('D', $hoy_strtotime2);
    $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);



    if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
         $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
         $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
         $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
         $sig_fecha_feriado2 == "25-12") {

    $fecha = $fechaAccion;
    $i = 0;

        while($i <= 0) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
      $sig_fecha_feriado = date('d-m', $sig_strtotime);


      if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;

               }
           $arreglo["fechaVenc"]= $fecha;

           }else{

    $fecha = $fechaAccion;
    $i = 0;
        while($i <= -1) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
      $sig_fecha_feriado = date('d-m', $sig_strtotime);

      if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;
               }

           $arreglo["fechaVenc"]= $fecha;

           }

    } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

      $fechaAccion = date("Y-m-d H:i:s");
      $hoy_strtotime2 = strtotime($fechaAccion);
    $sig_fecha_dia2 = date('D', $hoy_strtotime2);
    $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

    if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
         $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
         $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
         $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
         $sig_fecha_feriado2 == "25-12") {

    $fecha = $fechaAccion;
    $i = 0;

        while($i <= 0) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
      $sig_fecha_feriado = date('d-m', $sig_strtotime);

      if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;
               }

           $arreglo["fechaVenc"]= $fecha;

           }else{
    $fecha = $fechaAccion;
    $i = 0;

        while($i <= -1) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
        $sig_fecha_feriado = date('d-m', $sig_strtotime);

      if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;
               }

         $arreglo["fechaVenc"]= $fecha;

           }
    }


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=2;
    $arreglo2["idMovimiento"]=84;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $this->input->post('fechaVenc');
    $arreglo2["idLote"]= $idLote;
    $arreglo2["idCondominio"]= $this->input->post('idCondominio');
    $arreglo2["idCliente"]= $this->input->post('idCliente');
    $arreglo2["comentario"]= $this->input->post('comentario');


    $validate = $this->Asesor_model->validateSt2($idLote);

    if($validate == 1){

       if ($this->Asesor_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
           $data['message'] = 'OK';
           echo json_encode($data);

        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }

    }else {
        $data['message'] = 'FALSE';
        echo json_encode($data);
    }


  }





  public function editar_registro_loteRevision_asistentesAContraloria_proceceso2(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]= 2;
    $arreglo["idMovimiento"]= 4;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


  date_default_timezone_set('America/Mexico_City');
  $horaActual = date('H:i:s');
  $horaInicio = date("08:00:00");
  $horaFin = date("16:00:00");

  if ($horaActual > $horaInicio and $horaActual < $horaFin) {

  $fechaAccion = date("Y-m-d H:i:s");
  $hoy_strtotime2 = strtotime($fechaAccion);
  $sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);


  if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {


  $fecha = $fechaAccion;

  $i = 0;
    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;

           }
       $arreglo["fechaVenc"]= $fecha;
       }else{

  $fecha = $fechaAccion;
  $i = 0;
    while($i <= -1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;

    }

  } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {


  $fechaAccion = date("Y-m-d H:i:s");
  $hoy_strtotime2 = strtotime($fechaAccion);
  $sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

  if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

  $fecha = $fechaAccion;
  $i = 0;

    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);


  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{

  $fecha = $fechaAccion;

  $i = 0;
    while($i <= 0) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);


  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
     $arreglo["fechaVenc"]= $fecha;
     }
  }


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]= 2;
    $arreglo2["idMovimiento"]= 4;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;
    $arreglo2["idCondominio"]= $idCondominio;
    $arreglo2["idCliente"]= $idCliente;


    $validate = $this->Asesor_model->validateSt2($idLote);

    if($validate == 1){

       if ($this->Asesor_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
           $data['message'] = 'OK';
           echo json_encode($data);

        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }

    }else {
        $data['message'] = 'FALSE';
        echo json_encode($data);
    }

  }








  public function editar_registro_loteRevision_asistentesAContraloria6_proceceso2(){

    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date("Y-m-d H:i:s");
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]= 2;
    $arreglo["idMovimiento"]=62;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


date_default_timezone_set('America/Mexico_City');
$horaActual = date('H:i:s');
$horaInicio = date("08:00:00");
$horaFin = date("16:00:00");

if ($horaActual > $horaInicio and $horaActual < $horaFin) {
$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {


$fecha = $fechaAccion;
$i = 0;
    while($i <= 2) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);


  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{
$fecha = $fechaAccion;
$i = 0;
    while($i <= 1) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }

} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
$fechaAccion = date("Y-m-d H:i:s");
$hoy_strtotime2 = strtotime($fechaAccion);
$sig_fecha_dia2 = date('D', $hoy_strtotime2);
  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
     $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
     $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
     $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
     $sig_fecha_feriado2 == "25-12") {

$fecha = $fechaAccion;
$i = 0;
    while($i <= 2) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
       $arreglo["fechaVenc"]= $fecha;
       }else{
$fecha = $fechaAccion;
$i = 0;
    while($i <= 2) {
  $hoy_strtotime = strtotime($fecha);
  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
  $sig_fecha_dia = date('D', $sig_strtotime);
    $sig_fecha_feriado = date('d-m', $sig_strtotime);

  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
     $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
     $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
     $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
     $sig_fecha_feriado == "25-12") {
       }
         else {
                $fecha= $sig_fecha;
                 $i++;
              }
    $fecha = $sig_fecha;
           }
     $arreglo["fechaVenc"]= $fecha;
       }
}


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]= 2;
    $arreglo2["idMovimiento"]=62;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;
    $arreglo2["idCondominio"]= $idCondominio;
    $arreglo2["idCliente"]= $idCliente;

    $validate = $this->Asesor_model->validateSt2($idLote);

    if($validate == 1){

    if ($this->Asesor_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
        $data['message'] = 'OK';
        echo json_encode($data);

        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }

    }else {
        $data['message'] = 'FALSE';
        echo json_encode($data);
    }

}





public function envioRevisionAsesor2aJuridico7() {

    $idCliente=$this->input->post('idCliente');
    $nombreLote=$this->input->post('nombreLote');
    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $comentario=$this->input->post('comentario');
    $fechaVenc=$this->input->post('fechaVenc');


    $arreglo=array();
    $arreglo["idStatusContratacion"]=7;
    $arreglo["idMovimiento"]=83;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $horaActual = date('H:i:s');
    $horaInicio = date("08:00:00");
    $horaFin = date("16:00:00");


    if ($horaActual > $horaInicio and $horaActual < $horaFin) {

    $fechaAccion = date("Y-m-d H:i:s");
    $hoy_strtotime2 = strtotime($fechaAccion);
    $sig_fecha_dia2 = date('D', $hoy_strtotime2);
    $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);



    if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
         $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
         $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
         $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
         $sig_fecha_feriado2 == "25-12") {

    $fecha = $fechaAccion;
    $i = 0;

        while($i <= 2) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
      $sig_fecha_feriado = date('d-m', $sig_strtotime);


      if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;

               }
           $arreglo["fechaVenc"]= $fecha;

           }else{

    $fecha = $fechaAccion;
    $i = 0;
        while($i <= 1) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
      $sig_fecha_feriado = date('d-m', $sig_strtotime);

      if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;
               }

           $arreglo["fechaVenc"]= $fecha;

           }

    } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

      $fechaAccion = date("Y-m-d H:i:s");
      $hoy_strtotime2 = strtotime($fechaAccion);
    $sig_fecha_dia2 = date('D', $hoy_strtotime2);
    $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

    if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
         $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
         $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
         $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
         $sig_fecha_feriado2 == "25-12") {

    $fecha = $fechaAccion;
    $i = 0;

        while($i <= 2) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
      $sig_fecha_feriado = date('d-m', $sig_strtotime);

      if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;
               }

           $arreglo["fechaVenc"]= $fecha;

           }else{
    $fecha = $fechaAccion;
    $i = 0;

        while($i <= 2) {
      $hoy_strtotime = strtotime($fecha);
      $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
      $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
      $sig_fecha_dia = date('D', $sig_strtotime);
        $sig_fecha_feriado = date('d-m', $sig_strtotime);

      if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  }
        $fecha = $sig_fecha;
               }

         $arreglo["fechaVenc"]= $fecha;

           }
    }


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]=7;
    $arreglo2["idMovimiento"]=83;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;
    $arreglo2["idCondominio"]= $idCondominio;
    $arreglo2["idCliente"]= $idCliente;


    $validate = $this->Asesor_model->validateSt2($idLote);

    if($validate == 1){

    if ($this->Asesor_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
        $data['message'] = 'OK';
        echo json_encode($data);

        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }

    }else {
        $data['message'] = 'FALSE';
        echo json_encode($data);
    }



  }


  public function editar_registro_loteRevision_eliteAcontraloria5_proceceso2(){


    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');

    $arreglo=array();
    $arreglo["idStatusContratacion"]= 2;
    $arreglo["idMovimiento"]=74;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]= 2;
    $arreglo2["idMovimiento"]=74;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;
    $arreglo2["idCondominio"]= $idCondominio;
	$arreglo2["idCliente"]= $idCliente;


    $validate = $this->Asesor_model->validateSt2($idLote);

    if($validate == 1){

    if ($this->Asesor_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
        $data['message'] = 'OK';
        echo json_encode($data);

        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }

    }else {
        $data['message'] = 'FALSE';
        echo json_encode($data);
    }

  }



  public function editar_registro_loteRevision_eliteAcontraloria5_proceceso2_2(){


    $idLote=$this->input->post('idLote');
    $idCondominio=$this->input->post('idCondominio');
    $nombreLote=$this->input->post('nombreLote');
    $idCliente=$this->input->post('idCliente');
    $comentario=$this->input->post('comentario');
    $modificado=date('Y-m-d H:i:s');
    $fechaVenc=$this->input->post('fechaVenc');

    $arreglo=array();
    $arreglo["idStatusContratacion"]= 2;
    $arreglo["idMovimiento"]=93;
    $arreglo["comentario"]=$comentario;
    $arreglo["usuario"]=$this->session->userdata('id_usuario');
    $arreglo["perfil"]=$this->session->userdata('id_rol');
    $arreglo["modificado"]=date("Y-m-d H:i:s");


    $arreglo2=array();
    $arreglo2["idStatusContratacion"]= 2;
    $arreglo2["idMovimiento"]=93;
    $arreglo2["nombreLote"]=$nombreLote;
    $arreglo2["comentario"]=$comentario;
    $arreglo2["usuario"]=$this->session->userdata('id_usuario');
    $arreglo2["perfil"]=$this->session->userdata('id_rol');
    $arreglo2["modificado"]=date("Y-m-d H:i:s");
    $arreglo2["fechaVenc"]= $fechaVenc;
    $arreglo2["idLote"]= $idLote;
    $arreglo2["idCondominio"]= $idCondominio;
    $arreglo2["idCliente"]= $idCliente;



    $validate = $this->Asesor_model->validateSt2($idLote);

    if($validate == 1){

    if ($this->Asesor_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
        $data['message'] = 'OK';
        echo json_encode($data);

        }else{
            $data['message'] = 'ERROR';
            echo json_encode($data);
        }

    }else {
        $data['message'] = 'FALSE';
        echo json_encode($data);
    }


  }

	function getregistrosClientes() {
		$objDatos = json_decode(file_get_contents("php://input"));
		$dato= $this->registrolote_modelo->registroCliente();
		//$data2= $this->registrolote_modelo->getReferenciasCliente();

		for($i=0; $i<count($dato); $i++)
		{
			$data[$i]['id_cliente'] = $dato[$i]->id_cliente;
			$data[$i]['id_asesor'] = $dato[$i]->id_asesor;
			$data[$i]['id_coordinador'] = $dato[$i]->id_coordinador;
			$data[$i]['id_gerente'] = $dato[$i]->id_gerente;
			$data[$i]['id_sede'] = $dato[$i]->id_sede;
			$data[$i]['nombre'] = $dato[$i]->nombre;
			$data[$i]['apellido_paterno'] = $dato[$i]->apellido_paterno;
			$data[$i]['apellido_materno'] = $dato[$i]->apellido_materno;
			$data[$i]['personalidad_juridica'] = ($dato[$i]->personalidad_juridica =="") ? "N/A" : $dato[$i]->personalidad_juridica;
			$data[$i]['nacionalidad'] = ($dato[$i]->nacionalidad =="") ? "N/A" : $dato[$i]->nacionalidad;
			$data[$i]['rfc'] = ($dato[$i]->rfc =="") ? "N/A" : $dato[$i]->rfc;
			$data[$i]['curp'] = ($dato[$i]->curp =="") ? "N/A" : $dato[$i]->curp;
			$data[$i]['correo'] = ($dato[$i]->correo =="") ? "N/A" : $dato[$i]->correo;
			$data[$i]['telefono1'] = ($dato[$i]->telefono1 =="") ? "N/A" : $dato[$i]->telefono1;
			$data[$i]['telefono2'] = ($dato[$i]->telefono2 =="") ? "N/A" : $dato[$i]->telefono2;
			$data[$i]['telefono3'] = ($dato[$i]->telefono3 =="") ? "N/A" : $dato[$i]->telefono3;
			$data[$i]['fecha_nacimiento'] = ($dato[$i]->fecha_nacimiento =="") ? "N/A" : $dato[$i]->fecha_nacimiento;
			$data[$i]['lugar_prospeccion'] = ($dato[$i]->lugar_prospeccion =="") ? "N/A" : $dato[$i]->lugar_prospeccion;
			$data[$i]['medio_publicitario'] = ($dato[$i]->medio_publicitario =="") ? "N/A" : $dato[$i]->medio_publicitario;
			$data[$i]['otro_lugar'] = ($dato[$i]->otro_lugar =="") ? "N/A" : $dato[$i]->otro_lugar;
			$data[$i]['plaza_venta'] = ($dato[$i]->plaza_venta =="") ? "N/A" : $dato[$i]->plaza_venta;
			$data[$i]['tipo'] = ($dato[$i]->tipo =="") ? "N/A" : $dato[$i]->tipo;
			$data[$i]['estado_civil'] = ($dato[$i]->estado_civil =="") ? "N/A" : $dato[$i]->estado_civil;
			$data[$i]['regimen_matrimonial'] = ($dato[$i]->regimen_matrimonial =="") ? "N/A" : $dato[$i]->regimen_matrimonial;
			$data[$i]['nombre_conyuge'] = ($dato[$i]->nombre_conyuge =="") ? "N/A" : $dato[$i]->nombre_conyuge;
//			$data[$i]['calle'] = ($dato[$i]->calle =="") ? "N/A" : $dato[$i]->calle;
//			$data[$i]['numero'] = ($dato[$i]->numero =="") ? "N/A" : $dato[$i]->numero;
//			$data[$i]['colonia'] = ($dato[$i]->colonia =="") ? "N/A" : $dato[$i]->colonia;
//			$data[$i]['municipio'] = ($dato[$i]->municipio =="") ? "N/A" : $dato[$i]->municipio;
//			$data[$i]['estado'] = ($dato[$i]->estado =="") ? "N/A" : $dato[$i]->estado;
			$data[$i]['domicilio_particular'] = ($dato[$i]->domicilio_particular =="") ? "N/A" : $dato[$i]->domicilio_particular;
			$data[$i]['tipo_vivienda'] = ($dato[$i]->tipo_vivienda =="") ? "N/A" : $dato[$i]->tipo_vivienda;
			$data[$i]['ocupacion'] = ($dato[$i]->ocupacion =="") ? "N/A" : $dato[$i]->ocupacion;
			$data[$i]['empresa'] = ($dato[$i]->empresa =="") ? "N/A" : $dato[$i]->empresa;
			$data[$i]['puesto'] = ($dato[$i]->puesto =="") ? "N/A" : $dato[$i]->puesto;
			$data[$i]['edadFirma'] = ($dato[$i]->edadFirma =="") ? "N/A" : $dato[$i]->edadFirma;
			$data[$i]['antiguedad'] = ($dato[$i]->antiguedad =="") ? "N/A" : $dato[$i]->antiguedad;
			$data[$i]['domicilio_empresa'] = ($dato[$i]->domicilio_empresa =="") ? "N/A" : $dato[$i]->domicilio_empresa;
			$data[$i]['telefono_empresa'] = ($dato[$i]->telefono_empresa =="") ? "N/A" : $dato[$i]->telefono_empresa;
			$data[$i]['noRecibo'] = ($dato[$i]->noRecibo =="") ? "N/A" : $dato[$i]->noRecibo;
			$data[$i]['engancheCliente'] = ($dato[$i]->engancheCliente =="") ? "N/A" : $dato[$i]->engancheCliente;
			$data[$i]['concepto'] = ($dato[$i]->concepto =="") ? "N/A" : $dato[$i]->concepto;
			$data[$i]['fechaEnganche'] = ($dato[$i]->fechaEnganche =="") ? "N/A" : $dato[$i]->fechaEnganche;
			$data[$i]['idTipoPago'] = ($dato[$i]->idTipoPago =="") ? "N/A" : $dato[$i]->idTipoPago;
			$data[$i]['expediente'] = ($dato[$i]->expediente =="") ? "N/A" : $dato[$i]->expediente;
			$data[$i]['status'] = ($dato[$i]->status =="") ? "N/A" : $dato[$i]->status;
			$data[$i]['idLote'] = ($dato[$i]->idLote =="") ? "N/A" : $dato[$i]->idLote;
			$data[$i]['fechaApartado'] = ($dato[$i]->fechaApartado =="") ? "N/A" : $dato[$i]->fechaApartado;
			$data[$i]['fechaVencimiento'] = ($dato[$i]->fechaVencimiento =="") ? "N/A" : $dato[$i]->fechaVencimiento;
			$data[$i]['usuario'] = ($dato[$i]->usuario =="") ? "N/A" : $dato[$i]->usuario;
			$data[$i]['idCondominio'] = ($dato[$i]->idCondominio =="") ? "N/A" : $dato[$i]->idCondominio;
			$data[$i]['fecha_creacion'] = ($dato[$i]->fecha_creacion =="") ? "N/A" : $dato[$i]->fecha_creacion;
			$data[$i]['creado_por'] = ($dato[$i]->creado_por =="") ? "N/A" : $dato[$i]->creado_por;
			$data[$i]['fecha_modificacion'] = ($dato[$i]->fecha_modificacion =="") ? "N/A" : $dato[$i]->fecha_modificacion;
			$data[$i]['modificado_por'] = ($dato[$i]->modificado_por=="") ? "N/A" : $dato[$i]->modificado_por;
			$data[$i]['nombreCondominio'] = ($dato[$i]->nombreCondominio=="") ? "N/A" : $dato[$i]->nombreCondominio;
			$data[$i]['nombreResidencial'] = ($dato[$i]->nombreResidencial=="") ? "N/A" : $dato[$i]->nombreResidencial;
			$data[$i]['nombreLote'] = ($dato[$i]->nombreLote=="") ? "N/A" : $dato[$i]->nombreLote;
			$data[$i]['asesor'] = ($dato[$i]->asesor=="") ? "N/A" : $dato[$i]->asesor;
			$data[$i]['gerente'] = ($dato[$i]->gerente=="") ? "N/A" : $dato[$i]->gerente;
			$data[$i]['coordinador'] = ($dato[$i]->coordinador=="") ? "N/A" : $dato[$i]->coordinador;

			$dataRef = $this->registrolote_modelo->getReferenciasCliente($dato[$i]->id_cliente);
			$dataPrCon = $this->registrolote_modelo->getPrimerContactoCliente($dato[$i]->lugar_prospeccion);
			$dataVenComp = $this->registrolote_modelo->getVentasCompartidas($dato[$i]->id_cliente);
			$data[$i]['primerContacto'] = $dataPrCon[0]->nombre;

			for($n=0; $n < count($dataRef); $n++)
			{
				$data[$i]['idreferencia'.($n+1)] = $dataRef[$n]->id_referencia;
				$data[$i]['referencia'.($n+1)] = $dataRef[$n]->nombre;
				$data[$i]['telreferencia'.($n+1)] = $dataRef[$n]->telefono;
			}
			if(count($dataVenComp)<=0)
			{
				$data[$i]['asesor2'] = "N/A";
				$data[$i]['asesor3'] = "N/A";
			}
			else
			{
				for($a=0; $a<count($dataVenComp); $a++)
				{
					if(count($dataVenComp)>0)
					{
						$data[$i]['asesor'.($a+1+1)] = $dataVenComp[$a]->nombre;
					}
					else{
						$data[$i]['asesor'.($a+1+1)] = "";
					}

				}
			}
		}
		if($data != null) {

			echo json_encode($data);

		}
		else
		{

			echo json_encode(array());
		}
	}



}
