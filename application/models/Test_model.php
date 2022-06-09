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


    function getAdviserLeaderInformation($id_asesor)
    {
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario'); // PARA ASESOR, COORDINADOR, GERENTE, SUBDIRECTOR, REGIONAL Y DIRECCIÓN COMERCIAL
        $id_lider = $this->session->userdata('id_lider'); // PARA ASISTENTES

        if ($id_rol == 7) // MJ: Asesor
            $filter = " AND cl.id_asesor = $id_usuario";
        else if ($id_rol == 9) // MJ: Coordinador
            $filter = " AND (cl.id_asesor = $id_usuario OR cl.id_coordinador = $id_usuario)";
        else if ($id_rol == 3) // MJ: Gerente
            $filter = " AND cl.id_gerente = $id_usuario";
        else if ($id_rol == 6) // MJ: Asistente de gerencia
            $filter = " AND cl.id_gerente = $id_lider";
        else if ($id_rol == 2) // MJ: Subdirector
            $filter = " AND cl.id_subdirector = $id_usuario";
        else if ($id_rol == 5) // MJ: Asistente subdirección
            $filter = " AND cl.id_subdirector = $id_lider";
        else if ($id_rol == 2) {// MJ: Director regional
            $id_sede = "'" . implode("', '", explode(", ", $this->session->userdata('id_sede'))) . "'"; // MJ: ID sede separado por , como string
            $filter = " AND cl.id_sede IN ($id_sede)";
        }
        else if ($id_rol == 5) // MJ: Asistente de dirección regional
            $filter = ""; // MJ: PENDIENTE
        else if ($id_rol == 1 || $id_rol == 4) // MJ: Director comercial
            $filter = "";

        return $this->db->query("SELECT SUM(ISNULL(l.totalNeto2, l.total)) canceladoContratado, COUNT(*)
        totalCanceladosContratados, '1' opt FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1 AND YEAR(cl.fechaApartado) = 2021 $filter
        INNER JOIN (SELECT MAX(modificado) modificado, idLote, status FROM historial_liberacion
        GROUP BY idLote, status) hl ON hl.idLote = l.idLote AND hl.status = 1
		INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
		WHERE idStatusContratacion = 15 AND idMovimiento = 45 AND status = 1 GROUP BY idLote, idCliente) hl2 ON hl2.idLote = l.idLote 
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor
        INNER JOIN sedes s ON s.id_sede = l.ubicacion
        WHERE l.status = 1")->row();
    }
}
