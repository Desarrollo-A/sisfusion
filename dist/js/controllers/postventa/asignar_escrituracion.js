let filtro_proyectos = new SelectFilter({id: 'proyecto', label: 'Proyecto', placeholder: 'Selecciona un proyecto'});
let filtro_condominios = new SelectFilter({id: 'condominio', label: 'Condominio', placeholder: 'Selecciona un condominio'});

let estadoCivil = [];
let typingTimer;
let typingInterval = 100;

$(document).ready(function() {
    $.post(`${general_base_url}General/getOpcionesPorCatalogo/18`, function(data) {
        estadoCivil = data.map(item => ({
            value: item.id_opcion,
            label: item.nombre
        }));
    }, 'json');
})
$.ajax({
    type: 'GET', 
    url: `residenciales`,
    success: function (response) {
        filtro_proyectos.setOptions(response)
    },
    error: function() {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

filtro_proyectos.onChange(function(option) {
    $.ajax({
        type: 'GET',
        url: `condominios?proyecto=${option.value}`,
        success: function(response) {
            filtro_condominios.setOptions(response)
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    })
});

filtro_condominios.onChange(function(option) {    
    table.setParams({condominio: option.value})
    table.reload();
});

let optionsEscrituracion = [
    {label: 'NO', value: 2},
    {label: 'SÍ', value: 1}
];

let columns = [
    {data: 'idLote'},
    {
        data: function(d) 
        {
            return d.sup + ' <b>m<sup>2</sup></b>';
        }
    },
    {data: 'nombreResidencial'},
    {data: 'nombreCondominio'},
    {data: 'nombreLote'},
    {data: 'nombreCliente'},
    {data: function(data) 
        {
            if (data.escrituraFinalizada == '0' || data.escrituraFinalizada == 0 || data.escrituraFinalizada == null) {
                return `<span class="label lbl-orange">SIN MARCA DE ESCTRITURACIÓN</span>`;
            }
            if(data.escrituraFinalizada == '1') {
                return `<span class="label lbl-green">ESCRITURADO</span>`;
            }
            if(data.escrituraFinalizada == '2') {
                return `<span class="label lbl-warning">NO ESCRITURADO</span>`;
            }
        }
    },
    { data: function(data) 
        {
            let vobo_button = '';
            let asignar_button = '';
            let addCliente = '';
            let editCliente = '';
            //AGREGAR MARCA
            if(data.escrituraFinalizada == 0 && data.idCliente != null){
                asignar_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Agregar Marca', onClick: btn_assign, data});
            }
            //VOBO
            if(data.clienteExistente != 0 && (data.revisionEscrituracion == 0 || data.revisionEscrituracion == null) && data.escrituraFinalizada != 0) {
                vobo_button = new RowButton({icon: 'check', color: 'green', label: 'Visto bueno', onClick: btn_vistoBueno, data});
            }
            //CREAR CLIENTE
            if(data.clienteExistente == 0 || data.clienteExistente == '0') {
                addCliente = new RowButton({icon: 'assignment_ind', label: 'Agregar Cliente', onClick: subirCliente, data: data});
            }
            //EDITAR CLIENTE
            if(data.clienteNuevoEditar == 0) {
                editCliente = new RowButton({icon: 'edit', label: 'Editar Cliente', onClick: editarCliente, data: data})
            }
            return `<div class="d-flex justify-center">${asignar_button}${vobo_button}${addCliente}${editCliente}</div>`;
        }
    }
]

let filtros = new Filters({
    id : 'table-filters',
    filters: [
        filtro_proyectos, 
        filtro_condominios,
    ],
})

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Lotes sin marca de escritura",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

btn_assign = function (data) {
    let form = new Form({
        title : 'Marca de escrituración',
        text: `¿Deseas agregar la marca de escrituración para el lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (dataForm) {
            form.loading(true);
            let formConfirm = new FormConfirm({
                title: '¿Estás seguro de agregar la marca de titulación?',
                onSubmit: function() {
                    formConfirm.loading(true);
                    $.ajax({
                        type: 'POST',
                        url: `${general_base_url}/postventa/asignarMarca`,
                        data: dataForm,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alerts.showNotification("top", "right", "Se ha agregado correctamente la marca.", "success");
                            table.reload();
                            formConfirm.hide();
                            formConfirm.loading(false);
                            form.hide();
                        },
                        error: function (resp) {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            formConfirm.loading(false);
                            formConfirm.hide();
                        }
                    })
                }
            });
            formConfirm.show();
            form.loading(false);
        },
        fields: [
            new SelectField({ id: 'marcaEscrituracion', label: 'Marca de escrituración', placeholder: 'Selecciona una opción', width: '12', data: optionsEscrituracion, required: true}),
            new HiddenField({ id: 'idCliente', value: data.idCliente}),
            new HiddenField({ id: 'accion', value: 1}),
            new HiddenField({ id: 'idLote', value: data.idLote})
        ]
    });
    form.show();
}

btn_vistoBueno = function (data) {
    let form = new Form({
        title: 'Dar el visto bueno',
        text: `¿Deseas dar el visto bueno para el lote: <b>${data.nombreLote}</b>?`,
        onSubmit: function(dataForm) {
            form.loading(false);
            $.ajax({
                type: 'POST',
                url: `${general_base_url}/postventa/asignarMarca`,
                data: dataForm,
                contentType: false,
                processData: false,
                success: function(response) {
                    alerts.showNotification("top", "right", "Se ha dado el visto bueno.", "success");
                    table.reload(null, false);
                    form.hide();
                }, 
                error: function (resp) {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    form.hide();
                }
            });
        }, 
        fields: [
            new HiddenField({ id: 'idCliente', value: data.idCliente}),
            new HiddenField({ id: 'accion', value: 2}),
            new HiddenField({ id: 'idProceso', value: data.idProcesoCasas}),
            new HiddenField({ id: 'idLote', value: data.idLote})
        ]
    });
    form.show();
}

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

let table = new Table({
    id: '#tablaLotes',
    url: 'postventa/escrituraDisponible',
    buttons: buttons,
    columns,
})

