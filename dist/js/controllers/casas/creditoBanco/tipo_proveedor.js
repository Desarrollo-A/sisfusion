let tipos = [
    {label: 'Persona moral', value: 1},
    {label: 'Persona física', value: 2},
]

function select_tipo_proveedor(data) {
    let form = new Form({
        title: 'Seleccionar tipo de proveedor',
        onSubmit: function(data){
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/select_tipo_proveedor`,
                data: data,
                contentType: false,
                processData: false,
                success: function(response){
                    alerts.showNotification("top", "right", "Se ha seleccionado el tipo de proveedor", "success");
                        
                    table.reload()
                    form.hide()
                },
                error: function(){
                    alerts.showNotification("top", "right", "Ha ocurrido un error al enviar los datos", "danger");

                    form.loading(false);
                }
            })
        },
        fields: [
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new SelectField({ id: 'tipoProveedor', placeholder: 'SELECCIONA UNA OPCIÓN',data: tipos, value: data.tipoProveedor }),
        ]
    })

    form.show()
}

function to_precierre_cifras(data) {
    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/avancePaso4`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")

                    table.reload()
                    form.hide()        
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")

                    form.loading(false)
                }
            })

        },
        fields: [
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show();
}

go_to_documentos = function(data) {
    window.location.href = `documentos_proveedor/${data.idProcesoCasas}`;
}

let columns = [
    { data: 'idLote' },
    { data: 'nombreLote' },
    { data: 'condominio' },
    { data: 'proyecto' },
    { data: 'nombreCliente' },
    { data: 'nombreAsesor' },
    { data: 'nombreGerente' },
    { data: function (data) {
        console.log(data.tipoProveedor)
        if(data.tipoProveedor == 1){
            return 'Persona moral'
        }else if(data.tipoProveedor == 2){
            return 'Persona física'
        }else{
            return 'No seleccionado'
        }
    }},
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
        let btn_avance = '';
        let subir_proveedor = ''

        if(data.num_documentos){
            subir_proveedor = new RowButton({icon: 'toc', color: '', label: 'Cargar documentos de proveedor', onClick: go_to_documentos, data});
            
            if(data.num_documentos === data.documentos_subidos){
                btn_avance = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: to_precierre_cifras, data})
            }
        }

        let escoger_tipo = new RowButton({icon: 'check_box', color: '', label: 'Tipo de proveedor', onClick: select_tipo_proveedor, data});

        return `<div class="d-flex justify-center">${btn_avance}${escoger_tipo}${subir_proveedor}</div>`
    } }
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
    // url: 'casas/getLotesProcesoBanco',
    url: 'casas/lista_tipo_proveedor',
    buttons,
    columns,
})