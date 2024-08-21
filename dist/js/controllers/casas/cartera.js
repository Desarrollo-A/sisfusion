let filtro_proyectos = new SelectFilter({ id: 'proyecto', label: 'Proyecto',  placeholder: 'Selecciona una opción' })
let filtro_condominios = new SelectFilter({ id: 'condominio', label: 'Condominio',  placeholder: 'Selecciona una opción' })

let arrayValores = []
let arrayIdLotes = []
let arrayIdClientes = []


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
                            form2.loading(false)
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
            columns: [0, 1, 2, 3, 4],
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
    { data: 'correo' },
    { data: 'lugar_prospeccion' },
    { data: function(data)
        {
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: select_lote, data})
            if (data.idCliente != 0)
                return '<div class="d-flex justify-center">' + pass_button + '</div>'
            else
                return '';
        } 
    },
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
    form.show()
 });
