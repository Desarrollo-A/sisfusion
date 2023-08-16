<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Ventas_modelo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function getGralInfRepoVta(){
		$query=$this->db->query("SELECT USU.id_usuario AS id_asesor, CONCAT(USU.nombre, ' ', USU.apellido_paterno, ' ', USU.apellido_materno) AS nombre_asesor, USU.fecha_creacion AS fecha_creacion, 
		COUNT(LO.idLote) AS num_lotes, FORMAT(SUM(LO.total_lotes), 'C') AS total_ventas_lotes,
		CASE 
			WHEN DATEDIFF(MONTH, USU.fecha_creacion, DATETIMEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), DAY(GETDATE()), 23, 59, 59, 999)) BETWEEN 0 AND 3 THEN 
				'3 MESES' 
			WHEN DATEDIFF(MONTH, USU.fecha_creacion, DATETIMEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), DAY(GETDATE()), 23, 59, 59, 999)) BETWEEN 4 AND 6 THEN 
				'6 MESES'
			WHEN DATEDIFF(MONTH, USU.fecha_creacion, DATETIMEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), DAY(GETDATE()), 23, 59, 59, 999)) BETWEEN 7 AND 9 THEN 
				'9 MESES'
			ELSE
				'MÁS DE 9 MESES'
		END AS periodo
		FROM usuarios AS USU
		INNER JOIN clientes as CLI
		ON USU.id_usuario = CLI.id_asesor
		INNER JOIN (SELECT idLote, idCliente, idCondominio,
					CASE 
						WHEN totalNeto2 IS NULL OR totalNeto2 = 0 THEN
							total
						ELSE
							totalNeto2
					END AS total_lotes
					FROM lotes) AS LO
		ON CLI.idLote = LO.idLote
		INNER JOIN condominios AS CO
		ON CO.idCondominio = LO.idCondominio
		INNER JOIN residenciales AS RES
		ON RES.idResidencial = CO.idResidencial
		WHERE CLI.status = 1 AND USU.estatus = 1
		GROUP BY USU.id_usuario, CLI.id_asesor,
		CASE 
			WHEN DATEDIFF(MONTH, USU.fecha_creacion, DATETIMEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), DAY(GETDATE()), 23, 59, 59, 999)) BETWEEN 0 AND 3 THEN 
				'3 MESES' 
			WHEN DATEDIFF(MONTH, USU.fecha_creacion, DATETIMEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), DAY(GETDATE()), 23, 59, 59, 999)) BETWEEN 4 AND 6 THEN 
				'6 MESES'
			WHEN DATEDIFF(MONTH, USU.fecha_creacion, DATETIMEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), DAY(GETDATE()), 23, 59, 59, 999)) BETWEEN 7 AND 9 THEN 
				'9 MESES'
			ELSE
				'MÁS DE 9 MESES'
		END, CONCAT(USU.nombre, ' ', USU.apellido_paterno, ' ', USU.apellido_materno), USU.fecha_creacion
		HAVING (SUM(LO.total_lotes) <= 500000 )
		ORDER BY periodo");
		return $query;
	}
	public function GetInfoDetalleVta($id_asesor){
		$query = $this->db->query("SELECT CAST(RE.descripcion AS varchar) AS proyecto, CO.nombre AS condominio, 
		LO.nombreLote AS nombreLote, LO.idLote AS idLote, FORMAT(LO.total_lotes, 'C') AS total_lotes
		FROM clientes AS CL
		INNER JOIN (SELECT idLote, idCliente, idCondominio, nombre_lote, nombreLote,
					CASE 
						WHEN totalNeto2 IS NULL OR totalNeto2 = 0 THEN
							total
						ELSE
							totalNeto2
					END AS total_lotes
					FROM lotes) AS LO
		ON CL.idLote = LO.idLote
		INNER JOIN condominios AS CO
		ON LO.idCondominio = CO.idCondominio
		INNER JOIN residenciales AS RE
		ON CO.idResidencial = RE.idResidencial
		WHERE CL.id_asesor = $id_asesor AND CL.status = 1");
		return $query;
	}

	public function editDireccionOficce($idDireccion, $direccionOffice){
		$query = $this->db->query("UPDATE direcciones SET nombre = '$direccionOffice' WHERE id_direccion = '$idDireccion'");

		return $query;
	}

	public function statusOffice($idDireccion, $status){
		$status = $status == 0 ? 1 : 0;
		$query = $this->db->query("UPDATE direcciones SET estatus = '$status' WHERE id_direccion = '$idDireccion'");

		return $query;
	}

	public function addDireccionOficce($direccion, $idSede, $inicio, $fin){
		$idUsuario = $this->session->userdata('id_usuario');
		$query = $this->db->query("INSERT INTO direcciones VALUES ('$idSede', '$direccion', '1', '$inicio', '$fin', '1', GETDATE(), '$idUsuario')");

		return $query;
	}
}
