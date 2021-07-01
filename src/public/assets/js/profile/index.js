$(document).ready(() => {
    validateCheckBoxes()
    jqValidate()
    startViaCEP()
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

function startViaCEP() {
    viaCEP({
        inpZipCode: $('#formInpFirstZipCode'),
        inpAddress: $('#formInpFirstAddress'),
        inpNumber: $('#formInpFirstNumber'),
        inpNeighborhood: $('#formInpFirstNeighborhood'),
        inpCity: $('#formInpFirstCity'),
        inpState: $('#formInpFirstState'),
    })
    viaCEP({
        inpZipCode: $('#formInpSecondZipCode'),
        inpAddress: $('#formInpSecondAddress'),
        inpNumber: $('#formInpSecondNumber'),
        inpNeighborhood: $('#formInpSecondNeighborhood'),
        inpCity: $('#formInpSecondCity'),
        inpState: $('#formInpSecondState'),
    })
}