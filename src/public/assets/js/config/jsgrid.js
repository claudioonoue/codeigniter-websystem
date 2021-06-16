var JSGridDefaultConfig = {
    autoload: true,
    width: '100%',
    height: 'auto',
    paging: true,
    pageLoading: true,
    noDataContent: 'Nenhum registro encontrado',
    pageSize: 19,
    pageButtonCount: 5,
    pagerFormat: 'Página: {first} {prev} {pages} {next} {last}    {pageIndex} de {pageCount}',
    pagePrevText: 'Voltar',
    pageNextText: 'Próx',
    pageFirstText: 'Primeira',
    pageLastText: 'Última',
    loadMessage: 'Por favor, aguarde...',
    updateOnResize: true,
}

function loadJSGridDefaultConfig($customConfigs) {
    return {
        ...JSGridDefaultConfig,
        ...$customConfigs,
    }
}
