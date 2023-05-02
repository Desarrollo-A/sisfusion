$(document).ready(function(){
	$.post(`${general_base_url}Contratacion/lista_proyecto`, function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++)
		{
			var id = data[i]['idResidencial'];
			var name = data[i]['descripcion'];
			$("#proyecto").append($('<option>').val(id).text(name.toUpperCase()));
		}

		$("#proyecto").selectpicker('refresh');
	}, 'json');

	$.post(`${general_base_url}Contratacion/lista_estatus`, function(data) {
		var len = data.length;
		for( var i = 0; i<len; i++)
		{
			var id = data[i]['idStatusLote'];
			var name = data[i]['nombre'];
			$("#estatus").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#estatus").selectpicker('refresh');
	}, 'json');
});


$('#proyecto').change( function(){
	index_proyecto = $(this).val();
	$("#condominio").html("");
	$(document).ready(function(){
		$.post(`${general_base_url}Contratacion/lista_condominio/`+index_proyecto, function(data) {
			var len = data.length;
			$("#condominio").append($('<option disabled selected>- SELECCIONA CONDOMINIO -</option>'));

			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idCondominio'];
				var name = data[i]['nombre'];
				$("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#condominio").selectpicker('refresh');
		}, 'json');
	});
});

       $('#tabla_inventario_contraloria thead tr:eq(0) th').each( function (i) {
           if(i!=17){
               var title = $(this).text();
               $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="'+title+'"/>' );
               $( 'input', this ).on('keyup change', function () {
                   if ($('#tabla_inventario_contraloria').DataTable().column(i).search() !== this.value ) {
                       $('#tabla_inventario_contraloria').DataTable().column(i).search(this.value).draw();
                   }
               });
           }

       });

