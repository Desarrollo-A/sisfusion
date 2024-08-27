class DateField {
    constructor({ id, label, placeholder, value, width, required }) {
        this.id = id

        this.field = $('<div />')
            .addClass(`col-lg-${width} col-md-12`)
            .append(
                $('<label />')
                    .addClass('control-label label-gral')
                    .attr('for', id)
                    .text(label)
            )
            .append(
                $('<input />')
                    .addClass('form-control input-gral datepicker')
                    .prop('required', required)
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
                        },
                    })
            )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get() {
        return this.field
    }

    load() { }
}
class Button {
    constructor({id, label, icon, color = 'blueMaderas', onClick, data}) {
        this.id = id || '';
        this.label = label || '';
        this.icon = icon || '';
        this.color = color;
        this.onClick = onClick;
        this.data = data;

        this.field = $('<div />')
            .addClass('col-lg-12 col-md-12 text-end')
            .append(
                $('<label />')
                    .addClass('control-label label-gral')
                    .attr('for', id)
            );

        let button = $('<button />')
            .addClass(`btn-data btn-${this.color} pull-right`)
            .attr('id', this.id)
            .attr('type', 'button')
            .attr('data-toggle', 'tooltip')
            .attr('data-placement', 'top')
            .attr('title', this.label.toUpperCase())
            .append(
                $('<i />')
                    .addClass('material-icons')
                    .text(this.icon)
            );

        if (this.onClick) {
            button.on('click', () => this.onClick(this.data));
        }

        this.field.append(button);

        this.value = () => {
            return $(`#${id}`).val();
        }
    }

    get() {
        return this.field;
    }

    load() { }
}
class HiddenField {
    constructor({ id, value }) {
        this.id = id
        this.value = () => { return this.data }
        this.data = value

        this.field = $('<input />')
            .attr('type', 'hidden')
    }

    get() {
        return this.field
    }

    load() { }

    set(value) {
        this.data = value
    }
}

class SelectField {
    constructor({ id, label, placeholder, data = [], value, width, required = false, onChange=undefined }) {
        this.id = id
        this.required = required

        let options = []

        for (let item of data) {

            let option = $('<option>', {
                value: item.value,
                text: item.label
            })

            if (value === item.value) {
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
                            .append(options)
                            .on('change', () => this.validate())
                            .on('change', (event) => this.triggerOnChange(event))
                    )
                    .append(
                        $('<span />')
                            .attr('id', `${id}_warning`)
                            .addClass('text-danger h7 ml-1')
                            .text('Debes escoger un elemento')
                            .hide()
                    )
            )

        this.value = () => {
            return $(`#${this.id}`).val()
        }

        this.callback = onChange        
    }

    triggerOnChange = (event) => {
        let value = $(event.target).val()
        let label = $(event.target).find("option:selected").text()

        let option = {value, label}
        
        if(this.callback){
            this.callback(option)
        }
    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`#${this.id}`).val()

            if (!val) {
                pass = false
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() { }

    hide(){
        this.field.hide()
        this.required = false
    }

    show(){
        this.field.show()
        this.required = true
    }
}

class FileField {
    constructor({ id, label, placeholder, accept, required = false }) {
        this.id = id
        this.required = required

        this.field = $('<div />')
            .addClass('col-md-12')
            .append(`<label class='control-label label-gral'>${label}</label>`)
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
                            .change(function (e) {
                                //console.log(e.target.files[0])

                                let name = e.target.files[0].name
                                let size = e.target.files[0].size / 1024
                                let prefix = 'KB'

                                if (size > 1024) {
                                    size = size / 1024
                                    prefix = 'MB'
                                }

                                $(`#${id}-name`).val(`${name} - ${size.toFixed(2)} ${prefix}`)

                                if (accept) {
                                    // console.log(e.target.files[0].type)

                                    if (!accept.includes(e.target.files[0].type)) {
                                        alerts.showNotification("top", "right", "No es admitible el tipo de archivo.", "danger")
                                        $(`#${id}-name`).val('')
                                    }
                                }
                            })
                            .on('change', () => this.validate())
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
            .append(
                $('<span />')
                    .attr('id', `${id}_warning`)
                    .addClass('text-danger h7 ml-1')
                    .text('Debes seleccionar un archivo')
                    .hide()
            )

        this.value = () => {
            return $(`#${id}`)[0].files[0]
        }

    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`#${this.id}`)[0].files[0]

