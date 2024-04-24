class SelectFilter{
    constructor({id, label, placeholder, data=[], onChange=undefined}){
        this.id = id

        let options = []

        for (let item of data) {

            let option = $('<option>', {
                value: item.value,
                text: item.label
            })

            options.push(option)
        }

        this.select = $('<select />')
        .addClass('selectpicker select-gral m-0')
        //.attr('id', id)
        //.attr('name', id)
        .data('style', 'btn')
        .data('show-subtext', 'true')
        .data('live-search', 'true')
        .data('size', '7')
        .data('container', 'body')
        .attr('title', placeholder)
        .append(options)

        this.field = $('<div />')
        .addClass('col-lg-4 col-md-6')
        .append(
            $('<div />')
            .addClass('form-group select-is-empty overflow-hidden m-0 p-0')
            .append(
                $('<label />')
                .addClass('control-label m-1')
                .text(label)
            )
            .append(this.select)
        )

        /*
        this.value = () => {
            return $(`#${id}`).val()
        }
        */

        this.callback = onChange
    }

    get(){
        this.select.on('change', this.triggerOnChange)

        return this.field
    }

    triggerOnChange = (event) => {
        let value = $(event.target).val()
        let label = $(event.target).find("option:selected").text()

        let option = {value, label}

        // console.log(option)

        if(this.callback){
            this.callback(option)
        }
    }

    onChange(callback){
        this.callback = callback
        //this.field.on('change', () => {callback(this.value)})
    }

    setOptions(data=[]){
        let options = []

        for (let item of data) {

            let option = $('<option>', {
                value: item.value,
                text: item.label
            })

            options.push(option)
        }

        this.select.find('option')
        .remove()
        .end()
        .append(options)
        .selectpicker('refresh')
    }
}

class Filters{
    constructor({id, filters=[]}) {
        this.id = id
        this.div = $(`#${id}`)

        for(let filter of filters){
            this.div.append(filter.get())
        }
    }

    add(filter){
        this.div.append(filter.get())
    }
}