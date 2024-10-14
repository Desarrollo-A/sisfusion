window.onload = function () {
    const selectElements = document.querySelectorAll('select[data-i18n-label]');

    const updateTitle = (selectElement) => {
        const selectedOption = selectElement.options[selectElement.selectedIndex]?.text || 'No option selected';
        selectElement.setAttribute('title', selectedOption);
    };

    selectElements.forEach(selectElement => {
        if (selectElement.options.length > 0) {
            updateTitle(selectElement);
        }

        selectElement.addEventListener('change', function () {
            updateTitle(selectElement);
        });
    });
};

let copropietarioCollapse = false;
let usuariosContraloria = [2752, 2826, 2810, 5957, 6390, 4857, 2834, 11655];
function validarMensaje(tipoMensaje) {
    if (tipoMensaje === 'danger_1') {
        alerts.showNotification('top', 'right', `${_("alerta-danger_1")}`, 'danger');
        return;
    } else if (tipoMensaje === 'danger_2') {
        alerts.showNotification('top', 'right', `${_("alerta-danger_2")}`, 'danger');
        return;
    } else if (tipoMensaje === 'success') {
        alerts.showNotification('top', 'right', `${_("costo-final")}`, 'success');
        return;
    }
}

$(document).ready(function() {
    $('body').i18n();
    const e = new Event("change");
    const element = document.querySelector('#rfc_check')
    element.dispatchEvent(e);

    personaFisicaMoralOnChange();


    let idPermitidos = [2752, 2826, 2810, 2855, 2815, 6390, 4857, 2834, 9775, 12377, 2799, 10088, 2827, 6012, 12931, 14342, 11655, 16679, 17043];
    if(!idPermitidos.includes(id_usuario_general)){//si el id usuario no está aqui va a hacer la validación de M2 final
        $('#costoM2, #costom2f').on('change', function() {
            const tipoMensaje = validarCostos();
            console.log('tipoMensaje', tipoMensaje);
            validarMensaje(tipoMensaje);
        });
    }
     setTimeout(function() {
        $('body').i18n();
        document.getElementById('lablespan').innerHTML =  _('oferta-vigencia');
     }, 500);
});

function validarCostos() {
    let costoListaM2 = parseFloat($('#costoM2').val().replace('$', '').replace(',', ''));
    let costoFinalM2 = parseFloat($('#costom2f').val().replace('$', '').replace(',', ''));
    let tipoVenta = document.getElementById('tipo_venta').value;


    if (isNaN(costoFinalM2) || isNaN(costoListaM2)) {
        alerts.showNotification('top', 'right', `${_("precio-m2-valor")}`, 'info');
        return;
    }
    const clienteInfo = obtenerCliente(cliente);

    if (tipoVenta == '1') {
        if (costoFinalM2 > costoListaM2 || costoFinalM2 < 0) {
            setTimeout(()=>{
                $('#costom2f').val('');
            }, 1000);
            return 'danger_2';
        } else {
            return 'success';
        }
    } else {
        const descuentoCostoListaM2 = (idDesarrollo == 5 || idDesarrollo == 6) ? costoListaM2 * 0.74 : costoListaM2 * 0.80; // Aplicar el descuento del 20%

        if([0, 1].includes(clienteInfo.proceso)){
            if (costoFinalM2 > costoListaM2 || costoFinalM2 < descuentoCostoListaM2 || costoFinalM2 < 0) {
                setTimeout(()=>{
                    $('#costom2f').val('');
                }, 1000);
                return 'danger_1';
            } 
            else {
                return 'success';
            }
        }
        else{
            return 'success';
        }
    }
}

function personaFisicaMoralOnChange() {
    personaFisicaMoralShowOrHide();
}

function personaFisicaMoralShowOrHide() {
    if (!esPersonaFisicaDocs() && !esPersonaMoralDocs()) {
        $('.persona-fisica-div').show();
        $('.persona-moral-div').show();
    } else if (esPersonaFisicaDocs()) {
        $('.persona-fisica-div').show();
        $('.persona-moral-div').hide();
    } else if (esPersonaMoralDocs()) {
        $('.persona-moral-div').show();
        $('.persona-fisica-div').hide();
    }
}

function esPersonaFisicaDocs() {
    return $('#idOficial_pf').is(':checked') || $('#idDomicilio_pf').is(':checked') || $('#actaMatrimonio_pf').is(':checked');
}

