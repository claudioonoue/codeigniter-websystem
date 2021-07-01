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
            { type: 'number', name: 'id', title: 'ID', align: 'center', filtering: false, visible: false },
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
                type: 'select',
                name: 'active',
                title: 'Ativo',
                align: 'center',
                items: [
                    { Name: 'Selecione', Id: -1 },
                    { Name: 'Não', Id: '0' },
                    { Name: 'Sim', Id: '1' }
                ],
                selectedIndex: -1,
                textField: 'Name',
                valueField: 'Id',
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