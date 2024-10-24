let filtro_proyectos = new SelectFilter({ id: 'proyecto', label: 'Proyecto',  placeholder: 'Selecciona una opción' })
let filtro_condominios = new SelectFilter({ id: 'condominio', label: 'Condominio',  placeholder: 'Selecciona una opción' })

let arrayValores = []
let arrayIdLotes = []
let arrayIdClientes = []

let estadoCivil = [];

let typingTimer;
let typingInterval = 100;

$.ajax({
    type: 'GET',
    url: 'residenciales',
    success: function (response) {
        filtro_proyectos.setOptions(response)
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

$(document).ready(function() {
    $.post(`${general_base_url}General/getOpcionesPorCatalogo/18`, function(data) {
        estadoCivil = data.map(item => ({
            value: item.id_opcion,
            label: item.nombre
        }));
    }, 'json');
})

filtro_proyectos.onChange(function(option){
    arrayValores = []
    arrayIdLotes = []
    arrayIdClientes = []


    let btn = document.getElementsByClassName("btn-asignar")
    btn[0].classList.add('hide');

    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function (response) {
            filtro_condominios.setOptions(response)
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

filtro_condominios.onChange(function(option){
    arrayValores = []
    arrayIdLotes = []
    arrayIdClientes = []
    
    let btn = document.getElementsByClassName("btn-asignar");
    btn[0].classList.add('hide');

    table.setParams({condominio: option.value})
    table.reload()
})

let filtros = new Filters({
    id: 'table-filters',
    filters: [
        filtro_proyectos,
        filtro_condominios,
    ],
})

let gerentes = []
let tipoEsquema = [];
let propuestasCasas = [];
tipoEsquema[0] = {label: "Crédito de banco", value: 1}; // credito de banco
tipoEsquema[1] = {label: "Crédito directo", value: 2}; // credito directo

$.ajax({
    type: 'GET',
    url: 'options_gerentes',
    async: false,
    success: function (response) {
        gerentes = response;
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
});

select_lote = function(data) {
    let form = new Form({
        title: 'Iniciar proceso', 
        text: `¿Deseas iniciar el proceso de asignación del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(dataForm){
            form.loading(true)
            let form2 = new FormConfirm({
                title: '¿Estás seguro de iniciar el proceso de asignación?',
                onSubmit: function(){
                    form2.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}/casas/to_asignacion`,
                        data: dataForm,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");
                            table.reload();
                            form2.hide(); 
                            arrayValores = [];
                            arrayIdLotes = [];
                            arrayIdClientes = [];
                            form2.loading(false);
                            form.hide();
                        },
                        error: function (resp) {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            form.loading(false);
                            arrayValores = [];
                            arrayIdLotes = [];
                            arrayIdClientes = [];
                            form2.hide();
                            form2.loading(false);
                        }
                    })
                }
            });
            form2.show();
            form.loading(false);
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
            new SelectField({   id: 'gerente', label: 'Gerente', placeholder: 'Selecciona una opción', width: '12', data: gerentes, required: true }),
        ],
    })

    form.show();
}

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Originación de cartera",
        exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    },
    {
        text: '<i class="fas fa-user-plus"></i>',
        className: 'btn-large btn-sky btn-asignar botonEnviar hide',
        titleAttr: 'Asignar lotes',
        title:"Asignar lotes",
    }
]

