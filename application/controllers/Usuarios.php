<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);
class Usuarios extends CI_Controller
{
    public function __construct()
    {
		parent::__construct();
        $this->load->model(array('Usuarios_modelo'));
        $this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
        $this->load->model('Services_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
        $this->load->model('Clientes_model');
        //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
        $this->load->library(array('session','form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
        $this->load->library(array('session','form_validation','formatter'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        $this->jwt_actions->authorize('9472', $_SERVER['HTTP_HOST']);
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
	}

	public function index()
	{
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url() . 'login');
		}
	}

    public function configureProfile()
    {
        $data = $this->Usuarios_modelo->getPersonalInformation()->result();
        foreach ($data as $value) {
            $datos["id_usuario"] = $value->id_usuario;
            $datos["nombre"] = $value->nombre;
            $datos["apellido_paterno"] = $value->apellido_paterno;
            $datos["apellido_materno"] = $value->apellido_materno;
            $datos["correo"] = $value->correo;
            $datos["telefono"] = $value->telefono;
            $datos["rfc"] = $value->rfc;
            $datos["usuario"] = $value->usuario;
            $datos["contrasena"] = desencriptar($value->contrasena);
        }


    $datos["opn_cumplimiento"] = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();

        //var_dump($datos);
        $this->load->view('template/header');
        $this->load->view("usuarios/profile", $datos);
    }

    public function updatePersonalInformation()
    {
        $data = array(
            "contrasena" => encriptar($_POST['contrasena']),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        if (isset($_POST) && !empty($_POST)) {
            $response = $this->Usuarios_modelo->updatePersonalInformation($data, $this->input->post("id_usuario"));
            echo json_encode($response);
        }
    }

    public function saveUser()
    {
        $data = array(
            "nombre" => $_POST['name'],
            "apellido_paterno" => $_POST['last_name'],
            "apellido_materno" => $_POST['mothers_last_name'],
            "forma_pago" => $_POST['payment_method'],
            "rfc" => '',
            "tiene_hijos" => 2,
            "estatus" => 1,
            "sesion_activa" => 1,
            "imagen_perfil" => '',
            "correo" => $_POST['email'],
            "telefono" => $_POST['phone_number'],
            "id_sede" => $_POST['headquarter'],
            "id_rol" => $_POST['member_type'],
            "id_lider" => $_POST['leader'],
            "usuario" => $_POST['username'],
            "contrasena" => encriptar($_POST['contrasena']),
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );
        if (isset($_POST) && !empty($_POST)) {
            $response = $this->Usuarios_modelo->saveUser($data);
            echo json_encode($response);
        }
    }

    public function advisersList()
    {
        $this->load->view('template/header');
        $this->load->view("usuarios/advisers_list");
    }

    public function addUser()
    {
        $this->load->view('template/header');
        $this->load->view("usuarios/add_user");
    }

    public function usersList()
    {
        $this->load->view('template/header');
        $this->load->view("usuarios/users_list");
    }

    public function getUsersList()
    {
        $data['data'] = $this->Usuarios_modelo->getUsersList()->result_array();
        echo json_encode($data);
    }
    
    public function usersAsesor()
    {
        $this->load->view('template/header');
        $this->load->view("asesor/viewUser");   
    }

    public function getUsersListAsesor()
    {
        $data['data'] = $this->Usuarios_modelo->getUserPassword()->result_array();
        $data['data'][0]['contrasena'] = desencriptar($data['data'][0]['contrasena']);
        echo json_encode($data);
    }

    public function getPaymentMethod(){
                echo json_encode($this->Usuarios_modelo->getPaymentMethod()->result_array());
    }

    public function getMemberType()
    {
        echo json_encode($this->Usuarios_modelo->getMemberType()->result_array());
    }

    public function getHeadquarter()
    {
        echo json_encode($this->Usuarios_modelo->getHeadquarter()->result_array());
    }

    public function getLeadersList($headquarter, $type)
    {
        echo json_encode($this->Usuarios_modelo->getLeadersList($headquarter, $type)->result_array());
    }


    public function changeUserStatus()
    {
        date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d H:i:s');
        $url = 'https://rh.gphsis.com/index.php/WS/baja_asesor';
        if (isset($_POST) && !empty($_POST)) {
            if ($this->input->post("estatus") == 0) {
                $estatus = 0;
                if ($this->input->post("idrol") == 'Asesor' || $this->input->post("idrol") == 'Coordinador de ventas' || $this->input->post("idrol") == 'Gerente') {
                    $estatus = 3;
                    $dataBaja = array(
                        "fecha_baja" => $hoy,
                        "cantidad_descuento" => "0",
                        "desc_descuento" => "NA",
                        "material_baja" => "NA",
                        "observaciones_baja" => "NA",
                        "idasesor" => $this->input->post("id_user"),
                        "motivo_baja" => $this->input->post("motivo")
                    );
                    $this->Usuarios_modelo->ServicePostCH($url, $dataBaja);
                }
                $data = array(
                    "estatus" => $estatus,
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario'),
                    "status_contratacion" => 0
                );
                $response = $this->Usuarios_modelo->changeUserStatus($data, $this->input->post("id_user"));
                echo json_encode($response);
            } else {
                $data = array(
                    "estatus" => $this->input->post("estatus"),
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => $this->session->userdata('id_usuario'),
                    "status_contratacion" => 0
                );
                $response = $this->Usuarios_modelo->changeUserStatus($data, $this->input->post("id_user"));
                echo json_encode($response);
            }
        }
    }

    public function getSedesCH()
    {
        $user = file_get_contents('https://rh.gphsis.com/index.php/WS/getSedes');
        echo base64_decode($user);
    }

    public function getSucursalCH($idsede){
        $url = 'https://rh.gphsis.com/index.php/WS/getSucursalesComerciales';
        $data = array(
            "idsede" => $idsede
        );
        $row = $this->Usuarios_modelo->ServicePostCH($url, $data);
        echo $row;
    }

       public function updateUser()
       {
           $usersCH = 0;
           $ruta="https://rh.gphsis.com/index.php/WS/movimiento_interno_asesor";         
           if ($this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17 || $this->session->userdata('id_rol') == 13) {
               $data = array(
                   "forma_pago" => $_POST['payment_method'],
                   "fecha_modificacion" => date("Y-m-d H:i:s"),
                   "modificado_por" => $this->session->userdata('id_usuario')
               );
               //ACTUALIZACIÓN DE CONTRALORÍA SOLO FORMA DE PAGO
                $formaPago =  $this->Usuarios_modelo->getFormaPago($_POST['payment_method']);
               
               $dataCH = array(
                            "dcontrato" => array("forma_pagoch" => $formaPago[0]['nombre']),
                            "idasesor" => $this->input->post("id_usuario")
               );
               $usersCH = 1;
               $resultadoCH  =  $this->Usuarios_modelo->ServicePostCH($ruta, $dataCH);
               $res = json_decode($resultadoCH);
               $resultadoCH = $res->resultado;
           } else {
                   if($this->session->userdata('id_rol') == 4 || $this->session->userdata('id_rol') == 5 || $this->session->userdata('id_rol') == 6){
                        $arrayChecar = array (
                            'id_rol' => $_POST['member_type'],
                            'id_sede' => $_POST['headquarter'],
                            'id_lider' => $_POST['leader'],
                            'tipo'      => $_POST['tipo']
                        );
                        

                        if($_POST['tipo'] == 2){
                            $validacion['respuesta']=1;
                        }else{
                            $validacion = validateUserVts($arrayChecar);
                        }

                        if($validacion['respuesta']==1){
                            //continuar con la lógica
                        }
                        else{
                            switch ($this->session->userdata('id_rol')){
                                case 4:
                                case 5:
                                case 6:
                                    $usr = $this->Usuarios_modelo->getUserInformation($_POST['id_usuario']);
                                    $usr = $usr[0];
                                    $rolActual = $usr['id_rol'];
                                    $sedeActual = $usr['id_sede'];
                                    $liderActual = $usr['id_lider'];
                                    if($_POST['member_type'] != $rolActual || $_POST['headquarter'] != $sedeActual || $_POST['leader'] != $liderActual){

                                        echo json_encode(array("result" => false,
                                            "respuesta" => $validacion['respuesta'],
                                            "message" => $validacion['mensaje']));
                                        exit;
                                    }else{
                                    }

                                    break;
                            }

                        }
                    }

               $sedeCH = 0;
               $sucursal = 0;
               if (($_POST['member_type'] == 3 || $_POST['member_type'] == 7 || $_POST['member_type'] == 9 ) && $this->session->userdata('tipo') == 1) {
                   $usersCH = 1;
                   #actualizar los registros en caso de que haya modificado de lider o tipo de miembro
                   /* 
                   SEDES CAPITAL HUMANO
                   9 -- cancun
                   4 ---cdmx
                   2 -- leon
                   5 -- merida -- peninsula 
                   1 -- qro 
                   3 -- slp
                   11 -- tijuana 
                   */
                   $sedeCH = $_POST['sedech'];
                   $sucursal = !isset($_POST['sucursal']) ? 0 : $_POST['sucursal'];
                   $datosCH = array(
                       "dpersonales" => array(
                           "nombre_persona" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['name']))),
                               "apellido_paterno_persona" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['last_name']))),
                               "apellido_materno_persona" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['mothers_last_name']))),
                               "RFC" => strtoupper(trim($_POST['rfc'])),
                               "telefono1" => $_POST['phone_number'],
                               "email_empresarial" => strtoupper(trim($_POST['email']))
                                   ),
                                   "dcontrato" => array(),
                                   "idasesor" => $this->input->post("id_usuario")
                           );
              
               $resultadoCH = $this->Usuarios_modelo->UpdateProspect($this->input->post("id_usuario"), $_POST['leader'], $_POST['member_type'], $_POST['rol_actual'], $sedeCH, $sucursal, $datosCH);
            }
               $nueva_estructura = (isset($_POST['nueva_estructura'])) ? $_POST['nueva_estructura'] : 0;
            $simbolicoPropiedad = '';
            if(isset($_POST["simbolicoType"])){
                $simbolicoPropiedad = $_POST["simbolicoType"];
            }else{
                $simbolicoPropiedad = NULL;
            }

            if($_POST['leader'] != 0){
                $dataLiderAAsignar = $this->Services_model->getInfoLider($_POST['leader']);
                if($dataLiderAAsignar->tipo==2){
                    $tipoUsuario =  $dataLiderAAsignar->tipo;
                }else{
                    $tipoUsuario = 1;//tipo de usuario 1: comercializacion, 2:oaam
                }
            }else{
                    $tipoUsuario = 1;//tipo de usuario 1: comercializacion, 2:oaam
            }


               $data = array(
                   "nombre" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['name']))),
                   "apellido_paterno" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['last_name']))),
                   "apellido_materno" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['mothers_last_name']))),
                   "rfc" => strtoupper(trim($_POST['rfc'])),
                   "correo" => strtoupper(trim($_POST['email'])),
                   "telefono" => strtoupper(trim($_POST['phone_number'])),
                   "telefono" => $_POST['phone_number'],
                   "id_sede" => $_POST['headquarter'],
                   "id_rol" => $_POST['member_type'],
                   "id_lider" => $_POST['leader'],
                   "usuario" => trim($_POST['username']),
                   "contrasena" => encriptar($_POST['contrasena']),
                   "nueva_estructura" =>  $nueva_estructura,
                   "fecha_modificacion" => date("Y-m-d H:i:s"),
                   "modificado_por" => $this->session->userdata('id_usuario'),
                   "sedech" => $sedeCH,
                   "sucursalch" => $sucursal,
                   "simbolico" => $simbolicoPropiedad,
                   "tipo" => $tipoUsuario 
            );
        }
       
        if ($usersCH == 0) {
            $response['respuesta'] = $this->Usuarios_modelo->updateUser($data, $this->input->post("id_usuario"));
        } else {
            $result = json_decode($resultadoCH);
            if ($result == 1) {
                $response['respuesta'] = $this->Usuarios_modelo->updateUser($data, $this->input->post("id_usuario"));
                $response['message'] = 'Realizado correctamente';

                print_r(json_encode($response));
                exit;
            } else {
                $response['respuesta'] = 0;
                $response['message'] = 'No se pudo actualizar el registro debido a que el prospecto no se pudo actualizar ';
            }
        }
           echo json_encode($response);
       }
    public function getUserInformation($id_usuario){
        $data = $this->Usuarios_modelo->getUserInformation($id_usuario);
        $data[0]['contrasena'] = desencriptar($data[0]['contrasena']);
        echo json_encode($data);
    }

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            redirect(base_url() . "index.php/login");
        }
    }


    public function getNationality()
    {
        echo json_encode($this->Clientes_model->getNationality()->result_array());
    }

