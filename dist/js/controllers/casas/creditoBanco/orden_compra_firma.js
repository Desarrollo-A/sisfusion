// let valor_avance = 5; // valor predefinido al que se debe avanzar normalmente, a excepcion de cuando es rechazo de un paso mas alto

// const formatter = new Intl.NumberFormat('es-MX', {
//   style: 'currency',
//   currency: 'MXN',
// });

// let opcionRegreso = 0
// let datos = "";

// let formRegreso = $("#modalRegreso")

// function avanceProcesoBanco(data){
//     if(data.procesoAnterior > data.procesoNuevo && data.tipoMovimiento == 1){
//         valor_avance = data.procesoAnterior // para identificar a que paso debe de avanzar viendo de que paso se rechazo
//     }

//     let form = new Form({
//         title: 'Avanzar proceso',
//         text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
//         onSubmit: function(data){
//             form.loading(true);

//             $.ajax({
//                 type: 'POST',
//                 url: `${general_base_url}casas/to_precierre_cifras`,
//                 data: data,
//                 contentType: false,
//                 processData: false,
//                 success : function(response){
//                     alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")

//                     table.reload()
//                     form.hide()        
//                 },
//                 error: function(){
//                     alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")

//                     form.loading(false)
//                 }
//             })

//         },
//         fields: [
//             new HiddenField({ id: 'idLote', value: data.idLote }),
//             new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
//             new HiddenField({ id: 'proceso', value: data.proceso }),
//             new HiddenField({ id: 'procesoNuevo', value: valor_avance }),
//             new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
//             new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
//         ],
//     })