$(document).on('change','#proyecto, #condominio, #estatus', function() {
	ix_proyecto = $("#proyecto").val();
   	ix_condominio = $("#condominio").val();
   	ix_estatus = $("#estatus").val();

   	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        destroy: true,
   		"ajax":
   		{
   			"url": `${general_base_url}index.php/Contratacion/get_inventario/`+ix_estatus+`/`+ix_condominio+`/`+ix_proyecto,
   			"dataSrc": ""
   		},
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Inventario Lotes',
                    title:"Inventario Lotes",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SUP';
                                        break;
                                    case 4:
                                        return 'M2';
                                        break;
                                    case 5:
                                        return 'PRECIO LISTA';
                                        break;
                                    case 6:
                                        return 'TOTAL DESCUENTOS';
                                        break;
                                    case 7:
                                        return 'REFERENCIA';
                                        break;
                                    case 8:
                                        return 'MSI';
                                        break;
                                    case 9:
                                        return 'ASESOR';
                                        break;
                                    case 10:
                                        return 'COORDINADOR';
                                        break;
                                    case 11:
                                        return 'GERENTE';
                                        break;
                                    case 12:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 13:
                                        return 'DIRECTOR REGIONAL';
                                        break;
                                    case 14:
                                        return 'ESTATUS';
                                        break;
                                    case 15:
                                        return 'FECHA AP';
                                        break;
                                    case 16:
                                        return 'COMENTARIO';
                                        break;
                                    case 17:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 18:
                                        return 'FECHA APERTURA';
                                        break;
                                    case 19:
										return 'FECHA VALIDACION ENGANCHE';
										break;
									case 20:
										return 'CANTIDAD ENGANCHE PAGADO';
										break;
                                    case 21:
                                        return 'UBICACIÓN'
                                        break;
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Inventario Lotes',
                    title: "Inventario Lotes",
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                        format: {
                            header: function (d, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'PROYECTO';
                                        break;
                                    case 1:
                                        return 'CONDOMINIO';
                                        break;
                                    case 2:
                                        return 'LOTE';
                                    case 3:
                                        return 'SUP';
                                        break;
                                    case 4:
                                        return 'M2';
                                        break;
                                    case 5:
                                        return 'PRECIO LISTA';
                                        break;
                                    case 6:
                                        return 'TOTAL DESCUENTOS';
                                        break;
                                    case 7:
                                        return 'REFERENCIA';
                                        break;
                                    case 8:
                                        return 'MSI';
                                        break;
                                    case 9:
                                        return 'ASESOR';
                                        break;
                                    case 10:
                                        return 'COORDINADOR';
                                        break;
                                    case 11:
                                        return 'GERENTE';
                                        break;
                                    case 12:
                                        return 'SUBDIRECTOR';
                                        break;
                                    case 13:
                                        return 'DIRECTOR REGIONAL';
                                        break;
                                    case 14:
                                        return 'ESTATUS';
                                        break;
                                    case 15:
                                        return 'FECHA AP';
                                        break;
                                    case 16:
                                        return 'COMENTARIO';
                                        break;
                                    case 17:
                                        return 'LUGAR PROSPECCIÓN';
                                        break;
                                    case 18:
                                        return 'FECHA APERTURA';
                                        break;
                                    case 19:
										return 'FECHA VALIDACION ENGANCHE';
										break;
									case 20:
										return 'CANTIDAD ENGANCHE PAGADO';
										break;
                                    case 21:
                                        return 'UBICACIÓN'
                                        break;
                                }
                            }
                        }
                    }
                }
            ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
		processing: true,
		pageLength: 10,
		bAutoWidth: false,
		bLengthChange: false,
		scrollX: true,
		bInfo: true,
		searching: true,
		paging: true,
		ordering: true,
		fixedColumns: true,
		columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
		columns:
		[{
			"width": "10%",
			data: 'nombreResidencial'
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
			}
		},
		{
			"width": "14%",
			data: 'nombreLote'
		},
		{
			"width": "10%",
			"data": function(d){
				return '<p>'+d.superficie+'</p>';
			}
		},
	    {
			"width": "10%",
			"data": function(d){
                var preciom2;
                    
                if(d.nombreResidencial == 'CCMP'){
                
                    if(d.idStatusLote != 3){
                        var stella;
                        var aura;
                        
                        if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
                            d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
                            d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
                            d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
                            d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
                            
                            d.nombreLote == 'CCMP-LIRIO-010' ||
                            d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
                            d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
                            d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
                                
                                stella = ( (parseInt(d.total) + parseInt(2029185)) / d.superficie);
                                aura = ( (parseInt(d.total) + parseInt(1037340)) / d.superficie );
                                
                                preciom2 = '<p>S:'+formatMoney(stella).replace('$', '$ ')+'</p>' +'A:'+formatMoney(aura).replace('$', '$ ');


                        } else {
                            
                                stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
                                aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
                            
                                preciom2 = '<p>S:'+formatMoney(stella).replace('$', '$ ')+'</p>' +'A:'+formatMoney(aura).replace('$', '$ ');

                        }
                    } else if(d.idStatusLote == 3) {
                    
                    preciom2 = '<p>'+formatMoney(d.precio).replace('$', '$ ')+'</p>';

                    }
                    
                } else {
                
                    preciom2 = '<p>'+formatMoney(d.precio).replace('$', '$ ')+'</p>';

                }

                return preciom2;
			}
		},
		{
			"width": "10%",
			"data": function(d){
                var preciot;				
                if(d.nombreResidencial == 'CCMP'){
                    
                    if(d.idStatusLote != 3){
                        var stella;
                        var aura;
                        
                        if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
                            d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
                            d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
                            d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
                            d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
                            
                            d.nombreLote == 'CCMP-LIRIO-010' ||
                            d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
                            d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
                            d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
                                
                                stella = ( parseInt(d.total) + parseInt(2029185) );
                                aura = ( parseInt(d.total) + parseInt(1037340) );
                                
                                preciot = '<p>S:'+formatMoney(stella).replace('$', '$ ')+'</p>' +'A:'+formatMoney(aura).replace('$', '$ ');


                        } else {
                            
                                stella = ( parseInt(d.total) + parseInt(2104340) );
                                aura = ( parseInt(d.total) + parseInt(1075760) );
                            
                                preciot = '<p>S:'+formatMoney(stella).replace('$', '$ ')+'</p>' +'A:'+formatMoney(aura).replace('$', '$ ');

                        }
                    } else if(d.idStatusLote == 3){
                    
                    preciot = '<p>'+formatMoney(d.total).replace('$', '$ ')+'</p>';

                    }
                    
                } else {
                
                    preciot = '<p>'+formatMoney(d.total).replace('$', '$ ')+'</p>';

                }

                return preciot;
                                
            }
		},
		{
			"width": "10%",
			"data": function(d){
				if (d.totalNeto2 == null || d.totalNeto2 == '' || d.totalNeto2 == undefined) {
					return '<p> ' + formatMoney(0).replace('$', '$ ')+ '</p>';
				} else {
					return '<p> ' + formatMoney(d.totalNeto2).replace('$', '$ ') + '</p>';
				}
			}
		},
		{
			"width": "10%",
			data: 'referencia'
		},
		{
			"width": "5%",
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
			data: function(d){
				var subdirector;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					subdirector = d.subdirector2 == '  ' ? 'SIN ESPECIFICAR' : d.subdirector2;
				else
					subdirector = d.subdirector == '  ' ? 'SIN ESPECIFICAR' : d.subdirector;
				return subdirector;
			}
		},
		{
			data: function(d){
				var regional;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
					regional = d.regional2 == '  ' ? 'SIN ESPECIFICAR' : d.regional2;
				else
					regional = d.regional == '  ' ? 'SIN ESPECIFICAR' : d.regional;
				return regional;
			}
		},
		{
			"width": "12%",
			"data": function(d){
				
			    libContraloria = (d.observacionContratoUrgente == '1') ? '<center><span class="label label-warning";">Lib. Contraloría</span> <center><p><p>' : '';
				valTV = (d.tipo_venta == null) ? '<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span> <center>' :
				'<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span> <p><p> <span class="label label-warning";">'+d.tipo_venta+'</span> <center>';

				return valTV + libContraloria;
			}
		},
		{
			"width": "10%",
			"data": function(d){
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10){
                    if(d.fecha_modst == 'null' || d.fecha_modst == 'NULL' || d.fecha_modst == null || d.fecha_modst == ''){
                        return '-';
                    }else{
                        return '<p>'+d.fecha_modst+'</p>';
                    }
				}else {
                    if(d.fechaApartado == 'null' || d.fechaApartado == 'NULL' || d.fechaApartado == null || d.fechaApartado == ''){
                        return '-';
                    }else{
                        return '<p>'+d.fechaApartado+'</p>';
                    }
				}
			}
		},
		{
			"width": "16%",
			"data": function(d){

				
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10 || d.idStatusLote == 11 || d.idStatusLote == 4 
				   || d.idStatusLote == 6 || d.idStatusLote == 7){
					
						if(d.motivo_change_status=='NULL'||d.motivo_change_status=='null'||d.motivo_change_status==null){
							return ' - ';
						}
						else {
							return '<p>'+d.motivo_change_status+'</p>';
						}
						
				} else {
				
						if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
							return ' - ';
						}
						else {
							return '<p>'+d.comentario+'</p>';
						}
				  
				}
				
			}
		},
		{
            "width": "50%",
            "data": function(d){
                if(d.lugar_prospeccion=='NULL'||d.lugar_prospeccion=='null'||d.lugar_prospeccion==null){
                    return ' - ';
                }
                else
                {
                    return '<p>'+d.lugar_prospeccion+'</p>';
                }
            }
        },
        {
            "width": "5%",
            "data": function(d){
                if(d.fecha_creacion == 'NULL' || d.fecha_creacion == 'null' || d.fecha_creacion == null){
                    return ' - ';
                }
                else
                {
                    return '<p>'+d.fecha_creacion+'</p>';
                }
            }
        },
        {
            "width": "8%",
            "data": function (d) {
                if(d.fecha_validacion == 'NULL' || d.fecha_validacion == 'null' || d.fecha_validacion == null || d.fecha_validacion == ''){
                    return '-';
                }else{
                    return '<p>'+ d.fecha_validacion +'</p>';
                }
            }
        },
        {
            "width": "8%",
            "data": function( d ){
                return '<p>'+formatMoney(d.cantidad_enganche).replace('$', '$ ')+'</p>';
            }
        },
        {
            "width": "10%",
			"data": function (d) {
                lugar_ubicacion = (d.ubicacion == null) 
                    ? '<center><span class="label label-warning;" style="background:#F9E79F; color: #7D6608">Sin asignar</span> <center>'
                    : '<center><span class="label label-warning;" style="background:#D2B4DE; color: #4A235A">' + d.ubicacion + '</span> <center>';
                return lugar_ubicacion;
            }
        },
		{
			"width": "8%",
			"data": function( d ){
				return '<center><button class="btn-data btn-green ver_historial" value="' + d.idLote +'" data-nomLote="'+d.nombreLote+'" data-tipo-venta="'+d.tipo_venta+'" title="Ver detalles generales"><i class="fas fa-history"></i></button></center>';
			}
		}]
	});


    $(window).resize(function(){
    tabla_inventario.columns.adjust();
	});
});
$(document).on("click", ".ver_historial", function(){
	var tr = $(this).closest('tr');
	var row = tabla_inventario.row( tr );
	idLote = $(this).val();
	var $itself = $(this);

	var element = document.getElementById("li_individual_sales");

	if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
		$.getJSON(`${general_base_url}Contratacion/getClauses/`+idLote).done( function( data ){
			$('#clauses_content').html(data[0]['nombre']);
		});
		element.classList.remove("hide");
	} else {
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
	$.getJSON(`${general_base_url}Contratacion/obtener_liberacion/`+idLote).done( function( data ){
		urlTableFred = `${general_base_url}Contratacion/obtener_liberacion/`+idLote;
		fillFreedom(urlTableFred);
	});


	var urlTableHist = '';
	$.getJSON(`${general_base_url}Contratacion/historialProcesoLoteOp/`+idLote).done( function( data ){
		$('#nomLoteHistorial').html($itself.attr('data-nomLote'));
			urlTableHist = `${general_base_url}Contratacion/historialProcesoLoteOp/`+idLote;
			fillHistory(urlTableHist);
	});

	var urlTableCSA = '';
    $.getJSON(`${general_base_url}Contratacion/getCoSallingAdvisers/`+idLote).done( function( data ){
        urlTableCSA = `${general_base_url}Contratacion/getCoSallingAdvisers/`+idLote;
        fillCoSellingAdvisers(urlTableCSA);
    });
    
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

	 // comentario, perfil, modificado,
}

    function fillHistory(urlTableHist)
	{
		tableHistorial = $('#verDet').DataTable( {
			responsive: true,
            dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt> <'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				}
			],
			columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
			"scrollX": true,
			"pageLength": 10,
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
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
			/*"ajax": {
				"url": urlTableHist,//"<?=base_url()?>index.php/registroLote/historialProcesoLoteOp/"
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.idLote = idlote_global;
				}
			},*/
			"ajax":
				{
					"url": urlTableHist,
					"dataSrc": ""
				},
		});
	}
	function fillFreedom(urlTableFred)
	{
		tableHistorialBloqueo = $('#verDetBloqueo').DataTable( {
			responsive: true,

            dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt> <'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
            buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				}
			],
			columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
			"scrollX": true,
			"pageLength": 10,
            language: {
                url: `${general_base_url}static/spanishLoader_v2.json`,
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
			/*"ajax": {
				"url": urlTableFred,//<?=base_url()?>index.php/registroLote/historialBloqueos/
				"type": "POST",
				cache: false,
				"data": function( d ){
				}
			},*/
			"ajax":
				{
					"url": urlTableFred,
					"dataSrc": ""
				},
		});
	}

	function fillCoSellingAdvisers(urlTableCSA)
{
    tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable( {
        responsive: true,
        dom: "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'B><'col-12 col-sm-12 col-md-6 col-lg-6'f>rt> <'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        buttons: [
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
        ],
        columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
        "scrollX": true,
        "pageLength": 10,
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
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
        "ajax":
            {
                "url": urlTableCSA,
                "dataSrc": ""
            },
    });
}