public function getEstados()
{
        echo json_encode($this->Clientes_model->getEstados()->result_array());
    }


    public function usersListComptroller()
    {
        $this->load->view('template/header');
        $this->load->view("usuarios/users_list_comptroller");
    }

    public function getChangelog($id_usuario)
    {
        echo json_encode($this->Usuarios_modelo->getChangelog($id_usuario)->result_array());
    }


/**-------------OPNION DE CUMPLIMIENTO-------- */
public function SubirPDF($id = '')
{

    $id_usuario = $this->session->userdata('id_usuario');
    $nombre = $this->session->userdata('nombre');
    $opc = 0;

    if ($id != '') {
        $opc = 1;
        $id_usuario = $this->input->post("id_usuario");
        $nombre = $this->input->post("nombre");
    }

    $uploadFileDir = './static/documentos/cumplimiento/';
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d");


        $fileTmpPath = $_FILES['file-uploadE']['tmp_name'];
            $fileName = $_FILES['file-uploadE']['name'];
            $fileSize = $_FILES['file-uploadE']['size'];
            $fileType = $_FILES['file-uploadE']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = $nombre . $hoy . md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './static/documentos/cumplimiento/';
            $dest_path = $uploadFileDir . $newFileName;
            
            
            $dest_path = $uploadFileDir . $newFileName;
            move_uploaded_file($fileTmpPath, $dest_path);
                        

            $response = $this->Usuarios_modelo->SaveCumplimiento($id_usuario, $newFileName, $opc);
            echo json_encode($response);
}

