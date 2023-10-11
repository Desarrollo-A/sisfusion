<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VentasAsistentes_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    function get_proyecto_lista(){
        return $this->db->query("SELECT CONCAT(nombreResidencial,' - ', descripcion) AS descripcionConcat,* FROM [residenciales] WHERE status = 1");
    }
    function get_condominio_lista($proyecto){
        return $this->db->query("SELECT * FROM [condominios] WHERE status = 1 AND idResidencial = ".$proyecto."");
    }
    function get_lote_lista($condominio){
        return $this->db->query("SELECT * FROM [lotes] WHERE status = 1 AND idCondominio =  ".$condominio." AND idCliente in (SELECT idCliente FROM clientes ) AND (idCliente <> 0 AND idCliente <>'')");
    }

    //Función para traer proyecto por usuario
    function get_proyecto_lista_usu(){
        return $this->db->query('SELECT r.idResidencial, r.nombreResidencial, CAST(r.descripcion AS varchar(80)) descripcion 
                FROM clientes cli INNER JOIN usuarios u ON cli.id_asesor = u.id_usuario
                INNER JOIN lotes l ON l.idCliente = cli.id_cliente
                INNER JOIN condominios con ON con.idCondominio = cli.idCondominio
                INNER JOIN residenciales r ON con.idResidencial = r.idResidencial
                WHERE u.id_usuario = ' . $this->session->userdata('id_usuario') . ' AND r.status = 1
                GROUP BY r.idResidencial, r.nombreResidencial, CAST(r.descripcion AS varchar(80))
                ORDER BY CAST(r.descripcion AS varchar(80))');
    }

    //Función para traer condominio por usuario
    function get_condominio_lista_usu($proyecto){
        return $this->db->query('SELECT con.idCondominio, con.nombre
                                FROM clientes cli INNER JOIN usuarios u ON cli.id_asesor = u.id_usuario
                                    INNER JOIN lotes l ON l.idCliente = cli.id_cliente
                                    INNER JOIN condominios con ON con.idCondominio = cli.idCondominio
                                    INNER JOIN residenciales r ON con.idResidencial = r.idResidencial
                                    WHERE u.id_usuario = ' . $this->session->userdata('id_usuario') . ' AND r.status = 1 AND r.idResidencial = '.$proyecto.'
                                    GROUP BY con.idCondominio, con.nombre
                                    ORDER BY con.nombre');
    }

    //Función para traer los lotes por usuario
    function get_lote_lista_usu($condominio){
        return $this->db->query('SELECT l.idLote, l.nombreLote
                                FROM clientes cli INNER JOIN usuarios u ON cli.id_asesor = u.id_usuario
                                    INNER JOIN lotes l ON l.idCliente = cli.id_cliente
                                    INNER JOIN condominios con ON con.idCondominio = cli.idCondominio
                                    WHERE u.id_usuario = ' . $this->session->userdata('id_usuario') . ' AND con.idCondominio = '.$condominio.'
                                    GROUP BY l.idLote, l.nombreLote');
    }

    function get_datos_lote_aut($lote){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, con.idCondominio,  cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial 
                                FROM clientes cli INNER JOIN [lotes] lot ON lot.idLote = cli.idLote 
                                    INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                                    INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cli.idLote = '".$lote."'");
    }
    
    function get_datos_lote_cont($lote){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, 
        lot.nombreLote, con.nombre as condominio, res.nombreResidencial, 
        CASE WHEN lot.contratoArchivo = 'NULL' THEN 'SIN ESPECIFICAR' ELSE lot.contratoArchivo END AS contratoArchivo
        FROM clientes cli INNER JOIN [lotes] lot ON lot.idLote = cli.idLote 
        INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
        INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
        WHERE cli.status = 1 AND cli.idLote = '".$lote."'");
    }

    public function getLegalRejections() {
        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                                        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
                                        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
                                        l.tipo_venta, 
                                        CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
                                        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
                                        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
                                        cond.idCondominio, cl.expediente
                                    FROM lotes l
                                        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
                                        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
                                        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
                                        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
                                        LEFT JOIN usuarios coordinador ON asesor.id_lider = coordinador.id_usuario
                                        LEFT JOIN usuarios gerente ON coordinador.id_lider = gerente.id_usuario
                                    WHERE  l.idStatusContratacion = '3' and l.idMovimiento  = '82' and cl.status = 1 
                                    GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
                                        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
                                        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
                                        l.tipo_venta, 
                                        CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
                                        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
                                        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
                                        cond.idCondominio, cl.expediente");
        return $query->result();
    }
   
	public function registroStatusContratacion8 () {
        $id_sede = $this->session->userdata('id_sede');
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $tipo = $this->session->userdata('tipo');
        if (in_array($id_rol, array(17, 70))) { // MJ: ES CONTRALORÍA Y EJECUTIVO DE CONTRALORÍA JR
            $filtroUsuarioBR = '';
            if($id_usuario == 2815 || $id_usuario == 12931)
                $filtroUsuarioBR = ' AND (l.tipo_venta IN (4, 6) OR cl.id_asesor IN (2549, 2570, 2591))';
            else if (in_array($id_usuario, array(12377, 2799, 10088, 2827, 6012))) // MIRIAM PAOLA JIMENEZ FIGUEROA o LADY SKARLETT LOPEZ VEN REUBICACIONES
                $filtroUsuarioBR = ' AND l.tipo_venta IN (6)';
            else
                $filtroUsuarioBR = ' AND l.tipo_venta IN (4, 6)';
            $where = "l.idStatusContratacion IN (7, 11) AND l.idMovimiento IN (37, 7, 64, 66, 77, 41) AND l.status8Flag = 0 AND cl.status = 1 ".$filtroUsuarioBR;
        }
        else if (in_array($id_rol, array(54, 63, 4))) // MJ: MARKETING DIGITAL (POPEA) OR CONTROL INTERNO OR ASISTENTES DIRECCIÓN COMERCIAL
            $where = "l.idStatusContratacion IN (7, 11) AND l.idMovimiento IN (37, 7, 64, 66, 77, 41) AND l.status8Flag = 0 AND cl.status = 1";
        else { // MJ: ES COMERCIALIZACIÓN
            if ($tipo == 1) { // SON COMERCIALIZACIÓN
                if ($id_sede == 9)
                    $filtroSede = "AND l.ubicacion IN ('4', '$id_sede')";
                else if ($id_sede == 10 && $id_usuario == 11422) // FRANCISCA JUDITH VE TEXAS, TIJUANA Y MTY
                    $filtroSede = "AND l.ubicacion IN ('8', '11', '$id_sede')";
                else if ($id_sede == 10 && !in_array($id_rol, array(6, 5, 4))) 
                    $filtroSede = "AND l.ubicacion IN ('11', '$id_sede')";
                else
                    $filtroSede = "AND l.ubicacion IN ('$id_sede')";
                
                if (in_array($id_usuario, array(28, 3)))
                    $filtroSede = "AND l.ubicacion IN ('2', '4', '13', '14', '15')";

                $filtroGerente = "";
                if ($id_usuario == 12318) { // EMMA CECILIA MALDONADO RAMÍREZ
                    $filtroGerente = "AND cl.id_gerente IN ($id_lider, 11196, 5637, 2599, 1507)";
                    $filtroSede = "";
                } else if (in_array($id_usuario, array(7097, 7096, 10924, 7324, 5620, 13094))) // GRISELL MALAGON, EDGAR AGUILAR Y DALIA PONCE
                    $filtroSede = "AND l.ubicacion IN ('4', '9', '13', '14')"; // Ciudad de México, San Miguel de Allende, Estado de México Occidente y Estado de México Norte
                else if (in_array($id_usuario, array(29, 7934))) // FERNANDA MONJARAZ Y SANDRA CAROLINA GUERRERO GARCIA
                    $filtroSede = "AND l.ubicacion IN ('5', '12')"; // León y Guadalajara
                else if(in_array($id_usuario, array(13050))){
                    $filtroGerente = "AND cl.id_gerente IN ($id_lider)";
                    $filtroSede = " AND l.ubicacion IN ($id_sede, '4')";
                }
                else if ($id_usuario == 6831) { // YARETZI MARICRUZ ROSALES HERNANDEZ
                    $filtroGerente = "AND cl.id_subdirector IN ($id_lider)";
                    $filtroSede = "";
                }
            }
            else { // SON EEC
                $filtroGerente = "AND cl.id_gerente IN ($id_lider)";
                $filtroSede = "";
            }
        
            $where = "l.idStatusContratacion IN (7, 11) AND l.idMovimiento IN (37, 7, 64, 66, 77, 41) AND l.status8Flag = 0 AND cl.status = 1 $filtroSede $filtroGerente";
        }

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(VARCHAR, l.modificado, 120) AS modificado, cl.rfc, sd.nombre as nombreSede,
        CAST(l.comentario AS varchar(MAX)) as comentario, CONVERT(VARCHAR,l.fechaVenc,120) AS fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.observacionContratoUrgente as vl,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
        cond.idCondominio, cl.expediente, UPPER(mo.descripcion) AS descripcion,
        ISNULL(oxc0.nombre, 'Normal') tipo_proceso
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote and cl.status = 1
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN movimientos mo ON mo.idMovimiento = l.idMovimiento
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
        LEFT JOIN sedes sd ON sd.id_sede = l.ubicacion
        LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE $where
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, sd.nombre,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        tv.tipo_venta, l.observacionContratoUrgente,
        CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
        cond.idCondominio, cl.expediente, mo.descripcion, ISNULL(oxc0.nombre, 'Normal')
        ORDER BY l.nombreLote");
		return $query->result();
	}

    public function validateSt8($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (7, 11) AND idMovimiento IN (37, 7, 64, 66, 77, 41) AND status8Flag = 0)");	
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    function validaSinliquidar($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where("tipo_doc = 38 AND status = 1");
        $query = $this->db->get('historial_documento');	
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    function validaComplementoEnganche($idLote){
        $query = $this->db->query("SELECT expediente FROM historial_documento WHERE idLote=$idLote AND tipo_doc=38 AND status=1;");
        return $query->row();
    }

    public function updateSt($idLote,$arreglo,$arreglo2){

        $this->db->trans_begin();

        $this->db->where("idLote",$idLote);
        $this->db->update('lotes',$arreglo);

        $this->db->insert('historial_lotes',$arreglo2);

        if ($this->db->trans_status() === FALSE){
              $this->db->trans_rollback();
              return false;
        } else {
              $this->db->trans_commit();
              return true;
        }

    }

	public function getCorreoSt ($idCliente) {

		$query = $this->db-> query("SELECT STRING_AGG (correo, ',') correos FROM (
			/*ASESOR COORDINADOR GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, CONCAT(u.correo, ',', uu.correo, ',', uuu.correo) correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor 
			LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador 
			LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente 
			WHERE c.id_cliente = ".$idCliente."
			UNION ALL
			/*ASESOR COORDINADOR GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, CONCAT(u.correo, ',', uu.correo, ',', uuu.correo) correo FROM ventas_compartidas vc 
			LEFT JOIN usuarios u ON u.id_usuario = vc.id_asesor 
			LEFT JOIN usuarios uu ON uu.id_usuario = vc.id_coordinador 
			LEFT JOIN usuarios uuu ON uuu.id_usuario = vc.id_gerente 
			WHERE vc.id_cliente = ".$idCliente."
			UNION ALL
			/*ASISTENTE GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, u.correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_lider = c.id_gerente
			WHERE c.id_cliente = ".$idCliente." AND u.id_rol = 6
			UNION ALL
			/*ASISTENTE GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, u.correo FROM ventas_compartidas vc 
			INNER JOIN usuarios u ON u.id_lider = vc.id_gerente
			WHERE vc.id_cliente = ".$idCliente." AND u.id_rol = 6
			UNION ALL
			/*ASISTENTE SUBDIRECTOR (TITULAR VENTA) */
			SELECT c.id_cliente, uuu.correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_gerente
			LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
			LEFT JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
			WHERE c.id_cliente = ".$idCliente." AND uuu.id_rol = 5
			UNION ALL
			/*ASISTENTE SUBDIRECTOR (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, uuu.correo FROM ventas_compartidas vc 
			LEFT JOIN usuarios u ON u.id_usuario = vc.id_gerente
			LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
			LEFT JOIN usuarios uuu ON uuu.id_lider = uu.id_usuario
			WHERE vc.id_cliente = ".$idCliente." AND uuu.id_rol = 5 GROUP BY vc.id_cliente, uuu.correo) AS correos;");

		return $query->result_array();

	}



	public function getNameLote($idLote){
		$query = $this->db-> query("SELECT l.idLote, l.nombreLote, cond.nombre,
		res.nombreResidencial
        FROM lotes l
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		where l.idLote = ".$idLote." "); 
		return $query->row();
	}
	
    public function registroStatusContratacion14 () {
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_sede = $this->session->userdata('id_sede');
        $id_lider = $this->session->userdata('id_lider');
        $tipo = $this->session->userdata('tipo');
        if (in_array($id_rol, array(17, 70))){ // MJ: ES CONTRALORÍA Y EJECUTIVO CONTRALORÍA JR
            $filtroUsuarioBR = '';
            if($id_usuario == 2815 || $id_usuario == 12931)
                $filtroUsuarioBR = ' AND (l.tipo_venta IN (4, 6) OR cl.id_asesor IN (2549, 2570, 2591))';
            else if (in_array($id_usuario, array(12377, 2799, 10088, 2827, 6012))) // MIRIAM PAOLA JIMENEZ FIGUEROA o LADY SKARLETT LOPEZ VEN REUBICACIONES
                $filtroUsuarioBR = ' AND l.tipo_venta IN (6)';
            else
                $filtroUsuarioBR = ' AND l.tipo_venta IN (4, 6)';
            $where = "l.idStatusContratacion = 13 AND l.idMovimiento IN (43, 68) AND cl.status = 1".$filtroUsuarioBR;
        }
        else if (in_array($id_rol, array(54, 63, 4)))  // MJ: MARKETING DIGITAL (POPEA) OR CONTROL INTERNO OR ASISTENTES DIRECCIÓN COMERCIAL
            $where = "l.idStatusContratacion = 13 AND l.idMovimiento IN (43, 68) AND cl.status = 1";
        else { // MJ: ES COMERCIALIZACIÓN
            if ($tipo == 1) { // SON COMERCIALIZACIÓN
                if ($id_sede == 9)
                    $filtroSede = "AND l.ubicacion IN ('4', '$id_sede')";
                else if ($id_sede == 10 && $id_usuario == 11422) // FRANCISCA JUDITH VE TEXAS, TIJUANA Y MTY
                    $filtroSede = "AND l.ubicacion IN ('8', '11', '$id_sede')";
                else if ($id_sede == 10 && !in_array($id_rol, array(6, 5, 4))) 
                    $filtroSede = "AND l.ubicacion IN ('11', '$id_sede')";
                else
                    $filtroSede = "AND l.ubicacion IN ('$id_sede')";
                    
                if (in_array($id_usuario, array(28, 3)))
                    $filtroSede = "AND l.ubicacion IN ('2', '4', '13', '14', '15')";

                $filtroGerente = "";
                if ($id_usuario == 12318) { // EMMA CECILIA MALDONADO RAMÍREZ
                    $filtroGerente = "AND cl.id_gerente IN ($id_lider, 11196, 5637, 2599, 1507)";
                    $filtroSede = "";
                } else if (in_array($id_usuario, array(7097, 7096, 10924, 7324, 5620, 13094))) // GRISELL MALAGON, EDGAR AGUILAR Y DALIA PONCE
                    $filtroSede = "AND l.ubicacion IN ('4', '9', '13', '14')"; // Ciudad de México, San Miguel de Allende, Estado de México Occidente y Estado de México Norte
                else if (in_array($id_usuario, array(29, 7934))) // FERNANDA MONJARAZ Y SANDRA CAROLINA GUERRERO GARCIA
                    $filtroSede = "AND l.ubicacion IN ('5', '12')"; // León y Guadalajara
                else if(in_array($id_usuario, array(13050))){
                    $filtroGerente = "AND cl.id_gerente IN ($id_lider)";
                    $filtroSede = " AND l.ubicacion IN ($id_sede, '4')";
                }
                else if ($id_usuario == 6831) { // YARETZI MARICRUZ ROSALES HERNANDEZ
                    $filtroGerente = "AND cl.id_subdirector IN ($id_lider)";
                    $filtroSede = "";
                }
            }
            else { // SON EEC
                $filtroGerente = "AND cl.id_gerente IN ($id_lider)";
                $filtroSede = "";
            }
            
            $where = "l.idStatusContratacion = 13 AND l.idMovimiento IN (43, 68) AND cl.status = 1 $filtroSede $filtroGerente";
        }
        $query = $this->db->query(" SELECT l.idLote, cl.id_cliente,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(VARCHAR,l.modificado,120) AS modificado, cl.rfc,
        CAST(l.comentario AS VARCHAR(MAX)) AS comentario, CONVERT(VARCHAR,l.fechaVenc,120) AS fechaVenc, l.perfil, cond.nombre AS nombreCondominio, res.nombreResidencial, l.ubicacion,
        ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente,
        CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) AS asesor,
        CONCAT(coordinador.nombre, ' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) AS coordinador,
        CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) AS gerente,
        cond.idCondominio, l.observacionContratoUrgente AS vl, sd.nombre as nombreSede,
        ISNULL(oxc0.nombre, 'Normal') tipo_proceso
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
        LEFT JOIN sedes sd ON sd.id_sede = l.ubicacion
        LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE $where
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS VARCHAR(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        tv.tipo_venta, CONCAT(asesor.nombre,' ',asesor.apellido_paterno, ' ', asesor.apellido_materno),
        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
        cond.idCondominio, l.observacionContratoUrgente, sd.nombre, ISNULL(oxc0.nombre, 'Normal')
        ORDER BY l.nombreLote");
		return $query->result();
	}
    
	public function validateSt14($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (13) AND idMovimiento IN (43, 68))");	
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;

    }

	public function get_lp($idLote){
		$query = $this->db-> query("SELECT cl.lugar_prospeccion
        FROM clientes cl where cl.lugar_prospeccion = 6 AND cl.idLote = ".$idLote." "); 
		return $query->row();
	}

	public function validaCartaCM($idCliente){
        $query = $this->db->query("SELECT hd.*, cl.personalidad_juridica, cl.tipo_comprobanteD FROM historial_documento  hd
        INNER JOIN clientes cl ON cl.id_cliente = hd.idCliente
        WHERE idCliente=".$idCliente." AND hd.status=1 AND (tipo_doc=29 OR tipo_doc=26) AND movimiento='CARTA DOMICILIO CM';");
        return $query->result_array();
    }
    public function check_carta($idCliente){
        $query = $this->db->query("SELECT * FROM clientes WHERE id_cliente=".$idCliente);
        return $query->result_array();
    }
}
