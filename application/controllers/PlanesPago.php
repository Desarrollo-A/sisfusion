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

            foreach ($pagos as $num_pago =>$pago) {
                if(!isset($pago->pagado)){
                    // print_r($saldo_insoluto);

                    return [$num_plan, $num_pago, $saldo_insoluto];
                }

                $saldo_insoluto -= $pago->capital;
            }
        }
    }

    private function getMensualidadMasAlta($planes){
        $mensualidad = 0;

        foreach ($planes as $num_plan => $plan) {
            $pagos = json_decode($plan->dumpPlan);

            foreach ($pagos as $num_pago =>$pago) {
                if(!isset($pago->pagado)){
                    if($pago->total > $mensualidad){
                        $mensualidad = $pago->total;
                    }
                }
            }
        }

        return $mensualidad;
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
        
        $moratorios = round( ( ($saldo * 0.04) / 30 ) * $dias_atraso, 2, PHP_ROUND_HALF_DOWN );
        
        $pago->moratorios = $moratorios;

        $pago->fechaPago = date('d-m-Y', strtotime($data->fecha));
        $pago->capitalPactado = round($saldo, 2, PHP_ROUND_HALF_DOWN);
        $pago->saldoCapital = floatval($pago->capital);
        $pago->saldoInteres = floatval($pago->interes);

        if($pago->total > $monto){
            $pago->total = $monto;
        }

        $pago->saldoMoratiorios = round($pago->moratorios - $monto, 2, PHP_ROUND_HALF_DOWN);
        if($pago->saldoMoratiorios < 0){
            $pago->saldoMoratiorios = 0;
        }
        $monto -= $pago->moratorios;

        if($monto > 0){
            $pago->saldoInteres = $pago->interes - $monto;
            if($pago->saldoInteres < 0){
                $pago->saldoInteres = 0;
            }

            $monto -= $pago->interes;

            if($monto > 0){
                $pago->saldo = $pago->capitalPactado - $pago->capital;

                $pago->saldoCapital = round($pago->capital - $monto, 2, PHP_ROUND_HALF_DOWN);
                if($pago->saldoCapital < 0){
                    $pago->saldoCapital = 0;
                }

                $monto -= $pago->capital;
                
                if($monto < 0){
                    $monto = 0;
                }
            }
        }

        $pago->capital = round($pago->capital - $pago->saldoCapital, 2, PHP_ROUND_HALF_DOWN);
        $pago->interes = round($pago->interes - $pago->saldoInteres, 2, PHP_ROUND_HALF_DOWN);
        $pago->moratorios -= $pago->saldoMoratiorios;
        $pago->saldo = $pago->capitalPactado - $pago->capital;

        return [$pago, $monto];
    }

    private function insertar_pago_a_capital($pagos, $num_pago, $monto){
        $viejo = $pagos[$num_pago];

        $fecha = $viejo->fechaPago;
        $planPago = $viejo->planPago;
        $pago = $viejo->pago;
        $capital = $monto;
        $saldoCapital = 0;
        $interes = 0;
        $saldoInteres = 0;
        $iva = 0;
        $saldoIva = 0;
        $moratorios = 0;
        $saldoMoratiorios = 0;
        $capitalPactado = $viejo->saldo;
        $total = $monto;
        $saldo = $viejo->saldo - $monto;

        $restante = (object) [
            'fecha' => $fecha,
            'planPago' => $planPago,
            'pago' => $pago,
            'capital' => $capital,
            'saldoCapital' => $saldoCapital,
            'interes' => $interes,
            'saldoInteres' => $saldoInteres,
            'iva' => $iva,
            'saldoIva' => $saldoIva,
            // 'moratorios' => $moratorios,
            // 'fechaPago' => $fechaPago,
            // 'saldoMoratiorios' => $saldoMoratiorios,
            'capitalPactado' => $capitalPactado,
            'pagado' => 1,
            'total' => $total,
            'saldo' => $saldo,
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

    private function insertar_pago($pagos, $num_pago, $monto){
        $viejo = $pagos[$num_pago];

        $fecha = $viejo->fechaPago;
        $planPago = $viejo->planPago;
        $pago = $viejo->pago;
        $capital = $viejo->saldoCapital;
        $saldoCapital = 0;
        $interes = $viejo->saldoInteres;
        $saldoInteres = 0;
        $iva = $viejo->saldoIva;
        $saldoIva = 0;
        $moratorios = $viejo->saldoMoratiorios;
        $saldoMoratiorios = 0;
        $capitalPactado = $viejo->saldo;
        $total = floatval($viejo->saldoCapital) + floatval($viejo->saldoInteres) + floatval($viejo->saldoIva) + floatval($viejo->saldoMoratiorios);
        $saldo = $viejo->saldo - $viejo->saldoCapital;

        $restante = (object) [
            'fecha' => $fecha,
            'planPago' => $planPago,
            'pago' => $pago,
            'capital' => $capital,
            'saldoCapital' => $saldoCapital,
            'interes' => $interes,
            'saldoInteres' => $saldoInteres,
            'iva' => $iva,
            'saldoIva' => $saldoIva,
            // 'moratorios' => $moratorios,
            // 'fechaPago' => $fechaPago,
            // 'saldoMoratiorios' => $saldoMoratiorios,
            'capitalPactado' => $capitalPactado,
            // 'pagado' => $pagado,
            'total' => $total,
            'saldo' => $saldo,
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

    private function recalcularSaldoPlan($saldo, $pagos){
        foreach ($pagos as $num_pago =>$pago) {
            $saldo -= $pagos[$num_pago]->capital;
            
            $pagos[$num_pago]->saldo = $saldo;
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

                if($pago->saldoCapital > 0){
                    $pagos = $this->insertar_pago($pagos, $num_pago, $monto);
                }

                #$planes[$num_plan]->dumpPlan = json_encode($pagos);
            }

            if($data->capital){
                $mensualidad = $this->getMensualidadMasAlta($planes);

                if($monto > $mensualidad){
                    #print_r("Ingresar a capital: $monto" );
                    $pagos = $this->insertar_pago_a_capital($pagos, $num_pago, $monto);

                    #$planes[$num_plan]->dumpPlan = json_encode($pagos);

                    $monto = 0;
                }
            }

            #Guardar plan de pagos
            $planes[$num_plan]->dumpPlan = json_encode($this->recalcularSaldoPlan($planes[$num_plan]->monto, $pagos));
            $this->PlanesPagoModel->savePlanPago($planes[$num_plan]->idPlanPago, $planes[$num_plan]->dumpPlan);

            if($monto <= 0){
                print_r($planes[$num_plan]->dumpPlan);

                break;
            }

        }
    }
}

?>