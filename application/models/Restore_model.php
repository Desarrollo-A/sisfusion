<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restore_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function return_status_uno($idCliente){
        $this->db->trans_begin();

        $query4 = $this->db->query("SELECT idStatusContratacion, idMovimiento, perfil, comentario, usuario,
		                            modificado, fechaVenc,
									idLote FROM historial_lotes WHERE idHistorialLote = (SELECT max(idHistorialLote) FROM historial_lotes WHERE idCliente = '$idCliente');");
        $row = $query4->result();
        $totalNeto2=0;
        $registroComision=0;
        $modificado_por=$this->session->userdata('id_usuario');
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
                ,MAX(fecha_creacion) as fecha_creacion, id_parametro
            FROM auditoria WHERE id_parametro = $idlote AND tabla = 'lotes'
            AND col_afect IN ('tipo_venta', 'registro_comision', 'ubicacion', 'ubicacion_dos', 'totalNeto2') 
            GROUP BY col_afect, id_parametro
        )
        SELECT
            t.anterior
            ,cte.*
        FROM cte
        INNER JOIN auditoria t ON t.col_afect = cte.col_afect AND t.fecha_creacion = cte.fecha_creacion AND t.id_parametro = cte.id_parametro");
        $rowAuditoria= $queryAuditoria->result_array();
        $AND = "";
        if(count($rowAuditoria) > 0){
            foreach($rowAuditoria as $row){
                if($row['col_afect'] == 'tipo_venta'){
                    $param = $row['anterior'];

                    $AND .= ", tipo_venta =  $param";
                }elseif($row['col_afect'] == 'registro_comision'){
                    $param = $row['anterior'];
                    $registroComision=$param;
                    $AND .= ", registro_comision =  $param";
                }elseif($row['col_afect'] == 'ubicacion'){
                    $param = $row['anterior'];

                    $AND .= ", ubicacion =  $param";
                }elseif($row['col_afect'] == 'totalNeto2'){
                    $param = $row['anterior'];
                    $totalNeto2 = $param;
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

        /*---------COMISIONES---------- */
        $queryComisiones = $this->db->query("SELECT c.*,pci.pagado,pc.porcentaje_abono
            FROM comisiones c
            INNER JOIN (SELECT SUM(abono_neodata) pagado,id_comision FROM pago_comision_ind GROUP BY id_comision) pci ON pci.id_comision=c.id_comision
            INNER JOIN pago_comision pc ON pc.id_lote=c.id_lote 
            WHERE id_lote = $idlote AND idCliente = $idCliente;")->result_array();

        if(count($queryComisiones) > 0){
            $sumaTotalComision= ($queryComisiones[0]['pagado'] / 100) * $totalNeto2;
            //SI HAY COMISIONES SE REGRESAN LAS COMISIONES
            $this->db->query("UPDATE comisiones set comision_total=((porcentaje_decimal / 100) * $totalNeto2),estatus=1,modificado_por=$modificado_por WHERE id_lote = $idlote AND idCliente = $idCliente;");
                $pendiente = $sumaTotalComision - $queryComisiones[0]['pagado'];
                $this->db->query("UPDATE pago_comision SET 
                            total_comision=$sumaTotalComision,pagado=".$queryComisiones[0]['pagado'].",bandera=$registroComision,modificado_por='$modificado_por',pendiente=$pendiente 
                            WHERE id_lote=$idlote;");
        }
        /**-------FIN COMISIONES-------- */



        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }
}