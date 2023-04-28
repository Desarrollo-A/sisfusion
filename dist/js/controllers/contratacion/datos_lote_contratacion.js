<<<<<<< HEAD
$(document).ready(function () {
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idResidencial").append($('<option>').val(data[i]['idResidencial']).text(data[i]['nombreResidencial'] + ' - ' + data[i]['descripcion']));
        }
        $("#idResidencial").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Contratacion/lista_estatus`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#idEstatus").append($('<option>').val(data[i]['idStatusLote']).text(data[i]['nombre']));
        }
        $("#idEstatus").selectpicker('refresh');
    }, 'json');
});

$('#idResidencial').change(function () {
    index_idResidencial = $(this).val();
    $("#idCondominioInventario").html("");
    $(document).ready(function () {
        $.post(`${general_base_url}Contratacion/lista_condominio/${index_idResidencial}`, function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#idCondominioInventario").append($('<option>').val(data[i]['idCondominio']).text(data[i]['nombre']));
            }
            $("#idCondominioInventario").selectpicker('refresh');
        }, 'json');
    });
});

let titulosInventario = [];
$('#tablaInventario thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaInventario').DataTable().column(i).search() !== this.value) {
            $('#tablaInventario').DataTable().column(i).search(this.value).draw();
        }
    });
});

$(document).on('change', '#idResidencial, #idCondominioInventario, #idEstatus', function () {
    ix_idResidencial = ($("#idResidencial").val().length <= 0) ? 0 : $("#idResidencial").val();
    ix_idCondominio = $("#idCondominioInventario").val() == '' ? null : $("#idCondominioInventario").val();
    ix_idEstatus = $("#idEstatus").val() == '' ? null : $("#idEstatus").val();

    tabla_inventario = $("#tablaInventario").DataTable({
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6 p-0'f>rt>"+"<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        destroy: true,
        searching: true,
        ajax: {
            url: `${general_base_url}Contratacion/get_inventario/${ix_idEstatus}/${ix_idCondominio}/${ix_idResidencial}`,
            dataSrc: ""
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'MADERAS_CRM_INVENTARIO',
                exportOptions: {
                    columns: coordinador = id_rol_general == 11 ? [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 26],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'PDF',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 22],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosInventario[columnIdx]  + ' ';
                        }
                    }
                }
            }],
        columnDefs: [{
            targets: [22, 23, 24],
            visible: coordinador = id_rol_general == 11 ? true : false
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: false,
        pageLength: 10,
        bAutoWidth: false,
        bLengthChange: false,
        bInfo: true,
        paging: true,
        ordering: true,
        fixedColumns: true,
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            {
                data: function (d) {
                    if (d.casa == 1)
                        return `${d.nombreLote} <br><span class="label" style="background:#D7BDE2; color:#512E5F;">${d.nombre_tipo_casa}</span>`
                    else
                        return d.nombreLote;
                }
            },
            { data: 'idLote' },
            {
                data: function (d) {
                    return d.superficie + ' <b>m<sup>2</sup></b>';
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.precio * d.sup);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.totalNeto2);
                }
            },
            {
                data: function (d) {
                    return formatMoney(d.precio);
                }
            },
            { data: 'referencia' },
            { data: 'msni' },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.asesor2;
                    else
                        return d.asesor;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.coordinador2;
                    else
                        return d.coordinador;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.gerente2;
                    else
                        return d.gerente;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.subdirector2;
                    else
                        return d.subdirector;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.regional22;
                    else
                        return d.regional;
                }
            },
            {
                data: function (d) {
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return 'SIN ESPECIFICAR';
                    else
                        return d.regional2;
                }
            },
            {
                data: function (d) {
                    return d.tipo_venta == null ?
                        `<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <center>` :
                        `<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <p><p> <span class="label" style="background:#A5D6A7; color:#1B5E20;">${d.tipo_venta}</span> <center>`;
                }
            },
            {
                data: function (d) { // VALIDAR FECHAS NULL DESDE LA QUERY
                    if (d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
                        return d.fecha_modst;
                    else
                        return d.fechaApartado;
                }
            },
            {
                data: function (d) { // VALIDAR FECHAS NULL DESDE LA QUERY
                    if (d.comentario == null || d.comentario == 'NULL' || d.comentario == '')
                        return 'SIN ESPECIFICAR';
                    else
                        return d.comentario;
                }
            },
            { data: 'lugar_prospeccion' },
            { data: 'fecha_validacion' }, // VALIDAR FECHA NULL DESDE LA QUERY
            {
                data: function (d) {
                    return formatMoney(d.cantidad_enganche);
                }
            },
            {
                visible: (id_rol_general == 11) ? true : false,
                data: function (d) {
                    return d.idStatusContratacion; // VALIDAR ESTATUS NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_rol_general == 11) ? true : false,
                data: function (d) {
                    return d.nombreCliente; // VALIDAR CLIENTE NULL DESDE LA QUERY
                }
            },
            {
                visible: (id_rol_general == 11) ? true : false,
                data: function (d) {
                    return d.nombreCopropietario; // VALIDAR COPROPIETARIO NULL DESDE LA QUERY
                }
            },
            { data: 'comentario_administracion' },
            {
                data: function (d) {
                    return `<center><button class="btn-data btn-blueMaderas ver_historial" value="${d.idLote}" data-nomLote="${d.nombreLote}" data-tipo-venta="${d.tipo_venta}" data-toggle="tooltip" data-placement="left" title="Ver más información"><i class="fas fa-history"></i></button></center>`;
                }
            }
        ],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
});

$(document).on("click", ".ver_historial", function () {
    let $itself = $(this);
    let element = document.getElementById("divTabClausulas");
    let idLote = $(this).val();
    if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
        $.getJSON(`${general_base_url}Contratacion/getClauses/${idLote}`).done(function (data) {
            $('#clauses_content').html(data[0]['nombre']);
        });
        element.classList.remove("hide");
    } else {
        element.classList.add("hide");
        $('#clauses_content').html('');
    }

    $("#seeInformationModal").modal();

    // LLENA LA TABLA CON EL HISTORIAL DEL PROCESO DE CONTRATACIÓN DEL LOTE X
    consultarHistoriaContratacion(idLote);

    // LLENA LA TABLA CON EL HISTORIAL DE LIBERACIÓN DEL LOTE X
    consultarHistoriaLiberacion(idLote);

    // LLENA LA TABLA CON EL LISTADO DE COMISIONISTAS COMO VENTAS COMPARTIDAS DEL LOTE X
    consultarVentasCompartidas(idLote);
});


let titulostablaHistorialContratacion = [];
$('#tablaHistorialContratacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulostablaHistorialContratacion.push(title);
    $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaHistorialContratacion').DataTable().column(i).search() !== this.value) {
            $('#tablaHistorialContratacion').DataTable().column(i).search(this.value).draw();
        }
    });
});

function consultarHistoriaContratacion(idLote) {
    tablaHistorialContratacion = $('#tablaHistorialContratacion').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'HISTORIAL CONTRATACIÓN',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulostablaHistorialContratacion[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        width: '100%',
        scrollX: true,
        pageLength: 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { data: "nombreLote" },
            { data: "nombreStatus" },
            { data: "descripcion" },
            { data: "comentario" },
            { data: "modificado" },
            { data: "usuario" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/historialProcesoLoteOp/${idLote}`,
            dataSrc: ""
        },
    });
}

