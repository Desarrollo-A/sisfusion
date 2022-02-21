

 <?php

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Pagados_internomex extends REST_Controller {

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
      $URL_API_PANORAMIO = "http://35.192.127.0:8080/api/SolicitudDeComisiones";
      $contenido_url = $this->leer_contenido_completo($URL_API_PANORAMIO);
      // echo $contenido_url;
      $JSON_INTERNOMEX = json_decode($contenido_url);

     print_r($JSON_INTERNOMEX);



   //    $data=array();

   //        foreach ($JSON_INTERNOMEX as $row) {

   //          $row_arr=array(
   //            'id_pago_i' =>  $row->idPago,
   //            'descuento' =>  $row->descuento
   //          );
   //           array_push($data,$row_arr);
   //        }


   //        var_dump($data);
   //        $this->db->insert_batch('api_binary', $data);

   // $this->response($data, REST_Controller::HTTP_OK);
   // echo $JSON_INTERNOMEX[$i]->idPago."<br>";

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