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
        if (isset($_POST) && !empty($_POST)) {
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate")));
            $endDate = date("Y-m-d", strtotime($this->input->post("endDate")));
            $where = $this->input->post("where");
            $type = $this->input->post("type");
            $saleType = $this->input->post("saleType");
            $currentYear = date("Y");
            if ($type == 1) { // GENERAL TABLE
                $data['data'] = $this->Reporte_model->getGeneralInformation($typeTransaction, $beginDate, $endDate, $currentYear, $saleType)->result_array();
            } else if ($type == 2) { // MANAGER TABLE
                $data['data'] = $this->Reporte_model->getInformationByManager($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 3) { // COORDINATOR TABLE
                $data['data'] = $this->Reporte_model->getInformationByCoordinator($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            } else if ($type == 4) { // ADVISER TABLE
                $data['data'] = $this->Reporte_model->getInformationByAdviser($typeTransaction, $beginDate, $endDate, $currentYear, $where, $saleType)->result_array();
            }
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }

    public function getDataChart(){
        $coordinadorVC = ''; $coordinadorVA = ''; $coordinadorCC = ''; $coordinadorCA = ''; $coordinador = false;
        $general = $this->input->post('general');
        $tipoChart = $this->input->post('tipoChart');
        $beginDate = date("Y-m-d", strtotime($this->input->post("beginDate"))) . ' 00:00:00.000';
        $endDate = date("Y-m-d", strtotime($this->input->post("endDate"))) . ' 23:59:00.000';

        $id = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');
        
        if( $rol == 2 || $rol == 5){
            $condicion_x_rol = $this->validateRegional($id);
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
        $coordinadorVC = "SELECT qu.total, cantidad, DateValue, 'vc' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT  FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total,
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote = 2
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
        GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        WHERE ISNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate'
        AND cl.id_asesor = $id
        GROUP BY MONTH(cl.fechaApartado)) qu ON qu.mes = cte.DateValue";
        // array_push($coordinadorAll, $coordinadorVC);

        $coordinadorVA = "SELECT qu.total, cantidad, DateValue,'va' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total  WHEN totalNeto2 = 0 THEN total  ELSE totalNeto2  END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idStatusLote != 2
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 1 AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate'
        AND cl.id_asesor = $id
        GROUP BY MONTH(cl.fechaApartado)) qu ON qu.mes = cte.DateValue";
        // array_push($coordinadorAll, $coordinadorVA);

        $coordinadorCC = "SELECT qu.total, cantidad, DateValue, 'cc' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
        GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0  AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate' 
        AND cl.id_asesor = $id
        GROUP BY MONTH(cl.fechaApartado)) qu ON qu.mes = cte.DateValue";
        // array_push($coordinadorAll, $coordinadorCC);

        $coordinadorCA = "SELECT qu.total, cantidad, DateValue, 'ca' tipo, '9' rol FROM cte
        LEFT JOIN (SELECT FORMAT(ISNULL(SUM(CASE WHEN totalNeto2 IS NULL THEN total WHEN totalNeto2 = 0 THEN total ELSE totalNeto2 END), 0), 'C') total, 
        COUNT(*) cantidad, MONTH(cl.fechaApartado) mes
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.tipo NOT IN (2, 5, 6) AND hl.id_cliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45
        GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        WHERE isNULL(noRecibo, '') != 'CANCELADO' AND cl.status = 0  AND cl.fechaApartado BETWEEN '$beginDate' AND '$endDate' 
        AND cl.id_asesor = $id
        GROUP BY MONTH(cl.fechaApartado)) qu ON qu.mes = cte.DateValue";
        // array_push($coordinadorAll, $coordinadorCA);

        array_push($coordinadorAll, $coordinadorVC, $coordinadorVA, $coordinadorCC, $coordinadorCA);
        return $coordinadorAll;
    }

    // public function getSpecificChart(){
    //     $tipo = $this->input->post('type');
    //     $id = $this->session->userdata('id_usuario');
    //     if( $tipo == '1' )
    //         $data = $this->Reporte_model->getVentasContratadas($id);
    //     else if( $tipo == '2' )
    //         $data = $this->Reporte_model->getVentasApartadas($id);
    //     else if( $tipo == '3' )
    //         $data = $this->Reporte_model->getCancelasContratadas($id);
    //     else if( $tipo == '4' )
    //         $data = $this->Reporte_model->getCanceladasApartadas($id);

    //     if($data != null) {
    //         echo json_encode($array);
    //     }
    //     else echo json_encode(array());
    // }

    public function validateRegional($id){
        $data = $this->Reporte_model->validateRegional($id);
        if($data != null) $where = " AND cl.id_regional = " . $id;
        else $where = " AND cl.id_subdirector = " . $id;

        return $where;
    }
}
 
