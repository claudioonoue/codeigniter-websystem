function viaCEP({
    inpZipCode,
    inpAddress,
    inpNumber,
    inpNeighborhood,
    inpCity,
    inpState
}) {
    $(inpZipCode).blur(() => {
        let zipCode = $(inpZipCode).val().replace(/\D/g, '')

        if (zipCode !== '') {
            var validateZipCode = /^[0-9]{8}$/

            if (validateZipCode.test(zipCode)) {
                $(inpAddress).val('...')
                $(inpNeighborhood).val('...')
                $(inpCity).val('...')

                $.getJSON('https://viacep.com.br/ws/' + zipCode + '/json/?callback=?', (data) => {
                    if (!('erro' in data)) {
                        $(inpAddress).val(data.logradouro)
                        $(inpNeighborhood).val(data.bairro)
                        $(inpCity).val(data.localidade)
                        $(inpState).val(data.uf)
                    } else {
                        $(inpAddress).val('')
                        $(inpNumber).val('')
                        $(inpNeighborhood).val('')
                        $(inpCity).val('')
                        $(inpState).val('')
                    }
                })
            } else {
                $(inpAddress).val('')
                $(inpNumber).val('')
                $(inpNeighborhood).val('')
                $(inpCity).val('')
                $(inpState).val('')
            }
        } else {
            $(inpAddress).val('')
            $(inpNumber).val('')
            $(inpNeighborhood).val('')
            $(inpCity).val('')
            $(inpState).val('')
        }
    })
}