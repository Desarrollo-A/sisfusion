<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reporte extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reporte_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email', 'Jwt_actions', 'Formatter','permisos_sidebar'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        // $this->programacion = $this->load->database('programacion', TRUE);

        date_default_timezone_set('America/Mexico_City');
        $this->jwt_actions->authorize('9717', $_SERVER['HTTP_HOST']);
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function reporte(){
        $this->load->view("dashboard/reporte/reporte");
    }

    public function getInformation(){
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $id_usuario = $this->input->post("id_usuario");
            $where = $this->input->post("where");
            $rol = $this->input->post("type");
            $render = $this->input->post("render");
            $asesor = $this->input->post("asesor");
            $coordinador = $this->input->post("coordinador");
            $gerente = $this->input->post("gerente");
            $subdirector = $this->input->post("subdirector");
            $regional = $this->input->post("regional");
            /* Filtros grales*/
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["begin"])));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["end"] )));
            $typeSale = $this->input->post("filters")[0]["typeSale"];
            $typeLote = $this->input->post("filters")[0]["typeLote"];
            $typeConstruccion = $this->input->post("filters")[0]["typeConstruccion"];
            $estatus = $this->input->post("filters")[0]["estatus"]; 
            /* Filtros grales*/
            $aptArr = trim($this->input->post('aptid'));
            $aptArr = empty($aptArr) ? ['0'] : explode(',', $aptArr);
            $contArr = trim($this->input->post('contid'));
            $contArr = empty($contArr) ? ['0'] : explode(',', $contArr);
            $canaparArr = trim($this->input->post('canaptid'));
            $canaparArr = empty($canaparArr) ? ['0'] : explode(',', $canaparArr);
            $canconArr = trim($this->input->post('cancontid'));
            $canconArr = empty($canconArr) ? ['0'] : explode(',', $canconArr);
            $generalArr = array_merge($aptArr, $contArr, $canaparArr, $canconArr);
            
            $data['data'] = $this->Reporte_model->getGeneralInformation($beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatus, $rol, $id_usuario, $render, [$asesor, $coordinador, $gerente, $subdirector, $regional], $typeTransaction, $generalArr, $aptArr, $contArr, $canaparArr, $canconArr)->result_array();
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            json_encode(array());
        }
    }
    public function getDataChart() {
        $general = $this->input->post('general');
        $tipoChart = $this->input->post('tipoChart');
        $id_rol = $this->input->post('type');
        $render = $this->input->post('render');
        $asesor = $this->input->post("asesor");
        $coordinador = $this->input->post("coordinador");
        $gerente = $this->input->post("gerente");
        $subdirector = $this->input->post("subdirector");
        $regional = $this->input->post("regional");
        
        /* Filtros grales*/
        $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["begin"])));
        $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["end"] )));
        $typeSale = $this->input->post("filters")[0]["typeSale"];
        $typeLote = $this->input->post("filters")[0]["typeLote"];
        $typeConstruccion = $this->input->post("filters")[0]["typeConstruccion"];    
        $estatus = $this->input->post("filters")[0]["estatus"]; 
        $data = $this->Reporte_model->getDataChart($general, $tipoChart, $id_rol, $beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatus, $render, [$asesor, $coordinador, $gerente, $subdirector, $regional]);

        //Obtenemos solo array de ventas contratadas
        $vcArray = array_filter($data, function($element){
            return $element['tipo'] == 'vc';
        });
        $sum = 0;
        foreach($vcArray as $key => $elemento) {
            $total = floatval(preg_replace('/[^\d\.]/', '', $elemento['total']));
            $sum += $total;
        }
        //echo json_encode($sum);

        //Obtenemos solo array de ventas apartadas
        $vaArray = array_filter($data, function($element){
            return $element['tipo'] == 'va';
        });

        //Reindexamos el filtro obtenido anteriormente
        $vcArray = array_values($vcArray);
        $vaArray = array_values($vaArray);
        $sumApt = 0;
        $sumCompleta = 0;

        //Recorremos uno de los arrays obtenido anteriormente y sumamos en cada uno de los puntos para obtener cantidad y total
        if( $general == "1" || $tipoChart == "vt"){
            if($tipoChart == "vt"){
                $data = array();
            }
            foreach( $vcArray as $key => $elemento ){
                $tot1 = floatval(preg_replace('/[^\d\.]/', '', $elemento['total']));
                $tot2 = floatval(preg_replace('/[^\d\.]/', '', $vaArray[$key]['total']));
                $sumApt = $tot1 + $tot2;
                //Hacemos push a nuevo array de ventas generales ya con la sumatoria de va y vc por mes.
                $data[] = array(
                    'total' => "$" . number_format(($tot1 + $tot2), 2),
                    'cantidad' => $elemento['cantidad'] + $vaArray[$key]['cantidad'],
                    'mes' => $elemento['mes'],
                    'año' => $elemento['año'],
                    'tipo' => 'vt',
                    'rol' => $elemento['rol']
                ); 
                
            }
            
        }
        

        if($data != null)
            echo json_encode($data);
            
        else
            echo json_encode(array());
    }

    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    public function validateRegional($id){
        $data = $this->Reporte_model->validateRegional($id);
        if($data != null) $where = " AND cl.id_regional = " . $id;
        else $where = " AND cl.id_subdirector = " . $id;

        return $where;
    }

    public function getRolDR(){
        $idUser = $this->input->post('idUser');
        $data = $this->Reporte_model->validateRegional($idUser);
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        }
        else echo json_encode(array());
    }

    public function getDetails () {
        $typeTransaction = $this->input->post("transaction");
        /*Filtros  grales*/
        $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["begin"])));
        $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["end"] )));
        $typeSale = $this->input->post("filters")[0]["typeSale"];
        $typeLote = $this->input->post("filters")[0]["typeLote"];
        $typeConstruccion = $this->input->post("filters")[0]["typeConstruccion"];
        $estatus = $this->input->post("filters")[0]["estatus"];
        /*Filtros grales */
        $id_usuario = $this->input->post("id_usuario");
        $rol = $this->input->post("rol");
        $render = $this->input->post("render");
        $leader = $this->input->post("leader");
        $asesor = $this->input->post("asesor");
        $coordinador = $this->input->post("coordinador");
        $gerente = $this->input->post("gerente");
        $subdirector = $this->input->post("subdirector");   
        $regional = $this->input->post("regional");

        $generalArr = empty($generalArr) ? ['0'] : explode(',', $generalArr);
        $aptArr = trim($this->input->post('aptid'));
        $aptArr = empty($aptArr) ? ['0'] : explode(',', $aptArr);
        $contArr = trim($this->input->post('contid'));
        $contArr = empty($contArr) ? ['0'] : explode(',', $contArr);
        $canaparArr = trim($this->input->post('canaptid'));
        $canaparArr = empty($canaparArr) ? ['0'] : explode(',', $canaparArr);
        $canconArr = trim($this->input->post('cancontid'));
        $canconArr = empty($canconArr) ? ['0'] : explode(',', $canconArr);
        $generalArr = array_merge($aptArr, $contArr, $canaparArr, $canconArr);
        
        $data = $this->Reporte_model->getDetails($beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatus, $rol, $id_usuario, $render, $leader, [$asesor, $coordinador, $gerente, $subdirector, $regional], $generalArr, $aptArr, $contArr, $canaparArr, $canconArr,$leader)->result_array();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }

    }
    public function getLotesInformation(){
        if (isset($_POST) && !empty($_POST)) {
            $type = $this->input->post("type");
            /*Filtros grales */
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["begin"])));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("filters")[0]["end"] )));
            $typeSale = $this->input->post("filters")[0]["typeSale"];
            $typeLote = $this->input->post("filters")[0]["typeLote"];
            $typeConstruccion = $this->input->post("filters")[0]["typeConstruccion"];
            $estatus = $this->input->post("filters")[0]["estatus"]; 
            /*Filtros grales */
            $id_usuario = $this->input->post("user");
            $rol = $this->input->post("rol");
            $render = $this->input->post("render");
            $sede = $this->input->post("sede");
            $leader = $this->input->post("leader");
            $asesor = $this->input->post("asesor");
            $coordinador = $this->input->post("coordinador");
            $gerente = $this->input->post("gerente");
            $subdirector = $this->input->post("subdirector");
            $regional = $this->input->post("regional");

            $aptArr = trim($this->input->post('aptid'));
            $aptArr = empty($aptArr) ? ['0'] : explode(',', $aptArr);
            $contArr = trim($this->input->post('contid'));
            $contArr = empty($contArr) ? ['0'] : explode(',', $contArr);
            $canaparArr = trim($this->input->post('canaptid'));
            $canaparArr = empty($canaparArr) ? ['0'] : explode(',', $canaparArr);
            $canconArr = trim($this->input->post('cancontid'));
            $canconArr = empty($canconArr) ? ['0'] : explode(',', $canconArr);
            $idArr = array_merge($aptArr, $contArr, $canaparArr, $canconArr);
            
            ini_set('max_execution_time', 900);
            set_time_limit(900);
            ini_set('memory_limit','2048M');
            $data['data'] = $this->Reporte_model->getGeneralLotesInformation($beginDate, $endDate, $typeSale, $typeLote, $typeConstruccion, $estatus, $rol, $id_usuario, $render, $type, $sede, $idArr,$leader, [$asesor, $coordinador, $gerente, $subdirector, $regional])->result_array();
            for ( $x = 0; $x < count($data['data']); $x++ ){
                $fechaUltimoStatus = $data['data'][$x]['fechaUltimoStatus'];
                $fechaApartado = $data['data'][$x]['fechaApartado'];
                $fechaStatus9 = $data['data'][$x]['fechaStatus9'];

                $diasUltimoStatus = $this->formatter->validarDiasHabiles($fechaApartado, $fechaUltimoStatus);    

                if ( $fechaStatus9 != null){
                    $diasStatus9 = $this->formatter->validarDiasHabiles($fechaApartado, $fechaStatus9);
                }
                else $diasStatus9 = 'NO APLICA';

                $data['data'][$x]['diasUltimoStatus'] = $diasUltimoStatus;
                $data['data'][$x]['diasStatus9'] = $diasStatus9;
                
            }
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else
            echo json_encode(array());
    }

    public function reporteConRecisiones(){
		$this->validateSession();

		$this->load->view('template/header');
		$this->load->view("reportes/reporteConRecisiones");
	}

    public function getVentasConSinRecision(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getVentasConSinRecision($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function reporteTrimestral(){
        $this->validateSession();

        $this->load->view('template/header');
        $this->load->view("reportes/reporteTrimestral");
    }

    public function getLotesTrimestral(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getReporteTrimestral($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function reporteApartados(){
        $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("reportes/reporteApartados");
    }

    public function getLotesApartados(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getLotesApartados($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getLotesXStatus(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getLotesXStatus($beginDate, $endDate)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getEstatusContratacionList(){
        $data = $this->Reporte_model->getEstatusContratacionList()->result_array();
        echo json_encode($data);
    }

    public function lotesXStatus(){        
		$this->load->view('template/header');
		$this->load->view("reportes/lotesXStatus_view");
    }

    public function reporteLotesCliente(){        
		$this->load->view('template/header');
		$this->load->view("reportes/reporteClientes_view");
    }

    public function ventasPorUsuario(){
        $this->load->view('template/header');
        $this->load->view("reportes/ventasPorUsuario");
    }
    public function getListadoDeVentas() {
        $fechaInicio = explode('/', $this->input->post("beginDate"));
        $fechaFin = explode('/', $this->input->post("endDate"));
        $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
        $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
        $result['data'] = $this->Reporte_model->getListadoDeVentas($beginDate, $endDate);
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function getAllLotes(){

        $nombreCliente = $this->input->post("nombreCliente");

        $data = $this->Reporte_model->getAllLotes($nombreCliente)->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getLotesUnicos(){

        $data = $this->Reporte_model->getLotesUnicos()->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getLotesTotal(){

        $data = $this->Reporte_model->getLotesTotal()->result_array();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getMensualidadAbonoNeo(){
        $empresa = $_POST['empresa'];
        $nombreLote = $_POST['nombreLote'];

        $data = $this->Reporte_model->getMensualidadAbonoNeo($empresa, $nombreLote);
        if( $data != null) {
            echo json_encode($data,JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }
    
    public function lotesContrato(){
        $this->load->view('template/header');
        $this->load->view("reportes/reporteLotesContrato");
    }
    public function getLotesContrato(){
        $beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
        $data = $this->Reporte_model->getLotesContrato($beginDate, $endDate);
        foreach ($data as $index=>$elemento){$data[$index]['nombreSede'] = ($elemento['nombreSede']=='')?'NA':$elemento['nombreSede'];}
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }
}