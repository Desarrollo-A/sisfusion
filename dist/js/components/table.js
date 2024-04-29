class Table{
    constructor({id, url, params={}, buttons=[], columns=[]}) {
        this.url = url
        this.params = new URLSearchParams(params).toString();

        $(`${id} thead tr:eq(0) th`).each(function (i) {
            $(this).css('text-align', 'center');
            const title = $(this).text();
            //titulos.push(title);
            
            $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($(id).DataTable().column(i).search() !== this.value) {
                    $(id).DataTable().column(i).search(this.value).draw();
                }
            });
        });

        this.table = $(id).DataTable({
            destroy: true,
            ajax: {
                url: `${general_base_url}${this.url}?${this.params}`,
                dataSrc: ""
            },
            deferLoading: true,
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: '100%',
            scrollX: true,
            ordering:false,
            pageLength: 20,
            buttons: buttons,
            language: {
                url: `${general_base_url}/static/spanishLoader_v2.json`,
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            columns: columns,
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip({
                    trigger: "hover"
                });
            },
        })
    }

    setParams(params){
        this.params = new URLSearchParams(params).toString();
    }

    reload(){
        this.table.ajax.url(`${general_base_url}${this.url}?${this.params}`)

        this.table.ajax.reload()
    }
}

class TableButton {
    constructor({id, label, icon, color, onClick}) {
        this.id = id || ''
        this.label = label || ''
        this.icon = icon || ''
        this.color = color || 'blueMaderas'
        this.onClick = onClick
    }

    get(){
        return {
            text: `<i class="fa fa-${this.icon}""></i><span class="${this.label ? 'ml-1' : ''}">${this.label}</span>`,
            action: function(data) {
                this.onClick()
            },
            attr: {
                class: `btn btn-${this.color}`,
                style: 'position: relative; float: right',
            }
        }
    }
}

class RowButton {
    constructor({id, label, icon, color, onClick, data}) {
        this.id = id || ''
        this.label = label || ''
        this.icon = icon || ''
        this.color = color || 'blueMaderas'
        this.onClick = onClick
        this.data = data
    }
    
    toString() {
        const button = $('<button />')
        .addClass(`btn-data btn-${this.color}`)
        .attr('id', this.id)
        .attr('data-toggle', 'tooltip')
        .attr('data-placement', 'top')
        .attr('title', this.label.toUpperCase())
        .append(
            $('<i />')
            .addClass('material-icons')
            .text(this.icon)
        )

        if(this.onClick){
            button.attr('onClick', `${this.onClick.name}(${JSON.stringify(this.data)})`)
        }

        return button.prop('outerHTML')
    }
}