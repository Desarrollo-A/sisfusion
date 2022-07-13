var data;

$(document).ready(function () {
    console.log('info',information);
    $('#nombreCl').text(information.nombreCl);
    $('#nombreAs').text(information.nombreAs);
    $('#fechaApartado').text(information.fechaApartado);
    $('#nombreResidencial').text(information.nombreResidencial);
    $('#nombreCondominio').text(information.nombreCondominio);
    $('#nombreLote').text(information.nombreLote);
})
$(document).on('click', '#upload',function (){
    $('#spiner-loader').removeClass('hide');
    let formData = new FormData();
    formData.append('file', data, data.name);
    formData.append('data', JSON.stringify(information));
    $.ajax({
        url: "../uploadToDropbox",
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            $('#player').hide();
            $('#player').html('');
            $('#success').css('display','flex');
            $('#success').addClass('direction-column align-center');
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
})


var options = {
    controls: true,
    bigPlayButton: false,
    fluid: true,
    plugins: {
        record: {
            audio: true,
            video: true,
            maxLength: 10,
            debug: true
        }
    }
};

// apply some workarounds for opera browser
// applyVideoWorkaround();

var player = videojs('myVideo', options, function() {
    // print version information at startup
    var msg = 'Using video.js ' + videojs.VERSION +
        ' with videojs-record ' + videojs.getPluginVersion('record') +
        ' and recordrtc ' + RecordRTC.version;
    videojs.log(msg);
});

// error handling
player.on('deviceError', function() {
    console.log('device error:', player.deviceErrorCode);
});

player.on('error', function(element, error) {
    console.error(error);
});

// user clicked the record button and started recording
player.on('startRecord', function() {
    console.log('started recording!');
    $('#actionButtons').removeClass('action-buttons-active');
    $('#actionButtons').addClass('action-buttons-inactive');
});

// user completed recording and stream is available
player.on('finishRecord', function() {
    // the blob object contains the recorded data that
    // can be downloaded by the user, stored on server etc.
    console.log('finished recording: ', player.recordedData);
    data = player.recordedData;
    $('#actionButtons').removeClass('action-buttons-inactive');
    $('#actionButtons').addClass('action-buttons-active');
});
