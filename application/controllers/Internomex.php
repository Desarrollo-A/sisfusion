  <?php
  defined('BASEPATH') or exit('No direct script access allowed');

  use PhpOffice\PhpSpreadsheet\Spreadsheet;


  class Internomex extends CI_Controller
  {
    private $gph;
    public function __construct()
    {
      parent::__construct();
      $this->load->model(array('Internomex_model', 'asesor/Asesor_model'));
      $this->load->library(array('session','form_validation', 'get_menu', 'Jwt_actions'));
      $this->load->helper(array('url', 'form'));
      $this->load->database('default');
    }


    public function index()
    {
      if ($this->session->userdata('id_rol') == false || $this->session->userdata('id_rol') != '31') {
        redirect(base_url() . 'login');
      }
      /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
      $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
      /*-------------------------------------------------------------------------------*/
      $this->load->view('template/header');
      // $this->load->view('internomex/inicio_internomex_view',$datos);
      $this->load->view('template/home',$datos);
      $this->load->view('template/footer');
    }

    
    public function nuevos()
    {
     /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
     $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
     /*-------------------------------------------------------------------------------*/

     $this->load->view('template/header');
     $this->load->view("internomex/nuevos", $datos);
   }

   public function getDatosNuevasInternomex($proyecto,$condominio){
    $dat =  $this->Internomex_model->getDatosNuevasInternomex($proyecto,$condominio)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
   }
   echo json_encode( array( "data" => $dat));
  }



  public function aplicados()
  {
    /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
    $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
    /*-------------------------------------------------------------------------------*/
    $this->load->view('template/header');
    $this->load->view("internomex/aplicados", $datos);
  }

  public function getDatosAplicadosInternomex($proyecto,$condominio){
    $dat =  $this->Internomex_model->getDatosAplicadosInternomex($proyecto,$condominio)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
   }
   echo json_encode( array( "data" => $dat));
  }



  public function historial()
  {
    /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
    $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
    /*-------------------------------------------------------------------------------*/
    $this->load->view('template/header');
    $this->load->view("internomex/historial", $datos);
  }

  public function getDatosHistorialInternomex($proyecto,$condominio){
    $dat =  $this->Internomex_model->getDatosHistorialInternomex($proyecto,$condominio)->result_array();
    for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
   }
   echo json_encode( array( "data" => $dat));
  }


  public function aplico_internomex_pago($sol){
    $this->load->model("Internomex_model");   
    $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");
    
    if( $consulta_comisiones->num_rows() > 0 ){
     $consulta_comisiones = $consulta_comisiones->result_array();
     for( $i = 0; $i < count($consulta_comisiones ); $i++){
      $this->Internomex_model->update_aplica_intemex($consulta_comisiones[$i]['id_pago_i']);
    }
  }
  else{
   $consulta_comisiones = array();
  }
  }

  public function loadFinalPayment()
  {
    $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
    $this->load->view('template/header');
    $this->load->view("internomex/load_final_payment", $datos);
  }

  public function getPaymentsListByCommissionAgent()
  {
    $data = $this->Internomex_model->getCommissions()->result_array();
    echo json_encode($data);
  }
  public function getPagosFinal(){
    
  }

  public function insertInformation() {
    if (!isset($_POST))
      echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."));
    else {
      if ($this->input->post("data") == "")
        echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado."), JSON_UNESCAPED_UNICODE);
      else {
        $data = $this->input->post("data");
        $decodedData = $this->jwt_actions->decodeData('4582', $data);
        if (in_array($decodedData, array('ALR001', 'ALR003', 'ALR004', 'ALR005', 'ALR006', 'ALR007', 'ALR008', 'ALR009', 'ALR010', 'ALR012', 'ALR013', 'ALR002', 'ALR011', 'ALR014')))
          echo json_encode(array("status" => 500, "message" => "No se logró decodificar la data."), JSON_UNESCAPED_UNICODE);
        else {

          $decodedData1 = explode(",", $decodedData);

          $insertAuditoriaData = array("fecha_creacion" => date("Y-m-d H:i:s"), "creado_por" => $this->session->userdata('id_usuario'));
          //echo json_encode($decodedData1);         
          $infos = array();
          $infos2 = array();
          $infos3 = array();
          $infos4 = array();
          $clave =0 ;
          $UserYaAgregados = array();
          $flag   = 0 ;
          $bande  = true;
          $banda  = true;
          $year   = date("Y");
          $mes    = date("m");
         
         
          for ($i = 0; $i < count($decodedData1) ; $i++) { 
            if($flag == 0){
              if($banda){
                $idUser = substr($decodedData1[$i],15);
                $banda = false;  
              }else{ 
                $idUser = substr($decodedData1[$i],14);
                    }
             if(isset($decodedData1[$i]) && !empty($decodedData1[$i]) ) {
              $clave = $idUser ;
                $infoIdUser = array ("id_usuario" => $idUser);
            }  
              $bande = true;
            }else if($flag == 1){
              $nombreUsuario      = substr($decodedData1[$i], 17 , -1);  
            }else if($flag == 2){  
              $tipoUsuario        = substr($decodedData1[$i], 15, -1);      
            }else if($flag == 3){ 
              $sede               = substr($decodedData1[$i], 8, -1);     
            }else if($flag == 4){
              $formaPago          = substr($decodedData1[$i], 13, -1);    
              
              $resultado = $this->Internomex_model->formaDePago($formaPago); 

              $FormaPagos = array ("forma_pago" => $resultado->id_opcion );
            
            }else if($flag == 5){ 
              $rfc                = substr($decodedData1[$i], 7, -1);    
            }else if($flag == 6){
              $nacionalidad       = substr($decodedData1[$i], 16, -1);    
            }else if($flag == 7){
            
              $montoSinDescuento  = substr($decodedData1[$i], 21, -1);    
              $infos2SinDescuento = array ("monto_sin_descuento" => $montoSinDescuento );
            }else if($flag == 8){
              $montoConDescuento  = substr($decodedData1[$i], 25, -1);    
              $infos3MontoConDescuento = array ("monto_con_descuento" => $montoConDescuento );
            }else if($flag == 9){
              $montoFinal         = substr($decodedData1[$i], 13, -2);
              $infos4MontoFinal = array ("monto_internomex" => $montoFinal );
              $flag   = 0 ;
              $bande  = false;
              $insertAuditoriaData ;

              $dataReal = array_merge($insertAuditoriaData,$infos2SinDescuento,$infos3MontoConDescuento,$infos4MontoFinal, $FormaPagos, $infoIdUser);
              
              //echo json_encode($infoIdUser);
              //$data =  $this->Internomex_model->existeUserPorMes($infoIdUsers);
              
              if($this->Internomex_model->existeUserPorMes($clave)){
                $UserYaAgregados[$i] = $infoIdUser;
              }else{
                // $this->db->insert_batch('pagos_internomex',$dataReal);
               $this->Internomex_model->insertMontoFinalPago($dataReal);
              } 
            }//fin del if 9
            if ($bande){ $flag ++;} //bandera if
          }//fin ciclo
          //$claves,$mes,$fecha
          //$usuarios = $this->Internomex_model->getuser($hoy );
        
          if (count($dataReal) > 0){
            
          }else
          {
            echo json_encode(array("status" => 500, "message" => "Alguno de los registros no tiene un valor establecido."), JSON_UNESCAPED_UNICODE);
          }
       }
      }
    }
 }






}
