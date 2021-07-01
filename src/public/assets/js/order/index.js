$(document).ready(() => {
    loadGrid()
})

function loadData(filter) {
    var d = $.Deferred();
    $.ajax({
        url: '/api/ajax/order/list',
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
            { type: 'text', name: 'provider', title: 'Fornecedor', align: 'center' },
            { type: 'text', name: 'contributor', title: 'Colaborador', align: 'center' },
            {
                type: 'text',
                name: 'observations',
                title: 'Observações',
                itemTemplate: function (value) {
                    var text = value.length > 20 ? value.substr(0, 19) + '...' : value;
                    return text;
                }
            },
            { type: 'text', name: 'totalProducts', title: 'Total de Produtos', align: 'center', filtering: false },
            {
                type: 'select',
                name: 'finished',
                title: 'Finalizado',
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
            window.location.href = `/order/edit/${rc.item.id}`;
        }
    })
    $('#jsGrid').jsGrid(gridConfig)
}