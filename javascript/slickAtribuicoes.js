console.log("só teste");



jQuery("#carrousselReviews").slick({
  dots: false,
  infinite: true,
  speed: 500,
  slidesToShow: 4,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  arrows: false,
   prevArrow: "#arrow1",
  nextArrow: "#arrow2",

  // Adicionando a opção 'responsive'
  responsive: [
    {
      breakpoint: 768, // Quando a tela for menor que 767px
      settings: {
        slidesToShow: 1, // Mostra 1 slide por vez
        slidesToScroll: 1, // E rola 1 slide por vez
      },
    },
  ],
});
