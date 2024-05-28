backPage = function() {
    window.location.href = `${general_base_url}casas/reporte_casas`
}

let buttons = [
    {
        text: '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
        action: function() {
            backPage()
        },
        attr: {
            class: 'btn-back',
            style: 'position: relative; float: left',
            title: 'Regresar'
        }
    },
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Documentacion del lote",
        exportOptions: {
            columns: [0, 1, 2, 3],
            format: {
                header: function (d, columnIdx) {
                    return $(d).attr('placeholder');
                }
            }
        },
        attr: {
            style: 'position: relative; float: left; margin: 5px',
        }
    }
]

let columns = [
    { data: 'procesoAnterior' },
    { data: 'procesoNuevo' },
    { data: 'descripcion' },
    { data: 'idMovimiento' },
    { data: 'usuarioMovimiento' },
    { data: function(data){
        return data.fechaMovimiento.substring(0, 16)
    } },
]

let table = new Table({
    id: '#tableDoct',
    url: `casas/lista_historial/${idProcesoCasas}`,
    buttons: buttons,
    columns,
})