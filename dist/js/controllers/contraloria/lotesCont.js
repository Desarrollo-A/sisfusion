let titulos = [];
$('#loteCont thead tr:eq(0) th').each( function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($("#loteCont").DataTable().column(i).search() !== this.value) {
            $("#loteCont").DataTable().column(i).search(this.value).draw();
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
})

$("#loteCont").ready(function () {
    $("#loteCont").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [ 
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: "Lotes Apartados",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            },
        ],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        
        pageLength: 11,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [ 
            {
                data: function(d){
                    return d.nombreResidencial;
                }
            },
            {
                data: function(d){
                    return d.nombre;
                }
            },
            {
                data: function (d) {
                    return d.idLote.toString(); 
                }
            },
            {
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d) {
                    return d.idCliente == 0 || d.idCliente == null ? 'Sin Cliente' : d.nombreCliente;
                }
            },
            {
                data: function (d) {
                    if (d.dias_transcurridos >= 45){
                        return  '<span class="label lbl-warning"> más de 45 días </span>'
                    }if(d.dias_transcurridos >= 15 && d.dias_transcurridos <= 44){
                        return  '<span class="label lbl-yellow"> más de 15 días </span>' 
                    }
                }
            },
            {
                data: function (d) { 
                    if(d.prorroga == 1){
                        return '<span class="label lbl-green"> Aceptada </span>' 
                    }if(d.prorroga == 2){
                        return '<span class="label lbl-warning"> Rechazada </span>' 
                    }else{
                        return  '<span class="label lbl-gray"> Sin definir </span>' 
                    }
                }
            },
            {
                data: function (d) {
                    
                    if(d.idStatusLote == 1){
                        return '<span class= "label lbl-violetBoots">Disponible en contraloría</span>';
                    }else{
                        btns = '<div class="d-flex justify-center">';
                        if(d.dias_transcurridos >= 0 && d.dias_transcurridos <= 15 && id_rol_general == 6){ 
                            btns += `<button type="button"  class="btn-data btn-green" data_toggle="tooltip" data-placement="left" title="ACEPTAR PRÓRROGA" onclick="fillModal(1, ${d.dias_transcurridos}, ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-check"></i></button>`
                            
                            btns += `<button type="button"  class="btn-data btn-warning" data_toggle="tooltip" data-placement="left" title="RECHAZAR PRÓRROGA" onclick="fillModal(2, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-times"></i></button>`
                        }
                        else if(d.dias_transcurridos >= 16 && d.dias_transcurridos <= 30 && id_rol_general == 2){
                            btns += `<button type="button"  class="btn-data btn-green" data_toggle="tooltip" data-placement="left" title="ACEPTAR PRÓRROGA" onclick="fillModal(1, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-check"></i></button>`
                            
                            btns += `<button type="button"  class="btn-data btn-warning" data_toggle="tooltip" data-placement="left" title="RECHAZAR PRÓRROGA" onclick="fillModal(2, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-times"></i></button>`
                        }
                        else if(d.dias_transcurridos >= 31 && d.dias_transcurridos <= 45 && id_rol_general == 2 ){ 
                            btns += `<button type="button"    class="btn-data btn-green" data_toggle="tooltip" data-placement="left" title="ACEPTAR PRÓRROGA" onclick="fillModal(1, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-check"></i></button>`
                            
                            btns += `<button type="button"    class="btn-data btn-warning" data_toggle="tooltip" data-placement="left" title="RECHAZAR PRÓRROGA" onclick="fillModal(2, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-times"></i></button>`
                        }
                        else if(d.dias_transcurridos >= 46 && id_rol_general == 1){  
                            btns += `<button type="button"   class="btn-data btn-green" data_toggle="tooltip" data-placement="left" title="ACEPTAR PRÓRROGA" onclick="fillModal(1, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-check"></i></button>`
                            
                            btns += `<button type="button"   class="btn-data btn-warning" data_toggle="tooltip" data-placement="left" title="RECHAZAR PRÓRROGA" onclick="fillModal(2, ${d.dias_transcurridos},  ${d.idLote}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.prorroga})"><i class="fas fa-times"></i></button>`
                        }
                        btns += '</div>'
                        return btns;
                    }
                }
            },
        ],
        ajax: {
            url: "get_lotes_contratados", 
            type: "POST",
            cache: false,
            data: function (d) {}
        }, 
    });
    $('#loteCont').removeClass('hide');
});

