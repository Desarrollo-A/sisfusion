<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PaquetesCorrida extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('PaquetesCorrida_model', 'asesor/Asesor_model','General_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->programacion = $this->load->database('default', TRUE);
        //$this->validateSession();
    }

    public function index()
    {
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
            redirect(base_url() . "index.php/login");
    }

    public function Planes()
    { 

      $datos = array();
      $datos["datos2"] = $this->Asesor_model->getMenu($this->session->userdata('id_rol'))->result();
      $datos["datos3"] = $this->Asesor_model->getMenuHijos($this->session->userdata('id_rol'))->result();
      $val = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
      $salida = str_replace('' . base_url() . '', '', $val);
      $datos["datos4"] = $this->Asesor_model->getActiveBtn($salida, $this->session->userdata('id_rol'))->result();
      $this->load->view('template/header');
      $this->load->view("ventas/Planes", $datos);
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
     //echo $this->input->post("pago");
        $index = $this->input->post("index");
        $datos_sede = explode(",",$this->input->post("sede"));
        $id_sede = $datos_sede[0];
        $residenciales = $this->input->post("residencial[]");
        $superficie = $this->input->post("superficie");
        /***/
        $inicio = $this->input->post("inicio");
        $fin = $this->input->post("fin");
        $query_superdicie = '';
        $query_tipo_lote = '';
        //Superficie
        /**
         * 1.-Mayor a
         * 2.-Rango
         * 3.-Cualquiera
         */
        if($superficie == 1){ //Mayor a
          $query_superdicie = 'and sup >= 200 ';
        }else if($superficie == 2){ // Rango
          $query_superdicie = 'and (sup >= 100 and sup <= 199) ';

        }else if($superficie == 3){ // Cualquiera
          $query_superdicie = '';
        }
        $Fechainicio = $this->input->post("fechainicio");
        $Fechafin = $this->input->post("fechafin");
        /*
        Tipo lote
        1.-Habitacional
        2.-Comercial
        3.-Ambos
        */ 
        $ArrPAquetes = array();
        $TipoLote = $this->input->post("tipoLote");
        if($TipoLote == 1){ //Habitacional
          $query_tipo_lote = 'and c.tipo_lote = 1 ';
        }else if($TipoLote == 2){ // Comercial
          $query_tipo_lote = 'and c.tipo_lote = 0 ';

        }else if($TipoLote == 3){ // Ambos
          $query_tipo_lote = '';
        }
        $datosInsertar = array();
        date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d');
        $hoy2 = date('Y-m-d H:i:s');
        for ($i=1; $i <= $index ; $i++){ 
            //VALIDAR SI EXISTE PAQUETE EN EL FORM
            if(isset($_POST["descripcion_".$i])){
              $descripcion_paquete = $_POST["descripcion_".$i];
              $indice = $i.'.-';
              $query_paquete = $this->db->query("INSERT INTO paquetes(descripcion,id_descuento,fecha_inicio,fecha_fin,estatus,sede) VALUES('$indice $descripcion_paquete',0,'$Fechainicio','$Fechafin',1,'".$datos_sede[1]."') ");
              $id_paquete = $this->db->insert_id();
              array_push($ArrPAquetes,$id_paquete);
               // echo $_POST["descripcion_".$i];
              //  echo "<br>";
                //1.- DESCUENTO AL TOTAL
                  if(isset($_POST[$i."_0_ListaDescuentosTotal_"])){
                   // print_r($_POST[$i."_0_ListaDescuentosTotal_"]);
                   // echo "<br>";
                    $descuentos = $_POST[$i."_0_ListaDescuentosTotal_"];
                    
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      $meses_s_i=0;
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                        $msi = $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
                       //  echo "<br>";
                      }
                     // echo "_______________ <br>";
                     // echo $descuentos[$j];
                     // echo "_______________ <br>";

                      $data_descuento=array(
                        'id_paquete' => $id_paquete,
                        'id_descuento' =>  $descuentos[$j],
                        'prioridad' => $j +1,
                        'msi_descuento' => $meses_s_i,
                        'fecha_creacion' =>  $hoy2,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'fecha_modificacion' =>  $hoy2,
                        'modificado_por' => $this->session->userdata('id_usuario'),
                      );
                       array_push($datosInsertar,$data_descuento);
                     // echo $descuentos[$j];
                    }
                  }
                  if(isset($_POST[$i."_1_ListaDescuentosEnganche_"])){
                  //  print_r($_POST[$i."_1_ListaDescuentosEnganche_"]);
                    $descuentos = $_POST[$i."_1_ListaDescuentosEnganche_"];
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      $meses_s_i=0;
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                      //  echo $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
                     //    echo "<br>";
                      }
                      $data_descuento=array(
                        'id_paquete' => $id_paquete,
                        'id_descuento' =>  $descuentos[$j],
                        'prioridad' => $j +1,
                        'msi_descuento' => $meses_s_i,
                        'fecha_creacion' =>  $hoy2,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'fecha_modificacion' =>  $hoy2,
                        'modificado_por' => $this->session->userdata('id_usuario'),
                      );
                       array_push($datosInsertar,$data_descuento);
                    //  echo $descuentos[$j];
                    }
                  //  echo "<br>";
                  }
                  if(isset($_POST[$i."_2_ListaDescuentosM2_"])){
                  //  print_r($_POST[$i."_2_ListaDescuentosM2_"]);
                    $descuentos = $_POST[$i."_2_ListaDescuentosM2_"];
                    
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                        $meses_s_i=0;
                      //  echo $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
                      //   echo "<br>";
                      }
                      $data_descuento=array(
                        'id_paquete' => $id_paquete,
                        'id_descuento' =>  $descuentos[$j],
                        'prioridad' => $j +1,
                        'msi_descuento' => $meses_s_i,
                        'fecha_creacion' =>  $hoy2,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'fecha_modificacion' =>  $hoy2,
                        'modificado_por' => $this->session->userdata('id_usuario'),
                      );
                       array_push($datosInsertar,$data_descuento);
                   //   echo $descuentos[$j];
                    }
                   // echo "<br>";
                  }
                  if(isset($_POST[$i."_3_ListaDescuentosBono_"])){
                    //print_r($_POST[$i."_3_ListaDescuentosBono_"]);
                    $descuentos = $_POST[$i."_3_ListaDescuentosBono_"];
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      $meses_s_i=0;
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                       // echo $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
                         //echo "<br>";
                      }
                      $data_descuento=array(
                        'id_paquete' => $id_paquete,
                        'id_descuento' =>  $descuentos[$j],
                        'prioridad' => $j +1,
                        'msi_descuento' => $meses_s_i,
                        'fecha_creacion' =>  $hoy2,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'fecha_modificacion' =>  $hoy2,
                        'modificado_por' => $this->session->userdata('id_usuario'),
                      );
                       array_push($datosInsertar,$data_descuento);
                     // echo $descuentos[$j];
                    }
                   // echo "<br>";
                  }
                //2.- DESCUENTO AL ENGANCHE
                //3.- DESCUENTO POR M2
                //4.- DESCUENTO POR BONO
            }
        }
        $ins_b = $this->PaquetesCorrida_model->insertBatch('relaciones',$datosInsertar);
        $cadena_lotes = implode(",", $ArrPAquetes);
        $desarrollos = implode(",",$residenciales);
       /* echo $cadena_lotes;
        echo "<br>";
        print_r($ArrPAquetes);
        print_r($datosInsertar);*/

         $this->PaquetesCorrida_model->UpdateLotes($desarrollos,$cadena_lotes,$query_superdicie,$query_tipo_lote,$this->session->userdata('id_usuario'));

      
        if ($this->db->trans_status() === FALSE) {
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
    $tdescuento=$this->input->post("tdescuento");
	$id_condicion=$this->input->post("id_condicion");
	$eng_top=$this->input->post("eng_top");
	$apply=$this->input->post("apply");
      echo json_encode($this->PaquetesCorrida_model->getDescuentosPorTotal($tdescuento,$id_condicion,$eng_top,$apply)->result_array());
    }

}

