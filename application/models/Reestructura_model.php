<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reestructura_model extends CI_Model
{
    function __construct()
    {
        $this->load->library('email');
        parent::__construct();
    }

    public function getListaClientesReubicar() {
        ini_set('memory_limit', -1);
        $id_usuario = $this->session->userdata('id_usuario');
        $query = $this->db->query("SELECT cl.proceso, lr.idProyecto, lo.idLote, lo.nombreLote, lo.idCliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, 
        CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, co.nombre AS nombreCondominio, re.nombreResidencial,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, lo.sup, 
        (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total, co.tipo_lote, oxc.nombre nombreTipoLote
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso NOT IN (2,3,4)
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        INNER JOIN (SELECT DISTINCT(idProyecto) idProyecto FROM loteXReubicacion WHERE estatus = 1) lr ON lr.idProyecto = re.idResidencial
        LEFT JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = co.tipo_lote AND oxc.id_catalogo = 27
        WHERE lo.liberaBandera = 1 AND lo.status = 1 AND lo.id_usuario_asignado = $id_usuario");

        return $query->result_array();
    }

    public function getProyectosDisponibles($proyecto, $superficie, $tipoLote){
        $query = $this->db->query("SELECT lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100))) descripcion, COUNT(*) disponibles
        FROM loteXReubicacion lr
        INNER JOIN residenciales re ON re.idResidencial = lr.proyectoReubicacion AND re.status = 1
		INNER JOIN condominios co ON co.idResidencial = re.idResidencial AND co.tipo_lote = $tipoLote
		INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND (lo.sup >= $superficie - 0.5) AND lo.idStatusLote = 15 AND lo.status = 1
        WHERE lr.idProyecto = $proyecto
		GROUP BY lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100)))");

        return $query->result_array();
    }

    public function getCondominiosDisponibles($proyecto, $superficie, $tipoLote){
        $query = $this->db->query("SELECT lo.idCondominio, co.nombre, COUNT(*) disponibles
        FROM condominios co
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        WHERE lo.idStatusLote = 15 AND lo.status = 1
        AND co.idResidencial = $proyecto AND (lo.sup >= $superficie - 0.5) AND co.tipo_lote = $tipoLote
        GROUP BY lo.idCondominio, co.nombre");

        return $query->result();
    }

    public function getLotesDisponibles($condominio, $superficie){
        $query = $this->db->query("SELECT CASE 
		WHEN (lo.sup = $superficie) THEN op1.nombre
		WHEN (lo.sup - $superficie) <= 2 THEN op2.nombre
		ELSE op3.nombre END a_favor, lo.idLote, lo.nombreLote, lo.sup, lo.precio, lo.total 
		FROM lotes lo 
		INNER JOIN opcs_x_cats op1 ON op1.id_catalogo = 103 AND op1.id_opcion = 1
		INNER JOIN opcs_x_cats op2 ON op2.id_catalogo = 103 AND op2.id_opcion = 2
		INNER JOIN opcs_x_cats op3 ON op3.id_catalogo = 103 AND op3.id_opcion = 3
		WHERE lo.idCondominio = $condominio AND lo.idStatusLote = 15 AND lo.status = 1 AND (lo.sup >= $superficie - 0.5)");
        
        return $query->result();
    }

    function get_proyecto_lista(){
        return $this->db->query("SELECT lotx.proyectoReubicacion AS idResidencial, CONCAT(res.nombreResidencial, ' - ' , res.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales res ON res.idResidencial = lotx.proyectoReubicacion
		GROUP BY lotx.proyectoReubicacion, CONCAT(res.nombreResidencial, ' - ' , res.descripcion)");
    }
    function get_proyecto_listaCancelaciones(){
        return $this->db->query("SELECT lotx.idProyecto AS idResidencial, CONCAT(res.nombreResidencial, ' - ' , res.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales res ON res.idResidencial = lotx.idProyecto 
		GROUP BY lotx.idProyecto,CONCAT(res.nombreResidencial, ' - ' , res.descripcion)");
    }

    function get_catalogo_resstructura(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 100 and estatus = 1");
    }

    function  insertOpcion(){
        return $this->db->query("SELECT TOP (1) id_opcion + 1 AS lastId FROM opcs_x_cats WHERE id_catalogo = 100 ORDER BY id_opcion DESC")->row();
    }

    function nuevaOpcion($datos){
        return $this->db->query("INSERT INTO opcs_x_cats values(".$datos['id'].",100,'".$datos['nombre']."',1,'".$datos['fecha_creacion']."',1,NULL)");
    }

    public function get_valor_lote($id_proyecto){
        ini_set('memory_limit', -1);
        return $this->db->query("SELECT res.nombreResidencial,con.nombre AS condominio, lot.nombreLote,
         lot.idLote ,lot.sup AS superficie, lot.precio, CONCAT(cli.nombre,' ',cli.apellido_paterno,' ',cli.apellido_materno) nombreCliente,
         lot.liberadoReubicacion AS observacion, oxc.nombre AS nombreOp, 
         lot.comentarioReubicacion, lot.liberadoReubicacion ,
         lot.liberaBandera 
        FROM lotes lot
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res on res.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc on oxc.id_opcion = lot.opcionReestructura and id_catalogo = 100
        INNER JOIN loteXReubicacion lotx ON lotx.proyectoReubicacion = con.idResidencial and lotx.proyectoReubicacion in ($id_proyecto)
        LEFT JOIN clientes cli ON cli.id_cliente = lot.idCliente and cli.status in (1,0)
        WHERE lot.idStatusLote in (15,2,3)")->result();
    }

    public function actualizarValidacion($datos)
    {
        return $this->db->query("UPDATE lotes SET opcionReestructura = ".$datos['opcionReestructura'].", comentarioReubicacion = '".$datos['comentario']."', usuario = ".$datos['userLiberacion']." where idLote = ".$datos['idLote']." ");
    }

    public function borrarOpcionModel($datos){
        return $this->db->query("UPDATE opcs_x_cats SET estatus = 0 WHERE id_catalogo = 100 AND id_opcion = ".$datos['idOpcion']."");
    }

    public function editarOpcionModel($datos){
        return $this->db->query("UPDATE opcs_x_cats set nombre = '".$datos['editarCatalogo']."' where id_opcion = ".$datos['idOpcionEdit']." and id_catalogo = 100");
    }

    public function historialModel($id_prospecto){
        return $this->db->query("(SELECT aud.id_auditoria, oxc.nombre, oxcs.nombre as nombreNuevo, aud.fecha_creacion, CONCAT(usu.nombre,' ', usu.apellido_paterno,' ', usu.apellido_materno) AS creado_por from auditoria aud
        INNER JOIN opcs_x_cats  oxc on oxc.id_opcion = aud.anterior and oxc.id_catalogo = 100 and aud.col_afect = 'opcionReestructura'
        INNER JOIN opcs_x_cats  oxcs on oxcs.id_opcion = aud.nuevo and oxcs.id_catalogo = 100 and aud.col_afect = 'opcionReestructura'
        INNER JOIN usuarios usu on usu.id_usuario = aud.creado_por
        where aud.anterior != 'NULL' AND tabla = 'lotes' and col_afect = 'opcionReestructura' and id_parametro = $id_prospecto)
        UNION ALL
        (SELECT aud.id_auditoria, aud.anterior, aud.nuevo, aud.fecha_creacion, CONCAT(usu.nombre,' ', usu.apellido_paterno,' ', usu.apellido_materno) AS creado_por from auditoria aud
        INNER JOIN usuarios usu on usu.id_usuario = aud.creado_por
        where aud.anterior != 'NULL' AND tabla = 'lotes'  and col_afect = 'comentario' and id_parametro = $id_prospecto)");
    }

    public function aplicaLiberacion($datos){
        
        $comentarioLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : $datos['obsLiberacion']));
        $observacionLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : 'CANCELACIÓN DE CONTRATO') );
        $datos["comentarioLiberacion"] = $comentarioLiberacion;
        $datos["observacionLiberacion"] = $observacionLiberacion;
        $datos["fechaLiberacion"] = date('Y-m-d H:i:s');
        $datos["modificado"] = date('Y-m-d H:i:s');
        $datos["status"] = 1;
        $datos["userLiberacion"] = $this->session->userdata('id_usuario');
        $datos["tipo"] = $datos['tipoLiberacion'];


        $row = $this->db->query("SELECT idLote, nombreLote, status, sup,precio,ubicacion,
        (CASE WHEN totalNeto2 IS NULL THEN 0.00 ELSE totalNeto2 END) totalNeto2,
        (CASE WHEN idCliente = 0  OR idCliente IS NULL THEN 0 ELSE idCliente END) idCliente,registro_comision,
        (CASE WHEN tipo_venta IS NULL THEN 0 ELSE tipo_venta END) tipo_venta FROM lotes WHERE idLote=".$datos['idLote']." AND status = 1")->result_array();
        $registro_comision = ($datos['tipo'] == 8 || $datos['tipo'] == 9) ? 9 : 8;
        $idStatusLote = $datos['tipo'] == 9 ? 15 :($datos['tipo'] == 8  ? 3 : 1);
        $sqlIdCliente = $datos['tipo'] == 8 ? ' AND id_cliente='.$row[0]['idCliente'] : '';
        $this->db->trans_begin();
        //($datos['tipo'] == 7 || $datos['tipo'] == 8) ? $this->db->query("UPDATE lotes SET tipo_venta=".$row[0]['tipo_venta'].",usuario='".$datos['userLiberacion']."' WHERE idLote=".$datos['idLoteNuevo']." ") : '';
            $banderaComisionCl = (in_array($datos['tipo'],array(7,8,9))) ? ' ,banderaComisionCl ='.$row[0]['registro_comision'] : '';
            $id_cliente = $this->db->query("SELECT id_cliente FROM clientes WHERE status = 1 AND idLote IN (" . $row[0]['idLote'] . ") ")->result_array();
            $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
            $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row[0]['idLote'].")");
            $this->db->query("UPDATE clientes SET status = 0, tipoLiberacion= ".$datos['tipo'].",totalNeto2Cl=".$row[0]['totalNeto2']." $banderaComisionCl WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") $sqlIdCliente ");
            $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
            $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");

            $datos['tipo'] == 8 ? $this->db->query("UPDATE clientes SET idLote=".$datos['idLote']." WHERE id_cliente=".$datos['idClienteNuevo'].";")  : '' ;
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row[0]['idLote']." AND estatus=1")->result_array();
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
        $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0  WHERE id_lote=".$row[0]['idLote']." ");


            if($row[0]['tipo_venta'] == 1){
                if($datos['tipo'] == 7 || $datos['tipo'] == 8){
                    $clausula = $this->db->query("SELECT TOP 1 id_clausula,nombre FROM clausulas WHERE id_lote = ".$datos['idLote']." ORDER BY id_clausula DESC")->result_array();
                    $this->db->query("INSERT INTO clausulas VALUES(".$datos['idLoteNuevo'].",'".$clausula['nombre']."',1,GETDATE(),'".$datos['userLiberacion']."');");
                }
                $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_lote=".$datos['idLote']." AND estatus = 1");
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
                    idMovimiento = $idMovimiento, comentario = 'NULL', idCliente = $idClienteNuevo, usuario = 'NULL', perfil = 'NULL ', 
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
                    asig_jur = 0
                    WHERE idLote IN (".$datos['idLote'].") and status = 1");

                    if(!in_array($datos["tipo"],array(7,8,9))) {
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
                    }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

    public function setReestructura($datos){
        $this->db->trans_begin();
        $fecha = date('Y-m-d H:i:s');
        $creado_por = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO ventas_compartidas VALUES(".$datos['idCliente'].",".$datos['id_asesor'].",0,".$datos['id_gerente'].",2,'$fecha',$creado_por,".$datos['id_subdirector'].",'$fecha','$creado_por',0,NULL)");
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function obtenerDocumentacionActiva($idLote, $idCliente)
    {
        $query = $this->db->query("SELECT * FROM historial_documento WHERE idLote = $idLote AND idCliente = $idCliente AND status = 1");
        return $query->result_array();
    }

    public function obtenerLotePorId($idLote)
    {
        $query = $this->db->query("SELECT lo.*,
            cl.personalidad_juridica
            FROM lotes lo
            LEFT JOIN clientes cl ON lo.idLote = cl.idLote
            WHERE lo.idLote = $idLote AND cl.status = 1");
        return $query->row();
    }

    public function obtenerDocumentacionPorReubicacion($personalidadJuridica)
    {
        $idCatalogo = ($personalidadJuridica == 1) ? 101 : 98;
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $idCatalogo AND estatus = 1");
        return $query->result_array();
    }

    public function obtenerDocumentacionPorReestructura()
    {
        $query = $this->db->query('SELECT * FROM opcs_x_cats WHERE id_catalogo = 102 AND estatus = 1');
        return $query->result_array();
    }

    public function obtenerDSPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT * FROM deposito_seriedad WHERE id_cliente = $idCliente");
        return $query->row();
    }

    public function obtenerResidencialPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT re.* 
            FROM clientes cl 
            INNER JOIN lotes lo ON cl.idLote = lo.idLote
            INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
            INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
            WHERE id_cliente = $idCliente
        ");
        return $query->row();
    }

    public function obtenerCopropietariosPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT * FROM copropietarios WHERE id_cliente = $idCliente");
        return $query->result_array();
    }

    public function buscarLoteAnteriorPorIdClienteNuevo($idCliente)
    {
        $query = $this->db->query("SELECT * FROM lotes WHERE idLote = (SELECT idLote FROM clientes WHERE id_cliente = (SELECT id_cliente_reubicacion_2 FROM clientes WHERE id_cliente = $idCliente))");
        return $query->row();
    }

    public function getSelectedSup($idLote){
        $query = $this->db->query("SELECT idLote, sup, nombreLote FROM lotes WHERE idLote = $idLote");
        return $query;
    }

    public function loteLiberadoPorReubicacion($idLote): bool
    {
        $query = $this->db->query("SELECT * FROM historial_liberacion WHERE idLote = $idLote AND tipo = 7");
        return count($query->result_array()) > 0;
    }

    public function obtenerClientePorId($idCliente)
    {
        $query = $this->db->query("SELECT * FROM clientes WHERE id_cliente = $idCliente");
        return $query->row();
    }

    public function informacionCartaReubicacionPdf($idClienteNuevo)
    {
        $query = $this->db->query("SELECT CONCAT(clN.nombre, ' ', clN.apellido_paterno, ' ', clN.apellido_materno) AS nombreCliente, 
            loN.nombreLote AS loteNuevo, condN.nombre AS condNuevo, resN.descripcion AS desarrolloNuevo,
            loA.nombreLote AS loteAnterior, condA.nombre AS condAnterior, resA.descripcion AS desarrolloAnterior
        FROM clientes clN
        INNER JOIN lotes loN ON clN.idLote = loN.idLote
        INNER JOIN condominios condN ON loN.idCondominio = condN.idCondominio
        INNER JOIN residenciales resN ON condN.idResidencial = resN.idResidencial
        INNER JOIN clientes clA ON clN.id_cliente_reubicacion_2 = clA.id_cliente
        INNER JOIN lotes loA ON clA.idLote = loA.idLote
        INNER JOIN condominios condA ON loA.idCondominio = condA.idCondominio
        INNER JOIN residenciales resA ON condA.idResidencial = resA.idResidencial
        WHERE clN.id_cliente = $idClienteNuevo");
        return $query->row();
    }

    public function informacionCartaReestructuraPdf($idCliente)
    {
        $query = $this->db->query("SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) AS nombreCliente, 
            lo.nombreLote AS loteNuevo, cond.nombre AS cond, res.descripcion AS desarrollo
        FROM clientes cl
        INNER JOIN lotes lo ON cl.idLote = lo.idLote
        INNER JOIN condominios cond ON lo.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        WHERE cl.id_cliente = $idCliente");
        return $query->row();
    }
    public function getLotes($id_proyecto){
        ini_set('memory_limit', -1);
        return $this->db->query("SELECT res.nombreResidencial,con.nombre AS condominio, lot.nombreLote, lot.idLote ,lot.sup AS superficie, lot.precio, CONCAT(cli.nombre,' ',cli.apellido_paterno,' ',cli.apellido_materno) nombreCliente,lot.observacionLiberacion AS observacion 
        FROM lotes lot
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN loteXReubicacion lotx ON lotx.idProyecto = con.idResidencial AND lotx.idProyecto IN ($id_proyecto)
        INNER JOIN clientes cli ON cli.id_cliente = lot.idCliente AND cli.status IN (1)
        WHERE cli.proceso IN(0,1)")->result();
    }

    public function getLotesEstatusSeisSinTraspaso(){
        return $this->db->query("SELECT re.nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.referencia, lo.sup,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, FORMAT(lo.totalNeto, 'C') totalATraspasar,
        ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, ISNULL(oxc0.nombre, 'Normal') tipo_proceso
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso IN (2, 3, 4)
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
        WHERE status = 1 AND idStatusContratacion = 6 AND idMovimiento = 36 GROUP BY idLote, idCliente) hl
        ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE lo.status  = 1 AND ISNULL(lo.validacionEnganche, 'NULL') NOT IN ('VALIDADO')");
    }

    public function getListaAsignacionCartera() {
        ini_set('memory_limit', -1);
        $id_usuario = $this->session->userdata('id_usuario');
        return $this->db->query("SELECT cl.proceso, lr.idProyecto, lo.idLote, lo.nombreLote, lo.idCliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, 
        CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, co.nombre AS nombreCondominio, re.nombreResidencial,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, lo.sup, 
        CASE WHEN u6.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u6.nombre, ' ', u6.apellido_paterno, ' ', u6.apellido_materno)) END nombreAsesorAsignado, 
        (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total, 
        co.tipo_lote, oxc.nombre nombreTipoLote, ISNULL(u6.id_usuario, 0) idAsesorAsignado
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso NOT IN (2, 3, 4)
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        INNER JOIN (SELECT DISTINCT(idProyecto) idProyecto FROM loteXReubicacion WHERE estatus = 1) lr ON lr.idProyecto = re.idResidencial
        LEFT JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = co.tipo_lote AND oxc.id_catalogo = 27
        LEFT JOIN usuarios u6 ON u6.id_usuario = id_usuario_asignado
        WHERE lo.liberaBandera = 1 AND lo.status = 1")->result_array();
    }

    public function getListaUsuariosParaAsignacion() {
        return $this->db->query("SELECT id_usuario, UPPER(CONCAT(nombre , ' ', apellido_paterno, ' ', apellido_materno, ' ')) nombreUsuario 
        FROM usuarios 
        WHERE estatus = 1 AND tipo = 2 AND id_rol = 7")->result_array();
    }

    function banderaLiberada($clave , $data){
        try {
            $this->db->where('idLote', $clave);
            $this->db->update('lotes', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }
    
    function get_proyecto_lista_yola() {
        return $this->db->query("SELECT lotx.idProyecto AS idResidencial,
        CONCAT(re.nombreResidencial, ' - ' , re.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales re ON re.idResidencial = lotx.idProyecto AND re.idResidencial IN (14, 21, 22, 25)
		GROUP BY lotx.idProyecto, CONCAT(re.nombreResidencial, ' - ' , re.descripcion)");
    }

}
