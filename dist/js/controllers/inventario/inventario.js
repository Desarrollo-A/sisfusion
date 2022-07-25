
$(document).ready(function(){
	$.post(`${general_base_url}Contratacion/sedesPorDesarrollos`, function(data) {
		var len = data.length;
		for(var i = 0; i<len; i++)
		{
			var id = data[i]['id_sede'];
			var name = data[i]['nombre'];
			$("#sedes").append($('<option>').val(id).text(name.toUpperCase()));
		}
		$("#sedes").selectpicker('refresh');
	}, 'json');
});

$(document).on('change', "#sedes", function () {
    fillTableInventario($(this).val());
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

function fillTableInventario(sede) {
   	tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
        dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        destroy: true,
   		buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Inventario Lotes',
            title:"Inventario Lotes",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
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
                                return 'GERENTE';
                                break;
                            case 10:
                                return 'COORDINADOR';
                                break;
                            case 11:
                                return 'ASESOR';
                                break;
                            case 12:
                                return 'ESTATUS';
                                break;
                            case 13:
                                return 'FECHA AP';
                                break;
                            case 14:
                                return 'COMENTARIO';
                                break;
                            case 15:
                                return 'LUGAR PROSPECCIÓN';
                                break;
                            case 16:
                                return 'FECHA APERTURA';
                                break;
                            case 17:
								return 'FECHA VALIDACION ENGANCHE';
								break;
							case 18:
								return 'CANTIDAD ENGANCHE PAGADO';
								break;
                        }
                    }
                }
            }
        }],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
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
					    
						preciom2 = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);


				} else {
					
						stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
						aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
					
						preciom2 = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);

				}
			} else if(d.idStatusLote == 3) {
			
			preciom2 = '<p>'+formatMoney(d.precio)+'</p>';

			}
			
		} else {
		
			preciom2 = '<p>'+formatMoney(d.precio)+'</p>';

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
					    
						preciot = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);


				} else {
					
						stella = ( parseInt(d.total) + parseInt(2104340) );
						aura = ( parseInt(d.total) + parseInt(1075760) );
					
						preciot = '<p>S:'+formatMoney(stella)+'</p>' +'A:'+formatMoney(aura);

				}
			} else if(d.idStatusLote == 3){
			
			preciot = '<p>'+formatMoney(d.total)+'</p>';

			}
			
		} else {
		
			preciot = '<p>'+formatMoney(d.total)+'</p>';

		}

		return preciot;
						
			}
		},
		{
			"width": "10%",
			"data": function(d){
				if (d.totalNeto2 == null || d.totalNeto2 == '' || d.totalNeto2 == undefined) {
					return '$0.00';
				} else {
					return formatMoney(d.totalNeto2);
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
			"data": function(d){
				var gerente;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
				{
					gerente = myFunctions.validateEmptyField(d.gerente2);
				}
				else
				{
					gerente = myFunctions.validateEmptyField(d.gerente);
				}
				return gerente;
			}
		},
		{
			"data": function(d){
				var coordinador;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
				{
					coordinador = myFunctions.validateEmptyField(d.coordinador2);
				}
				else
				{
					coordinador = myFunctions.validateEmptyField(d.coordinador);
				}
				return coordinador;
			}
		},
		{
			"data": function(d){
				return myFunctions.validateEmptyField(d.asesor);
				var asesor;
				if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
				{
					asesor = myFunctions.validateEmptyField(d.asesor2);
				}
				else
				{
					asesor = myFunctions.validateEmptyField(d.asesor);
				}
				return asesor;
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
				  return '<p>'+d.fecha_modst+'</p>';
				} else {
				  return '<p>'+d.fechaApartado+'</p>';

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
				data: 'fecha_validacion'
			},
			{
				"width": "8%",
				"data": function( d ){
					return '<p>$ '+formatMoney(d.cantidad_enganche)+'</p>';
				}
			}
		],
        ajax: {
            url: `${general_base_url}Contratacion/downloadCompleteInventory`,
            type: "POST",
            cache: false,
            data: {
                "id_sede": sede
            }
        }
	});
    $(window).resize(function(){
        tabla_inventario.columns.adjust();
	});
}

function formatMoney( n ) {
	var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

