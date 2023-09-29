<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caja_outside extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('Clientes_model', 'caja_model_outside', 'General_model','PaquetesCorrida_model'));
        $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->jwt_actions->authorize_externals('6489', apache_request_headers()["Authorization"]);

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }

    public function index()
    {
        if($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '12')
        {
            redirect(base_url().'login');
        }
        $this->load->view('template/header');
        $this->load->view('caja/inicio_caja_view');
        $this->load->view('template/footer');
    }


    public function getResidencialDisponible() {
        $datos["residenciales"] = $this->caja_model_outside->getResidencialDis();
        $datos["asesor"] = $this->caja_model_outside->allAsesor();
        if($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }


    public function getResidencialDisponible2() {
        $proyecto = json_decode(file_get_contents("php://input"));

        $recidenciales = $this->caja_model_outside->getResidencialDis2($proyecto->id_rol);
        if($recidenciales != null) {
            echo json_encode($recidenciales);
        } else {
            echo json_encode(array());
        }
    }

    public function getCondominioDisponible() {
        $proyecto = json_decode(file_get_contents("php://input"));

        $condominio = $this->caja_model_outside->getCondominioDis($proyecto->idResidencial);
        if($condominio != null) {
            echo json_encode($condominio);
        } else {
            echo json_encode(array());
        }
    }


    public function getCondominioDisponible2() {
        $proyecto = json_decode(file_get_contents("php://input"));

        $condominio = $this->caja_model_outside->getCondominioDis2($proyecto->idResidencial, $proyecto->id_rol);
        if($condominio != null) {
            echo json_encode($condominio);
        } else {
            echo json_encode(array());
        }
    }

    public function getLoteDisponible() {
        $condominio = json_decode(file_get_contents("php://input"));
        $lotes = $this->caja_model_outside->getLotesDis($condominio->idCondominio);
        for($i = 0; $i < count($lotes); $i++) {
            $lotes[$i]['casasDetail'] = json_decode(str_replace("'", '"', $lotes[$i]['casasDetail']));
        }
        if($lotes != null) {
            echo json_encode($lotes);
        } else {
            echo json_encode(array());
        }
    }

////////////////
    public function getLoteDisponible2() {
        $condominio = json_decode(file_get_contents("php://input"));
        $lotes = $this->caja_model_outside->getLotesDis2($condominio->idCondominio, $condominio->id_rol);
        for($i = 0; $i < count($lotes); $i++) {
            $lotes[$i]['casasDetail'] = json_decode(str_replace("'", '"', $lotes[$i]['casasDetail']));
        }
        if($lotes != null) {
            echo json_encode($lotes);
        } else {
            echo json_encode(array());
        }
    }

    public function getResidencial() {
        $residenciales = $this->caja_model_outside->getResidencial();
        if($residenciales != null) {
            echo json_encode($residenciales);
        } else {
            echo json_encode(array());
        }
    }

    public function getCondominio() {
        $proyecto = json_decode(file_get_contents("php://input"));

        $condominio = $this->caja_model_outside->getCondominio($proyecto->idResidencial);
        if($condominio != null) {
            echo json_encode($condominio);
        } else {
            echo json_encode(array());
        }
    }

    public function getAllCondominios()
    {
        $proyecto =  (array) (json_decode(file_get_contents("php://input")));
        if(!empty($proyecto)){
            $idResidencial = $proyecto["idResidencial"];
            if($idResidencial != null || $idResidencial != ""){
                $condominios = $this->caja_model_outside->getCondominio($idResidencial);
                if ($condominios != null || !empty($condominios))
                    echo json_encode($condominios);
                else
                    echo(json_encode(array("status" => 403, "mensaje" => "No se han encontrado registros"), JSON_UNESCAPED_UNICODE));
            }
            else echo(json_encode(array("status" => 403, "mensaje" => "No se ha enviado un ID de Proyecto"), JSON_UNESCAPED_UNICODE));
        }
        else echo(json_encode(array("status" => 403, "mensaje" => "No existe parámetro"), JSON_UNESCAPED_UNICODE));
    }

    public function getAllLotes(){
        $proyecto =  (array) (json_decode(file_get_contents("php://input")));
        if(!empty($proyecto)){
            $idCondominio = $proyecto["idCondominio"];
            if( $idCondominio != null || $idCondominio != "" ){
                $lotes = $this->caja_model_outside->getAllLotes($idCondominio);
                if ($lotes != null || !empty($lotes))
                    echo json_encode($lotes);
                else
                    echo(json_encode(array("status" => 403, "mensaje" => "No se han encontrado registros"), JSON_UNESCAPED_UNICODE));
            }
            else echo(json_encode(array("status" => 403, "mensaje" => "No se ha enviado un ID de Condominio"), JSON_UNESCAPED_UNICODE));
        }
        else echo(json_encode(array("status" => 403, "mensaje" => "No existe parámetro"), JSON_UNESCAPED_UNICODE));
    }

    public function getAllClientsByLote(){
        $data =  (array) (json_decode(file_get_contents("php://input")));
        if(!empty($data)){
            $idLote = $data["idLote"];
            if( $idLote != null || $idLote != "" ){
                $clientes = $this->caja_model_outside->getAllClientsByLote($idLote);
                if ($clientes != null || !empty($clientes))
                    echo json_encode($clientes);
                else
                    echo(json_encode(array("status" => 403, "mensaje" => "No se han encontrado registros"), JSON_UNESCAPED_UNICODE));
            }
            else echo(json_encode(array("status" => 403, "mensaje" => "No se ha enviado un ID de Lote"), JSON_UNESCAPED_UNICODE));
        }
        else echo(json_encode(array("status" => 403, "mensaje" => "No existe parámetro"), JSON_UNESCAPED_UNICODE));
    }

    public function getLotee() {
        $condominio = json_decode(file_get_contents("php://input"));

        $lotes = $this->caja_model_outside->getLotes($condominio->idCondominio);
        if($lotes != null) {
            echo json_encode($lotes);
        } else {
            echo json_encode(array());
        }
    }

    public function getdbanco(){
        $datos["banco"]= $this->caja_model_outside->table_datosBancarios();
        echo json_encode($datos);
    }

    public function getEtapa(){
        $datos["etapa"]= $this->caja_model_outside->table_etapa();
        echo json_encode($datos);
    }

    function caja_modules() {
        $data = json_decode( file_get_contents('php://input') );
        $datos = array();
        if ($data->accion == 0){
            foreach ($data->lotes as $value) {

                $datos["nombreLote"] = $value->nombreLote;
                $datos["sup"] = $value->sup;
                $datos["precio"] = $value->precio;
                $datos["porcentaje"] = $value->porcentaje;


                $datos["idStatusContratacion"] = 0;
                $datos["idMovimiento"] = 0;
                $datos["ubicacion"] = 0;
                $datos["msi"] = 36; //se asignan los msi por defecto al dar de alta el lote


                if ($value->idStatusLote == 'DISPONIBLE') {
                    $datos['idStatusLote'] = 1;
                } else if ($value->idStatusLote == 'APARTADO') {
                    $datos['idStatusLote'] = 3;
                } else if ($value->idStatusLote == 'ENGANCHE') {
                    $datos['idStatusLote'] = 4;
                } else if ($value->idStatusLote == 'INTERCAMBIO') {
                    $datos['idStatusLote'] = 6;
                } else if ($value->idStatusLote == 'DIRECCION') {
                    $datos['idStatusLote'] = 7;
                } else if ($value->idStatusLote == 'BLOQUEO' || $value->idStatusLote == 'BLOQUEADO') {
                    $datos['idStatusLote'] = 8;
                } else if ($value->idStatusLote == 'ESPECIAL') {
                    $datos['idStatusLote'] = 101;
                } else {
                    $datos['idStatusLote'] = 8;
                }

                $datos["idCondominio"] = $data->idCondominio;
                $datos["total"] = ($value->precio * $value->sup);
                $datos["enganche"] = ($datos["total"] * 0.1);
                $datos["saldo"] = ($datos["total"] - ($datos["enganche"]));

                $insert = $this->caja_model_outside->loadLotes($datos);

                if($insert == TRUE) {
                    $response['message'] = 'SUCCESS';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'ERROR';
                    echo json_encode($response);
                }


            }

        }
        else if ($data->accion == 1){
            foreach($data->lotes as $value) {
                $datos["idCondominio"] = $data->idCondominio;
                $datos["nombreLote"] = $value->nombreLote;
                $datos["precio"] = $value->precio;
                $update = $this->caja_model_outside->uploadPrecio($datos);
                if($update == TRUE) {
                    $response['message'] = 'SUCCESS';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'ERROR';
                    echo json_encode($response);
                }
            }


        }
        else if ($data->accion == 2) {

            foreach ($data->lotes as $value) {

                $datos["idCondominio"] = $data->idCondominio;

                $datos["nombreLote"] = $value->nombreLote;
                $datos["referencia"] = $value->referencia;

                $update = $this->caja_model_outside->uploadReferencias($datos);

                if ($update == TRUE) {
                    $response['message'] = 'SUCCESS';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'ERROR';
                    echo json_encode($response);
                }

            }


        }
        else if ($data->accion == 3) {
            $inicio = date("Y-m-01");
            $fin = date("Y-m-t");
            //$datosCondominio = $this->caja_model_aoutside->getDatosCondominio($data->idCondominio);
                    if($data->lotes[0]->tipo_lote == 1 ){ //1 - Comercial
                        //si el condominio es comercial solo consultar sin importar la superficie
                        $getPaquetesDescuentos = $this->PaquetesCorrida_model->getPaquetesDisponiblesyApart("AND c.tipo_lote =1","",$data->id_proy, $inicio, $fin);
                        $datos["descuentoComerciales"] = count($getPaquetesDescuentos) == 0 ? NULL :  $getPaquetesDescuentos[0]['id_descuento'] ;
                    }else{ //0 - Habitacional
                        $paquetesMenores200 = $this->PaquetesCorrida_model->getPaquetesDisponiblesyApart("AND c.tipo_lote =0","AND sup < 200",$data->id_proy, $inicio, $fin);
                        $paquetesMayores200 = $this->PaquetesCorrida_model->getPaquetesDisponiblesyApart("AND c.tipo_lote =0","AND sup > 200",$data->id_proy, $inicio, $fin);
                        $datos["descuentoHabMenores"] = count($paquetesMenores200) == 0 ? NULL : $paquetesMenores200[0]['id_descuento'];
                        $datos["descuentoHabMayores"] = count($paquetesMayores200) == 0 ? NULL : $paquetesMayores200[0]['id_descuento'];
                    }
            foreach ($data->lotes as $value) {

                $datos["idCondominio"] = $data->idCondominio;

                $datos["nombreLote"] = $value->nombreLote;
                $datos["precio"] = $value->precio;
                $datos["activeLE"] = $data->activeLE;
                $datos["tipo_lote"] = $data->lotes[0]->tipo_lote;
                $datos["activeLP"] = $data->activeLP;


                $datos["comentarioLiberacion"] = 'LIBERADO';
                $datos["observacionLiberacion"] = 'LIBERADO POR CORREO';
                $datos["fechaLiberacion"] = date('Y-m-d H:i:s');
                $datos["modificado"] = date('Y-m-d H:i:s');
                $datos["status"] = 1;
                $datos["userLiberacion"] = $data->id_usuario;

                $datos["tipo"] = $data->tipo;

                if ($data->activeLP == true)
                    $datos["clausulas"] = $value->clausulas;

                $update = $this->caja_model_outside->aplicaLiberacion($datos);

                if ($update == TRUE) {
                    $response['message'] = 'SUCCESS';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'ERROR';
                    echo json_encode($response);
                }


            }
        }
        else if ($data->accion == 6) {

            foreach ($data->lotes as $value) {

                $datos["idCondominio"] = $data->idCondominio;

                $datos["nombreLote"] = $value->nombreLote;
                $datos["sup"] = $value->sup;

                $update = $this->caja_model_outside->uploadSup($datos);

                if ($update == TRUE) {
                    $response['message'] = 'SUCCESS';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'ERROR';
                    echo json_encode($response);
                }


            }
        }
    }


    public function getAllAsesor()
    {
        $datos["asesor"] = $this->caja_model_outside->allAsesor();
        echo json_encode($datos);
    }

    public function getProspectoXAsesor()
    {
        $asesor = json_decode(file_get_contents("php://input"));

        $datos["prospecto"] = $this->caja_model_outside->prospectoXAsesor($asesor->id_asesor);
        echo json_encode($datos);
    }

    public function insertProyecto()
    {

        $data = json_decode(file_get_contents("php://input"));
        $dato = array();
        $dato["nombreResidencial"] = $data->nProyecto;
        $dato["descripcion"] = $data->descripcion;

        $this->caja_model_outside->insert_proyecto($dato);

    }

    function aplicaLiberacion()
    {
        $valida = ($this->input->post('checkls') == NULL) ? 0 : 1;
        $this->caja_model_outside->aplicaLiberaciones($this->input->post('filtro4'), $valida);
    }

    public function insertCluster()
    {

        $data = json_decode(file_get_contents("php://input"));

        $dato = array();
        $dato["idResidencial"] = $data->idResidencial;
        $dato["nombre"] = $data->nombre;
        $dato["msni"] = 36;
        $dato["idEtapa"] = $data->idEtapa;
        $dato["idDBanco"] = $data->idDBanco;
        $dato["tipo_lote"] = $data->tipo_lote;

        $insert = $this->caja_model_outside->insert_cluster($dato);

        if ($insert == TRUE) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }


    }

    public function EnganchEstatusOnline()
    {
        echo json_encode(array("resultado" => $this->db->query("SELECT * FROM lotes WHERE lotes.referencia = " . $this->input->post("referencia"))->num_rows() > 0));
    }


    public function actualizaProspecto($id_prospecto)
    {

        $data_update = array(
            'tipo' => 1,
            'becameClient' => date('Y-m-d H:i:s'),
            'estatus_particular' => 7
        );

        $return = $this->caja_model_outside->updateProspecto($id_prospecto, $data_update);

        if ($return > 0) {
            return 'Prospecto actualizado correctamente';
        }

    }

    public function addClient()
    {
        $dataPost = file_get_contents("php://input");
        //$response['resultado'] = FALSE;
        $datosView = json_decode($dataPost);

        /************testing datas *************/
        /*$datosView = json_decode($dataFromView);

        print_r($datosView);
        print_r($datosView->id_prospecto);
        print_r($datosView->lotes[0]->idLote);
        exit;*/
        /************termina testeo *************/
        $id_prospecto = $datosView->id_prospecto;
        $id_lote = $datosView->lotes[0]->idLote;
        $validateLote = $this->caja_model_outside->validate($id_lote);
        ($validateLote == 1) ? TRUE : FALSE;
        if ($validateLote == FALSE) {
            $dataError['ERROR'] = array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error, el lote no esta disponible 1'
            );
            if ($dataError != null) {
                echo json_encode($dataError);
            } else {
                echo json_encode(array());
            }
            exit;
        }
        $data['prospecto'] = $this->caja_model_outside->consultByProspect($id_prospecto);
        /*update validacion 26-11-2020*/
        if (count($data['prospecto']) <= 0) {
            $dataError['ERROR'] = array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error no se encuentra el prospecto [ID: ' . $id_prospecto . ']'
            );
            if ($dataError != null) {
                echo json_encode($dataError);
            } else {
                echo json_encode(array());
            }
            exit;
        }


        if ($datosView->id_coordinador == $datosView->id_asesor && $datosView->id_asesor != 7092 && $datosView->id_asesor != 6626) {
            $voBoCoord = 0;
        } else if ($datosView->id_coordinador == $datosView->id_gerente && $datosView->id_asesor != 7092 && $datosView->id_asesor != 6626) {
            $voBoCoord = 0;
        } else {
            $voBoCoord = $datosView->id_coordinador;
        }

        $data['lote'] = $id_lote;
        $data['condominio'] = $this->caja_model_outside->getCondominioByIdLote($id_lote);
       // $data['lider'] = $this->caja_model_outside->getLider($datosView->id_gerente);
 
        if( $datosView->concepto == 'REUBICACIÓN'){
            if(ISSET( $datosView->fechaApartadoReubicacion)){
                if( $datosView->fechaApartadoReubicacion == null || $datosView->fechaApartadoReubicacion == '' ){
                    $dataError['ERROR'] = array(
                        'titulo' => 'ERROR',
                        'resultado' => FALSE,
                        'message' => 'La fecha por reubicación no ha sido enviada'
                    );
                    
                    if ($dataError != null) {
                        echo json_encode($dataError);
                    } else {
                        echo json_encode(array());
                    }
                    exit;
                }
            }
            else{
                    $dataError['ERROR'] = array(
                        'titulo' => 'ERROR',
                        'resultado' => FALSE,
                        'message' => 'La fecha por reubicación no ha sido enviada'
                    );
                    
                    if ($dataError != null) {
                        echo json_encode($dataError);
                    } else {
                        echo json_encode(array());
                    }
                    exit;
            }
        }
        $dias = [1,2,3];
        $date = new DateTime('now');
        $date->modify('-1 month');
        $date->format('Y-m-t');
        $fechaApartado = $datosView->pagoRetrasado != 0 &&  in_array(date("j"),$dias) ? $date->format('Y-m-t H:i:s') : date('Y-m-d H:i:s') ;
        $dataInsertCliente = array(
            'id_asesor' => $datosView->id_asesor,
            'id_coordinador' => $voBoCoord,
            'id_gerente' => $datosView->id_gerente,
            'id_subdirector' => $datosView->id_subdirector,
            'id_regional' => $datosView->id_regional,
            'id_regional_2' => $datosView->id_regional_2,
            'id_sede' => $datosView->id_sede,
            'nombre' => $data['prospecto'][0]['nombre'],
            'apellido_paterno' => $data['prospecto'][0]['apellido_paterno'],
            'apellido_materno' => $data['prospecto'][0]['apellido_materno'],
            'personalidad_juridica' => $data['prospecto'][0]['personalidad_juridica'],
            'nacionalidad' => $data['prospecto'][0]['nacionalidad'],
            'rfc' => $data['prospecto'][0]['rfc'],
            'curp' => $data['prospecto'][0]['curp'],
            'correo' => $data['prospecto'][0]['correo'],
            'telefono1' => $data['prospecto'][0]['telefono'],
            'telefono2' => $data['prospecto'][0]['telefono_2'],
            'telefono3' => '',/*del formulario*/
            'fecha_nacimiento' => $data['prospecto'][0]['fecha_nacimiento'],
            'lugar_prospeccion' => $data['prospecto'][0]['lugar_prospeccion'],
            'medio_publicitario' => $data['prospecto'][0]['medio_publicitario'],
            'otro_lugar' => $data['prospecto'][0]['otro_lugar'],
            'plaza_venta' => $data['prospecto'][0]['plaza_venta'],
            'tipo' => $data['prospecto'][0]['tipo'],
            'estado_civil' => $data['prospecto'][0]['estado_civil'],
            'regimen_matrimonial' => $data['prospecto'][0]['regimen_matrimonial'],
            'nombre_conyuge' => $data['prospecto'][0]['conyuge'],
            'domicilio_particular' => $data['prospecto'][0]['domicilio_particular'],
            'originario_de' => $data['prospecto'][0]['originario_de'],
            'tipo_vivienda' => $data['prospecto'][0]['tipo_vivienda'],
            'ocupacion' => $data['prospecto'][0]['ocupacion'],
            'empresa' => $data['prospecto'][0]['empresa'],
            'puesto' => $data['prospecto'][0]['posicion'],
            'edadFirma' => $data['prospecto'][0]['edadFirma'],
            'antiguedad' => $data['prospecto'][0]['antiguedad'],
            'domicilio_empresa' => $data['prospecto'][0]['direccion'],
            'engancheCliente' => $datosView->lotes[0]->pago,
            'concepto' => $datosView->concepto,
            'noRecibo' => $datosView->pago->recibo,
            'fechaEnganche' => date('Y-m-d H:i:s'),
            'status' => 1,
            'idLote' => $data['lote'],
            'fechaApartado' => ( $datosView->concepto == 'REUBICACIÓN') ? $datosView->fechaApartadoReubicacion : $fechaApartado,
            'fechaVencimiento' => date("Y-m-d H:i:s", strtotime($data['prospecto'][0]['fecha_vencimiento'])),
            'usuario' => $datosView->id_usuario,
            'modificado_por' => $datosView->id_usuario,
            'idCondominio' => $data['condominio'][0]['idCondominio'],
            'fecha_creacion' => date('Y-m-d h:i:s'),
            'creado_por' => 1,
            'id_prospecto' => $id_prospecto,
            'fecha_modificacion' => date('Y-m-d H:i:s'),
            'estructura' => in_array($datosView->id_gerente, array(12135, 6661)) ? 1 : 0,
            'apartadoXReubicacion' => ( $datosView->concepto == 'REUBICACIÓN') ? '1' : '0',
            'fechaAlta' => date('Y-m-d H:i:s'),
            'id_cliente_reubicacion' => isset( $datosView->id_cliente_reubicacion ) ? $datosView->id_cliente_reubicacion : null
        );
        /*Inserta cliente*/
        $last_id = '';
        $currentUSer = $this->session->userdata('usuario');
        if ($idClienteInsert = $this->caja_model_outside->insertClient($dataInsertCliente)) {
            $last_id = $idClienteInsert[0]["lastId"];
            date_default_timezone_set('America/Mexico_City');
            $horaActual = date('H:i:s');
            $horaInicio = date("08:00:00");
            $horaFin = date("16:00:00");
            if ($horaActual > $horaInicio and $horaActual < $horaFin) {
                $fechaAccion = date("Y-m-d H:i:s");
                $hoy_strtotime2 = strtotime($fechaAccion);
                $sig_fecha_dia2 = date('D', $hoy_strtotime2);
                $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
                if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                    $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                    $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                    $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                    $sig_fecha_feriado2 == "25-12") {
                    $fecha = $fechaAccion;
                    $i = 0;
                    while ($i <= 6) {
                        $hoy_strtotime = strtotime($fecha);
                        $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                        $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                        $sig_fecha_dia = date('D', $sig_strtotime);
                        $sig_fecha_feriado = date('d-m', $sig_strtotime);
                        if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                            $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                            $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                            $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                            $sig_fecha_feriado == "25-12") {
                        } else {
                            $fecha = $sig_fecha;
                            $i++;
                        }
                        $fecha = $sig_fecha;
                    }
                    $fechaFull = $fecha;
                } else {
                    $fecha = $fechaAccion;
                    $i = 0;
                    while ($i <= 5) {
                        $hoy_strtotime = strtotime($fecha);
                        $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                        $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                        $sig_fecha_dia = date('D', $sig_strtotime);
                        $sig_fecha_feriado = date('d-m', $sig_strtotime);
                        if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                            $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                            $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                            $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                            $sig_fecha_feriado == "25-12") {
                        } else {
                            $fecha = $sig_fecha;
                            $i++;
                        }
                        $fecha = $sig_fecha;
                    }
                    $fechaFull = $fecha;
                }
            } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
                $fechaAccion = date("Y-m-d H:i:s");
                $hoy_strtotime2 = strtotime($fechaAccion);
                $sig_fecha_dia2 = date('D', $hoy_strtotime2);
                $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
                if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                    $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                    $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                    $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                    $sig_fecha_feriado2 == "25-12") {
                    $fecha = $fechaAccion;
                    $i = 0;
                    while ($i <= 6) {
                        $hoy_strtotime = strtotime($fecha);
                        $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                        $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                        $sig_fecha_dia = date('D', $sig_strtotime);
                        $sig_fecha_feriado = date('d-m', $sig_strtotime);
                        if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                            $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                            $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                            $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                            $sig_fecha_feriado == "25-12") {
                        } else {
                            $fecha = $sig_fecha;
                            $i++;
                        }
                        $fecha = $sig_fecha;
                    }
                    $fechaFull = $fecha;
                } else {
                    $fecha = $fechaAccion;
                    $i = 0;
                    while ($i <= 6) {
                        $hoy_strtotime = strtotime($fecha);
                        $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                        $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                        $sig_fecha_dia = date('D', $sig_strtotime);
                        $sig_fecha_feriado = date('d-m', $sig_strtotime);
                        if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                            $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                            $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                            $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                            $sig_fecha_feriado == "25-12") {
                        } else {
                            $fecha = $sig_fecha;
                            $i++;
                        }
                        $fecha = $sig_fecha;
                    }
                    $fechaFull = $fecha;
                }
            }
        } else {
            $dataError['ERROR'] = array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.'
            );
            if ($dataError != null) {
                echo json_encode($dataError);
            } else {
                echo json_encode(array());
            }
            exit;
        }
        $dataUpdateLote = array(
            'idCliente' => $last_id,
            'idStatusContratacion' => 1,
            'idMovimiento' => 31,
            'comentario' => 'OK',
            'usuario' => $datosView->id_usuario,
            'perfil' => 'caja',
            'modificado' => date('Y-m-d h:i:s'),
            'fechaVenc' => $fechaFull,
            'IdStatusLote' => 3
        );
        ////////////////// VENTA DE PARTICULARES
        $vp = $this->caja_model_outside->validatep($id_lote);
        $vp_v = ($vp == 1) ? TRUE : FALSE;
        if ($vp_v == TRUE) {

            $datap = array(
                'tipo_venta' => 1
            );
            $dataUpdateLote = array_merge($dataUpdateLote, $datap);
        } else {

        }
        //if (!isset($datosView->lotes[0]->tipo_lote)) {
        if (isset($datosView->lotes[0]->tipo_lote)) {
            $val_tl = $datosView->lotes[0]->tipo_lote;
        }
        //$val_tl = $datosView->lotes[0]->tipo_lote;
        if (!isset($val_tl)) {
        } else {
            $casasDetail = $this->db->query("SELECT (l.sup * l.precio) total_terreno, c.casasDetail, c.aditivas_extra FROM lotes l 
                INNER JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail, aditivas_extra
                FROM casas WHERE estatus = 1) c ON c.id_lote = l.idLote WHERE l.idLote = $id_lote AND l.status = 1")->result_array();
            $cd = json_decode(str_replace("'", '"', $casasDetail[0]['casasDetail']));
            $info = $this->caja_model_outside->getDatosLote($id_lote);
            if ($datosView->lotes[0]->tipo_lote == 'STELLA') {
                $tipo_casa = 2;
                $nl = $datosView->lotes[0]->nombre;
                $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
                foreach ($cd->tipo_casa as $value) {
                    if ($value->nombre == 'Stella') {
                        $total_construccion = $value->total_const;
                        if($casasDetail[0]['aditivas_extra'] == 1){
                            foreach ($value->extras as $v) { // MJ: SE LEEN LAS CARACTERÍSTICAS EXTRAS QUE LLEGUE A TENER LA CASA
                                $total_construccion += $v->techado;
                            }
                        }
                    }
                }
                $total = $info->total_t;
                $dataUpdateLote2 = array(
                    'total' => ($total + $total_construccion),
                    'enganche' => (($total + $total_construccion) * 0.1),
                    'saldo' => ($total + $total_construccion) - (($total + $total_construccion) * 0.1)
                );
            }
            else if ($datosView->lotes[0]->tipo_lote == 'AURA') {
                $tipo_casa = 1;
                $nl = $datosView->lotes[0]->nombre;
                $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
                foreach ($cd->tipo_casa as $value) {
                    if ($value->nombre == 'Aura') {
                        $total_construccion = $value->total_const;
                        if($casasDetail[0]['aditivas_extra'] == 1){
                            foreach ($value->extras as $v) { // MJ: SE LEEN LAS CARACTERÍSTICAS EXTRAS QUE LLEGUE A TENER LA CASA
                                $total_construccion += $v->techado;
                            }
                        }
                    }
                }
                $total = $info->total_t;
                $dataUpdateLote2 = array(
                    'total' => ($total + $total_construccion),
                    'enganche' => (($total + $total_construccion) * 0.1),
                    'saldo' => ($total + $total_construccion) - (($total + $total_construccion) * 0.1)
                );
            }
            else if ($datosView->lotes[0]->tipo_lote == 'TERRENO') {
                $tipo_casa = 0;
                $t = (($info->precio + 500) * $info->sup);
                $e = ($t * 0.1);
                $s = ($t - $e);
                $m2 = ($t / $info->sup);
                $dataUpdateLote2 = array(
                    'total' => $t,
                    'enganche' => $e,
                    'saldo' => $s,
                    'precio' => $m2
                );
            }
            $dataUpdateLote = array_merge($dataUpdateLote, $dataUpdateLote2);

            $updateData = array(
                "tipo_casa" => $tipo_casa
            );
            $result = $this->General_model->updateRecord("clientes", $updateData, "id_cliente", $last_id);//se actualiza el cliente
        }
        $validateLote = $this->caja_model_outside->validate($id_lote);
        ($validateLote == 1) ? TRUE : FALSE;
        if ($validateLote == TRUE) {
            if ($this->caja_model_outside->addClientToLote($id_lote, $dataUpdateLote)) {
            } else {
                $dataError['ERROR'] = array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.'
                );
                if ($dataError != null) {
                    echo json_encode($dataError);
                } else {
                    echo json_encode(array());
                }
                exit;
            }
        } else {
            $dataError['ERROR'] = array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error, el lote no esta disponible 2'
            );
            if ($dataError != null) {
                echo json_encode($dataError);
            } else {
                echo json_encode(array());
            }
            exit;
        }
        /*termina la actualizacion del cliente*/
        $dataInsertHistorialLote = array(
            'nombreLote' => $data['condominio'][0]['nombreLote'],
            'idStatusContratacion' => 1,
            'idMovimiento' => 31,
            'modificado' => date('Y-m-d h:i:s'),
            'fechaVenc' => date('Y-m-d h:i:s'),
            'idLote' => $data['condominio'][0]['idLote'],
            'idCondominio' => $data['condominio'][0]['idCondominio'],
            'idCliente' => $last_id,
            'usuario' => $datosView->id_usuario,
            'perfil' => 'caja',
            'comentario' => 'OK',
            'status' => 1
        );
        /*insertar historial lotes*/
        if ($this->caja_model_outside->insertLotToHist($dataInsertHistorialLote)) {
            /*$logFile = fopen($_SERVER['DOCUMENT_ROOT']."/logs/log-insert-HL.txt", 'a') or die("Error creando archivo");
            fwrite($logFile, "\n".date("Y-m-d h:i:s")." El usuario: ".$currentUSer." ha añadido a el Lote con ID: ".$data['condominio'][0]['idLote']) or die("Error escribiendo en el archivo");
            fclose($logFile);*/
        } else {
            $dataError['ERROR'] = array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.'
            );
            if ($dataError != null) {
                echo json_encode($dataError);
            } else {
                echo json_encode(array());
            }
            exit;
        }
        /*termina la insersión de historial documento*/
        /*Si es persona moral o fisica e sla documentacion que va a insertar*/
        if ($data['prospecto'][0]['personalidad_juridica'] == 1) {
            $dataDocs = $this->caja_model_outside->getDocsByType(32);
            //print_r($dataDocs);
            $dataDC = array();
            for ($i = 0; $i < count($dataDocs); $i++) {
                $dataDC[$i]['id_opcion'] = $dataDocs[$i]['id_opcion'];
                $dataDC[$i]['id_catalogo'] = $dataDocs[$i]['id_catalogo'];
                $dataDC[$i]['nombre'] = $dataDocs[$i]['nombre'];
                $dataDC[$i]['estatus'] = $dataDocs[$i]['estatus'];
                $dataDC[$i]['fecha_creacion'] = $dataDocs[$i]['fecha_creacion'];
                $dataDC[$i]['creado_por'] = $dataDocs[$i]['creado_por'];

                
                $dataInsertHistorialDocumento = array(
                    'movimiento' => $dataDC[$i]['nombre'],/*nombre comp del mov*/
                    'modificado' => date('Y-m-d H:m:i'),/*date ahorita*/
                    'idCliente' => $last_id,/*id cliente*/
                    'idCondominio' => $data['condominio'][0]['idCondominio'],
                    'idLote' => $data['condominio'][0]['idLote'],
                    'tipo_doc' => $dataDC[$i]['id_opcion']/*tipo num*/
                );

                $this->caja_model_outside->insertDocToHist($dataInsertHistorialDocumento);
            }

        } elseif ($data['prospecto'][0]['personalidad_juridica'] == 2 || $data['prospecto'][0]['personalidad_juridica'] == 3) {
            /*Es persona fisica*/
            $dataDocs = $this->caja_model_outside->getDocsByType(31);
            $dataDC = array();
            for ($i = 0; $i < count($dataDocs); $i++) {
                $dataDC[$i]['id_opcion'] = $dataDocs[$i]['id_opcion'];
                $dataDC[$i]['id_catalogo'] = $dataDocs[$i]['id_catalogo'];
                $dataDC[$i]['nombre'] = $dataDocs[$i]['nombre'];
                $dataDC[$i]['estatus'] = $dataDocs[$i]['estatus'];
                $dataDC[$i]['fecha_creacion'] = $dataDocs[$i]['fecha_creacion'];
                $dataDC[$i]['creado_por'] = $dataDocs[$i]['creado_por'];
                $dataInsertHistorialDocumento = array(
                    'movimiento' => $dataDocs[$i]['nombre'],/*nombre comp del mov*/
                    'modificado' => date('Y-m-d H:m:i'),/*date ahorita*/
                    'idCliente' => $last_id,/*id cliente*/
                    'idCondominio' => $data['condominio'][0]['idCondominio'],
                    'idLote' => $data['condominio'][0]['idLote'],
                    'tipo_doc' => $dataDocs[$i]['id_opcion']/*tipo num*/
                );
                
                $this->caja_model_outside->insertDocToHist($dataInsertHistorialDocumento);
                
            }
        }

        /***************************************/
        $this->actualizaProspecto($id_prospecto);
        $response['Titulo'] = 'Prospecto - cliente';
        $response['resultado'] = TRUE;
        $response['message'] = 'Proceso realizado correctamente ' . date('y-m-d H:i:s');
        $response['id_cliente'] = $last_id;
        echo json_encode($response);
    }

    function addEvidenceToEvidencia_cliente($id_cliente, $id_prospecto)
    {
        $id_lote = $this->Asesor_model->getidLoteByClient($id_cliente);
        $id_lote = (count($id_lote) > 0) ? $id_lote[0]['idLote'] : 0;
        $data_evidencia_chat = $this->Asesor_model->getEvidenciasProspectosChat($id_prospecto);

        if (count($data_evidencia_chat) > 0) {
            $path = FCPATH . 'static/documentos/cliente/evidencia/';
            $img = $data_evidencia_chat[0]['nombre'];
            $path = str_replace('\\', '/', $path);
            if (file_exists($path . $img)) {
                //copiar el archivo
                //unlink($path_to.$img);
                $original_path = FCPATH . 'static/documentos/cliente/evidencia/';
                $original_path = str_replace('\\', '/', $original_path);
                $destino_path = FCPATH . 'static/documentos/evidencia_mktd/';
                $destino_path = str_replace('\\', '/', $destino_path);

                if (!copy($original_path . $img, $destino_path . $img)) {
                    $resp = "Error al copiar $img...\n";
                } else {
                    //$resp = 'El archivo '.$img.' existe y ha sido copiado exitosamente.';

                    //insertar evidencia_mktd e historial
                    $data_insert_evidencia = array(
                        'idCliente' => $id_cliente,
                        'idLote' => $id_lote,
                        'id_sol' => $this->session->userdata('id_usuario'),
                        'id_rolAut' => 0,
                        'estatus' => 3,
                        'evidencia' => $img,
                        'comentario_autorizacion' => 'Se ha ingresado la evidencia desde caja_outside.',
                        'fecha_creacion' => date('Y-m-d H:i:s'),
                        'estatus_particular' => 1,
                        'fecha_modificado' => date('Y-m-d H:i:s'),
                    );
                    $data_insert = $this->Asesor_model->insertEvidencia($data_insert_evidencia);
                    $last_id = $this->db->insert_id();
                    $data_insert_histEv = array(
                        'id_evidencia' => $last_id,
                        'fecha_creacion' => date('Y-m-d H:i:s'),
                        'estatus' => 3,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'evidencia' => $img,
                        "comentario_autorizacion" => 'Se ha ingresado la evidencia desde caja_outside.'
                    );
                    $data_histInsert = $this->Asesor_model->insertHistorialEvidencia($data_insert_histEv);

                    if ($data_insert > 0 AND $data_histInsert > 0) {
                        $resp = 'Se ha añadido la evidencia correctamente';
                    }
                }


            } else {
                $resp = 'El archivo ' . $img . ' no existe';
                //insertar evidencia_mktd e historial SIN IMAGEN
                $data_insert_evidencia = array(
                    'idCliente' => $id_cliente,
                    'idLote' => $id_lote,
                    'id_sol' => $this->session->userdata('id_usuario'),
                    'id_rolAut' => 0,
                    'estatus' => 3,
                    'evidencia' => $img,
                    'comentario_autorizacion' => 'Se ha ingresado la evidencia desde caja_outside.',
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'estatus_particular' => 1,
                    'fecha_modificado' => date('Y-m-d H:i:s'),
                );
                $data_insert = $this->Asesor_model->insertEvidencia($data_insert_evidencia);
                $last_id = $this->db->insert_id();
                $data_insert_histEv = array(
                    'id_evidencia' => $last_id,
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'estatus' => 3,
                    'creado_por' => $this->session->userdata('id_usuario'),
                    'evidencia' => $img,
                    "comentario_autorizacion" => 'Se ha ingresado la evidencia desde caja_outside.'
                );
                $data_histInsert = $this->Asesor_model->insertHistorialEvidencia($data_insert_histEv);

                if ($data_insert > 0 AND $data_histInsert > 0) {
                    $resp = 'Se ha añadido la evidencia correctamente';
                }
            }
            /*print_r($data_evidencia_chat);*/
        } else {
            $resp = 'No hay evidencias para este prospecto/cliente';
        }
        return $resp;
    }


    public function updateProyecto()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->idProyecto;
        $dato = array();
        $dato["nombreResidencial"] = $data->nProyecto;
        $dato["descripcion"] = $data->descripcion;
        $this->caja_model_outside->update_proyecto($id, $dato);
    }


    public function updateCluster()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id = $data->idCondominio;
        $dato = array();
        $dato["nombre"] = $data->nombre;
        $dato["idResidencial"] = $data->idProyecto;
        $dato["msni"] = $data->msni;
        $dato["idEtapa"] = $data->idEtapa;
        $dato["idDBanco"] = $data->idBanco;
        $dato["tipo_lote"] = $data->tipoLote;
        $this->caja_model_outside->update_cluster($id, $dato);
    }

    public function getReferencesList()
    {
        $data['data'] = $this->caja_model_outside->getReferencesList()->result_array();
        echo json_encode($data);
    }


    public function changeReferenceStatus()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data) && !empty($data)) {
            $dato = array(
                "estatus" => $data->estatus,
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $data->id_usuario
            );
            $response = $this->caja_model_outside->changeReferenceStatus($dato, $data->id_referencia);
            echo json_encode($response);
        }
    }


    public function saveReference()
    {

        $data = json_decode(file_get_contents("php://input"));

        if (isset($data) && !empty($data)) {
            $dato = array(
                "id_cliente" => $data->cliente,
                "nombre" => $data->name,
                "telefono" => $data->phone_number,
                "parentesco" => $data->kinship,
                "estatus" => 1,
                "fecha_creacion" => date("Y-m-d H:i:s"),
                "creado_por" => $data->id_usuario,
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $data->id_usuario,
            );
            $response = $this->caja_model_outside->saveReference($dato);
            echo json_encode($response);
        }
    }


    public function updateReference()
    {

        $data = json_decode(file_get_contents("php://input"));

        $dato = array(
            "id_cliente" => $data->id_cliente,
            "parentesco" => $data->kinship_ed,
            "nombre" => $data->name_ed,
            "telefono" => $data->phone_number_ed,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $data->id_usuario
        );
        $response = $this->caja_model_outside->updateReference($dato, $data->id_referencia);
        echo json_encode($response);
    }


    public function insertarCliente(){

        $data = json_decode(file_get_contents("php://input"));   
        
        $counter = 0;
        $res1 = array(); // SUCESS TRANSACTION
        $res2 = array(); // LOTE NO DISPONIBLE
        $res3 = array(); // ERROR AL INSERTAR EL CLIENTE
        
         foreach($data->lotes as $value) {
        
        $arreglo=array();
            
        
        
        $arreglo["idLote"]=$value->idLote;
        $arreglo["idCondominio"]=$value->idCondominio;
        
        
        $arreglo["engancheCliente"]=$value->pago;
        $arreglo["noRecibo"]=$data->pago->recibo;
        $arreglo["concepto"]=$data->concepto;
        $arreglo["fechaEnganche"]=date('Y-m-d H:i:s');
        $arreglo["usuario"]=$data->id_usuario;
        
        
        
            if($data->personalidad_juridica == 1){
        
                $arreglo["nombre"]=$data->propietarios[0]->nombre;
                $arreglo["rfc"]=$data->propietarios[0]->rfc;
                
            } else if ($data->personalidad_juridica == 2){
            
                $arreglo["nombre"]=$data->propietarios[0]->nombre;
                $arreglo["apellido_paterno"]=$data->propietarios[0]->apellido_paterno;
                $arreglo["apellido_materno"]=$data->propietarios[0]->apellido_materno;
                    
            }
                
            
        
        $arreglo["id_gerente"]=$data->asesores[0]->idGerente;
        $arreglo["id_coordinador"]=$data->asesores[0]->idCoordinador;
        $arreglo["id_asesor"]=$data->asesores[0]->idAsesor;
        $arreglo["id_subdirector"] = $data->asesores[0]->id_subdirector;
        $arreglo["id_regional"] = $data->asesores[0]->id_regional;
        $arreglo["id_regional_2"] = $data->asesores[0]->id_regional_2;    
        
        $arreglo["fechaApartado"] = date('Y-m-d H:i:s');
        $arreglo["personalidad_juridica"]=$data->personalidad_juridica;
        $arreglo["id_sede"]=$data->id_sede;
        
        
        $fechaAccion = date("Y-m-d H:i:s");
        $hoy_strtotime2 = strtotime($fechaAccion);
        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
        $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
        
        if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
         $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
         $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
         $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
         $sig_fecha_feriado2 == "25-12") {
        
        
        $fecha = $fechaAccion;
        
        $i = 0;
        while($i <= 46) {
        $hoy_strtotime = strtotime($fecha);
        $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
        $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
        $sig_fecha_dia = date('D', $sig_strtotime);
        $sig_fecha_feriado = date('d-m', $sig_strtotime);
        
        if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  } 
        $fecha = $sig_fecha;
               }
        
        
           $arreglo["fechaVencimiento"]= $fecha;
        
           }else{
        
        $fecha = $fechaAccion;
        
        $i = 0;
        while($i <= 45) {
        $hoy_strtotime = strtotime($fecha);
        $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
        $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
        $sig_fecha_dia = date('D', $sig_strtotime);
        $sig_fecha_feriado = date('d-m', $sig_strtotime);
        
        if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
         $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
         $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
         $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
         $sig_fecha_feriado == "25-12") {
           }
             else {
                    $fecha= $sig_fecha;
                     $i++;
                  } 
        $fecha = $sig_fecha;
               }
        
        
           $arreglo["fechaVencimiento"]= $fecha;
          
        
           }
        
        
        
        
        $validateLote = $this->caja_model_outside->validate($value->idLote);
        $disponibilidad =  ($validateLote==1) ? TRUE : FALSE;
        
        
        if($disponibilidad == TRUE)
        {
              $idClienteInsert = $this->caja_model_outside->insertClient($arreglo);
        
        
              if ($idClienteInsert){
                  
                  
                  ////////////////// VENTA DE PARTICULARES 
                  
                 $vp = $this->caja_model_outside->validatep($value->idLote);
                 $vp_v =  ($vp == 1) ? TRUE : FALSE;
                    
                    if($vp_v == TRUE){
                      $updateLote["tipo_venta"] = 1;
                    } else {
                    
                    }
        
                  /////////////////
        
                $updateLote=array();
                $updateLote["idStatusContratacion"]= 1;
                $updateLote["idStatusLote"]=3;
                $updateLote["idMovimiento"]=31;
                $updateLote["idCliente"]= $idClienteInsert[0]["lastId"];
                $updateLote["comentario"]= 'OK';
                $updateLote["usuario"]=$data->id_usuario;
                $updateLote["perfil"]='caja';
                $updateLote["modificado"]=date("Y-m-d H:i:s");
                if (!isset($value->tipo_lote)) {
                    
                } else {
                    
                    $info = $this->caja_model_outside->getDatosLote($value->idLote);
        
                    
                    if($value->tipo_lote == 'STELLA'){
                            
        
                        
                        if(
                            $value->nombre2 == 'CCMP-LAMAY-011' || $value->nombre2 == 'CCMP-LAMAY-021' || $value->nombre2 == 'CCMP-LAMAY-030' ||
                            $value->nombre2 == 'CCMP-LAMAY-031' || $value->nombre2 == 'CCMP-LAMAY-032' || $value->nombre2 == 'CCMP-LAMAY-045' ||
                            $value->nombre2 == 'CCMP-LAMAY-046' || $value->nombre2 == 'CCMP-LAMAY-047' || $value->nombre2 == 'CCMP-LAMAY-054' || 
                            $value->nombre2 == 'CCMP-LAMAY-064' || $value->nombre2 == 'CCMP-LAMAY-079' || $value->nombre2 == 'CCMP-LAMAY-080' ||
                            $value->nombre2 == 'CCMP-LAMAY-090' || $value->nombre2 == 'CCMP-LIRIO-010' ||
                            
                            $value->nombre2 == 'CCMP-LIRIO-10' ||
                            $value->nombre2 == 'CCMP-LIRIO-033' || $value->nombre2 == 'CCMP-LIRIO-048' || $value->nombre2 == 'CCMP-LIRIO-049' ||
                            $value->nombre2 == 'CCMP-LIRIO-067' || $value->nombre2 == 'CCMP-LIRIO-089' || $value->nombre2 == 'CCMP-LIRIO-091' ||
                            $value->nombre2 == 'CCMP-LIRIO-098' || $value->nombre2 == 'CCMP-LIRIO-100'
                        
                        ){
                            $total = $info->total;
                            $updateLote["total"]= ($total + 2029185.00);
                            $updateLote["enganche"]= ($updateLote["total"] * 0.1);
                            $updateLote["saldo"]= ($updateLote["total"] - $updateLote["enganche"]);
                            $updateLote["precio"]= ($updateLote["total"] / $info->sup);
        
                        
                        } else {
                            
                            $total = $info->total;
                            $updateLote["total"]= ($total + 2104340.00);
                            $updateLote["enganche"]= ($updateLote["total"] * 0.1);
                            $updateLote["saldo"]= ($updateLote["total"] - $updateLote["enganche"]);
                            $updateLote["precio"]= ($updateLote["total"] / $info->sup);
        
                        
                        }
                        
                        $updateLote["nombreLote"]=$value->nombre;
        
        
                    } else if($value->tipo_lote == 'AURA'){
                                        
                        if(
        
                            $value->nombre2 == 'CCMP-LAMAY-011' || $value->nombre2 == 'CCMP-LAMAY-021' || $value->nombre2 == 'CCMP-LAMAY-030' ||
                            $value->nombre2 == 'CCMP-LAMAY-031' || $value->nombre2 == 'CCMP-LAMAY-032' || $value->nombre2 == 'CCMP-LAMAY-045' ||
                            $value->nombre2 == 'CCMP-LAMAY-046' || $value->nombre2 == 'CCMP-LAMAY-047' || $value->nombre2 == 'CCMP-LAMAY-054' || 
                            $value->nombre2 == 'CCMP-LAMAY-064' || $value->nombre2 == 'CCMP-LAMAY-079' || $value->nombre2 == 'CCMP-LAMAY-080' ||
                            $value->nombre2 == 'CCMP-LAMAY-090' || $value->nombre2 == 'CCMP-LIRIO-010' ||
                            
                            $value->nombre2 == 'CCMP-LIRIO-10' ||
                            $value->nombre2 == 'CCMP-LIRIO-033' || $value->nombre2 == 'CCMP-LIRIO-048' || $value->nombre2 == 'CCMP-LIRIO-049' ||
                            $value->nombre2 == 'CCMP-LIRIO-067' || $value->nombre2 == 'CCMP-LIRIO-089' || $value->nombre2 == 'CCMP-LIRIO-091' ||
                            $value->nombre2 == 'CCMP-LIRIO-098' || $value->nombre2 == 'CCMP-LIRIO-100'
                        
                        ){
                            $total = $info->total;
                            $updateLote["total"]= ($total + 1037340.00);
                            $updateLote["enganche"]= ($updateLote["total"] * 0.1);
                            $updateLote["saldo"]= ($updateLote["total"] - $updateLote["enganche"]);
                            $updateLote["precio"]= ($updateLote["total"] / $info->sup);
        
                        } else {
                                        
                            $total = $info->total;
                            $updateLote["total"]= ($total + 1075760.00);
                            $updateLote["enganche"]= ($updateLote["total"] * 0.1);
                            $updateLote["saldo"]= ($updateLote["total"] - $updateLote["enganche"]);
                            $updateLote["precio"]= ($updateLote["total"] / $info->sup);
        
                        }
                        
                        
                        $updateLote["nombreLote"]=$value->nombre;
        
        
                    } else if($value->tipo_lote == 'TERRENO'){
                        
                            $t= (($info->precio + 500) * $info->sup);
                            $e= ($t * 0.1);
                            $s= ($t - $e);
                            $m2= ($t / $info->sup);
        
                            
                            $updateLote["total"]= $t;
                            $updateLote["enganche"]= $e;
                            $updateLote["saldo"]= $s;
                            $updateLote["precio"]= $m2;
                        
                    }
                    
                
                }
            
            date_default_timezone_set('America/Mexico_City');
            $horaActual = date('H:i:s');
            $horaInicio = date("08:00:00");
            $horaFin = date("16:00:00");
            
            if ($horaActual > $horaInicio and $horaActual < $horaFin) {
            
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
              $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            
            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
                 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                 $sig_fecha_feriado2 == "25-12") {
            
            
            
            $fecha = $fechaAccion;
            $i = 0;
                while($i <= 6) {
              $hoy_strtotime = strtotime($fecha);
              $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
              $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
              $sig_fecha_dia = date('D', $sig_strtotime);
                $sig_fecha_feriado = date('d-m', $sig_strtotime);
            
              if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
                 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                 $sig_fecha_feriado == "25-12") {
                   }
                     else {
                            $fecha= $sig_fecha;
                             $i++;
                          } 
                $fecha = $sig_fecha;
                       }
                   $updateLote["fechaVenc"]= $fecha;
        
                   }else{
            
            $fecha = $fechaAccion;
            
            $i = 0;
            
                while($i <= 5) {
            
              $hoy_strtotime = strtotime($fecha);
              $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
              $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
              $sig_fecha_dia = date('D', $sig_strtotime);
                $sig_fecha_feriado = date('d-m', $sig_strtotime);
            
              if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
                 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                 $sig_fecha_feriado == "25-12") {
                   }
                     else {
                            $fecha= $sig_fecha;
                             $i++;
                          } 
            
                $fecha = $sig_fecha;
            
                       }
            
                   $updateLote["fechaVenc"]= $fecha;
            
                   }
            
            } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
            
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
              $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            
            
            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
                 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                 $sig_fecha_feriado2 == "25-12") {
            
            $fecha = $fechaAccion;
            
            $i = 0;
            
                while($i <= 6) {
              $hoy_strtotime = strtotime($fecha);
              $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
              $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
              $sig_fecha_dia = date('D', $sig_strtotime);
                $sig_fecha_feriado = date('d-m', $sig_strtotime);
            
              if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
                 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                 $sig_fecha_feriado == "25-12") {
                   }
                     else {
                            $fecha= $sig_fecha;
                             $i++;
                          } 
            
                $fecha = $sig_fecha;
            
                       }
            
                   $updateLote["fechaVenc"]= $fecha;
            
                   }else{
            
            $fecha = $fechaAccion;
            
            $i = 0;
            
                while($i <= 6) {
              $hoy_strtotime = strtotime($fecha);
              $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
              $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
              $sig_fecha_dia = date('D', $sig_strtotime);
                $sig_fecha_feriado = date('d-m', $sig_strtotime);
            
              if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
                 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                 $sig_fecha_feriado == "25-12") {
                   }
                     else {
                            $fecha= $sig_fecha;
                             $i++;
                          } 
                $fecha = $sig_fecha;
                       }
        
                 $updateLote["fechaVenc"]= $fecha;
            
                   }
            
            }
        
        
            $nomLote = $this->caja_model_outside->getNameLote($value->idLote);
        
            
                $arreglo2=array();
                $arreglo2["idStatusContratacion"]= 1;
                $arreglo2["idMovimiento"]=31;
                $arreglo2["nombreLote"]= $nomLote->nombreLote;
                $arreglo2["comentario"]= 'OK';
                $arreglo2["usuario"]= $data->id_usuario;
                $arreglo2["perfil"]= 'caja';
                $arreglo2["modificado"]=date("Y-m-d H:i:s");
                $arreglo2["fechaVenc"]= date('Y-m-d H:i:s');
                $arreglo2["idLote"]= $value->idLote;  
                $arreglo2["idCondominio"]= $value->idCondominio;          
                $arreglo2["idCliente"]= $idClienteInsert[0]["lastId"];          
        
        
                if($data->personalidad_juridica == 1){
        
                    $tipoDoc = $this->caja_model_outside->getDocsByType(32);
                    foreach ($tipoDoc AS $arrayDocs){
                          $arrayDocs = array(
                            'movimiento' => $arrayDocs["nombre"],
                            'idCliente' => $idClienteInsert[0]["lastId"],
                            'idCondominio' => $value->idCondominio,
                            'idLote' => $value->idLote,
                            'tipo_doc' => $arrayDocs["id_opcion"]
                          );
                          $this->caja_model_outside->insertDocToHist($arrayDocs);
                    }
        
                    
                } else if ($data->personalidad_juridica == 2){
                
                    $tipoDoc = $this->caja_model_outside->getDocsByType(31);
                    foreach ($tipoDoc AS $arrayDocs){
                          $arrayDocs = array(
                            'movimiento' => $arrayDocs["nombre"],
                            'idCliente' => $idClienteInsert[0]["lastId"],
                            'idCondominio' => $value->idCondominio,
                            'idLote' => $value->idLote,
                            'tipo_doc' => $arrayDocs["id_opcion"]
                          );
                          $this->caja_model_outside->insertDocToHist($arrayDocs);
        
                    }
                        
                }
        
        
                $this->caja_model_outside->addClientToLote($value->idLote, $updateLote);
                $this->caja_model_outside->insertLotToHist($arreglo2);
         
                $count = count($data->propietarios);
                $propietarios = array_slice($data->propietarios, 1, $count);
                    foreach($propietarios as $value) {
                        $arreglo_propietarios=array();
                        if($data->personalidad_juridica == 1){
                            $arreglo_propietarios["nombre"]=$value->nombre;
                            $arreglo_propietarios["rfc"]=$value->rfc;
        
                            $arreglo_propietarios["id_cliente"]=$idClienteInsert[0]["lastId"];
        
                        } else if ($data->personalidad_juridica == 2){
                            $arreglo_propietarios["nombre"]=$value->nombre;
                            $arreglo_propietarios["apellido_paterno"]=$value->apellido_paterno;
                            $arreglo_propietarios["apellido_materno"]=$value->apellido_materno;
        
        
                            $arreglo_propietarios["id_cliente"]=$idClienteInsert[0]["lastId"];
                            $arreglo_propietarios["estatus"]=1;
                            $arreglo_propietarios["creado_por"]=$data->id_usuario;
        
                        }
                    
                      $this->caja_model_outside->insert_coopropietarios($arreglo_propietarios);
        
                    }
        
                    $countAs = count($data->asesores);
                    $asesores = array_slice($data->asesores, 1, $countAs);
                    
                        foreach($asesores as $value) {
                    
                            $arreglo_asesores=array();
                            $arreglo_asesores["id_gerente"]=$value->idGerente;
                            $arreglo_asesores["id_coordinador"]= $value->idCoordinador == $value->idAsesor ? 0 : $value->idCoordinador;
                            $arreglo_asesores["id_asesor"]=$value->idAsesor;
                            $arreglo_asesores["id_cliente"]=$idClienteInsert[0]["lastId"];
                            $arreglo_asesores["estatus"]=1;
                            $arreglo_asesores["creado_por"]=$data->id_usuario;
        
                            $this->caja_model_outside->insert_vcompartidas($arreglo_asesores);
                    
                        }
                
                $res1[$counter] = 1;
                /*$response['message'] = 'OK';
                echo json_encode($response);  */      
              }
                    else {
                        $res3[$counter] = 1;
                      /*$response['message'] = 'ERROR';
                      echo json_encode($response);*/
                    }
        
                } else {
                    $res2[$counter] = 1;
                /*$response['message'] = 'ERROR';
                echo json_encode($response);*/
              }
              $counter ++;
            }
            if (count($res1) == count($data->lotes)) { // MJ: TODOS LOS LOTES SE APARTARON BIEN
                    $response['Titulo'] = 'Apartado';
                    $response['resultado'] = TRUE;
                    $response['message'] = 'Proceso realizado correctamente ' . date('y-m-d H:i:s');
                    echo json_encode($response);
                } else if (count($res2) >= 1 && count($res3) >= 1) { // MJ: ALGUNO DE LOS LOTES TUVO UN DETALLE
                    $dataError['ERROR'] = array(
                        'titulo' => 'ERROR',
                        'resultado' => FALSE,
                        'message' => 'Error, verifica el estatus de los apartados.'
                    );
                    echo json_encode($dataError);
                } else if (count($res2) == count($data->lotes)) { // MJ: LOS LOTES NO ESTABAN DISPONIBLES A LA HORA DE APARTAR
                    $dataError['ERROR'] = array(
                        'titulo' => 'ERROR',
                        'resultado' => FALSE,
                        'message' => 'Error, lotes no disponibles a la hora de apartar.'
                    );
                    echo json_encode($dataError);
                }
                else if (count($res3) == count($data->lotes)) { // MJ: ERROR AL INSERTAR EL CLIENTE
                    $dataError['ERROR'] = array(
                        'titulo' => 'ERROR',
                        'resultado' => FALSE,
                        'message' => 'Error, no se pudo insertar el cliente.'
                    );
                    echo json_encode($dataError);
                }
        }

