const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'nombreCliente' },
    { data: 'nombreAsesor' },
    { data: 'nombreGerente' },
    { data: 'tiempoProceso' },
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

            return `<span class="label lbl-${clase}">${data.nombreMovimiento}</span>`
        } 
    },
    { data: function(data){
        let btn_rechazo = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: avanceProcesoBanco, data});
        let btn_avance = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar proceso', onClick: avanceProcesoBanco, data})

        if([5, 6].includes(data.proceso) && data.saldoOOAM == 0){
            return `<div class="d-flex justify-center">${btn_avance}${btn_rechazo}</div>`
        }
        else{
            return ''
        }
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
    url: 'casas/getLotesProcesoBanco',
    params: { proceso: [5, 6], tipoDocumento: 0 },
    buttons: buttons,
    columns,
})

function avanceProcesoBanco(data){
    let form = new Form({
        title: 'Avanzar proceso',
        text: `Se avanzara el proceso del lote ${data.nombreLote}`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/setVoBoSaldos`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    if(response.result){
                        alerts.showNotification("top", "right", response.message, "success")

                        table.reload()
                        form.hide()  
                    }
                    else{
                        alerts.showNotification("top", "right", response.message, "danger")
                    }                          
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")

                    form.loading(false)
                }
            })

        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'tipoSaldo', value: 2 }),
            new HiddenField({ id: 'saldoAdmon', value: data.saldoAdmon }),
            new HiddenField({ id: 'saldoOOAM', value: data.saldoOOAM }),
            new HiddenField({ id: 'saldoGPH', value: data.saldoGPH }),
            new HiddenField({ id: 'saldoPV', value: data.saldoPV }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show();
}