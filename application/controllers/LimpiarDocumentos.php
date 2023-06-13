<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
// LimpiarDocumentos/LimpiarCarpetas
class LimpiarDocumentos extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
  }

  public function index()
  {
    
    $DirectorioExpediente = array();  
    $DirectorioCorrida = array();  
    $DirectorioContrato = array();  

    $DirectorioExpediente = $this->db->query("SELECT DISTINCT(hd.expediente) from historial_documento hd WHERE hd.modificado < '2023-01-01' AND hd.tipo_doc = 0");
    $DirectorioCorrida = $this->db->query("SELECT DISTINCT(hd.expediente) from historial_documento hd WHERE hd.modificado < '2023-01-01' AND hd.tipo_doc = 7");
    $DirectorioContrato = $this->db->query("SELECT DISTINCT(hd.expediente) from historial_documento hd WHERE hd.modificado < '2023-01-01' AND hd.tipo_doc = 8");
    $facturasComisiones = $this->db->query("SELECT DISTINCT(fa.nombre_archivo) from facturas fa WHERE fa.fecha_ingreso < '2023-01-01'");

        if($DirectorioExpediente->num_rows() > 0){
            foreach( $DirectorioExpediente->result() as $row ){
                if (file_exists('./static/documentos/cliente/expediente/'.$row->expediente)) {
                    echo 'OK EXPEDIENTE'.$row->expediente.'<br>';
                    unlink('./static/documentos/cliente/expediente/'.$row->expediente);
                    
                } else{
                    echo 'NOT FOUND FILE EXPEDIENTE'.$row->expediente.'<br>';
                }
            }
        } else{ 
             echo 'ERROR, NO ENTRA AL PROCESO EXPEDIENTE';
        }

        if($DirectorioCorrida->num_rows() > 0){
            foreach( $DirectorioCorrida->result() as $row ){
                if (file_exists('./static/documentos/cliente/corrida/'.$row->expediente)) {
                    echo 'OK CORRIDA'.$row->expediente.'<br>';
                    unlink('./static/documentos/cliente/corrida/'.$row->expediente);
                    
                } else{
                    echo 'NOT FOUND FILE CORRIDA'.$row->expediente.'<br>';
                }
            }
        }else{ 
            
            echo 'ERROR, NO ENTRA AL PROCESO CORRIDA';
        }

        if($DirectorioContrato->num_rows() > 0){
            foreach( $DirectorioContrato->result() as $row ){
                if (file_exists('./static/documentos/cliente/contrato/'.$row->expediente)) {
                    unlink('./static/documentos/cliente/contrato/'.$row->expediente);
                            echo 'OK CONTRATO'.$row->expediente.'<br>';

                } else{
                    echo 'NOT FOUND FILE CONTRATO'.$row->expediente.'<br>';
                }
            }
        }else{ 
             
            echo 'ERROR, NO ENTRA AL PROCESO CONTRATO';
        }

        if($facturasComisiones->num_rows() > 0){
            foreach( $facturasComisiones->result() as $row ){
                if (file_exists('./UPLOADS/XMLS/'.$row->factura)) {
                    unlink('./UPLOADS/XMLS/'.$row->factura);
                            echo 'OK FACTURAS'.$row->factura.'<br>';

                } else{
                    echo 'NOT FOUND FILE FACTURAS'.$row->factura.'<br>';
                }
            }
        }else{ 
             
            echo 'ERROR, NO ENTRA AL PROCESO FACTURAS';
        }

    }


}
