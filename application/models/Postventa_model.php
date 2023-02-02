<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Postventa_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    function getProyectos()
    {
        return $this->db->query("SELECT * FROM residenciales WHERE status = 1");
    }

    function getCondominios($idResidencial)
    {
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial = $idResidencial ORDER BY nombre");
    }

    function getLotes($idCondominio)
    {
        return $this->db->query("SELECT * FROM lotes l
        WHERE idCondominio = $idCondominio /*AND idStatusContratacion = 15 AND idMovimiento = 45*/ AND idStatusLote = 2 
        AND idLote NOT IN(SELECT idLote FROM clientes WHERE id_cliente IN (SELECT id_cliente FROM solicitudes_escrituracion))");
    }

    function getClient($idLote)
    {   
        $num_cli = $this->db->query("SELECT CASE
                                                WHEN idCliente IS NULL THEN 0
                                                WHEN idCliente = '' THEN 0 
                                                ELSE idCliente
                                            END AS num_cli 
                                    FROM lotes
                                    WHERE idLote = $idLote");
        if($num_cli->row()->num_cli < 1){
            return $num_cli;
        }else{
            return $this->db->query("SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.ocupacion, 1 as num_cli,
            oxc.nombre nacionalidad, oxc2.nombre estado_civil, oxc3.nombre regimen_matrimonial, c.correo, c.domicilio_particular, c.rfc, c.telefono1, c.telefono2, c.personalidad_juridica, oxc4.nombre as nombre_juridica
            FROM lotes l 
            INNER JOIN clientes c ON c.id_cliente = l.idCliente 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = c.nacionalidad AND oxc.id_catalogo = 11
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = c.estado_civil AND oxc2.id_catalogo = 18
            LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = c.regimen_matrimonial AND oxc3.id_catalogo = 19
            LEFT JOIN opcs_x_cats oxc4 ON oxc4.id_opcion = c.personalidad_juridica AND oxc4.id_catalogo = 10
            WHERE l.idLote = $idLote");
        }
    }

    function getDetalleNota($id_solicitud){
        return $this->db->query("SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS nombre, he.descripcion, he.fecha_creacion 
        FROM solicitudes_escrituracion se
        JOIN historial_escrituracion he ON se.id_solicitud = he.id_solicitud
        JOIN usuarios us ON he.creado_por = us.id_usuario
        WHERE se.id_solicitud = $id_solicitud AND he.descripcion <> ''
	    ORDER BY he.fecha_creacion ASC");
    }

    function getEmpRef($idLote){
        return $this->db->query("SELECT l.referencia, r.empresa
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE l.idLote = $idLote");
    }

    // function setEscrituracion( $personalidad, $idLote,$idCliente, $idPostventa, $data, $idJuridico)
    // {
    //     if(is_object($data)){
    //         $data = (array)$data;
    //     }
    //     $idUsuario = $this->session->userdata('id_usuario');
    //     $rol = $this->session->userdata('id_rol');
    //     $nombre = (!isset($data['ncliente']) || $data['ncliente'] = '') ? 'NULL' : $data['ncliente'];
    //     $idConst = (!isset($data['idECons']) || $data['idECons'] = '') ? 'NULL' : $data['idECons'];
    //     $idEstatus = (isset($data['idEstatus']) || $data['idEstatus'] != '') && $data['idEstatus'] == 8 ? 1:2;
    //     $claveCat = (!isset($data['ClaveCat']) || $data['ClaveCat'] = '') ? 'NULL' : $data['ClaveCat'];
    //     $clienteAnterior = $data['ult_ncliente'] != null ? 1:2;
    //     $nombreClienteAnterior = $clienteAnterior == 1 ? $data['ult_ncliente']: NULL;
    //     $rfcAnterior =  $clienteAnterior == 1 ? $data['ult_rfc']: NULL;
    
    //     /*$this->db->query("INSERT INTO solicitud_escrituracion (idLote, idCliente, estatus, fecha_creacion
    //     , creado_por, fecha_modificacion, modificado_por, idArea, idPostventa, estatus_pago, clave_catastral, cliente_anterior,
    //     nombre_anterior, RFC, nombre, personalidad, id_juridico)
    //      VALUES($idLote, $idCliente, 0, GETDATE(), $idUsuario, GETDATE(),$idUsuario, $rol, $idPostventa, $idEstatus, '$claveCat', 
    //             $clienteAnterior, '$nombreClienteAnterior', '$rfcAnterior', '$nombre', $personalidad, $idJuridico);");*/
    //     $this->db->query("INSERT INTO solicitudes_escrituracion (id_lote,id_cliente,id_actividad,id_estatus,estatus_pago,superficie,clave_catastral
    //     ,estatus_construccion,id_notaria,id_valuador,tipo_escritura,id_postventa,
    //     personalidad_juridica,aportacion,descuento,id_titulacion,fecha_creacion,creado_por,
    //     fecha_modificacion,modificado_por)
    //     VALUES($idLote, $idCliente,1,1,$idEstatus,0,'$claveCat',0,0,0,0,$idPostventa,2,0,0,$idJuridico,GETDATE(),$idUsuario,GETDATE(),$idUsuario)");
    //     $insert_id = $this->db->insert_id();
    //     $opcion = 60;// $personalidad == 2 || $personalidad == '' || $personalidad == null ? 60:72;
    //     $opciones = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo =  $opcion")->result_array();
    //     foreach ($opciones as $row) {
    //         $opcion = $row['id_opcion'];
    //         $this->db->query("INSERT INTO documentos_escrituracion VALUES('creacion de rama',NULL,GETDATE(),1,$insert_id,$idUsuario,$opcion,$idUsuario,$idUsuario,GETDATE(),NULL,NULL,NULL);");
    //     }
    //     $y=0;

    //     for($x=0;$x<9;$x++){
    //         $y = $y<3 ? $y+1:1;
    //         $this->db->query("INSERT INTO Presupuestos (expediente, idSolicitud, estatus, tipo, fecha_creacion, creado_por, modificado_por, bandera) 
    //         VALUES('', $insert_id, 0, $y,  GETDATE(), $idUsuario, $idUsuario, NULL);");
    //     }

    //     return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
    //      VALUES(0, 59, 4, GETDATE(), 1,$insert_id, $rol,0,'','', $idUsuario);");
    // }

    // $row['id_pago_i']
    function setEscrituracion( $personalidad, $idLote,$idCliente, $idPostventa, $data, $idJuridico)
    {
        if(is_object($data)){
            $data = (array)$data;
        }
        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');
        $idEstatus = (isset($data['idEstatus']) || $data['idEstatus'] != '') && $data['idEstatus'] == 8 ? 1:2;
        $claveCat = (!isset($data['ClaveCat']) || $data['ClaveCat'] = '') ? 'NULL' : $data['ClaveCat'];
      
        $this->db->query("INSERT INTO solicitudes_escrituracion (id_lote,id_cliente,id_actividad,id_estatus,estatus_pago,superficie,clave_catastral,estatus_construccion,id_notaria,id_valuador,tipo_escritura,id_postventa,personalidad_juridica,aportacion,descuento,id_titulacion,fecha_creacion,creado_por,fecha_modificacion,modificado_por) VALUES($idLote, $idCliente,1,0,$idEstatus,0,'$claveCat',0,0,0,0,$idPostventa,2,0,0,$idJuridico,GETDATE(),$idUsuario,GETDATE(),$idUsuario)");
        $insert_id = $this->db->insert_id();

        $opciones = $this->db->query("SELECT * FROM documentacion_escrituracion WHERE tipo_personalidad IN (0,$personalidad)")->result_array();
        foreach ($opciones as $row) {
            $this->db->query("INSERT INTO documentos_escrituracion VALUES('creacion de rama',NULL,GETDATE(),1,$insert_id,$idUsuario,".$row['id_documento'].",$idUsuario,$idUsuario,GETDATE(),NULL,NULL,NULL,".$row['obligatorio'].");");
        }
        
        $y=0;

        for($x=0;$x<9;$x++){
            $y = $y<3 ? $y+1:1;
            $this->db->query("INSERT INTO Presupuestos (expediente, idSolicitud, estatus, tipo, fecha_creacion, creado_por, modificado_por, bandera) 
            VALUES('', $insert_id, 0, $y,  GETDATE(), $idUsuario, $idUsuario, NULL);");
        }

        return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por) VALUES(0, 59, 4, GETDATE(), 1,$insert_id, $rol,0,'','', $idUsuario);");
    }
    

    function getSolicitudes($begin, $end, $estatus, $tipo_tabla)
    {   
        
        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');
        $filtroTabla = "";
        $AddWhere = "";
        $WhereFechas = "";
        if($tipo_tabla == 1){
            $filtroTabla = "AND se.id_estatus in (45,48)";
        }else{
            $filtroTabla = "AND se.id_estatus not in (45,48)";
        }
        if($begin != 0){
          $WhereFechas = " AND se.fecha_creacion >= '$begin' AND se.fecha_creacion <= '$end' ";
        }

        if($estatus == 0){
        //PROPIOS
            if($rol == 57 && $idUsuario!= 10865){
                $AddWhere  =   " WHERE se.id_titulacion = $idUsuario ";
            }else if($rol == 11){
                $AddWhere  =   " WHERE cp.area_actual in ($rol) OR (se.id_estatus IN (4,2) AND se.bandera_admin IS NULL)  ";
            }else if($rol == 56){
                $AddWhere  =   " WHERE cp.area_actual in ($rol) OR (se.id_estatus IN (3,2) AND se.bandera_comite IS NULL) ";
            }else{
                $AddWhere  =   " WHERE cp.area_actual in ($rol) ";
            }
        }else{
            //TODOS
            $AddWhere = " ";
        }
        return $this->db->query("SELECT distinct(se.id_solicitud), se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre nombreCondominio, r.nombreResidencial, c.nombre as cliente, n.pertenece, se.bandera_notaria, se.descuento, se.aportacion, ar.id_opcion as id_area, ar.nombre as area, cp.area_actual, dc.expediente, dc.tipo_documento, dc.idDocumento, cr.area_sig, CONCAT(cp.clave_actividad ,' - ', ae.nombre) AS nombre_estatus, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, se.cliente_anterior, (CASE when cp.tipo_permiso = 3 THEN 'RECHAZO' ELSE '' END ) rechazo, concat((select[dbo].[DiasLaborales]( (dateadd(day,1,se.fecha_modificacion)) ,GETDATE())), ' día(s) de ',ae.dias_vencimiento) vencimiento, de4.contrato,pr.banderaPresupuesto,se.id_notaria,
        se.fecha_firma,(CASE WHEN he.descripcion IS NULL THEN '-' ELSE he.descripcion END) ultimo_comentario
        FROM solicitudes_escrituracion se 
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN clientes c ON c.id_cliente = l.idCliente
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
        INNER JOIN control_permisos cp ON se.id_estatus = cp.estatus_actual AND cp.clasificacion in (1)
        INNER JOIN actividades_escrituracion ae ON ae.clave = cp.clave_actividad 
        INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1
        LEFT JOIN documentos_escrituracion dc ON dc.idSolicitud = se.id_solicitud AND dc.tipo_documento in(CASE WHEN se.id_estatus in (3,4,6,8,9,10) THEN 18 WHEN se.id_estatus in(18,21) THEN 7 WHEN se.id_estatus in(44,55) THEN 19 WHEN se.id_estatus in(45,48) THEN 14 WHEN se.id_estatus in(29,40) THEN 15 ELSE 11 END) 
        LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
        LEFT JOIN (SELECT TOP 1 h.id_solicitud, (CASE WHEN h.tipo_movimiento = 1 THEN mr.motivo ELSE h.descripcion END) AS descripcion FROM historial_escrituracion h LEFT JOIN motivos_rechazo mr ON mr.id_motivo = TRY_CAST(h.descripcion AS INT) GROUP BY h.id_solicitud, h.descripcion, mr.motivo, h.tipo_movimiento) he ON he.id_solicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END banderaPresupuesto FROM Presupuestos WHERE expediente != '' GROUP BY idSolicitud) pr ON pr.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) THEN 0 ELSE 1 END contrato
        FROM documentos_escrituracion WHERE tipo_documento = 18 GROUP BY idSolicitud) de4 ON de4.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT DISTINCT(cl.clave_actividad),  cl.estatus_actual as estatus_siguiente, cl.clasificacion, cl.tipo_permiso, ar2.nombre as area_sig, CONCAT(av.clave,' - ', av.nombre, '-', ar2.nombre) as nombre_estatus_siguiente
        FROM control_permisos cl 	
        INNER JOIN actividades_escrituracion av ON cl.clave_actividad LIKE av.clave
        INNER JOIN opcs_x_cats ar2 ON ar2.id_opcion = cl.area_actual AND ar2.id_catalogo = 1
        WHERE cl.clasificacion in (1)
        GROUP BY cl.nombre_actividad, cl.clave_actividad, cl.clasificacion, cl.estatus_actual, cl.tipo_permiso, av.nombre, av.clave, ar2.nombre) cr ON cr.estatus_siguiente = cp.estatus_siguiente
        $AddWhere $filtroTabla $WhereFechas
        GROUP BY se.id_solicitud, cp.estatus_actual, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre, r.nombreResidencial, c.nombre, n.pertenece, se.bandera_notaria, se.descuento, se.aportacion, ae.id_actividad, ae.clave, cp.tipo_permiso, cp.clave_actividad, cp.clave_actividad, ae.nombre, ar.id_opcion, cp.estatus_siguiente, ar.nombre, cp.nombre_actividad, cp.estatus_siguiente, cp.estatus_siguiente, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso, dc.expediente, dc.tipo_documento, dc.idDocumento, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, cp.area_actual, se.cliente_anterior, cr.area_sig, ae.nombre, ae.dias_vencimiento,se.fecha_modificacion, de4.contrato, he.descripcion,pr.banderaPresupuesto,se.id_notaria,se.fecha_firma");

    }



    
    function getNotarias()
    {
        return $this->db->query("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, n.direccion, n.correo, n.telefono, s.nombre, n.pertenece 
        FROM Notarias n
        JOIN sedes s ON n.sede = s.id_sede
        WHERE sede != 0 and n.Estatus = 1
        ORDER BY n.idNotaria");
    }

    function listSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
     }

    function updateNotarias($idnotaria){

        $respuesta = $this->db->query("UPDATE Notarias SET estatus = 0 WHERE idNotaria = $idnotaria");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }
    function insertNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, $sede){

        $respuesta = $this->db->query("INSERT INTO Notarias (nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece, estatus) VALUES ('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', $sede, 1, 1)");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }

    }
    
    function changeStatus($id_solicitud, $type, $comentarios,$area_rechazo)
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');

        $estatus = $this->db->query("SELECT id_estatus,bandera_admin,bandera_comite,id_notaria,bandera_notaria FROM solicitudes_escrituracion WHERE id_solicitud = $id_solicitud")->row();//->id_estatus;
      
        // echo $estatus;
        $sqlAreaRechazo = '';
        if($area_rechazo != 0 && $area_rechazo != ''){
            $sqlAreaRechazo = " AND estatus_siguiente=$area_rechazo ";
        }

         
        $notaria = $estatus->id_notaria; //$this->db->query("SELECT id_notaria FROM solicitudes_escrituracion WHERE id_solicitud = $id_solicitud")->row()->id_notaria;
        $notariaInterna = '';
        if($estatus->id_estatus == 12 && $notaria == 0 && $estatus->bandera_notaria == 1){
            $notariaInterna = ' AND estatus_siguiente=13 ';
        }
        if($estatus->id_estatus == 12 && $notaria != 0 && $estatus->bandera_notaria == 1){
            $pertenece = $this->db->query("SELECT pertenece FROM solicitudes_escrituracion se INNER JOIN Notarias n ON n.idNotaria = se.id_notaria WHERE id_solicitud = $id_solicitud")->row()->pertenece;
            $notariaInterna = $pertenece == 2 ? ' AND estatus_siguiente=18 ' : ' AND estatus_siguiente=13 ';
        }
       
        if($estatus->id_estatus == 3 && $estatus->bandera_admin == 1 && $estatus->bandera_comite == 0){
            $estatus = $estatus->id_estatus;
            $actividades_x_estatus = (object)array("estatus_siguiente" => 4 ,"estatus_actual" => 3 , "clave_actividad" => "APE0002");
        }
        else if($estatus->id_estatus == 4 && $estatus->bandera_admin == 0 && $estatus->bandera_comite == 1){
            $estatus = $estatus->id_estatus;
            $actividades_x_estatus = (object)array("estatus_siguiente" => 3 ,"estatus_actual" => 4, "clave_actividad" => "APE0003");
        }
        else if($estatus->id_estatus == 2 && $estatus->bandera_admin == 0 && $estatus->bandera_comite == 0){
            $estatus = $estatus->id_estatus;
            $estatus_sig =  $rol == 56 ? 4 : 3;
            $clave =  $rol == 56 ? 'APE0003' : 'APE0002';
            $actividades_x_estatus = (object)array("estatus_siguiente" => $estatus_sig ,"estatus_actual" => 2, "clave_actividad" => $clave);
        }
        else {
            //print_r($notariaInterna);
            //print_r("SELECT * FROM control_permisos WHERE estatus_actual=$estatus AND area_actual=$rol $notariaInterna $sqlAreaRechazo and tipo_permiso=$type");
            $estatus = $estatus->id_estatus;
            //print_r($estatus);
            $actividades_x_estatus = $this->db->query("SELECT * FROM control_permisos WHERE estatus_actual=$estatus AND area_actual=$rol $notariaInterna $sqlAreaRechazo and tipo_permiso=$type")->row();
        }
        $banderasStatusRechazo = $actividades_x_estatus->estatus_siguiente == 5 ? ' ,bandera_admin=0 ' : ($actividades_x_estatus->estatus_siguiente == 7 ? ' ,bandera_comite=0' : '');
        $banderasStatus2 = $actividades_x_estatus->estatus_siguiente == 3 ? ' ,bandera_admin=1 ' : ($actividades_x_estatus->estatus_siguiente == 4 ? ' ,bandera_comite=1' : '');
        if($actividades_x_estatus->estatus_siguiente == 8 || $actividades_x_estatus->estatus_siguiente == 6){
            $banderasStatus2 = $actividades_x_estatus->estatus_siguiente == 6 ? ' ,bandera_admin=1 ' : ($actividades_x_estatus->estatus_siguiente == 8 ? ' ,bandera_comite=1' : '');
        }

       

        $pertenece = 0;
       /* if($notaria != NULL || $notaria != 0){
            $pertenece = $this->db->query("SELECT pertenece FROM solicitud_escrituracion se INNER JOIN Notarias n ON n.idNotaria = se.id_notaria WHERE id_solicitud = $id_solicitud")->row();
            $pertenece = ($pertenece) ? $pertenece->pertenece : 1;
        }*/

      /*  if ($type == 1) { //OK
            if ($estatus == 90) {
                $newStatus = 16;
                $next = $newStatus + 1;
            }elseif($estatus == 92){
                $newStatus = 4;
                $next = $newStatus + 1;
            }else {
                $newStatus = $estatus + 1;
                $next = $newStatus + 1;
            }
            if ($estatus == 5 && $pertenece == 2){
                $newStatus = 10;
                $nex = 11;
            }
            if ($estatus == 93) {
                $newStatus = 16;
                $next = $newStatus + 1;
            }
        } elseif ($type == 2) {//REJECT
            if ($estatus === 16) { // ENVÍO / RECEPCIÓN DE PROYECTO
                $newStatus = 13;
                $estatus = 12;
            } else {
                $newStatus = $estatus - 1;
            }

            $next = $newStatus + 1;
        } elseif ($type == 3) {//comodin fecha
            if ($estatus == 90) {
                $newStatus = 14;
                $next = $newStatus + 1;
            } else {
                $newStatus = 90;
                $next = 14;
            }
        }elseif($type == 4){
            if($estatus == 12){
                $newStatus = 10;
                $next = 11;
            }
        }elseif($type == 5){
            if ($estatus == 0) {
                $newStatus = 91;
                $next = 92;
            } else if($estatus == 91 || $estatus == 92) {
                $newStatus = 92;
                $next = 4;
            }
        }*/
        $num_movimiento = $type == 3 ? 1 : 0;

        $this->db->query("UPDATE solicitudes_escrituracion SET id_estatus =".$actividades_x_estatus->estatus_siguiente." $banderasStatus2 $banderasStatusRechazo  WHERE id_solicitud = $id_solicitud");
        return $this->db->query("INSERT INTO historial_escrituracion (id_solicitud, numero_estatus,tipo_movimiento, descripcion, fecha_creacion, creado_por, fecha_modificacion, modificado_por, estatus_siguiente)
         VALUES($id_solicitud,".$actividades_x_estatus->estatus_actual.",$num_movimiento,'".$comentarios."',GETDATE(),$idUsuario,GETDATE(),$idUsuario,".$actividades_x_estatus->estatus_siguiente.");");
        /*return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
         VALUES(($estatus), 59, $type, GETDATE(), ($next), $id_solicitud, $rol, ($newStatus), '$comentarios', $motivos_rechazo, $idUsuario);");*/
    }

    function generateFilename($idSolicitud, $tipoDoc)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC_', REPLACE(oxc.nombre, ' ', '_'), SUBSTRING(de.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName, de.idDocumento, de.expediente, de.estatus_validacion 
		FROM solicitudes_escrituracion se 
		INNER JOIN lotes l ON se.id_lote =l.idLote
		INNER JOIN clientes c ON c.idLote = l.idLote AND c.id_cliente = se.id_cliente
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud = se.id_solicitud AND de.tipo_documento = $tipoDoc
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = $tipoDoc AND oxc.id_catalogo = 60
		WHERE se.id_solicitud = $idSolicitud");
    }

    function generateFilename2($idDoc)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC_', REPLACE(oxc.nombre, ' ', '_'), SUBSTRING(de.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName, de.idDocumento, de.expediente, de.tipo_documento FROM solicitud_escrituracion se 
		INNER JOIN lotes l ON se.idLote =l.idLote
		INNER JOIN clientes c ON c.idLote = l.idLote AND c.id_cliente = se.idCliente
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud 
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = de.tipo_documento AND oxc.id_catalogo = (CASE WHEN isNULL(se.personalidad,0) = 1 THEN 72 ELSE 60 END)
		WHERE de.idDocumento = $idDoc");
    }

    function updateDocumentBranch($documentName, $idSolicitud, $idUsuario, $documentType)
    {
        // print_r("INSERT INTO documentos_escrituracion VALUES('$documentName', '$documentName', GETDATE(), 1, $idSolicitud,
        // $idUsuario, $documentType, $idUsuario, $idUsuario, GETDATE());");
        $response = $this->db->query("INSERT INTO documentos_escrituracion VALUES('$documentName', '$documentName', GETDATE(), 1, $idSolicitud,
        $idUsuario, $documentType, $idUsuario, $idUsuario, GETDATE());");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function getFilename($idDocumento, $documentType=null)
    {
        if($documentType == 13){
            return $this->db->query("SELECT * FROM Presupuestos WHERE idPresupuesto = $idDocumento");
        }else{
            return $this->db->query("SELECT * FROM documentos_escrituracion WHERE idDocumento = $idDocumento");
        }
    }

    function replaceDocument($updateDocumentData, $idDocumento, $documentType = null)
    {
        if($documentType == 13){
            $response = $this->db->update("Presupuestos", $updateDocumentData, "idPresupuesto = $idDocumento");
        }else{
            $response = $this->db->update("documentos_escrituracion", $updateDocumentData, "idDocumento = $idDocumento");
        }
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function motivos_rechazo($tipoDocumento)
    {
        $query = $this->db->query("SELECT * FROM motivos_rechazo WHERE tipo_proceso = 2 AND tipo_documento = $tipoDocumento");
        return $query->result();
    }

    function existNotariaExterna($idSolicitud)
    {
        $notariaExterna = $this->db->query("SELECT idControl FROM control_estatus WHERE idEscrituracion = $idSolicitud 
                                        AND comentarios LIKE '%Se trabajara con Notaría externa%'");
        return $notariaExterna->row();
    }

    function getDocumentsClient($idSolicitud, $status, $notariaExterna)
    {
        $docNotariaExterna = ($notariaExterna) ? '' : ',20';

        if($status == 9){
            $tipo_doc = "IN (11,13,20 $docNotariaExterna)";
        }elseif($status == 18){
            $tipo_doc = 'IN (7)';
        }elseif($status == 19 ||$status == 22 || $status == 24){
            $tipo_doc = 'IN (1,2,3,4,5,6,8,9,10,12,14,21)';
        }elseif($status == 3 || $status == 4 || $status == 6 || $status == 8 || $status == 10 ){
            $tipo_doc = 'IN (17,18)';
        }elseif($status == 29 || $status == 40){
            $tipo_doc = 'IN (15)';
        }elseif($status == 23){
            $tipo_doc = 'IN (22)';
        }elseif($status == 24){
            $tipo_doc = 'IN (16)';
        }

        $query = $this->db->query("SELECT de.idDocumento, de.movimiento, de.expediente, de.modificado, de.status , de.idSolicitud ,de.idUsuario ,de.tipo_documento,
        de.modificado as documento_modificado_por, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as documento_creado_por, de.fecha_creacion as creacion_documento ,
        de.estatus_validacion as estatusValidacion ,opc.id_documento , de.estatus_validacion as validacion,
        opc.descripcion  , opc.fecha_creacion, se.id_solicitud , se.id_estatus as estatus_solicitud, se.estatus_construccion,
		   (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) as estatus_validacion,de.estatus_validacion ev,
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) as colour,de.editado,
		(CASE WHEN mr.motivo IS NULL THEN 'SIN MOTIVO RECHAZO' ELSE mr.motivo END) as motivos_rechazo,
		(CASE WHEN de.validado_por IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END ) AS validado_por
        FROM documentos_escrituracion de
		INNER JOIN documentacion_escrituracion opc ON de.tipo_documento=opc.id_documento
		INNER JOIN solicitudes_escrituracion se ON de.idSolicitud=se.id_solicitud
		INNER JOIN usuarios u ON u.id_usuario=de.idUsuario
		LEFT JOIN usuarios userV ON userV.id_usuario=de.validado_por
		LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento=de.idDocumento
		LEFT JOIN motivos_rechazo mr ON mr.id_motivo=mrxd.id_motivo
         WHERE opc.id_documento $tipo_doc 
        AND de.idSolicitud = $idSolicitud");
        return $query->result();
    }

    // function getNotarias()
    // {
    //     $query = $this->db->query("SELECT * FROM Notarias WHERE sede != 0");
    //     return $query->result();
    // }

    // function listSedes(){
    //     return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
    //  }


    function getValuadores(){
        $query = $this->db->query("SELECT * FROM Valuadores");
        return $query->result();
    }

    function getNotaria($idNotaria){
        $query = $this->db->query("SELECT * FROM Notarias WHERE idNotaria = $idNotaria");
        return $query->result();
    }

    function getValuador($idValuador){
        $query = $this->db->query("SELECT * FROM Valuadores WHERE idValuador = $idValuador");
        return $query->result();
    }

    function getBudgetInfo($idSolicitud){
        return $this->db->query("SELECT se.*, hl.modificado,
        cond.nombre nombreCondominio, r.nombreResidencial, l.nombreLote, oxc2.nombre nombreConst, oxc.nombre nombrePago, oxc3.nombre tipoEscritura,
		CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombre,n.* 
		FROM solicitudes_escrituracion se 
        INNER JOIN clientes c ON c.id_cliente = se.id_cliente
        INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.id_lote
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
        LEFT JOIN Notarias n ON n.idNotaria=se.id_notaria
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus_pago AND oxc.id_catalogo = 63
		LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.estatus_construccion AND oxc2.id_catalogo = 62
        LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = se.tipo_escritura AND oxc3.id_catalogo = 70
        WHERE se.id_solicitud = $idSolicitud");
    }

    function savePresupuesto($nombreT, $fechaCA, $cliente, $superficie, $catastral, $rfcDatos, $construccion,
                             $nombrePresupuesto2, $id_solicitud, $estatusPago)
    {
        return $this->db->query("UPDATE solicitud_escrituracion SET nombre_escrituras='$nombrePresupuesto2', estatus_pago=$estatusPago,
        superficie=$superficie, clave_catastral=$catastral, estatus_construccion=$construccion, cliente_anterior=$cliente,
        nombre_anterior='$nombreT', fecha_anterior=$fechaCA, RFC='$rfcDatos' WHERE idSolicitud=$id_solicitud");
    }

    function updatePresupuesto($data, $id_solicitud)
    {
        $response = $this->db->update("solicitudes_escrituracion", $data, "id_solicitud = $id_solicitud");
        if (!$response)
            return $finalAnswer = 0;
        else
            return $finalAnswer = 1;
    }

function checkBudgetInfo($idSolicitud){
        return $this->db->query("SELECT se.*, hl.modificado, l.nombreLote, 
        cond.nombre nombreCond, r.nombreResidencial, n.correo correoN, v.correo correoV, oxc2.nombre nombreConst, oxc.nombre nombrePago, oxc3.nombre tipoEscritura, n.nombre_notaria, 
        n.nombre_notario, n.direccion, n.correo, n.telefono, n.pertenece,CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre
                FROM solicitudes_escrituracion se 
                INNER JOIN clientes c ON c.id_cliente = se.id_cliente
                INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.id_lote
                INNER JOIN lotes l ON l.idLote = se.id_lote
                INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
                LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
                LEFT JOIN Valuadores v ON v.idValuador = se.id_valuador
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus_pago AND oxc.id_catalogo = 63
		        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.estatus_construccion AND oxc2.id_catalogo = 62
                LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = se.tipo_escritura AND oxc3.id_catalogo = 70
                WHERE se.id_solicitud =$idSolicitud");
    }

    function getInfoNotaria($idSolicitud)
    {
        return $this->db->query("SELECT se.*, de.*, n.* FROM solicitud_escrituracion se
		INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud
		INNER JOIN Notarias n ON n.idNotaria = se.idNotaria
		WHERE se.idSolicitud = $idSolicitud AND de.tipo_documento NOT IN (14,15,16,17)");
    }

    function saveDate($signDate, $idSolicitud)
    {
        $newDate = date("d-m-Y H:i:s", strtotime($signDate));
        $id_usuario = $this->session->userdata('id_usuario');
        return $this->db->query("UPDATE solicitudes_escrituracion SET fecha_firma = '$signDate' WHERE id_solicitud = $idSolicitud");
        /* return $response = $this->db->query("INSERT INTO historial_escrituracion VALUES($idSolicitud,26,0,'Nueva fecha para firma: $newDate',GETDATE(),$id_usuario,GETDATE(),$id_usuario,27)");*/
    }

    function getFileNameByDoctype($idSolicitud, $docType)
    {
        return $this->db->query("SELECT * FROM documentos_escrituracion WHERE idSolicitud = $idSolicitud AND tipo_documento = $docType");

    }

    function getInfoSolicitud($idSolicitud)
    {
        return $this->db->query("SELECT * FROM solicitud_escrituracion WHERE idSolicitud = $idSolicitud");
    }
    
    function insertNotariaValuador($idNotaria, $idValuador, $idSolicitud){
        return $this->db->query("UPDATE solicitud_escrituracion SET idNotaria= $idNotaria, idValuador = $idValuador WHERE idSolicitud = $idSolicitud;");
    }

    //ASIGNAR NOTARIA EXTERNA
    function asignarNotariaExterna($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, $id_solicitud){
        $id_usuario = $this->session->userdata('id_usuario');
        $response = $this->db->query("INSERT INTO notarias (nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece, estatus) VALUES('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', 0, 2, 1)");
        $insert_id = $this->db->insert_id();
        $response = $this->db->query("UPDATE solicitudes_escrituracion SET bandera_notaria = 1, id_notaria = $insert_id WHERE id_solicitud = $id_solicitud");
        $response = $this->db->query("INSERT INTO historial_escrituracion VALUES($id_solicitud,12,0,'SE ASIGNÓ NOTARÍA EXTERNA',GETDATE(),$id_usuario,GETDATE(),$id_usuario,0)");
        
        // if ($response) {
        //     return 1;
        // } else {
            return $response;
        // }
    }

    //ASIGNAR NOTARIA INTERNA
    function asignarNotariaInterna($id_solicitud){
        $id_usuario = $this->session->userdata('id_usuario');
        $response = $this->db->query("UPDATE solicitudes_escrituracion SET bandera_notaria = 1, id_notaria = 0 WHERE id_solicitud = $id_solicitud");
        $response = $this->db->query("INSERT INTO historial_escrituracion VALUES($id_solicitud,12,0,'SE ASIGNÓ NOTARÍA INTERNA',GETDATE(),$id_usuario,GETDATE(),$id_usuario,0)");
        
        return $response;
    }

    //INSERT NOTARIA DESDE POSTVENTA Y PASA AL STATUS 5
    function newNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono){
        $this->db->query("INSERT INTO Notarias(nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece)
                        VALUES('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', 0, 2)");
        $insert_id = $this->db->insert_id();
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');
        $idUsuario = $this->session->userdata('id_usuario');
        $estatus = $this->db->query("SELECT id_estatus FROM solicitudes_escrituracion WHERE id_solicitud = $idSolicitud")->row()->id_estatus;

        $this->db->query("UPDATE solicitudes_escrituracion SET id_notaria= $insert_id WHERE id_solicitud = $idSolicitud;");
        return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
         VALUES(($estatus), 57, 1, GETDATE(), 7, $idSolicitud, $rol, 6, 'Se trabajara con Notaría externa', 0, $idUsuario);");
    }

    //GESTION NOTARIA CLIENTE
    function getNotariaClient($idSolicitud)
    {
        $idSolicitud = $_GET['idSolicitud'];
        //print_r("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, n.direccion, n.correo, n.telefono FROM Notarias n INNER JOIN solicitud_escrituracion se ON se.idNotaria = n.idNotaria WHERE se.idSolicitud = $idSolicitud");
        return $this->db->query("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, n.direccion, n.correo, n.telefono FROM Notarias n INNER JOIN solicitud_escrituracion se ON se.idNotaria = n.idNotaria WHERE se.idSolicitud = '$idSolicitud'");
        
    }

    //RECHAZAR NOTARIA
    function rechazarNotaria(){
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');
        $idUsuario = $this->session->userdata('id_usuario');
        $this->db->query("UPDATE solicitud_escrituracion SET idNotaria = '', estatus = 10 WHERE idSolicitud = $idSolicitud;");
        
        return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
         VALUES(11, 59, 2, GETDATE(), 12, $idSolicitud, $rol, 10, 'Se rechazo la Notaría', 0, $idUsuario);");
    }

    function rechazarNotaria5(){
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');
        $idUsuario = $this->session->userdata('id_usuario');
        $this->db->query("UPDATE solicitud_escrituracion SET idNotaria = '', estatus = 4 WHERE idSolicitud = $idSolicitud;");
        
        return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
         VALUES(5, 57, 2, GETDATE(), 6, $idSolicitud, $rol, 4, 'Se rechazo la Notaría', 0, $idUsuario);");
    }

    function getEstatusConstruccion()
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 62");
        return $query->result_array();
    }

    function getEstatusPago()
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 63");
        return $query->result_array();
    }

    //OBSERVACIONES
    function updateObservacionesPostventa() {
        $idSolicitud = $_POST['idSolicitud'];
        $observaciones = $_POST['observacionesS'];
        $rol = $this->session->userdata('id_rol');
        $idUsuario = $this->session->userdata('id_usuario');
        $this->db->query("UPDATE solicitud_escrituracion SET estatus = 10 WHERE idSolicitud = $idSolicitud;");

        return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
         VALUES(13, 59, 3, GETDATE(), 14, $idSolicitud, $rol, 10, '$observaciones', 0, $idUsuario);");
    }

    function updateObservacionesProyectos() {
        $idSolicitud = $_POST['idSolicitud'];
        $observaciones = $_POST['observacionesS'];
        $rol = $this->session->userdata('id_rol');
        $idUsuario = $this->session->userdata('id_usuario');
        $this->db->query("UPDATE solicitud_escrituracion SET estatus = 93 WHERE idSolicitud = $idSolicitud;");

        return $this->db->query("INSERT INTO control_estatus (idStatus, idCatalogo, tipo, fecha_creacion, next, idEscrituracion, idArea, newStatus, comentarios, motivos_rechazo, modificado_por)
         VALUES(13, 59, 3, GETDATE(), 14, $idSolicitud, $rol, 10, '$observaciones', 0, $idUsuario);");
    }
 
    function getSolicitudEscrituracion($idSolicitud)
    {
        $idSolicitud = $_POST['idSolicitud'];

        return $this->db->query("SELECT * FROM solicitud_escrituracion WHERE idSolicitud = '$idSolicitud'");
    }

    
    function saveEstatusLote($data, $id_solicitud)
    {
        $response = $this->db->update("solicitudes_escrituracion", $data, "id_solicitud = $id_solicitud");
        if (!$response)
            return $finalAnswer = 0;
        else
            return $finalAnswer = 1;
    }

    
    function getPresupuestos($id_solicitud)
    {
        return $this->db->query("	SELECT pr.*, oxc.nombre FROM Presupuestos pr
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.tipo AND oxc.id_catalogo = 69
		WHERE idSolicitud = $id_solicitud");
    }

    function addPresupuesto($updateDocumentData, $idSolicitud, $presupuestoType, $idPresupuesto = null)
    {
        $response = $this->db->update("Presupuestos", $updateDocumentData, array("idSolicitud" => $idSolicitud, "tipo" =>$presupuestoType, "idPresupuesto"=> $idPresupuesto));
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function approvePresupuesto($data){
        $idUsuario = $this->session->userdata('id_usuario');
        $idPresupuesto = $data['idDocumento'];
        $idSolicitud = $data['idSolicitud'];
        $this->db->query("UPDATE Presupuestos SET estatus = 0 WHERE idSolicitud = $idSolicitud");
        return $this->db->query("UPDATE Presupuestos SET estatus = 1, modificado_por = $idUsuario  WHERE idPresupuesto = $idPresupuesto");
    }

    function getData_contraloria()
    {
        return $this->db->query("SELECT se.idSolicitud, l.nombreLote,cond.nombre nombreCondominio, r.nombreResidencial,
            se.nombre, oxc.nombre estatus, cp.tiempo as dias, ce.fecha_creacion,
            CASE WHEN (se.id_juridico IS null) THEN oxc2.nombre 
                ELSE CONCAT(uj.nombre, ' ', uj.apellido_paterno, ' ', uj.apellido_materno) END as area
            FROM solicitudes_escrituracion se
            INNER JOIN lotes l ON se.idLote = l.idLote 
            INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
            INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial 
            INNER JOIN clientes c ON c.id_cliente = se.idCliente AND c.status = 1
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus AND oxc.id_catalogo = 59 
            INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.idArea AND oxc2.id_catalogo = 1
            INNER JOIN control_procesos cp ON cp.estatus = se.estatus AND se.idArea = cp.idRol
            LEFT JOIN usuarios uj ON uj.id_usuario = se.id_juridico
            LEFT JOIN (SELECT idEscrituracion, max(fecha_creacion) fecha_creacion, newStatus FROM control_estatus GROUP BY idEscrituracion, newStatus) ce 
                ON ce.idEscrituracion = se.idSolicitud AND ce.newStatus= se.estatus
            ORDER BY se.fecha_creacion ASC");
    }

    function getData_titulacion()
    {
        return $this->db->query("SELECT se.idSolicitud, l.nombreLote,cond.nombre nombreCondominio, r.nombreResidencial,
        se.nombre, oxc.nombre estatus, oxc2.nombre area, DATEDIFF(day, ce.fecha_creacion, GETDATE()) - cp.tiempo as diferencia,
		(CASE WHEN DATEDIFF(day, ce.fecha_creacion, GETDATE()) > cp.tiempo THEN 'ATRASADO' ELSE 'EN TIEMPO' END) atrasado, cp.tiempo as dias, ce.fecha_creacion
        FROM solicitud_escrituracion se
        INNER JOIN lotes l ON se.idLote = l.idLote 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial 
        INNER JOIN clientes c ON c.id_cliente = se.idCliente AND c.status = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus AND oxc.id_catalogo = 59 
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.idArea AND oxc2.id_catalogo = 1
		INNER JOIN control_procesos cp ON cp.estatus = se.estatus AND se.idArea = cp.idRol
        LEFT JOIN (SELECT idEscrituracion, max(fecha_creacion) fecha_creacion, newStatus FROM control_estatus GROUP BY idEscrituracion, newStatus) ce ON ce.idEscrituracion = se.idSolicitud AND ce.newStatus= se.estatus
        ORDER BY se.fecha_creacion ASC");
    }

    function getData_postventa()
    {
        return $this->db->query("SELECT se.idSolicitud, l.nombreLote,cond.nombre nombreCondominio, r.nombreResidencial,
        se.nombre, oxc.nombre estatus, oxc2.nombre area, DATEDIFF(day, ce.fecha_creacion, GETDATE()) - cp.tiempo as diferencia,
		(CASE WHEN DATEDIFF(day, ce.fecha_creacion, GETDATE()) > cp.tiempo THEN 'ATRASADO' ELSE 'EN TIEMPO' END) atrasado, cp.tiempo as dias, ce.fecha_creacion
        FROM solicitud_escrituracion se
        INNER JOIN lotes l ON se.idLote = l.idLote 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial 
        INNER JOIN clientes c ON c.id_cliente = se.idCliente AND c.status = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus AND oxc.id_catalogo = 59 
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.idArea AND oxc2.id_catalogo = 1
		INNER JOIN control_procesos cp ON cp.estatus = se.estatus AND se.idArea = cp.idRol
        LEFT JOIN (SELECT idEscrituracion, max(fecha_creacion) fecha_creacion, newStatus FROM control_estatus GROUP BY idEscrituracion, newStatus) ce ON ce.idEscrituracion = se.idSolicitud AND ce.newStatus= se.estatus
        ORDER BY se.fecha_creacion ASC");
    }

    function getEstatusEscrituracion()
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 59 AND id_opcion NOT IN (25,90);");
        return $query->result_array();
    }

    // function getFullReportContraloria($idSolicitud)
    // {
    //     $query = $this->db->query("SELECT ce.idEscrituracion, max(ce.fecha_creacion) fecha_creacion,(CASE WHEN isNULL(DATEDIFF(day, ce.fecha_creacion,ISNULL(cee.fecha_creacion, GETDATE())) -CP.tiempo,0)< 0.0 THEN 0 ELSE isNULL(DATEDIFF(day, ce.fecha_creacion,ISNULL(cee.fecha_creacion, GETDATE())) -CP.tiempo,0) END) diferencia, ce.newStatus,
	// 	l.nombreLote,cond.nombre nombreCondominio, r.nombreResidencial,
    //     se.nombre, oxc.nombre estatus, oxc2.nombre area, cp.tiempo,
	// 	(CASE WHEN DATEDIFF(day, ce.fecha_creacion,ISNULL(cee.fecha_creacion, GETDATE())) > cp.tiempo THEN 'ATRASADO' ELSE 'EN TIEMPO' END) atrasado
	// 	FROM control_estatus ce
	// 	INNER JOIN solicitud_escrituracion se ON se.idSolicitud = ce.idEscrituracion
	// 	INNER JOIN lotes l ON se.idLote = l.idLote 
    //     INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
    //     INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial 
    //     INNER JOIN clientes c ON c.id_cliente = se.idCliente AND c.status = 1
    //     INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = ce.newStatus AND oxc.id_catalogo = 59 
    //     INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = ce.idArea AND oxc2.id_catalogo = 1
	// 	INNER JOIN control_procesos cp ON cp.estatus=ce.newStatus AND cp.idRol = ce.idArea
	// 	LEFT JOIN (SELECT idEscrituracion, max(fecha_creacion) fecha_creacion, newStatus FROM control_estatus GROUP BY idEscrituracion, newStatus) cee ON cee.newStatus = ce.newStatus + 1 AND cee.idEscrituracion = ce.idEscrituracion
	// 	WHERE ce.idEscrituracion = $idSolicitud GROUP BY ce.idEscrituracion, ce.newStatus,
	// 	l.nombreLote,cond.nombre, r.nombreResidencial,
    //     CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno), oxc.nombre, oxc2.nombre, cp.tiempo
	// 	,cee.fecha_creacion, ce.fecha_creacion,  se.nombre, se.nombre");
    //     return $query->result_array();
    // }

    function getFullReportContraloria($idSolicitud){
        $query = $this->db->query("WITH cte AS(
            SELECT MAX(fecha_creacion) fecha_creacion, comentarios,
            CAST((CASE WHEN idStatus = 91 or idStatus = 92 THEN idStatus-89 WHEN idStatus = 0 THEN idStatus+1 WHEN idStatus = 90 THEN 15.1 ELSE idStatus END) AS INT) idStatus, idEscrituracion
            FROM control_estatus 
            WHERE idEscrituracion = $idSolicitud GROUP BY idStatus, idEscrituracion , comentarios
        )
		SELECT cte.*, isNULL(lag(MAX(ce.fecha_creacion)) OVER (ORDER BY cte.idStatus), cte.fecha_creacion) fechados,
        l.nombreLote, cond.nombre nombreCondominio, r.nombreResidencial, se.nombre, 
        oxc.nombre estatus, oxc2.nombre area, cp.tiempo FROM cte
        INNER JOIN control_estatus ce ON ce.idEscrituracion = cte.idEscrituracion AND ce.fecha_creacion = cte.fecha_creacion
        INNER JOIN solicitud_escrituracion se ON se.idSolicitud = cte.idEscrituracion
        INNER JOIN lotes l ON se.idLote = l.idLote
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial 
        INNER JOIN clientes c ON c.id_cliente = se.idCliente AND c.status = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = cte.idStatus AND oxc.id_catalogo = 59 
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = ce.idArea AND oxc2.id_catalogo = 1
        INNER JOIN control_procesos cp ON cp.estatus=ce.idStatus AND cp.idRol = ce.idArea
        GROUP BY cte.idStatus, cte.idEscrituracion, cte.fecha_creacion, l.nombreLote, cond.nombre, r.nombreResidencial, se.nombre, oxc.nombre, oxc2.nombre, cp.tiempo, cte.comentarios");
        return $query->result_array();
    }

    function getTipoEscrituracion()
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 70");
        return $query->result_array();
    }

    function updateInformacion($data, $idSolicitud)
    {
        $response = $this->db->update("solicitudes_escrituracion", $data, "id_solicitud = $idSolicitud");
        if (!$response)
            return $finalAnswer = 0;
        else 
            return $finalAnswer = 1;
    }

    function getBudgetInformacion($idSolicitud){
        return $this->db->query("SELECT se.*, hl.modificado,
        cond.nombre nombreCondominio, r.nombreResidencial, l.nombreLote, oxc2.nombre nombreConst, oxc.nombre nombrePago, oxc3.nombre tipoEscritura,
        CASE se.cliente_anterior WHEN 1 THEN 'SÍ' ELSE 'NO' END cli_anterior
        FROM solicitudes_escrituracion se 
        INNER JOIN clientes c ON c.id_cliente = se.id_cliente
        LEFT JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.id_lote
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus_pago AND oxc.id_catalogo = 63
		LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.estatus_construccion AND oxc2.id_catalogo = 62
        LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = se.tipo_escritura AND oxc3.id_catalogo = 70
        WHERE se.id_solicitud = $idSolicitud");
    }

    function getNotariasXUsuario($idSolicitud)
    {
        $query = $this->db->query("SELECT nxu.*, n.nombre_notaria, n.direccion FROM notarias_x_usuario nxu 
        INNER JOIN Notarias n ON n.idNotaria = nxu.id_notaria
        WHERE id_solicitud = $idSolicitud AND n.Estatus = 1");
        return $query->result_array();
    }

    function getPresupuestosUpload($idNotariaxSolicitud)
    {
        $query = $this->db->query("SELECT  TOP (3) oxc.nombre, pres.idPresupuesto, pres.expediente,pres.tipo, pres.idNotariaxSolicitud,  nxu.* FROM notarias_x_usuario nxu
        INNER JOIN Presupuestos pres ON pres.idSolicitud = nxu.id_solicitud AND (pres.idNotariaxSolicitud = nxu.idNotariaxSolicitud OR pres.idNotariaxSolicitud IS NULL)
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pres.tipo AND oxc.id_catalogo = 69
        WHERE nxu.idNotariaxSolicitud = $idNotariaxSolicitud");
        return $query->result_array();
    }

    function updatePresupuestosNXU($idSolicitud, $idNotaria)
    {
        $response = $this->db->query("UPDATE Presupuestos SET idNotariaxSolicitud = (SELECT idNotariaxSolicitud FROM notarias_x_usuario WHERE id_notaria = $idNotaria AND id_solicitud = $idSolicitud) 
        WHERE idPresupuesto IN (SELECT MIN(idPresupuesto) id FROM Presupuestos WHERE idSolicitud = $idSolicitud AND idNotariaxSolicitud IS NULL
            GROUP BY tipo, idNotariaxSolicitud)");
    }

   
    
    function getDocumentsClientOtros($idSolicitud)
    {
        $query = $this->db->query("	SELECT de.idDocumento, oxc.nombre, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) creado_por, de.fecha_creacion, se.estatus estatusActual,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) estatus_validacion,
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) colour,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END) validado_por,
        de.estatus_validacion ev,
        (CASE 
        WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '')
        ELSE 'SIN  MOTIVOS DE RECHAZO'
        END) motivos_rechazo, 0 estatusPropuesta, de.editado
        FROM documentos_escrituracion de 
        INNER JOIN solicitud_escrituracion se ON se.idSolicitud = de.idSolicitud
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = de.tipo_documento AND oxc.id_catalogo = (CASE WHEN isNULL(se.personalidad,0) = 1 THEN 72 ELSE 60 END)
        LEFT JOIN usuarios us ON us.id_usuario = de.creado_por
        LEFT JOIN usuarios us2 ON us2.id_usuario = de.validado_por
        LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = de.idDocumento AND mrxd.estatus = 1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
        LEFT JOIN control_estatus ce ON ce.idEscrituracion = se.idSolicitud AND ce.idStatus = se.estatus AND de.estatus_validacion = 2
        WHERE de.idSolicitud = $idSolicitud AND de.tipo_documento NOT IN (1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17)
        GROUP BY
        de.idDocumento, oxc.nombre, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno), de.fecha_creacion, se.estatus,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END),
        de.estatus_validacion, de.editado
            UNION ALL
            SELECT pr.idPresupuesto idDocumento, CONCAT('Presupuesto ', oxc.nombre, ' - ', nota.nombre_notaria) nombre, pr.expediente, 13 tipo_documento, pr.idSolicitud,  CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) creado_por, pr.fecha_creacion, 
            se.estatus estatusActual,
            (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) estatus_validacion,
            (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) colour,
            (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END) validado_por,
            de.estatus_validacion ev,
            (CASE 
            WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '')
            ELSE 'SIN  MOTIVOS DE RECHAZO'
            END) motivos_rechazo, pr.estatus estatusPropuesta, null editado
    
            from Presupuestos pr
            INNER JOIN usuarios u ON u.id_usuario = pr.creado_por
            INNER JOIN solicitud_escrituracion se ON se.idSolicitud = pr.idSolicitud
            INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud AND de.tipo_documento = 13
            LEFT JOIN usuarios us2 ON us2.id_usuario = de.validado_por
            LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = de.idDocumento AND mrxd.estatus = 1 
            LEFT JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.tipo AND oxc.id_catalogo = 69
            INNER JOIN notarias_x_usuario nxu ON nxu.idNotariaxSolicitud = pr.idNotariaxSolicitud
			INNER JOIN Notarias nota ON nota.idNotaria = nxu.id_notaria
            WHERE pr.idSolicitud = $idSolicitud AND pr.expediente != ''
             GROUP BY
        pr.idPresupuesto , pr.expediente, pr.idSolicitud, oxc.nombre, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), pr.fecha_creacion, 
            se.estatus,
            (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
            (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
            (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END),
            de.estatus_validacion, pr.estatus,nota.nombre_notaria");
        return $query->result();
    }

    function getDocumentsClientPago($idSolicitud)
    {
        $query = $this->db->query("	SELECT de.idDocumento, oxc.nombre, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) creado_por, de.fecha_creacion, se.estatus estatusActual,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) estatus_validacion,
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) colour,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END) validado_por,
        de.estatus_validacion ev,
        (CASE 
        WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '')
        ELSE 'SIN  MOTIVOS DE RECHAZO'
        END) motivos_rechazo, 0 estatusPropuesta, de.editado
        FROM documentos_escrituracion de 
        INNER JOIN solicitud_escrituracion se ON se.idSolicitud = de.idSolicitud
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = de.tipo_documento AND oxc.id_catalogo = (CASE WHEN isNULL(se.personalidad,0) = 1 THEN 72 ELSE 60 END)
        LEFT JOIN usuarios us ON us.id_usuario = de.creado_por
        LEFT JOIN usuarios us2 ON us2.id_usuario = de.validado_por
        LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = de.idDocumento AND mrxd.estatus = 1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
        LEFT JOIN control_estatus ce ON ce.idEscrituracion = se.idSolicitud AND ce.idStatus = se.estatus AND de.estatus_validacion = 2
        WHERE de.idSolicitud = $idSolicitud AND de.tipo_documento NOT IN (1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 20, 21)
        GROUP BY
        de.idDocumento, oxc.nombre, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno), de.fecha_creacion, se.estatus,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END),
        de.estatus_validacion, de.editado
            UNION ALL
            SELECT pr.idPresupuesto idDocumento, CONCAT('Presupuesto ', oxc.nombre, ' - ', nota.nombre_notaria) nombre, pr.expediente, 13 tipo_documento, pr.idSolicitud,  CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) creado_por, pr.fecha_creacion, 
            se.estatus estatusActual,
            (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) estatus_validacion,
            (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) colour,
            (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END) validado_por,
            de.estatus_validacion ev,
            (CASE 
            WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '')
            ELSE 'SIN  MOTIVOS DE RECHAZO'
            END) motivos_rechazo, pr.estatus estatusPropuesta, null editado
    
            from Presupuestos pr
            INNER JOIN usuarios u ON u.id_usuario = pr.creado_por
            INNER JOIN solicitud_escrituracion se ON se.idSolicitud = pr.idSolicitud
            INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud AND de.tipo_documento = 13
            LEFT JOIN usuarios us2 ON us2.id_usuario = de.validado_por
            LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = de.idDocumento AND mrxd.estatus = 1 
            LEFT JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.tipo AND oxc.id_catalogo = 69
            INNER JOIN notarias_x_usuario nxu ON nxu.idNotariaxSolicitud = pr.idNotariaxSolicitud
			INNER JOIN Notarias nota ON nota.idNotaria = nxu.id_notaria
            WHERE pr.idSolicitud = $idSolicitud AND pr.expediente != ''
             GROUP BY
        pr.idPresupuesto , pr.expediente, pr.idSolicitud, oxc.nombre, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), pr.fecha_creacion, 
            se.estatus,
            (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
            (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
            (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END),
            de.estatus_validacion, pr.estatus,nota.nombre_notaria");
        return $query->result();
    }

    public function obtenerJuridicoAsignacion()
    {
        $query = $this->db->query('SELECT id_usuario FROM solicitud_juridico WHERE orden = (SELECT TOP 1 MIN(orden) 
                                          FROM solicitud_juridico WHERE esta_activo = 0)');
        return $query->row();
    }

    public function asignarJuridicoActivo($usuarioId)
    {
        $this->db->query("UPDATE solicitud_juridico SET esta_activo = 1 WHERE id_usuario = $usuarioId");
    }

    public function restablecerJuridicosAsignados()
    {
        $this->db->query('UPDATE solicitud_juridico set esta_activo = 0');
    }

    public function existeNotariaSolicitud($idSolicitud, $idNotaria)
    {
        $query = $this->db->query("SELECT idNotariaxSolicitud FROM notarias_x_usuario 
             WHERE id_solicitud = $idSolicitud AND id_notaria = $idNotaria");
        return $query->row();
    }

    function getOpcCat($id_cat){
        return $this->db->query("SELECT OPCAT.id_opcion, OPCAT.nombre, CASE WHEN CAT.nombre = 'Estado civil' THEN 'ecivil' WHEN CAT.nombre = 'Régimen matrimonial' THEN 'rconyugal' WHEN CAT.nombre = 'Personalidad jurídica' THEN 'perj' END AS etq
                                FROM opcs_x_cats AS OPCAT
                                INNER JOIN catalogos AS CAT
                                ON OPCAT.id_catalogo = CAT.id_catalogo
                                WHERE OPCAT.id_catalogo IN ($id_cat) AND OPCAT.estatus = 1
                                ORDER BY OPCAT.id_catalogo");
    }

    public function InsertCli($datos){
        $user = $this->session->userdata;
        $id_usuario = $user['id_usuario'];
        $idGerente = ($user['idGerente'] == '' || !empty($user['idGerente']) ) ? 'NULL' : $user['idGerente'];
        $id_sede = $user['id_sede'];
        $nombre2 = $datos['nombre2'];
        $ape1 = $datos['ape1'];
        $ape2 = $datos['ape2'];
        $rfc = $datos['rfc'];
        $correo = $datos['correo'];
        $telefono = ( !empty($datos['telefono']) || $datos['telefono'] == '') ? 'NULL' : $datos['telefono'];
        $cel = (!empty($datos['cel']) || $datos['cel'] == '') ? 'NULL' : $datos['cel'];
        $ecivil = (!array_key_exists('ecivil', $datos) || !empty($datos['ecivil']) || $datos['ecivil'] == '') ? 'NULL' : $datos['ecivil'];
        $rconyugal = (!array_key_exists('rconyugal', $datos) || !empty($datos['rconyugal']) || $datos['rconyugal'] == '') ? 'NULL' : $datos['rconyugal'];
        $direccion = $datos['direccion'];
        $origen = $datos['origen'];
        $ocupacion = $datos['ocupacion'];
        $idLote = $datos['idLote'];
        $usuario = $user['usuario'];
        $idCondominio = $datos['idCondominio'];
        $usuario = $user['usuario'];
        $this->db->query("INSERT INTO clientes (id_asesor
                ,id_coordinador
                ,id_gerente
                ,id_sede
                ,nombre
                ,apellido_paterno
                ,apellido_materno
                ,rfc
                ,correo
                ,telefono1
                ,telefono2
                ,estado_civil
                ,regimen_matrimonial
                ,domicilio_particular
                ,originario_de
                ,ocupacion
                ,status
                ,idLote
                ,usuario
                ,idCondominio
                ,fecha_creacion
                ,creado_por
                ,fecha_modificacion
)
        VALUES  ($id_usuario,
                $id_usuario,
                $idGerente,
                $id_sede,
                '$nombre2',
                '$ape1',
                '$ape2',
                '$rfc',
                '$correo',
                $telefono,
                $cel,
                $ecivil,
                $rconyugal,
                '$direccion',
                '$origen',
                '$ocupacion',
                1,
                $idLote,
                '$usuario',
                $idCondominio,
                GetDate(),
                1,
                GetDate())");
        $ult_insert = $this->db->query("SELECT SCOPE_IDENTITY() as ult_reg")->row();
        $this->db->query("UPDATE lotes SET idCliente = $ult_insert->ult_reg WHERE idLote = $idLote");
        return  $ult_insert;
    }


    public function SolicitudesEscrituracion($idUsu){
        if($idUsu == ''){
            $queryExtra = '';
        }else 
        {
            $queryExtra = "WHERE CONCAT(usuti.nombre, ' ' ,usuti.apellido_paterno ,' ',usuti.apellido_materno  )  like  "."'%$idUsu%'"; 
        }
        $cmd = ("SELECT distinct(se.id_solicitud), cp.estatus_actual, se.id_estatus, se.fecha_creacion, l.nombreLote, se.id_estatus idEstatus,se.bandera_comite,se.bandera_admin,
        cond.nombre nombreCondominio, r.nombreResidencial, c.nombre as cliente, n.pertenece, se.id_notaria, se.descuento, 
        se.aportacion, ae.id_actividad,se.id_titulacion ,CONCAT(usuti.nombre, ' ' ,usuti.apellido_paterno ,' ',usuti.apellido_materno  ) as nombre,
        ae.clave, ae.nombre actividad, ar.id_opcion as id_area, ar.nombre as area,
        (CASE WHEN se.id_estatus in (2) THEN CONCAT(cp.clave_actividad ,' - ', (STRING_AGG(cp.nombre_actividad, ' y ')))
        ELSE CONCAT(cp.clave_actividad ,' - ', STRING_AGG(cp.nombre_actividad, ' ')) END) AS nombre_estatus
        
        FROM solicitudes_escrituracion se 
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN clientes c ON c.id_cliente = l.idCliente
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
        INNER JOIN control_permisos cp ON se.id_estatus = cp.estatus_actual AND cp.bandera_vista = 1
        INNER JOIN actividades_escrituracion ae ON ae.clave = cp.clave_actividad AND cp.bandera_vista = 1
        INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1
        LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
        LEFT JOIN usuarios usuti on usuti.id_rol = 57 and usuti.estatus = 1 and usuti.id_usuario = se.id_titulacion
        LEFT JOIN historial_escrituracion h ON h.id_solicitud = se.id_solicitud
        $queryExtra
        GROUP BY se.id_solicitud, cp.estatus_actual, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre, r.nombreResidencial, 
        c.nombre, n.pertenece,se.id_titulacion, se.id_notaria, se.descuento, se.aportacion, ae.id_actividad, ae.clave, cp.tipo_permiso, cp.clave_actividad,
        cp.clave_actividad, ae.nombre, ar.id_opcion, ar.nombre,CONCAT(usuti.nombre, ' ' ,usuti.apellido_paterno ,' ',usuti.apellido_materno  ) , cp.estatus_siguiente, cp.area_siguiente, se.bandera_comite, se.bandera_admin");
        
        $query = $this->db->query($cmd);
        return $query->result_array();       
    }
    public function GetTitulaciones()
    {
        $cmd = ("SELECT id_usuario,  CONCAT(nombre, ' ' ,apellido_paterno ,' ',apellido_materno  ) as nombre , id_rol ,usuario,id_sede FROM usuarios WHERE id_rol = 57 and estatus = 1");
        $query = $this->db->query($cmd);
        return $query->result_array(); 
    }
    function cambiarTitulacion($clave , $data){
        try {
            $this->db->where('id_solicitud', $clave);
            $this->db->update('solicitudes_escrituracion', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }
    function updateauditoria($insertArray)
    {
     
        $this->db->insert('auditoria', $insertArray);
        $afftectedRows = $this->db->affected_rows();
        return $afftectedRows > 0 ? TRUE : FALSE ;
    }
    
    function getDocumentosPorSolicitud($solicitud, $estatus )
    {
        $cmd="SELECT de.idDocumento, de.movimiento, de.expediente, de.modificado, de.status , de.idSolicitud ,de.idUsuario ,de.tipo_documento,
        de.modificado as documento_modificado_por, de.creado_por as documento_creado_por, de.fecha_creacion as creacion_documento ,
        de.estatus_validacion as estatusValidacion ,opc.id_opcion , opc.id_catalogo, de.estatus_validacion as validacion,
        opc.nombre, opc.estatus , opc.estatus , opc.fecha_creacion, se.id_solicitud , se.id_estatus as estatus_solicitud, se.estatus_construccion
        FROM documentos_escrituracion de, opcs_x_cats opc, solicitudes_escrituracion se 
        WHERE opc.id_catalogo = 72 
        AND de.expediente IS NOT  NULL 
        AND de.tipo_documento = opc.id_opcion 
        AND se.id_solicitud = de.idSolicitud 
        AND opc.estatus in $estatus 
        AND de.idSolicitud = $solicitud";
        $query = $this->db->query($cmd);
        return $query->result_array();

    }
    
    function documentosNecesarios( $estatus){

        $cmd=("SELECT * FROM opcs_x_cats WHERE id_catalogo = 72 AND id_opcion in  $estatus");
        $query = $this->db->query($cmd);
        return $query->result_array();

    }   
    
    function insertDocumentNuevo($insertDocumentNuevo)
    {
     
        $this->db->insert('documentos_escrituracion', $insertDocumentNuevo);
        $afftectedRows = $this->db->affected_rows();
        
        return $afftectedRows > 0 ? $this->db->insert_id() : FALSE ;
    }
    public function  eliminarDoc($idDocumento)
    {
        $this->db->where('idDocumento', $idDocumento);
        $this->db->delete('documentos_escrituracion');
        $afftectedRows = $this->db->affected_rows();
        
        return $afftectedRows > 0 ? TRUE : FALSE ;
    }


    public function actualizarDocs($clave , $data){
        try {
            $this->db->where('idDocumento', $clave);
            $this->db->update('documentos_escrituracion', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }



    function getMotivosRechazos($tipoDocumento)
    {
        $query = $this->db->query("SELECT * FROM motivos_rechazo WHERE tipo_proceso = 2 AND tipo_documento = $tipoDocumento");
        return $query->result();
    }
    function getStatusSiguiente($estatus){
        return $this->db->query("SELECT ae.nombre as actividad, cp.id_estatus, cp.bandera_vista, cp.estatus_actual, ae.clave as clave_actual, cp.nombre_actividad as actividad_actual, cp.area_actual, cp.estatus_siguiente, cr.clave_siguiente, cr.actividad_siguiente, cp.area_siguiente, cp.tipo_permiso, ar.nombre as area, cr.nombre_siguiente, pr.nombre as permiso
        FROM actividades_escrituracion ae 
        INNER JOIN control_permisos cp ON cp.clave_actividad LIKE ae.clave
        INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1
        INNER JOIN opcs_x_cats pr ON pr.id_opcion = cp.tipo_permiso AND pr.id_catalogo = 80
        LEFT JOIN (SELECT DISTINCT(cl.clave_actividad) as clave_siguiente, cl.nombre_actividad as actividad_siguiente, cl.estatus_actual, cl.tipo_permiso,
        av.nombre as nombre_siguiente FROM control_permisos cl INNER JOIN actividades_escrituracion av ON cl.clave_actividad LIKE av.clave WHERE cl.tipo_permiso = 1 
        GROUP BY cl.estatus_actual, cl.clave_actividad, cl.nombre_actividad, cl.tipo_permiso, av.nombre) cr ON cr.estatus_actual = cp.estatus_siguiente
        WHERE cp.tipo_permiso = 3 AND cp.estatus_actual in($estatus)")->result_array();
    }


 //INSERT NUEVA NOTARIA
 function insertNewNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono){
    $idUsuario = $this->session->userdata('id_usuario');
    $this->db->query("INSERT INTO Notarias(nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece)
    VALUES('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', 0, 2);");
    $insert_id = $this->db->insert_id();
    $idSolicitud = $_POST['idSolicitud'];
    $rol = $this->session->userdata('id_rol');
    $estatus = $this->db->query("SELECT id_estatus FROM solicitudes_escrituracion WHERE id_solicitud = $idSolicitud")->row()->id_estatus;
    $estatus_siguiente = $estatus == 19 || $estatus == 22 ? 20 : 25;
    //print_r("UPDATE solicitud_escrituracion SET idNotaria= $insert_id WHERE idSolicitud = $idSolicitud;");
    $this->db->query("UPDATE solicitudes_escrituracion SET id_notaria= $insert_id WHERE id_solicitud = $idSolicitud;");
    return $this->db->query("INSERT INTO historial_escrituracion (id_solicitud, numero_estatus,tipo_movimiento, descripcion, fecha_creacion, creado_por, fecha_modificacion, modificado_por, estatus_siguiente)
    VALUES($idSolicitud,".$estatus.",0,'Cambio de Notaria',GETDATE(),$idUsuario,GETDATE(),$idUsuario,$estatus_siguiente);");
}







}