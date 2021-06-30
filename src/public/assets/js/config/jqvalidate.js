jQuery.extend(jQuery.validator.messages, {
    required: 'Este campo é obrigatório',
})

var JQValidateDefaultConfig = {
    ignore: '',
    errorPlacement: function (error, element) {
        let isSelect2 = $(element).hasClass('select2')

        if (isSelect2) {
            $(error).insertAfter($(element).next('span'))
        } else {
            $(error).insertAfter($(element))
        }
    }
}

function loadJQValidateDefaultConfig(customConfigs) {
    return {
        ...JQValidateDefaultConfig,
        ...customConfigs,
    }
}
