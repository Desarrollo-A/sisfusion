function set_adeudo(data) {
    let form = new Form({
        title: 'Ingresar adeudo',
        //text: 'Descripcion del formulario',
    })

    form.onSubmit = function(data){
        //console.log(data)
        form.loading(true)

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

                form.loading(false)
            }
        })
    }

    // console.log(data)

    let adeudo
    let value
    let label
    switch(idRol){
        case 99:
            adeudo = 'adeudoOOAM'
            value = data.adeudoOOAM
            label = 'Adeudo OOAM'
            break
        case 101:
            adeudo = 'adeudoGPH'
            value = data.adeudoGPH
            label = 'Adeudo GPH'
            break
        case 33:
            adeudo = 'adeudoADM'
            value = data.adeudoADM
            label = 'Adeudo ADM'
            break
    }

    if([4512].includes(idUsuario)){
        adeudo = 'adeudoGPH'
        value = data.adeudoGPH
        label = 'Adeudo GPH'
    }

    form.fields = [
        new HiddenField({ id: 'id', value: data.idProcesoCasas }),
        new HiddenField({ id: 'adeudo', value: adeudo }),
        new NumberField({ id: 'cantidad', value, label, placeholder: 'Ingresa la cantidad', width:'12', required:true, mask: "#,##0.00" }),
        // new NumberField({ id: 'adeudoAdm', value: data.adeudoADM, label: 'Adeudo ADM', placeholder: 'Ingresa la cantidad', width:'12', required:true, mask: "#,##0.00" }),
        // new NumberField({ id: 'adeudoGph', value: data.adeudoGPH, label: 'Adeudo GPH', placeholder: 'Ingresa la cantidad', width:'12', required:true, mask: "#,##0.00" }),
    ]

    form.show()
}

const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'cliente' },
    { data: 'nombreAsesor' },
    { data: 'gerente' },
    { data: function(data){
        if([4512].includes(idUsuario)){
            return formatter.format(data.adeudoGPH)
        }
        if(idRol === 99 && data.adeudoOOAM){
            return formatter.format(data.adeudoOOAM)
        }
        if(idRol === 101 && data.adeudoGPH){
            return formatter.format(data.adeudoGPH)
        }
        if(idRol === 33 && data.adeudoADM){
            return formatter.format(data.adeudoADM)
        }
        return 'Sin ingresar'
    } },
    { data: function(data){
        let inicio = new Date(data.fechaProceso)
        let today = new Date()

        let difference = today.getTime() - inicio.getTime()

        let days = Math.floor(difference / (1000 * 3600 * 24))

        let text = `Lleva ${days} día(s)`

        return text
    } },
    { data: function (data) {
        switch(data.tipoMovimiento){
        case 1:
            clase = 'warning'
            break
        case 2:
            clase = 'orange'
            break
        default:
            clase = 'blueMaderas'
        }

        return `<span class="label lbl-${clase}">${data.movimiento}</span>`
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
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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