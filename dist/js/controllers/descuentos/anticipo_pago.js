$(document).ready(function () {
    loadTable()

    $("#file_adelanto").change(function(){
        // Verifica si se seleccionó un archivo
        if($(this).val() !== ""){
            // Muestra el contenedor de evidencia
            $("#evidenciaContainer").show();
        }
    });

});



function loadTable() {
    $('#tabla-anticipo').ready(function () {
        $('#tabla-anticipo').on('xhr.dt', function (e, settings, json, xhr) {
            var general = 0;
            var recaudado = 0;
            var caja = 0;
            var pendiente = 0;

            $.each(json.data, function (i, v) {
                general += parseFloat(v.monto);
                recaudado += parseFloat(v.total_descontado);
                caja += parseFloat(v.pagado_caja);
            });
            pendiente = (general-recaudado-caja);
        });

        tablaGeneral = $('#tabla-anticipo').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Reporte Descuentos Universidad',
            exportOptions: {
                columns: [0, 1, 2],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        }],
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
        destroy: true,
        ordering: false,
        columns:[{
                "data": function (d) {
                return d.nombre;
            }},
            {"data": function (d) {
                return d.id_prestamo;
            }},
            {"data": function (d) {
                return d.id_usuario;
            }},
            {"data": function (d) {
                return d.id_usuario;
            }}
        ],
                "ajax": {
                "url": `getPrestamos/`,
                "type": "GET",
                cache: false,
                "data": function (d) {}
            }
        });

    })}
    var checkbox = document.getElementById('checkbox');
    checkbox.addEventListener("change", validaCheckbox, false);
    function validaCheckbox()
    {
    var checked = checkbox.checked;
    if(checked){
        alert('falso');
    }else{
        alert('true');
    }
    }


$("#file_adelanto").on('change', function () {
    $('#archivo-extranjero').val('');
    v2 = document.getElementById("file_adelanto").files[0].name;
    document.getElementById("archivo-extranjero").innerHTML = v2;
    const src = URL.createObjectURL(document.getElementById("file_adelanto").files[0]);
    $('#preview-div').html("");
    $('#preview-div').append(`<embed src="${src}" width="500" height="600">`);
});