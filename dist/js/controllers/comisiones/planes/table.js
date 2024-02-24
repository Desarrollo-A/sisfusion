class AskDialog{
    constructor({title, text, onOk, onCancel}) {
        this.title = title
        this.text = text
        this.onOk = onOk
        this.onCancel = onCancel
    }
    handleOk(){
        if(this.onOk){
            this.onOk()
        }
        $("#alert-modal").modal('hide');
    }
    show(){
        $('#title-alert-modal').text(this.title)
        $('#text-alert-modal').text(this.text)
        $('#ok-button-alert-modal').off('click')
        $('#ok-button-alert-modal').on('click', () => this.handleOk())
        $("#alert-modal").modal();
    }
}

class TableButton {
    constructor({id, label, icon, color, onClick, data}) {
        this.id = id || ''
        this.label = label || ''
        this.icon = icon || ''
        this.color = color || 'btn-blueMaderas'
        this.onClick = onClick
        this.data = data
    }
    toString() {
        const button = $('<button />')
        .addClass(`btn-data ${this.color}`)
        .attr('id', this.id)
        .attr('data-toggle', 'tooltip')
        .attr('data-placement', 'top')
        .attr('title', this.label.toUpperCase())
        .append(
            $('<i />')
            .addClass('material-icons')
            .text(this.icon)
        )

        if(this.onClick){
            button.attr('onClick', `${this.onClick.name}(${JSON.stringify(this.data)})`)
        }

        return button.prop('outerHTML')
    }
}

let dispersionDataTable;

$(document).ready(function () {
    getDataSelect('sede', `${general_base_url}planes/sedes`);
    getDataSelect('residencial', `${general_base_url}planes/residenciales`);
    getDataSelect('prospeccion', `${general_base_url}planes/prospecciones`);

    $("#plan-modal").modal();

    let titulos_intxt = [];

    const tabla_planes_comisiones = $('#tabla_planes_comisiones thead tr:eq(0) th').each(function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos_intxt.push(title);
        if (i != 0) {
            $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_planes_comisiones').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_planes_comisiones').DataTable().column(i).search(this.value).draw();
                }
                var index = $('#tabla_planes_comisiones').DataTable().rows({
                    selected: true, 
                    search: 'applied' 
                    }).indexes();
                var data = $('#tabla_planes_comisiones').DataTable().rows(index).data();
            });
        }
    });

    dispersionDataTable = $('#tabla_planes_comisiones').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: 'Reporte planes de comision',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
            },
            {
                text: '<i class="fa fa-check"></i> NUEVO PLAN',
                action: function() {
                    console.log('Nuevo plan click')
                    $("#plan-modal").modal();
                },
                attr: {
                    class: 'btn btn-azure',
                    style: 'position: relative; float: right',
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
        destroy: true,
        ordering: false,
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data : null,
                defaultContent: '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i></div>'
            },
            {data: 'idPlan'},
            {data: 'nombre'},
            { 
                data: function (d) {
                    const date = new Date(d.fechaActualizado)
                    const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };

                    return `<span class="label lbl-azure">${date.toLocaleDateString('es-MX', options)}</span>`
                }
            },
            {data: 'prioridad'},
            { //STATUS
                data: function (d) {
                    if(d.estatus == 1){
                        return '<span class="label label-success">Activo</span>'
                    }else{
                        return '<span class="label label-default">Inactivo</span>'
                    }
                }
            },
            { //ACTIONS
                data: function (data) {
                    const subir_prioridad = new TableButton({label: 'subir prioridad', icon: 'arrow_upward', color: 'btn-deepGray', onClick: subirPrioridad, data})
                    const bajar_prioridad = new TableButton({label: 'bajar prioridad', icon: 'arrow_downward', color: 'btn-deepGray', onClick: bajarPrioridad, data})
                    const editar_plan = new TableButton({label: 'editar plan', icon: 'edit', color: 'btn-blueMaderas', onClick: editPlan, data: data})
                    
                    let toggle_plan = new TableButton({label: 'activar plan', icon: 'play_arrow', color: 'btn-green', onClick: enablePlan, data: data})
                    if(data.estatus == 1){
                        toggle_plan = new TableButton({label: 'desactivar plan', icon: 'pause', color: 'btn-yellow', onClick: disablePlan, data: data})
                    }

                    return `<div class="d-flex justify-center">${subir_prioridad}${bajar_prioridad}${editar_plan}${toggle_plan}</div>`
                }
            }
        ],
        columnDefs: [
            {
                visible: false,
                searchable: false
            }
        ],
        ajax: {
            url: `${general_base_url}planes/list`,
            type: "GET",
            cache: false,
            data: function( d ){}
        }
    })

    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-remove',
            inline: true
        }
    });

    $('#btn_add_usuario_comision').on('click', function() {
        let id_usuario = $('#id_usuario').val();

        getUserComisionando(id_usuario);
    });

    $('#tabla_planes_comisiones tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dispersionDataTable.row(tr);

        if (row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
            $(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
        } else {
            let esquema = ''
            let condiciones = ''

            if(row.data().fechaInicio){
                condiciones += `${row.data().fechaInicio}<br>`
            }
            if(row.data().fechaFin){
                condiciones += `${row.data().fechaFin}<br>`
            }
            if(row.data().prospeccion_list){
                condiciones += `prospeccion: ${row.data().prospeccion_list}<br>`
            }
            if(row.data().sedes_list){
                condiciones += `sedes: ${row.data().sedes_list}<br>`
            }

            var html = `<div class="container subBoxDetail">
                <div class="row">
                    <div class="col-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                        <label>
                            <b>
                                Esquema de comisiones
                            </b>
                        </label>
                        <br>
                        ${esquema}
                    </div>
                    <div class="col-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                        <label>
                            <b>
                                condiciones del plan
                            </b>
                        </label>
                        <br>
                        ${condiciones}
                    </div>
                </div>
            </div>`
            row.child(html).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        }
    })

    $('#ok-button-plan-modal').on('click', function(){
        $( "#form-plan-modal" ).trigger( "submit" );
    })

    $( "#form-plan-modal" ).on( "submit", function( event ) {
        event.preventDefault()

        let data = {
            nombre: new FormData(event.target).get('nombre'),
            prospeccion: new FormData(event.target).getAll('prospeccion').toString(),
        }

        console.log(data)

        $.post( `${general_base_url}planes/insertar`, data)
            .done(function( response ) {
                console.log( "Data Loaded: " + response );

                $("#plan-modal").modal('hide');

                dispersionDataTable.ajax.reload()
        });
    });

})

