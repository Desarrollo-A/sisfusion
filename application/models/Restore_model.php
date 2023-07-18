<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restore_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function updateLote($datos){
        $this->db->trans_begin();
        $replace = ["$", ","];
        $update = '';
        $idCliente = $datos['idCliente'];
        $totalValidado = !isset($datos['totalValidado']) ? "N/A" : $datos['totalValidado'] ;
        $update .= $totalValidado == "N/A" ? "" : ', totalValidado='.str_replace($replace,"",$totalValidado) ;
        $comentario = !isset($datos['comentario']) ? "N/A" : $datos['comentario'] ;
        $update .= $comentario == "N/A" ? "" : ", comentario='".$comentario."'";
        $tipo_venta = $datos['tipo_venta'];
        $ubicacion = $datos['ubicacion'];
        $totalNetoPost =!isset($datos['totalNeto']) ? "N/A" : $datos['totalNeto'] ;
        $update .= $totalNetoPost == "N/A" ? "" : ", totalNeto=".str_replace($replace,"",$totalNetoPost);
        $totalNeto2Post = !isset($datos['totalNeto2']) ? "N/A" : $datos['totalNeto2'];
        $update .= $totalNeto2Post == "N/A" ? "" : ", totalNeto2=".str_replace($replace,"",$totalNeto2Post);
        $idLote = $datos['idLote'];
        $modificado_por=$this->session->userdata('id_usuario');
        if($totalNeto2Post != "N/A"){
            $this->RecarcalcularComisiones($idLote,$idCliente,str_replace($replace,"",$totalNeto2Post),$modificado_por,1);
        }

        $this->db->query("UPDATE lotes SET ubicacion=$ubicacion,tipo_venta=$tipo_venta, usuario=$modificado_por $update 
        WHERE idLote = $idLote;");

        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function return_status_uno($datos){
        $replace = ["$", ","];
        $this->db->trans_begin();
        $idCliente = $datos['idCliente'];
        $totalValidado = !isset($datos['totalValidado']) ? "N/A" : $datos['totalValidado'] ;
        $comentarioPost = !isset($datos['comentario']) ? "N/A" : $datos['comentario'] ;
        $tipo_venta = !isset($datos['tipo_venta']) ? "N/A" : $datos['tipo_venta'];
        $ubicacion = !isset($datos['ubicacion']) ? "N/A" : $datos['ubicacion'];
        $totalNeto2Post = !isset($datos['totalNeto2']) ? "N/A" : $datos['totalNeto2'] ;
        $totalNetoPost = !isset($datos['totalNeto']) ? "N/A" : $datos['totalNeto'] ;

        $query4 = $this->db->query("SELECT idStatusContratacion, idMovimiento, perfil, comentario, usuario,
		                            modificado, fechaVenc,
									idLote FROM historial_lotes WHERE idHistorialLote = (SELECT max(idHistorialLote) FROM historial_lotes WHERE idCliente = '$idCliente');");
        $row = $query4->result();
        $totalNeto2=0;
        $registroComision=0;
        $modificado_por=$this->session->userdata('id_usuario');
        $idstatus = $row[0]->idStatusContratacion;
        $idmovimiento = $row[0]->idMovimiento;
        $perfil = $row[0]->perfil;
        $idlote = $row[0]->idLote;   		 
		$comentario = $comentarioPost == 'N/A' ? $row[0]->comentario : $comentarioPost;
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
            AND col_afect IN ('tipo_venta', 'registro_comision', 'ubicacion', 'ubicacion_dos', 'totalNeto2','totalNeto','totalValidado') 
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
                    $param = $tipo_venta == 'N/A' ?  $row['anterior'] : $tipo_venta;
                    $AND .= ", tipo_venta =  $param";
                }elseif($row['col_afect'] == 'registro_comision'){
                    $param = $row['anterior'];
                    $registroComision=$param;
                    $AND .= ", registro_comision =  $param";
                }elseif($row['col_afect'] == 'ubicacion'){
                    $param = $ubicacion == 'N/A' ? $row['anterior'] : $ubicacion;
                    $AND .= ", ubicacion =  $param";
                }elseif($row['col_afect'] == 'totalNeto2'){
                    $param = $totalNeto2Post == 'N/A' ? $row['anterior'] : str_replace($replace,"",$totalNeto2Post);
                    $totalNeto2 = $param;
                    $AND .= ", totalNeto2 =  $param";
                }
                elseif($row['col_afect'] == 'ubicacion_dos'){
                    $param = $row['anterior'];
                    $AND .= ", ubicacion_dos = $param";
                }
                elseif($row['col_afect'] == 'totalNeto'){
                    $param = $totalNetoPost == 'N/A' ? $row['anterior'] : str_replace($replace,"",$totalNetoPost);
                    $AND .= ", totalNeto =  $param";
                }
                elseif($row['col_afect'] == 'totalValidado'){
                    $param = $totalValidado == 'N/A' ? $row['anterior'] : str_replace($replace,"",$totalValidado);
                    $AND .= ", totalValidado =  $param";
                }
            }
        }

        if($idstatus < 5){
            $AND = ",totalValidado=NULL,totalNeto2=NULL,totalNeto=NULL,ubicacion=0,status8Flag=0,validacionEnganche=NULL,tipo_venta=0 ";
        }/*else if(in_array($idstatus, array(5,6,7))){
            $AND = ",totalValidado=NULL,totalNeto2=NULL,totalNeto=NULL,status8Flag=0,validacionEnganche=NULL ";
        }*/



        $this->RecarcalcularComisiones($idlote,$idCliente,$totalNeto2,$modificado_por,$registroComision);
        $idStatusLote = $idstatus == 15 ? 2 : 3;
        $this->db->query("UPDATE lotes SET idStatusContratacion = '$idstatus', idMovimiento = '$idmovimiento', perfil = '$perfil', usuario = 1,
									modificado = '$modificado', fechaVenc = '$fechaVenc',
									status=1, idCliente='$idCliente', comentario = '$comentario', idStatusLote = $idStatusLote $AND 
                                    WHERE idLote = '$idlote';");
        $this->db->query("UPDATE clientes SET status=0 WHERE idLote='$idlote';");
        $this->db->query("UPDATE clientes SET status=1, modificado_por=$modificado_por WHERE id_cliente='$idCliente' AND idLote='$idlote';");


        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function RecarcalcularComisiones($idLote,$idCliente,$totalNeto2,$modificado_por,$registroComision){
                /*---------REGRESAR COMISIONES EN CASO DE TENER---------- */
                $queryComisiones = $this->db->query("SELECT SUM(pci.abono_neodata) pagado,pc.porcentaje_abono as porcentaje_abono FROM comisiones c
                INNER JOIN pago_comision_ind pci ON pci.id_comision=c.id_comision
                INNER JOIN pago_comision pc ON pc.id_lote=c.id_lote 
                WHERE c.id_lote=$idLote AND c.idCliente=$idCliente
                GROUP BY c.id_lote,pc.porcentaje_abono")->result_array();
    
            if(count($queryComisiones) > 0){
                $sumaTotalComision= ($queryComisiones[0]['porcentaje_abono'] / 100) * $totalNeto2;
                //SI HAY COMISIONES SE REGRESAN LAS COMISIONES
                $this->db->query("UPDATE comisiones set comision_total=((porcentaje_decimal / 100) * $totalNeto2),estatus=1,modificado_por=$modificado_por WHERE id_lote = $idLote AND idCliente = $idCliente;");
                    $pendiente = $sumaTotalComision - $queryComisiones[0]['pagado'];
                    $this->db->query("UPDATE pago_comision SET 
                                total_comision=$sumaTotalComision,abonado=".$queryComisiones[0]['pagado'].",bandera=$registroComision,modificado_por='$modificado_por',pendiente=$pendiente 
                                WHERE id_lote=$idLote;");
            }
            /**-------FIN COMISIONES-------- */
    }
}