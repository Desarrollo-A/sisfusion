class TextField{
    constructor({id, placeholder}){

    }

    get(){
        return 'ASDF'
    }
}

class Form{
    constructor({title, text, fields}) {
        this.title = title || ''
        this.text = text || ''
        this.fields = []
    }

    show(){
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

        $('#title-form-modal').text(this.title)
        $('#text-form-modal').html(this.text)
        $("#form-modal").modal();
    }
}