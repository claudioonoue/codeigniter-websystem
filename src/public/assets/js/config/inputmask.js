$(document).ready(() => {
    runInputMask()
})

function runInputMask() {
    $('.input-mask-phone').each(function (index, element) {
        $(element).inputmask({
            'mask': '(99) 99999-9999',
            'clearIncomplete': true
        })
    })
    $('.input-mask-zipcode').each(function (index, element) {
        $(element).inputmask({
            'mask': '99.999-999',
            'clearIncomplete': true
        })
    })
    $('.input-mask-currency').each(function (index, element) {
        $(element).inputmask({
            'numericInput': true,
            'alias': 'numeric',
            'rightAlign': false,
            'prefix': 'R$ ',
            'groupSeparator': '.',
            'placeholder': '0',
            'digits': 2,
            'autoGroup': true,
            'allowMinus': false,
            'clearIncomplete': true
        })
    })
    $('.input-mask-quantity').each(function (index, element) {
        $(element).inputmask('integer', {
            'rightAlign': false,
            'min': 1
        })
    })
}