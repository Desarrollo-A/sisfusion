<?php

use Google\Service\CloudSearch\Id;

ini_set('display_errors', 1);
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reestructura extends CI_Controller{
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reestructura_model','General_model', 'caja_model_outside', 'Contraloria_model', 'Clientes_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'permisos_sidebar', 'Formatter'));
		$this->load->helper(array('url', 'form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
		//$this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		//$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        //$this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession() {
		if($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
			redirect(base_url() . "index.php/login");
	}

	public function index(){
		$this->load->view('template/header');
		$this->load->view("template/home");
		$this->load->view('template/footer');
	}

	public function reubicarCliente(){
		$this->load->view('template/header');
        if ($this->session->userdata('id_rol') == 11) // ES ADMINISTRACIÓN
            $this->load->view("reestructura/traspasoAportaciones_view");
        else // TODOS LOS DEMÁS
            $this->load->view("reestructura/reubicarCliente_view");
	}	

    public function getListaClientesReubicar(){
        ini_set('max_execution_time', 900);
        set_time_limit(900);
        ini_set('memory_limit','2048M');
        $data = $this->Reestructura_model->getListaClientesReubicar();
        $array_final = array();
        $array_manejo = array();

        foreach ($data as $elemento){
            if($elemento['origen']==1 || $elemento['destino']==0){
                array_push($array_final, $elemento);
            }
        }
        echo json_encode($array_final, JSON_NUMERIC_CHECK);

    }

    public function getCliente($idCliente, $idLote) {
        $datCliente = $this->Reestructura_model->getDatosClienteTemporal($idLote); // MJ: BUSCA LA INFORMACIÓN EN datos_x_clientes
        $copropietarios = $this->Reestructura_model->obtenerCopropietariosReubicacion($idLote); // MJ: BUSCA COPROPIETARIOS
        if ($datCliente == '') // MJ: SINO ENCUENTRA NADA EN datos_x_clientes SE VA A TRAER LA INFORMACIÓN DE clientes
            $datCliente = $this->Reestructura_model->getCliente($idCliente);
        $datCliente->copropietarios = (count($copropietarios)>0) ? $copropietarios : array(); // MJ: SE AGREGA LA INFORMACIÓN DE copropietarios
        echo json_encode($datCliente);
    }
    
    public function getEstadoCivil(){
        $data = $this->Reestructura_model->getEstadoCivil();
        echo json_encode($data);
    }

	public function getProyectosDisponibles(){
		$idProyecto = $this->input->post('idProyecto');
		$superficie = $this->input->post('superficie');
		$flagFusion = $this->input->post('flagFusion');

        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Reestructura_model->getProyectosDisponibles($idProyecto, $superficie, $flagFusion);
        echo json_encode($data);
    }

	public function getCondominiosDisponibles(){
		$idProyecto = $this->input->post('idProyecto');
		$superficie = $this->input->post('superficie');
        $flagFusion = $this->input->post('flagFusion');

		$data = $this->Reestructura_model->getCondominiosDisponibles($idProyecto, $superficie, $flagFusion);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

	public function getLotesDisponibles(){
		$idCondominio = $this->input->post('idCondominio');
        $superficie = $this->input->post('superficie');
        $flagFusion = $this->input->post('flagFusion');
        $idProyecto = $this->input->post('idProyecto');

		$data = $this->Reestructura_model->getLotesDisponibles($idCondominio, $superficie, $flagFusion, $idProyecto);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}

	public function reestructura(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reestructura_view");
    }

	public function lista_catalogo_opciones(){
		$id_catalogo = $_POST['id_catalogo'];
		echo json_encode($this->Reestructura_model->get_catalogo_restructura($id_catalogo)->result_array());
	}

	public function insertarOpcion(){
		$idOpcion = $this->Reestructura_model->insertOpcion(100);
		$idOpcion = $idOpcion->lastId;
		$datos["id"] = $idOpcion;
		$datos["nombre"] = $_POST['inputCatalogo'];
		$datos["fecha_creacion"] = date('Y-m-d H:i:s');
		$insert = $this->Reestructura_model->nuevaOpcion($datos);
		if ($insert == TRUE) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

	public function getHistorial($idLote){
        echo json_encode($this->Reestructura_model->historialModel($idLote)->result_array());
    }

	public function validarLote(){
		$dataPost = $_POST;
		$datos["idLote"] = $dataPost['idLote'];
		$datos["opcionReestructura"] = $dataPost['opcionReestructura'];
		$datos["comentario"] = $dataPost['comentario'];
		$datos["userLiberacion"] = $this->session->userdata('id_usuario');
		$update = $this->Reestructura_model->actualizarValidacion($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		} 
	}

    public function insertarInformacionCli ($idLote) {
        $dataPost = $_POST;
        $datos["idLote"] = $dataPost['idLote'];
		$datos["nombre"] = $dataPost['nombreCli'];
		$datos["apellido_paterno"] = str_replace("'","`", $dataPost['apellidopCli']);
		$datos["apellido_materno"] = str_replace("'","`", $dataPost['apellidomCli']);
        $datos["telefono1"] = $dataPost['telefonoCli'];
        $datos["correo"] = $dataPost['correoCli'];
        $datos["domicilio_particular"] = str_replace("'", "`", $dataPost['domicilioCli']) ;
        $datos["estado_civil"] = $dataPost['estadoCli'];
        $datos["ine"] = $dataPost['ineCLi'];
        $datos["ocupacion"] = $dataPost['ocupacionCli'];
        $datos["tipo_proceso"] = $this->input->post('idStatusLote') == 17 ? 3 : 2;
        $datos["banderaProcesoUrgente"] = isset($dataPost['cmbProcesoUrgente']) ? 1 : 0;
        $datos["impresionEn"] = (int) $dataPost['impresoEn'];
        $datCliente = $this->Reestructura_model->getDatosClienteTemporal($idLote);
        $this->movimientosCopropietarios($dataPost['idLote'], $dataPost);
        if (empty($datCliente)) {
            $insert = $this->Reestructura_model->insertarCliente($datos);
            echo ($insert) ? json_encode(1) : json_encode(0);
            return;
        }
        $update = $this->General_model->updateRecord('datos_x_cliente', $datos, 'idLote', $idLote);
        echo ($update) ? json_encode(1) : json_encode(0);
    }

	public function getLotesRegistros(){
        $index_proyecto = $this->input->post('index_proyecto');
        $dato = $this->Reestructura_model->getLotesRegistros($index_proyecto);
        if ($dato != null) {
            echo json_encode($dato);
        }else{
            echo json_encode(array());
        }
    }

	public function aplicarLiberacion() {
		$dataPost = $_POST;
        $update = $this->Reestructura_model->aplicaLiberacion($dataPost);
        if ($update == TRUE)
            echo json_encode(1);
        else
            echo json_encode(0);
	}

    public function setReestructura(){
        $this->db->trans_begin();
        $esquemaAnterior = false;
        $idCliente = $this->input->post('idCliente');
        $idAsesor = $this->session->userdata('id_usuario');
        $nombreAsesor = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $idLider = $this->session->userdata('id_lider');
		$clienteAnterior = $this->General_model->getClienteNLote($idCliente)->row();
        $idClienteAnterior = $clienteAnterior->id_cliente;
        $loteAOcupar = $clienteAnterior->idLote;
        $planComision = 0;
        $checkApartado02 = $this->Reestructura_model->checkFechaApartado02($loteAOcupar);
        $fechaCambio = "2024-03-09";
        $fechaUltimoEstatus2 = $checkApartado02[0]['fechaUltimoEstatus2'];

        $ultimoEstatus2 = new DateTime($fechaUltimoEstatus2); 
        $fechaNuevoEsquema = new DateTime($fechaCambio);

        if( $ultimoEstatus2 >= $fechaNuevoEsquema){
            $lineaVenta = $this->General_model->getLider($idLider)->row();
        }
        else{
            $lineaVenta = new stdClass();
            $lineaVenta->id_subdirector = 13546;
            $lineaVenta->id_regional = 0;
            $lineaVenta->id_regional_2 = 0;
            $idLider = $checkApartado02[0]['id_gerente_asignado'];
            $esquemaAnterior = true;
        }

        $tipo_venta = $clienteAnterior->tipo_venta;
        $ubicacion = $clienteAnterior->ubicacion;

        $expediente = $this->Reestructura_model->obtenerDocumentacionPorReestructura();
        $loteNuevoInfo = $this->Reestructura_model->obtenerLotePorId($loteAOcupar);
        $documentacionActiva = $this->Reestructura_model->obtenerDocumentacionActiva($clienteAnterior->idLote, $idClienteAnterior);
        $planComision = $esquemaAnterior ? 64 : 84;

        $proceso = 3;
        $clienteNuevo = $this->copiarClienteANuevo($planComision, $clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso);
        $idClienteInsert = $clienteNuevo[0]['lastId'];

        if (!$idClienteInsert) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        $dataLiberacion = array(
            'tipoLiberacion' => 8,
            'idLote' => $loteAOcupar,
            'idClienteNuevo' => $idClienteInsert,
            'idClienteAnterior' => $idClienteAnterior
        );

        if (!$this->Reestructura_model->aplicaLiberacion($dataLiberacion)){
            $data['message'] = 'ERROR';
            echo json_encode($data);
            return;
        }

        $dataInsertHistorialLote = array(
			'nombreLote' => $clienteAnterior->nombreLote,
			'idStatusContratacion' => 1,
			'idMovimiento' => 31,
			'modificado' => date('Y-m-d h:i:s'),
			'fechaVenc' => date('Y-m-d h:i:s'),
			'idLote' => $loteAOcupar,
			'idCondominio' => $clienteAnterior->idCondominio,
			'idCliente' => $idClienteInsert,
			'usuario' => $idAsesor,
			'perfil' => 'EEC',
			'comentario' => 'OK',
			'status' => 1
        );

        $dataInsertPreprocesoLote = array(
            'idLote' => $loteAOcupar,
            'idCliente' => $idClienteInsert,
            'id_preproceso' => 6,
            'comentario' => 'SELECCIÓN FINAL EEC',
            'estatus' => 1,
            'modificado_por' => $this->session->userdata('id_usuario'),
			'fecha_modificacion' => date('Y-m-d h:i:s'),
        );
        
        if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        if (!$this->General_model->addRecord('historial_preproceso_lote', $dataInsertPreprocesoLote)) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al guardar el registro del lote.',
                'color' => 'danger'
            ));
            return;
        }

        if (!$this->copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteInsert, $loteAOcupar)) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        $dataUpdateCliente = array(
            'proceso' => $proceso
        );

        if (!$this->General_model->updateRecord("clientes", $dataUpdateCliente, "id_cliente", $idClienteAnterior)){
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }


        //Copia del cliente
        $datosClienteConfirm = $this->Reestructura_model->copiarDatosXCliente($loteAOcupar);
        $dataUpdateClienteNew = array(
            'nombre' => $datosClienteConfirm->nombre,
            'apellido_paterno' => $datosClienteConfirm->apellido_paterno,
            'apellido_materno' => $datosClienteConfirm->apellido_materno,
            'estado_civil' => $datosClienteConfirm->estado_civil,
            'domicilio_particular' => $datosClienteConfirm->domicilio_particular,
            'correo' => $datosClienteConfirm->correo,
            'telefono1' => $datosClienteConfirm->telefono1,
            'ocupacion' => $datosClienteConfirm->ocupacion,
            'modificado_por' => $this->session->userdata('id_usuario'),
            'fecha_modificacion' => date('Y-m-d h:i:s')
        );

        //Se modifican datos a los ingresados como confirmación por los gerentes ooam
        if (!$this->General_model->updateRecord("clientes", $dataUpdateClienteNew, "id_cliente", $idClienteInsert)){
            $this->db->trans_rollback();
            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        //función para actualizar la propuestas final
        if (!$this->Reestructura_model->setSeleccionPropuesta($loteAOcupar, $loteAOcupar)){
            $this->db->trans_rollback();
            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }


        $documentacionOriginal = $this->Reestructura_model->obtenerDocumentacionOriginal($clienteAnterior->personalidad_juridica);
        if (!$this->moverExpediente(
            $documentacionOriginal, $clienteAnterior->idLote, $loteAOcupar, $idClienteAnterior, $idClienteInsert,
            $expediente, $loteNuevoInfo, $documentacionActiva
        )) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        if (!$this->updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion)) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        //actualiza el parametro del preproceso
        $dataUpdateLoteO = array(
            'estatus_preproceso' => 7,
        );
        if (!$this->General_model->updateRecord("lotes", $dataUpdateLoteO, "idLote", $loteAOcupar)){
            $this->db->trans_rollback();
            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al actualizar el estatus preproceso del lote, inténtalo nuevamente.',
                'color' => 'danger'
            ));
            return;
        }


            if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        $this->db->trans_commit();
		echo json_encode(array(
            'titulo' => 'OK',
            'resultado' => TRUE,
            'message' => 'Proceso realizado correctamente.',
            'color' => 'success'
        ));
    }

    public function asignarPropuestasLotes(){
        $this->db->trans_begin();
        $idLotes = $this->input->post('idLotes');
        $idLoteOriginal = $this->input->post('idLoteOriginal');
        $statusPreproceso = $this->input->post('statusPreproceso');
        $idCliente = $this->input->post('idCliente');
        $proceso = $this->input->post('proceso');
        $totalLotes = count($idLotes);
        $flagConteo = 0;
        $statusLote=0;
        $arrayNoDisponible = '';
        $flagFusion = $this->input->post('flagFusion');
        $idProyecto = $this->input->post('idProyecto');

        $varibaleCiertoFalso = '';
        if($idProyecto == 21 || $idProyecto == 14 || $idProyecto == 22 || $idProyecto == 25){
            $varibaleCiertoFalso = true;
        }
        foreach ($idLotes as $elementoLote) { 
            $dataDisponible = $this->Reestructura_model->checarDisponibleRe($elementoLote, $idProyecto);

            if (count($dataDisponible) > 0) {
                if ($dataDisponible[0]['idLote'] == $elementoLote && ($dataDisponible[0]['idStatusLote'] == 15 || $dataDisponible[0]['idStatusLote'] == 1 || $dataDisponible[0]['idStatusLote'] == 2 || $varibaleCiertoFalso)) {//se checa que el devuelto si este en 15 y sea el que s emandó
                    $flagConteo = $flagConteo + 1;
                    $arrayNoDisponible .= '- ID LOTE: ' . $dataDisponible[0]['idLote'] . ' (' . $dataDisponible[0]['nombreLote'] . '),';
                }
            }
        }

        if ($flagConteo == $totalLotes) { //si todos estan disponibles se avanza
            $arrayLotes = array();
            $arrayLotesApartado = array();
            //AA: Se asignan propuesta por primera vez
            if ($statusPreproceso == 0) {
                if($flagFusion == 1){
                    foreach ($idLotes as $elemento){
                        $arrayLote = array(
                            "idLote" => $elemento, //lote propuesta
                            "idCliente" => 0,
                            "origen" => 0,
                            "destino" => 1,
                            "idLotePvOrigen" => $idLoteOriginal, //idLotePivote
                            "nombreLotes" => null,
                            "totalNeto2" => null,
                            "creadoPor" => $this->session->userdata('id_usuario'),
                            "fechaCreacion" => date('Y-m-d H:i:s'),
                            "modificadoPor" => null,
                            "fechaModificacion" => null,
                            "contrato" => null,
                            "corrida" => null,
                            "rescision" => null,
                        );

                        array_push($arrayLotes, $arrayLote);
                    }
                    if (!$this->General_model->insertBatch('lotesFusion', $arrayLotes)) {
                        $this->db->trans_rollback();

                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar el alta de las propuestas',
                            'color' => 'danger'));
                        return;
                    }
                }
                else{
                    foreach ($idLotes as $idLote) {
                        $arrayLote = array(
                            'idLote' => $idLoteOriginal,
                            'id_lotep' => $idLote,
                            'estatus' =>  0,//se coloca en 0 porque aun no es la oficial
                            'creado_por' => $this->session->userdata('id_usuario'),
                            'fecha_modificacion' => date("Y-m-d H:i:s"),
                            'modificado_por' => $this->session->userdata('id_usuario')
                        );

                        array_push($arrayLotes, $arrayLote);
                    }
                    if (!$this->General_model->insertBatch('propuestas_x_lote', $arrayLotes)) {
                        $this->db->trans_rollback();

                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar el alta de las propuestas',
                            'color' => 'danger'));
                        return;
                    }
                }
            }

            $lotesString = implode(",", $idLotes);
            $dataLoteDis = $this->Reestructura_model->getLotesDetail($lotesString);

            foreach ($dataLoteDis as $index => $dataLote) {
                if ( $proceso == 2 && ($dataLoteDis[$index]['idResidencial'] == 21 || $dataLoteDis[$index]['idResidencial'] == 14 || $dataLoteDis[$index]['idResidencial'] == 25 || $dataLoteDis[$index]['idResidencial'] == 22)){
                    //Reubicación en los mismos proyectos
                    $statusLote = 20;
                }
                else if( $proceso == 2 && ($dataLoteDis[$index]['idResidencial'] != 21 || $dataLoteDis[$index]['idResidencial'] != 14 || $dataLoteDis[$index]['idResidencial'] != 25 || $dataLoteDis[$index]['idResidencial'] != 22) ){
                    //Reubicación normal
                    $statusLote = 16;
                }
                else{
                    //Reestructura
                    $statusLote =  17;
                }
                $arrayLoteApartado = array(
                    'idLote' => $dataLote['idLote'],
                    //se valida que venga en reestrucura y que sea norte para colocar el nuevo statusLote
                    'idStatusLote' => $statusLote,
                    'usuario' => $this->session->userdata('id_usuario')
                );
                array_push($arrayLotesApartado, $arrayLoteApartado);
                
            }

            if (!$this->General_model->updateBatch('lotes', $arrayLotesApartado, 'idLote')) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ));
                return;
            }

            if ($flagFusion == 1) {
                //Acctualizamos preproceso para todos los lote de origen fusionados
                $arrayLoteOrigen = array();
                $arrayLotesOrigen = array();
                $idClientesOrigen = '';
                $lotesOrigen = $this->Reestructura_model->getFusion($idLoteOriginal, 1);
                foreach ($lotesOrigen as $dataLote){
                    $arrayLoteOrigen = array(
                        'idLote' => $dataLote['idLote'],
                        'estatus_preproceso' => 1,
                        'usuario' => $this->session->userdata('id_usuario')
                    );

                    $idClientesOrigen .= "'". $dataLote['idCliente'] ."', ";
                    array_push($arrayLotesOrigen, $arrayLoteOrigen);

                    $insertData[] = array(
                        "idLote" => $dataLote['idLote'],
                        "idCliente" => $idCliente,
                        "id_preproceso" => 0,
                        "comentario" => 'ASIGNACIÓN DE PROPUESTAS',
                        "estatus" => 1,
                        "modificado_por" => $this->session->userdata('id_usuario'),
                        "fecha_modificacion" => date('Y-m-d h:i:s')
                    );
                }
                
                $idCliente = substr($idClientesOrigen, 0, -2);
                $lotesOrigenUpdated = $this->General_model->updateBatch('lotes', $arrayLotesOrigen, 'idLote');
                $insert = $this->General_model->insertBatch("historial_preproceso_lote", $insertData); // insert de 0 en historial preproceso de lotes
            }
            else{
                $updateLoteOriginal = array(
                    'estatus_preproceso' => 1,
                    'usuario' => $this->session->userdata('id_usuario')
                );

                $insertData = array(
                    "idLote" => $idLoteOriginal,
                    "idCliente" => $idCliente,
                    "id_preproceso" => 0,
                    "comentario" => 'ASIGNACIÓN DE PROPUESTAS',
                    "estatus" => 1,
                    "modificado_por" => $this->session->userdata('id_usuario'),
                    "fecha_modificacion" => date('Y-m-d h:i:s')
                );
                
                $lotesOrigenUpdated = $this->General_model->updateRecord("lotes", $updateLoteOriginal, "idLote", $idLoteOriginal);
                $insert = $this->General_model->addRecord("historial_preproceso_lote", $insertData); // insert de 0 en historial preproceso de lotes
            }

            if (!$lotesOrigenUpdated) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$insert) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$this->copiarCopropietariosAnteriores($idCliente, $idLoteOriginal)) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ));
                return;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar el alta de propuestas de lotes',
                    'color' => 'danger'
                ));
                return;
            }
            $this->db->trans_commit();
            echo json_encode(array(
                'titulo' => 'OK',
                'resultado' => TRUE,
                'message' => 'Proceso realizado correctamente.',
                'color' => 'success'
            ));
        } else {
            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Lotes no disponibles ' . $arrayNoDisponible.' Verifíquelos',
                'color' => 'danger'
            ));
        }
    }

    public function setReubicacion(){
        $this->db->trans_begin();
        $idLote = $this->input->post('idLote');
        if(!isset($idLote)){
            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Debes seleccionar un lote para este proceso',
                'color' => 'danger'
            ));
            exit;
        }
        $esquemaAnterior = false;
        $flagFusion = $this->input->post('flagFusion');
        $idClienteAnterior = $this->input->post('idCliente');
        $idLoteOriginal = $this->input->post('idLoteOriginal'); // O PIVOTE
        $idAsesor = $this->session->userdata('id_usuario');
		$nombreAsesor = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $idLider = $this->session->userdata('id_lider');

        $checkApartado02 = $this->Reestructura_model->checkFechaApartado02($idLoteOriginal);
        
        $fechaCambio = "2024-03-09";
        $fechaUltimoEstatus2 = $checkApartado02[0]['fechaUltimoEstatus2'];

        $ultimoEstatus2 = new DateTime($fechaUltimoEstatus2); 
        $fechaNuevoEsquema = new DateTime($fechaCambio);

        if($ultimoEstatus2 >= $fechaNuevoEsquema){
            $lineaVenta = $this->General_model->getLider($idLider)->row();
        }
        else{
            $lineaVenta = new stdClass();
            $lineaVenta->id_subdirector = 13546;
            $lineaVenta->id_regional = 0;
            $lineaVenta->id_regional_2 = 0;
            $idLider = $checkApartado02[0]['id_gerente_asignado'];
            $esquemaAnterior = true;
        }

        $metrosGratuitos = 0;
        $total8P = 0; 
        $clienteAnterior = $this->General_model->getClienteNLote($idClienteAnterior)->row();
        $tipo_venta = $clienteAnterior->tipo_venta;
        $ubicacion = $clienteAnterior->ubicacion;
        $planComision = 0;

        if( $flagFusion == 1){
            $banderaInsertResicion = 0; $totalSupOrigen = 0; $numDestinos = 0; $totalSupDestino = 0; $numDestinos = 0; $totalSupDestino = 0; $precioM2Original = 0; $sumPrecioM2Original = 0;
            $idClientesOrigen = ''; $idLotesOrigen = ''; $idLotesDestino = '';
            $arrayUpdateCliente = array(); $arrayUpdateLoteO = array(); $arrayHistorialLoteO = array();

            $expediente = $this->Reestructura_model->obtenerDocumentacionPorReubicacion($clienteAnterior->personalidad_juridica);
            $documentacionOriginal = $this->Reestructura_model->obtenerDocumentacionOriginal($clienteAnterior->personalidad_juridica);

            $dataFusion = $this->Reestructura_model->getFusion($idLoteOriginal, 3);

            foreach ($dataFusion as $dataLote){
                if($dataLote['origen'] == 1){
                    $dataUpdateLoteO = array();
                    $dataHistorialLoteO = array();
                    $idClientesOrigen .= "'". $dataLote['idCliente'] ."', ";
                    $totalSupOrigen = $totalSupOrigen + floatval($dataLote['sup']);
                    $idLotesOrigen .= "'". $dataLote['idLote'] ."', ";

                    $dataUpdateLoteO = array(
                        'idLote' => $dataLote['idLote'],
                        'estatus_preproceso' => 7,
                    );
                    array_push($arrayUpdateLoteO, $dataUpdateLoteO);

                    $dataHistorialLoteO = array(
                        'idLote' => $dataLote['idLote'],
                        'idCliente' => $dataLote['idCliente'],
                        'id_preproceso' => 6,
                        'comentario' => 'SELECCIÓN FINAL EEC',
                        'estatus' => 1,
                        'modificado_por' => $this->session->userdata('id_usuario')
                    );
                    array_push($arrayHistorialLoteO, $dataHistorialLoteO);
                } 
                else if($dataLote['destino'] == 1){
                    $idLotesDestino .= "'". $dataLote['idLote'] ."', ";
                    $totalSupDestino = $totalSupDestino + floatval($dataLote['sup']);

                    $validateLote = $this->caja_model_outside->validate($dataLote['idLote']);
                    //Validamos que los lotes de destino estén disponibles
                    if ($validateLote == 0) {
                        echo json_encode(array(
                            'titulo' => 'FALSE',
                            'resultado' => FALSE,
                            'message' => 'Error, el lote '.$dataLote['nombreLotes'].' no está disponible',
                            'color' => 'danger'
                        ));
                        return;
                    }
                    $numDestinos = $numDestinos + 1;
                }

            }
            $idClientesOrigen = substr($idClientesOrigen, 0, -2);
            $idLotesDestino = substr($idLotesDestino, 0, -2);
            $clienteAnteriores = $this->General_model->getClienteNLote($idClientesOrigen)->result_array();
            $loteSelected = $this->Reestructura_model->getSelectedSup($idLotesDestino)->result_array();
            if( $totalSupOrigen == $totalSupDestino || $totalSupDestino < $totalSupOrigen ){
                $proceso = 5;
            }
            else{
                $metrosGratuitos = $totalSupOrigen * 0.05;
                $proceso = $totalSupDestino - $totalSupOrigen <= $metrosGratuitos ? 5 : 6;
            }

            foreach ($clienteAnteriores as $dataCliente){
                $dataUpdateCliente= array();
                if ($proceso == 6){
                    $precioM2Original = floatval($dataCliente['totalNeto2']) / floatval($dataCliente['sup']);
                    $sumPrecioM2Original = $sumPrecioM2Original + floatval($precioM2Original); 
                }

                $dataUpdateCliente = array(
                    'id_cliente' => $dataCliente['id_cliente'],
                    'proceso' => $proceso,
                );
                array_push($arrayUpdateCliente, $dataUpdateCliente);
            }

            $total8P = floatval(($totalSupDestino - $totalSupOrigen ) - $metrosGratuitos) * ($sumPrecioM2Original / count($clienteAnteriores));
            $total8P = floatval(number_format($total8P, 2, '.', ''));
            $total8P = $total8P / $numDestinos;

            $datosClienteConfirm = $this->Reestructura_model->copiarDatosXCliente($idLoteOriginal);
            $dataUpdateClienteNew = array(
                'nombre' => $datosClienteConfirm->nombre,
                'apellido_paterno' => $datosClienteConfirm->apellido_paterno,
                'apellido_materno' => $datosClienteConfirm->apellido_materno,
                'estado_civil' => $datosClienteConfirm->estado_civil,
                'domicilio_particular' => $datosClienteConfirm->domicilio_particular,
                'correo' => $datosClienteConfirm->correo,
                'telefono1' => $datosClienteConfirm->telefono1,
                'ocupacion' => $datosClienteConfirm->ocupacion,
                'modificado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion' => date('Y-m-d h:i:s')
            );
 
            $expediente = $this->Reestructura_model->obtenerDocumentacionPorReubicacion($clienteAnterior->personalidad_juridica);
            $documentacionOriginal = $this->Reestructura_model->obtenerDocumentacionOriginal($clienteAnterior->personalidad_juridica);
    
            if($esquemaAnterior){
                $planComision = $proceso == 3 ? 64 : (($proceso == 2 || $proceso == 5) ? 65 : 66);
            }
            else{
                $planComision = $proceso == 3 ? 84 : (($proceso == 2 || $proceso == 5) ? 85 : 86);
            }

            foreach ($dataFusion as $dataLote){
                if($dataLote['destino'] == 1){
                    $clienteNuevo = $this->copiarClienteANuevo($planComision, $clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $dataLote['idLote'], $dataLote['idCondominio'], $total8P);
                    $idClienteInsert = $clienteNuevo[0]['lastId'];

                    if (!$idClienteInsert) {
                        $this->db->trans_rollback();
            
                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                            'color' => 'danger'
                        ));
                        return;
                    }

                    //Se modifican datos a los ingresados como confirmación por los gerentes ooam
                    if (!$this->General_model->updateRecord("clientes", $dataUpdateClienteNew, "id_cliente", $idClienteInsert)){
                        $this->db->trans_rollback();

                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al actualizar la información del cliente nuevo con datos verificados de postventa',
                            'color' => 'danger'
                        ));
                        return;
                    }

                    if (!$this->updateLote($idClienteInsert, $nombreAsesor, $dataLote['idLote'], $tipo_venta, $ubicacion)) {
                        $this->db->trans_rollback();
            
                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                            'color' => 'danger'
                        ));
                        return;
                    }

                    $dataInsertHistorialLote = array(
                        'nombreLote' => $dataLote['nombreLoteDO'],
                        'idStatusContratacion' => 1,
                        'idMovimiento' => 31,
                        'modificado' => date('Y-m-d h:i:s'),
                        'fechaVenc' => date('Y-m-d h:i:s'),
                        'idLote' => $dataLote['idLote'],
                        'idCondominio' => $dataLote['idCondominio'],
                        'idCliente' => $idClienteInsert,
                        'usuario' => $idAsesor,
                        'perfil' => 'EEC',
                        'comentario' => 'OK',
                        'status' => 1
                    );
            
                    if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
                        $this->db->trans_rollback();
            
                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                            'color' => 'danger'
                        ));
                        return;
                    }
            
                    if (!$this->copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteInsert, $idLoteOriginal)) {
                        $this->db->trans_rollback();
            
                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                            'color' => 'danger'
                        ));
                        return;
                    }

                    if (!$this->moverExpediente($documentacionOriginal, $clienteAnterior->idLote, $dataLote['idLote'],
                        $idClienteAnterior, $idClienteInsert, $expediente, null, null, $flagFusion, $dataFusion, $banderaInsertResicion)) {
                        $this->db->trans_rollback();
            
                        echo json_encode(array(
                            'titulo' => 'ERROR',
                            'resultado' => FALSE,
                            'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                            'color' => 'danger'
                        ));
                        return;
                    }
                    $banderaInsertResicion = $banderaInsertResicion + 1;
                }
            }

            if (!$this->General_model->updateBatch('lotes', $arrayUpdateLoteO, 'idLote')) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar estatus preproceso final en lotes de origen',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$this->General_model->insertBatch('historial_preproceso_lote', $arrayHistorialLoteO)) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al insertar historial de pre proceso para los lotes de origen',
                    'color' => 'danger'
                ));
                return;
            }
            //No se realiza update en selección de propuestas
            //No se realiza función de desactivar lotes ya que todos son selecciones finales para fusión
        }
        else{
            $loteAOcupar = $this->input->post('idLote');
            $loteSelected = $this->Reestructura_model->getSelectedSup($loteAOcupar)->row();
            $idCondominio = $loteSelected->idCondominio;
            $nuevaSup = floatval($loteSelected->sup);
            $anteriorSup = floatval($clienteAnterior->sup);

            $proyectosValidacion = $this->Reestructura_model->getProyectosByIdLote($idLoteOriginal);
            $proyectosValidacion = $proyectosValidacion[0];
            if( $anteriorSup == $nuevaSup || $nuevaSup <= $anteriorSup){
                $proceso = 2;
            }
            else{
                $metrosGratuitos = $anteriorSup * 0.05;
                $proceso = $nuevaSup - $anteriorSup <= $metrosGratuitos ? 2 : 4;
            }

            if ($proceso == 4){
                $precioM2Original = floatval($clienteAnterior->totalNeto2) / floatval($clienteAnterior->sup); 
                $total8P = floatval(($nuevaSup - $anteriorSup) - $metrosGratuitos) * floatval($precioM2Original);
                $total8P = floatval(number_format($total8P, 2, '.', ''));
            }

            $validateLote = $this->caja_model_outside->validate($loteAOcupar);
            if ($validateLote == 0) {
                echo json_encode(array(
                    'titulo' => 'FALSE',
                    'resultado' => FALSE,
                    'message' => 'Error, el lote no está disponible',
                    'color' => 'danger'
                ));
                return;
            }
            
            if($esquemaAnterior){
                $planComision = $proceso == 3 ? 64 : (($proceso == 2 || $proceso == 5) ? 65 : 66);
            }
            else{
                $planComision = $proceso == 3 ? 84 : (($proceso == 2 || $proceso == 5) ? 85 : 86);
            }

            $clienteNuevo = $this->copiarClienteANuevo($planComision, $clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $loteSelected->idLote, $idCondominio, $total8P);
            $idClienteInsert = $clienteNuevo[0]['lastId'];
            if (!$idClienteInsert) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            $datosClienteConfirm = $this->Reestructura_model->copiarDatosXCliente($idLoteOriginal);
            $dataUpdateClienteNew = array(
                'nombre' => $datosClienteConfirm->nombre,
                'apellido_paterno' => $datosClienteConfirm->apellido_paterno,
                'apellido_materno' => $datosClienteConfirm->apellido_materno,
                'estado_civil' => $datosClienteConfirm->estado_civil,
                'domicilio_particular' => $datosClienteConfirm->domicilio_particular,
                'correo' => $datosClienteConfirm->correo,
                'telefono1' => $datosClienteConfirm->telefono1,
                'ocupacion' => $datosClienteConfirm->ocupacion,
                'modificado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion' => date('Y-m-d h:i:s')
            );

            //Se modifican datos a los ingresados como confirmación por los gerentes ooam
            if (!$this->General_model->updateRecord("clientes", $dataUpdateClienteNew, "id_cliente", $idClienteInsert)){
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$this->Reestructura_model->setSeleccionPropuesta($idLoteOriginal, $loteAOcupar)){
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$this->Reestructura_model->setNoSeleccionPropuesta($idLoteOriginal, $loteAOcupar)){
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción. (502)',
                    'color' => 'danger'
                ));
                return;
            }
    
            if (!$this->desactivarOtrosLotes($idLoteOriginal)) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }
    
            if (!$this->updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion)) {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$this->copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteInsert, $idLoteOriginal)) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            $dataInsertHistorialLote = array(
                'nombreLote' => $loteSelected->nombreLote,
                'idStatusContratacion' => 1,
                'idMovimiento' => 31,
                'modificado' => date('Y-m-d h:i:s'),
                'fechaVenc' => date('Y-m-d h:i:s'),
                'idLote' => $loteAOcupar,
                'idCondominio' => $idCondominio,
                'idCliente' => $idClienteInsert,
                'usuario' => $idAsesor,
                'perfil' => 'EEC',
                'comentario' => 'OK',
                'status' => 1
            );

            if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            $expediente = $this->Reestructura_model->obtenerDocumentacionPorReubicacion($clienteAnterior->personalidad_juridica);
            $documentacionOriginal = $this->Reestructura_model->obtenerDocumentacionOriginal($clienteAnterior->personalidad_juridica);
    
            if (!$this->moverExpediente($documentacionOriginal, $clienteAnterior->idLote, $loteAOcupar, $idClienteAnterior, $idClienteInsert, $expediente)) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            $dataUpdateLoteO = array(
                'estatus_preproceso' => 7,
            );

            if (!$this->General_model->updateRecord("lotes", $dataUpdateLoteO, "idLote", $idLoteOriginal)){
                $this->db->trans_rollback();
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                    'color' => 'danger'
                ));
                return;
            }

            $dataHistorialLoteO = array(
                'idLote' => $idLoteOriginal,
                'idCliente' => $idClienteAnterior,
                'id_preproceso' => 6,
                'comentario' => 'SELECCIÓN FINAL EEC',
                'estatus' => 1,
                'modificado_por' => $this->session->userdata('id_usuario')
            );

            if (!$this->General_model->addRecord('historial_preproceso_lote', $dataHistorialLoteO)) {
                $this->db->trans_rollback();
    
                echo json_encode(array(
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al insertar historial de pre proceso para el lotes de origen',
                    'color' => 'danger'
                ));
                return;
            }
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ));
            return;
        }

        $this->db->trans_commit();
		echo json_encode(array(
            'titulo' => 'OK',
            'resultado' => TRUE,
            'message' => 'Proceso realizado correctamente.',
            'color' => 'success'
        ));
	}

    public function copiarClienteANuevo($planComision, $clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $loteSelected = null, $idCondominio = null, $total8P = 0) {
        $dataCliente = [];
        $camposOmitir = ['id_cliente','nombreLote', 'sup', 'tipo_venta', 'ubicacion', 'totalNeto2'];

        foreach ($clienteAnterior as $clave => $valor) {
            if(in_array($clave, $camposOmitir)) {
                continue;
            } else if ($clave == 'id_asesor') {
                $dataCliente = array_merge([$clave => $idAsesor], $dataCliente);
                continue;
            } else if ($clave == 'id_coordinador') {
                $dataCliente = array_merge([$clave => 0], $dataCliente);
                continue;
            } else if ($clave == 'id_gerente') {
                $dataCliente = array_merge([$clave => $idLider], $dataCliente);
                continue;
            } else if ($clave == 'idLote' && $proceso != 3) {
                $dataCliente = array_merge([$clave => $loteSelected], $dataCliente);
                continue;
            } else if ($clave == 'idCondominio' && $proceso != 3) {
                $dataCliente = array_merge([$clave =>  $idCondominio], $dataCliente);
                continue;
            } else if ($clave == 'id_subdirector') {
                $dataCliente = array_merge([$clave => $lineaVenta->id_subdirector], $dataCliente);
                continue;
            } else if ($clave == 'id_regional') {
                $dataCliente = array_merge([$clave =>  $lineaVenta->id_regional], $dataCliente);
                continue;
            } else if ($clave == 'plan_comision') {
                $dataCliente = array_merge([$clave => $planComision], $dataCliente);
                continue;
            } else if ($clave == 'status') {
                $dataCliente = array_merge([$clave =>  1], $dataCliente);
                continue;
            } else if ($clave == 'proceso') {
                $dataCliente = array_merge([$clave =>  $proceso], $dataCliente);
                continue;
            } else if ($clave == 'totalNeto2Cl') {
                $dataCliente = array_merge([$clave => 0], $dataCliente);
                continue;
            } else if ($clave == 'id_cliente_reubicacion_2') {
                $dataCliente = array_merge([$clave => $clienteAnterior->id_cliente], $dataCliente);
                continue;
            } else if ($clave == 'fechaApartado'){
                $dataCliente = array_merge([$clave => date('Y-m-d H:i:s')], $dataCliente);
                continue;
            } else if ($clave == 'fechaVencimiento'){
                $dataCliente = array_merge([$clave => $this->validateVencimiento() ], $dataCliente);
                continue;
            } else if ($clave == 'fecha_creacion'){
                $dataCliente = array_merge([$clave => date('Y-m-d H:i:s')], $dataCliente);
                continue;
            } else if ($clave == 'fecha_modificacion'){
                $dataCliente = array_merge([$clave => date('Y-m-d H:i:s')], $dataCliente);
                continue;
            } else if ($clave == 'creado_por'){
                $dataCliente = array_merge([$clave => $this->session->userdata('id_usuario')], $dataCliente);
                continue;
            } else if ($clave == 'total8P'){
                $dataCliente = array_merge([$clave => $total8P], $dataCliente);
                continue;
            }

            $dataCliente = array_merge([$clave => $valor], $dataCliente);
        }

        return $this->caja_model_outside->insertClient($dataCliente);
    }

    function updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion){
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

		$dataUpdateLote = array(
            'idCliente' => $idClienteInsert,
            'idStatusContratacion' => 1,
            'idMovimiento' => 31,
            'comentario' => 'OK',
            'usuario' => $nombreAsesor,
            'perfil' => 'EEC',
            'modificado' => date('Y-m-d h:i:s'),
            'fechaVenc' => $fechaFull,
            'IdStatusLote' => 3,
            'tipo_venta' => $tipo_venta,
            'ubicacion' =>$ubicacion,
            'registro_comision' => 9
        );

        $resultLote = $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $loteAOcupar);
        return $resultLote;
    }

    function validateVencimiento(){
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
        return $fecha;
    }

    function moverExpediente(
        $documentacionOriginal, $idLoteAnterior, $idLoteNuevo, $idClienteAnterior, $idClienteNuevo, $expedienteNuevo,
        $loteInfo = null, $docInfo = null, $flagFusion=0, $dataFusion=null, $banderaInsertResicion = 0
    ): bool
    {
        $totalPropuestas = 0;
        $loteAnteriorInfo = $this->Reestructura_model->obtenerLotePorId($idLoteAnterior);
        $loteNuevoInfo = (is_null($loteInfo))
            ? $this->Reestructura_model->obtenerLotePorId($idLoteNuevo)
            : $loteInfo;
        $docAnterior = (is_null($docInfo))
            ? $this->Reestructura_model->obtenerDocumentacionActiva($idLoteAnterior, $idClienteAnterior)
            : $docInfo;
        
        if($flagFusion != 1){
            $totalPropuestas = count($this->Reestructura_model->getNotSelectedLotes($idLoteAnterior));
        }
        

        $documentacion = [];
        $modificado = date('Y-m-d H:i:s');
        $documentosSinPasar = (is_null($docInfo)) ? [7, 8, '7', '8'] : [];

        // Ciclo para vaciar ramas del expediente anterior
        foreach ($docAnterior as $doc) {
            $expedienteAnterior = in_array($doc['tipo_doc'], $documentosSinPasar) ? null : $doc['expediente'];

            if ($doc['tipo_doc'] == 7 || $doc['tipo_doc'] == 8) {
                if($flagFusion == 1){
                    $expReubicacion = $this->Reestructura_model->expedienteFusionDestino($idLoteAnterior, $idLoteNuevo);
                }
                else{
                    $expReubicacion = $this->Reestructura_model->expedienteReubicacion($idLoteAnterior);
                }
                
                $carpeta = '';

                if ($doc['tipo_doc'] == 7) {
                    $carpeta = 'CORRIDA/';
                    $expedienteAnterior = $expReubicacion->corrida;
                } else if ($doc['tipo_doc'] == 8) {
                    $carpeta = 'CONTRATO/';
                    $expedienteAnterior = $expReubicacion->contrato;
                }

                if (!is_null($expedienteAnterior)) {
                    $path = "static/documentos/contratacion-reubicacion-temp/$loteAnteriorInfo->nombreLote/$carpeta$expedienteAnterior";

                    $exist = file_exists($path);

                    $file = [
                        "tmp_name" => $path,
                    ];

                    if($exist){
                        $this->uploadFileToBucket($file, $expedienteAnterior);
                    }
                }
            }

            $documentacion[] = array(
                'movimiento' => $doc['movimiento'],
                'expediente' => $expedienteAnterior,
                'modificado' => $modificado,
                'status' => 1,
                'idCliente' => $idClienteNuevo,
                'idCondominio' => $loteNuevoInfo->idCondominio,
                'idLote' => $idLoteNuevo,
                'idUser' => NULL,
                'tipo_documento' => 0,
                'id_autorizacion' => 0,
                'tipo_doc' => $doc['tipo_doc'],
                'estatus_validacion' => 0,
                'bucket' => 1,
            );
        }

        // Crear las ramas extras que no se tengan en el expediente anterior
        foreach ($documentacionOriginal as $doc) {
            $index = in_array($doc['id_opcion'], array_column($documentacion, 'tipo_doc'));

            if ($index !== false) {
                continue;
            }

            $documentacion[] = array(
                'movimiento' => $doc['nombre'],
                'expediente' => null,
                'modificado' => $modificado,
                'status' => 1,
                'idCliente' => $idClienteNuevo,
                'idCondominio' => $loteNuevoInfo->idCondominio,
                'idLote' => $idLoteNuevo,
                'idUser' => NULL,
                'tipo_documento' => 0,
                'id_autorizacion' => 0,
                'tipo_doc' => $doc['id_opcion'],
                'estatus_validacion' => 0,
                'bucket' => 0,
            );
        }

        $a = 0;
        // Ciclo para las nuevas ramas a agregar

        foreach ($expedienteNuevo as $doc) {
            $banderainterna = 1;//para que pueda hacer el salto de archivos dentro de los ciclos
            if ($doc['id_opcion'] == 33 || $doc['id_opcion'] == 35) { //archivos a tomar en cuenta
                if($flagFusion == 1){ //si son fusiones
                    foreach ($dataFusion as $dataLote){//recorre el arreglo de los lotes fusionados
                        if($dataLote['destino'] == 1 && $banderaInsertResicion==0 ){//Revisa que solo pase una vez de todos los destinos
                            foreach ($dataFusion as $dataLote1 => $elemento){//vuelve a recorrer el arreglo de fusion para sacar los lotes de origen
                                if($elemento['origen'] == 1 && $banderainterna <= $dataLote['originales']
                                    && ($doc['id_opcion'] == 33 || $doc['id_opcion'] == 35)){ //dentro del primer destino inserta las ramas para resicion de contrato dependiendo los lotes de origen

                                        if($doc['id_opcion'] == 33){
                                            $nombreLoteOrigen = $elemento['nombreLotes'];
                                            $nombreResLoteOrigen = $elemento['rescision'];

                                            $path = "static/documentos/contratacion-reubicacion-temp/$nombreLoteOrigen/RESCISIONES/$nombreResLoteOrigen";

                                            $exist = file_exists($path);

                                            $file = [
                                                "tmp_name" => $path,
                                            ];

                                            if($exist){
                                                $this->uploadFileToBucket($file, $nombreResLoteOrigen);
                                            }
                                        }

                                        $documentacion[] = array(
                                            'movimiento' => $doc['nombre'],
                                            'expediente' => ($doc['id_opcion'] == 33) ? $elemento['rescision'] : null,
                                            'modificado' => $modificado,
                                            'status' => 1,
                                            'idCliente' => $idClienteNuevo,
                                            'idCondominio' => $loteNuevoInfo->idCondominio,
                                            'idLote' => $idLoteNuevo,
                                            'idUser' => NULL,
                                            'tipo_documento' => 0,
                                            'id_autorizacion' => 0,
                                            'tipo_doc' => $doc['id_opcion'],
                                            'estatus_validacion' => 0,
                                            'bucket' => 1,
                                        );
                                }
                                $banderainterna = $banderainterna + 1;
                            }
                            continue;//continua con las ramas de los demás lotes de propuesta y que no se les insertara nada de fusion
                            $nombreLoteOrigen = $dataLote['nombreLotes'];
                            $nombreResLoteOrigen = $dataLote['rescision'];

                                $path = "static/documentos/contratacion-reubicacion-temp/$nombreLoteOrigen/RESCISIONES/$nombreResLoteOrigen";

                                $exist = file_exists($path);

                                $file = [
                                    "tmp_name" => $path,
                                ];

                                if($exist){
                                    $this->uploadFileToBucket($file, $nombreResLoteOrigen);
                                }

                                $documentacion[] = array(
                                    'movimiento' => $doc['nombre'],
                                    'expediente' => $expedienteAnterior,
                                    'modificado' => $modificado,
                                    'status' => 1,
                                    'idCliente' => $idClienteNuevo,
                                    'idCondominio' => $loteNuevoInfo->idCondominio,
                                    'idLote' => $idLoteNuevo,
                                    'idUser' => NULL,
                                    'tipo_documento' => 0,
                                    'id_autorizacion' => 0,
                                    'tipo_doc' => $doc['id_opcion'],
                                    'estatus_validacion' => 0,
                                    'bucket' => 1,
                                );
                                continue;

                        }
                    }
                }
                else{
                    $expRescision = $this->Reestructura_model->obtenerDatosClienteReubicacion($idLoteAnterior);

                    $path = "static/documentos/contratacion-reubicacion-temp/$loteAnteriorInfo->nombreLote/RESCISIONES/$expRescision->rescision";

                    $exist = file_exists($path);

                    $file = [
                        "tmp_name" => $path,
                    ];

                    if($exist){
                        $this->uploadFileToBucket($file, $expRescision->rescision);
                    }
    
                    $documentacion[] = array(
                        'movimiento' => $doc['nombre'],
                        'expediente' => $expRescision->rescision,
                        'modificado' => $modificado,
                        'status' => 1,
                        'idCliente' => $idClienteNuevo,
                        'idCondominio' => $loteNuevoInfo->idCondominio,
                        'idLote' => $idLoteNuevo,
                        'idUser' => NULL,
                        'tipo_documento' => 0,
                        'id_autorizacion' => 0,
                        'tipo_doc' => $doc['id_opcion'],
                        'estatus_validacion' => 0,
                        'bucket' => 1,
                    );
    
                    continue;
                }
            }

            // Corrida, contrato
            if ($doc['id_opcion'] == 39 || $doc['id_opcion'] == 40) {
                $tipoDoc = 0;
                if ($doc['id_opcion'] == 39) {
                    $tipoDoc = 7;
                } else if ($doc['id_opcion'] == 40) {
                    $tipoDoc = 8;
                }

                $index = array_search($tipoDoc, array_column($docAnterior, 'tipo_doc'));

                $documentacion[] = array(
                    'movimiento' => $doc['nombre'],
                    'expediente' => $docAnterior[$index]['expediente'],
                    'modificado' => $modificado,
                    'status' => 1,
                    'idCliente' => $idClienteNuevo,
                    'idCondominio' => $loteNuevoInfo->idCondominio,
                    'idLote' => $idLoteNuevo,
                    'idUser' => NULL,
                    'tipo_documento' => 0,
                    'id_autorizacion' => 0,
                    'tipo_doc' => $doc['id_opcion'],
                    'estatus_validacion' => 0,
                    'bucket' => 1,
                );

                continue;
            }

            if ($doc['id_opcion'] == 42 && $totalPropuestas === 0) {
                continue;
            }
            if ($doc['id_opcion'] == 43 && $totalPropuestas <= 1) {
                continue;
            }

            if($doc['id_opcion'] != 33){
                if( $doc['id_opcion'] != 35){
                    $documentacion[] = array(
                        'movimiento' => $doc['nombre'],
                        'expediente' => NULL,
                        'modificado' => $modificado,
                        'status' => 1,
                        'idCliente' => $idClienteNuevo,
                        'idCondominio' => $loteNuevoInfo->idCondominio,
                        'idLote' => $idLoteNuevo,
                        'idUser' => NULL,
                        'tipo_documento' => 0,
                        'id_autorizacion' => 0,
                        'tipo_doc' => $doc['id_opcion'],
                        'estatus_validacion' => 0,
                        'bucket' => 0,
                    );
                }
            }
        }

        foreach ($documentacion as $key => $documento) {
            $documento = (object) $documento;
            if($documento->expediente){
                //$docAnterior[$index]['expediente'];
                $path = "static/documentos/cliente/expediente/" . $documento->expediente;

                $exist = file_exists($path);

                $file = [
                    "tmp_name" => $path,
                ];

                if($exist){
                    $this->uploadFileToBucket($file, $documento->expediente);
                }
            }
        }

        return $this->General_model->insertBatch('historial_documento', $documentacion);
    }

    public function copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteNuevo, $idLote): bool
    {
        $dsAnterior = $this->Reestructura_model->obtenerDSPorIdCliente($idClienteAnterior);
        $residencial = $this->Reestructura_model->obtenerResidencialPorIdCliente($idClienteNuevo);
        $copropietarios = $this->Reestructura_model->obtenerCopropietariosReubicacion($idLote);
        $dsData = [];
        $copropietariosData = [];

        foreach ($dsAnterior as $clave => $valor) {
            if(in_array($clave, ['id', 'id_cliente', 'clave'])) {
                continue;
            }

            if ($clave == 'proyecto') {
                $dsData = array_merge([$clave => $residencial->nombreResidencial], $dsData);
                continue;
            }

            $dsData = array_merge([$clave => $valor], $dsData);
        }

        foreach ($copropietarios as $coopropietario) {
            $dataTmp = [];

            foreach ($coopropietario as $clave => $valor) {
                if (in_array($clave, ['id_dxcop', 'idLote'])) {
                    continue;
                }

                $dataTmp = array_merge([$clave => $valor], $dataTmp);
            }

            $copropietariosData[] = array_merge($dataTmp, [
                'id_cliente' => $idClienteNuevo,
                'creado_por' => $dataTmp['modificado_por'],
                'fecha_creacion' => date('Y-m-d H:i:s')
            ]);
        }

        $resultDs = $this->General_model->updateRecord('deposito_seriedad', $dsData, 'id_cliente', $idClienteNuevo);
        $resultCop = empty($copropietariosData) || $this->General_model->insertBatch('copropietarios', $copropietariosData);

        return $resultDs && $resultCop;
    }

	// PARA EL MÓDULO DE ALEJANDRO
    public function cancelarLotes() {
		$this->load->view('template/header');
        $this->load->view("reestructura/cancelacion_view");
    }

	public function getregistrosLotes() {
        $id_proyecto = $this->input->post('index_proyecto');

        if ($this->session->userdata('id_usuario') == 13546) {
            $union = "UNION ALL
                SELECT re.idResidencial, re.nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.estatus_preproceso, lo.idCliente, lo.sup superficie, FORMAT(lo.precio, 'C') precio, 
                    CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) END nombreCliente, 
                    lo.observacionLiberacion AS observacion, CASE WHEN lo.liberaBandera = 1 THEN 'LIBERADO' ELSE 'SIN LIBERAR' END estatusLiberacion,
                    lo.liberaBandera, lo.idStatusLote, '1' as consulta
                FROM lotes lo 
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial IN ($id_proyecto)
                    LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente
                WHERE 
                    lo.status = 1
                AND (lo.estatus_preproceso != 7 AND lo.liberaBandera = 1 AND lo.idStatusLote IN (2, 3) )";
        }else {
            $union = "";
        }
        
        $dato = $this->Reestructura_model->getLotes($union);
        if ($dato != null)
            echo json_encode($dato);
        else
            echo json_encode(array());
    }

    public function obtenerClientePorId($idCliente)
    {
        $cliente = $this->Reestructura_model->obtenerClientePorId($idCliente);
        echo json_encode($cliente);
    }

    public function lotesEstatusSeisSinTraspaso(){
        $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("reestructura/lotesEstatusSeisSinTraspaso_view");
    }

    public function getLotesEstatusSeisSinTraspaso(){
        $data = $this->Reestructura_model->getLotesEstatusSeisSinTraspaso()->result_array();
        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function asignacionCartera(){
		$this->load->view('template/header');
        $this->load->view("reestructura/asignacionCartera_view");
	}	

    public function getListaAsignacionCartera(){
        $data = $this->Reestructura_model->getListaAsignacionCartera();
        echo json_encode($data);
    }

    public function getListaUsuariosParaAsignacion() {
        echo json_encode($this->Reestructura_model->getListaUsuariosParaAsignacion());
    }

    public function setAsesor() {
	    $idFusion = $this->input->post('idFusion');
        $idAsesorAsignado = $this->input->post('idAsesor');
        $lineaVenta = $this->Reestructura_model->lineaVenta($idAsesorAsignado)->row();
	    if($idFusion==1){
            $idLote = $this->input->post('idLote');
            $lotesFusionados = explode(",", $idLote);
            $flagEsatus = 0;
            foreach ($lotesFusionados as $elemento){
                $updateData = array(
                    "id_usuario_asignado" => $idAsesorAsignado,
                    "id_gerente_asignado" =>  $lineaVenta->id_gerente,
                    "id_subdirector_asignado" => $lineaVenta->id_subdirector,
                    "usuario" => $this->session->userdata('id_usuario')
                );
                if($this->General_model->updateRecord("lotes", $updateData, "idLote", $elemento)){
                    $flagEsatus = $flagEsatus + 1;
                }
            }
            if($flagEsatus == count($lotesFusionados)){
                echo json_encode(array("status" => 200, "message" => "OK"), JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(array("status" => 500, "message" => "ERROR"), JSON_UNESCAPED_UNICODE);
            }
        }else if($idFusion == 0){
            $updateData = array(
                "id_usuario_asignado" => $idAsesorAsignado, 
                "id_gerente_asignado" =>  $lineaVenta->id_gerente,
                "id_subdirector_asignado" => $lineaVenta->id_subdirector,
                "usuario" => $this->session->userdata('id_usuario')
            );
            if($this->General_model->updateRecord("lotes", $updateData, "idLote", $this->input->post('idLote'))){
                echo json_encode(array("status" => 200, "message" => "OK"), JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(array("status" => 500, "message" => "ERROR"), JSON_UNESCAPED_UNICODE);
            }
        }
    }
    
    public function cambiarBandera  (){
        $bandera   =  $this->input->post('bandera');
        $idLote    =  $this->input->post('idLoteBandera');
        $arr_update = array( 
                        "liberaBandera"   => $bandera,
                        "usuario" => $this->session->userdata('id_usuario')
                        );
        $update = $this->Reestructura_model->banderaLiberada($idLote,$arr_update);                           
        if($update){
            $respuesta =  array(
            "response_code" => 200, 
            "response_type" => 'success',
            "message" => "Se ha liberado  satisfactoriamente");
        }else{
            $respuesta =  array(
            "response_code" => 400, 
            "response_type" => 'warning',
            "message" => "Lote no actualizado, inténtalo más tarde ");
        }
        echo json_encode ($respuesta);             
    }

    function getListaLotesArchivosReestrucura(){
        $data = $this->Reestructura_model->getListaLotesArchivosReestrucura();
        echo json_encode($data);
    }

    function getOpcionesLote(){
	    $idLote = $this->input->post('idLote');
	    $flagFusion = $this->input->post('flagFusion');
	    $data['opcionesLotes'] = $this->Reestructura_model->getOpcionesLote($idLote, $flagFusion);
	    $data['copropietarios'] = $this->Reestructura_model->getCopropietariosReestructura($idLote);
        echo json_encode ($data, JSON_NUMERIC_CHECK);
    }

    function updateArchivos(){
        $flagAction = $_POST['tipoProceso'];
        $arrayLength = $_POST['longArray'];
        $banderaFusion = $_POST['banderaFusion'];
        $nombreLoteOriginal = $_POST['nombreLoteOriginal'];
        $id_dxc = $_POST['id_dxc'];
        $id_rol = $this->session->userdata('id_rol');
        $columnFecha = $banderaFusion != 0 ? 'fechaModificacion' : 'fecha_modificacion';
        $columnModificado = $banderaFusion != 0 ? 'modificadoPor' : 'modificado_por';
        
        $editar = $_POST['editarFile'];
        $arrayLotes = 0;
        
        $numeroArchivos = ($banderaFusion != 0 && $id_rol == 15) ? $_POST['countArchResi'] : count(explode(',',$nombreLoteOriginal[0]));// $arrayLength ;
        if($numeroArchivos > 1){
            $arrayLotes = explode(',',$nombreLoteOriginal[0]);
            $numeroArchivos = in_array($id_rol, [17, 70, 71, 73]) ? count($arrayLotes) : $numeroArchivos; 
            $id_dxc = explode(',', $id_dxc[0]);
        }else{
            $arrayLotes = $nombreLoteOriginal;
        }   
            
            for ($j=0; $j < $numeroArchivos ; $j++) { 
                $nombreLoteOriginal = $arrayLotes[$j];
                $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal;
                if (!file_exists($micarpeta)) {
                    mkdir($micarpeta, 0777, true) or die("Error en la generación");
                }
        
                if($flagAction==2 && in_array($id_rol, [17, 70, 71, 73])){
                    $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/CORRIDA';
                    if (!file_exists($micarpeta)) {
                        mkdir($micarpeta, 0777, true);
                    }
                    $carpetaUbicacion = 'CORRIDA/';
                    $nameField = 'corrida';
                    $acceptFiles = 'xlsx|csv|xls|xlsb';
                }elseif($flagAction==2 && $id_rol == 15){
                    $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/CONTRATO';
                    if (!file_exists($micarpeta)) {
                        mkdir($micarpeta, 0777, true);
                    }
                    $carpetaUbicacion = 'CONTRATO/';
                    $nameField = 'contrato';
                    $acceptFiles = 'pdf';
        
                }

                $arrayData = array();
                $config['upload_path'] = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/'.$carpetaUbicacion;
                $config['allowed_types'] = $acceptFiles;
                $config['max_size']     = '0';
                $this->load->library('upload', $config);
                $flagInterno = 0;
                for($i=0; $i<$arrayLength; $i++){
        
                    $resultado = $this->upload->do_upload('archivo'.$i);
                    if($resultado){
                        $archivoSubido = $this->upload->data();
                        $fileNameCmps = explode(".", $_FILES['archivo'.$i]['name']);
                        $fileExtension = strtolower(end($fileNameCmps));
                        $fechaActual = date_create(date('Y-m-d H:i:s'));
                        $nuevoNombre = $this->input->post('nombreLote'.$i).'-'.date_format($fechaActual,"YmdHis").'.'.$fileExtension;
                        rename( $archivoSubido['full_path'], "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal.'/'.$carpetaUbicacion.$nuevoNombre );
                        $idpxl = $this->input->post('idLoteArchivo'.$i);
                        $updateDocumentData = array(
                            $nameField => $nuevoNombre,
                            $columnFecha => date_format($fechaActual,"Y-m-d H:i:s"),
                            $columnModificado => $this->session->userdata('id_usuario')
                        );
                        $tablaUpdate = $banderaFusion != 0 ? 'lotesFusion' : 'propuestas_x_lote';
                        $columnUpdate =  $banderaFusion != 0 ? 'idFusion' : 'id_pxl';
                        $result =  $this->General_model->updateRecord($tablaUpdate, $updateDocumentData, $columnUpdate, $idpxl);
                        if($result){
                            $flagInterno = $flagInterno + 1;
                            if($editar==1){
                                $urlEliminar = "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal.'/'.$carpetaUbicacion.$_POST['archivoEliminar'.$i];
                                $this->eliminaArchivoServer($urlEliminar);
                            }
                        }
                    }
                }
                if($flagAction == 2 && $id_rol == 15){
                    $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/RESCISIONES';
                    if (!file_exists($micarpeta)) {
                        mkdir($micarpeta, 0777, true);
                    }
                    $config2['upload_path'] = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/RESCISIONES/';
                    $config2['allowed_types'] = 'pdf';
                    $this->load->library('upload', $config2);
                    $resultado2 = $this->upload->do_upload('archivoResicion_'.$j);
                    if($resultado2){
                        $archivoSubido2 = $this->upload->data();
                        $fileNameCmps2 = explode(".", $_FILES['archivoResicion_'.$j]['name']);
                        $fileExtension2 = strtolower(end($fileNameCmps2));
                        $fechaActual = date_create(date('Y-m-d H:i:s'));
                        $nuevoNombre2 = $nombreLoteOriginal.'-'.date_format($fechaActual,"YmdHis").'.'.$fileExtension2;
                        rename( $archivoSubido2['full_path'], "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal."/RESCISIONES/".$nuevoNombre2 );
        
                        $updateDocumentData = array(
                            "rescision" => $nuevoNombre2,
                            $columnFecha => date_format($fechaActual,"Y-m-d H:i:s"),
                            $columnModificado => $this->session->userdata('id_usuario')
                        );
                        $tablaUpdate = $banderaFusion != 0 ? 'lotesFusion' : 'datos_x_cliente';
                        $columnUpdate =  $banderaFusion != 0 ? 'idFusion' : 'id_dxc';
                        $this->General_model->updateRecord($tablaUpdate, $updateDocumentData, $columnUpdate, $id_dxc[$j]);
                        if($editar==1){
                            $urlEliminar = "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal."/RESCISIONES/".$_POST['rescisionArchivo'];
                            $this->eliminaArchivoServer($urlEliminar);
                        }
        
                    }
                }
            }


        if($flagInterno==$arrayLength){
            print_r( json_encode(array('code' => 200)));
        }else{
            print_r(json_encode(array('code' => 500, 'flagInterno' => $flagInterno, 'arrayLength' => $arrayLength)));
        }

    }

    function checkDocumentacion($idLote){
	    $datos = $this->Reestructura_model->checkDocumentacion($idLote);

        if ($datos != null) {
            echo json_encode($datos);
        }else{
            echo json_encode(array());
        }
    }

    function eliminaArchivoServer($urlBorrado){
        unlink($urlBorrado);
    }

    function actualizaExpecifico(){
        
        $flagAction = $_POST['tipoProceso'];
        $arrayLength = $_POST['longArray'];
        $id_rol = $this->session->userdata('id_rol');
        $nombreLoteOriginal = $_POST['nombreLoteOriginal'];
        $id_dxc = $_POST['id_dxc'];
        $editar = $_POST['editarFile'];
        $banderaFusion = $_POST['banderaFusion'];
        $columnFecha = $banderaFusion != 0 ? 'fechaModificacion' : 'fecha_modificacion';
        $columnModificado = $banderaFusion != 0 ? 'modificadoPor' : 'modificado_por';
        $numeroArchivos = ($banderaFusion != 0 && $id_rol == 15) ? $_POST['countArchResi'] : count(explode(',',$nombreLoteOriginal[0]));// $arrayLength ;
        $nameField = '';

        if($numeroArchivos > 1){
            $arrayLotes = explode(',',$nombreLoteOriginal[0]);
            $id_dxc = explode(',', $id_dxc[0]);
            $numeroArchivos = in_array($id_rol, [17, 70, 71, 73]) ? count($arrayLotes) : $numeroArchivos; 
            $rescisionArchivo = $id_rol == 15 ? explode(',',$_POST['rescisionArchivo'][0]) : 0;

        }else{
            $arrayLotes = $nombreLoteOriginal;
            $rescisionArchivo = $id_rol == 15 ? $_POST['rescisionArchivo'] : 0;

        }
        for ($j=0; $j < $numeroArchivos ; $j++) {
            $nombreLoteOriginal = $arrayLotes[$j];
            $pre = '';

            if($flagAction==2 && ($id_rol == 17 || $id_rol == 70 || $id_rol == 71 || $id_rol == 73 )){
                $pre = 'CORRIDA';
                $nameField = 'corrida';
                //$acceptFiles = 'xlsx|csv|xls';
            }
            elseif($flagAction==2 && $id_rol == 15){

                $pre = 'CONTRATO';
                $nameField = 'contrato';
            }

            $flagInterno = 0;
            for($i=0; $i<$arrayLength; $i++){
                //$resultado = $this->upload->do_upload('archivo'.$i);
                if(isset($_FILES["archivo".$i])){

                    $file = $_FILES["archivo".$i];

                    $old_file = $_POST['archivoEliminar'.$i];

                    if($file){
                        $filename = $pre . "_" . $this->input->post('nombreLote'.$i) . "_" . date('dmY') . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

                        $uploaded = $this->uploadFileToBucket($file, $filename, $old_file);

                        if($uploaded){
                            $idpxl = $this->input->post('idLoteArchivo'.$i);

                            $updateDocumentData = array(
                                $nameField => $filename,
                                $columnFecha => date('Y-m-d H:i:s'),
                                $columnModificado => $this->session->userdata('id_usuario'),
                                "bucket" => 1,
                            );

                            $tablaUpdate = $banderaFusion != 0 ? 'lotesFusion' : 'propuestas_x_lote';
                            $columnUpdate =  $banderaFusion != 0 ? 'idFusion' : 'id_pxl';

                            $result = $this->General_model->updateRecord($tablaUpdate, $updateDocumentData, $columnUpdate, $idpxl);

                            if($result){
                                $flagInterno += 1;
                            }
                        }
                    }
                }
            }
            if($flagAction == 2 && $id_rol == 15){
                if(isset($_FILES["archivoResicion_".$j])){
                    $pre = 'RESCISION';


                    $file = $_FILES["archivoResicion_".$j];

                    $old_file = $rescisionArchivo[$j];
                    if($file){
                        $filename = $pre . "_" . $nombreLoteOriginal . "_" . date('dmY') . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
                        $uploaded = $this->uploadFileToBucket($file, $filename, $old_file);

                        if($uploaded){
                            $updateDocumentData = array(
                                "rescision" => $filename,
                                $columnFecha => date('Y-m-d H:i:s'),
                                $columnModificado => $this->session->userdata('id_usuario'),
                                "bucket" => 1,
                            );

                            $tablaUpdate = $banderaFusion != 0 ? 'lotesFusion' : 'datos_x_cliente';
                            $columnUpdate =  $banderaFusion != 0 ? 'idFusion' : 'id_dxc';

                            $this->General_model->updateRecord($tablaUpdate, $updateDocumentData, $columnUpdate, $id_dxc[$j]);
                        }
                    }
                }
            }
        }

        print_r( json_encode(array('code' => 200)));
    }

    public function obtenerPropuestasXLote(){
        $idLote =  $this->input->post('idLoteOriginal');
        $flagFusion =  $this->input->post('flagFusion');
        echo json_encode( $this->Reestructura_model->obtenerPropuestasXLote($idLote, $flagFusion)->result_array());
    }

    public function setAvance() {
        $this->db->trans_begin();
        $estatusMovimientos = array(
            1 => 1, // Si el movimiento anterior es nuevo, el sig pasa a nuevo
            2 => 3, // Si el movimiento ant. es rechazo, el sig pasa a corrección
            3 => 1 // Si el movimiento ant. es corrección, el sig pasa a nuevo
        );

        $idLote = $this->input->post('idLote');
        $idPreproceso = $this->input->post('tipoTransaccion');
        $idCliente = $this->input->post('idCliente');
        $comentario = $this->input->post('comentario');
        $idMovimiento = $this->input->post('idEstatusMovimento');
        $idUsuario = $this->session->userdata('id_usuario');
        $idRol = $this->session->userdata('id_rol');
        $flagProcesoContraloriaJuridico = 0;

        if ($idPreproceso == 2)
            $flagProcesoContraloriaJuridico = $this->Reestructura_model->validarEstatusContraloriaJuridico($idLote);
        
        $flagFusion = $this->input->post('flagFusion');

        // AVANCE A Elaboración de corridas, contrato y rescisión: SE CORRE PROCESO PARA ASIGNAR EXPEDIENTE
        if ($idPreproceso + 1 == 2) { 
            $id_asig = $this->Contraloria_model->get_id_asig('reestructura')->contador;
            if ($id_asig == 2747) // CARLITOS
                $assigned_user = 2762; // SE ASIGNA A DANI
            else if ($id_asig == 2762) // ES DANI
                $assigned_user = 13691; // SE ASIGNA A CECILIA
            else if ($id_asig == 13691) // ES CECILIA
                $assigned_user = 2765; // SE LE ASIGNA A  LUIS OCTAVIO
            else if ($id_asig == 2765) //  LUIS OCTAVIO
                $assigned_user = 10463; // SE LE ASIGNA A KARINA ANGELICA
            else if ($id_asig == 10463) // KARINA ANGELICA
                $assigned_user = 2876; // SE LE ASIGNA A JENNIFER ARELI
            else if ($id_asig == 2876) // JENNIFER ARELI 
                $assigned_user = 2747; // SE LE ASIGNA A CARLITOS
        
            $dataUpdateVariable = array('contador' => $assigned_user);
            $responseVariable = $this->General_model->updateRecord("variables", $dataUpdateVariable, "identificador", 'reestructura');
        }

        // VALIDACIÓN DE AVANCE PASOS DE CONTRALORÍA Y JURÍDICO QUE CORREN AL MISMO TIEMPO
        if ($idPreproceso == 2) {
            if ($flagProcesoContraloriaJuridico->flagProcesoContraloria == 0 && in_array($idRol, [17, 70, 71, 73]))
                $this->General_model->updateRecord("datos_x_cliente", array('flagProcesoContraloria' => 1, 'modificado_por' => $idUsuario, 'fecha_modificacion' => date("Y-m-d H:i:s")), 'idLote', $idLote);
            if ($flagProcesoContraloriaJuridico->flagProcesoJuridico == 0 && $idRol == 15)
                $this->General_model->updateRecord("datos_x_cliente", array('flagProcesoJuridico' => 1, 'modificado_por' => $idUsuario, 'fecha_modificacion' => date("Y-m-d H:i:s")), 'idLote', $idLote);
            
            if (($flagProcesoContraloriaJuridico->flagProcesoJuridico == 1 && in_array($idRol, [17, 70, 71, 73])) || ($flagProcesoContraloriaJuridico->flagProcesoContraloria == 1 && $idRol == 15)) {
                $estatus_proceso = 3;
                $updateFechaVencimientoBandera = 1;
            }
            else {
                $estatus_proceso = 2;
                $updateFechaVencimientoBandera = 0;
            }
        }
        else {
            $estatus_proceso = ($idPreproceso + 1) == 5 ? 6 : $idPreproceso + 1 ;
            $updateFechaVencimientoBandera = 1;
        }
        
        $fechaVencimiento = $this->getFechaVencimiento(0); // SI ES ELABORACIÓN DE CORRIDAS, CONTRATO Y RESCISIÓN DA 2 DÍAS SINO 1

        if ($idPreproceso + 1 == 4) // AG ENVÍA A EEC SE HACE EL SALTO DE LOS PASOS 4 Y 5 ENVIÁNDOSE DIRECTOR AL 6
            $estatus_proceso = 6;

        if($flagFusion==1) {
            //Se obtienen lotes de fusión de origen para actualizar estatus de lote e insertar historial
            $data = $this->Reestructura_model->getFusion($idLote, 1);
            $arrayLotesUpdate = array();
            $arrayLotesHistorial = array();

            foreach($data as $elemento){
                $dataUpdateLote = array();
                $dataHistorial = array();
                
                $dataUpdateLote = array(
                    "idLote" => $elemento['idLote'],
                    'estatus_preproceso' => $estatus_proceso,
                    'usuario' => $idUsuario
                );

                if ($idPreproceso + 1 == 2)
                    $dataUpdateLote['id_juridico_preproceso'] = $assigned_user;

                if ($updateFechaVencimientoBandera == 1)
                    $dataUpdateLote['fechaVencimiento'] = $fechaVencimiento;

                array_push($arrayLotesUpdate, $dataUpdateLote);
                
                $dataHistorial = array(
                    'idLote' => $elemento['idLote'],
                    'idCliente' => $elemento['idCliente'],
                    'id_preproceso' => $idPreproceso,
                    'comentario' => $comentario,
                    'estatus' => $estatusMovimientos[$idMovimiento],
                    'modificado_por' => $idUsuario
                );
                array_push($arrayLotesHistorial, $dataHistorial);
            }


            $this->General_model->updateBatch('lotes', $arrayLotesUpdate, 'idLote');
            $this->General_model->insertBatch('historial_preproceso_lote', $arrayLotesHistorial);
        } else {
            $dataUpdateLote = array(
                'estatus_preproceso' => $estatus_proceso,
                'usuario' => $idUsuario
            );

            if ($idPreproceso + 1 == 2)
                $dataUpdateLote['id_juridico_preproceso'] = $assigned_user;

            if ($updateFechaVencimientoBandera == 1)
                $dataUpdateLote['fechaVencimiento'] = $fechaVencimiento;

            $dataHistorial = array(
                'idLote' => $idLote,
                'idCliente' => $idCliente,
                'id_preproceso' => $idPreproceso,
                'comentario' => $comentario,
                'estatus' => $estatusMovimientos[$idMovimiento],
                'modificado_por' => $idUsuario
            );

            $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $idLote);
            $this->General_model->addRecord('historial_preproceso_lote', $dataHistorial);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al realizar avance de lotes',
                'color' => 'danger'
            ));
            return;
        }

        $this->db->trans_commit();
        echo json_encode(array(
            'titulo' => 'OK',
            'resultado' => TRUE,
            'message' => 'Proceso realizado correctamente.',
            'color' => 'success'
        ));
    }

    public function setLoteDisponible()
    {
        $tipoEstatusRegreso = $this->input->post('tipoEstatusRegreso');
        $tipoProceso = $this->input->post('tipoProceso');
        $idLote = $this->input->post('idLote');
        $id_pxl = $this->input->post('id_pxl');
        $flagFusion = $this->input->post('flagFusion');

        $getProyecto = $this->Reestructura_model->getProyectoIdByLote($idLote);
        $idProyecto = (int) $getProyecto[0]['idProyecto'];

        if($tipoEstatusRegreso == 1){
            $statusLote = 15;
        }
        else if($tipoEstatusRegreso == 2 && in_array($idProyecto, [14,21,22,25])){
                $statusLote = 21;
        }
        else if($tipoEstatusRegreso == 0 && !in_array($idProyecto, [14,21,22,25])){
            $statusLote = 1;
        }

        $dataUpdateLote = array(
            'idStatusLote' => $statusLote,
            'usuario' => $this->session->userdata('id_usuario'),
            'estatus_preproceso' => 0
        );

        $responseUpdateLote = $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $idLote);
        if($flagFusion==1){
            $responseDeletePropuesta = $this->General_model->deleteRecord('lotesFusion', array('idFusion' => $id_pxl));
        }else{
            $responseDeletePropuesta = $this->General_model->deleteRecord('propuestas_x_lote', array('id_pxl' => $id_pxl));
        }

        echo ($responseUpdateLote && $responseDeletePropuesta);
    }

    public function agregarLotePropuesta()
    {

        $idLoteOriginal = $this->input->post('idLoteOriginal');
        $idLotePropuesta = $this->input->post('idLotePropuesta');
        $flagFusion = $this->input->post('flagFusion');
        $idProyecto = $this->input->post('idProyecto');

        $lote = $this->Reestructura_model->checarDisponibleRe($idLotePropuesta, $idProyecto);
        if (count($lote) === 0) {
            echo json_encode(['code' => 400, 'message' => 'Lote no disponible. Favor de verificarlo']);
            return;
        }

        $dataUpdateLote = array(
            'idStatusLote' => ($idProyecto==21) ? 20 : 16,
            'usuario' => $this->session->userdata('id_usuario')
        );
        if($flagFusion==1){
            $tabla= 'lotesFusion';
            $dataInsertPropuestaLote = array(
                'idLote' => $idLotePropuesta,
                'idcliente' => 0,
                'origen' => 0,
                'destino' => 1,
                'idLotePvOrigen' => $idLoteOriginal,
                'nombreLotes' => null,
                'totalNeto2' => null,
                'creadoPor' => $this->session->userdata('id_usuario'),
                'fechaCreacion'   => date("Y-m-d H:i:s"),
                'modificadoPor' => $this->session->userdata('id_usuario'),
                'fechaModificacion'   => date("Y-m-d H:i:s"),
                'contrato'   => null,
                'corrida'   => null,
                'rescision'   => null
            );
        }
        else{
            $tabla = 'propuestas_x_lote';

            $dataInsertPropuestaLote = array(
                'idLote' => $idLoteOriginal,
                'id_lotep' => $idLotePropuesta,
                'estatus' => 0,
                'creado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion'   => date("Y-m-d H:i:s"),
                'modificado_por' => $this->session->userdata('id_usuario')
            );
        }

        $responseUpdateLote = $this->General_model->updateRecord('lotes', $dataUpdateLote, 'idLote', $idLotePropuesta);
        $responseInsertPropuesta = $this->General_model->addRecord($tabla, $dataInsertPropuestaLote);

        echo ($responseUpdateLote && $responseInsertPropuesta) ? json_encode(['code' => 200]) : json_encode(['code' => 500]);
    }

    public function totalPropuestas($idLoteOriginal, $flagFusion)
    {
        $totalPropuestas = $this->Reestructura_model->obtenerTotalPropuestas($idLoteOriginal, $flagFusion);
        echo json_encode($totalPropuestas->total_propuestas);
    }

    public function desactivarOtrosLotes($idLoteOriginal){
        $notSelectedLotes = $this->Reestructura_model->getNotSelectedLotes($idLoteOriginal);

        if (count($notSelectedLotes) == 0) {
            return true;
        }

        $arrayLotes = array();

        foreach ($notSelectedLotes as $lote){
            $arrayLote = array(
                'idLote' => $lote['id_lotep'],
                'idStatusLote' => $lote['tipo_estatus_regreso'] == 1 ? 15 : ($lote['tipo_estatus_regreso'] == 2 ? 21 : 1),
                'usuario' => $this->session->userdata('id_usuario')
            );

            array_push($arrayLotes, $arrayLote);
        }
        
        return $this->General_model->updateBatch('lotes', $arrayLotes, 'idLote');
    }

    public function inventario(){
		$this->load->view('template/header');
        $this->load->view("reestructura/inventario_view");
	}

    public function getInventario() {
        echo json_encode($this->Reestructura_model->getInventario());
    }

    public function reporteVentas(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reporteVentas_view");
	}

    public function getReporteVentas() {
        echo json_encode($this->Reestructura_model->getReporteVentas());
    }

    public function contratoFirmadoR(){
        $flagFusion = $this->input->post('flagFusion');
        $editarFile = $this->input->post('editarFile');

        $idLote = $this->input->post('idLote');
        $nombreLote = $this->input->post('nombreLoteOriginal');
        $idDocumento = $this->input->post('idDocumento');
        $idCliente = $this->input->post('idCliente');
        $idCondominio = $this->input->post('idCondominio');
        $idUsuario = $this->session->userdata('id_usuario');
        $nombreResidencial = $this->input->post('nombreResidencial');
        $nombreCondominio = $this->input->post('nombreCondominio');
        $nombreDocumento = $this->input->post('nombreDocumento');

        //configuracion DEL LOS ARCHIVOS PDF
        //$configCF['upload_path'] = 'static/documentos/cliente/contratoFirmado/';
        //$configCF['allowed_types'] = 'pdf';
        //$this->load->library('upload', $configCF);
        // print_r($editarFile);
        if($editarFile == 0){

            if($flagFusion==1){
                $totalContratos = $this->input->post('totalContratos');
                $flagInternoConteo = 0;
                
                for($i = 0; $i < $totalContratos; $i++){
                    $dataConsultaCF = $this->Reestructura_model->revisarCFDocumentos($idLote[$i], $idCliente[$i]);
                    $flagExisteRama = count($dataConsultaCF);

                    //$this->load->library('upload', $configCF);
                    if($flagExisteRama == 0){//no existe la rama se debe crear

                        $file = $_FILES["contratoFirmado".$i];

                        $filename = 'CONTRATO_FIRM_' . $nombreLote[$i] . '_' . date('dmY') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                        //$filename = $this->generarNombreFile($nombreResidencial[$i], $nombreCondominio[$i], $nombreLote[$i], $idCliente[$i], $_FILES["contratoFirmado".$i]["name"]);

                        $uploaded = $this->uploadFileToBucket($file, $filename, $nombreDocumento[$i]);

                        if($uploaded){
                            $dataInsert = array(
                                'movimiento' => "CONTRATO FIRMADO",
                                'expediente' => $filename,
                                'modificado' => date('Y-m-d H:i:s'),
                                'status' => 1,
                                'idCliente' => $idCliente[$i],
                                'idCondominio' => $idCondominio[$i],
                                'idLote' => $idLote[$i],
                                'idUser' => $idUsuario,
                                'tipo_documento' => 0,
                                'id_autorizacion' => 0,
                                'tipo_doc' => 30,
                                'estatus_validacion' => 0,
                                'bucket' => 1,
                            );

                            $insert = $this->General_model->addRecord('historial_documento', $dataInsert);

                            if($insert){
                                $flagInternoConteo += 1;
                            }
                        }else{//no se pudo subir el archivo
                            print_r( json_encode(array('code' => 500)));
                        }

                    }
                }

                if($flagInternoConteo == $totalContratos){//el contador de la bandera cuando se inserto corr4ectamente debe
                    //de coinidir con el total de lotes fusionados
                    print_r( json_encode(array('code' => 200)));
                }else{
                    print_r( json_encode(array('code' => 400)));
                }

            }else{//proceso normal SIN FUSION SÓLO UN ARCHIVO
                $dataConsultaCF = $this->Reestructura_model->revisarCFDocumentos($idLote, $idCliente);
                
                $flagExisteRama = count($dataConsultaCF);
                if($flagExisteRama == 0){//no existe la rama se debe crear

                    $file = $_FILES["contratoFirmado"];

                    $filename = 'CONTRATO_FIRM_' . $nombreLote . '_' . date('dmY') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                    //$filename = $this->generarNombreFile($nombreResidencial, $nombreCondominio, $nombreLote, $idCliente, $_FILES["contratoFirmado"]["name"]);

                    $uploaded = $this->uploadFileToBucket($file, $filename, $nombreDocumento);

                    if($uploaded){
                        $dataInsert = array(
                            'movimiento' => "CONTRATO FIRMADO",
                            'expediente' => $filename,
                            'modificado' => date('Y-m-d H:i:s'),
                            'status' => 1,
                            'idCliente' => $idCliente,
                            'idCondominio' => $idCondominio,
                            'idLote' => $idLote,
                            'idUser' => $idUsuario,
                            'tipo_documento' => 0,
                            'id_autorizacion' => 0,
                            'tipo_doc' => 30,
                            'estatus_validacion' => 0,
                            'bucket' => 1,
                        );

                        $insert = $this->General_model->addRecord('historial_documento', $dataInsert);

                        if($insert){
                            print_r( json_encode(array('code' => 200)));
                        }else{
                            print_r( json_encode(array('code' => 404)));
                        }
                    }
                }
            }
        }
        elseif($editarFile == 1){
            if($flagFusion == 1){
                    $totalContratos = $this->input->post('totalContratos');
                    $archivoEditado = $this->input->post('archivoEditado');

                    if(!isset($totalContratos)){
                        $totalContratos = 1;
                    }

                    if(!isset($archivoEditado)){
                        $archivoEditado = [
                            0 => 1
                        ];
                    }

                    $flagInternoConteo = 0;
                    $flagEditados = 0;

                    for($i=0; $i<$totalContratos; $i++){//recorremos el numero de fusiones
                        if($archivoEditado[$i]==1){ //revisamos que venga uno con edición
                            //hacer la lógica de la actualización

                            $flagEditados += 1;

                            if(isset($_FILES["contratoFirmado".$i])){
                                $file = $_FILES["contratoFirmado".$i];
                            }elseif(isset($_FILES["contratoFirmado"])){
                                $file = $_FILES["contratoFirmado"];
                            }
                            
                            if($file){
                                if(is_array($nombreLote)){
                                    $nombre = $nombreLote[$i];
                                }else{
                                    $nombre = $nombreLote;
                                }

                                $filename = 'CONTRATO_FIRM_' . $nombre . '_' . date('dmY') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                                //$filename = $this->generarNombreFile($nombreResidencial[$i], $nombreCondominio[$i], $nombreLote[$i], $idCliente[$i], $_FILES["contratoFirmado".$i]["name"]);

                                if(is_array($nombreDocumento)){
                                    $old_file = $nombreDocumento[$i];
                                }elseif($this->input->post('nombreDocumento') !== null ){
                                    $old_file = $nombreDocumento;
                                }

                                $uploaded = $this->uploadFileToBucket($file, $filename, $old_file);

                                if($uploaded){
                                    $data_actualizar = array(
                                        'modificado' => date('Y-m-d H:i:s'),
                                        'idUser'     => $this->session->userdata('id_usuario'),
                                        'expediente' => $filename,
                                        'bucket'     => 1,
                                    );

                                    if(is_array($idDocumento)){
                                        $id_documento = $idDocumento[$i];
                                    }elseif($this->input->post('idDocumento') !== null ){
                                        $id_documento = $idDocumento;
                                    }

                                    $update = $this->General_model->updateRecord('historial_documento', $data_actualizar, 'idDocumento', $id_documento);

                                    if($update){
                                        $flagInternoConteo += 1;
                                    }
                                }
                            }
                        }
                    }

                    if($flagInternoConteo == $flagEditados){
                        print_r( json_encode(array('code' => 200)));
                    }else{
                        print_r( json_encode(array('code' => 404)));
                    }
                exit;
            }
            else{
                $file = $_FILES["contratoFirmado"];

                $filename = 'CONTRATO_FIRM_' . $nombreLote . '_' . date('dmY') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                //$filename = $this->generarNombreFile($nombreResidencial, $nombreCondominio, $nombreLote, $idCliente, $_FILES["contratoFirmado"]["name"]);

                $uploaded = $this->uploadFileToBucket($file, $filename, $nombreDocumento);

                if($uploaded){
                    $data_actualizar = array(
                        'modificado' => date('Y-m-d H:i:s'),
                        'idUser'     => $this->session->userdata('id_usuario'),
                        'expediente' => $filename,
                        'bucket'     => 1,
                    );

                    $update = $this->General_model->updateRecord('historial_documento', $data_actualizar, 'idDocumento', $idDocumento);

                    if($update){
                        print_r( json_encode(array('code' => 200)));
                    }else{
                        print_r( json_encode(array('code' => 404)));
                    }
                }
            }
        }
        exit;
    }

    public function uploadFileToBucket($file, $filename, $old_file=null){
        // if($file){

        //     $object = $this->bucket->upload(
        //         fopen($file["tmp_name"], 'r'),
        //         [
        //             'name' => $filename,
        //         ]
        //     );

        //     if($old_file && $old_file != $filename){
        //         $old_object = $this->bucket->object($old_file);

        //         if($old_object->exists()){
        //             $old_object->delete();
        //         }
        //     }

        //     if($object->exists()){
        //         return true;
        //     }
        // }

        return true;
    }

    function generarNombreFile($nombreResidencial, $nombreCondominio, $nombreLote, $idCliente, $archivo){
        //esta funcion genera un nombre apartir de los parametros de nombreResidencial, $nombreCondominio,
        //nombreLote y $idCliente quedando como el sig. ejemplo: CMMSLP_MON01_22122020_38479_508.pdf
        $aleatorio = rand(100,1000);
        $proyecto = str_replace(' ', '', $nombreResidencial);
        $condominio = str_replace(' ', '', $nombreCondominio);
        $condom = substr($condominio, 0, 3);
        $cond= strtoupper($condom);
        $numeroLote = preg_replace('/[^0-9]/','', $nombreLote);
        $date= date('dmY');
        $composicion = $proyecto."_".$cond."_".$numeroLote."_".$date;
        $nombArchivo=$composicion;
        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
        $expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'.'.$extension;
        return $expediente;
    }

    public function getListaUsuariosReasignacionJuridico() {
        echo json_encode($this->Reestructura_model->getListaUsuariosReasignacionJuridico());
    }

    public function setEjecutivoJuridico() {
        $updateData = array("id_juridico_preproceso" => $this->input->post('id_usuario'), "usuario" => $this->session->userdata('id_usuario'));
        echo json_encode($this->General_model->updateRecord("lotes", $updateData, "idLote", $this->input->post('idLote')));
    }

    public function copiarCopropietariosAnteriores($idCliente, $idLote): bool
    {
        $copropietarios = $this->Reestructura_model->obtenerCopropietariosPorIdCliente($idCliente);

        if (count($copropietarios) === 0) {
            return true;
        }else{
            //revisar si ya se habian insertado anteriormente los copropietarios
            //y vuelven  pasar por este paso porque volvieron a aceptar (deshacer reestructura)
            $coopropietarioPorDR = $this->Reestructura_model->coopropietarioPorDR($idLote);
            if(count($copropietarios) == count($coopropietarioPorDR)){
            return true;
            }
        }

        $copropietariosInsertar = [];
        foreach ($copropietarios as $coopropietario) {
            $copropietariosInsertar[] = [
                'idLote' => $idLote,
                'nombre' => $coopropietario['nombre'] ?? '',
                'apellido_paterno' => $coopropietario['apellido_paterno'] ?? '',
                'apellido_materno' => $coopropietario['apellido_materno'] ?? '',
                'correo' => $coopropietario['correo'] ?? '',
                'telefono_2' => $coopropietario['telefono_2'] ?? '',
                'domicilio_particular' => $coopropietario['domicilio_particular'] ?? '',
                'estado_civil' => $coopropietario['estado_civil'] ?? '',
                'ocupacion' => $coopropietario['ocupacion'] ?? '',
                'ine' => $coopropietario['ine'],
                'modificado_por' => $this->session->userdata('id_usuario')
            ];
        }

        return $this->General_model->insertBatch('datos_x_copropietario', $copropietariosInsertar);
    }

    public function movimientosCopropietarios($idLote, $data): bool
    {
        if (!isset($data['id_cop']) && !isset($data['id_cop_eliminar'])) {
            return true;
        }

        $copropietariosInsertar = [];
        $copropietariosActualizar = [];

        if (isset($data['id_cop'])) {
            foreach ($data['id_cop'] as $index => $idCopropietario) {
                if ($idCopropietario !== 'Nuevo') {
                    $copropietariosActualizar[] = [
                        'id_dxcop' => $data['id_cop'][$index],
                        'idLote' => $idLote,
                        'nombre' => $data['nombre'][$index],
                        'apellido_paterno' => $data['apellido_p'][$index],
                        'apellido_materno' => $data['apellido_m'][$index],
                        'correo' => $data['correo'][$index],
                        'telefono_2' => $data['telefono2'][$index],
                        'domicilio_particular' => $data['domicilio'][$index],
                        'estado_civil' => $data['estado_civil'][$index],
                        'ocupacion' => $data['ocupacion'][$index],
                        'ine' => $data['identificacion'][$index],
                        'modificado_por' => $this->session->userdata('id_usuario')
                    ];
                    continue;
                }

                $copropietariosInsertar[] = [
                    'idLote' => $idLote,
                    'nombre' => $data['nombre'][$index],
                    'apellido_paterno' => $data['apellido_p'][$index],
                    'apellido_materno' => $data['apellido_m'][$index],
                    'correo' => $data['correo'][$index],
                    'telefono_2' => $data['telefono2'][$index],
                    'domicilio_particular' => $data['domicilio'][$index],
                    'estado_civil' => $data['estado_civil'][$index],
                    'ocupacion' => $data['ocupacion'][$index],
                    'ine' => $data['identificacion'][$index],
                    'modificado_por' => $this->session->userdata('id_usuario')
                ];
            }
        }

        $resultInsert = empty($copropietariosInsertar) || $this->General_model->insertBatch('datos_x_copropietario', $copropietariosInsertar);
        $resultUpdate = empty($copropietariosActualizar) || $this->General_model->updateBatch('datos_x_copropietario', $copropietariosActualizar, 'id_dxcop');
        $resultDelete = empty($data['id_cop_eliminar']) || $this->Reestructura_model->eliminarCopropietarios($data['id_cop_eliminar']);

        return $resultInsert && $resultUpdate && $resultDelete;
    }

    public function borarArchivo(){
        $archivoNombre = 'static/documentos/contratacion-reubicacion-temp/CMMSLP-ASPH-044/CORRIDA/CMSSLP-IRAI-48-20231221161742.xlsx';
        unlink($archivoNombre);
    }

    public function lista_proyecto(){
        $bandera = $this->input->post('bandera');
		if(in_array($this->session->userdata('id_rol'), [2, 5, 18]) || in_array($this->session->userdata('id_usuario'), [2896, 12271, 12113, 12112, 13164, 12668, 12111]))
			echo json_encode($this->Reestructura_model->get_proyecto_listaCancelaciones()->result_array());
		else if(($this->session->userdata('id_usuario') == 5107 || $this->session->userdata('id_usuario') == 9897) && $bandera == 1) // MJ: SELECT DE LA VISTA LIBERAR
          echo json_encode($this->Reestructura_model->get_proyecto_lista_yola()->result_array());
        else // MJ: SELECT DE LA VISTA reestructura
            echo json_encode($this->Reestructura_model->get_proyecto_lista(1)->result_array());
    }

    public function borrarOpcion(){
		$idOpcion = $_POST['idOpcion'];
		$update = $this->Reestructura_model->borrarOpcionModel(100,$idOpcion);
		if ($update == TRUE) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

    public function editarOpcion(){
		$dataPost = $_POST;
		$datos["idOpcionEdit"] = $dataPost['idOpcionEdit'];
		$datos["editarCatalogo"] = $dataPost['editarCatalogo'];
		$update = $this->Reestructura_model->editarOpcionModel($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		}
	}

    public function obtenerRegistrosLiberar()
    {
        $proyecto = $this->input->post('index_proyecto');
        $datos = $this->Reestructura_model->obtenerLotesLiberar($proyecto);
        echo json_encode($datos);
    }

    public function setFusionLotes(){
        $datos = $this->input->post('data');
        $dataInsert = array();
        $datos = json_decode($datos);
        foreach ($datos as $index => $elemento){
            $dataInsert[$index] = array(
                'idLote' => $elemento[4],
                'idCliente' => $elemento[1],
                'origen' => 1,
                'destino' => 0,
                'idLotePvOrigen' => $datos[0][4],
                'nombreLotes' => $elemento[0],
                'totalNeto2' => $elemento[3],
                'creadoPor' => 1,
                'fechaCreacion' => date('Y-m-d H:i:s'),
                'modificadoPor' => null,
                'fechaModificacion' => date('Y-m-d H:i:s'),
            );
        }

        $insertResponse = $this->General_model->insertBatch('lotesFusion', $dataInsert);

        if ($insertResponse) // SE EVALÚA LA RESPUESTA DE LA TRANSACCIÓN OK
            echo json_encode(array("status" => 200, "message" => "Se han fusionado los lotes correctamente."), JSON_UNESCAPED_UNICODE);
        else // FALLÓ EL BATCH
            echo json_encode(array("status" => 500, "message" => "No se logró procesar la petición."), JSON_UNESCAPED_UNICODE);
    }

    function getFusion(){
        $idLote = $this->input->post('idLote');
        $tipoOrigenDestino = $this->input->post('tipoOrigenDestino');
        $data = $this->Reestructura_model->getFusion($idLote, $tipoOrigenDestino);
        if ($data) // SE EVALÚA LA RESPUSTA DE LA TRANSACCIÓN OK
            echo json_encode(array("status" => 200, "message" => "OK", "data" => $data), JSON_UNESCAPED_UNICODE);
        else // FALLÓ EL BATCH
            echo json_encode(array("status" => 500, "message" => "ERROR"), JSON_UNESCAPED_UNICODE);
    }

    public function setTraspaso() {
        if ($this->input->post('tipo') == 1) { // ES DE PROCESO NORMAL DE REUBICACIÓN
            $updateDataOrigenNormal = array (
                "cantidadTraspaso" => $this->formatter->removeNumberFormat($this->input->post('cantidadTraspaso')), 
                "comentario" => $this->input->post('comentarioTraspaso'), 
                "modificado_por" => $this->session->userdata('id_usuario'), 
                'fecha_modificacion' => date('Y-m-d H:i:s'),
                'estatusTraspaso' => 1
            );
        } else { // ES UN PROCESO FUSIÓN DE REUBICACIÓN
            $updateDataOrigenFusion = array (
                "cantidadTraspaso" => $this->formatter->removeNumberFormat($this->input->post('cantidadTraspaso')), 
                "comentario" => $this->input->post('comentarioTraspaso'), 
                "modificadoPor" => $this->session->userdata('id_usuario'), 
                'fechaModificacion' => date('Y-m-d H:i:s'),
                'estatusTraspaso' => 1
            );
        }

        $updateDataDestino = array (
            "totalValidado" => $this->formatter->removeNumberFormat($this->input->post('cantidadTraspaso')), 
            "validacionEnganche" => 'VALIDADO', 
            "usuario" => $this->session->userdata('id_usuario')
        );

        $insertDataDestino = array(
			'nombreLote' => $this->input->post('nombreLoteDestino'),
			'idStatusContratacion' => 11,
			'idMovimiento' => 41,
			'modificado' => date('Y-m-d h:i:s'),
			'fechaVenc' => date('Y-m-d h:i:s'),
			'idLote' => $this->input->post('idLoteDestino'),
			'idCondominio' => $this->input->post('idCondominioDestino'),
			'idCliente' => $this->input->post('idClienteDestino'),
			'usuario' => $this->session->userdata('id_usuario'),
			'perfil' => $this->session->userdata('id_rol'),
			'comentario' => $this->input->post('comentarioTraspaso'),
			'status' => 1
        );
        
        if ($this->input->post('tipo') == 1) // ES DE PROCESO NORMAL DE REUBICACIÓN
            $responseUpdateOrigen = $this->General_model->updateRecord("datos_x_cliente", $updateDataOrigenNormal, "idLote", $this->input->post('idLoteOrigen'));
        else // ES UN PROCESO FUSIÓN DE REUBICACIÓN
            $responseUpdateOrigen = $this->General_model->updateRecord("lotesFusion", $updateDataOrigenFusion, "idLote", $this->input->post('idLoteDestino'));

        $responseUpdateDestino = $this->General_model->updateRecord("lotes", $updateDataDestino, "idLote", $this->input->post('idLoteDestino'));
        $responseInsertHistorial = $this->General_model->addRecord('historial_lotes', $insertDataDestino);

        if ($responseUpdateOrigen && $responseUpdateDestino && $responseInsertHistorial)
            echo json_encode(true);
        else 
            echo json_encode(false);
    }

    public function getFechaVencimiento ($numeroDias) {
        $numeroDias = intval($numeroDias);
        date_default_timezone_set('America/Mexico_City');
        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");
        if ($horaActual > $horaInicio and $horaActual < $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            if (in_array($sig_fecha_dia2, ['Sat', 'Sun']) || in_array($sig_fecha_feriado2, ['01-01', '06-02', '20-03', '01-05', '16-09', '20-11', '19-11', '25-12'])) {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= $numeroDias) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if (in_array($sig_fecha_dia, ['Sat', 'Sun']) || in_array($sig_fecha_feriado, ['01-01', '06-02', '20-03', '01-05', '16-09', '20-11', '19-11', '25-12'])) {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaVencimiento = $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= $numeroDias) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if (in_array($sig_fecha_dia, ['Sat', 'Sun']) || in_array($sig_fecha_feriado, ['01-01', '06-02', '20-03', '01-05', '16-09', '20-11', '19-11', '25-12'])) {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaVencimiento = $fecha;
            }
        } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            if (in_array($sig_fecha_dia2, ['Sat', 'Sun']) || in_array($sig_fecha_feriado2, ['01-01', '06-02', '20-03', '01-05', '16-09', '20-11', '19-11', '25-12'])) {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= $numeroDias) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if (in_array($sig_fecha_dia, ['Sat', 'Sun']) || in_array($sig_fecha_feriado, ['01-01', '06-02', '20-03', '01-05', '16-09', '20-11', '19-11', '25-12'])) {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaVencimiento = $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= $numeroDias) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if (in_array($sig_fecha_dia, ['Sat', 'Sun']) || in_array($sig_fecha_feriado, ['01-01', '06-02', '20-03', '01-05', '16-09', '20-11', '19-11', '25-12'])) {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaVencimiento = $fecha;
            }
        }
        return $fechaVencimiento;
    }

    public function getListaLotesPendienteTraspaso() {
        $registrosNormales = $this->Reestructura_model->getListaLotesPendienteTraspasoNormales();
        $registrosFusion = $this->Reestructura_model->getListaLotesPendienteTraspasoFusion();
        for ($i = 0; $i < count($registrosFusion); $i ++) {
            $registrosFusion[$i]['nombreResidencialOrigen'] = implode(', ', array_unique(explode(', ', $registrosFusion[$i]['nombreResidencialOrigen'])));
            $registrosFusion[$i]['nombreCondominioOrigen'] = implode(', ', array_unique(explode(', ', $registrosFusion[$i]['nombreCondominioOrigen'])));
        }
        $finalArrayData = array_merge($registrosNormales, $registrosFusion);
        for ($m = 0; $m < count ($finalArrayData); $m ++) {
            $finalArrayData[$m]['fechaVencimiento'] = $this->sumarDiaSinFestivosNiFinDeSemana($finalArrayData[$m]['fechaEstatus9']);
        }
        echo json_encode($finalArrayData, JSON_NUMERIC_CHECK);
    }

    public function reporteEstatus(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reporteEstatus_view");
	}	

    public function getReporteEstatus() {
        $registros = $this->Reestructura_model->getReporteEstatus();
        for ($i = 0; $i < count($registros); $i ++) {
            $registros[$i]['nombreResidencialOrigen'] = implode(', ', array_unique(explode(', ', $registros[$i]['nombreResidencialOrigen'])));
            $registros[$i]['nombreCondominioOrigen'] = implode(', ', array_unique(explode(', ', $registros[$i]['nombreCondominioOrigen'])));
            $registros[$i]['nombreResidencialDestino'] = implode(', ', array_unique(explode(', ', $registros[$i]['nombreResidencialDestino'])));
            $registros[$i]['nombreCondominioDestino'] = implode(', ', array_unique(explode(', ', $registros[$i]['nombreCondominioDestino'])));
            $registros[$i]['estatusProceso'] = implode(', ', array_unique(explode(', ', $registros[$i]['estatusProceso'])));
        }
        echo json_encode($registros, JSON_NUMERIC_CHECK);
    }

    public function getHistorialPorLote($idLote, $flagFusion) {
        $arrayIdLote = ( explode( ',', $idLote ));
        echo json_encode($this->Reestructura_model->getHistorialPorLote($arrayIdLote[0], $flagFusion));
    }
    
    public function quitarLoteFusion(){
        $datosPost = $_POST;
        $result = false;
        for ($i=0; $i < $datosPost['index'] ; $i++) { 
            if(isset($datosPost['idFusion_'.$i])){
                $result = $this->Reestructura_model->quitarLoteFusion($datosPost['idFusion_'.$i],$this->session->userdata('id_usuario'));
            }
        }
        echo json_encode($result);
    }

    public function removeLoteFusion()
    {
        $datosPost = $_POST;
        $pvLote = $datosPost["pvLote"];
        $result = false;
        $data = array();
        $lotesDestino = array();
        $lotesOrigen = array();
        $statusLoteDestino = array();
        $idRegreso = 0;
        $allUpdates = true;
        $idUsuario = $this->session->userdata('id_usuario');

        if (!empty($pvLote)) {
            // 1. checamos los lotes que estas involucrados en la fusion
            $checkFusion = $this->Reestructura_model->checkFusion($pvLote);
            // $checkFusionOrigen = $this->Reestructura_model->checkFusionOrigen();


            $data = $checkFusion->result();

            $this->db->trans_begin();

            // una vez que se comprueba que haya resultados de la consulta, se guardan los lotes en un arreglo
            foreach ($data as $d) {
                if($d->origen == 1){
                    $lotesOrigen[] = $d->idLote;
                }
                else if($d->origen == 0){
                    $lotesDestino[] = $d->idLote;
                }
                
            }

            // 2. despues se eliminan los registros de la fusión
            $delete = $this->Reestructura_model->deleteFusion($pvLote);

            if ($delete) {
                $idLotes = implode(',', $lotesDestino);

                if ($checkFusion->num_rows() > 0 && count($lotesDestino) > 0) {
                    $checkLotes = $this->Reestructura_model->checkLotesFusion($idLotes);

                    $data = $checkLotes->result();

                    foreach ($data as $d) {
                        // $statusLoteDestino["idLote"] = $d->idLote;
                        // $statusLoteDestino["idStatusLote"] = $d->idStatusLote;

                        if ($d->idStatusLote == 20) {
                            $idRegreso = 21;
                        } else if ($d->idStatusLote == 16) {
                            $idRegreso = 15;
                        }

                        //3. Se regresan los lotes a su estatus anterior
                        //actualizar uno por uno
                        $update = $this->Reestructura_model->updateLotesFusion($d->idLote, $idRegreso, $idUsuario);

                        if (!$update) {
                            $allUpdates = false;
                            break;
                        }
                    }
                }

                if ($allUpdates) {

                    $idsOrigen = implode(',', $lotesOrigen);
                    
                    // 4. se regresa el lotes de origen a su estatus de preproceso 0
                    $update = $this->Reestructura_model->updateLotesOrigen($idsOrigen, 0, 2, $idUsuario); // estatus preproceso en 0

                    if($update){
                        $this->db->trans_commit();

                        $result["result"] = true;
                        $result["msg"] = "La fusión ha sido removida correctamente";
                    }
                    else {
                        $this->db->trans_rollback();

                        $result["result"] = false;
                        $result["msg"] = "Error al actualizar los lotes de origen";
                    }
                    
                } else {
                    $this->db->trans_rollback();
                    $result["result"] = false;
                    $result["msg"] = "Error al actualizar los lotes";
                }
            } else {
                $this->db->trans_rollback();
                $result["result"] = false;
                $result["msg"] = "Error: no se han eliminado los destinos de la fusión";
            }
        }
        else{
            $result["result"] = false;
            $result["msg"] = "Faltan datos en el formulario";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($result));
    }

    public function renameFile(){
        $archivoViejo = '/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion-temp/CPPYUC-PCPH-051/CORRIDA/CMPYUC-MALH-012-20240228152528.xlsx';
        $archivoNuevo = '/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion-temp/CPPYUC-PCPH-051/CORRIDA/CMPYUC-MALH-012-20240228152529.xlsx';
        rename($archivoViejo, $archivoNuevo);
    }

    public function eliminaArchivo(){
        //eliminar archivo
        /*unlink('/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion-temp/CMNQRO-CONH-080/RESCISIONES/CMNQRO-CONH-080-20240222110416.pdf');*/

        //eliminar carpeta
        //rmdir('/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion-temp/CMNQRO-CONH-080/');
    }


    public function moverArchivo(){
        $currentLocation = '/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion-temp/YUCA-27 CMLJAL.xlsx';
        $newLocation = '/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion-temp/CMCJAL-UCAH-017/CORRIDA/CMLJAL-YUCH-027-20240119154209.xlsx';
        if(is_file($currentLocation))
        {
            $moved = rename($currentLocation, $newLocation);
        }
        if($moved)
        {
            echo "File moved successfully";
        }
    }

    public function copy(){
        $currentLocation = '/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion/CDMSLP-ALTH-107/CDMSLP_CDMS_45794_142892_TDOC35RESC_1-3-2024.pdf';
        $newLocation = '/mnt/data/aplicaciones/maderascrm/static/documentos/contratacion-reubicacion/CDMSLP-ALTH-107/CDMSLP_CDMS_45794_142892_TDOC41CONT_1-3-2024.pdf';

        copy($currentLocation, $newLocation);
    }

    // PARA EL MÓDULO DE PATRICIA MAYA
    public function reporteCancelaciones() {
        $this->load->view('template/header');
        $this->load->view("reestructura/reporteCancelaciones"); //cancelacionReestructura
    }

    public function getReporteCancelaciones() {
        $dato = $this->Reestructura_model->getReporteCancelaciones($this->input->post('index_proyecto'));
        if ($dato != null)
            echo json_encode($dato);
        else
            echo json_encode(array());
    }

    public function cargaContratoFirmado() {
        $this->load->view('template/header');
        $this->load->view("reestructura/cargaContratoFirmado_view");
    }

    public function getLotesParaCargarContratoFirmado() {
        $data = $this->Reestructura_model->getLotesParaCargarContratoFirmado();
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function getSedes(){
        $data = $this->Reestructura_model->getSedes();
        echo json_encode($data);
    }

    public function cargaContratoReubicacionFirmado() {
        $this->load->view('template/header');
        $this->load->view("reestructura/cargaContratoReubFirmado_view");
    }

    public function getLotesParaCargarContratoReubFirmado() {
        $data = $this->Reestructura_model->getLotesParaCargarContratoReubFirmado();
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function setSolicitudCancelacion(){
		$dataPost = $_POST;
        $data = $this->Reestructura_model->setSolicitudCancelacion($dataPost);
        if ($data == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		} 
    }

    public function returnToRestructure(){
        $dataPost = $_POST;
        $data = $this->Reestructura_model->returnToRestructure($dataPost);
        if ($data == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		} 
    }

    function sumarDiaSinFestivosNiFinDeSemana($fecha) {
        $currentYear = date("Y");
        $festivos = array(
            // Agrega aquí los días festivos en el formato 'YYYY-MM-DD'
            $currentYear . '-01-01',
            $currentYear . '-03-21',
            $currentYear . '-05-01',
            $currentYear . '-09-16',
            $currentYear . '-11-20',
            $currentYear . '-12-25'
        );
    
        $fechaObj = new DateTime($fecha);
        $fechaObj->modify('+1 day');
    
        while (in_array($fechaObj->format('Y-m-d'), $festivos) || $fechaObj->format('N') >= 6) {
            $fechaObj->modify('+1 day');
        }

        return $fechaObj->format('Y-m-d');
    }

    public function regresoPreproceso(){
        $preproceso = $this->input->post("preproceso");
        $juridico = $this->input->post("juridico");
        $contraloria = $this->input->post("contraloria");
        $idLotePv = $this->input->post("idLote");
        $idCliente = $this->input->post("idCliente");
        $comentario = $this->input->post("comentario");

        // $getLotesOrigen = $this->Reestructura_model->getLotesOrigenRe($idLotePv);
        $getLotesDestino = $this->Reestructura_model->getLotesDestinoRe($idLotePv);
        $getFlagCJ = $this->Reestructura_model->getFlagCJ($idLotePv);
        $banderaProceso = true;

        $getStatusLote = $this->Reestructura_model->getStatusLote($idLotePv)->result();
        $statusReestructura = $getStatusLote[0]->anterior;

        $this->db->trans_begin();
        
        if($preproceso <= 3){
            $update = $this->preprocesoCambioRe($idLotePv, $preproceso, $idCliente, $comentario);

            if(!$update){
                $banderaProceso = false;
            }
        }

        if($preproceso <= 2 ){
            if($getFlagCJ->num_rows() > 0 && $preproceso == 2){
                $update = $this->contraloriaJuridicoCambio($idLotePv, $contraloria, $juridico, $getFlagCJ->result());
            }
            else if($preproceso < 2){
                $update = $this->contraloriaJuridicoCambio($idLotePv, 1, 2, $getFlagCJ->result());
            }

            if(!$update){
                $banderaProceso = false;
            }
        }

        if($preproceso <= 1 ){
            $update = $this->updateLotesJuridicoRe($idLotePv);
            $updateRe = $this->updateDocRe($getLotesDestino->result());
            $updateResicion = $this->updateResicionRe($idLotePv, $idCliente);

            if(!$update || !$updateRe || !$updateResicion){
                $banderaProceso = false;
            }
        }

        if($preproceso <= 0 ){
            $tempFlag = true; 
            if($getLotesDestino->num_rows() > 0){
                
                $updateDestino = $this->updateLotesDestinoRe($getLotesDestino->result(), $idLotePv, $statusReestructura);
                if(!$updateDestino){
                    $tempFlag = false;
                }
            }

            $deleteDatos = $this->deletesDatos($idLotePv);
            $deleteCopropietario = $this->deleteCopropietario($idLotePv);

            if(!$deleteDatos || !$tempFlag || !$deleteCopropietario){
                $banderaProceso = false;
            }
        }

        if($banderaProceso){ // aqui se ve si todos los pasos fueron realizados
            $this->db->trans_commit();
            $response["result"] = true;
            $response["message"] = 'Se ha regresado el lote al preproceso ';
        }
        else{
            $this->db->trans_rollback();
            
            $response["result"] = false;
            $response["message"] = 'Error al regresar la fusión';
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function regresoPreprocesoFusion(){
        $preproceso = $this->input->post("preproceso");
        $juridico = $this->input->post("juridico");
        $contraloria = $this->input->post("contraloria");
        $idLotePv = $this->input->post("idLote");
        $idCliente = $this->input->post("idCliente");
        $comentario = $this->input->post("comentario");

        $getLotesOrigen = $this->Reestructura_model->getLotesOrigen($idLotePv);
        $getLotesDestino = $this->Reestructura_model->getLotesDestino($idLotePv);
        $getFlagCJ = $this->Reestructura_model->getFlagCJ($idLotePv);
        $banderaProceso = true;


        $this->db->trans_begin();
        
        if($preproceso <= 3){
            $update = $this->preprocesoCambio($getLotesOrigen->result(), $preproceso, $comentario);

            if(!$update){
                $banderaProceso = false;
            }
        }
        if($preproceso <= 2 ){
            if($getFlagCJ->num_rows() > 0 && $preproceso == 2){
                $update = $this->contraloriaJuridicoCambio($idLotePv, $contraloria, $juridico, $getFlagCJ->result());
            }
            else if($preproceso < 2){
                $update = $this->contraloriaJuridicoCambio($idLotePv, 1, 2, $getFlagCJ->result());
            }

            if(!$update){
                $banderaProceso = false;
            }
        }
        if($preproceso <= 1 ){
            // $update = $this->updateLotesJuridico($getLotesOrigen->result());
            $updateFusion = $this->updateDocFusion($getLotesOrigen->result(), $getLotesDestino->result());

            if(!$update || !$updateFusion){
                $banderaProceso = false;
            }
        }
        if($preproceso <= 0 ){
            $tempFlag = true; 
            if($getLotesDestino->num_rows() > 0){
                $updateDestino = $this->updateLotesDestinoFusion($getLotesDestino->result(), $idLotePv);
                if(!$updateDestino){
                    $tempFlag = false;
                }
            }

            $deleteDatos = $this->deletesDatos($idLotePv);
            $deleteCopropietario = $this->deleteCopropietario($idLotePv);

            if(!$deleteDatos || !$tempFlag || !$deleteCopropietario){
                $banderaProceso = false;
            }
        }

        if($banderaProceso){ // aqui se ve si todos los pasos fueron realizados
            $this->db->trans_commit();
            $response["result"] = true;
            $response["message"] = 'Se ha regresado la fusión al preproceso ';
        }
        else{
            $this->db->trans_rollback();
            
            $response["result"] = false;
            $response["message"] = 'Error al regresar la fusión';
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function preprocesoCambio($getLotesOrigen, $preproceso, $comentario){
        $lotesOrigenInsert = [];
        $lotesOrigenUpdate = [];

        foreach($getLotesOrigen as $lote){
            $lotesOrigenInsert[] = array(
                'idLote' => $lote->idLote,
                'idCliente' => $lote->idCliente,
                'id_preproceso' => $preproceso,
                'comentario' => isset($comentario) ? $comentario :'Regreso de preproceso',
                'estatus' => 2,
                'modificado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion' => date('Y-m-d H:i:s')
            );

            $lotesOrigenUpdate[] = array(
                'idLote' => $lote->idLote,
                'estatus_preproceso' => $preproceso
            );

        }

        $update = $this->General_model->insertBatch('historial_preproceso_lote', $lotesOrigenInsert);

        if($update){
            $update = $this->General_model->updateBatch('lotes', $lotesOrigenUpdate, 'idLote');
        }

        return $update;
    }

    public function preprocesoCambioRe($idLotePv, $preproceso, $idCliente, $comentario){
        $lotesOrigenInsert = array(
            'idLote' => $idLotePv,
            'idCliente' => $idCliente,
            'id_preproceso' => $preproceso,
            'comentario' => isset($comentario) ? $comentario :'Regreso de preproceso',
            'estatus' => 2,
            'modificado_por' => $this->session->userdata('id_usuario'),
            'fecha_modificacion' => date('Y-m-d H:i:s')
        );

        $lotesOrigenUpdate = array(
            'estatus_preproceso' => $preproceso
        );

        $update = $this->General_model->addRecord('historial_preproceso_lote', $lotesOrigenInsert);

        if($update){
            $update = $this->General_model->updateRecord('lotes', $lotesOrigenUpdate, 'idLote', $idLotePv);
        }

        return $update;
    }

    public function contraloriaJuridicoCambio($idLotePv, $contraloria, $juridico, $getFlagCJ){
        $updateData = array(
            'flagProcesoContraloria' => $contraloria == 1 ? 0 : $getFlagCJ[0]->flagProcesoContraloria,
            'flagProcesoJuridico' => $juridico == 2 ? 0 : $getFlagCJ[0]->flagProcesoJuridico
        );

        $update = $this->General_model->updateRecord('datos_x_cliente', $updateData, 'idLote', $idLotePv);

        return $update;
    }

    public function updateLotesJuridicoRe($idLotePv){ // ver si se va a usar

        $lotesOrigenUpdate = array(
            'id_juridico_preproceso' => 0
        );

        $update = $this->General_model->updateRecord('lotes', $lotesOrigenUpdate, 'idLote', $idLotePv);

        return $update;
    }

    public function updateDocFusion($getLotesOrigen, $getLotesDestino){
        $lotesOrigenUpdate = [];
        $lotesDestinoUpdate = [];

        $flag = true;

        foreach($getLotesOrigen as $lote){
            $lotesOrigenUpdate[] = array(
                'idLote' => $lote->idLote,
                'contrato' => null,
                'corrida' => null,
                'rescision' => null
            );
        }
        
        foreach($getLotesDestino as $lote){
            $lotesDestinoUpdate[] = array(
                'idLote' => $lote->idLote,
                'contrato' => null,
                'corrida' => null,
                'rescision' => null
            );
        }

        $updateOrigen = $this->General_model->updateBatch('lotesFusion', $lotesOrigenUpdate, 'idLote');
        $updateDestino = $this->General_model->updateBatch('lotesFusion', $lotesDestinoUpdate, 'idLote');

        if(!$updateOrigen || !$updateDestino){
            $flag = false; 
        }

        return $flag;
    }
    
    public function updateDocRe($getLotesDestino){
        $lotesDestinoUpdate = [];
        $flag = true;

        foreach($getLotesDestino as $lote){
            $lotesDestinoUpdate[] = array(
                'id_lotep' => $lote->id_lotep,
                'corrida' => null,
                'contrato' => null,
                'estatusPreseleccion' => 0,
                'fecha_modificacion' => date('Y-m-d H:i:s')
            );
        }

        $updateDestino = $this->General_model->updateBatch('propuestas_x_lote', $lotesDestinoUpdate, 'id_lotep');

        if(!$updateDestino){
            $flag = false; 
        }

        return $flag;
    }

    public function updateLotesDestinoFusion($getLotesDestino, $idLotePv){
        $lotesDestinoUpdate =[];
        $lotesDelete = [];
        $flag = true;
        
        foreach($getLotesDestino as $lote){
            $lotesDestinoUpdate[] = array(
                'idLote' => $lote->idLote,
                'idStatusLote' => $lote->tipo_estatus_regreso == 2 ? 21 : 15
            );

            $lotesDelete[] = $lote->idLote;
        }

        $updateLotes = $this->General_model->updateBatch('lotes', $lotesDestinoUpdate, 'idLote');
        $deleteDestinos = $this->Reestructura_model->deleteFusionDestinos($lotesDelete, $idLotePv);

        if(!$updateLotes || !$deleteDestinos){
            $flag = false;
        }

        return $flag;
    }

    public function updateLotesDestinoRe($getLotesDestino, $idLotePv, $statusReestructura){
        $lotesDestinoUpdate =[];
        $lotesDelete = [];
        $flag = true;
        
        foreach($getLotesDestino as $lote){
            if($lote->id_lotep != $idLotePv){
                $lotesDestinoUpdate[] = array(
                    'idLote' => $lote->id_lotep,
                    'idStatusLote' => $lote->tipo_estatus_regreso == 2 ? 21 : 15
                );
            }
            else{
                $lotesDestinoUpdate[] = array(
                    'idLote' => $lote->id_lotep,
                    'idStatusLote' => $statusReestructura
                );
            }
            
            $lotesDelete[] = $lote->id_lotep;
        }

        $updateLotes = $this->General_model->updateBatch('lotes', $lotesDestinoUpdate, 'idLote');
        $deleteDestinos = $this->Reestructura_model->deletePropuestasDestinos($lotesDelete, $idLotePv);

        if(!$deleteDestinos || !$updateLotes){
            $flag = false;
        }

        return $flag;
    }

    public function updateResicionRe($idLotePv, $idCliente){
        $update = $this->Reestructura_model->updateRescision($idLotePv, $idCliente);

        return $update;
    }

    public function deletesDatos($idLotePv){
        $flag = false;

        $delete = $this->Reestructura_model->deleteDatos($idLotePv);

        return $delete;
    }

    public function deleteCopropietario($idLotePv){
        $deleteCopropietario = $this->Reestructura_model->deleteCopropietario($idLotePv);

        return $deleteCopropietario;
    }

    public function regresoProcesoVenta(){
        $loteNuevo = $this->input->post('idLote', true);
        $clienteNuevo = $this->input->post('idCliente', true); // se guarda id y cliente nuevo
        $tipoRegresoOrigen = $this->input->post('estatusRegreso', true);
        $comentario = $this->input->post('comentario', true);

        $flagOk = true;
        $msg = '';

        $this->db->trans_begin();

        $getCliente = $this->Reestructura_model->getClienteAnterior($loteNuevo, $clienteNuevo)->result(); // para obtener el cliente anterior y el lote origen        
        
        $clienteAnterior = $getCliente[0]->clienteAnterior; // se guarda id y cliente anterior
        $loteAnterior = $getCliente[0]->loteAnterior;
        $statusLoteAnterior = $getCliente[0]->statusAnterior;
        $statusLoteAnterior2 = $getCliente[0]->statusAnterior2;
        $statusNuevo = $getCliente[0]->statusNuevo;
        $nombreLoteNuevo = $getCliente[0]->nombreLoteNuevo;
        $precioNuevo = $getCliente[0]->precioAnterior; // datos para el insert de historial regreso
        $statusLoteNuevo = $getCliente[0]->statusNuevo;
        $tipoProceso = $getCliente[0]->procesoDestino;
        $comisionNuevo = $getCliente[0]->comisionNuevo;
        $clienteReubicacion = $getCliente[0]->id_cliente_reubicacion_2;

        $getTotalNeto2 = $this->Reestructura_model->getTotalNeto2($loteAnterior)->result();
        $totalNetoAnterior = $getTotalNeto2[0]->anterior;

        // update historial enganche a status 0 - comentario lote libeardo - pendiente  
        // aplicarLiberacion funcion
        // preguntar por las clausulas set clausulas  status = 0 solo si es diferente a fusion - listo
        // insertar en historial liberacion - listo
        // preguntar correo de liberacion a postventa -- pendiente pero listo
        // verificar si se ocupa el lote una vez que paso el 6 checar si se puede - idStatus lote 0 - desocupado y idMovimiento = 0 - listo

        // paso 0 se verifica si el lote de origen esta libre antes de regresar
        if($statusNuevo > 6 && !in_array($statusLoteAnterior2, array(1, 2, 15, 21)) && $loteNuevo != $loteAnterior) {$flagOk = false; $msg = 'error 0'; }

        // paso 1 - insert en tabla de regreso
        $insertRegresoLote = $this->insertRegresoLote($clienteAnterior, $clienteNuevo, $loteAnterior, $loteNuevo, $tipoProceso, $comisionNuevo, $clienteReubicacion);
        if(!$insertRegresoLote){ $flagOk = false; $msg = 'guardar, el lote de origen ya ha sido ocupado';}

        
        // paso 2 - actualizar datos en historial documento
        $updateHistorialDocumento = $this->updateHistorialDocumento($clienteNuevo, $loteNuevo, $clienteAnterior, $loteAnterior);
        if(!$updateHistorialDocumento) { $flagOk = false; $msg = 'actualizar el historia de documentos';}


        // paso 3 - actualizar la tabla historial_lotes
        $updateHistorialLote = $this->updateHistorialLote($clienteNuevo, $loteNuevo, $clienteAnterior, $loteAnterior);
        if(!$updateHistorialLote) { $flagOk = false; $msg = 'guardar el registro del lote de origen';}


        // paso 4 - actualizar clientes 
        $updateClientes = $this->updateClientes($clienteNuevo, $loteNuevo, $clienteAnterior, $loteAnterior);
        if(!$updateClientes) { $flagOk = false; $msg = 'actualizar datos del cliente';}

        // paso 5 - insert into historial_enganche
        // $upadateEnganche = $this->updateEnganche($clienteNuevo, $loteNuevo); // verificar de nuevo

        // paso 6 - update clausulas
        $updateClausulas = $this->updateClausulas($loteNuevo);
        if(!$updateClausulas) { $flagOk = false; $msg = 'guardar el registro de clausulas';}

        // paso 7 - insertar en historial_liberacion
        $updateLiberacion = $this->updateLiberacion($clienteNuevo, $loteNuevo, $nombreLoteNuevo, $precioNuevo);
        if(!$updateLiberacion) { $flagOk = false; $msg = 'guardar el registro de liberación';}


        // paso 8 - liberar el lote de destino
        $updateLoteDestino = $this->updateDestinosProceso($loteNuevo, $loteAnterior, $tipoRegresoOrigen, $clienteAnterior);
        if(!$updateLoteDestino) { $flagOk = false; $msg = 'regresar los destinos';}


        //paso 9 - regresar origen
        $updateOrigen = $this->updateOrigenProceso($loteAnterior, $clienteAnterior, $comentario, $totalNetoAnterior);
        if(!$updateOrigen) { $flagOk = false; $msg = 'regresar los origenes';}


        // último paso, confirmación de que los procesos han sido correctos
        if($flagOk){
           //  $this->db->trans_commit();
            $response["result"] = true;
            $response["message"] = 'Se ha regresado el proceso del lote';
        }
        else{
            $this->db->trans_rollback();
            $response["result"] = false;
            $response["message"] = 'Error al ' . $msg;
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    public function updateHistorialDocumento($clienteNuevo, $loteNuevo, $clienteAnterior, $loteAnterior){
        $flag = true;

        $updateClienteAnterior = $this->Reestructura_model->updateDocumentoAnterior($loteAnterior, $clienteAnterior);
        $updateClienteNuevo = $this->Reestructura_model->updateDocumentoNuevo($loteNuevo, $clienteNuevo);

        if(!$updateClienteAnterior || !$updateClienteNuevo)
            $flag = false;

        return $flag;
    }

    public function updateHistorialLote($clienteNuevo, $loteNuevo, $clienteAnterior, $loteAnterior){
        $flag = true;

        $updateClienteAnterior = $this->Reestructura_model->updateHistorialAnterior($loteAnterior, $clienteAnterior);
        $updateClienteNuevo = $this->Reestructura_model->updateHistorialNuevo($loteNuevo, $clienteNuevo);

        if(!$updateClienteAnterior || !$updateClienteNuevo)
            $flag = false;

        return $flag;
    }

    public function updateClientes($clienteNuevo, $loteNuevo, $clienteAnterior, $loteAnterior){
        $flag = true;

        $updateClienteAnterior = $this->Reestructura_model->updateClienteAnterior($loteAnterior, $clienteAnterior);
        $updateClienteNuevo = $this->Reestructura_model->updateClienteNuevo($loteNuevo, $clienteNuevo);
        $deleteCopropietarioNuevo = $this->Reestructura_model->deleteCopropietario($loteNuevo); // preguntar si esta bien
        $deleteCopropietario = $this->Reestructura_model->deleteCopropietario($loteAnterior);

        if(!$updateClienteAnterior || !$updateClienteNuevo || !$deleteCopropietarioNuevo || !$deleteCopropietario)
            $flag = false;

        return $flag;
    }

    public function updateDestinosProceso($loteNuevo, $loteAnterior, $tipoRegresoOrigen, $clienteAnterior){
        $getLotesDestino = $this->Reestructura_model->getLotesDestinoRe($loteAnterior);
        $destinos = $getLotesDestino->result();
        $flag = true;
        
        if($loteNuevo != $loteAnterior){
            $loteNuevoUpdate = array(
                'idCliente' => $loteNuevo == $loteAnterior ? $clienteAnterior : 0,
                'idStatusContratacion' => 0,
                'idMovimiento' => 0,
                'idStatusLote' => $tipoRegresoOrigen == 2 ? 21 : 15,
                'perfil' => 17, //preguntar -- contraloria
                'usuario' => $this->session->userdata('id_usuario'),
                'fechaVenc' => NULL,
                'ubicacion' => 0,
                'totalNeto2' => 0,
                'tipo_venta' => 0,
                'status8Flag' => 0,
                'totalNeto' => 0,
                'registro_comision' => 9,
                'observacionContratoUrgente' => null,
                'firmaRL' => null,
                'comentarioLiberacion' => 'preguntar',
                'observacionLiberacion' => 'preguntar',
                'fechaLiberacion' => date('Y-m-d H:i:s'),
                'userLiberacion' => $this->session->userdata('id_usuario'),
                'id_usuario_asignado' => 0,
                'asig_jur' => 0,
                'solicitudCancelacion' => 0,
                'id_gerente_asignado' => 0,
                'id_subdirector_asignado' => 0
            );
    
            $updateDestinoSelect = $this->General_model->updateRecord('lotes', $loteNuevoUpdate, 'idLote', $loteNuevo);

            if(!$updateDestinoSelect){
                $flag = false;
            }
        }
        
        if($getLotesDestino->num_rows() > 0){
            foreach($destinos as $lote){
                if($lote->id_lotep != $loteAnterior){
                    $lotesDestinoUpdate[] = array(
                        'idLote' => $lote->id_lotep,
                        'idStatusLote' => $lote->tipo_estatus_regreso == 2 ? 21 : 15
                    );
                }
                
                $lotesDelete[] = $lote->id_lotep;
            }

            $deleteDestinos = $this->Reestructura_model->deletePropuestasDestinos($lotesDelete, $loteAnterior);

            if(!$deleteDestinos){
                $flag = false;
            }

            if(!empty($lotesDestinoUpdate)){
                $updateLotes = $this->General_model->updateBatch('lotes', $lotesDestinoUpdate, 'idLote');

                if(!$updateLotes){
                    $flag = false;
                }
            }   
        }

        return $flag;
    }

    public function updateOrigenProceso($loteAnterior, $clienteAnterior, $comentario, $totalNetoAnterior){
        $flag = true;

        $updateLoteOrigen = array(
            // 'id_usuario_asignado' => 0,
            'id_juridico_preproceso' => 0,
            'estatus_preproceso' => 0,
            'idCliente' => $clienteAnterior,
            'idStatusLote' => 2,
            'idStatusContratacion' => 15,
            'idMovimiento' => 45,
            'totalNeto2' => intval($totalNetoAnterior)
            // 'idStatusLote' => 1
        );

        $lotesOrigenInsert = array(
            'idLote' => $loteAnterior,
            'idCliente' => $clienteAnterior,
            'id_preproceso' => 0,
            'comentario' => $comentario,
            'estatus' => 2,
            'modificado_por' => $this->session->userdata('id_usuario'),
            'fecha_modificacion' => date('Y-m-d h:i:s')
        );

        
        $updateOrigen = $this->General_model->updateRecord('lotes', $updateLoteOrigen, 'idLote', $loteAnterior);
        $insertHistorial = $this->General_model->addRecord('historial_preproceso_lote', $lotesOrigenInsert);
        $deleteDatos = $this->Reestructura_model->deleteDatos($loteAnterior);

   
        // copropietario

        if(!$updateOrigen || !$deleteDatos || !$insertHistorial){
            $flag = false;
        }

        return $flag;
    }

    // public function updateEnganche($clienteNuevo, $loteNuevo){
    //     $insertData = array(
    //         'id' => $
    //     );

    //     $update = $this->General_model->addRecord();
    // }

    public function updateLiberacion($clienteNuevo, $loteNuevo, $nombreLoteNuevo, $precioNuevo){
        $insertData = array(
            'nombreLote' => $nombreLoteNuevo,
            'comentarioLiberacion' => 'Liberación por regreso',
            'observacionLiberacion' => 'Se regreso el lote desde el preproceso',
            'precio' => $precioNuevo,
            'fechaLiberacion' => date('Y-m-d'),
            'modificado' => date('Y-m-d H:i:s'),
            'status' => 1,
            'idLote' => $loteNuevo,
            'userLiberacion' => $this->session->userdata('id_usuario'),
            'tipo' => 1, // preguntar
            'id_cliente' => $clienteNuevo 
        );

        $update = $this->General_model->addRecord('historial_liberacion', $insertData);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('programador.analista34@ciudadmaderas.com')
            //->to('postventa@ciudadmaderas.com')
            ->subject('Notificación de solicitud de cancelación reestructura')
            ->view($this->load->view('mail/reestructura/mailSolicitudCancelacion', [
                'lote' => $nombreLoteNuevo,
                'Observaciones' => 'Observacion de prueba',
                'tipoCancelacion' => 1 // $tipoCancelacionNombre
            ], true));

        $this->email->send();

        return $update;
    }

    public function updateClausulas($loteNuevo){
        $updateData = array(
            'estatus' => 0 
        );

        $update = $this->General_model->updateRecord('clausulas', $updateData, 'id_lote', $loteNuevo);

        return $update;
    }

    public function insertRegresoLote($clienteAnterior, $clienteNuevo, $loteAnterior, $loteNuevo, $tipoProceso, $comisionNuevo, $clienteReubicacion){
        $insertData = array(
            'idClienteOrigen' => $clienteAnterior,
            'idClienteDestino' => $clienteNuevo,
            'idLoteOrigen' => $loteAnterior,
            'idLoteDestino' => $loteNuevo,
            'tipoProceso' => $tipoProceso,
            'planComision' => $comisionNuevo,
            'clienteReubicacion2' => $clienteReubicacion,
            'fechaCreacion' => date('Y-m-d H:i:s'),
            'creadoPor' => $this->session->userdata('id_usuario')
        );
        
        $insert = $this->General_model->addRecord('historial_regreso_reestructura', $insertData);

        return $insert;
    }

    public function bloqueoRegreso(){
        $bandera = $this->input->post("bandera");
        $idLote = $this->input->post("idLoteBandera");
        $idCliente = $this->input->post("idCliente");
        $flagFusion = 0;
        $flagRe = 0;
        $flagPass = true;
        $flagFusion = 0;
        $flagRe = 0;
        $idLotePvOrigen = $this->input->post("idLoteBandera");;

        $dataUpdate = array(
            "liberaBandera" => 0
        );

        $checkFusion = $this->Reestructura_model->checkFusion($idLote); // revisar si es fusión
        $checkRe = $this->Reestructura_model->checkReubicacion($idLote); // revisar si es reubicación 
        $checkRee = $this->Reestructura_model->checkReestructura($idLote); // o reestructura

        $this->db->trans_begin();

        if($checkRe->num_rows() > 0 || $checkRee->num_rows() > 0){
            $flagRe = 1;
        }
        else if($checkFusion->num_rows() > 0){
            $flagFusion = 1;

            $fusionResult = $checkFusion->result();
            $idLotePvOrigen = $fusionResult[0]->idLotePvOrigen;
        }

        $updateBandera = $this->General_model->updateRecord('lotes', $dataUpdate, 'idLote', $idLote);
        if(!$updateBandera) $flagPass = false;

        if($flagPass){
            $this->db->trans_commit();
            $response["result"] = true;
            $response["flagRe"] = $flagRe;
            $response["flagFusion"] = $flagFusion;
            $response["idLotePvOrigen"] = $idLotePvOrigen;
            $response["message"] = "Se ha bloqueado el lote correctamente";
        }
        else{
            $this->db->trans_rollback();
            $response["result"] = false;
            $response["message"] = "Ha ocurrido un error al bloquear el lote";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));        
    }

    public function deshacerFusion(){
        $idLotePv = $this->input->post('idLotePvOrigen');

        $checkFusion = $this->Reestructura_model->checkFusion($idLotePv); // revisar si es fusión
        $data = $checkFusion->result();

        // una vez que se comprueba que haya resultados de la consulta, se guardan los lotes en un arreglo
        foreach ($data as $d) {
            if($d->origen == 1){
                $lotesOrigenUpdate[] = array(
                    'idLote' => $d->idLote,
                    'id_usuario_asignado' => 0,
                    'id_juridico_preproceso' => 0
                );
            }
            else if($d->origen == 0){
                $lotesDestino[] = $d->idLote;
            }
        }
        
        $update = $this->General_model->updateBatch('lotes', $lotesOrigenUpdate, 'idLote');
        $deleteFusion = $this->Reestructura_model->deshacerFusion($idLotePv);

        if($deleteFusion && $update){
            $response["result"] = true;
            $response["message"] = "Se ha bloqueado el lote y eliminado la fusión";
        }
        else{
            $response["result"] = false;
            $response["message"] = "Ha ocurrido un error al deshacer la fusión";
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response)); 
    }

    function getPreOrigen(){
        $idLote = $this->input->post('idLote');

        $getOrigen = $this->Reestructura_model->getPreOrigen($idLote);
        $getDatos = $getOrigen->result();

        if($getOrigen->num_rows() > 0){
            $response["result"] = true;
            $response["message"] = "Se ha obtenido el historial de preproceso";
            $response["idLote"] = $getDatos[0]->idLote;
            $response["proceso"] = $getDatos[0]->proceso;
        }
        else{
            $response["result"] = false;
            $response["message"] = "No hay historial preproceso para este lote";
            $response["idLote"] = 0;
            $response["proceso"] = 0;
        }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));         
    }
}
