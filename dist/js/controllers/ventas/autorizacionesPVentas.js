
$("#autorizacionesPVentas").ready(function() {
    let titulos = [];
    $('#autorizacionesPVentas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        titulos.push(title);

        $(this).html('<input type="text"  class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function() {

            if (tablaAutorizacion.column(i).search() !== this.value) {
                tablaAutorizacion
                    .column(i)
                    .search(this.value)
                    .draw();

                var index = tablaAutorizacion.rows({
                    selected: true,
                    search: 'applied'
                }).indexes();
            }
        });
    });
 
    tablaAutorizacion = $("#autorizacionesPVentas").DataTable({
        dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: 'auto',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Descargar archivo de Excel',
            title: 'AUTORIZACIONES PLANES DE VENTAS',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                format: {
                    header:  function (d, columnIdx) {
                        return titulos[columnIdx];
                    }
                }
            },
        } ],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{  
            "width": "2%",
            "data": function( d ){
                return '<p class="m-0">'+d.id_autorizacion+'</p>';
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0"><span class="">${d.sede}</span></p>`;
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return '<p class="m-0"><span class="label" style="background:'+d.idResidencial+';"></span></p>';
            }
        },
        {  
            "width": "10%",
            "data": function( d ){
                return `<p class="m-0"><b>${d.fecha_inicio}</b></p>`;
            }
        },
        {
            "width": "15%",
            "data": function( d ){
                return '<p class="m-0"><b>'+d.fecha_fin+'</b></p>';
            }
        },
        {
            "width": "10%",
            "data": function( d ){
                return '<p class="m-0">'+d.tipoLote+'</p>';
            }
        },
        {  
            "width": "5%",
            "data": function( d ){
                    return '<p class="m-0">'+d.superficie+'</p>';
                
            }
        },
        {
            "width": "5%",
            "data": function( d ){
                    return '<p class="m-0"><span class="label" style="background:#48C9B0;">'+d.estatus_autorizacion+'</span></p>';
                
            }
        },
        {  
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0"><span class="label" style="background:#48C9B0;">'+d.estatus+'</span></p>';
            
        }
        },
        {
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0">'+d.fecha_creacion.split('.')[0]+'</p>';
            
        }
        },
        {  
            "width": "5%",
            "data": function( d ){
                return '<p class="m-0"><span class="label" style="background:#48C9B0;">'+d.creadoPor+'</span></p>';
            
             }
        },
        {  
            "width": "5%",
            "data": function( d ){
                $('[data-toggle="tooltip"]').tooltip();
                let botones = '';
                switch(id_rol_general){
                    case 5:
                        if(d.estatus == 1){
                            botones += botonesPermiso(1,1,1,0,d.id_autorizacion);
                        }
                    break;
                    case 17:
                        if(d.estatus == 2){
                            botones += botonesPermiso(1,0,1,1,d.id_autorizacion);
                        }
                        if(d.estatus == 3){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion);
                        }
                        if(d.estatus == 4){
                            botones += botonesPermiso(1,0,0,0,d.id_autorizacion);
                        }
                    break;
                }
                botones += `<button data-idAutorizacion="${d.id_autorizacion}" id="btnHistorial" class="btn-data btn-danger" data-toggle="tooltip" data-placement="top" title="Historial"><i class="fas fa-info"></i></button>`; ;
                return '<div class="d-flex justify-center">' + botones + '<div>';
            
             }
        }],
        columnDefs: [{}],
        ajax: {
            "url": general_base_url + "PaquetesCorrida/getAutorizaciones",
            "type": "POST",
            cache: false,
            "data": function(d) {}
        },
        order: [
            [1, 'asc']
        ]
    });
});

function botonesPermiso(permisoVista,permisoEditar,permisoAvanzar,permisoRechazar,idAutorizacion){
    let botones = '';
    /**Permisos
     * 1.- vista
     * 2.- Editar
     * 3.- Avanzar
     * */
        if(permisoVista == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnVer" class="btn-data btn-info" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></button>`;   }
        if(permisoEditar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnEditar" class="btn-data btn-warninf" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pencil"></i></button>`; }
        if(permisoAvanzar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnAvanzar" class="btn-data btn-success" data-toggle="tooltip" data-placement="top" title="Avanzar"><i class="fas fa-ok"></i></button>`;  }
        if(permisoRechazar == 1){ botones += `<button data-idAutorizacion="${idAutorizacion}" id="btnRechazar" class="btn-data btn-danger" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-trash"></i></button>`;  }
      return  botones;
    }

    $(document).on('click', '#btnAvanzar', function () {
        var data = tablaAutorizacion.row($(this).parents('tr')).data();    
        let idAutorizacion = $(this).attr('data-idAutorizacion');
       // alert(idAutorizacion);
        $("#avanzarAut").modal();

    });
    