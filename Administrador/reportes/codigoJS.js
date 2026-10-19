var chart1, options;
$("#btnresumen").click(function () {
    $(".modal-header").css("background-color", "#343a40");
    $(".modal-header").css("color", "white");
    $("#modal-1").modal("show");

    $.ajax({
        url: "graficos.php",
        type: "Post",
        dataType: "json",
        success: function (data) {
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })

    Resumenes();
});

$("#btnresumen3").click(function () {
    $(".modal-header").css("background-color", "#343a40");
    $(".modal-header").css("color", "white");
    $("#modal-2").modal("show");

    $.ajax({
        url: "extensosgrafico.php",
        type: "Post",
        dataType: "json",
        success: function (data) {
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })

    Extensos();
});

$("#btnresumen5").click(function () {
    $(".modal-header").css("background-color", "#343a40");
    $(".modal-header").css("color", "white");
    $("#modal-3").modal("show");

    $.ajax({
        url: "articulosgraficos.php",
        type: "Post",
        dataType: "json",
        success: function (data) {
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })

    Articulos();
});

$("#btnresumen6").click(function () {
    $(".modal-header").css("background-color", "#343a40");
    $(".modal-header").css("color", "white");
    $("#modal-4").modal("show");

    $.ajax({
        url: "graficosarticulosp.php",
        type: "Post",
        dataType: "json",
        success: function (data) {
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })

    ArticulosPublicados();
});

$("#btnresumen8").click(function () {
    $(".modal-header").css("background-color", "#343a40");
    $(".modal-header").css("color", "white");
    $("#modal-5").modal("show");

    $.ajax({
        url: "graficostotal.php",
        type: "Post",
        dataType: "json",
        success: function (data) {
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })

    Total();
});

//Aqui se cambia todas las propiedades de la grafica
function Resumenes() {
    var v_modal = $("#modal-1").modal({
        show: false
    });
    options = {
        chart: {
            renderTo: "contenedor-modal",
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'PORCENTAJE DE RESUMENES'
        },
        tooltip: {
            //Formato de el nombre de las series y el formato del porcentaje
            pointFormat: '{series.name}:<b>{point.percentage:.2f}</b>%',
        },
        plotOptions: {
            pie: {
                //Se establece el formato em negritas y el formato del cursor
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}:<b>{point.percentage:.2f}</b>%'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [],
        }]
    }

    v_modal.on('shower', function () {});
    v_modal.modal('show');
};


function Extensos() {
    var v_modal = $("#modal-2").modal({
        show: false
    });
    options = {
        chart: {
            renderTo: "GraficoExtenso",
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'PORCENTAJE DE EXTENSOS'
        },
        tooltip: {
            //Formato de el nombre de las series y el formato del porcentaje
            pointFormat: '{series.name}:<b>{point.percentage:.2f}</b>%',
        },
        plotOptions: {
            pie: {
                //Se establece el formato em negritas y el formato del cursor
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}:<b>{point.percentage:.2f}</b>%'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [],
        }]
    }

    v_modal.on('shower', function () {});
    v_modal.modal('show');
};

function Articulos() {
    var v_modal = $("#modal-3").modal({
        show: false
    });
    options = {
        chart: {
            renderTo: "GraficoArticulo",
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'PORCENTAJE DE ARTICULOS'
        },
        tooltip: {
            //Formato de el nombre de las series y el formato del porcentaje
            pointFormat: '{series.name}:<b>{point.percentage:.2f}</b>%',
        },
        plotOptions: {
            pie: {
                //Se establece el formato em negritas y el formato del cursor
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}:<b>{point.percentage:.2f}</b>%'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [],
        }]
    }

    v_modal.on('shower', function () {});
    v_modal.modal('show');
};

function ArticulosPublicados() {
    var v_modal = $("#modal-4").modal({
        show: false
    });
    options = {
        chart: {
            renderTo: "GraficoArticuloPublicado",
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'PORCENTAJE DE ARTICULOS PUBLICADOS'
        },
        tooltip: {
            //Formato de el nombre de las series y el formato del porcentaje
            pointFormat: '{series.name}:<b>{point.percentage:.2f}</b>%',
        },
        plotOptions: {
            pie: {
                //Se establece el formato em negritas y el formato del cursor
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}:<b>{point.percentage:.2f}</b>%'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [],
        }]
    }

    v_modal.on('shower', function () {});
    v_modal.modal('show');
};

function Total() {
    var v_modal = $("#modal-5").modal({
        show: false
    });
    options = {
        chart: {
            renderTo: "GraficoTotal",
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'PORCENTAJE TOTAL'
        },
        tooltip: {
            //Formato de el nombre de las series y el formato del porcentaje
            pointFormat: '{series.name}:<b>{point.percentage:.2f}</b>%',
        },
        plotOptions: {
            pie: {
                //Se establece el formato em negritas y el formato del cursor
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}:<b>{point.percentage:.2f}</b>%'
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: [],
        }]
    }

    v_modal.on('shower', function () {});
    v_modal.modal('show');
};

