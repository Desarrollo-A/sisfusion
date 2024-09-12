let form = new Form({
    title: 'Asignar asesor',
    text: 'Asigna un asesor para avanzar el proceso',
})


let arrayValores = []
let arrayIdClientes = []
let arrayIdLotes = [];

form.onSubmit = function (data) {
    form.loading(true);
    formConfirm = new FormConfirm({
        title: '¿Estás seguro de la asignación?',
        onSubmit: function() {
            formConfirm.loading(true);
            $.ajax({
                type: 'POST',
                url: 'asignar',
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se asignó el asesor correctamente.", "success");;
                    table.reload();
                    arrayValores = [];
                    arrayIdClientes = [];
                    let arrayIdLotes = [];
                    let btn = document.getElementsByClassName("btn-asignar")
                    btn[0].classList.add('hide');
                    formConfirm.hide();
                    form.hide();
                    formConfirm.loading(false);
                }, error: function() {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    formConfirm.hide();
                }
            })

        }
    });
    formConfirm.show();
    form.loading(false);
}

let items = []

$.ajax({
    type: 'GET',
    url: 'options_asesores',
    async: false,
    success: function (response) {
        items = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

function choose_asesor(data) {
    form.fields = [
        new HiddenField({ id: 'idCliente', value: data.id_cliente }),
        new HiddenField({id: 'idLote', value: data.idLote}),
        new SelectField({ id: 'asesor', label: 'Asesor', value: data.idAsesor, placeholder: 'Selecciona una opción', data: items, required: true }),
    ]
    form.show()
}

select_asesor = function (data) {

    let form = new Form({
        title: 'Continuar proceso',
        text: `¿Deseas asignar a <b>${data.nombreAsesor}</b> al lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_carta_auth`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");

                    table.reload();

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })

        },
        fields: [
            new HiddenField({ id: 'id', value: data.idProcesoCasas }),
            new HiddenField({ id: 'esquemaCreditoCasas', value: data.esquemaCreditoCasas }),
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'asesor', value: data.idAsesor }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

cancel_process = function (data) {

    let form = new Form({
        title: 'Cancelar proceso',
        text: `¿Desea cancelar el proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `cancel_process`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", `El proceso del lote ha sido cancelado.`, "success");

                    table.reload()
                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })

        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idCliente', value: data.id_cliente }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}


let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Asignación de cartera",
        exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
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
            let check = ''

            if(!data.idAsesor){
                check = `<div class="d-flex justify-center">
                        <label class="cont">
                            <input type="checkbox" onChange="verificarCheck(this)" data-idCliente="${data.id_cliente}" data-nombreLote="${data.nombreLote}" data-idLote="${data.idLote}" name="lotesOrigen[]" value="${data.idLote}" required>
                            <span></span>
                        </label></div>`
            }

            return check
        }        
    },
    { data: 'proyecto' },
    { data: 'condominio' },
    { data: 'nombreLote' },
    { data: 'idLote' },
    { data: 'precioTotalLote' },
    { data: 'sup' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: 'cliente' },
    { data: function(data)
        {
            if (data.telefono1 == ''){
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
    {
        data: function (data) {
            let asesor_button = new RowButton({ icon: 'assignment_ind', label: 'Asignar asesor', onClick: choose_asesor, data })

            let pass_button = ''
            if (data.idAsesor) {
                pass_button = new RowButton({ icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: select_asesor, data })
            }

            return `<div class="d-flex justify-center">${asesor_button}${pass_button}</div>`
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_asignacion',
    buttons: buttons,
    columns,
    buttons,
})

function verificarCheck(valorActual){
    const tr = $(this).closest('tr');
        const row = $('#tablaAsignacionCartera').DataTable().row(tr);
        let botonEnviar = document.getElementsByClassName('botonEnviar');
        let botonAsesor = document.getElementsByClassName('btn-blueMaderas');
        let arrayInterno = [];
        let arrayId_cliente = [];
        let arrayId_lotes = [];
    
        if (valorActual.checked){
            arrayInterno.push($(valorActual).attr('data-nombreLote'));//[0]
            arrayInterno.push($(valorActual).attr('data-idLote'));//[1]

            arrayId_cliente.push($(valorActual).attr('data-idCliente'));//[0]
            arrayId_lotes.push($(valorActual).attr('data-idLote'));//[1]
    
            arrayValores.push(arrayInterno);
            arrayIdClientes.push(arrayId_cliente);
            arrayIdLotes.push(arrayId_lotes);
        }
        else{
            let indexDelete = buscarValor($(valorActual).val(),arrayValores);
            let indexDeleteId = buscarValor($(valorActual).val(),arrayIdClientes);
            let indexDeleteIdLote = buscarValor($(valorActual).val(),arrayIdLotes);

            arrayValores = arrayValores.slice(0, indexDelete).concat(arrayValores.slice(indexDelete + 1));
            arrayIdClientes = arrayIdClientes.slice(0, indexDeleteId).concat(arrayIdClientes.slice(indexDeleteId + 1));
            arrayIdLotes = arrayIdLotes.slice(0, indexDeleteIdLote).concat(arrayIdLotes.slice(indexDeleteIdLote + 1));
        }

        if(arrayValores.length > 1 || (arrayValores.length == 1 && parseFloat(arrayValores[0][5]))){
         //se seleccionó más de uno, se habilita el botón para hacer el multiple
            botonEnviar[0].classList.remove('hide');
            for(let i = 0; i < botonAsesor.length; i++) {
                botonAsesor[i].classList.add('hide');
            }
            $('#btn_'+$(valorActual).val()).prop("disabled", true);        
        }
        else{
            botonEnviar[0].classList.add('hide');
            for(let i = 0; i < botonAsesor.length; i++) {
                botonAsesor[i].classList.remove('hide');
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
        title: 'Asignar lotes a asesor',
        text: `¿Iniciar proceso de asignación del los siguientes lotes?<br> <b>${nombresLot}</b>`,
        onSubmit: function(data){
            form.loading(true)
            data.append("idClientes", JSON.stringify(arrayIdClientes));
            data.append("idLotes", JSON.stringify(arrayIdLotes));
            formConfirm = new FormConfirm({
                title: '¿Estás seguro de asignar los lotes?',
                onSubmit: function() {
                    formConfirm.loading(true);
                     $.ajax({
                        type: 'POST',
                        url: `${general_base_url}casas/to_asignacion_asesor`,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            alerts.showNotification("top", "right", "Se han asignado los lotes correctamente", "success");
                            table.reload();
                            form.hide();
                            formConfirm.hide();
                            arrayValores = [];
                            arrayIdClientes = [];
                            arrayIdLotes = [];
                            let btn = document.getElementsByClassName("btn-asignar")
                            btn[0].classList.add('hide');
                            formConfirm.loading(false);
                        },
                        error: function () {
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                            formConfirm.loading(false);
                            form.loading(false)
                            arrayValores = [];
                            arrayIdClientes = [];
                            arrayIdLotes = [];
                            formConfirm.hide();
                        }
                    })
                }
            });
            formConfirm.show();
            form.loading(false);
        },
        fields: [
            new SelectField({ id: 'asesor', label: 'Asesor', placeholder: 'Selecciona una opción', data: items, required: true })
        ],
    })
    form.show()
 });