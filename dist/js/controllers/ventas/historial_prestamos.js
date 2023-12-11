let titulos = [];
let prestamosTabla;

$("#prestamos-table").prop('hidden', true);
$('#mes').change(function(ruta){
    anio = $('#anio').val();
    mes = $('#mes').val();
    
    if(mes == '' || anio == ''){
    }else{
        createPrestamosDataTable(mes, anio);
    }
});

$('#anio').change(function(ruta) {
    anio = $('#anio').val();
    mes = $('#mes').val();
    console.log(anio);
    if(anio == '' || mes == ''){
    }else{
        createPrestamosDataTable(mes, anio);
    }
    
});

$('#prestamos-table thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);

    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {

        if (prestamosTabla.column(i).search() !== this.value) {
            prestamosTabla.column(i).search(this.value).draw();
            var total = 0;
                var index = prestamosTabla.rows({ selected: true, search: 'applied' }).indexes();
                var data = prestamosTabla.rows( index ).data();
                $.each(data, function(i, v){
                    total += parseFloat(v.abono_neodata);
                });
                document.getElementById('total-pago').textContent = formatMoney(total);
        }
    });
});

function createPrestamosDataTable(mes, anio) {

    if (prestamosTabla) {
        prestamosTabla.clear();
        prestamosTabla.destroy();
        $('#prestamos-table tbody').empty();
    }

    $("#prestamos-table").prop('hidden', false);
    $('#prestamos-table').on('xhr.dt', function (e, settings, json) {
        let total = 0;
        
        $.each(json.data, function(i, v) {
            total += parseFloat(v.abono_neodata);
        });
        document.getElementById('total-pago').textContent = formatMoney(total);
    });

    prestamosTabla = $('#prestamos-table').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10,11],
                format: {
                    header:  function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + `/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            'data': function( d ){
                return '<p class="m-0">'+d.id_pago_i+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+d.id_prestamo+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+d.nombre_completo+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+d.puesto+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+formatMoney(d.monto_prestado)+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+formatMoney(d.abono_neodata)+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+formatMoney(d.pendiente)+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+formatMoney(d.pago_individual)+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+d.fecha_creacion+'</p>';
            }
        },
        {
            'data': function( d ){
                return '<p class="m-0">'+d.comentario+'</p>';
            }
        },
        {
            'data': function(d) {
                return '<span class="label lbl-green">PAGADO</span>';
            }
        },
        {
            'data': function(d) {

            if(d.id_opcion == 18){
                objeto='class="label lbl-green"';
            } else if(d.id_opcion == 19){ 
                objeto='class="label lbl-azure"';
            }else if(d.id_opcion == 20){ 
                objeto='class="label lbl-blueMaderas"';
            }else if(d.id_opcion == 21){ 
                objeto='class="label lbl-blueMaderas"';
            }else if(d.id_opcion == 22){ 
                objeto='class="label lbl-violetBoots"';
            }else if(d.id_opcion == 23){ 
                objeto='class="label lbl-violetBoots"';
            }else if(d.id_opcion == 24){
                objeto='class="label lbl-brown"';
            }else if(d.id_opcion == 25){ 
                objeto='class="label lbl-green"';
            }else if(d.id_opcion == 26){ 
                objeto='class="label lbl-azure"';
            }
            return '<p><span '+objeto+'>'+d.tipo+'</span></p>';
            }
        },
        {
            'orderable': false,
            'data': function( d ) {
                let btns = '';

                const BTN_HISRESS = `<button class="btn-data btn-blueMaderas consulta-historial" value="${d.id_relacion_pp}" title="Historial"><i class="fas fa-info"></i></button>`;
                btns += BTN_HISRESS;

                return `<div class="d-flex justify-center">${btns}</div>`;
            }
        }],
        columnDefs: [],
        ajax: {
            url: general_base_url + `Comisiones/getPrestamosTable/${mes}/${anio}`,
            type: "GET",
            cache: false,
            data: function( d ){}
        },
    });

    $('#prestamos-table').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    });

    $("#prestamos-table tbody").on("click", ".consulta-historial", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        const idRelacion = $(this).val();

        changeSizeModal("modal-md");
        appendBodyModal(`<div class="modal-body">
            <div role="tabpanel">
                <ul class="nav" role="tablist">
                    <div id="nombreLote"></div>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="changelogTab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-plain">
                                    <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                        <ul class="timeline-3" id="comentariosAsimilados"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
        </div>`);
        showModal();

        $("#nombreLote").append('<p><h5>HISTORIAL DEL PAGO</h5></p>');
        $.getJSON(general_base_url + `Comisiones/getHistorialPrestamoAut/${idRelacion}`).done( function( data ){
            $.each( data, function(i, v){
                $("#comentariosAsimilados").append('<li><div class="container-fluid"><div class="row"><div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><a><b>' + v.nombre_usuario + '</b></a><br></div> <div class="float-end text-right"><a>' + v.fecha + '</a></div><div class="col-md-12"><p class="m-0"><b> ' + v.comentario + '</b></p></div></div></div></li>');
            });
        });
    });
}