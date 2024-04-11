

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
    constructor({id, label, placeholder, data=[]}){
        this.id = id

        let options = []

        for (let item of data) {

            let option = $('<option>', {
                value: item.value,
                text: item.label
            })

            options.push(option)
        }

        this.field = $('<div />')
        .addClass('col-lg-6 col-md-12')
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
                .data('style', 'btn')
                .data('show-subtext', 'true')
                .data('live-search', 'true')
                .data('size', '7')
                .data('container', 'body')
                .attr('title', placeholder)
                .append(options)
            )
        )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get(){
        return this.field
    }
}

class FileField{
    constructor({id, label, placeholder}){
        this.id = id

        this.field = $('<div />')
        .addClass('col-md-12 mt-1')
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
                .attr('accept', 'application/pdf')
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
                .addClass('upload-btn m-0')
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
    constructor({id, label, placeholder}){
        this.id = id
        this.field = $('<div />')
        .addClass('col-lg-6 col-md-12')
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
    constructor({id, label, placeholder}){
        this.id = id
        this.field = $('<div />')
        .addClass('col-lg-6 col-md-12')
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
            .attr('type', 'number')
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

class Form{
    constructor({title, text, fields, onSubmit}) {
        this.title = title || ''
        this.text = text || ''
        this.fields = fields || []
        this.onSubmit = onSubmit || undefined

        if(!text){
            $('#text-form-modal').hide()
        }
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

            data.append(field.id, field.value())
        }

        this.onSubmit(data)
    }

    hide(){
        $("#form-modal").modal('hide')
    }
}