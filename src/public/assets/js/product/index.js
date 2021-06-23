$(document).ready(() => {
    loadGrid()
})

function loadData(filter) {
    var d = $.Deferred();
    $.ajax({
        url: '/api/ajax/product/list',
        type: 'GET',
        dataType: 'json',
        data: filter,
    }).done(function (response) {
        d.resolve(response);
    });
    return d.promise();
}

function loadGrid() {
    var gridConfig = loadJSGridDefaultConfig({
        filtering: true,
        fields: loadJSGridDefaultFields([
            { type: 'number', name: 'id', title: 'ID', align: 'center', filtering: false },
            { type: 'text', name: 'name', title: 'Nome' },
            {
                type: 'text',
                name: 'description',
                title: 'Descrição',
                itemTemplate: function (value) {
                    var text = value.length > 20 ? value.substr(0, 19) + '...' : value;
                    return text;
                }
            },
            {
                type: 'text',
                name: 'active',
                title: 'Ativo',
                align: 'center',
                filtering: false,
                itemTemplate: function (value) {
                    var iconElement = document.createElement('i');
                    iconElement.className = `icon fas fa-${value === '1' ? 'check-circle text-success' : 'times-circle text-danger'}`;
                    return iconElement;
                }
            },
        ]),
        controller: {
            loadData: loadData,
        },
        rowClick: function (rc) {
            window.location.href = `/product/edit/${rc.item.id}`;
        }
    })
    $('#jsGrid').jsGrid(gridConfig)
}