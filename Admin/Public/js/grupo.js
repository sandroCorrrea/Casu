$(document).ready(() => {

    $("#cpfColaborador").mask("000.000.000-00");
    $("#cepColaborador").mask("00000-000");
    $("#numeroIdentidadeColaborador").mask("00.000.000");

    // Vamos montar o seletor com todos os estados do br
    $.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome", (dados) => {
        
        var seletorUfs = `
            <label id="estadoIdentidade" class="estadosIbge">Estado Identidade</label>
            <select name="estadoIndentidade" id="estadoIdentidade" class="form-control text-primary">
                <option value="selecione" selected> -- SELECIONE -- </option>
        `;

        dados.forEach((cadaDado) => {
            seletorUfs += `<option value="${cadaDado.sigla}">${cadaDado.sigla}</option>`;
        });

        seletorUfs += `
            </select>
        `;

        $(".ufs_br").append(seletorUfs);
    });


    $("#criarGrupoFormulario").click(() => {

        var nomeGrupo   = $("input[name='nomeGrupo']").val();
        var erro        = 0;

        if(!nomeGrupo){
            $("input[name='nomeGrupo']").addClass("border border-danger");
            $(".nomeGrupoLabel").addClass("text-danger");
            erro = 1;
        }else{

            $("input[name='nomeGrupo']").removeClass("border border-danger");
            $(".nomeGrupoLabel").removeClass("text-danger");

            $("#criarGrupoFormulario").prop("disabled", true);
            
            $("#criarGrupoFormulario")[0].textContent = "Criando ...";

            $("#formularioGrupo").submit();
        }

    });

    $("#criarColaboradorFormulario").click(() => {
        
        var nomeCompleto        = $("input[name='nomeCompleto']").val(); 
        var cpf                 = $("input[name='cpfColaborador']").val();
        var email               = $("input[name='emailColaborador']").val();
        var dataNascimento      = $("input[name='dataNascimentoColaborador']").val();          
        var estadoIdentidade    = $("select[name='estadoIndentidade']").val();            
        var numeroIdentidade    = $("input[name='numeroIdentidadeColaborador']").val();     
        var cep                 = $("input[name='cepColaborador']").val();
        var grupo               = $("select[name='grupoColaborador']").val();
        var erro                = 0;

        if(!nomeCompleto){
            $("label.nomeCompletoLabel").addClass("text-danger");
            $("input[name='nomeCompleto']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.nomeCompletoLabel").removeClass("text-danger");
            $("input[name='nomeCompleto']").removeClass("border border-danger");
        }
        
        cpf                         = cpf.replace(".", "");
        cpf                         = cpf.replace("-", "");
        cpf                         = cpf.replace(".", "");
        var validaCpfColaborador    = valida_cpf(cpf);

        if(!validaCpfColaborador){
            $("label.cpfColaborador").addClass("text-danger");
            $("input[name='cpfColaborador']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.cpfColaborador").removeClass("text-danger");
            $("input[name='cpfColaborador']").removeClass("border border-danger");
        }

        var verificaEmail = email.indexOf("@");

        if(verificaEmail == -1){
            $("label.emailColaborador").addClass("text-danger");
            $("input[name='emailColaborador']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.emailColaborador").removeClass("text-danger");
            $("input[name='emailColaborador']").removeClass("border border-danger");
        }

        if(!dataNascimento){
            $("label.dataNascimentoColaborador").addClass("text-danger");
            $("input[name='dataNascimentoColaborador']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.dataNascimentoColaborador").removeClass("text-danger");
            $("input[name='dataNascimentoColaborador']").removeClass("border border-danger");
        }

        if(estadoIdentidade == "selecione"){
            $("label.estadosIbge").addClass("text-danger");
            $("select[name='estadoIndentidade']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.estadosIbge").removeClass("text-danger");
            $("select[name='estadoIndentidade']").removeClass("border border-danger");
        }

        if(!numeroIdentidade){
            $("label.numeroIdentidadeColaborador").addClass("text-danger");
            $("input[name='numeroIdentidadeColaborador']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.numeroIdentidadeColaborador").removeClass("text-danger");
            $("input[name='numeroIdentidadeColaborador']").removeClass("border border-danger");
        }

        // Vamos buscar todos os dados do endereço com cep informado
        var validaCepColaborador = valida_cep(cep);

        if(!validaCepColaborador){
            $("label.cepColaborador").addClass("text-danger");
            $("input[name='cepColaborador']").addClass("border border-danger");
            erro = 1;
        }else{
            $("label.cepColaborador").removeClass("text-danger");
            $("input[name='cepColaborador']").removeClass("border border-danger");
        }

        if(grupo == "selecione" || grupo == "grupoVazio"){
            $("label.grupoColaborador").addClass("text-danger");
            $("select[name='grupoColaborador']").addClass("border border-danger");
            erro = 1; 
        }else{
            $("label.grupoColaborador").removeClass("text-danger");
            $("select[name='grupoColaborador']").removeClass("border border-danger");
        }

        $("#criarColaboradorFormulario").prop("disabled", true);
        $("#criarColaboradorFormulario")[0].textContent = "Buscando CEP ...";

        $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, (dadosEndereco) => {
            
            var formularioEndereco = `
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

            $(".todosDadosDoEndereco").append(formularioEndereco);

            $("#criarColaboradorFormulario").removeAttr("disabled");
            $("#criarColaboradorFormulario")[0].textContent = "Criar Colaborador";

            if(erro == 0 && dadosEndereco.cep){
                $("#criarColaboradorFormulario").prop("disabled", true);
                $("#criarColaboradorFormulario")[0].textContent = "Salvando ...";
                $("#formularioColaborador").submit();
            }
        });
    });
});

$("#botaoEditarGrupo").click(() => {

    var nomeGrupoCriado = $("input[name='nomeGrupoCriado']").val();
    var erro            = 0;

    if(!nomeGrupoCriado){

        $("input[name='nomeGrupoCriado']").addClass("border border-danger");

        $("label.labelNomeGrupoCriado").addClass("text-danger");

        erro = 1;

    }else{

        $("input[name='nomeGrupoCriado']").removeClass("border border-danger");

        $("label.labelNomeGrupoCriado").removeClass("text-danger");
    }

    if(erro == 0){
        $("#formularioEditaGrupo").submit();
    }

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

var valida_cep = (cep) => {

    cep = cep.replace(/[^0-9]/gi, "");

    if (cep.length == 8) {
        return true;
    }else{
        return false;
    }
}