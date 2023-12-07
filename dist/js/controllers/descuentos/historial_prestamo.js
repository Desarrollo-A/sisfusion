
let prestamosTabla;
$(document).ready(function () {
  
    });

$("#prestamos-table").prop('hidden', true);

// $('#roles').change(function () {
//     const rol = $(this).val();
//     // $("#users").empty().selectpicker('refresh');

//     $.ajax({
//         url: `${general_base_url}Comisiones/getUserPrestamoByRol/${rol}`,
//         type: 'GET',
//         dataType: 'json',
//         success: function (data) {
//             const len = data.length;
//             for(let i = 0; i < len; i++){
//                 const id = data[i]['id_usuario'];
//                 const name = data[i]['name_user'].toUpperCase();
//                 $("#users").append($('<option>').val(id).text(name));
//             }

//             $("#users").selectpicker('refresh');
//         }
//     });

//     // createPrestamosDataTable(rol, user, mes, anio);
// });

// $('#users').change(function () {
//     const rol = $('#roles').val();
//     let user = $(this).val();
//     mes = $('#mes').val();
//     rol = $('#rol').val();

//     if (user === undefined || user === null || user === '') {
//         user = 0;
//     }

//     // createPrestamosDataTable(rol, user, mes, anio);
// });

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
    // rol = $('#roles').val();
    // users = $('#users').val();
    console.log(anio);
    if(anio == '' || mes == ''){
    }else{
        createPrestamosDataTable(mes, anio);
    }
    
});

//     $('#rol').change( function(){
//     mes = $('#mes').val();
//     anio = $('#anio').val();
//     rol = $('#rol').val();

//     if(mes == '' || anio == '' ){
//    //     alerts.showNotification("top", "right", "Debe seleccionar las dos fechas y el estatus", "warning");
//     }else{
//         createPrestamosDataTable(anio,rol);
//     }
// });

$('#prestamos-table thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();

    if ( i != 10) {
        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (prestamosTabla.column(i).search() !== this.value) {
                prestamosTabla.column(i).search(this.value).draw();

                var total = 0;
                    var index = prestamosTabla.rows({ selected: true, search: 'applied' }).indexes();
                    var data = prestamosTabla.rows( index ).data();
                    $.each(data, function(i, v){
                        total += parseFloat(v.abono_neodata);
                    });
                    document.getElementById('total-pago').textContent = '$' + formatMoney(total);
            }
        });
    }
});