function editPlan(data){
    console.log(data)

    //$("#alert-modal").modal();
}

function subirPrioridad(data){
    let title = 'Subir prioridad'
    let text = `¿Desea subir la prioridad en el plan ${data.nombre}?`
    let enable = function(){
        $.getJSON( `${general_base_url}planes/subir?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }
    
    let alert = new AskDialog({title: title, text: text, onOk: enable})

    alert.show()
}

function bajarPrioridad(data){
    let title = 'Bajar prioridad'
    let text = `¿Desea bajar la prioridad en el plan ${data.nombre}?`
    let enable = function(){
        $.getJSON( `${general_base_url}planes/bajar?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }
    
    let alert = new AskDialog({title: title, text: text, onOk: enable})

    alert.show()
}

function enablePlan(data){
    let title = 'Activar plan'
    let text = `¿Desea activar el plan ${data.nombre}?`
    let enable = function(){
        $.getJSON( `${general_base_url}planes/enable?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }
    
    let alert = new AskDialog({title: title, text: text, onOk: enable})

    alert.show()
}

function disablePlan(data){
    let title = 'Desactivar plan'
    let text = `¿Desea desactivar el plan ${data.nombre}?`

    let alert = new AskDialog({title: title, text: text})

    alert.onOk = function(){
        $.getJSON( `${general_base_url}planes/disable?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }

    alert.show()
}

function tableButton(id, label='', icon='', color='btn-blueMaderas', method=null, data=null){
    const button = $('<button />')
        .addClass(`${id} btn-data ${color}`)
        .attr('id', id)
        .attr('data-toggle', 'tooltip')
        .attr('data-placement', 'top')
        .attr('title', label.toUpperCase())
        .append(
            $('<i />')
            .addClass('material-icons')
            .text(icon)
        )

    if(method){
        button.attr('onClick', `${method.name}(${JSON.stringify(data)})`)
    }

    return button.prop('outerHTML')
}

function getUserComisionando(id_usuario){
    $.getJSON( `${general_base_url}planes/usuario?id_usuario=${id_usuario}` )
    .done(function( data ) {
        let id = data.id_usuario
        let nombre = `${data.nombre} ${data.apellido_paterno} ${data.apellido_materno}`

        addUsuarioPlanComision(id, nombre)
    })
}

function getDataSelect(element, url){
    $.getJSON( url )
    .done(function( data ) {
        $.each( data, function( i, item ) {
            $(`#${element}`).append($('<option>').val(item.id).text(item.label.toUpperCase()));
            $(`#${element}`).selectpicker('refresh');
        })
    })
}

function addUsuarioPlanComision(id, nombre){
    $('#usuarios_plan_comisiones').append(
        $('<div />')
        .addClass('col-md-12')
        .append(
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<div />')
                .addClass('form-group')
                .append(
                    $('<input />')
                    .attr('type', 'text')
                    .addClass('form-control input-gral')
                    .val(nombre)
                )
            ),
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<div />')
                .addClass('form-group')
                .append(
                    $('<input />')
                    .attr('type', 'text')
                    .addClass('form-control input-gral')
                    .val(1)
                )
            ),
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<button />')
                .addClass('btn btn-primary')
                .text('Eliminar')
            )
        )
    )
}