if(typeof locale === 'undefined'){
    let locale = 'es'
}

locale = localStorage.getItem('locale');
languajeTable = general_base_url + "static/spanishLoader_v2.json";

$.i18n().load(`${general_base_url}dist/js/jquery.i18n/langs.json`)
.done(function() {
    try {
        $('body').i18n()
    }catch(err) {
        // console.log(err)
    }
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
    if(!locale){
        locale = 'es'
        
        localStorage.setItem('locale', locale)
    }

    changeIcon(locale)

    try {
        $('body').i18n()
    }catch(err) {
        // console.log(err)
    }
})

function changeIcon(lang) {
    // console.log(lang);
    $('#lang_icon').attr("src", `${general_base_url}static/images/langs/${lang}.png`);
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

    // $('body').i18n()

    triggerChangeFunctions()

    // location.reload();
}

_ = $.i18n

if(typeof load_functions === 'undefined'){
    let load_functions = []
}

if(typeof change_functions === 'undefined'){
    let change_functions = []
}

load_functions = []
change_functions = []

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
        // console.log(callback)
        
        callback()
    }
}

function triggerChangeFunctions() {
    for (let callback of change_functions) {
        callback()
    }
}

if(typeof datosTablasComisiones === 'undefined'){
    const datosTablasComisiones = []
}

datosTablasComisiones = [
    {
        idTabla : 'tabla_nuevas_comisiones',
        idText: 'myText_nuevas'
    },
    {
        idTabla : 'tabla_revision_comisiones',
        idText: 'myText_revision'
    },
    {
        idTabla : 'tabla_pagadas_comisiones',
        idText : 'myText_pagadas'
    }
];

function applySearch(table) {
    let id = table.tables().nodes().to$().attr('id')

    $(`#${id} thead tr:eq(0) th`).each(function (i) {
        $('input', this).on('keyup change', function () {
            console.log(this)

            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
                const searchTabla = datosTablasComisiones.find((idTables) => idTables.idTabla == id);

                if( searchTabla !== undefined){
                    var total = 0;
                    var index = table.rows({
                        selected: true,
                        search: 'applied'
                    }).indexes();
                    var data = table.rows(index).data();
                    $.each(data, function (i, v) {
                        console.log(v)
                        total += parseFloat(v.pago_cliente);
                    });
                    document.getElementById(`${searchTabla.idText}`).textContent = '$' + formatMoney(total);
                }
            }
        })
    })

    $(`#${id}`).on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

function construirHead(table){
    let titulos = []
    const idNoPermitidos = ['checkComisionesNuevas']

    $(`#${table} thead tr:eq(0) th`).each(function (i) {
        var id = $(this).text();
        
        titulos.push(id);
        // console.log(id)
        if(id && idNoPermitidos.indexOf(id)){
            if(id){
                title = _(id)
                $(this).html(`<input id="${table}_${i}_${id}" class="textoshead" type="text" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
                
                function translatePlaceholder(){
                    $(`#${table}_${i}_${id}`).attr('placeholder', _(id))
                    $(`#${table}_${i}_${id}`).attr('data-original-title', _(id))
                }

                onLoadTranslations(translatePlaceholder)
                onChangeTranslations(translatePlaceholder)
            }
        }else if(id == 'checkComisionesNuevas'){
            title = _(id)
            $(this).html(`<input id="all" type="checkbox" onchange="selectAll(this)" data-toggle="tooltip" data-placement="top" data-toggle="tooltip_nuevas" id="head-${id}"  data-placement="top" title="${title}"/>`);
        }
    });

    $(`#${table}`).on('draw.dt', function() {
        $('.dt-button').each(function (i) {
            let is_excel = $(this).hasClass('buttons-excel')
            let is_pdf = $(this).hasClass('buttons-pdf')
            let is_yt = $(this).hasClass('buttons-youtube')
            
            
            if(is_excel){
                $(this).attr('title', _('descargar-excel'))
                $(this).children().children().removeAttr('title')
            }

            if(is_pdf){
                $(this).attr('title', _('descargar-pdf'))
                $(this).children().children().removeAttr('title')
            }

            if(is_yt){
                $(this).attr('title', _('video-tutorial'))
                $(this).children().children().removeAttr('title')
            }
        })
        
        $('body').i18n()
    });
}

