let v;
let v2;

$("#file-upload").on('change', function(e){ 
    v = document.getElementById("file-upload").files[0].name; 
    let p = document.getElementById("archivo");
    document.getElementById("archivo").style.color = "black";
    p.innerHTML = v;
});

$("#file-uploadE").on('change', function(e){ 		
    v2 = document.getElementById("file-uploadE").files[0].name; 
    let a = document.getElementById("archivoE");
    document.getElementById("archivoE").style.color = "black";
    a.innerHTML = v2;
});

$("#nombre").keypress(function(){
    document.getElementById("nom").innerHTML ='';
});

$("#btnsave").on('click', function(e){ 
    if ($('#nombre').val().length == 0 && v == "" || v == undefined) {
        document.getElementById("nom").innerHTML ='Requerido';
        document.getElementById("archivo").innerHTML ='Requerido';	  
    }
    else if ($('#nombre').val().length != 0 && v == "" || v == undefined) {
        document.getElementById("archivo").innerHTML ='Requerido';	   
    }
    else if ($('#nombre').val().length == 0 && v !== "" && v !== undefined) {
        document.getElementById("nom").innerHTML ='Requerido';
    }
    else if($('#nombre').val().length != 0 && v !== "" && v !== undefined){
        save();
    }
}); 

function save() {
    var formData = new FormData(document.getElementById("formAdmin"));
    formData.append("dato", "valor");
    $.ajax({
        type: 'POST',
        url: 'saveCarpetas',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $("#carpetas").modal('hide');
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                $tableCarpetas.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

typeTransaction = 1;
$(document).ready(function () {
    $('#tableCarpetas thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if ($('#tableCarpetas').DataTable().column(i).search() !== this.value ) {
                $('#tableCarpetas').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    $tableCarpetas = $('#tableCarpetas').DataTable({
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            { 
                data: function (d) {
                    return d.id_archivo;
                }
            },
            { 
                data: function (d) {
                    return d.nombre;
                }
            },
            { 
                data: function (d) {
                    return d.descripcion;
                }
            },
            { 
                data: function (d) {
                    return d.archivo;
                }
            },
            { 
                data: function (d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label lbl-green">Activo</span><center>';
                    } else {
                        return '<center><span class="label lbl-warning">Inactivo</span><center>';
                    }
                }
            },
            { 
                data: function (d) {
                    return d.usuario;
                }
            },
            { 
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            { 
                data: function (d) {
                    return d.fecha_modificacion;
                }
            },
            { 
                data: function (d) {
                    return id_rol_general == 53 ? "N/A" : '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas editarCarpeta" data-id-carpeta="' + d.id_archivo +'"><i class="fas fa-pencil-alt"></i></button><button class="btn-data btn-deepGray preview" data-id-carpeta="' + d.id_archivo +'"><i class="far fa-eye"></i></button></div>';
                }
            }
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }],
        ajax: {
            "url": "getCarpetas",
            "type": "POST",
            cache: false,
            "data": function( d ){
            }
        },
    });

    $(document).on('click', '.editarCarpeta', function(e){
        $('#spiner-loader').removeClass('hide');
        id_carpeta = $(this).attr("data-id-carpeta");
        $.getJSON("getInfoCarpeta/"+id_carpeta).done( function( data ){
            $('#spiner-loader').addClass('hide');
            $.each( data, function(i, v){
                $("#carpetasE").modal();
                fillFields(v);
            });
        });
    });

    $(document).on('click', '.preview', function(e){
        id_carpeta = $(this).attr("data-id-carpeta");
        $.getJSON("getInfoCarpeta/"+id_carpeta).done( function( data ){
            $.each( data, function(i, v){
                $("#carpetasP").modal();
                var htmlModalPreview = '';
                var url_file = general_base_url + 'static/documentos/carpetas/'+v.archivo;
                var embebed_code = '<embed src="'+url_file+'#toolbar=0" frameborder="0" width="100%" height="400em">';
                htmlModalPreview += '<h3>'+ v.nombre + ': ' + v.descripcion + '</h3>';
                htmlModalPreview += ' ' + embebed_code;
                $('#carpetasP').find('.modal-header').html(htmlModalPreview);
            });
        });
    });

    function fillFields (v) {
        $("#idCarpeta").val(v.id_archivo);
        $("#nombreE").val(v.nombre);
        document.getElementById("archivoE").innerHTML = v.archivo;
        $("#descripcionE").val(v.descripcion);
        $("#filename").val(v.archivo);
        $("#estatus").val(v.estatus);
    }
});

function update() {
    let val=0;
    if (v2 == undefined) {
        val =1;
    }
    else{
        val=2;
    }

    var formData = new FormData(document.getElementById("formAdminE"));
    formData.append("dato", "valor");
    $.ajax({
        type: 'POST',
        url: 'updateCarpetas/'+val,
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            if (data == 1) {
                $("#carpetasE").modal('hide');
                alerts.showNotification("top", "right", "El registro se actualizo exitosamente.", "success");
                $tableCarpetas.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}