let titulosTablaHistoriaLiberacion = [];
$('#tablaHistoriaLiberacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosTablaHistoriaLiberacion.push(title);
    $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaHistoriaLiberacion').DataTable().column(i).search() !== this.value) {
            $('#tablaHistoriaLiberacion').DataTable().column(i).search(this.value).draw();
        }
    });
});

function consultarHistoriaLiberacion(idLote) {
    tablaHistoriaLiberacion = $('#tablaHistoriaLiberacion').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'HISTORIAL LIBERACIÓN',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosTablaHistoriaLiberacion[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        width: '100%',
        scrollX: true,
        pageLength: 10,
        destroy: true,
        ordering: false,
        columns: [
            { data: "nombreLote" },
            { data: "precio" },
            { data: "modificado" },
            { data: "observacionLiberacion" },
            { data: "userLiberacion" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/obtener_liberacion/${idLote}`,
            dataSrc: ""
        },
    });
}

let titulosTablaVentasCompartidas = [];
$('#tablaVentasCompartidas thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosTablaVentasCompartidas.push(title);
    $(this).html(`<input type="text" class="textoshead" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaVentasCompartidas').DataTable().column(i).search() !== this.value) {
            $('#tablaVentasCompartidas').DataTable().column(i).search(this.value).draw();
        }
    });
});

