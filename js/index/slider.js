$(document).ready(function(){

var mygallery = new fadeSlideShow({
        wrapperid: "fadeshow", //ID of blank DIV on page to house Slideshow
        dimensions: [953, 400], //width/height of gallery in pixels. Should reflect dimensions of largest image
        imagearray: [
            //Fotos Nuevas
            ["img/Convocatoria2017.jpg", "", "", "Revista Digital"],
            ["img/Prensa.jpg", "", "", "Rueda de Prensa"],
           // ["img/FutbolAmericano2017.png", "", "", "Fútbol Americano"],
            //["img/FutbolAmericanoMujeres2017.png", "", "", "Fútbol Americano Mujeres"],
            //["img/Porristas2017.png", "", "", "Porristas"],
            //["img/taekwondo2017.png", "", "", "El arte de golpear con los pies y las manos"],
            //["img/Talento2017.png", "", "", "Innovación"],
            //["img/RespSocial.png", "", "", "Responsabilidad Social"],
            //["img/banda.png","","","Banda de Guerra"],
            //["img/basquetball.png","","","Equipo de Basketball"],
            //["img/baseball.png","","","Equipo de Baseball"],
            //["img/taekwondo.png","","","El arte de golpear con los pies y las manos"],
            //["img/futball.png","","","Equipo de Football Varonil"],
            //["img/escolta.png","","","Acción de honra a nuestro lábaro patrio"],
            //["img/bailem.png","","","Práctica de baile moderno"],
            //["img/folk.png","","","El arte de la danza en el ITSL"],
            //["img/rondalla.png","","","La formación y crecimiento músical en alumnos del ITSL"],
            //["img/ajedrez.png", "", "", "Alumnos incrementan sus habilidades intelectuales con ajedrez"],          
        ],
        displaymode: { type: 'auto', pause : 4500, cycles: 0, wraparound: false },
        persist: false, //remember last viewed slide and recall within same session?
        fadeduration: 500, //transition duration (milliseconds)
        descreveal: "always",
        togglerid: "slideshowtoggler"
    })
});