function esPersonaMoralDocs() {
    return $('#poder_pm').is(':checked') || $('#actaConstitutiva_pm').is(':checked') || $('#checks').is(':checked');
}

function resizeInput() {
    $(this).attr('size', $(this).val().length);
}
function validaLadas(){
    if($('#telefono1').val() != '' || $('#telefono1').val() == undefined){
        if($('#ladaTelN').val()=='' || $('#ladaTelN').val() == undefined){
            alerts.showNotification('top', 'right', `${_("tel-1")}`, 'danger');
        }
    }

    if($('#telefono2').val() != '' || $('#telefono2').val() != undefined){
        if($('#ladaTel2').val()=='' || $('#ladaTel2').val() == undefined){
            alerts.showNotification('top', 'right', `${_("tel-2")}`, 'danger');
        }
    }
}

function validaTipoVivienda()
{
    validaLadas();
    if (!$("input[name='tipo_vivienda']").is(':checked')) {
        alerts.showNotification('top', 'right', `${_("tipo-vivienda")}`, 'danger');
    }
    else {
        if (!$("input[name='tipoNc_valor']").is(':checked')) {
            alerts.showNotification('top', 'right', `${_("tipo-residencia")}`, 'danger');
            $('#tipoNc_valor').focus();
            $('#label1').addClass('hover_focus');
            $('#label2').addClass('hover_focus');
            setTimeout(()=>{
                $('#label1').removeClass('hover_focus');
                $('#label2').removeClass('hover_focus');
            },1500)
        }
        else{
            if(!$("input[name='imprimePagare']").is(':checked')  && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
                alerts.showNotification('top', 'right', `${_("opcion-pagares")}`, 'danger');
                $('.imprimePagare').focus();
                $('#labelSi1').addClass('hover_focus');
                $('#labelNo1').addClass('hover_focus');
                setTimeout(() => {
                    $('#labelSi1').removeClass('hover_focus');
                    $('#labelNo1').removeClass('hover_focus');
                }, 1500)
            }
            else{
                if(!$("input[name='tipo_comprobante']").is(':checked') && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
                    alerts.showNotification('top', 'right', `${_("carta-domicilio")}`, 'danger');
                    $('.tipo_comprobante').focus();
                    $('#labelSi2').addClass('hover_focus');
                    $('#labelNo2').addClass('hover_focus');
                    setTimeout(() => {
                        $('#labelSi2').removeClass('hover_focus');
                        $('#labelNo2').removeClass('hover_focus');
                    }, 1500)
                }
            }
        }
    }
}
$('input[name="letraCantidad"]').keyup(resizeInput).each(resizeInput);

function estaEnRango(valor, minimo = 1, maximo = 31) {
    return valor >= minimo && valor <= maximo;
}

function validarDia(input) {
    const valor = parseInt(input.value);
    if (!estaEnRango(valor)) {
        input.value = '';
        alerts.showNotification('top', 'right', `${_("rango-dias")}`, 'warning');
    }
}

function validarRFC(input) {
    const regex = /^[A-Z]{4}\d{6}[A-Z0-9]{3}$/;
    if (!regex.test(input.value)) {
        alerts.showNotification('top', 'right', `${_("formato-rfc")}`, 'warning');
    }
}

function validarCodigoPostal(input) {
    const regex = /^\d{5}$/;
    if (!regex.test(input.value)) {
        alerts.showNotification('top', 'right', `${_("cp-digitos")}`, 'warning');
    }
}

const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

const validate = () => {
    const $result = $('#result');
    const email = $('#correo').val();
    $result.text('');

    if(validateEmail(email)){
        $result.text(`${_("correo-valido")}`);
        $result.css('color', 'rgb(26 159 10)');
    } else{
        $result.text(`${_("correo-invalido")}`);
        $result.css('color', 'red');
    }
    return false;
}

$('#correo').on('input', validate);

function checkResidencia(){
    let valor = document.querySelector('input[name="tipoNc_valor"]:checked').value;
    if(valor == 1){
        //si es de residencia extranjera se debe de preguntar si imprime pagares
        $('#pagarePart').removeClass('hide');
        document.getElementsByName("imprimePagare")[0].setAttribute('required', true);

        if ($('input[name="imprimePagare"]:checked').val() == 1) {
            $('#domicilioCarta').removeClass('hide');
            document.getElementsByName("tipo_comprobante")[0].setAttribute('required', true);
        }
    } else {
        //se vuelve a quitar el apartado de pagares
        $('#pagarePart').addClass('hide');
        $('#domicilioCarta').addClass('hide');
        document.getElementsByName("imprimePagare")[0].removeAttribute('required');
        document.getElementsByName("tipo_comprobante")[0].removeAttribute('required');
    }
}

