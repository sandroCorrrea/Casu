$(document).ready(() => {

    $("#cpfUsuario").mask("000.000.000-00");
    $("#cepUsuario").mask("00000-000");

    $("#botaoSalvarDadosPessoais").click(() => {

        var nome            = $("input[name='nome']").val();
        var cpf             = $("input[name='cpf']").val();
        var dataNascimento  = $("input[name='dataNascimento']").val();
        var email           = $("input[name='email']").val();
        var identidade      = $("input[name='identidade']").val();
        var erro            = 0;

        if (!nome) {
            $("input[name='nome']").removeClass("bg-primary");
            $(".icon_nome_completo").removeClass("bx-check");
            $(".icon_nome_completo").addClass("bx-info-circle");
            $(".icon_nome_completo").removeClass("text-primary");
            $(".icon_nome_completo").addClass("text-danger");
            $("input[name='nome']").addClass("bg-danger");
            erro = 1;
        } else {
            $("input[name='nome']").removeClass("bg-danger");
            $("input[name='nome']").addClass("bg-primary");
            $(".icon_nome_completo").addClass("bx-check");
            $(".icon_nome_completo").removeClass("bx-info-circle");
            $(".icon_nome_completo").removeClass("text-danger");
            $(".icon_nome_completo").addClass("text-primary");
        }

        cpf = cpf.replace(".", "");
        cpf = cpf.replace("-", "");
        cpf = cpf.replace(".", "");

        var resultadoCpf = valida_cpf(cpf);
        
        if(!resultadoCpf){
            $("input[name='cpf']").removeClass("bg-primary");
            $(".icon_cpf").removeClass("bx-check");
            $(".icon_cpf").addClass("bx-info-circle");
            $(".icon_cpf").removeClass("text-primary");
            $(".icon_cpf").addClass("text-danger");
            $("input[name='cpf']").addClass("bg-danger");
            erro = 1;
        }else{
            $("input[name='cpf']").removeClass("bg-danger");
            $("input[name='cpf']").addClass("bg-primary");
            $(".icon_cpf").addClass("bx-check");
            $(".icon_cpf").removeClass("bx-info-circle");
            $(".icon_cpf").removeClass("text-danger");
            $(".icon_cpf").addClass("text-primary");
        }

        var validaEmail = email.indexOf("@");

        if(validaEmail == -1){
            $("input[name='email']").removeClass("bg-primary");
            $(".icon_email").removeClass("bx-check");
            $(".icon_email").addClass("bx-info-circle");
            $(".icon_email").removeClass("text-primary");
            $(".icon_email").addClass("text-danger");
            $("input[name='email']").addClass("bg-danger");
            erro = 1;
        }else{
            $("input[name='email']").removeClass("bg-danger");
            $("input[name='email']").addClass("bg-primary");
            $(".icon_email").addClass("bx-check");
            $(".icon_email").removeClass("bx-info-circle");
            $(".icon_email").removeClass("text-danger");
            $(".icon_email").addClass("text-primary");
        }

        if(!dataNascimento){
            $("input[name='dataNascimento']").removeClass("bg-primary");
            $(".icon_dataNascimento").removeClass("bx-check");
            $(".icon_dataNascimento").addClass("bx-info-circle");
            $(".icon_dataNascimento").removeClass("text-primary");
            $(".icon_dataNascimento").addClass("text-danger");
            $("input[name='dataNascimento']").addClass("bg-danger");
            erro = 1;
        }else{
            $("input[name='dataNascimento']").removeClass("bg-danger");
            $("input[name='dataNascimento']").addClass("bg-primary");
            $(".icon_dataNascimento").addClass("bx-check");
            $(".icon_dataNascimento").removeClass("bx-info-circle");
            $(".icon_dataNascimento").removeClass("text-danger");
            $(".icon_dataNascimento").addClass("text-primary");
        }

        if(!identidade){
            $("input[name='identidade']").removeClass("bg-primary");
            $(".icon_identidade").removeClass("bx-check");
            $(".icon_identidade").addClass("bx-info-circle");
            $(".icon_identidade").removeClass("text-primary");
            $(".icon_identidade").addClass("text-danger");
            $("input[name='identidade']").addClass("bg-danger");
            erro = 1;
        }else{
            $("input[name='identidade']").removeClass("bg-danger");
            $("input[name='identidade']").addClass("bg-primary");
            $(".icon_identidade").addClass("bx-check");
            $(".icon_identidade").removeClass("bx-info-circle");
            $(".icon_identidade").removeClass("text-danger");
            $(".icon_identidade").addClass("text-primary");
        }

        if(erro == 0){
            $("#botaoSalvarDadosPessoais").remove();

            var botaoDadosPessoais = `
                <button type="button" class="btn btn-facebook" disabled="disabled"><i class='bx bx-loader-alt bx-spin bx-rotate-90'></i> Salvando ...</button>
            `;

            $(".div_button_formulario").append(botaoDadosPessoais);

            $("#formularioSalvaDadosPessoais").submit();
        }
    });

    $("#buscaDadosCep").click(() => {

        $("#buscaDadosCep").prop("disabled", true);
        $("#buscaDadosCep")[0].textContent = "Buscando ...";

        var cep = $("input[name='cep']").val();
        cep     = cep.replace("-", "");
        
        // Vamos buscar todo os dados do cep informado
        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", (dados => {
            if(!("erro" in dados)){
                $("input[name='logradouro']").val(dados.logradouro);
                $("input[name='bairro']").val(dados.bairro);
                $("input[name='localidade']").val(dados.localidade);
                $("input[name='uf']").val(dados.uf);
                $("input[name='ibge']").val(dados.ibge);
                $("input[name='gia']").val(dados.gia);
                $("input[name='ddd']").val(dados.ddd);
                $("input[name='siafi']").val(dados.siafi);

                $("#buscaDadosCep").prop("disabled", true);
                $("#buscaDadosCep").removeAttr("disabled");
                $("#buscaDadosCep")[0].textContent = "Buscar Dados";
            }else{
                alert("Formato de CEP inválido.");
                limpa_formulário_cep();
            }
        }));
    });

    $("#botaoSalvarDadosEndereco").click(() => {

        $("#botaoSalvarDadosEndereco").prop("disabled", true);

        $("input[name='logradouro']").removeAttr("disabled");
        $("input[name='bairro']").removeAttr("disabled");
        $("input[name='localidade']").removeAttr("disabled");
        $("input[name='uf']").removeAttr("disabled");
        $("input[name='ibge']").removeAttr("disabled");
        $("input[name='gia']").removeAttr("disabled");
        $("input[name='ddd']").removeAttr("disabled");
        $("input[name='siafi']").removeAttr("disabled");

        $("#formularioEnderecoPessoa").submit();
    });

});

var valida_cpf = (cpf) => {

    var numeros, digitos, soma, i, resultado, digitos_iguais;

    digitos_iguais = 1;

    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++)
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (!digitos_iguais) {
        numeros = cpf.substring(0, 9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
            soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        numeros = cpf.substring(0, 10);
        soma = 0;
        for (i = 11; i > 1; i--)
            soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}

var limpa_formulário_cep = () => {
    // Limpa valores do formulário de cep.
    $("input[name='logradouro']").val("");
    $("input[name='bairro']").val("");
    $("input[name='localidade']").val("");
    $("input[name='uf']").val("");
    $("input[name='ibge']").val("");
    $("input[name='gia']").val("");
    $("input[name='ddd']").val("");
    $("input[name='siafi']").val("");
}