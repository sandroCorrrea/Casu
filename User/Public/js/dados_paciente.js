$(document).ready(() => {

    // FORMANDO SELETOR DE ESTADOS COM A API DO IBGE
    $.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados", (estados) => {

        var seletor = `
            <label for="estado_identidade" class="form-label label-estado_identidade">Estado Identidade</label>

            <select class="form-select" id="estado_identidade" name="estado_identidade">
                
                <option value="selecione"> -- SELECIONE -- </option>
        `;

        estados.forEach((cadaEstado) => {
            seletor += `<option value="${cadaEstado.sigla}">${cadaEstado.sigla}</option>`;
        });

        seletor += "</select>"

        $("#seletor_estados_ibge").append(seletor);
    });


    // MASCARAS USADAS NO FORMULÁRIO PARA O REGISTRO DO PACIENTE.
    $("#cep_paciente").mask("00000-000");
    $("#cpf").mask("000.000.000-00");
    $("#numeroIdentidade").mask("00.000.000");
    $("#celular").mask("(00)00000-0000");
    $("#telefonePaciente").mask("(00)0000-0000");


    // VALIDANDO INFORMAÇÕES DO PACIENTE
    $("#botaoCadastroPaciente").click(() => {

        var primeiroNome        = $("input[name='primeiroNomePaciente']").val();
        var sobrenome           = $("input[name='sobrenome']").val();
        var email               = $("input[name='emailPaciente']").val();
        var dataNascimento      = $("input[name='data_nascimento_paciente']").val();
        var cpf                 = $("input[name='cpf']").val();
        var numeroIdentidade    = $("input[name='numero_identidade']").val();
        var estadoIdentidade    = $("select[name='estado_identidade']").val();
        var orgaoExpeditor      = $("input[name='orgao_expeditor']").val();
        var cep                 = $("input[name='cep']").val().length;
        var erro                = 0;

        if(!primeiroNome){
            $("input[name='primeiroNomePaciente']").addClass("border border-danger");
            $(".label-nome").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='primeiroNomePaciente']").removeClass("border border-danger");
            $(".label-nome").removeClass("text-danger");
        }

        if(!sobrenome){
            $("input[name='sobrenome']").addClass("border border-danger");
            $(".label-sobrenome").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='sobrenome']").removeClass("border border-danger");
            $(".label-sobrenome").removeClass("text-danger");
        }

        var verificaEmail = email.indexOf("@");
        
        if(verificaEmail == -1){
            $("input[name='emailPaciente']").addClass("border border-danger");
            $(".label-emailPaciente").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='emailPaciente']").removeClass("border border-danger");
            $(".label-emailPaciente").removeClass("text-danger");
        }

        if($("input[name='celular_paciente']").val().length < 14){
            $("input[name='celular_paciente']").addClass("border border-danger");
            $(".label-celular_paciente").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='celular_paciente']").removeClass("border border-danger");
            $(".label-celular_paciente").removeClass("text-danger");
        }

        if(!dataNascimento){
            $("input[name='data_nascimento_paciente']").addClass("border border-danger");
            $(".label-data_nascimento_paciente").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='data_nascimento_paciente']").removeClass("border border-danger");
            $(".label-data_nascimento_paciente").removeClass("text-danger");
        }

        cpf                     = cpf.replace(".", "");
        cpf                     = cpf.replace("-", "");
        cpf                     = cpf.replace(".", "");
        var validaCpfPaciente   = valida_cpf(cpf);

        if(!validaCpfPaciente){
            $("input[name='cpf']").addClass("border border-danger");
            $(".label-cpf").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='cpf']").removeClass("border border-danger");
            $(".label-cpf").removeClass("text-danger");
        }

        if(!numeroIdentidade){
            $("input[name='numero_identidade']").addClass("border border-danger");
            $(".label-numero_identidade").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='numero_identidade']").removeClass("border border-danger");
            $(".label-numero_identidade").removeClass("text-danger");
        }

        if(erro == 0){
            $("#botaoCadastroPaciente").remove();

            var botaoCadastro = `
                <button class="w-100 btn btn-primary btn-lg" type="button" disabled="disabled"><i class='bx bx-loader-alt bx-spin bx-rotate-90 mr-2' ></i>   Salvando ...</button>
            `;
    
            $(".botao_cadastro_paciente").append(botaoCadastro);
    
            $("#formularioCadastroPaciente").submit();
        }

        if(estadoIdentidade == "selecione"){
            $("select[name='estado_identidade']").addClass("border border-danger");
            $(".label-estado_identidade").addClass("text-danger");
            erro = 1;
        }else{
            $("select[name='estado_identidade']").removeClass("border border-danger");
            $(".label-estado_identidade").removeClass("text-danger");
        }

        if(!orgaoExpeditor){
            $("input[name='orgao_expeditor']").addClass("border border-danger");
            $(".label-orgao_expeditor").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='orgao_expeditor']").removeClass("border border-danger");
            $(".label-orgao_expeditor").removeClass("text-danger");
        }

        if(cep < 9){
            $("input[name='cep']").addClass("border border-danger");
            $(".label-cep").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='cep']").removeClass("border border-danger");
            $(".label-cep").removeClass("text-danger");
        }

        var valorCep    = $("input[name='cep']").val();
        valorCep        = valorCep.replace("-", "");

        //VAMOS BUSCAR COM O CEP TODOS OS DADOS DO ENDEREÇO DA PESSOA
        $.getJSON(`https://viacep.com.br/ws/${valorCep}/json/`, (dadosEndereco) => {

            var dadosEnderecoFormulario = `
                <input type="hidden" name="logradouro" value="${dadosEndereco.logradouro}">
                <input type="hidden" name="complemento" value="${dadosEndereco.complemento}">
                <input type="hidden" name="bairro" value="${dadosEndereco.bairro}">
                <input type="hidden" name="localidade" value="${dadosEndereco.localidade}">
                <input type="hidden" name="uf" value="${dadosEndereco.uf}">
                <input type="hidden" name="ibge" value="${dadosEndereco.ibge}">
                <input type="hidden" name="gia" value="${dadosEndereco.gia}">
                <input type="hidden" name="ddd" value="${dadosEndereco.ddd}">
                <input type="hidden" name="siafi" value="${dadosEndereco.siafi}">
            `; 

            $(".dados__endereco_cep").append(dadosEnderecoFormulario);

            if(dadosEndereco.cep && erro == 0){

                $("#botaoCadastroPaciente").remove();

                var botaoCadastro = `
                    <button class="w-100 btn btn-primary btn-lg" type="button" disabled="disabled"><i class='bx bx-loader-alt bx-spin bx-rotate-90 mr-2' ></i>   Salvando ...</button>
                `;

                $(".botao_cadastro_paciente").append(botaoCadastro);

                $("#formularioCadastroPaciente").submit();
            }
        });
    });

    // VALIDADANDO DADOS LOGIN
    $("#botao_logar_paciente").click(() => {
        var login = $("input[name='login']").val();
        var senha = $("input[name='senha']").val();
        var erro  = 0;

        if(!login){
            $("input[name='login']").addClass("border border-danger");
            $(".label_login_paciente").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='login']").removeClass("border border-danger");
            $(".label_login_paciente").removeClass("text-danger");
        }

        if(!senha){
            $("input[name='senha']").addClass("border border-danger");
            $(".label_senha_paciente").addClass("text-danger");
            erro = 1;
        }else{
            $("input[name='senha']").removeClass("border border-danger");
            $(".label_senha_paciente").removeClass("text-danger");
        }

        if(erro == 0){
            $("#botao_logar_paciente").remove();
            
            var botao_login = `
                <button class="w-100 btn btn-lg btn-primary" type="button" disabled="disabled"><i class='bx bx-loader-alt bx-spin' ></i>    Entrando</button>
            `;

            $(".escopo_botao_login").append(botao_login);

            $("#formulario_login").submit();

        }

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

$("#botao_redefinir_senha").click(() => {
    var email   = $("input[name='emailSenha']").val();
    var erro    = 0;

    if(!email){
        $("input[name='emailSenha']").addClass("border border-danger text-danger");
        erro = 1;
    }else{
        $("input[name='emailSenha']").removeClass("border border-danger text-danger");
    }

    if(erro == 0){
        $("#botao_redefinir_senha").remove();

        var novoBotao = `
            <button type="button" class="btn btn-primary" disabled="disabled"><i class='bx bx-loader-alt bx-spin bx-rotate-90 mr-2' ></i>    Buscando Informações ...</button>
        `;

        $(".botao_senha").append(novoBotao);

        $("#formulario_atualiza_senha").submit();
    }
});