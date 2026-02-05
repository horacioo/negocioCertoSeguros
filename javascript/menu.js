


jQuery("#hamburguer").click(function () {
  jQuery("#menu").css("display", "block");
  /******************************************/
  jQuery("#menu").addClass("LeftToRight");
  /******************************************/
  animarMenu();
  /******************************************/
  jQuery("#fundaoMenu").addClass("openFundoCSS");
  /******************************************/
});


/******************************************************************/
jQuery('#fundaoMenu').click(function(){
    jQuery("#menu").removeClass("LeftToRight");
     jQuery("#fundaoMenu").removeClass("openFundoCSS");
})
/******************************************************************/





jQuery("#fundaoMenu").click(function () {
  jQuery();
});

function animarMenu() {
  $("#MenuPrincipal li").removeClass("mostraBtn"); // limpa antes
  $("#MenuPrincipal li").each(function (index, element) {
    setTimeout(() => {
      console.log("teste");
      $(element).addClass("mostraBtn");
    }, index * 300);
  });
}

// exemplo de uso
