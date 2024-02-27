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
        $("#ask-modal").modal('hide');
    }
    show(){
        $('#title-ask-modal').text(this.title)
        $('#text-ask-modal').html(this.text)
        $('#ok-button-ask-modal').off('click')
        $('#ok-button-ask-modal').on('click', () => this.handleOk())
        $("#ask-modal").modal();
    }
}

class AlertDialog{
    constructor({title, text}) {
        this.title = title
        this.text = text
    }
    show(){
        $('#title-alert-modal').text(this.title)
        $('#text-alert-modal').html(this.text)
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

let defaults = {
    estatus: 1,
    prioridad: 0,
    comision_director: 1,
    comision_regional: 1,
    comision_subdirector: 1,
    comision_gerente: 1,
    comision_coordinador: 1,
    comision_asesor: 3,
    usuarios: []
}

$(document).ready(function () {
    getDataSelect('sedes', `${general_base_url}planes/sedes`);
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
                    editPlan(defaults)
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
                    const date = new Date(d.fechaModificacion)
                    date.setTime( date.getTime() + date.getTimezoneOffset()*60*1000 )

                    const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };

                    return `<span class="label lbl-azure">${date.toLocaleDateString('es-MX', options)}</span>`
                }
            },
            { //STATUS
                data: function (d) {
                    if(d.estatus == 1){
                        return '<span class="label label-success">Funcionando</span>'
                    }else{
                        return '<span class="label label-default">Inactivo</span>'
                    }
                }
            },
            {data: 'prioridad'},
            { //ACTIONS
                data: function (data) {
                    const subir_prioridad = new TableButton({label: 'subir prioridad', icon: 'arrow_upward', color: 'btn-azure', onClick: subirPrioridad, data})
                    const bajar_prioridad = new TableButton({label: 'bajar prioridad', icon: 'arrow_downward', color: 'btn-azure', onClick: bajarPrioridad, data})
                    
                    return `<div class="d-flex justify-center">${subir_prioridad}${bajar_prioridad}</div>`
                }
            },
            { //ACTIONS
                data: function (data) {
                    const editar_plan = new TableButton({label: 'editar plan', icon: 'edit', color: 'btn-blueMaderas', onClick: editPlan, data: data})
                    
                    let toggle_plan = new TableButton({label: 'activar plan', icon: 'play_arrow', color: 'btn-green', onClick: enablePlan, data: data})
                    let delete_plan = new TableButton({label: 'borrar plan', icon: 'delete', color: 'btn-warning', onClick: deletePlan, data: data})
                    if(data.estatus == 1){
                        toggle_plan.label   = 'desactivar plan'
                        toggle_plan.icon    = 'pause'
                        toggle_plan.color   = 'btn-yellow'
                        toggle_plan.onClick = disablePlan

                        delete_plan.color = 'btn-deepGray'
                    }

                    return `<div class="d-flex justify-center">${editar_plan}${toggle_plan}${delete_plan}</div>`
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
        format: 'YYYY-MM-DD',
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

    /*
    $(".datepicker #fechaInicio").on("change",function(){
        fechaInicio = $(this).val();
    });

    $(".datepicker #fechaFin").on("change",function(){
        fechaFin = $(this).val();
    });
    */

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
            let usuarios = ''

            // ESQUEMA

            if(row.data().comision_director){
                esquema += `director: ${row.data().comision_director} %<br>`
            }

            if(row.data().comision_regional){
                esquema += `gerente regional: ${row.data().comision_regional} %<br>`
            }

            if(row.data().comision_subdirector){
                esquema += `subdirector: ${row.data().comision_subdirector} %<br>`
            }

            if(row.data().comision_gerente){
                esquema += `gerente: ${row.data().comision_gerente} %<br>`
            }

            if(row.data().comision_coordinador){
                esquema += `coordinador: ${row.data().comision_coordinador} %<br>`
            }

            if(row.data().comision_asesor){
                esquema += `asesor: ${row.data().comision_asesor} %<br>`
            }

            // CONDICIONES

            if(row.data().fechaInicio){
                condiciones += `fecha inicio: ${row.data().fechaInicio}<br>`
            }
            if(row.data().fechaFin){
                condiciones += `fecha fin: ${row.data().fechaFin}<br>`
            }
            if(row.data().prospeccion_list){
                condiciones += `prospeccion: ${row.data().prospeccion_list}<br>`
            }
            if(row.data().sedes_list){
                condiciones += `sedes: ${row.data().sedes_list}<br>`
            }
            if(row.data().residencial_list){
                condiciones += `residencial: ${row.data().residencial_list}<br>`
            }
            if(row.data().lotes_list){
                condiciones += `lotes: ${row.data().lotes_list}<br>`
            }

            // USUARIOS
            for (var i = 0; i < row.data().usuarios.length; i++) {
                let id = row.data().usuarios[i].idUsuario
                let nombre = row.data().usuarios[i].nombre
                let comision = row.data().usuarios[i].valorComision
                
                usuarios += `${nombre}: ${comision} %<br>`
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
                    </div>`

            if(row.data().usuarios.length > 0){
                html += `<div class="col-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">
                    <label>
                        <b>
                            otros usuarios comisionando en el plan
                        </b>
                    </label>
                    <br>
                    ${usuarios}
                </div>`
            }

            html += `</div>
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
            idPlan: new FormData(event.target).get('idPlan') || null,
            nombre: new FormData(event.target).get('nombre'),
            estatus: new FormData(event.target).get('estatus'),
            fechaInicio: new FormData(event.target).get('fechaInicio'),
            fechaFin: new FormData(event.target).get('fechaFin'),

            is_prospeccion: new FormData(event.target).get('is_prospeccion') || null,
            prospeccion: new FormData(event.target).getAll('prospeccion').toString(),
            inicio_prospeccion: new FormData(event.target).get('inicio_prospeccion'),
            fin_prospeccion: new FormData(event.target).get('fin_prospeccion'),
            
            // is_sede: new FormData(event.target).get('is_sede') || null,
            sedes: new FormData(event.target).getAll('sedes').toString(),

            residencial: new FormData(event.target).getAll('residencial').toString(),
            lotes: new FormData(event.target).get('lotes'),
            prioridad: new FormData(event.target).get('prioridad') || 0,
            
            is_regional: new FormData(event.target).get('is_regional') || 0,
            regional: new FormData(event.target).get('regional'),

            comision_director: new FormData(event.target).get('comision_director'),
            comision_regional: new FormData(event.target).get('comision_regional'),
            comision_subdirector: new FormData(event.target).get('comision_subdirector'),
            comision_gerente: new FormData(event.target).get('comision_gerente'),
            comision_coordinador: new FormData(event.target).get('comision_coordinador'),
            comision_asesor: new FormData(event.target).get('comision_asesor'),
        }

        let usuarios = []
        $.each($('#usuarios_plan_comisiones .user-plan-comision'), function(i,e){
            usuario = {
                id: $(e).find('.input-id').val(),
                nombre: $(e).find('.input-nombre').val(),
                comision: $(e).find('.input-comision').val(),
            }

            usuarios.push(usuario)
        })

        // console.log(usuarios)

        data.usuarios = usuarios

        console.log(data)

        let url = `${general_base_url}planes/insertar`;
        if(data.idPlan){
            url = `${general_base_url}planes/guardar`;
        }

        $.post( url, data)
        .done(function( response ) {
            console.log( "Data Loaded: " + response );

            $("#plan-modal").modal('hide');

            dispersionDataTable.ajax.reload()
        });

        event.target.reset();
    });

})

