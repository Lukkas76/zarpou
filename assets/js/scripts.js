//smooth scroll
function smoothscroll(referencia){
   $(referencia).click(function (e) {
      e.preventDefault();
      var target = this.hash;
      $target = $(target);
      $('body,html').stop().animate({
         'scrollTop': $(target).offset().top - 30
      }, 2000, function () {
         window.location.hash = target;
      });
   });
}
//animação do slide na tab index
function animateSlider(blocoSlider){
   $(blocoSlider).on('shown.bs.tab', function (e) {
      var target = $(this).attr('href');
      $(target).css('left','-'+ $(window).width()+'px');
      var left = $(target).offset().left;
      $(target).css({left:left}).animate({'left':"0px"});
   })
}
// banner principal
function banner(classeBanner){
      $(classeBanner).revolution({
         startwidth:1170,
         startheight:500,
         hideThumbs:10,
         fullWidth:"on",
         fullScreen:"on",
         delay:5000,
         hideThumbs:10,
         autoHeight:"off",
         touchenabled:"on",
         onHoverStop:"off",
         navigationArrows:"none",
         dottedOverlay:"none",
      });
}
//customScrollBar (plugin)
function customScrollBar(blocoScroll){
   $(blocoScroll).mCustomScrollbar({
      axis:"x",
      mouseWheel:false,
      theme:"light-3",
      contentTouchScroll: false,
   });
}

//filtro galeria
function filtro(classeFiltro){
   $(function(){
      //MixItUp:
      $(classeFiltro).mixItUp({
         load: {
            filter: '.fachada'
         }
      });
   });
}
// fancybox
function fancybox(classeFancy){
   $(classeFancy).fancybox({
      padding : 0
   });
   if(($(window).width())<780){
      $(classeFancy).fancybox({
         margin: 30,
         padding : 0,
         maxWidth:700
      });
   }
}
// grafico donuts
function graph(classeGrafico,porcentagem){
   $.getScript('http://www.chartjs.org/assets/Chart.js',function(){
      var value = porcentagem;
      var rest = (100 - value);
      var data = [{
         value: 00,
         color:"#4e4f54"
      },
      {
         value: 00,
         color: "#fff"
      }];
      data[0]['value'] = value;
      data[1]['value'] = rest;
      var options = {
         animation:true
      };
      var c = $('#'+classeGrafico);
      var ct = c.get(0).getContext('2d');
      var ctx = document.getElementById(classeGrafico).getContext("2d");
      myNewChart = new Chart(ct).Doughnut(data, options);
   })
}
