    $('#file-es').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['csv']
    });
function limpiar()
{
    //$('#table_datos2').DataTable().ajax.reload();
    var table = $('#table_datos2').DataTable();
table
    .clear()
    .draw();
    location.reload();
}

let personalidadV=0;
let contador = 0;
function parseCSV(text) {
  // Obtenemos las lineas del texto
    let lines = text.replace(/\r/g, '').split('\n');
    return lines.map(line => {
        // Por cada linea obtenemos los valores
        let values = line.split(',');
        return values;
    });
}

function reverseMatrix(matrix){
    let output = [];
  // Por cada fila
    matrix.forEach((values, row) => {
    // Vemos los valores y su posicion
    values.forEach((value, col) => {
      // Si la posición aún no fue creada
        if (output[col] === undefined) output[col] = [];
        output[col][row] = value;
    });
    });
    return output;
}

let c=0;
function readFile(evt) {
    var fileName = this.files[0].name;
    var ext = fileName.split('.').pop();
    //alert(ext);

if(ext !== "csv"){
alerts.showNotification("top", "right", "El formato permitido solo es .csv", "danger");
}else{
    let file = evt.target.files[0];
    let reader = new FileReader();
    reader.onload = (e) => {
console.log(e.target.result);     
    // Cuando el archivo se terminó de cargar
    let lines = parseCSV(e.target.result);
    let output = reverseMatrix(lines);
//Se mandan los dotos a la funcion que pinta la datatable   
//alert(lines.length); 
llenar(lines.splice(1,lines.length));
    };
  // Leemos el contenido del archivo seleccionado
reader.readAsBinaryString(file); 
}
}
document.getElementById('customFile').addEventListener('change', readFile, false);
let contadorSede = 0;
let contadorSede2 =0;
let ContadorErr= 0;
let ContadorFila=2;
function llenar(lines) {
$(document).ready(function() {
    $('#table_datos2').DataTable( {
        ordering: false,
        paging: true,
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            "url": "../../static/spanishLoader.json"
        },
        destroy: true,
        data: lines.splice(0,lines.length -1),
        initComplete:
        function(settings, json) {
        },
        columns: [
            { data: lines.id_sede, render: function(data)
                { //alert(data);
               // let v;
                let variable = new String(data);
                let numero = parseFloat(data);
                if (data == "id_sede" || data == undefined ) {
                    return '<p></p>';
                }else if(variable == ""){
                    ContadorErr++;
                return '<b style="color:red;">REQUERIDO</b>';
                    }else if( data !== "id_sede" && data !== "" && data != undefined)
                    {
                    if (data >= 1 && data <=7  && Number.isInteger(numero) == true) {
                        return '<p>'+data+'</p>'; 
                        }else{
                             
                        return '<b style="color:red;">'+data+'</b>';
                        }
                    }
                }
            },        
            { data: lines.id_asesor,render: function (data) {
                let numero = parseFloat(data);
                if (data == "id_asesor" || data == undefined) {
                    return '<p></p>';
                }
                else if(data == "" && data != undefined){
                    ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>';
                }else if(data !== "id_asesor" && data !== "" && data != undefined){
                    if (Number.isInteger(numero) == true) {
                        return '<p >'+data+'</p>';
                    }else{
                        ContadorErr++;
                        return '<b style="color:red;">'+data+'<b>';
                    }
                }
            }
            },
            { data: lines.nombre,render:function(data) {
                if (data == "nombre" || data == undefined) {
                    return '<p></p>';
                }
                else if(data == ""){
                     ContadorErr++;
                     return '<b style="color:red;">REQUERIDO</b>';   
                }else if(data !== "" && data !== "nombre"){
                             return '<p>'+data+'</p>';
                }
            }
            },
            { data: lines.apellido_paterno,render:function(data) {
                if (data == "apellido_paterno" || data == undefined) {
                    return '<p></p>';
                }
                else{
                    return '<p>'+data+'</p>';
                }
            }
             },
            { data: lines.apellido_materno,render:function(data) {
                if (data == "apellido_materno" || data == undefined) {
                    return '<p></p>';
                }
                else{
                    return '<p>'+data+'</p>';
                }
            }
             },
            { data: lines.personalidad_juridica, render: function(data) {
                if (data == "") {
                    ContadorErr++;
 return '<b style="color:red;">REQUERIDO</b>';
                }else{
                    if (personalidad(data) == 1) 
                {
                    return '<p>'+data+'</p>'; 
                }else if(personalidad(data) == 1)
                {
                   
                    return '<p ">'+data+'</p>'; 
                }else if(personalidad(data) == 2)
                {
                 
                    return '<p ">'+data+'</p>'; 
                }
                else if(personalidad(data) == 3)
                {
                    ContadorErr++;
                    return '<b style="color:red;">'+data+'</b>'; 
                }
                else if(personalidad(data) == 4)
                {
                    return '<p></p>';
                }
                }

            } 
             },
            { data: lines.correo, render: function(data)
                {   
                        if (data == "") {
                            //ContadorErr++;
 return '<b ></b>';
                        }else{
                            if (validar_email2(data) == 2) {
                            return '<p>'+data+'</p>';
                            }else if(validar_email2(data) == 1){
                                ContadorErr++;
                                 return '<b style="color:red;">'+data+'</b>';
                                
                            }else if(validar_email2(data) == 3)
                            {    
                               return '<b style="color:red;"></b>'; 
                            } 
                        }       
                }
            },
            { data: lines.telefono, render: function(data)
                { if (data == "") {
                    ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>';
                 }else{
                         if (telefonoF(data) == 3) {
                return '<b style="color:red;"></b>';
                }else if(telefonoF(data) == 2){
                    ContadorErr++;
                     return '<b style="color:red;">'+data+'</b>';
                    contador +=1;
                }else if(telefonoF(data) == 1){
                     return '<p>'+data+'</p>';   
                }
                 } 
                }
            },
            { data: lines.telefono_2, render: function(data)
                {
                 if (data == undefined || data == "") {
                    return '<p></p>';
                 }else{
                                 if (telefonoF(data) == 3) {
                                    
                        return '<b style="color:red;"></b>';
                        }else if(telefonoF(data) == 2){
                            
                             return '<b style="color:red;">'+data+'</b>';
                            contador +=1;
                        }else if(telefonoF(data) == 1){
                             return '<p>'+data+'</p>';
                            
                        }else if(telefonoF(data) == 4)
                        {
                            //ContadorErr++;
                            return '<b style="color:red;">'+data+'</b>';
                        }

                 }   

                }

             },
            { data: lines.observaciones,render:function(data) {
                if (data == "observaciones" || data == undefined) {
                    return '<p></p>';
                }else{
                    return '<p>'+data+'<p>';
                }
            }

             },
            { data: lines.lugar_prospeccion,render:function (data) {
                if (data == "lugar_prospeccion" || data == undefined) {
                    return '<p></p>';
                }else if(data == ""){
 ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>';
                   
                }else{

                    if (data == 6) {
                        return '<p>'+data+'</p>';
                    }else{
                        ContadorErr++;
                        return '<b style="color:red;">'+data+'</b>';
                    }
                }
            }

             },
            { data: lines.otro_lugar,render: function(data) {
                if (data == "") {
  ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>';
                }else{
                        if (otro_lugar(data) == 1) {
                        return '<p>'+data+'</p>';
                    }else if (otro_lugar(data) == 2) {
                        ContadorErr++;
                        return '<b style="color:red;">'+data+'</b>';
                    }else if (otro_lugar(data) == 3) {
                        return '<p></p>';
                    }
                }
            }
             },
            { data: lines.plaza_venta,render: function (data) {
                let numero = parseFloat(data);
                //console.log(parseFloat(data));
                if (data == "plaza_venta" || data == undefined) {
                    return '<p></p>';
                }else if(data == ""){
                 ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>';   
                }else if(data !== "plaza_venta" && data !== ""){
                    if (numero >= 1 && numero <= 5 && Number.isInteger(numero) == true)  {
                        return '<p>'+data+'</p>';
                    }else{
                        ContadorErr++;
                      return '<b style="color:red;">'+data+'</b>';  
                    }
                }
            }
             },
           /* { data: lines.medio_publicitario,render:function (data) {
                let numero = parseFloat(data);
                if (data == "medio_publicitario" || data == undefined) {
                    return '<p></p>';
                }else if(data == ""){
                   ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>'; 
                }else if(data !== "medio_publicitario" && data !== ""){
                     if (numero >= 1 && numero <= 10 && Number.isInteger(numero) == true) {
                    return '<p>'+data+'</p>';
                    }else{
                        ContadorErr++;
                       return '<b style="color:red;">'+data+'</b>';   
                    }
                }
            }
            },*/
            { data: lines.nacionalidad,render: function (data) {
                let numero = parseFloat(data);
                if (data == "nacionalidad" || data == undefined) {
                    return '<p></p>';
                }else if(data == ""){
                    ContadorErr++;
                    return '<b style="color:red;">REQUERIDO</b>'; 
                    
                }else if(data !== "" && data !== "nacionalidad"){
                    if (numero >= 0 && numero <= 70 && Number.isInteger(numero) == true) {
                        return '<p>'+data+'</p>';
                    }else{
                        ContadorErr++;
                       return '<b style="color:red;">'+data+'</b>';   
                    }
                }
            }

            }
        ],

    } );
} );
}
function otro_lugar(dato) 
{
            let variable = new String(dato);
            if (variable == "otro_lugar" || variable == "undefined" || variable == "") {
                return 3;
            }else 
            {
                   const opciones = ['01 800','Chat','Contacto web','Facebook','WhatsApp','Recomendado','Instagram'];
                  let resultado = opciones.includes(''+variable+'');
                 let result = opciones.indexOf(variable);
                // console.log(resultado);
                if (resultado == true) {
                    return 1;
                }else
                {
                    return 2;
                }
            }
}
function personalidad(dato) 
{
    const variable = new String(dato);
                if (isNaN(variable) == false && variable !== "personalidad_juridica") {
                            if (variable == 1 ) {
                                   personalidadV=1;
                                return 1;
                            }else if(variable == 2){
                                   personalidadV=2;
                                return 2;
                            }
                            else if(variable != 1 || variable != 2){ 
                                personalidadV = 3;
                                return 3; }

                }else{
                    return 4;
                } 
}
function validar_email2(d) 
{
        let variable = new String(d);
        if (variable == "correo" || variable == "undefined") {
            return 3;
        }else 
        {
            if ( validar_email(variable) == false) {
                return 1;
            }
            else if( validar_email(variable) == true){
                return 2;
            }
        }
    }
function validar_email( email ) 
{
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}
function telefonoF(d) 
{
    const variable = new String(d);
    if (variable.length >= 10 && variable.length <= 15 && variable.includes('e') == false) {
       return 1;     
    }else if(variable.length < 10 || variable.length > 15 && variable.includes('e') == false)
    {
        return 2;
    }
    else if(variable.length < 10 || variable.length > 15 && variable.includes('e') == true )
    {
        return 3;
    }else if(variable.length < 10 || variable.length > 15 && variable.includes('e') == false && variable !== ""){
return 4;
    }
}
// function errores() 
// {
//     var btn = document.getElementById('finish');
//         if (ContadorErr == 0) {
//             btn.disabled = false;
//         }else{
//             btn.disabled = true;
//         }  
// }