Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';

Chart.defaults.global.defaultFontColor = '#858796';

var ctx = document.getElementById("myPieChart");

// Vamo tentar mete o ajax aqui kkkkkkkkkkkkkkkkkkk
$(document).ready(() => {

  $.post("../Servicos/porcentagens_categorias.php",
    {
      tipo: 'categorias'
    }
  ).done((dadosCategorias) => {

    var categorias = JSON.parse(dadosCategorias);
    
    var arrayCategoriasNome = [];
    var arrayCategoriasQtd  = [];

    // Vamos buscar as cores que estão na view principal
    var todasCores  = $("input[name^='cor']");
    var i           = 0;
    var arrayCores  = [];

    for(i = 0; i < todasCores.length; i++){
      arrayCores.push(todasCores[i].value);
    }
    

    if (categorias) {

      categorias.forEach((cadaCategoria) => {

        arrayCategoriasNome.push(cadaCategoria.nome);

        arrayCategoriasQtd.push(cadaCategoria.quantidade);

      });

      var myPieChart = new Chart(ctx, {

        type: 'doughnut',

        data: {
          labels:
            arrayCategoriasNome
          ,
          datasets: [{
            data: arrayCategoriasQtd,
            backgroundColor: arrayCores,
            hoverBackgroundColor: arrayCores,
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
        },

        options: {
          maintainAspectRatio: false,

          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },

          legend: {
            display: false
          },

          cutoutPercentage: 80,
        },
      });
    }
  });
});



