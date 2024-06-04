// este js funciona para modificar los botones , de  plantilla 
// 
// 


$("#abrir_modal_plantillas").click(function(e){
    e.preventDefault();
    document.getElementById('btn_platilla_sub').disabled = true;
    $('#botones_plantilla').removeClass('hide');
    $('#subir_platilla_div').addClass('hide');
    document.getElementById('respuesta_platilla').innerHTML = '';
});


$("#uploadFile").click(function(e){
    e.preventDefault();
    document.getElementById('btn_platilla_sub').disabled = false;
    $('#botones_plantilla').addClass('hide');
    $('#subir_platilla_div').removeClass('hide');
    document.getElementById('respuesta_platilla').innerHTML = '';

});


$("#downloadFile").click(function(e){

    e.preventDefault();

    // var len = response.length;
    var createXLSLFormatObj = [];
    var xlsHeader = ["id_usuario", "monto", 'num_pagos', "pago_individual", "comentarios", "tipo"];
    xlsHeader.push($(this).data('name'));
    createXLSLFormatObj.push(xlsHeader);
    for (var i = 0; i < 1; i++) {
        var innerRowData = [];
        innerRowData.push(1);
        innerRowData.push(1);
        innerRowData.push(1);
        innerRowData.push(1);
        innerRowData.push(1);
        innerRowData.push(1);
        createXLSLFormatObj.push(innerRowData);
    }

    let date = new Date();
    var filename = "PlantillaPrestamos_" + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " + date.getHours() + date.getMinutes() + date.getSeconds() + date.getMilliseconds() + ".xlsx";
    var ws_name = "Plantilla";
    var wb = XLSX.utils.book_new(),
        ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);
    XLSX.utils.book_append_sheet(wb, ws, ws_name);
    XLSX.writeFile(wb, filename);
    $('#spiner-loader').addClass('hide');

});


$("#downloadFileTipo").click(function(e){
    e.preventDefault();
        $.ajax({
            url: 'todos_los_tipos/',
            type: 'post',
            dataType: 'json',
            beforeSend: function() {
                $('#spiner-loader').removeClass('hide');
            },
            success: function (response) {
            // incio de succesos
            console.log(response);
            var len = response.length;
            var createXLSLFormatObj = [];
            var xlsHeader = ["tipo", "nombre"];
            xlsHeader.push($(this).data('name'));
            createXLSLFormatObj.push(xlsHeader);
            for (var i = 0; i < len; i++) {
                var innerRowData = [];
                innerRowData.push(response[i]['id_opcion']);
                innerRowData.push(response[i]['nombre']);
                createXLSLFormatObj.push(innerRowData);
            }
        
            let date = new Date();
            var filename = "tipo_descuentos" + date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " + date.getHours() + date.getMinutes() + date.getSeconds() + date.getMilliseconds() + ".xlsx";
            var ws_name = "Plantilla";
            var wb = XLSX.utils.book_new(),
                ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);
            XLSX.utils.book_append_sheet(wb, ws, ws_name);
            XLSX.writeFile(wb, filename);
            $('#spiner-loader').addClass('hide');
            }
            // llave de succesos    
        })
        // var len = response.length;
    });





// form_prestamo_plantilla

