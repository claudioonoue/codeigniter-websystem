$(document).ready(() => {
    validateCheckBoxes()
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