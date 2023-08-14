<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once './dist/js/jwt/JWT.php';

use Firebase\JWT\JWT;

class ServicesCRM extends CI_Controller
{

    public function __construct()
    {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Content-Type,Origin, authorization, X-API-KEY,X-Requested-With,Accept,Access-Control-Request-Method');
            header('Access-Control-Allow-Method: GET, POST, PUT, DELETE,OPTION');
            parent::__construct();
            $urls = array('https://prueba.gphsis.com','prueba.gphsis.com','localhost','http://localhost','127.0.0.1','https://rh.gphsis.com','rh.gphsis.com','https://maderascrm.gphsis.com','maderascrm.gphsis.com');
            date_default_timezone_set('America/Mexico_City');
            
           //print_r(getallheaders()['Authorization']);
           // $header = getallheaders();
           // echo $header['Authorization'];

            //echo $_SERVER['HTTP_ORIGIN'];
            if(isset($this->input->request_headers()['origin'])){
                $origin = $this->input->request_headers()['origin'];
            }else if(array_key_exists('HTTP_ORIGIN',$_SERVER)){
                $origin = $_SERVER['HTTP_ORIGIN'];
            }else if(array_key_exists('HTTP_PREFERER',$_SERVER)){
                $origin = $_SERVER['HTTP_PREFERER'];
            }
            else{
                $origin = $_SERVER['HTTP_HOST'];
            }
            if(in_array($origin,$urls) || strpos($origin,"192.168")){
            $this->load->helper(array('form'));
            $this->load->library(array('jwt_key','formatter'));
            $this->load->model(array('Services_model', 'General_model'));
            }else{
                die ("Access Denied");     
                exit;  
            }
    }

    function getSubdirectores(){
        $data = $this->Services_model->getSubdirectores();
       echo base64_encode(json_encode($data));
    }
    function getNacionalidades(){
        $data = $this->Services_model->getNacionalidades();
       echo base64_encode(json_encode($data));
    }

    function codificarTest(){
        $miJson = array(
            "rfc"=>"HGDE350247FF5",
            "id_rol"=> 9,
            "id_lider"=>692,
            "id_gerente" => 456,
            "id_subdirector" => 789,
            "id_regional" => 321,
            "nombre" => "Nombre Fulanito",
            "apellido_paterno" => "Gómez",
            "apellido_materno" => "Perez",
            "forma_pago" => 2,
            "correo" => "garmar@gmail.com",
            "telefono" => 442210616,
            "id_sede" => 4,
            "usuario" => "tedigo" ,
            "contrasena" => "123456",
            "creado_por" => 5,
            "sedech" => 1,
            "sucursalch" => 1,
            "status_contratacion" => 1,
            "nacionalidad" => 0

        ) ;
        $ok1 = json_encode($miJson);
        $ok2 = utf8_decode($ok1);
        print_r(base64_encode($ok2));


    }
    public function saveUserCH()
    {
            $objDatos = json_decode(utf8_encode(base64_decode(file_get_contents("php://input"))), true);
            $getRFC = $this->Services_model->getRFC($objDatos['rfc']);
           
            if(count($getRFC) > 0 ){
                echo base64_encode(json_encode(array("result" => false,
                                       "message" => "El RFC ingresado ya se encuentra registrado.")));
    
            }else{
                
                if($objDatos['id_rol'] != 3){
                    $getLider = $this->Services_model->getLider($objDatos['id_lider'],$objDatos['id_rol']);
                }               
                $id_gerente=0;
                $id_subdirector=0;
                $id_regional=0;
                $id_lider=0;
                if($objDatos['id_rol'] == 7){
                    //Asesor
                    $id_lider  = $objDatos['id_lider'];
                    $id_gerente=$getLider[0]['id_gerente'];
                    $id_subdirector=$getLider[0]['id_subdirector'];
                    $id_regional=$getLider[0]['id_regional'];
                }
                else if($objDatos['id_rol'] == 9){
                    //Coordinador
                    $id_lider  = $objDatos['id_lider'];
                    $id_gerente=$objDatos['id_lider'];
                    $id_subdirector=$getLider[0]['id_subdirector'];
                    $id_regional=$getLider[0]['id_regional'];
                }
                else if($objDatos['id_rol'] == 3){
                    //Gerente
                    $id_lider  = $objDatos['id_lider'];
                    $id_gerente=0;
                    $id_subdirector=0;//$getLider[0]['id_subdirector'];
                    $id_regional=0;//$getLider[0]['id_regional'];
                }

                $dataValidar = array(
                    "id_sede" => $objDatos['id_sede'],
                    "id_rol" => $objDatos['id_rol'],
                    "id_lider" => $id_lider,
                    "gerente_id" => $id_gerente,
                    "subdirector_id" => $id_subdirector,
                    "regional_id" => $id_regional,
                );
                $validacion = validateUserVts($dataValidar);
                if($validacion['respuesta']==1){
                    //continuar con la lógica
                }else{
                    echo base64_encode(json_encode(array("result" => false,
                        "code" => 0,
                        "message" => $validacion['mensaje'])));
                    exit;
                }


                $data = array(
                    "nombre" => $this->formatter->eliminar_tildes(strtoupper(trim($objDatos['nombre']))),
                    "apellido_paterno" => $this->formatter->eliminar_tildes(strtoupper(trim($objDatos['apellido_paterno']))),
                    "apellido_materno" =>$this->formatter->eliminar_tildes(strtoupper(trim($objDatos['apellido_materno']))),
                    "forma_pago" => $objDatos['forma_pago'],
                    "rfc" => $this->formatter->eliminar_tildes(strtoupper(trim($objDatos['rfc']))),
                    "estatus" => 1,
                    "sesion_activa" => 1,
                    "imagen_perfil" => '',
                    "correo" => $this->formatter->eliminar_tildes(strtoupper(trim($objDatos['correo']))),
                    "telefono" => trim($objDatos['telefono']),
                    "id_sede" => $objDatos['id_sede'],
                    "id_rol" => $objDatos['id_rol'],
                    "id_lider" => $id_lider,
                    "usuario" => trim($objDatos['usuario']),
                    "contrasena" => encriptar(trim($objDatos['contrasena'])),
                    "fecha_creacion" => date("Y-m-d H:i:s"),
                    "creado_por" => $objDatos['creado_por'],
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $objDatos['creado_por'],
                    "sedech" => $objDatos['sedech'],
                    "sucursalch" => $objDatos['sucursalch'],
                    "status_contratacion" => $objDatos['status_contratacion'],
                    "nacionalidad" => $objDatos['nacionalidad'],
                    "gerente_id" => $id_gerente,
                    "subdirector_id" => $id_subdirector,
                    "regional_id" => $id_regional,
                    "talla" => "0",
                    "sexo" => "S",
                    "tiene_hijos" => "NO",
                    "hijos_12" => "0",
                    "fecha_reingreso" => NULL,
                    "fecha_baja" => NULL 
                );
                //echo var_dump($data);
                if (isset($objDatos) && !empty($objDatos)) {
                    $response = $this->Services_model->saveUserCH($data);
                        if($response == 1){
                        echo base64_encode(json_encode(array("result" => $response,
                        "message" => "Ok")));
                        }else{
                        echo base64_encode(json_encode($response));
                        }    
                }
            }
        
        
    }

 

}
