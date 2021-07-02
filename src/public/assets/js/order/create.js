$(document).ready(() => {
    jqValidate()
    formProductList()
})

function jqValidate() {
    var jqValidateConfig = loadJQValidateDefaultConfig({
        submitHandler: function (form, event) {
            event.preventDefault()
            let productsSequence = []
            $('.div-products').each((index, element) => {
                let sequence = $(element).data('sequence')
                productsSequence.push(sequence)
            })
            let sequenceInput = document.createElement('input')
            $(sequenceInput).remove()
            sequenceInput.name = 'productsSequence'
            sequenceInput.value = productsSequence.join(',')
            sequenceInput.hidden = true
            $(sequenceInput).appendTo(form)
            if ($(sequenceInput).val() === '') {
                removeError()
                $(showError('É necessário ao menos 1 produto para salvar o pedido!')).insertAfter('#divProductsList')
                return
            }
            form.submit()
        }
    })

    $('form').validate(jqValidateConfig)
}

function getProducts() {
    var responseData = null
    $.ajax({
        url: '/api/ajax/product/list_all',
        async: false,
        type: 'GET',
        global: false,
        dataType: 'json',
        success: function (data) {
            responseData = data.data
        }
    })
    return responseData
}

var products = getProducts()
var totalProductsRow = 0

function formProductList() {
    $('#btnAddProduct').click(() => {
        addProduct()
        removeError()
    })
}

function addProduct() {
    totalProductsRow++

    let divRow = document.createElement('div')
    divRow.id = `divProduct-${totalProductsRow}`
    divRow.className = 'w-100 row div-products'
    divRow.dataset.sequence = totalProductsRow

    let divColSelect = document.createElement('div')
    divColSelect.className = 'col-6'
    let divColValue = document.createElement('div')
    divColValue.className = 'col'
    let divColQuantity = document.createElement('div')
    divColQuantity.className = 'col'
    let divColControl = document.createElement('div')
    divColControl.className = 'col-auto'

    divRow.appendChild(divColSelect)
    divRow.appendChild(divColValue)
    divRow.appendChild(divColQuantity)
    divRow.appendChild(divColControl)

    let productsSelect = createProductSelect(products, totalProductsRow)
    divColSelect.appendChild(productsSelect)
    let valueInput = createValueInput(totalProductsRow)
    divColValue.appendChild(valueInput)
    let quantityInput = createQuantityInput(totalProductsRow)
    divColQuantity.appendChild(quantityInput)
    let controlsDiv = createControls(totalProductsRow)
    divColControl.appendChild(controlsDiv)


    $('#divProductsList').append(divRow)
    $('.product-input').each(function (index, element) {
        $(element).rules('add', {
            required: true
        })
    })
    runInputMask()
}

function createFormGroup() {
    let divFormGroup = document.createElement('div')
    divFormGroup.className = 'form-group'
    return divFormGroup
}

function createProductSelect(options, i) {
    let divFormGroup = createFormGroup()

    let label = document.createElement('label')
    label.innerHTML = 'Produto*'
    divFormGroup.appendChild(label)

    let select = document.createElement('select')
    select.name = `inpSelectProduct-${i}`
    select.id = `inpSelectProduct-${i}`
    select.className = 'form-control select2 product-input'
    select.required = true
    select.style = 'width: 100%'

    let defaultOption = document.createElement('option')
    defaultOption.value = ''
    defaultOption.selected = true
    defaultOption.innerHTML = 'Selecione...'
    select.appendChild(defaultOption)

    options.forEach(option => {
        let productOption = document.createElement('option')
        productOption.value = option.id
        productOption.innerHTML = option.name
        select.appendChild(productOption)
    })

    divFormGroup.appendChild(select)

    $(select).select2(Select2DefaultConfig)

    return divFormGroup
}

function createValueInput(i) {
    let divFormGroup = createFormGroup()

    let label = document.createElement('label')
    label.innerHTML = 'Valor Unit.*'
    divFormGroup.appendChild(label)

    let input = document.createElement('input')
    input.name = `inpValue-${i}`
    input.id = `inpValue-${i}`
    input.type = 'text'
    input.className = 'form-control form-control-border input-mask-currency product-input'
    input.placeholder = 'Valor Unit.'
    input.required = true

    divFormGroup.appendChild(input)

    return divFormGroup
}

function createQuantityInput(i) {
    let divFormGroup = createFormGroup()

    let label = document.createElement('label')
    label.innerHTML = 'Quantidade*'
    divFormGroup.appendChild(label)

    let input = document.createElement('input')
    input.name = `inpQuantity-${i}`
    input.id = `inpQuantity-${i}`
    input.type = 'text'
    input.className = 'form-control form-control-border input-mask-quantity product-input'
    input.placeholder = 'Quantidade'
    input.required = true

    divFormGroup.appendChild(input)

    return divFormGroup
}

function createControls(i) {
    let div = document.createElement('div')
    div.className = 'w-100 h-100 d-flex align-items-center justify-content-center'

    let icon = document.createElement('i')
    icon.className = 'fas fa-trash-alt remove-btn'
    icon.style = 'font-size: 35px; cursor: pointer;'
    icon.onclick = () => {
        $(`#divProduct-${i}`).remove()
    }

    div.appendChild(icon)

    return div
}

function showError(message) {
    var errorBox = $(`
        <div id="productErrorBox" class="alert alert-danger alert-dismissible ml-2 mr-2">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
            ${message}
        </div>
    `)
    return errorBox
}

function removeError() {
    $('#productErrorBox').remove()
}