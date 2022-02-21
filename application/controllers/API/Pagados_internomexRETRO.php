

 <?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Pagados_internomexRETRO extends REST_Controller {

   /**
    * Get All Data from this method.
    *
    * @return Response
    */
   public function __construct() {
      parent::__construct();
      $this->load->database();
   }

   /**
    * Get All Data from this method.
    *
    * @return Response
    */
   public function index_get()
   {
          $query_vobo = $this->db->query("SELECT * FROM api_binary WHERE bandera = 0")->result_array();

    // var_dump($query_vobo);

 
      for ($i=0; $i<count($query_vobo); $i++){
        // echo $query_vobo[$i]['descuento'];
        // echo $query_vobo[$i]['id_pago_i'];

        $this->db->query("UPDATE pago_comision_ind SET estatus = 11, abono_final = ".$query_vobo[$i]['descuento'].", aply_pago_intmex = GETDATE() WHERE id_pago_i = ".$query_vobo[$i]['id_pago_i']." AND estatus = 1");
        $this->db->query("IF EXISTS(SELECT id_pago_i FROM pago_comision_ind WHERE id_pago_i = ".$query_vobo[$i]['id_pago_i']." AND estatus = 8) INSERT INTO historial_comisiones VALUES(".$query_vobo[$i]['id_pago_i'].", 4918, GETDATE(), 1, 'INTERNOMEX APLICÓ EL PAGO POR SISTEMA')");
        $this->db->query("UPDATE api_binary SET bandera = 1 WHERE id_pago_i = ".$query_vobo[$i]['id_pago_i']."");



      }

    // for ($i=0; $i<15; $i++){
    // for ($i=0; $i<count($JSON_INTERNOMEX); $i++){


      // $query_vobo 
      // echo $JSON_INTERNOMEX[$i]['descuento'].' <br>';
      // echo $query_vobo[$i]->row()->id_pago_i.' desceunto <br>';

        // $this->db->query("UPDATE pago_comision_ind SET estatus = 11, abono_final = ".$query_vobo[$i]['descuento'].", aply_pago_intmex = GETDATE() WHERE id_pago_i = ".$query_vobo[$i]['id_pago_i']." AND estatus = 8");
        // $this->db->query("IF EXISTS(SELECT id_pago_i FROM pago_comision_ind WHERE id_pago_i = ".$query_vobo[$i]['id_pago_i']." AND estatus = 8) INSERT INTO historial_comisiones VALUES(".$query_vobo[$i]['id_pago_i'].", 4918, GETDATE(), 1, 'INTERNOMEX APLICÓ EL PAGO POR SISTEMA')");
 
 

  // }
     

}


 


// echo 'cantidad'.count($array_pago);

   

   public function leer_contenido_completo($url){
   $fichero_url = fopen ($url, "r");
   $texto = "";
   while ($trozo = fgets($fichero_url, 1024)){
      $texto .= $trozo;
   }
   return $texto;
}


   /**
    * Get All Data from this method.
    *
    * @return Response
    */
  
   /**
    * Get All Data from this method.
    *
    * @return Response
    */
    
   /**
    * Get All Data from this method.
    *
    * @return Response
    */
   /*public function index_delete($id)
   {
      $this->db->delete('comisiones', array('id'=>$id));

      $this->response(['comisiones deleted successfully.'], REST_Controller::HTTP_OK);
   }*/
}