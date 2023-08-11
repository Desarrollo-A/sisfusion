let titulosEvidence = [];

$('#Jtabla thead tr:eq(0) th').each(function (i) {
    let title = $(this).text();
    titulosEvidence.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this).on('keyup change', function () {
        if ($('#Jtabla').DataTable().column(i).search() !== this.value) {
            $('#Jtabla').DataTable().column(i).search(this.value).draw();
        }   
    });
});

$(document).ready(function(){
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
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

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
});

    function fillTable(typeTransaction, beginDate, endDate, where) {
        
        $('#Jtabla').dataTable({
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            scrollX: true,
            bAutoWidth: true,
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                filename:'Contratos Recibidos',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosEvidence[columnIdx] + ' ';
                        }
                    }
                }
            }],
            pagingType: "full_numbers",
            fixedHeader: true,
            language: {
                url: general_base_url + '/static/spanishLoader_v2.json',
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            destroy: true,
            ordering: false,
            columnDefs: [{
                defaultContent: "-",
                targets: "_all"
            }],
            columns: [{
                data: function (d) {
                    return d.nombreLote;
                }
            },
            {
                data: function (d){
                    var ge1;
                    if(d.gerente == undefined){ge1="";}else{ge1=d.gerente;};
                    return ge1;
                }
            },
            {
                data: function (d){
                    var as1;
                    if(d.asesor == undefined){as1="";}else{as1=d.asesor};
                    return as1 ;
                }
            },
            {
                data: function (d){
                    var status;
                    if(d.idStatusContratacion==9){
                        status="9. CONTRATO RECIBIDO CON FIRMA DE CLIENTE (CONTRALORÍA) ";
                    }
                    else{
                        status="STATUS NO DEFINIDO [303]";
                    }
                    return status;
                }
            },
            {
                data: function (d){
                    var details;
                    if(d.idStatusContratacion==9 && d.idMovimiento==39){details="STATUS 9 LISTO (CONTRALORÍA)    ";}
                    return details;
                }
            },
            {
                data: function (d) {
                    return d.comentario;
                }
            },
            {
                data:function(d){
                    return "$"+alerts.number_format(d.totalNeto2, 2, ".", ",")
                }
            },
            {
                data:function(d){
                    return "$"+alerts.number_format(d.totalValidado, 2, ".", ",")
                }
            },
            {
                data: function (d) {
                    return d.modificado;
                }
            }],
            ajax:{
                url: general_base_url +'index.php/registroLote/getHistProcData',
                type: "POST",
                cache: false,
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where
                }
            },
        });
    }

    $('#Jtabla').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });

