pass_to_next = function(data) {
    let form = new Form({
        title: 'Validar avance', 
        text: `¿Enviar el lote <b>${data.nombreLote}</b> para validar avance?`,
        onSubmit: function(data){
            //console.log(data)

            $.ajax({
                type: 'POST',
                url: `to_validar_avance`,
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    alerts.showNotification("top", "right", "Se envió el lote al proceso para confirmar pago.", "success");
        
                    table.reload()

                    form.hide();
                },
                error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            })
        },
        fields: [
            new HiddenField({ id: 'id', value: data.idProcesoPagos }),
            new HiddenField({ id: 'avance', value: data.nuevo_avance }),
            new TextAreaField({  id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show()
}

show_form = function(proceso) {
    let form = new Form({
        title: 'Ingresar avance',
        onSubmit: function(data){
            // console.log(data.get('nuevo_avance'))

            let is_ok = true
            let avance = proceso.avanceObra + parseFloat(data.get('nuevo_avance'))

            if(avance > 100){
                alerts.showNotification("top", "right", `El nuevo avance no debe ser mayor a ${100-proceso.avanceObra}%.`, "danger");
                is_ok = false
            }

            if(parseFloat(data.get('nuevo_avance')) == 0){
                alerts.showNotification("top", "right", `El nuevo avance no puede ser 0%.`, "danger");
                is_ok = false
            }

            if(is_ok){
                $.ajax({
                    type: 'POST',
                    url: `add_avance`,
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alerts.showNotification("top", "right", "Se ha creado un nuevo avance.", "success");
            
                        table.reload()

                        form.hide();
                    },
                    error: function () {
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                })
            }
        },
        fields: [
            new HiddenField({ id: 'id_proceso',     value: proceso.idProcesoPagos }),
            new HiddenField({ id: 'id_avance',      value: proceso.idAvance }),
            new NumberField({ id: 'nuevo_avance',   value: proceso.nuevo_avance,   label: 'Nuevo avance',  placeholder: 'Ingresa porcentaje de avance', width:'12', required: true, max: 100 }),
            new NumberField({ id: 'monto',          value: proceso.monto,          label: 'Monto a pagar', placeholder: 'Ingresa la cantidad', width:'12', required: true, mask: "#,##0.00" }),
        ],
    })

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
        return `${data.avanceObra} %`
    } },
    { data: function(data){
        if(data.nuevo_avance){
            return `${data.nuevo_avance} %`
        }
        
        return 'sin ingresar'
    } },
    { data: function(data) {
        if(data.monto){
            return formatter.format(data.monto)
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
    { data: function(data){
        let docu_button = new RowButton({icon: 'toc', label: 'Ingresar nuevo avance', onClick: show_form, data})

        let pass_button = '' 
        if(data.nuevo_avance && data.monto){
            pass_button = new RowButton({icon: 'thumb_up', color: 'green', label: 'Validar depósito', onClick: pass_to_next, data})
        }

        // let back_button = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_documentacion, data})
        
        return `<div class="d-flex justify-center">${docu_button}${pass_button}</div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'pagoscasas/lista_solicitar_avance',
    columns,
})