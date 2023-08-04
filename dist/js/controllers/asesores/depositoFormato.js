let copropietarioCollapse = false;

$(document).ready(function() {
    const e = new Event("change");
    const element = document.querySelector('#rfc_check')
    element.dispatchEvent(e);

    personaFisicaMoralOnChange();
});

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

$('input[name="letraCantidad"]').keyup(resizeInput).each(resizeInput);

function estaEnRango(valor, minimo = 1, maximo = 31) {
    return valor >= minimo && valor <= maximo;
}

function validarDia(input) {
    const valor = parseInt(input.value);
    if (!estaEnRango(valor)) {
        input.value = '';
        alerts.showNotification('top', 'right', 'El día debe estar dentro del rango del 1 al 31.', 'warning');
    }
}

function validarRFC(input) {
    const regex = /^[A-Z]{4}\d{6}[A-Z0-9]{3}$/;
    if (!regex.test(input.value)) {
        alerts.showNotification('top', 'right', 'El RFC no tiene el formato correcto', 'warning');
    }
}

function validarCodigoPostal(input) {
    const regex = /^\d{5}$/;
    if (!regex.test(input.value)) {
        alerts.showNotification('top', 'right', 'El código postal debe contener 5 dígitos numéricos.', 'warning');
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
        $result.text('El correo es válido');
        $result.css('color', 'rgb(26 159 10)');
    } else{
        $result.text('El correo es inválido.');
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
    $.get(`${general_base_url}Asesor/getHistorialDS/${cliente}`, function (data) {
        const info = JSON.parse(data);
        if (info.length === 0) {
            alerts.showNotification('top', 'right', 'No hay registro de movimientos', 'warning');
            return;
        }
        changeSizeModal('modal-md');
        appendBodyModal(historialCampoHtml(info));

        appendFooterModal(`<button type="button" class="btn btn-danger btn-simple" onclick="hideModal()">Cerrar</button>`);
        showModal();
    });
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

function historialCampoHtml(data) {
    let dataTable = '<h5>HISTORIAL DE MOVIMIENTOS</h5>';

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
            <p class="m-0">USUARIO: <b>${(cambio.usuario) ? cambio.usuario : ''} </b></p>
            <p class="m-0">CAMPO ANTERIOR:<b> ${(cambio.anterior != '') ? cambio.anterior : 'VACIO'} </b></p>
            <p class="m-0">CAMPO NUEVO:<b> ${cambio.nuevo}</b></p>
        </li>`;
        });
    });
    dataTable += '</ul></div></div></div>';
    return dataTable;

}

if(id_rol_general == 7 || id_usuario_general == 2752 || id_usuario_general == 2826 || id_usuario_general == 2810 || id_usuario_general == 5957 || id_usuario_general == 6390 || id_usuario_general == 4857 || id_usuario_general == 2834 || onlyView == 0){
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

$(document).on('submit', '#deposito-seriedad-form', function (e) {
    e.preventDefault();
    if (!$("input[name='tipo_vivienda']").is(':checked')) {
        alerts.showNotification('top', 'right', 'Debes seleccionar un tipo de vivienda', 'danger');
        return;
    }
    if (!$("input[name='tipoNc_valor']").is(':checked')) {
        alerts.showNotification('top', 'right', 'Debes seleccionar el tipo de residencia', 'danger');
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
            alerts.showNotification('top', 'right', 'Debes seleccionar la opción de pagares', 'danger');
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
        alerts.showNotification('top', 'right', 'Debes seleccionar si requieres la carta de domicilio', 'danger');
        $('.tipo_comprobante').focus();
        $('#labelSi2').addClass('hover_focus');
        $('#labelNo2').addClass('hover_focus');
        setTimeout(() => {
            $('#labelSi2').removeClass('hover_focus');
            $('#labelNo2').removeClass('hover_focus');
        }, 1500);
        return;
    }
    const costoListaM2 = parseFloat($('#costoM2').val().replace('$', '').replace(',', ''));
    const costoFinalM2 = parseFloat($('#costom2f').val().replace('$', '').replace(',', ''));
    if (costoFinalM2 > costoListaM2 || costoFinalM2 < ((costoListaM2 * .80))) {
        alerts.showNotification('top', 'right', 'El COSTO POR M2 FINAL no debe ser superior al COSTO POR M2 LISTA ni debe ser inferior al 20% de descuento del COSTO POR M2 LISTA.', 'danger');
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
                alerts.showNotification("top", "right", 'Datos guardados con éxito', "success");
            }
            if (res.code === 400) {
                alerts.showNotification("top", "right", res.message, "warning");
            }
            if (res.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            $('#depositoSeriedadGuardar').attr('disabled', false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

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
            alerts.showNotification('top', 'right', `El campo ${campo} del coopropietario ${i+1} es requerido`, 'danger');
            result = false;
        }
    }
    return result;
}