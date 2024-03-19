<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Seguros extends CI_Controller
{
    private $gph;
    public function __construct()
    {
    parent::__construct();
    $this->load->model(array('Comisiones_model', 'General_model','Seguro_model','Usuarios_modelo'));
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('1616', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
    }

    public function index(){
        redirect(base_url());
    }
    public function validateSession() {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

    /**-----------------VISTAS---------------* */
    public function comisiones_colaborador(){
        $datos = array();
        $datos["opn_cumplimiento"] = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();
        $this->load->view('template/header');
        $this->load->view("ventas/comisionesColaboradorSeguros", $datos);
    }
    /**--------------------------------------- */
    public function getDatosComisionesAsesor($a)
    {
    $dat =  $this->Seguro_model->getDatosComisionesAsesor($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
        $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
    }
    public function getTotalComisionAsesor()
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Seguro_model->getTotalComisionAsesor($idUsuario);
        echo json_encode($data);
    }
    public function getComments($id_pago_i){
        echo json_encode($this->Seguro_model->getComments($id_pago_i)->result_array());
    }
    public function consulta_codigo_postal(){
        $resolt = $this->Seguro_model->consulta_codigo_postal($this->session->userdata('id_usuario'))->result_array();
        echo json_encode($resolt);
      }
      public function acepto_comisiones_user(){
        $formaPagoInvalida = [2,3,4,5];
        $id_user_Vl = $this->session->userdata('id_usuario');
        $formaPagoUsuario = $this->session->userdata('forma_pago');
        $sol=$this->input->post('idcomision');  
        $consulta_comisiones = $this->db->query("SELECT pci.id_pago_i FROM pago_seguro_ind pci LEFT JOIN usuarios u ON u.id_usuario=pci.id_usuario WHERE pci.id_pago_i IN (".$sol.")");
        $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 WHEN tipo=3 THEN 4 ELSE 0 END) tipo,forma_pago FROM usuarios WHERE id_usuario IN (".$id_user_Vl.")")->result_array();
    
        if(in_array($consultaTipoUsuario[0]['forma_pago'],$formaPagoInvalida)){ //EL COMISIONISTA SI TIENE UNA FORMA DE PAGO VALIDA Y CONTINUA CON EL PROCESO DE ENVIO DE COMISIONES
          $opinionCumplimiento = $this->Comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl);
          $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
          $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND corteOoam = ".$consultaTipoUsuario[0]['tipo']." AND YEAR(GETDATE()) = YEAR(fechaInicio) /*AND DAY(GETDATE()) = DAY(fechaFinGeneral)*/ AND mes = $mesActual")->result_array();
    
          $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;
          
          if( $consulta_comisiones->num_rows() > 0 && $consultaFechasCorte ){
            $validar_sede = $this->session->userdata('id_sede');
            $fecha_actual = strtotime($obtenerFechaSql);
            $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
            $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
            
            if($formaPagoUsuario == 3){
              $consultaCP = $this->Comisiones_model->consulta_codigo_postal($id_user_Vl)->result_array();
            }
    
            if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) || ($id_user_Vl == 7689)){
              if( $formaPagoUsuario == 3 && ( $this->input->post('cp') == '' || $this->input->post('cp') == 'undefined' ) ){
                $data_response = 3;
                echo json_encode($data_response);
              } else if( $formaPagoUsuario == 3 && ( $this->input->post('cp') != '' || $this->input->post('cp') != 'undefined' ) &&  $consultaCP[0]['estatus'] == 0 ){
                $data_response = 4;
                echo json_encode($data_response);
              } else{
                $consulta_comisiones = $consulta_comisiones->result_array();
                $sep = ',';
                $id_pago_i = '';
                $data=array();
                $pagoInvoice = array();
    
                foreach ($consulta_comisiones as $row) {
                  $id_pago_i .= implode($sep, $row);
                  $id_pago_i .= $sep;
    
                  $row_arr=array(
                    'id_pago_i' => $row['id_pago_i'],
                    'id_usuario' =>  $id_user_Vl,
                    'fecha_movimiento' => date('Y-m-d H:i:s'),
                    'estatus' => 1,
                    'comentario' =>  'COLABORADOR ENVÍO A CONTRALORÍA' 
                  );
                  array_push($data,$row_arr);
    
                  if ($formaPagoUsuario == 5) { // Pago extranjero
                    $pagoInvoice[] = array(
                      'id_pago_i' => $row['id_pago_i'],
                      'nombre_archivo' => $opinionCumplimiento->archivo_name,
                      'estatus' => 1,
                      'modificado_por' => $id_user_Vl,
                      'fecha_registro' => date('Y-m-d H:i:s')
                    );
                  }
                }
    
                $id_pago_i = rtrim($id_pago_i, $sep);
                $up_b = $this->Seguro_model->update_acepta_solicitante($id_pago_i);
                $ins_b = $this->Comisiones_model->insert_phc($data);
                $this->Comisiones_model->changeEstatusOpinion($id_user_Vl);
                if ($formaPagoUsuario == 5) {
                  $this->PagoInvoice_model->insertMany($pagoInvoice);
                }
                  
                if($up_b == true && $ins_b == true){
                  $data_response = 1;
                  echo json_encode($data_response);
                } else {
                  $data_response = 0;
                  echo json_encode($data_response);
                } 
              }
            } else {
              $data_response = 2;
              echo json_encode($data_response);
            }
          } else{
            $data_response = 0;
            echo json_encode($data_response);
          }
        }else{ //EL COMISIONISTA NO TIENE UNA FORMA DE PAGO VALIDA Y TERMINA CON EL PROCESO DE ENVIO DE COMISIONES
          $data_response = 5;
          echo json_encode($data_response);
        } 
      }    

      public function getGeneralStatusFromNeodata($proyecto, $condominio)
      {
        $this->load->model('ComisionesNeo_model');
          $datos = $this->ComisionesNeo_model->getLotesByAdviser($proyecto, $condominio);
          if(COUNT($datos) > 0){
              $data = array();
              $final_data = array();
              $contador = 0;
              for($i = 0; $i < COUNT($datos); $i++){
                  $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
                  $final_data[$contador] = $this->ComisionesNeo_model->getLoteInformation($datos[$i]['idLote']);
                  $final_data[$contador]->reason = $data[$i]->Marca;
                  $contador ++;
              }
              if (COUNT($final_data) > 0) {
                  echo json_encode(array("data" => $final_data));
              } else {
                  echo json_encode(array("data" => ''));
              }
          }
          else{
              echo json_encode(array("data" => ''));
          }
      }
    
        public function getFechaCorteActual(){
        $tipoUsuario = (($this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 2 ) ?  ($this->session->userdata('tipo') == 1 ? ( date('N') == 3 ? '3' : '1'): '2') :( $this->session->userdata('tipo') == 3 ? '4' : '1' ));
        $diaActual = date('d'); 
        $fechaCorte = $this->Comisiones_model->getFechaCorteActual($tipoUsuario,$diaActual);
        echo json_encode(array("fechasCorte" => $fechaCorte),JSON_NUMERIC_CHECK);
        }


}