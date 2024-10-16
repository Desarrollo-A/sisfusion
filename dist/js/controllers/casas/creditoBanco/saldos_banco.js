const formatter = new Intl.NumberFormat('es-MX', {
  style: 'currency',
  currency: 'MXN',
});

let tipoSaldo = 0; // se define el tipo de saldo 
let campo = ""

switch(idRol){
    case 76: 
    case 81: 
    case 55: // portventa 
    case 11: // portventa 
        if(idUsuario == 5107 || idRol == 11){ // yolanda 
            tipoSaldo = 1;
            campo = "saldoAdmon";
        }
        else if(idUsuario == 4512){
            tipoSaldo = 3;
            campo = "saldoGPH";
        }
        else{
            tipoSaldo = 4;
            campo = "saldoPV";
        }
        break;
    
    case 99: // OOAM
        tipoSaldo = 2;
        campo = "saldoOOAM";
        break;

    case 33:
        tipoSaldo = 3;
        campo = "saldoGPH";
        break;
    
    case 101: // gph
        tipoSaldo = 3;
        campo = "saldoGPH";
        break;

    case 11: // ADM
        tipoSaldo = 1;
        campo = "saldoAdmon";
        break;
}

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
        let btn_rechazo = ''
        let btn_avance = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: avanceProcesoBanco, data})

        if(data.cierreContraloria == 1){ // solo si el usaurio es Patricia Maya y si se ha dado un avance en el cierre de contraloria
            btn_rechazo = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: rechazo_proceso, data});
        }
        if( tipoSaldo == 1 && data.saldoAdmon == 0){
            return `<div class="d-flex justify-center">${btn_avance}${btn_rechazo}</div>`
        }
        if( tipoSaldo == 2 && data.saldoOOAM == 0){
            return `<div class="d-flex justify-center">${btn_avance}${btn_rechazo}</div>`
        }
        if( tipoSaldo == 3 && data.saldoGPH == 0){
            return `<div class="d-flex justify-center">${btn_avance}${btn_rechazo}</div>`
        }
        if( tipoSaldo == 4 && data.saldoPV == 0){
            
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
    params: { proceso: [5, 6], tipoDocumento: 0, tipoSaldo: tipoSaldo, campo: campo },
    buttons: buttons,
    columns,
})

function avanceProcesoBanco(data){
    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true);

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/voboPaso6`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    response = JSON.parse(response);
                    console.log(response.avance);
                    if(response.result){
                        if(response.avance == 1){
                            avanceProceso(data, form);
                        }
                        else{
                            alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")

                            table.reload()
                            form.hide()  
                        }                        
                    }
                    else{
                        alerts.showNotification("top", "right", "Error al avanzar el proceso", "danger")
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
            new HiddenField({ id: 'tipoSaldo', value: tipoSaldo }),
            new HiddenField({ id: 'saldoAdmon', value: data.saldoAdmon }),
            new HiddenField({ id: 'saldoOOAM', value: data.saldoOOAM }),
            new HiddenField({ id: 'saldoGPH', value: data.saldoGPH }),
            new HiddenField({ id: 'saldoPV', value: data.saldoPV }),
            new HiddenField({ id: 'cierreContraloria', value: data.cierreContraloria }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
        ],
    })

    form.show();
}

function avanceProceso(data, form){
    $.ajax({
        type: 'POST',
        url: `${general_base_url}casas/avancePaso5_6`,
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
}

rechazo_proceso = function (data) {
    let form = new Form({
        title: 'Rechazar proceso',
        text: `¿Deseas rechazar el lote <b>${data.nombreLote}</b>?`,
        onSubmit: function (data) {
            form.loading(true)

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/rechazoPaso6`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    alerts.showNotification("top", "right", "Se ha rechazado el proceso correctamente", "success")
        
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
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 12 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),       
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
            new HiddenField({ id: 'idCliente', value: data.idCliente }),
        ],
    })

    form.show()
}