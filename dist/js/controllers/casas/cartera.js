let filtro_proyectos = new SelectFilter({ id: 'proyecto', label: 'Proyecto',  placeholder: 'Selecciona una opción' })
let filtro_condominios = new SelectFilter({ id: 'condominio', label: 'Condominio',  placeholder: 'Selecciona una opción' })
let arrayValores = []
let arrayIdLotes = []

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
    })
})

filtro_condominios.onChange(function(option){
    arrayValores = []
    arrayIdLotes = []
    
    let btn = document.getElementsByClassName("btn-asignar")
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
tipoEsquema[0] = {label: "Crédito de banco", value: 1}; // credito de banco
tipoEsquema[1] = {label: "Crédito directo", value: 2}; // credito directo

$.ajax({
    type: 'GET',
    url: 'options_gerentes',
    async: false,
    success: function (response) {
        gerentes = response
    },
    error: function () {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
})

select_lote = function(data) {
    let form = new Form({
        title: 'Iniciar proceso', 
        text: `¿Deseas iniciar el proceso de asignación del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_asignacion`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success");
        
                    table.reload();

                    form.hide();
                    arrayValores = []
                    arrayIdLotes = []
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    
                    form.loading(false)
                    arrayValores = []
                    arrayIdLotes = []
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
            new SelectField({   id: 'gerente', label: 'Gerente', placeholder: 'Selecciona una opción', width: '12', data: gerentes, required: true }),
            new SelectField({   id: 'esquemaCredito', label: 'Tipo de crédito (Esquema)', placeholder: 'Selecciona una opción', width: '12', data: tipoEsquema, required: true }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
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
            return `<center><input type="checkbox" onChange="verificarCheck(this)"
            data-nombreLote="${data.nombreLote}" data-idLote="${data.idLote}" data-idCliente="${data.idCliente}" name="lotesOrigen[]" value="${data.idLote}" required></center>` 
        }        
    },
    {
        data: 'idLote'
    },
    { data: function(data)
        { return `${data.nombreLote}` } 
    },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: function(data)
        {
            let pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: select_lote, data})
            return '<div class="d-flex justify-center">' + pass_button + '</div>'
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
    const tr = $(this).closest('tr');
        const row = $('#tablaAsignacionCartera').DataTable().row(tr);
        let botonEnviar = document.getElementsByClassName('botonEnviar');
        let arrayInterno = [];
        let arrayId = [];
    
        if (valorActual.checked){
            arrayInterno.push($(valorActual).attr('data-nombreLote'));//[0]
            arrayInterno.push($(valorActual).attr('data-idLote'));//[0]

            arrayId.push($(valorActual).attr('data-idLote'));//[1]
    
            arrayValores.push(arrayInterno);
            arrayIdLotes.push(arrayId);
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
            $('#btn_'+$(valorActual).val()).prop("disabled", true);        
        }
        else{
            botonEnviar[0].classList.add('hide');
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
        text: `¿Iniciar proceso de asignación del los siguientes lotes?<br> <b>${nombresLot}</b>`,
        onSubmit: function(data){
            form.loading(true)
            data.append("idLotes", JSON.stringify(arrayIdLotes))
            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_asignacion_varios`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se han asignado los lotes correctamente", "success");
        
                    table.reload();
                    form.hide();
                    arrayValores = []
                    arrayIdLotes = []
                    let btn = document.getElementsByClassName("btn-asignar")
                    btn[0].classList.add('hide');
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");

                    form.loading(false)
                }
            })
        },
        fields: [
            new SelectField({   id: 'gerente', label: 'Gerente', placeholder: 'Selecciona una opción', width: '12', data: gerentes, required: true }),
            new SelectField({   id: 'esquemaCredito', label: 'Tipo de crédito (Esquema)', placeholder: 'Selecciona una opción', width: '12', data: tipoEsquema, required: true }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
 });