public function SubirPDFExtranjero($id = '')
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $nombre = $this->session->userdata('nombre');
        $opc = 0;

        if ($id != '') {
            $opc = 1;
            $id_usuario = $this->input->post("id_usuario");
            $nombre = $this->input->post("nombre");
        }

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d");


        $fileTmpPath = $_FILES['file-upload-extranjero']['tmp_name'];
        $fileName = $_FILES['file-upload-extranjero']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = $nombre . $hoy . md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './static/documentos/extranjero/';

        $dest_path = $uploadFileDir . $newFileName;
        move_uploaded_file($fileTmpPath, $dest_path);


        $response = $this->Usuarios_modelo->SaveCumplimiento($id_usuario, $newFileName, $opc);
        echo json_encode($response);
    }

/**---------------------------------------------------------------------------------- */
public function UpdatePDF()
{
 $id = $this->input->post("idDoc");
 
 $response = $this->Usuarios_modelo->UpdatePDF($id);
 echo json_encode($response);
}

/**---------------------------------------- */
public function getChangeLogUsers($id_usuario)
{
    $data = $this->Usuarios_modelo->getChangeLogUsers($id_usuario);
    echo json_encode($data);
}

    public function fillSelectsForUsers()
    {
        echo json_encode($this->Usuarios_modelo->getCatalogs()->result_array());
    }

    public function mktdAdvisors()
    {
        $this->load->view('template/header');
        $this->load->view("usuarios/mktd_advisers_list");
    }

    public function getMktdAvisersList()
    {
        $data['data'] = $this->Usuarios_modelo->getMktdAvisersList()->result_array();
        echo json_encode($data);
    }

    public function changeUserType()
    {
        if (isset($_POST) && !empty($_POST)) {
            $data = array(
                "ismktd" => $this->input->post("value_to_modify"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Usuarios_modelo->changeUserType($data, $this->input->post("id_usuario"));
            echo json_encode($response);
        } else {
            echo json_encode(0);
        }
    }

    public function usersByLeader()
    {
      $this->load->view('template/header');
      $this->load->view("usuarios/usersByLeader");
  }

    public function getUsersListByLeader()
    {
        $data['data'] = $this->Usuarios_modelo->getUsersListByLeader($this->session->userdata('id_usuario'))->result_array();
        echo json_encode($data);
    }

}
