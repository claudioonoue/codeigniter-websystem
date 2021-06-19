jQuery.extend(jQuery.validator.messages, {
    required: 'Este campo é obrigatório',
})

var JQValidateDefaultConfig = {
    ignore: ''
}

function loadJQValidateDefaultConfig(customConfigs) {
    return {
        ...JQValidateDefaultConfig,
        ...customConfigs,
    }
}
