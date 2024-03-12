<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prospectos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getListaProspectos($beginDate, $endDate, $tipoUsuario) {
        $idUsuario = $this->session->userdata('id_usuario');
        if ($tipoUsuario == 7) // BUSCA PROSPECTOS COMO ASESOR
            $validacionPorTipoUsuario = "AND pr.id_asesor = $idUsuario";
        else if ($tipoUsuario == 9) // BUSCA PROSPECTOS COMO COORDINADOR
            $validacionPorTipoUsuario = "AND pr.id_coordinador = $idUsuario";
        else if ($tipoUsuario == 3) // BUSCA PROSPECTOS COMO GERENTE
            $validacionPorTipoUsuario = "AND pr.id_gerente = $idUsuario";
        else if ($tipoUsuario == 2) // BUSCA PROSPECTOS COMO SUBDIRECTOR
            $validacionPorTipoUsuario = "AND pr.id_subdirector = $idUsuario";
        else if ($tipoUsuario == 59) // BUSCA PROSPECTOS COMO DIRECTOR REGIONAL
            $validacionPorTipoUsuario = "AND (pr.id_regional = $idUsuario OR pr.id_regional_2 = $idUsuario)";

        return $this->db->query(
            "SELECT
                pr.id_prospecto idProspecto,
                UPPER(CONCAT(pr.nombre, ' ', pr.apellido_paterno, ' ', pr.apellido_materno)) nombreProspecto,
                CASE WHEN (pr.correo IS NULL OR pr.correo = '') THEN 'SIN ESPECIFICAR' ELSE pr.correo END correo,
                pr.telefono,
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
                CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2,
                CASE WHEN oxc0.nombre LIKE '%especificar%' THEN CONCAT(REPLACE(oxc0.nombre, ' (especificar)', '<br>'), '<small><i>', CASE WHEN pr.otro_lugar = '0' THEN 'SIN ESPECIFICAR' ELSE pr.otro_lugar END, '</i></small>') ELSE oxc0.nombre END lugarProspeccion,
                CONVERT(varchar, pr.fecha_creacion, 105) fechaAlta
            FROM prospectos pr
            LEFT JOIN usuarios u0 ON u0.id_usuario = pr.id_asesor
            LEFT JOIN usuarios u1 ON u1.id_usuario = pr.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = pr.id_gerente
            LEFT JOIN usuarios u3 ON u3.id_usuario = pr.id_subdirector
            LEFT JOIN usuarios u4 ON u4.id_usuario = pr.id_regional
            LEFT JOIN usuarios u5 ON u5.id_usuario = pr.id_regional_2
            INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = pr.lugar_prospeccion AND oxc0.id_catalogo = 9
            WHERE
                pr.tipo = 0
                AND pr.lugar_prospeccion != 6
                AND pr.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'
                $validacionPorTipoUsuario
            ORDER BY
                pr.fecha_creacion
            "
        )->result_array();
    }

    public function getRoles() {
        return $this->db->query(
            "SELECT 
                * 
            FROM opcs_x_cats 
            WHERE 
                estatus = 1 
                AND id_opcion IN (7, 3, 9, 2, 59) 
                AND id_catalogo IN (1) 
            ORDER BY 
                CASE id_opcion 
                    WHEN 7 THEN 0 
                    WHEN 9 THEN 1 
                    WHEN 3 THEN 2 
                    WHEN 2 THEN 3 
                    WHEN 59 THEN 4 
                END
            "
        )->result_array();
    }

    public function getListaUsuarios() {
        return $this->db->query(
            "SELECT
                id_rol id_catalogo,
                id_usuario id_opcion,
                UPPER(CONCAT(id_usuario, ' - ', nombre, ' ', apellido_paterno, ' ', apellido_materno)) nombreUsuario
            FROM usuarios
            WHERE
                estatus = 1
                AND id_rol IN (7, 9, 3, 2)
                AND rfc NOT LIKE '%TSTDD%' 
                AND ISNULL(correo, '') NOT LIKE '%test_%' 
                AND ISNULL(correo, '') NOT LIKE '%OOAM%'
            ORDER BY
                CASE id_rol 
                    WHEN 7 THEN 0 
                    WHEN 9 THEN 1 
                    WHEN 3 THEN 2 
                    WHEN 2 THEN 3 
                END,
                nombre,
                apellido_paterno,
                apellido_materno
            "
        )->result_array();
    }

    public function aplicarReAsignacion($datosParaActualizar, $idProspecto) { 
        if ($datosParaActualizar != '' && $datosParaActualizar != null) {
            $response = $this->db->update("prospectos", $datosParaActualizar, "id_prospecto IN ($idProspecto)");
            if ($response)
                return true;
            else
                return false;
        } else
            return false;
    }
    
}
