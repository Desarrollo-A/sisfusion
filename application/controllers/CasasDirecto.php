<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class CasasDirecto extends BaseController
{
    private $idRol;
    private $idUsuario;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('CasasDirectoModel'));
        $this->load->model('General_model');

        $this->load->library(['session']);
        $this->load->library('email');

        $this->idRol = $this->session->userdata('id_rol');
        $this->idUsuario = $this->session->userdata('id_usuario');
    }

    /*
    ******************* Vistas ******************  
    */
    public function documentacionDirecto($proceso)
    {
        $lote = $this->CasasDirectoModel->getProcesoDirecto($proceso);
        $data = [
            'lote' => $lote,
        ];

        $this->load->view('template/header');
        $this->load->view("casas/creditoDirecto/documentacion", $data);
    }

    public function creditoDirectoCaja()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/cajas_adeudo_view");
    }

    public function ordenCompra()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/ordenCompra_view");
    }

    public function adeudoCreditoDirecto()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/admon_adeudo_view");
    }

    public function expediente()
    {
        $this->load->view("template/header");

        $this->load->view("casas/creditoDirecto/expediente_view");
    }

    /*
    ******************* Utilidades ******************  
    */
    public function generateFileName($documento, $lote, $proceso, $archivo)
    {
        $file_ext = pathinfo($archivo, PATHINFO_EXTENSION);

        $documento = strtoupper($documento);
        $documento = str_replace(" ", "_", $documento);

        $lote = str_replace("-", "_", $lote);

        $filename = $documento . "_" . $lote . "_" . $proceso . '.' . $file_ext;

        $input = ['+', "'", '`', '^', 'à', '{', '}', ']', '[', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü', 'â', 'ã', 'ä', 'å', 'ā', 'ă', 'ą', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ā', 'Ă', 'Ą', 'è', 'é', 'é', 'ê', 'ë', 'ē', 'ĕ', 'ė', 'ę', 'ě', 'Ē', 'Ĕ', 'Ė', 'Ę', 'Ě', 'ì', 'í', 'î', 'ï', 'ì', 'ĩ', 'ī', 'ĭ', 'Ì', 'Í', 'Î', 'Ï', 'Ì', 'Ĩ', 'Ī', 'Ĭ', 'ó', 'ô', 'õ', 'ö', 'ō', 'ŏ', 'ő', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ō', 'Ŏ', 'Ő', 'ù', 'ú', 'û', 'ü', 'ũ', 'ū', 'ŭ', 'ů', 'Ù', 'Ú', 'Û', 'Ü', 'Ũ', 'Ū', 'Ŭ', 'Ů', '(', ')', ' ', 'Ñ', 'ñ'];
        $output = '';

        $filename = str_replace($input, $output, $filename);

        return $filename;
    }

    public function UploadDocumentoCreditoDirecto()
    {
        $idProceso = $this->form('idProceso');
        $proceso = $this->form('proceso');
        $nombre_lote = $this->form('nombre_lote');
        $tipoDocumento = $this->form('tipoDocumento') ? $this->form('tipoDocumento') : 1;
        $id_documento = $this->form('id_documento');
        $idCliente = $this->form('idCliente');
        $file = $this->file('file_uploaded');

        if (!isset($proceso) || !isset($nombre_lote) || !isset($id_documento)) {
            http_response_code(400);
            $this->json([]);
        }

        if (!$file) {
            http_response_code(400);
        } else {

            // Consulta nombre tipo documento
            $documento = $this->CasasDirectoModel->getDocumentoCreditoDirecto($id_documento);

            $name_documento = $documento->result()[0]->nombre;

            //  Nombre del archivo          
            $filename = $this->generateFileName($name_documento, $nombre_lote, $idProceso, $file->name);

            // Se sube archivo al buket
            $uploaded = $this->upload($file->tmp_name, $filename);

            if ($uploaded) {

                $created = $this->CasasDirectoModel->insertDocProcesoCreditoDirecto($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento, $this->idUsuario);

                if ($created) {
                    $motivo = "Se subió archivo: $name_documento";
                    $this->CasasDirectoModel->addHistorial($idProceso, $proceso, $proceso, $motivo, 1, $idCliente);

                    $this->json([]);
                }
            }
        }

        http_response_code(404);
    }

    public function uploadDocumentoPersona() {

        $idProceso = $this->form('idProceso');
        $idDocumento = $this->form('idDocumento');
        $nombreDocumento = $this->form('nombreDocumento');
        $file = $this->file('file_uploaded');
        $nombreLote = $this->form('nombreLote');
        
        if (!isset($idProceso) || !isset($idDocumento) || !isset($nombreDocumento) || !isset($nombreLote) || ! $file) {
            http_response_code(400);
            $this->json([]);
        }

        $proceso = $this->CasasDirectoModel->getProcesoDirecto($idProceso);
        $idCliente = $proceso->idCliente;
        
        //  Nombre del archivo          
        $filename = $this->generateFileName($nombreDocumento, $nombreLote, $idProceso, $file->name);

        // Se sube archivo al buket
        $uploaded = $this->upload($file->tmp_name, $filename);

        if ($uploaded) {
            $created = $this->CasasDirectoModel->insertDocProcesoCreditoDirecto($idProceso, $nombreDocumento, $filename, $idDocumento, 2, $this->idUsuario);

            if ($created) {
                $motivo = "Se subió archivo: $nombreDocumento";
                $this->CasasDirectoModel->addHistorial($idProceso, $proceso->proceso, $proceso->proceso, $motivo, 1, $idCliente);

                $this->json([]);
            }
        }
    }

    public function archivo($name)
    {
        $object = $this->bucket->object(urldecode($name));

        if ($object->exists()) {
            $contentType = $object->info()['contentType'];

            $file = $object->downloadAsString();

            header("Content-type: $contentType");

            print($file);
        } else {
            header("HTTP/1.1 404 Not Found");

            http_response_code(404);
        }
    }

    public function setAdeudo()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $adeudo = $form->adeudo;

        $this->db->trans_begin();

        $updateData = array(
            "adeudo"            => $adeudo,
            "fechaModificacion" => date("Y-m-d H:i:s")
        );

        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        if ($update) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    /*
    ****************** Listas ******************  
    */
    public function lista_documentos_cliente_directo($proceso)
    {
        $idCliente = $this->CasasDirectoModel->getProcesoDirecto($proceso)->idCliente;
        $documentos = [];
        $persona = $this->CasasDirectoModel->getTipoPersona($idCliente)->personalidad_juridica ;
        $tipos = [];
        $catalogoPersona = '';

        if ($persona == 1) {
            # Persona moral
            $tipos = [10,11,12,7,8,17,29,30,22,23,24,25];
            $catalogoPersona = 32;
        } else if ($persona == 2) {
            # Persona fisica
            $tipos = [2,3,4,7,8,20,26,27,28,29,30];
            $catalogoPersona = 31;
        }

        // switch ($this->idRol) {
            // case '12':
                $documentos = $this->CasasDirectoModel->getListaDocumentosClienteDirecto($proceso, $tipos, $catalogoPersona);
                // break;
        // }
        $this->json($documentos);
    }

    public function lotesCreditoDirecto()
    {
        $data = $this->input->get();
        $proceso = $data["proceso"];

        $tipoDocumento = isset($data["tipoDocumento"]) ? $data["tipoDocumento"] : 0;
        $nombreDocumento = isset($data["nombreDocumento"]) ? $data["nombreDocumento"] : '';

        if (!isset($proceso)) {
            $proceso = 0; // se asigna esta variable para saber de que proceso se van a mostrar
        }

        $lotes = $this->CasasDirectoModel->lotesCreditoDirecto($proceso, $tipoDocumento, $nombreDocumento)->result();

        $this->json($lotes);
    }

    /*
    ******************* Avances ****************** 
    */
    public function creditoDirectoAvance()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $form->idCliente;

        if (!isset($idProceso) || !isset($proceso) || !isset($comentario) || !isset($idCliente)) {
            http_response_code(400);

            $this->json([]);
        }

        $this->db->trans_begin();


        $pasos = $this->CasasDirectoModel->getPasos($idProceso, 1);

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $pasos->avance,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            'idCliente' => $idCliente,
            "idMovimiento" => $this->idUsuario
        );

        $dataProceso = array(
            "comentario"        => $comentario,
            "proceso"           => $pasos->avance,
            "fechaAvance"       => date("Y-m-d H:i:s"),
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "tipoMovimiento"    => $pasos->tipoMovimiento
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $dataProceso, "idProceso", $idProceso);

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);

        if ($proceso == 1) {
            $crearVobo = $this->CasasDirectoModel->insertVoboDirecto($idProceso, $pasos->avance);
        }

        if ($update && $addHistorial && $crearVobo) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function avanceOrdenCompra()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $idLote = $form->idLote;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $voBoOrdenCompra = $form->proyectos;
        $voBoAdeudoTerreno = $form->adm;
        $idCliente = $form->idCliente;
        $banderaDocumentos = true;

        if (!isset($idProceso) || !isset($idLote) || !isset($proceso) || !isset($comentario) || !isset($voBoOrdenCompra) || !isset($voBoAdeudoTerreno) || !isset($idCliente)) {
            http_response_code(400);

            $this->json([]);
        }

        $this->db->trans_begin();

        $pasos = $this->CasasDirectoModel->getPasos($idProceso, 1);

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $voBoAdeudoTerreno == 1 ? $pasos->avance : $proceso,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente,
            "idMovimiento" => $this->idUsuario
        );

        $updateData = array(
            "comentario" => $comentario,
            "proceso" => $voBoAdeudoTerreno == 1 ? $pasos->avance : $proceso,
            "tipoMovimiento"    => $pasos->tipoMovimiento
        );

        $updateVobo = array(
            "proyectos" => 1,
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "modificadoPor" => $this->idUsuario
        );

        // actualizar el registro de la tabla
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        // insert en historial
        $add = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);

        // actualizar vobo
        $vobo = $this->CasasDirectoModel->updateVobosDirecto($idProceso, $proceso, $updateVobo);

        $persona = $this->CasasDirectoModel->getTipoPersona($idCliente)->personalidad_juridica ;
        if ($voBoAdeudoTerreno == 1 && $persona == 1) {
            # Persona moral
            $tipos = [10,11,12,7,8,17,29,30,22,23,24,25];
            foreach($tipos as $tipo) {
                $name_documento = $this->CasasDirectoModel->getDocumentoPersonaMoral($tipo)->nombre;
                $documentos = $this->CasasDirectoModel->insertDocProcesoCreditoDirecto($idProceso, $name_documento, NULL, $tipo, $pasos->tipoMovimiento, $this->idUsuario);
                if (!$documentos) {
                    $banderaDocumentos = false;
                }
            }
        } else if ($voBoAdeudoTerreno == 1 && $persona == 2) {
            # Persona fisica
            $tipos = [2,3,4,7,8,20,26,27,28,29,30];
            foreach($tipos as $tipo) {
                $name_documento = $this->CasasDirectoModel->getDocumentoPersonaFisica($tipo)->nombre;
                $documentos = $this->CasasDirectoModel->insertDocProcesoCreditoDirecto($idProceso, $name_documento, NULL, $tipo, $pasos->tipoMovimiento, $this->idUsuario);
                if (!$documentos) {
                    $banderaDocumentos = false;
                }
            }
        }

        if ($update && $add && $vobo && $banderaDocumentos) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function avanceAdeudo()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $idLote = $form->idLote;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $voBoOrdenCompra = $form->proyectos;
        $voBoAdeudoTerreno = $form->adm;
        $idCliente = $form->idCliente;
        $banderaDocumentos = true;

        if (!isset($idProceso) || !isset($idLote) || !isset($proceso) || !isset($comentario) || !isset($voBoOrdenCompra) || !isset($voBoAdeudoTerreno) || !isset($idCliente)) {
            http_response_code(400);

            $this->json([]);
        }

        $this->db->trans_begin();

        $pasos = $this->CasasDirectoModel->getPasos($idProceso, 1);

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $voBoOrdenCompra == 1 ? $pasos->avance : $proceso,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente,
            "idMovimiento" => $this->idUsuario
        );

        $updateData = array(
            "comentario" => $comentario,
            "proceso" => $voBoOrdenCompra == 1 ? $pasos->avance : $proceso,
            "tipoMovimiento"    => $pasos->tipoMovimiento
        );

        $updateVobo = array(
            "adm" => 1,
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "modificadoPor" => $this->idUsuario
        );

        // actualizar el registro de la tabla
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        // insert en historial
        $add = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);

        // actualizar vobo
        $vobo = $this->CasasDirectoModel->updateVobosDirecto($idProceso, $proceso, $updateVobo);

        $persona = $this->CasasDirectoModel->getTipoPersona($idCliente)->personalidad_juridica ;
        if ($voBoOrdenCompra == 1 && $persona == 1) {
            # Persona moral
            $tipos = [10,11,12,7,8,17,29,30,22,23,24,25];
            foreach($tipos as $tipo) {
                $name_documento = $this->CasasDirectoModel->getDocumentoPersonaMoral($tipo)->nombre;
                $documentos = $this->CasasDirectoModel->insertDocProcesoCreditoDirecto($idProceso, $name_documento, NULL, $tipo, $pasos->tipoMovimiento, $this->idUsuario);
                if (!$documentos) {
                    $banderaDocumentos = false;
                }
            }
        } else if ( $voBoOrdenCompra == 1 && $persona == 2) {
            # Persona fisica
            $tipos = [2,3,4,7,8,20,26,27,28,29,30];
            foreach($tipos as $tipo) {
                $name_documento = $this->CasasDirectoModel->getDocumentoPersonaFisica($tipo)->nombre;
                $documentos = $this->CasasDirectoModel->insertDocProcesoCreditoDirecto($idProceso, $name_documento, NULL, $tipo, $pasos->tipoMovimiento, $this->idUsuario);
                if (!$documentos) {
                    $banderaDocumentos = false;
                }
            }
        }

        if ($update && $add && $vobo && $banderaDocumentos) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    /*
    ****************** Rechazos ****************** 
    */
    public function rechazoAPaso2()
    {
        $form = $this->form();

        $idProceso = $form->idProceso;
        $proceso = $form->proceso;
        $comentario = $form->comentario;
        $idCliente = $form->idCliente;

        $this->db->trans_begin();

        $pasos = $this->CasasDirectoModel->getPasos($idProceso, 2);

        $dataHistorial = array(
            "idProcesoCasas"  => $idProceso,
            "procesoAnterior" => $proceso,
            "procesoNuevo"    => $pasos->avance,
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "creadoPor"       => $this->idUsuario,
            "descripcion"     => $comentario,
            "esquemaCreditoProceso" => 1,
            "idCliente" => $idCliente,
            "idMovimiento" => $this->idUsuario
        );

        $updateData = array(
            "comentario"         => $comentario,
            "proceso"            => $pasos->avance,
            "fechaModificacion"  => date("Y-m-d H:i:s"),
            "tipoMovimiento"     => $pasos->tipoMovimiento
        );

        $updateVobo = array(
            "adm" => 0,
            "proyectos" => 0,
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "modificadoPor" => $this->idUsuario
        );

        // paso 1: hacer update del proceso
        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateData, "idProceso", $idProceso);

        // paso 2: guardar registro del movimiento
        $addHistorial = $this->General_model->addRecord("historial_proceso_casas", $dataHistorial);

        // actualizar vobo
        $vobo = $this->CasasDirectoModel->updateVobosDirecto($idProceso, $pasos->avance, $updateVobo);

        if ($update && $addHistorial && $vobo) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);

            $this->json([]);
        }
    }

    public function returnFlagsPaso2()
    {
        $proceso = $this->input->post("proceso");
        $idProceso = $this->input->post("idProceso");

        $updateProceso = array(
            "adeudo"            => 0,
            "fechaAvance"       => date("Y-m-d H:i:s"),
        );

        $updateVobo = array(
            "adm" => 0,
            "proyectos" => 0,
            "fechaModificacion" => date("Y-m-d H:i:s"),
            "modificadoPor" => $this->idUsuario
        );

        $this->db->trans_begin();

        $update = $this->General_model->updateRecord("proceso_casas_directo", $updateProceso, "idProceso", $idProceso);
        $vobos = $this->CasasModel->updateVobosDirecto($idProceso, $proceso, $updateVobo);

        if ($update && $vobos) {
            $this->db->trans_commit();
            $this->json([]);
        } else {
            $this->db->trans_rollback();
            http_response_code(400);
            $this->json([]);
        }
    }

}