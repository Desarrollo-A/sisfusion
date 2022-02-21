<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administracion_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }



	public function get_datos_lote_11 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, l.totalNeto, l.fechaSolicitudValidacion,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		  cond.idCondominio, cl.expediente

	    FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial

		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario


         where  l.idStatusContratacion = '10' and l.idMovimiento  = '40' and cl.status = 1
                or l.idStatusContratacion = '10' and l.idMovimiento  = '10' and cl.status = 1
                or l.idStatusContratacion = '8' and l.idMovimiento  = '67' and cl.status = 1
                OR l.idStatusContratacion = '12' and l.idMovimiento  = '42'  and l.validacionEnganche = 'NULL' and cl.status = 1
                OR l.idStatusContratacion = '12' and l.idMovimiento  = '42'  and l.validacionEnganche IS NULL and cl.status = 1

 			  
	     GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, l.totalNeto, l.fechaSolicitudValidacion,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,
      
         concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
         concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
         concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
         cond.idCondominio, cl.expediente");

		return $query->result();

	}



    public function get_datos_admon($condominio){
    	return $this->db->query("SELECT lot.idCliente, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, lot.comentarioLiberacion, lot.fechaLiberacion, 
                                con.idCondominio, lot.sup as superficie, lot.saldo, lot.precio, lot.enganche, lot.porcentaje, lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
                                sl.nombre as descripcion_estatus, sl.color FROM [lotes] lot 
                                INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
                                INNER JOIN [statuslote] sl ON sl.idStatusLote = lot.idStatusLote WHERE lot.idCondominio = ".$condominio."");
    }



	public function validateSt11($idLote){
      $this->db->where("idLote",$idLote);
      $this->db->where_in('idStatusLote', 3);
  
      $this->db->where("(idStatusContratacion = 10 and idMovimiento  = 40
            OR idStatusContratacion = 10 and idMovimiento = 10
            OR idStatusContratacion = 8 and idMovimiento = 67
            OR idStatusContratacion = 12 and idMovimiento = 42 and validacionEnganche = 'NULL'
            OR idStatusContratacion = 12 and idMovimiento = 42 and validacionEnganche IS NULL )");	
  
      $query = $this->db->get('lotes');
      $valida = (empty($query->result())) ? 0 : 1;
      return $valida;
  
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
  
	   public function get_data_asignacion($idLote){
		return $this->db->query("SELECT id_estado, id_desarrollo_n FROM lotes WHERE idLote = $idLote")->row();
	  }

	  public function get_edo_lote(){
		return $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 44")->result_array();
	  }
	  
	  public function get_des_lote(){
		return $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 45")->result_array();
	  }

	  public function update_asignacion($idLote,$data){
		$this->db->where("idLote",$idLote);
		$this->db->update('lotes',$data);
		return true;
	 }
  
 
}
