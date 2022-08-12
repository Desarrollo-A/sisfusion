<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Usuarios_modelo', 'Services_model'));
        $this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
        $this->load->model('Clientes_model');
        $this->load->model('General_model');
        //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
        $this->load->library(array('session', 'form_validation', 'get_menu'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->validateSession();
    }

    public function index()
    {
        if ($this->session->userdata('id_rol') == FALSE) {
            redirect(base_url() . 'login');
        }
    }

    public function configureProfile()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
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
            "rfc" => $_POST['rfc'],
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
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("usuarios/advisers_list", $datos);
    }

    public function addUser()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("usuarios/add_user", $datos);
    }

    public function usersList()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("usuarios/users_list", $datos);
    }

    public function getUsersList()
    {
        $data['data'] = $this->Usuarios_modelo->getUsersList()->result_array();
        //$data['contrasena'] = desencriptar($data['contrasena']);
        echo json_encode($data);
    }

    public function getPaymentMethod()
    {
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
        $url = 'https://prueba.gphsis.com/RHCV/index.php/WS/baja_asesor';
        if (isset($_POST) && !empty($_POST)) {
            if ($this->input->post("estatus") == 0) {
                $estatus = 0;
                if ($this->input->post("idrol") == 'Asesor' || $this->input->post("idrol") == 'Coordinador de ventas' || $this->input->post("idrol") == 'Gerente') {

                  $VerificarComision = $this->Usuarios_modelo->VerificarComision($this->input->post("id_user"))->result_array();
                    if(count($VerificarComision) == 0 || $VerificarComision[0]['abono_pendiente'] <= 0 ){
                        $estatus = 0;
                    }else{
                        $estatus = 3;
                    }
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
            }
            else {
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
        $user = file_get_contents('https://prueba.gphsis.com/RHCV/index.php/WS/getSedes');
        echo base64_decode($user);
    }

    public function getSucursalCH($idsede)
    {
        $url = 'https://prueba.gphsis.com/RHCV/index.php/WS/getSucursalesComerciales';
        $data = array(
            "idsede" => $idsede);
        $row = $this->Usuarios_modelo->ServicePostCH($url, $data);
        echo $row;
    }

    public function updateUser()
    {
        if ($this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17 || $this->session->userdata('id_rol') == 13) {
            $data = array(
                "forma_pago" => $_POST['payment_method'],
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario')
            );
        } else {

            $sedeCH = 0;
            $sucursal = 0;
            if ($_POST['member_type'] == 3 || $_POST['member_type'] == 7 || $_POST['member_type'] == 9) {
                #actualizar los registros en caso de que haya modificado de lider o tipo de miembro
                //$getLider = $this->Services_model->getLider($_POST['leader'],$_POST['member_type']);
                $data_update = array();
               /* switch ($_POST['member_type'] ){
                    case 3;
                        $data_update = array(
                            'regional_id' => $getLider[0]['id_regional'],
                            'subdirector_id' => $_POST['leader'],
                            'gerente_id' => 0,
                            'id_lider' => 0
                        );
                        break;
                    case 7;
                        $data_update = array(
                            'regional_id' => $getLider[0]['id_regional'],
                            'subdirector_id' => $getLider[0]['id_subdirector'],
                            'gerente_id' => $getLider[0]['id_gerente'],
                            'id_lider' => $_POST['leader']
                        );
                        break;
                    case 9;
                        $data_update = array(
                            'regional_id' => $getLider[0]['id_regional'],
                            'subdirector_id' => $getLider[0]['id_subdirector'],
                            'gerente_id' => 0,
                            'id_lider' => $_POST['leader']
                        );
                        break;
                }*/

                /*print_r($data_update);
                echo 'data del post:<br><br>';
                print_r($_POST);
                exit;*/
              //  $this->General_model->updateRecord('usuarios', $data_update, 'id_usuario', $_POST['id_usuario']);
                #end of this part




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
                $this->Usuarios_modelo->UpdateProspect($this->input->post("id_usuario"), $_POST['leader'], $_POST['member_type'], $_POST['rol_actual'], $sedeCH, $sucursal);
            }
            $getLider = $this->Services_model->getLider($_POST['leader'],$_POST['member_type']);
            $id_lider = 0;
            $id_gerente=0;
            $id_subdirector=0;
            $id_regional=0;
            if($_POST['member_type'] == 7){
                //Asesor
                $id_lider = $_POST['leader'];
                $id_gerente=$getLider[0]['id_gerente'];
                $id_subdirector=$getLider[0]['id_subdirector'];
                $id_regional=$getLider[0]['id_regional'];
            }else if($_POST['member_type'] == 9){
                //Coordinador
                $id_lider = 0;
                $id_gerente=$_POST['leader'];
                $id_subdirector=$getLider[0]['id_subdirector'];
                $id_regional=$getLider[0]['id_regional'];
            }else if($_POST['member_type'] == 3){
                //Gerente
                $id_lider = 0;
                $id_gerente=0;
                $id_subdirector=$_POST['leader']; //$getLider[0]['id_subdirector'];
                $id_regional=$getLider[0]['id_lider'];
            }

            $data = array(
                "nombre" => $_POST['name'],
                "apellido_paterno" => $_POST['last_name'],
                "apellido_materno" => $_POST['mothers_last_name'],
                "rfc" => $_POST['rfc'],
                "correo" => $_POST['email'],
                "telefono" => $_POST['phone_number'],
                "id_sede" => $_POST['headquarter'],
                "id_rol" => $_POST['member_type'],
                "id_lider" => $id_lider,
                "usuario" => $_POST['username'],
                "contrasena" => encriptar($_POST['contrasena']),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
                "sedech" => $sedeCH,
                "sucursalch" => $sucursal,
                "gerente_id" => $id_gerente,
                "subdirector_id" => $id_subdirector,
                "regional_id" => $id_regional,
                "talla" => empty($_POST['talla']) ? 0 : $_POST['talla'],
                "sexo" => !empty($_POST['sexo']) ? $_POST['sexo'] : 'S',
                "tiene_hijos" => !empty($_POST['hijos']) ? $_POST['hijos'] : "NO" ,
                "hijos_12" => !empty($_POST['noHijos']) ? $_POST['noHijos'] : 0   
               );
        }
        $response = $this->Usuarios_modelo->updateUser($data, $this->input->post("id_usuario"));
        echo json_encode($response);
    }

    /*public function changeUserStatus(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "estatus" => $this->input->post("estatus"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->Usuarios_modelo->changeUserStatus($data, $this->input->post("id_usuario"));
            echo json_encode($response);
        }
    }*/

    public function getUserInformation($id_usuario)
    {
        $data = $this->Usuarios_modelo->getUserInformation($id_usuario);
        $data[0]['contrasena'] = desencriptar($data[0]['contrasena']);
        echo json_encode($data);
    }

    /*public function updateUser(){
        if($this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17 || $this->session->userdata('id_rol') == 13 ){
            $data = array(
                "forma_pago" => $_POST['payment_method'],
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario')
            );
        } else {
            $data = array(
                "nombre" => $_POST['name'],
                "apellido_paterno" => $_POST['last_name'],
                "apellido_materno" => $_POST['mothers_last_name'],
                "rfc" => $_POST['rfc'],
                "correo" => $_POST['email'],
                "telefono" => $_POST['phone_number'],
                "id_sede" => $_POST['headquarter'],
                "id_rol" => $_POST['member_type'],
                "id_lider" => $_POST['leader'],
                "usuario" => $_POST['username'],
                "contrasena" => encriptar($_POST['contrasena']),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario')
            );
        }
        $response = $this->Usuarios_modelo->updateUser($data, $this->input->post("id_usuario"));
        echo json_encode($response);
    }*/

    public function validateSession()
    {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
            //echo "<script>console.log('No hay sesión iniciada');</script>";
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
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("usuarios/users_list_comptroller", $datos);
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
        /*print_r($id_usuario);
        exit;*/
        $data = $this->Usuarios_modelo->getChangeLogUsers($id_usuario);
        echo json_encode($data);
    }

    public function fillSelectsForUsers()
    {
        echo json_encode($this->Usuarios_modelo->getCatalogs()->result_array());
    }

    public function mktdAdvisors()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("usuarios/mktd_advisers_list", $datos);
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

    public function usersByLeader(){
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/           
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
      $this->load->view('template/header');
      $this->load->view("usuarios/usersByLeader", $datos);
  }

    public function getUsersListByLeader(){
        $data['data'] = $this->Usuarios_modelo->getUsersListByLeader($this->session->userdata('id_usuario'))->result_array();
        echo json_encode($data);
    }

    public function usersAsesor()
    {
        /*--------------------NUEVA FUNCIÓN PARA EL MENÚ--------------------------------*/
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
        /*-------------------------------------------------------------------------------*/
        $this->load->view('template/header');
        $this->load->view("asesor/viewUser", $datos);   
    }

    public function getUsersListAsesor()
    {
        $data['data'] = $this->Usuarios_modelo->getUserPassword()->result_array();
        //print_r($data['data'][0]['contrasena']);

        //exit;
        $data['data'][0]['contrasena'] = desencriptar($data['data'][0]['contrasena']);
        echo json_encode($data);
    }




}