$('input[type=radio][name=imprimePagare]').change(function () {
    if (this.value == '1') {
        $('#domicilioCarta').removeClass('hide');
        document.getElementsByName("tipo_comprobante")[0].setAttribute('required', true);
    }
    if (this.value == '0') {
        $('#domicilioCarta').addClass('hide');
        document.getElementsByName("tipo_comprobante")[0].removeAttribute('required');
    }
});

function historial() {
    $('#spiner-loader').removeClass('hide');

    $.get(`${general_base_url}Asesor/getHistorialDS/${cliente}`, function (data) {
        const info = JSON.parse(data);
        if (info.length === 0) {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification('top', 'right', `${_("no-hay-movimientos")}`, 'warning');
            return;
        }
        changeSizeModal('modal-md');
        appendBodyModal(historialCampoHtml(info));

        appendFooterModal(`<button type="button" class="btn btn-danger btn-simple" onclick="hideModal()" data-i18n="cerrar">Cerrar</button>`);
        showModal();
        $('#spiner-loader').addClass('hide');

    });
}

function cargarInputs() {
    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].name === "cantidad") {
            inputs[i].value = inputs[i].value;
        }else if (inputs[i].name === "costom2f") {
            inputs[i].value = inputs[i].value;
        }else if (inputs[i].name === "costoM2") {
            inputs[i].value = inputs[i].value;
        }else if (inputs[i].name === "importOferta"){
            inputs[i].value = inputs[i].value;
        }else if (inputs[i].name === "saldoDeposito"){
            inputs[i].value = inputs[i].value;
        }else if (inputs[i].name === "aportMensualOfer"){
            inputs[i].value = inputs[i].value;
        }
    }
}

function guardarInputs() {
  var button = document.getElementsByTagName("button");
  var inputs = document.getElementsByTagName("input");
  for (var i = 0; i < inputs.length; i++) {
    if (button[i].type === "submit") {
        inputs[i].value = inputs[i].value.replace(/\,/g, "");
    }
  }
}

$( ".letrasCaracteres" ).on( "focusout", function(){
    const input = event.target;
    input.value = input.value.trim();
});

$( ".letrasCaracteres" ).on( "keyup", function() {
    const input = event.target;
    const regex = /[^a-zA-Z ñÑáéíóúÁÉÍÓÚüÜ.,-]/g;
    input.value = input.value.replace(regex, '').toUpperCase();
});

$( ".letrasNumeros" ).on( "focusout", function(){
    const input = event.target;
    input.value = input.value.trim();
});