function consultarVentasCompartidas(idLote) {
    tablaVentasCompartidas = $('#tablaVentasCompartidas').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'VENTAS COMPARTIDAS',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosTablaVentasCompartidas[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        width: '100%',
        scrollX: true,
        pageLength: 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { data: "asesor" },
            { data: "coordinador" },
            { data: "gerente" },
            { data: "subdirector" },
            { data: "regional" },
            { data: "regional2" },
            { data: "fecha_creacion" },
            { data: "creado_por" }
        ],
        ajax: {
            url: `${general_base_url}Contratacion/getCoSallingAdvisers/${idLote}`,
            dataSrc: ""
        },
    });
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});
=======
var idLote = 0;
$(document).ready(function(){
	$.post(general_base_url + "Contratacion/lista_proyecto", function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++){
			var id = data[i]['idResidencial'];
			var name = data[i]['descripcion'];
			$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#proyecto").selectpicker('refresh');
	}, 'json');

	$.post(general_base_url + "Contratacion/lista_estatus", function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++){
			var id = data[i]['idStatusLote'];
			var name = data[i]['nombre'];
			$("#estatus").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#estatus").selectpicker('refresh');
	}, 'json');

	$.post(general_base_url + "Administracion/get_des_lote", function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++){
			var id = data[i]['id_opcion'];
			var name = data[i]['nombre'];
			$("#sel_desarrollo").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#sel_desarrollo").selectpicker('refresh');
	}, 'json');
});

$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(general_base_url + "Contratacion/lista_condominio/"+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>SELECCIONA UNA OPCIÓN</option>'));
			for( var i = 0; i<len; i++){
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
});

let titulos = [];

