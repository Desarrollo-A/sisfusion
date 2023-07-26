$(document).ready(function() {
    getAsesores();
    getSedes();
    sp.initFormExtendedDatetimepickers();
    setIniDatesXMonth('#beginDate','#endDate');
    $(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
})

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

let titulos = [];
$('#clients-datatable thead tr:eq(0) th').each(function(i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
        $('input', this).on('keyup change', function() {
            if (prospectsTable.column(i).search() !== this.value) {
                prospectsTable.column(i).search(this.value).draw();
            }
        });
});

$(document).on('change', '#asesores', function(){
    fillTable();
    $('#clients-datatable').removeClass('hide');
})

function validateEmptyFields() {
    $("#btnSubmit").attr("onclick", "").unbind("click");
    for (i = 0; i < $("#tamanocer").val(); i++) {
        if ($('#expediente1')[0].files.length === 0) {
            alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
            $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
            return false;
        } else {
            $('#btnSubmitEnviar').click();
        }
    }
}

sp = { //  SELECT PICKER
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

function fillTable() {
    let asesor = $('#asesores').val();
    prospectsTable = $('#clients-datatable').DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            "class":          "details-control",
            "orderable":      false,
            "data":           null,
            "defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
        },
        {
            data: function(d) {
                return d.id_cliente;
            }
        },
        {
            data: function(d) {
                return d.nombre;
            }
        },
        {
            data: function(d) {
                return d.telefono1;
            }
        },
        {
            data: function(d) {
                return d.correo;
            }
        },
        {
            data: function(d) {
                return d.idLote;
            }
        },
        {
            data: function(d) {
                return d.nombreLote;
            }
        },
        {
            data: function(d) {
                return d.fechaApartado;
            }
        },
        {
            data: function(d) {
                return d.gerente;
            }
        },
        {
            data: function(d) {
                return d.nombre_lp;
            }
        },
        {
            data: function(d) {
                if(d.tipo_controversia == 1){
                    return '<span class="label lbl-green">Normal</span>';
                }
                else if(d.tipo_controversia == 2){
                    return '<span class="label lbl-yellow">Para descuento</span>';
                }
                else if(d.tipo_controversia == 3){
                    return '<span class="label lbl-azure">Venta nueva</span>';
                }
                else{
                    return 'NO APLICA';
                }
            }
        },
        {
            data: function(d) {
                if( d.lugar_prospeccion != 6 ){
                    if(d.tipo_controversia == '' || d.tipo_controversia == null){
                        return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas add_controversy" data-id-cliente="' + d.id_cliente + '" data-id-lote="' + d.idLote + '" data-nombre="' + d.nombreLote + '" data-toggle="tooltip"  data-placement="top" title="AÑADIR CONTROVERSIA"><i class="fas fa-comment-medical"></i></button></div>';
                    }
                    else{
                        return '<div class="d-flex justify-center"><button class="btn-data btn-green add_evidence" data-id-cliente="' + d.id_cliente + '" data-id-lote="' + d.idLote + '" data-nombre="' + d.nombreLote + '" data-toggle="tooltip"  data-placement="top" title="SUBIR EVIDENCIA"><i class="fas fa-cloud-upload-alt"></i></button></div>';
                    }
                }
                else{
                    return '';
                }
            }
        }],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            url: 'getClientsByAsesor',
            type: "POST",
            cache: false,
            data: {
                "asesor": asesor
            }
        }
    });

    $(document).on('click', '.add_controversy', function(e) {
        var id_cliente = $(this).attr("data-id-cliente");
        var id_lote = $(this).attr("data-id-lote");
        var nombreLote = $(this).attr("data-nombre");
        $("#loteName").text(nombreLote);
        $("#idLote").val(id_lote);
        $("#idCliente").val(id_cliente);
        $("#controversy").val('');
        $("#modalConfirmRequest").modal();
    });

    $(document).on('click', '.add_evidence', function () {
        var id_cliente = $(this).attr("data-id-cliente");
        var id_lote = $(this).attr("data-id-lote");
        var nombreLote = $(this).attr("data-nombre");
        $('#idClienteEv').val(id_cliente);
        $('#idLoteEv').val(id_lote);
        $('#nombreLoteEv').val(nombreLote);
        $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
        $('#solicitarAutorizacion').modal();
    });

    $("#sendControversy").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'setControversy',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                // Actions before send post
                $('#spiner-loader').removeClass('hide');
            },
            success: function(data) {
                $('#spiner-loader').addClass('hide');
                response = JSON.parse(data);
                if(response.resultado){
                    $("#modalConfirmRequest").modal('toggle');
                    alerts.showNotification('top', 'right', 'Se ha realizado el registro exitosamente.', 'success');
                    $('#clients-datatable').DataTable().ajax.reload();
                }
                else{
                    alerts.showNotification('top', 'right', 'El lote ya ha sido registrado.', 'warning');
                }
            },
            error: function() {
                $('#spiner-loader').addClass('hide');
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    });

    $("#subir_evidencia_form").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'addEvidenceToCobranza',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#btnSubmit').attr("disabled", "disabled");
                $('#btnSubmit').css("opacity", ".5");
                $("#btnSubmit").attr("onclick", "").unbind("click");
            },
            success: function (data) {
                if (data == 1) {
                    $('#btnSubmit').removeAttr("disabled");
                    $('#btnSubmit').css("opacity", "1");
                    $('#solicitarAutorizacion').modal("hide");
                    $('#subir_evidencia_form').trigger("reset");
                    $('#clients-datatable').DataTable().ajax.reload();
                    alerts.showNotification('top', 'right', 'Se enviaron las autorizaciones correctamente', 'success');
                } else {
                    $('#btnSubmit').removeAttr("disabled");
                    $('#btnSubmit').css("opacity", "1");
                    alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
                    $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
                }
            },
            error: function () {
                $('#btnSubmit').removeAttr("disabled");
                $('#btnSubmit').css("opacity", "1");
                $("#btnSubmit").attr("onclick", "return validateEmptyFields()");
                alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
            }
        });
    });
    
    var detailRows = [];
    prospectsTable.on( 'click', 'tr td.details-control', function () {
        console.log('priemro');
        var tr = $(this).closest('tr');
        var row = prospectsTable.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
        let check = [];
        let beginDate = $("#beginDate").val();
        let endDate = $("#endDate").val();
        let sede = $("#sedess").val();
        var isChecked = document.getElementById("sedes").checked;
        if(($('input[name="checks"]:checked').length > 0 )){
            $('input[name="checks"]:checked').each(function() {
                check.push({
                    key: this.className,
                    value: this.value
                });
            });
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
                detailRows.splice( idx, 1 );
                console.log('Hola');
            }
            if(isChecked &&  $("#sedess").val()=='' ){
            alerts.showNotification('top', 'right', 'Debes seleccionar una sede', 'warning');
            $('#spiner-loader').addClass('hide');
            return false;
            }
            else {
                console.log('bye');
                $('#spiner-loader').removeClass('hide');
                $.post("getDetails",{
                    id: row.data().id_cliente,
                    checks: check,
                    beginDate: beginDate,
                    endDate: endDate,
                    sede: sede
                }).done(function (data) {
                    $('#spiner-loader').addClass('hide');
                    row.data().solicitudes = JSON.parse(data);
                    prospectsTable.row(tr).data(row.data());
                    row = prospectsTable.row(tr);
                    row.child(buildTableDetail(row.data().solicitudes)).show();
                    $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
                });
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        }
        else{
            $("#empty").modal();
        }
    });
    // On each draw, loop over the `detailRows` array and show any child rows
    prospectsTable.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    });

};

