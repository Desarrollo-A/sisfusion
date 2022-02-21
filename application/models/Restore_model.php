<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restore_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function return_status_uno($idCliente){
        $query4 = $this->db->query("SELECT idStatusContratacion, idMovimiento, perfil, comentario, usuario,
		                            modificado, fechaVenc,
									idLote FROM historial_lotes WHERE idHistorialLote = (SELECT max(idHistorialLote) FROM historial_lotes WHERE idCliente = '$idCliente');");
        $row = $query4->result();
        $idstatus = $row[0]->idStatusContratacion;
        $idmovimiento  = $row[0]->idMovimiento;
        $perfil = $row[0]->perfil;
        $idlote = $row[0]->idLote;   		
		$comentario = $row[0]->comentario;
        $usuario = $row[0]->usuario;
        $modificado = $row[0]->modificado;
        $fechaVenc = $row[0]->fechaVenc;
        $query9 = $this->db->query("UPDATE historial_enganche SET status=0 WHERE idLote='$idlote';");
        $query = $this->db->query("UPDATE historial_enganche SET status=1 WHERE idCliente='$idCliente' AND idLote='$idlote';");
        $query2 = $this->db->query("UPDATE historial_documento SET status=0 WHERE idLote='$idlote';");
        $query8 = $this->db->query("UPDATE historial_documento SET status=1 WHERE idCliente='$idCliente' AND idLote='$idlote';");
        $query7 = $this->db->query("UPDATE historial_lotes SET status=0 WHERE idLote='$idlote';");
        $query3 = $this->db->query("UPDATE historial_lotes SET status=1 WHERE idCliente='$idCliente' AND idLote='$idlote';");
        
        $queryAuditoria = $this->db->query("WITH cte AS(
            SELECT
                col_afect
                ,MAX(fecha_creacion) as fecha_creacion
            FROM auditoria WHERE id_parametro = $idlote AND tabla = 'lotes'
            AND col_afect IN ('tipo_venta', 'registro_comision', 'ubicacion', 'ubicacion_dos', 'totalNeto2') 
            GROUP BY col_afect
        )
        SELECT
            t.anterior
            ,cte.*
        FROM cte
        INNER JOIN auditoria t ON t.col_afect = cte.col_afect AND t.fecha_creacion = cte.fecha_creacion");
        $rowAuditoria= $queryAuditoria->result_array();
        $AND = "";
        if(count($rowAuditoria) > 0){
            foreach($rowAuditoria as $row){
                if($row['col_afect'] == 'tipo_venta'){
                    $param = $row['anterior'];

                    $AND .= ", tipo_venta =  $param";
                }elseif($row['col_afect'] == 'registro_comision'){
                    $param = $row['anterior'];

                    $AND .= ", registro_comision =  $param";
                }elseif($row['col_afect'] == 'ubicacion'){
                    $param = $row['anterior'];

                    $AND .= ", ubicacion =  $param";
                }elseif($row['col_afect'] == 'totalNeto2'){
                    $param = $row['anterior'];

                    $AND .= ", totalNeto2 =  $param";
                }
                elseif($row['col_afect'] == 'ubicacion_dos'){
                    $param = $row['anterior'];
                    $AND .= ", ubicacion_dos = $param";
                }
            }
        }

        $query5 = $this->db->query("UPDATE lotes SET idStatusContratacion = '$idstatus', idMovimiento = '$idmovimiento', perfil = '$perfil', usuario = 1,
									modificado = '$modificado', fechaVenc = '$fechaVenc',
									status=1, idCliente='$idCliente', comentario = '$comentario', idStatusLote = 3 $AND WHERE idLote = '$idlote';");
        $query6 = $this->db->query("UPDATE clientes SET status=0 WHERE idLote='$idlote';");
        $query10 = $this->db->query("UPDATE clientes SET status=1, modificado_por=1 WHERE id_cliente='$idCliente' AND idLote='$idlote';");

    }
}