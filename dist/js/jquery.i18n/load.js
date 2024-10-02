let locale = localStorage.getItem('locale')

$.i18n().load(`${general_base_url}dist/js/jquery.i18n/langs.json`)
.done(function() {
    $('body').i18n()
    //changeLanguaje()

    triggerLoadFunctions()
})

$.i18n( { 
    locale: 'es' // Locale is English 
});

// Load locale from config
if(locale){
    $.i18n().locale = locale;
}

$(document).ready(function() {
    changeIcon(locale)
})

function changeIcon(lang) {
    $('#lang_icon').attr("src", `${general_base_url}static/images/langs/${lang}.png`)
}

function changeLanguaje() {
    let locale = localStorage.getItem('locale')

    if(locale == 'en'){
        new_locale = 'es'
    }else{
        new_locale = 'en'
    }

    $.i18n().locale = new_locale
    localStorage.setItem('locale', new_locale)
    changeIcon(new_locale)

    $('body').i18n()

    triggerChangeFunctions()
}

_ = $.i18n

let load_functions = []
let change_functions = []

function onLoadTranslations(callback){
    if (typeof callback === 'function') {
        load_functions.push(callback)
    }
}

function onChangeTranslations(callback){
    if (typeof callback === 'function') {
        change_functions.push(callback)
    }
}

function triggerLoadFunctions() {
    for (let callback of load_functions) {
        callback()
    }
}

function triggerChangeFunctions() {
    for (let callback of change_functions) {
        callback()
    }
}

function construirHead(tabla){
    let titulos = []
    const idNoPermitidos = ['checkComisionesNuevas']

    $(`#${tabla} thead tr:eq(0) th`).each(function (i) {
        var id = $(this).text();
        
        titulos.push(id);
        // console.log(id)

        if(id && idNoPermitidos.indexOf(id)){
            title = _(id)
            // console.log(title)

            $(this).html(`<input class="textoshead" type="text" data-toggle="tooltip" data-placement="top" title="${title}" id="head-${id}" placeholder="${title}"/>`);
            $('input', this).on('keyup change', function () {
                if (tabla_6.column(i).search() !== this.value) {
                    tabla_6.column(i).search(this.value).draw();
                }
            });
            $('[data-toggle="tooltip"]').tooltip(); 

        }else if(id == 'checkComisionesNuevas'){
            title = _(id)
            $(this).html(`<input id="all" type="checkbox" onchange="selectAll(this)" data-toggle="tooltip" data-placement="top" data-toggle="tooltip_nuevas" id="head-${id}"  data-placement="top" title="${title}"/>`);
            $('[data-toggle="tooltip"]').tooltip(); 

        }
        

    });

    function translatePlaceholder(){
            for(titulo of titulos){
                if(titulo !== ''){
                    $(`#head-${titulo}`).attr('placeholder', _(titulo));
                    $(`#head-${titulo}`).attr('title', _(titulo));
                }
            }
        }

    onLoadTranslations(translatePlaceholder)
    onChangeTranslations(translatePlaceholder)
}

function changeButtonTooltips() {
    $('button').each(function (i) {
        let id = $(this).data('i18n-tooltip')

        // console.log(id)

        if(id){
            let title = _(id)

            $(this).attr('data-original-title', title)
        }
    })
}

function changeSelects() {
    $('select.selectpicker').each(function (i) {
        let id = $(this).data('i18n')

        if(id){
            let title = _(id)

            let parent = $(this).parent()

            let div = parent.children('button').children('span.filter-option')

            div.html(title)

            $(this).attr('title', title)
        }
    })
}

function stringToI18(str) {
    // Convertir todo el string a minúsculas
    let resultado = str.toLowerCase();
      
    // Eliminar acentos reemplazando caracteres acentuados por su equivalente sin acento
    resultado = resultado.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
      
    // Reemplazar cualquier combinación de espacios, puntos, comas, signos de interrogación, signos de admiración por un guión medio
    resultado = resultado.replace(/[\s,\.?,¿!,¡]+/g, '-');
      
    console.log(resultado);
    return resultado;
}

onLoadTranslations(changeSelects)
onChangeTranslations(changeSelects)
onLoadTranslations(changeButtonTooltips)
onChangeTranslations(changeButtonTooltips)