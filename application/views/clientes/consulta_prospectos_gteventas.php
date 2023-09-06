<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Listado general de prospectos</h3>
                            <div class="toolbar">
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="mktdProspectsTable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ESTADO</th>
                                                    <th>ETAPA</th>
                                                    <th>PROSPECTO</th>
                                                    <th>MEDIO</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>SUBDIRECTOR</th>
                                                    <th>DIRECTOR REGIONAL</th>
                                                    <th>DIRECTOR REGIONAL 2</th>
                                                    <th>CREACIÓN</th>
                                                    <th>VENCIMIENTO</th>
                                                    <th>ÚLTIMA MODIFICACIÓN</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php include 'common_modals.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/mktd-1.1.0.js"></script>

<script>
    var mktdProspectsTable
    $(document).ready(function () {





$('#mktdProspectsTable thead tr:eq(0) th').each( function (i) {

      if(i != 12){
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
        $( 'input', this ).on('keyup change', function () {
            if (mktdProspectsTable.column(i).search() !== this.value ) {
                mktdProspectsTable
                .column(i)
                .search(this.value)
                .draw();
            }
        } );
    }
});
/*---INPUT SEARCH-----*/

         mktdProspectsTable = $('#mktdProspectsTable').DataTable({
             dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
             buttons: [{
                 extend: 'excelHtml5',
                 text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                 className: 'btn buttons-excel',
                 titleAttr: 'Listado general de prospectos' ,
                 title: 'Listado general de prospectos'  ,
                 exportOptions: {
                     columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                     format: {
                         header: function (d, columnIdx) {
                             switch (columnIdx) {
                                 case 0:
                                     return 'ESTADO';
                                 case 1:
                                     return 'ETAPA';
                                 case 2:
                                     return 'PROSPECTO';
                                 case 3:
                                     return 'MEDIO';
                                 case 4:
                                     return 'ASESOR';
                                 case 5:
                                     return 'GERENTE';
                                 case 6:
                                     return 'SUBDIRECTOR';
                                 case 7:
                                     return 'DIRECTOR REGIONAL';
                                 case 8:
                                     return 'DIRECTOR REGIONAL 2';
                                 case 9:
                                     return 'CREACIÓN';
                                 case 10:
                                     return 'VENCIMIENTO';
                                 case 11:
                                     return 'ÚLTIMA MODIFICACIÓN';
                             }
                         }
                     }
                 }
             }],
             pagingType: "full_numbers",
             lengthMenu: [
                 [10, 25, 50, -1],
                 [10, 25, 50, "Todos"]
             ],
             language: {
                 url: "../static/spanishLoader_v2.json",
                 paginate: {
                     previous: "<i class='fa fa-angle-left'>",
                     next: "<i class='fa fa-angle-right'>"
                 }
             },
             columnDefs: [{
                 defaultContent: "Sin especificar",
                 targets: "_all",
                 searchable: true,
                 orderable: true
             }],
             destroy: true,
             ordering: true,
            columns: [
               { data: function (d) {
                  

                    if (d.estatus == 1) {
                            return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                            } else {
                            return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                            }
                        }
                
            },
            { data: function (d) {
                    if(d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                    } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                    } else if (d.estatus_particular == 3){ // CON CITA
                        b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                    } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                        b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                    } else if (d.estatus_particular == 5){ // PAUSADO
                        b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                    } else if (d.estatus_particular == 6){ // PREVENTA
                        b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                    }

                    return b;
                }
            },
                { data: function (d) {
                        return d.nombre + '<br>' +'<span class="label" style="background:#1ABC9C">'+ d.id_prospecto +'</span>';
                    }
                },
                { data: function (d) {
                        return d.otro_lugar;
                    }
                },
                { data: function (d) {
                        return d.asesor;
                    }
                },
                { data: function (d) {
                        return d.gerente;
                    }
                },
                {
                    data: function (d) {
                        return (d.subdirector === '  ') ? 'SIN ESPECIFICAR' : d.subdirector;
                    }
                },
                {
                    data: function (d) {
                        return (d.regional === '  ') ? 'SIN ESPECIFICAR' : d.regional;
                    }
                },
                {
                    data: function (d) {
                        return (d.regional_2 === '  ') ? 'SIN ESPECIFICAR' : d.regional_2;
                    }
                },
                { data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                { data: function (d) {
                        return d.fecha_vencimiento;
                    }
                },
                { data: function (d) {
                        return d.fecha_modificacion;
                    }
                },
                {
                data: function(d) {
                    return '<div class="d-flex justify-center"><button class="btn-data btn-details-grey see-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ver información"><i class="fas fa-eye"></i></button></div>';
                }
            }
            ],
            "ajax": {
                "url": "getProspectsSalesTeam",
                "type": "POST",
                cache: false,
                "data": function( d ){
                }
            }
        });

    });

