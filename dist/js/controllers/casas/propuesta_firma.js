let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
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
        /*
        let propuestas_button = new TableButton({icon: 'list', label: 'Propuestas para firma'})
        let upload_button = new TableButton({icon: 'file_upload', label: 'Subir deposito de anticipo', onClick: show_upload, data})

        let view_button = ''
        let pass_button = ''
        if(data.archivo){
            view_button = new TableButton({icon: 'visibility', label: 'Visualizar carta de autorizacion', onClick: show_preview, data})
            pass_button = new TableButton({icon: 'thumb_up', color: 'green', label: 'Pasar a aceptacion de propuestas', onClick: pass_to_validacion_contraloria, data})
        }

        let back_button = new TableButton({icon: 'thumb_down', color: 'warning', label: 'Regresar proceso', onClick: back_to_carga_titulos, data})
        */

        return `<div class="d-flex justify-center"></div>`
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_propuesta_firma',
    buttons: ['excel'],
    columns,
})