function deletePlan(data){
    console.log(data)

    if(data.estatus == 1){
        let title = 'Borrar plan'
        let text = `Debes desactivar el plan <b>${data.nombre?.toUpperCase()}</b> para poderlo borrar.`

        let alert = new AlertDialog({title: title, text: text})

        alert.show()
    }else{
        let title = 'Borrar plan'
        let text = `¿Desea borrar el plan <b>${data.nombre?.toUpperCase()}</b>?`
        let borrar = function(){
            $.getJSON( `${general_base_url}planes/borrar?plan=${data.idPlan}` )
            .done(function( data ) {
                dispersionDataTable.ajax.reload()
            })
        }
        
        let ask = new AskDialog({title: title, text: text, onOk: borrar})

        ask.show()
    }
}

function editPlan(data){
    console.log(data)

    $('#form-plan-modal #idPlan').val(data.idPlan)
    $('#form-plan-modal #nombre').val(data.nombre)
    $('#form-plan-modal #estatus').val(data.estatus).change()
    $('#form-plan-modal #fechaInicio').val(data.fechaInicio)
    $('#form-plan-modal #fechaFin').val(data.fechaFin)
    $('#form-plan-modal #prioridad').val(data.prioridad)
    
    $('#form-plan-modal #is_regional').val(data.is_regional).change()
    $('#form-plan-modal #regional').val(data.regional)

    $('#form-plan-modal #comision_director').val(data.comision_director)
    $('#form-plan-modal #comision_regional').val(data.comision_regional)
    $('#form-plan-modal #comision_subdirector').val(data.comision_subdirector)
    $('#form-plan-modal #comision_gerente').val(data.comision_gerente)
    $('#form-plan-modal #comision_coordinador').val(data.comision_coordinador)
    $('#form-plan-modal #comision_asesor').val(data.comision_asesor)
    
    // $('#form-plan-modal #is_sede').val(data.is_sede).change()
    $('#form-plan-modal #sedes').val('')
    if(data.sedes){
        $.each(data.sedes.split(","), function(i,e){
            //console.log(e)
            $("#form-plan-modal #sedes option[value='" + e + "']").prop("selected", true)
        })
    }
    $('#form-plan-modal #sedes').selectpicker('refresh')

    $('#form-plan-modal #residencial').val('')
    if(data.residencial){
        $.each(data.residencial.split(","), function(i,e){
            //console.log(e)
            $("#form-plan-modal #residencial option[value='" + e + "']").prop("selected", true)
        })
    }
    $('#form-plan-modal #residencial').selectpicker('refresh')

    $('#form-plan-modal #inicio_prospeccion').val(data.inicio_prospeccion)
    $('#form-plan-modal #fin_prospeccion').val(data.fin_prospeccion)
    $('#form-plan-modal #is_prospeccion').val(data.is_prospeccion).change()
    $('#form-plan-modal #prospeccion').val('')
    if(data.prospeccion){
        $.each(data.prospeccion.split(","), function(i,e){
            //console.log(e)
            $("#form-plan-modal #prospeccion option[value='" + e + "']").prop("selected", true)
        })
    }
    $('#form-plan-modal #prospeccion').selectpicker('refresh')

    $('#usuarios_plan_comisiones').html('')
    for (var i = 0; i < data.usuarios.length; i++) {
        let id = data.usuarios[i].idUsuario
        let nombre = data.usuarios[i].nombre
        
        addUsuarioPlanComision(id, nombre)
    }

    $("#plan-modal").modal();
}

