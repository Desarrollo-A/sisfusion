<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Neodata_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->programacion2 = $this->load->database('programacion2', TRUE);
    }

    public function addUpdateClienteNeoData($data) {
        $response = $this->programacion2->query("EXEC [programacion2].[dbo].[CDM300ClientesNeoD]
        @accion = '" . $data['accion'] . "',
        @Cliente = '" . $data['Cliente'] . "',
        @IdProyecto = " . $data['IdProyecto'] . ",
        @IdVivienda = " . $data['IdVivienda'] . ",
        @IdCredito = " . $data['IdCredito'] . ",
        @IdEstado = " . ($data['IdEstado'] == '' ? 'NULL' : $data['IdEstado']) . ",
        @IdEtapaCliente = " . $data['IdEtapaCliente'] . ",
        @IdMedio = " . $data['IdMedio'] . ",
        @Nombre = '" . $data['Nombre'] . "',
        @ApellidoPaterno = '" . $data['ApellidoPaterno'] . "',
        @ApellidoMaterno = '" . $data['ApellidoMaterno'] . "',
        @Calle = " . ($data['Calle'] == '' ? 'NULL' : $data['Calle']) . ",
        @Colonia = " . ($data['Colonia'] == '' ? 'NULL' :$data['Colonia']) . ",
        @CodPost = " . ($data['CodPost'] == '' ? 'NULL' : $data['CodPost']) . ",
        @MpioDeleg = " . ($data['MpioDeleg'] == '' ? 'NULL' : $data['MpioDeleg']) . ",
        @Localidad = " . ($data['Localidad'] == '' ? 'NULL' : $data['Localidad']) . ",
        @Telefono = '" . $data['Telefono'] . "',
        @Email = '" . $data['Email'] . "',
        @RFC = '" . $data['RFC'] . "',
        @FechaNacimiento = " . ($data['FechaNacimiento'] == '' ? 'NULL' : $data['FechaNacimiento']) . ",
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
        @IdTipoMoneda = " . $data['IdTipoMoneda'] . ",
        @Lada = " . ($data['Lada'] == '' ? 'NULL' : $data['Lada']) . ",
        @Pais = " . $data['Pais'] . ",
        @MonedaSATDefault = '" . $data['MonedaSATDefault'] . "',
        @IdCodigoPostalSAT = " . $data['IdCodigoPostalSAT'] . ",
        @IdPaisSAT = " . $data['IdPaisSAT'] . ",
        @IdCatRegimen = " . $data['IdCatRegimen'] . ",
        @CuentaClabeSTP = " . ($data['CuentaClabeSTP'] == '' ? 'NULL' : $data['CuentaClabeSTP']) . ";")->result_array();
        echo json_encode($response);
        exit;
    }

}