            if (!val) {
                pass = false
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() { }
}

class TextField {
    constructor({ id, label, placeholder, width, required = false }) {
        this.id = id
        this.required = required

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
                    .prop('required', required)
                    .attr('placeholder', placeholder)
                    .on('keyup', () => this.validate())
            )
            .append(
                $('<span />')
                    .attr('id', `${id}_warning`)
                    .addClass('text-danger h7 ml-1')
                    .text('Debes ingresar un texto')
                    .hide()
            )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`#${this.id}`).val()

            if (!val) {
                pass = false
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() { }
}

class TextAreaField {
    constructor({ id, label, placeholder, width, required, value }) {
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
                    .text(value)
                    .attr('name', id)
                    .prop('required', required)
                    .attr('placeholder', placeholder)
            )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get() {
        return this.field
    }

    load() { }
}

class NumberField {
    constructor({ id, label, placeholder, value, width = 12, required = false, mask, max }) {
        this.id = id
        this.required = required
        this.max = max

        let number = ''

        if (value) {
            number = `${value}`

            if (value % 1 == 0 && mask) {
                number = `${value}.00`
            }
        }

        let input = $('<input />')
            .addClass(`form-control input-gral`)
            .attr('id', id)
            .attr('name', id)
            .attr('type', 'text')
            .attr('placeholder', placeholder)
            .prop('required', required)
            .attr('maxlength', 20)
            .val(number)
            .on('keyup', () => this.validate())

        if (mask) {
            input.mask(mask, {
                reverse: true
            })
        } else {
            input.mask('#')
        }

        this.field = $('<div />')
            .addClass(`col-lg-${width}`)
            .append(
                $('<label />')
                    .addClass('control-label')
                    .attr('for', id)
                    .text(label)
            )
            .append(input)
            .append(
                $('<span />')
                    .attr('id', `${id}_warning`)
                    .addClass('text-danger h7 ml-1')
                    .text('Debes ingresar un número')
                    .hide()
            )

        this.value = () => {
            let val = $(`#${id}`).val()
            return parseFloat(val.replace(/,/g, ''))
        }
    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`#${this.id}`).val()

