let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'notaria' },
    { data: 'fechaFirma' },
    { data: 'costo' },
]

let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_propuesta_firma',
    columns,
})