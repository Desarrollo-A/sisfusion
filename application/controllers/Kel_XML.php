<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Kel_XML extends CI_Controller
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
    redirect(base_url());
  }


    public function descargar_XML(){

        if( $this->session->userdata('id_rol') == 31 ){
        $filtro = " pci.estatus IN (8) ";
      }
      else{
        $filtro = " pci.estatus IN (4,8) ";
      }


          $facturas_disponibles = array(); ;

                  $facturas_disponibles = $this->db->query("SELECT DISTINCT(fa.nombre_archivo) from facturas fa
                  INNER JOIN pago_comision_ind pci ON fa.id_comision = pci.id_pago_i
                  WHERE $filtro
                  GROUP BY fa.nombre_archivo
                  ORDER BY fa.nombre_archivo");
                   
          if( $facturas_disponibles->num_rows() > 0 ){

               $this->load->library('zip');
              $nombre_documento = 'FACTURAS_INTERNOMEX_'.date("YmdHis").'.zip';
              
              foreach( $facturas_disponibles->result() as $row ){
                // echo '<br>'.$row->nombre_archivo;
                  $this->zip->read_file( './UPLOADS/XMLS/'.$row->nombre_archivo );
              }
              
              $this->zip->archive( $nombre_documento );
              $this->zip->download( $nombre_documento );

          }else{
              echo 'no entra';
          }
          
  }

    public function descargar_PDF(){
          $facturas_disponibles = array(); ;

                  $facturas_disponibles = $this->db->query("SELECT DISTINCT(opn.archivo_name) from opinion_cumplimiento opn WHERE opn.estatus in (1,2) ORDER BY opn.archivo_name");
                   
          if( $facturas_disponibles->num_rows() > 0 ){
              $this->load->library('zip');
              $nombre_documento = 'PDF_INTERNOMEX_'.date("YmdHis").'.zip';
              
              foreach( $facturas_disponibles->result() as $row ){
                  $this->zip->read_file( './static/documentos/cumplimiento/'.$row->archivo_name );
              }
              
              $this->zip->archive( $nombre_documento );
              $this->zip->download( $nombre_documento );

          }else{
              echo 'no entra';
          }
          
  }
    // public function verificacion(){
    // $datos = $this->Comisiones_model->getLotesPagados()->result_array();
    
    // if(count($datos) > 0)
    // {
    // $data = array();
    // $final_data = array();
    // $contador = 0;
    
    // for($i = 0; $i < COUNT($datos); $i++){
    // // print_r ($datos[$i]['referencia']);
    // //print_r ($datos[$i]['referencia']);
    
    // $data[$i] = $this->Comisiones_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
    // if(!empty($data)){
    
    // if($data[$i]->Marca == 1){
    
    // //print_r ("aplicado".$data[$i]->Aplicado);
    // //print_r ("ultimo".$datos[$i]['ultimo_pago']);
    // if($data[$i]->Aplicado > $datos[$i]['ultimo_pago']){
    // //$final_data[$contador] = $this->Comisiones_model->getLoteInformation($datos[$i]['idLote']);
    // //ACTUALIZAR
    // echo $datos[$i]['id_lote'];
    // $this->Comisiones_model->UpdateBanderaPagoComision($datos[$i]['id_lote']);
    // $contador ++;
    
    
    // }else{
    // echo "NO";
    // }
    // }
    
    
    
    // }
    
    // }
    // }
    
    // }




}
