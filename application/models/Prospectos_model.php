<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Prospectos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    function getProspectsList(){
        ini_set('memory_limit', -1);
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');
        $id_lider = $this->session->userdata('id_lider');
        $where = "WHERE";

        $and = "AND ((pr.lugar_prospeccion != 6) OR (pr.fecha_creacion > '2022-01-19 23:59:59.999' AND pr.lugar_prospeccion = 6))";
        if ($id_rol == 3) // MJ: GERENTE
            $where = "pr.id_gerente = $id_usuario";
        else if ($id_rol == 6) { // MJ: ASISTENTE DE GERENTE
            if ($id_usuario == 10270) // ANDRES BARRERA VENEGAS
                $where = "pr.id_gerente IN ($id_lider, 113) AND pr.id_sede IN (4, 13)";
            else if ($id_usuario == 12318) // EMMA CECILIA MALDONADO RAMÍREZ
                $where = "pr.id_gerente IN ($id_lider, 11196, 5637, 2599, 1507) AND pr.id_sede IN (8, 10)";
            else
                $where = "pr.id_gerente = $id_lider";
        }
        else if ($id_rol == 9) // MJ: COORDINADOR
            $where = "(pr.id_asesor = $id_usuario OR pr.id_coordinador = $id_usuario)";
        else if ($id_rol == 7) { // MJ: ASESOR
            $and = "";
            if ($id_usuario == 6578) // MJ: COREANO VLOGS
                $where = "pr.lugar_prospeccion IN (26)";
            else if ($id_usuario == 9942) // MJ: BADABUN
                $where = "pr.lugar_prospeccion IN (33)";
            else if ($id_usuario == 11750) // MJ: FLACO CON SUERTE
                $where = "pr.lugar_prospeccion IN (43)";
            else if ($id_usuario == 13151) // MJ: LOS BEZARES
                $where = "pr.lugar_prospeccion IN (48)";
            else
                $where = "pr.id_asesor = $id_usuario";
        }

        return $this->db->query("SELECT pr.id_prospecto, UPPER(CONCAT (pr.nombre, ' ', pr.apellido_paterno, ' ', pr.apellido_materno)) AS nombre, pr.vigencia,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) asesor, 
        UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) coordinador, 
        UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) gerente, 
        UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) subdirector, 
        UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) regional,
        UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) regional_2,
        CONVERT(varchar, pr.fecha_creacion, 20) fecha_creacion, pr.fecha_vencimiento, pr.estatus, pr.estatus_particular, pr.lugar_prospeccion , UPPER(oxc.nombre) AS nombre_lp, pr.id_asesor, pr.telefono, pr.telefono_2,
        pr.source, pr.editProspecto, CASE WHEN CAST(pr.id_dragon AS VARCHAR(25)) = 0 THEN 'NO DISPONIBLE' ELSE CAST(pr.id_dragon AS VARCHAR(25)) END id_dragon, lugar_prospeccion, becameClient
        FROM prospectos pr
        INNER JOIN usuarios u0 ON u0.id_usuario = pr.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = pr.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = pr.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = pr.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = pr.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = pr.id_regional_2
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pr.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE $where AND pr.tipo = 0 $and ORDER BY pr.fecha_creacion DESC");
    }

    function getSedesProspectos(){
        return $this->db->query("SELECT id_sede, nombre FROM sedes ORDER BY nombre");
    }

    function saveComment($id_usuario, $id_prospecto, $comentario) {
	    if ($id_prospecto != '' && $comentario) {
            $response = $this->db->insert("observaciones", array(
                "id_prospecto" => $id_prospecto,
                "observacion" => $comentario,
                "creado_por" => $id_usuario
            ));
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
	        return 0;
        }
    }

    function getProspectInformation($id_prospecto){
        return $this->db->query("SELECT * FROM prospectos WHERE id_prospecto = ".$id_prospecto."");
    }
    
    function getAsesor($sede){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 7 AND id_sede ='$sede' AND estatus = 1 ORDER BY nombre");
    }

    function getCoordinador($sede){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 9 AND id_sede ='$sede' AND estatus = 1 ORDER BY nombre");
    }

    function getGerentes($sede){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 3 AND id_sede = '$sede' AND estatus = 1 ORDER BY nombre");
    }

    function getSubdirector($sede){
        return $this->db->query("SELECT us.id_usuario, rus.idUsuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, us.id_sede, id_rol 
		FROM usuarios us INNER JOIN (SELECT DISTINCT(idUsuario) idUsuario FROM roles_x_usuario WHERE idRol = 2) rus ON rus.idUsuario = us.id_usuario
		WHERE id_rol = 2 AND estatus = 1 ORDER BY nombre");
    }

    function getDirectorRegional($sede){
        return $this->db->query("SELECT us.id_usuario, rus.idUsuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, us.id_sede, id_rol 
		FROM usuarios us
		INNER JOIN (SELECT DISTINCT(idUsuario) idUsuario FROM roles_x_usuario WHERE idRol = 59) rus ON rus.idUsuario = us.id_usuario
		WHERE id_rol = 2 AND estatus = 1 ORDER BY nombre");
    }

    function getCatalogs(){
        return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (5, 7, 9, 10, 11, 18, 19, 38) AND estatus = 1 ORDER BY id_catalogo, 
        (CASE id_catalogo WHEN 9 THEN (CASE id_opcion WHEN 31 THEN ' ' WHEN 6 THEN '' ELSE nombre END) WHEN 11 THEN (CASE id_opcion WHEN 0 THEN '' ELSE nombre END) ELSE nombre END)"); 
    }

    function getInformationToPrint($id_prospecto){
        return $this->db->query(
            "SELECT p.id_prospecto, p.id_asesor, p.id_coordinador, p.id_gerente,
                    CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS  nombre, 
                    oxc.nombre AS personalidad_juridica,
                    p.rfc, p.curp, p.correo, p.telefono, 
                    p.telefono_2, p.observaciones,
                    oxc2.nombre AS lugar_prospeccion, 
                    P.otro_lugar,
                    oxc3.nombre AS plaza_venta, 
                    oxc4.nombre AS nacionalidad,
                    us.telefono tel_asesor,
                    us2.telefono tel_coordinador,
                    us3.telefono tel_gerente,
                    CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS asesor, 
                    CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) AS coordinador,
                    CONCAT(us3.nombre, ' ', us3.apellido_paterno, ' ', us3.apellido_materno) AS gerente,
                    p.observaciones
            FROM prospectos p 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = p.personalidad_juridica AND oxc.id_catalogo = 10
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = p.lugar_prospeccion AND oxc2.id_catalogo = 9
            LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = p.plaza_venta AND oxc3.id_catalogo = 5
            LEFT JOIN opcs_x_cats oxc4 ON oxc4.id_opcion = p.nacionalidad AND oxc4.id_catalogo = 11
            LEFT JOIN usuarios us ON us.id_usuario = p.id_asesor
            LEFT JOIN usuarios us2 ON us2.id_usuario = p.id_coordinador
            LEFT JOIN usuarios us3 ON us3.id_usuario = p.id_gerente
            WHERE p.id_prospecto = $id_prospecto");
    }

    function updateProspect($data, $id_prospecto) {

        $response = $this->db->update("prospectos", $data, "id_prospecto = $id_prospecto");

            return $finalAnswer = 1;
        

    }

    function getComments($prospecto){
        return $this->db->query("SELECT observacion, CONVERT(varchar, fecha_creacion, 20) AS fecha_creacion, creador
            FROM observaciones
            INNER JOIN (SELECT id_usuario AS id_creador, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS creador FROM usuarios) AS creadores ON creadores.id_creador = observaciones.creado_por
            WHERE id_prospecto = $prospecto  ORDER BY fecha_creacion DESC");
    }
    
    function getChangelog($prospecto){
        return $this->db->query("SELECT CONVERT(VARCHAR,fecha_creacion,20) AS fecha_creacion, isNULL(creador, cambios.creado_por) creador, UPPER(parametro_modificado) AS parametro_modificado,UPPER((
            CASE 
                WHEN parametro_modificado = 'NACIONALIDAD' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 11)
                WHEN parametro_modificado = 'PERSONALIDAD JURÍDICA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 10)
                WHEN parametro_modificado = 'ASESOR' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN parametro_modificado = 'SEDE' THEN (SELECT nombre FROM sedes WHERE id_sede = nuevo)
                WHEN parametro_modificado = 'COORDINADOR' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN parametro_modificado = 'GERENTE' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = nuevo)
                WHEN parametro_modificado = 'TIPO' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 8)
                WHEN parametro_modificado = 'LUGAR DE PROSPECCIÓN' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 9)
                WHEN parametro_modificado = 'PLAZA DE VENTA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 5)
                WHEN parametro_modificado = 'ZONA DE VENTA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 6)
                WHEN parametro_modificado = 'MÉTODO DE PROSPECCIÓN' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 7)
                WHEN parametro_modificado = 'ESTADO CIVIL' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 18)
                WHEN parametro_modificado = 'RÉGIMEN MATRIMONIAL' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 19)
                WHEN parametro_modificado = 'TIPO VIVIENDA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 20)
                WHEN parametro_modificado = 'ESTATUS VIGENCIA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 3)
                WHEN parametro_modificado = 'ESTATUS PROSPECTO' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = nuevo AND id_catalogo = 38)
                ELSE nuevo  
            END)) AS nuevo,UPPER((
            CASE 
                WHEN parametro_modificado = 'NACIONALIDAD' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 11)
                WHEN parametro_modificado = 'PERSONALIDAD JURÍDICA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 10)
                WHEN parametro_modificado = 'ASESOR' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN parametro_modificado = 'SEDE' THEN (SELECT nombre FROM sedes WHERE id_sede = anterior)
                WHEN parametro_modificado = 'COORDINADOR' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN parametro_modificado = 'GERENTE' THEN (SELECT CONCAT( apellido_paterno,' ',apellido_materno,' ',nombre) as nombre FROM usuarios WHERE id_usuario = anterior)
                WHEN parametro_modificado = 'TIPO' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 8)
                WHEN parametro_modificado = 'LUGAR DE PROSPECCIÓN' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 9)
                WHEN parametro_modificado = 'PLAZA DE VENTA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 5)
                WHEN parametro_modificado = 'ZONA DE VENTA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 6)
                WHEN parametro_modificado = 'MÉTODO DE PROSPECCIÓN' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 7)
                WHEN parametro_modificado = 'ESTADO CIVIL' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 18)
                WHEN parametro_modificado = 'RÉGIMEN MATRIMONIAL' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 19)
                WHEN parametro_modificado = 'TIPO VIVIENDA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 20)
                WHEN parametro_modificado = 'ESTATUS VIGENCIA' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 3)
                WHEN parametro_modificado = 'ESTATUS PROSPECTO' THEN (SELECT nombre FROM opcs_x_cats WHERE id_opcion = anterior AND id_catalogo = 38)
                ELSE anterior  
            END)) AS anterior
            FROM cambios
            LEFT JOIN (SELECT id_usuario AS id_creador, CONCAT(nombre, ' ', apellido_paterno,' ',apellido_materno) AS creador  FROM usuarios) AS creadores ON CAST(id_creador as VARCHAR(45)) = creado_por
            WHERE id_prospecto = $prospecto ORDER BY fecha_creacion DESC");
    }

    function getPrintableInformation($id_prospecto)
    {
        return $this->db->query("SELECT id_prospecto, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS cliente, rfc, telefono, telefono_2, correo, personalidad, nacionalidades.nacionalidad, 
        REPLACE(curp, '<', '') AS curp,
                                lugar, otro_lugar, plaza, asesor, telefono_asesor, gerente, telefono_gerente, coordinador, telefono_coordinador, CONCAT(creador, ' ', fecha_creacion) as creacion, p.id_sede, p.id_coordinador, p.id_gerente FROM prospectos p
                                LEFT JOIN (SELECT id_opcion AS id_personalidad, nombre AS personalidad FROM opcs_x_cats WHERE id_catalogo LIKE 10) AS personalidades ON personalidades.id_personalidad = p.personalidad_juridica
                                LEFT JOIN (SELECT id_opcion AS id_nacionalidad, nombre AS nacionalidad FROM opcs_x_cats WHERE id_catalogo LIKE 11) AS nacionalidades ON nacionalidades.id_nacionalidad = p.nacionalidad
                                LEFT JOIN (SELECT id_opcion AS id_lugar, nombre AS lugar FROM opcs_x_cats WHERE id_catalogo LIKE 9) AS lugares ON lugares.id_lugar = p.lugar_prospeccion
                                LEFT JOIN (SELECT id_opcion AS id_plaza, nombre AS plaza FROM opcs_x_cats WHERE id_catalogo LIKE 5) AS plazas ON plazas.id_plaza = p.plaza_venta
                                LEFT JOIN (SELECT id_usuario AS id_asesor, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS asesor, telefono AS telefono_asesor FROM usuarios) AS asesores ON asesores.id_asesor = p.id_asesor
                                LEFT JOIN (SELECT id_usuario AS id_gerente, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS gerente, telefono AS telefono_gerente FROM usuarios) AS gerentes ON gerentes.id_gerente = p.id_gerente
                                LEFT JOIN (SELECT id_usuario AS id_coordinador, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS coordinador, telefono AS telefono_coordinador FROM usuarios) AS coordinadores ON coordinadores.id_coordinador = p.id_coordinador
                                LEFT JOIN (SELECT id_usuario AS id_creador, CONCAT(apellido_paterno, ' ', apellido_materno, ' ', nombre) AS creador FROM usuarios) AS creadores ON creadores.id_creador = p.creado_por
                                WHERE id_prospecto = $id_prospecto");
    }

    function getProspectSpecification($id_prospecto){
        return $this->db->query("SELECT ISNULL(p.id_prospecto, '') prospecto, ISNULL(p.otro_lugar, '') especificar FROM prospectos p 
                                WHERE p.id_prospecto = $id_prospecto AND p.lugar_prospeccion IN (3, 6, 7, 9, 10)");
    }

    function getRole($id_asesor)
    {
        return $this->db->query("SELECT id_rol, id_sede FROM usuarios WHERE id_usuario = $id_asesor");
    }

    function getSalesPartnerInformation($id_prospecto, $tipo)
    {
        return $this->db->query("SELECT spi.id_sale, spi.id_prospecto, spi.tipo,
                                CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) coordinador, u.telefono telefono_coordinador,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) gerente, uu.telefono telefono_gerente
                                FROM sales_partner_inf spi 
                                LEFT JOIN usuarios u ON u.id_usuario = spi.id_coordinador
                                LEFT JOIN usuarios uu ON uu.id_usuario = spi.id_gerente
                                WHERE spi.id_prospecto = $id_prospecto AND spi.tipo = $tipo");
    }

}