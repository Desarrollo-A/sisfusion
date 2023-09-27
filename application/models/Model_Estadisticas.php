<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_Estadisticas extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function get_managers_by_asis($user){
		$sedes = $this->session->userdata("id_sede");/*("inicio_sesion")['sede']*/
		return $this->db->query("SELECT u.id_usuario, u.id_rol, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) 
        AS nombrecompleto FROM usuarios u WHERE FIND_IN_SET(u.id_sede, '$sedes')
        AND u.id_rol = 3 AND u.estatus = 1");
	}


	function get_managers($user){

		return $this->db->query("SELECT id_usuario, id_rol, UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)) AS nombrecompleto
        FROM usuarios WHERE id_lider IN (SELECT id_usuario FROM usuarios WHERE id_lider = '$user') AND id_rol = 3");

	}

	function get_managers_bysubdir($user){
		$sedes = $this->session->userdata("id_sede") ; /*("inicio_sesion")['sede'] */
		return $this->db->query("SELECT u.id_usuario, u.id_rol, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) 
        AS nombrecompleto FROM usuarios u WHERE FIND_IN_SET(u.id_sede, '$sedes')
        AND u.id_rol = 3 AND u.estatus = 1");
	}

	function get_managers_bydir($user){
		$sedes = $this->session->userdata("id_sede"); /*("inicio_sesion")['sede']*/
		return $this->db->query("SELECT u.id_usuario, u.id_rol, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) 
        AS nombrecompleto FROM usuarios u, (SELECT @pv := (SELECT id_sede FROM usuarios WHERE id_usuario = '$user')) sd
        WHERE FIND_IN_SET(u.id_sede, @pv)
        AND u.id_rol = 3 AND u.estatus = 1");
	}

	function get_asesores($user){

		return $this->db->query("SELECT DISTINCT c.id_asesor AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) 
        AS nombre_asesores FROM clientes c INNER JOIN usuarios u WHERE c.id_gerente = '$user' AND
        c.id_asesor = u.id_usuario AND u.id_rol = 7");

	}


	function get_asesoresbygerente($user){

		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',
        u.apellido_materno)) 
        AS nombre_asesores FROM usuarios u WHERE (u.id_lider = '$user' AND u.id_rol = 7) OR
        (u.id_usuario = '$user')");

	}

	function get_coordinadoresbygerente($user){

		return $this->db->query("SELECT id_usuario AS id_coordinadores,  UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ',
        apellido_materno)) 
        AS nombre_coordinadores FROM usuarios WHERE id_lider = '$user' AND id_rol = 9 AND estatus = 1;");

	}

	function get_coordinadoresbyasis($user){

		return $this->db->query("SELECT id_usuario AS id_coordinadores,  UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ',
        apellido_materno)) 
        AS nombre_coordinadores FROM usuarios WHERE id_lider IN
(SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND id_rol = 9 AND estatus = 1;");

	}

	function get_asesores_bycoord($coordinador,$user){
		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',
        u.apellido_materno)) 
        AS nombre_asesores FROM usuarios u WHERE u.estatus = 1 AND ( (u.id_lider = '$coordinador' AND u.id_rol = 7)  OR (u.id_usuario IN (SELECT id_usuario FROM usuarios WHERE id_lider = $user AND id_rol = 6)) 
         OR (u.id_usuario = '$user'))");
	}

	function get_asesores_coord($user){
		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',
        u.apellido_materno)) 
        AS nombre_asesores FROM usuarios u WHERE u.estatus = 1 AND ((u.id_lider = '$user' AND u.id_rol = 7) OR
        (u.id_usuario = '$user'))");
	}

	function get_asesores_asis($user){
		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',
        u.apellido_materno)) 
        AS nombre_asesores FROM usuarios u WHERE (u.id_lider IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user')
        AND u.id_rol = 7 OR u.id_usuario IN (SELECT id_lider FROM usuarios where id_usuario = '$user'))");
	}

	function get_asesores_sede($sede){
		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
        AS nombre_asesores, u.nombre FROM usuarios u WHERE (id_rol IN (3, 6, 7, 9)) AND id_sede = '$sede' ORDER BY u.nombre");
	}

	function get_asesores_bycoord_asis($coordinador,$user){
		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',
        u.apellido_materno)) 
        AS nombre_asesores FROM usuarios u WHERE u.estatus = 1 AND ( (u.id_lider = '$coordinador' AND u.id_rol = 7) OR u.id_usuario = '$user' OR
        u.id_usuario IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user'));");
	}

	function get_clientes($user, $tipo ){
		$current_year = date("Y");
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) 
        AS mes, COUNT(id_cliente) AS clientes FROM sisgphco_crm.clientes WHERE tipo = 0 AND id_asesor = '$user' AND
        (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') 
        GROUP BY mes ORDER BY MONTH(fecha_creacion)");

	}

	function get_chart($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
         COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.tipo = '$tipo' AND c.id_asesor = '$user' AND c.id_gerente = '$currentuser') 
         AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chartuser($user, $tipo, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.tipo = '$tipo' AND c.id_asesor = '$user') 
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chartmkt($asesor, $sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.id_asesor = '$asesor' AND c.id_sede = '$sede' AND c.otro_lugar = '$lugar') 
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_repomkt($asesor, $sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo, 
        c.telefono AS Telefono, 
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'Sin especificar', c.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede 
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_asesor = '$asesor' AND c.id_sede = '$sede' AND c.otro_lugar = '$lugar')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        AND oc.id_opcion = 6
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion");
	}

	function get_chartmkt3($asesor, $sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.id_asesor = '$asesor' AND c.id_sede = '$sede' AND lugar_prospeccion = 6) 
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_repomkt3($asesor, $sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo, 
        c.telefono AS Telefono, 
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'Sin especificar', c.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON (c.territorio_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_asesor = '$asesor' AND c.id_sede = '$sede' AND c.lugar_prospeccion = 6)
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion");
	}

	function get_chartmkt5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (lugar_prospeccion = 6)
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo' 
	WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio' 
	WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' 
	WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre' WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' 
	WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre' END mes, 
	COUNT(id_prospecto) AS clientes FROM prospectos 
	WHERE (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_repomkt5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'Sin especificar', c.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (lugar_prospeccion = 6)
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON (p.plaza_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE ( lugar_prospeccion = 6)
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_repomkt1($sede, $lugar, $fecha_ini, $fecha_fin){ //reporte con lugar y sede especificos
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'Sin especificar', c.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_sede = '$sede' AND otro_lugar = '$lugar')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON (p.plaza_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (p.id_sede = '$sede' AND otro_lugar = '$lugar')
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_chartmkt1($sede, $lugar, $fecha_ini, $fecha_fin){
		return $this->db->query("
		SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE  (id_sede = '$sede' AND otro_lugar = '$lugar')  
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
	COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.id_sede = '$sede' AND otro_lugar = '$lugar')
	AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
	}

	function get_chartmkt4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.otro_lugar = '$lugar')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE  (otro_lugar = '$lugar')  
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartmkt6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.id_sede = '$sede' AND lugar_prospeccion = 6)
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
        GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE  (id_sede = '$sede' AND lugar_prospeccion = 6)  
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_repomkt6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'Sin especificar', c.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_sede = '$sede' AND lugar_prospeccion = 6)
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON (p.plaza_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (p.id_sede = '$sede' AND lugar_prospeccion = 6)
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_repomkt4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'Sin especificar', c.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.otro_lugar = '$lugar')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON (p.plaza_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (p.otro_lugar = '$lugar')
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_chartuser2($user, $tipo, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes  
        WHERE id_asesor = '$user' AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	/*function get_chart2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser, $coordinador){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes,
		COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes
		WHERE id_asesor = '$user' AND id_gerente = '$currentuser' AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
		GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}*/

	function get_chart2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser, $coordinador){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes  
        WHERE id_asesor = '$user' AND id_gerente = '$currentuser' AND (id_coordinador = '$coordinador' OR id_coordinador = '$user' OR id_coordinador = '$currentuser' )
        AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_chart_subdir($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.tipo = '$tipo' AND c.id_asesor = '$user' AND c.id_gerente = '$gerente') 
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $currentuser)
        GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chart_subdir2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes, 
       COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes  
       WHERE id_asesor = '$user' AND id_gerente = '$gerente' AND id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $currentuser) AND
       (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_chart_subdir_asis($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.tipo = '$tipo' AND c.id_asesor = '$user' AND c.id_gerente = '$gerente') 
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $currentuser)
        GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chart_subdir_asis2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes, 
    COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes  
    WHERE id_asesor = '$user' AND id_gerente = '$gerente' AND id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $currentuser) AND
    (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_chart_asisger($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.tipo = '$tipo' AND c.id_asesor = '$user' )
        AND c.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$currentuser')  
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chart_coord($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c WHERE (c.tipo = '$tipo' AND c.id_asesor = '$user' AND c.id_coordinador = '$currentuser' )
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chart_coord2($user, $fecha_ini, $fecha_fin, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes  
       WHERE id_asesor = '$user' AND id_coordinador = '$currentuser'
       AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_chart_asisger2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion), 1)), SUBSTRING(MONTHNAME(fecha_creacion), 2)) AS mes, 
       COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes  
       WHERE id_asesor = '$user' AND id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$currentuser') 
       AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_total_gerente($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.tipo = '$tipo' AND c.id_gerente = '$user') AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' 
        AND '$current_year/12/31 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_mkt(){
		$current_year = date("Y");
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT (*) clientes
                                FROM prospectos
                                WHERE (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                AND lugar_prospeccion = 6
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_total_coordinador($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.tipo = '$tipo' AND c.id_coordinador = '$user') AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' 
        AND '$current_year/12/31 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_gerente1($gerente, $tipo, $fecha_ini, $fecha_fin){ //get clientes o prospectos por gerente
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.tipo = '$tipo' AND c.id_gerente = '$gerente') AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_coordinador1($gerente, $coordinador, $tipo, $fecha_ini, $fecha_fin){ //get clientes o prospectos por coordinador
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.tipo = '$tipo' AND c.id_gerente = '$gerente' AND c.id_coordinador = '$coordinador') AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_coordinador_asis1($user, $coordinador, $tipo, $fecha_ini, $fecha_fin){ //get clientes o prospectos por coordinador siendo asistente
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.tipo = '$tipo' AND c.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user' AND id_rol = 6)
        AND c.id_coordinador = '$coordinador') AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_coordinador2($gerente, $coordinador, $fecha_ini, $fecha_fin){ //get clientes y prospectos por coordinador
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes c 
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.id_gerente = '$gerente' AND c.id_coordinador = '$coordinador') AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_coordinadorasis2($user, $coordinador, $fecha_ini, $fecha_fin){ //get clientes y prospectos por coordinador siendo asistente
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes c 
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user' AND id_rol = 6))
        AND c.id_coordinador = '$coordinador' AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_gerente2($gerente, $fecha_ini, $fecha_fin){ //get clientes y prospectos por gerente
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes c 
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.id_gerente = '$gerente') AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_chart_gerente($user, $tipo, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, COUNT(id_cliente) AS clientes FROM sisgphco_crm.clientes WHERE (tipo = '$tipo' AND id_asesor = '$user') AND
        fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_chart_dirbyase($user, $tipo, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, COUNT(id_cliente) AS clientes FROM sisgphco_crm.clientes WHERE (tipo = '$tipo' AND id_asesor = '$user') AND
        fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_all_dir($tipo, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, COUNT(id_cliente) AS clientes FROM sisgphco_crm.clientes 
        WHERE tipo = '$tipo' AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_alldir($fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes
         FROM sisgphco_crm.clientes WHERE fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59' GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_chart_dirbyase1($user, $tipo, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes
         FROM sisgphco_crm.clientes WHERE (id_asesor = '$user') AND
        (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_total_director(){
		$current_year = date("Y");
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, COUNT(id_cliente) AS clientes FROM sisgphco_crm.clientes 
        WHERE (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND tipo = 0  GROUP BY mes ORDER BY MONTH(fecha_creacion)");
	}

	function get_lider($user){
		return $this->db->query("SELECT id_lider FROM usuarios WHERE id_usuario = '$user'");
	}

	function get_mkt_dig(){
		/*
		 * SELECT  otro_lugar, IF(otro_lugar = '0', 'Sin especificar', otro_lugar) AS lugares
			FROM .clientes WHERE lugar_prospeccion = 6  GROUP BY otro_lugar ORDER BY otro_lugar
		 * */
		return $this->db->query("SELECT otro_lugar, CASE
      WHEN otro_lugar = '0' 
               THEN 'Sin especificar'
               ELSE otro_lugar
       END as lugares
FROM prospectos
WHERE lugar_prospeccion = 6 GROUP BY otro_lugar ORDER BY otro_lugar;");
	}

	function get_sedes(){
		return $this->db->query("SELECT id_sede AS id_sede, nombre AS sede FROM sedes ORDER BY nombre");
	}

	function get_reporte_asesor($user, $fecha_ini, $fecha_fin, $tipo){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        WEEK(c.fecha_creacion) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion, 
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar) AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        se.nombre AS Sede,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario 
        FROM clientes c INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9) 
        LEFT JOIN sedes ot ON (c.territorio_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (c.id_asesor = '$user' AND c.tipo = '$tipo') AND c.fecha_creacion 
        BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_reporte_asesor_general($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        WEEK(c.fecha_creacion) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion, 
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        se.nombre AS Sede,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario 
        FROM clientes c INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9) 
        LEFT JOIN sedes ot ON (c.territorio_venta = ot.id_sede)
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (c.id_asesor = '$user' AND c.tipo = '$tipo')
         AND c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59'  ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_reporte_asesor_1($user, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        WEEK(c.fecha_creacion) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion, 
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        se.nombre AS Sede,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario 
        FROM clientes c INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9) 
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (c.id_asesor = '$user') AND c.fecha_creacion 
        BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_reporte_gerente($user){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        se.nombre AS Sede,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion AS Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.id_gerente = '$user' ) AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_gerente_general($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        se.nombre AS Sede,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion AS Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.id_gerente = '$user' and c.tipo = '$tipo') AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_coordinador($user){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        se.nombre AS Sede,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion AS Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.id_coordinador = '$user' ) AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_byger($gerente, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
         AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
         AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                 CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                 IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
AS Gerencia,
                 IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                 IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                 IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                 IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                 c.fecha_creacion AS Fecha
                 FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                 INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                 INNER JOIN sedes se ON se.id_sede = c.id_sede 
                 LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                 LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                 LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                 WHERE (c.id_gerente = '$gerente') AND
                 (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_bycoord1($gerente, $coordinador, $fecha_ini, $fecha_fin, $tipo){ //reporte por coordinador
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
         AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
         AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                 CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                 IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
AS Gerencia,
                 IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                 IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                 IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                 IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                 c.fecha_creacion AS Fecha
                 FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                 INNER JOIN sedes se ON se.id_sede = c.id_sede 
                 INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                 LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                 LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                 LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                 WHERE (c.id_gerente = '$gerente' AND c.tipo = '$tipo' AND c.id_coordinador = '$coordinador') AND
                 (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_bycoord2($gerente, $coordinador, $fecha_ini, $fecha_fin){ //reporte por coordinador
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
         AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
         AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                 CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                 IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
AS Gerencia,
                 IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                 IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                 IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                 IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                 c.fecha_creacion AS Fecha
                 FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                 INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                 INNER JOIN sedes se ON se.id_sede = c.id_sede 
                 LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                 LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                 LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                 WHERE (c.id_gerente = '$gerente' AND c.id_coordinador = '$coordinador') AND
                 (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_byger1($gerente, $fecha_ini, $fecha_fin, $tipo){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
         AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
         AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                 CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                 IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
AS Gerencia,
                 IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                 IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                 IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                 IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                 c.fecha_creacion AS Fecha
                 FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                 INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                 INNER JOIN sedes se ON se.id_sede = c.id_sede 
                 LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                 LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                 LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                 WHERE (c.id_gerente = '$gerente' AND c.tipo = $tipo) AND
                 (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion LIMIT 3000");
	}

	function get_reporte_gerente1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
       (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion AS Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.id_gerente = '$user' AND c.tipo = '$tipo' AND c.id_asesor = '$asesor') AND
                (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_reporte_coordinador1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
         AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
         AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                 CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                 IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                 IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar) AS DetalleProspeccion,
                 IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                 IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                 c.fecha_creacion AS Fecha
                 FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                 INNER JOIN sedes se ON se.id_sede = c.id_sede 
                 LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                 LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                 LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                 WHERE (c.id_coordinador = '$user' AND c.tipo = '$tipo' AND c.id_asesor = '$asesor') AND
                 (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_reporte_coordinadorgeneral1($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
         AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
         AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                 CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                 IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                 IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                 IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                 IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                 c.fecha_creacion AS Fecha
                 FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                 INNER JOIN sedes se ON se.id_sede = c.id_sede 
                 LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                 LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                 LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                 WHERE (c.id_coordinador = '$user' AND c.tipo = '$tipo') AND
                 (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_reporte_coordinador2($user, $fecha_ini, $fecha_fin, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion AS Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.id_coordinador = '$user' AND c.id_asesor = '$asesor') AND
                (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY c.fecha_creacion");
	}

	function get_reporte_asisgerente($user){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_asisgeneralgerente($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                AND c.tipo = '$tipo' ORDER BY c.fecha_creacion");
	}

	function get_reporte_asisgerente1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND (c.tipo = '$tipo' AND c.id_asesor = '$asesor')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_asisgerente2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND (c.id_asesor = '$asesor')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_gerente2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente = '$user' AND (c.id_asesor = '$asesor')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_gerente_coord2($user, $fecha_ini, $fecha_fin, $coordinador){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente = '$user' AND (c.id_coordinador = '$coordinador')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_asisgerente_coord2($user, $fecha_ini, $fecha_fin, $coordinador){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user' AND id_rol = 6) AND (c.id_coordinador = '$coordinador')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_gerente_coord1($user, $fecha_ini, $fecha_fin, $tipo, $coordinador){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente = '$user' AND c.tipo = '$tipo' AND (c.id_coordinador = '$coordinador')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_asisgerente_coord1($user, $fecha_ini, $fecha_fin, $tipo, $coordinador){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, se.nombre AS Sede, 
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) AS Asesor, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario 
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user' AND id_rol = 6) AND c.tipo = '$tipo' AND (c.id_coordinador = '$coordinador')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_total_gerente_asis($user, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE (c.tipo = '$tipo') AND c.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND
        c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59'  GROUP BY mes 
        ORDER BY MONTH(c.fecha_creacion)");
	}


	function get_reporte_dir(){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
		IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno))
        AS Gerencia, se.nombre AS Sede,
        c.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN clientes c ON t1.id_usuario = c.id_asesor
        INNER JOIN usuarios t2 ON t2.id_usuario = c.id_gerente
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
        ORDER BY c.fecha_creacion");
	}

	function get_reporte_dir_general($tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno))
         as Gerencia, se.nombre AS Sede,
        c.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN clientes c ON t1.id_usuario = c.id_asesor
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND c.tipo = '$tipo'
        ORDER BY c.fecha_creacion");
	}

	function get_reporte_dir1($fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM usuarios t1
                INNER JOIN clientes c ON t1.id_usuario = c.id_asesor
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE t1.id_rol = 7 AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (c.tipo = '$tipo' AND c.id_asesor = '$asesor')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_dir2($fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
        c.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN clientes c ON t1.id_usuario = c.id_asesor
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE t1.id_rol = 7 AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (c.id_asesor = '$asesor')
        ORDER BY c.fecha_creacion");
	}

	function get_total_subdir_byasis($user){
		$current_year = date("Y");
		$sedes = $this->session->userdata("id_sede") ; /*("inicio_sesion")['sede'] */
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, COUNT(c.id_cliente) AS clientes FROM clientes c
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE FIND_IN_SET(c.id_sede, '$sedes') AND
        (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND tipo = 0  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_subdir($user){
		$current_year = date("Y");
		$sedes = $this->session->userdata("id_sede") ; /*("inicio_sesion")['sede'] */
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, COUNT(c.id_cliente) AS clientes FROM clientes c
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE FIND_IN_SET(c.id_sede, '$sedes') AND
        (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND tipo = 0  
        GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_subdir1($subdir, $fecha_ini, $fecha_fin, $tipo){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(c.id_cliente) AS clientes FROM clientes c
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario WHERE c.id_sede IN
        (SELECT id_sede FROM usuarios WHERE id_usuario = '$subdir') AND
        (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND tipo = '$tipo' 
        GROUP BY mes ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_total_subdir2($subdir, $fecha_ini, $fecha_fin){
		return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes, 
        COUNT(IF(tipo = '0', 1, NULL)) AS prospectos, COUNT(IF(tipo = '1', 1, NULL)) AS clientes FROM clientes c 
        INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        WHERE c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$subdir') AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' 
        AND '$fecha_fin 23:59:59')  GROUP BY mes ORDER BY MONTH(c.fecha_creacion);");
	}

	function get_reporte_subdir_byasis($user){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$user')
                AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_subdir_byasisgeneral($user, $tipo){
		$current_year = date("Y");
		$sedes = $this->session-userdata("id_sede") ; /*("inicio_sesion")['sede'] */
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE FIND_IN_SET(c.id_sede, '$sedes')
                AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                AND tipo = '$tipo' ORDER BY c.fecha_creacion");
	}

	function get_reporte_subdir1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (c.tipo = '$tipo' AND c.id_asesor = '$asesor') 
                AND c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $user) ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_reporte_subdir_byasis2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$user')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (c.id_asesor = '$asesor') ORDER BY c.fecha_creacion");
	}

	function get_reporte_subdir($user){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede,
        c.fecha_creacion as Fecha
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$user')
        AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
        ORDER BY c.fecha_creacion");
	}

	function get_reporte_subdir_general($user, $tipo){
		$current_year = date("Y");
		$sedes = $this->session->userdata("id_sede") ; /*("inicio_sesion")['sede'] */
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede,
        c.fecha_creacion as Fecha
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE FIND_IN_SET(c.id_sede, '$sedes') AND c.tipo = '$tipo'
        AND (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
        ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_bysub($subdir, $fecha_ini, $fecha_fin){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
                AS Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$subdir')
                AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_bysub1($subdir, $fecha_ini, $fecha_fin, $tipo){
		$current_year = date("Y");
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
        IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno)) AS Gerencia, se.nombre AS Sede,
        c.fecha_creacion as Fecha
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$subdir')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        AND c.tipo = '$tipo'
        ORDER BY c.fecha_creacion");
	}

	function get_repo_dir_all($tipo, $fecha_ini, $fecha_fin){

		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
                AS Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                AND c.tipo = $tipo
                ORDER BY c.fecha_creacion");
	}

	function get_repo_dirall($fecha_ini, $fecha_fin){

		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año, 
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
                AS Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59' ORDER BY c.fecha_creacion");
	}

	function get_reporte_subdir_byasis1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año,
        (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE  (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (c.tipo = '$tipo' AND c.id_asesor = '$asesor')
                AND c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $user)
                ORDER BY c.fecha_creacion");
	}

	function get_reporte_subdir2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, YEAR(c.fecha_creacion) AS Año,
       (WEEK(c.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
                IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
                IF(c.otro_lugar IS NULL OR c.otro_lugar = '0', 'N/A', c.otro_lugar)AS DetalleProspeccion,
                IF(ot.nombre IS NULL, 'N/D', ot.nombre  )AS TerritorioVenta,
                IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
                CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
                CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) as Gerencia, se.nombre AS Sede,
                c.fecha_creacion as Fecha
                FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
                INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
                INNER JOIN sedes se ON se.id_sede = c.id_sede 
                LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
                LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                WHERE (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (c.id_asesor = '$asesor') 
                AND c.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $user)
                ORDER BY MONTH(c.fecha_creacion)");
	}

	function get_all_places(){
		return $this->db->query("SELECT lugar_prospeccion, 
        (CASE WHEN lugar_prospeccion = 1 THEN 'Call Picker' WHEN lugar_prospeccion = 2 THEN 'Correo electrónico' 
        WHEN lugar_prospeccion = 3 THEN 'Evento (especificar)' WHEN lugar_prospeccion = 5 
        THEN 'Facebook (chat)' WHEN lugar_prospeccion = 6 THEN 'MKT digital (especificar)' 
        WHEN lugar_prospeccion = 7 THEN 'Otro (especificar)' 
        WHEN lugar_prospeccion = 8 THEN 'Página web (chat)' 
        WHEN lugar_prospeccion = 9 THEN 'Pase (especificar)'
        WHEN lugar_prospeccion = 10 THEN 'Visita a empresas (especificar)' END) AS lugares 
        FROM prospectos WHERE lugar_prospeccion in(1,2,3,4,5,6,7,8,9,10)  GROUP BY lugar_prospeccion ORDER BY lugares;");
	}

	function get_total_lp(){
		$current_year = date("Y");
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM sisgphco_crm.clientes c
		WHERE (c.fecha_creacion BETWEEN '$current_year/01/01 00:00:00'
        AND '$current_year/12/31 23:59:59') GROUP BY mes ORDER BY MONTH(c.fecha_creacion);*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE  (fecha_creacion BETWEEN '$current_year 00:00:00' AND '$current_year/12/31 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartlp($sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.id_sede = '$sede' AND c.lugar_prospeccion = '$lugar')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE   ( lugar_prospeccion = '$lugar')
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartlp5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c WHERE
        c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("
		SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE  (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartlp4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.lugar_prospeccion = '$lugar')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE (lugar_prospeccion = '$lugar')  
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartlp1($sede, $lugar, $fecha_ini, $fecha_fin){
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.id_sede = '$sede' AND lugar_prospeccion = '$lugar')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE (id_sede = '$sede' AND lugar_prospeccion = '$lugar')
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartlp6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.id_sede = '$sede')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
        GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE (id_sede = '$sede')
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_chartlp3($sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.id_sede = '$sede')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE (id_sede = '$sede')
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}
	function get_chartlp3_5( $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
		/*SELECT CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) AS mes,
        COUNT(c.id_cliente) AS clientes
		FROM clientes c
		WHERE (c.id_sede = '$sede')
        AND c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(c.fecha_creacion)*/
		return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                 COUNT(id_prospecto) AS clientes
                                FROM prospectos
                                WHERE (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
	}

	function get_report_lp($sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (cñ.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_sede = '$sede' AND c.lugar_prospeccion = '$lugar')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        AND oc.id_opcion = 6
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede 
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");

	}

	function get_report_lp1($sede, $lugar, $fecha_ini, $fecha_fin){ //reporte con lugar y sede especificos
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_sede = '$sede' AND lugar_prospeccion = '$lugar')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE  (p.id_sede = '$sede' AND p.lugar_prospeccion = '$lugar')
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_report_lp3($sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
		return $this->db->query("SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), c.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2)) 
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente, 
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo, 
        c.telefono AS Telefono, 
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede 
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_sede = '$sede')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion");
	}

	function get_report_lp4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.lugar_prospeccion = '$lugar')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE  (p.lugar_prospeccion = '$lugar') AND
        p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_report_lp5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
		/*
		 * SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

	function get_report_lp6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
		/*SELECT c.id_cliente AS Folio, IF(c.tipo = 0, 'Prospecto', 'Cliente') AS Tipo,
        DATEDIFF(CURDATE(), c.fecha_creacion)
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(c.fecha_creacion),1)),SUBSTRING(MONTHNAME(c.fecha_creacion),2))
        AS Mes,  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS Cliente,
        IF(c.correo IS NULL, 'No especificado', c.correo) AS Correo,
        c.telefono AS Telefono,
        IF(c.telefono_2 IS NULL, 'No especificado', c.telefono_2) AS Telefono_2,
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, c.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM clientes c INNER JOIN usuarios s ON c.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON c.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = c.id_sede
        LEFT JOIN opcs_x_cats oc ON (c.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON c.territorio_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (c.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (c.id_cliente = o.id_cliente)
        WHERE (c.id_sede = '$sede')
        AND (c.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY c.id_cliente ORDER BY c.fecha_creacion*/
		return $this->db->query("SELECT p.id_prospecto AS Folio, 
		(CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, 
		YEAR(p.fecha_creacion) AS Año, 
        (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
        DATENAME(MONTH, p.fecha_creacion) AS Mes,  
        CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
		(CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
        (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
        (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
        (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
        (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
        CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
        (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
        ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
        p.fecha_creacion as Fecha
        FROM usuarios t1
        INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        WHERE  (p.id_sede = '$sede')
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
	}

//comentario
}