$('#loteCont').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$("#acceptModalButton").click(function(){
    let idLote = $('#idLote').val();
    let prorroga = $('#prorroga').val();

    $.ajax({
        url:general_base_url + 'Contraloria/actualiza_lotes_apartados',
        type: 'POST',
        data: {
            "idLote": idLot,
            "isProrroga": isProrroga
        },
        dataType: 'JSON',
        success: function(data){
            data= JSON.parse(data);

            if(data == true){
                alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                $("#loteCont").DataTable().ajax.reload();
                closeModal();

            }else{
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', jqXHR.status, errorThrown);
        },
        catch: function (c) {
            console.log('catch:', c);
        },
    });
});

var isProrroga;
var idLot;
function fillModal(prorroga1, dias_transcurridos, idLote, idCondominio, idProyecto, nombreLote, prorroga) {
    let modalTitle = document.getElementById("modal-title");
    let modalContent = document.getElementById("contenido");
    isProrroga = prorroga1;
 
    $('#idlote').val(idLote);
    idLot = $('#idlote').val();

    $('#dias_transcurridos').val(dias_transcurridos);
    $('#idCondominio').val(idCondominio);
    $('#idProyecto').val(idProyecto);
    $('#nombreLote').val(nombreLote);
    $('#prorroga').val(prorroga);
 
    if (isProrroga == 1)
    {
        modalTitle.innerHTML = "<div>¿Desea aceptar la prórroga para el lote <b>"+nombreLote+"</b></div>";
        modalContent.innerHTML = 
        "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: center; border-radius: 10px; background-color: #eaeaea;'>"+ 
            "<p style='border-bottom: 3px solid #ffffff; margin-top: 10px; margin-bottom: 10px; margin-left: -15px; margin-right: -15px'><b>LOTE SELECCIONADO</b></p>"+
            "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'><p class='m-0'><b>ID</b></p><p>"+idLote+"</p></div>"+
            "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'><p class='m-0'><b>NOMBRE</b></p><p>"+nombreLote+"</p></div>"+
            "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'><p class='m-0'><b>DÍAS HÁBILES</b></p><p>"+dias_transcurridos+"</p></div>"+
        "</div>";

        $('#modalGeneral').modal('show');

    } else if(isProrroga == 2){
        modalTitle.innerHTML = "<div>¿Desea rechazar la prórroga para el lote <b>"+nombreLote+"</b></div>";
        modalContent.innerHTML = 
        "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='text-align: center; border-radius: 10px; background-color: #eaeaea;'>"+ 
        "<p style='border-bottom: 3px solid #ffffff; margin-top: 10px; margin-bottom: 10px; margin-left: -15px; margin-right: -15px'><b>LOTE SELECCIONADO</b></p>"+
        "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'><p class='m-0'><b>ID</b></p><p>"+idLote+"</p></div>"+
        "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'><p class='m-0'><b>NOMBRE</b></p><p>"+nombreLote+"</p></div>"+
        "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'><p class='m-0'><b>DÍAS HÁBILES</b></p><p>"+dias_transcurridos+"</p></div>"+
    "</div>";

        $('#modalGeneral').modal('show');
    }
}

function closeModal() {
    $('#modal-title').text('');
    $('#modal-content').text('');
    $('#dias_transcurridos').val('');
    $('#idlote').val('');
    $('#modalGeneral').modal('hide');
    $('#editarModal').modal("hide");
    $('#idLote').val('')
    $('#idCondominio').val('');
    $('#idProyecto').val('');
    $('#nombreLote').val('');
    $('#prorroga').val('');
}