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
            { type: 'number', name: 'id', title: 'ID', align: 'center', filtering: false },
            { type: 'number', name: 'providerId', title: 'providerID', align: 'center', filtering: false },
            { type: 'number', name: 'contributorId', title: 'contributorID', align: 'center', filtering: false },
            {
                type: 'text',
                name: 'observations',
                title: 'Observações',
                itemTemplate: function (value) {
                    var text = value.length > 20 ? value.substr(0, 19) + '...' : value;
                    return text;
                }
            },
            {
                type: 'text',
                name: 'finished',
                title: 'Finalizado',
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
            window.location.href = `/order/edit/${rc.item.id}`;
        }
    })
    $('#jsGrid').jsGrid(gridConfig)
}