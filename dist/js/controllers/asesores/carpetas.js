$(document).ready(function () {
    $.post(`${general_base_url}index.php/asesor/getAllFoldersPDF`,  function(data) {
        if(data.length > 0){
            $('#navbartabs').find('#test').empty().selectpicker('refresh');
            for(var i=0; i < data.length; i++){
                var html_code = '';
                html_code += '<option value="'+data[i]['archivo']+'"> <strong>' + data[i]['nombre'] + '</strong></option>'
                $('#navbartabs').find('#test').append(html_code);
            }
            $('#navbartabs').find('#test').selectpicker('refresh');

            $('select').on('change', function() {
                $('#spiner-loader').removeClass('hide');
                var value = this.value;
                //codigo embebido del PDF
                var url_file = `${general_base_url}/static/documentos/carpetas/${value}`
                var embebed_code = `<embed src="${url_file}" frameborder="0" width="100%" height="770em">`;
                //construye los contenedores de las tabs
                var html_contenedor_tabs = '';
                html_contenedor_tabs += '	<div class="content">';
                html_contenedor_tabs += '		<div class="container-fluid">';
                html_contenedor_tabs += '			<div class="row">';
                html_contenedor_tabs += '				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                html_contenedor_tabs += '					'+embebed_code;
                html_contenedor_tabs += '				</div>';
                html_contenedor_tabs += '			</div>';
                html_contenedor_tabs += '		</div>';
                html_contenedor_tabs += '	</div>';
                $('#paneles-tabs').html(html_contenedor_tabs);
                setTimeout(function(){
                    $('#spiner-loader').addClass('hide');
                },1500);
            });
        }
        else{
            $('#msg').append('<center><h2 style="color: #a0a0a0;font-weight: 100">No hay Carpetas disponibles</h2></center>');
        }
    }, 'json');    
});
