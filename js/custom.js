var verificaCategoriaSelecionada = (codigoCategoria, nomeCategoria) => {

  //Vamos realizar uma requisição via ajax para listar todos os itens dessa categoria
  $.post( "./Admin/Servicos/lista_itens_categorias.php", 
    {   
      codigo_categoria: codigoCategoria
    } 
  ).done((itens) => {
    
    if(itens){

      var itensArray  = JSON.parse(itens);
      // Vamos montar nossa tabela para colocar dentro de um card no meio da tela
      console.log(itensArray)
      var tabela_agendamento = `
        <div class="row align-items-center">
          <div class="col-12 mx-auto card_categoria">
            <a href="./User/view/index.php" style="text-decoration:none;">
              <div class="card shadow border">
                <div class="card-body d-flex flex-column align-items-center">
                  <table class="table table-hover">

                    <thead>
                      <tr>
                        <th></th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Vagas</th>
                      </tr>
                    </thead>

                    <tbody>
      `;
      
      if(itensArray.length >= 0){
        itensArray.forEach(cadaItem => {
          if(cadaItem.vagas >= 1){
            tabela_agendamento += `
              <tr>
                <td>${cadaItem.nome}</td>
                <td>${cadaItem.data_formatada}</td>
                <td>${cadaItem.hora}</td>
                <td>${cadaItem.vagas}</td>
              </tr>
            `;
          }else{
            tabela_agendamento += `
            <tr class="text-danger">
              <td>${cadaItem.nome}</td>
              <td>${cadaItem.data_formatada}</td>
              <td>${cadaItem.hora}</td>
              <td>${cadaItem.vagas} - Limite atingido !</td>
            </tr>
            `;
          }
        });
      }else{
        tabela_agendamento += `
          <tr class="text-center">
            <td class="text-danger" colspan="4">Não possui nenhum agendamento !</td>
          </tr>
        `
      }

      tabela_agendamento += `
                  </tbody>
                </table>
              </div>
            </div>
          </a>
        </div>
      </div>
      `;

      // Vamos remover todos os cards
      $("main").remove();

      // Vamos alterar o nome da página
      $("h3")[0].firstChild.data = nomeCategoria;

      // Vamos incluir a tabela com o card com todos os dados disponíveis da consulta
      $(".tabela_itens_servico").removeClass("oculta_item");
      $(".span_voltar").removeClass("oculta_item");
      $(".tabela_itens_servico").append(tabela_agendamento);

    }else{
      return false;
    }
  });

};