// FIN DE  REGISTRO DE CLIENTES TODOS LOS CLIENTES EXCEPTO DE SAN LUIS Y DE CIUDAD MADERAS SUR

    public function get_tablec()
    {
        $residencial = json_decode(file_get_contents("php://input"));
        $data = $this->caja_model_outside->table_condominio($residencial->idResidencial);

        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }


    public function getInventario()
    {
        $condominio = json_decode(file_get_contents("php://input"));
        $datos = $this->caja_model_outside->getInventario($condominio->idCondominio);
        echo json_encode($datos);
    }


    public function getEstatus()
    {
        $datos = $this->caja_model_outside->getEstatus();
        echo json_encode($datos);
    }


    public function changeEstatusLote() {
        $lote = json_decode(file_get_contents("php://input"));
        $idLote = $lote->idLote;
        $idStatusLote = $lote->idStatusLote;
        $idAsesor = $lote->idAsesor;
        $idAsesor2 = $lote->idAsesor2;
        $motivo_change_status = $lote->motivo_change_status;
        $usuario = $lote->id_usuario;
        $idInvolucrados = $lote->idInvolucrados;
        /*
            1  DISPONIBLE
            2  CONTRATADO
            6  INTERCAMBIO
            7  DIRECCIÓN
            8  BLOQUEADO
            9  CONTRATADO POR INTERCAMBIO
            10 APARTADO CASAS
            11 DONACIÓN
            12 INTERCAMBIO ESCRITURADO
        */
        $inicio = date("Y-m-01");
        $fin = date("Y-m-t");
        $getCurrentLoteStatus = $this->caja_model_outside->validateCurrentLoteStatus($idLote)->row();
        $descuentos = 0;
        /*$query_tipo_lote = "AND c.tipo_lote =".$getCurrentLoteStatus->tipo_lote;
        $query_superdicie = $getCurrentLoteStatus->sup < 200 ?  "AND sup < 200" : "AND sup >= 200";
        $desarrollos = $getCurrentLoteStatus->idResidencial;
        $getPaquetesDescuentos = $this->PaquetesCorrida_model->getPaquetes($query_tipo_lote,$query_superdicie,$desarrollos, $inicio, $fin);
        if(count($getPaquetesDescuentos) == 0 || $getPaquetesDescuentos[0]['id_paquete'] == NULL){
            $descuentos = NULL;
        }else{
            $descuentos = $getPaquetesDescuentos[0]['id_paquete'];
        }*/
        /*
        1.- consultar lotes < 200
        2.- consultar lotes >= 200
        */
        if ($getCurrentLoteStatus->idStatusLote == 2 || $getCurrentLoteStatus->idStatusLote == 3 || $getCurrentLoteStatus->idStatusLote == 99) {
            if ($getCurrentLoteStatus->idStatusLote == 2)
                echo json_encode(array("message" => "Acción no válida. El lote actualmente se encuentra CONTRATADO."), JSON_UNESCAPED_UNICODE);
            else if ($getCurrentLoteStatus->idStatusLote == 3)
                echo json_encode(array("message" => "Acción no válida. El lote actualmente se encuentra APARTADO en el estatus " . $getCurrentLoteStatus->nombreStatusContratacion), JSON_UNESCAPED_UNICODE);
            else if ($getCurrentLoteStatus->idStatusLote == 99)
                echo json_encode(array("message" => "Acción no válida. El lote se encuentra en proceso de confirmación de pago (apartado en línea)."), JSON_UNESCAPED_UNICODE);
        }
        else {
            if ($idStatusLote == 1 || $idStatusLote == 2 || $idStatusLote == 6 || $idStatusLote == 7  || $idStatusLote == 8 || $idStatusLote == 9 || $idStatusLote == 10 || $idStatusLote == 11 || $idStatusLote == 12) {
                $arreglo = array();
                $arreglo["idStatusLote"] = $idStatusLote;
                $arreglo["fecha_modst"] = date("Y-m-d H:i:s");
                $arreglo["userstatus"] = $usuario;
                $arreglo["usuario"] = $usuario;
                if ($idStatusLote == 9 || $idStatusLote == 10 || $idStatusLote == 7 || $idStatusLote == 6 || $idStatusLote == 11 || $idStatusLote == 12) {
                    $arreglo["idAsesor"] = $idAsesor;
                    $arreglo["idAsesor2"] = $idAsesor2;
                    $arreglo["observacionContratoUrgente"] = NULL;
                    $arreglo["motivo_change_status"] = $motivo_change_status;
                } else if ($idStatusLote == 8) {
                    $arreglo["idAsesor"] = $idAsesor;
                    $arreglo["idAsesor2"] = $idAsesor2;
                    $arreglo["observacionContratoUrgente"] = NULL;
                    $arreglo["motivo_change_status"] = $motivo_change_status;
                    $datos["lote"] = $this->caja_model_outside->infoBloqueos($idLote);
                    $data = array();
                    $data["idResidencial"] = $datos["lote"]->idResidencial;
                    $data["idCondominio"] = $datos["lote"]->idCondominio;
                    $data["idLote"] = $datos["lote"]->idLoteL;
                    $data["usuario"] = $usuario;
                    $data["idAsesor"] = $idAsesor;
                    $data["idAsesor2"] = $idAsesor2;
                    $update = $this->caja_model_outside->editaEstatus($idLote,$arreglo);
                    if($update == TRUE) {
                        $this->caja_model_outside->insert_bloqueos($data);
                        $response['message'] = 'El estatus del lotes ha sido modificado correctamente.';
                        echo json_encode($response);
                    } else {
                        $response['message'] = 'No se ha podido modificar el estatus, verifica la acción o vuelve a intentarlo.';
                        echo json_encode($response);
                    }
                } else if ($idStatusLote == 1) {          
                    //LIBERACIÓN DE LOTE        
                    $arreglo["idAsesor"] = NULL;
                    $arreglo["idAsesor2"] = NULL;
                    $arreglo["observacionContratoUrgente"] = NULL;
                    $arreglo["motivo_change_status"] = $motivo_change_status;
                    $arreglo['id_descuento'] = $descuentos;
                } else if ($idStatusLote == 2) {
                    $arreglo["motivo_change_status"] = $motivo_change_status;
                } 
                if ($idStatusLote != 8) {
                    $update = $this->caja_model_outside->editaEstatus($idLote, $arreglo);
                    if($update == TRUE)
                        echo json_encode(array("message" => "El estatus del lotes ha sido modificado correctamente."), JSON_UNESCAPED_UNICODE);
                    else 
                        echo json_encode(array("message" => "No se ha podido modificar el estatus, verifica la acción o vuelve a intentarlo."), JSON_UNESCAPED_UNICODE);
                }
            } else
                echo json_encode(array("message" => "Estatus no válido, verifica la acción o vuelve a intentarlo."), JSON_UNESCAPED_UNICODE);
        } 
    }

    public function getGerente()
    {
        $datos = $this->caja_model_outside->getGerente();
        echo json_encode($datos);
    }

    public function getCoordinador()
    {
        $gerente = json_decode(file_get_contents("php://input"));
        $datos = $this->caja_model_outside->getCoordinador($gerente->id_gerente);
        echo json_encode($datos);
    }

    public function getAsesor()
    {
        $coordinador = json_decode(file_get_contents("php://input"));
        $datos = $this->caja_model_outside->getAsesor($coordinador->id_coordinador);
        echo json_encode($datos);
    }

    public function getAsesorSpecial()
    {
        $datos = $this->caja_model_outside->getAsesorSpecial();
        echo json_encode($datos);
    }

