class TextField{
    constructor({id, label, placeholder}){
        // <div class="col-lg-3 col-md-6">
        //     <label for="nombre" class="control-label">Nombre</label>
        //     <input class="form-control input-gral" type="text" id="nombre" name="nombre" placeholder="NOMBRE DEL PLAN" />
        // </div>

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

            let field

            switch(this.fields[i].type){
                case 'text':
                    field = new TextField(this.fields[i])
                break
            }

            if(field)
            {
                $('#fields-form-modal').append(field.get())
            }
        }

        const $submit = this.onSubmit
        
        $('#form-form-modal').submit(function(event) {
            event.preventDefault();
            // Do other stuff

            let formdata = $(this).serializeArray();
            let data = {};
            $(formdata).each(function(index, obj){
                data[obj.name] = obj.value;
            });

            if($submit){
                //console.log('submited')
                $submit(data)
            }
        });

        $('#title-form-modal').text(this.title)
        $('#text-form-modal').html(this.text)
        $("#form-modal").modal();
    }
}