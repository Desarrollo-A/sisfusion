<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Usuarios_modelo'));
        $this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
        $this->load->model('Clientes_model');
        $this->load->model('General_model');
        //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
        $this->load->library(array('session', 'form_validation', 'get_menu', 'formatter','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
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
        $url = 'https://prueba.gphsis.com/RHCV/index.php/WS/baja_asesor';
        if (isset($_POST) && !empty($_POST)) {
            if ($this->input->post("estatus") == 0) {
                $estatus = 0;
                if ($this->input->post("idrol") == 'Asesor' || $this->input->post("idrol") == 'Coordinador de ventas' || $this->input->post("idrol") == 'Gerente') {

                    $VerificarComision = $this->Usuarios_modelo->VerificarComision($this->input->post("id_user"))->result_array();
                    if (count($VerificarComision) == 0 || $VerificarComision[0]['abono_pendiente'] <= 0) {
                        $estatus = 0;
                    } else {
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
        $user = file_get_contents('https://prueba.gphsis.com/RHCV/index.php/WS/getSedes');
        echo base64_decode($user);
    }

    public function getSucursalCH($idsede)
    {
        $url = 'https://prueba.gphsis.com/RHCV/index.php/WS/getSucursalesComerciales';
        $data = array(
            "idsede" => $idsede
        );
        $row = $this->Usuarios_modelo->ServicePostCH($url, $data);
        echo $row;
    }

    public function updateUser()
    {
        $usersCH = 0;
        $ruta = "https://prueba.gphsis.com/RHCV/index.php/WS/movimiento_interno_asesor_v2";
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
        }
        else {

            if($this->session->userdata('id_rol') == 4 || $this->session->userdata('id_rol') == 5 || $this->session->userdata('id_rol') == 6){
                $arrayChecar = array (
                    'id_rol' => $_POST['member_type'],
                    'id_sede' => $_POST['headquarter'],
                    'id_lider' => $_POST['leader']
                );
                $validacion = validateUserVts($arrayChecar);


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
//                            print_r($_POST['member_type']);
//                            echo '<br>'.$rolActual;
//                            echo '<br><br>';
//                            print_r($_POST['headquarter']);
//                            echo '<br>'.$sedeActual;
//                            echo '<br><br>';
//                            print_r($_POST['leader']);
//                            echo '<br>'.$liderActual;
//                            echo '<br><br>';
//                            exit;
                            if($_POST['member_type'] != $rolActual || $_POST['headquarter'] != $sedeActual || $_POST['leader'] != $liderActual){

                                echo json_encode(array("result" => false,
                                    "respuesta" => $validacion['respuesta'],
                                    "message" => $validacion['mensaje']));
                                exit;
                            }else{
//                                print_r('sigue lógica normal');
//                                exit;
                            }

                            break;
                    }

                }
            }

            $sedeCH = 0;
            $sucursal = 0;
            if ($_POST['member_type'] == 3 || $_POST['member_type'] == 7 || $_POST['member_type'] == 9 || $_POST['member_type'] == 2) {
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
                $sedeCH = $_POST['sedech'] ?? 0;
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
                    "dcontrato" => [
                        'idsedech' => $sedeCH
                    ],
                    "idasesor" => $this->input->post("id_usuario")
                );

                $resultadoCH = 1;// $this->actualizarProspecto($this->input->post("id_usuario"), $_POST['leader'], $_POST['member_type'], $_POST['rol_actual'], $_POST['headquarter'], $sucursal, $datosCH);
            }
            $nueva_estructura = (isset($_POST['nueva_estructura'])) ? $_POST['nueva_estructura'] : 0;
            if(isset($_POST["simbolicoType"])){
                $simbolicoPropiedad = $_POST["simbolicoType"];
            }else{
                $simbolicoPropiedad = NULL;
            }

            $data = array( 
                "nombre" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['name']))),
                "apellido_paterno" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['last_name']))),
                "apellido_materno" => $this->formatter->eliminar_tildes(strtoupper(trim($_POST['mothers_last_name']))),
                "rfc" => strtoupper(trim($_POST['rfc'])),
                "correo" => strtoupper(trim($_POST['email'])),
                "telefono" => strtoupper(trim($_POST['phone_number'])),
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
                "simbolico" => $simbolicoPropiedad
            );
        }
        $insertData = array();
        $commonData = array();
        $updateArrayData = [];
        $dataPost = $_POST;
        //var_dump($dataPost);
        if($dataPost['index'] != 0){
           // echo "si entra";
            for ($i = 0; $i < $dataPost['index']; $i++) {
                if(isset($dataPost['multi_'.$i]) && !isset($dataPost['idRU_'.$i])){
                    $commonData = array(
                        "idUsuario" => (int)$dataPost['id_usuario'],
                        "idSede" => $dataPost['sedes_'.$i],
                        "idRol" => $dataPost['multi_'.$i],
                        "creado_por" => (int)$this->session->userdata('id_usuario'),
                        "fecha_creacion" => date("Y-m-d H:i:s"),
                        "modificado_por" => (int)$this->session->userdata('id_usuario'),
                        "fecha_modificacion" => date("Y-m-d H:i:s"),

                    );
                    array_push($insertData, $commonData);
                }
                if(isset($dataPost['idRU_'.$i])){
                        $updateArrayData[] = array(
                            'idSede' => $dataPost['sedes_'.$i],
                            'idRol' => $dataPost['multi_'.$i],
                            "idRU" => $dataPost['idRU_'.$i]
                        ); 
                }
              }
              count($insertData) > 0 ? $this->General_model->insertBatch("roles_x_usuario", $insertData) : '';
             count($updateArrayData) > 0 ? $this->General_model->updateBatch("roles_x_usuario", $updateArrayData, "idRU") : '';
        }

        if ($usersCH == 0) {
            $response = $this->Usuarios_modelo->updateUser($data, $this->input->post("id_usuario"));
            $mensajeLeyenda = ($response == 1) ? 'Usuario Actualizado correctamente' : 'No se pudo actualizar el usuario';
        } else {
            $result = json_decode($resultadoCH);
            if ($result == 1) {
                $response = $this->Usuarios_modelo->updateUser($data, $this->input->post("id_usuario"));
                $mensajeLeyenda = 'Usuario Actualizado correctamente';
            } else {
                $response = 0;
                $mensajeLeyenda = 'No se pudo actualizar el usuario';
            }
        }

        $respuestaView = array(
            'respuesta' => $response,
            'message' => $mensajeLeyenda
        );
        echo json_encode($respuestaView);
    }

    public function getUserInformation($id_usuario){
        $data = $this->Usuarios_modelo->getUserInformation($id_usuario);
        $data[0]['contrasena'] = desencriptar($data[0]['contrasena']);
        $data[0]['multirol'] = $this->Usuarios_modelo->getUserMultirol($id_usuario);

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

    public function deleteDocumentoExtranjero()
    {
        $a = 0;
        $idDocumento = $this->input->post("idDocumento");
        $response = $this->Usuarios_modelo->deleteDocumentoExtranjero($idDocumento);
        if ($response)
            echo json_encode(array("status" => 200, "message" => "Se ha realizado la acción de manera exitosa"));
        else
            echo json_encode(array("status" => 503, "message" => "Oops, algo salió mal. No se ha podido realizar la acción solicitada."));
    }

    public function actualizarProspecto($idUsuario, $idLiderNuevo, $rolNuevo, $rolActual, $sedeNueva, $sucursal, $datosCH)
    {
        //RUTA DE PRUEBAS
        $url = "https://prueba.gphsis.com/RHCV/index.php/WS/movimiento_interno_asesor_v2";
        //RUTA DE PRODUCCIÓN
        //$url="https://rh.gphsis.com/index.php/WS/movimiento_interno_asesor";

        $coordAndGerente = $this->actualizarProspectoPorRol($idUsuario, $rolNuevo, $rolActual, $idLiderNuevo, $sedeNueva);

        $datosCH['dcontrato']['idsucursalch'] = $sucursal;
        $datosCH['dcontrato']['idpuesto'] = $rolNuevo;
        $datosCH['dcontrato']['idcoordinador'] = $coordAndGerente->id_coordinador;
        $datosCH['dcontrato']['idgerente'] = $coordAndGerente->id_gerente;

//        $resultado = $this->Usuarios_modelo->ServicePostCH($url, $datosCH);
//        $r = json_decode($resultado);
//        if (isset($r->resultado)) {
//            if ($r->resultado == 1) {
//                return json_decode($r->resultado);
//            } else {
//                return json_decode(0);
//            }
//        } else {
//            return json_decode(0);
//        }

        return json_decode(1);
    }

    private function actualizarProspectoPorRol($idOwner, $rolNuevo, $rolActual, $idLiderNuevo, $sede): object
    {
        $dataProspecto = [
            'id_sede' => $sede,
            'modificado_por' => $this->session->userdata('id_usuario')
        ];

        $infoLineaVenta = $this->Usuarios_modelo->obtenerLideresPorIdUsuario($idOwner, $idLiderNuevo, $sede, $rolNuevo);

        if (
            ($rolActual == 7 && $rolNuevo == 9) || // De asesor pasa a coordinador
            ($rolActual == 2 && $rolNuevo == 9) || // De subdirector pasa a coordinador
            ($rolActual == 3 && $rolNuevo == 9) || // De gerente pasa a coordinador
            ($rolActual == 9 && $rolNuevo == 9) // Se queda en coordinador
        ) {
            $dataProspecto['id_coordinador'] = $idOwner;
            $dataProspecto['id_gerente'] = $infoLineaVenta->id_gerente;
            $dataProspecto['id_subdirector'] = $infoLineaVenta->id_subdirector;
            $dataProspecto['id_regional'] = $infoLineaVenta->id_regional;
            $dataProspecto['id_regional_2'] = $infoLineaVenta->id_regional_2;
        } else if (
            ($rolActual == 7 && $rolNuevo == 3) || // De asesor pasa a gerente
            ($rolActual == 9 && $rolNuevo == 3) || // De coordinador pasa a gerente
            ($rolActual == 2 && $rolNuevo == 3) || // De subdirector pasa a gerente
            ($rolActual == 3 && $rolNuevo == 3) // Se queda en gerente
        ) {
            $dataProspecto['id_coordinador'] = $idOwner;
            $dataProspecto['id_gerente'] = $idOwner;
            $dataProspecto['id_subdirector'] = $infoLineaVenta->id_subdirector;
            $dataProspecto['id_regional'] = $infoLineaVenta->id_regional;
            $dataProspecto['id_regional_2'] = $infoLineaVenta->id_regional_2;
        } else if (
            ($rolActual == 7 && $rolNuevo == 2) || // De asesor pasa a subdirector
            ($rolActual == 9 && $rolNuevo == 2) || // De coordinador pasa a subdirector
            ($rolActual == 3 && $rolNuevo == 2) || // De gerente pasa a subdirector
            ($rolActual == 2 && $rolNuevo == 2) // Se queda en subdirector
        ) {
            $dataProspecto['id_coordinador'] = $idOwner;
            $dataProspecto['id_gerente'] = $idOwner;
            $dataProspecto['id_subdirector'] = $idOwner;
            $dataProspecto['id_regional'] = $infoLineaVenta->id_regional;
            $dataProspecto['id_regional_2'] = $infoLineaVenta->id_regional_2;
        } else if ($idLiderNuevo == 832) { // Son asesores
                $dataProspecto['id_coordinador'] = $idLiderNuevo;
                $dataProspecto['id_gerente'] = $idLiderNuevo;
                $dataProspecto['id_subdirector'] = $infoLineaVenta->id_subdirector;
                $dataProspecto['id_regional'] = $infoLineaVenta->id_regional;
                $dataProspecto['id_regional_2'] = $infoLineaVenta->id_regional_2;
        } else {
            $dataProspecto['id_coordinador'] = $infoLineaVenta->id_coordinador;
            $dataProspecto['id_gerente'] = $infoLineaVenta->id_gerente;
            $dataProspecto['id_subdirector'] = $infoLineaVenta->id_subdirector;
            $dataProspecto['id_regional'] = $infoLineaVenta->id_regional;
            $dataProspecto['id_regional_2'] = $infoLineaVenta->id_regional_2;
        }

        $this->Clientes_model->actualizarProspectosPorPropietario($idOwner, $dataProspecto);

        return (object)[
            'id_coordinador' => $dataProspecto['id_coordinador'],
            'id_gerente' => $dataProspecto['id_gerente']
        ];
    }

    public function borrarMulti(){
        $idRU = $this->input->post("idRU");
        $modificado_por = $this->session->userdata('id_usuario');
        $result = $this->Usuarios_modelo->borrarMulti($idRU,$modificado_por);
        if($result){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }
    public function consultarLinea(){
        $sede = $this->input->post("sede");
        $puesto = $this->input->post("puesto");
        $lider = $this->input->post("lider");
        $result = $this->Usuarios_modelo->consultarLinea($sede,$puesto,$lider)->result_array();
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
}
