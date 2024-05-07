function set_adeudo(data) {
    let form = new Form({
        title: 'Ingresar adeudo',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        //console.log(data)

        $.ajax({
            type: 'POST',
            url: 'ingresar_adeudo',
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {

                alerts.showNotification("top", "right", "Adeudo ingresado correctamente.", "success");

                table.reload()

                form.hide()
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        })
    }

    form.fields = [
        new HiddenField({ id: 'id', value: data.idProcesoCasas }),
        new NumberField({ id: 'adeudoOoam', value: data.adeudoOOAM, label: 'Adeudo OOAM', placeholder: 'Ingresa la cantidad', width:'12', required:'required' }),
        new NumberField({ id: 'adeudoAdm', value: data.adeudoADM, label: 'Adeudo ADM', placeholder: 'Ingresa la cantidad', width:'12', required:'required' }),
        new NumberField({ id: 'adeudoGph', value: data.adeudoGPH, label: 'Adeudo GPH', placeholder: 'Ingresa la cantidad', width:'12', required:'required' }),
    ]

    form.show()
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        return data.adOOAM
    } },
    { data: function(data){
        return data.adADM
    } },
    { data: function(data){
        return data.adGPH
    } },
    { data: function(data){
        let vigencia = new Date(data.fechaProceso)
        vigencia.setDate(vigencia.getDate() + 2)
        let today = new Date()

        let difference = vigencia.getTime() - today.getTime()

        let days = Math.round(difference / (1000 * 3600 * 24))

        let text = `Quedan ${days} dia(s)`
        if(days < 0){
            text = 'El tiempo establecido ha pasado'
        }

        return text
    } },
    { data: function(data){
        let adeudo_button = new RowButton({icon: 'edit', label: 'Ingresar adeudo', onClick: set_adeudo, data})

        return `<div class="d-flex justify-center">${adeudo_button}</div>`
    } },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Ingresar adeudo",
        exportOptions: {
            columns: [0, 1, 2, 3, 5],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        }
    }
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_adeudos',
    buttons:buttons,
    columns,
})