function subirPrioridad(data){
    let title = 'Subir prioridad'
    let text = `¿Desea subir la prioridad en el plan <b>${data.nombre?.toUpperCase()}</b>?`
    let enable = function(){
        $.getJSON( `${general_base_url}planes/subir?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }
    
    let ask = new AskDialog({title: title, text: text, onOk: enable})

    ask.show()
}

function bajarPrioridad(data){
    let title = 'Bajar prioridad'
    let text = `¿Desea bajar la prioridad en el plan <b>${data.nombre?.toUpperCase()}</b>?`
    let enable = function(){
        $.getJSON( `${general_base_url}planes/bajar?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }
    
    let ask = new AskDialog({title: title, text: text, onOk: enable})

    ask.show()
}

function enablePlan(data){
    let title = 'Activar plan'
    let text = `¿Desea activar el plan <b>${data.nombre?.toUpperCase()}</b>?`
    let enable = function(){
        $.getJSON( `${general_base_url}planes/enable?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }
    
    let ask = new AskDialog({title: title, text: text, onOk: enable})

    ask.show()
}

function disablePlan(data){
    let title = 'Desactivar plan'
    let text = `¿Desea desactivar el plan <b>${data.nombre?.toUpperCase()}</b>?`

    let ask = new AskDialog({title: title, text: text})

    ask.onOk = function(){
        $.getJSON( `${general_base_url}planes/disable?plan=${data.idPlan}` )
        .done(function( data ) {
            dispersionDataTable.ajax.reload()
        })
    }

    ask.show()
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
        .addClass('user-plan-comision col-md-12')
        .append(
            $('<input />')
            .attr('type', 'hidden')
            .addClass('input-id')
            .val(id)
            ,
            $('<div />')
            .addClass('col-md-4')
            .append(
                $('<div />')
                .addClass('form-group')
                .append(
                    $('<input />')
                    .attr('type', 'text')
                    .addClass('form-control input-gral input-nombre')
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
                    .addClass('form-control input-gral input-comision')
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