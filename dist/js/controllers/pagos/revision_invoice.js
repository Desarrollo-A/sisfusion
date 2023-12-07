var tr;
var tabla_invoice ;
var totaPago = 0;
let titulosInvoice = [];

$(document).ready(function() {
    getDataInvoice();
});


$('#tabla_invoice thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        titulosInvoice.push(title);
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $( 'input', this ).on('keyup change', function () {
            if ($('#tabla_invoice').DataTable().column(i).search() !== this.value ) {
                $('#tabla_invoice').DataTable().column(i).search(this.value).draw();
            }
        });
});


function getDataInvoice(){
    
    $('#tabla_invoice').on('xhr.dt', function(e, settings, json, xhr) {
        var total = 0;
        $.each(json.data, function(i, v) {
            total += parseFloat(v.impuesto);
        });
        var to = formatMoney(numberTwoDecimal(total));
        document.getElementById("disponibleInvoice").textContent = to;
    });
    

    $("#tabla_invoice").prop("hidden", false);
    tabla_invoice = $("#tabla_invoice").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Comprobantes Fiscales Invoice - Revisión Contraloría',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInvoice[columnIdx -1] + ' ';
                        }
                    }
                },
            }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url+"/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function(d) {
                return `<p class="m-0"><b>${d.id_usuario}</b></p>`;
            }
        },
        {
            data: function(d) {
                return `<p class="m-0">${d.usuario}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${formatMoney(numberTwoDecimal(d.total))}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${d.forma_pago}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${d.nacionalidad}</p>`;
            }
        },
        {
            data: function (d) {
                return `<p class="m-0">${d.estatus_usuario}</p>`;
            }
        },
        {
            data: function (d) {
                return `
                    <div class="d-flex justify-center">
                        <button data-usuario="${d.archivo_name}"
                            class="btn-data btn-warning consultar-archivo"
                            title="VER ARCHIVO">
                                <i class="fas fa-file-pdf-o"></i>
                        </button>
                    </div>`;
            }
        }],
        ajax: {
            "url": general_base_url+"Pagos/getComprobantesExtranjero",
            "type": "GET",
            data: function(d) {}
        },
    });

    $('#tabla_invoice').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });


    $('#tabla_invoice tbody').on('click', '.consultar-archivo', function () {
        const $itself = $(this);
        Shadowbox.open({
            content: `
                <div>
                    <iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" 
                        src="${general_base_url}static/documentos/extranjero/${$itself.attr('data-usuario')}">
                    </iframe>
                </div>`,
            player: "html",
            title: "Visualizando documento fiscal: " + $itself.attr('data-usuario'),
            width: 985,
            height: 660
        });
    });

}

$(window).resize(function(){
    tabla_invoice.columns.adjust();
});