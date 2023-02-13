$(document).ready(() => {
    $("#botao_salva_categoria_servico").click(() => {
        
        var nome    = $("input[name='nome']").val();
        var erro    = 0;

        if(!nome){
            $("input[name='nome']").addClass("border border-danger");
            $(".label_nome_categoria").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='nome']").removeClass("border border-danger");
            $(".label_nome_categoria").removeClass("text-danger");
        }

        if(erro == 0){
            
            $("#botao_salva_categoria_servico").prop("disabled", true);

            $("#botao_salva_categoria_servico")[0].textContent = "Salvando Categoria ...";

            $("#formulario_servico_categoria").submit();
        }
    });
});