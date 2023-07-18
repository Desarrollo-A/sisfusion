<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class PaquetesCorrida extends CI_Controller
{
    public $id_rol = FALSE;
    public function __construct()
    {
      parent::__construct();
      $this->load->model(array('PaquetesCorrida_model', 'asesor/Asesor_model', 'General_model'));
      $this->load->library(array('session', 'form_validation', 'get_menu'));
      $this->load->helper(array('url', 'form'));
      $this->load->database('default');
      $this->programacion = $this->load->database('default', TRUE);
      $this->id_rol = $this->session->userdata('id_rol');

      $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
      $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }


    public function validateSession()
    {
      if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
        redirect(base_url() . "index.php/login");
    }
 
    public function Planes()
    {
      $this->load->view('template/header');
      $this->load->view("ventas/Planes");
    }
    function getResidencialesList($id_sede)
    {
      $data = $this->PaquetesCorrida_model->getResidencialesList($id_sede);
      if ($data != null)
        echo json_encode($data);
      else
        echo json_encode(array());
    }
  
    function getTipoDescuento()
    {
      $data = $this->PaquetesCorrida_model->getTipoDescuento();
      if ($data != null)
        echo json_encode($data);
      else
        echo json_encode(array());
    }


    public function SavePaquete()
    {
        $this->db->trans_begin();
        $index = $this->input->post("index");
        $accion = $this->input->post("accion");
        $datos_sede = $this->input->post("sede");
        $residenciales = $this->input->post("residencial[]");
        $superficie = $this->input->post("superficie");
        $idAutorizacion = $this->input->post("idSolicitudAut");
        $inicio = 0;
        $fin = 0;
        $query_superdicie = '';
        $query_tipo_lote = '';
        //Superficie
        /**
         * 1.-Mayor a
         * 2.-Rango
         * 3.-Cualquiera
         */
        if ($superficie == 1) { //Menor a 200
            $query_superdicie = 'and sup < 200 ';
        } else if ($superficie == 2) { // Mayor a 200
            $query_superdicie = 'and sup >= 200 ';
            $inicio =0;
            $fin = 0;
        } else if ($superficie == 3) { // Cualquiera
            $query_superdicie = '';
            $inicio = 0;
            $fin = 0;
        }
        $Fechainicio =  $this->input->post("fechainicio");
        $Fechafin = $this->input->post("fechafin");
        /*Tipo lote
        1.-Habitacional
        2.-Comercial
        3.-Ambos*/
        $ArrPAquetes = array();
        $TipoLote = $this->input->post("tipoLote");
        if ($TipoLote == 0) { //Habitacional
            $query_tipo_lote = 'and c.tipo_lote = 0 ';
        } else if ($TipoLote == 1) { // Comercial
            $query_tipo_lote = 'and c.tipo_lote = 1 ';
        } else if ($TipoLote == 2) { // Ambos
            $query_tipo_lote = '';
        }

        $datosInsertar = array();
        date_default_timezone_set('America/Mexico_City');
        $hoy2 = date('Y-m-d H:i:s');
        $desarrollos = implode(",", $residenciales);

        for ($i = 1; $i <= $index; $i++) {
            //VALIDAR SI EXISTE PAQUETE EN EL FORM
            if (isset($_POST["descripcion_" . $i])) {
                $descripcion_paquete = $_POST["descripcion_" . $i];
                $this->db->query("INSERT INTO paquetes(descripcion,id_descuento,fecha_inicio,fecha_fin,estatus,sede,desarrollos,tipo_lote,super1,super2) VALUES('$descripcion_paquete',0,'$Fechainicio','$Fechafin',1,'" . $datos_sede . "','$desarrollos',$TipoLote,$inicio,$fin) ");
                $id_paquete = $this->db->insert_id();
                array_push($ArrPAquetes, $id_paquete);
                //1.- DESCUENTO AL TOTAL
                if (isset($_POST[$i . "_0_ListaDescuentosTotal_"])) {
                    $descuentos = $_POST[$i . "_0_ListaDescuentosTotal_"];

                    for ($j = 0; $j < count($descuentos); $j++) {
                        $data_descuento = array(
                            'id_paquete' => $id_paquete,
                            'id_descuento' => $descuentos[$j],
                            'prioridad' => $j + 1,
                            'msi_descuento' => 0,
                            'fecha_creacion' => $hoy2,
                            'creado_por' => $this->session->userdata('id_usuario'),
                            'fecha_modificacion' => $hoy2,
                            'modificado_por' => $this->session->userdata('id_usuario'),
                        );
                        array_push($datosInsertar, $data_descuento);
                    }
                }
                if (isset($_POST[$i . "_1_ListaDescuentosEnganche_"])) {
                    $descuentos = $_POST[$i . "_1_ListaDescuentosEnganche_"];
                    for ($j = 0; $j < count($descuentos); $j++) {
                        $data_descuento = array(
                            'id_paquete' => $id_paquete,
                            'id_descuento' => $descuentos[$j],
                            'prioridad' => $j + 1,
                            'msi_descuento' => 0,
                            'fecha_creacion' => $hoy2,
                            'creado_por' => $this->session->userdata('id_usuario'),
                            'fecha_modificacion' => $hoy2,
                            'modificado_por' => $this->session->userdata('id_usuario'),
                        );
                        array_push($datosInsertar, $data_descuento);
                    }
                }
                if (isset($_POST[$i . "_2_ListaDescuentosEfectivoporm_"])) {
                    $descuentos = $_POST[$i . "_2_ListaDescuentosEfectivoporm_"];
                    for ($j = 0; $j < count($descuentos); $j++) {
                        $data_descuento = array(
                            'id_paquete' => $id_paquete,
                            'id_descuento' => $descuentos[$j],
                            'prioridad' => $j + 1,
                            'msi_descuento' => 0,
                            'fecha_creacion' => $hoy2,
                            'creado_por' => $this->session->userdata('id_usuario'),
                            'fecha_modificacion' => $hoy2,
                            'modificado_por' => $this->session->userdata('id_usuario'),
                        );
                        array_push($datosInsertar, $data_descuento);
                    }
                }
                if (isset($_POST[$i . "_3_ListaDescuentosBono_"])) {
                    $descuentos = $_POST[$i . "_3_ListaDescuentosBono_"];
                    for ($j = 0; $j < count($descuentos); $j++) {
                        $data_descuento = array(
                            'id_paquete' => $id_paquete,
                            'id_descuento' => $descuentos[$j],
                            'prioridad' => $j + 1,
                            'msi_descuento' => 0,
                            'fecha_creacion' => $hoy2,
                            'creado_por' => $this->session->userdata('id_usuario'),
                            'fecha_modificacion' => $hoy2,
                            'modificado_por' => $this->session->userdata('id_usuario'),
                        );
                        array_push($datosInsertar, $data_descuento);
                    }
                }
                if (isset($_POST[$i . "_4_ListaDescuentosMSI_"])) {
                    $descuentos = $_POST[$i . "_4_ListaDescuentosMSI_"];
                    for ($j = 0; $j < count($descuentos); $j++) {
                        $datos = explode(",", $descuentos[$j]);
                        $meses_s_i = 0;
                        $data_descuento = array(
                            'id_paquete' => $id_paquete,
                            'id_descuento' => $datos[0],
                            'prioridad' => $j + 1,
                            'msi_descuento' => $datos[1],
                            'fecha_creacion' => $hoy2,
                            'creado_por' => $this->session->userdata('id_usuario'),
                            'fecha_modificacion' => $hoy2,
                            'modificado_por' => $this->session->userdata('id_usuario'),
                        );
                        array_push($datosInsertar, $data_descuento);
                    }
                }
                //2.- DESCUENTO AL ENGANCHE
                //3.- DESCUENTO POR M2
                //4.- DESCUENTO POR BONO
            }
        }
        $this->PaquetesCorrida_model->insertBatch('relaciones', $datosInsertar);
        $cadena_lotes = implode(",", $ArrPAquetes);
        $datosInsertar_x_condominio = array();
        $getPaquetesByLotes = $this->PaquetesCorrida_model->getPaquetesByLotes($desarrollos, $query_superdicie, $query_tipo_lote, $superficie, $inicio, $fin);
        $user_sesionado = $this->session->userdata('id_usuario');
        //ESTE INSERT ES EL QUE SE HACIA ANTERIORMENTE, AUN NO SE ELIMINA YA SE OCUPARA PARA EL
        $dataInsertAutPventas = array(
          "idResidencial" => $desarrollos,
          "fecha_inicio" => $Fechainicio,
          "fecha_fin" => $Fechafin,
          "id_sede" => $datos_sede[0],
          "tipo_lote" => $TipoLote,
          "superficie" => $superficie,
          "paquetes" => $cadena_lotes,
          "estatus_autorizacion" => 1,
          "estatus" => 1,
          "fecha_creacion" => $hoy2,
          "creado_por" => $user_sesionado,
          "fecha_modificacion" => $hoy2,
           "modificado_por" => $user_sesionado,
           "accion" => $accion,
           "idAutorizacion" => $idAutorizacion
        );
         $this->PaquetesCorrida_model->saveAutorizacion($dataInsertAutPventas);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            echo json_encode(0);

        } else {
            $this->db->trans_commit();
            echo json_encode(1);
        }

    }
  public function lista_sedes()
  {
    echo json_encode($this->PaquetesCorrida_model->get_lista_sedes()->result_array());
  }
  public function getDescuentosPorTotal()
  {
    $id_condicion = $this->input->post("id_condicion");
    echo json_encode($this->PaquetesCorrida_model->getDescuentosPorTotal($id_condicion)->result_array(), JSON_NUMERIC_CHECK);
  }

  public function getDescuentosYCondiciones(){
    $tipoCondicion = $this->input->post("tipoCondicion");
    echo json_encode($this->PaquetesCorrida_model->getDescuentosYCondiciones($tipoCondicion),JSON_NUMERIC_CHECK);
  }

  public function SaveNewDescuento(){
    $id_condicion = $this->input->post("id_condicion");
    $descuento = $this->input->post("descuento");

    if ($this->input->post("id_condicion") == 4 || $this->input->post("id_condicion") == 12) {
      $replace = ["$", ","];
      $descuento = str_replace($replace, "", $descuento);
    }
    
    $row = $this->PaquetesCorrida_model->ValidarDescuento($id_condicion, $descuento)->result_array();
    if (count($row) > 0) {
      echo(json_encode(array("status" => 403, "mensaje" => "El descuento ingresado, ya existe.", "color" => "warning"), JSON_UNESCAPED_UNICODE));
    } 
    else {
      $response = $this->PaquetesCorrida_model->SaveNewDescuento($id_condicion, $descuento);
      $lastRecords = $this->PaquetesCorrida_model->getDescuentosYCondiciones($id_condicion);
      
      echo(json_encode(array("status" => 402, "mensaje" => "Descuento almacenado correctamente", "detalle" => $lastRecords, "color" => "success"), JSON_UNESCAPED_UNICODE));
    }
  }

  public function getPaquetes()
  {
    $index = $this->input->post("index");
    $accion = $this->input->post("accion");
    $paquetes = $this->input->post("paquetes");
    $id_sede = $this->input->post("sede");  
    $residenciales = $this->input->post("residencial[]");
    $desarrollos = implode(",", $residenciales);
    $superficie = $this->input->post("superficie");
    /***/
    $inicio = 0;
    $fin = 0;
    $fechaInicio = $this->input->post("fechaInicio");
    $fechaFin = $this->input->post("fechaFin");
    $query_superdicie = '';
    $query_tipo_lote = '';
    //Superficie
    /**
     * 1.-Mayor a
     * 2.-Rango
     * 3.-Cualquiera
     */
    if ($superficie == 1) { //Mayor a
      $query_superdicie = 'and sup < 200 ';
    } else if ($superficie == 2) { // Menor a
     $query_superdicie = 'and sup >= 200 ';
    } else if ($superficie == 3) { // Cualquiera
      $query_superdicie = '';
    }

    /*
    Tipo lote
    0.-Habitacional
    1.-Comercial
    2.-AmbosPlanes
    */
    $ArrPAquetes = array();
    $TipoLote = $this->input->post("tipolote");
    if ($TipoLote == 0) { //Habitacional
      $query_tipo_lote = 'and c.tipo_lote = 0 ';
    } else if ($TipoLote == 1) { // Comercial
      $query_tipo_lote = 'and c.tipo_lote = 1 ';

    } else if ($TipoLote == 2) { // Ambos
      $query_tipo_lote = '';
    }

    $row = $accion == 1 ? $this->PaquetesCorrida_model->getPaquetes($query_tipo_lote, $query_superdicie, $desarrollos, $fechaInicio, $fechaFin) : array(array('id_paquete' => $paquetes)) ;

    $data = array();
    if (count($row) == 0) {

    } else if (count($row) == 1) {
      $dataPaquetes = $this->PaquetesCorrida_model->getPaquetesById($row[0]['id_paquete']);
      $dataDescuentos = $this->PaquetesCorrida_model->getDescuentosByPlan($row[0]['id_paquete']);
    } else if (count($row) > 1) {
      $data = $this->PaquetesCorrida_model->getPaquetesById($row[0]['id_paquete']);
    }
    echo json_encode(array(array("paquetes" => $dataPaquetes, "descuentos" => $dataDescuentos)));
  }

  public function getDescuentosByPlan()
  {
    $id_paquete = $this->input->post("id_paquete");
    $data = $this->PaquetesCorrida_model->getDescuentosByPlan($id_paquete);
    echo json_encode($data);
  }
  
  public function Autorizaciones()
    {
        if ($this->id_rol == FALSE) {
            redirect(base_url());
        }
        $this->load->view('template/header');
        $this->load->view("ventas/autorizacionesPVentas");
    }
    public function getAutorizaciones()
    {
      $opcion = $this->input->post("opcion");
      $anio = $this->input->post("anio");
      $estatus = $this->input->post("estatus");
      if($opcion == 1){
        echo json_encode(array("data" => $this->PaquetesCorrida_model->getAutorizaciones($this->id_rol)));
      }else {
        echo json_encode(array("data" => $this->PaquetesCorrida_model->getAutorizaciones($this->id_rol,$opcion,$anio,$estatus)));
      }
    }

    public function avanceAutorizacion(){ 
      $id_autorizacion = $this->input->post("id_autorizacion");
      $estatus = $this->input->post("estatus");
      $tipo = $this->input->post("tipo");
      $comentario = $tipo == 2 ? $this->input->post("comentario") : 0 ;
      echo json_encode($this->PaquetesCorrida_model->avanceAutorizacion($id_autorizacion,$estatus,$tipo,$comentario,$this->session->userdata('id_usuario')));
    }

    public function getHistorialAutorizacion(){
      $id_autorizacion = $this->input->post("id_autorizacion");
      echo json_encode($this->PaquetesCorrida_model->getHistorialAutorizacion($id_autorizacion));
    }
    public function getCatalogo(){
      $id_catalogo = $this->input->post("id_catalogo");
      echo json_encode($this->PaquetesCorrida_model->getCatalogo($id_catalogo));
    }
    public function paquetesView(){
     $row = array(array('id_paquete' => $this->input->post("paquetes")));
      $dataPaquetes = $this->PaquetesCorrida_model->getPaquetesById($row[0]['id_paquete']);
      $dataDescuentos = $this->PaquetesCorrida_model->getDescuentosByPlan($row[0]['id_paquete']);

      echo json_encode(array(array("paquetes" => $dataPaquetes,
      "descuentos" => $dataDescuentos)),JSON_NUMERIC_CHECK);
    }

}