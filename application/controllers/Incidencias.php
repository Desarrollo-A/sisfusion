<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
 
class Incidencias extends CI_Controller
{
  private $gph;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Comisiones_model');
        $this->load->model('Incidencias_model');
        $this->load->model('asesor/Asesor_model');
        $this->load->model('Usuarios_modelo');
        $this->load->model('Incidencias_model');
        $this->load->model('PagoInvoice_model');
        $this->load->model('General_model');
        $this->load->model('ReporteContratacion_model');
        $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','phpmailer_lib','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function index()
    {
        $datos["sedes"] = $this->Incidencias_model->sedesCambios();
        $this->load->view('template/header');
        $this->load->view("incidencias/IncidenciasByLote", $datos);
    }

    public function getInCommissions($lote)
    {
      $datos = array();
      $datos = $this->Incidencias_model->getInCommissions($lote);
      if ($datos != null) {
        echo json_encode($datos);
      } else {
        echo json_encode(array());
      }
    }
  
    public function getUsuariosRol3($rol)
    {
      echo json_encode($this->Incidencias_model->getUsuariosRol3($rol)->result_array());
    }

    public function getAsesoresBaja() {
      $data = $this->Incidencias_model->getAsesoresBaja();
      if($data != null) {
        echo json_encode($data);
      }else{
        echo json_encode(array());
      }
      exit;
    }

    public function getUsuariosByrol($rol,$user){
      echo json_encode($this->Incidencias_model->getUsuariosByrol($rol,$user)->result_array());
    }

    public function GuardarPago($id_comision){
      $comentario_topa = $this->input->post('comentario_topa');
      $monotAdd =    $this->input->post('monotAdd');
      $respuesta = $this->Incidencias_model->GuardarPago($id_comision, $comentario_topa, $monotAdd);
      echo json_encode($respuesta); 
    }

    public function SaveAjuste($opc = ''){
      $id_comision = $this->input->post('id_comision');
      $id_usuario = $this->input->post('id_usuario');
      $id_lote =    $this->input->post('id_lote');
      $porcentaje = $pesos=str_replace("%", "", $this->input->post('porcentaje'));
      $porcentaje_ant = $this->input->post('porcentaje_ant');
      $comision_total = $pesos=str_replace(",", "", $this->input->post('comision_total'));
      $respuesta = $this->Incidencias_model->SaveAjuste($id_comision,$id_lote,$id_usuario,$porcentaje,$porcentaje_ant,$comision_total,$opc);
      echo json_encode($respuesta); 
    }

    public function CederComisiones(){
      $idAsesorOld = $this->input->post('asesorold');
      $rol = $this->input->post('roles2');
      $newUsuario = $this->input->post('usuarioid2');
      $respuesta = array($this->Incidencias_model->CederComisiones($idAsesorOld,$newUsuario,$rol));
      echo json_encode($respuesta[0]);
    }

    
    public function UpdateInventarioClient(){
      $usuarioOld=0;
      $banderaSubRegional = 2;
      $asesor=$this->input->post('asesor'); 
      $coordinador = $this->input->post('coordinador');
      $gerente = $this->input->post('gerente');
      $subdirector = $this->input->post('subdirector');
      $regional = $this->input->post('regional');
      $rolSelect= $this->input->post('roles3');
      $newColab = $this->input->post('usuarioid3');
      $comentario=$this->input->post('comentario3');
      $idLote=$this->input->post('idLote');
      $idCliente=$this->input->post('idCliente');

      if($rolSelect == 7){
        $usuarioOld=$asesor;
        
      }else if($rolSelect == 9){
        $usuarioOld=$coordinador;
        
      }else if($rolSelect == 3){
        $usuarioOld=$gerente;
        
      }else if($rolSelect == 2){
        $usuarioOld=$subdirector;
        $TieneRegional = $this->Incidencias_model->tieneRegional1($subdirector);
        if(count($TieneRegional) != 0 ){
            $banderaSubRegional = 1;
          }
        } else if($rolSelect == 59){
          $usuarioOld=$regional;
        }
      
        $respuesta = array($this->Incidencias_model->UpdateInventarioClient($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario,$banderaSubRegional, $regional));
        if ($banderaSubRegional == 1){
          $rolSelect = 59;
          $newColab  = 0;
          $usuarioOld = $regional;
          $respuesta = array($this->Incidencias_model->UpdateInventarioClient($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario,$banderaSubRegional, $regional));
        }
        echo json_encode($respuesta[0]);
    }