let columns = [
    { data: function (data)
        {
            if (data.idCliente != 0)
                return `<div class="d-flex justify-center">
                            <label class="cont">
                                <input type="checkbox" onChange="verificarCheck(this)" data-nombreLote="${data.nombreLote}" data-idLote="${data.idLote}" data-idCliente="${data.idCliente}" name="lotesOrigen[]" value="${data.idLote}" required>
                                <span></span>
                            </label>
                        </div>` ;
            else
                return '';
        }        
    },
    { data: 'proyecto' },
    { data: 'condominio' },
    { data: function(data)
        { return `${data.nombreLote}` } 
    },
    { data: 'idLote' },
    { data: 'precioTotalLote' },
    { data: 'sup' },
    { data: 'cliente' },
    { data: function(data)
        {
            if (data.telefono1 == '' || data.telefono1 == 'NULL'){
                return 'SIN ESPECIFICAR';
            }
            return `${data.telefono1}` 
        } 
    },
    { data: function(data)
        {
            if (data.telefono2 == ''){
                return 'SIN ESPECIFICAR';
            }
            return `${data.telefono2}` 
        } 
    },
    { data: function(data)
        {
            if (data.telefono3 == ''){
                return 'SIN ESPECIFICAR';
            }
            return `${data.telefono3}` 
        } 
    },
    { data: function(data)
        {
            if (data.correo == ''){
                return 'SIN ESPECIFICAR';
            }
            return `${data.correo}` 
        } 
    },
    { data: 'lugar_prospeccion' },
    {data: function(data) {
        let buttons = `<div class="d-flex justify-center">`;

        if(data.idCliente != 0) {
            let pass_button = new RowButton({
                icon: 'thumb_up',
                color: 'green',
                label: 'Avanzar',
                onClick: select_lote,
                data: data
            });
            buttons += pass_button;
        }

        if (data.clienteExistente == 0 || data.clienteExistente == '0') {
            let addCliente = new RowButton({
                icon: 'assignment_ind',
                label : 'Agregar Cliente',
                onClick: subirCliente,
                data: data
            });
            buttons += addCliente;
        }
        if(data.clienteNuevoEditar == 0 || data.clienteNuevoEditar == '0') {
            let editCliente = new RowButton({
                icon: 'edit', 
                label: 'Editar Cliente',
                onClick: editarCliente,
                data: data
            });
            buttons += editCliente;
        }
        buttons += '</div>';
        return buttons;
    }}
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lotes',
    buttons:buttons,
    columns,
})


function verificarCheck(valorActual){
    let botonEnviar = document.getElementsByClassName('botonEnviar');
    let botonAvanzar = document.getElementsByClassName('btn-green');
    let arrayInterno = [];
    let arrayId = [];
    let arrayIdCliente = [];

    if (valorActual.checked){
        arrayInterno.push($(valorActual).attr('data-nombreLote'));
        arrayInterno.push($(valorActual).attr('data-idLote'));
        arrayInterno.push($(valorActual).attr('data-idcliente'));

        arrayId.push($(valorActual).attr('data-idLote'));
        arrayIdCliente.push($(valorActual).attr('data-idcliente'));

        arrayValores.push(arrayInterno);
        arrayIdLotes.push(arrayId);
        arrayIdClientes.push(arrayIdCliente);
    }
    else{
        let indexDelete = buscarValor($(valorActual).val(),arrayValores);
        let indexDeleteId = buscarValor($(valorActual).val(),arrayIdLotes);

        arrayValores = arrayValores.slice(0, indexDelete).concat(arrayValores.slice(indexDelete + 1));
        arrayIdLotes = arrayIdLotes.slice(0, indexDeleteId).concat(arrayIdLotes.slice(indexDeleteId + 1));
    }

    if(arrayValores.length > 1 || (arrayValores.length == 1 && parseFloat(arrayValores[0][5]))){
        //se seleccionó más de uno, se habilita el botón para hacer el multiple
        botonEnviar[0].classList.remove('hide');
        for (let i = 0; i < botonAvanzar.length; i++) {
            botonAvanzar[i].classList.add('hide');
        }
        $('#btn_'+$(valorActual).val()).prop("disabled", true);        
    }
    else{
        botonEnviar[0].classList.add('hide');
        for(let i = 0; i < botonAvanzar.length; i++) {
            botonAvanzar[i].classList.remove('hide');
        }
    }
}

function buscarValor(valor, array) {
    for (let i = 0; i < array.length; i++) {
        const subArray = array[i];
        if (subArray.includes(valor)) {
            return i;
        }
    }
    return null;
}

