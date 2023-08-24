<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caja_model extends CI_Model {

   public function __construct() {
      parent::__construct();
   }

   public function getReporteLotesBloqueados() {
      return $this->db-> query("SELECT re.descripcion nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.sup, FORMAT(lo.precio, 'C') precioM2, FORMAT(lo.total, 'C') total,
      lo.referencia, lo.motivo_change_status, ISNULL(CONVERT(varchar, lo.fecha_modst, 105), 'SIN ESPECIFICAR') fechaBloqueo,
      CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END bloqueadoPara
      FROM lotes lo
      INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
      INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
      LEFT JOIN usuarios u0 ON u0.id_usuario = lo.idAsesor
      WHERE lo.status = 1 AND lo.idStatusLote = 8")->result_array();
   }

   public function getLotesParticulares() {
      return $this->db-> query("SELECT re.descripcion nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.sup, FORMAT(lo.precio, 'C') precioM2, 
      FORMAT(lo.total, 'C') total, lo.referencia, sl.color, sl.background_sl, sl.nombre nombreEstatusLote, ISNULL(cl.nombre, 'SIN ESPECIFICAR') clausulas, tv.tipo_venta, 
      ISNULL(cl.id_clausula, 0) id_clausula
      FROM lotes lo
      INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
      INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
      INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
	   LEFT JOIN clausulas cl ON cl.id_lote = lo.idLote AND cl.estatus = 1
      INNER JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
      WHERE lo.status = 1 AND lo.tipo_venta = 1")->result_array();
   }

}