function esconder(id){
    // alert(1331)
    $('#muestratexto'+id).addClass('hide');
    // $('#muestratexto'+id).removeClass('hide');
    
}


function mostrar(id){
    // $('#muestratexto'+id).addClass('hide');
    $('#muestratexto'+id).removeClass('hide');
    
}





/*
ejemplo priermo tenemos que tener 2doble la data table

        { 
            data: function (d) { return '<p class="m-0">'+d.comentario+'</p>' ;}
        },
        { 
            data: function( d){         
                const letras = d.comentario.split(" ");
                if(letras.length <= 4)
                {
                    return '<p class="m-0">'+d.comentario+'</p>';
                }else{
                    
                    letras[2] = undefined ? letras[2] = '' : letras[2];
                    letras[3] = undefined ? letras[3] = '' : letras[3];
                    return `    
                        <div class="muestratexto${d.id_prestamo}" id="muestratexto${d.id_prestamo}">
                            <p class="m-0">${letras[0]} ${letras[1]} ${letras[2]} ${letras[3]}....</p> 
                            <a href='#' data-toggle="collapse" data-target="#collapseOne${d.id_prestamo}" 
                                onclick="esconder(${d.id_prestamo})" aria-expanded="true" aria-controls="collapseOne${d.id_prestamo}">
                                <span class="lbl-blueMaderas">Ver más</span> 
                                
                            </a>
                        </div>
                        <div id="collapseOne${d.id_prestamo}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                ${d.comentario}</p> 
                                <a href='#'  data-toggle="collapse" data-target="#collapseOne${d.id_prestamo}" 
                                    onclick="mostrar(${d.id_prestamo})" aria-expanded="true" aria-controls="collapseOne${d.id_pago_i}">
                                    <span class="lbl-blueMaderas">Ver menos</span> 
                                </a>
                            </div>
                        </div>
                    `;
                }
            }
        },