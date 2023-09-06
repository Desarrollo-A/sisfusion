let titulos_intxt = [];

$("#Jtabla").ready( function(){
    $('#Jtabla thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos_intxt.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if (tabla_6.column(i).search() !== this.value ) {
                tabla_6.column(i).search(this.value).draw();
            }
        });
    });

    tabla_6 = $("#Jtabla").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'Rechazos Jurídico',
            exportOptions: {
                columns: [1,2,3,4,5,6],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
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
            "className": 'details-control',
            "orderable": false,
            "data" : null,
            "defaultContent": '<div class="d-flex justify-center"><div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i></div></div>'
        },
        {
            "data": function( d ){
                var lblStats = '<span class="label lbl-warning">Rechazo</span>';
                return lblStats;
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreResidencial+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.gerente+'</p>';
            }
        },
        {
            "data": function( d ){
                return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
            }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            "url": general_base_url + 'Asistente_gerente/getLegalRejections',
            "dataSrc": "",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
        "order": [[ 1, 'asc' ]]
    });

    $('#Jtabla tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_6.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } 
        else {
            var status = 'RECHAZO (JURÍDICO)';
            var fechaVenc = 'VENCIDO';
            var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información adicional</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>'+status+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>'+ row.data().comentario +'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha de vencimiento: </b>' + fechaVenc + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha de realizado: </b>' + row.data().modificado.split('.')[0] + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>'+row.data().coordinador+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>'+row.data().asesor+'</label></div></div></div>';
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });
});