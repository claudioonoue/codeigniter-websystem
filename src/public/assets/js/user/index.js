$(document).ready(() => {
    loadGrid()
})

function loadData(filter) {
    var d = $.Deferred();
    $.ajax({
        url: '/api/ajax/user/list',
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
            { type: 'text', name: 'fullName', title: 'Nome' },
            { type: 'text', name: 'email', title: 'Email' },
            {
                type: 'text',
                name: 'isAdmin',
                title: 'Admin',
                align: 'center',
                itemTemplate: function (value) {
                    var iconElement = document.createElement('i');
                    iconElement.className = `icon fas fa-${value === '1' ? 'check-circle text-success' : 'times-circle text-danger'}`;
                    return iconElement;
                }
            },
            {
                type: 'text',
                name: 'hasSystemAccess',
                title: 'Acesso ao sistema',
                align: 'center',
                itemTemplate: function (value) {
                    var iconElement = document.createElement('i');
                    iconElement.className = `icon fas fa-${value === '1' ? 'check-circle text-success' : 'times-circle text-danger'}`;
                    return iconElement;
                }
            },
            {
                type: 'text',
                name: 'isProvider',
                title: 'Fornecedor',
                align: 'center',
                itemTemplate: function (value) {
                    var iconElement = document.createElement('i');
                    iconElement.className = `icon fas fa-${value === '1' ? 'check-circle text-success' : 'times-circle text-danger'}`;
                    return iconElement;
                }
            },
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
            {
                type: 'text',
                name: 'totalAddresses',
                title: 'Cadastro completo',
                align: 'center',
                itemTemplate: function (value, item) {
                    var totalNeededAddresses = item.isProvider === '1' ? 2 : item.isAdmin === '0' ? 1 : 0;
                    var iconElement = document.createElement('i');
                    iconElement.className = `icon fas fa-${parseInt(value) >= totalNeededAddresses ? 'check-double text-success' : 'exclamation-triangle text-warning'}`;
                    return iconElement;
                }
            },
        ],
        controller: {
            loadData: loadData,
        },
        rowClick: function(rc) {
            window.location.href = `/user/edit/${rc.item.id}`;
        }
    })
    $('#jsGrid').jsGrid(gridConfig)
}