$(document).on('change','#proyecto, #condominio, #estatus', function() {
	ix_proyecto = ($("#proyecto").val().length<=0) ? 0 : $("#proyecto").val();
	ix_condominio = $("#condominio").val();
	ix_estatus = $("#estatus").val();

	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
		dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
		destroy: true,
		searching: true,
		ajax: {
			url: general_base_url + 'Contratacion/get_inventario/'+ix_estatus+"/"+ix_condominio+"/"+ix_proyecto,
			dataSrc: ""
		},
		buttons: [{
			extend: 'excelHtml5',
			text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
			className: 'btn buttons-excel',
			titleAttr: 'Descargar archivo de Excel',
			title: 'MADERAS_CRM_INVENTARIO',
			exportOptions: {
				columns:   coordinador = id_rol_general == 11 ?  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21] : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18] ,
				format: {
					header: function (d, columnIdx) {
						if(id_rol_general != 11){
							switch (columnIdx) {
								case 0:
									return 'PROYECTO';
									break;
								case 1:
									return 'CONDOMINIO';
									break;
								case 2:
									return 'LOTE';
									break;
								case 3:
									return 'ID LOTE';
									break;
								case 4:
									return 'SUPERFICIE';
									break;
								case 5:
									return 'PRECIO DE LISTA';
									break;
								case 6:
									return 'TOTAL CON DESCUENTOS';
									break;
								case 7:
									return 'M2';
									break;
								case 8:
									return 'REFERENCIA';
									break;
								case 9:
									return 'MSI';
									break;
								case 10:
									return 'ASESOR';
									break;
								case 11:
									return 'COORDINADOR';
									break;
								case 12:
									return 'GERENTE';
									break;
								case 13:
									return 'ESTATUS';
									break;
								case 14:
									return 'APARTADO';
									break;
								case 15:
									return 'COMENTARIO';
									break;
								case 16:
									return 'LUGAR PROSPECCIÓN';
									break;
								case 17:
									return 'FECHA VALIDACION ENGANCHE';
									break;
								case 18:
									return 'CANTIDAD ENGANCHE PAGADO';
									break;
							}
						} else {
							switch (columnIdx) {
								case 0:
									return 'PROYECTO';
									break;
								case 1:
									return 'CONDOMINIO';
									break;
								case 2:
									return 'LOTE';
									break;
								case 3:
									return 'ID LOTE';
									break;
								case 4:
									return 'SUPERFICIE';
									break;
								case 5:
									return 'PRECIO DE LISTA';
									break;
								case 6:
									return 'TOTAL CON DESCUENTOS';
									break;
								case 7:
									return 'M2';
									break;
								case 8:
									return 'REFERENCIA';
									break;
								case 9:
									return 'MSI';
									break;
								case 10:
									return 'ASESOR';
									break;
								case 11:
									return 'COORDINADOR';
									break;
								case 12:
									return 'GERENTE';
									break;
								case 13:
									return 'ESTATUS';
									break;
								case 14:
									return 'APARTADO';
									break;
								case 15:
									return 'COMENTARIO';
									break;
								case 16:
									return 'LUGAR PROSPECCIÓN';
									break;
								case 17:
									return 'FECHA VALIDACION ENGANCHE';
									break;
								case 18:
									return 'CANTIDAD ENGANCHE PAGADO';
									break;
								case 19:
									if(id_rol_general == 11){
										return 'ESTATUS CONTRATACIÓN';
									}
									return ''
									break;
								case 20:
									if(id_rol_general == 11)
										return 'CLIENTE';
									else
										return ''
									break;
								case 21:
									if(id_rol_general == 11)
										return 'COPROPIETARIO (S)';
									else
										return ''
									break;
							}
						}
					}
				}
			}
		},
		{
			extend: 'pdfHtml5',
			text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
			className: 'btn buttons-pdf',
			titleAttr: 'PDF',
			orientation: 'landscape',
			pageSize: 'LEGAL',
			exportOptions: {
			columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
			format: {
				header:  function (d, columnIdx) {
						return ' '+d +' ';
					}
				}
			}
		}],
		columnDefs: [
			{ targets: [19,20, 21], visible: coordinador = id_rol_general == 11 ? true : false },
			{ targets: '_all', visible: true }
		],
		pagingType: "full_numbers",
		language: {
			url: general_base_url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		"processing": false,
		"pageLength": 10,
		"bLengthChange": false,
		"bInfo": true,
		"paging": true,
		"ordering": true,
		"fixedColumns": true,
		"columns": [{
			data: 'nombreResidencial'
		},
		{
			"data": function(d){
				return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
			}
		},
		{
			"data": function(d){
				if (d.casa == 1)
					return `${d.nombreLote} <br><span class="label" style="background:#D7BDE2; color:#512E5F;">${d.nombre_tipo_casa}</span>`
				else
					return (d.nombreLote).toUpperCase();
			}
		},
		{
			"data": function(d){
				return '<p>'+ d.idLote +'</p>';
			}
		},
		{
			"data": function(d){
				return '<p>'+d.superficie+'<b> m<sup>2</sup></b></p>';
			}
		},
		{
			"data": function(d){
				var preciot;

				if(d.nombreResidencial == 'CCMP'){
					if(d.idStatusLote != 3){
						var stella;
						var aura;
						var terreno;

						if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' || d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' || d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' || d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' || d.nombreLote == 'CCMP-LIRIO-010' || d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' || d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' || d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
							stella = ( parseInt(d.total) + parseInt(2029185) );
							aura = ( parseInt(d.total) + parseInt(1037340) );
							terreno = parseInt(d.total);
							
							preciot = '<p>S: $ '+formatMoney(stella)+'</p>' + '<p>A: $ '+formatMoney(aura)+'</p>' + '<p>T: $ '+formatMoney(terreno)+'</p>';
						} 
						else {
							stella = ( parseInt(d.total) + parseInt(2104340) );
							aura = ( parseInt(d.total) + parseInt(1075760) );
							terreno = parseInt(d.total);

							preciot = '<p>S: $ '+formatMoney(stella)+'</p>' + '<p>A: $ '+formatMoney(aura)+'</p>' + '<p>T: $ '+formatMoney(terreno)+'</p>';
						}
					} 
					else if(d.idStatusLote == 3 || d.idStatusLote == 2){
						preciot = '<p>$ '+formatMoney(d.total)+'</p>';
					}
				} 
				else {
					preciot = '<p>$ '+formatMoney(d.total)+'</p>';
				}
				
				return preciot;
			}
		},
		{
			"data": function(d){
				if (d.totalNeto2 == null || d.totalNeto2 == '' || d.totalNeto2 == undefined) {
					return '$0.00';
				} else {
					return formatMoney(d.totalNeto2);
				}
			}
		},
		{
			"data": function(d){
				var preciom2;
				if(d.nombreResidencial == 'CCMP'){
					if(d.idStatusLote != 3){
						var stella;
						var aura;
						var terreno;
						if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' || d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' || d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' || d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' || d.nombreLote == 'CCMP-LIRIO-010' || d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' || d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' || d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
							stella = ( (parseInt(d.total) + parseInt(2029185)) / d.superficie);
							aura = ( (parseInt(d.total) + parseInt(1037340)) / d.superficie );
							terreno = (parseInt(d.total) / d.superficie);

							preciom2 = '<p>S: $ '+formatMoney(stella)+'</p>' + '<p>A: $ '+formatMoney(aura)+'</p>' + '<p>T: $ '+formatMoney(terreno)+'</p>';
						} 
						else {
							stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
							aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
							terreno = (parseInt(d.total) / d.superficie);

							preciom2 = '<p>S: $ '+formatMoney(stella)+'</p>' + '<p>A: $ '+formatMoney(aura)+'</p>' + '<p>T: $ '+formatMoney(terreno)+'</p>';
						}
					} 
					else if(d.idStatusLote == 3 || d.idStatusLote == 2) {
						preciom2 = '<p>$ '+formatMoney(d.precio)+'</p>';
					}
				} 
				else {
					preciom2 = '<p>$ '+formatMoney(d.precio)+'</p>';
				}

				return preciom2;
			}
		},
		{
			data: 'referencia'
		},
		{
			data: 'msni'
		},
		{
			data: function(d){
				var asesor;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					asesor = d.asesor2 == '  ' ? 'SIN ESPECIFICAR' : d.asesor2;
				else
					asesor = d.asesor == '  ' ? 'SIN ESPECIFICAR' : d.asesor;
				return asesor;
			}
		},
		{
			data: function(d){
				var coordinador;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					coordinador = d.coordinador2 == '  ' ? 'SIN ESPECIFICAR' : d.coordinador2;
				else
					coordinador = d.coordinador == '  ' ? 'SIN ESPECIFICAR' : d.coordinador;
				return coordinador;
			}
		},
		{
			data: function(d){
				var gerente;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					gerente = d.gerente2 == '  ' ? 'SIN ESPECIFICAR' : d.gerente2;
				else
					gerente = d.gerente == '  ' ? 'SIN ESPECIFICAR' : d.gerente;
				return gerente;
			}
		},
		{
			"data": function(d){
				valTV = (d.tipo_venta == null) ? `<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <center>` :
				`<center><span class="label" style="background:#${d.background_sl}; color:#${d.color};">${d.descripcion_estatus}</span> <p><p> <span class="label" style="background:#A5D6A7; color:#1B5E20;">${d.tipo_venta}</span> <center>`;
				return valTV;
			}
		},
		{
			"data": function(d){
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10){
					if(d.fecha_modst == null || d.fecha_modst == 'null') {
						return 'Sin registro';
					} 
					else {
						return '<p>'+d.fecha_modst+'</p>';
					}
				} else {
					if(d.fechaApartado == null || d.fechaApartado == 'null') {
						return 'Sin registro';
					} 
					else {
						return '<p>'+d.fechaApartado+'</p>';
					}
				}
			}
		},
		{
			"data": function(d){
				if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
					return ' - ';
				}
				else return '<p>'+d.comentario+'</p>';
			}
		},
		{
			data: 'lugar_prospeccion'
		},
		{
			"data": function( d ){
				if(d.fecha_validacion  == ' ' || d.fecha_validacion  == null || d.fecha_validacion  == ''   ){
					return '<p> SIN ESPECIFICAR </p>';
				}
				else return '<p>$ '+d.fecha_validacion+'</p>';
			}
		},
		{
			"data": function( d ){
				return '<p>$ '+formatMoney(d.cantidad_enganche)+'</p>';
			}
		},
		{
			"visible": (id_rol_general==11) ? true : false,
			"data": function( d ){
				if(d.idStatusContratacion  == ' ' || d.idStatusContratacion  == null || d.idStatusContratacion  == ''   ){
					return '<p> SIN ESPECIFICAR </p>';
				}
				else{
					return '<p>'+d.idStatusContratacion+'</p>';
				}
			}
		},
		{
			"visible": (id_rol_general==11) ? true : false,
			"data": function( d ){
				if(d.nombreCliente  == "  " || d.nombreCliente  == null || d.nombreCliente  == ''   ){
					return '<p> SIN ESPECIFICAR </p>';
				}else{
					return '<p>'+d.nombreCliente+'</p>';
				}
			}
		},
		{
			"visible": (id_rol_general==11) ? true : false,
			"data": function( d ){
				if(d.nombreCopropietario  == ' ' || d.nombreCopropietario  == null || d.nombreCopropietario  == ''   ){
					return '<p> SIN ESPECIFICAR </p>';
				}else{
					return '<p>'+d.nombreCopropietario+'</p>';
				}
			}
		},
		{
			"data": function( d ){
				return '<center><button class="btn-data  btn-details-grey to-comment ver_historial" value="' + d.idLote +'" data-nomLote="'+d.nombreLote+'" data-tipo-venta="'+d.tipo_venta+'"><i class="fas fa-history"></i></button></center>';
			}
		}]
	});
});