    public function UpdateVcUser(){
      $usuarioOld=0;
      $cuantos=$this->input->post('cuantos');
  
      if($cuantos == 1){
        $asesor=$this->input->post('asesor');
        $coordinador = $this->input->post('coordinador');
        $gerente = $this->input->post('gerente');
        $subdirector = $this->input->post('subdirector');
        $rolSelect= $this->input->post('rolesvc');
        $newColab = $this->input->post('usuarioid4');
        $comentario=$this->input->post('comentario4');
        $idLote=$this->input->post('idLote');
        $idCliente=$this->input->post('idCliente');
      }
  
      if($rolSelect == 7){
        $usuarioOld=$asesor;
      } else if($rolSelect == 9){
        $usuarioOld=$coordinador;
      } else if($rolSelect == 3){
        $usuarioOld=$gerente;
      } else if($rolSelect == 2){
        $usuarioOld=$subdirector;
      }

      $respuesta = array($this->Incidencias_model->UpdateVcUser($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario,$cuantos));
      echo json_encode($respuesta[0]);
    }

    public function getUserVC($id_cliente){
      $datos = $this->Incidencias_model->getUserVC($id_cliente)->result_array();
      echo json_encode($datos);
    }
    
    public function getUserInventario($id_cliente){
      $datos = $this->Incidencias_model->getUserInventario($id_cliente)->result_array();
      echo json_encode($datos[0]);
    }

    public function datosLotesaCeder($id_usuario){
      $respuesta = array($this->Incidencias_model->datosLotesaCeder($id_usuario));
      echo json_encode($respuesta);
    }

    public function saveTipoVenta(){
      $idLote = $this->input->post('id');
      $tipo = $this->input->post('tipo');
      $respuesta = $this->Incidencias_model->saveTipoVenta($idLote,$tipo);
      echo json_encode($respuesta); 
    }

    public function AddVentaCompartida(){
      $datosAse = explode(",",$this->input->post('usuarioid5'));
      $coor = $this->input->post('usuarioid6');
      $ger = $this->input->post('usuarioid7');
      $sub = $this->input->post('usuarioid8');
      $id_cliente = $this->input->post('id_cliente');
      $id_lote = $this->input->post('id_lote');
      $respuesta = array($this->Incidencias_model->AddVentaCompartida($datosAse[0],$coor,$ger,$sub,$id_cliente,$id_lote));
      echo json_encode($respuesta[0]);
    }
    
    public function getComisionesLoteSelected($idLote){
      echo json_encode($this->Incidencias_model->getComisionesLoteSelected($idLote)->result_array());
    }

    public function lista_lote($condominio){
      echo json_encode($this->Asesor_model->get_lote_lista($condominio)->result_array());
    }

    function getDatosAbonadoSuma11($idlote){
      echo json_encode($this->Incidencias_model->getDatosAbonadoSuma11($idlote)->result_array());
    }

    public function CambiarPrecioLote(){
      $idLote = $this->input->post("idLote");
      $precioAnt = $this->input->post("precioAnt");
      $precio=str_replace(",", "", $this->input->post("precioL"));
      $comentario='Se modificó el precio de '.$precioAnt.' a '.$precio;
      $respuesta = $this->Incidencias_model->CambiarPrecioLote($idLote,$precio,$comentario);
    echo json_encode($respuesta);
    }

    public function tieneRegional(){
      $bandera = false;
      $usuario = $this->input->post("usuario");
      $regionals = $this->Incidencias_model->tieneRegional1($usuario); 
      if(count($regionals) > 0 ){
        $bandera = $regionals;      
      }else{
        $bandera = false;      
      }
      echo json_encode( $bandera );
    }

    public function getLideres($lider){
      echo json_encode($this->Incidencias_model->getLideres($lider)->result_array());
    }

