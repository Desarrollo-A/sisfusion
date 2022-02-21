

 <?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Pagados_internomexMKTD extends REST_Controller {

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
      $URL_API_PANORAMIO = "http://35.192.127.0:8080/api/SolicitudMarketing";
      $contenido_url = $this->leer_contenido_completo($URL_API_PANORAMIO);

      $JSON_INTERNOMEX = json_decode($contenido_url);

      // echo 'DATA MARKETING '.count($JSON_INTERNOMEX);

      for ($i=0; $i<count($JSON_INTERNOMEX); $i++){
        $this->db->query("UPDATE pago_comision_mktd SET estatus = 11, descuento = ".$JSON_INTERNOMEX[$i]->descuento." WHERE id_usuario = ".$JSON_INTERNOMEX[$i]->id_usuario." AND estatus = 8");
      }

      $JSON_COM = $this->db->query("SELECT * FROM pago_comision_ind WHERE id_usuario = 4394 AND estatus = 8")->result_array();

      for ($i=0; $i<count($JSON_COM); $i++){
        $this->db->query("INSERT INTO historial_comisiones VALUES (".$JSON_COM[$i]['id_pago_i'].", 4918, GETDATE(), 1, 'INTERNOMEX APLICÓ EL PAGO')");
      }

      $this->db->query("UPDATE pago_comision_ind SET estatus = 11 WHERE id_usuario = 4394 AND estatus = 8");
    }
     
   

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