<link href="<?= base_url() ?>dist/css/depositoSeriedad.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
   div.dropdown-menu.open{
   max-height: 314px !important;
   overflow: hidden;
   }
   ul.dropdown-menu.inner{
   max-height: 260px !important;
   overflow-y: auto;
   }
</style>
<body>
   <!-- div de spiner para carga con js -->
   <div class="wrapper">
      <div class = "container"  id="mainBoxDS">
         <div class= "card">
            <section id = "sectionBtns">
               <button data-i18n="guardar-cambios" type="submit" id="depositoSeriedadGuardar" name="guardarC" class="btn btnAction" onclick="guardarCambios();">GUARDAR CAMBIOS</button>
            </section>
            <section>
               <a target="_blank" class="btn btnAction">IMPRIMIR DEPÓSITO</a>
            </section>
            <div class= "container-fluid" id = "mainContainer">
               <div class = "row" id= "encabezadoDS">
                  <div class= "col-12 col-sm-6 col-md-5 col-lg-5">
                     <img  class="w-100" src="<?=base_url()?>static/images/Logo_CM&TP_1.png" alt="Servicios Condominales" title="Servicios Condominales"/>
                  </div>
                  <div class="col-12 col-sm-6 col-md-7 col-lg-7">
                     <h3 class="m-0 mb-1" data-i18n="deposito-seriedad">DEPÓSITO DE SERIEDAD<i class="fas fa-info-circle" style="cursor: pointer;" onclick="historial()"></i></h3>
                  </div>
               </div>
               <!-- encabezados -->
               <div class = "row pt-2" id ="radioDS">
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                     <h6 class="label-on-left mb-0" data-i18n="desarrollo">DESARROLLO</h6>
                     <div class = "radio_container">
                        <!-- sede residencial -->
                     </div>
                     <br>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                     <h4 class="label-on-left mb-0" data-i18n="tipo-lote">TIPO LOTE</h4>
                     <div class="radio_container">
                        <input type = "radio" name = "tipoLote_valor" id = "tipoLote_valor" onclick="return false;" value="0">
                        <label for="one1" data-i18n="habitacional">HABITACIONAL</label>
                        <input type = "radio" name = "tipoLote_valor" id = "tipoLote_valor" onclick="return false;" value="1" >
                        <label for="two2" data-i18n="comercial">COMERCIAL</label>
                     </div>
                  </div>
               </div>
               <!-- radios 1 -->
               <div class="row pt-1 persona-fisica-div" id="checkDS">
                  <h4 class="label-on-left m-0" data-i18n="persona-fisica">PERSONA FÍSICA</h4>
                  <div class="container boxChecks p-0">
                     <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                        <label class="m-0 checkstyleDS">
                        <input type ="checkbox" name="idOficial_pf" id = "idOficial_pf" value="1" onchange="personaFisicaMoralOnChange()">
                        <span data-i18n="identificacion-oficial">IDENTIFICACIÓN OFICIAL</span>
                        </label>
                     </div>
                     <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                        <label class="m-0 checkstyleDS">
                        <input type ="checkbox" name="idDomicilio_pf" id="idDomicilio_pf" value="1" onchange="personaFisicaMoralOnChange()">
                        <span data-i18n="comprobante-domicilio">COMPROBANTE DE DOMICILIO</span>
                        </label>
                     </div>
                     <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                        <label class="m-0 checkstyleDS">
                        <input type ="checkbox" name="actaMatrimonio_pf" id="actaMatrimonio_pf" value="1" onchange="personaFisicaMoralOnChange()">
                        <span data-i18n="acta-matriminio">ACTA DE MATRIMONIO</span>
                        </label>
                     </div>
                  </div>
               </div>
               <!-- radio 2 -->
               <div class="row pt-1 persona-moral-div" id="checkDS">
                  <h4 class="label-on-left m-0" data-i18n="persona-moral">PERSONA MORAL</h4>
                  <div class="container boxChecks p-0">
                     <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                        <label class="m-0 checkstyleDS">
                        <input type ="checkbox" name="poder_pm" id="poder_pm" value="1" value="1" onchange="personaFisicaMoralOnChange()">
                        <span data-i18n="carta-poder">CARTA PODER</span>
                        </label>
                     </div>
                     <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                        <label class="m-0 checkstyleDS">
                        <input type ="checkbox" name="actaConstitutiva_pm" id="actaConstitutiva_pm" value="1" onchange="personaFisicaMoralOnChange()">
                        <span data-i18n="acta-constitutiva">ACTA CONSTITUTIVA</span>
                        </label>
                     </div>
                     <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                        <label class="m-0 checkstyleDS">
                        <input type ="checkbox"class="nombre" name="checks" id="checks" value="apellido_materno" onchange="personaFisicaMoralOnChange()">
                        <span data-i18n="id-oficial">IDE. OFICIAL APODERADO</span>
                        </label>
                     </div>
                  </div>
               </div>
               <!-- radio 3 -->
               <div class="row pt-1" id="boxFactura">
                  <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                     <div class="pb-1">
                        <h4 class="label-on-left m-0" data-i18n="factura">FACTURA</h4>
                        <input type="checkbox" name="rfc_check" id="rfc_check" >
                        <label class="switch" for="rfc_check"></label>
                     </div>
                  </div>
                  <div  class="col-10 col-sm-10 col-md-7 col-lg-7">
                     <div class="form-group label-floating overflow-hidden">
                        <div class="d-none" name="regimenl" id="regimenl">
                           <h4 class="label-on-left m-0" data-i18n="regimen-fiscal">RÉGIMEN FISCAL</h4>
                           <select name="regimenFiscal" data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN" id="regimenFiscal" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%"></select>
                        </div>
                     </div>
                  </div>
                  <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                     <div class="form-group">
                        <h4 class="label-on-left m-0" name="rfcl" id="rfcl" style="display:none;">RFC</h4>
                        <input type="text" pattern="[A-Za-z0-9]+" onblur="validarRFC(this)" class="form-control input-gral" oninput="this.value = this.value.toUpperCase()" name="rfc" id="rfc" style="display:none;">
                     </div>
                  </div>
                  <div  class="col-2 col-sm-2 col-md-2 col-lg-2">
                     <div class="form-group">
                        <h4 class="label-on-left m-0" style="display:none;" name="codigol" id="codigol" data-i18n="codigo-postal">CÓDIGO POSTAL</h4>
                        <input class="form-control input-gral" onblur="validarCodigoPostal(this)"  style="display:none;" name="cp_fac" id="cp_fac">
                     </div>
                  </div>
               </div>
            </div>
            <!-- row factura -->
            <!-- radios 3 -->
            <!-- row especialista escuadron -->
            <div class="row pt-1">
               <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                  <div class="pb-1">
                     <h4 class="label-on-left m-0">ESCUADRON RESCATE</h4>
                     <input type="checkbox" name="escuadronRescate" id="escuadronRescate">
                     <label class="switch" for="escuadronRescate"></label>
                  </div>
               </div>
               <div  class="col col-xs-12 col-sm-3 col-md-6 col-lg-6" id="liderEscuadronDiv">
                  <h4 class="label-on-left m-0">LIDER ESCUADRON RESCATE</h4>
                  <select id="liderEscuadronSelect" name="liderEscuadron" 
                     title="SELECCIONA UNA OPCIÓN"  
                     class=" selectpicker m-0 select-gral"  data-size="7"
                     data-live-search="true" data-container="body" data-width="100%"></select>
                  <input type="hidden" name="idCoordinadorEscuadron" id="idCoordinadorEscuadron">
               </div>
               <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                  <h4 class="label-on-left mb-0">IDIOMA</h4>
                  <div class="radio_container">
                     <input  type="radio" name="idiomaValor"  id="idiomaValor1" value="1">
                     <label for="idiomaValor1">ESPAÑOL</label>
                     <input type="radio" name="idiomaValor"  id="idiomaValor2" value="2">
                     <label for="idiomaValor2">INGLÉS</label>
                  </div>
               </div>
            </div>
            <!-- fin especialista escuadron -->
            <div class="row pt-1">
               <div class="col-sm-6 checkbox-radios" id="radioDS" >
                  <h4 class="label-on-left m-0" data-i18n="residencia">RESIDENCIA (<small style="color: red;">*</small>)</h4>
                  <div class = "radio_container">
                     <input type="radio" name="tipoNc_valor" id="tipoNc_valor1" onchange="checkResidencia()" value="0">
                     <label for="tipoNc_valor1" data-i18n="nacional">NACIONAL</label>
                     <input type="radio" name="tipoNc_valor" id="tipoNc_valor2" onchange="checkResidencia()" value="1">
                     <label for="tipoNc_valor2" data-i18n="extranjero">EXTRANJERO</label>                            
                  </div>
               </div>
               <div class="col col-xs-12 col-sm-3 col-md-3 col-lg-3 boxCustomRadio" id="pagarePart">
                  <h4 class="label-on-left m-0" data-i18n="imprime-pagares">¿IMPRIME PAGARES?</h4>
                  <div class="d-flex">
                     <div class="w-50 mt-1">
                        <input class="customRadio imprimePagare" type="radio" name="imprimePagare" id="imprimePagare1" value="1">
                        <label for="imprimePagare1" data-i18n="si">SÍ</label>
                     </div>
                     <div class="w-50 mt-1">
                        <input class="customRadio imprimePagare" type="radio" name="imprimePagare" id="imprimePagare2" value="0">
                        <label for="imprimePagare2">NO</label>
                     </div>
                  </div>
               </div>
               <div id="domicilioCarta" class="col col-xs-12 col-sm-3 col-md-3 col-lg-3" >
                  <h4 class="label-on-left m-0" data-i18n="carta-domicilio-cm">CARTA DOMICILIO CM (<small style="color: red;">*</small>)</h4>
                  <div class="input-group">
                     <div class="w-50 mt-1">
                        <input class="customRadio tipo_comprobante" type="radio" name="tipo_comprobante" id="tipo_comprobante1" value="1">
                        <label for="tipo_comprobante1" data-i18n="si">SÍ</label>
                     </div>
                     <div class="w-50 mt-1">
                        <input class="customRadio tipo_comprobante" type="radio" name="tipo_comprobante" id="tipo_comprobante2" value="0">
                        <label for="tipo_comprobante2">NO</label>
                     </div>
                  </div>
               </div>
               <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0" >
                <div class="pb-1">
                         <h4 class="label-on-left m-0" data-i18n="venta-extranjero">VENTA EXTRANJERO</h4>
                         <input type="checkbox" name="venta_check" id="venta_check">
                         <label class="switch" for="venta_check"></label>
                </div>
               </div>
            </div>
            
            <!-- row especialista escuadron -->
            <div class="row pt-3" >
                <div class="col-2 col-sm-2 col-md-1 col-lg-1 checkbox pt-0 m-0">
                     <div class="pb-1">
                        <h4 class="label-on-left m-0" data-i18n="escuadron-rescate">ESCUADRÓN RESCATE</h4>
                        <input type="checkbox" name="escuadronRescate" id="escuadronRescate">
                        <label class="switch" for="escuadronRescate"></label>
                     </div>
                </div>
            </div>


         </div>
      </div>
   </div>
</body>
<?php $this->load->view('template/footer');?>
<!-- <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
   <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script> -->
<script src="<?= base_url() ?>dist/js/controllers/casas/creditoDirecto/seriedadCasasFormato.js></script>