$(document).on("click", ".ver_historial", function(){
	idLote = $(this).val();
	var $itself = $(this);
	var element = document.getElementById("li_individual_sales");

	if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
		$.getJSON(url+"Contratacion/getClauses/"+idLote).done( function( data ){
			$('#clauses_content').html(data[0]['nombre']);
		});
		element.classList.remove("hide");
	} 
	else {
		element.classList.add("hide");
		$('#clauses_content').html('');
	}

	$("#seeInformationModal").on("hidden.bs.modal", function(){
		$("#changeproces").html("");
		$("#changelog").html("");
		$('#nomLoteHistorial').html("");
	});

	$("#seeInformationModal").modal();
	var urlTableFred = '';
	$.getJSON(general_base_url+"Contratacion/obtener_liberacion/"+idLote).done( function( data ){
		urlTableFred = general_base_url+"Contratacion/obtener_liberacion/"+idLote;
		fillFreedom(urlTableFred);
	});

	var urlTableHist = '';
	$.getJSON(general_base_url+"Contratacion/historialProcesoLoteOp/"+idLote).done( function( data ){
		$('#nomLoteHistorial').html($itself.attr('data-nomLote'));
		urlTableHist = general_base_url+"Contratacion/historialProcesoLoteOp/"+idLote;
		fillHistory(urlTableHist);
	});

	var urlTableCSA = '';
	$.getJSON(general_base_url+"Contratacion/getCoSallingAdvisers/"+idLote).done( function( data ){
		urlTableCSA = general_base_url+"Contratacion/getCoSallingAdvisers/"+idLote;
		fillCoSellingAdvisers(urlTableCSA);
	});

	fill_data_asignacion();
});

