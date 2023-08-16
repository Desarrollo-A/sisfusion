<?php

class RegistroCliente extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registrolote_modelo');
        $this->load->model('asesor/Asesor_model');
        $this->load->model('General_model');
        $this->load->model([
            'opcs_catalogo/valores/EstatusAutorizacionesOpcs',
            'opcs_catalogo/valores/TipoAutorizacionClienteOpcs'
        ]);
		$this->load->library(array('session','form_validation'));
        //LIBRERIA PARA LLAMAR OBTENER LrAS CONSULTAS DE LAS  DEL MENÚ
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
		$this->load->library('Pdf');
		$this->load->library('email');
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		date_default_timezone_set('America/Mexico_City');
        $this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }
	// EN ESTA PARTE SE REALIZA EL REGISTRO DE CLIENTES TODOS LOS CLIENTES EXCEPTO DE SAN LUIS Y DE CIUDAD MADERAS SUR
	public function index (){
		$this->load->helper("url");
		$datos=array();
		$datos["gerentes"]= $this->registrolote_modelo->getGerente();
		$datos["residenciales"]= $this->registrolote_modelo->getResidencialQro();
		$datos["tipoPago"]= $this->registrolote_modelo->getTipoPago();
		$this->load->view("registro_cliente_view",$datos);
	}

     public function editar_ds_ea(){
        setlocale(LC_MONETARY, 'en_US');

        if(isset($_POST["pdfOK"]) || $_POST["pdfOK"] == '1' ) {


            $enganchecf = $this->input->post('enganchecf');
            $precio_m2cf = $this->input->post('precio_m2cf');
            $precio_totalcf = $this->input->post('precio_totalcf');
            $msi1 = $this->input->post('msi1');
            $msi2 = $this->input->post('msi2');
            $msi3 = $this->input->post('msi3');
            $paquete = $this->input->post('paquete');


            $idCliente=$this->input->post('idCliente');
            $rfc=$this->input->post('rfc');
            $fechaNacimiento=$this->input->post('fechaNacimiento');
            $correo=$this->input->post('correo');
            $referencia1=$this->input->post('referencia1');
            $telreferencia1=$this->input->post('telreferencia1');
            $referencia2=$this->input->post('referencia2');
            $telreferencia2=$this->input->post('telreferencia2');
            $telefono1=$this->input->post('telefono1');
            $telefono2=$this->input->post('telefono2');
            $domicilio_particular=$this->input->post('domicilio_particular');


            $clave=$this->input->post('clave');

            $nacionalidad=$this->input->post('CAMPO21');
            $nombreCompleto=$this->input->post('nombre');


            $arreglo=array();
            $arreglo["rfc"]=$rfc;
            $arreglo["fechaNacimiento"]=$fechaNacimiento;
            $arreglo["correo"]=$correo;
            $arreglo["referencia1"]=$referencia1;
            $arreglo["telreferencia1"]=$telreferencia1;
            $arreglo["referencia2"]=$referencia2;
            $arreglo["telreferencia2"]=$telreferencia2;
            $arreglo["telefono1"]=$telefono1;
            $arreglo["telefono2"]=$telefono2;




            $arreglo2=array();
            $arreglo2["domicilio_particular"]=$domicilio_particular;
            $arreglo2["nombreCliente"]=$nombreCompleto;

            if(isset($_POST["desarrollo"])) {
                $arreglo2["desarrollo"] = $_POST["desarrollo"];

                if( $_POST["desarrollo"] == 1){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1" checked="checked"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';
                }
                if( $_POST["desarrollo"] == 2){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2" checked="checked"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';
                }
                if( $_POST["desarrollo"] == 3){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3" checked="checked"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';

                }
                if( $_POST["desarrollo"] == 4){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4" checked="checked"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';

                }
                if( $_POST["desarrollo"] == 5){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5" checked="checked"> Mérida';

                }



            }

            else if(!isset($_POST["desarrollo"])){
                $arreglo2["desarrollo"] = '0';
            }





            if(isset($_POST["CAMPO04"])) {
                $arreglo2["tipoLote"] = $_POST["CAMPO04"];




                if( $_POST["CAMPO04"] == 0){
                    $tipoLote = '<input type="radio" id="CAMPO04" name="CAMPO04" value="0" checked="checked"> Lote';
                    $tipoLote2 = '<input type="radio" id="CAMPO04" name="CAMPO04" value="1"> Lote Comercial';
                }

                if( $_POST["CAMPO04"] == 1){
                    $tipoLote = '<input type="radio" id="CAMPO04" name="CAMPO04" value="0"> Lote';
                    $tipoLote2 = '<input type="radio" id="CAMPO04" name="CAMPO04" value="1" checked="checked"> Lote Comercial';
                }

            } else if(!isset($_POST["CAMPO04"])){
                $arreglo2["tipoLote"] = '0';
            }




            if(isset($_POST["CAMPO05"])) {
                $arreglo2["idOficial_pf"] = $_POST["CAMPO05"];

                $idOf = '<input type="checkbox" id="CAMPO05" name="CAMPO05" value="1" checked="checked"> Identificación&nbsp;Oficial';

            } else if(!isset($_POST["CAMPO05"])){
                $idOf = '<input type="checkbox" id="CAMPO05" name="CAMPO05" value="1"> Identificación&nbsp;Oficial';

                $arreglo2["idOficial_pf"] = '0';
            }

            if(isset($_POST["CAMPO06"])) {
                $compDom = '<input type="checkbox" id="CAMPO06" name="CAMPO06" value="1" checked="checked"> Comprobante&nbsp;de&nbsp;Domicilio';
                $arreglo2["idDomicilio_pf"] = $_POST["CAMPO06"];
            } else if(!isset($_POST["CAMPO06"])){
                $compDom = '<input type="checkbox" id="CAMPO06" name="CAMPO06" value="1"> Comprobante&nbsp;de&nbsp;Domicilio';
                $arreglo2["idDomicilio_pf"] = '0';
            }

            if(isset($_POST["CAMPO07"])) {
                $actMat = '<input type="checkbox" id="CAMPO07" name="CAMPO07" value="1" checked="checked"> Acta&nbsp;de&nbsp;Matrimonio';
                $arreglo2["actaMatrimonio_pf"] = $_POST["CAMPO07"];
            } else if(!isset($_POST["CAMPO07"])){
                $actMat = '<input type="checkbox" id="CAMPO07" name="CAMPO07" value="1"> Acta&nbsp;de&nbsp;Matrimonio';
                $arreglo2["actaMatrimonio_pf"] = '0';
            }



            if(isset($_POST["CAMPO08"])) {
                $actConst = '<input type="checkbox" id="CAMPO08" name="CAMPO08" value="1" checked="checked"> Acta&nbsp;Constitutiva';
                $arreglo2["actaConstitutiva_pm"] = $_POST["CAMPO08"];
            } else if(!isset($_POST["CAMPO08"])){
                $actConst = '<input type="checkbox" id="CAMPO08" name="CAMPO08" value="1"> Acta&nbsp;Constitutiva';
                $arreglo2["actaConstitutiva_pm"] = '0';
            }


            if(isset($_POST["CAMPO09"])) {
                $cartaPoder = '<input type="checkbox" id="CAMPO09" name="CAMPO09" value="1" checked="checked"> Poder';
                $arreglo2["poder_pm"] = $_POST["CAMPO09"];
            } else if(!isset($_POST["CAMPO09"])){
                $cartaPoder = '<input type="checkbox" id="CAMPO09" name="CAMPO09" value="1"> Poder';
                $arreglo2["poder_pm"] = '0';
            }

            if(isset($_POST["CAMPO10"])) {
                $identApoderado = '<input type="checkbox" id="CAMPO10" name="CAMPO10" value="1" checked="checked"> Identificación&nbsp;Oficial&nbsp;Apoderado';
                $arreglo2["idOficialApoderado_pm"] = $_POST["CAMPO10"];
            } else if(!isset($_POST["CAMPO10"])){
                $identApoderado = '<input type="checkbox" id="CAMPO10" name="CAMPO10" value="1"> Identificación&nbsp;Oficial&nbsp;Apoderado';
                $arreglo2["idOficialApoderado_pm"] = '0';
            }


            if(isset($_POST["CAMPO12"])) {
                $rfcC = '<input type="checkbox" id="CAMPO12" name="CAMPO12" value="1" checked="checked"> RFC';
                $arreglo2["rfc"] = $_POST["CAMPO12"];
            } else if(!isset($_POST["CAMPO12"])){
                $rfcC = '<input type="checkbox" id="CAMPO12" name="CAMPO12" value="1"> RFC';
                $arreglo2["rfc"] = '0';
            }







            $arreglo2["nacionalidad"] =  $nacionalidad;
            $arreglo2["originario"] =  $originario = $_POST["CAMPO22"];
            $arreglo2["estadoCivil"] =  $estadoCivil = $_POST["CAMPO23"];
            $arreglo2["nombreConyuge"] =  $nombreConyuge = $_POST["CAMPO24"];
            $arreglo2["regimen"] =  $regimen = $_POST["CAMPO25"];
            $arreglo2["ocupacion"] =  $ocupacion = $_POST["CAMPO27"];
            $arreglo2["empresaLabora"] =  $empresaLabora = $_POST["CAMPO28"];
            $arreglo2["puesto"] =  $puesto = $_POST["CAMPO29"];
            $arreglo2["antigueda"] =  $antigueda = $_POST["CAMPO30"];
            $arreglo2["edadFirma"] =  $edadFirma = $_POST["CAMPO31"];
            $arreglo2["domicilioEmpresa"] =  $domicilioEmpresa = $_POST["CAMPO32"];
            $arreglo2["telefonoEmp"] =  $telefonoEmp = $_POST["CAMPO34"];


            if(isset($_POST["CAMPO35"])) {
                $arreglo2["casa"] = $_POST["CAMPO35"];

                if( $_POST["CAMPO35"] == 1){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1" checked="checked"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';
                }

                if( $_POST["CAMPO35"] == 2){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2" checked="checked"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

                if( $_POST["CAMPO35"] == 3){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3" checked="checked"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

                if( $_POST["CAMPO35"] == 4){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4" checked="checked"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

                if( $_POST["CAMPO35"] == 5){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5" checked="checked"> OTRO';}

            } else if(!isset($_POST["CAMPO35"])){
                $arreglo2["casa"] = '0';
            }



            $arreglo2["noLote"] =  $noLote = $_POST["numeroLote"];
            $arreglo2["cluster"] =  $cluster = $_POST["CAMPO38"];
            $arreglo2["super"] =  $super = $_POST["CAMPO39"];
            $arreglo2["noRefPago"] =  $noRefPago = $_POST["CAMPO40"];
            $costoM2 = $_POST["CAMPO41"];
            $arreglo2["costom2f"] =  $costom2f = $_POST["CAMPO41_1"];
            $arreglo2["proyecto"] =  $proyecto = $_POST["CAMPO42"];
            $arreglo2["municipio"] =  $municipio = $_POST["CAMPO43"];
            $arreglo2["importOferta"] =  $importOferta = $_POST["CAMPO44"];
            $arreglo2["letraImport"] =  $letraImport = $_POST["CAMPO45"];
            $arreglo2["cantidad"] =  $cantidad = $_POST["CAMPO46"];
            $arreglo2["letraCantidad"] =  $letraCantidad = $_POST["CAMPO47"];
            $arreglo2["saldoDeposito"] =  $saldoDeposito = $_POST["CAMPO48"];
            $arreglo2["aportMensualOfer"] =  $aportMensualOfer = $_POST["CAMPO49"];
            $arreglo2["fecha1erAport"] =  $fecha1erAport = $_POST["CAMPO50"];
            $arreglo2["plazo"] =  $plazo = $_POST["CAMPO51"];
            $arreglo2["fechaLiquidaDepo"] =  $fechaLiquidaDepo = $_POST["CAMPO52"];
            $arreglo2["fecha2daAport"] =  $fecha2daAport = $_POST["CAMPO53"];
            $arreglo2["municipio2"] =  $municipio2 = $_POST["CAMPO54"];
            $arreglo2["dia"] =  $dia = $_POST["CAMPO55"];
            $arreglo2["mes"] =  $mes = $_POST["CAMPO56"];
            $arreglo2["año"] =  $año = $_POST["CAMPO57"];
            $arreglo2["nombreFirOfertante"] =  $nombreFirOfertante = $_POST["CAMPO58"];
            $arreglo2["observacion"] =  $observacion = $_POST["CAMPO59"];
            $arreglo2["parentescoReferen"] =  $parentescoReferen = $_POST["CAMPO61"];
            $arreglo2["parentescoReferen2"] =  $parentescoReferen2 = $_POST["CAMPO64"];
            $arreglo2["nombreFirmaAsesor"] =  $nombreFirmaAsesor = $_POST["CAMPO66"];
            $arreglo2["email2"] =  $email2 = $_POST["CAMPO68"];
            $arreglo2["nombreFirmaAutoriza"] =  $nombreFirmaAutoriza = $_POST["CAMPO67"];
            $arreglo2["fechaCrate"] =  $fechaCrate = date('Y-m-d H:i:s');
            $arreglo2["idCliente"] =  $idCliente;





            if(isset($_POST["espectacular"])) {
                $espectacular = '<input type="checkbox" id="espectacular" name="espectacular" value="1" checked="checked"> ESPECTACULAR';
                $arreglo2["espectacular"] = '1';
            } else if(!isset($_POST["espectacular"])){
                $espectacular = '<input type="checkbox" id="espectacular" name="espectacular" value="1"> ESPECTACULAR';
                $arreglo2["espectacular"] = '0';
            }



            if(isset($_POST["volante"])) {
                $volante = '<input type="checkbox" id="volante" name="volante" value="1" checked="checked"> VOLANTE';
                $arreglo2["volante"] = '1';
            } else if(!isset($_POST["volante"])){
                $volante = '<input type="checkbox" id="volante" name="volante" value="1"> VOLANTE';
                $arreglo2["volante"] = '0';
            }



            if(isset($_POST["radio"])) {
                $radio = '<input type="checkbox" id="radio" name="radio" value="1" checked="checked"> RADIO';
                $arreglo2["radio"] = '1';
            } else if(!isset($_POST["radio"])){
                $radio = '<input type="checkbox" id="radio" name="radio" value="1"> RADIO';
                $arreglo2["radio"] = '0';
            }



            if(isset($_POST["periodico"])) {
                $periodico = '<input type="checkbox" id="periodico" name="periodico" value="1" checked="checked"> PERIÓDICO';
                $arreglo2["periodico"] = '1';
            } else if(!isset($_POST["periodico"])){
                $periodico = '<input type="checkbox" id="periodico" name="periodico" value="1"> PERIÓDICO';
                $arreglo2["periodico"] = '0';
            }



            if(isset($_POST["revista"])) {
                $revista = '<input type="checkbox" id="revista" name="revista" value="1" checked="checked"> REVISTA';
                $arreglo2["revista"] = '1';
            } else if(!isset($_POST["revista"])){
                $revista = '<input type="checkbox" id="revista" name="revista" value="1"> REVISTA';
                $arreglo2["revista"] = '0';
            }



            if(isset($_POST["redes"])) {
                $redes = '<input type="checkbox" id="redes" name="redes" value="1" checked="checked"> REDES SPCOALES';
                $arreglo2["redes"] = '1';
            } else if(!isset($_POST["redes"])){
                $redes = '<input type="checkbox" id="redes" name="redes" value="1"> REDES SPCOALES';
                $arreglo2["redes"] = '0';
            }




            if(isset($_POST["punto"])) {
                $punto = '<input type="checkbox" id="punto" name="punto" value="1" checked="checked"> PUNTO DE VENTA';
                $arreglo2["punto"] = '1';
            } else if(!isset($_POST["punto"])){
                $punto = '<input type="checkbox" id="punto" name="punto" value="1"> PUNTO DE VENTA';
                $arreglo2["punto"] = '0';
            }


            if(isset($_POST["invitacion"])) {
                $invitacion = '<input type="checkbox" id="invitacion" name="invitacion" value="1" checked="checked"> INVITACIÓN A EVENTO';
                $arreglo2["invitacion"] = '1';
            } else if(!isset($_POST["invitacion"])){
                $invitacion = '<input type="checkbox" id="invitacion" name="invitacion" value="1"> INVITACIÓN A EVENTO';
                $arreglo2["invitacion"] = '0';
            }



            if(isset($_POST["emailing"])) {
                $emailing = '<input type="checkbox" id="emailing" name="emailing" value="1" checked="checked"> E-MAILING';
                $arreglo2["emailing"] = '1';
            } else if(!isset($_POST["emailing"])){
                $emailing = '<input type="checkbox" id="emailing" name="emailing" value="1"> E-MAILING';
                $arreglo2["emailing"] = '0';
            }



            if(isset($_POST["pagina"])) {
                $pagina = '<input type="checkbox" id="pagina" name="pagina" value="1" checked="checked"> PÁGINA WEB';
                $arreglo2["pagina"] = '1';
            } else if(!isset($_POST["pagina"])){
                $pagina = '<input type="checkbox" id="pagina" name="pagina" value="1"> PÁGINA WEB';
                $arreglo2["pagina"] = '0';
            }



            if(isset($_POST["recomendacion"])) {
                $recomendacion = '<input type="checkbox" id="recomendacion" name="recomendacion" value="1" checked="checked"> RECOMENDACIÓN';
                $arreglo2["recomendacion"] = '1';
            } else if(!isset($_POST["recomendacion"])){
                $recomendacion = '<input type="checkbox" id="recomendacion" name="recomendacion" value="1"> RECOMENDACIÓN';
                $arreglo2["recomendacion"] = '0';
            }




            if(isset($_POST["convenio"])) {
                $convenio = '<input type="checkbox" id="convenio" name="convenio" value="1" checked="checked"> CONVENIO';
                $arreglo2["convenio"] = '1';
            } else if(!isset($_POST["convenio"])){
                $convenio = '<input type="checkbox" id="convenio" name="convenio" value="1"> CONVENIO';
                $arreglo2["convenio"] = '0';
            }



            if(isset($_POST["marketing"])) {
                $marketing = '<input type="checkbox" id="marketing" name="marketing" value="1" checked="checked"> MARKETING DIGITAL';
                $arreglo2["marketing"] = '1';
            } else if(!isset($_POST["marketing"])){
                $marketing = '<input type="checkbox" id="marketing" name="marketing" value="1"> MARKETING DIGITAL';
                $arreglo2["marketing"] = '0';
            }


            if(isset($_POST["otro1"])) {
                $otro1 = '<input type="checkbox" id="otro1" name="otro1" value="1" checked="checked"> OTRO';
                $arreglo2["otro1"] = '1';
            } else if(!isset($_POST["otro1"])){
                $otro1 = '<input type="checkbox" id="otro1" name="otro1" value="1"> OTRO';
                $arreglo2["otro1"] = '0';
            }

            if($_POST["especificar"]==12 || $_POST["especificar"]==6) {
                $especificar = '<input type="checkbox" id="especificar" name="especificar" value="1" checked="checked"> ESPECIFICAR';
                //$arreglo2["especificar"] = '12';
            } else if(!isset($_POST["especificar"])){
                $especificar = '<input type="checkbox" id="especificar" name="especificar" value="1"> ESPECIFICAR';
                //$arreglo2["especificar"] = '0';
            }
            $arreglo2["especificar"] = (empty($_POST["especificar"]))?'11':$_POST["especificar"];


            if(isset($_POST["pase"])) {
                $pase = '<input type="checkbox" id="pase" name="pase" value="1" checked="checked"> PASE OFICINA';
                $arreglo2["pase"] = '1';
            } else if(!isset($_POST["pase"])){
                $pase = '<input type="checkbox" id="pase" name="pase" value="1"> PASE OFICINA';
                $arreglo2["pase"] = '0';
            }




            if(isset($_POST["modulo"])) {
                $modulo = '<input type="checkbox" id="modulo" name="modulo" value="1" checked="checked"> PASE MÓDULO EN PLAZAS';
                $arreglo2["modulo"] = '1';
            } else if(!isset($_POST["modulo"])){
                $modulo = '<input type="checkbox" id="modulo" name="modulo" value="1"> PASE MÓDULO EN PLAZAS';
                $arreglo2["modulo"] = '0';
            }



            if(isset($_POST["paseevento"])) {
                $paseevento = '<input type="checkbox" id="paseevento" name="paseevento" value="1" checked="checked"> PASE EVENTO';
                $arreglo2["paseevento"] = '1';
            } else if(!isset($_POST["paseevento"])){
                $paseevento = '<input type="checkbox" id="paseevento" name="paseevento" value="1"> PASE EVENTO';
                $arreglo2["paseevento"] = '0';
            }







            if(isset($_POST["pasedesarrollo"])) {
                $pasedesarrollo = '<input type="checkbox" id="pasedesarrollo" name="pasedesarrollo" value="1" checked="checked"> PASE DESARROLLO';
                $arreglo2["pasedesarrollo"] = '1';
            } else if(!isset($_POST["pasedesarrollo"])){
                $pasedesarrollo = '<input type="checkbox" id="pasedesarrollo" name="pasedesarrollo" value="1"> PASE DESARROLLO';
                $arreglo2["pasedesarrollo"] = '0';
            }





            if(isset($_POST["call"])) {
                $call = '<input type="checkbox" id="call" name="call" value="1" checked="checked"> CALL PICKER';
                $arreglo2["call"] = '1';
            } else if(!isset($_POST["call"])){
                $call = '<input type="checkbox" id="call" name="call" value="1"> CALL PICKER';
                $arreglo2["call"] = '0';
            }






            if(isset($_POST["pasedirecto"])) {
                $pasedirecto = '<input type="checkbox" id="pasedirecto" name="pasedirecto" value="1" checked="checked"> PASE DIRECTO DE MI PARTE';
                $arreglo2["pasedirecto"] = '1';
            } else if(!isset($_POST["pasedirecto"])){
                $pasedirecto = '<input type="checkbox" id="pasedirecto" name="pasedirecto" value="1"> PASE DIRECTO DE MI PARTE';
                $arreglo2["pasedirecto"] = '0';
            }




            if(isset($_POST["casaCheck"])) {
                $casaCheck = '<input type="checkbox" id="casaCheck" name="casaCheck" value="1" checked="checked"> CASA';
                $arreglo2["casaCheck"] = '1';
            } else if(!isset($_POST["casaCheck"])){
                $casaCheck = '<input type="checkbox" id="casaCheck" name="casaCheck" value="1"> CASA';
                $arreglo2["casaCheck"] = '0';
            }




            if(isset($_POST["oficina"])) {
                $oficina = '<input type="checkbox" id="oficina" name="oficina" value="1" checked="checked"> OFICINA';
                $arreglo2["oficina"] = '1';
            } else if(!isset($_POST["oficina"])){
                $oficina = '<input type="checkbox" id="oficina" name="oficina" value="1"> OFICINA';
                $arreglo2["oficina"] = '0';
            }




            if(isset($_POST["whatsapp"])) {
                $whatsapp = '<input type="checkbox" id="whatsapp" name="whatsapp" value="1" checked="checked"> WHATSAPP';
                $arreglo2["whatsapp"] = '1';
            } else if(!isset($_POST["whatsapp"])){
                $whatsapp = '<input type="checkbox" id="whatsapp" name="whatsapp" value="1"> WHATSAPP';
                $arreglo2["whatsapp"] = '0';
            }



            if(isset($_POST["email"])) {
                $email = '<input type="checkbox" id="email" name="email" value="1" checked="checked"> E-MAIL DE MI PARTE';
                $arreglo2["email"] = '1';
            } else if(!isset($_POST["email"])){
                $email = '<input type="checkbox" id="email" name="email" value="1"> E-MAIL DE MI PARTE';
                $arreglo2["email"] = '0';
            }



            if(isset($_POST["otro2"])) {
                $otro2 = '<input type="checkbox" id="otro2" name="otro2" value="1" checked="checked"> OTRO';
                $arreglo2["otro2"] = '1';
            } else if(!isset($_POST["otro2"])){
                $otro2 = '<input type="checkbox" id="otro2" name="otro2" value="1"> OTRO';
                $arreglo2["otro2"] = '0';
            }





                ///CONVERTIMOS A ARREGLO TANTO LOS DESCUENTOS ACTUALES COMO EL NUEVO A AGREGAR
            $arrayCorreo = explode(",", $correo);
                //// CHECAMOS SI EN EL ARREGLO NO HAY POSICIONES VACIAS Y LAS ELIMINAMOS
            $listCheckVacio = array_filter($arrayCorreo, "strlen");
            ////VERIFICAMOS QUE NUESTRO ARREGLO NO TENGA DATOS REPETIDOS
            $arrayCorreoNotRepeat=array_unique($listCheckVacio);
            ////EL ARREGLO FINAL LO CONVERTIMOS A STRING
            // $resCorreo = implode( ",", $arrayCorreoNotRepeat);



            $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);


            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sistemas María José Martínez Martínez');
            $pdf->SetTitle('DEPÓSITO DE SERIEDAD');
            $pdf->SetSubject('CONSTANCIA DE RELACION EMPRESA TRABAJADOR');
            $pdf->SetKeywords('CONSTANCIA, CIUDAD MADERAS, RELACION, EMPRESA, TRABAJADOR');
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetAutoPageBreak(TRUE, 0);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('Helvetica', '', 9, '', true);
            $pdf->SetMargins(15, 15, 15, true);


            $pdf->AddPage('P', 'LEGAL');

            $pdf->SetFont('Helvetica', '', 5, '', true);





            $pdf->SetFooterMargin(0);
            $bMargin = $pdf->getBreakMargin();
            $auto_page_break = $pdf->getAutoPageBreak();
            $pdf->Image('static/images/ar4c.png', 120, 15, 300, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
            $pdf->setPageMark();




            $html = '
            <!DOCTYPE html>
            <html lang="en">
               <head>
                  <link rel="shortcut icon" href="'.base_url().'static/images/arbol_cm.png" />
                  <link href="<?=base_url()?>dist/css/bootstrap.min.css" rel="stylesheet" />
                  <!--  Material Dashboard CSS    -->
                  <link href="<?=base_url()?>dist/css/material-dashboard.css" rel="stylesheet" />
                  <!--  CSS for Demo Purpose, don\'t include it in your project     -->
                  <link href="<?=base_url()?>dist/css/demo.css" rel="stylesheet" />
                  <!--     Fonts and icons     -->
                  <link href="<?=base_url()?>dist/css/font-awesome.css" rel="stylesheet" />
                  <link href="<?=base_url()?>dist/css/google-roboto-300-700.css" rel="stylesheet" />
                  <style>
                  body{color: #084c94;}
                  .espacio{padding: 5%;}
                  .espaciodos{padding: 10%;} 
                  h2{font-weight: bold;color: #084c94;}
                  .save {display:scroll;position:fixed;bottom:225px;right:17px;z-index: 3;}
                  p{color: #084c94;}
                  .col-xs-16 {width: 3px;float: left;}
                  .col-xs-17 {width: 16%;float: left;}
                  #imagenbg {position: relative;top:1500px;z-index: -1;}
                  #fichadeposito {position: absolute;z-index: 2;}
                  .mySectionPdf
                  {
                     padding: 20px;
                  }
                  .form-group.is-focused .form-control {
                    outline: none;
                    background-image: linear-gradient(#0c63c5, #177beb), linear-gradient(#D2D2D2, #D2D2D2);
                    background-size: 100% 2px, 100% 1px;
                    box-shadow: none;
                    transition-duration: 0.3s;
                  }
                  b{
                  font-size: 8px;
                  }
                  </style>
               </head>
               <body>
                      <div id="fichadeposito" name="fichadeposito" class="fichadeposito">
                          <div id="muestra"> 
                            <table border="0" width="100%" id="tabla" align="center">
                              
                              <tr>
                               <td width="70%" align="left" >
                                   <br>
                              <label>
                                 <h1 style="margin-right: 50px;"> DEPÓSITO DE SERIEDAD</h1>
                              </label>
                                </td>
                                <td align="right" width="15%">
                                <br><br><br>
                                   <p style="margin-right: 2px;">FOLIO</p>
                                </td>
                                <td width="15%" style="border-bottom:1px solid #CCCCCC">
                                         <p style="color: red;font-size:14px;">'.$clave.'</p>
                                </td>
                              </tr>
                            </table>
                            <table border="0" width="100%" align="" align="">
                              <tr>
                                <th rowspan="4" width="283" align="left">
                                 <img src="'.base_url().'/static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width: 250px"/>
                                </th>
                                <td width="367">
                                  <h5><p style="font-size:9px;"><strong>DESARROLLO:</strong></p></h5>
                                </td>
                              </tr>
                              <tr>
                                <td width="367">
                                  <table border="0" width="100%">
                                    <tr>
                                      <td width="10%"></td>
                                      <td width="20%">
                                      '.$desarrollo.'
                                      </td>
                                      <td width="20%">
                                      '.$desarrollo2.'
                                      </td>
                                      <td width="20%">
                                      '.$desarrollo3.'
                                      </td>
                                      <td width="20%">
                                      '.$desarrollo4.'
                                      </td>
                                      <td width="20%">
                                      '.$desarrollo5.'
                                      </td>
                           
                                    </tr>
                                    <tr>
                                      <td width="10%"></td>
                                      <td width="20%">
                                      '.$tipoLote.'
                                      </td>
                                      <td width="20%">
                                      '.$tipoLote2.'
                                      </td>
                                      <td width="15%"></td>
                                      <td width="15%"></td>
                                      <td width="30%"></td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <h5><p style="font-size:9px;"><strong>DOCUMENTACIÓN ENTREGADA:</strong></p></h5>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <table border="0" width="100%">
                                    <tr>
                                      <td width="19 %"><p><strong>Personas&nbsp;Físicas</strong></p></td>

                                      <td width="23%">
                                      '.$idOf.'
                                      </td>
                                      <td width="27%">
                                      '.$compDom.'
                                      </td>
                                      <td width="29%" colspan="2">
                                      '.$actMat.'
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="19%"><p><strong>Personas&nbsp;Morales</strong></p></td>
                                      <td width="23%">
                                      '.$actConst.'
                                      </td>
                                      <td width="27%">
                                      '.$cartaPoder.'
                                      </td>
                                      <td width="29%" colspan="2">
                                      '.$identApoderado.'
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="19%"></td>
                                      <td width="35%">
                                      </td>
                                      <td width="15%"></td>
                                      <td width="55%" colspan="3">
                                      '.$rfcC.'
                                      <input type="text" class="form-cont" id="CAMPO13" name="CAMPO13" value="'.$rfc.'" size="24">
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" colspan="2">
                                  <br>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
                                <label>
                                   NOMBRE(<b><span style="color: red;">*</span></b>):
                                   </label><br><br>
                                   <b>&nbsp;'.$nombreCompleto.' <br></b>
                                                   
                                </td>
                              </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                              <tr>
                        
                                      <td width="47.5%" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                    TELÉFONO CASA:
                                   </label><br><br>
                                          <b style="padding-left: 250px">&nbsp;'.$telefono1.'</b><br>
                                          
                                      </td>
                                      <td width="5%"></td>
                                      <td width="47.5%" colspan="2" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                        CELULAR (<b><span style="color: red;">*</span></b>)
                                   </label><br><br>
                                          <b>&nbsp;'.$telefono2.'</b><br>
                                       
                                      </td> 
                       
                              </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                              <tr>
                                <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                   EMAIL (<b><span style="color: red;">*</span></b>)
                              </label><br><br>
                              <b>&nbsp;'.$correo.'</b><br>
                                </td>
                              </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                             <tr>
                               <td width="30%" colspan="2" style="border-bottom: 1px solid #CCCCCC">
                              <label>
                                 FECHA DE NACIMIENTO (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br>                 
                                    <b>'.$fechaNacimiento.'</b><br>
                                </td>   
                                <td width="5%"></td>
                                <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                 NACIONALIDAD (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br>  
                                    <b>&nbsp;'.$nacionalidad.'</b>
                                </td>    
                                <td width="5%"></td>          
                                <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                 ORIGINARIO DE (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br> 
                              <b>&nbsp;'.$originario.'</b>
                                </td>
                             </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                            <tr>
                               <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                                  <label>
                                 ESTADO CIVIL (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br> 
                                    <b>&nbsp;'.$estadoCivil.'</b><br>
                                </td>  
                                <td width="5%"></td>     
                                <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                 NOMBRE DEL CÓNYUGE
                              </label>  <br><br> 
                                    <b>&nbsp;'.$nombreConyuge.'</b><br>
                                </td>    
                                <td width="5%"></td>              
                                <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                                   <label>
                                 RÉGIMEN (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br> 
                                    <b>&nbsp;'.$regimen.'</b><br>
                                                               
                                </td>
                            </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                              <tr>
                                <td width="100%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                                   <label>
                                 DOMICILIO PARTICULAR (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br>
                                   <b>&nbsp;'.$domicilio_particular.'</b><br>                    
                                </td> 
                                </tr>
                                <tr>
                                <td width="100%" colspan="2"></td>
                              </tr>
                              <tr>
                               <td width="47.5%" style="border-bottom:1px solid #CCCCCC;">
                                  <label>
                                 OCUPACIÓN (<b><span style="color: red;">*</span></b>)
                              </label>  <br><br>
                                     <b>&nbsp;'.$ocupacion.'</b><br>
                                </td> 
                                <td width="5%"></td>
                                <td width="47.5%" style="border-bottom:1px solid #CCCCCC;">
                                   <label>
                                 EMPRESA EN LA QUE TRABAJA
                              </label>  <br><br>
                                    <b>&nbsp;'.$empresaLabora.'</b><br>
                                      
                                </td>            
                              </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                             <tr>
                           <td width="30%" style="border-bottom:1px solid #CCCCCC;">
                                  <label>
                                     PUESTO (<b><span style="color: red;">*</span></b>)
                                  </label><br><br>
                                     <b>&nbsp;'.$puesto.'</b><br>
                           </td>   
                           <td width="5%"></td>
                           <td width="30%" style="border-bottom:1px solid #CCCCCC;">
                                  <label>
                                     ANTIGÜEDAD (AÑOS)
                                  </label><br><br>
                                     <b>&nbsp;'.$antigueda.'</b><br>
                           </td> 
                           <td width="5%"></td>   
                           <td width="30%" style="border-bottom:1px solid #CCCCCC;">
                                  <label>
                                     EDAD AL MOMENTO DE LA FIRMA (<b><span style="color: red;">*</span></b>)
                                  </label><br><br>
                                      <b>&nbsp;'.$edadFirma.'</b><br>
                           </td>
                             </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                              <tr>
                                <td width="100%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                                   <label>
                                     DOMICILIO EMPRESA
                                  </label><br><br>
                                   <b>&nbsp;'.$domicilioEmpresa.'</b><br>
                                </td>
                              </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                            <tr>
                              <td width="30%" style="border-bottom:1px solid #CCCCCC;">  
                                 <label>
                                    TELÉFONO EMPRESA
                                 </label><br><br>
                                 <b>&nbsp;'.$telefonoEmp.'</b><br>
                              </td>   
                              <td width="5%"></td>              
                              <td width="65%" style="border-bottom:1px solid #CCCCCC;">
                                 <label>
                                    VIVE EN CASA:
                                 </label><br><br>
                                       <b>' . $casa . ' ' . $casa2 . ' ' . $casa3 . ' ' . $casa4 . ' ' . $casa5 . '</b><br>
                              </td>
                            </tr>
                            <tr>
                               <td width="100%" colspan="2"></td>
                            </tr>
                            <tr>
                           <td width="100%" style="border-bottom:1px solid #CCCCCC;">
                              <label>&nbsp;&nbsp;&nbsp;&nbsp;El Sr.(a) (<b><span style="color: red;">*</span></b>)</label><br><br>
                              <b>&nbsp;&nbsp;&nbsp;'.$nombreCompleto.'</b>
                           </td>                 
                            </tr>
                            <tr>
                                <td width="100%" colspan="2"></td>
                            </tr>
                            <tr >
                                <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                                  <label>Se compromete a adquirir el lote No.(<b><span style="color: red;">*</span></b>): </label>
                                  <b style="border-bottom:1px solid #CCCCCC;">'.$noLote.'</b> &nbsp;&nbsp;&nbsp; 
                                </td>
                           <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                              <label>en el clúster (<b><span style="color: red;">*</span></b>): </label>
                              <b style="border-bottom:1px solid #CCCCCC;">'.$cluster.'</b> &nbsp;&nbsp;&nbsp;  
                           </td>
                           <td width="25%" style="border-bottom:1px solid #CCCCCC;">
                              <label>de sup. aprox. (<b><span style="color: red;">*</span></b>): </label>
                              <b style="border-bottom:1px solid #CCCCCC;">'.$super.'</b> &nbsp;&nbsp;&nbsp; 
                           </td>
                           <td width="25%" style="border-bottom:1px solid #CCCCCC;">
                              <label>No. de ref. de pago (<b><span style="color: red;">*</span></b>): </label>
                              <b style="border-bottom: 1px solid #CCCCCC">'.$noRefPago.'</b> &nbsp;&nbsp;&nbsp;
                           </td>
                            </tr>
                            <tr>
                                <td width="100%" colspan="2"></td>
                            </tr>
                          <tr>
                            <td width="20%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                            <label>costo por m2 lista (<b><span style="color: red;">*</span></b>): </label>
                            <b>'.$costoM2.'</b>
                           </td>
                           <td width="20%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                             <label>costo por m2 final (<b><span style="color: red;">*</span></b>): </label>
                             <b>'.$costom2f.'</b>
                           </td>
                          </tr>
                            <tr>
                                <td width="100%" colspan="2"></td>
                            </tr>        
                           <tr>
                            <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">  
                                  <label>una vez que sea autorizado el proyecto (<b><span style="color: red;">*</span></b>): </label>
                                  <b>'.$proyecto.'</b>,
                                </td>
                                <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">  
                                   <label> en el Municipio de (<b><span style="color: red;">*</span></b>): </label>
                                   <b>'.$municipio.'</b>
                                </td>
                            </tr>

                            <tr>
                                <td width="100%" colspan="2"></td>
                            </tr>

                           <tr>
                            <td width="30%" colspan="2">  
                            <label>La ubicación del lote puede variar debido a ajustes del proyecto.</label>
                            </td>

                           </tr>




                            <tr>
                                <td width="100%" colspan="2"></td>
                            </tr>
                            <tr>
                                <td width="100%" colspan="2" style="border-bottom:1px solid #CCCCCC;">   
                              <label>Importe de la oferta $ (<b><span style="color: red;">*</span></b>): </label>
                              <b>'.$importOferta.'</b> &nbsp;&nbsp;&nbsp;&nbsp;( <b>'.$letraImport.'</b> 00/100 M.N )
                                </td>
                            </tr>
                            <tr>
                              <td width="100%" colspan="2"></td>
                            </tr> 
                            <tr>
                                <td width="55%" colspan="2" style="border-bottom:1px solid #CCCCCC">  
                                <label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $ (<b><span style="color: red;">*</span></b>): </label>
                                <b>'.$cantidad.'</b>  
                                </td>
                                <td width="45%" style="border-bottom:1px solid #CCCCCC">
                                   <b> ( '.$letraCantidad.' ), </b>
                                </td>
                            </tr>

                            <tr>
                                <td width="100%" colspan="2"></td>
                            </tr>


                            <tr>

                                <td width="45%">
                                <label>misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo.</label>
                             </td>




                            </tr>
                     
                            <tr>
                              <td width="100%" colspan="2"></td>
                            </tr> 
                            <tr>
                                <td width="75%" colspan="2" >
                                   <label>El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma:</label>
                                </td>
                                <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC">
                                    <label>Saldo de depósito: $ (<b><span style="color: red;">*</span></b>): </label>
                                    <b>'.$saldoDeposito.'</b> 
                                </td>
                            </tr>
                            <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>        
                            <tr>
                               <td width="17%"> 
                                      <label>Aportación mensual a la oferta: $ (<b><span style="color: red;">*</span></b>): </label>
                               </td>   
                               <td width="23%" style="border-bottom:1px solid #CCCCCC">
                                      <b>'.$aportMensualOfer.'</b> 
                               </td>
                               <td width="13%">
                                      <label> Fecha 1era. Aportación (<b><span style="color: red;">*</span></b>): </label>
                               </td>  
                               <td width="27%" style="border-bottom:1px solid #CCCCCC">
                                      <b>'.$fecha1erAport.'</b>
                               </td>      
                               <td width="5%"> 
                                   <label>Plazo (<b><span style="color: red;">*</span></b>): </label> 
                               </td>
                               <td width="15%" style="border-bottom:1px solid #CCCCCC">
                                      <b>'.$plazo.'</b> <label> meses</label> 
                               </td>
                            </tr>
                                <tr>
                                   <td width="100%" colspan="2"></td>
                               </tr> 
                                <tr>
                                  <td width="17%">
                                      <label>Fecha liquidación de depósito  (<b><span style="color: red;">*</span></b>): </label>               
                                   </td>  
                                   <td width="23%" style="border-bottom:1px solid #CCCCCC">
                                          <b>'.$fechaLiquidaDepo.'</b>
                                   </td> 
                                  <td width="13%" >
                                      <label>Fecha 2da. Aportación: </label>  
                                  </td>
                                  <td width="27%" style="border-bottom:1px solid #CCCCCC">
                                      <b>'.$fecha2daAport.'</b> 
                                  </td>
                                </tr>
                                <tr>
                                   <td width="100%" colspan="2"></td>
                               </tr> 
                              <tr>
                                <td width="100%" colspan="2" style="background-color:#FFF;"> 
                                      <label style="text-align: justify; font-size: 5px">Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente  $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.</label>
                                     
                                      <label style="text-align: justify; font-size: 5px">Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. 
                                        Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. 
                                        De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. 
                                        Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.  
                                      </label>
                                </td>
                              </tr>
                              <tr>
                              <td width="100%" colspan="2"></td>
                            </tr>
                              <tr>
                                <td width="10%">
                                   <label>En el Municipio de: </label>
                           </td>
                           <td width="25%" style="border-bottom:1px solid #CCCCCC">
                              <b>'.$municipio2.'</b>
                           </td>
                           <td width="3%" align="center">
                              <label>A: </label>
                           </td>
                           <td width="3%" style="border-bottom:1px solid #CCCCCC">
                              <b>'.$dia.'</b>
                           </td>
                           <td width="8%" align="right">
                              <label>Del mes de:  </label>
                           </td>
                           <td width="13%" style="border-bottom:1px solid #CCCCCC">
                               <b> '.$mes.'</b>
                           </td>
                           <td width="5%" align="right">
                              <label>Del año:  </label>
                           </td>
                           <td width="10%" style="border-bottom:1px solid #CCCCCC">
                              <b> &nbsp;&nbsp;'.$año.'</b>
                           </td>
                              </tr>
                              <tr>
                               <td width="100%" colspan="2"></td>
                              </tr>
                             <tr>
                             <td width="100%" colspan="2"></td>
                            </tr>
                              <tr>
                                <td width="100%" colspan="2">         
                                  <table border="0" width="100%">
                                    <tr>
                                      <td width="60%" align="center"> 
                                        <table border="0" width="100%">
                                          <tr>  
                                            <td width="100%"><br><br><br><br></td>              
                                          </tr>
                                          <tr>
                                            <td width="100%" align="center">   
                                            '.$nombreCompleto.'          
                                              <BR>                      
                                              ______________________________________________________________________________
                                              <p>Nombre y Firma / Ofertante</p>
                                              <p>Acepto que se realice una verificación de mis datos, en los teléfonos<br> y correos que proporciono para el otorgamiento del crédito.</p>
                                            </td>
                                          </tr>
                                          <tr>
                                          <td width="100%" colspan="2"></td>
                                         </tr>
                                         <tr>
                                         <td width="100%" colspan="2"></td>
                                        </tr>
                                          <tr>
                                            <td width="100%" align="center">
                                    
                                            <table border="0" width="91%" style="background-color:#ffffff;">
                                            <tr>
                                            <td>
                  
                                              </td>
                                              </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </table>
                                      </td>   
                                      <td width="37%" >                            
                                        <table border="0" width="108%" style="border:1px solid #CCC">
                                        <tr>
                                        <td width="100%" colspan="2" ></td>
                                       </tr>  
                                       <tr>  
                                            <td width="100%" colspan="2" style="" align="center">
                                               <h4>  REFERENCIAS PERSONALES</h4>
                                            </td>              
                                       </tr>
                                       <tr>
                                          <td width="100%" colspan="2"></td>
                                       </tr>
                                       <tr>
                                           <td width="15%"></td>
                                            <td width="20%" style="color: #084c94;"> NOMBRE: </td>              
                                            <td width="48%" style="border-bottom:1px solid #CCC">
                                       <b style="font-size: 5px"> '.$referencia1.'</b>
                                            </td>
                                       </tr>
                                       <tr>
                                           <td width="15%"></td>
                                            <td width="20%" style="color: #084c94;"> PARENTESCO: </td>  
                                            <td width="48%" style="border-bottom:1px solid #CCC">
                                               <b style="font-size: 5px"> '.$parentescoReferen.'</b>
                                            </td> 
                                       </tr>
                                       <tr> 
                                              <td width="15%"></td>
                                            <td width="20%" style="color: #084c94;"> TEL: </td>  
                                            <td width="48%" style="border-bottom:1px solid #CCC">
                                               <b style="font-size: 5px"> ' . $telreferencia1 . '</b>
                                            </td>                          
                                       </tr>
                                      <tr>
                                          <td width="100%" colspan="2"></td>
                                      </tr>
                                      <tr>
                                           <td width="15%"></td>
                                            <td width="20%" style="color: #084c94;"> NOMBRE: </td>              
                                            <td width="48%" style="border-bottom:1px solid #CCC">
                                       <b style="font-size: 5px"> '.$referencia2.'</b>
                                            </td>
                                       </tr>
                                       <tr>
                                           <td width="15%"></td>
                                            <td width="20%" style="color: #084c94;"> PARENTESCO: </td>  
                                            <td width="48%" style="border-bottom:1px solid #CCC">
                                               <b style="font-size: 5px"> '.$parentescoReferen2.'</b>
                                            </td> 
                                       </tr>
                                       <tr> 
                                              <td width="15%"></td>
                                            <td width="20%" style="color: #084c94;"> TEL: </td>  
                                            <td width="48%" style="border-bottom:1px solid #CCC">
                                               <b style="font-size: 5px"> ' . $telreferencia2 . '</b>
                                            </td>                          
                                       </tr>   
                                <tr>
                                          <td width="100%" colspan="2"></td>
                                      </tr>
                                      
                                      <tr>
                                         <td width="100%" colspan="2"></td>
                                      </tr>
                                        </table>
                                      </td>              
                                    </tr>
                                  </table> 
                                </td>
                              </tr>

                            <tr>                
                           <td width="100%" colspan="2"></td>
                           </tr>       
                      <tr>
                           <td width="100%" colspan="2">
                           <b style="font-size: 10px"> ' . $observacion . '</b>
                           </td>
                       </tr>
                           <tr>
                                <td width="100%" colspan="2">
                                  <br><br><br><br>
                                </td>
                              </tr>
                              <tr>
                                <td width="100%" colspan="2">
                                  <table border="0" width="100%">
                                  <tr>
                                    <td width="50%" align="center">
                                    '.$nombreFirmaAsesor.'
                              <BR>
                                    __________________________________________________________________________
                                      <p>Nombre y Firma / Asesor</p> 
                                    </td>
                                    <td width="50%" align="center">
                                    '.$nombreFirmaAutoriza.'
                              <BR>
                                    __________________________________________________________________________
                                      <p>Nombre y Firma / Autorización de operación</p>        
                                </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>     
                              <tr>
                               <td width="100%" colspan="2"></td>
                              </tr>
                              <tr>
                               <td width="100%" colspan="2"></td>
                              </tr>                
                              <tr>
                              <td width="3%" align="center"> 
                              </td> 
                          <td width="8%" align="center"> 
                                  <label>
                                   E-mail: 
                             </label>
                              </td>
                              <td width="35%" align="center" style="border-bottom:1px solid #CCCCCC"> 
                               <b>'.$email2.'</b>
                              </td>

                              </tr>
                          <tr>                

                             
                              <td width="100%" colspan="2">
                                <br><br>
                              </td>

                            </tr>
                             
                                              
                              <tr>                  
                              <td width="100%" colspan="2">
                                <br><br>
                              </td>
                            </tr>
                            </table>
                          </div> 
                      </div>
                     
                </body>
            </html>';

            $pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);


            $namePDF = utf8_decode('DEPÓSITO_DE_SERIEDAD_'.$idCliente.'.pdf');

            $pdf->Output(utf8_decode($namePDF), 'I');

            $attachment= $pdf->Output(utf8_decode($namePDF), 'S');

            $this->email
                ->initialize()
                ->from('Ciudad Maderas')
                ->to('tester.ti2@ciudadmaderas.com')
                // ->to($correo)
                ->subject('DEPÓSITO DE SERIEDAD - CIUDAD MADERAS')
                ->attach($attachment, '', $namePDF)
                ->view('<h3>A continuación se adjunta el archivo correspondiente a Depósito de seriedad.</h3>');

            if ($this->registrolote_modelo->editaRegistroClienteDS_EA($idCliente,$arreglo,$arreglo2)){
              if($this->email->send()){
                $data['message_email'] = 'OK';
              }else{
                $data['message_email'] = $this->email->print_debugger();
              }
              $data['message'] = 'OK';
            }else{
              die("ERROR");
            }
        }



        else if(!isset($_POST["pdfOK"]) || $_POST["pdfOK"] == '0' ) {
            $idCliente=$this->input->post('idCliente');
            $rfc=$this->input->post('rfc');
            $fechaNacimiento=$this->input->post('fechaNacimiento');
            $correo=$this->input->post('correo');
            $referencia1=$this->input->post('referencia1');
            $telreferencia1=$this->input->post('telreferencia1');
            $referencia2=$this->input->post('referencia2');
            $telreferencia2=$this->input->post('telreferencia2');
            $telefono1=$this->input->post('telefono1');
            $telefono2=$this->input->post('telefono2');
            $domicilio_particular=$this->input->post('domicilio_particular');
            $clave=$this->input->post('clave');
            $nacionalidad=$this->input->post('CAMPO21');
            $nombreCompleto=$this->input->post('nombre');
            $arreglo=array();
            $arreglo["rfc"]=$rfc;
            $arreglo["fechaNacimiento"]=$fechaNacimiento;
            $arreglo["correo"]=$correo;
            $arreglo["referencia1"]=$referencia1;
            $arreglo["telreferencia1"]=$telreferencia1;
            $arreglo["referencia2"]=$referencia2;
            $arreglo["telreferencia2"]=$telreferencia2;
            $arreglo["telefono1"]=$telefono1;
            $arreglo["telefono2"]=$telefono2;
            $arreglo2=array();
            $arreglo2["domicilio_particular"]=$domicilio_particular;
            $arreglo2["nombreCliente"]=$nombreCompleto;

            if(isset($_POST["desarrollo"])) {
                $arreglo2["desarrollo"] = $_POST["desarrollo"];

                if( $_POST["desarrollo"] == 1){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1" checked="checked"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';

                }
                if( $_POST["desarrollo"] == 2){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2" checked="checked"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';
                }
                if( $_POST["desarrollo"] == 3){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3" checked="checked"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';

                }
                if( $_POST["desarrollo"] == 4){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4" checked="checked"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';
                }

                if( $_POST["desarrollo"] == 5){
                    $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                    $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                    $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                    $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                    $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5" checked="checked"> Mérida';
                }


            }
            else if(!isset($_POST["desarrollo"])){
                $arreglo2["desarrollo"] = '0';
            }



            if(isset($_POST["CAMPO04"])) {
                $arreglo2["tipoLote"] = $_POST["CAMPO04"];




                if( $_POST["CAMPO04"] == 0){
                    $tipoLote = '<input type="radio" id="CAMPO04" name="CAMPO04" value="0" checked="checked"> Lote';
                    $tipoLote2 = '<input type="radio" id="CAMPO04" name="CAMPO04" value="1"> Lote Comercial';
                }

                if( $_POST["CAMPO04"] == 1){
                    $tipoLote = '<input type="radio" id="CAMPO04" name="CAMPO04" value="0"> Lote';
                    $tipoLote2 = '<input type="radio" id="CAMPO04" name="CAMPO04" value="1" checked="checked"> Lote Comercial';
                }

            } else if(!isset($_POST["CAMPO04"])){
                $arreglo2["tipoLote"] = '0';
            }




            if(isset($_POST["CAMPO05"])) {
                $arreglo2["idOficial_pf"] = $_POST["CAMPO05"];

                $idOf = '<input type="checkbox" id="CAMPO05" name="CAMPO05" value="1" checked="checked"> Identificación&nbsp;Oficial';

            } else if(!isset($_POST["CAMPO05"])){
                $idOf = '<input type="checkbox" id="CAMPO05" name="CAMPO05" value="1"> Identificación&nbsp;Oficial';

                $arreglo2["idOficial_pf"] = '0';
            }

            if(isset($_POST["CAMPO06"])) {
                $compDom = '<input type="checkbox" id="CAMPO06" name="CAMPO06" value="1" checked="checked"> Comprobante&nbsp;de&nbsp;Domicilio';
                $arreglo2["idDomicilio_pf"] = $_POST["CAMPO06"];
            } else if(!isset($_POST["CAMPO06"])){
                $compDom = '<input type="checkbox" id="CAMPO06" name="CAMPO06" value="1"> Comprobante&nbsp;de&nbsp;Domicilio';
                $arreglo2["idDomicilio_pf"] = '0';
            }

            if(isset($_POST["CAMPO07"])) {
                $actMat = '<input type="checkbox" id="CAMPO07" name="CAMPO07" value="1" checked="checked"> Acta&nbsp;de&nbsp;Matrimonio';
                $arreglo2["actaMatrimonio_pf"] = $_POST["CAMPO07"];
            } else if(!isset($_POST["CAMPO07"])){
                $actMat = '<input type="checkbox" id="CAMPO07" name="CAMPO07" value="1"> Acta&nbsp;de&nbsp;Matrimonio';
                $arreglo2["actaMatrimonio_pf"] = '0';
            }



            if(isset($_POST["CAMPO08"])) {
                $actConst = '<input type="checkbox" id="CAMPO08" name="CAMPO08" value="1" checked="checked"> Acta&nbsp;Constitutiva';
                $arreglo2["actaConstitutiva_pm"] = $_POST["CAMPO08"];
            } else if(!isset($_POST["CAMPO08"])){
                $actConst = '<input type="checkbox" id="CAMPO08" name="CAMPO08" value="1"> Acta&nbsp;Constitutiva';
                $arreglo2["actaConstitutiva_pm"] = '0';
            }


            if(isset($_POST["CAMPO09"])) {
                $cartaPoder = '<input type="checkbox" id="CAMPO09" name="CAMPO09" value="1" checked="checked"> Poder';
                $arreglo2["poder_pm"] = $_POST["CAMPO09"];
            } else if(!isset($_POST["CAMPO09"])){
                $cartaPoder = '<input type="checkbox" id="CAMPO09" name="CAMPO09" value="1"> Poder';
                $arreglo2["poder_pm"] = '0';
            }

            if(isset($_POST["CAMPO10"])) {
                $identApoderado = '<input type="checkbox" id="CAMPO10" name="CAMPO10" value="1" checked="checked"> Identificación&nbsp;Oficial&nbsp;Apoderado';
                $arreglo2["idOficialApoderado_pm"] = $_POST["CAMPO10"];
            } else if(!isset($_POST["CAMPO10"])){
                $identApoderado = '<input type="checkbox" id="CAMPO10" name="CAMPO10" value="1"> Identificación&nbsp;Oficial&nbsp;Apoderado';
                $arreglo2["idOficialApoderado_pm"] = '0';
            }



            if(isset($_POST["CAMPO12"])) {
                $rfcC = '<input type="checkbox" id="CAMPO12" name="CAMPO12" value="1" checked="checked"> RFC';
                $arreglo2["rfc"] = $_POST["CAMPO12"];
            } else if(!isset($_POST["CAMPO12"])){
                $rfcC = '<input type="checkbox" id="CAMPO12" name="CAMPO12" value="1"> RFC';
                $arreglo2["rfc"] = '0';
            }

            $arreglo2["nacionalidad"] =  $nacionalidad;
            $arreglo2["originario"] =  $originario = $_POST["CAMPO22"];
            $arreglo2["estadoCivil"] =  $estadoCivil = $_POST["CAMPO23"];
            $arreglo2["nombreConyuge"] =  $nombreConyuge = $_POST["CAMPO24"];
            $arreglo2["regimen"] =  $regimen = $_POST["CAMPO25"];
            $arreglo2["ocupacion"] =  $ocupacion = $_POST["CAMPO27"];
            $arreglo2["empresaLabora"] =  $empresaLabora = $_POST["CAMPO28"];
            $arreglo2["puesto"] =  $puesto = $_POST["CAMPO29"];
            $arreglo2["antigueda"] =  $antigueda = $_POST["CAMPO30"];
            $arreglo2["edadFirma"] =  $edadFirma = $_POST["CAMPO31"];
            $arreglo2["domicilioEmpresa"] =  $domicilioEmpresa = $_POST["CAMPO32"];
            $arreglo2["telefonoEmp"] =  $telefonoEmp = $_POST["CAMPO34"];


            if(isset($_POST["CAMPO35"])) {
                $arreglo2["casa"] = $_POST["CAMPO35"];

                if( $_POST["CAMPO35"] == 1){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1" checked="checked"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';
                }

                if( $_POST["CAMPO35"] == 2){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2" checked="checked"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

                if( $_POST["CAMPO35"] == 3){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3" checked="checked"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

                if( $_POST["CAMPO35"] == 4){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4" checked="checked"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

                if( $_POST["CAMPO35"] == 5){
                    $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                    $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                    $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                    $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                    $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5" checked="checked"> OTRO';}

            } else if(!isset($_POST["CAMPO35"])){
                $arreglo2["casa"] = '0';
            }



            $arreglo2["noLote"] =  $noLote = $_POST["numeroLote"];
            $arreglo2["cluster"] =  $cluster = $_POST["CAMPO38"];
            $arreglo2["super"] =  $super = $_POST["CAMPO39"];
            $arreglo2["noRefPago"] =  $noRefPago = $_POST["CAMPO40"];
            $costoM2 = $_POST["CAMPO41"];
            $arreglo2["costom2f"] =  $costom2f = $_POST["CAMPO41_1"];
            $arreglo2["proyecto"] =  $proyecto = $_POST["CAMPO42"];
            $arreglo2["municipio"] =  $municipio = $_POST["CAMPO43"];
            $arreglo2["importOferta"] =  $importOferta = $_POST["CAMPO44"];
            $arreglo2["letraImport"] =  $letraImport = $_POST["CAMPO45"];
            $arreglo2["cantidad"] =  $cantidad = $_POST["CAMPO46"];
            $arreglo2["letraCantidad"] =  $letraCantidad = $_POST["CAMPO47"];
            $arreglo2["saldoDeposito"] =  $saldoDeposito = $_POST["CAMPO48"];
            $arreglo2["aportMensualOfer"] =  $aportMensualOfer = $_POST["CAMPO49"];
            $arreglo2["fecha1erAport"] =  $fecha1erAport = $_POST["CAMPO50"];
            $arreglo2["plazo"] =  $plazo = $_POST["CAMPO51"];
            $arreglo2["fechaLiquidaDepo"] =  $fechaLiquidaDepo = $_POST["CAMPO52"];
            $arreglo2["fecha2daAport"] =  $fecha2daAport = $_POST["CAMPO53"];
            $arreglo2["municipio2"] =  $municipio2 = $_POST["CAMPO54"];
            $arreglo2["dia"] =  $dia = $_POST["CAMPO55"];
            $arreglo2["mes"] =  $mes = $_POST["CAMPO56"];
            $arreglo2["año"] =  $año = $_POST["CAMPO57"];
            $arreglo2["nombreFirOfertante"] =  $nombreFirOfertante = $_POST["CAMPO58"];
            $arreglo2["observacion"] =  $observacion = $_POST["CAMPO59"];
            $arreglo2["parentescoReferen"] =  $parentescoReferen = $_POST["CAMPO61"];
            $arreglo2["parentescoReferen2"] =  $parentescoReferen2 = $_POST["CAMPO64"];
            $arreglo2["nombreFirmaAsesor"] =  $nombreFirmaAsesor = $_POST["CAMPO66"];
            $arreglo2["email2"] =  $email2 = $_POST["CAMPO68"];
            $arreglo2["nombreFirmaAutoriza"] =  $nombreFirmaAutoriza = $_POST["CAMPO67"];
            $arreglo2["fechaCrate"] =  $fechaCrate = date('Y-m-d H:i:s');
            $arreglo2["idCliente"] =  $idCliente;


            if(isset($_POST["espectacular"])) {
                $espectacular = '<input type="checkbox" id="espectacular" name="espectacular" value="1" checked="checked"> ESPECTACULAR';
                $arreglo2["espectacular"] = '1';
            } else if(!isset($_POST["espectacular"])){
                $espectacular = '<input type="checkbox" id="espectacular" name="espectacular" value="1"> ESPECTACULAR';
                $arreglo2["espectacular"] = '0';
            }



            if(isset($_POST["volante"])) {
                $volante = '<input type="checkbox" id="volante" name="volante" value="1" checked="checked"> VOLANTE';
                $arreglo2["volante"] = '1';
            } else if(!isset($_POST["volante"])){
                $volante = '<input type="checkbox" id="volante" name="volante" value="1"> VOLANTE';
                $arreglo2["volante"] = '0';
            }



            if(isset($_POST["radio"])) {
                $radio = '<input type="checkbox" id="radio" name="radio" value="1" checked="checked"> RADIO';
                $arreglo2["radio"] = '1';
            } else if(!isset($_POST["radio"])){
                $radio = '<input type="checkbox" id="radio" name="radio" value="1"> RADIO';
                $arreglo2["radio"] = '0';
            }



            if(isset($_POST["periodico"])) {
                $periodico = '<input type="checkbox" id="periodico" name="periodico" value="1" checked="checked"> PERIÓDICO';
                $arreglo2["periodico"] = '1';
            } else if(!isset($_POST["periodico"])){
                $periodico = '<input type="checkbox" id="periodico" name="periodico" value="1"> PERIÓDICO';
                $arreglo2["periodico"] = '0';
            }



            if(isset($_POST["revista"])) {
                $revista = '<input type="checkbox" id="revista" name="revista" value="1" checked="checked"> REVISTA';
                $arreglo2["revista"] = '1';
            } else if(!isset($_POST["revista"])){
                $revista = '<input type="checkbox" id="revista" name="revista" value="1"> REVISTA';
                $arreglo2["revista"] = '0';
            }



            if(isset($_POST["redes"])) {
                $redes = '<input type="checkbox" id="redes" name="redes" value="1" checked="checked"> REDES SPCOALES';
                $arreglo2["redes"] = '1';
            } else if(!isset($_POST["redes"])){
                $redes = '<input type="checkbox" id="redes" name="redes" value="1"> REDES SPCOALES';
                $arreglo2["redes"] = '0';
            }




            if(isset($_POST["punto"])) {
                $punto = '<input type="checkbox" id="punto" name="punto" value="1" checked="checked"> PUNTO DE VENTA';
                $arreglo2["punto"] = '1';
            } else if(!isset($_POST["punto"])){
                $punto = '<input type="checkbox" id="punto" name="punto" value="1"> PUNTO DE VENTA';
                $arreglo2["punto"] = '0';
            }


            if(isset($_POST["invitacion"])) {
                $invitacion = '<input type="checkbox" id="invitacion" name="invitacion" value="1" checked="checked"> INVITACIÓN A EVENTO';
                $arreglo2["invitacion"] = '1';
            } else if(!isset($_POST["invitacion"])){
                $invitacion = '<input type="checkbox" id="invitacion" name="invitacion" value="1"> INVITACIÓN A EVENTO';
                $arreglo2["invitacion"] = '0';
            }



            if(isset($_POST["emailing"])) {
                $emailing = '<input type="checkbox" id="emailing" name="emailing" value="1" checked="checked"> E-MAILING';
                $arreglo2["emailing"] = '1';
            } else if(!isset($_POST["emailing"])){
                $emailing = '<input type="checkbox" id="emailing" name="emailing" value="1"> E-MAILING';
                $arreglo2["emailing"] = '0';
            }



            if(isset($_POST["pagina"])) {
                $pagina = '<input type="checkbox" id="pagina" name="pagina" value="1" checked="checked"> PÁGINA WEB';
                $arreglo2["pagina"] = '1';
            } else if(!isset($_POST["pagina"])){
                $pagina = '<input type="checkbox" id="pagina" name="pagina" value="1"> PÁGINA WEB';
                $arreglo2["pagina"] = '0';
            }



            if(isset($_POST["recomendacion"])) {
                $recomendacion = '<input type="checkbox" id="recomendacion" name="recomendacion" value="1" checked="checked"> RECOMENDACIÓN';
                $arreglo2["recomendacion"] = '1';
            } else if(!isset($_POST["recomendacion"])){
                $recomendacion = '<input type="checkbox" id="recomendacion" name="recomendacion" value="1"> RECOMENDACIÓN';
                $arreglo2["recomendacion"] = '0';
            }




            if(isset($_POST["convenio"])) {
                $convenio = '<input type="checkbox" id="convenio" name="convenio" value="1" checked="checked"> CONVENIO';
                $arreglo2["convenio"] = '1';
            } else if(!isset($_POST["convenio"])){
                $convenio = '<input type="checkbox" id="convenio" name="convenio" value="1"> CONVENIO';
                $arreglo2["convenio"] = '0';
            }



            if(isset($_POST["marketing"])) {
                $marketing = '<input type="checkbox" id="marketing" name="marketing" value="1" checked="checked"> MARKETING DIGITAL';
                $arreglo2["marketing"] = '1';
            } else if(!isset($_POST["marketing"])){
                $marketing = '<input type="checkbox" id="marketing" name="marketing" value="1"> MARKETING DIGITAL';
                $arreglo2["marketing"] = '0';
            }


            if(isset($_POST["otro1"])) {
                $otro1 = '<input type="checkbox" id="otro1" name="otro1" value="1" checked="checked"> OTRO';
                $arreglo2["otro1"] = '1';
            } else if(!isset($_POST["otro1"])){
                $otro1 = '<input type="checkbox" id="otro1" name="otro1" value="1"> OTRO';
                $arreglo2["otro1"] = '0';
            }


            if($_POST["especificar"]==12 || $_POST["especificar"]==6) {
                $especificar = '<input type="checkbox" id="especificar" name="especificar" value="1" checked="checked"> ESPECIFICAR';
                //$arreglo2["especificar"] = '12';
            } else if(!isset($_POST["especificar"])){
                $especificar = '<input type="checkbox" id="especificar" name="especificar" value="1"> ESPECIFICAR';
                //$arreglo2["especificar"] = '0';
            }
            $arreglo2["especificar"] = (empty($_POST["especificar"]))?'':$_POST["especificar"];


            if(isset($_POST["pase"])) {
                $pase = '<input type="checkbox" id="pase" name="pase" value="1" checked="checked"> PASE OFICINA';
                $arreglo2["pase"] = '1';
            } else if(!isset($_POST["pase"])){
                $pase = '<input type="checkbox" id="pase" name="pase" value="1"> PASE OFICINA';
                $arreglo2["pase"] = '0';
            }


            if(isset($_POST["modulo"])) {
                $modulo = '<input type="checkbox" id="modulo" name="modulo" value="1" checked="checked"> PASE MÓDULO EN PLAZAS';
                $arreglo2["modulo"] = '1';
            } else if(!isset($_POST["modulo"])){
                $modulo = '<input type="checkbox" id="modulo" name="modulo" value="1"> PASE MÓDULO EN PLAZAS';
                $arreglo2["modulo"] = '0';
            }


            if(isset($_POST["paseevento"])) {
                $paseevento = '<input type="checkbox" id="paseevento" name="paseevento" value="1" checked="checked"> PASE EVENTO';
                $arreglo2["paseevento"] = '1';
            } else if(!isset($_POST["paseevento"])){
                $paseevento = '<input type="checkbox" id="paseevento" name="paseevento" value="1"> PASE EVENTO';
                $arreglo2["paseevento"] = '0';
            }

            if(isset($_POST["pasedesarrollo"])) {
                $pasedesarrollo = '<input type="checkbox" id="pasedesarrollo" name="pasedesarrollo" value="1" checked="checked"> PASE DESARROLLO';
                $arreglo2["pasedesarrollo"] = '1';
            } else if(!isset($_POST["pasedesarrollo"])){
                $pasedesarrollo = '<input type="checkbox" id="pasedesarrollo" name="pasedesarrollo" value="1"> PASE DESARROLLO';
                $arreglo2["pasedesarrollo"] = '0';
            }

            if(isset($_POST["call"])) {
                $call = '<input type="checkbox" id="call" name="call" value="1" checked="checked"> CALL PICKER';
                $arreglo2["call"] = '1';
            } else if(!isset($_POST["call"])){
                $call = '<input type="checkbox" id="call" name="call" value="1"> CALL PICKER';
                $arreglo2["call"] = '0';
            }


            if(isset($_POST["pasedirecto"])) {
                $pasedirecto = '<input type="checkbox" id="pasedirecto" name="pasedirecto" value="1" checked="checked"> PASE DIRECTO DE MI PARTE';
                $arreglo2["pasedirecto"] = '1';
            } else if(!isset($_POST["pasedirecto"])){
                $pasedirecto = '<input type="checkbox" id="pasedirecto" name="pasedirecto" value="1"> PASE DIRECTO DE MI PARTE';
                $arreglo2["pasedirecto"] = '0';
            }


            if(isset($_POST["casaCheck"])) {
                $casaCheck = '<input type="checkbox" id="casaCheck" name="casaCheck" value="1" checked="checked"> CASA';
                $arreglo2["casaCheck"] = '1';
            } else if(!isset($_POST["casaCheck"])){
                $casaCheck = '<input type="checkbox" id="casaCheck" name="casaCheck" value="1"> CASA';
                $arreglo2["casaCheck"] = '0';
            }

            if(isset($_POST["oficina"])) {
                $oficina = '<input type="checkbox" id="oficina" name="oficina" value="1" checked="checked"> OFICINA';
                $arreglo2["oficina"] = '1';
            } else if(!isset($_POST["oficina"])){
                $oficina = '<input type="checkbox" id="oficina" name="oficina" value="1"> OFICINA';
                $arreglo2["oficina"] = '0';
            }


            if(isset($_POST["whatsapp"])) {
                $whatsapp = '<input type="checkbox" id="whatsapp" name="whatsapp" value="1" checked="checked"> WHATSAPP';
                $arreglo2["whatsapp"] = '1';
            } else if(!isset($_POST["whatsapp"])){
                $whatsapp = '<input type="checkbox" id="whatsapp" name="whatsapp" value="1"> WHATSAPP';
                $arreglo2["whatsapp"] = '0';
            }

            if(isset($_POST["email"])) {
                $email = '<input type="checkbox" id="email" name="email" value="1" checked="checked"> E-MAIL DE MI PARTE';
                $arreglo2["email"] = '1';
            } else if(!isset($_POST["email"])){
                $email = '<input type="checkbox" id="email" name="email" value="1"> E-MAIL DE MI PARTE';
                $arreglo2["email"] = '0';
            }

            if(isset($_POST["otro2"])) {
                $otro2 = '<input type="checkbox" id="otro2" name="otro2" value="1" checked="checked"> OTRO';
                $arreglo2["otro2"] = '1';
            } else if(!isset($_POST["otro2"])){
                $otro2 = '<input type="checkbox" id="otro2" name="otro2" value="1"> OTRO';
                $arreglo2["otro2"] = '0';
            }




            if ($this->registrolote_modelo->editaRegistroClienteDS_EA($idCliente,$arreglo,$arreglo2)){


            redirect(base_url().'index.php/Asesor/deposito_seriedad_ds/'.$idCliente.'/0');


            }else

            {

                die("ERROR");

            }


        }

    }
    public function replaceDocumentView(){
        $datos = [
            'residencial' => $this->registrolote_modelo->getResidencialQro(),
            'tieneAcciones' => 1,
            'tipoFiltro' => null,
            'funcionVista' => 'replaceDocumentView'
        ];
        
        $this->load->view('template/header');
        $this->load->view("documentacion/documentacion_view", $datos);
    }


    public function expedientesWS_DS($lotes) {
        $data = array_merge($this->registrolote_modelo->getdp_DS($lotes));
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }       
    }

    public function query_ds(){
        setlocale(LC_MONETARY, 'en_US');


        $enganchecf = $this->input->post('enganchecf');
        $precio_m2cf = $this->input->post('precio_m2cf');
        $precio_totalcf = $this->input->post('precio_totalcf');
        $msi1 = $this->input->post('msi1');
        $msi2 = $this->input->post('msi2');
        $msi3 = $this->input->post('msi3');
        $paquete = $this->input->post('paquete');


        $idCliente=$this->input->post('idCliente');
        $rfc=$this->input->post('rfc');
        $fechaNacimiento=$this->input->post('fechaNacimiento');
        $correo=$this->input->post('correo');
        $referencia1=$this->input->post('referencia1');
        $telreferencia1=$this->input->post('telreferencia1');
        $referencia2=$this->input->post('referencia2');
        $telreferencia2=$this->input->post('telreferencia2');
        $telefono1=$this->input->post('telefono1');
        $telefono2=$this->input->post('telefono2');
        $domicilio_particular=$this->input->post('domicilio_particular');


        $clave=$this->input->post('clave');

        $nacionalidad=$this->input->post('CAMPO21');
        $nombreCompleto=$this->input->post('nombre');


        $arreglo=array();
        $arreglo["rfc"]=$rfc;
        $arreglo["fechaNacimiento"]=$fechaNacimiento;
        $arreglo["correo"]=$correo;
        $arreglo["referencia1"]=$referencia1;
        $arreglo["telreferencia1"]=$telreferencia1;
        $arreglo["referencia2"]=$referencia2;
        $arreglo["telreferencia2"]=$telreferencia2;
        $arreglo["telefono1"]=$telefono1;
        $arreglo["telefono2"]=$telefono2;





        $arreglo2=array();
        $arreglo2["domicilio_particular"]=$domicilio_particular;
        $arreglo2["nombreCliente"]=$nombreCompleto;

        if(isset($_POST["desarrollo"])) {
            $arreglo2["desarrollo"] = $_POST["desarrollo"];

            if( $_POST["desarrollo"] == 1){
                $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1" checked="checked"> Queretaro';
                $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';
            }
            if( $_POST["desarrollo"] == 2){
                $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2" checked="checked"> Leon';
                $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';
            }
            if( $_POST["desarrollo"] == 3){
                $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3" checked="checked"> Celaya';
                $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';

            }
            if( $_POST["desarrollo"] == 4){
                $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4" checked="checked"> San Luis Potosí';
                $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5"> Mérida';

            }
            if( $_POST["desarrollo"] == 5){
                $desarrollo = '<input type="radio" id="desarrollo" name="desarrollo" value="1"> Queretaro';
                $desarrollo2 = '<input type="radio" id="desarrollo" name="desarrollo" value="2"> Leon';
                $desarrollo3 = '<input type="radio" id="desarrollo" name="desarrollo" value="3"> Celaya';
                $desarrollo4 = '<input type="radio" id="desarrollo" name="desarrollo" value="4"> San Luis Potosí';
                $desarrollo5 = '<input type="radio" id="desarrollo" name="desarrollo" value="5" checked="checked"> Mérida';

            }



        }

        else if(!isset($_POST["desarrollo"])){
            $arreglo2["desarrollo"] = '0';
        }

        if(isset($_POST["CAMPO04"])) {
            $arreglo2["tipoLote"] = $_POST["CAMPO04"];
            if( $_POST["CAMPO04"] == 0){
                $tipoLote = '<input type="radio" id="CAMPO04" name="CAMPO04" value="0" checked="checked"> Lote';
                $tipoLote2 = '<input type="radio" id="CAMPO04" name="CAMPO04" value="1"> Lote Comercial';
            }

            if( $_POST["CAMPO04"] == 1){
                $tipoLote = '<input type="radio" id="CAMPO04" name="CAMPO04" value="0"> Lote';
                $tipoLote2 = '<input type="radio" id="CAMPO04" name="CAMPO04" value="1" checked="checked"> Lote Comercial';
            }

        } else if(!isset($_POST["CAMPO04"])){
            $arreglo2["tipoLote"] = '0';
        }


        if(isset($_POST["CAMPO05"])) {
            $arreglo2["idOficial_pf"] = $_POST["CAMPO05"];

            $idOf = '<input type="checkbox" id="CAMPO05" name="CAMPO05" value="1" checked="checked"> Identificación&nbsp;Oficial';

        } else if(!isset($_POST["CAMPO05"])){
            $idOf = '<input type="checkbox" id="CAMPO05" name="CAMPO05" value="1"> Identificación&nbsp;Oficial';

            $arreglo2["idOficial_pf"] = '0';
        }

        if(isset($_POST["CAMPO06"])) {
            $compDom = '<input type="checkbox" id="CAMPO06" name="CAMPO06" value="1" checked="checked"> Comprobante&nbsp;de&nbsp;Domicilio';
            $arreglo2["idDomicilio_pf"] = $_POST["CAMPO06"];
        } else if(!isset($_POST["CAMPO06"])){
            $compDom = '<input type="checkbox" id="CAMPO06" name="CAMPO06" value="1"> Comprobante&nbsp;de&nbsp;Domicilio';
            $arreglo2["idDomicilio_pf"] = '0';
        }

        if(isset($_POST["CAMPO07"])) {
            $actMat = '<input type="checkbox" id="CAMPO07" name="CAMPO07" value="1" checked="checked"> Acta&nbsp;de&nbsp;Matrimonio';
            $arreglo2["actaMatrimonio_pf"] = $_POST["CAMPO07"];
        } else if(!isset($_POST["CAMPO07"])){
            $actMat = '<input type="checkbox" id="CAMPO07" name="CAMPO07" value="1"> Acta&nbsp;de&nbsp;Matrimonio';
            $arreglo2["actaMatrimonio_pf"] = '0';
        }



        if(isset($_POST["CAMPO08"])) {
            $actConst = '<input type="checkbox" id="CAMPO08" name="CAMPO08" value="1" checked="checked"> Acta&nbsp;Constitutiva';
            $arreglo2["actaConstitutiva_pm"] = $_POST["CAMPO08"];
        } else if(!isset($_POST["CAMPO08"])){
            $actConst = '<input type="checkbox" id="CAMPO08" name="CAMPO08" value="1"> Acta&nbsp;Constitutiva';
            $arreglo2["actaConstitutiva_pm"] = '0';
        }


        if(isset($_POST["CAMPO09"])) {
            $cartaPoder = '<input type="checkbox" id="CAMPO09" name="CAMPO09" value="1" checked="checked"> Poder';
            $arreglo2["poder_pm"] = $_POST["CAMPO09"];
        } else if(!isset($_POST["CAMPO09"])){
            $cartaPoder = '<input type="checkbox" id="CAMPO09" name="CAMPO09" value="1"> Poder';
            $arreglo2["poder_pm"] = '0';
        }

        if(isset($_POST["CAMPO10"])) {
            $identApoderado = '<input type="checkbox" id="CAMPO10" name="CAMPO10" value="1" checked="checked"> Identificación&nbsp;Oficial&nbsp;Apoderado';
            $arreglo2["idOficialApoderado_pm"] = $_POST["CAMPO10"];
        } else if(!isset($_POST["CAMPO10"])){
            $identApoderado = '<input type="checkbox" id="CAMPO10" name="CAMPO10" value="1"> Identificación&nbsp;Oficial&nbsp;Apoderado';
            $arreglo2["idOficialApoderado_pm"] = '0';
        }



        if(isset($_POST["CAMPO12"])) {
            $rfcC = '<input type="checkbox" id="CAMPO12" name="CAMPO12" value="1" checked="checked"> RFC';
            $arreglo2["rfc"] = $_POST["CAMPO12"];
        } else if(!isset($_POST["CAMPO12"])){
            $rfcC = '<input type="checkbox" id="CAMPO12" name="CAMPO12" value="1"> RFC';
            $arreglo2["rfc"] = '0';
        }


        $arreglo2["nacionalidad"] =  $nacionalidad;
        $arreglo2["originario"] =  $originario = $_POST["CAMPO22"];
        $arreglo2["estadoCivil"] =  $estadoCivil = $_POST["CAMPO23"];
        $arreglo2["nombreConyuge"] =  $nombreConyuge = $_POST["CAMPO24"];
        $arreglo2["regimen"] =  $regimen = $_POST["CAMPO25"];
        $arreglo2["ocupacion"] =  $ocupacion = $_POST["CAMPO27"];
        $arreglo2["empresaLabora"] =  $empresaLabora = $_POST["CAMPO28"];
        $arreglo2["puesto"] =  $puesto = $_POST["CAMPO29"];
        $arreglo2["antigueda"] =  $antigueda = $_POST["CAMPO30"];
        $arreglo2["edadFirma"] =  $edadFirma = $_POST["CAMPO31"];
        $arreglo2["domicilioEmpresa"] =  $domicilioEmpresa = $_POST["CAMPO32"];
        $arreglo2["telefonoEmp"] =  $telefonoEmp = $_POST["CAMPO34"];


        if(isset($_POST["CAMPO35"])) {
            $arreglo2["casa"] = $_POST["CAMPO35"];

            if( $_POST["CAMPO35"] == 1){
                $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1" checked="checked"> PROPIA';
                $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';
            }

            if( $_POST["CAMPO35"] == 2){
                $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2" checked="checked"> RENTADA';
                $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

            if( $_POST["CAMPO35"] == 3){
                $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3" checked="checked"> PAGÁNDOSE';
                $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

            if( $_POST["CAMPO35"] == 4){
                $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4" checked="checked"> FAMILIAR';
                $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5"> OTRO';}

            if( $_POST["CAMPO35"] == 5){
                $casa = '<input type="radio" id="CAMPO35" name="CAMPO35" value="1"> PROPIA';
                $casa2 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="2"> RENTADA';
                $casa3 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="3"> PAGÁNDOSE';
                $casa4 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="4"> FAMILIAR';
                $casa5 = '<input type="radio" id="CAMPO35" name="CAMPO35" value="5" checked="checked"> OTRO';}

        } else if(!isset($_POST["CAMPO35"])){
            $arreglo2["casa"] = '0';
        }

        $arreglo2["noLote"] =  $noLote = $_POST["numeroLote"];
        $arreglo2["cluster"] =  $cluster = $_POST["CAMPO38"];
        $arreglo2["super"] =  $super = $_POST["CAMPO39"];
        $arreglo2["noRefPago"] =  $noRefPago = $_POST["CAMPO40"];
        $costoM2 = $_POST["CAMPO41"];
        $arreglo2["costom2f"] =  $costom2f = $_POST["CAMPO41_1"];
        $arreglo2["proyecto"] =  $proyecto = $_POST["CAMPO42"];
        $arreglo2["municipio"] =  $municipio = $_POST["CAMPO43"];
        $arreglo2["importOferta"] =  $importOferta = $_POST["CAMPO44"];
        $arreglo2["letraImport"] =  $letraImport = $_POST["CAMPO45"];
        $arreglo2["cantidad"] =  $cantidad = $_POST["CAMPO46"];
        $arreglo2["letraCantidad"] =  $letraCantidad = $_POST["CAMPO47"];
        $arreglo2["saldoDeposito"] =  $saldoDeposito = $_POST["CAMPO48"];
        $arreglo2["aportMensualOfer"] =  $aportMensualOfer = $_POST["CAMPO49"];
        $arreglo2["fecha1erAport"] =  $fecha1erAport = $_POST["CAMPO50"];
        $arreglo2["plazo"] =  $plazo = $_POST["CAMPO51"];
        $arreglo2["fechaLiquidaDepo"] =  $fechaLiquidaDepo = $_POST["CAMPO52"];
        $arreglo2["fecha2daAport"] =  $fecha2daAport = $_POST["CAMPO53"];
        $arreglo2["municipio2"] =  $municipio2 = $_POST["CAMPO54"];
        $arreglo2["dia"] =  $dia = $_POST["CAMPO55"];
        $arreglo2["mes"] =  $mes = $_POST["CAMPO56"];
        $arreglo2["año"] =  $año = $_POST["CAMPO57"];
        $arreglo2["nombreFirOfertante"] =  $nombreFirOfertante = $_POST["CAMPO58"];
        $arreglo2["observacion"] =  $observacion = $_POST["CAMPO59"];
        $arreglo2["parentescoReferen"] =  $parentescoReferen = $_POST["CAMPO61"];
        $arreglo2["parentescoReferen2"] =  $parentescoReferen2 = $_POST["CAMPO64"];
        $arreglo2["nombreFirmaAsesor"] =  $nombreFirmaAsesor = $_POST["CAMPO66"];
        $arreglo2["email2"] =  $email2 = $_POST["CAMPO68"];
        $arreglo2["nombreFirmaAutoriza"] =  $nombreFirmaAutoriza = $_POST["CAMPO67"];
        $arreglo2["fechaCrate"] =  $fechaCrate = date('Y-m-d H:i:s');
        $arreglo2["idCliente"] =  $idCliente;


        if(isset($_POST["espectacular"])) {
            $espectacular = '<input type="checkbox" id="espectacular" name="espectacular" value="1" checked="checked"> ESPECTACULAR';
            $arreglo2["espectacular"] = '1';
        } else if(!isset($_POST["espectacular"])){
            $espectacular = '<input type="checkbox" id="espectacular" name="espectacular" value="1"> ESPECTACULAR';
            $arreglo2["espectacular"] = '0';
        }

        if(isset($_POST["volante"])) {
            $volante = '<input type="checkbox" id="volante" name="volante" value="1" checked="checked"> VOLANTE';
            $arreglo2["volante"] = '1';
        } else if(!isset($_POST["volante"])){
            $volante = '<input type="checkbox" id="volante" name="volante" value="1"> VOLANTE';
            $arreglo2["volante"] = '0';
        }

        if(isset($_POST["radio"])) {
            $radio = '<input type="checkbox" id="radio" name="radio" value="1" checked="checked"> RADIO';
            $arreglo2["radio"] = '1';
        } else if(!isset($_POST["radio"])){
            $radio = '<input type="checkbox" id="radio" name="radio" value="1"> RADIO';
            $arreglo2["radio"] = '0';
        }

        if(isset($_POST["periodico"])) {
            $periodico = '<input type="checkbox" id="periodico" name="periodico" value="1" checked="checked"> PERIÓDICO';
            $arreglo2["periodico"] = '1';
        } else if(!isset($_POST["periodico"])){
            $periodico = '<input type="checkbox" id="periodico" name="periodico" value="1"> PERIÓDICO';
            $arreglo2["periodico"] = '0';
        }

        if(isset($_POST["revista"])) {
            $revista = '<input type="checkbox" id="revista" name="revista" value="1" checked="checked"> REVISTA';
            $arreglo2["revista"] = '1';
        } else if(!isset($_POST["revista"])){
            $revista = '<input type="checkbox" id="revista" name="revista" value="1"> REVISTA';
            $arreglo2["revista"] = '0';
        }



        if(isset($_POST["redes"])) {
            $redes = '<input type="checkbox" id="redes" name="redes" value="1" checked="checked"> REDES SPCOALES';
            $arreglo2["redes"] = '1';
        } else if(!isset($_POST["redes"])){
            $redes = '<input type="checkbox" id="redes" name="redes" value="1"> REDES SPCOALES';
            $arreglo2["redes"] = '0';
        }




        if(isset($_POST["punto"])) {
            $punto = '<input type="checkbox" id="punto" name="punto" value="1" checked="checked"> PUNTO DE VENTA';
            $arreglo2["punto"] = '1';
        } else if(!isset($_POST["punto"])){
            $punto = '<input type="checkbox" id="punto" name="punto" value="1"> PUNTO DE VENTA';
            $arreglo2["punto"] = '0';
        }


        if(isset($_POST["invitacion"])) {
            $invitacion = '<input type="checkbox" id="invitacion" name="invitacion" value="1" checked="checked"> INVITACIÓN A EVENTO';
            $arreglo2["invitacion"] = '1';
        } else if(!isset($_POST["invitacion"])){
            $invitacion = '<input type="checkbox" id="invitacion" name="invitacion" value="1"> INVITACIÓN A EVENTO';
            $arreglo2["invitacion"] = '0';
        }



        if(isset($_POST["emailing"])) {
            $emailing = '<input type="checkbox" id="emailing" name="emailing" value="1" checked="checked"> E-MAILING';
            $arreglo2["emailing"] = '1';
        } else if(!isset($_POST["emailing"])){
            $emailing = '<input type="checkbox" id="emailing" name="emailing" value="1"> E-MAILING';
            $arreglo2["emailing"] = '0';
        }



        if(isset($_POST["pagina"])) {
            $pagina = '<input type="checkbox" id="pagina" name="pagina" value="1" checked="checked"> PÁGINA WEB';
            $arreglo2["pagina"] = '1';
        } else if(!isset($_POST["pagina"])){
            $pagina = '<input type="checkbox" id="pagina" name="pagina" value="1"> PÁGINA WEB';
            $arreglo2["pagina"] = '0';
        }



        if(isset($_POST["recomendacion"])) {
            $recomendacion = '<input type="checkbox" id="recomendacion" name="recomendacion" value="1" checked="checked"> RECOMENDACIÓN';
            $arreglo2["recomendacion"] = '1';
        } else if(!isset($_POST["recomendacion"])){
            $recomendacion = '<input type="checkbox" id="recomendacion" name="recomendacion" value="1"> RECOMENDACIÓN';
            $arreglo2["recomendacion"] = '0';
        }




        if(isset($_POST["convenio"])) {
            $convenio = '<input type="checkbox" id="convenio" name="convenio" value="1" checked="checked"> CONVENIO';
            $arreglo2["convenio"] = '1';
        } else if(!isset($_POST["convenio"])){
            $convenio = '<input type="checkbox" id="convenio" name="convenio" value="1"> CONVENIO';
            $arreglo2["convenio"] = '0';
        }



        if(isset($_POST["marketing"])) {
            $marketing = '<input type="checkbox" id="marketing" name="marketing" value="1" checked="checked"> MARKETING DIGITAL';
            $arreglo2["marketing"] = '1';
        } else if(!isset($_POST["marketing"])){
            $marketing = '<input type="checkbox" id="marketing" name="marketing" value="1"> MARKETING DIGITAL';
            $arreglo2["marketing"] = '0';
        }


        if(isset($_POST["otro1"])) {
            $otro1 = '<input type="checkbox" id="otro1" name="otro1" value="1" checked="checked"> OTRO';
            $arreglo2["otro1"] = '1';
        } else if(!isset($_POST["otro1"])){
            $otro1 = '<input type="checkbox" id="otro1" name="otro1" value="1"> OTRO';
            $arreglo2["otro1"] = '0';
        }


        if(isset($_POST["especificar"])) {
            $especificar = '<input type="checkbox" id="especificar" name="especificar" value="1" checked="checked"> ESPECIFICAR';
            $arreglo2["especificar"] = '12';
        } else if(!isset($_POST["especificar"])){
            $especificar = '<input type="checkbox" id="especificar" name="especificar" value="1"> ESPECIFICAR';
            $arreglo2["especificar"] = '0';
        }


        if(isset($_POST["pase"])) {
            $pase = '<input type="checkbox" id="pase" name="pase" value="1" checked="checked"> PASE OFICINA';
            $arreglo2["pase"] = '1';
        } else if(!isset($_POST["pase"])){
            $pase = '<input type="checkbox" id="pase" name="pase" value="1"> PASE OFICINA';
            $arreglo2["pase"] = '0';
        }




        if(isset($_POST["modulo"])) {
            $modulo = '<input type="checkbox" id="modulo" name="modulo" value="1" checked="checked"> PASE MÓDULO EN PLAZAS';
            $arreglo2["modulo"] = '1';
        } else if(!isset($_POST["modulo"])){
            $modulo = '<input type="checkbox" id="modulo" name="modulo" value="1"> PASE MÓDULO EN PLAZAS';
            $arreglo2["modulo"] = '0';
        }



        if(isset($_POST["paseevento"])) {
            $paseevento = '<input type="checkbox" id="paseevento" name="paseevento" value="1" checked="checked"> PASE EVENTO';
            $arreglo2["paseevento"] = '1';
        } else if(!isset($_POST["paseevento"])){
            $paseevento = '<input type="checkbox" id="paseevento" name="paseevento" value="1"> PASE EVENTO';
            $arreglo2["paseevento"] = '0';
        }







        if(isset($_POST["pasedesarrollo"])) {
            $pasedesarrollo = '<input type="checkbox" id="pasedesarrollo" name="pasedesarrollo" value="1" checked="checked"> PASE DESARROLLO';
            $arreglo2["pasedesarrollo"] = '1';
        } else if(!isset($_POST["pasedesarrollo"])){
            $pasedesarrollo = '<input type="checkbox" id="pasedesarrollo" name="pasedesarrollo" value="1"> PASE DESARROLLO';
            $arreglo2["pasedesarrollo"] = '0';
        }





        if(isset($_POST["call"])) {
            $call = '<input type="checkbox" id="call" name="call" value="1" checked="checked"> CALL PICKER';
            $arreglo2["call"] = '1';
        } else if(!isset($_POST["call"])){
            $call = '<input type="checkbox" id="call" name="call" value="1"> CALL PICKER';
            $arreglo2["call"] = '0';
        }






        if(isset($_POST["pasedirecto"])) {
            $pasedirecto = '<input type="checkbox" id="pasedirecto" name="pasedirecto" value="1" checked="checked"> PASE DIRECTO DE MI PARTE';
            $arreglo2["pasedirecto"] = '1';
        } else if(!isset($_POST["pasedirecto"])){
            $pasedirecto = '<input type="checkbox" id="pasedirecto" name="pasedirecto" value="1"> PASE DIRECTO DE MI PARTE';
            $arreglo2["pasedirecto"] = '0';
        }




        if(isset($_POST["casaCheck"])) {
            $casaCheck = '<input type="checkbox" id="casaCheck" name="casaCheck" value="1" checked="checked"> CASA';
            $arreglo2["casaCheck"] = '1';
        } else if(!isset($_POST["casaCheck"])){
            $casaCheck = '<input type="checkbox" id="casaCheck" name="casaCheck" value="1"> CASA';
            $arreglo2["casaCheck"] = '0';
        }




        if(isset($_POST["oficina"])) {
            $oficina = '<input type="checkbox" id="oficina" name="oficina" value="1" checked="checked"> OFICINA';
            $arreglo2["oficina"] = '1';
        } else if(!isset($_POST["oficina"])){
            $oficina = '<input type="checkbox" id="oficina" name="oficina" value="1"> OFICINA';
            $arreglo2["oficina"] = '0';
        }




        if(isset($_POST["whatsapp"])) {
            $whatsapp = '<input type="checkbox" id="whatsapp" name="whatsapp" value="1" checked="checked"> WHATSAPP';
            $arreglo2["whatsapp"] = '1';
        } else if(!isset($_POST["whatsapp"])){
            $whatsapp = '<input type="checkbox" id="whatsapp" name="whatsapp" value="1"> WHATSAPP';
            $arreglo2["whatsapp"] = '0';
        }



        if(isset($_POST["email"])) {
            $email = '<input type="checkbox" id="email" name="email" value="1" checked="checked"> E-MAIL DE MI PARTE';
            $arreglo2["email"] = '1';
        } else if(!isset($_POST["email"])){
            $email = '<input type="checkbox" id="email" name="email" value="1"> E-MAIL DE MI PARTE';
            $arreglo2["email"] = '0';
        }



        if(isset($_POST["otro2"])) {
            $otro2 = '<input type="checkbox" id="otro2" name="otro2" value="1" checked="checked"> OTRO';
            $arreglo2["otro2"] = '1';
        } else if(!isset($_POST["otro2"])){
            $otro2 = '<input type="checkbox" id="otro2" name="otro2" value="1"> OTRO';
            $arreglo2["otro2"] = '0';
        }





        ///CONVERTIMOS A ARREGLO TANTO LOS DESCUENTOS ACTUALES COMO EL NUEVO A AGREGAR
        $arrayCorreo = explode(",", $correo);
        //// CHECAMOS SI EN EL ARREGLO NO HAY POSICIONES VACIAS Y LAS ELIMINAMOS
        $listCheckVacio = array_filter($arrayCorreo, "strlen");
        ////VERIFICAMOS QUE NUESTRO ARREGLO NO TENGA DATOS REPETIDOS
        $arrayCorreoNotRepeat=array_unique($listCheckVacio);
        ////EL ARREGLO FINAL LO CONVERTIMOS A STRING
        // $resCorreo = implode( ",", $arrayCorreoNotRepeat);



        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);


        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Sistemas María José Martínez Martínez');
        $pdf->SetTitle('DEPÓSITO DE SERIEDAD');
        $pdf->SetSubject('CONSTANCIA DE RELACION EMPRESA TRABAJADOR');
        $pdf->SetKeywords('CONSTANCIA, CIUDAD MADERAS, RELACION, EMPRESA, TRABAJADOR');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(15, 15, 15, true);


        $pdf->AddPage('P', 'LEGAL');

        $pdf->SetFont('Helvetica', '', 5, '', true);





        $pdf->SetFooterMargin(0);
        $bMargin = $pdf->getBreakMargin();
        $auto_page_break = $pdf->getAutoPageBreak();
        $pdf->Image('static/images/ar4c.png', 120, 15, 300, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
        $pdf->setPageMark();




        $html = '
    <!DOCTYPE html>
    <html lang="en">
       <head>
          <link rel="shortcut icon" href="'.base_url().'static/images/arbol_cm.png" />
          <link href="<?=base_url()?>dist/css/bootstrap.min.css" rel="stylesheet" />
          <!--  Material Dashboard CSS    -->
          <link href="<?=base_url()?>dist/css/material-dashboard.css" rel="stylesheet" />
          <!--  CSS for Demo Purpose, don\'t include it in your project     -->
          <link href="<?=base_url()?>dist/css/demo.css" rel="stylesheet" />
          <!--     Fonts and icons     -->
          <link href="<?=base_url()?>dist/css/font-awesome.css" rel="stylesheet" />
          <link href="<?=base_url()?>dist/css/google-roboto-300-700.css" rel="stylesheet" />
          <style>
          body{color: #084c94;}
          .espacio{padding: 5%;}
          .espaciodos{padding: 10%;} 
          h2{font-weight: bold;color: #084c94;}
          .save {display:scroll;position:fixed;bottom:225px;right:17px;z-index: 3;}
          p{color: #084c94;}
          .col-xs-16 {width: 3px;float: left;}
          .col-xs-17 {width: 16%;float: left;}
          #imagenbg {position: relative;top:1500px;z-index: -1;}
          #fichadeposito {position: absolute;z-index: 2;}
          .mySectionPdf
          {
             padding: 20px;
          }
          .form-group.is-focused .form-control {
            outline: none;
            background-image: linear-gradient(#0c63c5, #177beb), linear-gradient(#D2D2D2, #D2D2D2);
            background-size: 100% 2px, 100% 1px;
            box-shadow: none;
            transition-duration: 0.3s;
          }
          b{
          font-size: 8px;
          }
          </style>
       </head>
       <body>
              <div id="fichadeposito" name="fichadeposito" class="fichadeposito">
                  <div id="muestra"> 
                    <table border="0" width="100%" id="tabla" align="center">
                      
                      <tr>
                       <td width="70%" align="left" >
                           <br>
                      <label>
                         <h1 style="margin-right: 50px;"> DEPÓSITO DE SERIEDAD</h1>
                      </label>
                        </td>
                        <td align="right" width="15%">
                        <br><br><br>
                           <p style="margin-right: 2px;">FOLIO</p>
                        </td>
                        <td width="15%" style="border-bottom:1px solid #CCCCCC">
                                 <p style="color: red;font-size:14px;">'.$clave.'</p>
                        </td>
                      </tr>
                    </table>
                    <table border="0" width="100%" align="" align="">
                      <tr>
                        <th rowspan="4" width="283" align="left">
                         <img src="'.base_url().'/static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width: 250px"/>
                        </th>
                        <td width="367">
                          <h5><p style="font-size:9px;"><strong>DESARROLLO:</strong></p></h5>
                        </td>
                      </tr>
                      <tr>
                        <td width="367">
                          <table border="0" width="100%">
                            <tr>
                              <td width="10%"></td>
                              <td width="20%">
                              '.$desarrollo.'
                              </td>
                              <td width="20%">
                              '.$desarrollo2.'
                              </td>
                              <td width="20%">
                              '.$desarrollo3.'
                              </td>
                              <td width="20%">
                              '.$desarrollo4.'
                              </td>
                              <td width="20%">
                              '.$desarrollo5.'
                              </td>
                   
                            </tr>
                            <tr>
                              <td width="10%"></td>
                              <td width="20%">
                              '.$tipoLote.'
                              </td>
                              <td width="20%">
                              '.$tipoLote2.'
                              </td>
                              <td width="15%"></td>
                              <td width="15%"></td>
                              <td width="30%"></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h5><p style="font-size:9px;"><strong>DOCUMENTACIÓN ENTREGADA:</strong></p></h5>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table border="0" width="100%">
                            <tr>
                              <td width="19 %"><p><strong>Personas&nbsp;Físicas</strong></p></td>
    
                              <td width="23%">
                              '.$idOf.'
                              </td>
                              <td width="27%">
                              '.$compDom.'
                              </td>
                              <td width="29%" colspan="2">
                              '.$actMat.'
                              </td>
                            </tr>
                            <tr>
                              <td width="19%"><p><strong>Personas&nbsp;Morales</strong></p></td>
                              <td width="23%">
                              '.$actConst.'
                              </td>
                              <td width="27%">
                              '.$cartaPoder.'
                              </td>
                              <td width="29%" colspan="2">
                              '.$identApoderado.'
                              </td>
                            </tr>
                            <tr>
                              <td width="19%"></td>
                              <td width="35%">
                              </td>
                              <td width="15%"></td>
                              <td width="55%" colspan="3">
                              '.$rfcC.'
                              <input type="text" class="form-cont" id="CAMPO13" name="CAMPO13" value="'.$rfc.'" size="24">
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td width="100%" colspan="2">
                          <br>
                        </td>
                      </tr>
                      <tr>
                        <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC; margin: 0px 0px 150px 0px">
                        <label>
                           NOMBRE(<b><span style="color: red;">*</span></b>):
                           </label><br><br>
                           <b>&nbsp;'.$nombreCompleto.' <br></b>
                                           
                        </td>
                      </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                      <tr>
                
                              <td width="47.5%" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                            TELÉFONO CASA:
                           </label><br><br>
                                  <b style="padding-left: 250px">&nbsp;'.$telefono1.'</b><br>
                                  
                              </td>
                              <td width="5%"></td>
                              <td width="47.5%" colspan="2" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                                CELULAR (<b><span style="color: red;">*</span></b>)
                           </label><br><br>
                                  <b>&nbsp;'.$telefono2.'</b><br>
                               
                              </td> 
               
                      </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                      <tr>
                        <td width="100%" colspan="2" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                           EMAIL (<b><span style="color: red;">*</span></b>)
                      </label><br><br>
                      <b>&nbsp;'.$correo.'</b><br>
                        </td>
                      </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                     <tr>
                       <td width="30%" colspan="2" style="border-bottom: 1px solid #CCCCCC">
                      <label>
                         FECHA DE NACIMIENTO (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br>                 
                            <b>'.$fechaNacimiento.'</b><br>
                        </td>   
                        <td width="5%"></td>
                        <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                         NACIONALIDAD (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br>  
                            <b>&nbsp;'.$nacionalidad.'</b>
                        </td>    
                        <td width="5%"></td>          
                        <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                         ORIGINARIO DE (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br> 
                      <b>&nbsp;'.$originario.'</b>
                        </td>
                     </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                    <tr>
                       <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                          <label>
                         ESTADO CIVIL (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br> 
                            <b>&nbsp;'.$estadoCivil.'</b><br>
                        </td>  
                        <td width="5%"></td>     
                        <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                         NOMBRE DEL CÓNYUGE
                      </label>  <br><br> 
                            <b>&nbsp;'.$nombreConyuge.'</b><br>
                        </td>    
                        <td width="5%"></td>              
                        <td width="30%" style="border-bottom: 1px solid #CCCCCC">
                           <label>
                         RÉGIMEN (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br> 
                            <b>&nbsp;'.$regimen.'</b><br>
                                                       
                        </td>
                    </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                      <tr>
                        <td width="100%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                           <label>
                         DOMICILIO PARTICULAR (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br>
                           <b>&nbsp;'.$domicilio_particular.'</b><br>                    
                        </td> 
                        </tr>
                        <tr>
                        <td width="100%" colspan="2"></td>
                      </tr>
                      <tr>
                       <td width="47.5%" style="border-bottom:1px solid #CCCCCC;">
                          <label>
                         OCUPACIÓN (<b><span style="color: red;">*</span></b>)
                      </label>  <br><br>
                             <b>&nbsp;'.$ocupacion.'</b><br>
                        </td> 
                        <td width="5%"></td>
                        <td width="47.5%" style="border-bottom:1px solid #CCCCCC;">
                           <label>
                         EMPRESA EN LA QUE TRABAJA
                      </label>  <br><br>
                            <b>&nbsp;'.$empresaLabora.'</b><br>
                              
                        </td>            
                      </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                     <tr>
                   <td width="30%" style="border-bottom:1px solid #CCCCCC;">
                          <label>
                             PUESTO (<b><span style="color: red;">*</span></b>)
                          </label><br><br>
                             <b>&nbsp;'.$puesto.'</b><br>
                   </td>   
                   <td width="5%"></td>
                   <td width="30%" style="border-bottom:1px solid #CCCCCC;">
                          <label>
                             ANTIGÜEDAD (AÑOS)
                          </label><br><br>
                             <b>&nbsp;'.$antigueda.'</b><br>
                   </td> 
                   <td width="5%"></td>   
                   <td width="30%" style="border-bottom:1px solid #CCCCCC;">
                          <label>
                             EDAD AL MOMENTO DE LA FIRMA (<b><span style="color: red;">*</span></b>)
                          </label><br><br>
                              <b>&nbsp;'.$edadFirma.'</b><br>
                   </td>
                     </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                      <tr>
                        <td width="100%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                           <label>
                             DOMICILIO EMPRESA
                          </label><br><br>
                           <b>&nbsp;'.$domicilioEmpresa.'</b><br>
                        </td>
                      </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                    <tr>
                      <td width="30%" style="border-bottom:1px solid #CCCCCC;">  
                         <label>
                            TELÉFONO EMPRESA
                         </label><br><br>
                         <b>&nbsp;'.$telefonoEmp.'</b><br>
                      </td>   
                      <td width="5%"></td>              
                      <td width="65%" style="border-bottom:1px solid #CCCCCC;">
                         <label>
                            VIVE EN CASA:
                         </label><br><br>
                               <b>' . $casa . ' ' . $casa2 . ' ' . $casa3 . ' ' . $casa4 . ' ' . $casa5 . '</b><br>
                      </td>
                    </tr>
                    <tr>
                       <td width="100%" colspan="2"></td>
                    </tr>
                    <tr>
                   <td width="100%" style="border-bottom:1px solid #CCCCCC;">
                      <label>&nbsp;&nbsp;&nbsp;&nbsp;El Sr.(a) (<b><span style="color: red;">*</span></b>)</label><br><br>
                      <b>&nbsp;&nbsp;&nbsp;'.$nombreCompleto.'</b>
                   </td>                 
                    </tr>
                    <tr>
                        <td width="100%" colspan="2"></td>
                    </tr>
                    <tr >
                        <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                          <label>Se compromete a adquirir el lote No.(<b><span style="color: red;">*</span></b>): </label>
                          <b style="border-bottom:1px solid #CCCCCC;">'.$noLote.'</b> &nbsp;&nbsp;&nbsp; 
                        </td>
                   <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                      <label>en el clúster (<b><span style="color: red;">*</span></b>): </label>
                      <b style="border-bottom:1px solid #CCCCCC;">'.$cluster.'</b> &nbsp;&nbsp;&nbsp;  
                   </td>
                   <td width="25%" style="border-bottom:1px solid #CCCCCC;">
                      <label>de sup. aprox. (<b><span style="color: red;">*</span></b>): </label>
                      <b style="border-bottom:1px solid #CCCCCC;">'.$super.'</b> &nbsp;&nbsp;&nbsp; 
                   </td>
                   <td width="25%" style="border-bottom:1px solid #CCCCCC;">
                      <label>No. de ref. de pago (<b><span style="color: red;">*</span></b>): </label>
                      <b style="border-bottom: 1px solid #CCCCCC">'.$noRefPago.'</b> &nbsp;&nbsp;&nbsp;
                   </td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2"></td>
                    </tr>
                  <tr>
                    <td width="20%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                    <label>costo por m2 lista (<b><span style="color: red;">*</span></b>): </label>
                    <b>'.$costoM2.'</b>
                   </td>
                   <td width="20%" colspan="2" style="border-bottom:1px solid #CCCCCC;">
                     <label>costo por m2 final (<b><span style="color: red;">*</span></b>): </label>
                     <b>'.$costom2f.'</b>
                   </td>
                  </tr>
                    <tr>
                        <td width="100%" colspan="2"></td>
                    </tr>        
                   <tr>
                    <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">  
                          <label>una vez que sea autorizado el proyecto (<b><span style="color: red;">*</span></b>): </label>
                          <b>'.$proyecto.'</b>,
                        </td>
                        <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC;">  
                           <label> en el Municipio de (<b><span style="color: red;">*</span></b>): </label>
                           <b>'.$municipio.'</b>
                        </td>
                    </tr>
    
                    <tr>
                        <td width="100%" colspan="2"></td>
                    </tr>
    
                   <tr>
                    <td width="30%" colspan="2">  
                    <label>La ubicación del lote puede variar debido a ajustes del proyecto.</label>
                    </td>
    
                   </tr>
    
    
    
    
                    <tr>
                        <td width="100%" colspan="2"></td>
                    </tr>
                    <tr>
                        <td width="100%" colspan="2" style="border-bottom:1px solid #CCCCCC;">   
                      <label>Importe de la oferta $ (<b><span style="color: red;">*</span></b>): </label>
                      <b>'.$importOferta.'</b> &nbsp;&nbsp;&nbsp;&nbsp;( <b>'.$letraImport.'</b> 00/100 M.N )
                        </td>
                    </tr>
                    <tr>
                      <td width="100%" colspan="2"></td>
                    </tr> 
                    <tr>
                        <td width="55%" colspan="2" style="border-bottom:1px solid #CCCCCC">  
                        <label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $ (<b><span style="color: red;">*</span></b>): </label>
                        <b>'.$cantidad.'</b>  
                        </td>
                        <td width="45%" style="border-bottom:1px solid #CCCCCC">
                           <b> ( '.$letraCantidad.' ), </b>
                        </td>
                    </tr>
    
                    <tr>
                        <td width="100%" colspan="2"></td>
                    </tr>
    
    
                    <tr>
    
                        <td width="45%">
                        <label>misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo.</label>
                     </td>
    
    
    
    
                    </tr>
             
                    <tr>
                      <td width="100%" colspan="2"></td>
                    </tr> 
                    <tr>
                        <td width="75%" colspan="2" >
                           <label>El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma:</label>
                        </td>
                        <td width="25%" colspan="2" style="border-bottom:1px solid #CCCCCC">
                            <label>Saldo de depósito: $ (<b><span style="color: red;">*</span></b>): </label>
                            <b>'.$saldoDeposito.'</b> 
                        </td>
                    </tr>
                    <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>        
                    <tr>
                       <td width="17%"> 
                              <label>Aportación mensual a la oferta: $ (<b><span style="color: red;">*</span></b>): </label>
                       </td>   
                       <td width="23%" style="border-bottom:1px solid #CCCCCC">
                              <b>'.$aportMensualOfer.'</b> 
                       </td>
                       <td width="13%">
                              <label> Fecha 1era. Aportación (<b><span style="color: red;">*</span></b>): </label>
                       </td>  
                       <td width="27%" style="border-bottom:1px solid #CCCCCC">
                              <b>'.$fecha1erAport.'</b>
                       </td>      
                       <td width="5%"> 
                           <label>Plazo (<b><span style="color: red;">*</span></b>): </label> 
                       </td>
                       <td width="15%" style="border-bottom:1px solid #CCCCCC">
                              <b>'.$plazo.'</b> <label> meses</label> 
                       </td>
                    </tr>
                        <tr>
                           <td width="100%" colspan="2"></td>
                       </tr> 
                        <tr>
                          <td width="17%">
                              <label>Fecha liquidación de depósito  (<b><span style="color: red;">*</span></b>): </label>               
                           </td>  
                           <td width="23%" style="border-bottom:1px solid #CCCCCC">
                                  <b>'.$fechaLiquidaDepo.'</b>
                           </td> 
                          <td width="13%" >
                              <label>Fecha 2da. Aportación: </label>  
                          </td>
                          <td width="27%" style="border-bottom:1px solid #CCCCCC">
                              <b>'.$fecha2daAport.'</b> 
                          </td>
                        </tr>
                        <tr>
                           <td width="100%" colspan="2"></td>
                       </tr> 
                      <tr>
                        <td width="100%" colspan="2" style="background-color:#FFF;"> 
                          <label style="text-align: justify; font-size: 5px">Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente  $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.</label>
                         
						  <label style="text-align: justify; font-size: 5px">Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. 
							Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. 
							De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. 
							Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.  
						  </label>
						</td>
                      </tr>
                      <tr>
                      <td width="100%" colspan="2"></td>
                    </tr>
                      <tr>
                        <td width="10%">
                           <label>En el Municipio de: </label>
                   </td>
                   <td width="25%" style="border-bottom:1px solid #CCCCCC">
                      <b>'.$municipio2.'</b>
                   </td>
                   <td width="3%" align="center">
                      <label>A: </label>
                   </td>
                   <td width="3%" style="border-bottom:1px solid #CCCCCC">
                      <b>'.$dia.'</b>
                   </td>
                   <td width="8%" align="right">
                      <label>Del mes de:  </label>
                   </td>
                   <td width="13%" style="border-bottom:1px solid #CCCCCC">
                       <b> '.$mes.'</b>
                   </td>
                   <td width="5%" align="right">
                      <label>Del año:  </label>
                   </td>
                   <td width="10%" style="border-bottom:1px solid #CCCCCC">
                      <b> &nbsp;&nbsp;'.$año.'</b>
                   </td>
                      </tr>
                      <tr>
                       <td width="100%" colspan="2"></td>
                      </tr>
                     <tr>
                     <td width="100%" colspan="2"></td>
                    </tr>
                      <tr>
                        <td width="100%" colspan="2">         
                          <table border="0" width="100%">
                            <tr>
                              <td width="60%" align="center"> 
                                <table border="0" width="100%">
                                  <tr>  
                                    <td width="100%"><br><br><br><br></td>              
                                  </tr>
                                  <tr>
                                    <td width="100%" align="center">   
                                    '.$nombreCompleto.'          
                                      <BR>                      
                                      ______________________________________________________________________________
                                      <p>Nombre y Firma / Ofertante</p>
                                      <p>Acepto que se realice una verificación de mis datos, en los teléfonos<br> y correos que proporciono para el otorgamiento del crédito.</p>
                                    </td>
                                  </tr>
                                  <tr>
                                  <td width="100%" colspan="2"></td>
                                 </tr>
                                 <tr>
                                 <td width="100%" colspan="2"></td>
                                </tr>
                                  <tr>
                                    <td width="100%" align="center">
                            
                                    <table border="0" width="91%" style="background-color:#ffffff;">
                                    <tr>
                                    <td>
          
                                      </td>
                                      </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>   
                              <td width="37%" >                            
                                <table border="0" width="108%" style="border:1px solid #CCC">
                                <tr>
                                <td width="100%" colspan="2" ></td>
                               </tr>  
                               <tr>  
                                    <td width="100%" colspan="2" style="" align="center">
                                       <h4>  REFERENCIAS PERSONALES</h4>
                                    </td>              
                               </tr>
                               <tr>
                                  <td width="100%" colspan="2"></td>
                               </tr>
                               <tr>
                                   <td width="15%"></td>
                                    <td width="20%" style="color: #084c94;"> NOMBRE: </td>              
                                    <td width="48%" style="border-bottom:1px solid #CCC">
                               <b style="font-size: 5px"> '.$referencia1.'</b>
                                    </td>
                               </tr>
                               <tr>
                                   <td width="15%"></td>
                                    <td width="20%" style="color: #084c94;"> PARENTESCO: </td>  
                                    <td width="48%" style="border-bottom:1px solid #CCC">
                                       <b style="font-size: 5px"> '.$parentescoReferen.'</b>
                                    </td> 
                               </tr>
                               <tr> 
                                      <td width="15%"></td>
                                    <td width="20%" style="color: #084c94;"> TEL: </td>  
                                    <td width="48%" style="border-bottom:1px solid #CCC">
                                       <b style="font-size: 5px"> ' . $telreferencia1 . '</b>
                                    </td>                          
                               </tr>
                              <tr>
                                  <td width="100%" colspan="2"></td>
                              </tr>
                              <tr>
                                   <td width="15%"></td>
                                    <td width="20%" style="color: #084c94;"> NOMBRE: </td>              
                                    <td width="48%" style="border-bottom:1px solid #CCC">
                               <b style="font-size: 5px"> '.$referencia2.'</b>
                                    </td>
                               </tr>
                               <tr>
                                   <td width="15%"></td>
                                    <td width="20%" style="color: #084c94;"> PARENTESCO: </td>  
                                    <td width="48%" style="border-bottom:1px solid #CCC">
                                       <b style="font-size: 5px"> '.$parentescoReferen2.'</b>
                                    </td> 
                               </tr>
                               <tr> 
                                      <td width="15%"></td>
                                    <td width="20%" style="color: #084c94;"> TEL: </td>  
                                    <td width="48%" style="border-bottom:1px solid #CCC">
                                       <b style="font-size: 5px"> ' . $telreferencia2 . '</b>
                                    </td>                          
                               </tr>   
                        <tr>
                                  <td width="100%" colspan="2"></td>
                              </tr>
                              
                              <tr>
                                 <td width="100%" colspan="2"></td>
                              </tr>
                                </table>
                              </td>              
                            </tr>
                          </table> 
                        </td>
                      </tr>
    
                    <tr>                
                   <td width="100%" colspan="2"></td>
                   </tr>       
              <tr>
                   <td width="100%" colspan="2">
                   <b style="font-size: 10px"> ' . $observacion . '</b>
                   </td>
               </tr>
                   <tr>
                        <td width="100%" colspan="2">
                          <br><br><br><br>
                        </td>
                      </tr>
                      <tr>
                        <td width="100%" colspan="2">
                          <table border="0" width="100%">
                          <tr>
                            <td width="50%" align="center">
                            '.$nombreFirmaAsesor.'
                      <BR>
                            __________________________________________________________________________
                              <p>Nombre y Firma / Asesor</p> 
                            </td>
                            <td width="50%" align="center">
                            '.$nombreFirmaAutoriza.'
                      <BR>
                            __________________________________________________________________________
                              <p>Nombre y Firma / Autorización de operación</p>        
                        </td>
                            </tr>
                          </table>
                        </td>
                      </tr>     
                      <tr>
                       <td width="100%" colspan="2"></td>
                      </tr>
                      <tr>
                       <td width="100%" colspan="2"></td>
                      </tr>                
                      <tr>
                      <td width="3%" align="center"> 
                      </td> 
                  <td width="8%" align="center"> 
                          <label>
                           E-mail: 
                     </label>
                      </td>
                      <td width="35%" align="center" style="border-bottom:1px solid #CCCCCC"> 
                       <b>'.$email2.'</b>
                      </td>
    
                      </tr>
                  <tr>                
    
                     
                      <td width="100%" colspan="2">
                        <br><br>
                      </td>
    
                    </tr>
                     
                                      
                      <tr>                  
                      <td width="100%" colspan="2">
                        <br><br>
                      </td>
                    </tr>
                    </table>
                  </div> 
              </div>
             
        </body>
    </html>';


        $pdf->writeHTMLCell(0, 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);


        $namePDF = utf8_decode('DEPÓSITO_DE_SERIEDAD_'.$idCliente.'.pdf');

        $pdf->Output(utf8_decode($namePDF), 'I');

    }

	public function addUser()
	{
		$this->load->view("addCliente_view");
	}
	public function addUserAction()
	{
		$this->load->model("registrolote_modelo");

		$arreglo=array();
		$perfil = $this->input->post('perfilUsr');
		$username = $this->input->post('userNameUsr');
		$password = $this->input->post('passUsr');
		$primerNombre = $this->input->post('primerNomUsr');
		$segundoNombre = $this->input->post('segundoNomUsr');
		$apellidoPaterno = $this->input->post('apPaternoUsr');
		$apellidoMaterno = $this->input->post('apMaternoUsr');
		$ubicacion = $this->input->post('ubicacionUsr');
		$avatar = $this->input->post('sexoUsr');

		if($perfil!="" || $username!="" || $password!="" || $primerNombre!="" || $apellidoPaterno=!""
				|| $apellidoMaterno!="" || $ubicacion!="" || $avatar!="")
		{

			$buscaUser = $this->registrolote_modelo->buscaUserExist($username);
			if($buscaUser!="")
			{
				echo 7;
			}
			else
			{
				$arreglo["perfil"]=$perfil;
				$arreglo["username"]=$username;
				$arreglo["password"]=$password;

				$arreglo["primerNombre"]=$primerNombre;
				$arreglo["segundoNombre"]=$segundoNombre;
				$arreglo["apellidoPaterno"]=$apellidoPaterno;
				$arreglo["apellidoMaterno"]=$apellidoMaterno;

				$arreglo["ubicacion"]=$ubicacion;
				$arreglo["avatar"]=$avatar;

				if($this->registrolote_modelo->insertaNewUser($arreglo))
				{
					echo 1;
				}
			}
		}
		else
		{
			echo 0;
		}
	}

	function getAsesor($gerentes)
	{
		$data['asesores'] = $this->registrolote_modelo->getAsesores($gerentes);
		echo "<option value='".$data[''][$i]['']."'>ELIJA ASESOR</option>";
		for ($i=0; $i < count($data['asesores']); $i++) {
			echo "<option idAsesor='".$data['asesores'][$i]['idAsesor']."' value='".$data['asesores'][$i]['idAsesor']."'>".$data['asesores'][$i]['nombreAsesor']."</option>";
		}
	}

	function getCondominioQro($residenciales)
	{
		$data['condominios'] = $this->registrolote_modelo->getCondominio($residenciales);
		echo "<option value='".$data[''][$i]['']."'>ELIJA CONDOMINIO</option>";
		for ($i=0; $i < count($data['condominios']); $i++) {
			echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']."</option>";
		}
	}

	function getLotesQro($condominio,$residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getLotes($condominio,$residencial);
		echo "<option value='".$data[''][$i]['']."'>ELIJA LOTE</option>";
		$i = 0;
		while ($i<count($data['lotes']))
		{
			$status_color = array(
				'1' => '#FFFFFF',
				'2' => '#4169E1',
				'3' => '#FFFF00',
				'4' => '#FFA500',
				'5' => '#7FFF00',
				'6' => '#9400D3',
				'7' => '#FF00FF'
			);
			echo "<option style='background-color:" . $status_color[$data['lotes'][$i]['idStatusLote']] . ";'
	       'font-weight:bold;' 
	       idLote='".$data['lotes'][$i]['idLote']."' value='".$data['lotes'][$i]['idLote']."'>".$data['lotes'][$i]['nombreLote']."</option>";
			$i++;
		}
	}
	
	

	public function insertarCliente(){
      $arreglo=array();
      $fechaApartado= date('Y-m-d H:i:s');
      $arreglo["primerNombre"]=$this->input->post('primerNombre');
      $arreglo["segundoNombre"]=$this->input->post('segundoNombre');
      $arreglo["apellidoPaterno"]=$this->input->post('apellidoPaterno');
      $arreglo["apellidoMaterno"]=$this->input->post('apellidoMaterno');
      $arreglo["idAsesor"]=$this->input->post('filtro2');
      $arreglo["idLote"]=$this->input->post('filtro5');
      $arreglo["idCondominio"]=$this->input->post('filtro4');
      $arreglo["engancheCliente"]=$this->input->post('engancheCliente');
      $arreglo["concepto"]=$this->input->post('concepto');
      $arreglo["fechaEnganche"]=date('Y-m-d H:i:s');
      $arreglo["fechaApartado"]=date('Y-m-d H:i:s');
      $arreglo["noRecibo"]=$this->input->post('noRecibo');
      $arreglo["idTipoPago"]=$this->input->post('idTipoPago');
      $arreglo["user"]=$this->session->userdata('username');
      $arreglo["idAsesor2"]=$this->input->post('filtro9');
      $arreglo["idAsesor3"]=$this->input->post('filtro11');
      $arreglo["idGerente"]=$this->input->post('filtro1');
      $arreglo["idGerente2"]=$this->input->post('filtro8');
      $arreglo["idGerente3"]=$this->input->post('filtro10');
      $fechaAccion = date("Y-m-d H:i:s");
      $hoy_strtotime2 = strtotime($fechaAccion);
	$sig_fecha_dia2 = date('D', $hoy_strtotime2);
	  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
	
	if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
		 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
		 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
		 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
		 $sig_fecha_feriado2 == "25-12") {
		
	 
	$fecha = $fechaAccion;
	
	$i = 0;
		while($i <= 46) {
	  $hoy_strtotime = strtotime($fecha);
	  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
	  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
	  $sig_fecha_dia = date('D', $sig_strtotime);
		$sig_fecha_feriado = date('d-m', $sig_strtotime);
	
	  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
		 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
		 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
		 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
		 $sig_fecha_feriado == "25-12") {
		   }
			 else {
					$fecha= $sig_fecha;
					 $i++;
				  } 
		$fecha = $sig_fecha;
			   }
	
	
		   $arreglo["fechaVencimiento"]= $fecha;
	
		   }else{
	
	$fecha = $fechaAccion;
	
	$i = 0;
		while($i <= 45) {
	  $hoy_strtotime = strtotime($fecha);
	  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
	  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
	  $sig_fecha_dia = date('D', $sig_strtotime);
		$sig_fecha_feriado = date('d-m', $sig_strtotime);
	
	  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
		 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
		 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
		 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
		 $sig_fecha_feriado == "25-12") {
		   }
			 else {
					$fecha= $sig_fecha;
					 $i++;
				  } 
		$fecha = $sig_fecha;
			   }
	
	
		   $arreglo["fechaVencimiento"]= $fecha;
		  
	
		   }
	
	
			  $validateLote = ($this->registrolote_modelo->validate($this->input->post('filtro5')) == 1) ? TRUE : FALSE;
	
	
			  if($validateLote == TRUE) {
				  
				$idClienteInsert = $this->registrolote_modelo->insertaRegistroCliente($arreglo);
	
			  if ($idClienteInsert){
	  
				$updateLote=array();
				$updateLote["idStatusContratacion"]= 1;
				$updateLote["idStatusLote"]=3;
				$updateLote["idMovimiento"]=31;
				$updateLote["idCliente"]= $idClienteInsert;
				$updateLote["comentario"]= 'OK';
				$updateLote["user"]=$this->session->userdata('username');
				$updateLote["perfil"]=$this->session->userdata('perfil');
				$updateLote["modificado"]=date("Y-m-d H:i:s");
			
			
			
			date_default_timezone_set('America/Mexico_City');
			$horaActual = date('H:i:s');
			$horaInicio = date("08:00:00");
			$horaFin = date("16:00:00");
			
			if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			
			if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
				 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				 $sig_fecha_feriado2 == "25-12") {
			
			
			
			$fecha = $fechaAccion;
			$i = 0;
				while($i <= 6) {
			  $hoy_strtotime = strtotime($fecha);
			  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
			  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
			  $sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
			
			  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
				 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
				 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
				 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
				 $sig_fecha_feriado == "25-12") {
				   }
					 else {
							$fecha= $sig_fecha;
							 $i++;
						  } 
				$fecha = $sig_fecha;
					   }
				   $updateLote["fechaVenc"]= $fecha;
	
				   }else{
			
			$fecha = $fechaAccion;
			
			$i = 0;
			
				while($i <= 5) {
			
			  $hoy_strtotime = strtotime($fecha);
			  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
			  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
			  $sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
			
			  if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
				 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
				 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
				 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
				 $sig_fecha_feriado == "25-12") {
				   }
					 else {
							$fecha= $sig_fecha;
							 $i++;
						  } 
			
				$fecha = $sig_fecha;
			
					   }
			
				   $updateLote["fechaVenc"]= $fecha;
			
				   }
			
			} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			  $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			
			
			if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
				 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				 $sig_fecha_feriado2 == "25-12") {
			
			$fecha = $fechaAccion;
			
			$i = 0;
			
				while($i <= 6) {
			  $hoy_strtotime = strtotime($fecha);
			  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
			  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
			  $sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
			
			  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
				 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
				 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
				 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
				 $sig_fecha_feriado == "25-12") {
				   }
					 else {
							$fecha= $sig_fecha;
							 $i++;
						  } 
			
				$fecha = $sig_fecha;
			
					   }
			
				   $updateLote["fechaVenc"]= $fecha;
			
				   }else{
			
			$fecha = $fechaAccion;
			
			$i = 0;
			
				while($i <= 6) {
			  $hoy_strtotime = strtotime($fecha);
			  $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
			  $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
			  $sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
			
			  if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || 
				 $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
				 $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
				 $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
				 $sig_fecha_feriado == "25-12") {
				   }
					 else {
							$fecha= $sig_fecha;
							 $i++;
						  } 
				$fecha = $sig_fecha;
					   }
	
				 $updateLote["fechaVenc"]= $fecha;
			
				   }
			
			}
	
	
			$nomLote = $this->registrolote_modelo->getNameLote($this->input->post('filtro5'));
	
			
				$arreglo2=array();
				$arreglo2["idStatusContratacion"]= 1;
				$arreglo2["idMovimiento"]=31;
				$arreglo2["nombreLote"]= $nomLote->nombreLote;
				$arreglo2["comentario"]= 'OK';
				$arreglo2["user"]=$this->session->userdata('username');
				$arreglo2["perfil"]=$this->session->userdata('perfil');
				$arreglo2["modificado"]=date("Y-m-d H:i:s");
				$arreglo2["fechaVenc"]= date('Y-m-d H:i:s');
				$arreglo2["idLote"]= $this->input->post('filtro5');  
				$arreglo2["idCondominio"]= $this->input->post('filtro4');          
				$arreglo2["idCliente"]= $idClienteInsert;          
			
	
				$tipoDoc = $this->registrolote_modelo->getDoc();
	
				foreach ($tipoDoc AS $arrCorreo){
				
					  $arrayDocs = array(
						'movimiento' => $arrCorreo["descripcion"],
						'idCliente' => $idClienteInsert,
						'idCondominio' => $this->input->post('filtro4'),
						'idLote' => $this->input->post('filtro5'),
						'tipo_doc' => $arrCorreo["id_tipo"]
					  );
				
					  $this->registrolote_modelo->addDocs($arrayDocs);
				}
	
	
				$this->registrolote_modelo->editaRegistroLoteCaja($this->input->post('filtro5'), $updateLote);
				$this->registrolote_modelo->insertHistorialLotes($arreglo2);
		 
	
						  
				$response['message'] = 'OK';
				echo json_encode($response);            
			  }
					else {
				
					  $response['message'] = 'ERROR';
					  echo json_encode($response);
					}
	
				} else {
		  
				$response['message'] = 'ERROR';
				echo json_encode($response);
			  }
	
	
		}
		

	// FIN DE  REGISTRO DE CLIENTES TODOS LOS CLIENTES EXCEPTO DE SAN LUIS Y DE CIUDAD MADERAS SUR

	public function registrosCliente()
	{
		$datos=array();
		$datos["registrosCliente"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_view",$datos);
	}

	public function editarCliente($idCliente)
	{
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$this->load->view('editar_cliente_view',$datos);
	}
	public function editar_registro_cliente()
	{
		$idCliente=$this->input->post('idCliente');
		$idLote=$this->input->post('idLote');
		$primerNombre=$this->input->post('primerNombre');
		$segundoNombre=$this->input->post('segundoNombre');
		$apellidoPaterno=$this->input->post('apellidoPaterno');
		$apellidoMaterno=$this->input->post('apellidoMaterno');
		$rfc=$this->input->post('rfc');
		$razonSocial=$this->input->post('razonSocial');

		/******* Bitacora se agrega algun cambio que se realice *********/
		$arreglo2=array();
		$arreglo2["movimiento"]="Actualización de Cliente";
		$arreglo2["idCliente"]=$this->input->post('idCliente');
		$arreglo2["idLote"]=$this->input->post('idLote');
		$primerNombreOriginal=$this->input->post('primerNombreOriginal');
		if ($primerNombreOriginal <> $primerNombre) {
			$primerNombreOriginal= $primerNombre;
		}
		$segundoNombreOriginal=$this->input->post('segundoNombreOriginal');

		if ($segundoNombreOriginal <> $segundoNombre) {
			$segundoNombreOriginal=$segundoNombre;
		}
		$apellidoPaternoOriginal=$this->input->post('apellidoPaternoOriginal');
		if ($apellidoPaternoOriginal <> $apellidoPaterno) {
			$apellidoPaternoOriginal=$apellidoPaterno;
		}
		$apellidoMaternoOriginal=$this->input->post('apellidoMaternoOriginal');
		if ($apellidoMaternoOriginal <> $apellidoMaterno) {
			$apellidoMaternoOriginal=$apellidoMaterno;
		}
		$rfcOriginal=$this->input->post('rfcOriginal');
		if ($rfcOriginal <> $rfc) {
			$rfcOriginal=$rfc;
		}
		$razonSocialOriginal=$this->input->post('razonSocialOriginal');
		if ($razonSocialOriginal <> $razonSocial) {
			$razonSocialOriginal=$razonSocial;
		}
		/*****************************************************************/
		$arreglo2["antes"]=$primerNombreOriginal.' '.$segundoNombreOriginal.' '.$apellidoPaternoOriginal.' '.$apellidoMaternoOriginal.' '.$rfcOriginal.' '.$razonSocialOriginal;
		$arreglo2["perfil"]=$this->input->post('perfil');
		$arreglo2["user"]=$this->input->post('usuario');
		$arreglo2["fecha"]=date("Y-m-d H:i:s");
		$arreglo=array();
		$arreglo["primerNombre"]=$primerNombre;
		$arreglo["segundoNombre"]=$segundoNombre;
		$arreglo["apellidoPaterno"]=$apellidoPaterno;
		$arreglo["apellidoMaterno"]=$apellidoMaterno;
		$arreglo["rfc"]=$rfc;
		$arreglo["razonSocial"]=$razonSocial;
		$this->registrolote_modelo->insertBitacorarreglo($arreglo2);

		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosCliente");
		}else
		{
			die("ERROR");
		}
	}
	public function registrosClientePostventa(){
		$datos=array();
		$datos["registrosClientePostventa"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_postventa_view",$datos);
	}
	public function editarClientePostventa($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectNombreLote($idCliente);
		$this->load->view('editar_cliente_postventa_view',$datos);
	}
	public function editar_registro_cliente_postventa(){
		$idCliente=$this->input->post('idCliente');
		$idLote=$this->input->post('idLote');
		$fechaNacimiento=$this->input->post('fechaNacimiento');
		$telefono1=$this->input->post('telefono1');
		$telefono2=$this->input->post('telefono2');
		$telefono3=$this->input->post('telefono3');
		$calle=$this->input->post('calle');
		$numero=$this->input->post('numero');
		$colonia=$this->input->post('colonia');
		$municipio=$this->input->post('municipio');
		$estado=$this->input->post('estado');
		$correo=$this->input->post('correo');
		$referencia1=$this->input->post('referencia1');
		$telreferencia1=$this->input->post('telreferencia1');
		$referencia2=$this->input->post('referencia2');
		$telreferencia2=$this->input->post('telreferencia2');
		$enterado=$this->input->post('enterado');
		$especifiqueEnt=$this->input->post('especifiqueEnt');
		$primerContacto=$this->input->post('primerContacto');

		/******* Bitacora se agrega algun cambio que se realice *********/
		$arreglo2=array();
		$arreglo2["movimiento"]="Se actualizaron los siguiente registros";
		$arreglo2["idCliente"]=$this->input->post('idCliente');
		$arreglo2["idLote"]=$this->input->post('idLote');
		$fechaNacimientoriginal=$this->input->post('fechaNacimientoriginal');
		if ($fechaNacimientoriginal <> $fechaNacimiento) {
			$fechaNacimientoriginal= $fechaNacimiento;
		}

		$telefono1original=$this->input->post('telefono1original');
		if ($telefono1original <> $telefono1) {
			$telefono1original=$telefono1;
		}
		$telefono2original=$this->input->post('telefono2original');
		if ($telefono2original <> $telefono2) {
			$telefono2original=$telefono2;
		}
		$telefono3original=$this->input->post('telefono3original');
		if ($telefono3original <> $telefono3) {
			$telefono3original=$telefono3;
		}
		$calleoriginal=$this->input->post('calleoriginal');
		if ($calleoriginal <> $calle) {
			$calleoriginal=$calle;
		}
		$numeroriginal=$this->input->post('numeroriginal');
		if ($numeroriginal <> $numero) {
			$numeroriginal=$numero;
		}
		$coloniaoriginal=$this->input->post('coloniaoriginal');
		if ($coloniaoriginal <> $colonia) {
			$coloniaoriginal=$colonia;
		}
		$municipioriginal=$this->input->post('municipioriginal');
		if ($municipioriginal <> $municipio) {
			$municipioriginal=$municipio;
		}
		$estadoriginal=$this->input->post('estadoriginal');
		if ($estadoriginal <> $estado) {
			$estadoriginal=$estado;
		}
		$correoriginal=$this->input->post('correoriginal');
		if ($correoriginal <> $correo) {
			$correoriginal=$correo;
		}
		$referencia1original=$this->input->post('referencia1original');
		if ($referencia1original <> $referencia1) {
			$referencia1original=$referencia1;
		}
		$telreferencia1original=$this->input->post('telreferencia1original');
		if ($telreferencia1original <> $telreferencia1) {
			$telreferencia1original=$telreferencia1;
		}
		$referencia2original=$this->input->post('referencia2original');
		if ($referencia2original <> $referencia2) {
			$referencia2original=$referencia2;
		}
		$telreferencia2original=$this->input->post('telreferencia2original');
		if ($telreferencia2original <> $telreferencia2) {
			$telreferencia2original=$telreferencia2;
		}
		$enteradorignal=$this->input->post('enteradoriginal');
		if ($enteradorignal <> $enterado) {
			$enteradorignal=$enterado;
		}
		$especifiqueEntorignal=$this->input->post('especifiqueEntoriginal');
		if ($especifiqueEntorignal <> $especifiqueEnt) {
			$especifiqueEntorignal=$especifiqueEnt;
		}
		$primerContactoOriginal=$this->input->post('primerContactoOriginal');
		if ($primerContactoOriginal <> $primerContacto) {
			$primerContactoOriginal=$primerContacto;
		}
		/*****************************************************************/
		$arreglo2["antes"]=$fechaNacimientoriginal.' '.$telefono1original.' '.$telefono2original.' '.$telefono3original.' '.$calleoriginal.' '.$numeroriginal.' '.$coloniaoriginal.' '.$municipioriginal.' '.$estadoriginal.' '.$correoriginal.' '.$referencia1original.' '.$telreferencia1original.' '.$referencia2original.' '.$telreferencia2original.' '.$enteradorignal.' '.$especifiqueEntorignal.' '.$primerContactoOriginal;
		$arreglo2["perfil"]=$this->input->post('perfil');
		$arreglo2["user"]=$this->input->post('usuario');
		$arreglo2["fecha"]=date("Y-m-d H:i:s");
		$arreglo=array();
		$arreglo["fechaNacimiento"]=$fechaNacimiento;
		$arreglo["telefono1"]=$telefono1;
		$arreglo["telefono2"]=$telefono2;
		$arreglo["telefono3"]=$telefono3;
		$arreglo["calle"]=$calle;
		$arreglo["numero"]=$numero;
		$arreglo["colonia"]=$colonia;
		$arreglo["municipio"]=$municipio;
		$arreglo["estado"]=$estado;
		$arreglo["correo"]=$correo;
		$arreglo["referencia1"]=$referencia1;
		$arreglo["telreferencia1"]=$telreferencia1;
		$arreglo["referencia2"]=$referencia2;
		$arreglo["telreferencia2"]=$telreferencia2;
		$arreglo["enterado"]=$enterado;
		$arreglo["especifiqueEnt"]=$especifiqueEnt;
		$arreglo["primerContacto"]=$primerContacto;
		$this->registrolote_modelo->insertBitacorarreglo($arreglo2);
		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosClientePostventa");
		}else{
			die("ERROR");
		}
	}
	public function registrosClienteDocumentosRL(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_documentos_representanteLegal_view",$datos);
	}

	public function registrosClienteRL(){
		$datos=array();
		$datos["registrosClienteRL"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_representanteLegal_view",$datos);
	}
	public function registrosClienteVentasAsistentes(){
		$datos=array();
		$datos["registrosClienteVentasAsistentes"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_ventasAsistentes_view",$datos);
	}

	public function registrosClienteAsistentesGerentes(){
		$datos=array();
		$datos["registrosClienteAsistentesGerentes"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_asistentesGerentes_view",$datos);
	}

	public function registrosClienteJuridico(){
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view");
	}


	function getregistrosClientes() 
	{
		$objDatos = json_decode(file_get_contents("php://input"));
		$dato= $this->registrolote_modelo->registroCliente();
		if($dato != null) {

			echo json_encode($dato);

		}
		else
		{

			echo json_encode(array());
		}
	}


	public function registrosCliente_yola(){
		$datos=array();
		$datos["registrosCliente_yola"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_yola_view",$datos);
	}

	public function registrosClienteContratacion()
	{
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view");
	}

	public function getRegsClientes()
	{
		$this->validateSession();
		$data=array();
		$data= $this->registrolote_modelo->registroCliente();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}

	public function registrosExpedienteVentasAsistentes(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_expediente_ventasAsistentes_view",$datos);
	}

	///////////////////////////////////////Documentacion de asistentes de gerentes

	public function registrosExpedienteAsistentesGerentes(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_expediente_asistentesGerentes_view",$datos);
	}

	public function registrosClienteDocumentosAsistentesGerentes(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_documentos_asistentesGerentes_view",$datos);
	}

	public function editarClienteAsistentesGerentes($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectdocs($idCliente);
		$this->load->view('editar_cliente_expediente_asistentesGerentes_view',$datos);
	}

	public function editar_registro_cliente_asistentesGerentes_expediente(){

		$aleatorio = rand(100,1000);

		$idCliente=$this->input->post('idCliente');
		$idHistorialCliente = $this->input->post('idClienteHistorial');
		$idLoteHistorial = $this->input->post('idLoteHistorial');
		$idUser= $this->input->post('idUser');
		$idCondominio = $this->input->post('idCondominio');
		$nombreResidencial=$_POST['nombreResidencial'];
		$nombreCondominio=$_POST['nombreCondominio'];
		$nombreLote=$_POST['nombreLote'];

		$proyecto = str_replace(' ', '', $nombreResidencial);
		$condominio = str_replace(' ', '', $nombreCondominio);
		$condom = substr($condominio, 0, 3);
		$cond= strtoupper($condom);
		$numeroLote = preg_replace('/[^0-9]/','', $nombreLote);
		$date= date('dmY');
		$composicion = $proyecto."_".$cond.$numeroLote."_".$date;
		$nombArchivo=$composicion;
		$expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"];


		$arreglo2=array();
		$arreglo2["movimiento"]="Se adjunto Expediente";
		$arreglo2["idCliente"]=$idHistorialCliente;
		$arreglo2["idLote"]=$idLoteHistorial;
		$arreglo2["expediente"]= $expediente;
		$arreglo2["idUser"]=$idUser;
		$arreglo2["idCondominio"]=$idCondominio;

		$arreglo=array();
		$arreglo["expediente"] = $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"];
		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			$this->registrolote_modelo->insert_historial_documento($arreglo2);
			if (move_uploaded_file($_FILES["expediente"]["tmp_name"],"static/documentos/cliente/expediente/".$nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"])) {
				echo 1;
			}
		}
	}

	public function HistorialCliente($idCliente){
		$datos["bitacora"] = $this->registrolote_modelo->ConsultClienteBitacora($idCliente);
		$this->load->view('historial_cliente_view', $datos);
	}

	public function editarClienteAsistentesGerentesRfc($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$this->load->view('editar_cliente_rfc_asistentesGerentes_view',$datos);
	}

	public function editar_registro_cliente_asistentesGerentes_rfc(){
		$idCliente=$this->input->post('idCliente');
		$rfc=$this->input->post('rfc');
		$arreglo=array();
		$arreglo["rfc"]=$rfc;
		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo))
        {
			redirect(base_url()."index.php/registroCliente/registrosClienteDocumentosAsistentesGerentes");

		}else{
			die("ERROR");
		}
	}

	public function registrosExpedienteContraloria(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_expediente_contraloria_view",$datos);
	}

	public function registrosClienteDocumentosContraloria(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$datos["registrosClienteDocumentosContraloria"]= $this->registrolote_modelo->corridaContraloria();
		$this->load->view("datos_cliente_documentos_contraloria_view",$datos);
	}

	public function editarClienteContraloriaCorrida($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectdocs($idCliente);
		$this->load->view('editar_cliente_corrida_contraloria_view',$datos);
	}

	public function editar_registro_cliente_corrida_contraloria(){
		$aleatorio = rand(100,1000);
		$idCliente=$this->input->post('idCliente');
		$idHistorialCliente = $this->input->post('idClienteHistorial');
		$idLoteHistorial = $this->input->post('idLoteHistorial');
		$idUser= $this->input->post('idUser');
		$idCondominio = $this->input->post('idCondominio');
		$nombreResidencial=$_POST['nombreResidencial'];
		$nombreCondominio=$_POST['nombreCondominio'];
		$nombreLote=$_POST['nombreLote'];

		$proyecto = str_replace(' ', '', $nombreResidencial);
		$condominio = str_replace(' ', '', $nombreCondominio);
		$condom = substr($condominio, 0, 3);
		$cond= strtoupper($condom);
		$numeroLote = preg_replace('/[^0-9]/','', $nombreLote);
		$date= date('dmY');
		$composicion = $proyecto."_".$cond.$numeroLote."_".$date;
		$nombArchivo=$composicion;
		$expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"];


		$arreglo2=array();
		$arreglo2["movimiento"]="Se adjunto Corrida";
		$arreglo2["idCliente"]=$idHistorialCliente;
		$arreglo2["idLote"]=$idLoteHistorial;
		$arreglo2["expediente"]= $expediente;
		$arreglo2["idUser"]=$idUser;
		$arreglo2["idCondominio"]=$idCondominio;


		$arreglo=array();
		$arreglo["expediente"] = $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"];

		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			$this->registrolote_modelo->insert_historial_documento($arreglo2);

			if (move_uploaded_file($_FILES["expediente"]["tmp_name"],"static/documentos/cliente/corrida/".$nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"])) {
                //redirect(base_url()."index.php/registroCliente/registrosClienteDocumentosContraloria");
				echo 1;
			}

		}

	}

	public function editarRechazoDocumentacionContraloria($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$this->load->view('editar_cliente_rechazoDocumentacion_contraloria_view',$datos);
	}


	public function editar_cliente_rechazoDocumentacion_contraloria(){
		$idCliente=$this->input->post('idCliente');
		$rechazoContraloria=$this->input->post('rechazoContraloria');
		$observacionesContraloria=$this->input->post('observacionesContraloria');
		$arreglo=array();
		$arreglo["rechazoContraloria"]=$rechazoContraloria;
		$arreglo["observacionesContraloria"]=$observacionesContraloria;

		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosClienteDocumentosContraloria");
		}
        else{
        	die("ERROR");
		}
	}



	public function registrosClienteDocumentosCaja(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_documentos_caja_view",$datos);
	}


	public function registrosClienteAdministracion()
	{
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view");
	}

	public function getRegClients()
	{

		if($this->session->userdata('perfil') !="")
		{
			$data = array();
			$data= $this->registrolote_modelo->registroCliente();
			if($data != null) {
				echo json_encode($data);
			} else {
				echo json_encode(array());
			}
			exit;

		}
		else
		{
			redirect(base_url());
		}

	}

	public function registrosClienteContraloria2(){

		$datos=array();
		$datos["registrosClienteContraloria2"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_contraloria2_view",$datos);
	}


	public function registrosClienteContraloria(){
		$datos=array();
		$datos["registrosClienteContraloria"]= $this->registrolote_modelo->registroClienteSolicitud();
		$datos["variable"]= $this->registrolote_modelo->findCount();
		$this->load->view("datos_cliente_contraloria_view",$datos);
	}


	public function registrosSolicitudContraloria(){
		$datos=array();
		$datos["registrosSolicitudContraloria"]= $this->registrolote_modelo->registroSolicitudContratos();
		$this->load->view("datos_solicitudContratos_contraloria_view",$datos);
	}

	public function editarNombreClienteExpedienteContraloria($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$this->load->view('editar_cliente_nombreClienteExpediente_contraloria_view',$datos);
	}

	public function editar_cliente_nombreClienteExpediente_contraloria(){
		$idCliente=$this->input->post('idCliente');
		$nombreClienteExpediente=$this->input->post('nombreClienteExpediente');
		$arreglo=array();
		$arreglo["nombreClienteExpediente"]=$nombreClienteExpediente;
		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosClienteContraloria");
		}else
		{
			die("ERROR");
		}
	}

	public function historialJuridico($idCliente){
		$datos["bitacora"] = $this->registrolote_modelo->ConsultJuridico($idCliente);
		$this->load->view('historial_juridico_view', $datos);
	}


	public function editarRechazoDocumentacionJuridico($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$datos["bitacora"]= $this->registrolote_modelo->selectClientebitacora($idCliente);
		$this->load->view('editar_cliente_rechazoDocumentacion_juridico_view',$datos);
	}

	public function editar_cliente_rechazoDocumentacion_juridico(){
		$idCliente=$this->input->post('idCliente');
		$observacionesJuridico=$this->input->post('observacionesJuridico');
		$arreglo=array();
		$arreglo["observacionesJuridico"]=$observacionesJuridico;
		$arreglo2=array();
		$arreglo2["movimiento"]='Se realizo la siguiente accion';
		$arreglo2["idCliente"]=$this->input->post('cliebit');
		$arreglo2["idLote"]=$this->input->post('lotebit');
		$arreglo2["antes"]=$this->input->post('observacionesJuridico');
		$arreglo2["fecha"]=$this->input->post('horafecha');
		$arreglo2["user"]=$this->input->post('user');
		$arreglo2["perfil"]=$this->input->post('perfil');
		$this->registrolote_modelo->insertBitacoraRecibo($arreglo2);

		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/Documentacion/documentacion");
		}else
		{
			die("ERROR");
		}
	}

	public function registrosClienteDocumentosPostventa(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_documentos_postventa_view",$datos);
	}

	public function editarRechazoDocumentacionPostventa($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$this->load->view('editar_cliente_rechazoDocumentacion_postventa_view',$datos);
	}

	public function editar_cliente_rechazoDocumentacion_postventa(){
		$idCliente=$this->input->post('idCliente');
		$rechazoPostventa=$this->input->post('rechazoPostventa');
		$observacionesPostventa=$this->input->post('observacionesPostventa');
		$arreglo=array();
		$arreglo["rechazoPostventa"]=$rechazoPostventa;
		$arreglo["observacionesPostventa"]=$observacionesPostventa;

		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosClienteDocumentosPostventa");
		}else
		{
			die("ERROR");
		}
	}

	public function registrosRelacionAcuseContraloria(){
		$datos=array();
		$datos["registrosRelacionAcuseContraloria"]= $this->registrolote_modelo->registroCliente();
		$this->load->view("datos_cliente_relacionAcuse_contraloria_view",$datos);
	}

	public function editarRelacionAcuseContraloria($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$this->load->view('editar_cliente_relacionAcuse_contraloria_view',$datos);
	}

	public function editar_cliente_relacionAcuse_contraloria(){
		$idCliente=$this->input->post('idCliente');
		$noAcuse=$this->input->post('noAcuse');
		$arreglo=array();
		$arreglo["noAcuse"]=$noAcuse;

		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosRelacionAcuseContraloria");
		}else
		{
			die("ERROR");
		}
	}

	public function registrosClienteDocumentosVentas(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_documentos_ventas_view",$datos);
	}

	public function registrosClienteAcuseVentas(){
		$datos=array();
		$datos["registrosClienteAcuseVentas"]= $this->registrolote_modelo->registroAcuse();
		$this->load->view("datos_acuse_cliente_ventas_view",$datos);
	}

	public function reporteContratacion(){
		$datos=array();
		$datos["reporteContratacion"]= $this->registrolote_modelo->reporteContratacion();
		$this->load->view("reporte_contratacion_view",$datos);
	}

	public function reporteHistorialApartados(){
		$datos=array();
		$datos["reporteHistorialApartados"]= $this->registrolote_modelo->reporteApartados();
		$this->load->view("reporte_apartados_view",$datos);
	}

	public function editarClienteEngancheCaja($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectRegistroCliente($idCliente);
		$datos["tipoPago"]= $this->registrolote_modelo->getTipoPago();
		$this->load->view('editar_cliente_enganche_caja_view',$datos);
	}

	public function editar_cliente_enganche_caja(){
		$idCliente=$this->input->post('idCliente');
		$noRecibo=$this->input->post('noRecibo');
		$engancheCliente=$this->input->post('engancheCliente');
		$concepto=$this->input->post('concepto');
		$fechaEnganche=date('Y-m-d H:i:s');
		$idTipoPago=$this->input->post('idTipoPago');
		$user=$this->input->post('usuario');
		$idLote=$this->input->post('idLote');
		$arreglo=array();
		$arreglo["engancheCliente"]=$engancheCliente;
		$arreglo["noRecibo"]=$noRecibo;
		$arreglo["idTipoPago"]=$idTipoPago;
		$arreglo["fechaEnganche"]=date('Y-m-d H:i:s');
		$arregloEditaEnganche=array();
		$arregloEditaEnganche["noRecibo"]=$noRecibo;
		$arregloEditaEnganche["engancheCliente"]=$engancheCliente;
		$arregloEditaEnganche["concepto"]=$concepto;
		$arregloEditaEnganche["fechaEnganche"]=$fechaEnganche;
		$arregloEditaEnganche["idTipoPago"]=$idTipoPago;
		$arregloEditaEnganche["idCliente"]=$idCliente;
		$arregloEditaEnganche["idLote"]=$idLote;
		$arregloEditaEnganche["user"]=$user;
		$arregloEditaEnganche["idLote"]=$idLote;
		$this->registrolote_modelo->his_Enganche($arregloEditaEnganche);
		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosCliente");
		}else
		{
			die("ERROR");
		}
	}


	public function registrosClienteAcuseContratacion(){
		$datos=array();
		$datos["registrosClienteAcuseContratacion"]= $this->registrolote_modelo->registroAcuse();
		$this->load->view("datos_acuse_cliente_contratacion_view",$datos);
	}

	public function registroClienteMoral () {
		$datos=array();
		$datos["gerentes"]= $this->registrolote_modelo->getGerente();
		$datos["residenciales"]= $this->registrolote_modelo->getResidencialQro();
		$datos["tipoPago"]= $this->registrolote_modelo->getTipoPago();
		$this->load->view("registro_clienteMoral_view",$datos);
	}

	public function insertarClienteMoral(){
		$this->load->model("registrolote_modelo");
		$arreglo=array();
		$fechaApartado= date('Y-m-d H:i:s');
		$arreglo["razonSocial"]=$this->input->post('razonSocial');
		$arreglo["rfc"]=$this->input->post('rfc');
		$arreglo["idAsesor"]=$this->input->post('filtro2');
		$arreglo["idLote"]=$this->input->post('filtro5');
		$arreglo["idCondominio"]=$this->input->post('filtro4');
		$arreglo["engancheCliente"]=$this->input->post('engancheCliente');
		$arreglo["concepto"]=$this->input->post('concepto');
		$arreglo["fechaEnganche"]=date('Y-m-d H:i:s');
		$arreglo["fechaApartado"]=  date('Y-m-d H:i:s');
		$arreglo["noRecibo"]=$this->input->post('noRecibo');
		$arreglo["idTipoPago"]=$this->input->post('idTipoPago');
		$arreglo["user"]=$this->session->userdata('username');
		$arreglo["idAsesor2"]=$this->input->post('filtro9');
		$arreglo["idAsesor3"]=$this->input->post('filtro11');
		$arreglo["idAsesor4"]=$this->input->post('filtro13');
		$arreglo["idAsesor5"]=$this->input->post('filtro15');
		$fecha = $fechaApartado;
		$i = 0;
		while($i <= 45) {
			$hoy_strtotime = strtotime($fecha);
			$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
			$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
			$sig_fecha_dia = date('D', $sig_strtotime);
			$sig_fecha_feriado = date('d-m', $sig_strtotime);
			if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
				$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
				$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
				$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" ||
				$sig_fecha_feriado == "25-12") {
			}
			else {
				$fecha= $sig_fecha;
				$i++;
			}
			$fecha = $sig_fecha;
		}

		for ($i = 0; $i < count($fecha); $i++) {
			$arreglo["fechaVencimiento"]= $fecha;
		}
		if($this->registrolote_modelo->insertaRegistroCliente($arreglo))  {
			redirect(base_url()."index.php/registroCliente/registrosCliente");
		}
	}
    // FIN DE  REGISTRO DE CLIENTES TODOS LOS CLIENTES EXCEPTO DE SAN LUIS Y DE CIUDAD MADERAS SUR

    public function historial_enganche($idCliente){
		$datos["historial_enganche"]= $this->registrolote_modelo->historialEnganche($idCliente);
		$this->load->view("datos_cliente_enganche_view",$datos);
	}

	public function historial_nombre_cliente($idCliente){
		$datos["historial_nombre_cliente"]= $this->registrolote_modelo->historialClienteNombre($idCliente);
		$this->load->view("datos_cliente_nombre_view",$datos);
	}

	public function historialDocumentosAsistentes($idCliente){
		$datos["bitacora"] = $this->registrolote_modelo->historialDocsAsistentes($idCliente);
		$this->load->view('historial_docAsistentes_view', $datos);
	}

	public function insertarReporte(){
		if($_POST <> NULL){
			$misDatosJSON = json_decode($_POST['datos']);
			//var_dump($misDatosJSON);
			foreach ($misDatosJSON as list($b)) {
				$dato2=array();
				$dato2["idCliente"]=$b;
				$dato2["noSolicitud"]=$misDatosJSON[0][8];
				$this->registrolote_modelo->insertReporte($dato2);
			}
			$dato2=array();
			$dato2["contador"]=$misDatosJSON[0][8];
			$this->registrolote_modelo->updateTblvariables(1,$dato2);
		}else{
			echo "No recibí datos por POST";
		}
	}

	function getCondominio($residencial)
	{
		$data = $this->registrolote_modelo->getCondominio($residencial);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}

	function getLotesEliteV($condominio,$residencial)
	{
		$data = $this->registrolote_modelo->getLotesElite($condominio,$residencial);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
		$data['lotes'] = $this->registrolote_modelo->getLotesElite($condominio,$residencial);
		echo "<option>ELIJA LOTE</option>";
		$i = 0;
		while ($i<count($data['lotes']))  {
			echo "<option idLote='".$data['lotes'][$i]['idLote']."' value='".$data['lotes'][$i]['idLote']."'>".$data['lotes'][$i]['nombreLote']."</option>";
			$i++;
		}
	}

	function getClienteDocumentosElite($lotes)
	{
		$data = $this->registrolote_modelo->getDocumentosElite($lotes);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
		echo '<table id="tabla_documentos_Elite" width ="100%" class="table table-bordered table-hover" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Gerente 1</th>';
		echo '<th class="text-center">Asesor 1</th>';
		echo '<th class="text-center">Gerente 2</th>';
		echo '<th class="text-center">Asesor 2</th>';
		echo '<th class="text-center">Expediente</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Gerente 1</th>';
		echo '<th class="text-center">Asesor 1</th>';
		echo '<th class="text-center">Gerente 2</th>';
		echo '<th class="text-center">Asesor 2</th>';
		echo '<th class="text-center">Expediente</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['cliente']))  {
			echo "<tr id='".$data['cliente'][$i]['idCliente']."' class='resaltar'>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombre']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombreResidencial']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['primerNombre']." ".$data['cliente'][$i]['segundoNombre']." ".$data['cliente'][$i]['apellidoPaterno']." ".$data['cliente'][$i]['apellidoMaterno']." ".$data['cliente'][$i]['razonSocial']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['gerente1']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['asesor']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['gerente2']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['asesor2']."</td>";
			if($extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) == 'pdf' or $extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) == 'xlsx' ) {
				echo "<td style=text-align:center>
                 <a href='".'editarClienteAsistentesGerentes/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox;width=985;height=460'> 
                <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                </a>   
                </td>";
			}   elseif ($data['cliente'][$i]['expediente'] == NULL) {
				echo "<td style=text-align:center>
                 <a href='".'editarClienteAsistentesGerentes/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox;width=985;height=460'> 
                <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                </a>
                </td>";
			}
			elseif ($extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) != 'pdf' or $extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) != 'xlsx') {
				echo "<td style=text-align:center>
                 <a href='".'editarClienteAsistentesGerentes/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox;width=985;height=460'> 
                    <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                </a>
                </td>";
			}
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_documentos_Elite').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						});
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
		// echo "<script type='text/javascript'>$('document').ready(function(){iniciarTabla();});</script>";
	}

	function getCondominios($residencial)
	{
		$data = $this->registrolote_modelo->getCondominio($residencial);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}

	function getExpediente($lotes)
	{
		$data = $this->registrolote_modelo->getExpedienteCliente($lotes);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
		echo '<table id="tabla_expediente" width ="100%" class="table table-bordered table-hover" style="text-align:center;" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Nombre de Documento</th>';
		echo '<th class="text-center">Hora/Fecha</th>';
		echo '<th class="text-center">Documento</th>';
		echo '<th class="text-center">Elite</th>';
		echo '<th class="text-center">Ubicación</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Nombre de Documento</th>';
		echo '<th class="text-center">Hora/Fecha</th>';
		echo '<th class="text-center">Documento</th>';
		echo '<th class="text-center">Elite</th>';
		echo '<th class="text-center">Ubicación</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="historial_documento">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['historial_documento']))  {
			echo "<tr id='".$data['historial_documento'][$i]['idDocumento']."'>";
			echo "<td style=text-align:center>".$data['historial_documento'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['historial_documento'][$i]['nombreResidencial']."</td>";
			echo "<td style=text-align:center>".$data['historial_documento'][$i]['nombre']."</td>";
			echo "<td style=text-align:center>".$data['historial_documento'][$i]['primerNombre']." ".$data['historial_documento'][$i]['segundoNombre']." ".$data['historial_documento'][$i]['apellidoPaterno']." ".$data['historial_documento'][$i]['apellidoMaterno']." ".$data['historial_documento'][$i]['razonSocial']."</td>";
			echo "<td style=text-align:center>".$data['historial_documento'][$i]['expediente']."</td>";
			echo "<td style=text-align:center>".date("d-m-Y H:i:s", strtotime($data['historial_documento'][$i]['modificado']))."</td>";
			if($extension = current(array_reverse(explode(".", $data['historial_documento'][$i]['expediente']))) == 'pdf') {
				echo "<td style=text-align:center>
                    <a href='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."' rel='shadowbox;width=985;height=660'>
                         <img src='https://contratacion.sisgph.com/contratacion/static/images/pdf.png' width='25' height='23'/>
                            <src='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."'> </a> 
                    </td>";    
			}
			elseif ($extension = current(array_reverse(explode(".", $data['historial_documento'][$i]['expediente']))) == 'xlsx' || $extension = current(array_reverse(explode(".", $data['historial_documento'][$i]['expediente']))) == 'XLSX') {
				echo "<td style=text-align:center>
                <a href='../../static/documentos/cliente/corrida/".$data['historial_documento'][$i]['expediente']."'>
                 <img src='https://contratacion.sisgph.com/contratacion/static/images/excel.png' width='25' height='23'/>
                <src='../../static/documentos/cliente/corrida/".$data['historial_documento'][$i]['expediente']."'> </a> 
                 </td>";
			}
			elseif ($data['historial_documento'][$i]['expediente'] == NULL) {
				echo "<td style=text-align:center>
                 <a href='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."' rel='shadowbox;width=985;height=660'>
                    <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                </a>   
                </td>";
			}
			elseif ($extension = current(array_reverse(explode(".", $data['historial_documento'][$i]['expediente']))) != 'pdf') {
				echo "<td style=text-align:center>
                <a href='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."' rel='shadowbox;width=985;height=660'><img src='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."' width='50' height='30'/> </a> 
                 </td>";
			}
			elseif ($extension = current(array_reverse(explode(".", $data['historial_documento'][$i]['expediente']))) != 'xlsx' || $extension = current(array_reverse(explode(".", $data['historial_documento'][$i]['expediente']))) != 'XLSX') {
				echo "<td style=text-align:center>
                    <a href='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."' rel='shadowbox;width=985;height=660'><img src='../../static/documentos/cliente/expediente/".$data['historial_documento'][$i]['expediente']."' width='50' height='30'/> </a> 
                     </td>";
			}
			echo "<td style=text-align:center>".$data['historial_documento'][$i]['primerNom']." ".$data['historial_documento'][$i]['segundoNom']." ".$data['historial_documento'][$i]['apellidoPa']." ".$data['historial_documento'][$i]['apellidoMa']."</td>";
		    echo "<td style=text-align:center>".$data['historial_documento'][$i]['ubic']."</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_expediente').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						} );
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
	}



	function getCondominioContraloria($residencial)
	{
		$data['condominios'] = $this->registrolote_modelo->getCondominio($residencial);
		echo "<option value='".$data[''][$i]['']."'>ELIJA CONDOMINIO</option>";
		for ($i=0; $i < count($data['condominios']); $i++) {
			echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']."</option>";
		}
	}

	function getLotesDocContraloria($condominio,$residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getLotesDocContraloria($condominio,$residencial);
		echo "<option>ELIJA LOTE</option>";
		$i = 0;
		while ($i<count($data['lotes']))  {
			echo "<option idLote='".$data['lotes'][$i]['idLote']."' value='".$data['lotes'][$i]['idLote']."'>".$data['lotes'][$i]['nombreLote']."</option>";
			$i++;
		}
	}

	function getClienteDocumentosContraloria($lotes) {
		$data['cliente'] = $this->registrolote_modelo->getDocumentosElite($lotes);
		echo '<table id="tabla_documentos_contraloria" cellpadding="0" cellspacing="0" border="0" width ="100%" class="table table-vcenter table-striped">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Corrida</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Corrida</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="documentos">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['cliente']))  {
			echo "<tr id='".$data['cliente'][$i]['idCliente']."' class='resaltar'>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombre']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombreResidencial']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['primerNombre']." ".$data['cliente'][$i]['segundoNombre']." ".$data['cliente'][$i]['apellidoPaterno']." ".$data['cliente'][$i]['apellidoMaterno']." ".$data['cliente'][$i]['razonSocial']."</td>";
			if($extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) == 'pdf' or $extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) == 'xlsx' ) {
				echo "<td style=text-align:center>
                 <a href='".'editarClienteContraloriaCorrida/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox[Vacation]'> 
                     <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                 </a>
                </td>";
			}   elseif ($data['cliente'][$i]['expediente'] == NULL) {
				echo "<td style=text-align:center>
                         <a href='".'editarClienteContraloriaCorrida/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox[Vacation]'> 
                             <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                         </a>
                    </td>";
			}
			elseif ($extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) != 'pdf' or $extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) != 'xlsx') {
				echo "<td style=text-align:center>
                         <a href='".'editarClienteContraloriaCorrida/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox[Vacation]'> 
                         <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                        </a>   
                    </td>";
			}
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready( function () {
				$('#tabla_documentos_contraloria').DataTable({
					"scrollX": true,
					"language": {
						"sProcessing":     "Procesando...",
						"sLengthMenu":     "Mostrar _MENU_ registros",
						"sZeroRecords":    "No se encontraron resultados",
						"sEmptyTable":     "Ningún dato disponible en esta tabla",
						"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":    "",
						"sSearch":         "Buscar:",
						"sUrl":            "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst":    "Primero",
							"sLast":     "Último",
							"sNext":     "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}
					},
					"scrollX": true,
					"scrollY": "350px",
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+ d+'">'+d+'</option>' )
							} );
						} );
					},
					dom: 'Bfrtip',
					"buttons": [   {
						extend: 'print',
						text: 'Imprimir',
						title:  'Modifier entrée',
						exportOptions: {
							columns: ':visible'} },
						{extend: 'excel',
							exportOptions: {
								columns: ':visible' } } ,
						{extend: 'pdfHtml5',
							text: 'PDF',
							exportOptions: {
								columns: ':visible'} },
						{extend: 'copyHtml5',
							text: 'Copiar',
							exportOptions: {
								columns: ':visible'}},
					],
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
				});
			});
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
	}
	public function cancelarPago ($idEnganche){
		$idEnganche=$this->input->post('idEnganche');
		if($this->registrolote_modelo->deletePago($idEnganche)){
			redirect(base_url()."index.php/registroCliente/registrosCliente");
		}else
		{
			die("ERROR");
		}
	}

	public function registrosClientePagos(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_enganche_view",$datos);
	}

	function getCondominioPagos($residencial)
	{
		$data['condominios'] = $this->registrolote_modelo->getCondominio($residencial);
		echo "<option value='".$data[''][$i]['']."'>ELIJA CONDOMINIO</option>";
		for ($i=0; $i < count($data['condominios']); $i++) {
			echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']."</option>";
		}
	}
	function getLotePagos($condominio,$residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getLotesPagos($condominio,$residencial);
		echo "<option>ELIJA LOTE</option>";
		$i = 0;
		while ($i<count($data['lotes']))  {
    		echo "<option idLote='".$data['lotes'][$i]['idLote']."' value='".$data['lotes'][$i]['idLote']."'>".$data['lotes'][$i]['nombreLote']."</option>";
			$i++;

		}
	}


	function getPagos($lotes) {
		$data['historial_enganche'] = $this->registrolote_modelo->getPagosCliente($lotes);
		echo '<table id="tabla_pagos" width ="100%" class="table table-bordered table-hover">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">No Recibo </th>';
		echo '<th class="text-center">Monto</th>';
		echo '<th class="text-center">Concepto</th>';
		echo '<th class="text-center">Tipo de Pago</th>';
		echo '<th class="text-center">Fecha</th>';
		echo '<th class="text-center">Usuario</th>';
		echo '<th class="text-center">Cancelar</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">No Recibo </th>';
		echo '<th class="text-center">Monto</th>';
		echo '<th class="text-center">Concepto</th>';
		echo '<th class="text-center">Tipo de Pago</th>';
		echo '<th class="text-center">Fecha</th>';
		echo '<th class="text-center">Usuario</th>';
		echo '<th class="text-center">Cancelar</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="pagos">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['historial_enganche']))  {
			echo "<tr id='".$data['historial_enganche'][$i]['idEnganche']."' class='resaltar'>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['primerNombre']." ".$data['historial_enganche'][$i]['segundoNombre']." ".$data['historial_enganche'][$i]['apellidoPaterno']." ".$data['historial_enganche'][$i]['apellidoMaterno']." ".$data['historial_enganche'][$i]['razonSocial']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['noRecibo']."</td>";
			echo "<td style=text-align:center>"."$".$data['historial_enganche'][$i]['engancheCliente']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['concepto']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['tipo']."</td>";
			echo "<td style=text-align:center>".date("d-m-Y H:i:s", strtotime($data['historial_enganche'][$i]['fechaEnganche']))."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['user']."</td>";
			echo "<td style=text-align:center>
             <a href='".'editCancelaPago/'.$data['historial_enganche'][$i]['idEnganche']."' class='btn btn-danger btn-xs btn-elimina'> 
                       Cancelar Pago
             </a>
            </td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_pagos').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						} );
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
		// echo "<script type='text/javascript'>$('document').ready(function(){iniciarTabla();});</script>";
	}
	public function editCancelaPago($idEnganche){
		$datos=array();
		$datos["historial_enganche"]= $this->registrolote_modelo->selectPago($idEnganche);
		$this->load->view('cancela_pagoCliente_view',$datos);
	}
	public function editar_pago_cliente(){
		$idEnganche=$this->input->post('idEnganche');
		$comentarioCancelacion=$this->input->post('comentarioCancelacion');
		$fechaCancelacion=$this->input->post('fechaCancelacion');
		$status=$this->input->post('status');
		$user=$this->input->post('user');
		$arreglo=array();
		$arreglo["comentarioCancelacion"]=$comentarioCancelacion;
		$arreglo["fechaCancelacion"]=date('Y-m-d H:i:s');
		$arreglo["status"]= 0;
		$arreglo["user"]=$user;
		if ($this->registrolote_modelo->cancelaPago($idEnganche,$arreglo)){
			redirect(base_url()."index.php/registroCliente/registrosClientePagos");
		}else
		{
			die("ERROR");
		}
	}
	public function registrosClientePagosCancelados(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_cancelacionesEnganche_view",$datos);
	}
	function getCondominioEngancheCancelado($residencial)
	{
		$data['condominios'] = $this->registrolote_modelo->getCondominio($residencial);
		echo "<option value='".$data[''][$i]['']."'>ELIJA CONDOMINIO</option>";
		for ($i=0; $i < count($data['condominios']); $i++) {
			echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']."</option>";
		}
	}

	function getLotePagosCancelados($condominio,$residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getLotesPagos($condominio,$residencial);
		echo "<option>ELIJA LOTE</option>";
		$i = 0;
		while ($i<count($data['lotes']))  {
			echo "<option idLote='".$data['lotes'][$i]['idLote']."' value='".$data['lotes'][$i]['idLote']."'>".$data['lotes'][$i]['nombreLote']."</option>";
			$i++;
		}
	}
	function getPagosCancelados($lotes) {
		$data['historial_enganche'] = $this->registrolote_modelo->getPagosCanceladosCliente($lotes);
		echo '<table id="tabla_pagos_cancelados" width ="100%" class="table table-bordered table-hover">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">No Recibo </th>';
		echo '<th class="text-center">Monto</th>';
		echo '<th class="text-center">Concepto</th>';
		echo '<th class="text-center">Tipo de Pago</th>';
		echo '<th class="text-center">Fecha Cancelación</th>';
		echo '<th class="text-center">Motivo</th>';
		echo '<th class="text-center">Usuario</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">No Recibo </th>';
		echo '<th class="text-center">Monto</th>';
		echo '<th class="text-center">Concepto</th>';
		echo '<th class="text-center">Tipo de Pago</th>';
		echo '<th class="text-center">Fecha Cancelación</th>';
		echo '<th class="text-center">Motivo</th>';
		echo '<th class="text-center">Usuario</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="pagos">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['historial_enganche']))  {
			echo "<tr id='".$data['historial_enganche'][$i]['idEnganche']."' class='resaltar'>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['primerNombre']." ".$data['historial_enganche'][$i]['segundoNombre']." ".$data['historial_enganche'][$i]['apellidoPaterno']." ".$data['historial_enganche'][$i]['apellidoMaterno']." ".$data['historial_enganche'][$i]['razonSocial']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['noRecibo']."</td>";
			echo "<td style=text-align:center>"."$".$data['historial_enganche'][$i]['engancheCliente']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['concepto']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['tipo']."</td>";
			echo "<td style=text-align:center>".date("d-m-Y H:i:s", strtotime($data['historial_enganche'][$i]['fechaCancelacion']))."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['comentarioCancelacion']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['user']."</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_pagos_cancelados').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						} );
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
		// echo "<script type='text/javascript'>$('document').ready(function(){iniciarTabla();});</script>";
	}
	public function registrosClientePagosElite(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_cliente_engancheElite_view",$datos);
	}
	function getPagosAll($lotes)
	{
		$data = $this->registrolote_modelo->getPagosCliente($lotes);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		echo '<table id="tabla_pagosGral" width ="100%" class="table table-bordered table-hover">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">No Recibo </th>';
		echo '<th class="text-center">Monto</th>';
		echo '<th class="text-center">Concepto</th>';
		echo '<th class="text-center">Tipo de Pago</th>';
		echo '<th class="text-center">Fecha</th>';
		echo '<th class="text-center">Usuario</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">No Recibo </th>';
		echo '<th class="text-center">Monto</th>';
		echo '<th class="text-center">Concepto</th>';
		echo '<th class="text-center">Tipo de Pago</th>';
		echo '<th class="text-center">Fecha</th>';
		echo '<th class="text-center">Usuario</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="pagos">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['historial_enganche']))  {
			echo "<tr id='".$data['historial_enganche'][$i]['idEnganche']."' class='resaltar'>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['primerNombre']." ".$data['historial_enganche'][$i]['segundoNombre']." ".$data['historial_enganche'][$i]['apellidoPaterno']." ".$data['historial_enganche'][$i]['apellidoMaterno']." ".$data['historial_enganche'][$i]['razonSocial']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['noRecibo']."</td>";
			echo "<td style=text-align:center>"."$".$data['historial_enganche'][$i]['engancheCliente']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['concepto']."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['tipo']."</td>";
			echo "<td style=text-align:center>".date("d-m-Y H:i:s", strtotime($data['historial_enganche'][$i]['fechaEnganche']))."</td>";
			echo "<td style=text-align:center>".$data['historial_enganche'][$i]['user']."</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_pagosGral').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						} );
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
	}
	public function registroContratoVentasAsistentes(){
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contrato_ventasAsistentes_view",$datos);
	}
	public function registroContratoJuridico(){
        $datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("juridico/datos_cliente_contrato_juridico_view",$datos);
	}

	function getContrato($lotes) {
		$data = $this->registrolote_modelo->getContratoCliente($lotes);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
		echo '<table id="tabla_contrato" width ="100%" class="table table-bordered table-hover" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Nombre de Contrato</th>';
		echo '<th class="text-center">Contrato</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Nombre de Contrato</th>';
		echo '<th class="text-center">Contrato</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['lotes']))  {
			echo "<tr id='".$data['lotes'][$i]['idLote']."'>";
    		echo "<td style=text-align:center>".$data['lotes'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['lotes'][$i]['nombreResidencial']."</td>";
			echo "<td style=text-align:center>".$data['lotes'][$i]['nombre']."</td>";
			echo "<td style=text-align:center>".$data['lotes'][$i]['primerNombre']." ".$data['lotes'][$i]['segundoNombre']." ".$data['lotes'][$i]['apellidoPaterno']." ".$data['lotes'][$i]['apellidoMaterno']." ".$data['lotes'][$i]['razonSocial']."</td>";
			echo "<td style=text-align:center>".$data['lotes'][$i]['contratoArchivo']."</td>";
			if($extension = current(array_reverse(explode(".", $data['lotes'][$i]['contratoArchivo']))) == 'pdf') {
				echo "<td style=text-align:center>
                <a href='../../static/documentos/cliente/contrato/".$data['lotes'][$i]['contratoArchivo']."' rel='shadowbox;width=985;height=660'>
                <img src='https://contratacion.sisgph.com/contratacion/static/images/pdf.png' width='25' height='23'/>
                <src='../../static/documentos/cliente/contrato/".$data['lotes'][$i]['contratoArchivo']."'> </a> 
                 </td>";
			}
			elseif ($extension = current(array_reverse(explode(".", $data['lotes'][$i]['contratoArchivo']))) == 'docx') {
				echo "<td style=text-align:center>
                <a href='../../static/documentos/cliente/contrato/".$data['lotes'][$i]['contratoArchivo']."'>
                 <img src='https://contratacion.sisgph.com/contratacion/static/images/excel.png' width='25' height='23'/>
                <src='../../static/documentos/cliente/contrato/".$data['lotes'][$i]['contratoArchivo']."'> </a> 
                </td>";
			}
			elseif ($data['lotes'][$i]['contratoArchivo'] == NULL) {
				echo "<td style=text-align:center>
                Sin contrato </td>";
			}
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_contrato').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						} );
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
    		Shadowbox.init();
		</script>
		<?php
	}

	public function registrosClienteDS(){
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("asesor/datos_clienteDS_view");
	}
	public function deposito_seriedad($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectDS($idCliente);
		$this->load->view('asesor/dpform',$datos);
	}


    function getAsesorCorrida($gerentes)  {
		$data['asesores'] = $this->registrolote_modelo->getAsesores($gerentes);
		echo "<option value='0'>ELIJA ASESOR</option>";
		for ($i=0; $i < count($data['asesores']); $i++) {
			echo "<option idAsesor='".$data['asesores'][$i]['idAsesor']."' value='".$data['asesores'][$i]['nombreAsesor']."'>".$data['asesores'][$i]['nombreAsesor']."</option>";
		}
	}

	function getCondominioDesc($residenciales) {
		$data = $this->registrolote_modelo->getCondominioDesc($residenciales);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}


	public function registrosClienteAutorizacionVentas(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_clienteAutorizacion_ventas_view",$datos);
	}


	function getLotesVentasAut($condominio,$residencial) {
		$data['lotes'] = $this->registrolote_modelo->getLotesVentasAut($condominio,$residencial);
		echo "<option>ELIJA LOTE</option>";
		$i = 0;
		while ($i<count($data['lotes']))  {
			echo "<option idLote='".$data['lotes'][$i]['idLote']."' value='".$data['lotes'][$i]['idLote']."'>".$data['lotes'][$i]['nombreLote']."</option>";
			$i++;
		}
	}

	function getAutorizacion($lotes)
	{
		$data['cliente'] = $this->registrolote_modelo->getDocumentosElite($lotes);
		echo '<table id="tabla_documentos_Elite" width ="100%" class="table table-bordered table-hover">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Autorización</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Cliente</th>';
		echo '<th class="text-center">Autorización</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i<count($data['cliente']))  {
			echo "<tr id='".$data['cliente'][$i]['idCliente']."' class='resaltar'>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombreLote']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombre']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['nombreResidencial']."</td>";
			echo "<td style=text-align:center>".$data['cliente'][$i]['primerNombre']." ".$data['cliente'][$i]['segundoNombre']." ".$data['cliente'][$i]['apellidoPaterno']." ".$data['cliente'][$i]['apellidoMaterno']." ".$data['cliente'][$i]['razonSocial']."</td>";
			if($extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) == 'pdf' or $extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) == 'xlsx' ) {
				echo "<td style=text-align:center>
                     <a href='".'editarAutorizacionVentas/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox;width=985;height=660'> 
                    <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                    </a>
                 </td>";
			}   elseif ($data['cliente'][$i]['expediente'] == NULL) {
				echo "<td style=text-align:center>
                 <a href='".'editarAutorizacionVentas/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox;width=985;height=660'> 
                     <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                 </a>
                 </td>";

			}
			elseif ($extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) != 'pdf' or $extension = current(array_reverse(explode(".", $data['cliente'][$i]['expediente']))) != 'xlsx') {
				echo "<td style=text-align:center>
                 <a href='".'editarAutorizacionVentas/'.$data['cliente'][$i]['idCliente']."' rel='shadowbox;width=985;height=660'> 
                     <img src='https://contratacion.sisgph.com/contratacion/static/images/up.png' width='25' height='23'/>
                 </a>
                 </td>";
			}
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabla_documentos_Elite').dataTable( {
					initComplete: function () {
						this.api().columns().every( function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo( $(column.footer()).empty() )
								.on( 'change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search( val ? '^'+val+'$' : '', true, false )
										.draw();
								} );
							column.data().unique().sort().each( function ( d, j ) {
								select.append( '<option value="'+d+'">'+d+'</option>' )
							} );
						} );
					},
					"scrollX": true,
					"pageLength": 10,
					// "scrollY": "350px",
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend:    'copyHtml5',
							text:      '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend:    'excelHtml5',
							text:      '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend:    'csvHtml5',
							text:      '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend:    'pdfHtml5',
							text:      '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				} );
			} );
		</script>


		<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
	}


	public function editarAutorizacionVentas($idCliente){
		$datos=array();
		$datos["cliente"]= $this->registrolote_modelo->selectdocs($idCliente);
		$this->load->view('editar_cliente_ventasAutorizacion_view',$datos);
	}

	public function registrosClienteDocumentosContraloria2(){
		$datos=array();
		$datos["residencial"]= $this->registrolote_modelo->getResidencialQro();
		$datos["registrosClienteDocumentosContraloria"]= $this->registrolote_modelo->corridaContraloria2();
		$this->load->view("datos_cliente_documentos_contraloria2_view",$datos);
	}

	public function getEtapa ($residenciales) {
		$data['etapas'] = $this->registrolote_modelo->getEtapa($residenciales);
		for ($i=0; $i < count($data['etapas']); $i++) {
			echo "<option idEtapa='".$data['etapas'][$i]['idEtapa']."' value='".$data['etapas'][$i]['idEtapa']."'>".$data['etapas'][$i]['descripcion']."</option>";
		}
	}



	function getCondominioEtapa($etapa) {

		$data['condominioEtapa'] = $this->registrolote_modelo->getCondominioEtapa($etapa);
		for ($i=0; $i < count($data['condominioEtapa']); $i++) {
			echo "<option idCondominio='".$data['condominioEtapa'][$i]['idCondominio']."' value='".$data['condominioEtapa'][$i]['idCondominio']."'>".$data['condominioEtapa'][$i]['nombre']."</option>";
		}
	}

	public function clientes_info()
	{
		$data["data"]= $this->registrolote_modelo->registroCliente();
		echo json_encode($data);
	}

	function tableClienteDS()
	{
		$data= $this->registrolote_modelo->registroClienteDS();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}

	public function addFileVentas()
	{
		$aleatorio = rand(100,1000);
		$idCliente=$this->input->post('idCliente');
		$nombreResidencial=$this->input->post('nombreResidencial');
		$nombreCondominio=$this->input->post('nombreCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idLote=$this->input->post('idLote');
		$expediente= $_FILES["expediente"]["name"];
		$proyecto = str_replace(' ', '',$nombreResidencial);
		$condominio = str_replace(' ', '',$nombreCondominio);
		$condom = substr($condominio, 0, 3);
		$cond= strtoupper($condom);
		$numeroLote = preg_replace('/[^0-9]/','',$nombreLote);
		$date= date('dmY');
		$composicion = $proyecto."_".$cond.$numeroLote."_".$date;
		$nombArchivo= $composicion;
		$expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$expediente;
		$idCondominio=$this->input->post('idCondominio');
		$arreglo2=array();
		$arreglo2["movimiento"]="Se adjunto Expediente";
		$arreglo2["idCliente"]=$this->input->post('idCliente');
		$arreglo2["idLote"]=$this->input->post('idLote');
		$arreglo2["expediente"]= $expediente;
		$arreglo2["idUser"]=$this->session->userdata('id');
		$arreglo2["idCondominio"]=$this->input->post('idCondominio');
		$arreglo=array();
		$arreglo["expediente"] = $expediente;
		if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
			$this->registrolote_modelo->insert_historial_documento($arreglo2);
			if (move_uploaded_file($_FILES["expediente"]["tmp_name"],"static/documentos/cliente/expediente/".$expediente)) {
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	public function tableClienteDS_query(){
		$this->validateSession();
		$data = $this->registrolote_modelo->registroClienteDS_query();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;

	}



	public function validateSession()
	{
		if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
		{
			//echo "<script>console.log('No hay sesión iniciada');</script>";
			redirect(base_url() . "index.php/login");
		}
	}


	public function getActiveDirs()
	{
		$data = $this->registrolote_modelo->getDirectores();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}

	/*autorizaciones SUBDIRE y DIRECTIVOS*/
	public function directivosAut(){
        $this->load->view('template/header');
        $this->load->view('contratacion/datos_autdirectivos_view');
	}

	function tableAut(){
		$data['data'] = $this->registrolote_modelo->registroClienteAut();
		echo json_encode($data);
	}

	/*funcion para traer autorizaciones a directores con el ID_ROL = 1*/
	public function autsByDC()
	{
		$data['data'] = $this->registrolote_modelo->autsByDC();
		echo json_encode($data);
	}

    public function updateAutsFromsDC() {
		$tamanoOfAuts = ($_POST['numeroDeRow']);
		$idCliente = ($_POST['idCliente']);
		$idCondominio = ($_POST['idCondominio']);
		$idLote = ($_POST['idLote']);
		$idAut = ($_POST['id_autorizacion']);
        $nombreResidencial = ($_POST['nombreResidencial']);
        $nombreCondominio = ($_POST['nombreCondominio']);
        $nombreLote = ($_POST['nombreLote']);
        $autorizacionesCliente = $_POST['autorizacionesCliente'] ?? null;
        $response =  0 ;
        $code = '';
        $mensaje = '';
		$autorizacionComent = "";
		$motivoAut='';
		$type = 0;

		for($i=0; $i < $tamanoOfAuts; $i++){
			$idAut = $_POST['idAutorizacion'.$i];

			if (isset($_FILES["docArchivo".$i]["name"]) && !empty($_FILES["docArchivo".$i]["name"])) {
				$aleatorio = rand(100,1000);
				$expediente=preg_replace('[^A-Za-z0-9]', '',$_FILES["docArchivo".$i]["name"]);
				$proyecto = str_replace(' ', '',$nombreResidencial);
				$condominio = str_replace(' ', '',$nombreCondominio);
				$condominioQuitaN= str_replace(array('Ñ','ñ'),"N",$condominio);
				$condom = substr($condominioQuitaN, 0, 3);
				$cond= strtoupper($condom);
				$numeroLote = preg_replace('/[^0-9]/','',$nombreLote);
				$date= date('dmY');
				$composicion = $proyecto."_".$cond.$numeroLote."_".$date;

                $motivoAut = ($this->session->userdata('id_rol') == 1)
                    ? 'DIRECTOR SUBE ARCHIVO DE AUTORIZACIÓN'
                    : 'SUBDIRECTOR SUBE ARCHIVO DE AUTORIZACIÓN';

				$nombArchivo= $composicion;
				$expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$expediente;
				$arreglo2 = array(
					'movimiento' => $motivoAut,
					'expediente' => $expediente,
					'modificado' => date('Y-m-d h:i:s'),
					'status' => 1,
					'idCliente' => $idCliente,
					'idCondominio' => $idCondominio,
					'idLote' => $idLote,
					'idUser' => $this->session->userdata('id_usuario'),
					'id_autorizacion' => $idAut
				);

				$this->registrolote_modelo->insert_historial_documento($arreglo2);
                move_uploaded_file($_FILES["docArchivo".$i]["tmp_name"],"static/documentos/cliente/expediente/".$expediente);
			}

			$dataUPDAut = array(
				'estatus' => $_POST['accion'.$i]
			);
			$dataInsHA = array(
				'id_autorizacion' => $_POST['idAutorizacion'.$i],
				'autorizacion' => $_POST['observaciones'.$i],
				'estatus' => $_POST['accion'.$i],
				'creado_por' => $this->session->userdata('id_usuario')
			);

			// únicamente se ponen las obsercaciones cuyo estatus sea 3 - va para DC
			if ($_POST['accion'.$i] == 3) {
				$autorizacionComent .= ($i+1).'.- '.$_POST['observaciones'.$i].".<br>";
			}

			$dataUpdAut = $this->registrolote_modelo->updAutFromDC($idAut, $dataUPDAut);
			$dataInsertHA = $this->registrolote_modelo->insertAutFromDC($dataInsHA);

            if (isset($autorizacionesCliente)) {
                $estatus = $_POST['accion'.$i];
                if ($estatus == EstatusAutorizacionesOpcs::AUTORIZADA) {
                    $this->Asesor_model->eliminarCodigoAutorizaciones($idCliente, $_POST["tipo$i"]);
                    $campoEdicion = ($_POST["tipo$i"] == TipoAutorizacionClienteOpcs::CORREO)
                        ? ['autorizacion_correo' => null]
                        : ['autorizacion_sms' => null];

                    $this->General_model->updateRecord('clientes', $campoEdicion, 'id_cliente', $idCliente);
                }
            }

			if($dataUpdAut >= 1 || $dataInsertHA >= 1) {
				if ($_POST['accion'.$i] == 3) {
					$type = 1;
				} else {
					$type = 2;
				}
                $response = 1 ;
                $code = 'success';
                $mensaje = 'La acción se ha realizado correctamente.';
                // se guarda la respuesta para regresar al js
				$this->session->set_userdata('success', 1);
			} else {
				$type = 3;
                $response = 2 ;
                // se guarda la respuesta para regresar al js
				$this->session->set_userdata('error', 99);
                $code = 'warning';
                $mensaje = 'No se ha ejecutado la acción correctamente';
            }
		}

		// SE VALIDA EL TIPO DE ESTATUS 3 VA A DC Y SE ENVÍA CORREO
		if ($type == 1) {
            $idAut = $this->session->userdata('id_usuario');
            $dataUser = $this->Asesor_model->getInfoUserById($idAut);

            $motivoAut = $autorizacionComent;
            
            $encabezados = [
                "nombreResidencial" => "PROYECTO",
                "nombreCondominio"  => "CONDOMINIO",
                "nombreLote"        => "LOTE",
                "motivoAut"         => "AUTORIZACIÓN",
                "fechaHora"         => "FECHA/HORA"
            ];

            $contenido[] = [
                'nombreResidencial' =>  $nombreResidencial,
                'nombreCondominio'  =>  $nombreCondominio,
                'nombreLote'        =>  $nombreLote,
                'motivoAut'         =>  $motivoAut,
                'fechaHora'         =>  date("Y-m-d H:i:s")
            ];

            $this->email
                ->initialize()
                ->from('Ciudad Maderas')
                ->to('tester.ti2@ciudadmaderas.com')
                // ->to($dataUser[0]->correo)
                ->subject('SOLICITUD DE AUTORIZACIÓN - CONTRATACIÓN')
                ->view($this->load->view('mail/registro-cliente/update-auts-from-dc', [
                    'comentario' => $motivoAut,
                    'encabezados' => $encabezados,
                    'contenido' => $contenido
                ], true));

            if($dataUser[0]->correo != 'gustavo.mancilla@ciudadmaderas.com'){
                if($this->email->send()){
                  $data['message_email'] = 'OK';
                } else {
                  $data['message_email'] = $this->email->print_debugger();
                }
            }
		}

        $respuesta = array(
          'code'    => $code,
          'mensaje' => $mensaje,
          'respuesta' => $response,
          // donde 1 es succes y 2 es error
        );

         echo json_encode ($respuesta);
    }

    function getLotesAsesor($condominio,$residencial) {
        $data['lotes'] = $this->registrolote_modelo->getLotesAsesor($condominio,$residencial);
        $data2 = array();
        if(count($data['lotes'])<=0)
        {
            $data['lotes'][0]['idLote'] = 0;
            $data['lotes'][0]['nombreLote'] = 'SIN LOTES PARA ESTE ASESOR';
            echo json_encode($data['lotes']);
        }
        else{
            // echo json_encode($data['lotes']);
            if($this->session->userdata('id_rol') == 5 || /*$this->session->userdata('id_rol') == 6 || */$this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 7)
            {
                for($k=0; $k < count($data['lotes']); $k++)
                {
                    if($data['lotes'][$k]['venta_compartida'] == 2)
                    {
                        $data2[$k] = $data['lotes'][$k];
                    }
                }
                // print_r(json_encode($data['lotes']));
                // echo '<br>';
                // // print_r($data2);
                //

                $data2 = array_values($data2);
                $longitud = count($data['lotes']);
                // print_r($longitud);
                //
                $falgRepeat=0;
                for($k=0; $k < $longitud; $k++)
                {
                    for($t=0; $t < count($data2); $t++){
                        if($data['lotes'][$k]['idLote'] == $data2[$t]['idLote'] && $data['lotes'][$k]['venta_compartida'] == 2)//
                        {
                            $falgRepeat = $falgRepeat + 1;
                        }
                        if($falgRepeat>1){
                            unset($data['lotes'][$k]);
                        }else{
                            $array_final[$k] = $data['lotes'][$k];
                        }

                        /*if($data['lotes'][$k]['idLote'] == $data2[$t]['idLote'] && $data['lotes'][$k]['venta_compartida'] == 2)
                        {
                            unset($data['lotes'][$k]);
                        }
                        else
                        {
                            $array_final[$k] = $data['lotes'][$k];
                        }*/
                    }

                }


                $array_filtrado=array();
                $flag = 0;
                foreach($data['lotes'] as $key => $result){
                    // print_r($result['idLote']);
                    // echo '<br>';
                    if(count($data2)>0){
                        foreach($data2 as $key2 => $result2){
                            if($result['idLote'] == $result2['idLote']){
                                // print_r($result2);
                                // echo '<br>';
                                if($flag==0){
                                    // echo '>';
                                    // print_r($result);
                                    // echo '<br>';
                                    array_push($array_filtrado, $result);
                                }
                                $flag = $flag + 1;
                            }else{
                                array_push($array_filtrado, $result);
                                // print_r($result);
                                // echo '<br>';

                            }

                        }

                    }else{
                        array_push($array_filtrado, $result);
                    }
                }
                // print_r(json_encode($array_filtrado));
                //

                $data['lotes'] = array_values($array_filtrado);
                echo json_encode($data['lotes']);
            }
            else
            {
                echo json_encode($data['lotes']);
            }
        }
    }


	public function addFileAsesor(){

		$aleatorio = rand(100,1000);
		$idCliente=$this->input->post('idCliente');
		$nombreResidencial=$this->input->post('nombreResidencial');
		$nombreCondominio=$this->input->post('nombreCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idLote=$this->input->post('idLote');
		$idCondominio=$this->input->post('idCondominio');
		$expediente_file= preg_replace('[^A-Za-z0-9]', '',$_FILES["expediente"]["name"]);
		$tipodoc=$this->input->post('tipodoc');
		$idDocumento=$this->input->post('idDocumento');




        $data = $this->Asesor_model->revisaOU($idLote);
        if(count($data)>=1){
            $data['message'] = 'OBSERVACION_CONTRATO';
            echo json_encode($data);
           
        }
        else{
            $proyecto = str_replace(' ', '',$nombreResidencial);
            $condominio = str_replace(' ', '',$nombreCondominio);
            $condominioQuitaN= str_replace(array('Ñ','ñ'),"N",$condominio);
            $condom = substr($condominioQuitaN, 0, 3);
            $cond= strtoupper($condom);
            $numeroLote = preg_replace('/[^0-9]/','',$nombreLote);
            $date= date('dmYHis');
            $composicion = $proyecto."_".$cond.$numeroLote."_".$date;

            $nombArchivo= $composicion;
            $expediente=  eliminar_acentos($nombArchivo.'_'.$idCliente.'_'.$aleatorio);

            $fileExt = strtolower(substr($expediente_file, strrpos($expediente_file, '.') + 1));


            if ($fileExt == 'jpeg' || $fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'pdf'){
                $carpeta = '';
                if($tipodoc==31){
                    $carpeta = 'autFechainicio';
                }else{
                    $carpeta = 'expediente';
                }
                $move = move_uploaded_file($_FILES["expediente"]["tmp_name"],"static/documentos/cliente/".$carpeta."/".$expediente.'.'.$fileExt);

                $validaMove = $move == FALSE ? 0 : 1;

                if ($validaMove == 1) {

                    $arreglo=array();
                    $arreglo["expediente"] = $expediente.'.'.$fileExt;


                    $arreglo2=array();
                    $arreglo2["expediente"]= $expediente.'.'.$fileExt;
                    $arreglo2["modificado"]= date('Y-m-d H:i:s');
                    $arreglo2["idUser"]= $this->session->userdata('id_usuario');
                    $this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo);
                    $this->registrolote_modelo->updateDoc($arreglo2,$tipodoc,$idCliente,$idDocumento);

                    $response['message'] = 'OK';
                    echo json_encode($response);

                } else if ($validaMove == 0){
                    $response['message'] = 'ERROR 1';
                    echo json_encode($response);
                } else {
                    $response['message'] = 'ERROR';
                    echo json_encode($response);
                }

            } else {

                $response['message'] = 'ERROR';
                echo json_encode($response);

            }
        }

	}

	public function deleteFile(){

		$idDocumento=$this->input->post('idDocumento');
        $id_tipoDoc = $this->input->post('id_tipoDoc');

		$data=array();
		$data["expediente"]= NULL;
		$data["modificado"]=date("Y-m-d H:i:s");
		$data["idUser"]=0;

        $carpeta = '';
        if($id_tipoDoc == 31){
            $carpeta = 'autFechainicio';
        }else{
            $carpeta = 'expediente';
        }

		$nombreExp = $this->registrolote_modelo->getNomExp($idDocumento);
        $file = "./static/documentos/cliente/".$carpeta."/".$nombreExp->expediente;


		if(file_exists($file)){
			unlink($file);
		}

		$delete=$this->registrolote_modelo->deleteDoc($idDocumento, $data);
		$validaDelete = $delete == TRUE ? 1 : 0;

		if ($validaDelete == 1) {
			$response['message'] = 'OK';
			echo json_encode($response);
		} else if ($validaDelete == 0){
			$response['message'] = 'ERROR';
			echo json_encode($response);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode($response);
		}

	}

	public function getCorrida(){
		$datos=array();
		$datos= $this->registrolote_modelo->getcorridaContraloria();
		echo json_encode($datos);
	}


    public function expedientesWS($lotes, $cliente = '') {
        $query = $this->registrolote_modelo->getdp($lotes, $cliente);
        if (count($query) <= 0) {
            $query = $this->registrolote_modelo->getdp_DS($lotes);
        }

        $data = array_merge(
          $query,
          $this->registrolote_modelo->getExpedienteAll($lotes,$cliente),
          $this->registrolote_modelo->get_auts_by_loteAll($lotes,$cliente),
          $this->registrolote_modelo->getsProspeccionData($lotes,$cliente),
          $this->registrolote_modelo->getEVMTKTD($lotes,$cliente)
        );

        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function getcop() {
      $id_cliente = $this->input->post("id_cliente");
      $response['data'] = $this->registrolote_modelo->getcop($id_cliente);
      echo json_encode($response);
    }
	
    function getResultsClientsSerch()
    {
    ini_set('max_execution_time', 900);
    set_time_limit(900);
    ini_set('memory_limit','2048M');
      $info_client = [];
      $this->input->post('nombre') !== ''
      ? $info_client["cl.nombre"] = $this->input->post('nombre')
      : '';

      $this->input->post('apellido_paterno') !== ''
      ? $info_client["cl.apellido_paterno"] = $this->input->post('apellido_paterno')
      : '';

      $this->input->post('apellido_materno') !== ''
      ? $info_client["cl.apellido_materno"] = $this->input->post('apellido_materno')
      : '';

      $this->input->post('correo') !== ''
      ? $info_client["cl.correo"] = $this->input->post('correo')
      : '';
      
      $data = (!empty($info_client) || count($info_client) > 0) 
              ? $this->registrolote_modelo->getDetailedInfoClients($info_client, $this->input->post('telefono'))
              : array();
      if($data != null) {
          echo json_encode($data);
      } else {
          echo json_encode(array());
      }
    }

    function getLotesAllAssistant($condominio,$residencial)

    {
        $data = $this->registrolote_modelo->getLotesAllAssistant($condominio,$residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    function getregistrosClientesTwo()
    {
        $objDatos = json_decode(file_get_contents("php://input"));
        $index_proyecto = $this->input->post('index_proyecto');
        $index_condominio = $this->input->post('index_condominio');
        $dato = $this->registrolote_modelo->registroClienteTwo($index_proyecto, $index_condominio);
        if ($dato != null) {
            echo json_encode($dato);
        } else {
            echo json_encode(array());
        }
    }

    function getLotesAllTwo($condominio,$residencial)

    {
        $data = $this->registrolote_modelo->getLotesGralTwo($condominio,$residencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    
	function getLotesJuridico($condominio,$residencial)

	{
		$data = $this->registrolote_modelo->getLotesJuridico($condominio,$residencial);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
    public function expedientesReplace($lotes,$cliente = '') {
        $data = $this->registrolote_modelo->getExpedienteReplace($lotes);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
       
	}

	function getSelectedLotes($idCondominio, $idResidencial){
	    $data = $this->registrolote_modelo->getSelectedLotes($idCondominio, $idResidencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
       
    }

    function getClientsByLote(){
      $idLote = $this->input->post('idLote');
        $data = $this->registrolote_modelo->getClientsByLote($idLote);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    function getClientByID(){
        $idLote = $this->input->post('idLote');
        $idCliente = $this->input->post('idCliente');
        $data = $this->registrolote_modelo->getClientByID($idLote == '' ? '' : $idLote,$idCliente == '' ? '' : $idCliente);
        if($data != null) {
          echo json_encode(array("data" => $data));
        } else {
            echo json_encode(array());
        }
       
    }

    function autorizacionesClienteCodigo()
    {
        if ($this->session->userdata('id_rol') == 1) {
            echo json_encode(['data' => []]);
            return;
        }

        $data = $this->registrolote_modelo->autorizacionesClienteCodigo($this->session->userdata('id_usuario'));
        echo json_encode(['data' => $data]);
    }
}