            if (!val) {
                pass = false
            } else {
                // console.log(this.max)

                if (this.max) {
                    if (val > this.max) {
                        $(`#${this.id}`).val(this.max)
                    }
                }
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() { }
}

class OptionField {
    constructor({ id, label, placeholder, data, value, style, check, required = false }) {
        this.id = id
        this.selected = value
        this.required = required

        let options = []
        for (const option of data) {
            options.push(
                $('<div />')
                    .addClass('col-lg-12')
                    .append(
                        $('<div /><br>')
                            .addClass('container boxChecks p-0')
                            .attr('style', style)
                            .append(
                                $('<label />')
                                    .addClass('m-0 checkstyleDS')
                                    .attr('id', `${id}_${option.value}_label`)
                                    .append(
                                        $('<input/>')
                                            //.addClass('hide')
                                            .attr('type', 'radio')
                                            .attr('id', `${id}_${option.value}`)
                                            .attr('name', id)
                                            .val(option.value)
                                            .on('change', () => this.validate())
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
            )
        }

        this.field = $('<div />')
            .addClass('col-12 lotePropuesto checkDS')
            .append(
                $('<label />')
                    .text(label)
            )
            .append(options)
            .append(
                $('<span />')
                    .attr('id', `${id}_warning`)
                    .addClass('text-danger h7 ml-1')
                    .text('Debes escoger una opcion')
                    .hide()
            )

        this.value = () => {
            //return $(`#${id}`).val()
            return $(`input[name="${id}"]:checked`).val()
        }
    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`input[name="${this.id}"]:checked`).val()

            if (!val) {
                pass = false
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() {
        // console.log(`#${this.id}_${this.selected}_label`)

        $(`#${this.id}_${this.selected}_label`).trigger('click')
    }
}

class OptionFieldAndView {
    constructor({ id, label, placeholder, data, value, style, onClick, title, required = false }) {
        this.id = id
        this.selected = value
        this.required = required

        let options = []
        for (const option of data) {
            options.push(
                $('<div /><br>')
                    .addClass('col-lg-12')
                    .append(
                        $('<div />')
                            .addClass('d-flex justify-content-between align-items-center mb-3')
                            .append(
                                $('<div />')
                                    .addClass('container boxChecks p-0')
                                    .attr('style', style)
                                    .append(
                                        $('<label />')
                                            .addClass('m-0 checkstyleDS')
                                            .attr('id', `${id}_${option.value}_label`)
                                            .append(
                                                $('<input/>')
                                                    .attr('type', 'radio')
                                                    .attr('id', `${id}_${option.value}`)
                                                    .attr('name', id)
                                                    //.attr('checked', 'checked')
                                                    .val(option.value)
                                                    .on('change', () => this.validate())
                                            )
                                            .append(
                                                $('<span />')
                                                    .addClass('w-100 d-flex justify-between')
                                                    .append(
                                                        $('<p />')
                                                            .addClass('m-0')
                                                            .text(typeof (option.subtitle) === "string" ? option.subtitle.toUpperCase() : option.subtitle)
                                                    )
                                            )
                                    )
                            )
                            .append(
                                $('<button />')
                                    .addClass('btn-data btn-blueMaderas m-0 ml-1')
                                    .attr('id', 'uno')
                                    .attr('style', 'padding:15px')
                                    .attr('type', 'button')
                                    .attr('title', title)
                                    .attr('onClick', `${onClick.name}(${JSON.stringify(option.archivo)})`)
                                    .append(
                                        $('<i class="">file_upload</i></button>')
                                            .addClass('material-icons')
                                            .text('file_download')
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
            .append(
                $('<span />')
                    .attr('id', `${id}_warning`)
                    .addClass('text-danger h7 ml-1')
                    .text('Debes escoger un elemento')
                    .hide()
            )

        this.value = () => {
            //return $(`#${id}`).val()
            return $(`input[name="${id}"]:checked`).val()
        }
    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`input[name="${this.id}"]:checked`).val()

            if (!val) {
                pass = false
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() {
        $(`#${this.id}_${this.selected}_label`).trigger('click')
    }
}

class CrudInput {
    constructor({ id, label, placeholder, width, required = false, icon, color = 'blueMaderas', title, disabled = false, onClick, data }) {
        this.id = id;
        this.required = required;
        this.onClick = onClick;
        this.data = data;
        this.inputId = `${id}-input`; // Define inputId aquí

        let button = $('<button />')
            .addClass(`btn-data btn-${color} m-0 ml-1`)
            .attr('id', id + '-button')
            .attr('type', 'button')
            .attr('title', title)
            .append(
                $('<i class="material-icons"></i>')
                    .text(icon)
            );

        if (this.onClick) {
            button.on('click', () => this.handleButtonClick());
        }

        this.field = $('<div />')
            .addClass(`col-lg-${width} col-md-12 mb-1`)
            .append(
                $('<label />')
                    .addClass('control-label label-gral')
                    .attr('for', this.inputId)
                    .text(label)
            )
            .append(
                $('<div />')
                    .addClass('d-flex justify-content-between align-items-center mb-0')
                    .append(
                        $('<input />')
                            .addClass(`form-control input-gral`)
                            .attr('id', this.inputId)
                            .attr('disabled', disabled)
                            .attr('name', id)
                            .attr('type', 'text')
                            .prop('required', required)
                            .attr('placeholder', placeholder)
                            .on('keyup', () => this.validate())
                    )
                    .append(
                        $('<span />')
                            .attr('id', `${id}_warning`)
                            .addClass('text-danger h7 ml-1')
                            .text('Debes ingresar un texto')
                            .hide()
                    )
                    .append(button)
            );
    }

    handleButtonClick() {
        const currentValue = this.getData();
        if (this.onClick) {
            this.onClick(currentValue); 
        }
        this.updateButtonData(currentValue); 
    }

    updateButtonData(value) {
        $(`#${this.id}-button`).data('value', value);
    }

    getData() {
        return $(`#${this.inputId}`).val(); 
    }

    validate() {
        let pass = true;

        if (this.required) {
            let val = $(`#${this.inputId}`).val(); 

            if (!val) {
                pass = false;
            }

            if (pass) {
                $(`#${this.id}_warning`).hide();
            } else {
                $(`#${this.id}_warning`).show();
            }
        }

        return pass;
    }

    get() {
        return this.field;
    }

    load() { }
}


class DateDelete {
    constructor({ id, label, placeholder, value, width, required = false }) {
        this.id = id
        this.required = required

        this.field = $('<div />')
            .addClass(`col-lg-${width} col-md-12 mb-1`)
            .append(
                $('<label />')
                    .addClass('control-label label-gral')
                    .attr('for', id)
                    .text(label)
            )
            .append(
                $('<div />')
                    .addClass('d-flex justify-content-between align-items-center mb-0')
                    .append(
                        $('<input />')
                            .addClass('form-control input-gral datepicker')
                            .prop('required', required)
                            .attr('type', 'text')
                            .attr('name', id)
                            .attr('id', id)
                            .prop('readOnly', true)
                            .attr('placeholder', placeholder.toUpperCase())
                            //.on('change', () => this.validate())
                            .datetimepicker({
                                date: value ? value.substring(0, 16) : null,
                                format: 'YYYY-MM-DD HH:mm',
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
                                },
                                minDate: new Date(),
                                tooltips: {
                                    today: 'Ir a hoy',
                                    clear: 'Borrar seleccion',
                                    close: 'Cerrar el selector',
                                    selectMonth: 'Seleccionar mes',
                                    prevMonth: 'Mes anterior',
                                    nextMonth: 'Siguiente mes',
                                    selectYear: 'Seleccionar año',
                                    prevYear: 'Año anterior',
                                    nextYear: 'Siguiente año',
                                    selectDecade: 'Seleccionar decada',
                                    prevDecade: 'Decada anterior',
                                    nextDecade: 'Siguiente decada',
                                    prevCentury: 'Siglo anterior',
                                    nextCentury: 'Siguiente siglo',
                                    selectTime: 'Seleccionar hora',
                                    incrementHour: 'Incrementar hora',
                                    incrementMinute: 'Incrementar minutos',
                                    decrementHour: 'Disminuir hora',
                                    decrementMinute: 'Disminuir minutos',
                                },
                                ignoreReadonly: true,
                            })
                            .on('dp.change', () => this.validate())
                    )
                    .append(
                        $('<button />')
                            .addClass('btn-data btn-warning m-0 ml-1')
                            .attr('id', 'uno')
                            //.attr('style', 'padding:0px')
                            .attr('type', 'button')
                            .attr('title', 'Borrar')
                            .click(function () {
                                // Aquí borramos los valores de los campos de fecha
                                $(`#${id}`).val('');
                            })
                            .append(
                                $('<i class="">file_upload</i></button>')
                                    .addClass('material-icons')
                                    .text('close')
                            )
                    )
            )
            .append(
                $('<span />')
                    .attr('id', `${id}_warning`)
                    .addClass('text-danger h7 ml-1')
                    .text('Debes escoger un elemento')
                    .hide()
            )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    validate() {
        let pass = true

        if (this.required) {
            let val = $(`#${this.id}`).val()

            if (!val) {
                pass = false
            }

            if (pass) {
                $(`#${this.id}_warning`).hide()
            } else {
                $(`#${this.id}_warning`).show()
            }
        }

        return pass
    }

    get() {
        return this.field
    }

    load() { }
}

class inputText {
    constructor({ id, label, placeholder, value, width, required }) {
        this.id = id

        this.field =
            $('<div /><br>')
                .addClass('col-lg-12 checkDft')
                .append(
                    $('<div />')
                        .addClass('container boxChecksDft p-0')
                        .attr('style', 'height: 45px')
                        .append(
                            $('<label />')
                                .addClass('m-0 checkstyleDft')
                                .append(
                                    $('<input checked/>')
                                        .attr('type', 'button')
                                        .attr('id', id)
                                        .attr('name', id)
                                        .val(value)
                                )
                                .append(
                                    $('<span />')
                                        .addClass('w-100 d-flex justify-between')
                                        .append(
                                            $('<i />')
                                                .addClass('material-icons')
                                                .text('done')
                                        )
                                        .append(
                                            $('<p />')
                                                .addClass('m-0')
                                                .text(label)
                                        )
                                )
                        )
                )

        this.value = () => {
            return $(`#${id}`).val()
        }
    }

    get() {
        return this.field
    }

    load() { }
}

class title {
    constructor({ text }) {
        this.field = $('<div />')

            .append(
                $('<label/> ')
                    .addClass('control-label')
                    .text(text)
            )
        this.value = () => {
            return $(``).val()
        }
    }

    get() {
        return this.field
    }

    load() { }
}

class TimeLine {
    

constructor({ title, back, next, description, date }) {

{/* <li>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <a><b>  dsdsds  </b></a><br>
            </div>
            <div class="float-end text-right">
                <a> ddsdsds </a>
            </div>
            <div class="col-md-12">
                <p class="m-0"><small>Estatus: </small><b>  xcxcx </b></p>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <p class="m-0"><small>Comentario: </small><b>  dsdsds </b></p>
    </div>
</li> */}

    this.field = $('<li /><div />')
        .addClass('container-fluid')
        .append(
            $('<div />')
                .addClass('row')
                .append(
                    $('<div />')
                        .addClass('col-xs-12 col-sm-6 col-md-6 col-lg-6')
                        .append(
                            $('<a />')
                                .append(
                                    $('<b />')
                                        .addClass('m-0')
                                        .text(title)
                                )
                        )
                )
                .append(
                    $('<div />')
                        .addClass('float-end text-right')
                        .append(

                            $('<a />')
                                .addClass('m-0')
                                .text(date)
                        )
                )
                .append(
                    $('<div />')
                        .addClass('col-md-12')
                        .append(
                            $('<p />')
                                .addClass('m-0')
                                .append(
                                    $('<small />')
                                        .text('Proceso anterior: ')
                                        .append(
                                            $('<b />')
                                                .text(back)
                                        )
                                )
                        )
                )
                .append(
                    $('<div />')
                        .addClass('col-md-12')
                        .append(
                            $('<p />')
                                .addClass('m-0')
                                .append(
                                    $('<small />')
                                        .text('Proceso nuevo: ')
                                        .append(
                                            $('<b />')
                                                .text(next)
                                        )
                                )
                        )
                )
                .append(
                    $('<div />')
                        .addClass('col-md-12')
                        .append(
                            $('<p />')
                                .addClass('m-0')
                                .append(
                                    $('<small />')
                                        .text('Descripción: ')
                                        .append(
                                            $('<b />')
                                                .text(description)
                                        )
                                )
                        )
                )
        )
        
}

    toString() {
        const ht = this.field

        return ht.prop('outerHTML')
    }
}

class HrTitle {
    constructor({ text }) {
        this.field = $('<div />')
            .append(
                $('<strong/> ')
                    .addClass('control-label')
                    .text(text)
            )
            .append(
                $('<hr/>')
            )
        this.value = () => {
            return $(``).val()
        }
    }

    get() {
        return this.field
    }

    load() { }
}

class Form {
    constructor({ title, text, fields, onSubmit }) {
        this.title = title || ''
        this.text = text || ''
        this.fields = fields || []
        this.onSubmit = onSubmit || undefined

        /* if(!text){
            $('#text-form-modal').hide()
        } */

        $("#ok-button-form-modal").prop('disabled', false)
    }

    show() {
        $('#fields-form-modal').html('')

        for (var i = 0; i < this.fields.length; i++) {

            let field = this.fields[i]

            if (field) {
                $('#fields-form-modal').append(field.get())

                field.load()
            }
        }

        $('.selectpicker').selectpicker('refresh')

        $('#form-form-modal').unbind('submit')

        $('#form-form-modal').submit((event) => this.submit(event))

        $('#title-form-modal').text(this.title)
        $('#text-form-modal').html(this.text)
        $("#ok-button-form-modal").prop('disabled', false)
        $("#form-modal").modal();
    }

    submit(event) {
        event.preventDefault()

        let pass = true
        let data = new FormData()
        for (var i = 0; i < this.fields.length; i++) {
            let field = this.fields[i]

            if (typeof field.validate === 'function') {
                if (!field.validate()) {
                    pass = false
                }
            }

            if (field.value() != null || field.value() != undefined) {
                data.append(field.id, field.value())
            }
        }

        if (pass) {
            this.onSubmit(data)
        }
    }

    hide() {
        $("#form-modal").modal('hide')
    }

    loading(load) {
        if (load) {
            $("#ok-button-form-modal").prop('disabled', true)
        } else {
            $("#ok-button-form-modal").prop('disabled', false)
        }
    }
}

class Form2 {
    constructor({ title, text, fields, onSubmit }) {
        this.title = title || ''
        this.text = text || ''
        this.fields = fields || []
        this.onSubmit = onSubmit || undefined

        /* if(!text){
            $('#text-form-modal').hide()
        } */

        $("#ok-button-form-modal2").prop('disabled', false)
    }

    show() {
        $('#fields-form-modal2').html('')

        for (var i = 0; i < this.fields.length; i++) {

            let field = this.fields[i]

            if (field) {
                $('#fields-form-modal2').append(field.get())

                field.load()
            }
        }

        $('.selectpicker').selectpicker('refresh')

        $('#form-form-modal2').unbind('submit')

        $('#form-form-modal2').submit((event) => this.submit(event))

        $('#title-form-modal2').text(this.title)
        $('#text-form-modal2').html(this.text)
        $("#ok-button-form-modal2").prop('disabled', false)
        $("#form-modal2").modal();

        $('body').addClass('modal-open');
    }

    submit(event) {
        event.preventDefault()

        let pass = true
        let data = new FormData()
        for (var i = 0; i < this.fields.length; i++) {
            let field = this.fields[i]

            if (typeof field.validate === 'function') {
                if (!field.validate()) {
                    pass = false
                }
            }

            if (field.value() != null || field.value() != undefined) {
                data.append(field.id, field.value())
            }
        }

        if (pass) {
            this.onSubmit(data)
        }
    }

    hide() {
        $("#form-modal2").modal('hide')
    }

    loading(load) {
        if (load) {
            $("#ok-button-form-modal2").prop('disabled', true)
        } else {
            $("#ok-button-form-modal2").prop('disabled', false)
        }
    }
}

class FormConfirm {
    constructor({ title, text, fields, onSubmit }) {
        this.title = title || ''
        this.text = text || ''
        this.fields = fields || []
        this.onSubmit = onSubmit || undefined

        /* if(!text){
            $('#text-form-modal').hide()
        } */

        $("#ok-button-form-modal3").prop('disabled', false)
    }

    show() {
        $('#fields-form-modal3').html('')

        for (var i = 0; i < this.fields.length; i++) {

            let field = this.fields[i]

            if (field) {
                $('#fields-form-modal3').append(field.get())

                field.load()
            }
        }

        $('.selectpicker').selectpicker('refresh')

        $('#form-form-modal3').unbind('submit')

        $('#form-form-modal3').submit((event) => this.submit(event))

        $('#title-form-modal3').text(this.title)
        $('#text-form-modal3').html(this.text)
        $("#ok-button-form-modal3").prop('disabled', false)
        $("#form-modal3").modal();
    }

    submit(event) {
        event.preventDefault()

        let pass = true
        let data = new FormData()
        for (var i = 0; i < this.fields.length; i++) {
            let field = this.fields[i]

            if (typeof field.validate === 'function') {
                if (!field.validate()) {
                    pass = false
                }
            }

            if (field.value() != null || field.value() != undefined) {
                data.append(field.id, field.value())
            }
        }

        if (pass) {
            this.onSubmit(data)
        }
    }

    hide() {
        $("#form-modal3").modal('hide')
    }

    loading(load) {
        if (load) {
            $("#ok-button-form-modal3").prop('disabled', true)
        } else {
            $("#ok-button-form-modal3").prop('disabled', false)
        }
    }
}

class MultiSelectField {
    constructor({ id, label, placeholder, data = [], value = [], width, required = false }) {
        this.id = id;
        this.required = required;
        let options = [];
        this.value = value;

        for (let item of data) {
            let option = $('<option>', {
                value: item.value,
                text: item.label
            });
            if (this.value.includes(item.value)) {
                option.attr("selected", true);
            }
            options.push(option);
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
                            .attr('multiple', 'multiple')
                            .data('style', 'btnSelect')
                            .data('show-subtext', 'true')
                            .data('live-search', 'true')
                            .data('size', '7')
                            .data('container', 'body')
                            .attr('title', placeholder)
                            .append(options)
                            //.on('change', () => this.validate())
                    )
                    .append(
                        $('<span />')
                            .attr('id', `${id}_warning`)
                            .addClass('text-danger h7 ml-1')
                            .text('Debes escoger mínimo un elemento')
                            .hide()
                    )
            );
        this.value = () => {
            return $(`#${this.id}`).val();
        }
        this.field.find('select').on('selected.bs.select', () => {
            this.validate();
        });
        $(document).ready(() => this.initializeSelectPicker());
        
    }

    initializeSelectPicker() {
        $(`#${this.id}`).selectpicker('refresh');
    }

    validate() {
        let pass = true;
        if (this.required) {
            let val = $(`#${this.id}`).val();
            if (!val || val.length === 0) {
                pass = false;
            }
            if (pass) {
                $(`#${this.id}_warning`).hide();
            } else {
                $(`#${this.id}_warning`).show();
            }
        }
        return pass;
    }

    get() {
        return this.field;
    }

    load() { }
}


