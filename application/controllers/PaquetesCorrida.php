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
          $query_superdicie = 'and sup >= '.$fin.' ';
        }else if($superficie == 2){ // Menor a
          $query_superdicie = 'and sup < '.$fin.' ';
          $inicio = $this->input->post("fin");
          $fin = $this->input->post("inicio");

        }else if($superficie == 3){ // Cualquiera
          $query_superdicie = '';
          $inicio = 0;
          $fin = 0;
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
          $query_tipo_lote = 'and c.tipo_lote = 0 ';
        }else if($TipoLote == 2){ // Comercial
          $query_tipo_lote = 'and c.tipo_lote = 1 ';

        }else if($TipoLote == 3){ // Ambos
          $query_tipo_lote = '';
        }
        $datosInsertar = array();
        date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d');
        $hoy2 = date('Y-m-d H:i:s');
        $desarrollos = implode(",",$residenciales);
        

        for ($i=1; $i <= $index ; $i++){ 
            //VALIDAR SI EXISTE PAQUETE EN EL FORM
            if(isset($_POST["descripcion_".$i])){
              $descripcion_paquete = $_POST["descripcion_".$i];
              $query_paquete = $this->db->query("INSERT INTO paquetes(descripcion,id_descuento,fecha_inicio,fecha_fin,estatus,sede,desarrollos,tipo_lote,super1,super2) VALUES('$descripcion_paquete',0,'$Fechainicio','$Fechafin',1,'".$datos_sede[1]."','$desarrollos',$TipoLote,$inicio,$fin) ");
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
                        $msi = $descuentos[$j] . ',' . $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
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
                    }
                  }
                  if(isset($_POST[$i."_1_ListaDescuentosEnganche_"])){
                    $descuentos = $_POST[$i."_1_ListaDescuentosEnganche_"];
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      $meses_s_i=0;
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                        $msi = $descuentos[$j] . ',' . $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
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
                    }
                  }
                  if(isset($_POST[$i."_2_ListaDescuentosM2_"])){
                    $descuentos = $_POST[$i."_2_ListaDescuentosM2_"];
                     
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                        $meses_s_i=0;
                        $msi = $descuentos[$j] . ',' . $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
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
                    }
                  }
                  if(isset($_POST[$i."_3_ListaDescuentosBono_"])){
                    $descuentos = $_POST[$i."_3_ListaDescuentosBono_"];
                    for ($j=0; $j < count($descuentos) ; $j++) { 
                      $meses_s_i=0;
                      if(isset($_POST[$i.'_'.$descuentos[$j].'_msi'])){
                        $msi = $descuentos[$j] . ',' . $_POST[$i.'_'.$descuentos[$j].'_msi'];
                        $msi = explode(",",$msi);
                        $meses_s_i = $msi[1];
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
                    }
                  }
                  if(isset($_POST[$i."_4_ListaDescuentosMSI_"])){
                    $descuentos = $_POST[$i."_4_ListaDescuentosMSI_"];
                    for ($j=0; $j < count($descuentos) ; $j++){ 
                      $datos =explode(",",$descuentos[$j]);
                      $meses_s_i=0;
                      
                      $data_descuento=array(
                        'id_paquete' => $id_paquete,
                        'id_descuento' =>  $datos[0],
                        'prioridad' => $j +1,
                        'msi_descuento' => $datos[1],
                        'fecha_creacion' =>  $hoy2,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'fecha_modificacion' =>  $hoy2,
                        'modificado_por' => $this->session->userdata('id_usuario'),
                      );
                       array_push($datosInsertar,$data_descuento);
                    }
                   // echo "<br>";
                  }
                //2.- DESCUENTO AL ENGANCHE
                //3.- DESCUENTO POR M2
                //4.- DESCUENTO POR BONO
            }
        }
         $this->PaquetesCorrida_model->insertBatch('relaciones',$datosInsertar);
        $cadena_lotes = implode(",", $ArrPAquetes);
        $datosInsertar_x_condominio = array();
        $getPaquetesByLotes = $this->PaquetesCorrida_model->getPaquetesByLotes($desarrollos,$query_superdicie,$query_tipo_lote,$superficie,$inicio,$fin);
        
         $this->PaquetesCorrida_model->UpdateLotes($desarrollos,$cadena_lotes,$query_superdicie,$query_tipo_lote,$this->session->userdata('id_usuario'),$inicio,$fin);

      
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
      echo json_encode($this->PaquetesCorrida_model->getDescuentosPorTotal($tdescuento,$id_condicion,$eng_top,$apply)->result_array(),JSON_NUMERIC_CHECK);
    }
    public function getDescuentos($tdescuento,$id_condicion,$eng_top,$apply)
    {
      echo json_encode(array( "data" => $this->PaquetesCorrida_model->getDescuentos($tdescuento,$id_condicion,$eng_top,$apply)->result_array()));
    }
    public function SaveNewDescuento(){
          $tdescuento=$this->input->post("tdescuento");
          $id_condicion=$this->input->post("id_condicion");
          $eng_top=$this->input->post("eng_top");
          $apply=$this->input->post("apply");
          $descuento=$this->input->post("descuento"); 
          if($this->input->post("tipo_d") == 4 || $this->input->post("tipo_d") == 12){
             $replace = ["$", ","];
            $descuento = str_replace($replace,"",$descuento);
           }
          $row = $this->PaquetesCorrida_model->ValidarDescuento($tdescuento,$id_condicion,$eng_top,$apply,$descuento)->result_array();
          if(count($row) > 0){
            echo json_encode(2);
          }else{
            echo json_encode($response = $this->PaquetesCorrida_model->SaveNewDescuento($tdescuento,$id_condicion,$eng_top,$apply,$descuento));
          }
    }


    public function listaDescuentos() {
      date_default_timezone_set('America/Mexico_City');
      $cuari1 =  $this->db->query("SELECT DISTINCT(ISNULL(id_descuento, 0)) paquetes FROM lotes")->result_array();
      $stack= array();
        
      for ($i=0; $i < sizeof($cuari1); $i++) {
        $queryRes =  $this->db->query("SELECT r.nombreResidencial, 
        (CASE 
        WHEN p.super1 = '0' AND p.super2 = '0' THEN 'Cualquiera'
        WHEN p.super1 = '0' AND p.super2 != '0' THEN concat('Mayor igual a ',p.super2 )
        WHEN p.super1 != '0' AND p.super2 = '0' THEN concat('Menor a ',p.super2 )
        ELSE 'NA' END) superficie,   
        (CASE 
        WHEN p.super1 = 0 AND p.super2 = 0 THEN '#2874A6'
        WHEN p.super1 = 0 AND p.super2 != 0 THEN '#3498DB'
        WHEN p.super1 != 0 AND p.super2 = 0 THEN '#85C1E9'
        ELSE 'blue'
        END) color_superficie,
        (CASE 
        WHEN p.tipo_lote = 1 THEN 'HABITACIONAL'
        WHEN p.tipo_lote = 2 THEN 'COMERCIAL'
        WHEN p.tipo_lote = 3 THEN 'AMBOS'
        ELSE '-'
        END) tipo_lote,
        p.descripcion, 
        (CASE 
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 1 AND d.eng_top = 0 AND d.apply = 1 THEN 'TOTAL DE LOTE'
        WHEN d.id_tdescuento = 2 AND d.id_condicion = 2 AND d.eng_top = 0 AND d.apply = 0 THEN 'ENGANCHE'
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 4 AND d.eng_top = 0 AND d.apply = 1 THEN 'M2'
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 12 AND d.eng_top = 1 AND d.apply = 1 THEN 'BONO'
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 13 AND d.eng_top = 1 AND d.apply = 1 THEN 'MSI'
        END) tipo, 
        (CASE 
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 1 AND d.eng_top = 0 AND d.apply = 1 THEN 1
        WHEN d.id_tdescuento = 2 AND d.id_condicion = 2 AND d.eng_top = 0 AND d.apply = 0 THEN 2
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 4 AND d.eng_top = 0 AND d.apply = 1 THEN 3
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 12 AND d.eng_top = 1 AND d.apply = 1 THEN 4
        WHEN d.id_tdescuento = 1 AND d.id_condicion = 13 AND d.eng_top = 1 AND d.apply = 1 THEN 5
        END) tipo_check,
        (CASE 
        WHEN d.id_condicion = 13 THEN rl.msi_descuento ELSE d.porcentaje END) porcentaje, rl.msi_descuento, 
        (CASE 
        WHEN d.id_condicion != 13 AND rl.msi_descuento NOT IN (0) THEN rl.msi_descuento ELSE 0 END) msi_extra,
        CONVERT(varchar, p.fecha_inicio, 3) fecha_inicio, CONVERT(varchar, p.fecha_fin, 3) fecha_fin
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial 
        INNER JOIN paquetes p ON p.id_paquete IN (".$cuari1[$i]['paquetes'].") AND l.id_descuento = '".$cuari1[$i]['paquetes']."'
        INNER JOIN relaciones rl ON rl.id_paquete = p.id_paquete
        INNER JOIN descuentos d ON d.id_descuento = rl.id_descuento
        WHERE l.id_descuento is not null --AND p.tipo_lote IS NOT NULL
        GROUP BY r.nombreResidencial, p.descripcion, p.super1, p.super2, d.id_tdescuento,
        d.id_condicion, d.eng_top, d.apply, rl.msi_descuento, d.porcentaje, p.tipo_lote, CONVERT(varchar, p.fecha_inicio, 3), CONVERT(varchar, p.fecha_fin, 3)");
      
        foreach ($queryRes->result() as  $valor) {
           array_push($stack, array(
            'nombreResidencial'=>$valor->nombreResidencial, 
            // 'nombre_condominio'=>$valor->nombre_condominio, 
            'superficie'=>$valor->superficie, 
            'descripcion'=>$valor->descripcion, 
            'tipo'=>$valor->tipo, 
            'porcentaje'=>$valor->porcentaje, 
            'msi_descuento'=>$valor->msi_descuento, 
            'color_superficie'=>$valor->color_superficie, 
            'tipo_lote'=>$valor->tipo_lote, 
            'tipo_check'=>$valor->tipo_check, 
            'msi_extra'=>$valor->msi_extra,
            'fecha_inicio'=>$valor->fecha_inicio,
            'fecha_fin'=>$valor->fecha_fin
          ));
        }
      }
      echo json_encode(array("data"=>$stack));
    }

public function getPaquetes(){
  $index = $this->input->post("index");
  $datos_sede = explode(",",$this->input->post("sede"));
  $id_sede = $datos_sede[0];
  $residenciales = $this->input->post("residencial[]");
  $desarrollos = implode(",",$residenciales);
  $superficie = $this->input->post("superficie");
  /***/
  $inicio = $this->input->post("inicio");
  $fin = $this->input->post("fin");
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
  if($superficie == 1){ //Mayor a
    $query_superdicie = 'and sup >= '.$fin.' ';
  }else if($superficie == 2){ // Menor a
    $query_superdicie = 'and sup < '.$fin.' ';
  }else if($superficie == 3){ // Cualquiera
    $query_superdicie = '';
  }

  /*
  Tipo lote
  1.-Habitacional
  2.-Comercial
  3.-AmbosPlanes
  */  
  $ArrPAquetes = array();
  $TipoLote = $this->input->post("tipoLote");
  if($TipoLote == 1){ //Habitacional
    $query_tipo_lote = 'and c.tipo_lote = 0 ';
  }else if($TipoLote == 2){ // Comercial
    $query_tipo_lote = 'and c.tipo_lote = 1 ';

  }else if($TipoLote == 3){ // Ambos
    $query_tipo_lote = '';
  }

 $row = $this->PaquetesCorrida_model->getPaquetes($query_tipo_lote, $query_superdicie, $desarrollos, $fechaInicio, $fechaFin);

 $data = array();
 if(count($row) == 0){

 }else if(count($row) == 1){
  $data = $this->PaquetesCorrida_model->getPaquetesById($row[0]['id_descuento']);
 }else if(count($row) > 1 ){
  $data = $this->PaquetesCorrida_model->getPaquetesById($row[0]['id_descuento']);
 }
 echo json_encode(array(array("paquetes"=>$data)));
}

public function getDescuentosByPlan(){
 $id_paquete =  $this->input->post("id_paquete");
 $id_tcondicion =  $this->input->post("id_tcondicion");
 $data = $this->PaquetesCorrida_model->getDescuentosByPlan($id_paquete,$id_tcondicion);
 echo json_encode($data);
}

 
}

