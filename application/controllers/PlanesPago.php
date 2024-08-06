<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class PlanesPago extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('PlanesPagoModel');
    }

    public function original($lote){
        $plan = $this->PlanesPagoModel->getPlanesPagoOriginal($lote);

        echo json_encode($plan);
    }

    public function plan($lote){
        $plan = $this->PlanesPagoModel->getPlanesPago($lote);

        echo json_encode($plan);
    }

    private function pago_actual($planes){
        foreach ($planes as $num_plan => $plan) {
            $pagos = json_decode($plan->dumpPlan);

            $saldo_insoluto = $plan->monto;

            foreach ($pagos as $num_pago => $pago) {
                if(!isset($pago->pagado)){
                    return [$num_plan, $num_pago, $saldo_insoluto];
                }

                $saldo_insoluto = $pago->capital;
            }
        }
    }

    private function aplicar_pago($pago){
        
    }

    private function mandar_pago($pago){
        return true;
    }

    private function calcular_pago($pago, $data, $saldo, $monto){
        $fecha_pactada = DateTime::createFromFormat("d-m-Y", $pago->fecha);
        $fecha_pago = new DateTime(date('Y-m-d', strtotime($data->fecha)));
        $interval = $fecha_pactada->diff($fecha_pago);

        $dias_atraso = 0;
        if(!$interval->invert){
            $dias_atraso = $interval->days + 1;
        }
        
        $moratorios = ( ($saldo * 0.04) / 30 ) * $dias_atraso;

        $pago->moratorios = $moratorios;

        if($monto > $pago->moratorios){
            $monto -= $pago->moratorios;
        }

        if($monto > $pago->saldoInteres){
            $monto -= $pago->saldoInteres;
        }

        if($monto < $pago->capital){
            $pago->capital = $monto;
        }

        $monto -= $pago->total;

        return [$pago, $monto];
    }

    private function insertar_pago($pagos, $num_pago, $monto){
        $viejo = $pagos[$num_pago];

        $restante = (object) [
            'fecha' => $viejo->fecha,
            'planPago' => $viejo->planPago,
            'pago' => 0,
            'capital' => $monto * -1,

        ];

        array_splice(
            $pagos,
            $num_pago + 1,
            0,
            [$restante]
        );

        foreach ($pagos as $key => $pago) {
            $pago->pago = $key + 1;
        }

        return $pagos;
    }

    public function registrar_pago($lote){
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->fecha)){
            echo json_encode([
                'status' => 'Error',
                'message' => 'Datos incompletos',
            ]);
            exit;
        }

        $planes = $this->PlanesPagoModel->getPlanesPago($lote);

        $monto = $data->monto;

        while(true){
            [$num_plan, $num_pago, $saldo] = $this->pago_actual($planes);

            $pagos = json_decode($planes[$num_plan]->dumpPlan); 

            $pago = $pagos[$num_pago];

            [$pago, $monto] = $this->calcular_pago($pago, $data, $saldo, $monto);

            $is_ok = $this->mandar_pago($pago);

            if($is_ok){
                $pago->pagado = 1;
                $pagos[$num_pago] = $pago;

                if($monto < 0){
                    $pagos = $this->insertar_pago($pagos, $num_pago, $monto);
                }

                $planes[$num_plan]->dumpPlan = json_encode($pagos);
            }

            if($monto <= 0){
                print_r($planes[$num_plan]->dumpPlan);

                break;
            }
        }

        #Guardar plan de pagos
    }
}

?>