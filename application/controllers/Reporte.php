<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reporte extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reporte_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
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
            $currentYear = date("Y");

            $data['data'] = $this->Reporte_model->getGeneralInformation($beginDate, $endDate, $rol, $id_usuario, $render)->result_array();

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
        if( $this->input->post("beginDate")==null && $this->input->post("endDate") == null){
            $beginDate = "$currentYear-01-01";
            $endDate = date("Y-m-d");
        }else{
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
        }
        $id = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');
        
        if( $rol == 2 || $rol == 5){
            $condicion_x_rol = $this->validateRegional($id);
            $getRol = $this->Reporte_model->validateRegional($id);
            if(count($getRol) > 1){
                $rol = 59;
                $coordinador = true;
                $arraySalesBySubdir = $this->chartRegional($id, $beginDate, $endDate);
                $coordinadorVC = $arraySalesBySubdir[0];
                $coordinadorVA = $arraySalesBySubdir[1];
                $coordinadorCC = $arraySalesBySubdir[2];
                $coordinadorCA = $arraySalesBySubdir[3]; 
            }
        }
        else if( $rol == 3 ){
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

        if( $rol == 4 || $rol == 5 || $rol == 6 ) $id = $this->session->userdata('id_lider');
        $data = $this->Reporte_model->getDataChart($general, $tipoChart, $rol, $condicion_x_rol, $coordinador, $coordinadorVC, $coordinadorVA, $coordinadorCC, $coordinadorCA, $beginDate, $endDate);
        
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
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

        $data = $this->Reporte_model->getDetails($beginDate, $endDate, $rol, $id_usuario, $render, $leader)->result_array();
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
            $data['data'] = $this->Reporte_model->getGeneralLotesInformation($beginDate, $endDate, $rol, $id_usuario, $render, $type, $sede, $leader)->result_array();
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
}
