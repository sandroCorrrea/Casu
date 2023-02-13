$(document).ready(() => {

    $("#valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    $(".valores_agendamento").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    $("#botao_cria_agendamento").click(() => {

        var categoria           = $("select[name='categoria_agendamento']").val();
        var horario             = $("input[name='horario']").val();
        var data_agendamento    = $("input[name='data_agendamento']").val();
        var nome_agendamento    = $("input[name='nome_agendamento']").val();
        var quantidade_vagas    = $("input[name='vagas_agendamento']").val();
        var local_atendimento   = $("textarea[name='localAtendimento']").val();
        var valor               = $("input[name='valor']").val();
        var erro = 0;

        if (categoria == "selecione") {
            $("select[name='categoria_agendamento']").addClass("border border-danger");
            $(".label__categoria").addClass("text-danger");
            erro = 1;
        } else {
            $("select[name='categoria_agendamento']").removeClass("border border-danger");
            $(".label__categoria").removeClass("text-danger");
        }

        if (!horario) {
            $("input[name='horario']").addClass("border border-danger");
            $(".label_horario").addClass("text-danger");
            erro = 1;
        } else {
            $("input[name='horario']").removeClass("border border-danger");
            $(".label_horario").removeClass("text-danger");
        }

        if (!data_agendamento) {
            $("input[name='data_agendamento']").addClass("border border-danger");
            $(".label_data_agendamento").addClass("text-danger");
            erro = 1;
        } else {
            $("input[name='data_agendamento']").removeClass("border border-danger");
            $(".label_data_agendamento").removeClass("text-danger");
        }

        if (!nome_agendamento) {
            $("input[name='nome_agendamento']").addClass("border border-danger");
            $(".nome_agendamento").addClass("text-danger");
            erro = 1;
        } else {
            $("input[name='nome_agendamento']").removeClass("border border-danger");
            $(".nome_agendamento").removeClass("text-danger");
        }

        if (!quantidade_vagas) {
            $("input[name='vagas_agendamento']").addClass("border border-danger");
            $(".label_vagas").addClass("text-danger");
            erro = 1;
        } else {
            $("input[name='vagas_agendamento']").removeClass("border border-danger");
            $(".label_vagas").removeClass("text-danger");
        }

        if (!local_atendimento) {
            $("textarea[name='localAtendimento']").addClass("border border-danger");
            $(".label_local_atendimento").addClass("text-danger");
            erro = 1;
        } else {
            $("textarea[name='localAtendimento']").removeClass("border border-danger");
            $(".label_local_atendimento").removeClass("text-danger");
        }

        if(!valor){
            $("input[name='valor']").addClass("border border-danger");
            $(".label_valor").addClass("text-danger");
            erro = 1;
        }

        if (erro == 0) {
            $("#formulario_agendamento").submit();
        }

    });
});


function apenasNumeros(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    //var regex = /^[0-9.,]+$/;
    var regex = /^[0-9.]+$/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}