$( ".letrasNumeros" ).on( "keyup", function() {
    const input = event.target;
    const regex = /[^a-zA-Z 0-9@#&_.-]/g;
    input.value = input.value.replace(regex, '').toUpperCase();
});

$( ".espaciosOff" ).on( "focusout", function(){
    const input = event.target;
    input.value = input.value.trim();
});

$("input[data-type='currency']").on({
    keyup: function() {
        formatCurrency($(this));
    },
});

function formatCurrency(input, blur) {
    var input_val = input.val();
    if (input_val === "") { return; }
    // original length
    var original_len = input_val.length;

    // initial caret position 
    var caret_pos = input.prop("selectionStart");
        
    // check for decimal
    if (input_val.indexOf(".") >= 0) {
        var decimal_pos = input_val.indexOf(".");
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);
        left_side = formatNumber(left_side);
        right_side = formatNumber(right_side);
        if (blur === "blur") {
            right_side += "00";
        }
        right_side = right_side.substring(0, 2);
        input_val = "$" + left_side + "." + right_side;

    } else {
        input_val = formatNumber(input_val);
        input_val = "$" + input_val;
        if (blur === "blur") {
        input_val += ".00";
        }
    }
    input.val(input_val);
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

function historialCampoHtml(data) {
    let dataTable = '<h5 data-i18n="historial-movimientos">HISTORIAL DE MOVIMIENTOS</h5>';

    dataTable += `
    <div class="container-fluid">
        <div class="row p-0">
            <div class="col-md-12 offset-md-3 p-0 scroll-styles" style="height: 350px; overflow: auto">
                <ul class="timeline-3">
            `;

    data.forEach(columna => {
        dataTable += `<li><div class="container-fluid">
        <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><small>Campo:</small><b> ${columna.columna}</b></a></div>`;
        columna.detalle.forEach(cambio => {
            dataTable += `<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right"><a class="float-end">${cambio.fecha}</a></div>
            </div>
            </div>
            <p class="m-0"> <span data-i18n="usuario">USUARIO</span>: <b>${(cambio.usuario) ? cambio.usuario : ''} </b></p>
            <p class="m-0"><span data-i18n="campo-anterior">CAMPO ANTERIOR</span>:<b> ${(cambio.anterior != '') ? cambio.anterior : `${_("vacio")}`} </b></p>
            <p class="m-0"><span data-i18n="campo-nuevo">CAMPO NUEVO</span>:<b> ${cambio.nuevo}</b></p>
        </li>`;
        });
    });
    dataTable += '</ul></div></div></div>';
    return dataTable;

}

if(id_rol_general == 7 || usuariosContraloria.includes(id_usuario_general) || onlyView == 0){
    $("#nacionalidad").change(function(){
        let valor_nacionalidad = $('select[name="nacionalidad"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="nac_select" id="nac_select" value="'+valor_nacionalidad+'">');
    });
    $("#estado_civil").change(function(){
        let valor_estado_civil = $('select[name="estado_civil"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="ecivil_select" id="ecivil_select" value="'+valor_estado_civil+'">');
    });
    $("#regimen_matrimonial").change(function(){
        let valor_regimen = $('select[name="regimen_matrimonial"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="regimen_select" id="regimen_select" value="'+valor_regimen+'">');
    });
    $("#parentezco").change(function(){
        let valor_parentezco = $('select[name="parentezco"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="parentezco_select1" id="parentezco_select1" value="'+valor_parentezco+'">');
    });
    $("#parentezco").change(function(){
        let valor_parentezco = $('select[name="parentezco"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="parentezco_select2" id="parentezco_select2" value="'+valor_parentezco+'">');
    });
    const checkbox = document.getElementById("rfc_check");
    const campo1 = document.getElementById("rfc");
    const campo2 = document.getElementById("rfcl");
    const campo3 = document.getElementById("regimenl");
    const campo5 = document.getElementById("codigol");
    const campo6 = document.getElementById("cp_fac");
    checkbox.addEventListener("change", function() {
        if (checkbox.checked) {
            $('#regimenFiscal').prop('required',true);
            $('#rfc').prop('required',true);
            $('#cp_fac').prop('required',true);
            campo1.style.display = "block";
            campo2.style.display = "block";
            campo3.classList.remove("d-none");
            campo5.style.display = "block";
            campo6.style.display = "block";
        } else {
            $('#regimenFiscal').prop('required',false);
            $('#rfc').prop('required',false);
            $('#cp_fac').prop('required',false);
            campo1.style.display = "none";
            campo2.style.display = "none";
            campo3.classList.add("d-none");
            campo5.style.display = "none";
            campo6.style.display = "none";
        }
    });
    window.onscroll = () => {
        const nav = document.querySelector('#sectionBtns');
        if(this.scrollY <= 10) nav.className = ''; else nav.className = 'scroll';
    };
}

$(document).on('click', '#copropietario-collapse', function () {
    if (copropietarioCollapse) {
        $('#copropietario-icono').removeClass('fa-arrow-up');
        $('#copropietario-icono').addClass('fa-arrow-down');
        copropietarioCollapse = !copropietarioCollapse;
    } else {
        $('#copropietario-icono').removeClass('fa-arrow-down');
        $('#copropietario-icono').addClass('fa-arrow-up');
        copropietarioCollapse = !copropietarioCollapse;
    }
});

let validacionRealizada = false;

$(document).on('submit', '#deposito-seriedad-form', async function (e) {
    e.preventDefault();

    if(![17, 32, 70].includes(id_rol_general)){
        const tipoMensaje = validarCostos();
        if (tipoMensaje !== 'success') {
            validarMensaje(tipoMensaje);
            return;
        }
    }
     // if(id_rol_general!= 17 || id_rol_general != 70 || id_rol_general != 32){
     //
     // }

    if (!$("input[name='tipo_vivienda']").is(':checked')) {
        alerts.showNotification('top', 'right', `${_("tipo-vivienda")}`, 'danger');
        return;
    }
    if (!$("input[name='tipoNc_valor']").is(':checked')) {
        alerts.showNotification('top', 'right', `${_("tipo-residencia")}`, 'danger');
        $('#tipoNc_valor').focus();
        $('#label1').addClass('hover_focus');
        $('#label2').addClass('hover_focus');
        setTimeout(()=>{
            $('#label1').removeClass('hover_focus');
            $('#label2').removeClass('hover_focus');
        },1500);
        return;
    }
    if (!$("input[name='imprimePagare']").is(':checked')  && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
            alerts.showNotification('top', 'right', `${_("opcion-pagares")}`, 'danger');
            $('.imprimePagare').focus();
            $('#labelSi1').addClass('hover_focus');
            $('#labelNo1').addClass('hover_focus');
            setTimeout(() => {
                $('#labelSi1').removeClass('hover_focus');
                $('#labelNo1').removeClass('hover_focus');
            }, 1500);
            return;
    }
    if (!$("input[name='tipo_comprobante']").is(':checked') && ($('input[name=tipoNc_valor]:checked').val() == 1)) {
        alerts.showNotification('top', 'right', `${_("carta-domicilio")}`, 'danger');
        $('.tipo_comprobante').focus();
        $('#labelSi2').addClass('hover_focus');
        $('#labelNo2').addClass('hover_focus'); 
        setTimeout(() => {
            $('#labelSi2').removeClass('hover_focus');
            $('#labelNo2').removeClass('hover_focus');
        }, 1500);
        return;
    }



    if (!validateInputArray('telefono2_cop[]', 'Celular')) {
        return;
    }
    if (!validateInputArray('email_cop[]', 'Correo eletrónico')) {
        return;
    }
    if (!validateInputArray('id_particular_cop[]', 'Domicilio particular')) {
        return;
    }
    if (!validateInputArray('originario_cop[]', 'Originario de')) {
        return;
    }
    if (!validateInputArray('ocupacion_cop[]', 'Ocupación')) {
        return;
    }
    if (!validateInputArray('puesto_cop[]', 'Puesto')) {
        return;
    }
    if (!validateInputArray('edadFirma_cop[]', 'Edad firma')) {
        return;
    }
    const data = new FormData(this);
    $('#depositoSeriedadGuardar').attr('disabled', true);
    $.ajax({
        url: `${general_base_url}Asesor/editar_ds`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            const res = JSON.parse(response);
            $('#depositoSeriedadGuardar').attr('disabled', false);
            if (res.code === 200) {
                alerts.showNotification("top", "right", `${_("guardado-exito")}`, "success");
            }
            if (res.code === 400) {
                alerts.showNotification("top", "right", res.message, "warning");
            }
            if (res.code === 500) {
                alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "warning");
            }
        }, error: function () {
            $('#depositoSeriedadGuardar').attr('disabled', false);
            alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "danger");
        }
    });
});

