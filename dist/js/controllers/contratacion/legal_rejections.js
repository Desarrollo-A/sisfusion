$("#Jtabla").ready( function(){
    
    construirHead("Jtabla");
    
    tabla_6 = $("#Jtabla").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        bAutoWidth: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: `${_('descargar-excel')}`,
            title: _("rechazo-juridico"),
            exportOptions: {
                columns: [1,2,3,4,5,6],
                format: {
                    header: function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
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
            "width": "3%",
            "className": 'details-control',
            "orderable": false,
            "data" : null,
            "defaultContent": '<div class="d-flex justify-center"><div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i></div></div>'
        },
        {
            "data": function( d ){
                var lblStats = `<span class="label label-danger">${_("rechazo")}</span>`;
                return lblStats;
            }
        },
        {
            "width": "10%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreResidencial+'</p>';
            }
        },
        {
            "width": "10%",
            "data": function( d ){
                return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
            }
        },
        {
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0">'+d.nombreLote+'</p>';
            }
        },
        {
            "width": "20%",
            "data": function( d ){
                return '<p class="m-0">'+d.gerente+'</p>';
            }
        },
        {
            "width": "20%",
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
        "order": [[ 1, 'asc' ]],
        initComplete: function() {
            onLoadTranslations(function(){
                $('body').i18n()
            })
            
        },
    });

    applySearch(tabla_6);

    $('#Jtabla tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tabla_6.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } 
        else {
            var status = `<span data-i18n="rechazo-juridico-2"> ${_("rechazo-juridico-2")}</span>`;
            var fechaVenc = `<span data-i18n="vencido"> ${_("vencido")}</span>`;
            var informacion_adicional = `<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b data-i18n="informacion-adicional">${_("informacion-adicional")}</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b data-i18n="estatus-2">${_("estatus-2")}</b>: ${status}</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b data-i18n="comentario">${_("comentario")}</b>: ${row.data().comentario}</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b data-i18n="fecha-vencimiento-2">${_("fecha-vencimiento-2")}</b>: ${fechaVenc}</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b data-i18n="fecha-realizado">${_("fecha-realizado")}</b>: ${row.data().modificado}</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b data-i18n="coordinador">${_("coordinador")}</b>: ${row.data().coordinador}</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b data-i18n="asesor">${_("asesor")}</b>: ${row.data().asesor}</label></div></div></div>`;
            row.child(informacion_adicional).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
        }
    });
});