function format ( d ) {
    return 'Full name: '+d.first_name+' '+d.last_name+'<br>'+
        'Salary: '+d.salary+'<br>'+
        'The child row can contain any data you wish, including links, images, inner tables etc.';
}

function buildTableDetail(data) {
    var solicitudes = '<table class="table detailTable subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'NOMBRE ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'TELÉFONO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'CORREO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'LUGAR DE PROSPECCION ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA DE ALTA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ASESOR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'GERENTE ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(data, function (i, v) {
        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i+1) + ' </td>';
        solicitudes += '<td> ' + v.nombre + ' </td>';
        solicitudes += '<td> ' + v.telefono + ' </td>';
        solicitudes += '<td> ' + v.correo + ' </td>';
        solicitudes += '<td> ' + v.namePros + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion.split('.')[0] + ' </td>';
        solicitudes += '<td> ' + v.nombreAsesor + ' </td>';
        solicitudes += '<td> ' + v.nombreGerente + ' </td>';
        solicitudes += '</tr>';

    });
    return solicitudes += '</table>';
}

function getAsesores() {
    $("#asesores").find("option").remove();
    $.post('getAsesores', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#asesores").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#asesores").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#asesores").selectpicker('refresh');
    }, 'json');
}

function getSedes(){
    $("#sedess").find("option").remove();
    $.post('getSedes', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id_sede = data[i]['id_sede'];
            var nombre = data[i]['nombre'];
            $("#sedess").append($('<option>').val(id_sede).text(nombre.toUpperCase()));
        }
        if (len <= 0) {
            $("#sedess").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#sedess").selectpicker('refresh');
    }, 'json');
}

function toggleSelect1(){
    var isChecked = document.getElementById("sedes").checked;
    if(isChecked){
        console.log('Se activan las sedes');
        $("#sedess").attr('disabled',false);
        $(".selectpicker[data-id='sedess']").removeClass("disabled");
        $(".dropdown-toggle[data-id='sedess']").removeClass("disabled");
    }
    else{
        console.log('Se desactivan las sedes');
        $("#sedess").attr('disabled',true);
        $(".selectpicker[data-id='sedess']").addClass("disabled");
        $(".dropdown-toggle[data-id='sedess']").addClass("disabled");
    }
}

function toggleSelect2(){
    var isChecked = document.getElementById("date").checked;
    (isChecked) ? $(".datepicker").prop("disabled", false) :  $(".datepicker").prop("disabled", true);
}
