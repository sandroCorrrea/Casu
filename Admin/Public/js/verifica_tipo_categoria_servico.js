$(document).ready(() => {

    $("#botao_salva_tipo_categoria_servico").click(() => {
        var nome        = $("input[name='nome']").val();
        var categoria   = $("select[name='categoria']").val();
        var erro        = 0;
    
        if(!nome){
            $("input[name='nome']").addClass("border border-danger");
            $(".label_nome_categoria").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='nome']").removeClass("border border-danger");
            $(".label_nome_categoria").removeClass("text-danger");
        }

        if(categoria == "selecione"){
            $("select[name='categoria']").addClass("border border-danger");
            $(".label_categoria").addClass("text-danger");
            erro = 1;
        }else{
            $("select[name='categoria']").removeClass("border border-danger");
            $(".label_categoria").removeClass("text-danger");
        }

        if(erro == 0){
            $("#formulario_servico_tipo_categoria").submit();
        }

    });

});