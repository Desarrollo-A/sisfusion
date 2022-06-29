<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class PaquetesCorrida_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getTipoDescuento()
    {
        return $this->db->query("select * from tipos_condiciones where id_tcondicion in(1,2,5,12,13)")->result_array();
    }
    public  function get_lista_sedes(){
    return $this->db->query("SELECT * FROM sedes where id_sede in(1,2,3,4,5,6,9) ORDER BY nombre");
    }
    
    public function getResidencialesList($id_sede)
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion, empresa FROM residenciales WHERE status = 1 and sede_residencial=$id_sede ORDER BY nombreResidencial ASC")->result_array();
    }
    public function getDescuentosPorTotal($tdescuento,$id_condicion,$eng_top,$apply)
    {
        return $this->db->query("SELECT id_tdescuento,inicio,fin,id_condicion,eng_top,apply,max(id_descuento) AS id_descuento,porcentaje 
        FROM descuentos WHERE id_tdescuento = $tdescuento AND id_condicion = $id_condicion AND eng_top = $eng_top AND apply = $apply and inicio is null 
        group by id_tdescuento,inicio,fin,id_condicion,eng_top,apply,porcentaje 
        order by porcentaje");
    }

    public function UpdateLotes($desarrollos,$cadena_lotes,$query_superdicie,$query_tipo_lote,$usuario){
        $this->db->query("UPDATE  l  
        set l.id_descuento = '$cadena_lotes',usuario='$usuario'
        from lotes l
        inner join condominios c on c.idCondominio=l.idCondominio 
        inner join residenciales r on r.idResidencial=c.idResidencial
        where r.idResidencial in($desarrollos) 
        $query_superdicie
        $query_tipo_lote"); 
    }

    public function insertBatch($table, $data)
    {
      $row = $this->db->insert_batch($table, $data);
        if ($row === FALSE) { 
            return false;
        } else { 
            return true;
        }
    }

    public function getDescuentos($tdescuento,$id_condicion,$eng_top,$apply)
    {
        return $this->db->query("SELECT c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,max(d.id_descuento) AS id_descuento,d.porcentaje 
        FROM descuentos d
		INNER JOIN condiciones c on c.id_condicion=d.id_condicion
		WHERE d.id_tdescuento = $tdescuento 
		AND d.id_condicion = $id_condicion 
		AND d.eng_top = $eng_top 
		AND d.apply = $apply
		and d.inicio is null 
        group by c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,d.porcentaje 
        order by d.porcentaje");
    }
    public function SaveNewDescuento($tdescuento,$id_condicion,$eng_top,$apply,$descuento){
      $response =  $this->db->query("INSERT INTO descuentos VALUES($tdescuento,NULL,NULL,$id_condicion,$descuento,$eng_top,$apply,NULL)"); 
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
    public function ValidarDescuento($tdescuento,$id_condicion,$eng_top,$apply,$descuento)
    {
        return $this->db->query("SELECT c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,max(d.id_descuento) AS id_descuento,d.porcentaje 
        FROM descuentos d
		INNER JOIN condiciones c on c.id_condicion=d.id_condicion
		WHERE d.id_tdescuento = $tdescuento 
		AND d.id_condicion = $id_condicion 
		AND d.eng_top = $eng_top 
		AND d.apply = $apply
        AND d.porcentaje=$descuento
		and d.inicio is null 
        group by c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,d.porcentaje 
        order by d.porcentaje");
    }



}
