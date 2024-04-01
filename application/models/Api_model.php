<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Api_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function verifyUser($username, $password)
    {
        $query = $this->db->query("SELECT * FROM external_users WHERE usuario = '$username' AND contrasena = '$password' AND estatus = 1");
        if($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }

    function getAdviserLeaderInformation($id_asesor) {
        return $this->db->query(
            "SELECT 
                u.id_rol, 
                u.id_sede, 
                u.id_lider id_coordinador, 
                CASE WHEN uu.id_rol = 3 THEN u.id_lider ELSE ge.id_usuario END id_gerente, 
                CASE WHEN uu.id_rol = 3 THEN ge.id_usuario ELSE sb.id_usuario END id_subdirector, 
                CASE WHEN uu.id_rol = 3 THEN sb.id_usuario ELSE ISNULL(CASE rg.id_usuario WHEN 2 THEN 0 ELSE rg.id_usuario END, 0) END id_regional 
            FROM usuarios u 
                    LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
                    LEFT JOIN usuarios ge ON ge.id_usuario = uu.id_lider
                    LEFT JOIN usuarios sb ON sb.id_usuario = ge.id_lider
                    LEFT JOIN usuarios rg ON rg.id_usuario = sb.id_lider
            WHERE u.id_usuario = $id_asesor
        ")->row();
    }

    function generateFilename($idLote, $idDocumento)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC', hd.tipo_doc, SUBSTRING(hd.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        INNER JOIN historial_documento hd ON hd.idLote = l.idLote AND hd. idDocumento = $idDocumento
        WHERE l.idLote = $idLote");
    }

    function updateDocumentBranch($updateDocumentData, $idDocumento)
    {
        $response = $this->db->update("historial_documento", $updateDocumentData, "idDocumento = $idDocumento");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function updateUserContratacion($datos, $id_usuario)
    {
         $this->db->update("usuarios", $datos, "id_usuario = $id_usuario");
        if ($this->db->affected_rows() >= 0)
        {
          return 1;
        }
        else
        {
          return 0;
        }
    }


    public function login_user($username,$password)
	{
		$new_pass = encriptar($password);
 
			$query = $this->db->query("SELECT u.id_usuario, u.id_lider, u.estatus,(CASE u.id_lider WHEN 832 THEN 832 ELSE us.id_lider END) id_lider_2, ge.id_usuario id_lider_3, sb.id_usuario id_lider_4, u.id_rol, u.id_sede, u.nombre, u.apellido_paterno, u.apellido_materno,
            u.correo, u.usuario, u.contrasena, u.telefono, u.tiene_hijos, u.estatus, u.sesion_activa, u.imagen_perfil, u.fecha_creacion, u.creado_por, u.modificado_por, u.forma_pago, u.jerarquia_user
            FROM usuarios u
            LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
            LEFT JOIN usuarios ge ON ge.id_usuario = us.id_lider
            LEFT JOIN usuarios sb ON sb.id_usuario = ge.id_lider
            WHERE u.usuario = '$username' AND u.contrasena = '$new_pass' AND u.estatus in (0,1,3)");
            return $query->result_array();
	}

    function getClientsInformation()
    {
        return $this->db->query("SELECT * FROM sisfusion_pruebas.dbo.lotes LCRM 
        INNER JOIN sisfusion_pruebas.dbo.clientes as CLCRM ON LCRM.idLote = CLCRM.idLote AND CLCRM.status = 1
        INNER JOIN sisfusion_pruebas.dbo.tipo_venta TVCRM ON TVCRM.id_tventa = LCRM.tipo_venta
        INNER JOIN sisfusion_pruebas.dbo.statusLote SLCRM ON SLCRM.idStatusLote = LCRM.idStatusLote
        INNER JOIN sisfusion_pruebas.dbo.usuarios ACRM ON ACRM.id_usuario = CLCRM.id_asesor AND ACRM.estatus = 1
        LEFT JOIN sisfusion_pruebas.dbo.usuarios COORDCRM ON COORDCRM.id_usuario = CLCRM.id_coordinador AND COORDCRM.estatus = 1
        LEFT JOIN sisfusion_pruebas.dbo.usuarios GERCRM ON GERCRM.id_usuario = CLCRM.id_gerente AND GERCRM.estatus = 1
        INNER JOIN sisfusion_pruebas.dbo.sedes AS SEDECRMAS ON CAST(SEDECRMAS.id_sede AS VARCHAR(45)) = CAST(ACRM.id_sede AS VARCHAR(45))
        INNER JOIN sisfusion_pruebas.dbo.condominios CCRM ON CCRM.idCondominio = LCRM.idCondominio
        INNER JOIN sisfusion_pruebas.dbo.residenciales RCRM ON RCRM.idResidencial = CCRM.idResidencial
        WHERE LCRM.idStatusContratacion >= 15 AND LCRM.status = 1")->result_array();
    }

    function getInformationOfficesAndResidences(){
        $query["sedes"] = $this->db->query("SELECT id_sede, nombre, abreviacion FROM sedes WHERE estatus = 1")->result_array();
        $query["residenciales"] = $this->db->query("SELECT idResidencial as id_residencial, descripcion AS nombre, nombreResidencial AS abreviacion FROM residenciales WHERE status = 1")->result_array();
        return $query;
    }

    public function getAsesoresList($fecha) {
        $validacionFecha = $fecha != '' ? "AND u0.fecha_creacion >= '$fecha 00:00:00.000'" : "";
        return $this->db->query("SELECT u0.id_usuario, u0.usuario, u0.fecha_creacion, oxc0.nombre estatusAsesor,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor
        FROM usuarios u0
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = u0.estatus AND oxc0.id_catalogo = 3
        WHERE u0.id_rol = 7 AND rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%'
        AND id_usuario NOT IN (821, 1366, 1923, 4340, 4062, 4064, 4065, 4067, 4068, 4069, 6578, 712 , 9942, 4415, 3, 607, 13151, 12845)
        $validacionFecha")->result_array(); 
    }

    public function getInformacionProspectos(int $year, int $month){
        $month1 = $month;
        $month2 = $month;
        
        if(!isset($month) || $month <= 0){
            $month1 = 1;
            $month2 = 12;
        }
        
        $query = $this->db->query("SELECT 
                            pr.id_prospecto, 
                            pr.nombre,
                            pr.apellido_paterno,
                            pr.apellido_materno,
                            opx.nombre personalidad_juridica,
                            COALESCE(pr.rfc, '') AS rfc,
                            COALESCE(pr.correo, '') AS correo,
                            pr.telefono,
                            COALESCE(pr.telefono_2, '') AS telefono_2,
                            opx2.nombre tipo,
                            opx1.nombre lugar_prospeccion,
                            pr.fecha_creacion,
                            pr.id_asesor,
                            UPPER(CONCAT(us.nombre, ' ' , us.apellido_paterno, ' ', us.apellido_materno)) AS nombre_asesor
                            FROM prospectos pr
                            INNER JOIN opcs_x_cats opx ON opx.id_opcion = pr.personalidad_juridica AND opx.id_catalogo = 10
                            INNER JOIN opcs_x_cats opx1 ON opx1.id_opcion = pr.lugar_prospeccion AND opx1.id_catalogo = 9
                            INNER JOIN opcs_x_cats opx2 ON opx2.id_opcion = pr.tipo AND opx2.id_catalogo = 8
                            INNER JOIN usuarios us ON us.id_usuario = pr.id_asesor
                            WHERE YEAR(pr.fecha_creacion) = ? AND MONTH(pr.fecha_creacion) BETWEEN ? AND ?",
                            array( $year, $month1, $month2 ));
        return $query->result_array();
    }

    public function getCatalogos() {
        return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 16 AND estatus = 1
        UNION ALL
        SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (1, 2, 3, 7, 9)
        UNION ALL
        SELECT 0 id_catalogo, id_sede id_opcion, nombre FROM sedes WHERE estatus = 1")->result_array();
    }

    public function verificarExistenciaUsuario($usuario) {
        return $this->db->query("SELECT * FROM usuarios WHERE usuario = '$usuario'")->result_array();
    }

    public function agregarUsuarioOoam($data) {
        $this->db->insert('usuarios', $data);
        return $this->db->query("SELECT IDENT_CURRENT('usuarios') id_usuario")->result_array();
    }

    public function validarCorreoTelefono($telefono, $email) {
        return $this->db->query("SELECT * FROM prospectos WHERE telefono = '$telefono' OR telefono_2 = '$telefono' OR correo = '$email'")->result_array();
    }

    public function getInventarioVirtual($idResidencial)
    {
        $query = $this->db->query("SELECT (cond.nombre) condominio, (l.nombreLote) lote, l.idLote, (res.descripcion) proyecto, (l.sup) superficie, (l.total) precioLista, (l.precio) m2, l.msi,
        CASE WHEN u0.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(u0.nombre,' ', u0.apellido_paterno,' ', u0.apellido_materno) END asesor,
        CASE WHEN u1.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(u1.nombre,' ', u1.apellido_paterno,' ', u1.apellido_materno) END coordinador,
        CASE WHEN u2.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(u2.nombre,' ', u2.apellido_paterno,' ', u2.apellido_materno) END gerente,
        CASE WHEN u3.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(u3.nombre,' ', u3.apellido_paterno,' ', u3.apellido_materno) END subDirector,
        CONCAT (u4.nombre,' ', u4.apellido_paterno,' ', u4.apellido_materno) director, (st.nombre) estatus, cl.fechaApartado, cl.fechaEnganche
        FROM lotes l
        INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial AND res.idResidencial = $idResidencial
        LEFT JOIN clientes AS cl ON cl.id_cliente = l.idCliente
        LEFT JOIN usuarios AS u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios AS u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios AS u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios AS u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios AS u4 ON u4.id_usuario = 2
        LEFT JOIN statuslote AS st ON st.idStatusLote = l.idStatusLote
        WHERE l.status = 1");
        
        return $query->result_array();
    }

    public function getListaResidenciales() {
        return $this->db->query("SELECT idResidencial, (descripcion) nombre FROM residenciales WHERE status = 1 AND idResidencial NOT IN (21, 22, 14, 25)")->result_array();
    }

    public function validacionIdSalesforce($id_salesforce) {
        return $this->db->query("SELECT * FROM prospectos WHERE id_salesforce = '$id_salesforce'")->result_array();
    }

    public function aplicaLiberacion($datos){
        $modificado_por = 1;
        $comentarioLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : $datos['obsLiberacion']));
        $observacionLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : 'CANCELACIÓN DE CONTRATO') );
        $datos["comentarioLiberacion"] = $comentarioLiberacion;
        $datos["observacionLiberacion"] = $observacionLiberacion;
        $datos["fechaLiberacion"] = date('Y-m-d H:i:s');
        $datos["modificado"] = date('Y-m-d H:i:s');
        $datos["status"] = 1;
        $datos["userLiberacion"] = ($datos['tipoLiberacion'] == 7 &&  $this->session->userdata('id_rol') == 17 ) ? 1 : 1;
        $datos["tipo"] = $datos['tipoLiberacion'];
        $tipo_estatus_regreso = $datos['tipoLiberacion'] == 9 ? 1 : 0; // SI ES LIBERACIÓN DE YOLA (ES EL INVENTARIO ESPECIAL PARA EL PROYECTO DE REESTRUCURA) SE MANDA BANDERA EN 1 SINO 0

        $row = $this->db->query("SELECT idLote, nombreLote, status, sup,precio,ubicacion,idStatusLote,
        (CASE WHEN totalNeto2 IS NULL THEN 0.00 ELSE totalNeto2 END) totalNeto2,
        (CASE WHEN idCliente = 0  OR idCliente IS NULL THEN 0 ELSE idCliente END) idCliente,registro_comision,
        (CASE WHEN tipo_venta IS NULL THEN 0 ELSE tipo_venta END) tipo_venta FROM lotes WHERE idLote=".$datos['idLote']." AND status = 1")->result_array();
        $registro_comision = ($datos['tipo'] == 8 || $datos['tipo'] == 9) ? 9 : 8;
        $idStatusLote = $datos['tipo'] == 9 ? 15 :($datos['tipo'] == 8  ? 3 :( $datos['tipo'] == 7 ? 19 : 18));
        $sqlIdCliente = $datos['tipo'] == 8 ? ' AND id_cliente='.$row[0]['idCliente'] : '';
        $sqlIdClienteAnt = isset($datos["idClienteAnterior"]) ? 'AND idCliente = '.$datos["idClienteAnterior"] : '';
        $this->db->trans_begin();
        if($row[0]['idStatusLote'] == 8 || $row[0]['idCliente'] == NULL){
                $arregloLote = array();
                $arregloLote = array(
                    "idStatusLote" => 15,
                    "fecha_modst" => date("Y-m-d H:i:s"),
                    "userstatus" => $datos["userLiberacion"],
                    "usuario" => $datos["userLiberacion"],
                    "liberaBandera" => 1,
                    "tipo_estatus_regreso" => 1
                );
                $this->General_model->updateRecord('lotes',$arregloLote , 'idLote',$datos['idLote']);
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
                exit;
        }
        
        $banderaComisionCl = (in_array($datos['tipo'],array(7,8,9))) ? ' ,banderaComisionCl ='.$row[0]['registro_comision'] : '';
        $id_cliente = $this->db->query("SELECT id_cliente,plan_comision FROM clientes WHERE status = 1 AND idLote IN (" . $row[0]['idLote'] . ") ")->result_array();
        $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
        $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row[0]['idLote'].")");
        $this->db->query("UPDATE clientes SET status = 0,modificado_por='".$modificado_por."', tipoLiberacion= ".$datos['tipo'].",totalNeto2Cl=".$row[0]['totalNeto2']." $banderaComisionCl WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") $sqlIdCliente ");
        $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") $sqlIdClienteAnt");
        $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");

        $datos['tipo'] == 8 ? $this->db->query("UPDATE clientes SET idLote=".$datos['idLote'].",modificado_por='".$modificado_por."' WHERE id_cliente=".$datos['idClienteNuevo'].";")  : '' ;
        //$arrayRegistroComision = [0,8,9];
        if(!in_array($row[0]['registro_comision'],array(7))){
            $comisionesNuevas = $this->Comisiones_model->porcentajes($id_cliente[0]['id_cliente'],$row[0]["totalNeto2"],$id_cliente[0]['plan_comision'])->result_array();
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row[0]['idLote']." AND estatus=1")->result_array();

            if(in_array($row[0]['registro_comision'],array(8,0))){
                for ($i=0; $i < count($comisionesNuevas) ; $i++) { 
                    $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisionesNuevas[$i]['id_usuario'].",".$comisionesNuevas[$i]['comision_total'].",".$comisionesNuevas[$i]['porcentaje_decimal'].",".$comisionesNuevas[$i]['id_rol'].",".$id_cliente[0]['id_cliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."','".$row[0]['nombreLote']."')"); 
                }
            }else{
                if(count($comisiones) == 0){
                    for ($i=0; $i < count($comisionesNuevas) ; $i++) { 
                        $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisionesNuevas[$i]['id_usuario'].",".$comisionesNuevas[$i]['comision_total'].",".$comisionesNuevas[$i]['porcentaje_decimal'].",".$comisionesNuevas[$i]['id_rol'].",".$id_cliente[0]['id_cliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."','".$row[0]['nombreLote']."')"); 
                    }
                }else{
                    for ($i=0; $i <count($comisiones) ; $i++) {
                        $sumaxcomision=0;
                        $pagos_ind = $this->db->query("SELECT * FROM pago_comision_ind WHERE id_comision=".$comisiones[$i]['id_comision']."")->result_array();
                        for ($j=0; $j <count($pagos_ind) ; $j++) {
                            $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];
                        }
                        if(($datos['tipo'] == 7 || $datos['tipo'] == 8) && $row[0]['registro_comision'] == 1){
                            $nuevaComision = $comisiones[$i]['comision_total'] - $sumaxcomision;
                            $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisiones[$i]['id_usuario'].",".$nuevaComision.",".$comisiones[$i]['porcentaje_decimal'].",".$comisiones[$i]['rol_generado'].",".$row[0]['idCliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."','".$row[0]['nombreLote']."')");
                        }
                        $this->db->query("UPDATE comisiones SET modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
                    }
                    $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0,modificado_por='".$modificado_por."'  WHERE id_lote=".$row[0]['idLote']." ");
                }
            }
        }else{
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row[0]['idLote']." AND estatus=1")->result_array();
            for ($i=0; $i <count($comisiones) ; $i++) {
                $this->db->query("UPDATE comisiones SET modificado_por='" . $datos['userLiberacion'] . "',estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
            }
            $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0,modificado_por='".$modificado_por."'  WHERE id_lote=".$row[0]['idLote']." ");
        }
        
        if($row[0]['tipo_venta'] == 1){
            if($datos['tipo'] == 7 || $datos['tipo'] == 8){
                if( $datos['tipo'] == 7 && $datos['banderaFusion'] == 0){
                    $clausula = $this->db->query("SELECT TOP 1 id_clausula,nombre FROM clausulas WHERE id_lote = ".$datos['idLote']." ORDER BY id_clausula DESC")->result_array();
                    $this->db->query("INSERT INTO clausulas VALUES(".$datos['idLoteNuevo'].",'".$clausula['nombre']."',1,GETDATE(),'".$datos['userLiberacion']."');");
                    $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_lote=".$datos['idLote']." AND estatus = 1");
                }
            }
        }

        //LOTES FUSIÓN
        if($datos["tipo"] == 7 && $datos['banderaFusion'] == 1){
            $datosFusion = $this->db->query("SELECT idLotePvOrigen FROM lotesFusion WHERE idLote=".$datos['idLote'])->result_array();
            $idLotePv = $datosFusion[0]['idLotePvOrigen'];
            $this->db->query("UPDATE lotesFusion SET banderaComision=".$row[0]['registro_comision'].",totalNeto2=".$row[0]['totalNeto2'].",modificadoPor=".$datos['userLiberacion'].",fechaModificacion='".$datos['modificado']."' WHERE idLote=".$datos['idLote']." AND idCliente=".$row[0]['idCliente']." ");
            $this->db->query("UPDATE lotesFusion SET nombreLotes=CONCAT(nombreLotes,',','".$row[0]['nombreLote']."'),modificadoPor=".$datos['userLiberacion'].",fechaModificacion='".$datos['modificado']."' WHERE idLotePvOrigen=".$idLotePv." AND destino=1");
        }



        $data_l = array(
            'nombreLote'=> $row[0]['nombreLote'],
            'comentarioLiberacion'=> $datos['comentarioLiberacion'],
            'observacionLiberacion'=> $datos['observacionLiberacion'],
            'precio'=> $row[0]['precio'],
            'fechaLiberacion'=> $datos['fechaLiberacion'],
            'modificado'=> $datos['modificado'],
            'status'=> $datos['status'],
            'idLote'=> $row[0]['idLote'],
            'tipo'=> $datos['tipo'],
            'userLiberacion'=> $datos['userLiberacion'],
            'id_cliente' => (count($id_cliente)>=1 ) ? $id_cliente[0]['id_cliente'] : 0
        );

        $this->db->insert('historial_liberacion',$data_l);

        $idStatusContratacion = $datos["tipo"] == 8 ? 1 : 0;
        $idClienteNuevo = $datos["tipo"] == 8 ? $datos['idClienteNuevo'] : 0 ;
        $idMovimiento = $datos["tipo"] == 8 ? 31 : 0;
        $tipo_venta = $datos["tipo"] == 8 ? $row[0]['tipo_venta'] : 0;
        $ubicacion = $datos["tipo"] == 8 ? $row[0]['ubicacion'] : 0;
        $motivo_change_status =  $datos["tipoLiberacion"] == 3 ? $datos['obsLiberacion'] : 'LOTE LIBERADO';
        $this->db->query("UPDATE lotes SET idStatusContratacion = $idStatusContratacion,
                    idMovimiento = $idMovimiento, comentario = 'NULL', idCliente = $idClienteNuevo, usuario = '".$modificado_por."', perfil = 'NULL ', 
                    fechaVenc = null, modificado = null, status8Flag = 0, 
                    ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                    casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                    totalValidado = 0, validacionEnganche = 'NULL', 
                    fechaSolicitudValidacion = null, 
                    fechaRL = null, 
                    motivo_change_status='$motivo_change_status',
                    registro_comision = $registro_comision,
                    tipo_venta = $tipo_venta, 
                    observacionContratoUrgente = null,
                    firmaRL = 'NULL', comentarioLiberacion = '".$datos['comentarioLiberacion']."', 
                    observacionLiberacion = '".$datos['observacionLiberacion']."', liberadoReubicacion = '".$datos['observacionLiberacion']."' , idStatusLote = $idStatusLote, 
                    fechaLiberacion = GETDATE(), 
                    userLiberacion = '".$datos['userLiberacion']."',
                    precio = ".$row[0]['precio'].", total = ((".$row[0]['sup'].") * ".$row[0]['precio']."),
                    enganche = (((".$row[0]['sup'].") * ".$row[0]['precio'].") * 0.1), 
                    saldo = (((".$row[0]['sup'].") * ".$row[0]['precio'].") - (((".$row[0]['sup'].") * ".$row[0]['precio'].") * 0.1)),
                    asig_jur = 0, tipo_estatus_regreso = $tipo_estatus_regreso
                    WHERE idLote IN (".$datos['idLote'].") and status = 1");
                    
                    /*if(!in_array($datos["tipo"],array(7,8,9))) {
                        $this->email
                            ->initialize()
                            ->from('Ciudad Maderas')
                            ->to('programador.analista24@ciudadmaderas.com')
                            ->subject('Notificación de liberación')
                            ->view($this->load->view('mail/reestructura/mailLiberacion', [
                                'lote' => $row[0]['nombreLote'],
                                'fechaApartado' => $datos['fechaLiberacion'],
                                'Observaciones' => $datos['obsLiberacion']
                            ], true));
                
                        $this->email->send();
                    }*/

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }
    function getAsesoresSeguros() {
        return $this->db->query(
            "SELECT u0.id_usuario as id_asesor,u0.id_sede,u0.id_rol as puestoAsesor, 
            CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno) asesor,
            u0.id_lider as id_gerente,u1.id_rol as puestoGerente,
            (CASE u1.id_rol WHEN 9 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) WHEN 3 THEN CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno) END) gerente
            FROM usuarios u0
            LEFT JOIN usuarios u1 ON u1.id_usuario = u0.id_lider -- GERENTE
            WHERE u0.id_rol = 7 AND u0.estatus = 1 AND u0.tipo=4 AND u0.id_lider != 1980
        ")->result_array();
    }
}
