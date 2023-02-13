$(document).ready(() => {
    $("#botao_agendamento_servico").click(() => {
        var grupo       = $("select[name='grupo']").val();
        var categoria   = $("select[name='categoria']").val();
        var erro        = 0;

        if(grupo == "selecione"){
            $("select[name='grupo']").addClass("border border-danger");
            $(".label_grupos").addClass("text-danger");
            erro = 1;
        }else{
            $("select[name='grupo']").removeClass("border border-danger");
            $(".label_grupos").removeClass("text-danger");
        }

        if(categoria == "selecione"){
            $("select[name='categoria']").addClass("border border-danger");
            $(".label_categorias").addClass("text-danger");
            erro = 1;
        }else{
            $("select[name='categoria']").removeClass("border border-danger");
            $(".label_categorias").removeClass("text-danger");
        }

        if(erro == 0){
            $("#formulario_gerenciamento_servico").submit();
        }
    });
});