function createPrestamosDataTable(mes, anio) {
    console.log(anio);
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

        document.getElementById('total-pago').textContent = '$' + formatMoney(total);
    });

    prestamosTabla = $('#prestamos-table').DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",

        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,11,12],
                    format: {
                        header: function (d, columnIndx) {
                            switch (columnIndx) {
                                case 0: return 'ID PAGO';
                                case 1: return 'ID PRÉSTAMO';
                                case 2: return 'USUARIO';
                                case 3: return 'PUESTO';
                                case 4: return 'MONTO TOTAL';
                                case 5: return 'PAGADO';
                                case 6: return 'PENDIENTE';
                                case 7: return 'PAGO INDIVIDUAL';
                                case 8: return 'FECHA';
                                case 9: return 'COMENTARIOS';
                                case 11: return 'TIPO DESCUENTO';
                                case 12: return 'ESTATUS';
                                default: return 'NA';
                            }
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                'name': 'ID PAGO',
                'width': "5%",
                'data': function( d ){
                    return '<p class="m-0">'+d.id_pago_i+'</p>';
                }
            },
            {
                'width': "8%",
                'data': function( d ){
                    return '<p class="m-0">'+d.id_prestamo+'</p>';
                }
            },
            {
                'width': "20%",
                'data': function( d ){
                    return '<p class="m-0">'+d.nombre_completo+'</p>';
                }
            },
            {
                'width': "10%",
                'data': function( d ){
                    return '<p class="m-0">'+d.puesto+'</p>';
                }
            },
            {
                'width': "8%",
                'data': function( d ){
                    return '<p class="m-0">$'+formatMoney(d.monto_prestado)+'</p>';
                }
            },
            {
                'width': "8%",
                'data': function( d ){
                    return '<p class="m-0">$'+formatMoney(d.abono_neodata)+'</p>';
                }
            },
            {
                'width': "8%",
                'data': function( d ){
                    return '<p class="m-0">$'+formatMoney(d.pendiente)+'</p>';
                }
            },
            {
                'width': "8%",
                'data': function( d ){
                    return '<p class="m-0">$'+formatMoney(d.pago_individual)+'</p>';
                }
            },
            {

                visible: true ,
                data: function( d ){
                    return '<p class="m-0">'+d.fecha_creacion+'</p>';
                }
            },
            {
                'width': "8%",
                'data': function( d){         
                    
                        return '<p class="m-0">'+d.comentario+'</p>';
                    
                }
            },
            {
                'width': "8%",
                'data': function( d){         
                    const letras = d.comentario.split(" ");
                    if(letras.length <= 4)
                    {
                        console.log(1) 
                        return '<p class="m-0">'+d.comentario+'</p>';
                    }else{
                    
                        console.log(2)
                        return `<p class="m-0">${letras[0]} ${letras[1]} ${letras[2]} ${letras[3]}....</p> 
                        <a  data-toggle="collapse" data-target="#collapseOne${d.id_pago_i}" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                            <span class="lbl-blueMaderas">Ver más</span> 
                        </a>

                                <div id="collapseOne${d.id_pago_i}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                ${d.comentario}
                                </div>
                                </div>
                        `;
                    }
                }
            },
            {
                'width': "5%",
                'data': function(d) {
                    return '<span class="label" style="background: #05A134;">PAGADO</span>';
                }
            },
            {
                'width': "5%",
                'data': function(d) {
                    let etiqueta = '';
                color='000';
                if(d.id_opcion == 18){ //PRESTAMO
                    color='89C86C';
                } else if(d.id_opcion == 19){ //SCIO
                    color='72EDD6';
                }else if(d.id_opcion == 20){ //PLAZA
                    color='72CBED';
                }else if(d.id_opcion == 21){ //LINEA TELEFÓNICA
                    color='7282ED';
                }else if(d.id_opcion == 22){ //MANTENIMIENTO
                    color='CA72ED';
                }else if(d.id_opcion == 23){ //NÓMINA - ANALISTAS DE COMISIONES
                    color='CA15ED';
                }else if(d.id_opcion == 24){ //NÓMINA - ASISTENTES CDMX
                    color='CA9315';
                }else if(d.id_opcion == 25){ //NÓMINA - IMSS
                    color='34A25C';
                }else if(d.id_opcion == 26){ //NÓMINA -LIDER DE PROYECTO E INNOVACIÓN
                    color='165879';
                }

                return '<p><span class="label" style="background:#'+color+';">'+d.tipo+'</span></p>';
                }
            },
            {
                'width': "6%",
                'orderable': false,
                'data': function( d ) {
                    
                    return `<div class="d-flex justify-center">
                        <button class="btn-data btn-blueMaderas consulta-historial"
                            value="${d.id_relacion_pp}"
                            title="Historial">
                            <i class="fas fa-info"></i>
                        </button>
                    </div> `;
                }
            }
        ],
        columnDefs: [{
            targets: [ 9], visible: false,
            searchable: false,
        }],
        ajax: {
            url: `${general_base_url}Comisiones/getPrestamosTable/${mes}/${anio}`,
            type: "GET",
            cache: false,
            data: function( d ){}
        },
    });

    $('#prestamos-table tbody').on('click', '.consulta-historial', function (e) {
        $('#spiner-loader').removeClass('hide');
        e.preventDefault();
        e.stopImmediatePropagation();

        const idRelacion = $(this).val();

        $('#historial-prestamo-content').html('');
        $.getJSON(`${general_base_url}Comisiones/getHistorialPrestamoAut/${idRelacion}`)
            .done(function (data) {
                $.each(data, function(i, v) {
                    $("#historial-prestamo-content").append(`
                        <p style="color:gray;font-size:1.1em;">
                            ${v.comentario}
                            <br>
                            <b style="color:#3982C0;font-size:0.9em;">
                                ${v.fecha}
                            </b>
                            <b style="color:gray;font-size:0.9em;">
                            - ${v.nombre_usuario}
                            </b>
                        </p>
                    `);
                });

                $('#historial-modal').modal();
                    $('#spiner-loader').addClass('hide');
            });
    });
}

function formatMoney( n ) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d === undefined ? "." : d,
        t = t === undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

