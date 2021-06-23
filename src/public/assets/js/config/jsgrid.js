var JSGridDefaultConfig = {
    autoload: true,
    width: '100%',
    height: 'auto',
    paging: true,
    pageLoading: true,
    noDataContent: 'Nenhum registro encontrado',
    pageSize: 15,
    pageButtonCount: 5,
    pagerFormat: 'Página: {first} {prev} {pages} {next} {last}   {pageIndex} de {pageCount}',
    pagePrevText: '<',
    pageNextText: '>',
    pageFirstText: '<<',
    pageLastText: '>>',
    loadMessage: 'Por favor, aguarde...',
    updateOnResize: true,
}

function loadJSGridDefaultConfig(customConfigs) {
    return {
        ...JSGridDefaultConfig,
        ...customConfigs,
    }
}

function loadJSGridDefaultFields(customFields) {
    return [
        ...customFields,
        {
            type: 'control',
            editButton: false,
            deleteButton: false,
            headerTemplate: function () {
                return '';
            },
            filterTemplate: function () {
                var searchBtn = document.createElement('i');
                searchBtn.className = 'fas fa-search';
                searchBtn.style = 'cursor: pointer';

                var clearFiltersBtn = document.createElement('i');
                clearFiltersBtn.className = 'fas fa-times-circle';
                clearFiltersBtn.style = 'cursor: pointer';

                var div = document.createElement('div');
                div.appendChild(searchBtn);
                div.insertAdjacentHTML('beforeend', '&nbsp&nbsp');
                div.appendChild(clearFiltersBtn);

                $(searchBtn).click(function () {
                    $('#jsGrid').jsGrid('search');
                });

                $(clearFiltersBtn).click(function () {
                    $('#jsGrid').jsGrid('clearFilter');
                });

                return div;
            }
        }
    ]
}
