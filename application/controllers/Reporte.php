<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reporte extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reporte_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email', 'Jwt_actions'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->jwt_actions->authorize('9717', $_SERVER['HTTP_HOST']);
        $this->validateSession();
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
        $currentYear = date("Y");

        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            //si es consulta inicial = 1 o si es consulta con filtro de fechas = 2
            if( $typeTransaction==1){
                $beginDate = "$currentYear-01-01";
                $endDate = date("Y-m-d");
            }else{
                $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
                $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            }
            $id_usuario = $this->input->post("id_usuario");
            $where = $this->input->post("where");
            $rol = $this->input->post("type");
            $render = $this->input->post("render");
            $asesor = $this->input->post("asesor");
            $coordinador = $this->input->post("coordinador");
            $gerente = $this->input->post("gerente");
            $subdirector = $this->input->post("subdirector");
            $regional = $this->input->post("regional");
            $typeSale = $this->input->post("typeSale");
            $currentYear = date("Y");
            $data['data'] = $this->Reporte_model->getGeneralInformation($beginDate, $endDate, $rol, $id_usuario, $render, [$asesor, $coordinador, $gerente, $subdirector, $regional], $typeTransaction, $typeSale)->result_array();
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            json_encode(array());
        }
    }

    public function getDataChart(){
        $currentYear = date("Y");

        $coordinadorVC = ''; $coordinadorVA = ''; $coordinadorCC = ''; $coordinadorCA = ''; $coordinador = false;
        $general = $this->input->post('general');
        $tipoChart = $this->input->post('tipoChart');
        $typeSale = $this->input->post('typeSale');
        $id_rol = $this->input->post('type');
        $render = $this->input->post('render');
        $asesor = $this->input->post("asesor");
        $coordinador = $this->input->post("coordinador");
        $gerente = $this->input->post("gerente");
        $subdirector = $this->input->post("subdirector");
        $regional = $this->input->post("regional");

        if( $this->input->post("beginDate")==null && $this->input->post("endDate") == null){
            $beginDate = "$currentYear-01-01";
            $endDate = date("Y-m-d");
        }
        else{
            $beginDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("beginDate"))));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post("endDate"))));
        }
        
        /*
        $id = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');

        
        //Provisional para simular rol como director
        if ( $rol == 18 || $rol == 4 || $rol == 63 || $rol == 33 || $rol == 58 || $rol == 69){
            $rol = 1;
            $id = 2;
        }
        //  5: Asistente subdirector especificamente para los usuarioas 28 y 30
        else if( $rol == 5 && ( $id != 28 || $id != 30 )){
            $rol = 1;
            $id = 2;
        }

        if( $rol == 2 || $rol == 5){
            if ( $rol == 5 ) $id = $this->session->userdata('id_lider'); //Se asignara id de su lider (para asistentes de dirección y subdirección)

            $condicion_x_rol = $this->validateRegional($id);
            $getRol = $this->Reporte_model->validateRegional($id);

            if(count($getRol) > 1){
                if( ( $rol == 5 || $rol == 2 ) && ( $id == 28 || $id == 30 ) ) $rol = 59; //Se asigna rol de dto. regional y  subdto.
                
                $coordinador = true;
                $arraySalesBySubdir = $this->chartRegional($id, $beginDate, $endDate);
                $coordinadorVC = $arraySalesBySubdir[0];
                $coordinadorVA = $arraySalesBySubdir[1];
                $coordinadorCC = $arraySalesBySubdir[2];
                $coordinadorCA = $arraySalesBySubdir[3]; 
            }
            else $rol = 2;//Validación para asistentes de dto. regional, se asigna rol especial

        }
        else if( $rol == 3 || $rol == 6 ){
            if( $rol == 6 ){ //Validación para asistente gte
                $id = $this->session->userdata('id_lider');
                $rol = 3;
            }
            $condicion_x_rol = ' AND cl.id_gerente = ' . $id;
        }
        else if( $rol == 7 ){
            $condicion_x_rol = ' AND cl.id_asesor = ' . $id;
        }
        else if( $rol == 9 ){
            $condicion_x_rol = ' AND cl.id_coordinador = ' . $id;
            $rol = 7;
            $coordinador = true;
            $arraySalesByCoor = $this->chartCoordinator($id, $beginDate, $endDate);
            $coordinadorVC = $arraySalesByCoor[0];
            $coordinadorVA = $arraySalesByCoor[1];
            $coordinadorCC = $arraySalesByCoor[2];
            $coordinadorCA = $arraySalesByCoor[3]; 
        }
        else{
            $condicion_x_rol = '';
        }
        */

        $data = $this->Reporte_model->getDataChart($general, $tipoChart, $id_rol, $beginDate, $endDate, $typeSale, $render, [$asesor, $coordinador, $gerente, $subdirector, $regional]);

        //Obtenemos solo array de ventas contratadas
        $vcArray = array_filter($data, function($element){
            return $element['tipo'] == 'vc';
        });

        //Obtenemos solo array de ventas apartadas
        $vaArray = array_filter($data, function($element){
            return $element['tipo'] == 'va';
        });

        //Reindexamos el filtro obtenido anteriormente
        $vcArray = array_values($vcArray);
        $vaArray = array_values($vaArray);

        //Recorremos uno de los arrays obtenido anteriormente y sumamos en cada uno de los puntos para obtener cantidad y total
        if( $general == "1" || $tipoChart == "vt"){
            if($tipoChart == "vt"){
                $data = array();
            }
            foreach( $vcArray as $key => $elemento ){
                $tot1 = floatval(preg_replace('/[^\d\.]/', '', $elemento['total']));
                $tot2 = floatval(preg_replace('/[^\d\.]/', '', $vaArray[$key]['total']));
                
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

    public function chartCoordinator($id, $beginDate, $endDate){
        $coordinadorAll = [];
        $coordinadorVC = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'vc' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total,
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3)
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE ISNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' 
        AND cl.id_asesor = $id
        AND hlo2.idStatusContratacion >= 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";
        // array_push($coordinadorAll, $coordinadorVC);

        $coordinadorVA = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'va' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total  WHEN totalNeto2 = 0 THEN total  ELSE totalNeto2  END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' 
        AND cl.id_asesor = $id
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";
        // array_push($coordinadorAll, $coordinadorVA);

        $coordinadorCC = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'  
        AND cl.id_asesor = $id
        AND hlo2.idStatusContratacion >= 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $coordinadorCA = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0 
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'  
        AND cl.id_asesor = $id
        AND hlo2.idStatusContratacion < 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        array_push($coordinadorAll, $coordinadorVC, $coordinadorVA, $coordinadorCC, $coordinadorCA);
        return $coordinadorAll;
    }

    public function chartRegional($id, $beginDate, $endDate){
        $subdirectorAll = [];
        $subdirectorVC = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'vc' tipo, '2' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total,
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote IN (2, 3)
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE ISNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' 
        AND cl.id_subdirector = $id
        AND hlo2.idStatusContratacion >= 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";
        // array_push($subdirectorAll, $subdirectorVC);

        $subdirectorVA = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'va' tipo, '2' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total  WHEN totalNeto2 = 0 THEN total  ELSE totalNeto2  END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2 AND lo.idStatusContratacion < 11
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' 
        AND cl.id_subdirector = $id
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";
        // array_push($subdirectorAll, $subdirectorVA);

        $subdirectorCC = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '2' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'  
        AND cl.id_subdirector = $id
        AND hlo2.idStatusContratacion >= 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";

        $subdirectorCA = "SELECT ISNULL(total, 0) total, ISNULL(cantidad, 0) cantidad, MONTH(DateValue) mes, YEAR(DateValue) año, 'cc' tipo, '2' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes, YEAR(cl.fechaApartado) año
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND isNULL(isNULL(cl.tipo_venta_cl, lo.tipo_venta), 0) IN (0, 1, 2) AND cl.status = 0  
        AND cl.fechaApartado BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000'  
        AND cl.id_subdirector = $id
        AND hlo2.idStatusContratacion < 11
        GROUP BY MONTH(cl.fechaApartado), YEAR(cl.fechaApartado)) qu ON qu.mes = month(cte.DateValue) AND qu.año = year(cte.DateValue)
        GROUP BY Month(DateValue), YEAR(DateValue), cantidad, total";
        
        array_push($subdirectorAll, $subdirectorVC, $subdirectorVA, $subdirectorCC, $subdirectorCA);
        return $subdirectorAll;
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

    public function getDetails(){
        $typeTransaction = $this->input->post("transaction");//si es consulta inicial = 1 o si es consulta con filtro de fechas = 2
        
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
        $id_usuario = $this->input->post("id_usuario");
        $rol = $this->input->post("rol");
        $render = $this->input->post("render");
        $leader = $this->input->post("leader");
        $asesor = $this->input->post("asesor");
        $coordinador = $this->input->post("coordinador");
        $gerente = $this->input->post("gerente");
        $subdirector = $this->input->post("subdirector");
        $regional = $this->input->post("regional");
        $typeSale = $this->input->post("typeSale");

        $data = $this->Reporte_model->getDetails($typeSale, $beginDate, $endDate, $rol, $id_usuario, $render, $leader, [$asesor, $coordinador, $gerente, $subdirector, $regional])->result_array();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
    }
    public function get4MonthsRequest(){
        $data = $this->get4Months();
        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        }
        else echo json_encode(array());
    }

    public function getLotesInformation(){
        if (isset($_POST) && !empty($_POST)) {
            $type = $this->input->post("type");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
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
            $typeSale = $this->input->post("typeSale");

            $data['data'] = $this->Reporte_model->getGeneralLotesInformation($typeSale, $beginDate, $endDate, $rol, $id_usuario, $render, $type, $sede, $leader, [$asesor, $coordinador, $gerente, $subdirector, $regional])->result_array();
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else
            echo json_encode(array());
    }

    public function reporteConRecisiones(){
		$this->validateSession();

   		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('template/header');
		$this->load->view("reportes/reporteConRecisiones",$datos);
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

        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        $this->load->view('template/header');
        $this->load->view("reportes/reporteTrimestral",$datos);
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
}
