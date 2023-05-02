$(document).ready(function () {
    
    let titulos_intxt = [];
 
    $('#tabla_retiros_resguardo thead tr:eq(0) th').each( function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        if (i != 7) {
            $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_retiros_resguardo').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_retiros_resguardo').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_retiros_resguardo').DataTable().rows({
                selected: true,
                search: 'applied'
            }).indexes();
            var data = $('#tabla_retiros_resguardo').DataTable().rows(index).data();
        });
    }});
    var id_user = id_usuario_general == 1875 ? 2 : id_usuario_general;
    
    dispersionDataTable = $('#tabla_retiros_resguardo').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'Reporte Comisiones Dispersion',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header:  function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                            }
                        }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        scrollX: true,
        destroy: true,
        ordering: false,
        columns: [

            {data: 'id_rc'},
            {data: 'usuario'},
            {data: 'monto'},
            {data: 'conceptos'},
            { data: function (d) {
                var labelEstatus;
                if(d.estatus == 1) {
                    labelEstatus ='<span class="label" style="color:#186A3B;background:#ABEBC6;">ACTIVO</span>';
                }else if(d.estatus == 2) {
                    labelEstatus ='<span class="label" style="color:#78281F;background:#F5B7B1;">CANCELADO</span>';
                }else if(d.estatus == 3) {
                    labelEstatus ='<span class="label" style="color:#512E5F;background:#D7BDE2;">APROBADO</span>';
                }else if(d.estatus == 4) {
                    labelEstatus ='<span class="label" style="color:#78281F;background:#F5B7B1;">RECHAZADO DIRECTIVO</span>';
                }else if(d.estatus == 67) {
                    labelEstatus ='<span class="label" style="color:#7D6608;background:#F9E79F;">INGRESO EXTRA</span>';
                }else {
                    labelEstatus ='<span class="label" style="color:#626567;background:#E5E7E9;">Sin Definir</span>';
                }
                return labelEstatus;
            }}, 
            {data: 'creado_por'}, 
            { data: function (d) {
                var fecha = d.fecha_creacion.substring(0, d.fecha_creacion.length - 4);
                return fecha;
            }},
            { data: function (d) {
                var BtnStats = '';
                if(id_user == 1875 ){
                    if(d.estatus == 3 || d.estatus == 4 || d.estatus == 2){
                        BtnStats = `<button class="btn-data btn-blueMaderas btn-log" value="${d.id_rc}" title="LOG"><i class="fas fa-info"></i></button>`;
                    } 
                } else{
                    if(d.estatus == 1){
                        BtnStats = `<button class="btn-data btn-warning btn-delete" value="'+d.id_rc+','+d.monto+','+d.usuario+'" title="RECHAZAR RETIRO"><i class="fas fa-trash"></i></button><button class="btn-data btn-green btn-aut" value="${d.id_rc},${d.monto},${d.usuario}" title="APROBAR RETIRO"><i class="fas fa-check"></i></button>`;

                    } else if(d.estatus == 3 || d.estatus == 4 || d.estatus == 2){
                        BtnStats = `<button class="btn-data btn-blueMaderas btn-log" value="${d.id_rc}" title="LOG"><i class="fas fa-info"></i></button>`;
                    } 
                }
                return '<div class="d-flex justify-center">'+BtnStats+'</div>';
            }}   
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: 'getRetiros/'+id_user+'/'+1,   
            type: "POST",
            cache: false,
            data: function( d ){}
        }
    }) 


    $("#tabla_retiros_resguardo tbody").on("click", ".btn-log", function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        id_rc = $(this).val();

        $("#seeInformationModalRetiros").modal();
        $.getJSON(url+"Resguardos/getListaRetiros/"+id_rc, function (data) {
            $.each( data, function(i, v){
                $("#comments-list-retiros").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_creacion+'</b><b style="color:gray;"> - '+v.usuario+'</b></p></div>');
            });
        });
    });

    function cleanCommentsRetiros() {
        var myCommentsList = document.getElementById('comments-list-retiros');
        myCommentsList.innerHTML = '';
    }


    $("#tabla_retiros_resguardo tbody").on("click", ".btn-aut", function(){
        var tr = $(this).closest('tr');
        var row =  $('#tabla_retiros_resguardo').DataTable().row(tr);

        id_pago_i = $(this).val();

        $("#modal_nuevas .modal-body").html("");
        $("#modal_nuevas .modal-header").html("");
        $("#modal_nuevas .modal-header").append(`<h3>Autorizar</h3>`);
        $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p><h5>¿Seguro que desea autorizar a <b>'+row.data().usuario+'</b> la cantidad de <b style="color:red;">$'+formatMoney(row.data().monto)+'</b>?</h5><input type="hidden" name="id_descuento" id="id_descuento" value="'+row.data().id_rc+'"><input type="hidden" name="opcion" id="opcion" value="Autorizar"><br><div></p></div></div>');
        $("#modal_nuevas").modal();
    });
 
});