// $(document).on('click', '#btn_platilla_sub', function () {
    // $("#form_prestamo_plantilla").on('submit', function (e) {  
    //     e.preventDefault();
    //     let fileElm = document.getElementById("subir_platilla");
    //     let file = fileElm.value;
    //     if (file == '') {        
    //         alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
    //     } else {
    //         let extension = file.substring(file.lastIndexOf("."));
    //         let statusValidateExtension = validateExtension(extension, ".xlsx");
    
    //         alert(213313131331131331313113);
            

    //         if (statusValidateExtension) { 
    //             processFile(fileElm.files[0]).then(jsonInfo => {
    //                 $.ajax({
    //                     url: general_base_url + 'Descuentos/descuentos_masivos/',
    //                     type: 'post',
    //                     dataType: 'json',
    //                     contentType: 'application/json',
    //                     data: JSON.stringify({data: jsonInfo}), // Asegúrate de enviar 'data' como un objeto
    //                     success: function (response) {
    //                         alerts.showNotification("top", "right", response.message, response.status == 200 ? "success" : "warning");
    //                     },
    //                     error: function(XMLHttpRequest, textStatus, errorThrown){
    //                         alerts.showNotification("top", "right", XMLHttpRequest.status == 500 ? 'Error en los datos ingresados':'Oops, algo salió mal. Inténtalo de nuevo.', "danger");
    //                         if (XMLHttpRequest.status == 301){
    //                             alerts.showNotification("top", "right", 'intentas subir uno o varios registros.' , "warning");
    //                         }
    //                         $('#uploadModal').modal('toggle');
    //                     }
    //                 });
    //             });
    //         } else {
    //             alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo <b>.xlsx</b>.", "warning");
    //         }        
    //     }
    // });
    $("#form_prestamo_plantilla").on('submit', function (e) {  

        e.preventDefault();
        document.getElementById('btn_platilla_sub').disabled = true;
        $('#spiner-loader').removeClass('hide');
        fileElm = document.getElementById("subir_platilla");
    file = fileElm.value;

            if (file == '')
            {        
                alerts.showNotification("top", "right", "Asegúrate de seleccionar un archivo para llevar a cabo la carga de la información.", "warning");
                $('#spiner-loader').addClass('hide');
                document.getElementById('btn_platilla_sub').disabled = false;
            }
            else {
                let extension = file.substring(file.lastIndexOf("."));
                let statusValidateExtension = validateExtension(extension, ".xlsx");

                if (statusValidateExtension == true) { 
                    
                    processFile(fileElm.files[0]).then(jsonInfo => {
                        
                        console.log(jsonInfo);
                        
                        $.ajax({
                            url: general_base_url +'Descuentos/descuentos_masivos/',
                            type: 'post',
                            dataType:'json',
                            data: {'data': jsonInfo},
                            // data: JSON.stringify({data: jsonInfo}),
                            // data: {'data': generateJWT(jsonInfo)},
                            success: function (data) {
                                
                                dataDatos = ` <div class="article-body"> 
                                <h3> ID DE USUARIOS Correctos</h3>
                                <b style="color: #000;">
                                            Datos correctos:
                                            `;
                                            
                                alerts.showNotification("top", "right", "" + data.message + "", "" + data.response_type + "");
                                if(data.correctas == undefined){
                                    dataDatos += `NO EXISTEN DATOS </b>`;

                                }else{
                                    data.correctas.forEach(idx =>{
                                    
                                        dataDatos += ` 
                                            ${idx},
                                            
                                        `;
                                    });
                                    
                                    dataDatos += ` 
                                    </b>
                                    `;
                                }
                                


                                dataDatos += `
                                <h3>ID DE USUARIOS Incorrectos</h3>
                                    <b>`;
                                    
                                if(data.incorrectos == undefined){
                                    dataDatos += `NO EXISTEN DATOS </b>`;
                                }else{
                                    data.incorrectos.forEach(idx =>{
                                    
                                        dataDatos += ` 
                                            ${idx},
                                            </b>
                                        `;
                                    });
                                    dataDatos += ` 
                                    </b>
                                    `;                                    
                                }



                                dataDatos += `</div>`;
                                document.getElementById('respuesta_platilla').innerHTML = dataDatos;
                                // dataModal += `</div"></div>`; 
                                // Modalbody.append(dataModal);
                                
                                $('#spiner-loader').addClass('hide');
                                
                                // $('#uploadModal').modal('toggle');
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown){
                                alerts.showNotification("top", "right", XMLHttpRequest.status == 500 ? 'Error en los datos ingresados':'Oops, algo salió mal. Inténtalo de nuevo.', "danger");
                                if (XMLHttpRequest.status == 301){
                                    alerts.showNotification("top", "right", 'intentas subir uno o varios regitros.' , "warning");
                                }
                                $('#modal_plantilla_descuentos').modal('toggle');
                            }
                        });
                    });
                } else{
                    alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo <b>.xlsx</b>.", "warning");
                }        
            }
        });




    async function processFile(selectedFile) {
        try {
            let arrayBuffer = await readFileAsync(selectedFile);
            return arrayBuffer;
        } catch (err) {
            console.log(err);
        }
    }

    function readFileAsync(selectedFile) {
        return new Promise((resolve, reject) => {
            let fileReader = new FileReader();
            fileReader.onload = function (event) {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                    type: "binary",
                    cellDates: true,
                });
                let jsonProspectos;
                workbook.SheetNames.forEach(sheet => {
                    let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet], {defval: '', blankrows: true});
                    jsonProspectos = JSON.stringify(rowObject);
                });
                resolve(jsonProspectos);
            };
            fileReader.onerror = reject;
            fileReader.readAsArrayBuffer(selectedFile);
        });
    }

function generateJWT(excelData) {
    var header = {"alg": "HS256", "typ": "JWT"};
    var data = excelData;
    var secret = "thisismysecretkeytest";
    var stringifiedHeader = CryptoJS.enc.Utf8.parse(JSON.stringify(header));
    var encodedHeader = base64url(stringifiedHeader);
    var stringifiedData = CryptoJS.enc.Utf8.parse(JSON.stringify(data));
    var encodedData = base64url(stringifiedData);
    var signature = encodedHeader + "." + encodedData;
    signature = CryptoJS.HmacSHA256(signature, secret);
    signature = base64url(signature);
    return encodedHeader + '.' + encodedData +  '.' + signature;
}


function base64url(source) {
    encodedSource = CryptoJS.enc.Base64.stringify(source);
    encodedSource = encodedSource.replace(/=+$/, '');
    encodedSource = encodedSource.replace(/\+/g, '-');
    encodedSource = encodedSource.replace(/\//g, '_');
    return encodedSource;
}
