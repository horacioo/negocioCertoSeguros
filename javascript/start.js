jQuery(document).ready(function () {
  setTimeout(function () {
 
    // Cria e adiciona o primeiro script
    var script1 = document.createElement("script");
    script1.src = tema + "/javascript/slick.min.js";
    document.body.appendChild(script1);

    // Quando o primeiro script for carregado, adiciona o segundo
    script1.onload = function () {
      var script2 = document.createElement("script");
      script2.src = tema + "/javascript/slickAtibuicoes.min.js";
      document.body.appendChild(script2);

      script2.onload = function () {
        console.log("Ambos os scripts foram carregados!");
      };

      script2.onerror = function () {
        console.error("Erro ao carregar slickAtibuicoes.min.js");
      };
    };

    script1.onerror = function () {
      console.error("Erro ao carregar slick.min.js");
    };
  }, 800);
});