function fillLiberacion (v) {
	$("#changelog").append('<li class="timeline-inverted">\n' +
		'<div class="timeline-badge success"></div>\n' +
		'<div class="timeline-panel">\n' +
		'<label><h5><b>LIBERACIÓN - </b>'+v.nombreLote+'</h5></label><br>\n' +
		'<b>ID:</b> '+v.idLiberacion+'\n' +
		'<br>\n' +
		'<b>Estatus:</b> '+v.estatus_actual+'\n' +
		'<br>\n' +
		'<b>Comentario:</b> '+v.observacionLiberacion+'\n' +
		'<br>\n' +
		'<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+' - '+v.modificado+'</span>\n' +
		'</h6>\n' +
		'</div>\n' +
		'</li>');
}

function fillProceso (i, v) {
	$("#changeproces").append('<li class="timeline-inverted">\n' +
		'<div class="timeline-badge info">'+(i+1)+'</div>\n' +
		'<div class="timeline-panel">\n' +
		'<b>'+v.nombreStatus+'</b><br><br>\n' +
		'<b>Comentario:</b> \n<p><i>'+v.comentario+'</i></p>\n' +
		'<br>\n' +
		'<b>Detalle:</b> '+v.descripcion+'\n' +
		'<br>\n' +
		'<b>Perfil:</b> '+v.perfil+'\n' +
		'<br>\n' +
		'<b>Usuario:</b> '+v.usuario+'\n' +
		'<br>\n' +
		'<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.modificado+'</span>\n' +
		'</h6>\n' +
		'</div>\n' +
		'</li>');
}


