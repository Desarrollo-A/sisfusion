$(document).ready(function() {
    const e = new Event("change");
    const element = document.querySelector('#rfc_check')
    element.dispatchEvent(e);
});

const cliente = "<?=$cliente[0]->id_cliente?>";
function validaTipoVivienda()
{
    if (!$("input[name='tipo_vivienda']").is(':checked')) {
        alerts.showNotification('top', 'right', 'Debes seleccionar un tipo de vivienda', 'danger');
    }
    else {
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

$('input[name="letraCantidad"]')
    .keyup(resizeInput)
    .each(resizeInput);

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
};

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
        changeSizeModal('modal-lg');
        appendBodyModal(historialCampoHtml(info));
        appendFooterModal(`<button type="button" class="btn btn-danger" onclick="hideModal()">Cerrar</button>`);
        showModal();
    });
}

function formatearNumero(numero) {
return "$ " + numero.toString().replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
}

function cargarInputs() {
    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].name === "cantidad") {
            inputs[i].value = formatearNumero(inputs[i].value);
        }else if (inputs[i].name === "costom2f") {
            inputs[i].value = formatearNumero(inputs[i].value);
        }else if (inputs[i].name === "costoM2") {
            inputs[i].value = formatearNumero(inputs[i].value);
        }else if (inputs[i].name === "importOferta"){
            inputs[i].value = formatearNumero(inputs[i].value);
        }else if (inputs[i].name === "saldoDeposito"){
            inputs[i].value = formatearNumero(inputs[i].value);
        }else if (inputs[i].name === "aportMensualOfer"){
            inputs[i].value = formatearNumero(inputs[i].value);
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

// function validarLetras(event) {
// const input = event.target;
// const regex = /[^a-zA-Z]/g;
// input.value = input.value.replace(regex, '');
// }

// function mayus(e) {
// e.value = e.value.toUpperCase();
// }

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
    let html = '<h3>Historial de movimientos</h3>';
    data.forEach(columna => {
        let dataTable = '';
        columna.detalle.forEach(cambio => {
            dataTable += `
            <tr>
              <td>${(cambio.usuario) ? cambio.usuario : ''}</td>
              <td>${cambio.fecha}</td>
              <td>${cambio.anterior}</td>
              <td>${cambio.nuevo}</td>
            </tr>`;
        });

        html += `
            <div class="row">
                <div class="col-lg-12">
                    <h4><b>Campo: ${columna.columna}</b></h4>
                </div>
                <div class="col-lg-12">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Usuario</th>
                          <th scope="col">Modificación</th>
                          <th scope="col">Valor Anterior</th>
                          <th scope="col">Valor Nuevo</th>
                        </tr>
                      </thead>
                      <tbody>
                        ${dataTable}
                      </tbody>
                    </table>
                </div>
            </div>
        `;
    });

    return html;
}

// var url = "<?=base_url()?>";

 if(id_rol_general == 7 || id_usuario_general == 2752 || id_usuario_general == 2826 || id_usuario_general == 2810 || id_usuario_general == 5957 || id_usuario_general == 6390 || id_usuario_general == 4857 || id_usuario_general == 2834){
    // Recordar colocar el onlyView

    $("#nacionalidad").change(function(){
        var valor_nacionalidad = $('select[name="nacionalidad"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="nac_select" id="nac_select" value="'+valor_nacionalidad+'">');
    });

    $("#estado_civil").change(function(){
        var valor_estado_civil = $('select[name="estado_civil"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="ecivil_select" id="ecivil_select" value="'+valor_estado_civil+'">');
    });


    $("#regimen_matrimonial").change(function(){
        var valor_regimen = $('select[name="regimen_matrimonial"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="regimen_select" id="regimen_select" value="'+valor_regimen+'">');
    });

    $("#parentezco").change(function(){
        var valor_parentezco = $('select[name="parentezco"] option:selected').text();
        $(".datos_select").append('<input type="hidden" name="parentezco_select1" id="parentezco_select1" value="'+valor_parentezco+'">');
    });

    $("#parentezco").change(function(){
        var valor_parentezco = $('select[name="parentezco"] option:selected').text();
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
        console.log(nav);
        if(this.scrollY <= 10) nav.className = ''; else nav.className = 'scroll';
    };
}