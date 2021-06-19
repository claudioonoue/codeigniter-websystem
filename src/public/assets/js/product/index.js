$(document).ready(() => {
    loadGrid()
})

function loadData(filter) {
    var d = $.Deferred();
    $.ajax({
        url: '/api/ajax/product/list',
        type: 'GET',
        dataType: 'json',
    }).done(function (response) {
        d.resolve(response);
    });
    return d.promise();
}

function loadGrid() {
    var gridConfig = loadJSGridDefaultConfig({
        fields: [
            { type: 'number', name: 'id', title: 'ID', align: 'center' },
            { type: 'text', name: 'name', title: 'Nome' },
            { type: 'text', name: 'description', title: 'Descrição' },
            {
                type: 'text',
                name: 'active',
                title: 'Ativo',
                align: 'center',
                itemTemplate: function (value) {
                    var iconElement = document.createElement('i');
                    iconElement.className = `icon fas fa-${value === '1' ? 'check-circle text-success' : 'times-circle text-danger'}`;
                    return iconElement;
                }
            },
        ],
        controller: {
            loadData: loadData,
        },
        rowClick: function (rc) {
            window.location.href = `/product/edit/${rc.item.id}`;
        }
    })
    $('#jsGrid').jsGrid(gridConfig)
}