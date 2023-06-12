function cargarInputs() {
    console.log('Si entra a la función cargarInputs DS');
}

$(document).ready(function() {
    const e = new Event("change");
    const element = document.querySelector('#rfc_check')
    element.dispatchEvent(e);
});

function validaTipoVivienda(){
    if (!$("input[name='tipo_vivienda']").is(':checked')) {
        alerts.showNotification('top', 'right', 'Debes seleccionar un tipo de vivienda', 'danger');
    } else {
        if (!$("input[name='tipoNc_valor']").is(':checked')) {
            alerts.showNotification('top', 'right', 'Debes seleccionar el tipo de residencia', 'danger');
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
                alerts.showNotification('top', 'right', 'Debes seleccionar la opción de pagares', 'danger');
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
                    alerts.showNotification('top', 'right', 'Debes seleccionar si requieres la carta de domicilio', 'danger');
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
        $('#domicilioCarta').removeClass('hide');
        document.getElementsByName("imprimePagare")[0].setAttribute('required', true);
        document.getElementsByName("tipo_comprobante")[0].setAttribute('required', true);
    }else{
        //se vuelve a quitar el apartado de pagares
        $('#pagarePart').addClass('hide');
        $('#domicilioCarta').addClass('hide');
        document.getElementsByName("imprimePagare")[0].removeAttribute('required');
        document.getElementsByName("tipo_comprobante")[0].removeAttribute('required');
    }
}

function historial() {
    $.get(`${general_base_url}Asesor/getHistorialDS/${cliente}`, function (data) {
        const info = JSON.parse(data);
        if (info.length === 0) {
            alerts.showNotification('top', 'right', 'No hay registro de movimientos', 'warning');
            return;
        }
        changeSizeModal('modal-md');
        appendBodyModal(historialCampoHtml(info));

        appendFooterModal(`<button type="button" class="btn btn-danger" onclick="hideModal()">Cerrar</button>`);
        showModal();
    });
}

function guardarInputs() {
    const button = document.getElementsByTagName("button");
    const inputs = document.getElementsByTagName("input");
    for (let i = 0; i < inputs.length; i++) {
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

function formatCurrency(input, blur) {
    let input_val = input.val();
    if (input_val === "") { return; }
    // original length
    let original_len = input_val.length;

    // initial caret position
    let caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {
        let decimal_pos = input_val.indexOf(".");
        let left_side = input_val.substring(0, decimal_pos);
        let right_side = input_val.substring(decimal_pos);
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
    let updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

function historialCampoHtml(data) {
    let dataTable = '<h5>HISTORIAL DE MOVIMIENTOS</h5>';

    dataTable += `
    <div class="container-fluid">
        <div class="row p-0">
            <div class="col-md-12 offset-md-3 p-0">
                <ul class="timeline-3 scroll-styles">

            `;

    data.forEach(columna => {
        dataTable += `<li><div class="container-fluid">
        <div class="row">
        <div class="col-md-6"><a><small>Campo:</small><b> ${columna.columna}</b></a></div>`;
        columna.detalle.forEach(cambio => {
            dataTable += `<div class="col-md-6 text-right"><a class="float-end">${cambio.fecha}</a></div>
            </div>
            </div>
            <p class="m-0">USUARIO: <b>${(cambio.usuario) ? cambio.usuario : ''} </b></p>
            <p class="m-0">CAMPO ANTERIOR:<b> ${(cambio.anterior != '') ? cambio.anterior : 'VACIO'} </b></p>
            <p class="m-0">CAMPO NUEVO:<b> ${cambio.nuevo}</b></p>

          </li>
       `;
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