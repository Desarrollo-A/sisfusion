class DateField{
    constructor({id, label, placeholder, value, required}){
        this.id = id

        this.field = $('<div />')
        .addClass('col-lg-6 col-md-12')
        .append(
            $('<label />')
            .addClass('control-label label-gral')
            .attr('for', id)
            .text(label)
        )
        .append(
            $('<input />')
            .addClass('form-control input-gral datepicker')
            .attr(required, required )
            .attr('type', 'text')
            .attr('name', id)
            .attr('id', id)
            .attr('placeholder', placeholder.toUpperCase())
            .val(value)
            .datetimepicker({
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
            })
        )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get(){
        return this.field
    }
}

class HiddenField{
    constructor({id, value}){
        this.id = id
        this.value = () => {return value}

        this.field = $('<input />')
        .attr('type', 'hidden')
    }

    get(){
        return this.field
    }
}

class SelectField{
    constructor({id, label, placeholder, data=[], value, width, required}){
        this.id = id

        let options = []

        for (let item of data) {

            let option = $('<option>', {
                value: item.value,
                text: item.label
            })

            if(value === item.value){
                option.attr("selected", true)
            }

            options.push(option)
        }

        this.field = $('<div />')
        .addClass(`col-lg-${width} col-md-12`)
        .append(
            $('<div />')
            .addClass('form-group select-is-empty overflow-hidden m-0 p-0')
            .append(
                $('<label />')
                .addClass('control-label m-1')
                .text(label)
            )
            .append(
                $('<select />')
                .addClass('selectpicker select-gral m-0')
                .attr('id', id)
                .attr('name', id)
                .data('style', 'btnSelect')
                .data('show-subtext', 'true')
                .data('live-search', 'true')
                .data('size', '7')
                .data('container', 'body')
                .attr('title', placeholder)
                .attr(required, required )
                .append(options)
            )
        )

        //$(`#${id}`).trigger("change")
        //$(`#${id} option[value='${value}']`).prop('selected', true);

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get(){
        return this.field
    }
}

class FileField{
    constructor({id, label, placeholder, accept}){
        this.id = id

        this.field = $('<div />')
        .addClass('col-md-12')
        .append(
            $('<div />')
            .addClass('file-gph')
            .append(
                $('<input />')
                .attr('id', `file-${id}`)
                .attr('name', `file-${id}`)
                .attr('type', 'hidden')
            )
            .append(
                $('<input />')
                .addClass('d-none')
                .attr('id', id)
                .attr('name', id)
                .attr('type', 'file')
                .attr('accept', accept)
                .change(function(e) { 
                    //console.log(e.target.files[0])

                    let name = e.target.files[0].name
                    let size = e.target.files[0].size / 1024
                    let prefix = 'KB'

                    if(size > 1024){
                        size = size / 1024
                        prefix = 'MB'
                    }

                    $(`#${id}-name`).val(`${name} - ${size.toFixed(2)} ${prefix}`)

                    if(accept){
                        // console.log(e.target.files[0].type)

                        if(!accept.includes(e.target.files[0].type)){
                            alerts.showNotification("top", "right", "No es admitible el tipo de archivo.", "danger")
                            $(`#${id}-name`).val('')
                        }
                    }
                })
            )
            .append(
                $('<input />')
                .addClass('file-name')
                .attr('id', `${id}-name`)
                .attr('type', 'text')
                .attr('placeholder', placeholder)
                .attr('readOnly', true)
            )
            .append(
                $('<label />')
                .addClass('upload-btn')
                .attr('for', id)
                .attr('type', 'text')
                .append(
                    $('<span />')
                    .text('Seleccionar')
                )
                .append(
                    $('<i />')
                    .addClass('fas fa-folder-open')
                )
            )
        )

        this.value = () => {
            return $(`#${id}`)[0].files[0]
        }
        
    }

    get(){
        return this.field
    }
}

class TextField{
    constructor({id, label, placeholder, width, required}){
        this.id = id
        this.field = $('<div />')
        .addClass(`col-lg-${width} mt-1`)
        .append(
            $('<label />')
            .addClass('control-label')
            .attr('for', id)
            .text(label)
        )
        .append(
            $('<input />')
            .addClass(`form-control input-gral`)
            .attr('id', id)
            .attr('name', id)
            .attr('type', 'text')
            .attr(required, required )
            .attr('placeholder', placeholder)
        )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get(){
        return this.field
    }
}

class TextAreaField{
    constructor({id, label, placeholder, width, required}){
        this.id = id
        this.field = $('<div />')
        .addClass(`col-lg-${width} mt-1`)
        .append(
            $('<label />')
            .addClass('control-label')
            .attr('for', id)
            .text(label)
        )
        .append(
            $('<textarea />')
            .addClass(`text-modal`)
            .attr('id', id)
            .attr('name', id)
            .attr(required, required )
            .attr('placeholder', placeholder)
        )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get(){
        return this.field
    }
}

class NumberField{
    constructor({id, label, placeholder, value, width=12, required}){
        this.id = id
        this.field = $('<div />')
        .addClass(`col-lg-${width}`)
        .append(
            $('<label />')
            .addClass('control-label')
            .attr('for', id)
            .text(label)
        )
        .append(
            $('<input />')
            .addClass(`form-control input-gral`)
            .attr('id', id)
            .attr('name', id)
            .attr('type', 'text')
            .attr('placeholder', placeholder)
            .attr(required, required )
            .val(value)
            .on('keypress', this.onlyNumbers)
        )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get(){
        return this.field
    }

    onlyNumbers(e) {
        var key = e.keyCode || e.which;
        var tecla = String.fromCharCode(key);
        var letras = "0123456789.";
        var especiales = [8, 37, 39, 46];
    
        var tecla_especial = false;
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
    
        if (letras.indexOf(tecla) == -1 && !tecla_especial) return false;
    
        // Permitir solo un punto decimal
        if (tecla == '.' && e.target.value.indexOf('.') !== -1) return false;
    
        // Limitar a dos decimales
        var parts = e.target.value.split('.');
        if (parts.length > 1 && parts[1].length >= 2) return false;
    
        return true;
    }
}

class OptionField{
    constructor({id, label, placeholder, data, value}){
        this.id = id

        let options = []
        for (const option of data) {
            options.push(
                $('<div /><br>')
                .addClass('container boxChecks p-0')
                .append(
                    $('<label />')
                    .addClass('m-0 checkstyleDS')
                    .append(
                        $('<input />')
                        //.addClass('hide')
                        .attr('type', 'radio')
                        .attr('id', id)
                        .attr('name', id)
                        .val(option.value)
                    )
                    .append(
                        $('<span />')
                        .addClass('w-100 d-flex justify-between')
                        .append(
                            $('<b />')
                            .addClass('m-0')
                            .text(option.title)
                        )
                    )
                    .append(
                        $('<span />')
                        .addClass('w-100 d-flex justify-between')
                        .append(
                            $('<p />')
                            .addClass('m-0')
                            .text(option.subtitle)
                        )
                    )
                    .append(
                        $('<span />')
                        .addClass('w-100 d-flex justify-between')
                        .append(
                            $('<p />')
                            .addClass('m-0')
                            .text(option.description)
                        )
                    )
                )
            )
        }

        this.field = $('<div />')
        .addClass('col-12 lotePropuesto checkDS')
        .append(
            $('<label />')
            .text(label)
        )
        .append(options)

        this.value = () => {
            //return $(`#${id}`).val()
            return $(`input[name="${id}"]:checked`).val()
        }
    }

    get(){
        return this.field
    }
}

class Form{
    constructor({title, text, fields, onSubmit}) {
        this.title = title || ''
        this.text = text || ''
        this.fields = fields || []
        this.onSubmit = onSubmit || undefined

        /* if(!text){
            $('#text-form-modal').hide()
        } */
    }

    show(){
        $('#fields-form-modal').html('')

        for (var i = 0; i < this.fields.length; i++) {

            let field = this.fields[i]

            if(field)
            {
                $('#fields-form-modal').append(field.get())
            }
        }

        $('.selectpicker').selectpicker('refresh')

        $('#form-form-modal').unbind('submit')

        $('#form-form-modal').submit((event) => this.submit(event))

        $('#title-form-modal').text(this.title)
        $('#text-form-modal').html(this.text)
        $("#form-modal").modal();
    }

    submit(event){
        event.preventDefault()

        let data = new FormData()
        for (var i = 0; i < this.fields.length; i++) {
            let field = this.fields[i]

            if(field.value()){
                data.append(field.id, field.value())
            }
        }

        this.onSubmit(data)
    }

    hide(){
        $("#form-modal").modal('hide')
    }
}