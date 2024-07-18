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