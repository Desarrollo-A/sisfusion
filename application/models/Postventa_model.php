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
        WHERE idCondominio = $idCondominio AND idStatusLote in (2,9) 
        AND idLote NOT IN(SELECT idLote FROM clientes WHERE id_cliente IN (SELECT id_cliente FROM solicitudes_escrituracion)) ORDER BY nombreLote asc");
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
            return $this->db->query("SELECT c.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.ocupacion, 1 as num_cli,
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

     /**
     * Función para buscar el path donde se encuentra el archivo en los diferentes tipos de proceso de contratación
     *
     * @param $tipoDocumento
     * @param $tipoContratacion
     * @param $nombreLote
     * @param bool $eliminarArchivo bandera para saber si se eliminará el archivo o no para no afectar los archivos del patch viejo
     * @param $nombreDocumento
     * @return string
     */


    public function getCarpetaArchivo(
        $tipoDocumento, $tipoContratacion = 1, $nombreLote = '', $nombreDocumento = '', $eliminarArchivo = false
    ): string
    {
        if ($tipoContratacion == 0 || $tipoContratacion == 1) {
            return $this->obtenerPathViejoContratacion($tipoDocumento);
        }

        if ($tipoContratacion == 2 || $tipoContratacion == 3 || $tipoContratacion == 4) {
            
            $pathViejo = $this->obtenerPathViejoContratacion($tipoDocumento);
            return (file_exists($pathViejo.$nombreDocumento)) ? $pathViejo : $pathNuevo;
        }

        return '';
    }

    private function obtenerPathViejoContratacion($tipoDocumento): string
    {
        $pathBase = 'static/documentos/cliente/';  

        if ($tipoDocumento == 7 || $tipoDocumento == 39) { // CORRIDA FINANCIERA: CONTRALORÍA
            return "{$pathBase}corrida/";
        }

        if ($tipoDocumento == 8 || $tipoDocumento == 40) { // CONTRATO: JURÍDICO
            return "{$pathBase}contrato/";
        }

        if ($tipoDocumento == 30) { // CONTRATO FIRMADO: CONTRALORÍA
            return "{$pathBase}contratoFirmado/";
        }
        return "{$pathBase}expediente/";
    }

    
    
    public function getNameLote($idLote){
		$query = $this->db-> query("SELECT l.idLote, l.nombreLote, cond.nombre, res.nombreResidencial, 
            l.observacionContratoUrgente, cl.proceso
            FROM lotes l
            INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
            INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
            INNER JOIN clientes cl ON cl.idLote = l.idLote
		    where l.idLote = $idLote AND cl.status = 1");
		return $query->row();
	}

    function getDetalleNota($id_solicitud){
 
        return $this->db->query("SELECT CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS nombre, he.descripcion,he.fecha_creacion as fecha_creacion, he.tipo_movimiento, '' AS color
        FROM solicitudes_escrituracion se
        JOIN historial_escrituracion he ON se.id_solicitud = he.id_solicitud
        JOIN usuarios us ON he.creado_por = us.id_usuario
        WHERE se.id_solicitud = $id_solicitud AND he.tipo_movimiento = 0
		UNION
        (SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS nombre, Concat('Rechazo: ',mr.motivo) as descripcion, he.fecha_creacion as fecha_creacion, he.tipo_movimiento, '#B03A2E' AS color
        FROM solicitudes_escrituracion se
        JOIN historial_escrituracion he ON se.id_solicitud = he.id_solicitud
        JOIN usuarios us ON he.creado_por = us.id_usuario
		JOIN motivos_rechazo mr ON mr.id_motivo=he.descripcion AND he.tipo_movimiento = 1
        WHERE se.id_solicitud = $id_solicitud  AND he.numero_estatus NOT IN(28,31))
		ORDER BY he.fecha_creacion  DESC");
    }

    function getEmpRef($idLote){
        return $this->db->query("SELECT l.referencia, r.empresa
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE l.idLote = $idLote");
    }

    function setEscrituracion( $personalidad, $idLote,$idCliente, $idPostventa, $data, $idJuridico, $valor_contrato)
    {
        $replace = ["$", ","];
        $valor_contrato = str_replace($replace,"",$valor_contrato);
        if(is_object($data)){
            $data = (array)$data;
        }
        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');
        $idEstatus = (isset($data['idEstatus']) || $data['idEstatus'] != '') && $data['idEstatus'] == 8 ? 1:2;
        $claveCat = (!isset($data['ClaveCat']) || $data['ClaveCat'] = '') ? 'NULL' : $data['ClaveCat'];
      
        $this->db->query("INSERT INTO solicitudes_escrituracion (id_lote,id_cliente,id_actividad,id_estatus,estatus_pago,superficie,clave_catastral,estatus_construccion,id_notaria,id_valuador,tipo_escritura,id_postventa,personalidad_juridica,aportacion,descuento,id_titulacion,fecha_creacion,creado_por,fecha_modificacion,modificado_por,valor_contrato,valor_escriturar) VALUES($idLote, $idCliente,1,1,$idEstatus,0,'$claveCat',0,0,0,0,$idPostventa,$personalidad,0,0,$idJuridico,GETDATE(),$idUsuario,GETDATE(),$idUsuario,'$valor_contrato',NULL)");
        $insert_id = $this->db->insert_id();

        $opciones = $this->db->query("SELECT * FROM documentacion_escrituracion WHERE tipo_personalidad IN (0,$personalidad)")->result_array();
        foreach ($opciones as $row) {
            $this->db->query("INSERT INTO documentos_escrituracion VALUES('creacion de rama',NULL,GETDATE(),1,$insert_id,$idUsuario,".$row['id_documento'].",$idUsuario,$idUsuario,GETDATE(),NULL,NULL,NULL,".$row['obligatorio'].",".$row['documento_a_validar'].");");
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

        if($estatus == 0){
            if($rol == 57 && $idUsuario!= 10865){
                $AddWhere  =   " WHERE se.id_titulacion = $idUsuario ";
            }else if($rol == 11){
                $AddWhere  =   " WHERE cp.area_actual in ($rol) OR (se.id_estatus IN (4,2) AND se.bandera_admin IS NULL) ";
            }else if($rol == 56){
                $AddWhere  =   " WHERE cp.area_actual in ($rol) OR (se.id_estatus IN (3,2) AND se.bandera_comite IS NULL) ";
            }else{
                $AddWhere  =   " WHERE cp.area_actual in ($rol) ";
            }
        }else{
            $AddWhere = " ";
        }

        if($tipo_tabla == 1){
            $filtroTabla = $estatus == 0 ? " AND se.id_estatus in (47,50)" : " WHERE se.id_estatus in (47,50)" ;
        }else if($tipo_tabla == 0){
        $filtroTabla = $estatus == 0 ? " AND se.id_estatus not in (47,50,49,54)" : " WHERE se.id_estatus not in (47,50,49,54)";
        }else if($tipo_tabla == 2){
            $filtroTabla = $estatus == 0 ? " AND se.id_estatus in (54)" : " WHERE se.id_estatus in (54)";
            }
        if($begin != 0){
        $WhereFechas = " AND se.fecha_creacion >= '$begin' AND se.fecha_creacion <= '$end' ";
        }
        
        return $this->db->query("SELECT distinct(se.id_solicitud),CONCAT(creado.nombre, ' ', creado.apellido_paterno, ' ', creado.apellido_materno) as creado,se.creado_por,se.id_cliente,se.id_lote,c.banderaEscrituracion,se.id_titulacion, se.valor_contrato, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre nombreCondominio, r.nombreResidencial, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as cliente, n.pertenece, se.bandera_notaria, se.descuento, se.aportacion, ar.id_opcion as id_area, (CASE WHEN se.id_estatus IN (4,2,3) AND (se.bandera_admin IS NULL OR se.bandera_comite IS NULL) THEN 'Administración / Comité técnico' ELSE ar.nombre END) area, cp.area_actual, dc.expediente, dc.tipo_documento, dc.idDocumento, cr.area_sig, CONCAT(cp.clave_actividad ,' - ', ae.nombre) AS nombre_estatus, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, se.cliente_anterior, (CASE when cp.tipo_permiso = 3 THEN 'RECHAZO' ELSE '' END ) rechazo, concat((select[dbo].[DiasLaborales]( (dateadd(day,1,se.fecha_modificacion)) ,GETDATE())), ' día(s) de ',ae.dias_vencimiento) vencimiento, de4.contrato,pr.banderaPresupuesto,presup2.presupuestoAprobado,se.id_notaria, se.fecha_firma, a.descripcion ultimo_comentario,CONCAT(userAsig.nombre, ' ', userAsig.apellido_paterno, ' ', userAsig.apellido_materno) asignada_a,de2.documentosCargados, 
        de2.estatusValidacion,de2.no_rechazos,doc22.documentosCargados22, doc22.estatusValidacion22,doc22.no_rechazos22,doc22.no_editados22,de5.formasPago, 
        (CASE WHEN se.id_estatus IN (5,7,10,16,21,24,30,34,36,37,40,44,50,52,58,59) THEN 'RECHAZO' ELSE 'PROCESO NORMAL' END) estatusAct
        FROM solicitudes_escrituracion se 
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN clientes c ON c.id_cliente = l.idCliente 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
        INNER JOIN control_permisos cp ON se.id_estatus = cp.estatus_actual AND cp.bandera_vista in (1)
        INNER JOIN control_permisos cs ON se.id_estatus = cs.estatus_actual and cs.clasificacion in (1,2)
        INNER JOIN usuarios userAsig ON userAsig.id_usuario=se.id_titulacion
        LEFT JOIN usuarios creado ON creado.id_usuario=se.creado_por
        INNER JOIN actividades_escrituracion ae ON ae.clave = cp.clave_actividad 
        INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1

        LEFT JOIN documentos_escrituracion dc ON dc.idSolicitud = se.id_solicitud AND dc.tipo_documento in(CASE WHEN se.id_estatus in (3,4,6,8,9,10) THEN 18 WHEN se.id_estatus in(18,21) THEN 7 WHEN se.id_estatus in(46,52) THEN 19 WHEN se.id_estatus in(47,50) THEN 14 WHEN se.id_estatus in(29,40,33,41) THEN 15 WHEN se.id_estatus in(39,44,42,45) THEN 13 ELSE 11 END) 
        LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
        
        LEFT JOIN (SELECT a.id_solicitud, a.fecha_creacion, (CASE WHEN a.tipo_movimiento = 1 THEN CONCAT(MAX(mr.motivo),' ',us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno,' - ',rol.nombre) ELSE CONCAT(MAX(a.descripcion),' ',us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' - ', rol.nombre) END) AS descripcion 
        FROM historial_escrituracion a
        INNER JOIN (SELECT id_solicitud, MAX(fecha_creacion) fecha_max FROM historial_escrituracion GROUP BY id_solicitud) b ON a.id_solicitud = b.id_solicitud AND a.fecha_creacion = b.fecha_max
        INNER JOIN usuarios us ON us.id_usuario = a.creado_por 
        INNER JOIN opcs_x_cats rol ON rol.id_opcion = us.id_rol AND rol.id_catalogo = 1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = TRY_CAST(a.descripcion AS INT) 
        GROUP BY a.id_solicitud, a.fecha_creacion, a.descripcion, mr.motivo, a.tipo_movimiento, rol.nombre, us.nombre, us.apellido_paterno, us.apellido_materno) a ON a.id_solicitud=se.id_solicitud


        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) 
            THEN 0 ELSE 1 END documentosCargados,  
            CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion = 1 THEN 1 END) THEN 0 ELSE 1 END estatusValidacion,
            COUNT(CASE WHEN estatus_validacion = 2 THEN 1 END) no_rechazos
            FROM documentos_escrituracion 
            WHERE documento_a_validar=1
            GROUP BY idSolicitud) de2 ON de2.idSolicitud = se.id_solicitud 

            LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) 
            THEN 0 ELSE 1 END documentosCargados22,  
            CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion = 1 THEN 1 END) THEN 0 ELSE 1 END estatusValidacion22,
            COUNT(CASE WHEN estatus_validacion = 2 THEN 1 END) no_rechazos22,
            COUNT(CASE WHEN editado = 1 THEN 1 END) no_editados22
            FROM documentos_escrituracion 
            WHERE tipo_documento=22
            GROUP BY idSolicitud) doc22 ON doc22.idSolicitud = se.id_solicitud 

        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END banderaPresupuesto FROM Presupuestos WHERE expediente != '' GROUP BY idSolicitud) pr ON pr.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) THEN 0 ELSE 1 END contrato
        FROM documentos_escrituracion WHERE tipo_documento = 18 GROUP BY idSolicitud) de4 ON de4.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion=1 THEN 1 END) THEN 0 ELSE 1 END formasPago
        FROM documentos_escrituracion WHERE tipo_documento = 7 GROUP BY idSolicitud) de5 ON de5.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END presupuestoAprobado FROM Presupuestos WHERE estatus = 1 GROUP BY idSolicitud) presup2 ON presup2.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT DISTINCT(cl.clave_actividad), cl.estatus_actual as estatus_siguiente, cl.clasificacion, cl.tipo_permiso, ar2.nombre as area_sig, CONCAT(av.clave,' - ', av.nombre, '-', ar2.nombre) as nombre_estatus_siguiente FROM control_permisos cl INNER JOIN actividades_escrituracion av ON cl.clave_actividad LIKE av.clave INNER JOIN opcs_x_cats ar2 ON ar2.id_opcion = cl.area_actual AND ar2.id_catalogo = 1 WHERE cl.clasificacion in (1,2)
        GROUP BY cl.estatus_actual, cl.clave_actividad, cl.clasificacion, cl.estatus_actual, cl.tipo_permiso, av.nombre, av.clave, ar2.nombre) cr ON cr.estatus_siguiente = cs.estatus_siguiente
        $AddWhere $filtroTabla $WhereFechas
        GROUP BY doc22.no_editados22,creado.nombre,creado.apellido_paterno,creado.apellido_materno,doc22.documentosCargados22,se.creado_por, doc22.estatusValidacion22,doc22.no_rechazos22,se.id_solicitud,c.banderaEscrituracion,se.id_cliente,se.id_lote,doc22.documentosCargados22, doc22.estatusValidacion22,doc22.no_rechazos22,de2.documentosCargados,presup2.presupuestoAprobado,de2.estatusValidacion,de2.no_rechazos,se.id_titulacion, cp.estatus_actual, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre, r.nombreResidencial, c.nombre,c.apellido_paterno,c.apellido_materno, n.pertenece, se.bandera_notaria, se.descuento, se.aportacion, ae.id_actividad, ae.clave, cp.tipo_permiso, cp.clave_actividad, cp.clave_actividad, ae.nombre, ar.id_opcion, cp.estatus_siguiente, ar.nombre, cp.nombre_actividad, cp.estatus_siguiente, cp.estatus_siguiente, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso, dc.expediente, dc.tipo_documento, dc.idDocumento, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, cp.area_actual, se.cliente_anterior, cr.area_sig, ae.nombre, ae.dias_vencimiento,se.fecha_modificacion, de4.contrato, a.descripcion,pr.banderaPresupuesto,se.id_notaria,se.fecha_firma,userAsig.nombre,userAsig.apellido_paterno, userAsig.apellido_materno, se.valor_contrato,de5.formasPago ORDER BY se.id_solicitud DESC");


    }

    function getNotarias()
    {
        return $this->db->query("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, UPPER(n.direccion) AS direccion, UPPER(n.correo) AS correo, n.telefono, UPPER(s.nombre) AS nombre, n.pertenece 
        FROM Notarias n
        JOIN sedes s ON n.sede = s.id_sede
        WHERE sede != 0 and n.Estatus = 1
        ORDER BY n.idNotaria");
    }

    function get_proyecto_lista(){
        return $this->db->query("SELECT lotx.proyectoReubicacion AS idResidencial, CONCAT(res.nombreResidencial, ' - ' , res.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales res ON res.idResidencial = lotx.proyectoReubicacion");
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

        $estatus = $this->db->query("SELECT id_estatus,bandera_admin,bandera_comite,id_notaria,bandera_notaria,personalidad_juridica FROM solicitudes_escrituracion WHERE id_solicitud = $id_solicitud")->row();//->id_estatus;
      
        $sqlAreaRechazo = '';
        if($area_rechazo != 0 && $area_rechazo != ''){
            $sqlAreaRechazo = " AND estatus_siguiente=$area_rechazo ";
        }
        $personalidadJuridica = $estatus->personalidad_juridica;
        $notaria = $estatus->id_notaria; 
        $notariaInterna = '';
        if($estatus->id_estatus == 12 && $notaria == 0 && $estatus->bandera_notaria == 1 && $type == 1){
            $notariaInterna = ' AND estatus_siguiente=13 ';
        }
        if($estatus->id_estatus == 12 && $notaria != 0 && $estatus->bandera_notaria == 1 && $type == 1){
            $pertenece = $this->db->query("SELECT pertenece FROM solicitudes_escrituracion se INNER JOIN Notarias n ON n.idNotaria = se.id_notaria WHERE id_solicitud = $id_solicitud")->row()->pertenece;
            $notariaInterna = $pertenece == 2 ? ' AND estatus_siguiente=18 ' : ' AND estatus_siguiente=13 ';
        }
       
        if($estatus->id_estatus == 3 && $estatus->bandera_admin == 1 && $estatus->bandera_comite == 0){
            $estatus = $estatus->id_estatus;
            $actividades_x_estatus = (object)array("estatus_siguiente" => 4 ,"estatus_actual" => 3 , "clave_actividad" => "APE0002");
        }
        else if($estatus->id_estatus == 4 && $estatus->bandera_admin == 0 && $estatus->bandera_comite == 1){
            $estatus = $estatus->id_estatus;
            $actividades_x_estatus = $type == 3 ? (object)array("estatus_siguiente" => 58 ,"estatus_actual" => 4, "clave_actividad" => "APE0003") : (object)array("estatus_siguiente" => 3 ,"estatus_actual" => 4, "clave_actividad" => "APE0003"); 
        }
        else if($estatus->id_estatus == 2 && $estatus->bandera_admin == 0 && $estatus->bandera_comite == 0){
            $estatus = $estatus->id_estatus;
            $estatus_sig =  $rol == 56 ? 4 : 3;
            $clave =  $rol == 56 ? 'APE0003' : 'APE0002';
            $actividades_x_estatus = $type == 3 ? (object)array("estatus_siguiente" => 58 ,"estatus_actual" => 2, "clave_actividad" => "APE0002") : (object)array("estatus_siguiente" => $estatus_sig ,"estatus_actual" => 2, "clave_actividad" => $clave);
        }
        else {
            $estatus = $estatus->id_estatus;
            $actividades_x_estatus = $this->db->query("SELECT * FROM control_permisos WHERE estatus_actual=$estatus AND area_actual=$rol $notariaInterna $sqlAreaRechazo and tipo_permiso=$type")->row();
        }
        $banderasStatusRechazo = $actividades_x_estatus->estatus_siguiente == 5 ? ' ,bandera_admin=0 ' : ($actividades_x_estatus->estatus_siguiente == 7 ? ' ,bandera_comite=0' : '');
        $banderasStatus2 = $actividades_x_estatus->estatus_siguiente == 3 && $type == 1 ? ' ,bandera_admin=1 ' : ($actividades_x_estatus->estatus_siguiente == 4 ? ' ,bandera_comite=1' : '');
        
        if($actividades_x_estatus->estatus_siguiente == 8 || $actividades_x_estatus->estatus_siguiente == 6){
            $banderasStatus2 = $actividades_x_estatus->estatus_siguiente == 6 ? ' ,bandera_admin=1 ' : ($actividades_x_estatus->estatus_siguiente == 8 ? ' ,bandera_comite=1' : '');
        }
        if($actividades_x_estatus->estatus_siguiente == 2 || $type == 3){
            $banderasStatus2 =  ' ,bandera_admin=NULL ';
        }
        $pertenece = 0;
        $fechaFirma = $actividades_x_estatus->estatus_siguiente == 36  || $actividades_x_estatus->estatus_siguiente == 34 ? ",fecha_firma=NULL " : "";
        
        $num_movimiento = $type == 3 ? 1 : 0;
        if($actividades_x_estatus->estatus_siguiente == 12 ){
            $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=0  WHERE idSolicitud = $id_solicitud AND tipo_documento IN(1,2,3,4,6,16,20,21,22,23)");
        }
        if($actividades_x_estatus->estatus_siguiente == 13 || $actividades_x_estatus->estatus_siguiente == 18){
            $doc20 = $notaria == 0 ? 0 : 20;
            $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=1  WHERE idSolicitud = $id_solicitud AND tipo_documento IN(1,2,3,4,6,16,21,23,$doc20)");
        }
        if($actividades_x_estatus->estatus_siguiente == 20  || $actividades_x_estatus->estatus_siguiente == 25){
            $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=1  WHERE idSolicitud = $id_solicitud AND tipo_documento in(5,8,9,10) AND expediente IS NOT NULL");
        } if($actividades_x_estatus->estatus_siguiente == 19  || $actividades_x_estatus->estatus_siguiente == 22 || $actividades_x_estatus->estatus_siguiente == 24){
            $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=0  WHERE idSolicitud = $id_solicitud AND tipo_documento in(5,8,9,10,22)");
        }
        if($actividades_x_estatus->estatus_siguiente == 23){
            $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=1  WHERE idSolicitud = $id_solicitud AND tipo_documento in(22)");
        }

        $this->db->query("UPDATE solicitudes_escrituracion SET id_estatus =".$actividades_x_estatus->estatus_siguiente." $banderasStatus2 $banderasStatusRechazo $fechaFirma  WHERE id_solicitud = $id_solicitud");
        return $this->db->query("INSERT INTO historial_escrituracion (id_solicitud, numero_estatus,tipo_movimiento, descripcion, fecha_creacion, creado_por, fecha_modificacion, modificado_por, estatus_siguiente)
        VALUES($id_solicitud,".$actividades_x_estatus->estatus_actual.",$num_movimiento,'".$comentarios."',GETDATE(),$idUsuario,GETDATE(),$idUsuario,".$actividades_x_estatus->estatus_siguiente.");");
    }

    function generateFilename($idSolicitud, $tipoDoc)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC_', REPLACE(oxc.descripcion, ' ', '_'), SUBSTRING(de.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName, de.idDocumento, de.expediente, de.estatus_validacion 
		FROM solicitudes_escrituracion se 
		INNER JOIN lotes l ON se.id_lote =l.idLote
		INNER JOIN clientes c ON c.idLote = l.idLote AND c.id_cliente = se.id_cliente
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud = se.id_solicitud AND de.tipo_documento = $tipoDoc
		INNER JOIN documentacion_escrituracion oxc ON oxc.id_documento = $tipoDoc 
		WHERE se.id_solicitud = $idSolicitud");
    }

    function generateFilename2($idDoc)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC_', REPLACE(oxc.descripcion, ' ', '_'), SUBSTRING(de.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName, de.idDocumento, de.expediente, de.tipo_documento 
		FROM solicitudes_escrituracion se 
		INNER JOIN lotes l ON se.id_lote =l.idLote
		INNER JOIN clientes c ON c.idLote = l.idLote AND c.id_cliente = se.id_cliente
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud = se.id_solicitud 
		LEFT JOIN documentacion_escrituracion oxc ON de.tipo_documento=oxc.id_documento
		WHERE de.idDocumento = $idDoc");
    }

    function updateDocumentBranch($documentName, $idSolicitud, $idUsuario, $documentType)
    {
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
        if($documentType == 12){
            return $this->db->query("SELECT * FROM Presupuestos WHERE idPresupuesto = $idDocumento");
        }else{
            return $this->db->query("SELECT * FROM documentos_escrituracion WHERE idDocumento = $idDocumento");
        }
    }

    function replaceDocument($updateDocumentData, $idDocumento, $documentType = null)
    {
        if($documentType == 12){
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
        $notariaExterna = $this->db->query("SELECT id_notaria,personalidad_juridica FROM solicitudes_escrituracion WHERE id_solicitud=$idSolicitud");
        return $notariaExterna->row();
    }

    function getDocumentsClient($idSolicitud, $status, $notariaExterna)
    {
        $docNotariaExterna = $notariaExterna->id_notaria == 0 ? '' : ',20';
        $docPersonalidadJuridica = $notariaExterna->personalidad_juridica == 2 ? ',2,10' : ($notariaExterna->personalidad_juridica == 1 ? ',16,21' : '' );

        if($status == 9){
            $tipo_doc = "IN (11,13 $docNotariaExterna)";
        }elseif($status == 18){
            $tipo_doc = 'IN (7)';
        }elseif($status == 19 ||$status == 22 || $status == 24 || $status == 20 || $status == 25 || $status == 34){
            $tipo_doc = "IN (1,3,4,5,6,7,8,9,11,17,18,23,24,25,26$docPersonalidadJuridica $docNotariaExterna)";
        }elseif($status == 3 || $status == 4 || $status == 6 || $status == 8 || $status == 10 ){
            $tipo_doc = 'IN (17,18)';
        }elseif($status == 29 || $status == 35 || $status == 40){
            $tipo_doc = 'IN (15)';
        }elseif($status == 47 || $status == 50){
            $tipo_doc = 'IN (14)';
        }elseif($status == 42 || $status == 52){
            $tipo_doc = 'IN (19)';
        }elseif($status == 48 || $status == 51 || $status == 53){
            $tipo_doc = 'IN (14,19)';
        }elseif($status == 26 || $status == 27 || $status == 28 || $status == 30 || $status == 31){
            $tipo_doc = 'IN (22)';
        }elseif($status == 12 || $status == 59){
            $tipo_doc = 'IN (11,17,18)';
        }

        $query = $this->db->query("SELECT de.idDocumento,
        de.documento_a_validar, 
        de.movimiento, 
        de.expediente, 
        de.modificado, 
        de.status , 
        de.idSolicitud,
        de.idUsuario,
        de.tipo_documento,
    de.modificado as documento_modificado_por, 
    CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as documento_creado_por, 
    de.fecha_creacion as creacion_documento ,
    de.estatus_validacion as estatusValidacion,
    opc.id_documento , 
    de.estatus_validacion as validacion,
    opc.descripcion  , 
    opc.fecha_creacion, 
    se.id_solicitud ,
    se.id_estatus as estatus_solicitud,
    se.estatus_construccion,
    (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) as estatus_validacion,
    (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) as colour,
    (CASE WHEN CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END) validado_por,
    de.estatus_validacion ev,
    (CASE WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '') ELSE 'SIN  MOTIVOS DE RECHAZO' END) motivos_rechazo,
    0 estatusPresupuesto,
    de.editado

    FROM documentos_escrituracion de
    INNER JOIN documentacion_escrituracion opc ON de.tipo_documento=opc.id_documento
    INNER JOIN solicitudes_escrituracion se ON de.idSolicitud=se.id_solicitud
    INNER JOIN usuarios u ON u.id_usuario=de.idUsuario
    LEFT JOIN usuarios userV ON userV.id_usuario=de.validado_por
    LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento=de.idDocumento AND mrxd.estatus=1
    LEFT JOIN motivos_rechazo mr ON mr.id_motivo=mrxd.id_motivo
     WHERE opc.id_documento $tipo_doc 
    AND de.idSolicitud = $idSolicitud

    GROUP BY de.idDocumento,de.documento_a_validar,se.estatus_construccion, de.movimiento,de.modificado,de.status ,opc.id_documento ,de.idUsuario,opc.fecha_creacion,se.id_solicitud ,opc.descripcion, de.expediente, de.tipo_documento, de.idSolicitud,
    CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), de.fecha_creacion, se.id_estatus,
    (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
    (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
    (CASE WHEN CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END),
    de.estatus_validacion, de.editado

    UNION ALL
    SELECT pr.idPresupuesto idDocumento,
    0 documento_a_validar,
    pr.expediente as movimiento,
    CONCAT('Presupuesto ', oxc.nombre, ' - ', nota.nombre_notaria) expediente, 
    de.modificado,
    de.status , 
    pr.idSolicitud,  
    de.idUsuario,
    12 tipo_documento,
    de.modificado as documento_modificado_por,
    CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as documento_creado_por, 
    de.fecha_creacion as creacion_documento, 
        de.estatus_validacion as estatusValidacion,
           opc.id_documento , 
        de.estatus_validacion as validacion,
        oxc.nombre  , 
        opc.fecha_creacion, 
        se.id_solicitud ,
        se.id_estatus as estatus_solicitud,
        se.estatus_construccion,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) estatus_validacion,
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) colour,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END) validado_por,
        de.estatus_validacion ev,
        (CASE WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '') ELSE 'SIN  MOTIVOS DE RECHAZO' END) as motivos_rechazo, 
        pr.estatus estatusPresupuesto,
        null editado

        from Presupuestos pr
        INNER JOIN usuarios u ON u.id_usuario = pr.creado_por
        INNER JOIN solicitudes_escrituracion se ON se.id_solicitud = pr.idSolicitud
        INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.id_solicitud AND de.tipo_documento = 12  
        LEFT JOIN usuarios us2 ON us2.id_usuario = de.validado_por
        LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = de.idDocumento AND mrxd.estatus = 1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
        INNER JOIN documentacion_escrituracion opc ON de.tipo_documento=opc.id_documento
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.tipo AND oxc.id_catalogo = 69
        INNER JOIN notarias_x_usuario nxu ON nxu.idNotariaxSolicitud = pr.idNotariaxSolicitud
        INNER JOIN Notarias nota ON nota.idNotaria = nxu.id_notaria
        WHERE pr.idSolicitud = $idSolicitud AND pr.expediente != ''
         GROUP BY pr.idPresupuesto ,de.modificado,se.estatus_construccion,de.fecha_creacion, pr.expediente,opc.id_documento,se.id_estatus,se.id_solicitud,opc.fecha_creacion,oxc.nombre,pr.expediente, pr.idSolicitud, opc.descripcion,de.status, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),de.idUsuario, pr.fecha_creacion,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END),
        de.estatus_validacion, pr.estatus,nota.nombre_notaria");
        return $query->result();
    }

    function getDocumentsClient2($idSolicitud, $status, $notariaExterna)
    {
        $docNotariaExterna = $notariaExterna->id_notaria == 0 ? '' : ',20';
        $docPersonalidadJuridica = $notariaExterna->personalidad_juridica == 2 ? ',2,10' : ($notariaExterna->personalidad_juridica == 1 ? ',16,21' : '' );

        if($status == 25 || $status == 20)
            $tipo_doc = "IN (1,3,4,5,6,7,8,9,11,17,18,23,24,25,26$docPersonalidadJuridica $docNotariaExterna)"; // DEJAR LÍNEA 

        $query = $this->db->query("SELECT de.idDocumento, de.documento_a_validar, de.movimiento, de.expediente, de.modificado, de.status , de.idSolicitud, de.idUsuario, de.tipo_documento, 
        de.modificado as documento_modificado_por, 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as documento_creado_por, 
        de.fecha_creacion as creacion_documento , 
        de.estatus_validacion as estatusValidacion, 
        opc.id_documento , 
        de.estatus_validacion as validacion, 
        opc.descripcion , 
        opc.fecha_creacion, 
        se.id_solicitud , 
        se.id_estatus as estatus_solicitud, 
        se.estatus_construccion, 
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) as estatus_validacion, 
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) as colour, 
        (CASE WHEN CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) = '' THEN 'Sin especificar' 
        ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END) validado_por, de.estatus_validacion ev, 
        (CASE WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '') ELSE 'SIN MOTIVOS DE RECHAZO' END) motivos_rechazo, 0 estatusPresupuesto, de.editado 
        FROM documentos_escrituracion de 
        INNER JOIN documentacion_escrituracion opc ON de.tipo_documento=opc.id_documento 
        INNER JOIN solicitudes_escrituracion se ON de.idSolicitud=se.id_solicitud 
        INNER JOIN usuarios u ON u.id_usuario=de.idUsuario 
        LEFT JOIN usuarios userV ON userV.id_usuario=de.validado_por 
        LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento=de.idDocumento AND mrxd.estatus=1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo=mrxd.id_motivo 
        WHERE opc.id_documento $tipo_doc 
        AND de.idSolicitud = $idSolicitud
        AND (de.estatus_validacion IS NULL OR de.estatus_validacion = 1)
        AND de.documento_obligatorio = 1

        GROUP BY de.idDocumento,de.documento_a_validar,se.estatus_construccion, de.movimiento,de.modificado,de.status ,opc.id_documento ,de.idUsuario,opc.fecha_creacion,se.id_solicitud ,
        opc.descripcion, de.expediente, de.tipo_documento, de.idSolicitud, 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), de.fecha_creacion, se.id_estatus, 
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END), 
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) , 
        (CASE WHEN CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) = '' THEN 'Sin especificar' 
        ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END), de.estatus_validacion, de.editado");
        return $query->result();
    }

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
        LEFT JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.id_lote
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
        LEFT JOIN Notarias n ON n.idNotaria=se.id_notaria
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus_pago AND oxc.id_catalogo = 63
		LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.estatus_construccion AND oxc2.id_catalogo = 62
        LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = se.tipo_escritura AND oxc3.id_catalogo = 70
        WHERE se.id_solicitud = $idSolicitud");
    }
    function getCopropietarios($idSolicitud){
        return $this->db->query("SELECT * FROM copropietariosEscritura WHERE id_solicitud=$idSolicitud AND estatus=1")->result_array();
    }
    function borrarCopropietario($idCopropietario){
        $modificado_por = $this->session->userdata('id_usuario');
        return $this->db->query("UPDATE copropietariosEscritura SET estatus=0,modificado_por=$modificado_por WHERE idCopropietario=$idCopropietario");
    }
    function savePresupuesto($nombreT, $fechaCA, $cliente, $superficie, $catastral, $rfcDatos, $construccion,
                             $nombrePresupuesto2, $id_solicitud, $estatusPago)
    {
        return $this->db->query("UPDATE solicitudes_escrituracion SET nombre_a_escriturar='$nombrePresupuesto2', estatus_pago=$estatusPago,
        superficie=$superficie, clave_catastral=$catastral, estatus_construccion=$construccion, cliente_anterior=$cliente,
        nombre_anterior='$nombreT', fecha_anterior=$fechaCA, RFC='$rfcDatos' WHERE id_solicitud=$id_solicitud");
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
        return $this->db->query("SELECT se.*, hl.modificado, l.nombreLote,oxc4.nombre as tipoContrato,
        cond.nombre nombreCond, r.nombreResidencial, n.correo correoN, v.correo correoV, oxc2.nombre nombreConst, oxc.nombre nombrePago, oxc3.nombre tipoEscritura, n.nombre_notaria, 
        n.nombre_notario, n.direccion, n.correo, n.telefono, n.pertenece,CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, se.observaciones
                FROM solicitudes_escrituracion se 
                INNER JOIN clientes c ON c.id_cliente = se.id_cliente
                LEFT JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.id_lote
                INNER JOIN lotes l ON l.idLote = se.id_lote
                INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
                LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
                LEFT JOIN Valuadores v ON v.idValuador = se.id_valuador
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus_pago AND oxc.id_catalogo = 63
		        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.estatus_construccion AND oxc2.id_catalogo = 62
                LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = se.tipo_escritura AND oxc3.id_catalogo = 70
                LEFT JOIN opcs_x_cats oxc4 ON oxc4.id_opcion = se.tipo_contrato_ant AND oxc4.id_catalogo = 93
                WHERE se.id_solicitud =$idSolicitud");
    }

    function saveDate($signDate, $idSolicitud)
    {
        $newDate = date("d-m-Y H:i:s", strtotime($signDate));
        $id_usuario = $this->session->userdata('id_usuario');
        return $this->db->query("UPDATE solicitudes_escrituracion SET fecha_firma = '$signDate' WHERE id_solicitud = $idSolicitud");
    }

    function getFileNameByDoctype($idSolicitud, $docType)
    {
        return $this->db->query("SELECT * FROM documentos_escrituracion WHERE idSolicitud = $idSolicitud AND tipo_documento = $docType");

    }
    
    function asignarNotariaExterna($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono, $id_solicitud){
        $id_usuario = $this->session->userdata('id_usuario');
        $response = $this->db->query("INSERT INTO notarias (nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece, estatus) VALUES('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', 0, 2, 1)");
        $insert_id = $this->db->insert_id();
        $response = $this->db->query("UPDATE solicitudes_escrituracion SET bandera_notaria = 1, id_notaria = $insert_id WHERE id_solicitud = $id_solicitud");
        $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=1 WHERE idSolicitud = $id_solicitud AND tipo_documento=20;");
        $response = $this->db->query("INSERT INTO historial_escrituracion VALUES($id_solicitud,12,0,'SE ASIGNÓ NOTARÍA EXTERNA',GETDATE(),$id_usuario,GETDATE(),$id_usuario,0)");
        
        return $response;
    }

    function asignarNotariaInterna($id_solicitud){
        $id_usuario = $this->session->userdata('id_usuario');
        $response = $this->db->query("UPDATE solicitudes_escrituracion SET bandera_notaria = 1, id_notaria = 0 WHERE id_solicitud = $id_solicitud");
        $response = $this->db->query("INSERT INTO historial_escrituracion VALUES($id_solicitud,12,0,'SE ASIGNÓ NOTARÍA INTERNA',GETDATE(),$id_usuario,GETDATE(),$id_usuario,0)");
        
        return $response;
    }

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

    function getNotariaClient($idSolicitud)
    {
        $idSolicitud = $_GET['idSolicitud'];
        return $this->db->query("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, n.direccion, n.correo, n.telefono FROM Notarias n INNER JOIN solicitudes_escrituracion se ON se.id_notaria = n.idNotaria WHERE se.id_solicitud = '$idSolicitud'");
        
    }

    function rechazarNotaria(){
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');
        $idUsuario = $this->session->userdata('id_usuario');
        $this->db->query("UPDATE solicitudes_escrituracion SET id_notaria = 0, id_estatus = 10 WHERE id_solicitud = $idSolicitud;");
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

    function getData_contraloria($begin, $end)
    {   
        $WhereFechas = "";
        if($begin != 0){
            $WhereFechas = " AND se.fecha_creacion >= '$begin' AND se.fecha_creacion <= '$end' ";
          }
        return $this->db->query("SELECT se.id_solicitud,se.nombre_a_escriturar,l.referencia, l.nombreLote, cond.nombre nombreCondominio, r.nombreResidencial, c.nombre, av.nombre as estatus,
		se.fecha_creacion, CASE WHEN (se.id_titulacion IS null) THEN ar.nombre ELSE CONCAT(uj.nombre, ' ', uj.apellido_paterno, ' ', uj.apellido_materno) END as asignado,
		(CASE WHEN se.id_estatus IN (4,2,3) AND (se.bandera_admin IS NULL OR se.bandera_comite IS NULL) THEN 'Administración / Comité técnico' ELSE ar.nombre END) area, 
		se.id_solicitud as idEscrituracion, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) cliente,
		concat((select[dbo].[DiasLaborales]( (dateadd(day,1,his.fecha_ultima)) ,GETDATE())), ' día(s) de ',av.dias_vencimiento) tiempo,
		av.dias_vencimiento,(select[dbo].[DiasLaborales]( (dateadd(day,1,his.fecha_ultima)) ,GETDATE())) dias,FORMAT(fecha_ultima,'dd-MM-yyyy hh:mm:ss') as fecha_ultima,his.descripcion
        FROM solicitudes_escrituracion se
		LEFT JOIN (SELECT MAX(fecha_modificacion) fecha_ultima,id_solicitud,estatus_siguiente,descripcion FROM historial_escrituracion GROUP BY id_solicitud,estatus_siguiente,descripcion) his ON his.id_solicitud=se.id_solicitud AND his.estatus_siguiente=se.id_estatus
        LEFT JOIN lotes l ON se.id_lote = l.idLote 
        LEFT JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        LEFT JOIN residenciales r ON r.idResidencial = cond.idResidencial 
        LEFT JOIN clientes c ON c.id_cliente = se.id_cliente AND c.status = 1
        LEFT JOIN control_permisos cp ON cp.estatus_actual = se.id_estatus AND cp.bandera_vista in (1)
        LEFT JOIN actividades_escrituracion av ON av.clave = cp.clave_actividad
        LEFT JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1
        LEFT JOIN usuarios uj ON uj.id_usuario = se.id_titulacion
        $WhereFechas
        GROUP BY se.id_solicitud,se.nombre_a_escriturar,l.referencia,his.descripcion,his.fecha_ultima,se.id_estatus,se.bandera_admin,se.bandera_comite, l.nombreLote, cond.nombre, r.nombreResidencial, c.nombre,c.apellido_paterno,c.apellido_materno, av.nombre, av.dias_vencimiento, se.fecha_creacion, se.id_titulacion, uj.nombre, uj.apellido_paterno, uj.apellido_materno, ar.nombre, se.id_solicitud
        ORDER BY se.fecha_creacion ASC");
    }

    function getEstatusEscrituracion()
    {
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 59 AND id_opcion NOT IN (25,90);");
        return $query->result_array();
    }

    function getFullReportContraloria($idSolicitud){
        $query = $this->db->query("SELECT MAX(he.fecha_creacion) fecha_creacion, 
        he.id_historial, 
        se.fecha_creacion, he.descripcion, he.tipo_movimiento,
        (CASE WHEN he.tipo_movimiento = 1 THEN (SELECT  motivo FROM motivos_rechazo WHERE id_motivo = he.descripcion AND he.tipo_movimiento = 1 AND he.descripcion NOT LIKE '%Nueva fecha para firma%') ELSE he.descripcion END) as comentarios,
        he.numero_estatus idStatus, he.id_solicitud as idEscrituracion,
        isNULL(lag(MAX(he.fecha_creacion)) OVER (ORDER BY he.id_historial), he.fecha_creacion) fechados, lo.nombreLote, co.nombre_condominio, re.nombreResidencial, av.nombre, ar.nombre as area, 
        concat((select[dbo].[DiasLaborales]( (dateadd(day,1,se.fecha_creacion)) ,he.fecha_modificacion)), ' día(s) de ',av.dias_vencimiento) tiempo,
        av.dias_vencimiento,(select[dbo].[DiasLaborales]( (dateadd(day,1,se.fecha_creacion)) ,he.fecha_modificacion)) dias, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as creado_por
            FROM historial_escrituracion he
            INNER JOIN solicitudes_escrituracion se ON se.id_solicitud = he.id_solicitud
            LEFT JOIN usuarios u on u.id_usuario=he.creado_por
            INNER JOIN lotes lo ON se.id_lote = lo.idLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            INNER JOIN clientes cl ON cl.id_cliente = se.id_cliente AND cl.status = 1
            INNER JOIN control_permisos cp ON cp.estatus_actual = he.numero_estatus AND cp.bandera_vista = 1
            INNER JOIN actividades_escrituracion av ON av.clave = cp.clave_actividad
            INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1
            WHERE he.id_solicitud = $idSolicitud
            GROUP BY he.id_historial,he.fecha_modificacion,se.fecha_creacion,he.fecha_creacion, he.numero_estatus, 
            he.id_solicitud, he.descripcion, av.fecha_creacion, lo.nombreLote, co.nombre_condominio, 
            re.nombreResidencial, av.nombre, ar.nombre, av.dias_vencimiento,u.nombre,u.apellido_paterno,u.apellido_materno, he.tipo_movimiento");
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
        return $this->db->query("SELECT se.*, hl.modificado,se.fecha_contrato,oxc4.nombre as tipoContrato,
        cond.nombre nombreCondominio, r.nombreResidencial, l.nombreLote, oxc2.nombre nombreConst,oxc.id_opcion idEstatusPago,oxc3.nombre tipoEscritura,
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
        LEFT JOIN opcs_x_cats oxc4 ON oxc4.id_opcion = se.tipo_contrato_ant AND oxc4.id_catalogo = 93
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

    function updatePresupuestosNXU($idSolicitud, $idNotaria,$borrarNotaria = 0)
    {
        $response = $this->db->query("UPDATE Presupuestos SET idNotariaxSolicitud = (SELECT idNotariaxSolicitud FROM notarias_x_usuario WHERE id_notaria = $idNotaria AND id_solicitud = $idSolicitud) 
        WHERE idPresupuesto IN (SELECT MIN(idPresupuesto) id FROM Presupuestos WHERE idSolicitud = $idSolicitud AND idNotariaxSolicitud IS NULL
            GROUP BY tipo, idNotariaxSolicitud)");
            if($borrarNotaria == 1){
                $this->db->query("UPDATE solicitudes_escrituracion set id_notaria=0 WHERE id_solicitud=$idSolicitud");
                $this->db->query("UPDATE documentos_escrituracion set documento_a_validar=0 WHERE idSolicitud=$idSolicitud AND tipo_documento=20");
            }
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
        return $this->db->query("SELECT OPCAT.id_opcion, OPCAT.nombre, CASE WHEN CAT.nombre = 'Estado civil' THEN 'ecivil'
                                                                            WHEN CAT.nombre = 'Régimen matrimonial' THEN 'rconyugal' 
                                                                            WHEN CAT.nombre = 'Personalidad jurídica' THEN 'perj'
                                                                            WHEN CAT.nombre = 'Instrumento monetario' THEN 'instrumento'
                                                                            WHEN CAT.nombre = 'Moneda o Divisa' THEN 'monedaDiv'
                                                                            WHEN CAT.nombre = 'Forma de pago' THEN 'formaP' 
                                                                            END AS etq
                                FROM opcs_x_cats AS OPCAT
                                INNER JOIN catalogos AS CAT
                                ON OPCAT.id_catalogo = CAT.id_catalogo
                                WHERE OPCAT.id_catalogo IN ($id_cat) AND OPCAT.estatus = 1
                                ORDER BY OPCAT.id_catalogo");
    }

    public function InsertCli($datos){
        $user = $this->session->userdata;
        $id_usuario = $user['id_usuario'] ;
        $dataCliente = array(
            'id_asesor' => 0,
            'id_coordinador' => 0,
            'id_gerente' => 0,
            'id_sede' => $user['id_sede'],
            'nombre' => $datos['nombre2'],
            'apellido_paterno' => $datos['ape1'],
            'apellido_materno' => $datos['ape2'],
            'rfc' => $datos['rfc'],
            'correo' => $datos['correo'],
            'telefono1' => ( !empty($datos['telefono']) || $datos['telefono'] == '') ? NULL : $datos['telefono'],
            'telefono2' => (!empty($datos['cel']) || $datos['cel'] == '') ? NULL : $datos['cel'],
            'estado_civil' => (!array_key_exists('ecivil', $datos) || !empty($datos['ecivil']) || $datos['ecivil'] == '') ? NULL : $datos['ecivil'],
            'regimen_matrimonial' => (!array_key_exists('rconyugal', $datos) || !empty($datos['rconyugal']) || $datos['rconyugal'] == '') ? NULL : $datos['rconyugal'],
            'domicilio_particular' => $datos['direccion'],
            'originario_de' => $datos['origen'],
            'ocupacion' => $datos['ocupacion'],
            'status' => 1,
            'idLote' => $datos['idLote'],
            'usuario' => $user['usuario'],
            'idCondominio' => $datos['idCondominio'],
            'fecha_creacion' => date('Y-m-d h:i:s'),
            'fechaApartado' => date('Y-m-d h:i:s'),
            'creado_por' => $this->session->userdata('id_usuario'),
            'fecha_modificacion' => date('Y-m-d h:i:s'),
            'banderaEscrituracion' => 1
        );
        $resultadoInsertarCliente = $this->db->insert('clientes', $dataCliente);
        $idCliente = $this->db->query("SELECT IDENT_CURRENT('clientes') idCliente")->row()->idCliente;
        $this->db->query("UPDATE lotes SET idCliente = $idCliente, usuario = $id_usuario WHERE idLote = ".$datos['idLote']." ");      
        return $idCliente;
    }


    public function SolicitudesEscrituracion($idUsu){
        if($idUsu == ''){
            $queryExtra = ' WHERE se.id_estatus not in(49) ';
        }else 
        {
            $queryExtra = "WHERE CONCAT(usuti.nombre, ' ' ,usuti.apellido_paterno ,' ',usuti.apellido_materno  )  like  "."'%$idUsu%' AND se.id_estatus not in(49) "; 
        }
        
        $cmd = ("SELECT distinct(se.id_solicitud),se.id_titulacion, FORMAT(TRY_CAST(se.valor_contrato AS float),'C') valor_contrato, se.id_estatus, CONVERT(VARCHAR,se.fecha_creacion,120) AS fecha_creacion, l.nombreLote, cond.nombre nombreCondominio,
        r.nombreResidencial, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as cliente, n.pertenece, se.bandera_notaria, se.descuento, 
        se.aportacion, ar.id_opcion as id_area, UPPER((CASE WHEN se.id_estatus IN (4,2,3) AND (se.bandera_admin IS NULL OR se.bandera_comite IS NULL) THEN 'Administración / Comité técnico' ELSE ar.nombre END)) area,
        UPPER(cp.area_actual) AS area_actual, UPPER(cr.area_sig) AS area_sig, CONCAT(cp.clave_actividad ,' - ', ae.nombre) AS nombre_estatus, cr.estatus_siguiente,
        cr.nombre_estatus_siguiente, cr.tipo_permiso, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar,
        se.cliente_anterior, (CASE when cp.tipo_permiso = 3 THEN 'RECHAZO' ELSE '' END ) rechazo, concat((select[dbo].[DiasLaborales]( (dateadd(day,1,se.fecha_modificacion)) ,GETDATE())), ' día(s) de ',ae.dias_vencimiento) vencimiento,
        se.id_notaria, se.fecha_firma, a.descripcion actividad,
        CONCAT(usuti.nombre, ' ', usuti.apellido_paterno, ' ', usuti.apellido_materno) nombre
                FROM solicitudes_escrituracion se 
                INNER JOIN lotes l ON se.id_lote = l.idLote 
                INNER JOIN clientes c ON c.id_cliente = l.idCliente 
                INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
                INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
                INNER JOIN control_permisos cp ON se.id_estatus = cp.estatus_actual AND cp.bandera_vista in (1)
                INNER JOIN control_permisos cs ON se.id_estatus = cs.estatus_actual and cs.clasificacion in (1,2)
                INNER JOIN usuarios usuti ON usuti.id_usuario=se.id_titulacion
                INNER JOIN actividades_escrituracion ae ON ae.clave = cp.clave_actividad 
                INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1
        
                LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
                
                LEFT JOIN (SELECT a.id_solicitud, a.fecha_creacion, (CASE WHEN a.tipo_movimiento = 1 THEN CONCAT(MAX(mr.motivo),' ',us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno,' - ',rol.nombre) ELSE CONCAT(MAX(a.descripcion),' ',us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' - ', rol.nombre) END) AS descripcion 
                FROM historial_escrituracion a
                INNER JOIN (SELECT id_solicitud, MAX(fecha_creacion) fecha_max FROM historial_escrituracion GROUP BY id_solicitud) b ON a.id_solicitud = b.id_solicitud AND a.fecha_creacion = b.fecha_max
                INNER JOIN usuarios us ON us.id_usuario = a.creado_por 
                INNER JOIN opcs_x_cats rol ON rol.id_opcion = us.id_rol AND rol.id_catalogo = 1 
                LEFT JOIN motivos_rechazo mr ON mr.id_motivo = TRY_CAST(a.descripcion AS INT) 
                GROUP BY a.id_solicitud, a.fecha_creacion, a.descripcion, mr.motivo, a.tipo_movimiento, rol.nombre, us.nombre, us.apellido_paterno, us.apellido_materno) a ON a.id_solicitud=se.id_solicitud
        
        
                LEFT JOIN (SELECT DISTINCT(cl.clave_actividad), cl.estatus_actual as estatus_siguiente, cl.clasificacion, cl.tipo_permiso, ar2.nombre as area_sig, CONCAT(av.clave,' - ', av.nombre, '-', ar2.nombre) as nombre_estatus_siguiente FROM control_permisos cl INNER JOIN actividades_escrituracion av ON cl.clave_actividad LIKE av.clave INNER JOIN opcs_x_cats ar2 ON ar2.id_opcion = cl.area_actual AND ar2.id_catalogo = 1 WHERE cl.clasificacion in (1,2)
                GROUP BY cl.estatus_actual, cl.clave_actividad, cl.clasificacion, cl.estatus_actual, cl.tipo_permiso, av.nombre, av.clave, ar2.nombre) cr ON cr.estatus_siguiente = cs.estatus_siguiente
                $queryExtra
                GROUP BY se.id_solicitud,se.id_titulacion, cp.estatus_actual, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre, r.nombreResidencial, c.nombre,c.apellido_paterno,c.apellido_materno, n.pertenece, se.bandera_notaria, se.descuento, 
                se.aportacion, ae.id_actividad, ae.clave, cp.tipo_permiso, cp.clave_actividad, cp.clave_actividad, ae.nombre, ar.id_opcion, cp.estatus_siguiente, ar.nombre,
                cp.nombre_actividad, cp.estatus_siguiente, cp.estatus_siguiente, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso,
                se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, cp.area_actual, se.cliente_anterior, cr.area_sig, ae.nombre, ae.dias_vencimiento,
                se.fecha_modificacion, a.descripcion,se.id_notaria,se.fecha_firma,usuti.nombre,usuti.apellido_paterno, usuti.apellido_materno,
                se.valor_contrato ORDER BY se.id_solicitud DESC");
        
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
    
    function insertDocumentNuevo($insertDocumentNuevo)
    {
        $this->db->insert('documentos_escrituracion', $insertDocumentNuevo);
        $afftectedRows = $this->db->affected_rows();
        
        return $afftectedRows > 0 ? $this->db->insert_id() : FALSE ;
    }

    function getMotivosRechazos($tipoDocumento)
    {
        $cadena = $tipoDocumento == 0 ? 0 : $tipoDocumento.',0';
        $query = $this->db->query("SELECT * FROM motivos_rechazo WHERE tipo_proceso IN (2,3) AND tipo_documento IN ($cadena)");
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

    function insertNewNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono){
        $idUsuario = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO Notarias(nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece)
                         VALUES('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', 0, 2);");
        $insert_id = $this->db->insert_id();
        $idSolicitud = $_POST['idSolicitud'];
        $rol = $this->session->userdata('id_rol');
        $estatus = $this->db->query("SELECT id_estatus FROM solicitudes_escrituracion WHERE id_solicitud = $idSolicitud")->row()->id_estatus;
        $estatus_siguiente = $estatus == 19 || $estatus == 22 ? 20 : 25;
        $this->db->query("UPDATE documentos_escrituracion SET documento_a_validar=1 WHERE idSolicitud = $idSolicitud AND tipo_documento=20;");
        $this->db->query("UPDATE solicitudes_escrituracion SET id_notaria= $insert_id WHERE id_solicitud = $idSolicitud;");
        return $this->db->query("INSERT INTO historial_escrituracion (id_solicitud, numero_estatus,tipo_movimiento, descripcion, fecha_creacion, creado_por, fecha_modificacion, modificado_por, estatus_siguiente)
                                VALUES($idSolicitud,".$estatus.",0,'Cambio de Notaria',GETDATE(),$idUsuario,GETDATE(),$idUsuario,$estatus_siguiente);");
    }

    
    function getDocumentosPorSolicituds($solicitud, $opciones )
    {
        $cmd="SELECT de.idDocumento, de.movimiento, de.expediente, de.modificado, 
        de.status , de.idSolicitud ,de.idUsuario 
        ,de.tipo_documento,
        CONCAT(usu.apellido_paterno,' ', usu.apellido_materno  ,' ', usu.nombre) AS cargadoX,
        does.descripcion as nombre, 
        does.id_documento as id_opcion,
        de.modificado as documento_modificado_por ,
        de.creado_por as documento_creado_por , 
        de.fecha_creacion as creacion_documento , 
        de.estatus_validacion as estatusValidacion , 
        se.id_estatus as estatus_solicitud , 
        de.estatus_validacion as validacion
        , se.id_solicitud, se.estatus_construccion 
        FROM documentos_escrituracion de  
		INNER JOIN documentacion_escrituracion does on de.tipo_documento = does.id_documento AND does.id_documento $opciones 
		INNER JOIN solicitudes_escrituracion se  on de.idSolicitud = se.id_solicitud 
		LEFT JOIN usuarios usu on usu.id_usuario  = de.creado_por
		where de.expediente is not null AND de.idSolicitud = $solicitud";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }
    
    function documentosNecesarios( $estatus){
        $cmd=("SELECT * FROM documentacion_escrituracion WHERE id_documento   $estatus");
        $query = $this->db->query($cmd);
        return $query->result_array();
    }   
    
    function insertMotivoPorDoc($insertDocumentNuevo)
    {
        $this->db->insert('motivos_rechazo_x_documento', $insertDocumentNuevo);
        $afftectedRows = $this->db->affected_rows();
        
        return $afftectedRows > 0 ? $this->db->insert_id() : FALSE ;
    }

    public function actualizarMotivosRechazo($clave , $clave2, $data){
        try {
            $this->db->where('tipo', $clave);
            $this->db->where('id_documento', $clave2);
            $this->db->update('motivos_rechazo_x_documento', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    function  validarExisteDocumento ($tipoDocuemento, $solicitud)
    {
        $cmd=("SELECT * FROM documentos_escrituracion where idSolicitud = $solicitud and tipo_documento = $tipoDocuemento ");
        $query = $this->db->query($cmd);
        $resultados = $query->num_rows() ;
        return  $resultados > 0 ? FALSE : TRUE;
    }

    function  validarExisteDocumentos ($tipoDocuemento, $solicitud)
    {
        $cmd=("SELECT * FROM documentos_escrituracion where idSolicitud = $solicitud and tipo_documento = $tipoDocuemento ");
        $query = $this->db->query($cmd);
        return $query->row();
    }


    function  traerEstatus ($solicitud)
    {
        $cmd=("SELECT * FROM solicitudes_escrituracion where id_solicitud =  $solicitud ");
        $query = $this->db->query($cmd);
        return $query->row();
    }


    function existeNegado($solicitud){
        $cmd=("SELECT * FROM documentos_escrituracion  where tipo_documento in (1,2,3,4,5,6,8,9,10,11,12,17,18 ) AND idSolicitud = $solicitud AND 
        (estatus_validacion IS NULL OR estatus_validacion = 2)");
        $query = $this->db->query($cmd);
        $resultados = $query->num_rows() ;
        return  $resultados > 0 ? FALSE : TRUE;
    }

    function rechazosDeDocs($solicitud){
        $cmd = ("Select de.tipo_documento,mr.motivo, mrx.id_motivo  from documentos_escrituracion de
        INNER JOIN motivos_rechazo_x_documento mrx on mrx.id_documento = de.idDocumento AND  mrx.estatus =1
        INNER JOIN motivos_rechazo mr on mr.id_motivo = mrx.id_motivo
        where idSolicitud = $solicitud");
        $query      = $this->db->query($cmd);
        $resultados = $query->result_array();
        return $resultados;
    }

    public function getStatus3VP() {
        return $this->db->query("SELECT lo.idLote, hd.idDocumento, hd.tipo_doc, hd.expediente, hd.movimiento, lo.referencia, cl.id_cliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        lo.nombreLote, lo.idStatusContratacion, lo.idMovimiento, lo.modificado, cl.rfc,
        CAST(lo.comentario AS varchar(MAX)) comentario, lo.fechaVenc, lo.perfil, co.nombre nombreCondominio, re.nombreResidencial, lo.ubicacion, ISNULL(se.nombre, 'SIN ESPECIFICAR') nombreSede,
        lo.tipo_venta, lo.observacionContratoUrgente as vl,	co.idCondominio, lo.tipo_venta,
            CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
            CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
            CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente
            FROM lotes lo
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            LEFT JOIN historial_documento hd ON lo.idLote = hd.idLote AND hd.tipo_doc = 50
            LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
            LEFT JOIN sedes se ON se.id_sede = cl.id_sede
            WHERE lo.idStatusContratacion IN (2, 3) AND lo.idMovimiento IN (98, 100, 102, 105, 107, 110, 113, 114) AND lo.tipo_venta = 1
            ORDER BY lo.nombreLote ")->result_array();
    }

    public function validateSt3($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (2, 3) AND idMovimiento IN (98, 99, 100, 102, 105, 107, 110, 113, 114))");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }
    
    function pausarSolicitud($idSolicitud,$comentario,$idUsuario){
        $this->db->query("UPDATE solicitudes_escrituracion SET id_estatus=54 WHERE id_solicitud=$idSolicitud");
        return $this->db->query("INSERT INTO historial_escrituracion (id_solicitud, numero_estatus,tipo_movimiento, descripcion, fecha_creacion, creado_por, fecha_modificacion, modificado_por, estatus_siguiente)
                                VALUES($idSolicitud,19,0,'".$comentario."',GETDATE(),$idUsuario,GETDATE(),$idUsuario,20)");
    }
    
    function getRejectReasonsTwo($idDocumento, $idSolicitud, $documentType)
    {
        return $this->db->query("SELECT mrxd.id_mrxdoc, mr.motivo, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) userValidacion 
            FROM solicitudes_escrituracion se      
            INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.id_solicitud
            INNER JOIN usuarios u ON u.id_usuario = de.validado_por
            INNER JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = $idDocumento AND mrxd.estatus = 1 AND mrxd.tipo = $documentType
            INNER JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
            WHERE se.id_solicitud = $idSolicitud");
    }

    function getInfoCliente($idCliente)
    {
        return $this->db->query("SELECT id_cliente,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombreCliente,fechaApartado  FROM clientes WHERE id_cliente=$idCliente");
    }

    function getTipoContratoAnt(){
        return $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 93");
    }

    function getDocumentacionCliente($idSolicitud, $notariaExterna) //MUESTRA TODOS LOS DOCUMENTOS PARA LA VISTA DOCUMENTACIÓN
    {
        $docNotariaExterna = $notariaExterna->id_notaria == 0 ? '' : ',20';
        $docPersonalidadJuridica = $notariaExterna->personalidad_juridica == 2 ? ',2,10' : ($notariaExterna->personalidad_juridica == 1 ? ',16,21' : '' );
        $tipo_doc = "IN (1,3,4,5,6,7,8,9,11,17,18,23,24,25,26$docPersonalidadJuridica $docNotariaExterna)";

        $query = $this->db->query("SELECT de.idDocumento,
        de.documento_a_validar, 
        de.movimiento, 
        de.expediente, 
        de.modificado, 
        de.status , 
        de.idSolicitud,
        de.idUsuario,
        de.tipo_documento,
        de.modificado as documento_modificado_por, 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as documento_creado_por, 
        de.fecha_creacion as creacion_documento ,
        de.estatus_validacion as estatusValidacion,
        opc.id_documento , 
        de.estatus_validacion as validacion,
        opc.descripcion  , 
        opc.fecha_creacion, 
        se.id_solicitud ,
        se.id_estatus as estatus_solicitud,
        se.estatus_construccion,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) as estatus_validacion,
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) as colour,
        (CASE WHEN CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END) validado_por,
        de.estatus_validacion ev,
        (CASE WHEN de.estatus_validacion = 2 THEN STRING_AGG (mr.motivo, '') ELSE 'SIN  MOTIVOS DE RECHAZO' END) motivos_rechazo,
        0 estatusPresupuesto,
        de.editado

        FROM documentos_escrituracion de
        INNER JOIN documentacion_escrituracion opc ON de.tipo_documento=opc.id_documento
        INNER JOIN solicitudes_escrituracion se ON de.idSolicitud=se.id_solicitud
        INNER JOIN usuarios u ON u.id_usuario=de.idUsuario
        LEFT JOIN usuarios userV ON userV.id_usuario=de.validado_por
        LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento=de.idDocumento AND mrxd.estatus=1
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo=mrxd.id_motivo
        WHERE opc.id_documento $tipo_doc 
        AND de.idSolicitud = $idSolicitud

        GROUP BY de.idDocumento,de.documento_a_validar,se.estatus_construccion, de.movimiento,de.modificado,de.status ,opc.id_documento ,de.idUsuario,opc.fecha_creacion,se.id_solicitud ,opc.descripcion, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), de.fecha_creacion, se.id_estatus,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
        (CASE WHEN CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(userV.nombre, ' ', userV.apellido_paterno, ' ', userV.apellido_materno) END),
        de.estatus_validacion, de.editado");
        
        return $query->result();
    }

    function getRechazoDocs() //MODELO PARA MOSTRAR LOS MOTIVOS DE RECHAZO
    {
        $query = $this->db->query("SELECT * FROM motivos_rechazo WHERE tipo_proceso = 2 AND estatus = 1");
        return $query->result();
    }

    function getSolicitudesDocs()
    {   
        return $this->db->query("SELECT distinct(se.id_solicitud),CONCAT(creado.nombre, ' ', creado.apellido_paterno, ' ', creado.apellido_materno) as creado,se.creado_por,se.id_cliente,se.id_lote,c.banderaEscrituracion,se.id_titulacion, se.valor_contrato, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre nombreCondominio, r.nombreResidencial, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as cliente, n.pertenece, se.bandera_notaria, se.descuento, se.aportacion, ar.id_opcion as id_area, (CASE WHEN se.id_estatus IN (4,2,3) AND (se.bandera_admin IS NULL OR se.bandera_comite IS NULL) THEN 'Administración / Comité técnico' ELSE ar.nombre END) area, cp.area_actual, dc.expediente, dc.tipo_documento, dc.idDocumento, cr.area_sig, CONCAT(cp.clave_actividad ,' - ', ae.nombre) AS nombre_estatus, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, se.cliente_anterior, (CASE when cp.tipo_permiso = 3 THEN 'RECHAZO' ELSE '' END ) rechazo, concat((select[dbo].[DiasLaborales]( (dateadd(day,1,se.fecha_modificacion)) ,GETDATE())), ' día(s) de ',ae.dias_vencimiento) vencimiento, de4.contrato,pr.banderaPresupuesto,presup2.presupuestoAprobado,se.id_notaria, se.fecha_firma, a.descripcion ultimo_comentario,CONCAT(userAsig.nombre, ' ', userAsig.apellido_paterno, ' ', userAsig.apellido_materno) asignada_a,de2.documentosCargados, 
        de2.estatusValidacion,de2.no_rechazos,doc22.documentosCargados22, doc22.estatusValidacion22,doc22.no_rechazos22,doc22.no_editados22,de5.formasPago, 
        (CASE WHEN se.id_estatus IN (5,7,10,16,21,24,30,34,36,37,40,44,50,52,58,59) THEN 'RECHAZO' ELSE 'PROCESO NORMAL' END) estatusAct
        FROM solicitudes_escrituracion se 
        INNER JOIN lotes l ON se.id_lote = l.idLote 
        INNER JOIN clientes c ON c.id_cliente = l.idCliente 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
        INNER JOIN control_permisos cp ON se.id_estatus = cp.estatus_actual AND cp.bandera_vista in (1)
        INNER JOIN control_permisos cs ON se.id_estatus = cs.estatus_actual and cs.clasificacion in (1,2)
        INNER JOIN usuarios userAsig ON userAsig.id_usuario=se.id_titulacion
        LEFT JOIN usuarios creado ON creado.id_usuario=se.creado_por
        INNER JOIN actividades_escrituracion ae ON ae.clave = cp.clave_actividad 
        INNER JOIN opcs_x_cats ar ON ar.id_opcion = cp.area_actual AND ar.id_catalogo = 1

        LEFT JOIN documentos_escrituracion dc ON dc.idSolicitud = se.id_solicitud AND dc.tipo_documento in(CASE WHEN se.id_estatus in (3,4,6,8,9,10) THEN 18 WHEN se.id_estatus in(18,21) THEN 7 WHEN se.id_estatus in(46,52) THEN 19 WHEN se.id_estatus in(47,50) THEN 14 WHEN se.id_estatus in(29,40,33,41) THEN 15 WHEN se.id_estatus in(39,44,42,45) THEN 13 ELSE 11 END) 
        LEFT JOIN Notarias n ON n.idNotaria = se.id_notaria
        
        LEFT JOIN (SELECT a.id_solicitud, a.fecha_creacion, (CASE WHEN a.tipo_movimiento = 1 THEN CONCAT(MAX(mr.motivo),' ',us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno,' - ',rol.nombre) ELSE CONCAT(MAX(a.descripcion),' ',us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' - ', rol.nombre) END) AS descripcion 
        FROM historial_escrituracion a
        INNER JOIN (SELECT id_solicitud, MAX(fecha_creacion) fecha_max FROM historial_escrituracion GROUP BY id_solicitud) b ON a.id_solicitud = b.id_solicitud AND a.fecha_creacion = b.fecha_max
        INNER JOIN usuarios us ON us.id_usuario = a.creado_por 
        INNER JOIN opcs_x_cats rol ON rol.id_opcion = us.id_rol AND rol.id_catalogo = 1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = TRY_CAST(a.descripcion AS INT) 
        GROUP BY a.id_solicitud, a.fecha_creacion, a.descripcion, mr.motivo, a.tipo_movimiento, rol.nombre, us.nombre, us.apellido_paterno, us.apellido_materno) a ON a.id_solicitud=se.id_solicitud


        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) 
            THEN 0 ELSE 1 END documentosCargados,  
            CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion = 1 THEN 1 END) THEN 0 ELSE 1 END estatusValidacion,
            COUNT(CASE WHEN estatus_validacion = 2 THEN 1 END) no_rechazos
            FROM documentos_escrituracion 
            WHERE documento_a_validar=1
            GROUP BY idSolicitud) de2 ON de2.idSolicitud = se.id_solicitud 

            LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) 
            THEN 0 ELSE 1 END documentosCargados22,  
            CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion = 1 THEN 1 END) THEN 0 ELSE 1 END estatusValidacion22,
            COUNT(CASE WHEN estatus_validacion = 2 THEN 1 END) no_rechazos22,
            COUNT(CASE WHEN editado = 1 THEN 1 END) no_editados22
            FROM documentos_escrituracion 
            WHERE tipo_documento=22
            GROUP BY idSolicitud) doc22 ON doc22.idSolicitud = se.id_solicitud 

        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END banderaPresupuesto FROM Presupuestos WHERE expediente != '' GROUP BY idSolicitud) pr ON pr.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) THEN 0 ELSE 1 END contrato
        FROM documentos_escrituracion WHERE tipo_documento = 18 GROUP BY idSolicitud) de4 ON de4.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion=1 THEN 1 END) THEN 0 ELSE 1 END formasPago
        FROM documentos_escrituracion WHERE tipo_documento = 7 GROUP BY idSolicitud) de5 ON de5.idSolicitud = se.id_solicitud
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END presupuestoAprobado FROM Presupuestos WHERE estatus = 1 GROUP BY idSolicitud) presup2 ON presup2.idSolicitud = se.id_solicitud
       
        LEFT JOIN (SELECT DISTINCT(cl.clave_actividad), cl.estatus_actual as estatus_siguiente, cl.clasificacion, cl.tipo_permiso, ar2.nombre as area_sig, CONCAT(av.clave,' - ', av.nombre, '-', ar2.nombre) as nombre_estatus_siguiente FROM control_permisos cl INNER JOIN actividades_escrituracion av ON cl.clave_actividad LIKE av.clave INNER JOIN opcs_x_cats ar2 ON ar2.id_opcion = cl.area_actual AND ar2.id_catalogo = 1 WHERE cl.clasificacion in (1,2)
        GROUP BY cl.estatus_actual, cl.clave_actividad, cl.clasificacion, cl.estatus_actual, cl.tipo_permiso, av.nombre, av.clave, ar2.nombre) cr ON cr.estatus_siguiente = cs.estatus_siguiente
        GROUP BY doc22.no_editados22,creado.nombre,creado.apellido_paterno,creado.apellido_materno,doc22.documentosCargados22,se.creado_por, doc22.estatusValidacion22,doc22.no_rechazos22,se.id_solicitud,c.banderaEscrituracion,se.id_cliente,se.id_lote,doc22.documentosCargados22, doc22.estatusValidacion22,doc22.no_rechazos22,de2.documentosCargados,presup2.presupuestoAprobado,de2.estatusValidacion,de2.no_rechazos,se.id_titulacion, cp.estatus_actual, se.id_estatus, se.fecha_creacion, l.nombreLote, cond.nombre, r.nombreResidencial, c.nombre,c.apellido_paterno,c.apellido_materno, n.pertenece, se.bandera_notaria, se.descuento, se.aportacion, ae.id_actividad, ae.clave, cp.tipo_permiso, cp.clave_actividad, cp.clave_actividad, ae.nombre, ar.id_opcion, cp.estatus_siguiente, ar.nombre, cp.nombre_actividad, cp.estatus_siguiente, cp.estatus_siguiente, cr.estatus_siguiente, cr.nombre_estatus_siguiente, cr.tipo_permiso, dc.expediente, dc.tipo_documento, dc.idDocumento, se.bandera_comite, se.bandera_admin, se.estatus_construccion, se.nombre_a_escriturar, cp.area_actual, se.cliente_anterior, cr.area_sig, ae.nombre, ae.dias_vencimiento,se.fecha_modificacion, de4.contrato, a.descripcion,pr.banderaPresupuesto,se.id_notaria,se.fecha_firma,userAsig.nombre,userAsig.apellido_paterno, userAsig.apellido_materno, se.valor_contrato,de5.formasPago ORDER BY se.id_solicitud DESC");

    }

    function getListaClientes($id_residencial, $id_condominio) {
        $validacionCondminio = $id_condominio == 0 ? "" : "AND co.idCondominio = $id_condominio";
        return $this->db->query(
            "SELECT
                re.nombreResidencial, 
                co.nombre nombreCondominio, 
                lo.nombreLote, 
                lo.idLote, 
                UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, 
                lo.idCliente,
                fechaApartado, 
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor, 
                CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
                ISNULL(tv.tipo_venta, 'SIN ESPECIFICAR') tipoVenta, 
                ISNULL(se.nombre, 'SIN ESPECIFICAR') ubicacion,
                ISNULL(oxc1.nombre, 'SIN ESPECIFICAR') tipoTramite,
                oxc0.nombre estatusProceso,
                lo.estatusCambioNombre,
                ISNULL(cxl.id_registro, 0) id_registro,
                cxl.nombre nombreCteNuevo,
                cxl.apellido_paterno apCteNuevo,
                cxl.apellido_materno amCteNuevo,
                cxl.tipoTramite idTipoTramite, 
                lo.comentario,
                lo.totalNeto2 as precioFinalLote
            FROM 
                lotes lo 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio $validacionCondminio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $id_residencial
                LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 
                LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor 
                LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
                LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
                LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
                LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
                LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
                LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta 
                LEFT JOIN sedes se ON se.id_sede = lo.ubicacion 
                LEFT JOIN clientes_x_lote cxl ON cxl.idLote = lo.idLote AND cxl.estatus = 1
                INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = lo.estatusCambioNombre AND oxc0.id_catalogo = 123
                LEFT JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = cxl.tipoTramite  AND oxc1.id_catalogo = 122
            WHERE 
                lo.status = 1 
                AND lo.idStatusLote IN (2, 3)
            ORDER BY
                lo.nombreLote"
        )->result();
    }

    function getListaClientesRevision() {
        return $this->db->query(
            "SELECT
                re.nombreResidencial, 
                co.nombre nombreCondominio, 
                lo.nombreLote, 
                lo.idLote, 
                co.idResidencial as idProyecto,
                UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, 
                UPPER(CONCAT(cxl.nombre, ' ', cxl.apellido_paterno, ' ', cxl.apellido_materno)) nombreClienteNuevo, 
                lo.idCliente,
                CONVERT(varchar, cl.fechaApartado, 120) fechaApartado, 
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor, 
                CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
                ISNULL(tv.tipo_venta, 'SIN ESPECIFICAR') tipoVenta, 
                ISNULL(se.nombre, 'SIN ESPECIFICAR') ubicacion,
                ISNULL(oxc1.nombre, 'SIN ESPECIFICAR') tipoTramite,
                oxc0.nombre estatusProceso,
                lo.estatusCambioNombre,
                ISNULL(cxl.id_registro, 0) id_registro,
                cxl.nombre nombreCteNuevo,
                cxl.apellido_paterno apCteNuevo,
                cxl.apellido_materno amCteNuevo,
                cxl.tipoTramite idTipoTramite,
                CONVERT(varchar, lo.fecha_modst, 120) fechaUltimoEstatus,
                lo.comentario, lo.totalNeto2 as precioFinal, cxl.escrituraNotariada, lo.idCondominio
            FROM 
                lotes lo 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 
                LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor 
                LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
                LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
                LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
                LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
                LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
                LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta 
                LEFT JOIN sedes se ON se.id_sede = lo.ubicacion 
                INNER JOIN clientes_x_lote cxl ON cxl.idLote = lo.idLote AND cxl.estatus = 1
                INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = lo.estatusCambioNombre AND oxc0.id_catalogo = 123
                INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = cxl.tipoTramite  AND oxc1.id_catalogo = 122
            WHERE 
                lo.status = 1 
                AND lo.idStatusLote IN (2, 3)
                AND lo.estatusCambioNombre = 3
            ORDER BY
                lo.nombreLote"
        )->result();
    }

    public function getInformacionCliente($idLote) {
        return $this->db->query(
            "SELECT
                lo.nombreLote,
                lo.idCondominio,
                lo.precio,
                lo.tipo_venta,
                ISNULL(cl.id_asesor, 0) id_asesor,
                ISNULL(cl.id_coordinador, 0) id_coordinador,
                ISNULL(cl.id_gerente, 0) id_gerente,
                ISNULL(cl.id_subdirector, 0) id_subdirector,
                ISNULL(cl.id_regional, 0) id_regional,
                ISNULL(cl.id_regional_2, 0) id_regional_2,
                ISNULL(cl.personalidad_juridica, 0) personalidad_juridica,
                cxl.nombre nombreCliente,
                cxl.apellido_paterno,
                cxl.apellido_materno
            FROM 
                lotes lo 
                LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 
                INNER JOIN clientes_x_lote cxl ON cxl.idLote = lo.idLote AND cxl.estatus = 1
            WHERE 
                lo.status = 1 
                AND lo.idLote IN ($idLote)"
        )->result();
    }

    function getHistorialCambioNombre() {
        return $this->db->query(
            "SELECT
                re.nombreResidencial, 
                co.nombre nombreCondominio, 
                lo.nombreLote, 
                lo.idLote, 
                UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, 
                lo.idCliente,
                CONVERT(varchar, cl.fechaApartado, 120) fechaApartado, 
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor, 
                CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
                ISNULL(tv.tipo_venta, 'SIN ESPECIFICAR') tipoVenta, 
                ISNULL(se.nombre, 'SIN ESPECIFICAR') ubicacion,
                ISNULL(oxc1.nombre, 'SIN ESPECIFICAR') tipoTramite,
                oxc0.nombre estatusProceso,
                lo.estatusCambioNombre,
                cxl.tipoTramite idTipoTramite,
                CONVERT(varchar, lo.fecha_modst, 120) fechaUltimoEstatus,
                lo.comentario
            FROM 
                lotes lo 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 
                LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor 
                LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
                LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
                LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
                LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
                LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
                LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta 
                LEFT JOIN sedes se ON se.id_sede = lo.ubicacion 
                INNER JOIN clientes_x_lote cxl ON cxl.idLote = lo.idLote AND cxl.estatus = 1
                INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = lo.estatusCambioNombre AND oxc0.id_catalogo = 123
                INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = cxl.tipoTramite  AND oxc1.id_catalogo = 122
            WHERE 
                lo.status = 1 
                AND lo.idStatusLote IN (2, 3)
                AND lo.estatusCambioNombre IN (4, 5)
            ORDER BY
                lo.nombreLote"
        )->result();
    }

    function getCopropsByIdCliente($id_cliente){
        $query = $this->db->query("SELECT * FROM copropietarios WHERE id_cliente = ".$id_cliente);
        return $query->result_array();
    }

    function eliminaCopropietario($id_copropietario){
        $response = $this->db->query("DELETE FROM copropietarios WHERE id_copropietario = $id_copropietario");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getEscrituraNotariada($idCliente, $idLote){
        $query = $this->db->query("SELECT * FROM clientes_x_lote WHERE idCliente=".$idCliente." AND idLote=".$idLote);
        return $query->row();
    }

    function getCopropsActuales($id_cliente){
        $query = $this->db->query("SELECT * FROM copropietarios WHERE id_cliente = ".$id_cliente);
        return $query->result_array();
    }

    function getHistorialEstatus3(){
        return $this->db->query("SELECT res.abreviatura as nombreResidencial, co.nombre as nombreCondominio, lo.nombreLote,
        lo.idLote, lo.referencia, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,
        lo.ubicacion, sede.nombre as nombreSede, CAST(lo.comentario AS varchar(MAX)) comentario, 
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as nombreGerente,
        hl.modificado fechaEnvioPostventa, hl3.modificado fechaEnvioAsesor
        FROM lotes lo
        LEFT JOIN (SELECT MAX(modificado) modificado, idLote, idCliente FROM historial_lotes hl WHERE hl.idMovimiento IN (4, 74, 101, 103) AND status = 1 GROUP BY idLote, idCliente) hl  ON hl.idLote = lo.idLote-- AND hl.idCliente = lo.idCliente
        LEFT JOIN historial_lotes hl2 ON hl2.idLote = hl.idLote AND hl2.idCliente = hl.idCliente AND hl2.modificado = hl.modificado AND hl2.status = 1
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, idCliente FROM historial_lotes hl3 WHERE hl3.idMovimiento IN (98, 100) AND status = 1 GROUP BY idLote, idCliente) hl3  ON hl3.idLote = lo.idLote-- AND hl.idCliente = lo.idCliente
        INNER JOIN historial_lotes hl4 ON hl4.idLote = hl3.idLote AND hl4.idCliente = hl3.idCliente AND hl4.modificado = hl3.modificado AND hl4.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        LEFT JOIN sedes sede ON sede.id_sede = lo.ubicacion
        INNER JOIN usuarios us ON us.id_usuario = cl.id_gerente
        WHERE lo.tipo_venta = 1 AND lo.status = 1 
        GROUP BY res.abreviatura, co.nombre, lo.nombreLote, lo.idLote, lo.nombreLote, lo.referencia, cl.nombre,
        cl.apellido_paterno, cl.apellido_materno,  lo.ubicacion, sede.nombre, CAST(lo.comentario AS varchar(MAX)), hl.modificado,
        us.nombre, us.apellido_paterno, us.apellido_materno, hl3.modificado")->result_array();
    }

    public function getResidencialesOptions()
    {
        $query = "SELECT CONCAT(nombreResidencial, ' - ', UPPER(CONVERT(VARCHAR(50), descripcion))) AS label, idResidencial AS value
        FROM residenciales WHERE status = 1";
        return $this->db->query($query)->result();
    }

    public function getCondominiosOptions($idResidencial)
    {
        $query = "SELECT nombre AS label, idCondominio AS value
        FROM condominios
        WHERE status = 1
        AND idResidencial = $idResidencial";
        
        return $this->db->query($query)->result();
    }

    public function getEscrituraDisponible($idCondominio) 
    {
        return $this->db->query("SELECT  lo.idLote, lo.nombreLote, lo.sup, cond.nombre nombreCondominio, re.descripcion proyecto,
        CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) END nombreCliente, 
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, ISNULL(cl.id_cliente, 0) AS idCliente, CASE WHEN cl.id_cliente IS NULL THEN 0 ELSE 1 END AS clienteExistente,
        re.nombreResidencial, cl.revisionEscrituracion,
        CASE WHEN cl.id_cliente IS NOT NULL THEN CASE WHEN cl.id_cliente = lo.idCliente THEN 1 ELSE 0 END END AS clienteNuevoEditar,
        cl.apellido_paterno  AS apePaterno, cl.apellido_materno AS apeMaterno, cl.domicilio_particular,
        cl.estado_civil, cl.ocupacion,cl.telefono1, cl.correo, cl.escrituraFinalizada

        FROM lotes lo 
        LEFT JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN condominios cond ON cond.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cond.idResidencial
        LEFT JOIN proceso_casas_banco pc ON pc.idLote = lo.idLote
        WHERE lo.status = 1 AND lo.idStatusLote = 2 AND (cl.revisionEscrituracion = 0 OR  cl.revisionEscrituracion IS NULL)
        AND (cond.idCondominio = $idCondominio)
        ")->result_array();
    }

    public function checkDocument($idProceso) {
        if($idProceso == null) {
            return null;
        }
        $query = "SELECT idDocumento FROM documentos_proceso_casas WHERE idProcesoCasas = $idProceso AND tipo = 11";
        return $this->db->query($query)->row();
    }
    
}