$(document).ready(() => {
    
    $("#verificaDadosFormulario").click(() => {
        
        var login   = $("input[name='login']").val();
        var senha   = $("input[name='senha']").val();
        var erro    = 0;

        if(!login){
            $("input[name='login']").addClass("border border-danger");
            erro = 1;
        }else{
            $("input[name='login']").removeClass("border border-danger");
        }

        if(!senha){
            $("input[name='senha']").addClass("border border-danger");
            erro = 1;
        }else{
            $("input[name='senha']").removeClass("border border-danger");
        }

        if(erro == 0){

            var buttonLogin = `
                <button class="w-100 btn btn-lg btn-primary" type="button" disabled="disabled"><i class='bx bx-loader-alt bx-spin mr-2' ></i> Carregando ...</button>
            `;

            $("#verificaDadosFormulario").remove();

            $(".form-button__login").append(buttonLogin);

            $("#form_login").submit();
        }


    });

});