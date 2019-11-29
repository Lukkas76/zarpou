// CALCULA NOVA ALTURA OU LARGURA DAS IMAGENS
equalheight = function(container,container_filho, altura, largura){
    var largura_img = '';
    largura_img = $(container_filho).css('width');
    //altura real da imagem
    var altura_img = '';
    altura_img = $(container_filho).css('height');

    //Altura maior que a largura
    if(parseInt(altura_img) > parseInt(largura_img)){
        var diferenca = parseInt(altura_img, 10) - parseInt(largura_img, 10);
        var novaAltura = parseInt(largura, 10) + parseInt(diferenca, 10);

        $(container_filho).css('width', largura);
        $(container_filho).css('height', novaAltura);
    }
    // Altura menor que a largura
    if(parseInt(altura_img) < parseInt(largura_img)){
        var diferenca = parseInt(largura_img, 10) - parseInt(altura_img, 10);
        var novaLargura = parseInt(altura, 10) + parseInt(diferenca, 10);

        if(parseInt(novaLargura) < parseInt(largura)){
            var diferenca = parseInt(altura_img, 10) - parseInt(largura_img, 10);
            var novaAltura = parseInt(largura, 10) + parseInt(diferenca, 10);
            $(container_filho).css('width', largura);
            $(container_filho).css('height', novaAltura);
        }
        else{
            $(container_filho).css('width', novaLargura);
            $(container_filho).css('height', altura);
        }   
    }else{
        $(container_filho).css('max-width', '100%');
    }
}


//Executa a função equalheight() quando a tela é redimensionada
$(window).resize(function(){
    var cont2 = 1;
    var largura = $('.imagem-calculo').css('width');
    var altura = $('.imagem-calculo').css('height');
    $(".imagem-calculo").each(function() {
        equalheight('.imagem-calculo-'+cont2,'.imagem-calculo_'+cont2, altura, largura);
        cont2++;
    });
});

//Executa a função equalheight() redimencionando as imagens apos 1 segundo
$(window).load(function(){
    var cont = 1;
    var largura = $('.imagem-calculo').css('width');
    var altura = $('.imagem-calculo').css('height');
    $(".imagem-calculo").each(function(index, elem) {
        setTimeout(function () {
            $(elem).animate({"opacity":"1"}, 300);
        }, index * 900);
        equalheight('.imagem-calculo-'+cont,'.imagem-calculo_'+cont, altura, largura);
        cont++;
    });
});