    public function updateBandera(){
      $response = $this->Incidencias_model->updateBandera( $_POST['id_pagoc'], $_POST['param']);
      echo json_encode($response);
    }

    function getDatosAbonadoDispersion($idlote){
      echo json_encode($this->Incidencias_model->getDatosAbonadoDispersion($idlote)->result_array());
    }
    
    public function getPagosByComision($id_comision){
      $respuesta = $this->Incidencias_model->getPagosByComision($id_comision);
      echo json_encode($respuesta); 
    }

    public function getModalidadCambio() {
      $descripcion = $this->input->post('descripcion');
      $estatus = $this->input->post('compartida');
      $id_cliente = $this->input->post('cliente_modalidad');
      $idLote = $this->input->post('idLote');

      if($estatus !== NULL){
        $estatus = 0;
      }

      $result = $this->Incidencias_model->getModalidadCambio($estatus, $id_cliente);
      $result_2 = $this->Incidencias_model->agregarComentario($id_cliente, $descripcion, $idLote);
  
      echo json_encode($result,$result_2);
    }

    // public function ToparComision_2($id_comision, $idLote = ''){
    //   $comentario = $this->input->post("descripcion");
    //   $respuesta = $this->Comisiones_model->ToparComision_2($id_comision,$comentario);
    //   echo json_encode($respuesta); 
    // }

    public function ToparComision($id_comision,$idLote = '')
    {
      $comentario = $this->input->post("comentario");
      $respuesta = $this->Incidencias_model->ToparComision($id_comision,$comentario);
      echo json_encode($respuesta); 
    }

