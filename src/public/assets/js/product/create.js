$(document).ready(() => {
    jqValidate()
})

function jqValidate() {
    var jqValidateConfig = loadJQValidateDefaultConfig()

    $('form').validate(jqValidateConfig)
}