//     form.show();
// }
let selectOption = null;
function rechazoProcesoBanco(data){
    let form = new Form({
        title: 'Rechazar proceso',
        text: `¿Deseas rechazar el proceso del lote ${data.nombreLote}?`,
        onSubmit: function(data){
            form.loading(true);
            if (selectOption == null || selectOption == 0) {
                alerts.showNotification("top", "right", "Debes seleccionar un modelo.", "warning");
                form.loading(false);
                return;
            }

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/creditoBancoAvance`,
                data: data,
                contentType: false,
                processData: false,
                success : function(response){
                    alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")
                    table.reload()
                    form.hide();
                    selectOption = null;        
                },
                error: function(){
                    alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")
                    form.loading(false);
                    selectOption = null;
                }
            })

        },
        fields: [
            new HiddenField({ id: 'idLote', value: data.idLote }),
            new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
            new HiddenField({ id: 'proceso', value: data.proceso }),
            new HiddenField({ id: 'procesoNuevo', value: 3 }),
            new HiddenField({ id: 'tipoMovimiento', value: data.tipoMovimiento }),
            new TextAreaField({   id: 'comentario', label: 'Comentario', width: '12' }),
        ],
    })

    form.show();
}

// function file_upload(data) {
//     let form = new Form({
//         title: 'Subir orden de compra firmada',
//         onSubmit: function(data){
//             form.loading(true)

//             $.ajax({
//                 type: 'POST',
//                 url: `${general_base_url}casas/uploadDocumentoCreditoBanco`,
//                 data: data,
//                 contentType: false,
//                 processData: false,
//                 success: function(response){
//                     alerts.showNotification("top", "right", "Se ha subido la orden de compra", "success");
                        
//                     table.reload()
//                     form.hide()
//                 },
//                 error: function(){
//                     alerts.showNotification("top", "right", "Ha ocurrido un error al enviar el archivo", "danger");

//                     form.loading(false);
//                 }
//             })
//         },
//         fields: [
//             new HiddenField({ id: 'idProcesoCasas', value: data.idProcesoCasas }),
//             new HiddenField({ id: 'proceso', value: data.proceso }),
//             new HiddenField({ id: 'tipoDocumento', value: data.tipo }),
//             new HiddenField({ id: 'id_documento', value: 29 }),
//             new HiddenField({ id: 'nombre_lote', value: data.nombreLote }),
//             new FileField({   id: 'file_uploaded',   label: 'Archivo', placeholder: 'Selecciona un archivo', accept: ['application/pdf'], required: true}),
//         ]
//     })

//     form.show()
// }

// go_to_documentos = function(data) {
//     window.location.href = `documentacionProveedor/${data.idProcesoCasas}`;
// }

go_to_documentos_cliente = function(data) {
    window.location.href = `documentacionCliente/${data.idProcesoCasas}`;
}

// function show_preview(data) {
//     let url = `${general_base_url}casas/archivo/${data.archivo}`

//     Shadowbox.init();

//     Shadowbox.open({
//         content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${url}"></iframe></div>`,
//         player: "html",
//         title: `Visualizando archivo: ${data.documento}`,
//         width: 985,
//         height: 660
//     });
// }

// function funcionRechazo(data){
//     formRegreso.modal("show")
//     datos = data
// }

// function seleccionOpcion(opcion){
//     if(opcion.value == 3){
//         opcionRegreso = opcion.value
//         $("#paso2").prop("checked", false);
//     }
//     else if(opcion.value == 2){
//         opcionRegreso = opcion.value
//         $("#paso3").prop("checked", false);
//     }
// }

// $("#rechazarForm").submit(function(e){
//     e.preventDefault()

//     let paso3 = document.getElementById("paso3")
//     let paso2 = document.getElementById("paso2")

//     let comentario = $("#comentarioRechazo").val()
//     if(comentario == null || comentario.trim() === ''){
//         comentario = 'Sin comentario'
//     }

//     let formData = new FormData();
//     formData.append("idLote", datos.idLote)
//     formData.append("idProcesoCasas", datos.idProcesoCasas)
//     formData.append("proceso", datos.proceso)
//     formData.append("procesoNuevo", opcionRegreso)
//     formData.append("tipoMovimiento",  datos.tipoMovimiento)
//     formData.append("nombreLote", datos.nombreLote)
//     formData.append("comentario", comentario)
    
//     if(!paso3.checked && !paso2.checked){
//         alerts.showNotification("top", "right", "Se debe seleccionar una opción para avanzar", "danger");   
//     }
//     else{
//         $.ajax({
//             type: 'POST',
//             url: `${general_base_url}casas/creditoBancoAvance`,
//             data: formData,
//             contentType: false,
//             processData: false,
//             success : function(response){
//                 alerts.showNotification("top", "right", "Se ha avanzado el proceso correctamente", "success")

//                 table.reload()
//                 formRegreso.modal("hide")        
//             },
//             error: function(){
//                 alerts.showNotification("top", "right", "Oops, algo salió mal", "danger")
//             }
//         })
//     }
// })

// $(".modal").on("hidden.bs.modal", function(){
//     $("#paso3").prop("checked", false);
//     $("#paso2").prop("checked", false);

//     opcionRegreso = 0
//     datos = ''
// });
let idCasaFinal = new HiddenField({id: 'idCasaFinal', value: selectOption});
function to_precierre_cifras(data) {
    let idRol = document.getElementById("idRol").value;

    if(idRol == 33) {
        selectCasa('#form-form-modal', 'custom-div-id', data.idPropuestaCasa);
    }
    

    let form = new Form({
        title: 'Avanzar proceso',
        text: `¿Deseas realizar el avance de proceso del lote <b>${data.nombreLote}</b>?`,
        onSubmit: function(data){
            form.loading(true);
            if (selectOption == null || selectOption == 0) {
                alerts.showNotification("top", "right", "Debes seleccionar un modelo.", "warning");
                form.loading(false);
                return;
            }            

            $.ajax({
                type: 'POST',
                url: `${general_base_url}casas/to_precierre_cifras`,
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
            new TextAreaField({ id: 'comentario', label: 'Comentario', width: '12' }),
            idCasaFinal,
            new HiddenField({ id: 'idCliente', value: data.id_cliente}),
        ],
    })

    form.show();
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
        let btn_avance = '';
        let btn_rechazo = new RowButton({icon: 'thumb_down', color: 'warning', label: 'Rechazar', onClick: rechazoProcesoBanco, data});
        // let subir_proveedor = new RowButton({icon: 'toc', color: '', label: 'Cargar documentos de proveedor', onClick: go_to_documentos, data});
        let subir_cliente = new RowButton({icon: 'toc', color: '', label: 'Cargar documentos de cliente', onClick: go_to_documentos_cliente, data});

        if(data.documentos === 9){
            btn_avance = new RowButton({icon: 'thumb_up', color: 'green', label: 'Avanzar', onClick: to_precierre_cifras, data})
        }

        return `<div class="d-flex justify-center">${btn_avance}${subir_cliente}${btn_rechazo}</div>`
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

$(".modal").on("hidden.bs.modal", function(){
    $("#paso3").prop("checked", false);
    $("#paso2").prop("checked", false);
    opcionRegreso = 0
    datos = '';
    selectOption = null;
    $('.custom-div-id').remove();
});



let table = new Table({
    id: '#tableDoct',
    url: 'casas/lista_orden_compra_firma',
    buttons,
    columns,
})



function selectCasa(parentSelector, divId, idPropuestaCasa) {
    $.post(`${general_base_url}/casas/modeloOptions`, { idModelo: idPropuestaCasa }, function(data) {
        
        const parent = document.querySelector(parentSelector);
        const existingDivs = parent.querySelectorAll(`.${divId}`);
        existingDivs.forEach(div => div.remove());

        const modalBody = parent.querySelector('.modal-body');

        data.forEach((item, index) => {
            const newDiv = document.createElement('div');
            newDiv.id = `${divId}-${index}`;
            newDiv.className = `${divId} element-select`; 
            
            newDiv.innerHTML = `
                <div id="checkDS" style="margin-bottom: 10px">
                    <div class="container boxChecks p-0">
                        <label class="m-0 checkstyleDS">
                            <input type="radio" name="idPropuesta" id="idPropuesta-${index}" value="${item.idModelo}">
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Modelo <b>${item.modelo}</b></p>
                            </span>
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">Superficie <b>${item.sup}</b></p>
                            </span>
                            <span class="w-100 d-flex justify-between">
                                <p class="m-0">COSTO M2 <b>${item.costoFinal}</b></p>
                            </span>
                        </label>
                    </div>
                </div>`;
            
            newDiv.addEventListener('change', function() {
                const selectedOption = modalBody.querySelector('input[name="idPropuesta"]:checked').value;    
                selectOption = selectedOption;
                idCasaFinal.set(selectOption)
            });
            modalBody.appendChild(newDiv);
        });
    }, 'json');
}