//VERIFICAMOS EL ACCESO AL ASESOR MEDIANTE SU ID Y CONTRASEÑA
    public function validar_login_asesor()
    {
        $data = json_decode(file_get_contents("php://input"));
        $resultado = false;

        if (isset($data)) {
            $resultado = $this->db->query("SELECT * FROM usuarios WHERE id_usuario = " . $data->idAsesor . " AND contrasena = '" . encriptar($data->name) . "'")->num_rows() > 0;
        }

        echo json_encode(array("resultado" => $resultado));
    }

    //APARTADO EN LINEA
    function validaOnLine()
    {

        $data = json_decode(file_get_contents("php://input"));
        if ($data) {

            $resultado = FALSE;
            $recibo_pago = NULL;
            $mensaje_error = NULL;

            $token_data = array();
            if(!empty($data->token)){
                $token_data[0]['existe'] = 1;
                $token_data[0]['token'] = $data->token;

            } 

            //VERIFICAMOS LA IDENTIDAD DEL ASESOR
            if ($this->db->query("SELECT * FROM usuarios WHERE id_usuario = " . $data->idAsesor . " AND contrasena = '" . encriptar($data->name) . "'")->num_rows() > 0) {
                //VERIFICAMOS SI TODOS LOS LOTES INTERESADOS ESTAN LIBRES
                if ($this->db->query("SELECT COUNT( idLote ) disponibles FROM lotes WHERE status = 1 AND idStatusLote = 1 AND idLote IN ( " . implode(",", $data->idlotes) . " )")->row()->disponibles == COUNT($data->idlotes)) {
                    $this->db->update("lotes", array("idStatusLote" => 99, "modificado" => date('Y-m-d H:i:s')), "idLote IN ( " . implode(",", $data->idlotes) . " )");
                    //INSERCION DEL JSON DE APARTADOS A EJECUTAR.
                    $this->db->insert("json_apartado", array(
                        "id_asesor" => $data->idAsesor,
                        "id_lote" => implode(",", $data->idlotes),
                        "json" => json_encode($data)
                    ));
                    //EL MAXIMO EN UNA REFERENCIA ES ESTA 34 CARACTERES CON EL FORMATO ACTUAL QUE TENEMOS ESTAMOS LLEGANDO A LOS 21 CARACTERES
                    //EJEMPLO: ACM-12-11042021203652 (21 CARACTERES)
                    //$recibo_pago = "CONFPAGO".date('dmYHis');
                    $recibo_pago = "CONFPAGO" . date('dmYHis') . rand(0, 999);

                    //$dataLider = $this->caja_model_outside->getLider($data->asesores[0]->idGerente);

                    if ($data->asesores[0]->idCoordinador == $data->asesores[0]->idAsesor && $data->asesores[0]->idAsesor != 7092 && $data->asesores[0]->idAsesor != 6626) {
                        $voBoCoord = 0;
                    } else if ($data->asesores[0]->idCoordinador == $data->asesores[0]->idGerente && $data->asesores[0]->idAsesor != 7092 && $data->asesores[0]->idAsesor != 6626) {
                        $voBoCoord = 0;
                    } else {
                        $voBoCoord = $data->asesores[0]->idCoordinador;
                    }

                    foreach ($data->lotes as $value) {
                        $arreglo = array();


                        $arreglo["idLote"] = $value->idLote;
                        $arreglo["idCondominio"] = $value->idCondominio;
                        $arreglo["engancheCliente"] = $value->pago;
                        $arreglo["noRecibo"] = $recibo_pago;
                        $arreglo["concepto"] = "APARTADO DESDE LA PAGINA DE CIUDAD MADERAS";
                        $arreglo["fechaEnganche"] = date('Y-m-d H:i:s');
                        //PAGOS EN LINEA SIEMPRE MADARA PERSONAL _JURIDICA == 2
                        $arreglo["nombre"] = $data->propietarios->nombre;
                        $arreglo["apellido_paterno"] = $data->propietarios->apellido_paterno;
                        $arreglo["apellido_materno"] = $data->propietarios->apellido_materno;

                        $arreglo["correo"] = $data->propietarios->correo_electronico;
                        $arreglo["telefono2"] = $data->propietarios->telefono;

                        $arreglo["personalidad_juridica"] = 2;
                        
                        //INFORMACION DEL ASESOR
                        $arreglo["id_gerente"] = $data->asesores[0]->idGerente;
                        $arreglo["id_coordinador"] = $voBoCoord;
                        $arreglo["id_asesor"] = $data->asesores[0]->idAsesor;
                        $arreglo["id_sede"] = $data->asesores[0]->id_sede;
                        //INFORMACION DEL APARTADO
                        $arreglo["fechaApartado"] = date('Y-m-d H:i:s');
                        $arreglo["id_sede"] = 0;
                        $arreglo['id_subdirector'] = $data->asesores[0]->idSubdirector;
                        $arreglo['id_regional'] = $data->asesores[0]->idRegional1;
                        $arreglo['id_regional_2'] = $data->asesores[0]->idRegional2;
                        $arreglo['estructura'] = in_array($data->asesores[0]->idGerente, array(12135, 6661)) ? 1 : 0;

                        //SE OBTIENEN LAS FECHAS PARA EL TIEMPO QUE TIENE PARA CUMPLIR LOS ESTATUS EN CADA FASE EN EL SISTEMA
                        $fechaAccion = date("Y-m-d H:i:s");
                        $hoy_strtotime2 = strtotime($fechaAccion);
                        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
                        $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
                        //CALCULAMOS LA FECHA DE VENCIMIENTO
                        $fecha = $fechaAccion;

                        $i = 0;
                        $vueltas = in_array($sig_fecha_dia2, array("Sat", "Sun")) || in_array($sig_fecha_feriado2, array("01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12")) ? 46 : 45;
                        while ($i <= $vueltas) {
                            $hoy_strtotime = strtotime($fecha);
                            $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                            $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                            $sig_fecha_dia = date('D', $sig_strtotime);
                            $sig_fecha_feriado = date('d-m', $sig_strtotime);

                            if (!in_array($sig_fecha_dia, array("Sat", "Sun")) || !in_array($sig_fecha_feriado, array("01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12"))) {
                                $fecha = $sig_fecha;
                                $i++;
                            }
                            $fecha = $sig_fecha;
                        }

                        $arreglo["fechaVencimiento"] = $fecha;
                        $arreglo["flag_compartida"] = 2;
                        /*********************************************************************************************/

                        if ($this->caja_model_outside->validar_aOnline($value->idLote) == 1) {
                            $trans = $this->caja_model_outside->trasns_vo($arreglo, $data->asesores, (!isset($data->lote_casa)) ? [] : $data->lote_casa, $value->idLote, $token_data);
                            if ($trans == true) {
                                $resultado = TRUE;
                            } else {
                                $resultado = FALSE;
                                $mensaje_error = "¡Disculpe! Algún terreno se encuentra en proceso de ser apartado. 1";
                                break;
                            }
                        } else {
                            $resultado = FALSE;
                            $mensaje_error = "¡Disculpe! Algún terreno se encuentra en proceso de ser apartado. 2";
                            break;
                        }
                    } // END FOREACH
                } else {
                    $resultado = FALSE;
                    $mensaje_error = "¡Disculpe! Algún terreno se encuentra en proceso de ser apartado. 3";
                }
            } else {
                $resultado = FALSE;
                $mensaje_error = "Contraseña incorrecta. Verifique que este correcta.";
            }
            echo json_encode(array("resultado" => $resultado, "mensaje" => $mensaje_error, "folio" => $recibo_pago));
        }
    }

    function confirmarPago()
    {
        //VERIFICAMOS QUE RECIBAMOS EL PARAMETRO CORRECTO PARA REALIZAR EL APARTADO.
        $data = json_decode(file_get_contents("php://input"));

        var_dump($data);

        if ($data) {
            //MOVEMOS EL LOTE AL ESTATUS DE CONTRATADO ESTATUS 99
            $this->db->query("UPDATE lt 
        SET lt.idStatusLote = 3,
        lt.precio = (lt.total / lt.sup)
        FROM lotes lt INNER JOIN
        ( SELECT idLote FROM clientes
        WHERE clientes.noRecibo LIKE 'CONFPAGO%' AND clientes.noRecibo LIKE '%" . $data->num_operacion . "') clientes
        ON clientes.idLote = lt.idLote WHERE idStatusLote IN (99)");

            //ACTUALIZAMOS EL NUMERO DE RECIBO DEL CLIENTE PARA EL CONTROL
        $this->db->query("  UPDATE cl
        SET cl.noRecibo = '$data->folio'
        FROM clientes cl INNER JOIN ( SELECT lot.idLote, res.idResidencial FROM ( SELECT idLote, idCondominio FROM lotes ) lot
        INNER JOIN ( SELECT idCondominio, idResidencial FROM condominios ) con ON con.idCondominio = lot.idCondominio
        INNER JOIN ( SELECT idResidencial FROM residenciales ) res ON res.idResidencial = con.idResidencial ) res ON res.idLote = cl.idLote
        WHERE cl.noRecibo LIKE 'CONFPAGO%' AND cl.noRecibo LIKE '%" . $data->num_operacion . "'");

        $this->db->query("INSERT INTO logs_banco (confirmacion, fecha_creacion) VALUES ('".$data->num_operacion."', GETDATE())");

        }

    }

    /****************************************************************/

    public function getCoOwnersList()
    {

        $data = json_decode(file_get_contents("php://input"));
        $id_cliente = $data->id_cliente;


        $data = $this->caja_model_outside->getCoOwnersList($id_cliente)->result_array();
        echo json_encode($data);
    }


    public function getCoOwnerInformation($id_copropietario)
    {

        echo json_encode($this->caja_model_outside->getCoOwnerInformation($id_copropietario)->result_array());
    }


    public function saveCoOwner()
    {

        $data = json_decode(file_get_contents("php://input"));


        $data = array(
            "id_cliente" => $data->id_cliente,
            "personalidad_juridica" => $data->personalidad_juridica,
            "nombre" => $data->nombre,
            "apellido_paterno" => $data->apellido_paterno,
            "apellido_materno" => $data->apellido_materno,
            "creado_por" => $data->id_usuario

        );


        $res = $this->caja_model_outside->saveCoOwner($data);

        if ($res == 1) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }

    }


    public function updateCoOwner()
    {

        $data = json_decode(file_get_contents("php://input"));

        $id_copropietario = $data->id_copropietario;


        $dato = array(
            "nombre" => $data->nombre,
            "apellido_paterno" => $data->apellido_paterno,
            "apellido_materno" => $data->apellido_materno,
            "estatus" => $data->estatus
        );


        $res = $this->caja_model_outside->updateCoOwner($dato, $id_copropietario);

        if ($res == 1) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }


    }


    public function changeCoOwnerStatus()
    {
        if (isset($_POST) && !empty($_POST)) {
            $data = array(
                "estatus" => $this->input->post("estatus"),
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $this->session->userdata('id_usuario'),
            );
            $response = $this->caja_model_outside->changeCoOwnerStatus($data, $this->input->post("id_copropietario"));
            echo json_encode($response);
        }
    }


    public function get_sede()
    {
        echo json_encode($this->caja_model_outside->get_sede()->result_array());
    }


    function getregistrosClientes()
    {

        $dato = $this->caja_model_outside->data_cliente();

        for ($i = 0; $i < count($dato); $i++) {
            $data[$i]['id_cliente'] = $dato[$i]->id_cliente;
            $data[$i]['id_asesor'] = $dato[$i]->id_asesor;
            $data[$i]['id_coordinador'] = $dato[$i]->id_coordinador;
            $data[$i]['id_gerente'] = $dato[$i]->id_gerente;
            $data[$i]['id_sede'] = $dato[$i]->id_sede;
            $data[$i]['nombre'] = $dato[$i]->nombre;
            $data[$i]['apellido_paterno'] = $dato[$i]->apellido_paterno;
            $data[$i]['apellido_materno'] = $dato[$i]->apellido_materno;
            $data[$i]['personalidad_juridica'] = ($dato[$i]->personalidad_juridica == "") ? "N/A" : $dato[$i]->personalidad_juridica;
            $data[$i]['nacionalidad'] = ($dato[$i]->nacionalidad == "") ? "N/A" : $dato[$i]->nacionalidad;
            $data[$i]['rfc'] = ($dato[$i]->rfc == "") ? "N/A" : $dato[$i]->rfc;
            $data[$i]['curp'] = ($dato[$i]->curp == "") ? "N/A" : $dato[$i]->curp;
            $data[$i]['correo'] = ($dato[$i]->correo == "") ? "N/A" : $dato[$i]->correo;
            $data[$i]['telefono1'] = ($dato[$i]->telefono1 == "") ? "N/A" : $dato[$i]->telefono1;
            $data[$i]['telefono2'] = ($dato[$i]->telefono2 == "") ? "N/A" : $dato[$i]->telefono2;
            $data[$i]['telefono3'] = ($dato[$i]->telefono3 == "") ? "N/A" : $dato[$i]->telefono3;
            $data[$i]['fecha_nacimiento'] = ($dato[$i]->fecha_nacimiento == "") ? "N/A" : $dato[$i]->fecha_nacimiento;
            $data[$i]['lugar_prospeccion'] = ($dato[$i]->lugar_prospeccion == "") ? "N/A" : $dato[$i]->lugar_prospeccion;
            $data[$i]['medio_publicitario'] = ($dato[$i]->medio_publicitario == "") ? "N/A" : $dato[$i]->medio_publicitario;
            $data[$i]['otro_lugar'] = ($dato[$i]->otro_lugar == "") ? "N/A" : $dato[$i]->otro_lugar;
            $data[$i]['plaza_venta'] = ($dato[$i]->plaza_venta == "") ? "N/A" : $dato[$i]->plaza_venta;
            $data[$i]['tipo'] = ($dato[$i]->tipo == "") ? "N/A" : $dato[$i]->tipo;
            $data[$i]['estado_civil'] = ($dato[$i]->estado_civil == "") ? "N/A" : $dato[$i]->estado_civil;
            $data[$i]['regimen_matrimonial'] = ($dato[$i]->regimen_matrimonial == "") ? "N/A" : $dato[$i]->regimen_matrimonial;
            $data[$i]['nombre_conyuge'] = ($dato[$i]->nombre_conyuge == "") ? "N/A" : $dato[$i]->nombre_conyuge;

            $data[$i]['domicilio_particular'] = ($dato[$i]->domicilio_particular == "") ? "N/A" : $dato[$i]->domicilio_particular;
            $data[$i]['tipo_vivienda'] = ($dato[$i]->tipo_vivienda == "") ? "N/A" : $dato[$i]->tipo_vivienda;
            $data[$i]['ocupacion'] = ($dato[$i]->ocupacion == "") ? "N/A" : $dato[$i]->ocupacion;
            $data[$i]['empresa'] = ($dato[$i]->empresa == "") ? "N/A" : $dato[$i]->empresa;
            $data[$i]['puesto'] = ($dato[$i]->puesto == "") ? "N/A" : $dato[$i]->puesto;
            $data[$i]['edadFirma'] = ($dato[$i]->edadFirma == "") ? "N/A" : $dato[$i]->edadFirma;
            $data[$i]['antiguedad'] = ($dato[$i]->antiguedad == "") ? "N/A" : $dato[$i]->antiguedad;
            $data[$i]['domicilio_empresa'] = ($dato[$i]->domicilio_empresa == "") ? "N/A" : $dato[$i]->domicilio_empresa;
            $data[$i]['telefono_empresa'] = ($dato[$i]->telefono_empresa == "") ? "N/A" : $dato[$i]->telefono_empresa;
            $data[$i]['noRecibo'] = ($dato[$i]->noRecibo == "") ? "N/A" : $dato[$i]->noRecibo;
            $data[$i]['engancheCliente'] = ($dato[$i]->engancheCliente == "") ? "N/A" : $dato[$i]->engancheCliente;
            $data[$i]['concepto'] = ($dato[$i]->concepto == "") ? "N/A" : $dato[$i]->concepto;
            $data[$i]['fechaEnganche'] = ($dato[$i]->fechaEnganche == "") ? "N/A" : $dato[$i]->fechaEnganche;
            $data[$i]['idTipoPago'] = ($dato[$i]->idTipoPago == "") ? "N/A" : $dato[$i]->idTipoPago;
            $data[$i]['expediente'] = ($dato[$i]->expediente == "") ? "N/A" : $dato[$i]->expediente;
            $data[$i]['status'] = ($dato[$i]->status == "") ? "N/A" : $dato[$i]->status;
            $data[$i]['idLote'] = ($dato[$i]->idLote == "") ? "N/A" : $dato[$i]->idLote;
            $data[$i]['fechaApartado'] = ($dato[$i]->fechaApartado == "") ? "N/A" : $dato[$i]->fechaApartado;
            $data[$i]['fechaVencimiento'] = ($dato[$i]->fechaVencimiento == "") ? "N/A" : $dato[$i]->fechaVencimiento;
            $data[$i]['usuario'] = ($dato[$i]->usuario == "") ? "N/A" : $dato[$i]->usuario;
            $data[$i]['idCondominio'] = ($dato[$i]->idCondominio == "") ? "N/A" : $dato[$i]->idCondominio;
            $data[$i]['fecha_creacion'] = ($dato[$i]->fecha_creacion == "") ? "N/A" : $dato[$i]->fecha_creacion;
            $data[$i]['creado_por'] = ($dato[$i]->creado_por == "") ? "N/A" : $dato[$i]->creado_por;
            $data[$i]['fecha_modificacion'] = ($dato[$i]->fecha_modificacion == "") ? "N/A" : $dato[$i]->fecha_modificacion;
            $data[$i]['modificado_por'] = ($dato[$i]->modificado_por == "") ? "N/A" : $dato[$i]->modificado_por;
            $data[$i]['nombreCondominio'] = ($dato[$i]->nombreCondominio == "") ? "N/A" : $dato[$i]->nombreCondominio;
            $data[$i]['nombreResidencial'] = ($dato[$i]->nombreResidencial == "") ? "N/A" : $dato[$i]->nombreResidencial;
            $data[$i]['nombreLote'] = ($dato[$i]->nombreLote == "") ? "N/A" : $dato[$i]->nombreLote;
            $data[$i]['asesor'] = ($dato[$i]->asesor == "") ? "N/A" : $dato[$i]->asesor;
            $data[$i]['gerente'] = ($dato[$i]->gerente == "") ? "N/A" : $dato[$i]->gerente;
            $data[$i]['coordinador'] = ($dato[$i]->coordinador == "") ? "N/A" : $dato[$i]->coordinador;

            $data[$i]['descripcion'] = $dato[$i]->descripcion;
            $data[$i]['referencia'] = $dato[$i]->referencia;


        }
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }


    public function eddPago()
    {

        $data = json_decode(file_get_contents("php://input"));


        $id_cliente = $data->id_cliente;
        $noRecibo = $data->noRecibo;
        $engancheCliente = $data->engancheCliente;
        $concepto = $data->concepto;
        $fechaEnganche = date('Y-m-d H:i:s');
        $idTipoPago = $data->idTipoPago;
        $user = $data->usuario;
        $idLote = $data->idLote;


        $arreglo = array();
        $arreglo["engancheCliente"] = $engancheCliente;
        $arreglo["noRecibo"] = $noRecibo;
        $arreglo["idTipoPago"] = $idTipoPago;
        $arreglo["fechaEnganche"] = date('Y-m-d H:i:s');
        $arreglo["concepto"] = $concepto;

        $arregloEditaEnganche = array();
        $arregloEditaEnganche["noRecibo"] = $noRecibo;
        $arregloEditaEnganche["engancheCliente"] = $engancheCliente;
        $arregloEditaEnganche["concepto"] = $concepto;
        $arregloEditaEnganche["fechaEnganche"] = $fechaEnganche;
        $arregloEditaEnganche["idTipoPago"] = $idTipoPago;
        $arregloEditaEnganche["idCliente"] = $id_cliente;
        $arregloEditaEnganche["idLote"] = $idLote;
        $arregloEditaEnganche["usuario"] = $user;
        $arregloEditaEnganche["idLote"] = $idLote;

        $this->caja_model_outside->historial_Enganche($arregloEditaEnganche);
        $respuesta = $this->caja_model_outside->payment($id_cliente, $arreglo);


        if ($respuesta == TRUE) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }

    }

    public function getSharedSalesList()
    {

        $data = json_decode(file_get_contents("php://input"));

        $vcompartida = $this->caja_model_outside->getSharedSalesList($data->id_cliente);

        if ($vcompartida != null) {
            echo json_encode($vcompartida);
        } else {
            echo json_encode(array());
        }
    }

    public function saveSalesPartner()
    {
        $data = json_decode(file_get_contents("php://input"));
       // $dataLider = $this->caja_model_outside->getLider($data->id_gerente);

        if ($data->id_coordinador == $data->id_asesor) {
            $voBoCoord = 0;
        } else if ($data->id_coordinador == $data->id_gerente) {
            $voBoCoord = 0;
        } else {
            $voBoCoord = $data->id_coordinador;
        }


        $updateArrayData = array(
            "id_cliente" => $data->id_cliente,
            "id_asesor" => $data->id_asesor,
            "id_coordinador" => $voBoCoord,
            "id_gerente" => $data->id_gerente,
            "estatus" => 1,
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "creado_por" => $data->id_usuario,
            "id_subdirector" => $data->id_subdirector,
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $data->id_usuario,
            "id_regional" => $data->id_regional,
            "id_regional_2" => $data->id_regional_2
        );

        $clientInformation = $this->caja_model_outside->getClientInformation($data->id_cliente)->row();
        $salesPartnerInformation = $this->caja_model_outside->getSalesPartnerInformation($data->id_cliente)->result_array();

        if (COUNT($salesPartnerInformation) >= 1) { // SÍ EXISTEN REGISTROS EN VENTAS COMPARTIDAS
            // echo 'ENTRA IF DE SÍ HAY REGISTROS <br>';
            if ($clientInformation->id_asesor == $data->id_asesor) { // LOS REGISTROS SON IGUALES (ASESOR)
                $response['message'] = 'ERROR';
            } else {
                for ($i = 0; $i < COUNT($salesPartnerInformation); $i++) {
                    if ($salesPartnerInformation[$i]['id_asesor'] == $data->id_asesor) { // LOS REGISTROS SON IGUALES (ASESOR)
                        $response['message'] = 'ERROR';
                    } else {
                        $answer = $this->caja_model_outside->saveSalesPartner($updateArrayData);
                        if ($answer == 1) {
                            $response['message'] = 'SUCCESS';
                        } else {
                            $response['message'] = 'ERROR';
                        }
                    }
                }
            }
        } else { // NO EXISTEN REGISTROS EN VENTAS COMPARTIDAS
            // echo 'ENTRA ELSE DE NO HAY REGISTROS<br>';
            if ($clientInformation->id_asesor == $data->id_asesor) { // LOS REGISTROS SON IGUALES (ASESOR)
                $response['message'] = 'ERROR';
            } else {
                $answer = $this->caja_model_outside->saveSalesPartner($updateArrayData);
                if ($answer == 1) {
                    $response['message'] = 'SUCCESS';

                } else {
                    $response['message'] = 'ERROR';
                }
            }
        }
        echo json_encode($response);
    }

    public function changeSalesPartnerStatus()
    {
        $data = json_decode(file_get_contents("php://input"));

        $id_vcompartida = $data->id_vcompartida;

        $data = array(
            "estatus" => $data->estatus,
            "creado_por" => $data->id_usuario
        );
        $res = $this->caja_model_outside->changeSalesPartnerStatus($data, $id_vcompartida);

        if ($res == 1) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }


    }


    public function changeTitular() {
        $dataJson = json_decode(file_get_contents("php://input"));
        $id_cliente = $dataJson->id_cliente;
        if ($dataJson->id_gerente != null) {
            //$data['lider'] = $this->caja_model_outside->getLider($dataJson->id_gerente);
            if ($dataJson->id_asesor == $dataJson->id_coordinador)
                $id_coordinador = 0;
            else if($dataJson->id_coordinador == $dataJson->id_gerente)
                $id_coordinador = 0;
            else
                $id_coordinador = $dataJson->id_coordinador;
            $data = array(
                "id_asesor" => $dataJson->id_asesor,
                "id_coordinador" => $id_coordinador,
                "id_gerente" => $dataJson->id_gerente,
                "id_subdirector" => $dataJson->id_subdirector,
                "id_regional" => $dataJson->id_regional,
                "id_regional_2" => $dataJson->id_regional_2,
                "fecha_modificacion" => date("Y-m-d H:i:s"),
                "modificado_por" => $dataJson->id_usuario_que_modifica
            );
            $res = $this->caja_model_outside->changeTitular($data, $id_cliente);

            if ($res == 1) {
                $response['message'] = 'SUCCESS';
                echo json_encode($response);
            } else {
                $response['message'] = 'ERROR';
                echo json_encode($response);
            }

        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }

    }


    public function changeTitularName()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id_cliente = $data->id_cliente;
        $personalidad_juridica = $data->personalidad_juridica;

        $data_cliente = $this->caja_model_outside->checkTipoJuridico($id_cliente);
        $pj_info_cliente = $data_cliente->personalidad_juridica;
        $idLote = $data_cliente->idLote;

        if($personalidad_juridica != $pj_info_cliente && ($data->editar===true)){
            //se debe hacer el cambio de personalidad juridica en el árbol de documentos
            //1: Persona Moral : 32
            //2: Persona Física: 31
            $documentacion_cliente = $this->caja_model_outside->documentacionActual($id_cliente);
            $documentacion_vieja = array();
            foreach ( $documentacion_cliente as $index => $elemento) {
                if($documentacion_cliente[$index]['movimiento'] == 'COMPROBANTE DE DOMICILIO' &&
                    $documentacion_cliente[$index]['expediente'] != null){
                    array_push($documentacion_vieja, ($documentacion_cliente[$index]));
                }
                if($documentacion_cliente[$index]['movimiento'] == 'IDENTIFICACIÓN OFICIAL' &&
                    $documentacion_cliente[$index]['expediente'] != null){
                    array_push($documentacion_vieja, ($documentacion_cliente[$index]));
                }
                if($documentacion_cliente[$index]['movimiento'] == 'RECIBOS DE APARTADO Y ENGANCHE' &&
                    $documentacion_cliente[$index]['expediente'] != null){
                    array_push($documentacion_vieja, ($documentacion_cliente[$index]));
                }
                if($documentacion_cliente[$index]['movimiento'] == 'CUPÓN DE DESCUENTOS Y AUTORIZACIONES' &&
                    $documentacion_cliente[$index]['expediente'] != null){
                    array_push($documentacion_vieja, ($documentacion_cliente[$index]));
                }
                if($documentacion_cliente[$index]['movimiento'] == 'CORRIDA' &&
                    $documentacion_cliente[$index]['expediente'] != null){
                    array_push($documentacion_vieja, ($documentacion_cliente[$index]));
                }
                if($documentacion_cliente[$index]['movimiento'] == 'CARTA DOMICILIO CM' &&
                    $documentacion_cliente[$index]['expediente'] != null){
                    array_push($documentacion_vieja, ($documentacion_cliente[$index]));
                }
            }

            $nueva_documentacion = $this->caja_model_outside->nuevaDocByTP($personalidad_juridica);
            foreach ( $nueva_documentacion as $index2 => $elemento2) {
                  // Recorrer la documentacion vieja y evitar en que en la nueva se repita la vieja
                foreach ($documentacion_vieja as $index3 => $elemento3){
                    if($documentacion_vieja[$index3]['movimiento'] == $nueva_documentacion[$index2]['nombre']){
                        $nueva_documentacion[$index2]['expediente'] = $documentacion_vieja[$index3]['expediente'];
                    }
                    $nueva_documentacion[$index2]['modificado'] = $documentacion_vieja[$index3]['modificado'];
                    $nueva_documentacion[$index2]['idCliente'] = $documentacion_vieja[$index3]['idCliente'];
                    $nueva_documentacion[$index2]['idCondominio'] = $documentacion_vieja[$index3]['idCondominio'];
                    $nueva_documentacion[$index2]['idLote'] = $documentacion_vieja[$index3]['idLote'];
                    $nueva_documentacion[$index2]['idUser'] = $documentacion_vieja[$index3]['idUser'];
                    $nueva_documentacion[$index2]['id_autorizacion'] = $documentacion_vieja[$index3]['id_autorizacion'];
                    $nueva_documentacion[$index2]['estatus_validacion'] = $documentacion_vieja[$index3]['estatus_validacion'];

                }
            }

            $arrayDocumentacion = array();
            foreach ($nueva_documentacion as $documentoNuevo){
                $arrayManejo = array(
                    'movimiento' => $documentoNuevo['nombre'],
                    'expediente' => (empty($documentoNuevo['expediente'])) ? null: $documentoNuevo['expediente'],
                    'modificado' => date('Y-m-d H:i:s'),
                    'status'     => 1,
                    'idCliente'  => $id_cliente,
                    'idCondominio'=> $documentoNuevo['idCondominio'],
                    'idLote'     => $documentoNuevo['idLote'],
                    'idUser'     => $documentoNuevo['idUser'],
                    'tipo_documento' => 0,
                    'id_autorizacion' => $documentoNuevo['id_autorizacion'],
                    'tipo_doc'        => $documentoNuevo['id_opcion'],
                    'estatus_validacion' => $documentoNuevo['estatus_validacion']
                );

                array_push($arrayDocumentacion, $arrayManejo);
            }
            if(count($arrayDocumentacion)>0){
                //Deshabilitar el árbola ctual
                $deshabilitados = $this->caja_model_outside->deshabDocsByLoteCliente($idLote, $id_cliente);
                if($deshabilitados>0){
                    //insertar el nuevo árbol
                        $insertado = $this->General_model->insertBatch('historial_documento', $arrayDocumentacion);
                }
            }
        }
        

        if ($personalidad_juridica != NULL) {

            $dato = array(
                "nombre" => $data->nombre,
                "apellido_paterno" => $data->apellido_paterno,
                "apellido_materno" => $data->apellido_materno,
                "personalidad_juridica" => $data->personalidad_juridica,
                "modificado_por" => $data->creado_por
            );

            //aplicar el mismo cambios en prospecto
            $res = $this->caja_model_outside->changeTitularAll($dato, $id_cliente, $personalidad_juridica);

            /*new functions 22072021*/
            $data_request_prospecto = $this->caja_model_outside->getProspectByIdClient($id_cliente);
            $id_prospecto = $data_request_prospecto[0]['id_prospecto'];

            $request_update_prospecto = $this->caja_model_outside->updateProspectoCTN($id_prospecto, $dato);
            if ($request_update_prospecto >= 1) {
                $response['message_upd_prospecto'] = 'Se actualizó correctamente el prospecto.';
            }
            /*end new function*/
        }
        else {

            $dato = array(
                "nombre" => $data->nombre,
                "apellido_paterno" => $data->apellido_paterno,
                "apellido_materno" => $data->apellido_materno,
                "modificado_por" => $data->creado_por
            );

            $res = $this->caja_model_outside->changeTitular($dato, $id_cliente);

            /*new functions 22072021*/
            $data_request_prospecto = $this->caja_model_outside->getProspectByIdClient($id_cliente);
            $id_prospecto = $data_request_prospecto[0]['id_prospecto'];

            $request_update_prospecto =  $this->caja_model_outside->updateProspectoCTN($id_prospecto, $dato);
            if ($request_update_prospecto >= 1) {
                $response['message_upd_prospecto'] = 'Se actualizó correctamente el prospecto.';
            }
            /*end new function*/
        }
        if ($res == 1) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }
    }


    public function cancela_pago()
    {

        $data = json_decode(file_get_contents("php://input"));
        $idEnganche = $data->idEnganche;


        $dato = array();
        $dato["comentarioCancelacion"] = $data->comentarioCancelacion;
        $dato["fechaCancelacion"] = date('Y-m-d H:i:s');
        $dato["status"] = 0;
        $dato["usuario"] = $data->id_usuario;

        $res = $this->caja_model_outside->cancelaPago($idEnganche, $dato);

        if ($res == TRUE) {
            $response['message'] = 'SUCCESS';
            echo json_encode($response);
        } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
        }

    }


    public function hist_liberacion()
    {

        $data = json_decode(file_get_contents("php://input"));
        $idLote = $data->idLote;

        $response = $this->caja_model_outside->getHistLib($idLote);

        echo json_encode($response);

    }


    public function hist_pago()
    {

        $data = json_decode(file_get_contents("php://input"));
        $idLote = $data->idLote;

        $response = $this->caja_model_outside->getHistPago($idLote);

        echo json_encode($response);

    }


    public function getregistrosClientes2(){
        $data = json_decode(file_get_contents("php://input"));
        $dato = $this->caja_model_outside->data_cliente2($data->idCondominio);
        if ($dato != null)
            echo json_encode($dato);
        else
            echo json_encode(array());
    }


    public function getInventario2()
    {
        $condominio = json_decode(file_get_contents("php://input"));
        $datos = $this->caja_model_outside->getInventario2($condominio->idCondominio);
        echo json_encode($datos);
    }


    public function getInventario3()
    {
        $condominio = json_decode(file_get_contents("php://input"));
        $datos = $this->caja_model_outside->getInventario3($condominio->idCondominio, $condominio->idResidencial);
        echo json_encode($datos);
    }


    public function getDocumentosByLote()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id_lote = $data->idLote;

        $data = $this->caja_model_outside->getExpedienteAll($id_lote);

        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getProspectInformationByReference()
    {
        $reference = json_decode(file_get_contents("php://input"));
        $information = $this->Clientes_model->getProspectInformationByReference($reference->referencia);
        if ($information != null) {
            echo json_encode($information);
        } else {
            echo json_encode(array());
        }
    }

    public function getReasons()
    {
        $datos = $this->caja_model_outside->getReasons();
        echo json_encode($datos);
    }

    public function insertResidencial()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->abreviacion) || !isset($data->nombre) || !isset($data->empresa))
            echo json_encode(array("status" => 400, "error" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->abreviacion == "" || $data->nombre == "" || $data->empresa == "")
                echo json_encode(array("status" => 400, "error" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
            else {
                $insertData = array("nombreResidencial" => $data->abreviacion, "descripcion" => $data->nombre, "empresa" => $data->empresa);
                $reuslt = $this->General_model->addRecord("residenciales", $insertData);
                if ($reuslt == true)
                    echo json_encode(array("status" => 200, "error" => "El registro se ha ingresado de manera exitosa."), JSON_UNESCAPED_UNICODE);
                else
                    echo json_encode(array("status" => 400, "error" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function getEmpresasList()
    {
        echo json_encode($this->caja_model_outside->getEmpresasList());
    }

    public function updateResidencial()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->idResidencial) || !isset($data->abreviacion) || !isset($data->nombre) || !isset($data->empresa) || !isset($data->servicio_bajio))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->idResidencial == "" || $data->abreviacion == "" || $data->nombre == "" || $data->empresa == "" || $data->servicio_bajio == "")
                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
            else {
                $updateData = array(
                    "nombreResidencial" => $data->abreviacion,
                    "descripcion" => $data->nombre,
                    "empresa" => $data->empresa,
                    "servicio_bajio" => $data->servicio_bajio
                );
                $reuslt = $this->General_model->updateRecord("residenciales", $updateData, "idResidencial", $data->idResidencial);
                if ($reuslt == true)
                    echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."), JSON_UNESCAPED_UNICODE);
                else
                    echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function getEmpresasLargoList()
    {
        echo json_encode($this->caja_model_outside->getEmpresasLargoList());
    }

    public function getBancosLargoList()
    {
        echo json_encode($this->caja_model_outside->getBancosLargoList());
    }
  
    public function updateCondominio()
    {
        $data = json_decode((file_get_contents("php://input")));
        if (!isset($data->idCondominio) || !isset($data->nombre) || !isset($data->nombre_condominio) || !isset($data->abreviatura) || !isset($data->tipo_lote) || !isset($data->idEtapa) || !isset($data->idDBanco) || !isset($data->idResidencial))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->idCondominio == "" || $data->nombre == "" || $data->nombre_condominio == "" || $data->abreviatura == "" || $data->tipo_lote == "" ||
                $data->idEtapa == "" || $data->idDBanco == "" || $data->idResidencial=="")
                   echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado..."), JSON_UNESCAPED_UNICODE);
            else {
                $updateData = array(
                    "nombre" => $data->nombre,
                    "nombre_condominio" => $data->nombre_condominio,
                    "abreviatura" => $data->abreviatura,
                    "tipo_lote" => $data->tipo_lote,
                    "idEtapa" => $data->idEtapa,
                    "idDBanco" => $data->idDBanco,
                    "idResidencial" => $data->idResidencial
                );
                $reuslt = $this->General_model->updateRecord("condominios", $updateData, "idCondominio", $data->idCondominio);
                if ($reuslt == true)
                    echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."), JSON_UNESCAPED_UNICODE);
                else
                    echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function dataBankTask(){
        $data = json_decode((file_get_contents("php://input")));
        if (!isset($data->idDBanco) || !isset($data->empresa) || !isset($data->banco) || !isset($data->cuenta) || !isset($data->clabe) || !isset($data->estatus))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->idDBanco < 0 || $data->empresa == "" || $data->banco == "" || $data->cuenta == "" || $data->clabe == "" || $data->estatus == "")
                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado..."), JSON_UNESCAPED_UNICODE);
            else {
                $idDBanco = (int) $data->idDBanco;
                $data_action = array(
                    "empresa"   => $data->empresa,
                    "banco"     => $data->banco,
                    "cuenta"    => $data->cuenta,
                    "clabe"     => $data->clabe,
                    "estatus"   => $data->estatus
                );
                if($idDBanco==0)
                    $result = $this->General_model->addRecord("datosbancarios", $data_action);
                else
                    $result = $this->General_model->updateRecord("datosbancarios", $data_action, "idDBanco", $idDBanco);

                if ($result == true)
                    echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."), JSON_UNESCAPED_UNICODE);
                else
                    echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    public function getTipoLote() {
        echo json_encode($this->caja_model_outside->getTipoLote());
    }

    public function getAllSubdirector()
    {
        $datos["subdirector"] = $this->caja_model_outside->allSubdirector();
        echo json_encode($datos);
    }
    public function allUserVentas()
    {
        $datos["usuariosVentas"] = $this->caja_model_outside->allUserVentas();
        echo json_encode($datos);
    }



}