$(document).on('click', '.btn-asignar', () => {
    let nombresLot = '';
    let separador = '';

    arrayValores.map((elemento, index) => {
        if(arrayValores.length == (index+1))
            separador = '';
        else
            separador = '<br>';
        nombresLot += elemento[0]+separador;
    });

    let form = new Form({
        title: 'Iniciar proceso',
        text: `¿Deseas iniciar el proceso de asignación de los siguientes lotes?<br> <b>${nombresLot}</b>`,
        onSubmit: function(data){
            form.loading(true)
            data.append("idLotes", JSON.stringify(arrayIdLotes));
            data.append("idClientes", JSON.stringify(arrayIdClientes));
            let form2 = new FormConfirm ({
                title: '¿Estás seguro de iniciar el proceso de asignación?',
                onSubmit: function(){
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}casas/to_asignacion_varios`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alerts.showNotification("top", "right", "Se han asignado los lotes correctamente", "success");
                            form2.hide();
                            form.hide();
                            arrayValores = [];
                            arrayIdLotes = [];
                            arrayIdClientes = [];
                            let btn = document.getElementsByClassName("btn-asignar");
                            btn[0].classList.add('hide');
                            table.reload();
                            form.loading(false);
                        },
                        error: function (response) {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            form.loading(false);
                        }
                    })
                }
            });
            form2.show();
            form.loading(false);
        },
        fields: [
            new SelectField({   id: 'gerente', label: 'Gerente', placeholder: 'Selecciona una opción', width: '12', data: gerentes, required: true }),
            //new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })
    form.show();
    form.loading(false);
 });


subirCliente = function(data) {
    let form = new Form({
        title: 'Alta de cliente',
        text: 'Rellena los campos',
        onSubmit: function(dataForm){
            form.loading(true);
            let formConfirm = new FormConfirm({
                title: '¿Estás seguro de crear el cliente?',
                onSubmit: function () {
                    formConfirm.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}/casas/clienteAccion`,
                        data: dataForm,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alerts.showNotification("top", "right", "Se ha agregado el cliente correctamente.", "success");
                            table.reload();
                            formConfirm.hide();
                            formConfirm.loading(false);
                            form.loading(false);
                            form.hide();
                        },
                        error: function(response) {
                            alerts.showNotification("top", "right", response.responseJSON[0] ? response.responseJSON[0] : "Oops, algo salió mal.", "danger");
                            formConfirm.loading(false);
                            formConfirm.hide();
                            form.loading(false);
                        }
                    })
                }
            });
            formConfirm.onCancel = function(){form.loading(false);}
            formConfirm.show();
            form.loading(true);
        }, 
        fields : [
            new TextField({id: 'nombre', label: 'Nombre', placeholder : 'Ingresa el nombre', width: 12, required : true}),
            new TextField({id: 'paterno', label: 'Apellido Paterno', placeholder : 'Ingresa el apellido paterno', width: 12, required : true}),
            new TextField({id: 'materno', label: 'Apellido Materno', placeholder : 'Ingresa el apellido materno', width: 12, required : true}),
            new NumberField({id: 'telefono', label: 'Teléfono', placeholder: 'Ingresa el número telefónico.', width: 6, required: true}),
            new TextField({id: 'correo', label: 'Correo Electrónico', placeholder: 'Ingrese el correo electrónico.', width: 6, required: true}),
            new TextField({id: 'domicilio', label: 'Domicilio', placeholder: 'Ingresa el domicilio', width: 12, required: true}),
            new SelectField({   id: 'estado_civil', label: 'Estado civil', placeholder: 'Selecciona una opción', width: '12', data: estadoCivil, required: true }),
            new TextField({id: 'ocupacion', label: 'Ocupación', placeholder: 'Ingresa la ocupación', width: 12, required: true}),
            new HiddenField({ id: 'altaAccion', value: 1}),
            new HiddenField({ id: 'idLote', value: data.idLote })
        ]
    });
    form.show();
    form.loading(false);
    allowOnlyLetters('nombre');
    allowOnlyLetters('ocupacion');
    allowOnlyLetters('paterno');
    allowOnlyLetters('materno');
}