function obtenerCliente() {
    return new Promise((resolve) => {
        $.getJSON(`${general_base_url}Reestructura/obtenerClientePorId/${cliente}`, function (data) {
            resolve(data);
        });
    });
}

/**
 * @param {string} input
 * @param {string} campo
 * @return {boolean}
 */
function validateInputArray(input, campo) {
    let result = true;
    const inputArr = document.getElementsByName(input);
    for (let i = 0; i < inputArr.length; i++) {
        if (inputArr[i].value.length === 0) {
            alerts.showNotification('top', 'right', `${_("el-campo")} ${campo} ${_("del-coopropietario")} ${i+1} ${_("es-requerido")}`, 'danger');
            result = false;
        }
    }
    return result;
}

$('#estado').change(function(){
    let value = $("#estado").val();
    let option = 'select';
    $.getJSON(`${general_base_url}Asesor/getCodigoPostales/${value}/${option}`)
        .done(function(data) {
            let options = data.length ? 
                data.map(item => `<option value="${item.codigo_postal}" data-value="${item.codigo_postal}">${item.codigo_postal}</option>`)
                : `<option selected="selected" disabled>${_("no-se-han-encontrado-reg")}</option>`;
            $("#cp").html(options);
            $("#cp").selectpicker('refresh');
            let selectedCP = $("#cp").data("cp");
            if (selectedCP) {
                $("#cp").val(selectedCP);
                $("#cp").selectpicker('refresh');
            }
        })
        .fail(function() {
            console.error("Error fetching data");
    });
});
