var verificaCheckboxMarcado = (input, idInput, label, formulario) => {

    var marcado = $(`input[name='${input}']`).is(":checked");

    if(!marcado){
        $(`#${idInput}`).addClass("text-danger border border-danger");
        $(`.${label}`).addClass("text-danger");
    }else{
        $(`#${formulario}`).submit();
    }
};