editarCliente = function (data) {
    let form = new Form({
        title: 'Editar información del cliente',
        text: 'Edita los campos',
        onSubmit: function(dataForm) {
            form.loading(true);
            let formConfirm = new FormConfirm ({
                title: '¿Estás seguro de actualizar la información?',
                onSubmit: function() {
                    formConfirm.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}/casas/clienteAccion`,
                        data: dataForm,
                        contentType: false, processData: false,
                        success: function(response) {
                            alerts.showNotification("top", "right", "Se ha modificado el cliente correctamente.", "success");
                            table.reload();
                            formConfirm.hide();
                            formConfirm.loading(false);
                            form.hide();
                            form.loading(false);
                        },
                        error: function(resp) {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            form.loading(false);
                            formConfirm.hide();
                            formConfirm.loading(false);
                        }
                    })
                }
            });
            formConfirm.onCancel = function(){form.loading(false);}
            formConfirm.show();
            form.loading(true);
        },
        fields: [
            new TextField({id: 'nombre', label: 'Nombre', placeholder : 'Ingresa el nombre', width: 12, required : true, value: data.nombreCliente}),
            new TextField({id: 'paterno', label: 'Apellido Paterno', placeholder : 'Ingresa el apellido paterno', width: 12, required : true, value: data.apePaterno}),
            new TextField({id: 'materno', label: 'Apellido Materno', placeholder : 'Ingresa el apellido materno', width: 12, required : true, value: data.apeMaterno}),
            new NumberField({id: 'telefono', label: 'Teléfono', placeholder: 'Ingresa el número telefónico.', value: data.telefono1,width: 6, required: true}),
            new TextField({id: 'correo', label: 'Correo Electrónico', placeholder: 'Ingrese el correo electrónico.', width: 6, required: true, value: data.correo}),
            new TextField({id: 'domicilio', label: 'Domicilio', placeholder: 'Ingresa el domicilio', width: 12, required: true, value: data.domicilio_particular}),
            new SelectField({   id: 'estado_civil', label: 'Estado civil', placeholder: 'Selecciona una opción', width: '12', data: estadoCivil, required: true , value: data.estado_civil}),
            new TextField({id: 'ocupacion', label: 'Ocupación', placeholder: 'Ingresa la ocupación', width: 12, required: true, value: data.ocupacion}),
            new HiddenField({id: 'idLote', value: data.idLote}),
            new HiddenField({ id: 'altaAccion', value: 2}),
            new HiddenField({ id: 'idCliente', value: data.idCliente })
        ]
    });
    form.show();
    form.loading(false);
    
    allowOnlyLetters('nombre');
    allowOnlyLetters('ocupacion');
    allowOnlyLetters('paterno');
    allowOnlyLetters('materno');
}

$(document).on('input', '#telefono', function() {
    let maxLength = 10;
    if (this.value.length > maxLength) {
        this.value = this.value.slice(0, maxLength);
    }
});

const validarCorreo = (idCorreoInput) => {
    const emailInput = $(idCorreoInput);
    let warningId = emailInput.attr('id') + '_warning';

    let feedback = $(`#${warningId}`);
    let email = emailInput.val();

    if(!email) {
        feedback.text("Debes ingresar un correo").show();
        return;
    }

    feedback.text('');

    if (validateEmail(email)) {
        feedback.text('El correo es válido').css('color', 'rgb(26 159 10').show();
    }
    else {
        feedback.text('El correo es inválido').css('color', 'red').show();
    }
};

$(document).on('input', '#correo', function(){
    clearTimeout(typingInterval);
    typingTimer = setTimeout(() => {
        validarCorreo('#correo');
    }, typingInterval);
});

const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

$('#form-modal3').on('hidden.bs.modal', function(e){
    $('#ok-button-form-modal').prop('disabled', false);
});

function allowOnlyLetters(id) {
    $(`#${id}`).on('input', function() {
        let value = $(this).val();
        $(this).val(value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''));
    });
}
