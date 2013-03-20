function popUp(popup,alto,ancho){
    this.popup = $(popup);
    
    this.init = function(){
        var container = this.popup;
            //Conseguir valores de la img
        /*var img_w = $(container+" img").width() + 10;
        var img_h = $(container+" img").height() + 28;
        */
        //Darle el alto y ancho
        container.css('width', ancho + 'px');
        container.css('height', alto + 'px');

        //Esconder el popup
        //container.hide();

        //Consigue valores de la ventana del navegador
        var w = $(window).width();
        var h = $(window).height();

        //Centra el popup   
        w = (w/2) - (ancho/2);
        h = (h/2) - (alto/2);
        container.css("left",w + "px");
        container.css("top",h + "px");
        
        //container.fadeTo('slow',0.95);
    }
    this.init();
    //temporizador, para que no aparezca de golpe
    //setTimeout("mostrar("+popup+")",1000);

}