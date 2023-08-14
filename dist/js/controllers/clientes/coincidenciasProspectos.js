$(document).ready(function () {
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});

let titulos = [];
$('#prospectscon_datatable thead tr:eq(0) th').each(function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $( 'input', this).on('keyup change', function () {
        if ($('#prospectscon_datatable').DataTable().column(i).search() !== this.value) {
            $('#prospectscon_datatable').DataTable().column(i).search(this.value).draw();
        }   
    });
});

async function processFile(selectedFile) {
    try {
        let arrayBuffer = await readFileAsync(selectedFile);
        return arrayBuffer;
    } catch (err) {
        console.log(err);
    }
}

function readFileAsync(selectedFile) {
    return new Promise((resolve, reject) => {
        let fileReader = new FileReader();
        fileReader.onload = function (event) {
            var data = event.target.result;
            var workbook = XLSX.read(data, {
                type: "binary"
            });

            workbook.SheetNames.forEach(sheet => {
                rowObject = JSON.stringify(XLSX.utils.sheet_to_json(workbook.Sheets[sheet], { header: 0, defval: '', blankrows: true }));
                // jsonProspectos = JSON.stringify(rowObject, null);
            });
            resolve(rowObject);
        };
        fileReader.onerror = reject;
        fileReader.readAsArrayBuffer(selectedFile);
    })
}

$(document).on('click', '#cargaCoincidencias', function (){
    checked = $("input[type=checkbox]:checked").length;
    fileElm = document.getElementById("fileElm");
    if ( checked > 0 &&  fileElm.value != ''){
        processFile(fileElm.files[0]).then(jsonProspectos => {
            var checks = [];
            $('input[name^="checks"]:checked').each(function() {
                checks.push($(this).val());
            });
            if($("#anio").val()=='' ){
                alerts.showNotification('top', 'right', 'Debes seleccionar un año', 'warning');
            }else{
                // MJ: SE AGREGÓ EL AÑO AL ARRAY DE CHECKS
                checks.push("anio");
                updateTable(checks, jsonProspectos, $("#anio").val());
                $('#prospectscon_datatable').removeClass('hide');
            }
            
        });
    }
    else{
        $('#notificacion').modal('show');
    }
});

function updateTable(checks, jsonProspectos, anio){
    prospectsTable = $('#prospectscon_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title:'Coincidencias de prospectos',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4,5,6,7,8,9,10],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        bAutoWidth: true,
        destroy: true,
        ordering: false,
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        columns: [{
            data: function (d) {
                return d.idLote;
            }
        },
        {
            data: function (d) {
                return d.nombreLote;
            }
        },
        {
            data: function (d) {
                return d.nombre;
            }
        },
        {
            data: function (d) {
                return d.telefono1;
            }
        },
        {
            data: function (d) {
                return d.correo;
            }
        },
        {
            data: function (d) {
                return d.fechaApartado;
            }
        },
        {
            data: function (d) {
                if(d.descuento_mdb == 1)
                    return d.nombre_lp + ' MDB';
                else
                    return d.nombre_lp
            }
        },
        {
            data: function (d) {
                return d.nombreAsesor;
            }
        },
        {
            data: function (d) {
                return d.nombreGerente;
            }
        },
        {
            data: function (d) {
                return d.sede;
            }
        },
        {
            data: function (d) {
                return d.nombreEstatus;
            }
        }],
        ajax: {
            url: 'filterProspectos',
            type: "POST",
            cache: false,
            data : {
                "checks": checks,
                "anio": anio,
                "jsonProspectos": jsonProspectos
            }
        }
    });
}