    public function updateEstatusCompartidas()
    {
      $this->db->trans_begin();
      $idLote = $this->input->post('idLote');
      $idCliente = $this->input->post('idCliente');
      $index = $this->input->post('index');
      $idVentasCompartidas = [];
      $modificadoPor = $this->session->userdata('id_usuario');
      
      for ($o=1; $o < $index; $o++) {
        if(!empty($this->input->post('checkBoxVC_'.$o))){
          echo $this->input->post('checkBoxVC_'.$o);
          //$respuesta = $this->Incidencias_model->updateEstatusVentasC($this->input->post('checkBoxVC_'.$o),$modificadoPor);
          array_push($idVentasCompartidas,$this->input->post('checkBoxVC_'.$o));
        } 
      }
      var_dump($idVentasCompartidas);


      exit;

      $compartidas = $this->Incidencias_model->getAllCompartidas($idCliente);

      

      // Combina $result y $compartidas en un solo arreglo
      $datos_combinados = array_merge($result, $compartidas);

      // Bucle para $result y $compartidas combinados
      foreach ($datos_combinados as $data) {
          foreach ($columnas as $rol => $id_usuario) {
              $id_usuario = implode(" ", $id_usuario);

              var_dump($id_usuario);
              var_dump($data[$rol]);
              exit;
              if ($id_usuario != $data[$rol]) {
                  $result_2[] = $this->Incidencias_model->getNuevoIdComision($idLote, $idCliente, $id_usuario);
              }
          }
      }


      $checkboxesSeleccionados = $this->input->post('checkboxesSeleccionados');

      foreach ($checkboxesSeleccionados as $id_vcompartida) {
          $respuesta = $this->Incidencias_model->updateEstatusVentasC($nuevo_estatus, $id_vcompartida);
      }

      $result_2_json = json_encode($result_2);

      $response = array(
          'respuesta' => $respuesta,
          'result_2' => $result_2_json
      );
      if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();
        echo json_encode(0);

    } else {
        $this->db->trans_commit();
        echo json_encode(1);
    }
      echo json_encode($response);
    }

    

    public function getComisionistas(){
      $result = $this->Incidencias_model->getComisionistas($this->input->post('idLote'));
      echo json_encode($result);
    }

    public function getAllCompartidas(){
      $id_cliente = $this->input->post('id_cliente');

      $result = $this->Incidencias_model->getAllCompartidas($id_cliente);

      echo json_encode($result);
    }

    public function comentarioComisiones() {
      $idCliente = $this->input->post('idCliente');
      $id_lote = $this->input->post('id_lote');  
      $descripcionCambio = $this->input->post('descripcionCambio');
      $result_2 = $this->Incidencias_model->agregarComentario($idCliente, $id_lote, $descripcionCambio);
      
      echo json_encode($result_2);
    }

    public function updateEstatusVentas() {
      $this->db->trans_begin();

      $informacion = $this->input->post('informacion');

      //PARA $result
      $estatus = $this->input->post('estatusCompartidas');
      $id_vcompartida = $this->input->post('id_vcompartida');
      $estatus = ($estatus == 1) ? 0 : $estatus;
      $result = $this->Incidencias_model->updateEstatusVentasC($estatus, $id_vcompartida);

      //PARA $results
      $infoUsuarios = $this->input->post('infoUsuarios');
      $estatusComisiones = $this->input->post('estatusComisiones');
      $infoLotes = $this->input->post('infoLotes');
      $infoClientes = $this->input->post('infoClientes');
      $estatusNuevo = ($estatusComisiones == 1) ? 1 : 1;
      $descripcionCambio = $this->input->post('descripcionCambio');

  
      $result_2 = false;

      for ($i = 0; $i < count($informacion); $i++) {        
          $result_2 = $this->Incidencias_model->updateEstatus8($infoLotes[$i], $infoClientes[$i], $estatusNuevo, $infoUsuarios[$i],$descripcionCambio); 
      }
  
      if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        $resultado = array("resultado" => FALSE);
      }else{
        $this->db->trans_commit();
        $resultado = array("resultado" => TRUE);
      }
      echo json_encode($resultado);
    }
  

  public function updateComisiones() {

    $informacion = $this->input->post('informacion');
    $infoPorcentajeNuevo = $this->input->post('infoPorcentajeNuevo');
    $infoUsuarios = $this->input->post('infoUsuarios');
    $infoIdComision = $this->input->post('infoIdComision');
    $totales = $this->input->post('totales');

    $results = array();

    for ($i = 0; $i < count($informacion); $i++) {
        $data = array(
            "porcentaje_decimal" => $infoPorcentajeNuevo[$i],
            "modificado_por" => $infoUsuarios[$i],
            "comision_total" => $totales[$i]
        );

        $result = $this->Incidencias_model->updateComisiones($data, $infoIdComision[$i]);

        $results[] = $result;
    }

    if (is_array($results)) {
        echo json_encode($results);
    } else {
        echo json_encode(array("error" => "Error en la respuesta del servidor"));
    }
  }

    public function cambioSede(){
      $sede     = $this->input->post("sedesCambio");
      $lote     = $this->input->post("idLote");
      $cliente  = $this->input->post("cliente");
      $planComision = 0;
      $arr_update = array( 
        "id_sede"                 =>  intval($sede),
        "plan_comision"           =>  $planComision, 
      );
      
      $update = $this->Incidencias_model->updateSedesEdit($cliente, $lote, $arr_update);
      if($update){
        $respuesta =  array(
          "response_code" => 200, 
          "response_type" => 'success',
          "message" => "Sede actualizada");
        } else{
          $respuesta =  array(
            "response_code" => 400, 
            "response_type" => 'error',
            "message" => "Sede no actualizada, inténtalo más tarde ");
        }
        echo json_encode ($respuesta);
    }

    public function fillMensualidades() {
      echo json_encode($this->Incidencias_model->getMensualidades()->result_array());
    }

    public function updateMensualidades() {
      $idUsuarioM =  $this->session->userdata('id_usuario');
      $mensualidad = $this->input->post('tipoMensualidad');
      $idCliente = $this->input->post('idCliente');
      $idLote = $this->input->post('idLote');
  
      $result = $this->Incidencias_model->updateMensualidades($mensualidad, $idCliente, $idLote ,$idUsuarioM);
      
      echo json_encode ($result);

    }
  
    public function AddEmpresa(){
      $idLote = $this->input->post("idLoteE");
      $Precio = $this->input->post("PrecioLoteE");
      $idCliente = $this->input->post("idClienteE");
  
      $respuesta = $this->Incidencias_model->AddEmpresa($idLote,($Precio*(1/100)),$idCliente);
      echo json_encode($respuesta);
    }

}