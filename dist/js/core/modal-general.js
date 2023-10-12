const showModal = () => {
    $('#blank-modal').modal();
}

const appendBodyModal = (body) => {
    $('#blank-modal .modal-body').html("");
    $('#blank-modal .modal-body').append(body);
}

const appendFooterModal = (footer) => {
    $('#blank-modal .modal-footer').html("");
    $('#blank-modal .modal-footer').append(footer);
}

const changeSizeModal = (className = '') => {
    if (className !== '') {
        $('#blank-modal-div').removeClass();
        $('#blank-modal-div').addClass(`modal-dialog ${className}`);
    }
}

const hideModal = () => {
    changeOptionsModal({ backdrop: true, keyboard: true, show: true });
    $('#blank-modal').modal('hide');
}

const changeOptionsModal = (options) => {
    $('#blank-modal').data('bs.modal').options = options;
}