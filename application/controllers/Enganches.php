<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . "/controllers/BaseController.php");

class Enganches extends BaseController {
    public function __construct() {
        parent::__construct();

        $this->load->model(array('EnganchesModel'));
    }

    public function descargar($nombre = ''){
        $time_start = microtime(true);

        $empresas = $this->EnganchesModel->getEmpresas($nombre);

        // print_r($empresas);

        $is_ok = $this->EnganchesModel->borrarEnganches();

        set_time_limit(0);

        foreach ($empresas as $key => $empresa) {

            $enganches = $this->EnganchesModel->getEnganchesPorEmpresa($empresa->empresa);

            foreach ($enganches as $key => $enganche) {
                $data = [];

                $lote = $this->EnganchesModel->getLotePorNombre($enganche['Contrato']);

                if($lote){
                    print_r($enganche);

                    $data['idLote'] = $lote->idLote;
                    $data['idCliente'] = $lote->idCliente;

                    if($enganche['¿Enganche diferido?'] == 'Contado'){
                        $data['formaPago'] = 2;
                    }else{
                        $data['formaPago'] = 1;
                    }

                    $data['fechaCreacion'] = date("Y-m-d H:i:s");
                    $data['idCreacion'] = 1;
                    $data['estatus'] = 1;
                    $data['montoEnganche'] = $enganche['montoenganche'];

                    $insert_id = $this->EnganchesModel->insertEnganche($data);

                    if($insert_id){
                        $instrumentos = explode(',', $enganche['instrumentoMonetEnganc']);
                        $fechas = explode(',', $enganche['fecha_pago']);
                        $divisas = explode(',', $enganche['divisa']);

                        foreach ($instrumentos as $key => $instrumento) {
                            $det_enganche = [];

                            $det_enganche['idEnganche'] = $insert_id;
                            $det_enganche['estatus'] = 1;
                            $det_enganche['fechaCreacion'] = date("Y-m-d H:i:s");
                            $det_enganche['idCreacion'] = 1;

                            // print_r($instrumentos);

                            switch (trim($instrumentos[$key])) {
                                case 'Transferencia':
                                    $det_enganche['instrumentoMonetario'] = 1;
                                    break;
                                case 'Efectivo':
                                    $det_enganche['instrumentoMonetario'] = 2;
                                    break;
                                default:
                                    $det_enganche['instrumentoMonetario'] = 3;
                                    break;
                            }

                            // print_r($fechas);

                            $det_enganche['fechaPago'] = date(trim($fechas[$key]));

                            // print_r($divisas);

                            switch (trim($divisas[$key])) {
                                case 'PESOS MXN':
                                    $det_enganche['monedaDivisa'] = 1;
                                    break;
                            }

                            // print_r($det_enganche);

                            $this->EnganchesModel->insertDetalleEnganche($det_enganche);

                        }
                    }
                }
            }
        }

        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start)/60;

        echo '<b>Total Execution Time:</b> '.$execution_time.' Mins';
    }

}