$(document).on('click', '.see-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    $("#prospecto_lbl").val(id_prospecto);

    $.getJSON("getInformationToPrint/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillFields(v, 1);
        });
    });

    $.getJSON("getComments/" + id_prospecto).done(function(data) {
        counter = 0;
        $.each(data, function(i, v) {
            counter++;
            fillTimeline(v, counter);
        });
    });

    $.getJSON("getChangelog/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillChangelog(v);
        });
    });

});

function fillFields(v, type) {
    /*
     * 0 update prospect
     * 1 see information modal
     * 2 update reference
     */
    if (type == 0) {
        $("#nationality").val(v.nacionalidad);
        $("#legal_personality").val(v.personalidad_juridica);
        $("#curp").val(v.curp);
        $("#rfc").val(v.rfc);
        $("#name").val(v.nombre);
        $("#last_name").val(v.apellido_paterno);
        $("#mothers_last_name").val(v.apellido_materno);
        $("#date_birth").val(v.fecha_nacimiento);
        $("#email").val(v.correo);
        $("#phone_number").val(v.telefono);
        $("#phone_number2").val(v.telefono_2);
        $("#civil_status").val(v.estado_civil);
        $("#matrimonial_regime").val(v.regimen_matrimonial);
        $("#spouce").val(v.conyuge);
        $("#from").val(v.originario_de);
        $("#home_address").val(v.domicilio_particular);
        $("#occupation").val(v.ocupacion);
        $("#company").val(v.empresa);
        $("#position").val(v.posicion);
        $("#antiquity").val(v.antiguedad);
        $("#company_antiquity").val(v.edadFirma);
        $("#company_residence").val(v.direccion);
        $("#prospecting_place").val(v.lugar_prospeccion);
        $("#advertising").val(v.medio_publicitario);
        $("#sales_plaza").val(v.plaza_venta);
        $("#observation").val(v.observaciones);
        if (v.tipo_vivienda == 1) {
            document.getElementById('own').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 2) {
            document.getElementById('rented').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 3) {
            document.getElementById('paying').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 4) {
            document.getElementById('family').setAttribute("checked", "true");
        } else {
            document.getElementById('other').setAttribute("checked", "true");
        }

        pp = v.lugar_prospeccion;
        console.log(pp);
        if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
            $("#specify").val(v.otro_lugar);
        } else if (pp == 6) { // SPECIFY MKTD OPTION
            document.getElementById('specify_mkt').value = v.otro_lugar;
        } else if (pp == 21) { // RECOMMENDED SPECIFICATION
            document.getElementById('specify_recommends').value = v.otro_lugar;
        } else { // WITHOUT SPECIFICATION
            $("#specify").val("");
        }

    } else if (type == 1) {
        $("#nationality-lbl").val(v.nacionalidad);
        $("#legal-personality-lbl").val(v.personalidad_juridica);
        $("#curp-lbl").val(v.curp);
        $("#rfc-lbl").val(v.rfc);
        $("#name-lbl").val(v.nombre);
        $("#last-name-lbl").val(v.apellido_paterno);
        $("#mothers-last-name-lbl").val(v.apellido_materno);
        $("#email-lbl").val(v.correo);
        $("#phone-number-lbl").val(v.telefono);
        $("#phone-number2-lbl").val(v.telefono_2);
        $("#prospecting-place-lbl").val(v.lugar_prospeccion);
        $("#specify-lbl").html(v.otro_lugar);
        $("#sales-plaza-lbl").val(v.plaza_venta);
        $("#comments-lbl").val(v.observaciones);
        $("#asesor-lbl").val(v.asesor);
        $("#coordinador-lbl").val(v.coordinador);
        $("#gerente-lbl").val(v.gerente);
        $("#phone-asesor-lbl").val(v.tel_asesor);
        $("#phone-coordinador-lbl").val(v.tel_coordinador);
        $("#phone-gerente-lbl").val(v.tel_gerente);

    } else if (type == 2) {
        $("#prospecto_ed").val(v.id_prospecto).trigger('change');
        $("#prospecto_ed").selectpicker('refresh');
        $("#kinship_ed").val(v.parentesco).trigger('change');
        $("#kinship_ed").selectpicker('refresh');
        $("#name_ed").val(v.nombre);
        $("#phone_number_ed").val(v.telefono);
    }
}

function fillTimeline(v) {
    $("#comments-list").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge info"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.creador + '</h6></label>\n' +
        '            <br>' + v.observacion + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

function fillChangelog(v) {
    $("#changelog").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge success"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.parametro_modificado + '</h6></label><br>\n' +
        '            <b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + ' - ' + v.creador + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list');
    myCommentsList.innerHTML = '';

    var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

</script>

</html>
