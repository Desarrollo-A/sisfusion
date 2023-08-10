$(document).ready (function() {
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
        console.log('triggered');
    });

    $('#filtro3').change(function(){
        var valorSeleccionado = $(this).val();
        $("#filtro4").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'registroCliente/getCondominios/'+valorSeleccionado,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['idCondominio'];
                    var name = response[i]['nombre'];
                    $("#filtro4").append($('<option>').val(id).text(name));
                }
                $("#filtro4").selectpicker('refresh');
            }
        });
    });

    $('#filtro4').change(function(){
        var residencial = $('#filtro3').val();
        var valorSeleccionado = $(this).val();
        $("#filtro5").empty().selectpicker('refresh');
        $.ajax({
            url: general_base_url + 'registroCliente/getLotesJuridico/'+valorSeleccionado+'/'+residencial,
            type: 'post',
            dataType: 'json',
            success:function(response){
                var len = response.length;
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['idLote'];
                    var name = response[i]['nombreLote'];
                    $("#filtro5").append($('<option>').val(id).text(name));
                }
                $("#filtro5").selectpicker('refresh');
            }
        });
    });

    $('#filtro5').change(function(){
        var valorSeleccionado = $(this).val();
        console.log(valorSeleccionado);
        $('#tableDoct').DataTable({
            dom: 'rt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            ajax:
                {
                    "url": general_base_url + '/registroCliente/expedientesReplace/'+valorSeleccionado,
                    "dataSrc": ""
                },
            pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: general_base_url + "static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columns: [{
                "width": "8%",
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreResidencial+'</p>';
                }
            },
            {
                "width": "8%",
                "data": function( d ){
                    return '<p class="m-0">'+d.nombre+'</p>';
                }
            },
            {
                "width": "12%",
                "data": function( d ){
                    return '<p class="m-0">'+d.nombreLote+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p class="m-0">'+d.nomCliente +' ' +d.apellido_paterno+' '+d.apellido_materno+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p class="m-0">'+d.movimiento+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p class="m-0">'+d.modificado+'</p>';
                }
            },
            {
                "width": "10%",
                data: null,
                render: function ( data, type, row ){
                    let deletePermission = '';
                    let vdPermission = '';
                    if (data.expediente == null) {
                        vdPermission = '<button type="button" title= "Asociar a contrato" class="btn-data btn-sky addRemoveFile"  data-tableID="tableDoct" data-action="1" data-idLote="' + data.idLote + '" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-name="Contrato"><i class="fas fa-upload"></i></button>';
                    } else {
                        label = '';
                        vdPermission = '<button type="button" title= "Ver contrato" class="btn-data btn-orangeYellow addRemoveFile" data-action="3" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-file="' + data.expediente + '" data-name="Contrato"><i class="far fa-eye"></i></button>';
                        deletePermission = '<button type="button" title= "Eliminar contrato" class="btn-data btn-gray addRemoveFile" data-tableID="tableDoct" data-action="2" data-idLote="' + data.idLote + '" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-name="Contrato"><i class="fas fa-trash"></i></button>';
                    }
                    return '<div class="d-flex justify-center">'+vdPermission + deletePermission + '</div>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    return '<p class="m-0">'+ myFunctions.validateEmptyFieldDocs(d.primerNom) +' '+myFunctions.validateEmptyFieldDocs(d.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(d.apellidoMa)+'</p>';
                }
            },
            {
                "width": "10%",
                "data": function( d ){
                    var validaub = (d.ubic == null) ? '' : d.ubic;
                    return '<p class="m-0">'+ validaub +'</p>';
                }
            }]
        });

        $.post( general_base_url + "registroCliente/expedientesReplace/"+valorSeleccionado, function( data_json ) {
            var data = jQuery.parseJSON(data_json);
            if(data.length>0){
                $('#btnFilesGral').removeClass('hide');
                $('#btnFilesGral').attr('data-idLote', valorSeleccionado);
            }
            else
            {
                $('#btnFilesGral').addClass('hide');
                $('#btnFilesGral').attr('data-idLote', valorSeleccionado);
            }
        });
    });
});
