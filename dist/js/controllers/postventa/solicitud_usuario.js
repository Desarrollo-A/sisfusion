$('#table-user thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    if (i !== 10) {
        $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#table-user').DataTable().column(i).search() !== this.value ) {
                $('#table-user').DataTable().column(i).search(this.value).draw();
            }
        });
    }
   
});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

sp2 = { // CHRIS: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker2').datetimepicker({
            format: 'DD/MM/YYYY LT',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            },
            minDate:new Date(),
        });
    }
}
 
$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    sp2.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    getEstatusEscrituracion();
    setInitialValues();
    fillTable();

    // $('#table-user thead tr:eq(0) th').each(function (i) {
    //     if (i !== 10) {
    //         const title = $(this).text();
    //         titulosTablaGeneral.push(title);
 
    //         $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    //         $('input', this).on('keyup change', function () {
    //             if (tablaGeneral.column(i).search() !== this.value) {
    //                 tablaGeneral.column(i).search(this.value).draw();

    //                 let totalDescuento = 0;
    //                 const index = tablaGeneral.rows({selected: true, search: 'applied'}).indexes();
    //                 const data = tablaGeneral.rows(index).data();

                

                
    //             }
    //         });
    //     }
    // })





    $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    getRejectionReasons(2); // MJ: SE MANDAN TRAER LOS MOTIVOS DE RECHAZO PARA EL ÁRBOL DE DOCUMENTOS DE ESCRUTURACIÓN

}); 
 

//funciones
function fillTable(id) {
    console.log(id);
    if(id == ''){
        id = ''
    }
    prospectsTable = $('#table-user').DataTable({
        dom: 'rt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 10,
        bAutoWidth: false,
        fixedColumns: true,
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return d.id_solicitud
                }
            },
            {
                data: function (d) {
                    return d.nombreResidencial
                }
            },
            {
                data: function (d) {
                    return d.nombreCondominio
                }
            },
            {
                data: function (d) {
                    return d.nombreLote
                }
            },
            {
                data: function (d) {
                    return d.cliente
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion
                }
            },
            {
                data: function (d) {
                    return d.nombre
                }
            },
            {
                data: function (d) {
                    return d.actividad
                }
            },
            {
                data: function (d) {
                    return d.nombre_estatus
                }
            },
            {
                data: function (d) {
                    return d.area
                }
            },
            {
                data: function (d) {
                    return `<center> <button value="${d.id_solicitud}" 
                                            data-code="${d.id_solicitud}" 
                                            data-nombre=" ${d.cliente}"
                                            data-nombreTitu="${d.nombre}"
                                            data-idTitu="${d.id_titulacion}"
                                            data-lote="${d.nombreLote}"
                                             name="repartir" 
                                            id="repartir" data-type="5"
                                             class="btn-data btn-green" 
                                             data-toggle="tooltip" 
                                             data-placement="top" 
                                             title="Aprobar">
                                             <i class="fa fa-share"></i></button>
                                              <center>`;
                }
            }
            
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },
        // {
        //     "targets": [ 10 ],
        //     "visible": false
        // }
        ],
        ajax: {
            url: 'SolicitudesEscrituracion',
            type: "POST",
            cache: false,
            data: {
                "id_usuario": id,
            
            }
        }

    });
};
 
function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);

   
}

function getEstatusEscrituracion(){
    $('#spiner-loader').removeClass('hide');
    $("#estatusE").find("option").remove();
    $("#estatusE").append($('<option selected>').val("0").text("Propios"));
    $("#estatusE").append($('<option>').val("1").text("Todos"));
    $("#estatusE").selectpicker('refresh');
    $('#spiner-loader').addClass('hide');
 
}


$(document).on('click', '#repartir', function () {

    $('#modal_nuevas').modal('show');
    solicitud = $(this).attr("data-code");
    nombreTitular = $(this).attr("data-nombreTitu");
    idTitular = $(this).attr("data-idTitu");

    document.getElementById("id_actual").value =  idTitular;
    document.getElementById("solicitud").value =  solicitud;

    console.log(solicitud);
    var Descripcion = document.getElementById('textDescripcion');
    Descripcion.innerHTML = ' ';
    var titulo  = ' ';
    titulo += '  <h5 id="tituloModalUni" name="tituloModalUni">Reasignación solicitud : '+ solicitud  +'</h5>';
    var anterior = document.getElementById('anteriorTitu');
    anterior.innerHTML = ' '  ;
    anterior.innerHTML =   nombreTitular  ;

    var Descripcion = document.getElementById('textDescripcion');
    var comentarioDescrip = document.getElementById('textDescripcion');
    var texto = ' ';
    comentarioDescrip.innerHTML = ' ID :'+idTitular +'   Nombre: '+ nombreTitular   ;

    var myCommentsLote = document.getElementById('tituloModal');
    myCommentsLote.innerHTML = ' ';
    myCommentsLote.innerHTML = titulo;
    // var Header_modal = document.getElementById('header_modal');
    // Header_modal.innerHTML = titulo;


});

    $(document).on("click", ".updateTitu", function () {
        titulares  = document.getElementById("titulares").value;
        idTitular  =   document.getElementById("id_actual").value ;
        solicitud  = document.getElementById("solicitud").value ;
        var validacion = false;
        if(titulares == idTitular){
            validacion = false;
            console.log('son iguales');
        }else{
            validacion = true;
            console.log('son diferentes');
        }
        if(validacion){
            $.ajax({
                url : 'descuentoUpdateTi',
                type : 'POST',
                dataType: "json",
                data: {
                // "pagos_activos"     : pagos_activos,
                "id_solicitud" : solicitud,
                "titulares" : titulares, //nuevo 
                "idTitular": idTitular,         //viejo  
                  }, 
                  success: function(data) {
           
                    alerts.showNotification("top", "right", ""+data.message+"", ""+data.response_type+"");
                   
                    $('#table-user').DataTable().ajax.reload(null, false );
                    
                    // toastr[response.response_type](response.message);
                    $('#modal_nuevas').modal('toggle');
                },              
                error : (a, b, c) => {
                    alerts.showNotification("top", "right", "Error al actualizar No actualizado .", "error");
                }
                });
        }else{
            alerts.showNotification("top", "right", "No puedes asignar a la misma persona la actividad .", "error");
        }
    });

    $(document).on("click", ".aportaciones", function () {

        claveusu  = document.getElementById("claveusu").value;
        
        if(claveusu == '' ){
            alerts.showNotification("top", "right", "Por favor escribe la clave del usuario.", "error");
        }else {
            fillTable(claveusu);
        }



    });



 