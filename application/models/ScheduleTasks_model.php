<?php class ScheduleTasks_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function verificaProspectActivos()
	{
		$query = $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) completeName, 
		fecha_creacion, fecha_vencimiento, GETDATE() currentDate, estatus FROM prospectos 
		WHERE estatus = 1 AND fecha_vencimiento <= GETDATE() AND tipo = 0 ORDER BY fecha_vencimiento;");
    	return $query->result_array();
	}
	
	/*public function verificaProspectActivos($type)
	{
	    if ($type == 1){
            $query = $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) completeName, 
            fecha_creacion, fecha_vencimiento, GETDATE() currentDate, estatus, vigencia FROM prospectos 
            WHERE estatus = 1 AND fecha_vencimiento <= GETDATE() AND tipo = 0 AND fecha_creacion >= '2021-04-19 23:59:59.000' ORDER BY fecha_vencimiento;");
        } else if ($type == 2) {
            $query = $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) completeName, 
            fecha_creacion, fecha_vencimiento, GETDATE() currentDate, estatus, vigencia FROM prospectos 
            WHERE estatus = 1 AND fecha_vencimiento <= GETDATE() AND tipo = 0 AND fecha_creacion <= '2021-04-19 23:59:59.000' ORDER BY fecha_vencimiento;");
        }
    	return $query->result_array();
	}*/

	public function disableProspecto($id_prospecto, $data)
	{
		$this->db->where("id_prospecto",$id_prospecto);
		$this->db->update('prospectos', $data);
		return true;
	}
	
	
	public function sendMailVentasRetrasos(){

			$this->db->select("residenciales.nombreResidencial, condominios.nombre as nombreCondominio, lotes.nombreLote, clientes.fechaApartado,
			clientes.nombre as nc, clientes.apellido_paterno as appc, clientes.apellido_materno as apmc, 
			
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente");
			
			
			$this->db->join('lotes', 'clientes.idLote = lotes.idLote');
			$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
			$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
			
			
			$this->db->join('usuarios asesor', 'clientes.id_asesor = asesor.id_usuario', 'left');
			$this->db->join('usuarios coordinador', 'clientes.id_coordinador = coordinador.id_usuario', 'left');
			$this->db->join('usuarios gerente', 'clientes.id_gerente = gerente.id_usuario', 'left');
	
			$this->db->where_in('lotes.idMovimiento', array('31','85','20','63','73','82','92'));
			$this->db->where("lotes.status",1);
			$this->db->where("clientes.status",1);
			$this->db->order_by('clientes.fechaApartado', 'asc');
			$query = $this->db->get('clientes');
			return $query->result();
	} 



	public function getBloqueos(){
	$query = array();
		$queryBloqueados = $this->db->query('SELECT idLote as idLotes from historial_bloqueo where historial_bloqueo.status = 1 ');
		foreach ($queryBloqueados->result_array() as $bloqueosAll)
		{
			$query[] = $this->db-> query('SELECT idLote, idStatusLote from lotes where idLote IN ('.$bloqueosAll['idLotes'].')')->result_array();
			 
		}	
		return $query;
	} 


	public function updateStatusBloqueo($data){
		 $this->db->where_in("idLote", $data, FALSE);
		 $this->db->update('historial_bloqueo', array( "status" => 0));
		 return true; 

	}


	public function sendMailBloqueosDireccion(){

	$this->db->select("lotes.idLote, condominios.idCondominio, residenciales.idResidencial, lotes.nombreLote, residenciales.nombreResidencial,
	        condominios.nombre as nombreCondominio, historial_bloqueo.create_at, 	 
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente, lotes.sup");
	 
			$this->db->join('lotes', 'historial_bloqueo.idLote = lotes.idLote');
			$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio');
			$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial');
			
			
			$this->db->join('usuarios asesor', 'historial_bloqueo.idAsesor = asesor.id_usuario');
			$this->db->join('usuarios coordinador', 'asesor.id_lider = coordinador.id_usuario');
			$this->db->join('usuarios gerente', 'coordinador.id_lider = gerente.id_usuario');


	 $this->db->where("historial_bloqueo.status", '1');
	 $query = $this->db->get('historial_bloqueo');
	 return $query->result();


	}


	function getUsersList()
    {
        $query = $this->db->query("SELECT id_usuario, (CASE id_usuario WHEN 5363 THEN  '1, 5' WHEN 2042 THEN '2, 3, 4, 6' ELSE id_sede END)
		id_sede, id_rol, correo, nombre FROM usuarios WHERE (id_rol IN (19, 20, 28) OR id_usuario IN (2767, 2855)) AND estatus = 1 ORDER BY id_rol, nombre");
        return $query->result_array();
    }

    function getRejectList ($id_sede, $reject_type, $userType) {
        if ($userType == 32) { // CONTRALORÍA
        	$query = $this->db->query("SELECT id_coment, cm.idLote, cm.observacion, cm.fecha_creacion,
	        l.nombreLote, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,
	        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as nombreSolicitante
	        FROM comentariosMktd cm
	        INNER JOIN lotes l ON l.idLote=cm.idLote
	        INNER JOIN clientes cl ON cl.id_cliente=l.idCliente
	        INNER JOIN usuarios u ON u.id_usuario=cm.creado_por ORDER BY nombreLote");
        } else { // MKTD
        	$query = $this->db->query("SELECT c.id_cliente, l.idLote, ec.id_evidencia, l.nombreLote, ec.estatus, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombreCliente,
        CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as nombreSolicitante, ec.evidencia, he.fecha_creacion fechaRechazo,
        ec.comentario_autorizacion, ec.fecha_creacion, s.nombre plaza, DATEPART ( WK , he.fecha_creacion ) weekNumber
        FROM evidencia_cliente ec
        INNER JOIN clientes c ON c.id_cliente = ec.idCliente AND c.lugar_prospeccion = 6 AND c.status = 1
        INNER JOIN usuarios solicitante ON ec.id_sol = solicitante.id_usuario
        INNER JOIN usuarios asesor ON c.id_asesor = asesor.id_usuario
        INNER JOIN sedes s ON s.id_sede = asesor.id_sede
        INNER JOIN lotes l ON l.idLote = ec.idLote
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias 
        GROUP BY id_evidencia, estatus) he ON he.id_evidencia = ec.id_evidencia AND he.estatus = $reject_type
        WHERE asesor.id_sede IN ($id_sede) AND ec.estatus IN ($reject_type)");
        }
        return $query->result_array();
     }

    public function verifyLead()
    {
        $query = $this->db->query("SELECT tipo, estatus, id_prospecto, fecha_creacion, fecha_vencimiento, vigencia, estatus_vigencia,
		DATEDIFF(DAY, fecha_vencimiento, GETDATE()) difference
		FROM prospectos
		WHERE estatus = 1 AND fecha_creacion >= '2021-04-19 23:59:59.000'
		AND DATEDIFF(DAY, fecha_vencimiento, GETDATE()) >= 5 AND tipo = 0");
        return $query->result_array();
    }

    function getReportInformation ($queryType, $date) {
        if ($queryType == 1) { // MJ: REPORTE ESTATUS 10
        	$query = $this->db->query("SELECT s.nombre nombreSede, res.nombreResidencial, cond.nombre nombreCondominio, l.nombreLote,
			CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente,
			l.sup, l.referencia, UPPER(st.nombre) estatusLote, cl.fechaApartado,
			CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) nombreAsesor,
			CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) nombreGerente,
			ISNULL(oxc0.nombre, 'Normal') tipo_proceso
			FROM historial_lotes hd
			INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente AND cl.status = 1
			INNER JOIN lotes l ON hd.idLote = l.idLote AND l.status = 1
			INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
			INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
			INNER JOIN sedes s ON s.id_sede = l.ubicacion
			INNER JOIN statuslote st ON st.idStatusLote = l.idStatusLote
			LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
			LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
			LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
			WHERE (hd.idStatusContratacion = 10 and hd.idMovimiento  = 40) AND hd.status = 1 
			AND hd.modificado BETWEEN '$date 00:00:00' AND '$date 23:59:59'
			ORDER BY hd.modificado ASC");
        } else  if ($queryType == 2) { // MJ: REPORTE LIBERADOS
        	$query = $this->db->query("SELECT res.nombreResidencial, cond.nombre nombreCondominio, l.nombreLote,
			CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente,
			l.sup, l.referencia, UPPER(st.nombre) estatusLote, cl.fechaApartado, a.fecha_creacion fechaLiberacion,
			CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) nombreAsesor,
			CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) nombreGerente
			FROM  lotes l
			INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
			INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
			INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
			INNER JOIN statuslote st ON st.idStatusLote = l.idStatusLote
			INNER JOIN auditoria a ON a.id_parametro = cl.idLote AND a.nuevo = '1' AND 
			a.fecha_creacion BETWEEN '$date 00:00:00' AND '$date 23:59:59' 
			AND a.col_afect = 'observacionContratoUrgente' AND a.tabla = 'lotes'
			LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
			LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
			WHERE l.status = 1");
        }
        return $query->result_array();
     }
	
	//  public function interesMenos(){
	// 	return $this->db->query("SELECT * FROM condominios where msni > 0 AND status = 1 AND idResidencial NOT IN (3,13,22)");
	// }

	public function interesMenos(){
		$query = $this->db->query("SELECT idLote, c.idCondominio, idResidencial, msi as msni, nombre, l.fecha_creacion as create_at
        FROM lotes l 
        INNER JOIN condominios c ON c.idCondominio=l.idCondominio
        WHERE c.idResidencial NOT IN (3, 13, 22) 
        AND msni > 0 
        AND (l.fecha_creacion < DATEADD(DAY, -15, GETDATE()) OR l.fecha_creacion IS NULL) ");


//		return $updateArrayData;
        return $query->result_array();
	}

	public function SessionDestroy(){
		$array = array();
		$getID = $this->db->query("SELECT id_usuario FROM usuarios WHERE id_rol = 61")->row();
		$user = $getID->id_usuario;
		$query = $this->db->query("DELETE FROM session_sisfusion WHERE id IN (SELECT id FROM session_sisfusion WHERE data LIKE '%id_usuario|i:$user%')");
		return $query;
	}

	public function getPresupuestos(){
		$mes = date('m');
		$year = date('Y');

		return $this->db->query("SELECT idPresupuesto, expediente, idSolicitud, estatus, tipo, fecha_creacion, creado_por, modificado_por, bandera
		FROM Presupuestos
		WHERE estatus = 0 AND tipo = 2 
		AND idPresupuesto NOT IN 
			(SELECT idPresupuesto 
			FROM Presupuestos
			WHERE fecha_creacion BETWEEN '$year-$mes-01 00:00:00' AND '$year-$mes-10 23:59:59')");
									
	}

	public function getLotesAsignadosTodos(){
        $query = $this->db->query(
            "WITH proceso0 AS(
                SELECT
	        	    usg.id_usuario,
	        	    COUNT(lo.idLote) cantidadProceso0,
	        	    CONCAT(usg.nombre, ' ', usg.apellido_paterno, ' ', usg.apellido_materno) AS nombreGerente,
	        	    usg.correo
	        	    FROM 
	        		    lotes lo
	        	    INNER JOIN usuarios usa ON usa.id_usuario = lo.id_usuario_asignado 
	        	    INNER JOIN usuarios usg ON usg.id_usuario = usa.id_lider 
	        	    WHERE id_usuario_asignado != 0 AND usg.id_rol = 3 AND lo.estatus_preproceso = 0
	        	    AND lo.idLote NOT IN (SELECT idLote FROM propuestas_x_lote)
	        	    AND lo.idLote NOT IN (SELECT idLotePvOrigen FROM lotesFusion)
	        	    GROUP BY usg.id_usuario, usg.correo, usg.id_usuario, usg.nombre, usg.apellido_paterno, usg.apellido_materno
                ),
            proceso1 AS(
	            SELECT
	            	usg.id_usuario,
	            	COUNT(lo.idLote) cantidadProceso1,
	            	CONCAT(usg.nombre, ' ', usg.apellido_paterno, ' ', usg.apellido_materno) AS nombreGerente,
	            	usg.correo
	            	FROM 
	            		lotes lo
	            	INNER JOIN usuarios usa ON usa.id_usuario = lo.id_usuario_asignado 
	            	INNER JOIN usuarios usg ON usg.id_usuario = usa.id_lider 
	            	WHERE id_usuario_asignado != 0 AND usg.id_rol = 3 AND lo.estatus_preproceso = 1
	            	GROUP BY usg.id_usuario, usg.correo, usg.id_usuario, usg.nombre, usg.apellido_paterno, usg.apellido_materno
                ),
            proceso3 AS(
	            SELECT
	        	    usg.id_usuario,
	        	    COUNT(lo.idLote) cantidadProceso3,
	        	    CONCAT(usg.nombre, ' ', usg.apellido_paterno, ' ', usg.apellido_materno) AS nombreGerente,
	        	    usg.correo
	        	    FROM 
	        		    lotes lo
	        	    INNER JOIN usuarios usa ON usa.id_usuario = lo.id_usuario_asignado 
	        	    INNER JOIN usuarios usg ON usg.id_usuario = usa.id_lider 
	        	    WHERE id_usuario_asignado != 0 AND usg.id_rol = 3 AND lo.estatus_preproceso = 3
	        	    GROUP BY usg.id_usuario, usg.correo, usg.id_usuario, usg.nombre, usg.apellido_paterno, usg.apellido_materno
                ),
            proceso6 AS(
            	SELECT
            		usg.id_usuario,
            		COUNT(lo.idLote) cantidadProceso6,
            		CONCAT(usg.nombre, ' ', usg.apellido_paterno, ' ', usg.apellido_materno) AS nombreGerente,
            		usg.correo
            		FROM 
            			lotes lo
            		INNER JOIN usuarios usa ON usa.id_usuario = lo.id_usuario_asignado 
            		INNER JOIN usuarios usg ON usg.id_usuario = usa.id_lider 
            		WHERE id_usuario_asignado != 0 AND usg.id_rol = 3 AND lo.estatus_preproceso = 6
            		GROUP BY usg.id_usuario, usg.correo, usg.id_usuario, usg.nombre, usg.apellido_paterno, usg.apellido_materno
            )

            SELECT 
            	us.id_usuario,
                us.correo,
            	pr0.nombreGerente, pr0.cantidadProceso0,
            	pr1.cantidadProceso1, pr3.cantidadProceso3,
            	pr6.cantidadProceso6
            	FROM
            		usuarios us
            	INNER JOIN proceso0 pr0 ON pr0.id_usuario = us.id_usuario
            	INNER JOIN proceso1 pr1 ON pr1.id_usuario = us.id_usuario
            	INNER JOIN proceso3 pr3 ON pr3.id_usuario = us.id_usuario
            	INNER JOIN proceso6 pr6 ON pr6.id_usuario = us.id_usuario");

        return $query;
    }

    public function getLotesAsignados6(){
        $query = $this->db->query(
            "WITH proceso6 AS(
            	SELECT
            		usa.id_usuario,
            		COUNT(lo.idLote) cantidadProceso6,
            		CONCAT(usa.nombre, ' ', usa.apellido_paterno, ' ', usa.apellido_materno) AS nombreAsesor,
            		usa.correo
            		FROM 
            			lotes lo
            		INNER JOIN usuarios usa ON usa.id_usuario = lo.id_usuario_asignado 
            		INNER JOIN usuarios usg ON usg.id_usuario = usa.id_lider 
            		WHERE id_usuario_asignado != 0 AND usg.id_rol = 3 AND lo.estatus_preproceso = 6
            		GROUP BY usg.id_usuario, usa.correo, usa.id_usuario, usa.nombre, usa.apellido_paterno, usa.apellido_materno
            )

            SELECT
            	us.id_usuario,
                us.correo,
				pr6.nombreAsesor,
            	pr6.cantidadProceso6
            	FROM
            		usuarios us
            	INNER JOIN proceso6 pr6 ON pr6.id_usuario = us.id_usuario"
        );

        return $query;
    }

    public function getLotesAsignadosContraloria(){
        $query = $this->db->query("SELECT
            		COUNT(lo.idLote) cantidadProceso2
            		FROM 
            			lotes lo
					INNER JOIN datos_x_cliente dxc ON dxc.idLote = lo.idLote AND dxc.flagProcesoContraloria = 0
            		WHERE id_usuario_asignado != 0 AND lo.estatus_preproceso = 2");
        
        return $query;
    }

    public function getLotesAsignadosJuridico(){
        $query = $this->db->query("SELECT
            		COUNT(lo.idLote) cantidadProceso2
            		FROM 
            			lotes lo
					INNER JOIN datos_x_cliente dxc ON dxc.idLote = lo.idLote AND dxc.flagProcesoContraloria = 1 AND dxc.flagProcesoJuridico = 0
            		WHERE id_usuario_asignado != 0 AND lo.estatus_preproceso = 2");
        
        return $query;
    }
}