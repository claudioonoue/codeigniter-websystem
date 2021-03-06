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
    var jqValidateConfig = loadJQValidateDefaultConfig({
        invalidHandler: function (form) {
            validateAddresses()
        },
        ignore: ''
    })

    $('form').validate(jqValidateConfig)
}

function validateAddresses() {
    var firstAddressInputs = $('#tab_1 :input').toArray()
    var secondAddressInputs = $('#tab_2 :input').toArray()

    for (const input of firstAddressInputs) {
        if ($(input).val() === '') {
            $('#tab_2').removeClass('active')
            $('#tab_link_2').removeClass('active')
            $('#tab_1').addClass('active')
            $('#tab_link_1').addClass('active')
            return false
        }
    }
    for (const input of secondAddressInputs) {
        if ($(input).val() === '') {
            $('#tab_1').removeClass('active')
            $('#tab_link_1').removeClass('active')
            $('#tab_2').addClass('active')
            $('#tab_link_2').addClass('active')
            return false
        }
    }
    return true
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