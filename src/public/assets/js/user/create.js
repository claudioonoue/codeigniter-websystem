$(document).ready(() => {
    validateCheckBoxes()
    jqValidate()
})

function validateCheckBoxes() {
    $('#formInpIsAdmin').change(() => {
        $('#formInpHasSystemAccess').prop("checked", true);
        $('#formInpIsProvider').prop("checked", false);
    })
    $('#formInpIsProvider').change(() => {
        $('#formInpIsAdmin').prop("checked", false);
        $('#formInpHasSystemAccess').prop("checked", false);
    })
    $('#formInpHasSystemAccess').change(() => {
        $('#formInpIsProvider').prop("checked", false);
    })
}

function jqValidate() {
    var jqValidateConfig = loadJQValidateDefaultConfig()

    $('form').validate(jqValidateConfig)
}