function changeButtonTooltips() {
    $('button').each(function (i) {
        let id = $(this).data('i18n-tooltip')

        // console.log(id)

        if(id){
            let title = _(id)

            if($(this).attr('title')){
                $(this).attr('title', title)
            }
            $(this).attr('data-original-title', title)
        }
    })
}

function changeSelects() {
    $('select.selectpicker').each(function (i) {
        let id = $(this).data('i18n-label')

        if(id){
            let title = _(id)

            let parent = $(this).parent()

            let button = parent.children('button')

            let div = button.children('span.filter-option')

            if(button.attr('tabindex') === undefined){
                div.html(title)
            }

            $(this).attr('title', title)

            $('option', this).each(function (x) {
                let clase = $(this).attr('class')

                if(clase === 'bs-title-option'){
                    $(this).html(title)
                }
            })
        }
    })
}

function changeInputPlaceholder() {
    $('input').each(function (i) {
        let id = $(this).data('i18n-label')

        if(id){
            let title = _(id)
            // console.log(title)

            $(this).attr('placeholder', title)
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
    
    return resultado;
}

function changeParagraphTooltips() {
    $('p').each(function (i) {
        let id = $(this).data('i18n-tooltip')

        // console.log(id)

        if(id){
            let title = _(id)

            $(this).attr('title', title)
        }
    })
}

function changeListTooltips() {
    // console.log('li')

    $('li').each(function (i) {
        let id = $(this).data('i18n-tooltip')

        // console.log(id)

        if(id){
            let title = _(id)

            $(this).attr('title', title)
            $(this).attr('data-original-title', title)
        }
    })
}

function changeSteps() {
    $('button[data-i18n-stepper]').each(function (i) {
        let id = $(this).data('i18n-stepper');

        if(id) {
            let title = _(id);
            if(id == 'anterior') {
                $("#stepperAnterior").html(title);
                $(this).attr('data-title', title);
            }
            if(id == 'siguiente') {
                $("#stepperSiguiente").html(title);
                $(this).attr('data-title', title);
            }
        }
    })
}

function changeFontIconTooltips() {

    $('i').each(function (i) {
        let id = $(this).data('i18n-tooltip')

        if(id){
            let title = _(id)

            $(this).attr('title', title)
            $(this).attr('data-original-title', title)
        }
    })
}

function changeDivTooltips() {
    $('div').each(function (i) {
        let id = $(this).data('i18n-tooltip')

        if(id){
            let title = _(id)

            if($(this).attr('title')){
                $(this).attr('title', title)
            }
            $(this).attr('data-original-title', title)
        }
    })
}

function changeTableButton() {
    $('.dt-button').each(function (i) {
        let is_excel = $(this).hasClass('buttons-excel')
        let is_pdf = $(this).hasClass('buttons-pdf')
        
        if(is_excel){
            $(this).attr('title', _('descargar-excel'))
            $(this).children().children().removeAttr('title')
        }

        if(is_pdf){
            $(this).attr('title', _('descargar-pdf'))
            $(this).children().children().removeAttr('title')
        }
    })
    
    try {
        $('body').i18n()
    }catch(err) {
        // console.log(err)
    }
}

onLoadTranslations(changeSelects)
onChangeTranslations(changeSelects)
onLoadTranslations(changeButtonTooltips)
onChangeTranslations(changeButtonTooltips)
onLoadTranslations(changeParagraphTooltips)
onChangeTranslations(changeParagraphTooltips)
onLoadTranslations(changeListTooltips)
onChangeTranslations(changeListTooltips)
onLoadTranslations(changeInputPlaceholder)
onChangeTranslations(changeInputPlaceholder)
onLoadTranslations(changeFontIconTooltips)
onChangeTranslations(changeFontIconTooltips)
onLoadTranslations(changeDivTooltips)
onChangeTranslations(changeDivTooltips)
onLoadTranslations(changeTableButton)
onChangeTranslations(changeTableButton)