function formatMoney( n ) {
	var c = isNaN(c = Math.abs(c)) ? 2 : c,
	d = d == undefined ? "." : d,
	t = t == undefined ? "," : t,
	s = n < 0 ? "-" : "",
	i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
	j = (j = i.length) > 3 ? j % 3 : 0;

	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function fillHistory(urlTableHist){
	tableHistorial = $('#verDet').DataTable( {
		responsive: true,
		dom: 'Bfrtip',
		buttons: [{
			extend:    'excelHtml5',
			text:      '<i class="fa fa-file-excel-o"></i>',
			titleAttr: 'Excel'
		}],
		"scrollX": true,
		"pageLength": 10,
		language: {
			url: general_base_url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		"destroy": true,
		"ordering": false,
		columns: [
			{ "data": "nombreLote" },
			{ "data": "nombreStatus" },
			{ "data": "descripcion" },
			{ "data": "comentario" },
			{ "data": "modificado" },
			{ "data": "usuario" }
		],
		"ajax": {
			"url": urlTableHist,
			"dataSrc": ""
		},
	});
}

function fillFreedom(urlTableFred){
	tableHistorialBloqueo = $('#verDetBloqueo').DataTable({
		responsive: true,
		dom: 'Bfrtip',
		buttons: [{
			extend:    'excelHtml5',
			text:      '<i class="fa fa-file-excel-o"></i>',
			titleAttr: 'Excel'
		}],
		"scrollX": true,
		"pageLength": 10,
		language: {
			url: general_base_url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		"destroy": true,
		"ordering": false,
		columns: [
			{ "data": "nombreLote" },
			{ "data": "precio" },
			{ "data": "modificado" },
			{ "data" : "observacionLiberacion"},
			{ "data": "userLiberacion" }
		],
		"ajax": {
			"url": urlTableFred,
			"dataSrc": ""
		},
	});
}

function fillCoSellingAdvisers(urlTableCSA){
	tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable({
		responsive: true,
		dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
		buttons: [{
			extend:    'excelHtml5',
			text:      '<i class="fa fa-file-excel-o"></i>',
			titleAttr: 'Excel'
		}],
		columnDefs: [{
			defaultContent: "",
			targets: "_all",
			searchable: true,
			orderable: false
		}],
		"scrollX": true,
		"pageLength": 10,
		language: {
			url: general_base_url+"static/spanishLoader_v2.json",
			paginate: {
				previous: "<i class='fa fa-angle-left'>",
				next: "<i class='fa fa-angle-right'>"
			}
		},
		"destroy": true,
		"ordering": false,
		columns: [
			{ "data": "asesor" },
			{ "data": "coordinador" },
			{ "data": "gerente" },
			{ "data" : "fecha_creacion"},
			{ "data": "creado_por" }
		],
		"ajax": {
			"url": urlTableCSA,
			"dataSrc": ""
		},
	});
}

function fill_data_asignacion(){
	$.getJSON(general_base_url+"Administracion/get_data_asignacion/"+idLote).done( function( data ){
		(data.id_estado == 1) ? $("#check_edo").prop('checked', true) : $("#check_edo").prop('checked', false);
		$('#sel_desarrollo').val(data.id_desarrollo_n);
		$("#sel_desarrollo").selectpicker('refresh');
	});
}

$(document).on('click', '#save_asignacion', function(e) {
	e.preventDefault();
	var id_desarrollo = $("#sel_desarrollo").val();
	var id_estado = ($('input:checkbox[id=check_edo]:checked').val() == 'on') ? 1 : 0;
	var data_asignacion = new FormData();
	data_asignacion.append("idLote", idLote);
	data_asignacion.append("id_desarrollo", id_desarrollo);
	data_asignacion.append("id_estado", id_estado);

	if (id_desarrollo == null) {
		alerts.showNotification("top", "right", "Debes seleccionar un desarrollo.", "danger");
	} 

	if (id_desarrollo != null) {
		$('#save_asignacion').prop('disabled', true);
		$.ajax({
			url : general_base_url+'Administracion/update_asignacion/',
			data: data_asignacion,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST', 
			success: function(data){
				response = JSON.parse(data);
				if(response.message == 'OK') {
					$('#save_asignacion').prop('disabled', false);
					$('#seeInformationModal').modal('hide');
					alerts.showNotification("top", "right", "Asignado con éxito.", "success");
				}
				else if(response.message == 'ERROR'){
					$('#save_asignacion').prop('disabled', false);
					$('#seeInformationModal').modal('hide');
					alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
				}
			},
			error: function( data ){
					$('#save_asignacion').prop('disabled', false);
					$('#seeInformationModal').modal('hide');
					alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
			}
		});
	}
});
>>>>>>> paso_22_escrituracion
