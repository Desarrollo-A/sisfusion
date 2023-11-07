<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reestructura extends CI_Controller{
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Reestructura_model','General_model', 'caja_model_outside', 'Contraloria_model', 'Clientes_model'));
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
		$this->load->helper(array('url', 'form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
		$this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
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
        $this->load->view("reestructura/reubicarCliente_view");
	}	

    public function getListaClientesReubicar(){
        $data = $this->Reestructura_model->getListaClientesReubicar();
        echo json_encode($data);
    }

    public function getCliente($idCliente, $idLote){
        $datCliente = $this->Reestructura_model->getDatosClienteTemporal($idLote); // MJ: BUSCA LA INFORMACIÓN EN datos_x_clientes
        $copropietarios = $this->Reestructura_model->obtenerCopropietariosReubicacion($idLote); // MJ: BUSCA COPROPIETARIOS
        if ($datCliente == '') // MJ: SINO ENCUENTRA NADA EN datos_x_clientes SE VA A TRAER LA INFORMACIÓN DE clientes
            $datCliente = $this->Reestructura_model->getCliente($idCliente);
        $datCliente->copropietarios = $copropietarios; // MJ: SE AGREGA LA INFORMACIÓN DE copropietarios
        echo json_encode($datCliente);
    }
    
    public function getEstadoCivil(){
        $data = $this->Reestructura_model->getEstadoCivil();
        echo json_encode($data);
    }

	public function getProyectosDisponibles(){
		$idProyecto = $this->input->post('idProyecto');
		$superficie = $this->input->post('superficie');

		$data = $this->Reestructura_model->getProyectosDisponibles($idProyecto, $superficie);
        echo json_encode($data);
    }

	public function getCondominiosDisponibles(){
		$idProyecto = $this->input->post('idProyecto');
		$superficie = $this->input->post('superficie');

		$data = $this->Reestructura_model->getCondominiosDisponibles($idProyecto, $superficie);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

	public function getLotesDisponibles(){
		$idCondominio = $this->input->post('idCondominio');
        $superficie = $this->input->post('superficie');

		$data = $this->Reestructura_model->getLotesDisponibles($idCondominio, $superficie);
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
		echo json_encode($this->Reestructura_model->get_catalogo_reestructura()->result_array());
	}

	public function insertarOpcionN (){
		$idOpcion = $this->Reestructura_model->insertOpcion();
		$idOpcion = $idOpcion->lastId;
		$dataPost = $_POST;
		$datos["id"] = $idOpcion;
		$datos["nombre"] = $dataPost['nombre'];
		$datos["fecha_creacion"] = date('Y-m-d H:i:s');

		$insert = $this->Reestructura_model->nuevaOpcion($datos);

		if ($insert == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
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

    public function insertarInformacionCli ($idLote){
        $dataPost = $_POST;
        $datos["idLote"] = $dataPost['idLote'];
		$datos["nombre"] = $dataPost['nombreCli'];
		$datos["apellido_paterno"] = $dataPost['apellidopCli'];
		$datos["apellido_materno"] = $dataPost['apellidomCli'];
        $datos["telefono1"] = $dataPost['telefonoCli'];
        $datos["correo"] = $dataPost['correoCli'];
        $datos["domicilio_particular"] = $dataPost['domicilioCli'];
        $datos["estado_civil"] = $dataPost['estadoCli'];
        $datos["ine"] = $dataPost['ineCLi'];
        $datos["ocupacion"] = $dataPost['ocupacionCli'];
        $datos["tipo_proceso"] = $this->input->post('idStatusLote') == 17 ? 3 : 2;
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

	public function getRegistros(){
        $index_proyecto = $this->input->post('index_proyecto');
        $dato = $this->Reestructura_model->get_valor_lote($index_proyecto);
        if ($dato != null) {
            echo json_encode($dato);
        }else{
            echo json_encode(array());
        }
    }

	public function aplicarLiberacion(){
		$dataPost = $_POST;
        $update = $this->Reestructura_model->aplicaLiberacion($dataPost);
        if ($update == TRUE) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
	}

    public function setReestructura(){
        $this->db->trans_begin();
        $idCliente = $this->input->post('idCliente');
        $idAsesor = $this->session->userdata('id_usuario');
        $nombreAsesor = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $idLider = $this->session->userdata('id_lider');
		$clienteAnterior = $this->General_model->getClienteNLote($idCliente)->row();
        $idClienteAnterior = $clienteAnterior->id_cliente;
        $loteAOcupar = $clienteAnterior->idLote;
		$lineaVenta = $this->General_model->getLider($idLider)->row();
        $tipo_venta = $clienteAnterior->tipo_venta;
        $ubicacion = $clienteAnterior->ubicacion;

        $expediente = $this->Reestructura_model->obtenerDocumentacionPorReestructura();
        $loteNuevoInfo = $this->Reestructura_model->obtenerLotePorId($loteAOcupar);
        $documentacionActiva = $this->Reestructura_model->obtenerDocumentacionActiva($clienteAnterior->idLote, $idClienteAnterior);
        $proceso = 3;
        $clienteNuevo = $this->copiarClienteANuevo($clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso);
        $idClienteInsert = $clienteNuevo[0]['lastId'];

        if (!$idClienteInsert) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataLiberacion = [
            'tipoLiberacion' => 8,
            'idLote' => $loteAOcupar,
            'idClienteNuevo' => $idClienteInsert,
            'idClienteAnterior' => $idClienteAnterior
        ];

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
        
        if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if (!$this->copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteInsert, $loteAOcupar)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataUpdateCliente = array(
            'proceso' => $proceso
        );

        if (!$this->General_model->updateRecord("clientes", $dataUpdateCliente, "id_cliente", $idClienteAnterior)){
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $documentacionOriginal = $this->Reestructura_model->obtenerDocumentacionOriginal($clienteAnterior->personalidad_juridica);
        if (!$this->moverExpediente(
            $documentacionOriginal, $clienteAnterior->idLote, $loteAOcupar, $idClienteAnterior, $idClienteInsert,
            $expediente, $loteNuevoInfo, $documentacionActiva
        )) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if (!$this->updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $this->db->trans_commit();
		echo json_encode([
            'titulo' => 'OK',
            'resultado' => TRUE,
            'message' => 'Proceso realizado correctamente.',
            'color' => 'success'
        ]);
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
        $arrayNoDisponible = '';
        foreach ($idLotes as $elementoLote) {
            $dataDisponible = $this->Reestructura_model->checarDisponibleRe($elementoLote);

            if (count($dataDisponible) > 0) {
                if ($dataDisponible[0]['idLote'] == $elementoLote && ($dataDisponible[0]['idStatusLote'] == 15 || $dataDisponible[0]['idStatusLote'] == 1 || $dataDisponible[0]['idStatusLote'] == 2)) {//se checa que el devuelto si este en 15 y sea el que s emandó
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
                foreach ($idLotes as $idLote) {
                    $arrayLote = array(
                        'idLote' => $idLoteOriginal,
                        'id_lotep' => $idLote,
                        'estatus' =>  $proceso == 2 ? 0 : 1,
                        'creado_por' => $this->session->userdata('id_usuario'),
                        'fecha_modificacion' => date("Y-m-d H:i:s"),
                        'modificado_por' => $this->session->userdata('id_usuario')
                    );

                    array_push($arrayLotes, $arrayLote);
                }
                if (!$this->General_model->insertBatch('propuestas_x_lote', $arrayLotes)) {
                    $this->db->trans_rollback();

                    echo json_encode([
                        'titulo' => 'ERROR',
                        'resultado' => FALSE,
                        'message' => 'Error al dar el alta de las propuestas',
                        'color' => 'danger'
                    ]);
                    return;
                }
            }
            foreach ($idLotes as $idLote) {
                $arrayLoteApartado = array(
                    'idLote' => $idLote,
                    'idStatusLote' => ($proceso == 2) ? 16 : 17,
                    'usuario' => $this->session->userdata('id_usuario')
                );

                array_push($arrayLotesApartado, $arrayLoteApartado);
            }
            if (!$this->General_model->updateBatch('lotes', $arrayLotesApartado, 'idLote')) {
                $this->db->trans_rollback();
                echo json_encode([
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ]);
                return;
            }
            $updateLoteOriginal = array(
                'estatus_preproceso' => 1,
                'usuario' => $this->session->userdata('id_usuario')
            );
            if (!$this->General_model->updateRecord("lotes", $updateLoteOriginal, "idLote", $idLoteOriginal)) {
                $this->db->trans_rollback();
                echo json_encode([
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ]);
                return;
            }

            if (!$this->copiarCopropietariosAnteriores($idCliente, $idLoteOriginal)) {
                $this->db->trans_rollback();
                echo json_encode([
                    'titulo' => 'ERROR',
                    'resultado' => FALSE,
                    'message' => 'Error al actualizar en apartado los lotes',
                    'color' => 'danger'
                ]);
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

        $idClienteAnterior = $this->input->post('idCliente');
        $loteAOcupar = $this->input->post('idLote');
        $idLoteOriginal = $this->input->post('idLoteOriginal');
        $idAsesor = $this->session->userdata('id_usuario');
		$nombreAsesor = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $idLider = $this->session->userdata('id_lider');
		$clienteAnterior = $this->General_model->getClienteNLote($idClienteAnterior)->row();
        $loteSelected = $this->Reestructura_model->getSelectedSup($loteAOcupar)->row();
        $idCondominio = $loteSelected->idCondominio;
        $lineaVenta = $this->General_model->getLider($idLider)->row();
		$nuevaSup = floatval($loteSelected->sup);
		$anteriorSup = floatval($clienteAnterior->sup);
		$proceso = ( $anteriorSup == $nuevaSup || (($nuevaSup - $anteriorSup) <= ($anteriorSup * 0.05))) ? 2 : 4;
        $tipo_venta = $clienteAnterior->tipo_venta;
        $ubicacion = $clienteAnterior->ubicacion;

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

        $clienteNuevo = $this->copiarClienteANuevo($clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $loteSelected, $idCondominio);
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

        $dataUpdateCliente = array(
            'proceso' => 2,
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

    public function copiarClienteANuevo($clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $loteSelected = null, $idCondominio = null) {
        $dataCliente = [];
        $camposOmitir = ['id_cliente','nombreLote', 'sup', 'tipo_venta', 'ubicacion'];

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
                $dataCliente = array_merge([$clave => $loteSelected->idLote], $dataCliente);
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
                $dataCliente = array_merge([$clave =>  $proceso == 3 ? 64 : ($proceso == 2 ? 65 : 66) ], $dataCliente);
                continue;
            } else if ($clave == 'status') {
                $dataCliente = array_merge([$clave =>  1], $dataCliente);
                continue;
            } else if ($clave == 'proceso') {
                $dataCliente = array_merge([$clave =>  $proceso], $dataCliente);
                continue;
            } else if ($clave == 'totalNeto2Cl') {
                $dataCliente = array_merge([$clave =>  0], $dataCliente);
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
            'ubicacion' =>$ubicacion
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
        $loteInfo = null, $docInfo = null
    ): bool
    {
        $loteAnteriorInfo = $this->Reestructura_model->obtenerLotePorId($idLoteAnterior);
        $loteNuevoInfo = (is_null($loteInfo))
            ? $this->Reestructura_model->obtenerLotePorId($idLoteNuevo)
            : $loteInfo;
        $docAnterior = (is_null($docInfo))
            ? $this->Reestructura_model->obtenerDocumentacionActiva($idLoteAnterior, $idClienteAnterior)
            : $docInfo;
        $totalPropuestas = count($this->Reestructura_model->getNotSelectedLotes($idLoteAnterior));

        $documentacion = [];
        $modificado = date('Y-m-d H:i:s');
        $documentosSinPasar = (is_null($docInfo)) ? [7, 8, '7', '8'] : [];

        $ubicacionFolder = "static/documentos/contratacion-reubicacion/$loteNuevoInfo->nombreLote/";

        if (!file_exists($ubicacionFolder)) {
            $result = mkdir($ubicacionFolder, 0777, TRUE);
            if (!$result) {
                return false;
            }
        }

        // Ciclo para vaciar ramas del expediente anterior
        foreach ($docAnterior as $doc) {
            $expedienteAnterior = in_array($doc['tipo_doc'], $documentosSinPasar) ? null : $doc['expediente'];

            if ($doc['tipo_doc'] == 7 || $doc['tipo_doc'] == 8) {
                $expReubicacion = $this->Reestructura_model->expedienteReubicacion($idLoteAnterior);
                $carpeta = '';

                if ($doc['tipo_doc'] == 7) {
                    $carpeta = 'CORRIDA/';
                    $expedienteAnterior = $expReubicacion->corrida;
                } else if ($doc['tipo_doc'] == 8) {
                    $carpeta = 'CONTRATO/';
                    $expedienteAnterior = $expReubicacion->contrato;
                }

                if (!is_null($expedienteAnterior)) {
                    copy(
                        "static/documentos/contratacion-reubicacion-temp/$loteAnteriorInfo->nombreLote/$carpeta$expedienteAnterior",
                        $ubicacionFolder.$expedienteAnterior
                    );
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
                'estatus_validacion' => 0
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
                'estatus_validacion' => 0
            );
        }

        // Ciclo para las nuevas ramas a agregar
        foreach ($expedienteNuevo as $doc) {
            if ($doc['id_opcion'] == 33 || $doc['id_opcion'] == 36) {
                $expRescision = $this->Reestructura_model->obtenerDatosClienteReubicacion($idLoteAnterior);

                copy(
                    "static/documentos/contratacion-reubicacion-temp/$loteAnteriorInfo->nombreLote/RESCISIONES/$expRescision->rescision",
                    $ubicacionFolder.$expRescision->rescision
                );

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
                    'estatus_validacion' => 0
                );

                continue;
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
                    'estatus_validacion' => 0
                );

                continue;
            }

            if ($doc['id_opcion'] == 42 && $totalPropuestas === 0) {
                continue;
            }
            if ($doc['id_opcion'] == 43 && $totalPropuestas <= 1) {
                continue;
            }

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
                'estatus_validacion' => 0
            );
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

	public function cancelarLotes(){
		$this->load->view('template/header');
        $this->load->view("reestructura/cancelacion_view");
    }

	public function getregistrosLotes(){
        $index_proyecto = $this->input->post('index_proyecto');
        $dato = $this->Reestructura_model->getLotes($index_proyecto);
        if ($dato != null) {
            echo json_encode($dato);
        }else{
            echo json_encode(array());
        }
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
        $updateData = array("id_usuario_asignado" => $this->input->post('idAsesor'), "usuario" => $this->session->userdata('id_usuario'));
        echo json_encode($this->General_model->updateRecord("lotes", $updateData, "idLote", $this->input->post('idLote')));
    }
    
    public function cambiarBandera  ()
    {
        $bandera   =  $this->input->post('bandera');
        $idLote    =  $this->input->post('idLoteBandera');
           $arr_update = array( 
                            "liberaBandera"   => $bandera,
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
	    $data['opcionesLotes'] = $this->Reestructura_model->getOpcionesLote($idLote);
	    $data['copropietarios'] = $this->Reestructura_model->getCopropietariosReestructura($idLote);
        echo json_encode ($data);
    }

    function updateArchivos(){
        $flagAction = $_POST['tipoProceso'];
        $arrayLength = $_POST['longArray'];
        $nombreLoteOriginal = $_POST['nombreLoteOriginal'];
        $id_dxc = $_POST['id_dxc'];
        $editar = $_POST['editarFile'];




        $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal;
        if (!file_exists($micarpeta)) {
            mkdir($micarpeta, 0777, true) or die("Error en la generación");
        }

        if($flagAction==2){
            $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/CORRIDA';
            if (!file_exists($micarpeta)) {
                mkdir($micarpeta, 0777, true);
            }
            $carpetaUbicacion = 'CORRIDA/';
            $nameField = 'corrida';
            $acceptFiles = 'xlsx|csv|xls';
        }elseif($flagAction==3){
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
        $this->load->library('upload', $config);
        $flagInterno = 0;
        for($i=0; $i<$arrayLength; $i++){

            $resultado = $this->upload->do_upload('archivo'.$i);
            if($resultado){
                $archivoSubido = $this->upload->data();
                $fileNameCmps = explode(".", $_FILES['archivo'.$i]['name']);
                $fileExtension = strtolower(end($fileNameCmps));
                $nuevoNombre = $this->input->post('nombreLote'.$i).'-'.date('YmdHis').'.'.$fileExtension;
                rename( $archivoSubido['full_path'], "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal.'/'.$carpetaUbicacion.$nuevoNombre );
                $idpxl = $this->input->post('idLoteArchivo'.$i);

                $updateDocumentData = array(
                    $nameField => $nuevoNombre,
                    "fecha_modificacion" => date('Y-m-d H:i:s'),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );

                $result = $this->General_model->updateRecord("propuestas_x_lote", $updateDocumentData, "id_pxl", $idpxl);
                if($result){
                    $flagInterno = $flagInterno + 1;
                    if($editar==1){
                        $urlEliminar = "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal.'/'.$carpetaUbicacion.$_POST['archivoEliminar'.$i];
                        $this->eliminaArchivoServer($urlEliminar);
                    }
                }
            }
        }
        if($flagAction == 3){
            $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/RESCISIONES';
            if (!file_exists($micarpeta)) {
                mkdir($micarpeta, 0777, true);
            }
            $config2['upload_path'] = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/RESCISIONES/';
            $config2['allowed_types'] = 'pdf';
            $this->load->library('upload', $config2);
            $resultado2 = $this->upload->do_upload('archivoResicion');
            if($resultado2){
                $archivoSubido2 = $this->upload->data();
                $fileNameCmps2 = explode(".", $_FILES['archivoResicion']['name']);
                $fileExtension2 = strtolower(end($fileNameCmps2));
                $nuevoNombre2 = $nombreLoteOriginal.'-'.date('YmdHis').'.'.$fileExtension2;
                rename( $archivoSubido2['full_path'], "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal."/RESCISIONES/".$nuevoNombre2 );

                $updateDocumentData = array(
                    "rescision" => $nuevoNombre2,
                    "fecha_modificacion" => date('Y-m-d H:i:s'),
                    "modificado_por" => $this->session->userdata('id_usuario')
                );

                $this->General_model->updateRecord("datos_x_cliente", $updateDocumentData, "id_dxc", $id_dxc);
                if($editar==1){
                    $urlEliminar = "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal."/RESCISIONES/".$_POST['rescisionArchivo'];
                    $this->eliminaArchivoServer($urlEliminar);
                }

            }
        }

        if($flagInterno==$arrayLength){
            print_r( json_encode(array('code' => 200)));
        }else{
            print_r(json_encode(array('code' => 500)));
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
        $nombreLoteOriginal = $_POST['nombreLoteOriginal'];
        $id_dxc = $_POST['id_dxc'];
        $editar = $_POST['editarFile'];



        $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal;
        if (!file_exists($micarpeta)) {
            mkdir($micarpeta, 0777, true);
        }

        if($flagAction==2){
            $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/CORRIDA';
            if (!file_exists($micarpeta)) {
                mkdir($micarpeta, 0777, true);
            }
            $carpetaUbicacion = 'CORRIDA/';
            $nameField = 'corrida';
            $acceptFiles = 'xlsx|csv|xls';
        }elseif($flagAction==3){
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
        $this->load->library('upload', $config);
        $flagInterno = 0;
        for($i=0; $i<$arrayLength; $i++){
            if($_POST['flagEditado'.$i] == 0){
                $flagInterno = $flagInterno + 1;
            }else{
                $resultado = $this->upload->do_upload('archivo'.$i);
                if($resultado){
                    $archivoSubido = $this->upload->data();
                    $fileNameCmps = explode(".", $_FILES['archivo'.$i]['name']);
                    $fileExtension = strtolower(end($fileNameCmps));
                    $nuevoNombre = $this->input->post('nombreLote'.$i).'-'.date('YmdHis').'.'.$fileExtension;
                    rename( $archivoSubido['full_path'], "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal.'/'.$carpetaUbicacion.$nuevoNombre );
                    $idpxl = $this->input->post('idLoteArchivo'.$i);

                    $updateDocumentData = array(
                        $nameField => $nuevoNombre,
                        "fecha_modificacion" => date('Y-m-d H:i:s'),
                        "modificado_por" => $this->session->userdata('id_usuario')
                    );

                    $result = $this->General_model->updateRecord("propuestas_x_lote", $updateDocumentData, "id_pxl", $idpxl);
                    if($result){
                        $flagInterno = $flagInterno + 1;
                        if($editar==1){
                            $urlEliminar = "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal.'/'.$carpetaUbicacion.$_POST['archivoEliminar'.$i];
                            $this->eliminaArchivoServer($urlEliminar);
                        }
                    }
                }
            }

        }
        if($flagAction == 3){
            if($_POST['flagEditarRescision'] == 1){
                $micarpeta = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/RESCISIONES';
                if (!file_exists($micarpeta)) {
                    mkdir($micarpeta, 0777, true);
                }
                $config2['upload_path'] = 'static/documentos/contratacion-reubicacion-temp/'.$nombreLoteOriginal.'/RESCISIONES/';
                $config2['allowed_types'] = 'pdf';
                $this->load->library('upload', $config2);
                $resultado2 = $this->upload->do_upload('archivoResicion');
                if($resultado2){
                    $archivoSubido2 = $this->upload->data();
                    $fileNameCmps2 = explode(".", $_FILES['archivoResicion']['name']);
                    $fileExtension2 = strtolower(end($fileNameCmps2));
                    $nuevoNombre2 = $nombreLoteOriginal.'-'.date('YmdHis').'.'.$fileExtension2;
                    rename( $archivoSubido2['full_path'], "static/documentos/contratacion-reubicacion-temp/".$nombreLoteOriginal."/RESCISIONES/".$nuevoNombre2 );

                    $updateDocumentData = array(
                        "rescision" => $nuevoNombre2,
                        "fecha_modificacion" => date('Y-m-d H:i:s'),
                        "modificado_por" => $this->session->userdata('id_usuario')
                    );

                    $this->General_model->updateRecord("datos_x_cliente", $updateDocumentData, "id_dxc", $id_dxc);
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
            print_r(json_encode(array('code' => 500)));
        }
    }

    public function obtenerPropuestasXLote(){
        $idLote =  $this->input->post('idLoteOriginal');
        echo json_encode( $this->Reestructura_model->obtenerPropuestasXLote($idLote)->result_array());
    }

    public function setAvance()
    {
        $estatusMovimientos = [
            1 => 1, // Si el movimiento anterior es nuevo, el sig pasa a nuevo
            2 => 3, // Si el movimiento ant. es rechazo, el sig pasa a corrección
            3 => 1 // Si el movimiento ant. es corrección, el sig pasa a nuevo
        ];

        $idLote = $this->input->post('idLote');
        $idPreproceso = $this->input->post('tipoTransaccion');
        $idCliente = $this->input->post('idCliente');
        $comentario = $this->input->post('comentario');
        $idMovimiento = $this->input->post('idEstatusMovimento');
        $idUsuario = $this->session->userdata('id_usuario');

        $assigned_user = 0;
        if ($idPreproceso + 1 == 3) { // AVANCE A JURÍDICO: SE CORRE PROCESO PARA ASIGNAR EXPEDIENTE
            $id_asig = $this->Contraloria_model->get_id_asig('reestructura')->contador;
            if ($id_asig == 2747) // CARLITOS
                $assigned_user = 2762; // SE ASIGNA A DANI
            else if ($id_asig == 2762) // ES DANI
                $assigned_user = 13691; // SE ASIGNA A CECILIA
            else if ($id_asig == 13691) // ES CECILIA
                $assigned_user = 2747; // SE LE ASIGNA A CARLITOS
        
            $dataUpdateVariable = array('contador' => $assigned_user);
            $responseVariable = $this->General_model->updateRecord("variables", $dataUpdateVariable, "identificador", 'reestructura');
        }

        $dataUpdateLote = [
			'estatus_preproceso' => $idPreproceso + 1,
			'usuario' => $idUsuario,
            'id_juridico_preproceso' => $assigned_user
        ];

        $dataHistorial = [
            'idLote' => $idLote,
            'idCliente' => $idCliente,
            'id_preproceso' => $idPreproceso,
            'comentario' => $comentario,
            'estatus' => $estatusMovimientos[$idMovimiento],
            'modificado_por' => $idUsuario
        ];

        $responseUpdateLote = $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $idLote);
        $responseInsertHistorial = $this->General_model->addRecord('historial_preproceso_lote', $dataHistorial);

        echo json_encode($responseUpdateLote && $responseInsertHistorial);
    }
    
    public function setLoteDisponible()
    {
        $dataUpdateLote = [
            'idStatusLote' => $this->input->post('tipoEstatusRegreso') == 1 ? 15: 1,
            'usuario' => $this->session->userdata('id_usuario'),
            'estatus_preproceso' => $this->input->post('tipoProceso') == 3 ? 0 : 1
        ];

        $responseUpdateLote = $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $this->input->post('idLote'));
        $responseDeletePropuesta = $this->General_model->deleteRecord('propuestas_x_lote', ['id_pxl' => $this->input->post('id_pxl')]);

        echo ($responseUpdateLote && $responseDeletePropuesta);
    }

    public function agregarLotePropuesta()
    {
        $idLoteOriginal = $this->input->post('idLoteOriginal');
        $idLotePropuesta = $this->input->post('idLotePropuesta');

        $lote = $this->Reestructura_model->checarDisponibleRe($idLotePropuesta);
        if (count($lote) === 0) {
            echo json_encode(['code' => 400, 'message' => 'Lote no disponible. Favor de verificarlo']);
            return;
        }

        $dataUpdateLote = [
            'idStatusLote' => 16,
            'usuario' => $this->session->userdata('id_usuario')
        ];
        
        $dataInsertPropuestaLote = [
            'idLote' => $idLoteOriginal,
            'id_lotep' => $idLotePropuesta,
            'estatus' => 0,
            'creado_por' => $this->session->userdata('id_usuario'),
            'fecha_modificacion'   => date("Y-m-d H:i:s"),
            'modificado_por' => $this->session->userdata('id_usuario')
        ];

        $responseUpdateLote = $this->General_model->updateRecord('lotes', $dataUpdateLote, 'idLote', $idLotePropuesta);
        $responseInsertPropuesta = $this->General_model->addRecord('propuestas_x_lote', $dataInsertPropuestaLote);

        echo ($responseUpdateLote && $responseInsertPropuesta) ? json_encode(['code' => 200]) : json_encode(['code' => 500]);
    }

    public function totalPropuestas($idLoteOriginal)
    {
        $totalPropuestas = $this->Reestructura_model->obtenerTotalPropuestas($idLoteOriginal);
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
                'idStatusLote' => $lote['tipo_estatus_regreso'] == 1 ? 15 : 1,
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
	    $idLote = $this->input->post('idLote');
	    $nombreLote = $this->input->post('nombreLoteOriginal');
	    $idDocumento = $this->input->post('idDocumento');
	    $editarFile = $this->input->post('editarFile');
	    $idCliente = $this->input->post('idCliente');
	    $idCondominio = $this->input->post('idCondominio');
        $idUsuario = $this->session->userdata('id_usuario');
        $nombreResidencial = $this->input->post('nombreResidencial');
        $nombreCondominio = $this->input->post('nombreCondominio');
        $nombreDocumento = $this->input->post('nombreDocumento');

	    $dataConsultaCF = $this->Reestructura_model->revisarCFDocumentos($idLote, $idCliente);
	    $flagExisteRama = count($dataConsultaCF);
        $configCF['upload_path'] = 'static/documentos/cliente/contratoFirmado/';
        $configCF['allowed_types'] = 'pdf';
        $this->load->library('upload', $configCF);

	    if($editarFile == 0){

            if($flagExisteRama == 0){//no existe la rama se debe crear
                $contratoSubido = $this->upload->do_upload('contratoFirmado');

                if($contratoSubido){
                    $archivoSubido = $this->upload->data();
                    $nombreExpediente = $this->generarNombreFile($nombreResidencial, $nombreCondominio, $nombreLote, $idCliente,  $_FILES["contratoFirmado"]["name"]);
                    rename( $archivoSubido['full_path'], "static/documentos/cliente/contratoFirmado/".$nombreExpediente );

                    $dataInsert = array(
                        'movimiento' => "CONTRATO FIRMADO",
                        'expediente' => $nombreExpediente,
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
                    );
                    $insert = $this->General_model->addRecord('historial_documento', $dataInsert);
                    if($insert){
                        print_r( json_encode(array('code' => 200)));
                    }else{
                        print_r( json_encode(array('code' => 400)));
                    }
                }else{
                    print_r( json_encode(array('code' => 500)));
                }

            }
        }
        elseif($editarFile == 1){
            $contratoCF = $this->upload->do_upload('contratoFirmado');
            if($contratoCF){
                $contratoCFUP = $this->upload->data();
                $nombreExpediente = $this->generarNombreFile($nombreResidencial, $nombreCondominio, $nombreLote, $idCliente, $_FILES["contratoFirmado"]["name"]);
                rename( $contratoCFUP['full_path'], "static/documentos/cliente/contratoFirmado/".$nombreExpediente );

                $data_actualizar = array(
                    'modificado' => date('Y-m-d H:i:s'),
                    'idUser'     => $this->session->userdata('id_usuario'),
                    'expediente' => $nombreExpediente
                );
                $update = $this->General_model->updateRecord('historial_documento', $data_actualizar, 'idDocumento', $idDocumento);
                if($update){
                    print_r( json_encode(array('code' => 200)));
                    unlink('static/documentos/cliente/contratoFirmado/'.$nombreDocumento);
                }
            }
        }
	    exit;
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
        $composicion = $proyecto."_".$cond.$numeroLote."_".$date;
        $nombArchivo=$composicion;
        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
        $expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'.'.$extension;
        return $expediente;
    }
    
    public function rechazarRegistro()
    {
        $idPreproceso = $this->input->post('tipoTransaccion');
        $idLote = $this->input->post('idLote');
        $idCliente = $this->input->post('idCliente');
        $comentario = $this->input->post('comentario');
        $idUsuario = $this->session->userdata('id_usuario');

        $dataUpdateLote = [
            'estatus_preproceso' => $idPreproceso - 1,
            'usuario' => $idUsuario
        ];

        $dataHistorial = [
            'idLote' => $idLote,
            'idCliente' => $idCliente,
            'id_preproceso' => $idPreproceso,
            'comentario' => $comentario,
            'estatus' => 2,
            'modificado_por' => $idUsuario
        ];

        $responseUpdateLote = $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $idLote);
        $responseInsertHistorial = $this->General_model->addRecord('historial_preproceso_lote', $dataHistorial);

        echo ($responseUpdateLote && $responseInsertHistorial)
            ? json_encode(['code' => 200])
            : json_encode(['code' => 500]);
    }

    public function getListaUsuariosReasignacionJuridico() {
        echo json_encode($this->Reestructura_model->getListaUsuariosReasignacionJuridico());
    }

    public function setEjecutivoJuridico() {
        $updateData = array("id_juridico_preproceso" => $this->input->post('id_usuario'), "usuario" => $this->session->userdata('id_usuario'));
        echo json_encode($this->General_model->updateRecord("lotes", $updateData, "idLote", $this->input->post('idLote')));
    }

    public function reporteReubicaciones(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reporteReubicaciones_view");
	}

    public function getReporteReubicaciones() {
        echo json_encode($this->Reestructura_model->getReporteReubicaciones());
    }

    public function copiarCopropietariosAnteriores($idCliente, $idLote): bool
    {
        $copropietarios = $this->Reestructura_model->obtenerCopropietariosPorIdCliente($idCliente);

        if (count($copropietarios) === 0) {
            return true;
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
                'fecha_nacimiento' => $coopropietario['fecha_nacimiento'],
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
        $archivoNombre = 'static/documentos/contratacion-reubicacion-temp/CMMSLP-PATH-001/RESCISIONES/CMMSLP-PATH-001-20231017225640.pdf';
        unlink($archivoNombre);
    }

    public function lista_proyecto(){
        $bandera = $this->input->post('bandera');
		if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 10878 || $this->session->userdata('id_rol') == 4)
			echo json_encode($this->Reestructura_model->get_proyecto_listaCancelaciones()->result_array());
		else if($this->session->userdata('id_usuario') == 5107 && $bandera == 1) // MJ: SELECT DE LA VISTA LIBERAR
          echo json_encode($this->Reestructura_model->get_proyecto_lista_yola()->result_array());
        else // MJ: SELECT DE LA VISTA reestructura
            echo json_encode($this->Reestructura_model->get_proyecto_lista(1)->result_array());
    }

    public function borrarOpcion(){

		$dataPost = $_POST;
		$datos["idOpcion"] = $dataPost['idOpcion'];
		$update = $this->Reestructura_model->borrarOpcionModel($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
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
}
