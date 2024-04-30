let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'notaria' },
    { data: 'fechaFirma' },
    { data: 'costo' },
]

let buttons = [
    {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Descargar archivo excel',
        title:"Propuesta de firma",
        exportOptions: {
            columns: [0, 1, 2, 3, 4],
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

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_propuesta_firma',
    columns,
    buttons:buttons,
})