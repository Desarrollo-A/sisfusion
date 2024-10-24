<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Neodata_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->programacion2 = $this->load->database('programacion2', TRUE);
    }

    public function addUpdateClienteNeoData($data) {
        $messageDetail = $data['accion'] == "upd" ? "actualizado" : "insertado";
        $fechaNacimiento = "'" . $data['FechaNacimiento'] . "'";
        $Cliente = "'" . $data['Cliente'] . "'";
        $response = $this->programacion2->query("EXEC [programacion].[dbo].[CDM300ClientesNeoD]
        @accion = '" . $data['accion'] . "',
        @Cliente = " . ($data['Cliente'] == '' ? 'NULL' : $Cliente) . ",
        @IdProyecto = " . $data['IdProyecto'] . ",
        @IdVivienda = " . $data['IdVivienda'] . ",
        @IdCredito = " . $data['IdCredito'] . ",
        @IdEstado = " . ($data['IdEstado'] == '' ? 'NULL' : $data['IdEstado']) . ",
        @IdEtapaCliente = " . $data['IdEtapaCliente'] . ",
        @IdMedio = " . $data['IdMedio'] . ",
        @Nombre = '" . $data['Nombre'] . "',
        @ApellidoPaterno = '" . $data['ApellidoPaterno'] . "',
        @ApellidoMaterno = '" . $data['ApellidoMaterno'] . "',
        @Calle = '" . ($data['Calle'] == '' ? 'NULL' : $data['Calle']) . "',
        @Colonia = '" . ($data['Colonia'] == '' ? 'NULL' :$data['Colonia']) . "',
        @CodPost = '" . ($data['CodPost'] == '' ? 'NULL' : $data['CodPost']) . "',
        @MpioDeleg = '" . ($data['MpioDeleg'] == '' ? 'NULL' : $data['MpioDeleg']) . "',
        @Localidad = '" . ($data['Localidad'] == '' ? 'NULL' : $data['Localidad']) . "',
        @Telefono = '" . $data['Telefono'] . "',
        @Email = '" . $data['Email'] . "',
        @RFC = '" . $data['RFC'] . "',
        @FechaNacimiento = " . ($data['FechaNacimiento'] == '' ? 'NULL' : $fechaNacimiento) . ",
        @FechaIngreso = '" . $data['FechaIngreso'] . "',
        @NumOficial = " . ($data['NumOficial'] == '' ? 'NULL' : $data['NumOficial']) . ",
        @NumInterior = " . ($data['NumInterior'] == '' ? 'NULL' : $data['NumInterior']) . ",
        @Sexo = " . ($data['Sexo'] == '' ? 'NULL' : $data['Sexo']) . ",
        @Notas = " . ($data['Notas'] == '' ? 'NULL' : $data['Notas']) . ",
        @IdCEtapa = " . $data['IdCEtapa'] . ",
        @FechaAsignacionVivienda = '" . $data['FechaAsignacionVivienda'] . "',
        @Cancelado = " . $data['Cancelado'] . ",
        @Escriturado = " . $data['Escriturado'] . ",
        @TelefonoCelular = " . ($data['TelefonoCelular'] == '' ? 'NULL' : $data['TelefonoCelular']) . ",
        @FechaRegistro = '" . $data['FechaRegistro'] . "',
        @TelefonosConfirmados = " . $data['TelefonosConfirmados'] . ",
        @FechaUltimoContacto = '" . $data['FechaUltimoContacto'] . "',
        @Referencia = " . $data['Referencia'] . ",
        @FechaFichaRapApartado = '" . $data['FechaFichaRapApartado'] . "',
        @IdSofolSolicitada = " . $data['IdSofolSolicitada'] . ",
        @IdCuentaMoratorios = " . ($data['IdCuentaMoratorios'] == '' ? 'NULL' : $data['IdCuentaMoratorios']) . ",
        @IdCuentaIntereses = " . ($data['IdCuentaIntereses'] == '' ? 'NULL' : $data['IdCuentaIntereses']) . ",
        @NoCuentaContable = " . ($data['NoCuentaContable'] == '' ? 'NULL' : $data['NoCuentaContable']) . ",
        @EscrituradoReal = " . $data['EscrituradoReal'] . ",
        @IdTipoMoneda = " . ($data['IdTipoMoneda'] == '' ? 1 : $data['IdTipoMoneda']) . ",
        @Lada = " . ($data['Lada'] == '' ? 'NULL' : $data['Lada']) . ",
        @Pais = " . ($data['Pais'] == '' ? 'NULL' : $data['Pais']) . ",
        @MonedaSATDefault = '" . $data['MonedaSATDefault'] . "',
        @IdCodigoPostalSAT = " . ($data['IdCodigoPostalSAT'] == '' ? 'NULL' : $data['IdCodigoPostalSAT']) . ",
        @IdPaisSAT = " . $data['IdPaisSAT'] . ",
        @IdCatRegimen = " . ($data['IdCatRegimen'] == '' ? 'NULL' : $data['IdCatRegimen']) . ",
        @CuentaClabeSTP = " . ($data['CuentaClabeSTP'] == '' ? 'NULL' : $data['CuentaClabeSTP']) . ",
        @Prospecto = " . $data['Prospecto'] . "")->result_array();
        
        if (isset($response[0]['idCliente']))
            return array("status" => 1, "message" => "Registro $messageDetail con éxito.", "idCliente" => $response[0]['idCliente'], "Cliente" => $response[0]['Cliente']);
        else {
            if (!isset($response[0]['ErrorNumber']))
                return array("status" => -1, "message" => $response[0]['msj'], "idCliente" => 0, "Cliente" => 0);
            else
                return array("status" => -1, "message" => $response[0]['ErrorNumber'] . " - " . $response[0]['ErrorMessage'], "idCliente" => 0, "Cliente" => 0);
        }
    }

    public function cancelaPlanPagoNeo($data){

        $nombreLote = $data['nombreLoteCancelado'];
        $numeroPlanLote = $data['numeroPlanLoteCancelado'];

//        print_r($nombreLote);
////        echo '<br>';
////        print_r($numeroPlanLote);
////        exit;

//        $messageDetail = $data['accion'] == "upd" ? "actualizado" : "insertado";
        /**/$response = $this->db->query("
        EXEC [192.168.16.23].[programacion].[dbo].[CDM302CancelarPlanPago]
        @empresa = N'FRO2',
        @lote = N'$nombreLote',
        @numPlanPagoCRM = $numeroPlanLote 
        ")->result_array();
        return array("responseGeneral" => $response);

//        if (isset($response[0]['idCliente']))
//            return array("status" => 1, "message" => "Registro $messageDetail con éxito - " . $response[0]['idCliente'] . ".");
//        else
//            return array("status" => -1, "message" => $response[0]['ErrorNumber'] . " - " . $response[0]['ErrorMessage']);
    }
}
