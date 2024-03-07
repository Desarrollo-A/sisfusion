
    function validarMensaje(tipoMensaje) {
        if (tipoMensaje === 'danger_1') {
            alerts.showNotification('top', 'right', 'El COSTO POR M2 FINAL no debe ser superior al COSTO POR M2 LISTA ni debe ser inferior al 20% de descuento del COSTO POR M2 LISTA y tampoco puede ser menor que cero.', 'danger');
            return;
        } else if (tipoMensaje === 'danger_2') {
            alerts.showNotification('top', 'right', 'El COSTO POR M2 FINAL no debe ser superior al COSTO POR M2 LISTA y tampoco puede ser menor que cero.', 'danger');
            return;
        } else if (tipoMensaje === 'success') {
            alerts.showNotification('top', 'right', 'El costo FINAL ingresado es válido', 'success');
            return;
        }
    }

    $(document).ready(function() {
        const e = new Event("change");
        const element = document.querySelector('#rfc_check')
        element.dispatchEvent(e);
        
        $('#costoM2, #costom2f').on('change', function() {
            console.log('entra aqui antes de validar costos');
            const tipoMensaje = validarCostos();
            console.log('tipoMensaje', tipoMensaje);
            validarMensaje(tipoMensaje);
        });
    });

    function validarCostos() {
        let costoListaM2 = parseFloat($('#costoM2').val().replace('$', '').replace(',', ''));  
        let costoFinalM2 = parseFloat($('#costom2f').val().replace('$', '').replace(',', ''));
        console.log('costoListaM2', costoListaM2);
        console.log('costoFinalM2', costoFinalM2);
        console.log('tipoVenta', document.getElementById('tipo_venta').value);
        let tipoVenta = document.getElementById('tipo_venta').value;

        
        if (isNaN(costoFinalM2) || isNaN(costoListaM2)) {
            alerts.showNotification('top', 'right', 'Asegurate que el campo Precio por M2 Final tenga un valor', 'info');
            return;
        }
        const clienteInfo = obtenerCliente(cliente);

        if (tipoVenta == '1') {
            console.log('tipoVenta', tipoVenta);

            if (costoFinalM2 > costoListaM2 || costoFinalM2 < 0) {
                setTimeout(()=>{
                    $('#costom2f').val('');
                }, 1000);
                return 'danger_2';
            } else {
                return 'success';
            }
        } else {
            const descuentoCostoListaM2 = costoListaM2 * 0.80; // Aplicar el descuento del 20%


            if (![2, 3, 4].includes(clienteInfo.proceso)) {
                if (costoFinalM2 > costoListaM2 || costoFinalM2 < descuentoCostoListaM2 || costoFinalM2 < 0) {
                    setTimeout(()=>{
                        $('#costom2f').val('');
                    }, 1000);
                    return 'danger_1';
                } else {
                    return 'success';
                }
            } else {
                if (costoListaM2 > 0 && costoFinalM2 <= costoListaM2 && costoFinalM2 >= 0) {
                    return 'success';
                } else {
                    setTimeout(()=>{
                        $('#costom2f').val('');
                    }, 1000);
                    return 'danger_1';
                }
            }
        }
    }

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
    

    function obtenerCliente() {
        return new Promise((resolve) => {
            $.getJSON(`${general_base_url}Reestructura/obtenerClientePorId/${cliente}`, function (data) {
                resolve(data);
            });
        });
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
        $.get(`${url}Asesor/getHistorialDS/${cliente}`, function (data) {
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

    const checkbox = document.getElementById("rfc_check");
	const campo1 = document.getElementById("rfc");
    const campo2 = document.getElementById("rfcl");
    const campo3 = document.getElementById("regimenl");
    const campo5 = document.getElementById("codigol");
    const campo6 = document.getElementById("cp_fac");

    checkbox.addEventListener("change", function() {

        if (checkbox.checked) {
            campo1.style.display = "block";
            campo2.style.display = "block";
            campo3.classList.remove("d-none");
            campo5.style.display = "block";
            campo6.style.display = "block";
            $('#regimenFiscal').prop('required',true);
            $('#rfc').prop('required',true);
            $('#cp_fac').prop('required',true);
       } else {
            campo1.style.display = "none";
            campo2.style.display = "none";
            campo3.classList.add("d-none");
            campo5.style.display = "none";
            campo6.style.display = "none";
            $('#regimenFiscal').prop('required',false);
            $('#rfc').prop('required',false);
            $('#cp_fac').prop('required',false);
            }
    });


    if(id_rol_general == 7 || id_rol_general == 9 || id_usuario_general == 2752 || id_usuario_general == 2826 || id_usuario_general == 2810 || id_usuario_general == 5957 
    	|| id_usuario_general == 6390 || id_usuario_general == 4857 || id_usuario_general == 2834 || onlyView == 0){
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

     

        window.onscroll = () => {
            const nav = document.querySelector('#sectionBtns');
            if(this.scrollY <= 10) nav.className = ''; else nav.className = 'scroll';
        };
    }
